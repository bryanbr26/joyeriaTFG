<?php

namespace App\Providers;

use App\Models\Carrito;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

/**
 * AppServiceProvider - Proveedor de servicios principal de la aplicación.
 *
 * Registra y bootea servicios globales como la paginación Bootstrap
 * y el composer de vistas para el contador del carrito.
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Registra servicios de la aplicación.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootea servicios de la aplicación.
     *
     * Configura la paginación con Bootstrap y comparte el total de items
     * del carrito con la vista del header.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
        // Nota: Si estuvieras usando Bootstrap 5 específicamente, 
        // podrías usar Paginator::useBootstrapFive();

        View::composer('layouts.Header', function ($view) {
            $totalItemsCarrito = Auth::check()
                ? Carrito::where('id_usuario', Auth::id())->sum('cantidad')
                : 0;

            $view->with('totalItemsCarrito', $totalItemsCarrito);
        });
    }
}
