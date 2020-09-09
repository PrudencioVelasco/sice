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
        $this->load->model('alumno_model', 'alumno');
        $this->load->model('grupo_model', 'grupo');
        $this->load->library('permission');
        $this->load->library('session');
    }

    public function inicio() {
        $idplantel = $this->session->idplantel; 
        $data = array(
            'periodos'=> $this->cicloescolar->showAll($idplantel),
            'grupos'=> $this->grupo->showAllGrupos($idplantel),
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
    public  function  buscarCursos(){
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
    public  function buscarAsistencia($idperiodo = '',$idgrupo = '',$idcurso='',$tiporeporte='',$fechainicio='',$fechafin = ''){
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
        if($tiporeporte == 4){
            $tabla = $this->obtenerCalificacion($idclicloescolar, $idgrupo);
        }
        if($tiporeporte == 2){
            $tabla = $this->obtenerCalificacionFinal($idclicloescolar, $idgrupo);
        }
        $data = array(
            'tabla'=>$tabla,
            'periodos'=> $this->cicloescolar->showAll($idplantel),
            'grupos'=> $this->grupo->showAllGrupos($idplantel),
        );
        $this->load->view('admin/header');
        $this->load->view('admin/catalogo/calificaciones/resultado', $data);
        $this->load->view('admin/footer');
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
                        //No se le muestra la materia porque la reprobo y estaba seriada
                        
                    }else{
                        $valor_calificacion = $this->calificacion->obtenerCalificacionSumatoria($idalumno,$idmateria,$idperiodo);
                        
                        //Se refleja la metaria para sacar el promedio
                        if(isset($valor_calificacion) && !empty($valor_calificacion)){
                            $suma_recorrido = 0;
                            foreach ($valor_calificacion as $row_ca){
                                if($suma_recorrido == 0){
                                    $suma_calificacion_materias = $row_ca->calificacion;
                                    $total_materias++;
                                }
                                $suma_recorrido = 1;
                            }
                        }else{
                            $total_materias++; 
                        }
                        
                    }
                    
                    $materias_reprobadas = $this->calificacion->listaMateriasReprobadas($idalumno,$idperiodo);
                    if(isset($materias_reprobadas) && !empty($materias_reprobadas)){
                        foreach ($materias_reprobadas as $value) {
                            $idhorario_reprobada = $value->idhorario;
                            $idprofesormateria = $value->idprofesormateria;
                            $calificacion_reprobados = $this->calificacion->obtenerCalificacionSumatoria($idalumno,$idprofesormateria,$idhorario_reprobada);
                            
                            if(isset($calificacion_reprobados) && !empty($calificacion_reprobados)){
                                $suma_recorrido_reprobados = 0;
                                foreach ($valor_calificacion as $row_ca_rep){
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
    public function obtenerCalificacion($idperiodo,$idgrupo) {
        $idplantel = $this->session->idplantel;
         $alumnos = $this->calificacion->listaAlumnos($idgrupo,$idplantel,$idperiodo);
        $materias = $this->calificacion->listaMateriasGrupo($idgrupo,$idplantel,$idperiodo);
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
                $tabla .= '<tr>';
                $tabla .= '  <td>' . $c++ . '</td>'; 
                $tabla .= '<td>' . $row->apellidop . " " . $row->apellidom . " " . $row->nombre . '</td>';
               
                $suma_recorrido = 0;
                if (isset($materias) && !empty($materias)){
                foreach ($materias as $block) { 
                    $idmateria = $block->idmateriareal;
                    $validar_materia_reprobada = $this->calificacion->validarMateriaReprobada($idalumno,$idmateria);
                    $tabla .= '<td>'; 
                    if($validar_materia_reprobada){
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
                     
                    }
                
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
        $query = $this->calificacion->allMateriasPreescolar(); 
        if ($query) {
            $result['materias'] = $this->calificacion->allMateriasPreescolar();
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
    public function  searchAlumnos(){
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
    public  function generarExcel() {
            
         $cabezera = array(
         'A', 'B', 'C','D','E', 'F', 'G','H', 'I', 'J','K', 'L', 'M', 'N', 'O','P', 'Q', 'R','S', 'T', 'U','V','W', 'X','Y','Z','AA','AB','AC','AD','AE'
        );
         
        $this->load->library('excel');
        $idmes = 1;
        $idperiodo = 10;
        $idgrupo = 31;
        $alumnos = $this->calificacion->showAllAlumnosPreescolar($idperiodo, $idgrupo, $idmes);
        $sheet = $this->excel->getActiveSheet();
        PHPExcel_Shared_Font::setAutoSizeMethod(PHPExcel_Shared_Font::AUTOSIZE_METHOD_EXACT);
        $contador_interno = 0;
        foreach ($alumnos as $alumno) {
        
            $this->excel->setActiveSheetIndex(0);
            $objWorkSheet = $this->excel->createSheet($contador_interno);
            // $objPHPExcel = $this->excel->addSheet($objWorkSheet);

            //$objWorkSheet->setTitle('Listado de Alumnos');
            // Contador de filas
            $contador = 1;
            // Definimos los títulos de la cabecera.
            $style = array(
              'alignment'=> array(
                  'vertical'=>PHPExcel_Style_Alignment::VERTICAL_BOTTOM
              )
            );
            $objWorkSheet->getStyle("A1:AC1")->applyFromArray($style);
            $objWorkSheet->getStyle("A1:AC1")->getAlignment()->setTextRotation(90);
            $objWorkSheet->getStyle("A1:AC1")->getAlignment()->setWrapText(true);
            $objWorkSheet->getRowDimension("1")->setRowHeight(150);
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
             $objWorkSheet->getStyle("A1:AC1")->getFont()->setBold(true); 

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
            $idalumno = $alumno->idalumno;
           
            $materias = $this->calificacion->allMateriasPreescolar();
            $meses = $this->calificacion->allMeses();
            if ($meses) {
                foreach ($meses as $opcion) {
                    $idmes = $opcion->idmes;
                        $objWorkSheet->getStyle("A{$contador}")->getFont()->setBold(true); 
                    // Incrementamos una fila más, para ir a la siguiente.
                    $contador ++;
                    $objWorkSheet->setCellValue("A{$contador}", $opcion->nombremes);
                    foreach ($materias as $materia){
                        $idmateria = $materia->idmateriapreescolar;
                        $row = $this->calificacion->obtenerCalificacionPreescolar($idperiodo, $idgrupo, $idalumno,$idmes,$idmateria);
                        // Informacion de las filas de la consulta.
                        if ($row){
                        if ($row->idmateriapreescolar == 1) {
                            $objWorkSheet->setCellValue("B{$contador}", $row->abreviatura);
                        }
                        if ($row->idmateriapreescolar == 2) {
                            $objWorkSheet->setCellValue("C{$contador}", $row->abreviatura);
                        }
                        if ($row->idmateriapreescolar == 3) {
                            $objWorkSheet->setCellValue("D{$contador}", $row->abreviatura);
                        }
                        if ($row->idmateriapreescolar == 4) {
                            $objWorkSheet->setCellValue("E{$contador}", $row->abreviatura);
                        }
                        if ($row->idmateriapreescolar == 5) {
                            $objWorkSheet->setCellValue("F{$contador}", $row->abreviatura);
                        }
                        if ($row->idmateriapreescolar == 6) {
                            $objWorkSheet->setCellValue("G{$contador}", $row->abreviatura);
                        }
                        if ($row->idmateriapreescolar == 7) {
                            $objWorkSheet->setCellValue("H{$contador}", $row->abreviatura);
                        }
                        if ($row->idmateriapreescolar == 8) {
                            $objWorkSheet->setCellValue("I{$contador}", $row->abreviatura);
                        }
                        if ($row->idmateriapreescolar == 9) {
                            $objWorkSheet->setCellValue("J{$contador}", $row->abreviatura);
                        }
                        if ($row->idmateriapreescolar == 10) {
                            $objWorkSheet->setCellValue("K{$contador}", $row->abreviatura);
                        }
                        if ($row->idmateriapreescolar == 11) {
                            $objWorkSheet->setCellValue("L{$contador}", $row->abreviatura);
                        }
                        if ($row->idmateriapreescolar == 12) {
                            $objWorkSheet->setCellValue("M{$contador}", $row->abreviatura);
                        }
                        if ($row->idmateriapreescolar == 13) {
                            $objWorkSheet->setCellValue("N{$contador}", $row->abreviatura);
                        }
                        if ($row->idmateriapreescolar == 14) {
                            $objWorkSheet->setCellValue("O{$contador}", $row->abreviatura);
                        }
                        if ($row->idmateriapreescolar == 15) {
                            $objWorkSheet->setCellValue("P{$contador}", $row->abreviatura);
                        }
                        if ($row->idmateriapreescolar == 16) {
                            $objWorkSheet->setCellValue("Q{$contador}", $row->abreviatura);
                        }
                        if ($row->idmateriapreescolar == 17) {
                            $objWorkSheet->setCellValue("R{$contador}", $row->abreviatura);
                        }
                        if ($row->idmateriapreescolar == 18) {
                            $objWorkSheet->setCellValue("S{$contador}", $row->abreviatura);
                        }
                        if ($row->idmateriapreescolar == 19) {
                            $objWorkSheet->setCellValue("T{$contador}", $row->abreviatura);
                        }
                        if ($row->idmateriapreescolar == 20) {
                            $objWorkSheet->setCellValue("U{$contador}", $row->abreviatura);
                        }
                        if ($row->idmateriapreescolar == 27) {
                            $objWorkSheet->setCellValue("V{$contador}", $row->abreviatura);
                        }
                        if ($row->idmateriapreescolar == 21) {
                            $objWorkSheet->setCellValue("W{$contador}", $row->abreviatura);
                        }
                        if ($row->idmateriapreescolar == 22) {
                            $objWorkSheet->setCellValue("X{$contador}", $row->abreviatura);
                        }
                        if ($row->idmateriapreescolar == 23) {
                            $objWorkSheet->setCellValue("Y{$contador}", $row->abreviatura);
                        }
                        if ($row->idmateriapreescolar == 24) {
                            $objWorkSheet->setCellValue("Z{$contador}", $row->abreviatura);
                        }
                        if ($row->idmateriapreescolar == 25) {
                            $objWorkSheet->setCellValue("AA{$contador}", $row->abreviatura);
                        }
                        if ($row->idmateriapreescolar == 26) {
                            $objWorkSheet->setCellValue("AB{$contador}", $row->abreviatura);
                        }
                        if ($row->idmateriapreescolar == 28) {
                            $objWorkSheet->setCellValue("AC{$contador}", $row->abreviatura);
                        }
                     }
                    }
                   
                }
            }
           
            $objWorkSheet->setTitle( $alumno->nombrealumno);
        }

        $archivo = "Lista de Alumnos {$idperiodo}.xls";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $archivo . '"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        // Hacemos una salida al navegador con el archivo Excel.
        $objWriter->save('php://output');
    }
}
