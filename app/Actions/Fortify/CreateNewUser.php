<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

/**
 * CreateNewUser - Acción de Fortify para registrar nuevos usuarios.
 *
 * Valida los datos de entrada y crea un usuario en la base de datos
 * con contraseña hasheada.
 */
class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Valida y crea un usuario recién registrado.
     *
     * @param array<string, string> $input Datos del formulario de registro
     * @return \App\Models\User
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'nombre' => ['required','string', 'max:255'],
            'apellidos' => ['required','string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
        ])->validate();

        return User::create([
            'nombre' => $input['nombre'],
            'apellidos' => $input['apellidos'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);
    }
}
