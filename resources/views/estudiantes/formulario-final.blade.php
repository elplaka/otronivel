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

<?php 
    $nomKardex = substr($estudiante->img_kardex,0,strlen($estudiante->img_kardex)-3);
    $extKardex = strtoupper(substr(strrchr($estudiante->img_kardex, "."), 1));
    $archivoKardex = $nomKardex . $extKardex;

    $nomConstancia = substr($estudiante->img_constancia,0,strlen($estudiante->img_constancia)-3);
    $extConstancia = strtoupper(substr(strrchr($estudiante->img_constancia, "."), 1));
    $archivoConstancia = $nomConstancia . $extConstancia;
?>

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

<script>
    $(document).ready( function() {

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
</head>
<body>
    <div class="container">
        <div class="card-body">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="row justify-content-center mb-2">
                        <img src="{{url('/img/Logo_y_Escudo.jpg')}}" style="width:70%" />;
                </div>
                    <div class="card">
                        <div class="card-body">
                            <form class="contact-form" method="POST" action="{{ route('estudiantes.formulario_final.post') }}" enctype="multipart/form-data" novalidate>
                                @csrf
                                <div class="row justify-content-center mb-1">
                                    <img src="{{url('/img/alivianate.jpg')}}" style="width:45%" />;
                                </div>
                                <br>
                                <div class="row justify-content-center mb-1">
                                    <h1 class="h3 mb-4 text-gray-800 text-center"> <b>{{ __('FORMULARIO DE ACTUALIZACIÓN DE INFORMACIÓN ') }} </b> </h1>
                                </div>
                                <div class="card" style="background:#9c5c5f;color:#ffffff">
                                    <div class="card-header text-white" style="background:#5b5b5e">
                                        <i class="fas fa-user"></i> &nbsp; INFORMACIÓN DEL ESTUDIANTE
                                    </div>
                                    {{-- <div class="row mb-0">
                                        <label class="col-md-4 col-form-label             text-md-right">Nombre:<b> </label><div class="col-md-8"> <label class="col-form-label text-md-left">  {{ $estudiante->nombre . ' ' . $estudiante->primer_apellido . ' ' . $estudiante->segundo_apellido }}</b>
                                        </label></div>
                                    </div>
                                    <div class="row mb-0">
                                        <label class="col-md-4 col-form-label             text-md-right">Escuela:<b> </label><div class="col-md-8"> <label class="col-form-label text-md-left">  {{ $estudiante->escuela->escuela }}</b>
                                        </label></div>
                                    </div>
                                    <div class="row mb-0">
                                        <label class="col-md-4 col-form-label             text-md-right">Carrera:<b> </label><div class="col-md-8"> <label class="col-form-label text-md-left">  {{ $estudiante->carrera }}</b>
                                        </label></div>
                                    </div>
                                    <div class="row mb-1">
                                        <label class="col-md-4 col-form-label             text-md-right">Ciudad Escuela:<b> </label><div class="col-md-8"> <label class="col-form-label text-md-left">  {{ $estudiante->ciudad->ciudad }}</b>
                                        </label></div>
                                    </div> --}}
                                    <table class="table-striped table-sm">
                                        <tbody>
                                                <tr>
                                                    <td style="text-align:right">Nombre: </td>
                                                    <td><b>{{ $estudiante->nombre . ' ' . $estudiante->primer_apellido . ' ' . $estudiante->segundo_apellido }} </b></td>
                                                </tr> 
                                                <tr>
                                                    <td style="text-align:right">Escuela:</td>
                                                    <td><b>{{ $estudiante->escuela->escuela }} </b></td>
                                                </tr> 
                                                <tr>
                                                    <td style="text-align:right">Carrera:</td>
                                                    <td><b>{{ $estudiante->carrera }} </b></td>
                                                </tr> 
                                                <tr>
                                                    <td style="text-align:right">Ciudad Escuela:</td>
                                                    <td><b>{{ $estudiante->ciudad->ciudad }} </b></td>
                                                </tr> 
                                                
                                        </tbody>
                                  </table>
                                </div>
                                <br>
                                <div class="card">
                                    <div class="form-section">
                                        <div class="card-header text-white bg-primary">
                                            <i class="fas fa-upload"></i> &nbsp; INFORMACIÓN A SUBIR Y/O ACTUALIZAR
                                        </div>
                                        <br>
                                        <div>
                                            @if (session()->has('message'))
                                            <div class="alert alert-danger mb-0">                        
                                                <button type="button" class="close" data-dismiss="alert">
                                                    &times;
                                                </button>                        
                                                {!! html_entity_decode(session()->get('message')) !!}
                                            </div> 
                                            @endif 
                                        </div>
                                        <div class="card-body">
                                            @if ($errors->any())
                                            <div class="alert alert-danger">
                                                <button type="button" class="close" data-dismiss="alert">
                                                    &times;
                                                </button> 
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                             </div>
                                             @endif

                                            {{-- <div class="row mb-3">
                                                <div class="col-md-12 alert alert-danger text-justify"> <i class="fas fa-exclamation-triangle"></i> <small> <i> Si el KARDEX que subiste anteriormente no fue el más reciente, aquí tienes la oportunidad de actualizarlo junto con el PROMEDIO. Si ya los tienes actualizados procede a subir la CONSTANCIA DE ESTUDIOS. </i> </small>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-md-6 col-form-label text-md-right">{{ __('Kárdex') }} <a data-toggle="tooltip" data-placement="top" data-html="true" title="<b>CONSTANCIA DE CALIFICACIONES O FICHA DE INSCRIPCIÓN</b> <br> Sube el kardex más reciente. ><img src="{{ url('/img/help.jpg')}}" style="width:12px;cursor:pointer;"></a></label>
                                                <div class="col-md-5">
                                                    <a id="sel_archivo_kardex" style="cursor:pointer" title="Cargar" class="btn btn-success"> <b> <i class="fas fa-upload"></i> </b> </i></a>
                                                    <div id="archivo_kardex" style="font-size:13px">{{$estudiante->img_kardex ?? 'Sin archivo seleccionado' }}</div>
                                                </div>
                                                <input class='file' type="file" style="display: none" class="form-control" name="img_kardex" id="img_kardex" accept="application/pdf" required>
                                            </div>
                                            <input id="kardex_hidden" name="kardex_hidden" type="hidden" value="{{ $estudiante->img_kardex ?? '#kardex#' }}">

                                            <div class="row mb-4">
                                                <label for="promedio" class="col-md-6 col-form-label text-md-right">{{ __('Promedio Actual') }}<a data-toggle="tooltip" data-placement="top" data-html="true" title="<b>PROMEDIO GENERAL DEL ÚLTIMO CICLO CURSADO</b>"> <img src="{{ url('/img/help.jpg')}}" style="width:12px;cursor:pointer;"></a></label>
                                                <div class="col-md-2">
                                                    <input id="promedio" name="promedio" type="number" step="0.1" min="0.0" max="10.0" class="form-control @error('promedio') is-invalid @enderror" name="promedio" value="{{ old('promedio', $estudiante->promedio) }}" autocomplete="promedio" required>
                                                    @error('promedio')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div> --}}
                                            <div class="row mb-3">
                                                <label class="col-md-6 col-form-label text-md-right">{{ __('Constancia de Estudios') }} <a data-toggle="tooltip" data-placement="top" data-html="true" title="<b>CONSTANCIA DE ESTUDIOS </b> <br> En formato PDF que no pese más de 2MB"><img src="{{ url('/img/help.jpg')}}" style="width:12px;cursor:pointer;"></a></label>
                                                <div class="col-md-5">
                                                    {{-- @if ($archivoConstancia != "PENDIENTE") <a href="{{ "/img/constancias/" . $archivoConstancia  }}" title="Ver PDF" class="btn btn-danger"> <b> Ver PDF </b></a> 
                                                    @endif --}}
                                                    <a id="sel_archivo_constancia" style="cursor:pointer" title="Cargar" class="btn btn-success"> Selecciona archivo<small><2M</small> <b> <i class="fas fa-upload"></i> </b> </i></a>
                                                    {{-- @if ($archivoConstancia == "PENDIENTE") --}}
                                                    <div id="archivo_constancia" style="font-size:13px">{{$estudiante->img_constancia ?? 'Sin archivo seleccionado' }}</div>
                                                    {{-- @endif --}}
                                                </div>
                                                <input class='file' type="file" style="display: none" class="form-control" name="img_constancia" id="img_constancia" accept="application/pdf" required>
                                            </div>
                                            <input id="constancia_hidden" name="constancia_hidden" type="hidden" value="{{ $estudiante->img_constancia ?? '#constancia#' }}">
                                            <div class="row mb-1 justify-content-center">
                                                 <button type="submit" id="btnSiguiente" name="btnSiguiente" class="btn btn-info mt-2">Guardar</button>
                                            </div>
                                        </div> 
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a> --}}
    <script src="{{ asset('js/jquery.js') }}"></script>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('js/app.js') }}"></script>
   

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('js/sb-admin.min.js') }}"></script>
</body>
</html>