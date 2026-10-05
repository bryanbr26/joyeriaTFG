@extends("layouts.layout")

@section("content")

<section class="section-grabados">
    <div class="imagen-info">
     

          {!! responsive_picture('img-informativas/regalos-banner.png', 'grabado', ['loading' => 'lazy', 'decoding' => 'async', 'class' => 'lazy-image blur-up img-regalos']) !!}
    </div>
    <div class="info-grabados">
        <h2>Regalos para grabar tus momentos</h2>
        <p>Aliquip ex qui proident commodo in voluptate commodo laboris qui Lorem officia cupidatat proident non. Ut deserunt dolore </p>
        <a href="{{ route('joyas.index', 'pendientes') }}" class="btn-regalos">Descubre más</a>
    </div>

</section>
<section class="section-ocasiones">
    <div class="fila-ocasiones">
        <a href="{{ url('/regalos/bodas') }}" class="tarjeta-ocasion">
              {!! responsive_picture('img-informativas/banner-bodas.png', 'bodas', ['loading' => 'lazy', 'decoding' => 'async', 'class' => 'lazy-image blur-up img-bodas']) !!}
              <h2>Compromisos y Bodas</h2>
        </a>
           <a href="{{ url('/regalos/ninos') }}" class="tarjeta-ocasion">
              {!! responsive_picture('img-informativas/banner-para-niños.png', 'niños', ['loading' => 'lazy', 'decoding' => 'async', 'class' => 'lazy-image blur-up img-niños']) !!}
              <h2>Los mas pequeños</h2>
        </a>
           <a href="{{ url('/regalos/cumpleanos') }}" class="tarjeta-ocasion">
              {!! responsive_picture('img-informativas/banner-cumples.png', 'cumples', ['loading' => 'lazy', 'decoding' => 'async', 'class' => 'lazy-image blur-up img-cumples']) !!}
              <h2>Cumpleaños</h2>
        </a>
    </div>
</section>

<section class="section-conjuntos">
    <div class="info-conjuntos">
        <h2>El regalo perfecto en conjunto</h2>
        <p>Aliquip sit occaecat velit culpa ex aute cillum esse officia dolor. </p>
        <a href="{{ route('joyas.index', 'pendientes') }}" class="btn-regalos">Descubre más</a>
    </div>
    <div class="img-conjuntos">
        {!! responsive_picture('img-informativas/banner-conjuntos.png', 'conjuntos', ['loading' => 'lazy', 'decoding' => 'async', 'class' => 'lazy-image blur-up img-conjunto']) !!}
    </div>

</section>

<section class="section-bestseller">
    <div class="titulo">
        <h2>Más vendidos</h2>
    </div>
    <div class="fila-productos">
        @if($masVendidos->isNotEmpty())
            <div class="productos-fila">
                @foreach($masVendidos as $producto)
                    @php($categoriaProducto = $categoriaUrlByDb[$producto->categoria] ?? $producto->categoria)
                    <div class="producto-item">
                        <a href="{{ route('joyas.show', [$categoriaProducto, $producto]) }}" class="producto-enlace">
                            <div class="producto-card">
                                @if($producto->imagen_principal_url)
                                    <img src="{{ $producto->imagen_principal_url }}"
                                         loading="lazy"
                                         decoding="async"
                                         class="producto-imagen"
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
    </div>
</section>

<section class="section-genero">
    <a href="{{ url('/regalos/bodas') }}" class="tarjeta-genero">
              {!! responsive_picture('regalos-img/brazalete-hombre.png', 'brazalete-hombre', ['loading' => 'lazy', 'decoding' => 'async', 'class' => 'lazy-image blur-up brazalete-hombre']) !!}
              <h2>Regalos para él</h2>
    </a>
     <a href="{{ url('/regalos/bodas') }}" class="tarjeta-genero">
              {!! responsive_picture('regalos-img/brazalete-plata-mujer.png', 'brazalete-mujer', ['loading' => 'lazy', 'decoding' => 'async', 'class' => 'lazy-image blur-up brazalete-mujer']) !!}
              <h2>Regalos para ella</h2>
    </a>
</section>

<section class="section-precios">
    <div class="fila-regalos-uno">
        <a href="{{ url('/regalos/bodas') }}" class="tarjeta-regalos">
              {!! responsive_picture('regalos-img/banner-regalo-uno.png', 'regalo-uno', ['loading' => 'lazy', 'decoding' => 'async', 'class' => 'lazy-image blur-up regalo-uno']) !!}
              <h2>Menos de 50€</h2>
        </a>
           <a href="{{ url('/regalos/ninos') }}" class="tarjeta-regalos">
              {!! responsive_picture('regalos-img/banner-regalo-dos.png', 'regalo-dos', ['loading' => 'lazy', 'decoding' => 'async', 'class' => 'lazy-image blur-up regalo-dos']) !!}
              <h2>Menos de 100€</h2>
        </a>
           <a href="{{ url('/regalos/cumpleanos') }}" class="tarjeta-regalos">
              {!! responsive_picture('regalos-img/banner-regalo-tres.png', 'regalo-tres', ['loading' => 'lazy', 'decoding' => 'async', 'class' => 'lazy-image blur-up regalo-tres']) !!}
              <h2>Menos de 200€</h2>
        </a>
    </div>
    <div class="fila-regalos-dos">
        <a href="{{ url('/regalos/bodas') }}" class="tarjeta-regalo">
              {!! responsive_picture('regalos-img/banner-regalo-cuatro.png', 'regalo-cuatro', ['loading' => 'lazy', 'decoding' => 'async', 'class' => 'lazy-image blur-up regalo-cuatro']) !!}
              <h2>Mas de 500€</h2>
        </a>
    </div>
</section>
@endsection
