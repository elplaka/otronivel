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
                <h1 class="h3 mb-0 text-gray-800"> <b> Tantos de Boletos </b></h1> &nbsp;&nbsp;
                <a href="{{ route('boletos.tantos-nuevos', $id_remesa) }}" title="Nuevos Tantos" class="btn btn-verde mb-2"> +</a>
            </div>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('boletos.tantos-index', $id_remesa) }}">
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
            </form>
            <br>
            <div class="table-responsive">
                <table class="table table-sm table-hover table-bordered">
                    <thead class="thead-light">
                    <tr>
                        <th scope="col">Remesa</th>
                        <th scope="col">Escuela</th>
                        <th scope="col">Cant. Folios</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($tantos as $tanto)
                            <tr>
                                <td scope="row">{{ isset($tanto->id_remesa) ? $tanto->boleto_remesa->descripcion: "N/A" }}</td>
                                <td>{{ $tanto->escuela->escuela_abreviatura }}</td>
                                <td>{{ isset($tanto->id_remesa) ? $tanto->cantidad_folios : "N/A" }}</td>                               
                                <td>
                                    @if (isset($tanto->id_remesa))
                                    <a href="{{ route('boletos.tantos-editar', [$tanto->id_remesa, $tanto->cve_escuela]) }}" class="btn-sm btn-dorado"> <i class="fa-solid fa-pen-to-square"></i> </a>
                                    @else
                                    <a href="{{ route('boletos.tantos-nuevo-uno', $tanto->cve_escuela) }}" class="btn-sm btn-dorado"> <i class="fa-solid fa-square-plus"></i> </a>
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