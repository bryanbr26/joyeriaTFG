@extends('layouts.admin')

@section('title', 'Crear usuario')

@section('content')
    <div class="admin-page-header">
        <div>
            <p class="admin-eyebrow">Administración</p>
            <h1>Crear usuario</h1>
        </div>
        <a href="{{ route('admin.usuarios.index') }}" class="btn btn-outline-dark">
            <i class="bi bi-arrow-left me-1"></i>
            Volver
        </a>
    </div>

    <section class="admin-panel">
        @include('admin.usuarios.form', [
            'usuario' => null,
            'action' => route('admin.usuarios.store'),
            'method' => 'POST',
            'submit' => 'Crear usuario',
        ])
    </section>
@endsection
