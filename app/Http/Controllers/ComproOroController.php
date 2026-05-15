<?php

namespace App\Http\Controllers;

/**
 * ComproOroController - Muestra la sección de compra de oro.
 */
class ComproOroController extends Controller
{
    /**
     * Muestra la página informativa del servicio de compra de oro.
     *
     * @return \Illuminate\View\View
     */
    public function comproOro()
    {
        return view('pages.comproOro');
    }
}
