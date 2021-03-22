<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("America/Mexico_City");
class Webhook extends CI_Controller
{
      function __construct()
      {
            parent::__construct();
            $this->load->helper('url');
            $this->load->model('data_model');
            $this->load->model('alumno_model', 'alumno');
            $this->load->model('grupo_model', 'grupo');
            $this->load->model('horario_model', 'horario');
            $this->load->model('user_model', 'user');
            $this->load->model('cicloescolar_model', 'cicloescolar');
            $this->load->model('tutor_model', 'tutor');
            $this->load->model('webhook_model', 'webhook');
            $this->load->model('data_model');
            $this->load->library('pdfgenerator');
            $this->load->library('openpayservicio');
            $this->load->library('encryption');
      }

      public function cambiargrupo()
      {
            $id_periodo_anterior  = 11;
            //$id_grupo_anterior =0;

            $id_periodo_nuevo = 16;
            //$id_grupo_nuevo = 0;

            $lista_alumnos = $this->webhook->alumnos($id_periodo_anterior);
            if (isset($lista_alumnos) && !empty($lista_alumnos)) {
                  foreach ($lista_alumnos as  $value) {
                        $idalumnogrupo = $value->idalumnogrupo;
                        $idalumno = $value->idalumno;
                        $data = array(
                              'idalumno' => $idalumno,
                              'idperiodo' => $id_periodo_nuevo,
                              'idgrupo' => $value->idgrupo,
                              'idbeca' => $value->idbeca,
                              'idestatusnivel' => $value->idestatusnivel,
                              'activo' => $value->activo,
                              'idusuario' => 45,
                              'fecharegistro' => date('Y-m-d H:i:s'),
                        );
                        $this->webhook->addAlumnoGrupo($data);
                        $data_update = array(
                              'activo' => 0
                        );
                        $this->webhook->updateAlumnoGrupo($idalumnogrupo, $data_update);
                  }
            }
      }

      public function index()
      {
            $body = @file_get_contents('php://input');
            $data = json_decode($body);
            http_response_code(200); // Return 200 OK 
      }
      /*
public function noficaciones()
{
$body = @file_get_contents('php://input');
$data = json_decode($body);
http_response_code(200); // Return 200 OK
}
public function crear_webhooks()
{
$openpay = Openpay::getInstance('moiep6umtcnanql3jrxp', 'sk_3433941e467c1055b178ce26348b0fac');

$webhook = array(
'url' => 'http://requestb.in/11vxrsf1',
'user' => 'juanito',
'password' => 'passjuanito',
'event_types' => array(
'charge.refunded',
'charge.failed',
'charge.cancelled',
'charge.created',
'chargeback.accepted'
)
);

$webhook = $openpay->webhooks->add($webhook);
}
public function solicitar_webhooks()
{
$openpay = Openpay::getInstance('moiep6umtcnanql3jrxp', 'sk_3433941e467c1055b178ce26348b0fac');

$webhook = $openpay->webhooks->get('wxvanstudf4ssme8khmc');
}
 */
}
