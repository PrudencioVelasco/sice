<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("America/Mexico_City");
class Profesores extends CI_Controller {
 function __construct() {
        parent::__construct();

        if (!isset($_SESSION['user_id'])) {
            $this->session->set_flashdata('flash_data', 'You don\'t have access! ss');
            return redirect('welcome');
        }
        $this->load->helper('url');
        $this->load->model('data_model');
        $this->load->model('profesor_model','profesor'); 
        $this->load->library('permission');
        $this->load->library('session');
	}
 
	public function index()
	{
        Permission::grant(uri_string());
        $fecha_actual = date('Y-m-d');
        $idprofesor = $this->session->idprofesor;
        $datos = $this->profesor->showTareas($idprofesor,$fecha_actual);
        $planeaciones = $this->profesor->showPlaneaciones($idprofesor,$fecha_actual);
        //var_dump($datos);
        $data = array('tareas' =>$datos , 'planeaciones' =>$planeaciones );
	    $this->load->view('docente/header');
        $this->load->view('docente/index',$data);
        $this->load->view('docente/footer');

	} 
}
