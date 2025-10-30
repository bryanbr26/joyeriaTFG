<?php

namespace App\Http\Controllers;

use App\Models\LogUsuario;
use Illuminate\Http\Request;

class LogUsuarioController extends Controller
{
    public function index()
    {
        $logs = LogUsuario::with('usuario')->get();
        return response()->json($logs);
    }

    public function show($id)
    {
        $log = LogUsuario::with('usuario')->find($id);
        return response()->json($log);
    }
}