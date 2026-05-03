@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <div class="admin-page-header">
        <div>
            <p class="admin-eyebrow">Panel de control</p>
            <h1>Dashboard</h1>
            <span class="text-muted">{{ $filtros['periodoLabel'] }}</span>
        </div>
        <a href="{{ route('admin.productos.create') }}" class="btn btn-dark">
            <i class="bi bi-plus-lg me-1"></i>
            Nuevo producto
        </a>
    </div>

    <section class="admin-panel mb-4">
        <form action="{{ route('admin.dashboard') }}" method="GET" class="admin-filter-bar">
            <select name="periodo" class="form-select">
                <option value="mes" {{ $filtros['periodo'] === 'mes' ? 'selected' : '' }}>Mes concreto</option>
                <option value="anio" {{ $filtros['periodo'] === 'anio' ? 'selected' : '' }}>Año completo</option>
                <option value="todo" {{ $filtros['periodo'] === 'todo' ? 'selected' : '' }}>Histórico completo</option>
            </select>

            <select name="mes" class="form-select">
                @foreach([
                    1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
                    5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
                    9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
                ] as $numeroMes => $nombreMes)
                    <option value="{{ $numeroMes }}" {{ $filtros['mes'] === $numeroMes ? 'selected' : '' }}>{{ $nombreMes }}</option>
                @endforeach
            </select>

            <select name="anio" class="form-select">
                @foreach($filtros['aniosDisponibles'] as $anioDisponible)
                    <option value="{{ $anioDisponible }}" {{ $filtros['anio'] === (int) $anioDisponible ? 'selected' : '' }}>{{ $anioDisponible }}</option>
                @endforeach
            </select>

            <button type="submit" class="btn btn-outline-dark">
                <i class="bi bi-funnel me-1"></i>
                Aplicar
            </button>
        </form>
    </section>

    <section class="admin-stat-grid">
        <article class="admin-stat-card">
            <span>Usuarios</span>
            <strong>{{ $stats['usuarios'] }}</strong>
            <small>Total registrados</small>
        </article>
        <article class="admin-stat-card">
            <span>Stock bajo</span>
            <strong>{{ $stats['stockBajo'] }}</strong>
            <small><a href="#stock-bajo" class="text-dark fw-semibold">Ver más</a></small>
        </article>
        <article class="admin-stat-card">
            <span>Ventas</span>
            <strong>{{ number_format($stats['ventas'], 2) }}€</strong>
            <small>Facturación del periodo</small>
        </article>
    </section>

    <section class="admin-panel-grid">
        <article class="admin-panel">
            <div class="admin-panel-header">
                <h2>Últimos pedidos del periodo</h2>
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
                <h2>Productos más vendidos</h2>
                <a href="{{ route('admin.productos.index') }}">Gestionar</a>
            </div>

            <div class="admin-stock-list">
                @forelse($productosMasVendidos as $producto)
                    <div class="admin-stock-item">
                        <div>
                            <strong>{{ $producto->nombre }}</strong>
                            <span>{{ ucfirst($producto->categoria) }} · {{ number_format($producto->total, 2) }}€</span>
                        </div>
                        <span class="badge bg-dark">
                            {{ $producto->unidades }} uds.
                        </span>
                    </div>
                @empty
                    <p class="text-muted mb-0">No hay ventas en este periodo.</p>
                @endforelse
            </div>
        </article>
    </section>

    <section class="admin-panel mt-4" id="stock-bajo">
        <div class="admin-panel-header">
            <h2>Stock bajo actual</h2>
            <a href="{{ route('admin.productos.index') }}">Revisar catálogo</a>
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
    </section>
@endsection
