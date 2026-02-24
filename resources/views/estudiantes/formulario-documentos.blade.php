<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>OTRO NIVEL | Subir documentación </title>
    
        <!-- Custom fonts for this template-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link
            href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
            rel="stylesheet">
    
        <!-- Custom styles for this template-->
        <link href="{{ asset('css/sb-admin.min.css')}}" rel="stylesheet"> 
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
        <link rel="icon" type="image/png" href="{{ asset('Favicon.png') }}">

        <!--<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>-->

        <!--<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>-->
        <style>
            /* Efecto de sombra roja suave para el botón danger */
            .shadow-danger {
                box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
                transition: all 0.2s ease;
            }
            .shadow-danger:hover {
                box-shadow: 0 6px 15px rgba(220, 53, 69, 0.4);
                transform: translateY(-1px);
            }
        </style>

        <!-- Ventana modal -->
        <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content border-0" style="border-radius: 16px; overflow: hidden; box-shadow: 0 15px 35px rgba(255,0,0,0.1);">
                    
                    <div style="height: 6px; background: linear-gradient(90deg, #dc3545, #ff4d5a);"></div>

                    <div class="modal-body p-5 text-center">
                        <div class="mb-4">
                            <div class="d-inline-flex align-items-center justify-content-center bg-light-danger" style="width: 80px; height: 80px; background-color: #fff5f5; border-radius: 50%;">
                                <i class="fas fa-exclamation-circle text-danger" style="font-size: 3rem;"></i>
                            </div>
                        </div>

                        <h3 class="font-weight-bold mb-3" style="color: #1e293b; letter-spacing: -0.5px;">
                            ¿Estás seguro de regresar?
                        </h3>
                        
                        <p class="text-muted mb-0" style="font-size: 1.1rem; line-height: 1.6;">
                            Al salir de esta sección, los archivos que hayas seleccionado <span class="text-danger font-weight-bolder" style="text-decoration: underline;">se perderán definitivamente</span>.
                        </p>
                    </div>

                    <div class="modal-footer border-0 px-4 pb-4 pt-0 justify-content-center">
                        <button type="button" class="btn btn-light py-2 px-4 mr-2" data-dismiss="modal" style="border-radius: 10px; font-weight: 600; color: #64748b; border: 1px solid #e2e8f0;">
                            No, continuar aquí
                        </button>
                        
                        <a href="{{ route('estudiantes.formulario4') }}" id="btnSalir" class="btn btn-danger py-2 px-4 shadow-danger" style="border-radius: 10px; font-weight: 600; background-color: #dc3545; border: none;">
                            Sí, deseo salir <i class="fas fa-sign-out-alt ml-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <script language="JavaScript" type="text/javascript">
        document.addEventListener("DOMContentLoaded",function(){
            $(function () {
                $('[data-toggle="tooltip"]').tooltip({
                trigger : 'click'
                })
                $('[data-toggle="tooltip"]').mouseleave(function(){
                $(this).tooltip('hide');
                });    
            });
        });

    document.getElementById('btnSalir').addEventListener('click', function(e) {
        // 1. Buscamos el modal y lo ocultamos inmediatamente
        $('#confirmModal').modal('hide');
        mostrarCargando();
    });
        
        // El enlace seguirá su curso natural hacia el href después de ocultar el modal
</script>
    

    <script>
       document.addEventListener("DOMContentLoaded", function() {

            $('#sel_archivo_acta_nac').click(function(){
                mostrarCargando();
                $('#img_acta_nac').trigger('click');
                $('#img_acta_nac').change(function() {
                    var filename = $('#img_acta_nac').val();
                    if (filename.substring(3,11) == 'fakepath')
                    {
                        filename = filename.substring(12);
                    } // Remove c:\fake at beginning from localhost chrome
                    else
                    {
                        filename = "Sin archivo seleccionado";
                        noQuieroArchivo();
                    }
                    $('#archivo_acta_nac').html(filename);
                });
                setTimeout(ocultarCargando, 500);
            });

            $('#sel_archivo_comprobante_dom').click(function(){
                mostrarCargando();
                $('#img_comprobante_dom').trigger('click');
                $('#img_comprobante_dom').change(function() {
                    var filename = $('#img_comprobante_dom').val();
                    if (filename.substring(3,11) == 'fakepath')
                    {
                        filename = filename.substring(12);
                    } // Remove c:\fake at beginning from localhost chrome
                    else
                    {
                        filename = "Sin archivo seleccionado";
                        noQuieroArchivo();
                    }
                    $('#archivo_comprobante_dom').html(filename);
                });
                setTimeout(ocultarCargando, 500);
            });

            $('#sel_archivo_identificacion').click(function(){
                mostrarCargando();
                $('#img_identificacion').trigger('click');
                $('#img_identificacion').change(function() {
                    var filename = $('#img_identificacion').val();
                    if (filename.substring(3,11) == 'fakepath')
                    {
                        filename = filename.substring(12);
                    } // Remove c:\fake at beginning from localhost chrome
                    else
                    {
                        filename = "Sin archivo seleccionado";
                        noQuieroArchivo();
                    }
                    $('#archivo_identificacion').html(filename);
                });
                setTimeout(ocultarCargando, 500);
            });

            $('#sel_archivo_kardex').click(function(){
                mostrarCargando();
                $('#img_kardex').trigger('click');
                $('#img_kardex').change(function() {
                    var filename = $('#img_kardex').val();
                    if (filename.substring(3,11) == 'fakepath')
                    {
                    filename = filename.substring(12);
                } // Remove c:\fake at beginning from localhost chrome
                else
                {
                    filename = "Sin archivo seleccionado";
                    noQuieroArchivo();
                }
                $('#archivo_kardex').html(filename);
                });
                setTimeout(ocultarCargando, 500);
            });

            $('#sel_archivo_constancia').click(function(){
                mostrarCargando();
                $('#img_constancia').trigger('click');
                $('#img_constancia').change(function() {
                    var filename = $('#img_constancia').val();
                    if (filename.substring(3,11) == 'fakepath')
                    {
                        filename = filename.substring(12);
                    } // Remove c:\fake at beginning from localhost chrome
                    else
                    {
                        filename = "Sin archivo seleccionado";
                        noQuieroArchivo();
                    }
                    $('#archivo_constancia').html(filename);
                });
                setTimeout(ocultarCargando, 500);
            });
    });
    </script>

    <script language="JavaScript" type="text/javascript">
        // A function that disables button
        function disableButton() {
            document.getElementById('btnSiguiente').setAttribute("disabled","disabled");
            document.getElementById('btnSiguiente').innerText = "Enviando...";
        }

        document.addEventListener("DOMContentLoaded", function(){
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
    .tooltip-inner {
        max-width: 350px;
        /* If max-width does not work, try using width instead */
        width: 350px; 
        max-height: 120px;
        background-color: #2f4fff;
        text-align: left;
    }

    /* Suavizar bordes del modal */
    #confirmModal .modal-content {
        border-radius: 16px;
    }

    /* Caja del icono de advertencia */
    .icon-box-warning {
        width: 45px;
        height: 45px;
        background-color: #fff9ec;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
    }

    /* Botón de peligro (Aceptar) */
    .btn-danger {
        background-color: var(--rojo-institucional);
        border: none;
        transition: all 0.2s;
    }

    .btn-danger:hover {
        background-color: #c30505;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(234, 6, 6, 0.3);
    }

    .btn-link {
        background-color: var(--verde-boton);
        border: none;
        transition: all 0.2s;
        color: white!important;
}

    /* Botón de cancelar (Link) */
    .btn-link:hover {
        color: var(--verde-boton);
        background-color: #2c4a22ff;
        border-radius: 8px;
    }
</style>

<style>
          :root {
            --rojo-institucional: #7b003a;
            --verde-boton: #00656c;
            --verde-hover: #4a826a;
            --gris-fondo: #f8f9fc;
            --gris-anterior: #6e707e;
            --gris-anterior-hover: #3a3b45;
        }

        body { background-color: white; }

        /* --- UI MODERNA --- */
        .custom-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            background: #fff;
        }

        .section-header-modern {
            background-color: var(--rojo-institucional);
            padding: 1.25rem 1.5rem;
            border-radius: 12px 12px 0 0;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .header-content { display: flex; align-items: center; color: #ffffff; }
        .header-content i { font-size: 1.2rem; margin-right: 15px; opacity: 0.9; }
        .header-text { 
            font-size: 0.95rem; 
            font-weight: 700; 
            text-transform: uppercase; 
            letter-spacing: 2px;
        }
        .header-line { width: 40px; height: 3px; background-color: rgba(255, 255, 255, 0.4); border-radius: 2px; margin-left: 35px; }

        /* Formulario */
        .form-label-custom { font-weight: 600; color: #4b4b4b; margin-bottom: 8px; display: block; }
        .form-control {
            height: 42px !important;
            border-radius: 8px !important;
            border: 1px solid #d1d3e2;
        }
        .form-control:focus {
            border-color: var(--rojo-institucional);
            box-shadow: 0 0 0 0.2rem rgba(123, 0, 58, 0.15);
        }

        /* Banner de Estudiante */
        .student-banner {
            background-color: #f1f3f9;
            color: var(--rojo-institucional);
            padding: 12px;
            border-radius: 8px;
            font-size: 1rem;
            border-left: 4px solid var(--rojo-institucional);
        }

        /* Botones */
        .btn-verde {
            background-color: var(--verde-boton);
            color: white;
            padding: 10px 30px;
            border-radius: 50px;
            font-weight: bold;
            transition: all 0.3s ease;
            border: none;
        }
        .btn-verde:hover { background-color: var(--verde-hover); color: white; }

        .btn-anterior {
            background-color: var(--gris-anterior) !important;
            color: white !important;
            padding: 10px 30px;
            border-radius: 50px;
            font-weight: bold;
            transition: all 0.3s ease;
            border: none;
        }
        .btn-anterior:hover { background-color: var(--gris-anterior-hover) !important; }

        @media (max-width: 576px) {
            .btn-mobile-block { width: 100%; display: block; margin-bottom: 10px; }
        }

        .container-adaptable { padding-bottom: 3rem;  }
        
        @media (max-width: 576px) {
            .container-adaptable { padding-bottom: 18rem !important; }
            .btn-mobile-block { width: 100%; display: block; margin-bottom: 10px; }
            .header-text { font-size: 0.85rem; letter-spacing: 1px; }
            body { min-height: 120vh; }
        }

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
            pointer-events: none; 
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
                
                <div style="min-width: 0; flex: 1; line-height: 1;"> <h6 class="modal-title fw-bolder mb-0" id="pdfModalLabel" 
                        style="color: #2c3e50; letter-spacing: -0.5px; white-space: nowrap; font-size: 1rem;">
                        Vista Preliminar <span class="d-none d-md-inline">del Archivo</span>:
                        <label id="lblNombreDoc" style="font-weight: 900; color: #7b003a; margin-left: 5px;"></label>
                    </h6>
                    
                    <small class="text-muted d-flex align-items-center" 
                        style="font-size: 0.8rem; white-space: nowrap; margin-top: -4px; opacity: 0.8;">
                        <i class="bi bi-shield-check-fill text-success me-1" style="font-size: 0.75rem;"></i> 
                        <span class="d-md-none">Verificado</span>
                        <span class="d-none d-md-inline">Documento verificado por el sistema</span>
                    </small>
                </div>
            </div>

            <div class="d-flex gap-2 justify-content-end align-items-center w-100 w-md-auto">
                <button type="button" class="btn btn-verde btn-sm px-4 py-2 custom-btn-confirm" data-dismiss="modal">
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

</head>
<body>
    <!-- <div class="container">
        <div class="card-body">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="row justify-content-center mb-2">
                        <img src="../img/Logo_y_Escudo.jpg" style="width:70%">
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <form id="my_form" name="my_form" class="contact-form" enctype="multipart/form-data" method="POST" action="{{ route('estudiantes.formulario-documentos.post') }}" enctype="multipart/form-data" novalidate>
                                @csrf
                                <div class="row justify-content-center mb-1">
                                    <div class="text-center">
                                        <a href="/2025-2026">
                                            <img src="../img/logo_programa.jpg" style="width:45%">
                                        </a>
                                    </div>
                                </div>
                                <div class="row justify-content-center mb-1">
                                    <h1 class="h3 mb-2 text-gray-800"> <b>{{ __('FORMULARIO DE REGISTRO') }} </b> </h1>
                                </div>
                                {{-- <div class="row justify-content-center mb-1">
                                    <h3 class="h6 mb-4 text-gray-800"> <i class="fa-solid fa-user"></i> <b>{{ $nombre_completo }} </b> </h3>
                                </div>        --}}
                                <div class="card">
                                    <div class="form-section">
                                        <div class="card-header text-white bg-rojo">
                                            <b>SUBIR DOCUMENTOS</b>
                                        </div>
                                        <br>
                                        <div>
                                            @if (session()->has('message'))
                                            <div class="alert alert-danger mb-0">                        
                                                <button type="button" class="close" data-dismiss="alert">
                                                    &times;
                                                </button>                        
                                                {!! html_entity_decode(session()->get('message')) !!}
                                            </div> 
                                            @endif 
                                        </div>
                                        <div class="card-body">
                                            @if ($errors->any())
                                            <div class="alert alert-danger">
                                                <button type="button" class="close" data-dismiss="alert">
                                                    &times;
                                                </button> 
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                        <li>{!! $error !!}</li>
                                                    @endforeach
                                                </ul>
                                             </div>
                                             @endif
                                             {{-- <div class="col-md-11 alert alert-success text-center mt-n4" style="padding:5px;"> <small> <strong> ¡¡IMPORTANTE!! </strong> Todos los archivos deben estar en formato PDF. </small>
                                             </div> --}}
                                             <div class="row mb-3 justify-content-center" style="background-color: #ebebeb; color: #7b003a;">
                                                Estudiante: &nbsp; <b> {{ $estudiante->nombre . ' ' . $estudiante->primer_apellido . ' ' . $estudiante->segundo_apellido }} </b>
                                            </div>
                                             <div class="row mb-3">
                                                <label class="col-md-6 col-form-label text-md-right">{{ __('Acta de Nacimiento') }} <a data-toggle="tooltip" data-placement="top" data-html="true" title="<b>ACTA CON FORMATO RECIENTE</b> <br> El acta de nacimiento se recomienda que sea de formato reciente y que esté en formato PDF que no pese más de 1MB"><img src="../img/help.jpg" style="width:12px;cursor:pointer;"></a></label>
                                                <div class="col-md-5">
                                                    <button type="button" class="btn btn-verde" id="sel_archivo_acta_nac">Selecciona archivo<small><1M</small> <i class="fas fa-upload"></i></button>
                                                    <div id="archivo_acta_nac" style="font-size:13px">{{$estudiante->img_acta_nac ?? 'Sin archivo seleccionado' }}</div>
                                                </div>
                                                <div id="vistaPreviaActa" name="vistaPreviaActa">
                                                    <a href="#" onclick="mostrarVistaPrevia('img_acta_nac')" data-toggle="tooltip" title="Vista preliminar" style="display: inline-block; line-height: 32px; vertical-align: middle;">
                                                        <b><i class="fa-solid fa-file-pdf text-rojo" style="font-size: 24px;"></i></b>
                                                    </a>
                                                </div>
                                                <input class="archivo-input" type="file" style="display: none" class="form-control" name="img_acta_nac" id="img_acta_nac" accept=".pdf, .PDF" onchange="mostrarVistaPreviaPDF(this)" >
                                            </div>
                                            
                                            <div class="row mb-3">
                                                <label class="col-md-6 col-form-label text-md-right">{{ __('Comprobante Domicilio') }} <a data-toggle="tooltip" data-placement="top" data-html="true" title="<b>COMPROBANTE MÁS RECIENTE DE:</b> <br> 
                                                    - Recibo de CFE o<br>
                                                    - Recibo de JUMAPAC o<br>
                                                    - Recibo de TELMEX<br> En formato PDF que no pese más de 1MB."><img src="../img/help.jpg" style="width:12px;cursor:pointer;"></a></label> 
                                                <div class="col-md-5">
                                                    <button type="button" class="btn btn-verde" id="sel_archivo_comprobante_dom">Selecciona archivo<small><1M</small> <i class="fas fa-upload"></i></button>
                                                    <div id="archivo_comprobante_dom" style="font-size:13px">{{$estudiante->img_comprobante_dom ?? 'Sin archivo seleccionado' }}</div>
                                                </div>
                                                <div id="vistaPreviaComprobante" name="vistaPreviaComprobante">
                                                    <a href="#" onclick="mostrarVistaPrevia('img_comprobante_dom')" data-toggle="tooltip" title="Vista preliminar" style="display: inline-block; line-height: 32px; vertical-align: middle;">
                                                        <b><i class="fa-solid fa-file-pdf text-rojo" style="font-size: 24px;"></i></b>
                                                    </a>
                                                </div>
                                                <input class="archivo-input" type="file" style="display: none" class="form-control" name="img_comprobante_dom" id="img_comprobante_dom" accept=".pdf, .PDF" onchange="mostrarVistaPreviaPDF(this)" >
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-md-6 col-form-label text-md-right">{{ __('Identificación Oficial') }} <a data-toggle="tooltip" data-placement="top" data-html="true" title="<b>INE O ESCOLAR</b> <br> Si no tienes la credencial del INE entonces subirás una credencial escolar en formato PDF que no pese más de 1MB"><img src="../img/help.jpg" style="width:12px;cursor:pointer;"></a></label>
                                                <div class="col-md-5">
                                                    <button type="button" class="btn btn-verde" id="sel_archivo_identificacion">Selecciona archivo<small><1M</small> <i class="fas fa-upload"></i></button>
                                                    <div id="archivo_identificacion" style="font-size:13px">{{$estudiante->img_identificacion ?? 'Sin archivo seleccionado' }}</div>
                                                </div>
                                                <div id="vistaPreviaIdentificacion" name="vistaPreviaIdentificacion">
                                                    <a href="#" onclick="mostrarVistaPrevia('img_identificacion')" data-toggle="tooltip" title="Vista preliminar" style="display: inline-block; line-height: 32px; vertical-align: middle;">
                                                        <b><i class="fa-solid fa-file-pdf text-rojo" style="font-size: 24px;"></i></b>
                                                    </a>
                                                </div>
                                                <input class="archivo-input" type="file" style="display: none" class="form-control" name="img_identificacion" id="img_identificacion" accept=".pdf, .PDF" onchange="mostrarVistaPreviaPDF(this)" >
                                            </div>
 
                                            <div class="row mb-3">
                                                <label class="col-md-6 col-form-label text-md-right">{{ __('Kárdex') }} <a data-toggle="tooltip" data-placement="top" data-html="true" title="<b>CONSTANCIA DE CALIFICACIONES</b> <br> Si apenas vas a entrar al Nivel Superior subirás el certificado de la prepa en formato PDF que no pese más de 1MB"><img src="../img/help.jpg" style="width:12px;cursor:pointer;"></a></label>
                                                <div class="col-md-5">
                                                    <button type="button" class="btn btn-verde" id="sel_archivo_kardex">Selecciona archivo<small><1M</small> <i class="fas fa-upload"></i></button>
                                                    <div id="archivo_kardex" style="font-size:13px">{{$estudiante->img_kardex ?? 'Sin archivo seleccionado' }}</div>
                                                </div>
                                                <div id="vistaPreviaKardex" name="vistaPreviaKardex">
                                                    <a href="#" onclick="mostrarVistaPrevia('img_kardex')" data-toggle="tooltip" title="Vista preliminar" style="display: inline-block; line-height: 32px; vertical-align: middle;">
                                                        <b><i class="fa-solid fa-file-pdf text-rojo" style="font-size: 24px;"></i></b>
                                                    </a>
                                                </div>
                                                <input class="archivo-input" type="file" style="display: none" class="form-control" name="img_kardex" id="img_kardex" accept=".pdf, .PDF" onchange="mostrarVistaPreviaPDF(this)" >
                                            </div>

                                            <div class="row mb-3 justify-content-center">
                                                <div class="col-md-8 text-center" style="background-color: #fce2e2; color: #7b003a; border-radius:20px">
                                                    <label class="col-12 col-form-label">¿Tienes la <strong> Constancia de Estudios </strong> correspondiente al <strong> Ciclo Escolar 2025-2026 </strong>?</label>
                                                    <div class="col-12">
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="constancia-opcion" id="constancia-si" value="si">
                                                            <label class="form-check-label" for="constancia-si">Sí</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="constancia-opcion" id="constancia-no" value="no" checked>
                                                            <label class="form-check-label" for="constancia-no">No</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div id="divConstancia" style="display: none;">
                                                <div class="row mb-3">
                                                    <label class="col-md-6 col-form-label text-md-right">{{ __('Constancia de Estudios') }} <a data-toggle="tooltip" data-placement="top" data-html="true" title="<b>CONSTANCIA DE ESTUDIOS </b> <br> Debe ser un documento que avale que estás inscrito en el periodo de Septiembre de 2025 en adelante. En formato PDF que no pese más de 1MB"><img src="../img/help.jpg" style="width:12px;cursor:pointer;"></a></label>
                                                    <div class="col-md-5">
                                                        <button type="button" class="btn btn-verde" id="sel_archivo_constancia">Selecciona archivo<small><1M</small> <i class="fas fa-upload"></i></button>
                                                        <div id="archivo_constancia" style="font-size:13px">{{$estudiante->img_constancia ?? 'Sin archivo seleccionado' }}</div>
                                                    </div>
                                                    <div id="vistaPreviaConstancia" name="vistaPreviaConstancia">
                                                        <a href="#" onclick="mostrarVistaPrevia('img_constancia')" data-toggle="tooltip" title="Vista preliminar" style="display: inline-block; line-height: 32px; vertical-align: middle;">
                                                            <b><i class="fa-solid fa-file-pdf text-rojo" style="font-size: 24px;"></i></b>
                                                        </a>
                                                    </div>
                                                    <input class="archivo-input" type="file" style="display: none" class="form-control" name="img_constancia" id="img_constancia" accept=".pdf, .PDF" onchange="mostrarVistaPreviaPDF(this)">
                                                </div>
                                            </div>
                                            <div class="alert alert-danger mb-0" id="mensajeError" style="background-color: #dc3545; color: #ffffff; display:none">
                                            </div>
                                            {{-- <div class="row mb-1">
                                                <label class="col-md-6 col-form-label text-md-right">{{ __('Constancia de Estudios') }} <a data-toggle="tooltip" data-placement="top" data-html="true" title="<b>CONSTANCIA DE ESTUDIOS </b> <br> En formato PDF que no pese más de 1MB"><img src="../img/help.jpg" style="width:12px;cursor:pointer;"></a></label>
                                               <div class="col-md-5 alert alert-danger text-justify" style="padding:5px; margin:0"> <small> <i> Este archivo lo subirás después de que hayas enviado todos los documentos previamente solicitados. </i> </small>
                                                </div>
                                                <div class="col-md-5">
                                                    <button type="button" class="btn btn-success" id="sel_archivo_constancia">Selecciona archivo<small><1M</small> <i class="fas fa-upload"></i></button>
                                                    <div id="archivo_constancia" style="font-size:13px">{{$estudiante->img_constancia ?? 'Sin archivo seleccionado' }}</div>
                                                </div>
                                                <input class='file' type="file" style="display: none" class="form-control" name="img_constancia" id="img_constancia" accept="application/pdf" required>
                                            </div>
                                            <input id="constancia_hidden" name="constancia_hidden" type="hidden" value="{{ $estudiante->img_constancia ?? '#constancia#' }}"> --}}
                                            <div class="row mb-1 justify-content-center">
                                                <div class="col-12 text-center">
                                                    <label class="col-form-label mx-1 p-2 col-10" style="font-size: 10pt; text-align: justify; color: #7b003a;">
                                                    * Para escanear los documentos se recomienda <b> CamScanner</b>. <br>
                                                    * Para la manipulación de <b> archivos PDF </b> se recomienda  <b> ILovePDF</b>.
                                                    </label>
                                                </div>
                                            </div>
                                        </div> 
                                    </div>
                          
                                </div>
                                <div class="row mb-1 justify-content-center">
                                    <div class="col-12 text-center">
                                        <label class="col-form-label mx-1 p-2 col-12" style="font-size: 10pt; text-align: justify; background-color: #ebebeb; color: #7b003a;">
                                            <h4 style="text-align: center"><b>¡¡ IMPORTANTE !! <br> Estás en la PRIMER ETAPA DEL PROCESO</b></h4>
                                            <ul>
                                                <li>Si tienes <strong> todos los documentos solicitados en orden </strong> puedes completar el registro. </li>
                                                <li>En caso de <strong> no contar con la CONSTANCIA DE ESTUDIOS correspondiente al Ciclo Escolar 2025-2026</strong> debes subir los demás documentos y ENVIAR la solicitud. Posteriormente procederás a subir el documento faltante para completar el registro. </li>
                                                {{-- <li><strong>Tienes que ENVIAR todos los archivos solicitados:</strong> Es obligatorio subir todos los documentos solicitados.</li> --}}
                                                <li><strong>La sesión NO QUEDA GUARDADA:</strong> Completa y envía el formulario antes de cerrar esta página.</li>
                                                <li><strong>Formulario enviado con éxito:</strong> Verás un mensaje de confirmación cuando el envío sea exitoso.</li>
                                            </ul>
                                        </label>
                                    </div>
                                </div>
                                
                                <a href="#" class="next btn btn-verde float-left mt-2" data-toggle="modal" data-target="#confirmModal">Anterior</a>
                                <button type="submit" id="btnSiguiente" name="btnSiguiente" class="next btn btn-verde float-right mt-2" disabled>Enviar</button>                                
                            </form>
                        </div>
                    </div>
                    <div class="row mb-1 justify-content-center">
                        <div class="col-12 text-center">
                            <label class="col-form-label mx-1 p-2 col-12" style="font-size: 10pt; text-align: justify; background-color: #ebebeb; color: #7b003a;">
                                * <b> <i class="fab fa-whatsapp"></i> <a href="javascript:void(0);" onclick="openWhatsApp()" style="color: inherit; text-decoration: none;">6692295855</a></b> para soporte técnico y dudas sobre el registro en línea. <br>
                                * Mayores informes en la presidencia municipal de <b> Lunes a Viernes de 8:30 a.m. a 3 p.m. </b>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
    <div class="container py-5 container-adaptable">
        <div class="row justify-content-center">
            <div class="col-md-9">            
                <div class="text-center mb-4">
                    <img src="../img/Logo_y_Escudo.jpg" class="img-fluid mb-3" style="width: 100%; max-width: 450px; height: auto;">
                    <div class="mb-4">
                        <a href="/2025-2026">
                            <img src="../img/logo_programa.jpg" class="img-fluid" style="max-width: 280px;">
                        </a>
                    </div>
                    <h1 class="h3 font-weight-bold text-dark">{{ __('FORMULARIO DE REGISTRO') }}</h1>
                </div>

                <div class="custom-card mb-4">
                    <div class="section-header-modern">
                        <div class="header-content">
                            <i class="fas fa-file-upload"></i>
                            <span class="header-text">Subir Documentos</span>
                        </div>
                        <div class="header-line"></div>
                    </div>

                    <div class="card-body p-4">
                        <div class="student-banner mb-4 text-center">
                            <i class="fas fa-user-graduate mr-2"></i> Estudiante: <b>{{ $estudiante->nombre . ' ' . $estudiante->primer_apellido . ' ' . $estudiante->segundo_apellido }}</b>
                        </div>

                        @if (session()->has('message'))
                            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                                {!! html_entity_decode(session()->get('message')) !!}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{!! $error !!}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        <style>
                            /* Contenedor Principal */
                            .modern-header-docs {
                                position: relative;
                                padding-bottom: 10px;
                            }

                            /* Caja del Icono Izquierdo */
                            .icon-box-tech {
                                background: rgba(123, 0, 58, 0.1);
                                color: #7b003a;
                                width: 45px;
                                height: 45px;
                                display: flex;
                                align-items: center;
                                justify-content: center;
                                border-radius: 12px;
                                font-size: 1.2rem;
                                border: 1px solid rgba(123, 0, 58, 0.2);
                            }

                            /* Títulos */
                            .tech-title {
                                font-weight: 800;
                                text-transform: uppercase;
                                letter-spacing: 1px;
                                color: #2c3e50;
                                font-size: 1.1rem;
                            }

                            .tech-subtitle {
                                font-size: 0.75rem;
                                letter-spacing: 0.5px;
                            }

                            /* Badges (Etiquetas de restricción) */
                            .badge-tech {
                                background: #f8f9fa;
                                border: 1px solid #e3e6f0;
                                color: #5a5c69;
                                padding: 4px 12px;
                                border-radius: 50px;
                                font-size: 0.7rem;
                                font-weight: 700;
                                margin-left: 8px;
                                box-shadow: 0 2px 4px rgba(0,0,0,0.05);
                                text-transform: uppercase;
                            }

                            /* Línea de Gradiente Tecnológica */
                            .tech-line-gradient {
                                height: 3px;
                                width: 100%;
                                background: linear-gradient(to right, #7b003a 0%, #00656c 50%, transparent 100%);
                                margin-top: 15px;
                                border-radius: 2px;
                                opacity: 0.8;
                            }

                            /* Ajuste para Móviles */
                            @media (max-width: 576px) {
                                .tech-badges {
                                    margin-top: 12px;
                                    width: 100%;
                                    justify-content: flex-start;
                                }
                                .badge-tech {
                                    margin-left: 0;
                                    margin-right: 8px;
                                }
                            }

                            /* Contenedor con efecto de profundidad */
                            .tech-notice-container {
                                perspective: 1000px;
                            }

                            .tech-notice-glass {
                                background: rgba(255, 255, 255, 0.9);
                                border: 1px solid #e0e0e0;
                                border-left: 6px solid #7b003a;
                                border-radius: 16px;
                                padding: 20px;
                                position: relative;
                                overflow: hidden;
                                box-shadow: 0 10px 30px rgba(123, 0, 58, 0.08);
                            }

                            /* Cabecera con Icono Animado */
                            .tech-notice-header {
                                display: flex;
                                align-items: center;
                                margin-bottom: 15px;
                            }

                            .tech-notice-title {
                                color: #7b003a;
                                font-weight: 800;
                                text-transform: uppercase;
                                font-size: 0.95rem;
                                letter-spacing: 1.5px;
                                margin: 0;
                            }

                            .pulse-icon {
                                background: #7b003a;
                                color: white;
                                width: 32px;
                                height: 32px;
                                border-radius: 8px;
                                display: flex;
                                align-items: center;
                                justify-content: center;
                                margin-right: 12px;
                                animation: tech-pulse 2s infinite;
                            }

                            /* Grid de Requisitos */
                            .requirement-grid {
                                display: grid;
                                gap: 12px;
                            }

                            .req-item {
                                display: flex;
                                align-items: flex-start;
                                padding: 10px;
                                border-radius: 10px;
                                background: rgba(0, 0, 0, 0.03);
                                font-size: 0.88rem;
                            }

                            .req-item i {
                                margin-top: 3px;
                                margin-right: 12px;
                                font-size: 1.1rem;
                            }

                            .req-item.mandatory i { color: #00656c; }
                            .req-item.warning i { color: #7b003a; }

                            .req-item strong {
                                display: block;
                                color: #333;
                                font-size: 0.85rem;
                            }

                            .req-item span {
                                color: #666;
                            }

                            /* Animación de Pulso */
                            @keyframes tech-pulse {
                                0% { box-shadow: 0 0 0 0 rgba(123, 0, 58, 0.4); }
                                70% { box-shadow: 0 0 0 10px rgba(123, 0, 58, 0); }
                                100% { box-shadow: 0 0 0 0 rgba(123, 0, 58, 0); }
                            }            
                        </style>

                        <form id="my_form" method="POST" action="{{ route('estudiantes.formulario-documentos.post') }}" enctype="multipart/form-data" novalidate>
                            @csrf
                            <div class="container mt-4">
                                <div class="row">
                                    <div class="col-12">
                                       <div class="modern-header-docs mb-4">
                                            <div class="d-flex align-items-center justify-content-between flex-wrap">
                                                <div class="d-flex align-items-center">
                                                    <div class="icon-box-tech mr-3">
                                                        <i class="fas fa-folder-open"></i>
                                                    </div>
                                                    <div>
                                                        <h5 class="mb-0 tech-title">Documentación Requerida</h5>
                                                        <p class="text-muted small mb-0 tech-subtitle">Expediente Digital del Estudiante</p>
                                                    </div>
                                                </div>
                                                <div class="tech-badges d-flex align-items-center">
                                                    <span class="badge-tech"><i class="far fa-file-pdf mr-1"></i> PDF</span>
                                                    <span class="badge-tech"><i class="fas fa-file-invoice mr-1"></i> 1 PÁGINA</span>
                                                    <span class="badge-tech"><i class="fas fa-weight-hanging mr-1"></i> Máx. 1MB</span>
                                                </div>
                                            </div>
                                            <div class="tech-line-gradient"></div>
                                        </div>
                                        
                                        <div class="upload-card mb-3 p-3 shadow-sm border rounded">
                                            <div class="row align-items-center">
                                                <div class="col-md-5">
                                                    <label class="font-weight-bold mb-0 text-dark">{{ __('Acta de Nacimiento') }}</label>
                                                    <p class="text-muted small mb-1">Formato reciente y legible.</p>
                                                </div>
                                                <div class="col-md-5 text-center px-md-4"> 
                                                    <button type="button" class="btn btn-outline-verde w-100 mb-1" id="sel_archivo_acta_nac">
                                                        <i class="fas fa-file-upload mr-1"></i> Seleccionar archivo
                                                    </button>
                                                    <div id="archivo_acta_nac" class="text-truncate small text-secondary">
                                                        {{$estudiante->img_acta_nac ?? 'Sin archivo seleccionado' }}
                                                    </div>
                                                </div>
                                                <div class="col-md-2 text-center border-left pl-md-4">
                                                    <div id="vistaPreviaActa" style="display: none;">
                                                        <a href="#" onclick="mostrarVistaPrevia('img_acta_nac')" class="pdf-preview" title="Vista preliminar">
                                                            <i class="fa-solid fa-file-pdf text-rojo"></i>
                                                            <span class="d-block tiny-text">VER PDF</span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <input class="archivo-input" type="file" style="display: none" name="img_acta_nac" id="img_acta_nac" accept=".pdf, .PDF" onchange="mostrarVistaPreviaPDF(this)">
                                        </div>

                                        <div class="upload-card mb-3 p-3 shadow-sm border rounded">
                                            <div class="row align-items-center">
                                                <div class="col-md-5">
                                                    <label class="font-weight-bold mb-0 text-dark">{{ __('Comprobante Domicilio') }}</label>
                                                    <p class="text-muted small mb-1">Recibo de CFE, JUMAPAC o TELMEX reciente (Concordia, Sin.).</p>
                                                </div>
                                                <div class="col-md-5 text-center px-md-4">
                                                    <button type="button" class="btn btn-outline-verde w-100 mb-1" id="sel_archivo_comprobante_dom">
                                                        <i class="fas fa-file-upload mr-1"></i> Seleccionar archivo
                                                    </button>
                                                    <div id="archivo_comprobante_dom" class="text-truncate small text-secondary">
                                                        {{$estudiante->img_comprobante_dom ?? 'Sin archivo seleccionado' }}
                                                    </div>
                                                </div>
                                                <div class="col-md-2 text-center border-left pl-md-4">
                                                    <div id="vistaPreviaComprobante" style="display: none;">
                                                        <a href="#" onclick="mostrarVistaPrevia('img_comprobante_dom')" class="pdf-preview" title="Vista preliminar">
                                                            <i class="fa-solid fa-file-pdf text-rojo"></i>
                                                            <span class="d-block tiny-text">VER PDF</span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <input class="archivo-input" type="file" style="display: none" name="img_comprobante_dom" id="img_comprobante_dom" accept=".pdf, .PDF" onchange="mostrarVistaPreviaPDF(this)">
                                        </div>

                                        <div class="upload-card mb-3 p-3 shadow-sm border rounded">
                                            <div class="row align-items-center">
                                                <div class="col-md-5">
                                                    <label class="font-weight-bold mb-0 text-dark">{{ __('Identificación Oficial') }}</label>
                                                    <p class="text-muted small mb-1">Credencial del INE (Concordia, Sin.).</p>
                                                </div>
                                                <div class="col-md-5 text-center px-md-4">
                                                    <button type="button" class="btn btn-outline-verde w-100 mb-1" id="sel_archivo_identificacion">
                                                        <i class="fas fa-file-upload mr-1"></i> Seleccionar archivo
                                                    </button>
                                                    <div id="archivo_identificacion" class="text-truncate small text-secondary">
                                                        {{$estudiante->img_identificacion ?? 'Sin archivo seleccionado' }}
                                                    </div>
                                                </div>
                                                <div class="col-md-2 text-center border-left pl-md-4">
                                                    <div id="vistaPreviaIdentificacion" style="display: none;">
                                                        <a href="#" onclick="mostrarVistaPrevia('img_identificacion')" class="pdf-preview" title="Vista preliminar">
                                                            <i class="fa-solid fa-file-pdf text-rojo"></i>
                                                            <span class="d-block tiny-text">VER PDF</span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <input class="archivo-input" type="file" style="display: none" name="img_identificacion" id="img_identificacion" accept=".pdf, .PDF" onchange="mostrarVistaPreviaPDF(this)">
                                        </div>

                                        <div class="upload-card mb-3 p-3 shadow-sm border rounded">
                                            <div class="row align-items-center">
                                                <div class="col-md-5">
                                                    <label class="font-weight-bold mb-0 text-dark">{{ __('Kárdex') }}</label>
                                                    <p class="text-muted small mb-1">Constancia de calificaciones (Promedio >= 8.0).</p>
                                                </div>
                                                <div class="col-md-5 text-center px-md-4">
                                                    <button type="button" class="btn btn-outline-verde w-100 mb-1" id="sel_archivo_kardex">
                                                        <i class="fas fa-file-upload mr-1"></i> Seleccionar archivo
                                                    </button>
                                                    <div id="archivo_kardex" class="text-truncate small text-secondary">
                                                        {{$estudiante->img_kardex ?? 'Sin archivo seleccionado' }}
                                                    </div>
                                                </div>
                                                <div class="col-md-2 text-center border-left pl-md-4">
                                                    <div id="vistaPreviaKardex" style="display: none;">
                                                        <a href="#" onclick="mostrarVistaPrevia('img_kardex')" class="pdf-preview" title="Vista preliminar">
                                                            <i class="fa-solid fa-file-pdf text-rojo"></i>
                                                            <span class="d-block tiny-text">VER PDF</span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <input class="archivo-input" type="file" style="display: none" name="img_kardex" id="img_kardex" accept=".pdf, .PDF" onchange="mostrarVistaPreviaPDF(this)">
                                        </div>

                                        <div id="divConstancia">
                                            <div class="upload-card mb-3 p-3 shadow-sm border rounded">
                                                <div class="row align-items-center">
                                                    <div class="col-md-5">
                                                        <label class="font-weight-bold mb-0 text-dark">{{ __('Constancia de Estudios') }}</label>
                                                        <p class="text-muted small mb-1">Documento vigente del periodo actual.</p>
                                                    </div>
                                                    <div class="col-md-5 text-center px-md-4">
                                                        <button type="button" class="btn btn-outline-verde w-100 mb-1" id="sel_archivo_constancia">
                                                            <i class="fas fa-file-upload mr-1"></i> Seleccionar archivo
                                                        </button>
                                                        <div id="archivo_constancia" class="text-truncate small text-secondary">
                                                            {{$estudiante->img_constancia ?? 'Sin archivo seleccionado' }}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 text-center border-left pl-md-4">
                                                        <div id="vistaPreviaConstancia" style="display: none;">
                                                            <a href="#" onclick="mostrarVistaPrevia('img_constancia')" class="pdf-preview" title="Vista preliminar">
                                                                <i class="fa-solid fa-file-pdf text-rojo"></i>
                                                                <span class="d-block tiny-text">VER PDF</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <input class="archivo-input" type="file" style="display: none" name="img_constancia" id="img_constancia" accept=".pdf, .PDF" onchange="mostrarVistaPreviaPDF(this)">
                                            </div>
                                        </div>

                                        <div class="alert alert-danger mt-3" id="mensajeError" style="display:none; border-radius: 8px;">
                                            <i class="fas fa-exclamation-triangle mr-2"></i> Error en la carga de archivos.
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <style>
                                /* Tarjeta de carga */
                                .upload-card {
                                    background-color: #ffffff;
                                    transition: transform 0.2s ease, border-color 0.2s ease;
                                    border: 1px solid #dee2e6 !important;
                                }

                                .upload-card:hover {
                                    border-color: #28a745 !important;
                                    background-color: #f8fff9;
                                }

                                /* Botón personalizado estilo "Verde" */
                                .btn-outline-verde {
                                    color: #00656c;
                                    border: 2px solid #00656c;
                                    background-color: transparent;
                                    font-weight: bold;
                                    border-radius: 16px;
                                    padding: 8px;
                                }

                                .btn-outline-verde:hover {
                                    background-color: #00656c;
                                    color: #ffffff;
                                    border-style: solid;
                                }

                                /* Icono de PDF y Previsualización */
                                .pdf-preview {
                                    text-decoration: none !important;
                                    transition: opacity 0.2s;
                                }

                                .pdf-preview:hover {
                                    opacity: 0.7;
                                }

                                .pdf-preview i {
                                    font-size: 28px;
                                }

                                .tiny-text {
                                    font-size: 10px;
                                    font-weight: bold;
                                    color: #6c757d;
                                    margin-top: 4px;
                                }

                                .text-rojo { color: #dc3545; }

                                /* Separador en móviles */
                                @media (max-width: 768px) {
                                    .border-left {
                                        border-left: none !important;
                                        border-top: 1px solid #dee2e6;
                                        margin-top: 15px;
                                        padding-top: 10px;
                                    }
                                }
                            </style>

                            <div class="text-center mb-4">
                                <small class="text-muted italic">
                                    * Recomendamos <b>CamScanner</b> para escanear e <b>ILovePDF</b> para comprimir tus archivos.
                                </small>
                            </div>

                            <div class="tech-notice-container mb-4">
                                <div class="tech-notice-glass">
                                    <div class="tech-notice-header">
                                        <div class="pulse-icon">
                                            <i class="fas fa-shield-alt"></i>
                                        </div>
                                        <h5 class="tech-notice-title">Protocolo de Registro</h5>
                                    </div>
                                    
                                    <div class="tech-notice-body">
                                        <div class="requirement-grid">
                                            <div class="req-item mandatory">
                                                <i class="fas fa-check-double"></i>
                                                <div>
                                                    <strong>Requisitos Obligatorios:</strong>
                                                    <span>Todos los documentos deben ser cargados para proceder.</span>
                                                </div>
                                            </div>

                                            <div class="req-item warning">
                                                <i class="fas fa-hourglass-start"></i>
                                                <div>
                                                    <strong>Sesión Temporal:</strong>
                                                    <span>El progreso no se guardará. Finaliza el proceso ahora.</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                                    
                                </div>
                            </div>

                            <div class="d-flex flex-column flex-sm-row justify-content-between mt-4">
                                <a href="#" class="btn btn-anterior btn-mobile-block mb-2" data-toggle="modal" data-target="#confirmModal">
                                    <i class="fas fa-chevron-left mr-2"></i> Anterior
                                </a>
                                <button type="submit" id="btnSiguiente" class="btn btn-verde btn-mobile-block mb-2" disabled>
                                    Enviar Solicitud <i class="fas fa-paper-plane ml-2"></i>
                                </button>
                            </div>
                        </form>
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
            </div>
        </div>
    </div>

    <script>
        function openWhatsApp(phoneNumber) {
            //var phoneNumber = "526692295855"; // Coloca el número de teléfono sin el signo "+"
            var isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
            var url = isMobile ? "https://api.whatsapp.com/send?phone=" : "https://web.whatsapp.com/send?phone=";
    
            window.open(url + phoneNumber, "_blank");
        }
    </script>

    <script src="{{ asset('js/jquery.js') }}"></script>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ mix('js/app.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('js/sb-admin.min.js') }}"></script>

    
<script>
    function validacion() {
    var archivosCargados = 0;
    var archivosValidos = true;
    var mensajeError = '';

    // Obtener la respuesta del usuario (Asegúrate de que este valor sea dinámico según tu lógica)
    const tieneConstancia = true; 
    const archivosRequeridos = tieneConstancia ? 5 : 4;

    $(".archivo-input").each(function() {
        var archivo = $(this).prop("files")[0];

        if (!tieneConstancia && this.id === 'img_constancia') {
            return; 
        }

        if (archivo) {
            archivosCargados++;
            // Validación de 1MB
            if (archivo.size > 1024 * 1024) { 
                archivosValidos = false;
                mensajeError += 'El archivo <b>"' + archivo.name + '"</b> excede 1MB. <br>';
                
                // OPCIONAL: Limpiar el input para obligar a seleccionar otro
                $(this).val(''); 
            }
        }
    });

    // --- LOGICA DE ALERTAS Y BOTONES ---

    if (archivosValidos && archivosCargados === archivosRequeridos) {
        // Todo perfecto
        $('#btnSiguiente').prop("disabled", false);
        $("#mensajeError").hide();
    } else {
        // Deshabilitar botón si algo falla
        $('#btnSiguiente').prop("disabled", true);

        // Si hay un error de TAMAÑO, lanzamos el Sweet Alert
        if (!archivosValidos) {
            Swal.fire({
                icon: 'error',
                title: 'Archivos demasiado pesados',
                html: mensajeError, // Usamos 'html' para que se vea el <b>
                confirmButtonColor: '#28a745',
                confirmButtonText: 'Entendido'
            });
            
            // También lo mostramos en el div de texto por si acaso
            $("#mensajeError").html(mensajeError).show();
        } else {
            // Si el error es solo que faltan archivos, ocultamos el mensaje de peso
            $("#mensajeError").hide();
        }
    }
}

    $(document).ready(function() {
        $(".archivo-input").on("change", validacion);
    });

        document.addEventListener('DOMContentLoaded', function() {
        const divConstancia = document.getElementById('divConstancia');
        const radioSi = document.getElementById('constancia-si');
        const radioNo = document.getElementById('constancia-no');

        // Muestra u oculta el div de la constancia
        function toggleConstanciaDiv() {
            if (radioSi.checked) {
                divConstancia.style.display = 'block';
            } else {
                divConstancia.style.display = 'none';
                validacion();
                if (currentInputId)
                { 
                    var filename = "Sin archivo seleccionado";
                    noQuieroArchivo();
                    $('#archivo_constancia').html(filename);
                }
            }
        }

        // Asigna el evento 'change' a los botones de radio
        // radioSi.addEventListener('change', toggleConstanciaDiv);
        // radioNo.addEventListener('change', toggleConstanciaDiv);

        // Llama a la función al cargar la página para reflejar el estado inicial
        // toggleConstanciaDiv();
    });
</script>

    
{{-- <script>
    $(document).ready(function() {
        $(".archivo-input").on("change", function() {
            var archivosCargados = 0;
            var archivosValidos = true;
            var mensajeError = '';

            $(".archivo-input").each(function() {
                var archivo = $(this).prop("files")[0];

                if (archivo) {
                    archivosCargados++;
                    if (archivo.size > 1024 * 1024) { // Tamaño máximo de 1 MB (en bytes)
                        archivosValidos = false;
                        mensajeError = mensajeError + 'El archivo "' + archivo.name + '" excede 1MB. ';
                    }
                }
            });
            if (archivosValidos && archivosCargados === 4) {
                document.getElementById('btnSiguiente').removeAttribute("disabled");
                document.getElementById('btnSiguiente').innerText = "Enviar";
                $("#mensajeError").hide(); // Ocultar el contenido del mensaje de error
            } else {
                document.getElementById('btnSiguiente').setAttribute("disabled", "disabled");
                document.getElementById('btnSiguiente').innerText = "Siguiente";
                $("#mensajeError").text(mensajeError); // Mostrar mensaje de error

                if (mensajeError) {
                    $("#mensajeError").show(); // Mostrar el div si hay mensajes de error
                } else {
                    $("#mensajeError").hide(); // Ocultar el div si no hay mensajes de error
                }
            }
        });
    });
</script> --}}

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
        // 1. Lógica para el botón "Siguiente" usando el ID del formulario
        var formulario = document.getElementById('my_form');
        
        if (formulario) {
            formulario.addEventListener('submit', function() {
                // checkValidity valida los campos "required", "min", "max", etc.
                if (this.checkValidity()) {
                    mostrarCargando();
                    
                    // Opcional: Deshabilitar el botón para evitar clics extra
                    var btn = document.getElementById('btnSiguiente');
                    if (btn) {
                        btn.disabled = true;
                        btn.innerHTML = 'Cargando... <i class="fas fa-spinner fa-spin"></i>';
                    }
                }
            });
        }
       
    });
</script>

    <script>
        var lastSelectedFile = null;
        var renderTask = null;
        var currentInputId = null; // Variable para almacenar el ID del input actual

        function ocultarVistaPreviaLink(currentInputId) {
            
            if (currentInputId == 'img_acta_nac') var vistaPreviaLink = document.getElementById("vistaPreviaActa");
            else if (currentInputId == 'img_comprobante_dom') var vistaPreviaLink = document.getElementById("vistaPreviaComprobante");
            else if (currentInputId == 'img_identificacion') var vistaPreviaLink = document.getElementById("vistaPreviaIdentificacion");
            else if (currentInputId == 'img_kardex') var vistaPreviaLink = document.getElementById("vistaPreviaKardex");
            else if (currentInputId == 'img_constancia') var vistaPreviaLink = document.getElementById("vistaPreviaConstancia");

            // var vistaPreviaLink = document.getElementById(fileType);
            if (lastSelectedFile === null) {
                vistaPreviaLink.style.display = "none";
            } else {
                vistaPreviaLink.style.display = "inline-block";
            }
        }

        document.addEventListener("DOMContentLoaded", function () {
            ocultarVistaPreviaLink("img_acta_nac");
            ocultarVistaPreviaLink("img_comprobante_dom");
            ocultarVistaPreviaLink("img_identificacion");
            ocultarVistaPreviaLink("img_kardex");
            ocultarVistaPreviaLink("img_constancia");
        });
        
        function mostrarVistaPreviaPDF(input) {
            if (!input.files || !input.files[0]) return;

            const archivo = input.files[0];
            const limiteBytes = 1024 * 1024; // 1 MB

            const esMovil = window.innerWidth <= 768;

            // 2. VALIDACIÓN DE TAMAÑO (BLOQUEO)
            if (archivo.size > limiteBytes) {
               Swal.fire({
                    icon: 'error',
                    title: '¡Vaya! El archivo es muy pesado',
                    position: esMovil ? 'top' : 'center',
                    html: `
                        <div class="swal-text-container">
                            <p>El límite es de <b>1MB</b> para asegurar una carga rápida. Tu archivo actual supera este tamaño.</p>
                            <hr style="border-top: 1px solid #eee; margin: 15px 0;">
                            <p style="font-size: 0.9rem; color: #555;">
                                <i class="fas fa-lightbulb" style="color: #ffc107;"></i> 
                                <strong>Sugerencia:</strong> Prueba comprimiéndolo en sitios como <b>IlovePDF</b> antes de subirlo.
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
                currentInputId = input.id;
                input.value = ""; 
                var idTexto = "archivo_" + input.id.replace('img_', '');
                if(document.getElementById(idTexto)) {
                    document.getElementById(idTexto).innerText = "Sin archivo seleccionado";
                }

                // IMPORTANTE: Detenemos la función aquí para que NO se abra el modal
                return; 
            }

            // 3. Validar tipo de archivo
            if (!archivo.type.includes('pdf')) {
                const esMovil = window.innerWidth <= 768;
                Swal.fire({
                    icon: 'error',
                    title: 'Archivo no permitido',
                    position: esMovil ? 'top' : 'center',
                    html: `
                        <div class="swal-text-container">
                            <p>Por favor, selecciona un documento en formato <b>PDF</b>.</p>
                            <hr style="border-top: 1px solid #eee; margin: 15px 0;">
                            <p style="font-size: 0.9rem; color: #555;">
                                <i class="fas fa-info-circle" style="color: #17a2b8;"></i> 
                                <strong>¿Tienes una foto?</strong> Si tu archivo es una imagen, puedes convertirla a PDF usando <b>IlovePDF</b> o la opción "Imprimir a PDF" de tu celular.
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

                currentInputId = input.id;
                input.value = "";
                return;
            }

            mostrarCargando();

             // Validar si el archivo seleccionado es un PDF
            if (!input.files[0].type.includes('pdf')) {
                var currentInput = input.name;

                if (currentInput == 'img_acta_nac') var archivoElement = document.getElementById("archivo_acta_nac");
                else if (currentInput == 'img_comprobante_dom') var archivoElement = document.getElementById("archivo_comprobante_dom");
                else if (currentInput == 'img_identificacion') var archivoElement = document.getElementById("archivo_identificacion");
                else if (currentInput == 'img_kardex') var archivoElement = document.getElementById("archivo_kardex");
                else if (currentInput == 'img_constancia') var archivoElement = document.getElementById("archivo_constancia");
                
                archivoElement.innerText = "Sin archivo seleccionado";
                currentInputId = input.id;
                noQuieroArchivo();
                ocultarCargando();


                // Mostrar un mensaje de error o alerta al usuario
                alert('Por favor, selecciona un archivo PDF.');
                
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

                    // Cancelar la operación anterior antes de renderizar una nueva vista previa
                    if (renderTask) {
                        renderTask.cancel();
                    }

                    // Renderizar la página en el canvas y almacenar la tarea de renderización actual
                    renderTask = page.render({ canvasContext: context, viewport: viewport });

                    // Si ocurre algún error al renderizar, manejarlo para evitar excepciones
                    renderTask.promise.catch(function (error) {
                        if (!(error instanceof pdfjsLib.RenderingCancelledException)) {
                        console.error('Error al renderizar el PDF:', error);
                        }
                    });

                    var nombreDoc = input.name;
                    var label = document.getElementById("lblNombreDoc");
                    // Creamos un diccionario de nombres
                    const nombresDocumentos = {
                        'img_acta_nac': 'Acta de Nacimiento',
                        'img_comprobante_dom': 'Comprobante de Domicilio',
                        'img_identificacion': 'Identificación Oficial',
                        'img_kardex': 'Kárdex',
                        'img_constancia': 'Constancia de Estudios',
                        'img_curp': 'CURP'
                    };

                    // Asignamos el nombre. Si no existe en el mapa, ponemos un texto por defecto.
                    label.innerText = nombresDocumentos[nombreDoc] || 'Documento no identificado';

                    ocultarCargando();

                    // Mostrar la ventana modal después de cargar el PDF
                    $("#pdfModal").modal("show");

                    currentInputId = input.id;
                    lastSelectedFile = input.files[0];

                    ocultarVistaPreviaLink(currentInputId); // Ajustar visibilidad del elemento
                    });
                });
                };
                reader.readAsArrayBuffer(input.files[0]);
            }
        }
       
    
        function cerrarVistaPreviaPDF() {
            $("#pdfModal").modal("hide");
        }

        function noQuieroArchivo() {
            // Restablecer el valor del input de tipo "file" para permitir cargar un nuevo archivo
            var inputElement = document.getElementById(currentInputId);

            if (inputElement) {
                inputElement.value = ""; // Ahora solo lo hace si el elemento existe
            } 

            // Restablecer la vista previa a "Sin archivo seleccionado"
            if (currentInputId == 'img_acta_nac') var archivoElement = document.getElementById("archivo_acta_nac");
            else if (currentInputId == 'img_comprobante_dom') var archivoElement = document.getElementById("archivo_comprobante_dom");
            else if (currentInputId == 'img_identificacion') var archivoElement = document.getElementById("archivo_identificacion");
            else if (currentInputId == 'img_kardex') var archivoElement = document.getElementById("archivo_kardex");
            else if (currentInputId == 'img_constancia') var archivoElement = document.getElementById("archivo_constancia");
            
            if (archivoElement) {
                archivoElement.innerText = "Sin archivo seleccionado";
            } 

            lastSelectedFile = null;

            if (currentInputId)
            {
                ocultarVistaPreviaLink(currentInputId); // Ajustar visibilidad del elemento
                validacion();
            }


            // Ocultar la ventana modal
            $("#pdfModal").modal("hide");
        }

        function mostrarVistaPrevia(fileInput) {
            var input = document.getElementById(fileInput);
            var nombreDoc = input.name;
            var label = document.getElementById("lblNombreDoc");

            // Creamos un diccionario de nombres
            const nombresDocumentos = {
                'img_acta_nac': 'Acta de Nacimiento',
                'img_comprobante_dom': 'Comprobante de Domicilio',
                'img_identificacion': 'Identificación Oficial',
                'img_kardex': 'Kárdex',
                'img_constancia': 'Constancia de Estudios',
                'img_curp': 'CURP'
            };

            // Asignamos el nombre. Si no existe en el mapa, ponemos un texto por defecto.
            label.innerText = nombresDocumentos[nombreDoc] || 'Documento no identificado';

            selectedFile = input.files[0];

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

                if (lastSelectedFile == selectedFile) reader.readAsArrayBuffer(lastSelectedFile);
                else reader.readAsArrayBuffer(selectedFile);
            } else {
                alert("No se ha cargado ningún archivo.");
            }
        }

    </script>
    
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.min.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
        // IMPORTANTE: usa la MISMA versión para el worker
        pdfjsLib.GlobalWorkerOptions.workerSrc =
            "https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.worker.min.js";
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