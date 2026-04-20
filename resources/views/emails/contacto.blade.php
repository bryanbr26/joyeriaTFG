<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Nuevo Mensaje de Contacto</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <h2>Tienes un nuevo mensaje de contacto</h2>
    
    <p><strong>Nombre:</strong> {{ $datos['nombre'] }}</p>
    <p><strong>Email:</strong> {{ $datos['email'] }}</p>
    <p><strong>Asunto:</strong> {{ ucfirst($datos['asunto']) }}</p>
    
    <h3>Mensaje:</h3>
    <div style="background-color: #f9f9f9; padding: 15px; border-radius: 5px; border-left: 4px solid #0d6efd;">
        {{ $datos['mensaje'] }}
    </div>
</body>
</html>
