<?php

defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("America/Mexico_City");

class Configuracion extends CI_Controller
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
        $this->load->model('configuracion_model', 'configuracion');
        $this->load->model('escuela_model', 'escuela');
        $this->load->library('encryption');
    }

    public function index()
    {
        $this->load->view('admin/header');
        $this->load->view('admin/configuracion/index');
        $this->load->view('admin/footer');
    }
    public function detallePlantel()
    {
        # code...
        $idplantel = $this->session->idplantel;
        $query = $this->configuracion->detallePlantel($idplantel);
        //var_dump($query);
        if ($query) {
            $result['plantel'] = $this->configuracion->detallePlantel($idplantel);
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }
    public function detalleConfiguracionPrincipal()
    {
        # code...
        $idplantel = $this->session->idplantel;
        $query = $this->configuracion->detalleConfiguracionPrincpal($idplantel);
        if ($query) {
            $result['configuracion'] = $this->configuracion->detalleConfiguracionPrincpal($idplantel);
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }
    public function showAllPlanteles()
    {
        # code...
        $idplantel = $this->session->idplantel;
        $query = $this->configuracion->showAllPlanteles();
        //var_dump($query);
        if ($query) {
            $result['planteles'] = $this->configuracion->showAllPlanteles();
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }
    public function showAllNivelesEducativos()
    {
        # code...
        $idplantel = $this->session->idplantel;
        $query = $this->configuracion->showAllNivelesEducativos();
        //var_dump($query);
        if ($query) {
            $result['niveleseducativos'] = $this->configuracion->showAllNivelesEducativos();
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }
    public function eliminarCalificacion()
    {
        # code...
        $iddetalle = $this->input->get('iddetalle');
        $this->configuracion->eliminarCalificacion($iddetalle);
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }
    public function showAllCalificaciones()
    {
        $idplantel = $this->session->idplantel;
        $query = $this->configuracion->showAllCalificaciones($idplantel);
        //var_dump($query);
        if ($query) {
            $result['calificaciones'] = $this->configuracion->showAllCalificaciones($idplantel);
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }
    public function modificarPlantel()
    {
        $config = array(
            array(
                'field' => 'clave',
                'label' => 'Clave',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => '%s es campo obligatorio.'
                )
            ),
            array(
                'field' => 'nombreplantel',
                'label' => 'Nombre del plantel',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => '%s es campo obligatorio.'
                )
            ),
            array(
                'field' => 'direccion',
                'label' => 'Dirección',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => '%s es campo obligatorio.'
                )
            ), array(
                'field' => 'director',
                'label' => 'Director',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => '%s es campo obligatorio.'
                )
            ), array(
                'field' => 'mision',
                'label' => 'Misión',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => '%s es campo obligatorio.'
                )
            ), array(
                'field' => 'vision',
                'label' => 'Visión',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => '%s es campo obligatorio.'
                )
            ), array(
                'field' => 'objetivos',
                'label' => 'Objetivos',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => '%s es campo obligatorio.'
                )
            ),
            array(
                'field' => 'telefono',
                'label' => 'Telefono',
                'rules' => 'trim|required|integer|exact_length[10]',
                'errors' => array(
                    'required' => '%s es campo obligatorio.',
                    'integer' => '%s es debe de ser solo número.',
                    'exact_length' => '%s es debe de ser 10 digitos.'
                )
            )
        );

        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            $result['error'] = true;
            $result['msg'] = array(
                'clave' => form_error('clave'),
                'nombreplantel' => form_error('nombreplantel'),
                'direccion' => form_error('direccion'),
                'telefono' => form_error('telefono'),
                'director' => form_error('director'),
                'mision' => form_error('mision'),
                'vision' => form_error('vision'),
                'objetivos' => form_error('objetivos')
            );
        } else {
            $clave = strtoupper($this->input->post('clave'));
            $idplantel = strtoupper($this->input->post('idplantel'));
            $validar = $this->escuela->validarUpdateEscuela($clave, $idplantel);
            if ($validar == FALSE) {
                $data = array(
                    'clave' => strtoupper($this->input->post('clave')),
                    'nombreplantel' => strtoupper($this->input->post('nombreplantel')),
                    'mision' => strtoupper($this->input->post('mision')),
                    'vision' => strtoupper($this->input->post('vision')),
                    'objetivos' => strtoupper($this->input->post('objetivos')),
                    'direccion' => strtoupper($this->input->post('direccion')),
                    'telefono' => $this->input->post('telefono'),
                    'director' =>  strtoupper($this->input->post('director')),
                    'idusuario' => $this->session->user_id,
                    'fecharegistro' => date('Y-m-d H:i:s')

                );
                $this->escuela->updateEscuela($idplantel, $data);
            } else {
                $result['error'] = true;
                $result['msg'] = array(
                    'msgerror' => "La clave de la Escuela ya esta registrado."
                );
            }
        }

        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }
    public function agregarCalificacion()
    {
        $config = array(
            array(
                'field' => 'idnivel',
                'label' => 'Nivel Escolar',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => '%s es obligatorio.'
                )
            ),
            array(
                'field' => 'calificacion_minima',
                'label' => 'Calificacion',
                'rules' => 'trim|required|decimal|callback_maxNumber',
                'errors' => array(
                    'required' => '%s es obligatorio.',
                    'decimal' => '%s debe de ser solo número decimal.'
                )
            ),
            array(
                'field' => 'reprovandas_minima',
                'label' => 'Reprobadas permitidas',
                'rules' => 'trim|required|numeric',
                'errors' => array(
                    'required' => '%s es obligatorio.',
                    'numeric' => '%s debe ser solo numero.'
                )
            )
        );

        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            $result['error'] = true;
            $result['msg'] = array(
                'idnivel' => form_error('idnivel'),
                'calificacion_minima' => form_error('calificacion_minima'),
                'reprovandas_minima' => form_error('reprovandas_minima')
            );
        } else {
            $idnivel = $this->input->post('idnivel');
            //$iddetalle = $this->input->post('iddetalle');
            $idplantel = $this->session->idplantel;
            $configuracion = $this->configuracion->showAllConfiguracion($idplantel);
            if ($configuracion) {
                $idconfiguracion = $configuracion[0]->idconfiguracion;
                $validar = $this->configuracion->validarAddCalificacion($idnivel, $idplantel, $idconfiguracion);
                if ($validar == FALSE) {
                    $data = array(
                        'idconfiguracion' => $idconfiguracion,
                        'idnivel' => $this->input->post('idnivel'),
                        'calificacion_minima' => $this->input->post('calificacion_minima'),
                        'reprovandas_minima' => $this->input->post('reprovandas_minima'),

                    );
                    $this->configuracion->addDetalleConfiguracion($data);
                } else {
                    $result['error'] = true;
                    $result['msg'] = array(
                        'msgerror' => "El detalle pra el nivel ya esta registrado."
                    );
                }
            } else {
                $result['error'] = true;
                $result['msg'] = array(
                    'msgerror' => "Registre la Configuracion Principal."
                );
            }
        }

        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }
    public function modificarCalificacion()
    {
        $config = array(
            array(
                'field' => 'idnivel',
                'label' => 'Nivel Escolar',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => '%s es obligatorio.'
                )
            ),
            array(
                'field' => 'calificacion_minima',
                'label' => 'Calificacion',
                'rules' => 'trim|required|decimal|callback_maxNumber',
                'errors' => array(
                    'required' => '%s es obligatorio.',
                    'decimal' => '%s debe de ser solo número decimal.'
                )
            ),
            array(
                'field' => 'reprovandas_minima',
                'label' => 'Reprobadas permitidas',
                'rules' => 'trim|required|numeric',
                'errors' => array(
                    'required' => '%s es obligatorio.',
                    'numeric' => '%s debe ser solo numero.'
                )
            )
        );

        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            $result['error'] = true;
            $result['msg'] = array(
                'idnivel' => form_error('idnivel'),
                'calificacion_minima' => form_error('calificacion_minima'),
                'reprovandas_minima' => form_error('reprovandas_minima')
            );
        } else {
            $idnivel = $this->input->post('idnivel');
            $iddetalle = $this->input->post('iddetalle');
            $idplantel = $this->session->idplantel;
            $calificacion_minima = $this->input->post('calificacion_minima');
            $reprovandas_minima = $this->input->post('reprovandas_minima');
            $validar = $this->configuracion->validarUpdateCalificacion($idnivel, $idplantel, $iddetalle);
            if ($validar == FALSE) {
                $data = array(
                    'idnivel' => $this->input->post('idnivel'),
                    'calificacion_minima' => $this->input->post('calificacion_minima'),
                    'reprovandas_minima' => $this->input->post('reprovandas_minima'),

                );
                $this->configuracion->updateCalificacion($iddetalle, $data);
            } else {
                $result['error'] = true;
                $result['msg'] = array(
                    'msgerror' => "El nivel escolar ya se encuentra registrado."
                );
            }
        }

        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }
    public function maxNumber($num)
    {
        if ($num >= 0.0 && $num <= 10) {
            return true;
        } else {
            $this->form_validation->set_message('maxNumber', 'Las calificaciones debe de ser entre 0.0 a 10');
            return false;
        }
    }
    public function modificarConfiguracion()
    {
        $config = array(
            array(
                'field' => 'idplantel',
                'label' => 'Plantel',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => '%s es obligatorio.'
                )
            ),
            array(
                'field' => 'idniveleducativo',
                'label' => 'Nivel Educativo',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => '%s es obligatorio.'
                )
            ),
            array(
                'field' => 'totalrecargo',
                'label' => 'Recargo',
                'rules' => 'trim|required|decimal',
                'errors' => array(
                    'required' => '%s es obligatorio.',
                    'decimal' => '%s debe de ser solo número decimal.'
                )
            ),
            array(
                'field' => 'diaultimorecargo',
                'label' => 'Dia de corte',
                'rules' => 'trim|required|numeric',
                'errors' => array(
                    'required' => '%s es obligatorio.',
                    'numeric' => '%s debe ser solo numero.'
                )
            )
        );

        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            $result['error'] = true;
            $result['msg'] = array(
                'idplantel' => form_error('idplantel'),
                'idniveleducativo' => form_error('idniveleducativo'),
                'totalrecargo' => form_error('totalrecargo'),
                'diaultimorecargo' => form_error('diaultimorecargo')
            );
        } else {
            $idconfiguracion = $this->input->post('idconfiguracion');

            $data = array(
                'idplantel' => $this->input->post('idplantel'),
                'idniveleducativo' => $this->input->post('idniveleducativo'),
                'totalrecargo' => $this->input->post('totalrecargo'),
                'diaultimorecargo' => $this->input->post('diaultimorecargo'),

            );
            $this->configuracion->updateConfiguracion($idconfiguracion, $data);
        }

        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }
    public function agregarConfiguracion()
    {
        $config = array(
            array(
                'field' => 'idplantel',
                'label' => 'Plantel',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => '%s es obligatorio.'
                )
            ),
            array(
                'field' => 'idniveleducativo',
                'label' => 'Nivel Educativo',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => '%s es obligatorio.'
                )
            ),
            array(
                'field' => 'totalrecargo',
                'label' => 'Recargo',
                'rules' => 'trim|required|decimal',
                'errors' => array(
                    'required' => '%s es obligatorio.',
                    'decimal' => '%s debe de ser solo número decimal.'
                )
            ),
            array(
                'field' => 'diaultimorecargo',
                'label' => 'Dia de corte',
                'rules' => 'trim|required|numeric',
                'errors' => array(
                    'required' => '%s es obligatorio.',
                    'numeric' => '%s debe ser solo numero.'
                )
            )
        );

        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            $result['error'] = true;
            $result['msg'] = array(
                'idplantel' => form_error('idplantel'),
                'idniveleducativo' => form_error('idniveleducativo'),
                'totalrecargo' => form_error('totalrecargo'),
                'diaultimorecargo' => form_error('diaultimorecargo')
            );
        } else {
            $idplantel  = $this->input->post('idplantel');
            $valor = $this->configuracion->configuracionPorPlante($idplantel);
            if ($valor == false) {
                $data = array(
                    'idplantel' => $this->input->post('idplantel'),
                    'idniveleducativo' => $this->input->post('idniveleducativo'),
                    'totalrecargo' => $this->input->post('totalrecargo'),
                    'diaultimorecargo' => $this->input->post('diaultimorecargo'),

                );
                $this->configuracion->addConfiguracion($data);
            } else {
                $result['error'] = true;
                $result['msg'] = array(
                    'msgerror' => "La configuracion para el Plantel  ya se encuentra registrado."
                );
            }
        }

        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }
    public function eliminarLogo()
    {
        $opcion = $this->input->get('opcion');
        $idplantel = $this->session->idplantel;
        if (isset($opcion) && !empty($opcion)) {
            if ($opcion == 1) {
                //LOGO PRINCIPAL
                $data = array(
                    'logoplantel' => ""
                );
                $this->configuracion->updatePlantel($idplantel, $data);
            }
            if ($opcion == 2) {
                // LOGO SECUNDARIO
                $data2 = array(
                    'logosegundo' => ""
                );
                $this->configuracion->updatePlantel($idplantel, $data2);
            }
            $result['error'] = false;
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }
    public function subirFotoPlantelPrincipal()
    {
        if (isset($_FILES['file']['name']) && !empty($_FILES['file']['name'])) {
            $id = $this->session->idplantel;
            $mi_archivo = 'file';
            $config['upload_path'] = "assets/images/escuelas/";
            //$config['file_name'] = 'Avatar' . date("Y-m-d his");
            //$config['allowed_types'] = "*";
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size'] = "50000";
            $config['max_width'] = "2000";
            $config['max_height'] = "2000";
            $file_name = $_FILES['file']['name'];
            $tmp = explode('.', $file_name);
            $extension_img = end($tmp);
            $user_img_profile = $id . "-" . date("Y-m-dhis") . '.' . $extension_img;
            $config['file_name'] = $user_img_profile;

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload($mi_archivo)) {
                //*** ocurrio un error
                //$data['state'] = 500;
                //$data['message'] = $this->upload->display_errors();
                // echo $this->upload->display_errors();
                //echo json_encode($data);

                $result['error'] = true;
                $result['msg'] = array(
                    'msgerror' => $this->upload->display_errors()
                );
                //return;
            } else {

                $data = array(
                    'logoplantel' =>  $user_img_profile,
                    'idusuario' => $this->session->user_id,
                    'fecharegistro' => date('Y-m-d H:i:s')
                );
                $this->configuracion->updatePlantel($id, $data);
            }
        } else {
            $result['error'] = true;
            $result['msg'] = array(
                'msgerror' => 'Seleccioar la foto.'
            );
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }
    public function subirFotoPlantelSecundario()
    {
        if (isset($_FILES['file']['name']) && !empty($_FILES['file']['name'])) {
            $id = $this->session->idplantel;
            $mi_archivo = 'file';
            $config['upload_path'] = "assets/images/escuelas/";
            //$config['file_name'] = 'Avatar' . date("Y-m-d his");
            //$config['allowed_types'] = "*";
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size'] = "50000";
            $config['max_width'] = "2000";
            $config['max_height'] = "2000";
            $file_name = $_FILES['file']['name'];
            $tmp = explode('.', $file_name);
            $extension_img = end($tmp);
            $user_img_profile = $id . "-" . date("Y-m-dhis") . '.' . $extension_img;
            $config['file_name'] = $user_img_profile;

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload($mi_archivo)) {
                //*** ocurrio un error
                //$data['state'] = 500;
                //$data['message'] = $this->upload->display_errors();
                // echo $this->upload->display_errors();
                //echo json_encode($data);

                $result['error'] = true;
                $result['msg'] = array(
                    'msgerror' => $this->upload->display_errors()
                );
                //return;
            } else {

                $data = array(
                    'logosegundo' =>  $user_img_profile,
                    'idusuario' => $this->session->user_id,
                    'fecharegistro' => date('Y-m-d H:i:s')
                );
                $this->configuracion->updatePlantel($id, $data);
            }
        } else {
            $result['error'] = true;
            $result['msg'] = array(
                'msgerror' => 'Seleccioar la foto.'
            );
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }
}
