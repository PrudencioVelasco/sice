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
     /* $idhorario = $this->decode($idhorario);
      $idalumno = $this->decode($idalumno);
        if((isset($idhorario) && !empty($idhorario)) && (isset($idalumno) && !empty($idalumno)) ){
        */
        $detalle_logo = $this->alumno->logo($this->session->idplantel);
        $logo = base_url() . '/assets/images/escuelas/'.$detalle_logo[0]->logoplantel;
        $logo2 = base_url() . '/assets/images/escuelas/'.$detalle_logo[0]->logosegundo;
        
        $alumno = $this->alumno->detalleAlumno($idalumno);
        $grupo = $this->horario->showNivelGrupo($idhorario);
        $dias = $this->alumno->showAllDias();
        $datelle_alumno = $this->alumno->showAllMateriasAlumno($idalumno);
        if(isset($datelle_alumno) && !empty($datelle_alumno)){
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
            <label class="nombreplantel">'.$datelle_alumno[0]->nombreplantel.'</label><br>
            <label class="txtn">'.$datelle_alumno[0]->asociado.'</label><br>
            <label class="direccion">'.$datelle_alumno[0]->direccion.'</label><br>
            <label class="telefono">TELÉFONO: '.$datelle_alumno[0]->telefono.'</label>
    </td>
    <td width="137" align="center"><img   class="imgtitle" src="' . $logo . '" /></td>
  </tr> 
    <tr>
    <td align="center"  style=""><label class="titulo">Matricula</label></td>
    <td align="center"  style=""><label class="titulo">Alumno</label></td>
    <td align="center"  style=""><label class="titulo">Nivel Escolar</label></td>
    <td align="center"  style=""><label class="titulo">Periodo Escolar</label></td>
  </tr>
  <tr>
    <td align="center"><label class="result">'.$alumno->matricula.'</label></td>
    <td align="center"><label class="result">'.$alumno->nombre.' '.$alumno->apellidop.' '.$alumno->apellidom.'</label></td>
    <td align="center"><label class="result">'.$grupo->nombrenivel.' '.$grupo->nombregrupo.'</label></td>
    <td align="center"><label class="result">'.$grupo->mesinicio.' '.$grupo->yearinicio.' - '.$grupo->mesfin.' '.$grupo->yearfin.'</label></td>
  </tr> 
  </table> <br/>';

       $tabla .= '<table  width="950" border="1">
      <thead> 
    ';
       foreach($dias as $dia):
        $tabla .= '<th align="center" class="txtdia text-center">'.$dia->nombredia.'</th>';
       endforeach; 

      $tabla .= '</thead>';
      $c = 1; 
        //$alumn = $al->getAlumn();
       
        $tabla .= '<tr valign="top">';
      foreach($dias as $block):
       $lunes = $this->horario->showAllDiaHorario($idhorario,$block->iddia);
        $tabla .= '<td>';
        $tabla .= '<table   border="0" >';
        if($lunes != false ){ 
          foreach($lunes as $row){
              $tabla .= '<tr>
              <td width="200" style="border-bottom:solid #ccc 1px; height:70px; padding-left:5px; padding-right:5px;">';
             if(strtoupper($row->opcion) == "NORMAL"){ 
                 $tabla .='<ul>';
                 $tabla .='<li class="nombreclase">'.$row->nombreclase.'</li>';
                  $tabla .='<li class="txthorario">'.date('h:i A', strtotime($row->horainicial)).' - '.date('h:i A', strtotime($row->horafinal)).'</li>';
                   $tabla .='<li class="txttutor">'.$row->nombre.' '.$row->apellidop.' '.$row->apellidom.'</li>';
                 $tabla .='</ul>';
             }
            if(strtoupper($row->opcion) == "DESCANSO"){
              $tabla.='<label class="nombreclase"> '.$row->nombreclase.'</label>';
            }
             if(strtoupper($row->opcion) == "SIN CLASES"){
              //$tabla.='<label class="nombreclase">SIN CLASES</label>';
            }
            $tabla .= '</td>
            </tr>';
         }
        }else{
           $tabla .='<label>No registrado</label>';
        } 
         $tabla .= '</table>';
      $tabla .= '</td>';
      endforeach;

        $tabla .= '</tr>';
      

      
      $tabla .= '</table></div>';  
      
      return $tabla;  
      }else{
        return "";
      }
      
      
        }
        public function descargar($idhorario = '',$idalumno = '')
        {
          $idalumno = $this->decode($idalumno);
          $idhorario = $this->decode($idhorario);
          if((isset($idhorario) && !empty($idhorario)) && (isset($idalumno) && !empty($idalumno))){
        $detalle_logo = $this->alumno->logo($this->session->idplantel);
        $logo = base_url() . '/assets/images/escuelas/'.$detalle_logo[0]->logoplantel;
        $logo2 = base_url() . '/assets/images/escuelas/'.$detalle_logo[0]->logosegundo;
        $lunes = $this->horario->showAllDiaHorario($idhorario,1);
        $martes = $this->horario->showAllDiaHorario($idhorario,2);
        $miercoles = $this->horario->showAllDiaHorario($idhorario,3);
        $jueves = $this->horario->showAllDiaHorario($idhorario,4);
        $viernes = $this->horario->showAllDiaHorario($idhorario,5);
        $alumno = $this->alumno->detalleAlumno($idalumno);
        $grupo = $this->horario->showNivelGrupo($idhorario);
        $dias = $this->alumno->showAllDias();
        $datelle_alumno = $this->alumno->showAllMateriasAlumno($idalumno);
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
      font-size:10px; 
    font-weight:bold;
    border-bottom:solid 1px #000000; 
}
@page{
  size:0;
  margin-leff:20px;
  margin-right:20px;
  margin-top:5px;
}
@media print{
  #btnimprimir2{
    display:none;
  }
}
ul{
      list-style-type: none;
      margin: 0;
      padding: 0; 
    }
.result{
     font-family:Verdana, Geneva, sans-serif;
      font-size:9px; 
    font-weight:bold;
}.nombreclase{
   font-size:10px;
   font-weight: bold;
}
.txthorario{
   font-size:9px;
}
.txttutor{
   font-size:9px;
}
.txtdia{
  font-size:15px;
   font-weight: bold;
   background-color:#ccc;
   border:1px  solid #ccc;
}
   table {
            border-collapse:collapse; 
            }
   .tblhorario tr td
                {
                    border:0px  solid black;
                }

</style>
<div id="areaimprimir">  
          <table width="950" border="0" >
  <tr>
    <td width="101" align="center"><img   class="imgtitle" src="' . $logo2 . '" /></td>
    <td colspan="2" align="center">
            <label class="nombreplantel">'.$datelle_alumno[0]->nombreplantel.'</label><br>
            <label class="txtn">'.$datelle_alumno[0]->asociado.'</label><br>
            <label class="direccion">'.$datelle_alumno[0]->direccion.'</label><br>
            <label class="telefono">TELÉFONO: '.$datelle_alumno[0]->telefono.'</label>
    </td>
    <td width="137" align="center"><img   class="imgtitle" src="' . $logo . '" /></td>
  </tr> 
    <tr>
    <td align="center"  style=""><label class="titulo">Matricula</label></td>
    <td align="center"  style=""><label class="titulo">Alumno</label></td>
    <td align="center"  style=""><label class="titulo">Nivel Escolar</label></td>
    <td align="center"  style=""><label class="titulo">Periodo Escolar</label></td>
  </tr>
  <tr>
    <td align="center"><label class="result">'.$alumno->matricula.'</label></td>
    <td align="center"><label class="result">'.$alumno->nombre.' '.$alumno->apellidop.' '.$alumno->apellidom.'</label></td>
    <td align="center"><label class="result">'.$grupo->nombrenivel.' '.$grupo->nombregrupo.'</label></td>
    <td align="center"><label class="result">'.$grupo->mesinicio.' '.$grupo->yearinicio.' - '.$grupo->mesfin.' '.$grupo->yearfin.'</label></td>
  </tr> 
  </table> <br/>';

       $tabla .= '<table class="tblepr"  width="950" border="0">
      <thead> 
    ';
       foreach($dias as $dia):
        $tabla .= '<th align="center" class="txtdia text-center">'.$dia->nombredia.'</th>';
       endforeach; 

      $tabla .= '</thead>';
      $c = 1; 
        //$alumn = $al->getAlumn();
       
        $tabla .= '<tr valign="top">';
      foreach($dias as $block):
       $lunes = $this->horario->showAllDiaHorario($idhorario,$block->iddia);
        $tabla .= '<td>';
        $tabla .= '<table   class="tblhorario"  border="0" >';
        if($lunes != false ){ 
          foreach($lunes as $row){
              $tabla .= '<tr>
              <td width="200" style="border:solid #ccc 1px; height:60px; padding-left:5px; padding-right:5px;">';
             if(strtoupper($row->opcion) == "NORMAL"){ 
                 $tabla .='<ul>';
                 $tabla .='<li class="nombreclase">'.$row->nombreclase.'</li>';
                  $tabla .='<li class="txthorario">'.date('h:i A', strtotime($row->horainicial)).' - '.date('h:i A', strtotime($row->horafinal)).'</li>';
                   $tabla .='<li class="txttutor">'.$row->nombre.' '.$row->apellidop.' '.$row->apellidom.'</li>';
                 $tabla .='</ul>';
             }
            if(strtoupper($row->opcion) == "DESCANSO"){
              $tabla.='<label class="nombreclase"> '.$row->nombreclase.'</label>';
            }
             if(strtoupper($row->opcion) == "SIN CLASES"){
              //$tabla.='<label class="nombreclase">SIN CLASES</label>';
            }
            $tabla .= '</td>
            </tr>';
         }
        }else{
           $tabla .='<label>No registrado</label>';
        } 
         $tabla .= '</table>';
      $tabla .= '</td>';
      endforeach;

        $tabla .= '</tr>';
      

      
      $tabla .= '</table></div>';
      echo $tabla;
      echo '<button type="button" id="btnimprimir2" onclick="imprimirDiv()" >IMPRIMIR</button>';
      echo '
      <script>
 imprimirDiv();
function imprimirDiv(){
  //alert(divName);
  var printContents =document.getElementById("areaimprimir").innerHTML;
  var originalContents = document.body.innerHTML;
  document.body.innerHTML = printContents; 
  window.print();
  document.body.innerHTML= originalContents;
}
$(document).ready(function(){
  $("#btnimprimir2").trigger("click");
});
document.getElementById("btnimprimir2").onclick = imprimirDiv;
</script>
      ';
       }else{
        $data = array(
            'heading'=>'Error',
            'message'=>'Error intente mas tarde.'
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
        $detalle = $this->alumno->detalleAlumno($idalumno);
        $data = array('kardex' => $kardex,'detalle'=>$detalle,'id'=>$idalumno,'controller'=>$this );
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
      $tabla = $this->generarHorarioPDF($idhorario,$idalumno);
      
      //var_dump($grupo);
      $data = array(
        'idhorario'=>$idhorario,
        'idalumno'=>$idalumno,
        'controller'=>$this,
        'tabla'=>$tabla

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
            <th>#</th> ';
            for($i=0;$i<$range;$i++):
               setlocale(LC_ALL, 'es_ES');
            $fecha = strftime("%A, %d de %B", strtotime($fechainicio)+($i*(24*60*60)));

         $domingo = date('N',strtotime($fechainicio)+($i*(24*60*60)));
              if(($domingo != '7')  ){
                    if(($domingo != '6')  ){
                $tabla .= '<th>'.$fecha.'</th>';
                    }
            }
           //echo date("d-M",strtotime($_GET["start_at"])+($i*(24*60*60)));
           endfor;
           $tabla .= '</thead>';
            $n = 1;
            foreach($alumns as $alumn){  
               $tabla .= ' <tr>';
               $tabla .='<td>'.$n++.'</td>';
              for($i=0;$i<$range;$i++):
                    $date_at= date("Y-m-d",strtotime($fechainicio)+($i*(24*60*60)));
                   // $asist = AssistanceData::getByATD($alumn->id,$_GET["team_id"],$date_at);
                    $asist = $this->grupo->listaAsistencia($alumn->idalumno,$idhorario,$date_at,$idhorariodetalle);
                          $domingo = date('N',strtotime($fechainicio)+($i*(24*60*60)));

  if(($domingo != '7')  ){
                      if(($domingo != '6')  ){
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
                      }
                    }
             endfor; 
                $tabla .= '</tr>';
                

            }
$tabla .= '</table>';
}
return $tabla;

    }
      public function buscarAsistencia($idhorario,$idhorariodetalle,$fechainicio,$fechafin,$idmotivo)
    
       { 
      Permission::grant(uri_string());
        $idalumno = $this->session->idalumno;
        $idhorario =$this->decode($idhorario);
        //$idmotivo = $this->input->post('motivo');
        $idhorariodetalle =$this->decode($idhorariodetalle);
       // $fechainicio = $this->input->post('fechainicio');
       // $fechafin = $this->input->post('fechafin');
 if((isset($idhorario) && !empty($idhorario)) &&
        (isset($idhorariodetalle) && !empty($idhorariodetalle)) &&
        
        (isset($fechainicio) && !empty($fechainicio)) &&
        (isset($fechafin) && !empty($fechafin)) &&
        (isset($idmotivo) ) ){
         $alumns = $this->alumno->showAllAlumnoId($idalumno);
         $tabla = ""; 

         if($alumns != false){
        $range= ((strtotime($fechafin)-strtotime($fechainicio))+(24*60*60)) /(24*60*60);
        //$range= ((strtotime($_GET["finish_at"])-strtotime($_GET["start_at"]))+(24*60*60)) /(24*60*60);
        
        $tabla .= '<table id="tablageneral2" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
            <thead>
            <th>#</th> ';
            for($i=0;$i<$range;$i++):
               setlocale(LC_ALL, 'es_ES');
                       
                        $fecha = strftime("%A, %d de %B", strtotime($fechainicio)+($i*(24*60*60)));

           $tabla .= '<th>'. utf8_encode($fecha).'</th>';
           //echo date("d-M",strtotime($_GET["start_at"])+($i*(24*60*60)));
           endfor;
           $tabla .= '</thead>';
            $n = 1;
            foreach($alumns as $alumn){  
               $tabla .= ' <tr>';
               $tabla .='<td>'.$n++.'</td>';
              for($i=0;$i<$range;$i++):
                    $date_at= date("Y-m-d",strtotime($fechainicio)+($i*(24*60*60)));
                   // $asist = AssistanceData::getByATD($alumn->id,$_GET["team_id"],$date_at);
                    $asist = $this->grupo->listaAsistenciaBuscar($alumn->idalumno,$idhorario,$date_at,$idhorariodetalle,$idmotivo);
                        


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
 
$motivos = $this->alumno->showAllMotivoAsistencia();
 $detalle  = $this->alumno->detalleClase($idhorariodetalle);
    
 $nombreclase = $detalle[0]->nombreclase; 
       $data = array(
        //'tabla'=>$this->obtenerCalificacion($idhorario,$idhorariodetalle)
        'tabla'=>$tabla,
        'nombreclase'=>$nombreclase,
        'idhorario'=>$idhorario,
        'idhorariodetalle'=>$idhorariodetalle,
        'motivos'=>$motivos,
        'controller'=>$this
      );
      $this->load->view('alumno/header');
        $this->load->view('alumno/calificacion/buscar_asistencia',$data);
        $this->load->view('alumno/footer');
 
 }else{
        $data = array(
            'heading'=>'Error',
            'message'=>'Intente mas tarde.'
        );
         $this->load->view('errors/html/error_general',$data);
    }
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
        'materias'=>$materias,
        'controller'=>$this
      );
      $this->load->view('alumno/header');
        $this->load->view('alumno/calificacion/index',$data);
        $this->load->view('alumno/footer');
    }

    public function calificacion($idhorario,$idhorariodetalle)
    {
      # code... 
      Permission::grant(uri_string());
      $idhorario = $this->decode($idhorario);
      $idhorariodetalle = $this->decode($idhorariodetalle);
      if((isset($idhorario) && !empty($idhorario)) && (isset($idhorariodetalle) && !empty($idhorariodetalle))){
      $detalle  = $this->alumno->detalleClase($idhorariodetalle);
      $nombreclase = $detalle[0]->nombreclase; 
      $data = array(
        'tabla'=>$this->obtenerCalificacion($idhorario,$idhorariodetalle),
        'nombreclase' => $nombreclase
      );
     


        $this->load->view('alumno/header');
        $this->load->view('alumno/calificacion/calificacion',$data);
        $this->load->view('alumno/footer');
          }else{
        $data = array(
            'heading'=>'Error',
            'message'=>'Error intente mas tarde.'
        );
         $this->load->view('errors/html/error_general',$data);
    }
    }
     public function asistencia($idhorario,$idhorariodetalle)
    {
      # code... 
      Permission::grant(uri_string());
      $idhorario = $this->decode($idhorario);
      $idhorariodetalle = $this->decode($idhorariodetalle);
      if((isset($idhorario) && !empty($idhorario)) && (isset($idhorariodetalle) && !empty($idhorariodetalle))){
      $detalle  = $this->alumno->detalleClase($idhorariodetalle);
      $nombreclase = $detalle[0]->nombreclase; 
      $idalumno = $this->session->idalumno;
      $datafin = $this->alumno->ultimaFechaAsistencia($idalumno,$idhorariodetalle);
      $datainicio = $this->alumno->primeraFechaAsistencia($idalumno,$idhorariodetalle);
     
      //if($datafin != false && $datainicio != false){
      //  $tabla = $this->obetnerAsistencia($idhorario,$datainicio->fecha,$datafin->fecha,$idhorariodetalle);
      //}else{
          $tabla = $this->obetnerAsistencia($idhorario,date("Y-m-d"),date("Y-m-d"),$idhorariodetalle);
      //}
      $motivos = $this->alumno->showAllMotivoAsistencia();
      $data = array(
        //'tabla'=>$this->obtenerCalificacion($idhorario,$idhorariodetalle)
        'tabla'=>$tabla,
        'nombreclase'=>$nombreclase,
        'idhorario'=>$idhorario,
        'idhorariodetalle'=>$idhorariodetalle,
        'motivos'=>$motivos,
        'controller'=>$this
      );
      $this->load->view('alumno/header');
        $this->load->view('alumno/calificacion/asistencia',$data);
        $this->load->view('alumno/footer');

           }else{
        $data = array(
            'heading'=>'Error',
            'message'=>'Error intente mas tarde.'
        );
         $this->load->view('errors/html/error_general',$data);
    }
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
     $total_unidades =0;
      $tabla ="";
       $tabla .= '<table class="table table-bordered table-hover">
      <thead>
      <th>#</th>
      <th>Nombre de Materia</th>';
       foreach($unidades as $block):
        $total_unidades +=1;
        $tabla .= '<th><strong>'.$block->nombreunidad.'</strong></th>';
       endforeach; 
      $tabla .= '<th>C. Final</th>';
      $tabla .= '</thead>';
      $c = 1;
      if (isset($materias) && !empty($materias)) {
        $suma_calificacion = 0;
      foreach($materias as $row){
        //$alumn = $al->getAlumn();
      $suma_calificacion = 0;
        $tabla .= '<tr>
        <td>'.$c++.'</td>
        <td><strong>'.$row->nombreclase.'</strong><br><small>( '.$row->nombre.' '.$row->apellidop.' '.$row->apellidom.'</small>)</td>';
      foreach($unidades as $block):
      $val = $this->grupo->obtenerCalificacion($idalumno, $block->idunidad, $row->idhorariodetalle);
      
        $tabla .= '<td>';
        if($val != false ){ 
          $suma_calificacion = $suma_calificacion + $val->calificacion;
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
      $tabla .= '<td>';
      $calificacion_final = number_format($suma_calificacion / $total_unidades,2);
      if(validar_calificacion($calificacion_final)){
      $tabla .='<label style="color:red;">'.number_format($suma_calificacion / $total_unidades,2).'</label>'; 
      }else{
          $tabla .='<label style="color:green;">'.number_format($suma_calificacion / $total_unidades,2).'</label>'; 
      }
      $tabla .= '</td>';
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
      
       $datelle_alumno = $this->alumno->showAllMateriasAlumno($idalumno,1);
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
            <label class="nombreplantel">'.$detalle_logo[0]->nombreplantel.'</label><br>
            <label class="txtn">'.$detalle_logo[0]->asociado.'</label><br>
            <label class="direccion">'.$detalle_logo[0]->direccion.'</label><br>
            <label class="telefono">TELÉFONO: '.$detalle_logo[0]->telefono.'</label>
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
  $idtarea = $this->decode($idtarea);
  if(isset($idtarea) && !empty($idtarea)){
        $detalle_tarea = $this->mensaje->detalleTarea($idtarea);
        //var_dump($detalle_tarea);
        $data = array(
          'tarea'=>$detalle_tarea
        );
        $this->load->view('alumno/header');
        $this->load->view('alumno/detalle/tarea',$data);
        $this->load->view('alumno/footer');
          }else{
         $data = array(
            'heading'=>'Error',
            'message'=>'Error intente mas tarde.'
        );
         $this->load->view('errors/html/error_general',$data);
    }
}
public function detallemensaje($idmensaje = '')
{
        $idmensaje = $this->decode($idmensaje);
        if(isset($idmensaje) && !empty($idmensaje)){
        $detalle_mensaje = $this->mensaje->detalleMensaje($idmensaje);
        //var_dump($detalle_tarea);
        $data = array(
          'mensaje'=>$detalle_mensaje
        );
        $this->load->view('alumno/header');
        $this->load->view('alumno/detalle/mensaje',$data);
        $this->load->view('alumno/footer');
         }else{
         $data = array(
            'heading'=>'Error',
            'message'=>'Error intente mas tarde.'
        );
         $this->load->view('errors/html/error_general',$data);
    }
}


function obtenerCalificacionFinal($idalumno = '')
{
  $periodos = $this->alumno->obtenerPeriodo($idalumno);
  $total_periodo = 0;
  if($periodos){
      foreach($periodos as $row){
        $total_periodo += 1;
        $idperiodo = $row->idperiodo;
        $idgrupo = $row->idgrupo;
        $idhorario = $row->idhorario;
        $idplantel = $row->idplantel;
      }
  }
}

}
