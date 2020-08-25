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
    }

    public function index() {
        $data = array();
        $this->load->view('docente/header');
        $this->load->view('docente/tarea/index', $data);
        $this->load->view('docente/footer');
    }
    public function showAll() {
          $query = $this->tarea->showAll( $this->session->user_id);
        //var_dump($query);
        if ($query) {
            $result['tareas'] = $this->tarea->showAll( $this->session->user_id);
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }
        public function searchTarea() {
             $value = $this->input->post('text');
          $query = $this->tarea->searchTareas($value, $this->session->user_id);
        //var_dump($query);
        if ($query) {
            $result['tareas'] = $this->tarea->searchTareas($value, $this->session->user_id);
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
    public function showAllAlumnosTarea() {
        $idtarea = $this->input->get('id');
        $idhorario = $this->input->get('idhorario');
        $idmateria = $this->input->get('idmateria');
        $idprofesormateria = $this->input->get('idprofesormateria');
        $query = $this->tarea->showAllAlumnosTarea($idhorario,$idprofesormateria,$idmateria,$idtarea);
         if ($query) {
            $result['alumnostareas'] = $this->tarea->showAllAlumnosTarea($idhorario,$idprofesormateria,$idmateria,$idtarea);
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
         $query = $this->tarea->searchAllAlumnosTarea($value,$idhorario,$idprofesormateria,$idmateria,$idtarea);
        if ($query) {
            $result['alumnostareas'] = $query;
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
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
                $file->setParents(array("1B4CoR3bBXuzZaX5UbA7_wXGBeAfqmzXT"));
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
                    'nombredocumento'=>$result->name,
                    'iddocumento'=>$result->id,
                    'fechaentrega' => $fechaentrega,
                    'horaentrega'=>$horaentrega,
                    'idnotificacionalumno' => 1,
                    'idnotificaciontutor' => 1,
                    'eliminado'=>0,
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
         }else{
             $data = array(
                    'idhorario' => $idhorario,
                    'idhorariodetalle' => $idhorariodetalle,
                    'titulo' => mb_strtoupper($titulo),
                    'tarea' => $tarea,
                    'nombredocumento'=>'',
                    'iddocumento'=>'',
                    'fechaentrega' => $fechaentrega,
                    'horaentrega'=>$horaentrega,
                    'idnotificacionalumno' => 1,
                    'idnotificaciontutor' => 1,
                    'eliminado'=>0,
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
                    $user_img_profile = date("Y-m-dhis") . '.' . $extension_img;
                    $config['file_name'] = $user_img_profile;

//instacia de archivo
                    $file = new Google_Service_Drive_DriveFile();
                    $file->setName($user_img_profile);

//obtenemos el mime type
                    $finfo = finfo_open(FILEINFO_MIME_TYPE);
                    $mime_type = finfo_file($finfo, $archivoParaSubir["tmp_name"]);

//id de la carpeta donde hemos dado el permiso a la cuenta de servicio 
                    $file->setParents(array("1B4CoR3bBXuzZaX5UbA7_wXGBeAfqmzXT"));
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
            'eliminado' => 0
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
            $file->setParents(array("1B4CoR3bBXuzZaX5UbA7_wXGBeAfqmzXT"));
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

}
