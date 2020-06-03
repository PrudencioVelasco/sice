<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("America/Mexico_City");
class Welcome extends CI_Controller {
 
	   function __construct() {
        parent::__construct(); 

        $this->load->helper('url');
        $this->load->model('user_model','usuario');  
        $this->load->library('session'); 
    }

	public function index()
	{
		//$this->logout();
		$this->load->view('login');
	} 
	public function alumno()
	{
		# code...
				//load session library
		$this->load->library('session');
 
		$output = array('error' => false);
 
		$matricula = $_POST['matricula'];
		$password = $_POST['password'];
 
		$result = $this->usuario->loginAlumno($matricula);
 
		if($result){
			if (password_verify($password, $result->password)) {
			 $this->session->set_userdata([
                    'user_id' => $result->id,
                    'idalumno' => $result->idalumno,
                    'nombre' => $result->nombre,
                    'apellidop' => $result->apellidop,
                    'apellidom' => $result->apellidom,
                    'idplantel' => $result->idplantel
                ]);
			//$this->session->set_userdata('user', $data);
			 redirect('/Alumnos/');
			}else{
				$this->session->set_flashdata('err', 'Matricula o Contraseña son incorrectos.');
                redirect('/');
			}
		}
		else{
		   $this->session->set_flashdata('err', 'Matricula o Contraseña son incorrectos.');
                redirect('/');
		}
 
		//echo json_encode($output); 


	}
		public function docente(){ 
		$this->load->library('session'); 
		$correo = $_POST['correo'];
		$password = $_POST['password'];
 
		$result = $this->usuario->loginDocente($correo); 
		if($result){ 
			if (password_verify($password, $result->password)) {
			 $this->session->set_userdata([
                    'user_id' => $result->id,
                    'idprofesor' => $result->idprofesor,
                    'nombre' => $result->nombre,
                    'apellidop' => $result->apellidop,
                    'apellidom' => $result->apellidom,
                    'idplantel' => $result->idplantel
                ]); 
			 redirect('/Profesores');
			}else{
				 $this->session->set_flashdata('err2', 'Correo o Contraseña son incorrectos.');
                redirect('/');
			}
		}
		else{
		   $this->session->set_flashdata('err2', 'Correo o Contraseña son incorrectos.');
                redirect('/');
		} 
	}
		public function tutor()
	{
		 
		$this->load->library('session'); 
		  $correo = $_POST['correo'];
		  $password = $_POST['password'];
 
		$result = $this->usuario->loginTutor($correo); 
		if($result){ 
			if (password_verify($password, $result->password)) {
			 $this->session->set_userdata([
                    'user_id' => $result->id,
                    'idtutor' => $result->idtutor,
                    'nombre' => $result->nombre,
                    'apellidop' => $result->apellidop,
                    'apellidom' => $result->apellidom,
                    'idplantel' => $result->idplantel
                ]); 
			 redirect('/Tutores');
			}else{
				 $this->session->set_flashdata('err2', 'Correo o Contraseña son incorrectos.');
                redirect('/');
			}
		}
		else{
		   $this->session->set_flashdata('err2', 'Correo o Contraseña son incorrectos.');
                redirect('/');
		} 

	}
	 
		public function admin()
	{
		# code...
				//load session library
		$this->load->library('session'); 
 
		$usuario = $_POST['usuario'];
		$password = $_POST['password'];
 
		$result = $this->usuario->loginAdmin($usuario);
 
		if($result){
			//var_dump($result);
			if (password_verify($password, $result->password)) {
			 $this->session->set_userdata([
                    'user_id' => $result->id,
                    'idpersonal' => $result->idpersonal,
                    'nombre' => $result->nombre,
                    'apellidop' => $result->apellidop,
                    'apellidom' => $result->apellidom,
                    'idplantel' => $result->idplantel,
                    'idrol'=>$result->idrol
                ]);
			//$this->session->set_userdata('user', $data);
			redirect('/Admin');
			}else{
				  $this->session->set_flashdata('err', 'Usuario o Contraseña son incorrectos.');
                redirect('/Administrator/');
			}
		}
		else{
		   $this->session->set_flashdata('err', 'Usuario o Contraseña son incorrectos.');
                redirect('/Administrator/');
		}
 
		//echo json_encode($output); 


	} 
	 public function logout() {
        // creamos un array con las variables de sesión en blanco
        $datasession = array('usuario_id' => '', 'logged_in' => '');
        // y eliminamos la sesión
        $this->session->unset_userdata($datasession);
        // redirigimos al controlador principal 
        $logout = $this->session->sess_destroy();

        redirect('/');
    }
    	 public function logouta() {
        // creamos un array con las variables de sesión en blanco
        $datasession = array('usuario_id' => '', 'logged_in' => '');
        // y eliminamos la sesión
        $this->session->unset_userdata($datasession);
        // redirigimos al controlador principal 
        $logout = $this->session->sess_destroy();

        redirect('/Administrator');
    }
}
