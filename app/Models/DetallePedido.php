<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo DetallePedido - Representa una línea de detalle dentro de un pedido.
 *
 * Cada registro especifica un producto concreto, su cantidad, precio unitario
 * y opcionalmente una ruta de grabado personalizado para ese artículo.
 *
 * @property int $id Identificador único del detalle
 * @property int $cantidad Cantidad de unidades compradas
 * @property float $precio_unitario Precio por unidad en el momento de la compra
 * @property int $id_pedido Pedido al que pertenece
 * @property int $id_producto Producto comprado
 * @property string|null $ruta_grabado_personalizado Ruta en S3 del grabado personalizado
 *
 * @property-read \App\Models\Pedido $pedido
 * @property-read \App\Models\Producto $producto
 */
class DetallePedido extends Model
{
    use HasFactory;

    /** @var string Nombre de la tabla en la base de datos */
    protected $table = 'DETALLES_PEDIDO';

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
        'cantidad', 'precio_unitario', 'id_pedido', 'id_producto', 'ruta_grabado_personalizado'
    ];

    /**
     * Relación: un detalle pertenece a un pedido.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pedido()
    {
        return $this->belongsTo(Pedido::class, 'id_pedido');
    }

    /**
     * Relación: un detalle hace referencia a un producto.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto');
    }
}
