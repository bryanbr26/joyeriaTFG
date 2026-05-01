<?php

namespace App\Providers;

use App\Models\Carrito;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
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
