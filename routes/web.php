<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;

// Página de inicio
Route::get('/', [HomeController::class, 'index'])->name('index');

// USUARIOS
//Route::get('/usuarios', [UserController::class, 'index'])->name('usuarios.index');
//Route::get('/usuarios/{id}', [UserController::class, 'show'])->name('usuarios.show');

// RUTAS DE AUTH
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
