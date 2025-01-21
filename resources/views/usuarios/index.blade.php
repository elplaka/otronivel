@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="card mx-auto">
            <div>
                @if (session()->has('message'))
                <div class="alert alert-success">
                    
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
                    <h1 class="h3 mb-0 text-gray-800"> <b> Usuarios </b></h1>
                </div>
                <div class="row">
                    <div class="col">
                        <form method="GET" action="{{ route('usuarios.index') }}">
                            <div class="form-row align-items-center">
                                <div class="col">
                                    <input type="search" name="search" class="form-control mb-2" id="inlineFormInput">
                                </div>
                                <div class="col">
                                    <button type="submit" class="btn btn-rojo mb-2"> Buscar </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <a href="{{ route('usuarios.create') }}" class="btn btn-verde mb-2">Crear</a>
                </div>            
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">E-mail</th>
                        <th scope="col"></th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($usuarios as $usuario)
                            <tr>
                                <th scope="row">{{ $usuario->id }}</th>
                                <td>{{ $usuario->name  }}</td>
                                <td>{{ $usuario->email }}</td>
                                <td>
                                    <a href="{{ route('usuarios.edit', $usuario->id) }}" class="btn btn-verde"> Editar </a>
                                </td>
                            </tr>                            
                        @endforeach 
                    </tbody>
                  </table>
            </div>
        </div>
    </div>
@endsection