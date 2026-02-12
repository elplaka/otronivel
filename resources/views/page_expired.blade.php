<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sesión Expirada - Gobierno de Concordia</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/png" href="{{ asset('Favicon.png') }}">

    <style>
        :root {
            --color-municipio: #820826;
            --color-municipio-hover: #61061d;
        }
        .bg-institucional { background-color: var(--color-municipio); }
        .text-institucional { color: var(--color-municipio); }
        .border-institucional { border-color: var(--color-municipio); }
        .hover-bg-institucional:hover { background-color: var(--color-municipio-hover); }

        @keyframes float {
            0% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-15px) rotate(1deg); }
            100% { transform: translateY(0px) rotate(0deg); }
        }
        .animate-float { animation: float 5s ease-in-out infinite; }

        .blob {
            position: absolute;
            width: 300px;
            height: 300px;
            background: rgba(130, 8, 38, 0.05);
            filter: blur(40px);
            border-radius: 50%;
            z-index: -1;
        }
    </style>
</head>
<body class="bg-white font-sans antialiased overflow-hidden">
    
    <div class="blob top-0 left-0"></div>
    <div class="blob bottom-0 right-0"></div>

    <div class="min-h-screen flex items-center justify-center p-6">
        <div class="max-w-2xl w-full text-center">
            
           <div class="mb-10 flex justify-center items-center">
                <div class="flex items-center space-x-4">
                   <div class="flex-shrink-0 overflow-hidden" style="width: 60px;"> 
                        <img src="{{ asset('img/Logo_y_Escudo.jpg') }}" alt="Escudo de Concordia" class="h-20 max-w-none object-cover object-left" style="width: 80px;">
                    </div>

                    <div class="pl-4 border-l-4 border-institucional py-1">
                        <span class="block text-2xl font-black tracking-tighter text-gray-800 leading-none uppercase">
                            <span class="text-lg font-bold tracking-widest text-gray-600">Gobierno del Municipio de Concordia</span>
                        </span>
                    </div>
                </div>
            </div>

            <div class="relative flex justify-center mb-10">
                <div class="text-[14rem] font-black text-gray-100 select-none leading-none">
                    419
                </div>
                
                <div class="absolute inset-0 flex items-center justify-center animate-float">
                    <div class="bg-white p-8 rounded-2xl shadow-2xl border-b-8 border-institucional">
                        <svg class="w-20 h-20 text-institucional" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <h1 class="text-3xl font-bold text-gray-900 mb-4">La sesión ha expirado</h1>
            <p class="text-lg text-gray-600 mb-10 leading-relaxed">
                Por seguridad, tu sesión se ha cerrado tras un periodo de inactividad. No te preocupes, puedes volver a intentarlo regresando al formulario.
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <button onclick="window.location.reload()" 
                    class="w-full sm:w-auto px-10 py-4 bg-institucional text-white font-semibold rounded-full shadow-lg hover-bg-institucional transition duration-300 transform hover:scale-105 flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    Actualizar página
                </button>
                
                <button onclick="window.history.back()" 
                        class="w-full sm:w-auto px-10 py-4 bg-white border-2 border-institucional text-institucional font-semibold rounded-full hover:bg-red-50 transition duration-300">
                    Regresar al formulario
                </button>
            </div>

            <div class="mt-20">
                <p class="text-xs uppercase tracking-[0.2em] text-gray-400 font-bold">
                    Gobierno del Municipio de Concordia &copy; {{ date('Y') }}
                </p>
            </div>

        </div>
    </div>
</body>
</html>