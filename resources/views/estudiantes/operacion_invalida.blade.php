<!DOCTYPE html>
<html>
<head>
    <title>Operación Inválida</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }

        .message {
            text-align: center;
            padding: 20px;
            background-color: #781711;
            color: white;
            border-radius: 5px;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 10px;
        }

        .button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="message">
        <h1>OPERACIÓN INVÁLIDA</h1>
        <a class="button" href="{{ route('estudiantes.forget') }}">Ir al Inicio de Registro</a>
    </div>
</body>
</html>
