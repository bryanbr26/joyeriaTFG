<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function login()
    {
        return view('auth.login');
    }

    public function register()
    {
        return view('auth.login', ['mostrarRegistro' => true]);
    }

    public function logout()
    {
        Auth::logout();
        return view('auth.logout');
    }

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
