@extends("layouts.layout")

@section("title", $titulo)

@section("content")

<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>{{ $titulo }}</h2>
        <a href="{{ route('joyas.create', $categoria) }}" class="btn btn-dark">
            <i class="bi bi-plus-lg"></i> Nuevo {{ rtrim($titulo, 's') }}
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-3">
        @forelse($productos as $producto)
        <div class="col-md-3">
            <div class="card h-100">
                @if($producto->ruta_grabado && file_exists(public_path('storage/' . $producto->ruta_grabado)))
                    <img src="{{ asset('storage/' . $producto->ruta_grabado) }}" class="card-img-top" alt="{{ $producto->nombre }}" style="height: 200px; object-fit: cover;">
                @else
                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                        <i class="bi bi-gem fs-1 text-muted"></i>
                    </div>
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{ $producto->nombre }}</h5>
                    <p class="card-text text-muted small">{{ $producto->marca }}</p>
                    <p class="card-text">{{ Str::limit($producto->descripcion, 60) }}</p>
                    <p class="card-text fw-bold">{{ number_format($producto->precio, 2) }} €</p>
                    <p class="card-text"><small class="text-muted">Stock: {{ $producto->stock }}</small></p>
                </div>
                <div class="card-footer d-flex gap-2">
                    <a href="{{ route('joyas.edit', [$categoria, $producto]) }}" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-pencil"></i> Editar
                    </a>
                    <form action="{{ route('joyas.destroy', [$categoria, $producto]) }}" method="POST" onsubmit="return confirm('¿Eliminar este producto?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger">
                            <i class="bi bi-trash"></i> Eliminar
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-info text-center">
                No hay {{ strtolower($titulo) }} registrados. <a href="{{ route('joyas.create', $categoria) }}">Crear uno</a>.
            </div>
        </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $productos->links() }}
    </div>
</div>

@endsection
