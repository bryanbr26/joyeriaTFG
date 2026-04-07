@extends("layouts.layout")

@section("title", "Mi Cesta")

@section("content")

<style>
    .carrito-bg {
        background-color: #f8f9fa; /* Gris muy clarito casi blanco */
        min-height: 80vh;
        padding: 40px 0;
    }
    
    .item-box {
        border: 2px solid #dee2e6; /* Borde gris normal */
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
        
        <!-- Botón de volver atrás -->
        <a href="javascript:history.back()" class="btn btn-outline-dark mb-4">
            <i class="bi bi-arrow-left me-2"></i>Volver atrás
        </a>

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
                    <div class="item-box">
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
                                    <h5 class="fw-bold mb-1">{{ $item->producto->nombre }}</h5>
                                    <p class="text-muted small mb-0">{{ Str::limit($item->producto->descripcion, 70) }}</p>
                                </div>
                                <div class="fw-bold fs-5 ms-3 whitespace-nowrap">
                                    {{ number_format($item->producto->precio, 0) }}€
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-between align-items-end mt-4">
                                <form action="{{ route('carrito.eliminar', $item->id) }}" method="POST" onsubmit="return confirm('¿Seguro que quieres eliminar este producto?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-secondary btn-sm rounded-pill px-3 fw-semibold">Eliminar</button>
                                </form>
                                
                                <div class="d-flex align-items-center">
                                    <span class="me-2 fw-semibold text-muted">Cantidad</span>
                                    <span class="badge rounded-pill text-dark px-3 py-2 bg-light border">
                                        {{ $item->cantidad }}
                                    </span>
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
                    <div class="d-flex justify-content-center mt-5 mb-4">
                        <button class="btn btn-dark btn-lg px-5 py-3 rounded-0 fw-bold fs-5 w-100 shadow" style="max-width: 400px;" onclick="alert('Pasando por caja... ¡Compra realizada con éxito! (Total: {{ number_format($totalPrice, 2) }}€)')">
                            Pasar por caja [{{ $totalItems }}]
                        </button>
                    </div>
                @endif
                
            </div>
        </div>
    </div>
</div>

@endsection
