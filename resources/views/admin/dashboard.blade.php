@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <section class="admin-stat-grid">
        <article class="admin-stat-card">
            <span>Usuarios</span>
            <strong>{{ $stats['usuarios'] }}</strong>
            <small>Total registrados</small>
        </article>
        <article class="admin-stat-card">
            <span>Productos</span>
            <strong>{{ $stats['productos'] }}</strong>
            <small>Joyas en catálogo</small>
        </article>
        <article class="admin-stat-card">
            <span>Pedidos</span>
            <strong>{{ $stats['pedidos'] }}</strong>
            <small>Histórico de compras</small>
        </article>
        <article class="admin-stat-card">
            <span>Carrito</span>
            <strong>{{ $stats['itemsCarrito'] }}</strong>
            <small>Unidades pendientes</small>
        </article>
        <article class="admin-stat-card">
            <span>Stock bajo</span>
            <strong>{{ $stats['stockBajo'] }}</strong>
            <small>Productos con 5 o menos</small>
        </article>
        <article class="admin-stat-card">
            <span>Ventas</span>
            <strong>{{ number_format($stats['ventas'], 2) }}€</strong>
            <small>Total acumulado</small>
        </article>
    </section>

    <section class="admin-panel-grid">
        <article class="admin-panel">
            <div class="admin-panel-header">
                <h2>Últimos pedidos</h2>
                <a href="{{ route('admin.pedidos.index') }}">Ver todos</a>
            </div>

            <div class="table-responsive">
                <table class="table align-middle admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Cliente</th>
                            <th>Estado</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ultimosPedidos as $pedido)
                            <tr>
                                <td><a href="{{ route('admin.pedidos.show', $pedido) }}">#{{ $pedido->id }}</a></td>
                                <td>{{ $pedido->usuario->nombre ?? 'Sin usuario' }}</td>
                                <td><span class="badge bg-secondary">{{ ucfirst($pedido->estado ?? 'pendiente') }}</span></td>
                                <td>{{ number_format($pedido->total, 2) }}€</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-muted">Aún no hay pedidos.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </article>

        <article class="admin-panel">
            <div class="admin-panel-header">
                <h2>Stock bajo</h2>
                <a href="{{ route('admin.productos.index') }}">Gestionar</a>
            </div>

            <div class="admin-stock-list">
                @forelse($productosStockBajo as $producto)
                    <div class="admin-stock-item">
                        <div>
                            <strong>{{ $producto->nombre }}</strong>
                            <span>{{ ucfirst($producto->categoria) }}</span>
                        </div>
                        <span class="badge {{ $producto->stock <= 2 ? 'bg-danger' : 'bg-warning text-dark' }}">
                            {{ $producto->stock }} uds.
                        </span>
                    </div>
                @empty
                    <p class="text-muted mb-0">No hay productos con stock bajo.</p>
                @endforelse
            </div>
        </article>
    </section>
@endsection
