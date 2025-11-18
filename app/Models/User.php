<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'USUARIO';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'nombre', 'apellidos', 'email', 'password', 'telefono', 'activo'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Relaciones
    public function direcciones()
    {
        return $this->hasMany(DireccionEnvio::class, 'id_usuario');
    }

    public function pedidos()
    {
        return $this->hasMany(Pedido::class, 'id_usuario');
    }

    public function carritos()
    {
        return $this->hasMany(Carrito::class, 'id_usuario');
    }

    public function favoritos()
    {
        return $this->hasMany(Favorito::class, 'id_usuario');
    }

    public function logs()
    {
        return $this->hasMany(LogUsuario::class, 'id_usuario');
    }
}