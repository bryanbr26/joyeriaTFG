@extends('layouts.admin')

@section('title', 'Editar producto')

@section('content')
    <div class="admin-page-header">
        <div>
            <p class="admin-eyebrow">Catálogo</p>
            <h1>Editar producto</h1>
        </div>
        <a href="{{ route('admin.productos.index') }}" class="btn btn-outline-dark">
            <i class="bi bi-arrow-left me-1"></i>
            Volver
        </a>
    </div>

    <section class="admin-panel">
        @include('admin.productos.form', [
            'producto' => $producto,
            'action' => route('admin.productos.update', $producto),
            'method' => 'PUT',
            'submit' => 'Guardar cambios',
            'imageRequired' => false,
        ])
    </section>
@endsection
