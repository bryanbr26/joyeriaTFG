<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar contraseña</title>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <script src="{{ mix('js/manifest.js') }}" defer></script>
    <script src="{{ mix('js/vendor.js') }}" defer></script>
    <script src="{{ mix('js/app.js') }}" defer></script>
</head>

<body class="auth-recovery-page">
    <main class="auth-recovery-card">
        <a href="{{ route('login') }}" class="auth-recovery-back">
            <i class="bi bi-arrow-left"></i>
            Volver al login
        </a>

        <div class="auth-recovery-header">
            <span class="auth-recovery-kicker">Joyas Pérez</span>
            <h1>Recuperar contraseña</h1>
            <p>Introduce tu correo y te enviaremos un enlace para crear una nueva contraseña.</p>
        </div>

        @if (session('status'))
            <div class="auth-alert auth-alert--success">{{ session('status') }}</div>
        @endif

        @if ($errors->any())
            <div class="auth-alert auth-alert--error">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="auth-recovery-form">
            @csrf
            <label for="email">Correo electrónico</label>
            <input type="email" name="email" id="email" placeholder="tu@email.com" value="{{ old('email') }}" autocomplete="email" required>
            <button type="submit">Enviar enlace</button>
        </form>
    </main>
</body>
</html>
