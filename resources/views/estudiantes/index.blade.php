@extends('layouts.main')

<?php
    use App\Models\Estudiante;

    if (isset(auth()->user()->usertype))
    {
        $usertype = auth()->user()->usertype;
    }
    else 
    {
        return redirect()->to('/');
    }

    $i = 1;

    function encuentraStatus($status, $statusR)
    {
        if (!isset($statusR)) return false;  //Si son TODOS los status
        foreach ($statusR as $statR)  //Recorre todos los status
        {
            if ($status == $statR) return true;  //Si el status es igual al del request
        }
        return false;
    }

    function encuentraEscuela($cve_escuela, $cve_escuelaR)
    {
        if (!isset($cve_escuelaR)) return false;
        foreach ($cve_escuelaR as $cve_escR)
        {
            if ($cve_escuela == $cve_escR) return true;
        }
        return false;
    }

    function encuentraLocalidad($cve_localidad, $cve_localidadR)
    {
        if (!isset($cve_localidadR)) return false;
        foreach ($cve_localidadR as $cve_locR)
        {
            if ($cve_localidad == $cve_locR) return true;
        }
        return false;
    }

    function encuentraTurno($cve_turno, $cve_turnoR)
    {
        if (!isset($cve_turnoR)) return false;
        foreach ($cve_turnoR as $cve_turR)
        {
            if ($cve_turno == $cve_turR) return true;
        }
        return false;
    }

    function encuentraAno($ano, $anoR)
    {
        if (!isset($anoR)) return false;
        foreach ($anoR as $anR)
        {
            if ($ano == $anR) return true;
        }
        return false;
    }

    function encuentraPromedio($promedio, $promedioR)
    {
        if (!isset($promedioR)) return false;
        foreach ($promedioR as $promR)
        {
            if ($promedio == $promR) return true;
        }
        return false;
    }
?>
@section('content')
    <!-- Page Heading -->
    <script language="JavaScript" type="text/javascript">
        document.addEventListener("DOMContentLoaded", function () {
            $('#btnImprimir').click(function(){
             $("#exampleModal").modal("show");
            });
        });
    </script>

      <script language="JavaScript" type="text/javascript">
        document.addEventListener("DOMContentLoaded", function(){
            $('#btnAceptar').click(function(){
                var databack = $("#exampleModal #recipient-name").val().trim();   //Nombre del Reporte
                $('#tituloReporte').val(databack);

                //Abre el formulario con el PDF
                var f = document.getElementById("formReport");
                
                f.action = "{{ route('estudiantes.pdf') }}";
            
                f.submit();   

                $('#exampleModal').modal('hide');    //Cierra la ventana modal
            });
        });
        
       document.addEventListener("DOMContentLoaded", function() {
            // Escuchar cambios y ejecución inicial
            $('#selStatus').on('changed.bs.select', function () {
                actualizarColorSelect();
            }).on('rendered.bs.select', function () {
                actualizarColorSelect();
            });

            // Pequeño delay para asegurar que Bootstrap Select terminó de renderizar el botón
            setTimeout(actualizarColorSelect, 100);

           function actualizarColorSelect() {
            const colors = {1:'#9944d9', 2:'#0071bc', 3:'#7dc3f5', 4:'#ff0000', 5:'#ffe26e', 6:'#00ff00', 7:'#ff00ff', 8:'#00a135', 9:'#ff8000'};
            
            let $container = $('#selStatus').closest('.bootstrap-select');
            let $pickerBtn = $container.find('.btn-select-tech');
            let $textContainer = $container.find('.filter-option-inner-inner'); // El contenedor del texto
            
            if ($pickerBtn.length === 0) return;

            let selectedValues = $('#selStatus').val(); 

            // 1. Caso: Nada seleccionado
            if (!selectedValues || selectedValues.length === 0) {
                $pickerBtn[0].style.setProperty('background', '#fff', 'important');
                $pickerBtn[0].style.setProperty('color', '#333', 'important');
                return;
            }

            let bgValue = "";

            if (selectedValues.length === 1) {
                // UN SOLO COLOR: Mantenemos el texto visible
                bgValue = colors[selectedValues[0]] || '#ccc';
            } 
            else {
                // DOS O MÁS COLORES: Generamos gradiente y OCULTAMOS el texto
                let gradientParts = [];
                let totalItems = selectedValues.length;
                let step = 100 / totalItems;

                selectedValues.forEach((val, index) => {
                    let color = colors[val] || '#ccc';
                    let start = index * step;
                    let end = (index + 1) * step;
                    gradientParts.push(`${color} ${start}%`, `${color} ${end}%`);
                });

                bgValue = `linear-gradient(90deg, ${gradientParts.join(', ')})`;
                
                // --- AQUÍ EL DETALLE: Vaciamos el texto si hay más de uno ---
                $textContainer.text(''); 
            }

            // Aplicación de estilos
            $pickerBtn[0].style.setProperty('background', bgValue, 'important');
            $pickerBtn[0].style.setProperty('color', '#fff', 'important');
        }
    });

   document.addEventListener("click", function(event) {
        // Buscamos si el clic fue en el botón de reset (Limpiar)
        if (event.target && (event.target.type === 'reset' || event.target.closest('button[type="reset"]'))) {
            
            // 1. Evitamos que el formulario haga el reset nativo antes de tiempo para controlarlo nosotros
            event.preventDefault();
            
            var jq = window.jQuery || window.$;
            
            if (jq) {
                // Seleccionamos el formulario padre del botón
                var $form = jq(event.target).closest('form');
                
                // 2. Limpiar inputs de texto y búsqueda nativos
                $form.find('input[type="search"], input[type="text"]').val('');
                
                // 3. Limpiar todos los Bootstrap Select (Estatus, Escuela, Ciudad, etc.)
                var $selects = $form.find('.selectpicker');
                $selects.selectpicker('deselectAll'); // Desmarca opciones en múltiples
                $selects.selectpicker('val', '');     // Limpia el valor en individuales
                $selects.selectpicker('refresh');     // Redibuja el control
                
                // 4. Forzar que el botón de Estatus (y otros) vuelva a blanco
                // Llamamos a tu función de colores si existe
                if (typeof actualizarColorSelect === "function") {
                    setTimeout(actualizarColorSelect, 100);
                }
            } else {
                // Si por alguna razón jQuery no está, al menos limpiamos el formulario de forma nativa
                event.target.closest('form').reset();
            }
        }
    });
    </script>

    <style>
    .bg-rojo {
           background-color: #7b003a; /* Color rojo en formato hexadecimal */
       }

   .btn-verde {
     background-color: #00656c;
     color: white;
   }
 
   .btn-verde:hover {
     background-color: #4a826a; /* Cambia el color aquí al deseado cuando el mouse esté encima */
     color: white;
   }

   .btn-verde:active {
        background-color: #5ca265; /* Cambia el color aquí al deseado cuando el botón está activado (clic) */
        color: white;
    }

   .btn-dorado {
      background-color: #706f6f;
      color: white;
    }
  
    .btn-dorado:hover {
      background-color: #ebebeb; /* Cambia el color aquí al deseado cuando el mouse esté encima */
      color: white;
    }

    .btn-rojo {
      background-color: #7b003a;
      color: white;
    }
  
    .btn-rojo:hover {
      background-color: #5c2134; /* Cambia el color aquí al deseado cuando el mouse esté encima */
      color: white;
    }

    .text-rojo {
            color: #932f4a;
        }

        .text-rojo:hover {
            color: #5c2134;
        }

        /* Forzar el color del texto en los badges */
        .text-white-important {
            color: white !important;
        }
    </style>

<style>
    .custom-pagination .pagination .page-item.active .page-link {
        background-color: #7b003a; /* Color guinda (maroon) para el paginador activo */
        color: white; /* Cambiar el color del texto a blanco para el paginador activo */
        /* Ajusta otros estilos según tus preferencias */
    }

    .custom-pagination .pagination li a {
        color: #767676; /* Cambia el color del texto a blanco */
    }
</style>

    {{-- ***********************************  Ventana MODAL  ************************************************* --}}
    <div class="modal fade" id="exampleModal" name="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><b> <i class="fas fa-print"></i> Opciones del Reporte</b></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> &times; </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label"> <b> Título del Reporte </b></label>
                        <input type="text" value="Reporte de Estudiantes" class="form-control" id="recipient-name">
                    </div>
                </div>
                <div class="modal-footer">
                        <button type="button" id="btnAceptar" type="submit" class="btn btn-danger btn-sm action-complete-task">Generar</button>
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>

    <style>
        .header-tech-container {
            background: white;
            padding: 1.5rem;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.04); /* Sombra muy suave */
            border: 1px solid rgba(0,0,0,0.05);
        }

        .brand-accent-line {
            width: 4px;
            height: 40px;
            background: linear-gradient(180deg, #7b003a, #4a0022);
            border-radius: 10px;
        }

        .tracking-tight {
            letter-spacing: -0.5px;
        }

        /* --- BOTONES MODERNOS --- */
        .action-buttons-gap {
            gap: 10px;
        }

        /* Botón Estilo Outlined (Tecnológico) */
        .btn-tech-outline {
            background: transparent;
            color: #7b003a;
            border: 1.5px solid #7b003a;
            border-radius: 10px;
            padding: 0.6rem 1.2rem;
            font-size: 0.9rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-tech-outline:hover {
            background: rgba(123, 0, 58, 0.05);
            color: #4a0022;
            border-color: #4a0022;
            transform: translateY(-2px);
        }

        /* Botón con Gradiente (Principal) */
        .btn-tech-gradient {
            background: linear-gradient(135deg, #00656c, #004d52);
            color: white !important;
            border: none;
            border-radius: 10px;
            padding: 0.6rem 1.4rem;
            font-size: 0.9rem;
            box-shadow: 0 4px 15px rgba(0, 101, 108, 0.3);
            transition: all 0.3s ease;
        }

        .btn-tech-gradient:hover {
            box-shadow: 0 6px 20px rgba(0, 101, 108, 0.4);
            transform: translateY(-2px);
            filter: brightness(1.1);
        }

        /* Iconos dentro de botones */
        .btn-tech-outline i, .btn-tech-gradient i {
            font-size: 1rem;
        }

        /* --- CONTENEDOR PRINCIPAL DEL HEADER --- */
        .card-header-tech {
            background: #ffffffff;
            /* border: 1px solid rgba(213, 0, 0, 0.08); */
            padding: 0.75rem 1.25rem;
            transition: all 0.3s ease;
        }
        

        /* --- ESTILO DEL DISPARADOR DE BÚSQUEDA --- */
        .search-trigger-link {
            text-decoration: none !important;
            color: #2d3748;
        }

        .search-icon-wrapper {
            width: 35px;
            height: 35px;
            background: #f8f9fa;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #7b003a; /* Tu color guinda */
            border: 1px solid rgba(123, 0, 58, 0.1);
        }

        /* Contenedor del título para controlar el brillo */
        .search-title {
            font-weight: 700;
            font-size: 0.95rem;
            letter-spacing: 0.3px;
            position: relative;
            display: inline-block;
            color: #2d3748;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Efecto de línea brillante que aparece abajo al hacer hover */
        .search-title::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -2px;
            left: 0;
            background: linear-gradient(90deg, #7b003a, #ff4d97);
            transition: width 0.3s ease;
            box-shadow: 0 0 8px rgba(123, 0, 58, 0.6);
        }

        /* Estado Hover del Link */
        .search-trigger-link:hover .search-title {
            color: #7b003a;
            transform: translateX(4px); /* Desplazamiento fluido */
            text-shadow: 0 0 1px rgba(123, 0, 58, 0.2);
        }

        .search-trigger-link:hover .search-title::after {
            width: 100%; /* La línea se expande tecnológicamente */
        }

        /* Animación del icono de búsqueda al hacer hover */
        .search-trigger-link:hover .search-icon-wrapper {
            background: #7b003a;
            color: white;
            transform: scale(1.1) rotate(10deg);
            box-shadow: 0 0 15px rgba(123, 0, 58, 0.3);
            border-color: transparent;
        }

        /* Rotación suave de la flecha */
        .search-trigger-link:hover .arrow-icon {
            color: #7b003a;
            filter: drop-shadow(0 0 2px rgba(123, 0, 58, 0.4));
        }

        .arrow-icon {
            font-size: 0.7rem;
            transition: transform 0.3s ease;
            color: #a0aec0;
        }

        /* Animación de la flecha cuando se abre el collapse */
        .search-trigger-link[aria-expanded="true"] .arrow-icon {
            transform: rotate(180deg);
        }

        /* --- ESTILO DEL CONTADOR (STATS) --- */
        .stats-container {
            font-size: 0.85rem;
        }

        .stats-label {
            color: #718596ff;
            font-weight: 600;
        }

        .stats-badge {
            background: linear-gradient(135deg, #7b003a, #4a0022);
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-family: 'Nunito', sans-serif;
            font-weight: 800;
            box-shadow: 0 4px 10px rgba(123, 0, 58, 0.2);
            min-width: 50px;
            text-align: center;
        }

        .count-number {
            font-size: 0.9rem;
        }

        /* Efecto Hover en el Header */
        .card-header-tech:hover {
            background: #fcfcfc;
        }

        /* --- ESTILO DEL CARD BODY --- */
        .card-body-tech {
            background: #ffffff;
            padding: 1.5rem !important;
            border-top: 1px solid rgba(0,0,0,0.05);
        }

        .bg-light-tech {
            background-color: #f8fafc;
            border: 1px solid #edf2f7;
        }

        /* --- LABELS Y FORM GROUPS --- */
        .form-group-tech {
            margin-bottom: 0;
        }

        .label-tech {
            font-size: 0.75rem;
            text-transform: uppercase;
            font-weight: 700;
            color: #4a5568;
            margin-bottom: 6px;
            display: block;
            letter-spacing: 0.5px;
        }

        .label-tech i {
            color: #7b003a;
            width: 15px;
            margin-right: 4px;
        }

        /* --- INPUTS Y SELECTS --- */
        .input-tech, .btn-select-tech {
            height: 36px !important;
            border-radius: 8px !important;
            border: 1.5px solid #e2e8f0 !important;
            font-size: 0.85rem !important;
            background-color: #fff !important;
            transition: all 0.2s ease-in-out !important;
        }

        .input-tech:focus, .btn-select-tech:focus, .btn-select-tech:active {
            border-color: #7b003a !important;
            box-shadow: 0 0 0 3px rgba(123, 0, 58, 0.1) !important;
            outline: none !important;
        }

        /* Estilo específico para el botón del SelectPicker */
        .btn-select-tech {
            display: flex;
            align-items: center;
            /* background: #fff; */
            /* border: 1px solid rgba(0,0,0,0.1) !important; */
        }

        .btn-select-tech .filter-option-inner-inner {
            font-weight: 700;       
        }

        /* Usamos el ID del select para llegar al contenedor que Bootstrap Select crea */
 
        .bootstrap-select .btn-select-tech .filter-option .status-item {
            background: transparent !important;
            background-color: transparent !important; /* Refuerzo */
            margin: 0 !important;
            padding: 0 !important;
            width: auto !important;
            display: inline !important;
            box-shadow: none !important;
            position: static !important; /* Evita desplazamientos */
        }

        .btn-select-tech .status-item {
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1) !important;
            letter-spacing: 0.5px; /* Mejora legibilidad en negritas */
        }

        .btn-select-tech .filter-option {
            font-weight: 600;
            color: #2d3748;
        }

        /* --- BOTONES --- */
        .btn-tech-sm {
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 700;
            padding: 8px 16px;
             white-space: nowrap;
        }

        /* Contenedor de botones con separación dinámica */
        .action-buttons-wrapper {
            gap: 12px; /* Espacio moderno entre elementos flex */
            padding-top: 10px;
        }

        /* Ajuste de tamaño para el botón principal */
        .btn-tech-lg {
            border-radius: 10px;
            font-size: 0.9rem;
            font-weight: 600;
            padding: 10px 25px;
            white-space: nowrap; /* Evita que el texto del botón se rompa en dos líneas */
            transition: all 0.3s ease;
        }

        /* Si la pantalla es pequeña, los botones ocupan todo el ancho */
        @media (max-width: 576px) {
            .action-buttons-wrapper {
                flex-direction: column;
                width: 100%;
            }
            .action-buttons-wrapper button {
                width: 100%;
                margin-right: 0 !important;
                margin-bottom: 10px;
            }
        }

        /* --- ESTILO DE TABLA SOFT-MODERN --- */
        .table-modern {
            border-collapse: separate;
            border-spacing: 0 8px; /* Crea el efecto de filas separadas */
            margin-top: -8px;
        }

        .table-modern thead th {
            border: none;
            color: #8e94a9;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 10px 15px;
        }

        .table-modern tbody tr {
            background-color: #ffffff;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04); /* Sombra muy suave */
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .table-modern tbody tr:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 6px rgba(0,0,0,0.08);
            background-color: #f8f9ff;
        }

        .table-modern td {
            border: none !important;
            padding: 12px 15px !important;
            color: #4a5568;
        }

        /* --- DETALLES DE CELDAS --- */
        .badge-index {
            background: #f1f3f7;
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 0.8rem;
            font-weight: bold;
        }

        .user-name {
            font-weight: 600;
            color: #2d3748;
            font-size: 0.9rem;
            line-height: 1.2;
        }

        .user-id {
            font-size: 0.75rem;
            color: #a0aec0;
        }

        /* Badge académico estilizado */
        .academic-badge {
            display: inline-flex;
            align-items: center;
            background: #f7ededff;
            border-radius: 20px;
            padding: 2px 10px;
            font-size: 0.75rem;
            margin-bottom: 4px;
        }

        .academic-badge .year { font-weight: 700; color: #684a4aff; margin-right: 5px; }
        .academic-badge .school { color: #7b0303ff; font-weight: 600; margin-right: 8px; }
        .academic-badge .city { color: #718096; font-size: 0.7rem; }

        .career-text { font-size: 0.8rem; color: #4e4f50ff; }
        .obs-text { font-size: 0.8rem; color: #a0aec0; margin: 0; font-style: italic; }

        /* --- BOTONES DE ACCIÓN SOFT --- */
        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 8px;
        }

        .btn-action {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            background: #f7fafc;
            color: #718096;
            transition: all 0.2s;
            text-decoration: none !important;
        }

        .btn-action:hover {
            color: white;
        }

        .btn-action.edit:hover { background: #4299e1; }
        .btn-action.print:hover { background: #f56565; }
        .btn-action.download:hover { background: #4a5568; }

        /* Contenedor de la lista */
        .student-container {
            background: #f4f7f6;
            padding: 20px;
            border-radius: 15px;
        }

        /* Tarjeta de Estudiante */
        .student-card {
            background: white;
            border: none;
            border-radius: 16px;
            margin-bottom: 0.5rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            padding: 0rem!important;
        }

        .student-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .status-indicator {
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 36px;
            display: flex;            /* Activamos flex */
            align-items: center;      /* Centrado vertical */
            justify-content: center;   /* Centrado horizontal */
            color: white;             /* Color de letra base */
            font-weight: 800;         /* Grosor para que resalte */
            font-size: 0.85rem;       /* Tamaño equilibrado */
            border-radius: 16px 0 0 16px; /* Para que coincida con el redondeo de la card */
        }

        /* Opcional: una rotación ligera para darle un toque tech */
        .status-indicator span {
            transform: rotate(0deg); /* Si lo quieres vertical cámbialo a -90deg */
        }

        /* Avatar con iniciales */
        .avatar-ui {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            font-weight: bold;
            font-size: 1.1rem;
            box-shadow: 0 4px 10px rgba(118, 75, 162, 0.3);
        }

        /* Badges Modernos */
        .badge-soft {
            padding: 0.5em 1em;
            border-radius: 8px;
            font-weight: 500;
            font-size: 0.75rem;
        }
        .bg-academic-soft { background: #e0e7ff; color: #4338ca; }
        .bg-history-soft { background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0; }

        /* Botones de acción */
        .action-group .btn {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-left: 5px;
            transition: all 0.2s;
            border: none;
        }

        .btn-edit { background: #eff6ff; color: #2563eb; }
        .btn-edit:hover { background: #2563eb; color: white; }
        .btn-print { background: #f0fdf4; color: #16a34a; }
        .btn-print:hover { background: #16a34a; color: white; }
        .btn-zip { background: #fff7ed; color: #ea580c; }
        .btn-zip:hover { background: #ea580c; color: white; }

        /* Responsividad */
        @media (max-width: 768px) {
            .avatar-ui { width: 40px; height: 40px; font-size: 0.9rem; }
            .action-group { margin-top: 15px; width: 100%; justify-content: center; }
        }

        /* 1. Cambia el color del item cuando está seleccionado */
        .bootstrap-select .dropdown-menu li.selected a {
            background-color: #7b003a !important; /* Tu color guinda */
            color: white !important;
        }

        /* 2. Cambia el color cuando pasas el mouse (Hover) sobre un item */
        .bootstrap-select .dropdown-menu li a:hover {
            background-color: #a1a1a1ff !important; /* Un guinda un poco más claro */
            color: white !important;
        }
        

        /* 3. Cambia el color del checkmark (la palomita) */
        .bootstrap-select .dropdown-menu li.selected a span.check-mark {
            color: white !important;
        }

        /* Mantiene el fondo guinda cuando pasas el mouse sobre un elemento YA seleccionado */
        .bootstrap-select .dropdown-menu li.selected a:hover, 
        .bootstrap-select .dropdown-menu li.selected.active a {
            background-color: #7b003a !important; /* Tu guinda institucional */
            color: white !important;
        }

        /* Opcional: Si quieres que al pasar el mouse sobre el seleccionado brille un poquito más 
        para que el usuario sepa dónde está el puntero, usa esta versión: */
        .bootstrap-select .dropdown-menu li.selected a:hover {
            background-color: #7b003a !important; /* Un guinda ligeramente más claro */
            color: white !important;
        }

        /* Seleccionamos específicamente el menú de Status */
        #selStatus + .bootstrap-select .dropdown-menu {
            padding: 0 !important; /* Quita el espacio arriba y abajo del menú */
            overflow-x: hidden !important; /* Evita scrolls horizontales raros */
        }

        #selStatus + .bootstrap-select .dropdown-menu li {
            margin: 0 !important;
            padding: 0 !important;
        }

        #selStatus + .bootstrap-select .dropdown-menu li a {
            padding: 0 !important; /* ELIMINA el hueco blanco lateral */
            margin: 0 !important;
            display: block !important;
            width: 100% !important;
        } 

        /* Usamos el atributo [id^='bs-select'] para que funcione aunque el número cambie */
        [id^='bs-select'] ul li a:hover .status-item {
            position: relative;
        }

        /* Creamos un destello blanco transparente sobre el color */
        [id^='bs-select'] ul li a:hover .status-item::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4); /* Un velo blanco al 40% */
            pointer-events: none;
        }

        /* Cambia el fondo del item que aparece dentro del botón al ser seleccionado */
        #collapseExample .bootstrap-select .btn-select-tech .filter-option .status-item {
            margin: 0 !important; /* Ajuste para que no se vea desfasado en el botón */
            padding: 2px 10px !important; /* Ajuste de tamaño para el botón */
            border-radius: 4px; /* Opcional: para que se vea más como etiqueta */
            box-shadow: 0 1px 3px rgba(0,0,0,0.2); /* Opcional: para darle relieve */
        }
    </style>

    <div class="container-fluid">
        <div class="card mx-auto">
            <?php  
                if (session()->has('msg_type'))  $msg_type = session()->get('msg_type');
                else $msg_type = "info";
            ?>
            <div>
                @if (session()->has('message'))
                <div class="alert alert-{{ $msg_type }} mb-0">                        
                    <button type="button" class="close" data-dismiss="alert">
                        &times;
                    </button>                        
                    {!! html_entity_decode(session()->get('message')) !!}
                </div>
                <br>
                @endif 
            </div>
            <div class="card-header mt-0">
                <div class="row mb-0">
                    <div class="col">
                        <div class="col-12 d-flex align-items-center justify-content-between mb-4 header-tech-container">
                            <div class="d-flex align-items-center">
                                <div class="brand-accent-line mr-3"></div>
                                <div>
                                    <h1 class="h3 mb-0 text-dark font-weight-bold tracking-tight">
                                        Estudiantes
                                    </h1>
                                    <p class="text-muted small mb-0">Registro y seguimiento de expedientes para movilidad estudiantil</p>
                                </div>
                            </div>

                            @if ($usertype <= 1)
                            <div class="d-flex align-items-center action-buttons-gap">
                                <a href="{{ route('estudiantes.nuevo-xt') }}" 
                                class="btn btn-tech-outline d-flex align-items-center" 
                                title="Nuevo registro extemporáneo">
                                    <i class="fa-solid fa-user-clock mr-2"></i>
                                    <span class="d-none d-md-inline">Extemporáneo</span>
                                </a>

                                <a href="{{ route('estudiantes.forget') }}" 
                                class="btn btn-tech-gradient d-flex align-items-center ml-2" 
                                title="Registrar nuevo estudiante">
                                    <i class="fa-solid fa-plus-circle mr-2"></i>
                                    <span class="font-weight-bold">Nuevo Estudiante</span>
                                </a>
                            </div>
                            @endif
                        </div>
                        <div class="card mt-3">
                            <div class="card-header-tech d-flex align-items-center justify-content-between"
                            style="background:#eeeeee">
                                <a data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" class="search-trigger-link">
                                    <div class="d-flex align-items-center">
                                        <div class="search-icon-wrapper mr-3">
                                            <i class="fas fa-search"></i>
                                        </div>
                                        <div>
                                            <span class="search-title">Parámetros de Búsqueda</span>
                                            <i class="fas fa-chevron-down ml-2 arrow-icon"></i>
                                        </div>
                                    </div>
                                </a>

                                <div class="stats-container d-flex align-items-center">
                                    <div class="stats-label d-none d-md-block mr-2">
                                        <i class="fas fa-database mr-1"></i> Estudiantes registrados:
                                    </div>
                                    <div class="stats-badge">
                                        @foreach ($totEstudiantes as $ciclo => $total)
                                            <span class="count-number">{{ number_format($total) }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="collapse" id="collapseExample">
                                <div class="card-body card-body-tech">
                                    <form method="GET" action="{{ route('estudiantes.index') }}">
                                        <div class="row align-items-end mb-4">
                                            <div class="col-md-2">
                                                <div class="form-group-tech">
                                                    <label class="label-tech"><i class="fas fa-book"></i> CICLO ESCOLAR</label>
                                                    <select name="selCiclo[]" id="selCiclo" data-style="btn-select-tech" title="-- TODOS --" class="form-control selectpicker show-tick" autofocus multiple>
                                                        @foreach ($ciclos as $ciclo)
                                                            <option value="{{ $ciclo->id_ciclo }}" @if(in_array($ciclo->id_ciclo, $cicloR)) selected @endif>{{ $ciclo->descripcion }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group-tech">
                                                    <label class="label-tech"><i class="fas fa-layer-group"></i> PERIODO</label>
                                                    <select name="selPeriodo[]" id="selPeriodo" data-style="btn-select-tech" title="-- TODOS --" class="form-control selectpicker show-tick" autofocus multiple>
                                                        @foreach ($periodos as $periodo)
                                                            <option value="{{ $periodo->periodo }}" @if(in_array($periodo->periodo, $periodoR)) selected @endif>{{ $periodo->periodo }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group-tech">
                                                    <label class="label-tech"><i class="fas fa-user"></i> Nombre / Apellidos</label>
                                                    <input type="search" name="search" class="form-control input-tech" value="{{ old('search', $searchR) }}" placeholder="Buscar por nombre..." autofocus>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group-tech">
                                                    <label class="label-tech"><i class="fas fa-map-marker-alt"></i> Lugar Origen</label>
                                                    <select name="selLocalidadO[]" id="selLocalidadO" title="-- TODOS --" class="form-control selectpicker show-tick" data-style="btn-select-tech" data-size="8" multiple>
                                                        @foreach ($localidades as $localidad)
                                                            <option value="{{ $localidad->cve_localidad }}" {{ encuentraLocalidad($localidad->cve_localidad, $cve_localidadOR) ? 'selected' : '' }}>{{ $localidad->localidad }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            @if ($usertype <= 1)
                                            <div class="col-md-2">
                                                <div class="form-group-tech">
                                                    <label class="label-tech"><i class="fas fa-tag"></i> Estatus</label>
                                                    <select name="selStatus[]" id="selStatus" title="-- TODOS --" class="form-control selectpicker" data-style="btn-select-tech" multiple>
                                                        @foreach ($status as $stat)
                                                            @php
                                                                $colors = [1=>'#9944d9', 2=>'#0071bc', 3=>'#7dc3f5', 4=>'#ff0000', 5=>'#ffe26e', 6=>'#00ff00', 7=>'#ff00ff', 8=>'#00a135', 9=>'#ff8000'];
                                                                $color = $colors[$stat->cve_status] ?? '#ccc';
                                                                $textColor = ($stat->cve_status == 5 || $stat->cve_status == 3 || $stat->cve_status == 6) ? '#fff' : '#fff';
                                                            @endphp
                                                            <option 
                                                                value="{{ $stat->cve_status }}" 
                                                                data-content="<div class='status-item' style='background:{{$color}}; color:{{$textColor}}; margin: -5px -58px; padding: 8px 55px; font-weight:700; width: 240px; display: block;'>{{$stat->descripcion}}</div>"
                                                                {{ encuentraStatus($stat->cve_status, $statusR) ? 'selected' : '' }}>
                                                                {{ $stat->descripcion }}
                                                            </option>
                                                        @endforeach|
                                                    </select>
                                                </div>
                                            </div>
                                            @endif
                                            <!-- <div class="col-md-3">
                                                <div class="form-group-tech">
                                                    <label class="label-tech"><i class="fas fa-file-invoice-dollar"></i> Info. Socioeconómica</label>
                                                    <select name="selSocioeconomica" id="selSocioeconomica" class="form-control selectpicker" data-style="btn-select-tech">
                                                        <option value="" selected>-- TODOS --</option>
                                                        <option value=1 {{ $socioeconomicaR == 1 ? 'selected' : '' }}>SIN OBSERVACIONES</option>
                                                        <option value=2 {{ $socioeconomicaR == 2 ? 'selected' : '' }}>CON OBSERVACIONES</option>
                                                    </select>
                                                </div>
                                            </div> -->
                                        </div>
                                        <div class="row align-items-end mb-4">
                                            <div class="col-md-3">
                                                <div class="form-group-tech">
                                                    <label class="label-tech"><i class="fas fa-university"></i> Escuela</label>
                                                    <select name="selEscuela[]" id="selEscuela" data-live-search="true" title="-- TODAS --" class="form-control selectpicker" data-style="btn-select-tech" multiple>
                                                        @foreach ($escuelas as $escuela)
                                                            <option value="{{ $escuela->cve_escuela }}" {{ encuentraEscuela($escuela->cve_escuela, $cve_escuelaR) ? 'selected' : '' }}>{{ $escuela->escuela_abreviatura }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group-tech">
                                                    <label class="label-tech"><i class="fas fa-city"></i> Ciudad</label>
                                                    <select name="selCiudad" id="selCiudad" class="form-control selectpicker" data-style="btn-select-tech">
                                                        <option value="" selected>-- TODAS --</option>
                                                        @foreach ($ciudades as $ciudad)
                                                            <option value="{{ $ciudad->cve_ciudad }}" {{ $ciudad->cve_ciudad == $cve_ciudadR ? 'selected' : '' }}>{{ $ciudad->ciudad }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group-tech">
                                                    <label class="label-tech"><i class="fas fa-graduation-cap"></i> Carrera</label>
                                                    <input type="search" name="searchCarrera" class="form-control input-tech" value="{{ old('searchCarrera', $carreraR) }}" placeholder="Ej. Lic...">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group-tech">
                                                    <label class="label-tech"><i class="fas fa-clock"></i> Turno</label>
                                                    <select name="selTurno[]" id="selTurno" title="-- TODOS --" class="form-control selectpicker" data-style="btn-select-tech" multiple>
                                                        @foreach ($turnos as $turno)
                                                            <option value="{{ $turno->cve_turno }}" {{ encuentraTurno($turno->cve_turno, $cve_turnoR) ? 'selected' : '' }}>{{ $turno->turno }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group-tech">
                                                    <label class="label-tech"><i class="fas fa-calendar-alt"></i> Año</label>
                                                    <select name="selAnoEscolar[]" id="selAnoEscolar" title="-- TODOS --" class="form-control selectpicker" data-style="btn-select-tech" multiple>
                                                        @for ($i = 1; $i <= 6; $i++)
                                                            <option value="{{$i}}" {{ encuentraAno($i, $ano_escolarR) ? 'selected' : '' }}>{{$i}}° AÑO</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-0 mt-4 pt-3 border-top justify-content-between align-items-center bg-light-tech rounded-lg mx-0">
                                            <div class="col-lg-8 col-md-12 mb-3 mb-lg-3">
                                                <div class="row">
                                                    <div class="col-md-5 mb-2 mb-md-0">
                                                        <div class="form-group-tech">
                                                            <label class="label-tech"><i class="fas fa-sort-amount-down"></i> Ordenar por</label>
                                                            <select name="selOrderBy1" id="selOrderBy1" class="form-control selectpicker" data-style="btn-select-tech">
                                                                <option value="" selected>-- SIN ORDENAR --</option>
                                                                <option value=1 {{ $orderBy1R == 1 ? 'selected' : '' }}>APELLIDOS</option>
                                                                <option value=0 {{ isset($orderBy1R) && $orderBy1R == 0 ? 'selected' : '' }}>NOMBRE</option>
                                                                <option value=2 {{ $orderBy1R == 2 ? 'selected' : '' }}>ESCUELA</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group-tech">
                                                            <label class="label-tech"><i class="fas fa-comment-medical"></i> Observaciones Admin.</label>
                                                            <input type="search" name="observacionesAdmin" class="form-control input-tech" value="{{ old('observacionesAdmin', $observacionesAdminR) }}" placeholder="Notas internas...">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-4 col-md-12 d-flex justify-content-lg-end justify-content-center align-items-center action-buttons-wrapper">
                                                <button type="reset" class="btn btn-outline-secondary btn-tech-sm px-4 mr-3" 
                                                style=" border-radius: 10px;
                                                        padding: 0.6rem 1.2rem;
                                                        font-size: 0.9rem;
                                                        font-weight: 600;
                                                        transition: all 0.3s ease;">
                                                    <i class="fas fa-eraser mr-1"></i> Limpiar
                                                </button>
                                                <button type="submit" class="btn btn-tech-gradient btn-tech-lg shadow-sm">
                                                    <i class="fas fa-search-plus mr-2"></i> EJECUTAR BÚSQUEDA
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>            
            </div>
            @php
                $j = 1;
            @endphp
           <div class="student-container">
            @foreach ($estudiantes as $estudiante)
                @php
                    // Definición de colores de estatus
                    $statusColors = [
                        1=>'#9944d9', 2=>'#0071bc', 3=>'#7dc3f5', 4=>'#ff0000', 
                        5=>'#ffe26e', 6=>'#00ff00', 7=>'#ff00ff', 8=>'#00a135', 9=>'#ff8000'
                    ];
                    $color = $statusColors[$estudiante->cve_status] ?? '#ddd';
                    
                    // Iniciales para el avatar
                    $iniciales = substr($estudiante->nombre, 0, 1) . substr($estudiante->primer_apellido, 0, 1);
                    
                    // Consulta de años escolares (Idealmente mover esto al Controller con ->with())
                    $aniosEscolares = \App\Models\Estudiante::where('curp', $estudiante->curp)
                                        ->distinct()
                                        ->pluck('ano_escolar');

                    $badgeColors = ['primary', 'secondary', 'success', 'danger', 'warning', 'info', 'dark'];
                    $darkColors = ['primary', 'secondary', 'success', 'danger', 'info', 'dark'];
                @endphp

                <div class="card student-card" style="position: relative; overflow: hidden;">
                    <div class="status-indicator" style="
                        background: linear-gradient(180deg, {{ $color }} 0%, rgba(0,0,0,0.25) 100%);
                        background-color: {{ $color }}; /* Fallback */
                        position: absolute; 
                        left: 0; 
                        top: 0; 
                        bottom: 0; 
                        width: 36px; 
                        display: flex; 
                        align-items: center; 
                        justify-content: center; 
                        color: white; 
                        font-weight: 800;
                        z-index: 10;
                        box-shadow: inset -2px 0 5px rgba(0,0,0,0.05);">
                        <span style="font-size: 0.85rem; text-shadow: 0 1px 2px rgba(0,0,0,0.2);">{{ $j++ }}</span>
                    </div>
                    
                    <div class="card-body p-3" style="padding-left: 52px !important;"> 
                        <div class="row align-items-center">                            
                            <div class="col-md-4">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-ui me-3" 
                                        style="
                                            background: white; 
                                            color: #2d3748; 
                                            border: 2px solid {{ $estudiante->promedio >= 8 ? '#16a34a' : '#ae0000ff' }}; 
                                            min-width: 45px; 
                                            height: 45px;
                                            position: relative;
                                            border-radius: 20%;">
                                        <div class="d-flex flex-column align-items-center justify-content-center h-100">
                                            
                                            <span style="
                                                font-size: 1rem; 
                                                font-weight: 800; 
                                                line-height: 1;
                                                text-decoration: {{ $estudiante->promedio < 8 ? 'line-through' : 'none' }};
                                                text-decoration-color: #ae0000ff;
                                               ">
                                                {{ $estudiante->promedio }}
                                            </span>

                                            <span style="
                                                font-size: 0.45rem; 
                                                font-weight: 700; 
                                                text-transform: uppercase;
                                                text-decoration: {{ $estudiante->promedio < 8 ? 'line-through' : 'none' }};
                                                text-decoration-color: #ae0000ff;
                                                ">
                                                Prom
                                            </span>

                                        </div>
                                    </div>
                                    <div class="overflow-hidden ml-2">
                                        <h6 class="user-name mb-0 text-uppercase text-truncate" style="font-size: 0.85rem; letter-spacing: -0.1px; font-weight:700">
                                            {{ $estudiante->primer_apellido }} {{ $estudiante->segundo_apellido }} {{ $estudiante->nombre }}
                                        </h6>
                                        <div class="d-flex align-items-center flex-wrap gap-2 mt-1">
                                            <span class="small text-muted mr-4 d-flex align-items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" 
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-id-card-icon lucide-id-card mr-1">
                                                <path d="M16 10h2"/><path d="M16 14h2"/><path d="M6.17 15a3 3 0 0 1 5.66 0"/><circle cx="9" cy="11" r="2"/>
                                                <rect x="2" y="5" width="20" height="14" rx="2"/></svg> 
                                                <b style="font-family: 'Nunito', sans-serif;">{{ $estudiante->id }}</b>
                                            </span>
                                            <span class="small text-muted d-none d-sm-inline mr-4">
                                                <i class="fas fa-book me-1 mr-1" style="font-size: 0.7rem;"></i><b style="font-family: 'Nunito', sans-serif;"> {{ $estudiante->ciclo->descripcion }}</b>
                                            </span>
                                            <span class="small text-muted d-none d-sm-inline">
                                                <i class="fas fa-layer-group me-1 mr-1" style="font-size: 0.7rem;"></i><b style="font-family: 'Nunito', sans-serif;"> {{ $estudiante->periodo }}</b>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 border-start ps-md-4">
                                <div class="academic-badge mb-1">
                                    <span class="school text-uppercase">{{ $estudiante->escuela->escuela_abreviatura }}</span>
                                    <span class="year">{{ $estudiante->ano_escolar }}° Año</span>
                                </div>
                                <div class="d-flex align-items-center justify-content-between w-100" style="gap: 8px;">
                                    <div class="career-text fw-bold text-dark text-truncate mb-0" 
                                        style="font-size: 0.8rem; flex: 1;" 
                                        title="{{ $estudiante->carrera }}">
                                        {{ $estudiante->carrera }}
                                    </div>

                                    <div class="d-flex gap-1 flex-shrink-0">
                                        @foreach ($aniosEscolares as $index => $anio)
                                            @php
                                                $colorBadge = $badgeColors[$index % count($badgeColors)];
                                            @endphp
                                            <span class="badge {{ str_starts_with($colorBadge, '#') ? '' : 'bg-'.$colorBadge }}"
                                                style="
                                                    @if(str_starts_with($colorBadge, '#')) background-color: {{ $colorBadge }} !important; @endif
                                                    color: white;
                                                    font-size: 0.6rem; 
                                                    padding: 3px 6px; 
                                                    border-radius: 50px !important; /* Estilo píldora moderna */
                                                    font-weight: 600;
                                                    display: inline-flex;
                                                    align-items: center;
                                                    text-transform: uppercase;
                                                    letter-spacing: 0.4px;
                                                    box-shadow: 0 2px 4px rgba(0,0,0,0.12); /* Sombra suave para relieve */
                                                    border: 1px solid rgba(255,255,255,0.2); /* Brillo sutil en el borde */
                                                ">
                                                {{ $anio }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-2 d-none d-lg-block border-start ps-4">
                                <label class="label-tech mb-0" style="font-size: 0.6rem; color: #a0aec0; letter-spacing: 0.5px;">OBSERVACIONES</label>
                                <p class="obs-text mb-0 mt-1" style="line-height: 1.2;">
                                    <i class="fas fa-comment-dots me-1" style="font-size: 0.75rem;"></i>
                                    {{ Str::limit($estudiante->observaciones_admin, 50) ?: 'Sin comentarios' }}
                                </p>
                            </div>

                            <div class="col-md-2 text-end">
                                <div class="action-buttons d-flex flex-row justify-content-end align-items-center gap-2">
                                    <a href="{{ route('estudiantes.edit', $estudiante->id) }}" class="btn-action edit" title="Editar"><i class="fas fa-pen"></i></a>
                                    <a href="{{ route('estudiantes.registro_pdf_post', $estudiante->id_hex) }}" class="btn-action print" title="PDF"><i class="fas fa-file-pdf"></i></a>
                                    <a href="{{ route('estudiantes.download-zip', $estudiante->id) }}" class="btn-action download" title="ZIP"><i class="fas fa-archive"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach                
                <div class="d-flex justify-content-between align-items-center flex-wrap mt-4 mb-1 px-3">
                    <div class="pagination-wrapper">
                        @if($estudiantes->hasPages())
                            {{ $estudiantes->links('pagination::bootstrap-5') }}
                        @endif
                    </div>

                    <form method="GET" id="formReport" action="{{ route('estudiantes.pdf') }}" class="m-0">
                        <input id="tituloReporte" name="tituloReporte" type="hidden" value="">
                        <button id="btnImprimir" type="button" class="btn btn-rojo btn-sm d-flex align-items-center gap-2 shadow-sm" 
                                data-toggle="modal" data-target="#exampleModal" 
                                style="border-radius: 8px; padding: 8px 16px; font-weight: 700;">
                            <i class="fas fa-file-pdf mr-1"></i>
                            <span>EXPORTAR PDF</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection   