<?php

    namespace App\Utils;
    use App\Models\BoletoAsignado;
    use App\Models\BoletosRemesa;
    use App\Models\ApoyoAsignado;

    class HelperFunctions
    {

        public static function formato_fecha_espanol_corta($fecha)
        {
            $fecha2 = strtotime($fecha);
            $dia = date('d', $fecha2);
            $mes_numero = date('m', $fecha2);
            switch ($mes_numero)
            {
                case 1:
                    $mes = "ENE";
                    break;
                case 2:
                    $mes = "FEB";
                    break;
                case 3:
                    $mes = "MAR";
                    break;
                case 4:
                    $mes = "ABR";
                    break;
                case 5:
                    $mes = "MAY";
                    break;
                case 6:
                    $mes = "JUN";
                    break;
                case 7:
                    $mes = "JUL";
                    break;
                case 8:
                    $mes = "AGO";
                    break;
                case 9:
                    $mes = "SEP";
                    break;
                case 10:
                    $mes = "OCT";
                    break;
                case 11:
                    $mes = "NOV";
                    break;
                case 12:
                    $mes = "DIC";
                    break;
            }
            return $dia . '-' . $mes . '-' . date('Y', $fecha2);
        }

        public static function folios_asignados($id_remesa, $id_estudiante)
        {
            $folios_asignados = "";
            $asignados = BoletoAsignado::where('id_remesa', $id_remesa)->where('id_estudiante', $id_estudiante)->get();

            if ($asignados->count() == 0) return "N/A";
            foreach($asignados as $asignado)
            {
                if ($asignado->folio_inicial == $asignado->folio_final) $folios_asignados = $folios_asignados . " [ " . $asignado->folio_inicial . " ] "; 
                else $folios_asignados = $folios_asignados . " [ " . $asignado->folio_inicial . " - " . $asignado->folio_final . " ] "; 
            }

            return $folios_asignados;
        }

        public static function monto_asignado($id_remesa, $id_estudiante)
        {
            $monto_asignado = ApoyoAsignado::where('id_remesa', $id_remesa)->where('id_estudiante', $id_estudiante)->first();
    
            if (!isset($monto_asignado)) return "N/A";
    
            return '$ ' . $monto_asignado->monto;
        }
    }

    

    