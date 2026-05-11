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
        {{-- Contenedor principal --}}
        <div class="productos-showcase">

            @if(count($productos) > 0)
                @php $productoDestacado = $productos->first(); @endphp

                {{-- Producto destacado --}}
                <div class="producto-destacado">
                    <a href="{{ route('joyas.show', [$categoria, $productoDestacado]) }}" class="producto-enlace">
                        <div class="producto-card producto-card--grande">
                            @if($productoDestacado->ruta_grabado && file_exists(public_path('storage/' . $productoDestacado->ruta_grabado)))
                                <img src="{{ asset('storage/' . $productoDestacado->ruta_grabado) }}" class="producto-imagen"
                                    alt="{{ $productoDestacado->nombre }}">
                            @else
                                <div class="producto-imagen--placeholder">
                                    <i class="bi bi-gem icono-placeholder"></i>
                                </div>
                            @endif

                            <div class="producto-overlay">
                                <h3 class="producto-titulo">{{ $productoDestacado->nombre }}</h3>
                                <p class="producto-marca">{{ $productoDestacado->marca }}</p>
                                <p class="producto-precio">{{ number_format($productoDestacado->precio, 2) }} €</p>
                                <span class="producto-badge">Destacado</span>
                            </div>
                        </div>
                    </a>
                </div>

                {{-- Grid de productos secundarios --}}
                <div class="productos-secundarios">
                    @forelse($productos->slice(1, 4) as $producto)
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
                                        <p class="producto-stock">Stock: {{ $producto->stock }}</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @empty
                        {{-- Sin productos adicionales --}}
                    @endforelse
                </div>

            @else
                <div class="productos-vacio">
                    <i class="bi bi-inbox vacio-icono"></i>
                    <h3>No hay {{ strtolower($titulo) }} registrados</h3>
                    <a href="{{ route('joyas.create', $categoria) }}" class="btn-crear">
                        <i class="bi bi-plus-circle"></i> Crear uno
                    </a>
                </div>
            @endif

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