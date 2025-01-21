@extends('layouts.main')
@section('content')
<?php 
    function formato_fecha_espanol_corta($fecha)
    {
        $fecha2 = strtotime($fecha);
        $dia = date('d', $fecha2);
        $mes_numero = date('m', $fecha2);
        switch ($mes_numero)
        {
            case 1:
                $mes = "ENE";
                break;
            case 2:
                $mes = "FEB";
                break;
            case 3:
                $mes = "MAR";
                break;
            case 4:
                $mes = "ABR";
                break;
            case 5:
                $mes = "MAY";
                break;
            case 6:
                $mes = "JUN";
                break;
            case 7:
                $mes = "JUL";
                break;
            case 8:
                $mes = "AGO";
                break;
            case 9:
                $mes = "SEP";
                break;
            case 10:
                $mes = "OCT";
                break;
            case 11:
                $mes = "NOV";
                break;
            case 12:
                $mes = "DIC";
                break;
        }
        return $dia . '-' . $mes . '-' . date('Y', $fecha2);
    }
?>
<div class="row">
    <div class="card mx-auto w-50">
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
                <h1 class="h3 mb-0 text-gray-800"> <b> Montos </b></h1> &nbsp;&nbsp;
                <a href="{{ route('apoyos.montos-nuevos', ['id_remesa' => $id_remesa, 'cve_ciudad_escuela' => $cve_ciudad]) }}" title="Nuevos Montos" class="btn btn-verde mb-2"> +</a>
            </div>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('apoyos.montos-index', $id_remesa) }}">
                <div class="row">
                    <label for="id_remesa" class="col-md-3 col-form-label text-md-right">{{ __('Remesa') }} </label>
                    <div class="col-md-9">
                        <select id="id_remesa" name="id_remesa" class="form-control" @error('id_remesa') is-invalid @enderror aria-label="Default select example" onchange="this.form.submit()">
                            <option value=''>-- SELECCIONA REMESA --</option>
                            @foreach ($remesas as $remesa)
                                <option value="{{ $remesa->id_remesa }}" {{ $remesa->id_remesa == $id_remesa? 'selected' : '' }}>{{ $remesa->descripcion . ' :: ' . formato_fecha_espanol_corta($remesa->fecha) }}</option>
                            @endforeach
                        </select>
                        
                        @error('id_remesa')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <br>
                <div class="row">
                    <label for="cve_ciudad" class="col-md-3 col-form-label text-md-right">{{ __('Ciudad Escuela') }} </label>
                    <div class="col-md-9">
                        <select id="cve_ciudad" name="cve_ciudad" class="form-control" @error('id_remesa') is-invalid @enderror aria-label="Default select example" onchange="this.form.submit()">
                            <option value=''>-- SELECCIONA CIUDAD --</option>
                            @foreach ($ciudades as $ciudad)
                                <option value="{{ $ciudad->cve_ciudad }}" {{ $ciudad->cve_ciudad == $cve_ciudad? 'selected' : '' }}>{{ $ciudad->ciudad }}</option>
                            @endforeach
                        </select>
                        
                        @error('cve_ciudad')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
            </form>
            <br>
            <div class="table-responsive">
                <table class="table table-sm table-hover table-bordered">
                    <thead class="thead-light">
                    <tr>
                        <th scope="col">Remesa</th>
                        <th scope="col">Escuela</th>
                        <th scope="col">Monto</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($montos as $monto)
                            <tr>
                                <td scope="row">{{ isset($monto->monto) ? $monto->descripcion: "N/A" }}</td>
                                <td>{{ $monto->escuela_abreviatura }}</td>
                                <td>{{ isset($monto->monto) ? '$ ' . $monto->monto : "N/A" }}</td>                               
                                <td>
                                    @if (isset($monto->monto))
                                    <a href="{{ route('apoyos.monto-editar', [$monto->id_remesa, $monto->cve_ciudad_escuela, $monto->cve_escuela]) }}" class="btn-sm btn-verde"> <i class="fa-solid fa-pen-to-square"></i> </a>
                                    @else
                                    <a href="{{ route('apoyos.montos-nuevo-uno', [$monto->id_remesa, $monto->cve_ciudad_escuela, $monto->cve_escuela]) }}" class="btn-sm btn-verde"> <i class="fa-solid fa-square-plus"></i> </a>
                                    @endif
                                </td>
                            </tr>                            
                        @endforeach 
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection