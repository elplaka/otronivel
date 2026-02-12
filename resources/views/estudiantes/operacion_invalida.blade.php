<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Operación Inválida | OTRO NIVEL</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="icon" type="image/png" href="{{ asset('Favicon.png') }}">
    <style>
        :root {
            --guinda: #7b003a;
            --guinda-dark: #5c002b;
            --dorado: #b2945e;
            --bg-light: #f8f9fc;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--bg-light);
        }

        .error-card {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            text-align: center;
            max-width: 500px;
            width: 90%;
            border-top: 5px solid var(--guinda);
        }

   

        .alert-icon {
            font-size: 50px;
            color: #e74a3b; /* Rojo suave de alerta */
            margin-bottom: 20px;
        }

        h1 {
            font-size: 22px;
            color: #333;
            margin: 0 0 15px 0;
            font-weight: 800;
            letter-spacing: 1px;
        }

        p {
            color: #666;
            line-height: 1.6;
            margin-bottom: 30px;
        }

        .btn-home {
            display: inline-block;
            padding: 14px 28px;
            background-color: var(--guinda);
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-weight: bold;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(123, 0, 58, 0.2);
        }

        .btn-home:hover {
            background-color: var(--guinda-dark);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(123, 0, 58, 0.3);
        }

       /* Ajuste para el logo superior */
        .header-logos img {
            max-height: 100px; /* Aumentado de 60px a 100px */
            width: auto;
            max-width: 90%;   /* Asegura que no se desborde en móviles */
        }

        /* Ajuste para el logo inferior */
        .footer-logo img {
            max-width: 250px; /* Aumentado de 150px a 250px */
            width: auto;
            height: auto;
        }

        /* Opcional: Si quieres que el logo superior ocupe más espacio */
        .header-logos {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px;
            margin-bottom: 25px;
            padding: 10px;
        }

        .footer-logo {
            margin-top: 40px;
            opacity: 0.8;
        }
    </style>
</head>
<body>

    <div class="error-card">
        <div class="header-logos">
            <img src="{{url('/img/Logo_y_Escudo.jpg')}}" alt="Logo Institucional">
        </div>

        <div class="alert-icon">
            <i class="fa-solid fa-triangle-exclamation"></i>
        </div>

        <h1>OPERACIÓN INVÁLIDA</h1>
        
        <p>Parece que la sesión ha expirado o el enlace al que intentas acceder ya no está disponible. Por favor, intenta iniciar el proceso nuevamente.</p>

        <a class="btn-home" href="{{ route('estudiantes.forget') }}">
            <i class="fa-solid fa-rotate-left" style="margin-right: 8px;"></i> Reintentar Registro
        </a>

        <div class="footer-logo">
            <img src="{{url('/img/logo_programa.jpg')}}" alt="Logo Programa">
        </div>
    </div>

</body>
</html>