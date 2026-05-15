<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * Modelo ImagenProducto - Representa una imagen asociada a un producto.
 *
 * Gestiona las URLs de imágenes almacenadas en S3, distinguiendo entre
 * imágenes públicas y privadas mediante URLs temporales.
 *
 * @property int $id Identificador único de la imagen
 * @property string $url Ruta o URL de la imagen en S3
 * @property bool $principal Indica si es la imagen principal del producto
 * @property int $id_producto Producto al que pertenece
 *
 * @property-read \App\Models\Producto $producto
 * @property-read string $url_completa URL completa resuelta para mostrar la imagen (accessor)
 */
class ImagenProducto extends Model
{
    use HasFactory;

    /** @var string Nombre de la tabla en la base de datos */
    protected $table = 'IMAGENES_PRODUCTO';

    /** @var string Clave primaria de la tabla */
    protected $primaryKey = 'id';

    /** @var bool Desactiva los timestamps automáticos de Laravel */
    public $timestamps = false;

    /**
     * Atributos que se pueden asignar masivamente.
     *
     * @var array<string>
     */
    protected $fillable = [
        'url', 'principal', 'id_producto'
    ];

    /**
     * Relación: una imagen pertenece a un producto.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto');
    }

    /**
     * Accessor para obtener la URL completa de la imagen.
     *
     * Si la URL ya es absoluta (http/https) la devuelve tal cual.
     * Si las imágenes están configuradas como privadas genera una URL temporal de S3;
     * de lo contrario devuelve la URL pública de S3.
     *
     * @return string URL completa de la imagen
     */
    public function getUrlCompletaAttribute()
    {
        if (preg_match('/^https?:\/\//', $this->url)) {
            return $this->url;
        }

        if (env('AWS_IMAGES_PRIVATE', true)) {
            return Storage::disk('s3')->temporaryUrl($this->url, now()->addHours(6));
        }

        return Storage::disk('s3')->url($this->url);
    }
}
