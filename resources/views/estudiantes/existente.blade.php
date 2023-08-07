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
            <div class="row justify-content-center">
                <div class="col-md-7">
                    <div class="row text-center">
                        <h4><b> <small>«</small> {{ $estudiante->nombre . ' ' . $estudiante->primer_apellido . ' ' . $estudiante->segundo_apellido }} <small>»</small> ya se encuentra registrado(a) para el Ciclo Escolar {{ $ciclo }}</b> </h4>
                    </div>
                    <div class="text-justify">
                        <p> <br> Aquí se puede descargar el archivo PDF que contiene la <b> HOJA DE REGISTRO </b>. </p>
                        <div class="text-center"> 
                          <a href="{{ route('estudiantes.registro_pdf') }}" class="next btn btn-rojo"><i class="fa-solid fa-download"></i> <b> PDF </b></a>
                      </div>
                    </div>
                    {{-- <div class="text-justify">
                      <p> <br> También puedes subir la <b> CONSTANCIA DE ESTUDIOS DEL PERIODO ACTUAL </b> para concluir el proceso de registro </b>. </p>
                      <div class="text-center"> 
                        <a href="{{ route('estudiantes.formulario_constancia', $estudiante->id_hex) }}" title="Completar registro" class="btn btn-verde btn-md"> <b> <i class="fa-solid fa-upload"></i> Subir CONSTANCIA </b> </a>
                    </div> --}}
                  </div>
                </div>
            </div>
            <div class="row justify-content-center">

                      </div> <br>
                  <div class="row justify-content-center mb-4">
                      <img src="{{ url('img/Logo_y_Escudo.jpg') }}" alt="Por tiempos mejores" style="width: 35%">
                      &nbsp; &nbsp; &nbsp; &nbsp;
                      <img src="{{ url('img/alivianate.jpg') }}" style="width: 20%">
                  </div>
                  <div class="row justify-content-center">
                      <a class="btn btn-dorado" href="{{ route('estudiantes.forget') }}">Ir al Inicio</a>
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