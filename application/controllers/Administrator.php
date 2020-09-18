<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("America/Mexico_City");
class Administrator extends CI_Controller {
 
    
    function __construct() {
        parent::__construct();
        
        $this->load->helper('url');
        $this->load->model('user_model', 'usuario');
        $this->load->library('session');
        $this->load->library('encryption'); 
    }
	public function index()
	{ 
	    if ($this->session->idtipousuario == 1) {
	        //DOCENTE
	        redirect('Profesores/');
	    } elseif ($this->session->idtipousuario == 2){
	        //ADMINISTRATIVO
	        redirect('Admin/');
	    } elseif ($this->session->idtipousuario == 3){
	        //ALUMNO
	        redirect('Alumnos/');
	    } elseif ($this->session->idtipousuario == 5){
	        redirect('Tutores/');
	    } else{
		$this->load->view('loginadmin'); 
	    }

	} 
}
