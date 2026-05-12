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
            <div class="d-flex gap-3">
                @auth
                    <form action="{{ route('logout') }}" method="POST" class="m-0" onsubmit="return confirm('¿Quieres cerrar sesión?');">
                        @csrf
                        <button type="submit" class="btn btn-link text-dark p-0 border-0" title="Cerrar sesión">
                            <i class="bi bi-box-arrow-right fs-5"></i>
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-dark" title="Iniciar sesión">
                        <i class="bi bi-person fs-5"></i>
                    </a>
                @endauth
                <a href="https://maps.app.goo.gl/2nEWQXenbcLCjSgh6" class="text-dark" title="ubicacion">
                    <i class="bi bi-geo-alt"></i>
                </a>
                <!-- boton ubicacion-->
                <a href="#" class="header-icon-link" title="ubicacion">
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
                @auth
                    @if(auth()->user()->rol === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="text-dark" title="Panel de control">
                            <i class="bi bi-gear fs-5"></i>
                        </a>
                    @endif
                @endauth
            </div>
        </div>

    </div>

    <!-- Navegación con Mega Menú -->
    <nav class="border-top navbar-light" id="nav-bar">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <ul class="nav justify-content-center py-2">
                        <li class="nav-item dropdown joyeria-mega-dropdown">
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
                                    <img id="categoria-imagen" src="{{ asset('images/joyas/default.jpg') }}"
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
                                            <a href="" style="font-weight: bold;">Categoria</a>
                                            <br>
                                            <a href="#">Mas Vendidos</a>
                                            <a href="#">Cojuntos de regalo</a>
                                            <a href="#">Regalos para grabar</a>
                                        </li>

                                        <li class="ocasiones-item">
                                            <a href="#" style="font-weight: bold;">Ocasiones especiales</a>
                                            <br>
                                            <a href="#">Bodas</a>
                                            <br>
                                            <a href="#">Comuniones</a>
                                            <br>
                                            <a href="#">Compromisos</a>
                                            <br>
                                            <a href="#">Aniversario</a>
                                            <br>
                                            <a href="#">Bautizo</a>
                                            <br>
                                        </li>
                                        <li class="regalos-item">
                                            <a href="#" style="font-weight: bold;">Regalos para</a>
                                            <br>
                                            <a href="#">Para ella</a>
                                            <br>
                                            <a href="#">Para él</a>
                                            <br>
                                            <a href="#">Niños</a>
                                            <br>
                                            <a href="#">Pareja</a>
                                            <br>
                                            <a href="#">Padres</a>
                                            <br>
                                        </li>
                                        <li class="presupuesto-item">
                                            <a href="#" style="font-weight: bold;">Presupuesto</a>
                                            <br>
                                            <a href="#">Menos de 50€</a>
                                            <a href="#">Menos de 100€</a>
                                            <a href="#">Menos de 250€</a>
                                            <a href="#">Mas de 250€</a>
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
                                            <a href="#">Grabado de anillos</a>
                                            <br>
                                            <a href="#">Grabado de pendientes</a>
                                            <br>
                                            <a href="#">Grabado de colgantes</a>
                                            <br>
                                            <a href="#">Grabado de pulseras</a>
                                            <br>
                                        </li>
                                        <li class="material-personaliza">
                                            <a href="#" style="font-weight: bold;">Material</a>
                                            <br>
                                            <a href="#">Plata de 1º ley</a>
                                            <br>
                                            <a href="#">Oro 18k</a>
                                            <br>
                                            <a href="#">Oro rosa</a>
                                            <br>
                                            <a href="#">Acero Inoxidable</a>
                                            <br>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item">
<<<<<<< HEAD
                            <a class="nav-link fw-medium" href="{{ route('comproOro') }}">Compro Oro</a>
=======
                            <a class="nav-link fw-medium" href="{{ route('comproOro') }}">Compra de Oro</a>
>>>>>>> 888453589d2b165258d152ea9369137514804a65
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
                    <input type="text" class="form-control" placeholder="Buscar" id="buscador">
                </div>
            </div>
            <div class="contenedor-categorias">
                <div class="contenedor-recomendaciones">
                    <h3>Recomendaciones</h3>
                </div>
                <div class="contenedor-productos">
                    <h3>Nuestros best sellers</h3>
                    <div class="contenedor-productos-img">

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
