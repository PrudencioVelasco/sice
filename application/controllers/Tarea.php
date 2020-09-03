<?php

defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("America/Mexico_City");
header("Access-Control-Allow-Origin: *");

class Tarea extends CI_Controller {

    function __construct() {
        parent::__construct();

        /* if (!isset($_SESSION['user_id'])) {
          $this->session->set_flashdata('flash_data', 'You don\'t have access! ss');
          return redirect('welcome');
          }
          $this->load->model('alumno_model', 'alumno');
          $this->load->helper('url');
          $this->load->model('data_model');
          $this->load->library('permission');
          $this->load->library('session'); */
        $this->load->model('tarea_model', 'tarea');
        $this->load->library('Autoload');
        $this->load->library('encryption');
        $this->carpeta_primaria = "1pXEzNEKkle_1goqm5N2Pxyak9fGGdAe3";
        $this->carpeta_secundaria= "1DONgwm3SMr6b-3zOcxQpGO5uUfiCGG6k";
        $this->carpeta_bachillerato= "1fcRPw3xIefTfCE1nmPqxi6G7mFNhiT-m";
        $this->carpeta_preescolar= "1jv5UT5WHznaZ5bwHs4wgM9ju_nKDOJOg";
        $this->carpeta_licenciatura_primaria= "1FXIZVLCsc1zUtAN4k8l-JeT32whj9hgD";
        $this->carpeta_licenciatura_preescolar= "1xRmuoTSKhOljzppjsWIblp64pLwuJL-O";
    }
            

    public function showAll() {
        $idhorariodetalle = $this->input->get('idhorariodetalle');
        $query = $this->tarea->showAll($this->session->user_id, $idhorariodetalle);
        //var_dump($query);
        if ($query) {
            $result['tareas'] = $this->tarea->showAll($this->session->user_id, $idhorariodetalle);
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function searchTarea() {
        $value = $this->input->post('text');
        $idhorariodetalle = $this->input->get('idhorariodetalle');
        $query = $this->tarea->searchTareas($value, $this->session->user_id, $idhorariodetalle);
        //var_dump($query);
        if ($query) {
            $result['tareas'] = $this->tarea->searchTareas($value, $this->session->user_id, $idhorariodetalle);
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function showAllEstatusTarea() {
        $query = $this->tarea->showAllEstatusTarea();
        //var_dump($query);
        if ($query) {
            $result['estatustarea'] = $this->tarea->showAllEstatusTarea();
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function showDetalleTarea() {
        $idtarea = $this->input->get('idtarea');
        $query = $this->tarea->detalleTareaAlumno($idtarea);
        //var_dump($query);
        if ($query) {
            $result['tarea'] = $this->tarea->detalleTareaAlumno($idtarea);
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function showdetalleRespuestaTareaAlumno() {
        $idtarea = $this->input->get('idtarea');
        $idalumno = $this->session->idalumno;
        $query = $this->tarea->detalleRespuestaTareaAlumno($idtarea, $idalumno);
        //var_dump($query);
        if ($query) {
            $result['contestado'] = $this->tarea->detalleRespuestaTareaAlumno($idtarea, $idalumno);
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function showAllAlumnosTarea() {
        $idtarea = $this->input->get('id');
        $idhorario = $this->input->get('idhorario');
        $idmateria = $this->input->get('idmateria');
        $idprofesormateria = $this->input->get('idprofesormateria');
        $query = $this->tarea->showAllAlumnosTarea($idhorario, $idprofesormateria, $idmateria, $idtarea);
        if ($query) {
            $result['alumnostareas'] = $this->tarea->showAllAlumnosTarea($idhorario, $idprofesormateria, $idmateria, $idtarea);
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function searchTareasAlumno() {
        $value = $this->input->post('text');
        $idhorario = $this->decode($this->input->get('idhorario'));
        $idalumno = $this->decode($this->input->get('idalumno'));
        if (isset($idhorario) && !empty($idhorario)) {
            $query = $this->tarea->searchTareasAlumnoMateria($value, $idhorario,$idalumno);
            if ($query) {
                $result['tareas'] = $this->tarea->searchTareasAlumnoMateria($value, $idhorario,$idalumno);
            }
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function searchAllAlumnosTarea() {
        //Permission::grant(uri_string());
        $value = $this->input->post('text');
        $idtarea = $this->input->get('id');
        $idhorario = $this->input->get('idhorario');
        $idmateria = $this->input->get('idmateria');
        $idprofesormateria = $this->input->get('idprofesormateria');
        $query = $this->tarea->searchAllAlumnosTarea($value, $idhorario, $idprofesormateria, $idmateria, $idtarea);
        if ($query) {
            $result['alumnostareas'] = $query;
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function obtenerCarpeta($idplantel) {
        $carpeta = "";
        switch ($idplantel) {
            case 1:
                $carpeta .= $this->carpeta_primaria;
                break;
            case 3:
                $carpeta .= $this->carpeta_secundaria;
                break;
            case 4:
                $carpeta .= $this->carpeta_bachillerato;
                break;
            case 5:
                $carpeta .= $this->carpeta_preescolar;
                break;
             case 7:
                $carpeta .= $this->carpeta_licenciatura_primaria;
                break;
             case 8:
                $carpeta .= $this->carpeta_licenciatura_preescolar;
                break;

            default:
                break;
        }
        return $carpeta;
    }

    public function addTarea() {
        $config = array(
            array(
                'field' => 'titulo',
                'label' => 'Titulo de la tarea',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),
            array(
                'field' => 'tarea',
                'label' => 'Redactar tarea',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),
            array(
                'field' => 'fechaentrega',
                'label' => 'Feha limite de entrega',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ), array(
                'field' => 'horaentrega',
                'label' => 'Hora limite de entrega',
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
                'titulo' => form_error('titulo'),
                'tarea' => form_error('tarea'),
                'fechaentrega' => form_error('fechaentrega'),
                'horaentrega' => form_error('horaentrega')
            );
        } else {
            $idhorario = trim($this->input->post('idhorario'));
            $idhorariodetalle = trim($this->input->post('idhorariodetalle'));
            $titulo = trim($this->input->post('titulo'));
            $tarea = trim($this->input->post('tarea'));
            $fechaentrega = trim($this->input->post('fechaentrega'));
            $horaentrega = trim($this->input->post('horaentrega'));
            if (isset($_FILES["file"]) && !empty($_FILES["file"])) {
                $this->load->library('Autoload');
                $archivoParaSubir = $_FILES["file"];
                $maxsize = 1000000;
                $allowed = array('gif', 'png', 'jpg', 'jpeg', 'gif', 'docx', 'doc', 'pdf', 'xls', 'xlsx');
                $filename = $_FILES['file']['name'];
                $ext = pathinfo($filename, PATHINFO_EXTENSION);
                if (in_array($ext, $allowed)) {
                    if (($_FILES['file']['size'] <= $maxsize)) {
                        //$tituloDeDoc = "TEST";
                        //$tituloDeDocPartes = explode(".", $tituloDeDoc);
                        //array_pop($tituloDeDocPartes);
                        //$tituloDeDoc = implode(".", $tituloDeDocPartes);
                        //include_once '../vendor/autoload.php';
//configurar variable de entorno
                        putenv('GOOGLE_APPLICATION_CREDENTIALS=credencial.json');

                        $client = new Google_Client();
                        $client->useApplicationDefaultCredentials();
                        $client->addScope(Google_Service_Drive::DRIVE);
                        $client->setScopes(['https://www.googleapis.com/auth/drive.file']);
                        try {
//instanciamos el servicio
                            $service = new Google_Service_Drive($client);

                            $info = new finfo(FILEINFO_MIME);
                            $tipoDeDoc = $info->file($archivoParaSubir["tmp_name"]);
// $mimeType = explode(";", $tipoDeDoc)[0]; 
                            $contenido = file_get_contents($archivoParaSubir["tmp_name"]);
//ruta al archivo
                            $file_name = $_FILES['file']['name'];
                            $tmp = explode('.', $file_name);
                            $extension_img = end($tmp);
                            $user_img_profile = date("Y-m-dhis") . '.' . $extension_img;
                            $config['file_name'] = $user_img_profile;

//instacia de archivo
                            $file = new Google_Service_Drive_DriveFile();
                            $file->setName($user_img_profile);

//obtenemos el mime type
                            $finfo = finfo_open(FILEINFO_MIME_TYPE);
                            $mime_type = finfo_file($finfo, $archivoParaSubir["tmp_name"]);

//id de la carpeta donde hemos dado el permiso a la cuenta de servicio 
                            $nombre_carpeta = $this->obtenerCarpeta($this->session->idplantel);
                            $file->setParents(array($nombre_carpeta));
                            $file->setDescription('archivo subido desde php');
                            $file->setMimeType($mime_type);

                            $result = $service->files->create(
                                    $file,
                                    array(
                                        'data' => $contenido,
                                        'mimeType' => $mime_type,
                                        'uploadType' => 'media',
                                    )
                            );

                            $data = array(
                                'idhorario' => $idhorario,
                                'idhorariodetalle' => $idhorariodetalle,
                                'titulo' => mb_strtoupper($titulo),
                                'tarea' => $tarea,
                                'nombredocumento' => $result->name,
                                'iddocumento' => $result->id,
                                'fechaentrega' => $fechaentrega,
                                'horaentrega' => $horaentrega,
                                'idnotificacionalumno' => 1,
                                'idnotificaciontutor' => 1,
                                'eliminado' => 0,
                                'idusuario' => $this->session->user_id,
                                'fecharegistro' => date('Y-m-d H:i:s'),
                            );
                            $value = $this->tarea->addTarea($data);
                            // echo '<a href="https://drive.google.com/open?id=' . $result->id . '" target="_blank">' . $result->name . '</a>';
                        } catch (Google_Service_Exception $gs) {

                            $m = json_decode($gs->getMessage());
                            //echo $m->error->message;
                            $result['error'] = true;
                            $result['msg'] = array(
                                'msgerror' => $m->error->message
                            );
                        } catch (Exception $e) {
                            //echo $e->getMessage();
                            $result['error'] = true;
                            $result['msg'] = array(
                                'msgerror' => $e->getMessage()
                            );
                        }
                    } else {
                        $result['error'] = true;
                        $result['msg'] = array(
                            'msgerror' => "EL DOCUMENTO DEBE DE PESAR 1MB COMO MAXIMO."
                        );
                    }
                } else {
                    $result['error'] = true;
                    $result['msg'] = array(
                        'msgerror' => "SOLO ES PERMITDO IMAGENES, WORD, PDF Y EXCEL."
                    );
                }
            } else {
                $data = array(
                    'idhorario' => $idhorario,
                    'idhorariodetalle' => $idhorariodetalle,
                    'titulo' => mb_strtoupper($titulo),
                    'tarea' => $tarea,
                    'nombredocumento' => '',
                    'iddocumento' => '',
                    'fechaentrega' => $fechaentrega,
                    'horaentrega' => $horaentrega,
                    'idnotificacionalumno' => 1,
                    'idnotificaciontutor' => 1,
                    'eliminado' => 0,
                    'idusuario' => $this->session->user_id,
                    'fecharegistro' => date('Y-m-d H:i:s'),
                );
                $value = $this->tarea->addTarea($data);
            }
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function updateTarea() {
        $config = array(
            array(
                'field' => 'titulo',
                'label' => 'Titulo de la tarea',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),
            array(
                'field' => 'tarea',
                'label' => 'Redactar tarea',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),
            array(
                'field' => 'fechaentregareal',
                'label' => 'Feha limite de entrega',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ), array(
                'field' => 'horaentregareal',
                'label' => 'Hora limite de entrega',
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
                'titulo' => form_error('titulo'),
                'tarea' => form_error('tarea'),
                'fechaentrega' => form_error('fechaentregareal'),
                'horaentrega' => form_error('horaentregareal')
            );
        } else {
            $idtarea = trim($this->input->post('idtarea'));
            $titulo = trim($this->input->post('titulo'));
            $tarea = trim($this->input->post('tarea'));
            $fechaentrega = trim($this->input->post('fechaentregareal'));
            $horaentrega = trim($this->input->post('horaentregareal'));
            if (isset($_FILES["file"]) && !empty($_FILES["file"])) {

                $maxsize = 1000000;
                $allowed = array('gif', 'png', 'jpg', 'jpeg', 'gif', 'docx', 'doc', 'pdf', 'xls', 'xlsx');
                $filename = $_FILES['file']['name'];
                $ext = pathinfo($filename, PATHINFO_EXTENSION);
                if (in_array($ext, $allowed)) {
                    if (($_FILES['file']['size'] <= $maxsize)) {
                        //Cambiara el documento
                        $this->load->library('Autoload');
                        $archivoParaSubir = $_FILES["file"];
                        //$tituloDeDoc = "TEST";
                        //$tituloDeDocPartes = explode(".", $tituloDeDoc);
                        //array_pop($tituloDeDocPartes);
                        //$tituloDeDoc = implode(".", $tituloDeDocPartes);
                        //include_once '../vendor/autoload.php';
//configurar variable de entorno
                        putenv('GOOGLE_APPLICATION_CREDENTIALS=credencial.json');

                        $client = new Google_Client();
                        $client->useApplicationDefaultCredentials();
                        $client->addScope(Google_Service_Drive::DRIVE);
                        $client->setScopes(['https://www.googleapis.com/auth/drive.file']);
                        try {
//instanciamos el servicio
                            $service = new Google_Service_Drive($client);

                            $info = new finfo(FILEINFO_MIME);
                            $tipoDeDoc = $info->file($archivoParaSubir["tmp_name"]);
// $mimeType = explode(";", $tipoDeDoc)[0]; 
                            $contenido = file_get_contents($archivoParaSubir["tmp_name"]);
//ruta al archivo
                            $file_name = $_FILES['file']['name'];
                            $tmp = explode('.', $file_name);
                            $extension_img = end($tmp);
                            $user_img_profile = date("Y-m-dhis") . '.' . $extension_img;
                            $config['file_name'] = $user_img_profile;

//instacia de archivo
                            $file = new Google_Service_Drive_DriveFile();
                            $file->setName($user_img_profile);

//obtenemos el mime type
                            $finfo = finfo_open(FILEINFO_MIME_TYPE);
                            $mime_type = finfo_file($finfo, $archivoParaSubir["tmp_name"]);

//id de la carpeta donde hemos dado el permiso a la cuenta de servicio 
                             $nombre_carpeta = $this->obtenerCarpeta($this->session->idplantel);
                            $file->setParents(array($nombre_carpeta));
                            $file->setDescription('archivo subido desde php');
                            $file->setMimeType($mime_type);

                            $result = $service->files->create(
                                    $file,
                                    array(
                                        'data' => $contenido,
                                        'mimeType' => $mime_type,
                                        'uploadType' => 'media',
                                    )
                            );

                            $data = array(
                                //'idhorario' => $idhorario,
                                //'idhorariodetalle' => $idhorariodetalle,
                                'titulo' => mb_strtoupper($titulo),
                                'tarea' => $tarea,
                                'nombredocumento' => $result->name,
                                'iddocumento' => $result->id,
                                'fechaentrega' => $fechaentrega,
                                'horaentrega' => $horaentrega,
                                'idnotificacionalumno' => 1,
                                'idnotificaciontutor' => 1,
                                //'eliminado'=>0,
                                'idusuario' => $this->session->user_id,
                                'fecharegistro' => date('Y-m-d H:i:s'),
                            );
                            $value = $this->tarea->updateTarea($idtarea, $data);
                            // echo '<a href="https://drive.google.com/open?id=' . $result->id . '" target="_blank">' . $result->name . '</a>';
                        } catch (Google_Service_Exception $gs) {

                            $m = json_decode($gs->getMessage());
                            //echo $m->error->message;
                            $result['error'] = true;
                            $result['msg'] = array(
                                'msgerror' => $m->error->message
                            );
                        } catch (Exception $e) {
                            //echo $e->getMessage();
                            $result['error'] = true;
                            $result['msg'] = array(
                                'msgerror' => $e->getMessage()
                            );
                        }
                    } else {
                        $result['error'] = true;
                        $result['msg'] = array(
                            'msgerror' => "EL DOCUMENTO DEBE DE PESAR 1MB COMO MAXIMO."
                        );
                    }
                } else {
                    $result['error'] = true;
                    $result['msg'] = array(
                        'msgerror' => "SOLO ES PERMITDO IMAGENES, WORD, PDF Y EXCEL."
                    );
                }
            } else {


                $data = array(
                    'titulo' => mb_strtoupper($titulo),
                    'tarea' => $tarea,
                    'fechaentrega' => $fechaentrega,
                    'horaentrega' => $horaentrega,
                    'idnotificacionalumno' => 1,
                    'idnotificaciontutor' => 1,
                    'idusuario' => $this->session->user_id,
                    'fecharegistro' => date('Y-m-d H:i:s'),
                );
                $value = $this->tarea->updateTarea($idtarea, $data);
            }
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function deleteTarea() {
        $id = $this->input->get('id');
        $data = array(
            'eliminado' => 1
        );

        $query = $this->tarea->updateTarea($id, $data);
        if ($query) {
            $result['error'] = false;
        } else {
            $result['error'] = true;
            $result['msg'] = array(
                'msgerror' => 'No se puede Elimnar registro.'
            );
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function calificarTareaAlumno() {
        $config = array(
            array(
                'field' => 'idestatustarea',
                'label' => 'Id Estatus Tarea',
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
                'idestatustarea' => form_error('idestatustarea'),
            );
        } else {
            $iddetalletarea = trim($this->input->post('iddetalletarea'));
            $idestatustarea = trim($this->input->post('idestatustarea'));
            $data = array(
                'idestatustarea' => $idestatustarea
            );
            $this->tarea->updateDetalleTarea($iddetalletarea, $data);
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function contestar() {
        $this->load->library('Autoload');
        $archivoParaSubir = $_FILES["file"];
        //$tituloDeDoc = "TEST";
        //$tituloDeDocPartes = explode(".", $tituloDeDoc);
        //array_pop($tituloDeDocPartes);
        //$tituloDeDoc = implode(".", $tituloDeDocPartes);
        //include_once '../vendor/autoload.php';
//configurar variable de entorno
        putenv('GOOGLE_APPLICATION_CREDENTIALS=credencial.json');

        $client = new Google_Client();
        $client->useApplicationDefaultCredentials();
        $client->setScopes(['https://www.googleapis.com/auth/drive.file']);
        try {
//instanciamos el servicio
            $service = new Google_Service_Drive($client);

            $info = new finfo(FILEINFO_MIME);
            $tipoDeDoc = $info->file($archivoParaSubir["tmp_name"]);
// $mimeType = explode(";", $tipoDeDoc)[0]; 
            $contenido = file_get_contents($archivoParaSubir["tmp_name"]);
//ruta al archivo
            $file_name = $_FILES['file']['name'];
            $tmp = explode('.', $file_name);
            $extension_img = end($tmp);
            $user_img_profile = date("Y-m-dhis") . '.' . $extension_img;
            $config['file_name'] = $user_img_profile;

//instacia de archivo
            $file = new Google_Service_Drive_DriveFile();
            $file->setName($user_img_profile);

//obtenemos el mime type
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime_type = finfo_file($finfo, $archivoParaSubir["tmp_name"]);

//id de la carpeta donde hemos dado el permiso a la cuenta de servicio 
            $nombre_carpeta = $this->obtenerCarpeta($this->session->idplantel);
            $file->setParents(array($nombre_carpeta));
            $file->setDescription('archivo subido desde php');
            $file->setMimeType($mime_type);

            $result = $service->files->create(
                    $file,
                    array(
                        'data' => $contenido,
                        'mimeType' => $mime_type,
                        'uploadType' => 'media',
                    )
            );

            echo '<a href="https://drive.google.com/open?id=' . $result->id . '" target="_blank">' . $result->name . '</a>';
        } catch (Google_Service_Exception $gs) {

            $m = json_decode($gs->getMessage());
            //echo $m->error->message;
            $result['error'] = true;
            $result['msg'] = array(
                'msgerror' => $m->error->message
            );
        } catch (Exception $e) {
            //echo $e->getMessage();
            $result['error'] = true;
            $result['msg'] = array(
                'msgerror' => $e->getMessage()
            );
        }
    }

    public function showTareasAlumno() {
        $idhorario = $this->decode($this->input->get('idhorario'));
        $idalumno = $this->decode($this->input->get('idalumno'));
        if (isset($idhorario) && !empty($idhorario)) {
            $query = $this->tarea->showTareasAlumnoMateria($idhorario,$idalumno);
            if ($query) {
                $result['tareas'] = $this->tarea->showTareasAlumnoMateria($idhorario,$idalumno);
            }
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
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

    public function responderTareaAlumno() {
        $config = array(
            array(
                'field' => 'tarea',
                'label' => 'Redactar tarea',
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
                'tarea' => form_error('tarea')
            );
        } else {
            $idtarea = trim($this->input->post('idtarea'));
            $tarea = trim($this->input->post('tarea'));
            $detalle_tarea = $this->tarea->detalleTareaAlumno($idtarea);

            $horaentraga = $detalle_tarea->horaentrega;
            $fechaentrega = $detalle_tarea->fechaentregareal;
            $fecha_antes = $detalle_tarea->fechaantes;
            $fechaactual = date('Y-m-d H:i:s');

            if ($fechaactual <= $fecha_antes) {
                if (isset($_FILES["file"]) && !empty($_FILES["file"])) {
                    $maxsize = 1000000;
                    $allowed = array('gif', 'png', 'jpg', 'jpeg', 'gif', 'docx', 'doc', 'pdf', 'xls', 'xlsx');
                    $filename = $_FILES['file']['name'];
                    $ext = pathinfo($filename, PATHINFO_EXTENSION);
                    if (in_array($ext, $allowed)) {
                        if (($_FILES['file']['size'] <= $maxsize)) {
                            //Cambiara el documento
                            $this->load->library('Autoload');
                            $archivoParaSubir = $_FILES["file"];
                            //$tituloDeDoc = "TEST";
                            //$tituloDeDocPartes = explode(".", $tituloDeDoc);
                            //array_pop($tituloDeDocPartes);
                            //$tituloDeDoc = implode(".", $tituloDeDocPartes);
                            //include_once '../vendor/autoload.php';
//configurar variable de entorno
                            putenv('GOOGLE_APPLICATION_CREDENTIALS=credencial.json');

                            $client = new Google_Client();
                            $client->useApplicationDefaultCredentials();
                            $client->setScopes(['https://www.googleapis.com/auth/drive.file']);
                            try {
//instanciamos el servicio
                                $service = new Google_Service_Drive($client);

                                $info = new finfo(FILEINFO_MIME);
                                $tipoDeDoc = $info->file($archivoParaSubir["tmp_name"]);
// $mimeType = explode(";", $tipoDeDoc)[0]; 
                                $contenido = file_get_contents($archivoParaSubir["tmp_name"]);
//ruta al archivo
                                $file_name = $_FILES['file']['name'];
                                $tmp = explode('.', $file_name);
                                $extension_img = end($tmp);
                                $user_img_profile = date("Ymdhis") . '.' . $extension_img;
                                $config['file_name'] = $user_img_profile;

//instacia de archivo
                                $file = new Google_Service_Drive_DriveFile();
                                $file->setName($user_img_profile);

//obtenemos el mime type
                                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                                $mime_type = finfo_file($finfo, $archivoParaSubir["tmp_name"]);

//id de la carpeta donde hemos dado el permiso a la cuenta de servicio 
                                  $nombre_carpeta = $this->obtenerCarpeta($this->session->idplantel);
                               $file->setParents(array($nombre_carpeta));
                                $file->setDescription('archivo subido desde php');
                                $file->setMimeType($mime_type);

                                $result = $service->files->create(
                                        $file,
                                        array(
                                            'data' => $contenido,
                                            'mimeType' => $mime_type,
                                            'uploadType' => 'media',
                                        )
                                );

                                $data = array(
                                    'idtarea' => $idtarea,
                                    'idalumno' => $this->session->idalumno,
                                    'idestatustarea' => 1,
                                    'mensaje' => $tarea,
                                    'nombrearchivo' => $result->name,
                                    'iddocumento' => $result->id,
                                    'eliminado' => 0,
                                    'idusuario' => $this->session->user_id,
                                    'fecharegistro' => date('Y-m-d H:i:s'),
                                );
                                $value = $this->tarea->addDetalleTarea($data);
                                // echo '<a href="https://drive.google.com/open?id=' . $result->id . '" target="_blank">' . $result->name . '</a>';
                            } catch (Google_Service_Exception $gs) {

                                $m = json_decode($gs->getMessage());
                                //echo $m->error->message;
                                $result['error'] = true;
                                $result['msg'] = array(
                                    'msgerror' => $m->error->message
                                );
                            } catch (Exception $e) {
                                //echo $e->getMessage();
                                $result['error'] = true;
                                $result['msg'] = array(
                                    'msgerror' => $e->getMessage()
                                );
                            }
                        } else {
                            $result['error'] = true;
                            $result['msg'] = array(
                                'msgerror' => "EL DOCUMENTO DEBE DE PESAR 1MB COMO MAXIMO."
                            );
                        }
                    } else {
                        $result['error'] = true;
                        $result['msg'] = array(
                            'msgerror' => "SOLO ES PERMITDO IMAGENES, WORD, PDF Y EXCEL."
                        );
                    }
//            }else{
//                 $result['error'] = true;
//                    $result['msg'] = array(
//                        'msgerror' => "YA REBASÓ EL LIMITE DE ENTREGA."
//                    ); 
//            }
                } else {

                    $data = array(
                        'idtarea' => $idtarea,
                        'idalumno' => $this->session->idalumno,
                        'idestatustarea' => 1,
                        'mensaje' => $tarea,
                        'nombrearchivo' => '',
                        'iddocumento' => '',
                        'eliminado' => 0,
                        'idusuario' => $this->session->user_id,
                        'fecharegistro' => date('Y-m-d H:i:s'),
                    );
                    $value = $this->tarea->addDetalleTarea($data);
                }
            } else {
                $result['error'] = true;
                $result['msg'] = array(
                    'msgerror' => "YA REBASÓ EL LIMITE DE ENTREGA2."
                );
            }
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

}
