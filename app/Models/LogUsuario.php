<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo LogUsuario - Registra acciones importantes realizadas por los usuarios.
 *
 * Permite auditar eventos como inicios de sesión, modificaciones de datos
 * u otras acciones relevantes dentro del sistema.
 *
 * @property int $id Identificador único del log
 * @property string $accion Descripción de la acción realizada
 * @property int $id_usuario Usuario que realizó la acción
 *
 * @property-read \App\Models\User $usuario
 */
class LogUsuario extends Model
{
    use HasFactory;

    /** @var string Nombre de la tabla en la base de datos */
    protected $table = 'LOGS_USUARIOS';

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
        'accion', 'id_usuario'
    ];

    /**
     * Relación: un log pertenece a un usuario.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }
}
