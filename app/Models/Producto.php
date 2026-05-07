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
            return asset('storage/' . $this->ruta_grabado);
        }

        return null;
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
