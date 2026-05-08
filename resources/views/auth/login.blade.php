<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Iniciar sesión</title>
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <link rel="stylesheet" href="{{ asset('css/global.css') }}">
  <script src="{{ asset('js/app.js') }}"></script>
</head>

<body>
  <div class="login-container">

    <aside class="contenedor-imagen-login">
      <img src="{{ asset('images/fondos/Logo-login.jpg') }}" alt="Imagen decorativa">
    </aside>

    <div class="contenedor-form-login">
      <div class="fila-btn-salir">
        <a href="{{ route('index') }}"><i class="bi bi-x"></i></a>
      </div>
      <div class="fila-form">
        <div class="btn-opciones-login">
          <a href="{{ route('login') }}">Iniciar Sesión</a>
          <a href="{{ route('register') }}">Registrarse</a>
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

        <div class="fila-form-login">
          <form action="{{ route('login') }}" method="post">
            @csrf
            <div class="form-group">

              <input type="email" name="email" id="email" placeholder="Dirección de correo electrónico *">
            </div>
            <div class="form-group">

              <input type="password " name="password" id="password" placeholder="Contraseña *">
            </div>
            <a href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a>
            <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
          </form>
        </div>
      </div>
    </div>

  </div>
</body>

</html>