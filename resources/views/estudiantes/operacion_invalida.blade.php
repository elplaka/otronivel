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
            background-color: #ffffff;
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center; /* Agregamos esta línea */
        }

        .logo {
            width: 80%;
            margin-bottom: 20px;
            max-width: 400px; /* Limitamos el tamaño máximo */
        }

        .message {
            text-align: center;
            padding: 20px;
            background-color: #781711;
            color: white;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            margin-bottom: 20px;
        }

        .message h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 10px;
            transition: background-color 0.3s ease;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .button:hover {
            background-color: #45a049;
        }

        .alivianate-logo {
            width: 80%;
            max-width: 400px; /* Limitamos el tamaño máximo */
        }
    </style>
</head>
<body>
    <div class="container">
        <div><img src="{{url('/img/Logo_y_Escudo.jpg')}}" class="logo" alt="Logo"></div>
        <div class="message">
            <h1>OPERACIÓN INVÁLIDA</h1>
            <a class="button" href="{{ route('estudiantes.forget') }}">Ir al Inicio de Registro</a>
        </div>
        <div><img src="{{url('/img/alivianate.jpg')}}" class="alivianate-logo" alt="Alivianate Logo"></div>
    </div>
</body>
</html>



