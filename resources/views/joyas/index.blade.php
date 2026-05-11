@extends("layouts.layout")

@section("title", $titulo)

@section("content")

    <div class="page-joyas" id="page-joyas">
        <div class="contenedor-titulo-filtros">
            <h2>{{ $titulo }}</h2>
            <div class="contenedor-filtros">
                <div class="filtrar">
                    <p>Filtrar Por:</p>
                    <i class="bi bi-list"></i>
                </div>
                <div class="ordenar">
                    <p>Ordenar Por:</p>
                    <i class="bi bi-list"></i>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        <!--Fila con imagen a la izquierda y productos a la derecha -->
        {{-- Layout principal con imagen destacada y grid 2x2 --}}
        <div class="container my-4">
            <div class="row g-3">
                {{-- Verificar si hay al menos un producto para mostrar como destacado --}}
                @if(count($productos) > 0)
                    {{-- Imagen destacada del primer producto - Ocupa 6 columnas (50%) --}}
                    <div class="col-md-6">
                        @php $productoDestacado = $productos->first(); @endphp
                        <a href="{{ route('joyas.show', [$categoria, $productoDestacado]) }}"
                            class="text-decoration-none text-dark">
                            <div class="card h-100 border-0 shadow-sm position-relative overflow-hidden"
                                style="min-height: 430px;">
                                @if($productoDestacado->ruta_grabado && file_exists(public_path('storage/' . $productoDestacado->ruta_grabado)))
                                    <img src="{{ asset('storage/' . $productoDestacado->ruta_grabado) }}"
                                        class="card-img-top h-100 w-100" alt="{{ $productoDestacado->nombre }}"
                                        style="object-fit: cover; position: absolute; top: 0; left: 0;">
                                @else
                                    <div class="bg-light d-flex align-items-center justify-content-center h-100"
                                        style="position: absolute; top: 0; left: 0; width: 100%;">
                                        <i class="bi bi-gem fs-1 text-muted" style="font-size: 4rem !important;"></i>
                                    </div>
                                @endif

                                {{-- Overlay con información --}}
                                <div class="position-absolute bottom-0 start-0 w-100 p-4 text-white"
                                    style="background: linear-gradient(transparent, rgba(0,0,0,0.8));">
                                    <h4 class="fw-bold mb-2">{{ $productoDestacado->nombre }}</h4>
                                    <p class="mb-1 small opacity-75">{{ $productoDestacado->marca }}</p>
                                    <p class="mb-0 fs-5 fw-bold">{{ number_format($productoDestacado->precio, 2) }} €</p>
                                    <span class="badge bg-primary mt-2">Destacado</span>
                                </div>
                            </div>
                        </a>
                    </div>

                    {{-- Grid 2x2 de los siguientes 4 productos - Ocupa 6 columnas (50%) --}}
                    <div class="col-md-6">
                        <div class="row g-3">
                            @forelse($productos->slice(1, 4) as $producto)
                                <div class="col-6">
                                    <a href="{{ route('joyas.show', [$categoria, $producto]) }}"
                                        class="text-decoration-none text-dark">
                                        <div class="card h-100 shadow-sm hover-card">
                                            @if($producto->ruta_grabado && file_exists(public_path('storage/' . $producto->ruta_grabado)))
                                                <img src="{{ asset('storage/' . $producto->ruta_grabado) }}" class="card-img-top"
                                                    alt="{{ $producto->nombre }}" style="height: 200px; object-fit: cover;">
                                            @else
                                                <div class="card-img-top bg-light d-flex align-items-center justify-content-center"
                                                    style="height: 200px;">
                                                    <i class="bi bi-gem fs-1 text-muted"></i>
                                                </div>
                                            @endif
                                            <div class="card-body d-flex flex-column">
                                                <h6 class="card-title fw-bold">{{ Str::limit($producto->nombre, 30) }}</h6>
                                                <p class="card-text text-muted small mb-1">{{ $producto->marca }}</p>
                                                <p class="card-text small text-muted mb-2">
                                                    {{ Str::limit($producto->descripcion, 40) }}
                                                </p>
                                                <p class="card-text fw-bold text-primary mt-auto mb-1">
                                                    {{ number_format($producto->precio, 2) }} €
                                                </p>
                                                <p class="card-text mb-0">
                                                    <small class="text-muted">Stock: {{ $producto->stock }}</small>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @empty
                                {{-- No se muestran productos adicionales si solo hay 1 --}}
                            @endforelse
                        </div>
                    </div>
                @else
                    {{-- Mensaje cuando no hay productos --}}
                    <div class="col-12">
                        <div class="alert alert-info text-center py-5">
                            <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                            <h5>No hay {{ strtolower($titulo) }} registrados</h5>
                            <a href="{{ route('joyas.create', $categoria) }}" class="btn btn-primary mt-2">
                                <i class="bi bi-plus-circle"></i> Crear uno
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
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