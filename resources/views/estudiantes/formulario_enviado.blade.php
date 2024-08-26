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

</head>
<body>
    <div class="container">
        <div class="card-body">
          <div class="row justify-content-center mb-4">
            <img src="../img/Logo_y_Escudo.jpg" alt="Por tiempos mejores" style="width:35%"> &nbsp; &nbsp; &nbsp;
            &nbsp; <img src="../img/alivianate.jpg" style="width:20%">
          </div>   
          <div class="row justify-content-center">
              <div class="col-md-7" style="font-size:11pt">
                <div class="row text-center">
                    <h2><b> FORMULARIO ENVIADO CON ÉXITO </b> </h2>
                </div>
                <div class="row text-justify mb-0">
                    <p>Se te ha enviado un correo electrónico a la dirección que proporcionaste en el formulario. Es importante que conserves este correo, ya que te será útil en las siguientes etapas del proceso.</p>

                    {{-- <p class="mb-0"><strong>Descarga del PDF:</strong> En este momento, también tienes la opción de descargar un archivo PDF que contiene toda la información que acabas de registrar. Este archivo es una copia de seguridad y te permitirá tener acceso inmediato a los detalles enviados.</p> --}}
                </div>

                {{-- <div class="col-12 text-center mt-0">
                    <a href="{{ route('estudiantes.registro_pdf') }}" class="btn btn-rojo">
                        <i class="fa-solid fa-download"></i> <b> PDF </b>
                    </a>
                </div> --}}
                <div class="row text-justify mb-0">
                  <p class="mb-0"><strong>Revisar tu correo:</strong></p>
                  <ul>
                      <li><strong>Bandeja de entrada:</strong> El correo electrónico debería llegar en unos minutos a tu bandeja de entrada.</li>
                      <li><strong>Carpeta de spam o correo no deseado:</strong> Si no ves el correo en tu bandeja de entrada, por favor revisa tu carpeta de spam o correo no deseado. A veces, los correos electrónicos automáticos pueden ser filtrados por error.</li>
                  </ul>

                  <p class="mb-0"><strong>Problemas para recibir el correo:</strong></p>
                  <ul>
                      <li>Si no recibes el correo electrónico en las próximas horas, verifica que la dirección de e-mail proporcionada sea correcta.</li>
                      <li>En caso de errores o problemas, contacta con el equipo de soporte utilizando la información de contacto proporcionada en la plataforma.</li>
                  </ul>

                  <p class="mb-0"><strong>Próximos pasos</strong></p>
                  <ul>
                      <li><strong>Contacto por WhatsApp:</strong> Asegúrate de que el número de WhatsApp que proporcionaste en el formulario esté activo y disponible. Te contactaremos a través de este medio para informarte sobre el avance del proceso y cualquier otra información relevante. Es importante que puedas acceder a WhatsApp regularmente para no perderte ninguna comunicación.</li>

                      <li><strong>Continúa con el proceso:</strong> Ya puedes subir la Constancia de Estudios requerida para continuar con el registro.</li>
                  </ul>
                </div>
              </div>
            </div>       
            <div class="row justify-content-center">
                <a class="btn btn-verde" href="{{ route('estudiantes.forget') }}">Nuevo Registro</a> &nbsp;&nbsp;
              <a class="btn btn-dorado" href="{{ route('estudiantes.forget') }}">Subir Constancia de Estudios</a>
            </div>
            <br>
          </div>
        </div>
      </div>
            

    <script src="{{ asset('js/jquery.js') }}"></script>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ mix('js/app.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('js/sb-admin.min.js') }}"></script>
</body>
</html>