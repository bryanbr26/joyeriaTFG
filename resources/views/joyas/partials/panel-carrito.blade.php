@php
    $cartItems = collect();
    $totalPrice = 0;
    if(Auth::check()) {
        $cartItems = \App\Models\Carrito::with('producto')->where('id_usuario', Auth::id())->get();
        foreach($cartItems as $item) {
            $totalPrice += $item->producto->precio * $item->cantidad;
        }
    }
@endphp

<div class="panel-carrito" id="panelCarrito">
    <div class="panel-header">
        <h3>Tu Cesta</h3>
        <button type="button" class="btn-close" id="closeCarrito"></button>
    </div>
    
    <div class="carrito-grid-mini" style="overflow-y: auto; flex: 1; padding-right: 0.5rem;">
        <div class="panel-cart-items">
            @forelse($cartItems as $item)
                <div class="item-box" id="panel-item-{{ $item->id }}">
                    <div class="item-grid">
                        <div class="item-panel-image">
                            @if($item->producto->imagen_principal_url)
                                <img src="{{ $item->producto->imagen_principal_url }}"
                                     alt="{{ $item->producto->nombre }}" class="lazy-image blur-up item-img"
                                     loading="lazy" decoding="async">
                            @else
                                <div class="item-image-placeholder">
                                    <i class="bi bi-gem text-muted fs-4"></i>
                                </div>
                            @endif
                        </div>
                        <div class="item-details">
                            <h5 class="item-title">
                                {{ $item->producto->nombre }}
                            </h5>
                            @if($item->ruta_grabado_personalizado)
                                <span class="badge-personalizado">
                                    <i class="bi bi-brush me-1"></i>Personalizado
                                </span>
                            @endif
                            <div class="item-price-cantidad">
                                <span class="item-precio">{{ number_format($item->producto->precio * $item->cantidad, 2) }}€</span>
                                <small class="item-cantidad">Cant: {{ $item->cantidad }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="carrito-vacio">
                    <i class="bi bi-cart-x fs-1 d-block mb-3"></i>
                    <p>Tu cesta está vacía</p>
                </div>
            @endforelse
        </div>
    </div>

    <div class="panel-footer">
        <div class="subtotal-grid">
            <span>Subtotal:</span>
            <span>{{ number_format($totalPrice, 2) }}€</span>
        </div>
        <div class="botones-grid">
            <a href="{{ route('carrito.index') }}" class="btn-ver-carrito">Ver carrito</a>
            <button type="button" class="btn-seguir-comprando" id="btnSeguirComprando">Seguir comprando</button>
        </div>
    </div>
</div>
<div class="panel-overlay" id="panelOverlayCarrito"></div>
