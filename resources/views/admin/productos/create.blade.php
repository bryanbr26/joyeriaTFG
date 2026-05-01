@extends('layouts.admin')

@section('title', 'Crear producto')

@section('content')
    <div class="admin-page-header">
        <div>
            <p class="admin-eyebrow">Catálogo</p>
            <h1>Crear producto</h1>
        </div>
        <a href="{{ route('admin.productos.index') }}" class="btn btn-outline-dark">
            <i class="bi bi-arrow-left me-1"></i>
            Volver
        </a>
    </div>

    <section class="admin-panel">
        @include('admin.productos.form', [
            'producto' => null,
            'action' => route('admin.productos.store'),
            'method' => 'POST',
            'submit' => 'Crear producto',
            'imageRequired' => true,
        ])
    </section>
@endsection
