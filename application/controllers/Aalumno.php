<?php

use Dompdf\Dompdf;
use Dompdf\Options;

defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("America/Mexico_City");

class Aalumno extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!isset($_SESSION['user_id'])) {
            $this->session->set_flashdata('flash_data', 'You don\'t have access! ss');
            return redirect('welcome');
        }
        $this->load->helper('url');
        $this->load->library('permission');
        $this->load->library('session');
        $this->load->model('alumno_model', 'alumno');
        $this->load->model('horario_model', 'horario');
        $this->load->model('grupo_model', 'grupo');
        $this->load->model('mensaje_model', 'mensaje');
        $this->load->model('calificacion_model', 'calificacion');
        $this->load->model('cicloescolar_model', 'cicloescolar');
        $this->load->model('configuracion_model', 'configuracion');
        date_default_timezone_set("America/Mexico_City");
        $this->load->helper('numeroatexto_helper');
        $this->load->library('encryption');
    }

    public function encode($string)
    {
        $encrypted = $this->encryption->encrypt($string);
        if (!empty($string)) {
            $encrypted = strtr($encrypted, array(
                '/' => '~'
            ));
        }
        return $encrypted;
    }

    public function decode($string)
    {
        $string = strtr($string, array(
            '~' => '/'
        ));
        return $this->encryption->decrypt($string);
    }

    public function index()
    {
        Permission::grant(uri_string());
        $this->load->view('alumno/header');
        $this->load->view('alumno/index');
        $this->load->view('alumno/footer');
    }

    public function generarHorarioPDF($idhorario = '', $idalumno = '')
    {
        $idalumno = $this->decode($idalumno);
        $idhorario = $this->decode($idhorario);
        if ((isset($idhorario) && !empty($idhorario)) && (isset($idalumno) && !empty($idalumno))) {
            $detalle_logo = $this->alumno->logo($this->session->idplantel);
            $detalle_horario = $this->horario->detalleHorario($idhorario);
            $ubicacion_imagen = '/assets/images/escuelas/';
            $logo = base_url() . $ubicacion_imagen . $detalle_logo[0]->logoplantel;
            $logo2 = base_url() . $ubicacion_imagen . $detalle_logo[0]->logosegundo;

            $alumno = $this->alumno->detalleAlumno($idalumno);
            $grupo = $this->horario->showNivelGrupo($idhorario);
            $dias = $this->alumno->showAllDias();
            $datelle_alumno = $this->alumno->showAllMateriasAlumno($idalumno);
            if (isset($datelle_alumno) && !empty($datelle_alumno)) {
                $this->load->library('tcpdf');
                $hora = date("h:i:s a");
                $fechaactual = date('d/m/Y');
                $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
                $pdf->SetTitle('Horario de clases.');
                $pdf->SetHeaderMargin(30);
                $pdf->SetTopMargin(10);
                $pdf->setFooterMargin(20);
                $pdf->SetAutoPageBreak(true);
                $pdf->SetAuthor('Author');
                $pdf->SetDisplayMode('real', 'default');
                $pdf->setPrintHeader(false);
                $pdf->setPrintFooter(false);

                $pdf->SetMargins(15, 15, 15);
                $pdf->SetHeaderMargin(15);
                $pdf->SetFooterMargin(15);

                // set auto page breaks
                $pdf->SetAutoPageBreak(TRUE, 15);
                $pdf->AddPage();
                $tabla = '
        <style type="text/css">
    .txtn{
        font-size:9px;
    }
    .direccion{
        font-size:8px;
    }
    .nombreplantel{
        font-size:10px;
        font-weight:bolder;
    }
    .telefono{
          font-size:8px;
    }
    .boleta{
         font-size:9px;
         font-weight:bolder;
    }
     .periodo{
         font-size:9px;
         font-weight:bolder;
    }
    .txtgeneral{
         font-size:8px;
         font-weight:bolder;
    }
    .txtnota{
         font-size:6px;
         font-weight:bolder;
    }
    .txtcalificacion{
        font-size:10px;
         font-weight:bolder;
    }
    .imgtitle{
        width:55px;

    }
    .titulo{
     font-family:Verdana, Geneva, sans-serif;
      font-size:8px;
    font-weight:bold;
    border-bottom:solid 1px #000000;
}
.result{
     font-family:Verdana, Geneva, sans-serif;
      font-size:8px;
    font-weight:bold;
}.nombreclase{
   font-size:12px;
   font-weight: bold;
}
.txthorario{
   font-size:8px;
}
.txttutor{
   font-size:10px;
}
.txtdia{
  font-size:8px;
   font-weight: bold;
   background-color:#ccc;
}
  .tblhorario tr td
                {
                    border:0px solid black;
                }

</style>
<div id="areimprimir">
          <table width="600" border="0" cellpadding="2" cellspacing="0">';
                if ((isset($this->session->idplantel) && !empty($this->session->idplantel)) && ($this->session->idplantel == 7 || $this->session->idplantel == 8)) {
                    $tabla .= '<tr>
    <td width="150" align="center" valing="top"><img  src="' . $logo2 . '" /></td>
    <td colspan="2" width="230" align="center">
            <label class="nombreplantel">' . $detalle_logo[0]->nombreplantel . '</label><br>
            <label class="txtn">' . $detalle_logo[0]->asociado . '</label><br>
            <label class="direccion">C.C.T.' . $detalle_logo[0]->clave . '</label><br>';
                    if ($this->session->idplantel == 8) {
                        $tabla .= ' <label class="telefono">TURNO MATUTINO</label><br/>';
                    }
                    if ($this->session->idplantel == 7) {
                        $tabla .= ' <label class="telefono">TURNO VESPERTINO</label><br/>';
                    }
                    $tabla .= '<label class="telefono">136 años educando a la niñez y juventud</label>
    </td>
    <td width="150" align="center"><img     src="' . $logo . '" /></td>';
                    $tabla .= '</tr>';
                } else if ((isset($this->session->idplantel) && !empty($this->session->idplantel)) && ($this->session->idplantel == 4)) {
                    $tabla .= '<tr>
    <td width="150" align="center" valing="top"><img  src="' . $logo2 . '" /></td>
    <td colspan="2" width="230" align="center">
            <label class="nombreplantel">' . $detalle_logo[0]->nombreplantel . '</label><br>
            <label class="txtn">' . $detalle_logo[0]->asociado . '</label><br>
            <label class="direccion">C.C.T.' . $detalle_logo[0]->clave . '</label><br>';
                    $tabla .= '<label class="telefono">Incorporado a la Dirección General del Bachillerato - Modalidad Escolarizada
RVOE: 85489 de fecha 29 julio 1985, otorgado por la Dirección General de Incorporación y Revalidación
</label>
    </td>
    <td width="150" align="center"><img     src="' . $logo . '" /></td>';
                    $tabla .= '</tr>';
                } else {
                    $tabla .= '<tr>
    <td width="150" align="center" valing="top"><img class="imgtitle" src="' . $logo2 . '" /></td>
    <td colspan="2" width="230" align="center">
            <label class="nombreplantel">' . $detalle_logo[0]->nombreplantel . '</label><br>
            <label class="txtn">' . $detalle_logo[0]->asociado . '</label><br>
            <label class="direccion">C.C.T.' . $detalle_logo[0]->clave . '</label><br>';

                    $tabla .= '<label class="telefono">136 años educando a la niñez y juventud</label>
    </td>
    <td width="150" align="center"><img   class="imgtitle"  src="' . $logo . '" /></td>';
                    $tabla .= '</tr>';
                }
                $tabla .= ' <tr>
    <td align="center"  style=""><label class="titulo">Matricula</label></td>
    <td align="center"  style=""><label class="titulo">Alumno</label></td>
    <td align="center"  style=""><label class="titulo">Nivel Escolar</label></td>
    <td align="center"  style=""><label class="titulo">Periodo Escolar</label></td>
  </tr>
  <tr>
    <td align="center"><label class="result">' . $alumno->matricula . '</label></td>
    <td align="center"><label class="result">' . $alumno->nombre . ' ' . $alumno->apellidop . ' ' . $alumno->apellidom . '</label></td>
    <td align="center"><label class="result">' . $grupo->nombrenivel . ' ' . $grupo->nombregrupo . '</label></td>
    <td align="center"><label class="result">' . $grupo->mesinicio . ' ' . $grupo->yearinicio . ' - ' . $grupo->mesfin . ' ' . $grupo->yearfin . '</label></td>
  </tr>
  </table>';

                $tabla .= '<table class="tblhorario" width="600" cellpadding="2" > ';
                $tabla .= '<tr>';
                $tabla .= '<td width="65" align="center" class="txtdia">Hora</td>';
                $tabla .= '<td width="93" align="center" class="txtdia">Lunes</td>';
                $tabla .= '<td width="93" align="center" class="txtdia">Martes</td>';
                $tabla .= '<td width="93" align="center" class="txtdia">Miercoles</td>';
                $tabla .= '<td width="93" align="center" class="txtdia">Jueves</td>';
                $tabla .= '<td width="93" align="center" class="txtdia">Viernes</td>';

                $tabla .= '</tr>';
                $lunesAll = $this->horario->showAllDiaHorarioSinDua($idhorario);

                foreach ($lunesAll as $row) {
                    $tabla .= '<tr>';
                    $tabla .= '<td width="65" class="txthorario">' . $row->hora . '</td>';
                    $tabla .= '<td width="93" class="txthorario">' . $row->lunes . '</td>';
                    $tabla .= '<td  width="93"class="txthorario">' . $row->martes . '</td>';
                    $tabla .= '<td  width="93"class="txthorario">' . $row->miercoles . '</td>';
                    $tabla .= '<td width="93" class="txthorario">' . $row->jueves . '</td>';
                    $tabla .= '<td width="93" class="txthorario">' . $row->viernes . '</td>';

                    $tabla .= '</tr>';
                }
                $tabla .= '</table>';

                $pdf->writeHTML($tabla, true, false, false, false, '');

                ob_end_clean();

                $pdf->Output('Kardex de Calificaciones', 'I');
            } else {
                return "";
            }
        }
    }

    public function horarioClasesAlumno($idhorario = '', $idalumno = '')
    {
        if ((isset($idhorario) && !empty($idhorario)) && (isset($idalumno) && !empty($idalumno))) {

            $tabla = '
        <style type="text/css">
.txthorario{
   font-size:12px;
}
.txttutor{
   font-size:10px;
}
.txtdia{
  font-size:14px;
   font-weight: bold;
   background-color:#ccc;
}
  .tblhorario tr td
                {
                    border:0px solid black;
                }
.card1{
border:solid #FAF9F9 2px;
border-radius:5px;
padding:10px 10px 10px 10px;
-webkit-box-shadow: 1px 2px 3px -1px rgba(156,156,156,0.63);
-moz-box-shadow: 1px 2px 3px -1px rgba(156,156,156,0.63);
box-shadow: 1px 2px 3px -1px rgba(156,156,156,0.63);
min-height: 160px;
border-top:solid #33C1FF 2px;
}
</style>';

            $tabla .= '<div class="table-responsive"><table class="table "  > ';
            $tabla .= ' <thead class="bg-teal"> ';
            $tabla .= '<td>HORA</td>';
            $tabla .= '<td>LUNES</td>';
            $tabla .= '<td>MARTES</td>';
            $tabla .= '<td>MIERCOLES</td>';
            $tabla .= '<td>JUEVES</td>';
            $tabla .= '<td>VIERNES</td>';

            $tabla .= ' </thead>';
            $array_materias_reprobadas = array();
            $materias_reprobadas = $this->alumno->obtenerTodasMateriaReprobadasActivas($idalumno);
            if (isset($materias_reprobadas) && !empty($materias_reprobadas)) {
                foreach ($materias_reprobadas as $row) {
                    array_push($array_materias_reprobadas, $row->idmateriaprincipal);
                }
            }
            $base = base_url();
            $reprobadas = implode(",", $array_materias_reprobadas);
            $lunesAll = $this->horario->horarioClasesXDia($idhorario, $idalumno, $reprobadas);

            if (isset($lunesAll) && !empty($lunesAll)) {
                foreach ($lunesAll as $row) {
                    $tabla .= '<tr>';
                    $tabla .= '<td  ><strong>' . $row->hora . '</strong></td>';
                    $tabla .= '<td >';
                    if (isset($row->lunes) && !empty($row->lunes)) {
                        $tabla .= '<div class="card1"> <strong><i class="fa fa-book" style="color:#ff7e00;" ></i>  
                                ' . $row->lunes . '</strong><hr>';
                        if (isset($row->lunesprofesor) && !empty($row->lunesprofesor)) {
                            $tabla .= '<small><i class="fa fa-user" style="color:#3db828;" ></i> ' . $row->lunesprofesor . '</small><br>';
                        }

                        if (isset($row->lunesurl) && !empty($row->lunesurl)) {

                            $tabla .= '<a href="#"  onclick="cambiar_estado(\'' . $row->lunesidhorariodetalle . '\',\'' . $base . '\')" style="color:#1e81fb;   font-weight:bolder;"><i class="fa fa-external-link"></i> ENTRAR A CLASE</a><br>';
                        }
                        if (isset($row->lunesurlgrabado) && !empty($row->lunesurlgrabado)) {
                            $tabla .= '  <a target="_blank" href="' . $row->lunesurlgrabado . '" style="color:#1e81fb; font-weight:bolder;"><i class="fa fa-external-link"></i> CLASE GRABADA</a>';
                        }
                        $tabla .= '</div>';
                    }
                    $tabla .= '</td>';
                    $tabla .= '<td  >';
                    if (isset($row->martes) && !empty($row->martes)) {
                        $tabla .= '<div class="card1"> <strong><i class="fa fa-book" style="color:#ff7e00;"></i>  
                                ' . $row->martes . '</strong><hr>';
                        if (isset($row->martesprofesor) && !empty($row->martesprofesor)) {
                            $tabla .= '<small><i class="fa fa-user" style="color:#3db828;"></i> ' . $row->martesprofesor . '</small><br>';
                        }
                        if (isset($row->martesurl) && !empty($row->martesurl)) {
                            $tabla .= '<a href="#"  onclick="cambiar_estado(\'' . $row->martesidhorariodetalle . '\',\'' . $base . '\')" style="color:#1e81fb;   font-weight:bolder;"><i class="fa fa-external-link"></i> ENTRAR A CLASE</a><br>';
                        }
                        if (isset($row->martesurlgrabado) && !empty($row->martesurlgrabado)) {
                            $tabla .= '  <a target="_blank" href="' . $row->martesurlgrabado . '" style="color:#1e81fb; font-weight:bolder;"><i class="fa fa-external-link"></i> CLASE GRABADA</a>';
                        }
                        $tabla .= '</div>';
                    }
                    $tabla .= '</td>';
                    $tabla .= '<td >';
                    if (isset($row->miercoles) && !empty($row->miercoles)) {
                        $tabla .= '<div class="card1"> <strong><i class="fa fa-book" style="color:#ff7e00;"></i>  
                                ' . $row->miercoles . '</strong><hr>';
                        if (isset($row->miercolesprofesor) && !empty($row->miercolesprofesor)) {
                            $tabla .= '<small><i class="fa fa-user" style="color:#3db828;" ></i> ' . $row->miercolesprofesor . '</small><br>';
                        }
                        if (isset($row->miercolesurl) && !empty($row->miercolesurl)) {
                            $tabla .= '<a href="#"  onclick="cambiar_estado(\'' . $row->miercolesidhorariodetalle . '\',\'' . $base . '\')" style="color:#1e81fb;   font-weight:bolder;"><i class="fa fa-external-link"></i> ENTRAR A CLASE</a><br>';
                        }
                        if (isset($row->miercolesurlgrabado) && !empty($row->miercolesurlgrabado)) {
                            $tabla .= '  <a target="_blank" href="' . $row->miercolesurlgrabado . '" style="color:#1e81fb; font-weight:bolder;"><i class="fa fa-external-link"></i> CLASE GRABADA</a>';
                        }
                        $tabla .= '</div>';
                    }
                    $tabla .= '</td>';
                    $tabla .= '<td  >';
                    if (isset($row->jueves) && !empty($row->jueves)) {
                        $tabla .= '<div class="card1"> <strong><i class="fa fa-book" style="color:#ff7e00;"></i>  
                                ' . $row->jueves . '</strong><hr>';
                        if (isset($row->juevesprofesor) && !empty($row->juevesprofesor)) {
                            $tabla .= '<small><i class="fa fa-user" style="color:#3db828;"></i> ' . $row->juevesprofesor . '</small><br>';
                        }
                        if (isset($row->juevesurl) && !empty($row->juevesurl)) {
                            $tabla .= '<a href="#"  onclick="cambiar_estado(\'' . $row->juevesidhorariodetalle . '\',\'' . $base . '\')" style="color:#1e81fb;   font-weight:bolder;"><i class="fa fa-external-link"></i> ENTRAR A CLASE</a><br>';
                        }
                        if (isset($row->juevesurlgrabado) && !empty($row->juevesurlgrabado)) {
                            $tabla .= '  <a target="_blank" href="' . $row->juevesurlgrabado . '" style="color:#1e81fb; font-weight:bolder;"><i class="fa fa-external-link"></i> CLASE GRABADA</a>';
                        }
                        $tabla .= '</div>';
                    }
                    $tabla .= '</td>';
                    $tabla .= '<td >';
                    if (isset($row->viernes) && !empty($row->viernes)) {
                        $tabla .= '<div class="card1"> <strong><i class="fa fa-book" style="color:#ff7e00;"></i>  
                                ' . $row->viernes . '</strong><hr>';
                        if (isset($row->viernesprofesor) && !empty($row->viernesprofesor)) {
                            $tabla .= '<small><i class="fa fa-user" style="color:#3db828;" ></i> ' . $row->viernesprofesor . '</small><br>';
                        }
                        if (isset($row->viernesurl) && !empty($row->viernesurl)) {
                            $tabla .= '<a href="#"  onclick="cambiar_estado(\'' . $row->viernesidhorariodetalle . '\',\'' . $base . '\')" style="color:#1e81fb;   font-weight:bolder;"><i class="fa fa-external-link"></i> ENTRAR A CLASE</a><br>';
                        }
                        if (isset($row->viernesurlgrabado) && !empty($row->viernesurlgrabado)) {
                            $tabla .= '  <a target="_blank" href="' . $row->viernesurlgrabado . '" style="color:#1e81fb; font-weight:bolder;"><i class="fa fa-external-link"></i> CLASE GRABADA</a>';
                        }
                        $tabla .= '</div>';
                    }
                    $tabla .= '</td>';

                    $tabla .= '</tr>';
                }
            } else {
                $tabla .= '<tr><td colspan="6" align="center"><label>Sin registros</label></td></tr>';
            }
            $tabla .= '</table></div>';

            return $tabla;
        }
    }

    public function horarioMostrar($idhorario = '', $idalumno = '')
    {
        if ((isset($idhorario) && !empty($idhorario)) && (isset($idalumno) && !empty($idalumno))) {

            $tabla = '
        <style type="text/css">
.txthorario{
   font-size:12px;
}
.txttutor{
   font-size:10px;
}
.txtdia{
  font-size:14px;
   font-weight: bold;
   background-color:#ccc;
}
  .tblhorario tr td
                {
                    border:0px solid black;
                }
.card1{
border:solid #FAF9F9 2px;
border-radius:5px;
padding:10px 10px 10px 10px;
-webkit-box-shadow: 1px 2px 3px -1px rgba(156,156,156,0.63);
-moz-box-shadow: 1px 2px 3px -1px rgba(156,156,156,0.63);
box-shadow: 1px 2px 3px -1px rgba(156,156,156,0.63);
min-height: 160px;
border-top:solid #33C1FF 2px;
}
</style>';

            $tabla .= '<div class="table-responsive"><table class="table "  > ';
            $tabla .= ' <thead class="bg-teal"> ';
            $tabla .= '<td>HORA</td>';
            $tabla .= '<td>LUNES</td>';
            $tabla .= '<td>MARTES</td>';
            $tabla .= '<td>MIERCOLES</td>';
            $tabla .= '<td>JUEVES</td>';
            $tabla .= '<td>VIERNES</td>';

            $tabla .= ' </thead>';
            $array_materias_reprobadas = array();
            $materias_reprobadas = $this->alumno->obtenerTodasMateriaReprobadasActivas($idalumno);
            if (isset($materias_reprobadas) && !empty($materias_reprobadas)) {
                foreach ($materias_reprobadas as $row) {
                    array_push($array_materias_reprobadas, $row->idmateriaprincipal);
                }
            }
            $base = base_url();
            $reprobadas = implode(",", $array_materias_reprobadas);
            $lunesAll = $this->horario->showAllDiaHorarioSinDua($idhorario, $reprobadas);

            if (isset($lunesAll) && !empty($lunesAll)) {
                foreach ($lunesAll as $row) {
                    $tabla .= '<tr>';
                    $tabla .= '<td  ><strong>' . $row->hora . '</strong></td>';
                    $tabla .= '<td >';
                    if (isset($row->lunes) && !empty($row->lunes)) {
                        $tabla .= '<div class="card1">  
                                ' . $row->lunes . '<br>';
                        if (isset($row->lunesurl) && !empty($row->lunesurl)) {

                            $tabla .= '<a href="#"  onclick="cambiar_estado(\'' . $row->lunesidhorariodetalle . '\',\'' . $base . '\')" style="color:#1e81fb;   font-weight:bolder;"><i class="fa fa-external-link"></i> ENTRAR A CLASE</a>';
                        }
                        if (isset($row->lunesurlgrabado) && !empty($row->lunesurlgrabado)) {
                            $tabla .= '  <a target="_blank" href="' . $row->lunesurlgrabado . '" style="color:#1e81fb; font-weight:bolder;"><i class="fa fa-external-link"></i> CLASE GRABADA</a>';
                        }
                        $tabla .= '</div>';
                    }
                    $tabla .= '</td>';
                    $tabla .= '<td  >';
                    if (isset($row->martes) && !empty($row->martes)) {
                        $tabla .= '<div class="card1"> ' . $row->martes . '<br>';
                        if (isset($row->martesurl) && !empty($row->martesurl)) {
                            $tabla .= '<a href="#"  onclick="cambiar_estado(\'' . $row->martesidhorariodetalle . '\',\'' . $base . '\')" style="color:#1e81fb;   font-weight:bolder;"><i class="fa fa-external-link"></i> ENTRAR A CLASE</a>';
                        }
                        if (isset($row->martesurlgrabado) && !empty($row->martesurlgrabado)) {
                            $tabla .= '  <a target="_blank" href="' . $row->martesurlgrabado . '" style="color:#1e81fb; font-weight:bolder;"><i class="fa fa-external-link"></i> CLASE GRABADA</a>';
                        }
                        $tabla .= '</div>';
                    }
                    $tabla .= '</td>';
                    $tabla .= '<td >';
                    if (isset($row->miercoles) && !empty($row->miercoles)) {
                        $tabla .= '<div class="card1"> ' . $row->miercoles . '<br>';
                        if (isset($row->miercolesurl) && !empty($row->miercolesurl)) {
                            $tabla .= '<a href="#"  onclick="cambiar_estado(\'' . $row->miercolesidhorariodetalle . '\',\'' . $base . '\')" style="color:#1e81fb;   font-weight:bolder;"><i class="fa fa-external-link"></i> ENTRAR A CLASE</a>';
                        }
                        if (isset($row->miercolesurlgrabado) && !empty($row->miercolesurlgrabado)) {
                            $tabla .= '  <a target="_blank" href="' . $row->miercolesurlgrabado . '" style="color:#1e81fb; font-weight:bolder;"><i class="fa fa-external-link"></i> CLASE GRABADA</a>';
                        }
                        $tabla .= '</div>';
                    }
                    $tabla .= '</td>';
                    $tabla .= '<td  >';
                    if (isset($row->jueves) && !empty($row->jueves)) {
                        $tabla .= '<div class="card1"> ' . $row->jueves . '<br>';
                        if (isset($row->juevesurl) && !empty($row->juevesurl)) {
                            $tabla .= '<a href="#"  onclick="cambiar_estado(\'' . $row->juevesidhorariodetalle . '\',\'' . $base . '\')" style="color:#1e81fb;   font-weight:bolder;"><i class="fa fa-external-link"></i> ENTRAR A CLASE</a>';
                        }
                        if (isset($row->juevesurlgrabado) && !empty($row->juevesurlgrabado)) {
                            $tabla .= '  <a target="_blank" href="' . $row->juevesurlgrabado . '" style="color:#1e81fb; font-weight:bolder;"><i class="fa fa-external-link"></i> CLASE GRABADA</a>';
                        }
                        $tabla .= '</div>';
                    }
                    $tabla .= '</td>';
                    $tabla .= '<td >';
                    if (isset($row->viernes) && !empty($row->viernes)) {
                        $tabla .= '<div class="card1"> ' . $row->viernes . '<br>';
                        if (isset($row->viernesurl) && !empty($row->viernesurl)) {
                            $tabla .= '<a href="#"  onclick="cambiar_estado(\'' . $row->viernesidhorariodetalle . '\',\'' . $base . '\')" style="color:#1e81fb;   font-weight:bolder;"><i class="fa fa-external-link"></i> ENTRAR A CLASE</a>';
                        }
                        if (isset($row->viernesurlgrabado) && !empty($row->viernesurlgrabado)) {
                            $tabla .= '  <a target="_blank" href="' . $row->viernesurlgrabado . '" style="color:#1e81fb; font-weight:bolder;"><i class="fa fa-external-link"></i> CLASE GRABADA</a>';
                        }
                        $tabla .= '</div>';
                    }
                    $tabla .= '</td>';

                    $tabla .= '</tr>';
                }
            } else {
                $tabla .= '<tr><td colspan="6" align="center"><label>Sin registros</label></td></tr>';
            }
            $tabla .= '</table></div>';

            return $tabla;
        }
    }

    public function verificarhora()
    {
        date_default_timezone_set("America/Mexico_City");
        $idhorariodetalle = $this->input->post('idhorariodetalle');

        if ((isset($idhorariodetalle) && !empty($idhorariodetalle))) {
            $detalle_horario = $this->horario->detalleHorarioDetalle($idhorariodetalle);
            if (isset($detalle_horario) && !empty($detalle_horario)) {
                $hora_inicial = $detalle_horario[0]->horainicial;
                $hora = date('H:i', strtotime($hora_inicial));
                $horafinal = $detalle_horario[0]->horafinal;
                $iddia = $detalle_horario[0]->iddia;
                $idhorario = $detalle_horario[0]->idhorario;
                $idalumno = $this->session->idalumno;
                $url = $detalle_horario[0]->urlvideoconferencia;
                $numero_dia = date('N');
                $nombre_dia = "";
                switch ($iddia) {
                    case 1:
                        $nombre_dia = "LUNES";

                        break;
                    case 2:
                        $nombre_dia = "MARTES";

                        break;
                    case 3:
                        $nombre_dia = "MIERCOLES";

                        break;
                    case 4:
                        $nombre_dia = "JUEVES";

                        break;
                    case 5:
                        $nombre_dia = "VIERNES";

                        break;

                    default:
                        $nombre_dia = "NO ESPECIFICADO";
                        break;
                }
                if ($iddia == $numero_dia) {
                    $fecha_actual = date('Y-m-d H:i:s');
                    $hora_actual = strtotime('-3 minute', strtotime($hora_inicial));
                    $hora_actual_menos10minutos = date('H:i', $hora_actual);
                    $hora_actual_cero = date('H:i', strtotime($fecha_actual));
                    // $hora_actual_mas30minutos = date('H:i', strtotime('+30 minute', strtotime($hora)));

                    $hora_termino_clase = date('H:i', strtotime($horafinal));

                    if (($hora_actual_cero >= $hora_actual_menos10minutos) && ($hora_actual_cero <= $hora_termino_clase)) {
                        // ENTRA A CLASES PORQUE ESTA EN TIEMPO
                        $data = array(
                            'opcion' => 1,
                            'url' => $url
                        );
                        // VALIDAR SI LA ASISTENCIA YA ESTA REGISTRADA

                        // AGREGAR LA ASISTENCIA DEL ALUMNO
                    } else {
                        // NO PUEDE ENTRAR A CLASES PORQUE ES TEMPRANO O YA ES TARDE
                        $data = array(
                            'opcion' => 2,
                            'mensaje' => 'PUEDE ENTRAR A LA CLASE 3 MINUTOS ANTES O ANTES DE TERMINAR.'
                        );
                    }
                } else {
                    $data = array(
                        'opcion' => 4,
                        'mensaje' => 'ESTA CLASE LO PUEDE TENER  EL ' . $nombre_dia
                    );
                }
            } else {
                $data = array(
                    'opcion' => 5,
                    'mensaje' => 'ACTUALIZE LA PAGINA'
                );
            }
        } else {
            // NO VIENE POR POST URL Y HORA

            $data = array(
                'opcion' => 3,
                'mensaje' => 'Ocurrio un error, intente mas tarde.'
            );
        }
        if (isset($data) && !empty($data)) {
            echo json_encode($data);
        }
    }

    public function promedioGeneral($idalumno, $idplantel)
    {
        $suma_calificacion = 0;
        $contador = 0;
        $calificacion_final = 0.0;
        $consulta = $this->alumno->calificacionFinal($idalumno, $idplantel);

        if ($consulta) {
            foreach ($consulta as $row) {
                $contador++;
                $suma_calificacion += $row->calificacionxperiodo;
            }
            $calificacion_final = numberFormatPrecision($suma_calificacion / $contador, 1, '.');
        }
        return $calificacion_final;
    }

    public function kardex()
    {
        Permission::grant(uri_string());
        # code...
        $idalumno = $this->session->idalumno;
        //$idplantel = $this->session->idplantel;
        $kardex = $this->alumno->allKardex($this->session->idalumno);
        //$promerio = $this->promedioGeneral($idalumno, $idplantel);
        $detalle = $this->alumno->detalleAlumno($idalumno);
        $data = array(
            'kardex' => $kardex,
            'detalle' => $detalle,
            'promedio' => $this->calificacionFinal($idalumno),
            'id' => $idalumno,
            'controller' => $this
        );
        $this->load->view('alumno/header');
        $this->load->view('alumno/kardex/index', $data);
        $this->load->view('alumno/footer');
    }

    // Nuevo metodo par obtener los horario de los alumnos
    public function horariov2()
    {
        $idalumno = $this->session->idalumno;
        $idhorario = "";
        $lunes = "";
        $materias_taller = "";
        $materia_taller_seleccionada = "";
        $grupo = $this->alumno->obtenerGrupo($idalumno);
        $mostrar = FALSE;
        $tabla = "";
        $materias_repetir = "";
        if ($this->session->idniveleducativo == 3) {
            $mostrar = TRUE;
        } else {
            $mostrar = FALSE;
        }
        if ($grupo != false) {
            $idhorario = $grupo->idhorario;
            $array_materias_reprobadas = array();
            $materias_reprobadas = $this->alumno->obtenerTodasMateriaReprobadasActivas($idalumno);
            if (isset($materias_reprobadas) && !empty($materias_reprobadas)) {
                foreach ($materias_reprobadas as $row) {
                    array_push($array_materias_reprobadas, $row->idmateriaprincipal);
                }
            }
            $reprobadas = implode(",", $array_materias_reprobadas);
            $tabla = $this->horarioClasesAlumno($idhorario, $idalumno);
            $materias_repetir = $this->horario->materiasARepetir($idalumno);
            $materias_taller = $this->alumno->materiasTallerHorario($idhorario);
            $materia_taller_seleccionada = $this->alumno->materiaTallerSeleccionada($idhorario, $idalumno);
        }
        // var_dump($materia_taller_seleccionada);

        $data = array(
            'idhorario' => $idhorario,
            'idalumno' => $idalumno,
            'controller' => $this,
            'tabla' => $tabla,
            'lunes' => $lunes,
            'mostrar' => $mostrar,
            'materia_seleccionada' => $materia_taller_seleccionada,
            'materias_taller' => $materias_taller,
            'materias_repetir' => $materias_repetir
        );
        $this->load->view('alumno/header');
        $this->load->view('alumno/horario/horariov2', $data);
        $this->load->view('alumno/footer');
    }

    public function seleccionarTaller($idhorario = '', $idalumno = '', $idprofesormateria = '', $idmateria = '')
    {
        if ((isset($idhorario) && !empty($idhorario)) && (isset($idalumno) && !empty($idalumno)) && (isset($idprofesormateria) && !empty($idprofesormateria)) && (isset($idmateria) && !empty($idmateria))) {
            // ELIMINAR LA CLASE DE TALLER QUE TENGA REGISTRADO
            $eliminar = $this->alumno->deleteClaseTaller($idalumno, $idhorario);
            $data = array(
                'idalumno' => $idalumno,
                'idhorario' => $idhorario,
                'idmateria' => $idmateria,
                'idprofesormateria' => $idprofesormateria,
                'idusuario' => $this->session->user_id,
                'fecharegistro' => date('Y-m-d H:i:s')
            );
            $agregar = $this->alumno->addClaseTaller($data);
            $this->session->set_flashdata('exito_taller_clase', "Se agrego la clase de taller con exito.");
            redirect('Aalumno/horariov2');
        }
    }

    public function horario()
    {
        # code...
        Permission::grant(uri_string());

        echo $idalumno = $this->session->idalumno;
        $idhorario = "";

        $grupo = $this->alumno->obtenerGrupo($idalumno);
        if ($grupo != false) {
            echo $idhorario = $grupo->idhorario;
        }
        $tabla = $this->horarioMostrar($idhorario, $idalumno);
        $materias_repetir = $this->horario->materiasARepetir($idalumno);
        $data = array(
            'idhorario' => $idhorario,
            'idalumno' => $idalumno,
            'controller' => $this,
            'tabla' => $tabla,
            'materias_repetir' => $materias_repetir
        );
        $this->load->view('alumno/header');
        $this->load->view('alumno/horario/horario', $data);
        $this->load->view('alumno/footer');
    }

    public function obtenerCalificacion($idhorario = '', $idhorariodetalle)
    {
        # code...
        $idalumno = $this->session->idalumno;
        $detalle_horario = $this->horario->detalleHorarioDetalle($idhorariodetalle);
        $idmateria = $detalle_horario[0]->idmateria;
        $unidades = $this->grupo->unidades($this->session->idplantel);
        $alumnos = $this->alumno->showAllAlumnoId($idalumno);
        $tabla = "";
        $tabla .= '<table class="table  table-hover">
      <thead class="bg-teal">
      <th>#</th>
      <th>Nombre</th>';
        foreach ($unidades as $block) :
            $tabla .= '<th>' . $block->nombreunidad . '</th>';
        endforeach;

        $tabla .= '</thead>';
        $c = 1;
        foreach ($alumnos as $row) {
            // $alumn = $al->getAlumn();

            $tabla .= '<tr>
        <td>' . $c++ . '</td>
        <td>' . $row->apellidop . " " . $row->apellidom . " " . $row->nombre . '</td>';
            foreach ($unidades as $block) :
                $val = $this->grupo->obtenerCalificacionValidandoMateria($row->idalumno, $block->idunidad, $idhorario, $idmateria);

                $tabla .= '<td>';
                if ($val != false) {
                    $tabla .= '<label>' . $val->calificacion . '</label>';
                } else {
                    $tabla .= '<label>No registrado</label>';
                }
                $tabla .= '</td>';
            endforeach;

            $tabla .= '</tr>';
        }
        $tabla .= '</table>';
        return $tabla;
    }

    public function obetnerAsistencia($idhorario, $fechainicio, $fechafin, $idhorariodetalle)
    {
        $idalumno = $this->session->idalumno;
        $alumns = $this->alumno->showAllAlumnoId($idalumno);
        $tabla = "";

        if ($alumns != false) {
            $range = ((strtotime($fechafin) - strtotime($fechainicio)) + (24 * 60 * 60)) / (24 * 60 * 60);
            // $range= ((strtotime($_GET["finish_at"])-strtotime($_GET["start_at"]))+(24*60*60)) /(24*60*60);

            $tabla .= '<table class="table">
            <thead>
            <th>#</th> ';
            for ($i = 0; $i < $range; $i++) :
                setlocale(LC_ALL, 'es_ES');
                $fecha = strftime("%A, %d de %B", strtotime($fechainicio) + ($i * (24 * 60 * 60)));

                $domingo = date('N', strtotime($fechainicio) + ($i * (24 * 60 * 60)));
                if (($domingo != '7')) {
                    if (($domingo != '6')) {
                        $tabla .= '<th>' . $fecha . '</th>';
                    }
                }
            // echo date("d-M",strtotime($_GET["start_at"])+($i*(24*60*60)));
            endfor;
            $tabla .= '</thead>';
            $n = 1;
            foreach ($alumns as $alumn) {
                $tabla .= ' <tr>';
                $tabla .= '<td>' . $n++ . '</td>';
                for ($i = 0; $i < $range; $i++) :
                    $date_at = date("Y-m-d", strtotime($fechainicio) + ($i * (24 * 60 * 60)));
                    // $asist = AssistanceData::getByATD($alumn->id,$_GET["team_id"],$date_at);
                    $asist = $this->grupo->listaAsistencia($alumn->idalumno, $idhorario, $date_at, $idhorariodetalle);
                    $domingo = date('N', strtotime($fechainicio) + ($i * (24 * 60 * 60)));

                    if (($domingo != '7')) {
                        if (($domingo != '6')) {
                            $tabla .= '<td>';
                            if ($asist != false) {
                                switch ($asist->idmotivo) {
                                    case 1:
                                        # code...
                                        $tabla .= '<span class="label label-success">' . $asist->nombremotivo . '</span>';
                                        break;
                                    case 2:
                                        $tabla .= '<span class="label label-warning">' . $asist->nombremotivo . '</span>';
                                        # code...
                                        break;
                                    case 3:
                                        $tabla .= '<span class="label label-info">' . $asist->nombremotivo . '</span>';
                                        # code...
                                        break;
                                    case 4:
                                        $tabla .= '<span class="label label-danger">' . $asist->nombremotivo . '</span>';
                                        # code...
                                        break;

                                    default:
                                        # code...
                                        break;
                                }
                            } else {
                                $tabla .= "No registrado";
                            }

                            $tabla .= '</td>';
                        }
                    }
                endfor;
                $tabla .= '</tr>';
            }
            $tabla .= '</table>';
        }
        return $tabla;
    }

    public function buscarAsistencia($idhorario, $idhorariodetalle, $fechainicio, $fechafin, $idmotivo)
    {
        Permission::grant(uri_string());
        $idalumno = $this->session->idalumno;
        $idhorario = $this->decode($idhorario);
        // $idmotivo = $this->input->post('motivo');
        $idhorariodetalle = $this->decode($idhorariodetalle);
        // $fechainicio = $this->input->post('fechainicio');
        // $fechafin = $this->input->post('fechafin');
        if ((isset($idhorario) && !empty($idhorario)) && (isset($idhorariodetalle) && !empty($idhorariodetalle)) && (isset($fechainicio) && !empty($fechainicio)) && (isset($fechafin) && !empty($fechafin)) && (isset($idmotivo))) {
            $alumns = $this->alumno->showAllAlumnoId($idalumno);
            $tabla = "";

            if ($alumns != false) {
                $range = ((strtotime($fechafin) - strtotime($fechainicio)) + (24 * 60 * 60)) / (24 * 60 * 60);
                // $range= ((strtotime($_GET["finish_at"])-strtotime($_GET["start_at"]))+(24*60*60)) /(24*60*60);

                $tabla .= '<table id="tablageneral2" class="table table-striped  dt-responsive nowrap" cellspacing="0" width="100%">
           <thead class="bg-teal">
            <th>#</th> ';
                for ($i = 0; $i < $range; $i++) :
                    setlocale(LC_ALL, 'es_ES');

                    $fecha = strftime("%A, %d de %B", strtotime($fechainicio) + ($i * (24 * 60 * 60)));

                    $tabla .= '<th>' . utf8_encode($fecha) . '</th>';
                // echo date("d-M",strtotime($_GET["start_at"])+($i*(24*60*60)));
                endfor;
                $tabla .= '</thead>';
                $n = 1;
                foreach ($alumns as $alumn) {
                    $tabla .= ' <tr>';
                    $tabla .= '<td>' . $n++ . '</td>';
                    for ($i = 0; $i < $range; $i++) :
                        $date_at = date("Y-m-d", strtotime($fechainicio) + ($i * (24 * 60 * 60)));
                        // $asist = AssistanceData::getByATD($alumn->id,$_GET["team_id"],$date_at);
                        $asist = $this->grupo->listaAsistenciaBuscar($alumn->idalumno, $idhorario, $date_at, $idhorariodetalle, $idmotivo);

                        $tabla .= '<td>';
                        if ($asist != false) {
                            switch ($asist->idmotivo) {
                                case 1:
                                    # code...
                                    $tabla .= '<span class="label label-success">' . $asist->nombremotivo . '</span>';
                                    break;
                                case 2:
                                    $tabla .= '<span class="label label-warning">' . $asist->nombremotivo . '</span>';
                                    # code...
                                    break;
                                case 3:
                                    $tabla .= '<span class="label label-info">' . $asist->nombremotivo . '</span>';
                                    # code...
                                    break;
                                case 4:
                                    $tabla .= '<span class="label label-danger">' . $asist->nombremotivo . '</span>';
                                    # code...
                                    break;

                                default:
                                    # code...
                                    break;
                            }
                        } else {
                            $tabla .= "No registrado";
                        }

                        $tabla .= '</td>';
                    endfor;
                    $tabla .= '</tr>';
                }
                $tabla .= '</table>';
            }

            $motivos = $this->alumno->showAllMotivoAsistencia();
            $detalle = $this->alumno->detalleClase($idhorariodetalle);

            $nombreclase = $detalle[0]->nombreclase;
            $data = array(
                // 'tabla'=>$this->obtenerCalificacion($idhorario,$idhorariodetalle)
                'tabla' => $tabla,
                'nombreclase' => $nombreclase,
                'idhorario' => $idhorario,
                'idhorariodetalle' => $idhorariodetalle,
                'motivos' => $motivos,
                'controller' => $this
            );
            $this->load->view('alumno/header');
            $this->load->view('alumno/calificacion/buscar_asistencia', $data);
            $this->load->view('alumno/footer');
        } else {
            $data = array(
                'heading' => 'Error',
                'message' => 'Intente mas tarde.'
            );
            $this->load->view('errors/html/error_general', $data);
        }
    }

    public function clases()
    {
        # code...
        Permission::grant(uri_string());
        $idalumno = $this->session->idalumno;
        $grupo = $this->alumno->obtenerGrupo($idalumno);

        $materias = "";
        if ($grupo != false) {
            $idhorario = $grupo->idhorario;
            $array_materias_reprobadas = array();
            $materias_reprobadas = $this->alumno->obtenerTodasMateriaReprobadasActivas($idalumno);

            if (isset($materias_reprobadas) && !empty($materias_reprobadas)) {
                foreach ($materias_reprobadas as $row) {
                    array_push($array_materias_reprobadas, $row->idmateriaprincipal);
                }
            }
            $reprobadas = implode(",", $array_materias_reprobadas);

            $materias = $this->alumno->showAllMateriasTareas($idhorario, $reprobadas, $idalumno);
        }
        $data = array(
            'materias' => $materias,
            'controller' => $this
        );
        $this->load->view('alumno/header');
        $this->load->view('alumno/calificacion/index', $data);
        $this->load->view('alumno/footer');
    }

    public function tareas($idhorario, $idhorariodetalle, $idmateria)
    {
        $idhorario = $this->decode($idhorario);
        $idhorariodetalle = $this->decode($idhorariodetalle);
        $idmateria = $this->decode($idmateria);
        if ((isset($idhorario) && !empty($idhorario)) && (isset($idhorariodetalle) && !empty($idhorariodetalle)) && (isset($idmateria) && !empty($idmateria))) {
            $data = array(
                'idhorario' => $this->encode($idhorario),
                'idhorariodetalle' => $idhorariodetalle,
                'idmateria' => $idmateria,
                'controller' => $this
            );
            $this->load->view('alumno/header');
            $this->load->view('alumno/tarea/tareas', $data);
            $this->load->view('alumno/footer');
        }
    }
    public function  mensajes($idhorario, $idhorariodetalle, $idmateria)
    {
        $idhorario = $this->decode($idhorario);
        $idhorariodetalle = $this->decode($idhorariodetalle);
        $idmateria = $this->decode($idmateria);
        $mensajes = $this->mensaje->showAllMensajePorMateria($idhorario, $idmateria);

        if ((isset($idhorario) && !empty($idhorario)) && (isset($idhorariodetalle) && !empty($idhorariodetalle)) && (isset($idmateria) && !empty($idmateria))) {
            $data = array(
                'idhorario' => $this->encode($idhorario),
                'idhorariodetalle' => $idhorariodetalle,
                'idmateria' => $idmateria,
                'mensajes' => $mensajes,
                'controller' => $this
            );
            $this->load->view('alumno/header');
            $this->load->view('alumno/mensaje/index', $data);
            $this->load->view('alumno/footer');
        }
    }
    public function calificacion($idhorario, $idhorariodetalle)
    {
        # code...
        Permission::grant(uri_string());
        $idhorario = $this->decode($idhorario);
        $idhorariodetalle = $this->decode($idhorariodetalle);
        if ((isset($idhorario) && !empty($idhorario)) && (isset($idhorariodetalle) && !empty($idhorariodetalle))) {
            $detalle = $this->alumno->detalleClase($idhorariodetalle);
            $nombreclase = $detalle[0]->nombreclase;
            $data = array(
                'tabla' => $this->obtenerCalificacion($idhorario, $idhorariodetalle),
                'nombreclase' => $nombreclase
            );

            $this->load->view('alumno/header');
            $this->load->view('alumno/calificacion/calificacion', $data);
            $this->load->view('alumno/footer');
        } else {
            $data = array(
                'heading' => 'Error',
                'message' => 'Error intente mas tarde.'
            );
            $this->load->view('errors/html/error_general', $data);
        }
    }

    public function asistencia($idhorario, $idhorariodetalle)
    {
        # code...
        Permission::grant(uri_string());
        $idhorario = $this->decode($idhorario);
        $idhorariodetalle = $this->decode($idhorariodetalle);
        if ((isset($idhorario) && !empty($idhorario)) && (isset($idhorariodetalle) && !empty($idhorariodetalle))) {
            $detalle = $this->alumno->detalleClase($idhorariodetalle);
            $nombreclase = $detalle[0]->nombreclase;
            $idalumno = $this->session->idalumno;
            $datafin = $this->alumno->ultimaFechaAsistencia($idalumno, $idhorariodetalle);
            $datainicio = $this->alumno->primeraFechaAsistencia($idalumno, $idhorariodetalle);

            // if($datafin != false && $datainicio != false){
            // $tabla = $this->obetnerAsistencia($idhorario,$datainicio->fecha,$datafin->fecha,$idhorariodetalle);
            // }else{
            $tabla = $this->obetnerAsistencia($idhorario, date("Y-m-d"), date("Y-m-d"), $idhorariodetalle);
            // }
            $motivos = $this->alumno->showAllMotivoAsistencia();
            $data = array(
                // 'tabla'=>$this->obtenerCalificacion($idhorario,$idhorariodetalle)
                'tabla' => $tabla,
                'nombreclase' => $nombreclase,
                'idhorario' => $idhorario,
                'idhorariodetalle' => $idhorariodetalle,
                'motivos' => $motivos,
                'controller' => $this
            );
            $this->load->view('alumno/header');
            $this->load->view('alumno/calificacion/asistencia', $data);
            $this->load->view('alumno/footer');
        } else {
            $data = array(
                'heading' => 'Error',
                'message' => 'Error intente mas tarde.'
            );
            $this->load->view('errors/html/error_general', $data);
        }
    }

    public function tarea($idhorario, $idhorariodetalle, $idmateria)
    {
        # code...
        Permission::grant(uri_string());
        $detalle = $this->alumno->detalleClase($idhorariodetalle);
        $nombreclase = $detalle[0]->nombreclase;
        $tareas = $this->alumno->showAllTareaAlumno($idhorario, $idmateria);
        $data = array(
            'tareas' => $tareas,
            'nombreclase' => $nombreclase
        );
        $this->load->view('alumno/header');
        $this->load->view('alumno/calificacion/tarea', $data);
        $this->load->view('alumno/footer');
    }

    public function obtenerCalificacionSecundaria($idhorario = '', $idalumno = '', $idperiodo = '')
    {
        # code...
        Permission::grant(uri_string());
        // $unidades = $this->grupo->unidades($this->session->idplantel);
        //$materias = $this->alumno->obtenerMateriasHorario($idalumno, $idhorario);
        $datoshorario = $this->horario->showNivelGrupo($idhorario);
        $idnivelestudio = $datoshorario->idnivelestudio;
        $calificaciones  = $this->alumno->spObtenerCalificacion($idalumno, $idhorario, $idperiodo);
        //$oportunidades_examen = $this->alumno->showAllOportunidadesExamen($this->session->idplantel);

        $detalle_configuracion = $this->configuracion->showAllConfiguracion($this->session->idplantel, $idnivelestudio);
        /*
        // $total_unidades = 0;
        $total_materia = 0;
        if (isset($materias) && !empty($materias)) {
            foreach ($materias as $row) {
                # code...
                $total_materia = $total_materia + 1;
            }
        }*/
        $tabla = "";
        $tabla .= '<div class="table-responsive"> <table class="table  table-striped  table-hover">
        <thead class="bg-teal">
             <th>NO.</th>
             <th>MATERIA</th>';
        $tabla .= '<th><center>CALIFICACIÓN</center></th>';
        // $tabla .= '<th></th>';
        $tabla .= '</thead>';
        $c = 1;
        $total_materia = 0;
        $suma_calificacion = 0;
        if (isset($calificaciones) && !empty($calificaciones)) {
            foreach ($calificaciones as $row) {
                if ($row->mostrar === "SI") {
                    $total_materia++;
                    $suma_calificacion += $row->calificacion;
                    /*$idprofesormateria = $row->idprofesormateria;
                $calificacion = 0;
                foreach ($oportunidades_examen as $oportunidad) {
                    $idoportunidadexamen = $oportunidad->idoportunidadexamen;
                    $detalle_calificacion = $this->alumno->obtenerCalificacionPorMateriaSecundaria($idhorario, $idprofesormateria, $idalumno, $idoportunidadexamen);
                    if ($detalle_calificacion && $calificacion == 0) {
                        $calificacion .= $detalle_calificacion->calificacion;
                    }
                }*/
                    $tabla .= '<tr>';
                    $tabla .= '<td>' . $c++ . '</td>';
                    $tabla .= '<td>' . $row->nombreclase . '</td>';
                    $tabla .= '<td align="center" >';
                    if ($detalle_configuracion[0]->calificacion_minima < $row->calificacion) {
                        $tabla .= '<label>' . eliminarDecimalCero(numberFormatPrecision($row->calificacion, 1, '.')) .  '</label>';
                    } else {
                        $tabla .= '<label style="color:red;">' . eliminarDecimalCero(numberFormatPrecision($row->calificacion, 1, '.')) .  '</label>';
                    }

                    $tabla .= '</td>';
                    //$tabla .= '<td>';
                    /* if ($row->opcion == 0) {
                    $tabla .= '<label style="color:blue;">R</label>';
                }*/

                    //$tabla .= '</td>';
                    $tabla .= '</tr>';
                }
            }
            $promedio = 0;
            if ($total_materia > 0 && $suma_calificacion > 0) {
                $promedio =  $suma_calificacion / $total_materia;
            }
            $tabla .= '
                <tr style="background-color:#ccc;" >
                    <td colspan="2" align="right"><strong><h5>PROMEDIO:</h5></strong></td>
                    <td align="center"><strong><h5>' . eliminarDecimalCero(numberFormatPrecision($promedio, 1, '.')) . '</h5></strong></td>
                </tr>
            ';
        }
        $tabla .= '</table></div>';
        return $tabla;
    }

    public function obtenerCalificacionPreparatoria($idhorario = '', $idalumno = '', $idperiodo)
    {
        # code...
        Permission::grant(uri_string());
        //$unidades = $this->grupo->unidades($this->session->idplantel);
        ///$materias = $this->alumno->showAllMateriasPasadas($idhorario, $idalumno, $idperiodo);
        $datoshorario = $this->horario->showNivelGrupo($idhorario);
        $idnivelestudio = $datoshorario->idnivelestudio;
        //$oportunidades_examen = $this->alumno->showAllOportunidadesExamen($this->session->idplantel);
        $calificaciones = $this->alumno->spObtenerCalificacion($idalumno, $idhorario, $idperiodo);
        //var_dump($calificaciones);
        $detalle_configuracion = $this->configuracion->showAllConfiguracion($this->session->idplantel, $idnivelestudio);
        /*$total_unidades = 0;
        $total_materia = 0;
        if (isset($materias) && !empty($materias)) {
            foreach ($materias as $row) {
                # code...
                $total_materia = $total_materia + 1;
            }
        }*/
        $tabla = "";
        $tabla .= '<div class="table-responsive"> <table class="table  table-striped  table-hover">
        <thead class="bg-teal">
             <th>NO.</th>
             <th>MATERIA</th>';
        $tabla .= '<th><center>CALIFICACIÓN</center></th>';
        $tabla .= '</thead>';
        $c = 1;
        $total_materia = 0;
        $suma_calificacion = 0;
        if (isset($calificaciones) && !empty($calificaciones)) {
            foreach ($calificaciones as $row) {
                /*$idhorariodetalle = $row->idhorariodetalle;
                $calificacion = 0;
                foreach ($oportunidades_examen as $oportunidad) {
                    $idoportunidadexamen = $oportunidad->idoportunidadexamen;
                    $detalle_calificacion = $this->alumno->calificacionSecuPrepa($idalumno, $idhorariodetalle, $idoportunidadexamen);
                    if ($detalle_calificacion && $calificacion == 0) {
                        $calificacion .= $detalle_calificacion[0]->calificacion;
                    }
                }*/
                if ($row->mostrar === "SI" && $row->calificacion > 0 && $row->mostrar_calificar == 'SI') {
                    $total_materia++;
                    $suma_calificacion += $row->calificacion;
                    $tabla .= '<tr>';
                    $tabla .= '<td>' . $c++ . '</td>';
                    $tabla .= '<td>' . $row->nombreclase . '</td>';
                    $tabla .= '<td align="center">';
                    if ($detalle_configuracion[0]->calificacion_minima < $row->calificacion) {
                        $tabla .= '<label>' . eliminarDecimalCero(numberFormatPrecision($row->calificacion, 1, '.')) . '</label>';
                    } else {
                        $tabla .= '<label style="color:red;">' . eliminarDecimalCero(numberFormatPrecision($row->calificacion, 1, '.')) . '</label>';
                    }

                    $tabla .= '</td>';
                    $tabla .= '</tr>';
                }
            }
            $promedio = 0;
            if ($total_materia > 0 && $suma_calificacion > 0) {
                $promedio =  $suma_calificacion / $total_materia;
            }
            $tabla .= '
                <tr style="background-color:#ccc;" >
                    <td colspan="2" align="right"><strong><h5>PROMEDIO:</h5></strong></td>
                    <td align="center"><strong><h5>' . eliminarDecimalCero(numberFormatPrecision($promedio, 1, '.')) . '</h5></strong></td>
                </tr>
            ';
        }
        $tabla .= '</table></div>';
        return $tabla;
    }

    public function obtenerCalificacionLicenciaturaFinal($idhorario = '', $idalumno = '', $idperiodo = '')
    {
        # code...
        Permission::grant(uri_string());
        //$unidades = $this->grupo->unidades($this->session->idplantel);
        ///$materias = $this->alumno->showAllMateriasPasadas($idhorario, $idalumno, $idperiodo);
        $datoshorario = $this->horario->showNivelGrupo($idhorario);
        $idnivelestudio = $datoshorario->idnivelestudio;
        //$oportunidades_examen = $this->alumno->showAllOportunidadesExamen($this->session->idplantel);
        $calificaciones = $this->alumno->spObtenerCalificacion($idalumno, $idhorario, $idperiodo);
        $detalle_configuracion = $this->configuracion->showAllConfiguracion($this->session->idplantel, $idnivelestudio);
        /*$total_unidades = 0;
        $total_materia = 0;
        if (isset($materias) && !empty($materias)) {
            foreach ($materias as $row) {
                # code...
                $total_materia = $total_materia + 1;
            }
        }*/
        $tabla = "";
        $tabla .= '<div class="table-responsive"> <table class="table  table-striped  table-hover">
        <thead class="bg-teal">
             <th>NO.</th>
             <th>MATERIA</th>';
        $tabla .= '<th><center>CALIFICACIÓN</center></th>';
        $tabla .= '</thead>';
        $c = 1;
        $total_materia = 0;
        $suma_calificacion = 0;
        if (isset($calificaciones) && !empty($calificaciones)) {
            foreach ($calificaciones as $row) {
                /*$idhorariodetalle = $row->idhorariodetalle;
                $calificacion = 0;
                foreach ($oportunidades_examen as $oportunidad) {
                    $idoportunidadexamen = $oportunidad->idoportunidadexamen;
                    $detalle_calificacion = $this->alumno->calificacionSecuPrepa($idalumno, $idhorariodetalle, $idoportunidadexamen);
                    if ($detalle_calificacion && $calificacion == 0) {
                        $calificacion .= $detalle_calificacion[0]->calificacion;
                    }
                }*/
                if ($row->mostrar === "SI") {
                    $total_materia++;
                    $suma_calificacion += $row->calificacion;
                    $tabla .= '<tr>';
                    $tabla .= '<td>' . $c++ . '</td>';
                    $tabla .= '<td>' . $row->nombreclase . '</td>';
                    $tabla .= '<td align="center">';
                    if ($row->calificacion != '') {
                        if ($detalle_configuracion[0]->calificacion_minima < $row->calificacion) {
                            $tabla .= '<label>' . $row->calificacion . '</label>';
                        } else {
                            $tabla .= '<label style="color:red;">' . $row->calificacion . '</label>';
                        }
                    } else {
                        $tabla .= '<label>0</label>';
                    }

                    $tabla .= '</td>';
                    $tabla .= '</tr>';
                }
            }
            if ($total_materia > 0 && $suma_calificacion > 0) {
                $promedio =  $suma_calificacion / $total_materia;
            }
            $tabla .= '
                <tr style="background-color:#ccc;" >
                    <td colspan="2" align="center"><strong><h5>PROMEDIO:</h5></strong></td>
                    <td align="center"><strong><h5>' . eliminarDecimalCero(numberFormatPrecision($promedio, 1, '.')) . '</h5></strong></td>
                </tr>
            ';
        }
        $tabla .= '</table></div>';
        return $tabla;
    }

    public function obtenerCalificacionPreescolar($idhorario = '', $idalumno = '', $idnivelestudio = '', $idperiodo = '')
    {
        Permission::grant(uri_string());

        // Obtener meses
        $meses = $this->alumno->obtenerMeses();
        $materias = $this->alumno->obtenerMaterias($idnivelestudio);

        $tabla = "";
        $tabla .= '<div class="table-responsive"> <table id="tblcalificacionpreescolar" class="table table-striped dt-responsive nowrap" cellspacing="0" width="100%">
        <thead class="bg-teal">
        <th>ASIGNATURA</th>';
        foreach ($meses as $mes) {
            $tabla .= '<th>' . $mes->nombremes . '</th>';
        }

        $tabla .= '</thead>
        <tbody>';
        foreach ($materias as $materia) {
            $idmateria = $materia->idmateriapreescolar;

            if ($idmateria != 1 && $idmateria != 10 && $idmateria != 19 && $idmateria != 21) {

                $tabla .= '<tr>';
                $tabla .= '<td>' . $materia->nombremateria . '</td>';

                foreach ($meses as $mes) {
                    $idmes = $mes->idmes;

                    if ($idmateria == 26) {
                        $faltas = $this->alumno->obtenerFaltasPreescolar($idperiodo, $idalumno, $idmes);

                        if ($faltas) {

                            $tabla .= '<td>' . $faltas->faltas . '</td>';
                        } else {
                            $tabla .= '<td></td>';
                        }
                    } else {
                        $calificacion = $this->alumno->obtenerCalificacionPreescolar($idperiodo, $idalumno, $idmateria, $idmes);

                        if ($calificacion) {

                            $tabla .= '<td>' . $calificacion->abreviatura . '</td>';
                        } else {
                            $tabla .= '<td></td>';
                        }
                    }
                }
                $tabla .= '</tr>';
            }
        }

        $tabla .= '
        </tbody>
        </table></div>';

        return $tabla;
    }

    public function obtenerCalificacion2($idhorario = '', $idalumno = '')
    {
        # code...
        Permission::grant(uri_string());
        $unidades = $this->grupo->unidades($this->session->idplantel);
        $array_materias_reprobadas = array();
        $materias_reprobadas = $this->alumno->obtenerTodasMateriaReprobadasActivas($idalumno);
        if (isset($materias_reprobadas) && !empty($materias_reprobadas)) {
            foreach ($materias_reprobadas as $row) {
                array_push($array_materias_reprobadas, $row->idmateriaprincipal);
            }
        }
        $reprobadas = implode(",", $array_materias_reprobadas);

        $materias = $this->alumno->showAllMaterias($idhorario, $reprobadas, $idalumno);
        $datoshorario = $this->horario->showNivelGrupo($idhorario);
        $idnivelestudio = $datoshorario->idnivelestudio;
        $idperiodo =  $datoshorario->idperiodo;
        $detalle_configuracion = $this->configuracion->showAllConfiguracion($this->session->idplantel, $idnivelestudio);
        $total_unidades = 0;
        $total_materia = 0;
        if ($materias != false) {
            foreach ($materias as $row) {
                # code...
                $total_materia = $total_materia + 1;
            }
        }
        $tabla = "";
        $tabla .= '<div class="table-responsive"> <table class="table  table-striped  table-hover">
        <thead class="bg-teal">
        <th>#</th>
        <th>MATERIA</th>';
        foreach ($unidades as $block) :
            $total_unidades += 1;
            $tabla .= '<th><strong>' . $block->nombreunidad . '</strong></th>';
        endforeach;
        $tabla .= '<th>PROMEDIO</th>';
        $tabla .= '</thead>';
        $c = 1;
        $mostrar = FALSE;
        if (isset($materias) && !empty($materias)) {
            $suma_calificacion = 0;
            $suma_unidad_concalificacion = 0;

            foreach ($materias as $row) {

                $suma_calificacion = 0;
                $idmateria = $row->idmateria;
                $suma_unidad_concalificacion = 0;
                $idhorariodetalle = $row->idhorariodetalle;
                $validar = $this->calificacion->verificarCalificacionSiSeMuestraXMateria($idalumno, $idhorario, $idmateria);
                $validar_quitar_materia = $this->alumno->validarQuitarMateria($idalumno, $idhorario, $idmateria);
                if (!$validar_quitar_materia) {
                    if ($idperiodo == 9) {
                        if ($validar) {
                            $suma_calificacion_verificar = 0;
                            foreach ($validar as $rowv) {
                                $suma_calificacion_verificar += $rowv->calificacion;
                            }
                            if ($suma_calificacion_verificar > 0) {
                                $mostrar = TRUE;
                            } else {
                                $mostrar = FALSE;
                            }
                        } else {
                            $mostrar = TRUE;
                        }
                    } else {
                        $mostrar = TRUE;
                    }
                } else {
                    $mostrar = false;
                }
                if ($mostrar) {
                    $tabla .= '<tr>
                <td>' . $c++ . '</td>
                <td>';
                    if ($row->opcion == 0) {
                        $tabla .= '<label style="color:red;">R: </label>';
                    }
                    $tabla .= '<strong>' . $row->nombreclase . '</strong><br><small>( ' . $row->nombre . ' ' . $row->apellidop . ' ' . $row->apellidom . '</small>)</td>';
                    foreach ($unidades as $block) :
                        $val = $this->grupo->obtenerCalificacionValidandoMateria($idalumno, $block->idunidad, $idhorario, $idmateria);

                        $tabla .= '<td>';
                        if ($val) {
                            $idcalificacion = $val->idcalificacion;
                            $detalle_calificacion = $this->grupo->detalleCalificacionSecundaria($idcalificacion);
                            $suma_calificacion = $suma_calificacion + $val->calificacion;
                            if (validar_calificacion($val->calificacion, $detalle_configuracion[0]->calificacion_minima)) {
                                if ($val->calificacion > 0) {
                                    $suma_unidad_concalificacion += 1;
                                    $tabla .= '<label style="color:red;">' . eliminarDecimalCero($val->calificacion) . '</label>';
                                } else {
                                    $suma_unidad_concalificacion += 1;
                                    $tabla .= '<label style="color:red;">' . eliminarDecimalCero($val->calificacion) . '</label>';
                                }
                            } else {
                                $suma_unidad_concalificacion += 1;
                                $tabla .= '<label style="color:#36ad36;">' . eliminarDecimalCero($val->calificacion) . '</label>';
                            }
                        } else {
                            $tabla .= '<small>No registrado</small>';
                        }
                        $tabla .= '</td>';
                    endforeach;
                    if ($suma_unidad_concalificacion == $total_unidades) {
                        $tabla .= '<td>';
                        $calificacion_final = eliminarDecimalCero($suma_calificacion / $total_unidades);
                        if (validar_calificacion($calificacion_final, $detalle_configuracion[0]->calificacion_minima)) {
                            if ($suma_calificacion > 0.0) {
                                $tabla .= '<label style="color:red;">' . eliminarDecimalCero($suma_calificacion / $total_unidades) . '</label>';
                            } else {
                                $tabla .= '<label "> </label>';
                            }
                        } else {
                            $tabla .= '<label style="color:green;">' . eliminarDecimalCero($suma_calificacion / $total_unidades) . '</label>';
                        }
                        $tabla .= '</td>';
                    } else {
                        $tabla .= '<td></td>';
                    }
                    $tabla .= '</tr>';
                }
            }
        }
        $tabla .= '</table></div>';
        return $tabla;
    }

    public function obtenerCalificacionLicenciatura($idhorario = '', $idalumno = '')
    {
        # code...
        Permission::grant(uri_string());
        $unidades = $this->grupo->unidades($this->session->idplantel);
        $array_materias_reprobadas = array();
        $materias_reprobadas = $this->alumno->obtenerTodasMateriaReprobadasActivas($idalumno);
        if (isset($materias_reprobadas) && !empty($materias_reprobadas)) {
            foreach ($materias_reprobadas as $row) {
                array_push($array_materias_reprobadas, $row->idmateriaprincipal);
            }
        }
        $reprobadas = implode(",", $array_materias_reprobadas);

        $materias = $this->alumno->showAllMaterias($idhorario, $reprobadas);
        $datoshorario = $this->horario->showNivelGrupo($idhorario);
        $idnivelestudio = $datoshorario->idnivelestudio;
        $unidades_trabajo_final = $this->grupo->unidadesCalificacionFinal($this->session->idplantel);
        $total_unidades_trabajo_final = count($unidades_trabajo_final);
        $detalle_configuracion = $this->configuracion->showAllConfiguracion($this->session->idplantel, $idnivelestudio);

        $total_materia = 0;
        if ($materias != false) {
            foreach ($materias as $row) {
                # code...
                $total_materia = $total_materia + 1;
            }
        }
        $tabla = "";
        $tabla .= '<div class="table-responsive"> <table class="table  table-striped  table-hover">
        <thead class="bg-teal">
        <th>#</th>
        <th>MATERIA</th>';
        foreach ($unidades as $block) :

            $tabla .= '<th ><strong>' . $block->nombreunidad . '</strong></th>';
        endforeach;
        $tabla .= '<th>P. UNIDADES</th>';
        if (isset($unidades_trabajo_final) && !empty($unidades_trabajo_final)) {
            foreach ($unidades_trabajo_final as $unidadtrabajo) :
                $tabla .= '<th>' . $unidadtrabajo->nombreunidad . '</th>';
            endforeach;
        }
        $tabla .= '<th>PROMEDIO</th>';
        $tabla .= '</thead>';
        $c = 1;

        if (isset($materias) && !empty($materias)) {
            $suma_calificacion = 0;

            foreach ($materias as $row) {
                $total_unidades = $row->unidades;
                $idmateria = $row->idmateria;
                $suma_calificacion = 0;
                $total_unidades_registradas = 0;
                $total_trabajo_final_registradas = 0;
                $suma_calificacion_trabajo_final = 0;
                $total_unidades_recorridas = 0;
                $promedio = 0;
                $promedio_unidades = 0;
                $promedio_trabajo_final = 0;
                $tabla .= '<tr>
                <td>' . $c++ . '</td>
                <td>';
                if ($row->opcion == 0) {
                    $tabla .= '<label style="color:red;">R: </label>';
                }
                $tabla .= '<strong>' . $row->nombreclase . '</strong><br><small>( ' . $row->nombre . ' ' . $row->apellidop . ' ' . $row->apellidom . '</small>)</td>';
                foreach ($unidades as $block) {
                    $total_unidades_recorridas += 1;
                    if ($total_unidades_recorridas <= $total_unidades) {

                        $val = $this->grupo->obtenerCalificacionValidandoMateria($idalumno, $block->idunidad, $idhorario, $idmateria);

                        $tabla .= '<td>';
                        if ($val) {
                            $total_unidades_registradas += 1;

                            $suma_calificacion = $suma_calificacion + round($val->calificacion, 0);
                            if (validar_calificacion($val->calificacion, $detalle_configuracion[0]->calificacion_minima)) {
                                $tabla .= '<label style="color:red;">' . round($val->calificacion, 0) . '</label>';
                            } else {
                                $tabla .= '<label style="color:green;">' .  round($val->calificacion, 0) . '</label>';
                            }
                        } else {
                            $tabla .= '<small>No registrado</small>';
                        }
                        $tabla .= '</td>';
                    } else {
                        $tabla .= '<td>-</td>';
                    }
                }
                if ((isset($total_unidades) && !empty($total_unidades) && $total_unidades >  0)
                    && (isset($suma_calificacion) && !empty($suma_calificacion) && $suma_calificacion > 0)
                ) {

                    $promedio_unidades  =  numberFormatPrecision($suma_calificacion / $total_unidades, 1, '.');
                }
                if ($total_unidades_registradas == $total_unidades) {
                    $tabla .= '<td><label>' . eliminarDecimalCero($promedio_unidades) . '</label></td>';
                } else {
                    $tabla .= '<td>-</td>';
                }
                if (isset($unidades_trabajo_final) && !empty($unidades_trabajo_final)) {
                    foreach ($unidades_trabajo_final as $block) :

                        $val = $this->grupo->obtenerCalificacionValidandoMateria($idalumno, $block->idunidad, $idhorario, $idmateria);

                        $tabla .= '<td>';
                        if ($val) {
                            $total_trabajo_final_registradas += 1;
                            $suma_calificacion_trabajo_final = $suma_calificacion_trabajo_final + round($val->calificacion, 0);

                            if (validar_calificacion($val->calificacion, $detalle_configuracion[0]->calificacion_minima)) {
                                $tabla .= '<label style="color:red;">' . round($val->calificacion, 0) . '</label>';
                            } else {
                                $tabla .= '<label style="color:green;">' . round($val->calificacion, 0) . '</label>';
                            }
                        } else {
                            $tabla .= '<small>No registrado</small>';
                        }
                        $tabla .= '</td>';
                        $tabla .= '</td>';
                    endforeach;
                }

                $tabla .= '<td>';
                if ((isset($total_unidades) && !empty($total_unidades) && $total_unidades >  0)
                    && (isset($suma_calificacion) && !empty($suma_calificacion) && $suma_calificacion > 0)
                ) {

                    $promedio_unidades  =  numberFormatPrecision($suma_calificacion / $total_unidades, 1, '.');
                }
                if ((isset($total_unidades_trabajo_final) && !empty($total_unidades_trabajo_final) && $total_unidades_trabajo_final > 0)
                    && (isset($suma_calificacion_trabajo_final) && !empty($suma_calificacion_trabajo_final) && $suma_calificacion_trabajo_final > 0)
                ) {
                    $promedio_trabajo_final =  numberFormatPrecision($suma_calificacion_trabajo_final / $total_unidades_trabajo_final, 1, '.');
                }
                if (($total_unidades_registradas == $total_unidades) && ($total_unidades_trabajo_final == $total_trabajo_final_registradas)) {
                    $promedio = round(($promedio_unidades + $promedio_trabajo_final) / 2, 0);
                }

                if ($promedio > 0) {
                    //  $calificacion_final = numberFormatPrecision($suma_calificacion / $total_unidades, 1, '.');
                    if (validar_calificacion($promedio, $detalle_configuracion[0]->calificacion_minima)) {
                        if ($suma_calificacion > 0.0) {
                            $tabla .= '<label style="color:red;">' . $promedio . '</label>';
                        } else {
                            $tabla .= '<label "> </label>';
                        }
                    } else {
                        $tabla .= '<label style="color:green;">' . $promedio . '</label>';
                    }
                } else {
                    $tabla .= '<label></label>';
                }
                $tabla .= '</tr>';
            }
        }
        $tabla .= '</table></div>';
        return $tabla;
    }

    public function obtenerCalificacionPrimaria($idhorario = '', $idalumno = '')
    {
        # code...
        Permission::grant(uri_string());
        // $idplantel = $this->session->idplantel;
        $datoshorario = $this->horario->showNivelGrupo($idhorario);
        $idnivelestudio = $datoshorario->idnivelestudio;
        $idperiodo = $datoshorario->idperiodo;
        //$materias = $this->alumno->obtenerMateriasHorario($idalumno, $idhorario);
        $detalle_configuracion = $this->configuracion->showAllConfiguracion($this->session->idplantel, $idnivelestudio);
        //$calificaciones = $this->alumno->calificacionFinalPrimaria($idalumno, $idhorario, $idplantel);
        $calificaciones = $this->alumno->spObtenerCalificacion($idalumno, $idhorario, $idperiodo);
        $tabla = "";
        $tabla .= '<div class="table-responsive"> <table class="table  table-striped  table-hover">
        <thead class="bg-teal">
         <th>#</th>
        <th>MATERIA</th>';
        $tabla .= '<th  ><center>CALIFICACIÓN</center></th>';
        $tabla .= '</thead>';
        $c = 1;
        $total_materia = 0;
        $suma_calificacion = 0;
        if (isset($calificaciones) && !empty($calificaciones)) {
            foreach ($calificaciones as $calificacion) {
                //$idprofesormateria = $materia->idprofesormateria;
                if ($calificacion->mostrar === "SI") {
                    $total_materia++;
                    $suma_calificacion += $calificacion->calificacion;
                    $tabla .= '<tr>';
                    $tabla .= '<td>' . $c++ . '</td>';
                    $tabla .= '<td>' . $calificacion->nombreclase . '</td>';
                    ///OBTENER CALIFICACION POR MATERIA
                    /*$calificacion = $this->alumno->obtenerCalificacionPorMateriaPrimaria($idhorario, $idprofesormateria, $idalumno);
                if (isset($calificacion) && !empty($calificacion)) {*/
                    if ($calificacion->calificacion < $detalle_configuracion[0]->calificacion_minima) {
                        $tabla .= '<td align="center" ><strong>' . eliminarDecimalCero(numberFormatPrecision($calificacion->calificacion, 1, '.')) . '</strong></td>';
                    } else {
                        $tabla .= '<td align="center">' . eliminarDecimalCero(numberFormatPrecision($calificacion->calificacion, 1, '.')) . '</td>';
                    }
                    /* } else {
                    $tabla .= '<td><strong>NA</strong></td>';
                }*/

                    $tabla .= '</tr>';
                }
            }
            $promedio = 0;
            if ($total_materia > 0 && $suma_calificacion > 0) {
                $promedio =  $suma_calificacion / $total_materia;
            }
            $tabla .= '
                <tr>
                    <td colspan="2" align="right"><strong><h5>PROMEDIO</h5></strong></td>
                    <td align="center"><strong><h5>' . eliminarDecimalCero(numberFormatPrecision($promedio, 1, '.')) . '</h5></strong></td>
                </tr>
            ';
        }

        $tabla .= '</table></div>';
        return $tabla;
    }

    public function imprimirkardex($idhorario = '', $idalumno = '')
    {
        Permission::grant(uri_string());
        $idhorario = $this->decode($idhorario);
        $idalumno = $this->decode($idalumno);
        if ((isset($idhorario) && !empty($idhorario)) && (isset($idalumno) && !empty($idalumno))) {
            $alumno = $this->alumno->detalleAlumno($idalumno);
            $grupop = $this->horario->showNivelGrupo($idhorario);
            $unidades = $this->grupo->unidades($this->session->idplantel);
            // $materias = $this->alumno->showAllMaterias($idhorario);
            $detalle_logo = $this->alumno->logo($this->session->idplantel);
            $logo = base_url() . '/assets/images/escuelas/' . $detalle_logo[0]->logoplantel;
            $logo2 = base_url() . '/assets/images/escuelas/' . $detalle_logo[0]->logosegundo;
            $total_unidades = 0;
            $calificacion = "";
            $materias = $this->alumno->showAllMaterias($idhorario);
            $total_materia = 0;
            if ($materias != false) {
                foreach ($materias as $row) {
                    # code...
                    $total_materia = $total_materia + 1;
                }
            }
            if ($unidades != false) {
                foreach ($unidades as $row) {
                    # code...
                    $total_unidades = $total_unidades + 1;
                }
            }
            $datoscalifiacacion = $this->horario->calificacionGeneralAlumno($idhorario, $idalumno);
            if ($datoscalifiacacion != false && $total_materia > 0) {
                $calificacion = ($datoscalifiacacion->calificaciongeneral / $total_unidades) / $total_materia;
            }

            $this->load->library('tcpdf');
            $hora = date("h:i:s a");
            // $linkimge = base_url() . '/assets/images/woorilogo.png';

            $datelle_alumno = $this->alumno->showAllMateriasAlumno($idalumno, 1);
            $fechaactual = date('d/m/Y');
            $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
            $pdf->SetTitle('kardex de Calificaciones.');
            $pdf->SetHeaderMargin(30);
            $pdf->SetTopMargin(10);
            $pdf->setFooterMargin(20);
            $pdf->SetAutoPageBreak(true);
            $pdf->SetAuthor('Sistema Integral para el Control Escolar');
            $pdf->SetDisplayMode('real', 'default');
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);

            $pdf->AddPage();

            $tbl = '
<style type="text/css">
.titulodias{font-size:9px; font-weight:bold;}
.cajon{
    font-size:9px;
    font-weight:bold;
    border-bottom:solid 1px black;
    border-left:solid 1px black;
     border-right:solid 1px black;
      padding:900px 20px 20px 20px;
}
 .txtn{
        font-size:6px;
    }
    .direccion{
        font-size:6px;
    }
.escuela{
      font-size:12px;
    font-weight:bold;
}
.horario{
      font-size:10px;
    font-weight:bold;
}
.titulo{
      font-size:8px;
    font-weight:bold;
}
.result{
      font-size:8px;
    font-weight:bold;
}
    .nombreplantel{
        font-size:11px;
        font-weight:bolder;
    }
    .telefono{
          font-size:6px;
    }
 .imgtitle{
        width:60px;

    }
    .promedio{
           font-size:10px;
    }
.tblcalificacion  td
                {
                    border:0px  solid black;
                }
tblcalificacion  {border-collapse:collapse}
.titulocal{
     font-family:Verdana, Geneva, sans-serif;
     font-weight:bolder;
     font-size:8px;
     background-color:#ccc;
}
.subtitulocal{
     font-family:Verdana, Geneva, sans-serif;
     font-size:7px;
}
.imgprincipal{
  width:90px;
}
</style>
 <table width="580" border="0" cellpadding="0" cellspacing="4">
   <tr>
    <td width="101" align="left"><img   class="imgtitle" src="' . $logo2 . '" /></td>
    <td colspan="2" align="center">
            <label class="nombreplantel">' . $detalle_logo[0]->nombreplantel . '</label><br>
            <label class="txtn">' . $detalle_logo[0]->asociado . '</label><br>
            <label class="direccion">' . $detalle_logo[0]->direccion . '</label><br>
            <label class="telefono">TELÉFONO: ' . $detalle_logo[0]->telefono . '</label>
    </td>
    <td width="137"  align="right" valing="top"><img   class="imgprincipal" src="' . $logo . '" /></td>
  </tr>

  <tr>
    <td colspan="4" align="center"><label class="horario">KARDEX ESCOLAR</label></td>
    </tr>
   <tr>
    <td align="center"  style="border-bottom:solid 1px #000000;"><label class="titulo">Matricula</label></td>
    <td align="center"  style="border-bottom:solid 1px #000000;"><label class="titulo">Alumno(a)</label></td>
    <td align="center"  style="border-bottom:solid 1px #000000;"><label class="titulo">Nivel Escolar</label></td>
    <td align="center"  style="border-bottom:solid 1px #000000;"><label class="titulo">Periodo Escolar</label></td>
  </tr>
  <tr>
    <td align="center"><label class="result">' . $alumno->matricula . '</label></td>
    <td align="center"><label class="result">' . $alumno->nombre . ' ' . $alumno->apellidop . ' ' . $alumno->apellidom . '</label></td>
    <td align="center"><label class="result">' . $grupop->nombrenivel . ' ' . $grupop->nombregrupo . '</label></td>
    <td align="center"><label class="result">' . $grupop->mesinicio . ' - ' . $grupop->mesfin . ' ' . $grupop->yearfin . '</label></td>
  </tr>
</table>
<br><br>
 ';
            $tbl .= '<table width="100" class="tblcalificacion" cellpadding="2"  >
      <tr>
      <td width="30" class="titulocal">#</td>
      <td width="180" class="titulocal">MATERIA</td>';
            foreach ($unidades as $block) :
                $tbl .= '<td class="titulocal">' . $block->nombreunidad . '</td>';
            endforeach;

            $tbl .= '</tr>';
            $c = 1;
            foreach ($materias as $row) {
                // $alumn = $al->getAlumn();
                $idmateria = $row->idmateria;
                $tbl .= '<tr>
        <td width="30" class="subtitulocal">' . $c++ . '</td>
        <td width="180" class="subtitulocal">' . $row->nombreclase . '</td>';
                foreach ($unidades as $block) :
                    $val = $this->grupo->obtenerCalificacionValidandoMateria($idalumno, $block->idunidad, $idhorario, $idmateria);
                    // var_dump($val);
                    $tbl .= '<td class="subtitulocal">';
                    if ($val != false) {
                        $tbl .= '<label>' . $val->calificacion . '</label>';
                    } else {
                        $tbl .= '<label>No registrado</label>';
                    }
                    $tbl .= '</td>';
                endforeach;

                $tbl .= '</tr>';
            }
            $tbl .= '</table>';
            $tbl .= '
<br><br>
      <table border="0" width="531">
        <tr>
            <td align="right" class="promedio" >
                Promedio: <strong>';
            if (isset($calificacion) && !empty($calificacion)) {
                $tbl .= numberFormatPrecision($calificacion, 1, '.');
            } else {
                $tbl .= '<label>0.0</label>';
            }

            $tbl .= '</strong>
            </td>
        </tr>
      </table>
      ';

            $pdf->writeHTML($tbl, true, false, false, false, '');

            ob_end_clean();

            $pdf->Output('Kardex de Calificaciones', 'I');
        } else {
            $data = array(
                'heading' => 'Error',
                'message' => 'Error intente mas tarde.'
            );
            $this->load->view('errors/html/error_general', $data);
        }
    }

    public function actual()
    {
        $idalumno = $this->session->idalumno;
        $idhorario = "";
        $grupo = $this->alumno->obtenerGrupo($idalumno);
        if ($grupo != false) {
            $idhorario = $grupo->idhorario;
        }

        if ($idhorario != "") {

            $idalumno = $this->session->idalumno;
            $calificacion = "";

            $datosalumno = $this->alumno->showAllAlumnoId($idalumno);
            $datoshorario = $this->horario->showNivelGrupo($idhorario);

            $array_materias_reprobadas = array();
            $materias_reprobadas = $this->alumno->obtenerTodasMateriaReprobadasActivas($idalumno);
            if (isset($materias_reprobadas) && !empty($materias_reprobadas)) {
                foreach ($materias_reprobadas as $row) {
                    array_push($array_materias_reprobadas, $row->idmateriaprincipal);
                }
            }
            $reprobadas = implode(",", $array_materias_reprobadas);

            $materias = $this->alumno->showAllMaterias($idhorario, $reprobadas);
            $unidades = $this->grupo->unidades($this->session->idplantel);
            $idnivelestudio = $datoshorario->idnivelestudio;
            $idniveleducativo = $datoshorario->idniveleducativo;
            $detalle_configuracion = $this->configuracion->showAllConfiguracion($this->session->idplantel, $idnivelestudio);
            $idperiodo = $datoshorario->idperiodo;
            $alumno_grupo = $this->grupo->detalleAlumnoGrupo($idalumno, $idperiodo);
            $total_unidades = 0;
            $total_materia = 0;

            //
            if ($this->session->idniveleducativo == 5) {
                $tabla = $this->obtenerCalificacionLicenciatura($idhorario, $idalumno);
            } elseif ($this->session->idniveleducativo == 4) {
                $tabla = $this->obtenerCalificacionPreescolar($idhorario, $idalumno, $idnivelestudio, $idperiodo);
            } elseif ($this->session->idniveleducativo == 1 || $this->session->idniveleducativo == 2) {
                $tabla = $this->obtenerCalificacionSecuNew($idhorario, $idalumno);
            } else {
                $tabla = $this->obtenerCalificacion2($idhorario, $idalumno);
            }


            $data = array(
                'idhorario' => $idhorario,
                'idalumno' => $idalumno,
                'tabla' => $tabla,
                'datosalumno' => $datosalumno,
                'datoshorario' => $datoshorario,
                'calificacion' => $calificacion,
                'controller' => $this,
                //'estatus_nivel' => $estatus_alumno,
                'oportunidades' => $this->grupo->showAllOportunidades($this->session->idplantel),
                'nivel_educativo' => $idniveleducativo,
                //'mostrar_estatus' => $mostrar_estatus
                // 'detalle_siguiente_oportunidad'=>$detalle_siguiente_oportunidad
            );
            $this->load->view('alumno/header');
            if ($this->session->idniveleducativo == 4) {
                $this->load->view('alumno/preescolar/actual', $data);
            } else {
                $this->load->view('alumno/kardex/calificacion', $data);
            }
            $this->load->view('alumno/footer');
        } else {
            $data = array(
                'idhorario' => $idhorario
            );
            $this->load->view('alumno/header');
            $this->load->view('alumno/kardex/calificacion', $data);
            $this->load->view('alumno/footer');
        }
    }

    public function obtenerCalificacionSecuNew($idhorario, $idalumno)
    {
        $unidades = $this->grupo->unidades($this->session->idplantel);
        $array_materias_reprobadas = array();
        $materias_reprobadas = $this->alumno->obtenerTodasMateriaReprobadasActivas($idalumno);
        if (isset($materias_reprobadas) && !empty($materias_reprobadas)) {
            foreach ($materias_reprobadas as $row) {
                array_push($array_materias_reprobadas, $row->idmateriaprincipal);
            }
        }
        $reprobadas = implode(",", $array_materias_reprobadas);

        $materias = $this->alumno->showAllMaterias($idhorario, $reprobadas, $idalumno);
        $datoshorario = $this->horario->showNivelGrupo($idhorario);
        $idnivelestudio = $datoshorario->idnivelestudio;
        $unidades_reales = $this->grupo->unidadesConCalificaciones($this->session->idplantel, $idhorario);

        $detalle_configuracion = $this->configuracion->showAllConfiguracion($this->session->idplantel, $idnivelestudio);
        $total_unidades = count($unidades);
        $total_unidades_registradas = 0;
        $total_meses = 0;
        $total_materia = 0;
        $total_cols = 0;
        if ($materias) {
            foreach ($materias as $row) {

                $total_materia = $total_materia + 1;
            }
        }
        $idhorarioe = $this->encode($idhorario);
        $idalumnoe = $this->encode($idalumno);
        $tabla = "";
        $tabla .= '
        <div class="row">
             <div class="col-md-12 col-sm-12 col-xs-12 ">
             <a target="_blank" class="btn  btn-default" href="' . base_url() . '/Aalumno/imprimirBoleta/' . $idhorarioe . '/' . $idalumnoe . '"><i class="fa fa-cloud-download"></i> Descargar Boleta</a>
             </div>
        </div>
        <div class="table-responsive"> 
<table class="table  table-striped  table-hover" style="width:100%;" id="datatablebodega">
        <thead  >
        <th>#</th>
        <th>MATERIA</th>';
        if ($unidades_reales) {
            foreach ($unidades_reales as $block) :
                $idunidad = $block->idunidad;
                $meses_reales = $this->grupo->mesesPorUnidad($idhorario, $idunidad);

                if ($meses_reales) {
                    foreach ($meses_reales as $row) {
                        $total_meses += 1;
                        $total_cols += 1;
                        $tabla .= '<th><strong>' . $row->nombremes . '</strong></th>';
                    }
                    $total_unidades_registradas++;
                }
                $total_cols += 1;
                $tabla .= '<th><strong>' . $block->nombreunidad . '</strong></th>';
            endforeach;
        }
        if ($total_unidades == $total_unidades_registradas) {
            $tabla .= '<th>PROMEDIO</th>';
            $total_cols += 1;
        }
        $tabla .= '</thead>';
        $c = 1;

        if (isset($materias) && !empty($materias)) {
            $suma_calificacion = 0;
            $suma_calificacion_verificar = 0;
            $mostrar = false;
            foreach ($materias as $row) {

                $suma_calificacion = 0;
                $idmateria = $row->idmateria;
                $validar = $this->calificacion->verificarCalificacionSiSeMuestraXMateria($idalumno, $idhorario, $idmateria);
                if ($validar) {
                    $suma_calificacion_verificar = 0;
                    foreach ($validar as $rowv) {
                        $suma_calificacion_verificar += $rowv->calificacion;
                    }
                    if ($suma_calificacion_verificar > 0) {
                        $mostrar = TRUE;
                    } else {
                        $mostrar = FALSE;
                    }
                } else {
                    $mostrar = TRUE;
                }
                if ($mostrar) {
                    $tabla .= '<tr>
                <td>' . $c++ . '</td>
                <td>';
                    if ($row->opcion == 0) {
                        $tabla .= '<label style="color:red;">R: </label>';
                    }
                    $tabla .= '<strong>' . $row->nombreclase . '</strong><br><small>( ' . $row->nombre . ' ' . $row->apellidop . ' ' . $row->apellidom . '</small>)</td>';
                    if ($unidades_reales) {
                        $suma_calificacion_mes = 0;
                        $contador_meses = 0;
                        foreach ($unidades_reales as $block) :
                            $idunidad = $block->idunidad;
                            $meses_reales = $this->grupo->mesesPorUnidad($idhorario, $idunidad);

                            if ($meses_reales) {
                                $suma_calificacion_mes = 0;
                                $contador_meses = 0;
                                foreach ($meses_reales as $rowmes) {
                                    $val = $this->grupo->obtenerCalificacionValidandoMateria($idalumno, $block->idunidad, $idhorario, $idmateria);
                                    if ($val) {
                                        $idmes = $rowmes->idmes;
                                        $idcalificacion = $val->idcalificacion;
                                        $calificacion_mes = $this->grupo->obtenerCalificacionXMeses($idcalificacion, $idmes);
                                        if ($calificacion_mes) {
                                            $suma_calificacion_mes = $suma_calificacion_mes + $calificacion_mes->calificacion;
                                            $contador_meses++;
                                            $tabla .= '<td align="center"><strong><center>' . numberFormatPrecision($calificacion_mes->calificacion, 1, '.') . '</center></strong></td>';
                                        } else {
                                            $tabla .= '<td><small>No registrado</small></td>';
                                        }
                                    } else {
                                        $tabla .= '<td  ></td>';
                                    }
                                }
                            }

                            if ($contador_meses > 0 && $suma_calificacion_mes > 0) {

                                $calificacion_trimestral = number_format($suma_calificacion_mes / $contador_meses, 2);
                                $suma_calificacion = $suma_calificacion + $calificacion_trimestral;
                                $tabla .= '<td align="center"><strong><center>' . numberFormatPrecision($calificacion_trimestral, 1, '.') . '</center></strong></td>';
                            } else {
                                $tabla .= '<td> </td>';
                            }
                        endforeach;
                    }
                    if ($total_unidades == $total_unidades_registradas) {
                        if ($suma_calificacion > 0 && $total_unidades > 0) {
                            $promedio = $suma_calificacion / $total_unidades;
                            $tabla .= '<td align="center"><strong>' . numberFormatPrecision($promedio, 1, '.') . '</strong></td>';
                        } else {
                            $tabla .= '<td></td>';
                        }
                    }
                    $tabla .= '</tr>';
                }
            }
        }
        $tabla .= '</table></div>';
        return $tabla;
    }

    public function test()
    {
        # code...
        echo $dato = $_SERVER['DOCUMENT_ROOT'] . '/sice/application/view/alumno/calificacion/';
        // '../../assets/images/escuelas/' . 'secundario_licenciatura.png';
        echo '<img src="' . $dato . '" width="150" height="90" />';
    }

    public function imprimirBoleta($idhorario, $idalumno)
    {
        $idhorario = $this->decode($idhorario);
        $idalumno = $this->decode($idalumno);
        if ((isset($idhorario) && !empty($idhorario)) && (isset($idalumno) && !empty($idalumno))) {
            // $this->load->library('tcpdf');

            $detalle_logo = $this->alumno->logo($this->session->idplantel);
            $alumno = $this->alumno->detalleAlumno($idalumno);
            $ubicacion_imagen = '../../assets/images/escuelas/';
            $logo = base_url() . '/assets/images/escuelas/principal_licenciatura.png';
            $logo2 = base_url() . '/assets/images/escuelas/secundario_licenciatura.png';
            $dato = $_SERVER['DOCUMENT_ROOT'] . '/sice/assets/images/escuelas/' . 'secundario_licenciatura.png';
            $septiembre = base_url() . '/assets/images/meses/septiembre.png';
            $octubre = base_url() . '/assets/images/meses/octubre.png';
            $noviembre = base_url() . '/assets/images/meses/noviembre.png';
            $promedio = base_url() . '/assets/images/meses/promedio.png';
            $promediofinal = base_url() . '/assets/images/meses/promediofinal.png';
            $diciembre = base_url() . '/assets/images/meses/diciembre.png';
            $enero = base_url() . '/assets/images/meses/enero.png';
            $febrero = base_url() . '/assets/images/meses/febrero.png';
            $marzo = base_url() . '/assets/images/meses/marzo.png';
            $abril = base_url() . '/assets/images/meses/abril.png';
            $mayo = base_url() . '/assets/images/meses/mayo.png';
            $junio = base_url() . '/assets/images/meses/junio.png';
            $detalle_cicloescolar = $this->cicloescolar->detalleCicloEscolarHorario($idhorario);
            $detalle_grupo = $this->cicloescolar->detalleGrupo($idhorario);

            $array_materias_reprobadas = array();
            $materias_reprobadas = $this->alumno->obtenerTodasMateriaReprobadasActivas($idalumno);
            if (isset($materias_reprobadas) && !empty($materias_reprobadas)) {
                foreach ($materias_reprobadas as $row) {
                    array_push($array_materias_reprobadas, $row->idmateriaprincipal);
                }
            }
            $reprobadas = implode(",", $array_materias_reprobadas);

            $materias = $this->alumno->showAllMaterias($idhorario, $reprobadas, $idalumno);

            $data = array(
                'detalle_logo' => $this->alumno->logo($this->session->idplantel),
                'alumno' => $this->alumno->detalleAlumno($idalumno),
                'detalle_cicloescolar' => $this->cicloescolar->detalleCicloEscolarHorario($idhorario),
                'detalle_grupo' => $this->cicloescolar->detalleGrupo($idhorario),
                'materias' => $materias,
                'idalumno' => $idalumno,
                'idhorario' => $idhorario
            );
            // $html = $this->load->view('alumno/calificacion/boletapdf', $data, true);
            // $html = $this->output->get_output();

            // echo '<img src="../../../assets/images/escuelas/secundario_licenciatura.png" width="150" height="70" />';

            /*
             * $options = new Options();
             * $options->set('isRemoteEnabled',true);
             * $dompdf = new Dompdf($options);
             * $contxt = stream_context_create([
             * 'ssl'=>[
             * 'verify_peer'=>FALSE,
             * 'verify_peer_name'=>FALSE,
             * 'allow_self_siged'=>TRUE
             * ]
             * ]);
             * $dompdf->setHttpContext($contxt);
             */
            $this->load->library('tcpdf');
            $hora = date("h:i:s a");
            $fechaactual = date('d/m/Y');
            $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
            $pdf->SetTitle('Boleta de Evaluación.');
            $pdf->SetHeaderMargin(20);
            $pdf->SetTopMargin(10);
            $pdf->setFooterMargin(20);
            $pdf->SetAutoPageBreak(true);
            $pdf->SetAuthor('Author');
            $pdf->SetDisplayMode('real', 'default');
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);

            $pdf->SetMargins(10, 10, 10);
            $pdf->SetHeaderMargin(15);
            $pdf->SetFooterMargin(15);

            // set auto page breaks
            $pdf->SetAutoPageBreak(TRUE, 15);
            $pdf->AddPage();
            $tabla = '
             <style>
             .txtn {
                font-size: 12px;
                color: #3dae57;
                font-family: sans-serif;
            }
                      
            .clave {
                font-size: 9px;
                color: #000;
                font-family: sans-serif;
            }
            .cicloescolar {
                font-size: 8px;
                color: #000000;
                font-weight:bold;
                font-family: sans-serif;
            }
                      
            .slogan {
                font-size: 9px;
                font-family: sans-serif;
                font-weight:bold;
            }
                      
            .nombreplantel {
                font-size: 11px;
                font-weight: bold;
                color: #1f497d;
                font-family: sans-serif;
            }
                      
            .tipoplantel {
                font-size: 10px;
                padding: 0px;
                margin: 0px;
                color: #365f91;
                font-family: sans-serif;
            }
                      
            .titulo {
                font-size: 7px;
                text-align: center;
                font-family: sans-serif;
                font-weight:bold;
            }
            .cuerpo{
              font-size: 7px;
              text-align: left;
              font-family: sans-serif;
            }
                      
            .secondtxt {
                font-size: 5px;
                font-family: sans-serif;
                vertical-align:middle;
            }
            .thirdtxt {
                font-size: 6px;
                font-family: sans-serif;
            }
                      
            .bg-prom {
                background-color: #ccc;
            }
          
              .tituloalumno{
               font-size: 7px;
                font-family: sans-serif;
                      
          }
         
          .meses{
            font-size: 10px;
            font-family: sans-serif;
          
          }
          .trimestre{
            font-size: 9px;
            font-family: sans-serif;
            font-weight:bolder;
            text-align:center;
          }
         .tblcalificacion td{
              border-collapse:collapse;
              border:solid black 1px;
          }
          tr:nth-of-type(5) td:nth-of-type(1){
              visible:hidden;
          }

          .rotate{
        
           white-space:nowrap;
           width:2.0em;
           font-size: 9px;
           font-family: sans-serif;
          }
          .rotate div{
            -moz-transform:rotate(-90.0deg);
            -o-transform:rotate(-90.0deg);
            -webkit-transform:rotate(-90.0deg);
            filter:prodig:DXImageTransform.Microsoft.BasicImage(rotation=0.83);
            transform:rotate(-90.0deg);
            margin-left:-10em;
            margin-right:-10em;
            margin-top:-8em;
          }
          .rotatepromediofinal{
            white-space:nowrap;
            width:2.0em;
            font-size: 9px;
            font-weight:bolder;
            font-family: sans-serif;
          }
          .rotatepromediofinal div{
            -moz-transform:rotate(-90.0deg);
            -o-transform:rotate(-90.0deg);
            -webkit-transform:rotate(-90.0deg);
            filter:prodig:DXImageTransform.Microsoft.BasicImage(rotation=0.83);
            transform:rotate(-90.0deg);
            margin-left:-10em;
            margin-right:-10em;
            margin-top:-7.5em;
          }
          .calificacion{
            font-size: 8px;
            font-weight:bolder;
            font-family: sans-serif;
          }
          .nombreclase{
            font-size: 8px;
            font-weight:bolder;
            font-family: sans-serif;
          }
          .asignatura{
            font-size: 10px;
            font-weight:bolder;
            font-family: sans-serif;
            text-align:center;
          }
          .boleta{
            font-size: 11px;
            font-weight:bolder;
            font-family: sans-serif;
            text-align:center;
          }
          .alumno{
            font-size: 8px;
            font-weight:bolder;
            font-family: sans-serif; 
          }.grado{
            font-size: 9px;
            font-weight:bolder;
            font-family: sans-serif; 
          }
          .director{
            font-size: 9px;
            font-weight:bolder;
            font-family: sans-serif; 
          }
          .img{
              width:30px;
          }

             </style>
          
             <table  border="0" cellpadding="2"  cellspacing="0">
             <tr>
             <td width="120" align="center">
             <img src="' . $logo . '" width="150" height="90" />
             </td>
             <td colspan="2" width="300" align="center">
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
             <td align="center" colspan="4" ></td>
             </tr> 
             <tr>
             <td  colspan="2" class="alumno">NOMBRE DEL ALUMNO: ' . $alumno->apellidop . ' ' . $alumno->apellidom . ' ' . $alumno->nombre . '</td>
             <td  colspan="2" class="grado" align="right">' . $detalle_grupo->primaria . ' ' . $detalle_grupo->nombregrupo . '</td>
             </tr>
             <tr>
             <td align="center" colspan="4" ></td>
             </tr> 
             </table>';
            $tabla .= ' 
            <table class="tblcalificacion"  style="margin-top:300px;" cellpadding="2" cellspacing="0">
            <tr>
              <td width="260" rowspan="2" class="asignatura">ASIGNATURA AREAS</td>
              <td colspan="4"   width="80"    class="trimestre">1° TRIMESTRE</td>
              <td colspan="5"   width="100"  class="trimestre">2° TRIMESTRE</td>
              <td colspan="4"   width="80" class="trimestre">3° TRIMESTRE</td>
              <td rowspan="2" width="20"    style="margin-left:1000px;" ><img  src="' . $promediofinal . '"   height="70" /></td>
            </tr>
            <tr  >
              <td height="20" class="rotate" width="20"  > <img src="' . $septiembre . '"   height="50" /></td>
              <td height="20" class="rotate" width="20"   ><img src="' . $octubre . '"   height="50" /></td>
              <td height="20" class="rotate" width="20"   ><img src="' . $noviembre . '"   height="50" /></td>
              <td height="20" class="rotate" width="20"   ><img src="' . $promedio . '"   height="50" /></td>
              <td height="20" class="rotate" width="20"   ><img src="' . $diciembre . '"   height="50" /></td>
              <td height="20" class="rotate" width="20"   ><img src="' . $enero . '"   height="50" /></td>
              <td height="20" class="rotate" width="20"   ><img src="' . $febrero . '"   height="50" /></td>
              <td height="20" class="rotate" width="20"   ><img src="' . $marzo . '"   height="50" /></td>
              <td height="20" class="rotate" width="20"   ><img src="' . $promedio . '"   height="50" /></td>
              <td height="20" class="rotate"   width="20" ><img src="' . $abril . '"   height="50" /></td>
              <td height="20" class="rotate"  width="20"  ><img src="' . $mayo . '"   height="50" /></td>
              <td height="20" class="rotate"  width="20"  ><img src="' . $junio . '"   height="50" /></td>
              <td height="20" class="rotate"  width="20"  ><img src="' . $promedio . '"   height="50" /></td>
            </tr>';
            $primer_trimestre = $this->cicloescolar->showAllPrimerTrimestre();
            $total_primer_trimeste = count($primer_trimestre);

            $segundo_trimestre = $this->cicloescolar->showAllSegundoTrimestre();
            $total_segundo_trimeste = count($segundo_trimestre);

            $tercer_trimestre = $this->cicloescolar->showAllTercerTrimestre();
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
                        $suma_primer_trimestre += $calificacion->calificacion;
                        $tabla .= '<td class="calificacion" align="center"  height="2">' . eliminarDecimalCero($calificacion->calificacion) . '</td>';
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
                        $suma_segundo_trimestre += $calificacion->calificacion;

                        $tabla .= '<td class="calificacion" align="center"  height="2">' . eliminarDecimalCero($calificacion->calificacion) . '</td>';
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
                        $suma_tercer_trimestre += $calificacion->calificacion;
                        $tabla .= '<td class="calificacion" align="center"  height="2">' . eliminarDecimalCero($calificacion->calificacion) . '</td>';
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
                $tabla .= '     
                       
                        <td class="calificacion" align="center"  width="20"   height="2">' . eliminarDecimalCero(numberFormatPrecision($promedio_final, 1, '.')) . '</td>
                </tr>';
            }
            $tabla .= '</table>';
            $tabla .= ' <br/><br/><br/>
                <table width="430"  border="0">
                <tr>
                        <td colspan="5" align="center" class="director" width="200">PROFESORA DEL GRUPO</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td colspan="5" align="center" class="director" width="200">DIRECTORA</td>
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
            // echo $tabla;
            $pdf->writeHTML($tabla, true, false, false, false, '');

            // ob_end_clean();

            $pdf->Output('Kardex de Calificaciones', 'I');
            // echo $tabla;
            /*
             * $dompdf->loadHtml($tabla);
             * $dompdf->setPaper('A4', 'portrait');
             * $dompdf->render();
             * $dompdf->stream('welcome.pdf', array("Attachment" => false));
             */
        }
    }

    public function calificacionFinal($idalumno)
    {
        $detalle = $this->alumno->allKardex($idalumno);
        $calificacion_periodo = 0;
        $suma_periodo = 0;
        $calificacion_global = 0;
        if (isset($detalle) && !empty($detalle)) {
            $total_materia = 0;
            $suma_calificacion = 0;
            $calificacion = 0;
            foreach ($detalle as $det) {
                $suma_periodo++;
                $idhorario = $det->idhorario;
                $idperiodo = $det->idperiodo;
                $calificaciones = $this->alumno->spObtenerCalificacion($idalumno, $idhorario, $idperiodo);
                if (isset($calificaciones) && !empty($calificaciones)) {
                    foreach ($calificaciones as $calificacion) {
                        $idnivelestudio = $calificacion->idnivelestudio;
                        $detalle_configuracion = $this->configuracion->showAllConfiguracion($this->session->idplantel, $idnivelestudio);
                        if ($calificacion->calificacion > 0 && $calificacion->mostrar == "SI"  &&   $calificacion->mostrar_calificar  == 'SI') {
                            //if ($calificacion->calificacion >= $detalle_configuracion[0]->calificacion_minima) {

                            $suma_calificacion += $calificacion->calificacion;
                            $total_materia = $total_materia + 1;
                            /*} else {
                                $total_materia = $total_materia + 1;
                            }*/
                        }
                    }
                    if ($suma_calificacion > 0  && $total_materia > 0) {
                        $calificacion = $suma_calificacion / $total_materia;

                        $calificacion_periodo += numberFormatPrecision($calificacion, 1, '.');
                    }
                }
                /* $materias = $this->alumno->showAllMateriasPasadas($idhorario, $idalumno, $idperiodo);

                if (isset($materias) && !empty($materias)) {

                    $oportunidades_examen = $this->alumno->showAllOportunidadesExamen($this->session->idplantel);
                    $total_materia = 0;
                    $suma_calificacion = 0;
                    $calificacion = 0;

                    foreach ($materias as $row) {
                        $idnivelestudio = $row->idnivelestudio;
                        $idprofesormateria = $row->idprofesormateri;
                        $detalle_configuracion = $this->configuracion->showAllConfiguracion($this->session->idplantel, $idnivelestudio);
 
                         $calificacion = 0;
                        foreach ($oportunidades_examen as $oportunidad) {
                            $idoportunidadexamen = $oportunidad->idoportunidadexamen;
                            $detalle_calificacion = $this->alumno->obtenerCalificacionFinal($idalumno, $idhorario, $idprofesormateria);
                            if ($detalle_calificacion && $calificacion == 0) {

                                if ($detalle_calificacion[0]->calificacion >= $detalle_configuracion[0]->calificacion_minima) {
                                    $calificacion .= $detalle_calificacion[0]->calificacion;
                                    $suma_calificacion += $calificacion;
                                    $total_materia = $total_materia + 1;
                                }
                            }
                        }
                    }

                    $calificacion = $suma_calificacion / $total_materia;

                    $calificacion_periodo += numberFormatPrecision($calificacion, 1, '.');
                }*/
            }
        }
        if ($calificacion_periodo > 0 && $suma_periodo > 0) {
            $calificacion_global = numberFormatPrecision(($calificacion_periodo / $suma_periodo), 1, '.');
        }

        return $calificacion_global;
    }

    public function historial($idhorario = '', $idperiodo = '')
    {
        Permission::grant(uri_string());
        //echo $this->session->idalumno;
        $idhorario = $this->decode($idhorario);
        $idperiodo = $this->decode($idperiodo);
        $tabla = "";
        if ((isset($idhorario) && !empty($idhorario)) && (isset($idperiodo) && !empty($idperiodo))) {
            $idalumno = $this->session->idalumno;
            $datosalumno = $this->alumno->showAllAlumnoId($idalumno);
            $datoshorario = $this->horario->showNivelGrupo($idhorario);
            $materias = $this->alumno->showAllMateriasPasadas($idhorario, $idalumno, $idperiodo);
            // $unidades = $this->grupo->unidades($this->session->idplantel);
            $idnivelestudio = $datoshorario->idnivelestudio;
            $idniveleducativo = $datoshorario->idniveleducativo;
            $detalle_configuracion = $this->configuracion->showAllConfiguracion($this->session->idplantel, $idnivelestudio);

            if ($idniveleducativo == 1) {
                // PRIMARIA  
                $tabla = $this->obtenerCalificacionPrimaria($idhorario, $idalumno);
            }
            if ($idniveleducativo == 2) {
                // SECUNDARIA
                $tabla = $this->obtenerCalificacionSecundaria($idhorario, $idalumno, $idperiodo);
            }
            if ($idniveleducativo == 3) {
                // PREPARATORIA
                $tabla = $this->obtenerCalificacionPreparatoria($idhorario, $idalumno, $idperiodo);
            }
            if ($idniveleducativo == 5) {
                // LICENCIATUA
                $tabla = $this->obtenerCalificacionLicenciaturaFinal($idhorario, $idalumno, $idperiodo);
            }
            if ($idniveleducativo == 4) {
                // PREESCOLAR
                $tabla = $this->obtenerCalificacionPreescolar($idhorario, $idalumno, $idnivelestudio, $idperiodo);
            }

            // CODIGO PARA OBTENER LA CALIFICACION DEL NIVEL
            $oportunidades_examen = $this->alumno->showAllOportunidadesExamen($this->session->idplantel);
            $total_materia = 0;
            $suma_calificacion = 0;
            foreach ($materias as $row) {
                $total_materia = $total_materia + 1;
                $idhorariodetalle = $row->idhorariodetalle;
                $calificacion = 0;
                foreach ($oportunidades_examen as $oportunidad) {
                    $idoportunidadexamen = $oportunidad->idoportunidadexamen;
                    $detalle_calificacion = $this->alumno->calificacionSecuPrepa($idalumno, $idhorariodetalle, $idoportunidadexamen);
                    if ($detalle_calificacion && $calificacion == 0) {
                        if ($detalle_calificacion[0]->calificacion >= $detalle_configuracion[0]->calificacion_minima) {
                            $calificacion .= $detalle_calificacion[0]->calificacion;
                            $suma_calificacion += $calificacion;
                        }
                    }
                }
            }
            $calificacion = 0;
            $calificacion = $suma_calificacion / $total_materia;
            // FIN DEL CODIGO PARA OBTENER LA CALIFICACION DEL NIVEL
            $data = array(
                'idhorario' => $idhorario,
                'idalumno' => $idalumno,
                'tabla' => $tabla,
                'datosalumno' => $datosalumno,
                'datoshorario' => $datoshorario,
                'calificacion' => $calificacion,
                'controller' => $this,
                // 'total_reprobados'=>$total_reprovadas,
                'nivel_educativo' => $idniveleducativo
            );
            $this->load->view('alumno/header');
            $this->load->view('alumno/kardex/kardex', $data);
            $this->load->view('alumno/footer');
        } else {
            $data = array(
                'heading' => 'Error',
                'message' => 'Error intente mas tarde.'
            );
            $this->load->view('errors/html/error_general', $data);
        }
    }

    public function obtenerCalificacionOportunidades($idhorario = '', $idalumno = '', $idoportunidad_acterior, $idoportunidad_actual)
    {
        # code...
        Permission::grant(uri_string());
        $idplantel = $this->session->idplantel;
        $datoshorario = $this->horario->showNivelGrupo($idhorario);
        $idnivelestudio = $datoshorario->idnivelestudio;

        $detalle_configuracion = $this->configuracion->showAllConfiguracion($this->session->idplantel, $idnivelestudio);
        $calificaciones = $this->alumno->obtenerCalificacionPorOportunidadAlumno($idalumno, $idhorario, $idoportunidad_acterior);
        $tabla = "";
        $tabla .= '<table class="table  table-striped  table-hover">
        <thead class="bg-teal">
         <th>#</th>
        <th>MATERIA</th>';
        $tabla .= '<th>CALIFICACIÓN</th>';
        $tabla .= '</thead>';
        $c = 1;
        if (isset($calificaciones) && !empty($calificaciones)) {
            foreach ($calificaciones as $row) {
                if (($row->mostrar == "SI") && ($row->calificacion < $detalle_configuracion[0]->calificacion_minima)) {
                    $calificacion_alu = $this->alumno->calificacionPorOportunidad($idalumno, $idhorario, $idoportunidad_actual, $row->idmateria);

                    $tabla .= '<tr>';
                    $tabla .= '<td>' . $c++ . '</td>';
                    $tabla .= '<td>' . $row->nombreclase . '</td>';
                    if (isset($calificacion_alu) && !empty($calificacion_alu)) {
                        if ($calificacion_alu[0]->calificacionmateria < $detalle_configuracion[0]->calificacion_minima) {
                            $tabla .= '<td style="color:red;"><strong>' . $calificacion_alu[0]->calificacionmateria . '</strong></td>';
                        } else {
                            $tabla .= '<td style="color:green;"><strong>' . $calificacion_alu[0]->calificacionmateria . '</strong></td>';
                        }
                    } else {
                        $tabla .= '<td>No registrado.</td>';
                    }
                    $tabla .= '</tr>';
                }
            }
        }
        if ($c <= 1) {
            $tabla .= '<tr><td colspan="3" align="center">Sin registros</td></tr>';
        }
        $tabla .= '</table>';
        return $tabla;
    }

    public function oportunidades($idalumno, $idhorario, $idopotunidad, $numero)
    {
        $idalumno = $this->decode($idalumno);
        $idhorario = $this->decode($idhorario);
        $idopotunidad = $this->decode($idopotunidad);
        $numero = $this->decode($numero);
        if ((isset($idhorario) && !empty($idhorario)) && (isset($idalumno) && !empty($idalumno)) && (isset($idopotunidad) && !empty($idopotunidad)) && (isset($numero) && !empty($numero))) {
            $idplantel = $this->session->idplantel;
            $detalle_oportunidad_anteriot = $this->grupo->obtenerOportunidadAnterior($numero, $idplantel);
            $idoportunidad_anterior = $detalle_oportunidad_anteriot->idoportunidadexamen;
            // $detalle_calificacion = $this->alumno->calificacionPorOportunidad($idalumno, $idhorario,$idoportunidad_anterior);
            $detalle_oportunidad = $this->grupo->detalleOportunidad($idopotunidad);
            $nombre_oportunidad = $detalle_oportunidad->nombreoportunidad;
            $data = array(
                'tabla' => $this->obtenerCalificacionOportunidades($idhorario, $idalumno, $idoportunidad_anterior, $idopotunidad),
                'nombreoportunidad' => $nombre_oportunidad
            );
            $this->load->view('alumno/header');
            $this->load->view('alumno/kardex/oportunidades', $data);
            $this->load->view('alumno/footer');
        } else {
            $data = array(
                'heading' => 'Error',
                'message' => 'Error intente mas tarde.'
            );
            $this->load->view('errors/html/error_general', $data);
        }
    }

    public function detalletarea($idtarea = '')
    {
        $idtarea = $this->decode($idtarea);
        if (isset($idtarea) && !empty($idtarea)) {
            $detalle_tarea = $this->mensaje->detalleTarea($idtarea);
            $data_tarea = array(
                'idnotificacionalumno' => 2
            );
            $this->mensaje->updateTarea($idtarea, $data_tarea);
            $data = array(
                'tarea' => $detalle_tarea
            );
            $this->load->view('alumno/header');
            $this->load->view('alumno/detalle/tarea', $data);
            $this->load->view('alumno/footer');
        } else {
            $data = array(
                'heading' => 'Error',
                'message' => 'Error intente mas tarde.'
            );
            $this->load->view('errors/html/error_general', $data);
        }
    }

    public function detallemensaje($idmensaje = '')
    {
        $idmensaje = $this->decode($idmensaje);
        if (isset($idmensaje) && !empty($idmensaje)) {
            $detalle_mensaje = $this->mensaje->detalleMensaje($idmensaje);
            // var_dump($detalle_tarea);
            $data_mesaje = array(
                'idnotificacionalumno' => 2
            );
            $this->mensaje->updateMensaje($idmensaje, $data_mesaje);
            $data = array(
                'mensaje' => $detalle_mensaje
            );
            $this->load->view('alumno/header');
            $this->load->view('alumno/detalle/mensaje', $data);
            $this->load->view('alumno/footer');
        } else {
            $data = array(
                'heading' => 'Error',
                'message' => 'Error intente mas tarde.'
            );
            $this->load->view('errors/html/error_general', $data);
        }
    }

    public function obtenerCalificacionFinal($idalumno = '')
    {
        $periodos = $this->alumno->obtenerPeriodo($idalumno);
        $total_periodo = 0;
        if ($periodos) {
            foreach ($periodos as $row) {
                $total_periodo += 1;
                $idperiodo = $row->idperiodo;
                $idgrupo = $row->idgrupo;
                $idhorario = $row->idhorario;
                $idplantel = $row->idplantel;
            }
        }
    }
}
