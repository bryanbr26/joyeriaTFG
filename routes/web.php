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

// Página de inicio
Route::get('/', [HomeController::class, 'index'])->name('index');

// USUARIOS
//Route::get('/usuarios', [UserController::class, 'index'])->name('usuarios.index');
//Route::get('/usuarios/{id}', [UserController::class, 'show'])->name('usuarios.show');

// RUTAS DE AUTH
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/home', [HomeController::class, 'index'])->name('home');

// RUTAS DE JOYERIA
Route::get('/collares', [JoyasController::class, 'collares'])->name('collares');
Route::get('/anillos', [JoyasController::class, 'anillos'])->name('anillos');
Route::get('/pulseras', [JoyasController::class, 'pulseras'])->name('pulseras');
Route::get('/pendientes', [JoyasController::class, 'pendientes'])->name('pendientes');

//RUTAS DEL RESTO DEL NAV
Route::get('/regalos', [RegalosController::class, 'regalos'])->name('regalos');
Route::get('/personaliza-tus-joyas', [PersonalizaController::class, 'personaliza'])->name('personaliza');
Route::get('/compro-oro', [ComproOroController::class, 'comproOro'])->name('comproOro');
Route::get('/orfebreria', [OrfebreriaController::class, 'orfebreria'])->name('orfebreria');
Route::get('/historia', [HistoriaController::class, 'historia'])->name('historia');
Route::get('/contacto', [ContactoController::class, 'contacto'])->name('contacto');
