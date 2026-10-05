<?php

namespace App\Http\Controllers;

use App\Models\DetallePedido;
use App\Models\Producto;

/**
 * RegalosController - Muestra la sección de ideas de regalo.
 */
class RegalosController extends Controller
{
    /**
     * Muestra la página de sugerencias de regalos.
     *
     * Incluye los 4 productos más vendidos (excluyendo pedidos cancelados).
     *
     * @return \Illuminate\View\View
     */
    public function regalos()
    {
        $idsMasVendidos = DetallePedido::select('id_producto')
            ->selectRaw('SUM(cantidad) as total_vendido')
            ->whereHas('pedido', fn($q) => $q->where('estado', '!=', 'cancelado'))
            ->groupBy('id_producto')
            ->orderByDesc('total_vendido')
            ->limit(4)
            ->pluck('id_producto');

        $masVendidos = $idsMasVendidos->isEmpty()
            ? collect()
            : Producto::with('imagenes')
                ->whereIn('id', $idsMasVendidos)
                ->orderByRaw('FIELD(id, ' . $idsMasVendidos->implode(',') . ')')
                ->get();

        $categoriaUrlByDb = [
            'collar' => 'collares',
            'anillo' => 'anillos',
            'pulsera' => 'pulseras',
            'pendiente' => 'pendientes',
        ];

        return view('pages.regalos', compact('masVendidos', 'categoriaUrlByDb'));
    }
}
