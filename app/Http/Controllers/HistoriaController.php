<?php

namespace App\Http\Controllers;

/**
 * HistoriaController - Muestra la sección sobre la historia de la joyería.
 */
class HistoriaController extends Controller
{
    /**
     * Muestra la página de historia y trayectoria de la marca.
     *
     * @return \Illuminate\View\View
     */
    public function historia()
    {
        return view('pages.historia');
    }
}
