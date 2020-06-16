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
        $this->load->helper('numeroatexto_helper');
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
          $alumnos = $this->alumno->listaAlumnoPorGrupo($idgrupo,$this->session->idplantel,$idclicloescolar);
          $tabla = '';
          if (isset($alumnos) && !empty($alumnos)) {
             $tabla .= ' <table class="table table-striped">
                    <thead>
                      <tr> 
                        <th>#</th>
                        <th>Alumno</th>
                        <th>C. Nivel</th>
                        <th>Estatus</th>
                        <th align="center">M. Reprobadas</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody> ';
                    $contador = 1;
              foreach ($alumnos as $value) {
                  $tabla .='<tr>';
                  $tabla .='<td>'.$contador++.'</td>';
                  $tabla .= '<td>'.$value->apellidop.' '.$value->apellidom.' '.$value->nombre.'</td>';
                   $tabla .='<td>';
                   if(validar_calificacion($value->calificacion)){
                    $tabla .='<strong style="color:red;">'.number_format($value->calificacion,2).'</strong>';
                   }else{
                     $tabla .='<strong style="color:green;">'.number_format($value->calificacion,2).'</strong>';
                   }
                    $tabla .='</td>';
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
                                  data-idgrupo="'.$idgrupo.'"  title="Ver Calificaciones"><i class="fa fa-list-ul"></i> Detalle</a></td>
                   </tr>';
              }
              $tabla .=' </tbody>
                  </table>';
               echo json_encode([
                 'success'=>'Ok',
                 'tabla'=>$tabla,
                 'idgrupo'=>$idgrupo,
                 'idcicloescolar'=>$idclicloescolar]);
          }else{
          // $tabla = '
          // <table><tr><td>ddd</td></tr></table>';
               echo json_encode([
                 'success'=>'Error',
                 'error'=>'No existe registros de Alumnos para el Grupo.']);
           }
            
        } 
    }

public function calificaciones()
{
    $idalumno =  $this->input->post('idalumno');
    $idhorario =  $this->input->post('idhorario');
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
    //$suma_calificacion = 0;
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
     // return $tabla;
       echo json_encode(['success'=>'Ok','tabla'=>$tabla]);
}

}
