<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>OTRO NIVEL :: Información de Registro</title>
    <link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet'>
    <link rel="icon" type="image/png" href="{{ asset('Favicon.png') }}">

    <?php 
        use SimpleSoftwareIO\QrCode\Facades\QrCode;

        // Carga de Imágenes a Base64
        function imageToBase64($path) {
            if (file_exists($path)) {
                $type = pathinfo($path, PATHINFO_EXTENSION);
                $data = file_get_contents($path);
                return 'data:image/' . $type . ';base64,' . base64_encode($data);
            }
            return null;
        }

        $logo_aliviane = imageToBase64(getcwd() . '/img/logo_programa.jpg');
        $logo_admon    = imageToBase64(getcwd() . '/img/Logo_y_Escudo.jpg');
        $footer_pattern = imageToBase64(getcwd() . '/img/Pattern_Footer.jpg');

        // Generación de QR (Formato PNG es más compatible con dompdf que SVG)
        $qrcode = base64_encode(QrCode::format('svg')->size(300)->margin(1)->generate(URL::to("/") . '/registro' . '/' . $estudiante->id_hex));

        // Lógica de Año Escolar
        $anos = [1 => "PRIMERO", 2 => "SEGUNDO", 3 => "TERCERO", 4 => "CUARTO", 5 => "QUINTO", 6 => "SEXTO"];
        $ano_escolar_txt = $anos[$estudiante->ano_escolar] ?? "N/A";
    ?>

    <style>
        @page { margin: 1cm 1.5cm; }
        
        body {
            font-family: 'Montserrat', Helvetica, Arial, sans-serif;
            color: #333;
            line-height: 1.2;
            font-size: 11px;
        }

        /* Cabecera */
        .header-container { text-align: center; margin-bottom: 10px; }
        .logo-admon { width: 55%; margin-bottom: 5px; }
        .logo-programa { width: 38%; }

        /* QR Flotante */
        .qr-box {
            position: absolute;
            top: 135px;
            right: 0;
            text-align: center;
            width: 90px;
        }
        .qr-box img { width: 100%; border: 1px solid #eee; }
        .qr-box span { font-size: 8px; color: #666; display: block; margin-top: 2px; }

        /* Títulos */
        .main-title {
            text-align: center;
            font-size: 22px;
            font-weight: bold;
            color: #000;
            margin: 10px 0 2px 0;
            text-transform: uppercase;
        }
        .ciclo-label {
            text-align: center;
            font-size: 13px;
            color: #7b003a;
            font-weight: bold;
            margin-bottom: 15px;
        }

        /* Secciones */
        .section-bar {
            background-color: #ffffff;    /* Fondo blanco */
            color: #7b003a;               /* Texto en color guinda */
            padding: 5px 10px;            /* Espaciado interno */
            font-weight: bold;
            font-size: 16px;              /* Un poco más grande para resaltar */
            margin-top: 20px;             /* Espacio con la sección anterior */
            margin-bottom: 5px;           /* Espacio con la tabla de abajo */
            
            /* Borde izquierdo grueso */
            border-left: 6px solid #7b003a; 
            
            /* Opcional: un borde inferior muy tenue para delimitar la sección */
            border-bottom: 1px solid #f0f0f0;
            
            clear: both;
            text-transform: uppercase;    /* Hace que se vea más institucional */
        }

        /* Tablas de datos */
        .table-data {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 4px;
            margin-top: 5px;
        }
        .table-data td { padding: 5px 8px; }
        .label {
            background-color: #f0f0f0;
            color: #555;
            font-weight: bold;
            text-align: right;
            width: 25%;
            border-radius: 3px 0 0 3px;
        }
        .value {
            background-color: #fafafa;
            border-bottom: 1px solid #eeeeee;
            border-radius: 0 3px 3px 0;
        }

        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: 2cm; /* Espacio total asignado al footer */
            text-align: center; /* Centra el contenido (imagen y texto) */
        }

        .footer-pattern {
            width: 10cm;      /* <--- ASIGNA AQUÍ EL ANCHO FIJO QUE DESEES */
            height: auto;     /* <--- IMPORTANTE: 'auto' evita que la imagen se aplaste */
            display: block;   /* Permite que el margen sea automático */
            margin: 0 auto;   /* Centra la imagen horizontalmente */
        }

        .footer-text {
            font-size: 9px;
            color: #666;
            margin-top: 15px;
        }
    </style>
</head>
<body>

    <div class="header-container">
        <img src="{{ $logo_admon }}" class="logo-admon"><br>
        <img src="{{ $logo_aliviane }}" class="logo-programa">
    </div>

    <div class="qr-box">
        <img src="data:image/png;base64, {!! $qrcode !!}">
        <span>ID: {{ $estudiante->id_hex }}</span>
    </div>

    <div class="main-title">Datos de Registro</div>
    <div class="ciclo-label">CICLO ESCOLAR {{ $estudiante->ciclo->descripcion }} - PERIODO # {{ $estudiante->periodo }}</div>

    <div class="section-bar">INFORMACIÓN PERSONAL</div>
    <table class="table-data">
        <tr>
            <td class="label" style="width: 20%;">Nombre:</td>
            <td class="value" colspan="3"><b>{{ $estudiante->nombre }} {{ $estudiante->primer_apellido }} {{ $estudiante->segundo_apellido }}</b></td>
        </tr>

        <tr>
            <td class="label" style="width: 20%;">CURP:</td>
            <td class="value" style="width: 50%;"><b>{{ $estudiante->curp }}</b></td>
            
            <td class="label" style="width: 15%;">Nacimiento:</td> 
            <td class="value" style="width: 15%;"><b>{{ date('d-m-Y', strtotime($estudiante->fecha_nac)) }}</b></td>
        </tr>

        <tr>
            <td class="label" style="width: 20%;">E-mail:</td>
            <td class="value" style="width: 50%;"><b>{{ $estudiante->email }}</b></td>
            
            <td class="label" style="width: 15%;">Celular:</td>
            <td class="value" style="width: 15%;"><b>{{ $estudiante->celular }}</b></td>
        </tr>

        <tr>
            <td class="label" style="width: 20%;">Origen:</td>
            <td class="value" colspan="3"><b>{{ $estudiante->localidad_origen->localidad }}</b></td>
        </tr>
    </table>

    <div class="section-bar">INFORMACIÓN ESCOLAR</div>
    <table class="table-data">
        <tr>
            <td class="label">Institución:</td>
            <td class="value" colspan="3"><b>{{ $estudiante->escuela->escuela }}</b></td>
        </tr>
        <tr>
            <td class="label">Carrera:</td>
            <td class="value" colspan="3"><b>{{ $estudiante->carrera }}</b></td>
        </tr>
        <tr>
            <td class="label">Año Escolar:</td>
            <td class="value"><b>{{ $ano_escolar_txt }}</b></td>
            <td class="label" style="width: 15%;">Promedio:</td>
            <td class="value"><b>{{ $estudiante->promedio }}</b></td>
        </tr>
        <tr>
            <td class="label">Ciudad:</td>
            <td class="value"><b>{{ $estudiante->ciudad->ciudad }}</b></td>
            <td class="label">Turno:</td>
            <td class="value"><b>{{ $estudiante->turno->turno }}</b></td>
        </tr>
    </table>

    <div class="section-bar">INFORMACIÓN SOCIOECONÓMICA</div>
    <table class="table-data">
        <tr>
            <td class="label" style="width: 45%;">Material de techo:</td>
            <td class="value"><b>{{ $estudiante->socioeconomico->techo->techo }}</b></td>
        </tr>
        <tr>
            <td class="label">Personas en vivienda:</td>
            <td class="value"><b>{{ $estudiante->socioeconomico->personas_vivienda }}</b></td>
        </tr>
        <tr>
            <td class="label">Monto mensual hogar:</td>
            <td class="value"><b>{{ $estudiante->socioeconomico->monto_mensual->monto }}</b></td>
        </tr>
        <tr>
            <td class="label">¿Recibe otras becas / ayuda?</td>
            <td class="value">
                <b>Beca: {{ $estudiante->socioeconomico->beca_estudios == 1 ? 'SÍ' : 'NO' }}</b> / 
                <b>Ayuda Gob: {{ $estudiante->socioeconomico->ayuda_gobierno == 1 ? 'SÍ' : 'NO' }}</b>
            </td>
        </tr>
        <tr>
            <td class="label">¿Tiene empleo?</td>
            <td class="value">
                <b>{{ $estudiante->socioeconomico->empleo ? 'SÍ ('.$estudiante->socioeconomico->empleo.')' : 'NO' }}</b>
            </td>
        </tr>
        <tr>
            <td class="label">Gasto transporte diario:</td>
            <td class="value"><b>$ {{ number_format($estudiante->socioeconomico->gasto_transporte, 2) }}</b></td>
        </tr>
    </table>

    <footer>
        @if($footer_pattern)
            <img src="{{ $footer_pattern }}" class="footer-pattern">
        @endif
        <!-- <div class="footer-text">
            Documento informativo generado el {{ date('d/m/Y H:i') }}
        </div> -->
    </footer>
</body>
</html>