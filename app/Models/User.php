<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Modelo User - Representa a un usuario del sistema de joyería.
 *
 * Gestiona la autenticación, roles y relaciones con direcciones,
 * pedidos, carrito, favoritos y logs de actividad.
 *
 * @property int $id Identificador único del usuario
 * @property string $nombre Nombre del usuario
 * @property string $apellidos Apellidos del usuario
 * @property string $email Correo electrónico único
 * @property string $password Contraseña hasheada
 * @property string|null $telefono Teléfono de contacto
 * @property string $rol Rol del usuario (usuario|admin)
 * @property \Carbon\Carbon|null $email_verified_at Fecha de verificación del email
 * @property string|null $remember_token Token de "recordarme"
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\DireccionEnvio[] $direcciones
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Pedido[] $pedidos
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Carrito[] $carritos
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Favorito[] $favoritos
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\LogUsuario[] $logs
 */
class User extends Authenticatable
{
    use Notifiable;

    /** @var string Nombre de la tabla en la base de datos */
    protected $table = 'USUARIO';

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
        'nombre', 'apellidos', 'email', 'password', 'telefono', 'rol'
    ];

    /**
     * Atributos que deben ocultarse en las serializaciones.
     *
     * @var array<string>
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Conversiones de tipos para los atributos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Relación: un usuario tiene muchas direcciones de envío.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function direcciones()
    {
        return $this->hasMany(DireccionEnvio::class, 'id_usuario');
    }

    /**
     * Relación: un usuario tiene muchos pedidos.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pedidos()
    {
        return $this->hasMany(Pedido::class, 'id_usuario');
    }

    /**
     * Relación: un usuario tiene muchos elementos en el carrito.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function carritos()
    {
        return $this->hasMany(Carrito::class, 'id_usuario');
    }

    /**
     * Relación: un usuario tiene muchos favoritos.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function favoritos()
    {
        return $this->hasMany(Favorito::class, 'id_usuario');
    }

    /**
     * Relación: un usuario tiene muchos logs de actividad.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function logs()
    {
        return $this->hasMany(LogUsuario::class, 'id_usuario');
    }
}
