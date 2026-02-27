<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot password</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <script src="{{ asset('js/app.js') }}"></script>
</head>

<body class="d-flex align-items-center justify-content-center py-4 mt-5">

    @if (session('status'))
        <div>{{ session('status') }}</div>
    @endif

    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <h3 class="mb-3 olvidaste-contra">¿Olvidaste tu contraseña?</h3>
        <div class="mb-3">
            <input type="email" name="email" id="email" class="form-control input-email" placeholder="Escriba su email aquí" required>
        </div>
        <button class="btn btn-primary boton-login" type="submit">Enviar enlace de recuperación</button>
    </form>
</body>
</html>