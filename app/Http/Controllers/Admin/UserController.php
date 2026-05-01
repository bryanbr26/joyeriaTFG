<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $usuarios = User::query()
            ->when($request->filled('buscar'), function ($query) use ($request) {
                $buscar = $request->input('buscar');
                $query->where(function ($subquery) use ($buscar) {
                    $subquery->where('nombre', 'like', '%' . $buscar . '%')
                        ->orWhere('apellidos', 'like', '%' . $buscar . '%')
                        ->orWhere('email', 'like', '%' . $buscar . '%');
                });
            })
            ->when($request->filled('rol'), function ($query) use ($request) {
                $query->where('rol', $request->input('rol'));
            })
            ->orderByDesc('id')
            ->paginate(10)
            ->appends($request->query());

        return view('admin.usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        return view('admin.usuarios.create');
    }

    public function store(Request $request)
    {
        $datos = $this->validateUsuario($request);
        $datos['password'] = Hash::make($datos['password']);
        $datos['activo'] = $request->has('activo');

        User::create($datos);

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario creado correctamente.');
    }

    public function edit(User $usuario)
    {
        return view('admin.usuarios.edit', compact('usuario'));
    }

    public function update(Request $request, User $usuario)
    {
        $datos = $this->validateUsuario($request, $usuario);
        $datos['activo'] = $request->has('activo');

        if (!empty($datos['password'])) {
            $datos['password'] = Hash::make($datos['password']);
        } else {
            unset($datos['password']);
        }

        $usuario->update($datos);

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy(User $usuario)
    {
        $usuario->delete();

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario eliminado correctamente.');
    }

    private function validateUsuario(Request $request, ?User $usuario = null): array
    {
        $usuarioId = $usuario ? ',' . $usuario->id : '';
        $passwordRule = $usuario ? 'nullable|string|min:6' : 'required|string|min:6';

        return $request->validate([
            'nombre' => 'required|string|max:100',
            'apellidos' => 'required|string|max:150',
            'email' => 'required|email|unique:USUARIO,email' . $usuarioId,
            'password' => $passwordRule,
            'telefono' => 'nullable|string|max:20',
            'rol' => 'required|in:user,admin',
        ]);
    }
}
