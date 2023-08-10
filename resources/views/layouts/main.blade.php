<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Sistema ALIVIAN4TE</title>

    <!-- Custom fonts for this template-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    {{-- Multiple Select --}}
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />  --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
    {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" /> --}}
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"> </script> --}}
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.min.js"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.min.js"></script>


    <!-- Custom styles for this template-->
    <link href="{{ asset('css/sb-admin.min.css')}}" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> 
   
</head>

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
            $('#archivo_curp').html(filename);
            });
        });

        $('#sel_archivo_acta_nac').click(function(){
        $('#img_acta_nac').trigger('click');
        $('#img_acta_nac').change(function() {
            var filename = $('#img_acta_nac').val();
            if (filename.substring(3,11) == 'fakepath')
            {
                filename = filename.substring(12);
            } // Remove c:\fake at beginning from localhost chrome
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

        $('.search_select_box select').selectpicker();
});
</script>

<style>
    .search_select_box
    {
        max-width: 400px;
    }

    .search_select_box select
    {
        width: 100%;
    }

    .search_select_box button
    {
        background-color: #ffffff;
        border-color: #cccccc;
        font-size: 13px;
    }
    
    .bootstrap-select .form-control:focus {
        outline: 0px none #fff !important;
    }

    .bootstrap-select .form-control > div.filter-option:focus {
        outline: 0px none #fff !important;
    }

    .bootstrap-select .form-control > div.filter-option > div.filter-option-inner:focus {
        outline: 0px none #fff !important;
    }

    .bootstrap-select .form-control > div.filter-option > div.filter-option-inner > div.filter-option-inner-inner:focus {
        outline: 0px none #fff !important;
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


<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href={{ url('/home') }}>
                <div>
                    <i class="fa-solid fa-book-open-reader"></i>
                    {{-- <img src="/img/icono.png" alt="Por tiempos mejores" style="width:50px"> --}}
                </div>
                <div class="sidebar-brand-text mx-3">ALIVIAN4TE </div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

           <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Nav Item - Estudiantes -->
            @if (Auth::user()->usertype >= 1)  
            <li class="nav-item">
                <a class="nav-link" href="{{ route('estudiantes.index') }}">
                    <i class="fas fa-book"></i>
                    <span>&nbsp;Estudiantes</span></a>
                    
                    {{-- @if (Auth::user()->usertype == 1) 
                    <div id="collapseSystem1" class="collapse" aria-labelledby="headingOne" data-parent="#accordionSidebar">
                        <div class="py-0 collapse-inner rounded">
                                <a class="nav-link" href="{{ route('estudiantes.monto-raya') }}"><i class="fa-solid fa-boxes-stacked"></i>Monto Raya </a>
                        </div>
                    </div>
                    @endif --}}
            </li>
            @endif
            {{-- <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSystem"
                aria-expanded="true" aria-controls="collapseSystem">
                <img src="/img/iconousuarios.png" alt="Estudiantes" style="width:25px">
                    <span>Estudiantes</span>
                </a>
                <div id="collapseSystem" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded"> --}}
                        {{-- <h6 class="collapse-header">Custom Components:</h6> --}}
                        {{-- <a class="collapse-item" href="{{ route('countries.index') }}">Country</a>
                        <a class="collapse-item" href="{{ route('states.index') }}">State</a>
                        <a class="collapse-item" href="{{ route('cities.index') }}">City</a>
                        <a class="collapse-item" href="{{ route('departments.index') }}">Department</a> --}}
                        {{-- <a class="collapse-item" href="{{ route('empleados.create') }}">Nuevo</a>
                        <a class="collapse-item" href="{{ route('empleados.index') }}">Buscar</a> --}}
                        {{-- <a class="collapse-item" href="{{ route('empleados.index') }}">Buscar</a>
                        <a class="collapse-item" href="/">Department</a>  --}}
                    {{-- </div>
                </div>
            </li> --}}

            @if (Auth::user()->usertype == 1 || Auth::user()->usertype == 3)  
            <!-- Divider -->
           <hr class="sidebar-divider"> 
           <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSystem2"
            aria-expanded="true" aria-controls="collapseSystem2">
            <i class="fas fa-language"></i>
                <span>Boletos</span>
            </a>
            <div id="collapseSystem2" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="py-0 collapse-inner rounded">
                     @if (Auth::user()->usertype == 1) 
                     <a class="nav-link" href="{{ route('boletos.paquetes-index') }}"><i class="fa-solid fa-boxes-stacked"></i>Paquetes </a>
                     <a class="nav-link" href="{{ route('boletos.remesas-index') }}"><i class="fa-solid fa-people-carry-box"></i>Remesas </a>
                     <a class="nav-link" href="{{ route('boletos.tantos-index') }}"><i class="fa-solid fa-spinner"></i>Tantos </a>
                     @endif
                     <a class="nav-link" href="{{ route('boletos.asignacion-nueva') }}">                    <i class="fa-solid fa-hand-holding"></i>Asignación </a>
                </div>
            </div>
            </li>
           @endif

           @if (Auth::user()->usertype == 1 || Auth::user()->usertype == 3)  
           <!-- Divider -->
          <hr class="sidebar-divider"> 
          <li class="nav-item">
           <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSystem3"
           aria-expanded="true" aria-controls="collapseSystem3">
           <i class="fa-solid fa-circle-dollar-to-slot"></i>
               <span>Apoyos Económicos</span>
           </a>
           <div id="collapseSystem3" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
               <div class="py-0 collapse-inner rounded">
                    @if (Auth::user()->usertype == 1) 
                    <a class="nav-link" href="{{ route('apoyos.montos-index') }}"><i class="fa-solid fa-sack-dollar"></i>Montos </a>
                    @endif
                    @if (Auth::user()->usertype == 1 || Auth::user()->usertype == 3) 
                    <a class="nav-link" href="{{ route('apoyos.asignacion') }}"><i class="fa-solid fa-hand-holding-dollar"></i>Asignación </a>
                    @endif
         
               </div>
           </div>
           </li>
          @endif

            @if (Auth::user()->usertype == 1)  
             <!-- Divider -->
            <hr class="sidebar-divider"> 
            <li class="nav-item">
                <a class="nav-link" href="{{ route('usuarios.index') }}">
                    <i class="fas fa-user-cog"></i>
                    <span>Usuarios</span></a>
            </li>
            @endif

            {{-- @if (Auth::user()->usertype != 2)    
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSystem2"
                aria-expanded="true" aria-controls="collapseSystem2">
                <i class="fas fa-fw fa-cog"></i>
                    <span>Configuración</span>
                </a>
                <div id="collapseSystem2" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        {{-- <a class="collapse-item" href="{{ route('areas.index') }}">Dependencias </a>
                        <a class="collapse-item" href="{{ route('dias_descanso.index') }}">Días de descanso</a> --}}
                    {{-- </div>
                </div>
            </li>
            @endif --}}



            {{--
            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUser"
                    aria-expanded="true" aria-controls="collapseUser">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>User Management</span>
                </a>
                <div id="collapseUser" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="/">User</a>
                        <a class="collapse-item" href="cards.html">Role</a>
                        <a class="collapse-item" href="buttons.html">Permission</a>         
                    </div>
                </div>
            </li> --}}


            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>


        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->name }}</span>
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">

   
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                                     <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                        {{ __('Cerrar Sesión') }}
                                    </a>
                                    
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>

                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    @yield('content')
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Por Tiempos Mejores 2021-2024</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <script src="{{ asset('js/jquery.js') }}"></script>

    <!-- Bootstrap core JavaScript-->
    {{-- <script src="{{ mix('js/app.js') }}"></script> --}}

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('js/sb-admin.min.js') }}"></script>

    <!-- Multiple Select -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"> </script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"> </script> --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.min.js"></script>

    <!-- JavaScript para cargar y mostrar el archivo PDF con PDF.js -->
    <script>
        $(document).ready(function () {
            $('a.pdf-link').on('click', function () {
                var pdfUrl = $(this).attr('data-pdf-url');
                
                pdfjsLib.getDocument(pdfUrl).promise.then(function (pdfDoc_) {
                    var pdfDoc = pdfDoc_;
                    var numPages = pdfDoc.numPages;
    
                    var container = document.getElementById('pdfContainer');
                    container.innerHTML = '';
    
                    for (var pageNum = 1; pageNum <= numPages; pageNum++) {
                        pdfDoc.getPage(pageNum).then(function (page) {
                            var canvas = document.createElement('canvas');
                            var context = canvas.getContext('2d');
    
                            // Ajustar la escala para que el PDF se adapte al ancho de la ventana modal
                            var viewport = page.getViewport({ scale: container.clientWidth / page.getViewport({ scale: 1 }).width });
    
                            canvas.height = viewport.height;
                            canvas.width = viewport.width;
    
                            var renderContext = {
                                canvasContext: context,
                                viewport: viewport
                            };
    
                            page.render(renderContext).promise.then(function () {
                                container.appendChild(canvas);
                            });
                        });
                    }
                });
    
                $('#pdfPreviewModal').modal('show');
            });
        });
    </script>
    
</body>

</html>