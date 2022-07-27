@extends('layouts.main')

<?php
    $usertype = auth()->user()->usertype;
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
?>
@section('content')
    <!-- Page Heading -->
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
                            Estudiantes</b></h1>
                        </div>
                        <form method="GET" action="{{ route('estudiantes.index') }}">
                            <div class="row">
                                 <div class="col-md-3">
                                    <label class="col-md-6 col-form-label text-md-left"> &nbsp </label>
                                    <div>
                                        <input type="search" name="search" class="form-control mb-2" id="inlineFormInput" value="{{ old('search', $searchR) }}" placeholder="Nombre o Apellidos" autofocus>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label class="col-md-4 col-form-label text-md-left"> <b> Estatus </b> </label>
                                    <div class="search_select_box">
                                        <select name="selStatus[]" id="selStatus" data-style="btn-selectpicker" title="-- TODOS --" class="selectpicker" data-style-base="form-control"  autofocus multiple>
                                            @foreach ($status as $stat)
                                                <option value="{{ $stat->cve_status }}" {{ encuentraStatus($stat->cve_status, $statusR) ? 'selected' : '' }}>{{ $stat->descripcion }} </li>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                {{-- <div class="col-md-3">
                                    <label class="col-md-4 col-form-label text-md-left"> <b> Escuela </b> </label>
                                    <div class="search_select_box">
                                        <select name="selEscuela[]" id="selEscuela" data-style="btn-selectpicker" data-live-search="true" title="-- TODAS --" class="selectpicker" data-size="8" autofocus multiple>
                                            @foreach ($escuelas as $escuela)
                                                <option value="{{ $escuela->cve_escuela }}" {{ encuentraEscuela($escuela->cve_escuela, $cve_escuelaR) ? 'selected' : '' }}>{{ $escuela->escuela_abreviatura }} </li>
                                            @endforeach
                                            <option value="999">OTRA</option>
                                        </select>
                                    </div>
                                </div> --}}
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-primary"> Buscar </button>
                                </div>
                            </div>
                        </form>
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

                                switch ($estudiante->cve_status)
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
                            <tr title={{ $estudiante->status->descripcion }}>
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
                  {{-- N° de registros: {{ $estudiantes->count() }} --}}
            </div>
        </div>
    </div>
@endsection