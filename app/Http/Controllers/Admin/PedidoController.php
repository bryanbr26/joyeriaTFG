<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pedido;
use Illuminate\Http\Request;

/**
 * PedidoController (Admin) - Gestión de pedidos desde el panel de administración.
 *
 * Permite listar, filtrar, ver detalles, actualizar estado y eliminar pedidos.
 */
class PedidoController extends Controller
{
    /**
     * Muestra el listado paginado de pedidos con filtro por estado.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $pedidos = Pedido::with('usuario')
            ->when($request->filled('estado'), function ($query) use ($request) {
                $query->where('estado', $request->input('estado'));
            })
            ->orderByDesc('fecha')
            ->paginate(10)
            ->appends($request->query());

        return view('admin.pedidos.index', compact('pedidos'));
    }

    /**
     * Muestra el detalle completo de un pedido.
     *
     * @param \App\Models\Pedido $pedido Pedido a visualizar
     * @return \Illuminate\View\View
     */
    public function show(Pedido $pedido)
    {
        $pedido->load('usuario', 'detalles.producto');

        return view('admin.pedidos.show', compact('pedido'));
    }

    /**
     * Actualiza el estado de un pedido.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Pedido $pedido Pedido a actualizar
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateEstado(Request $request, Pedido $pedido)
    {
        $request->validate([
            'estado' => 'required|in:pendiente,preparado,enviado,entregado,cancelado',
        ]);

        $pedido->update(['estado' => $request->input('estado')]);

        return back()->with('success', 'Estado del pedido actualizado.');
    }

    /**
     * Elimina un pedido del sistema.
     *
     * @param \App\Models\Pedido $pedido Pedido a eliminar
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Pedido $pedido)
    {
        $pedido->delete();

        return redirect()->route('admin.pedidos.index')->with('success', 'Pedido eliminado correctamente.');
    }
}
