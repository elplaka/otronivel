@extends('layouts.app')

<style>
    /* ... Tus estilos anteriores de .btn-rojo y .form-control ... */
    
    .form-control-alternative {
        border-radius: 10px;
        border: 1px solid #e9ecef;
        background-color: white;
    }

    .btn-block {
        border-radius: 12px !important;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 0.9rem !important;
    }

    .alert-custom {
        background-color: white;
        border-left: 5px solid #c53030; /* Acento lateral para que parezca advertencia */
        color: #c53030;
        border-radius: 8px;
        padding: 20px;
    }

    .text-info:hover {
        color: #118b52ff !important;
        text-decoration: underline !important;
    }

    .btn-moderno {
        background: linear-gradient(45deg, #932f4a, #c13d5a); /* Gradiente base */
        color: white !important;
        border: none;
        border-radius: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        position: relative;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1); /* Transición suave */
        box-shadow: 0 4px 15px rgba(147, 47, 74, 0.3);
    }

    .btn-moderno:hover {
        background: linear-gradient(45deg, #a53553, #d94668); /* Gradiente más vivo */
        transform: translateY(-3px) scale(1.02); /* Se eleva y crece ligeramente */
        box-shadow: 0 8px 25px rgba(147, 47, 74, 0.5); /* Resplandor tecnológico (Glow) */
        letter-spacing: 2px; /* Efecto dinámico en el texto */
    }

    .btn-moderno:active {
        transform: translateY(-1px);
    }

    /* Efecto de brillo "barrido" al pasar el mouse */
    .btn-moderno::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(
            120deg,
            transparent,
            rgba(255, 255, 255, 0.3),
            transparent
        );
        transition: all 0.6s;
    }

    .btn-moderno:hover::before {
        left: 100%;
    }

    .alert-custom {
        /* Un rosa muy suave con matiz grisáceo para que no sea chillón */
        background-color: #fce8ed; 
        
        /* Color guinda elegante (Vinotinto/Burgundy) */
        color: #630d16; 
        
        /* Borde sutil basado en el guinda con transparencia */
        border: 1px solid rgba(99, 13, 22, 0.1); 
        
        border-radius: 8px;
        padding: 1rem 1.25rem;
        position: relative;
        overflow: hidden;
    }

    .alert-accent {
        /* El borde izquierdo usa el color exacto del texto */
        border-left: 5px solid #630d16 !important;
    }

    /* Opcional: Para que el icono resalte sutilmente */
    .alert-custom i {
        color: #8a1522;
    }

    /* Efecto Hover para compensar la falta de subrayado */
    .btn-link-convocatoria:hover {
        color: #0dadb9 !important; /* Un tono un poco más claro al pasar el mouse */
        background-color: rgba(0, 101, 108, 0.05); /* Fondo muy sutil */
        border-radius: 4px;
    }

    /* Animación de la flecha para guiar el ojo hacia la acción */
    .btn-link-convocatoria:hover .icon-move {
        transform: translateX(4px);
        transition: 0.3s;
    }

    @keyframes pulse-soft {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }

    .fa-user-graduate {
        animation: pulse-soft 2s infinite ease-in-out;
    }
</style>

@php
    // Recuperamos el ID de la sesión que puso el middleware
    $id_ciclo = session('ciclo');
    
    // Consultamos el modelo Ciclo
    $ciclo = \App\Models\Ciclo::where('id_ciclo', $id_ciclo)->first();
    
    // Determinamos si está abierta (si no hay ciclo, por defecto false)
    $estaAbierta = $ciclo ? $ciclo->convocatoria_abierta : false;
@endphp

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-lg border-0" style="border-radius: 20px; overflow: hidden;">
                
                <div class="bg-white py-4">
                    <div class="d-flex justify-content-center align-items-center">
                        <img src="{{ url('img/Logo_y_Escudo.jpg') }}" class="img-fluid mx-2" style="max-height: 50px; width: auto;">
                        <div style="width: 1px; height: 40px; background-color: #dee2e6;" class="mx-3 d-none d-sm-block"></div>
                        <img src="{{ url('img/logo_programa.jpg') }}" class="img-fluid mx-2" style="max-height: 50px; width: auto;">
                    </div>
                </div>

                <div class="card-body px-lg-5 py-0">
                    <div class="text-center mb-4">
                        <h4 class="font-weight-bold" style="color: #344767;">{{ __('Inicio de Sesión') }}</h4>
                        <p class="text-muted small">{{ __('Acceso exclusivo para administradores y personal autorizado') }}</p>
                    </div>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group mb-3">
                            <label for="email" class="small font-weight-bold text-uppercase text-muted" style="letter-spacing: 0.5px;">{{ __('Correo Electrónico') }}</label>
                            <div class="input-group input-group-merge">
                                <input id="email" type="email" class="form-control form-control-alternative @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="ejemplo@correo.com">
                            </div>
                            @error('email')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label for="password" class="small font-weight-bold text-uppercase text-muted" style="letter-spacing: 0.5px;">{{ __('Contraseña') }}</label>
                            <input id="password" type="password" class="form-control form-control-alternative @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="••••••••">
                            @error('password')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-block btn-moderno shadow py-3 mb-3">
                            {{ __('Ingresar al Sistema') }}
                        </button>
                    </form>
                </div>

                <div class="card-footer bg-white border-0 pb-4 text-center">
                    <span class="text-muted small d-block mb-1">¿Eres estudiante y buscas las becas?</span>

                    @if ($estaAbierta)
                        {{-- Estado Activo: Limpio, sin subrayado, con feedback al pasar el mouse --}}
                        <a href="{{ route('estudiantes.forget') }}" 
                        class="btn-link-convocatoria"
                        style="color: #00656c; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; transition: 0.3s; padding: 5px 10px;">
                            
                            <span>Regístrate aquí al Sistema de Becas</span>
                            
                            <i class="fas fa-arrow-right ml-2 icon-move" style="font-size: 0.8rem;"></i>
                        </a>
                    @else
                        {{-- Estado Cerrado --}}
                        <div class="d-inline-flex align-items-center justify-content-center p-2 px-3" 
                            style="background-color: #f8f9fa; border-radius: 50px; border: 1px solid #e9ecef; cursor: default;">
                            <i class="fas fa-lock text-muted mr-2" style="font-size: 0.8rem;"></i>
                            <span class="text-secondary font-weight-bold small" style="letter-spacing: 0.5px;">
                                CONVOCATORIA CERRADA
                            </span>             
                        </div>
                        <p class="text-muted mt-2" style="font-size: 0.7rem;">
                            Mantente pendiente de nuestras redes para la próxima apertura.
                        </p>
                    @endif
                </div>
            </div>

           <div class="mt-4">
                @if ($estaAbierta)
                    {{-- Alerta cuando la convocatoria está ABIERTA --}}
                    <div class="alert shadow-sm d-flex align-items-center" role="alert" 
                        style="background-color: #f8eeef; border-left: 5px solid #6c1d45; color: #4a1430; border-radius: 8px;">
                        <i class="fas fa-user-graduate mr-3 fa-2x" style="color: #6c1d45;"></i>
                        <div>
                            <strong style="font-size: 1.1rem; color: #6c1d45;">¿Buscas registrarte?</strong><br>
                            Este formulario es <span class="font-weight-bold">exclusivo para personal administrativo</span>. 
                            Da click 
                            <a href="{{ route('estudiantes.forget') }}" 
                            style="color: #4a1430; font-weight: 800; text-decoration: underline;">aquí</a> 
                            para iniciar tu registro como estudiante.
                        </div>
                    </div>
                @else
                    {{-- Alerta cuando la convocatoria está CERRADA --}}
                    <div class="alert shadow-sm d-flex align-items-center" role="alert" 
                        style="background-color: #e2f3f5; border-left: 5px solid #00656c; color: #004a4f; border-radius: 8px;">
                        <i class="fas fa-info-circle mr-3 fa-lg"></i>
                        <div>
                            <strong>Aviso importante:</strong> El periodo de registros para estudiantes ha finalizado. 
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>


@endsection
