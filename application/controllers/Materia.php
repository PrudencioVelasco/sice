<?php

defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("America/Mexico_City");

class Materia extends CI_Controller {

    function __construct() {
        parent::__construct();
        if (!isset($_SESSION['user_id'])) {
            $this->session->set_flashdata('flash_data', 'You don\'t have access! ss');
            return redirect('welcome');
        }
        $this->load->helper('url');
        $this->load->model('Materia_model', 'materia');
        $this->load->model('Profesor_model', 'profesor');
        $this->load->model('data_model');
        $this->load->library('permission');
        $this->load->library('session');
        $this->load->library('pdfgenerator');
    }

    public function inicio() {
         Permission::grant(uri_string());
        $this->load->view('admin/header');
        $this->load->view('admin/materia/index');
        $this->load->view('admin/footer');
    }

    public function searchMateria() {
        $value = $this->input->post('text');
        $query = $this->materia->searchMateria($value, $this->session->idplantel);
        if ($query) {
            $result['materias'] = $query;
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function showAll() {
        $query = $this->materia->showAll($this->session->idplantel);
        //var_dump($query);
        if ($query) {
            $result['materias'] = $this->materia->showAll($this->session->idplantel);
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function showAllClasificaciones() {
        $query = $this->materia->showAllClasificaciones();
        //var_dump($query);
        if ($query) {
            $result['clasificaciones'] = $this->materia->showAllClasificaciones();
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function showAllNiveles() {
        $query = $this->materia->showAllNiveles();
        //var_dump($query);
        if ($query) {
            $result['niveles'] = $this->materia->showAllNiveles();
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function showAllEspecialidades() {
        $query = $this->materia->showAllEspecialidades($this->session->idplantel);
        //var_dump($query);
        if ($query) {
            $result['especialidades'] = $this->materia->showAllEspecialidades($this->session->idplantel);
            ;
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function addMateria() {
        if (Permission::grantValidar(uri_string()) == 1) {
            $config = array(
                array(
                    'field' => 'idnivelestudio',
                    'label' => 'Mes inicio',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => 'Campo obligatorio.'
                    )
                ),
                array(
                    'field' => 'idespecialidad',
                    'label' => 'Nombre',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => 'Campo obligatorio.'
                    )
                ),
                array(
                    'field' => 'clave',
                    'label' => 'Clve',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => 'Campo obligatorio.'
                    )
                ), array(
                    'field' => 'credito',
                    'label' => 'Clve',
                    'rules' => 'trim|required|integer',
                    'errors' => array(
                        'required' => 'Campo obligatorio.',
                        'integer' => 'Solo número enteros.'
                    )
                ),
                array(
                    'field' => 'nombreclase',
                    'label' => 'A. Paterno',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => 'Campo obligatorio.'
                    )
                ),
                array(
                    'field' => 'idclasificacionmateria',
                    'label' => 'Claficacion Materia',
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
                    'idnivelestudio' => form_error('idnivelestudio'),
                    'idespecialidad' => form_error('idespecialidad'),
                    'nombreclase' => form_error('nombreclase'),
                    'clave' => form_error('clave'),
                    'credito' => form_error('credito'),
                    'idclasificacionmateria' => form_error('idclasificacionmateria')
                );
            } else {

                $idnivelestudio = trim($this->input->post('idnivelestudio'));
                $idespecialidad = trim($this->input->post('idespecialidad'));
                $idclasificacionmateria = trim($this->input->post('idclasificacionmateria'));
                $nombreclase = trim($this->input->post('nombreclase'));
                $credito = trim($this->input->post('credito'));
                $clave = trim($this->input->post('clave'));
                $validar = $this->materia->validarAddMateria($idnivelestudio, $idespecialidad, $nombreclase, $this->session->idplantel, $clave);
                if ($validar == FALSE) {

                    $data = array(
                        'idplantel' => $this->session->idplantel,
                        'idnivelestudio' => $idnivelestudio,
                        'idespecialidad' => $idespecialidad,
                        'idclasificacionmateria' => $idclasificacionmateria,
                        'nombreclase' => mb_strtoupper($nombreclase),
                        'clave' => mb_strtoupper($clave),
                        'credito' => $credito,
                        'idusuario' => $this->session->user_id,
                        'fecharegistro' => date('Y-m-d H:i:s')
                    );
                    $this->materia->addMateria($data);
                } else {
                    $result['error'] = true;
                    $result['msg'] = array(
                        'msgerror' => 'Algunos datos ya se encentran registrados.'
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

    public function addMateriaSeriada() {
        if (Permission::grantValidar(uri_string()) == 1) {
            $config = array(
                array(
                    'field' => 'idmateriaseriada',
                    'label' => 'Materia',
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
                    'idmateriaseriada' => form_error('idmateriaseriada')
                );
            } else {

                $idmateria = trim($this->input->post('idmateria'));
                $idmateriaseriada = trim($this->input->post('idmateriaseriada'));
                $validar = $this->materia->validarAddMateriaSeriada($idmateria);
                if ($validar == FALSE) {

                    $data = array(
                        'idmateriaprincipal' => $idmateria,
                        'idmateriasecundaria' => $idmateriaseriada,
                        'eliminado' => 0,
                        'idusuario' => $this->session->user_id,
                        'fecharegistro' => date('Y-m-d H:i:s')
                    );
                    $this->materia->addMateriaSeriada($data);
                } else {
                    $result['error'] = true;
                    $result['msg'] = array(
                        'msgerror' => 'Solo permite agrega una materia seriada.'
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

    public function updateMateria() {
        if (Permission::grantValidar(uri_string()) == 1) {
            $config = array(
                array(
                    'field' => 'idnivelestudio',
                    'label' => 'Mes inicio',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => 'Campo obligatorio.'
                    )
                ),
                array(
                    'field' => 'idespecialidad',
                    'label' => 'Nombre',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => 'Campo obligatorio.'
                    )
                ),
                array(
                    'field' => 'clave',
                    'label' => 'Clve',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => 'Campo obligatorio.'
                    )
                ), array(
                    'field' => 'credito',
                    'label' => 'Clve',
                    'rules' => 'trim|required|integer',
                    'errors' => array(
                        'required' => 'Campo obligatorio.',
                        'integer' => 'Solo número enteros.'
                    )
                ),
                array(
                    'field' => 'nombreclase',
                    'label' => 'A. Paterno',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => 'Campo obligatorio.'
                    )
                ),
                array(
                    'field' => 'idclasificacionmateria',
                    'label' => 'Claficacion Materia',
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
                    'idnivelestudio' => form_error('idnivelestudio'),
                    'idespecialidad' => form_error('idespecialidad'),
                    'nombreclase' => form_error('nombreclase'),
                    'clave' => form_error('clave'),
                    'credito' => form_error('credito'),
                    'idclasificacionmateria' => form_error('idclasificacionmateria')
                );
            } else {

                $idnivelestudio = trim($this->input->post('idnivelestudio'));
                $idespecialidad = trim($this->input->post('idespecialidad'));
                $nombreclase = trim($this->input->post('nombreclase'));
                $idmateria = trim($this->input->post('idmateria'));
                $clave = trim($this->input->post('clave'));
                $credito = trim($this->input->post('credito'));
                $idclasificacionmateria = trim($this->input->post('idclasificacionmateria'));
                $validar = $this->materia->validarUpdateMateria($idmateria, $idnivelestudio, $idespecialidad, $nombreclase, $this->session->idplantel, $clave);
                if ($validar == FALSE) {

                    $data = array(
                        'idnivelestudio' => $idnivelestudio,
                        'idespecialidad' => $idespecialidad,
                        'idclasificacionmateria' => $idclasificacionmateria,
                        'nombreclase' => mb_strtoupper($nombreclase),
                        'clave' => mb_strtoupper($clave),
                        'credito' => $credito,
                        'idusuario' => $this->session->user_id,
                        'fecharegistro' => date('Y-m-d H:i:s')
                    );
                    $this->materia->updateMateria($idmateria, $data);
                } else {
                    $result['error'] = true;
                    $result['msg'] = array(
                        'msgerror' => 'Ya esta registrado la Materia.'
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

    public function updateMateriaSeriada() {
        $config = array(
            array(
                'field' => 'idmateriasecundaria',
                'label' => 'Materia',
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
                'idmateriasecundaria' => form_error('idmateriasecundaria')
            );
        } else {
            $idmateriaseriada = trim($this->input->post('idmateriaseriada'));
            $idmateriasecundaria = trim($this->input->post('idmateriasecundaria'));
            $data = array(
                'idmateriasecundaria' => $idmateriasecundaria,
                'idusuario' => $this->session->user_id,
                'fecharegistro' => date('Y-m-d H:i:s')
            );
            $this->materia->updateMateriaSeriada($idmateriaseriada, $data);
        }

        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function deleteMateria() {
        if (Permission::grantValidar(uri_string()) == 1) {
            $idmateria = $this->input->get('idmateria');
            $query = $this->materia->deleteMateria($idmateria);
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

    public function showAllClases() {

        $idplantel = $this->session->idplantel;
        $idmateria = $this->input->get('idmateria');
        $query = $this->materia->showAllClases($idplantel, $idmateria);
        if ($query) {
            $result['clases'] = $this->materia->showAllClases($idplantel, $idmateria);
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function showDetalleMateria() {
        $idmateria = $this->input->get('idmateria');
        $query = $this->materia->showAllMateriaSeriada($idmateria);
        if ($query) {
            $result['materias'] = $this->materia->showAllMateriaSeriada($idmateria);
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function deleteMateriaSeriada() {
        if (Permission::grantValidar(uri_string()) == 1) {
            $id = $this->input->get('id');

            $data = array(
                'eliminado' => 1
            );
            $query = $this->materia->updateMateriaSeriada($id, $data);
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

    public function detalle($idmateria = '') {
        $detalle_materia = $this->materia->detalleMateria($idmateria);
        $data = array(
            'detalle_materia' => $detalle_materia,
            'id' => $idmateria
        );
        $this->load->view('admin/header');
        $this->load->view('admin/materia/detalle', $data);
        $this->load->view('admin/footer');
    }

}
