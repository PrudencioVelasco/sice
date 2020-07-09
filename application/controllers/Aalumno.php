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
        $this->load->model('configuracion_model','configuracion'); 
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
       $idalumno = $this->decode($idalumno);
          $idhorario = $this->decode($idhorario);
          if((isset($idhorario) && !empty($idhorario)) && (isset($idalumno) && !empty($idalumno))){
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
          <table width="600" border="0" cellpadding="2" cellspacing="0">
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
  </table> <br/><br/>';

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
    
     foreach($lunesAll as $row){
        $tabla .= '<tr>';
                  $tabla .= '<td width="65" class="txthorario">'.$row->hora.'</td>';
                  $tabla .= '<td width="93" class="txthorario">'.$row->lunes.'</td>';
                  $tabla .= '<td  width="93"class="txthorario">'.$row->martes.'</td>';
                  $tabla .= '<td  width="93"class="txthorario">'.$row->miercoles.'</td>';
                  $tabla .= '<td width="93" class="txthorario">'.$row->jueves.'</td>';
                  $tabla .= '<td width="93" class="txthorario">'.$row->viernes.'</td>';
                  
            $tabla .= '</tr>';
          } 
      $tabla .= '</table>';  
      
        $pdf->writeHTML($tabla, true, false, false, false, '');

    ob_end_clean();


        $pdf->Output('Kardex de Calificaciones', 'I');
   
      //return $tabla;  
      }else{
        return "";
      }
      
    }
        }
            public function horarioMostrar($idhorario = '',$idalumno='')  { 
        $datelle_alumno = $this->alumno->showAllMateriasAlumno($idalumno);
        if(isset($datelle_alumno) && !empty($datelle_alumno)){ 
        
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
                  $tabla .= '<td   >Hora</td>';
                  $tabla .= '<td   >Lunes</td>';
                  $tabla .= '<td  >Martes</td>';
                  $tabla .= '<td >Miercoles</td>';
                  $tabla .= '<td  >Jueves</td>';
                  $tabla .= '<td  >Viernes</td>';
                  
                  
            $tabla .= ' </thead>';
          $array_materias_reprobadas= array();
      $materias_reprobadas = $this->alumno->obtenerTodasMateriaReprobadasActivas($idalumno);
      if(isset($materias_reprobadas) && !empty($materias_reprobadas)){
        foreach($materias_reprobadas as $row){
            array_push($array_materias_reprobadas,$row->idmateriaprincipal);
        }
      }
      $reprobadas  = implode(",",$array_materias_reprobadas);
      
            $lunesAll = $this->horario->showAllDiaHorarioSinDua($idhorario,$reprobadas);
       
    
     foreach($lunesAll as $row){
        $tabla .= '<tr>';
                  $tabla .= '<td  ><strong>'.$row->hora.'</strong></td>';
                  $tabla .= '<td >'.$row->lunes.'</td>';
                  $tabla .= '<td  >'.$row->martes.'</td>';
                  $tabla .= '<td >'.$row->miercoles.'</td>';
                  $tabla .= '<td  >'.$row->jueves.'</td>';
                  $tabla .= '<td >'.$row->viernes.'</td>';
                  
            $tabla .= '</tr>';
          } 
      $tabla .= '</table>';   
   
       return $tabla;  
      }else{
        return "";
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
      $tabla = $this->horarioMostrar($idhorario,$idalumno);
      $materias_repetir =$this->horario->materiasARepetir($idalumno); 
      $data = array(
        'idhorario'=>$idhorario,
        'idalumno'=>$idalumno,
        'controller'=>$this,
        'tabla'=>$tabla,
        'materias_repetir'=>$materias_repetir

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
       $tabla .= '<table class="table  table-hover">
      <thead class="bg-teal">
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
        
        $tabla .= '<table id="tablageneral2" class="table table-striped  dt-responsive nowrap" cellspacing="0" width="100%">
           <thead class="bg-teal">
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
          $array_materias_reprobadas= array();
      $materias_reprobadas = $this->alumno->obtenerTodasMateriaReprobadasActivas($idalumno);
      if(isset($materias_reprobadas) && !empty($materias_reprobadas)){
        foreach($materias_reprobadas as $row){
            array_push($array_materias_reprobadas,$row->idmateriaprincipal);
        }
      }
      $reprobadas  = implode(",",$array_materias_reprobadas);
      
      $materias = $this->alumno->showAllMaterias($idhorario,$reprobadas);
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
 public function obtenerCalificacionSecundaria($idhorario='',$idalumno = '')
    {
      # code...
      Permission::grant(uri_string());
      $unidades =  $this->grupo->unidades($this->session->idplantel);
      $materias = $this->alumno->showAllMateriasPasadas($idhorario); 
      $datoshorario = $this->horario->showNivelGrupo($idhorario); 
      $idnivelestudio =$datoshorario->idnivelestudio;
      $oportunidades_examen = $this->alumno->showAllOportunidadesExamen($this->session->idplantel);
           
      $detalle_configuracion = $this->configuracion->showAllConfiguracion($this->session->idplantel,$idnivelestudio);
     $total_unidades =0;
     $total_materia = 0;
        if ($materias != FALSE) { 
            foreach ($materias as $row) {
                # code...
                $total_materia = $total_materia + 1;
            }
         
        } 
      $tabla ="";
       $tabla .= '<table class="table  table-striped  table-hover">
        <thead class="bg-teal">
      <th>NO.</th>
      <th>MATERIA</th>
         <th>CRÉDITO</th>'; 
      $tabla .= '<th>CALIFICACIÓN</th>';
      $tabla .= '</thead>';
      $c = 1;
      
          foreach($materias as $row){
            $idhorariodetalle = $row->idhorariodetalle;
            $calificacion = 0;
            foreach($oportunidades_examen as $oportunidad){
              $idoportunidadexamen = $oportunidad->idoportunidadexamen;
              $detalle_calificacion = $this->alumno->calificacionSecuPrepa($idalumno,$idhorariodetalle,$idoportunidadexamen);
               if($detalle_calificacion && $calificacion == 0){
                  $calificacion .= $detalle_calificacion[0]->calificacion;
                  
               }
               
            }
              $tabla .= '<tr>';
                $tabla .= '<td>'.$c++.'</td>';
               $tabla .= '<td>'.$row->nombreclase.'</td>';
                 $tabla .= '<td>'.$row->credito.'</td>';
               $tabla .= '<td>';
               if($detalle_configuracion[0]->calificacion_minima < $calificacion){
                  $tabla .= '<label>'.number_format($calificacion,2).'</label>';
               }else{
                  $tabla .= '<label>NA</label>';
               }
               
               $tabla.='</td>';
                $tabla .= '</tr>';
          }
      
      $tabla .= '</table>';
      return $tabla;

    }
    public function obtenerCalificacion2($idhorario='',$idalumno = '')
    {
      # code...
      Permission::grant(uri_string());
     $unidades =  $this->grupo->unidades($this->session->idplantel);
           $array_materias_reprobadas= array();
      $materias_reprobadas = $this->alumno->obtenerTodasMateriaReprobadasActivas($idalumno);
      if(isset($materias_reprobadas) && !empty($materias_reprobadas)){
        foreach($materias_reprobadas as $row){
            array_push($array_materias_reprobadas,$row->idmateriaprincipal);
        }
      }
      $reprobadas  = implode(",",$array_materias_reprobadas);
      
     $materias = $this->alumno->showAllMaterias($idhorario,$reprobadas); 
      $datoshorario = $this->horario->showNivelGrupo($idhorario); 
      $idnivelestudio =$datoshorario->idnivelestudio;

     $detalle_configuracion = $this->configuracion->showAllConfiguracion($this->session->idplantel,$idnivelestudio);
     $total_unidades =0;
     $total_materia = 0;
        if ($materias != FALSE) { 
            foreach ($materias as $row) {
                # code...
                $total_materia = $total_materia + 1;
            }
         
        } 
      $tabla ="";
       $tabla .= '<table class="table  table-striped  table-hover">
        <thead class="bg-teal">
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
        <td>';
        if($row->opcion == 0){
            $tabla .='<label style="color:red;">R: </label>';
        }
        $tabla .='<strong>'.$row->nombreclase.'</strong><br><small>( '.$row->nombre.' '.$row->apellidop.' '.$row->apellidom.'</small>)</td>';
      foreach($unidades as $block):
      $val = $this->grupo->obtenerCalificacion($idalumno, $block->idunidad, $row->idhorariodetalle);
      
        $tabla .= '<td>';
        if($val != false ){ 
          $suma_calificacion = $suma_calificacion + $val->calificacion;
          if(validar_calificacion($val->calificacion,$detalle_configuracion[0]->calificacion_minima)){
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
      if(validar_calificacion($calificacion_final,$detalle_configuracion[0]->calificacion_minima)){
        if($suma_calificacion > 0.0){
           $tabla .='<label style="color:red;">'.number_format($suma_calificacion / $total_unidades,2).'</label>'; 
        }else{
              $tabla .='<label "> </label>'; 
        }
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
public function obtenerCalificacionPrimaria($idhorario='',$idalumno = '')
    {
      # code...
      Permission::grant(uri_string());
      $idplantel =   $this->session->idplantel; 
      $datoshorario = $this->horario->showNivelGrupo($idhorario); 
      $idnivelestudio =$datoshorario->idnivelestudio;

      $detalle_configuracion = $this->configuracion->showAllConfiguracion($this->session->idplantel,$idnivelestudio);
      $calificaciones = $this->alumno->calificacionFinalPrimaria($idalumno,$idhorario,$idplantel);
       $tabla ="";
       $tabla .= '<table class="table  table-striped  table-hover">
        <thead class="bg-teal">
         <th>#</th>
        <th>Nombre de Materia</th>'; 
      $tabla .= '<th>C. Final</th>';
      $tabla .= '</thead>';
      $c = 1;
     
      foreach($calificaciones as $row){
         $tabla .='<tr>';
          $tabla .='<td>'.$c++.'</td>';
          $tabla .='<td>'.$row->nombreclase.'</td>';
         
          if($row->calificacion < $detalle_configuracion[0]->calificacion_minima){
             $tabla .='<td><strong>NA</strong></td>';
          }else{
             $tabla .='<td>'.$row->calificacion.'</td>';
          }
            $tabla .='</tr>'; 
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
public function actual()
  {
    $idalumno = $this->session->idalumno;
      $idhorario="";
      $grupo = $this->alumno->obtenerGrupo($idalumno);
      if($grupo != false){
        $idhorario= $grupo->idhorario;
      }
      
      if($idhorario != ""){
      
          $idalumno = $this->session->idalumno;
        $calificacion = "";
        $tabla = $this->obtenerCalificacion2($idhorario,$idalumno);

        //$tabla = $this->obtenerCalificacionSecundaria($idhorario,$idalumno);
        $datosalumno = $this->alumno->showAllAlumnoId($idalumno);
        $datoshorario = $this->horario->showNivelGrupo($idhorario);
             $array_materias_reprobadas= array();
      $materias_reprobadas = $this->alumno->obtenerTodasMateriaReprobadasActivas($idalumno);
      if(isset($materias_reprobadas) && !empty($materias_reprobadas)){
        foreach($materias_reprobadas as $row){
            array_push($array_materias_reprobadas,$row->idmateriaprincipal);
        }
      }
      $reprobadas  = implode(",",$array_materias_reprobadas);
      
        $materias = $this->alumno->showAllMaterias($idhorario,$reprobadas);
        $unidades =  $this->grupo->unidades($this->session->idplantel);
        $idnivelestudio =$datoshorario->idnivelestudio;
        $idniveleducativo = $datoshorario->idniveleducativo;
        $detalle_configuracion = $this->configuracion->showAllConfiguracion($this->session->idplantel,$idnivelestudio);
        $idperiodo = $datoshorario->idperiodo;
        $alumno_grupo = $this->grupo->detalleAlumnoGrupo($idalumno,$idperiodo);
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
         $detalle_calificacion = $this->alumno->calificacionAlumno($idalumno,$idhorario);
         $total_aprovadas = 0;
         $total_reprovadas = 0; 
         if($detalle_calificacion){
            foreach($detalle_calificacion  as $row){
              if(validar_calificacion($row->calificacion,$detalle_configuracion[0]->calificacion_minima)){
                //REPROVADAS
                $total_reprovadas += 1;
              }else{
                //APROBADAS
                 $total_aprovadas += 1;
              }
          }
        } 
        $calificacion_minima = $detalle_configuracion[0]->calificacion_minima;
        $reprovatorio_permitido = $detalle_configuracion[0]->reprovandas_minima;
        $estatus_alumno = calcularReprovado($idnivelestudio,$idniveleducativo,$total_materia,$total_aprovadas,$total_reprovadas,$reprovatorio_permitido,$calificacion,$calificacion_minima);
          $mostrar_estatus = mostrarReprovado($idnivelestudio,$idniveleducativo,$total_materia,$total_aprovadas,$total_reprovadas,$reprovatorio_permitido,$calificacion,$calificacion_minima);
        
           $data = array(
            'idhorario'=>$idhorario,
            'idalumno'=>$idalumno,
            'tabla'=>$tabla,
            'datosalumno'=>$datosalumno,
            'datoshorario'=>$datoshorario,
            'calificacion'=>$calificacion,
            'controller'=>$this,
            'estatus_nivel'=>$estatus_alumno,
            'total_reprobados'=>$total_reprovadas,
            'nivel_educativo'=>$idniveleducativo,
            'mostrar_estatus'=>$mostrar_estatus
        );
        $this->load->view('alumno/header');
        $this->load->view('alumno/kardex/calificacion',$data);
        $this->load->view('alumno/footer');
      }else{
      $data = array(
            'idhorario'=>$idhorario
        );
        $this->load->view('alumno/header');
        $this->load->view('alumno/kardex/calificacion',$data);
        $this->load->view('alumno/footer');
      }
  }
public function historial($idhorario='')
{
 Permission::grant(uri_string());
 $idhorario = $this->decode($idhorario);
 if(isset($idhorario) && !empty($idhorario)){
        $idalumno = $this->session->idalumno; 
        $datosalumno = $this->alumno->showAllAlumnoId($idalumno);
        $datoshorario = $this->horario->showNivelGrupo($idhorario);
        $materias = $this->alumno->showAllMaterias($idhorario);
       // $unidades =  $this->grupo->unidades($this->session->idplantel);
        $idnivelestudio =$datoshorario->idnivelestudio;
        $idniveleducativo = $datoshorario->idniveleducativo;
        $detalle_configuracion = $this->configuracion->showAllConfiguracion($this->session->idplantel,$idnivelestudio);
        
        //$alumno_grupo = $this->grupo->detalleAlumnoGrupo($idalumno,$idperiodo);
        if($idniveleducativo == 1){
          //PRIMARIA
           //$tabla = $this->obtenerCalificacionPrimaria($idhorario,$idalumno);
           $tabla = $this->obtenerCalificacionPrimaria($idhorario,$idalumno);
        }
        if($idniveleducativo == 2){
          //SECUNDARIA
           $tabla = $this->obtenerCalificacionSecundaria($idhorario,$idalumno);
        }
        if($idniveleducativo == 3){
          //PREPARATORIA
        }
       
        //CODIGO PARA OBTENER LA CALIFICACION DEL NIVEL
       $oportunidades_examen = $this->alumno->showAllOportunidadesExamen($this->session->idplantel); 
        $total_materia = 0;
        $suma_calificacion = 0;
        foreach($materias as $row){
              $total_materia  = $total_materia +  1;
                $idhorariodetalle = $row->idhorariodetalle;
                $calificacion = 0;
                foreach($oportunidades_examen as $oportunidad){
                  $idoportunidadexamen = $oportunidad->idoportunidadexamen;
                  $detalle_calificacion = $this->alumno->calificacionSecuPrepa($idalumno,$idhorariodetalle,$idoportunidadexamen);
                  if($detalle_calificacion && $calificacion == 0){
                    if($detalle_calificacion[0]->calificacion >= $detalle_configuracion[0]->calificacion_minima){
                      $calificacion .= $detalle_calificacion[0]->calificacion;
                      $suma_calificacion += $calificacion;
                    }
                  } 
                }
              }
          $calificacion = 0;
          $calificacion =  $suma_calificacion / $total_materia; 
        //FIN DEL CODIGO PARA OBTENER LA CALIFICACION DEL NIVEL
           $data = array(
            'idhorario'=>$idhorario,
            'idalumno'=>$idalumno,
            'tabla'=>$tabla,
            'datosalumno'=>$datosalumno,
            'datoshorario'=>$datoshorario,
            'calificacion'=>$calificacion,
            'controller'=>$this, 
            //'total_reprobados'=>$total_reprovadas,
            'nivel_educativo'=>$idniveleducativo,
            
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
 public function oportunidades($idalumno,$idhorario){
    if((isset($idhorario) && !empty($idhorario)) && (isset($idalumno) && !empty($idalumno))){
        $detalle_calificacion = $this->alumno->calificacionAlumno($idalumno,$idhorario);
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
