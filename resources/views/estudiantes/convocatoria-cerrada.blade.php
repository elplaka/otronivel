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
    <div class="container mt-5">
      <div class="card border-0 shadow-lg" style="border-radius: 20px;">
          <div class="card-body p-5 text-center">
              
              <div class="row justify-content-center align-items-center mb-5">
                  <div class="col-6 col-md-4 mb-3 mb-md-0">
                      <img src="{{ url('img/Logo_y_Escudo.jpg') }}" class="img-fluid" style="max-height: 80px;">
                  </div>
                  <div class="col-5 col-md-3">
                      <img src="{{ url('img/logo_programa.jpg') }}" class="img-fluid" style="max-height: 80px;">
                  </div>
              </div>

              <div class="py-4">
                  <div class="display-1 text-danger mb-4">
                      <i class="fas fa-calendar-times"></i>
                  </div>
                  <h2 class="font-weight-bold text-dark">Convocatoria Finalizada</h2>
                  <div class="alert alert-danger d-inline-block px-4 py-3 mt-3" style="border-radius: 10px; border-left: 5px solid #690116ff;">
                      <p class="mb-0" style="font-size: 1.1rem;">
                          Lo sentimos, el periodo de registro para este programa ha <strong>concluido</strong>.
                      </p>
                  </div>
                  <p class="text-muted mt-3">Te invitamos a estar pendiente de nuestras próximas fechas y redes sociales.</p>
              </div>

              <hr class="my-4" style="width: 20%; margin: auto;">

              <div class="mt-2">
                  <a class="btn btn-rojo btn-lg px-5 rounded-pill shadow-sm" 
                    href="{{ route('estudiantes.forget') }}"
                    style="font-weight: 600; transition: transform 0.2s;">
                      <i class="fas fa-home mr-2"></i>Regresar al Inicio
                  </a>
              </div>

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