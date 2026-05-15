<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo DireccionEnvio - Representa una dirección postal de envío de un usuario.
 *
 * Almacena los datos necesarios para la entrega de pedidos: dirección, ciudad,
 * provincia, código postal y país.
 *
 * @property int $id Identificador único de la dirección
 * @property string $direccion Calle y número
 * @property string $ciudad Ciudad de destino
 * @property string $provincia Provincia o estado
 * @property string $codigo_postal Código postal
 * @property string $pais País de destino
 * @property int $id_usuario Usuario propietario de la dirección
 *
 * @property-read \App\Models\User $usuario
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Pedido[] $pedidos
 */
class DireccionEnvio extends Model
{
    use HasFactory;

    /** @var string Nombre de la tabla en la base de datos */
    protected $table = 'DIRECCIONES_ENVIO';

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
        'direccion', 'ciudad', 'provincia', 'codigo_postal', 'pais', 'id_usuario'
    ];

    /**
     * Relación: una dirección pertenece a un usuario.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    /**
     * Relación: una dirección puede estar asociada a muchos pedidos.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pedidos()
    {
        return $this->hasMany(Pedido::class, 'id_direcciones_envio');
    }
}
