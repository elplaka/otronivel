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
    max-height: 100px;
    background-color: #2f4fff;
    text-align: left;
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
                <div class="col-md-8">
                    <div class="row justify-content-center mb-4">
                        <img src="../img/Logo_y_Escudo.jpg" alt="Por tiempos mejores" style="width:70%">
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <form class="contact-form" method="POST" action="{{ route('estudiantes.formulario3.post') }}">
                                @csrf
                                <div class="row justify-content-center mb-1">
                                    <div class="text-center">
                                        <a href="/2023-2024">
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
                                            <b>INFORMACIÓN DEL CICLO ESCOLAR {{ $cicloDescripcion }}</b>
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
                                                <label for="cve_escuela" class="col-md-4 col-form-label text-md-right">{{ __('Institución Educativa*') }}</label>
                                                <div class="col-md-8">
                                                    <select id="cve_escuela" name="cve_escuela" class="form-control" required>
                                                        <option value="" selected> -- SELECCIONA LA INSTITUCIÓN -- </option>
                                                        @foreach ($escuelas as $escuela)
                                                            <option value={{ $escuela->cve_escuela }} {{ $escuela->cve_escuela == $estudiante->cve_escuela ? 'selected' : '' }}>{{ $escuela->escuela . ' - (' . $escuela->escuela_abreviatura . ')' }}</option>
                                                        @endforeach
                                                        <option disabled>____________________________________________________</option>
                                                        <option value="999" {{ "999" == $estudiante->cve_escuela ? 'selected' : '' }}> OTRA </option>
                                                    </select>
                                                    @error('cve_escuela')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="carrera" class="col-md-4 col-form-label text-md-right">{{ __('Carrera*') }}</label>
                                                <div class="col-md-8">
                                                    <input id="carrera" name="carrera" type="text" class="form-control @error('carrera') is-invalid @enderror" name="carrera" value="{{ old('carrera', $estudiante->carrera) }}" autocomplete="carrera" max="30" required>
                                                    @error('carrera')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="cve_ciudad_escuela" class="col-md-4 col-form-label text-md-right">{{ __('Ciudad Escuela*')}}</label>
                                                <div class="col-md-8">
                                                    <select id="cve_ciudad_escuela" name="cve_ciudad_escuela"  class="form-control" required >
                                                        <option value="" selected> -- SELECCIONA LA CIUDAD -- </option>
                                                        @foreach ($ciudades as $ciudad)
                                                            <option value={{ $ciudad->cve_ciudad }} {{ $ciudad->cve_ciudad == $estudiante->cve_ciudad_escuela ? 'selected' : '' }}>{{ $ciudad->ciudad }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('cve_ciudad_escuela')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="cve_turno_escuela" class="col-md-4 col-form-label text-md-right">{{ __('Turno Escuela*')}}</label>
                                                <div class="col-md-8">
                                                    <select id="cve_turno_escuela" name="cve_turno_escuela"  class="form-control" required>
                                                        <option value="" selected> -- SELECCIONA EL TURNO -- </option>
                                                        @foreach ($turnos as $turno)
                                                            <option value={{ $turno->cve_turno }} {{ $turno->cve_turno == $estudiante->cve_turno_escuela ? 'selected' : '' }}>{{ $turno->turno }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('cve_turno_escuela')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="ano_escolar" class="col-md-4 col-form-label text-md-right">{{ __('Año Escolar*')}}</label>
                                                <div class="col-md-8">
                                                    <select id="ano_escolar" name="ano_escolar"  class="form-control" required>
                                                        <option value="" selected> -- SELECCIONA EL AÑO -- </option>
                                                        <option value=1 {{ $estudiante->ano_escolar == 1 ? 'selected' : '' }}> PRIMERO </option>
                                                        <option value=2 {{ $estudiante->ano_escolar == 2 ? 'selected' : '' }}> SEGUNDO </option>
                                                        <option value=3 {{ $estudiante->ano_escolar == 3 ? 'selected' : '' }}> TERCERO </option>
                                                        <option value=4 {{ $estudiante->ano_escolar == 4 ? 'selected' : '' }}> CUARTO </option>
                                                        <option value=5 {{ $estudiante->ano_escolar == 5 ? 'selected' : '' }}> QUINTO </option>
                                                        <option value=6 {{ $estudiante->ano_escolar == 6 ? 'selected' : '' }}> SEXTO </option>
                                                    </select>
                                                    @error('ano_escolar')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="promedio" class="col-md-4 col-form-label text-md-right">{{ __('Promedio Actual') }}<a data-toggle="tooltip" data-placement="top" data-html="true" title="<b>PROMEDIO GENERAL DEL ÚLTIMO CICLO CURSADO. Si vienes de la preparatoria escribe tu promedio del certificado. </b>"> <img src="../img/help.jpg" style="width:12px;cursor:pointer;"></a></label>
                                                <div class="col-md-8">
                                                    <input id="promedio" name="promedio" type="number" step="0.1" min="0.0" max="10.0" class="form-control @error('promedio') is-invalid @enderror" name="promedio" value="{{ old('promedio', $estudiante->promedio == 0 ? '': $estudiante->promedio) }}" placeholder="Promedio del último ciclo cursado" autocomplete="promedio" required>
                                                    @error('promedio')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>                                        
                                    </div> 
                                </div>
                                <a href="{{ route('estudiantes.formulario2') }}" class="next btn btn-verde float-left mt-2">Anterior</a>
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