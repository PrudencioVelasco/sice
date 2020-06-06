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
        $this->load->model('mensaje_model','mensaje'); 
        $this->load->library('encryption');
	}
 
	public function index()
	{ 
          Permission::grant(uri_string());
          $idalumno = $this->session->idalumno;
          $grupo = $this->alumno->obtenerGrupo($idalumno);
          $tareas = "";
          $mensajes = "";
          if($grupo != false){
             $idhorario= $grupo->idhorario;
             $tareas = $this->alumno->showTareaAlumnoMateria($idhorario);
             $mensajes = $this->mensaje->showAllMensajeAlumno($idhorario);
          }
         
         //var_dump($mensajes);
          $data = array(
            'tareas'=>$tareas,
            'mensajes'=>$mensajes,
            'controller'=>$this
          );
         // var_dump($tareas);

	      $this->load->view('alumno/header');
        $this->load->view('alumno/index',$data);
        $this->load->view('alumno/footer');

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
}
