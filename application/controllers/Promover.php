<?php

defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("America/Mexico_City");

class Promover extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        if (!isset($_SESSION['user_id'])) {
            $this->session->set_flashdata('flash_data', 'You don\'t have access! ss');
            return redirect('welcome');
        }
        $this->load->helper('url');
        $this->load->model('profesor_model', 'profesor');
        $this->load->model('alumno_model', 'alumno');
        $this->load->model('grupo_model', 'grupo');
        $this->load->model('horario_model', 'horario');
        $this->load->model('cicloescolar_model', 'cicloescolar');
        $this->load->model('promover_model', 'promover');
        $this->load->model('data_model');
        $this->load->library('permission');
        $this->load->library('session');
        $this->load->model('configuracion_model', 'configuracion');
        //VARIABLES GLOBALES DE CONFIGURACION
        //PRIMARIA
        $this->promedio_minimo_primaria = 7.00;
        $this->permitir_materia_reprobada_primaria = false;
        //$this->total_materia_reprobada_primaria = 0;
        //SECUNDARIA
        $this->promedio_minimo_secundaria = 7.00;
        $this->permitir_materia_reprobada_secundaria = false;
        //$this->total_materia_reprobada_segundaria = 0;
        //PREPARATORIA
        $this->promedio_minimo_preparatoria = 7.00;
        $this->permitir_materia_reprobada_preparatoria = false;
        //$this->total_materia_reprobada_primaria = 0;

        $this->load->helper('numeroatexto_helper');
        //
    }

    public function index()
    {
        Permission::grant(uri_string());
        $cicloescolar_activo = $this->cicloescolar->showAllCicloEscolarActivo($this->session->idplantel);
        $cicloescolar_inactivo = $this->cicloescolar->showAllCicloEscolarDesActivo($this->session->idplantel);
        $data = array(
            'cicloescolar' => $cicloescolar_activo,
            'grupos' => $this->alumno->showAllGrupos($this->session->idplantel),
        );
        $this->load->view('admin/header');
        $this->load->view('admin/promover/index', $data);
        $this->load->view('admin/footer');
    }
    public function admin()
    {
        $cicloescolar_activo = $this->cicloescolar->showAllCicloEscolarActivo($this->session->idplantel);
        $cicloescolar_inactivo = $this->cicloescolar->showAllCicloEscolarDesActivo($this->session->idplantel);
        $data = array(
            'cicloescolaractivo' => $cicloescolar_activo,
            'cicloescolarinactivo' => $cicloescolar_inactivo,
            'grupos' => $this->alumno->showAllGrupos($this->session->idplantel),
        );
        $this->load->view('admin/header');
        $this->load->view('admin/promover/admin', $data);
        $this->load->view('admin/footer');
    }
    public function promover()
    {
        $config = array(
            array(
                'field' => 'grupo',
                'label' => 'Grupo',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => '%s campo requerido.'
                )
            ),
            array(
                'field' => 'cicloescolar',
                'label' => 'Ciclo Escolar',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => '%s campo requerido.'
                )
            ),
            array(
                'field' => 'grupoposterior',
                'label' => 'Grupo Posterior',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => '%s campo requerido.'
                )
            ),
            array(
                'field' => 'cicloescolarposterior',
                'label' => 'Ciclo Escolar Posperior',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => '%s campo requerido.'
                )
            )
        );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            $errors = validation_errors();
            echo json_encode(['error' => $errors]);
        } else {
            $idgrupo = $this->input->post('grupo');
            $idclicloescolar = $this->input->post('cicloescolar');
            $idgrupoposterior = $this->input->post('grupoposterior');
            $idcicloescolarposterior = $this->input->post('cicloescolarposterior');
            $grupo = $this->promover->obtenerDetalleGrupo($idgrupo);
            if ($grupo) {
                switch ($this->session->idniveleducativo) {
                    case 1:
                        //PRIMARIA
                        if ($grupo->idnivelestudio < 6) {
                            $regreso =  $this->procesoPromover($idgrupo, $idclicloescolar, $idgrupoposterior, $idcicloescolarposterior);
                            if (isset($regreso) && !empty($regreso)) {
                                $total_fallas_desactivar = $regreso["falla_desactivar"];
                                $total_fallas_agregar = $regreso["falla_agregar"];
                                if ($total_fallas_desactivar > 0 || $total_fallas_agregar > 0) {
                                    echo json_encode([
                                        'success' => 'Error',
                                        'error' => 'Algunos alumnos no se pudieron promover, intente nuevamente.'
                                    ]);
                                } else {
                                    echo json_encode([
                                        'success' => 'Exito',
                                        'mensaje' => 'Se promovieron todos los alumnos del grupo.'
                                    ]);
                                }
                            } else {
                                echo json_encode([
                                    'success' => 'Error',
                                    'error' => 'No se pudieron promover, intente nuevamente.'
                                ]);
                            }
                        } else {
                            echo json_encode([
                                'success' => 'Error',
                                'error' => 'No se puede promover a los alumnos del grupo porque es el ultimo nivel.'
                            ]);
                        }
                        break;
                    case 2:
                        //SECUNDARIA
                        if ($grupo->idnivelestudio < 3) {
                            $regreso =  $this->procesoPromover($idgrupo, $idclicloescolar, $idgrupoposterior, $idcicloescolarposterior);
                            if (isset($regreso) && !empty($regreso)) {
                                $total_fallas_desactivar = $regreso["falla_desactivar"];
                                $total_fallas_agregar = $regreso["falla_agregar"];
                                if ($total_fallas_desactivar > 0 || $total_fallas_agregar > 0) {
                                    echo json_encode([
                                        'success' => 'Error',
                                        'error' => 'Algunos alumnos no se pudieron promover, intente nuevamente.'
                                    ]);
                                } else {
                                    echo json_encode([
                                        'success' => 'Exito',
                                        'mensaje' => 'Se promovieron todos los alumnos del grupo.'
                                    ]);
                                }
                            } else {
                                echo json_encode([
                                    'success' => 'Error',
                                    'error' => 'No se pudieron promover, intente nuevamente.'
                                ]);
                            }
                        } else {
                            echo json_encode([
                                'success' => 'Error',
                                'error' => 'No se puede promover a los alumnos del grupo porque es el ultimo nivel.'
                            ]);
                        }
                        break;
                    case 3:
                        //MEDIO SUPERIOR
                        if ($grupo->idnivelestudio < 6) {
                            $regreso =  $this->procesoPromover($idgrupo, $idclicloescolar, $idgrupoposterior, $idcicloescolarposterior);
                            if (isset($regreso) && !empty($regreso)) {
                                $total_fallas_desactivar = $regreso["falla_desactivar"];
                                $total_fallas_agregar = $regreso["falla_agregar"];
                                if ($total_fallas_desactivar > 0 || $total_fallas_agregar > 0) {
                                    echo json_encode([
                                        'success' => 'Error',
                                        'error' => 'Algunos alumnos no se pudieron promover, intente nuevamente.'
                                    ]);
                                } else {
                                    echo json_encode([
                                        'success' => 'Exito',
                                        'mensaje' => 'Se promovieron todos los alumnos del grupo.'
                                    ]);
                                }
                            } else {
                                echo json_encode([
                                    'success' => 'Error',
                                    'error' => 'No se pudieron promover, intente nuevamente.'
                                ]);
                            }
                        } else {
                            echo json_encode([
                                'success' => 'Error',
                                'error' => 'No se puede promover a los alumnos del grupo porque es el ultimo nivel.'
                            ]);
                        }
                        break;
                    case 4:
                        //PREESCOLAR
                        if ($grupo->idnivelestudio < 3) {
                            $regreso =  $this->procesoPromover($idgrupo, $idclicloescolar, $idgrupoposterior, $idcicloescolarposterior);
                            if (isset($regreso) && !empty($regreso)) {
                                $total_fallas_desactivar = $regreso["falla_desactivar"];
                                $total_fallas_agregar = $regreso["falla_agregar"];
                                if ($total_fallas_desactivar > 0 || $total_fallas_agregar > 0) {
                                    echo json_encode([
                                        'success' => 'Error',
                                        'error' => 'Algunos alumnos no se pudieron promover, intente nuevamente.'
                                    ]);
                                } else {
                                    echo json_encode([
                                        'success' => 'Exito',
                                        'mensaje' => 'Se promovieron todos los alumnos del grupo.'
                                    ]);
                                }
                            } else {
                                echo json_encode([
                                    'success' => 'Error',
                                    'error' => 'No se pudieron promover, intente nuevamente.'
                                ]);
                            }
                        } else {
                            echo json_encode([
                                'success' => 'Error',
                                'error' => 'No se puede promover a los alumnos del grupo porque es el ultimo nivel.'
                            ]);
                        }
                        break;
                    case 5:
                        //LICENCIATURA
                        if ($grupo->idnivelestudio < 8) {
                            $regreso =  $this->procesoPromover($idgrupo, $idclicloescolar, $idgrupoposterior, $idcicloescolarposterior);
                            if (isset($regreso) && !empty($regreso)) {
                                $total_fallas_desactivar = $regreso["falla_desactivar"];
                                $total_fallas_agregar = $regreso["falla_agregar"];
                                if ($total_fallas_desactivar > 0 || $total_fallas_agregar > 0) {
                                    echo json_encode([
                                        'success' => 'Error',
                                        'error' => 'Algunos alumnos no se pudieron promover, intente nuevamente.'
                                    ]);
                                } else {
                                    echo json_encode([
                                        'success' => 'Exito',
                                        'mensaje' => 'Se promovieron todos los alumnos del grupo.'
                                    ]);
                                }
                            } else {
                                echo json_encode([
                                    'success' => 'Error',
                                    'error' => 'No se pudieron promover, intente nuevamente.'
                                ]);
                            }
                        } else {
                            echo json_encode([
                                'success' => 'Error',
                                'error' => 'No se puede promover a los alumnos del grupo porque es el ultimo nivel.'
                            ]);
                        }
                        break;
                    default:
                        echo json_encode([
                            'success' => 'Error',
                            'error' => 'No se puede promover a los alumnos del grupo porque es el ultimo nivel.'
                        ]);
                        break;
                }
            }
        }
    }
    public function procesoPromover($idgrupo = '', $idclicloescolar = '', $idgrupoposterior = '', $idcicloescolarposterior = '')
    {
        $regreso = "";
        if (((isset($idgrupo) && !empty($idgrupo)) && (isset($idclicloescolar) && !empty($idclicloescolar)))
            && ((isset($idgrupoposterior) && !empty($idgrupoposterior)) && (isset($idcicloescolarposterior) && !empty($idcicloescolarposterior)))
        ) {
            $alumnos = $this->alumno->spObtenerAlumnosGrupo($idclicloescolar, $idgrupo);
            if (isset($alumnos) && !empty($alumnos)) {
                $falla_desactivar = 0;
                $falla_agregar = 0;
                foreach ($alumnos as $value) {
                    if ($value->activoalumno == 1 && $value->idhorario != '') {
                        $idalumno = $value->idalumno;
                        $alumnogrupo = $this->promover->obtenerAlumnoGrupo($idalumno, $idclicloescolar);
                        $idalumnogrupo = $alumnogrupo->idalumnogrupo;
                        $update = array(
                            'activo' => 0
                        );
                        $desactivar = $this->promover->updateAlumnoGrupo($idalumnogrupo, $update);
                        if ($value->idalumnoestatus == 1) {
                            if ($desactivar) {
                                $add = array(
                                    'idalumno' => $idalumno,
                                    'idperiodo' => $idcicloescolarposterior,
                                    'idgrupo' => $idgrupoposterior,
                                    'idbeca' => 1,
                                    'idestatusnivel' => 1,
                                    'activo' => 1,
                                    'idusuario' => $this->session->user_id,
                                    'fecharegistro' => date('Y-m-d H:i:s')
                                );
                                $agregar = $this->promover->addAlumnoGrupo($add);
                                if ($agregar) {
                                } else {
                                    $falla_agregar++;
                                }
                            } else {
                                $falla_desactivar++;
                            }
                        }
                    }
                }
                $regreso = array(
                    'falla_desactivar' => $falla_desactivar,
                    'falla_agregar' => $falla_agregar
                );
            }
        }
        return $regreso;
    }
    public function buscar()
    {
        $config = array(
            array(
                'field' => 'grupo',
                'label' => 'planeacion',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Seleccione el Grupo.'
                )
            ),
            array(
                'field' => 'cicloescolar',
                'label' => 'Modelo',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Seleccione el Ciclo Escolar.'
                )
            )
        );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            $errors = validation_errors();
            echo json_encode(['error' => $errors]);
        } else {
            $idgrupo = $this->input->post('grupo');
            $idclicloescolar = $this->input->post('cicloescolar');
            $alumnos = $this->alumno->spObtenerAlumnosGrupo($idclicloescolar, $idgrupo);
            $tabla = '';
            if (isset($alumnos) && !empty($alumnos)) {
                $tabla .= ' <table class="table table-striped">
                    <thead class="bg-teal">
                      <tr> 
                        <th>#</th>
                        <th></th>
                        <th>ALUMNO(A)</th>
                        <th>PROMEDIO</th>
                        <th>ESTATUS</th>
                        <th align="center">APROBADAS</th>
                        <th>NOTAS</th>
                       
                        <th></th>
                      </tr>
                    </thead>
                    <tbody> ';
                $contador = 1;

                foreach ($alumnos as $value) {
                    if ($value->activoalumno == 1 && $value->idhorario != '') {
                        //  $datos_calificacion = $this->promover->calificacionAlumnoParaPromover($value->idalumno, $idgrupo, $value->idhorario);
                        $idalumno = $value->idalumno;
                        $idhorario  = $value->idhorario;
                        $calificacion_materias  = $this->alumno->spObtenerCalificacion($idalumno, $idhorario, $idclicloescolar);
                        $tabla .= '<tr>';
                        $tabla .= '<td>' . $contador++ . '</td>';
                        $tabla .= '<td>';
                        if ($value->opcion == 1) {
                            $tabla .= '<label  style="color:green;">N</label>';
                        } else {
                            $tabla .= '<label style="color:red;">R</label>';
                        }
                        $tabla .= '</td>';
                        $tabla .= '<td>' . $value->apellidop . ' ' . $value->apellidom . ' ' . $value->nombre . '</td>';
                        $tabla .= '<td>';
                        if (isset($calificacion_materias) && !empty($calificacion_materias)) {

                            $calificacion_materia = 0;
                            $contador_materia = 0;
                            $total_materia_reprobada = 0;
                            $total_materia_aprobada = 0;
                            $maximo_reprobados = 0;
                            $calificacion_minima = 0;
                            //VALIDAR UNIDADES REGISTRADAS
                            $total_unidades_faltantes = 0;
                            //FIN DE UNIDADES REGISTRADAS
                            foreach ($calificacion_materias as $row) {
                                if ($row->mostrar == 'SI') {
                                    $idnivelestudio = $this->session->idnivelestudio;
                                    $detalle_configuracion = $this->configuracion->showAllConfiguracion($this->session->idplantel, $idnivelestudio);
                                    $calificacion_materia =  $row->calificacion + $calificacion_materia;
                                    $maximo_reprobados = $detalle_configuracion[0]->reprovandas_minima;
                                    $calificacion_minima = $detalle_configuracion[0]->calificacion_minima;
                                    if ($row->calificacion < $detalle_configuracion[0]->calificacion_minima) {
                                        $total_materia_reprobada++;
                                    }
                                    if ($row->calificacion >= $detalle_configuracion[0]->calificacion_minima) {
                                        $total_materia_aprobada++;
                                    }
                                    if ($row->unidadesregistradas != 28) {
                                        if ($row->unidadesregistradas != $row->totalunidades) {
                                            $faltante = $row->totalunidades - $row->unidadesregistradas;
                                            // $total_unidades_faltante = 0;
                                            $total_unidades_faltantes  = $total_unidades_faltantes + $faltante;
                                        }
                                    }

                                    $contador_materia++;
                                }
                            }

                            $promedio = number_format(($calificacion_materia / $contador_materia), 2);
                            if ($promedio < $calificacion_minima) {
                                $tabla .= '<label  style="color:red;">' . eliminarDecimalCero(numberFormatPrecision($promedio, 1, '.')) . '</label>';
                            } else {
                                $tabla .= '<label style="color:green;">' .  eliminarDecimalCero(numberFormatPrecision($promedio, 1, '.')) . '</label>';
                            }

                            $tabla .= '</td>';
                            $tabla .= '<td>';
                            if ($promedio < $calificacion_minima || $total_materia_reprobada > $maximo_reprobados) {
                                $tabla .= '<label style="color:red;">REPROBADO</label>';
                            } else {
                                $tabla .= '<label style="color:green;" >APROBADO</label>';
                            }
                            $tabla .= '</td>';
                            $tabla .= '<td align="center">';
                            $tabla .= '<label>' . $total_materia_aprobada . "/" . $contador_materia . '</label>';
                            $tabla .= '</td>';
                            $tabla .= '<td>';
                            $tabla .= '<label>' . ($total_unidades_faltantes > 0) ? '<strong>' . $total_unidades_faltantes . '</strong> examen(es) estan pendientes para subir sus calificaciones' : 'Ok' . '</label>';
                            $tabla .= '</td>';

                            $tabla .= '<td align="right"><a  href="javascript:void(0)" class="edit_button btn btn-info"  data-toggle="modal"
                                  data-idalumno="' . $value->idalumno . '"
                                  data-idhorario="' . $idhorario . '"
                                   data-alumno="' . $value->apellidop . ' ' . $value->apellidom . ' ' . $value->nombre . '"
                                  data-idgrupo="' . $idgrupo . '"  title="Ver Calificaciones"><i class="fa fa-list-ul"></i> Detalle</a></td>';
                        } else {
                            $tabla .= '<td colspan="4">';
                            $tabla .= '<label>NO REGISTRADO SUS CALIFICACIONES</label>';
                            $tabla .= '</td>';
                        }
                        $tabla .= '</tr>';
                    }
                }
                $tabla .= ' </tbody>
                  </table>';
                echo json_encode([
                    'success' => 'Ok',
                    'tabla' => $tabla,
                    'idgrupo' => $idgrupo,
                    'idcicloescolar' => $idclicloescolar
                ]);
            } else {
                // $tabla = '
                // <table><tr><td>ddd</td></tr></table>';
                echo json_encode([
                    'success' => 'Error',
                    'error' => 'No existe registros de Alumnos para el Grupo.'
                ]);
            }
        }
    }
    public function finalizar()
    {
        $config = array(
            array(
                'field' => 'grupo',
                'label' => 'Grupo',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => '%s campo requerido.'
                )
            ),
            array(
                'field' => 'cicloescolar',
                'label' => 'Ciclo Escolar',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => '%s campo requerido.'
                )
            )

        );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            $errors = validation_errors();
            echo json_encode(['error' => $errors]);
        } else {
            $idgrupo = $this->input->post('grupo');
            $idclicloescolar = $this->input->post('cicloescolar');
            $grupo = $this->promover->obtenerDetalleGrupo($idgrupo);
            if ($grupo) {
                switch ($this->session->idniveleducativo) {
                    case 1:
                        //PRIMARIA
                        if ($grupo->idnivelestudio == 6) {
                            $this->procesoFinalizar($idgrupo, $idclicloescolar);
                            echo json_encode([
                                'success' => 'Exito',
                                'mensaje' => 'Fueron finalizador los alumnos del ultimo nivel.'
                            ]);
                        } else {
                            echo json_encode([
                                'success' => 'Error',
                                'error' => 'No se puede finalizar los alumnos del grupo porque no es ultimo nivel.'
                            ]);
                        }
                        break;
                    case 2:
                        //SECUNDARIA
                        if ($grupo->idnivelestudio == 3) {
                            $this->procesoFinalizar($idgrupo, $idclicloescolar);
                            echo json_encode([
                                'success' => 'Exito',
                                'mensaje' => 'Fueron finalizador los alumnos del ultimo nivel.'
                            ]);
                        } else {
                            echo json_encode([
                                'success' => 'Error',
                                'error' => 'No se puede finalizar los alumnos del grupo porque no es ultimo nivel.'
                            ]);
                        }
                        break;
                    case 3:
                        //MEDIO SUPERIOR
                        if ($grupo->idnivelestudio == 6) {
                            $this->procesoFinalizar($idgrupo, $idclicloescolar);
                            echo json_encode([
                                'success' => 'Exito',
                                'mensaje' => 'Fueron finalizador los alumnos del ultimo nivel.'
                            ]);
                        } else {
                            echo json_encode([
                                'success' => 'Error',
                                'error' => 'No se puede finalizar los alumnos del grupo porque no es ultimo nivel.'
                            ]);
                        }
                        break;
                    case 4:
                        //PREESCOLAR
                        if ($grupo->idnivelestudio == 3) {
                            $this->procesoFinalizar($idgrupo, $idclicloescolar);
                            echo json_encode([
                                'success' => 'Exito',
                                'mensaje' => 'Fueron finalizador los alumnos del ultimo nivel.'
                            ]);
                        } else {
                            echo json_encode([
                                'success' => 'Error',
                                'error' => 'No se puede finalizar los alumnos del grupo porque no es ultimo nivel.'
                            ]);
                        }
                        break;
                    case 5:
                        //LICENCIATURA
                        if ($grupo->idnivelestudio == 8) {
                            $this->procesoFinalizar($idgrupo, $idclicloescolar);
                            echo json_encode([
                                'success' => 'Exito',
                                'mensaje' => 'Fueron finalizador los alumnos del ultimo nivel.'
                            ]);
                        } else {
                            echo json_encode([
                                'success' => 'Error',
                                'error' => 'No se puede finalizar los alumnos del grupo porque no es ultimo nivel.'
                            ]);
                        }
                        break;
                    default:
                        echo json_encode([
                            'success' => 'Error',
                            'error' => 'No se puede finalizar los alumnos del grupo porque no es ultimo nivel.'
                        ]);
                        break;
                }
            }
        }
    }
    public function procesoFinalizar($idgrupo = '', $idclicloescolar = '')
    {
        if ((isset($idgrupo) && !empty($idgrupo)) && (isset($idclicloescolar) && !empty($idclicloescolar))) {
            $alumnos = $this->alumno->spObtenerAlumnosGrupo($idclicloescolar, $idgrupo);
            if (isset($alumnos) && !empty($alumnos)) {
                foreach ($alumnos as $value) {
                    if ($value->activoalumno == 1 && $value->idhorario != '') {
                        $idalumno = $value->idalumno;
                        $alumnogrupo = $this->promover->obtenerAlumnoGrupo($idalumno, $idclicloescolar);
                        $idalumnogrupo = $alumnogrupo->idalumnogrupo;
                        $update = array(
                            'idestatusnivel' => 5,
                            'activo' => 0,
                            'idusuario' => $this->session->user_id,
                            'fecharegistro' => date('Y-m-d H:i:s')
                        );
                        $desactivar = $this->promover->updateAlumnoGrupo($idalumnogrupo, $update);
                    }
                }
            }
        }
    }
    public function calificacionPorUnidad()
    {
        $idalumno = $this->input->post('idalumno');
        $idhorario = $this->input->post('idhorario');
        $idprofesormateria = $this->input->post('idprofesormateria');
        $idplantel = $this->session->idplantel;
        $calificaciones = $this->configuracion->calificacionPorMateriaPS($idalumno, $idhorario, $idprofesormateria, $idplantel);
        $tabla = "";
        $tabla .= '<table class="table  table-hover">
                    <thead class="bg-teal"> 
                    <th>A CALIFICAR</th>';
        $tabla .= '<th>CALIFICACION</th>';
        $tabla .= '</thead>';
        $c = 1;
        if (isset($calificaciones) && !empty($calificaciones)) {

            foreach ($calificaciones as $row) {
                $tabla .= '<tr> 
                <td><strong>' . $row->nombremes . '</strong></td>';
                if (isset($row->calificacion) && !empty($row->calificacion))
                    $tabla .= '<td><strong>' . $row->calificacion . '</strong></td>';
                else
                    $tabla .= '<td><small>No registrado</small></td>';
                $tabla .= '</tr>';
            }
        }
        $tabla .= '</table>';
        echo json_encode(['success' => 'Ok', 'tabla' => $tabla]);
    }
    public function calificaciones()
    {
        $idalumno = $this->input->post('idalumno');
        $idhorario = $this->input->post('idhorario');
        $detalle_horario = $this->horario->detalleHorario($idhorario);

        $idperiodo = $detalle_horario->idperiodo;
        $tabla = "";
        $tabla .= '<table class="table  table-hover">
    <thead class="bg-teal">
      <th>#</th>
      <th>MATERIA</th>';
        $tabla .= '<th>PROMEDIO</th>';
        $tabla .= '<th>U. CALIFICADAS</th>';
        $tabla .= '<th></th>';
        $tabla .= '</thead>';
        $c = 1;
        $datos_calificacion = $this->alumno->spObtenerCalificacion($idalumno, $idhorario, $idperiodo);
        if (isset($datos_calificacion) && !empty($datos_calificacion)) {

            foreach ($datos_calificacion as $row) {
                if ($row->mostrar == 'SI') {
                    $tabla .= '<tr>
                     <td>' . $c++ . '</td>
                     <td><strong>' . $row->nombreclase . '</strong><br><small>( ' . $row->profesor . '</small>)</td>';

                    $idnivelestudio = $row->idnivelestudio;
                    $detalle_configuracion = $this->configuracion->showAllConfiguracion($this->session->idplantel, $idnivelestudio);

                    $calificacion_materia = $row->calificacion;

                    if ($calificacion_materia < $detalle_configuracion[0]->calificacion_minima) {
                        $tabla .= '<td style="color:red;"><strong>' .  numberFormatPrecision($calificacion_materia, 1, '.') . '</strong></td>';
                    } else {
                        $tabla .= '<td  style="color:GREEN;"><strong>' .    numberFormatPrecision($calificacion_materia, 1, '.') . '</strong></td>';
                    }

                    if ($row->unidadesregistradas != 28) {
                        if ($row->unidadesregistradas == $row->totalunidades) {
                            $tabla .= '<td style="color:green;"><strong>Completo</strong></td>';
                        } else {
                            $tabla .= '<td style="color:red;">';
                            $tabla .= '<strong>' . $row->unidadesregistradas . ' de ' . $row->totalunidades . '</strong>';

                            $tabla .= '</td>';
                        }
                    } else {
                        $tabla .= '<td>Completo</td>';
                    }
                    $tabla .= '<td align="right"><a  href="javascript:void(0)" class="ver_unidades btn btn-info"  data-toggle="modal"
                    data-idalumno="' . $row->idalumno . '"
                    data-idhorario="' . $idhorario . '" 
                    data-idprofesormateria="' . $row->idprofesormateria . '" 
                    data-nombreclase="' . $row->nombreclase . '" 
                    title="Ver Calificaciones">Detalle</a></td>';

                    $tabla .= '</tr>';
                }
            }
        }
        $tabla .= '</table>';
        echo json_encode(['success' => 'Ok', 'tabla' => $tabla]);
    }
}
