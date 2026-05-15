<?php

namespace App\Http\Controllers;

/**
 * RegalosController - Muestra la sección de ideas de regalo.
 */
class RegalosController extends Controller
{
    /**
     * Muestra la página de sugerencias de regalos.
     *
     * @return \Illuminate\View\View
     */
    public function regalos()
    {
        return view('pages.regalos');
    }
}
