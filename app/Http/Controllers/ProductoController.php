<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::with('categoria')->get();
        return response()->json($productos);
    }

    public function show($id)
    {
        $producto = Producto::with('categoria')->find($id);
        return response()->json($producto);
    }

    //Funcion qeu retorna los productos a una vista para probar
    public function testView()
{
    $productos = Producto::with('categoria')->get();
    return view('productos-test', compact('productos'));
}
}