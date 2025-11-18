<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\PasswordResetResponse;

class CustomPasswordResetResponse implements PasswordResetResponse
{
    public function toResponse($request)
    {
        return redirect('/login')
            ->with('status', 'Contraseña cambiada correctamente.');
    }
}
