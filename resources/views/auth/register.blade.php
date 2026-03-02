<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registrarse · Joyas Pérez</title>
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <link rel="stylesheet" href="{{ asset('css/global.css') }}">
  <script src="{{ asset('js/app.js') }}"></script>
</head>

<body class="m-0 auth-wrapper">

  @include("layouts.header")

  <div class="container py-5">
    <div class="row justify-content-center align-items-stretch g-0" style="max-width:900px; margin:auto;">

      <!-- Panel izquierdo decorativo -->
      <div class="col-md-4 auth-aside d-none d-md-flex flex-column justify-content-center align-items-center p-4"
        style="border-radius: 20px 0 0 20px;">
        <i class="bi bi-person-check text-white" style="font-size:3rem; opacity:0.85;"></i>
        <h3 class="text-white mt-4 text-center" style="font-family:'Cormorant Garamond',serif; font-size:1.6rem;">
          Únete a nosotros
        </h3>
        <p class="text-center mt-2" style="color:rgba(255,255,255,0.7); font-size:0.85rem;">
          Crea tu cuenta y accede a ofertas exclusivas
        </p>
      </div>

      <!-- Panel derecho: formulario -->
      <div class="col-12 col-md-8">
        <div class="auth-card card h-100" style="border-radius: 0 20px 20px 0 !important;">
          <div class="card-body p-4 p-md-5">

            <!-- Tabs -->
            <div class="d-flex auth-tabs mb-4 rounded-3 overflow-hidden">
              <a href="{{ route('login') }}" class="tab-btn">Iniciar sesión</a>
              <a href="{{ route('register') }}" class="tab-btn active">Registrarse</a>
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

            <!-- Formulario -->
            <form action="{{ route('register') }}" method="POST">
              @csrf

              <div class="row g-3 mb-3">
                <div class="col-6">
                  <label for="nombre" class="form-label">Nombre</label>
                  <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Tu nombre" required>
                </div>
                <div class="col-6">
                  <label for="apellidos" class="form-label">Apellidos</label>
                  <input type="text" name="apellidos" id="apellidos" class="form-control" placeholder="Tus apellidos"
                    required>
                </div>
              </div>

              <div class="row g-3 mb-3">
                <div class="col-6">
                  <label for="email" class="form-label">Email</label>
                  <input type="email" name="email" id="email" class="form-control" placeholder="tu@email.com" required>
                </div>
                <div class="col-6">
                  <label for="telefono" class="form-label">Teléfono</label>
                  <input type="text" name="telefono" id="telefono" class="form-control" placeholder="600 000 000"
                    required>
                </div>
              </div>

              <div class="row g-3 mb-4">
                <div class="col-6">
                  <label for="password" class="form-label">Contraseña</label>
                  <input type="password" class="form-control" name="password" id="password" placeholder="••••••••"
                    required>
                </div>
                <div class="col-6">
                  <label for="password_confirmation" class="form-label">Confirmar contraseña</label>
                  <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
                    placeholder="••••••••" required>
                </div>
              </div>

              <p class="small mb-2">
                <a href="#">Acepto los términos y condiciones</a>
              </p>
              <p class="small mb-4">
                <a href="#">Política de privacidad</a>
              </p>

              <button type="submit" class="btn btn-primary w-100">
                <i class="bi bi-person-plus me-2"></i>Crear cuenta
              </button>
            </form>

            <p class="text-center mt-4 mb-0" style="font-size:0.9rem;">
              ¿Ya tienes cuenta?
              <a href="{{ route('login') }}" class="fw-semibold">Inicia sesión</a>
            </p>

          </div>
        </div>
      </div>
    </div>
  </div>

  @include("layouts.footer")

</body>

</html>