@extends("layouts.layout")

@section("hero")

<!-- 1. Hero Orfebrería (el fondo vive en layouts/layout.blade.php) -->
<section class="contenedor-orfebreria-hero">

    <div class="contenedor-principal-wrapper">
        
            
        <div class="subtitulo">Orfebrería artesanal</div>

        <h1 class="titulo-orfebreria">El arte del metal, forjado a mano</h1>
        <p class="contenido-orfebreria">Ea esse occaecat culpa veniam tempor veniam est Lorem amet aliquip esse. Ad magna duis ipsum nostrud sit ea sint ex laboris.</p>

        <div class="fila-botones">
            <a href="{{ route('joyas.index', 'anillos') }}" class="btn btn-coleccion">Explorar colección</a>
            <a href="{{ route('joyas.index', 'colecciones') }}" class="btn btn-proceso">Nuestro proceso</a>
        </div>
        <hr class="separador-hero">

    </div>

   

</section>

@endsection

@section("content")
<section class="contenedor-orfebreria-info">
        <div class="img-orfebreria">
            {!! responsive_picture('fondos/taller-orfebre.png', 'Fondo de la sección de orfebrería', ['loading' => 'lazy', 'decoding' => 'async', 'class' => 'lazy-image blur-up']) !!}
        </div>
        <div class="contendor-texto">
            <h2 class="titulo-info"> Dolor eu minim est non magna ullamco deserunt laborum ex velit</h2>
            <p class="contenido-info">duis do quis. Occaecat culpa do velit aliquip veniam irure exercitation. Fugiat esse sint veniam anim sunt in. Veniam et qu iint culpa consequat commodo dolore ullamco mollit ex aliquip. Consectetur veniam non incididuntduis do quis. Occaecat culpa do velit aliquip veniam irure exercitation. Fugiat esse sint veniam anim sunt in. Veniam et qu iint culpa consequat commodo dolore ullamco mollit ex aliquip. Consectetur veniam non incididunt</p>
            <a href="{{ route('joyas.index', 'colecciones') }}" class="btn-info-proceso">Descubre más</a>
        </div>    
</section>
<section class="contenedor-orfebreria-imagenes">
   <div class="titulo-orfebreria">Nuestras creaciones propias</div>

   <div class="galeria-orfebre" id="galeria-orfebre">
        {!! responsive_picture('joyas-orfebres/colgante-marco-beige.png', 'Colgante dorado', ['loading' => 'lazy', 'decoding' => 'async', 'class' => 'lazy-image blur-up colgante-dorado']) !!}

        {!! responsive_picture('joyas-orfebres/anillo-marco-verde.png', 'Anillo de plata', ['loading' => 'lazy', 'decoding' => 'async', 'class' => 'lazy-image blur-up anillo-serpiente']) !!}

        {!! responsive_picture('joyas-orfebres/colgante-marco-dorado.png', 'Anillo de oro', ['loading' => 'lazy', 'decoding' => 'async', 'class' => 'lazy-image blur-up colgante-oro']) !!}

        {!! responsive_picture('joyas-orfebres/colgante-marco-rosa-.png', 'Anillo de oro', ['loading' => 'lazy', 'decoding' => 'async', 'class' => 'lazy-image blur-up colgante-rosa']) !!}

        {!! responsive_picture('joyas-orfebres/collar-azul-marco-blanco.png', 'Anillo de oro', ['loading' => 'lazy', 'decoding' => 'async', 'class' => 'lazy-image blur-up collar-azul']) !!}

   </div>
</section>
<section class="contenedor-orfebreria-contacto">
    <div class="titulo-formulario">
        Contacta con nosotros
    </div>
    <div class="formulario-consultas-cita">
        <form action="" method="POST" class="formulario-consultas">
            @csrf
            <div class="encabezado-formulario">
                <div class="primera-columna">
                    <div class="campo-formulario">
                        <label for="nombre">Nombre</label>
                        <input type="text" id="nombre" name="nombre" required>
                    </div>

                    <div class="campo-formulario">
                        <label for="email">Correo electrónico</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="campo-formulario">
                        <label for="telefono">Teléfono (opcional)</label>
                        <input type="tel" id="telefono" name="telefono">
                    </div>
                    <div class="campo-formulario">
                        <label for="asunto">Motivo de la consulta</label>
                        <select id="asunto" name="asunto" required>
                            <option value="">Seleccione un motivo</option>
                            <option value="consulta">Consulta</option>
                            <option value="cita">Solicitud de cita</option>
                            <option value="otro">Otro</option>
                        </select>
                    </div>
                </div>
                
                <div class="segunda-columna"> 
                    <div class="campo-mensaje">
                        <label for="mensaje">Cuéntanos tu idea:</label>
                        <textarea id="mensaje" name="mensaje" rows="4" required></textarea>
                    </div>
                    <div class="campo-imagen">
                        <span class="etiqueta-imagen">Imagen de referencia: <small>(opcional)</small></span>
                        <label for="imagen" class="btn-cargar-imagen">Cargar imagen:</label>
                        <input type="file" id="imagen" name="imagen" class="imagen" accept="image/*" hidden>
                    </div>
                </div>
            </div>
            <div class="footer-formulario">
                <div class="privacidad">
                    <input type="checkbox" id="privacidad" name="privacidad" required>
                    <label for="privacidad">He leído y acepto la <a href="#">Política de Privacidad</a> *</label>
                </div>
                <button type="submit" class="btn-enviar">Enviar solicitud</button>
            </div>
        </form>
    </div>

    <div class="reloj-wrapper">
        {!! responsive_picture('fondos/reloj_sin_agujas.png', 'Fondo de la sección de orfebrería', ['loading' => 'lazy', 'decoding' => 'async', 'class' => 'lazy-image blur-up reloj']) !!}

        {{-- Agujas SVG animadas desde orfebreria.js. Pivote del mecanismo: (1456, 2306) del viewBox. --}}
        <svg class="agujas" viewBox="0 0 3138 4832" aria-hidden="true">
            <defs>
                <linearGradient id="facetDark" x1="0" y1="0" x2="1" y2="0">
                    <stop offset="0" stop-color="#5f3a20"/>
                    <stop offset="0.25" stop-color="#7d5636"/>
                    <stop offset="1" stop-color="#a07447"/>
                </linearGradient>
                <linearGradient id="facetLight" x1="0" y1="0" x2="1" y2="0">
                    <stop offset="0" stop-color="#e8c491"/>
                    <stop offset="0.45" stop-color="#c69660"/>
                    <stop offset="0.85" stop-color="#d9a870"/>
                    <stop offset="1" stop-color="#f0d3a4"/>
                </linearGradient>
                <linearGradient id="secGrad" x1="0" y1="0" x2="1" y2="0">
                    <stop offset="0" stop-color="#6e4426"/>
                    <stop offset="0.5" stop-color="#e3b57e"/>
                    <stop offset="1" stop-color="#6e4426"/>
                </linearGradient>
                <radialGradient id="capGold" cx=".38" cy=".35" r=".9">
                    <stop offset="0" stop-color="#f4d8ab"/><stop offset=".55" stop-color="#c98f5c"/><stop offset="1" stop-color="#8a5530"/>
                </radialGradient>
                <filter id="handShadow" x="-30%" y="-30%" width="160%" height="160%">
                    <feDropShadow dx="10" dy="8" stdDeviation="9" flood-color="#3a2c1c" flood-opacity="0.35"/>
                </filter>
            </defs>

            <g id="reloj-hora" filter="url(#handShadow)">
                <path fill="url(#facetDark)"  d="M0,55 L-14,50 L-45,-90 L-44,-180 L-40,-280 L-34,-380 L-27,-480 L-19,-580 L-10,-690 L0,-770 Z"/>
                <path fill="url(#facetLight)" d="M0,55 L14,50 L45,-90 L44,-180 L40,-280 L34,-380 L27,-480 L19,-580 L10,-690 L0,-770 Z"/>
                <path fill="#f7e3c0" opacity="0.45" d="M-1.5,-60 L0,-765 L1.5,-60 Z"/>
                <path fill="none" stroke="#4e2f18" stroke-width="2.5" opacity="0.8"
                      d="M-14,50 L-45,-90 L-44,-180 L-40,-280 L-34,-380 L-27,-480 L-19,-580 L-10,-690 L0,-770 L10,-690 L19,-580 L27,-480 L34,-380 L40,-280 L44,-180 L45,-90 L14,50"/>
            </g>

            <g id="reloj-minuto" filter="url(#handShadow)">
                <path fill="url(#facetDark)"  d="M0,110 L-7,105 L-40,-60 L-39,-200 L-32,-350 L-26,-500 L-17,-650 L-11,-800 L-6,-950 L-2,-1060 L0,-1110 Z"/>
                <path fill="url(#facetLight)" d="M0,110 L7,105 L40,-60 L39,-200 L32,-350 L26,-500 L17,-650 L11,-800 L6,-950 L2,-1060 L0,-1110 Z"/>
                <path fill="#f7e3c0" opacity="0.45" d="M-1,100 L0,-1105 L1,100 Z"/>
                <path fill="none" stroke="#4e2f18" stroke-width="2.5" opacity="0.8"
                      d="M-7,105 L-40,-60 L-39,-200 L-32,-350 L-26,-500 L-17,-650 L-11,-800 L-6,-950 L-2,-1060 L0,-1110 L2,-1060 L6,-950 L11,-800 L17,-650 L26,-500 L32,-350 L39,-200 L40,-60 L7,105"/>
            </g>

            <g id="reloj-segundo" filter="url(#handShadow)">
                <path fill="url(#facetDark)"  d="M0,70 L-11,100 L-9,220 L-6,340 L-2,430 L0,445 Z"/>
                <path fill="url(#facetLight)" d="M0,70 L11,100 L9,220 L6,340 L2,430 L0,445 Z"/>
                <path fill="url(#secGrad)" d="M-4,-60 L-4,-1050 L-2,-1080 L2,-1080 L4,-1050 L4,-60 Z"/>
                <circle cx="0" cy="0" r="20" fill="none" stroke="#b87a4e" stroke-width="7"/>
                <circle cx="0" cy="0" r="20" fill="none" stroke="#f0d3a4" stroke-width="2" opacity="0.7"/>
            </g>

            <g id="reloj-tapa" transform="translate(1456 2306)">
                <circle r="100" fill="none" stroke="#c9a06b" stroke-width="5" opacity="0.85"/>
                <circle r="104" fill="none" stroke="#8a6a45" stroke-width="2" opacity="0.5"/>
                <circle r="56" fill="url(#capGold)"/>
                <circle r="56" fill="none" stroke="#7d4e2c" stroke-width="3"/>
                <circle r="40" fill="none" stroke="#a06a3f" stroke-width="4"/>
                <circle r="24" fill="none" stroke="#e8c491" stroke-width="2" opacity="0.8"/>
            </g>
        </svg>
    </div>
</section>

@endsection

@push('scripts')
<script src="{{ asset('js/pages/orfebreria.js') }}"></script>
@endpush
