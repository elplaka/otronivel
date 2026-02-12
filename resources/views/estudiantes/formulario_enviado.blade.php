<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Confirmación de Registro | OTRO NIVEL</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <!-- <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,600,700,800" rel="stylesheet"> -->
    <link href="{{ asset('css/sb-admin.min.css')}}" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('Favicon.png') }}">

    <style>
        body {
            background-color: #f8f9fc;
            font-family: 'Nunito', sans-serif;
            color: #4e73df;
        }
        /* Tarjeta Principal */
        .main-card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 0.5rem 2rem 0 rgba(0, 0, 0, 0.1);
            overflow: hidden;
            background: white;
            margin-top: 2rem;
            margin-bottom: 2rem;
        }
        /* Encabezado con logos */
        .logo-section {
            padding: 2rem;
            background: #fff;
            border-bottom: 1px solid #f0f0f0;
        }
        /* Títulos */
        h2 {
            color: #7b003a; /* Guinda */
            font-weight: 800;
            letter-spacing: -0.5px;
        }
        /* Botones personalizados */
        .btn-custom {
            border-radius: 50px;
            padding: 12px 30px;
            font-weight: 700;
            transition: all 0.3s ease;
            text-transform: uppercase;
            font-size: 0.85rem;
            border: none;
        }
        .btn-guinda { background-color: #7b003a; color: white; }
        .btn-guinda:hover { background-color: #5c002b; transform: translateY(-2px); box-shadow: 0 5px 15px rgba(123,0,58,0.3); color: white; }
        
        .btn-verde { background-color: #00656c; color: white; }
        .btn-verde:hover { background-color: #004d52; transform: translateY(-2px); box-shadow: 0 5px 15px rgba(0,101,108,0.3); color: white; }

        /* Iconos informativos */
        .info-icon {
            color: #b2945e; /* Dorado */
            margin-right: 10px;
        }
        /* Secciones de texto */
        .step-box {
            background: #fdfaf3;
            border-left: 4px solid #b2945e;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 1.5rem;
        }
        .success-icon {
            font-size: 4rem;
            color: #1cc88a;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-9 col-lg-10">
                <div class="main-card">
                    <div class="logo-section text-center">
                        <div class="row align-items-center">
                            <div class="col-6 col-md-6 text-right">
                                <img src="../img/Logo_y_Escudo.jpg" style="max-width: 90%; height: auto;">
                            </div>
                            <div class="col-6 col-md-6 text-left">
                                <img src="../img/logo_programa.jpg" style="max-width: 80%; height: auto;">
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4 p-md-5">
                        <div class="text-center mb-5">
                            <div class="success-icon">
                                <i class="fa-solid fa-circle-check"></i>
                            </div>
                            <h2>¡FORMULARIO ENVIADO CON ÉXITO!</h2>
                            <p class="lead text-gray-800">Tu registro ha sido procesado correctamente.</p>
                        </div>

                        <div class="row">
                            <div class="col-md-11 mx-auto text-gray-700">
                                
                                <div class="step-box">
                                    <p class="mb-0"><i class="fa-solid fa-envelope-open-text info-icon"></i> Se ha enviado un correo a tu dirección proporcionada. <strong>Es vital que lo conserves</strong> para las siguientes etapas.</p>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <h5 class="font-weight-bold text-dark"><i class="fa-solid fa-envelope"></i> Revisar tu correo</h5>
                                        <ul class="pl-3 mt-3">
                                            <li><small><strong>Bandeja de entrada:</strong> Llega en un par de minutos.</small></li>
                                            <li><small><strong>Spam:</strong> Revisa tu carpeta de correo no deseado si no lo ves.</small></li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <h5 class="font-weight-bold text-dark"><i class="fa-brands fa-whatsapp"></i> Próximos pasos</h5>
                                        <ul class="pl-3 mt-3">
                                            <li><small><strong>WhatsApp:</strong> Mantente atento al número que registraste, te contactaremos pronto.</small></li>
                                            <!-- <li><small><strong>Constancia:</strong> Ya puedes subir tu documento para finalizar.</small></li> -->
                                        </ul>
                                    </div>
                                </div>

                                <hr class="my-4">

                                <div class="text-center">
                                    <div class="d-flex flex-column flex-md-row justify-content-center gap-3" style="gap: 15px;">
                                        <a class="btn btn-custom btn-guinda mb-2" href="{{ route('estudiantes.forget') }}">
                                            <i class="fa-solid fa-user-plus mr-2"></i> Nuevo Registro
                                        </a>
                                        
                                        @if(session('estudiante') && session('estudiante')->img_constancia === 'PENDIENTE')
                                            <a class="btn btn-custom btn-verde mb-2" href="{{ route('estudiantes.forget') }}">
                                                <i class="fa-solid fa-file-arrow-up mr-2"></i> Subir Constancia
                                            </a>
                                        @endif
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div> </div> <p class="text-center text-muted"><small>&copy; Gobierno del Municipio de Concordia - OTRO NIVEL</small></p>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>