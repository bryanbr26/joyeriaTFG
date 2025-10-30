<?php

namespace App\Http\Controllers;

use App\Models\Favorito;
use Illuminate\Http\Request;

class FavoritoController extends Controller
{
    public function index()
    {
        $favoritos = Favorito::with(['usuario', 'producto'])->get();
        return response()->json($favoritos);
    }

    public function show($id)
    {
        $favorito = Favorito::with(['usuario', 'producto'])->find($id);
        return response()->json($favorito);
    }
}