<?php

defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("America/Mexico_City");

class CicloEscolar extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        if (!isset($_SESSION['user_id'])) {
            $this->session->set_flashdata('flash_data', 'You don\'t have access! ss');
            return redirect('welcome');
        }
        $this->load->helper('url');
        $this->load->model('CicloEscolar_model', 'ciclo');
        $this->load->model('data_model');
        $this->load->library('permission');
        $this->load->library('session');
        $this->load->library('pdfgenerator');
    }

    public function inicio()
    {
        Permission::grant(uri_string());
        $this->load->view('admin/header');
        $this->load->view('admin/cicloescolar/index');
        $this->load->view('admin/footer');
    }

    public function searchCiclo()
    {
        //Permission::grant(uri_string());
        $value = $this->input->post('text');
        $query = $this->ciclo->searchCiclo($value, $this->session->idplantel);
        if ($query) {
            $result['ciclos'] = $query;
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function showAll()
    {
        //Permission::grant(uri_string());
        $query = $this->ciclo->showAll($this->session->idplantel);
        //var_dump($query);
        if ($query) {
            $result['ciclos'] = $this->ciclo->showAll($this->session->idplantel);
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function showAllMeses()
    {
        //Permission::grant(uri_string());
        $query = $this->ciclo->showAllMeses();
        //var_dump($query);
        if ($query) {
            $result['meses'] = $this->ciclo->showAllMeses();
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function showAllYears()
    {
        //Permission::grant(uri_string());
        $query = $this->ciclo->showAllYears();
        //var_dump($query);
        if ($query) {
            $result['years'] = $this->ciclo->showAllYears();
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function addCiclo()
    {
        if (Permission::grantValidar(uri_string()) == 1) {
            $config = array(
                array(
                    'field' => 'idmesinicio',
                    'label' => 'Mes inicio',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => '%s es obligatorio.'
                    )
                ),
                array(
                    'field' => 'idyearinicio',
                    'label' => 'Año inicio',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => '%s es obligatorio.'
                    )
                ),
                array(
                    'field' => 'idmesfin',
                    'label' => 'Mes termino',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => '%s es obligatorio.'
                    )
                ),
                array(
                    'field' => 'idyearfin',
                    'label' => 'Año termino',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => '%s es obligatorio.'
                    )
                ),
            );

            $this->form_validation->set_rules($config);
            if ($this->form_validation->run() == FALSE) {
                $result['error'] = true;
                $result['msg'] = array(
                    'idmesinicio' => form_error('idmesinicio'),
                    'idyearinicio' => form_error('idyearinicio'),
                    'idmesfin' => form_error('idmesfin'),
                    'idyearfin' => form_error('idyearfin'),
                    'descripcion' => form_error('descripcion')
                );
            } else {

                $mesinicio = trim($this->input->post('idmesinicio'));
                $yearinicio = trim($this->input->post('idyearinicio'));
                $mesfin = trim($this->input->post('idmesfin'));
                $yearfin = trim($this->input->post('idyearfin'));
                $descripcion = trim($this->input->post('descripcion'));
                $validar = $this->ciclo->validarAddCiclo($mesinicio, $yearinicio, $mesfin, $yearfin, $this->session->idplantel);
                if ($validar == FALSE) {
                    $data_update = array(
                        'activo' => 0
                    );
                    $this->ciclo->desactivaCiclo($data_update, $this->session->idplantel);

                    $data_update_horario = array(
                        'activo' => 0
                    );
                    $this->ciclo->desactivarHorario($data_update_horario, $this->session->idplantel);


                    $data = array(
                        'idplantel' => $this->session->idplantel,
                        'idmesinicio' => $mesinicio,
                        'idyearinicio' => $yearinicio,
                        'idmesfin' => $mesfin,
                        'idyearfin' => $yearfin,
                        'descripcion' => $descripcion,
                        'activo' => 1,
                        'idusuario' => $this->session->user_id,
                        'fecharegistro' => date('Y-m-d H:i:s')
                    );
                    $this->ciclo->addCiclo($data);
                } else {
                    $result['error'] = true;
                    $result['msg'] = array(
                        'msgerror' => 'Ya esta registrado el Ciclo Escolar.'
                    );
                }
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

    public function updateCiclo()
    {
        if (Permission::grantValidar(uri_string()) == 1) {
            $config = array(
                array(
                    'field' => 'idmesinicio',
                    'label' => 'Mes inicio',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => 'Campo obligatorio.'
                    )
                ),
                array(
                    'field' => 'idyearinicio',
                    'label' => 'Año inicio',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => '%s es obligatorio.'
                    )
                ),
                array(
                    'field' => 'idmesfin',
                    'label' => 'Mes termino',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => '%s es obligatorio.'
                    )
                ),
                array(
                    'field' => 'idyearfin',
                    'label' => 'Año termino',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => '%s es obligatorio.'
                    )
                ),
            );

            $this->form_validation->set_rules($config);
            if ($this->form_validation->run() == FALSE) {
                $result['error'] = true;
                $result['msg'] = array(
                    'idmesinicio' => form_error('idmesinicio'),
                    'idyearinicio' => form_error('idyearinicio'),
                    'idmesfin' => form_error('idmesfin'),
                    'idyearfin' => form_error('idyearfin'),
                    'descripcion' => form_error('idyearfin')
                );
            } else {

                $mesinicio = trim($this->input->post('idmesinicio'));
                $yearinicio = trim($this->input->post('idyearinicio'));
                $mesfin = trim($this->input->post('idmesfin'));
                $yearfin = trim($this->input->post('idyearfin'));
                $idperiodo = trim($this->input->post('idperiodo'));
                $descripcion = trim($this->input->post('descripcion'));
                $activo = trim($this->input->post('activo'));
                $validar = $this->ciclo->validarUpdateCiclo($mesinicio, $yearinicio, $mesfin, $yearfin, $idperiodo, $this->session->idplantel);
                if ($validar == FALSE) {

                    $data_periodo = $this->ciclo->datosCiclo($idperiodo);
                    $estatus = $data_periodo->activo;
                    if ($activo == $estatus) {

                        $data = array(
                            'idplantel' => $this->session->idplantel,
                            'idmesinicio' => $mesinicio,
                            'idyearinicio' => $yearinicio,
                            'idmesfin' => $mesfin,
                            'idyearfin' => $yearfin,
                            'descripcion' => $descripcion,
                            'idusuario' => $this->session->user_id,
                            'fecharegistro' => date('Y-m-d H:i:s')
                        );
                        $this->ciclo->updatePeriodo($idperiodo, $data);
                    } else {
                        if ($activo == 1) {
                            $data_update = array(
                                'activo' => 0
                            );
                            $this->ciclo->desactivaCiclo($data_update, $this->session->idplantel);
                            $data_update_horario = array(
                                'activo' => 0
                            );
                            $this->ciclo->desactivarHorario($data_update_horario, $this->session->idplantel);
                            $data = array(
                                'idplantel' => $this->session->idplantel,
                                'idmesinicio' => $mesinicio,
                                'idyearinicio' => $yearinicio,
                                'idmesfin' => $mesfin,
                                'idyearfin' => $yearfin,
                                'descripcion' => $descripcion,
                                'activo' => 1,
                                'idusuario' => $this->session->user_id,
                                'fecharegistro' => date('Y-m-d H:i:s')
                            );
                            $this->ciclo->updatePeriodo($idperiodo, $data);
                            $data_update_horario_activar = array(
                                'activo' => 1
                            );
                            $this->ciclo->updateHorario($idperiodo, $data_update_horario_activar);
                        } elseif ($activo == 0) {
                            # code...
                            $data = array(
                                'idplantel' => $this->session->idplantel,
                                'idmesinicio' => $mesinicio,
                                'idyearinicio' => $yearinicio,
                                'idmesfin' => $mesfin,
                                'idyearfin' => $yearfin,
                                'activo' => 0,
                                'idusuario' => $this->session->user_id,
                                'fecharegistro' => date('Y-m-d H:i:s')
                            );
                            $this->ciclo->updatePeriodo($idperiodo, $data);
                            $data_update_horario_activar = array(
                                'activo' => 0
                            );
                            $this->ciclo->updateHorario($idperiodo, $data_update_horario_activar);
                        } else {
                            $result['error'] = true;
                            $result['msg'] = array(
                                'msgerror' => 'Error, intente mas tarde.'
                            );
                        }
                    }
                } else {
                    $result['error'] = true;
                    $result['msg'] = array(
                        'msgerror' => 'Ya esta registrado el Ciclo Escolar.'
                    );
                }
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

    public function deleteCicloEscolar()
    {
        if (Permission::grantValidar(uri_string()) == 1) {
            $idperiodo = $this->input->get('idperiodo');
            $query = $this->ciclo->deleteCicloEscolar($idperiodo);
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
