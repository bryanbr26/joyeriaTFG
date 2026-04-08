<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Iniciar sesión</title>
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
          <a href="{{ route('login') }}" class="auth-tab auth-tab-active">Iniciar Sesión</a>
          <a href="{{ route('register') }}" class="auth-tab">Registrarse</a>
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

        <!-- Status de recuperar la contraseña -->
        @if (session('status'))
        <div class="mb-4 font-medium text-sm text-green-600">
          {{ session('status') }}
        </div>
        @endif

        <!-- FORMULARIO -->
        <form method="POST" action="{{ route('login') }}" class="form-login">
          @csrf
          <div class="campo-form">
            <label for="email" class="form-label">Correo electrónico</label>
            <input type="email" name="email" id="email" required autofocus>
          </div>

          <div class="campo-form">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" name="password" id="password" required>
          </div>

          <div class="form-submit-wrapper">
            <button type="submit" class="btn-crear-cuenta">Entrar</button>
          </div>

          <p class="form-link-recover">
            <a href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a>
          </p>
        </form>

        <p class="form-link-alt">
          <a href="{{ route('register') }}">¿No tienes cuenta? Regístrate</a>
        </p>

      </div>
    </main>

  </div>
</body>


@include("layouts.footer");

</html>