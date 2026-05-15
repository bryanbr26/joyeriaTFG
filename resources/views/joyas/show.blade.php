@extends("layouts.layout")

@section("title", $titulo)

@section("content")

    @php
        $esFavorito = false;
        if (Auth::check()) {
            $esFavorito = \App\Models\Favorito::where('id_usuario', Auth::id())
                ->where('id_producto', $producto->id)
                ->exists();
        }
    @endphp

    <div class="producto-detalle" id="producto-show">
        <div class="producto-detalle-grid">
            {{-- ===================== COLUMNA IZQUIERDA: IMAGEN ===================== --}}
            <div class="producto-detalle-imagen">
                <div class="contenedor-imagen-principal">
                    @if($producto->imagen_principal_url)
                        <img src="{{ $producto->imagen_principal_url }}" id="producto-imagen-principal" class="imagen-principal-producto" alt="{{ $producto->nombre }}" loading="eager">
                    @else
                        <div class="imagen-placeholder">
                            <i class="bi bi-gem icono-placeholder"></i>
                        </div>
                    @endif
                </div>
                @if($producto->imagenes->count() > 1)
                    <div class="contenedor-imagenes-miniatura">
                        @foreach($producto->imagenes as $imagen)
                            <div class="imagen-mini">
                                <img src="{{ $imagen->url_completa }}"
                                     data-full-src="{{ $imagen->url_completa }}"
                                     class="imagen-producto-mini producto-miniatura"
                                     alt="{{ $producto->nombre }}"
                                     loading="lazy"
                                     decoding="async">
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- ===================== COLUMNA DERECHA: INFORMACIÓN ===================== --}}
            <div class="producto-info">
                <h2 class="producto-nombre">{{ $producto->nombre }}</h2>
                <p class="producto-marca">{{ $producto->marca }}</p>

                <p class="producto-precio">{{ number_format($producto->precio, 2) }} €</p>

                {{-- Descripción --}}
                <p class="producto-descripcion">{{ $producto->descripcion }}</p>

                {{-- Detalles del producto --}}
                <div class="producto-detalles">
                    <table class="tabla-detalles">
                        <tbody>
                            @if($producto->material)
                                <tr>
                                    <td class="detalle-etiqueta">Material</td>
                                    <td class="detalle-valor">{{ ucfirst($producto->material) }}</td>
                                </tr>
                            @endif
                            @if($producto->color)
                                <tr>
                                    <td class="detalle-etiqueta">Color</td>
                                    <td class="detalle-valor">{{ ucfirst($producto->color) }}</td>
                                </tr>
                            @endif
                            @if($producto->genero)
                                <tr>
                                    <td class="detalle-etiqueta">Género</td>
                                    <td class="detalle-valor">{{ ucfirst($producto->genero) }}</td>
                                </tr>
                            @endif
                            @if($producto->talla)
                                <tr>
                                    <td class="detalle-etiqueta">Talla</td>
                                    <td class="detalle-valor">{{ $producto->talla }}</td>
                                </tr>
                            @endif
                            @if($producto->peso)
                                <tr>
                                    <td class="detalle-etiqueta">Peso</td>
                                    <td class="detalle-valor">{{ $producto->peso }} g</td>
                                </tr>
                            @endif
                            <tr>
                                <td class="detalle-etiqueta">Disponibilidad</td>
                                <td class="detalle-valor">
                                    @if($producto->stock > 0)
                                        <span class="stock-disponible">
                                            <i class="bi bi-check-circle"></i> En stock ({{ $producto->stock }})
                                        </span>
                                    @else
                                        <span class="stock-agotado">
                                            <i class="bi bi-x-circle"></i> Agotado
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                {{-- Botones de acción --}}
                <div class="producto-acciones">
                    {{-- Añadir a la cesta --}}
                    @auth
                        <button class="btn-carrito" id="btnAnadirCestaAuth"
                            data-url="{{ route('carrito.agregar', $producto) }}" 
                            {{ $producto->stock <= 0 ? 'disabled' : '' }}>
                            <i class="bi bi-cart-plus"></i>
                            <span>Añadir a la cesta</span>
                        </button>
                    @else
                        <button class="btn-carrito" id="btnAnadirCestaGuest"
                            data-modal-target="loginModal"
                                {{ $producto->stock <= 0 ? 'disabled' : '' }}>
                            <i class="bi bi-cart-plus"></i>
                            <span>Añadir a la cesta</span>
                        </button>
                    @endauth

                    {{-- Favorito --}}
                    @auth
                        <button class="btn-favorito {{ $esFavorito ? 'btn-favorito--activo' : '' }}" 
                            id="btnFavorito"
                            data-url="{{ route('favoritos.toggle', $producto) }}" 
                            title="Añadir a favoritos">
                            <i class="bi {{ $esFavorito ? 'bi-heart-fill' : 'bi-heart' }}"></i>
                        </button>
                    @else
                        <button class="btn-favorito" id="btnFavoritoGuest"
                            data-modal-target="loginModal"
                            title="Añadir a favoritos">
                            <i class="bi bi-heart"></i>
                        </button>
                    @endauth
                </div>

                {{-- Botón personalizar --}}
                <a href="{{ route('personaliza.producto', $producto) }}" class="btn-personalizar">
                    <i class="bi bi-brush"></i>
                    <span>Personalizar joya</span>
                </a>
            </div>
        </div>
    </div>

    <div class="modal-overlay" id="loginModal">
        <div class="modal-contenido">
            <div class="modal-header">
                <h5 class="modal-titulo">Inicia sesión</h5>
                <button class="modal-cerrar" data-modal-close>✕</button>
            </div>
            <div class="modal-body">
                <i class="bi bi-person-lock modal-icono"></i>
                <p>Para añadir productos a la cesta o a favoritos debes iniciar sesión o crear una cuenta nueva.</p>
                <div class="modal-botones">
                    <a href="{{ route('login') }}" class="btn-login">Iniciar sesión</a>
                    <a href="{{ route('register') }}" class="btn-registro">Registrarse</a>
                </div>
            </div>
        </div>
    </div>
    @if(isset($productos) && $productos->count() > 0)
        <div class="productos-relacionados-showcase">
            <h3 class="showcase-titulo">También te puede interesar</h3>
            <div class="productos-relacionados-fila">
                @foreach($productos->take(4) as $relacionado)
                    <div class="producto-item">
                        <a href="{{ route('joyas.show', [$categoria, $relacionado]) }}" class="producto-enlace">
                            <div class="producto-card">
                                @if($relacionado->imagen_principal_url)
                                    <img src="{{ $relacionado->imagen_principal_url }}" class="producto-imagen"
                                        alt="{{ $relacionado->nombre }}" loading="lazy" decoding="async">
                                @else
                                    <div class="producto-imagen--placeholder">
                                        <i class="bi bi-gem icono-placeholder"></i>
                                    </div>
                                @endif
                                <div class="producto-info">
                                    <h4 class="producto-titulo">{{ Str::limit($relacionado->nombre, 30) }}</h4>
                                    <p class="producto-marca">{{ $relacionado->marca }}</p>
                                    <p class="producto-descripcion">{{ Str::limit($relacionado->descripcion, 40) }}</p>
                                    <p class="producto-precio">{{ number_format($relacionado->precio, 2) }} €</p>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
    <section class="section-cinco">
        <div class="contenedor-iconos-informativos">
            <div class="targeta-icono">
                <i class="bi bi-box-seam-fill"></i>
                <div class="texto">
                    <h4>Devolucion gratuita en 15 dias</h4>
                </div>
            </div>
            <div class="targeta-icono">
                <i class="bi bi-truck"></i>
                <div class="texto">
                    <h4>Envio gratis a partir de 40€</h4>

                </div>
            </div>
            <div class="targeta-icono">
                <i class="bi bi-gift-fill"></i>
                <div class="texto">
                    <h4>Cajas regalo disponibles</h4>

                </div>
            </div>
            <div class="targeta-icono">
                <i class="bi bi-calendar-check"></i>
                <div class="texto">
                    <h4>Reserva tu cita con nosotros</h4>

                </div>
            </div>
        </div>
    </section>

    @include('joyas.partials.panel-carrito')

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const imagenPrincipal = document.getElementById('producto-imagen-principal');
            const miniaturas = document.querySelectorAll('.producto-miniatura');

            miniaturas.forEach(function (miniatura) {
                miniatura.addEventListener('click', function () {
                    if (!imagenPrincipal) return;

                    imagenPrincipal.src = this.dataset.fullSrc;
                    miniaturas.forEach(img => img.classList.remove('active'));
                    this.classList.add('active');
                });
            });
        });
    </script>
    <script src="{{ mix('js/pages/panel-carrito.js') }}" defer></script>
    <script src="{{ mix('js/pages/show.js') }}" defer></script>
@endpush
