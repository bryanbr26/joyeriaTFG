<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
</head>
<body>
    <h1>Crear cuenta</h1>

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf
        <label for="nombre">Nombre:</label><br>
        <input type="text" name="nombre" id="nombre" required><br><br>

        <label for="apellidos">Apellidos:</label><br>
        <input type="text" name="apellidos" id="apellidos" required><br><br>

        <label for="email">Correo electrónico:</label><br>
        <input type="email" name="email" id="email" required><br><br>

        <label for="password">Contraseña:</label><br>
        <input type="password" name="password" id="password" required><br><br>

        <label for="password_confirmation">Confirmar contraseña:</label><br>
        <input type="password" name="password_confirmation" id="password_confirmation" required><br><br>

        <button type="submit">Registrarse</button>
    </form>

    <p><a href="{{ route('login') }}">¿Ya tienes cuenta? Inicia sesión</a></p>
</body>
</html>
