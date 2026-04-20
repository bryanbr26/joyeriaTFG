<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Registrarse</title>
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <link rel="stylesheet" href="{{ asset('css/global.css') }}">
  <script src="{{ asset('js/app.js') }}"></script>
</head>

@include("layouts.header")

<body class="m-0">
  <div class="auth-split-layout">

    <!-- IMAGEN -->
    <aside class="auth-image-side">
      <img src="{{ asset('assets/BolsaLogin.png') }}" alt="Imagen decorativa joyería">
    </aside>

    <!-- MAIN -->
    <main class="auth-form-side">
      <div class="auth-form-wrapper">

        <!-- INICIAR SESION / REGISTRARSE -->
        <div class="auth-tabs">
          <a href="{{ route('login') }}" class="auth-tab">Iniciar Sesión</a>
          <a href="{{ route('register') }}" class="auth-tab auth-tab-active">Registrarse</a>
        </div>

        <!-- ERRORES -->
        @if ($errors->any())
        <div class="text-danger mb-3">
          <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
        @endif

        <!-- FORMULARIO -->
        <form action="{{ route('register') }}" method="POST" class="form-register">
          @csrf
          <div class="form-grid">
            <div class="campo-form">
              <label for="nombre" class="form-label">Nombre</label>
              <input type="text" id="nombre" name="nombre" required>
            </div>

            <div class="campo-form">
              <label for="apellidos" class="form-label">Apellidos</label>
              <input type="text" name="apellidos" id="apellidos" required>
            </div>

            <div class="campo-form">
              <label for="email" class="form-label">Correo electrónico</label>
              <input type="email" name="email" id="email" required>
            </div>

            <div class="campo-form">
              <label for="telefono" class="form-label">Teléfono</label>
              <input type="text" name="telefono" id="telefono" required>
            </div>

            <div class="campo-form">
              <label for="password" class="form-label">Contraseña</label>
              <input type="password" name="password" id="password" required>
            </div>

            <div class="campo-form">
              <label for="password_confirmation" class="form-label">Confirmar contraseña</label>
              <input type="password" name="password_confirmation" id="password_confirmation" required>
            </div>
          </div>

          <div class="form-terms">
            <p>
              <a href="#">Aceptar terminos y condiciones</a>
            </p>
            <p>
              <a href="#">Politica de privacidad</a>
            </p>
          </div>

          <div class="form-submit-wrapper">
            <button type="submit" class="btn-crear-cuenta">Crea tu cuenta</button>
          </div>
        </form>

      </div>
    </main>

  </div>
</body>


@include("layouts.footer");

</html>