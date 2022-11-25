@extends('layouts.main')
<script language="JavaScript" type="text/javascript">
    function checkNumber(event)
    {
        var aCode = event.which ? event.which : event.keyCode;
        if (aCode > 31 && (aCode < 48 || aCode > 57)) return false;
        return true;
    }

    function calculaTotal() {
        document.getElementById("total_folios").value = document.getElementById("folio_final").value - document.getElementById("folio_inicial").value + 1}
</script>
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
                <h1 class="h3 mb-0 text-gray-800"> <b> Nuevo Paquete de Boletos </b></h1> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                <a href="{{ route('boletos.paquetes-index') }}" class="float-right"> Atrás</a>
            </div>

        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('boletos.paquetes-crea') }}">
                @csrf
                <div class="row mb-3">
                    <label for="folio_inicial" class="col-md-4 col-form-label text-md-right">{{ __('Folio Inicial') }}</label>

                    <div class="col-md-6">
                        <input id="folio_inicial" type="text" onkeypress="return checkNumber(event)" onkeyup="calculaTotal()" class="form-control @error('folio_inicial') is-invalid @enderror" name="folio_inicial" value="{{ old('folio_inicial') }}" required autocomplete="folio_inicial" autofocus>

                        @error('folio_inicial')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="folio_final" class="col-md-4 col-form-label text-md-right">{{ __('Folio Final') }}</label>
                    <div class="col-md-6">
                        <input id="folio_final" type="text" onkeypress="return checkNumber(event)" onkeyup="calculaTotal()" class="form-control @error('folio_final') is-invalid @enderror" name="folio_final" value="{{ old('folio_final') }}" required autocomplete="folio_final" autofocus>

                        @error('folio_final')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="total_folios" class="col-md-4 col-form-label text-md-right">{{ __('Total Folios') }}</label>
                    <div class="col-md-6">
                        <input id="total_folios" type="text" onkeypress="return checkNumber(event)" class="form-control @error('total_folios') is-invalid @enderror" name="total_folios" value="{{ old('total_folios') }}" required autocomplete="folio_final" readonly>

                        @error('total_folios')
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