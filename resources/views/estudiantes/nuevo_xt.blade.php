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
                    &times;
                </button>    
                
                {{ session()->get('message') }}
                </div>                
            @endif
            
        </div>
        <div class="card-header">
             <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-3">
                <h1 class="h3 mb-0 text-gray-800"> <b> Estudiantes Extemporáneos </b></h1> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                <a href="{{ route('estudiantes.index') }}" class="float-right"> Atrás</a>
            </div>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('estudiantes.crea-xt') }}">
                @csrf
                <div class="row mb-3">
                    <label for="curp" class="col-md-4 col-form-label text-md-right">{{ __('CURP') }}</label>

                    <div class="col-md-6">
                        <input id="curp" class="form-control @error('curp') is-invalid @enderror" name="curp" value="{{ old('curp') }}" required autocomplete="curp" autofocus>

                        @error('curp')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-verde">
                            {{ __('Agregar') }}
                        </button>
                    </div>
                </div>
            </form>
            <br>
            <div class="table-responsive">
                <table class="table table-sm table-hover table-bordered">
                    <thead class="thead-light">
                    <tr>
                        <th scope="col">CURP</th>
                        <th scope="col">Registrado</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($estudiantes_xt as $estudiante_xt)
                            <tr>
                                <td scope="row">{{ $estudiante_xt->curp }}</td>
                                <td>{{ !is_null($estudiante_xt->estudiante()) ? 'SÍ' : 'NO' }}</td>
                            </tr>                            
                        @endforeach 
                    </tbody>
                </table>
        </div>
    </div>
</div>
@endsection