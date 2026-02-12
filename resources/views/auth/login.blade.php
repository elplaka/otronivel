@extends('layouts.app')

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

                <div class="card-body px-lg-5 py-4">
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
                    <span class="text-muted small">¿Eres estudiante y buscas las becas?</span><br>
                    <a href="https://www.otronivel.concordia.gob.mx/estudiantes/forget" 
                        class="font-weight-bold" 
                        style="color: #00656c !important; text-decoration: none !important; transition: 0.3s;">
                        Regístrate aquí al Sistema de Becas 
                        <i class="fas fa-external-link-alt ml-1" style="font-size: 0.8rem;"></i>
                    </a>
                </div>
            </div>

            <div class="mt-4">
                <div class="alert alert-custom shadow-sm d-flex align-items-center" role="alert">
                    <i class="fas fa-exclamation-triangle mr-3 fa-lg"></i>
                    <div>
                        <strong>¡Atención Estudiante!</strong> Este acceso es solo para personal del sistema. Para inscribirte, usa el enlace de arriba.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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
</style>
@endsection
