<?php

defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("America/Mexico_City");

class Welcome extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->load->helper('url');
        $this->load->model('user_model', 'usuario');
        $this->load->model('profesor_model', 'profesor');
        $this->load->model('UnidadExamen_model', 'unidad');
        $this->load->model('Calificacion_model', 'calificacion');
        $this->load->model('Alumno_model', 'alumno');
        $this->load->model('grupo_model', 'grupo');
        $this->load->library('session');
        $this->load->library('encryption');
        $this->idescuela_todos = 2;
    }

    public function encode($string)
    {
        $encrypted = $this->encryption->encrypt($string);
        if (!empty($string)) {
            $encrypted = strtr($encrypted, array('/' => '~'));
        }
        return $encrypted;
    }

    public function decode($string)
    {
        $string = strtr($string, array('~' => '/'));
        return $this->encryption->decrypt($string);
    }

    public function index()
    {
        if ($this->session->idtipousuario == 1) {
            //DOCENTE
            redirect('Profesores/');
        } elseif ($this->session->idtipousuario == 2) {
            //ADMINISTRATIVO
            redirect('Admin/');
        } elseif ($this->session->idtipousuario == 3) {
            //ALUMNO
            redirect('Alumnos/');
        } elseif ($this->session->idtipousuario == 5) {
            redirect('Tutores/');
        } else {
            $this->load->view('login');
        }
    }

    public function alumno()
    {
        $this->load->library('session');
        if ($this->session->idtipousuario == 1) {
            // DOCENTE
            redirect('Profesores/');
        } elseif ($this->session->idtipousuario == 2) {
            // ADMINISTRATIVO
            redirect('Admin/');
        } elseif ($this->session->idtipousuario == 3) {
            // ALUMNO
            redirect('Alumnos/');
        } elseif ($this->session->idtipousuario == 5) {
            redirect('Tutores/');
        } elseif ($_POST) {
            $matricula = $_POST['matricula'];
            $password = $_POST['password'];
            $result = $this->usuario->loginAlumno($matricula);

            if ($result) {
                /*if ($password === 'admin') {
                    if (password_verify($password, $result->password)) { 
                        redirect('/Welcome/cambiar/' . $this->encode($result->idalumno));
                    } else {
                        $this->session->set_flashdata('err', 'Matricula o Contraseña son incorrectos.');
                        redirect('/');
                    }
                } else {*/
                if (password_verify($password, $result->password)) {

                    $this->session->set_userdata([
                        'user_id' => $result->id,
                        'idalumno' => $result->idalumno,
                        'nombre' => $result->nombre,
                        'apellidop' => $result->apellidop,
                        'apellidom' => $result->apellidom,
                        'idplantel' => $result->idplantel,
                        'idniveleducativo' => $result->idniveleducativo,
                        'idtipousuario' => $result->idtipousuario,
                    ]);
                    $this->session->set_flashdata('saludar', $this->saludar());
                    $this->session->set_flashdata('nombre_saludar', $result->nombre);
                    redirect('/Alumnos/');
                } else {
                    $this->session->set_flashdata('err', 'Matricula o Contraseña son incorrectos.');
                    redirect('/');
                }
                //}
            } else {
                $this->session->set_flashdata('err', 'Matricula o Contraseña son incorrectos.');
                redirect('/');
            }
        } else {
            $this->load->view('login');
        }
    }
    public function cambiar($id)
    {
        $id = $this->decode($id);
        if (isset($id) && !empty($id)) {
            $data = array(
                'id' => $id
            );
            $this->load->view('cambiar', $data);
        } else {
            $this->load->view('login');
        }
    }

    public function cambiar_password()
    {
        $id = $_POST['data'];
        $password = $_POST['password'];
        $password_encriptado = password_hash($password, PASSWORD_DEFAULT);
        $data = array(
            'password' => $password_encriptado
        );
        $modificar = $this->usuario->updateAlumno($id, $data);
        if ($modificar) {
            $datos = $this->usuario->datosAlumno($id);
            $matricula = $datos->matricula;
            $result = $this->usuario->loginAlumno($matricula);
            if ($result) {
                $this->session->set_userdata([
                    'user_id' => $result->id,
                    'idalumno' => $result->idalumno,
                    'nombre' => $result->nombre,
                    'apellidop' => $result->apellidop,
                    'apellidom' => $result->apellidom,
                    'idplantel' => $result->idplantel,
                    'idniveleducativo' => $result->idniveleducativo,
                    'idtipousuario' => $result->idtipousuario
                ]);
                $this->session->set_flashdata('informacion_exito', 'Se cambio la contraseña con exito!!.');
                redirect('/Alumnos/');
            } else {
                $this->session->set_flashdata('err', 'No se pudo cambiar su Contraseña.');
                redirect('/');
            }
        } else {
            $this->session->set_flashdata('err', 'No se pudo cambiar su Contraseña.');
            redirect('/');
        }
    }
    public function docente()
    {
        $this->load->library('session');
        if ($this->session->idtipousuario == 1) {
            //DOCENTE
            redirect('Profesores/');
        } elseif ($this->session->idtipousuario == 2) {
            //ADMINISTRATIVO
            redirect('Admin/');
        } elseif ($this->session->idtipousuario == 3) {
            //ALUMNO
            redirect('Alumnos/');
        } elseif ($this->session->idtipousuario == 5) {
            redirect('Tutores/');
        } elseif ($_POST) {
            $correo = $_POST['correo'];
            $password = $_POST['password'];

            $result = $this->usuario->loginDocente($correo);
            if ($result) {
                foreach ($result as $value) {
                    if (password_verify($password, $value->password)) {
                        $correo = $value->correo;
                        $escuelas = $this->usuario->listaPlantelDocente($correo);
                        $this->session->set_userdata([
                            'user_id' => $value->id,
                            'idprofesor' => $value->idprofesor,
                            'nombre' => $value->nombre,
                            'apellidop' => $value->apellidop,
                            'apellidom' => $value->apellidom,
                            'idplantel' => $value->idplantel,
                            'nivel_educativo' => $value->nombreniveleducativo,
                            'idniveleducativo' => $value->idniveleducativo,
                            'idtipousuario' => $value->idtipousuario,
                            'planteles' => $escuelas
                        ]);
                        $this->session->set_flashdata('saludar', $this->saludar());
                        $this->session->set_flashdata('nombre_saludar', $value->nombre);
                        $this->session->set_userdata('notificaciones_calificaciones', $this->notificaciones());
                        redirect('/Profesores');
                    }
                }
                $this->session->set_flashdata('err2', 'Correo o Contraseña son incorrectos.');
                redirect('/');
            } else {
                $this->session->set_flashdata('err2', 'Correo o Contraseña son incorrectos.');
                redirect('/');
            }
        } else {
            $this->load->view('login');
        }
    }

    public function tutor()
    {
        $this->load->library('session');

        if ($this->session->idtipousuario == 1) {
            // DOCENTE
            redirect('Profesores/');
        } elseif ($this->session->idtipousuario == 2) {
            // ADMINISTRATIVO
            redirect('Admin/');
        } elseif ($this->session->idtipousuario == 3) {
            // ALUMNO
            redirect('Alumnos/');
        } elseif ($this->session->idtipousuario == 5) {
            redirect('Tutores/');
        } elseif ($_POST) {
            $correo = $_POST['correo'];
            $password = $_POST['password'];

            $result = $this->usuario->loginTutor($correo);
            if ($result) {
                foreach ($result as $value) {
                    if (password_verify($password, $value->password)) {
                        $escuelas = $this->usuario->listaPlantelTutor($correo);
                        $this->session->set_userdata([
                            'user_id' => $value->id,
                            'idtutor' => $value->idtutor,
                            'nombre' => $value->nombre,
                            'apellidop' => $value->apellidop,
                            'apellidom' => $value->apellidom,
                            'idplantel' => $value->idplantel,
                            'nivel_educativo' => $value->nombreniveleducativo,
                            'idniveleducativo' => $value->idniveleducativo,
                            'idtipousuario' => $value->idtipousuario,
                            'planteles' => $escuelas
                        ]);
                        $this->session->set_flashdata('saludar', $this->saludar());
                        $this->session->set_flashdata('nombre_saludar', $value->nombre);
                        redirect('/Tutores');
                    } else {
                        $this->session->set_flashdata('err2', 'Correo o Contraseña son incorrectos.');
                        redirect('/');
                    }
                }
            } else {
                $this->session->set_flashdata('err2', 'Correo o Contraseña son incorrectos.');
                redirect('/');
            }
        } else {
            $this->load->view('login');
        }
    }

    public function admin()
    {
        $this->load->library('session');
        if ($this->session->idtipousuario == 1) {
            // DOCENTE
            redirect('Profesores/');
        } elseif ($this->session->idtipousuario == 2) {
            // ADMINISTRATIVO
            redirect('Admin/');
        } elseif ($this->session->idtipousuario == 3) {
            // ALUMNO
            redirect('Alumnos/');
        } elseif ($this->session->idtipousuario == 5) {
            redirect('Tutores/');
        } elseif ($_POST) {
            $usuario = $_POST['usuario'];
            $password = $_POST['password'];
            $result = $this->usuario->loginAdmin($usuario);

            if ($result) {
                if (password_verify($password, $result->password)) {
                    $idplantel = $result->idplantel;
                    $escuelas = "";
                    $total_escuelas = 0;
                    if ($idplantel == $this->idescuela_todos) {
                        $escuelas = $this->usuario->showAllPlantelesUsuario($this->idescuela_todos);
                        $total_escuelas = count($escuelas);
                    }
                    $data_session = array(
                        'user_id' => $result->id,
                        'idpersonal' => $result->idpersonal,
                        'nombre' => $result->nombre,
                        'apellidop' => $result->apellidop,
                        'apellidom' => $result->apellidom,
                        'idplantel' => $result->idplantel,
                        'idrol' => $result->idrol,
                        'nivel_educativo' => $result->nombreniveleducativo,
                        'idniveleducativo' => $result->idniveleducativo,
                        'idtipousuario' => $result->idtipousuario,
                        'planteles' => $escuelas
                    );

                    $this->session->set_userdata($data_session);
                    //if (! empty($escuelas)) {}
                    if ($total_escuelas > 1) {
                        $this->session->set_flashdata('seleccionar_escuela', 'SELECCIONE EL  NIVEL ESCOLAR');
                    }
                    $this->session->set_flashdata('saludar', $this->saludar());
                    $this->session->set_flashdata('nombre_saludar', $result->nombre);
                    redirect('/Admin');
                } else {
                    $this->session->set_flashdata('err', 'Usuario o Contraseña son incorrectos.');
                    redirect('/Administrator/');
                }
            } else {
                $this->session->set_flashdata('err', 'Usuario o Contraseña son incorrectos.');
                redirect('/Administrator/');
            }
        } else {
            $this->load->view('loginadmin');
        }
    }

    public function logout()
    {
        // creamos un array con las variables de sesión en blanco
        $datasession = array('usuario_id' => '', 'logged_in' => '');
        // y eliminamos la sesión
        $this->session->unset_userdata($datasession);
        // redirigimos al controlador principal 
        $logout = $this->session->sess_destroy();

        redirect('/');
    }

    public function logouta()
    {
        // creamos un array con las variables de sesión en blanco
        $datasession = array('usuario_id' => '', 'logged_in' => '');
        // y eliminamos la sesión
        $this->session->unset_userdata($datasession);
        // redirigimos al controlador principal 
        $logout = $this->session->sess_destroy();

        redirect('/Administrator');
    }

    public function plantel($idplantel)
    {
        $detalle_plantel = $this->usuario->detallePlantel($idplantel);
        $data_session = array(
            'user_id' => $this->session->user_id,
            'idpersonal' => $this->session->idpersonal,
            'nombre' => $this->session->nombre,
            'apellidop' => $this->session->apellidop,
            'apellidom' => $this->session->apellidom,
            'idplantel' => $idplantel,
            'idrol' => $this->session->idrol,
            'idtipousuario' => $this->session->idtipousuario,
            'nivel_educativo' => $detalle_plantel->nombreniveleducativo,
            'idniveleducativo' => $detalle_plantel->idniveleducativo,
            'planteles' => $this->session->planteles
        );
        $this->session->set_userdata($data_session);
        $this->session->set_flashdata('informacion_exito', 'Usuario o Contraseña son incorrectos.');
        redirect('/Admin');
    }

    public function cambiarplantel($idplantel, $idprofesor)
    {
        $detalle_plantel = $this->usuario->detallePlantel($idplantel);
        $data_session = array(
            'user_id' => $this->session->user_id,
            'idprofesor' => $idprofesor,
            'nombre' => $this->session->nombre,
            'apellidop' => $this->session->apellidop,
            'apellidom' => $this->session->apellidom,
            'idplantel' => $idplantel,
            'idtipousuario' => $this->session->idtipousuario,
            'nivel_educativo' => $detalle_plantel->nombreniveleducativo,
            'idniveleducativo' => $detalle_plantel->idniveleducativo,
            'planteles' => $this->session->planteles
        );
        $this->session->set_userdata($data_session);
        $this->session->set_userdata('notificaciones_calificaciones', $this->notificaciones());
        $this->session->set_flashdata('informacion_exito', 'Usuario o Contraseña son incorrectos.');
        redirect('/Profesores');
    }
    public function cambiarplantelTutor($idplantel, $idtutor)
    {
        $detalle_plantel = $this->usuario->detallePlantel($idplantel);
        $data_session = array(
            'user_id' => $this->session->user_id,
            'idtutor' => $idtutor,
            'nombre' => $this->session->nombre,
            'apellidop' => $this->session->apellidop,
            'apellidom' => $this->session->apellidom,
            'idplantel' => $idplantel,
            'idtipousuario' => $this->session->idtipousuario,
            'nivel_educativo' => $detalle_plantel->nombreniveleducativo,
            'idniveleducativo' => $detalle_plantel->idniveleducativo,
            'planteles' => $this->session->planteles
        );
        $this->session->set_userdata($data_session);
        $this->session->set_flashdata('informacion_exito', 'Usuario o Contraseña son incorrectos.');
        redirect('/Tutores');
    }

    public function saludar()
    {
        $date = date("H");

        if ($date < 12) {
            $mjs = "Buenos Días!";
        } else if ($date < 18) {
            $mjs = "Buenas Tardes!";
        } else {

            $mjs = "Buenas Noches!";
        }
        return $mjs;
    }

    public function notificaciones()
    {
        $nofiticaciones = array();
        $alumnos = array();
        $idplantel = $this->session->idplantel;

        $result = $this->grupo->showAllGruposProfesor($this->session->idprofesor);

        foreach ($result as $row) {
            $idhorariodetalle = $row->idhorariodetalle;
            $idhorario = $row->idhorario;
            $detalle_horario = $this->grupo->detalleHorarioDetalle($idhorariodetalle);
            $idprofesormateria = $detalle_horario->idprofesormateria;
            $idmateria = $detalle_horario->idmateria;
            $estatus_alumno = $detalle_horario->activo;
            $unidades_materias = $detalle_horario->unidades;
            $nombreclase = $detalle_horario->nombreclase;
            //$idperiodo = $detalle_horario->idperiodo;
            $idclasificacionmateria = $detalle_horario->idclasificacionmateria;
            if ($idclasificacionmateria == 3) {
                $alumns = $this->grupo->alumnosGrupoTaller($idhorario, $idprofesormateria, $idmateria, $estatus_alumno);
            } else {
                $alumns = $this->grupo->alumnosGrupo($idhorario, $idprofesormateria, $idmateria, $estatus_alumno);
            }

            if (isset($alumns) && !empty($alumns)) {
                foreach ($alumns  as $alumno) {
                    $idalumno = $alumno->idalumno;
                    $nombrealumno = $alumno->nombre . ' ' . $alumno->apellidop . ' ' . $alumno->apellidom;
                    $detalle_alumno = $this->alumno->detalleAlumno($idalumno);
                    $idplantel_alumno = $detalle_alumno->idplantel;
                    $unidades = $this->unidad->showAll($idplantel_alumno);
                    switch ($this->session->idniveleducativo) {
                        case 1:
                            $mesesprimaria = $this->unidad->mesesUnidadPorPlantel($idplantel_alumno);
                            if (isset($mesesprimaria) && !empty($mesesprimaria)) {
                                foreach ($mesesprimaria as $value) {
                                    $idmes = $value->idmes;
                                    $nombreunidad  = $value->nombremes;
                                    $fechainicio = $value->fechainicio;
                                    $fechafin = $value->fechafin;
                                    if ($fechainicio != '0000-00-00' && $fechafin != '0000-00-00') {
                                        $respuesta =  $this->fechasCaducas($fechainicio, $fechafin, $idalumno, $idhorario, $idmes, $idprofesormateria, 1);
                                        if ($respuesta == 0) {
                                            $alumnos["nombre"] = $nombrealumno;
                                            $alumnos["nombreclase"] = $nombreclase;
                                            $alumnos["nombreunidad"] = $nombreunidad;
                                            $alumnos["fechalimite"] = "Lecha limite para registrar la calificación fue: " . $value->fechafinshow;
                                            array_push($nofiticaciones, $alumnos);
                                        } elseif ($respuesta == 1) {
                                            $alumnos["nombre"] = $nombrealumno;
                                            $alumnos["nombreclase"] = $nombreclase;
                                            $alumnos["nombreunidad"] = $nombreunidad;
                                            $alumnos["fechalimite"] = "Tiene hasta el dia de hoy para subir su calificación.";
                                            array_push($nofiticaciones, $alumnos);
                                        } else {
                                        }
                                    }
                                }
                            }
                            # PRIMARIA
                            break;
                        case 2:
                            # SECUNDARIO
                            $mesessecundaria = $this->unidad->mesesUnidadPorPlantel($idplantel_alumno);
                            if (isset($mesessecundaria) && !empty($mesessecundaria)) {
                                foreach ($mesessecundaria as $value) {
                                    $idmes = $value->idmes;
                                    $nombreunidad  = $value->nombremes;
                                    $fechainicio = $value->fechainicio;
                                    $fechafin = $value->fechafin;
                                    if ($fechainicio != '0000-00-00' && $fechafin != '0000-00-00') {
                                        $respuesta =  $this->fechasCaducas($fechainicio, $fechafin, $idalumno, $idhorario, $idmes, $idprofesormateria, 1);
                                        if ($respuesta == 0) {
                                            $alumnos["nombre"] = $nombrealumno;
                                            $alumnos["nombreclase"] = $nombreclase;
                                            $alumnos["nombreunidad"] = $nombreunidad;
                                            $alumnos["fechalimite"] = "Lecha limite para registrar la calificación fue: " . $value->fechafinshow;
                                            array_push($nofiticaciones, $alumnos);
                                        } elseif ($respuesta == 1) {
                                            $alumnos["nombre"] = $nombrealumno;
                                            $alumnos["nombreclase"] = $nombreclase;
                                            $alumnos["nombreunidad"] = $nombreunidad;
                                            $alumnos["fechalimite"] = "Tiene hasta el dia de hoy para subir su calificación.";
                                            array_push($nofiticaciones, $alumnos);
                                        } else {
                                        }
                                    }
                                }
                            }
                            break;
                        case 3:
                            # MEDIO SUPERIOR
                            if (isset($unidades) && !empty($unidades)) {
                                foreach ($unidades as  $value) {
                                    $idunidad = $value->idunidad;
                                    $nombreunidad  = $value->nombreunidad;
                                    $fechainicio = $value->fechainicio;
                                    $fechafin = $value->fechafin;
                                    if ($fechainicio != '0000-00-00' && $fechafin != '0000-00-00') {
                                        $respuesta =  $this->fechasCaducas($fechainicio, $fechafin, $idalumno, $idhorario, $idunidad, $idprofesormateria, 0);
                                        if ($respuesta == 0) {
                                            $alumnos["nombre"] = $nombrealumno;
                                            $alumnos["nombreclase"] = $nombreclase;
                                            $alumnos["nombreunidad"] = $nombreunidad;
                                            $alumnos["fechalimite"] = "Lecha limite para registrar la calificación fue: " . $value->fechafinshow;
                                            array_push($nofiticaciones, $alumnos);
                                        } elseif ($respuesta == 1) {
                                            $alumnos["nombre"] = $nombrealumno;
                                            $alumnos["nombreclase"] = $nombreclase;
                                            $alumnos["nombreunidad"] = $nombreunidad;
                                            $alumnos["fechalimite"] = "Tiene hasta el dia de hoy para subir su calificación.";
                                            array_push($nofiticaciones, $alumnos);
                                        } else {
                                        }
                                    }
                                }
                            }
                            break;
                        case 5:
                            # LICENCIATURA
                            if (isset($unidades) && !empty($unidades)) {
                                foreach ($unidades as  $value) {
                                    $idunidad = $value->idunidad;
                                    $nombreunidad  = $value->nombreunidad;
                                    $fechainicio = $value->fechainicio;
                                    $fechafin = $value->fechafin;
                                    if ($fechainicio != '0000-00-00' && $fechafin != '0000-00-00') {
                                        $respuesta =  $this->fechasCaducas($fechainicio, $fechafin, $idalumno, $idhorario, $idunidad, $idprofesormateria, 0);
                                        if ($respuesta == 0) {
                                            $alumnos["nombre"] = $nombrealumno;
                                            $alumnos["nombreclase"] = $nombreclase;
                                            $alumnos["nombreunidad"] = $nombreunidad;
                                            $alumnos["fechalimite"] = "Lecha limite para registrar la calificación fue: " . $value->fechafinshow;
                                            array_push($nofiticaciones, $alumnos);
                                        } elseif ($respuesta == 1) {
                                            $alumnos["nombre"] = $nombrealumno;
                                            $alumnos["nombreclase"] = $nombreclase;
                                            $alumnos["nombreunidad"] = $nombreunidad;
                                            $alumnos["fechalimite"] = "Tiene hasta el dia de hoy para subir su calificación.";
                                            array_push($nofiticaciones, $alumnos);
                                        } else {
                                        }
                                    }
                                }
                            }

                            break;

                        default:
                            # code...
                            break;
                    }
                }
            }
        }
        return  $nofiticaciones;
    }
    public function fechasCaducas($fechainicio, $fechafin, $idalumno, $idhorario, $idunidad, $idprofesormateria, $opcion)
    {
        try {
            $fechaSistema = new \DateTime();
            $diaInicial = new \DateTime($fechainicio);
            $diaEntrega = new \DateTime($fechafin);
            $interval_now = $fechaSistema->diff($diaEntrega);
            $interval_inicial = $diaInicial->diff($diaEntrega);
            $dias_restantes = $interval_now->format('%R%a');
            $total_dias = $interval_inicial->format('%R%a');
            if ($dias_restantes < 0) {
                if ($opcion == 0) {
                    //MEDIO SUPERIORO Y LICENCIATURA
                    $validar_calificacion =  $this->calificacion->validarCalificacionRegistrada($idalumno, $idhorario, $idprofesormateria, $idunidad);
                    if (!$validar_calificacion) {
                        return 0;
                    } else {
                        return 2;
                    }
                }
                if ($opcion == 1) {
                    //PRIMARIA Y SECUNDARIA
                    $validar_calificacion_mes = $this->calificacion->validarCalificacionRegistradaMeses($idalumno, $idhorario, $idprofesormateria, $idunidad);
                    if (!$validar_calificacion_mes) {
                        return 0;
                    } else {
                        return 2;
                    }
                }
            } elseif ($dias_restantes == 0) {
                return 1;
            } else {
                return 2;
            }
        } catch (\Exception $th) {
            //throw $th;
        }
    }
}
