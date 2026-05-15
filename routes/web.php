<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImageController;
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
use App\Http\Controllers\RedsysController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductoController as AdminProductoController;
use App\Http\Controllers\Admin\PedidoController as AdminPedidoController;
use App\Http\Controllers\Admin\UserController as AdminUserController;

// Página de inicio
Route::get('/', [HomeController::class, 'index'])->name('index');

// Ruta de imágenes optimizadas
Route::get('/img/{size}/{path}', [ImageController::class, 'show'])
    ->where('size', 'thumbnail|small|medium|large|placeholder|webp')
    ->where('path', '.*')
    ->name('imagen.optimizada');

// RUTAS DE AUTH
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/panel-usuario', [AuthController::class, 'panel'])->name('panel.usuario')->middleware('auth');
Route::get('/home', [HomeController::class, 'index'])->name('home');

// PANEL DE ADMINISTRACIÓN
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('usuarios', AdminUserController::class)->except(['show'])->parameters(['usuarios' => 'usuario']);
    Route::resource('productos', AdminProductoController::class)->except(['show']);
    Route::patch('/productos/{producto}/stock', [AdminProductoController::class, 'updateStock'])->name('productos.stock');
    Route::get('/pedidos', [AdminPedidoController::class, 'index'])->name('pedidos.index');
    Route::get('/pedidos/{pedido}', [AdminPedidoController::class, 'show'])->name('pedidos.show');
    Route::patch('/pedidos/{pedido}/estado', [AdminPedidoController::class, 'updateEstado'])->name('pedidos.estado');
    Route::delete('/pedidos/{pedido}', [AdminPedidoController::class, 'destroy'])->name('pedidos.destroy');
});

// Búsqueda AJAX de productos (debe ir antes del prefijo {categoria})
Route::get('/buscar-productos', [JoyasController::class, 'buscar'])->name('buscar.productos');

// CRUD JOYAS POR CATEGORÍA
Route::get('/joyeria', [JoyasController::class, 'indexAll'])->name('joyas.buscar');

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
Route::get('/compro-oro', [ComproOroController::class, 'comproOro'])->name('comproOro');
Route::get('/orfebreria', [OrfebreriaController::class, 'orfebreria'])->name('orfebreria');
Route::post('/orfebreria', [OrfebreriaController::class, 'enviarCita'])->name('orfebreria.enviar');
Route::get('/historia', [HistoriaController::class, 'historia'])->name('historia');


// RUTAS CARRITO
Route::middleware('auth')->group(function () {
    Route::get('/carrito', [CarritoController::class, 'index'])->name('carrito.index');
    Route::post('/carrito/agregar/{producto}', [CarritoController::class, 'agregar'])->name('carrito.agregar');
    Route::patch('/carrito/{id}/cantidad', [CarritoController::class, 'actualizarCantidad'])->name('carrito.actualizarCantidad');
    Route::delete('/carrito/{id}', [CarritoController::class, 'eliminar'])->name('carrito.eliminar');
    Route::post('/carrito/checkout', [CarritoController::class, 'checkout'])->name('carrito.checkout');
});

// RUTAS REDSYS
Route::post('/redsys/notificacion', [RedsysController::class, 'notification'])->name('redsys.notification');
Route::match(['get', 'post'], '/redsys/ok', [RedsysController::class, 'ok'])->name('redsys.ok');
Route::match(['get', 'post'], '/redsys/ko', [RedsysController::class, 'ko'])->name('redsys.ko');

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

// RUTAS CONTACTO
Route::get('/contacto', [ContactoController::class, 'contacto'])->name('contacto');
Route::post('/contacto', [ContactoController::class, 'enviar'])->name('contacto.enviar');

// RUTAS PERSONALIZA
Route::get('/personaliza-tus-joyas', [PersonalizaController::class, 'personaliza'])->name('personaliza');
Route::middleware('auth')->group(function () {
    Route::post('/personaliza-tus-joyas/guardar', [PersonalizaController::class, 'guardarGrabado'])->name('personaliza.guardar');
    Route::get('/personaliza-tus-joyas/{producto}', [PersonalizaController::class, 'personalizaProducto'])->name('personaliza.producto');
});

Route::get('/instalar-bd', function () {
    // Limpia la caché de rutas para que Laravel detecte esta URL nueva
    \Illuminate\Support\Facades\Artisan::call('route:clear');
    
    // Ejecuta las migraciones (crea las tablas) en la BD de España
    // El parámetro --force es obligatorio en entornos de producción
    \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
    
    return "¡Tablas creadas con éxito en la base de datos de España!";
});

use Illuminate\Support\Facades\Artisan;

Route::get('/ejecutar-seeder', function () {
    // Añadimos el '--force' => true para que no pregunte nada
    Artisan::call('db:seed', [
        '--class' => 'UsuarioSeeder',
        '--force' => true
    ]);
    
    return '¡UsuarioSeeder ejecutado con éxito por la fuerza! Ya puedes iniciar sesión.';
});
