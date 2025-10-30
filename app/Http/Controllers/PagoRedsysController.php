<?php

namespace App\Http\Controllers;

use App\Models\PagoRedsys;
use Illuminate\Http\Request;

class PagoRedsysController extends Controller
{
    public function index()
    {
        $pagos = PagoRedsys::with('pedido')->get();
        return response()->json($pagos);
    }

    public function show($id)
    {
        $pago = PagoRedsys::with('pedido')->find($id);
        return response()->json($pago);
    }
}