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

    //Muestra todos los collares
    public static function mostrarCollares()
    {
        return self::where('categoria', 'collar')->get();
    }
    //Muestra todos los anillos
    public static function mostrarAnillos()
    {
        return self::where('categoria', 'anillo')->get();
    }
    //Muestra todas las pulseras
    public static function mostrarPulseras()
    {
        return self::where('categoria', 'pulsera')->get();
    }
    //Muestra todos los pendientes
    public static function mostrarPendientes()
    {
        return self::where('categoria', 'pendiente')->get();
    }
    //Muestra todos los productos
    public static function mostrarTodos()
    {
        return self::all();
    }
}
