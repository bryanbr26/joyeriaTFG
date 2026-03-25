@extends("layouts.layout")

@section("title", $titulo)

@section("content")

<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>{{ $titulo }}</h2>

        <div>
            <form method="GET" action="{{ route('joyas.index', $categoria) }}" id="filterSortForm">
                <!-- Dropdown de filtros -->
                <div class="dropdown mb-3 d-inline-block me-2">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownFiltrar" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                        Filtrar por
                    </button>
                    
                    <div class="dropdown-menu p-3" aria-labelledby="dropdownFiltrar" style="min-width: 300px;">
                        
                        <!-- Marca -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Marca</label>
                            @foreach(['marca1', 'marca2', 'marca3'] as $marca)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="marca[]" value="{{ $marca }}" id="marca{{ $loop->index + 1 }}" {{ in_array($marca, request('marca', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="marca{{ $loop->index + 1 }}">{{ ucfirst($marca) }}</label>
                            </div>
                            @endforeach
                        </div>
                        
                        <!-- Género -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Género</label>
                            @foreach(['hombre', 'mujer', 'unisex'] as $genero)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="genero[]" value="{{ $genero }}" id="genero{{ ucfirst($genero) }}" {{ in_array($genero, request('genero', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="genero{{ ucfirst($genero) }}">{{ ucfirst($genero) }}</label>
                            </div>
                            @endforeach
                        </div>
                    
                    <!-- Color -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Color</label>
                        @foreach(['oro', 'plata', 'acero'] as $color)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="color[]" value="{{ $color }}" id="color{{ ucfirst($color) }}" {{ in_array($color, request('color', [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="color{{ ucfirst($color) }}">{{ ucfirst($color) }}</label>
                        </div>
                        @endforeach
                    </div>
                    
                    <!-- Material -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Material</label>
                        @foreach(['oro', 'plata', 'acero'] as $material)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="material[]" value="{{ $material }}" id="material{{ ucfirst($material) }}" {{ in_array($material, request('material', [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="material{{ ucfirst($material) }}">{{ ucfirst($material) }}</label>
                        </div>
                        @endforeach
                    </div>
                    
                    <!-- Precio -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Precio</label>
                        <div class="d-flex align-items-center">
                            <input type="range" min="0" max="{{ $precioMaximo }}" value="{{ $precioMin }}" class="form-range me-2" id="precioMin" name="precio_min">
                            <span id="precioMinValor">{{ $precioMin }}</span> €
                        </div>
                        <div class="d-flex align-items-center mt-2">
                            <input type="range" min="0" max="{{ $precioMaximo }}" value="{{ $precioMax }}" class="form-range me-2" id="precioMax" name="precio_max">
                            <span id="precioMaxValor">{{ $precioMax }}</span> €
                        </div>
                    </div>
                    
                    <!-- Talla -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Talla</label>
                        @foreach(['S', 'M', 'L', 'XL'] as $talla)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="talla[]" value="{{ $talla }}" id="talla{{ $talla }}" {{ in_array($talla, request('talla', [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="talla{{ $talla }}">{{ $talla }}</label>
                        </div>
                        @endforeach
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary btn-sm">Aplicar filtros</button>
                        <a href="{{ route('joyas.index', $categoria) }}" class="btn btn-outline-secondary btn-sm">Limpiar</a>
                    </div>
                </div>
            </div>
            
            <!-- Dropdown de ordenar -->
            <div class="dropdown mb-3 d-inline-block">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownOrdenar" data-bs-toggle="dropdown" aria-expanded="false">
                    Ordenar por
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownOrdenar">
                    <li><button class="dropdown-item sort-option" type="button" data-sort-value="precio_asc">Menor a mayor precio</button></li>
                    <li><button class="dropdown-item sort-option" type="button" data-sort-value="precio_desc">Mayor a menor precio</button></li>
                </ul>
                <input type="hidden" name="orden" id="ordenInput" value="{{ request('orden', '') }}">
            </div>
        </form>
    </div>
    <!--
        TODO: Meter para admin estilo dashboard
            <a href="{{ route('joyas.create', $categoria) }}" class="btn btn-dark">
                <i class="bi bi-plus-lg"></i> Nuevo {{ $categoria }}
            </a>
    -->
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-3">
        @forelse($productos as $producto)
        <div class="col-md-3">
            <div class="card h-100">
                @if($producto->ruta_grabado && file_exists(public_path('storage/' . $producto->ruta_grabado)))
                    <img src="{{ asset('storage/' . $producto->ruta_grabado) }}" class="card-img-top" alt="{{ $producto->nombre }}" style="height: 200px; object-fit: cover;">
                @else
                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                        <i class="bi bi-gem fs-1 text-muted"></i>
                    </div>
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{ $producto->nombre }}</h5>
                    <p class="card-text text-muted small">{{ $producto->marca }}</p>
                    <p class="card-text">{{ Str::limit($producto->descripcion, 60) }}</p>
                    <p class="card-text fw-bold">{{ number_format($producto->precio, 2) }} €</p>
                    <p class="card-text"><small class="text-muted">Stock: {{ $producto->stock }}</small></p>
                </div>
                <!--
                    TODO: Meter para admin estilo dashboard
                        <div class="card-footer d-flex gap-2">
                            <a href="{{ route('joyas.edit', [$categoria, $producto]) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil"></i> Editar
                            </a>
                            <form action="{{ route('joyas.destroy', [$categoria, $producto]) }}" method="POST" onsubmit="return confirm('¿Eliminar este producto?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i> Eliminar
                                </button>
                            </form>
                        </div>
                -->
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-info text-center">
                No hay {{ strtolower($titulo) }} registrados. <a href="{{ route('joyas.create', $categoria) }}">Crear uno</a>.
            </div>
        </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $productos->links() }}
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
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
            button.addEventListener('click', function() {
                ordenInput.value = this.dataset.sortValue;
                filterSortForm.submit();
            });
        });
    });
</script>

@endsection
