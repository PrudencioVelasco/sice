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
         $this->load->model('grupo_model','grupo'); 
          $this->load->model('horario_model','horario');  
        date_default_timezone_set("America/Mexico_City");
        $this->load->library('permission');
        $this->load->library('session');
        $this->load->library('encryption');
	}
  function encode($string)
        {
            $encrypted = $this->encryption->encrypt($string);
            if ( !empty($string) )
            {
                $encrypted = strtr($encrypted, array('/' => '~'));
            }
            return $encrypted;
        }

        function decode($string)
        {
            $string = strtr($string, array('~' => '/'));
            return $this->encryption->decrypt($string);
        } 

	public function index()
	{
        Permission::grant(uri_string()); 
        $idhorario = "";
        $result = $this->grupo->showAllGruposProfesor($this->session->idprofesor);
        //var_dump($result);
        if($result != false){
             $idhorario = $result[0]->idhorario;
        }
       
        $data = array( 
            'id'=>$idhorario,
            'controller'=>$this
        );
	    $this->load->view('docente/header');
        $this->load->view('docente/horario/index',$data);
        $this->load->view('docente/footer');

	} 
     public function imprimirHorario($idhorario='')
 { 
    Permission::grant(uri_string());
    $idhorario = $this->decode($idhorario);
    if(isset($idhorario) && !empty($idhorario)){
   $lunes = $this->horario->showAllDiaHorario($idhorario,1);
        $martes = $this->horario->showAllDiaHorario($idhorario,2);
        $miercoles = $this->horario->showAllDiaHorario($idhorario,3);
        $jueves = $this->horario->showAllDiaHorario($idhorario,4);
        $viernes = $this->horario->showAllDiaHorario($idhorario,5);  
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
    if(isset($lunes) && !empty($lunes)){
    foreach($lunes as $row){
            if($row->opcion != "Descanso"){
              $tbl.='<div class="dia"><label> '.$row->nombreclase.'</label><br> <small class = "hora">('.$row->horainicial.' - '.$row->horafinal.')</small></div>';
            }else{
              $tbl.='<div class="dia"><label> '.$row->nombreclase.'</label><br> <small class = "hora">('.$row->horainicial.' - '.$row->horafinal.')</small></div>';
            }
        } 
      }
    $tbl .='
</div>
<div class = "dl">
<div class="diasemana"><label>MARTES</label></div>
     ';
     if(isset($martes) && !empty($martes)){
    foreach($martes as $row){
            if($row->opcion != "Descanso"){
              $tbl.='<div class="dia"><label> '.$row->nombreclase.'</label><br> <small class = "hora">('.$row->horainicial.' - '.$row->horafinal.')</small></div>';
            }else{
              $tbl.='<div class="dia"><label> '.$row->nombreclase.'</label><br> <small class = "hora">('.$row->horainicial.' - '.$row->horafinal.')</small></div>';
            }
        } 
      }
    $tbl .='
</div> 
<div class = "dl">
<div class="diasemana"><label>MIERCOLES</label></div>
   ';
   if(isset($miercoles) && !empty($miercoles)){
    foreach($miercoles as $row){
            if($row->opcion != "Descanso"){
              $tbl.='<div class="dia"><label> '.$row->nombreclase.'</label><br> <small class = "hora">('.$row->horainicial.' - '.$row->horafinal.')</small></div>';
            }else{
              $tbl.='<div class="dia"><label> '.$row->nombreclase.'</label><br> <small class = "hora">('.$row->horainicial.' - '.$row->horafinal.')</small></div>';
            }
        } 
      }
    $tbl .='
</div> 
<div class = "dl">
<div class="diasemana"><label>JUEVES</label></div>
     ';
     if(isset($jueves) && !empty($jueves)){
    foreach($jueves as $row){
            if($row->opcion != "Descanso"){
              $tbl.='<div class="dia"><label> '.$row->nombreclase.'</label><br> <small class = "hora">('.$row->horainicial.' - '.$row->horafinal.')</small></div>';
            }else{
              $tbl.='<div class="dia"><label> '.$row->nombreclase.'</label><br> <small class = "hora">('.$row->horainicial.' - '.$row->horafinal.')</small></div>';
            }
        } 
      }
    $tbl .='
</div> 
<div class = "dl">
<div class="diasemana"><label>VIERNES</label></div>
    ';
    if(isset($viernes) && !empty($viernes)){
    foreach($viernes as $row){
            if($row->opcion != "Descanso"){
              $tbl.='<div class="dia"><label> '.$row->nombreclase.'</label><br> <small class = "hora">('.$row->horainicial.' - '.$row->horafinal.')</small></div>';
            }else{
              $tbl.='<div class="dia"><label> '.$row->nombreclase.'</label><br> <small class = "hora">('.$row->horainicial.' - '.$row->horafinal.')</small></div>';
            }
        } 
      }
    $tbl .='
</div> 
</body>
</html>
';
 $this->load->library('pdfgenerator');
$this->dompdf->loadHtml($tbl);
$this->dompdf->setPaper('A4');
$this->dompdf->render();
$this->dompdf->stream("welcome.pdf", array("Attachment"=>0));
 }else{
         $data = array(
            'heading'=>'Error',
            'message'=>'Error intente mas tarde.'
        );
         $this->load->view('errors/html/error_general',$data);
    }
 }
}
