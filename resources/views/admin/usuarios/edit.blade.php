@extends('layouts.admin')

@section('title', 'Editar usuario')

@section('content')
    <div class="admin-page-header">
        <div>
            <p class="admin-eyebrow">Administración</p>
            <h1>Editar usuario</h1>
        </div>
        <a href="{{ route('admin.usuarios.index') }}" class="btn btn-outline-dark">
            <i class="bi bi-arrow-left me-1"></i>
            Volver
        </a>
    </div>

    <section class="admin-panel">
        @include('admin.usuarios.form', [
            'usuario' => $usuario,
            'action' => route('admin.usuarios.update', $usuario),
            'method' => 'PUT',
            'submit' => 'Guardar cambios',
        ])
    </section>
@endsection
