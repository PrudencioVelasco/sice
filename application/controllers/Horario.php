<?php

defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("America/Mexico_City");

class Horario extends CI_Controller {

    function __construct() {
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

    public function inicio() {
        //Permission::grant(uri_string());
        $this->load->view('admin/header');
        $this->load->view('admin/horario/index');
        $this->load->view('admin/footer');
    }

    public function searchHorario() {
        //Permission::grant(uri_string());
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

    public function showAll() {
        //Permission::grant(uri_string()); 
        $query = $this->horario->showAll($this->session->idplantel);
        //var_dump($query);
        if ($query) {
            $result['horarios'] = $this->horario->showAll($this->session->idplantel);
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function detalle($id) {
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
            'detalle_horario'=>$detalle_horario,
            'activo_ciclo_escolar' => $activo_ciclo_escolar
        );
        $this->load->view('admin/header');
        $this->load->view('admin/horario/detalle', $data);
        $this->load->view('admin/footer');
    }

    public function descargar($idhorario = '') {
        //$idhorario = $this->decode($idhorario);
        //if((isset($idhorario) && !empty($idhorario))){
        $detalle_logo = $this->alumno->logo($this->session->idplantel);
        $logo = base_url() . '/assets/images/escuelas/' . $detalle_logo[0]->logoplantel;
        $logo2 = base_url() . '/assets/images/escuelas/' . $detalle_logo[0]->logosegundo;

        $dias = $this->alumno->showAllDias();
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
          <table width="600" border="0" >
  <tr>
    <td width="101" align="center"><img   class="imgtitle" src="' . $logo2 . '" /></td>
    <td colspan="2" align="center">
            <label class="nombreplantel">' . $detalle_logo[0]->nombreplantel . '</label><br>
            <label class="txtn">' . $detalle_logo[0]->asociado . '</label><br>
            <label class="direccion">' . $detalle_logo[0]->direccion . '</label><br>
            <label class="telefono">TELÉFONO: ' . $detalle_logo[0]->telefono . '</label>
    </td>
    <td width="137" align="center"><img   class="imgtitle" src="' . $logo . '" /></td>
  </tr> 
 
  </table> <br/>';


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


        $pdf->Output('Kardex de Calificaciones', 'I');
    }

    public function showAllDiaHorario($idhorario, $iddia) {
        //Permission::grant(uri_string()); 
        $query = $this->horario->showAllDiaHorario($idhorario, $iddia);
        //var_dump($query);
        if ($query) {
            $result['horarios'] = $this->horario->showAllDiaHorario($idhorario, $iddia);
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function showAllDias() {
        //Permission::grant(uri_string()); 
        $query = $this->horario->showAllDias();
        //var_dump($query);
        if ($query) {
            $result['dias'] = $this->horario->showAllDias();
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function showAllPeriodos() {
        //Permission::grant(uri_string());
        $query = $this->horario->showAllPeriodos($this->session->idplantel);
        if ($query) {
            $result['periodos'] = $this->horario->showAllPeriodos($this->session->idplantel);
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function showAllGrupos() {
        //Permission::grant(uri_string());
        $query = $this->horario->showAllGrupos($this->session->idplantel);
        if ($query) {
            $result['grupos'] = $this->horario->showAllGrupos($this->session->idplantel);
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function showAllMaterias() {
        //Permission::grant(uri_string()); 
        $query = $this->horario->showAllMaterias($this->session->idplantel);
        //var_dump($query);
        if ($query) {
            $result['materias'] = $this->horario->showAllMaterias($this->session->idplantel);
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function validate_time($str) {
        if ($str != '') {
            $time = preg_match('#^([01]?[0-9]|2[0-3]):[0-5][0-9](:[0-5][0-9])?$#', $str);

            if ($time) {
                return true;
            } else {
                $this->form_validation->set_message(
                        'validate_time',
                        'Formato no valido.'
                );
                return false;
            }
        }
    }

    public function addMateriaHorario() {
        if (Permission::grantValidar(uri_string()) == 1) {
            $config = array(
                array(
                    'field' => 'idmateria',
                    'label' => 'Materia',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => 'Campo obligatorio.'
                    )
                ),
                array(
                    'field' => 'iddia',
                    'label' => 'Dia',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => 'Campo obligatorio.'
                    )
                ),
                array(
                    'field' => 'horainicial',
                    'label' => 'Hora inicial',
                    'rules' => 'trim|required|min_length[3]|max_length[5]|callback_validate_time',
                    'errors' => array(
                        'required' => 'Campo obligatorio.'
                    )
                ),
                array(
                    'field' => 'horafinal',
                    'label' => 'Hora final',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => 'Campo obligatorio.'
                    )
                ),
                array(
                    'field' => 'urlvideoconferencia',
                    'label' => 'URL Videoconferencia',
                    'rules' => 'trim|valid_url',
                    'errors' => array(
                        'valid_url' => 'Formato de la URL invalido.'
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
                    'urlvideoconferencia' => form_error('urlvideoconferencia')
                );
            } else {

                $data = array(
                    'idhorario' => $this->input->post('idhorario'),
                    'idmateria' => strtoupper($this->input->post('idmateria')),
                    'iddia' => strtoupper($this->input->post('iddia')),
                    'horainicial' => strtoupper($this->input->post('horainicial')),
                    'horafinal' => $this->input->post('horafinal'),
                    'urlvideoconferencia' => $this->input->post('urlvideoconferencia'),
                    'idusuario' => $this->session->user_id,
                    'fecharegistro' => date('Y-m-d H:i:s')
                );
                $this->horario->addMateriaHorario($data);
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

    public function addReceso() {
        if (Permission::grantValidar(uri_string()) == 1) {
            $config = array(
                array(
                    'field' => 'titulo',
                    'label' => 'Titulo',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => 'Campo obligatorio.'
                    )
                ),
                array(
                    'field' => 'horainicial',
                    'label' => 'Hora inicial',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => 'Campo obligatorio.'
                    )
                ),
                array(
                    'field' => 'horafinal',
                    'label' => 'Hora final',
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

    public function addHoraSinClases() {
        if (Permission::grantValidar(uri_string()) == 1) {
            $config = array(
                array(
                    'field' => 'iddia',
                    'label' => 'Titulo',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => 'Campo obligatorio.'
                    )
                ),
                array(
                    'field' => 'horainicial',
                    'label' => 'Hora inicial',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => 'Campo obligatorio.'
                    )
                ),
                array(
                    'field' => 'horafinal',
                    'label' => 'Hora final',
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

    public function updateHoraSinClases() {
        if (Permission::grantValidar(uri_string()) == 1) {
            $config = array(
                array(
                    'field' => 'iddia',
                    'label' => 'Titulo',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => 'Campo obligatorio.'
                    )
                ),
                array(
                    'field' => 'horainicial',
                    'label' => 'Hora inicial',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => 'Campo obligatorio.'
                    )
                ),
                array(
                    'field' => 'horafinal',
                    'label' => 'Hora final',
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

    public function addHorario() {
        if (Permission::grantValidar(uri_string()) == 1) {
            $config = array(
                array(
                    'field' => 'idperiodo',
                    'label' => 'Periodo',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => 'Campo obligatorio.'
                    )
                ),
                array(
                    'field' => 'idgrupo',
                    'label' => 'Grupo',
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
                    'idperiodo' => form_error('idperiodo'),
                    'idgrupo' => form_error('idgrupo')
                );
            } else {
                $idperiodo = $this->input->post('idperiodo');
                $idgrupo = $this->input->post('idgrupo');
                $validar = $this->horario->validarAddHorario($idperiodo, $idgrupo, $this->session->idplantel);
                if ($validar == FALSE) {
                    $data = array(
                        'idplantel' => $this->session->idplantel,
                        'idperiodo' => $this->input->post('idperiodo'),
                        'idgrupo' => $this->input->post('idgrupo'),
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

    public function updateHorario() {
        if (Permission::grantValidar(uri_string()) == 1) {
            $config = array(
                array(
                    'field' => 'idperiodo',
                    'label' => 'Periodo',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => 'Campo obligatorio.'
                    )
                ),
                array(
                    'field' => 'idgrupo',
                    'label' => 'Grupo',
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

    public function updateMateriaHorario() {
        if (Permission::grantValidar(uri_string()) == 1) {
            $config = array(
                array(
                    'field' => 'idmateria',
                    'label' => 'Materia',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => 'Campo obligatorio.'
                    )
                ),
                array(
                    'field' => 'iddia',
                    'label' => 'Dia',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => 'Campo obligatorio.'
                    )
                ),
                array(
                    'field' => 'horainicial',
                    'label' => 'Hora inicial',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => 'Campo obligatorio.'
                    )
                ),
                array(
                    'field' => 'horafinal',
                    'label' => 'Hora final',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => 'Campo obligatorio.'
                    )
                ),
                array(
                    'field' => 'urlvideoconferencia',
                    'label' => 'URL Videoconferencia',
                    'rules' => 'trim|valid_url',
                    'errors' => array(
                        'valid_url' => 'Formato de la URL invalido.'
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
                    'urlvideoconferencia' => form_error('urlvideoconferencia')
                );
            } else {
                $id = $this->input->post('idhorariodetalle');
                $data = array(
                    'idhorario' => $this->input->post('idhorario'),
                    'idmateria' => strtoupper($this->input->post('idprofesormateria')),
                    'iddia' => strtoupper($this->input->post('iddia')),
                    'horainicial' => strtoupper($this->input->post('horainicial')),
                    'horafinal' => $this->input->post('horafinal'),
                    'urlvideoconferencia' => $this->input->post('urlvideoconferencia'),
                    'idusuario' => $this->session->user_id,
                    'fecharegistro' => date('Y-m-d H:i:s')
                );
                $this->horario->updateHorarioMateria($id, $data);
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

    public function updateReceso() {
        if (Permission::grantValidar(uri_string()) == 1) {
            $config = array(
                array(
                    'field' => 'nombreclase',
                    'label' => 'Titulo',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => 'Campo obligatorio.'
                    )
                ),
                array(
                    'field' => 'horainicial',
                    'label' => 'Hora inicial',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => 'Campo obligatorio.'
                    )
                ),
                array(
                    'field' => 'horafinal',
                    'label' => 'Hora final',
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

    public function deleteHorarioMateria() {
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

    public function deleteReceso() {
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

    public function deleteHorario() {
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

    public function deleteSinClases() {
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
