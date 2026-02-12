<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>OTRO NIVEL | Acceso al Sistema</title>
    
        <!-- Custom fonts for this template-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <!-- <link
            href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
            rel="stylesheet"> -->
    
        <!-- Custom styles for this template-->
        <link href="{{ asset('css/sb-admin.min.css')}}" rel="stylesheet">  
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <link rel="icon" type="image/png" href="{{ asset('Favicon.png') }}">

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
        // IMPORTANTE: usa la MISMA versión para el worker
        pdfjsLib.GlobalWorkerOptions.workerSrc =
            "https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.worker.min.js";
        </script>





        <script language="JavaScript" type="text/javascript">
            $(document).ready(function(){
                $(function () {
                    $('[data-toggle="tooltip"]').tooltip({
                    trigger : 'click'
                    })
                    $('[data-toggle="tooltip"]').mouseleave(function(){
                    $(this).tooltip('hide');
                    });    
                });
            });
        </script>

    <script>
    //     $(document).ready( function() {
    //         $('#sel_archivo_curp').click(function(){
    //         $('#img_curp').trigger('click');
    //         $('#img_curp').change(function() {
    //             var filename = $('#img_curp').val();
    //             if (filename.substring(3,11) == 'fakepath')
    //             {
    //                 filename = filename.substring(12);
    //             } // Remove c:\fake at beginning from localhost chrome
    //             else
    //             {
    //                 filename = "Sin archivo seleccionado";
    //                 noQuieroArchivo();
    //             }
    //             $('#archivo_curp').html(filename);
    //             });
    //         });
    // });
    // Utilidad: muestra u oculta el ojo según haya archivo
    function actualizarIconoVistaPrevia(nombreArchivo) {
        var pdfIcon = document.getElementById('iconPdf');
        var linkOjo = document.getElementById('vistaPreviaLink');
        if (!linkOjo) return;
        if (!pdfIcon) return;

        const texto = (nombreArchivo || '').trim();
        const sinArchivo = (texto === '' || texto.toLowerCase().includes('sin archivo'));

        if (sinArchivo) {
        linkOjo.classList.add('d-none');
        pdfIcon.classList.add('d-none');
        } else {
        linkOjo.classList.remove('d-none');
        pdfIcon.classList.remove('d-none');
        }
    }

    function reiniciarFormularioArchivo() {
        // 1. Limpiamos el input file físicamente
        $('#img_curp').val(''); 
        
        // 2. Restauramos el texto por defecto
        const defaultText = 'Sin archivo seleccionado';
        $('#archivo_curp').text(defaultText);
        
        // 3. Actualizamos la visibilidad de los iconos
        actualizarIconoVistaPrevia(defaultText);
    }

    $(document).ready(function () {
        // Abre el selector de archivos al hacer click en el botón proxy
        $('#sel_archivo_curp').on('click', function () {
            $('#img_curp').trigger('click');
        });

        // Maneja el cambio de archivo UNA SOLA VEZ
        $('#img_curp').on('change', function (e) {
            let filename = 'Sin archivo seleccionado';

            // Si hay archivo seleccionado, toma el nombre real
            if (e.target.files && e.target.files.length > 0) {
                filename = e.target.files[0].name;
            } else {
                // Si no hay archivo, ejecuta tu lógica de descarte
                noQuieroArchivo && typeof noQuieroArchivo === 'function' && noQuieroArchivo();
            }

            // Asigna el nombre al span
            $('#archivo_curp').text(filename);

            // Muestra/oculta el ojo según corresponda
            actualizarIconoVistaPrevia(filename);
        });

        $(window).on('pageshow', function(event) {
            // Forzamos el reinicio al cargar la página o volver atrás
            // if ($('.swal2-container').length > 0 || {{ $errors->any() ? 'true' : 'false' }}) {
                reiniciarFormularioArchivo(); 
            // }
        });

        // Estado inicial (por si viene desde Blade con valor o vacío)
        const inicial = ($('#archivo_curp').text() || '').trim();
        actualizarIconoVistaPrevia(inicial);
    });
    </script>

    <script language="JavaScript" type="text/javascript">
        // A function that disables button
        function disableButton() {
            document.getElementById('btnSiguiente').setAttribute("disabled","disabled");
            document.getElementById('btnSiguiente').innerText = "Cargando...";
        }

        $(document).ready(function(){
            var $myForm = $("#my_form");
            $myForm.submit(function(){
                disableButton();
                $myForm.submit(function(){
                    return false;
                });
            });
        });
    </script>

<style>
    html, body {
    /* Permitir scroll natural */
    overflow-x: hidden;
    overflow-y: auto;
    height: auto !important; /* Permite que el contenido dicte el largo */
    min-height: 100%;
    -webkit-overflow-scrolling: touch; /* Hace que el scroll en iPhone sea suave */
}

/* Ajuste para que el contenedor no se pegue a los bordes en móvil */
.container {
    padding-bottom: 80px !important; /* Espacio extra al final para que el botón de WhatsApp no se corte */
}

/* Si usas SweetAlert, esto evita que la página "salte" al abrirlo */
body.swal2-shown {
    overflow-y: auto !important;
    padding-right: 0 !important;
}
    .tooltip-inner {
    max-width: 350px;
    /* If max-width does not work, try using width instead */
    width: 350px; 
    max-height: 120px;
    background-color: #2f4fff;
    text-align: left;
}

.modal-dialog.modal-fullscreen-height {
    height: 100vh;
    margin: 0;
    display: flex;
    flex-direction: column;
}

.modal-fullscreen-height .modal-content {
    height: 100%;
    display: flex;
    flex-direction: column;
}

.modal-fullscreen-height .modal-body {
    flex-grow: 1;
    overflow-y: auto; /* Permite el scroll si el contenido es muy largo */
}

.upload-zone {
        border: 2px dashed #e0e0e0;
        border-radius: 25px;
        background-color: #ffffff;
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        cursor: pointer;
    }

    .upload-zone:hover {
        border-color: #7b003a;
        background-color: #fdfafb;
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.05) !important;
    }

    /* Animación de Pulso para el Icono */
    .upload-icon-wrapper {
        position: relative;
        display: inline-block;
    }

    .pulse-animation {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 80px;
        height: 80px;
        background-color: rgba(123, 0, 58, 0.05);
        border-radius: 50%;
        z-index: 1;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% { transform: translate(-50%, -50%) scale(0.8); opacity: 0.8; }
        100% { transform: translate(-50%, -50%) scale(1.5); opacity: 0; }
    }

    /* Botón Siguiente (Para el final del form) */
    .btn-verde-modern {
        background-color: #28a745;
        color: white;
        border-radius: 12px;
        padding: 10px 30px;
        font-weight: bold;
        transition: all 0.3s;
    }
    
    .btn-verde-modern:hover {
        background-color: #218838;
        box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
    }

    .hover-elevate:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1) !important;
        background-color: #5f5f5fff !important;
        color: white !important;
        border-color: #5f5f5fff !important;
    }

    .icon-acento {
        color: #7b003a !important;
    }

    #sel_archivo_curp {
        transition: all 0.3s ease; /* Suaviza los cambios de color */
        cursor: pointer;
    }

    /* Efecto al pasar el mouse (Hover) */
    #sel_archivo_curp:hover {
        background-color: #ad0051ff !important; /* Un tono más claro del guinda */
        transform: translateY(-2px); /* Un pequeño salto hacia arriba */
        shadow: 0 4px 15px rgba(0,0,0,0.3); /* Sombra más profunda */
    }

    /* Efecto al hacer click (Active) */
    #sel_archivo_curp:active {
        background-color: #5a002a !important; /* Un tono más oscuro */
        transform: translateY(0); /* Regresa a su posición original */
        box-shadow: inset 0 3px 5px rgba(0,0,0,0.2); /* Sombra interna para efecto de "hundido" */
    }
</style>

<style>
    .btn-dorado {
      background-color: #706f6f;
      color: white;
    }
  
    .btn-dorado:hover {
      background-color: #575757; /* Cambia el color aquí al deseado cuando el mouse esté encima */
      color: white;
    }

    .btn-verde {
      background-color: #00656c;
      color: white;
    }
  
    .btn-verde:hover {
      background-color: #4a826a; /* Cambia el color aquí al deseado cuando el mouse esté encima */
      color: white;
    }

    .btn-verde:active {
        background-color: #356b5d; /* Cambia el color aquí al deseado cuando el botón está activado (clic) */
        color: white;
    }

    .btn-guinda {
      background-color: #7b003a;
      color: white;
    }
  
    .btn-guinda:hover {
      background-color: #932f4a; /* Cambia el color aquí al deseado cuando el mouse esté encima */
      color: white;
    }

    .btn-rojo {
      background-color: #932f4a;
      color: white;
    }
  
    .btn-rojo:hover {
      background-color: #5c2134; /* Cambia el color aquí al deseado cuando el mouse esté encima */
      color: white;
    }

    .text-rojo {
            color: #932f4a;
        }

        .text-rojo:hover {
            color: #5c2134;
        }

        /* --- CONFIGURACIÓN DEL SCROLL EN MÓVIL --- */
        .scroll-container-pdf {
            height: 70vh; /* Altura fija para forzar el scroll */
            overflow-y: auto !important;
            overflow-x: hidden;
            -webkit-overflow-scrolling: touch; /* Scroll suave en iOS */
            position: relative;
        }

        .pdf-wrapper {
            padding: 1rem;
            min-height: calc(70vh + 2px); /* Obliga al scroll a existir */
            display: flex;
            justify-content: center;
        }

        #pdfCanvas {
            max-width: 100% !important;
            height: auto !important;
            /* IMPORTANTE: pointer-events permite que el scroll funcione 
            al arrastrar el dedo sobre el canvas en celulares */
            pointer-events: none; 
        }

        /* --- ESTILOS DE BOTONES PERSONALIZADOS --- */
        .custom-btn-confirm {
            background-color: #00656c; /* O tu color verde */
            color: white;
            border-radius: 20px;
            font-weight: 600;
            min-width: 130px;
            border: none;
            transition: all 0.3s ease;
        }

        .custom-btn-confirm:hover {
            background-color: #218838;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }

        .custom-btn-confirm:active {
            transform: translateY(0);
            filter: brightness(0.8);
        }

        .custom-btn-discard {
            border-radius: 20px;
            font-weight: 600;
            min-width: 110px;
            transition: all 0.3s ease;
        }

        /* --- AJUSTES PARA PANTALLAS PEQUEÑAS --- */
        @media (max-width: 576px) {
            .modal-header {
                text-align: center;
            }
            
            .scroll-container-pdf {
                height: 60vh; /* Un poco menos de altura en móviles para dejar ver el header */
            }

            /* En móvil los botones se reparten el ancho */
            .w-100.w-md-auto .btn {
                flex: 1;
            }
        }

        /* Clase personalizada para el contenedor inteligente */
        .contenedor-adaptable {
            overflow-x: hidden; /* Siempre oculto el horizontal */
        }

        /* Solo para celulares y tablets (Pantallas menores a 768px) */
        @media (max-width: 767px) {
            .contenedor-adaptable {
                max-height: 75vh; /* Un poco menos para que se vea el fondo */
                overflow-y: auto;
                -webkit-overflow-scrolling: touch; /* Scroll suave en iPhone */
                padding-bottom: 20px;
                border-bottom: 1px solid #eee; /* Una línea sutil para indicar final */
            }
        }

        /* Para computadoras (Pantallas mayores a 768px) */
        @media (min-width: 768px) {
            .contenedor-adaptable {
                max-height: none; 
                overflow-y: visible;
            }
        }

        /* Estilos para mejorar el modal en dispositivos móviles */
        /* @media (max-width: 768px) {
            #requisitosModal .modal-dialog {
                margin: 10px;
                max-height: calc(90vh - 20px);
            }
            
            #requisitosModal .modal-content {
                max-height: calc(90vh - 20px);
                    }
            
            #requisitosModal .modal-body {
                max-height: 100vh;
                overflow-y: auto;
            }
        } */

            @media (max-width: 768px) {
            #requisitosModal .modal-dialog {
                margin: 0;
                height: 105vh;
                max-height: 110vh;
                width: 100%;
                max-width: 100%;
            }
            
            #requisitosModal .modal-content {
                height: 105vh;
                border-radius: 0;
                display: flex;
                flex-direction: column;
            }
            
            #requisitosModal .modal-header {
                padding: 1rem 1.5rem;
                border-bottom: 1px solid rgba(255,255,255,0.2);
            }
            
            #requisitosModal .modal-body {
                flex: 1;
                overflow-y: auto;
                padding: 1.5rem;
            }
            
            #requisitosModal .modal-footer {
                padding: 1rem 1.5rem;
                border-top: 1px solid #dee2e6;
                background: #f8f9fa;
            }
        }

  </style>


    <!-- Ventana Modal -->
    <div class="modal fade" id="pdfModal" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-fullscreen-sm-down">
            <div class="modal-content shadow-lg border-0">
                
                <div class="modal-header bg-light d-flex flex-column flex-md-row align-items-center justify-content-between p-3 gap-3">
                    
                <div class="d-flex align-items-center flex-grow-1" style="min-width: 0;">
                <div class="me-2 d-flex align-items-center justify-content-center flex-shrink-0" 
                    style="width: 32px; height: 32px;">
                    <i class="fa-solid fa-file-pdf" style="color: #7b003a; font-size: 1.2rem;"></i>
                </div>
                
                <div style="min-width: 0; flex: 1; line-height: 1;">
                    <h6 class="modal-title fw-bolder mb-0" id="pdfModalLabel" 
                        style="color: #2c3e50; letter-spacing: -0.5px; white-space: nowrap; font-size: 1rem;">
                        Vista Preliminar <span class="d-none d-md-inline">del Archivo</span>:
                        <label id="lblNombreDoc" style="font-weight: 900; color: #7b003a; margin-left: 5px;"> CURP</label>
                    </h6>
                    
                    <small class="text-muted d-flex align-items-center" 
                        style="font-size: 0.85rem; white-space: nowrap;  margin-top: -4px; opacity: 0.8;">
                        <i class="bi bi-shield-check-fill text-success me-1"></i> 
                        <span class="d-md-none">Verificado por el sistema</span>
                        <span class="d-none d-md-inline">Documento verificado por el sistema</span>
                    </small>
                </div>
            </div>

            <div class="d-flex gap-2 justify-content-end align-items-center w-100 w-md-auto">
                <button type="button" class="btn btn-verde btn-sm px-4 py-2 custom-btn-confirm" data-bs-dismiss="modal">
                    Confirmar
                </button> 
                <button type="button" class="btn btn-outline-danger ml-2 btn-sm px-4 py-2 custom-btn-discard" onclick="noQuieroArchivo()">
                    Descartar
                </button>
            </div>
        </div>

            <div class="modal-body p-0 bg-dark-subtle scroll-container-pdf">
                <div class="pdf-wrapper">
                    <canvas id="pdfCanvas" class="shadow-lg bg-white mx-auto d-block"></canvas>
                </div>
            </div>

            <div class="modal-footer py-2 bg-light justify-content-center">
                <small class="text-muted" style="font-size: 0.75rem;">
                    <i class="fa-solid fa-arrows-up-down me-1 mr-2"></i> Deslice para revisar toda la información
                </small>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="requisitosModal" tabindex="-1" role="dialog"
     aria-labelledby="requisitosModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable" role="document">
        <div class="modal-content border-0 shadow-lg"
             style="border-radius:16px; overflow:hidden;">

            <!-- Header -->
            <div class="modal-header"
                 style="background:linear-gradient(135deg,#00656c,#004c52); color:#fff;">
                <div>
                    <h6 class="modal-title font-weight-bold text-uppercase mb-0"
                        id="requisitosModalLabel">
                        Requisitos oficiales de registro 
                    </h6>
                    <small class="mt-0" style="opacity:.85;">Programa OTRO NIVEL</small>
                </div>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Body -->
            <div class="modal-body px-4 py-2" style="font-size:0.9rem;">
                <!-- Paso 1 -->
                <div class="d-flex align-items-start mb-4">
                    <div class="step-badge mr-3">1</div>
                    <div>
                        <h6 class="font-weight-bold mb-1">
                            CURP en PDF digital
                        </h6>
                        <p class="mb-0 text-muted">
                            Debe ser el archivo original descargado del portal oficial.
                        </p>
                    </div>
                </div>

                <!-- Paso 2 -->
                <div class="d-flex align-items-start mb-3">
                    <div class="step-badge mr-3">2</div>
                    <div>
                        <h6 class="font-weight-bold mb-2">
                            Documentos adicionales en PDF (Obligatorios)
                        </h6>

                        <div class="card mb-2 border-0 shadow-sm">
                            <div class="card-body py-2 d-flex align-items-start">
                                <i class="fas fa-id-card icon-acento text-muted mr-2 mt-1"></i>
                                <div>
                                    <strong>Identificación oficial</strong>
                                    <div class="small text-muted">
                                        Credencial del INE con domicilio en Concordia, Sinaloa
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-2 border-0 shadow-sm">
                            <div class="card-body py-2 d-flex align-items-start">
                                <i class="fas fa-scroll icon-acento text-muted mr-2 mt-1"></i>
                                <div>
                                    <strong>Acta de nacimiento</strong>
                                    <div class="small text-muted">Formato reciente.</div>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-2 border-0 shadow-sm">
                            <div class="card-body py-2 d-flex align-items-start">
                                <i class="fas fa-home icon-acento text-muted mr-2 mt-1"></i>
                                <div>
                                    <strong>Comprobante de domicilio</strong>
                                    <div class="small text-muted">
                                        CFE, Agua Potable, MegaCable o TELMEX
                                        (Concordia, Sinaloa).
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-2 border-0 shadow-sm">
                            <div class="card-body py-2 d-flex align-items-start">
                                <i class="fas fa-graduation-cap icon-acento text-muted mr-2 mt-1"></i>
                                <div>
                                    <strong>Kardex escolar</strong>
                                    <div class="small text-muted">
                                        Calificaciones del periodo recién cursado. (Promedio >= 8.0)
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card border-0 shadow-sm">
                            <div class="card-body py-2 d-flex align-items-start">
                                <i class="fas fa-school icon-acento text-muted mr-2 mt-1"></i>
                                <div>
                                    <strong>Constancia de estudios</strong>
                                    <div class="small text-muted">
                                        Ciclo escolar 2025‑2026 (Escuela fuera del municipio de Concordia)
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Reglas -->
                <div class="d-inline-flex align-items-center p-2 px-4 rounded-pill mt-1 mb-1"
                    style="background-color:#fce4ec; color:#7b003a; border:1px solid #f8bbd0;">
                    <i class="fas fa-info-circle mr-2"></i>
                    <span>
                        Todos los archivos deben ser <strong>legibles</strong>
                        y no exceder <strong>1 MB</strong>.
                    </span>
                </div>
            </div>

            <!-- Footer -->
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-outline-secondary rounded-pill px-4"
                        data-dismiss="modal">
                    Cerrar
                </button>              
            </div>
        </div>
    </div>
</div>
</head>
<body>
    <div class="container contenedor-adaptable">
        <div class="card-body">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="row justify-content-center mb-2 text-center">
                            <img 
                                src="{{ asset('img/Logo_y_Escudo.jpg') }}"
                                class="img-fluid mx-auto d-block"
                                style="width:75%;">
                    </div>
                    <div class="card">
                        <form id="my_form" name="my_form" class="contact-form" method="POST" action="{{ route('estudiantes.formulario-curp.post') }}" enctype="multipart/form-data" novalidate>
                            @csrf
                            <div class="row justify-content-center mt-3 mb-2">
                                <a href="{{ route('estudiantes.forget') }}" class="text-center">
                                    <img src="../img/logo_programa.jpg" class="img-fluid" style="max-width: 60%;">
                                </a>
                            </div>
                            @php
                                $columnClass = $convocatoria_abierta ? 'col-md-8' : 'col-md-10';
                                $columnClass2 = $convocatoria_abierta ? 'col-md-4' : 'col-md-2';
                            @endphp
                            <div class="row mb-2">
                                <div class="col-12">
                                    <div class="card border-0 shadow-sm" style="border-radius: 15px; background: linear-gradient(to right, #7b003a, #9d0c4f);">
                                        <div class="card-body p-4 text-white">
                                            <div class="row align-items-center">
                                                <div class="{{ $columnClass }} text-center text-md-left">
                                                    <h4 class="font-weight-bold mb-2">Acceso al Sistema</h4>
                                                    @if ($convocatoria_abierta)
                                                    <p class="mb-0 opacity-80" style="font-size: 0.95rem;">
                                                        Utiliza este panel tanto para realizar un <strong>nuevo registro</strong> como para <strong>consultar el estatus</strong> de tu solicitud
                                                    </p>
                                                    @else
                                                    <p class="mb-3 opacity-80" style="font-size: 0.95rem;">
                                                        Utiliza este panel para <strong>consultar el estatus</strong> de tu solicitud
                                                    </p>
                                                     <a href="https://www.concordia.gob.mx/2026/CONVOCATORIA_OTRO_NIVEL_25226_1.pdf" 
                                                        target="_blank" 
                                                        class="btn btn-outline-light btn-sm px-4 mb-0" 
                                                        style="border-radius: 20px; font-weight: 600; border-width: 2px;">
                                                            <i class="fas fa-file-pdf mr-2"></i>Ver Convocatoria
                                                    </a>
                                                    @endif
                                                </div>                                                
                                                <div class="{{ $columnClass2 }} text-center text-md-right mt-4 mt-md-0">
                                                    @if ($convocatoria_abierta)
                                                    <div class="d-inline-block text-center px-3 border-right border-white-50">
                                                        <i class="fas fa-user-plus fa-lg d-block mb-1"></i>
                                                        <small class="text-uppercase font-weight-bold" style="font-size: 0.7rem;">Registro</small>
                                                    </div>
                                                    @endif
                                                    <div class="d-inline-block text-center px-3">
                                                        <i class="fas fa-search fa-lg d-block mb-1"></i>
                                                        <small class="text-uppercase font-weight-bold" style="font-size: 0.7rem;">Estatus</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-3 bg-white rounded-lg">
                                @if ($convocatoria_abierta)
          <div class="alert shadow-lg border-0 p-0 overflow-hidden" 
     style="background: #ffffff; border-radius: 24px; box-shadow: 0 10px 30px rgba(0,0,0,0.08)!important;">
    
    <div class="px-4 py-3 d-flex align-items-center" style="background: linear-gradient(90deg, #7b003a 0%, #a5004d 100%);">
        <div class="rounded-circle bg-white d-flex align-items-center justify-content-center mr-3 shadow-sm" style="width: 35px; height: 35px; opacity: 0.9;">
            <i class="fas fa-rocket fa-lg" style="color:#7b003a;"></i>
        </div>
        <h6 class="font-weight-bold text-uppercase mb-0 text-white" style="letter-spacing: 1.5px; font-size: 1.1rem;">
            Guía de Postulación Digital
        </h6>
    </div>

    <div class="p-4">
        <div class="row align-items-stretch">
            <div class="col-md-6 border-right-md pr-md-4">
                <div class="mb-4">
                    @if ($convocatoria_abierta)
                        <div class="d-flex align-items-center mb-2">
                            <span class="badge badge-pill px-3 py-2 small font-weight-black text-uppercase" style="letter-spacing: 1px; background: #e6fffa; color: #047857; border: 1px solid #34d399;">
                                <span class="spinner-grow spinner-grow-sm mr-1" role="status" aria-hidden="true"></span>
                                CONVOCATORIA ACTIVA
                            </span>
                        </div>
                        <div class="d-inline-flex align-items-center px-3 py-2 shadow-sm" 
                             style="background: #f8fafc; border-radius: 12px; border-left: 4px solid #00656c;">
                            <i class="far fa-calendar-check mr-2" style="color: #00656c;"></i>
                            <span class="small font-weight-bold text-dark">
                                Límite: <span style="color: #00656c;">14 de Febrero, 2026</span>
                            </span>
                        </div>
                    @else
                        <span class="badge badge-pill badge-danger px-3 py-2 shadow-sm">
                            <i class="fas fa-clock mr-1"></i> PROCESO FINALIZADO
                        </span>
                    @endif
                </div>

                <div class="rounded-lg p-3" style="background: #f1f5f9; border-radius: 16px;">
                    <div class="d-flex mb-2">
                        <i class="fas fa-fingerprint text-primary mr-2 mt-1"></i>
                        <p class="small mb-0 text-dark">
                            <strong>Validación de Identidad:</strong> Solo se procesarán archivos <b>PDF originales</b> del CURP.
                        </p>
                    </div>
                    <div class="d-flex border-top pt-2 mt-2" style="border-color: #e2e8f0!important;">
                        <i class="fas fa-shield-virus text-danger mr-2 mt-1"></i>
                        <p class="extra-small mb-0 text-muted" style="font-size: 0.75rem;">
                            Evite digitalizaciones manuales (fotos/escaneos) para no ser rechazado por el sistema.
                        </p>
                    </div>
                </div>
            </div>

             <div class="col-md-6 pl-md-4 text-center mt-6">
                <div class="d-flex flex-column align-items-center gap-2">
                    <a href="https://www.concordia.gob.mx/2026/CONVOCATORIA_OTRO_NIVEL_25226_1.pdf"
                    target="_blank"
                    class="btn btn-rojo btn-sm px-4 p-2 mb-4"
                    style="border-radius: 20px; font-weight: 600; border-width: 2px; min-width:230px;">
                        <i class="fas fa-file-pdf mr-2"></i> Ver Convocatoria
                    </a>

                    <a href="https://www.gob.mx/curp/"
                    target="_blank"
                    class="btn btn-sm border rounded-pill shadow-sm d-inline-flex align-items-center justify-content-center px-3 py-2 hover-elevate btn-curp"
                    style="background:#ffffff; font-weight:600; font-size:0.85rem; min-width:230px;">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            width="14" height="14"
                            fill="currentColor"
                            class="mr-1"
                            viewBox="0 0 16 16">
                            <path d="M4 0h6.293A1 1 0 0 1 11 0.293l3.707 3.707A1 1 0 0 1 15 4.707V15a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V1a1 1 0 0 1 1-1z"/>
                            <path d="M9.5 3a.5.5 0 0 1 .5.5V6h2.5a.5.5 0 0 1 0 1H10v2.5a.5.5 0 0 1-1 0V7H6.5a.5.5 0 0 1 0-1H9V3.5a.5.5 0 0 1 .5-.5z"/>
                        </svg>
                        Obtener CURP Original
                    </a>
                    <small class="text-muted text-center mt-1 mb-3">
                        Sitio oficial del Gobierno de México
                    </small>
                    <button type="button"
                            class="btn btn-verde btn-sm rounded-pill d-inline-flex align-items-center justify-content-center px-3 py-2"
                            data-toggle="modal" data-target="#requisitosModal"
                            style="font-weight:600; font-size:0.8rem; min-width:230px;">
                        <i class="fas fa-list-check mr-1 p-1"></i>
                        Ver REQUISITOS de Registro
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .hover-elevate:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 15px rgba(123, 0, 58, 0.2) !important;
    }
    .font-weight-black { font-weight: 900; }
    .extra-small { line-height: 1.2; }
</style>
                                @endif
                                @if (session()->has('message') || $errors->any())
                                <style>
                                    /* Texto para computadora */
                                    .swal-text-pc {
                                        font-size: 1rem !important;
                                        text-align: left;
                                    }

                                    /* Texto para celular */
                                    .swal-text-movil {
                                        font-size: 0.9rem !important; /* Texto más pequeño */
                                        text-align: center!important;
                                        max-height: 45vh !important; /* Limita el alto para que no tape el botón */
                                        overflow-y: auto !important; /* Si el texto es mucho, permite scroll interno */
                                        padding: 0 5px !important;
                                    }

                                    /* Ajuste general del modal */
                                    .redondear-modal {
                                        border-radius: 20px !important;
                                    }

                                    /* Asegura que el botón no sea gigante en móvil */
                                    .redondear-boton {
                                        border-radius: 999px !important;
                                        padding: 10px 30px !important;
                                        font-size: 0.9rem !important;
                                    }

                                    /* Reducir el tamaño del icono de SweetAlert en móvil */
                                    .swal2-icon.swal2-error.icon-movil {
                                        transform: scale(0.6); /* Reduce el icono al 60% */
                                        margin-top: 5px !important;
                                        margin-bottom: 0 !important;
                                    }

                                    /* Espaciado ultra-compacto para móvil */
                                    .swal-text-movil hr {
                                        margin: 10px 0 !important; /* Separador más pequeño */
                                    }

                                    .swal-text-movil #mensaje-recomendacion {
                                        border-radius: 15px !important; /* Menos redondeado para ganar espacio */
                                        padding: 8px !important;
                                        font-size: 0.8rem !important;
                                        line-height: 1.2 !important;
                                    }

                                    /* Eliminar espacios excesivos en la parte superior del modal en móvil */
                                    @media (max-width: 767px) {
                                        /* Reduce el espacio entre el icono y el título */
                                        .swal2-title {
                                            margin-top: -15px !important; /* Sube el título hacia el icono */
                                            padding-top: 0 !important;
                                        }

                                        /* Reduce el espacio que el icono empuja hacia abajo */
                                        .swal2-icon {
                                            margin-top: 10px !important;
                                            margin-bottom: 5px !important;
                                        }

                                        /* Reduce el espacio entre el título y el contenido (mensajeHtml) */
                                        .swal2-html-container {
                                            margin-top: 5px !important;
                                        }
                                    }

                                    /* El estilo del icono que ya teníamos, asegurando que no empuje el título */
                                    .swal2-icon.swal2-error.icon-movil {
                                        transform: scale(0.6);
                                        margin-bottom: 0 !important;
                                    }
                                </style>
                                <script>
                                   $(document).ready(function() {
                                        const esMovil = window.innerWidth <= 768;
                                        
                                        // Ajustamos el padding inicial según el dispositivo
                                        let mensajeHtml = `<div style="font-size: ${esMovil ? '0.9em' : '1.1em'}; text-align: left; padding: 0 ${esMovil ? '5px' : '10px'};">`;

                                        @if(session()->has('message'))
                                            mensajeHtml += `<div style="margin-bottom: ${esMovil ? '8px' : '15px'};">{!! html_entity_decode(session()->get('message')) !!}</div>`;
                                        @endif

                                        @if($errors->any())
                                            // Reducimos el margen de la lista en móvil
                                            mensajeHtml += `<ul style="display: inline-block; text-align: left; margin-top: ${esMovil ? '5px' : '10px'}; padding-left: 20px; list-style-position: outside;">`;
                                            @foreach ($errors->all() as $error)
                                                mensajeHtml += `<li style="margin-bottom: ${esMovil ? '4px' : '10px'};">{!! $error !!}</li>`;
                                            @endforeach
                                            mensajeHtml += '</ul>';
                                        @endif

                                        mensajeHtml += `
                                            <hr style="margin: ${esMovil ? '10px' : '20px'} 0; border: 0; border-top: 1px solid #eee;">
                                            <div id="mensaje-recomendacion" style="color: #666; background: #f9f9f9; padding: 10px; border-radius: ${esMovil ? '15px' : '60px'};">
                                                <strong>💡 Recomendación:</strong><br>
                                                - Usa el PDF original de <a href="https://www.gob.mx/curp/" target="_blank" style="color: #3085d6; font-weight: bold;">gob.mx/curp/</a>.
                                                ${esMovil ? '' : '<br> - Evita fotos o escaneos para que el sistema lo valide correctamente.'} 
                                            </div>
                                        </div>`;

                                        Swal.fire({
                                            title: `<strong style="font-size: ${esMovil ? '1em' : '1.2em'};">¡Atención!</strong>`,
                                            html: mensajeHtml,
                                            icon: 'error',
                                            confirmButtonText: 'Entendido',
                                            confirmButtonColor: '#7a2525',
                                            width: esMovil ? '95%' : '550px',
                                            heightAuto: false,
                                            customClass: {
                                                popup: 'redondear-modal',
                                                confirmButton: 'redondear-boton',
                                                htmlContainer: esMovil ? 'swal-text-movil' : 'swal-text-pc',
                                                icon: esMovil ? 'icon-movil' : '' // Aplicamos la clase de tamaño al icono
                                            },
                                            showClass: {
                                                popup: 'animate__animated animate__fadeInDown animate__faster'
                                            },
                                            hideClass: {
                                                popup: 'animate__animated animate__fadeOutUp animate__faster'
                                            }
                                        });
                                    });
                                </script>
                                @endif
                                <div class="d-flex align-items-center justify-content-between mt-4 mb-4">
                                    <div class="d-flex align-items-center">
                                        <div style="width: 4px; height: 30px; background-color: #7b003a; border-radius: 10px;"></div>
                                        <div class="ml-3">
                                            <h5 class="mb-0 font-weight-bold" style="color: #4a4a4a;">Gestión de Solicitud</h5>
                                            <normal class="text-muted">Identificación mediante CURP digital</normal>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center mb-2">
                                    <div class="d-inline-block p-2 px-4 rounded-pill" style="background-color: #fce4ec; color: #7b003a; border: 1px solid #f8bbd0;">
                                        <i class="fas fa-fingerprint mr-2"></i>
                                        <span class="normal font-weight-bold">Tu CURP es tu llave de acceso</span>
                                    </div>
                                </div>
                                <div class="row justify-content-center mt-4 mb-2">
                                    <div class="col-md-10 col-lg-8">
                                        <div class="upload-zone p-5 text-center position-relative shadow-sm" id="drop-area">
                                            <i class="fas fa-file-pdf position-absolute" style="right: 20px; bottom: 10px; font-size: 5rem; color: rgba(0,0,0,0.03);"></i>

                                            <div class="upload-icon-wrapper mb-4">
                                                <div class="pulse-animation"></div>
                                                <i class="fas fa-cloud-upload-alt fa-3x" style="color: #7b003a; position: relative; z-index: 2;"></i>
                                            </div>

                                            <h6 class="font-weight-bold mb-2">Selecciona tu archivo CURP</h6>
                                            <p class="text-muted small mb-4">Arrastra el archivo aquí o haz clic en el botón</p>

                                            <button type="button" class="btn px-5 py-2 shadow" id="sel_archivo_curp" 
                                                    style="background-color: #7b003a; color: white; border-radius: 30px; font-weight: 600; border: none; font-size: 0.9rem;">
                                                EXAMINAR EQUIPO
                                            </button>

                                            <div id="archivo_curp_container" class="mt-4 p-2 bg-white rounded-pill border d-inline-flex align-items-center px-4 mx-auto shadow-sm" 
                                                style="max-width: 90%; {{ isset($estudiante->img_curp) ? '' : 'display:none;' }}">
                                                <i id="iconPdf" class="fas fa-file-pdf text-danger mr-2" onclick="mostrarVistaPrevia()"></i>
                                                <span id="archivo_curp" class="small text-truncate font-weight-bold" style="max-width: 200px;">
                                                    {{ $estudiante->img_curp ?? 'Sin archivo seleccionado' }}
                                                </span>
                                                <span id="vistaPreviaLink"
                                                    onclick="mostrarVistaPrevia()"
                                                    class="ml-3 text-primary small"
                                                    style="cursor:pointer;"
                                                    title="Previsualizar">
                                                    <i class="fas fa-eye"></i>
                                                </span>
                                            </div>

                                           <div class="mt-3 validation-notice" id="spanSiguiente" style="display: none;">
                                                <i class="fas fa-arrow-right mr-1"></i> 
                                                Selecciona <strong>Siguiente</strong> para continuar
                                            </div>

                                                <style>
                                                .validation-notice {
                                                    padding: 12px 16px;
                                                    background-color: #e7fff8ff; /* Azul clarito para resaltar */
                                                    border-left: 4px solid #00656c; /* Barra lateral llamativa */
                                                    color: #00656c;
                                                    border-radius: 6px;
                                                    font-size: 0.85rem;
                                                    display: inline-block;
                                                    animation: pulse-subtle 2s infinite; /* Un pequeño movimiento para atraer la vista */
                                                }

                                                @keyframes pulse-subtle {
                                                    0% { transform: scale(1); }
                                                    50% { transform: scale(1.02); }
                                                    100% { transform: scale(1); }
                                                }
                                                </style>

                                            <input class="file" type="file" style="display: none" name="img_curp" id="img_curp" accept=".pdf, .PDF" onchange="mostrarVistaPreviaPDF(this)">
                                        </div>
                                        
                                        <div class="d-flex justify-content-between mt-3 px-2">
                                            <span class="small text-muted"><i class="fas fa-shield-alt mr-1"></i> Formato PDF Seguro</span>
                                            <span class="small text-muted font-weight-bold">Tamaño máx: 1MB</span>
                                        </div>

                                        <div class="row mt-3 mb-3">
                                            <div class="col-12">
                                                <button type="submit"
                                                        id="btnSiguiente"
                                                        name="btnSiguiente"
                                                        class="btn btn-verde float-right px-4 py-2"
                                                        style="border:none; font-weight:600; border-radius:999px; display:none">
                                                    Siguiente <i class="fas fa-chevron-right"></i>
                                                </button> 
                                            </div>
                                        </div>                                       
                                    </div>
                                </div>
                                <div class="support-container mt-2">
                                    <div class="p-3 rounded shadow-sm border-left-highlight" 
                                        style="background: #ffffff; border: 1px solid #e3e6f0; border-left: 5px solid #7b003a; font-size: 0.9rem;">
                                        
                                        <div class="row align-items-center">
                                            <div class="col-md-6 mb-3 mb-md-0 border-right-md">
                                                <div class="d-flex align-items-center">
                                                    <div class="icon-circle bg-whatsapp-light mr-3">
                                                        <i class="fab fa-whatsapp" style="color: #25D366; font-size: 1.4rem;"></i>
                                                    </div>
                                                    <div>
                                                        <span class="text-muted d-block small uppercase font-weight-bold">¿Necesitas ayuda?</span>
                                                        <a href="javascript:void(0);" onclick="openWhatsApp('526949568140')" 
                                                        class="support-link" style="color: #7b003a; font-size: 1.1rem; font-weight: 700; text-decoration: none;">
                                                        694 956 8140
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="d-flex align-items-start">
                                                    <i class="fas fa-university mr-3 mt-1 text-muted" style="font-size: 1.1rem;"></i>
                                                    <div>
                                                        <span class="text-muted d-block small uppercase font-weight-bold">Atención Presencial</span>
                                                        <span class="text-dark">
                                                            Presidencia Municipal <br>
                                                            <small class="text-secondary">
                                                                <i class="far fa-clock mr-1"></i> Lunes a Viernes • 8:30 a.m. a 3:00 p.m.
                                                            </small>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <style>
                                    .bg-whatsapp-light {
                                        background-color: #e8f9ee;
                                        width: 45px;
                                        height: 45px;
                                        display: flex;
                                        align-items: center;
                                        justify-content: center;
                                        border-radius: 50%;
                                    }
                                    .border-left-highlight {
                                        transition: transform 0.2s ease;
                                    }
                                    .border-left-highlight:hover {
                                        transform: translateY(-2px);
                                    }
                                    .support-link:hover {
                                        color: #a3004d !important;
                                    }
                                    .uppercase { text-transform: uppercase; letter-spacing: 0.5px; }
                                    
                                    @media (min-width: 768px) {
                                        .border-right-md { border-right: 1px solid #e3e6f0; }
                                    }
                                </style>
                            </div>
                        </div>                        
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- <div class="container py-4">
        <div class="card-body">
            <div class="row justify-content-center mb-3">
                <div class="col-md-8">
                    <a href="{{ route('estudiantes.forget') }}" class="text-center d-block">
                        <img src="{{ asset('img/Logo_y_Escudo.jpg') }}" class="img-fluid" style="width:85%; max-width: 500px;">
                    </a>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card shadow-lg border-0" style="border-radius: 20px; overflow: hidden;">
                        <form id="my_form" name="my_form" class="contact-form" method="POST" action="{{ route('estudiantes.formulario-curp.post') }}" enctype="multipart/form-data" novalidate>
                            @csrf
                            
                            <div class="text-center mt-4 mb-3">
                                <img src="../img/logo_programa.jpg" style="width:180px; max-width:40%;">
                            </div>

                            <div class="px-4 mb-4">
                                <div class="card border-0 shadow-sm" style="border-radius: 15px; background: linear-gradient(135deg, #7b003a, #9d0c4f);">
                                    <div class="card-body p-3 p-md-4 text-white">
                                        <div class="row align-items-center">
                                            <div class="col-md-8">
                                                <h4 class="font-weight-bold mb-1" style="font-size: 1.25rem;">Acceso al Sistema</h4>
                                                <p class="mb-0 opacity-80 small">Registro y consulta de estatus mediante tu CURP.</p>
                                            </div>
                                            <div class="col-md-4 text-md-right mt-3 mt-md-0 d-flex justify-content-md-end gap-3">
                                                <div class="text-center px-2">
                                                    <i class="fas fa-user-plus d-block mb-1"></i>
                                                    <small class="text-uppercase font-weight-bold" style="font-size: 0.6rem;">Registro</small>
                                                </div>
                                                <div class="text-center px-2">
                                                    <i class="fas fa-search d-block mb-1"></i>
                                                    <small class="text-uppercase font-weight-bold" style="font-size: 0.6rem;">Estatus</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="px-4">
                                <div class="alert border-0 shadow-sm p-4" style="background: #fdfdfd; border-radius: 15px; border-left: 5px solid #7b003a !important;">
                                    <div class="d-flex align-items-center mb-3">
                                        <i class="fas fa-calendar-check fa-lg mr-2" style="color:#7b003a;"></i>
                                        <h6 class="font-weight-bold text-uppercase mb-0" style="color:#7b003a; letter-spacing: 0.5px;">
                                            Convocatoria 2026
                                        </h6>
                                    </div>

                                    <div class="bg-white rounded p-3 border">
                                        <div class="row align-items-center">
                                            <div class="col-md-7 border-md-right">
                                                <p class="mb-2 d-flex align-items-center">
                                                    <i class="fas fa-clock mr-2 text-muted"></i>
                                                    @if ($convocatoria_abierta)
                                                        <span>Estatus: <strong class="text-success">¡Abierta ahora!</strong><br>
                                                        Del <strong>3 al 14 de Febrero</strong></span>
                                                    @else
                                                        <span class="text-danger font-weight-bold">Convocatoria Finalizada</span>
                                                    @endif
                                                </p>
                                                <p class="mb-0 small text-muted">
                                                    <i class="fas fa-file-pdf mr-2"></i>Requiere PDF original (no fotos).
                                                </p>
                                            </div>
                                            <div class="col-md-5 text-center mt-3 mt-md-0">
                                                <a href="https://www.gob.mx/curp/" target="_blank" class="btn btn-outline-secondary btn-sm rounded-pill px-3 w-100 mb-2">
                                                    <i class="fas fa-download mr-1"></i> Descargar CURP
                                                </a>
                                                <button type="button" class="btn btn-verde btn-sm rounded-pill px-3 w-100" data-toggle="modal" data-target="#requisitosModal">
                                                    <i class="fas fa-list-check mr-1"></i> Requisitos
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body px-4 pt-0">
                                <div class="text-center mb-4">
                                    <div class="d-inline-block p-2 px-4 rounded-pill" style="background-color: #fce4ec; color: #7b003a; border: 1px solid #f8bbd0;">
                                        <i class="fas fa-fingerprint mr-2"></i>
                                        <span class="font-weight-bold small">Tu CURP es tu llave de acceso</span>
                                    </div>
                                </div>

                                <div class="upload-zone p-4 p-md-5 text-center position-relative shadow-sm border" id="drop-area" style="border-style: dashed !important; border-width: 2px !important; border-radius: 20px;">
                                    <div class="upload-icon-wrapper mb-3">
                                        <i class="fas fa-cloud-upload-alt fa-3x" style="color: #7b003a;"></i>
                                    </div>
                                    <h6 class="font-weight-bold mb-1">Selecciona tu archivo CURP</h6>
                                    <p class="text-muted small mb-4">Haz clic abajo para buscar el archivo PDF</p>

                                    <button type="button" class="btn px-5 py-2" id="sel_archivo_curp" 
                                            style="background-color: #7b003a; color: white; border-radius: 30px; font-weight: 600; border: none; transition: 0.3s;">
                                        EXAMINAR EQUIPO
                                    </button>

                                    <div id="archivo_curp_container" class="mt-4 p-2 bg-white rounded-pill border d-inline-flex align-items-center px-4 shadow-sm" 
                                         style="{{ isset($estudiante->img_curp) ? '' : 'display:none;' }}">
                                        <i class="fas fa-file-pdf text-danger mr-2"></i>
                                        <span id="archivo_curp" class="small text-truncate font-weight-bold" style="max-width: 150px;">
                                            {{ $estudiante->img_curp ?? '' }}
                                        </span>
                                        <i id="vistaPreviaLink" class="fas fa-eye ml-3 text-primary" style="cursor:pointer;" onclick="mostrarVistaPrevia()"></i>
                                    </div>

                                    <input class="file" type="file" style="display: none" name="img_curp" id="img_curp" accept=".pdf, .PDF">
                                </div>

                                <div class="d-flex justify-content-between mt-3 small text-muted">
                                    <span><i class="fas fa-shield-alt"></i> PDF Original</span>
                                    <span>Máx: 1MB</span>
                                </div>

                                <button type="submit" id="btnSiguiente" class="btn btn-verde float-right mt-4 px-5 py-2 shadow-sm" style="border-radius:30px; font-weight:700;">
                                    Siguiente <i class="fas fa-arrow-right ml-2"></i>
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="mt-4 mb-5 p-3 rounded shadow-sm bg-light border-left" style="border-left: 4px solid #7b003a !important;">
                        <div class="row">
                            <div class="col-sm-6">
                                <i class="fab fa-whatsapp text-success mr-1"></i> Soporte: 
                                <a href="javascript:void(0);" onclick="openWhatsApp('526949568140')" class="font-weight-bold text-dark">694 956 8140</a>
                            </div>
                            <div class="col-sm-6 text-sm-right mt-2 mt-sm-0 small">
                                <i class="fas fa-clock mr-1"></i> Lunes a Viernes: 8:30 a.m. a 3:00 p.m.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->

    <div class="modal fade" id="pdfModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 20px; overflow: hidden;">
                <div class="modal-header bg-white d-flex align-items-center justify-content-between p-2 p-md-3">
                    <div class="d-flex align-items-center flex-grow-1" style="min-width: 0;">
                        <div class="me-2 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 35px;">
                            <i class="fa-solid fa-file-pdf" style="color: #7b003a; font-size: 1.5rem;"></i>
                        </div>
                        <div style="min-width: 0; flex: 1;">
                            <h6 class="modal-title fw-bolder mb-0" style="color: #2c3e50; white-space: nowrap; font-size: clamp(0.85rem, 4vw, 1.1rem);">
                                Vista Preliminar<span class="d-none d-sm-inline"> del Archivo</span>
                            </h6>
                            <small class="text-muted d-flex align-items-center" style="font-size: clamp(0.65rem, 3vw, 0.8rem); white-space: nowrap;">
                                <i class="bi bi-shield-check-fill text-success mr-1"></i> 
                                <span class="d-sm-none">Verificado por sistema</span>
                                <span class="d-none d-sm-inline">Documento verificado por el sistema</span>
                            </small>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-verde btn-sm rounded-pill px-3 mr-2" data-dismiss="modal">Confirmar</button>
                        <button type="button" class="btn btn-outline-danger btn-sm rounded-pill px-3" onclick="noQuieroArchivo()">Descartar</button>
                    </div>
                </div>
                <div class="modal-body p-0 bg-dark" style="height: 60vh; overflow-y: auto; -webkit-overflow-scrolling: touch;">
                    <canvas id="pdfCanvas" class="d-block mx-auto" style="max-width: 100%; pointer-events: none;"></canvas>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/jquery.js') }}"></script>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ mix('js/app.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('js/sb-admin.min.js') }}"></script>

    <script>
        function openWhatsApp(phoneNumber) {
            // var phoneNumber = "526941088943"; // Coloca el número de teléfono sin el signo "+"
            var isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
            var url = isMobile ? "https://api.whatsapp.com/send?phone=" : "https://web.whatsapp.com/send?phone=";
    
            window.open(url + phoneNumber, "_blank");
        }
    </script>

    <style>
        /* Estilos base (Computadora) */
        .my-custom-popup-class {
            border-radius: 20px !important;
        }

        .my-custom-button-class {
            border-radius: 50px !important;
            padding: 10px 24px !important;
        }

        /* --- AJUSTES PARA CELULAR --- */
        @media (max-width: 576px) {
            /* Reduce el tamaño del texto de la ventana completa */
            .my-custom-popup-class {
                font-size: 0.85rem !important; /* Texto base más pequeño */
                width: 95% !important;        /* Opcional: que no pegue a las orillas */
                border-radius: 15px !important;
            }

            /* Reduce específicamente el título */
            .my-custom-popup-class .swal2-title {
                font-size: 1.25rem !important;
            }

            /* Reduce el texto del botón */
            .my-custom-button-class {
                font-size: 0.9rem !important;
                border-radius: 20px !important;
                padding: 8px 18px !important;
            }
        }
    </style>
    
    <script>
        // Variable para almacenar el último archivo seleccionado
        var lastSelectedFile = null;
        var renderTask = null;

        function ocultarVistaPreviaLink() {
            var vistaPreviaLink = document.getElementById("vistaPreviaLink");

            // Si no existe el elemento, salimos sin romper
            if (!vistaPreviaLink) {
            // Opcional: log para depurar
            // console.warn('Elemento #vistaPreviaLink no encontrado aún');
            return;
            }

            // Asegúrate de que la variable existe
            if (typeof lastSelectedFile === 'undefined' || lastSelectedFile === null) {
            vistaPreviaLink.style.display = "none";
            spanSiguiente.style.display = "none";
            btnSiguiente.style.display = "none";
            } else {
            vistaPreviaLink.style.display = "inline-block";
            spanSiguiente.style.display = "inline-block";
            btnSiguiente.style.display = "inline-block";

            }
        }


        document.addEventListener("DOMContentLoaded", function () {
    ocultarVistaPreviaLink();
  });
        
        // Función para mostrar la vista previa del PDF en la ventana modal
        function mostrarVistaPreviaPDF(input) {
            const archivo = input.files[0];
            const limiteBytes = 1024 * 1024; // 1 MB

            const esMovil = window.innerWidth <= 768;

            // 2. VALIDACIÓN DE TAMAÑO (BLOQUEO)
            if (archivo.size > limiteBytes) {
               Swal.fire({
                    icon: 'warning',
                    title: 'El archivo no parece ser un CURP válido',
                    position: esMovil ? 'top' : 'center',
                    html: `
                        <div class="swal-text-container">
                            <p>
                                El CURP descargado desde la página oficial normalmente
                                pesa <b>menos de 1 MB</b>.
                            </p>

                            <p>
                                El archivo que intentas subir supera este tamaño, por lo que
                                probablemente:
                            </p>

                            <ul style="text-align: left; margin: 10px 0 15px 20px;">
                                <li>No fue descargado desde el sitio oficial</li>
                                <li>Fue escaneado o convertido desde una foto</li>
                                <li>Fue modificado o combinado con otro(s) archivo(s)</li>
                            </ul>

                            <p style="font-size: 0.9rem; color: #555;">
                                <i class="fas fa-lightbulb" style="color: #ffc107;"></i>
                                <strong>Recomendación:</strong> Descarga nuevamente tu CURP
                                desde el sitio oficial y súbelo directamente sin modificaciones.
                            </p>
                        </div>
                    `,
                    confirmButtonColor: '#7b003a',
                    confirmButtonText: 'Entendido',
                    customClass: {
                        popup: 'my-custom-popup-class',
                        confirmButton: 'my-custom-button-class'
                    }
                });

                // Limpiamos el input y actualizamos el texto
                input.value = ""; 
                var idTexto = "archivo_" + input.id.replace('img_', '');
                if(document.getElementById(idTexto)) {
                    document.getElementById(idTexto).innerText = "Sin archivo seleccionado";
                }

                // IMPORTANTE: Detenemos la función aquí para que NO se abra el modal
                return; 
            }

            if (!archivo.type.includes('pdf')) {
                const esMovil = window.innerWidth <= 768;
                Swal.fire({
                    icon: 'warning',
                    title: 'El archivo debe ser un PDF',
                    position: esMovil ? 'top' : 'center',
                    html: `
                        <div class="swal-text-container">
                            <p>
                                El <b>CURP oficial</b> se descarga únicamente en
                                <b>formato PDF</b>.
                            </p>

                            <p>
                                El archivo que intentas subir <b> no es válido </b>.
                            </p>

                            <hr style="border-top: 1px solid #eee; margin: 15px 0;">

                            <p style="font-size: 0.9rem; color: #555;">
                                <i class="fas fa-info-circle" style="color: #fd0d1563;"></i>
                                <strong>Recomendación:</strong> Descarga tu CURP desde
                                el sitio oficial y súbelo directamente en PDF,
                                sin escanearlo ni tomarle foto.
                            </p>
                        </div>
                    `,
                    confirmButtonColor: '#7b003a',
                    confirmButtonText: 'Entendido',
                    customClass: {
                        popup: 'my-custom-popup-class',
                        confirmButton: 'my-custom-button-class'
                    }
                });
                input.value = "";
                return;
            }

          if (input.files && input.files[0]) {
            var reader = new FileReader();
      
            reader.onload = function (e) {
              var pdfData = e.target.result;
      
              // Cargar el PDF en la ventana modal
              pdfjsLib.getDocument({ data: pdfData }).promise.then(function (pdf) {
                pdf.getPage(1).then(function (page) {
                  var canvas = document.getElementById("pdfCanvas");
                  var context = canvas.getContext("2d");
      
                  var viewport = page.getViewport({ scale: 1 });
                  canvas.width = viewport.width;
                  canvas.height = viewport.height;
      
                  //page.render({ canvasContext: context, viewport: viewport });

                   // Cancelar la operación anterior antes de renderizar una nueva vista previa
                if (renderTask) {
                    renderTask.cancel();
                }

                // Renderizar la página en el canvas y almacenar la tarea de renderización actual
                renderTask = page.render({ canvasContext: context, viewport: viewport });
                
                // Si ocurre algún error al renderizar, manejarlo para evitar excepciones
                renderTask.promise.catch(function(error) {
                    if (!(error instanceof pdfjsLib.RenderingCancelledException)) {
                    console.error('Error al renderizar el PDF:', error);
                    }
                });
      
                  // Mostrar la ventana modal después de cargar el PDF
                  $("#pdfModal").modal("show");

                  lastSelectedFile = input.files[0];
                  ocultarVistaPreviaLink(); // Ajustar visibilidad del elemento
                });
              });
            };
            reader.readAsArrayBuffer(input.files[0]);
          }
        }
      
        // Vincular la función al evento "change" del input de tipo "file"
        document.getElementById("img_curp").addEventListener("change", function () {
          mostrarVistaPreviaPDF(this);
        });
    
        function cerrarVistaPreviaPDF() {
        $("#pdfModal").modal("hide");
      }

      // Función para no cargar el archivo seleccionado
    function noQuieroArchivo() {
        // Restablecer el valor del input de tipo "file" para permitir cargar un nuevo archivo
        var inputElement = document.getElementById("img_curp");
        inputElement.value = ""; // Limpiar el valor para que no mantenga el archivo seleccionado

        // Restablecer la vista previa a "Sin archivo seleccionado"
        var archivoCurp = document.getElementById("archivo_curp");
        archivoCurp.innerText = "Sin archivo seleccionado";

        lastSelectedFile = null;
        ocultarVistaPreviaLink(); // Ajustar visibilidad del elemento

        actualizarIconoVistaPrevia('');

        // Ocultar la ventana modal
        $("#pdfModal").modal("hide");
    }

      function mostrarVistaPrevia() {
        if (lastSelectedFile) {
            var reader = new FileReader();

            reader.onload = function (e) {
                var pdfData = e.target.result;

                // Cargar el PDF en la ventana modal
                pdfjsLib.getDocument({ data: pdfData }).promise.then(function (pdf) {
                    pdf.getPage(1).then(function (page) {
                        var canvas = document.getElementById("pdfCanvas");
                        var context = canvas.getContext("2d");

                        var viewport = page.getViewport({ scale: 1 });
                        canvas.width = viewport.width;
                        canvas.height = viewport.height;

                        page.render({ canvasContext: context, viewport: viewport });

                        // Mostrar la ventana modal con la vista preliminar
                        $("#pdfModal").modal("show");
                    });
                });
            };

            reader.readAsArrayBuffer(lastSelectedFile);
        } else {
            alert("No se ha cargado ningún archivo.");
        }
    }
    </script>
</body>
</html>