<?php

namespace App\Http\Controllers;

/**
 * HomeController - Gestiona la página de inicio de la tienda.
 */
class HomeController extends Controller
{
    /**
     * Muestra la vista principal de la joyería.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('pages.home');
    }
}
