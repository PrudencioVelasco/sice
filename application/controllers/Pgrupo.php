<?php

defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("America/Mexico_City");

class pGrupo extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!isset($_SESSION['user_id'])) {
            $this->session->set_flashdata('flash_data', 'You don\'t have access! ss');
            return redirect('welcome');
        }
        $this->load->helper('url');
        $this->load->library('permission');
        $this->load->library('session');
        $this->load->model('grupo_model', 'grupo');
        $this->load->model('tarea_model', 'tarea');
        $this->load->model('mensaje_model', 'mensaje');
        $this->load->library('encryption');
        $this->load->helper('numeroatexto_helper');
        $this->load->model('configuracion_model', 'configuracion');
        $this->load->model('horario_model', 'horario');
        $this->load->library('excel');
        date_default_timezone_set("America/Mexico_City");
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
        # code...
        Permission::grant(uri_string());

        $result = $this->grupo->showAllGruposProfesor($this->session->idprofesor);
        $unidades = $this->grupo->unidades();

        $data = array(
            'datos' => $result,
            'grupos' => $result,
            'unidades' => $unidades,
            'controller' => $this,
        );
        $this->load->view('docente/header');
        $this->load->view('docente/grupo/index', $data);
        $this->load->view('docente/footer');
    }

    public function buscarAsistencia($idhorario, $idhorariodetalle, $fechainicio, $fechafin, $idunidad) {
        # code...
        Permission::grant(uri_string());
        $idhorario = $this->decode($idhorario);
        //$idunidad = $this->input->post('unidad');
        $idhorariodetalle = $this->decode($idhorariodetalle);
        //$fechainicio = $this->input->post('fechainicio');
        //$fechafin = $this->input->post('fechafin');
        if ((isset($idhorario) && !empty($idhorario)) &&
                (isset($idhorario) && !empty($idhorario)) &&
                (isset($fechainicio) && !empty($fechainicio)) &&
                (isset($fechafin) && !empty($fechafin))
        ) {
            $detalle_horario = $this->grupo->detalleHorarioDetalle($idhorariodetalle);
            $idprofesormateria = $detalle_horario->idprofesormateria;
            $idmateria = $detalle_horario->idmateria;
            $alumns = $this->grupo->alumnosGrupo($idhorario, $idprofesormateria, $idmateria);
            $tabla = "";
            if ($alumns != false) {
                $range = ((strtotime($fechafin) - strtotime($fechainicio)) + (24 * 60 * 60)) / (24 * 60 * 60);
                //$range= ((strtotime($_GET["finish_at"])-strtotime($_GET["start_at"]))+(24*60*60)) /(24*60*60);

                $tabla .= '  <table id="tablageneral2" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
            <thead class="bg-teal">
            <th>#</th>
            <th>ALUMNO</th>';
                for ($i = 0; $i < $range; $i++):
                    setlocale(LC_ALL, 'es_ES');
                    $fecha = strftime("%A, %d de %B", strtotime($fechainicio) + ($i * (24 * 60 * 60)));
                    $domingo = date('N', strtotime($fechainicio) + ($i * (24 * 60 * 60)));
                    if ($domingo != '7') {
                        if ($domingo != '6') {
                            $tabla .= '<th>' . utf8_encode($fecha) . '</th>';
                        }
                    }
                    //echo date("d-M",strtotime($_GET["start_at"])+($i*(24*60*60)));
                endfor;
                $tabla .= '</thead>';
                $n = 1;
                foreach ($alumns as $alumn) {
                    $tabla .= ' <tr>';
                    $tabla .= '<td>' . $n++ . '</td>';
                    $tabla .= '<td >' . $alumn->apellidop . " " . $alumn->apellidom . " " . $alumn->nombre . '</td>';
                    for ($i = 0; $i < $range; $i++):
                        $date_at = date("Y-m-d", strtotime($fechainicio) + ($i * (24 * 60 * 60)));
                        // $asist = AssistanceData::getByATD($alumn->id,$_GET["team_id"],$date_at);
                        $asist = $this->grupo->listaAsistencia($alumn->idalumno, $idhorario, $date_at, $idhorariodetalle, $idunidad);
                        $domingo = date('N', strtotime($fechainicio) + ($i * (24 * 60 * 60)));

                        if ($domingo != '7') {
                            if ($domingo != '6') {
                                $tabla .= '<td>';
                                if ($asist != false) {
                                    switch ($asist->idmotivo) {
                                        case 1:
                                            # code...
                                            $tabla .= '<span class="label label-success">' . $asist->nombremotivo . '</span>';
                                            $tabla .= '  <a  href="javascript:void(0)"><i class="fa fa-pencil edit_button"  data-toggle="modal" data-target="#myModal"
				                                data-idasistencia="' . $asist->idasistencia . '"
				                                data-idmotivo="' . $asist->idmotivo . '"
				                                data-alumno="' . $alumn->apellidop . " " . $alumn->apellidom . " " . $alumn->nombre . '"
				                               style = "color:blue;" title="Editar Calificación"></i> </a>';
                                            /* $tabla .=' <a  href="javascript:void(0)"><i class="fa fa-trash delete_button"  data-toggle="modal" data-target="#myModalDelete"
                                              data-idasistencia="'.$asist->idasistencia.'"
                                              data-idmotivo="'.$asist->idmotivo.'"
                                              data-alumno="'.$alumn->apellidop." ".$alumn->apellidom." ".$alumn->nombre.'"
                                              style = "color:red;" title="Eliminar Calificación"></i> </a>'; */
                                            break;
                                        case 2:
                                            $tabla .= '<span class="label label-warning">' . $asist->nombremotivo . '</span>';
                                            $tabla .= '  <a  href="javascript:void(0)"><i class="fa fa-pencil edit_button"  data-toggle="modal" data-target="#myModal"
				                                  data-idasistencia="' . $asist->idasistencia . '"
				                                  data-idmotivo="' . $asist->idmotivo . '"
				                                  data-alumno="' . $alumn->apellidop . " " . $alumn->apellidom . " " . $alumn->nombre . '"
				                                 style = "color:blue;" title="Editar Calificación"></i> </a>';
                                            /* $tabla .=' <a  href="javascript:void(0)"><i class="fa fa-trash delete_button"  data-toggle="modal" data-target="#myModalDelete"
                                              data-idasistencia="'.$asist->idasistencia.'"
                                              data-idmotivo="'.$asist->idmotivo.'"
                                              data-alumno="'.$alumn->apellidop." ".$alumn->apellidom." ".$alumn->nombre.'"
                                              style = "color:red;" title="Eliminar Calificación"></i> </a>'; */
                                            # code...
                                            break;
                                        case 3:
                                            $tabla .= '<span class="label label-info">' . $asist->nombremotivo . '</span>';
                                            $tabla .= '  <a  href="javascript:void(0)"><i class="fa fa-pencil edit_button"  data-toggle="modal" data-target="#myModal"
				                                  data-idasistencia="' . $asist->idasistencia . '"
				                                  data-idmotivo="' . $asist->idmotivo . '"
				                                  data-alumno="' . $alumn->apellidop . " " . $alumn->apellidom . " " . $alumn->nombre . '"
				                                 style = "color:blue;" title="Editar Calificación"></i> </a>';
                                            /* $tabla .=' <a  href="javascript:void(0)"><i class="fa fa-trash delete_button"  data-toggle="modal" data-target="#myModalDelete"
                                              data-idasistencia="'.$asist->idasistencia.'"
                                              data-idmotivo="'.$asist->idmotivo.'"
                                              data-alumno="'.$alumn->apellidop." ".$alumn->apellidom." ".$alumn->nombre.'"
                                              style = "color:red;" title="Eliminar Calificación"></i> </a>'; */
                                            # code...
                                            break;
                                        case 4:
                                            $tabla .= '<span class="label label-danger">' . $asist->nombremotivo . '</span>';
                                            $tabla .= '  <a  href="javascript:void(0)"><i class="fa fa-pencil edit_button"  data-toggle="modal" data-target="#myModal"
				                                  data-idasistencia="' . $asist->idasistencia . '"
				                                  data-idmotivo="' . $asist->idmotivo . '"
				                                  data-alumno="' . $alumn->apellidop . " " . $alumn->apellidom . " " . $alumn->nombre . '"
				                                 style = "color:blue;" title="Editar Calificación"></i> </a>';
                                            /* $tabla .=' <a  href="javascript:void(0)"><i class="fa fa-trash delete_button"  data-toggle="modal" data-target="#myModalDelete"
                                              data-idasistencia="'.$asist->idasistencia.'"
                                              data-idmotivo="'.$asist->idmotivo.'"
                                              data-alumno="'.$alumn->apellidop." ".$alumn->apellidom." ".$alumn->nombre.'"
                                              style = "color:red;" title="Eliminar Calificación"></i> </a>'; */
                                            # code...
                                            break;

                                        default:
                                            # code...
                                            break;
                                    }
                                } else {
                                    $tabla .= "No registrado";
                                }

                                $tabla .= '</td>';
                            }
                        }
                    endfor;
                    $tabla .= '</tr>';
                }
                $tabla .= '</table>';
            }
            $unidades = $this->grupo->unidades($this->session->idplantel);
            $motivo = $this->grupo->motivoAsistencia();
            $detalle = $this->grupo->detalleClase($idhorariodetalle);
            $nombreclase = $detalle[0]->nombreclase;
            $detalle_horario = $this->grupo->detalleHorarioDetalle($idhorariodetalle);
            $idprofesormateria = $detalle_horario->idprofesormateria;
            $idmateria = $detalle_horario->idmateria;
            $alumns = $this->grupo->alumnosGrupo($idhorario, $idprofesormateria, $idmateria);
            $data = array(
                'alumnos' => $alumns,
                'motivo' => $motivo,
                'idhorario' => $idhorario,
                'idhorariodetalle' => $idhorariodetalle,
                'tabla' => $tabla,
                'nombreclase' => $nombreclase,
                'unidades' => $unidades,
                'controller' => $this,
            );
            $this->load->view('docente/header');
            $this->load->view('docente/grupo/busqueda_asistencia', $data);
            $this->load->view('docente/footer');
        } else {
            $data = array(
                'heading' => 'Error',
                'message' => 'Intente mas tarde.',
            );
            $this->load->view('docente/header');
            $this->load->view('docente/error/general', $data);
            $this->load->view('docente/footer');
        }
    }

    public function obetnerAsistencia($idhorario, $fechainicio, $fechafin, $idhorariodetalle) {
        Permission::grant(uri_string());
        $detalle_horario = $this->grupo->detalleHorarioDetalle($idhorariodetalle);
        $idprofesormateria = $detalle_horario->idprofesormateria;
        $idmateria = $detalle_horario->idmateria;
        $alumns = $this->grupo->alumnosGrupo($idhorario, $idprofesormateria, $idmateria);
        $tabla = "";

        if ($alumns != false) {
            $range = ((strtotime($fechafin) - strtotime($fechainicio)) + (24 * 60 * 60)) / (24 * 60 * 60);
            //$range= ((strtotime($_GET["finish_at"])-strtotime($_GET["start_at"]))+(24*60*60)) /(24*60*60);

            $tabla .= '  <table id="tablageneral2" class="table table-striped  dt-responsive nowrap" cellspacing="0" width="100%">
            <thead class="bg-teal">
            <th>#</th>
            <th>ALUMNO</th>';
            for ($i = 0; $i < $range; $i++):
                setlocale(LC_ALL, 'es_ES');
                $fecha = strftime("%A, %d de %B", strtotime($fechainicio) + ($i * (24 * 60 * 60)));

                $domingo = date('N', strtotime($fechainicio) + ($i * (24 * 60 * 60)));
                if ($domingo != '7') {
                    if ($domingo != '6') {
                        $tabla .= '<th>' . utf8_encode($fecha) . '</th>';
                    }
                }
                //echo date("d-M",strtotime($_GET["start_at"])+($i*(24*60*60)));
            endfor;
            $tabla .= '</thead>';
            $n = 1;
            foreach ($alumns as $alumn) {
                $tabla .= ' <tr>';
                $tabla .= '<td>' . $n++ . '</td>';
                $tabla .= '<td >' . $alumn->apellidop . " " . $alumn->apellidom . " " . $alumn->nombre . '</td>';
                for ($i = 0; $i < $range; $i++):
                    $date_at = date("Y-m-d", strtotime($fechainicio) + ($i * (24 * 60 * 60)));
                    // $asist = AssistanceData::getByATD($alumn->id,$_GET["team_id"],$date_at);
                    $asist = $this->grupo->listaAsistencia($alumn->idalumno, $idhorario, $date_at, $idhorariodetalle);

                    $domingo = date('N', strtotime($fechainicio) + ($i * (24 * 60 * 60)));

                    if ($domingo != '7') {
                        if ($domingo != '6') {

                            $tabla .= '<td>';
                            if ($asist != false) {
                                switch ($asist->idmotivo) {
                                    case 1:
                                        # code...
                                        $tabla .= '<span class="label label-success">' . $asist->nombremotivo . '</span>';

                                        $tabla .= '  <a  href="javascript:void(0)"><i class="fa fa-pencil edit_button"  data-toggle="modal" data-target="#myModal"
				                                data-idasistencia="' . $asist->idasistencia . '"
				                                data-idmotivo="' . $asist->idmotivo . '"
				                                data-alumno="' . $alumn->apellidop . " " . $alumn->apellidom . " " . $alumn->nombre . '"
				                               style = "color:blue;" title="Editar Calificación"></i> </a>';
                                        /* $tabla .=' <a  href="javascript:void(0)"><i class="fa fa-trash delete_button"  data-toggle="modal" data-target="#myModalDelete"
                                          data-idasistencia="'.$asist->idasistencia.'"
                                          data-idmotivo="'.$asist->idmotivo.'"
                                          data-alumno="'.$alumn->apellidop." ".$alumn->apellidom." ".$alumn->nombre.'"
                                          style = "color:red;" title="Eliminar Calificación"></i> </a>'; */

                                        break;
                                    case 2:
                                        $tabla .= '<span class="label label-warning">' . $asist->nombremotivo . '</span>';
                                        $tabla .= '  <a  href="javascript:void(0)"><i class="fa fa-pencil edit_button"  data-toggle="modal" data-target="#myModal"
				                                  data-idasistencia="' . $asist->idasistencia . '"
				                                  data-idmotivo="' . $asist->idmotivo . '"
				                                  data-alumno="' . $alumn->apellidop . " " . $alumn->apellidom . " " . $alumn->nombre . '"
				                                 style = "color:blue;" title="Editar Calificación"></i> </a>';
                                        /* $tabla .=' <a  href="javascript:void(0)"><i class="fa fa-trash delete_button"  data-toggle="modal" data-target="#myModalDelete"
                                          data-idasistencia="'.$asist->idasistencia.'"
                                          data-idmotivo="'.$asist->idmotivo.'"
                                          data-alumno="'.$alumn->apellidop." ".$alumn->apellidom." ".$alumn->nombre.'"
                                          style = "color:red;" title="Eliminar Calificación"></i> </a>'; */
                                        # code...
                                        break;
                                    case 3:
                                        $tabla .= '<span class="label label-info">' . $asist->nombremotivo . '</span>';

                                        $tabla .= '  <a  href="javascript:void(0)"><i class="fa fa-pencil edit_button"  data-toggle="modal" data-target="#myModal"
				                                  data-idasistencia="' . $asist->idasistencia . '"
				                                  data-idmotivo="' . $asist->idmotivo . '"
				                                  data-alumno="' . $alumn->apellidop . " " . $alumn->apellidom . " " . $alumn->nombre . '"
				                                 style = "color:blue;" title="Editar Calificación"></i> </a>';
                                        /* $tabla .=' <a  href="javascript:void(0)"><i class="fa fa-trash delete_button"  data-toggle="modal" data-target="#myModalDelete"
                                          data-idasistencia="'.$asist->idasistencia.'"
                                          data-idmotivo="'.$asist->idmotivo.'"
                                          data-alumno="'.$alumn->apellidop." ".$alumn->apellidom." ".$alumn->nombre.'"
                                          style = "color:red;" title="Eliminar Calificación"></i> </a>'; */
                                        # code...
                                        break;
                                    case 4:
                                        $tabla .= '<span class="label label-danger">' . $asist->nombremotivo . '</span>';
                                        $tabla .= '  <a  href="javascript:void(0)"><i class="fa fa-pencil edit_button"  data-toggle="modal" data-target="#myModal"
				                                  data-idasistencia="' . $asist->idasistencia . '"
				                                  data-idmotivo="' . $asist->idmotivo . '"
				                                  data-alumno="' . $alumn->apellidop . " " . $alumn->apellidom . " " . $alumn->nombre . '"
				                                 style = "color:blue;" title="Editar Calificación"></i> </a>';
                                        /* $tabla .=' <a  href="javascript:void(0)"><i class="fa fa-trash delete_button"  data-toggle="modal" data-target="#myModalDelete"
                                          data-idasistencia="'.$asist->idasistencia.'"
                                          data-idmotivo="'.$asist->idmotivo.'"
                                          data-alumno="'.$alumn->apellidop." ".$alumn->apellidom." ".$alumn->nombre.'"
                                          style = "color:red;" title="Eliminar Calificación"></i> </a>'; */
                                        # code...
                                        break;

                                    default:
                                        # code...
                                        break;
                                }
                            } else {
                                $tabla .= "No registrado";
                            }

                            $tabla .= '</td>';
                        }
                    }
                endfor;
                $tabla .= '</tr>';
            }
            $tabla .= '</table>';
        }
        return $tabla;
    }

    public function obtenerCalificacion($idhorario = '', $idhorariodetalle) {
        # code...

        Permission::grant(uri_string());
        $unidades = $this->grupo->unidades($this->session->idplantel);
        $detalle_horario = $this->grupo->detalleHorarioDetalle($idhorariodetalle);
        $idprofesormateria = $detalle_horario->idprofesormateria;
        $idmateria = $detalle_horario->idmateria;
        $alumnos = $this->grupo->alumnosGrupo($idhorario, $idprofesormateria, $idmateria);
        $datoshorario = $this->horario->showNivelGrupo($idhorario);

        $idnivelestudio = $datoshorario->idnivelestudio;
        $detalle_configuracion = $this->configuracion->showAllConfiguracion($this->session->idplantel, $idnivelestudio);
        $tabla = "";
        $tabla .= ' <table id="tablageneral2" class="table table-striped dt-responsive nowrap" cellspacing="0" width="100%">
      <thead class="bg-teal">
      <th>#</th>
      <th>NOMBRE</th>';
        foreach ($unidades as $block):
            $tabla .= '<th>' . $block->nombreunidad . '</th>';
        endforeach;
        $tabla .= '<th>C. FINAL</th>';
        $tabla .= '</thead>';
        $c = 1;
        $total_unidades = 0;
        if (isset($alumnos) && !empty($alumnos)) {
            foreach ($alumnos as $row) {
                $tabla .= '<tr>';
                $tabla .= '  <td>' . $c++ . '</td>';
                if ($row->opcion == 0) {
                    $tabla .= '<td><label style="color:red;">R:</label> ' . $row->apellidop . " " . $row->apellidom . " " . $row->nombre . '</td>';
                } else {
                    $tabla .= '<td>' . $row->apellidop . " " . $row->apellidom . " " . $row->nombre . '</td>';
                }
                $suma_calificacion = 0;
                $total_unidades = 0;
                foreach ($unidades as $block):
                    // $suma_calificacion = 0;
                    $total_unidades += 1;
                    $val = $this->grupo->obtenerCalificacion($row->idalumno, $block->idunidad, $idhorariodetalle);
                    $tabla .= '<td>';
                    if ($val != false) {
                        $suma_calificacion = $suma_calificacion + $val->calificacion;
                        $tabla .= '<label>' . $val->calificacion . '  </label>';
                        $fecha_inicio = date('Y-m-d');
                        $fecha_fin = date('Y-m-d', strtotime($val->fecharegistro));
                        $total_dias = dias_pasados($fecha_inicio, $fecha_fin);
                        if ($total_dias <= 3) {
                            $tabla .= '  <a  href="javascript:void(0)"><i class="fa fa-pencil edit_button"  data-toggle="modal" data-target="#myModal"
				                                data-idcalificacion="' . $val->idcalificacion . '"
				                                data-calificacion="' . $val->calificacion . '"
				                                data-alumno="' . $row->apellidop . " " . $row->apellidom . " " . $row->nombre . '"
			                                   style = "color:blue;" title="Editar Calificación"></i> </a>';
                            $tabla .= '  <a  href="javascript:void(0)"><i class="fa fa-trash delete_button"  data-toggle="modal" data-target="#myModalDelete"
				                                data-idcalificacion="' . $val->idcalificacion . '"
				                                data-alumno="' . $row->apellidop . " " . $row->apellidom . " " . $row->nombre . '"
				                               style = "color:red;" title="Eliminar Calificación"></i> </a>';
                        }
                    } else {
                        $tabla .= '<label>No registrado</label>';
                    }
                    $tabla .= '</td>';
                endforeach;
                $tabla .= '<td>';
                $calificacion_final = number_format($suma_calificacion / $total_unidades, 2);
                if (validar_calificacion($calificacion_final, $detalle_configuracion[0]->calificacion_minima)) {
                    if ($suma_calificacion > 0.0) {
                        $tabla .= '<label style="color:red;">' . number_format($suma_calificacion / $total_unidades, 2) . '</label>';
                    } else {
                        $tabla .= '<label "> </label>';
                    }
                } else {
                    $tabla .= '<label style="color:green;">' . number_format($suma_calificacion / $total_unidades, 2) . '</label>';
                }
                $tabla .= '</td>';
                $tabla .= '</tr>';
            }
        }
        $tabla .= '</table>';
        return $tabla;
    }

    public function asistencia($idhorario = '', $idhorariodetalle) {
        Permission::grant(uri_string());
        $idhorario = $this->decode($idhorario);
        $idhorariodetalle = $this->decode($idhorariodetalle);
        if ((isset($idhorario) && !empty($idhorario)) && (isset($idhorariodetalle) && !empty($idhorariodetalle))) {
            $detalle_horario = $this->grupo->detalleHorarioDetalle($idhorariodetalle);
            $idprofesormateria = $detalle_horario->idprofesormateria;
            $idmateria = $detalle_horario->idmateria;
            $alumns = $this->grupo->alumnosGrupo($idhorario, $idprofesormateria, $idmateria);
            $motivo = $this->grupo->motivoAsistencia();
            $unidades = $this->grupo->unidades($this->session->idplantel);
            $fechainicio = date("Y-m-d");
            $fechafin = date("Y-m-d");
            $table = $this->obetnerAsistencia($idhorario, $fechainicio, $fechafin, $idhorariodetalle);
            $detalle = $this->grupo->detalleClase($idhorariodetalle);
            //var_dump($detalle);
            $nombreclase = $detalle[0]->nombreclase;
            $data = array(
                'alumnos' => $alumns,
                'motivo' => $motivo,
                'idhorario' => $idhorario,
                'idhorariodetalle' => $idhorariodetalle,
                'tabla' => $table,
                'nombreclase' => $nombreclase,
                'unidades' => $unidades,
                'controller' => $this,
            );
            $this->load->view('docente/header');
            $this->load->view('docente/grupo/asistencia', $data);
            $this->load->view('docente/footer');
        } else {
            $data = array(
                'heading' => 'Error',
                'message' => 'Error intente mas tarde.',
            );
            $this->load->view('docente/header');
            $this->load->view('docente/error/general', $data);
            $this->load->view('docente/footer');
        }
    }

    public function eliminarAsistenciaFecha() {
        $fecha = $this->input->post('fechaeliminar');
        $idhorariodetalle = $this->input->post('horariodetalle');
        $this->grupo->eliminarAsistenciaFecha($idhorariodetalle, $fecha);
    }

    public function examen($idhorario = '', $idhorariodetalle) {
        Permission::grant(uri_string());
        $idhorario = $this->decode($idhorario);
        $idhorariodetalle = $this->decode($idhorariodetalle);

        if ((isset($idhorario) && !empty($idhorario)) && (isset($idhorariodetalle) && !empty($idhorariodetalle))) {
            $unidades = $this->grupo->unidades($this->session->idplantel);
            $detalle_horario = $this->grupo->detalleHorarioDetalle($idhorariodetalle);
            $idprofesormateria = $detalle_horario->idprofesormateria;
            $idmateria = $detalle_horario->idmateria;
            $alumns = $this->grupo->alumnosGrupo($idhorario, $idprofesormateria, $idmateria);
            $detalle = $this->grupo->detalleClase($idhorariodetalle);

            $nombreclase = $detalle[0]->nombreclase;

            $data = array(
                'alumnos' => $alumns,
                'idhorario' => $idhorario,
                'idhorariodetalle' => $idhorariodetalle,
                'unidades' => $unidades,
                'nombreclase' => $nombreclase,
                'tabla' => $this->obtenerCalificacion($idhorario, $idhorariodetalle),
                'oportunidades' => $this->grupo->showAllOportunidades($this->session->idplantel),
                'controller' => $this,
            );

            $this->load->view('docente/header');
            $this->load->view('docente/grupo/examen', $data);
            $this->load->view('docente/footer');
        } else {
            $data = array(
                'heading' => 'Error',
                'message' => 'Error intente mas tarde.',
            );
             $this->load->view('docente/header');
            $this->load->view('docente/error/general', $data);
            $this->load->view('docente/footer');
        }
    }
   public function tareav2($idhorario = '', $idhorariodetalle) {
          Permission::grant(uri_string());
        $idhorario = $this->decode($idhorario);
        $idhorariodetalle = $this->decode($idhorariodetalle);
        if ((isset($idhorario) && !empty($idhorario)) && (isset($idhorariodetalle) && !empty($idhorariodetalle))) {
            $detalle = $this->grupo->detalleClase($idhorariodetalle);
           
            $data = array(         
                'idhorario' => $idhorario,
                'idhorariodetalle' => $idhorariodetalle,
                'tareas' => $this->grupo->allTarea($idhorariodetalle),
                'controller' => $this,
                'detalle_grupo'=>$detalle
            );

            $this->load->view('docente/header');
            $this->load->view('docente/grupo/tarea/index', $data);
            $this->load->view('docente/footer');
        } else {
            $data = array(
                'heading' => 'Error',
                'message' => 'Error intente mas tarde.',
            );
           $this->load->view('docente/header');
            $this->load->view('docente/error/general', $data);
            $this->load->view('docente/footer');
        }
                                    
   }
   public function revisar($idtarea) {
        if (isset($idtarea) && !empty($idtarea)) {
            $idusuario = $this->session->user_id;
            $validar_tarea = $this->tarea->validarTarea($idtarea, $idusuario);
            if ($validar_tarea) {
                $detalle_tarea = $this->tarea->detalleTarea($idtarea);

                $idhorariodetalle = $detalle_tarea[0]->idhorariodetalle;
                $idhorario = $detalle_tarea[0]->idhorario;
                $detalle = $this->grupo->detalleClase($idhorariodetalle);

                $idmateria = $detalle[0]->idmateria;
                $idprofesormateria = $detalle[0]->idprofesormateria;
                $data = array(
                    'idtarea' => $idtarea,
                    'detalle_tarea' => $detalle_tarea,
                    'idmateria' => $idmateria,
                    'idprofesormateria' => $idprofesormateria,
                    'idhorario' => $idhorario
                );
                $this->load->view('docente/header');
                $this->load->view('docente/grupo/tarea/detalle', $data);
                $this->load->view('docente/footer');
            } else {
                $data = array(
                    'heading' => 'Notificación',
                    'message' => 'El registro de la tarea no es de usted.',
                );
                $this->load->view('docente/header');
                $this->load->view('docente/error/general', $data);
                $this->load->view('docente/footer');
            }
        } else {
            $data = array(
                'heading' => 'Error',
                'message' => 'No de pasaron los parametros correctos.',
            );
            $this->load->view('docente/header');
            $this->load->view('docente/error/general', $data);
            $this->load->view('docente/footer');
        }
    }

    public function tarea($idhorario = '', $idhorariodetalle) {
        Permission::grant(uri_string());
        $idhorario = $this->decode($idhorario);
        $idhorariodetalle = $this->decode($idhorariodetalle);
        if ((isset($idhorario) && !empty($idhorario)) && (isset($idhorariodetalle) && !empty($idhorariodetalle))) {
            $data = array(
                'idhorario' => $idhorario,
                'idhorariodetalle' => $idhorariodetalle,
                'tareas' => $this->grupo->allTarea($idhorariodetalle),
                'controller' => $this,
            );

            $this->load->view('docente/header');
            $this->load->view('docente/grupo/tarea', $data);
            $this->load->view('docente/footer');
        } else {
            $data = array(
                'heading' => 'Error',
                'message' => 'Error intente mas tarde.',
            );
           $this->load->view('docente/header');
            $this->load->view('docente/error/general', $data);
            $this->load->view('docente/footer');
        }
    }

    public function addCalificacion() {
        Permission::grant(uri_string());
        $config = array(
            array(
                'field' => 'unidad',
                'label' => 'Unidad',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Seleccionar la Unidad.',
                ),
            ),
            array(
                'field' => 'calificacion[]',
                'label' => 'Calificacion',
                'rules' => 'trim|decimal|callback_maxNumber',
                'errors' => array(
                    'decimal' => 'Debe de ser Números decimales.',
                ),
            ),
        );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == false) {
            $errors = validation_errors();
            echo json_encode(['error' => $errors]);
        } else {
            $idhorario = $this->input->post('idhorario');
            $idhorariodetalle = $this->input->post('idhorariodetalle');
            $idalumno = $this->input->post('idalumno');
            $unidad = $this->input->post('unidad');
            $calificacion = $this->input->post('calificacion');
            $detalle_oportunidad = $this->grupo->primeraOportunidad($this->session->idplantel);
            if ($detalle_oportunidad) {
                $idopotunidad = $detalle_oportunidad[0]->idoportunidadexamen;
                $contador_no_insertado = 0;
                $contador_insertado = 0;
                foreach ($idalumno as $key => $value) {
                    $idalumno2 = $value;
                    $calificacion_final = $calificacion[$key];
                    $validar = $this->grupo->validarAgregarCalificacion($unidad, $idhorariodetalle, '', $idalumno2);
                    if ($validar == false) {
                        if (isset($calificacion_final) && !empty($calificacion_final)) {
                            $data = array(
                                'idunidad' => $unidad,
                                'idoportunidadexamen' => $idopotunidad,
                                'idalumno' => $idalumno2,
                                'idhorario' => $idhorario,
                                'idhorariodetalle' => $idhorariodetalle,
                                'calificacion' => $calificacion_final,
                                'idusuario' => $this->session->user_id,
                                'fecharegistro' => date('Y-m-d H:i:s'),
                            );
                            $this->grupo->addCalificacion($data);
                            $contador_insertado++;
                        } else {
                            $contador_no_insertado++;
                        }
                    } else {
                        $contador_no_insertado++;
                    }
                }
                if ($contador_no_insertado > 0) {
                    echo json_encode(['success' => 'Ok', 'mensaje' => 'Algunas calificaciones no fueron registrados, porque ya estan registrada.']);
                } else {
                    echo json_encode(['success' => 'Ok', 'mensaje' => 'Fueron registrados las calificaciones.']);
                }
            } else {
                echo json_encode(['error' => 'No esta registrado la Oportunidad.']);
            }
        }
        // echo json_encode($result);
    }

    public function addAsistencia() {
        Permission::grant(uri_string());
        $config = array(
            array(
                'field' => 'fecha',
                'label' => 'Unidad',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Debe de seleccionar la Fecha.',
                ),
            ),
            array(
                'field' => 'unidad',
                'label' => 'Unidad',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Debe de seleccionar la Unidad.',
                ),
            ),
            array(
                'field' => 'motivo[]',
                'label' => 'Asistencia',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Debe de seleccionar una Opción.',
                ),
            ),
        );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == false) {
            $errors = validation_errors();
            echo json_encode(['error' => $errors]);
        } else {

            $idhorario = $this->input->post('idhorario');
            $idunidad = $this->input->post('unidad');
            $idhorariodetalle = $this->input->post('idhorariodetalle');
            $idalumno = $this->input->post('idalumno');
            $motivo = $this->input->post('motivo');
            $fecha = $this->input->post('fecha');
            $numero_semana_enviado = date('W', strtotime($fecha));
            $semana_actual = date('W');
            if ($semana_actual == $numero_semana_enviado) {
                $validar = $this->grupo->validarAgregarAsistencia($fecha, $idhorariodetalle, $idunidad);
                if ($validar == false) {
                    foreach ($idalumno as $key => $value) {
                        # code...
                        // value es el idcliete
                        $idalumno2 = $value;
                        $motivo2 = $motivo[$key];

                        $data = array(
                            'idhorario' => $idhorario,
                            'idhorariodetalle' => $idhorariodetalle,
                            'idalumno' => $idalumno2,
                            'idmotivo' => $motivo2,
                            'idunidad' => $idunidad,
                            'fecha' => $fecha,
                            'idusuario' => $this->session->user_id,
                            'fecharegistro' => date('Y-m-d H:i:s'),
                        );
                        $this->grupo->addAsistencia($data);
                    }
                    echo json_encode(['success' => 'Ok']);
                } else {
                    echo json_encode(['error' => 'Las Asistencias ya estan registradas para esta Fecha.']);
                }
            } else {
                echo json_encode(['error' => 'Solo puedes trabajar en la semana actual.']);
            }
        }
        // echo json_encode($result);
    }

    public function updateAsistencia() {
        Permission::grant(uri_string());
        $config = array(
            array(
                'field' => 'motivo',
                'label' => 'Asistencia',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Debe de seleccionar una Opción.',
                ),
            ),
        );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == false) {
            $errors = validation_errors();
            echo json_encode(['error' => $errors]);
        } else {
            $idasistencia = $this->input->post('idasistencia');
            $motivo = $this->input->post('motivo');
            $data = array(
                'idmotivo' => $motivo,
                'idusuario' => $this->session->user_id,
                'fecharegistro' => date('Y-m-d H:i:s'),
            );
            $valu = $this->grupo->updateAsistencia($idasistencia, $data);
            if ($valu) {
                echo json_encode(['success' => 'Ok']);
            } else {
                echo json_encode(['error' => 'Error... Intente mas tarde.']);
            }
        }
        // echo json_encode($result);
    }

    public function addTarea() {
        Permission::grant(uri_string());
        $config = array(
            array(
                'field' => 'fechaentrega',
                'label' => 'Unidad',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'La fecha de entrega es requerido.',
                ),
            ),
            array(
                'field' => 'tarea',
                'label' => 'Calificación',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'La tarea es requerido',
                ),
            ),
        );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == false) {
            $errors = validation_errors();
            echo json_encode(['error' => $errors]);
        } else {
            $idhorario = $this->input->post('idhorario');
            $idhorariodetalle = $this->input->post('idhorariodetalle');
            $tarea = $this->input->post('tarea');
            $fechaentrega = $this->input->post('fechaentrega');
            $horaentrega = $this->input->post('horaentrega');
       $permitidos = array('jpg','JPG','PNG','jepg','JEGP');
       $nombre_documento = $_FILES['documento']['name'];
       $ext = pathinfo($nombre_documento,PATHINFO_EXTENSION);
       if(!in_array($ext, $permitidos)){
             echo json_encode(['error' => "El tipo de archivo no es permitido"]);
       }
           /* $data = array(
                'idhorario' => $idhorario,
                'idhorariodetalle' => $idhorariodetalle,
                'tarea' => $tarea,
                'fechaentrega' => $fechaentrega,
                'idnotificacionalumno'=>1,
                'idnotificaciontutor'=>1,
                'idusuario' => $this->session->user_id,
                'fecharegistro' => date('Y-m-d H:i:s'),
            );
            $value = $this->grupo->addTarea($data);

            echo json_encode(['success' => 'Ok']);*/
        }
       // echo json_encode($result);
    }

    public function addMensaje() {
        Permission::grant(uri_string());
        $config = array(
            array(
                'field' => 'mensaje',
                'label' => 'Calificación',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'El mensaje es requerido',
                ),
            ),
        );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == false) {
            $errors = validation_errors();
            echo json_encode(['error' => $errors]);
        } else {
            $idhorario = $this->input->post('idhorario');
            $idhorariodetalle = $this->input->post('idhorariodetalle');
            $mensaje = $this->input->post('mensaje');
            //$fechaentrega = $this->input->post('fechaentrega');

            $data = array(
                'idhorario' => $idhorario,
                'idhorariodetalle' => $idhorariodetalle,
                'mensaje' => $mensaje,
                'eliminado' => 0,
                'idnotificacionalumno'=>1,
                'idnotificaciontutor'=>1,
                'idusuario' => $this->session->user_id,
                'fecharegistro' => date('Y-m-d H:i:s'),
            );
            $this->mensaje->addMensaje($data);

            echo json_encode(['success' => 'Ok']);
        }
        // echo json_encode($result);
    }

    public function updateTarea() {
        Permission::grant(uri_string());
        $config = array(
            array(
                'field' => 'fechaentrega',
                'label' => 'Unidad',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Fecha de entrega es requerido.',
                ),
            ),
            array(
                'field' => 'tarea',
                'label' => 'Calificación',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'La tarean es requerido',
                ),
            ),
        );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == false) {
            $errors = validation_errors();
            echo json_encode(['error' => $errors]);
        } else {
            $idtarea = $this->input->post('idtarea');
            $tarea = $this->input->post('tarea');
            $fechaentrega = $this->input->post('fechaentrega');

            $data = array(
                'tarea' => $tarea,
                'fechaentrega' => $fechaentrega,
                 'idnotificacionalumno'=>1,
                'idnotificaciontutor'=>1,
                'idusuario' => $this->session->user_id,
                'fecharegistro' => date('Y-m-d H:i:s'),
            );
            $this->grupo->updateTarea($idtarea, $data);

            echo json_encode(['success' => 'Ok']);
        }
        // echo json_encode($result);
    }

    public function updateMensaje() {
        Permission::grant(uri_string());
        $config = array(
            array(
                'field' => 'mensaje',
                'label' => 'Calificación',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'El mensaje es requerido',
                ),
            ),
        );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == false) {
            $errors = validation_errors();
            echo json_encode(['error' => $errors]);
        } else {
            $idmensaje = $this->input->post('idmensaje');
            $mensaje = $this->input->post('mensaje');
            $data = array(
                'mensaje' => $mensaje,
                 'idnotificacionalumno'=>1,
                'idnotificaciontutor'=>1,
                'idusuario' => $this->session->user_id,
                'fecharegistro' => date('Y-m-d H:i:s'),
            );
            $this->mensaje->updateMensaje($idmensaje, $data);

            echo json_encode(['success' => 'Ok']);
        }
        // echo json_encode($result);
    }

    public function eliminarTarea($idhorario, $idhorariodetalle, $idtarea) {
        Permission::grant(uri_string());
        # code...
        $idhorario = $this->decode($idhorario);
        $idhorariodetalle = $this->decode($idhorariodetalle);
        $idtarea = $this->decode($idtarea);
        $this->grupo->eliminarTarea($idtarea);
        redirect('Pgrupo/tarea/' . $this->encode($idhorario) . '/' . $this->encode($idhorariodetalle));
    }

    public function eliminarMensaje($idhorario, $idhorariodetalle, $idmensaje) {
        Permission::grant(uri_string());
        # code...
        $idhorario = $this->decode($idhorario);
        $idhorariodetalle = $this->decode($idhorariodetalle);
        $idmensaje = $this->decode($idmensaje);
        $data = array(
            'eliminado' => 1,
        );
        $this->mensaje->updateMensaje($idmensaje, $data);
        redirect('Pgrupo/mensaje/' . $this->encode($idhorario) . '/' . $this->encode($idhorariodetalle));
    }

    public function mensaje($idhorario = '', $idhorariodetalle = '') {
        Permission::grant(uri_string());
        $idhorario = $this->decode($idhorario);
        $idhorariodetalle = $this->decode($idhorariodetalle);
        if ((isset($idhorario) && !empty($idhorario)) && (isset($idhorariodetalle) && !empty($idhorariodetalle))) {
            $data = array(
                'idhorario' => $idhorario,
                'idhorariodetalle' => $idhorariodetalle,
                'mensajes' => $this->mensaje->showAllMensaje($idhorariodetalle),
                'controller' => $this,
            );
            $this->load->view('docente/header');
            $this->load->view('docente/grupo/mensaje', $data);
            $this->load->view('docente/footer');
        } else {
            $data = array(
                'heading' => 'Error',
                'message' => 'Error intente mas tarde.',
            );
            $this->load->view('docente/header');
            $this->load->view('docente/error/general', $data);
            $this->load->view('docente/footer');
            
        }
    }

    public function eliminarCalificacion() {
        # code...
        Permission::grant(uri_string());
        $idcalificacion = $this->input->post('idcalificacion');
        $datelle = $this->alumno->detalleCalificacion($idcalificacion);
        $fecha_inicio = date('Y-m-d');
        $fecha_fin = date('Y-m-d', strtotime($datelle->fecharegistro));
        $total_dias = dias_pasados($fecha_inicio, $fecha_fin);
        if ($total_dias <= 3) {
            $value = $this->grupo->deleteCalificacion($idcalificacion);
            if ($value) {
                echo json_encode(['success' => 'Ok']);
            } else {
                echo json_encode(['error' => 'Error, Intente mas tarde.']);
            }
        } else {
            echo json_encode(['error' => 'Ya pasaron los 3 dias habiles.']);
        }
    }

    public function eliminarAsistencia() {
        # code...
        Permission::grant(uri_string());
        $idasistencia = $this->input->post('idasistencia');
        $value = $this->grupo->deleteAsistencia($idasistencia);
        if ($value) {
            echo json_encode(['success' => 'Ok']);
        } else {
            echo json_encode(['error' => 'Error, Intente mas tarde.']);
        }
    }

    public function maxNumber($num) {
        if ($num >= 0.00 && $num <= 10.00) {
            return true;
        } else {
            $this->form_validation->set_message(
                    'maxNumber',
                    'La Calificacion debe de ser entre 0.00 a 10.00'
            );
            return false;
        }
    }

    public function updateCalificacion() {
        Permission::grant(uri_string());
        $config = array(
            array(
                'field' => 'calificacion',
                'label' => 'Calificacion',
                'rules' => 'trim|required|decimal|callback_maxNumber',
                'errors' => array(
                    'required' => 'De de escribir las Calificaciones.',
                    'decimal' => 'Debe de ser Números decimales.',
                ),
            ),
        );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == false) {
            $errors = validation_errors();
            echo json_encode(['error' => $errors]);
        } else {
            $idcalificacion = $this->input->post('idcalificacion');
            $calificacion = $this->input->post('calificacion');
            $detalle_calificacion = $this->grupo->detalleCalificacion($idcalificacion);
            $fecha_inicio = date('Y-m-d');
            $fecha_fin = date('Y-m-d', strtotime($detalle_calificacion->fecharegistro));
            $total_dias = dias_pasados($fecha_inicio, $fecha_fin);
            if ($total_dias <= 3) {
                $data = array(
                    'calificacion' => $calificacion,
                    'idusuario' => $this->session->user_id,
                        //'fecharegistro' => date('Y-m-d H:i:s')
                );
                $this->grupo->updateCalificacion($idcalificacion, $data);

                echo json_encode(['success' => 'Ok']);
            } else {
                echo json_encode(['error' => 'Ya pasaron los 3 dias habiles.']);
            }
        }
    }

    public function eliminarCalificacionUnidadRecuperacion() {
        Permission::grant(uri_string());
        /* $config = array(
          array(
          'field' => 'unidad',
          'label' => 'Calificacion',
          'rules' => 'trim|required',
          'errors' => array(
          'required' => 'Seleccionar la Unidad.',
          ),
          ),
          );
          $this->form_validation->set_rules($config);
          if ($this->form_validation->run() == false) {
          $errors = validation_errors();
          echo json_encode(['error' => $errors]);
          } else { */
        //$detalle_oportunidad = $this->grupo->primeraOportunidad($this->session->idplantel);
        //if ($detalle_oportunidad) {
        $unidad = $this->input->post('idunidad');
        $idoportunidad = $this->input->post('idoportunidad');
        $horariodetalle = $this->input->post('horariodetalle');
        $detalle_calificacion = $this->grupo->detalleCalificacionUnidad($unidad, $horariodetalle);
        if ($detalle_calificacion) {
            $fecha_inicio = date('Y-m-d');
            $fecha_fin = date('Y-m-d', strtotime($detalle_calificacion->fecharegistro));
            $total_dias = dias_pasados($fecha_inicio, $fecha_fin);
            if ($total_dias <= 3) {
                $this->grupo->eliminarCalificacionUnidad($unidad, $horariodetalle, $idoportunidad);

                echo json_encode(['success' => 'Ok']);
            } else {
                echo json_encode(['error' => 'Ya pasaron los 3 dias habiles.']);
            }
        } else {
            echo json_encode(['success' => 'vacio',
                'mensaje' => 'Ya pasaron los 3 dias habiles.']);
        }
        //} else {
        //    echo json_encode(['error' => 'No esta registrado la Oportunidad.']);
        //}
        //  }
    }

    public function eliminarCalificacionUnidad() {
        Permission::grant(uri_string());
        $config = array(
            array(
                'field' => 'unidad',
                'label' => 'Calificacion',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Seleccionar la Unidad.',
                ),
            ),
        );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == false) {
            $errors = validation_errors();
            echo json_encode(['error' => $errors]);
        } else {
            $detalle_oportunidad = $this->grupo->primeraOportunidad($this->session->idplantel);
            if ($detalle_oportunidad) {
                $idopotunidad = $detalle_oportunidad[0]->idoportunidadexamen;
                $unidad = $this->input->post('unidad');
                $horariodetalle = $this->input->post('horariodetalle');
                $detalle_calificacion = $this->grupo->detalleCalificacionUnidad($unidad, $horariodetalle);
                if ($detalle_calificacion) {
                    $fecha_inicio = date('Y-m-d');
                    $fecha_fin = date('Y-m-d', strtotime($detalle_calificacion->fecharegistro));
                    $total_dias = dias_pasados($fecha_inicio, $fecha_fin);
                    if ($total_dias <= 3) {
                        $this->grupo->eliminarCalificacionUnidad($unidad, $horariodetalle, $idopotunidad);

                        echo json_encode(['success' => 'Ok']);
                    } else {
                        echo json_encode(['error' => 'Ya pasaron los 3 dias habiles.']);
                    }
                } else {
                    echo json_encode(['success' => 'vacio',
                        'mensaje' => 'No existe calificaciones para eliminar.']);
                }
            } else {
                echo json_encode(['error' => 'No esta registrado la Oportunidad.']);
            }
        }
    }

    public function obtenerCalificacionRecupaacion($idhorario = '', $idhorariodetalle, $idoportunidad_anterior, $idopotunidad) {
        $detalle_horario = $this->grupo->detalleClase($idhorariodetalle);
        $idprofesormateria = $detalle_horario[0]->idprofesormateria;
        $alumnos = $this->grupo->obtenerAlumnoRecuperar($idhorariodetalle, $idoportunidad_anterior, $idprofesormateria);
        $datoshorario = $this->horario->showNivelGrupo($idhorario);
        $idnivelestudio = $datoshorario->idnivelestudio;
        $detalle_configuracion = $this->configuracion->showAllConfiguracion($this->session->idplantel, $idnivelestudio);
        $tabla = "";
        $tabla .= ' <table id="tablageneral2" class="table table-striped dt-responsive nowrap" cellspacing="0" width="100%">
            <thead class="bg-teal">
            <th>#</th>
            <th>NOMBRE</th>';
        $tabla .= '<th>C. FINAL</th>';
        $tabla .= '</thead>';
        $c = 1;
        $total_unidades = 0;
        if (isset($alumnos) && !empty($alumnos)) {
            foreach ($alumnos as $row) {
                if (validar_calificacion($row->calificacion, $detalle_configuracion[0]->calificacion_minima)) {
                    $tabla .= '<tr>';
                    $tabla .= '  <td>' . $c++ . '</td>';
                    $tabla .= '<td>' . $row->apellidop . " " . $row->apellidom . " " . $row->nombre . '</td>';
                    $detalle_calificacion = $this->grupo->obtenerCalificacionRecuperado($row->idalumno, $idopotunidad, $idhorariodetalle);
                    if ($detalle_calificacion) {
                        $suma_calificacion = 0;
                        $suma_calificacion = $detalle_calificacion->calificacion;
                        $total_unidades = 1;
                        $tabla .= '<td>';
                        $calificacion_final = number_format($suma_calificacion / $total_unidades, 2);
                        if (validar_calificacion($calificacion_final, $detalle_configuracion[0]->calificacion_minima)) {
                            if ($suma_calificacion > 0.0) {
                                $tabla .= '<label style="color:red;">' . number_format($suma_calificacion / $total_unidades, 2) . '</label>';
                                $fecha_inicio = date('Y-m-d');
                                $fecha_fin = date('Y-m-d', strtotime($detalle_calificacion->fecharegistro));
                                $total_dias = dias_pasados($fecha_inicio, $fecha_fin);
                                if ($total_dias <= 3) {
                                    $tabla .= '  <a  href="javascript:void(0)"><i class="fa fa-pencil edit_button"  data-toggle="modal" data-target="#myModal"
		                                data-idcalificacion="' . $detalle_calificacion->idcalificacion . '"
		                                data-calificacion="' . number_format($suma_calificacion / $total_unidades, 2) . '"
		                                data-alumno="' . $detalle_calificacion->apellidop . " " . $detalle_calificacion->apellidom . " " . $detalle_calificacion->nombre . '"
	                                   style = "color:blue;" title="Editar Calificación"></i> </a>';
                                    $tabla .= '  <a  href="javascript:void(0)"><i class="fa fa-trash delete_button"  data-toggle="modal" data-target="#myModalDelete"
		                                data-idcalificacion="' . $detalle_calificacion->idcalificacion . '"
		                                data-alumno="' . $detalle_calificacion->apellidop . " " . $detalle_calificacion->apellidom . " " . $detalle_calificacion->nombre . '"
		                               style = "color:red;" title="Eliminar Calificación"></i> </a>';
                                }
                            } else {
                                $tabla .= '<label "> </label>';
                            }
                        } else {
                            $tabla .= '<label style="color:green;">' . number_format($suma_calificacion / $total_unidades, 2) . '</label>';
                            $fecha_fin = date('Y-m-d', strtotime($detalle_calificacion->fecharegistro));
                            $total_dias = dias_pasados($fecha_inicio, $fecha_fin);
                            if ($total_dias <= 3) {
                                $tabla .= '  <a  href="javascript:void(0)"><i class="fa fa-pencil edit_button"  data-toggle="modal" data-target="#myModal"
		                                data-idcalificacion="' . $detalle_calificacion->idcalificacion . '"
		                                data-calificacion="' . number_format($suma_calificacion / $total_unidades, 2) . '"
		                                data-alumno="' . $detalle_calificacion->apellidop . " " . $detalle_calificacion->apellidom . " " . $detalle_calificacion->nombre . '"
	                                   style = "color:blue;" title="Editar Calificación"></i> </a>';
                                $tabla .= '  <a  href="javascript:void(0)"><i class="fa fa-trash delete_button"  data-toggle="modal" data-target="#myModalDelete"
		                                data-idcalificacion="' . $detalle_calificacion->idcalificacion . '"
		                                data-alumno="' . $detalle_calificacion->apellidop . " " . $detalle_calificacion->apellidom . " " . $detalle_calificacion->nombre . '"
		                               style = "color:red;" title="Eliminar Calificación"></i> </a>';
                            }
                        }
                    } else {
                        $tabla .= '  <td>No registrado</td>';
                    }
                    $tabla .= '</td>';
                    $tabla .= '</tr>';
                }
            }
        }
        $tabla .= '</table>';
        return $tabla;
    }

    public function recuperacion($idhorario = '', $idhorariodetalle = '', $idopotunidad = '', $numero = '') {
        $idhorario = $this->decode($idhorario);
        $idhorariodetalle = $this->decode($idhorariodetalle);
        $idopotunidad = $this->decode($idopotunidad);
        $numero = $this->decode($numero);
        $idplantel = $this->session->idplantel;
        if ((isset($idhorario) && !empty($idhorario)) && (isset($idhorariodetalle) && !empty($idhorariodetalle)) && (isset($idopotunidad) && !empty($idopotunidad)) && (isset($numero) && !empty($numero))) {
            //$unidades = $this->grupo->unidades($this->session->idplantel);
            $detalle_oportunidad_anteriot = $this->grupo->obtenerOportunidadAnterior($numero, $idplantel);
            $idoportunidad_anterior = $detalle_oportunidad_anteriot->idoportunidadexamen;
            $detalle_horario = $this->grupo->detalleClase($idhorariodetalle);
            $idprofesormateria = $detalle_horario[0]->idprofesormateria;
            $alumnos = $this->grupo->obtenerAlumnoRecuperar($idhorariodetalle, $idoportunidad_anterior, $idprofesormateria);
            $tabla = $this->obtenerCalificacionRecupaacion($idhorario, $idhorariodetalle, $idoportunidad_anterior, $idopotunidad);
            $detalle = $this->grupo->detalleClase($idhorariodetalle);
            $detalle_oportunidad = $this->grupo->detalleOportunidad($idopotunidad);
            $nombreclase = $detalle[0]->nombreclase;
            $nombre_oportunidad = $detalle_oportunidad->nombreoportunidad;
            $datoshorario = $this->horario->showNivelGrupo($idhorario);
            $idnivelestudio = $datoshorario->idnivelestudio;
            $unidades = $this->grupo->obtenerUnidadUno(1);
            $idunidad = $unidades->idunidad;
            //$todas_unidades = $this->grupo->obtenerUnidades(1);
            // var_dump($todas_unidades);
            $detalle_configuracion = $this->configuracion->showAllConfiguracion($this->session->idplantel, $idnivelestudio);
            $data = array(
                'alumnos' => $alumnos,
                'idhorario' => $idhorario,
                'idhorariodetalle' => $idhorariodetalle,
                'tabla' => $tabla,
                'nombreclase' => $nombreclase,
                'nombreoportunidad' => $nombre_oportunidad,
                'calificacion_minima' => $detalle_configuracion[0]->calificacion_minima,
                'idunidad' => $idunidad,
                'idoportunidad' => $idopotunidad,
                    //'unidades' => $todas_unidades,
            );
            $this->load->view('docente/header');
            $this->load->view('docente/grupo/recuperacion/index', $data);
            $this->load->view('docente/footer');
        } else {
            $data = array(
                'heading' => 'Error',
                'message' => 'Error intente mas tarde.',
            );
            $this->load->view('docente/header');
            $this->load->view('docente/error/general', $data);
            $this->load->view('docente/footer');
        }
    }

    public function addCalificacionRecuperacion() {
        Permission::grant(uri_string());
        $config = array(
            array(
                'field' => 'calificacion[]',
                'label' => 'Calificacion',
                'rules' => 'trim|decimal|callback_maxNumber',
                'errors' => array(
                    'decimal' => 'Debe de ser Números decimales.',
                ),
            ),
        );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == false) {
            $errors = validation_errors();
            echo json_encode(['error' => $errors]);
        } else {
            $idhorario = $this->input->post('idhorario');
            $idhorariodetalle = $this->input->post('idhorariodetalle');
            $idalumno = $this->input->post('idalumno');
            $idunidad = $this->input->post('idunidad');
            $idoportunidad = $this->input->post('idoportunidad');
            $calificacion = $this->input->post('calificacion');
            $contador_no_insertado = 0;
            $contador_insertado = 0;
            foreach ($idalumno as $key => $value) {
                $idalumno2 = $value;
                $calificacion_final = $calificacion[$key];
                $validar = $this->grupo->validarAgregarCalificacion($idunidad, $idhorariodetalle, $idoportunidad, $idalumno2);
                if ($validar == false) {
                    if (isset($calificacion_final) && !empty($calificacion_final)) {
                        $data = array(
                            'idunidad' => $idunidad,
                            'idoportunidadexamen' => $idoportunidad,
                            'idalumno' => $idalumno2,
                            'idhorario' => $idhorario,
                            'idhorariodetalle' => $idhorariodetalle,
                            'calificacion' => $calificacion_final,
                            'idusuario' => $this->session->user_id,
                            'fecharegistro' => date('Y-m-d H:i:s'),
                        );
                        $this->grupo->addCalificacion($data);
                        $contador_insertado++;
                    } else {
                        $contador_no_insertado++;
                    }
                } else {
                    $contador_no_insertado++;
                }
            }
            if ($contador_no_insertado > 0) {
                echo json_encode(['success' => 'Ok', 'mensaje' => 'Algunas calificaciones no fueron registrados, porque ya estan registrada.']);
            } else {
                echo json_encode(['success' => 'Ok', 'mensaje' => 'Fueron registrados las calificaciones.']);
            }

            //} else {
            //    echo json_encode(['error' => 'Ya fueron registradas las calificaciones para esta unidad.']);
            //}
        }
    }

    public function reporte() {
        $result = $this->grupo->showAllGruposProfesor($this->session->idprofesor);
        $data = array('grupos' => $result);
        $this->load->view('docente/header');
        $this->load->view('docente/grupo/reporte/index', $data);
        $this->load->view('docente/footer');
    }

    public function generarReporter() {
        $idhorariodetalle = $this->input->post('grupo');
        $detalle = $this->grupo->detalleHorarioDetalle($idhorariodetalle);

        $idperiodo = $detalle->idperiodo;
        $idgrupo = $detalle->idgrupo;
        $idmateria = $detalle->idmateria;
        $idhorario = $detalle->idhorario;
        $idprofesormateria = $detalle->idprofesormateria;
        $tiporeporte = $this->input->post('tiporeporte');
        $cabezera = array(
            'A',
            'B',
            'C',
            'D',
            'E',
            'F',
            'G',
            'H',
            'I',
            'J',
            'K',
            'L',
            'M',
            'N',
            'O',
            'P',
            'Q',
            'R',
            'S',
            'T',
            'U',
            'V',
            'W',
            'X',
            'Y',
            'Y',
        );
        foreach ($cabezera as $row) {
            
        }

        if ($tiporeporte == 1) {
            $alumnos = $this->grupo->alumnosGrupo($idhorario, $idprofesormateria, $idmateria);
            
            $this->load->library('excel');
            $this->excel->setActiveSheetIndex(0);
            $this->excel->getActiveSheet()->setTitle('Listado de Alumnos');
            //Contador de filas
            $contador = 1;
            $contador_alumno = 0;
            //Le aplicamos ancho las columnas.
            $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
            $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(50);
            $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
            //Le aplicamos negrita a los títulos de la cabecera.
            $this->excel->getActiveSheet()->getStyle("A{$contador}")->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle("B{$contador}")->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle("C{$contador}")->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle("D{$contador}")->getFont()->setBold(true);
            //Definimos los títulos de la cabecera.
            $this->excel->getActiveSheet()->setCellValue("A{$contador}", 'NO');
            $this->excel->getActiveSheet()->setCellValue("B{$contador}", 'OPCION');
            $this->excel->getActiveSheet()->setCellValue("C{$contador}", 'NOMBRE');
            $this->excel->getActiveSheet()->setCellValue("D{$contador}", 'CALIFICACION');
            //Definimos la data del cuerpo.
            if(isset($alumnos) && !empty($alumnos)){
            foreach ($alumnos as $row) {
                //Incrementamos una fila más, para ir a la siguiente.
                $contador++;
                $contador_alumno++;
                //Informacion de las filas de la consulta.
                $this->excel->getActiveSheet()->setCellValue("A{$contador}", $contador_alumno);
                $this->excel->getActiveSheet()->setCellValue("B{$contador}", ($row->opcion == 1) ? "N" : "R"  );
                $this->excel->getActiveSheet()->setCellValue("C{$contador}", $row->apellidop . " " . $row->apellidom . " " . $row->nombre);
                $datalle_calificacion = $this->grupo->calificacionPorMateria($row->idalumno, $idprofesormateria, $idhorario);
                                    
            }
            }
            //Le ponemos un nombre al archivo que se va a generar.
            $archivo = "Lista de Alumnos {$idperiodo}.xls";
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . $archivo . '"');
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            //Hacemos una salida al navegador con el archivo Excel.
            $objWriter->save('php://output');
        }
        if ($tiporeporte == 2) {
            $alumnos = $this->grupo->alumnosGrupo($idhorario, $idprofesormateria, $idmateria);

            $this->load->library('excel');
            $this->excel->setActiveSheetIndex(0);
            $this->excel->getActiveSheet()->setTitle('Reporte de Calificaciones');
            //Contador de filas
            $contador = 1;
            $contador_alumno = 0;
            //Le aplicamos ancho las columnas.
            $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
            $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(50);
            $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
            //Le aplicamos negrita a los títulos de la cabecera.
            $this->excel->getActiveSheet()->getStyle("A{$contador}")->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle("B{$contador}")->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle("C{$contador}")->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle("D{$contador}")->getFont()->setBold(true);
            //Definimos los títulos de la cabecera.
            $this->excel->getActiveSheet()->setCellValue("A{$contador}", 'NO');
            $this->excel->getActiveSheet()->setCellValue("B{$contador}", 'CURP');
            $this->excel->getActiveSheet()->setCellValue("C{$contador}", 'NOMBRE');
            $this->excel->getActiveSheet()->setCellValue("D{$contador}", 'CALIFICACION');
            //Definimos la data del cuerpo.
            foreach ($alumnos as $row) {
                //Incrementamos una fila más, para ir a la siguiente.
                $contador++;
                $contador_alumno++;
                //Informacion de las filas de la consulta.
                $this->excel->getActiveSheet()->setCellValue("A{$contador}", $contador_alumno);
                $this->excel->getActiveSheet()->setCellValue("B{$contador}", $row->curp);
                $this->excel->getActiveSheet()->setCellValue("C{$contador}", $row->apellidop . " " . $row->apellidom . " " . $row->nombre);
                $datalle_calificacion = $this->grupo->calificacionPorMateria($row->idalumno, $idprofesormateria, $idhorario);
                //var_dump($datalle_calificacion);
                if ($datalle_calificacion) {
                    $this->excel->getActiveSheet()->setCellValue("D{$contador}", number_format($datalle_calificacion->calificacion, 2));
                } else {
                    $this->excel->getActiveSheet()->setCellValue("D{$contador}", 'No registrado.');
                }
            }
            //Le ponemos un nombre al archivo que se va a generar.
            $archivo = "Reporte de Calificaciones {$idperiodo}.xls";
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . $archivo . '"');
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            //Hacemos una salida al navegador con el archivo Excel.
            $objWriter->save('php://output');
        }
    }

}