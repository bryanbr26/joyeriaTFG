@extends("layouts.layout")

@section("title", "Pedido #" . $pedido->id)

@section("content")

<style>
    .pedido-bg {
        background-color: #f8f9fa;
        min-height: 80vh;
        padding: 40px 0;
    }

    .detalle-box {
        border: 2px solid #dee2e6;
        background-color: transparent;
        padding: 20px;
        margin-bottom: 20px;
        display: flex;
        gap: 20px;
    }

    .detalle-image {
        background-color: white;
        border: 1px solid #e9ecef;
        width: 100px;
        height: 100px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .detalle-info {
        background-color: white;
        border: 1px solid #e9ecef;
        flex-grow: 1;
        padding: 15px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .estado-pendiente { color: #ffc107; }
    .estado-preparado { color: #17a2b8; }
    .estado-enviado { color: #007bff; }
    .estado-entregado { color: #28a745; }
    .estado-cancelado { color: #dc3545; }

    @media (max-width: 768px) {
        .detalle-box {
            flex-direction: column;
        }
        .detalle-image {
            width: 100%;
            height: 150px;
        }
    }
</style>

<div class="pedido-bg">
    <div class="container">
        
        <!-- Botón de volver -->
        <a href="{{ route('pedidos.index') }}" class="btn btn-outline-dark mb-4">
            <i class="bi bi-arrow-left me-2"></i>Volver al historial
        </a>

        <h2 class="text-dark text-center mb-2" style="font-family: 'Italiana', serif;">Pedido #{{ $pedido->id }}</h2>

        <div class="row justify-content-center">
            <div class="col-lg-8">

                <!-- Info general del pedido -->
                <div class="bg-white border p-4 mb-4">
                    <div class="row">
                        <div class="col-md-4 mb-2">
                            <p class="text-muted small mb-1">Fecha</p>
                            <p class="fw-semibold mb-0">
                                {{ $pedido->fecha ? \Carbon\Carbon::parse($pedido->fecha)->format('d/m/Y H:i') : 'Sin fecha' }}
                            </p>
                        </div>
                        <div class="col-md-4 mb-2">
                            <p class="text-muted small mb-1">Estado</p>
                            @php
                                $estadoClase = 'estado-' . $pedido->estado;
                            @endphp
                            <span class="badge bg-light border {{ $estadoClase }} fw-semibold px-3 py-2">
                                <i class="bi bi-circle-fill me-1" style="font-size: 0.5rem;"></i>
                                {{ ucfirst($pedido->estado) }}
                            </span>
                        </div>
                        <div class="col-md-4 mb-2">
                            <p class="text-muted small mb-1">Total</p>
                            <p class="fw-bold fs-5 mb-0">{{ number_format($pedido->total, 2) }}€</p>
                        </div>
                    </div>
                </div>

                <!-- Productos del pedido -->
                <h5 class="fw-bold mb-3">Productos</h5>

                @foreach($pedido->detalles as $detalle)
                    <div class="detalle-box">
                        <!-- Imagen -->
                        <div class="detalle-image">
                            @if($detalle->producto && $detalle->producto->ruta_grabado && file_exists(public_path('storage/' . $detalle->producto->ruta_grabado)))
                                <img src="{{ asset('storage/' . $detalle->producto->ruta_grabado) }}" 
                                     alt="{{ $detalle->producto->nombre }}" class="img-fluid" style="object-fit: cover; width: 100%; height: 100%;">
                            @else
                                <i class="bi bi-gem text-muted" style="font-size: 2rem;"></i>
                            @endif
                        </div>

                        <!-- Info -->
                        <div class="detalle-info">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="fw-bold mb-1">{{ $detalle->producto ? $detalle->producto->nombre : 'Producto eliminado' }}</h6>
                                    @if($detalle->producto)
                                        <p class="text-muted small mb-0">{{ $detalle->producto->marca }}</p>
                                    @endif
                                </div>
                                <div class="text-end ms-3">
                                    <div class="fw-bold" style="white-space: nowrap;">
                                        {{ number_format($detalle->precio_unitario * $detalle->cantidad, 2) }}€
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-end mt-2">
                                <span class="text-muted small">{{ number_format($detalle->precio_unitario, 2) }}€/ud</span>
                                <span class="fw-semibold small">Cantidad: {{ $detalle->cantidad }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach

                <!-- Total -->
                <div class="bg-white border p-3 text-end mt-3">
                    <span class="fs-5 fw-bold">Total del pedido: {{ number_format($pedido->total, 2) }}€</span>
                </div>
                
            </div>
        </div>
    </div>
</div>

@endsection
