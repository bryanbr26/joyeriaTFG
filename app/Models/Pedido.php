<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $table = 'PEDIDO';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'estado', 'total', 'id_usuario', 'id_direcciones_envio', 'id_metodos_pago'
    ];

    // Relaciones
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }

    public function direccionEnvio()
    {
        return $this->belongsTo(DireccionEnvio::class, 'id_direcciones_envio');
    }

    public function metodoPago()
    {
        return $this->belongsTo(MetodoPago::class, 'id_metodos_pago');
    }

    public function detalles()
    {
        return $this->hasMany(DetallePedido::class, 'id_pedido');
    }

    public function pagoRedsys()
    {
        return $this->hasOne(PagoRedsys::class, 'id_pedido');
    }
}