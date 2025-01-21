<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
    
        <title>OTRO NIVEL </title>
    
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

  </style>

</head>
<body>
    <div class="container">
        <div class="card-body">
            <div class="row justify-content-center">
                <div class="row justify-content-center mb-4">
                  <img class="col-md-5" src="{{ url('img/Logo_y_Escudo.jpg') }}">
                  <img class="col-md-4" src="{{ url('img/logo_programa.jpg') }}">
                </div>

                <div class="col-md-8">
                    @if ($estudiante->cve_status != 4)
                    <div class="text-center">
                        <h4 style="text-align: center;"><b> Hola <small>«</small> {{ $estudiante->nombre . ' ' . $estudiante->primer_apellido . ' ' . $estudiante->segundo_apellido }} <small>»</small> </b> </h4>
                    </div>
                    @endif
                    @if($estudiante->img_constancia == 'PENDIENTE')
                        @if ($estudiante->cve_status == 1)
                          <div style="color:white; background-color: #85195b; border: 2px solid rgb(56, 0, 70); padding: 10px;">
                              <p>
                            TU REGISTRO PARA EL PERIODO ACTUAL <b>AÚN NO ESTÁ COMPLETO</b>. SE REQUIERE SUBIR LA <b> CONSTANCIA DE ESTUDIOS </b>.
                            </p>
                          </div>
                        @elseif ($estudiante->cve_status == 2)
                          <div style="color:white; background-color: #6b7c00; border: 2px solid rgb(56, 0, 70); padding: 10px;">
                            <p>
                          LA DOCUMENTACIÓN QUE HAS PROPORCIONADO HASTA EL MOMENTO HA SIDO REVISADA Y VALIDADA CORRECTAMENTE, SIN EMBARGO TU REGISTRO PARA EL PERIODO ACTUAL <b>AÚN NO ESTÁ COMPLETO</b>. SE REQUIERE SUBIR LA <b> CONSTANCIA DE ESTUDIOS </b>.
                          </p>
                          </div>
                        @endif
                    @else
                      @if ($estudiante->cve_status == 1)
                        <div style="color:white; background-color: #85195b; border: 2px solid rgb(56, 0, 70); padding: 10px;">
                          <p>
                            TU REGISTRO PARA EL PERIODO ACTUAL <b>YA ESTÁ COMPLETO</b>. TU DOCUMENTACIÓN SERÁ REVISADA Y VALIDADA SEGÚN SEA NECESARIO. </b>.
                          </p>
                        </div>
                      @endif
                    <div class="text-justify">
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
                      @if ($estudiante->cve_status == 6 || $estudiante->cve_status == 7)
                        @if (isset($prox_remesa))
                        <div style="background-color: #a62828; border: 2px solid #800000; color: white; padding: 7px; text-align: center; display: flex; justify-content: center; align-items: center;">
                          <p>
                              FECHA DE ENTREGA DE BECA: <b>{{  $dia }}-{{ $nombre_mes }}-{{ $anio }}</b>
                          </p>
                        </div>
                        @else
                        <div style="background-color: #e5f7e1; border: 2px solid green; padding: 10px;">
                          <p>
                              <b>TU DOCUMENTACIÓN YA SE VALIDÓ Y ESTÁ EN ORDEN</b>.
                              <i class="fas fa-check-circle" style="color: green;"></i>
                          </p>
                          <p>
                              Nos complace informarte que toda la documentación que proporcionaste ha sido revisada y validada correctamente. Esto significa que has cumplido con todos los requisitos necesarios hasta esta etapa del proceso.                            
                          </p>
                        </div>                    
                        @endif                     
                      @elseif ($estudiante->cve_status == 2)
                      <div style="background-color: #ffffcc; border: 2px solid yellow; padding: 10px;">
                        <p>
                            <b>TU SOLICITUD PARA ESTE PERIODO ESTÁ EN SU ETAPA FINAL</b>.
                            <i class="fas fa-exclamation-circle" style="color: rgba(168, 168, 31, 0.71);"></i>
                        </p>
                        <p>
                             Nos encontramos en la fase final del proceso de validación y revisión de documentos, en la cual HAS CUMPLIDO CORRECTAMENTE con los requisitos para el registro a este programa. Te recomendamos que estés al pendiente de este sistema donde se publicará posteriormente información importante.
                        </p>
                    </div>                    
                      @elseif ($estudiante->cve_status == 3)
                      <div style="background-color: #cce5ff; border: 2px solid #0000cc; padding: 10px;">
                        <p>
                          <b>TU DOCUMENTACIÓN ESTÁ INCOMPLETA O TIENE INCONSISTENCIAS</b>. Es posible que algunos documentos no hayan sido cargados correctamente. 
                            Para evitar retrasos en el proceso, te recomendamos que atiendas las observaciones que se te hicieron para corregir la situación.
                        </p>
                        <p>
                            Si tienes alguna duda o necesitas asistencia inmediata, puedes <b><a href="javascript:void(0);" onclick="openWhatsApp()" style="color: inherit; text-decoration: none;">
                            <i class="fab fa-whatsapp" style="color: #0000cc;"></i> contactarnos por WhatsApp</a></b>, donde nuestro equipo estará disponible para ayudarte a resolver cualquier inconveniente que hayas encontrado.
                        </p>
                        </div>
                        @if (!is_null($estudiante->observaciones_estudiante))
                          <br> <b> OBSERVACIONES: </b> <br>
                          <div style="color:rgb(0, 0, 0); background-color: #09ff00; border: 2px solid rgb(0, 51, 38); padding: 10px;">
                            <p>
                              <b> {{ $estudiante->observaciones_estudiante }} </b>
                            </p>
                          </div>
                        @endif           
                      @endif
                    @endif
                  </div>
                    @if($estudiante->img_constancia == 'PENDIENTE')
                    <div class="text-justify">
                      <p> <br> Aquí puedes subir la <b> CONSTANCIA DE ESTUDIOS DEL PERIODO ACTUAL </b> para concluir el proceso de registro. </p>
                      <div class="text-center"> 
                        <a href="{{ route('estudiantes.formulario_constancia', $estudiante->id_hex) }}" title="Completar registro" class="btn btn-verde btn-md"> <b> <i class="fa-solid fa-upload"></i> Subir CONSTANCIA </b> </a>
                    </div>
                    @else
                    @if ($estudiante->cve_status == 1 || $estudiante->cve_status == 2 || $estudiante->cve_status == 3)
                    <div class="text-justify">
                      <p> <br> Si quieres actualizar la <b> CONSTANCIA DE ESTUDIOS DEL PERIODO ACTUAL </b> lo puedes hacer aquí. </p>
                      <div class="text-center"> 
                        <a href="{{ route('estudiantes.formulario_constancia', $estudiante->id_hex) }}" title="Completar registro" class="btn btn-verde btn-md"> <b> <i class="fa-solid fa-upload"></i> Actualizar CONSTANCIA </b> </a>
                    </div>
                    @endif
                    @endif
                    @if ($estudiante->cve_status != 4)
                    <div class="text-justify">
                        <p> <br> También puedes descargar el archivo PDF que contiene tu <b> HOJA DE REGISTRO </b> para el Ciclo Escolar {{ $ciclo }}. </p>
                        <div class="text-center"> 
                          <a href="{{ route('estudiantes.registro_pdf') }}" class="next btn btn-rojo"><i class="fa-solid fa-download"></i> <b> PDF </b></a>
                      </div>
                    </div>
                    @endif
                    <br><br>
                    <div class="row justify-content-center">
                      <a class="btn btn-dorado" href="{{ route('estudiantes.forget') }}">Ir al Inicio</a>
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
          var phoneNumber = "526692295855"; // Coloca el número de teléfono sin el signo "+"
          var isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
          var url = isMobile ? "https://api.whatsapp.com/send?phone=" : "https://web.whatsapp.com/send?phone=";
  
          window.open(url + phoneNumber, "_blank");
      }
  </script>
</body>
</html>