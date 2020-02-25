<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("America/Mexico_City");
class Alumnos extends CI_Controller {
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
	}
 
	public function index()
	{ 
         Permission::grant(uri_string());
          $idalumno = $this->session->idalumno;
          $grupo = $this->alumno->obtenerGrupo($idalumno);
          $tareas = "";
          if($grupo != false){
            $idhorario= $grupo->idhorario;
             $tareas = $this->alumno->showTareaAlumnoMateria($idhorario);
          }
         
         
          $data = array(
            'tareas'=>$tareas
          );
         // var_dump($tareas);

	    $this->load->view('alumno/header');
        $this->load->view('alumno/index',$data);
        $this->load->view('alumno/footer');

	} 
}
