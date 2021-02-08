<?php

defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("America/Mexico_City");

class Alumnos extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        if (!isset($_SESSION['user_id'])) {
            $this->session->set_flashdata('flash_data', 'You don\'t have access! ss');
            return redirect('welcome');
        }
        $this->load->helper('url');
        $this->load->model('data_model');
        $this->load->library('permission');
        $this->load->library('session');
        $this->load->model('alumno_model', 'alumno');
        $this->load->model('Tarea_model', 'tarea');
        $this->load->model('configuracion_model', 'configuracion');
        $this->load->model('mensaje_model', 'mensaje');
        $this->load->library('encryption');
    }

    public function index()
    {
        Permission::grant(uri_string());
        $idalumno = $this->session->idalumno;
        $idplantel = $this->session->idplantel;
        $grupo = $this->alumno->obtenerGrupo($idalumno);
        $tareas = "";
        $idhorario = "";
        $mensajes = "";
        if ($grupo != false) {
            $idhorario = $grupo->idhorario;
            $fecha = date('Y-m-d', strtotime(date('Y-m-d') . "-4 days"));
            //$tareas = $this->alumno->showTareaAlumnoMateria($idhorario, $fecha); 
            //$mensajes = $this->mensaje->showAllMensajeAlumno($idhorario);
        }

        $data = array(
            'tareas' => $tareas,
            'mensajes' => $mensajes,
            'idhorario' => $idhorario,
            'controller' => $this,
            'idalumno' => $idalumno
        );

        $this->load->view('alumno/header');
        /*  if($this->session->idniveleducativo == 1){
        $this->load->view('alumno/tarea/index', $data);
        }else{
             $this->load->view('alumno/index', $data);
        } */
        $this->load->view('alumno/tarea/index', $data);
        $this->load->view('alumno/footer');
    }
    public function detalletarea($idtarea, $idhorario)
    {
        $idhorario = $this->decode($idhorario);
        if ((isset($idtarea) && !empty($idtarea)) && (isset($idhorario) && !empty($idhorario))) {
            $validar_tarea = $this->tarea->validarTareaAlumno($idtarea, $idhorario);
            if ($validar_tarea) {
                $data = array(
                    'idtarea' => $idtarea
                );
                $this->load->view('alumno/header');
                $this->load->view('alumno/tarea/detalle', $data);
                $this->load->view('alumno/footer');
            } else {
                $data = array(
                    'heading' => 'ERROR',
                    'message' => 'Ocurrio un error, intente mas tarde.',
                );
                $this->load->view('errors/html/error_general', $data);
            }
        } else {
            $data = array(
                'heading' => 'ERROR',
                'message' => 'Ocurrio un error, intente mas tarde.',
            );
            $this->load->view('errors/html/error_general', $data);
        }
    }

    function encode($string)
    {
        $encrypted = $this->encryption->encrypt($string);
        if (!empty($string)) {
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
