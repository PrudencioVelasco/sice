<?php

defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("America/Mexico_City");

class Examen extends CI_Controller {

    function __construct() {
        parent::__construct();

        if (!isset($_SESSION['user_id'])) {
            $this->session->set_flashdata('flash_data', 'You don\'t have access! ss');
            return redirect('welcome');
        }
        $this->load->helper('url');
        $this->load->model('data_model');
        $this->load->model('colegiatura_model', 'colegiatura');
        $this->load->model('unidadexamen_model', 'unidadexamen');
        $this->load->library('permission');
        $this->load->library('session');
    }

    public function inicio() {
        Permission::grant(uri_string());
        $this->load->view('admin/header');
        $this->load->view('admin/catalogo/examen/index');
        $this->load->view('admin/footer');
    }

    public function showAll() {
        $idplantel = $this->session->idplantel;
        $query = $this->unidadexamen->showAll($idplantel);
        //var_dump($query);
        if ($query) {
            $result['unidades'] = $this->unidadexamen->showAll($idplantel);
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }
        public function showAllOportunidades() {
        $idplantel = $this->session->idplantel;
        $query = $this->unidadexamen->showAllOportunidades($idplantel); 
        if ($query) {
            $result['oportunidades'] = $this->unidadexamen->showAllOportunidades($idplantel);
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function searchUnidadExamen() { 
        $value = $this->input->post('text');
        $query = $this->unidadexamen->searchUnidadExamen($value);
        if ($query) {
            $result['unidades'] = $query;
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }
        public function searchOportunidades() { 
        $value = $this->input->post('text');
        $query = $this->unidadexamen->searchOportunidades($value);
        if ($query) {
            $result['oportunidades'] = $query;
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function addUnidadExamen() {
        $config = array(
            array(
                'field' => 'nombreunidad',
                'label' => 'Nombre',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            )
        );

        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            $result['error'] = true;
            $result['msg'] = array(
                'nombreunidad' => form_error('nombreunidad')
            );
        } else {
            $idplantel = $this->session->idplantel;
            $nombreunidad = $this->input->post('nombreunidad');
            $validar = $this->unidadexamen->ultimoRegistro($idplantel);
            if ($validar) {
                $numero_ultimo = $validar[0]->numero;
                $data = array(
                    'numero' => $numero_ultimo + 1,
                    'idplantel' => $idplantel,
                    'nombreunidad' => strtoupper($nombreunidad),
                    'idusuario' => $this->session->user_id,
                    'fecharegistro' => date('Y-m-d H:i:s')
                );
                $this->unidadexamen->addUnidadExamen($data);
            } else {
                $data = array(
                    'numero' => 1,
                    'idplantel' => $idplantel,
                    'nombreunidad' => strtoupper($nombreunidad),
                    'idusuario' => $this->session->user_id,
                    'fecharegistro' => date('Y-m-d H:i:s')
                );
                $this->unidadexamen->addUnidadExamen($data);
            }
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }
        public function addOportunidad() {
        $config = array(
            array(
                'field' => 'nombreoportunidad',
                'label' => 'Nombre',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            )
        );

        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            $result['error'] = true;
            $result['msg'] = array(
                'nombreoportunidad' => form_error('nombreoportunidad')
            );
        } else {
            $idplantel = $this->session->idplantel;
            $nombreoportunidad = $this->input->post('nombreoportunidad');
            $validar = $this->unidadexamen->ultimoRegistroOportunidades($idplantel);
            if ($validar) {
                $numero_ultimo = $validar[0]->numero;
                $data = array(
                    'idplantel' => $idplantel,
                    'numero' => $numero_ultimo + 1, 
                    'nombreoportunidad' => strtoupper($nombreoportunidad),
                    'idusuario' => $this->session->user_id,
                    'fecharegistro' => date('Y-m-d H:i:s')
                );
                $this->unidadexamen->addOportunidad($data);
            } else {
                $data = array(
                     'idplantel' => $idplantel,
                    'numero' => 1, 
                    'nombreunidad' => strtoupper($nombreunidad),
                    'idusuario' => $this->session->user_id,
                    'fecharegistro' => date('Y-m-d H:i:s')
                );
                $this->unidadexamen->addOportunidad($data);
            }
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function updateUnidadExamen() {
        $config = array(
            array(
                'field' => 'idunidad',
                'label' => 'Nombre',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),
            array(
                'field' => 'nombreunidad',
                'label' => 'Nombre',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            )
        );

        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            $result['error'] = true;
            $result['msg'] = array(
                'idunidad' => form_error('idunidad'),
                'nombreunidad' => form_error('nombreunidad'),
            );
        } else {
            $idunidad = $this->input->post('idunidad');
            $idplantel = $this->session->idplantel;
            $nombreunidad = $this->input->post('nombreunidad');
            $data = array(
                //'idplantel' => $idplantel,
                'nombreunidad' => strtoupper($nombreunidad),
                'idusuario' => $this->session->user_id,
                'fecharegistro' => date('Y-m-d H:i:s')
            );
            $this->unidadexamen->updateUnidadExamen($idunidad, $data);
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }
        public function updateOportunidad() {
        $config = array(
            array(
                'field' => 'idoportunidadexamen',
                'label' => 'Nombre',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),
            array(
                'field' => 'nombreoportunidad',
                'label' => 'Nombre',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            )
        );

        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            $result['error'] = true;
            $result['msg'] = array(
                'idoportunidadexamen' => form_error('idoportunidadexamen'),
                'nombreoportunidad' => form_error('nombreoportunidad'),
            );
        } else {
            $idoportunidadexamen = $this->input->post('idoportunidadexamen');
            $idplantel = $this->session->idplantel;
            $nombreoportunidad = $this->input->post('nombreoportunidad');
            $data = array(
                //'idplantel' => $idplantel,
                'nombreoportunidad' => strtoupper($nombreoportunidad),
                'idusuario' => $this->session->user_id,
                'fecharegistro' => date('Y-m-d H:i:s')
            );
            $this->unidadexamen->updateOportunidad($idoportunidadexamen, $data);
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function deleteUnidadExamen() {
        # code...
        if (Permission::grantValidar(uri_string()) == 1) {
            $id = $this->input->get('id');
            $query = $this->unidadexamen->deleteUnidadExamen($id);
            if ($query) {
                $result['error'] = false;
            } else {
                $result['error'] = true;
                $result['msg'] = array(
                    'msgerror' => 'No se puede Elimnar registro.'
                );
            }
        } else {
            $result['error'] = true;
            $result['msg'] = array(
                'msgerror' => 'NO TIENE PERMISO PARA REALIZAR ESTA ACCIÓN.'
            );
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }
        public function deleteOportunidad() {
        # code...
        if (Permission::grantValidar(uri_string()) == 1) {
            $id = $this->input->get('id');
            $query = $this->unidadexamen->deleteOportunidad($id);
            if ($query) {
                $result['error'] = false;
            } else {
                $result['error'] = true;
                $result['msg'] = array(
                    'msgerror' => 'No se puede Elimnar registro.'
                );
            }
        } else {
            $result['error'] = true;
            $result['msg'] = array(
                'msgerror' => 'NO TIENE PERMISO PARA REALIZAR ESTA ACCIÓN.'
            );
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

}
