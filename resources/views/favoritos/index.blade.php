@extends("layouts.layout")

@section("title", "Mis Favoritos")

@section("content")

<style>
    .favoritos-bg {
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

<div class="favoritos-bg">
    <div class="container">
        
        <!-- Botón de volver atrás -->
        <a href="javascript:history.back()" class="btn btn-outline-dark mb-4">
            <i class="bi bi-arrow-left me-2"></i>Volver atrás
        </a>

        <h2 class="text-dark text-center mb-4" style="font-family: 'Italiana', serif;">Mis Favoritos</h2>

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
                
                @forelse($favoritos as $favorito)
                    <div class="item-box">
                        <!-- Img Container -->
                        <div class="item-image">
                            @if($favorito->producto->ruta_grabado && file_exists(public_path('storage/' . $favorito->producto->ruta_grabado)))
                                <img src="{{ asset('storage/' . $favorito->producto->ruta_grabado) }}" 
                                     alt="{{ $favorito->producto->nombre }}" class="img-fluid" style="object-fit: cover; width: 100%; height: 100%;">
                            @else
                                <i class="bi bi-gem text-muted" style="font-size: 3rem;"></i>
                            @endif
                        </div>

                        <!-- Detalles Container -->
                        <div class="item-details">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h5 class="fw-bold mb-1">{{ $favorito->producto->nombre }}</h5>
                                    <p class="text-muted small mb-0">{{ $favorito->producto->marca }}</p>
                                    <p class="text-muted small mb-0">{{ Str::limit($favorito->producto->descripcion, 70) }}</p>
                                </div>
                                <div class="fw-bold fs-5 ms-3" style="white-space: nowrap;">
                                    {{ number_format($favorito->producto->precio, 2) }}€
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-between align-items-end mt-4">
                                <!-- Eliminar de favoritos -->
                                <form action="{{ route('favoritos.eliminar', $favorito->id) }}" method="POST" onsubmit="return confirm('¿Seguro que quieres eliminar este producto de favoritos?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-secondary btn-sm rounded-pill px-3 fw-semibold">
                                        <i class="bi bi-heart-fill text-danger me-1"></i>Eliminar
                                    </button>
                                </form>
                                
                                <!-- Añadir al carrito -->
                                <form action="{{ route('favoritos.agregarCarrito', $favorito->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-dark btn-sm rounded-pill px-3 fw-semibold"
                                            {{ $favorito->producto->stock <= 0 ? 'disabled' : '' }}>
                                        <i class="bi bi-cart-plus me-1"></i>Añadir a la cesta
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center p-5 text-muted" style="border: 2px dashed #ced4da;">
                        <i class="bi bi-heart" style="font-size: 3rem;"></i>
                        <h4 class="mt-3">No tienes favoritos</h4>
                        <p>Explora nuestras joyas y guarda las que más te gusten.</p>
                        <a href="{{ route('index') }}" class="btn btn-dark mt-2">Explorar joyas</a>
                    </div>
                @endforelse
                
            </div>
        </div>
    </div>
</div>

@endsection
