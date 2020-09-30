<?php

defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("America/Mexico_City");

//include_once(dirname(__FILE__)."/Calificacion.php");
class Alumno extends CI_Controller {

    function __construct() {
        parent::__construct();
        if (!isset($_SESSION['user_id'])) {
            $this->session->set_flashdata('flash_data', 'You don\'t have access! ss');
            return redirect('welcome');
        }
        $this->load->helper('url');
        $this->load->model('alumno_model', 'alumno');
        $this->load->model('grupo_model', 'grupo');
        $this->load->model('horario_model', 'horario');
        $this->load->model('user_model', 'user');
        $this->load->model('cicloescolar_model', 'cicloescolar');
        $this->load->model('configuracion_model', 'configuracion');
        $this->load->model('data_model');

        $this->load->library('pdfgenerator');
        $this->load->helper('numeroatexto_helper');
        $this->load->library('encryption');
        $this->load->library('permission');
        $this->load->library('session');
    }

    public function inicio() {
        Permission::grant(uri_string());
        $data = array(
            'controller' => $this
        );
        $this->load->view('admin/header');
        $this->load->view('admin/alumno/index', $data);
        $this->load->view('admin/footer');
    }

    public function reprobadas() {
           Permission::grant(uri_string());
        $this->load->view('admin/header');
        $this->load->view('admin/alumno/reprobada');
        $this->load->view('admin/footer');
    }

    function encode($string) {
        $encrypted = $this->encryption->encrypt($string);
        if (!empty($string)) {
            $encrypted = strtr($encrypted, array('/' => '~'));
        }
        return $encrypted;
    }

    function decode($string) {
        $string = strtr($string, array('~' => '/'));
        return $this->encryption->decrypt($string);
    }

    public function showAll() {
        //Permission::grant(uri_string()); 
        $idplantel = $this->session->idplantel;
        $query = $this->alumno->showAll($idplantel);

        if ($query) {
            $result['alumnos'] = $this->alumno->showAll($idplantel);
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function showAllMateriasAsignadas() {
        $idplantel = $this->session->idplantel;
        $query = $this->alumno->materiasAsignadas($idplantel);

        if ($query) {
            $result['materiasasignadas'] = $this->alumno->materiasAsignadas($idplantel);
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function showAllMateriasPendientesAAsignar() {
        $idplantel = $this->session->idplantel;
        $query = $this->alumno->materiaPendientesAAsignar($idplantel);

        if ($query) {
            $result['materiaspendientesaasignar'] = $this->alumno->materiaPendientesAAsignar($idplantel);
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function showAllMateriaParaAsignar() {
        $idplantel = $this->session->idplantel;
        $idreprobada = $this->input->get('idreprobada');
        $detalle = $this->alumno->detalleReprobado($idreprobada);
        $idmateria = $detalle->idmateria;
        $query = $this->alumno->showMateriaParaAsignar($idmateria, $idplantel);

        if ($query) {
            $result['materiasdisponibles'] = $this->alumno->showMateriaParaAsignar($idmateria, $idplantel);
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    //  $datag = $this->alumno->detalleGrupoActual($id);
    public function grupoActual() {
        $id = $this->input->get('idalumno');
        $query = $this->alumno->detalleGrupoActual($id);
        if ($query) {
            $result['grupoactual'] = $this->alumno->detalleGrupoActual($id);
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    // $becas  = $this->alumno->showAllBecas();
    public function showAllBecas() {

        $query = $this->alumno->showAllBecas();
        if ($query) {
            $result['becas'] = $this->alumno->showAllBecas();
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function becaActual() {
        $id = $this->input->get('idalumno');
        $query = $this->alumno->becaAlumno($id);
        if ($query) {
            $result['becaactual'] = $this->alumno->becaAlumno($id);
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function estatusAlumno(){
        $id = $this->input->get('idalumno');
        $query = $this->alumno->estatusAlumno($id);

        if ($query) {
            $result['estatusalumno'] = $this->alumno->estatusAlumno($id);
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function detalleAlumno() {
        $id = $this->input->get('idalumno');
        $query = $this->alumno->detalleAlumno($id);
        if ($query) {
            $result['alumno'] = $this->alumno->detalleAlumno($id);
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    // $cicloescolar_activo = $this->cicloescolar->showAllCicloEscolarActivo($this->session->idplantel);
    public function showAllCiclosEscolar() {

        $query = $this->cicloescolar->showAllCicloEscolarActivo($this->session->idplantel);
        if ($query) {
            $result['cicloescolar'] = $this->cicloescolar->showAllCicloEscolarActivo($this->session->idplantel);
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function showAllEstatusAlumno() {
        $query = $this->alumno->showAllEstatusAlumno();
        if ($query) {
            $result['estatusalumno'] = $this->alumno->showAllEstatusAlumno();
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function calificacionFinal() {
        $idalumno = $this->input->get('idalumno');
        $idplantel = $this->session->idplantel;
        $suma_calificacion = 0;
        $contador = 0;
        $calificacion_final = 0.0;
        $consulta = $this->alumno->calificacionFinal($idalumno, $idplantel);
                 
        if ($consulta) {
            foreach ($consulta as $row) {
                $contador++;
                if($row->calificacionxperiodo > 7.00){
                    $suma_calificacion += $row->calificacionxperiodo;
                }
            }
            $calificacion_final = number_format($suma_calificacion / $contador,2);
            //$calificacion_final =  $suma_calificacion;
        }
        $result['datos'] = array(
            'promedio' => $calificacion_final
        );
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function showAllGrupos() {

        $idplantel = $this->session->idplantel;
        $query = $this->alumno->showAllGrupos($idplantel);
        if ($query) {
            $result['grupos'] = $this->alumno->showAllGrupos($idplantel);
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function showAllEspecialidades() {
        //Permission::grant(uri_string()); 
        $idplantel = $this->session->idplantel;

        $query = $this->alumno->showAllEspecialidades($idplantel);
        if ($query) {
            $result['especialidades'] = $this->alumno->showAllEspecialidades($idplantel);
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function showAllTiposSanguineos() {
        //Permission::grant(uri_string());  ;
        $query = $this->alumno->showAllTiposSanguineos();
        if ($query) {
            $result['tipossanguineos'] = $this->alumno->showAllTiposSanguineos();
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function showAllTutores($id) {
        // Permission::grant(uri_string()); 
        //$this->session->user_id,
        $query = $this->alumno->showAllTutores($id);
        if ($query) {
            $result['tutores'] = $this->alumno->showAllTutores($id);
        }
        echo json_encode($result);
    }

    public function showAllTutoresDisponibles() {
        //Permission::grant(uri_string()); 
        $idplantel = $this->session->idplantel;
        $query = $this->alumno->showAllTutoresDisponibles($idplantel);
        if ($query) {
            $result['tutores'] = $this->alumno->showAllTutoresDisponibles($idplantel);
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function asignarReprobado() {
        if (Permission::grantValidar(uri_string()) == 1) {

        $config = array(
            array(
                'field' => 'idreprobada',
                'label' => 'Nombre',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),
            array(
                'field' => 'idhorariodetalle',
                'label' => 'Nombre',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),
        );

        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            $result['error'] = true;
            $result['msg'] = array(
                'idreprobada' => form_error('idreprobada'),
                'idhorariodetalle' => form_error('idhorariodetalle')
            );
        } else {

            $idhorariodetalle = trim($this->input->post('idhorariodetalle'));
            $detalle_horario = $this->horario->detalleHorarioDetalle($idhorariodetalle);
            $idreprobada = trim($this->input->post('idreprobada'));
            $data = array(
                'idreprobada' => $idreprobada,
                'idhorario' => $detalle_horario[0]->idhorario,
                'idprofesormateria' => $detalle_horario[0]->idprofesormateria,
                'idusuario' => $this->session->user_id,
                'fecharegistro' => date('Y-m-d H:i:s'),
            );
            $this->horario->addDetalleReprobado($data);
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

    public function addAlumno() {
        if (Permission::grantValidar(uri_string()) == 1) {

            $config = array(
                array(
                    'field' => 'idespecialidad',
                    'label' => 'Nombre',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => 'Campo obligatorio.'
                    )
                ),
                array(
                    'field' => 'curp',
                    'label' => 'Nombre',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => 'Campo obligatorio.'
                    )
                ),
                array(
                    'field' => 'matricula',
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
                ),
//                array(
//                    'field' => 'lugarnacimiento',
//                    'label' => 'Nombre',
//                    'rules' => 'trim|required',
//                    'errors' => array(
//                        'required' => 'Campo obligatorio.'
//                    )
//                ),
                array(
                    'field' => 'nacionalidad',
                    'label' => 'Nombre',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => 'Campo obligatorio.'
                    )
                ),
                array(
                    'field' => 'domicilio',
                    'label' => 'Nombre',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => 'Campo obligatorio.'
                    )
                ),
//                array(
//                    'field' => 'serviciomedico',
//                    'label' => 'Nombre',
//                    'rules' => 'trim|required',
//                    'errors' => array(
//                        'required' => 'Campo obligatorio.'
//                    )
//                ),
                array(
                    'field' => 'idtiposanguineo',
                    'label' => 'Nombre',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => 'Campo obligatorio.'
                    )
                ),
//                array(
//                    'field' => 'alergiaopadecimiento',
//                    'label' => 'Nombre',
//                    'rules' => 'trim|required',
//                    'errors' => array(
//                        'required' => 'Campo obligatorio.'
//                    )
//                ),
//                array(
//                    'field' => 'estatura',
//                    'label' => 'Nombre',
//                    'rules' => 'trim|required|decimal',
//                    'errors' => array(
//                        'required' => 'Campo obligatorio.',
//                        'decimal' => 'Formato decimal'
//                    )
//                ),
//                array(
//                    'field' => 'peso',
//                    'label' => 'Nombre',
//                    'rules' => 'trim|required|decimal',
//                    'errors' => array(
//                        'required' => 'Campo obligatorio.',
//                        'decimal' => 'Formato decimal'
//                    )
//                ),
                array(
                    'field' => 'fechanacimiento',
                    'label' => 'Fecha nacimiento',
                    'rules' => 'trim|required|callback_validarFecha',
                    'errors' => array(
                        'required' => 'Campo obligatorio.'
                    )
                ),
//                array(
//                    'field' => 'password',
//                    'label' => 'Contraseña',
//                    'rules' => 'trim|required',
//                    'errors' => array(
//                        'required' => 'Campo obligatorio.'
//                    )
//                )
//                ,
                array(
                    'field' => 'sexo',
                    'label' => 'Sexo',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => 'Campo obligatorio.'
                    )
                )
                ,
                array(
                    'field' => 'telefono',
                    'label' => 'Telefono',
                    'rules' => 'trim|regex_match[/^[0-9]{10}$/]|required',
                    'errors' => array(
                        'regex_match' => 'Formato incorrecto.',
                        'required' => 'Campo obligatorio.'
                    )
                )
                ,
                array(
                    'field' => 'telefonoemergencia',
                    'label' => 'Telefono',
                    'rules' => 'trim|regex_match[/^[0-9]{10}$/]|required',
                    'errors' => array(
                        'regex_match' => 'Formato incorrecto.',
                        'required' => 'Campo obligatorio.'
                    )
                )
            );

            $this->form_validation->set_rules($config);
            if ($this->form_validation->run() == FALSE) {
                $result['error'] = true;
                $result['msg'] = array(
                    'idespecialidad' => form_error('idespecialidad'),
                    'curp' => form_error('curp'),
                    'nombre' => form_error('nombre'),
                    'apellidop' => form_error('apellidop'),
                    'matricula' => form_error('matricula'),
                    'fechanacimiento' => form_error('fechanacimiento'),
                    'correo' => form_error('correo'),
                    'password' => form_error('password'),
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
                    'telefonoemergencia' => form_error('telefonoemergencia')
                );
            } else {

                $matricula = trim($this->input->post('matricula'));
                $validar = $this->alumno->validarMatricula($matricula, $this->session->idplantel);
                   $fechanacimiento = $this->input->post('fechanacimiento');
                   $password = trim($this->input->post('password'));
                  $date = str_replace('/', '-', $fechanacimiento);
                if ($validar == FALSE) {
                    $data = array(
                        'idplantel' => $this->session->idplantel,
                        'idespecialidad' =>$this->input->post('idespecialidad'),
                        'matricula' => $this->input->post('matricula'),
                        'curp' => mb_strtoupper($this->input->post('curp')),
                        'nombre' => mb_strtoupper($this->input->post('nombre')),
                        'apellidop' => mb_strtoupper($this->input->post('apellidop')),
                        'apellidom' => mb_strtoupper($this->input->post('apellidom')),
                        'lugarnacimiento' => mb_strtoupper($this->input->post('lugarnacimiento')),
                        'nacionalidad' => mb_strtoupper($this->input->post('nacionalidad')),
                        'domicilio' => mb_strtoupper($this->input->post('domicilio')),
                        'telefono' => mb_strtoupper($this->input->post('telefono')),
                        'telefonoemergencia' => mb_strtoupper($this->input->post('telefonoemergencia')),
                        'serviciomedico' => mb_strtoupper($this->input->post('serviciomedico')),
                        'idtiposanguineo' => mb_strtoupper($this->input->post('idtiposanguineo')),
                        'alergiaopadecimiento' => mb_strtoupper($this->input->post('alergiaopadecimiento')),
                        'peso' => mb_strtoupper($this->input->post('peso')),
                        'estatura' => mb_strtoupper($this->input->post('estatura')),
                        'numfolio' => mb_strtoupper($this->input->post('numfolio')),
                        'numacta' => mb_strtoupper($this->input->post('numacta')),
                        'numlibro' => mb_strtoupper($this->input->post('numlibro')),
                        'fechanacimiento' =>date('Y-m-d', strtotime($date)),
                        'foto' => '',
                        'sexo' => $this->input->post('sexo'),
                        'correo' => $this->input->post('correo'),
                        'password' => (isset($password) && !empty($password))?  password_hash($password, PASSWORD_DEFAULT): password_hash('admin', PASSWORD_DEFAULT),
                        'idalumnoestatus' => 1,
                        'idusuario' => $this->session->user_id,
                        'fecharegistro' => date('Y-m-d H:i:s'),
                    );
                    $idalumno = $this->alumno->addAlumno($data);
                    $datausuario = array(
                        'idusuario' => $idalumno,
                        'idtipousuario' => 3,
                        'fecharegistro' => date('Y-m-d H:i:s')
                    );
                    $idusuario = $this->user->addUser($datausuario);
                    $data_usuario_rol = array(
                        'id_rol' => 12,
                        'id_user' => $idusuario
                    );
                    $id_usuario_rol = $this->user->addUserRol($data_usuario_rol);
                } else {
                    $result['error'] = true;
                    $result['msg'] = array(
                        'msgerror' => 'La Matricula ya esta registrado.'
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

    public function addTutorAlumnotest() {
        echo Permission::grantValidar(uri_string());
        if (Permission::grantValidar(uri_string()) == NULL) {
            //echo 0;
        } else {
            // echo 1;
        }
    }

//$numeroSemana = date("W"); 
    function validarFecha($fecha) {
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

    public function addTutorAlumno() {

        if (Permission::grantValidar(uri_string()) == 1) {
            $config = array(
                array(
                    'field' => 'idtutor',
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
                    'idtutor' => form_error('idtutor')
                );
            } else {
                $idtutor = $this->input->post('idtutor');
                $idalumno = $this->input->post('idalumno');
                $validar = $this->alumno->validarAsignarTutor($idalumno, $idtutor, $this->session->idplantel);
                if (!$validar) {
                    $data = array(
                        'idtutor' => $this->input->post('idtutor'),
                        'idalumno' => $this->input->post('idalumno')
                    );
                    $this->alumno->addTutorAlumno($data);
                } else {
                    $result['error'] = true;
                    $result['msg'] = array(
                        'msgerror' => 'Ya esta asignado el Tutor al Alumno.'
                    );
                }
            }
        } else {
            $result['error'] = true;
            $result['msg'] = array(
                'msgerror' => 'NO TIENE PERMISOS PARA REALIZAR ESTA ACCIÓN.'
            );
        }

        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function updateAlumno() {
        if (Permission::grantValidar(uri_string()) == 1) {
            $config = array(
                array(
                    'field' => 'idespecialidad',
                    'label' => 'Nombre',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => 'Campo obligatorio.'
                    )
                ),
                array(
                    'field' => 'curp',
                    'label' => 'Nombre',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => 'Campo obligatorio.'
                    )
                ),
                array(
                    'field' => 'matricula',
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
                ),
//                array(
//                    'field' => 'lugarnacimiento',
//                    'label' => 'Nombre',
//                    'rules' => 'trim|required',
//                    'errors' => array(
//                        'required' => 'Campo obligatorio.'
//                    )
//                ),
                array(
                    'field' => 'nacionalidad',
                    'label' => 'Nombre',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => 'Campo obligatorio.'
                    )
                ),
                array(
                    'field' => 'domicilio',
                    'label' => 'Nombre',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => 'Campo obligatorio.'
                    )
                ),
//                array(
//                    'field' => 'serviciomedico',
//                    'label' => 'Nombre',
//                    'rules' => 'trim|required',
//                    'errors' => array(
//                        'required' => 'Campo obligatorio.'
//                    )
//                ),
                array(
                    'field' => 'idtiposanguineo',
                    'label' => 'Nombre',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => 'Campo obligatorio.'
                    )
                ),
//                array(
//                    'field' => 'alergiaopadecimiento',
//                    'label' => 'Nombre',
//                    'rules' => 'trim|required',
//                    'errors' => array(
//                        'required' => 'Campo obligatorio.'
//                    )
//                ),
//                array(
//                    'field' => 'estatura',
//                    'label' => 'Nombre',
//                    'rules' => 'trim|required',
//                    'errors' => array(
//                        'required' => 'Campo obligatorio.'
//                    )
//                ),
//                array(
//                    'field' => 'peso',
//                    'label' => 'Nombre',
//                    'rules' => 'trim|required|decimal',
//                    'errors' => array(
//                        'required' => 'Campo obligatorio.',
//                        'decimal' => 'Formato decimal'
//                    )
//                ),
                array(
                    'field' => 'fechanacimiento',
                    'label' => 'Fecha nacimiento',
                    'rules' => 'trim|required|callback_validarFecha',
                    'errors' => array(
                        'required' => 'Campo obligatorio.'
                    )
                ),
                array(
                    'field' => 'sexo',
                    'label' => 'Sexo',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => 'Campo obligatorio.'
                    )
                )
                , array(
                    'field' => 'idestatusalumno',
                    'label' => 'Estatus Alumno',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => 'Campo obligatorio.'
                    )
                )
                ,
                array(
                    'field' => 'telefono',
                    'label' => 'Telefono',
                    'rules' => 'trim|regex_match[/^[0-9]{10}$/]',
                    'errors' => array(
                        'regex_match' => 'Formato invalido.',
                    )
                )
                ,
                array(
                    'field' => 'telefonoemergencia',
                    'label' => 'Telefono',
                    'rules' => 'trim|regex_match[/^[0-9]{10}$/]',
                    'errors' => array(
                        'regex_match' => 'Formato invalido.',
                    )
                )
            );

            $this->form_validation->set_rules($config);
            if ($this->form_validation->run() == FALSE) {
                $result['error'] = true;
                $result['msg'] = array(
                    'idespecialidad' => form_error('idespecialidad'),
                    'curp' => form_error('curp'),
                    'nombre' => form_error('nombre'),
                    'apellidop' => form_error('apellidop'),
                    'matricula' => form_error('matricula'),
                    'fechanacimiento' => form_error('fechanacimiento'),
                    'correo' => form_error('correo'),
                    //'password' => form_error('password'),
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
                    'idestatusalumno' => form_error('idestatusalumno')
                );
            } else {
                 $fechanacimiento = $this->input->post('fechanacimiento');
                  $date = str_replace('/', '-', $fechanacimiento);
                            
                $idalumno = $this->input->post('idalumno');
                $matricula = trim($this->input->post('matricula'));
                $validar = $this->alumno->validarMatricula($matricula, $idalumno, $this->session->idplantel);
                if ($validar == false) {
                    $data = array(
                        'idplantel' => $this->session->idplantel,
                        'idespecialidad' => $this->input->post('idespecialidad'),
                        'matricula' => $this->input->post('matricula'),
                        'curp' => mb_strtoupper($this->input->post('curp')),
                        'nombre' => mb_strtoupper($this->input->post('nombre')),
                        'apellidop' => mb_strtoupper($this->input->post('apellidop')),
                        'apellidom' => mb_strtoupper($this->input->post('apellidom')),
                        'lugarnacimiento' => mb_strtoupper($this->input->post('lugarnacimiento')),
                        'nacionalidad' => mb_strtoupper($this->input->post('nacionalidad')),
                        'domicilio' => mb_strtoupper($this->input->post('domicilio')),
                        'telefono' => mb_strtoupper($this->input->post('telefono')),
                        'telefonoemergencia' => mb_strtoupper($this->input->post('telefonoemergencia')),
                        'serviciomedico' => mb_strtoupper($this->input->post('serviciomedico')),
                        'idtiposanguineo' => mb_strtoupper($this->input->post('idtiposanguineo')),
                        'alergiaopadecimiento' => mb_strtoupper($this->input->post('alergiaopadecimiento')),
                        'peso' => mb_strtoupper($this->input->post('peso')),
                        'estatura' => mb_strtoupper($this->input->post('estatura')),
                        'numfolio' => mb_strtoupper($this->input->post('numfolio')),
                        'numacta' => mb_strtoupper($this->input->post('numacta')),
                        'numlibro' => mb_strtoupper($this->input->post('numlibro')),
                        'fechanacimiento' =>date('Y-m-d', strtotime($date)),
                        'sexo' => $this->input->post('sexo'),
                        'correo' => $this->input->post('correo'),
                        'idalumnoestatus' => $this->input->post('idestatusalumno'),
                        'idusuario' => $this->session->user_id,
                        'fecharegistro' => date('Y-m-d H:i:s'),
                    );
                    $modificar = $this->alumno->updateAlumno($idalumno, $data);
                } else {
                    $result['error'] = true;
                    $result['msg'] = array(
                        'msgerror' => 'La Matricula ya esta registrado.'
                    );
                }
            }
        } else {
            $result['error'] = true;
            $result['msg'] = array(
                'msgerror' => 'NO TIENE PERMISOS PARA REALIZAR ESTA ACCIÓN.'
            );
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function searchAlumno() {
        //Permission::grant(uri_string());
        $value = $this->input->post('text');
        $idplantel = $this->session->idplantel;
        $query = $this->alumno->searchAlumno($value, $idplantel);
        if ($query) {
            $result['alumnos'] = $query;
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function searchTutor($idalumno) {
        //Permission::grant(uri_string());
        $value = $this->input->post('text');
        $query = $this->alumno->searchTutores($value, $idalumno);
        if ($query) {
            $result['tutores'] = $query;
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

                            
    public function detalle($id) {
        Permission::grant(uri_string());
        $kardex = $this->alumno->allKardex($id);
        $cicloescolar_activo = $this->cicloescolar->showAllCicloEscolar($this->session->idplantel);
         
        $grupo_actual = "";
        $valida_grupo = $this->alumno->validadAlumnoGrupo($id);
        if ($valida_grupo) {
            $datag = $this->alumno->detalleGrupoActual($id);
            $grupo_actual = $datag->nombrenivel . " " . $datag->nombregrupo . " - " . $datag->nombreturno;
        }
        $becas = $this->alumno->showAllBecas();

        //Codigo para obtener la caficacion Final
        $calificacion_final = 0;
        $total_periodo = 0;
        $suma_calificacion = 0;
        if ($kardex != FALSE) {
            foreach ($kardex as $row) {
                $total_periodo = $total_periodo + 1;
                $idhorario = $row->idhorario;
                $materias = $this->alumno->showAllMaterias($idhorario);
                $unidades = $this->alumno->showAllUnidades($this->session->idplantel); 
                $total_materia = 0;
                $total_unidad = 0;
                if ($materias != FALSE) {
                    foreach ($materias as $row) {
                        $total_materia = $total_materia + 1;
                    }
                }
                if (isset($unidades) && !empty($unidades)) {
                    foreach ($unidades as $value) {
                        $total_unidad = $total_unidad + 1;
                    }
                }
                $datoscalifiacacion = $this->horario->calificacionGeneralAlumno($idhorario, $id);
                if ($datoscalifiacacion != FALSE && $total_materia > 0) {
                    $suma_calificacion = ($datoscalifiacacion->calificaciongeneral / $total_unidad) / $total_materia;
                } 
            }
            $calificacion_final = $suma_calificacion / $total_periodo;
        }
        $tutores = $this->alumno->showAllTutorAlumno($id);

        $data = array(
            'id' => $id,
            'detalle' => $this->alumno->detalleAlumno($id),
            'nivelestudio' => $this->alumno->nivelEstudio($id),
            'validargrupo' => $this->alumno->validadAlumnoGrupo($id),
            'grupos' => $this->alumno->showAllGrupos($this->session->idplantel),
            'grupoactual' => $grupo_actual,
            'promediogeneral' => $calificacion_final,
            'kardex' => $kardex,
            'cicloescolar' => $cicloescolar_activo,
            'becas' => $becas,
            'tutores' => $tutores
        );
        $this->load->view('admin/header');
        $this->load->view('admin/alumno/detalle', $data);
        $this->load->view('admin/footer');
    }

    public function horario($idhorario, $idalumno) {
        # code...
        Permission::grant(uri_string());
        //$tabla = $this->obtenerCalificacion($idhorario);
        $data = array(
            'idhorario' => $idhorario,
            'idalumno' => $idalumno,
            'controller' => $this,
            'tabla' => $this->generarHorarioPDFNuevo($idhorario, $idalumno)
        );
        $this->load->view('admin/header');
        $this->load->view('admin/alumno/horario', $data);
        $this->load->view('admin/footer');
    }

    public function generarHorarioPDFNuevo($idhorario = '', $idalumno = '') {
        /* $idhorario = $this->decode($idhorario);
          $idalumno = $this->decode($idalumno);
          if((isset($idhorario) && !empty($idhorario)) && (isset($idalumno) && !empty($idalumno)) ){
         */
        $detalle_logo = $this->alumno->logo($this->session->idplantel);
        $logo = base_url() . '/assets/images/escuelas/' . $detalle_logo[0]->logoplantel;
        $logo2 = base_url() . '/assets/images/escuelas/' . $detalle_logo[0]->logosegundo;

        $alumno = $this->alumno->detalleAlumno($idalumno);
        $grupo = $this->horario->showNivelGrupo($idhorario);
        $dias = $this->alumno->showAllDias();
        $datelle_alumno = $this->alumno->showAllMateriasAlumno($idalumno);
        if (isset($datelle_alumno) && !empty($datelle_alumno)) {
            $this->load->library('tcpdf');
            $hora = date("h:i:s a");
            //$linkimge = base_url() . '/assets/images/woorilogo.png';
            $fechaactual = date('d/m/Y');
            $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
            $pdf->SetTitle('Horario de clases.');
            $pdf->SetHeaderMargin(30);
            $pdf->SetTopMargin(10);
            $pdf->setFooterMargin(20);
            $pdf->SetAutoPageBreak(true);
            $pdf->SetAuthor('Author');
            $pdf->SetDisplayMode('real', 'default');
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);

            $pdf->AddPage();
            $tabla = '
        <style type="text/css">
    .txtn{
        font-size:12px;
    }
    .direccion{
        font-size:12px;
    }
    .nombreplantel{
        font-size:16px;
        font-weight:bolder;
    }
    .telefono{
          font-size:12px;
    }
    .boleta{
         font-size:9px;
         font-weight:bolder;
    }
     .periodo{
         font-size:9px;
         font-weight:bolder;
    }
    .txtgeneral{
         font-size:8px;
         font-weight:bolder; 
    }
    .txtnota{
         font-size:6px;
         font-weight:bolder; 
    } 
    .txtcalificacion{
        font-size:10px;
         font-weight:bolder; 
    } 
    .imgtitle{
        width:55px;

    }
    .titulo{
     font-family:Verdana, Geneva, sans-serif;
      font-size:11px; 
    font-weight:bold;
    border-bottom:solid 1px #000000;
}
.result{
     font-family:Verdana, Geneva, sans-serif;
      font-size:12px; 
    font-weight:bold;
}.nombreclase{
   font-size:12px;
   font-weight: bold;
}
.txthorario{
   font-size:10px;
}
.txttutor{
   font-size:10px;
}
.txtdia{
  font-size:15px;
   font-weight: bold;
   background-color:#ccc;
}
</style>
<div id="areimprimir">  
          <table width="950" border="0" cellpadding="2" cellspacing="0">
  <tr>
    <td width="101" align="center"><img   class="imgtitle" src="' . $logo2 . '" /></td>
    <td colspan="2" align="center">
            <label class="nombreplantel">' . $datelle_alumno[0]->nombreplantel . '</label><br>
            <label class="txtn">' . $datelle_alumno[0]->asociado . '</label><br>
            <label class="direccion">' . $datelle_alumno[0]->direccion . '</label><br>
            <label class="telefono">TELÉFONO: ' . $datelle_alumno[0]->telefono . ' EXT 1</label>
    </td>
    <td width="137" align="center"><img   class="imgtitle" src="' . $logo . '" /></td>
  </tr> 
    <tr>
    <td align="center"  style=""><label class="titulo">Matricula</label></td>
    <td align="center"  style=""><label class="titulo">Alumno</label></td>
    <td align="center"  style=""><label class="titulo">Nivel Escolar</label></td>
    <td align="center"  style=""><label class="titulo">Periodo Escolar</label></td>
  </tr>
  <tr>
    <td align="center"><label class="result">' . $alumno->matricula . '</label></td>
    <td align="center"><label class="result">' . $alumno->nombre . ' ' . $alumno->apellidop . ' ' . $alumno->apellidom . '</label></td>
    <td align="center"><label class="result">' . $grupo->nombrenivel . ' ' . $grupo->nombregrupo . '</label></td>
    <td align="center"><label class="result">' . $grupo->mesinicio . ' ' . $grupo->yearinicio . ' - ' . $grupo->mesfin . ' ' . $grupo->yearfin . '</label></td>
  </tr> 
  </table> <br/>';

            $tabla .= '<table  width="950" border="1">
      <thead> 
    ';
            foreach ($dias as $dia):
                $tabla .= '<th align="center" class="txtdia text-center">' . $dia->nombredia . '</th>';
            endforeach;

            $tabla .= '</thead>';
            $c = 1;
            //$alumn = $al->getAlumn();

            $tabla .= '<tr valign="top">';
            foreach ($dias as $block):
                $lunes = $this->horario->showAllDiaHorario($idhorario, $block->iddia);
                $tabla .= '<td>';
                $tabla .= '<table   border="0" >';
                if ($lunes != false) {
                    foreach ($lunes as $row) {
                        $tabla .= '<tr>
              <td width="200" style="border-bottom:solid #ccc 1px; height:70px; padding-left:5px; padding-right:5px;">';
                        if (strtoupper($row->opcion) == "NORMAL") {
                            $tabla .= '<ul>';
                            $tabla .= '<li class="nombreclase">' . $row->nombreclase . '</li>';
                            $tabla .= '<li class="txthorario">' . date('h:i A', strtotime($row->horainicial)) . ' - ' . date('h:i A', strtotime($row->horafinal)) . '</li>';
                            $tabla .= '<li class="txttutor">' . $row->nombre . ' ' . $row->apellidop . ' ' . $row->apellidom . '</li>';
                            $tabla .= '</ul>';
                        }
                        if (strtoupper($row->opcion) == "DESCANSO") {
                            $tabla .= '<label class="nombreclase"> ' . $row->nombreclase . '</label>';
                        }
                        if (strtoupper($row->opcion) == "SIN CLASES") {
                            //$tabla.='<label class="nombreclase">SIN CLASES</label>';
                        }
                        $tabla .= '</td>
            </tr>';
                    }
                } else {
                    $tabla .= '<label>No registrado</label>';
                }
                $tabla .= '</table>';
                $tabla .= '</td>';
            endforeach;

            $tabla .= '</tr>';



            $tabla .= '</table></div>';

            return $tabla;
        } else {
            return "";
        }
    }

    public function descargar($idhorario = '', $idalumno = '') {
        $idalumno = $this->decode($idalumno);
        $idhorario = $this->decode($idhorario);
        if ((isset($idhorario) && !empty($idhorario)) && (isset($idalumno) && !empty($idalumno))) {
            $detalle_logo = $this->alumno->logo($this->session->idplantel);
            $logo = base_url() . '/assets/images/escuelas/' . $detalle_logo[0]->logoplantel;
            $logo2 = base_url() . '/assets/images/escuelas/' . $detalle_logo[0]->logosegundo;
            $lunes = $this->horario->showAllDiaHorario($idhorario, 1);
            $martes = $this->horario->showAllDiaHorario($idhorario, 2);
            $miercoles = $this->horario->showAllDiaHorario($idhorario, 3);
            $jueves = $this->horario->showAllDiaHorario($idhorario, 4);
            $viernes = $this->horario->showAllDiaHorario($idhorario, 5);
            $alumno = $this->alumno->detalleAlumno($idalumno);
            $grupo = $this->horario->showNivelGrupo($idhorario);
            $dias = $this->alumno->showAllDias();
            $datelle_alumno = $this->alumno->showAllMateriasAlumno($idalumno);
            $this->load->library('tcpdf');
            $hora = date("h:i:s a");
            //$linkimge = base_url() . '/assets/images/woorilogo.png';
            $fechaactual = date('d/m/Y');
            $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
            $pdf->SetTitle('Horario de clases.');
            $pdf->SetHeaderMargin(30);
            $pdf->SetTopMargin(10);
            $pdf->setFooterMargin(20);
            $pdf->SetAutoPageBreak(true);
            $pdf->SetAuthor('Author');
            $pdf->SetDisplayMode('real', 'default');
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);

            $pdf->AddPage();
            $tabla = '
        <style type="text/css">
    .txtn{
        font-size:12px;
    }
    .direccion{
        font-size:12px;
    }
    .nombreplantel{
        font-size:16px;
        font-weight:bolder;
    }
    .telefono{
          font-size:12px;
    }
    .boleta{
         font-size:9px;
         font-weight:bolder;
    }
     .periodo{
         font-size:9px;
         font-weight:bolder;
    }
    .txtgeneral{
         font-size:8px;
         font-weight:bolder; 
    }
    .txtnota{
         font-size:6px;
         font-weight:bolder; 
    } 
    .txtcalificacion{
        font-size:10px;
         font-weight:bolder; 
    } 
    .imgtitle{
        width:55px;

    }
    .titulo{
     font-family:Verdana, Geneva, sans-serif;
      font-size:10px; 
    font-weight:bold;
    border-bottom:solid 1px #000000; 
}
@page{
  size:0;
  margin-leff:20px;
  margin-right:20px;
  margin-top:5px;
}
@media print{
  #btnimprimir2{
    display:none;
  }
}
ul{
      list-style-type: none;
      margin: 0;
      padding: 0; 
    }
.result{
     font-family:Verdana, Geneva, sans-serif;
      font-size:9px; 
    font-weight:bold;
}.nombreclase{
   font-size:10px;
   font-weight: bold;
}
.txthorario{
   font-size:9px;
}
.txttutor{
   font-size:9px;
}
.txtdia{
  font-size:15px;
   font-weight: bold;
   background-color:#ccc;
   border:1px  solid #ccc;
}
   table {
            border-collapse:collapse; 
            }
   .tblhorario tr td
                {
                    border:0px  solid black;
                }

</style>
<div id="areaimprimir">  
          <table width="950" border="0" >
  <tr>
    <td width="101" align="center"><img   class="imgtitle" src="' . $logo2 . '" /></td>
    <td colspan="2" align="center">
            <label class="nombreplantel">' . $datelle_alumno[0]->nombreplantel . '</label><br>
            <label class="txtn">' . $datelle_alumno[0]->asociado . '</label><br>
            <label class="direccion">' . $datelle_alumno[0]->direccion . '</label><br>
            <label class="telefono">TELÉFONO: ' . $datelle_alumno[0]->telefono . ' EXT 1</label>
    </td>
    <td width="137" align="center"><img   class="imgtitle" src="' . $logo . '" /></td>
  </tr> 
    <tr>
    <td align="center"  style=""><label class="titulo">Matricula</label></td>
    <td align="center"  style=""><label class="titulo">Alumno</label></td>
    <td align="center"  style=""><label class="titulo">Nivel Escolar</label></td>
    <td align="center"  style=""><label class="titulo">Periodo Escolar</label></td>
  </tr>
  <tr>
    <td align="center"><label class="result">' . $alumno->matricula . '</label></td>
    <td align="center"><label class="result">' . $alumno->nombre . ' ' . $alumno->apellidop . ' ' . $alumno->apellidom . '</label></td>
    <td align="center"><label class="result">' . $grupo->nombrenivel . ' ' . $grupo->nombregrupo . '</label></td>
    <td align="center"><label class="result">' . $grupo->mesinicio . ' ' . $grupo->yearinicio . ' - ' . $grupo->mesfin . ' ' . $grupo->yearfin . '</label></td>
  </tr> 
  </table> <br/>';

            $tabla .= '<table class="tblepr"  width="950" border="0">
      <thead> 
    ';
            foreach ($dias as $dia):
                $tabla .= '<th align="center" class="txtdia text-center">' . $dia->nombredia . '</th>';
            endforeach;

            $tabla .= '</thead>';
            $c = 1;
            //$alumn = $al->getAlumn();

            $tabla .= '<tr valign="top">';
            foreach ($dias as $block):
                $lunes = $this->horario->showAllDiaHorario($idhorario, $block->iddia);
                $tabla .= '<td>';
                $tabla .= '<table   class="tblhorario"  border="0" >';
                if ($lunes != false) {
                    foreach ($lunes as $row) {
                        $tabla .= '<tr>
              <td width="200" style="border:solid #ccc 1px; height:60px; padding-left:5px; padding-right:5px;">';
                        if (strtoupper($row->opcion) == "NORMAL") {
                            $tabla .= '<ul>';
                            $tabla .= '<li class="nombreclase">' . $row->nombreclase . '</li>';
                            $tabla .= '<li class="txthorario">' . date('h:i A', strtotime($row->horainicial)) . ' - ' . date('h:i A', strtotime($row->horafinal)) . '</li>';
                            $tabla .= '<li class="txttutor">' . $row->nombre . ' ' . $row->apellidop . ' ' . $row->apellidom . '</li>';
                            $tabla .= '</ul>';
                        }
                        if (strtoupper($row->opcion) == "DESCANSO") {
                            $tabla .= '<label class="nombreclase"> ' . $row->nombreclase . '</label>';
                        }
                        if (strtoupper($row->opcion) == "SIN CLASES") {
                            //$tabla.='<label class="nombreclase">SIN CLASES</label>';
                        }
                        $tabla .= '</td>
            </tr>';
                    }
                } else {
                    $tabla .= '<label>No registrado</label>';
                }
                $tabla .= '</table>';
                $tabla .= '</td>';
            endforeach;

            $tabla .= '</tr>';



            $tabla .= '</table></div>';
            echo $tabla;
            echo '<button type="button" id="btnimprimir2" onclick="imprimirDiv()" >IMPRIMIR</button>';
            echo '
      <script>
 imprimirDiv();
function imprimirDiv(){
  //alert(divName);
  var printContents =document.getElementById("areaimprimir").innerHTML;
  var originalContents = document.body.innerHTML;
  document.body.innerHTML = printContents; 
  window.print();
  document.body.innerHTML= originalContents;
}
$(document).ready(function(){
  $("#btnimprimir2").trigger("click");
});
document.getElementById("btnimprimir2").onclick = imprimirDiv;
</script>
      ';
        } else {
            $data = array(
                'heading' => 'Error',
                'message' => 'Error intente mas tarde.'
            );
            $this->load->view('errors/html/error_general', $data);
        }
    }

    public function obtenerCalificacion($idhorario = '', $idalumno = '') {
        //Permission::grant(uri_string());
        # code...
        $detalle_configuracion = $this->configuracion->showAllConfiguracion($this->session->idplantel);
        $unidades = $this->grupo->unidades($this->session->idplantel);
        $materias = $this->alumno->showAllMaterias($idhorario);
        $total_unidades = 0;
        $tabla = "";
        $tabla .= '<table class="table table-bordered table-hover">
      <thead>
      <th>#</th>
      <th>Nombre de Materia</th>';
        foreach ($unidades as $block):
            $total_unidades += 1;
            $tabla .= '<th><strong>' . $block->nombreunidad . '</strong></th>';
        endforeach;
        $tabla .= '<th>C. Final</th>';
        $tabla .= '</thead>';
        $c = 1;
        if (isset($materias) && !empty($materias)) {
            $suma_calificacion = 0;
            foreach ($materias as $row) {
                //$alumn = $al->getAlumn();
                $suma_calificacion = 0;
                $tabla .= '<tr>
        <td>' . $c++ . '</td>
        <td><strong>' . $row->nombreclase . '</strong><br><small>( ' . $row->nombre . ' ' . $row->apellidop . ' ' . $row->apellidom . '</small>)</td>';
                foreach ($unidades as $block):
                    $val = $this->grupo->obtenerCalificacion($idalumno, $block->idunidad, $row->idhorariodetalle);

                    $tabla .= '<td>';
                    if ($val != false) {
                        $suma_calificacion = $suma_calificacion + $val->calificacion;
                        if (validar_calificacion($val->calificacion, $detalle_configuracion[0]->calificacionminima)) {
                            $tabla .= '<label style="color:red;">' . $val->calificacion . '</label>';
                        } else {
                            $tabla .= '<label style="color:green;">' . $val->calificacion . '</label>';
                        }
                    } else {
                        $tabla .= '<label>No registrado</label>';
                    }
                    $tabla .= '</td>';
                endforeach;
                $tabla .= '<td>';
                $calificacion_final = number_format($suma_calificacion / $total_unidades, 2);
                if (validar_calificacion($calificacion_final, $detalle_configuracion[0]->calificacionminima)) {
                    $tabla .= '<label style="color:red;">' . number_format($suma_calificacion / $total_unidades, 2) . '</label>';
                } else {
                    $tabla .= '<label style="color:green;">' . number_format($suma_calificacion / $total_unidades, 2) . '</label>';
                }
                $tabla .= '</td>';
                $tabla .= '</tr>';
            }
        }
        $tabla .= '</table>';
        return $tabla;
    }

    public function obtenerCalificacionAlumnoPorNivel($idhorario = '', $idalumno = '') {
        //Permission::grant(uri_string());
        # code...
        $unidades = $this->grupo->unidades($this->session->idplantel);
        $materias = $this->alumno->showAllMaterias($idhorario);
        $total_unidad = 0;
        $total_materia = 0;
        $suma_calificacion = 0;
        $promedio = 0;

        $c = 1;
        if (isset($materias) && !empty($materias)) {

            foreach ($unidades as $block):
                $total_unidad += 1;
            endforeach;

            foreach ($materias as $row) {
                $total_materia += 1;

                foreach ($unidades as $block):
                    $val = $this->grupo->obtenerCalificacion($idalumno, $block->idunidad, $row->idhorariodetalle);


                    if ($val != false) {
                        $suma_calificacion += $val->calificacion;
                    }
                endforeach;
            }
            $promedio = ($suma_calificacion / $total_unidad) / $total_materia;
        }

        return $promedio;
    }

    public function obtenerCalificacionPrimaria($idhorario = '', $idalumno = '') {
        # code...
        Permission::grant(uri_string());
        $idplantel = $this->session->idplantel;
        $datoshorario = $this->horario->showNivelGrupo($idhorario);
        $idnivelestudio = $datoshorario->idnivelestudio;

        $detalle_configuracion = $this->configuracion->showAllConfiguracion($this->session->idplantel, $idnivelestudio);
        $calificaciones = $this->alumno->calificacionFinalPrimaria($idalumno, $idhorario, $idplantel);
        $tabla = "";
        $tabla .= '<table class="table  table-striped  table-hover">
        <thead class="bg-teal">
         <th>#</th>
        <th>MATERIA</th>';
        $tabla .= '<th>CALIFICACIÓN</th>';
        $tabla .= '</thead>';
        $c = 1;
        if (isset($calificaciones) && !empty($calificaciones)){
        foreach ($calificaciones as $row) {
            $tabla .= '<tr>';
            $tabla .= '<td>' . $c++ . '</td>';
            $tabla .= '<td>' . $row->nombreclase . '</td>';

            if ($row->calificacion < $detalle_configuracion[0]->calificacion_minima) {
                $tabla .= '<td><strong>NA</strong></td>';
            } else {
                $tabla .= '<td>' . $row->calificacion . '</td>';
            }
            $tabla .= '</tr>';
        }
        }else {
            $tabla .= '<tr><td colspan="3" align="center">Sin registros</td></tr>';
        }


        $tabla .= '</table>';
        return $tabla;
    }

    public function obtenerCalificacionSecundaria($idhorario = '', $idalumno = '',$idperiodo = '') {
        # code...
        Permission::grant(uri_string()); 
        $materias = $this->alumno->showAllMateriasPasadas($idhorario,$idalumno,$idperiodo);
        $datoshorario = $this->horario->showNivelGrupo($idhorario);
        $idnivelestudio = $datoshorario->idnivelestudio;
        $oportunidades_examen = $this->alumno->showAllOportunidadesExamen($this->session->idplantel);

        $detalle_configuracion = $this->configuracion->showAllConfiguracion($this->session->idplantel, $idnivelestudio);
         $total_materia = 0;
        if ($materias != FALSE) {
            foreach ($materias as $row) {
                # code...
                $total_materia = $total_materia + 1;
            }
        }
        $tabla = "";
        $tabla .= '<table class="table  table-striped  table-hover">
        <thead class="bg-teal">
      <th>NO.</th>
      <th>MATERIA</th>
         <th>CRÉDITO</th>';
        $tabla .= '<th>CALIFICACIÓN</th>';
        $tabla .= '<th></th>';
        $tabla .= '</thead>';
        $c = 1;
        if (isset($materias) && !empty($materias)){
        foreach ($materias as $row) {
            $idhorariodetalle = $row->idhorariodetalle;
            $calificacion = 0;
            foreach ($oportunidades_examen as $oportunidad) {
                $idoportunidadexamen = $oportunidad->idoportunidadexamen;
                $detalle_calificacion = $this->alumno->calificacionSecuPrepa($idalumno, $idhorariodetalle, $idoportunidadexamen);
                if ($detalle_calificacion && $calificacion == 0) {
                    $calificacion .= $detalle_calificacion[0]->calificacion;
                }
            }
            $tabla .= '<tr>';
            $tabla .= '<td>' . $c++ . '</td>';
            $tabla .= '<td>' . $row->nombreclase . '</td>';
            $tabla .= '<td>' . $row->credito . '</td>';
            $tabla .= '<td>';
            if ($detalle_configuracion[0]->calificacion_minima < $calificacion) {
                $tabla .= '<label>' . number_format($calificacion, 2) . '</label>';
            } else {
                $tabla .= '<label style="color:red;">NA</label>';
            }
              $tabla .= '</td>';
             $tabla .= '<td>';
             if($row->opcion == 0){
                   $tabla .= '<label style="color:blue;">R</label>';
             } 
           
            $tabla .= '</td>';
            $tabla .= '</tr>';
        }
        }else{
            $tabla .= '<tr><td colspan="5" align="center">Sin registros</td></tr>';
        }
        $tabla .= '</table>';
        return $tabla;
    }

    public function imprimirkardex($idhorario = '', $idalumno = '') {
        Permission::grant(uri_string());
        $idhorario = $this->decode($idhorario);
        $idalumno = $this->decode($idalumno);
        if ((isset($idhorario) && !empty($idhorario)) && (isset($idalumno) && !empty($idalumno))) {
            $alumno = $this->alumno->detalleAlumno($idalumno);
            $grupop = $this->horario->showNivelGrupo($idhorario);
            $detalle_logo = $this->alumno->logo($this->session->idplantel);
            $logo = base_url() . '/assets/images/escuelas/' . $detalle_logo[0]->logoplantel;
            $logo2 = base_url() . '/assets/images/escuelas/' . $detalle_logo[0]->logosegundo;
            $datoshorario = $this->horario->showNivelGrupo($idhorario);
            $idniveleducativo = $datoshorario->idniveleducativo;
            $detalle_configuracion = $this->configuracion->showAllConfiguracion($this->session->idplantel, $idnivelestudio);


            $this->load->library('tcpdf');

            $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
            $pdf->SetTitle('kardex de Calificaciones.');
            $pdf->SetHeaderMargin(30);
            $pdf->SetTopMargin(10);
            $pdf->setFooterMargin(20);
            $pdf->SetAutoPageBreak(true);
            $pdf->SetAuthor('Sistema Integral para el Control Escolar');
            $pdf->SetDisplayMode('real', 'default');
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);

            $pdf->AddPage();

            $tbl = '
<style type="text/css">
.titulodias{font-size:9px; font-weight:bold;}
.cajon{
    font-size:9px; 
    font-weight:bold;  
    border-bottom:solid 1px black;  
    border-left:solid 1px black;
     border-right:solid 1px black;  
      padding:900px 20px 20px 20px;
}  
 .txtn{
        font-size:6px;
    }
    .direccion{
        font-size:6px;
    }
.escuela{
      font-size:12px; 
    font-weight:bold;
}
.horario{
      font-size:10px; 
    font-weight:bold;
}
.titulo{
      font-size:8px; 
    font-weight:bold;
}
.result{
      font-size:8px; 
    font-weight:bold;
} 
    .nombreplantel{
        font-size:11px;
        font-weight:bolder;
    }
    .telefono{
          font-size:6px;
    }
 .imgtitle{
        width:60px;

    }
    .promedio{
           font-size:10px;
    }
.tblcalificacion  td 
                {
                    border:0px  solid black;
                }
 
.titulocal{
     font-family:Verdana, Geneva, sans-serif;
     font-weight:bolder;
     font-size:8px;
     background-color:#ccc;
}
.subtitulocal{
     font-family:Verdana, Geneva, sans-serif; 
     font-size:7px; 
}
.imgprincipal{
  width:90px;
}
.principal{
  font-family:Verdana, Geneva, sans-serif; 
     font-size:9px;
      font-weight:bolder;
        background-color:#f3f2f2;
}
.calificaciones{
 font-family:Verdana, Geneva, sans-serif; 
     font-size:9px;
}
</style>
 <table width="580" border="0" cellpadding="0" cellspacing="4">
   <tr>
    <td width="101" align="left"><img   class="imgtitle" src="' . $logo2 . '" /></td>
    <td colspan="2" align="center">
            <label class="nombreplantel">' . $detalle_logo[0]->nombreplantel . '</label><br>
            <label class="txtn">' . $detalle_logo[0]->asociado . '</label><br>
            <label class="direccion">' . $detalle_logo[0]->direccion . '</label><br>
            <label class="telefono">TELÉFONO: ' . $detalle_logo[0]->telefono . '</label>
    </td>
    <td width="137"  align="right" valing="top"><img   class="imgprincipal" src="' . $logo . '" /></td>
  </tr>
   
  <tr>
    <td colspan="4" align="center"><label class="horario">KARDEX ESCOLAR</label></td> 
    </tr>
   <tr>
    <td align="center"  style="border-bottom:solid 1px #000000;"><label class="titulo">Matricula</label></td>
    <td align="center"  style="border-bottom:solid 1px #000000;"><label class="titulo">Alumno(a)</label></td>
    <td align="center"  style="border-bottom:solid 1px #000000;"><label class="titulo">Nivel Escolar</label></td>
    <td align="center"  style="border-bottom:solid 1px #000000;"><label class="titulo">Periodo Escolar</label></td>
  </tr>
  <tr>
    <td align="center"><label class="result">' . $alumno->matricula . '</label></td>
    <td align="center"><label class="result">' . $alumno->nombre . ' ' . $alumno->apellidop . ' ' . $alumno->apellidom . '</label></td>
    <td align="center"><label class="result">' . $grupop->nombrenivel . ' ' . $grupop->nombregrupo . '</label></td>
    <td align="center"><label class="result">' . $grupop->mesinicio . ' - ' . $grupop->mesfin . ' ' . $grupop->yearfin . '</label></td>
  </tr> 
</table>
<br><br>
 ';


            if ($idniveleducativo == 1 || $idniveleducativo == 4) {
                //PRIMARIA

                $idplantel = $this->session->idplantel;
                $datoshorario = $this->horario->showNivelGrupo($idhorario);
                $idnivelestudio = $datoshorario->idnivelestudio;

                $detalle_configuracion = $this->configuracion->showAllConfiguracion($this->session->idplantel, $idnivelestudio);
                $calificaciones = $this->alumno->calificacionFinalPrimaria($idalumno, $idhorario, $idplantel);
                // $tabla = "";
                $tbl .= '<table class="tblcalificacion" cellpadding="2" >
        <tr class="principal">
         <td width="30">NO</td>
        <td  width="410">NOMBRE DE LA MATERIA</td>';
                $tbl .= '<td  width="90">CALIFICACIÓN</td>';
                $tbl .= '</tr>';
                $c = 1;
                $suma_calificacion = 0;
                $contador = 0;
                foreach ($calificaciones as $row) {
                    $contador++;
                    $suma_calificacion = $suma_calificacion + $row->calificacion;
                    $tbl .= '<tr class="calificaciones">';
                    $tbl .= '<td  width="30">' . $c++ . '</td>';
                    $tbl .= '<td width="410">' . $row->nombreclase . '</td>';

                    if ($row->calificacion < $detalle_configuracion[0]->calificacion_minima) {
                        $tbl .= '<td  width="90" style="color:red;"  align="right">' . $row->calificacion . '</td>';
                    } else {
                        $tbl .= '<td  width="90"  align="right">' . $row->calificacion . '</td>';
                    }
                    $tbl .= '</tr>';
                }

                $tbl .= '<tr  class="calificaciones">';
                $tbl .= '<td colspan="2" style="border-left:solid 1px red;" align="right"><strong>PROMEDIO:</strong></td>';
                $tbl .= '<td  align="right"><strong>' . number_format($suma_calificacion / $contador, 2) . '</strong></td>';
                $tbl .= '</tr>';
                $tbl .= '</table>';
            }
            if ($idniveleducativo == 2 || $idniveleducativo == 3 || $idniveleducativo == 5 ) {
                //SECUNDARIA
                $materias = $this->alumno->showAllMateriasPasadas($idhorario);
                $datoshorario = $this->horario->showNivelGrupo($idhorario);
                $idnivelestudio = $datoshorario->idnivelestudio;
                $oportunidades_examen = $this->alumno->showAllOportunidadesExamen($this->session->idplantel);

                $detalle_configuracion = $this->configuracion->showAllConfiguracion($this->session->idplantel, $idnivelestudio);
                $total_materia = 0;
                if ($materias != FALSE) {
                    foreach ($materias as $row) {
                        # code...
                        $total_materia = $total_materia + 1;
                    }
                }
                            
                $tbl .= '<table  class="tblcalificacion" cellpadding="2" >
        <tr  class="principal">
      <td  width="30">NO.</td>
      <td width="380">NOMBRE DE LA MATERIA</td> ';
                $tbl .= '<td width="90">CALIFICACIÓN</td>';
                $tbl .= '<td width="30"></td>';
                $tbl .= '</tr>';
                $c = 1;

                foreach ($materias as $row) {
                    $idhorariodetalle = $row->idhorariodetalle;
                    $calificacion = 0;
                    foreach ($oportunidades_examen as $oportunidad) {
                        $idoportunidadexamen = $oportunidad->idoportunidadexamen;
                        $detalle_calificacion = $this->alumno->calificacionSecuPrepa($idalumno, $idhorariodetalle, $idoportunidadexamen);
                        if ($detalle_calificacion && $calificacion == 0) {
                            $calificacion .= $detalle_calificacion[0]->calificacion;
                        }
                    }
                    $tbl .= '<tr>';
                    $tbl .= '<td  width="30">' . $c++ . '</td>';
                    $tbl .= '<td width="380">' . $row->nombreclase . '</td>'; 
                    $tbl .= '<td width="90">';
                    if ($detalle_configuracion[0]->calificacion_minima < $calificacion) {
                        $tbl .= '<label>' . number_format($calificacion, 2) . '</label>';
                    } else {
                        $tbl .= '<label>NA</label>';
                    }
                       $tbl .= '</td>';
                    $tbl .= '<td width="30">';
                    if ($row->opcion == 0) {
                        $tbl .= '<label>R</label>';
                    } 
                 
                    $tbl .= '</td>';
                    $tbl .= '</tr>';
                }

                $tbl .= '</table>';
            }
            if ($idniveleducativo == 3) {
                //PREPARATORIA
            }

            $pdf->writeHTML($tbl, true, false, false, false, '');

            ob_end_clean();


            $pdf->Output('Kardex de Calificaciones', 'I');
        } else {
            $data = array(
                'heading' => 'Error',
                'message' => 'Error intente mas tarde.'
            );
            $this->load->view('errors/html/error_general', $data);
        }
    }
    function calificacionGlobal() {
        $idalumno = $this->input->get('idalumno');
        $detalle = $this->alumno->allKardex($idalumno);
        $calificacion_periodo = 0;
        $suma_periodo = 0;
        $calificacion_global = 0;
        if (isset($detalle) && !empty($detalle)) {
            foreach ($detalle as $det) {
                $suma_periodo++;
                $idhorario = $det->idhorario;
                $idperiodo = $det->idperiodo;
                $materias = $this->alumno->showAllMateriasPasadas($idhorario, $idalumno, $idperiodo);

                if (isset($materias) && !empty($materias)) {

                    $oportunidades_examen = $this->alumno->showAllOportunidadesExamen($this->session->idplantel);
                    $total_materia = 0;
                    $suma_calificacion = 0;
                    $calificacion = 0;
                    foreach ($materias as $row) {
                        $idnivelestudio = $row->idnivelestudio;
                        $detalle_configuracion = $this->configuracion->showAllConfiguracion($this->session->idplantel, $idnivelestudio);
                        $total_materia = $total_materia + 1;
                        $idhorariodetalle = $row->idhorariodetalle;
                        $calificacion = 0;
                        foreach ($oportunidades_examen as $oportunidad) {
                            $idoportunidadexamen = $oportunidad->idoportunidadexamen;
                            $detalle_calificacion = $this->alumno->calificacionSecuPrepa($idalumno, $idhorariodetalle, $idoportunidadexamen);
                            if ($detalle_calificacion && $calificacion == 0) {
                                if ($detalle_calificacion[0]->calificacion >= $detalle_configuracion[0]->calificacion_minima) {
                                    $calificacion .= $detalle_calificacion[0]->calificacion;
                                    $suma_calificacion += $calificacion;
                                }
                            }
                        }
                    }

                    $calificacion = $suma_calificacion / $total_materia;
                    $calificacion_periodo += $calificacion;
                }  
            }
        }
        //return number_format(($calificacion_periodo/$suma_periodo),2);
         $result['datos'] = array(
            'promedio' => number_format(($calificacion_periodo/$suma_periodo),2)
        );
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function historial($idhorario = '', $idalumno = '',$idperiodo = '') {

        Permission::grant(uri_string());
        if ((isset($idhorario) && !empty($idhorario)) && (isset($idalumno) && !empty($idalumno)) && (isset($idperiodo) && !empty($idperiodo))) {

            $datosalumno = $this->alumno->showAllAlumnoId($idalumno);
            $datoshorario = $this->horario->showNivelGrupo($idhorario);
            $materias = $this->alumno->showAllMateriasPasadas($idhorario,$idalumno,$idperiodo); 
            $idnivelestudio = $datoshorario->idnivelestudio;
            $idniveleducativo = $datoshorario->idniveleducativo;
            $detalle_configuracion = $this->configuracion->showAllConfiguracion($this->session->idplantel, $idnivelestudio);
 
            if ($idniveleducativo == 1) {
                //PRIMARIA 
                $tabla = $this->obtenerCalificacionPrimaria($idhorario, $idalumno);
            }
             if ($idniveleducativo == 4) {
                //PREESCOLAR 
                $tabla = $this->obtenerCalificacionPrimaria($idhorario, $idalumno);
            }
            if ($idniveleducativo == 2) {
                //SECUNDARIA
                $tabla = $this->obtenerCalificacionSecundaria($idhorario, $idalumno,$idperiodo);
            }
            if ($idniveleducativo == 3) {
                //PREPARATORIA
                   $tabla = $this->obtenerCalificacionSecundaria($idhorario, $idalumno,$idperiodo);
            }
             if ($idniveleducativo == 5) {
                //LICENCIATURA
                   $tabla = $this->obtenerCalificacionSecundaria($idhorario, $idalumno,$idperiodo);
            }
                            

            //CODIGO PARA OBTENER LA CALIFICACION DEL NIVEL
            $oportunidades_examen = $this->alumno->showAllOportunidadesExamen($this->session->idplantel);
            $total_materia = 0;
            $suma_calificacion = 0;
            foreach ($materias as $row) {
                $total_materia = $total_materia + 1;
                $idhorariodetalle = $row->idhorariodetalle;
                $calificacion = 0;
                foreach ($oportunidades_examen as $oportunidad) {
                    $idoportunidadexamen = $oportunidad->idoportunidadexamen;
                    $detalle_calificacion = $this->alumno->calificacionSecuPrepa($idalumno, $idhorariodetalle, $idoportunidadexamen);
                    if ($detalle_calificacion && $calificacion == 0) {
                        if ($detalle_calificacion[0]->calificacion >= $detalle_configuracion[0]->calificacion_minima) {
                            $calificacion .= $detalle_calificacion[0]->calificacion;
                            $suma_calificacion += $calificacion;
                        }
                    }
                }
            }
            $calificacion = 0;
            $calificacion = $suma_calificacion / $total_materia;
            //FIN DEL CODIGO PARA OBTENER LA CALIFICACION DEL NIVEL
            $data = array(
                'idhorario' => $idhorario,
                'idalumno' => $idalumno,
                'tabla' => $tabla,
                'datosalumno' => $datosalumno,
                'datoshorario' => $datoshorario,
                'calificacion' => $calificacion,
                'controller' => $this,
                //'total_reprobados'=>$total_reprovadas,
                'nivel_educativo' => $idniveleducativo,
            );
            $this->load->view('admin/header');
            $this->load->view('admin/alumno/kardex', $data);
            $this->load->view('admin/footer');
        } else {
            $data = array(
                'heading' => 'Error',
                'message' => 'Error intente mas tarde.'
            );
            $this->load->view('errors/html/error_general', $data);
        }
    }

    public function deleteTutor() {
        # code...
        if (Permission::grantValidar(uri_string()) == 1) {
            $id = $this->input->get('id');
            $query = $this->alumno->deleteTutor($id);
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

    public function deleteReprobada() {
        # code...
        if (Permission::grantValidar(uri_string()) == 1) {
            $id = $this->input->get('id');
            $query = $this->alumno->validarEliminarReprobada($id);
            if (!$query) {
                $eliminar = $this->alumno->deleteReprobada($id);
                if ($eliminar) {
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
                    'msgerror' => 'No se puede Elimnar registro.'
                );
            }
        } else {
            $result['error'] = false;
            $result['msg'] = array(
                'msgerror' => 'NO TIENE PERMISO PARA REALIZAR ESTA ACCIÓN.'
            );
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function asignarGrupo() {
        if (Permission::grantValidar(uri_string()) == 1) {
            $config = array(
                array(
                    'field' => 'idcicloescolar',
                    'label' => 'Ciclo Escolar',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => 'Seleccione el Ciclo Escolar.'
                    )
                ),
                array(
                    'field' => 'idgrupo',
                    'label' => 'Seleccionar el Grupo.',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => 'Seleccionar el Grupo.'
                    )
                )
            );
            $this->form_validation->set_rules($config);
            if ($this->form_validation->run() == FALSE) {
                $result['error'] = true;
                $result['msg'] = array(
                    'idcicloescolar' => form_error('idcicloescolar'),
                    'idgrupo' => form_error('idgrupo'),
                );
            } else {
                $idalumno = $this->input->post('idalumno');
                $idperiodo = $this->input->post('idcicloescolar');
                $idgrupo = $this->input->post('idgrupo');
                $datelle_alumno = $this->alumno->showAllAlumnoId($idalumno);
                $idplantel = $datelle_alumno[0]->idplantel;
                $validar_add = $this->alumno->validarAddAlumnoGrupo($idperiodo, $idalumno, $idgrupo, $idplantel);
                if ($validar_add == false) {
                    $data = array(
                        'idalumno' => $this->input->post('idalumno'),
                        'idperiodo' => $this->input->post('idcicloescolar'),
                        'idgrupo' => $this->input->post('idgrupo'),
                        'idbeca' => 1,
                        'idestatusnivel' => 1,
                        'activo' => 1,
                        'idusuario' => $this->session->user_id,
                        'fecharegistro' => date('Y-m-d H:i:s')
                    );
                    $value = $this->alumno->asignarGrupo($data);
                } else {
                    $result['error'] = true;
                    $result['msg'] = array(
                        'msgerror' => 'Ya esta asignado al Grupo.'
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

    public function cambiarGrupo() {
        if (Permission::grantValidar(uri_string()) == 1) {
            $config = array(
                array(
                    'field' => 'idgrupo',
                    'label' => 'Seleccionar el Grupo.',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => 'Seleccionar el Grupo.'
                    )
                )
            );
            $this->form_validation->set_rules($config);
            if ($this->form_validation->run() == FALSE) {
                $result['error'] = true;
                $result['msg'] = array(
                    'idgrupo' => form_error('idgrupo'),
                );
            } else {
                $idalumnogrupo = $this->input->post('idalumnogrupo');
                $idgrupo = $this->input->post('idgrupo');

                $data = array(
                    'idgrupo' => $idgrupo,
                    'idusuario' => $this->session->user_id,
                    'fecharegistro' => date('Y-m-d H:i:s')
                );
                $value = $this->alumno->updateAlumnoGrupo($idalumnogrupo, $data);
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

    public function asignarBeca() {
        if (Permission::grantValidar(uri_string()) == 1) {
            $config = array(
                array(
                    'field' => 'idbeca',
                    'label' => 'Ciclo Escolar',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => 'Seleccione la Beca.'
                    )
                )
            );
            $this->form_validation->set_rules($config);
            if ($this->form_validation->run() == FALSE) {

                $result['error'] = true;
                $result['msg'] = array(
                    'idbeca' => form_error('idbeca'),
                );
            } else {
                $idbeca = $this->input->post('idbeca');
                $idalumno = $this->input->post('idalumnogrupo');
                $data = array(
                    'idbeca' => $idbeca,
                    'idusuario' => $this->session->user_id,
                    'fecharegistro' => date('Y-m-d H:i:s')
                );
                $value = $this->alumno->updateBecaAlumno($idalumno, $data);
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

    public function asignarEstatusAlumno() {
        if ($this->session->idpersonal == 14) {
            $config = array(
                array(
                    'field' => 'idestatus',
                    'label' => 'Estatus',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => 'Seleccione un estatus.'
                    )
                )
            );
            $this->form_validation->set_rules($config);
            if ($this->form_validation->run() == FALSE) {

                $result['error'] = true;
                $result['msg'] = array(
                    'idestatus' => form_error('idestatus'),
                );
            } else {
                $idestatus = $this->input->post('idestatus');

                $idalumno = $this->input->post('idalumno');
                $data = array(
                    'idalumnoestatus' => $idestatus,
                    'idusuario' => $this->session->user_id,
                    'fecharegistro' => date('Y-m-d H:i:s')
                );
                $value = $this->alumno->updateEstatusAlumno($idalumno, $data);
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

    public function subirFoto() {
        if (isset($_FILES['file']['name']) && !empty($_FILES['file']['name'])) {
            $mi_archivo = 'file';
            $config['upload_path'] = "assets/alumnos/";
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
                // echo $this->upload->display_errors();
                //echo json_encode($data);
                            
                $result['error'] = true;
                $result['msg'] = array(
                    'msgerror' => $this->upload->display_errors()
                );
                //return;
            } else {
                $id = $this->input->post('idalumno');
                $data = array(
                    'foto' => $user_img_profile,
                    'idusuario' => $this->session->user_id,
                    'fecharegistro' => date('Y-m-d H:i:s')
                );
                $this->alumno->updateAlumno($id, $data);
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

    public function generarHorarioPDF($idhorario = '', $idalumno = '') {
        //Permission::grant(uri_string());
        $idhorario = $this->decode($idhorario);
        $idalumno = $this->decode($idalumno);
        if ((isset($idhorario) && !empty($idhorario)) && (isset($idalumno) && !empty($idalumno))) {

            $lunes = $this->horario->showAllDiaHorario($idhorario, 1);
            $martes = $this->horario->showAllDiaHorario($idhorario, 2);
            $miercoles = $this->horario->showAllDiaHorario($idhorario, 3);
            $jueves = $this->horario->showAllDiaHorario($idhorario, 4);
            $viernes = $this->horario->showAllDiaHorario($idhorario, 5);
            $alumno = $this->alumno->detalleAlumno($idalumno);
            $grupo = $this->horario->showNivelGrupo($idhorario);
            $this->load->library('tcpdf');
            $hora = date("h:i:s a");
            //$linkimge = base_url() . '/assets/images/woorilogo.png';
            $fechaactual = date('d/m/Y');


            $tbl = '
        <!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style type="text/css">
.titulodias{font-size:9px; font-weight:bold;}
.cajon{
     font-family:Verdana, Geneva, sans-serif;
    font-size:9px; 
    font-weight:bold;  
    border-bottom:solid 1px black;  
    border-left:solid 1px black;
     border-right:solid 1px black;  
      padding:900px 20px 20px 20px;
}  
.escuela{
     font-family:Verdana, Geneva, sans-serif;
      font-size:12px; 
    font-weight:bold;
}
.horario{
     font-family:Verdana, Geneva, sans-serif;
      font-size:10px; 
    font-weight:bold;
}
.titulo{
     font-family:Verdana, Geneva, sans-serif;
      font-size:8px; 
    font-weight:bold;
}
.result{
     font-family:Verdana, Geneva, sans-serif;
      font-size:9px; 
    font-weight:bold;
}
.dl{ 
     font-family:Verdana, Geneva, sans-serif;
    width:142px;
    display:inline-block;
    *display:inline;
    vertical-align:top;
    margin-right:-4px;

}
.dia{
    font-family:Verdana, Geneva, sans-serif;
    border:solid 1px #ccc;
     font-size:8px;
     height:38px;
     vertical-align:top; 
     padding: 5px 5px 5px 5px;
     margin:0;
}
.diasemana{
      font-family:Verdana, Geneva, sans-serif;
    border:solid 1px #ccc;
     font-size:10px;
     height:20px;
     background-color:#ccc;
     padding: 5px 5px 0px 5px;
     font-weight:bolder;
}
.hora{
     font-family:Verdana, Geneva, sans-serif;
     font-size:8px;
     font-weight:bolder;
}
</style>

<title>Title</title>
</head>
<body>
<table width="540" border="0" cellpadding="1" cellspacing="4">

  <tr>
    <td colspan="4" align="center"><label class="escuela">' . $alumno->nombreplantel . '</label></td> 
  </tr>
  <tr>
    <td colspan="4" align="center"><label class="horario">Horario del Alumno</label></td> 
    </tr>
   <tr>
    <td align="center"  style="border-bottom:solid 1px #000000;"><label class="titulo">Matricula</label></td>
    <td align="center"  style="border-bottom:solid 1px #000000;"><label class="titulo">Alumno</label></td>
    <td align="center"  style="border-bottom:solid 1px #000000;"><label class="titulo">Nivel Escolar</label></td>
    <td align="center"  style="border-bottom:solid 1px #000000;"><label class="titulo">Periodo Escolar</label></td>
  </tr>
  <tr>
    <td align="center"><label class="result">' . $alumno->matricula . '</label></td>
    <td align="center"><label class="result">' . $alumno->nombre . ' ' . $alumno->apellidop . ' ' . $alumno->apellidom . '</label></td>
    <td align="center"><label class="result">' . $grupo->nombrenivel . ' ' . $grupo->nombregrupo . '</label></td>
    <td align="center"><label class="result">' . $grupo->mesinicio . ' ' . $grupo->yearinicio . ' - ' . $grupo->mesfin . ' ' . $grupo->yearfin . '</label></td>
  </tr> 
</table>
<br>
<div class = "dl">
<div class="diasemana"><label>LUNES</label></div>
    ';
            if (isset($lunes) && !empty($lunes)) {
                foreach ($lunes as $row) {
                    if (strtoupper($row->opcion) == "NORMAL") {
                        $tbl .= '<div class="dia"><label> ' . $row->nombreclase . '</label><br> <small class = "hora">(' . $row->horainicial . ' - ' . $row->horafinal . ')</small>
              <br>
              <small class = "hora">' . $row->nombre . ' ' . $row->apellidop . ' ' . $row->apellidom . '</small></div>';
                    }
                    if (strtoupper($row->opcion) == "DESCANSO") {
                        $tbl .= '<div class="dia"><label> ' . $row->nombreclase . '</label><br> <small class = "hora">(' . $row->horainicial . ' - ' . $row->horafinal . ')</small></div>';
                    }
                    if (strtoupper($row->opcion) == "SIN CLASES") {
                        $tbl .= '<div class="dia"><label>SIN CLASES</label><br> <small class = "hora">(' . $row->horainicial . ' - ' . $row->horafinal . ')</small></div>';
                    }
                }
            }
            $tbl .= '
</div>
<div class = "dl">
<div class="diasemana"><label>MARTES</label></div>
     ';
            if (isset($martes) && !empty($martes)) {
                foreach ($martes as $row) {
                    if (strtoupper($row->opcion) == "NORMAL") {
                        $tbl .= '<div class="dia"><label> ' . $row->nombreclase . '</label><br> <small class = "hora">(' . $row->horainicial . ' - ' . $row->horafinal . ')</small>
              <br>
              <small class = "hora">' . $row->nombre . ' ' . $row->apellidop . ' ' . $row->apellidom . '</small></div>';
                    }
                    if (strtoupper($row->opcion) == "DESCANSO") {
                        $tbl .= '<div class="dia"><label> ' . $row->nombreclase . '</label><br> <small class = "hora">(' . $row->horainicial . ' - ' . $row->horafinal . ')</small></div>';
                    }
                    if (strtoupper($row->opcion) == "SIN CLASES") {
                        $tbl .= '<div class="dia"><label>SIN CLASES</label><br> <small class = "hora">(' . $row->horainicial . ' - ' . $row->horafinal . ')</small></div>';
                    }
                }
            }
            $tbl .= '
</div> 
<div class = "dl">
<div class="diasemana"><label>MIERCOLES</label></div>
   ';
            if (isset($miercoles) && !empty($miercoles)) {
                foreach ($miercoles as $row) {
                    if (strtoupper($row->opcion) == "NORMAL") {
                        $tbl .= '<div class="dia"><label> ' . $row->nombreclase . '</label><br> <small class = "hora">(' . $row->horainicial . ' - ' . $row->horafinal . ')</small>
              <br>
              <small class = "hora">' . $row->nombre . ' ' . $row->apellidop . ' ' . $row->apellidom . '</small></div>';
                    }
                    if (strtoupper($row->opcion) == "DESCANSO") {
                        $tbl .= '<div class="dia"><label> ' . $row->nombreclase . '</label><br> <small class = "hora">(' . $row->horainicial . ' - ' . $row->horafinal . ')</small></div>';
                    }
                    if (strtoupper($row->opcion) == "SIN CLASES") {
                        $tbl .= '<div class="dia"><label>SIN CLASES</label><br> <small class = "hora">(' . $row->horainicial . ' - ' . $row->horafinal . ')</small></div>';
                    }
                }
            }
            $tbl .= '
</div> 
<div class = "dl">
<div class="diasemana"><label>JUEVES</label></div>
     ';
            if (isset($jueves) && !empty($jueves)) {
                foreach ($jueves as $row) {
                    if (strtoupper($row->opcion) == "NORMAL") {
                        $tbl .= '<div class="dia"><label> ' . $row->nombreclase . '</label><br> <small class = "hora">(' . $row->horainicial . ' - ' . $row->horafinal . ')</small>
              <br>
              <small class = "hora">' . $row->nombre . ' ' . $row->apellidop . ' ' . $row->apellidom . '</small></div>';
                    }
                    if (strtoupper($row->opcion) == "DESCANSO") {
                        $tbl .= '<div class="dia"><label> ' . $row->nombreclase . '</label><br> <small class = "hora">(' . $row->horainicial . ' - ' . $row->horafinal . ')</small></div>';
                    }
                    if (strtoupper($row->opcion) == "SIN CLASES") {
                        $tbl .= '<div class="dia"><label>SIN CLASES</label><br> <small class = "hora">(' . $row->horainicial . ' - ' . $row->horafinal . ')</small></div>';
                    }
                }
            }
            $tbl .= '
</div> 
<div class = "dl">
<div class="diasemana"><label>VIERNES</label></div>
    ';
            if (isset($viernes) && !empty($viernes)) {
                foreach ($viernes as $row) {
                    if (strtoupper($row->opcion) == "NORMAL") {
                        $tbl .= '<div class="dia"><label> ' . $row->nombreclase . '</label><br> <small class = "hora">(' . $row->horainicial . ' - ' . $row->horafinal . ')</small>
              <br>
              <small class = "hora">' . $row->nombre . ' ' . $row->apellidop . ' ' . $row->apellidom . '</small></div>';
                    }
                    if (strtoupper($row->opcion) == "DESCANSO") {
                        $tbl .= '<div class="dia"><label> ' . $row->nombreclase . '</label><br> <small class = "hora">(' . $row->horainicial . ' - ' . $row->horafinal . ')</small></div>';
                    }
                    if (strtoupper($row->opcion) == "SIN CLASES") {
                        $tbl .= '<div class="dia"><label>SIN CLASES</label><br> <small class = "hora">(' . $row->horainicial . ' - ' . $row->horafinal . ')</small></div>';
                    }
                }
            }
            $tbl .= '
</div> 
</body>
</html>
';
            $this->load->library('pdfgenerator');
            $this->dompdf->loadHtml($tbl);
            $this->dompdf->setPaper('A4');
            $this->dompdf->render();
            $this->dompdf->stream("Horario Escolar.pdf", array("Attachment" => 0));
        } else {
            $data = array(
                'heading' => 'Notificación',
                'message' => 'El Alumno(a) no tiene registrado Horario.'
            );
            $this->load->view('errors/html/error_general', $data);
        }
    }

    public function updatePasswordAlumno() {
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
                    $id = $this->input->post('idalumno');
                    $password_encrypted = password_hash(trim($this->input->post('password1')), PASSWORD_BCRYPT);

                    $data = array(
                        'password' => $password_encrypted,
                        'idusuario' => $this->session->user_id,
                        'fecharegistro' => date('Y-m-d H:i:s')
                    );
                    $this->alumno->updateAlumno($id, $data);
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

    public function obetnerAsistencia($idhorario = '', $fechai = '', $fechaf = '', $idalumno = '', $motivo = '') {
        // Permission::grant(uri_string());
        // $alumns = $this->grupo->alumnosGrupo($idhorario);

        $materias = $this->alumno->showAllMaterias($idhorario);
        $tabla = "";


        if ($materias != false) {
            $range = ((strtotime($fechaf) - strtotime($fechai)) + (24 * 60 * 60)) / (24 * 60 * 60);
            //$range= ((strtotime($_GET["finish_at"])-strtotime($_GET["start_at"]))+(24*60*60)) /(24*60*60);

            $tabla .= '<table class="table">
            <thead>
            <th>#</th>
            <th>Nombre</th>';
            for ($i = 0; $i < $range; $i++):
                $tabla .= '<th>' . date("D d-M", strtotime($fechai) + ($i * (24 * 60 * 60))) . '</th>';
                //echo date("d-M",strtotime($_GET["start_at"])+($i*(24*60*60)));
            endfor;
            $tabla .= '</thead>';
            $n = 1;
            foreach ($materias as $row) {
                $tabla .= ' <tr>';
                $tabla .= '<td>' . $n++ . '</td>';
                $tabla .= '<td >' . $row->nombreclase . '</td>';
                for ($i = 0; $i < $range; $i++):
                    $date_at = date("Y-m-d", strtotime($fechai) + ($i * (24 * 60 * 60)));
                    // $asist = AssistanceData::getByATD($alumn->id,$_GET["team_id"],$date_at);
                    $asist = $this->grupo->listaAsistenciaGeneral($idalumno, $idhorario, $date_at, $row->idhorariodetalle, $motivo);



                    $tabla .= '<td>';
                    if ($asist != false) {
                        switch ($asist->idmotivo) {
                            case 1:
                                # code...
                                $tabla .= '<span class="label label-success">' . $asist->nombremotivo . '</span>';
                                break;
                            case 2:
                                $tabla .= '<span class="label label-warning">' . $asist->nombremotivo . '</span>';
                                # code...
                                break;
                            case 3:
                                $tabla .= '<span class="label label-info">' . $asist->nombremotivo . '</span>';
                                # code...
                                break;
                            case 4:
                                $tabla .= '<span class="label label-danger">' . $asist->nombremotivo . '</span>';
                                # code...
                                break;

                            default:
                                # code...
                                break;
                        }
                    } else {
                        $tabla .= "No registrado.";
                    }

                    $tabla .= '</td>';
                endfor;
                $tabla .= '</tr>';
            }
            $tabla .= '</table>';
        }
        return $tabla;
    }

    public function asistencia($idhorario = '', $idalumno = '') {
        Permission::grant(uri_string());
        $materias = $this->alumno->showAllMaterias($idhorario);
        $tipoasistencia = $this->alumno->showAllTipoAsistencia();
        $data = array(
            'materias' => $materias,
            'idhorario' => $idhorario,
            'idalumno' => $idalumno,
            'tipoasistencia' => $tipoasistencia
        );
        $this->load->view('admin/header');
        $this->load->view('admin/alumno/asistencia', $data);
        $this->load->view('admin/footer');
    }

    public function buscarAsistencia() {
        //Permission::grant(uri_string());
        $materias = $this->input->post('materias');
        $idhorario = $this->input->post('idhorario');
        $idalumno = $this->input->post('idalumno');
        $fechainicio = $this->input->post('fechainicio');
        $fechafin = $this->input->post('fechafin');
        $motivo = $this->input->post('motivo');
        foreach ($materias as $key) {
            # code...
            // echo $key;
            if ($key == 2804) {
                $tabla = $this->obetnerAsistencia($idhorario, $fechainicio, $fechafin, $idalumno, $motivo);
                echo $tabla;
            } else {
                
            }
        }
    }

    public function deleteAlumno() {
        if (Permission::grantValidar(uri_string()) == 1) {
            $idalumno = $this->input->get('idalumno');
            $query = $this->alumno->deleteAlumno($idalumno);
            if ($query) {
                $result['error'] = false;
            } else {
                $result['error'] = true;
                $result['msg'] = array(
                    'msgerror' => 'No se puede Elimnar el Alumno.'
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

    public function boleta($idhorario = '', $idalumno = '', $idunidad = '') {
        //Permission::grant(uri_string());
        $detalle_logo = $this->alumno->logo($this->session->idplantel);
        $logo = base_url() . '/assets/images/escuelas/' . $detalle_logo[0]->logoplantel;
        $logo2 = base_url() . '/assets/images/escuelas/' . $detalle_logo[0]->logosegundo;
        $detalle_configuracion = $this->configuracion->showAllConfiguracion($this->session->idplantel);
        $datelle_alumno = $this->alumno->showAllMateriasAlumno($idalumno, 1);
        $materias = $this->alumno->showAllMaterias($idhorario);
        $detalle_unidad = $this->alumno->detalleUnidad($idunidad);
        $this->load->library('tcpdf');
        $hora = date("h:i:s a");
        //$linkimge = base_url() . '/assets/images/woorilogo.png';
        $fechaactual = date('d/m/Y');
        $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetTitle('Boleta de Calificación.');
        $pdf->SetHeaderMargin(30);
        $pdf->SetTopMargin(10);
        $pdf->setFooterMargin(20);
        $pdf->SetAutoPageBreak(true);
        $pdf->SetAuthor('Sistema Integral para el Control Escolar');
        $pdf->SetDisplayMode('real', 'default');
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        $pdf->AddPage();

        $tbl = '
<style type="text/css">
    .txtn{
        font-size:7px;
    }
    .direccion{
        font-size:8px;
    }
    .nombreplantel{
        font-size:11px;
        font-weight:bolder;
    }
    .telefono{
          font-size:7px;
    }
    .boleta{
         font-size:9px;
         font-weight:bolder;
    }
     .periodo{
         font-size:9px;
         font-weight:bolder;
    }
    .txtgeneral{
         font-size:8px;
         font-weight:bolder; 
    }
    .txtnota{
         font-size:6px;
         font-weight:bolder; 
    } 
    .txtcalificacion{
        font-size:10px;
         font-weight:bolder; 
    } 
    .imgtitle{
        width:55px;

    }
    .imgprincipal{
        width:90px;
    }
</style>
<table width="610" border="0" cellpadding="2" cellspacing="0">
  <tr>
    <td width="101" align="center"><img   class="imgtitle" src="' . $logo2 . '" /></td>
    <td colspan="2" align="center">
            <label class="nombreplantel">' . $detalle_logo[0]->nombreplantel . '</label><br>
            <label class="txtn">' . $detalle_logo[0]->asociado . '</label><br>
            <label class="direccion">' . $detalle_logo[0]->direccion . '</label><br>
            <label class="telefono">TELÉFONO: ' . $detalle_logo[0]->telefono . '</label>
    </td>
    <td width="137" align="center"><img   class="imgprincipal" src="' . $logo . '" /></td>
  </tr>
   <tr>
    <td width="543" colspan="3" align="center"><label class="boleta">BOLETA DE CALIFICACIONES DEL ' . $detalle_unidad[0]->nombreunidad . '</label></td>  
  </tr>
   <tr> 
    <td width="543" colspan="3" align="center"><label class="periodo">PERIODO: ' . $datelle_alumno[0]->mesinicio . ' - ' . $datelle_alumno[0]->mesfin . ' DE ' . $datelle_alumno[0]->yearfin . '</label></td> 
  </tr>
 <tr>
    <td width="50" valign="bottom"  class="txtgeneral" >NOMBRE:</td>
    <td width="300" valign="bottom" class="txtgeneral" style="border-bottom:solid 1px black;"> ' . $datelle_alumno[0]->apellidop . ' ' . $datelle_alumno[0]->apellidom . ' ' . $datelle_alumno[0]->nombre . '</td>
    <td width="60" valign="bottom" class="txtgeneral"> GRUPO:</td>
    <td width="130" valign="bottom" class="txtgeneral" style="border-bottom:solid 1px black;">' . $datelle_alumno[0]->nombrenivel . ' ' . $datelle_alumno[0]->nombregrupo . '</td>
  </tr>
  <tr>
   <td width="60" valign="bottom"  class="txtgeneral" >INSCRIPCIÓN:</td>
    <td width="290" valign="bottom" class="txtgeneral" style="border-bottom:solid 1px black;"> PRIMERA</td>
    <td width="60" valign="bottom" class="txtgeneral"> NUA:</td>
    <td width="130" valign="bottom" class="txtgeneral" style="border-bottom:solid 1px black;">' . $datelle_alumno[0]->matricula . '</td>
  </tr>
<tr>
   <td width="60" colspan="4" ></td> 
  </tr>
    <tr >
   <td width="60" style="border:solid 1px black; background-color:#ccc;" valign="bottom" align="center"  class="txtgeneral" >NUM</td>
    <td width="290" style="border:solid 1px black; background-color:#ccc;" valign="bottom"  align="center" class="txtgeneral">MATERIA</td>
    <td width="60" style="border:solid 1px black; background-color:#ccc;" valign="bottom"  align="center" class="txtgeneral">FALTAS</td>
    <td width="130"style="border:solid 1px black; background-color:#ccc;" valign="bottom"  align="center" class="txtgeneral">CALIFICACIÓN</td>
  </tr>
  ';
        if (isset($materias) && !empty($materias)) {
            $numero = 1;
            $total_materia = 0;
            $total_calificacion = 0;
            $promedio_final = 0;
            $total_reprobadas = 0;
            $total_aprovadas = 0;
            foreach ($materias as $row) {
                $total_materia = $total_materia + 1;
                $idhorariodetalle = $row->idhorariodetalle;
                $calificacion_alumno = $this->alumno->obtenerCalificacionMateria($idhorariodetalle, $idalumno, $idunidad);
                $asistencia = $this->alumno->obtenerAsistenciaMateria($idhorariodetalle, $idalumno, $idunidad);
                $tbl .= ' <tr >
           <td width="60" style="border:solid 1px black;" valign="bottom" align="center"  class="txtgeneral" >' . $numero++ . '</td>
            <td width="290" style="border:solid 1px black;" valign="bottom" class="txtgeneral">' . $row->nombreclase . '</td>
            <td width="60" style="border:solid 1px black;" valign="bottom"  align="center" class="txtgeneral">';
                if ($asistencia != FALSE) {
                    $total_falta = 0;
                    foreach ($asistencia as $value) {
                        $total_falta = $total_falta + 1;
                    }
                    $tbl .= '<label>' . $total_falta . '</label>';
                } else {
                    $tbl .= '0';
                }
                $tbl .= '</td>
            <td width="130"style="border:solid 1px black;" align="center" valign="bottom" class="txtgeneral">';
                if ($calificacion_alumno != FALSE) {
                    $total_calificacion = $total_calificacion + $calificacion_alumno->calificacion;
                    if (validar_calificacion($calificacion_alumno->calificacion, $detalle_configuracion[0]->calificacionminima)) {
                        $total_reprobadas = $total_reprobadas + 1;
                        $tbl .= '<label>' . $calificacion_alumno->calificacion . '</label>';
                    } else {
                        $total_aprovadas = $total_aprovadas + 1;
                        $tbl .= '<label>' . $calificacion_alumno->calificacion . '</label>';
                    }
                } else {
                    $tbl .= 'S/C';
                }
                $tbl .= '</td>
          </tr>';
            }
            $promedio_final = $total_calificacion / $total_materia;
        }
        $tbl .= '<tr >
   <td width="60" style="" valign="bottom" align="center"  class="txtgeneral" ></td>
    <td width="290" style="" valign="bottom"  align="center" class="txtgeneral"></td>
    <td width="60" style="border:solid 1px black; background-color:#ccc;" valign="bottom"  align="center" class="txtgeneral">PROMEDIO:</td>
    <td width="130"style="border:solid 1px black; background-color:#ccc;" valign="bottom"  align="center" class="txtcalificacion">' . number_format($promedio_final, 2) . '</td>
  </tr>
  <tr >
   <td width="60" style="" valign="bottom" align="center"  class="txtgeneral" ></td>
    <td width="290" style="" valign="bottom"  align="center" class="txtgeneral"></td>
    <td width="60"  valign="bottom"  align="center" class="txtgeneral"></td>
    <td width="130" valign="bottom"  align="center" class="txtgeneral"></td>
  </tr>
  <tr >
   <td width="60" style="" valign="bottom" align="center"  class="txtgeneral" ></td>
    <td width="290" style="" valign="bottom"  align="center" class="txtgeneral"></td>
    <td width="60" class="txtgeneral"></td>
    <td width="130"style="" valign="bottom"  align="right" class="txtgeneral">APROVADAS: ' . $total_aprovadas . ' </td>
  </tr>
   <tr >
   <td width="60" style="" valign="bottom" align="center"  class="txtgeneral"  ></td>
    <td width="290" style="" valign="bottom"  align="center" style="border-bottom:solid 2px black" class="txtgeneral"></td>
    <td width="60" class="txtgeneral" ></td>
    <td width="130"style="" valign="bottom"  align="right" class="txtgeneral">REPROVADAS: ' . $total_reprobadas . '</td>
  </tr>
   <tr >
   <td width="60" style="" valign="bottom" align="center"  class="txtgeneral"  ></td>
    <td width="290" style="" valign="bottom"  align="center" style="" class="txtgeneral">LRI.MARÍA ELENA DURÁN HERNÁNDEZ</td> 
    <td width="190"  colspan= "2"  style="" valign="bottom"  align="center" class="txtgeneral"> *Sin validez oficial </td>
  </tr>
  <tr > 
    <td width="540"  colspan= "4"  style="" valign="bottom"  align="left" class="txtnota">   </td>
  </tr>
  <tr > 
    <td width="540"  colspan= "4"  style="" valign="bottom"  align="left" class="txtnota">  </td>
  </tr>
  <tr > 
    <td width="540"  colspan= "4"  style="" valign="bottom"  align="left" class="txtnota"> NOTA: AC = ACREDITADO, NA= NO ACREDITADO, MÍNIMA APROVATORIA = 7.0 </td>
  </tr>
  ';
        $tbl .= '</table>
 

      ';

        $pdf->writeHTML($tbl, true, false, false, false, '');

        ob_end_clean();


        $pdf->Output('Boleta de Calificación.pdf', 'I');
    }

}