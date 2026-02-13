@extends('layouts.main')

<!-- Ventana modal para mostrar los archivos PDF -->
<!-- <div class="modal fade" id="pdfPreviewModal" tabindex="-1" role="dialog" aria-labelledby="pdfPreviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h5 class="modal-title font-weight-bold" id="pdfPreviewModalLabel">
                    <i class="fas fa-file-pdf mr-2"></i> Vista Preliminar de Archivo PDF
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <div class="modal-body p-0" style="background-color: #525659; overflow-y: auto;">
                <div id="pdfContainer" class="mx-auto" style="width: 100%; max-width: 900px; height: 80vh; display: block;">
                    {{-- Aquí se inyecta el PDF --}}
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary shadow-sm" data-dismiss="modal">Cerrar Visualizador</button>
            </div>
        </div>
    </div>
</div> -->

<style>
    /* Fondo del cuerpo del modal estilo visor profesional */
    /* .modern-pdf-body {
        background-color: #ffffffff !important; 
        position: relative;
        overflow-y: auto !important;
        scrollbar-width: thin;
        scrollbar-color: #646464ff #dfdfdfff;
    } */
/* 
    .modern-pdf-body {
        background-color: #333 !important;
        height: 80vh !important;
        overflow: auto !important; 
        display: block !important;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }

    #pdfContainer {
        display: inline-block; 
        min-width: 100%;
        text-align: center;
        padding: 20px;
    }

    #pdfContainer canvas {
        image-rendering: -webkit-optimize-contrast !important; 
        image-rendering: crisp-edges !important;               
        image-rendering: pixelated;                            
        display: block;
        margin: 0 auto 20px auto;
        box-shadow: 0 0 20px rgba(0,0,0,0.5);
        
        max-width: none !important; 
        width: auto !important;
        
        min-width: 1100px; 

        image-rendering: auto !important; 
    filter: contrast(1.1) brightness(1.05);
    } */

    /* 1. Body SOLO scroll vertical */
.modern-pdf-body {
    background-color: #333 !important;
    height: 80vh !important;
    overflow-y: auto !important;    /* ✅ Solo vertical */
    overflow-x: hidden !important;  /* ❌ No horizontal */
    display: block !important;
}

/* 2. Contenedor flex */
#pdfContainer {
    display: flex !important;
    flex-direction: column !important;
    align-items: center !important;
    width: 100% !important;
    min-width: 100% !important;
    padding: 20px;
    box-sizing: border-box;
}

/* 3. Canvas - AHORA SÍ SE ADAPTAN */
#pdfContainer canvas {
    max-width: 100% !important;     /* ✅ NUNCA se desborda */
    width: 100% !important;
    height: auto !important;
    min-width: 0 !important;        /* ✅ Elimina el mínimo fijo */
    
    /* Resto de estilos se mantienen */
    image-rendering: -webkit-optimize-contrast;
    image-rendering: crisp-edges;
    display: block;
    margin: 0 auto 20px auto;
    box-shadow: 0 0 20px rgba(0,0,0,0.5);
    filter: contrast(1.1) brightness(1.05);
}

/* Animación suave para las páginas */
.pdf-page {
    animation: fadeIn 0.4s ease-in-out;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}



    /* Scrollbar estilizado para Chrome/Safari */
    .modern-pdf-body::-webkit-scrollbar {
        width: 8px;
    }
    .modern-pdf-body::-webkit-scrollbar-track {
        background: #2c2e31;
    }
    .modern-pdf-body::-webkit-scrollbar-thumb {
        background: #565656ff;
        border-radius: 10px;
    }


    /* Clase para inyectar al canvas o elemento del PDF */
    /* #pdfContainer canvas, .pdf-canvas-item {
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.6) !important;
        border-radius: 4px;
        transition: transform 0.3s ease;
    } */

    /* Header y Footer Modernos */
    .modal-header-tech {
        background: #f8f9fa;
        border-bottom: 2px solid #7b003a;
    }

    .modal-footer-tech {
        background: #f8f9fa;
        border-top: 1px solid #dee2e6;
    }

    .status-badge {
        font-size: 0.75rem;
        padding: 4px 12px;
        border-radius: 20px;
        background: rgba(255, 255, 255, 0.1);
        color: #7b003a;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    /* Fuerza que el modal esté oculto si no tiene la clase 'show' */
    #pdfPreviewModal:not(.show) {
        display: none !important;
    }
</style>

<div class="modal fade" id="pdfPreviewModal" tabindex="-1" role="dialog" aria-labelledby="pdfPreviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content border-0 shadow-lg">
            
            <div class="modal-header modal-header-tech d-flex align-items-center py-3">
                <div class="d-flex align-items-center">
                    <div class="bg-white rounded-circle shadow-sm d-flex align-items-center justify-content-center mr-3" style="width: 40px; height: 40px;">
                        <i class="fas fa-file-pdf text-danger" style="font-size: 1.3rem;"></i>
                    </div>
                    <div>
                        <h5 class="modal-title font-weight-bold mb-0" id="pdfPreviewModalLabel" style="color: #2c3e50;">
                            Visualizador de Documentos
                        </h5>
                        <span class="status-badge">
                            <i class="fas fa-shield-alt mr-1"></i> Entorno Seguro
                        </span>
                    </div>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar" style="outline: none;">
                    <span aria-hidden="true" style="font-size: 1.5rem;">&times;</span>
                </button>
            </div>
            
            <div class="modal-body p-0 modern-pdf-body">
                <div id="pdf-loader" class="text-center text-white mt-5 loading-placeholder">
                    <div class="spinner-border text-light mb-2" role="status"></div>
                    <p class="small">Procesando documento...</p>
                </div>
                <div id="pdfContainer" class="mx-auto">
                    {{-- El JS debe inyectar el canvas aquí --}}

                </div>
            </div>

            <div class="modal-footer modal-footer-tech">
                <div class="container-fluid">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <small class="text-muted d-none d-md-block">
                                <i class="fas fa-mouse-pointer mr-1"></i> Deslice para ver toda la información
                            </small>
                        </div>
                        <div class="col-12 col-md-6 text-right">
                            <button type="button" class="btn btn-rojo px-4 shadow-sm" data-dismiss="modal" style="border-radius: 8px; font-weight: 600;">
                                <i class="fas fa-circle-xmark mr-2"></i>Cerrar Visualizador
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('content')
<?php 
    $nomActa = substr($estudiante->img_acta_nac,0,strlen($estudiante->img_acta_nac)-3);
    $extActa = strtoupper(substr(strrchr($estudiante->img_acta_nac, "."), 1));
    $archivoActa = $nomActa . $extActa;

    $nomComprobante = substr($estudiante->img_comprobante_dom,0,strlen($estudiante->img_comprobante_dom)-3);
    $extComprobante = strtoupper(substr(strrchr($estudiante->img_comprobante_dom, "."), 1));
    $archivoComprobante = $nomComprobante . $extComprobante;

    $nomIdentificacion = substr($estudiante->img_identificacion,0,strlen($estudiante->img_identificacion)-3);
    $extIdentificacion = strtoupper(substr(strrchr($estudiante->img_identificacion, "."), 1));
    $archivoIdentificacion = $nomIdentificacion . $extIdentificacion;

    $nomKardex = substr($estudiante->img_kardex,0,strlen($estudiante->img_kardex)-3);
    $extKardex = strtoupper(substr(strrchr($estudiante->img_kardex, "."), 1));
    $archivoKardex = $nomKardex . $extKardex;

    $nomConstancia = substr($estudiante->img_constancia,0,strlen($estudiante->img_constancia)-3);
    $extConstancia = strtoupper(substr(strrchr($estudiante->img_constancia, "."), 1));
    $archivoConstancia = $nomConstancia . $extConstancia;
?>

    <style>
        .form-container-custom {
            background-color: #fcfcfc;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
            border: none;
            overflow: hidden;
        }
        
        .btn-back {
            color: #6c757d;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            font-size: 0.9rem;
        }
        
        .btn-back:hover {
            color: #dc3545;
            text-decoration: none;
            transform: translateX(-5px);
        }

        .form-header-title {
            color: #2d3436;
            letter-spacing: -0.5px;
            position: relative;
        }

        .form-header-title::after {
            content: '';
            display: block;
            width: 50px;
            height: 4px;
            background: #dc3545;
            margin: 10px auto 0;
            border-radius: 10px;
        }

        .modern-alert {
            border: none;
            border-left: 5px solid;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }

        .bg-guinda-modern {
        background: linear-gradient(45deg, #7b003a, #892641);
        color: white;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 0.9rem;
        border: none;
        }

        .form-section-card {
            border: 1px solid #edf2f7;
            border-radius: 12px;
            overflow: hidden;
            margin-bottom: 2rem;
        }
        .input-group-text-modern {
            background-color: #f8f9fa;
            border-right: none;
            color: #6c757d;
        }
        .form-control-modern {
            border-left: none;
            padding-left: 0;
        }
        .form-control-modern:focus {
            border-color: #ced4da;
            box-shadow: none;
        }
        .input-group:focus-within .input-group-text-modern,
        .input-group:focus-within .form-control-modern {
            border-color: #800020;
            background-color: #fff;
        }
        .whatsapp-icon {
            background-color: #25D366;
            color: white;
            padding: 8px 12px;
            border-radius: 8px;
            transition: transform 0.2s;
        }
        .whatsapp-icon:hover {
            transform: scale(1.1);
            color: white;
        }

        /* Estilo para el botón que genera el Selectpicker */
        .bootstrap-select .dropdown-toggle {
            background-color: #fff !important;
            border: 1px solid #ced4da !important; /* El borde estándar de tus otros inputs */
            border-radius: 6px !important;
            padding: 0.6rem 1rem !important;
            height: calc(1.5 em + 1.25 rem + 2 px); /* Ajuste para igualar altura */
            transition: all 0.2s ease-in-out;
            color:#6c757d!important;
        }

        /* Efecto focus para que brille igual que los demás */
        .bootstrap-select .dropdown-toggle:focus, 
        .bootstrap-select.show .dropdown-toggle {
            border-color: #800020 !important; /* Tu color guinda */
            box-shadow: 0 0 0 0.2rem rgba(128, 0, 32, 0.15) !important;
            outline: none !important;
        }

        .bootstrap-select .filter-option {
            line-height: 18px;
            height: 18px;
            display: flex;
            align-items: center;
        }

        /* 1. Color del ítem cuando está seleccionado (Checkmark activo) */
        .bootstrap-select .dropdown-menu li.active a,
        .bootstrap-select .dropdown-menu li.selected a {
            background-color: #800020 !important; /* Tu color guinda */
            color: white !important;
            font-weight: bold!important;
            font-size: 1.2em!important;
        }

        /* 2. Color del ítem cuando pasas el cursor (Hover) */
        .bootstrap-select .dropdown-menu li a:hover {
            background-color: #939393ff !important; /* Un guinda un poco más claro para el hover */
            color: white !important;
        }

        /* 3. Ajuste para el color de la "palomita" (check icon) si lo usas */
        .bootstrap-select .dropdown-menu li.selected a span.check-mark {
            color: white !important;
        }

        /* Aplica el borde guinda al contenedor de la lista desplegable */
        .bootstrap-select .dropdown-menu {
            border: 2px solid #800020 !important; /* Borde guinda de 2px */
            border-radius: 8px !important;
            box-shadow: 0 10px 25px rgba(0,0,0,0.15) !important; /* Sombra para dar profundidad */
            overflow: hidden; /* Asegura que los items no se salgan del borde redondeado */
            margin-top: 2px !important; /* Separación mínima del input */
            margin-bottom: 2px !important; /* Separación mínima del input */
        }

        /* 2. Quita el borde o sombra del contenedor interno que causa la duplicidad */
        .bootstrap-select .dropdown-menu .inner {
            border: none !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        /* 3. Asegura que los items no tengan bordes propios */
        .bootstrap-select .dropdown-menu li {
            border: none !important;
        }
        
   
        .btn-outline-guinda {
            color: #932f4a;
            border-color: #932f4a;
            background-color: transparent;
            transition: all 0.2s ease-in-out;
            font-weight: 600;
        }

        .btn-outline-guinda:hover {
            color: #ffffff;
            background-color: #932f4a; /* Se llena de guinda al pasar el mouse */
            border-color: #932f4a;
        }

        .btn-outline-guinda:focus, .btn-outline-guinda.focus {
            box-shadow: 0 0 0 0.2rem rgba(128, 0, 32, 0.25);
        }

        /* Ajuste para que el icono de ojo también cambie de color en el hover */
        .btn-outline-guinda:hover i {
            color: #ffffff !important;
        }
        
        .btn-outline-guinda i {
            color: #932f4a;
            margin-right: 4px;
        }

        #container-status {
            box-shadow: inset 0 0 10px rgba(0,0,0,0.05);
        }
        

        /* Animación suave */
        .transition-all {
            transition: all 0.4s ease;
        }

        .btn-guinda-solid {
            background-color: #00656c;
            border-color: #00656c;
            color: #ffffff;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-radius: 50px; /* Bordes redondeados tipo píldora */
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .btn-guinda-solid:hover {
            background-color: #004d52ff; /* Un guinda un poco más oscuro */
            color: #ffffff;
            transform: translateY(-2px); /* Pequeño salto hacia arriba */
            box-shadow: 0 5px 15px rgba(0, 128, 41, 0.3) !important;
        }

        .btn-guinda-solid:active {
            transform: translateY(0);
        }
    </style>

            <div class="container py-5">
                <div class="row justify-content-center">
                    <div class="col-md-10 col-lg-9">
                        
                        <div class="d-flex justify-content-start mb-4">
                            <a href="{{ route('estudiantes.index') }}" class="btn-back">
                                <i class="fas fa-arrow-left mr-2"></i> {{ __('Regresar') }}
                            </a>
                        </div>

                        <div class="card form-container-custom">
                            <form action="{{ route('estudiantes.update', $estudiante->id) }}" method="POST">
                            @csrf
                            <div class="card-body p-4 p-md-8">                                
                                <div class="text-center mb-3">
                                    <h1 class="h3 form-header-title font-weight-bold">
                                        {{ __('Registro del Estudiante') }}
                                    </h1>
                                    <p class="text-muted small mt-2">Actualice la información necesaria del perfil</p>
                                </div>

                                @if (session()->has('message'))
                                    @php $msg_type = session()->get('msg_type', 'info'); @endphp
                                    <div class="alert alert-{{ $msg_type }} alert-dismissible fade show modern-alert mb-4" role="alert">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-info-circle mr-3"></i>
                                            <div>
                                                {!! html_entity_decode(session()->get('message')) !!}
                                            </div>
                                        </div>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif
                                <div class="card form-section-card shadow-sm">
                                     <div class="card-header bg-guinda-modern py-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span>  <i class="fas fa-user-circle mr-2"></i>
                                            <b>I. INFORMACIÓN PERSONAL</b></span>
                                            <span class="small opacity-75">Datos de contacto</span>
                                        </div>
                                    </div>

                                    <div class="card-body p-4">
                                        {{-- Manejo de Errores Mejorado --}}
                                        @if ($errors->any())
                                            <div class="alert alert-danger border-0 shadow-sm mb-4">
                                                <div class="d-flex">
                                                    <i class="fas fa-exclamation-triangle mt-1 mr-3"></i>
                                                    <div>
                                                        <ul class="mb-0 pl-3">
                                                            @foreach ($errors->all() as $error)
                                                                <li>{{ $error }}</li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                                <button type="button" class="close text-white" data-dismiss="alert">&times;</button>
                                            </div>
                                        @endif

                                        <div class="row">
                                            {{-- CURP (Solo lectura) --}}
                                            <div class="col-md-6 mb-3">
                                                <label class="font-weight-bold small text-uppercase text-muted">{{ __('CURP') }}</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text input-group-text-modern"><i class="fas fa-id-card"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control form-control-modern bg-light" 
                                                        name="curp" value="{{ old('curp', $estudiante->curp) }}" 
                                                        maxlength="18" readonly>
                                                </div>
                                            </div>

                                            {{-- Nombre --}}
                                            <div class="col-md-6 mb-3">
                                                <label class="font-weight-bold small text-uppercase text-muted">{{ __('Nombre(s)') }}</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text input-group-text-modern"><i class="fas fa-user"></i></span>
                                                    </div>
                                                    <input id="nombre" type="text" class="form-control form-control-modern @error('nombre') is-invalid @enderror" 
                                                        name="nombre" value="{{ old('nombre', $estudiante->nombre) }}" required>
                                                </div>
                                            </div>

                                            {{-- Apellidos --}}
                                            <div class="col-md-6 mb-3">
                                                <label class="font-weight-bold small text-uppercase text-muted">{{ __('Primer Apellido') }}</label>
                                                <input id="primer_apellido" type="text" class="form-control @error('primer_apellido') is-invalid @enderror" 
                                                    name="primer_apellido" value="{{ old('primer_apellido', $estudiante->primer_apellido) }}" required>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label class="font-weight-bold small text-uppercase text-muted">{{ __('Segundo Apellido') }}</label>
                                                <input id="segundo_apellido" type="text" class="form-control @error('segundo_apellido') is-invalid @enderror" 
                                                    name="segundo_apellido" value="{{ old('segundo_apellido', $estudiante->segundo_apellido) }}" required>
                                            </div>

                                            {{-- Fecha Nacimiento --}}
                                            <div class="col-md-3 mb-3">
                                                <label class="font-weight-bold small text-uppercase text-muted">{{ __('Fecha de Nac.') }}</label>
                                                <input id="fecha_nac" type="date" class="form-control @error('fecha_nac') is-invalid @enderror" 
                                                    name="fecha_nac" value="{{ old('fecha_nac', $estudiante->fecha_nac) }}" required>
                                            </div>

                                            {{-- Celular con WhatsApp --}}
                                            <div class="col-md-3 mb-3">
                                                <label class="font-weight-bold small text-uppercase text-muted">{{ __('N° Celular') }}</label>
                                                <div class="d-flex gap-2">
                                                    <input id="celular" type="tel" class="form-control @error('celular') is-invalid @enderror" 
                                                        name="celular" value="{{ old('celular', $estudiante->celular) }}" 
                                                        maxlength="10" required>
                                                    <a href="javascript:void(0);" onclick="openWhatsApp({{ $estudiante->celular }})" 
                                                    class="whatsapp-icon ml-2 d-flex align-items-center justify-content-center" 
                                                    style="height: 38px; width: 38px;"
                                                    title="Contactar por WhatsApp">
                                                        <i class="fab fa-whatsapp" style="font-size: 1.2rem;"></i>
                                                    </a>
                                                </div>
                                            </div>

                                            {{-- E-mail --}}
                                            <div class="col-md-6 mb-3">
                                                <label class="font-weight-bold small text-uppercase text-muted">{{ __('E-mail') }}</label>
                                                <input id="email" name="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                                                    value="{{ old('email', $estudiante->email) }}" maxlength="40" required>
                                            </div>

                                            {{-- Lugar de Origen --}}
                                            <div class="col-12 mb-3">
                                                <label class="font-weight-bold small text-uppercase text-muted">
                                                    {{ __('Lugar de Origen') }}
                                                </label>
                                                
                                                <select id="cve_localidad_origen" 
                                                        name="cve_localidad_origen" 
                                                        class="form-control selectpicker" 
                                                        data-container="body" {{-- 1. Evita que se corte --}}
                                                        data-dropup-auto="false" {{-- 2. Fuerza despliegue hacia abajo --}}
                                                        data-style="btn-white" {{-- Esto ayuda a resetear el estilo base --}}
                                                        data-size="5"
                                                        title="Seleccione una localidad...">
                                                    @foreach ($localidades as $localidad)
                                                        <option value="{{ $localidad->cve_localidad }}" 
                                                            {{ $localidad->cve_localidad == $estudiante->cve_localidad_origen ? 'selected' : '' }}>
                                                            {{ $localidad->localidad }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card form-section-card shadow-sm mt-4">
                                    <div class="card-header bg-guinda-modern py-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span><i class="fas fa-graduation-cap mr-2"></i> <b>II. INFORMACIÓN ESCOLAR</b></span>
                                            <span class="small opacity-75">Datos académicos actuales</span>
                                        </div>
                                    </div>
                                    <div class="card-body p-4">
                                        <div class="row">
                                            {{-- Institución Educativa - Ocupa más espacio --}}
                                            <div class="col-md-4 mb-4">
                                                <label class="font-weight-bold small text-uppercase text-muted">{{ __('Institución Educativa') }}</label>
                                                <select id="cve_escuela" name="cve_escuela" 
                                                        class="form-control selectpicker" 
                                                        data-container="body" 
                                                        data-size="5" 
                                                        data-style="btn-white" required>
                                                    <option value="" selected disabled>-- SELECCIONA LA INSTITUCIÓN --</option>
                                                    @foreach ($escuelas as $escuela)
                                                        <option value="{{ $escuela->cve_escuela }}" {{ $escuela->cve_escuela == $estudiante->cve_escuela ? 'selected' : '' }}>
                                                            {{ $escuela->escuela_abreviatura }}
                                                        </option>
                                                    @endforeach
                                                    <option data-divider="true"></option>
                                                    <option value="999" {{ "999" == $estudiante->cve_escuela ? 'selected' : '' }} data-subtext="No listada"> OTRA </option>
                                                </select>
                                                @error('cve_escuela')
                                                    <small class="text-danger font-weight-bold">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            {{-- Carrera --}}
                                            <div class="col-md-8 mb-4>
                                                <label class="font-weight-bold small text-uppercase text-muted">{{ __('Carrera / Especialidad') }}</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text input-group-text-modern"><i class="fas fa-book"></i></span>
                                                    </div>
                                                    <input id="carrera" name="carrera" type="text" 
                                                        class="form-control form-control-modern @error('carrera') is-invalid @enderror" 
                                                        value="{{ old('carrera', $estudiante->carrera) }}" 
                                                        placeholder="Ej. Ing. Sistemas" required>
                                                </div>
                                            </div>

                                            {{-- Ciudad de la Escuela --}}
                                            <div class="col-md-4 mb-4">
                                                <label class="font-weight-bold small text-uppercase text-muted">{{ __('Ciudad de la Escuela') }}</label>
                                                <select id="cve_ciudad_escuela" name="cve_ciudad_escuela" 
                                                        class="form-control selectpicker" 
                                                        data-container="body" 
                                                        data-size="5" 
                                                        data-style="btn-white" required>
                                                    <option value="" selected disabled>-- SELECCIONA CIUDAD --</option>
                                                    @foreach ($ciudades as $ciudad)
                                                        <option value="{{ $ciudad->cve_ciudad }}" {{ $ciudad->cve_ciudad == $estudiante->cve_ciudad_escuela ? 'selected' : '' }}>
                                                            {{ $ciudad->ciudad }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            {{-- Turno --}}
                                            <div class="col-md-3 mb-4">
                                                <label class="font-weight-bold small text-uppercase text-muted">{{ __('Turno') }}</label>
                                                <select id="cve_turno_escuela" name="cve_turno_escuela" 
                                                        class="form-control selectpicker" 
                                                        data-container="body" 
                                                        data-size="5" 
                                                        data-style="btn-white" required>
                                                    <option value="" selected disabled>-- TURNO --</option>
                                                    @foreach ($turnos as $turno)
                                                        <option value="{{ $turno->cve_turno }}" {{ $turno->cve_turno == $estudiante->cve_turno_escuela ? 'selected' : '' }}>
                                                            {{ $turno->turno }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            {{-- Año Escolar --}}
                                            <div class="col-md-3 mb-4">
                                                <label class="font-weight-bold small text-uppercase text-muted">{{ __('Año Escolar') }}</label>
                                                <select id="ano_escolar" name="ano_escolar" class="form-control selectpicker" data-style="btn-white" data-container="body" 
                                                        data-size="5" required>
                                                    <option value="" selected disabled>-- SELECCIONA --</option>
                                                    @php $grados = [1=>'PRIMERO', 2=>'SEGUNDO', 3=>'TERCERO', 4=>'CUARTO', 5=>'QUINTO', 6=>'SEXTO']; @endphp
                                                    @foreach($grados as $val => $texto)
                                                        <option value="{{ $val }}" {{ $estudiante->ano_escolar == $val ? 'selected' : '' }}>{{ $texto }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            {{-- Promedio --}}
                                            <div class="col-md-2 mb-4">
                                                <label class="font-weight-bold small text-uppercase text-muted">{{ __('Promedio') }}</label>
                                                <input id="promedio" name="promedio" type="number" step="0.1" min="0.0" max="10.0" 
                                                    class="form-control @error('promedio') is-invalid @enderror" 
                                                    value="{{ old('promedio', $estudiante->promedio) }}" 
                                                    placeholder="0.0" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card form-section-card shadow-sm mt-4">
                                    <div class="card-header bg-guinda-modern py-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span><i class="fas fa-file-alt mr-2"></i> <b>III. DOCUMENTACIÓN</b></span>
                                            <span class="small opacity-75">Formatos aceptados: PDF</span>
                                        </div>
                                    </div>

                                    <div class="card-body p-4">
                                        <div class="row">
                                            {{-- Generamos un array para iterar y no repetir código, o puedes hacerlo manual --}}
                                            @php
                                                $documentos = [
                                                    ['label' => 'CURP', 'field' => 'img_curp', 'hidden' => 'curp_hidden', 'msg' => 'Curp'],
                                                    ['label' => 'Acta de Nacimiento', 'field' => 'img_acta_nac', 'hidden' => 'acta_hidden', 'msg' => 'Acta'],
                                                    ['label' => 'Comprobante Domicilio', 'field' => 'img_comprobante_dom', 'hidden' => 'comprobante_hidden', 'msg' => 'Comprobante'],
                                                    ['label' => 'Identificación Oficial', 'field' => 'img_identificacion', 'hidden' => 'identificacion_hidden', 'msg' => 'Identificacion'],
                                                    ['label' => 'Kardex Académico', 'field' => 'img_kardex', 'hidden' => 'kardex_hidden', 'msg' => 'Kardex'],
                                                    ['label' => 'Constancia de Estudios', 'field' => 'img_constancia', 'hidden' => 'constancia_hidden', 'msg' => 'Constancia']
                                                ];
                                            @endphp

                                            @foreach($documentos as $doc)
                                                <div class="col-md-4 mb-4">
                                                    <div class="document-upload-box p-3 border rounded shadow-sm bg-white">
                                                        <label class="font-weight-bold small text-uppercase text-muted d-block mb-2">
                                                            {{ $doc['label'] }}
                                                        </label>
                                                        
                                                        <div class="d-flex align-items-center justify-content-between bg-white p-2 rounded border">
                                                            {{-- Visualización --}}
                                                            <div class="doc-actions">
                                                                <a href="javascript:void(0);" 
                                                                class="btn btn-sm btn-outline-guinda pdf-link py-1" 
                                                                data-pdf-url="{{ route('pdf.show', ['filename' => $estudiante->{$doc['field']}]) }}"
                                                                title="Visualizar documento actual">
                                                                    <i class="fas fa-eye"></i> 
                                                                    <span class="d-none d-sm-inline">Ver PDF</span> 
                                                                </a>
                                                            </div>

                                                            {{-- Carga --}}
                                                            <div class="upload-actions">
                                                                <button type="button" 
                                                                        onclick="document.getElementById('{{ $doc['field'] }}').click();" 
                                                                        class="btn btn-sm btn-verde py-1" 
                                                                        title="Reemplazar archivo">
                                                                    <i class="fas fa-upload"></i> Subir
                                                                </button>
                                                            </div>
                                                        </div>

                                                        {{-- Mensajes de estado --}}
                                                        <div id="archivo_{{ $doc['field'] }}" class="text-success small mt-1 font-italic" style="font-size: 11px;">
                                                            {{-- Aquí el JS pondrá el nombre del archivo seleccionado --}}
                                                        </div>
                                                        <div id="pdfProcessingMessage{{ $doc['msg'] }}" class="text-danger small mt-1" style="display: none;">
                                                            <span class="spinner-border spinner-border-sm"></span> Procesando...
                                                        </div>

                                                        {{-- Inputs Ocultos --}}
                                                        <input type="file" name="{{ $doc['field'] }}" id="{{ $doc['field'] }}" 
                                                            class="file-input-hidden" style="display: none;" accept=".pdf,.PDF">
                                                        <input type="hidden" name="{{ $doc['hidden'] }}" id="{{ $doc['hidden'] }}" 
                                                            value="{{ $estudiante->{$doc['field']} ?? '#' . $doc['msg'] . '#' }}">
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="card">
                                    <div class="form-section">
                                        <div class="card-header text-white bg-guinda">
                                            <b>IV. ADICIONAL </b>
                                        </div>
                                        <br>
                                        {{-- ********************* OBSERVACIONES Y STATUS ******************** --}}
                                        <div class="row mb-3">
                                            <label class="col-md-5 col-form-label text-md-right">{{ __('Observaciones Estudiante') }}</label>
                                            <div class="col-md-6">
                                                <textarea class="form-control" id="observaciones_estudiante" name="observaciones_estudiante" rows="2">{{ old('observaciones_estudiante', $estudiante->observaciones_estudiante) }}</textarea>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-md-5 col-form-label text-md-right">{{ __('Observaciones Admin') }}</label>
                                            <div class="col-md-6">
                                                <textarea class="form-control" id="observaciones_admin" name="observaciones_admin" rows="2">{{ old('observaciones_admin', $estudiante->observaciones_admin) }}</textarea>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-md-5 col-form-label text-md-right">{{ __('Estatus') }} </label>
                                            <div class="col-md-5">
                                                <select id="cve_status" name="cve_status" data-style="btn-selectpicker" class="form-control selectpicker" data-style-base="form-control">
                                                    @foreach ($status as $stat)
                                                        <?php
                                                            switch ($stat->cve_status)
                                                            {
                                                                case 1:   //RECIBIDO
                                                                    $color = "#9944d9"; 
                                                                    break;
                                                                case 2:  //REVISADO
                                                                    $color = "#0071bc";
                                                                    break; 
                                                                case 3: //CENSADO
                                                                    $color = "#7dc3f5";
                                                                    break; 
                                                                case 4: //RECHAZADO
                                                                    $color = "#ff0000";
                                                                    break;
                                                                case 5: //PENDIENTE
                                                                    $color = "#ffe26e";
                                                                    break; 
                                                                case 6: //ACEPTADO
                                                                    $color = "#00ff00";
                                                                    break;
                                                                case 7: //ESPECIAL
                                                                    $color = "#ff00ff";
                                                                    break;
                                                              }
                                                        ?>
                                                        <option style="background: {{ $color }}; color: #ffffff; font-weight: bold" value="{{ $stat->cve_status }}" {{ $stat->cve_status == $estudiante->cve_status? 'selected' : '' }}>{{ $stat->cve_status . ' - ' . $stat->descripcion }}</option>
                                                    @endforeach
                                                </select>
                                            </div> 
                                        </div>
                                    </div>
                                </div> -->
                                <div class="card form-section-card shadow-sm mt-4">
                                    <div class="card-header bg-guinda-modern py-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span><i class="fas fa-info-circle mr-2"></i> <b>IV. INFORMACIÓN ADICIONAL Y ESTATUS</b></span>
                                        </div>
                                    </div>

                                    <div class="card-body p-4">
                                        <div class="row">
                                            {{-- Observaciones Estudiante --}}
                                            <div class="col-md-6 mb-4">
                                                <label class="font-weight-bold small text-uppercase text-muted">
                                                    <i class="fas fa-comment-dots mr-1"></i> {{ __('Observaciones del Estudiante') }}
                                                </label>
                                                <textarea class="form-control form-control-modern" 
                                                        id="observaciones_estudiante" 
                                                        name="observaciones_estudiante" 
                                                        style="padding: 8px 12px !important; border: 1px solid #ced4da !important; 
                                                               border-radius: 8px !important;"
                                                        rows="3" 
                                                        placeholder="Notas o comentarios del alumno...">{{ old('observaciones_estudiante', $estudiante->observaciones_estudiante) }}</textarea>
                                            </div>

                                            {{-- Observaciones Admin --}}
                                            <div class="col-md-6 mb-4">
                                                <label class="font-weight-bold small text-uppercase text-muted text-guinda">
                                                    <i class="fas fa-user-shield mr-1"></i> {{ __('Observaciones del Administrador') }}
                                                </label>
                                                <textarea class="form-control form-control-modern border-guinda-light" 
                                                        id="observaciones_admin" 
                                                        name="observaciones_admin" 
                                                        style="padding: 8px 12px !important; border: 1px solid #ced4da !important; 
                                                               border-radius: 8px !important;"
                                                        rows="3" 
                                                        placeholder="Notas internas de revisión...">{{ old('observaciones_admin', $estudiante->observaciones_admin) }}</textarea>
                                            </div>

                                            {{-- Estatus del Trámite --}}
                                          <div class="col-md-12 mt-2">
                                            @php
                                                $color_inicial = match($estudiante->cve_status) {
                                                    1 => '#9944d9', 2 => '#0071bc', 3 => '#7dc3f5', 
                                                    4 => '#ff0000', 5 => '#ffc107', 6 => '#28a745', 
                                                    7 => '#ff00ff', default => '#6c757d'
                                                };
                                            @endphp

                                           <div id="container-status" class="p-3 rounded bg-white shadow-sm d-flex align-items-center justify-content-between" 
                                                style="border: 1px solid #dee2e6; border-left: 12px solid {{ $color_inicial }}; transition: all 0.4s ease;">
                                                
                                                <label class="font-weight-bold text-uppercase mb-0 mr-3 small"> 
                                                    <i class="fas fa-stream mr-1" style="color: {{ $color_inicial }}; transition: color 0.4s ease;" id="icon-status"></i> 
                                                    {{ __('Estatus Actual del Expediente:') }}
                                                </label>

                                                <div style="flex-grow: 1; max-width: 400px;">
                                                    <select id="cve_status" name="cve_status" 
                                                            class="form-control selectpicker" 
                                                            data-container="body" 
                                                            data-size="5" 
                                                            data-style="btn-outline-light font-weight-bold text-dark border">
                                                        @foreach ($status as $stat)
                                                            @php
                                                                $color_opt = match($stat->cve_status) {
                                                                    1 => '#9944d9', 2 => '#0071bc', 3 => '#7dc3f5', 
                                                                    4 => '#ff0000', 5 => '#ffc107', 6 => '#28a745', 
                                                                    7 => '#ff00ff', default => '#6c757d'
                                                                };
                                                            @endphp
                                                            <option value="{{ $stat->cve_status }}" 
                                                                    data-color="{{ $color_opt }}"
                                                                    {{ $stat->cve_status == $estudiante->cve_status ? 'selected' : '' }}>
                                                                {{ $stat->descripcion }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-4 mb-3">
                                    <div class="col-md-12 d-flex justify-content-center"> {{-- Lo centramos para mejor equilibrio visual --}}
                                        <button type="submit" class="btn btn-guinda-solid px-5 py-2 shadow-sm">
                                            <i class="fas fa-save mr-2"></i> {{ __('Actualizar Información del Expediente') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
@endsection

<script>
    function openWhatsApp(phoneNumber) {
        var isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
        var url = isMobile ? "https://api.whatsapp.com/send?phone=" : "https://web.whatsapp.com/send?phone=";

        window.open(url + phoneNumber, "_blank");
    }

    document.addEventListener('DOMContentLoaded', function() {
        const selectStatus = document.getElementById('cve_status');
        const containerStatus = document.getElementById('container-status');
        const iconStatus = document.getElementById('icon-status');

        if (selectStatus) {
            // Usamos jQuery por si usas bootstrap-select (selectpicker)
            $(selectStatus).on('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const color = selectedOption.getAttribute('data-color');
                
                if (color) {
                    // 1. Cambia solo el color del borde izquierdo
                    if (containerStatus) {
                        containerStatus.style.borderLeftColor = color;
                    }
                    
                    // 2. Cambia solo el color del icono
                    if (iconStatus) {
                        iconStatus.style.color = color;
                    }
                }
            });
        }
    });

//     document.addEventListener('DOMContentLoaded', function() {
//     console.log("🚀 Script PDF cargado y listo.");

//     const pdfjsLib = window['pdfjs-dist/build/pdf'];
//     // Asegúrate de que esta URL sea accesible, si no, fallará todo el motor
//     pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.4.120/pdf.worker.min.js';

//     document.querySelectorAll('.pdf-link').forEach(button => {
//         button.addEventListener('click', function() {
//             const url = this.getAttribute('data-pdf-url');
//             const container = document.getElementById('pdfContainer');
            
//             console.log("📂 Click detectado. Intentando cargar:", url);
            
//             // 1. Mostrar spinner inicial y abrir modal
//             container.innerHTML = '<div class="text-center text-white mt-5"><div class="spinner-border text-light"></div><p>Procesando HD...</p></div>';
//             $('#pdfPreviewModal').modal('show'); 

//             if (!pdfjsLib) {
//                 console.error("❌ Error: La librería PDF.js no se ha cargado correctamente.");
//                 return;
//             }

//             // 2. Cargar el documento
//             pdfjsLib.getDocument(url).promise.then(pdf => {
//                 console.log(`✅ PDF cargado. Total páginas: ${pdf.numPages}`);
//                 container.innerHTML = ''; // Limpiamos el spinner

//                 // 3. Obtener la primera página para calcular la escala global
//                 pdf.getPage(1).then(page => {
//                     const viewportOriginal = page.getViewport({ scale: 1 });
//                     const anchoOriginal = viewportOriginal.width;
                    
//                     console.log("📊 Dimensiones Base:", { ancho: anchoOriginal, alto: viewportOriginal.height });

//                     let escalaFinal = (anchoOriginal < 350) ? 4.5 : 2.0;
//                     console.log(`🔎 Escala elegida: ${escalaFinal} (${anchoOriginal < 350 ? 'Chico' : 'Estándar'})`);

//                     // 4. Función de renderizado corregida
//                     // Pasamos las variables necesarias como argumentos o las tomamos del cierre (closure)
//                     const renderPage = (pageNum) => {
//                         pdf.getPage(pageNum).then(page => {
//                             const canvas = document.createElement('canvas');
//                             const context = canvas.getContext('2d');

//                             const dpr = window.devicePixelRatio || 1;
//                             const nitidezExtra = 2.0; 
//                             const ratio = dpr * nitidezExtra;

//                             const viewport = page.getViewport({ scale: escalaFinal });

//                             // Ajuste de resolución física
//                             canvas.width = Math.floor(viewport.width * ratio);
//                             canvas.height = Math.floor(viewport.height * ratio);

//                             // Ajuste visual CSS
//                             canvas.style.width = viewport.width + "px";
//                             canvas.style.height = viewport.height + "px";

//                             context.setTransform(ratio, 0, 0, ratio, 0, 0);
//                             container.appendChild(canvas);

//                             console.log(`🖌️ Renderizando página ${pageNum} a resolución: ${canvas.width}x${canvas.height}px`);

//                             page.render({
//                                 canvasContext: context,
//                                 viewport: viewport,
//                                 intent: 'print',
//                                 disableCanvasInterface: false
//                             }).promise.then(() => {
//                                 console.log(`✨ Página ${pageNum} lista.`);
//                             });
//                         });
//                     };

//                     // 5. Bucle de renderizado
//                     for (let i = 1; i <= pdf.numPages; i++) {
//                         renderPage(i);
//                     }
//                 });
//             }).catch(err => {
//                 console.error("❌ Error crítico al cargar PDF:", err);
//                 container.innerHTML = `<div class="alert alert-danger m-3">Error: ${err.message}</div>`;
//             });
//         });
//     });
// });

//FUNCIONA CALIDAD DEL PDF PERO NO FUNCIONA EL ANCHO AL 100% SIEMPRE
// document.addEventListener('DOMContentLoaded', function() {
//     console.log("🚀 Script PDF cargado y listo.");

//     const pdfjsLib = window['pdfjs-dist/build/pdf'];
//     pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.4.120/pdf.worker.min.js';

//     document.querySelectorAll('.pdf-link').forEach(button => {
//         button.addEventListener('click', function() {
//             const url = this.getAttribute('data-pdf-url');
//             const container = document.getElementById('pdfContainer');
//             const modal = $('#pdfPreviewModal');
//             const loader = document.getElementById('pdf-loader');            
            
//             console.log("📂 Click detectado. Intentando cargar:", url);
            
//             container.style.opacity = '0';
//             // 1. Mostrar spinner y abrir modal
//             // container.innerHTML = '<div class="text-center text-white mt-5"><div class="spinner-border text-light"></div><p>Procesando HD...</p></div>';
//             // container.style.transition = 'opacity 0.3s ease-in';
//             if(loader) loader.style.display = 'block';
//             modal.modal('show');

//             if (!pdfjsLib) {
//                 console.error("❌ Error: La librería PDF.js no se ha cargado correctamente.");
//                 return;
//             }

//             // 2. Esperar a que el modal esté visible
//             modal.on('shown.bs.modal', function onModalShown() {
//                 modal.off('shown.bs.modal', onModalShown);
                
//                 // 3. Cargar el documento
//                 pdfjsLib.getDocument(url).promise.then(pdf => {
//                     console.log(`✅ PDF cargado. Total páginas: ${pdf.numPages}`);
//                     container.innerHTML = ''; // Limpiar spinner

//                     // 4. Obtener primera página para calcular escala
//                     pdf.getPage(1).then(page => {
//                         const viewportOriginal = page.getViewport({ scale: 1 });
//                         const anchoOriginal = viewportOriginal.width;
                        
//                         console.log("📊 Dimensiones Base:", { ancho: anchoOriginal, alto: viewportOriginal.height });

//                         // 🔥 SOLO CAMBIA ESTE VALOR PARA MEJORAR LA CALIDAD
//                         // 2.0 = Normal, 3.0 = Buena, 4.0 = Excelente, 5.0 = Máxima
//                         const CALIDAD_BASE = 4.0;
                        
//                         // Si el PDF es muy pequeño, aumentar calidad automáticamente
//                         const escalaFinal = (anchoOriginal < 350) ? CALIDAD_BASE * 1.5 : CALIDAD_BASE;
//                         console.log(`🔎 Calidad final: ${escalaFinal}x`);

//                         // 5. Función de renderizado MEJORADA - CON AJUSTE PREVENTIVO
//                         const renderPage = (pageNum, callback) => {
//                             pdf.getPage(pageNum).then(page => {
//                                 // Crear contenedor para evitar superposición
//                                 const pageContainer = document.createElement('div');
//                                 pageContainer.className = 'pdf-page mb-3';
//                                 pageContainer.style.textAlign = 'center';
//                                 pageContainer.style.width = '100%'; // Asegurar ancho completo
                                
//                                 const canvas = document.createElement('canvas');
                                
//                                 // 🎯 CONTEXTO OPTIMIZADO PARA CALIDAD
//                                 const context = canvas.getContext('2d', {
//                                     alpha: false,
//                                     desynchronized: true
//                                 });

//                                 // 🎯 CALCULAR EL ANCHO DISPONIBLE ANTES DE RENDERIZAR
//                                 const containerWidth = container.clientWidth;
                                
//                                 // 🎯 ESCALA BASE (tu calidad)
//                                 const viewport = page.getViewport({ scale: escalaFinal });
                                
//                                 // 🎯 CALCULAR ESCALA PARA AJUSTAR AL CONTENEDOR
//                                 const escalaAjuste = containerWidth / viewport.width;
                                
//                                 // 🎯 NUEVO VIEWPORT CON AMBAS ESCALAS (calidad + ajuste)
//                                 const viewportAjustado = page.getViewport({ 
//                                     scale: escalaFinal * escalaAjuste 
//                                 });

//                                 // 🎯 DIMENSIONES EXACTAS - YA AJUSTADAS AL CONTENEDOR
//                                 canvas.width = viewportAjustado.width;
//                                 canvas.height = viewportAjustado.height;

//                                 // 🎯 CSS - Tamaño natural (coincide con el canvas)
//                                 canvas.style.width = '100%';      // Ocupa todo el ancho
//                                 canvas.style.height = 'auto';     // Altura proporcional
//                                 canvas.style.maxWidth = '100%';
                                
//                                 // Resto de estilos...
//                                 canvas.style.boxShadow = '0 4px 12px rgba(0,0,0,0.15)';
//                                 canvas.style.borderRadius = '4px';
//                                 canvas.style.display = 'block';
//                                 canvas.style.margin = '0 auto';

//                                 pageContainer.appendChild(canvas);
//                                 container.appendChild(pageContainer);

//                                 console.log(`🖌️ Renderizando página ${pageNum}: ${canvas.width}x${canvas.height}px`);

//                                 // 🎯 RENDERIZADO CON MÁXIMA CALIDAD
//                                 page.render({
//                                     canvasContext: context,
//                                     viewport: viewportAjustado,  // Usamos el viewport ajustado
//                                     intent: 'print',
//                                     enableWebGL: true,
//                                     renderInteractiveForms: false,
//                                     background: 'white'
//                                 }).promise.then(() => {
//                                     if(loader) loader.style.display = 'none'; // Escondemos spinner
//                                     container.style.opacity = '1';
//                                     if (callback) callback();
//                                 });
//                             });
//                         };

//                         // 6. Renderizar una página a la vez (evita superposición)
//                         let currentPage = 1;
//                         const renderNextPage = () => {
//                             if (currentPage <= pdf.numPages) {
//                                 renderPage(currentPage, renderNextPage);
//                                 currentPage++;
//                             }
//                         };
                        
//                         renderNextPage();
//                     });
//                 }).catch(err => {
//                     console.error("❌ Error crítico al cargar PDF:", err);
//                     container.innerHTML = `<div class="alert alert-danger m-3">Error: ${err.message}</div>`;
//                 });
//             });
//         });
//     });
// });


//NO FUNCIONA CALIDAD DEL PDF Y SÍ FUNCIONA EL ANCHO AL 100% SIEMPRE
// document.addEventListener('DOMContentLoaded', function() {
//     console.log("🚀 Script PDF cargado y listo.");

//     const pdfjsLib = window['pdfjs-dist/build/pdf'];
//     pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.4.120/pdf.worker.min.js';

//     document.querySelectorAll('.pdf-link').forEach(button => {
//         button.addEventListener('click', function() {
//             const url = this.getAttribute('data-pdf-url');
//             const container = document.getElementById('pdfContainer');
//             const modal = $('#pdfPreviewModal');
//             const loader = document.getElementById('pdf-loader');            
            
//             container.style.opacity = '0';
//             if(loader) loader.style.display = 'block';
            
//             modal.modal('show');

//             modal.one('shown.bs.modal', function() {
//                 // DEBUG 1: Estado inmediato al abrir
//                 console.group("🔍 DEBUG PDF: Inicio de renderizado");
                
//                 setTimeout(() => {
//                     const modalBody = document.querySelector('.modal-body');
                    
//                     // Capturamos medidas de varios puntos para comparar
//                     const debugMeasures = {
//                         "Modal Body offsetWidth": modalBody ? modalBody.offsetWidth : "No encontrado",
//                         "Container clientWidth": container.clientWidth,
//                         "Window InnerWidth": window.innerWidth,
//                         "Document Body clientWidth": document.body.clientWidth
//                     };
//                     console.table(debugMeasures);

//                     const loadingTask = pdfjsLib.getDocument({
//                         url: url,
//                         verbosity: 0,
//                         stopAtErrors: false
//                     });

//                     loadingTask.promise.then(pdf => {
//                         container.innerHTML = ''; 

//                         pdf.getPage(1).then(page => {
//                             const viewportOriginal = page.getViewport({ scale: 1 });
//                             const CALIDAD_BASE = 4.0;
//                             const escalaFinal = (viewportOriginal.width < 350) ? CALIDAD_BASE * 1.5 : CALIDAD_BASE;

//                             const renderPage = (pageNum, callback) => {
//                                 pdf.getPage(pageNum).then(page => {
//                                     const pageContainer = document.createElement('div');
//                                     pageContainer.className = 'pdf-page mb-3';
//                                     pageContainer.style.width = '100%'; 
                                    
//                                     const canvas = document.createElement('canvas');
//                                     const context = canvas.getContext('2d', { alpha: false });

//                                     // 🛠️ EL CORRECTOR DINÁMICO:
//                                     // Si offsetWidth es muy pequeño (menor a 100px), algo anda mal con el modal.
//                                     let containerWidth = modalBody ? modalBody.offsetWidth : container.clientWidth;
                                    
//                                     // DEBUG 2: Medida por página
//                                     console.log(`📄 Página ${pageNum} - Ancho calculado: ${containerWidth}px`);

//                                     const viewport = page.getViewport({ scale: escalaFinal });
//                                     const escalaAjuste = containerWidth / viewport.width;
                                    
//                                     const viewportAjustado = page.getViewport({ 
//                                         scale: escalaFinal * escalaAjuste 
//                                     });

//                                     // DEBUG 3: Escalas finales
//                                     if(pageNum === 1) {
//                                         console.log("🎯 Factor de escala ajuste:", escalaAjuste);
//                                         console.log("🎯 Resolución final Canvas:", viewportAjustado.width, "x", viewportAjustado.height);
//                                     }

//                                     canvas.width = viewportAjustado.width;
//                                     canvas.height = viewportAjustado.height;
//                                     canvas.style.width = '100%'; 
//                                     canvas.style.height = 'auto';
//                                     canvas.style.display = 'block';

//                                     pageContainer.appendChild(canvas);
//                                     container.appendChild(pageContainer);

//                                     page.render({
//                                         canvasContext: context,
//                                         viewport: viewportAjustado,
//                                         intent: 'print'
//                                     }).promise.then(() => {
//                                         if(loader) loader.style.display = 'none';
//                                         container.style.opacity = '1';
//                                         if (callback) callback();
//                                     }).catch(() => { if (callback) callback(); });
//                                 });
//                             };

//                             let currentPage = 1;
//                             const renderNextPage = () => {
//                                 if (currentPage <= pdf.numPages) {
//                                     renderPage(currentPage, renderNextPage);
//                                     currentPage++;
//                                 } else {
//                                     console.groupEnd();
//                                 }
//                             };
//                             renderNextPage();
//                         });
//                     }).catch(err => {
//                         console.error("❌ Error:", err);
//                         console.groupEnd();
//                     });
//                 }, 250); // Aumentado a 250ms para asegurar estabilidad en servidor
//             });
//         });
//     });
// });

document.addEventListener('DOMContentLoaded', function() {
    console.log("🚀 Script PDF unificado cargado.");

    const pdfjsLib = window['pdfjs-dist/build/pdf'];
    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.4.120/pdf.worker.min.js';

    document.querySelectorAll('.pdf-link').forEach(button => {
        button.addEventListener('click', function() {
            const url = this.getAttribute('data-pdf-url');
            const container = document.getElementById('pdfContainer');
            const modal = $('#pdfPreviewModal');
            const loader = document.getElementById('pdf-loader');            
            
            container.style.opacity = '0';
            if(loader) loader.style.display = 'block';
            modal.modal('show');

            // Usamos .one para evitar duplicar eventos
            modal.one('shown.bs.modal', function() {
                
                // 1. ESPERA DE ESTABILIDAD (Clave para el 100% de ancho)
                setTimeout(() => {
                    const modalBody = document.querySelector('.modal-body');
                    
                    // Configuramos la tarea con verbosity 0 para evitar los warnings TT
                    const loadingTask = pdfjsLib.getDocument({
                        url: url,
                        verbosity: 0,
                        stopAtErrors: false
                    });

                    loadingTask.promise.then(pdf => {
                        container.innerHTML = ''; 

                        pdf.getPage(1).then(page => {
                            const viewportOriginal = page.getViewport({ scale: 1 });
                            
                            // 🔥 CONFIGURACIÓN DE ALTA CALIDAD
                            const CALIDAD_BASE = 4.0; // 4.0 es excelente para lectura
                            const escalaFinal = (viewportOriginal.width < 350) ? CALIDAD_BASE * 1.5 : CALIDAD_BASE;

                            const renderPage = (pageNum, callback) => {
                                pdf.getPage(pageNum).then(page => {
                                    const pageContainer = document.createElement('div');
                                    pageContainer.className = 'pdf-page mb-3';
                                    pageContainer.style.width = '100%'; 
                                    
                                    const canvas = document.createElement('canvas');
                                    
                                    // 🎯 CONTEXTO DE ALTA CALIDAD (De tu versión 2)
                                    const context = canvas.getContext('2d', { 
                                        alpha: false,
                                        desynchronized: true // Mejora rendimiento en renders pesados
                                    });

                                    // 🎯 MEDICIÓN REAL DEL ANCHO (De tu versión 1)
                                    // Usamos el ancho del modal-body para asegurar el 100%
                                    let containerWidth = modalBody ? modalBody.clientWidth : container.clientWidth;
                                    // Si hay padding en el modal, lo restamos para que no salga scroll
                                    const padding = modalBody ? parseFloat(window.getComputedStyle(modalBody).paddingLeft) * 2 : 40;
                                    const targetWidth = containerWidth - padding;

                                    const viewport = page.getViewport({ scale: escalaFinal });
                                    const escalaAjuste = targetWidth / viewport.width;
                                    
                                    const viewportAjustado = page.getViewport({ 
                                        scale: escalaFinal * escalaAjuste 
                                    });

                                    // Dimensiones del Canvas (Píxeles reales)
                                    canvas.width = viewportAjustado.width;
                                    canvas.height = viewportAjustado.height;
                                    
                                    // Dimensiones CSS (Lo que el usuario ve)
                                    canvas.style.width = '100%'; 
                                    canvas.style.height = 'auto';
                                    canvas.style.display = 'block';
                                    canvas.style.boxShadow = '0 4px 12px rgba(0,0,0,0.2)';

                                    pageContainer.appendChild(canvas);
                                    container.appendChild(pageContainer);

                                    // 🎯 RENDERIZADO PRO (Unión de ambas técnicas)
                                    page.render({
                                        canvasContext: context,
                                        viewport: viewportAjustado,
                                        intent: 'print', // Optimiza para claridad de texto
                                        enableWebGL: true,
                                        background: 'white'
                                    }).promise.then(() => {
                                        if(loader) loader.style.display = 'none';
                                        container.style.opacity = '1';
                                        if (callback) callback();
                                    }).catch(() => { if (callback) callback(); });
                                });
                            };

                            let currentPage = 1;
                            const renderNextPage = () => {
                                if (currentPage <= pdf.numPages) {
                                    renderPage(currentPage, renderNextPage);
                                    currentPage++;
                                }
                            };
                            renderNextPage();
                        });
                    }).catch(err => {
                        console.error("❌ Error:", err);
                        if(loader) loader.style.display = 'none';
                    });
                }, 200); // Retraso suficiente para que el CSS de Bootstrap asiente
            });
        });
    });
});


</script>