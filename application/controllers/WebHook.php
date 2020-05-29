<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("America/Mexico_City");
class Webhook extends CI_Controller {
 function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('data_model');   
        $this->load->model('alumno_model','alumno'); 
        $this->load->model('grupo_model','grupo'); 
        $this->load->model('horario_model','horario');
        $this->load->model('user_model','user');
        $this->load->model('cicloescolar_model','cicloescolar');
        $this->load->model('tutor_model','tutor');
        $this->load->model('webhook_model','webhook');  
        $this->load->model('data_model');  
        $this->load->library('pdfgenerator'); 
        $this->load->library('openpayservicio');
        $this->load->library('encryption');
	}
 
	public function index()
	{ 
	    $body = @file_get_contents('php://input');
        $data = json_decode($body);
        http_response_code(200); // Return 200 OK 
	} 
 
}
