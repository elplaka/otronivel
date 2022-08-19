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

</head>
<body>
    <div class="container">
        <div class="card-body">
            <div class="row justify-content-center">
                <div class="col-md-7">
                    <div class="row text-center">
                        <h2><b> INFORMACIÓN ACTUALIZADA CON ÉXITO </b> </h2>
                    </div>
                    <div class="row text-justify">
                        Aquí podrás descargar el archivo PDF que contiene la información completa de tu registro.
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="card-body">
            <div class="row justify-content-center">
    <a href="{{ route('estudiantes.registro_pdf') }}" class="next btn btn-danger float-center mt-2">PDF</a>
            </div>
        </div>
        <div class="row justify-content-center mb-4">
            <img src="../img/Logo_y_Escudo.jpg" alt="Por tiempos mejores" style="width:35%"> &nbsp; &nbsp; &nbsp;
            &nbsp; <img src="../img/alivianate.jpg" style="width:20%">
        </div>
    </div>
    <script src="{{ asset('js/jquery.js') }}"></script>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ mix('js/app.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('js/sb-admin.min.js') }}"></script>
</body>
</html>