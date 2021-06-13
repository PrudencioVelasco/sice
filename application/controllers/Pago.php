<?php

defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("America/Mexico_City");

class Pago extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        if (!isset($_SESSION['user_id'])) {
            $this->session->set_flashdata('flash_data', 'You don\'t have access! ss');
            return redirect('welcome');
        }
        $this->load->helper('url');
        $this->load->model('Pago_model', 'pagos');
        $this->load->model('data_model');
        $this->load->library('permission');
        $this->load->library('session');
        $this->load->library('pdfgenerator');
    }

    public function inicio()
    {
        //Permission::grant(uri_string());
        $this->load->view('admin/header');
        $this->load->view('admin/pago/index');
        $this->load->view('admin/footer');
    }

    public function showAllAlumnos()
    {
        $idplantel = $this->session->idplantel;
        $query = $this->pagos->showAllAlumnos($idplantel);
        if ($query) {
            $result['alumnos'] = $this->pagos->showAllAlumnos($idplantel);
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }
    public function detalleAlumno()
    {
        $idalumno = $this->input->get('idalumno');
        $query = $this->pagos->alumnoActivo($idalumno);
        if ($query) {
            $result['alumno'] = $this->pagos->alumnoActivo($idalumno);
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }
    public function showAllFormaPago()
    {
        $query = $this->pagos->showAllFormaPago();
        if ($query) {
            $result['formapagos'] = $this->pagos->showAllFormaPago();
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }
    public function pagosAlumno()
    {
        # code...
        $idplantel = $this->session->idplantel;
        $idalumno = $this->input->get('idalumno');
        $do = array();
        $usersList_array = array();
        $detalle_alumno = $this->pagos->alumnoActivo($idalumno);
        //var_dump($detalle_alumno);
        $idnivelestudio = $detalle_alumno->idnivelestudio;
        $conceptos = $this->pagos->showConceptosSinColegiatura($idnivelestudio, $idplantel);
        if (isset($conceptos) && !empty($conceptos)) {
            foreach ($conceptos as $row) {
                $do['idconcepto'] = $row->idtipopagocol;
                $do['concepto'] = $row->concepto;
                $do['descuento'] = $row->descuento;
                $do['idmes'] = "";
                $do['nombremes'] = "";
                array_push($usersList_array, $do);
            }
        }
        $costo_colegiatura =  $this->pagos->descuentoDeColegiatura($idnivelestudio, $idplantel);
        if (isset($costo_colegiatura) && !empty($costo_colegiatura)) {
            $costo = $costo_colegiatura->descuento;
            $meses = $this->pagos->showMesesColegiatura();
            if (isset($meses) && !empty($meses)) {
                foreach ($meses as $mes) {
                    $do['idconcepto'] = $mes->idtipopagocol;
                    $do['concepto'] = $mes->concepto;
                    $do['descuento'] = $costo;
                    $do['idmes'] = $mes->idmes;
                    $do['nombremes'] = $mes->nombremes;
                    array_push($usersList_array, $do);
                }
            }
        }
        echo json_encode($usersList_array, JSON_PRETTY_PRINT);
    }
}
