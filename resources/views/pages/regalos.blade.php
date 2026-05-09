@extends("layouts.layout")

@section("content")

<div id="portada_regalos">
    <div id="imagen_portada_regalos">
        <img src="{{ asset('') }}" alt="">
    </div>
    <div id="texto_portada_regalos">
        <h2>Regalos para grabar</h2>
        <h4>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur eget</h4>
    </div>
</div>
<div id="opciones_regalos">
    <div class="row row-cols-1 row-cols-md-3 mb-3 text-center"> 
        <div class="col"> 
            <div class="card mb-4 rounded-3 shadow-sm"> 
                <img src="{{ asset('img/joyeria/anillos.png') }}" alt="anillo_regalos" class="img-fluid">
                <h3>Compromiso y bodas</h3>
            </div> 
        </div> 
        <div class="col"> 
            <div class="card mb-4 rounded-3 shadow-sm"> 
                 <img src="{{ asset('img/joyeria/pulseras.png') }}" alt="pulseras_regalos" class="img-fluid"> 
                 <h3>Niños</h3>
            </div> 
        </div> 
        <div class="col"> 
            <div class="card mb-4 rounded-3 shadow-sm"> 
                 <img src="{{ asset('img/joyeria/collares.png') }}" alt="collares_regalos" class="img-fluid"> 
                 <h3>Cumpleaños</h3>
            </div> 
        </div> 
    </div>
</div>
<div id="conjuntos_regalos">
    <div id="texto_conjuntos">
        <h2>Conjuntos</h2>
        <h4>Encuentra conjuntos de joyas que haran tus momentos mas especiales</h4>
    </div>
    <div id="imagen_conjuntos">
        <img src="{{ asset('') }}" alt="" class="img-fluid">
    </div>
</div><!--
<div id="mas_vendidos_regalos">
    <div id="titulo_mas_vendidos_regalos">
        <h2>Más vendidos</h2>
    </div>
    <div id="productos_mas_vendidos_regalos">
        <div id="producto_1">
            <img src="" alt="">
        </div>
        <div id="producto_2">
            <img src="" alt="">
        </div>
        <div id="producto_3">
            <img src="" alt="">
        </div>
        <div id="producto_4">
            <img src="" alt="">
        </div>
    </div>
</div>-->
<div id="imagenes_grandes_regalos">
    <div id="imagen1">
        <img src="{{ asset('') }}" alt="">
    </div>
    <div id="imagen2">
        <img src="{{ asset('') }}" alt="">
    </div>
</div>
<div id="imagenes_peques_regalos">
    <div class="row row-cols-1 row-cols-md-3 mb-3 text-center"> 
        <div class="col"> 
            <div class="card mb-4 rounded-3 shadow-sm"> 
                <img src="{{ asset('img/joyeria/anillos.png') }}" alt="anillo_regalos" class="img-fluid">
                <h3>Menos de 50€</h3>
            </div> 
        </div> 
        <div class="col"> 
            <div class="card mb-4 rounded-3 shadow-sm"> 
                 <img src="{{ asset('img/joyeria/pulseras.png') }}" alt="pulseras_regalos" class="img-fluid"> 
                 <h3>Menos de 100€</h3>
            </div> 
        </div> 
        <div class="col"> 
            <div class="card mb-4 rounded-3 shadow-sm"> 
                 <img src="{{ asset('img/joyeria/collares.png') }}" alt="collares_regalos" class="img-fluid"> 
                 <h3>Menos de 200€</h3>
            </div> 
        </div> 
    </div>
</div>
<div id="imagenes_grande_regalos">
    <img src="{{ asset('') }}" alt="">
    <h4>Menos de 500€</h4>
</div>

@endsection