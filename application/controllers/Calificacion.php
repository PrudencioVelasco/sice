<?php

defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("America/Mexico_City");

class Calificacion extends CI_Controller {

    function __construct() {
        parent::__construct();

        if (!isset($_SESSION['user_id'])) {
            $this->session->set_flashdata('flash_data', 'You don\'t have access! ss');
            return redirect('welcome');
        }
        $this->load->helper('url');
        $this->load->model('data_model');
        $this->load->model('calificacion_model', 'calificacion');
        $this->load->model('cicloescolar_model', 'cicloescolar');
          $this->load->model('alumno_model', 'alumno');
        $this->load->model('grupo_model', 'grupo');
        $this->load->library('permission');
        $this->load->library('session');
    }

    function inicio() {
        $idplantel = $this->session->idplantel; 
        $data = array(
            'periodos'=> $this->cicloescolar->showAll($idplantel),
            'grupos'=> $this->grupo->showAllGrupos($idplantel),
        );
        $this->load->view('admin/header');
        $this->load->view('admin/catalogo/calificaciones/index',$data);
        $this->load->view('admin/footer');
    }
    public function obtenerCalificacionRecuperando($cicloescolar = '', $grupo = '') {
        $alumnos = $this->calificacion->listaAlumnoPorGrupo($grupo, $this->session->idplantel, $cicloescolar);
        $tabla = "";
        $tabla .= '<table  class="table table-striped dt-responsive nowrap" cellspacing="0" width="100%">
         <thead class="bg-teal"> 
          <th>#</th> 
         <th>NOMBRE</th>';
        $tabla .= '  <th>PROMEDIO</th>';
        $tabla .= '</thead>';
        $tabla .='<tr>';
        $contado = 1;
        foreach ($alumnos as $value) {
            if ($value->opcion == 1) {
                $tabla .='<td>'.$contado++.'</td>';
                 $tabla .='<td>'.$value->apellidop.' '.$value->apellidom.' '.$value->nombre.'</td>';
                $idalumno = $value->idalumno;
                $idhorario = $value->idhorario;
                $materias = $this->calificacion->showAllMateriasRecuperando($idhorario, $idalumno, $cicloescolar);
                //var_dump($materias);
                if (isset($materias) && !empty($materias)) {
                    $contado_materia = 0;
                    $suma_calificacion = 0;
                    foreach ($materias as $row) {
                        $contado_materia++;
                        $idprofesormateria = $row->idprofesormateria;
                        $calificacion = $this->calificacion->calificacionMateria($idhorario, $idalumno, $idprofesormateria);
                        if (isset($calificacion) && !empty($calificacion)) {
                            $suma_calificacion = $suma_calificacion + $calificacion[0]->calificacion;
                        }  
                    }
                    //  $suma_calificacion;
                     $promedio = number_format($suma_calificacion / $contado_materia, 2);
                     $tabla .='<td>'.$promedio.'</td>';
                }else{
                    $tabla .='<td>NO TIENE PROMEDIO.</td>';
                }
            }
        }
        $tabla .='</tr>';
        $tabla .='</table>';
        return $tabla;
    }

    public function buscar() {
        $idplantel = $this->session->idplantel;
        $cicloescolar = $this->input->post('cicloescolar');
        $grupo = $this->input->post('grupo');
        $tiporeporte = $this->input->post('tiporeporte');
        $tabla = $this->obtenerCalificacionRecuperando($cicloescolar, $grupo);
        $data = array(
            'tabla' => $tabla,
            'periodos' => $this->cicloescolar->showAll($idplantel),
            'grupos' => $this->grupo->showAllGrupos($idplantel),
        );
        $this->load->view('admin/header');
        $this->load->view('admin/catalogo/calificaciones/resultado', $data);
        $this->load->view('admin/footer');
    }

}
