<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo Carrito - Representa un elemento en el carrito de compras de un usuario.
 *
 * Cada registro indica la cantidad de un producto específico que el usuario
 * desea adquirir, incluyendo opcionalmente una ruta de grabado personalizado.
 *
 * @property int $id Identificador único del elemento del carrito
 * @property int $cantidad Cantidad de unidades del producto
 * @property int $id_usuario Usuario propietario del carrito
 * @property int $id_producto Producto agregado al carrito
 * @property string|null $ruta_grabado_personalizado Ruta en S3 del grabado personalizado
 *
 * @property-read \App\Models\User $usuario
 * @property-read \App\Models\Producto $producto
 */
class Carrito extends Model
{
    use HasFactory;

    /** @var string Nombre de la tabla en la base de datos */
    protected $table = 'CARRITO';

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
        'cantidad', 'id_usuario', 'id_producto', 'ruta_grabado_personalizado'
    ];

    /**
     * Relación: un elemento del carrito pertenece a un usuario.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    /**
     * Relación: un elemento del carrito contiene un producto.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto');
    }
}
