<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\PasswordResetResponse;

/**
 * CustomPasswordResetResponse - Respuesta personalizada tras restablecer contraseña.
 *
 * Redirige al usuario a la pantalla de login con un mensaje de confirmación.
 */
class CustomPasswordResetResponse implements PasswordResetResponse
{
    /**
     * Genera la respuesta HTTP tras un restablecimiento de contraseña exitoso.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toResponse($request)
    {
        return redirect('/login')
            ->with('status', 'OK');
    }
}
