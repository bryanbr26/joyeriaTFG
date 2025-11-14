<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrarse</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/app.js') }}"></script>
</head>

@include("layouts.header")

<body class="m-0">
  <div class="d-flex mt-4">
    
    <!-- IMAGEN -->
    <aside class="flex-fill d-flex justify-content-center align-items-center bg-light" style="border:1px solid red;">
      <img class="img-fluid" src="{{ asset('assets/BolsaLogin.png') }}" alt="ImagenPrueba" >
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

        <!-- FORMULARIO -->
        <form action="{{ route('register') }}" method="POST" class="mx-4">
            @csrf
            <div class="d-flex">
                <div class="flex-fill me-3">
                  <label for="nombre" class="form-label ">Nombre</label>
                  <input type="text" name="nombre" id="nombre" class="form-control" required>
                </div>
                    
                <div class="flex-fill m-0">
                  <label for="apellidos" class="form-label">Apellidos</label>
                  <input type="text" name="apellidos" id="apellidos" class="form-control" required>
                </div>

            </div>

            <div class="d-flex">
              <div class="flex-fill me-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" required>
              </div>

              <div class="flex-fill m-0">
                <!-- Usar regex o funcion de fortify para el telefono -->
                <label for="telefono" class="form-label">Telefono</label>
                <input type="text" name="telefono" id="telefono" class="form-control" required>
              </div>
                

            </div>

            <div class="d-flex">
              <div class="flex-fill me-2">
                <label for="password" class="form-label">Contraseña:</label>
                <input type="password" class="form-control" name="password" id="password" required>
              </div>

              <div class="flex-fill m-0">
                <!-- Comprobar que sea igual que password (comparar cadena o el hasheo directamente?) -->
                <label for="password_confirmation">Confirmar contraseña</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required>   
              </div>

            </div>

            <p class="mt-3" style="decoration:none; text-size:12px">
                <a href="#">Aceptar terminos y condiciones</a>
            </p>

            <p class="mt-3" style="decoration:none; text-size:12px">
                <a href="#">Politica de privacidad</a>
            </p>

            <div>
                <button type="submit" class="btn btn-primary w-25 text-center mt-3 ">Entrar</button>
            </div>
            
            
            

        </form>

      </div>
    </main>

  </div>
</body>


@include("layouts.footer");

</html>
