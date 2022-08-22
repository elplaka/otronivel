@extends('layouts.main')

<?php
    if (isset(auth()->user()->usertype))
    {
        $usertype = auth()->user()->usertype;
    }
    else 
    {
        return redirect()->to('/');
    }

    $i = 1;

    function encuentraStatus($status, $statusR)
    {
        if (!isset($statusR)) return false;  //Si son TODOS los status
        foreach ($statusR as $statR)  //Recorre todos los status
        {
            if ($status == $statR) return true;  //Si el status es igual al del request
        }
        return false;
    }

    function encuentraEscuela($cve_escuela, $cve_escuelaR)
    {
        if (!isset($cve_escuelaR)) return false;
        foreach ($cve_escuelaR as $cve_escR)
        {
            if ($cve_escuela == $cve_escR) return true;
        }
        return false;
    }

    function encuentraLocalidad($cve_localidad, $cve_localidadR)
    {
        if (!isset($cve_localidadR)) return false;
        foreach ($cve_localidadR as $cve_locR)
        {
            if ($cve_localidad == $cve_locR) return true;
        }
        return false;
    }

    function encuentraTurno($cve_turno, $cve_turnoR)
    {
        if (!isset($cve_turnoR)) return false;
        foreach ($cve_turnoR as $cve_turR)
        {
            if ($cve_turno == $cve_turR) return true;
        }
        return false;
    }

    function encuentraAno($ano, $anoR)
    {
        if (!isset($anoR)) return false;
        foreach ($anoR as $anR)
        {
            if ($ano == $anR) return true;
        }
        return false;
    }

    function encuentraPromedio($promedio, $promedioR)
    {
        if (!isset($promedioR)) return false;
        foreach ($promedioR as $promR)
        {
            if ($promedio == $promR) return true;
        }
        return false;
    }
?>
@section('content')
    <!-- Page Heading -->
    <script language="JavaScript" type="text/javascript">
        $(document).ready(function () {
            $('#btnImprimir').click(function(){
             $("#exampleModal").modal("show");
            });
         });
     </script>

      <script language="JavaScript" type="text/javascript">
        $(document).ready(function(){
            $('#btnAceptar').click(function(){
                var databack = $("#exampleModal #recipient-name").val().trim();   //Nombre del Reporte
                $('#tituloReporte').val(databack);

                //Abre el formulario con el PDF
                var f = document.getElementById("formReport");
                
                f.action = "{{ route('estudiantes.pdf') }}";
            
                f.submit();   

                $('#exampleModal').modal('hide');    //Cierra la ventana modal
            });
        });    
    </script>
    {{-- ***********************************  Ventana MODAL  ************************************************* --}}
    <div class="modal fade" id="exampleModal" name="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><b> <i class="fas fa-print"></i> Opciones del Reporte</b></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> &times; </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label"> <b> Título del Reporte </b></label>
                        <input type="text" value="Reporte de Estudiantes" class="form-control" id="recipient-name">
                    </div>
                </div>
                <div class="modal-footer">
                        <button type="button" id="btnAceptar" type="submit" class="btn btn-danger btn-sm action-complete-task">Generar</button>
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
 
    <div class="container-fluid">
        <div class="card mx-auto">
            <?php  
                if (session()->has('msg_type'))  $msg_type = session()->get('msg_type');
                else $msg_type = "info";
            ?>
            <div>
                @if (session()->has('message'))
                <div class="alert alert-{{ $msg_type }} mb-0">                        
                    <button type="button" class="close" data-dismiss="alert">
                        &times;
                    </button>                        
                    {!! html_entity_decode(session()->get('message')) !!}
                </div>
                <br>
                @endif 
            </div>
            <div class="card-header mt-0">
                <div class="row mb-0">
                    <div class="col">
                        <div class="d-sm-flex align-items-center justify-content-between mb-0">
                            <h1 class="h3 mt-2 mb-0 text-gray-800"><b>
                            Estudiantes</b></h1> <a href="{{ route("estudiantes.forget") }}" class="btn btn-success" title="Registrar estudiante"> <b> + </b> </a>
                        </div>
                        <div class="card mt-3">
                            <div class="card-header bg-info" style="color:#ffffff;padding:2px;font-size:15px">
                               &nbsp; <i class="fas fa-search"></i> &nbsp; Parámetros de Búsqueda  &nbsp; <a data-toggle="collapse" href="#collapseExample" aria-controls="collapseExample" style="color:#ffffff"><i class="fas fa-angle-double-down"></i></a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  <i class="fas fa-database"></i> &nbsp; Total de estudiantes registrados: <b> {{ $totEstudiantes }} </b> 
                            </div>
                            <div class="collapse" id="collapseExample">
                                <div class="card-body" style="padding-top:5px">    
                                    <form method="GET" action="{{ route('estudiantes.index') }}">
                                        <div class="row mb-1">
                                            <div class="col-md-4"> {{-- INFORMACIÓN PERSONAL --}}
                                                <label class="col-form-label text-md-left" style="font-size:13px"> <b> &nbsp; Nombre/Apellidos </b> </label>
                                                <div>
                                                    <input type="search" name="search" class="form-control mb-2" id="inlineFormInput" value="{{ old('search', $searchR) }}" style="font-size:12px" autofocus>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="col-form-label text-md-left" style="font-size:13px"> <b> &nbsp; Lugar Origen </b> </label>
                                                <div class="search_select_box">
                                                    <select name="selLocalidadO[]" id="selLocalidadO" data-style="btn-selectpicker" data-live-search="true" title="-- TODOS --" class="form-control selectpicker" data-style-base="form-control" data-size="8" autofocus multiple>
                                                        @foreach ($localidades as $localidad)
                                                            <option value="{{ $localidad->cve_localidad }}" {{ encuentraLocalidad($localidad->cve_localidad, $cve_localidadOR) ? 'selected' : '' }}>{{ $localidad->localidad }} </li>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">  
                                                <label class="col-form-label text-md-left" style="font-size:13px"> <b> &nbsp; Estatus </b> </label>
                                                <div class="search_select_box">
                                                    <select name="selStatus[]" id="selStatus" data-style="btn-selectpicker" title="-- TODOS --" class="form-control selectpicker" data-style-base="form-control" autofocus multiple>
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
                                                                }
                                                            ?>
                                                            <option style="background: {{ $color }}; color: #ffffff; font-weight: bold" value="{{ $stat->cve_status }}" {{ encuentraStatus($stat->cve_status, $statusR) ? 'selected' : '' }}>{{ $stat->descripcion }} </li>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="col-form-label text-md-left" style="font-size:13px"> <b> &nbsp; Información Socioeconómica </b> </label>
                                                <div class="search_select_box">
                                                    <select name="selSocioeconomica" id="selSocioeconomica" data-style="btn-selectpicker" class="form-control selectpicker" data-style-base="form-control" autofocus>
                                                        <option value="" selected> -- TODOS -- </option>
                                                        <option value=1 {{ $socioeconomicaR == 1 ? 'selected' : '' }}> SIN OBSERVACIONES </option>
                                                        <option value=2 {{ $socioeconomicaR == 2 ? 'selected' : '' }}> CON OBSERVACIONES </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">  {{-- INFORMACIÓN ESCOLAR --}}
                                            <div class="col-md-2">
                                                <label class="col-form-label text-md-left" style="font-size:13px"> <b> &nbsp; Escuela </b> </label>
                                                <div class="search_select_box">
                                                    <select name="selEscuela[]" id="selEscuela" data-style="btn-selectpicker" data-live-search="true" title="-- TODAS --" class="form-control selectpicker" data-style-base="form-control" data-size="8" autofocus multiple>
                                                        @foreach ($escuelas as $escuela)
                                                            <option value="{{ $escuela->cve_escuela }}" {{ encuentraEscuela($escuela->cve_escuela, $cve_escuelaR) ? 'selected' : '' }}>{{ $escuela->escuela_abreviatura }} </li>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="col-form-label text-md-left" style="font-size:13px"> <b> &nbsp; Ciudad Escuela </b> </label>
                                                <div class="search_select_box">
                                                    <select name="selCiudad" id="selCiudad" data-style="btn-selectpicker" title="-- TODAS --" class="form-control selectpicker" data-style-base="form-control" autofocus>
                                                        <option value="" selected> -- TODAS -- </option>
                                                        @foreach ($ciudades as $ciudad)
                                                            <option value="{{ $ciudad->cve_ciudad }}" {{ $ciudad->cve_ciudad == $cve_ciudadR ? 'selected' : '' }}>{{ $ciudad->ciudad }} </li>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="col-form-label text-md-left" style="font-size:13px"> <b> &nbsp; Carrera </b> </label>
                                                <div>
                                                    <input type="search" name="searchCarrera" class="form-control mb-2" id="inlineFormInput" value="{{ old('searchCarrera', $carreraR) }}" style="font-size:12px" autofocus>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="col-form-label text-md-left" style="font-size:13px"> <b> &nbsp; Turno Escuela </b> </label>
                                                <div class="search_select_box">
                                                    <select name="selTurno[]" id="selTurno" data-style="btn-selectpicker" title="-- TODOS --" class="form-control selectpicker" data-style-base="form-control" autofocus multiple>
                                                        @foreach ($turnos as $turno)
                                                            <option value="{{ $turno->cve_turno }}" {{ encuentraTurno($turno->cve_turno, $cve_turnoR) ? 'selected' : '' }}>{{ $turno->turno }} </li>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="col-form-label text-md-left" style="font-size:13px"> <b> &nbsp; Año Escolar </b> </label>
                                                <div class="search_select_box">
                                                    <select name="selAnoEscolar[]" id="selAnoEscolar" data-style="btn-selectpicker" title="-- TODOS --" class="form-control selectpicker" data-style-base="form-control" autofocus multiple>
                                                        <option value=1 {{ encuentraAno(1, $ano_escolarR) ? 'selected' : '' }}> PRIMERO </option>
                                                        <option value=2 {{ encuentraAno(2, $ano_escolarR) ? 'selected' : '' }}> SEGUNDO </option>
                                                        <option value=3 {{ encuentraAno(3, $ano_escolarR) ? 'selected' : '' }}> TERCERO </option>
                                                        <option value=4 {{ encuentraAno(4, $ano_escolarR) ? 'selected' : '' }}> CUARTO </option>
                                                        <option value=5 {{ encuentraAno(5, $ano_escolarR) ? 'selected' : '' }}> QUINTO </option>
                                                        <option value=6 {{ encuentraAno(6, $ano_escolarR) ? 'selected' : '' }}> SEXTO </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="col-form-label text-md-left" style="font-size:13px"> <b> &nbsp; Promedio </b> </label>
                                                <div class="search_select_box">
                                                    <select name="selPromedio[]" id="selPromedio" data-style="btn-selectpicker" title="-- TODOS --" class="form-control selectpicker" data-style-base="form-control" autofocus multiple>
                                                        <option value=1 {{ encuentraPromedio(1, $promedioR) ? 'selected' : '' }}> 9 - 10 </option>
                                                        <option value=2 {{ encuentraPromedio(2, $promedioR) ? 'selected' : '' }}> 8 - 9 </option>
                                                        <option value=3 {{ encuentraPromedio(3, $promedioR) ? 'selected' : '' }}> 7 - 8 </option>
                                                        <option value=4 {{ encuentraPromedio(4, $promedioR) ? 'selected' : '' }}> 6 - 7 </option>
                                                        <option value=5 {{ encuentraPromedio(5, $promedioR) ? 'selected' : '' }}> 5 - 6 </option>
                                                        <option value=6 {{ encuentraPromedio(6, $promedioR) ? 'selected' : '' }}> < 5 </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-0">
                                            <div class="col-md-1">
                                                <button type="submit" class="btn btn-info btn-sm"> Buscar </button>
                                            </div>
                                            <div class="col-md-3 text-md-right" style="font-size:13px">
                                                <label class="col-form-label" style="font-size:13px"> <b> &nbsp; Documentación </b> </label>
                                            </div>
                                            <div class="col-md-2" style="font-size:13px">
                                                <div class="search_select_box">
                                                    <select name="selDocumentacion" id="selDocumentacion" data-style="btn-selectpicker" class="form-control selectpicker" data-style-base="form-control" autofocus>
                                                        <option value="" selected> -- TODOS -- </option>
                                                        <option value=1 {{ $documentacionR == 1 ? 'selected' : '' }}> COMPLETA </option>
                                                        <option value=2 {{ $documentacionR == 2 ? 'selected' : '' }}> INCOMPLETA </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 text-md-right" style="font-size:13px">
                                                <label class="col-form-label" style="font-size:13px"> <i class="fas fa-sort"></i> <b> &nbsp; Ordenar por <i class="fas fa-angle-double-right"></i> </b> </label>
                                            </div>
                                            <div class="col-md-2" style="font-size:13px">
                                                <div class="search_select_box">
                                                    <select name="selOrderBy1" id="selOrderBy1" data-style="btn-selectpicker" class="form-control selectpicker" data-style-base="form-control" autofocus>
                                                        <option value="" selected> -- SIN ORDENAR -- </option>
                                                        <option value=1 {{ $orderBy1R == 1 ? 'selected' : '' }}> APELLIDOS </option>
                                                        <option value=0 {{ isset($orderBy1R) && $orderBy1R == 0 ? 'selected' : '' }}> NOMBRE </option>
                                                        <option value=2 {{ $orderBy1R == 2 ? 'selected' : '' }}> ESCUELA </option>
                                                        <option value=3 {{ $orderBy1R == 3 ? 'selected' : '' }}> CARRERA </option>
                                                        <option value=4 {{ $orderBy1R == 4 ? 'selected' : '' }}> CIUDAD ESCUELA </option>
                                                        <option value=5 {{ $orderBy1R == 5 ? 'selected' : '' }}> TURNO ESCUELA </option>
                                                        <option value=6 {{ $orderBy1R == 6 ? 'selected' : '' }}> AÑO ESCOLAR </option>
                                                        <option value=7 {{ $orderBy1R == 7 ? 'selected' : '' }}> PROMEDIO </option>
                                                        <option value=8 {{ $orderBy1R == 8 ? 'selected' : '' }}> LUGAR ORIGEN </option>
                                                    </select>
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
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-hover table-bordered">
                        <thead class="thead-light">
                        <tr>
                            <th class="col-md-auto">#</th>
                            <th class="col-sm-4">Nombre</th>
                            <th class="col-sm-2">Escuela - Ciudad</th>
                            <th class="col-sm-3">Carrera</th>
                            <th class="col-md-auto"></th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($estudiantes as $estudiante)
                                <?php
                                    if ($estudiante->cve_ciudad_escuela == 1) $ciudadEscuela = "MZT";
                                    elseif ($estudiante->cve_ciudad_escuela == 2) $ciudadEscuela = "CLN";
                                    else $ciudadEscuela = "NULL";

                                    switch ($estudiante->cve_status)  // Se colorea el borde izquierdo de la celda de acuerdo al status del estudiante
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
                                    }
                                ?>
                                <tr title={{ $estudiante->status->descripcion }} style="font-size:15px">
                                    <td scope="row" style="border-left: 4px solid {{ $color }}; vertical-align:middle">{{ $i++ }}</td>
                                    <td style="vertical-align:middle">{{ $estudiante->nombre . ' ' . $estudiante->primer_apellido . ' ' . $estudiante->segundo_apellido }} &nbsp;</td>
                                    <td style="vertical-align:middle">{{ $estudiante->escuela->escuela_abreviatura }} <i class="fas fa-map-marker-alt"></i> {{ $ciudadEscuela }} &nbsp;</td>
                                    <td style="vertical-align:middle">{{ $estudiante->carrera }} &nbsp;</td>
                                    <td style="vertical-align:middle"> @if ($usertype < 3) <a href="{{ route('estudiantes.edit', $estudiante->id) }}" title="Editar" class="btn btn-success btn-sm"><i class="fas fa-user-edit"></i></a> <a href="{{ route('estudiantes.edit_status', $estudiante->id) }}" title="Cambiar estatus" class="btn btn-danger btn-sm"><i class="fas fa-flag"></i></a> @if ($estudiante->cve_status >= 2) <a href="{{ route('estudiantes.edit_se', $estudiante->id) }}" title="Censar" class="btn btn-primary btn-sm"><i class="fas fa-street-view"></i></a> @endif @endif <a href="{{ route('estudiantes.registro_pdf_post', $estudiante->id_hex) }}" title="Imprimir" class="btn btn-info btn-sm"><i class="fas fa-print"></i></a></td>
                                </tr> 
                                <?php 
                                ?>                         
                            @endforeach 
                        </tbody>
                    </table>
                </div>
                <div>
                    <label class="col-form-label float-left">
                        {{ $estudiantes->links('pagination::bootstrap-5') }} 
                    </label>
                    <form method="GET" id="formReport" action="{{ route('estudiantes.pdf') }}">
                        <input id="tituloReporte" name="tituloReporte" type="hidden"  value="" class="form-control">
                        @if (Auth::user()->usertype == 1)  
                            <div class="float-right">
                                <button id="btnImprimir" name="btnImprimir" type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#exampleModal"> <i class="fas fa-file-export"></i> <b> PDF </b> </button>
                            </div>
                        @endif
                    </form>
                </div>
             </div>

        </div>
    </div>
@endsection