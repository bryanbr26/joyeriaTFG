<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DireccionEnvio extends Model
{
    use HasFactory;

    protected $table = 'DIRECCIONES_ENVIO';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'direccion', 'ciudad', 'provincia', 'codigo_postal', 'pais', 'id_usuario'
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }

    public function pedidos()
    {
        return $this->hasMany(Pedido::class, 'id_direcciones_envio');
    }
}