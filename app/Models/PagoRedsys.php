<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PagoRedsys extends Model
{
    use HasFactory;

    protected $table = 'PAGOS_REDSYS';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'importe', 'codigo_autorizacion', 'estado', 'respuesta_json', 'id_pedido'
    ];

    protected $casts = [
        'respuesta_json' => 'array'
    ];

    public function pedido()
    {
        return $this->belongsTo(Pedido::class, 'id_pedido');
    }
}