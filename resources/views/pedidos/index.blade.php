@extends("layouts.layout")

@section("title", "Historial de Pedidos")

@section("content")

<style>
    .pedidos-bg {
        background-color: #f8f9fa;
        min-height: 80vh;
        padding: 40px 0;
    }

    .pedido-card {
        border: 2px solid #dee2e6;
        background-color: white;
        padding: 20px;
        margin-bottom: 20px;
    }

    .estado-pendiente { color: #ffc107; }
    .estado-preparado { color: #17a2b8; }
    .estado-enviado { color: #007bff; }
    .estado-entregado { color: #28a745; }
    .estado-cancelado { color: #dc3545; }
</style>

<div class="pedidos-bg">
    <div class="container">
        
        <!-- Botón de volver atrás -->
        <a href="{{ route('carrito.index') }}" class="btn btn-outline-dark mb-4">
            <i class="bi bi-arrow-left me-2"></i>Volver a la cesta
        </a>

        <h2 class="text-dark text-center mb-4" style="font-family: 'Italiana', serif;">Historial de Pedidos</h2>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row justify-content-center">
            <div class="col-lg-8">
                
                @forelse($pedidos as $pedido)
                    <div class="pedido-card">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h5 class="fw-bold mb-1">Pedido #{{ $pedido->id }}</h5>
                                <p class="text-muted small mb-0">
                                    <i class="bi bi-calendar3 me-1"></i>
                                    {{ $pedido->fecha ? \Carbon\Carbon::parse($pedido->fecha)->format('d/m/Y H:i') : 'Sin fecha' }}
                                </p>
                            </div>
                            <div class="text-end">
                                <span class="fw-bold fs-5">{{ number_format($pedido->total, 2) }}€</span>
                                <br>
                                @php
                                    $estadoClase = 'estado-' . $pedido->estado;
                                @endphp
                                <span class="badge bg-light border {{ $estadoClase }} fw-semibold px-3 py-2 mt-1">
                                    <i class="bi bi-circle-fill me-1" style="font-size: 0.5rem;"></i>
                                    {{ ucfirst($pedido->estado) }}
                                </span>
                            </div>
                        </div>
                        
                        <!-- Resumen de productos -->
                        <div class="border-top pt-3">
                            <p class="text-muted small fw-semibold mb-2">{{ $pedido->detalles->count() }} producto(s)</p>
                            @foreach($pedido->detalles->take(3) as $detalle)
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="small">
                                        {{ $detalle->producto ? $detalle->producto->nombre : 'Producto eliminado' }}
                                        <span class="text-muted">× {{ $detalle->cantidad }}</span>
                                    </span>
                                    <span class="small fw-semibold">{{ number_format($detalle->precio_unitario * $detalle->cantidad, 2) }}€</span>
                                </div>
                            @endforeach
                            @if($pedido->detalles->count() > 3)
                                <span class="text-muted small">y {{ $pedido->detalles->count() - 3 }} más...</span>
                            @endif
                        </div>

                        <div class="text-end mt-3">
                            <a href="{{ route('pedidos.show', $pedido->id) }}" class="btn btn-outline-dark btn-sm rounded-pill px-3">
                                <i class="bi bi-eye me-1"></i>Ver detalles
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="text-center p-5 text-muted" style="border: 2px dashed #ced4da;">
                        <i class="bi bi-bag" style="font-size: 3rem;"></i>
                        <h4 class="mt-3">No tienes pedidos</h4>
                        <p>Cuando realices una compra, aparecerá aquí.</p>
                        <a href="{{ route('index') }}" class="btn btn-dark mt-2">Explorar joyas</a>
                    </div>
                @endforelse
                
            </div>
        </div>
    </div>
</div>

@endsection
