<?php

namespace App\Http\Controllers;

use App\Models\DireccionEnvio;
use Illuminate\Http\Request;

class DireccionEnvioController extends Controller
{
    public function index()
    {
        $direcciones = DireccionEnvio::with('usuario')->get();
        return response()->json($direcciones);
    }

    public function show($id)
    {
        $direccion = DireccionEnvio::with(['usuario', 'pedidos'])->find($id);
        return response()->json($direccion);
    }
}