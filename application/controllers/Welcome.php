<?php

defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("America/Mexico_City");

class Welcome extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->helper('url');
        $this->load->model('user_model', 'usuario');
        $this->load->library('session');
        $this->load->library('encryption');
        $this->idescuela_todos = 2;
    }

    public function encode($string) {
        $encrypted = $this->encryption->encrypt($string);
        if (!empty($string)) {
            $encrypted = strtr($encrypted, array('/' => '~'));
        }
        return $encrypted;
    }

    public function decode($string) {
        $string = strtr($string, array('~' => '/'));
        return $this->encryption->decrypt($string);
    }

    public function index() {
        if ($this->session->idtipousuario == 1) {
            //DOCENTE
            redirect('Profesores/');
        } elseif ($this->session->idtipousuario == 2){
            //ADMINISTRATIVO
            redirect('Admin/');
        } elseif ($this->session->idtipousuario == 3){
            //ALUMNO
            redirect('Alumnos/');
        } elseif ($this->session->idtipousuario == 5){
            redirect('Tutores/');
        } else{
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
                        $this->session->set_flashdata('saludar',$this->saludar());
                        $this->session->set_flashdata('nombre_saludar',$result->nombre);
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
    public function cambiar($id){
        $id = $this->decode($id);
        if(isset($id) && !empty($id)){
            $data = array(
                'id'=>$id
            );
            $this->load->view('cambiar',$data);
        }else{
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
        }else{
            $this->session->set_flashdata('err', 'No se pudo cambiar su Contraseña.');
            redirect('/');
        }
    }
    public function docente() {
        $this->load->library('session');
        if ($this->session->idtipousuario == 1) {
            //DOCENTE
            redirect('Profesores/');
        } elseif ($this->session->idtipousuario == 2){
            //ADMINISTRATIVO
            redirect('Admin/');
        } elseif ($this->session->idtipousuario == 3){
            //ALUMNO
            redirect('Alumnos/');
        } elseif ($this->session->idtipousuario == 5){
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
                        'idtipousuario'=>$value->idtipousuario,
                        'planteles' => $escuelas
                    ]);
                    $this->session->set_flashdata('saludar',$this->saludar());
                    $this->session->set_flashdata('nombre_saludar',$value->nombre);
                    redirect('/Profesores');
                }
            }
            $this->session->set_flashdata('err2', 'Correo o Contraseña son incorrectos.');
            redirect('/'); 
        } else {
            $this->session->set_flashdata('err2', 'Correo o Contraseña son incorrectos.');
            redirect('/');
        }
        } else{
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
                        $this->session->set_flashdata('saludar',$this->saludar());
                        $this->session->set_flashdata('nombre_saludar',$value->nombre);
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
                    if ($idplantel == $this->idescuela_todos) {
                        $escuelas = $this->usuario->showAllPlantelesUsuario($this->idescuela_todos);
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
                    if (! empty($escuelas)) {}
                    $this->session->set_flashdata('saludar',$this->saludar());
                    $this->session->set_flashdata('nombre_saludar',$result->nombre);
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

    public function logout() {
        // creamos un array con las variables de sesión en blanco
        $datasession = array('usuario_id' => '', 'logged_in' => '');
        // y eliminamos la sesión
        $this->session->unset_userdata($datasession);
        // redirigimos al controlador principal 
        $logout = $this->session->sess_destroy();

        redirect('/');
    }

    public function logouta() {
        // creamos un array con las variables de sesión en blanco
        $datasession = array('usuario_id' => '', 'logged_in' => '');
        // y eliminamos la sesión
        $this->session->unset_userdata($datasession);
        // redirigimos al controlador principal 
        $logout = $this->session->sess_destroy();

        redirect('/Administrator');
    }

    public function plantel($idplantel) {
        $detalle_plantel = $this->usuario->detallePlantel($idplantel);
        $data_session = array(
            'user_id' => $this->session->user_id,
            'idpersonal' => $this->session->idpersonal,
            'nombre' => $this->session->nombre,
            'apellidop' => $this->session->apellidop,
            'apellidom' => $this->session->apellidom,
            'idplantel' => $idplantel,
            'idrol' => $this->session->idrol,
            'idtipousuario'=>$this->session->idtipousuario,
            'nivel_educativo' => $detalle_plantel->nombreniveleducativo,
            'idniveleducativo' => $detalle_plantel->idniveleducativo,
            'planteles' => $this->session->planteles
        );
        $this->session->set_userdata($data_session); 
        $this->session->set_flashdata('informacion_exito', 'Usuario o Contraseña son incorrectos.');
        redirect('/Admin');
    }

    public function cambiarplantel($idplantel,$idprofesor) {
        $detalle_plantel = $this->usuario->detallePlantel($idplantel);
        $data_session = array(
            'user_id' => $this->session->user_id,
            'idprofesor' => $idprofesor,
            'nombre' => $this->session->nombre,
            'apellidop' => $this->session->apellidop,
            'apellidom' => $this->session->apellidom,
            'idplantel' => $idplantel,
            'idtipousuario'=>$this->session->idtipousuario,
            'nivel_educativo' => $detalle_plantel->nombreniveleducativo,
             'idniveleducativo' => $detalle_plantel->idniveleducativo,
            'planteles' => $this->session->planteles
        );
        $this->session->set_userdata($data_session); 
        $this->session->set_flashdata('informacion_exito', 'Usuario o Contraseña son incorrectos.');
        redirect('/Profesores');
    }
    public function cambiarplantelTutor($idplantel,$idtutor) {
        $detalle_plantel = $this->usuario->detallePlantel($idplantel);
        $data_session = array(
            'user_id' => $this->session->user_id,
            'idtutor' => $idtutor,
            'nombre' => $this->session->nombre,
            'apellidop' => $this->session->apellidop,
            'apellidom' => $this->session->apellidom,
            'idplantel' => $idplantel,
            'idtipousuario'=>$this->session->idtipousuario,
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
        $date = date ("H"); 

        if($date < 12) { 
        $mjs = "Buenos Días!";
        }
        else if ($date < 18){ 
        $mjs = "Buenas Tardes!";
        }
        else {
         
        $mjs = "Buenas Noches!";
        }
        return $mjs;
    }
}
