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
                <h1 class="h3 mb-0 text-gray-800"> <b> Editar Tantos de Boletos </b></h1> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                <a href="{{ route('boletos.tantos-index') }}" class="float-right"> Atrás</a>
            </div>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('boletos.tantos-actualizar', [$tanto->id_remesa, $tanto->cve_escuela]) }}">
                @csrf
                <div class="row mb-3">
                    <label for="id_remesa" class="col-md-4 col-form-label text-md-right">{{ __('Remesa') }} </label>
                    <div class="col-md-7">
                        <select id="id_remesa" name="id_remesa" class="form-control" disabled>
                            @foreach ($remesas as $remesa)
                                <option value="{{ $remesa->id_remesa }}" {{ $remesa->id_remesa == $tanto->id_remesa? 'selected' : '' }}>{{ $remesa->descripcion }}</option>
                            @endforeach
                        </select>
                        
                        @error('id_remesa')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="escuela" class="col-md-4 col-form-label text-md-right">{{ __('Escuela') }} </label>
                    <div class="col-md-7">
                        <input id="escuela" type="text" class="form-control" name="escuela" value="{{ old('escuela', $tanto->escuela->escuela_abreviatura) }}" required autocomplete="escuela" readonly>
                        
                        @error('cve_escuela')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    </div>
                </div>
               
                <div class="row mb-3">
                    <label for="cantidad_folios" class="col-md-4 col-form-label text-md-right">{{ __('Cant. Folios') }}</label>
                    <div class="col-md-3">
                        <input id="cantidad_folios" type="number" class="form-control @error('cantidad_folios') is-invalid @enderror" name="cantidad_folios" value="{{ old('cantidad_folios', $tanto->cantidad_folios) }}" required autocomplete="cantidad_folios" autofocus>  

                        @error('cantidad_folios')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Guardar') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection