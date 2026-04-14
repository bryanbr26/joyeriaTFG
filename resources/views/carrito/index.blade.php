@extends("layouts.layout")

@section("title", "Mi Cesta")

@section("content")

<style>
    .carrito-bg {
        background-color: #f8f9fa;
        min-height: 80vh;
        padding: 40px 0;
    }
    
    .item-box {
        border: 2px solid #dee2e6;
        background-color: transparent;
        padding: 20px;
        margin-bottom: 30px;
        display: flex;
        gap: 20px;
    }

    .item-image {
        background-color: white;
        border: 1px solid #e9ecef;
        width: 150px;
        height: 150px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .item-details {
        background-color: white;
        border: 1px solid #e9ecef;
        flex-grow: 1;
        padding: 20px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .qty-control {
        display: flex;
        align-items: center;
        gap: 0;
    }

    .qty-control button {
        width: 32px;
        height: 32px;
        border: 1px solid #dee2e6;
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 14px;
        font-weight: bold;
    }

    .qty-control button:hover {
        background-color: #f8f9fa;
    }

    .qty-control button:disabled {
        opacity: 0.4;
        cursor: not-allowed;
    }

    .qty-control .qty-value {
        width: 40px;
        height: 32px;
        border-top: 1px solid #dee2e6;
        border-bottom: 1px solid #dee2e6;
        border-left: none;
        border-right: none;
        text-align: center;
        font-weight: 600;
        font-size: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: white;
    }

    /* Responsividad básica */
    @media (max-width: 768px) {
        .item-box {
            flex-direction: column;
        }
        .item-image {
            width: 100%;
            height: 200px;
        }
    }
</style>

<div class="carrito-bg">
    <div class="container">
        
        <!-- Botones superiores -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="javascript:history.back()" class="btn btn-outline-dark">
                <i class="bi bi-arrow-left me-2"></i>Volver atrás
            </a>
            <a href="{{ route('pedidos.index') }}" class="btn btn-outline-dark">
                <i class="bi bi-clock-history me-2"></i>Historial de pedidos
            </a>
        </div>

        <h2 class="text-dark text-center mb-4" style="font-family: 'Italiana', serif;">Tu Cesta</h2>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-4">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row justify-content-center">
            <div class="col-lg-8">
                
                @forelse($items as $item)
                    <div class="item-box" id="item-{{ $item->id }}">
                        <!-- Img Container -->
                        <div class="item-image">
                            @if($item->producto->ruta_grabado && file_exists(public_path('storage/' . $item->producto->ruta_grabado)))
                                <img src="{{ asset('storage/' . $item->producto->ruta_grabado) }}" 
                                     alt="{{ $item->producto->nombre }}" class="img-fluid" style="object-fit: cover; width: 100%; height: 100%;">
                            @else
                                <i class="bi bi-gem text-muted" style="font-size: 3rem;"></i>
                            @endif
                        </div>

                        <!-- Detalles Container -->
                        <div class="item-details">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h5 class="fw-bold mb-1">
                                        {{ $item->producto->nombre }}
                                        @if($item->ruta_grabado_personalizado)
                                            <span class="badge bg-dark ms-2" style="font-size: 0.65rem;">
                                                <i class="bi bi-brush me-1"></i>Personalizado
                                            </span>
                                        @endif
                                    </h5>
                                    <p class="text-muted small mb-0">{{ Str::limit($item->producto->descripcion, 70) }}</p>
                                    @if($item->ruta_grabado_personalizado && file_exists(public_path('storage/' . $item->ruta_grabado_personalizado)))
                                        <a href="{{ asset('storage/' . $item->ruta_grabado_personalizado) }}" target="_blank" class="d-inline-block mt-2">
                                            <img src="{{ asset('storage/' . $item->ruta_grabado_personalizado) }}" alt="Grabado" 
                                                 style="height: 50px; border: 1px solid #dee2e6; border-radius: 4px;">
                                            <small class="d-block text-muted">Ver grabado</small>
                                        </a>
                                    @endif
                                </div>
                                <div class="text-end ms-3">
                                    <div class="fw-bold fs-5" style="white-space: nowrap;" id="subtotal-{{ $item->id }}">
                                        {{ number_format($item->producto->precio * $item->cantidad, 2) }}€
                                    </div>
                                    <small class="text-muted">{{ number_format($item->producto->precio, 2) }}€/ud</small>
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-between align-items-end mt-4">
                                <form action="{{ route('carrito.eliminar', $item->id) }}" method="POST" onsubmit="return confirm('¿Seguro que quieres eliminar este producto?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-secondary btn-sm rounded-pill px-3 fw-semibold">Eliminar</button>
                                </form>
                                
                                <div class="d-flex align-items-center gap-2">
                                    <span class="fw-semibold text-muted small">Cantidad</span>
                                    <div class="qty-control">
                                        <button type="button" class="btn-qty-minus" 
                                                data-item-id="{{ $item->id }}"
                                                {{ $item->cantidad <= 1 ? 'disabled' : '' }}>−</button>
                                        <div class="qty-value" id="qty-{{ $item->id }}">{{ $item->cantidad }}</div>
                                        <button type="button" class="btn-qty-plus" 
                                                data-item-id="{{ $item->id }}"
                                                data-max-stock="{{ $item->maxDisponible }}"
                                                {{ $item->cantidad >= $item->maxDisponible ? 'disabled' : '' }}>+</button>
                                    </div>
                                    <small class="text-muted" id="stock-info-{{ $item->id }}">({{ $item->maxDisponible }} máx.)</small>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center p-5 text-muted" style="border: 2px dashed #ced4da;">
                        <h4>Tu cesta está vacía</h4>
                        <a href="{{ route('index') }}" class="btn btn-dark mt-3">Seguir comprando</a>
                    </div>
                @endforelse

                @if($items->count() > 0)
                    <!-- Total y Checkout -->
                    <div class="text-center mt-4 mb-2">
                        <p class="fs-5 fw-semibold text-muted mb-1">Total: <span class="text-dark" id="totalPrice">{{ number_format($totalPrice, 2) }}€</span></p>
                    </div>
                    <div class="d-flex justify-content-center mt-2 mb-4">
                        <form action="{{ route('carrito.checkout') }}" method="POST" onsubmit="return confirm('¿Confirmar compra por {{ number_format($totalPrice, 2) }}€?')">
                            @csrf
                            <button type="submit" class="btn btn-dark btn-lg px-5 py-3 rounded-0 fw-bold fs-5 shadow" style="min-width: 300px;">
                                <i class="bi bi-bag-check me-2"></i>Pasar por caja [<span id="totalItems">{{ $totalItems }}</span>]
                            </button>
                        </form>
                    </div>
                @endif
                
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        function actualizarCantidad(itemId, nuevaCantidad) {
            fetch(`/carrito/${itemId}/cantidad`, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ cantidad: nuevaCantidad })
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    // Actualizar cantidad mostrada del item modificado
                    document.getElementById('qty-' + itemId).textContent = data.cantidad;
                    // Actualizar subtotal del item
                    document.getElementById('subtotal-' + itemId).textContent = data.subtotal + '€';
                    // Actualizar total general
                    document.getElementById('totalPrice').textContent = data.totalPrice + '€';
                    document.getElementById('totalItems').textContent = data.totalItems;

                    // Actualizar botones de TODAS las líneas del mismo producto
                    if (data.itemsActualizados) {
                        data.itemsActualizados.forEach(function(linea) {
                            const minusBtn = document.querySelector(`.btn-qty-minus[data-item-id="${linea.id}"]`);
                            const plusBtn = document.querySelector(`.btn-qty-plus[data-item-id="${linea.id}"]`);
                            const stockInfo = document.getElementById('stock-info-' + linea.id);

                            if (minusBtn) minusBtn.disabled = (linea.cantidad <= 1);
                            if (plusBtn) {
                                plusBtn.dataset.maxStock = linea.maxDisponible;
                                plusBtn.disabled = (linea.cantidad >= linea.maxDisponible);
                            }
                            if (stockInfo) stockInfo.textContent = '(' + linea.maxDisponible + ' máx.)';
                        });
                    }
                }
            })
            .catch(err => {
                console.error('Error:', err);
            });
        }

        // Botones de incrementar/decrementar cantidad
        document.querySelectorAll('.btn-qty-minus').forEach(btn => {
            btn.addEventListener('click', function() {
                const itemId = this.dataset.itemId;
                const currentQty = parseInt(document.getElementById('qty-' + itemId).textContent);
                if (currentQty > 1) {
                    actualizarCantidad(itemId, currentQty - 1);
                }
            });
        });

        document.querySelectorAll('.btn-qty-plus').forEach(btn => {
            btn.addEventListener('click', function() {
                const itemId = this.dataset.itemId;
                const currentQty = parseInt(document.getElementById('qty-' + itemId).textContent);
                const maxStock = parseInt(this.dataset.maxStock);
                if (currentQty < maxStock) {
                    actualizarCantidad(itemId, currentQty + 1);
                }
            });
        });
    });
</script>

@endsection
