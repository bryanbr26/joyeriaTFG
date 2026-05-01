<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        if ($request->user() && $request->user()->rol === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->intended('/');
    }
}
