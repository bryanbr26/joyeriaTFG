<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo Producto - Representa un artículo de joyería en el catálogo.
 *
 * Gestiona la información de productos como collares, anillos, pulseras
 * y pendientes, incluyendo imágenes, precios, stock y categorías.
 *
 * @property int $id Identificador único del producto
 * @property string $categoria Categoría del producto (collar|anillo|pulsera|pendiente)
 * @property string $nombre Nombre del producto
 * @property string|null $marca Marca del producto
 * @property string|null $descripcion Descripción detallada
 * @property float $precio Precio de venta
 * @property string|null $genero Género dirigido (hombre|mujer|unisex)
 * @property string|null $color Color principal
 * @property string|null $talla Talla disponible
 * @property string|null $ruta_grabado Ruta del archivo de grabado personalizado en S3
 * @property string|null $material Material de fabricación
 * @property float|null $peso Peso en gramos
 * @property int $stock Cantidad disponible en inventario
 * @property int|null $id_detalles_pedido Relación con detalle de pedido
 * @property \Carbon\Carbon|null $fecha_agregado Fecha de alta en el catálogo
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ImagenProducto[] $imagenes
 * @property-read \App\Models\ImagenProducto|null $imagenPrincipal
 * @property-read string|null $imagen_principal_url URL de la imagen principal (accessor)
 * @property-read string $imagen_optimizada URL de imagen optimizada (accessor)
 * @property-read string $placeholder URL del placeholder borroso (accessor)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\DetallePedido[] $detallesVentas
 */
class Producto extends Model
{
    use HasFactory;

    /** @var string Nombre de la tabla en la base de datos */
    protected $table = 'PRODUCTO';

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
        'categoria',
        'nombre',
        'marca',
        'descripcion',
        'precio',
        'genero',
        'color',
        'talla',
        'ruta_grabado',
        'material',
        'peso',
        'stock',
        'id_detalles_pedido',
        'fecha_agregado',
    ];

    /**
     * Conversiones de tipos para los atributos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'precio' => 'decimal:2',
        'peso' => 'decimal:2',
        'fecha_agregado' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relaciones
    |--------------------------------------------------------------------------
    */

    /**
     * Relación: un producto pertenece a un detalle de pedido.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function detallePedido()
    {
        return $this->belongsTo(DetallePedido::class, 'id_detalles_pedido');
    }

    /**
     * Relación: un producto aparece en muchos detalles de venta.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function detallesVentas()
    {
        return $this->hasMany(DetallePedido::class, 'id_producto');
    }

    /**
     * Relación: un producto tiene muchas imágenes asociadas.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function imagenes()
    {
        return $this->hasMany(ImagenProducto::class, 'id_producto');
    }

    /**
     * Relación: un producto tiene una imagen principal marcada.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function imagenPrincipal()
    {
        return $this->hasOne(ImagenProducto::class, 'id_producto')->where('principal', true);
    }

    /**
     * Accessor para obtener la URL de la imagen principal.
     *
     * Busca primero la imagen marcada como principal, luego la primera disponible,
     * y finalmente la ruta de grabado si existe. Devuelve null si no hay ninguna.
     *
     * @return string|null URL completa de la imagen o null
     */
    public function getImagenPrincipalUrlAttribute()
    {
        $imagen = $this->relationLoaded('imagenes')
            ? $this->imagenes->firstWhere('principal', true) ?? $this->imagenes->first()
            : $this->imagenPrincipal()->first();

        if ($imagen) {
            return $imagen->url_completa;
        }

        if ($this->ruta_grabado) {
            if (env('AWS_IMAGES_PRIVATE', true)) {
                return \Illuminate\Support\Facades\Storage::disk('s3')->temporaryUrl($this->ruta_grabado, now()->addHours(6));
            }

            return \Illuminate\Support\Facades\Storage::disk('s3')->url($this->ruta_grabado);
        }

        return null;
    }

    /**
     * SVG placeholder por defecto cuando no hay imagen disponible.
     *
     * @return string Data URI del SVG placeholder
     */
    protected function placeholderSvg(): string
    {
        return 'data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22%3E%3Crect fill=%22%23f0f0f0%22 width=%22100%22 height=%22100%22/%3E%3Ctext fill=%22%23999%22 font-family=%22sans-serif%22 font-size=%2214%22 dy=%22.3em%22 text-anchor=%22middle%22 x=%2250%22 y=%2250%22%3EImagen%3C/text%3E%3C/svg%3E';
    }

    /**
     * Genera la URL de la imagen optimizada al tamaño solicitado.
     *
     * @param string $tamaño Tamaño deseado: thumbnail|small|medium|large
     * @return string URL de la imagen o placeholder
     */
    public function imagenUrl(string $tamaño = 'medium'): string
    {
        return $this->imagen_principal_url ?? $this->placeholderSvg();
    }

    /**
     * Accessor para obtener la URL de la imagen optimizada por defecto.
     *
     * @return string URL de la imagen o placeholder
     */
    public function getImagenOptimizadaAttribute(): string
    {
        return $this->imagen_principal_url ?? $this->placeholderSvg();
    }

    /**
     * Accessor para obtener la URL del placeholder borroso (LQIP).
     *
     * @return string URL del placeholder
     */
    public function getPlaceholderAttribute(): string
    {
        return $this->imagen_principal_url ?? $this->placeholderSvg();
    }

    /**
     * Obtiene los productos de la categoría "collar" paginados.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function mostrarCollares()
    {
        return self::where('categoria', 'collar')->paginate(2);
    }

    /**
     * Obtiene los productos de la categoría "anillo" paginados.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function mostrarAnillos()
    {
        return self::where('categoria', 'anillo')->paginate(2);
    }

    /**
     * Obtiene los productos de la categoría "pulsera" paginados.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function mostrarPulseras()
    {
        return self::where('categoria', 'pulsera')->paginate(2);
    }

    /**
     * Obtiene los productos de la categoría "pendiente" paginados.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function mostrarPendientes()
    {
        return self::where('categoria', 'pendiente')->paginate(2);
    }

    /**
     * Obtiene todos los productos del catálogo paginados.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function mostrarTodos()
    {
        return self::paginate(2);
    }
}
