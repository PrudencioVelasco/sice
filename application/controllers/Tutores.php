<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("America/Mexico_City");
class Tutores extends CI_Controller {
 function __construct() {
        parent::__construct();

        if (!isset($_SESSION['user_id'])) {
            $this->session->set_flashdata('flash_data', 'You don\'t have access! ss');
            return redirect('welcome');
        }
        $this->load->helper('url');
        $this->load->model('data_model'); 
        $this->load->library('permission');
        $this->load->library('session');
        $this->load->model('alumno_model','alumno'); 
          $this->load->model('grupo_model','grupo'); 
	}
 
	public function index()
	{ 

	    $this->load->view('tutor/header');
        $this->load->view('tutor/index');
        $this->load->view('tutor/footer');

	} 
    public function alumnos()
    {
        $alumnos = $this->alumno->showAllAlumnosTutorActivos($this->session->idtutor);
        $data = array(
            'alumnos'=>$alumnos
        );
        $this->load->view('tutor/header');
        $this->load->view('tutor/alumnos/index',$data);
        $this->load->view('tutor/footer');
    }
    public function materias($idalumno='')
    {
        $materias = $this->alumno->showAllMateriasAlumno($idalumno);
        $alumno = $this->alumno->detalleAlumno($idalumno);
         $data = array(
            'materias'=>$materias,
            'alumno'=>$alumno,
            'idalumno'=>$idalumno
        );
        $this->load->view('tutor/header');
        $this->load->view('tutor/alumnos/materias',$data);
        $this->load->view('tutor/footer');
    }
     public function obtenerCalificacion($idhorario='',$idhorariodetalle = '', $idalumno = '')
    {
      # code...
     $unidades =  $this->grupo->unidades($this->session->idplantel);
     $alumnos = $this->grupo->alumnosGrupo($idhorario);
     
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
      if (isset($alumnos) && !empty($alumnos)) {
      foreach($alumnos as $row){
        //$alumn = $al->getAlumn();
      
        $tabla .= '<tr>
        <td>'.$c++.'</td>
        <td>'.$row->apellidop." ".$row->apellidom." ".$row->nombre.'</td>';
      foreach($unidades as $block):
      $val = $this->grupo->obtenerCalificacion($row->idalumno, $block->idunidad, $idhorariodetalle);
      
        $tabla .= '<td>';
        if($val != false ){  
          $tabla .='<label>'.$val->calificacion.'  </label>'; 
          $tabla .='  <a  href="javascript:void(0)"><i class="fa fa-pencil edit_button"  data-toggle="modal" data-target="#myModal"
          data-idcalificacion="'.$val->idcalificacion.'"
          data-calificacion="'.$val->calificacion.'"
          data-alumno="'.$row->apellidop." ".$row->apellidom." ".$row->nombre.'"
         style = "color:blue;" title="Editar Calificación"></i> </a>';
          $tabla .=' <a  href="javascript:void(0)"><i class="fa fa-trash delete_button"  data-toggle="modal" data-target="#myModalDelete"
          data-idcalificacion="'.$val->idcalificacion.'"
          data-calificacion="'.$val->calificacion.'"
          data-alumno="'.$row->apellidop." ".$row->apellidom." ".$row->nombre.'"
         style = "color:red;" title="Eliminar Calificación"></i> </a>';
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
    public function examen($idhorario='',$idhorariodetalle = '',$idalumno = '')
    {
      $unidades =  $this->grupo->unidades($this->session->idplantel);
      $alumns = $this->grupo->alumnosGrupo($idhorario);
      $detalle = $this->grupo->detalleClase($idhorariodetalle);
      //var_dump($detalle);
      $nombreclase = $detalle[0]->nombreclase;
     // echo $this->obtenerCalificacion($idhorario,$idhorariodetalle);
      $data = array(
        'alumnos'=>$alumns,
        'idhorario'=>$idhorario,
        'idhorariodetalle'=>$idhorariodetalle,
        'unidades'=>$unidades,
        'nombreclase'=>$nombreclase,
        'tabla' => $this->obtenerCalificacion($idhorario,$idhorariodetalle,$idalumno)
      );

       $this->load->view('docente/header');
        $this->load->view('docente/grupo/examen',$data);
        $this->load->view('docente/footer');

    }
}
