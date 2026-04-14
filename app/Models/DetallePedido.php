<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetallePedido extends Model
{
    use HasFactory;

    protected $table = 'DETALLES_PEDIDO';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'cantidad', 'precio_unitario', 'id_pedido', 'id_producto'
    ];

    public function pedido()
    {
        return $this->belongsTo(Pedido::class, 'id_pedido');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto');
    }
}