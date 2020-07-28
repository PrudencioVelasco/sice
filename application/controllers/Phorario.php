<?php

defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("America/Mexico_City");

class Phorario extends CI_Controller {

    function __construct() {
        parent::__construct();

        if (!isset($_SESSION['user_id'])) {
            $this->session->set_flashdata('flash_data', 'You don\'t have access! ss');
            return redirect('welcome');
        }
        $this->load->helper('url');
        $this->load->model('data_model');
        $this->load->model('grupo_model', 'grupo');
        $this->load->model('horario_model', 'horario');
        $this->load->model('alumno_model', 'alumno');
        date_default_timezone_set("America/Mexico_City");
        $this->load->library('permission');
        $this->load->library('session');
        $this->load->library('encryption');
    }

    function encode($string) {
        $encrypted = $this->encryption->encrypt($string);
        if (!empty($string)) {
            $encrypted = strtr($encrypted, array('/' => '~'));
        }
        return $encrypted;
    }

    function decode($string) {
        $string = strtr($string, array('~' => '/'));
        return $this->encryption->decrypt($string);
    }

    public function index() {
        Permission::grant(uri_string());
        $idhorario = "";
        $tabla = "";
        $result = $this->grupo->showAllGruposProfesor($this->session->idprofesor);
        //var_dump($result);
        if ($result != false) {
            $idhorario = $result[0]->idhorario;
            $tabla = $this->horarioMostrar();
        }


        $data = array(
            'id' => $idhorario,
            'controller' => $this,
            'tabla' => $tabla
        );
        $this->load->view('docente/header');
        $this->load->view('docente/horario/index', $data);
        $this->load->view('docente/footer');
    }

    public function horarioMostrar() {


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
 
</style>';


        $tabla .= '<table class="table table-hover table-striped"  > ';
        $tabla .= ' <thead class="bg-teal"> ';
        $tabla .= '<td   >HORA</td>';
        $tabla .= '<td   >LUNES</td>';
        $tabla .= '<td  >MARTES</td>';
        $tabla .= '<td >MIERCOLES</td>';
        $tabla .= '<td  >JUEVES</td>';
        $tabla .= '<td  >VIERNES</td>';


        $tabla .= ' </thead>';


        $lunesAll = $this->horario->showHorarioProfesor($this->session->idprofesor);


        foreach ($lunesAll as $row) {
            $tabla .= '<tr>';
            $tabla .= '<td  ><strong>' . $row->hora . '</strong></td>';
            $tabla .= '<td >' . $row->lunes . '</td>';
            $tabla .= '<td  >' . $row->martes . '</td>';
            $tabla .= '<td >' . $row->miercoles . '</td>';
            $tabla .= '<td  >' . $row->jueves . '</td>';
            $tabla .= '<td >' . $row->viernes . '</td>';

            $tabla .= '</tr>';
        }
        $tabla .= '</table>';

        return $tabla;
    }

    public function generarHorarioPDF($idhorario = '') {
        /* $idhorario = $this->decode($idhorario);
          $idalumno = $this->decode($idalumno);
          if((isset($idhorario) && !empty($idhorario)) && (isset($idalumno) && !empty($idalumno)) ){
         */
        $detalle_logo = $this->alumno->logo($this->session->idplantel);
        $logo = base_url() . '/assets/images/escuelas/' . $detalle_logo[0]->logoplantel;
        $logo2 = base_url() . '/assets/images/escuelas/' . $detalle_logo[0]->logosegundo;

        $dias = $this->alumno->showAllDias();
        $this->load->library('tcpdf');
        $hora = date("h:i:s a");
        //$linkimge = base_url() . '/assets/images/woorilogo.png';
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

        $pdf->AddPage();
        $tabla = '
        <style type="text/css">
    .txtn{
        font-size:12px;
    }
    .direccion{
        font-size:12px;
    }
    .nombreplantel{
        font-size:16px;
        font-weight:bolder;
    }
    .telefono{
          font-size:12px;
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
      font-size:11px; 
    font-weight:bold;
    border-bottom:solid 1px #000000;
}
.result{
     font-family:Verdana, Geneva, sans-serif;
      font-size:12px; 
    font-weight:bold;
}.nombreclase{
   font-size:12px;
   font-weight: bold;
}
.txthorario{
   font-size:10px;
}
.txttutor{
   font-size:10px;
}
.txtdia{
  font-size:15px;
   font-weight: bold;
   background-color:#ccc;
}
</style>
<div id="areimprimir">  
          <table width="950" border="0" cellpadding="2" cellspacing="0">
  <tr>
    <td width="101" align="center"><img   class="imgtitle" src="' . $logo2 . '" /></td>
    <td colspan="2" align="center">
            <label class="nombreplantel">' . $detalle_logo[0]->nombreplantel . '</label><br>
            <label class="txtn">' . $detalle_logo[0]->asociado . '</label><br>
            <label class="direccion">' . $detalle_logo[0]->direccion . '</label><br>
            <label class="telefono">TELÉFONO: ' . $detalle_logo[0]->telefono . '</label>
    </td>
    <td width="137" align="center"><img   class="imgtitle" src="' . $logo . '" /></td>
  </tr>  
  </table> <br/>';

        $tabla .= '<table  width="950" border="1">
      <thead> 
    ';
        foreach ($dias as $dia):
            $tabla .= '<th align="center" class="txtdia text-center">' . $dia->nombredia . '</th>';
        endforeach;

        $tabla .= '</thead>';
        $c = 1;
        //$alumn = $al->getAlumn();

        $tabla .= '<tr valign="top">';
        foreach ($dias as $block):
            $lunes = $this->horario->showAllDiaHorario($idhorario, $block->iddia);
            $tabla .= '<td>';
            $tabla .= '<table   border="0" >';
            if ($lunes != false) {
                foreach ($lunes as $row) {
                    $tabla .= '<tr>
              <td width="200" style="border-bottom:solid #ccc 1px; height:70px; padding-left:5px; padding-right:5px;">';
                    if (strtoupper($row->opcion) == "NORMAL") {
                        $tabla .= '<ul>';
                        $tabla .= '<li class="nombreclase">' . $row->nombreclase . '</li>';
                        $tabla .= '<li class="txthorario">' . date('h:i A', strtotime($row->horainicial)) . ' - ' . date('h:i A', strtotime($row->horafinal)) . '</li>';
                        $tabla .= '<li class="txttutor">' . $row->nombre . ' ' . $row->apellidop . ' ' . $row->apellidom . '</li>';
                        $tabla .= '</ul>';
                    }
                    if (strtoupper($row->opcion) == "DESCANSO") {
                        $tabla .= '<label class="nombreclase"> ' . $row->nombreclase . '</label>';
                    }
                    if (strtoupper($row->opcion) == "SIN CLASES") {
                        //$tabla.='<label class="nombreclase">SIN CLASES</label>';
                    }
                    $tabla .= '</td>
            </tr>';
                }
            } else {
                $tabla .= '<label>No registrado</label>';
            }
            $tabla .= '</table>';
            $tabla .= '</td>';
        endforeach;

        $tabla .= '</tr>';



        $tabla .= '</table></div>';

        return $tabla;
    }

    public function descargar($idhorario = '') {
        $idhorario = $this->decode($idhorario);
        if ((isset($idhorario) && !empty($idhorario))) {
            $detalle_logo = $this->alumno->logo($this->session->idplantel);
            $logo = base_url() . '/assets/images/escuelas/' . $detalle_logo[0]->logoplantel;
            $logo2 = base_url() . '/assets/images/escuelas/' . $detalle_logo[0]->logosegundo;

            $dias = $this->alumno->showAllDias();
            $this->load->library('tcpdf');
            $hora = date("h:i:s a");
            //$linkimge = base_url() . '/assets/images/woorilogo.png';
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
 
 <table width="600" border="0" cellpadding="2" cellspacing="0">
  <tr>
    <td width="101" align="center"><img   class="imgtitle" src="' . $logo2 . '" /></td>
    <td colspan="2" align="center">
            <label class="nombreplantel">' . $detalle_logo[0]->nombreplantel . '</label><br>
            <label class="txtn">' . $detalle_logo[0]->asociado . '</label><br>
            <label class="direccion">' . $detalle_logo[0]->direccion . '</label><br>
            <label class="telefono">TELÉFONO: ' . $detalle_logo[0]->telefono . '</label>
    </td>
    <td width="137" align="center"><img   class="imgtitle" src="' . $logo . '" /></td>
  </tr> 
 
  </table><br/><br/>';

           $tabla .= '<table class="tblhorario" width="600" cellpadding="2" > ';
        $tabla .= '<tr>';
        $tabla .= '<td width="65" align="center" class="txtdia">Hora</td>';
        $tabla .= '<td width="93" align="center" class="txtdia">Lunes</td>';
        $tabla .= '<td width="93" align="center" class="txtdia">Martes</td>';
        $tabla .= '<td width="93" align="center" class="txtdia">Miercoles</td>';
        $tabla .= '<td width="93" align="center" class="txtdia">Jueves</td>';
        $tabla .= '<td width="93" align="center" class="txtdia">Viernes</td>';


        $tabla .= '</tr>';
           $lunesAll = $this->horario->showHorarioProfesor($this->session->idprofesor);

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
            $data = array(
                'heading' => 'Error',
                'message' => 'Error intente mas tarde.'
            );
            $this->load->view('errors/html/error_general', $data);
        }
    }

    public function imprimirHorario($idhorario = '') {
        Permission::grant(uri_string());
        $idhorario = $this->decode($idhorario);
        if (isset($idhorario) && !empty($idhorario)) {
            $lunes = $this->horario->showAllDiaHorario($idhorario, 1);
            $martes = $this->horario->showAllDiaHorario($idhorario, 2);
            $miercoles = $this->horario->showAllDiaHorario($idhorario, 3);
            $jueves = $this->horario->showAllDiaHorario($idhorario, 4);
            $viernes = $this->horario->showAllDiaHorario($idhorario, 5);
            $this->load->library('tcpdf');
            $hora = date("h:i:s a");
            //$linkimge = base_url() . '/assets/images/woorilogo.png';
            $fechaactual = date('d/m/Y');


            $tbl = '
        <!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
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
      font-size:9px; 
    font-weight:bold;
}
.dl{ 
    width:142px;
    display:inline-block;
    *display:inline;
    vertical-align:top;
    margin-right:-4px;

}
.dia{
    font-family:Verdana, Geneva, sans-serif;
    border:solid 1px #ccc;
     font-size:10px;
     height:38px;
     vertical-align:top; 
     padding: 5px 5px 5px 5px;
     margin:0;
}
.diasemana{
      font-family:Verdana, Geneva, sans-serif;
    border:solid 1px #ccc;
     font-size:10px;
     height:20px;
     background-color:#ccc;
     padding: 5px 5px 0px 5px;
     font-weight:bolder;
}
.hora{
     font-size:8px;
     font-weight:bolder;
}
</style>

<title>Title</title>
</head>
<body>
 
<div class = "dl">
<div class="diasemana"><label>LUNES</label></div>
    ';
            if (isset($lunes) && !empty($lunes)) {
                foreach ($lunes as $row) {
                    if ($row->opcion != "Descanso") {
                        $tbl .= '<div class="dia"><label> ' . $row->nombreclase . '</label><br> <small class = "hora">(' . $row->horainicial . ' - ' . $row->horafinal . ')</small></div>';
                    } else {
                        $tbl .= '<div class="dia"><label> ' . $row->nombreclase . '</label><br> <small class = "hora">(' . $row->horainicial . ' - ' . $row->horafinal . ')</small></div>';
                    }
                }
            }
            $tbl .= '
</div>
<div class = "dl">
<div class="diasemana"><label>MARTES</label></div>
     ';
            if (isset($martes) && !empty($martes)) {
                foreach ($martes as $row) {
                    if ($row->opcion != "Descanso") {
                        $tbl .= '<div class="dia"><label> ' . $row->nombreclase . '</label><br> <small class = "hora">(' . $row->horainicial . ' - ' . $row->horafinal . ')</small></div>';
                    } else {
                        $tbl .= '<div class="dia"><label> ' . $row->nombreclase . '</label><br> <small class = "hora">(' . $row->horainicial . ' - ' . $row->horafinal . ')</small></div>';
                    }
                }
            }
            $tbl .= '
</div> 
<div class = "dl">
<div class="diasemana"><label>MIERCOLES</label></div>
   ';
            if (isset($miercoles) && !empty($miercoles)) {
                foreach ($miercoles as $row) {
                    if ($row->opcion != "Descanso") {
                        $tbl .= '<div class="dia"><label> ' . $row->nombreclase . '</label><br> <small class = "hora">(' . $row->horainicial . ' - ' . $row->horafinal . ')</small></div>';
                    } else {
                        $tbl .= '<div class="dia"><label> ' . $row->nombreclase . '</label><br> <small class = "hora">(' . $row->horainicial . ' - ' . $row->horafinal . ')</small></div>';
                    }
                }
            }
            $tbl .= '
</div> 
<div class = "dl">
<div class="diasemana"><label>JUEVES</label></div>
     ';
            if (isset($jueves) && !empty($jueves)) {
                foreach ($jueves as $row) {
                    if ($row->opcion != "Descanso") {
                        $tbl .= '<div class="dia"><label> ' . $row->nombreclase . '</label><br> <small class = "hora">(' . $row->horainicial . ' - ' . $row->horafinal . ')</small></div>';
                    } else {
                        $tbl .= '<div class="dia"><label> ' . $row->nombreclase . '</label><br> <small class = "hora">(' . $row->horainicial . ' - ' . $row->horafinal . ')</small></div>';
                    }
                }
            }
            $tbl .= '
</div> 
<div class = "dl">
<div class="diasemana"><label>VIERNES</label></div>
    ';
            if (isset($viernes) && !empty($viernes)) {
                foreach ($viernes as $row) {
                    if ($row->opcion != "Descanso") {
                        $tbl .= '<div class="dia"><label> ' . $row->nombreclase . '</label><br> <small class = "hora">(' . $row->horainicial . ' - ' . $row->horafinal . ')</small></div>';
                    } else {
                        $tbl .= '<div class="dia"><label> ' . $row->nombreclase . '</label><br> <small class = "hora">(' . $row->horainicial . ' - ' . $row->horafinal . ')</small></div>';
                    }
                }
            }
            $tbl .= '
</div> 
</body>
</html>
';
            $this->load->library('pdfgenerator');
            $this->dompdf->loadHtml($tbl);
            $this->dompdf->setPaper('A4');
            $this->dompdf->render();
            $this->dompdf->stream("welcome.pdf", array("Attachment" => 0));
        } else {
            $data = array(
                'heading' => 'Error',
                'message' => 'Error intente mas tarde.'
            );
            $this->load->view('errors/html/error_general', $data);
        }
    }

}
