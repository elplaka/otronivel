@extends('layouts.main')
@section('content')
<div class="row">
    <div class="card mx-auto">
        <div>
            @if (session()->has('message'))
                <?php 
                    $tipo_msg = session()->get('tipo_msg');
                ?>
                @if ($tipo_msg == "success")
                    <div class="alert alert-success">
                @elseif ($tipo_msg == "danger")
                    <div class="alert alert-danger">    
                @endif
                
                <button type="button" class="close" data-dismiss="alert">
                    x
                </button>    
                
                {{ session()->get('message') }}
                </div>                
            @endif
            
        </div>
        <div class="card-header">
             <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800"> <b> Editar Monto Asignado </b></h1> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                <a href="{{ URL::previous() }}" class="float-right"> Atrás</a>
            </div>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('apoyos.asignacion-actualizar-estudiante', [$apoyo_asignado->id_estudiante, $apoyo_asignado->id_remesa]) }}">
                @csrf
                <table class="table table-sm table-hover">
                    <tr>
                        <td class="text-right"> <!-- Utiliza la clase text-right para alinear a la derecha -->
                            Remesa &nbsp;&nbsp;
                        </td>
                        <td>
                           <b>  {{ $apoyo_asignado->boleto_remesa->descripcion }} </b>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-right"> <!-- Utiliza la clase text-right para alinear a la derecha -->
                            Estudiante &nbsp;&nbsp;
                        </td>
                        <td>
                           <b>  {{ $apoyo_asignado->estudiante->primer_apellido . ' ' . $apoyo_asignado->estudiante->segundo_apellido . ' ' . $apoyo_asignado->estudiante->nombre }} </b>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-right"> <!-- Utiliza la clase text-right para alinear a la derecha -->
                            Escuela &nbsp;&nbsp;
                        </td>
                        <td>
                           <b>  {{ $apoyo_asignado->estudiante->escuela->escuela_abreviatura }} </b>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-right"> <!-- Utiliza la clase text-right para alinear a la derecha -->
                            Ciudad &nbsp;&nbsp;
                        </td>
                        <td>
                           <b>  {{ $apoyo_asignado->estudiante->cve_ciudad_escuela == 1 ? 'MAZATLÁN' : 'CULIACÁN' }} </b>
                        </td>
                    </tr>
                </table>

                <div class="row mb-3">
                    <label for="monto" class="col-md-3 col-form-label text-md-right">{{ __('Monto') }} </label>
                    <div class="col-md-4">
                        <input id="monto" class="form-control" name="monto" value="{{ old('monto', $apoyo_asignado->monto) }}" required autocomplete="monto" type="number" step="5" min="0" max="10000">
                    </div>
                </div>
                <div class="row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-verde">
                            {{ __('Actualizar') }}
                        </button>
                    </div>
                </div>
            </form> 
        </div>
    </div>
</div>
@endsection