@extends('layouts.admin')

@section('title', 'Pedidos')

@section('content')
    <div class="admin-page-header">
        <div>
            <p class="admin-eyebrow">Ventas</p>
            <h1>Pedidos</h1>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <section class="admin-panel">
        <form action="{{ route('admin.pedidos.index') }}" method="GET" class="admin-filter-bar">
            <select name="estado" class="form-select">
                <option value="">Todos los estados</option>
                @foreach(['pendiente', 'preparado', 'enviado', 'entregado', 'cancelado'] as $estado)
                    <option value="{{ $estado }}" {{ request('estado') === $estado ? 'selected' : '' }}>{{ ucfirst($estado) }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-outline-dark">
                <i class="bi bi-filter me-1"></i>
                Filtrar
            </button>
        </form>

        <div class="table-responsive">
            <table class="table align-middle admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cliente</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                        <th>Total</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pedidos as $pedido)
                        <tr>
                            <td>#{{ $pedido->id }}</td>
                            <td>{{ $pedido->usuario->nombre ?? 'Sin usuario' }}</td>
                            <td>{{ $pedido->fecha ? \Carbon\Carbon::parse($pedido->fecha)->format('d/m/Y H:i') : 'Sin fecha' }}</td>
                            <td><span class="badge bg-secondary">{{ ucfirst($pedido->estado ?? 'pendiente') }}</span></td>
                            <td>{{ number_format($pedido->total, 2) }}€</td>
                            <td>
                                <div class="admin-actions">
                                    <a href="{{ route('admin.pedidos.show', $pedido) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <form action="{{ route('admin.pedidos.destroy', $pedido) }}" method="POST" onsubmit="return confirm('¿Eliminar este pedido?')">
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
                            <td colspan="6" class="text-muted">No hay pedidos.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $pedidos->links() }}
        </div>
    </section>
@endsection
