<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Sistema OTRO NIVEL</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.4.120/pdf.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qr.js/1.0.0/qr.min.js"></script>
    <link rel="icon" type="image/png" href="{{ asset('Favicon.png') }}">
    <link href="{{ asset('css/sb-admin.min.css')}}" rel="stylesheet">
    
    <style>
        /* --- ESTRUCTURA GENERAL --- */
        #wrapper { display: flex; }
        #content-wrapper { width: 100%; overflow-y: auto; background-color: #f4f7f6; }

        /* --- SIDEBAR REDISEÑADO --- */
        #accordionSidebar {
            width: 250px !important; /* Ajusta este valor al ancho deseado */
            min-width: 250px;
            background: linear-gradient(180deg, #7b003a 0%, #4a0022 100%);
            box-shadow: 4px 0 15px rgba(0,0,0,0.1);
            border-right: none;
            height: 100vh;
            position: sticky;
            top: 0;
            z-index: 1000;
            transition: all 0.3s ease-in-out;
            /* Flexbox para empujar el footer al fondo */
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
        }

        .sidebar-brand {
            height: auto !important;
            padding: 1rem 0.5rem;
            margin-bottom: 0.5rem;
        }

        .sidebar-brand-icon i {
            font-size: 1.8rem;
            filter: drop-shadow(0px 4px 4px rgba(0,0,0,0.2));
        }

        .sidebar-brand-text {
            font-weight: 800;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        /* --- ITEMS DEL MENÚ --- */
        .nav-item .nav-link {
            margin: 0.2rem 0.8rem;
            border-radius: 12px;
            transition: all 0.2s;
            font-weight: 600;
            padding: 0.8rem 1rem !important;
            width: auto;
        }

        .nav-item .nav-link:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateX(5px);
        }

        .nav-item .nav-link i {
            font-size: 1rem;
            margin-right: 0.75rem;
            opacity: 0.8;
        }

        .nav-item.active .nav-link {
            background: rgba(255, 255, 255, 0.15);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            transform: none; /* Recomendado: quitar el desplazamiento en el activo para que sea estable */
            margin-right: 0.8rem; /* Forzar que respete el margen derecho */
        }

        /* Submenús */
        .collapse-inner {
            background: #ffffff !important;
            border-radius: 10px !important;
            margin: 0 0.8rem 0.5rem 0.8rem;
            box-shadow: inset 0 2px 4px rgba(0,0,0,0.05);
        }

        .collapse-item {
            font-weight: 600 !important;
            font-size: 0.8rem !important;
            border-radius: 6px;
            margin: 2px 8px;
        }

        .collapse-item:hover {
            background-color: #f8f9fc !important;
            color: #7b003a !important;
        }

        /* --- FOOTER DE USUARIO OSCURECIDO --- */
        .sidebar-user-footer {
            background: rgba(0, 0, 0, 0.2); /* Fondo más oscuro */
            margin-top: auto; /* Empuja al fondo */
            border-top: 1px solid rgba(255,255,255,0.08);
            padding: 1.2rem 1rem !important;
            transition: all 0.3s;
        }

        .user-avatar-circle {
            width: 38px;
            height: 38px;
            min-width: 38px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #7b003a; 
        }

        .user-name-text {
            font-size: 0.85rem;
            font-weight: 700;
            color: #ffffff;
            line-height: 1.2;
        }

        .user-status-text {
            font-size: 0.65rem;
            color: rgba(255,255,255,0.7);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .online-indicator {
            width: 7px;
            height: 7px;
            background-color: #2ecc71;
            border-radius: 50%;
            display: inline-block;
            box-shadow: 0 0 5px #2ecc71;
        }

        /* --- DROPDOWN TECH --- */
        .dropdown-menu-tech {
            background-color: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 10px;
            padding: 4px;
            min-width: 190px;
            margin-bottom: 12px !important; 
        }

        .logout-item {
            padding: 4px 6px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            transition: all 0.2s ease;
        }

        .logout-item:hover {
            background: rgba(0,0,0,0.05);
            text-decoration: none;
        }

        .logout-icon-wrapper {
            width: 32px;
            height: 32px;
            min-width: 32px;
            background: rgba(229, 62, 62, 0.1);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #e53e3e;
            font-size: 0.9rem;
        }

        /* --- UI MODAL TECH --- */
        .modal-header-tech {
            background: #ffffff;
            border-bottom: 1px solid #edf2f7;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
        }

        /* --- RESPONSIVE / TOGGLED --- */
        .sidebar.toggled { width: 6.5rem !important; }
        .sidebar.toggled .sidebar-user-info, 
        .sidebar.toggled .sidebar-brand-text,
        .sidebar.toggled .user-status-text { display: none; }
        .sidebar.toggled .nav-item .nav-link span { display: none; }
        .sidebar.toggled .sidebar-user-footer { padding: 0.8rem !important; text-align: center; }

        .btn-verde {
            background-color: #00656c;
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
                
        #pdfContainer canvas { max-width: 100%; height: auto !important; margin-bottom: 20px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
    
        /* --- SUBMENÚS REDISEÑADOS --- */
        .collapse-inner {
            background: rgba(0, 0, 0, 0.15) !important; /* Fondo oscuro sutil en lugar de blanco */
            border-radius: 12px !important;
            margin: 0 0.8rem 0.5rem 1.5rem !important; /* Más margen a la izquierda para jerarquía */
            box-shadow: none !important;
            border-left: 2px solid rgba(255, 255, 255, 0.2); /* Línea guía lateral */
        }

        .collapse-item {
            color: rgba(255, 255, 255, 0.8) !important; /* Texto claro para que combine */
            font-weight: 500 !important;
            font-size: 0.85rem !important;
            padding: 0.6rem 1rem !important;
            margin: 2px 5px !important;
            transition: all 0.2s ease;
        }

        .collapse-item:hover {
            background-color: rgba(255, 255, 255, 0.1) !important;
            color: #ffffff !important;
            transform: translateX(3px);
            text-decoration: none;
        }

        /* Cuando el item está activo dentro del submenú */
        .collapse-item.active {
            background-color: rgba(255, 255, 255, 0.05) !important;
            color: #ffffff !important;
            /* font-weight: 800 !important; */
            box-shadow: inset 3px 0 0 #ffffff;
        }

        /* Ajuste del icono de la flecha del menú padre */
        .nav-link.collapsed::after {
            color: rgba(255, 255, 255, 0.5);
        }

        .nav-item .collapse.show {
            display: block !important;
        }
    
    </style>
</head>

<body id="page-top">

    <?php 
        $configFilePath = config_path('ciclo_actual.ini');
        $config = parse_ini_file($configFilePath, true);
        $cicloActual = $config['Ciclo']['CicloActual'];
        $ciclo_escolar = "20" . substr($cicloActual, 0, 2) . "-20" . substr($cicloActual, 2, 2); 
    ?>
    <div id="wrapper">
        <ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/home') }}">
                <div class="sidebar-brand-icon">
                    <i class="fa-solid fa-graduation-cap"></i>
                </div>
                <div class="sidebar-brand-text mx-3">OTRO NIVEL</div>
            </a>
            <div class="text-center text-white-50 mb-3" style="font-size: 14px; font-weight: 700; letter-spacing: 1px;">
                CICLO {{ $ciclo_escolar }}
            </div>

            @if (Auth::user()->usertype >= 1)
            <li class="nav-item {{ Request::is('estudiantes*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('estudiantes.index') }}">
                    <i class="fas fa-fw fa-user-graduate"></i>
                    <span>Estudiantes</span>
                </a>
            </li>
            @endif

            @if (Auth::user()->usertype == 1 || Auth::user()->usertype == 3)
            <li class="nav-item">
                <a class="nav-link {{ Request::is('boletos/remesas*') || Request::is('apoyos/montos*') || Request::is('apoyos/asignacion*') ? '' : 'collapsed' }}" 
                href="#" data-toggle="collapse" data-target="#collapseApoyos" 
                aria-expanded="{{ Request::is('boletos/remesas*') || Request::is('apoyos/montos*') || Request::is('apoyos/asignacion*') ? 'true' : 'false' }}">
                    <i class="fa-solid fa-hand-holding-dollar"></i>
                    <span>Apoyos Económicos</span>
                </a>
                
                <div id="collapseApoyos" class="collapse {{ Request::is('boletos/remesas*') || Request::is('apoyos/montos*') || Request::is('apoyos/asignacion*') ? 'show' : '' }}" 
                    data-parent="#accordionSidebar">
                    <div class="py-2 collapse-inner">
                        @if (Auth::user()->usertype == 1)
                            <a class="collapse-item {{ Request::is('boletos/remesas*') ? 'active' : '' }}" href="{{ route('boletos.remesas-index') }}">
                                Remesas
                            </a>
                            <a class="collapse-item {{ Request::is('apoyos/montos*') ? 'active' : '' }}" href="{{ route('apoyos.montos-index') }}">
                                Montos
                            </a>
                        @endif
                        <a class="collapse-item {{ Request::is('apoyos/asignacion*') ? 'active' : '' }}" href="{{ route('apoyos.asignacion') }}">
                            Asignación
                        </a>
                    </div>
                </div>
            </li>
            @endif

            @if (Auth::user()->usertype == 1)
            <li class="nav-item {{ Request::is('usuarios*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('usuarios.index') }}">
                    <i class="fas fa-fw fa-shield-halved"></i>
                    <span>Gestión Usuarios</span>
                </a>
            </li>
            @endif

            <div class="sidebar-user-footer">
                <div class="dropdown dropup no-arrow"> 
                    <a class="dropdown-toggle d-flex align-items-center text-decoration-none" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="user-avatar-circle mr-2 shadow-sm">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="sidebar-user-info overflow-hidden">
                            <p class="user-name-text mb-0 text-truncate">{{ Auth::user()->name }}</p>
                            <p class="mb-0 text-truncate" style="color:white; font-size:0.75em" title="{{ Auth::user()->email }}">{{ Auth::user()->email }}</p>
                            <div class="d-flex align-items-center">
                                <span class="online-indicator mr-1"></span>
                                <span class="user-status-text">En línea</span>
                            </div>
                        </div>
                    </a>
                    
                    <div class="dropdown-menu dropdown-menu-tech shadow-lg animated--fade-in" aria-labelledby="userDropdown">
                        <a class="dropdown-item logout-item" href="{{ route('logout') }}" 
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <div class="logout-icon-wrapper mr-3">
                                <i class="fas fa-sign-out-alt"></i>
                            </div>
                            <div>
                                <span class="d-block font-weight-bold text-dark">Cerrar Sesión</span>
                                <small class="text-muted">Finalizar sesión actual</small>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <div class="text-center d-none d-md-inline mb-3 mt-3">
                <button class="rounded-circle border-0" id="sidebarToggle" style="background: rgba(255,255,255,0.1); color: white;"></button>
            </div>
        </ul>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <div class="container-fluid pt-4">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="pdfPreviewModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 15px;">
                <div class="modal-header modal-header-tech align-items-center py-3 px-4">
                    <div class="d-flex align-items-center flex-grow-1">
                        <div class="pdf-icon-container mr-3" style="width: 42px; height: 42px; background: #fff5f5; color: #e53e3e; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-file-pdf"></i>
                        </div>
                        <div class="flex-column">
                            <div class="d-flex align-items-center">
                                <h5 class="modal-title font-weight-bold mb-0 text-dark" id="pdfPreviewModalLabel">Visualizador</h5>
                                <span class="status-badge-modern ml-3" style="background-color: #f0fff4; color: #2f855a; font-size: 0.7rem; padding: 2px 10px; border-radius: 20px; font-weight: 600; border: 1px solid #c6f6d5;"><i class="fas fa-shield-alt mr-1"></i> Protegido</span>
                            </div>
                            <small class="text-muted">Expediente Digital del Estudiante</small>
                        </div>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" style="outline: none; font-size: 2rem;">&times;</button>
                </div>
                <div class="modal-body bg-light p-0" style="height: 75vh; overflow-y: auto;">
                    <div id="pdf-loader" class="text-center py-5" style="display:none;">
                        <div class="spinner-border text-danger" role="status"></div>
                        <p class="mt-2 text-muted">Cargando documento...</p>
                    </div>
                    <div id="pdfContainer" class="p-4 d-flex flex-column align-items-center"></div>
                </div>
            </div>
        </div>
    </div>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/sb-admin.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

    <script>
        $(document).ready(function () {
            const setupFile = (btn, input, label) => {
                $(btn).click(() => $(input).trigger('click'));
                $(input).change(function() {
                    let filename = $(this).val().split('\\').pop();
                    $(label).html(filename || "Sin archivo");
                });
            };

            setupFile('#sel_archivo_curp', '#img_curp', '#archivo_curp');
            setupFile('#sel_archivo_acta_nac', '#img_acta_nac', '#archivo_acta_nac');
            setupFile('#sel_archivo_comprobante_dom', '#img_comprobante_dom', '#archivo_comprobante_dom');
            setupFile('#sel_archivo_identificacion', '#img_identificacion', '#archivo_identificacion');
            setupFile('#sel_archivo_kardex', '#img_kardex', '#archivo_kardex');
            setupFile('#sel_archivo_constancia', '#img_constancia', '#archivo_constancia');

            $('a.pdf-link').on('click', function (e) {
                e.preventDefault();
                const pdfUrl = $(this).attr('data-pdf-url');
                const docTitle = $(this).attr('data-title') || "Documento";
                
                $('#pdfPreviewModalLabel').text(docTitle);
                $('#pdfContainer').empty();
                $('#pdf-loader').show();
                $('#pdfPreviewModal').modal('show');

                const loadingTask = pdfjsLib.getDocument(pdfUrl);
                loadingTask.promise.then(pdf => {
                    $('#pdf-loader').hide();
                    for (let n = 1; n <= pdf.numPages; n++) {
                        pdf.getPage(n).then(page => {
                            const scale = 1.5;
                            const viewport = page.getViewport({ scale });
                            const canvas = document.createElement('canvas');
                            const context = canvas.getContext('2d');
                            canvas.height = viewport.height;
                            canvas.width = viewport.width;

                            const renderCtx = { canvasContext: context, viewport: viewport };
                            page.render(renderCtx).promise.then(() => {
                                document.getElementById('pdfContainer').appendChild(canvas);
                            });
                        });
                    }
                }).catch(err => {
                    $('#pdf-loader').hide();
                    $('#pdfContainer').html('<div class="alert alert-danger mt-5">Error al cargar PDF: ' + err.message + '</div>');
                });
            });

            $('.search_select_box select').selectpicker();
        });
    </script>
</body>
</html>