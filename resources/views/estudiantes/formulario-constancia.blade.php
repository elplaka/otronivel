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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.min.js"></script>

<?php 
    $nomKardex = substr($estudiante->img_kardex,0,strlen($estudiante->img_kardex)-3);
    $extKardex = strtoupper(substr(strrchr($estudiante->img_kardex, "."), 1));
    $archivoKardex = $nomKardex . $extKardex;

    $nomConstancia = substr($estudiante->img_constancia,0,strlen($estudiante->img_constancia)-3);
    $extConstancia = strtoupper(substr(strrchr($estudiante->img_constancia, "."), 1));
    $archivoConstancia = $nomConstancia . $extConstancia;
?>

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
        $('#sel_archivo_constancia').click(function(){
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
</head>
<body>
    <div class="container">
        <div class="card-body">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="row justify-content-center mb-2">
                        <img src="{{url('/img/Logo_y_Escudo.jpg')}}" style="width:70%" />
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <form class="contact-form" method="POST" action="{{ route('estudiantes.formulario_constancia.post') }}" enctype="multipart/form-data" novalidate>
                                @csrf
                                <div class="text-center">
                                    <a href="/2024-2025">
                                        <img src="/img/alivianate.jpg" style="width:45%">
                                    </a>
                                </div>
                                <br>
                                <div class="row justify-content-center mb-1">
                                    <h1 class="h3 mb-4 text-gray-800 text-center"> <b>{{ __('FORMULARIO DE ACTUALIZACIÓN DE INFORMACIÓN ') }} </b> </h1>
                                </div>
                                <div class="card" style="background:#9c5c5f;color:#ffffff">
                                    <div class="card-header text-white" style="background:#5b5b5e">
                                        <i class="fas fa-user"></i> &nbsp; INFORMACIÓN DEL ESTUDIANTE
                                    </div>
                                    <table class="table-striped table-sm">
                                        <tbody>
                                            <tr>
                                                <td style="text-align:right">Nombre: </td>
                                                <td><b>{{ $estudiante->nombre . ' ' . $estudiante->primer_apellido . ' ' . $estudiante->segundo_apellido }} </b></td>
                                            </tr> 
                                            <tr>
                                                <td style="text-align:right">Escuela:</td>
                                                <td><b>{{ $estudiante->escuela->escuela }} </b></td>
                                            </tr> 
                                            <tr>
                                                <td style="text-align:right">Carrera:</td>
                                                <td><b>{{ $estudiante->carrera }} </b></td>
                                            </tr> 
                                            <tr>
                                                <td style="text-align:right">Ciudad Escuela:</td>
                                                <td><b>{{ $estudiante->ciudad->ciudad }} </b></td>
                                            </tr> 
                                        </tbody>
                                    </table>
                                </div>
                                <br>
                                <div class="card">
                                    <div class="form-section">
                                        <div class="card-header text-white" style="background:#5b5b5e">
                                            <i class="fas fa-upload"></i> &nbsp; DOCUMENTACIÓN PENDIENTE DE SUBIR
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
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                            @endif
                                            <div class="row mb-1">
                                                <label class="col-md-5 col-form-label text-md-right">{{ __('Constancia de Estudios') }} <a data-toggle="tooltip" data-placement="top" data-html="true" title="<b>CONSTANCIA DE ESTUDIOS </b> <br> Del Ciclo Escolar 2024-2025 en formato PDF que no pese más de 1MB"><img src="/img/help.jpg" style="width:12px;cursor:pointer;"></a></label>
                                                <div class="col-md-5">
                                                    <button type="button" class="btn btn-dorado" id="sel_archivo_constancia" style="border: none;">Selecciona archivo <i class="fas fa-upload"></i></button>
                                                    <div id="archivo_constancia" style="font-size:13px" required>                 
                                                        {{$estudiante->img_constancia ?? 'Sin archivo seleccionado' }}
                                                    </div>
                                                </div>
                                                <div class="col-md-2" id="vistaPreviaLink" name="vistaPreviaLink">
                                                    <a href="#" onclick="mostrarVistaPrevia()" data-toggle="tooltip" title="Vista preliminar" style="display: inline-block; line-height: 32px; vertical-align: middle;">
                                                        <b><i class="fa-solid fa-file-pdf text-rojo" style="font-size: 24px;"></i></b>
                                                    </a>
                                                </div>
                                                <div class="col-md-2" id="vistaPreviaPDF" name="vistaPreviaPDF">
                                                    <a href="{{ route('estudiantes.ver-constancia', ['archivo' => $estudiante->img_constancia, 'key' => hash('sha256', $estudiante->img_constancia)]) }}" target="_blank" data-toggle="tooltip" title="Vista preliminar" style="display: inline-block; line-height: 32px; vertical-align: middle;">
                                                        <b><i class="fa-solid fa-file-pdf text-rojo" style="font-size: 24px;"></i></b> 
                                                    </a>
                                                </div>
                                            </div>
    
                                            <input class="file" type="file" style="display: none" class="form-control" name="img_constancia" id="img_constancia"  accept=".pdf, .PDF" onchange="mostrarVistaPreviaPDF(this)">
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-12 d-flex justify-content-center">
                                                <button type="submit" id="btnSiguiente" name="btnSiguiente" class="btn btn-verde mt-2">Guardar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="{{ asset('js/jquery.js') }}"></script>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('js/app.js') }}"></script>
   

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('js/sb-admin.min.js') }}"></script>

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

        function ocultarVistaPreviaLinkInicio(){
            var archivo = document.getElementById("archivo_constancia");
            var nombreArchivo = archivo.innerText;
            var vistaPreviaPDF = document.getElementById("vistaPreviaPDF");

            if (nombreArchivo.length >= 4) {
                var extension = nombreArchivo.substring(nombreArchivo.length - 4).toUpperCase();
            }

            if (extension == '.PDF')
            {
                vistaPreviaPDF.style.display = "inline-block";
            }
            else
            {
                vistaPreviaPDF.style.display = "none";
            }

        }

        document.addEventListener("DOMContentLoaded", function () {
            ocultarVistaPreviaLink();
            ocultarVistaPreviaLinkInicio();
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
        document.getElementById("img_constancia").addEventListener("change", function () {
          mostrarVistaPreviaPDF(this);
        });
    
        function cerrarVistaPreviaPDF() {
        $("#pdfModal").modal("hide");
      }

      // Función para no cargar el archivo seleccionado
    function noQuieroArchivo() {
        // Restablecer el valor del input de tipo "file" para permitir cargar un nuevo archivo
        var inputElement = document.getElementById("img_constancia");
        inputElement.value = ""; // Limpiar el valor para que no mantenga el archivo seleccionado

        // Restablecer la vista previa a "Sin archivo seleccionado"
        var archivoConstancia = document.getElementById("archivo_constancia");
        archivoConstancia.innerText = "Sin archivo seleccionado";

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