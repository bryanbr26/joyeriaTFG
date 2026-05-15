<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;
use App\Models\Usuario; 

use Laravel\Fortify\Contracts\PasswordResetResponse;
use App\Http\Responses\CustomPasswordResetResponse;
use Laravel\Fortify\Contracts\LoginResponse;
use App\Http\Responses\LoginResponse as CustomLoginResponse;

/**
 * FortifyServiceProvider - Configuración del paquete Laravel Fortify.
 *
 * Registra las acciones personalizadas de autenticación, las vistas
 * de login/registro/recuperación y los rate limiters de seguridad.
 */
class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Registra servicios de la aplicación.
     *
     * Sustituye las respuestas por defecto de Fortify por las personalizadas.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            PasswordResetResponse::class,
            CustomPasswordResetResponse::class
        );

        $this->app->singleton(
            LoginResponse::class,
            CustomLoginResponse::class
        );
    }

    /**
     * Bootea los servicios de Fortify.
     *
     * Configura acciones, vistas personalizadas y limitación de peticiones.
     *
     * @return void
     */
    public function boot(): void
    {
        // Acciones personalizadas de Fortify
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);


        // Vistas personalizadas (si usas Blade)
        Fortify::loginView(function () {
            return view('auth.login');
        });

        Fortify::registerView(function () {
            return view('auth.login', ['mostrarRegistro' => true]);
        });

        //Manda correo para recuperar la contraseña y manda a la vista
        Fortify::requestPasswordResetLinkView(function () {
            return view('auth.forgot-password');
        });


        Fortify::resetPasswordView(function ($request) {
            return view('auth.reset-password', ['request' => $request]);
        });

        // Rate limiting (seguridad)
        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())) . '|' . $request->ip());
            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });
    }
}
