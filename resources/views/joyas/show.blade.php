@extends("layouts.layout")

@section("title", $titulo)

@section("content")

@php
    $esFavorito = false;
    if(Auth::check()) {
        $esFavorito = \App\Models\Favorito::where('id_usuario', Auth::id())
                        ->where('id_producto', $producto->id)
                        ->exists();
    }
@endphp

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
                {{-- Añadir a la cesta: Lógica con Auth --}}
                @auth
                    <button class="btn btn-dark btn-lg flex-grow-1" id="btnAnadirCestaAuth"
                            data-url="{{ route('carrito.agregar', $producto) }}"
                            {{ $producto->stock <= 0 ? 'disabled' : '' }}>
                        <i class="bi bi-cart-plus me-2"></i>Añadir a la cesta
                    </button>
                @else
                    <button class="btn btn-dark btn-lg flex-grow-1" id="btnAnadirCestaGuest"
                            data-bs-toggle="modal" data-bs-target="#loginModal"
                            {{ $producto->stock <= 0 ? 'disabled' : '' }}>
                        <i class="bi bi-cart-plus me-2"></i>Añadir a la cesta
                    </button>
                @endauth

                {{-- Favorito --}}
                @auth
                    <button class="btn btn-outline-dark btn-lg" id="btnFavorito"
                            data-url="{{ route('favoritos.toggle', $producto) }}"
                            title="Añadir a favoritos">
                        <i class="bi {{ $esFavorito ? 'bi-heart-fill text-danger' : 'bi-heart' }}"></i>
                    </button>
                @else
                    <button class="btn btn-outline-dark btn-lg" id="btnFavoritoGuest"
                            data-bs-toggle="modal" data-bs-target="#loginModal"
                            title="Añadir a favoritos">
                        <i class="bi bi-heart"></i>
                    </button>
                @endauth
            </div>

            {{-- Botón personalizar joya --}}
            <a href="{{ route('personaliza') }}" class="btn btn-outline-secondary w-100">
                <i class="bi bi-brush me-2"></i>Personalizar joya
            </a>
        </div>
    </div>
</div>

{{-- Modal de Autenticación (para carrito y favoritos) --}}
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold" id="loginModalLabel">Inicia sesión</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body text-center pb-4">
                <i class="bi bi-person-lock text-muted" style="font-size: 3rem;"></i>
                <p class="mt-3 mb-4">Para añadir productos a la cesta o a favoritos debes iniciar sesión o crear una cuenta nueva.</p>
                <div class="d-grid gap-2">
                    <a href="{{ route('login') }}" class="btn btn-dark">Iniciar sesión</a>
                    <a href="{{ route('register') }}" class="btn btn-outline-dark">Registrarse</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Botón añadir a la cesta (Usuario Autenticado)
        const btnCestaAuth = document.getElementById('btnAnadirCestaAuth');
        if (btnCestaAuth) {
            btnCestaAuth.addEventListener('click', function() {
                const url = this.dataset.url;
                const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                // Deshabilitar botón temporalmente para evitar doble click
                this.disabled = true;
                const originalHTML = this.innerHTML;
                this.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Añadiendo...';

                fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    this.disabled = false;
                    this.innerHTML = originalHTML;

                    if(data.success) {
                        alert(data.message); // Muestra éxito temporalmente
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(err => {
                    this.disabled = false;
                    this.innerHTML = originalHTML;
                    console.error('Error:', err);
                    alert('Hubo un error al añadir a la cesta.');
                });
            });
        }

        // Botón favorito (Usuario Autenticado) - AJAX toggle
        const btnFav = document.getElementById('btnFavorito');
        if (btnFav) {
            btnFav.addEventListener('click', function() {
                const url = this.dataset.url;
                const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                const icon = this.querySelector('i');

                fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        if(data.favorito) {
                            // Añadido a favoritos
                            icon.classList.remove('bi-heart');
                            icon.classList.add('bi-heart-fill', 'text-danger');
                        } else {
                            // Eliminado de favoritos
                            icon.classList.remove('bi-heart-fill', 'text-danger');
                            icon.classList.add('bi-heart');
                        }
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(err => {
                    console.error('Error:', err);
                    alert('Hubo un error al actualizar favoritos.');
                });
            });
        }
    });
</script>

@endsection

