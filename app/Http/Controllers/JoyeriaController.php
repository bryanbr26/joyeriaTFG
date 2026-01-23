<?php

namespace App\Http\Controllers;




class JoyeriaController extends Controller
{
    public function collares()
    {
        return view('pages.joyas.collares');
    }

    public function anillos()
    {
        return view('pages.joyas.anillos');
    }

    public function pulseras()
    {
        return view('pages.joyas.pulseras');
    }

    public function pendientes()
    {
        return view('pages.joyas.pendientes');
    }
}
