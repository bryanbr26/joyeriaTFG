<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * PedidoController - Gestiona el historial y detalle de pedidos del usuario.
 *
 * Permite a los usuarios autenticados consultar sus pedidos realizados
 * y visualizar el detalle completo de cada uno.
 */
class PedidoController extends Controller
{
    /**
     * Muestra el historial de pedidos del usuario logueado.
     *
     * Carga los pedidos con sus detalles, productos, imágenes y pago Redsys
     * ordenados por fecha descendente.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para ver tus pedidos.');
        }

        $pedidos = Pedido::with(['detalles.producto.imagenes', 'pagoRedsys'])
                         ->where('id_usuario', Auth::id())
                         ->orderBy('fecha', 'desc')
                         ->get();

        return view('pedidos.index', compact('pedidos'));
    }

    /**
     * Muestra los detalles de un pedido específico del usuario.
     *
     * @param int $id Identificador del pedido
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function show($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $pedido = Pedido::with(['detalles.producto.imagenes', 'pagoRedsys'])
                        ->where('id', $id)
                        ->where('id_usuario', Auth::id())
                        ->firstOrFail();

        return view('pedidos.show', compact('pedido'));
    }
}
