<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = Categoria::with('productos')->get();
        return response()->json($categorias);
    }

    public function show($id)
    {
        $categoria = Categoria::with('productos')->find($id);
        return response()->json($categoria);
    }
    public function testView()
    {
        $categorias = Categoria::with('productos')->get(); // Obtenemos una coleccion de todos los datos de categorias
        return view('test.categorias-test', compact('categorias'));
    }
}