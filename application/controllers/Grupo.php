<?php

defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("America/Mexico_City");

class Grupo extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        if (!isset($_SESSION['user_id'])) {
            $this->session->set_flashdata('flash_data', 'You don\'t have access! ss');
            return redirect('welcome');
        }
        $this->load->helper('url');
        $this->load->model('Grupo_model', 'grupo');
        $this->load->model('Alumno_model', 'alumno');
        $this->load->model('data_model');
        $this->load->library('permission');
        $this->load->library('session');
        $this->load->library('pdfgenerator');
    }

    public function inicio()
    {
        Permission::grant(uri_string());
        $this->load->view('admin/header');
        $this->load->view('admin/grupo/index');
        $this->load->view('admin/footer');
    }

    public function alumnos()
    {
        Permission::grant(uri_string());
        $idplantel = $this->session->idplantel;
        $periodos = $this->grupo->showAllPeriodos($idplantel);
        $grupos = $this->grupo->showAllGrupos($idplantel);
        $oportunidades = $this->grupo->showAllOportunidadesExamen($idplantel);
        $data = array(
            'periodos' => $periodos,
            'grupos' => $grupos,
            'oportunidades' => $oportunidades
        );
        $this->load->view('admin/header');
        $this->load->view('admin/grupo/alumnos', $data);
        $this->load->view('admin/footer');
    }

    public function showAllEspecialidades()
    {
        //Permission::grant(uri_string()); 
        $idplantel = $this->session->idplantel;
        $query = $this->alumno->showAllEspecialidades($idplantel);

        if ($query) {
            $result['especialidades'] = $this->alumno->showAllEspecialidades($idplantel);
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function searchGrupo()
    {
        //ermission::grant(uri_string());
        $idplantel = $this->session->idplantel;
        $value = $this->input->post('text');
        $query = $this->grupo->searchGrupo($value, $idplantel);
        if ($query) {
            $result['grupos'] = $query;
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function showAll()
    {
        //Permission::grant(uri_string());
        $idplantel = $this->session->idplantel;
        $query = $this->grupo->showAllGrupos($idplantel);
        //var_dump($query);
        if ($query) {
            $result['grupos'] = $this->grupo->showAllGrupos($idplantel);
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function showAllNiveles()
    {
        //Permission::grant(uri_string());

        $query = $this->grupo->showAllNiveles();
        //var_dump($query);
        if ($query) {
            $result['niveles'] = $this->grupo->showAllNiveles();
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function showAllTurnos()
    {
        //Permission::grant(uri_string());
        $query = $this->grupo->showAllTurnos();
        //var_dump($query);
        if ($query) {
            $result['turnos'] = $this->grupo->showAllTurnos();
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function addGrupo()
    {
        if (Permission::grantValidar(uri_string()) == 1) {
            $config = array(
                array(
                    'field' => 'idespecialidad',
                    'label' => 'Especialidad',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => '%s es obligatorio.'
                    )
                ),
                array(
                    'field' => 'idnivelestudio',
                    'label' => 'Nivel Escolar',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => '%s es obligatorio.'
                    )
                ),
                array(
                    'field' => 'idturno',
                    'label' => 'Turno',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => '%s es obligatorio.'
                    )
                ),
                array(
                    'field' => 'nombregrupo',
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
                    'idnivelestudio' => form_error('idnivelestudio'),
                    'idespecialidad' => form_error('idespecialidad'),
                    'idturno' => form_error('idturno'),
                    'nombregrupo' => form_error('nombregrupo')
                );
            } else {

                $idnivelestudio = trim($this->input->post('idnivelestudio'));
                $idturno = trim($this->input->post('idturno'));
                $nombregrupo = trim($this->input->post('nombregrupo'));
                $validar = $this->grupo->validarAddGrupo($idnivelestudio, $idturno, $nombregrupo, $this->session->idplantel);
                if ($validar == FALSE) {
                    $data = array(
                        'idespecialidad' => $this->input->post('idespecialidad'),
                        'idplantel' => $this->session->idplantel,
                        'idnivelestudio' => $this->input->post('idnivelestudio'),
                        'idturno' => $this->input->post('idturno'),
                        'nombregrupo' => strtoupper($this->input->post('nombregrupo')),
                        'idusuario' => $this->session->user_id,
                        'fecharegistro' => date('Y-m-d H:i:s')
                    );
                    $this->grupo->addGrupo($data);
                } else {
                    $result['error'] = true;
                    $result['msg'] = array(
                        'msgerror' => 'Ya esta registrado el Grupo.'
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

    public function updateGrupo()
    {
        if (Permission::grantValidar(uri_string()) == 1) {
            $config = array(
                array(
                    'field' => 'idespecialidad',
                    'label' => 'Especialidad',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => '%s es obligatorio.'
                    )
                ),
                array(
                    'field' => 'idnivelestudio',
                    'label' => 'Nivel Escolar',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => '%s es obligatorio.'
                    )
                ),
                array(
                    'field' => 'idturno',
                    'label' => 'Turno',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => '%s es obligatorio.'
                    )
                ),
                array(
                    'field' => 'nombregrupo',
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
                    'idnivelestudio' => form_error('idnivelestudio'),
                    'idespecialidad' => form_error('idespecialidad'),
                    'idturno' => form_error('idturno'),
                    'nombregrupo' => form_error('nombregrupo')
                );
            } else {
                $idgrupo = trim($this->input->post('idgrupo'));
                $idnivelestudio = trim($this->input->post('idnivelestudio'));
                $idturno = trim($this->input->post('idturno'));
                $nombregrupo = trim($this->input->post('nombregrupo'));

                $validar = $this->grupo->validarUpdateGrupo($idnivelestudio, $idturno, $nombregrupo, $idgrupo, $this->session->idplantel);
                if ($validar == FALSE) {
                    $data = array(
                        'idespecialidad' => $this->input->post('idespecialidad'),
                        'idplantel' => $this->session->idplantel,
                        'idnivelestudio' => $this->input->post('idnivelestudio'),
                        'idturno' => $this->input->post('idturno'),
                        'nombregrupo' => strtoupper($this->input->post('nombregrupo')),
                        'idusuario' => $this->session->user_id,
                        'fecharegistro' => date('Y-m-d H:i:s')
                    );
                    $this->grupo->updateGrupo($idgrupo, $data);
                } else {
                    $result['error'] = true;
                    $result['msg'] = array(
                        'msgerror' => 'Ya esta registrado el Grupo.'
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

    public function deleteGrupo()
    {
        if (Permission::grantValidar(uri_string()) == 1) {
            $idgrupo = $this->input->get('idgrupo');
            $query = $this->grupo->deleteGrupo($idgrupo);
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

    public function busqueda($idgrupo, $idperiodo, $opcion)
    {
        $alumnos = "";
        $alumnos_reprobados = "";
        $calificaion_final = "";
        $calificacion_oportunidad = "";
        if ((isset($idgrupo) && !empty($idgrupo)) && (isset($idperiodo) && !empty($idperiodo)) && (isset($opcion) && !empty($opcion))) {
            $idplantel = $this->session->idplantel;
            if ($opcion == 28) {
                //LISTA DE ALUMNOS
                $alumnos = $this->grupo->listaAlumnosGrupo($idperiodo, $idgrupo, $idplantel);
                $alumnos_reprobados = $this->grupo->listaAlumnosGrupoReprobados($idperiodo, $idgrupo, $idplantel);
            } else if ($opcion == 29) {
                $calificaion_final = $this->tablaCalificacionesFinales($idgrupo, $idperiodo);
            } else {
                $calificacion_oportunidad = $this->tablaCalificacionesPorOportunidades($idgrupo, $idperiodo, $opcion);
            }

            $periodos = $this->grupo->showAllPeriodos($idplantel);
            $grupos = $this->grupo->showAllGrupos($idplantel);
            $oportunidades = $this->grupo->showAllOportunidadesExamen($idplantel);
            $data = array(
                'lista_alumnos' => $alumnos,
                'alumnos_reprobados' => $alumnos_reprobados,
                'calificaion_final' => $calificaion_final,
                'calificacion_por_oportunidad' => $calificacion_oportunidad,
                'periodos' => $periodos,
                'grupos' => $grupos,
                'oportunidades' => $oportunidades
            );
            $this->load->view('admin/header');
            $this->load->view('admin/grupo/busqueda', $data);
            $this->load->view('admin/footer');
        }
    }

    public function tablaCalificacionesFinales($idgrupo, $idperiodo)
    {
        $total_materias = 0;
        $materias = $this->grupo->listaMateriasGrupo($idperiodo, $idgrupo);
        //$materias_reprobadas = $this->grupo->listaMateriasReprobadasGrupo($idperiodo, $idgrupo);

        $alumnos = $this->grupo->listaAlumnosGrupo($idperiodo, $idgrupo, $this->session->idplantel);
        $alumnos_reprobados = $this->grupo->listaAlumnosGrupoReprobados($idperiodo, $idgrupo, $this->session->idplantel);
        $tabla = "";
        $tabla .= ' <table  class="tblcalificacionfinal table table-striped dt-responsive nowrap" cellspacing="0" width="100%">
 <caption class="bg-teal"  align="center" > <center><strong>CALIFICACIONES FINALES</strong></center></caption>         
<thead class="bg-teal"> 
      <th>#</th>
      <th></th>
      <th>NOMBRE</th>';
        if (isset($materias) && !empty($materias)) {
            foreach ($materias as $block) :
                $total_materias = $total_materias + 1;
                $tabla .= '<th>' . $block->nombreclase . '</th>';
            endforeach;
        }
        $tabla .= '  <th>PROMEDIO</th>';
        $tabla .= '</thead>';
        $c = 1;
        if (isset($alumnos) && !empty($alumnos)) {
            $suma_calificacion = 0;
            foreach ($alumnos as $row) {
                $tabla .= '<tr>';
                $tabla .= '  <td>' . $c++ . '</td>';
                $tabla .= '  <td>N</td>';
                $tabla .= '<td>' . $row->apellidop . " " . $row->apellidom . " " . $row->nombre . '</td>';
                $suma_calificacion = 0;
                foreach ($materias as $block) {
                    if ($this->grupo->validarMateriaSeriada($block->idmateria, $row->idalumno) == false) {
                        $val = $this->grupo->calificacionFinalNormal($idgrupo, $idperiodo, $block->idprofesormateria, $row->idalumno);
                        $tabla .= '<td>';
                        if ($val != false) {
                            $suma_calificacion = $suma_calificacion + $val[0]->calificacionfinal;
                            $tabla .= '<label>' . $val[0]->calificacionfinal . '</label>';
                        } else {
                            $tabla .= '<label>No registrado</label>';
                        }
                        $tabla .= '</td>';
                    } else {
                        $tabla .= '<td><label>No puede cursar esta materia.</label></td>';
                    }
                }
                $calificacion_alumno = $suma_calificacion / $total_materias;
                $tabla .= '<td>';
                $tabla .= '<label>' . number_format($calificacion_alumno, 2) . '</label>';
                $tabla .= '</td>';

                $tabla .= '</tr>';
            }
        }
        $calificacion_alumno_r = 0;
        if (isset($alumnos_reprobados) && !empty($alumnos_reprobados)) {
            $suma_calificacion_r = 0;
            if (!isset($c) && empty($c)) {
                $c = 1;
            }
            $total_materias_r = 0;
            foreach ($alumnos_reprobados as $value) {
                $tabla .= '<tr>';
                $tabla .= '  <td>' . $c++ . '</td>';
                $tabla .= '  <td>R</td>';
                $tabla .= '<td>' . $value->apellidop . " " . $value->apellidom . " " . $value->nombre . '</td>';
                $suma_calificacion_r = 0;
                $total_materias_r = 0;
                if (isset($materias) && !empty($materias)) {
                    foreach ($materias as $block) {
                        $val = $this->grupo->calificacionFinalReprobadas($idgrupo, $idperiodo, $block->idprofesormateria, $value->idalumno);
                        $tabla .= '<td>';
                        if ($val != false) {
                            $total_materias_r = $total_materias_r + 1;
                            $suma_calificacion_r = $suma_calificacion_r + $val[0]->calificacionfinal;
                            $tabla .= '<label>' . $val[0]->calificacionfinal . '</label>';
                        } else {
                            $tabla .= '<label>---</label>';
                        }
                        $tabla .= '</td>';
                    }
                }

                if ($suma_calificacion_r > 0 && $total_materias_r > 0) {
                    $calificacion_alumno_r = $suma_calificacion_r / $total_materias_r;
                }

                $tabla .= '<td>';
                $tabla .= '<label>' . number_format($calificacion_alumno_r, 2) . '</label>';
                $tabla .= '</td>';

                $tabla .= '</tr>';
            }
        }
        $tabla .= '</table>';
        return $tabla;
    }

    public function tablaCalificacionesPorOportunidades($idgrupo, $idperiodo, $opcion)
    {
        $total_materias = 0;
        $detalle_oportunidad = $this->grupo->detalleOportunidad($opcion);
        $materias = $this->grupo->calificacionPorOportunidad($idgrupo, $idperiodo, '', $opcion, '', 'materias');
        $alumnos = $this->grupo->calificacionPorOportunidad($idgrupo, $idperiodo, '', $opcion, '', 'alumnos');
        $materias_reprobadas = $this->grupo->calificacionPorOportunidad($idgrupo, $idperiodo, '', $opcion, '', 'materias');
        $alumnos_reprobados = $this->grupo->calificacionPorOportunidad($idgrupo, $idperiodo, '', $opcion, '', 'alumnos');
        $tabla = "";
        $tabla .= ' <table  class="tblcalificacionfinal table table-striped dt-responsive nowrap" cellspacing="0" width="100%">
   <caption class="bg-teal"  align="center" > <center><strong>' . $detalle_oportunidad->nombreoportunidad . '</strong></center></caption>     
<thead class="bg-teal"> 
      <th>#</th>
      <th></th>
      <th>NOMBRE</th>';
        if (isset($materias) & !empty($materias)) {
            foreach ($materias as $block) :
                $total_materias = $total_materias + 1;
                $tabla .= '<th>' . $block->nombreclase . '</th>';
            endforeach;
        }
        $tabla .= '</thead>';
        $c = 1;
        if (isset($alumnos) && !empty($alumnos)) {
            $suma_calificacion = 0;
            foreach ($alumnos as $row) {
                $tabla .= '<tr>';
                $tabla .= '  <td>' . $c++ . '</td>';
                $tabla .= '  <td>N</td>';
                $tabla .= '<td>' . $row->apellidop . " " . $row->apellidom . " " . $row->nombre . '</td>';
                $suma_calificacion = 0;
                foreach ($materias as $block) {
                    $val = $this->grupo->calificacionPorOportunidad($idgrupo, $idperiodo, $row->idalumno, $opcion, $block->idprofesormateria, 'calificacion');
                    $tabla .= '<td>';
                    if ($val != false) {
                        $suma_calificacion = $suma_calificacion + $val[0]->calificacion;
                        $tabla .= '<label>' . $val[0]->calificacion . '</label>';
                    } else {
                        $tabla .= '<label>No registrado</label>';
                    }
                    $tabla .= '</td>';
                }

                $tabla .= '</tr>';
            }
        }
        if (isset($alumnos_reprobados) && !empty($alumnos_reprobados)) {
            $suma_calificacion_r = 0;
            if (!isset($c) && empty($c)) {
                $c = 1;
            }
            foreach ($alumnos_reprobados as $value) {
                $tabla .= '<tr>';
                $tabla .= '  <td>' . $c++ . '</td>';
                $tabla .= '  <td>R</td>';
                $tabla .= '<td>' . $value->apellidop . " " . $value->apellidom . " " . $value->nombre . '</td>';

                foreach ($materias_reprobadas as $block) {
                    $val = $this->grupo->calificacionPorOportunidad($idgrupo, $idperiodo, $row->idalumno, $opcion, $block->idprofesormateria, 'calificacion');
                    $tabla .= '<td>';
                    if ($val != false) {

                        $tabla .= '<label>' . $val[0]->calificacion . '</label>';
                    } else {
                        $tabla .= '<label>---</label>';
                    }
                    $tabla .= '</td>';
                }
            }
        }
        $tabla .= '</table>';
        return $tabla;
    }
}
