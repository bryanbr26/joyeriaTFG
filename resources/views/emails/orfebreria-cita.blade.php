<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Nueva solicitud de cita de orfebrería</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <h2>Nueva solicitud de cita de orfebrería</h2>

    <p><strong>Nombre:</strong> {{ $datos['nombre'] }}</p>
    <p><strong>Email:</strong> {{ $datos['email'] }}</p>
    <p><strong>Teléfono:</strong> {{ $datos['telefono'] ?? 'No indicado' }}</p>
    <p><strong>Propósito:</strong> {{ ucfirst($datos['proposito']) }}</p>
    <p><strong>Motivo:</strong> {{ ucfirst(str_replace('-', ' ', $datos['motivo'])) }}</p>
    <p><strong>Fecha:</strong> {{ $datos['fecha'] }}</p>
    <p><strong>Hora:</strong> {{ $datos['hora'] }}</p>

    <h3>Comentarios:</h3>
    <div style="background-color: #f9f9f9; padding: 15px; border-radius: 5px; border-left: 4px solid #c9a96e;">
        {{ $datos['comentarios'] ?? 'Sin comentarios adicionales.' }}
    </div>
</body>
</html>
