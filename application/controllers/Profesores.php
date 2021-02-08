<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("America/Mexico_City");
class Profesores extends CI_Controller
{
        function __construct()
        {
                parent::__construct();

                if (!isset($_SESSION['user_id'])) {
                        $this->session->set_flashdata('flash_data', 'You don\'t have access! ss');
                        return redirect('welcome');
                }
                $this->load->helper('url');
                $this->load->model('data_model');
                $this->load->model('profesor_model', 'profesor');
                $this->load->model('UnidadExamen_model', 'unidad');
                $this->load->model('Calificacion_model', 'calificacion');
                $this->load->model('Alumno_model', 'alumno');
                $this->load->model('grupo_model', 'grupo');
                $this->load->library('permission');
                $this->load->library('session');
        }

        public function index()
        {
                Permission::grant(uri_string());
                // var_dump($this->session->notificaciones_calificaciones);
                $fecha_actual = date('Y-m-d');
                $idprofesor = $this->session->idprofesor;
                $datos = $this->profesor->showTareas($idprofesor, $fecha_actual);
                $planeaciones = $this->profesor->showPlaneaciones($idprofesor, $fecha_actual);

                $data = array('tareas' => $datos, 'planeaciones' => $planeaciones);
                $this->load->view('docente/header');
                $this->load->view('docente/index', $data);
                $this->load->view('docente/footer');
        }
        public function todasNotificaciones()
        {
                $data = array(
                        'notificaciones' => $this->notificaciones()
                );
                $this->load->view('docente/header');
                $this->load->view('docente/notificaciones/index', $data);
                $this->load->view('docente/footer');
        }
        public function notificaciones()
        {
                $nofiticaciones = array();
                $alumnos = array();
                $idplantel = $this->session->idplantel;

                $result = $this->grupo->showAllGruposProfesor($this->session->idprofesor);

                foreach ($result as $row) {
                        $idhorariodetalle = $row->idhorariodetalle;
                        $idhorario = $row->idhorario;
                        $detalle_horario = $this->grupo->detalleHorarioDetalle($idhorariodetalle);
                        $idprofesormateria = $detalle_horario->idprofesormateria;
                        $idmateria = $detalle_horario->idmateria;
                        $estatus_alumno = $detalle_horario->activo;
                        $unidades_materias = $detalle_horario->unidades;
                        $nombreclase = $detalle_horario->nombreclase;
                        //$idperiodo = $detalle_horario->idperiodo;
                        $idclasificacionmateria = $detalle_horario->idclasificacionmateria;
                        if ($idclasificacionmateria == 3) {
                                $alumns = $this->grupo->alumnosGrupoTaller($idhorario, $idprofesormateria, $idmateria, $estatus_alumno);
                        } else {
                                $alumns = $this->grupo->alumnosGrupo($idhorario, $idprofesormateria, $idmateria, $estatus_alumno);
                        }

                        if (isset($alumns) && !empty($alumns)) {
                                foreach ($alumns  as $alumno) {
                                        $idalumno = $alumno->idalumno;
                                        $nombrealumno = $alumno->nombre . ' ' . $alumno->apellidop . ' ' . $alumno->apellidom;
                                        $detalle_alumno = $this->alumno->detalleAlumno($idalumno);
                                        $idplantel_alumno = $detalle_alumno->idplantel;
                                        $unidades = $this->unidad->showAll($idplantel_alumno);
                                        switch ($this->session->idniveleducativo) {
                                                case 1:
                                                        $mesesprimaria = $this->unidad->mesesUnidadPorPlantel($idplantel_alumno);
                                                        if (isset($mesesprimaria) && !empty($mesesprimaria)) {
                                                                foreach ($mesesprimaria as $value) {
                                                                        $idmes = $value->idmes;
                                                                        $nombreunidad  = $value->nombremes;
                                                                        $fechainicio = $value->fechainicio;
                                                                        $fechafin = $value->fechafin;
                                                                        if ($fechainicio != '0000-00-00' && $fechafin != '0000-00-00') {
                                                                                $respuesta =  $this->fechasCaducas($fechainicio, $fechafin, $idalumno, $idhorario, $idmes, $idprofesormateria, 1);
                                                                                if ($respuesta == 0) {
                                                                                        $alumnos["nombre"] = $nombrealumno;
                                                                                        $alumnos["nombreclase"] = $nombreclase;
                                                                                        $alumnos["nombreunidad"] = $nombreunidad;
                                                                                        $alumnos["fechalimite"] = "Lecha limite para registrar la calificación fue: " . $value->fechafinshow;
                                                                                        array_push($nofiticaciones, $alumnos);
                                                                                } elseif ($respuesta == 1) {
                                                                                        $alumnos["nombre"] = $nombrealumno;
                                                                                        $alumnos["nombreclase"] = $nombreclase;
                                                                                        $alumnos["nombreunidad"] = $nombreunidad;
                                                                                        $alumnos["fechalimite"] = "Tiene hasta el dia de hoy para subir su calificación.";
                                                                                        array_push($nofiticaciones, $alumnos);
                                                                                } else {
                                                                                }
                                                                        }
                                                                }
                                                        }
                                                        # PRIMARIA
                                                        break;
                                                case 2:
                                                        # SECUNDARIO
                                                        $mesessecundaria = $this->unidad->mesesUnidadPorPlantel($idplantel_alumno);
                                                        if (isset($mesessecundaria) && !empty($mesessecundaria)) {
                                                                foreach ($mesessecundaria as $value) {
                                                                        $idmes = $value->idmes;
                                                                        $nombreunidad  = $value->nombremes;
                                                                        $fechainicio = $value->fechainicio;
                                                                        $fechafin = $value->fechafin;
                                                                        if ($fechainicio != '0000-00-00' && $fechafin != '0000-00-00') {
                                                                                $respuesta =  $this->fechasCaducas($fechainicio, $fechafin, $idalumno, $idhorario, $idmes, $idprofesormateria, 1);
                                                                                if ($respuesta == 0) {
                                                                                        $alumnos["nombre"] = $nombrealumno;
                                                                                        $alumnos["nombreclase"] = $nombreclase;
                                                                                        $alumnos["nombreunidad"] = $nombreunidad;
                                                                                        $alumnos["fechalimite"] = "Lecha limite para registrar la calificación fue: " . $value->fechafinshow;
                                                                                        array_push($nofiticaciones, $alumnos);
                                                                                } elseif ($respuesta == 1) {
                                                                                        $alumnos["nombre"] = $nombrealumno;
                                                                                        $alumnos["nombreclase"] = $nombreclase;
                                                                                        $alumnos["nombreunidad"] = $nombreunidad;
                                                                                        $alumnos["fechalimite"] = "Tiene hasta el dia de hoy para subir su calificación.";
                                                                                        array_push($nofiticaciones, $alumnos);
                                                                                } else {
                                                                                }
                                                                        }
                                                                }
                                                        }
                                                        break;
                                                case 3:
                                                        # MEDIO SUPERIOR
                                                        if (isset($unidades) && !empty($unidades)) {
                                                                foreach ($unidades as  $value) {
                                                                        $idunidad = $value->idunidad;
                                                                        $nombreunidad  = $value->nombreunidad;
                                                                        $fechainicio = $value->fechainicio;
                                                                        $fechafin = $value->fechafin;
                                                                        if ($fechainicio != '0000-00-00' && $fechafin != '0000-00-00') {
                                                                                $respuesta =  $this->fechasCaducas($fechainicio, $fechafin, $idalumno, $idhorario, $idunidad, $idprofesormateria, 0);
                                                                                if ($respuesta == 0) {
                                                                                        $alumnos["nombre"] = $nombrealumno;
                                                                                        $alumnos["nombreclase"] = $nombreclase;
                                                                                        $alumnos["nombreunidad"] = $nombreunidad;
                                                                                        $alumnos["fechalimite"] = "Lecha limite para registrar la calificación fue: " . $value->fechafinshow;
                                                                                        array_push($nofiticaciones, $alumnos);
                                                                                } elseif ($respuesta == 1) {
                                                                                        $alumnos["nombre"] = $nombrealumno;
                                                                                        $alumnos["nombreclase"] = $nombreclase;
                                                                                        $alumnos["nombreunidad"] = $nombreunidad;
                                                                                        $alumnos["fechalimite"] = "Tiene hasta el dia de hoy para subir su calificación.";
                                                                                        array_push($nofiticaciones, $alumnos);
                                                                                } else {
                                                                                }
                                                                        }
                                                                }
                                                        }
                                                        break;
                                                case 5:
                                                        # LICENCIATURA
                                                        if (isset($unidades) && !empty($unidades)) {
                                                                foreach ($unidades as  $value) {
                                                                        $idunidad = $value->idunidad;
                                                                        $nombreunidad  = $value->nombreunidad;
                                                                        $fechainicio = $value->fechainicio;
                                                                        $fechafin = $value->fechafin;
                                                                        if ($fechainicio != '0000-00-00' && $fechafin != '0000-00-00') {
                                                                                $respuesta =  $this->fechasCaducas($fechainicio, $fechafin, $idalumno, $idhorario, $idunidad, $idprofesormateria, 0);
                                                                                if ($respuesta == 0) {
                                                                                        $alumnos["nombre"] = $nombrealumno;
                                                                                        $alumnos["nombreclase"] = $nombreclase;
                                                                                        $alumnos["nombreunidad"] = $nombreunidad;
                                                                                        $alumnos["fechalimite"] = "Lecha limite para registrar la calificación fue: " . $value->fechafinshow;
                                                                                        array_push($nofiticaciones, $alumnos);
                                                                                } elseif ($respuesta == 1) {
                                                                                        $alumnos["nombre"] = $nombrealumno;
                                                                                        $alumnos["nombreclase"] = $nombreclase;
                                                                                        $alumnos["nombreunidad"] = $nombreunidad;
                                                                                        $alumnos["fechalimite"] = "Tiene hasta el dia de hoy para subir su calificación.";
                                                                                        array_push($nofiticaciones, $alumnos);
                                                                                } else {
                                                                                }
                                                                        }
                                                                }
                                                        }

                                                        break;

                                                default:
                                                        # code...
                                                        break;
                                        }

                                        /*$materias = $this->grupo->obtenerMateriasAlumno($idalumno, $idperiodo);
                                        if (isset($materias) && !empty($materias)) {
                                                foreach ($materias as $materia) {
                                                        $idprofesormateria = 
                                                }
                                        }*/
                                }
                        }
                }
                return  $nofiticaciones;
        }
        public function fechasCaducas($fechainicio, $fechafin, $idalumno, $idhorario, $idunidad, $idprofesormateria, $opcion)
        {
                try {
                        $fechaSistema = new \DateTime();
                        $diaInicial = new \DateTime($fechainicio);
                        $diaEntrega = new \DateTime($fechafin);
                        $interval_now = $fechaSistema->diff($diaEntrega);
                        $interval_inicial = $diaInicial->diff($diaEntrega);
                        $dias_restantes = $interval_now->format('%R%a');
                        $total_dias = $interval_inicial->format('%R%a');
                        if ($dias_restantes < 0) {
                                if ($opcion == 0) {
                                        //MEDIO SUPERIORO Y LICENCIATURA
                                        $validar_calificacion =  $this->calificacion->validarCalificacionRegistrada($idalumno, $idhorario, $idprofesormateria, $idunidad);
                                        if (!$validar_calificacion) {
                                                return 0;
                                        } else {
                                                return 2;
                                        }
                                }
                                if ($opcion == 1) {
                                        //PRIMARIA Y SECUNDARIA
                                        $validar_calificacion_mes = $this->calificacion->validarCalificacionRegistradaMeses($idalumno, $idhorario, $idprofesormateria, $idunidad);
                                        if (!$validar_calificacion_mes) {
                                                return 0;
                                        } else {
                                                return 2;
                                        }
                                }
                        } elseif ($dias_restantes == 0) {
                                return 1;
                        } else {
                                return 2;
                        }
                } catch (\Exception $th) {
                        //throw $th;
                }
        }
}
