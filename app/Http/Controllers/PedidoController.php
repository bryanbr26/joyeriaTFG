<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PedidoController extends Controller
{
    /**
     * Muestra el historial de pedidos del usuario logueado.
     */
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para ver tus pedidos.');
        }

        $pedidos = Pedido::with('detalles.producto')
                         ->where('id_usuario', Auth::id())
                         ->orderBy('fecha', 'desc')
                         ->get();

        return view('pedidos.index', compact('pedidos'));
    }

    /**
     * Muestra los detalles de un pedido específico.
     */
    public function show($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $pedido = Pedido::with('detalles.producto')
                        ->where('id', $id)
                        ->where('id_usuario', Auth::id())
                        ->firstOrFail();

        return view('pedidos.show', compact('pedido'));
    }
}
