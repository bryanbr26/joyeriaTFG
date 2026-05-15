<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * Controller - Clase base para todos los controladores de la aplicación.
 *
 * Proporciona los traits de autorización y validación usados por defecto
 * en los controladores de Laravel.
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
