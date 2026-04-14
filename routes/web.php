<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JoyasController;
use App\Http\Controllers\RegalosController;
use App\Http\Controllers\PersonalizaController;
use App\Http\Controllers\ComproOroController;
use App\Http\Controllers\OrfebreriaController;
use App\Http\Controllers\HistoriaController;
use App\Http\Controllers\ContactoController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\FavoritoController;
use App\Http\Controllers\PedidoController;

// Página de inicio
Route::get('/', [HomeController::class, 'index'])->name('index');

// RUTAS DE AUTH
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/home', [HomeController::class, 'index'])->name('home');

// CRUD USUARIOS
Route::resource('usuarios', UserController::class);

// CRUD JOYAS POR CATEGORÍA
Route::prefix('{categoria}')->where(['categoria' => 'collares|anillos|pulseras|pendientes'])->name('joyas.')->group(function () {
    Route::get('/', [JoyasController::class, 'index'])->name('index');
    Route::get('/create', [JoyasController::class, 'create'])->name('create');
    Route::post('/', [JoyasController::class, 'store'])->name('store');
    Route::get('/{producto}/edit', [JoyasController::class, 'edit'])->name('edit');
    Route::put('/{producto}', [JoyasController::class, 'update'])->name('update');
    Route::delete('/{producto}', [JoyasController::class, 'destroy'])->name('destroy');
    Route::get('/{producto}', [JoyasController::class, 'show'])->name('show');
});

// RUTAS DEL RESTO DEL NAV
Route::get('/regalos', [RegalosController::class, 'regalos'])->name('regalos');
Route::get('/personaliza-tus-joyas', [PersonalizaController::class, 'personaliza'])->name('personaliza');
Route::post('/personaliza-tus-joyas/guardar', [PersonalizaController::class, 'guardarGrabado'])->name('personaliza.guardar');
Route::get('/personaliza-tus-joyas/{producto}', [PersonalizaController::class, 'personalizaProducto'])->name('personaliza.producto');
Route::get('/compro-oro', [ComproOroController::class, 'comproOro'])->name('comproOro');
Route::get('/orfebreria', [OrfebreriaController::class, 'orfebreria'])->name('orfebreria');
Route::get('/historia', [HistoriaController::class, 'historia'])->name('historia');
Route::get('/contacto', [ContactoController::class, 'contacto'])->name('contacto');

// RUTAS CARRITO
Route::middleware('auth')->group(function () {
    Route::get('/carrito', [CarritoController::class, 'index'])->name('carrito.index');
    Route::post('/carrito/agregar/{producto}', [CarritoController::class, 'agregar'])->name('carrito.agregar');
    Route::patch('/carrito/{id}/cantidad', [CarritoController::class, 'actualizarCantidad'])->name('carrito.actualizarCantidad');
    Route::delete('/carrito/{id}', [CarritoController::class, 'eliminar'])->name('carrito.eliminar');
    Route::post('/carrito/checkout', [CarritoController::class, 'checkout'])->name('carrito.checkout');
});

// RUTAS FAVORITOS
// Toggle va fuera del middleware auth para devolver JSON 401 en AJAX
Route::post('/favoritos/toggle/{producto}', [FavoritoController::class, 'toggle'])->name('favoritos.toggle');

Route::middleware('auth')->group(function () {
    Route::get('/favoritos', [FavoritoController::class, 'index'])->name('favoritos.index');
    Route::delete('/favoritos/{id}', [FavoritoController::class, 'eliminar'])->name('favoritos.eliminar');
    Route::post('/favoritos/{id}/carrito', [FavoritoController::class, 'agregarAlCarrito'])->name('favoritos.agregarCarrito');
});

// RUTAS PEDIDOS
Route::middleware('auth')->group(function () {
    Route::get('/pedidos', [PedidoController::class, 'index'])->name('pedidos.index');
    Route::get('/pedidos/{id}', [PedidoController::class, 'show'])->name('pedidos.show');
});

