<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pedido;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
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

    public function show(Pedido $pedido)
    {
        $pedido->load('usuario', 'detalles.producto');

        return view('admin.pedidos.show', compact('pedido'));
    }

    public function updateEstado(Request $request, Pedido $pedido)
    {
        $request->validate([
            'estado' => 'required|in:pendiente,preparado,enviado,entregado,cancelado',
        ]);

        $pedido->update(['estado' => $request->input('estado')]);

        return back()->with('success', 'Estado del pedido actualizado.');
    }

    public function destroy(Pedido $pedido)
    {
        $pedido->delete();

        return redirect()->route('admin.pedidos.index')->with('success', 'Pedido eliminado correctamente.');
    }
}
