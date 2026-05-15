<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\UpdatesUserPasswords;

/**
 * UpdateUserPassword - Acción de Fortify para actualizar la contraseña del usuario.
 *
 * Valida la contraseña actual y reemplaza la contraseña del usuario logueado.
 */
class UpdateUserPassword implements UpdatesUserPasswords
{
    use PasswordValidationRules;

    /**
     * Valida y actualiza la contraseña del usuario.
     *
     * @param \App\Models\User $user Usuario a actualizar
     * @param array<string, string> $input Datos del formulario
     * @return void
     */
    public function update(User $user, array $input): void
    {
        Validator::make($input, [
            'current_password' => ['required', 'string', 'current_password:web'],
            'password' => $this->passwordRules(),
        ], [
            'current_password.current_password' => __('The provided password does not match your current password.'),
        ])->validateWithBag('updatePassword');

        $user->forceFill([
            'password' => Hash::make($input['password']),
        ])->save();
    }
}
