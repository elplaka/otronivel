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
                <h1 class="h3 mb-0 text-gray-800"> <b> Paquetes de Boletos </b></h1>
                <a href="{{ route('boletos.paquetes-nuevo') }}" title="Nuevo Paquete" class="btn btn-primary mb-2">+</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm table-hover table-bordered">
                    <thead class="thead-light">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Folio Inicial</th>
                        <th scope="col">Folio Final</th>
                        <th scope="col">Ult. Asignado </th>
                        <th scope="col">Disponibles </th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($paquetes as $paquete)
                            <tr>
                                <th scope="row">{{ $paquete->id_paquete }}</th>
                                <td>{{ $paquete->folio_inicial  }}</td>
                                <td>{{ $paquete->folio_final }}</td>
                                <td>{{ $paquete->ult_folio_asignado == 0 ? '-' : $paquete->ult_folio_asignado  }}</td>
                                <td>{{ $paquete->folios_disponibles }}</td>
                                <td>
                                    @if ($paquete->ult_folio_asignado == 0)
                                    <a href="{{ route('boletos.paquetes-editar', $paquete->id_paquete) }}" class="btn-sm btn-success"> <i class="fa-solid fa-pen-to-square"></i> </a>
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