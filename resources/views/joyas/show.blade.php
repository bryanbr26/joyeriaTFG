@extends("layouts.layout")

@section("title", $titulo)

@section("content")

<div class="container my-4">
    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('joyas.index', $categoria) }}">{{ ucfirst($categoria) }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $producto->nombre }}</li>
        </ol>
    </nav>

    <div class="row g-4">
        {{-- ===================== COLUMNA IZQUIERDA: IMAGEN ===================== --}}
        <div class="col-lg-6">
            <div class="mb-3">
                @if($producto->ruta_grabado && file_exists(public_path('storage/' . $producto->ruta_grabado)))
                    <img src="{{ asset('storage/' . $producto->ruta_grabado) }}"
                         class="img-fluid rounded w-100" alt="{{ $producto->nombre }}"
                         style="max-height: 450px; object-fit: cover;">
                @else
                    <div class="bg-light d-flex align-items-center justify-content-center rounded"
                         style="height: 450px;">
                        <i class="bi bi-gem" style="font-size: 5rem; color: #ccc;"></i>
                    </div>
                @endif
            </div>
        </div>

        {{-- ===================== COLUMNA DERECHA: INFORMACIÓN ===================== --}}
        <div class="col-lg-6">
            <h2 class="fw-bold mb-1">{{ $producto->nombre }}</h2>
            <p class="text-muted mb-3">{{ $producto->marca }}</p>

            <h3 class="text-dark mb-4">{{ number_format($producto->precio, 2) }} €</h3>

            {{-- Descripción --}}
            <p class="mb-4">{{ $producto->descripcion }}</p>

            {{-- Detalles del producto --}}
            <div class="mb-4">
                <table class="table table-sm table-borderless">
                    <tbody>
                        @if($producto->material)
                        <tr>
                            <td class="fw-bold text-muted" style="width: 120px;">Material</td>
                            <td>{{ ucfirst($producto->material) }}</td>
                        </tr>
                        @endif
                        @if($producto->color)
                        <tr>
                            <td class="fw-bold text-muted">Color</td>
                            <td>{{ ucfirst($producto->color) }}</td>
                        </tr>
                        @endif
                        @if($producto->genero)
                        <tr>
                            <td class="fw-bold text-muted">Género</td>
                            <td>{{ ucfirst($producto->genero) }}</td>
                        </tr>
                        @endif
                        @if($producto->talla)
                        <tr>
                            <td class="fw-bold text-muted">Talla</td>
                            <td>{{ $producto->talla }}</td>
                        </tr>
                        @endif
                        @if($producto->peso)
                        <tr>
                            <td class="fw-bold text-muted">Peso</td>
                            <td>{{ $producto->peso }} g</td>
                        </tr>
                        @endif
                        <tr>
                            <td class="fw-bold text-muted">Disponibilidad</td>
                            <td>
                                @if($producto->stock > 0)
                                    <span class="text-success"><i class="bi bi-check-circle"></i> En stock ({{ $producto->stock }})</span>
                                @else
                                    <span class="text-danger"><i class="bi bi-x-circle"></i> Agotado</span>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="d-flex align-items-center gap-3 mb-4">
                {{-- Añadir a la cesta: Dejamos que pueda agregar y hasta que no vaya a comprar no pida logearse --}}
                <button class="btn btn-dark btn-lg flex-grow-1" id="btnAnadirCesta"
                        {{ $producto->stock <= 0 ? 'disabled' : '' }}>
                    <i class="bi bi-cart-plus me-2"></i>Añadir a la cesta
                </button>

                {{-- TODO: hacer que pida logearse para añadir a favoritos: Modal + elegir login o register --}}
                {{-- Favorito --}}
                <button class="btn btn-outline-dark btn-lg" id="btnFavorito"
                        title="Añadir a favoritos">
                    <i class="bi bi-heart"></i>
                </button>
            </div>

            {{-- Botón personalizar joya --}}
            <a href="{{ route('personaliza') }}" class="btn btn-outline-secondary w-100">
                <i class="bi bi-brush me-2"></i>Personalizar joya
            </a>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Botón añadir a la cesta
        const btnCesta = document.getElementById('btnAnadirCesta');
        if (btnCesta) {
            btnCesta.addEventListener('click', function() {
                alert('Producto añadido a la cesta.');
            });
        }

        // Botón favorito
        const btnFav = document.getElementById('btnFavorito');
        if (btnFav) {
            btnFav.addEventListener('click', function() {
                const icon = this.querySelector('i');
                if (icon.classList.contains('bi-heart')) {
                    icon.classList.remove('bi-heart');
                    icon.classList.add('bi-heart-fill', 'text-danger');
                    alert('Añadido a favoritos.');
                } else {
                    icon.classList.remove('bi-heart-fill', 'text-danger');
                    icon.classList.add('bi-heart');
                    alert('Eliminado de favoritos.');
                }
            });
        }
    });
</script>

@endsection
