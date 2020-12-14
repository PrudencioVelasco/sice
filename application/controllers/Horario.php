<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("America/Mexico_City");

class Horario extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        if (!isset($_SESSION['user_id'])) {
            $this->session->set_flashdata('flash_data', 'You don\'t have access! ss');
            return redirect('welcome');
        }
        $this->load->helper('url');
        $this->load->model('horario_model', 'horario');
        $this->load->model('alumno_model', 'alumno');
        $this->load->model('data_model');
        $this->load->library('permission');
        $this->load->library('session');
    }

    public function inicio()
    {
        $this->load->view('admin/header');
        $this->load->view('admin/horario/index');
        $this->load->view('admin/footer');
    }

    public function searchHorario()
    {
        $idplantel = $this->session->idplantel;
        $value = $this->input->post('text');
        $query = $this->horario->searchHorario($value, $idplantel);
        if ($query) {
            $result['horarios'] = $query;
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function showAll()
    {
        $query = $this->horario->showAll($this->session->idplantel);

        if ($query) {
            $result['horarios'] = $this->horario->showAll($this->session->idplantel);
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function detalle($id)
    {
        # code...
        Permission::grant(uri_string());
        $activo_horario = 0;
        $activo_ciclo_escolar = 0;
        if ($this->horario->validarActivoHorario($id)) {
            $activo_horario = 1;
        }
        if ($this->horario->validarActivoCicloEscolar($id)) {
            $activo_ciclo_escolar = 1;
        }
        $detalle_horario = $this->horario->detalleHorario($id);
        $data = array(
            'id' => $id,
            'activo_horario' => $activo_horario,
            'detalle_horario' => $detalle_horario,
            'activo_ciclo_escolar' => $activo_ciclo_escolar
        );
        $this->load->view('admin/header');
        $this->load->view('admin/horario/detalle', $data);
        $this->load->view('admin/footer');
    }

    public function descargar($idhorario = '')
    {
        $detalle_logo = $this->alumno->logo($this->session->idplantel);
        $detalle_horario = $this->horario->detalleHorario($idhorario);
        $logo = base_url() . '/assets/images/escuelas/' . $detalle_logo[0]->logoplantel;
        $logo2 = base_url() . '/assets/images/escuelas/' . $detalle_logo[0]->logosegundo;

        $this->load->library('tcpdf');
        $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetTitle('Horario de clases.');
        $pdf->SetHeaderMargin(30);
        $pdf->SetTopMargin(10);
        $pdf->setFooterMargin(20);
        $pdf->SetAutoPageBreak(TRUE, 0);
        $pdf->SetAuthor('Author');
        $pdf->SetDisplayMode('real', 'default');
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        $pdf->SetMargins(15, 15, 15);
        $pdf->SetHeaderMargin(15);
        $pdf->SetFooterMargin(15);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, 15);

        $pdf->AddPage();
        $tabla = '
        <style type="text/css">
     .txtn{
        font-size:9px;
    }
    .direccion{
        font-size:8px;
    }
    .nombreplantel{
        font-size:10px;
        font-weight:bolder;
    }
    .telefono{
          font-size:8px;
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
      font-size:8px; 
    font-weight:bold;
    border-bottom:solid 1px #000000;
}
.result{
     font-family:Verdana, Geneva, sans-serif;
      font-size:8px; 
    font-weight:bold;
}.nombreclase{
   font-size:12px;
   font-weight: bold;
}
.txthorario{
   font-size:8px;
}
.txttutor{
   font-size:10px;
}
.txtdia{
  font-size:8px;
   font-weight: bold;
   background-color:#ccc;
}
  .tblhorario tr td
                {
                    border:0px solid black;
                }
</style>
<div id="areaimprimir">  
          <table width="600" border="0" >';
        if ((isset($this->session->idniveleducativo) && !empty($this->session->idniveleducativo)) && ($this->session->idniveleducativo == 5)) {
            $tabla .= '<tr>
    <td width="150" align="center" valing="top"><img width="100" src="' . $logo2 . '" /></td>
    <td colspan="2" width="230" align="center">
            <label class="nombreplantel" >"VALOR Y CONFIANZA"</label><br>
            <label class="txtn"style="color:#0c4d9e;" >INSTITUTO MORELOS</label><br>
            <label class="direccion" style="color:#0c4d9e;">C.C.T.' . $detalle_logo[0]->clave . '</label><br>';
            $tabla .= ' <label class="telefono" style="color:#0c4d9e;">TURNO ' . $detalle_horario->nombreturno . '</label><br/>';
            $tabla .= '<label class="telefono" style="color:#49950c;">136 años educando a la niñez y juventud</label>
    </td>
    <td width="150" align="center"><img  width="120"   src="' . $logo . '" /></td>';
            $tabla .= '</tr>';
            $tabla .= '<tr>
    <td width="150" align="center" style="font-size:10px;">CICLO ESCOLAR ' . $detalle_horario->yearinicio . '-' . $detalle_horario->yearfin . '</td>
    <td colspan="2"  width="230" align="center">  </td>
    <td width="150" align="center" style="font-size:10px;"> ' . $detalle_horario->nombrenivel . ' ' . $detalle_horario->nombregrupo . '</td>';
            $tabla .= '</tr>';
        } else if ((isset($this->session->idniveleducativo) && !empty($this->session->idniveleducativo)) && ($this->session->idniveleducativo == 3)) {
            $tabla .= '<tr>
    <td width="150" align="center" valing="top"><img  src="' . $logo2 . '" /></td>
    <td colspan="2" width="230" align="center">
            <label class="nombreplantel" >' . $detalle_logo[0]->nombreplantel . '</label><br>
            <label class="txtn">' . $detalle_logo[0]->asociado . '</label><br>
            <label class="direccion">C.C.T.' . $detalle_logo[0]->clave . '</label><br>';
            $tabla .= '<label class="telefono">Incorporado a la Dirección General del Bachillerato - Modalidad Escolarizada
RVOE: 85489 de fecha 29 julio 1985, otorgado por la Dirección General de Incorporación y Revalidación
</label>
    </td>
    <td width="150" align="center"><img     src="' . $logo . '" /></td>';

            $tabla .= '</tr>';
            $tabla .= '<tr>
    <td width="150" align="center" style="font-size:10px;">CICLO ESCOLAR ' . $detalle_horario->yearinicio . '-' . $detalle_horario->yearfin . '</td>
    <td colspan="2"  width="230" align="center">  </td>
    <td width="150" align="center" style="font-size:10px;"> ' . $detalle_horario->nombrenivel . ' ' . $detalle_horario->nombregrupo . '</td>';
            $tabla .= '</tr>';
        } else {
            $tabla .= '<tr>
    <td width="150" align="center" valing="top"><img class="imgtitle" src="' . $logo2 . '" /></td>
    <td colspan="2" width="230" align="center">
            <label class="nombreplantel">' . $detalle_logo[0]->nombreplantel . '</label><br>
            <label class="txtn">' . $detalle_logo[0]->asociado . '</label><br>
            <label class="direccion">C.C.T.' . $detalle_logo[0]->clave . '</label><br>';

            $tabla .= '<label class="telefono">136 años educando a la niñez y juventud</label>
    </td>
    <td width="150" align="center"><img   class="imgtitle"  src="' . $logo . '" /></td>';
            $tabla .= '</tr>';
            $tabla .= '<tr>
    <td width="150" align="center" style="font-size:10px;">CICLO ESCOLAR ' . $detalle_horario->yearinicio . '-' . $detalle_horario->yearfin . '</td>
    <td colspan="2"  width="230" align="center">  </td>
    <td width="150" align="center" style="font-size:10px;"> ' . $detalle_horario->nombrenivel . ' ' . $detalle_horario->nombregrupo . '</td>';
            $tabla .= '</tr>';
        }
        $tabla .= '</table> <br/>';

        $tabla .= '<table class="tblhorario" width="600" cellpadding="2" > ';
        $tabla .= '<tr>';
        $tabla .= '<td width="65" align="center" class="txtdia">Hora</td>';
        $tabla .= '<td width="93" align="center" class="txtdia">Lunes</td>';
        $tabla .= '<td width="93" align="center" class="txtdia">Martes</td>';
        $tabla .= '<td width="93" align="center" class="txtdia">Miercoles</td>';
        $tabla .= '<td width="93" align="center" class="txtdia">Jueves</td>';
        $tabla .= '<td width="93" align="center" class="txtdia">Viernes</td>';

        $tabla .= '</tr>';
        $lunesAll = $this->horario->showAllDiaHorarioSinDua($idhorario);

        foreach ($lunesAll as $row) {
            $tabla .= '<tr>';
            $tabla .= '<td width="65" class="txthorario">' . $row->hora . '</td>';
            $tabla .= '<td width="93" class="txthorario">' . $row->lunes . '</td>';
            $tabla .= '<td  width="93"class="txthorario">' . $row->martes . '</td>';
            $tabla .= '<td  width="93"class="txthorario">' . $row->miercoles . '</td>';
            $tabla .= '<td width="93" class="txthorario">' . $row->jueves . '</td>';
            $tabla .= '<td width="93" class="txthorario">' . $row->viernes . '</td>';

            $tabla .= '</tr>';
        }
        $tabla .= '</table>';
        $pdf->writeHTML($tabla, true, false, false, false, '');

        ob_end_clean();

        $pdf->Output('Horario Escolar', 'I');
    }

    public function showAllDiaHorario($idhorario, $iddia)
    {
        $query = $this->horario->showAllDiaHorario($idhorario, $iddia);
        if ($query) {
            $result['horarios'] = $this->horario->showAllDiaHorario($idhorario, $iddia);
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function showAllDias()
    {
        $query = $this->horario->showAllDias();
        if ($query) {
            $result['dias'] = $this->horario->showAllDias();
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function showAllPeriodos()
    {
        $query = $this->horario->showAllPeriodos($this->session->idplantel);
        if ($query) {
            $result['periodos'] = $this->horario->showAllPeriodos($this->session->idplantel);
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function showAllGrupos()
    {
        $query = $this->horario->showAllGrupos($this->session->idplantel);
        if ($query) {
            $result['grupos'] = $this->horario->showAllGrupos($this->session->idplantel);
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function showAllMaterias()
    {
        $query = $this->horario->showAllMaterias($this->session->idplantel);
        if ($query) {
            $result['materias'] = $this->horario->showAllMaterias($this->session->idplantel);
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function validate_time($str)
    {
        if ($str != '') {
            $time = preg_match('#^([01]?[0-9]|2[0-3]):[0-5][0-9](:[0-5][0-9])?$#', $str);

            if ($time) {
                return true;
            } else {
                $this->form_validation->set_message('validate_time', 'Formato no valido.');
                return false;
            }
        }
    }

    public function addMateriaHorario()
    {
        if (Permission::grantValidar(uri_string()) == 1) {
            $config = array(
                array(
                    'field' => 'idmateria',
                    'label' => 'Asignatura/Curso',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => '%s es obligatorio.'
                    )
                ),
                array(
                    'field' => 'iddia',
                    'label' => 'Dia',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => '%s es obligatorio.'
                    )
                ),
                array(
                    'field' => 'horainicial',
                    'label' => 'Hora inicial',
                    'rules' => 'trim|required|min_length[3]|max_length[5]|callback_validate_time',
                    'errors' => array(
                        'required' => '%s es obligatorio.'
                    )
                ),
                array(
                    'field' => 'horafinal',
                    'label' => 'Hora final',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => '%s es obligatorio.'
                    )
                ),
                array(
                    'field' => 'urlvideoconferencia',
                    'label' => 'URL Videoconferencia',
                    'rules' => 'trim|valid_url',
                    'errors' => array(
                        'valid_url' => 'Formato de la URL invalido.'
                    )
                ),
                array(
                    'field' => 'numeroanfitrion',
                    'label' => 'Número de anfitrion',
                    'rules' => 'trim|integer',
                    'errors' => array(
                        'integer' => '%s debe  ser número.'
                    )
                )
            );

            $this->form_validation->set_rules($config);
            if ($this->form_validation->run() == FALSE) {
                $result['error'] = true;
                $result['msg'] = array(
                    'idmateria' => form_error('idmateria'),
                    'iddia' => form_error('iddia'),
                    'horainicial' => form_error('horainicial'),
                    'horafinal' => form_error('horafinal'),
                    'urlvideoconferencia' => form_error('urlvideoconferencia'),
                    'numeroanfitrion' => form_error('numeroanfitrion')
                );
            } else {
                $idhorario = $this->input->post('idhorario');
                $detalle_horario = $this->horario->detalleHorario($idhorario);
                $idperiodo = $detalle_horario->idperiodo;
                $idmateria = $this->input->post('idmateria');
                $validar = $this->horario->validadAgregarMateriaHorario($idperiodo, $idmateria, $this->input->post('horainicial'), $this->input->post('horafinal'), $this->input->post('iddia'));
                if ($validar == false) {
                    $data = array(
                        'idhorario' => $this->input->post('idhorario'),
                        'idmateria' => strtoupper($this->input->post('idmateria')),
                        'iddia' => strtoupper($this->input->post('iddia')),
                        'horainicial' => strtoupper($this->input->post('horainicial')),
                        'horafinal' => $this->input->post('horafinal'),
                        'urlvideoconferencia' => $this->input->post('urlvideoconferencia'),
                        'urlvideoconferenciagrabado' => '',
                        'numeroanfitrion' => $this->input->post('numeroanfitrion'),
                        'idusuario' => $this->session->user_id,
                        'fecharegistro' => date('Y-m-d H:i:s')
                    );
                    $this->horario->addMateriaHorario($data);
                } else {
                    $result['error'] = true;
                    $result['msg'] = array(
                        'msgerror' => 'El docente ya esta impartiendo clases a la misma hora y dia en: ' . $validar->nombrenivel . ' ' . $validar->nombregrupo
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

    public function addReceso()
    {
        if (Permission::grantValidar(uri_string()) == 1) {
            $config = array(
                array(
                    'field' => 'titulo',
                    'label' => 'Titulo',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => '%s es obligatorio.'
                    )
                ),
                array(
                    'field' => 'horainicial',
                    'label' => 'Hora inicial',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => '%s es obligatorio.'
                    )
                ),
                array(
                    'field' => 'horafinal',
                    'label' => 'Hora final',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => '%s es obligatorio.'
                    )
                )
            );

            $this->form_validation->set_rules($config);
            if ($this->form_validation->run() == FALSE) {
                $result['error'] = true;
                $result['msg'] = array(
                    'titulo' => form_error('titulo'),
                    'horainicial' => form_error('horainicial'),
                    'horafinal' => form_error('horafinal')
                );
            } else {
                $data = array(
                    'titulo' => strtoupper($this->input->post('titulo')),
                    'idhorario' => $this->input->post('idhorario'),
                    'horainicial' => strtoupper($this->input->post('horainicial')),
                    'horafinal' => $this->input->post('horafinal')
                );
                $this->horario->addReceso($data);
                $result['error'] = false;
                $result['success'] = 'User updated successfully';
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

    public function addHoraSinClases()
    {
        if (Permission::grantValidar(uri_string()) == 1) {
            $config = array(
                array(
                    'field' => 'iddia',
                    'label' => 'Dia',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => '%s es obligatorio.'
                    )
                ),
                array(
                    'field' => 'horainicial',
                    'label' => 'Hora inicial',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => '%s es obligatorio.'
                    )
                ),
                array(
                    'field' => 'horafinal',
                    'label' => 'Hora final',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => '%s es obligatorio.'
                    )
                )
            );

            $this->form_validation->set_rules($config);
            if ($this->form_validation->run() == FALSE) {
                $result['error'] = true;
                $result['msg'] = array(
                    'iddia' => form_error('iddia'),
                    'horainicial' => form_error('horainicial'),
                    'horafinal' => form_error('horafinal')
                );
            } else {
                $data = array(
                    'iddia' => $this->input->post('iddia'),
                    'idhorario' => $this->input->post('idhorario'),
                    'horainicial' => $this->input->post('horainicial'),
                    'horafinal' => $this->input->post('horafinal')
                );
                $this->horario->addHoraSinClase($data);
                $result['error'] = false;
                $result['success'] = 'User updated successfully';
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

    public function updateHoraSinClases()
    {
        if (Permission::grantValidar(uri_string()) == 1) {
            $config = array(
                array(
                    'field' => 'iddia',
                    'label' => 'Titulo',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => '%s es obligatorio.'
                    )
                ),
                array(
                    'field' => 'horainicial',
                    'label' => 'Hora inicial',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => '%s es obligatorio.'
                    )
                ),
                array(
                    'field' => 'horafinal',
                    'label' => 'Hora final',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => '%s es obligatorio.'
                    )
                )
            );

            $this->form_validation->set_rules($config);
            if ($this->form_validation->run() == FALSE) {
                $result['error'] = true;
                $result['msg'] = array(
                    'iddia' => form_error('iddia'),
                    'horainicial' => form_error('horainicial'),
                    'horafinal' => form_error('horafinal')
                );
            } else {
                $id = $this->input->post('idhorariodetalle');
                $data = array(
                    'iddia' => $this->input->post('iddia'),
                    'horainicial' => $this->input->post('horainicial'),
                    'horafinal' => $this->input->post('horafinal')
                );
                $this->horario->updateHoraSinClase($id, $data);
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

    public function addHorario()
    {
        if (Permission::grantValidar(uri_string()) == 1) {
            $config = array(
                array(
                    'field' => 'idperiodo',
                    'label' => 'Periodo Escolar',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => '%s es obligatorio.'
                    )
                ),
                array(
                    'field' => 'idgrupo',
                    'label' => 'Grupo',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => '%s es obligatorio.'
                    )
                )
            );

            $this->form_validation->set_rules($config);
            if ($this->form_validation->run() == FALSE) {
                $result['error'] = true;
                $result['msg'] = array(
                    'idperiodo' => form_error('idperiodo'),
                    'idgrupo' => form_error('idgrupo')
                );
            } else {
                $idperiodo = $this->input->post('idperiodo');
                $idgrupo = $this->input->post('idgrupo');
                $descripcion = $this->input->post('descripcion');
                $validar = $this->horario->validarAddHorario($idperiodo, $idgrupo, $this->session->idplantel);
                if ($validar == FALSE) {
                    $data = array(
                        'idplantel' => $this->session->idplantel,
                        'idperiodo' => $this->input->post('idperiodo'),
                        'idgrupo' => $this->input->post('idgrupo'),
                        'descripcion' => $descripcion,
                        'activo' => 1
                    );
                    $this->horario->addHorario($data);
                } else {
                    $result['error'] = true;
                    $result['msg'] = array(
                        'msgerror' => "EL Horario ya esta registrado para este Ciclo Escolar."
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

    public function updateHorario()
    {
        if (Permission::grantValidar(uri_string()) == 1) {
            $config = array(
                array(
                    'field' => 'idperiodo',
                    'label' => 'Periodo Escolar',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => '%s es obligatorio.'
                    )
                ),
                array(
                    'field' => 'idgrupo',
                    'label' => 'Grupo',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => '%s es obligatorio.'
                    )
                )
            );

            $this->form_validation->set_rules($config);
            if ($this->form_validation->run() == FALSE) {
                $result['error'] = true;
                $result['msg'] = array(
                    'idperiodo' => form_error('idperiodo'),
                    'idgrupo' => form_error('idgrupo')
                );
            } else {
                $id = $this->input->post('idhorario');
                $idgrupo = $this->input->post('idgrupo');
                $idperiodo = $this->input->post('idperiodo');
                $validar = $this->horario->validarUpdateHorario($idperiodo, $idgrupo, $id, $this->session->idplantel);
                if ($validar == FALSE) {
                    $data = array(
                        'idplantel' => $this->session->idplantel,
                        'idperiodo' => $this->input->post('idperiodo'),
                        'idgrupo' => $this->input->post('idgrupo'),
                        'descripcion' => $this->input->post('descripcion'),
                        'activo' => $this->input->post('activo')
                    );
                    $this->horario->updateHorario($id, $data);
                } else {
                    $result['error'] = true;
                    $result['msg'] = array(
                        'msgerror' => "El horario ya esta regisrado."
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

    public function updateMateriaHorario()
    {
        if (Permission::grantValidar(uri_string()) == 1) {
            $config = array(
                array(
                    'field' => 'idmateria',
                    'label' => 'Asignatura/Curso',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => '%s es obligatorio.'
                    )
                ),
                array(
                    'field' => 'iddia',
                    'label' => 'Dia',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => '%s es obligatorio.'
                    )
                ),
                array(
                    'field' => 'horainicial',
                    'label' => 'Hora inicial',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => '%s es obligatorio.'
                    )
                ),
                array(
                    'field' => 'horafinal',
                    'label' => 'Hora final',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => '%s es obligatorio.'
                    )
                ),
                array(
                    'field' => 'urlvideoconferencia',
                    'label' => 'URL Videoconferencia',
                    'rules' => 'trim|valid_url',
                    'errors' => array(
                        'valid_url' => 'Formato de la URL invalido.'
                    )
                ),
                array(
                    'field' => 'numeroanfitrion',
                    'label' => 'Numero anfitrion',
                    'rules' => 'trim|integer',
                    'errors' => array(
                        'integer' => '%s debe ser numero.'
                    )
                )
            );

            $this->form_validation->set_rules($config);
            if ($this->form_validation->run() == FALSE) {
                $result['error'] = true;
                $result['msg'] = array(
                    'idmateria' => form_error('idmateria'),
                    'iddia' => form_error('iddia'),
                    'horainicial' => form_error('horainicial'),
                    'horafinal' => form_error('horafinal'),
                    'urlvideoconferencia' => form_error('urlvideoconferencia'),
                    'numeroanfitrion' => form_error('numeroanfitrion')
                );
            } else {
                $id = $this->input->post('idhorariodetalle');
                $validar_calificacion = $this->horario->validarCalificacionHorarioDetalle($id);
                $validar_asistencia = $this->horario->validarAsistenciaHorarioDetalle($id);
                $validar_tarea = $this->horario->validarTareaHorarioDetalle($id);
                $validar_mensaje = $this->horario->validarMensajeHorarioDetalle($id);
                if (!$validar_calificacion) {
                    if (!$validar_asistencia) {
                        if (!$validar_tarea) {
                            if (!$validar_mensaje) {
                                $data = array(
                                    'idhorario' => $this->input->post('idhorario'),
                                    'idmateria' => strtoupper($this->input->post('idprofesormateria')),
                                    'iddia' => strtoupper($this->input->post('iddia')),
                                    'horainicial' => strtoupper($this->input->post('horainicial')),
                                    'horafinal' => $this->input->post('horafinal'),
                                    'urlvideoconferencia' => $this->input->post('urlvideoconferencia'),
                                    'numeroanfitrion' => $this->input->post('numeroanfitrion'),
                                    'idusuario' => $this->session->user_id,
                                    'fecharegistro' => date('Y-m-d H:i:s')
                                );

                                $this->horario->updateHorarioMateria($id, $data);
                                $result['error'] = false;
                                $result['success'] = 'User updated successfully';
                            } else {
                                $result['error'] = true;
                                $result['msg'] = array(
                                    'msgerror' => 'No puede modificar, porque existe mensajes registrados.'
                                );
                            }
                        } else {
                            $result['error'] = true;
                            $result['msg'] = array(
                                'msgerror' => 'No puede modificar, porque existe tareas registradas.'
                            );
                        }
                    } else {
                        $result['error'] = true;
                        $result['msg'] = array(
                            'msgerror' => 'No puede modificar, porque existe asistencias registradas.'
                        );
                    }
                } else {
                    $result['error'] = true;
                    $result['msg'] = array(
                        'msgerror' => 'No puede modificar, porque existe calificaciones registradas.'
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

    public function updateReceso()
    {
        if (Permission::grantValidar(uri_string()) == 1) {
            $config = array(
                array(
                    'field' => 'nombreclase',
                    'label' => 'Titulo',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => '%s es obligatorio.'
                    )
                ),
                array(
                    'field' => 'horainicial',
                    'label' => 'Hora inicial',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => '%s es obligatorio.'
                    )
                ),
                array(
                    'field' => 'horafinal',
                    'label' => 'Hora final',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => '%s es obligatorio.'
                    )
                )
            );

            $this->form_validation->set_rules($config);
            if ($this->form_validation->run() == FALSE) {
                $result['error'] = true;
                $result['msg'] = array(
                    'nombreclase' => form_error('nombreclase'),
                    'horainicial' => form_error('horainicial'),
                    'horafinal' => form_error('horafinal')
                );
            } else {
                $id = $this->input->post('idhorariodetalle');
                $data = array(
                    'titulo' => strtoupper($this->input->post('nombreclase')),
                    'horainicial' => strtoupper($this->input->post('horainicial')),
                    'horafinal' => $this->input->post('horafinal')
                );
                $this->horario->updateReceso($id, $data);
                $result['error'] = false;
                $result['success'] = 'User updated successfully';
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

    public function deleteHorarioMateria()
    {
        if (Permission::grantValidar(uri_string()) == 1) {
            $id = $this->input->get('id');
            $query = $this->horario->deleteHorarioMateria($id);
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

    public function deleteReceso()
    {
        if (Permission::grantValidar(uri_string()) == 1) {
            $id = $this->input->get('id');
            $query = $this->horario->deleteReceso($id);
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

    public function deleteHorario()
    {
        if (Permission::grantValidar(uri_string()) == 1) {
            $idhorario = $this->input->get('idhorario');
            $query = $this->horario->deleteHorario($idhorario);
            if ($query) {
                $result['horarios'] = true;
            }
        } else {
            $result['horarios'] = false;
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function deleteSinClases()
    {
        if (Permission::grantValidar(uri_string()) == 1) {
            $id = $this->input->get('id');
            $query = $this->horario->deleteSinClases($id);
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
}
