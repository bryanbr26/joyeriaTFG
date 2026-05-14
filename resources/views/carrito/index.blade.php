@extends("layouts.layout")

@section("title", "Mi Cesta")

@section("content")

<div class="fondo-carrito">
    <div class="carrito-bg">

        <h2 class="titulo-cesta">Tu Cesta</h2>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
                <button type="button" class="alert-close" onclick="this.parentElement.remove()">×</button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
                <button type="button" class="alert-close" onclick="this.parentElement.remove()">×</button>
            </div>
        @endif

        <div class="carrito-grid">
            <div class="cart-items">
                
                @forelse($items as $item)
                    <div class="item-box" id="item-{{ $item->id }}">
                        <!-- Img Container -->
                        <div class="item-image">
                            @if($item->producto->ruta_grabado && file_exists(public_path('storage/' . $item->producto->ruta_grabado)))
                                <img src="{{ asset('storage/' . $item->producto->ruta_grabado) }}" 
                                     alt="{{ $item->producto->nombre }}" class="img-full">
                            @else
                                <i class="bi bi-gem text-muted icon-placeholder"></i>
                            @endif
                        </div>

                        <!-- Detalles Container -->
                        <div class="item-details">
                            <div class="item-header">
                                <div class="item-info">
                                    <h5 class="item-title">
                                        {{ $item->producto->nombre }}
                                        @if($item->ruta_grabado_personalizado)
                                            <span class="badge-personalizado">
                                                <i class="bi bi-brush"></i>Personalizado
                                            </span>
                                        @endif
                                    </h5>
                                    <p class="item-desc">{{ Str::limit($item->producto->descripcion, 70) }}</p>
                                    @if($item->ruta_grabado_personalizado && file_exists(public_path('storage/' . $item->ruta_grabado_personalizado)))
                                        <a href="{{ asset('storage/' . $item->ruta_grabado_personalizado) }}" target="_blank" class="grabado-link">
                                            <img src="{{ asset('storage/' . $item->ruta_grabado_personalizado) }}" alt="Grabado" class="grabado-img">
                                            <small>Ver grabado</small>
                                        </a>
                                    @endif
                                </div>
                                <div class="item-precio">
                                    <div class="precio-total" id="subtotal-{{ $item->id }}">
                                        {{ number_format($item->producto->precio * $item->cantidad, 2) }}€
                                    </div>
                                    <small class="precio-unitario">{{ number_format($item->producto->precio, 2) }}€/ud</small>
                                </div>
                            </div>
                            
                            <div class="item-footer">
                                <form action="{{ route('carrito.eliminar', $item->id) }}" method="POST" onsubmit="return confirm('¿Seguro que quieres eliminar este producto?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-eliminar">Eliminar</button>
                                </form>
                                
                                <div class="cantidad-control">
                                    <span class="cantidad-label">Cantidad</span>
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
                                    <small class="stock-info" id="stock-info-{{ $item->id }}">({{ $item->maxDisponible }} máx.)</small>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="cesta-vacia">
                        <h4>Tu cesta está vacía</h4>
                        <a href="{{ route('index') }}" class="btn-seguir-comprando">Seguir comprando</a>
                    </div>
                @endforelse

            </div>

            @if($items->count() > 0)
                <!-- Panel de Pago -->
                <div class="cart-pago">
                    <div class="checkout-section">
                        <div class="total-label">
                            <p class="total-title">Resumen del pedido</p>
                            <div class="total-row">
                                <span>Subtotal:</span>
                                <span class="total-amount">{{ number_format($totalPrice, 2) }}€</span>
                            </div>
                            <div class="total-row">
                                <span>Envío:</span>
                                <span>3,50€</span>
                            </div>
                            <div class="total-row total-final">
                                <span>Total:</span>
                                <span class="total-amount">{{ number_format($totalPrice + 3.50, 2) }}€</span>
                            </div>
                        </div>
                        <form action="{{ route('carrito.checkout') }}" method="POST" onsubmit="return confirm('¿Confirmar compra por {{ number_format($totalPrice, 2) }}€?')">
                            @csrf
                            <button type="submit" class="btn-checkout">
                                <i class="bi bi-bag-check"></i>Pago 
                            </button>
                        </form>
                    </div>
                </div>
            @endif
                
        </div>
    </div>
</div>

@push('scripts')
    <script src="{{ mix('js/pages/panel-carrito.js') }}" defer></script>
@endpush

@endsection