<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

/**
 * LoginResponse - Respuesta personalizada tras un inicio de sesión exitoso.
 *
 * Redirige a los administradores al dashboard y al resto de usuarios
 * a la página principal o a la URL previa.
 */
class LoginResponse implements LoginResponseContract
{
    /**
     * Genera la respuesta HTTP tras un login exitoso.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toResponse($request)
    {
        if ($request->user() && $request->user()->rol === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->intended('/');
    }
}
