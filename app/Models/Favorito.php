<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo Favorito - Representa un producto marcado como favorito por un usuario.
 *
 * Permite a los usuarios guardar productos de interés para acceder a ellos
 * posteriormente sin necesidad de buscarlos de nuevo.
 *
 * @property int $id Identificador único del favorito
 * @property int $id_usuario Usuario que marcó el favorito
 * @property int $id_producto Producto marcado como favorito
 *
 * @property-read \App\Models\User $usuario
 * @property-read \App\Models\Producto $producto
 */
class Favorito extends Model
{
    use HasFactory;

    /** @var string Nombre de la tabla en la base de datos */
    protected $table = 'FAVORITOS';

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
        'id_usuario', 'id_producto'
    ];

    /**
     * Relación: un favorito pertenece a un usuario.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    /**
     * Relación: un favorito hace referencia a un producto.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto');
    }
}
