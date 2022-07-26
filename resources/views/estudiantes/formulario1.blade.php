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

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

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
                        <img src="../img/Logo_y_Escudo.jpg" alt="Por tiempos mejores" style="width:70%">
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <form class="contact-form" method="POST" action="{{ route('estudiantes.formulario1.post') }}" enctype="multipart/form-data" novalidate>
                                @csrf
                                <div class="row justify-content-center mb-1">
                                    <img src="../img/alivianate.jpg" style="width:45%">
                                </div>
                                <div class="row justify-content-center mb-1">
                                    <h1 class="h3 mb-4 text-gray-800"> <b>{{ __('FORMULARIO DE REGISTRO') }} </b> </h1>
                                </div>
                                <div class="card">
                                    <div class="form-section">
                                        <div class="card-header text-white bg-primary">
                                            <b>1. SUBIR DOCUMENTOS</b>
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
                                            <div class="row mb-3">
                                                <label class="col-md-6 col-form-label text-md-right">{{ __('CURP') }} <a data-toggle="tooltip" data-placement="top" data-html="true" title="<b>ARCHIVO EN PDF</b> <br> El formulario aceptará el archivo PDF de formato reciente descargado en la página del Gobierno Federal <i>https://www.gob.mx/curp/</i> que no pese más de 2MB"><img src="../img/help.jpg" style="width:12px;cursor:pointer;"></a></label>
                                                <div class="col-md-5">
                                                    <button type="button" class="btn btn-success" id="sel_archivo_curp">Selecciona archivo<small><2M</small> <i class="fas fa-upload"></i></button>
                                                    <div id="archivo_curp" style="font-size:13px" required>{{$estudiante->img_curp ?? 'Sin archivo seleccionado' }}</div>
                                                </div>
                                                <input class='file' type="file" style="display: none " class="form-control" name="img_curp" id="img_curp" accept=".pdf, .PDF" required>
                                             </div>
                                             <input id="curp_hidden" name="curp_hidden" type="hidden" value="{{ $estudiante->img_curp ?? '#curp#' }}">
                                            
                                            <div class="row mb-3">
                                                <label class="col-md-6 col-form-label text-md-right">{{ __('Acta de Nacimiento') }} <a data-toggle="tooltip" data-placement="top" data-html="true" title="<b>ACTA CON FORMATO RECIENTE</b> <br> El acta de nacimiento se recomienda que sea de formato reciente y que esté en formato PDF que no pese más de 2MB"><img src="../img/help.jpg" style="width:12px;cursor:pointer;"></a></label>
                                                <div class="col-md-5">
                                                    <button type="button" class="btn btn-success" id="sel_archivo_acta_nac">Selecciona archivo<small><2M</small> <i class="fas fa-upload"></i></button>
                                                    <div id="archivo_acta_nac" style="font-size:13px">{{$estudiante->img_acta_nac ?? 'Sin archivo seleccionado' }}</div>
                                                </div>
                                                <input class='file' type="file" style="display: none" class="form-control" name="img_acta_nac" id="img_acta_nac" accept="application/pdf" required>
                                            </div>
                                            <input id="acta_hidden" name="acta_hidden" type="hidden" value="{{ $estudiante->img_acta_nac ?? '#acta#' }}">

                                            <div class="row mb-3">
                                                <label class="col-md-6 col-form-label text-md-right">{{ __('Comprobante Domicilio') }} <a data-toggle="tooltip" data-placement="top" data-html="true" title="<b>COMPROBANTE MÁS RECIENTE DE:</b> <br> 
                                                    - Recibo de CFE o<br>
                                                    - Recibo de JUMAPAC o<br>
                                                    - Recibo de TELMEX<br> En formato PDF que no pese más de 2MB."><img src="../img/help.jpg" style="width:12px;cursor:pointer;"></a></label> 
                                                <div class="col-md-5">
                                                    <button type="button" class="btn btn-success" id="sel_archivo_comprobante_dom">Selecciona archivo<small><2M</small> <i class="fas fa-upload"></i></button>
                                                    <div id="archivo_comprobante_dom" style="font-size:13px">{{$estudiante->img_comprobante_dom ?? 'Sin archivo seleccionado' }}</div>
                                                </div>
                                                <input class='file' type="file" style="display: none" class="form-control" name="img_comprobante_dom" id="img_comprobante_dom" accept="application/pdf" required>
                                            </div>
                                            <input id="comprobante_hidden" name="comprobante_hidden" type="hidden" value="{{ $estudiante->img_comprobante_dom ?? '#comprobante#' }}">

                                            <div class="row mb-3">
                                                <label class="col-md-6 col-form-label text-md-right">{{ __('Identificación Oficial') }} <a data-toggle="tooltip" data-placement="top" data-html="true" title="<b>INE O ESCOLAR</b> <br> Si no tienes la credencial del INE entonces subirás una credencial escolar en formato PDF que no pese más de 2MB"><img src="../img/help.jpg" style="width:12px;cursor:pointer;"></a></label>
                                                <div class="col-md-5">
                                                    <button type="button" class="btn btn-success" id="sel_archivo_identificacion">Selecciona archivo<small><2M</small> <i class="fas fa-upload"></i></button>
                                                    <div id="archivo_identificacion" style="font-size:13px">{{$estudiante->img_identificacion ?? 'Sin archivo seleccionado' }}</div>
                                                </div>
                                                <input class='file' type="file" style="display: none" class="form-control" name="img_identificacion" id="img_identificacion" accept="application/pdf" required>
                                            </div>
                                            <input id="identificacion_hidden" name="identificacion_hidden" type="hidden" value="{{ $estudiante->img_identificacion ?? '#identificacion#' }}">

                                            <div class="row mb-3">
                                                <label class="col-md-6 col-form-label text-md-right">{{ __('Kárdex') }} <a data-toggle="tooltip" data-placement="top" data-html="true" title="<b>CONSTANCIA DE CALIFICACIONES O FICHA DE INSCRIPCIÓN</b> <br> Si apenas vas a entrar al Nivel Superior subirás la ficha de inscripción en formato PDF que no pese más de 2MB"><img src="../img/help.jpg" style="width:12px;cursor:pointer;"></a></label>
                                                <div class="col-md-5">
                                                    <button type="button" class="btn btn-success" id="sel_archivo_kardex">Selecciona archivo<small><2M</small> <i class="fas fa-upload"></i></button>
                                                    <div id="archivo_kardex" style="font-size:13px">{{$estudiante->img_kardex ?? 'Sin archivo seleccionado' }}</div>
                                                </div>
                                                <input class='file' type="file" style="display: none" class="form-control" name="img_kardex" id="img_kardex" accept="application/pdf" required>
                                            </div>
                                            <input id="kardex_hidden" name="kardex_hidden" type="hidden" value="{{ $estudiante->img_kardex ?? '#kardex#' }}">

                                            <div class="row mb-3">
                                                <label class="col-md-6 col-form-label text-md-right">{{ __('Constancia de Estudios') }} <a data-toggle="tooltip" data-placement="top" data-html="true" title="<b>CONSTANCIA DE ESTUDIOS </b> <br> En formato PDF que no pese más de 2MB"><img src="../img/help.jpg" style="width:12px;cursor:pointer;"></a></label>
                                                <div class="col-md-5 alert alert-danger text-justify" style="padding:5px; margin:0"> <small> <i> Este archivo lo subirás una vez que solicites dicha constancia al inicio del Ciclo Escolar 2022-2023. </i> </small>
                                                </div>
                                                {{-- <div class="col-md-5">
                                                    <button type="button" class="btn btn-success" id="sel_archivo_constancia">Selecciona archivo<small><2M</small> <i class="fas fa-upload"></i></button>
                                                    <div id="archivo_constancia" style="font-size:13px">{{$estudiante->img_constancia ?? 'Sin archivo seleccionado' }}</div>
                                                </div>
                                                <input class='file' type="file" style="display: none" class="form-control" name="img_constancia" id="img_constancia" accept="application/pdf" required> --}}
                                            </div>
                                            {{-- <input id="constancia_hidden" name="constancia_hidden" type="hidden" value="{{ $estudiante->img_constancia ?? '#constancia#' }}"> --}}
                                        </div> 
                                    </div>
                                </div>
                                <button type="submit" id="btnSiguiente" name="btnSiguiente" class="next btn btn-info float-right mt-2">Siguiente</button>
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
    <script src="{{ mix('js/app.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('js/sb-admin.min.js') }}"></script>
</body>
</html>