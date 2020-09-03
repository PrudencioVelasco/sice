<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("America/Mexico_City");
class Perfil extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
 if (!isset($_SESSION['user_id'])) {
            $this->session->set_flashdata('flash_data', 'You don\'t have access! ss');
            return redirect('welcome');
        }
        $this->load->helper('url');
        $this->load->model('user_model', 'usuario');
        $this->load->model('alumno_model', 'alumno');
        $this->load->model('tutor_model', 'tutor');
      $this->load->library('permission');
        $this->load->library('session');
        $this->load->library('encryption');

    }
    public function tutor()
    {
         if (isset($this->session->idtutor) && !empty($this->session->idtutor)) { 
        $idtutor = $this->session->idtutor;
        $datos_tutor = $this->usuario->datosTutor($idtutor);
        $data = array(
            'tutor' => $datos_tutor,
        );
        $this->load->view('tutor/header');
        $this->load->view('tutor/perfil/index', $data);
        $this->load->view('tutor/footer');
         } else {
            $data = array(
                'heading' => 'Error',
                'message' => 'Error intente mas tarde.',
            );
            $this->load->view('errors/html/error_general', $data);
        }
    }
       public function alumno() {
        if (isset($this->session->idalumno) && !empty($this->session->idalumno)) { 
            $this->load->view('alumno/header');
            $this->load->view('alumno/perfil/index');
            $this->load->view('alumno/footer');
        } else {
            $data = array(
                'heading' => 'Error',
                'message' => 'Error intente mas tarde.',
            );
            $this->load->view('errors/html/error_general', $data);
        }
    }

    public function showDatosTutor()
    {
       
        if(isset($this->session->idtutor) && !empty($this->session->idtutor)){
             $idtutor = $this->session->idtutor;
        $datos_tutor = $this->usuario->datosTutor($idtutor);
        if ($datos_tutor) {
            $result['datos_tutor'] = $this->usuario->datosTutor($idtutor);
        }
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }
        public function showDatosAlumno() {
        if ((isset($this->session->idalumno) && !empty($this->session->idalumno))) {
            $idalumno = $this->session->idalumno;
            $datos_tutor = $this->usuario->datosAlumno($idalumno);
            if ($datos_tutor) {
                $result['alumno'] = $this->usuario->datosAlumno($idalumno);
            }
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function showAllAlumnoTutor()
    {
         if(isset($this->session->idtutor) && !empty($this->session->idtutor)){
        $idtutor = $this->session->idtutor;
        $datos_tutor = $this->usuario->showAllAlumnosTutor($idtutor);
        if ($datos_tutor) {
            $result['alumnos'] = $this->usuario->showAllAlumnosTutor($idtutor);
        }
         }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }
    public function searchAlumnosTutor()
    {
         if(isset($this->session->idtutor) && !empty($this->session->idtutor)){
        $value = $this->input->post('text');
        $idtutor = $this->session->idtutor;
        $query = $this->usuario->searchAlumnosTutor($value, $idtutor);
        if ($query) {
            $result['alumnos'] = $query;
        }
         }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function updateAlumno()
    {

        $config = array(
            array(
                'field' => 'idespecialidad',
                'label' => 'Nombre',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.',
                ),
            ),
            array(
                'field' => 'curp',
                'label' => 'Nombre',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.',
                ),
            ),
            array(
                'field' => 'matricula',
                'label' => 'Nombre',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.',
                ),
            ),
            array(
                'field' => 'nombre',
                'label' => 'Nombre',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.',
                ),
            ),
            array(
                'field' => 'apellidop',
                'label' => 'A. Paterno',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.',
                ),
            ),
            array(
                'field' => 'lugarnacimiento',
                'label' => 'Nombre',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.',
                ),
            ),
            array(
                'field' => 'nacionalidad',
                'label' => 'Nombre',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.',
                ),
            ),
            array(
                'field' => 'domicilio',
                'label' => 'Nombre',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.',
                ),
            ),
            array(
                'field' => 'serviciomedico',
                'label' => 'Nombre',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.',
                ),
            ),
            array(
                'field' => 'idtiposanguineo',
                'label' => 'Nombre',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.',
                ),
            ),
            array(
                'field' => 'alergiaopadecimiento',
                'label' => 'Nombre',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.',
                ),
            ),
            array(
                'field' => 'estatura',
                'label' => 'Nombre',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.',
                ),
            ),
            array(
                'field' => 'peso',
                'label' => 'Nombre',
                'rules' => 'trim|required|decimal',
                'errors' => array(
                    'required' => 'Campo obligatorio.',
                    'decimal' => 'Formato decimal',
                ),
            ),
            array(
                'field' => 'fechanacimiento',
                'label' => 'Fecha nacimiento',
                'rules' => 'trim|required|callback_validarFecha',
                'errors' => array(
                    'required' => 'Campo obligatorio.',
                ),
            ),
            array(
                'field' => 'sexo',
                'label' => 'Sexo',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.',
                ),
            )
            ,
            array(
                'field' => 'telefono',
                'label' => 'Telefono',
                'rules' => 'trim|regex_match[/^[0-9]{10}$/]',
                'errors' => array(
                    'regex_match' => 'Formato invalido.',

                ),
            )
            ,
            array(
                'field' => 'telefonoemergencia',
                'label' => 'Telefono',
                'rules' => 'trim|regex_match[/^[0-9]{10}$/]',
                'errors' => array(
                    'regex_match' => 'Formato invalido.',
                ),
            ),
        );

        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == false) {
            $result['error'] = true;
            $result['msg'] = array(
                'idespecialidad' => form_error('idespecialidad'),
                'curp' => form_error('curp'),
                'nombre' => form_error('nombre'),
                'apellidop' => form_error('apellidop'),
                'matricula' => form_error('matricula'),
                'fechanacimiento' => form_error('fechanacimiento'),
                'correo' => form_error('correo'),
                'sexo' => form_error('sexo'),
                'lugarnacimiento' => form_error('lugarnacimiento'),
                'nacionalidad' => form_error('nacionalidad'),
                'serviciomedico' => form_error('serviciomedico'),
                'domicilio' => form_error('domicilio'),
                'idtiposanguineo' => form_error('idtiposanguineo'),
                'alergiaopadecimiento' => form_error('alergiaopadecimiento'),
                'estatura' => form_error('estatura'),
                'peso' => form_error('peso'),
                'telefono' => form_error('telefono'),
                'telefonoemergencia' => form_error('telefonoemergencia'),
            );

        } else {
            $idalumno = $this->input->post('idalumno');
            //$matricula = trim($this->input->post('matricula'));
            $fecha = str_replace('/', '-', $this->input->post('fechanacimiento'));
            $fecha_nacimiento = date('Y-m-d', strtotime($fecha));
            $data = array(
                'idespecialidad' => trim($this->input->post('idespecialidad')),
                'curp' => strtoupper(trim($this->input->post('curp'))),
                'nombre' => strtoupper($this->input->post('nombre')),
                'apellidop' => strtoupper($this->input->post('apellidop')),
                'apellidom' => strtoupper($this->input->post('apellidom')),
                'lugarnacimiento' => strtoupper($this->input->post('lugarnacimiento')),
                'nacionalidad' => strtoupper($this->input->post('nacionalidad')),
                'domicilio' => strtoupper($this->input->post('domicilio')),
                'telefono' => strtoupper($this->input->post('telefono')),
                'telefonoemergencia' => strtoupper($this->input->post('telefonoemergencia')),
                'serviciomedico' => strtoupper($this->input->post('serviciomedico')),
                'idtiposanguineo' => strtoupper($this->input->post('idtiposanguineo')),
                'alergiaopadecimiento' => strtoupper($this->input->post('alergiaopadecimiento')),
                'peso' => strtoupper($this->input->post('peso')),
                'estatura' => strtoupper($this->input->post('estatura')),
                'numfolio' => strtoupper($this->input->post('numfolio')),
                'numacta' => strtoupper($this->input->post('numacta')),
                'numlibro' => strtoupper($this->input->post('numlibro')),
                'fechanacimiento' => $fecha_nacimiento,
                'sexo' => $this->input->post('sexo'),
                'correo' => $this->input->post('correo'),
                'idusuario' => $this->session->user_id,
                'fecharegistro' => date('Y-m-d H:i:s'),

            );
            $this->alumno->updateAlumno($idalumno, $data);

        }

        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }

    }
    public function updateDatosTutor()
    {
        $config = array(
            array(
                'field' => 'nombre',
                'label' => 'Nombre',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.',
                ),
            ),
            array(
                'field' => 'apellidop',
                'label' => 'A. Paterno',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.',
                ),
            ),
            array(
                'field' => 'fnacimiento',
                'label' => 'Fecha nacimiento',
                'rules' => 'trim|required|callback_validarFecha',
                'errors' => array(
                    'required' => 'Campo obligatorio.',
                ),
            ), array(
                'field' => 'direccion',
                'label' => 'Dirección',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.',
                ),
            ),
            array(
                'field' => 'rfc',
                'label' => 'RFC',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.',
                ),
            ),
            array(
                'field' => 'telefono',
                'label' => 'Telefono',
                'rules' => 'trim|required|integer|exact_length[10]',
                'errors' => array(
                    'required' => 'Campo obligatorio.',
                    'integer' => 'Debe de ser solo número.',
                    'exact_length' => 'Debe de ser 10 digitos.',
                ),
            ),

        );

        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == false) {
            $result['error'] = true;
            $result['msg'] = array(
                'nombre' => form_error('nombre'),
                'apellidop' => form_error('apellidop'),
                'fnacimiento' => form_error('fnacimiento'),
                'telefono' => form_error('telefono'),
                'correo' => form_error('correo'),
                'direccion' => form_error('direccion'),
                'rfc' => form_error('rfc'),
            );
        } else {
            $idtutor = $this->input->post('idtutor');
            $correo = trim($this->input->post('correo'));
            $validar = $this->tutor->validarUpdateTutor($idtutor, $correo, $this->session->idplantel);
            if ($validar == false) {
                $fecha = str_replace('/', '-', $this->input->post('fnacimiento'));
                $fecha_nacimiento = date('Y-m-d', strtotime($fecha));
                $data = array(

                    'nombre' => strtoupper($this->input->post('nombre')),
                    'apellidop' => strtoupper($this->input->post('apellidop')),
                    'apellidom' => strtoupper($this->input->post('apellidom')),
                    'escolaridad' => strtoupper($this->input->post('escolaridad')),
                    'ocupacion' => strtoupper($this->input->post('ocupacion')),
                    'dondetrabaja' => strtoupper($this->input->post('dondetrabaja')),
                    'fnacimiento' => $fecha_nacimiento,
                    'direccion' => strtoupper($this->input->post('direccion')),
                    'telefono' => $this->input->post('telefono'),
                    'correo' => $this->input->post('correo'),
                    'rfc' => $this->input->post('rfc'),
                    'factura' => $this->input->post('factura'),
                    'idusuario' => $this->session->user_id,
                    'fecharegistro' => date('Y-m-d H:i:s'),

                );
                $this->tutor->updateTutor($idtutor, $data);

            } else {
                $result['error'] = true;
                $result['msg'] = array(
                    'msgerror' => "El correo electrico ya esta registrado.",
                );
            }

        }

        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function validarFecha($fecha)
    {
        $parts = explode("/", $fecha);
        if (count($parts) == 3) {
            if (checkdate($parts[1], $parts[0], $parts[2])) {
                return true;
            } else {
                $this->form_validation->set_message(
                    'validarFecha',
                    'Formato no valido.'
                );
                return false;
            }
        } else {
            $this->form_validation->set_message(
                'validarFecha',
                'Formato no valido.'
            );
            return false;
        }
    }
    public function updatePasswordTutor()
    {
        $config = array(
            array(
                'field' => 'passwordanterior',
                'label' => 'Nombre',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.',
                ),
            ),
            array(
                'field' => 'passwordnueva',
                'label' => 'Nombre',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.',
                ),
            ),
            array(
                'field' => 'passwordrepita',
                'label' => 'Nombre',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.',
                ),
            ),
        );

        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == false) {
            $result['error'] = true;
            $result['msg'] = array(
                'passwordanterior' => form_error('passwordanterior'),
                'passwordnueva' => form_error('passwordnueva'),
                'passwordrepita' => form_error('passwordrepita'),
            );
        } else {
            if ($this->input->post('passwordnueva') == $this->input->post('passwordrepita')) {
                if(isset($this->session->idtutor) && !empty($this->session->idtutor)){
                $id = $this->session->idtutor;
                $detalle_tutor = $this->tutor->detalleTutor($id);
                if ($detalle_tutor) {
                    if (password_verify($this->input->post('passwordanterior'), $detalle_tutor->password)) {
                        $password_encrypted = password_hash(trim($this->input->post('passwordrepita')), PASSWORD_BCRYPT);

                        $data = array(
                            'password' => $password_encrypted,
                            'idusuario' => $this->session->user_id,
                            'fecharegistro' => date('Y-m-d H:i:s'),

                        );
                        $this->tutor->updateTutor($id, $data);
                    } else {
                        $result['error'] = true;
                        $result['msg'] = array(
                            'msgerror' => "La contraseña anterior es incorrecto.",
                        );
                    }
                } else {
                    $result['error'] = true;
                    $result['msg'] = array(
                        'msgerror' => "Error... Intente mas tarde.",
                    );
                }
                
                } else {
                        $result['error'] = true;
                        $result['msg'] = array(
                            'msgerror' => "Error... Intente mas tarde.",
                        );
                    }
                    
            } else {
                $result['error'] = true;
                $result['msg'] = array(
                    'msgerror' => "La Contraseña no coinciden.",
                );
            }
        }

        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }
      public function updatePasswordAlumno()
    {
        $config = array(
            array(
                'field' => 'passwordanterior',
                'label' => 'Nombre',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.',
                ),
            ),
            array(
                'field' => 'passwordnueva',
                'label' => 'Nombre',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.',
                ),
            ),
            array(
                'field' => 'passwordrepita',
                'label' => 'Nombre',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.',
                ),
            ),
        );

        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == false) {
            $result['error'] = true;
            $result['msg'] = array(
                'passwordanterior' => form_error('passwordanterior'),
                'passwordnueva' => form_error('passwordnueva'),
                'passwordrepita' => form_error('passwordrepita'),
            );
        } else {
            if ($this->input->post('passwordnueva') == $this->input->post('passwordrepita')) {
                if(isset($this->session->idalumno) && !empty($this->session->idalumno)){
                $id = $this->session->idalumno;
                $detalle_alumno = $this->usuario->datosAlumno($id);
                if ($detalle_alumno) {
                    if (password_verify($this->input->post('passwordanterior'), $detalle_alumno->password)) {
                        $password_encrypted = password_hash(trim($this->input->post('passwordrepita')), PASSWORD_BCRYPT);

                        $data = array(
                            'password' => $password_encrypted,
                            'idusuario' => $this->session->user_id,
                            'fecharegistro' => date('Y-m-d H:i:s'),

                        );
                        $this->usuario->updateAlumno($id, $data);
                    } else {
                        $result['error'] = true;
                        $result['msg'] = array(
                            'msgerror' => "La contraseña anterior es incorrecto.",
                        );
                    }
                } else {
                    $result['error'] = true;
                    $result['msg'] = array(
                        'msgerror' => "Error... Intente mas tarde.",
                    );
                }
                
                } else {
                        $result['error'] = true;
                        $result['msg'] = array(
                            'msgerror' => "Error... Intente mas tarde.",
                        );
                    }
                    
            } else {
                $result['error'] = true;
                $result['msg'] = array(
                    'msgerror' => "La Contraseña no coinciden.",
                );
            }
        }

        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function subirFotoTutor()
    {
        $mi_archivo = 'file';
        $config['upload_path'] = "assets/tutores/";
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
            //*** ocurrio un error
            //$data['state'] = 500;
            //$data['message'] = $this->upload->display_errors();
            //echo $this->upload->display_errors();
            // echo json_encode($data);
            $result['state'] = 500;
            $result['msg'] = array(
                'msgerror' => $this->upload->display_errors(),
            );
            return;
        } else {
            $id = $this->session->idtutor;
            $data = array(
                'foto' => $user_img_profile,
                'idusuario' => $this->session->user_id,
                'fecharegistro' => date('Y-m-d H:i:s'),

            );
            $this->tutor->updateTutor($id, $data);
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }
}