<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>OTRO NIVEL - Información Socioeconómica</title>

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
            --gris-anterior: #6e707e;
            --gris-anterior-hover: #3a3b45;
        }

        body { background-color: white; }

        /* --- UI MODERNA --- */
        .custom-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
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

        /* Formulario */
        .form-label-custom { font-weight: 600; color: #4b4b4b; margin-bottom: 8px; display: block; }
        .form-control {
            height: 42px !important;
            border-radius: 8px !important;
            border: 1px solid #d1d3e2;
        }
        .form-control:focus {
            border-color: var(--rojo-institucional);
            box-shadow: 0 0 0 0.2rem rgba(123, 0, 58, 0.15);
        }

        /* Banner de Estudiante */
        .student-banner {
            background-color: #f1f3f9;
            color: var(--rojo-institucional);
            padding: 12px;
            border-radius: 8px;
            font-size: 1rem;
            border-left: 4px solid var(--rojo-institucional);
        }

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

        .btn-anterior {
            background-color: var(--gris-anterior) !important;
            color: white !important;
            padding: 10px 30px;
            border-radius: 50px;
            font-weight: bold;
            transition: all 0.3s ease;
            border: none;
        }
        .btn-anterior:hover { background-color: var(--gris-anterior-hover) !important; }

        @media (max-width: 576px) {
            .btn-mobile-block { width: 100%; display: block; margin-bottom: 10px; }
        }

        .container-adaptable { padding-bottom: 3rem; }
        
        @media (max-width: 576px) {
            .container-adaptable { padding-bottom: 18rem !important; }
            .btn-mobile-block { width: 100%; display: block; margin-bottom: 10px; }
            .header-text { font-size: 0.85rem; letter-spacing: 1px; }
            body { min-height: 120vh; }
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
                        <i class="fas fa-home"></i>
                        <span class="header-text">Información Socioeconómica</span>
                    </div>
                    <div class="header-line"></div>
                </div>

                <div class="card-body p-4">
                    <div class="student-banner mb-4 text-center">
                        <i class="fas fa-user-graduate mr-2"></i> Estudiante: <b>{{ $estudiante->nombre . ' ' . $estudiante->primer_apellido . ' ' . $estudiante->segundo_apellido }}</b>
                    </div>

                    <form id="my_form" method="POST" action="{{ route('estudiantes.formulario4.post') }}">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <label class="form-label-custom">¿De qué material es el techo de tu vivienda?*</label>
                                <select name="cve_techo_vivienda" class="form-control" required>
                                    <option value="" selected disabled>-- Selecciona una opción --</option>
                                    @foreach ($techos as $techo)
                                        <option value="{{ $techo->cve_techo }}" {{ (isset($socioeconomico->cve_techo_vivienda) && $techo->cve_techo == $socioeconomico->cve_techo_vivienda) ? 'selected' : '' }}>
                                            {{ $techo->techo }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label-custom">¿Cuántos cuartos y baños disponen?*</label>
                                <input type="number" name="cuartos_vivienda" class="form-control" min="1" max="20" value="{{ old('cuartos_vivienda', $socioeconomico->cuartos_vivienda ?? '') }}" required>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label-custom">¿Cuántas personas viven ahí?*</label>
                                <input type="number" name="personas_vivienda" class="form-control" min="1" max="20" value="{{ old('personas_vivienda', $socioeconomico->personas_vivienda ?? '') }}" required>
                            </div>

                            <div class="col-md-12 mb-4">
                                <label class="form-label-custom">¿Cuál es el monto mensual que entra a tu hogar?*</label>
                                <select name="cve_monto_mensual" class="form-control" required>
                                    <option value="" selected disabled>-- Selecciona el rango --</option>
                                    @foreach ($montos as $monto)
                                        <option value="{{ $monto->cve_monto }}" {{ (isset($socioeconomico->cve_monto_mensual) && $monto->cve_monto == $socioeconomico->cve_monto_mensual) ? 'selected' : '' }}>
                                            {{ $monto->monto }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label-custom">¿Recibes beca de estudios?*</label>
                                <select name="beca_estudios" class="form-control" required>
                                    <option value="" disabled selected>--</option>
                                    <option value="1" {{ ($socioeconomico->beca_estudios ?? '') == '1' ? 'selected' : '' }}>SÍ</option>
                                    <option value="0" {{ ($socioeconomico->beca_estudios ?? '') == '0' ? 'selected' : '' }}>NO</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label-custom">¿Recibes ayuda del gobierno?*</label>
                                <select name="apoyo_gobierno" class="form-control" required>
                                    <option value="" disabled selected>--</option>
                                    <option value="1" {{ ($socioeconomico->apoyo_gobierno ?? '') == '1' ? 'selected' : '' }}>SÍ</option>
                                    <option value="0" {{ ($socioeconomico->apoyo_gobierno ?? '') == '0' ? 'selected' : '' }}>NO</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label-custom">¿Tienes algún empleo?*</label>
                                <select id="select_empleo" name="select_empleo" class="form-control" required>
                                    @php $tiene_empleo = !empty($socioeconomico->empleo); @endphp
                                    <option value="" disabled selected>--</option>
                                    <option value="1" {{ $tiene_empleo ? 'selected' : '' }}>SÍ</option>
                                    <option value="0" {{ (isset($socioeconomico) && !$tiene_empleo) ? 'selected' : '' }}>NO</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-4" id="hidden_div" style="display: {{ $tiene_empleo ? 'block' : 'none' }}">
                                <label class="form-label-custom">Especifique empleo:*</label>
                                <input id="input_empleo" name="empleo" type="text" class="form-control" value="{{ old('empleo', $socioeconomico->empleo ?? '') }}">
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label-custom">Gasto transporte diario ($)*</label>
                                <input name="gasto_transporte" type="number" step="1" class="form-control" value="{{ old('gasto_transporte', $socioeconomico->gasto_transporte ?? '') }}" required>
                            </div>
                        </div>

                        <div class="d-flex flex-column flex-sm-row justify-content-between mt-2 mb-3">
                            <a href="{{ route('estudiantes.formulario3') }}" class="btn btn-anterior btn-mobile-block mb-2">
                                <i class="fas fa-chevron-left mr-2"></i> Anterior
                            </a>
                            <button type="submit" id="btnSiguiente" class="btn btn-verde btn-mobile-block mb-2">
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
    $(document).ready(function() {
        // Lógica mostrar/ocultar empleo
        $('#select_empleo').on('change', function() {
            if ($(this).val() === '1') {
                $('#hidden_div').fadeIn();
                $('#input_empleo').attr('required', true);
            } else {
                $('#hidden_div').fadeOut();
                $('#input_empleo').attr('required', false).val('');
            }
        });

        // Prevenir doble envío
        $('#my_form').submit(function() {
            $('#btnSiguiente').prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i> Enviando...');
        });
    });

    function openWhatsApp(phoneNumber) {
        // var phoneNumber = "526692295855";
        var isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
        var url = isMobile ? "https://api.whatsapp.com/send?phone=" : "https://web.whatsapp.com/send?phone=";
        window.open(url + phoneNumber, "_blank");
    }
</script>

</body>
</html> 