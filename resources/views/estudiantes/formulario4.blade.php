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

<script language="JavaScript" type="text/javascript">
    // A function that disables button
    // function disableButton() {
    //     document.getElementById('btnSiguiente').setAttribute("disabled","disabled");
    //     document.getElementById('btnSiguiente').innerText = "Enviando...";
    // }

    $(document).ready(function(){
        $(function () {
            $('[data-toggle="tooltip"]').tooltip({
            trigger : 'click'
            })
            $('[data-toggle="tooltip"]').mouseleave(function(){
            $(this).tooltip('hide');
            });    
        });

        var $myForm = $("#my_form");
        $myForm.submit(function(){
            // disableButton();
            $myForm.submit(function(){
                return false;
            });
        });
    });
</script>

<script>
       // showDiv('hidden_div', this)  
        // function showDiv(divId, element)
        // {
        //     document.getElementById(divId).style.display = element.value == 1 ? 'block' : 'none';
        // }

        $(document).ready(function() {
    const selectEmpleo = $('#select_empleo');
    const divEmpleo = $('#hidden_div');

    if (selectEmpleo.val() === '1') {
        divEmpleo.show();
    } else {
        divEmpleo.hide();
    }

    selectEmpleo.on('change', function() {
        showDiv('hidden_div', this);
    });
});

function showDiv(divId, element) {
    const div = $('#' + divId);

    if ($(element).val() === '1') {
        div.show();
    } else {
        div.hide();
    }
}
</script>

<style>
    .tooltip-inner {
    max-width: 350px;
    /* If max-width does not work, try using width instead */
    width: 350px; 
    max-height: 100px;
    background-color: #2f4fff;
    text-align: left;
}

#hidden_div {
    display: none;
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
</style>
</head>
<body>
    <div class="container">
        <div class="card-body">
            <div class="row justify-content-center">
                <div class="col-md-7">
                    <div class="row justify-content-center mb-4">
                        <img src="../img/Logo_y_Escudo.jpg" alt="Por tiempos mejores" style="width:70%">
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <form class="contact-form" method="POST" action="{{ route('estudiantes.formulario4.post') }}">
                                @csrf
                                <div class="row justify-content-center mb-1">
                                    <div class="text-center">
                                        <a href="/2024-2025">
                                            <img src="../img/alivianate.jpg" style="width:45%">
                                        </a>
                                    </div>
                                </div>
                                <div class="row justify-content-center mb-1">
                                    <h1 class="h3 mb-4 text-gray-800"> <b>{{ __('FORMULARIO DE REGISTRO') }} </b> </h1>
                                </div>
                                <div class="card">
                                    <div class="form-section">
                                        <div class="card-header text-white bg-rojo">
                                            <b>INFORMACIÓN SOCIOECONÓMICA</b>
                                        </div>
                                        <div>
                                            @if (session()->has('message'))
                                            <br>
                                            <div class="alert alert-danger mb-0">                        
                                                <button type="button" class="close" data-dismiss="alert">
                                                    &times;
                                                </button>                        
                                                {!! html_entity_decode(session()->get('message')) !!}
                                            </div> 
                                            @endif 
                                        </div>
                                        <div class="card-body">
                                            <div class="row mb-3 justify-content-center" style="background-color: #f8f3ec; color: #5c2134;">
                                                Estudiante: &nbsp; <b> {{ $estudiante->nombre . ' ' . $estudiante->primer_apellido . ' ' . $estudiante->segundo_apellido }} </b>
                                            </div>
                                            <div class="row mb-3">
                                                <p class="text-justify px-3 mb-1">
                                                    ¿De qué material es el techo de tu vivienda?
                                                </p>  
                                                <?php $cve_techo_vivienda = $socioeconomico->cve_techo_vivienda  ?? '' ?>
                                                <div class="col-md-7">
                                                    <select id="cve_techo_vivienda" name="cve_techo_vivienda" class="form-control" required>
                                                        <option value="" selected>--SELECCIONA UNA OPCIÓN--</option>
                                                        @foreach ($techos as $techo)
                                                        <option value={{ old('cve_techo_vivienda', $techo->cve_techo) }} {{ $techo->cve_techo == $cve_techo_vivienda ? 'selected' : '' }}>{{ $techo->techo }}</option>
                                                    @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <p class="text-justify px-3 mb-1">
                                                    ¿Cuántos cuartos y baños disponen en tu vivienda? (Incluye cocina, sala, etc.)
                                                </p>                     
                                                <div class="col-md-3">
                                                    <input id="cuartos_vivienda" name="cuartos_vivienda" type="number" step="1" min="1" max="20" class="form-control @error('cuartos_vivienda') is-invalid @enderror" name="cuartos_vivienda" value="{{ old('cuartos_vivienda', $socioeconomico->cuartos_vivienda  ?? '') }}"  autocomplete="cuartos_vivienda" required>
                                                    @error('cuartos_vivienda')   
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                 <p class="text-justify px-3 mb-1">
                                                    ¿Cuántas personas viven normalmente en tu vivienda? (Incluye a personas de todas las edades que vivan ahí.)
                                                </p>                  
                                                <div class="col-md-3">
                                                    <input id="personas_vivienda" name="personas_vivienda" type="number" step="1" min="1" max="20" class="form-control @error('personas_vivienda') is-invalid @enderror" name="personas_vivienda" value="{{ old('personas_vivienda', $socioeconomico->personas_vivienda  ?? '') }}"  autocomplete="personas_vivienda" required>
                                                    @error('personas_vivienda')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <p class="text-justify px-3 mb-1">
                                                    ¿Cuál es el monto mensual que entra a tu hogar? (Incluye el sueldo de cualquier persona que viva en tu vivienda.) 
                                                </p>
                                                <?php $cve_monto_mensual = $socioeconomico->cve_monto_mensual  ?? '' ?>
                                                <div class="col-md-7">
                                                    <select id="cve_monto_mensual" name="cve_monto_mensual" class="form-control" required>
                                                        <option value="" selected>--SELECCIONA UNA OPCIÓN--</option>
                                                        @foreach ($montos as $monto)
                                                        <option value={{ $monto->cve_monto }} {{ $monto->cve_monto == $cve_monto_mensual ? 'selected' : '' }}>{{ $monto->monto }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <p class="text-justify px-3 mb-1">
                                                    ¿Recibes alguna beca para apoyar tus estudios?
                                                </p>
                                                <?php
                                                    $beca_estudios = isset($socioeconomico->beca_estudios) ? $socioeconomico->beca_estudios : null;
                                                ?>
                                                <div class="col-md-3">
                                                    <select id="beca_estudios" name="beca_estudios" class="form-control" required>
                                                        <option value="" {{ $beca_estudios === null ? 'selected' : '' }}>--</option>
                                                        <option value="1" {{ ($beca_estudios === '1' || $beca_estudios === 1) ? 'selected' : '' }}>SÍ</option>
                                                        <option value="0" {{ ($beca_estudios === '0' || $beca_estudios === 0) ? 'selected' : '' }}>NO</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <p class="text-justify px-3 mb-1">
                                                    ¿Recibes algún tipo de ayuda económica del gobierno?
                                                </p>
                                                <?php
                                                    $apoyo_gobierno = isset($socioeconomico->apoyo_gobierno) ? $socioeconomico->apoyo_gobierno : null;
                                                ?>
                                                <div class="col-md-3">
                                                    <select id="apoyo_gobierno" name="apoyo_gobierno" class="form-control" required>
                                                        <option value="" {{ $apoyo_gobierno === null ? 'selected' : '' }}>--</option>
                                                        <option value="1" {{ ($apoyo_gobierno === '1' || $apoyo_gobierno === 1) ? 'selected' : '' }}>SÍ</option>
                                                        <option value="0" {{ ($apoyo_gobierno === '0' || $apoyo_gobierno === 0) ? 'selected' : '' }}>NO</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <p class="text-justify px-3 mb-1 col-md-10">
                                                    ¿Tienes algún empleo? 
                                                </p>
                                                <?php
                                                    $empleo = isset($socioeconomico->empleo) ? $socioeconomico->empleo : null;
                                                ?>
                                                {{-- <div class="col-md-3">
                                                    <select id="select_empleo" class="form-control" required>
                                                        <option value="" {{ $empleo === null ? 'selected' : '' }}>--</option>
                                                        <option value="1" {{ $empleo !== null && strlen(trim($empleo)) > 0 ? 'selected' : '' }}>SÍ</option>
                                                        <option value="0" {{ $empleo !== null && strlen(trim($empleo)) === 0 ? 'selected' : '' }}>NO</option>
                                                    </select>
                                                </div> --}}
                                                <div class="col-md-3">
                                                    <select id="select_empleo" name="select_empleo" class="form-control" required>
                                                        <option value="" {{ $empleo === null ? 'selected' : '' }}>--</option>
                                                        <option value="1" {{ $empleo !== null && $empleo !== false && strlen(trim($empleo)) > 0 ? 'selected' : '' }}>SÍ</option>
                                                        <option value="0" {{ $empleo !== null && ($empleo === false || strlen(trim($empleo)) === 0) ? 'selected' : '' }}>NO</option>
                                                    </select>
                                                </div>                                               
                                                <div class="row mb-3" id="hidden_div" name="hidden_div" style="display: {{ $empleo == '1' ? 'block' : 'none' }}">
                                                    <p class="text-justify px-3 mb-1">
                                                        Especifica:
                                                    </p>
                                                    <div class="col-md-12">
                                                        <input id="empleo" name="empleo" type="text" class="form-control @error('empleo') is-invalid @enderror" name="empleo" value="{{ old('empleo', $empleo  ?? '') }}"  autocomplete="empleo" {{ $empleo == '1' ? 'required' : '' }}>
                                                        @error('empleo')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                    </div>
                                                </div>                                                
                                            </div>
                                            <div class="row mb-3">
                                                <p class="text-justify px-3 mb-1 col-md-10">
                                                    ¿Cuánto gastas en transporte diario a la escuela?(Taxi, camión, etc.) 
                                                </p>
                                                <div class="col-md-3">
                                                    <input id="gasto_transporte" name="gasto_transporte" type="number" step="5" min="0" max="1000" class="form-control @error('gasto_transporte') is-invalid @enderror" name="gasto_transporte" value="{{ old('gasto_transporte', $socioeconomico->gasto_transporte  ?? '') }}"  autocomplete="gasto_transporte" required>
                                                    @error('gasto_transporte')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                                <a href="{{ route('estudiantes.formulario3') }}" class="next btn btn-verde float-left mt-2">Anterior</a>
                                <button type="submit" id="btnSiguiente" name="btnSiguiente" class="next btn btn-verde float-right mt-2">Siguiente</button>
                            </form>
                        </div>
                    </div>
                    <div class="row mb-1 justify-content-center">
                        <div class="col-12 text-center">
                            <label class="col-form-label mx-1 p-2 col-12" style="font-size: 10pt; text-align: justify; background-color: #f8f3ec; color: #5c2134;">
                                * <b> <i class="fab fa-whatsapp"></i> <a href="javascript:void(0);" onclick="openWhatsApp()" style="color: inherit; text-decoration: none;">6941088943</a></b> para soporte técnico y dudas sobre el registro en línea. <br>
                                * Mayores informes en la presidencia municipal de <b> Lunes a Viernes de 8:30 a.m. a 3 p.m. </b>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openWhatsApp() {
            var phoneNumber = "526941088943"; // Coloca el número de teléfono sin el signo "+"
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