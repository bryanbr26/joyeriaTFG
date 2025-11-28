<?php

namespace App\Http\Controllers;

use App\Models\User;


class UserController extends Controller
{
    public function index()
    {
        $usuarios = User::all();
        return response()->json($usuarios);
    }

    public function show($id)
    {
        $usuario = User::with(['direcciones', 'pedidos', 'carritos'])->find($id);
        return response()->json($usuario);
    }
}
