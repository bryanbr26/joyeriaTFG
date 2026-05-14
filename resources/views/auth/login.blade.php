<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Iniciar sesión</title>
  <link rel="stylesheet" href="{{ mix('css/app.css') }}">
  <link rel="stylesheet" href="{{ asset('css/global.css') }}">
  <script src="{{ mix('js/manifest.js') }}" defer></script>
  <script src="{{ mix('js/vendor.js') }}" defer></script>
  <script src="{{ mix('js/app.js') }}" defer></script>
</head>

<body>

  <!--Panel login ! -->
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
          <a href="javascript:void(0)" id="btn-login" class="active">Iniciar Sesión</a>
          <a href="javascript:void(0)" id="btn-register">Registrarse</a>
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
          <!--Formulario para el inicio de sesion !-->
          <form action="{{ route('login') }}" method="post" class="form-login" id="form-login">
            @csrf
            <div class="form-group">

              <input type="email" name="email" id="email" placeholder="Dirección de correo electrónico *">
            </div>
            <div class="form-group">

              <input type="password " name="password" id="password" placeholder="Contraseña *">
            </div>
            <a class="contenedor-recuperar" href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a>
            <button type="submit">Iniciar Sesión</button>
          </form>
          <!--Formulario para el registro !-->
          <form action="{{ route('register') }}" method="POST" class="form-register" id="form-register" style="display: none;">
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
        <div class="info-login">
          <p>¿Busca el regalo perfecto? Únete a nuestra familia Pérez. Realice sus compras más rápido, rastree su pedido
            y
            programe citas para recibir orientación personalizada en la tienda, obtenga recomendaciones de regalos de
            nuestros asesores y disfrute de un servicio de cuidado de por vida para sus piezas de Tiffany.</p>
        </div>
      </div>
    </div>
  </div>
  <!-- Fin panel login ! -->

  <!--Panel registro ! -->
  <div class="register-container">

  </div>
  <!-- Fin panel registro ! -->

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const btnLogin = document.getElementById('btn-login');
      const btnRegister = document.getElementById('btn-register');
      const formLogin = document.getElementById('form-login');
      const formRegister = document.getElementById('form-register');

      btnLogin.addEventListener('click', function () {
        // Mostrar form login, ocultar register
        formLogin.style.display = 'flex';
        formRegister.style.display = 'none';
        
        // Actualizar clases activas
        btnLogin.classList.add('active');
        btnRegister.classList.remove('active');
      });

      btnRegister.addEventListener('click', function () {
        // Mostrar form register, ocultar login
        formRegister.style.display = 'flex';
        formLogin.style.display = 'none';
        
        // Actualizar clases activas
        btnRegister.classList.add('active');
        btnLogin.classList.remove('active');
      });
    });
  </script>
</body>

</html>