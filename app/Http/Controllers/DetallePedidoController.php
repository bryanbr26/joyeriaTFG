<?php

namespace App\Http\Controllers;

use App\Models\DetallePedido;
use Illuminate\Http\Request;

class DetallePedidoController extends Controller
{
    public function index()
    {
        $detalles = DetallePedido::with(['pedido', 'producto'])->get();
        return response()->json($detalles);
    }

    public function show($id)
    {
        $detalle = DetallePedido::with(['pedido', 'producto'])->find($id);
        return response()->json($detalle);
    }
}