<?php

namespace App\Http\Controllers;

use App\Models\MetodoPago;
use Illuminate\Http\Request;

class MetodoPagoController extends Controller
{
    public function index()
    {
        $metodosPago = MetodoPago::all();
        return response()->json($metodosPago);
    }

    public function show($id)
    {
        $metodoPago = MetodoPago::with('pedidos')->find($id);
        return response()->json($metodoPago);
    }
}