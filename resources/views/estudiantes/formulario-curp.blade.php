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
        $('#sel_archivo_curp').click(function(){
        $('#img_curp').trigger('click');
        $('#img_curp').change(function() {
            var filename = $('#img_curp').val();
            if (filename.substring(3,11) == 'fakepath')
            {
                filename = filename.substring(12);
            } // Remove c:\fake at beginning from localhost chrome
            else
            {
                filename = "Sin archivo seleccionado";
                noQuieroArchivo();
            }
            $('#archivo_curp').html(filename);
            });
        });
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
    .btn-dorado {
      background-color: #b2945e;
      color: white;
    }
  
    .btn-dorado:hover {
      background-color: #7c6c42; /* Cambia el color aquí al deseado cuando el mouse esté encima */
      color: white;
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
        background-color: #356b5d; /* Cambia el color aquí al deseado cuando el botón está activado (clic) */
        color: white;
    }

    .btn-guinda {
      background-color: #5c2134;
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

  </style>


<!-- Ventana Modal -->
<div class="modal fade" id="pdfModal" tabindex="-1" role="dialog" aria-labelledby="pdfModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="pdfModalLabel">Vista Preliminar del PDF</h6>
                <div>
                    <button type="button" class="btn btn-sm btn-verde" data-dismiss="modal"> Aceptar </button>
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

<div class="modal fade" id="requisitosModal" tabindex="-1" role="dialog" aria-labelledby="requisitosModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="pdfModalLabel" style="font-size:11pt"><b> Requisitos para el REGISTRO al PROGRAMA ALIVIAN4TE </b></h6>
            </div>
            <div class="modal-body">
                <label class="col-form-label mx-1 p-2" style="font-size: 10pt; background-color: #f8f3ec; color: #5c2134; text-align: justify;">
                    <ul style="list-style-type: disc; margin: 0; padding: 10px; background-color: #f8f3ec;">
                    <li style="text-align: justify;">
                        El archivo PDF del CURP será <b> tu primer requisito </b> para registrarte. Además necesitas los archivos PDF de:
                    </li>
                    <ul>
                    <li>
                       <i> <strong> Identificación Oficial </strong> </i>
                       <br> <i> De preferencia la credencial del INE. En caso de no contar con esta credencial se aceptará una identificación de cualquier insitución educativa. </i>
                    </li>
                    <li>
                       <i> <strong> Acta de Nacimiento </strong> </i>
                       <br> <i>En un formato reciente. </i>
                    </li>
                    <li>
                        <i> <strong> Comprobante de Domicilio </strong> </i>  <br>
                        <i> Puede ser de la CFE, Agua potable, MegaCable, TELMEX con dirección dentro del municipio de Concordia. </i>
                    </li>
                    <li>
                        <i> <strong> Kardex Escolar </strong> </i>
                        <br>
                        <i> Es una constancia con calificaciones de tu periodo escolar recién cursado. Si apenas vas a entrar al Nivel Superior subirás el certificado de la preparatoria. </i>
                    </li>
                    <li>
                        <i> <strong> Constancia de Estudios </strong> </i>    <br>
                        <i> Deberás solicitarla en tu escuela, la cual te acreditará como estudiante del ciclo escolar 2023-2024. </i>
                    </li>
                    </ul>
                    </ul>
                    <li style="text-align: justify;">
                    Estos archivos <b> deben ser legibles </b> y cada uno de ellos debe pesar menos de <b> 1 Megabyte. </b>
                    </li>
                    <br>
                    <li style="text-align: justify;">
                        Una vez que te hayas registrado, puedes usar el mismo archivo PDF para <b>descargar tu hoja de registro</b>, <b> subir tu Constancia de Estudios </b> y <b>consultar información</b> sobre el programa ALIVIAN4TE.
                    </li>
                </li>                
                </style>
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
                            <form id="my_form" name="my_form" class="contact-form" method="POST" action="{{ route('estudiantes.formulario-curp.post') }}" enctype="multipart/form-data" novalidate>
                                @csrf
                                <div class="row justify-content-center mb-2">
                                    <img src="../img/alivianate.jpg" style="width:45%">
                                </div>
                                {{-- <div class="row justify-content-center mb-1">
                                    <h1 class="h3 mb-2 text-gray-800"> <b>{{ __('INICIO DEL REGISTRO') }} </b> </h1>
                                </div> --}}
                                <div class="card">
                                    <div class="form-section">
                                        {{-- <div class="card-header text-white bg-primary">
                                            <b>SUBIR CURP</b>
                                        </div>
                                        <br> --}}
                                        <div class="card-body">                                            
                                             <div class="row mb-1 justify-content-center">
                                                <div class="col-md-12">
                                                    <label class="col-form-label mx-1 p-2" style="font-size: 10pt; background-color: #f8f3ec; color: #5c2134; text-align: justify;">
                                                        <ul style="list-style-type: disc; margin: 0; padding: 10px; background-color: #f8f3ec;">
                                                            <h4><b>¡¡ IMPORTANTE !!</b></h4>
                                                            @if ($convocatoria_abierta)
                                                            <li style="text-align: justify;">
                                                                El periodo de registro comprende del <b> 26 de Agosto al 20 de Septiembre de 2024. </b>
                                                            </li>                                               
                                                            @else
                                                            <li style="text-align: justify;">
                                                                El periodo de registro comprendió del <b> 26 de Agosto al 20 de Septiembre de 2024. </b>
                                                            </li>                           
                                                            <li style="text-align: justify;">
                                                                Puedes usar el archivo PDF para <b>descargar tu hoja de registro</b>, <b> subir tu constancia de estudios </b> y <b>consultar información</b> sobre el programa ALIVIAN4TE.
                                                            </li>
                                                            @endif
                                                            <li style="text-align: justify;">
                                                                Se aceptará el <strong> archivo PDF con el formato más reciente </strong> que puedes descargar en la página del Gobierno Federal
                                                                <i><a href="https://www.gob.mx/curp/" target="_blank" class="text-primary">https://www.gob.mx/curp/</a></i>
                                                            </li>
                                                            <li style="text-align: justify;">
                                                                El archivo PDF <b> NO se imprime</b>, <b> NO se escanea</b>, <b> NO se le toma foto.</b> Se debe subir el <b> archivo original </b> previamente descargado.
                                                            </li> 
                                                            <li style="text-align: justify;">
                                                                El registro a este programa  <b> se completa en dos etapas</b>:
                                                                <ul>
                                                                    <li>
                                                                        <b> ETAPA #1. </b> Utilizando tu <b> archivo PDF del CURP </b> en primera instancia </b> deberás subir <b> uno por uno los archivos PDF </b> de la <i> Identificación Oficial</i>, el <i> Acta de Nacimiento</i>, el  <i>Comprobante de Domicilio </i> y el <i> Kardex Escolar</i>. Dejando la <i> Constancia de Estudios </i> para la segunda etapa.
                                                                    </li>
                                                                    <li>
                                                                        <b>ETAPA #2.</b> Procederás a acceder al sistema de registro mediante tu archivo PDF del CURP y subirás el archivo PDF que contenga la <b>Constancia de Estudios del Ciclo Escolar 2024-2025</b> para completar el registro. 
                                                                    </li>
                                                                </ul>
                                                            </li>                          
                                                        </ul>
                                                        <button type="button" id="btnAbrirModal" class="next btn btn-guinda float-right mt-0" style="border: none;" data-toggle="modal" data-target="#requisitosModal">
                                                            Ver requisitos
                                                        </button>
                                                    </label>
                                                </div>
                                            </div>
                                            <hr>
                                             <!-- Botón para mostrar la ventana modal de selección de archivo -->
                                             @if (session()->has('message'))
                                             <div class="col-md-12 alert alert-danger mb-3">
                                                <div>                        
                                                    <button type="button" class="close" data-dismiss="alert">
                                                      &times;
                                                    </button>                        
                                                    {!! html_entity_decode(session()->get('message')) !!}
                                                    <li style="text-align: justify;">
                                                        Se aceptará el <strong> archivo PDF con el formato más reciente </strong> que puedes descargar en la página del Gobierno Federal
                                                        <i><a href="https://www.gob.mx/curp/" target="_blank" class="text-primary">https://www.gob.mx/curp/</a></i>
                                                    </li>
                                                    <li style="text-align: justify;">
                                                        El archivo PDF <b> NO se imprime</b>, <b> NO se escanea</b>, <b> NO se le toma foto.</b> Se debe subir el <b> archivo original </b> previamente descargado.
                                                    </li> 
                                                </div>
                                            </div>
                                            @endif 
                                            @if ($errors->any())
                                            <div class="col-md-12 alert alert-danger mb-3">
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
                                            <div class="row mb-1">
                                                <label class="col-md-4 col-form-label text-md-right">{{ __('CURP') }} <a data-toggle="tooltip" data-placement="top" data-html="true" title="<b>ARCHIVO EN PDF</b> <br> El formulario aceptará el archivo PDF de formato reciente descargado en la página del Gobierno Federal <i>https://www.gob.mx/curp/</i> que no pese más de 1MB"><img src="../img/help.jpg" style="width:12px;cursor:pointer;"></a></label>
                                                <div class="col-md-5">
                                                    <button type="button" class="btn btn-dorado" id="sel_archivo_curp" style="border: none;">Selecciona archivo <i class="fas fa-upload"></i></button>
                                                    <div id="archivo_curp" style="font-size:13px" required>                 
                                                        {{$estudiante->img_curp ?? 'Sin archivo seleccionado' }}
                                                    </div>
                                                </div>
                                                <div id="vistaPreviaLink" name="vistaPreviaLink">
                                                    <a href="#" onclick="mostrarVistaPrevia()" data-toggle="tooltip" title="Vista preliminar" style="display: inline-block; line-height: 32px; vertical-align: middle;">
                                                        <b><i class="fa-solid fa-file-pdf text-rojo" style="font-size: 24px;"></i></b>
                                                    </a>
                                                </div>
                                                <input class="file" type="file" style="display: none" class="form-control" name="img_curp" id="img_curp"  accept=".pdf, .PDF" onchange="mostrarVistaPreviaPDF(this)">
                                            </div>
                                        </div>
                                    </div>
                                </div>              
                                <button type="submit" id="btnSiguiente" name="btnSiguiente" class="next btn btn-verde float-right mt-2" style="border: none;">Siguiente</button>
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
    <script src="{{ asset('js/jquery.js') }}"></script>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ mix('js/app.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('js/sb-admin.min.js') }}"></script>

    <script>
        function openWhatsApp() {
            var phoneNumber = "526941088943"; // Coloca el número de teléfono sin el signo "+"
            var isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
            var url = isMobile ? "https://api.whatsapp.com/send?phone=" : "https://web.whatsapp.com/send?phone=";
    
            window.open(url + phoneNumber, "_blank");
        }
    </script>
    
    <script>
        // Variable para almacenar el último archivo seleccionado
        var lastSelectedFile = null;
        var renderTask = null;

        function ocultarVistaPreviaLink() {
            var vistaPreviaLink = document.getElementById("vistaPreviaLink");
            if (lastSelectedFile === null) {
            vistaPreviaLink.style.display = "none";
            } else {
            vistaPreviaLink.style.display = "inline-block";
            }
        }

        document.addEventListener("DOMContentLoaded", function () {
    ocultarVistaPreviaLink();
  });
        
        // Función para mostrar la vista previa del PDF en la ventana modal
        function mostrarVistaPreviaPDF(input) {
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