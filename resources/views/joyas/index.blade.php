@extends("layouts.layout")

@section("title", $titulo)

@section("content")

    <div class="page-joyas" id="page-joyas">
        <div class="contenedor-titulo-filtros">
            <h2>{{ $titulo }}</h2>
            <div class="contenedor-filtros">
                <div class="filtrar">
                    <p>Filtrar Por: </p>
                    <a id="boton-filter"><i class="bi bi-list"></i></a>
                </div>
                <div class="ordenar">
                    <p>Ordenar Por: </p>
                    <a id="boton-ordenar"><i class="bi bi-list"></i></a>
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

    <div class="panel-filtrar" id="panelFiltrar">
        <div class="panel-header">
            <h3>Filtrar</h3>
            <button type="button" class="btn-close" id="closeFilter"></button>
        </div>
        <form action="{{ route('joyas.index', $categoria) }}" method="GET" id="filterSortForm">
            {{-- Mantener el orden actual si existe --}}
            <input type="hidden" name="orden" id="ordenInput" value="{{ request('orden') }}">

            <div class="filter-group dropdown-custom" id="dropdown-marca">
                <div class="dropdown-header">
                    <label>Marca</label>
                    <i class="bi bi-chevron-down"></i>
                </div>
                <div class="dropdown-content">
                    @foreach(['Cartier', 'Armani', 'Pandora', 'Tous', 'Swarovski', 'Lotus'] as $marca)
                        <div class="checkbox-item">
                            <input type="checkbox" name="marca[]" value="{{ $marca }}" id="marca-{{ $marca }}" {{ in_array($marca, (array) request('marca')) ? 'checked' : '' }}>
                            <label for="marca-{{ $marca }}">{{ $marca }}</label>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="filter-group dropdown-custom" id="dropdown-genero">
                <div class="dropdown-header">
                    <label>Género</label>
                    <i class="bi bi-chevron-down"></i>
                </div>
                <div class="dropdown-content">
                    @foreach(['mujer', 'hombre', 'unisex'] as $gen)
                        <div class="checkbox-item">
                            <input type="checkbox" name="genero[]" value="{{ $gen }}" id="gen-{{ $gen }}" {{ in_array($gen, (array) request('genero')) ? 'checked' : '' }}>
                            <label for="gen-{{ $gen }}">{{ ucfirst($gen) }}</label>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="filter-group dropdown-custom" id="dropdown-color">
                <div class="dropdown-header">
                    <label>Color</label>
                    <i class="bi bi-chevron-down"></i>
                </div>
                <div class="dropdown-content">
                    @foreach(['blanco', 'negro', 'plata', 'azul', 'dorado'] as $color)
                        <div class="checkbox-item">
                            <input type="checkbox" name="color[]" value="{{ $color }}" id="color-{{ $color }}" {{ in_array($color, (array) request('color')) ? 'checked' : '' }}>
                            <label for="color-{{ $color }}" class="d-flex align-items-center gap-2">
                                <span class="color-circle color-{{ $color }}"></span>
                                {{ ucfirst($color) }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="filter-group dropdown-custom" id="dropdown-material">
                <div class="dropdown-header">
                    <label>Material</label>
                    <i class="bi bi-chevron-down"></i>
                </div>
                <div class="dropdown-content">
                    @foreach(['oro', 'acero', 'plata', 'perla'] as $mat)
                        <div class="checkbox-item">
                            <input type="checkbox" name="material[]" value="{{ $mat }}" id="mat-{{ $mat }}" {{ in_array($mat, (array) request('material')) ? 'checked' : '' }}>
                            <label for="mat-{{ $mat }}">{{ ucfirst($mat) }}</label>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="filter-group">
                <label>Precio: <span id="precioMinValor">{{ request('precio_min', 0) }}</span>€ - <span
                        id="precioMaxValor">{{ request('precio_max', $precioMaximo) }}</span>€</label>
                <div class="range-slider-container">
                    <input type="range" name="precio_min" id="precioMin" min="0" max="{{ $precioMaximo }}"
                        value="{{ request('precio_min', 0) }}">
                    <input type="range" name="precio_max" id="precioMax" min="0" max="{{ $precioMaximo }}"
                        value="{{ request('precio_max', $precioMaximo) }}">
                </div>
            </div>

            <div class="filter-group dropdown-custom" id="dropdown-talla">
                <div class="dropdown-header">
                    <label>Talla</label>
                    <i class="bi bi-chevron-down"></i>
                </div>
                <div class="dropdown-content">
                    @for($i = 46; $i <= 68; $i += 2)
                        <div class="checkbox-item">
                            <input type="checkbox" name="talla[]" value="{{ $i }}" id="talla-{{ $i }}" {{ in_array((string) $i, (array) request('talla')) ? 'checked' : '' }}>
                            <label for="talla-{{ $i }}">{{ $i }}</label>
                        </div>
                    @endfor
                </div>
            </div>

            <div class="panel-footer">
                <a href="{{ route('joyas.index', $categoria) }}" class="btn-limpiar">Limpiar</a>
                <button type="submit" class="btn-aplicar">Aplicar Filtros</button>
            </div>
        </form>
    </div>

    <div class="panel-ordenar" id="panelOrdenar">
        <div class="panel-header">
            <h3>Ordenar por</h3>
            <button type="button" class="btn-close" id="closeSort"></button>
        </div>
        <div class="sort-options-list">
            <button type="button" class="sort-option {{ request('orden') == 'precio_asc' ? 'active' : '' }}"
                data-sort-value="precio_asc">
                <i class="bi bi-sort-numeric-down"></i> Precio: Menor a mayor
            </button>
            <button type="button" class="sort-option {{ request('orden') == 'precio_desc' ? 'active' : '' }}"
                data-sort-value="precio_desc">
                <i class="bi bi-sort-numeric-up-alt"></i> Precio: Mayor a menor
            </button>
            <button type="button" class="sort-option {{ request('orden') == 'ventas' ? 'active' : '' }}"
                data-sort-value="ventas">
                <i class="bi bi-award"></i> Más vendidos
            </button>
        </div>
    </div>


    <div class="panel-overlay" id="panelOverlay"></div>

@endsection