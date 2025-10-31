<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Joyería - TFG</title>
    <style>
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            margin: 5px;
        }
        .btn:hover {
            background: #0056b3;
        }
        .btn-secondary {
            background: #6c757d;
        }
        .btn-success {
            background: #28a745;
        }
    </style>
</head>
<body>
    
    <div style="margin: 20px 0;">
    <a href="{{ route('productos.test') }}" class="btn">📋 Productos</a>
    <a href="{{ route('categorias.index') }}" class="btn btn-secondary">📁 Categorías</a>
    <a href="{{ route('usuarios.index') }}" class="btn btn-success">👥 Usuarios</a>
</div>
</body>
</html>