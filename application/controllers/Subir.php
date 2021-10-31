<?php

defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("America/Mexico_City");

class Subir extends CI_Controller
{

    function __construct()
    {
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
    public function password()
    {
        $alumnos = $this->alumno->showAll(1);
        foreach ($alumnos as $value) {
            $idalumno = $value->idalumno;
            $data = array(
                'password' => password_hash('28duguer', PASSWORD_DEFAULT)
            );
            $this->alumno->updateAlumno($idalumno, $data);
        }
    }
    public function index()
    {
        $this->load->view('admin/header');
        $this->load->view('admin/subir/index');
        $this->load->view('admin/footer');
    }
    public function separar()
    {
        $nombre = "JOSE PRUDENCIO VELASCO ";
        $var = $this->getNombreSplit($nombre);
        var_dump($var);
    }
    public  function getNombreSplit($nombreCompleto, $apellido_primero = false)
    {
        $chunks = ($apellido_primero)
            ? explode(" ", strtoupper($nombreCompleto))
            : array_reverse(explode(" ", strtoupper($nombreCompleto)));
        $exceptions = ["DE", "LA", "DEL", "LOS", "SAN", "SANTA"];
        $existen = array_intersect($chunks, $exceptions);
        $nombre = array("Materno" => "", "Paterno" => "", "Nombres" => "");
        $agregar_en = ($apellido_primero)
            ? "paterno"
            : "materno";
        $primera_vez = true;
        if ($apellido_primero) {
            if (!empty($existen)) {
                foreach ($chunks as $chunk) {
                    if ($primera_vez) {
                        $nombre["Paterno"] = $nombre["Paterno"] . " " . $chunk;
                        $primera_vez = false;
                    } else {
                        if (in_array($chunk, $exceptions)) {
                            if ($agregar_en == "paterno")
                                $nombre["Paterno"] = $nombre["Paterno"] . " " . $chunk;
                            elseif ($agregar_en == "materno")
                                $nombre["Materno"] = $nombre["Materno"] . " " . $chunk;
                            else
                                $nombre["Nombres"] = $nombre["Nombres"] . " " . $chunk;
                        } else {
                            if ($agregar_en == "paterno") {
                                $nombre["Paterno"] = $nombre["Paterno"] . " " . $chunk;
                                $agregar_en = "materno";
                            } elseif ($agregar_en == "materno") {
                                $nombre["Materno"] = $nombre["Materno"] . " " . $chunk;
                                $agregar_en = "nombres";
                            } else {
                                $nombre["Nombres"] = $nombre["Nombres"] . " " . $chunk;
                            }
                        }
                    }
                }
            } else {
                foreach ($chunks as $chunk) {
                    if ($primera_vez) {
                        $nombre["Paterno"] = $nombre["Paterno"] . " " . $chunk;
                        $primera_vez = false;
                    } else {
                        if (in_array($chunk, $exceptions)) {
                            if ($agregar_en == "paterno")
                                $nombre["Paterno"] = $nombre["Paterno"] . " " . $chunk;
                            elseif ($agregar_en == "materno")
                                $nombre["Materno"] = $nombre["Materno"] . " " . $chunk;
                            else
                                $nombre["Nombres"] = $nombre["Nombres"] . " " . $chunk;
                        } else {
                            if ($agregar_en == "paterno") {
                                $nombre["Materno"] = $nombre["Materno"] . " " . $chunk;
                                $agregar_en = "materno";
                            } elseif ($agregar_en == "materno") {
                                $nombre["Nombres"] = $nombre["Nombres"] . " " . $chunk;
                                $agregar_en = "nombres";
                            } else {
                                $nombre["Nombres"] = $nombre["Nombres"] . " " . $chunk;
                            }
                        }
                    }
                }
            }
        } else {
            foreach ($chunks as $chunk) {
                if ($primera_vez) {
                    $nombre["Materno"] = $chunk . " " . $nombre["Materno"];
                    $primera_vez = false;
                } else {
                    if (in_array($chunk, $exceptions)) {
                        if ($agregar_en == "materno")
                            $nombre["Materno"] = $chunk . " " . $nombre["Materno"];
                        elseif ($agregar_en == "paterno")
                            $nombre["Paterno"] = $chunk . " " . $nombre["Paterno"];
                        else
                            $nombre["Nombres"] = $chunk . " " . $nombre["Nombres"];
                    } else {
                        if ($agregar_en == "materno") {
                            $agregar_en = "paterno";
                            $nombre["Paterno"] = $chunk . " " . $nombre["Paterno"];
                        } elseif ($agregar_en == "paterno") {
                            $agregar_en = "nombres";
                            $nombre["Nombres"] = $chunk . " " . $nombre["Nombres"];
                        } else {
                            $nombre["Nombres"] = $chunk . " " . $nombre["Nombres"];
                        }
                    }
                }
            }
        }
        // LIMPIEZA DE ESPACIOS
        $nombre["Materno"] = trim($nombre["Materno"]);
        $nombre["Paterno"] = trim($nombre["Paterno"]);
        $nombre["Nombres"] = trim($nombre["Nombres"]);
        return $nombre;
    }

    public function comparar()
    {

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
            $fechanacimiento = $allDataInSheet[$i]["E"];
            $genero = $allDataInSheet[$i]["F"];
            //$apellidop = $allDataInSheet[$i]["G"];
            //$apellidom = $allDataInSheet[$i]["H"];
            $nombre_in = $allDataInSheet[$i]["I"];
            $calle = $allDataInSheet[$i]["J"];
            $calonia = $allDataInSheet[$i]["K"];
            $cp = $allDataInSheet[$i]["L"];
            $municipio = $allDataInSheet[$i]["M"];
            $estado = $allDataInSheet[$i]["N"];
            $correo = $allDataInSheet[$i]["O"];
            $telefono = $allDataInSheet[$i]["P"];
            $curp = $allDataInSheet[$i]["Q"];
            $tiposangre = $allDataInSheet[$i]["R"];
            $idplantel = $allDataInSheet[$i]["S"];
            $idespecialidad = $allDataInSheet[$i]["T"];
            $apellidop = "";
            $apellidom = "";
            $nombre = "";
            $separar = $this->getNombreSplit($nombre_in);
            if (isset($separar) && !empty($separar)) {
                $nombre = $separar["Nombres"];
                $apellidop = $separar["Paterno"];
                $apellidom = $separar["Materno"];
            }

            $direccion = $calle . ", " . $calonia . ", C.P. " . $cp . ", " . $municipio . ", " . $estado;
            $validar = $this->tutor->validadMatriculaPorNivel($matricula, $idplantel);
            if ($validar == false) {
                $data = array(
                    'idplantel' => $idplantel,
                    'idespecialidad' => $idespecialidad,
                    'matricula' => trim($matricula),
                    'curp' => '',
                    'nombre' => strtoupper($alumno_nombre),
                    'apellidop' => strtoupper($alumno_apellidop),
                    'apellidom' => strtoupper($alumno_apellidom),
                    'lugarnacimiento' => '',
                    'nacionalidad' => '',
                    'domicilio' => $direccion,
                    'telefono' => 0,
                    'telefonoemergencia' => 0,
                    'serviciomedico' => '',
                    'idtiposanguineo' => $tiposangre,
                    'alergiaopadecimiento' => '',
                    'peso' => 0.00,
                    'estatura' => 0.00,
                    'numfolio' => '',
                    'numacta' => '',
                    'numlibro' => '',
                    'fechanacimiento' => $fechanacimiento,
                    'foto' => '',
                    'sexo' => $genero,
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

                $validar_add_madre = $this->tutor->validadAddTutor($idplantel, trim($nombre), trim($apellidop), trim($apellidom));
                if ($validar_add_madre == false) {
                    $password_encrypted = password_hash(trim('admin'), PASSWORD_BCRYPT);
                    $data_tutor_madre = array(
                        'idplantel' => $idplantel,
                        'nombre' => strtoupper($nombre),
                        'apellidop' => strtoupper($apellidop),
                        'apellidom' => strtoupper($apellidom),
                        'escolaridad' => '',
                        'ocupacion' => '',
                        'dondetrabaja' => '',
                        'fnacimiento' => date('Y-m-d'),
                        'direccion' => strtoupper($direccion),
                        'telefono' => $telefono,
                        'correo' => $correo,
                        'password' => $password_encrypted,
                        'rfc' => '',
                        'factura' => 0,
                        'foto' => '',
                        'idusuario' => $this->session->user_id,
                        'fecharegistro' => date('Y-m-d H:i:s')
                    );
                    $idtutor = $this->tutor->addTutor($data_tutor_madre);
                    $datausuario_tutor = array(
                        'idusuario' => $idtutor,
                        'idtipousuario' => 5,
                        'fecharegistro' => date('Y-m-d H:i:s')
                    );
                    $idusuario_tutor = $this->user->addUser($datausuario_tutor);
                    $data_usuario_rol_tutor = array(
                        'id_rol' => 11,
                        'id_user' => $idusuario_tutor
                    );
                    $id_usuario_rol = $this->user->addUserRol($data_usuario_rol_tutor);
                    $data = array(
                        'idtutor' => $idtutor,
                        'idalumno' => $idalumno
                    );
                    $this->tutor->addTutorAlumno($data);
                    echo "<br>" . $matricula;
                } else {
                    //var_dump($validar);

                    // echo $validar[0]->matricula;
                    $idtutor = $validar_add_madre[0]->idtutor;
                    $data = array(
                        'idtutor' => $idtutor,
                        'idalumno' => $idalumno
                    );
                    $this->tutor->addTutorAlumno($data);
                }
                echo "<br>" . $matricula;
            }
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
