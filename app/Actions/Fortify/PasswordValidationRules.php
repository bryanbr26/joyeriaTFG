<?php

namespace App\Actions\Fortify;

use Illuminate\Validation\Rules\Password;

/**
 * Trait PasswordValidationRules
 *
 * Proporciona las reglas de validación por defecto para contraseñas
 * en las acciones de Fortify (registro, reset, update).
 */
trait PasswordValidationRules
{
    /**
     * Obtiene las reglas de validación usadas para contraseñas.
     *
     * @return array<int, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    protected function passwordRules(): array
    {
        return ['required', 'string', Password::default(), 'confirmed'];
    }
}
