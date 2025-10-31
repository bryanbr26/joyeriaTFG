<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogUsuario extends Model
{
    use HasFactory;

    protected $table = 'LOGS_USUARIOS';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'accion', 'id_usuario'
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }
}