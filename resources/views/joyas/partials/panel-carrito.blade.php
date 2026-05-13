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
        <div class="cart-items">
            @forelse($cartItems as $item)
                <div class="item-box p-3 mb-3 border rounded shadow-sm bg-white" id="panel-item-{{ $item->id }}">
                    <div class="d-flex gap-3">
                        <div class="item-image" style="width: 80px; height: 80px; flex-shrink: 0;">
                            @if($item->producto->ruta_grabado && file_exists(public_path('storage/' . $item->producto->ruta_grabado)))
                                <img src="{{ asset('storage/' . $item->producto->ruta_grabado) }}" 
                                     alt="{{ $item->producto->nombre }}" class="img-fluid rounded" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center h-100 rounded">
                                    <i class="bi bi-gem text-muted fs-4"></i>
                                </div>
                            @endif
                        </div>
                        <div class="item-details flex-grow-1">
                            <h5 class="item-title fs-6 mb-1 text-truncate" style="max-width: 180px;">
                                {{ $item->producto->nombre }}
                            </h5>
                            @if($item->ruta_grabado_personalizado)
                                <span class="badge bg-primary text-white x-small"><i class="bi bi-brush me-1"></i>Personalizado</span>
                            @endif
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <span class="fw-bold">{{ number_format($item->producto->precio * $item->cantidad, 2) }}€</span>
                                <small class="text-muted">Cant: {{ $item->cantidad }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center my-5 text-muted">
                    <i class="bi bi-cart-x fs-1 d-block mb-3"></i>
                    <p>Tu cesta está vacía</p>
                </div>
            @endforelse
        </div>
    </div>

    <div class="panel-footer mt-auto pt-3 border-top">
        <div class="d-flex justify-content-between fw-bold mb-3 fs-5">
            <span>Subtotal:</span>
            <span>{{ number_format($totalPrice, 2) }}€</span>
        </div>
        <div class="d-flex flex-column gap-2">
            <a href="{{ route('carrito.index') }}" class="btn btn-dark w-100 py-2">Ver carrito</a>
            <button type="button" class="btn btn-outline-dark w-100 py-2" id="btnSeguirComprando">Seguir comprando</button>
        </div>
    </div>
</div>
<div class="panel-overlay" id="panelOverlayCarrito"></div>
