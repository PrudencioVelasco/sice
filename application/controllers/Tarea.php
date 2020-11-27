<?php

defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("America/Mexico_City");
header("Access-Control-Allow-Origin: *");
class Tarea extends CI_Controller
{

    function __construct()
    {
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
        $this->load->model('horario_model', 'horario');
        $this->load->library('Autoload');
        $this->load->library('encryption');
        $this->load->helper('numeroatexto_helper');
        $this->carpeta_primaria = "1JeYjL9zZKmT_D6GW6KynxbwMbfEwjrLV";
        $this->carpeta_secundaria = "1GEyJSWkV2B1LVkHRcC8w3xgBo7acRnwo";
        $this->carpeta_bachillerato = "1_1HsVHaxDcv1Vc_QhqNYccJqFaPSgQEi";
        $this->carpeta_preescolar = "1AfNpCIaNKVExssUsIVKC-FIQN612No6e";
        $this->carpeta_licenciatura_primaria = "1nkROqzdgF0pI41EyGEOTm1XrXCq-PYGo";
        $this->carpeta_licenciatura_preescolar = "1AHjkjzfqk9iTUG1la8uceWibNiVVNq25";
        $this->appkey = "xrj2o8w9rc8vv4v";
        $this->appsecret = "h2dpotger3jzj6v";
        $this->token = "c79HAsllhxMAAAAAAAAAAXUL93C-XCQ3da-PwoSQyO-c7st-LqeM4aS6Hhu9vY73";
    }


    public function showAll()
    {
        $idhorariodetalle = $this->input->get('idhorariodetalle');

        $query = $this->tarea->showAll($this->session->user_id, $idhorariodetalle);

        if ($query) {

            $result['tareas']  =   $this->tarea->showAll($this->session->user_id, $idhorariodetalle);
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }
    public function showAllTareasXAsignatura()
    {
        $idhorario = $this->decode($this->input->get('idhorario'));
        $idhorariodetalle = $this->input->get('idhorariodetalle');
        $idmateria = $this->input->get('idmateria');
        $idalumno = $this->session->idalumno;
        $query = $this->tarea->showTareasAlumnoXMateria($idhorario, $idalumno, $idmateria);
        if ($query) {
            $result['tareas'] = $this->tarea->showTareasAlumnoXMateria($idhorario, $idalumno, $idmateria);
        }

        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function searchTarea()
    {
        $config = array(
            array(
                'field' => 'fechainicio',
                'label' => 'Fecha Inicio',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Seleccione la Fecha.'
                )
            ),
            array(
                'field' => 'fechafin',
                'label' => 'Fecha Fin',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Seleccione la Fecha.'
                )
            ),

        );

        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            $result['error'] = true;
            $result['msg'] = array(
                'fechainicio' => form_error('fechainicio'),
                'fechafin' => form_error('fechafin')
            );
        } else {
            $value = $this->input->post('texto');
            $fechainicio = $this->input->post('fechainicio');
            $fechafin = $this->input->post('fechafin');
            $idhorariodetalle = $this->input->get('idhorariodetalle');
            $query = $this->tarea->searchTareas($value, $this->session->user_id, $idhorariodetalle, $fechainicio, $fechafin);
            // var_dump($query);
            if ($query) {
                $result['tareas'] = $this->tarea->searchTareas($value, $this->session->user_id, $idhorariodetalle, $fechainicio, $fechafin);
            }
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function showAllEstatusTarea()
    {
        $query = $this->tarea->showAllEstatusTarea();
        //var_dump($query);
        if ($query) {
            $result['estatustarea'] = $this->tarea->showAllEstatusTarea();
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function showDetalleTarea()
    {
        $idtarea = $this->input->get('idtarea');
        $query = $this->tarea->detalleTareaAlumno($idtarea);
        if ($query) {
            $result['tarea'] = $this->tarea->detalleTareaAlumno($idtarea);
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }
    public function documentosTareaProfesor()
    {
        $idtarea = $this->input->get('idtarea');
        $do = array();
        $usersList_array = array();
        $query = $this->tarea->documentosTareaProfesor($idtarea);
        if (isset($query) && !empty($query)) {
            foreach ($query as $row) {
                $do['iddocumento'] = $row->iddocumento;
                $do['nombredocumento'] = $row->nombredocumento;
                if (empty($row->iddocumento) && !empty($row->nombredocumento)) {
                    $app = new Kunnu\Dropbox\DropboxApp($this->appkey, $this->appsecret,  $this->token);
                    $dropbox = new Kunnu\Dropbox\Dropbox($app);
                    $temporaryLink = $dropbox->getTemporaryLink("/" . $row->nombredocumento);

                    //Get File Metadata
                    $file = $temporaryLink->getMetadata();

                    //Get Link
                    $temporaryLink->getLink();
                    $do['link'] = $temporaryLink->getLink();
                } else {
                    $do['link'] = "";
                }
                array_push($usersList_array, $do);
            }
        }

        if (isset($usersList_array) && !empty($usersList_array)) {

            echo json_encode($usersList_array, JSON_PRETTY_PRINT);
        }
    }
    public function showdetalleRespuestaTareaAlumnoTutor()
    {
        $idtarea = $this->input->get('idtarea');
        $idalumno = $this->input->get('idalumno');
        $query = $this->tarea->showAllTaresDetalleAlumno($idtarea, $idalumno);

        $usersList_array = array();
        $user_array = array();
        $note_array = array();
        if ($query) {
            foreach ($query as $row) {
                $user_array["iddetalletarea"] = $row->iddetalletarea;
                $user_array["idtarea"] = $row->idtarea;
                $user_array["idalumno"] = $row->idalumno;
                $user_array["nombre"] = $row->nombre;
                $user_array["apellidop"] = $row->apellidop;
                $user_array["apellidom"] = $row->apellidom;
                $user_array["iddocumento"] = $row->iddocumento;
                $user_array["mensaje"] = $row->mensaje;
                $user_array["fecharegistro"] = $row->fecharegistro;
                $user_array["calificacion"] = $row->calificacion;
                $user_array["observacionesdocente"] = $row->observacionesdocente;
                $user_array["documentos"] = array();
                $documentos = $this->tarea->obtenerDocumentosAlumno($row->iddetalletarea);
                if ($documentos) {
                    foreach ($documentos as $documento) {
                        $note_array["file"] = $documento->iddocumento;
                        $note_array["extension"] = $documento->extension;
                        if (empty($documento->iddocumento) && !empty($documento->nombredocumento)) {
                            $app = new Kunnu\Dropbox\DropboxApp($this->appkey, $this->appsecret, $this->token);
                            $dropbox = new Kunnu\Dropbox\Dropbox($app);
                            $temporaryLink = $dropbox->getTemporaryLink("/" . $documento->nombredocumento);

                            //Get File Metadata
                            $file = $temporaryLink->getMetadata();

                            //Get Link
                            $temporaryLink->getLink();
                            $note_array['link'] = $temporaryLink->getLink();
                        } else {
                            $note_array['link'] = "";
                        }
                        array_push($user_array['documentos'], $note_array);
                    }
                }
                array_push($usersList_array, $user_array);
            }
        }

        if (isset($usersList_array) && !empty($usersList_array)) {

            echo json_encode($usersList_array, JSON_PRETTY_PRINT);
        }
    }

    public function showdetalleRespuestaTareaAlumno()
    {
        $idtarea = $this->input->get('idtarea');
        $idalumno = $this->session->idalumno;
        //$idtarea = 310;
        //$idalumno = 883 ;
        $query = $this->tarea->showAllTaresDetalleAlumno($idtarea, $idalumno);

        $usersList_array = array();
        $user_array = array();
        $note_array = array();
        if ($query) {
            foreach ($query as $row) {
                $user_array["iddetalletarea"] = $row->iddetalletarea;
                $user_array["idtarea"] = $row->idtarea;
                $user_array["idalumno"] = $row->idalumno;
                $user_array["nombre"] = $row->nombre;
                $user_array["apellidop"] = $row->apellidop;
                $user_array["apellidom"] = $row->apellidom;
                $user_array["iddocumento"] = $row->iddocumento;
                $user_array["mensaje"] = $row->mensaje;
                $user_array["fecharegistro"] = $row->fecharegistro;
                $user_array["calificacion"] = $row->calificacion;
                $user_array["observacionesdocente"] = $row->observacionesdocente;
                $user_array["documentos"] = array();
                $documentos = $this->tarea->obtenerDocumentosAlumno($row->iddetalletarea);
                if ($documentos) {
                    foreach ($documentos as $documento) {
                        $note_array["file"] = $documento->iddocumento;
                        $note_array["extension"] = $documento->extension;
                        if (empty($documento->iddocumento) && !empty($documento->nombredocumento)) {
                            $app = new Kunnu\Dropbox\DropboxApp($this->appkey, $this->appsecret,  $this->token);
                            $dropbox = new Kunnu\Dropbox\Dropbox($app);
                            $temporaryLink = $dropbox->getTemporaryLink("/" . $documento->nombredocumento);

                            //Get File Metadata
                            $file = $temporaryLink->getMetadata();

                            //Get Link
                            $temporaryLink->getLink();
                            $note_array['link'] = $temporaryLink->getLink();
                        } else {
                            $note_array['link'] = "";
                        }
                        array_push($user_array['documentos'], $note_array);
                    }
                }
                array_push($usersList_array, $user_array);
            }
        }

        if (isset($usersList_array) && !empty($usersList_array)) {

            echo json_encode($usersList_array, JSON_PRETTY_PRINT);
        }
    }

    public function showDocumentosAlumno()
    {
        $idtarea = $this->input->get('idtarea');
        $idalumno = $this->input->get('idalumno');
        $query = $this->tarea->obtenerDocumentosTareaAlumno($idtarea, $idalumno);

        $result['documentos'] = $query;
        echo json_encode($result);
    }


    //MOSTRAR TAREA EN DETALLE

    public function tareasEnvidasPorAlumno()
    {
        $idtarea = $this->input->get('idtarea');
        $idalumno = $this->input->get('idalumno');

        $query = $this->tarea->showAllTaresDetalleAlumno($idtarea, $idalumno);
        $usersList_array = array();
        $user_array = array();
        $note_array = array();
        if ($query) {
            foreach ($query as $row) {
                $user_array["iddetalletarea"] = $row->iddetalletarea;
                $user_array["idtarea"] = $row->idtarea;
                $user_array["idalumno"] = $row->idalumno;
                $user_array["nombre"] = $row->nombre;
                $user_array["apellidop"] = $row->apellidop;
                $user_array["apellidom"] = $row->apellidom;
                $user_array["iddocumento"] = $row->iddocumento;
                $user_array["mensaje"] = $row->mensaje;
                $user_array["fecharegistro"] = $row->fecharegistro;
                $user_array["calificacion"] = $row->calificacion;
                $user_array["observacionesdocente"] = $row->observacionesdocente;
                $user_array["documentos"] = array();
                $documentos = $this->tarea->obtenerDocumentosAlumno($row->iddetalletarea);
                if ($documentos) {
                    foreach ($documentos as $documento) {
                        $note_array["file"] = $documento->iddocumento;
                        $note_array["extension"] = $documento->extension;
                        if (empty($documento->iddocumento) && !empty($documento->nombredocumento)) {
                            $app = new Kunnu\Dropbox\DropboxApp($this->appkey, $this->appsecret,  $this->token);
                            $dropbox = new Kunnu\Dropbox\Dropbox($app);
                            $temporaryLink = $dropbox->getTemporaryLink("/" . $documento->nombredocumento);

                            //Get File Metadata
                            $file = $temporaryLink->getMetadata();

                            //Get Link
                            $temporaryLink->getLink();


                            $parameters = array('path' => '/' . $documento->nombredocumento);

                            $headers = array(
                                'Authorization: Bearer ' . $this->token,
                                'Content-Type: application/json'
                            );

                            $curlOptions = array(
                                CURLOPT_HTTPHEADER => $headers,
                                CURLOPT_POST => true,
                                CURLOPT_POSTFIELDS => json_encode($parameters),
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_VERBOSE => true
                            );

                            $ch = curl_init('https://api.dropboxapi.com/2/sharing/create_shared_link_with_settings');
                            curl_setopt_array($ch, $curlOptions);

                            $response = curl_exec($ch);
                            $json = json_decode($response, true);
                            $liga = "";
                            if (isset($json["error"]["shared_link_already_exists"]["metadata"]["url"]) && !empty($json["error"]["shared_link_already_exists"]["metadata"]["url"])) {
                                $liga  = $json["error"]["shared_link_already_exists"]["metadata"]["url"];
                            }
                            $note_array['link'] = $temporaryLink->getLink();
                            $note_array['ligapreview'] = $liga;
                        } else {
                            $note_array['link'] = "";
                        }
                        array_push($user_array['documentos'], $note_array);
                    }
                }
                array_push($usersList_array, $user_array);
            }
        }

        if (isset($usersList_array) && !empty($usersList_array)) {

            echo json_encode($usersList_array, JSON_PRETTY_PRINT);
        }
    }

    public function reporteCalificacionAlumnosXTarea()
    {
        $idtarea = $this->input->get('id');
        $idhorario = $this->input->get('idhorario');
        $idmateria = $this->input->get('idmateria');
        $idprofesormateria = $this->input->get('idprofesormateria');
        $query = $this->tarea->showAllAlumnosTareaReporte($idhorario, $idprofesormateria, $idmateria, $idtarea);
        if ($query) {
            $result['reporte'] = $this->tarea->showAllAlumnosTareaReporte($idhorario, $idprofesormateria, $idmateria, $idtarea);
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }
    public function reporteCalificaciones()
    {
        $config = array(
            array(
                'field' => 'fechainicio',
                'label' => 'Fecha Inicio',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Seleccione la Fecha.'
                )
            ),
            array(
                'field' => 'fechafin',
                'label' => 'Fecha Fin',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Seleccione la Fecha.'
                )
            ),

        );

        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            $result['error'] = true;
            $result['msg'] = array(
                'fechainicio' => form_error('fechainicio'),
                'fechafin' => form_error('fechafin')
            );
        } else {
            $value = $this->input->post('texto');
            $fechainicio = $this->input->post('fechainicio');
            $fechafin = $this->input->post('fechafin');
            $idhorariodetalle = $this->input->get('idhorariodetalle');
            $detalle_horario = $this->horario->detalleHorarioDetalle($idhorariodetalle);
            $idhorario = $detalle_horario[0]->idhorario;
            $idmateria = $detalle_horario[0]->idmateria;
            $fecha_inicio = strtotime($fechainicio);
            $fecha_fin = strtotime($fechafin);
            // echo $idhorario."<br>";
            // echo $idmateria."<br>";
            // $range = ((strtotime($fechafin) - strtotime($fechainicio)) + (24 * 60 * 60)) / (24 * 60 * 60); 
            $usersList_array = array();
            $user_array = array();
            $note_array = array();
            $alumnos = $this->tarea->showAlumnosGrupo($idhorario);
            if (isset($alumnos) && !empty($alumnos)) {
                $contador = 1;
                foreach ($alumnos as $alumno) {
                    //$user_array["idalumno"] = $alumno->idalumno;
                    $user_array["Numero"] = $contador++;
                    $user_array["Nombre"] = $alumno->apellidop . " " . $alumno->apellidom . " " . $alumno->nombre;
                    $idalumno = $alumno->idalumno;
                    $suma_calificacion  = 0;
                    $suma_total = 0;
                    for ($i = $fecha_inicio; $i <= $fecha_fin; $i += 86400) {
                        $fecha = date("Y-m-d", $i);
                        $fecha_formateada = date("d/m/Y", $i);
                        //$user_array[$fecha] = $fecha;
                        //array_push($usersList_array,$user_array);

                        $calificaciones = $this->tarea->obtenerCalificacionXId($idhorario, $idmateria, $idalumno, $fecha);
                        if (isset($calificaciones) && !empty($calificaciones)) {
                            foreach ($calificaciones as $calificacion) {
                                $user_array[$fecha_formateada] =  numberFormatPrecision($calificacion->calificacion, 1, '.');
                                $suma_total++;
                                $suma_calificacion = $suma_calificacion + $calificacion->calificacion;
                            }
                        }
                    }
                    $user_array["Promedio"] = ($suma_calificacion > 0) ?  numberFormatPrecision($suma_calificacion / $suma_total, 1, '.') : 0;
                    array_push($usersList_array, $user_array);
                }


                if (isset($usersList_array) && !empty($usersList_array)) {

                    echo json_encode($usersList_array, JSON_PRETTY_PRINT);
                }
            }
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }
    public function showAllAlumnosTarea()
    {
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

    public function searchTareasAlumno()
    {
        $value = $this->input->post('text');
        $idhorario = $this->decode($this->input->get('idhorario'));
        $idalumno = $this->decode($this->input->get('idalumno'));
        if (isset($idhorario) && !empty($idhorario)) {
            $query = $this->tarea->searchTareasAlumnoMateria($value, $idhorario, $idalumno);
            if ($query) {
                $result['tareas'] = $this->tarea->searchTareasAlumnoMateria($value, $idhorario, $idalumno);
            }
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }
    public function searchTareasAlumnoXMateria()
    {
        $value = $this->input->post('text');
        $idhorario = $this->decode($this->input->get('idhorario'));
        $idmateria = $this->input->get('idmateria');
        $idalumno =  $this->session->idalumno;
        if (isset($idhorario) && !empty($idhorario)) {
            $query = $this->tarea->searchTareasAlumnoXMateria($value, $idhorario, $idalumno, $idmateria);
            if ($query) {
                $result['tareas'] = $this->tarea->searchTareasAlumnoXMateria($value, $idhorario, $idalumno, $idmateria);
            }
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function searchAllAlumnosTarea()
    {
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

    public function obtenerCarpeta($idplantel)
    {
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

    public function addTarea()
    {
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

            if (!empty($_FILES['files']) && count(array_filter($_FILES['files'])) > 0) {

                $dataTarea = array(
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

                $idTarea = $this->tarea->addTarea($dataTarea);

                $filesCount = count($_FILES['files']['name']);

                for ($i = 0; $i < $filesCount; $i++) {

                    $_FILES['file']['name']     = $_FILES['files']['name'][$i];
                    $_FILES['file']['type']     = $_FILES['files']['type'][$i];
                    $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
                    $_FILES['file']['error']     = $_FILES['files']['error'][$i];
                    $_FILES['file']['size']     = $_FILES['files']['size'][$i];

                    $this->load->library('Autoload');
                    //$tmp_dir = ini_get('upload_tmp_dir') ? ini_get('upload_tmp_dir') : sys_get_temp_dir();
                    //sdie($tmp_dir);
                    $maxsize = 80000000;
                    $allowed = array('gif', 'png', 'jpg', 'jpeg', 'gif', 'docx', 'doc', 'pdf', 'xls', 'xlsx', 'fla', 'pptx', 'ppt', 'mov', 'mp4', 'avi', 'vfw', 'm4v', 'wmv', 'mkv', 'flv');
                    $filename = $_FILES['file']['name'];
                    $ext = pathinfo($filename, PATHINFO_EXTENSION);

                    //if (in_array($ext, $allowed)) {
                    if (($_FILES['file']['size'] <= $maxsize)) {

                        $file_name = $_FILES['file']['name']; //ruta al archivo
                        $tmp = explode('.', $file_name);
                        $extension_img = end($tmp);
                        $user_img_profile = date("Y-m-dhis") . '.' . $extension_img;
                        $config['file_name'] = $user_img_profile;

                        //$filePath  = $_FILES['file'][''];
                        $fileName = $user_img_profile;
                        $app = new Kunnu\Dropbox\DropboxApp($this->appkey, $this->appsecret,  $this->token);

                        //Configure Dropbox service
                        //$dropbox = new Dropbox($app);
                        $dropbox = new Kunnu\Dropbox\Dropbox($app);
                        //Get File Metadata



                        // File to Upload
                        $file = $_FILES['file'];

                        // File Path
                        // $fileName = $file['name'];
                        $filePath = $file['tmp_name'];

                        try {
                            // Create Dropbox File from Path
                            $dropboxFile = new Kunnu\Dropbox\DropboxFile($filePath);

                            // Upload the file to Dropbox
                            $uploadedFile = $dropbox->upload($dropboxFile, "/" . $fileName,     ['autorename' => true]);

                            // File Uploaded
                            $uploadedFile->getPathDisplay();

                            $dataDocumentos = array(
                                'idtarea' => $idTarea,
                                'nombredocumento' => $fileName,
                                'iddocumento' => "",
                                'idusuario' => $this->session->user_id,
                                'fecharegistro' => date('Y-m-d H:i:s'),
                            );

                            $value = $this->tarea->addDocumentTarea($dataDocumentos);
                        } catch (DropboxClientException $e) {
                            //echo $e->getMessage();
                            $result['error'] = true;
                            $result['msg'] = array(
                                'msgerror' => $e->getMessage()
                            );
                        }
                    } else {
                        $result['error'] = true;
                        $result['msg'] = array(
                            'msgerror' => "EL DOCUMENTO DEBE DE PESAR 78MB COMO MAXIMO."
                        );
                    }
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

    public function updateTarea()
    {
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

            if (!empty($_FILES['files']) && count(array_filter($_FILES['files'])) > 0) {

                $dataUpdateWork = array(
                    'titulo' => mb_strtoupper($titulo),
                    'tarea' => $tarea,
                    'fechaentrega' => $fechaentrega,
                    'horaentrega' => $horaentrega,
                    'idnotificacionalumno' => 1,
                    'idnotificaciontutor' => 1,
                    'idusuario' => $this->session->user_id,
                    'fecharegistro' => date('Y-m-d H:i:s'),
                );

                $responseUpdateWork = $this->tarea->updateTarea($idtarea, $dataUpdateWork);


                $filesCount = count($_FILES['files']['name']);

                for ($i = 0; $i < $filesCount; $i++) {

                    $_FILES['file']['name']     = $_FILES['files']['name'][$i];
                    $_FILES['file']['type']     = $_FILES['files']['type'][$i];
                    $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
                    $_FILES['file']['error']     = $_FILES['files']['error'][$i];
                    $_FILES['file']['size']     = $_FILES['files']['size'][$i];

                    $this->load->library('Autoload');

                    $maxsize = 80000000;
                    $allowed = array('gif', 'png', 'jpg', 'jpeg', 'gif', 'docx', 'doc', 'pdf', 'xls', 'xlsx', 'fla', 'pptx', 'ppt', 'mov', 'mp4', 'avi', 'vfw', 'm4v', 'wmv', 'mkv', 'flv');
                    $filename = $_FILES['file']['name'];
                    $ext = pathinfo($filename, PATHINFO_EXTENSION);

                    // if (in_array($ext, $allowed)) {
                    if (($_FILES['file']['size'] <= $maxsize)) {
                        $file_name = $_FILES['file']['name']; //ruta al archivo
                        $tmp = explode('.', $file_name);
                        $extension_img = end($tmp);
                        $user_img_profile = date("Y-m-dhis") . '.' . $extension_img;
                        $config['file_name'] = $user_img_profile;


                        //$filePath  = $_FILES['file'][''];
                        $fileName = $user_img_profile;
                        $app = new Kunnu\Dropbox\DropboxApp($this->appkey, $this->appsecret,  $this->token);

                        //Configure Dropbox service
                        //$dropbox = new Dropbox($app);
                        $dropbox = new Kunnu\Dropbox\Dropbox($app);
                        //Get File Metadata



                        // File to Upload
                        $file = $_FILES['file'];

                        // File Path
                        // $fileName = $file['name'];
                        $filePath = $file['tmp_name'];

                        try {
                            // Create Dropbox File from Path
                            $dropboxFile = new Kunnu\Dropbox\DropboxFile($filePath);

                            // Upload the file to Dropbox
                            $uploadedFile = $dropbox->upload($dropboxFile, "/" . $fileName,     ['autorename' => true]);

                            // File Uploaded
                            $uploadedFile->getPathDisplay();

                            $dataDocumentos = array(
                                'idtarea' => $idtarea,
                                'nombredocumento' => $fileName,
                                'iddocumento' => "",
                                'idusuario' => $this->session->user_id,
                                'fecharegistro' => date('Y-m-d H:i:s'),
                            );

                            $value = $this->tarea->addDocumentTarea($dataDocumentos);
                        } catch (DropboxClientException $e) {
                            //echo $e->getMessage();
                            $result['error'] = true;
                            $result['msg'] = array(
                                'msgerror' => $e->getMessage()
                            );
                        }
                    } else {
                        $result['error'] = true;
                        $result['msg'] = array(
                            'msgerror' => "EL DOCUMENTO DEBE DE PESAR 78MB COMO MAXIMO."
                        );
                    }
                    /*   } else {
                        $result['error'] = true;
                        $result['msg'] = array(
                            'msgerror' => "SOLO ES PERMITDO IMAGENES, WORD, PDF Y EXCEL."
                        );
                    } */
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

    public function deleteTarea()
    {
        $id = $this->input->get('id');
        $data = array(
            'eliminado' => 1
        );

        $query = $this->tarea->updateTarea($id, $data);

        //Eliminar documentos de la DB
        //$eliminarDocumentos = $this->tarea->deleteDocumentTarea($id);

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

    public function obtenerDocumentosTarea()
    {

        $idtarea = $this->input->get('idtarea');
        $do = array();
        $usersList_array = array();
        $query = $this->tarea->obtenerDocumentos($idtarea);
        if (isset($query) && !empty($query)) {
            foreach ($query as $row) {
                $do['iddocumentotarea'] = $row->iddocumentotarea;
                $do['iddocumento'] = $row->iddocumento;
                $do['nombredocumento'] = $row->nombredocumento;
                $do['extension'] = $row->extension;
                if (empty($row->iddocumento) && !empty($row->nombredocumento)) {
                    $app = new Kunnu\Dropbox\DropboxApp($this->appkey, $this->appsecret,  $this->token);
                    $dropbox = new Kunnu\Dropbox\Dropbox($app);
                    $temporaryLink = $dropbox->getTemporaryLink("/" . $row->nombredocumento);

                    //Get File Metadata
                    $file = $temporaryLink->getMetadata();

                    //Get Link
                    $temporaryLink->getLink();
                    $do['link'] = $temporaryLink->getLink();
                } else {
                    $do['link'] = "";
                }
                array_push($usersList_array, $do);
            }
        }
        // $result['documentos'] = $do;
        // echo json_encode($result);
        echo json_encode($usersList_array, JSON_PRETTY_PRINT);
    }

    public function obtenerDocumentosTareaRevisar()
    {

        $idtarea = $this->input->get('idtarea');
        $idalumno = $this->input->get('idalumno');

        $query = $this->tarea->obtenerDocumentosTareaAlumno($idtarea, $idalumno);

        $result['documentos'] = $query;
        echo json_encode($result);
    }

    public function deleteDocument()
    {
        $iddocumento = $this->input->get('iddocumentotarea');

        $query = $this->tarea->deleteDocument($iddocumento);
        if ($query) {
            $result['error'] = false;
        } else {
            $result['error'] = true;
            $result['msg'] = array(
                'msgerror' => 'No se puede Elimnar el documento.'
            );
        }

        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }
    public function maxNumber($num)
    {
        if ($num >= 0.00 && $num <= 10.00) {
            return true;
        } else {
            $this->form_validation->set_message('maxNumber', 'La calificación debe de ser entre 0.00 a 10.00');
            return false;
        }
    }
    public function calificarTareaAlumno()
    {
        $config = array(
            array(
                'field' => 'calificacion',
                'label' => 'Calificacion',
                'rules' => 'trim|decimal|callback_maxNumber|required',
                'errors' => array(
                    'decimal' => 'La calificación debe ser 1 entero y 1 digito.',
                    'required' => 'Agregue la calificación.'
                )
            )
        );

        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            $result['error'] = true;
            $result['msg'] = array(
                'calificacion' => form_error('calificacion'),
            );
        } else {
            $iddetalletarea = trim($this->input->post('iddetalletarea'));
            $observaciones = trim($this->input->post('observacionesdocente'));
            $calificacion = trim($this->input->post('calificacion'));

            $data = array(
                'observacionesdocente' => $observaciones,
                'calificacion' => $calificacion
            );
            $this->tarea->updateDetalleTarea($iddetalletarea, $data);
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function contestar()
    {
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

    public function showTareasAlumno()
    {
        $idhorario = $this->decode($this->input->get('idhorario'));
        $idalumno = $this->decode($this->input->get('idalumno'));
        if (isset($idhorario) && !empty($idhorario)) {
            $query = $this->tarea->showTareasAlumnoMateria($idhorario, $idalumno);
            if ($query) {
                $result['tareas'] = $this->tarea->showTareasAlumnoMateria($idhorario, $idalumno);
            }
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }
    public function showTareasAlumno2()
    {
        $idhorario = 13;
        $idalumno = 939;
        if (isset($idhorario) && !empty($idhorario)) {
            $query = $this->tarea->showTareasAlumnoMateria($idhorario, $idalumno);
            if ($query) {
                $result['tareas'] = $this->tarea->showTareasAlumnoMateria($idhorario, $idalumno);
            }
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
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

    public function responderTareaAlumno()
    {
        $config = array(
            array(
                'field' => 'tarea',
                'label' => 'Redactar tarea',
                'rules' => 'trim',
                'errors' => array()
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

            //if ($fechaactual <= $fecha_antes) {
            if (!empty($_FILES['files']) && count(array_filter($_FILES['files'])) > 0) {
                $data = array(
                    'idtarea' => $idtarea,
                    'idalumno' => $this->session->idalumno,
                    'idestatustarea' => 1,
                    'mensaje' => $tarea,
                    'nombrearchivo' => '',
                    'iddocumento' => '',
                    'eliminado' => 0,
                    'idusuario' => $this->session->user_id,
                    'fecharegistro' => date('Y-m-d H:i:s')
                );

                $idDetalleTarea = $this->tarea->addDetalleTarea($data);



                $filesCount = count($_FILES['files']['name']);

                for ($i = 0; $i < $filesCount; $i++) {

                    $_FILES['file']['name']     = $_FILES['files']['name'][$i];
                    $_FILES['file']['type']     = $_FILES['files']['type'][$i];
                    $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
                    $_FILES['file']['error']     = $_FILES['files']['error'][$i];
                    $_FILES['file']['size']     = $_FILES['files']['size'][$i];

                    $maxsize = 80000000;
                    $allowed = array('gif', 'png', 'jpg', 'jpeg', 'gif', 'docx', 'doc', 'pdf', 'xls', 'xlsx', 'fla', 'pptx', 'ppt', 'mov', 'mp4', 'avi', 'vfw', 'm4v', 'wmv', 'mkv', 'flv');
                    $filename = $_FILES['file']['name'];
                    $ext = pathinfo($filename, PATHINFO_EXTENSION);

                    if (in_array(strtolower($ext), $allowed)) {
                        if (($_FILES['file']['size'] <= $maxsize)) {
                            $file_name = $_FILES['file']['name']; //ruta al archivo
                            $tmp = explode('.', $file_name);
                            $extension_img = end($tmp);
                            $user_img_profile = $this->session->user_id . '-' . date("Ymdhis") . '.' . $extension_img;
                            $config['file_name'] = $user_img_profile;
                            $fileName = $user_img_profile;
                            $app = new Kunnu\Dropbox\DropboxApp($this->appkey, $this->appsecret,  $this->token);

                            //Configure Dropbox service
                            //$dropbox = new Dropbox($app);
                            $dropbox = new Kunnu\Dropbox\Dropbox($app);
                            //Get File Metadata 
                            // File to Upload
                            $file = $_FILES['file'];

                            // File Path
                            // $fileName = $file['name'];
                            $filePath = $file['tmp_name'];

                            try {
                                // Create Dropbox File from Path
                                $dropboxFile = new Kunnu\Dropbox\DropboxFile($filePath);

                                // Upload the file to Dropbox
                                $uploadedFile = $dropbox->upload($dropboxFile, "/" . $fileName,     ['autorename' => true]);

                                // File Uploaded
                                $uploadedFile->getPathDisplay();

                                $dataDocumentos = array(
                                    'iddetalletarea' => $idDetalleTarea,
                                    'nombredocumento' => $fileName,
                                    'iddocumento' => "",
                                    'idusuario' => $this->session->user_id,
                                    'fecharegistro' => date('Y-m-d H:i:s'),
                                );

                                $value = $this->tarea->addDocumentRespuestaTarea($dataDocumentos);
                            } catch (Kunnu\Dropbox\Exceptions\DropboxClientException $e) {
                                //Eliminar Documento Alumno
                                $this->tarea->deleteDocumentoAlumno($idDetalleTarea);
                                //Eliminar Detalle Tarea
                                $this->tarea->deleteDetalleTarea($idDetalleTarea);
                                //$dropboxFile = new Kunnu\Dropbox\Exceptions\DropboxClientException;
                                $result['error'] = true;
                                $result['msg'] = array(
                                    'msgerror' => $e->getMessage()
                                );
                            }
                        } else {
                            $result['error'] = true;
                            $result['msg'] = array(
                                'msgerror' => "EL DOCUMENTO DEBE DE PESAR 78MB COMO MAXIMO."
                            );
                        }
                    } else {
                        $result['error'] = true;
                        $result['msg'] = array(
                            'msgerror' => "SOLO ES PERMITDO IMAGENES, WORD, PDF Y EXCEL."
                        );
                    }
                }
            } else {
                if (isset($tarea) && !empty($tarea)) {
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
                } else {
                    $result['error'] = true;
                    $result['msg'] = array(
                        'msgerror' => "Escriba en mensaje de la tarea."
                    );
                }
            }
            /* } else {
                $result['error'] = true;
                $result['msg'] = array(
                    'msgerror' => "USTED DEBIO DE ENTRAGAR LA TAREA ANTES DE " . $fecha_antes
                );
            }*/
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }
}
