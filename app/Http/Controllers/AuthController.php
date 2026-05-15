<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Support\Facades\Auth;

/**
 * AuthController - Gestiona las vistas relacionadas con autenticación.
 *
 * Controla el acceso a login, registro, logout y el panel de usuario,
 * incluyendo el historial de pedidos del cliente.
 */
class AuthController extends Controller
{
    /**
     * Muestra la vista de inicio de sesión.
     *
     * @return \Illuminate\View\View
     */
    public function login()
    {
        return view('auth.login');
    }

    /**
     * Muestra la vista de registro dentro de la misma pantalla de login.
     *
     * @return \Illuminate\View\View
     */
    public function register()
    {
        return view('auth.login', ['mostrarRegistro' => true]);
    }

    /**
     * Cierra la sesión del usuario y muestra la vista de logout.
     *
     * @return \Illuminate\View\View
     */
    public function logout()
    {
        Auth::logout();
        return view('auth.logout');
    }

    /**
     * Muestra el panel personal del usuario con su historial de pedidos.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function panel()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para acceder a tu panel.');
        }

        $pedidos = Pedido::with('detalles.producto')
                         ->where('id_usuario', Auth::id())
                         ->orderBy('fecha', 'desc')
                         ->get();

        return view('auth.panel-usuario', compact('pedidos'));
    }
}
