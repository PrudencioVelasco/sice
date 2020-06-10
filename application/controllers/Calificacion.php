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
        $this->load->model('calificacion_model','calificacion'); 
        $this->load->library('permission');
        $this->load->library('session');
        $this->calificacion_minima_primaria = 7.00;
	}
 
	 public function calificacionPorNivel($idhorario='',$idalumno = '',$idplantel='')
     {
        $unidades =  $this->calificacion->unidades($idplantel);
        $materias = $this->calificacion->showAllMaterias($idhorario);
        $total_unidad = 0;
        $total_materia = 0;
        $suma_calificacion = 0; 
        $promedio = 0; 
        $c = 1;
        if (isset($materias) && !empty($materias)) { 
            foreach($unidades as $block):
            $total_unidad += 1;
        endforeach;  
        foreach($materias as $row){
        $total_materia +=1; 
        foreach($unidades as $block):
        $val = $this->calificacion->obtenerCalificacion($idalumno, $block->idunidad, $row->idhorariodetalle);
         if($val != false ){ 
            $suma_calificacion +=$val->calificacion; 
            }  
        endforeach;  
        }
        $promedio = ($suma_calificacion / $total_unidad) / $total_materia;
        }
        return $promedio;
    }
}
