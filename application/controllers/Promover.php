<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("America/Mexico_City");
class Promover extends CI_Controller {
 
  function __construct() {
        parent::__construct(); 
        if (!isset($_SESSION['user_id'])) {
            $this->session->set_flashdata('flash_data', 'You don\'t have access! ss');
            return redirect('welcome');

        }
        $this->load->helper('url');
        $this->load->model('profesor_model','profesor'); 
        $this->load->model('alumno_model','alumno'); 
        $this->load->model('grupo_model','grupo'); 
        $this->load->model('horario_model','horario');
        $this->load->model('cicloescolar_model','cicloescolar'); 
        $this->load->model('data_model'); 
        $this->load->library('permission');
        $this->load->library('session'); 
         $this->promedio_minimo = 7.00;
       
    }

	public function index()
	{
        Permission::grant(uri_string());
         $cicloescolar_activo = $this->cicloescolar->showAllCicloEscolarActivo($this->session->idplantel);
         $data = array(
            'cicloescolar' => $cicloescolar_activo, 
            'grupos'=>$this->alumno->showAllGrupos($this->session->idplantel),
        );
		$this->load->view('admin/header');
		$this->load->view('admin/promover/index',$data);
		$this->load->view('admin/footer');
	}

   
    public function buscar()
    { 
        $config = array(
            array(
                'field' => 'grupo',
                'label' => 'planeacion',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Seleccione el Grupo.'
                )
            ),
            array(
                'field' => 'cicloescolar',
                'label' => 'Modelo',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Seleccione el Ciclo Escolar.'
                )
            ) 
        );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            $errors = validation_errors();
        echo json_encode(['error'=>$errors]);
        } else {
          $idgrupo =  $this->input->post('grupo');
          $idclicloescolar =  $this->input->post('cicloescolar');
          $alumnos = $this->alumno->listaAlumnoPorGrupo($idgrupo,$this->session->idplantel);
          $tabla = '';
          if (isset($alumnos) && !empty($alumnos)) {
             $tabla .= ' <table class="table table-striped">
                    <thead>
                      <tr> 
                        <th>Nombre de Alumno</th>
                        <th>Calificación del Nivel</th>
                        <th>Estatus</th>
                        <th align="center">M. Reprobadas</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody> ';
              foreach ($alumnos as $value) {
                  $tabla .='<tr><td>'.$value->apellidop.' '.$value->apellidom.' '.$value->nombre.'</td>';
                   $tabla .='<td><strong>'.number_format($value->calificacion,2).'</strong></td>';
                   $tabla .='<td>';
                    if($value->calificacion > $this->promedio_minimo){
                    $tabla .='<label style="color:green;">APROVADO</label>';
                    }else{
                         $tabla .='<label style="color:red;">NO PROVADO</label>';
                    }
                   $tabla .='</td>';
                   $tabla .='<td align="center">';
                   $datos_calificacion = $this->alumno->obtenerCalificacionAlumno($value->idalumno,$idgrupo,$this->session->idplantel);
                   if(isset($datos_calificacion) && !empty($datos_calificacion)){
                   $total = 0;
                   foreach ($datos_calificacion as  $row) {
                      if($row->calificacionfinal <= $this->promedio_minimo){
                        $total = $total + 1;
                      }
                   }
                   if($total > 0){
                    $tabla .='<label style="color:red;">'.$total.'</label>';
                   }else{
                    $tabla .='<label style="color:green;">0</label>';

                   }

                 }else{
                  $tabla .='<label style="color:green;">0</label>';
                 }
                   $tabla .='</td>';
                   $tabla .='<td align="right"><a  href="javascript:void(0)" class="edit_button btn btn-info"  data-toggle="modal"
                                  data-idalumno="'.$value->idalumno.'"
                                  data-idhorario="'.$value->idhorario.'"
                                   data-alumno="'.$value->apellidop.' '.$value->apellidom.' '.$value->nombre.'"
                                  data-idgrupo="'.$idgrupo.'"  title="Ver Calificaciones">Detalle</a></td>
                   </tr>';
              }
              $tabla .=' </tbody>
                  </table>';
          }
          // $tabla = '
          // <table><tr><td>ddd</td></tr></table>';
               echo json_encode(['success'=>'Ok','tabla'=>$tabla]);
            
        } 
    }

public function calificaciones()
{
    $idalumno =  $this->input->post('idalumno');
    $idhorario =  $this->input->post('idhorario');
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
          if($val->calificacion <= $this->promedio_minimo){
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
     // return $tabla;
       echo json_encode(['success'=>'Ok','tabla'=>$tabla]);
}

}
