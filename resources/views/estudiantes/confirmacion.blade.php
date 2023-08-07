<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>ALIVIAN4TE :: Información de Registro </title>
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
<?php 
    //require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/include/funciones.php');

    use SimpleSoftwareIO\QrCode\Facades\QrCode;
    use Illuminate\Support\Facades\URL;

    $path = getcwd() . '/img/alivianate.jpg';
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    $logo_aliviane = 'data:image/' . $type . ';base64,' . base64_encode($data);

    $path = getcwd() . '/img/Logo_y_Escudo.jpg';
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    $logo_admon = 'data:image/' . $type . ';base64,' . base64_encode($data);

    // $qrcode2 = base64_encode(QrCode::format('png')->size(50)->generate(URL::to("/") . '/registro' . '/' . $estudiante->id_hex));
    // $qrcode = QrCode::format('png')->size(185)->errorCorrection('H')->generate(URL::to("/") . '/registro' . '/' . $estudiante->id_hex);
    $qrcode = base64_encode(\QrCode::size(1000)->errorCorrection('H')->encoding('UTF-8')->format('png')->generate(URL::to("/") . '/registro' . '/' . $estudiante->id_hex));
    // $qrcode = base64_encode(QrCode::format('png')->size(300)->generate(URL::to("/") . '/registro' . '/' . $estudiante->id_hex));
?>

<style>
        @page {
            margin: 1.5cm 1.5cm 1.5cm 1.5cm !important;                   /*arriba, derecha, abajo, izquierda*/
        }

th, td {
        font-size: 12px;
      font-family: 'Montserrat', serif;
      padding-left:5px 
}

div {
    font-size: 13px;
    font-family: 'Montserrat', serif;
    padding-top: 0px;
    padding-right: 0px;
    padding-bottom: 0px;
    padding-left: 0px;
    margin-bottom: 0px;
}
    
p {
      font-size: 20px;
      font-family: 'Montserrat', serif;
  }

  h1{
    font-size: 20px;
    font-weight: bold;
    padding-top: 0px;
    padding-right: 0px;
    padding-bottom: 0px;
    padding-left: 0px;
    margin-bottom: 0px;
    margin-top: 0px;
  }

  h2{
      font-size: 16px;
      font-family: 'Montserrat', serif;
  }

  h3{
      font-size: 14px;
      font-family: 'Montserrat', serif;
  }

  footer {
  position: fixed;
  bottom: -3.5cm;
  width: 70%;
  left: 0;
  right: 0;
  padding: 10px 10px;
  /* z-index: 1000; */
}

  .ha1
  {
      font-size: 20px;
      font-family: 'Montserrat', serif;
  }
  .center {
    margin-left: auto;
    margin-right: auto;
    width: 100%;
     }


    .ha1{
        font-size: 18px;
        font-weight: bold;
    }

    .celdagris {
        text-align:left;
        margin-left:0px;
        background-color:#EEEEEE;
    }
    
    #logo_aliviane {
    padding: 0px;
}
</style>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>ALIVIAN4TE :: Información de Registro</title>
</head>
<body>
    <header>
        <div style="text-align:center;">
            <img src="https://alivianate.concordia.gob.mx/img/logo_escudo.jpg" style="width:75%">
        </div>
        <br> 
        <div id="logo_aliviane" style="text-align:center;">
            <img src="https://alivianate.concordia.gob.mx/img/logo_alivianate.jpg" style="width:50%;"> &nbsp;
        </div>
    </header>
     <br>
     <div align="center"> <h2> CICLO ESCOLAR {{ $estudiante->ciclo->descripcion }} </h2> </div> 
    <div align="center"> <h1> DATOS DE REGISTRO <h1> </div>
    <div align="center">
       {{-- <a href="{{ url('/registro/' . $estudiante->id_hex) }}">Ver Hoja de Registro</a> --}}
       <a href="{{ url('/registro/' . $estudiante->id_hex) }}" style="display: inline-block; padding: 10px 20px; background-color: #B12A34; color: #fff; text-decoration: none; border-radius: 5px; font-weight: bold;">Ver PDF</a>

    </div>
    <br>
    <table width="100%" border="1" cellspacing="0">
        <tr>
            <td width="30%" align="right"><b>Nombre:</b></td>
            <td width="70%">{{ $estudiante->nombre }} {{ $estudiante->primer_apellido }} {{ $estudiante->segundo_apellido }}</td>
        </tr>
        <tr>
            <td width="30%" align="right"><b>CURP:</b></td>
            <td width="70%">{{ $estudiante->curp }}</td>
        </tr>
        <tr>
            <td width="30%" align="right"><b>Fecha Nac:</b></td>
            <td width="70%">{{ date('d-m-Y', strtotime($estudiante->fecha_nac)) }}</td>
        </tr>
        <tr>
            <td width="30%" align="right"><b>Celular:</b></td>
            <td width="70%">{{ $estudiante->celular }}</td>
        </tr>
        <tr>
            <td width="30%" align="right"><b>E-mail:</b></td>
            <td width="70%">{{ $estudiante->email }}</td>
        </tr>
        <tr>
            <td width="30%" align="right"><b>Lugar Origen:</b></td>
            <td width="70%">{{ $estudiante->localidad_origen->localidad }}</td>
        </tr>
        <tr>
            <td width="30%" align="right"><b>Lugar Transporte:</b></td>
            <td width="70%">{{ $estudiante->localidad_actual->localidad }}</td>
        </tr>
    </table>
    <br>
    <div align="center">
        <h2>INFORMACIÓN ESCOLAR</h2>
    </div>
    <table width="100%" border="1" cellspacing="0">
        <tr>
            <td width="30%" align="right"><b>Institución Educativa:</b></td>
            <td width="70%">{{ $estudiante->escuela->escuela }}</td>
        </tr>
        <tr>
            <td width="30%" align="right"><b>Carrera:</b></td>
            <td width="70%">{{ $estudiante->carrera }}</td>
        </tr>
        <tr>
            <td width="30%" align="right"><b>Ciudad Escuela:</b></td>
            <td width="70%">{{ $estudiante->ciudad->ciudad }}</td>
        </tr>
        <tr>
            <td width="30%" align="right"><b>Turno Escuela:</b></td>
            <td width="70%">{{ $estudiante->turno->turno }}</td>
        </tr>
    
    <?php 
        switch ($estudiante->ano_escolar)
        {
            case 1:
                $ano_escolar = "PRIMERO";
                break;
            case 2:
                $ano_escolar = "SEGUNDO";
                break;
            case 3:
                $ano_escolar = "TERCERO";
                break;
            case 4:
                $ano_escolar = "CUARTO";
                break;
            case 5:
                $ano_escolar = "QUINTO";
                break;
            case 6:
                $ano_escolar = "SEXTO";
                break;    
        }
    ?>
        <tr>
            <td width="30%" align="right"><b>Año Escolar:</b></td>
            <td width="70%">{{ $ano_escolar }}</td>
        </tr>
        <tr>
            <td width="30%" align="right"><b>Promedio Actual:</b></td>
            <td width="70%">{{ $estudiante->promedio }}</td>
        </tr>
    </table>
    <br>
    <div align="center">
        <h2>INFORMACIÓN SOCIOECONÓMICA</h2>
    </div>
    <table width="100%" border="1" cellspacing="0">
        <tr>
            <td width="55%" align="right"><b>¿De qué material es el techo de tu vivienda?</b></td>
            <td width="45%">{{ $estudiante->socioeconomico->techo->techo }}</td>
        </tr>
        <tr>
            <td width="55%" align="right"><b>¿Cuántos cuartos y baños disponen en tu vivienda?</b></td>
            <td width="45%">{{ $estudiante->socioeconomico->cuartos_vivienda }}</td>
        </tr>
        <tr>
            <td width="55%" align="right"><b>¿Cuántas personas viven normalmente en tu vivienda?</b></td>
            <td width="45%">{{ $estudiante->socioeconomico->personas_vivienda }}</td>
        </tr>
        <tr>
            <td width="55%" align="right"><b>¿Cuál es el monto mensual que entra a tu hogar?</b></td>
            <td width="45%">{{ $estudiante->socioeconomico->monto_mensual->monto }}</td>
        </tr>
        <tr>
            <td width="55%" align="right"><b>¿Recibes alguna beca para apoyar tus estudios?</b></td>
            <td width="45%">{{ $estudiante->socioeconomico->beca_estudios == 1 ? 'SÍ' : 'NO' }}</td>
        </tr>
        <tr>
            <td width="55%" align="right"><b>¿Recibes algún tipo de ayuda económica del gobierno?</b></td>
            <td width="45%">{{ $estudiante->socioeconomico->ayuda_gobierno == 1 ? 'SÍ' : 'NO' }}</td>
        </tr>
        <?php  
            $empleo = false;
            if (strlen($estudiante->socioeconomico->empleo) > 0) $empleo = true;
        ?>
        <tr>
            <td width="55%" align="right"><b>¿Recibes alguna beca para apoyar tus estudios?</b></td>
            <td width="45%">{{ $estudiante->socioeconomico->beca_estudios == 1 ? 'SÍ' : 'NO' }}</td>
        </tr>
        <tr>
            <td width="55%" align="right"><b>¿Recibes algún tipo de ayuda económica del gobierno?</b></td>
            <td width="45%">{{ $estudiante->socioeconomico->ayuda_gobierno == 1 ? 'SÍ' : 'NO' }}</td>
        </tr>
    </table>
</body>
</html>