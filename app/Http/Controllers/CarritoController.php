<?php

namespace App\Http\Controllers;

use App\Models\Carrito;
use Illuminate\Http\Request;

class CarritoController extends Controller
{
    public function index()
    {
        $carritos = Carrito::with(['usuario', 'producto'])->get();
        return response()->json($carritos);
    }

    public function show($id)
    {
        $carrito = Carrito::with(['usuario', 'producto'])->find($id);
        return response()->json($carrito);
    }
}