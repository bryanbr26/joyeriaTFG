<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\ResetsUserPasswords;

/**
 * ResetUserPassword - Acción de Fortify para restablecer la contraseña olvidada.
 *
 * Valida la nueva contraseña y la guarda de forma segura hasheada.
 */
class ResetUserPassword implements ResetsUserPasswords
{
    use PasswordValidationRules;

    /**
     * Valida y restablece la contraseña olvidada del usuario.
     *
     * @param \App\Models\User $user Usuario a actualizar
     * @param array<string, string> $input Datos del formulario de reset
     * @return void
     */
    public function reset(User $user, array $input): void
    {
        \Illuminate\Support\Facades\Log::info('ResetUserPassword: Start for ' . $user->email);

        Validator::make($input, [
            'password' => $this->passwordRules(),
        ])->validate();

        $user->forceFill([
            'password' => Hash::make($input['password']),
        ])->save();

        \Illuminate\Support\Facades\Log::info('ResetUserPassword: Password updated for ' . $user->email);
    }
}
