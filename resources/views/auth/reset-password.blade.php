<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
</head>
<body>
    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">
        
        <label>Email</label>
        <input type="email" name="email" value="{{ old('email', $request->email) }}" required>
        <label>Nueva contraseña</label>
        <input type="password" name="password" required>
        <label>Confirmar contraseña</label>
        <input type="password" name="password_confirmation" required>
        <button type="submit">Restablecer contraseña</button>
    </form>

</body>
</html>