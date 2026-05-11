@extends("layouts.layout")

@section("title", $titulo)

@section("content")

    <div class="page-joyas" id="page-joyas">
        <div class="contenedor-titulo-filtros">
            <h2>{{ $titulo }}</h2>
            <div class="contenedor-filtros">
                <div class="filtrar">
                    <p>Filtrar Por: </p>
                    <i class="bi bi-list"></i>
                </div>
                <div class="ordenar">
                    <p>Ordenar Por: </p>
                    <i class="bi bi-list"></i>
                </div>
            </div>

        </div>
        {{-- Contenedor de iconos de filtro y ordenación --}}

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        {{-- ========================================== --}}
        {{-- FILA 1: Imagen grande izquierda + 4 productos --}}
        {{-- ========================================== --}}
        @if($productos && count($productos) > 0)

            <div class="productos-showcase">
                {{-- Imagen decorativa grande (izquierda) --}}
                <div class="imagen-destacada">
                    <img src="{{ asset('images/joyas/exclusiva.webp') }}" alt="Joyería destacada" class="imagen-destacada-img">
                    <div class="imagen-destacada-overlay">
                        <h3>Colección Exclusiva</h3>
                        <p>Descubre nuestras piezas únicas</p>
                        <a href="{{ route('joyas.index', $categoria) }}" class="btn-ver-mas">Ver colección</a>
                    </div>
                </div>

                {{-- Grid 2x2 de productos (derecha) --}}
                <div class="productos-secundarios">
                    @foreach($productos->slice(0, 4) as $producto)
                        <div class="producto-item">
                            <a href="{{ route('joyas.show', [$categoria, $producto]) }}" class="producto-enlace">
                                <div class="producto-card">
                                    @if($producto->ruta_grabado && file_exists(public_path('storage/' . $producto->ruta_grabado)))
                                        <img src="{{ asset('storage/' . $producto->ruta_grabado) }}" class="producto-imagen"
                                            alt="{{ $producto->nombre }}">
                                    @else
                                        <div class="producto-imagen--placeholder">
                                            <i class="bi bi-gem icono-placeholder"></i>
                                        </div>
                                    @endif

                                    <div class="producto-info">
                                        <h4 class="producto-titulo">{{ Str::limit($producto->nombre, 30) }}</h4>
                                        <p class="producto-marca">{{ $producto->marca }}</p>
                                        <p class="producto-descripcion">{{ Str::limit($producto->descripcion, 40) }}</p>
                                        <p class="producto-precio">{{ number_format($producto->precio, 2) }} €</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- ========================================== --}}
            {{-- FILA 2: 4 productos en grid normal --}}
            {{-- ========================================== --}}
            @if($productos->count() > 4)
                <div class="productos-fila">
                    @foreach($productos->slice(4, 4) as $producto)
                        <div class="producto-item">
                            <a href="{{ route('joyas.show', [$categoria, $producto]) }}" class="producto-enlace">
                                <div class="producto-card">
                                    @if($producto->ruta_grabado && file_exists(public_path('storage/' . $producto->ruta_grabado)))
                                        <img src="{{ asset('storage/' . $producto->ruta_grabado) }}" class="producto-imagen"
                                            alt="{{ $producto->nombre }}">
                                    @else
                                        <div class="producto-imagen--placeholder">
                                            <i class="bi bi-gem icono-placeholder"></i>
                                        </div>
                                    @endif

                                    <div class="producto-info">
                                        <h4 class="producto-titulo">{{ Str::limit($producto->nombre, 30) }}</h4>
                                        <p class="producto-marca">{{ $producto->marca }}</p>
                                        <p class="producto-descripcion">{{ Str::limit($producto->descripcion, 40) }}</p>
                                        <p class="producto-precio">{{ number_format($producto->precio, 2) }} €</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- ========================================== --}}
            {{-- FILA 3: 4 productos izquierda + Imagen grande derecha --}}
            {{-- ========================================== --}}
            @if($productos->count() > 8)
                <div class="productos-showcase productos-showcase--invertido">
                    {{-- Grid 2x2 de productos (izquierda) --}}
                    <div class="productos-secundarios">
                        @foreach($productos->slice(8, 4) as $producto)
                            <div class="producto-item">
                                <a href="{{ route('joyas.show', [$categoria, $producto]) }}" class="producto-enlace">
                                    <div class="producto-card">
                                        @if($producto->ruta_grabado && file_exists(public_path('storage/' . $producto->ruta_grabado)))
                                            <img src="{{ asset('storage/' . $producto->ruta_grabado) }}" class="producto-imagen"
                                                alt="{{ $producto->nombre }}">
                                        @else
                                            <div class="producto-imagen--placeholder">
                                                <i class="bi bi-gem icono-placeholder"></i>
                                            </div>
                                        @endif

                                        <div class="producto-info">
                                            <h4 class="producto-titulo">{{ Str::limit($producto->nombre, 30) }}</h4>
                                            <p class="producto-marca">{{ $producto->marca }}</p>
                                            <p class="producto-descripcion">{{ Str::limit($producto->descripcion, 40) }}</p>
                                            <p class="producto-precio">{{ number_format($producto->precio, 2) }} €</p>

                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>

                    {{-- Imagen decorativa grande (derecha) --}}
                    <div class="imagen-destacada">
                        <img src="{{ asset('images/joyas/exclusiva-2.jpg') }}" alt="Artesanía en joyería"
                            class="imagen-destacada-img">
                        <div class="imagen-destacada-overlay">
                            <h3>Artesanía Única</h3>
                            <p>Cada pieza cuenta una historia</p>

                        </div>
                    </div>
                </div>
            @endif

            {{-- ========================================== --}}
            {{-- FILAS RESTANTES: Grid normal de 4 columnas --}}
            {{-- ========================================== --}}
            @if($productos->count() > 12)
                <div class="productos-fila">
                    @foreach($productos->slice(12) as $producto)
                        <div class="producto-item">
                            <a href="{{ route('joyas.show', [$categoria, $producto]) }}" class="producto-enlace">
                                <div class="producto-card">
                                    @if($producto->ruta_grabado && file_exists(public_path('storage/' . $producto->ruta_grabado)))
                                        <img src="{{ asset('storage/' . $producto->ruta_grabado) }}" class="producto-imagen"
                                            alt="{{ $producto->nombre }}">
                                    @else
                                        <div class="producto-imagen--placeholder">
                                            <i class="bi bi-gem icono-placeholder"></i>
                                        </div>
                                    @endif

                                    <div class="producto-info">
                                        <h4 class="producto-titulo">{{ Str::limit($producto->nombre, 30) }}</h4>
                                        <p class="producto-marca">{{ $producto->marca }}</p>
                                        <p class="producto-descripcion">{{ Str::limit($producto->descripcion, 40) }}</p>
                                        <p class="producto-precio">{{ number_format($producto->precio, 2) }} €</p>

                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif

        @else
            {{-- Estado vacío --}}
            <div class="productos-vacio">
                <i class="bi bi-inbox vacio-icono"></i>
                <h3>No hay {{ strtolower($titulo) }} registrados</h3>
                <a href="{{ route('joyas.create', $categoria) }}" class="btn-crear">
                    <i class="bi bi-plus-circle"></i> Crear uno
                </a>
            </div>
        @endif
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $productos->links() }}
    </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Doble slider de precio
            const precioMinInput = document.getElementById('precioMin');
            const precioMaxInput = document.getElementById('precioMax');
            const precioMinValor = document.getElementById('precioMinValor');
            const precioMaxValor = document.getElementById('precioMaxValor');

            function updatePriceValues() {
                let minVal = parseInt(precioMinInput.value);
                let maxVal = parseInt(precioMaxInput.value);

                if (minVal > maxVal) {
                    // Cambia los valores si se pasa el min al max
                    [minVal, maxVal] = [maxVal, minVal];
                    precioMinInput.value = minVal;
                    precioMaxInput.value = maxVal;
                }

                precioMinValor.textContent = minVal;
                precioMaxValor.textContent = maxVal;
            }

            precioMinInput.addEventListener('input', updatePriceValues);
            precioMaxInput.addEventListener('input', updatePriceValues);

            // Inicializamos los valores
            updatePriceValues();

            // Ordenar
            const sortOptions = document.querySelectorAll('.sort-option');
            const ordenInput = document.getElementById('ordenInput');
            const filterSortForm = document.getElementById('filterSortForm');

            // Logica de que al pulsar en la ordenacion haga submit al de filtros y ordene
            sortOptions.forEach(button => {
                button.addEventListener('click', function () {
                    ordenInput.value = this.dataset.sortValue;
                    filterSortForm.submit();
                });
            });
        });
    </script>

@endsection