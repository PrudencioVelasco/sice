<?php

defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("America/Mexico_City");

class Examen extends CI_Controller
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
        $this->load->model('colegiatura_model', 'colegiatura');
        $this->load->model('unidadexamen_model', 'unidadexamen');
        $this->load->library('permission');
        $this->load->library('session');
    }

    public function inicio()
    {
        Permission::grant(uri_string());
        $this->load->view('admin/header');
        $this->load->view('admin/catalogo/examen/index');
        $this->load->view('admin/footer');
    }

    public function showAll()
    {
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
    public function showAllMeses()
    {
        $query = $this->unidadexamen->showAllMeses();

        if ($query) {
            $result['meses'] = $this->unidadexamen->showAllMeses();
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }
    public function shoAllMesesUnidad($idunidad)
    {
        $query = $this->unidadexamen->showAllMesesUnidad($idunidad);
        //var_dump($query);
        if ($query) {
            $result['unidadmeses'] = $this->unidadexamen->showAllMesesUnidad($idunidad);
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }
    public function detalle($idunidad = '')
    {
        # code...
        if (isset($idunidad) && !empty($idunidad)) {
            $data = array(
                'idunidad' => $idunidad
            );
            $this->load->view('admin/header');
            $this->load->view('admin/catalogo/examen/detalle', $data);
            $this->load->view('admin/footer');
        }
    }
    public function showAllOportunidades()
    {
        $idplantel = $this->session->idplantel;
        $query = $this->unidadexamen->showAllOportunidades($idplantel);
        if ($query) {
            $result['oportunidades'] = $this->unidadexamen->showAllOportunidades($idplantel);
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function searchUnidadExamen()
    {
        $value = $this->input->post('text');
        $query = $this->unidadexamen->searchUnidadExamen($value);
        if ($query) {
            $result['unidades'] = $query;
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }
    public function searchOportunidades()
    {
        $value = $this->input->post('text');
        $query = $this->unidadexamen->searchOportunidades($value);
        if ($query) {
            $result['oportunidades'] = $query;
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function addUnidadExamen()
    {
        $config = array(
            array(
                'field' => 'nombreunidad',
                'label' => 'Nombre del examen',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => '%s es obligatorio.'
                )
            ),
            array(
                'field' => 'tipo',
                'label' => 'Tipo del examen',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => '%s es obligatorio.'
                )
            ),
            array(
                'field' => 'fechainicio',
                'label' => 'Fecha inicio de evaluación',
                'rules' => 'trim',
                /*'errors' => array(
                    'required' => '%s es obligatorio.'
                )*/
            ),
            array(
                'field' => 'fechafin',
                'label' => 'Fecha termino de evaluación',
                'rules' => 'trim',
                /* 'errors' => array(
                    'required' => '%s es obligatorio.'
                )*/
            )
        );

        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            $result['error'] = true;
            $result['msg'] = array(
                'nombreunidad' => form_error('nombreunidad'),
                'tipo' => form_error('tipo'),
                'fechainicio' => form_error('fechainicio'),
                'fechafin' => form_error('fechafin')
            );
        } else {
            $idplantel = $this->session->idplantel;
            $nombreunidad = $this->input->post('nombreunidad');
            $fechainicio = $this->input->post('fechainicio');
            $fechafin = $this->input->post('fechafin');
            $tipo = $this->input->post('tipo');
            $validar = $this->unidadexamen->ultimoRegistro($idplantel);
            if ($validar) {
                $numero_ultimo = $validar[0]->numero;
                $data = array(
                    'numero' => $numero_ultimo + 1,
                    'idplantel' => $idplantel,
                    'nombreunidad' => strtoupper($nombreunidad),
                    'fechainicio' => $fechainicio,
                    'fechafin' => $fechafin,
                    'tipo' => $tipo,
                    'idusuario' => $this->session->user_id,
                    'fecharegistro' => date('Y-m-d H:i:s')
                );
                $this->unidadexamen->addUnidadExamen($data);
            } else {
                $data = array(
                    'numero' => 1,
                    'idplantel' => $idplantel,
                    'nombreunidad' => strtoupper($nombreunidad),
                    'fechainicio' => $fechainicio,
                    'fechafin' => $fechafin,
                    'tipo' => $tipo,
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
    public function addMesUnidad()
    {
        $config = array(
            array(
                'field' => 'idmes',
                'label' => 'Mes',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => '%s es obligatorio.'
                )
            ),


            array(
                'field' => 'fechainicio',
                'label' => 'Fecha inicio de evaluación',
                'rules' => 'trim',
                /*'errors' => array(
                    'required' => '%s es obligatorio.'
                )*/
            ),
            array(
                'field' => 'fechafin',
                'label' => 'Fecha termino de evaluación',
                'rules' => 'trim',
                /*'errors' => array(
                    'required' => '%s es obligatorio.'
                )*/
            )
        );

        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            $result['error'] = true;
            $result['msg'] = array(
                'idmes' => form_error('idmes'),

                'fechainicio' => form_error('fechainicio'),
                'fechafin' => form_error('fechafin')
            );
        } else {
            $idunidad = $this->input->post('idunidad');
            $idmes = $this->input->post('idmes');

            $fechainicio = $this->input->post('fechainicio');
            $fechafin = $this->input->post('fechafin');
            $validar = $this->unidadexamen->validarMesUnidad($idunidad, $idmes);
            if (!$validar) {
                $data = array(
                    'idunidad' => $idunidad,
                    'idmes' => $idmes,
                    'fechainicio' => $fechainicio,
                    'fechafin' => $fechafin,
                    'activo' => 1,
                );
                $this->unidadexamen->addMesUnidad($data);
            } else {
                $result['error'] = true;
                $result['msg'] = array(
                    'msgerror' => 'El mes ya esta agregado al Trimestre.'
                );
            }
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }
    public function updateMesUnidad()
    {
        $config = array(
            array(
                'field' => 'idmes',
                'label' => 'Mes',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => '%s es obligatorio.'
                )
            ),
            array(
                'field' => 'fechainicio',
                'label' => 'Fecha inicio de evaluación',
                'rules' => 'trim',
                /*'errors' => array(
                    'required' => '%s es obligatorio.'
                )*/
            ),
            array(
                'field' => 'fechafin',
                'label' => 'Fecha termino de evaluación',
                'rules' => 'trim',
                /*'errors' => array(
                    'required' => '%s es obligatorio.'
                )*/
            )
        );

        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            $result['error'] = true;
            $result['msg'] = array(
                'idmes' => form_error('idmes'),
                'fechainicio' => form_error('fechainicio'),
                'fechafin' => form_error('fechafin')
            );
        } else {
            $idplantel = $this->session->idplantel;
            $idunidadmes = $this->input->post('idunidadmes');
            $idunidad = $this->input->post('idunidad');
            $idmes = $this->input->post('idmes');
            $fechainicio = $this->input->post('fechainicio');
            $fechafin = $this->input->post('fechafin');
            $validar = $this->unidadexamen->validarUpdateMesUnidad($idunidadmes, $idmes, $idplantel);
            if (!$validar) {
                $data = array(
                    'idmes' => $idmes,
                    'fechainicio' => $fechainicio,
                    'fechafin' => $fechafin,
                );
                $this->unidadexamen->updateUnidadMes($idunidadmes, $data);
            } else {
                $result['error'] = true;
                $result['msg'] = array(
                    'msgerror' => 'El mes ya esta agregado al Trimestre.'
                );
            }
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function maxNumber($num)
    {
        if ($num >= 0 && $num <= 1000) {
            return true;
        } else {
            $this->form_validation->set_message('maxNumber', 'Los creditos de la materia no es correcto');
            return false;
        }
    }
    public function addOportunidad()
    {
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
                    'nombreoportunidad' => strtoupper($nombreoportunidad),
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

    public function updateUnidadExamen()
    {
        $config = array(
            array(
                'field' => 'idunidad',
                'label' => 'Nombre del examen',
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
                    'required' => '%s es obligatorio.'
                )
            ),
            array(
                'field' => 'tipo',
                'label' => 'Tipo del examen',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => '%s es obligatorio.'
                )
            ),
            array(
                'field' => 'fechainicio',
                'label' => 'Fecha inicio de evaluación',
                'rules' => 'trim',
                /* 'errors' => array(
                    'required' => '%s es obligatorio.'
                )*/
            ),
            array(
                'field' => 'fechafin',
                'label' => 'Fecha termino de evaluación',
                'rules' => 'trim',
                /*'errors' => array(
                    'required' => '%s es obligatorio.'
                )*/
            )
        );

        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            $result['error'] = true;
            $result['msg'] = array(
                'idunidad' => form_error('idunidad'),
                'nombreunidad' => form_error('nombreunidad'),
                'tipo' => form_error('tipo'),
                'fechainicio' => form_error('fechainicio'),
                'fechafin' => form_error('fechafin')
            );
        } else {
            $idunidad = $this->input->post('idunidad');
            $idplantel = $this->session->idplantel;
            $nombreunidad = $this->input->post('nombreunidad');
            $tipo = $this->input->post('tipo');
            $fechainicio = $this->input->post('fechainicio');
            $fechafin = $this->input->post('fechafin');

            $data = array(
                //'idplantel' => $idplantel,
                'nombreunidad' => strtoupper($nombreunidad),
                'fechainicio' => $fechainicio,
                'fechafin' => $fechafin,
                'tipo' => $tipo,
                'idusuario' => $this->session->user_id,
                'fecharegistro' => date('Y-m-d H:i:s')
            );
            $this->unidadexamen->updateUnidadExamen($idunidad, $data);
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }
    public function updateOportunidad()
    {
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

    public function deleteUnidadExamen()
    {
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
    public function deleteOportunidad()
    {
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
    public function deleteUnidadMes()
    {
        $id = $this->input->get('id');
        if (isset($id) && !empty($id)) {
            $data = array(
                'activo' => 0
            );
            $query = $this->unidadexamen->deleteUnidadMes($id);
            if ($query) {
                $result['error'] = false;
            } else {
                $result['error'] = true;
                $result['msg'] = array(
                    'msgerror' => 'No se puede Elimnar registro.'
                );
            }
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }
    function validarFecha($fecha)
    {
        if ($fecha == '0000-00-00' || $fecha == '00-00-0000') {
            $parts = explode("/", $fecha);
            if (count($parts) == 3) {
                if (checkdate($parts[1], $parts[0], $parts[2])) {
                    return true;
                } else {
                    $this->form_validation->set_message(
                        'validarFecha',
                        'Formato de la fecha no valido.'
                    );
                    return false;
                }
            } else {
                $this->form_validation->set_message(
                    'validarFecha',
                    'Formato de la fecha no validos'
                );
                return false;
            }
        } else {
            return true;
        }
    }
}
