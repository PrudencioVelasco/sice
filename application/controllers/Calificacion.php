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

}
