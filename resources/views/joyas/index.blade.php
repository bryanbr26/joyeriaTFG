@extends("layouts.layout")

@section("title", $titulo)

@section("content")

<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>{{ $titulo }}</h2>

        <div>

            <form method="GET" action="">
                <!-- Dropdown de filtros -->
                <div class="dropdown mb-3">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownFiltrar" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                        Filtrar por
                    </button>
                    
                    <div class="dropdown-menu p-3" aria-labelledby="dropdownFiltrar" style="min-width: 300px;">
                        
                        <!-- Marca -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Marca</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="marca[]" value="marca1" id="marca1">
                                <label class="form-check-label" for="marca1">Marca 1</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="marca[]" value="marca2" id="marca2">
                                <label class="form-check-label" for="marca2">Marca 2</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="marca[]" value="marca3" id="marca3">
                                <label class="form-check-label" for="marca3">Marca 3</label>
                            </div>
                        </div>
                        
                        <!-- Género -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Género</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="genero[]" value="hombre" id="generoHombre">
                            <label class="form-check-label" for="generoHombre">Hombre</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="genero[]" value="mujer" id="generoMujer">
                            <label class="form-check-label" for="generoMujer">Mujer</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="genero[]" value="unisex" id="generoUnisex">
                            <label class="form-check-label" for="generoUnisex">Unisex</label>
                        </div>
                    </div>
                    
                    <!-- Color -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Color</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="color[]" value="oro" id="colorOro">
                            <label class="form-check-label" for="colorOro">Oro</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="color[]" value="plata" id="colorPlata">
                            <label class="form-check-label" for="colorPlata">Plata</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="color[]" value="acero" id="colorAcero">
                            <label class="form-check-label" for="colorAcero">Acero</label>
                        </div>
                    </div>
                    
                    <!-- Material -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Material</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="material[]" value="oro" id="materialOro">
                            <label class="form-check-label" for="materialOro">Oro</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="material[]" value="plata" id="materialPlata">
                            <label class="form-check-label" for="materialPlata">Plata</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="material[]" value="acero" id="materialAcero">
                            <label class="form-check-label" for="materialAcero">Acero</label>
                        </div>
                    </div>
                    
                    <!-- Precio -->
                    <div class="mb-3">
                        <label for="filtroPrecio" class="form-label fw-bold">Precio máximo</label>
                        <input type="range" min="0" max="1000" value="500" class="form-range" id="filtroPrecio" name="precio">
                        <div><span id="precioValor">500</span> €</div>
                    </div>
                    
                    <!-- Talla -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Talla</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="talla[]" value="S" id="tallaS">
                            <label class="form-check-label" for="tallaS">S</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="talla[]" value="M" id="tallaM">
                            <label class="form-check-label" for="tallaM">M</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="talla[]" value="L" id="tallaL">
                            <label class="form-check-label" for="tallaL">L</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="talla[]" value="XL" id="tallaXL">
                            <label class="form-check-label" for="tallaXL">XL</label>
                        </div>
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary btn-sm">Aplicar filtros</button>
                        <a href="" class="btn btn-outline-secondary btn-sm">Limpiar</a>
                    </div>
                </div>
            </div>
            
        </form>
    </div>
    <!-- Dropdown de ordenar -->
    <div class="dropdown mb-3">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownOrdenar" data-bs-toggle="dropdown" aria-expanded="false">
            Ordenar por
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownOrdenar">
            <li><button class="dropdown-item" type="submit" name="orden" value="precio_asc">Precio ascendente</button></li>
            <li><button class="dropdown-item" type="submit" name="orden" value="precio_desc">Precio descendente</button></li>
        </ul>
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

@endsection
