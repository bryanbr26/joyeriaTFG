<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * AdminMiddleware - Restringe el acceso a rutas del panel de administración.
 *
 * Verifica que el usuario esté autenticado y tenga el rol de administrador.
 * De lo contrario redirige al login o aborta con 403.
 */
class AdminMiddleware
{
    /**
     * Maneja una solicitud entrante permitiendo solo a administradores.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next Siguiente middleware en la cadena
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (Auth::user()->rol !== 'admin') {
            abort(403, 'No tienes permisos para acceder al panel de administración.');
        }

        return $next($request);
    }
}
