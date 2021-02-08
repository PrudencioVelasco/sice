<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("America/Mexico_City");

class pGrupo extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!isset($_SESSION['user_id'])) {
            $this->session->set_flashdata('flash_data', 'You don\'t have access! ss');
            return redirect('welcome');
        }
        $this->load->helper('url');
        $this->load->library('permission');
        $this->load->library('session');
        $this->load->model('grupo_model', 'grupo');
        $this->load->model('alumno_model', 'alumno');
        $this->load->model('tarea_model', 'tarea');
        $this->load->model('mensaje_model', 'mensaje');
        $this->load->model('calificacion_model', 'calificacion');
        $this->load->model('cicloescolar_model', 'cicloescolar');
        $this->load->library('encryption');
        $this->load->helper('numeroatexto_helper');
        $this->load->model('configuracion_model', 'configuracion');
        $this->load->model('horario_model', 'horario');
        $this->load->library('excel');
        date_default_timezone_set("America/Mexico_City");
        $this->dias = 3;
    }

    public function encode($string)
    {
        $encrypted = $this->encryption->encrypt($string);
        if (!empty($string)) {
            $encrypted = strtr($encrypted, array(
                '/' => '~'
            ));
        }
        return $encrypted;
    }

    public function decode($string)
    {
        $string = strtr($string, array(
            '~' => '/'
        ));
        return $this->encryption->decrypt($string);
    }

    public function index()
    {
        # code...
        Permission::grant(uri_string());

        $result = $this->grupo->showAllGruposProfesor($this->session->idprofesor);
        $unidades = $this->grupo->unidades();
        $oportunidades = $this->grupo->showAllOportunidades($this->session->idplantel);
        $meses = $this->calificacion->allMeses();

        $data = array(
            'datos' => $result,
            'grupos' => $result,
            'unidades' => $unidades,
            'meses' => $meses,
            'oportunidades' => $oportunidades,
            'controller' => $this
        );
        $this->load->view('docente/header');
        if ($this->session->idniveleducativo == 4) {
            $this->load->view('docente/grupo/preescolar', $data);
        } else {
            $this->load->view('docente/grupo/index', $data);
        }
        $this->load->view('docente/footer');
    }

    // EXAMEN LICENCIATURA
    public function calificacionLic($idhorario = '', $idhorariodetalle)
    {
        Permission::grant(uri_string());
        $idhorario = $this->decode($idhorario);
        $idhorariodetalle = $this->decode($idhorariodetalle);

        if ((isset($idhorario) && !empty($idhorario)) && (isset($idhorariodetalle) && !empty($idhorariodetalle))) {
            $unidades = $this->grupo->unidades($this->session->idplantel);
            $detalle_horario = $this->grupo->detalleHorarioDetalle($idhorariodetalle);
            $idprofesormateria = $detalle_horario->idprofesormateria;
            $idmateria = $detalle_horario->idmateria;
            $unidades_materia = $detalle_horario->unidades;
            $estatus_alumno = $detalle_horario->activo;
            $alumns = $this->grupo->alumnosGrupo($idhorario, $idprofesormateria, $idmateria, $estatus_alumno);
            $detalle = $this->grupo->detalleClase($idhorariodetalle);
            $oportunidades = $this->grupo->showAllOportunidades($this->session->idplantel);
            $nombreclase = $detalle[0]->nombreclase;
            $data = array(
                'alumnos' => $alumns,
                'idhorario' => $idhorario,
                'idhorariodetalle' => $idhorariodetalle,
                'unidades' => $unidades,
                'nombreclase' => $nombreclase,
                'unidades_materia' => $unidades_materia,
                'tabla' => $this->obtenerCalificacionLic($idhorario, $idhorariodetalle),
                'oportunidades' => $this->grupo->showAllOportunidades($this->session->idplantel),
                'controller' => $this
            );

            $this->load->view('docente/header');
            $this->load->view('docente/grupo/calificacion/licenciatura', $data);
            $this->load->view('docente/footer');
        } else {
            $data = array(
                'heading' => 'Error',
                'message' => 'Error intente mas tarde.'
            );
            $this->load->view('docente/header');
            $this->load->view('docente/error/general', $data);
            $this->load->view('docente/footer');
        }
    }

    // FIN EXAMEN LICENCIATURA
    // EXAMEN SECUNDARIA
    public function calificacionSecu($idhorario = '', $idhorariodetalle)
    {
        Permission::grant(uri_string());
        $idhorario = $this->decode($idhorario);
        $idhorariodetalle = $this->decode($idhorariodetalle);

        if ((isset($idhorario) && !empty($idhorario)) && (isset($idhorariodetalle) && !empty($idhorariodetalle))) {
            $unidades = $this->grupo->unidades($this->session->idplantel);
            $detalle_horario = $this->grupo->detalleHorarioDetalle($idhorariodetalle);
            $idprofesormateria = $detalle_horario->idprofesormateria;
            $idmateria = $detalle_horario->idmateria;
            $unidades_materia = $detalle_horario->unidades;
            $estatus_alumno = $detalle_horario->activo;
            $alumns = $this->grupo->alumnosGrupo($idhorario, $idprofesormateria, $idmateria, $estatus_alumno);

            $detalle = $this->grupo->detalleClase($idhorariodetalle);
            $mes = $this->calificacion->allMeses();
            $nombreclase = $detalle[0]->nombreclase;

            $data = array(
                'alumnos' => $alumns,
                'idhorario' => $idhorario,
                'idhorariodetalle' => $idhorariodetalle,
                'unidades' => $unidades,
                'nombreclase' => $nombreclase,
                'mes' => $mes,
                'unidades_materia' => $unidades_materia,
                'tabla' => $this->obtenerCalificacionSecu($idhorario, $idhorariodetalle),
                'oportunidades' => $this->grupo->showAllOportunidades($this->session->idplantel),
                'controller' => $this
            );

            $this->load->view('docente/header');
            $this->load->view('docente/grupo/calificacion/secundaria', $data);
            $this->load->view('docente/footer');
        } else {
            $data = array(
                'heading' => 'Error',
                'message' => 'Error intente mas tarde.'
            );
            $this->load->view('docente/header');
            $this->load->view('docente/error/general', $data);
            $this->load->view('docente/footer');
        }
    }

    public function calificacionPree($idhorario = '')
    {
        Permission::grant(uri_string());
        $idhorario = $this->decode($idhorario);

        if ((isset($idhorario) && !empty($idhorario))) {
            $unidades = $this->grupo->unidades($this->session->idplantel);
            $idprofesor = $this->session->idprofesor;
            $alumns = $this->grupo->alumnosGrupoPreescolar($idhorario, $idprofesor);

            $data = array(
                'alumnos' => $alumns,
                'idhorario' => $idhorario,
                'unidades' => $unidades,
                'tabla' => $this->obtenerCalificacionPree($idhorario),
                'oportunidades' => $this->grupo->showAllOportunidades($this->session->idplantel),
                'controller' => $this
            );

            $this->load->view('docente/header');
            $this->load->view('docente/grupo/calificacion/preescolar', $data);
            $this->load->view('docente/footer');
        } else {
            $data = array(
                'heading' => 'Error',
                'message' => 'Error intente mas tarde.'
            );
            $this->load->view('docente/header');
            $this->load->view('docente/error/general', $data);
            $this->load->view('docente/footer');
        }
    }

    public function updteCalificacionSecu()
    {
        $config = array(

            array(
                'field' => 'calificacion',
                'label' => 'Calificacion',
                'rules' => 'trim|decimal|callback_maxNumber',
                'errors' => array(
                    'decimal' => 'Debe de ser Números decimales.'
                )
            ),
        );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == false) {
            $errors = validation_errors();
            echo json_encode([
                'error' => $errors
            ]);
        } else {
            $idcalificacion = $this->input->post('idcalificacion');
            $iddetallecalificacion = $this->input->post('iddetallecalificacion');
            $calificacion = $this->input->post('calificacion');
            //OPTENER LA SUMA DE CALIFICACION EXEPTO DE QUE SE VA A MODIFICAR
            $detalle_calificacion = $this->grupo->sumaCalificacion($idcalificacion, $iddetallecalificacion);
            if ($detalle_calificacion) {
                //YA EXISTE REGISTRO
                if ($detalle_calificacion[0]->calificacion > 0) {
                    $suma_anterior = $detalle_calificacion[0]->calificacion;
                    $suma_total = $suma_anterior + $calificacion;
                    $meses_anteriores = $detalle_calificacion[0]->contador;
                    $suma_total_meses = $meses_anteriores + 1;
                    $data1 = array(
                        'calificacion' => $calificacion
                    );
                    $this->grupo->updateDetalleCalificacion($iddetallecalificacion, $data1);
                    $nueva_calificacion = $suma_total / $suma_total_meses;

                    $data2 = array(
                        'calificacion' => floordec($nueva_calificacion)
                    );
                    $this->grupo->updateCalificacion($idcalificacion, $data2);
                    echo json_encode([
                        'success' => 'Ok',
                        'mensaje' => 'Fueron modificado la calificación.'
                    ]);
                } else {
                    //ES EL PRIMER REGISTRO
                    $data1 = array(
                        'calificacion' => $calificacion
                    );
                    $this->grupo->updateDetalleCalificacion($iddetallecalificacion, $data1);

                    $data2 = array(
                        'calificacion' => $calificacion
                    );
                    $this->grupo->updateCalificacion($idcalificacion, $data2);
                    echo json_encode([
                        'success' => 'Ok',
                        'mensaje' => 'Fueron modificado la calificación.'
                    ]);
                }
            }
        }
    }

    public function addCalificacionSecu()
    {
        Permission::grant(uri_string());
        $config = array(
            array(
                'field' => 'unidad',
                'label' => 'Unidad',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Seleccionar la Unidad.'
                )
            ),
            array(
                'field' => 'mes',
                'label' => 'Calificacion',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Debe seleccionar el Mes.'
                )
            ),
            array(
                'field' => 'calificacion[]',
                'label' => 'Calificacion',
                'rules' => 'trim|decimal|callback_maxNumber',
                'errors' => array(
                    'decimal' => 'Debe de ser Números decimales.'
                )
            )
        );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == false) {
            $errors = validation_errors();
            echo json_encode([
                'error' => $errors
            ]);
        } else {
            $idhorario = $this->input->post('idhorario');
            $idhorariodetalle = $this->input->post('idhorariodetalle');
            $idalumno = $this->input->post('idalumno');
            $unidad = $this->input->post('unidad');
            $idmes = $this->input->post('mes');
            $validar_mes_unidad = $this->grupo->validarMesUnidad($idmes, $unidad);
            if ($validar_mes_unidad) {
                $calificacion = $this->input->post('calificacion');
                $detalle_oportunidad = $this->grupo->primeraOportunidad($this->session->idplantel);
                $detalle_horario = $this->horario->detalleHorarioDetalle($idhorariodetalle);
                $idmateria = $detalle_horario[0]->idmateria;
                $idprofesor = $this->session->idprofesor;
                $validar_profesor_materia = $this->grupo->validarSiLePerteneceLaMateria($idmateria, $idprofesor, $idhorario);
                if ($validar_profesor_materia) {
                    if ($detalle_oportunidad) {
                        $idopotunidad = $detalle_oportunidad[0]->idoportunidadexamen;
                        $contador_no_insertado = 0;
                        $contador_insertado = 0;
                        foreach ($idalumno as $key => $value) {
                            $idalumno2 = $value;
                            $calificacion_final =  floordec($calificacion[$key]);
                            $validar = $this->grupo->validarAgregarCalificacionXMateria($unidad, $idhorario, $idmateria, '', $idalumno2);
                            if ($validar == false) {
                                // ES LA PRIMERA VEZ QUE SE REGISTRA LA CALIFICACION
                                if (isset($calificacion_final) && !empty($calificacion_final)) {
                                    $data = array(
                                        'idunidad' => $unidad,
                                        'idoportunidadexamen' => $idopotunidad,
                                        'idalumno' => $idalumno2,
                                        'idhorario' => $idhorario,
                                        'idhorariodetalle' => $idhorariodetalle,
                                        'calificacion' => $calificacion_final,
                                        'idusuario' => $this->session->user_id,
                                        'fecharegistro' => date('Y-m-d H:i:s')
                                    );
                                    $idcalificacion = $this->grupo->addCalificacion($data);
                                    $data_detalle = array(
                                        'idcalificacion' => $idcalificacion,
                                        'idmes' => $idmes,
                                        'calificacion' => $calificacion_final,
                                        'idusuario' => $this->session->user_id,
                                        'fecharegistro' => date('Y-m-d H:i:s')
                                    );
                                    $this->grupo->addDetalleCalificacion($data_detalle);
                                    $contador_insertado++;
                                } else {
                                    $contador_no_insertado++;
                                }
                            } else {
                                if (isset($calificacion_final) && !empty($calificacion_final) && $calificacion_final >= 0.00) {
                                    $idcalificacion_registrado = $validar[0]->idcalificacion;
                                    // VALIDAR SI YA EXISTE EL REGISTRO EN TABLA DE DETALLE CALIFICACION
                                    $validar_mes = $this->grupo->validarMesDetalleCalificacion($idmes, $idcalificacion_registrado);
                                    if ($validar_mes == false) {
                                        // SE AGREGA LA CALIFICACION EN LA TABLA DETALLE PORQUE EL MES NO ESTA REGISTRADO
                                        $registro_detalle = $this->grupo->showAllDetalleCalificacion($idcalificacion_registrado);
                                        $total_suma = 0;
                                        $contado = 1;
                                        foreach ($registro_detalle as $row) {
                                            $total_suma += $row->calificacion;
                                            $contado++;
                                        }
                                        $suma = ($total_suma + $calificacion_final) / $contado;
                                        $data = array(
                                            'calificacion' => floordec($suma),
                                            'idusuario' => $this->session->user_id,
                                            'fecharegistro' => date('Y-m-d H:i:s')
                                        );
                                        $editar = $this->grupo->updateCalificacion($idcalificacion_registrado, $data);
                                        if ($editar) {
                                            $data_detalle = array(
                                                'idcalificacion' => $idcalificacion_registrado,
                                                'idmes' => $idmes,
                                                'calificacion' => $calificacion_final,
                                                'idusuario' => $this->session->user_id,
                                                'fecharegistro' => date('Y-m-d H:i:s')
                                            );
                                            $this->grupo->addDetalleCalificacion($data_detalle);
                                            $contador_insertado++;
                                        } else {

                                            $contador_no_insertado++;
                                        }
                                    } else {
                                        if (isset($calificacion_final) && !empty($calificacion_final) && $calificacion_final >= 0.00) {
                                            $idcalificacion2 = $validar_mes[0]->idcalificacion;
                                            $fecharegistro = $validar_mes[0]->fecharegistro;
                                            $fecha_inicio = date('Y-m-d');
                                            $fecha_fin = date('Y-m-d', strtotime($fecharegistro));
                                            $total_dias = dias_pasados($fecha_inicio, $fecha_fin);
                                            if ($total_dias <= $this->dias) {
                                                $iddetallecalificacion = $validar_mes[0]->iddetallecalificacion;
                                                $detalle_calificacion = $this->grupo->sumaCalificacion($idcalificacion2, $iddetallecalificacion);
                                                $suma_anterior = $detalle_calificacion[0]->calificacion;
                                                $suma_total = $suma_anterior + $calificacion_final;
                                                $meses_anteriores = $detalle_calificacion[0]->contador;
                                                $suma_total_meses = $meses_anteriores + 1;
                                                $suma_total2 = $suma_total / $suma_total_meses;
                                                //floordec($suma_total2);
                                                $data2 = array(
                                                    'calificacion' =>   floordec($suma_total2)
                                                );
                                                $this->grupo->updateCalificacion($idcalificacion2, $data2);

                                                $data1 = array(
                                                    'calificacion' => $calificacion_final
                                                );
                                                $this->grupo->updateDetalleCalificacion($iddetallecalificacion, $data1);
                                                $contador_insertado++;
                                            } else {
                                                $contador_no_insertado++;
                                            }
                                        }
                                    }
                                }
                            }
                        }

                        if ($contador_no_insertado > 0) {
                            echo json_encode([
                                'success' => 'Ok',
                                'mensaje' => 'Algunas calificaciones no fueron registrados, porque ya estan registrada.'
                            ]);
                        } else {
                            echo json_encode([
                                'success' => 'Ok',
                                'mensaje' => 'Fueron registrados las calificaciones.'
                            ]);
                        }
                    } else {
                        echo json_encode([
                            'error' => 'No esta registrado la Oportunidad.'
                        ]);
                    }
                } else {
                    echo json_encode([
                        'error' => 'Esta Asignatura no le pertenece a Usted.'
                    ]);
                }
            } else {
                echo json_encode([
                    'error' => 'El mes no le corresponde al trimestre.'
                ]);
            }
        }
    }
    public function test()
    {
        echo floordec(9.9);
    }
    // FIN EXAMEN SECUNDARIA
    public function buscarAsistencia($idhorario, $idhorariodetalle, $fechainicio, $fechafin, $idunidad)
    {
        # code...
        Permission::grant(uri_string());
        $idhorario = $this->decode($idhorario);
        $idhorariodetalle = $this->decode($idhorariodetalle);
        if ((isset($idhorario) && !empty($idhorario)) && (isset($idhorario) && !empty($idhorario)) && (isset($fechainicio) && !empty($fechainicio)) && (isset($fechafin) && !empty($fechafin))) {
            $detalle_horario = $this->grupo->detalleHorarioDetalle($idhorariodetalle);
            $idprofesormateria = $detalle_horario->idprofesormateria;
            $idmateria = $detalle_horario->idmateria;
            $estatus_alumno = $detalle_horario->activo;
            $idclasificacionmateria = $detalle_horario->idclasificacionmateria;
            if ($idclasificacionmateria == 3) {
                $alumns = $this->grupo->alumnosGrupoTaller($idhorario, $idprofesormateria, $idmateria, $estatus_alumno);
            } else {
                $alumns = $this->grupo->alumnosGrupoAsistencia($idhorario, $idprofesormateria, $idmateria, $estatus_alumno);
            }

            $tabla = "";
            if ($alumns != false) {
                $range = ((strtotime($fechafin) - strtotime($fechainicio)) + (24 * 60 * 60)) / (24 * 60 * 60);

                $tabla .= '  <table id="tablageneral2" class="table table-striped  dt-responsive nowrap" cellspacing="0" width="100%">
            <thead class="bg-teal">
            <th>#</th>
            <th>ALUMNO</th>';
                for ($i = 0; $i < $range; $i++) :
                    setlocale(LC_ALL, 'es_ES');
                    $fecha = strftime("%A, %d de %B", strtotime($fechainicio) + ($i * (24 * 60 * 60)));
                    $domingo = date('N', strtotime($fechainicio) + ($i * (24 * 60 * 60)));
                    if ($domingo != '7') {
                        if ($domingo != '6') {
                            $tabla .= '<th>' . utf8_encode($fecha) . '</th>';
                        }
                    }
                endfor;
                $tabla .= '</thead>';
                $n = 1;
                foreach ($alumns as $alumn) {
                    $tabla .= ' <tr>';
                    $tabla .= '<td>' . $n++ . '</td>';
                    $tabla .= '<td >' . $alumn->apellidop . " " . $alumn->apellidom . " " . $alumn->nombre . '</td>';
                    for ($i = 0; $i < $range; $i++) :
                        $date_at = date("Y-m-d", strtotime($fechainicio) + ($i * (24 * 60 * 60)));
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

                                            break;
                                        case 2:
                                            $tabla .= '<span class="label label-warning">' . $asist->nombremotivo . '</span>';
                                            $tabla .= '  <a  href="javascript:void(0)"><i class="fa fa-pencil edit_button"  data-toggle="modal" data-target="#myModal"
				                                  data-idasistencia="' . $asist->idasistencia . '"
				                                  data-idmotivo="' . $asist->idmotivo . '"
				                                  data-alumno="' . $alumn->apellidop . " " . $alumn->apellidom . " " . $alumn->nombre . '"
				                                 style = "color:blue;" title="Editar Calificación"></i> </a>';

                                            break;
                                        case 3:
                                            $tabla .= '<span class="label label-info">' . $asist->nombremotivo . '</span>';
                                            $tabla .= '  <a  href="javascript:void(0)"><i class="fa fa-pencil edit_button"  data-toggle="modal" data-target="#myModal"
				                                  data-idasistencia="' . $asist->idasistencia . '"
				                                  data-idmotivo="' . $asist->idmotivo . '"
				                                  data-alumno="' . $alumn->apellidop . " " . $alumn->apellidom . " " . $alumn->nombre . '"
				                                 style = "color:blue;" title="Editar Calificación"></i> </a>';

                                            break;
                                        case 4:
                                            $tabla .= '<span class="label label-danger">' . $asist->nombremotivo . '</span>';
                                            $tabla .= '  <a  href="javascript:void(0)"><i class="fa fa-pencil edit_button"  data-toggle="modal" data-target="#myModal"
				                                  data-idasistencia="' . $asist->idasistencia . '"
				                                  data-idmotivo="' . $asist->idmotivo . '"
				                                  data-alumno="' . $alumn->apellidop . " " . $alumn->apellidom . " " . $alumn->nombre . '"
				                                 style = "color:blue;" title="Editar Calificación"></i> </a>';

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
            $estatus_alumno = $detalle_horario->activo;
            //$alumns = $this->grupo->alumnosGrupo($idhorario, $idprofesormateria, $idmateria, $estatus_alumno);
            $data = array(
                'alumnos' => $alumns,
                'motivo' => $motivo,
                'idhorario' => $idhorario,
                'idhorariodetalle' => $idhorariodetalle,
                'tabla' => $tabla,
                'nombreclase' => $nombreclase,
                'unidades' => $unidades,
                'controller' => $this
            );
            $this->load->view('docente/header');
            $this->load->view('docente/grupo/busqueda_asistencia', $data);
            $this->load->view('docente/footer');
        } else {
            $data = array(
                'heading' => 'Error',
                'message' => 'Intente mas tarde.'
            );
            $this->load->view('docente/header');
            $this->load->view('docente/error/general', $data);
            $this->load->view('docente/footer');
        }
    }

    public function obetnerAsistencia($idhorario, $fechainicio, $fechafin, $idhorariodetalle)
    {
        Permission::grant(uri_string());
        $detalle_horario = $this->grupo->detalleHorarioDetalle($idhorariodetalle);
        $idprofesormateria = $detalle_horario->idprofesormateria;
        $idmateria = $detalle_horario->idmateria;
        $estatus_alumno = $detalle_horario->activo;
        $idclasificacionmateria = $detalle_horario->idclasificacionmateria;
        if ($idclasificacionmateria == 3) {
            $alumns = $this->grupo->alumnosGrupoTaller($idhorario, $idprofesormateria, $idmateria, $estatus_alumno);
        } else {
            $alumns = $this->grupo->alumnosGrupo($idhorario, $idprofesormateria, $idmateria, $estatus_alumno);
        }
        $tabla = "";

        if ($alumns != false) {
            $range = ((strtotime($fechafin) - strtotime($fechainicio)) + (24 * 60 * 60)) / (24 * 60 * 60);

            $tabla .= '  <table id="tablageneral2" class="table table-striped  dt-responsive nowrap" cellspacing="0" width="100%">
            <thead class="bg-teal">
            <th>#</th>
            <th>ALUMNO</th>';
            for ($i = 0; $i < $range; $i++) :
                setlocale(LC_ALL, 'es_ES');
                $fecha = strftime("%A, %d de %B", strtotime($fechainicio) + ($i * (24 * 60 * 60)));

                $domingo = date('N', strtotime($fechainicio) + ($i * (24 * 60 * 60)));
                if ($domingo != '7') {
                    if ($domingo != '6') {
                        $tabla .= '<th>' . utf8_encode($fecha) . '</th>';
                    }
                }
            endfor;
            $tabla .= '</thead>';
            $n = 1;
            foreach ($alumns as $alumn) {
                $tabla .= ' <tr>';
                $tabla .= '<td>' . $n++ . '</td>';
                $tabla .= '<td >' . $alumn->apellidop . " " . $alumn->apellidom . " " . $alumn->nombre . '</td>';
                for ($i = 0; $i < $range; $i++) :
                    $date_at = date("Y-m-d", strtotime($fechainicio) + ($i * (24 * 60 * 60)));
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


                                        break;
                                    case 2:
                                        $tabla .= '<span class="label label-warning">' . $asist->nombremotivo . '</span>';
                                        $tabla .= '  <a  href="javascript:void(0)"><i class="fa fa-pencil edit_button"  data-toggle="modal" data-target="#myModal"
				                                  data-idasistencia="' . $asist->idasistencia . '"
				                                  data-idmotivo="' . $asist->idmotivo . '"
				                                  data-alumno="' . $alumn->apellidop . " " . $alumn->apellidom . " " . $alumn->nombre . '"
				                                 style = "color:blue;" title="Editar Calificación"></i> </a>';

                                        break;
                                    case 3:
                                        $tabla .= '<span class="label label-info">' . $asist->nombremotivo . '</span>';

                                        $tabla .= '  <a  href="javascript:void(0)"><i class="fa fa-pencil edit_button"  data-toggle="modal" data-target="#myModal"
				                                  data-idasistencia="' . $asist->idasistencia . '"
				                                  data-idmotivo="' . $asist->idmotivo . '"
				                                  data-alumno="' . $alumn->apellidop . " " . $alumn->apellidom . " " . $alumn->nombre . '"
				                                 style = "color:blue;" title="Editar Calificación"></i> </a>';

                                        break;
                                    case 4:
                                        $tabla .= '<span class="label label-danger">' . $asist->nombremotivo . '</span>';
                                        $tabla .= '  <a  href="javascript:void(0)"><i class="fa fa-pencil edit_button"  data-toggle="modal" data-target="#myModal"
				                                  data-idasistencia="' . $asist->idasistencia . '"
				                                  data-idmotivo="' . $asist->idmotivo . '"
				                                  data-alumno="' . $alumn->apellidop . " " . $alumn->apellidom . " " . $alumn->nombre . '"
				                                 style = "color:blue;" title="Editar Calificación"></i> </a>';

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

    public function obtenerCalificacion($idhorario = '', $idhorariodetalle)
    {
        # code...
        Permission::grant(uri_string());
        $unidades = $this->grupo->unidades($this->session->idplantel);
        $detalle_horario = $this->grupo->detalleHorarioDetalle($idhorariodetalle);
        $idprofesormateria = $detalle_horario->idprofesormateria;
        $idmateria = $detalle_horario->idmateria;
        $estatus_alumno = $detalle_horario->activo;
        $idclasificacionmateria = $detalle_horario->idclasificacionmateria;
        if ($idclasificacionmateria == 3) {
            $alumnos = $this->grupo->alumnosGrupoTaller($idhorario, $idprofesormateria, $idmateria, $estatus_alumno);
        } else {
            $alumnos = $this->grupo->alumnosGrupo($idhorario, $idprofesormateria, $idmateria, $estatus_alumno);
        }

        $datoshorario = $this->horario->showNivelGrupo($idhorario);

        $idnivelestudio = $datoshorario->idnivelestudio;
        $detalle_configuracion = $this->configuracion->showAllConfiguracion($this->session->idplantel, $idnivelestudio);
        $tabla = "";
        $tabla .= ' <table id="tablageneral2" class="table table-striped dt-responsive nowrap" cellspacing="0" width="100%">
      <thead class="bg-teal">
      <th>#</th>
      <th>NOMBRE</th>';
        foreach ($unidades as $block) :
            $tabla .= '<th>' . $block->nombreunidad . '</th>';
        endforeach;
        $tabla .= '<th>PROMEDIO</th>';
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
                foreach ($unidades as $block) :
                    $total_unidades += 1;
                    $val = $this->grupo->obtenerCalificacionValidandoMateria($row->idalumno, $block->idunidad, $idhorario, $idmateria);
                    $tabla .= '<td>';
                    if ($val != false) {
                        $suma_calificacion = $suma_calificacion + $val->calificacion;
                        if (validar_calificacion($val->calificacion, $detalle_configuracion[0]->calificacion_minima)) {
                            $tabla .= '<label style="color:red;">' . eliminarDecimalCero(numberFormatPrecision($val->calificacion, 1, '.')) . '  </label>';
                        } else {
                            $tabla .= '<label style="color:green;">' . eliminarDecimalCero(numberFormatPrecision($val->calificacion, 1, '.')) . '  </label>';
                        }
                        $fecha_inicio = date('Y-m-d');
                        $fecha_fin = date('Y-m-d', strtotime($val->fecharegistro));
                        $total_dias = dias_pasados($fecha_inicio, $fecha_fin);
                        if ($total_dias <= $this->dias) {
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
                        $tabla .= '<small>No registrado</small>';
                    }
                    $tabla .= '</td>';
                endforeach;
                $tabla .= '<td>';
                $calificacion_final = numberFormatPrecision($suma_calificacion / $total_unidades, 1, '.');
                if (validar_calificacion($calificacion_final, $detalle_configuracion[0]->calificacion_minima)) {
                    if ($suma_calificacion > 0.0) {
                        $tabla .= '<label style="color:red;">' . eliminarDecimalCero(numberFormatPrecision($suma_calificacion / $total_unidades, 1, '.')) . '</label>';
                    } else {
                        $tabla .= '<label "> </label>';
                    }
                } else {
                    $tabla .= '<label style="color:green;">' . eliminarDecimalCero(numberFormatPrecision($suma_calificacion / $total_unidades, 1, '.')) . '</label>';
                }
                $tabla .= '</td>';
                $tabla .= '</tr>';
            }
        }
        $tabla .= '</table>';
        return $tabla;
    }

    public function obtenerCalificacionSecu($idhorario = '', $idhorariodetalle)
    {
        # code...
        Permission::grant(uri_string());
        $unidades = $this->grupo->unidades($this->session->idplantel);
        $detalle_horario = $this->grupo->detalleHorarioDetalle($idhorariodetalle);
        $idprofesormateria = $detalle_horario->idprofesormateria;
        $idmateria = $detalle_horario->idmateria;
        $estatus_alumno = $detalle_horario->activo;
        $alumnos = $this->grupo->alumnosGrupo($idhorario, $idprofesormateria, $idmateria, $estatus_alumno);
        $datoshorario = $this->horario->showNivelGrupo($idhorario);

        $idnivelestudio = $datoshorario->idnivelestudio;
        $detalle_configuracion = $this->configuracion->showAllConfiguracion($this->session->idplantel, $idnivelestudio);
        $tabla = "";
        $tabla .= ' <table id="tablageneral2" class="table table-striped dt-responsive nowrap" cellspacing="0" width="100%">
      <thead class="bg-teal">
      <th>#</th>
      <th>NOMBRE</th>';
        foreach ($unidades as $block) :
            $tabla .= '<th align="center" >' . $block->nombreunidad . '</th>';
        endforeach;
        $tabla .= '<th >PROMEDIO</th>';
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
                foreach ($unidades as $block) :
                    $total_unidades += 1;
                    $val = $this->grupo->obtenerCalificacionValidandoMateria($row->idalumno, $block->idunidad, $idhorario, $idmateria);

                    $tabla .= '<td align="center">';
                    if ($val) {
                        $idcalificacion = $val->idcalificacion;
                        $detalle_calificacion = $this->grupo->detalleCalificacionSecundaria($idcalificacion);
                        $suma_calificacion = $suma_calificacion + $val->calificaciondetalle;
                        $tabla .= '<label style="font-size:16px;">' . eliminarDecimalCero(numberFormatPrecision($val->calificaciondetalle, 1, '.')) . '  </label>';
                        $fecha_inicio = date('Y-m-d');
                        $fecha_fin = date('Y-m-d', strtotime($val->fecharegistro));
                        $total_dias = dias_pasados($fecha_inicio, $fecha_fin);
                        if ($detalle_calificacion) {
                            $datos = $this->encode($idcalificacion);
                            $tabla .= '       <a   href="' . base_url() . '/Pgrupo/detalleCalificacionSecu/' . $datos . '"><i class="fa fa-eye fa-lg"  style = "color:#3396FF;" title="Ver detalles de las Calificaciones"></i> </a> ';
                        }
                    } else {
                        $tabla .= '<small>No registrado</small>';
                    }
                    $tabla .= '</td>';
                endforeach;
                $tabla .= '<td>';
                $calificacion_final = numberFormatPrecision($suma_calificacion / $total_unidades, 1, '.');
                if (validar_calificacion($calificacion_final, $detalle_configuracion[0]->calificacion_minima)) {
                    if ($suma_calificacion > 0.0) {
                        $tabla .= '<label style="color:red;">' . eliminarDecimalCero(numberFormatPrecision($calificacion_final, 1, '.')) . '</label>';
                    } else {
                        $tabla .= '<label "> </label>';
                    }
                } else {
                    $tabla .= '<label style="color:green;">' . eliminarDecimalCero(numberFormatPrecision($calificacion_final, 1, '.')) . '</label>';
                }
                $tabla .= '</td>';
                $tabla .= '</tr>';
            }
        }
        $tabla .= '</table>';
        return $tabla;
    }
    public  function detalleCalificacionSecu($idcalificacion)
    {
        $idcalificacion  = $this->decode($idcalificacion);
        if (isset($idcalificacion) && !empty($idcalificacion)) {
            $detalle = $this->grupo->detalleMateriaCalificacion($idcalificacion);

            $data = array(
                'detalle' => $detalle
            );
            $this->load->view('docente/header');
            $this->load->view('docente/grupo/calificacion/detalle_calificacion_secu', $data);
            $this->load->view('docente/footer');
        }
    }
    public function obtenerCalificacionPree($idhorario = '')
    {

        Permission::grant(uri_string());
        $unidades = $this->grupo->unidades($this->session->idplantel);
        $idprofesor = $this->session->idprofesor;
        $alumnos = $this->grupo->alumnosGrupoPreescolar($idhorario, $idprofesor);
        $datoshorario = $this->horario->showNivelGrupo($idhorario);

        $idnivelestudio = $datoshorario->idnivelestudio;
        $detalle_configuracion = $this->configuracion->showAllConfiguracion($this->session->idplantel, $idnivelestudio);
        $tabla = "";
        $tabla .= ' <table id="tablageneral2" class="table table-striped dt-responsive nowrap" cellspacing="0" width="100%">
      <thead class="bg-teal">
      <th>#</th>
      <th>NOMBRE</th>';
        foreach ($unidades as $block) :
            $tabla .= '<th>' . $block->nombreunidad . '</th>';
        endforeach;
        $tabla .= '<th>PROMEDIO</th>';
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
                foreach ($unidades as $block) :
                    $total_unidades += 1;
                    $val = $this->grupo->obtenerCalificacion($row->idalumno, $block->idunidad, $idhorariodetalle);
                    $tabla .= '<td>';
                    if ($val) {
                        $idcalificacion = $val->idcalificacion;
                        $detalle_calificacion = $this->grupo->detalleCalificacionSecundaria($idcalificacion);
                        $suma_calificacion = $suma_calificacion + $val->calificacion;
                        $tabla .= '<label>' . $val->calificacion . '  </label>';
                        $fecha_inicio = date('Y-m-d');
                        $fecha_fin = date('Y-m-d', strtotime($val->fecharegistro));
                        $total_dias = dias_pasados($fecha_inicio, $fecha_fin);
                        if ($total_dias <= $this->dias) {
                            $tabla .= '  <a  href="javascript:void(0)"><i class="fa fa-pencil edit_button"  data-toggle="modal" data-target="#myModal"
				                                data-idcalificacion="' . $val->idcalificacion . '"
                                                                data-iddetallecalificacion="' . $detalle_calificacion->iddetallecalificacion . '"
				                                data-proyecto="' . $detalle_calificacion->proyecto . '"
                                                                data-tarea="' . $detalle_calificacion->tarea . '"
                                                                data-participacion="' . $detalle_calificacion->participacion . '"
                                                                data-examen="' . $detalle_calificacion->examen . '"
                                                                data-calificacion="' . $val->calificacion . '"
				                                data-alumno="' . $row->apellidop . " " . $row->apellidom . " " . $row->nombre . '"
			                                   style = "color:blue;" title="Editar Calificación"></i> </a>';
                            $tabla .= '  <a  href="javascript:void(0)"><i class="fa fa-eye detalle_button"  data-toggle="modal" data-target="#myModalDetalle"
				                                data-idcalificacion="' . $val->idcalificacion . '"
                                                                data-iddetallecalificacion="' . $detalle_calificacion->iddetallecalificacion . '"
				                                data-proyecto="' . $detalle_calificacion->proyecto . '"
                                                                data-tarea="' . $detalle_calificacion->tarea . '"
                                                                data-participacion="' . $detalle_calificacion->participacion . '"
                                                                data-examen="' . $detalle_calificacion->examen . '"
                                                                data-calificacion="' . $val->calificacion . '"
				                                data-alumno="' . $row->apellidop . " " . $row->apellidom . " " . $row->nombre . '"
			                                   style = "color:green;" title="Ver detalle Calificación"></i> </a>';
                            $tabla .= '  <a  href="javascript:void(0)"><i class="fa fa-trash delete_button"  data-toggle="modal" data-target="#myModalDelete"
				                                data-idcalificacion="' . $val->idcalificacion . '"
                                                                data-iddetallecalificacion="' . $detalle_calificacion->iddetallecalificacion . '"
				                                data-alumno="' . $row->apellidop . " " . $row->apellidom . " " . $row->nombre . '"
				                               style = "color:red;" title="Eliminar Calificación"></i> </a>';
                        }
                    } else {
                        $tabla .= '<small>No registrado</small>';
                    }
                    $tabla .= '</td>';
                endforeach;
                $tabla .= '<td>';
                $calificacion_final = numberFormatPrecision($suma_calificacion / $total_unidades, 1, '.');
                if (validar_calificacion($calificacion_final, $detalle_configuracion[0]->calificacion_minima)) {
                    if ($suma_calificacion > 0.0) {
                        $tabla .= '<label style="color:red;">' . numberFormatPrecision($suma_calificacion / $total_unidades, 1, '.') . '</label>';
                    } else {
                        $tabla .= '<label "> </label>';
                    }
                } else {
                    $tabla .= '<label style="color:green;">' . numberFormatPrecision($suma_calificacion / $total_unidades, 1, '.') . '</label>';
                }
                $tabla .= '</td>';
                $tabla .= '</tr>';
            }
        }
        $tabla .= '</table>';
        return $tabla;
    }

    public function obtenerCalificacionLic($idhorario = '', $idhorariodetalle)
    {
        # code...
        Permission::grant(uri_string());

        $detalle_horario = $this->grupo->detalleHorarioDetalle($idhorariodetalle);
        $idprofesormateria = $detalle_horario->idprofesormateria;
        $idmateria = $detalle_horario->idmateria;
        $unidades_materia = $detalle_horario->unidades;
        $unidades = "";
        if (isset($unidades_materia) && !empty($unidades_materia)) {
            $this->session->idplantel;
            $unidades = $this->grupo->unidades($this->session->idplantel, $unidades_materia);
        }
        $estatus_alumno = $detalle_horario->activo;
        $alumnos = $this->grupo->alumnosGrupo($idhorario, $idprofesormateria, $idmateria, $estatus_alumno);
        $datoshorario = $this->horario->showNivelGrupo($idhorario);

        $idnivelestudio = $datoshorario->idnivelestudio;
        $detalle_configuracion = $this->configuracion->showAllConfiguracion($this->session->idplantel, $idnivelestudio);
        $tabla = "";
        $tabla .= ' <table id="tablageneral2" class="table table-striped dt-responsive nowrap" cellspacing="0" width="100%">
      <thead class="bg-teal">
      <th>#</th>
      <th>NOMBRE</th>';
        if (isset($unidades) && !empty($unidades)) {
            foreach ($unidades as $block) :
                $tabla .= '<th>' . $block->nombreunidad . '</th>';
            endforeach;
        }
        $tabla .= '<th>PROMEDIO</th>';
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
                if (isset($unidades) && !empty($unidades)) {
                    foreach ($unidades as $block) :
                        $total_unidades += 1;
                        $val = $this->grupo->obtenerCalificacionValidandoMateria($row->idalumno, $block->idunidad, $idhorario, $idmateria);
                        $tabla .= '<td>';
                        if ($val != false) {
                            $suma_calificacion = $suma_calificacion + $val->calificacion;
                            $tabla .= '<label>' . eliminarDecimalCero($val->calificacion) . '  </label>';
                            $fecha_inicio = date('Y-m-d');
                            $fecha_fin = date('Y-m-d', strtotime($val->fecharegistro));
                            $total_dias = dias_pasados($fecha_inicio, $fecha_fin);
                            if ($total_dias <= $this->dias) {
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
                            $tabla .= '<small>No registrado</small>';
                        }
                        $tabla .= '</td>';
                    endforeach;
                }
                $tabla .= '<td>';
                if (isset($unidades) && !empty($unidades)) {
                    $calificacion_final = numberFormatPrecision($suma_calificacion / $total_unidades, 1, '.');
                    if (validar_calificacion($calificacion_final, $detalle_configuracion[0]->calificacion_minima)) {
                        if ($suma_calificacion > 0.0) {
                            $tabla .= '<label style="color:red;">' . eliminarDecimalCero(numberFormatPrecision($suma_calificacion / $total_unidades, 1, '.')) . '</label>';
                        } else {
                            $tabla .= '<label "> </label>';
                        }
                    } else {
                        $tabla .= '<label style="color:green;">' . eliminarDecimalCero(numberFormatPrecision($suma_calificacion / $total_unidades, 1, '.')) . '</label>';
                    }
                }
                $tabla .= '</td>';
                $tabla .= '</tr>';
            }
        }
        $tabla .= '</table>';
        return $tabla;
    }

    public function asistencia($idhorario = '', $idhorariodetalle)
    {
        Permission::grant(uri_string());
        $idhorario = $this->decode($idhorario);
        $idhorariodetalle = $this->decode($idhorariodetalle);
        if ((isset($idhorario) && !empty($idhorario)) && (isset($idhorariodetalle) && !empty($idhorariodetalle))) {
            $detalle_horario = $this->grupo->detalleHorarioDetalle($idhorariodetalle);
            $idprofesormateria = $detalle_horario->idprofesormateria;
            $idmateria = $detalle_horario->idmateria;
            $estatus_alumno = $detalle_horario->activo;
            $idclasificacionmateria = $detalle_horario->idclasificacionmateria;
            if ($idclasificacionmateria == 3) {
                $alumns = $this->grupo->alumnosGrupoTaller($idhorario, $idprofesormateria, $idmateria, $estatus_alumno);
            } else {
                $alumns = $this->grupo->alumnosGrupoAsistencia($idhorario, $idprofesormateria, $idmateria, $estatus_alumno);
            }

            $motivo = $this->grupo->motivoAsistencia();
            $unidades = $this->grupo->unidades($this->session->idplantel);
            $fechainicio = date("Y-m-d");
            $fechafin = date("Y-m-d");
            $table = $this->obetnerAsistencia($idhorario, $fechainicio, $fechafin, $idhorariodetalle);
            $detalle = $this->grupo->detalleClase($idhorariodetalle);

            $nombreclase = $detalle[0]->nombreclase;
            $data = array(
                'alumnos' => $alumns,
                'motivo' => $motivo,
                'idhorario' => $idhorario,
                'idhorariodetalle' => $idhorariodetalle,
                'tabla' => $table,
                'nombreclase' => $nombreclase,
                'unidades' => $unidades,
                'controller' => $this
            );
            $this->load->view('docente/header');
            $this->load->view('docente/grupo/asistencia', $data);
            $this->load->view('docente/footer');
        } else {
            $data = array(
                'heading' => 'Error',
                'message' => 'Error intente mas tarde.'
            );
            $this->load->view('docente/header');
            $this->load->view('docente/error/general', $data);
            $this->load->view('docente/footer');
        }
    }

    public function eliminarAsistenciaFecha()
    {
        $fecha = $this->input->post('fechaeliminar');
        $idhorariodetalle = $this->input->post('horariodetalle');
        $this->grupo->eliminarAsistenciaFecha($idhorariodetalle, $fecha);
    }

    public function examen($idhorario = '', $idhorariodetalle)
    {
        Permission::grant(uri_string());
        $idhorario = $this->decode($idhorario);
        $idhorariodetalle = $this->decode($idhorariodetalle);

        if ((isset($idhorario) && !empty($idhorario)) && (isset($idhorariodetalle) && !empty($idhorariodetalle))) {
            $unidades = $this->grupo->unidades($this->session->idplantel);
            $detalle_horario = $this->grupo->detalleHorarioDetalle($idhorariodetalle);
            $idprofesormateria = $detalle_horario->idprofesormateria;
            $idmateria = $detalle_horario->idmateria;
            $unidades_materia = $detalle_horario->idmateria;
            $estatus_alumno = $detalle_horario->activo;
            $idclasificacionmateria = $detalle_horario->idclasificacionmateria;
            if ($detalle_horario->idclasificacionmateria == 3) {

                $alumns = $this->grupo->alumnosGrupoTaller($idhorario, $idprofesormateria, $idmateria, $estatus_alumno);
            } else {

                $alumns = $this->grupo->alumnosGrupo($idhorario, $idprofesormateria, $idmateria, $estatus_alumno);
            }
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
                'controller' => $this
            );

            $this->load->view('docente/header');
            $this->load->view('docente/grupo/examen', $data);
            $this->load->view('docente/footer');
        } else {
            $data = array(
                'heading' => 'Error',
                'message' => 'Error intente mas tarde.'
            );
            $this->load->view('docente/header');
            $this->load->view('docente/error/general', $data);
            $this->load->view('docente/footer');
        }
    }

    public function tareav2($idhorario = '', $idhorariodetalle)
    {
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
                'detalle_grupo' => $detalle
            );

            $this->load->view('docente/header');
            $this->load->view('docente/grupo/tarea/index', $data);
            $this->load->view('docente/footer');
        } else {
            $data = array(
                'heading' => 'Error',
                'message' => 'Error intente mas tarde.'
            );
            $this->load->view('docente/header');
            $this->load->view('docente/error/general', $data);
            $this->load->view('docente/footer');
        }
    }

    public function revisar($idtarea)
    {
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
                    'message' => 'El registro de la tarea no es de usted.'
                );
                $this->load->view('docente/header');
                $this->load->view('docente/error/general', $data);
                $this->load->view('docente/footer');
            }
        } else {
            $data = array(
                'heading' => 'Error',
                'message' => 'No de pasaron los parametros correctos.'
            );
            $this->load->view('docente/header');
            $this->load->view('docente/error/general', $data);
            $this->load->view('docente/footer');
        }
    }

    public function tarea($idhorario = '', $idhorariodetalle)
    {
        Permission::grant(uri_string());
        $idhorario = $this->decode($idhorario);
        $idhorariodetalle = $this->decode($idhorariodetalle);
        if ((isset($idhorario) && !empty($idhorario)) && (isset($idhorariodetalle) && !empty($idhorariodetalle))) {
            $data = array(
                'idhorario' => $idhorario,
                'idhorariodetalle' => $idhorariodetalle,
                'tareas' => $this->grupo->allTarea($idhorariodetalle),
                'controller' => $this
            );

            $this->load->view('docente/header');
            $this->load->view('docente/grupo/tarea', $data);
            $this->load->view('docente/footer');
        } else {
            $data = array(
                'heading' => 'Error',
                'message' => 'Error intente mas tarde.'
            );
            $this->load->view('docente/header');
            $this->load->view('docente/error/general', $data);
            $this->load->view('docente/footer');
        }
    }

    public function addCalificacion()
    {
        Permission::grant(uri_string());
        $config = array(
            array(
                'field' => 'unidad',
                'label' => 'Unidad',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Seleccionar la Unidad.'
                )
            ),
            array(
                'field' => 'calificacion[]',
                'label' => 'Calificacion',
                'rules' => 'trim|numeric|callback_maxNumber',
                'errors' => array(
                    'numeric' => 'Las calificaciones debe de ser solo numeros.'

                )
            )
        );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == false) {
            $errors = validation_errors();
            echo json_encode([
                'error' => $errors
            ]);
        } else {
            $idhorario = $this->input->post('idhorario');
            $idhorariodetalle = $this->input->post('idhorariodetalle');
            $idalumno = $this->input->post('idalumno');
            $unidad = $this->input->post('unidad');
            $calificacion = $this->input->post('calificacion');
            $detalle_horario = $this->horario->detalleHorarioDetalle($idhorariodetalle);
            $idmateria = $detalle_horario[0]->idmateria;
            $detalle_oportunidad = $this->grupo->primeraOportunidad($this->session->idplantel);
            $idprofesor = $this->session->idprofesor;
            $validar_profesor_materia = $this->grupo->validarSiLePerteneceLaMateria($idmateria, $idprofesor, $idhorario);
            if ($validar_profesor_materia) {
                if ($detalle_oportunidad) {
                    $idopotunidad = $detalle_oportunidad[0]->idoportunidadexamen;
                    $contador_no_insertado = 0;
                    $contador_insertado = 0;
                    foreach ($idalumno as $key => $value) {
                        $idalumno2 = $value;
                        $calificacion_final = $calificacion[$key];
                        $validar = $this->grupo->validarAgregarCalificacionXMateria($unidad, $idhorario, $idmateria, '', $idalumno2);
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
                                    'fecharegistro' => date('Y-m-d H:i:s')
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
                        echo json_encode([
                            'success' => 'Ok',
                            'mensaje' => 'Algunas calificaciones no fueron registrados, porque ya estan registrada.'
                        ]);
                    } else {
                        echo json_encode([
                            'success' => 'Ok',
                            'mensaje' => 'Fueron registrados las calificaciones.'
                        ]);
                    }
                } else {
                    echo json_encode([
                        'error' => 'No esta registrado la Oportunidad.'
                    ]);
                }
            } else {
                echo json_encode([
                    'error' => 'Esta Asignatura no le pertenece a Usted.'
                ]);
            }
        }
    }

    public function addAsistencia()
    {
        Permission::grant(uri_string());
        $config = array(
            array(
                'field' => 'fecha',
                'label' => 'Unidad',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Debe de seleccionar la Fecha.'
                )
            ),
            array(
                'field' => 'unidad',
                'label' => 'Unidad',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Debe de seleccionar la Unidad.'
                )
            ),
            array(
                'field' => 'motivo[]',
                'label' => 'Asistencia',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Debe de seleccionar una Opción.'
                )
            )
        );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == false) {
            $errors = validation_errors();
            echo json_encode([
                'error' => $errors
            ]);
        } else {

            $idhorario = $this->input->post('idhorario');
            $idunidad = $this->input->post('unidad');
            $idhorariodetalle = $this->input->post('idhorariodetalle');
            $idalumno = $this->input->post('idalumno');
            $motivo = $this->input->post('motivo');
            $fecha = $this->input->post('fecha');
            $numero_semana_enviado = date('W', strtotime($fecha));
            $semana_actual = date('W');
            //if ($semana_actual == $numero_semana_enviado) {
            $detalle_horario = $this->horario->detalleHorarioDetalle($idhorariodetalle);
            $idmateria = $detalle_horario[0]->idmateria;
            $validar = $this->grupo->validarAgregarAsistenciaXMateria($fecha, $idhorario, $idmateria);
            if ($validar == false) {
                foreach ($idalumno as $key => $value) {
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
                        'fecharegistro' => date('Y-m-d H:i:s')
                    );
                    $this->grupo->addAsistencia($data);
                }
                echo json_encode([
                    'success' => 'Ok'
                ]);
            } else {
                echo json_encode([
                    'error' => 'Las Asistencias ya estan registradas para esta Fecha.'
                ]);
            }
            /*} else {
                echo json_encode([
                    'error' => 'Solo puedes trabajar en la semana actual.'
                ]);
            }*/
        }
    }

    public function updateAsistencia()
    {
        Permission::grant(uri_string());
        $config = array(
            array(
                'field' => 'motivo',
                'label' => 'Asistencia',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Debe de seleccionar una Opción.'
                )
            )
        );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == false) {
            $errors = validation_errors();
            echo json_encode([
                'error' => $errors
            ]);
        } else {
            $idasistencia = $this->input->post('idasistencia');
            $motivo = $this->input->post('motivo');
            $data = array(
                'idmotivo' => $motivo,
                'idusuario' => $this->session->user_id,
                'fecharegistro' => date('Y-m-d H:i:s')
            );
            $valu = $this->grupo->updateAsistencia($idasistencia, $data);
            if ($valu) {
                echo json_encode([
                    'success' => 'Ok'
                ]);
            } else {
                echo json_encode([
                    'error' => 'Error... Intente mas tarde.'
                ]);
            }
        }
    }

    public function addTarea()
    {
        Permission::grant(uri_string());
        $config = array(
            array(
                'field' => 'fechaentrega',
                'label' => 'Unidad',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'La fecha de entrega es requerido.'
                )
            ),
            array(
                'field' => 'tarea',
                'label' => 'Calificación',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'La tarea es requerido'
                )
            )
        );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == false) {
            $errors = validation_errors();
            echo json_encode([
                'error' => $errors
            ]);
        } else {
            $idhorario = $this->input->post('idhorario');
            $idhorariodetalle = $this->input->post('idhorariodetalle');
            $tarea = $this->input->post('tarea');
            $fechaentrega = $this->input->post('fechaentrega');
            $data = array(
                'idhorario' => $idhorario,
                'idhorariodetalle' => $idhorariodetalle,
                'tarea' => $tarea,
                'fechaentrega' => $fechaentrega,
                'idnotificacionalumno' => 1,
                'idnotificaciontutor' => 1,
                'idusuario' => $this->session->user_id,
                'fecharegistro' => date('Y-m-d H:i:s')
            );
            $value = $this->grupo->addTarea($data);

            echo json_encode([
                'success' => 'Ok'
            ]);
        }
    }

    public function addMensaje()
    {
        Permission::grant(uri_string());
        $config = array(
            array(
                'field' => 'mensaje',
                'label' => 'Calificación',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'El mensaje es requerido'
                )
            )
        );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == false) {
            $errors = validation_errors();
            echo json_encode([
                'error' => $errors
            ]);
        } else {
            $idhorario = $this->input->post('idhorario');
            $idhorariodetalle = $this->input->post('idhorariodetalle');
            $mensaje = $this->input->post('mensaje');

            $data = array(
                'idhorario' => $idhorario,
                'idhorariodetalle' => $idhorariodetalle,
                'mensaje' => $mensaje,
                'eliminado' => 0,
                'idnotificacionalumno' => 1,
                'idnotificaciontutor' => 1,
                'idusuario' => $this->session->user_id,
                'fecharegistro' => date('Y-m-d H:i:s')
            );
            $this->mensaje->addMensaje($data);

            echo json_encode([
                'success' => 'Ok'
            ]);
        }
    }

    public function updateTarea()
    {
        Permission::grant(uri_string());
        $config = array(
            array(
                'field' => 'fechaentrega',
                'label' => 'Unidad',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Fecha de entrega es requerido.'
                )
            ),
            array(
                'field' => 'tarea',
                'label' => 'Calificación',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'La tarean es requerido'
                )
            )
        );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == false) {
            $errors = validation_errors();
            echo json_encode([
                'error' => $errors
            ]);
        } else {
            $idtarea = $this->input->post('idtarea');
            $tarea = $this->input->post('tarea');
            $fechaentrega = $this->input->post('fechaentrega');

            $data = array(
                'tarea' => $tarea,
                'fechaentrega' => $fechaentrega,
                'idnotificacionalumno' => 1,
                'idnotificaciontutor' => 1,
                'idusuario' => $this->session->user_id,
                'fecharegistro' => date('Y-m-d H:i:s')
            );
            $this->grupo->updateTarea($idtarea, $data);

            echo json_encode([
                'success' => 'Ok'
            ]);
        }
    }

    public function updateMensaje()
    {
        Permission::grant(uri_string());
        $config = array(
            array(
                'field' => 'mensaje',
                'label' => 'Calificación',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'El mensaje es requerido'
                )
            )
        );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == false) {
            $errors = validation_errors();
            echo json_encode([
                'error' => $errors
            ]);
        } else {
            $idmensaje = $this->input->post('idmensaje');
            $mensaje = $this->input->post('mensaje');
            $data = array(
                'mensaje' => $mensaje,
                'idnotificacionalumno' => 1,
                'idnotificaciontutor' => 1,
                'idusuario' => $this->session->user_id,
                'fecharegistro' => date('Y-m-d H:i:s')
            );
            $this->mensaje->updateMensaje($idmensaje, $data);

            echo json_encode([
                'success' => 'Ok'
            ]);
        }
    }

    public function eliminarTarea($idhorario, $idhorariodetalle, $idtarea)
    {
        Permission::grant(uri_string());
        # code...
        $idhorario = $this->decode($idhorario);
        $idhorariodetalle = $this->decode($idhorariodetalle);
        $idtarea = $this->decode($idtarea);
        $this->grupo->eliminarTarea($idtarea);
        redirect('Pgrupo/tarea/' . $this->encode($idhorario) . '/' . $this->encode($idhorariodetalle));
    }

    public function eliminarMensaje($idhorario, $idhorariodetalle, $idmensaje)
    {
        Permission::grant(uri_string());
        # code...
        $idhorario = $this->decode($idhorario);
        $idhorariodetalle = $this->decode($idhorariodetalle);
        $idmensaje = $this->decode($idmensaje);
        $data = array(
            'eliminado' => 1
        );
        $this->mensaje->updateMensaje($idmensaje, $data);
        redirect('Pgrupo/mensaje/' . $this->encode($idhorario) . '/' . $this->encode($idhorariodetalle));
    }

    public function mensaje($idhorario = '', $idhorariodetalle = '')
    {
        Permission::grant(uri_string());
        $idhorario = $this->decode($idhorario);
        $idhorariodetalle = $this->decode($idhorariodetalle);
        if ((isset($idhorario) && !empty($idhorario)) && (isset($idhorariodetalle) && !empty($idhorariodetalle))) {
            $data = array(
                'idhorario' => $idhorario,
                'idhorariodetalle' => $idhorariodetalle,
                'mensajes' => $this->mensaje->showAllMensaje($idhorariodetalle),
                'controller' => $this
            );
            $this->load->view('docente/header');
            $this->load->view('docente/grupo/mensaje', $data);
            $this->load->view('docente/footer');
        } else {
            $data = array(
                'heading' => 'Error',
                'message' => 'Error intente mas tarde.'
            );
            $this->load->view('docente/header');
            $this->load->view('docente/error/general', $data);
            $this->load->view('docente/footer');
        }
    }

    public function eliminarCalificacion()
    {
        # code...
        Permission::grant(uri_string());
        $idcalificacion = $this->input->post('idcalificacion');
        $datelle = $this->grupo->detalleCalificacion($idcalificacion);
        $fecha_inicio = date('Y-m-d');
        $fecha_fin = date('Y-m-d', strtotime($datelle->fecharegistro));
        $total_dias = dias_pasados($fecha_inicio, $fecha_fin);
        if ($total_dias <= $this->dias) {
            $value = $this->grupo->deleteCalificacion($idcalificacion);
            if ($value) {
                echo json_encode([
                    'success' => 'Ok'
                ]);
            } else {
                echo json_encode([
                    'error' => 'Error, Intente mas tarde.'
                ]);
            }
        } else {
            echo json_encode([
                'error' => 'Ya pasaron los 3 dias habiles.'
            ]);
        }
    }

    public function eliminarCalificacionSecu()
    {
        # code...
        Permission::grant(uri_string());
        $idcalificacion = $this->input->post('idcalificacion');
        $idcalificacion_detalle = $this->input->post('iddetallecalificacion');
        $datelle = $this->grupo->detalleCalificacion($idcalificacion);
        $fecha_inicio = date('Y-m-d');
        $fecha_fin = date('Y-m-d', strtotime($datelle->fecharegistro));
        $total_dias = dias_pasados($fecha_inicio, $fecha_fin);
        if ($total_dias <= $this->dias) {
            $value = $this->grupo->deleteCalificacion($idcalificacion);
            if ($value) {
                echo json_encode([
                    'success' => 'Ok'
                ]);
            } else {
                echo json_encode([
                    'error' => 'Error, Intente mas tarde.'
                ]);
            }
        } else {
            echo json_encode([
                'error' => 'Ya pasaron los 3 dias habiles.'
            ]);
        }
    }

    public function eliminarAsistencia()
    {
        # code...
        Permission::grant(uri_string());
        $idasistencia = $this->input->post('idasistencia');
        $value = $this->grupo->deleteAsistencia($idasistencia);
        if ($value) {
            echo json_encode([
                'success' => 'Ok'
            ]);
        } else {
            echo json_encode([
                'error' => 'Error, Intente mas tarde.'
            ]);
        }
    }

    public function maxNumber($num)
    {
        if ($num >= 0.0 && $num <= 10) {
            return true;
        } else {
            $this->form_validation->set_message('maxNumber', 'Las calificaciones debe de ser entre 0.0 a 10');
            return false;
        }
    }

    public function maxNumberSecundaria($num)
    {
        if ($num >= 0.00 && $num <= 10.00) {
            return true;
        } else {
            $this->form_validation->set_message('maxNumber',  'Las calificaciones debe de ser entre 0.0 a 10');
            return false;
        }
    }

    public function updateCalificacion()
    {
        Permission::grant(uri_string());
        $config = array(
            array(
                'field' => 'calificacion',
                'label' => 'Calificacion',
                'rules' => 'trim|required|number|callback_maxNumber',
                'errors' => array(
                    'required' => 'Escriba la calificacion.',
                    'number' => 'Debe de ser solo numero la calificacion.'
                )
            )
        );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == false) {
            $errors = validation_errors();
            echo json_encode([
                'error' => $errors
            ]);
        } else {
            $idcalificacion = $this->input->post('idcalificacion');
            $calificacion = $this->input->post('calificacion');
            $detalle_calificacion = $this->grupo->detalleCalificacion($idcalificacion);
            $fecha_inicio = date('Y-m-d');
            $fecha_fin = date('Y-m-d', strtotime($detalle_calificacion->fecharegistro));
            $total_dias = dias_pasados($fecha_inicio, $fecha_fin);
            if ($total_dias <= $this->dias) {
                $data = array(
                    'calificacion' => $calificacion,
                    'idusuario' => $this->session->user_id
                );
                $this->grupo->updateCalificacion($idcalificacion, $data);

                echo json_encode([
                    'success' => 'Ok'
                ]);
            } else {
                echo json_encode([
                    'error' => 'Ya pasaron los 3 dias habiles.'
                ]);
            }
        }
    }

    /* public function updateCalificacionSecu()
    {
        Permission::grant(uri_string());
        $config = array(
            array(
                'field' => 'proyecto',
                'label' => 'Proyecto',
                'rules' => 'trim|required|decimal|callback_maxNumberSecundaria',
                'errors' => array(
                    'required' => 'Porcentaje de Proyecto requerido.'
                )
            ),
            array(
                'field' => 'tarea',
                'label' => 'Trabajo en Casa',
                'rules' => 'trim|required|decimal|callback_maxNumberSecundaria',
                'errors' => array(
                    'required' => 'Porcentaje de Trabajo en Casa requerido.'
                )
            ),
            array(
                'field' => 'participacion',
                'label' => 'Participación',
                'rules' => 'trim|required|decimal|callback_maxNumberSecundaria',
                'errors' => array(
                    'required' => 'Porcentaje de Participación requerido.'
                )
            ),
            array(
                'field' => 'examen',
                'label' => 'Examen',
                'rules' => 'trim|required|decimal|callback_maxNumberSecundaria',
                'errors' => array(
                    'required' => 'Porcentaje de Examen requerido.'
                )
            )
        );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == false) {
            $errors = validation_errors();
            echo json_encode([
                'error' => $errors
            ]);
        } else {
            $idcalificacion = $this->input->post('idcalificacion');
            $iddetallecalificacion = $this->input->post('iddetallecalificacion'); 
            $proyeco = $this->input->post('proyecto');
            $tarea = $this->input->post('tarea');
            $participacion = $this->input->post('participacion');
            $examen = $this->input->post('examen');
            $calificacion = ($proyeco + $tarea + $participacion + $examen) / 10;
            $detalle_calificacion = $this->grupo->detalleCalificacion($idcalificacion);

            $fecha_inicio = date('Y-m-d');
            $fecha_fin = date('Y-m-d', strtotime($detalle_calificacion->fecharegistro));
            $total_dias = dias_pasados($fecha_inicio, $fecha_fin);
            if ($total_dias <= 3) {
                $data = array(
                    'calificacion' => $calificacion,
                    'idusuario' => $this->session->user_id
                );
                $this->grupo->updateCalificacion($idcalificacion, $data);
                $data_detalle = array(
                    'proyecto' => $proyeco,
                    'tarea' => $tarea,
                    'participacion' => $participacion,
                    'examen' => $examen
                );
                $this->grupo->updateDetalleCalificacion($iddetallecalificacion, $data_detalle);
                echo json_encode([
                    'success' => 'Ok'
                ]);
            } else {
                echo json_encode([
                    'error' => 'Ya pasaron los 3 dias habiles.'
                ]);
            }
        }
    }*/

    public function eliminarCalificacionUnidadRecuperacion()
    {
        Permission::grant(uri_string());
        $unidad = $this->input->post('idunidad');
        $idoportunidad = $this->input->post('idoportunidad');
        $horariodetalle = $this->input->post('horariodetalle');
        $detalle_horario = $this->horario->detalleHorarioDetalle($horariodetalle);
        $idhorario = $detalle_horario[0]->idhorario;
        $idmateria = $detalle_horario[0]->idmateria;
        $detalle_calificacion = $this->grupo->detalleCalificacionUnidadXMateriaOportunidad($unidad, $idhorario, $idmateria, $idoportunidad);
        $eliminado = 0;
        $no_eliminado = 0;
        if ($detalle_calificacion) {
            if (isset($detalle_calificacion) && !empty($detalle_calificacion)) {
                foreach ($detalle_calificacion as $row) {
                    $fecha_inicio = date('Y-m-d');
                    $fecha_fin = date('Y-m-d', strtotime($row->fecharegistro));
                    $total_dias = dias_pasados($fecha_inicio, $fecha_fin);
                    $idhorariodetalle = $row->idhorariodetalle;
                    if ($total_dias <= $this->dias) {
                        $this->grupo->eliminarCalificacionUnidad($unidad, $idhorariodetalle, $idoportunidad);
                        $eliminado = $eliminado + 1;
                        /*echo json_encode([
                            'success' => 'Ok'
                        ]);*/
                    } else {
                        $no_eliminado = $no_eliminado + 1;
                        /* echo json_encode([
                            'error' => 'Ya pasaron los 3 dias habiles. 2'
                        ]);*/
                    }
                }
                if ($eliminado > 0 && $no_eliminado == 0) {
                    echo json_encode([
                        'success' => 'Ok',
                        'mensaje' => 'Fueron eliminados las calificaciones con exito.'
                    ]);
                }
                if ($eliminado > 0 && $no_eliminado > 0) {
                    echo json_encode([
                        'success' => 'Ok',
                        'mensaje' => 'Algunas calificaciones no fueron eliminadas.'
                    ]);
                }
                if ($eliminado == 0 && $no_eliminado > 0) {
                    echo json_encode([
                        'success' => 'Ok',
                        'mensaje' => 'No fueron eliminadas las calificaciones.'
                    ]);
                }
            } else {
                echo json_encode([
                    'success' => 'Ok',
                    'mensaje' => 'No hay calificaciones que eliminar.'
                ]);
            }
        } else {
            echo json_encode([
                'success' => 'OK',
                'mensaje' => 'Ya pasaron los 3 dias habiles. 1'
            ]);
        }
    }

    public function eliminarCalificacionUnidadRecuperacionSecu()
    {
        Permission::grant(uri_string());
        $unidad = $this->input->post('idunidad');
        $idoportunidad = $this->input->post('idoportunidad');
        $horariodetalle = $this->input->post('horariodetalle');
        $detalle_calificacion = $this->grupo->detalleCalificacionUnidad($unidad, $horariodetalle);
        if ($detalle_calificacion) {
            $fecha_inicio = date('Y-m-d');
            $fecha_fin = date('Y-m-d', strtotime($detalle_calificacion->fecharegistro));
            $total_dias = dias_pasados($fecha_inicio, $fecha_fin);
            if ($total_dias <= 3) {
                $registros = $this->grupo->showAllCalificacionUnidad($unidad, $horariodetalle, $idoportunidad);
                if (isset($registros) && !empty($registros)) {
                    foreach ($registros as $value) {
                        $this->grupo->eliminarDetalleCalificacionUnidadSecu($value->idcalificacion);
                    }
                }
                $this->grupo->eliminarCalificacionUnidad($unidad, $horariodetalle, $idoportunidad);

                echo json_encode([
                    'success' => 'Ok'
                ]);
            } else {
                echo json_encode([
                    'error' => 'Ya pasaron los 3 dias habiles.'
                ]);
            }
        } else {
            echo json_encode([
                'success' => 'vacio',
                'mensaje' => 'Ya pasaron los 3 dias habiles.'
            ]);
        }
    }

    public function eliminarCalificacionUnidad()
    {
        Permission::grant(uri_string());
        $config = array(
            array(
                'field' => 'unidad',
                'label' => 'Calificacion',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Seleccionar la Unidad.'
                )
            )
        );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == false) {
            $errors = validation_errors();
            echo json_encode([
                'error' => $errors
            ]);
        } else {
            $detalle_oportunidad = $this->grupo->primeraOportunidad($this->session->idplantel);
            if ($detalle_oportunidad) {
                $idopotunidad = $detalle_oportunidad[0]->idoportunidadexamen;
                $unidad = $this->input->post('unidad');
                $horariodetalle = $this->input->post('horariodetalle');
                $detalle_horario = $this->horario->detalleHorarioDetalle($horariodetalle);
                $idmateria = $detalle_horario[0]->idmateria;
                $idhorario = $detalle_horario[0]->idhorario;
                $detalle_calificacion = $this->grupo->detalleCalificacionUnidadXMateria($unidad, $idhorario, $idmateria);
                if ($detalle_calificacion) {
                    $fecha_inicio = date('Y-m-d');
                    $fecha_fin = date('Y-m-d', strtotime($detalle_calificacion[0]->fecharegistro));
                    $total_dias = dias_pasados($fecha_inicio, $fecha_fin);
                    if ($total_dias <= $this->dias) {
                        if (isset($detalle_calificacion) && !empty($detalle_calificacion)) {
                            foreach ($detalle_calificacion  as $row) {
                                $idhorariodetalle = $row->idhorariodetalle;
                                $this->grupo->eliminarCalificacionUnidad($unidad, $idhorariodetalle, $idopotunidad);
                            }
                        }


                        echo json_encode([
                            'success' => 'Ok'
                        ]);
                    } else {
                        echo json_encode([
                            'error' => 'Ya pasaron los 3 dias habiles.'
                        ]);
                    }
                } else {
                    echo json_encode([
                        'success' => 'vacio',
                        'mensaje' => 'No existe calificaciones para eliminar.'
                    ]);
                }
            } else {
                echo json_encode([
                    'error' => 'No esta registrado la Oportunidad.'
                ]);
            }
        }
    }

    public function eliminarCalificacionUnidadSecu()
    {
        Permission::grant(uri_string());
        $config = array(
            array(
                'field' => 'unidad',
                'label' => 'Calificacion',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Seleccionar la Unidad.'
                )
            ),
            array(
                'field' => 'meseliminar',
                'label' => 'Mes',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Seleccionar el Mes.'
                )
            )
        );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == false) {
            $errors = validation_errors();
            echo json_encode([
                'error' => $errors
            ]);
        } else {
            $detalle_oportunidad = $this->grupo->primeraOportunidad($this->session->idplantel);
            if ($detalle_oportunidad) {

                $idopotunidad = $detalle_oportunidad[0]->idoportunidadexamen;
                $unidad = $this->input->post('unidad');
                $horariodetalle = $this->input->post('horariodetalle');
                $detalle_horario = $this->horario->detalleHorarioDetalle($horariodetalle);
                $idmateria = $detalle_horario[0]->idmateria;
                $idhorario = $detalle_horario[0]->idhorario;
                $idmes = $this->input->post('meseliminar');
                $detalle_calificacion1 = $this->grupo->detalleCalificacionUnidadXMes($unidad, $idhorario, $idmateria, $idmes);
                if ($detalle_calificacion1) {

                    $fecha_inicio = date('Y-m-d');
                    $fecha_fin = date('Y-m-d', strtotime($detalle_calificacion1->fecharegistro));
                    $total_dias = dias_pasados($fecha_inicio, $fecha_fin);
                    if ($total_dias <= $this->dias) {

                        $calificacion = $this->grupo->showAllCalificacionUnidadXMateria($unidad, $idhorario, $idmateria, $idopotunidad);
                        if ($calificacion) {
                            foreach ($calificacion as $row) {
                                $idcalificacion = $row->idcalificacion;
                                $registros_detalle = $this->grupo->showAllDetalleCalificacion($idcalificacion);
                                if ($registros_detalle) {
                                    foreach ($registros_detalle as $detalle) {

                                        $iddetallecalificacion = $detalle->iddetallecalificacion;
                                        $detalle->idmes;
                                        if ($idmes == $detalle->idmes) {
                                            $detalle_calificacion = $this->grupo->sumaCalificacion($idcalificacion, $iddetallecalificacion);
                                            if ($detalle_calificacion) {

                                                if ($detalle_calificacion[0]->calificacion > 0) {
                                                    $suma_anterior = $detalle_calificacion[0]->calificacion;
                                                    $meses_anteriores = $detalle_calificacion[0]->contador;
                                                    $data2 = array(
                                                        'calificacion' => numberFormatPrecision($suma_anterior / $meses_anteriores, 1, '.')
                                                    );

                                                    $this->grupo->updateCalificacion($idcalificacion, $data2);
                                                    $this->grupo->eliminarDetalleCalificacionXId($iddetallecalificacion);

                                                    //NO ES EL PRIMER REGISTRO
                                                } else {

                                                    //ES EL PRIMER REGISTRO
                                                    $this->grupo->eliminarDetalleCalificacionXId($iddetallecalificacion);;
                                                    $this->grupo->deleteCalificacion($idcalificacion);
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        echo json_encode([
                            'success' => 'Ok',
                            'mensaje' => 'Fueron Eliminados todas las calificaciones.'
                        ]);
                    } else {
                        echo json_encode([
                            'error' => 'Ya pasaron los 3 dias habiles.'
                        ]);
                    }
                } else {
                    echo json_encode([
                        'success' => 'vacio',
                        'mensaje' => 'No existe calificaciones para eliminar.'
                    ]);
                }
            } else {
                echo json_encode([
                    'error' => 'No esta registrado la Oportunidad.'
                ]);
            }
        }
    }

    public function obtenerCalificacionRecupaacion($idhorario = '', $idhorariodetalle, $idoportunidad_anterior, $idopotunidad)
    {
        $detalle_horario = $this->grupo->detalleClase($idhorariodetalle);
        $idprofesormateria = $detalle_horario[0]->idprofesormateria;
        $idmateria = $detalle_horario[0]->idmateria;
        $detalle_oportunidad = $this->grupo->detalleOportunidad($idoportunidad_anterior);
        $numero_oportunidad = $detalle_oportunidad->numero;

        $alumnos = $this->grupo->obtenerAlumnoRecuperar($idhorario, $idoportunidad_anterior, $idprofesormateria);

        $datoshorario = $this->horario->showNivelGrupo($idhorario);
        $idnivelestudio = $datoshorario->idnivelestudio;
        $detalle_configuracion = $this->configuracion->showAllConfiguracion($this->session->idplantel, $idnivelestudio);
        $tabla = "";
        $tabla .= ' <table id="tablageneral2" class="table table-striped dt-responsive nowrap" cellspacing="0" width="100%">
            <thead class="bg-teal">
            <th>#</th>
            <th>NOMBRE</th>';
        $tabla .= '<th>CALIFICACIÓN</th>';
        $tabla .= '</thead>';
        $c = 1;
        $total_unidades = 0;
        if (isset($alumnos) && !empty($alumnos)) {
            $suma_calificacion_verificar = 0;
            $mostrar = false;
            foreach ($alumnos as $row) {
                $totalunidades = 0;

                $totalunidades = $row->unidades;

                $unidadesregistradas = $row->unidades;
                $validar = $this->calificacion->verificarCalificacionSiSeMuestraXMateria($row->idalumno, $idhorario, $idmateria);
                if ($validar) {
                    $suma_calificacion_verificar = 0;
                    foreach ($validar as $rowv) {
                        $suma_calificacion_verificar += $rowv->calificacion;
                    }
                    if ($suma_calificacion_verificar > 0) {
                        $mostrar = TRUE;
                    } else {
                        $mostrar = FALSE;
                    }
                } else {
                    $mostrar = TRUE;
                }
                if ($mostrar) {
                    if ($numero_oportunidad == 1) {
                        if ($row->mostrar == "SI") {
                            if (validar_calificacion($row->calificacion, $detalle_configuracion[0]->calificacion_minima)) {
                                //REPROBADA
                                $tabla .= '<tr>';
                                $tabla .= '<td>' . $c++ . '</td>';
                                $tabla .= '<td>' . $row->apellidop . " " . $row->apellidom . " " . $row->nombre . '</td>';
                                $detalle_calificacion = $this->grupo->obtenerCalificacionRecuperadoXMateria($row->idalumno, $idopotunidad, $idhorario, $idprofesormateria);
                                if ($detalle_calificacion) {

                                    $tabla .= '<td>';
                                    $calificacion_final = numberFormatPrecision($detalle_calificacion->calificacion, 1, '.');
                                    if (validar_calificacion($calificacion_final, $detalle_configuracion[0]->calificacion_minima)) {
                                        if ($calificacion_final > 0.0) {
                                            $tabla .= '<label style="color:red;">' . eliminarDecimalCero(numberFormatPrecision($calificacion_final, 1, '.')) . '</label>';
                                            $fecha_inicio = date('Y-m-d');
                                            $fecha_fin = date('Y-m-d', strtotime($detalle_calificacion->fecharegistro));
                                            $total_dias = dias_pasados($fecha_inicio, $fecha_fin);
                                            if ($total_dias <= $this->dias) {
                                                $tabla .= '  <a  href="javascript:void(0)"><i class="fa fa-pencil edit_button"  data-toggle="modal" data-target="#myModal"
                                            data-idcalificacion="' . $detalle_calificacion->idcalificacion . '"
                                            data-calificacion="' . numberFormatPrecision($calificacion_final, 1, '.') . '"
                                            data-alumno="' . $detalle_calificacion->apellidop . " " . $detalle_calificacion->apellidom . " " . $detalle_calificacion->nombre . '"
                                           style = "color:blue;" title="Editar Calificación"></i> </a>';
                                                $tabla .= '  <a  href="javascript:void(0)"><i class="fa fa-trash delete_button"  data-toggle="modal" data-target="#myModalDelete"
                                            data-idcalificacion="' . $detalle_calificacion->idcalificacion . '"
                                            data-alumno="' . $detalle_calificacion->apellidop . " " . $detalle_calificacion->apellidom . " " . $detalle_calificacion->nombre . '"
                                           style = "color:red;" title="Eliminar Calificación"></i> </a>';
                                            }
                                        }
                                    } else {
                                        $fecha_inicio = date('Y-m-d');
                                        $tabla .= '<label style="color:green;">' . eliminarDecimalCero(numberFormatPrecision($calificacion_final, 1, '.')) . '</label>';
                                        $fecha_fin = date('Y-m-d', strtotime($detalle_calificacion->fecharegistro));
                                        $total_dias = dias_pasados($fecha_inicio, $fecha_fin);
                                        if ($total_dias <= $this->dias) {
                                            $tabla .= '  <a  href="javascript:void(0)"><i class="fa fa-pencil edit_button"  data-toggle="modal" data-target="#myModal"
                                            data-idcalificacion="' . $detalle_calificacion->idcalificacion . '"
                                            data-calificacion="' . numberFormatPrecision($calificacion_final, 1, '.') . '"
                                            data-alumno="' . $detalle_calificacion->apellidop . " " . $detalle_calificacion->apellidom . " " . $detalle_calificacion->nombre . '"
                                           style = "color:blue;" title="Editar Calificación"></i> </a>';
                                            $tabla .= '  <a  href="javascript:void(0)"><i class="fa fa-trash delete_button"  data-toggle="modal" data-target="#myModalDelete"
                                            data-idcalificacion="' . $detalle_calificacion->idcalificacion . '"
                                            data-alumno="' . $detalle_calificacion->apellidop . " " . $detalle_calificacion->apellidom . " " . $detalle_calificacion->nombre . '"
                                           style = "color:red;" title="Eliminar Calificación"></i> </a>';
                                        }
                                    }
                                } else {
                                    $tabla .= '<td>No registrado</td>';
                                }
                            }
                        }
                    } else {
                        $tabla .= '<tr>';
                        $tabla .= '<td>' . $c++ . '</td>';
                        $tabla .= '<td>' . $row->apellidop . " " . $row->apellidom . " " . $row->nombre . '</td>';
                        $detalle_calificacion = $this->grupo->obtenerCalificacionRecuperadoXMateria($row->idalumno, $idopotunidad, $idhorario, $idprofesormateria);
                        if ($detalle_calificacion) {

                            $tabla .= '<td>';
                            $calificacion_final = numberFormatPrecision($detalle_calificacion->calificacion, 1, '.');
                            if (validar_calificacion($calificacion_final, $detalle_configuracion[0]->calificacion_minima)) {
                                if ($calificacion_final > 0.0) {
                                    $tabla .= '<label style="color:red;">' . eliminarDecimalCero(numberFormatPrecision($calificacion_final, 1, '.')) . '</label>';
                                    $fecha_inicio = date('Y-m-d');
                                    $fecha_fin = date('Y-m-d', strtotime($detalle_calificacion->fecharegistro));
                                    $total_dias = dias_pasados($fecha_inicio, $fecha_fin);
                                    if ($total_dias <= $this->dias) {
                                        $tabla .= '  <a  href="javascript:void(0)"><i class="fa fa-pencil edit_button"  data-toggle="modal" data-target="#myModal"
                                    data-idcalificacion="' . $detalle_calificacion->idcalificacion . '"
                                    data-calificacion="' . numberFormatPrecision($calificacion_final, 1, '.') . '"
                                    data-alumno="' . $detalle_calificacion->apellidop . " " . $detalle_calificacion->apellidom . " " . $detalle_calificacion->nombre . '"
                                   style = "color:blue;" title="Editar Calificación"></i> </a>';
                                        $tabla .= '  <a  href="javascript:void(0)"><i class="fa fa-trash delete_button"  data-toggle="modal" data-target="#myModalDelete"
                                    data-idcalificacion="' . $detalle_calificacion->idcalificacion . '"
                                    data-alumno="' . $detalle_calificacion->apellidop . " " . $detalle_calificacion->apellidom . " " . $detalle_calificacion->nombre . '"
                                   style = "color:red;" title="Eliminar Calificación"></i> </a>';
                                    }
                                }
                            } else {
                                $fecha_inicio = date('Y-m-d');
                                $tabla .= '<label style="color:green;">' . eliminarDecimalCero(numberFormatPrecision($calificacion_final, 1, '.')) . '</label>';
                                $fecha_fin = date('Y-m-d', strtotime($detalle_calificacion->fecharegistro));
                                $total_dias = dias_pasados($fecha_inicio, $fecha_fin);
                                if ($total_dias <= $this->dias) {
                                    $tabla .= '  <a  href="javascript:void(0)"><i class="fa fa-pencil edit_button"  data-toggle="modal" data-target="#myModal"
                                    data-idcalificacion="' . $detalle_calificacion->idcalificacion . '"
                                    data-calificacion="' . numberFormatPrecision($calificacion_final, 1, '.') . '"
                                    data-alumno="' . $detalle_calificacion->apellidop . " " . $detalle_calificacion->apellidom . " " . $detalle_calificacion->nombre . '"
                                   style = "color:blue;" title="Editar Calificación"></i> </a>';
                                    $tabla .= '  <a  href="javascript:void(0)"><i class="fa fa-trash delete_button"  data-toggle="modal" data-target="#myModalDelete"
                                    data-idcalificacion="' . $detalle_calificacion->idcalificacion . '"
                                    data-alumno="' . $detalle_calificacion->apellidop . " " . $detalle_calificacion->apellidom . " " . $detalle_calificacion->nombre . '"
                                   style = "color:red;" title="Eliminar Calificación"></i> </a>';
                                }
                            }
                        } else {
                            $tabla .= '<td>No registrado</td>';
                        }
                    }
                }
                /*if (validar_calificacion($row->calificacion, $detalle_configuracion[0]->calificacion_minima)) {
                        $detalle_calificacion = $this->grupo->obtenerCalificacionRecuperadoXMateria($row->idalumno, $idopotunidad, $idhorario, $idprofesormateria);
                        if ($detalle_calificacion) {
                            $suma_calificacion = 0;
                            $suma_calificacion = $detalle_calificacion->calificacion;
                            $total_unidades = 1;

                            $tabla .= '<tr>';
                            $tabla .= '<td>' . $c++ . '</td>';
                            $tabla .= '<td>' . $row->apellidop . " " . $row->apellidom . " " . $row->nombre . '</td>';

                            $tabla .= '<td>'; 
                                $calificacion_final = numberFormatPrecision($suma_calificacion / $total_unidades, 1, '.');
                                if (validar_calificacion($calificacion_final, $detalle_configuracion[0]->calificacion_minima)) {
                                    if ($suma_calificacion > 0.0) {
                                        $tabla .= '<label style="color:red;">' . numberFormatPrecision($suma_calificacion / $total_unidades, 1, '.') . '</label>';
                                        $fecha_inicio = date('Y-m-d');
                                        $fecha_fin = date('Y-m-d', strtotime($detalle_calificacion->fecharegistro));
                                        $total_dias = dias_pasados($fecha_inicio, $fecha_fin);
                                        if ($total_dias <= $this->dias) {
                                            $tabla .= '  <a  href="javascript:void(0)"><i class="fa fa-pencil edit_button"  data-toggle="modal" data-target="#myModal"
		                                data-idcalificacion="' . $detalle_calificacion->idcalificacion . '"
		                                data-calificacion="' . numberFormatPrecision($suma_calificacion / $total_unidades, 1, '.') . '"
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
                                    $fecha_inicio = date('Y-m-d');
                                    $tabla .= '<label style="color:green;">' . numberFormatPrecision($suma_calificacion / $total_unidades, 1, '.') . '</label>';
                                    $fecha_fin = date('Y-m-d', strtotime($detalle_calificacion->fecharegistro));
                                    $total_dias = dias_pasados($fecha_inicio, $fecha_fin);
                                    if ($total_dias <= $this->dias) {
                                        $tabla .= '  <a  href="javascript:void(0)"><i class="fa fa-pencil edit_button"  data-toggle="modal" data-target="#myModal"
		                                data-idcalificacion="' . $detalle_calificacion->idcalificacion . '"
		                                data-calificacion="' . numberFormatPrecision($suma_calificacion / $total_unidades, 1, '.') . '"
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
                    }*/
            }
        }

        $tabla .= '</table>';
        return $tabla;
    }

    public function obtenerCalificacionRecuparacionSecu($idhorario = '', $idhorariodetalle, $idoportunidad_anterior, $idopotunidad)
    {
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
        $tabla .= '<th>PROMEDIO</th>';
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
                        $calificacion_final = numberFormatPrecision($suma_calificacion / $total_unidades, 1, '.');
                        $idcalificacion = $detalle_calificacion->idcalificacion;
                        $row_calificacion = $this->grupo->detalleCalificacionSecundaria($idcalificacion);
                        if (validar_calificacion($calificacion_final, $detalle_configuracion[0]->calificacion_minima)) {
                            if ($suma_calificacion > 0.0) {
                                $tabla .= '<label style="color:red;">' . numberFormatPrecision($suma_calificacion / $total_unidades, 1, '.') . '</label>';
                                $fecha_inicio = date('Y-m-d');
                                $fecha_fin = date('Y-m-d', strtotime($detalle_calificacion->fecharegistro));
                                $total_dias = dias_pasados($fecha_inicio, $fecha_fin);

                                if ($total_dias <= $this->dias) {
                                    $tabla .= '  <a  href="javascript:void(0)"><i class="fa fa-trash delete_button"  data-toggle="modal" data-target="#myModalDelete"
		                                data-idcalificacion="' . $detalle_calificacion->idcalificacion . '"
                                                      data-iddetallecalificacion="' . $row_calificacion->iddetallecalificacion . '"
		                                data-alumno="' . $detalle_calificacion->apellidop . " " . $detalle_calificacion->apellidom . " " . $detalle_calificacion->nombre . '"
		                               style = "color:red;" title="Eliminar Calificación"></i> </a>';
                                }
                            } else {
                                $tabla .= '<label "> </label>';
                            }
                        } else {
                            $fecha_inicio = date('Y-m-d');
                            $tabla .= '<label style="color:green;">' . numberFormatPrecision($suma_calificacion / $total_unidades, 1, '.') . '</label>';
                            $fecha_fin = date('Y-m-d', strtotime($detalle_calificacion->fecharegistro));
                            $total_dias = dias_pasados($fecha_inicio, $fecha_fin);
                            if ($total_dias <= $this->dias) {


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

    public function recuperacion($idhorario = '', $idhorariodetalle = '', $idopotunidad = '', $numero = '')
    {
        $idhorario = $this->decode($idhorario);
        $idhorariodetalle = $this->decode($idhorariodetalle);
        $idopotunidad = $this->decode($idopotunidad);
        $numero = $this->decode($numero);
        $idplantel = $this->session->idplantel;
        if ((isset($idhorario) && !empty($idhorario)) && (isset($idhorariodetalle) && !empty($idhorariodetalle)) && (isset($idopotunidad) && !empty($idopotunidad)) && (isset($numero) && !empty($numero))) {

            $detalle_oportunidad_anteriot = $this->grupo->obtenerOportunidadAnterior($numero, $idplantel);
            $idoportunidad_anterior = $detalle_oportunidad_anteriot->idoportunidadexamen;
            $detalle_horario = $this->grupo->detalleClase($idhorariodetalle);
            $idprofesormateria = $detalle_horario[0]->idprofesormateria;
            $alumnos = $this->grupo->obtenerAlumnoRecuperar($idhorario, $idoportunidad_anterior, $idprofesormateria);
            $tabla = $this->obtenerCalificacionRecupaacion($idhorario, $idhorariodetalle, $idoportunidad_anterior, $idopotunidad);
            $detalle = $this->grupo->detalleClase($idhorariodetalle);
            $detalle_oportunidad = $this->grupo->detalleOportunidad($idopotunidad);
            $nombreclase = $detalle[0]->nombreclase;
            $nombre_oportunidad = $detalle_oportunidad->nombreoportunidad;
            $datoshorario = $this->horario->showNivelGrupo($idhorario);
            $idnivelestudio = $datoshorario->idnivelestudio;
            $unidades = $this->grupo->obtenerUnidadUno(1);
            $idunidad = $unidades->idunidad;
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
                'idoportunidad' => $idopotunidad
            );
            $this->load->view('docente/header');
            $this->load->view('docente/grupo/recuperacion/index', $data);
            $this->load->view('docente/footer');
        } else {
            $data = array(
                'heading' => 'Error',
                'message' => 'Error intente mas tarde.'
            );
            $this->load->view('docente/header');
            $this->load->view('docente/error/general', $data);
            $this->load->view('docente/footer');
        }
    }

    public function recuperacionSecu($idhorario = '', $idhorariodetalle = '', $idopotunidad = '', $numero = '')
    {
        $idhorario = $this->decode($idhorario);
        $idhorariodetalle = $this->decode($idhorariodetalle);
        $idopotunidad = $this->decode($idopotunidad);
        $numero = $this->decode($numero);
        $idplantel = $this->session->idplantel;
        if ((isset($idhorario) && !empty($idhorario)) && (isset($idhorariodetalle) && !empty($idhorariodetalle)) && (isset($idopotunidad) && !empty($idopotunidad)) && (isset($numero) && !empty($numero))) {
            $detalle_oportunidad_anteriot = $this->grupo->obtenerOportunidadAnterior($numero, $idplantel);
            $idoportunidad_anterior = $detalle_oportunidad_anteriot->idoportunidadexamen;
            $detalle_horario = $this->grupo->detalleClase($idhorariodetalle);
            $idprofesormateria = $detalle_horario[0]->idprofesormateria;
            $alumnos = $this->grupo->obtenerAlumnoRecuperar($idhorariodetalle, $idoportunidad_anterior, $idprofesormateria);
            $tabla = $this->obtenerCalificacionRecuparacionSecu($idhorario, $idhorariodetalle, $idoportunidad_anterior, $idopotunidad);
            $detalle = $this->grupo->detalleClase($idhorariodetalle);
            $detalle_oportunidad = $this->grupo->detalleOportunidad($idopotunidad);
            $nombreclase = $detalle[0]->nombreclase;
            $nombre_oportunidad = $detalle_oportunidad->nombreoportunidad;
            $datoshorario = $this->horario->showNivelGrupo($idhorario);
            $idnivelestudio = $datoshorario->idnivelestudio;
            $unidades = $this->grupo->obtenerUnidadUno(1);
            $idunidad = $unidades->idunidad;
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
                'idoportunidad' => $idopotunidad
            );
            $this->load->view('docente/header');
            $this->load->view('docente/grupo/recuperacion/secundaria', $data);
            $this->load->view('docente/footer');
        } else {
            $data = array(
                'heading' => 'Error',
                'message' => 'Error intente mas tarde.'
            );
            $this->load->view('docente/header');
            $this->load->view('docente/error/general', $data);
            $this->load->view('docente/footer');
        }
    }

    public function addCalificacionRecuperacion()
    {
        Permission::grant(uri_string());
        $config = array(
            array(
                'field' => 'calificacion[]',
                'label' => 'Calificacion',
                'rules' => 'trim|decimal|callback_maxNumberSecundaria',
                'errors' => array(
                    'decimal' => 'Debe de ser Números decimales.'
                )
            )
        );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == false) {
            $errors = validation_errors();
            echo json_encode([
                'error' => $errors
            ]);
        } else {
            $idhorario = $this->input->post('idhorario');
            $idhorariodetalle = $this->input->post('idhorariodetalle');
            $idalumno = $this->input->post('idalumno');
            $idunidad = $this->input->post('idunidad');
            $idoportunidad = $this->input->post('idoportunidad');
            $calificacion = $this->input->post('calificacion');
            $contador_no_insertado = 0;
            $contador_insertado = 0;
            $detalle_horario = $this->horario->detalleHorarioDetalle($idhorariodetalle);
            $idmateria = $detalle_horario[0]->idmateria;
            foreach ($idalumno as $key => $value) {
                $idalumno2 = $value;
                $calificacion_final = $calificacion[$key];
                $validar = $this->grupo->validarAgregarCalificacionXMateria($idunidad, $idhorario, $idmateria, $idoportunidad, $idalumno2);
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
                            'fecharegistro' => date('Y-m-d H:i:s')
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
                echo json_encode([
                    'success' => 'Ok',
                    'mensaje' => 'Algunas calificaciones no fueron registrados, porque ya estan registrada.'
                ]);
            } else {
                echo json_encode([
                    'success' => 'Ok',
                    'mensaje' => 'Fueron registrados las calificaciones.'
                ]);
            }
        }
    }

    public function addCalificacionRecuperacionSecu()
    {
        Permission::grant(uri_string());
        $config = array(
            array(
                'field' => 'calificacion[]',
                'label' => 'Calificacion',
                'rules' => 'required|trim|decimal|callback_maxNumberSecundaria',
                'errors' => array(
                    'decimal' => 'Debe de ser Números decimales.'
                )
            )
        );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == false) {
            $errors = validation_errors();
            echo json_encode([
                'error' => $errors
            ]);
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
                            'fecharegistro' => date('Y-m-d H:i:s')
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
                echo json_encode([
                    'success' => 'Ok',
                    'mensaje' => 'Algunas calificaciones no fueron registrados, porque ya estan registrada.'
                ]);
            } else {
                echo json_encode([
                    'success' => 'Ok',
                    'mensaje' => 'Fueron registrados las calificaciones.'
                ]);
            }
        }

        /* Permission::grant(uri_string());
        $config = array(
            array(
                'field' => 'proyecto[]',
                'label' => 'Calificacion',
                'rules' => 'trim|decimal|callback_maxNumberSecundaria',
                'errors' => array(
                    'decimal' => 'Debe de ser Números decimales.'
                )
            ),
            array(
                'field' => 'tarea[]',
                'label' => 'Calificacion',
                'rules' => 'trim|decimal|callback_maxNumberSecundaria',
                'errors' => array(
                    'decimal' => 'Debe de ser Números decimales.'
                )
            ),
            array(
                'field' => 'participacion[]',
                'label' => 'Calificacion',
                'rules' => 'trim|decimal|callback_maxNumberSecundaria',
                'errors' => array(
                    'decimal' => 'Debe de ser Números decimales.'
                )
            ),
            array(
                'field' => 'examen[]',
                'label' => 'Calificacion',
                'rules' => 'trim|decimal|callback_maxNumberSecundaria',
                'errors' => array(
                    'decimal' => 'Debe de ser Números decimales.'
                )
            )
        );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == false) {
            $errors = validation_errors();
            echo json_encode([
                'error' => $errors
            ]);
        } else {
            $idhorario = $this->input->post('idhorario');
            $idhorariodetalle = $this->input->post('idhorariodetalle');
            $idalumno = $this->input->post('idalumno');
            $idunidad = $this->input->post('idunidad');
            $proyecto = $this->input->post('proyecto');
            $tarea = $this->input->post('tarea');
            $participacion = $this->input->post('participacion');
            $idoportunidad = $this->input->post('idoportunidad');
            $examen = $this->input->post('examen');
            $datos = array(
                $idalumno,
                $proyecto,
                $tarea,
                $participacion,
                $examen
            );
            $numero_goblal = 0;
            $numero_alumno = 0;
            $numero_proyecto = 1;
            $numero_tarea = 2;
            $numero_participacion = 3;
            $numero_examen = 4;

            $contador_no_insertado = 0;
            $contador_insertado = 0;
            foreach ($idalumno as $value) {
                $var_idalumno = $datos[$numero_alumno][$numero_goblal];
                $proyecto_calificacion = $datos[$numero_proyecto][$numero_goblal];
                $tarea_calificacion = $datos[$numero_tarea][$numero_goblal];
                $participacion_calificacion = $datos[$numero_participacion][$numero_goblal];
                $examen_calificacion = $datos[$numero_examen][$numero_goblal];
                $numero_goblal ++;
                $validar = $this->grupo->validarAgregarCalificacion($idunidad, $idhorariodetalle, $idoportunidad, $var_idalumno);
                $calificacion_real_proyecto = ($proyecto_calificacion != "") ? $proyecto_calificacion : 0;
                $calificacion_real_tarea = ($tarea_calificacion != "") ? $tarea_calificacion : 0;
                $calificacion_real_participacion = ($participacion_calificacion != "") ? $participacion_calificacion : 0;
                $calificacion_real_examen = ($examen_calificacion != "") ? $examen_calificacion : 0;
                $calificacion_antes = $calificacion_real_proyecto + $calificacion_real_tarea + $calificacion_real_participacion + $calificacion_real_examen;
                $calificacion_final = ($calificacion_antes > 0) ? $calificacion_antes / 10 : 0;
                if ($validar == false) {
                    if ((isset($calificacion_final) && ! empty($calificacion_final)) && ($calificacion_final > 0)) {
                        $data = array(
                            'idunidad' => $idunidad,
                            'idoportunidadexamen' => $idoportunidad,
                            'idalumno' => $var_idalumno,
                            'idhorario' => $idhorario,
                            'idhorariodetalle' => $idhorariodetalle,
                            'calificacion' => $calificacion_final,
                            'idusuario' => $this->session->user_id,
                            'fecharegistro' => date('Y-m-d H:i:s')
                        );
                        $idcalificacion = $this->grupo->addCalificacion($data);
                        $data_detalle = array(
                            'idcalificacion' => $idcalificacion,
                            'proyecto' => $proyecto_calificacion,
                            'tarea' => $tarea_calificacion,
                            'participacion' => $participacion_calificacion,
                            'examen' => $examen_calificacion,
                            'idusuario' => $this->session->user_id,
                            'fecharegistro' => date('Y-m-d H:i:s')
                        );
                        $this->grupo->addDetalleCalificacion($data_detalle);
                        $contador_insertado ++;
                    } else {
                        $contador_no_insertado ++;
                    }
                } else {
                    $contador_no_insertado ++;
                }
            }
            if ($contador_no_insertado > 0) {
                echo json_encode([
                    'success' => 'Ok',
                    'mensaje' => 'Algunas calificaciones no fueron registrados, porque ya estan registrada.'
                ]);
            } else {
                echo json_encode([
                    'success' => 'Ok',
                    'mensaje' => 'Fueron registrados las calificaciones.'
                ]);
            }
        } */
    }

    public function reporte()
    {
        $result = $this->grupo->showAllGruposProfesor($this->session->idprofesor);
        $data = array(
            'grupos' => $result
        );
        $this->load->view('docente/header');
        $this->load->view('docente/grupo/reporte/index', $data);
        $this->load->view('docente/footer');
    }

    public function generarReporter()
    {
        $idhorariodetalle = $this->input->post('grupo');
        $detalle = $this->grupo->detalleHorarioDetalle($idhorariodetalle);

        $idperiodo = $detalle->idperiodo;
        $idgrupo = $detalle->idgrupo;
        $idmateria = $detalle->idmateria;
        $idhorario = $detalle->idhorario;
        $idprofesormateria = $detalle->idprofesormateria;
        $tiporeporte = $this->input->post('tiporeporte');
        $estatus_alumno = $detalle->activo;
        $pos_mes = strpos($tiporeporte, 'm');
        if ($pos_mes !== false) {
            $array = explode("m", $tiporeporte);
            $idmes = $array[1];
            $idhorariodetalle_encriptado = $this->encode($idhorariodetalle);
            $idmes_encriptado = $this->encode($idmes);
            redirect('Pgrupo/calificacionMes/' . $idhorariodetalle_encriptado . '/' . $idmes_encriptado);
        } else if ($tiporeporte == 28) {
            $alumnos = $this->grupo->alumnosGrupo($idhorario, $idprofesormateria, $idmateria, $estatus_alumno);

            $this->load->library('excel');
            $this->excel->setActiveSheetIndex(0);
            $this->excel->getActiveSheet()->setTitle('Listado de Alumnos');
            // Contador de filas
            $contador = 1;
            $contador_alumno = 0;
            // Le aplicamos ancho las columnas.
            $this->excel->getActiveSheet()
                ->getColumnDimension('A')
                ->setWidth(10);
            $this->excel->getActiveSheet()
                ->getColumnDimension('B')
                ->setWidth(20);
            $this->excel->getActiveSheet()
                ->getColumnDimension('C')
                ->setWidth(50);
            $this->excel->getActiveSheet()
                ->getColumnDimension('D')
                ->setWidth(20);
            // Le aplicamos negrita a los títulos de la cabecera.
            $this->excel->getActiveSheet()
                ->getStyle("A{$contador}")
                ->getFont()
                ->setBold(true);
            $this->excel->getActiveSheet()
                ->getStyle("B{$contador}")
                ->getFont()
                ->setBold(true);
            $this->excel->getActiveSheet()
                ->getStyle("C{$contador}")
                ->getFont()
                ->setBold(true);
            $this->excel->getActiveSheet()
                ->getStyle("D{$contador}")
                ->getFont()
                ->setBold(true);
            // Definimos los títulos de la cabecera.
            $this->excel->getActiveSheet()->setCellValue("A{$contador}", 'NO');
            $this->excel->getActiveSheet()->setCellValue("B{$contador}", 'OPCION');
            $this->excel->getActiveSheet()->setCellValue("C{$contador}", 'NOMBRE');
            $this->excel->getActiveSheet()->setCellValue("D{$contador}", '');
            // Definimos la data del cuerpo.
            if (isset($alumnos) && !empty($alumnos)) {
                foreach ($alumnos as $row) {
                    // Incrementamos una fila más, para ir a la siguiente.
                    $contador++;
                    $contador_alumno++;
                    // Informacion de las filas de la consulta.
                    $this->excel->getActiveSheet()->setCellValue("A{$contador}", $contador_alumno);
                    $this->excel->getActiveSheet()->setCellValue("B{$contador}", ($row->opcion == 1) ? "N" : "R");
                    $this->excel->getActiveSheet()->setCellValue("C{$contador}", $row->apellidop . " " . $row->apellidom . " " . $row->nombre);
                    $datalle_calificacion = $this->grupo->calificacionPorMateria($row->idalumno, $idprofesormateria, $idhorario);
                }
            }
            // Le ponemos un nombre al archivo que se va a generar.
            $archivo = "Lista de Alumnos {$idperiodo}.xls";
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . $archivo . '"');
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            // Hacemos una salida al navegador con el archivo Excel.
            $objWriter->save('php://output');
        } else if ((isset($this->session->idniveleducativo) && !empty($this->session->idniveleducativo)) && ($tiporeporte == 29 && $this->session->idniveleducativo == 3)) {
            $idhorariodetalle_enc  = $this->encode($idhorariodetalle);
            redirect('Calificacion/imprimirActaEvaluacion/' . $idhorariodetalle_enc);
            /* $this->load->library('tcpdf');
            $hora = date("h:i:s a");
            $fechaactual = date('d/m/Y');
            $idperiodo = $detalle->idperiodo;
            $detalle_periodo = $this->cicloescolar->detalleCicloEscolar($idperiodo);
            $detalle_logo = $this->alumno->logo($this->session->idplantel);

            $logo = base_url() . '/assets/images/escuelas/' . $detalle_logo[0]->logoplantel;
            $logo2 = base_url() . '/assets/images/escuelas/' . $detalle_logo[0]->logosegundo;


            $unidades = $this->calificacion->unidades($this->session->idplantel);
            $materias = $this->calificacion->materiasGrupo($idperiodo, $idgrupo);


            $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
            $pdf->SetTitle('Boleta de Calificaciones.');
            $pdf->SetHeaderMargin(30);
            $pdf->SetTopMargin(10);
            $pdf->setFooterMargin(20);
            $pdf->SetAutoPageBreak(true);
            $pdf->SetAuthor('Author');
            $pdf->SetDisplayMode('real', 'default');
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);

            $pdf->SetMargins(15, 15, 15);
            $pdf->SetHeaderMargin(15);
            $pdf->SetFooterMargin(15);

            $pdf->SetAutoPageBreak(TRUE, 15);
            $pdf->AddPage();
            $tabla = '
        <style type="text/css">
        .txtn {
          font-size: 7px;
          color: #365f91;
          font-family: sans-serif;
      }
                
      .clave {
          font-size: 7px;
          color: #365f91;
          font-family: sans-serif;
      }
                
      .slogan {
          font-size: 6px;
          font-family: sans-serif;
      }
                
      .nombreplantel {
          font-size: 9px;
          font-weight: bold;
          color: #1f497d;
          font-family: sans-serif;
      }
                
      .tipoplantel {
          font-size: 7px;
          padding: 0px;
          margin: 0px;
          color: #365f91;
          font-family: sans-serif;
      }
                
      .titulo {
          font-size: 9px;
          text-align: center;
          font-family: sans-serif;
      }
                
      .secondtxt {
          font-size: 5px;
          font-family: sans-serif;
          vertical-align:middle;
      }
      .thirdtxt {
          font-size: 7px;
          font-family: sans-serif;
      }
                
      .bg-prom {
          background-color: #ccc;
      }
      tblborder  {
          border-spacing:0.5rem;
      }
      tblborder {
        border-collapse:collapse;
      }
       .tblhorario tr td
       {
        border:0px solid black;
       }
        .tituloalumno{
         font-size: 7px;
          font-family: sans-serif;
                
    }
      </style>
                
      <body>
      <table width="500" border="0" cellpadding="3" class="tblborder" cellspacing="0">
      <tr>
      <td width="120" align="center">
      <img src="' . $logo2 . '" width="150" height="90" />
      </td>
      <td colspan="2" width="260" align="center">
      <label class="slogan">"' . str_replace("INSTITUTO MORELOS", "", $detalle_logo[0]->nombreplantel) . '"</label><br />
      <label class="nombreplantel">' . str_replace("VALOR Y CONFIANZA", "", $detalle_logo[0]->nombreplantel) . '</label><br />
      <label class="tipoplantel">' . $detalle_logo[0]->asociado . '</label><br />
      <label class="clave">CCT. ' . $detalle_logo[0]->clave . '</label><br />
      <label class="txtn">Incorporado a la Dirección General del Bachillerato - Modalidad Escolarizada</label
      ><br />
      <label class="txtn">RVOE: 85489 de fecha 29 julio 1985, otorgado por la Dirección General de Incorporación y Revalidación</label>
      </td>
      <td width="120" align="center">
      <img src="' . $logo . '" width="150" height="70" />
      </td>
      </tr>
      <tr>
      <td align="center" colspan="4"><strong>ACTA DE EVALUACIÓN</strong></td>
      </tr>
      <tr>
      <td  colspan="2" style="font-size:9px;"><strong>CICLO:</strong> ' . $detalle_periodo->yearinicio . '-' . $detalle_periodo->yearfin . ' / ' . $detalle_periodo->descripcion . '</td>
      <td  colspan="2" style="font-size:9px;" align="right"><strong>TIPO DE EVALUACIÓN:</strong> ORD</td>
      </tr>
      <tr>
      <td  colspan="2" style="font-size:9px;"><strong>GRADO: </strong></td>
      <td  colspan="2" style="font-size:9px;" align="left"><strong>DOCENTE:</strong> ' . $detalle->nombre . ' ' . $detalle->apellidop . ' ' . $detalle->apellidom . '</td>
      </tr>
      <tr>
      <td  colspan="2" style="font-size:9px;"><strong>GRUPO: </strong></td>
      <td  colspan="2" style="font-size:9px;" align="left"><strong>FIRMA:</strong></td>
      </tr>
      <tr>
      <td  colspan="2" style="font-size:9px;"></td>
      <td  colspan="2" style="border-bottom:solid black 2px;"></td>
      </tr>
      <tr>
      <td  colspan="4" style="font-size:9px;"><strong>ASIGNATURA: </strong>' . $detalle->nombreclase . '</td> 
      </tr>
      </table>';
            $pdf->writeHTML($tabla, true, false, false, false, '');

            ob_end_clean();

            $pdf->Output('Boleta de Calificaciones', 'I');*/
        } else if ((isset($this->session->idniveleducativo) && !empty($this->session->idniveleducativo)) && ($tiporeporte == 29 && $this->session->idniveleducativo == 5)) {
            $detalle_logo = $this->alumno->logo($this->session->idplantel);
            $detalle_horario_p = $this->horario->detalleHorario($idhorario);
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
            $pdf->SetAutoPageBreak(TRUE, 15);

            $pdf->AddPage('L');

            $detalle_horario = $this->grupo->detalleHorarioDetalle($idhorariodetalle);
            $idhorario = $detalle_horario->idhorario;
            $estatus_alumno = $detalle_horario->activo;
            $idprofesormateria = $detalle_horario->idprofesormateria;
            $idmateria = $detalle_horario->idmateria;
            $unidades_materia = $detalle_horario->unidades;
            $unidades = "";
            $idprimera_unidad = "";
            $idsegunda_unidad = "";
            $idtercera_unidad = "";
            $idcuarto_unidad = "";
            $idquinte_unidad = "";
            $idsexto_unidad = "";
            $total_colspan = 4;
            if (isset($unidades_materia) && !empty($unidades_materia)) {
                $this->session->idplantel;
                $unidades = $this->grupo->unidades($this->session->idplantel, $unidades_materia);
                foreach ($unidades as $value) {
                    $numero = $value->numero;
                    if ($numero <= $unidades_materia) {
                        if ($numero == 1) {
                            $idprimera_unidad = $value->idunidad;
                            $total_colspan = $total_colspan + 2;
                        }
                        if ($numero == 2) {
                            $idsegunda_unidad = $value->idunidad;
                            $total_colspan = $total_colspan + 2;
                        }
                        if ($numero == 3) {
                            $idtercera_unidad = $value->idunidad;
                            $total_colspan = $total_colspan + 2;
                        }
                        if ($numero == 4) {
                            $idcuarto_unidad = $value->idunidad;
                            $total_colspan = $total_colspan + 2;
                        }
                        if ($numero == 5) {
                            $idquinte_unidad = $value->idunidad;
                            $total_colspan = $total_colspan + 2;
                        }
                        if ($numero == 6) {
                            $idsexto_unidad = $value->idunidad;
                            $total_colspan = $total_colspan + 2;
                        }
                    }
                }
            }
            $alumnos = $this->grupo->alumnosGrupo($idhorario, $idprofesormateria, $idmateria, $estatus_alumno);
            $datoshorario = $this->horario->showNivelGrupo($idhorario);

            $idnivelestudio = $datoshorario->idnivelestudio;
            $detalle_configuracion = $this->configuracion->showAllConfiguracion($this->session->idplantel, $idnivelestudio);
            $tabla = "";
            $tabla = '<style type="text/css">
                    .txttitulo{
                       font-size:10px;
                       font-weight:bold;
                       text:center;
                   } 
                    .tblborder td
                    {
                        border:0px solid black;
                    }
                    .promediosemestral{
                      font-size:9px;
                    }
                    .sinborde{
                    border-right:solid 5px red;
                    }
               </style>';
            $tabla .= '<table  border="0" >';
            if ((isset($this->session->idniveleducativo) && !empty($this->session->idniveleducativo)) && ($this->session->idniveleducativo == 5)) {
                $tabla .= '<tr>
             <td width="150" align="center" valing="top"><img  src="' . $logo2 . '" /></td>
             <td colspan="2" width="450" align="center">
                     <label class="nombreplantel">' . $detalle_logo[0]->nombreplantel . '</label><br>
                     <label class="txtn">' . $detalle_logo[0]->asociado . '</label><br>
                     <label class="direccion">C.C.T.' . $detalle_logo[0]->clave . '</label><br>';
                $tabla .= ' <label class="telefono">TURNO ' . $detalle_horario->nombreturno . '</label><br/>';

                $tabla .= '<label class="telefono">136 años educando a la niñez y juventud</label>
             </td>
             
             <td width="150" align="center"  ><br/><br/><img   src="' . $logo . '" /></td>';
                $tabla .= '</tr>';
                $tabla .= ' <tr><td colspan="4" align="center" ><strong>CONCENTRADO DE CALIFICACIONES</strong></td></tr>';
                $tabla .= ' <tr><td colspan="4" align="center" ><strong>CICLO ESCOLAR ' . $detalle_horario_p->yearinicio . '-' . $detalle_horario_p->yearfin . '</strong></td></tr>';
                $tabla .= ' <tr><td colspan="4" align="left" ><strong>CURSO: ' . $detalle_horario->nombreclase . '</strong></td></tr>';
                $tabla .= ' <tr><td colspan="2" align="left" ><strong>DOCENTE: ' . $detalle_horario->nombre . ' ' . $detalle_horario->apellidop . ' ' . $detalle_horario->apellidom . '</strong></td>' . '<td colspan="2" align="right" ><strong>SEMESTRE: ' . $detalle_horario->numeroordinaria . '</strong></td></tr>';
            }
            $tabla .= '</table><br><br>';

            $tabla .= ' <table class="tblcalificacion" border="0" cellpadding="3" >
                <tr class="tblborder">
                <td class="txttitulo" align="center" width="32">N Prog.</td>
                <td class="txttitulo" align="center" width="140">NOMBRE</td>';
            if (isset($idprimera_unidad) && !empty($idprimera_unidad)) {
                $row = $this->grupo->detalleUnidad($idprimera_unidad);
                $tabla .= '<td  align="center"    class="txttitulo">' . $row->nombreunidad . '</td>';
                $tabla .= '<td align="center"  class="txttitulo"   width="50">FALTAS</td>';
            }
            if (isset($idsegunda_unidad) && !empty($idsegunda_unidad)) {
                $row = $this->grupo->detalleUnidad($idsegunda_unidad);
                $tabla .= '<td  align="center" class="txttitulo">' . $row->nombreunidad . '</td>';
                $tabla .= '<td  align="center" class="txttitulo"  width="50">FALTAS</td>';
            }
            if (isset($idtercera_unidad) && !empty($idtercera_unidad)) {
                $row = $this->grupo->detalleUnidad($idtercera_unidad);
                $tabla .= '<td  align="center" class="txttitulo">' . $row->nombreunidad . '</td>';
                $tabla .= '<td  align="center" class="txttitulo"  width="50">FALTAS</td>';
            }
            if (isset($idcuarto_unidad) && !empty($idcuarto_unidad)) {
                $row = $this->grupo->detalleUnidad($idcuarto_unidad);
                $tabla .= '<td  align="center" class="txttitulo">' . $row->nombreunidad . '</td>';
                $tabla .= '<td  align="center" class="txttitulo"  width="50">FALTAS</td>';
            }
            if (isset($idquinte_unidad) && !empty($idquinte_unidad)) {
                $row = $this->grupo->detalleUnidad($idquinte_unidad);
                $tabla .= '<td  align="center" class="txttitulo">' . $row->nombreunidad . '</td>';
                $tabla .= '<td  align="center" class="txttitulo"  width="50">FALTAS</td>';
            }
            if (isset($idsexto_unidad) && !empty($idsexto_unidad)) {
                $row = $this->grupo->detalleUnidad($idsexto_unidad);
                $tabla .= '<td  align="center" class="txttitulo">' . $row->nombreunidad . '</td>';
                $tabla .= '<td  align="center" class="txttitulo"  width="50">FALTAS</td>';
            }
            $tabla .= '<td  align="center" class="txttitulo">EVALUACIÓN FINAL</td>';
            $tabla .= '<td  align="center" class="txttitulo">% ASISTENCIAS</td>';
            $tabla .= '</tr>';
            $c = 1;

            if (isset($alumnos) && !empty($alumnos)) {
                $suma_calificacion = 0;
                $total_asistencia = 0;
                $total_faltas = 0;
                foreach ($alumnos as $row) {
                    $suma_calificacion = 0;
                    $total_asistencia = 0;
                    $total_faltas = 0;
                    $tabla .= '<tr  class="tblborder">';
                    $tabla .= '  <td  align="center">' . $c++ . '</td>';
                    if ($row->opcion == 0) {
                        $tabla .= '<td  align="left"><label style="color:red;">R:</label> ' . $row->apellidop . " " . $row->apellidom . " " . $row->nombre . '</td>';
                    } else {
                        $tabla .= '<td  align="left">' . $row->apellidop . " " . $row->apellidom . " " . $row->nombre . '</td>';
                    }
                    if (isset($idprimera_unidad) && !empty($idprimera_unidad)) {
                        $row1 = $this->grupo->detalleUnidad($idprimera_unidad);
                        $val = $this->grupo->obtenerCalificacionValidandoMateria($row->idalumno, $row1->idunidad, $idhorario, $idmateria);
                        $row_asistencia = $this->grupo->totalAsistencias($idprimera_unidad, $idhorariodetalle, $row->idalumno);
                        $tabla .= '<td  align="center">';
                        if ($val != false) {
                            $suma_calificacion = $suma_calificacion + $val->calificacion;
                            $tabla .= '<label>' . numberFormatPrecision($val->calificacion, 1, '.') . '  </label>';
                        } else {
                            $tabla .= '<label>No registrado</label>';
                        }
                        $tabla .= '</td>';
                        if ($row_asistencia) {
                            $total_asistencia = $total_asistencia + $row_asistencia[0]->totalregistrado;
                            $total_faltas = $total_faltas + $row_asistencia[0]->totalfalta;
                            $tabla .= '<td  align="center">' . $row_asistencia[0]->totalfalta . '</td>';
                        } else {
                            $tabla .= '<td  align="center">0</td>';
                        }
                    }
                    if (isset($idsegunda_unidad) && !empty($idsegunda_unidad)) {
                        $row2 = $this->grupo->detalleUnidad($idsegunda_unidad);
                        $val = $this->grupo->obtenerCalificacionValidandoMateria($row->idalumno, $row2->idunidad, $idhorario, $idmateria);
                        $row_asistencia = $this->grupo->totalAsistencias($idsegunda_unidad, $idhorariodetalle, $row->idalumno);
                        $tabla .= '<td  align="center">';
                        if ($val != false) {
                            $suma_calificacion = $suma_calificacion + $val->calificacion;
                            $tabla .= '<label>' . numberFormatPrecision($val->calificacion, 1, '.') . '  </label>';
                        } else {
                            $tabla .= '<label>No registrado</label>';
                        }
                        $tabla .= '</td>';
                        if ($row_asistencia) {
                            $total_asistencia = $total_asistencia + $row_asistencia[0]->totalregistrado;
                            $total_faltas = $total_faltas + $row_asistencia[0]->totalfalta;
                            $tabla .= '<td  align="center">' . $row_asistencia[0]->totalfalta . '</td>';
                        } else {
                            $tabla .= '<td  align="center">0</td>';
                        }
                    }
                    if (isset($idtercera_unidad) && !empty($idtercera_unidad)) {
                        $row3 = $this->grupo->detalleUnidad($idtercera_unidad);
                        $val = $this->grupo->obtenerCalificacionValidandoMateria($row->idalumno, $row3->idunidad, $idhorario, $idmateria);
                        $row_asistencia = $this->grupo->totalAsistencias($idtercera_unidad, $idhorariodetalle, $row->idalumno);
                        $tabla .= '<td  align="center">';
                        if ($val != false) {
                            $suma_calificacion = $suma_calificacion + $val->calificacion;
                            $tabla .= '<label>' . numberFormatPrecision($val->calificacion, 1, '.') . '  </label>';
                        } else {
                            $tabla .= '<label>No registrado</label>';
                        }
                        $tabla .= '</td>';
                        if ($row_asistencia) {
                            $total_asistencia = $total_asistencia + $row_asistencia[0]->totalregistrado;
                            $total_faltas = $total_faltas + $row_asistencia[0]->totalfalta;
                            $tabla .= '<td  align="center">' . $row_asistencia[0]->totalfalta . '</td>';
                        } else {
                            $tabla .= '<td  align="center">0</td>';
                        }
                    }
                    if (isset($idcuarto_unidad) && !empty($idcuarto_unidad)) {
                        $row4 = $this->grupo->detalleUnidad($idcuarto_unidad);
                        $val = $this->grupo->obtenerCalificacionValidandoMateria($row->idalumno, $row4->idunidad, $idhorario, $idmateria);
                        $row_asistencia = $this->grupo->totalAsistencias($idcuarto_unidad, $idhorariodetalle, $row->idalumno);
                        $tabla .= '<td  align="center">';
                        if ($val != false) {
                            $suma_calificacion = $suma_calificacion + $val->calificacion;
                            $tabla .= '<label>' . $val->calificacion . '  </label>';
                        } else {
                            $tabla .= '<label>No registrado</label>';
                        }
                        $tabla .= '</td>';
                        if ($row_asistencia) {
                            $total_asistencia = $total_asistencia + $row_asistencia[0]->totalregistrado;
                            $total_faltas = $total_faltas + $row_asistencia[0]->totalfalta;
                            $tabla .= '<td  align="center">' . $row_asistencia[0]->totalfalta . '</td>';
                        } else {
                            $tabla .= '<td  align="center">0</td>';
                        }
                    }
                    if (isset($idquinte_unidad) && !empty($idquinte_unidad)) {
                        $row5 = $this->grupo->detalleUnidad($idquinte_unidad);
                        $val = $this->grupo->obtenerCalificacionValidandoMateria($row->idalumno, $row5->idunidad, $idhorario, $idmateria);
                        $row_asistencia = $this->grupo->totalAsistencias($idquinte_unidad, $idhorariodetalle, $row->idalumno);
                        $tabla .= '<td  align="center">';
                        if ($val != false) {
                            $suma_calificacion = $suma_calificacion + $val->calificacion;
                            $tabla .= '<label>' . numberFormatPrecision($val->calificacion, 1, '.') . '  </label>';
                        } else {
                            $tabla .= '<label>No registrado</label>';
                        }
                        $tabla .= '</td>';
                        if ($row_asistencia) {
                            $total_asistencia = $total_asistencia + $row_asistencia[0]->totalregistrado;
                            $total_faltas = $total_faltas + $row_asistencia[0]->totalfalta;
                            $tabla .= '<td  align="center">' . $row_asistencia[0]->totalfalta . '</td>';
                        } else {
                            $tabla .= '<td  align="center">0</td>';
                        }
                    }
                    if (isset($idsexto_unidad) && !empty($idsexto_unidad)) {
                        $row6 = $this->grupo->detalleUnidad($idsexto_unidad);
                        $val = $this->grupo->obtenerCalificacionValidandoMateria($row->idalumno, $row6->idunidad, $idhorario, $idmateria);
                        $row_asistencia = $this->grupo->totalAsistencias($idsexto_unidad, $idhorariodetalle, $row->idalumno);
                        $tabla .= '<td  align="center">';
                        if ($val != false) {
                            $suma_calificacion = $suma_calificacion + $val->calificacion;
                            $tabla .= '<label>' . numberFormatPrecision($val->calificacion, 1, '.') . '  </label>';
                        } else {
                            $tabla .= '<small>No registrado</small>';
                        }
                        $tabla .= '</td>';
                        if ($row_asistencia) {
                            $total_asistencia = $total_asistencia + $row_asistencia[0]->totalregistrado;
                            $total_faltas = $total_faltas + $row_asistencia[0]->totalfalta;
                            $tabla .= '<td  align="center">' . $row_asistencia[0]->totalfalta . '</td>';
                        } else {
                            $tabla .= '<td  align="center">0</td>';
                        }
                    }
                    $tabla .= '<td  align="center">';
                    if ($suma_calificacion > 0 && $unidades_materia > 0) {
                        $tabla .= '<label>' . numberFormatPrecision(($suma_calificacion / $unidades_materia), 1, '.') . '</label>';
                    } else {
                        $tabla .= '<small>SIN REGISTRAR</small>';
                    }
                    $tabla .= '</td>';
                    $tabla .= '<td  align="center">';
                    if ($total_faltas > 0 && $total_asistencia > 0) {
                        $tabla .= '<label>' . obtenerPorcentaje($total_faltas, $total_asistencia) . '%</label>';
                    } else {
                        $tabla .= '<label>100%</label>';
                    }
                    $tabla .= '</td>';
                    $tabla .= '</tr>';
                }
                $tabla .= '<tr>';
                $tabla .= '<td colspan="2"  align="center"></td>';
                if (isset($idprimera_unidad) && !empty($idprimera_unidad)) {
                    $tabla .= '<td></td>';
                    $tabla .= '<td></td>';
                }
                if (isset($idsegunda_unidad) && !empty($idsegunda_unidad)) {
                    $tabla .= '<td></td>';
                    $tabla .= '<td></td>';
                }
                if (isset($idtercera_unidad) && !empty($idtercera_unidad)) {
                    $tabla .= '<td></td>';
                    $tabla .= '<td></td>';
                }
                if (isset($idcuarto_unidad) && !empty($idcuarto_unidad)) {
                    $tabla .= '<td></td>';
                    $tabla .= '<td></td>';
                }
                if (isset($idquinte_unidad) && !empty($idquinte_unidad)) {
                    $tabla .= '<td></td>';
                    $tabla .= '<td></td>';
                }
                if (isset($idsexto_unidad) && !empty($idsexto_unidad)) {
                    $tabla .= '<td></td>';
                    $tabla .= '<td class="promediosemestral"></td>';
                }
                $tabla .= '<td></td>';
                $tabla .= '</tr>';

                $tabla .= '<tr  class="tblborder">';
                $tabla .= '<td colspan="2" align="center">Firma del Docente</td>';
                if (isset($idprimera_unidad) && !empty($idprimera_unidad)) {
                    $tabla .= '<td></td>';
                    if (isset($idsegunda_unidad) && empty($idsegunda_unidad)) {
                        $tabla .= '<td class="promediosemestral">Promedio semestral</td>';
                    } else {
                        $tabla .= '<td></td>';
                    }
                }
                if (isset($idsegunda_unidad) && !empty($idsegunda_unidad)) {
                    $tabla .= '<td></td>';
                    if (isset($idtercera_unidad) && empty($idtercera_unidad)) {
                        $tabla .= '<td class="promediosemestral">Promedio semestral</td>';
                    } else {
                        $tabla .= '<td></td>';
                    }
                }
                if (isset($idtercera_unidad) && !empty($idtercera_unidad)) {
                    $tabla .= '<td></td>';
                    if (isset($idcuarto_unidad) && empty($idcuarto_unidad)) {
                        $tabla .= '<td class="promediosemestral">Promedio semestral</td>';
                    } else {
                        $tabla .= '<td></td>';
                    }
                }
                if (isset($idcuarto_unidad) && !empty($idcuarto_unidad)) {
                    $tabla .= '<td></td>';
                    if (isset($idquinte_unidad) && empty($idquinte_unidad)) {
                        $tabla .= '<td class="promediosemestral">Promedio semestral</td>';
                    } else {
                        $tabla .= '<td></td>';
                    }
                }
                if (isset($idquinte_unidad) && !empty($idquinte_unidad)) {
                    $tabla .= '<td></td>';
                    if (isset($idsexto_unidad) && empty($idsexto_unidad)) {
                        $tabla .= '<td class="promediosemestral">Promedio semestral</td>';
                    } else {
                        $tabla .= '<td></td>';
                    }
                }
                if (isset($idsexto_unidad) && !empty($idsexto_unidad)) {
                    $tabla .= '<td></td>';
                    $tabla .= '<td class="promediosemestral">Promedio semestral</td>';
                }
                $tabla .= '<td></td>';
                $tabla .= '</tr>';
                $tabla .= '<tr><td colspan="' . $total_colspan . '">Obervaciones</td></tr>';
                $tabla .= '<tr><td colspan="' . $total_colspan . '" style="border-bottom:solid 1px black;"></td></tr>';
                $tabla .= '<tr><td colspan="' . $total_colspan . '" style="border-bottom:solid 1px black;"></td></tr>';
                $tabla .= '<tr><td colspan="' . $total_colspan . '" style="border-bottom:solid 1px black;"></td></tr>';
            }
            $tabla .= '</table>';
            $pdf->writeHTML($tabla, true, false, false, false, '');

            ob_end_clean();

            $pdf->Output('Calificaciones.pdf', 'D');
        } else if ((isset($this->session->idniveleducativo) && !empty($this->session->idniveleducativo)) && ($tiporeporte == 29 && $this->session->idniveleducativo == 3)) {
            $detalle_logo = $this->alumno->logo($this->session->idplantel);
            $detalle_horario_p = $this->horario->detalleHorario($idhorario);
            $logo = base_url() . '/assets/images/escuelas/' . $detalle_logo[0]->logoplantel;
            $logo2 = base_url() . '/assets/images/escuelas/' . $detalle_logo[0]->logosegundo;
            $this->load->library('tcpdf');

            $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
            $pdf->SetTitle('Horario de clases.');
            $pdf->SetTopMargin(10);
            $pdf->SetAuthor('Author');
            $pdf->SetDisplayMode('real', 'default');
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);

            $pdf->SetMargins(15, 15, 15);
            $pdf->SetHeaderMargin(15);
            $pdf->SetFooterMargin(15);
            $pdf->SetAutoPageBreak(TRUE, 20);

            $pdf->AddPage('L');

            $detalle_horario = $this->grupo->detalleHorarioDetalle($idhorariodetalle);
            $idprofesormateria = $detalle_horario->idprofesormateria;
            $idmateria = $detalle_horario->idmateria;
            $estatus_alumno = $detalle_horario->activo;
            $idprimera_unidad = "";
            $idsegunda_unidad = "";
            $idtercera_unidad = "";
            $idcuarto_unidad = "";
            $idquinte_unidad = "";
            $idsexto_unidad = "";
            $total_colspan = 4;

            $unidades = $this->grupo->unidades($this->session->idplantel, '');
            $unidades_materia = count($unidades);
            foreach ($unidades as $value) {
                $numero = $value->numero;
                if ($numero == 1) {
                    $idprimera_unidad = $value->idunidad;
                    $total_colspan = $total_colspan + 2;
                }
                if ($numero == 2) {
                    $idsegunda_unidad = $value->idunidad;
                    $total_colspan = $total_colspan + 2;
                }
                if ($numero == 3) {
                    $idtercera_unidad = $value->idunidad;
                    $total_colspan = $total_colspan + 2;
                }
                if ($numero == 4) {
                    $idcuarto_unidad = $value->idunidad;
                    $total_colspan = $total_colspan + 2;
                }
                if ($numero == 5) {
                    $idquinte_unidad = $value->idunidad;
                    $total_colspan = $total_colspan + 2;
                }
                if ($numero == 6) {
                    $idsexto_unidad = $value->idunidad;
                    $total_colspan = $total_colspan + 2;
                }
            }

            $alumnos = $this->grupo->alumnosGrupo($idhorario, $idprofesormateria, $idmateria, $estatus_alumno);
            $datoshorario = $this->horario->showNivelGrupo($idhorario);

            $idnivelestudio = $datoshorario->idnivelestudio;
            $detalle_configuracion = $this->configuracion->showAllConfiguracion($this->session->idplantel, $idnivelestudio);
            $tabla = "";
            $tabla = '<style type="text/css">
                    .txttitulo{
                       font-size:10px;
                       font-weight:bold;
                       text:center;
                   } 
                    .tblborder td
                    {
                        border:0px solid black;
                    }
                    .promediosemestral{
                      font-size:9px;
                    }
                    .sinborde{
                    border-right:solid 5px red;
                    }
               </style>';
            $tabla .= '<table  border="0" >';
            if ((isset($this->session->idniveleducativo) && !empty($this->session->idniveleducativo)) && ($this->session->idniveleducativo == 3)) {
                $tabla .= '<tr>
             <td width="150" align="center" valing="top"><img  src="' . $logo2 . '" /></td>
             <td colspan="2" width="450" align="center">
                     <label class="nombreplantel">' . $detalle_logo[0]->nombreplantel . '</label><br>
                     <label class="txtn">' . $detalle_logo[0]->asociado . '</label><br>
                     <label class="direccion">C.C.T.' . $detalle_logo[0]->clave . '</label><br>';

                $tabla .= '<label class="telefono">Incorporado a la Dirección General del Bachillerato - Modalidad Escolarizada
RVOE: 85489 de fecha 29 julio 1985, otorgado por la Dirección General de Incorporación y Revalidación
</label>
             </td>
             
             <td width="150" align="center"  ><br/><br/><img   src="' . $logo . '" /></td>';
                $tabla .= '</tr>';
                $tabla .= ' <tr><td colspan="4" align="center" ><strong>CONCENTRADO DE CALIFICACIONES</strong></td></tr>';
                $tabla .= ' <tr><td colspan="4" align="center" ><strong>CICLO ESCOLAR ' . $detalle_horario_p->yearinicio . '-' . $detalle_horario_p->yearfin . '</strong></td></tr>';
                $tabla .= ' <tr><td colspan="4" align="left" ><strong>ASIGNATURA: ' . $detalle_horario->nombreclase . '</strong></td></tr>';
                $tabla .= ' <tr><td colspan="2" align="left" ><strong>DOCENTE: ' . $detalle_horario->nombre . ' ' . $detalle_horario->apellidop . ' ' . $detalle_horario->apellidom . '</strong></td>' . '<td colspan="2" align="right" ><strong>SEMESTRE: ' . $detalle_horario->numeroordinaria . '</strong></td></tr>';
            }
            $tabla .= '</table><br><br>';

            $tabla .= ' <table class="tblcalificacion" border="0" cellpadding="3" >
                <tr class="tblborder">
                <td class="txttitulo" align="center" width="32">N Prog.</td>
                <td class="txttitulo" align="center" width="140">NOMBRE</td>';
            if (isset($idprimera_unidad) && !empty($idprimera_unidad)) {
                $row = $this->grupo->detalleUnidad($idprimera_unidad);
                $tabla .= '<td  align="center"    class="txttitulo">' . $row->nombreunidad . '</td>';
                $tabla .= '<td align="center"  class="txttitulo"   width="50">FALTAS</td>';
            }
            if (isset($idsegunda_unidad) && !empty($idsegunda_unidad)) {
                $row = $this->grupo->detalleUnidad($idsegunda_unidad);
                $tabla .= '<td  align="center" class="txttitulo">' . $row->nombreunidad . '</td>';
                $tabla .= '<td  align="center" class="txttitulo"  width="50">FALTAS</td>';
            }
            if (isset($idtercera_unidad) && !empty($idtercera_unidad)) {
                $row = $this->grupo->detalleUnidad($idtercera_unidad);
                $tabla .= '<td  align="center" class="txttitulo">' . $row->nombreunidad . '</td>';
                $tabla .= '<td  align="center" class="txttitulo"  width="50">FALTAS</td>';
            }
            if (isset($idcuarto_unidad) && !empty($idcuarto_unidad)) {
                $row = $this->grupo->detalleUnidad($idcuarto_unidad);
                $tabla .= '<td  align="center" class="txttitulo">' . $row->nombreunidad . '</td>';
                $tabla .= '<td  align="center" class="txttitulo"  width="50">FALTAS</td>';
            }
            if (isset($idquinte_unidad) && !empty($idquinte_unidad)) {
                $row = $this->grupo->detalleUnidad($idquinte_unidad);
                $tabla .= '<td  align="center" class="txttitulo">' . $row->nombreunidad . '</td>';
                $tabla .= '<td  align="center" class="txttitulo"  width="50">FALTAS</td>';
            }
            if (isset($idsexto_unidad) && !empty($idsexto_unidad)) {
                $row = $this->grupo->detalleUnidad($idsexto_unidad);
                $tabla .= '<td  align="center" class="txttitulo">' . $row->nombreunidad . '</td>';
                $tabla .= '<td  align="center" class="txttitulo"  width="50">FALTAS</td>';
            }
            $tabla .= '<td  align="center" class="txttitulo">EVALUACIÓN FINAL</td>';
            $tabla .= '<td  align="center" class="txttitulo">% ASISTENCIAS</td>';
            $tabla .= '</tr>';
            $c = 1;

            if (isset($alumnos) && !empty($alumnos)) {
                $suma_calificacion = 0;
                $total_asistencia = 0;
                $total_faltas = 0;
                foreach ($alumnos as $row) {
                    $suma_calificacion = 0;
                    $total_asistencia = 0;
                    $total_faltas = 0;
                    $tabla .= '<tr  class="tblborder">';
                    $tabla .= '  <td  align="center">' . $c++ . '</td>';
                    if ($row->opcion == 0) {
                        $tabla .= '<td  align="left"><label style="color:red;">R:</label> ' . $row->apellidop . " " . $row->apellidom . " " . $row->nombre . '</td>';
                    } else {
                        $tabla .= '<td  align="left">' . $row->apellidop . " " . $row->apellidom . " " . $row->nombre . '</td>';
                    }
                    if (isset($idprimera_unidad) && !empty($idprimera_unidad)) {
                        $row1 = $this->grupo->detalleUnidad($idprimera_unidad);
                        $val = $this->grupo->obtenerCalificacionValidandoMateria($row->idalumno, $row1->idunidad, $idhorario, $idmateria);
                        $row_asistencia = $this->grupo->totalAsistencias($idprimera_unidad, $idhorariodetalle, $row->idalumno);
                        $tabla .= '<td  align="center">';
                        if ($val != false) {
                            $suma_calificacion = $suma_calificacion + $val->calificacion;
                            $tabla .= '<label>' . numberFormatPrecision($val->calificacion, 1, '.') . '  </label>';
                        } else {
                            $tabla .= '<label>No registrado</label>';
                        }
                        $tabla .= '</td>';
                        if ($row_asistencia) {
                            $total_asistencia = $total_asistencia + $row_asistencia[0]->totalregistrado;
                            $total_faltas = $total_faltas + $row_asistencia[0]->totalfalta;
                            $tabla .= '<td  align="center">' . $row_asistencia[0]->totalfalta . '</td>';
                        } else {
                            $tabla .= '<td  align="center">0</td>';
                        }
                    }
                    if (isset($idsegunda_unidad) && !empty($idsegunda_unidad)) {
                        $row2 = $this->grupo->detalleUnidad($idsegunda_unidad);
                        $val = $this->grupo->obtenerCalificacionValidandoMateria($row->idalumno, $row2->idunidad, $idhorario, $idmateria);
                        $row_asistencia = $this->grupo->totalAsistencias($idsegunda_unidad, $idhorariodetalle, $row->idalumno);
                        $tabla .= '<td  align="center">';
                        if ($val != false) {
                            $suma_calificacion = $suma_calificacion + $val->calificacion;
                            $tabla .= '<label>' . numberFormatPrecision($val->calificacion, 1, '.') . '  </label>';
                        } else {
                            $tabla .= '<label>No registrado</label>';
                        }
                        $tabla .= '</td>';
                        if ($row_asistencia) {
                            $total_asistencia = $total_asistencia + $row_asistencia[0]->totalregistrado;
                            $total_faltas = $total_faltas + $row_asistencia[0]->totalfalta;
                            $tabla .= '<td  align="center">' . $row_asistencia[0]->totalfalta . '</td>';
                        } else {
                            $tabla .= '<td  align="center">0</td>';
                        }
                    }
                    if (isset($idtercera_unidad) && !empty($idtercera_unidad)) {
                        $row3 = $this->grupo->detalleUnidad($idtercera_unidad);
                        $val = $this->grupo->obtenerCalificacionValidandoMateria($row->idalumno, $row3->idunidad, $idhorario, $idmateria);
                        $row_asistencia = $this->grupo->totalAsistencias($idtercera_unidad, $idhorariodetalle, $row->idalumno);
                        $tabla .= '<td  align="center">';
                        if ($val != false) {
                            $suma_calificacion = $suma_calificacion + $val->calificacion;
                            $tabla .= '<label>' . numberFormatPrecision($val->calificacion, 1, '.') . '  </label>';
                        } else {
                            $tabla .= '<label>No registrado</label>';
                        }
                        $tabla .= '</td>';
                        if ($row_asistencia) {
                            $total_asistencia = $total_asistencia + $row_asistencia[0]->totalregistrado;
                            $total_faltas = $total_faltas + $row_asistencia[0]->totalfalta;
                            $tabla .= '<td  align="center">' . $row_asistencia[0]->totalfalta . '</td>';
                        } else {
                            $tabla .= '<td  align="center">0</td>';
                        }
                    }
                    if (isset($idcuarto_unidad) && !empty($idcuarto_unidad)) {
                        $row4 = $this->grupo->detalleUnidad($idcuarto_unidad);
                        $val = $this->grupo->obtenerCalificacionValidandoMateria($row->idalumno, $row4->idunidad, $idhorario, $idmateria);
                        $row_asistencia = $this->grupo->totalAsistencias($idcuarto_unidad, $idhorariodetalle, $row->idalumno);
                        $tabla .= '<td  align="center">';
                        if ($val != false) {
                            $suma_calificacion = $suma_calificacion + $val->calificacion;
                            $tabla .= '<label>' . numberFormatPrecision($val->calificacion, 1, '.') . '  </label>';
                        } else {
                            $tabla .= '<label>No registrado</label>';
                        }
                        $tabla .= '</td>';
                        if ($row_asistencia) {
                            $total_asistencia = $total_asistencia + $row_asistencia[0]->totalregistrado;
                            $total_faltas = $total_faltas + $row_asistencia[0]->totalfalta;
                            $tabla .= '<td  align="center">' . $row_asistencia[0]->totalfalta . '</td>';
                        } else {
                            $tabla .= '<td  align="center">0</td>';
                        }
                    }
                    if (isset($idquinte_unidad) && !empty($idquinte_unidad)) {
                        $row5 = $this->grupo->detalleUnidad($idquinte_unidad);
                        $val = $this->grupo->oobtenerCalificacionValidandoMateria($row->idalumno, $row5->idunidad, $idhorario, $idmateria);
                        $row_asistencia = $this->grupo->totalAsistencias($idquinte_unidad, $idhorariodetalle, $row->idalumno);
                        $tabla .= '<td  align="center">';
                        if ($val != false) {
                            $suma_calificacion = $suma_calificacion + $val->calificacion;
                            $tabla .= '<label>' . numberFormatPrecision($val->calificacion, 1, '.') . '  </label>';
                        } else {
                            $tabla .= '<label>No registrado</label>';
                        }
                        $tabla .= '</td>';
                        if ($row_asistencia) {
                            $total_asistencia = $total_asistencia + $row_asistencia[0]->totalregistrado;
                            $total_faltas = $total_faltas + $row_asistencia[0]->totalfalta;
                            $tabla .= '<td  align="center">' . $row_asistencia[0]->totalfalta . '</td>';
                        } else {
                            $tabla .= '<td  align="center">0</td>';
                        }
                    }
                    if (isset($idsexto_unidad) && !empty($idsexto_unidad)) {
                        $row6 = $this->grupo->detalleUnidad($idsexto_unidad);
                        $val = $this->grupo->obtenerCalificacionValidandoMateria($row->idalumno, $row6->idunidad, $idhorario, $idmateria);
                        $row_asistencia = $this->grupo->totalAsistencias($idsexto_unidad, $idhorariodetalle, $row->idalumno);
                        $tabla .= '<td  align="center">';
                        if ($val != false) {
                            $suma_calificacion = $suma_calificacion + $val->calificacion;
                            $tabla .= '<label>' . numberFormatPrecision($val->calificacion, 1, '.') . '  </label>';
                        } else {
                            $tabla .= '<small>No registrado</small>';
                        }
                        $tabla .= '</td>';
                        if ($row_asistencia) {
                            $total_asistencia = $total_asistencia + $row_asistencia[0]->totalregistrado;
                            $total_faltas = $total_faltas + $row_asistencia[0]->totalfalta;
                            $tabla .= '<td  align="center">' . $row_asistencia[0]->totalfalta . '</td>';
                        } else {
                            $tabla .= '<td  align="center">0</td>';
                        }
                    }
                    $tabla .= '<td  align="center">';
                    if ($suma_calificacion > 0 && $unidades_materia > 0) {
                        $tabla .= '<label>' . numberFormatPrecision(($suma_calificacion / $unidades_materia), 1, '.') . '</label>';
                    } else {
                        $tabla .= '<small>SIN REGISTRAR</small>';
                    }
                    $tabla .= '</td>';
                    $tabla .= '<td  align="center">';
                    if ($total_faltas > 0 && $total_asistencia > 0) {
                        $tabla .= '<label>' . obtenerPorcentaje($total_faltas, $total_asistencia) . '%</label>';
                    } else {
                        $tabla .= '<label>100%</label>';
                    }
                    $tabla .= '</td>';
                    $tabla .= '</tr>';
                }
                $tabla .= '<tr>';
                $tabla .= '<td colspan="2"  align="center"></td>';
                if (isset($idprimera_unidad) && !empty($idprimera_unidad)) {
                    $tabla .= '<td></td>';
                    $tabla .= '<td></td>';
                }
                if (isset($idsegunda_unidad) && !empty($idsegunda_unidad)) {
                    $tabla .= '<td></td>';
                    $tabla .= '<td></td>';
                }
                if (isset($idtercera_unidad) && !empty($idtercera_unidad)) {
                    $tabla .= '<td></td>';
                    $tabla .= '<td></td>';
                }
                if (isset($idcuarto_unidad) && !empty($idcuarto_unidad)) {
                    $tabla .= '<td></td>';
                    $tabla .= '<td></td>';
                }
                if (isset($idquinte_unidad) && !empty($idquinte_unidad)) {
                    $tabla .= '<td></td>';
                    $tabla .= '<td></td>';
                }
                if (isset($idsexto_unidad) && !empty($idsexto_unidad)) {
                    $tabla .= '<td></td>';
                    $tabla .= '<td class="promediosemestral"></td>';
                }
                $tabla .= '<td></td>';
                $tabla .= '</tr>';

                $tabla .= '<tr  class="tblborder">';
                $tabla .= '<td colspan="2" align="center">Firma del Docente</td>';
                if (isset($idprimera_unidad) && !empty($idprimera_unidad)) {
                    $tabla .= '<td></td>';
                    if (isset($idsegunda_unidad) && empty($idsegunda_unidad)) {
                        $tabla .= '<td class="promediosemestral">Promedio semestral</td>';
                    } else {
                        $tabla .= '<td></td>';
                    }
                }
                if (isset($idsegunda_unidad) && !empty($idsegunda_unidad)) {
                    $tabla .= '<td></td>';
                    if (isset($idtercera_unidad) && empty($idtercera_unidad)) {
                        $tabla .= '<td class="promediosemestral">Promedio semestral</td>';
                    } else {
                        $tabla .= '<td></td>';
                    }
                }
                if (isset($idtercera_unidad) && !empty($idtercera_unidad)) {
                    $tabla .= '<td></td>';
                    if (isset($idcuarto_unidad) && empty($idcuarto_unidad)) {
                        $tabla .= '<td class="promediosemestral">Promedio semestral</td>';
                    } else {
                        $tabla .= '<td></td>';
                    }
                }
                if (isset($idcuarto_unidad) && !empty($idcuarto_unidad)) {
                    $tabla .= '<td></td>';
                    if (isset($idquinte_unidad) && empty($idquinte_unidad)) {
                        $tabla .= '<td class="promediosemestral">Promedio semestral</td>';
                    } else {
                        $tabla .= '<td></td>';
                    }
                }
                if (isset($idquinte_unidad) && !empty($idquinte_unidad)) {
                    $tabla .= '<td></td>';
                    if (isset($idsexto_unidad) && empty($idsexto_unidad)) {
                        $tabla .= '<td class="promediosemestral">Promedio semestral</td>';
                    } else {
                        $tabla .= '<td></td>';
                    }
                }
                if (isset($idsexto_unidad) && !empty($idsexto_unidad)) {
                    $tabla .= '<td></td>';
                    $tabla .= '<td class="promediosemestral">Promedio semestral</td>';
                }
                $tabla .= '<td></td>';
                $tabla .= '</tr>';
                $tabla .= '<tr><td colspan="' . $total_colspan . '">Obervaciones</td></tr>';
                $tabla .= '<tr><td colspan="' . $total_colspan . '" style="border-bottom:solid 1px black;"></td></tr>';
                $tabla .= '<tr><td colspan="' . $total_colspan . '" style="border-bottom:solid 1px black;"></td></tr>';
                $tabla .= '<tr><td colspan="' . $total_colspan . '" style="border-bottom:solid 1px black;"></td></tr>';
            }
            $tabla .= '</table>';
            // echo $tabla;
            $pdf->writeHTML($tabla, true, false, false, false, '');

            ob_end_clean();

            $pdf->Output('Calificaciones.pdf', 'D');
        } else if ((isset($this->session->idniveleducativo) && !empty($this->session->idniveleducativo)) && ($tiporeporte == 29 && ($this->session->idniveleducativo == 1 || $this->session->idniveleducativo == 2))) {
            $detalle_logo = $this->alumno->logo($this->session->idplantel);
            $detalle_horario_p = $this->horario->detalleHorario($idhorario);
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
            $pdf->SetAutoPageBreak(TRUE, 15);

            $pdf->AddPage('L');

            $detalle_horario = $this->grupo->detalleHorarioDetalle($idhorariodetalle);
            $idprofesormateria = $detalle_horario->idprofesormateria;
            $idmateria = $detalle_horario->idmateria;
            $estatus_alumno = $detalle_horario->activo;
            $idprimera_unidad = "";
            $idsegunda_unidad = "";
            $idtercera_unidad = "";
            $idcuarto_unidad = "";
            $idquinte_unidad = "";
            $idsexto_unidad = "";
            $total_colspan = 4;

            $unidades = $this->grupo->unidades($this->session->idplantel, '');
            $unidades_materia = count($unidades);
            foreach ($unidades as $value) {
                $numero = $value->numero;
                if ($numero == 1) {
                    $idprimera_unidad = $value->idunidad;
                    $total_colspan = $total_colspan + 2;
                }
                if ($numero == 2) {
                    $idsegunda_unidad = $value->idunidad;
                    $total_colspan = $total_colspan + 2;
                }
                if ($numero == 3) {
                    $idtercera_unidad = $value->idunidad;
                    $total_colspan = $total_colspan + 2;
                }
                if ($numero == 4) {
                    $idcuarto_unidad = $value->idunidad;
                    $total_colspan = $total_colspan + 2;
                }
                if ($numero == 5) {
                    $idquinte_unidad = $value->idunidad;
                    $total_colspan = $total_colspan + 2;
                }
                if ($numero == 6) {
                    $idsexto_unidad = $value->idunidad;
                    $total_colspan = $total_colspan + 2;
                }
            }

            $alumnos = $this->grupo->alumnosGrupo($idhorario, $idprofesormateria, $idmateria, $estatus_alumno);
            $datoshorario = $this->horario->showNivelGrupo($idhorario);

            $idnivelestudio = $datoshorario->idnivelestudio;
            $detalle_configuracion = $this->configuracion->showAllConfiguracion($this->session->idplantel, $idnivelestudio);
            $tabla = "";
            $tabla = '<style type="text/css">
                    .txttitulo{
                       font-size:8px;
                       font-weight:bold;
                       text:center;
                   } 
                    .tblborder td
                    {
                        border:0px solid black;
                    }
                    .promediosemestral{
                      font-size:9px;
                    }
                    .sinborde{
                    border-right:solid 5px red;
                    }
                    .imgtitle{
                      width:70px;
                    }
                .txtnombre{
                       font-size:9px;
                       font-weight:bold;
                       text:center;
                }
                .txtalumno{
                        font-size:8px;
                       font-weight:bold;
                }
                .txtdocente{
                       font-size:9px;
                       font-weight:bold;
                       text:center;
                }
               </style>';
            $tabla .= '<table  border="0" >';
            if ((isset($this->session->idniveleducativo) && !empty($this->session->idniveleducativo)) && ($this->session->idniveleducativo == 1 || $this->session->idniveleducativo == 2)) {
                $tabla .= '<tr>
             <td width="150" align="center" valing="top"><img class="imgtitle"  src="' . $logo2 . '" /></td>
             <td colspan="2" width="450" align="center">
                     <label class="nombreplantel">' . $detalle_logo[0]->nombreplantel . '</label><br>
                     <label class="txtn">' . $detalle_logo[0]->asociado . '</label><br>
                     <label class="direccion">C.C.T.' . $detalle_logo[0]->clave . '</label><br>';
                $tabla .= '<label class="telefono">136 años educando a la niñez y juventud </label>
             </td>
             
             <td width="150" align="center"  ><img  class="imgtitle" src="' . $logo . '" /></td>';
                $tabla .= '</tr>';
                $tabla .= ' <tr><td colspan="4" align="center" class="txtdocente" ><strong>CONCENTRADO DE CALIFICACIONES</strong></td></tr>';
                $tabla .= ' <tr><td colspan="4" align="center"  class="txtdocente" ><strong>CICLO ESCOLAR ' . $detalle_horario_p->yearinicio . '-' . $detalle_horario_p->yearfin . '</strong></td></tr>';
                $tabla .= ' <tr><td colspan="4" align="left"  class="txtdocente" ><strong>ASIGNATURA: ' . $detalle_horario->nombreclase . '</strong></td></tr>';
                $tabla .= ' <tr><td colspan="2" align="left"  class="txtdocente" ><strong>DOCENTE: ' . $detalle_horario->nombre . ' ' . $detalle_horario->apellidop . ' ' . $detalle_horario->apellidom . '</strong></td>' . '<td colspan="2" align="right" class="txtdocente" ><strong>AÑO: ' . $detalle_horario->numeroordinaria . '</strong></td></tr>';
            }
            $tabla .= '</table><br><br>';

            $tabla .= ' <table class="tblcalificacion" border="0" cellpadding="3" >
                <tr class="tblborder">
                <td class="txttitulo" align="center" width="32">N Prog.</td>
                <td class="txttitulo" align="center" width="140">NOMBRE</td>';
            if (isset($idprimera_unidad) && !empty($idprimera_unidad)) {
                $row = $this->grupo->detalleUnidad($idprimera_unidad);
                $tabla .= '<td  align="center"    class="txttitulo">' . $row->nombreunidad . '</td>';
                $tabla .= '<td align="center"  class="txttitulo"   width="50">FALTAS</td>';
            }
            if (isset($idsegunda_unidad) && !empty($idsegunda_unidad)) {
                $row = $this->grupo->detalleUnidad($idsegunda_unidad);
                $tabla .= '<td  align="center" class="txttitulo">' . $row->nombreunidad . '</td>';
                $tabla .= '<td  align="center" class="txttitulo"  width="50">FALTAS</td>';
            }
            if (isset($idtercera_unidad) && !empty($idtercera_unidad)) {
                $row = $this->grupo->detalleUnidad($idtercera_unidad);
                $tabla .= '<td  align="center" class="txttitulo">' . $row->nombreunidad . '</td>';
                $tabla .= '<td  align="center" class="txttitulo"  width="50">FALTAS</td>';
            }
            if (isset($idcuarto_unidad) && !empty($idcuarto_unidad)) {
                $row = $this->grupo->detalleUnidad($idcuarto_unidad);
                $tabla .= '<td  align="center" class="txttitulo">' . $row->nombreunidad . '</td>';
                $tabla .= '<td  align="center" class="txttitulo"  width="50">FALTAS</td>';
            }
            if (isset($idquinte_unidad) && !empty($idquinte_unidad)) {
                $row = $this->grupo->detalleUnidad($idquinte_unidad);
                $tabla .= '<td  align="center" class="txttitulo">' . $row->nombreunidad . '</td>';
                $tabla .= '<td  align="center" class="txttitulo"  width="50">FALTAS</td>';
            }
            if (isset($idsexto_unidad) && !empty($idsexto_unidad)) {
                $row = $this->grupo->detalleUnidad($idsexto_unidad);
                $tabla .= '<td  align="center" class="txttitulo">' . $row->nombreunidad . '</td>';
                $tabla .= '<td  align="center" class="txttitulo"  width="50">FALTAS</td>';
            }
            $tabla .= '<td  align="center" class="txttitulo">EVALUACIÓN FINAL</td>';
            $tabla .= '<td  align="center" class="txttitulo">% ASISTENCIAS</td>';
            $tabla .= '</tr>';
            $c = 1;

            if (isset($alumnos) && !empty($alumnos)) {
                $suma_calificacion = 0;
                $total_asistencia = 0;
                $total_faltas = 0;
                foreach ($alumnos as $row) {
                    $suma_calificacion = 0;
                    $total_asistencia = 0;
                    $total_faltas = 0;
                    $tabla .= '<tr  class="tblborder">';
                    $tabla .= '  <td  align="center" class="txtnombre">' . $c++ . '</td>';
                    if ($row->opcion == 0) {
                        $tabla .= '<td  align="left"  class="txtalumno"><label style="color:red;">R:</label> ' . $row->apellidop . " " . $row->apellidom . " " . $row->nombre . '</td>';
                    } else {
                        $tabla .= '<td  align="left" class="txtalumno">' . $row->apellidop . " " . $row->apellidom . " " . $row->nombre . '</td>';
                    }
                    if (isset($idprimera_unidad) && !empty($idprimera_unidad)) {
                        $row1 = $this->grupo->detalleUnidad($idprimera_unidad);
                        $val = $this->grupo->obtenerCalificacionValidandoMateria($row->idalumno, $row1->idunidad, $idhorario, $idmateria);
                        $row_asistencia = $this->grupo->totalAsistencias($idprimera_unidad, $idhorariodetalle, $row->idalumno);
                        $tabla .= '<td  align="center" class="txtnombre">';
                        if ($val != false) {
                            $suma_calificacion = $suma_calificacion + $val->calificacion;
                            $tabla .= '<label>' . numberFormatPrecision($val->calificacion, 1, '.') . '  </label>';
                        } else {
                            $tabla .= '<small></small>';
                        }
                        $tabla .= '</td>';
                        if ($row_asistencia) {
                            $total_asistencia = $total_asistencia + $row_asistencia[0]->totalregistrado;
                            $total_faltas = $total_faltas + $row_asistencia[0]->totalfalta;
                            $tabla .= '<td class="txtnombre" align="center">' . $row_asistencia[0]->totalfalta . '</td>';
                        } else {
                            $tabla .= '<td class="txtnombre" align="center"></td>';
                        }
                    }
                    if (isset($idsegunda_unidad) && !empty($idsegunda_unidad)) {
                        $row2 = $this->grupo->detalleUnidad($idsegunda_unidad);
                        $val = $this->grupo->obtenerCalificacionValidandoMateria($row->idalumno, $row2->idunidad, $idhorario, $idmateria);
                        $row_asistencia = $this->grupo->totalAsistencias($idsegunda_unidad, $idhorariodetalle, $row->idalumno);
                        $tabla .= '<td  align="center" class="txtnombre">';
                        if ($val != false) {
                            $suma_calificacion = $suma_calificacion + $val->calificacion;
                            $tabla .= '<label>' . numberFormatPrecision($val->calificacion, 1, '.') . '  </label>';
                        } else {
                            $tabla .= '<small></small>';
                        }
                        $tabla .= '</td>';
                        if ($row_asistencia) {
                            $total_asistencia = $total_asistencia + $row_asistencia[0]->totalregistrado;
                            $total_faltas = $total_faltas + $row_asistencia[0]->totalfalta;
                            $tabla .= '<td class="txtnombre" align="center">' . $row_asistencia[0]->totalfalta . '</td>';
                        } else {
                            $tabla .= '<td class="txtnombre" align="center"></td>';
                        }
                    }
                    if (isset($idtercera_unidad) && !empty($idtercera_unidad)) {
                        $row3 = $this->grupo->detalleUnidad($idtercera_unidad);
                        $val = $this->grupo->obtenerCalificacionValidandoMateria($row->idalumno, $row3->idunidad, $idhorario, $idmateria);
                        $row_asistencia = $this->grupo->totalAsistencias($idtercera_unidad, $idhorariodetalle, $row->idalumno);
                        $tabla .= '<td class="txtnombre" align="center">';
                        if ($val != false) {
                            $suma_calificacion = $suma_calificacion + $val->calificacion;
                            $tabla .= '<label>' . numberFormatPrecision($val->calificacion, 1, '.') . '  </label>';
                        } else {
                            $tabla .= '<small></small>';
                        }
                        $tabla .= '</td>';
                        if ($row_asistencia) {
                            $total_asistencia = $total_asistencia + $row_asistencia[0]->totalregistrado;
                            $total_faltas = $total_faltas + $row_asistencia[0]->totalfalta;
                            $tabla .= '<td class="txtnombre" align="center">' . $row_asistencia[0]->totalfalta . '</td>';
                        } else {
                            $tabla .= '<td class="txtnombre" align="center"></td>';
                        }
                    }
                    if (isset($idcuarto_unidad) && !empty($idcuarto_unidad)) {
                        $row4 = $this->grupo->detalleUnidad($idcuarto_unidad);
                        $val = $this->grupo->obtenerCalificacionValidandoMateria($row->idalumno, $row4->idunidad, $idhorario, $idmateria);
                        $row_asistencia = $this->grupo->totalAsistencias($idcuarto_unidad, $idhorariodetalle, $row->idalumno);
                        $tabla .= '<td  class="txtnombre" align="center">';
                        if ($val != false) {
                            $suma_calificacion = $suma_calificacion + $val->calificacion;
                            $tabla .= '<label>' . $val->calificacion . '  </label>';
                        } else {
                            $tabla .= '<small></small>';
                        }
                        $tabla .= '</td>';
                        if ($row_asistencia) {
                            $total_asistencia = $total_asistencia + $row_asistencia[0]->totalregistrado;
                            $total_faltas = $total_faltas + $row_asistencia[0]->totalfalta;
                            $tabla .= '<td class="txtnombre" align="center">' . $row_asistencia[0]->totalfalta . '</td>';
                        } else {
                            $tabla .= '<td class="txtnombre" align="center"></td>';
                        }
                    }
                    if (isset($idquinte_unidad) && !empty($idquinte_unidad)) {
                        $row5 = $this->grupo->detalleUnidad($idquinte_unidad);
                        $val = $this->grupo->obtenerCalificacionValidandoMateria($row->idalumno, $row5->idunidad, $idhorario, $idmateria);
                        $row_asistencia = $this->grupo->totalAsistencias($idquinte_unidad, $idhorariodetalle, $row->idalumno);
                        $tabla .= '<td class="txtnombre" align="center">';
                        if ($val != false) {
                            $suma_calificacion = $suma_calificacion + $val->calificacion;
                            $tabla .= '<label>' . $val->calificacion . '  </label>';
                        } else {
                            $tabla .= '<small></small>';
                        }
                        $tabla .= '</td>';
                        if ($row_asistencia) {
                            $total_asistencia = $total_asistencia + $row_asistencia[0]->totalregistrado;
                            $total_faltas = $total_faltas + $row_asistencia[0]->totalfalta;
                            $tabla .= '<td class="txtnombre" align="center">' . $row_asistencia[0]->totalfalta . '</td>';
                        } else {
                            $tabla .= '<td class="txtnombre" align="center"></td>';
                        }
                    }
                    if (isset($idsexto_unidad) && !empty($idsexto_unidad)) {
                        $row6 = $this->grupo->detalleUnidad($idsexto_unidad);
                        $val = $this->grupo->obtenerCalificacionValidandoMateria($row->idalumno, $row6->idunidad, $idhorario, $idmateria);
                        $row_asistencia = $this->grupo->totalAsistencias($idsexto_unidad, $idhorariodetalle, $row->idalumno);
                        $tabla .= '<td class="txtnombre" align="center">';
                        if ($val != false) {
                            $suma_calificacion = $suma_calificacion + $val->calificacion;
                            $tabla .= '<label>' . $val->calificacion . '  </label>';
                        } else {
                            $tabla .= '<small></small>';
                        }
                        $tabla .= '</td>';
                        if ($row_asistencia) {
                            $total_asistencia = $total_asistencia + $row_asistencia[0]->totalregistrado;
                            $total_faltas = $total_faltas + $row_asistencia[0]->totalfalta;
                            $tabla .= '<td class="txtnombre" align="center">' . $row_asistencia[0]->totalfalta . '</td>';
                        } else {
                            $tabla .= '<td class="txtnombre" align="center"></td>';
                        }
                    }
                    $tabla .= '<td class="txtnombre" align="center">';
                    if ($suma_calificacion > 0 && $unidades_materia > 0) {
                        $tabla .= '<label>' . numberFormatPrecision(($suma_calificacion / $unidades_materia), 1, '.') . '</label>';
                    } else {
                        $tabla .= '<small></small>';
                    }
                    $tabla .= '</td>';
                    $tabla .= '<td class="txtnombre" align="center">';
                    if ($total_faltas > 0 && $total_asistencia > 0) {
                        $tabla .= '<label>' . obtenerPorcentaje($total_faltas, $total_asistencia) . '%</label>';
                    } else {
                        $tabla .= '<label>100%</label>';
                    }
                    $tabla .= '</td>';
                    $tabla .= '</tr>';
                }
                $tabla .= '<tr>';
                $tabla .= '<td colspan="2"class="txtnombre"  align="center"></td>';
                if (isset($idprimera_unidad) && !empty($idprimera_unidad)) {
                    $tabla .= '<td></td>';
                    $tabla .= '<td></td>';
                }
                if (isset($idsegunda_unidad) && !empty($idsegunda_unidad)) {
                    $tabla .= '<td></td>';
                    $tabla .= '<td></td>';
                }
                if (isset($idtercera_unidad) && !empty($idtercera_unidad)) {
                    $tabla .= '<td></td>';
                    $tabla .= '<td></td>';
                }
                if (isset($idcuarto_unidad) && !empty($idcuarto_unidad)) {
                    $tabla .= '<td></td>';
                    $tabla .= '<td></td>';
                }
                if (isset($idquinte_unidad) && !empty($idquinte_unidad)) {
                    $tabla .= '<td></td>';
                    $tabla .= '<td></td>';
                }
                if (isset($idsexto_unidad) && !empty($idsexto_unidad)) {
                    $tabla .= '<td></td>';
                    $tabla .= '<td class="promediosemestral"></td>';
                }
                $tabla .= '<td></td>';
                $tabla .= '</tr>';

                $tabla .= '<tr  class="tblborder">';
                $tabla .= '<td colspan="2" align="center">Firma del Docente</td>';
                if (isset($idprimera_unidad) && !empty($idprimera_unidad)) {
                    $tabla .= '<td></td>';
                    if (isset($idsegunda_unidad) && empty($idsegunda_unidad)) {
                        $tabla .= '<td class="promediosemestral">Promedio semestral</td>';
                    } else {
                        $tabla .= '<td></td>';
                    }
                }
                if (isset($idsegunda_unidad) && !empty($idsegunda_unidad)) {
                    $tabla .= '<td></td>';
                    if (isset($idtercera_unidad) && empty($idtercera_unidad)) {
                        $tabla .= '<td class="promediosemestral">Promedio semestral</td>';
                    } else {
                        $tabla .= '<td></td>';
                    }
                }
                if (isset($idtercera_unidad) && !empty($idtercera_unidad)) {
                    $tabla .= '<td></td>';
                    if (isset($idcuarto_unidad) && empty($idcuarto_unidad)) {
                        $tabla .= '<td class="promediosemestral">Promedio semestral</td>';
                    } else {
                        $tabla .= '<td></td>';
                    }
                }
                if (isset($idcuarto_unidad) && !empty($idcuarto_unidad)) {
                    $tabla .= '<td></td>';
                    if (isset($idquinte_unidad) && empty($idquinte_unidad)) {
                        $tabla .= '<td class="promediosemestral">Promedio semestral</td>';
                    } else {
                        $tabla .= '<td></td>';
                    }
                }
                if (isset($idquinte_unidad) && !empty($idquinte_unidad)) {
                    $tabla .= '<td></td>';
                    if (isset($idsexto_unidad) && empty($idsexto_unidad)) {
                        $tabla .= '<td class="promediosemestral">Promedio semestral</td>';
                    } else {
                        $tabla .= '<td></td>';
                    }
                }
                if (isset($idsexto_unidad) && !empty($idsexto_unidad)) {
                    $tabla .= '<td></td>';
                    $tabla .= '<td class="promediosemestral">Promedio semestral</td>';
                }
                $tabla .= '<td></td>';
                $tabla .= '</tr>';
                $tabla .= '<tr><td colspan="' . $total_colspan . '">Obervaciones</td></tr>';
                $tabla .= '<tr><td colspan="' . $total_colspan . '" style="border-bottom:solid 1px black;"></td></tr>';
                $tabla .= '<tr><td colspan="' . $total_colspan . '" style="border-bottom:solid 1px black;"></td></tr>';
                $tabla .= '<tr><td colspan="' . $total_colspan . '" style="border-bottom:solid 1px black;"></td></tr>';
            }
            $tabla .= '</table>';
            $pdf->writeHTML($tabla, true, false, false, false, '');

            ob_end_clean();

            $pdf->Output('Calificaciones.pdf', 'D');
        } else if ($tiporeporte == 30) {
            $idhorariodetalle_encriptado = $this->encode($idhorariodetalle);
            redirect('Pgrupo/calificaciones/' . $idhorariodetalle_encriptado . '/' . $tiporeporte);
        } else {
            $idhorariodetalle_encriptado = $this->encode($idhorariodetalle);
            redirect('Pgrupo/calificaciones/' . $idhorariodetalle_encriptado . '/' . $tiporeporte);
        }
    }

    public function calificaciones($idhorariodetalle, $tiporeporte)
    {
        $idhorariodetalle = $this->decode($idhorariodetalle);
        if ((isset($idhorariodetalle) && !empty($idhorariodetalle))) {
            $tabla = "";
            if ($tiporeporte == 30) {
                $tabla = $this->reporteCalificacionAlumnos($idhorariodetalle);
            } else {
                $tabla = $this->reporteCalificacionPorOportunidad($idhorariodetalle, $tiporeporte);
            }

            $data = array(
                'tabla' => $tabla
            );
            $this->load->view('docente/header');
            $this->load->view('docente/grupo/reporte/calificaciones_alumnos', $data);
            $this->load->view('docente/footer');
        }
    }
    public function calificacionMes($idhorariodetalle, $idmes)
    {
        $idhorariodetalle = $this->decode($idhorariodetalle);
        $idmes = $this->decode($idmes);
        if ((isset($idhorariodetalle) && !empty($idhorariodetalle)) && (isset($idmes) && !empty($idmes))) {

            $tabla = "";
            $tabla = $this->obtenerCalificacionXMes($idhorariodetalle, $idmes);
            $data = array(
                'tabla' => $tabla
            );
            $this->load->view('docente/header');
            $this->load->view('docente/grupo/reporte/calificaciones_alumnos', $data);
            $this->load->view('docente/footer');
        }
    }

    public function obtenerCalificacionXMes($idhorariodetalle, $idmes)
    {
        $tabla = "";
        $detalle_horario = $this->grupo->detalleHorarioDetalle($idhorariodetalle);
        $idhorario = $detalle_horario->idhorario;
        $idprofesormateria = $detalle_horario->idprofesormateria;
        $idmateria = $detalle_horario->idmateria;
        $idclasificacionmateria = $detalle_horario->idclasificacionmateria;
        $estatus_alumno = $detalle_horario->activo;

        $alumnos = $this->grupo->alumnosGrupo($idhorario, $idprofesormateria, $idmateria, $estatus_alumno);

        $tabla .= '<table id="tablageneral2" class="table table-striped  dt-responsive nowrap" cellspacing="0" width="100%">
            <thead class="bg-teal">
                 <th>#</th>
                 <th>NOMBRE</th>';
        $tabla .= '<th>CALIFICACIÓN</th>';
        $tabla .= '</thead>';
        $c = 1;

        if (isset($alumnos) && !empty($alumnos)) {
            foreach ($alumnos as $row) {
                $idalumno = $row->idalumno;
                $tabla .= '<tr>';
                $tabla .= '<td>' . $c++ . '</td>';
                $tabla .= '<td>' . $row->apellidop . " " . $row->apellidom . " " . $row->nombre . '</td>';
                $calificacion = $this->grupo->calificacionXMes($idalumno, $idhorariodetalle, $idmes);
                if ($calificacion) {
                    $tabla .= '<td align="left"><label>' . numberFormatPrecision($calificacion[0]->calificacion, 1, '.') . '</label></td>';
                } else {
                    $tabla .= '<td><small>No registrado</small></td>';
                }

                $tabla .= '</tr>';
            }
        }
        $tabla .= '</table>';
        return $tabla;
    }
    public function reporteCalificacionPorOportunidad($idhorariodetalle, $idportunidad)
    {
        $tabla = "";
        $calificaciones = $this->grupo->showAllCalificacionOportunidad($idhorariodetalle, $idportunidad);
        $tabla .= '<table id="tablageneral2" class="table table-striped  dt-responsive nowrap" cellspacing="0" width="100%">
            <thead class="bg-teal">
                <th>#</th>
                 <th>NOMBRE</th>';
        $tabla .= '<th>CALIFICACIÓN</th>';
        $tabla .= '</thead>';
        $c = 1;

        if (isset($calificaciones) && !empty($calificaciones)) {
            foreach ($calificaciones as $row) {
                $tabla .= '<tr>';
                $tabla .= '<td>' . $c++ . '</td>';
                $tabla .= '<td>' . $row->apellidop . " " . $row->apellidom . " " . $row->nombre . '</td>';
                $tabla .= '<td>' . numberFormatPrecision($row->calificacion, 1, '.') . ' </td>';
                $tabla .= '</tr>';
            }
        }
        $tabla .= '</table>';
        return $tabla;
    }
    public function reporteCalificacionAlumnos($idhorariodetalle)
    {
        if ((isset($this->session->idnivelestudio) && !empty($this->session->idnivelestudio)) && ($this->session->idnivelestudio == 5)) {
            $detalle_horario = $this->grupo->detalleHorarioDetalle($idhorariodetalle);

            $idhorario = $detalle_horario->idhorario;
            $idprofesormateria = $detalle_horario->idprofesormateria;
            $idmateria = $detalle_horario->idmateria;
            $unidades_materia = $detalle_horario->unidades;
            $unidades = "";
            if (isset($unidades_materia) && !empty($unidades_materia)) {
                $this->session->idplantel;
                $unidades = $this->grupo->unidades($this->session->idplantel, $unidades_materia);
            }
            $estatus_alumno = $detalle_horario->activo;
            $alumnos = $this->grupo->alumnosGrupo($idhorario, $idprofesormateria, $idmateria, $estatus_alumno);
            $datoshorario = $this->horario->showNivelGrupo($idhorario);
            $idnivelestudio = $datoshorario->idnivelestudio;
            $detalle_configuracion = $this->configuracion->showAllConfiguracion($this->session->idplantel, $idnivelestudio);
            $tabla = "";
            $tabla .= '<table id="tablageneral2" class="table table-striped  dt-responsive nowrap" cellspacing="0" width="100%">
            <thead class="bg-teal">
      <th>#</th>
      <th>NOMBRE</th>';
            if (isset($unidades) && !empty($unidades)) {
                foreach ($unidades as $block) :
                    $tabla .= '<th>' . $block->nombreunidad . '</th>';
                endforeach;
            }
            $tabla .= '<th>PROMEDIO</th>';
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
                    if (isset($unidades) && !empty($unidades)) {
                        foreach ($unidades as $block) :
                            $total_unidades += 1;
                            $val = $this->grupo->obtenerCalificacionValidandoMateria($row->idalumno, $block->idunidad, $idhorario, $idmateria);
                            $tabla .= '<td>';
                            if ($val != false) {
                                $suma_calificacion = $suma_calificacion + $val->calificacion;
                                $tabla .= '<label>' . numberFormatPrecision($val->calificacion, '.') . '  </label>';
                            } else {
                                $tabla .= '<label>No registrado</label>';
                            }
                            $tabla .= '</td>';
                        endforeach;
                    }
                    $tabla .= '<td>';
                    if (isset($unidades) && !empty($unidades)) {
                        $calificacion_final = numberFormatPrecision($suma_calificacion / $total_unidades, 1, '.');
                        if (validar_calificacion($calificacion_final, $detalle_configuracion[0]->calificacion_minima)) {
                            if ($suma_calificacion > 0.0) {
                                $tabla .= '<label style="color:red;">' . numberFormatPrecision($suma_calificacion / $total_unidades, 1, '.') . '</label>';
                            } else {
                                $tabla .= '<label "> </label>';
                            }
                        } else {
                            $tabla .= '<label style="color:green;">' . numberFormatPrecision($suma_calificacion / $total_unidades, 1, '.') . '</label>';
                        }
                    }
                    $tabla .= '</td>';
                    $tabla .= '</tr>';
                }
            }
            $tabla .= '</table>';
            return $tabla;
        } else {
            $unidades = $this->grupo->unidades($this->session->idplantel);
            $detalle_horario = $this->grupo->detalleHorarioDetalle($idhorariodetalle);
            $idprofesormateria = $detalle_horario->idprofesormateria;
            $idmateria = $detalle_horario->idmateria;
            $idhorario = $detalle_horario->idhorario;
            $estatus_alumno = $detalle_horario->activo;
            $alumnos = $this->grupo->alumnosGrupo($idhorario, $idprofesormateria, $idmateria, $estatus_alumno);
            $datoshorario = $this->horario->showNivelGrupo($idhorario);

            $idnivelestudio = $datoshorario->idnivelestudio;
            $detalle_configuracion = $this->configuracion->showAllConfiguracion($this->session->idplantel, $idnivelestudio);
            $tabla = "";
            $tabla .= ' <table id="tablageneral2" class="table table-striped dt-responsive nowrap" cellspacing="0" width="100%">
      <thead class="bg-teal">
      <th>#</th>
      <th>NOMBRE</th>';
            foreach ($unidades as $block) :

                $tabla .= '<th>' . $block->nombreunidad . '</th>';
                $tabla .= '<th>FALTAS</th>';
            endforeach;
            $tabla .= '<th>PROMEDIO</th>';
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
                    foreach ($unidades as $block) :
                        $idunidad = $block->idunidad;
                        $idalumno = $row->idalumno;
                        $total_unidades += 1;
                        $val = $this->grupo->obtenerCalificacionValidandoMateria($row->idalumno, $block->idunidad, $idhorario, $idmateria);

                        if ($val) {
                            $idcalificacion = $val->idcalificacion;
                            $tabla .= '<td>';
                            if ($val->calificacion > 0) {
                                $suma_calificacion = $suma_calificacion + $val->calificacion;
                                $tabla .= '<label>' . numberFormatPrecision($val->calificacion, 1) . '  </label>';
                            } else {
                                $tabla .= '<small><strong>No lleva este curso.</strong></small>';
                            }
                            $tabla .= '</td>';
                            $row_faltas = $this->grupo->totalAsistencias($idunidad, $idhorariodetalle, $idalumno);

                            if ($row_faltas) {
                                $tabla .= '<td>' . $row_faltas[0]->totalfalta . '</td>';
                            } else {
                                $tabla .= '<td><small>0</small></td>';
                            }
                        } else {
                            $tabla .= '<td><small>No registrado</small></td>';
                            $tabla .= '<td><small>No registrado</small></td>';
                        }
                    endforeach;
                    $tabla .= '<td>';
                    $calificacion_final = numberFormatPrecision($suma_calificacion / $total_unidades, 1, '.');
                    if (validar_calificacion($calificacion_final, $detalle_configuracion[0]->calificacion_minima)) {
                        if ($suma_calificacion > 0.0) {
                            $tabla .= '<label style="color:red;">' . numberFormatPrecision($suma_calificacion / $total_unidades, 1, '.') . '</label>';
                        } else {
                            $tabla .= '<label "> </label>';
                        }
                    } else {
                        $tabla .= '<label style="color:green;">' . numberFormatPrecision($suma_calificacion / $total_unidades, 1, '.') . '</label>';
                    }
                    $tabla .= '</td>';
                    $tabla .= '</tr>';
                }
            }
            $tabla .= '</table>';
            return $tabla;
        }
    }
}
