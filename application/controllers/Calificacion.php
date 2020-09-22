<?php

defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("America/Mexico_City");

class Calificacion extends CI_Controller {

    function __construct() {
        parent::__construct();

        if (!isset($_SESSION['user_id'])) {
            $this->session->set_flashdata('flash_data', 'You don\'t have access! ss');
            return redirect('welcome');
        }
        $this->load->helper('url');
        $this->load->model('data_model');
        $this->load->model('calificacion_model', 'calificacion');
        $this->load->model('cicloescolar_model', 'cicloescolar');
        $this->load->model('horario_model', 'horario');
        $this->load->model('configuracion_model', 'configuracion');
        $this->load->model('alumno_model', 'alumno');
        $this->load->model('grupo_model', 'grupo');
        $this->load->library('permission');
        $this->load->library('session');
    }

    public function inicio() {
        $idplantel = $this->session->idplantel; 
        $unidades = $this->calificacion->unidades($idplantel);
        $oportunidades  = $this->calificacion->oportunidades($idplantel);
        $data = array(
            'periodos'=> $this->cicloescolar->showAll($idplantel),
            'grupos'=> $this->grupo->showAllGrupos($idplantel),
            'unidades'=>$unidades,
            'oportunidades'=>$oportunidades
        );
        $this->load->view('admin/header');
        if((isset($this->session->idniveleducativo) && !empty($this->session->idniveleducativo)) && ($this->session->idniveleducativo == 4)){
            $this->load->view('admin/catalogo/calificaciones/preescolar',$data);
        }else{
            $this->load->view('admin/catalogo/calificaciones/index',$data);
        }
        
        $this->load->view('admin/footer');
    }
    public function asistencia() {
        $idplantel = $this->session->idplantel;
        $data = array(
            'periodos'=> $this->cicloescolar->showAll($idplantel),
            'grupos'=> $this->grupo->showAllGrupos($idplantel),
            'motivos'=>$this->calificacion->motivoAsistencia()
        );
        $this->load->view('admin/header');
        $this->load->view('admin/catalogo/asistencias/index',$data);
        $this->load->view('admin/footer');
    }
    public function buscarCursos(){
        $idgrupo = $this->input->post('idgrupo');
        $idperiodo = $this->input->post('idperiodo');
       
        $array = $this->calificacion->cursosHorario($idperiodo,$idgrupo);
        
        $select = ""; 
        if (isset($array) && !empty($array)) {
            foreach ($array as $value) { 
                $select .= '<option value="' . $value->idprofesormateria . '">' . strtoupper($value->nombreclase) . '</option>';
            }
        }
        
        echo $select;
    }

    public function buscar() {  
        $cicloescolar = $this->input->post('cicloescolar');
        $grupo = $this->input->post('grupo');
        $tiporeporte = $this->input->post('tiporeporte'); 
        redirect('Calificacion/buscarCalificaciones/'.$cicloescolar.'/'.$grupo.'/'.$tiporeporte);
    }
    public function buscarA(){
        $cicloescolar = $this->input->post('cicloescolar');
        $grupo = $this->input->post('grupo');
        $curso = $this->input->post('curso'); 
        $tiporeporte = $this->input->post('tiporeporte'); 
        $fechainicio = $this->input->post('fechainicio'); 
        $fechafin = $this->input->post('fechafin'); 
        redirect('Calificacion/buscarAsistencia/'.$cicloescolar.'/'.$grupo.'/'.$curso.'/'.$tiporeporte.'/'.$fechainicio.'/'.$fechafin);
        
    }
    public function buscarAsistencia($idperiodo = '',$idgrupo = '',$idcurso='',$tiporeporte='',$fechainicio='',$fechafin = ''){
        if((isset($idperiodo) && !empty($idperiodo)) 
            && (isset($idgrupo) && !empty($idgrupo)) 
            && (isset($idcurso) && !empty($idcurso))
            && (isset($tiporeporte) && !empty($tiporeporte))
            && (isset($fechainicio) && !empty($fechainicio)) 
            && (isset($fechafin) && !empty($fechafin))){
                $idplantel = $this->session->idplantel;
                $tabla = $this->obtenerAsistencia($idperiodo,$idgrupo,$idcurso,$tiporeporte,$fechainicio,$fechafin);
              
                $data = array(
                    'periodos'=> $this->cicloescolar->showAll($idplantel),
                    'grupos'=> $this->grupo->showAllGrupos($idplantel),
                    'motivos'=>$this->calificacion->motivoAsistencia(),
                    'tabla'=>$tabla
                );
                $this->load->view('admin/header');
                $this->load->view('admin/catalogo/asistencias/resultado', $data);
                $this->load->view('admin/footer');
        } 
    }
    public function buscarCalificaciones($idclicloescolar = '',$idgrupo = '',$tiporeporte = ''){
        $idplantel = $this->session->idplantel; 
        $tabla = "";
         $pos_unidad = strpos($tiporeporte, 'u');
         $pos_oportunidad = strpos($tiporeporte, 'o');
     
       if ($pos_unidad !== false) {
            $array = explode("u", $tiporeporte);
              $idunidad = $array[1];
              $tabla = $this->obtenerCalificacionXUnidad($idclicloescolar, $idgrupo, $idunidad); 
       }else if ($pos_oportunidad !== false) {
            $array = explode("o", $tiporeporte);
              $idoportunidad = $array[1];
              $tabla = $this->obtenerCalificacionXOportunidad($idclicloescolar, $idgrupo, $idoportunidad);
        }
        else if($tiporeporte == 4){
            $tabla = $this->obtenerCalificacion($idclicloescolar, $idgrupo);
        }
       else if($tiporeporte == 2){
            $tabla = $this->obtenerCalificacionFinal($idclicloescolar, $idgrupo);
       }else{
           
           $tabla  = "";
       }
       $unidades = $this->calificacion->unidades($idplantel);
       $oportunidades  = $this->calificacion->oportunidades($idplantel);
        $data = array(
            'tabla'=>$tabla,
            'periodos'=> $this->cicloescolar->showAll($idplantel),
            'grupos'=> $this->grupo->showAllGrupos($idplantel),
            'unidades'=>$unidades,
            'oportunidades'=>$oportunidades
        );
        $this->load->view('admin/header');
        $this->load->view('admin/catalogo/calificaciones/resultado', $data);
        $this->load->view('admin/footer'); 
    }
    public function updateFaltasCalificacion()
    {
         $config = array(
            array(
                'field' => 'faltas',
                'label' => 'Calificación',
                'rules' => 'trim|required|is_natural',
                'errors' => array(
                    'required' => 'Escriba las faltas',
                    'is_natural' => 'Debe de ser numero enteros.'
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
            $id = $this->input->post('id');
            $faltas = $this->input->post('faltas');
            $data = array(
                'evaluacion ' => $faltas,
                'idusuario' => $this->session->user_id,
                'fecharegistro' => date('Y-m-d H:i:s')
            );
            $this->calificacion->updateOtrasEvaluacion($id, $data);

            echo json_encode([
                'success' => 'Ok'
            ]);
        }
    }

    public function addFaltasCalificacion()
    {
        $config = array(
            array(
                'field' => 'faltas',
                'label' => 'Calificación',
                'rules' => 'trim|required|is_natural',
                'errors' => array(
                    'required' => 'Escriba las faltas',
                    'is_natural' => 'Debe de ser numero enteros.'
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
            $faltas = $this->input->post('faltas');
            $data = array(
                'idcalificacion' => $idcalificacion,
                'idtipoevaluacion' => 1,
                'evaluacion ' => $faltas,
                'idusuario' => $this->session->user_id,
                'fecharegistro' => date('Y-m-d H:i:s')
            );
            $this->calificacion->addFaltasCalificacion($data);

            echo json_encode([
                'success' => 'Ok'
            ]);
        }
    }

    public function addRetardo()
    {
        $config = array(
            array(
                'field' => 'retardo',
                'label' => 'Calificación',
                'rules' => 'trim|required|is_natural',
                'errors' => array(
                    'required' => 'Escriba los retardos',
                    'is_natural' => 'Debe de ser numero enteros.'
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
            $retardos = $this->input->post('retardo');
            $data = array(
                'idcalificacion' => $idcalificacion,
                'idtipoevaluacion' => 2,
                'evaluacion ' => $retardos,
                'idusuario' => $this->session->user_id,
                'fecharegistro' => date('Y-m-d H:i:s')
            );
            $this->calificacion->addFaltasCalificacion($data);
            
            echo json_encode([
                'success' => 'Ok'
            ]);
        }
    }
    public function addDisciplina()
    {
        $config = array(
            array(
                'field' => 'disciplina',
                'label' => 'Disciplina',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Escriba la Disciplina.',
                )
            ),
            array(
                'field' => 'presentacionpersonal',
                'label' => 'Presentacio Personal',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Escriba la Presentacion Personal',
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
            $idalumno = $this->input->post('idalumno');
            $idhorario = $this->input->post('idhorario');
            $disciplina = mb_strtoupper($this->input->post('disciplina'));
            $presentacionpersonal = mb_strtoupper($this->input->post('presentacionpersonal')); 
            $data1 = array(
                'idalumno' => $idalumno,
                'idhorario' => $idhorario,
                'idtipoevaluacion' => 3,
                'evaluacion' => $disciplina,
                'idusuario' => $this->session->user_id,
                'fecharegistro' => date('Y-m-d H:i:s')
            );
            $this->calificacion->AddDiscriplina($data1);
            
            $data2 = array(
                'idalumno' => $idalumno,
                'idhorario' => $idhorario,
                'idtipoevaluacion' => 4,
                'evaluacion' => $presentacionpersonal,
                'idusuario' => $this->session->user_id,
                'fecharegistro' => date('Y-m-d H:i:s')
            );
            $this->calificacion->AddDiscriplina($data2);
            
            echo json_encode([
                'success' => 'Ok'
            ]);
        }
    }
    public function editisciplina()
    {
        $config = array(
            array(
                'field' => 'disciplina',
                'label' => 'Disciplina',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Escriba la Disciplina.',
                )
            ),
            array(
                'field' => 'presentacionpersonal',
                'label' => 'Presentacio Personal',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Escriba la Presentacion Personal',
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
            $iddisciplina = $this->input->post('iddisciplina');
            $idpresentacionpersonal = $this->input->post('idpresentacionpersonal');
            $disciplina = mb_strtoupper($this->input->post('disciplina'));
            $presentacionpersonal = mb_strtoupper($this->input->post('presentacionpersonal'));
            $data1 = array( 
                'evaluacion' => $disciplina,
                'idusuario' => $this->session->user_id,
                'fecharegistro' => date('Y-m-d H:i:s')
            );
            $this->calificacion->updateDiscriplina($iddisciplina,$data1);
            
            $data2 = array( 
                'evaluacion' => $presentacionpersonal,
                'idusuario' => $this->session->user_id,
                'fecharegistro' => date('Y-m-d H:i:s')
            );
            $this->calificacion->updateDiscriplina($idpresentacionpersonal,$data2);
            
            echo json_encode([
                'success' => 'Ok'
            ]);
        }
    }
    public function updateRetardo()
    {
        $config = array(
            array(
                'field' => 'retardo',
                'label' => 'Calificación',
                'rules' => 'trim|required|is_natural',
                'errors' => array(
                    'required' => 'Escriba los retardos',
                    'is_natural'=>'Debe de ser numero enteros.'
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
            $id = $this->input->post('id');
            $retardos = $this->input->post('retardo');
            $data = array( 
                'evaluacion' => $retardos,
                'idusuario' => $this->session->user_id,
                'fecharegistro' => date('Y-m-d H:i:s')
            );
            $this->calificacion->updateOtrasEvaluacion($id,$data);
            
            echo json_encode([
                'success' => 'Ok'
            ]);
        }
    }
    public function obtenerCalificacionXOportunidad($idperiodo,$idgrupo,$idoportunidad){
        $idplantel = $this->session->idplantel;
        $detalle_oportunidad = $this->calificacion->detalleOportunidad($idoportunidad,$idplantel);
        $tabla = "";
        $alumnos = "";
        $opcion = "";
        if ($detalle_oportunidad->numero == 2) {
            $opcion = 1;
            $alumnos = $this->calificacion->showAlumnosMateriasOportunidades($idperiodo,$idgrupo,'');
        }else{
            $detalle_oportunidad_anteriot = $this->grupo->obtenerOportunidadAnterior($detalle_oportunidad->numero, $idplantel);
            $idoportunidad_anterior = $detalle_oportunidad_anteriot->idoportunidadexamen; 
            $alumnos = $this->calificacion->showAlumnosMateriasOportunidadesXId($idperiodo,$idgrupo,$idoportunidad_anterior,$idoportunidad);
            $opcion = 2;
        }
     
        if(isset($alumnos) && !empty($alumnos)){
            $tabla .= ' <table  id="tablageneralcal" class=" table table-striped dt-responsive nowrap" cellspacing="0" width="100%">
                <thead class="bg-teal">
                    <th>#</th>
                    <th>NOMBRE</th>
                    <th>MATERIA</th>
                    <th>CALIFICACION</th>'; 
            $tabla .= '</thead>';
            $c = 1;
            if (isset($alumnos) && !empty($alumnos)) {
                foreach ($alumnos as $alumno){
                    
                    $datoshorario = $this->horario->showNivelGrupo($alumno->idhorario); 
                    $idnivelestudio = $datoshorario->idnivelestudio;
                    $detalle_configuracion = $this->configuracion->showAllConfiguracion($this->session->idplantel, $idnivelestudio);
                    $total_unidad = $alumno->totalunidad;
                    $totales_unidades = $alumno->totalunidades;
                    if($opcion == 1){
                        if(($total_unidad == $totales_unidades) && ($alumno->calificacion < $detalle_configuracion[0]->calificacion_minima)){
                            $tabla .='<tr>';
                                $tabla .= '<td>' . $c++ . '</td>';
                                $tabla .='<td>'.$alumno->nombre.' '.$alumno->apellidop.' '.$alumno->apellidom.'</td>';
                                $tabla .='<td>'.$alumno->nombreclase.'</td>';
                                $tabla .='<td>'.$alumno->calificacionoportunidad.'</td>';
                            $tabla .='</tr>';
                        }
                    }
                    if($opcion == 2){
                        if(($alumno->calificacionoportunidadanterior < $detalle_configuracion[0]->calificacion_minima)){
                            $tabla .='<tr>';
                            $tabla .= '<td>' . $c++ . '</td>';
                            $tabla .='<td>'.$alumno->nombre.' '.$alumno->apellidop.' '.$alumno->apellidom.'</td>';
                            $tabla .='<td>'.$alumno->nombreclase.'</td>';
                            $tabla .='<td>'.$alumno->calificacionoportunidadactual.'</td>';
                            $tabla .='</tr>';
                        }
                    }
                   
                }
            }
            
            $tabla .='</table>';
        }
        return $tabla;
    }
    public function obtenerCalificacionXUnidad($idperiodo,$idgrupo,$idunidad){
        $tabla = "";
        $alumnos = $this->calificacion->alumnosGrupo($idperiodo,$idgrupo);
        $materias = $this->calificacion->materiasGrupo($idperiodo,$idgrupo);
        $detalle_periodo = $this->calificacion->detallePeriodo($idperiodo);
        $estatus_periodo = $detalle_periodo->activo;
        if(isset($alumnos) && !empty($alumnos)){
            $tabla .= ' <table  id="tablageneralcal" class=" table table-striped dt-responsive nowrap" cellspacing="0" width="100%">
                <thead class="bg-teal">
                    <th>#</th>
                    <th>NOMBRE</th>';
                    if (isset($materias) && !empty($materias)){
                        foreach ($materias as $row){
                            $tabla .='<th>'.$row->nombreclase.'</th>';
                        }
                    } 
                    $tabla .= '</thead>';
                    $c = 1;
                    if (isset($alumnos) && !empty($alumnos)) {
                        foreach ($alumnos as $alumno){
                            $idalumno = $alumno->idalumno;
                            $opcion_alumno = $alumno->opcion;
                            $tabla .='<tr>';
                                $tabla .= '<td>' . $c++ . '</td>';
                                $tabla .='<td>'.$alumno->nombre.' '.$alumno->apellidop.' '.$alumno->apellidom.'</td>';
                                foreach ($materias as $materia) {
                                    $idmateria = $materia->idmateria;
                                    $idprofesormateria = $materia->idprofesormateria;
                                    // AVERIGUAR SI AL ALUMNO PUEDE LLEVAR ESTA MATERIA
                                    // DEPENDIENDO DE LLEVA REPROBADA
                                    if ($opcion_alumno == 1) {
                                        $evaluar = $this->calificacion->validarMateriaSeriada($idalumno, $idmateria,$estatus_periodo);
                                        if ($evaluar) {
                                            $tabla .= '<td>No puede llevar esta Asignatura.</td>';
                                        } else {
                                            $calificacion = $this->calificacion->obtenerCalificacionXUnidad($idalumno,$idunidad,$idprofesormateria);
                                            // EVALUA LA CALIFICACION PARA ESTE NIVEL
                                            if($calificacion){
                                                $idcalificacion =$calificacion->idcalificacion;
                                                $tabla .= '<td><label>'.$calificacion->calificacion.'</label>';
                                                $value_faltas = $this->calificacion->validarExistenciaOtrasEvaluaciones($idcalificacion,1);
                                                $value_retardo = $this->calificacion->validarExistenciaOtrasEvaluaciones($idcalificacion,2);
                                                if(isset($this->session->idniveleducativo) && !empty($this->session->idniveleducativo) && $this->session->idniveleducativo == 3){
                                            /*      if ($value_faltas) {
                                                     //YA ESTA REGISTRADO LAS FALTAS
                                                     $tabla .= '  <a  href="#" class="edit_button" data-toggle="modal" data-target="#modalEditFaltas" 
                                                     data-id="' .$value_faltas->iddetallecalificacionotras. '"
                                                     data-faltas="' .$value_faltas->evaluacion. '"
     				                                data-alumno="' . $alumno->apellidop . " " . $alumno->apellidom . " " . $alumno->nombre . '"
     				                                ><i class="fa fa-pencil-square fa-lg"  
     				                                style = "color:#2a90f0;" title="Editar faltas."></i> '.$value_faltas->evaluacion.' - Falta</a> ';
                                                 }else{
                                                     //NO ESTA REGISTRADO LAS FALTAS
                                                     $tabla .= '  <a  href="#"  data-toggle="modal" data-target="#modalAddFaltas" class=" add_button"
                                                     data-idcalificacion="' .$idcalificacion. '"
     				                                data-alumno="' . $alumno->apellidop . " " . $alumno->apellidom . " " . $alumno->nombre . '"><i class="fa fa-plus-circle fa-lg"  
     				                                style = "color:#4cc279;" title="Agregar faltas."></i> Falta </a> ';
                                                 } */
                                                
                                               /*  if ($value_retardo) {
                                                    //YA ESTA REGISTRADO LOS RETARDO
                                                  
                                                    $tabla .= '<a  href="#)" data-toggle="modal" data-target="#modalEditRetardo"  class="edit_button_retardo"
                                                    data-id="' .$value_retardo->iddetallecalificacionotras. '"
                                                    data-retardo="' .$value_retardo->evaluacion. '"
    				                                data-alumno="' . $alumno->apellidop . " " . $alumno->apellidom . " " . $alumno->nombre . '"
    				                                ><i class="fa fa-pencil-square fa-lg"
    				                                style = "color:#2a90f0;" title="Editar faltas."></i> '.$value_retardo->evaluacion.' - Retardo</a> ';
                                                    
                                                    
                                                }else{
                                                    //NO ESTA REGISTRADO LOS RETARDO
                                                    $tabla .= '  <a  href="#"  data-toggle="modal" data-target="#modalAddRetardo" class="add_button_retardo"
                                                    data-idcalificacion="' .$idcalificacion. '"
    				                                data-alumno="' . $alumno->apellidop . " " . $alumno->apellidom . " " . $alumno->nombre . '"><i class="fa fa-plus-circle fa-lg"
    				                                style = "color:#4cc279;" title="Agregar Retardo."></i> Retardo </a> ';
                                                } */
                                            }
                                                $tabla .='</td>';
                                                
                                                
                                            }else{
                                                $tabla .= '<td><small>No registrado</small></td>';
                                            }
                                        }
                                    } else if ($opcion_alumno == 0) {
                                        //VALIDAR MATERIA REPROBADA
                                        $validar = $this->calificacion->validarMateriaReprobadaXUnidad($idalumno,$idprofesormateria);
                                        if ($validar) {
                                            //VALIDAMOS LA CALIFICACION
                                            $calificacion = $this->calificacion->obtenerCalificacionXUnidad($idalumno,$idunidad,$idprofesormateria); 
                                            if($calificacion){
                                                $tabla .= '<td>'.$calificacion->calificacion.'</td>';
                                            }else{
                                                $tabla .= '<td><small>No registrado</small></td>';
                                            }
                                        }else{
                                            //NO PUEDE LLEVAR LA MATERIA 
                                            $tabla .='<td>No lleva la materia.</td>';
                                        }
                                    } else {
                                        //NO ES NADA
                                    }
                                }
                            $tabla .='</tr>';
                        }
                    }
                    
                    $tabla .='</table>';
        }else{
            //SIN REGISTROS DE ALUMNOS
        }
        return $tabla;
    }
    public function obtenerCalificacionFinal($idperiodo,$idgrupo) {
        $idplantel = $this->session->idplantel;
        $alumnos = $this->calificacion->listaAlumnos($idgrupo,$idplantel,$idperiodo);
        $materias = $this->calificacion->listaMateriasGrupo($idgrupo,$idplantel,$idperiodo);
        $tabla = "";
        $tabla .= ' <table  id="tablageneralcal" class=" table table-striped dt-responsive nowrap" cellspacing="0" width="100%">
        <thead class="bg-teal">
            <th>#</th>
            <th>NOMBRE</th>
            <th>PROMEDIO</th>'; 
        $tabla .= '</thead>';
        $c = 1;
        if (isset($alumnos) && !empty($alumnos)) {
            $total_materias = 0;
            $suma_calificacion_materias = 0;
            foreach ($alumnos as $row) {
                $idalumno = $row->idalumno;
                $tabla .= '<tr>';
                $tabla .= '<td>' . $c++ . '</td>';
                $tabla .= '<td>' . $row->apellidop . " " . $row->apellidom . " " . $row->nombre . '</td>';
                
                $suma_recorrido = 0;
                $suma_recorrido_reprobados = 0;
                $total_materias = 0;
                $suma_calificacion_materias = 0;
                if(isset($materias) && !empty($materias)){
                foreach ($materias as $block) {
                    $idmateria = $block->idmateriareal;
                    $validar_materia_reprobada = $this->calificacion->validarMateriaReprobada($idalumno,$idmateria);
                    
                    if($validar_materia_reprobada){
                            // No se le muestra la materia porque la reprobo y estaba seriada
                        } else {
                            $valor_calificacion = $this->calificacion->obtenerCalificacionSumatoria($idalumno, $idmateria, $idperiodo);

                            // Se refleja la metaria para sacar el promedio
                            if (isset($valor_calificacion) && ! empty($valor_calificacion)) {
                                $suma_recorrido = 0;
                                foreach ($valor_calificacion as $row_ca) {
                                    if ($suma_recorrido == 0) {
                                        $suma_calificacion_materias = $row_ca->calificacion;
                                        $total_materias ++;
                                    }
                                    $suma_recorrido = 1;
                                }
                            } else {
                                $total_materias ++;
                            }
                        }

                        $materias_reprobadas = $this->calificacion->listaMateriasReprobadas($idalumno, $idperiodo);
                        if (isset($materias_reprobadas) && ! empty($materias_reprobadas)) {
                            foreach ($materias_reprobadas as $value) {
                                $idhorario_reprobada = $value->idhorario;
                                $idprofesormateria = $value->idprofesormateria;
                                $calificacion_reprobados = $this->calificacion->obtenerCalificacionSumatoria($idalumno, $idprofesormateria, $idhorario_reprobada);

                                if (isset($calificacion_reprobados) && ! empty($calificacion_reprobados)) {
                                    $suma_recorrido_reprobados = 0;
                                    foreach ($valor_calificacion as $row_ca_rep) {
                                    if($suma_recorrido == 0){
                                        $suma_calificacion_materias = $row_ca_rep->calificacion;
                                        
                                    }
                                    $suma_recorrido_reprobados = 1;
                                }
                            }
                            $total_materias ++;
                        }
                    }
                     
                }
                $tabla .='<td>';
                if((isset($total_materias) && !empty($total_materias) && $total_materias > 0) && (isset($suma_calificacion_materias) && !empty($suma_calificacion_materias) && $suma_calificacion_materias > 0)){
                    $tabla .='<label>'.number_format(($suma_calificacion_materias/$total_materias),2).'</label>';
                }else{
                    $tabla .='<small>No registrado</small>';
                }
                $tabla .= '</td>';
                }else{ 
                    $tabla .= '<td><small>No registrado</small></td>';
                }
                
                $tabla .= '</tr>';
            }
        }
        $tabla .= '</table>';
        return $tabla;
    }
    
    function descargarBoletaPDF($idperiodo = '',$idgrupo = '', $idalumno = ''){
        
        $this->load->library('tcpdf');
        $hora = date("h:i:s a");
        $fechaactual = date('d/m/Y');
        
        $detalle_logo = $this->alumno->logo($this->session->idplantel);
        $logo = base_url() . '/assets/images/escuelas/' . $detalle_logo[0]->logoplantel;
        $logo2 = base_url() . '/assets/images/escuelas/' . $detalle_logo[0]->logosegundo;
        $materias_a_recuperar = $this->calificacion->materiasXRecuperar($idperiodo,$idalumno);
        $alumno = $this->alumno->detalleAlumno($idalumno);
        $unidades = $this->calificacion->unidades($this->session->idplantel);
        $materias = $this->calificacion->materiasGrupo($idperiodo,$idgrupo);
        $director = $this->calificacion->obtenerDirector($this->session->idplantel);
        $idhorario = "";
        if(isset($materias) && !empty($materias)){
            $idhorario = $materias[0]->idhorario;
        }
        $grupo = $this->horario->showNivelGrupo($idhorario);
        
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
      <table width="500" border="0" cellpadding="0" class="tblborder" cellspacing="0">
      <tr>
      <td width="120" align="center">
      <img src="' . $logo2 . '" width="150" height="90" />
      </td>
      <td colspan="2" width="260" align="center">
      <label class="slogan">"'.str_replace("INSTITUTO MORELOS", "", $detalle_logo[0]->nombreplantel).'"</label><br />
      <label class="nombreplantel">'.str_replace("VALOR Y CONFIANZA", "", $detalle_logo[0]->nombreplantel).'</label><br />
      <label class="tipoplantel">'.$detalle_logo[0]->asociado.'</label><br />
      <label class="clave">CCT. '.$detalle_logo[0]->clave.'</label><br />
      <label class="txtn">Incorporado a la Dirección General del Bachillerato - Modalidad Escolarizada</label
      ><br />
      <label class="txtn">RVOE: 85489 de fecha 29 julio 1985, otorgado por la Dirección General de Incorporación y Revalidación</label>
      </td>
      <td width="120" align="center">
      <img src="' . $logo . '" width="150" height="70" />
      </td>
      </tr>
      <tr>
      <td colspan="4" align="center">
      <br /><label class="titulo">BOLETA DE CALIFICACIONES</label>
      </td>
      </tr>
      </table>
          
      <table width="500" border="0" cellpadding="2" cellspacing="0">
      <tr  class="tituloalumno">
      <td colspan="3" align="left">';
        $tabla .='ALUMNO: ' . $alumno->nombre . ' ' . $alumno->apellidop . ' ' . $alumno->apellidom;
        $tabla .='</td>
      </tr>
      <tr>
      <td class="tituloalumno" colspan="2" align="left">';
        $tabla .='CURP: '.$alumno->curp;
      $tabla .='</td>
      <td class="tituloalumno" colspan="2" align="center">';
      $tabla .= $grupo->numeroromano.' SEMESTRE'; 
      $tabla.='</td>
      </tr>
      <tr>
      <td colspan="2" class="tituloalumno" align="left">';
      $tabla .= 'MATRICULA: '.$alumno->matricula;
      $tabla .= '</td>
      <td colspan="2" class="tituloalumno" align="center">';
      $tabla .= 'CICLO ESCOLAR: '. $grupo->yearinicio . ' - ' . $grupo->yearfin;
      $tabla .= '</td>
      </tr>
      </table>
          
      <table width="467" border="0" cellpadding="2"  class="tblhorario"  cellspacing="0">
      <tr class="bg-prom"   align="center">
      <td  width="30" align="center" height="20" class="secondtxt"  > &nbsp;<br>
       CLAVE
      </td>
      <td width="210" class="secondtxt">&nbsp;<br>
       ASIGNATURA
      </td>
      <td width="35" class="secondtxt">&nbsp;<br>
       1ER. PARCIAL
      </td class="secondtxt">
      <td width="35" class="secondtxt">&nbsp;<br>
       2DO. PARCIAL
      </td>
      <td width="35"  class="secondtxt">&nbsp;<br>
       3ER. PARCIAL
      </td>
      <td width="30" class="secondtxt">&nbsp;<br>
      EX.SEM
      </td>
      <td width="28" align="center" class="secondtxt">&nbsp;<br>
       PROM.
      </td>
      <td  width="25" class="secondtxt">&nbsp;<br>
      EXT.
      </td>
      <td  width="33" class="secondtxt">&nbsp;<br>
       FALTAS
      </td>
      <td width="39" class="secondtxt">&nbsp;<br>
      RETARDOS
      </td>
      </tr>
          
      <tr class="secondtxt">
      <td colspan="10" align="center">
      <label class="secondtxt"><strong>';
      if($grupo->nombrenivel == 1){
          $tabla .= 'PRIMER SEMESTRE';
      }else{
          $tabla .= $grupo->nombrenivel.' SEMESTRE';
      } 
      $tabla .='</strong>`</label>
      </td>
      </tr>';
        
        $detalle_periodo = $this->calificacion->detallePeriodo($idperiodo);
        $estatus_periodo = $detalle_periodo->activo;
        $suma_calificaciones_global = 0;
        $total_suma_materias = 0;
        if(isset($materias) && !empty($materias)){
            $suma_calificaciones = 0;
            $suma_unidades = 0;
            foreach ($materias as $materia){
                $idmateria = $materia->idmateria;
                
                $idhorariodetalle = $materia->idhorariodetalle;
                $idprofesormateria = $materia->idprofesormateria;
                $total_falta = $this->calificacion->obtenerAsistenciaBoleta($idalumno,$idperiodo,$idprofesormateria,4);
                $total_retardo = $this->calificacion->obtenerAsistenciaBoleta($idalumno,$idperiodo,$idprofesormateria,2);
                $evaluar = $this->calificacion->validarMateriaSeriada($idalumno, $idmateria,$estatus_periodo);
                 if ($evaluar == false) {
                     $total_suma_materias ++;
                 $tabla .='
                   <tr  class="thirdtxt"  >
                      <td align="center">'.$materia->clave.' </td>
                      <td>'.$materia->nombreclase.' </td>';
                         $suma_calificaciones = 0;
                         $suma_unidades = 0;
                         if (isset($unidades) && !empty($unidades)){ 
                             foreach ($unidades as $unidad){
                                 $idunidad = $unidad->idunidad;
                                 $evaluar = $this->calificacion->obtenerCalificacion($idalumno,$idunidad,$idhorariodetalle);
                                 if($evaluar){
                                     $tabla .='<td align="center">'.$evaluar->calificacion.'</td>'; 
                                     $suma_calificaciones+=$evaluar->calificacion;
                                 }else{
                                     $tabla .='<td align="center">0</td>'; 
                                 }
                                 $suma_unidades++;
                             }
                         }
                    
                     $tabla .='<td></td>';
                     if($suma_calificaciones > 0 && $suma_unidades > 0){
                         $suma = $suma_calificaciones/$suma_unidades;
                         $suma_calificaciones_global += $suma;
                     $tabla .='<td align="center" class="bg-prom">'.number_format($suma_calificaciones/$suma_unidades,1).'</td>';
                     }else{
                         $tabla .='<td align="center" class="bg-prom">0</td>';
                     }
                      $tabla .='<td></td>
                      <td  align="center">'.$total_falta->total.'</td>
                      <td  align="center">'.$total_retardo->total.'</td>
                  </tr>';
                  }
            }
        }
        if (isset($materias_a_recuperar) && !empty($materias_a_recuperar)) {
            
                $suma_calificaciones = 0;
                $suma_unidades = 0;
            foreach ($materias_a_recuperar as $row){
                $total_suma_materias ++;
                $total_falta = $this->calificacion->obtenerAsistenciaBoleta($idalumno,$idperiodo,$row->idprofesormateria,4);
                $total_retardo = $this->calificacion->obtenerAsistenciaBoleta($idalumno,$idperiodo,$row->idprofesormateria,2);
                
                
                $tabla .='
                   <tr  class="thirdtxt"  >
                      <td align="center">'.$row->clave.' </td>
                      <td>'.$row->nombreclase.' </td>';
                      $suma_calificaciones = 0;
                         $suma_unidades = 0;
                         if (isset($unidades) && !empty($unidades)){ 
                             foreach ($unidades as $unidad){
                                 $idunidad = $unidad->idunidad;
                                 $evaluar = $this->calificacion->obtenerCalificacion($idalumno,$idunidad,$row->idhorariodetalle);
                                 if($evaluar){
                                     $tabla .='<td align="center">'.$evaluar->calificacion.'</td>'; 
                                     $suma_calificaciones+=$evaluar->calificacion;
                                 }else{
                                     $tabla .='<td align="center">0</td>'; 
                                 }
                                 $suma_unidades++;
                             }
                         }
                     $tabla .='<td></td>';
                      if($suma_calificaciones > 0 && $suma_unidades > 0){
                          $suma = $suma_calificaciones/$suma_unidades;
                          $suma_calificaciones_global += $suma;
                     $tabla .='<td align="center" class="bg-prom">'.number_format($suma_calificaciones/$suma_unidades,1).'</td>';
                     }else{
                         $tabla .='<td align="center" class="bg-prom">0</td>';
                     }
                     $tabla .='<td></td>
                       <td  align="center">'.$total_falta->total.'</td>
                      <td  align="center">'.$total_retardo->total.'</td>
                  </tr>';
            }
        }
          
      $tabla .='<tr class="bg-prom thirdtxt" align="center">
      <td>  </td>
      <td align="left"  class="thirdtxt">';
      $tabla.='PROMEDIO';
      $tabla.='</td>
      <td> </td>
      <td> </td>
      <td> </td>
      <td> </td>
      <td>';
      if ($suma_calificaciones_global > 0 && $total_suma_materias > 0) {
          $tabla .= '<strong>'.number_format($suma_calificaciones_global/$total_suma_materias,1).'</strong>';
        
      }else{
          $tabla .= '<strong>0</strong>';
      }
      $tabla.='</td>
      <td> </td>
      <td> </td>
      <td> </td>
      </tr>
      <tr align="center" class="thirdtxt">
      <td> </td>
      <td align="left" class="thirdtxt">';
      $tabla .='DISCIPLINA';
      $tabla .='</td>
      <td>  </td>
      <td>  </td>
      <td> </td>
      <td> </td>
      <td> </td>
      <td> </td>
      <td>  </td>
      <td>  </td>
      </tr>
      <tr align="center"  class="thirdtxt">
      <td>  </td>
      <td align="left">';
       $tabla .='PRESENTACION PERSONAL';
       $tabla .=' </td>
      <td>  </td>
      <td> </td>
      <td> </td>
      <td>  </td>
      <td> </td>
      <td>  </td>
      <td>  </td>
      <td>  </td>
      </tr>
       <tr align="center"  class="thirdtxt">
      <td>  </td>
      <td align="left">';
       $tabla .='<label>FIRMA</label>';
       $tabla .=' </td>
      <td>  </td>
      <td> </td>
      <td> </td>
      <td>  </td>
      <td> </td>
      <td>  </td>
      <td>  </td>
      <td>  </td>
      </tr>
      </table>
          
      <table width="540" border="0" cellpadding="0" cellspacing="0">
      <tr align="center">
      <td colspan="">
      <label class="thirdtxt"></label>
      </td>
      <td width="100">
      <label class="thirdtxt">LUGAR DE EXPEDICION:</label>
      </td>
      <td width="130" align="left">
      <label class="thirdtxt">Miguel Hidalgo, Ciudad de México</label>
      </td>
      </tr>
      <tr align="center">
      <td colspan="">
      <label class="thirdtxt"></label>
      </td>
      <td width="100">
      <label class="thirdtxt">FECHA DE EXPEDICION:</label>
      </td>
      <td width="130" align="left">
      <label class="thirdtxt">'.date('d/m/Y').'</label>
      </td>
      </tr>
      </table>
          
      <table width="600" border="0" cellpadding="0" cellspacing="0">
      <tr align="center">
      <td width="200">';
       if ($director) {
        $tabla .= '<label class="thirdtxt">'.$director->nombre.' '.$director->apellidop.' '.$director->apellidom.'</label>';
       }
    
     $tabla .='</td>
      <td>
      <label class="thirdtxt"></label>
      </td>
      </tr>
      <tr align="center">
      <td width="200">
      <label class="thirdtxt">DIRECTORA DE BACHILLERATO</label>
      </td>
      <td>
      <label class="thirdtxt"></label>
      </td>
      </tr>
      </table>
      ';
        
        $pdf->writeHTML($tabla, true, false, false, false, '');
        
        ob_end_clean();
        
        $pdf->Output('Boleta de Calificaciones', 'I');
    }
    public function obtenerCalificacion($idperiodo,$idgrupo) {
        $detalle_periodo = $this->calificacion->detallePeriodo($idperiodo);
        $estatus_periodo = $detalle_periodo->activo;
        $alumnos = $this->calificacion->alumnosGrupo($idperiodo,$idgrupo);
        $materias = $this->calificacion->materiasGrupo($idperiodo,$idgrupo);
        $tabla = "";
        $tabla .= ' <table  id="tablageneralcal" class=" table table-striped dt-responsive nowrap" cellspacing="0" width="100%"> 
        <thead class="bg-teal">
            <th>#</th> 
            <th>NOMBRE</th>';
        if(isset($materias) & !empty($materias)){
            foreach ($materias as $block) : 
            $tabla .= '<th>' . $block->nombreclase . '</th>';
            endforeach;
        }else{
            $tabla .= '<th>SIN CURSOS</th>';
        }
        $tabla .= '</thead>';
        $c = 1;
        if (isset($alumnos) && !empty($alumnos)) {
          
            foreach ($alumnos as $row) { 
                $idalumno = $row->idalumno;
                $idhorario = $row->idhorario;
                $tabla .= '<tr>';
                $tabla .= '<td>' . $c++ . '</td>'; 
                $tabla .= '<td>' . $row->apellidop . " " . $row->apellidom . " " . $row->nombre;
                //EVALUAR SI YA TIENE REGISTRADOS OTRAS EVALUACIONES
                $validar_diciplina = $this->calificacion->validarOtrasEvaluaciones($idalumno,$idhorario);
                if(isset($this->session->idniveleducativo) && !empty($this->session->idniveleducativo) && $this->session->idniveleducativo == 3){
                if ($validar_diciplina) {
                    $tabla .= '  <a  href="#"  data-toggle="modal" data-target="#modalEditOtrasEvaluaciones" class="edit_button_diciplina"
                                                    data-idhorario="' . $idhorario . '"';
                    foreach ($validar_diciplina as $diciplina) {
                        if ($diciplina->idtipoevaluacion == 3) {
                            // DESCIPLINA
                            $tabla .= 'data-iddisciplina="' . $diciplina->idcalificaciondisciplina . '"';
                            $tabla .= 'data-disciplina="' . $diciplina->evaluacion . '"';
                        }
                        if ($diciplina->idtipoevaluacion == 4) {
                            // PRESENTACIÓN PERSONAl
                            $tabla .= 'data-idpresentacionpersonal="' . $diciplina->idcalificaciondisciplina . '"';
                            $tabla .= 'data-presentacionpersonal="' . $diciplina->evaluacion . '"';
                            
                        }
                   
                    }
                    $tabla .= '  data-alumno="' . $row->apellidop . " " . $row->apellidom . " " . $row->nombre . '"><i class="fa fa-pencil-square fa-lg"  
    				                                style = "color:#2a90f0;" title="Editar."></i> Editar </a> ';
                    $tabla .='<a  target="_blank" href="'.base_url().'/Calificacion/descargarBoletaPDF/'.$idperiodo.'/'.$idgrupo.'/'.$idalumno.'">Descargar</a>';
                } else {
                    $tabla .= '  <a  href="#"  data-toggle="modal" data-target="#modalAddOtrasEvaluaciones" class="add_button_diciplina"
                                                    data-idhorario="' . $idhorario . '"
                                                    data-idalumno="' . $idalumno . '"
    				                                data-alumno="' . $row->apellidop . " " . $row->apellidom . " " . $row->nombre . '"><i class="fa fa-plus-circle fa-lg"
    				                                style = "color:#4cc279;" title="Agregar."></i> Agregar </a> ';
                    
                }
            }
                $tabla .='</td>';
                $opcion_alumno = $row->opcion;
                $suma_recorrido = 0;
                if (isset($materias) && !empty($materias)){
                foreach ($materias as $block) { 
                    $idmateria = $block->idmateria; 
                    $idprofesormateria = $block->idprofesormateria;
                    //$validar_materia_reprobada = $this->calificacion->validarMateriaReprobada($idalumno,$idmateria);
                    $tabla .= '<td>'; 
                    if ($opcion_alumno == 1) {
                        $evaluar = $this->calificacion->validarMateriaSeriada($idalumno, $idmateria,$estatus_periodo);
                        if ($evaluar) {
                            $tabla .= '<td>No puede llevar esta Asignatura.</td>';
                        } else {
                            $valor_calificacion = $this->calificacion->obtenerCalificacionSumatoria($idalumno,$idprofesormateria,$idperiodo);
                            
                            //Se refleja la metaria para sacar el promedio
                            if(isset($valor_calificacion) && !empty($valor_calificacion)){
                                $suma_recorrido = 0;
                                foreach ($valor_calificacion as $row_ca){
                                    if($suma_recorrido == 0){
                                        $tabla .='<label>'.number_format($row_ca->calificacion,2).'</label>';
                                    }
                                    $suma_recorrido = 1;
                                } 
                            }else{
                                $tabla .='<small>No registrado</small>';
                            }
                        }
                    }else  if ($opcion_alumno == 0) {
                        $validar = $this->calificacion->validarMateriaReprobadaXUnidad($idalumno,$idprofesormateria);
                        if ($validar) {
                            //VALIDAMOS LA CALIFICACION
                            $valor_calificacion = $this->calificacion->obtenerCalificacionSumatoria($idalumno,$idprofesormateria,$idperiodo);
                            
                            //Se refleja la metaria para sacar el promedio
                            if(isset($valor_calificacion) && !empty($valor_calificacion)){
                                $suma_recorrido = 0;
                                foreach ($valor_calificacion as $row_ca){
                                    if($suma_recorrido == 0){
                                        $tabla .='<label>'.number_format($row_ca->calificacion,2).'</label>';
                                    }
                                    $suma_recorrido = 1;
                                }
                            }else{
                                $tabla .='<small>No registrado</small>';
                            }
                        }else{
                            //NO PUEDE LLEVAR LA MATERIA
                            $tabla .='<td>No lleva la materia.</td>';
                        }
                    }else{
                        
                    }
                    
/*                     if($validar_materia_reprobada){
                     //No se le muestra la materia porque la reprobo y estaba seriada
                        $tabla .='<small>No puede cursar esta curso.</small>';
                    }else{
                        $valor_calificacion = $this->calificacion->obtenerCalificacionSumatoria($idalumno,$idmateria,$idperiodo);
                        
                        //Se refleja la metaria para sacar el promedio
                        if(isset($valor_calificacion) && !empty($valor_calificacion)){
                            $suma_recorrido = 0;
                            foreach ($valor_calificacion as $row_ca){
                                if($suma_recorrido == 0){
                                    $tabla .='<label>'.number_format($row_ca->calificacion,2).'</label>';
                                }
                                $suma_recorrido = 1;
                            }
                        }else{
                            $tabla .='<small>No registrado</small>';
                        }
                     
                    } */
                
                    $tabla .= '</td>';
                }
            }else{
                $tabla .='<td><small>No registrado</small></td>';
            }
                
                $tabla .= '</tr>';
            }
        } 
        $tabla .= '</table>';
        return $tabla;
    }
    public function obtenerAsistencia($idperiodo,$idgrupo,$idcurso,$tiporeporte,$fechainicio,$fechafin) {
        $idplantel = $this->session->idplantel;
        $alumns = $this->calificacion->listaAlumnos($idgrupo,$idplantel,$idperiodo);
        $tabla = "";
        $detalle_curso = $this->calificacion->detalleCurso($idcurso);
        if ($alumns != false) {
            $range = ((strtotime($fechafin) - strtotime($fechainicio)) + (24 * 60 * 60)) / (24 * 60 * 60);
            $tabla .= '  <table id="tablageneralcal" class="table table-striped dt-responsive nowrap" cellspacing="0" width="100%">
            <caption class="bg-teal"><center><strong>'.$detalle_curso->nombreclase.'</strong></center></caption>           
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
            endfor;
            $tabla .= '</thead>';
            $n = 1;
            foreach ($alumns as $alumn) {
                $tabla .= ' <tr>';
                $tabla .= '<td>' . $n++ . '</td>';
                $tabla .= '<td >' . $alumn->apellidop . " " . $alumn->apellidom . " " . $alumn->nombre . '</td>';
                for ($i = 0; $i < $range; $i++):
                $date_at = date("Y-m-d", strtotime($fechainicio) + ($i * (24 * 60 * 60)));
                $asist = $this->calificacion->listaAsistencia($alumn->idalumno, $date_at, $idcurso,$tiporeporte);
                $domingo = date('N', strtotime($fechainicio) + ($i * (24 * 60 * 60)));
                
                if ($domingo != '7') {
                    if ($domingo != '6') {
                        $tabla .= '<td align="center">';
                        if ($asist) {
                            $tabla .= $asist->nombremotivo;
                        } else {
                            $tabla .= "---";
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
    
    //CRUD PREESCOLAR
    public  function showAllMaterias (){
        $idgrupo = $this->input->get('idgrupo');
        $resultado = $this->calificacion->detalleGrupo($idgrupo);
        if($resultado){
            $idnivelestudio = $resultado->idnivelestudio;
            $query = $this->calificacion->allMateriasPreescolar($idnivelestudio); 
        if ($query) {
            $result['materias'] = $this->calificacion->allMateriasPreescolar($idnivelestudio);
        }
        }
        if(isset($result) && !empty($result)){
            echo json_encode($result);
        }
    }
    public  function  showMateriasYaRegistradas(){
        $idalumno = $this->input->get('idalumno');
        $idperiodo = $this->input->get('idperiodo');
        $idgrupo = $this->input->get('idgrupo');
        $idmes = $this->input->get('idmes');
        $query = $this->calificacion->allMateriasPreescolarAlumno($idperiodo,$idgrupo,$idmes,$idalumno);
        if ($query) {
            $result['materias_registradas'] = $this->calificacion->allMateriasPreescolarAlumno($idperiodo,$idgrupo,$idmes,$idalumno);
        }
        if(isset($result) && !empty($result)){
            echo json_encode($result);
        }
    }
    public  function  showCalificacionesDetalle(){
        $idalumno = $this->input->get('idalumno');
        $idperiodo = $this->input->get('idperiodo');
        $idgrupo = $this->input->get('idgrupo');
        $idmes = $this->input->get('idmes');
        $query = $this->calificacion->showAllCalificacionesDetalle($idperiodo,$idgrupo,$idmes,$idalumno);
        if ($query) {
            $result['calificaciones_registradas'] = $this->calificacion->showAllCalificacionesDetalle($idperiodo,$idgrupo,$idmes,$idalumno);
        }
        if(isset($result) && !empty($result)){
            echo json_encode($result);
        }
    }
    public  function  showAsistenciasYaRegistradas(){
        $idalumno = $this->input->get('idalumno');
        $idperiodo = $this->input->get('idperiodo');
        $idgrupo = $this->input->get('idgrupo');
        $idmes = $this->input->get('idmes');
        $query = $this->calificacion->obtenerAsistenciaPreescolar($idperiodo,$idgrupo,$idmes,$idalumno);
        if ($query) {
            $result['asistencias_registradas'] = $this->calificacion->obtenerAsistenciaPreescolar($idperiodo,$idgrupo,$idmes,$idalumno);
        }
        if(isset($result) && !empty($result)){
            echo json_encode($result);
        }
    }
    public  function showAllTiposCalificacionPreescolar (){
        $query = $this->calificacion->allTipoCalificacionPreescolar();
        if ($query) {
            $result['tiposcalificacion'] = $this->calificacion->allTipoCalificacionPreescolar();
        }
        if(isset($result) && !empty($result)){
            echo json_encode($result);
        }
    }
    public  function showAllPeriodos (){
        $idplantel = $this->session->idplantel;
        $query =$this->cicloescolar->showAll($idplantel);
        if ($query) {
            $result['periodos'] = $this->cicloescolar->showAll($idplantel);
        }
        if(isset($result) && !empty($result)){
            echo json_encode($result);
        }
    }
    public  function showAllGrupos (){
        $idplantel = $this->session->idplantel;
        $query = $this->grupo->showAllGrupos($idplantel);
        if ($query) {
            $result['grupos'] = $this->grupo->showAllGrupos($idplantel);
        }
        if(isset($result) && !empty($result)){
            echo json_encode($result);
        }
    }
    public  function showAllMeses (){ 
        $query = $this->calificacion->allMeses();
        if ($query) {
            $result['meses'] = $this->calificacion->allMeses();
        }
        if(isset($result) && !empty($result)){
            echo json_encode($result);
        }
    }
    public  function  searchAlumnos(){
        $idmes = $this->input->get('idmes');
        $idperiodo = $this->input->get('idperiodo');
        $idgrupo = $this->input->get('idgrupo'); 
        $query = $this->calificacion->showAllAlumnosPreescolar($idperiodo,$idgrupo,$idmes);
        if ($query) {
            $result['alumnos'] =$this->calificacion->showAllAlumnosPreescolar($idperiodo,$idgrupo,$idmes);
        }
        if(isset($result) && !empty($result)){
            echo json_encode($result);
        }
    }
    public function addCalificacion() {
         $idperiodo = $this->input->post('idperiodo');
         $idgrupo = $this->input->post('idgrupo');
         $idmes = $this->input->post('idmes');
         $idalumno = $this->input->post('idalumno');
         $materias_calificacion = json_decode($this->input->post('materias_calificacion'));
         
         foreach ($materias_calificacion as $value) {
             $idmateria = $value->idmateria;
             $idtipocalificacion = $value->idcalificacion;
             $data = array(
                 'idperiodo'=>$idperiodo,
                 'idgrupo'=>$idgrupo,
                 'idalumno'=>$idalumno,
                 'idmateriapreescolar'=>$idmateria,
                 'idtipocalificacion'=>$idtipocalificacion,
                 'idmes'=>$idmes,
                 'observacion'=>'',
                 'idusuario' => $this->session->user_id,
                 'fecharegistro' => date('Y-m-d H:i:s'), 
             );
             $this->calificacion->addCalificacionPreescolar($data);
         }
         
    }
    public function deleteCalificacion() {
        
            $id = $this->input->get('id');
            $query = $this->calificacion->daleteCalificacionPreescolar($id);
            if ($query) {
                $result['error'] = false;
            } else {
                $result['error'] = true;
                $result['msg'] = array(
                    'msgerror' => 'No se puede Elimnar la Calificacion.'
                );
            } 
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }
    public function addFaltas() { 
            $config = array(
                array(
                    'field' => 'totalfaltas',
                    'label' => 'Faltas',
                    'rules' => 'trim|required|is_natural',
                    'errors' => array(
                        'required' => 'Campo obligatorio.',
                        'is_natural'=>'Solo numero enteros.'
                    )
                ), 
            );
            
            $this->form_validation->set_rules($config);
            if ($this->form_validation->run() == FALSE) {
                $result['error'] = true;
                $result['msg'] = array( 
                    'totalfaltas' => form_error('totalfaltas')
                );
            } else { 
                $totalfaltas = trim($this->input->post('totalfaltas'));
                $idperiodo = trim($this->input->post('idperiodo'));
                $idalumno = trim($this->input->post('idalumno'));
                $idmes = trim($this->input->post('idmes'));
                $idgrupo = trim($this->input->post('idgrupo'));
                $data = array(
                    'idperiodo' => $idperiodo,
                    'idgrupo' => $idgrupo,
                    'idalumno' => $idalumno,
                    'idmes' => $idmes,
                    'faltas' => $totalfaltas,
                    'idusuario' => $this->session->user_id,
                    'fecharegistro' => date('Y-m-d H:i:s'),
                );
                $this->calificacion->addAsistenciaPreescolar($data);
            }
       
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }
    public function updateFaltas() {
        $config = array(
            array(
                'field' => 'faltas',
                'label' => 'Faltas',
                'rules' => 'trim|required|is_natural',
                'errors' => array(
                    'required' => 'Campo obligatorio.',
                    'is_natural'=>'Solo numero enteros.'
                )
            ),
        );
        
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            $result['error'] = true;
            $result['msg'] = array(
                'faltas' => form_error('faltas')
            );
        } else {
            $faltas = trim($this->input->post('faltas'));
            $id = trim($this->input->post('idasistenciapreescolar'));
            $data = array(
                'faltas' => $faltas,
                'idusuario' => $this->session->user_id,
                'fecharegistro' => date('Y-m-d H:i:s'),
            );
            $this->calificacion->updateFaltas($id,$data);
        }
        
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }
    
    public  function generarExcel($idperiodo,$idgrupo,$idmes) {
            
         $cabezera = array(
         'A', 'B', 'C','D','E', 'F', 'G','H', 'I', 'J','K', 'L', 'M', 'N', 'O','P', 'Q', 'R','S', 'T', 'U','V','W', 'X','Y','Z','AA','AB','AC','AD','AE'
        );
         
        $this->load->library('excel');
        
        $alumnos = $this->calificacion->showAllAlumnosPreescolar($idperiodo, $idgrupo, $idmes);
        $detalle_grupo = $this->calificacion->detalleGrupo($idgrupo);
        $idnivelestudio = $detalle_grupo->idnivelestudio;
        $sheet = $this->excel->getActiveSheet();
        PHPExcel_Shared_Font::setAutoSizeMethod(PHPExcel_Shared_Font::AUTOSIZE_METHOD_EXACT);
        $detalle_logo = $this->alumno->logo($this->session->idplantel);
        $detalle_periodo = $this->calificacion->detallePeriodo($idperiodo);
       
        
        $contador_interno = 0;
        foreach ($alumnos as $alumno) {
            
            $logosecundario = $_SERVER['DOCUMENT_ROOT']  . '/sice/assets/images/escuelas/' . $detalle_logo[0]->logoplantel;
            $logoprincipal = $_SERVER['DOCUMENT_ROOT']  . '/sice/assets/images/escuelas/' . $detalle_logo[0]->logosegundo;
            $banda = $_SERVER['DOCUMENT_ROOT']  . '/sice/assets/images/escuelas/cabezado_preescolar_morelos.png';
            $objDrawing = new PHPExcel_Worksheet_Drawing();    //create object for Worksheet drawing
            $objDrawing->setName('Customer Signature');        //set name to image
            $objDrawing->setDescription('Customer Signature'); //set description to image
            $objDrawing->setPath($logoprincipal);
            $objDrawing->setOffsetX(20);                       //setOffsetX works properly
            $objDrawing->setOffsetY(0);                       //setOffsetY works properly
            $objDrawing->setCoordinates('A2');       //set image to cell
            $objDrawing->setWidth(120);                 //set width, height
            $objDrawing->setHeight(120);
            
            $objDrawing2 = new PHPExcel_Worksheet_Drawing();    //create object for Worksheet drawing
            $objDrawing2->setName('Customer Signature');        //set name to image
            $objDrawing2->setDescription('Customer Signature'); //set description to image
            $objDrawing2->setPath($logosecundario);
            $objDrawing2->setOffsetX(20);                       //setOffsetX works properly
            $objDrawing2->setOffsetY(0);                       //setOffsetY works properly
            $objDrawing2->setCoordinates('Z2');       //set image to cell
            $objDrawing2->setWidth(120);                 //set width, height
            $objDrawing2->setHeight(120);
            
            $objDrawing3 = new PHPExcel_Worksheet_Drawing();    //create object for Worksheet drawing
            $objDrawing3->setName('Customer Signature');        //set name to image
            $objDrawing3->setDescription('Customer Signature'); //set description to image
            $objDrawing3->setPath($banda);
            $objDrawing3->setOffsetX(0);                       //setOffsetX works properly
            //$objDrawing3->setOffsetY(0);                       //setOffsetY works properly
            $objDrawing3->setCoordinates('A8');       //set image to cell
            $objDrawing3->setWidthAndHeight(1050,80);
            $objDrawing3->setResizeProportional(true);
            
      
            $materias = $this->calificacion->allMateriasPreescolarReporte($idnivelestudio);
            $this->excel->setActiveSheetIndex(0);
            $objWorkSheet = $this->excel->createSheet($contador_interno); 
            // Contador de filas
            $contador = 12;
            // Definimos los títulos de la cabecera.
            $style = array(
              'alignment'=> array(
                  'vertical'=>PHPExcel_Style_Alignment::VERTICAL_BOTTOM
              )
            );
            $style_horizontal = array(
                'alignment'=> array(
                    'horizontal'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER
                )
            );
            //COMBINAR CELDAS
            $style_titulo = array(
                'font'  => array(
                    'bold'  => true,
                    //'color' => array('rgb' => 'FF0000'),
                    'size'  => 12,
                    'name'  => 'Century Gothic'
                ),
                'alignment'=> array(
                    'horizontal'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER
                )
            );  
            $style_leyenda = array(
                'font'  => array(
                    'bold'  => true,
                    'color' => array('rgb' => '00B050'),
                    'size'  => 12,
                    'name'  => 'Century Gothic'
                ),
                'alignment'=> array(
                    'horizontal'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER
                )
            );
            
            $style_calificacion = array(
                'font'  => array(
                    'bold'  => true,
                    //'color' => array('rgb' => '00B050'),
                    'size'  => 10,
                    'name'  => 'Century Gothic'
                ),
                'alignment'=> array(
                    'horizontal'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER
                )
            );
            
            $style_institucion = array(
                'font'  => array(
                    'bold'  => true,
                    'color' => array('rgb' => '002060'),
                    'size'  => 12,
                    'name'  => 'Century Gothic'
                ),
                'alignment'=> array(
                    'horizontal'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER
                )
            );
            $style_asignaturas = array(
                'font'  => array(
                    'bold'  => true,
                    //'color' => array('rgb' => 'FF0000'),
                    'size'  => 10,
                    'name'  => 'Century Gothic'
                ),
                'alignment'=> array(
                    'vertical'=>PHPExcel_Style_Alignment::VERTICAL_BOTTOM
                )
            );
            $objWorkSheet->mergeCells("J2:V2");
            $objWorkSheet->mergeCells("J3:V3");
            $objWorkSheet->mergeCells("J4:V4");
            $objWorkSheet->mergeCells("J5:V5");
            $objWorkSheet->mergeCells("J6:V6");
            $objWorkSheet->mergeCells("J7:V7");
            $objWorkSheet->setCellValue("J2", '“VALOR Y CONFIANZA”');
            $objWorkSheet->setCellValue("J3", 'INSTITUTO MORELOS');
            $objWorkSheet->setCellValue("J4", 'PREESCOLAR 09PJN0142A');
            $objWorkSheet->setCellValue("J5", 'ACUERDO 09060267');
            $objWorkSheet->setCellValue("J6", '135 AÑOS DE CALIDAD EDUCATIVA ACREDITADO POR LA CNEP');
            $objWorkSheet->setCellValue("J7", 'CICLO ESCOLAR '.$detalle_periodo->yearinicio.' - '.$detalle_periodo->yearfin);
            $objWorkSheet->getStyle("J2")->applyFromArray($style_titulo);
            $objWorkSheet->getStyle("J3")->applyFromArray($style_institucion);
            $objWorkSheet->getStyle("J4")->applyFromArray($style_titulo);
            $objWorkSheet->getStyle("J5")->applyFromArray($style_titulo);
            $objWorkSheet->getStyle("J6")->applyFromArray($style_leyenda); 
            $objWorkSheet->getStyle('J7')->applyFromArray($style_titulo);
            $objWorkSheet->getStyle('J2')->applyFromArray($style_titulo);
            
            
            $objWorkSheet->mergeCells("A10:B10");
            $objWorkSheet->setCellValue("A10", 'ALUMNO(A):');
            $objWorkSheet->mergeCells("C10:V10");
            $objWorkSheet->setCellValue("C10", $alumno->nombrealumno);
            $objWorkSheet->getStyle("A10")->getFont()->setBold(true);
            $objWorkSheet->getStyle("C10")->getFont()->setBold(true);
            $objWorkSheet->getStyle('C10')->getFont()->setUnderline(true);
            
           
            $objWorkSheet->getStyle("A12:AC12")->applyFromArray($style_asignaturas);
            $objWorkSheet->getStyle("A12:AC12")->getAlignment()->setTextRotation(90);
            $objWorkSheet->getStyle("A12:AC12")->getAlignment()->setWrapText(true);
            $objWorkSheet->getRowDimension("12")->setRowHeight(150);
            $objWorkSheet->getColumnDimension("B")->setWidth(7);
            $objWorkSheet->getColumnDimension("C")->setWidth(5);
            $objWorkSheet->getColumnDimension("D")->setWidth(5);
            $objWorkSheet->getColumnDimension("E")->setWidth(5);
            $objWorkSheet->getColumnDimension("F")->setWidth(5);
            $objWorkSheet->getColumnDimension("G")->setWidth(5);
            $objWorkSheet->getColumnDimension("H")->setWidth(5);
            $objWorkSheet->getColumnDimension("I")->setWidth(5);
            $objWorkSheet->getColumnDimension("J")->setWidth(5);
            $objWorkSheet->getColumnDimension("K")->setWidth(7);
            $objWorkSheet->getColumnDimension("L")->setWidth(5);
            $objWorkSheet->getColumnDimension("M")->setWidth(5);
            $objWorkSheet->getColumnDimension("N")->setWidth(5);
            $objWorkSheet->getColumnDimension("O")->setWidth(5);
            $objWorkSheet->getColumnDimension("P")->setWidth(5);
            $objWorkSheet->getColumnDimension("Q")->setWidth(5);
            $objWorkSheet->getColumnDimension("R")->setWidth(5);
            $objWorkSheet->getColumnDimension("S")->setWidth(5);
            $objWorkSheet->getColumnDimension("T")->setWidth(7);
            $objWorkSheet->getColumnDimension("U")->setWidth(5);
            $objWorkSheet->getColumnDimension("V")->setWidth(5);
            $objWorkSheet->getColumnDimension("W")->setWidth(5);
            $objWorkSheet->getColumnDimension("X")->setWidth(5);
            $objWorkSheet->getColumnDimension("Y")->setWidth(5);
            $objWorkSheet->getColumnDimension("Z")->setWidth(5);
            $objWorkSheet->getColumnDimension("AA")->setWidth(5);
            $objWorkSheet->getColumnDimension("AB")->setWidth(5);
            $objWorkSheet->getColumnDimension("AC")->setWidth(5); 
            //$objWorkSheet->getStyle("A12:AC12")->getFont()->setBold(true); 
            
           
            
            if ($idnivelestudio == 1){
            $objWorkSheet->setCellValue("A{$contador}");
            $objWorkSheet->setCellValue("B{$contador}", 'Área de Desarrollo  Personal Y Social');
            $objWorkSheet->setCellValue("C{$contador}", 'Autonomía');
            $objWorkSheet->setCellValue("D{$contador}", 'Socialización');
            $objWorkSheet->setCellValue("E{$contador}", 'Filosofía infantil');
            $objWorkSheet->setCellValue("F{$contador}", 'Cantos y Juegos');
            $objWorkSheet->setCellValue("G{$contador}", 'Psicomotricidad');
            $objWorkSheet->setCellValue("H{$contador}", 'Danza');
            $objWorkSheet->setCellValue("I{$contador}", 'Educación Física');
            $objWorkSheet->setCellValue("J{$contador}", 'Conducta');
            $objWorkSheet->setCellValue("K{$contador}", 'Campos de Formación Académica ');
            $objWorkSheet->setCellValue("L{$contador}", 'Lenguaje Oral');
            $objWorkSheet->setCellValue("M{$contador}", 'Lenguaje Escrito');
            $objWorkSheet->setCellValue("N{$contador}", 'Número');
            $objWorkSheet->setCellValue("O{$contador}", 'Ubicación Espacial');
            $objWorkSheet->setCellValue("P{$contador}", 'Forma y Medida');
            $objWorkSheet->setCellValue("Q{$contador}", 'Inglés');
            $objWorkSheet->setCellValue("R{$contador}", 'Mundo Natural');
            $objWorkSheet->setCellValue("S{$contador}", 'Cultura y Vida Social');
            $objWorkSheet->setCellValue("T{$contador}", 'Ambitos de autonomía Curricular');
            $objWorkSheet->setCellValue("U{$contador}", 'Computación'); 
            $objWorkSheet->setCellValue("V{$contador}", 'Apoyo en el aprendizaje');
            $objWorkSheet->setCellValue("W{$contador}", 'Puntualidad');
            $objWorkSheet->setCellValue("X{$contador}", 'Uniforme');
            $objWorkSheet->setCellValue("Y{$contador}", 'Participación');
            $objWorkSheet->setCellValue("Z{$contador}", 'Tareas');
            $objWorkSheet->setCellValue("AA{$contador}", 'Faltas');
            $objWorkSheet->setCellValue("AB{$contador}", 'Promedio Mensual');
        }else{
            $objWorkSheet->setCellValue("A{$contador}");
            $objWorkSheet->setCellValue("B{$contador}", 'Área de Desarrollo  Personal Y Social');
            $objWorkSheet->setCellValue("C{$contador}", 'Autonomía');
            $objWorkSheet->setCellValue("D{$contador}", 'Socialización');
            $objWorkSheet->setCellValue("E{$contador}", 'Filosofía infantil');
            $objWorkSheet->setCellValue("F{$contador}", 'Cantos y Juegos');
            $objWorkSheet->setCellValue("G{$contador}", 'Psicomotricidad');
            $objWorkSheet->setCellValue("H{$contador}", 'Danza');
            $objWorkSheet->setCellValue("I{$contador}", 'Educación Física');
            $objWorkSheet->setCellValue("J{$contador}", 'Conducta');
            $objWorkSheet->setCellValue("K{$contador}", 'Campos de Formación Académica ');
            $objWorkSheet->setCellValue("L{$contador}", 'Lenguaje Oral');
            $objWorkSheet->setCellValue("M{$contador}", 'Lenguaje Escrito');
            $objWorkSheet->setCellValue("N{$contador}", 'Número');
            $objWorkSheet->setCellValue("O{$contador}", 'Ubicación Espacial');
            $objWorkSheet->setCellValue("P{$contador}", 'Forma y Medida');
            $objWorkSheet->setCellValue("Q{$contador}", 'Inglés');
            $objWorkSheet->setCellValue("R{$contador}", 'Mundo Natural');
            $objWorkSheet->setCellValue("S{$contador}", 'Cultura y Vida Social');
            $objWorkSheet->setCellValue("T{$contador}", 'Ambitos de autonomía Curricular');
            $objWorkSheet->setCellValue("U{$contador}", 'Computación');
            $objWorkSheet->setCellValue("V{$contador}", 'Robótica');
            $objWorkSheet->setCellValue("W{$contador}", 'Apoyo en el aprendizaje');
            $objWorkSheet->setCellValue("X{$contador}", 'Puntualidad');
            $objWorkSheet->setCellValue("Y{$contador}", 'Uniforme');
            $objWorkSheet->setCellValue("Z{$contador}", 'Participación');
            $objWorkSheet->setCellValue("AA{$contador}", 'Tareas');
            $objWorkSheet->setCellValue("AB{$contador}", 'Faltas');
            $objWorkSheet->setCellValue("AC{$contador}", 'Promedio Mensual');
        }
            $idalumno = $alumno->idalumno;
           
           
            $meses = $this->calificacion->allMeses();
            if ($meses) {
                foreach ($meses as $opcion) {
                    $idmes = $opcion->idmes;
                    $contador ++;
                        $objWorkSheet->getStyle("A{$contador}")->getFont()->setBold(true); 
                    // Incrementamos una fila más, para ir a la siguiente.
                   
                    $objWorkSheet->setCellValue("A{$contador}", $opcion->nombremes);
                    foreach ($materias as $materia){
                        $idmateria = $materia->idmateriapreescolar;
                        if ($idmateria == 26) {
                            $result = $this->calificacion->obtenerFaltasPreescolar($idperiodo,$idgrupo,$idalumno,$idmes);
                            if($result){
                                $objWorkSheet->setCellValue("AA{$contador}", $result->faltas);
                            } 
                        }
                        
                        $row = $this->calificacion->obtenerCalificacionPreescolar($idperiodo, $idgrupo, $idalumno,$idmes,$idmateria);
                        // Informacion de las filas de la consulta.
                        if ($row){
                        if ($row->idmateriapreescolar == 1) {
                            $objWorkSheet->setCellValue("B{$contador}", $row->abreviatura);
                            $objWorkSheet->getStyle("B{$contador}")->applyFromArray($style_calificacion);
                            
                        }
                        if ($row->idmateriapreescolar == 2) {
                            $objWorkSheet->setCellValue("C{$contador}", $row->abreviatura);
                            $objWorkSheet->getStyle("C{$contador}")->applyFromArray($style_calificacion);
                        }
                        if ($row->idmateriapreescolar == 3) {
                            $objWorkSheet->setCellValue("D{$contador}", $row->abreviatura);
                            $objWorkSheet->getStyle("D{$contador}")->applyFromArray($style_calificacion);
                        }
                        if ($row->idmateriapreescolar == 4) {
                            $objWorkSheet->setCellValue("E{$contador}", $row->abreviatura);
                            $objWorkSheet->getStyle("E{$contador}")->applyFromArray($style_calificacion);
                        }
                        if ($row->idmateriapreescolar == 5) {
                            $objWorkSheet->setCellValue("F{$contador}", $row->abreviatura);
                            $objWorkSheet->getStyle("F{$contador}")->applyFromArray($style_calificacion);
                        }
                        if ($row->idmateriapreescolar == 6) {
                            $objWorkSheet->setCellValue("G{$contador}", $row->abreviatura);
                            $objWorkSheet->getStyle("G{$contador}")->applyFromArray($style_calificacion);
                        }
                        if ($row->idmateriapreescolar == 7) {
                            $objWorkSheet->setCellValue("H{$contador}", $row->abreviatura);
                            $objWorkSheet->getStyle("H{$contador}")->applyFromArray($style_calificacion);
                        }
                        if ($row->idmateriapreescolar == 8) {
                            $objWorkSheet->setCellValue("I{$contador}", $row->abreviatura);
                            $objWorkSheet->getStyle("I{$contador}")->applyFromArray($style_calificacion);
                        }
                        if ($row->idmateriapreescolar == 9) {
                            $objWorkSheet->setCellValue("J{$contador}", $row->abreviatura);
                            $objWorkSheet->getStyle("J{$contador}")->applyFromArray($style_calificacion);
                        }
                        if ($row->idmateriapreescolar == 10) {
                            $objWorkSheet->setCellValue("K{$contador}", $row->abreviatura);
                            $objWorkSheet->getStyle("K{$contador}")->applyFromArray($style_calificacion);
                        }
                        if ($row->idmateriapreescolar == 11) {
                            $objWorkSheet->setCellValue("L{$contador}", $row->abreviatura);
                            $objWorkSheet->getStyle("L{$contador}")->applyFromArray($style_calificacion);
                        }
                        if ($row->idmateriapreescolar == 12) {
                            $objWorkSheet->setCellValue("M{$contador}", $row->abreviatura);
                            $objWorkSheet->getStyle("M{$contador}")->applyFromArray($style_calificacion);
                        }
                        if ($row->idmateriapreescolar == 13) {
                            $objWorkSheet->setCellValue("N{$contador}", $row->abreviatura);
                            $objWorkSheet->getStyle("N{$contador}")->applyFromArray($style_calificacion);
                        }
                        if ($row->idmateriapreescolar == 14) {
                            $objWorkSheet->setCellValue("O{$contador}", $row->abreviatura);
                            $objWorkSheet->getStyle("O{$contador}")->applyFromArray($style_calificacion);
                        }
                        if ($row->idmateriapreescolar == 15) {
                            $objWorkSheet->setCellValue("P{$contador}", $row->abreviatura);
                            $objWorkSheet->getStyle("P{$contador}")->applyFromArray($style_calificacion);
                        }
                        if ($row->idmateriapreescolar == 16) {
                            $objWorkSheet->setCellValue("Q{$contador}", $row->abreviatura);
                            $objWorkSheet->getStyle("Q{$contador}")->applyFromArray($style_calificacion);
                        }
                        if ($row->idmateriapreescolar == 17) {
                            $objWorkSheet->setCellValue("R{$contador}", $row->abreviatura);
                            $objWorkSheet->getStyle("R{$contador}")->applyFromArray($style_calificacion);
                        }
                        if ($row->idmateriapreescolar == 18) {
                            $objWorkSheet->setCellValue("S{$contador}", $row->abreviatura);
                            $objWorkSheet->getStyle("S{$contador}")->applyFromArray($style_calificacion);
                        }
                        if ($row->idmateriapreescolar == 19) {
                            $objWorkSheet->setCellValue("T{$contador}", $row->abreviatura);
                            $objWorkSheet->getStyle("T{$contador}")->applyFromArray($style_calificacion);
                        }
                        if ($row->idmateriapreescolar == 20) {
                            $objWorkSheet->setCellValue("U{$contador}", $row->abreviatura);
                            $objWorkSheet->getStyle("U{$contador}")->applyFromArray($style_calificacion);
                        }
                        
                        if ($idnivelestudio == 1){ 
                            if ($row->idmateriapreescolar == 21) {
                                $objWorkSheet->setCellValue("V{$contador}", $row->abreviatura);
                                $objWorkSheet->getStyle("V{$contador}")->applyFromArray($style_calificacion);
                            }
                            if ($row->idmateriapreescolar == 22) {
                                $objWorkSheet->setCellValue("W{$contador}", $row->abreviatura);
                                $objWorkSheet->getStyle("W{$contador}")->applyFromArray($style_calificacion);
                            }
                            if ($row->idmateriapreescolar == 23) {
                                $objWorkSheet->setCellValue("X{$contador}", $row->abreviatura);
                                $objWorkSheet->getStyle("X{$contador}")->applyFromArray($style_calificacion);
                            }
                            if ($row->idmateriapreescolar == 24) {
                                $objWorkSheet->setCellValue("Y{$contador}", $row->abreviatura);
                                $objWorkSheet->getStyle("Y{$contador}")->applyFromArray($style_calificacion);
                            }
                            if ($row->idmateriapreescolar == 25) {
                                $objWorkSheet->setCellValue("Z{$contador}", $row->abreviatura);
                                $objWorkSheet->getStyle("Z{$contador}")->applyFromArray($style_calificacion);
                            }
                         
                            if ($row->idmateriapreescolar == 28) {
                                $objWorkSheet->setCellValue("AB{$contador}", $row->abreviatura);
                                $objWorkSheet->getStyle("AB{$contador}")->applyFromArray($style_calificacion);
                            }
                        }else {
                            if ($row->idmateriapreescolar == 27) {
                                $objWorkSheet->setCellValue("V{$contador}", $row->abreviatura);
                                $objWorkSheet->getStyle("V{$contador}")->applyFromArray($style_calificacion);
                            }
                            if ($row->idmateriapreescolar == 21) {
                                $objWorkSheet->setCellValue("W{$contador}", $row->abreviatura);
                                $objWorkSheet->getStyle("W{$contador}")->applyFromArray($style_calificacion);
                            }
                            if ($row->idmateriapreescolar == 22) {
                                $objWorkSheet->setCellValue("X{$contador}", $row->abreviatura);
                                $objWorkSheet->getStyle("X{$contador}")->applyFromArray($style_calificacion);
                            }
                            if ($row->idmateriapreescolar == 23) {
                                $objWorkSheet->setCellValue("Y{$contador}", $row->abreviatura);
                                $objWorkSheet->getStyle("V{$contador}")->applyFromArray($style_calificacion);
                            }
                            if ($row->idmateriapreescolar == 24) {
                                $objWorkSheet->setCellValue("Z{$contador}", $row->abreviatura);
                                $objWorkSheet->getStyle("Z{$contador}")->applyFromArray($style_calificacion);
                            }
                            if ($row->idmateriapreescolar == 25) {
                                $objWorkSheet->setCellValue("AA{$contador}", $row->abreviatura);
                                $objWorkSheet->getStyle("AA{$contador}")->applyFromArray($style_calificacion);
                            }
                            if ($row->idmateriapreescolar == 26) {
                                $result = $this->calificacion->obtenerFaltasPreescolar($idperiodo,$idgrupo,$idalumno,$idmes);
                                if($result){
                                    $objWorkSheet->setCellValue("AB{$contador}", $result->faltas);
                                    $objWorkSheet->getStyle("AB{$contador}")->applyFromArray($style_calificacion);
                                }else{
                                    $objWorkSheet->setCellValue("AB{$contador}", '0');
                                    $objWorkSheet->getStyle("AB{$contador}")->applyFromArray($style_calificacion);
                                }
                            }
                            if ($row->idmateriapreescolar == 28) {
                                $objWorkSheet->setCellValue("AC{$contador}", $row->abreviatura);
                                $objWorkSheet->getStyle("AC{$contador}")->applyFromArray($style_calificacion);
                            }
                        }
                        
                       
                     }
                    }
                   
                }
            }
            
            $objDrawing->setWorksheet( $this->excel->getActiveSheet());
            $objDrawing2->setWorksheet( $this->excel->getActiveSheet());
            $objDrawing3->setWorksheet( $this->excel->getActiveSheet());
            
            $objWorkSheet->setTitle($alumno->nombre );
        }

         $archivo = "Reporte de Calificaciones Preescolar {$idperiodo}.xls";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $archivo . '"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5'); 
        $objWriter->save('php://output');  
    }
}
