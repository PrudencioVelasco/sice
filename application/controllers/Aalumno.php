<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("America/Mexico_City");
class Aalumno extends CI_Controller {
 
  function __construct() {
        parent::__construct(); 
       if (!isset($_SESSION['user_id'])) {
            $this->session->set_flashdata('flash_data', 'You don\'t have access! ss');
            return redirect('welcome');
        }
        $this->load->helper('url');  
        $this->load->library('permission');
        $this->load->library('session');
        $this->load->model('alumno_model','alumno'); 
         $this->load->model('horario_model','horario');  
        $this->load->model('grupo_model','grupo'); 
        $this->load->model('mensaje_model','mensaje'); 
        date_default_timezone_set("America/Mexico_City");
        $this->load->helper('numeroatexto_helper');
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
        $this->load->view('alumno/header');
        $this->load->view('alumno/index');
        $this->load->view('alumno/footer');

    }
    public function generarHorarioPDF($idhorario = '',$idalumno='')
    {
        if((isset($idhorario) && !empty($idhorario)) && (isset($idalumno) && !empty($idalumno)) ){
 
        $lunes = $this->horario->showAllDiaHorario($idhorario,1);
        $martes = $this->horario->showAllDiaHorario($idhorario,2);
        $miercoles = $this->horario->showAllDiaHorario($idhorario,3);
        $jueves = $this->horario->showAllDiaHorario($idhorario,4);
        $viernes = $this->horario->showAllDiaHorario($idhorario,5);
        $alumno = $this->alumno->detalleAlumno($idalumno);
        $grupo = $this->horario->showNivelGrupo($idhorario);
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
     font-family:Verdana, Geneva, sans-serif;
    font-size:9px; 
    font-weight:bold;  
    border-bottom:solid 1px black;  
    border-left:solid 1px black;
     border-right:solid 1px black;  
      padding:900px 20px 20px 20px;
}  
.escuela{
     font-family:Verdana, Geneva, sans-serif;
      font-size:12px; 
    font-weight:bold;
}
.horario{
     font-family:Verdana, Geneva, sans-serif;
      font-size:10px; 
    font-weight:bold;
}
.titulo{
     font-family:Verdana, Geneva, sans-serif;
      font-size:8px; 
    font-weight:bold;
}
.result{
     font-family:Verdana, Geneva, sans-serif;
      font-size:9px; 
    font-weight:bold;
}
.dl{ 
     font-family:Verdana, Geneva, sans-serif;
    width:142px;
    display:inline-block;
    *display:inline;
    vertical-align:top;
    margin-right:-4px;

}
.dia{
    font-family:Verdana, Geneva, sans-serif;
    border:solid 1px #ccc;
     font-size:8px;
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
     font-family:Verdana, Geneva, sans-serif;
     font-size:8px;
     font-weight:bolder;
}
</style>

<title>Title</title>
</head>
<body>
<table width="540" border="0" cellpadding="1" cellspacing="4">

  <tr>
    <td colspan="4" align="center"><label class="escuela">'.$alumno->nombreplantel.'</label></td> 
  </tr>
  <tr>
    <td colspan="4" align="center"><label class="horario">Horario del Alumno</label></td> 
    </tr>
   <tr>
    <td align="center"  style="border-bottom:solid 1px #000000;"><label class="titulo">Matricula</label></td>
    <td align="center"  style="border-bottom:solid 1px #000000;"><label class="titulo">Alumno</label></td>
    <td align="center"  style="border-bottom:solid 1px #000000;"><label class="titulo">Nivel Escolar</label></td>
    <td align="center"  style="border-bottom:solid 1px #000000;"><label class="titulo">Periodo Escolar</label></td>
  </tr>
  <tr>
    <td align="center"><label class="result">'.$alumno->matricula.'</label></td>
    <td align="center"><label class="result">'.$alumno->nombre.' '.$alumno->apellidop.' '.$alumno->apellidom.'</label></td>
    <td align="center"><label class="result">'.$grupo->nombrenivel.' '.$grupo->nombregrupo.'</label></td>
    <td align="center"><label class="result">'.$grupo->mesinicio.' '.$grupo->yearinicio.' - '.$grupo->mesfin.' '.$grupo->yearfin.'</label></td>
  </tr> 
</table>
<br>
<div class = "dl">
<div class="diasemana"><label>LUNES</label></div>
    ';
    if(isset($lunes) && !empty($lunes)){
    foreach($lunes as $row){
              if(strtoupper($row->opcion) == "NORMAL"){ 
                 $tbl.='<div class="dia"><label> '.$row->nombreclase.'</label><br> <small class = "hora">('.$row->horainicial.' - '.$row->horafinal.')</small>
              <br>
              <small class = "hora">'.$row->nombre.' '.$row->apellidop.' '.$row->apellidom.'</small></div>';
              
            
            }
            if(strtoupper($row->opcion) == "DESCANSO"){
              $tbl.='<div class="dia"><label> '.$row->nombreclase.'</label><br> <small class = "hora">('.$row->horainicial.' - '.$row->horafinal.')</small></div>';
            }
             if(strtoupper($row->opcion) == "SIN CLASES"){
              $tbl.='<div class="dia"><label>SIN CLASES</label><br> <small class = "hora">('.$row->horainicial.' - '.$row->horafinal.')</small></div>';
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
            if(strtoupper($row->opcion) == "NORMAL"){ 
                 $tbl.='<div class="dia"><label> '.$row->nombreclase.'</label><br> <small class = "hora">('.$row->horainicial.' - '.$row->horafinal.')</small>
              <br>
              <small class = "hora">'.$row->nombre.' '.$row->apellidop.' '.$row->apellidom.'</small></div>';
              
            
            }
            if(strtoupper($row->opcion) == "DESCANSO"){
              $tbl.='<div class="dia"><label> '.$row->nombreclase.'</label><br> <small class = "hora">('.$row->horainicial.' - '.$row->horafinal.')</small></div>';
            }
             if(strtoupper($row->opcion) == "SIN CLASES"){
              $tbl.='<div class="dia"><label>SIN CLASES</label><br> <small class = "hora">('.$row->horainicial.' - '.$row->horafinal.')</small></div>';
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
            if(strtoupper($row->opcion) == "NORMAL"){ 
                 $tbl.='<div class="dia"><label> '.$row->nombreclase.'</label><br> <small class = "hora">('.$row->horainicial.' - '.$row->horafinal.')</small>
              <br>
              <small class = "hora">'.$row->nombre.' '.$row->apellidop.' '.$row->apellidom.'</small></div>';
              
            
            }
            if(strtoupper($row->opcion) == "DESCANSO"){
              $tbl.='<div class="dia"><label> '.$row->nombreclase.'</label><br> <small class = "hora">('.$row->horainicial.' - '.$row->horafinal.')</small></div>';
            }
             if(strtoupper($row->opcion) == "SIN CLASES"){
              $tbl.='<div class="dia"><label>SIN CLASES</label><br> <small class = "hora">('.$row->horainicial.' - '.$row->horafinal.')</small></div>';
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
          if(strtoupper($row->opcion) == "NORMAL"){ 
                 $tbl.='<div class="dia"><label> '.$row->nombreclase.'</label><br> <small class = "hora">('.$row->horainicial.' - '.$row->horafinal.')</small>
              <br>
              <small class = "hora">'.$row->nombre.' '.$row->apellidop.' '.$row->apellidom.'</small></div>';
              
            
            }
            if(strtoupper($row->opcion) == "DESCANSO"){
              $tbl.='<div class="dia"><label> '.$row->nombreclase.'</label><br> <small class = "hora">('.$row->horainicial.' - '.$row->horafinal.')</small></div>';
            }
             if(strtoupper($row->opcion) == "SIN CLASES"){
              $tbl.='<div class="dia"><label>SIN CLASES</label><br> <small class = "hora">('.$row->horainicial.' - '.$row->horafinal.')</small></div>';
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
             if(strtoupper($row->opcion) == "NORMAL"){ 
                 $tbl.='<div class="dia"><label> '.$row->nombreclase.'</label><br> <small class = "hora">('.$row->horainicial.' - '.$row->horafinal.')</small>
              <br>
              <small class = "hora">'.$row->nombre.' '.$row->apellidop.' '.$row->apellidom.'</small></div>';
              
            
            }
            if(strtoupper($row->opcion) == "DESCANSO"){
              $tbl.='<div class="dia"><label> '.$row->nombreclase.'</label><br> <small class = "hora">('.$row->horainicial.' - '.$row->horafinal.')</small></div>';
            }
             if(strtoupper($row->opcion) == "SIN CLASES"){
              $tbl.='<div class="dia"><label>SIN CLASES</label><br> <small class = "hora">('.$row->horainicial.' - '.$row->horafinal.')</small></div>';
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
$this->dompdf->stream("Horario Escolar.pdf", array("Attachment"=>0));
        }else{
             $data = array(
            'heading'=>'Notificación',
            'message'=>'El Alumno(a) no tiene registrado Horario.'
        );
         $this->load->view('errors/html/error_general',$data);
        }
        
        }
    public function kardex()
    {
    Permission::grant(uri_string());
      # code...
        $idalumno = $this->session->idalumno;
        $kardex = $this->alumno->allKardex($this->session->idalumno);
        $data = array('kardex' => $kardex,'id'=>$idalumno,'controller'=>$this );
          $this->load->view('alumno/header');
        $this->load->view('alumno/kardex/index',$data);
        $this->load->view('alumno/footer');  
    }
    public function horario()
    {
      # code... 
      Permission::grant(uri_string());
      $idalumno = $this->session->idalumno;
      $idhorario="";
      $grupo = $this->alumno->obtenerGrupo($idalumno);
      if($grupo != false){
        $idhorario= $grupo->idhorario;
      }
      
      //var_dump($grupo);
      $data = array(
        'idhorario'=>$idhorario,
        'idalumno'=>$idalumno

      );
        $this->load->view('alumno/header');
        $this->load->view('alumno/horario/horario',$data);
        $this->load->view('alumno/footer');

    }
        public function obtenerCalificacion($idhorario='',$idhorariodetalle)
    {
      # code...
     $idalumno = $this->session->idalumno;
     
     $unidades =  $this->grupo->unidades($this->session->idplantel);
     $alumnos = $this->alumno->showAllAlumnoId($idalumno); 
      $tabla ="";
       $tabla .= '<table class="table table-bordered table-hover">
      <thead>
      <th>#</th>
      <th>Nombre</th>';
       foreach($unidades as $block):
        $tabla .= '<th>'.$block->nombreunidad.'</th>';
       endforeach; 

      $tabla .= '</thead>';
      $c = 1;
      foreach($alumnos as $row){
        //$alumn = $al->getAlumn();
       
        $tabla .= '<tr>
        <td>'.$c++.'</td>
        <td>'.$row->apellidop." ".$row->apellidom." ".$row->nombre.'</td>';
      foreach($unidades as $block):
      $val = $this->grupo->obtenerCalificacion($row->idalumno, $block->idunidad, $idhorariodetalle);
      
        $tabla .= '<td>';
        if($val != false ){ 
          $tabla .='<label>'.$val->calificacion.'</label>'; 
        }else{
           $tabla .='<label>No registrado</label>';
        } 
      $tabla .= '</td>';
      endforeach;

        $tabla .= '</tr>';
      

      }
      $tabla .= '</table>';
      return $tabla;

    }
        public function obetnerAsistencia($idhorario,$fechainicio,$fechafin,$idhorariodetalle)
    { 
      Permission::grant(uri_string());
       $idalumno = $this->session->idalumno;
         $alumns = $this->alumno->showAllAlumnoId($idalumno);
         $tabla = ""; 

         if($alumns != false){
        $range= ((strtotime($fechafin)-strtotime($fechainicio))+(24*60*60)) /(24*60*60);
        //$range= ((strtotime($_GET["finish_at"])-strtotime($_GET["start_at"]))+(24*60*60)) /(24*60*60);
        
        $tabla .= '<table class="table">
            <thead>
            <th>#</th>
            <th>Nombre</th>';
            for($i=0;$i<$range;$i++):
           $tabla .= '<th>'.date("D d-M",strtotime($fechainicio)+($i*(24*60*60))).'</th>';
           //echo date("d-M",strtotime($_GET["start_at"])+($i*(24*60*60)));
           endfor;
           $tabla .= '</thead>';
            $n = 1;
            foreach($alumns as $alumn){  
               $tabla .= ' <tr>';
               $tabla .='<td>'.$n++.'</td>';
                $tabla .= '<td >'.$alumn->apellidop." ".$alumn->apellidom." ".$alumn->nombre.'</td>';
             for($i=0;$i<$range;$i++):
                    $date_at= date("Y-m-d",strtotime($fechainicio)+($i*(24*60*60)));
                   // $asist = AssistanceData::getByATD($alumn->id,$_GET["team_id"],$date_at);
                    $asist = $this->grupo->listaAsistencia($alumn->idalumno,$idhorario,$date_at,$idhorariodetalle);
                        


                $tabla .= '<td>';
                 if($asist != false){ 
                      switch ($asist->idmotivo) {
                          case 1:
                              # code...
                             $tabla .='<span class="label label-success">'.$asist->nombremotivo.'</span>';
                              break;
                                  case 2:
                                  $tabla .='<span class="label label-warning">'.$asist->nombremotivo.'</span>';
                              # code...
                              break;
                                  case 3:
                                  $tabla .='<span class="label label-info">'.$asist->nombremotivo.'</span>';
                              # code...
                              break;
                                  case 4:
                                  $tabla .='<span class="label label-danger">'.$asist->nombremotivo.'</span>';
                              # code...
                              break;
                          
                          default:
                              # code...
                              break;
                      }
                 }else{
                    $tabla .= "No registrado";
                 }
                   
                $tabla .= '</td>';
             endfor; 
                $tabla .= '</tr>';
                

            }
$tabla .= '</table>';
}
return $tabla;

    }

    public function clases()
    {
      # code...
        Permission::grant(uri_string());
      $idalumno = $this->session->idalumno;
      $grupo = $this->alumno->obtenerGrupo($idalumno);
       $materias = "";
       if($grupo != false){
      $idhorario= $grupo->idhorario;
      $materias = $this->alumno->showAllMaterias($idhorario);
    }
      $data = array(
        'materias'=>$materias
      );
      $this->load->view('alumno/header');
        $this->load->view('alumno/calificacion/index',$data);
        $this->load->view('alumno/footer');
    }

    public function calificacion($idhorario,$idhorariodetalle)
    {
      # code... 
      Permission::grant(uri_string());
      $detalle  = $this->alumno->detalleClase($idhorariodetalle);
      $nombreclase = $detalle[0]->nombreclase; 
      $data = array(
        'tabla'=>$this->obtenerCalificacion($idhorario,$idhorariodetalle),
        'nombreclase' => $nombreclase
      );
     


        $this->load->view('alumno/header');
        $this->load->view('alumno/calificacion/calificacion',$data);
        $this->load->view('alumno/footer');
    }
     public function asistencia($idhorario,$idhorariodetalle)
    {
      # code... 
      Permission::grant(uri_string());
      $detalle  = $this->alumno->detalleClase($idhorariodetalle);
      $nombreclase = $detalle[0]->nombreclase; 
      $idalumno = $this->session->idalumno;
      $datafin = $this->alumno->ultimaFechaAsistencia($idalumno,$idhorariodetalle);
      $datainicio = $this->alumno->primeraFechaAsistencia($idalumno,$idhorariodetalle);
     
      if($datafin != false && $datainicio != false){
        $tabla = $this->obetnerAsistencia($idhorario,$datainicio->fecha,$datafin->fecha,$idhorariodetalle);
      }else{
 $tabla = $this->obetnerAsistencia($idhorario,date("Y-m-d"),date("Y-m-d"),$idhorariodetalle);
      }
      $data = array(
        //'tabla'=>$this->obtenerCalificacion($idhorario,$idhorariodetalle)
        'tabla'=>$tabla,
        'nombreclase'=>$nombreclase
      );
      $this->load->view('alumno/header');
        $this->load->view('alumno/calificacion/asistencia',$data);
        $this->load->view('alumno/footer');
    }


public function tarea($idhorario,$idhorariodetalle,$idmateria)
{
  # code...
  Permission::grant(uri_string());
  $detalle  = $this->alumno->detalleClase($idhorariodetalle);
  $nombreclase = $detalle[0]->nombreclase; 
   $tareas = $this->alumno->showAllTareaAlumno($idhorario,$idmateria);
   $data = array( 
    'tareas'=>$tareas,
    'nombreclase' =>$nombreclase
      );
      $this->load->view('alumno/header');
      $this->load->view('alumno/calificacion/tarea',$data);
      $this->load->view('alumno/footer');
}
 public function obtenerCalificacion2($idhorario='',$idalumno = '')
    {
      # code...
      Permission::grant(uri_string());
     $unidades =  $this->grupo->unidades($this->session->idplantel);
     $materias = $this->alumno->showAllMaterias($idhorario);
     
      $tabla ="";
       $tabla .= '<table class="table table-bordered table-hover">
      <thead>
      <th>#</th>
      <th>Nombre de Materia</th>';
       foreach($unidades as $block):
        $tabla .= '<th><strong>'.$block->nombreunidad.'</strong></th>';
       endforeach; 

      $tabla .= '</thead>';
      $c = 1;
      if (isset($materias) && !empty($materias)) {
      foreach($materias as $row){
        //$alumn = $al->getAlumn();
      
        $tabla .= '<tr>
        <td>'.$c++.'</td>
        <td><strong>'.$row->nombreclase.'</strong><br><small>( '.$row->nombre.' '.$row->apellidop.' '.$row->apellidom.'</small>)</td>';
      foreach($unidades as $block):
      $val = $this->grupo->obtenerCalificacion($idalumno, $block->idunidad, $row->idhorariodetalle);
      
        $tabla .= '<td>';
        if($val != false ){ 
          if(validar_calificacion($val->calificacion)){
          $tabla .='<label style="color:red;">'.$val->calificacion.'</label>'; 
          }else{
             $tabla .='<label style="color:green;">'.$val->calificacion.'</label>'; 
          }
        }else{
           $tabla .='<label>No registrado</label>';
        } 
      $tabla .= '</td>';
      endforeach;

        $tabla .= '</tr>';
      

      }
    }
      $tabla .= '</table>';
      return $tabla;

    }

     public function imprimirkardex($idhorario='',$idalumno = '')
    {
        Permission::grant(uri_string());
        $idhorario = $this->decode($idhorario);
        $idalumno = $this->decode($idalumno);
        if((isset($idhorario) && !empty($idhorario)) && (isset($idalumno) && !empty($idalumno))){
        $alumno = $this->alumno->detalleAlumno($idalumno);
        $grupop = $this->horario->showNivelGrupo($idhorario);
        $unidades =  $this->grupo->unidades($this->session->idplantel);
        $materias = $this->alumno->showAllMaterias($idhorario);
        $detalle_logo = $this->alumno->logo($this->session->idplantel);
        $logo = base_url() . '/assets/images/escuelas/'.$detalle_logo[0]->logoplantel;
        $logo2 = base_url() . '/assets/images/escuelas/'.$detalle_logo[0]->logosegundo;
        $total_unidades = 0;
        $calificacion = "";   
        $materias = $this->alumno->showAllMaterias($idhorario);
        $total_materia = 0;
        if ($materias != FALSE) { 
            foreach ($materias as $row) {
                # code...
                $total_materia = $total_materia + 1;
            }
        } 
         if ($unidades != FALSE) { 
            foreach ($unidades as $row) {
                # code...
                $total_unidades = $total_unidades + 1;
            }
        } 
        $datoscalifiacacion = $this->horario->calificacionGeneralAlumno($idhorario,$idalumno);
         if($datoscalifiacacion != FALSE && $total_materia > 0){
            $calificacion= ($datoscalifiacacion->calificaciongeneral / $total_unidades) / $total_materia;
         }


       $this->load->library('tcpdf');  
        $hora = date("h:i:s a");
        //$linkimge = base_url() . '/assets/images/woorilogo.png';
      
       $datelle_alumno = $this->alumno->showAllMateriasAlumno($idalumno);
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
        width:55px;

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
</style>
 <table width="580" border="0" cellpadding="0" cellspacing="4">
   <tr>
    <td width="101" align="left"><img   class="imgtitle" src="' . $logo2 . '" /></td>
    <td colspan="2" align="center">
            <label class="nombreplantel">'.$datelle_alumno[0]->nombreplantel.'</label><br>
            <label class="txtn">INCORPORADA A LA UNIVERSIDAD DE GUANAJUATO SEGÚN EL OFICIO 14/ABRIL/1972</label><br>
            <label class="direccion">'.$datelle_alumno[0]->direccion.'</label><br>
            <label class="telefono">TELÉFONO: '.$datelle_alumno[0]->telefono.' EXT 1</label>
    </td>
    <td width="137" align="right"><img   class="imgtitle" src="' . $logo . '" /></td>
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
    <td align="center"><label class="result">'.$alumno->matricula.'</label></td>
    <td align="center"><label class="result">'.$alumno->nombre.' '.$alumno->apellidop.' '.$alumno->apellidom.'</label></td>
    <td align="center"><label class="result">'.$grupop->nombrenivel.' '.$grupop->nombregrupo.'</label></td>
    <td align="center"><label class="result">'.$grupop->mesinicio.' - '.$grupop->mesfin.' '.$grupop->yearfin.'</label></td>
  </tr> 
</table>
<br><br>
 ';
 $tbl .= '<table class="tblcalificacion" cellpadding="2"  >
      <tr>
      <td width="30" class="titulocal">#</td>
      <td width="180" class="titulocal">MATERIA</td>';
       foreach($unidades as $block):
        $tbl .= '<td class="titulocal">'.$block->nombreunidad.'</td>';
       endforeach; 

      $tbl .= '</tr>';
      $c = 1;
      foreach($materias as $row){
        //$alumn = $al->getAlumn();
      
        $tbl .= '<tr>
        <td width="30" class="subtitulocal">'.$c++.'</td>
        <td width="180" class="subtitulocal">'.$row->nombreclase.'</td>';
      foreach($unidades as $block):
      $val = $this->grupo->obtenerCalificacion($idalumno, $block->idunidad, $row->idhorariodetalle);
      //var_dump($val);
        $tbl .= '<td class="subtitulocal">';
        if($val != false ){ 
          $tbl .='<label>'.$val->calificacion.'</label>'; 
        }else{
           $tbl .='<label>No registrado</label>';
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
                if(isset($calificacion) && !empty($calificacion)){
                   $tbl .= number_format($calificacion,2);
                }else{
                    $tbl .='<label>0.0</label>';
                }
                
                $tbl .= '</strong>
            </td>
        </tr>
      </table>
      ';

        $pdf->writeHTML($tbl, true, false, false, false, '');

    ob_end_clean();


        $pdf->Output('Kardex de Calificaciones', 'I');
    }else{
            $data = array(
                'heading'=>'Error',
                'message'=>'Error intente mas tarde.'
            );
            $this->load->view('errors/html/error_general',$data);
        }
    }
public function historial($idhorario='')
{
 Permission::grant(uri_string());
 $idhorario = $this->decode($idhorario);
 if(isset($idhorario) && !empty($idhorario)){
        $idalumno = $this->session->idalumno;
        $calificacion = "";
        $tabla = $this->obtenerCalificacion2($idhorario,$idalumno);
        $datosalumno = $this->alumno->showAllAlumnoId($idalumno);
        $datoshorario = $this->horario->showNivelGrupo($idhorario);
        $materias = $this->alumno->showAllMaterias($idhorario);
        $unidades =  $this->grupo->unidades($this->session->idplantel);
        $total_unidades = 0;
        $total_materia = 0;
        if ($materias != FALSE) { 
            foreach ($materias as $row) {
                # code...
                $total_materia = $total_materia + 1;
            }
        } 
          if ($unidades != FALSE) { 
            foreach ($unidades as $row) {
                # code...
                $total_unidades = $total_unidades + 1;
            }
        } 
        $datoscalifiacacion = $this->horario->calificacionGeneralAlumno($idhorario,$idalumno);
         if($datoscalifiacacion != FALSE && $total_materia > 0){
            $calificacion= ($datoscalifiacacion->calificaciongeneral / $total_unidades) / $total_materia;
         }

           $data = array(
            'idhorario'=>$idhorario,
            'idalumno'=>$idalumno,
            'tabla'=>$tabla,
            'datosalumno'=>$datosalumno,
            'datoshorario'=>$datoshorario,
            'calificacion'=>$calificacion,
            'controller'=>$this
        );
        $this->load->view('alumno/header');
        $this->load->view('alumno/kardex/kardex',$data);
        $this->load->view('alumno/footer');
         }else{
         $data = array(
            'heading'=>'Error',
            'message'=>'Error intente mas tarde.'
        );
         $this->load->view('errors/html/error_general',$data);
    }
}
 
public function detalletarea($idtarea = '')
{
        $detalle_tarea = $this->mensaje->detalleTarea($idtarea);
        //var_dump($detalle_tarea);
        $data = array(
          'tarea'=>$detalle_tarea
        );
        $this->load->view('alumno/header');
        $this->load->view('alumno/detalle/tarea',$data);
        $this->load->view('alumno/footer');
}
public function detallemensaje($idmensaje = '')
{
        $detalle_mensaje = $this->mensaje->detalleMensaje($idmensaje);
        //var_dump($detalle_tarea);
        $data = array(
          'mensaje'=>$detalle_mensaje
        );
        $this->load->view('alumno/header');
        $this->load->view('alumno/detalle/mensaje',$data);
        $this->load->view('alumno/footer');
}

}
