<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Estatus de Registro | OTRO NIVEL</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <!-- <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700,800" rel="stylesheet"> -->
    <link href="{{ asset('css/sb-admin.min.css')}}" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('Favicon.png') }}">

    <style>
        body { background-color: #f4f7f6;  }
        
        .main-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
            background: white;
            margin-top: 30px;
            overflow: hidden;
        }

        /* Logos en cabecera completa */
        .logo-header {
            background: white;
            padding: 20px;
            border-bottom: 1px solid #edf2f7;
        }

        /* Estilo de los contenedores de mensaje (Alertas) */
        .status-box {
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 25px;
            border: none;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .status-pending { background-color: #fff5f5; color: #c53030; border-left: 5px solid #feb2b2; } /* Guinda/Rojo suave */
        .status-validated { background-color: #f0fff4; color: #276749; border-left: 5px solid #9ae6b4; } /* Verde suave */
        .status-warning { background-color: #fffff0; color: #744210; border-left: 5px solid #fefcbf; } /* Amarillo suave */
        .status-info { background-color: #ebf8ff; color: #2c5282; border-left: 5px solid #bee3f8; } /* Azul suave */
        .status-delivery { background-color: #7b003a; color: white; border-radius: 12px; }

        /* Botones Estilizados */
        .btn-action {
            border-radius: 50px;
            padding: 12px 25px;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.8rem;
            transition: all 0.3s;
            border: none;
            color: white !important;
        }
        
        .btn-verde { background: #00656c; color: white; }
        .btn-verde:hover { background: #004d52; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,101,108,0.3); }
        
        .btn-rojo { background: #932f4a; color: white; }
        .btn-rojo:hover { background: #7b263d; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(147,47,74,0.3); }

        .btn-dorado { background: #706f6f; color: white; }

        .section-title {
            color: #4a5568;
            font-weight: 800;
            margin-bottom: 20px;
            border-bottom: 2px solid #f1f1f1;
            padding-bottom: 10px;
        }

        .obs-box {
            background: #fffaf0;
            border: 1px dashed #ed8936;
            padding: 15px;
            border-radius: 8px;
            color: #7b341e;
        }

        .status-card {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1.25rem 1.5rem;
            border-radius: 16px;
            background: linear-gradient(135deg, #ffffff, #f7f9fc);
            border: 1px solid #e5e9f2;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.06);
            max-width: 520px;
            margin: auto;
        }

        .status-icon {
            width: 56px;
            height: 56px;
            border-radius: 14px;
            background: linear-gradient(135deg, #7b003a, #a3004d);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-size: 1.4rem;
            flex-shrink: 0;
        }

        .status-content {
            text-align: left;
        }

        .status-label {
            display: block;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #6c757d;
            margin-bottom: 0.2rem;
        }

        .status-date {
            font-size: 1.5rem;
            font-weight: 700;
            color: #212529;
        }

        .status-date span {
            color: #7b003a;
        }

        .status-note {
            display: block;
            margin-top: 0.2rem;
            font-size: 0.75rem;
            color: #6c757d;
        }

        /* Mobile */
        @media (max-width: 576px) {
            .status-card {
                flex-direction: column;
                text-align: center;
            }

            .status-content {
                text-align: center;
            }
        }
    </style>
</head>
<body>

<div class="container mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-9">
            
            <div class="main-card">
                <div class="logo-header px-3 py-3">
                <div class="row align-items-center">
                    <div class="col-12 col-md-6 text-center mb-3 mb-md-0">
                        <img src="{{ url('img/Logo_y_Escudo.jpg') }}" 
                             class="img-fluid" 
                             style="max-height: 80px; width: auto; object-fit: contain;">
                    </div>
                    <div class="col-12 col-md-6 text-center">
                        <img src="{{ url('img/logo_programa.jpg') }}" 
                             class="img-fluid" 
                             style="max-height: 60px; width: auto; object-fit: contain;">
                    </div>
                </div>
                

                <div class="card-body p-4 p-md-5">                    
                    @if ($estudiante->cve_status != 4)
                        <div class="mb-4">
                            <h3 class="text-dark font-weight-bold">Hola, <span style="color:#00656c">{{ $estudiante->nombre }}</span></h3>
                            <p class="text-muted">Aquí puedes consultar el estado actual de tu solicitud.</p>
                        </div>
                    @endif

                    @if($estudiante->img_constancia == 'PENDIENTE')
                        <div class="status-box {{ $estudiante->cve_status == 1 ? 'status-pending' : 'status-warning' }}">
                            <i class="fa-solid fa-circle-exclamation fa-2x"></i>
                            <div>
                                <strong>REGISTRO INCOMPLETO:</strong> 
                                {{ $estudiante->cve_status == 1 ? 'Aún no has subido tu constancia de estudios.' : 'Tus documentos base son correctos, pero falta la constancia de estudios del periodo actual.' }}
                            </div>
                        </div>
                    @else
                        @if ($estudiante->cve_status == 1)
                            <div class="status-box status-info">
                                <i class="fa-solid fa-clock fa-2x"></i>
                                <div><strong>REGISTRO COMPLETO:</strong> Tu documentación está en proceso de revisión.</div>
                            </div>
                        @endif

                        @php
                            if (isset($prox_remesa))
                            {
                            $fecha = \Carbon\Carbon::createFromFormat('Y-m-d', $prox_remesa->fecha);
                            $mes = $fecha->format('n'); // Obtener el número del mes (1-12)
                            $anio = $fecha->format('Y');
                            $dia = $fecha->format('d');

                            $nombre_mes = '';
                            switch ($mes) {
                                case 1:
                                    $nombre_mes = 'ENERO';
                                    break;
                                case 2:
                                    $nombre_mes = 'FEBRERO';
                                    break;
                                case 3:
                                    $nombre_mes = 'MARZO';
                                    break;
                                case 4:
                                    $nombre_mes = 'ABRIL';
                                    break;
                                case 5:
                                    $nombre_mes = 'MAYO';
                                    break;
                                case 6:
                                    $nombre_mes = 'JUNIO';
                                    break;
                                case 7:
                                    $nombre_mes = 'JULIO';
                                    break;
                                case 8:
                                    $nombre_mes = 'AGOSTO';
                                    break;
                                case 9:
                                    $nombre_mes = 'SEPTIEMBRE';
                                    break;
                                case 10:
                                    $nombre_mes = 'OCTUBRE';
                                    break;
                                case 11:
                                    $nombre_mes = 'NOVIEMBRE';
                                    break;
                                case 12:
                                    $nombre_mes = 'DICIEMBRE';
                                    break;
                                default:
                                    $nombre_mes = '';
                                    break;
                            }
                            }
                        @endphp

                        @if (($estudiante->cve_status == 6 || $estudiante->cve_status == 7) && isset($prox_remesa))
                        <div class="status-card">
                            <div class="status-icon">
                                <i class="fas fa-calendar-check"></i>
                            </div>

                            <div class="status-content">
                                <small class="status-label">
                                    Fecha programada de entrega de beca
                                </small>

                                <div class="status-date">
                                    {{ $dia }} <span>{{ $nombre_mes }}</span> {{ $anio }}
                                </div>

                                <small class="status-note">
                                    Información oficial sujeta a validación
                                </small>
                            </div>
                        </div>
                         @elseif ($estudiante->cve_status == 6 || $estudiante->cve_status == 7)
                             <div class="status-box status-validated">
                                <i class="fa-solid fa-check-circle fa-2x"></i>
                                <div>
                                    <strong>DOCUMENTACIÓN VALIDADA:</strong> 
                                    Has cumplido con todos los requisitos. Mantente al tanto de las próximas fechas.
                                </div>
                            </div>
                        @endif

                        @if ($estudiante->cve_status == 3)
                            <div class="status-box status-pending">
                                <i class="fa-solid fa-triangle-exclamation fa-2x"></i>
                                <div>
                                    <strong>DOCUMENTACIÓN CON OBSERVACIONES:</strong> Comunícate con la persona responsable del sistema para más información.
                                </div>
                            </div>
                        @endif

                         @if ($estudiante->cve_status == 5)
                            <div class="status-box status-warning">
                                <i class="fa-solid fa-triangle-exclamation fa-2x"></i>
                                <div>
                                    <strong>DOCUMENTACIÓN VALIDADA:</strong> Mantente al tanto de los próximos avisos.
                                </div>
                            </div>
                        @endif
                    @endif

                    @if (!is_null($estudiante->observaciones_estudiante) && $estudiante->cve_status == 3)
                        <div class="obs-box mb-4">
                            <h6 class="font-weight-bold"><i class="fa-solid fa-comment-dots"></i> Observaciones del revisor:</h6>
                            <p class="mb-0">{{ $estudiante->observaciones_estudiante }}</p>
                        </div>
                    @endif

                    <div class="row mt-4">
                        <!-- <div class="col-md-6 mb-4">
                            <h6 class="section-title">Documentación</h6>
                            @php $labelBtn = ($estudiante->img_constancia == 'PENDIENTE') ? 'Subir Constancia' : 'Actualizar Constancia'; @endphp
                            
                            @if ($estudiante->cve_status <= 3)
                                <p class="small text-muted">Asegúrate de que tu constancia sea legible y del periodo actual.</p>
                                <a href="{{ route('estudiantes.formulario_constancia', $estudiante->id_hex) }}" class="btn btn-action btn-verde btn-block">
                                    <i class="fa-solid fa-upload mr-2"></i> {{ $labelBtn }}
                                </a>
                            @endif
                        </div> -->

                        <div class="col-md-12 mb-4 d-flex flex-column align-items-center text-center">
                            <h6 class="section-title border-bottom pb-2 mb-3" style="width: fit-content;">Comprobante</h6>
                            
                            @if ($estudiante->cve_status != 4)
                                <p class="normal text-muted mb-4">
                                    Descarga tu hoja de registro para el <strong>Periodo #{{ $periodo }}</strong> del <strong>Ciclo Escolar {{ $ciclo }}</strong>.
                                </p>
                                
                                <a href="{{ route('estudiantes.registro_pdf') }}" 
                                id="btnDescargarPDF"
                                class="btn btn-action btn-rojo shadow-sm px-5 py-2" 
                                style="max-width: 400px; border-radius: 50px; font-weight: 600;">
                                    <i class="fa-solid fa-file-pdf mr-2"></i> Descargar Hoja de Registro
                                </a>
                            @endif
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <a class="btn btn-action btn-dorado shadow-sm" href="{{ route('estudiantes.forget') }}">
                            <i class="fa-solid fa-house mr-2"></i> Ir al Inicio
                        </a>
                    </div>

                </div> 
            </div> 
        </div>
    </div>
</div>

    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function openWhatsApp() {
            var phoneNumber = "526692295855";
            var isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
            var url = isMobile ? "https://api.whatsapp.com/send?phone=" : "https://web.whatsapp.com/send?phone=";
            window.open(url + phoneNumber, "_blank");
        }

        function mostrarCargando() {
            var overlay = document.getElementById('loading-overlay');
            if (overlay) {
                overlay.style.display = 'flex';
            }
        }

        // Función para ocultar (por si la necesitas tras una validación fallida)
        function ocultarCargando() {
            $('#loading-overlay').hide();
        }

        document.addEventListener("DOMContentLoaded", function() {
            var btnPDF = document.getElementById('btnDescargarPDF');

            if (btnPDF) {
                btnPDF.addEventListener('click', function(e) {
                    // 1. Mostrar la pantalla de carga
                    mostrarCargando();

                    // 2. Cambiar el texto del botón opcionalmente
                    this.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Generando PDF...';
                    this.style.pointerEvents = 'none'; // Evitar múltiples clics

                    // 3. UX Crucial: Ocultar el cargando tras unos segundos
                    // Ya que la descarga no refresca la página, debemos quitar el bloqueo manualmente
                    setTimeout(function() {
                        ocultarCargando();
                        // Restauramos el botón original
                        if (btnPDF) {
                            btnPDF.innerHTML = '<i class="fa-solid fa-file-pdf mr-2"></i> Descargar Hoja de Registro';
                            btnPDF.style.pointerEvents = 'auto';
                        }
                    }, 20000); // 4 segundos suele ser suficiente para iniciar la descarga
                });
            }
        });
    </script>
    <div id="loading-overlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7); z-index: 9999; justify-content: center; align-items: center; flex-direction: column; color: white;">
        <div class="spinner" style="border: 4px solid rgba(255,255,255,0.3); border-top: 4px solid #fff; border-radius: 50%; width: 40px; height: 40px; animation: spin 1s linear infinite;"></div>
        <p style="margin-top: 15px; font-weight: bold;">Procesando, por favor espere...</p>
    </div>

    <style>
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
    </style>
</body>
</html>