<header class="border-bottom main-header">
    <div class="container-fluid d-flex flex-row justify-content-center align-items-center py-2 top-bar-container">
        <div class="LogoLetra">
            <a href="{{ route('index') }}">
                JOYAS PÉREZ
            </a>
        </div>
    </div>

    <!-- Fila 2: Buscador e Iconos -->
    <div class="container-fluid py-2 icon-bar-container" id="header-icon">
        <!-- Iconos -->
        <div class="col-auto" id="contenedor-iconos">
            <div class="d-flex gap-4 " id="contenedor-botones">
            
                <!-- boton buscador-->
                <a id="boton-buscador" style="cursor: pointer;" class="header-icon-link" title="Buscador"><i
                        class="bi bi-search fs-5"></i></a>
                <!-- boton gestion usuarios-->
                @auth
                    <a href="{{ route('panel.usuario') }}" class="header-icon-link" title="Mi Cuenta">
                        <i class="bi bi-person fs-5"></i>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="header-icon-link" title="Gestión Usuarios">
                        <i class="bi bi-person fs-5"></i>
                    </a>
                @endauth
                <!-- boton ubicacion-->
                <a href="{{ route('contacto') }}" class="header-icon-link" title="ubicacion">
                    <i class="bi bi-geo-alt fs-5"></i>
                </a>
                <a href="{{ route('favoritos.index') }}" class="header-icon-link" title="Favoritos">
                    <i class="bi bi-heart fs-5"></i>
                </a>
                <a href="{{ route('carrito.index') }}" class="header-icon-link position-relative" title="Carrito">
                    <i class="bi bi-bag fs-5"></i>
                    <span id="cart-count" class="position-absolute top-0 start-100 translate-middle badge bg-danger">
                        {{ $totalItemsCarrito ?? 0 }}
                    </span>
                </a>
                 <a id="menu-toggle" class="header-icon-link menu-toggle" title="Menú">
                    <i class="bi bi-list fs-5"></i>
                </a>
            </div>
        </div>

    </div>

    <!-- Navegación con Mega Menú -->
    <nav class="border-top navbar-light" id="nav-bar">
        <button id="nav-close" class="nav-close" aria-label="Cerrar menú">
            <i class="bi bi-x-lg"></i>
        </button>
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <ul class="nav justify-content-center py-2">
                        
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="#" id="navbarDropdown" role="button">
                                Joyería
                            </a>

                            <!-- Mega Menú -->
                            <div class="dropdown-menu joyeria-mega-menu" aria-labelledby="navbarDropdown">
                                <!-- Columna Izquierda: Lista de categorías -->
                                <div class="titulo-contenedor">
                                    <h3>JOYERIA</h3>
                                </div>
                                <div class="lista-joyas-container">
                                    <ul class="lista-joyas">
                                        <li class="categoria-item"
                                            data-imagen="{{ asset('images/joyas/collares.jpg') }}">
                                            <a href="{{ route('joyas.index', 'collares') }}">Collares</a>
                                        </li>
                                        <li class="categoria-item"
                                            data-imagen="{{ asset('images/joyas/anillos.jpg') }}">
                                            <a href="{{ route('joyas.index', 'anillos') }}">Anillos</a>
                                        </li>
                                        <li class="categoria-item"
                                            data-imagen="{{ asset('images/joyas/pulseras.jpg') }}">
                                            <a href="{{ route('joyas.index', 'pulseras') }}">Pulseras</a>
                                        </li>
                                        <li class="categoria-item"
                                            data-imagen="{{ asset('images/joyas/pendientes.jpg') }}">
                                            <a href="{{ route('joyas.index', 'pendientes') }}">Pendientes</a>
                                        </li>
                                    </ul>
                                </div>

                                <!-- Columna Derecha: Imagen dinámica -->
                                <div class="img-drop-down">
                                    <img id="categoria-imagen" src="{{ asset('images/joyas/exclusiva.webp') }}"
                                        alt="Categoría destacada">
                                    <div class="imagen-texto">Pasa el mouse sobre una categoría</div>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="#" id="navbarDropdown" role="button">
                                Regalos
                            </a>

                            <!-- Mega Menú -->
                            <div class="dropdown-regalos" aria-labelledby="navbarDropdown">
                                <!-- Columna Izquierda: Lista de categorías -->
                                <div class="titulo-contenedor-regalos">
                                    <h3>IDEAS PARA REGALOS</h3>
                                </div>
                                <div class="lista-regalos-container">
                                    <ul class="lista-regalos">
                                        <li class="categoria-regalos">
                                            <a href="{{ route('joyas.buscar', ['categoria' => 'anillo', 'pendientes', 'collar', 'pulsera']) }}" style="font-weight: bold;">Categoria</a>
                                            <br>
                                            <a href="{{ route('joyas.buscar', ['categoria' => 'anillo', 'pendientes', 'collar', 'pulsera']) }}">Mas Vendidos</a>
                                            <a href="{{ route('joyas.buscar', ['categoria' => ['anillo', 'pendientes', 'collar', 'pulsera']]) }}">Cojuntos de regalo</a>
                                            <a href="{{ route('joyas.buscar', ['categoria' => 'anillo', 'pendientes', 'collar', 'pulsera']) }}">Regalos para grabar</a>
                                        </li>

                                        <li class="ocasiones-item">
                                            <a href="{{ route('joyas.buscar', ['categoria' => 'anillo', 'pendientes', 'collar', 'pulsera']) }}" style="font-weight: bold;">Ocasiones especiales</a>
                                            <br>
                                            <a href="{{ route('joyas.buscar', ['categoria' => 'anillo']) }}">Bodas</a>
                                            <br>
                                            <a href="{{ route('joyas.buscar', ['categoria' => 'anillo', 'pendientes', 'collar', 'pulsera']) }}">Comuniones</a>
                                            <br>
                                            <a href="{{ route('joyas.buscar', ['categoria' => 'anillo']) }}">Compromisos</a>
                                            <br>
                                            <a href="{{ route('joyas.buscar', ['categoria' => 'pendientes', 'collar', 'pulsera']) }}">Aniversario</a>
                                            <br>
                                            <a href="{{ route('joyas.buscar', ['categoria' => 'pendientes']) }}">Bautizo</a>
                                            <br>
                                        </li>
                                        <li class="regalos-item">
                                            <a href="{{ route('joyas.buscar', ['genero' => 'unisex']) }}" style="font-weight: bold;">Regalos para</a>
                                            <br>
                                            <a href="{{ route('joyas.buscar', ['genero' => 'mujer']) }}">Para ella</a>
                                            <br>
                                            <a href="{{ route('joyas.buscar', ['genero' => 'hombre']) }}">Para él</a>
                                            <br>
                                            <a href="{{ route('joyas.buscar', ['genero' => 'niño']) }}">Niños</a>
                                            <br>
                                            <a href="{{ route('joyas.buscar', ['categoria' => 'anillo']) }}">Pareja</a>
                                            <br>
                                            <a href="{{ route('joyas.buscar', ['categoria' => ['anillo', 'pulsera', 'collar', 'pendiente']]) }}">Padres</a>
                                            <br>
                                        </li>
                                        <li class="presupuesto-item">
                                            <a href="{{ route('joyas.buscar', ['precio_max' => 1000]) }}" style="font-weight: bold;">Presupuesto</a>
                                            <br>
                                            <a href="{{ route('joyas.buscar', ['precio_max' => 50]) }}">Menos de 50€</a>
                                            <a href="{{ route('joyas.buscar', ['precio_max' => 100]) }}">Menos de 100€</a>
                                            <a href="{{ route('joyas.buscar', ['precio_max' => 250]) }}">Menos de 250€</a>
                                            <a href="{{ route('joyas.buscar', ['precio_min' => 250]) }}">Mas de 250€</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link fw-medium" href="{{ route('joyas.buscar') }}" id="navbarDropdown"
                                role="button">Personaliza tus joyas</a>
                            <div class="dropdown-personaliza" aria-labelledby="navbarDropdown">
                                <!-- Columna Izquierda: Lista de categorías -->
                                <div class="titulo-contenedor-personaliza">
                                    <h3>PERSONALIZA TUS JOYAS</h3>
                                </div>
                                <div class="lista-personaliza-container">
                                    <ul class="lista-personaliza">
                                        <li class="categoria-personaliza">
                                            <a href="{{ route('personaliza') }}"
                                                style="font-weight: bold;">Categoria</a>
                                            <br>
                                            <a href="{{ route('personaliza') }}">Grabado de anillos</a>
                                            <br>
                                            <a href="{{ route('personaliza') }}">Grabado de pendientes</a>
                                            <br>
                                            <a href="{{ route('personaliza') }}">Grabado de colgantes</a>
                                            <br>
                                            <a href="{{ route('personaliza') }}">Grabado de pulseras</a>
                                            <br>
                                        </li>
                                        <li class="material-personaliza">
                                            <a href="{{ route('joyas.buscar', ['material' => ['plata', 'oro blanco', 'oro rosa', 'acero']]) }}" style="font-weight: bold;">Material</a>
                                            <br>
                                            <a href="{{ route('joyas.buscar', ['material' => ['plata']]) }}">Plata de 1º ley</a>
                                            <br>
                                            <a href="{{ route('joyas.buscar', ['material' => ['oro blanco']]) }}">Oro 18k</a>
                                            <br>
                                            <a href="{{ route('joyas.buscar', ['material' => ['oro blanco']]) }}">Oro rosa</a>
                                            <br>
                                            <a href="{{ route('joyas.buscar', ['material' => ['acero']]) }}">Acero Inoxidable</a>
                                            <br>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-medium" href="{{ route('comproOro') }}">Compro Oro</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-medium" href="{{ route('orfebreria') }}">Orfebrería</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-medium" href="{{ route('historia') }}">Historia</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-medium" href="{{ route('contacto') }}">Contacto</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</header>

<div id="overlay-buscador" class="overlay-buscador">
    <div class="panel-buscador">
        <div class="contenedor-buscador-padre">
            <div class="contenedor-buscar">
                <div class="input-group" id="contenedor-input-buscador">
                    <input type="text" class="form-control" placeholder="Buscar productos..." id="buscador" autocomplete="off">
                </div>
            </div>
            <div class="contenedor-categorias" id="contenedor-categorias-buscador">
                <div class="contenedor-recomendaciones">
                    <h3>Categorías</h3>
                    <ul class="lista-categorias-buscador">
                        <li><a href="{{ route('joyas.index', 'collares') }}">Collares</a></li>
                        <li><a href="{{ route('joyas.index', 'anillos') }}">Anillos</a></li>
                        <li><a href="{{ route('joyas.index', 'pulseras') }}">Pulseras</a></li>
                        <li><a href="{{ route('joyas.index', 'pendientes') }}">Pendientes</a></li>
                    </ul>
                </div>
                <div class="contenedor-productos">
                    <h3>Resultados</h3>
                    <div class="grid-productos" id="grid-productos-buscador" data-base-url="{{ url('') }}"></div>
                    <div class="buscador-sin-resultados" id="sin-resultados-buscador" style="display: none;">
                        <p>No se encontraron productos con ese nombre.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="contenedor-cerrar">
            <button type="button" id="cerrar-buscador" class="close" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
</div>
