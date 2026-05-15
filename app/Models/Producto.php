<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'PRODUCTO';
    protected $primaryKey = 'id';
    public $timestamps = false;

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

    public function detallePedido()
    {
        return $this->belongsTo(DetallePedido::class, 'id_detalles_pedido');
    }

    public function imagenes()
    {
        return $this->hasMany(ImagenProducto::class, 'id_producto');
    }

    public function imagenPrincipal()
    {
        return $this->hasOne(ImagenProducto::class, 'id_producto')->where('principal', true);
    }

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
     * SVG placeholder por defecto cuando no hay imagen.
     */
    protected function placeholderSvg(): string
    {
        return 'data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22%3E%3Crect fill=%22%23f0f0f0%22 width=%22100%22 height=%22100%22/%3E%3Ctext fill=%22%23999%22 font-family=%22sans-serif%22 font-size=%2214%22 dy=%22.3em%22 text-anchor=%22middle%22 x=%2250%22 y=%2250%22%3EImagen%3C/text%3E%3C/svg%3E';
    }

    /**
     * Genera la URL de la imagen optimizada al tamaño solicitado.
     *
     * @param string $tamaño thumbnail|small|medium|large
     */
    public function imagenUrl(string $tamaño = 'medium'): string
    {
        return $this->imagen_principal_url ?? $this->placeholderSvg();
    }

    /**
     * Accessor para obtener la URL de la imagen optimizada por defecto.
     */
    public function getImagenOptimizadaAttribute(): string
    {
        return $this->imagen_principal_url ?? $this->placeholderSvg();
    }

    /**
     * Accessor para obtener la URL del placeholder borroso (LQIP).
     */
    public function getPlaceholderAttribute(): string
    {
        return $this->imagen_principal_url ?? $this->placeholderSvg();
    }

    //Muestra todos los collares
    public static function mostrarCollares()
    {
        return self::where('categoria', 'collar')->paginate(2);
    }
    //Muestra todos los anillos
    public static function mostrarAnillos()
    {
        return self::where('categoria', 'anillo')->paginate(2);
    }
    //Muestra todas las pulseras
    public static function mostrarPulseras()
    {
        return self::where('categoria', 'pulsera')->paginate(2);
    }
    //Muestra todos los pendientes
    public static function mostrarPendientes()
    {
        return self::where('categoria', 'pendiente')->paginate(2);
    }
    //Muestra todos los productos
    public static function mostrarTodos()
    {
        return self::paginate(2);
    }
}
