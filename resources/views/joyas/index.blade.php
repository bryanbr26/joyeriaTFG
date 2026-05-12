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

            <div class="filter-group">
                <label>Marca</label>
                <select name="marca" class="filter-select">
                    <option value="">Todas las marcas</option>
                    @foreach(['Cartier', 'Armani', 'Pandora', 'Tous', 'Swarovski', 'Lotus'] as $marca)
                        <option value="{{ $marca }}" {{ request('marca') == $marca ? 'selected' : '' }}>{{ $marca }}</option>
                    @endforeach
                </select>
            </div>

            <div class="filter-group">
                <label>Género</label>
                <div class="filter-pills">
                    @foreach(['mujer', 'hombre', 'unisex'] as $gen)
                        <div class="pill-item">
                            <input type="radio" name="genero" value="{{ $gen }}" id="gen-{{ $gen }}" class="btn-check" {{ request('genero') == $gen ? 'checked' : '' }}>
                            <label class="btn btn-outline-dark btn-sm" for="gen-{{ $gen }}">{{ ucfirst($gen) }}</label>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="filter-group">
                <label>Color</label>
                <div class="filter-colors">
                    @foreach(['blanco', 'negro', 'plata', 'azul', 'dorado'] as $color)
                        <div class="color-item">
                            <input type="radio" name="color" value="{{ $color }}" id="color-{{ $color }}" class="btn-check" {{ request('color') == $color ? 'checked' : '' }}>
                            <label class="color-pill color-{{ $color }}" for="color-{{ $color }}"
                                title="{{ ucfirst($color) }}"></label>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="filter-group">
                <label>Material</label>
                <select name="material" class="filter-select">
                    <option value="">Todos los materiales</option>
                    @foreach(['oro', 'acero', 'plata', 'perla'] as $mat)
                        <option value="{{ $mat }}" {{ request('material') == $mat ? 'selected' : '' }}>{{ ucfirst($mat) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="filter-group">
                <label>Precio: <span id="precioMinValor">{{ request('precio_min', 0) }}</span>€ - <span
                        id="precioMaxValor">{{ request('precio_max', 1000) }}</span>€</label>
                <div class="range-slider-container">
                    <input type="range" name="precio_min" id="precioMin" min="0" max="1000"
                        value="{{ request('precio_min', 0) }}" class="form-range">
                    <input type="range" name="precio_max" id="precioMax" min="0" max="1000"
                        value="{{ request('precio_max', 1000) }}" class="form-range">
                </div>
            </div>

            <div class="filter-group">
                <label>Talla</label>
                <input type="text" name="talla" class="form-control" placeholder="Ej: 16, 50cm, S..."
                    value="{{ request('talla') }}">
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
                <i class="bi bi-fire"></i> Más vendidos
            </button>
        </div>
    </div>


    <div class="panel-overlay" id="panelOverlay"></div>

@endsection