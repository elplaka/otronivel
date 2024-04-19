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
                <h1 class="h3 mb-0 text-gray-800"> <b> Padrón de beneficiarios </b></h1> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                <a href="{{ route('estudiantes.index') }}" class="float-right"> Atrás</a>
            </div>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('estudiantes.padron-pdf') }}">
                @csrf
                <div class="row mb-3">
                    <label for="ciclo" class="col-md-4 col-form-label text-md-right">{{ __('Ciclo') }}</label>

                    <div class="col-md-5">
                        <select id="id_ciclo" name="id_ciclo" class = "form-control">
                            <option value="0">--SELECCIONA--</option>
                            <option value="-1">2022-2023</option>
                            <option value="-2">2023-2024</option>
                            <option value="1">2022-2023 :: 1</option>
                            <option value="2">2022-2023 :: 2</option>
                            <option value="3">2023-2024 :: 1</option>
                            <option value="4">2023-2024 :: 2</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-verde">
                            {{ __('Generar') }}
                        </button>
                    </div>
                </div>
            </form>            
        </div>
    </div>
</div>
@endsection