<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    public function index()
    {
        $pedidos = Pedido::with(['usuario', 'detalles'])->get();
        return response()->json($pedidos);
    }

    public function show($id)
    {
        $pedido = Pedido::with(['usuario', 'detalles.producto', 'direccionEnvio', 'metodoPago'])->find($id);
        return response()->json($pedido);
    }
}