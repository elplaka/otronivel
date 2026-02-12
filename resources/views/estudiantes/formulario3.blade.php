<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>OTRO NIVEL - Información Académica</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="{{ asset('css/sb-admin.min.css')}}" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('Favicon.png') }}">
    
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <style>
        :root {
            --rojo-institucional: #7b003a;
            --verde-boton: #00656c;
            --verde-hover: #4a826a;
            --gris-fondo: #f8f9fc;
        }

        body { background-color: white; }

        /* --- UI MODERNA (ESTILO FORM 2) --- */
        .custom-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            overflow: visible !important;
            background: #fff;
        }

        .section-header-modern {
            background-color: var(--rojo-institucional);
            padding: 1.25rem 1.5rem;
            border-radius: 12px 12px 0 0;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .header-content { display: flex; align-items: center; color: #ffffff; }
        .header-content i { font-size: 1.2rem; margin-right: 15px; opacity: 0.9; }
        .header-text { 
            font-size: 0.95rem; 
            font-weight: 700; 
            text-transform: uppercase; 
            letter-spacing: 2px;
        }
        .header-line { width: 40px; height: 3px; background-color: rgba(255, 255, 255, 0.4); border-radius: 2px; margin-left: 35px; }

        /* Inputs Estandarizados */
        .form-control {
            height: 42px !important;
            border-radius: 8px !important;
            border: 1px solid #d1d3e2;
        }
        .form-control:focus {
            border-color: var(--rojo-institucional);
            box-shadow: 0 0 0 0.2rem rgba(123, 0, 58, 0.15);
        }

        .form-label-custom { font-weight: 600; color: #4b4b4bff; margin-bottom: 5px; }

        /* Botones */
        .btn-verde {
            background-color: var(--verde-boton);
            color: white;
            padding: 10px 30px;
            border-radius: 50px;
            font-weight: bold;
            transition: all 0.3s ease;
            border: none;
        }
        .btn-verde:hover { background-color: var(--verde-hover); color: white; }

        /* Banner de Estudiante */
        .student-banner {
            background-color: #f1f3f9;
            color: var(--rojo-institucional);
            padding: 10px;
            border-radius: 8px;
            font-size: 1.1rem;
            border-left: 4px solid var(--rojo-institucional);
        }

        /* --- RESPONSIVE & ADAPTABILIDAD --- */
        .container-adaptable { padding-bottom: 3rem; }
        
        @media (max-width: 576px) {
            .container-adaptable { padding-bottom: 18rem !important; }
            .btn-mobile-block { width: 100%; display: block; margin-bottom: 10px; }
            .header-text { font-size: 0.85rem; letter-spacing: 1px; }
            body { min-height: 120vh; }
        }

        .tooltip-inner {
            max-width: 300px;
            background-color: #2f4fff;
            text-align: left;
            padding: 10px;
        }

        /* Color base para el botón Anterior (Gris oscuro) */
        .btn-anterior {
            background-color: #6e707e !important;
            color: white !important;
            border: none;
        }

        /* Efecto Hover: Se oscurece más al pasar el mouse */
        .btn-anterior:hover {
            background-color: #3a3b45 !important; /* Un gris mucho más profundo */
            color: white !important;
        }

        /* Mantener consistencia en el diseño redondeado */
        .btn-anterior.btn-verde {
            padding: 10px 30px;
            border-radius: 50px;
            font-weight: bold;
            transition: all 0.3s ease;
        }
    </style>
</head>
<body>

<div class="container py-5 container-adaptable">
    <div class="row justify-content-center">
        <div class="col-md-9">
            
            <div class="text-center mb-4">
                <img src="../img/Logo_y_Escudo.jpg" class="img-fluid mb-3" style="width: 100%; max-width: 450px; height: auto;">
                <div class="mb-4">
                    <a href="/2025-2026">
                        <img src="../img/logo_programa.jpg" class="img-fluid" style="max-width: 280px;">
                    </a>
                </div>
                <h1 class="h3 font-weight-bold text-dark">{{ __('FORMULARIO DE REGISTRO') }}</h1>
            </div>

            <div class="custom-card mb-4">
                <div class="section-header-modern">
                    <div class="header-content">
                        <i class="fas fa-graduation-cap"></i>
                        <span class="header-text">Información del Ciclo Escolar {{ $cicloDescripcion }}</span>
                    </div>
                    <div class="header-line"></div>
                </div>

                <div class="card-body p-4">
                    <div class="student-banner mb-4 text-center">
                        <i class="fas fa-user-graduate mr-2"></i> Estudiante: <b>{{ $estudiante->nombre . ' ' . $estudiante->primer_apellido . ' ' . $estudiante->segundo_apellido }}</b>
                    </div>

                    @if (session()->has('message'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            {!! html_entity_decode(session()->get('message')) !!}
                        </div>
                    @endif

                    <form class="contact-form" method="POST" action="{{ route('estudiantes.formulario3.post') }}">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label-custom">{{ __('Institución Educativa*') }}</label>
                                <select name="cve_escuela" class="form-control" required>
                                    <option value="" selected disabled>-- Selecciona la institución --</option>
                                    @foreach ($escuelas as $escuela)
                                        <option value="{{ $escuela->cve_escuela }}" {{ $escuela->cve_escuela == $estudiante->cve_escuela ? 'selected' : '' }}>
                                            {{ $escuela->escuela }} ({{ $escuela->escuela_abreviatura }})
                                        </option>
                                    @endforeach
                                    <option value="999" {{ "999" == $estudiante->cve_escuela ? 'selected' : '' }}>OTRA</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label-custom">{{ __('Carrera*') }}</label>
                                <input type="text" name="carrera" class="form-control @error('carrera') is-invalid @enderror" value="{{ old('carrera', $estudiante->carrera) }}" placeholder="Ej. Ingeniería Civil" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label-custom">{{ __('Ciudad de la Escuela*') }}</label>
                                <select name="cve_ciudad_escuela" class="form-control" required>
                                    <option value="" selected disabled>-- Selecciona la ciudad --</option>
                                    @foreach ($ciudades as $ciudad)
                                        <option value="{{ $ciudad->cve_ciudad }}" {{ $ciudad->cve_ciudad == $estudiante->cve_ciudad_escuela ? 'selected' : '' }}>
                                            {{ $ciudad->ciudad }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label-custom">{{ __('Turno*') }}</label>
                                <select name="cve_turno_escuela" class="form-control" required>
                                    <option value="" selected disabled>-- Turno --</option>
                                    @foreach ($turnos as $turno)
                                        <option value="{{ $turno->cve_turno }}" {{ $turno->cve_turno == $estudiante->cve_turno_escuela ? 'selected' : '' }}>
                                            {{ $turno->turno }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label-custom">{{ __('Año Escolar*') }}</label>
                                <select name="ano_escolar" class="form-control" required>
                                    <option value="" selected disabled>-- Año --</option>
                                    @foreach(range(1, 6) as $num)
                                        @php $labels = [1=>'PRIMERO', 2=>'SEGUNDO', 3=>'TERCERO', 4=>'CUARTO', 5=>'QUINTO', 6=>'SEXTO']; @endphp
                                        <option value="{{ $num }}" {{ $estudiante->ano_escolar == $num ? 'selected' : '' }}>{{ $labels[$num] }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label-custom">
                                    {{ __('Promedio Actual') }}
                                    <i class="fas fa-question-circle text-muted ml-1" data-toggle="tooltip" data-html="true" title="Promedio general del último ciclo cursado."></i>
                                </label>
                                <input type="number" step="0.1" min="0.0" max="10.0" name="promedio" class="form-control @error('promedio') is-invalid @enderror" value="{{ old('promedio', $estudiante->promedio == 0 ? '': $estudiante->promedio) }}" placeholder="0.0" required>
                            </div>
                        </div>

                        <div class="d-flex flex-column flex-sm-row justify-content-between mt-2 mb-4">
                            <a href="{{ route('estudiantes.formulario2') }}" 
                            class="btn btn-verde btn-anterior btn-mobile-block mb-2">
                                <i class="fas fa-chevron-left mr-2"></i> Anterior
                            </a>
                            <button type="submit" class="btn btn-verde shadow-sm btn-mobile-block mb-2">
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
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });

    function openWhatsApp(phoneNumber) {
        // var phoneNumber = "526949568140";
        var isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
        var url = isMobile ? "https://api.whatsapp.com/send?phone=" : "https://web.whatsapp.com/send?phone=";
        window.open(url + phoneNumber, "_blank");
    }
</script>

<script src="{{ mix('js/app.js') }}"></script>
<script src="{{ asset('js/sb-admin.min.js') }}"></script>
</body>
</html>