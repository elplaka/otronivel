<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>ALIVIAN4TE - Por tiempos mejores </title>
    
        <!-- Custom fonts for this template-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link
            href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
            rel="stylesheet">
    
        <!-- Custom styles for this template-->
        <link href="{{ asset('css/sb-admin.min.css')}}" rel="stylesheet">  
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.min.js"></script>

<!-- Ventana modal -->
<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="confirmModalLabel">Confirmación</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          Si vas a la sección anterior se perderán los archivos cargados. ¿Deseas continuar?
        </div>
        <div class="modal-footer">
          <a href="{{ route('estudiantes.formulario4') }}" class="btn btn-primary">Aceptar</a>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        </div>
      </div>
    </div>
  </div>

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
    $(document).ready( function() {

        $('#sel_archivo_acta_nac').click(function(){
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
        });

        $('#sel_archivo_comprobante_dom').click(function(){
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
        });

        $('#sel_archivo_identificacion').click(function(){
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
        });

        $('#sel_archivo_kardex').click(function(){
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
        });

        $('#sel_archivo_constancia').click(function(){
        $('#img_constancia').trigger('click');
        $('#img_constancia').change(function() {
            var filename = $('#img_constancia').val();
            if (filename.substring(3,11) == 'fakepath')
            {
                filename = filename.substring(12);
            } // Remove c:\fake at beginning from localhost chrome
            $('#archivo_constancia').html(filename);
            });
        });
});
</script>

<script language="JavaScript" type="text/javascript">
    // A function that disables button
    function disableButton() {
        document.getElementById('btnSiguiente').setAttribute("disabled","disabled");
        document.getElementById('btnSiguiente').innerText = "Enviando...";
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
    .tooltip-inner {
    max-width: 350px;
    /* If max-width does not work, try using width instead */
    width: 350px; 
    max-height: 120px;
    background-color: #2f4fff;
    text-align: left;
}
</style>

<style>
    .bg-rojo {
           background-color: #892641; /* Color rojo en formato hexadecimal */
       }

   .btn-verde {
     background-color: #3d5b4f;
     color: white;
   }
 
   .btn-verde:hover {
     background-color: #4a826a; /* Cambia el color aquí al deseado cuando el mouse esté encima */
     color: white;
   }

   .btn-verde:active {
        background-color: #5ca265; /* Cambia el color aquí al deseado cuando el botón está activado (clic) */
        color: white;
    }

   .btn-dorado {
      background-color: #b2945e;
      color: white;
    }
  
    .btn-dorado:hover {
      background-color: #7c6c42; /* Cambia el color aquí al deseado cuando el mouse esté encima */
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
</style>

<!-- Ventana Modal -->
<div class="modal fade" id="pdfModal" tabindex="-1" role="dialog" aria-labelledby="pdfModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="pdfModalLabel">Vista Preliminar del PDF</h6>
                <div>
                <button type="button" class="btn btn-verde btn-sm" data-dismiss="modal">Aceptar</button> 
                <button type="button" class="btn btn-rojo btn-sm" onclick="noQuieroArchivo()">Descartar</button>
                </div>
            </div>
            <div class="modal-body">
                <!-- Canvas para mostrar el PDF -->
                <canvas id="pdfCanvas" style="max-width: 100%;"></canvas>
            </div>            
        </div>
    </div>
</div>

</head>
<body>
    <div class="container">
        <div class="card-body">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="row justify-content-center mb-2">
                        <img src="../img/Logo_y_Escudo.jpg" alt="Por tiempos mejores" style="width:70%">
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <form id="my_form" name="my_form" class="contact-form" enctype="multipart/form-data" method="POST" action="{{ route('estudiantes.formulario-documentos.post') }}" enctype="multipart/form-data" novalidate>
                                @csrf
                                <div class="row justify-content-center mb-1">
                                    <div class="text-center">
                                        <a href="/2024-2025">
                                            <img src="../img/alivianate.jpg" style="width:45%">
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
                                             <div class="row mb-3 justify-content-center" style="background-color: #f8f3ec; color: #5c2134;">
                                                Estudiante: &nbsp; <b> {{ $estudiante->nombre . ' ' . $estudiante->primer_apellido . ' ' . $estudiante->segundo_apellido }} </b>
                                            </div>
                                             <div class="row mb-3">
                                                <label class="col-md-6 col-form-label text-md-right">{{ __('Acta de Nacimiento') }} <a data-toggle="tooltip" data-placement="top" data-html="true" title="<b>ACTA CON FORMATO RECIENTE</b> <br> El acta de nacimiento se recomienda que sea de formato reciente y que esté en formato PDF que no pese más de 1MB"><img src="../img/help.jpg" style="width:12px;cursor:pointer;"></a></label>
                                                <div class="col-md-5">
                                                    <button type="button" class="btn btn-dorado" id="sel_archivo_acta_nac">Selecciona archivo<small><1M</small> <i class="fas fa-upload"></i></button>
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
                                                    <button type="button" class="btn btn-dorado" id="sel_archivo_comprobante_dom">Selecciona archivo<small><1M</small> <i class="fas fa-upload"></i></button>
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
                                                    <button type="button" class="btn btn-dorado" id="sel_archivo_identificacion">Selecciona archivo<small><1M</small> <i class="fas fa-upload"></i></button>
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
                                                    <button type="button" class="btn btn-dorado" id="sel_archivo_kardex">Selecciona archivo<small><1M</small> <i class="fas fa-upload"></i></button>
                                                    <div id="archivo_kardex" style="font-size:13px">{{$estudiante->img_kardex ?? 'Sin archivo seleccionado' }}</div>
                                                </div>
                                                <div id="vistaPreviaKardex" name="vistaPreviaKardex">
                                                    <a href="#" onclick="mostrarVistaPrevia('img_kardex')" data-toggle="tooltip" title="Vista preliminar" style="display: inline-block; line-height: 32px; vertical-align: middle;">
                                                        <b><i class="fa-solid fa-file-pdf text-rojo" style="font-size: 24px;"></i></b>
                                                    </a>
                                                </div>
                                                <input class="archivo-input" type="file" style="display: none" class="form-control" name="img_kardex" id="img_kardex" accept=".pdf, .PDF" onchange="mostrarVistaPreviaPDF(this)" >
                                            </div>
 
                                            <div class="row mb-1">
                                                <label class="col-md-6 col-form-label text-md-right">{{ __('Constancia de Estudios') }} <a data-toggle="tooltip" data-placement="top" data-html="true" title="<b>CONSTANCIA DE ESTUDIOS </b> <br> En formato PDF que no pese más de 1MB"><img src="../img/help.jpg" style="width:12px;cursor:pointer;"></a></label>
                                                <div class="col-md-5 alert alert-danger text-justify" style="padding:5px; margin:0"> <small> <i> Este archivo lo subirás después de que hayas enviado todos los documentos previamente solicitados. </i> </small>
                                                </div>
                                                {{-- <div class="col-md-5">
                                                    <button type="button" class="btn btn-success" id="sel_archivo_constancia">Selecciona archivo<small><1M</small> <i class="fas fa-upload"></i></button>
                                                    <div id="archivo_constancia" style="font-size:13px">{{$estudiante->img_constancia ?? 'Sin archivo seleccionado' }}</div>
                                                </div>
                                                <input class='file' type="file" style="display: none" class="form-control" name="img_constancia" id="img_constancia" accept="application/pdf" required> --}}
                                            </div>
                                            {{-- <input id="constancia_hidden" name="constancia_hidden" type="hidden" value="{{ $estudiante->img_constancia ?? '#constancia#' }}"> --}}
                                            <div class="row mb-1 justify-content-center">
                                                <div class="col-12 text-center">
                                                    <label class="col-form-label mx-1 p-2 col-10" style="font-size: 10pt; text-align: justify; color: #5c2134;">
                                                    * Para escanear los documentos se recomienda <b> CamScanner</b>. <br>
                                                    * Para la manipulación de <b> archivos PDF </b> se recomienda  <b> ILovePDF</b>.
                                                    </label>
                                                </div>
                                            </div>
                                        </div> 
                                    </div>
                                    <div class="alert alert-danger mb-0" id="mensajeError" style="display:none">
                                    </div>
                                </div>
                                <div class="row mb-1 justify-content-center">
                                    <div class="col-12 text-center">
                                        <label class="col-form-label mx-1 p-2 col-12" style="font-size: 10pt; text-align: justify; background-color: #f8f3ec; color: #5c2134;">
                                            <h4><b>¡¡ IMPORTANTE !!</b></h4>
                                            <ul>
                                                <li><strong>Estás en la ETAPA #1 DEL PROCESO:</strong> Asegúrate de completar esta etapa para avanzar en el proceso y poder subir la Constancia de Estudios más adelante.</li>
                                                <li><strong>Tienes que ENVIAR todos los archivos solicitados:</strong> Es obligatorio subir todos los documentos solicitados.</li>
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
                            <label class="col-form-label mx-1 p-2 col-12" style="font-size: 10pt; text-align: justify; background-color: #f8f3ec; color: #5c2134;">
                                * <b> <i class="fab fa-whatsapp"></i> <a href="javascript:void(0);" onclick="openWhatsApp()" style="color: inherit; text-decoration: none;">6941088943</a></b> para soporte técnico y dudas sobre el registro en línea. <br>
                                * Mayores informes en la presidencia municipal de <b> Lunes a Viernes de 8:30 a.m. a 3 p.m. </b>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    {{-- <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a> --}}

    <script>
        function openWhatsApp() {
            var phoneNumber = "526941088943"; // Coloca el número de teléfono sin el signo "+"
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

        $(".archivo-input").each(function() {
            var archivo = $(this).prop("files")[0];

            if (archivo) {
                archivosCargados++;
                if (archivo.size > 1024 * 1024) { // Tamaño máximo de 1 MB (en bytes)
                    archivosValidos = false;
                    mensajeError = mensajeError + 'El archivo <b>"' + archivo.name + '"</b> excede 1MB. <br>';
                }
            }
        });

        if (archivosValidos && archivosCargados === 4) {
            document.getElementById('btnSiguiente').removeAttribute("disabled");
            // document.getElementById('btnSiguiente').innerText = "Enviar";
            $("#mensajeError").hide(); // Ocultar el contenido del mensaje de error
        } else {
            document.getElementById('btnSiguiente').setAttribute("disabled", "disabled");
            // document.getElementById('btnSiguiente').innerText = "Enviar";
            $("#mensajeError").html(mensajeError); // Mostrar mensaje de error

            if (mensajeError) {
                $("#mensajeError").show(); // Mostrar el div si hay mensajes de error
            } else {
                $("#mensajeError").hide(); // Ocultar el div si no hay mensajes de error
            }
        }
    }

    $(document).ready(function() {
        $(".archivo-input").on("change", validacion);
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

    <script>
        var lastSelectedFile = null;
        var renderTask = null;
        var currentInputId = null; // Variable para almacenar el ID del input actual

        function ocultarVistaPreviaLink(currentInputId) {
            
            if (currentInputId == 'img_acta_nac') var vistaPreviaLink = document.getElementById("vistaPreviaActa");
            else if (currentInputId == 'img_comprobante_dom') var vistaPreviaLink = document.getElementById("vistaPreviaComprobante");
            else if (currentInputId == 'img_identificacion') var vistaPreviaLink = document.getElementById("vistaPreviaIdentificacion");
            else if (currentInputId == 'img_kardex') var vistaPreviaLink = document.getElementById("vistaPreviaKardex");

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
        });
        
        function mostrarVistaPreviaPDF(input) {
             // Validar si el archivo seleccionado es un PDF
            if (!input.files[0].type.includes('pdf')) {
                var currentInput = input.name;

                if (currentInput == 'img_acta_nac') var archivoElement = document.getElementById("archivo_acta_nac");
                else if (currentInput == 'img_comprobante_dom') var archivoElement = document.getElementById("archivo_comprobante_dom");
                else if (currentInput == 'img_identificacion') var archivoElement = document.getElementById("archivo_identificacion");
                else if (currentInput == 'img_kardex') var archivoElement = document.getElementById("archivo_kardex");
                
                
                archivoElement.innerText = "Sin archivo seleccionado";
                currentInputId = input.id;
                noQuieroArchivo();

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
            inputElement.value = ""; // Limpiar el valor para que no mantenga el archivo seleccionado


            // Restablecer la vista previa a "Sin archivo seleccionado"
            if (currentInputId == 'img_acta_nac') var archivoElement = document.getElementById("archivo_acta_nac");
            else if (currentInputId == 'img_comprobante_dom') var archivoElement = document.getElementById("archivo_comprobante_dom");
            else if (currentInputId == 'img_identificacion') var archivoElement = document.getElementById("archivo_identificacion");
            else if (currentInputId == 'img_kardex') var archivoElement = document.getElementById("archivo_kardex");
            archivoElement.innerText = "Sin archivo seleccionado";

            lastSelectedFile = null;
            ocultarVistaPreviaLink(currentInputId); // Ajustar visibilidad del elemento

            validacion();

            // Ocultar la ventana modal
            $("#pdfModal").modal("hide");
        }

        function mostrarVistaPrevia(fileInput) {
            var input = document.getElementById(fileInput);

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

        // Vincular la función al evento "change" del input de tipo "file" para acta de nacimiento
        // document.getElementById("img_acta_nac").addEventListener("change", function () {
        // mostrarVistaPreviaPDF(this);
        // });

        // // Vincular la función al evento "change" del input de tipo "file" para comprobante de domicilio
        // document.getElementById("img_comprobante_dom").addEventListener("change", function () {
        //     mostrarVistaPreviaPDF(this);
        // });

        // // Vincular la función al evento "change" del input de tipo "file" para identificación
        // document.getElementById("img_identificacion").addEventListener("change", function () {
        // mostrarVistaPreviaPDF(this);
        // });

        // // Vincular la función al evento "change" del input de tipo "file" para kardex
        // document.getElementById("img_kardex").addEventListener("change", function () {
        // mostrarVistaPreviaPDF(this);
        // });
    </script>

  
{{-- <script>
    $(document).ready(function() {
        // Habilitar el botón para permitir el envío del formulario
        $(".archivo-input").on("change", function() {
            var archivosCargados = 0;
            $(".archivo-input").each(function() {
                var archivo = $(this).prop("files")[0];
                if (archivo) {
                    archivosCargados++;
                }
            });

            if (archivosCargados === 4) {
                document.getElementById('btnSiguiente').removeAttribute("disabled");
                // document.getElementById('btnSiguiente').innerText = "Enviar";
            } else {
                document.getElementById('btnSiguiente').setAttribute("disabled", "disabled");
                // document.getElementById('btnSiguiente').innerText = "Siguiente";
            }
        });
    });
</script> --}}



</body>
</html>