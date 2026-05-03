@extends('layouts.admin')

@section('title', 'Usuarios')

@section('content')
    <div class="admin-page-header">
        <div>
            <p class="admin-eyebrow">Administración</p>
            <h1>Usuarios</h1>
        </div>
        <a href="{{ route('admin.usuarios.create') }}" class="btn btn-dark">
            <i class="bi bi-person-plus me-1"></i>
            Nuevo administrador
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <section class="admin-panel">
        <form action="{{ route('admin.usuarios.index') }}" method="GET" class="admin-filter-bar">
            <input type="search" name="buscar" class="form-control" placeholder="Buscar por nombre o email" value="{{ request('buscar') }}">
            <select name="rol" class="form-select">
                <option value="">Todos los roles</option>
                <option value="admin" {{ request('rol') === 'admin' ? 'selected' : '' }}>Administradores</option>
                <option value="user" {{ request('rol') === 'user' ? 'selected' : '' }}>Usuarios</option>
            </select>
            <button type="submit" class="btn btn-outline-dark">
                <i class="bi bi-search me-1"></i>
                Filtrar
            </button>
        </form>

        <div class="table-responsive">
            <table class="table align-middle admin-table">
                <thead>
                    <tr>
                        <th>Usuario</th>
                        <th>Email</th>
                        <th>Teléfono</th>
                        <th>Rol</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($usuarios as $usuario)
                        <tr>
                            <td>
                                <strong>{{ $usuario->nombre }} {{ $usuario->apellidos }}</strong>
                                <span class="d-block text-muted small">ID #{{ $usuario->id }}</span>
                            </td>
                            <td>{{ $usuario->email }}</td>
                            <td>{{ $usuario->telefono ?? '-' }}</td>
                            <td>
                                <span class="badge {{ $usuario->rol === 'admin' ? 'bg-danger' : 'bg-primary' }}">
                                    {{ $usuario->rol === 'admin' ? 'Admin' : 'Usuario' }}
                                </span>
                            </td>
                            <td>
                                <div class="admin-actions">
                                    <a href="{{ route('admin.usuarios.edit', $usuario) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.usuarios.destroy', $usuario) }}" method="POST" onsubmit="return confirm('¿Eliminar este usuario?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-muted">No hay usuarios registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $usuarios->links() }}
        </div>
    </section>
@endsection
