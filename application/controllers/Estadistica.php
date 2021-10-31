<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("America/Mexico_City");
class Estadistica extends CI_Controller
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
        // Permission::grant(uri_string());
        // Permission::grant(uri_string());
        $cicloescolar_activo = $this->cicloescolar->showAllCicloEscolar($this->session->idplantel);
        $cicloescolar_inactivo = $this->cicloescolar->showAllCicloEscolarDesActivo($this->session->idplantel);
        $data = array(
            'cicloescolar' => $cicloescolar_activo,
            'grupos' => $this->grupo->showAllGrupos($this->session->idplantel),
        );
        $this->load->view('admin/header');
        $this->load->view('admin/catalogo/estadistica/index', $data);
        $this->load->view('admin/footer');
    }
    public function buscar()
    {
        $idperiodo = $this->input->get('periodo');
        $idgrupo = $this->input->get('grupo');
        $tipografica = $this->input->get('tipografica');
        $alumnos = $this->alumno->spObtenerAlumnosGrupo($idperiodo, $idgrupo);

        $usersList_array = array();
        $user_array = array();
        $note_array = array();
        $tabla = '';
        if (isset($alumnos) && !empty($alumnos)) {

            $contador = 1;

            foreach ($alumnos as $value) {
                //if ($value->activoalumno == 1 && $value->idhorario != '') {
                //  $datos_calificacion = $this->promover->calificacionAlumnoParaPromover($value->idalumno, $idgrupo, $value->idhorario);
                $idalumno = $value->idalumno;
                $idhorario  = $value->idhorario;
                $calificacion_materias  = $this->alumno->spObtenerCalificacion($idalumno, $idhorario, $idperiodo);
                // $user_array["numero"] = $contador++;
                $user_array["alumno"] =   $contador++ . '.- ' . $value->nombre;

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


                    $user_array["calificacion"] = eliminarDecimalCero(numberFormatPrecision($promedio, 1, '.'));
                } else {
                    $user_array["calificacion"] = 0;
                }
                // }
                array_push($usersList_array, $user_array);
                //}
            }
        }
        //var_dump($usersList_array);
        $cicloescolar_activo = $this->cicloescolar->showAllCicloEscolar($this->session->idplantel);
        //$cicloescolar_inactivo = $this->cicloescolar->showAllCicloEscolarDesActivo($this->session->idplantel);
        $data = array(
            'cicloescolar' => $cicloescolar_activo,
            'grupos' => $this->grupo->showAllGrupos($this->session->idplantel),
            'datosgraficagrupo' => $usersList_array,
            'tipografica' => $tipografica,
            'alumnos' => $alumnos
        );
        $this->load->view('admin/header');
        $this->load->view('admin/catalogo/estadistica/resultado', $data);
        $this->load->view('admin/footer');
    }

    public function calificacionPorAlumno()
    {
        $idperiodo = $this->input->post('idperiodo');
        $idhorario = $this->input->post('idhorario');
        $idalumno = $this->input->post('idalumno');
        $calificacion_materias  = $this->alumno->spObtenerCalificacion($idalumno, $idhorario, $idperiodo);

        $nombreClaseList_array = array();
        $clase_array = array();
        $calificacionList_array = array();
        $calificacion_array = array();
        if (isset($calificacion_materias) && !empty($calificacion_materias)) {
            foreach ($calificacion_materias as $value1) {
                if ($value1->mostrar == 'SI') {
                    // $clase_array["clase"] = $value1->nombreclase;
                    // $clase_array[$value1->nombreclase];
                    array_push($nombreClaseList_array, $value1->nombreclase);
                }
            }
        }
        if (isset($calificacion_materias) && !empty($calificacion_materias)) {
            foreach ($calificacion_materias as $value2) {
                if ($value2->mostrar == 'SI') {
                    //  $calificacion_array["calificacion"] = $value2->calificacion;
                    // $calificacion_array[$value2->calificacion];
                    array_push($calificacionList_array, $value2->calificacion);
                }
            }
        }
        $respuesta = [
            'nombreclase' =>  $nombreClaseList_array,
            'calificacion' =>  $calificacionList_array
        ];
        echo json_encode($respuesta);
    }
}
