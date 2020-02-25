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
        date_default_timezone_set("America/Mexico_City");

    }
 
    public function index()
    {
         Permission::grant(uri_string());
        $this->load->view('alumno/header');
        $this->load->view('alumno/index');
        $this->load->view('alumno/footer');

    }
    public function kardex()
    {

      # code...
        $idalumno = $this->session->idalumno;
        $kardex = $this->alumno->allKardex($this->session->idalumno);
        $data = array('kardex' => $kardex,'id'=>$idalumno );
          $this->load->view('alumno/header');
        $this->load->view('alumno/kardex/index',$data);
        $this->load->view('alumno/footer');  
    }
    public function horario()
    {
      # code...
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
          $tabla .='<label>'.$val->calificacion.'</label>'; 
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

public function historial($idhorario='')
{
 
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
            'calificacion'=>$calificacion
        );
        $this->load->view('alumno/header');
        $this->load->view('alumno/kardex/kardex',$data);
        $this->load->view('alumno/footer');
        
}
 

}
