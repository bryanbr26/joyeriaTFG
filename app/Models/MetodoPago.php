<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo MetodoPago - Representa un método de pago disponible en la tienda.
 *
 * Define los medios de pago que los usuarios pueden seleccionar al realizar
 * un pedido, como tarjeta de crédito, transferencia, etc.
 *
 * @property int $id Identificador único del método de pago
 * @property string $nombre Nombre del método (ej. Tarjeta, Transferencia)
 * @property string|null $descripcion Información adicional del método
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Pedido[] $pedidos
 */
class MetodoPago extends Model
{
    use HasFactory;

    /** @var string Nombre de la tabla en la base de datos */
    protected $table = 'METODOS_PAGO';

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
        'nombre', 'descripcion'
    ];

    /**
     * Relación: un método de pago puede estar en muchos pedidos.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pedidos()
    {
        return $this->hasMany(Pedido::class, 'id_metodos_pago');
    }
}
