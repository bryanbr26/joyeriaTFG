<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer contraseña</title>
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
            <h1>Restablecer contraseña</h1>
            <p>Elige una contraseña nueva para volver a acceder a tu cuenta.</p>
        </div>

        @if ($errors->any())
            <div class="auth-alert auth-alert--error">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}" class="auth-recovery-form">
            @csrf
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <label for="email">Correo electrónico</label>
            <input type="email" id="email" name="email" value="{{ old('email', $request->email) }}" autocomplete="email" required>

            <label for="password">Nueva contraseña</label>
            <input type="password" id="password" name="password" autocomplete="new-password" required>

            <label for="password_confirmation">Confirmar contraseña</label>
            <input type="password" id="password_confirmation" name="password_confirmation" autocomplete="new-password" required>

            <button type="submit">Restablecer contraseña</button>
        </form>
    </main>

</body>
</html>
