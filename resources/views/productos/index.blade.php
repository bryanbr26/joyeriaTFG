@extends("layouts.layout")

@section("title", "Gestión de Productos")

@section("content")

<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Gestión de Productos</h2>
        <a href="{{ route('productos.create') }}" class="btn btn-dark">
            <i class="bi bi-plus-lg"></i> Nuevo Producto
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Imagen</th>
                    <th>Nombre</th>
                    <th>Categoría</th>
                    <th>Marca</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($productos as $producto)
                <tr>
                    <td>{{ $producto->id }}</td>
                    <td>
                        @if($producto->ruta_grabado && file_exists(public_path('storage/' . $producto->ruta_grabado)))
                            <img src="{{ asset('storage/' . $producto->ruta_grabado) }}" alt="{{ $producto->nombre }}" width="60" height="60" style="object-fit: cover;">
                        @else
                            <span class="text-muted">Sin imagen</span>
                        @endif
                    </td>
                    <td>{{ $producto->nombre }}</td>
                    <td><span class="badge bg-secondary">{{ ucfirst($producto->categoria) }}</span></td>
                    <td>{{ $producto->marca }}</td>
                    <td>{{ number_format($producto->precio, 2) }} €</td>
                    <td>{{ $producto->stock }}</td>
                    <td>
                        <a href="{{ route('productos.edit', $producto) }}" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('productos.destroy', $producto) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar este producto?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center">No hay productos registrados.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center">
        {{ $productos->links() }}
    </div>
</div>

@endsection
