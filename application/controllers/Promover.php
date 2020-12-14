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
        $data = array(
            'cicloescolar' => $cicloescolar_activo,
            'grupos' => $this->alumno->showAllGrupos($this->session->idplantel),
        );
        $this->load->view('admin/header');
        $this->load->view('admin/promover/index', $data);
        $this->load->view('admin/footer');
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
            $alumnos = $this->alumno->listaAlumnoPorGrupo($idgrupo, $this->session->idplantel);
            $tabla = '';
            if (isset($alumnos) && !empty($alumnos)) {
                $tabla .= ' <table class="table table-striped">
                    <thead class="bg-teal">
                      <tr> 
                        <th>#</th>
                        <th></th>
                        <th>Alumno</th>
                        <th>Promedio</th>
                        <th>Estatus</th>
                        <th>Unidades</th>
                        <th align="center">M. Reprobadas</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody> ';
                $contador = 1;
                foreach ($alumnos as $value) {
                    $datos_calificacion = $this->promover->calificacionAlumnoParaPromover($value->idalumno, $idgrupo, $value->idhorario);

                    $tabla .= '<tr>';
                    $tabla .= '<td>' . $contador++ . '</td>';
                    $tabla .= '<td>';
                    if ($value->opcion == 1) {
                        $tabla .= '<label  style="color:red;">R</label>';
                    } else {
                        $tabla .= '<label style="color:green;">N</label>';
                    }
                    $tabla .= '</td>';
                    $tabla .= '<td>' . $value->apellidop . ' ' . $value->apellidom . ' ' . $value->nombre . '</td>';
                    $tabla .= '<td>';
                    if (isset($datos_calificacion) && !empty($datos_calificacion)) {
                        $idmateria = 0;
                        $calificacion_materia = 0;
                        $contador_materia = 0;
                        $idhorario = 0;
                        $total_materia_reprobada = 0;
                        $maximo_reprobados = 0;
                        $calificacion_minima = 0;
                        foreach ($datos_calificacion as $row) {
                            $idnivelestudio = $this->session->idnivelestudio;
                            $detalle_configuracion = $this->configuracion->showAllConfiguracion($this->session->idplantel, $idnivelestudio);

                            if ($idmateria != $row->idmateria) {
                                $idmateria = $row->idmateria;
                                $idhorario = $row->idhorario;
                                $contador_materia++;
                                $calificacion_materia = $calificacion_materia + $row->calificacion;
                                $maximo_reprobados = $detalle_configuracion[0]->reprovandas_minima;
                                $calificacion_minima = $detalle_configuracion[0]->calificacion_minima;
                                if ($calificacion_materia < $detalle_configuracion[0]->calificacion_minima) {
                                    $total_materia_reprobada++;
                                }
                            }
                        }

                        $promedio = number_format(($calificacion_materia / $contador_materia), 2);
                        if ($promedio < $calificacion_minima) {
                            $tabla .= '<label  style="color:red;">' . $promedio . '</label>';
                        } else {
                            $tabla .= '<label style="color:green;">' . $promedio . '</label>';
                        }

                        $tabla .= '</td>';
                        $tabla .= '<td>';
                        if ($promedio < $calificacion_minima || $total_materia_reprobada > $maximo_reprobados) {
                            $tabla .= '<label style="color:red;">REPROBADO</label>';
                        } else {
                            $tabla .= '<label style="color:green;" >APROBADO</label>';
                        }
                        $tabla .= '</td>';
                        $tabla .= '<td>';
                        $tabla .= '<label>0</label>';
                        $tabla .= '</td>';
                        $tabla .= '<td align="center">';
                        $tabla .= '<label>' . $total_materia_reprobada . '</label>';
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

    public function calificaciones()
    {
        $idalumno = $this->input->post('idalumno');
        $idhorario = $this->input->post('idhorario');
        $detalle_horario = $this->horario->detalleHorario($idhorario);
        $idgrupo = $detalle_horario->idgrupo;
        $tabla = "";
        $tabla .= '<table class="table  table-hover">
    <thead class="bg-teal">
      <th>#</th>
      <th>MATERIA</th>';
        $tabla .= '<th>CALIFICACIÓN</th>';
        $tabla .= '</thead>';
        $c = 1;
        $datos_calificacion = $this->alumno->calificacionAlumnoParaPromover($idalumno, $idgrupo, $idhorario);
        if (isset($datos_calificacion) && !empty($datos_calificacion)) {
            //$suma_calificacion = 0;
            foreach ($datos_calificacion as $row) {
                //$alumn = $al->getAlumn();

                $tabla .= '<tr>
                     <td>' . $c++ . '</td>
                     <td><strong>' . $row->nombreclase . '</strong><br><small>( ' . $row->nombre . ' ' . $row->apellidop . ' ' . $row->apellidom . '</small>)</td>';
                $idmateria = 0;
                $calificacion_materia = 0;
                $idhorario = 0;
                $idnivelestudio = $row->idnivelestudio;
                $detalle_configuracion = $this->configuracion->showAllConfiguracion($this->session->idplantel, $idnivelestudio);

                if ($idmateria == 0) {
                    $idmateria = $row->idmateria;
                    $calificacion_materia += $row->calificacion;

                    if ($calificacion_materia < $detalle_configuracion[0]->calificacion_minima) {
                        $tabla .= '<td style="color:red;">' . number_format($calificacion_materia, 2) . '</td>';
                    } else {
                        $tabla .= '<td  style="color:GREEN;">' .  number_format($calificacion_materia, 2) . '</td>';
                    }
                }

                $tabla .= '</tr>';
            }
        }
        $tabla .= '</table>';
        // return $tabla;
        echo json_encode(['success' => 'Ok', 'tabla' => $tabla]);
    }
}
