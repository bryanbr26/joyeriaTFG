<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Iniciar sesión · Joyas Pérez</title>
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <link rel="stylesheet" href="{{ asset('css/global.css') }}">
  <script src="{{ asset('js/app.js') }}"></script>
</head>

<body class="m-0 auth-wrapper">

  @include("layouts.header")

  <div class="container py-5">
    <div class="row justify-content-center align-items-stretch g-0" style="max-width:900px; margin:auto;">

      <!-- Panel izquierdo decorativo -->
      <div class="col-md-5 auth-aside d-none d-md-flex flex-column justify-content-center align-items-center p-5"
        style="border-radius: 20px 0 0 20px;">
        <i class="bi bi-gem text-white" style="font-size:3.5rem; opacity:0.85;"></i>
        <h3 class="text-white mt-4 text-center" style="font-family:'Cormorant Garamond',serif; font-size:1.8rem;">
          Lujo y Elegancia
        </h3>
        <p class="text-center mt-2" style="color:rgba(255,255,255,0.7); font-size:0.9rem;">
          Tu destino de joyas artesanales de alta calidad
        </p>
      </div>

      <!-- Panel derecho: formulario -->
      <div class="col-12 col-md-7">
        <div class="auth-card card h-100" style="border-radius: 0 20px 20px 0 !important;">
          <div class="card-body p-4 p-md-5">

            <!-- Tabs -->
            <div class="d-flex auth-tabs mb-4 rounded-3 overflow-hidden">
              <a href="{{ route('login') }}" class="tab-btn active">Iniciar sesión</a>
              <a href="{{ route('register') }}" class="tab-btn">Registrarse</a>
            </div>

            <!-- Errores -->
            @if ($errors->any())
              <div class="alert alert-danger mb-3">
                <ul class="mb-0">
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif

            <!-- Estado recuperar contraseña -->
            @if (session('status'))
              <div class="alert alert-info mb-3">{{ session('status') }}</div>
            @endif

            <!-- Formulario -->
            <form method="POST" action="{{ route('login') }}">
              @csrf

              <div class="mb-3">
                <label for="email" class="form-label">Correo electrónico</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="tu@email.com" required
                  autofocus>
              </div>

              <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="••••••••"
                  required>
              </div>

              <div class="d-flex justify-content-between align-items-center mb-4">
                <a href="{{ route('password.request') }}" style="font-size:0.85rem;">
                  ¿Olvidaste tu contraseña?
                </a>
              </div>

              <button type="submit" class="btn btn-primary w-100">
                <i class="bi bi-box-arrow-in-right me-2"></i>Entrar
              </button>
            </form>

            <p class="text-center mt-4 mb-0" style="font-size:0.9rem;">
              ¿No tienes cuenta?
              <a href="{{ route('register') }}" class="fw-semibold">Regístrate gratis</a>
            </p>

          </div>
        </div>
      </div>
    </div>
  </div>

  @include("layouts.footer")

</body>

</html>