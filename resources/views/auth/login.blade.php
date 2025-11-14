<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar sesión</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/app.js') }}"></script>
</head>

@include("layouts.header")

<body class="m-0">
  <div class="d-flex mt-4">
    
    <!-- IMAGEN -->
    <aside class="flex-fill d-flex justify-content-center align-items-center bg-light" style="border:1px solid red;">
      <img class="img-fluid" src="{{ asset('assets/BolsaLogin.png') }}" alt="ImagenPrueba">
    </aside>

    <!-- MAIN -->
    <main class="flex-fill d-flex justify-content-center align-items-center">
      <div class="w-100 h-100">
        
        <!-- INICIAR SESION / REGISTRARSE -->
        <div class="d-flex mb-3 p-2" style="background-color: lightgrey;">
          <p class="flex-fill text-center m-0">INICIAR SESIÓN</p>
          <p class="flex-fill text-center m-0">REGISTRARSE</p>
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

        <!-- Status de recuperar la contraseña-->
         @if (session('status'))
          <div class="mb-4 font-medium text-sm text-green-600">
              {{ session('status') }}
          </div>
        @endif

        <!-- FORMULARIO -->
        <form class="mx-4" method="POST" action="{{ route('login') }}">
          <!-- Token que evita la falsificacion de cuenta contrastando valores -->
          @csrf 
          <div class="mb-3">
            <label for="email" class="form-label">Correo electrónico:</label>
            <input type="email" class="form-control" name="email" id="email" required autofocus>
          </div>

          <div class="mb-3">
            <label for="password" class="form-label">Contraseña:</label>
            <input type="password" class="form-control" name="password" id="password" required>
          </div>

          <div class="d-flex mb-3 p-2">
            <button type="submit" class="btn btn-primary flex-fill text-center m-0">Entrar</button>
            <a href="{{ route('password.request') }}" class="flex-fill text-center m-0">Recuperar contraseña</a>
          </div>
          
        </form>

        <p class="mt-3 text-center">
          <a href="{{ route('register') }}">¿No tienes cuenta? Regístrate</a>
        </p>

      </div>
    </main>

  </div>
</body>


@include("layouts.footer");

</html>
