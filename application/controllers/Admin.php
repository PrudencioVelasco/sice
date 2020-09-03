<?php

defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("America/Mexico_City");

class Admin extends CI_Controller {

    function __construct() {
        parent::__construct();

        if (!isset($_SESSION['user_id'])) {
            $this->session->set_flashdata('flash_data', 'You don\'t have access! ss');
            return redirect('welcome');
        }
         $this->load->model('alumno_model', 'alumno');
        $this->load->helper('url');
        $this->load->model('data_model');
        $this->load->library('permission');
        $this->load->library('session');
    }

    public function index() {

        Permission::grant(uri_string());
        $idplantel = $this->session->idplantel;
        $mostrar = false;
        $query = $this->alumno->materiaPendientesAAsignar($idplantel);
       
        if ($query) {
            $mostrar = true;
        }
        $data = array(
            'mostrar' => $mostrar
        );
        $this->load->view('admin/header');
        $this->load->view('admin/index', $data);
        $this->load->view('admin/footer');
        # code...
    }

}