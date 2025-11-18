<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\MetodoPagoController;
use App\Http\Controllers\DireccionEnvioController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\DetallePedidoController;
use App\Http\Controllers\ImagenProductoController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\FavoritoController;
use App\Http\Controllers\LogUsuarioController;
use App\Http\Controllers\PagoRedsysController;

// Página de inicio
Route::get('/', function () {
    return view('welcome');
});

// USUARIOS
Route::get('/usuarios', [UserController::class, 'index'])->name('usuarios.index');
Route::get('/usuarios/{id}', [UserController::class, 'show'])->name('usuarios.show');

// CATEGORIAS
Route::get('/categorias', [CategoriaController::class, 'index'])->name('categorias.index');
Route::get('/categorias/{id}', [CategoriaController::class, 'show'])->name('categorias.show');

// PRODUCTOS
Route::get('/productos', [ProductoController::class, 'index'])->name('productos.index');
Route::get('/productos/{id}', [ProductoController::class, 'show'])->name('productos.show');

// MÉTODOS DE PAGO
Route::get('/metodos-pago', [MetodoPagoController::class, 'index'])->name('metodos-pago.index');
Route::get('/metodos-pago/{id}', [MetodoPagoController::class, 'show'])->name('metodos-pago.show');

// DIRECCIONES DE ENVÍO
Route::get('/direcciones-envio', [DireccionEnvioController::class, 'index'])->name('direcciones-envio.index');
Route::get('/direcciones-envio/{id}', [DireccionEnvioController::class, 'show'])->name('direcciones-envio.show');

// PEDIDOS
Route::get('/pedidos', [PedidoController::class, 'index'])->name('pedidos.index');
Route::get('/pedidos/{id}', [PedidoController::class, 'show'])->name('pedidos.show');

// DETALLES DE PEDIDO
Route::get('/detalles-pedido', [DetallePedidoController::class, 'index'])->name('detalles-pedido.index');
Route::get('/detalles-pedido/{id}', [DetallePedidoController::class, 'show'])->name('detalles-pedido.show');

// IMÁGENES DE PRODUCTO
Route::get('/imagenes-producto', [ImagenProductoController::class, 'index'])->name('imagenes-producto.index');
Route::get('/imagenes-producto/{id}', [ImagenProductoController::class, 'show'])->name('imagenes-producto.show');

// CARRITO
Route::get('/carrito', [CarritoController::class, 'index'])->name('carrito.index');
Route::get('/carrito/{id}', [CarritoController::class, 'show'])->name('carrito.show');

// FAVORITOS
Route::get('/favoritos', [FavoritoController::class, 'index'])->name('favoritos.index');
Route::get('/favoritos/{id}', [FavoritoController::class, 'show'])->name('favoritos.show');

// LOGS DE USUARIO
Route::get('/logs-usuario', [LogUsuarioController::class, 'index'])->name('logs-usuario.index');
Route::get('/logs-usuario/{id}', [LogUsuarioController::class, 'show'])->name('logs-usuario.show');

// PAGOS REDSYS
Route::get('/pagos-redsys', [PagoRedsysController::class, 'index'])->name('pagos-redsys.index');
Route::get('/pagos-redsys/{id}', [PagoRedsysController::class, 'show'])->name('pagos-redsys.show');


// Ruta para probar productos
Route::get('/test-productos', [ProductoController::class, 'testView'])->name('productos.test');