<?php

defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("America/Mexico_City");

class CorteCaja extends CI_Controller {

    function __construct() {
        parent::__construct();
        if (!isset($_SESSION['user_id'])) {
            $this->session->set_flashdata('flash_data', 'You don\'t have access! ss');
            return redirect('welcome');
        }
        $this->load->helper('url');
        $this->load->library('permission');
        $this->load->library('session');
        $this->load->model('alumno_model', 'alumno');
        $this->load->model('horario_model', 'horario');
        $this->load->model('grupo_model', 'grupo');
        $this->load->model('cortecaja_model', 'cortecaja');
        $this->load->model('configuracion_model', 'configuracion');
        date_default_timezone_set("America/Mexico_City");
    }

    public function index() {
        $idrol = $this->session->idrol;
        $idplantel = $this->session->idplantel;
        $fechainicio = $this->input->post('fechainicio');
        $fechafin = $this->input->post('fechafin');
        $pagoen = $this->input->post('pagoen');
        $estatus = $this->input->post('estatus');
        $pago_inicio = '';
        $pago_mensualidad = '';
       

        if (!empty($fechainicio) && !empty($fechafin)) {
            $pago_inicio = $this->cortecaja->showAllPagoInicio($fechainicio, $fechafin, $estatus, $pagoen,$idplantel);
            $pago_mensualidad = $this->cortecaja->showAllPagoColegiaturas($fechainicio, $fechafin, $estatus, $pagoen,$idplantel);
            //var_dump($pago_mensualidad);   
        }
        $data = array(
            'pago_inicio' => $pago_inicio,
            'pago_mensualidad' => $pago_mensualidad
        );
        $this->load->view('admin/header');
        $this->load->view('admin/cortecaja/index', $data);
        $this->load->view('admin/footer');
    }

    public function buscar() {
        $fechainicio = $this->input->post('fechainicio');
        $fechafin = $this->input->post('fechafin');
        $pagoen = $this->input->post('pagoen');
        $estatus = $this->input->post('estatus');
        $pago_inicio = $this->cortecaja->showAllPagoInicio($fechainicio, $fechafin, $estatus, $pagoen);
        $tabla = '<table id="datatablereportealmacen" class="table">
                            <thead>
                                <tr>
                                   <th scope="col">ALUMNO</th>
                                   <th scope="col">FORMA PAGO</th>
                                   <th scope="col">CONCEPTO</th>
                                   <th scope="col">DESCUENTO</th>
                                   <th scope="col">AUTORIZACIÓN</th>
                                   <th scope="col">FECHA</th> 
                               </tr>
                           </thead>
                           <tbody>';
        if (isset($pago_inicio) && !empty($pago_inicio)):
            foreach ($pago_inicio as $value):
                $tabla .= '<tr>';
                $tabla .= '<td>' . $value->nombre . '</td>';
                $tabla .= '<td>' . $value->nombretipopago . '</td>';
                $tabla .= '<td>' . $value->concepto . '</td>';
                $tabla .= '<td>' . $value->descuento . '</td>';
                $tabla .= '<td>' . $value->autorizacion . '</td>';
                $tabla .= '<td>' . $value->fecha . '</td>';
                $tabla .= '</tr>';
            endforeach;
        endif;
        $tabla .= '</tbody>
                </table>';
        echo $tabla;
    }

}
