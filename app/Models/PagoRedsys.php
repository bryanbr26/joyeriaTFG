<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo PagoRedsys - Registra los pagos procesados a través de la pasarela Redsys.
 *
 * Almacena el resultado de las transacciones bancarias incluyendo importe,
 * código de autorización, estado y la respuesta completa en JSON.
 *
 * @property int $id Identificador único del pago
 * @property float $importe Importe cobrado
 * @property string|null $codigo_autorizacion Código de autorización bancaria
 * @property string $estado Estado de la transacción
 * @property array|null $respuesta_json Respuesta completa de Redsys decodificada
 * @property int $id_pedido Pedido asociado al pago
 * @property string|null $numero_pedido_redsys Número de pedido en Redsys
 *
 * @property-read \App\Models\Pedido $pedido
 */
class PagoRedsys extends Model
{
    use HasFactory;

    /** @var string Nombre de la tabla en la base de datos */
    protected $table = 'PAGOS_REDSYS';

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
        'importe',
        'codigo_autorizacion',
        'estado',
        'respuesta_json',
        'id_pedido',
        'numero_pedido_redsys',
    ];

    /**
     * Conversiones de tipos para los atributos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'respuesta_json' => 'array'
    ];

    /**
     * Relación: un pago Redsys pertenece a un pedido.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pedido()
    {
        return $this->belongsTo(Pedido::class, 'id_pedido');
    }
}
