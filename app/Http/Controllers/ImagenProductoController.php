<?php

namespace App\Http\Controllers;

use App\Models\ImagenProducto;
use Illuminate\Http\Request;

class ImagenProductoController extends Controller
{
    public function index()
    {
        $imagenes = ImagenProducto::with('producto')->get();
        return response()->json($imagenes);
    }

    public function show($id)
    {
        $imagen = ImagenProducto::with('producto')->find($id);
        return response()->json($imagen);
    }
}