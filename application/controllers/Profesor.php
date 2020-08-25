<?php

defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("America/Mexico_City");

class Profesor extends CI_Controller {

    function __construct() {
        parent::__construct();
        if (!isset($_SESSION['user_id'])) {
            $this->session->set_flashdata('flash_data', 'You don\'t have access! ss');
            return redirect('welcome');
        }
        $this->load->helper('url');
        $this->load->model('profesor_model', 'profesor');
        $this->load->model('user_model', 'usuario');
        $this->load->model('data_model');
        $this->load->library('permission');
        $this->load->library('session');
        //$this->load->library('encrypt'); 
    }

    public function inicio() {
        Permission::grant(uri_string());
        $this->load->view('admin/header');
        $this->load->view('admin/profesor/index');
        $this->load->view('admin/footer');
    }

    public function showAll() {
        //Permission::grant(uri_string()); 
        $idplantel = $this->session->idplantel;
        $query = $this->profesor->showAll($idplantel);
        if ($query) {
            $result['profesores'] = $this->profesor->showAll($idplantel);
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function showDetalleProfesor() {
        $idprofesor = $this->input->get('idprofesor');
        $query = $this->profesor->detalleProfesor($idprofesor);
        if ($query) {
            $result['detalle_profesor'] = $this->profesor->detalleProfesor($idprofesor);
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function subirFoto() {
        if (Permission::grantValidar(uri_string()) == 1) {
            if (isset($_FILES['file']['name']) && !empty($_FILES['file']['name'])) {
                $mi_archivo = 'file';
                $config['upload_path'] = "assets/profesores/";
                //$config['file_name'] = 'Avatar' . date("Y-m-d his");
                //$config['allowed_types'] = "*";
                $config['allowed_types'] = 'jpg|jpeg|png';
                $config['max_size'] = "50000";
                $config['max_width'] = "2000";
                $config['max_height'] = "2000";
                $file_name = $_FILES['file']['name'];
                $tmp = explode('.', $file_name);
                $extension_img = end($tmp);
                $user_img_profile = date("Y-m-dhis") . '.' . $extension_img;
                $config['file_name'] = $user_img_profile;

                $this->load->library('upload', $config);

                if (!$this->upload->do_upload($mi_archivo)) {

                    $result['error'] = true;
                    $result['msg'] = array(
                        'msgerror' => $this->upload->display_errors()
                    );
                } else {
                    $id = $this->input->post('idprofesor');
                    $data = array(
                        'foto' => $user_img_profile,
                        'idusuario' => $this->session->user_id,
                        'fecharegistro' => date('Y-m-d H:i:s')
                    );

                    $this->profesor->updateProfesor($id, $data);
                }
            } else {
                $result['error'] = true;
                $result['msg'] = array(
                    'msgerror' => 'Seleccioar la foto.'
                );
            }
        } else {
            $result['error'] = true;
            $result['msg'] = array(
                'msgerror' => "NO TIENE PERMISOS PARA REALIZAR ESTA ACCIÓN."
            );
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function addProfesor() {
        if (Permission::grantValidar(uri_string()) == 1) {
            $config = array(
                array(
                    'field' => 'cedula',
                    'label' => 'Nombre',
                    'rules' => 'trim|required|integer',
                    'errors' => array(
                        'required' => 'Campo obligatorio.',
                        'integer' => 'Debe de ser solo número.'
                    )
                ),
                array(
                    'field' => 'nombre',
                    'label' => 'Nombre',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => 'Campo obligatorio.'
                    )
                ),
                array(
                    'field' => 'apellidop',
                    'label' => 'A. Paterno',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => 'Campo obligatorio.'
                    )
                ), array(
                    'field' => 'profesion',
                    'label' => 'A. Paterno',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => 'Campo obligatorio.'
                    )
                ),
                array(
                    'field' => 'correo',
                    'label' => 'Correo',
                    'rules' => 'trim|required|valid_email',
                    'errors' => array(
                        'required' => 'Campo obligatorio.',
                        'valid_email' => 'Correo no valido.'
                    )
                ),
                array(
                    'field' => 'password',
                    'label' => 'Contraseña',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => 'Campo obligatorio.'
                    )
                ),
                 array(
                    'field' => 'urlvideoconferencia',
                    'label' => 'URL Videoconferencia',
                    'rules' => 'trim|valid_url',
                    'errors' => array(
                        'valid_url' => 'Formato de la URL invalido.'
                    )
                ),
                  array(
                    'field' => 'numeroanfitrion',
                    'label' => 'Hora final',
                    'rules' => 'trim|integer',
                    'errors' => array( 
                         'integer' => 'Debe de ser numero.'
                    )
                )
            );

            $this->form_validation->set_rules($config);
            if ($this->form_validation->run() == FALSE) {
                $result['error'] = true;
                $result['msg'] = array(
                    'nombre' => form_error('nombre'),
                    'apellidop' => form_error('apellidop'),
                    'cedula' => form_error('cedula'),
                    'correo' => form_error('correo'),
                    'password' => form_error('password'),
                    'profesion' => form_error('profesion'),
                      'urlvideoconferencia' => form_error('urlvideoconferencia'),
                     'numeroanfitrion' => form_error('numeroanfitrion')
                );
            } else {
                $cedula = trim($this->input->post('cedula'));
                $correo = trim($this->input->post('correo'));
                $validar = $this->profesor->validarCedula($cedula,'', $this->session->idplantel);
                 $validar_correo = $this->profesor->validarCorreo($correo, $this->session->idplantel);
                if ($validar == FALSE && $validar_correo == FALSE) {
                    $password_encrypted = password_hash(trim($this->input->post('password')), PASSWORD_BCRYPT);
                    $data = array(
                        'idplantel' => $this->session->idplantel,
                        'cedula' => $cedula,
                        'nombre' => mb_strtoupper($this->input->post('nombre')),
                        'apellidop' => mb_strtoupper($this->input->post('apellidop')),
                        'apellidom' => mb_strtoupper($this->input->post('apellidom')),
                        'profesion' => mb_strtoupper($this->input->post('profesion')),
                        'correo' => $this->input->post('correo'),
                        'password' => $password_encrypted,
                        'foto' => '',
                        'urlvideoconferencia' => $this->input->post('urlvideoconferencia'),
                        'numeroanfitrion' => $this->input->post('numeroanfitrion'),
                        'idusuario' => $this->session->user_id,
                        'fecharegistro' => date('Y-m-d H:i:s')
                    );
                    $idprofesor = $this->profesor->addProfesor($data);
                    $data_user = array(
                        'idusuario' => $idprofesor,
                        'idtipousuario' => 1,
                        'fecharegistro' => date('Y-m-d H:i:s')
                    );
                    $idusuario = $this->usuario->addUser($data_user);
                    $data_usuario_rol = array(
                        'id_rol' => 10,
                        'id_user' => $idusuario
                    );
                    $id_usuario_rol = $this->usuario->addUserRol($data_usuario_rol);
                } else {
                    $result['error'] = true;
                    $result['msg'] = array(
                        'msgerror' => "La cëdula o correo electronico ya esta registrada."
                    );
                }
            }
        } else {
            $result['error'] = true;
            $result['msg'] = array(
                'msgerror' => "NO TIENE PERMISO PARA REALIZAR ESTA ACCIÓN."
            );
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function updateProfesor() {
        # code...
        if (Permission::grantValidar(uri_string()) == 1) {
            $config = array(
                array(
                    'field' => 'cedula',
                    'label' => 'Nombre',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => 'Campo obligatorio.'
                    )
                ),
                array(
                    'field' => 'nombre',
                    'label' => 'Nombre',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => 'Campo obligatorio.'
                    )
                ),
                array(
                    'field' => 'apellidop',
                    'label' => 'A. Paterno',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => 'Campo obligatorio.'
                    )
                ), array(
                    'field' => 'profesion',
                    'label' => 'A. Paterno',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => 'Campo obligatorio.'
                    )
                ),
                array(
                    'field' => 'correo',
                    'label' => 'Correo',
                    'rules' => 'trim|required|valid_email',
                    'errors' => array(
                        'required' => 'Campo obligatorio.',
                        'valid_email' => 'Correo no valido.'
                    )
                ),
                array(
                    'field' => 'password',
                    'label' => 'Contraseña',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => 'Campo obligatorio.'
                    )
                ),
                 array(
                    'field' => 'urlvideoconferencia',
                    'label' => 'URL Videoconferencia',
                    'rules' => 'trim|valid_url',
                    'errors' => array(
                        'valid_url' => 'Formato de la URL invalido.'
                    )
                ),
                  array(
                    'field' => 'numeroanfitrion',
                    'label' => 'Hora final',
                    'rules' => 'trim|integer',
                    'errors' => array( 
                         'integer' => 'Debe de ser numero.'
                    )
                )
            );

            $this->form_validation->set_rules($config);
            if ($this->form_validation->run() == FALSE) {
                $result['error'] = true;
                $result['msg'] = array(
                    'nombre' => form_error('nombre'),
                    'apellidop' => form_error('apellidop'),
                    'cedula' => form_error('cedula'),
                    'correo' => form_error('correo'),
                    'password' => form_error('password'),
                    'profesion' => form_error('profesion'),
                      'urlvideoconferencia' => form_error('urlvideoconferencia'),
                     'numeroanfitrion' => form_error('numeroanfitrion')
                );
            } else {
                $id = $this->input->post('idprofesor');
                $cedula = trim($this->input->post('cedula'));
                 $correo = trim($this->input->post('correo'));
                $validar = $this->profesor->validarCedula($cedula, $id, $this->session->idplantel);
                  $validar_correo = $this->profesor->validarCorreoUpdate($correo, $id, $this->session->idplantel);
                if ($validar == FALSE && $validar_correo == false) {
                    $data = array(
                        'idplantel' => $this->session->idplantel,
                        'cedula' => $this->input->post('cedula'),
                        'nombre' => mb_strtoupper($this->input->post('nombre')),
                        'apellidop' => mb_strtoupper($this->input->post('apellidop')),
                        'apellidom' => mb_strtoupper($this->input->post('apellidom')),
                        'profesion' => mb_strtoupper($this->input->post('profesion')),
                        'correo' => $this->input->post('correo'),
                          'urlvideoconferencia' => $this->input->post('urlvideoconferencia'),
                        'numeroanfitrion' => $this->input->post('numeroanfitrion'),
                        'idusuario' => $this->session->user_id,
                        'fecharegistro' => date('Y-m-d H:i:s')
                    );
                    $this->profesor->updateProfesor($id, $data);
                } else {
                    $result['error'] = true;
                    $result['msg'] = array(
                        'msgerror' => "La cëdula o correo electronico ya esta registrada."
                    );
                }
            }
        } else {
            $result['error'] = true;
            $result['msg'] = array(
                'msgerror' => "NO TIENE PERMISO PARA REALIZAR ESTA ACCIÓN."
            );
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function updatePasswordProfesor() {
        if (Permission::grantValidar(uri_string()) == 1) {
            $config = array(
                array(
                    'field' => 'password1',
                    'label' => 'Nombre',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => 'Campo obligatorio.'
                    )
                ),
                array(
                    'field' => 'password2',
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
                    'password1' => form_error('password1'),
                    'password2' => form_error('password2')
                );
            } else {
                if ($this->input->post('password1') == $this->input->post('password2')) {
                    $id = $this->input->post('idprofesor');
                    $password_encrypted = password_hash(trim($this->input->post('password1')), PASSWORD_BCRYPT);

                    $data = array(
                        'password' => $password_encrypted,
                        'idusuario' => $this->session->user_id,
                        'fecharegistro' => date('Y-m-d H:i:s')
                    );
                    $this->profesor->updateProfesor($id, $data);
                } else {
                    $result['error'] = true;
                    $result['msg'] = array(
                        'msgerror' => "La Contraseña no coinciden."
                    );
                }
            }
        } else {
            $result['error'] = true;
            $result['msg'] = array(
                'msgerror' => "NO TIENE PERMISO PARA REALIZAR ESTA ACCIÓN."
            );
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function searchProfesor() {
        //Permission::grant(uri_string());
        $idplantel = $this->session->idplantel;
        $value = $this->input->post('text');
        $query = $this->profesor->searchProfesor($value, $idplantel);
        if ($query) {
            $result['profesores'] = $query;
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function detalle($id) {
        Permission::grant(uri_string());
        # code...
        $data = array(
            'id' => $id,
            'detalle' => $this->profesor->detalleProfesor($id),
            'materiasprofesor' => $this->profesor->showAllMateriasProfesor($id)
        );
        $this->load->view('admin/header');
        $this->load->view('admin/profesor/detalle', $data);
        $this->load->view('admin/footer');
    }

    //MATERIAS DEL PROFESOR
    public function showAllClases() {
        //Permission::grant(uri_string()); 
        $idplantel = $this->session->idplantel;
        $query = $this->profesor->showAllClases();
        if ($query) {
            $result['clases'] = $this->profesor->showAllClases($idplantel);
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function searchllClases() {
        //Permission::grant(uri_string()); 
        $query = $this->profesor->searchMaterias();
        if ($query) {
            $result['clases'] = $this->profesor->searchMaterias();
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function showAllMaterias($idprofesor) {
        //Permission::grant(uri_string()); 
        $query = $this->profesor->showAllMateriasProfesor($idprofesor);
        if ($query) {
            $result['materias'] = $this->profesor->showAllMateriasProfesor($idprofesor);
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function addMateria() {
        if (Permission::grantValidar(uri_string()) == 1) {
            $config = array(
                array(
                    'field' => 'idmateria',
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
                    'idmateria' => form_error('idmateria')
                );
            } else {
                $idprofesor = $this->input->post('idprofesor');
                $idmateria = $this->input->post('idmateria');
                $validar = $this->profesor->validarMateriaProfesor($idprofesor, $idmateria);
                if ($validar == FALSE) {
                    $data = array(
                        'idprofesor' => $this->input->post('idprofesor'),
                        'idmateria' => $this->input->post('idmateria'),
                        'idusuario' => $this->session->user_id,
                        'fecharegistro' => date('Y-m-d H:i:s')
                    );
                    $this->profesor->addMateria($data);
                } else {
                    $result['error'] = true;
                    $result['msg'] = array(
                        'msgerror' => "Ya se le Asigno la Materia."
                    );
                }
            }
        } else {
            $result['error'] = true;
            $result['msg'] = array(
                'msgerror' => "NO TIENE PERMISO PARA REALIZAR ESTA ACCIÓN."
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
                    'field' => 'idmateria',
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
                    'idmateria' => form_error('idmateria')
                );
            } else {
                $idprofesor = $this->input->post('idprofesor');
                $id = $this->input->post('idprofesormateria');
                $idmateria = $this->input->post('idmateria');
                $validar = $this->profesor->validarMateriaProfesorUpdate($idprofesor, $idmateria, $id);
                //var_dump($validar);
                if ($validar == FALSE) {
                    //  echo "string";
                    $data = array(
                        'idmateria' => $this->input->post('idmateria'),
                        'idusuario' => $this->session->user_id,
                        'fecharegistro' => date('Y-m-d H:i:s')
                    );
                    $this->profesor->updateMateria($id, $data);
                } else {
                    $result['error'] = true;
                    $result['msg'] = array(
                        'msgerror' => "Ya se le Asigno la Materia."
                    );
                }
            }
        } else {
            $result['error'] = true;
            $result['msg'] = array(
                'msgerror' => "NO TIENE PERMISO PARA REALIZAR ESTA ACCIÓN."
            );
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function deleteMateria() {
        if (Permission::grantValidar(uri_string()) == 1) {
            $id = $this->input->get('id');
            $query = $this->profesor->deleteMateria($id);
            if ($query) {
                $result['error'] = false;
            } else {
                $result['error'] = true;
                $result['msg'] = array(
                    'msgerror' => 'No se puede Quitar la Materia.'
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

    public function deleteProfesor() {
        if (Permission::grantValidar(uri_string()) == 1) {
            $idprofesor = $this->input->get('idprofesor');
            $query = $this->profesor->deleteProfesor($idprofesor);
            if ($query) {
                $result['error'] = false;
            } else {
                $result['error'] = true;
                $result['msg'] = array(
                    'msgerror' => 'No se puede Eliminar el Profesor..'
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
