<?php

defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("America/Mexico_City");

class Subir extends CI_Controller {

    function __construct() {
        parent::__construct();
        if (!isset($_SESSION['user_id'])) {
            $this->session->set_flashdata('flash_data', 'You don\'t have access! ss');
            return redirect('welcome');
        }
        $this->load->helper('url');
        $this->load->model('alumno_model', 'alumno');
        $this->load->model('user_model', 'user');
        $this->load->model('tutor_model', 'tutor');
        $this->load->model('data_model');
        $this->load->library('permission');
        $this->load->library('session');
        $this->load->library('pdfgenerator');
        $this->load->helper('numeroatexto_helper');
        $this->load->library('excel');
    }

    public function index() {
        $this->load->view('admin/header');
        $this->load->view('admin/subir/index');
        $this->load->view('admin/footer');
    }

    public function comparar() {

        $mi_archivo = 'mi_archivo';
        $config['upload_path'] = "archivos/";
        $config['file_name'] = 'Invetario ' . date("Y-m-d his");
        $config['allowed_types'] = "*";
        $config['max_size'] = "50000";
        $config['max_width'] = "2000";
        $config['max_height'] = "2000";

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload($mi_archivo)) {
            //*** ocurrio un error
            $data['uploadError'] = $this->upload->display_errors();
            echo $this->upload->display_errors();
            return;
        }

        $data['uploadSuccess'] = $this->upload->data();
        $ruta = $data['uploadSuccess']['full_path'];
        $inputFileName = $ruta;
        $objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
        $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
        $arrayCount = count($allDataInSheet);  // Here get total count of row in that Excel sheet
        $datos = array();
        for ($i = 2; $i <= $arrayCount; $i++) {
            $matricula = $allDataInSheet[$i]["A"];
            $alumno_apellidop = $allDataInSheet[$i]["B"];
            $alumno_apellidom = $allDataInSheet[$i]["C"];
            $alumno_nombre = $allDataInSheet[$i]["D"];


            //$direccion = $calle . ", " . $colonia . ", C.P. " . $cp . ", " . $municipio . ", " . $estado;
            $data = array(
                'idplantel' => 4,
                'idespecialidad' => 5,
                'matricula' => trim($matricula),
                'curp' => '',
                'nombre' => strtoupper($alumno_nombre),
                'apellidop' => strtoupper($alumno_apellidop),
                'apellidom' => strtoupper($alumno_apellidom),
                'lugarnacimiento' => 'NO DEFINIDO',
                'nacionalidad' => 'NO DEFINIDO',
                'domicilio' => 'NO DEFINIDO',
                'telefono' => 0,
                'telefonoemergencia' =>0,
                'serviciomedico' => 'NO DEFINIDO',
                'idtiposanguineo' =>1,
                'alergiaopadecimiento' => 'NO DEFINIDO',
                'peso' => 0.00,
                'estatura' => 0.00,
                'numfolio' => 'NO DEFINIDO',
                'numacta' => 'NO DEFINIDO',
                'numlibro' => 'NO DEFINIDO',
                'fechanacimiento' => date('Y-m-d'),
                'foto' => '',
                'sexo' => 1,
                'correo' => '',
                'password' => password_hash('admin', PASSWORD_DEFAULT),
                'idalumnoestatus' => 1,
                'idusuario' => $this->session->user_id,
                'fecharegistro' => date('Y-m-d H:i:s'),
            );
            // var_dump($data);

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
            

//         if(!$validar_add_madre){
//         $password_encrypted = password_hash(trim('admin'), PASSWORD_BCRYPT);
//        	$data_tutor_madre = array(
//                    'idplantel'=> 1,
//                    'nombre' => strtoupper($madre_nombre),
//                    'apellidop' => strtoupper($madre_apellidop),
//                    'apellidom' => strtoupper($madre_apellidom),
//                    'escolaridad' => strtoupper($madre_escolaridad),
//                    'ocupacion' => strtoupper($madre_ocupacion),
//                    'dondetrabaja' => strtoupper($madre_dondetrabaja),
//                    'fnacimiento' => date('Y-m-d'),
//                    'direccion' =>  strtoupper($direccion),
//                    'telefono' => 0,
//                    'correo' => '',
//                    'password' => $password_encrypted,
//                    'rfc' => '',
//                    'factura' => 0,
//                    'foto' => '',
//                    'idusuario' => $this->session->user_id,
//                    'fecharegistro' => date('Y-m-d H:i:s')
//                     
//                );
//        	  $idtutor = $this->tutor->addTutor($data_tutor_madre); 
//              $datausuario_tutor     = array(
//                'idusuario' => $idtutor,
//                'idtipousuario' => 5, 
//                'fecharegistro' => date('Y-m-d H:i:s')
//
//            );
//             $idusuario_tutor = $this->user->addUser($datausuario_tutor);
//               $data_usuario_rol_tutor = array(
//                 'id_rol'=>11,
//                 'id_user'=>$idusuario_tutor
//             );
//             $id_usuario_rol = $this->user->addUserRol($data_usuario_rol_tutor);
//               $data = array(
//                    'idtutor' => $idtutor,
//                    'idalumno' => $idalumno
//                     
//                );
//             $this->tutor->addTutorAlumno($data);
//            }else{
//                $idtutor = $validar_add_madre[0]->idtutor;
//                 $data = array(
//                    'idtutor' => $idtutor,
//                    'idalumno' => $idalumno
//                     
//                );
//             $this->tutor->addTutorAlumno($data);
//            }
        }
    }

//	public function comparar() {
//       
//            $mi_archivo = 'mi_archivo';
//            $config['upload_path'] = "archivos/";
//            $config['file_name'] = 'Invetario ' . date("Y-m-d his");
//            $config['allowed_types'] = "*";
//            $config['max_size'] = "50000";
//            $config['max_width'] = "2000";
//            $config['max_height'] = "2000";
//
//            $this->load->library('upload', $config);
//
//            if (!$this->upload->do_upload($mi_archivo)) {
//                //*** ocurrio un error
//                $data['uploadError'] = $this->upload->display_errors();
//                echo $this->upload->display_errors();
//                return;
//            }
//
//            $data['uploadSuccess'] = $this->upload->data();
//            $ruta = $data['uploadSuccess']['full_path'];
//            $inputFileName = $ruta;
//            $objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
//            $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
//            $arrayCount = count($allDataInSheet);  // Here get total count of row in that Excel sheet
//            $datos = array();
//            for ($i = 2; $i <= $arrayCount; $i++) {
//                $matricula = $allDataInSheet[$i]["A"];
//                $alumno_apellidop = $allDataInSheet[$i]["B"];
//                $alumno_apellidom = $allDataInSheet[$i]["C"];
//                $alumno_nombre = $allDataInSheet[$i]["D"];
//                $fechanacimiento = $allDataInSheet[$i]["E"];
//                $curp = $allDataInSheet[$i]["F"];
//                $lugarnacimiento = $allDataInSheet[$i]["G"];
//                $nacionalidad = $allDataInSheet[$i]["H"];
//                $domicilio = $allDataInSheet[$i]["I"]; 
//                $cp = $allDataInSheet[$i]["J"]; 
//                $ciudad = $allDataInSheet[$i]["K"]; 
//                $telefono = $allDataInSheet[$i]["L"]; 
//                $telefonoemergencia = $allDataInSheet[$i]["M"]; 
//                $serviciomedico = $allDataInSheet[$i]["N"]; 
//                $tiposanguineo = $allDataInSheet[$i]["O"]; 
//                $alergiaopadecimiento = $allDataInSheet[$i]["P"]; 
//                $peso = $allDataInSheet[$i]["Q"]; 
//                $estatura = $allDataInSheet[$i]["R"]; 
//                $numerofolio = $allDataInSheet[$i]["S"]; 
//                $numeroacta = $allDataInSheet[$i]["T"]; 
//                $numerolibro = $allDataInSheet[$i]["U"];
//                $padre_apellidop = $allDataInSheet[$i]["V"]; 
//                $padre_apellidom = $allDataInSheet[$i]["W"]; 
//                $padre_nombre = $allDataInSheet[$i]["X"]; 
//                $padre_escolaridad = $allDataInSheet[$i]["Y"]; 
//                $padre_ocupacion = $allDataInSheet[$i]["Z"]; 
//                $padre_dondetrabaja = $allDataInSheet[$i]["AA"]; 
//                $madre_apellidop = $allDataInSheet[$i]["AB"]; 
//                $madre_apellidom = $allDataInSheet[$i]["AC"]; 
//                $madre_nombre = $allDataInSheet[$i]["AD"]; 
//                $madre_escolaridad = $allDataInSheet[$i]["AE"]; 
//                $madre_ocupacion = $allDataInSheet[$i]["AF"]; 
//                $madre_dondetrabaja = $allDataInSheet[$i]["AG"]; 
//
//                 $especialidad = $allDataInSheet[$i]["AH"]; 
//                $matricula = $allDataInSheet[$i]["AI"]; 
//                 $sexo = $allDataInSheet[$i]["AJ"]; 
//                $direccion = $domicilio." C.P. ".$cp." ".$ciudad;
//                	$data = array(
//                    'idplantel'=> 1,
//                    'idespecialidad'=>  trim($especialidad),
//                    'matricula' => trim($matricula),
//                    'curp' => strtoupper(trim($curp)),
//                    'nombre' => strtoupper($alumno_nombre),
//                    'apellidop' => strtoupper($alumno_apellidop),
//                    'apellidom' => strtoupper($alumno_apellidom),
//                    'lugarnacimiento' => strtoupper($lugarnacimiento),
//                    'nacionalidad' => strtoupper($nacionalidad),
//                    'domicilio' => strtoupper($direccion),
//                    'telefono' => strtoupper($telefono),
//                    'telefonoemergencia' => strtoupper($telefonoemergencia),
//                    'serviciomedico' => strtoupper($serviciomedico),
//                    'idtiposanguineo' => strtoupper($tiposanguineo),
//                    'alergiaopadecimiento' => strtoupper($alergiaopadecimiento),
//                    'peso' => strtoupper($peso),
//                    'estatura' => strtoupper($estatura),
//                    'numfolio' => strtoupper($numerofolio),
//                    'numacta' => strtoupper($numeroacta),
//                    'numlibro' => strtoupper($numerolibro),
//                    'fechanacimiento' => $fechanacimiento, 
//                    'foto' => '', 
//                    'sexo' => $sexo, 
//                    'correo' => '',
//                    'password' => password_hash('admin', PASSWORD_DEFAULT),
//                    'idalumnoestatus'=>1,
//                    'idusuario' => $this->session->user_id,
//                    'fecharegistro' => date('Y-m-d H:i:s'),
//                );
//               // var_dump($data);
//            
//             $idalumno =  $this->alumno->addAlumno($data); 
//                $datausuario     = array(
//                    'idusuario' => $idalumno,
//                    'idtipousuario' => 3, 
//                    'fecharegistro' => date('Y-m-d H:i:s')
//
//                );
//             $idusuario = $this->user->addUser($datausuario);
//             $data_usuario_rol = array(
//                 'id_rol'=>12,
//                 'id_user'=>$idusuario
//             );
//             $id_usuario_rol = $this->user->addUserRol($data_usuario_rol);
//             $validar = $this->alumno->buscarAlumno(trim($matricula));
//             //var_dump($validar);
//             //$idalumno = $validar[0]->idalumno;
//             $validar_add_padre = $this->tutor->validadAddTutor(1,trim($padre_nombre),trim($padre_apellidop),trim($padre_apellidom));
//              $validar_add_madre = $this->tutor->validadAddTutor(1,trim($madre_nombre),trim($madre_apellidop),trim($madre_apellidom));
//             if(!$validar_add_padre){
//         $password_encrypted = password_hash(trim('admin'), PASSWORD_BCRYPT);
//        	$data_tutor = array(
//                    'idplantel'=> 1,
//                    'nombre' => strtoupper($padre_nombre),
//                    'apellidop' => strtoupper($padre_apellidop),
//                    'apellidom' => strtoupper($padre_apellidom),
//                    'escolaridad' => strtoupper($padre_escolaridad),
//                    'ocupacion' => strtoupper($padre_ocupacion),
//                    'dondetrabaja' => strtoupper($padre_dondetrabaja),
//                    'fnacimiento' => date('Y-m-d'),
//                    'direccion' =>  strtoupper($direccion),
//                    'telefono' => 0,
//                    'correo' => '',
//                    'password' => $password_encrypted,
//                    'rfc' => '',
//                    'factura' => 0,
//                    'foto' => '',
//                    'idusuario' => $this->session->user_id,
//                    'fecharegistro' => date('Y-m-d H:i:s')
//                     
//                );
//        	  $idtutor_padre = $this->tutor->addTutor($data_tutor); 
//              $datausuario_tutor     = array(
//                'idusuario' => $idtutor_padre,
//                'idtipousuario' => 5, 
//                'fecharegistro' => date('Y-m-d H:i:s')
//
//            );
//             $idusuario_tutor = $this->user->addUser($datausuario_tutor);
//               $data_usuario_rol_tutor = array(
//                 'id_rol'=>11,
//                 'id_user'=>$idusuario_tutor
//             );
//             $id_usuario_rol = $this->user->addUserRol($data_usuario_rol_tutor);
//               $data = array(
//                    'idtutor' => $idtutor_padre,
//                    'idalumno' => $idalumno
//                     
//                );
//             $this->tutor->addTutorAlumno($data);
//            }else{
//                $idtutor_padre = $validar_add_padre[0]->idtutor;
//                 $data = array(
//                    'idtutor' => $idtutor_padre,
//                    'idalumno' => $idalumno
//                     
//                );
//             $this->tutor->addTutorAlumno($data);
//            }
//
//         if(!$validar_add_madre){
//         $password_encrypted = password_hash(trim('admin'), PASSWORD_BCRYPT);
//        	$data_tutor_madre = array(
//                    'idplantel'=> 1,
//                    'nombre' => strtoupper($madre_nombre),
//                    'apellidop' => strtoupper($madre_apellidop),
//                    'apellidom' => strtoupper($madre_apellidom),
//                    'escolaridad' => strtoupper($madre_escolaridad),
//                    'ocupacion' => strtoupper($madre_ocupacion),
//                    'dondetrabaja' => strtoupper($madre_dondetrabaja),
//                    'fnacimiento' => date('Y-m-d'),
//                    'direccion' =>  strtoupper($direccion),
//                    'telefono' => 0,
//                    'correo' => '',
//                    'password' => $password_encrypted,
//                    'rfc' => '',
//                    'factura' => 0,
//                    'foto' => '',
//                    'idusuario' => $this->session->user_id,
//                    'fecharegistro' => date('Y-m-d H:i:s')
//                     
//                );
//        	  $idtutor = $this->tutor->addTutor($data_tutor_madre); 
//              $datausuario_tutor     = array(
//                'idusuario' => $idtutor,
//                'idtipousuario' => 5, 
//                'fecharegistro' => date('Y-m-d H:i:s')
//
//            );
//             $idusuario_tutor = $this->user->addUser($datausuario_tutor);
//               $data_usuario_rol_tutor = array(
//                 'id_rol'=>11,
//                 'id_user'=>$idusuario_tutor
//             );
//             $id_usuario_rol = $this->user->addUserRol($data_usuario_rol_tutor);
//               $data = array(
//                    'idtutor' => $idtutor,
//                    'idalumno' => $idalumno
//                     
//                );
//             $this->tutor->addTutorAlumno($data);
//            }else{
//                $idtutor = $validar_add_madre[0]->idtutor;
//                 $data = array(
//                    'idtutor' => $idtutor,
//                    'idalumno' => $idalumno
//                     
//                );
//             $this->tutor->addTutorAlumno($data);
//            }
//
//            } 
//    }
}