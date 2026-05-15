<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

/**
 * UpdateUserProfileInformation - Acción de Fortify para actualizar el perfil.
 *
 * Actualiza nombre y email del usuario, gestionando la reverificación
 * de correo cuando este cambia.
 */
class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Valida y actualiza la información de perfil del usuario.
     *
     * @param \App\Models\User $user Usuario a actualizar
     * @param array<string, string> $input Datos del formulario de perfil
     * @return void
     */
    public function update(User $user, array $input): void
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
        ])->validateWithBag('updateProfileInformation');

        if ($input['email'] !== $user->email &&
            $user instanceof MustVerifyEmail) {
            $this->updateVerifiedUser($user, $input);
        } else {
            $user->forceFill([
                'name' => $input['name'],
                'email' => $input['email'],
            ])->save();
        }
    }

    /**
     * Actualiza la información de un usuario verificado cuyo email ha cambiado.
     *
     * @param \App\Models\User $user Usuario a actualizar
     * @param array<string, string> $input Datos del formulario
     * @return void
     */
    protected function updateVerifiedUser(User $user, array $input): void
    {
        $user->forceFill([
            'name' => $input['name'],
            'email' => $input['email'],
            'email_verified_at' => null,
        ])->save();

        $user->sendEmailVerificationNotification();
    }
}
