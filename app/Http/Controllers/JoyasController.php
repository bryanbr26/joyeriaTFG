<?php

namespace App\Http\Controllers;

use App\Models\Producto;

class JoyasController extends Controller
{
    public function collares()
    {
        $collares = Producto::mostrarCollares();
        return view('pages.joyas.collares', compact('collares'));
    }

    public function anillos()
    {
        $anillos = Producto::mostrarAnillos();
        return view('pages.joyas.anillos', compact('anillos'));
    }

    public function pulseras()
    {
        $pulseras = Producto::mostrarPulseras();
        return view('pages.joyas.pulseras', compact('pulseras'));
    }

    public function pendientes()
    {
        $pendientes = Producto::mostrarPendientes();
        return view('pages.joyas.pendientes', compact('pendientes'));
    }
}
