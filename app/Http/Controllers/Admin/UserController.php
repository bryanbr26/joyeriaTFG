<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * UserController (Admin) - Gestión de usuarios desde el panel de administración.
 *
 * Permite listar, buscar, crear, editar y eliminar usuarios del sistema,
 * incluyendo la gestión segura de contraseñas.
 */
class UserController extends Controller
{
    /**
     * Muestra el listado paginado de usuarios con filtros de búsqueda y rol.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
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

    /**
     * Muestra el formulario de creación de usuario.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.usuarios.create');
    }

    /**
     * Almacena un nuevo usuario en el sistema.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $datos = $this->validateUsuario($request);
        $datos['password'] = Hash::make($datos['password']);

        User::create($datos);

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario creado correctamente.');
    }

    /**
     * Muestra el formulario de edición de un usuario.
     *
     * @param \App\Models\User $usuario Usuario a editar
     * @return \Illuminate\View\View
     */
    public function edit(User $usuario)
    {
        return view('admin.usuarios.edit', compact('usuario'));
    }

    /**
     * Actualiza los datos de un usuario existente.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $usuario Usuario a actualizar
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, User $usuario)
    {
        $datos = $this->validateUsuario($request, $usuario);

        if (!empty($datos['password'])) {
            $datos['password'] = Hash::make($datos['password']);
        } else {
            unset($datos['password']);
        }

        $usuario->update($datos);

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario actualizado correctamente.');
    }

    /**
     * Elimina un usuario del sistema.
     *
     * @param \App\Models\User $usuario Usuario a eliminar
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $usuario)
    {
        $usuario->delete();

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario eliminado correctamente.');
    }

    /**
     * Valida los datos de un usuario según si es creación o edición.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User|null $usuario Usuario en edición (null para creación)
     * @return array Datos validados
     */
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
