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
                <h1 class="h3 mb-0 text-gray-800"> <b> Boletos Asignados </b></h1>
                <a href="{{ route('boletos.asignacion-nueva') }}" title="Nueva Asignación de Boletos" class="btn btn-primary mb-2">+</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm table-hover table-bordered">
                    <thead class="thead-light">
                    <tr>
                        <th scope="col">Remesa</th>
                        <th scope="col">Estudiante</th>
                        <th scope="col">Folios </th>
                        <th scope="col">Entregados</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($asignados as $asignado)
                            <tr>
                                <th scope="row">{{ $asignado->id_remesa }}</th>
                                <td>{{ $asignado->estudiante->primer_apellido . ' ' . $asignado->estudiante->segundo_apellido }}</td>
                                <td>{{ $asignado->folio_inicial . ' ' . $asignado->folio_inicial  }}</td>
                                <td>{{ $asignado->entregados == 0 ? 'NO' : 'SÍ'  }}</td>
                                {{-- <td>
                                    <a href="{{ route('boletos.paquetes-editar', $paquete->id_paquete) }}" class="btn-sm btn-success"> <i class="fa-solid fa-pen-to-square"></i> </a>
                                </td> --}}
                            </tr>                            
                        @endforeach 
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection