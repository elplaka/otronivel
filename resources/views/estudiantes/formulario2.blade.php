<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
    
        <title>OTRO NIVEL - Información Personal</title>
    
        <!-- Custom fonts for this template-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link
            href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
            rel="stylesheet">
    
        <!-- Custom styles for this template-->
        <link href="{{ asset('css/sb-admin.min.css')}}" rel="stylesheet"> 
        <link rel="icon" type="image/png" href="{{ asset('Favicon.png') }}">

        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

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
    /* Asegura que el contenedor de la tarjeta no corte elementos */
    .card-body {
        overflow: visible !important;
    }

    /* Estilo para el botón en móviles */
    @media (max-width: 576px) {
        .btn-block-mobile {
            width: 100%; /* El botón se expande en móviles para no perderse */
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 12px;
            font-size: 1.1rem;
        }
        
        /* Ajuste de margen para la sección de soporte en móvil */
        .flex-grow-1 {
            margin-top: 20px;
        }
    }

    /* Evita que el float-right rompa el diseño si decides seguir usándolo */
    .clearfix::after {
        content: "";
        clear: both;
        display: table;
    }
    
     .bg-rojo {
            background-color: #7b003a; /* Color rojo en formato hexadecimal */
        }

    .btn-verde {
        background-color: #00656c;
        color: white;
        padding: 10px 35px;
        border-radius: 50px;
        font-weight: bold;
        transition: all 0.3s ease;
    }
  
    .btn-verde:hover {
      background-color: #4a826a; /* Cambia el color aquí al deseado cuando el mouse esté encima */
      color: white;
    }

    .btn-verde:active {
        background-color: #5ca265; /* Cambia el color aquí al deseado cuando el botón está activado (clic) */
        color: white;
    }

    :root {
        --rojo-institucional: #7b003a;
        --verde-boton: #28a745;
        --gris-fondo: #f8f9fc;
    }

    body {
        background-color: var(--gris-fondo);
    }

    /* Tarjeta principal con sombra suave */
    .custom-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        overflow: hidden;
        background: #fff;
    }

    /* Encabezado de sección */
    .section-header {
        background-color: var(--rojo-institucional);
        color: white;
        padding: 15px 25px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    /* Estilo de los inputs */
    .form-control {
        border-radius: 8px;
        padding: 12px;
        border: 1px solid #d1d3e2;
    }

    .form-control:focus {
        border-color: var(--rojo-institucional);
        box-shadow: 0 0 0 0.2rem rgba(123, 0, 58, 0.15);
    }

    /* Etiquetas */
    .form-label-custom {
        font-weight: 600;
        color: #4b4b4bff;
        margin-bottom: 5px;
    }

    /* Alerta de Importante */
    .alert-important {
        background-color: #fff3f5;
        border-left: 5px solid var(--rojo-institucional);
        border-radius: 8px;
        color: #333;
    }

    .help-icon {
        width: 16px;
        margin-left: 5px;
        opacity: 0.7;
    }

    .section-header-modern {
    background-color: #7b003a; /* Tu color rojo */
    padding: 1.25rem 1.5rem;
    border-radius: 12px 12px 0 0; /* Bordes redondeados solo arriba */
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.header-content {
    display: flex;
    align-items: center;
    color: #ffffff;
}

.header-content i {
    font-size: 1.2rem;
    margin-right: 15px;
    opacity: 0.9;
}

.header-text {
    font-size: 0.95rem;
    font-weight: 700;
    text-transform: uppercase;
    /* Aquí está la clave del espaciado moderno */
    letter-spacing: 2px; 
    font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
}

    .header-line {
        width: 40px;
        height: 3px;
        background-color: rgba(255, 255, 255, 0.4);
        border-radius: 2px;
        margin-left: 35px; /* Alineado con el inicio del texto */
    }

    /* 1. Estandarizar altura para TODOS los controles */
    .form-control, 
    select.form-control {
        height: 42px !important; /* Altura fija para alineación perfecta */
        padding: 8px 12px !important;
        font-size: 0.95rem !important;
        line-height: 1.2 !important; /* Ajuste para que el texto no se corte */
        border-radius: 8px !important;
        display: flex;
        align-items: center;
    }

    /* 2. Ajuste específico para Select (Navegadores Chrome/Safari) */
    select.form-control {
        appearance: auto; /* Asegura que la flechita y el texto se centren */
        -webkit-appearance: auto;
    }

    /* 3. Si usas la librería Select2 de JS (ajusta el contenedor) */
    .select2-container--default .select2-selection--single {
        height: 42px !important;
        border-radius: 8px !important;
        border: 1px solid #d1d3e2 !important;
        display: flex;
        align-items: center;
    }

    .select2-selection__rendered {
        line-height: 40px !important; /* Un poco menos que el contenedor para centrar */
        padding-left: 12px !important;
    }

    .select2-selection__arrow {
        height: 40px !important; /* Centra la flecha */
    }

    @media (max-width: 576px) {
        /* Esto quita el float en móviles y asegura que el botón respire */
        .btn-verde {
            float: none !important;
            width: 100%; /* El botón se adapta al ancho del cel, siendo más fácil de presionar */
            display: block;
            margin-bottom: 10px;
        }
        
        /* Evita que la tarjeta corte el contenido sombreado o botones */
        .card-body {
            padding-bottom: 2rem !important;
            overflow: visible !important;
        }
    }

    .container-adaptable {
        padding-bottom: 3rem !important; 
    }

    /* Estilo exclusivo para CELULARES */
    @media (max-width: 576px) {
        .container-adaptable {
            /* Aquí aplicamos el estiramiento que te funcionó */
            padding-bottom: 18rem !important; 
        }
        
        /* Opcional: un poco de aire extra al body para asegurar el scroll */
        body {
            min-height: 120vh; 
        }
    }
</style>


</head>
<body style="background-color:white">
<div class="container py-5 container-adaptable" >
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="text-center mb-4">
                <img src="../img/Logo_y_Escudo.jpg" 
                class="img-fluid mb-3" 
                style="width: 100%; max-width: 450px; height: auto;">
                <div class="mb-4">
                    <a href="{{ route('estudiantes.forget') }}">
                        <img src="../img/logo_programa.jpg" class="img-fluid" style="max-width: 300px;">
                    </a>
                </div>
                <h1 class="h3 font-weight-bold text-dark letter-spacing: 2px;">{{ __('FORMULARIO DE REGISTRO') }}</h1>
            </div>

            <div class="custom-card mb-4">
                <div class="section-header-modern">
                    <div class="header-content">
                        <i class="fas fa-user-edit"></i>
                        <span class="header-text">Información Personal</span>
                    </div>
                    <div class="header-line"></div>
                </div>

                <div class="card-body p-4">
                    @if (session()->has('message'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        {!! html_entity_decode(session()->get('message')) !!}
                    </div>
                    @endif

                    <form class="contact-form" method="POST" action="{{ route('estudiantes.formulario2.post') }}" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label-custom">{{ __('CURP') }}</label>
                                <input type="text" class="form-control @error('curp') is-invalid @enderror" name="curp" value="{{ old('curp', $estudiante->curp) }}" readonly style="background-color: #f1f3f9;">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label-custom">{{ __('Fecha de Nacimiento') }}</label>
                                <input type="date" class="form-control @error('fecha_nac') is-invalid @enderror" name="fecha_nac" value="{{ old('fecha_nac', $estudiante->fecha_nac) }}" required>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label-custom">{{ __('Nombre(s)') }}</label>
                                <input type="text" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{ old('nombre', $estudiante->nombre) }}" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label-custom">{{ __('Primer Apellido') }}</label>
                                <input type="text" class="form-control @error('primer_apellido') is-invalid @enderror" name="primer_apellido" value="{{ old('primer_apellido', $estudiante->primer_apellido) }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label-custom">{{ __('Segundo Apellido') }}</label>
                                <input type="text" class="form-control @error('segundo_apellido') is-invalid @enderror" name="segundo_apellido" value="{{ old('segundo_apellido', $estudiante->segundo_apellido) }}" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label-custom">
                                    {{ __('N° Celular') }}
                                    <img src="../img/help.jpg" class="help-icon" data-toggle="tooltip" title="Usa un número con WhatsApp activo.">
                                </label>
                                <input type="tel" class="form-control @error('celular') is-invalid @enderror" name="celular" value="{{ old('celular', $estudiante->celular) }}" maxlength="10" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label-custom">
                                    {{ __('E-mail') }}
                                    <img src="../img/help.jpg" class="help-icon" data-toggle="tooltip" title="Revisa que sea un correo válido para recibir tu archivo.">
                                </label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $estudiante->email) }}" required>
                            </div>

                            <div class="col-md-12 mb-4">
                                <label class="form-label-custom">{{ __('Lugar de Origen') }}</label>
                                <select name="cve_localidad_origen" class="form-control select2">
                                    @foreach ($localidades as $localidad)
                                        <option value="{{ $localidad->cve_localidad }}" {{ $localidad->cve_localidad == $estudiante->cve_localidad_origen? 'selected' : '' }}>
                                            {{ $localidad->localidad }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="alert-important p-3 mb-4">
                            <h5 class="font-weight-bold" style="color: var(--rojo-institucional);">¡¡ IMPORTANTE !!</h5>
                            <ul class="mb-0 pl-3 text-muted" style="font-size: 0.95rem; color: var(--rojo-institucional)!important;">
                                <li>El <b>número de celular</b> debe tener WhatsApp para recibir notificaciones.</li>
                                <li>El <b>e-mail</b> debe ser accesible; se enviará un archivo importante al finalizar.</li>
                            </ul>
                        </div>

                        <div class="d-flex justify-content-end mt-4 pb-4"> 
                            <button type="submit" class="btn btn-verde shadow-sm btn-final">
                                Siguiente <i class="fas fa-chevron-right ml-2"></i>
                            </button>
                        </div>
                    </form>
                    <div class="support-container mt-2">
                        <div class="p-3 rounded shadow-sm border-left-highlight" 
                            style="background: #ffffff; border: 1px solid #e3e6f0; border-left: 5px solid #7b003a; font-size: 0.9rem;">
                            
                            <div class="row align-items-center">
                                <div class="col-md-6 mb-3 mb-md-0 border-right-md">
                                    <div class="d-flex align-items-center">
                                        <div class="icon-circle bg-whatsapp-light mr-3">
                                            <i class="fab fa-whatsapp" style="color: #25D366; font-size: 1.4rem;"></i>
                                        </div>
                                        <div>
                                            <span class="text-muted d-block small uppercase font-weight-bold">¿Necesitas ayuda?</span>
                                            <a href="javascript:void(0);" onclick="openWhatsApp('526949568140')" 
                                            class="support-link" style="color: #7b003a; font-size: 1.1rem; font-weight: 700; text-decoration: none;">
                                            694 956 8140
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="d-flex align-items-start">
                                        <i class="fas fa-university mr-3 mt-1 text-muted" style="font-size: 1.1rem;"></i>
                                        <div>
                                            <span class="text-muted d-block small uppercase font-weight-bold">Atención Presencial</span>
                                            <span class="text-dark">
                                                Presidencia Municipal <br>
                                                <small class="text-secondary">
                                                    <i class="far fa-clock mr-1"></i> Lunes a Viernes • 8:30 a.m. a 3:00 p.m.
                                                </small>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <style>
                        .bg-whatsapp-light {
                            background-color: #e8f9ee;
                            width: 45px;
                            height: 45px;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            border-radius: 50%;
                        }
                        .border-left-highlight {
                            transition: transform 0.2s ease;
                        }
                        .border-left-highlight:hover {
                            transform: translateY(-2px);
                        }
                        .support-link:hover {
                            color: #a3004d !important;
                        }
                        .uppercase { text-transform: uppercase; letter-spacing: 0.5px; }
                        
                        @media (min-width: 768px) {
                            .border-right-md { border-right: 1px solid #e3e6f0; }
                        }
                    </style>
                </div>
            </div>
        </div>
    </div>
</div>
    <script>
        function openWhatsApp(phoneNumber) {
            //var phoneNumber = "526692295855"; // Coloca el número de teléfono sin el signo "+"
            var isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
            var url = isMobile ? "https://api.whatsapp.com/send?phone=" : "https://web.whatsapp.com/send?phone=";
    
            window.open(url + phoneNumber, "_blank");
        }
    </script>

    {{-- <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a> --}}
    <script src="{{ asset('js/jquery.js') }}"></script>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ mix('js/app.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('js/sb-admin.min.js') }}"></script>
</body>
</html>