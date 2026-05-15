<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo Pedido - Representa una orden de compra realizada por un usuario.
 *
 * Gestiona el ciclo de vida de un pedido desde su creación hasta su entrega,
 * incluyendo estado, total, dirección de envío, método de pago y detalles.
 *
 * @property int $id Identificador único del pedido
 * @property string $estado Estado del pedido (pendiente|procesando|enviado|entregado|cancelado)
 * @property float $total Importe total del pedido
 * @property int $id_usuario Usuario que realizó el pedido
 * @property int $id_direcciones_envio Dirección de envío asociada
 * @property int $id_metodos_pago Método de pago utilizado
 *
 * @property-read \App\Models\User $usuario
 * @property-read \App\Models\DireccionEnvio $direccionEnvio
 * @property-read \App\Models\MetodoPago $metodoPago
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\DetallePedido[] $detalles
 * @property-read \App\Models\PagoRedsys|null $pagoRedsys
 */
class Pedido extends Model
{
    use HasFactory;

    /** @var string Nombre de la tabla en la base de datos */
    protected $table = 'PEDIDO';

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
        'estado', 'total', 'id_usuario', 'id_direcciones_envio', 'id_metodos_pago'
    ];

    /*
    |--------------------------------------------------------------------------
    | Relaciones
    |--------------------------------------------------------------------------
    */

    /**
     * Relación: un pedido pertenece a un usuario.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    /**
     * Relación: un pedido tiene una dirección de envío.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function direccionEnvio()
    {
        return $this->belongsTo(DireccionEnvio::class, 'id_direcciones_envio');
    }

    /**
     * Relación: un pedido utiliza un método de pago.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function metodoPago()
    {
        return $this->belongsTo(MetodoPago::class, 'id_metodos_pago');
    }

    /**
     * Relación: un pedido tiene muchos detalles de productos.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function detalles()
    {
        return $this->hasMany(DetallePedido::class, 'id_pedido');
    }

    /**
     * Relación: un pedido puede tener un pago Redsys asociado.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function pagoRedsys()
    {
        return $this->hasOne(PagoRedsys::class, 'id_pedido');
    }
}
