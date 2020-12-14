<html>

<head>
    <title></title>

    <style>
        .txtn {
            font-size: 12px;
            color: #3dae57;
            font-family: sans-serif;
        }

        .clave {
            font-size: 12px;
            color: #000;
            font-family: sans-serif;
        }

        .cicloescolar {
            font-size: 9px;
            color: #000000;
            font-weight: bold;
            font-family: sans-serif;
        }

        .slogan {
            font-size: 12px;
            font-family: sans-serif;
            font-weight: bold;
        }

        .nombreplantel {
            font-size: 12px;
            font-weight: bold;
            color: #1f497d;
            font-family: sans-serif;
        }

        .tipoplantel {
            font-size: 12px;
            padding: 0px;
            margin: 0px;
            color: #365f91;
            font-family: sans-serif;
        }

        .titulo {
            font-size: 7px;
            text-align: center;
            font-family: sans-serif;
            font-weight: bold;
        }

        .cuerpo {
            font-size: 7px;
            text-align: left;
            font-family: sans-serif;
        }

        .secondtxt {
            font-size: 5px;
            font-family: sans-serif;
            vertical-align: middle;
        }

        .thirdtxt {
            font-size: 7px;
            font-family: sans-serif;
        }

        .bg-prom {
            background-color: #ccc;
        }

        .tituloalumno {
            font-size: 7px;
            font-family: sans-serif;

        }

        .meses {
            font-size: 10px;
            font-family: sans-serif;

        }

        .trimestre {
            font-size: 10px;
            font-family: sans-serif;
            font-weight: bolder;
            text-align: center;
        }

        .tblcalificacion td {
            border-collapse: collapse;
            border: solid black 1px;
        }

        tr:nth-of-type(5) td:nth-of-type(1) {
            visible: hidden;
        }

        .rotate {

            white-space: nowrap;
            width: 2.0em;
            font-size: 9px;
            font-family: sans-serif;
        }

        .rotate div {
            -moz-transform: rotate(-90.0deg);
            -o-transform: rotate(-90.0deg);
            -webkit-transform: rotate(-90.0deg);
            transform: rotate(-90.0deg);
            margin-left: -10em;
            margin-right: -10em;
            margin-top: -8em;
        }

        .rotatepromediofinal {
            white-space: nowrap;
            width: 2.0em;
            font-size: 9px;
            font-weight: bolder;
            font-family: sans-serif;
        }

        .rotatepromediofinal div {
            -moz-transform: rotate(-90.0deg);
            -o-transform: rotate(-90.0deg);
            -webkit-transform: rotate(-90.0deg);
            transform: rotate(-90.0deg);
            margin-left: -10em;
            margin-right: -10em;
            margin-top: -7.5em;
        }

        .calificacion {
            font-size: 9px;
            font-weight: bolder;
            font-family: sans-serif;
        }

        .nombreclase {
            font-size: 10px;
            font-weight: bolder;
            font-family: sans-serif;
        }

        .asignatura {
            font-size: 12px;
            font-weight: bolder;
            font-family: sans-serif;
            text-align: center;
        }

        .boleta {
            font-size: 12px;
            font-weight: bolder;
            font-family: sans-serif;
            text-align: center;
        }

        .alumno {
            font-size: 9px;
            font-weight: bolder;
            font-family: sans-serif;
        }

        .director {
            font-size: 9px;
            font-weight: bolder;
            font-family: sans-serif;
        }
    </style>
</head>

<body>
    <?php
    $logo =   base_url() . '/assets/images/escuelas/secundario_licenciatura.png';
    $logo2 =   base_url() . '/assets/images/escuelas/secundario_licenciatura.png';
    $dato =   $_SERVER['DOCUMENT_ROOT'] . '/sice/assets/images/escuelas/' . 'secundario_licenciatura.png';
    $tabla = '
    
  
     <table width="500" border="0" cellpadding="3" class="tblborder" cellspacing="0">
     <tr>
     <td width="120" align="center"> 
     </td>
     <td colspan="2" width="260" align="center">
     <label class="slogan">"' . str_replace("INSTITUTO MORELOS", "", $detalle_logo[0]->nombreplantel) . '"</label><br />
     <label class="nombreplantel">' . str_replace("VALOR Y CONFIANZA", "", $detalle_logo[0]->nombreplantel) . '</label><br />
     <label class="tipoplantel">' . $detalle_logo[0]->asociado . '  ' . $detalle_logo[0]->clave . '</label><br />
     <label class="clave">Ciclo Escolar: ' . $detalle_cicloescolar->yearinicio . ' - ' . $detalle_cicloescolar->yearfin . '</label><br />
     <label class="txtn">136 años educando a la niñez y juventud</label
     ></td>
     <td width="120" align="center">
     <img src="' . $logo2 . '" width="150" height="70" />
     </td>
     </tr>
     <tr>
     <td align="center" colspan="4" class="boleta">BOLETA DE EVALUACIÓN</td>
     </tr>
     <tr>
     <td  colspan="2" class="alumno">NOMBRE DEL ALUMNO: ' . $alumno->apellidop . ' ' . $alumno->apellidom . ' ' . $alumno->nombre . '</td>
     <td  colspan="2" class="alumno" align="right">' . $detalle_grupo->primaria . ' ' . $detalle_grupo->nombregrupo . '</td>
     </tr>
    
     </table><br>
    <table class="tblcalificacion" cellpadding="2" cellspacing="0">
    <tr>
      <td width="280" rowspan="2" class="asignatura">ASIGNATURA AREAS</td>
      <td colspan="4" width="10" class="trimestre">1° TRIMESTRE</td>
      <td colspan="5" width="10" class="trimestre">2° TRIMESTRE</td>
      <td colspan="4"  width="10"class="trimestre">3° TRIMESTRE</td>
      <td rowspan="2" class="rotatepromediofinal" width="10"><div>PROMEDIO FINAL</div></td>
    </tr>
    <tr  >
      <td height="50" class="rotate" width="10"><div>SEPTIEMBRE</div></td>
      <td height="50" class="rotate" width="10"><div>OCTUBRE</div></td>
      <td height="50" class="rotate" width="10"><div>NOVIEMBRE</div></td>
      <td height="50" class="rotate" width="10"><div>PROMEDIO</div></td>
      <td height="50" class="rotate" width="10"><div>DICIEMBRE</div></td>
      <td height="50" class="rotate" width="10"><div>ENERO</div></td>
      <td height="50" class="rotate" width="10"><div>FEBRERO</div></td>
      <td height="50" class="rotate" width="10"><div>MARZO</div></td>
      <td height="50" class="rotate" width="10"><div>PROMEDIO</div></td>
      <td height="50" class="rotate" width="10"><div>ABRIL</div></td>
      <td height="50" class="rotate" width="10"><div>MAYO</div></td>
      <td height="50" class="rotate" width="10"><div>JUNIO</div></td>
      <td height="50" class="rotate" width="10"><div>PROMEDIO</div></td>
    </tr>';
    $primer_trimestre  = $this->cicloescolar->showAllPrimerTrimestre();
    $total_primer_trimeste = count($primer_trimestre);

    $segundo_trimestre  = $this->cicloescolar->showAllSegundoTrimestre();
    $total_segundo_trimeste = count($segundo_trimestre);

    $tercer_trimestre  = $this->cicloescolar->showAllTercerTrimestre();
    $total_tercer_trimeste = count($tercer_trimestre);

    $suma_promedio = 0;
    foreach ($materias as $materia) {
        $suma_promedio = 0;
        $idprofesormateria = $materia->idprofesormateri;
        $tabla .= '<tr>
                <td class="nombreclase"  height="2">' . $materia->nombreclase . '</td>';
        $suma_primer_trimestre = 0;
        foreach ($primer_trimestre as $primero) {
            $idmes = $primero->idmes;
            $calificacion = $this->cicloescolar->calificacionXMes($idprofesormateria, $idalumno, $idmes, $idhorario);
            if ($calificacion) {
                $suma_primer_trimestre  += $calificacion->calificacion;
                $tabla  .= '<td class="calificacion" align="center"  height="2">' . eliminarDecimalCero($calificacion->calificacion) . '</td>';
            } else {
                $tabla .= '<td class="calificacion" align="center"  height="2">0</td>';
            }
        }
        if ($total_primer_trimeste > 0 && $suma_primer_trimestre > 0) {
            $promedio = $suma_primer_trimestre / $total_primer_trimeste;
            $suma_promedio += $suma_primer_trimestre / $total_primer_trimeste;
            $tabla .= '<td class="calificacion" align="center"   height="2">' . eliminarDecimalCero(numberFormatPrecision($promedio, 1, '.')) . '</td>';
        } else {
            $tabla .= '<td class="calificacion" align="center"  height="2">0</td>';
        }

        $suma_segundo_trimestre = 0;
        foreach ($segundo_trimestre as $segundo) {
            $idmes = $segundo->idmes;
            $calificacion = $this->cicloescolar->calificacionXMes($idprofesormateria, $idalumno, $idmes, $idhorario);
            if ($calificacion) {
                $suma_segundo_trimestre  += $calificacion->calificacion;

                $tabla  .= '<td class="calificacion" align="center"  height="2">' . eliminarDecimalCero($calificacion->calificacion) . '</td>';
            } else {
                $tabla .= '<td class="calificacion" align="center"  height="2">0</td>';
            }
        }
        if ($total_segundo_trimeste > 0 && $suma_segundo_trimestre > 0) {
            $promedio = $suma_segundo_trimestre / $total_segundo_trimeste;
            $suma_promedio += $suma_segundo_trimestre / $total_segundo_trimeste;
            $tabla .= '<td class="calificacion" align="center"  height="2">' . eliminarDecimalCero(numberFormatPrecision($promedio, 1, '.')) . '</td>';
        } else {
            $tabla .= '<td class="calificacion" align="center"  height="2">0</td>';
        }

        $suma_tercer_trimestre = 0;
        foreach ($tercer_trimestre as $tercer) {
            $idmes = $tercer->idmes;
            $calificacion = $this->cicloescolar->calificacionXMes($idprofesormateria, $idalumno, $idmes, $idhorario);
            if ($calificacion) {
                $suma_tercer_trimestre  += $calificacion->calificacion;
                $tabla  .= '<td class="calificacion" align="center"  height="2">' . eliminarDecimalCero($calificacion->calificacion) . '</td>';
            } else {
                $tabla .= '<td class="calificacion" align="center"  height="2">0</td>';
            }
        }
        if ($total_tercer_trimeste > 0 && $suma_tercer_trimestre > 0) {
            $promedio = $suma_tercer_trimestre / $total_tercer_trimeste;
            $suma_promedio += $suma_tercer_trimestre / $total_tercer_trimeste;
            $tabla .= '<td class="calificacion" align="center"  height="2">' . eliminarDecimalCero(numberFormatPrecision($promedio, 1, '.')) . '</td>';
        } else {
            $tabla .= '<td class="calificacion" align="center"  height="2">0</td>';
        }
        $promedio_final = $suma_promedio / 3;
        $tabla  .= '     
               
                <td class="calificacion" align="center"  height="2">' .  eliminarDecimalCero(numberFormatPrecision($promedio_final, 1, '.'))  . '</td>
        </tr>';
    }
    $tabla .= '</table>';
    $tabla .= ' <br/><br/><br/>
        <table width="500"  border="0">
        <tr>
                <td colspan="5" align="center" class="director" width="200">PROFESORA DEL GRUPO</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td colspan="5" align="center" class="director" width="200">DIRECTOR</td>
            </tr>
            <tr>
            <td colspan="5" align="center" style="border-bottom:solid black 1px;" width="200"></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="5" align="center" style="border-bottom:solid black 1px;" width="200"></td>
        </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td >&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td >&nbsp;</td>
            </tr>
        </table>
    ';
    echo $tabla;
    ?>
</body>

</html>