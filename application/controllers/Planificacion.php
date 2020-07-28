<?php

defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("America/Mexico_City");

class Planificacion extends CI_Controller {

    function __construct() {
        parent::__construct();

        if (!isset($_SESSION['user_id'])) {
            $this->session->set_flashdata('flash_data', 'You don\'t have access! ss');
            return redirect('welcome');
        }
        $this->load->helper('url');
        $this->load->model('data_model');
        $this->load->model('Planificacion_model', 'planificacion');
        $this->load->model('Horario_model', 'horario');
        $this->load->model('Grupo_model', 'grupo');
        $this->load->library('permission');
        $this->load->library('session');
    }
    function administrar() {
           $this->load->view('admin/header');
        $this->load->view('admin/catalogo/planificacion/index');
        $this->load->view('admin/footer');
    }
    public function showAll() {
      
        $idusuario = $this->session->user_id;
        $query = $this->planificacion->showAll($idusuario);
        //var_dump($query);
        if ($query) {
            $result['planificaciones'] = $this->planificacion->showAll($idusuario);
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

        public function showAllAdmin() {
          $idplantel = $this->session->idplantel; 
        $query = $this->planificacion->showAll('',$idplantel);
        //var_dump($query);
        if ($query) {
            $result['planificaciones'] = $this->planificacion->showAll('',$idplantel);
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function showAllGrupos() {
      
        $idprofesor = $this->session->idprofesor;
        $query = $this->grupo->showAllGruposProfesor($idprofesor);
        //var_dump($query);
        if ($query) {
            $result['grupos'] = $this->grupo->showAllGruposProfesor($idprofesor);
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function searchPlanificacion() {
        $value = $this->input->post('text');
        $idusuario = $this->session->user_id;
        $query = $this->planificacion->searchPlanificacion($value, $idusuario);
        if ($query) {
            $result['planificaciones'] = $query;
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }
    
    public function searchPlanificacionAdmin() {
        $value = $this->input->post('text');
        $idplantel = $this->session->idplantel;
        $query = $this->planificacion->searchPlanificacion($value, '',$idplantel);
        if ($query) {
            $result['planificaciones'] = $query;
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function addPlanificacion() {
        $config = array(
            array(
                'field' => 'idprofesor',
                'label' => 'Profesor',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),
            array(
                'field' => 'bloque',
                'label' => 'Nombre',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),
            array(
                'field' => 'fechaejecucion',
                'label' => 'Nombre',
                'rules' => 'trim|required|callback_validarFecha',
                'errors' => array(
                    'required' => 'Campo obligatorio.',
                )
            )
            ,
            array(
                'field' => 'practicasociallenguaje',
                'label' => 'Nombre',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.',
                )
            )
            ,
            array(
                'field' => 'enfoque',
                'label' => 'Nombre',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.',
                )
            )
            ,
            array(
                'field' => 'ambito',
                'label' => 'Nombre',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.',
                )
            )
            ,
            array(
                'field' => 'competenciafavorece',
                'label' => 'Nombre',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.',
                )
            )
            ,
            array(
                'field' => 'aprendizajeesperado',
                'label' => 'Nombre',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.',
                )
            )
            ,
            array(
                'field' => 'propositodelproyecto',
                'label' => 'Nombre',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.',
                )
            )
            ,
            array(
                'field' => 'produccionesdesarrolloproyecto',
                'label' => 'Nombre',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.',
                )
            )
            ,
            array(
                'field' => 'recursosdidacticos',
                'label' => 'Nombre',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.',
                )
            ),
            array(
                'field' => 'indicadoresevaluacion',
                'label' => 'Nombre',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.',
                )
            )
        );

        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            $result['error'] = true;
            $result['msg'] = array(
                'idprofesor' => form_error('idprofesor'),
                'bloque' => form_error('bloque'),
                'fechaejecucion' => form_error('fechaejecucion'),
                'practicasociallenguaje' => form_error('practicasociallenguaje'),
                'enfoque' => form_error('enfoque'),
                'ambito' => form_error('ambito'),
                'competenciafavorece' => form_error('competenciafavorece'),
                'aprendizajeesperado' => form_error('aprendizajeesperado'),
                'propositodelproyecto' => form_error('propositodelproyecto'),
                'produccionesdesarrolloproyecto' => form_error('produccionesdesarrolloproyecto'),
                'recursosdidacticos' => form_error('recursosdidacticos'),
                'indicadoresevaluacion' => form_error('indicadoresevaluacion'),
            );
        } else {
            $idplantel = $this->session->idplantel;
            $idhorariodetalle = $this->input->post('idprofesor');
            $detalle_horario = $this->horario->detalleHorarioDetalle($idhorariodetalle);
            if ($detalle_horario) {
                $idperiodo = $detalle_horario[0]->idperiodo;
                $idprofesormateria = $detalle_horario[0]->idprofesormateria;
                $idgrupo = $detalle_horario[0]->idgrupo;
                $bloque = $this->input->post('bloque');
               // $fechaejecucion = date('Y-m-d', strtotime($this->input->post('fechaejecucion')));
                $var = $this->input->post('fechaejecucion');
                $date = str_replace('/', '-', $var);
                $fechaejecucion = date('Y-m-d', strtotime($date));
                $practicasociallenguaje = $this->input->post('practicasociallenguaje');
                $enfoque = $this->input->post('enfoque');
                $ambito = $this->input->post('ambito');
                $competenciafavorece = $this->input->post('competenciafavorece');
                $aprendizajeesperado = $this->input->post('aprendizajeesperado');
                $propositodelproyecto = $this->input->post('propositodelproyecto');
                $produccionesdesarrolloproyecto = $this->input->post('produccionesdesarrolloproyecto');
                $recursosdidacticos = $this->input->post('recursosdidacticos');
                $indicadoresevaluacion = $this->input->post('indicadoresevaluacion');
                $observacionesdocente = $this->input->post('observacionesdocente');
                $data = array(
                    'idhorariodetalle' => $idhorariodetalle,
                    'idperiodo' => $idperiodo,
                    'idprofesor' => $idprofesormateria,
                    'idgrupo' => $idgrupo,
                    'bloque' => $bloque,
                    'fechaejecucion' => $fechaejecucion,
                    'practicasociallenguaje' => $practicasociallenguaje,
                    'enfoque' => $enfoque,
                    'ambito ' => $ambito,
                    'competenciafavorece' => $competenciafavorece,
                    'tipotext' => '',
                    'aprendizajeesperado' => $aprendizajeesperado,
                    'propositodelproyecto ' => $propositodelproyecto,
                    'produccionesdesarrolloproyecto' => $produccionesdesarrolloproyecto,
                    'recursosdidacticos' => $recursosdidacticos,
                    'indicadoresevaluacion' => $indicadoresevaluacion,
                    'observacionesdocente' => $observacionesdocente,
                    'observacionescoordinador' => '',
                    'eliminado' => 0,
                    'idusuario' => $this->session->user_id,
                    'fecharegistro' => date('Y-m-d H:i:s')
                );
                $this->planificacion->addPlanificacion($data);
            } else {
                
            }
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function editPlanificacion() {
        $config = array(
            array(
                'field' => 'idhorariodetalle',
                'label' => 'Profesor',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),
            array(
                'field' => 'bloque',
                'label' => 'Nombre',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),
            array(
                'field' => 'fechaejecucion',
                'label' => 'Nombre',
                'rules' => 'trim|required|callback_validarFecha',
                'errors' => array(
                    'required' => 'Campo obligatorio.',
                )
            )
            ,
            array(
                'field' => 'practicasociallenguaje',
                'label' => 'Nombre',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.',
                )
            )
            ,
            array(
                'field' => 'enfoque',
                'label' => 'Nombre',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.',
                )
            )
            ,
            array(
                'field' => 'ambito',
                'label' => 'Nombre',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.',
                )
            )
            ,
            array(
                'field' => 'competenciafavorece',
                'label' => 'Nombre',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.',
                )
            )
            ,
            array(
                'field' => 'aprendizajeesperado',
                'label' => 'Nombre',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.',
                )
            )
            ,
            array(
                'field' => 'propositodelproyecto',
                'label' => 'Nombre',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.',
                )
            )
            ,
            array(
                'field' => 'produccionesdesarrolloproyecto',
                'label' => 'Nombre',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.',
                )
            )
            ,
            array(
                'field' => 'recursosdidacticos',
                'label' => 'Nombre',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.',
                )
            ),
            array(
                'field' => 'indicadoresevaluacion',
                'label' => 'Nombre',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.',
                )
            )
        );

        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            $result['error'] = true;
            $result['msg'] = array(
                'idhorariodetalle' => form_error('idhorariodetalle'),
                'bloque' => form_error('bloque'),
                'fechaejecucion' => form_error('fechaejecucion'),
                'practicasociallenguaje' => form_error('practicasociallenguaje'),
                'enfoque' => form_error('enfoque'),
                'ambito' => form_error('ambito'),
                'competenciafavorece' => form_error('competenciafavorece'),
                'aprendizajeesperado' => form_error('aprendizajeesperado'),
                'propositodelproyecto' => form_error('propositodelproyecto'),
                'produccionesdesarrolloproyecto' => form_error('produccionesdesarrolloproyecto'),
                'recursosdidacticos' => form_error('recursosdidacticos'),
                'indicadoresevaluacion' => form_error('indicadoresevaluacion'),
            );
        } else {
            $idplantel = $this->session->idplantel;
            $idhorariodetalle = $this->input->post('idhorariodetalle');
            $idplanificacion = $this->input->post('idplanificacion');
            $detalle_horario = $this->horario->detalleHorarioDetalle($idhorariodetalle);
            if ($detalle_horario) {
                $idperiodo = $detalle_horario[0]->idperiodo;
                $idprofesormateria = $detalle_horario[0]->idprofesormateria;
                $idgrupo = $detalle_horario[0]->idgrupo;
                $bloque = $this->input->post('bloque');
                $fechaejecucion = date('Y-m-d', strtotime($this->input->post('fechaejecucion')));
                $practicasociallenguaje = $this->input->post('practicasociallenguaje');
                $enfoque = $this->input->post('enfoque');
                $ambito = $this->input->post('ambito');
                $competenciafavorece = $this->input->post('competenciafavorece');
                $aprendizajeesperado = $this->input->post('aprendizajeesperado');
                $propositodelproyecto = $this->input->post('propositodelproyecto');
                $produccionesdesarrolloproyecto = $this->input->post('produccionesdesarrolloproyecto');
                $recursosdidacticos = $this->input->post('recursosdidacticos');
                $indicadoresevaluacion = $this->input->post('indicadoresevaluacion');
                $observacionesdocente = $this->input->post('observacionesdocente');
                $data = array(
                    'idhorariodetalle' => $idhorariodetalle,
                    'idperiodo' => $idperiodo,
                    'idprofesor' => $idprofesormateria,
                    'idgrupo' => $idgrupo,
                    'bloque' => $bloque,
                    'fechaejecucion' => $fechaejecucion,
                    'practicasociallenguaje' => $practicasociallenguaje,
                    'enfoque' => $enfoque,
                    'ambito ' => $ambito,
                    'competenciafavorece' => $competenciafavorece,
                    'tipotext' => '',
                    'aprendizajeesperado' => $aprendizajeesperado,
                    'propositodelproyecto ' => $propositodelproyecto,
                    'produccionesdesarrolloproyecto' => $produccionesdesarrolloproyecto,
                    'recursosdidacticos' => $recursosdidacticos,
                    'indicadoresevaluacion' => $indicadoresevaluacion,
                    'observacionesdocente' => $observacionesdocente,
                    'observacionescoordinador' => '',
                    'idusuario' => $this->session->user_id,
                    'fecharegistro' => date('Y-m-d H:i:s')
                );
                $this->planificacion->updatePlanificacion($idplanificacion, $data);
            } else {
                
            }
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }
        public function observacionPlanificacion() { 
            $idplantel = $this->session->idplantel; 
            $idplanificacion = $this->input->post('idplanificacion'); 
                 $observacionescoordinador = $this->input->post('observacionescoordinador');
                $data = array( 
                    'observacionescoordinador' => $observacionescoordinador
                );
                $this->planificacion->updatePlanificacion($idplanificacion, $data);
         
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    function validarFecha($fecha) {
        $parts = explode("/", $fecha);
        if (count($parts) == 3) {
            if (checkdate($parts[1], $parts[0], $parts[2])) {
                return true;
            } else {
                $this->form_validation->set_message(
                        'validarFecha',
                        'Formato no valido.'
                );
                return false;
            }
        } else {
            $this->form_validation->set_message(
                    'validarFecha',
                    'Formato no valido.'
            );
            return false;
        }
    }

    public function deletePlanificacion() {
        # code...
//        if (Permission::grantValidar(uri_string()) == 1) {
        $id = $this->input->get('id');
        $data = array(
            'eliminado' => 1
        );
        $query = $this->planificacion->updatePlanificacion($id, $data);
        if ($query) {
            $result['error'] = false;
        } else {
            $result['error'] = true;
            $result['msg'] = array(
                'msgerror' => 'No se puede Elimnar registro.'
            );
        }
//        } else {
//            $result['error'] = true;
//            $result['msg'] = array(
//                'msgerror' => 'NO TIENE PERMISO PARA REALIZAR ESTA ACCIÓN.'
//            );
//        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    } 
}
