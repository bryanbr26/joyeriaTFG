@extends('layouts.admin')

@section('title', 'Pedido #' . $pedido->id)

@section('content')
    <div class="admin-page-header">
        <div>
            <p class="admin-eyebrow">Ventas</p>
            <h1>Pedido #{{ $pedido->id }}</h1>
        </div>
        <a href="{{ route('admin.pedidos.index') }}" class="btn btn-outline-dark">
            <i class="bi bi-arrow-left me-1"></i>
            Volver
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <section class="admin-panel mb-4">
        <div class="row g-3 align-items-end">
            <div class="col-md-3">
                <span class="text-muted small d-block">Cliente</span>
                <strong>{{ $pedido->usuario->nombre ?? 'Sin usuario' }}</strong>
            </div>
            <div class="col-md-3">
                <span class="text-muted small d-block">Fecha</span>
                <strong>{{ $pedido->fecha ? \Carbon\Carbon::parse($pedido->fecha)->format('d/m/Y H:i') : 'Sin fecha' }}</strong>
            </div>
            <div class="col-md-3">
                <span class="text-muted small d-block">Total</span>
                <strong>{{ number_format($pedido->total, 2) }}€</strong>
            </div>
            <div class="col-md-3">
                <form action="{{ route('admin.pedidos.estado', $pedido) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <label for="estado" class="form-label">Estado</label>
                    <div class="d-flex gap-2">
                        <select id="estado" name="estado" class="form-select">
                            @foreach(['pendiente', 'preparado', 'enviado', 'entregado', 'cancelado'] as $estado)
                                <option value="{{ $estado }}" {{ $pedido->estado === $estado ? 'selected' : '' }}>{{ ucfirst($estado) }}</option>
                            @endforeach
                        </select>
                        <button class="btn btn-dark">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <section class="admin-panel">
        <div class="admin-panel-header">
            <h2>Productos del pedido</h2>
        </div>

        <div class="table-responsive">
            <table class="table align-middle admin-table">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio unitario</th>
                        <th>Subtotal</th>
                        <th>Grabado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pedido->detalles as $detalle)
                        <tr>
                            <td>
                                <strong>{{ $detalle->producto->nombre ?? 'Producto eliminado' }}</strong>
                                @if($detalle->producto)
                                    <span class="d-block text-muted small">{{ $detalle->producto->marca }}</span>
                                @endif
                            </td>
                            <td>{{ $detalle->cantidad }}</td>
                            <td>{{ number_format($detalle->precio_unitario, 2) }}€</td>
                            <td>{{ number_format($detalle->precio_unitario * $detalle->cantidad, 2) }}€</td>
                            <td>
                                @if($detalle->ruta_grabado_personalizado)
                                    <a href="{{ asset('storage/' . $detalle->ruta_grabado_personalizado) }}" target="_blank">Ver grabado</a>
                                @else
                                    <span class="text-muted">No</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
@endsection
