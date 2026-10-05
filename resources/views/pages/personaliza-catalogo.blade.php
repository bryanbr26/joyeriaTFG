@extends("layouts.layout")

@section("title", $titulo)

@section("content")

<div class="page-joyas" id="page-joyas">
    <div class="contenedor-titulo-filtros">
        <h2>{{ $titulo }}</h2>
        @if($subtitulo)
            <p class="text-muted mb-0">{{ $subtitulo }}</p>
        @endif
    </div>

    <p class="text-center text-muted mb-4">Elige la joya que quieres grabar y empieza a diseñar tu personalización.</p>

    @if($productos->count() > 0)
        <div class="productos-fila">
            @foreach($productos as $producto)
                <div class="producto-item">
                    <a href="{{ route('personaliza.producto', $producto) }}" class="producto-enlace">
                        <div class="producto-card">
                            @if($producto->imagen_principal_url)
                                <img src="{{ $producto->placeholder }}"
                                     data-src="{{ $producto->imagen_optimizada }}"
                                     loading="lazy"
                                     decoding="async"
                                     class="producto-imagen lazy-image blur-up"
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
                                <span class="btn-personalizar mt-2">
                                    <i class="bi bi-brush"></i>
                                    <span>Personalizar</span>
                                </span>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $productos->links() }}
        </div>
    @else
        <div class="productos-vacio">
            <i class="bi bi-inbox vacio-icono"></i>
            <h3>No hay joyas grabables disponibles</h3>
            <a href="{{ route('personaliza') }}" class="btn-crear">
                <i class="bi bi-arrow-left"></i> Ver todas
            </a>
        </div>
    @endif
</div>

@endsection
