@extends('layouts.admin')

@section('title', 'Productos')

@section('content')
    <div class="admin-page-header">
        <div>
            <p class="admin-eyebrow">Catálogo</p>
            <h1>Productos</h1>
        </div>
        <a href="{{ route('admin.productos.create') }}" class="btn btn-dark">
            <i class="bi bi-plus-lg me-1"></i>
            Nuevo producto
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <section class="admin-panel">
        <form action="{{ route('admin.productos.index') }}" method="GET" class="admin-filter-bar">
            <input type="search" name="buscar" class="form-control" placeholder="Buscar por nombre o marca" value="{{ request('buscar') }}">
            <select name="categoria" class="form-select">
                <option value="">Todas las categorías</option>
                <option value="anillo" {{ request('categoria') === 'anillo' ? 'selected' : '' }}>Anillos</option>
                <option value="pulsera" {{ request('categoria') === 'pulsera' ? 'selected' : '' }}>Pulseras</option>
                <option value="pendiente" {{ request('categoria') === 'pendiente' ? 'selected' : '' }}>Pendientes</option>
                <option value="collar" {{ request('categoria') === 'collar' ? 'selected' : '' }}>Collares</option>
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
                        <th>Imagen</th>
                        <th>Producto</th>
                        <th>Categoría</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($productos as $producto)
                        <tr>
                            <td>
                                @if($producto->imagen_principal_url)
                                    <img src="{{ $producto->imagen_principal_url }}" alt="{{ $producto->nombre }}" class="admin-product-thumb">
                                @else
                                    <span class="text-muted">Sin imagen</span>
                                @endif
                            </td>
                            <td>
                                <strong>{{ $producto->nombre }}</strong>
                                <span class="d-block text-muted small">{{ $producto->marca }}</span>
                            </td>
                            <td><span class="badge bg-secondary">{{ ucfirst($producto->categoria) }}</span></td>
                            <td>{{ number_format($producto->precio, 2) }}€</td>
                            <td>
                                <form action="{{ route('admin.productos.stock', $producto) }}" method="POST" class="d-flex gap-2" style="max-width: 150px;">
                                    @csrf
                                    @method('PATCH')
                                    <input type="number" name="stock" value="{{ $producto->stock }}" min="0" class="form-control form-control-sm">
                                    <button class="btn btn-sm btn-outline-dark" title="Guardar stock">
                                        <i class="bi bi-check-lg"></i>
                                    </button>
                                </form>
                            </td>
                            <td>
                                <div class="admin-actions">
                                    <a href="{{ route('admin.productos.edit', $producto) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.productos.destroy', $producto) }}" method="POST" onsubmit="return confirm('¿Eliminar este producto?')">
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
                            <td colspan="6" class="text-muted">No hay productos.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $productos->links() }}
        </div>
    </section>
@endsection
