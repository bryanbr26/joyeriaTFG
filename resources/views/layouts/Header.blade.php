<header class="border-bottom">
    <!-- Fila 1: Logo, Buscador, Iconos -->
    <div class="container-fluid py-2 bg-white">
        <div class="row align-items-center">

            <!-- Logo -->
            <div class="col-auto">
                <div class="d-flex align-items-center" style="text-decoration:none">
                    <a href="{{ route('index') }}" class="h3 mb-0 fw-bold text-uppercase" style="text-decoration:none">Joyas<br>Perez</a>
                </div>
            </div>
        </div>

        <!-- Buscador -->
        <div class="col">
            <div class="d-flex justify-content-center">
                <div class="input-group" style="max-width: 600px;">
                    <input type="text" class="form-control border-dark" placeholder="BUSCAR">
                    <button class="btn btn-dark" type="button">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Iconos -->
        <div class="col-auto">
            <div class="d-flex gap-3">
                <!-- Usuario/Login -->
                <a href="#" class="text-dark" title="Mi Cuenta">
                    <i class="bi bi-person fs-5"></i>
                </a>
                <!-- Ubicacion -->
                <a href="#" class="text-dark" title="ubicacion">
                    <i class="bi bi-geo-alt"></i>
                </a>
                <!-- Favoritos -->
                <a href="#" class="text-dark" title="Favoritos">
                    <i class="bi bi-heart fs-5"></i>
                </a>
                <!-- Carrito -->
                <a href="#" class="text-dark position-relative" title="Carrito">
                    <i class="bi bi-bag fs-5"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge bg-danger">
                        0
                    </span>
                </a>
            </div>
        </div>

    </div>
    </div>

    <!-- Fila 2: Navegación -->
    <nav class="border-top navbar-light" style="background-color: #e3f2fd;">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <ul class="nav justify-content-center py-2">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Joyería
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="{{ route('collares') }}">Collares</a></li>
                                <li><a class="dropdown-item" href="{{ route('anillos') }}">Anillos</a></li>
                                <li><a class="dropdown-item" href="{{ route('pulseras') }}">Pulseras</a></li>
                                <li><a class="dropdown-item" href="{{ route('pendientes') }}">Pendientes</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark fw-medium" href="{{route('regalos')}}">Regalos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark fw-medium" href="{{route('personaliza')}}">Personaliza tus joyas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark fw-medium" href="{{route('comproOro')}}">Compro Oro</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark fw-medium" href="{{route('orfebreria')}}">Orfebrería</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark fw-medium" href="{{route('historia')}}">Historia</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark fw-medium" href="{{route('contacto')}}">Contacto</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</header>