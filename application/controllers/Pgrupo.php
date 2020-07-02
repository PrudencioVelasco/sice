<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("America/Mexico_City");
class pGrupo extends CI_Controller {
 
  function __construct() {
        parent::__construct(); 
       if (!isset($_SESSION['user_id'])) {
            $this->session->set_flashdata('flash_data', 'You don\'t have access! ss');
            return redirect('welcome');
        }
        $this->load->helper('url');  
        $this->load->library('permission');
        $this->load->library('session'); 
        $this->load->model('grupo_model','grupo'); 
        $this->load->model('mensaje_model','mensaje'); 
        $this->load->library('encryption');
        $this->load->helper('numeroatexto_helper');
        date_default_timezone_set("America/Mexico_City");

    }
 
        function encode($string)
        {
            $encrypted = $this->encryption->encrypt($string);
            if ( !empty($string) )
            {
                $encrypted = strtr($encrypted, array('/' => '~'));
            }
            return $encrypted;
        }

        function decode($string)
        {
            $string = strtr($string, array('~' => '/'));
            return $this->encryption->decrypt($string);
        } 

    public function index()
    {
        # code...
       Permission::grant(uri_string()); 
      
        $result = $this->grupo->showAllGruposProfesor($this->session->idprofesor);
          $unidades = $this->grupo->unidades();
       // var_dump($result);
        $data = array(
            'datos'=>$result,
            'unidades'=>$unidades,
            'controller'=>$this
        );
        $this->load->view('docente/header');
        $this->load->view('docente/grupo/index',$data);
        $this->load->view('docente/footer');

    }

    public function buscarAsistencia($idhorario,$idhorariodetalle,$fechainicio,$fechafin,$idunidad)
    {
        # code...
         Permission::grant(uri_string());
        $idhorario = $this->decode($idhorario);
        //$idunidad = $this->input->post('unidad');
        $idhorariodetalle =$this->decode($idhorariodetalle);
        //$fechainicio = $this->input->post('fechainicio');
        //$fechafin = $this->input->post('fechafin');
        if((isset($idhorario) && !empty($idhorario)) &&
        (isset($idhorario) && !empty($idhorario)) &&
        (isset($fechainicio) && !empty($fechainicio)) &&
        (isset($fechafin) && !empty($fechafin))  ){ 
        $alumns = $this->grupo->alumnosGrupo($idhorario);
         $tabla = ""; 
         if($alumns != false){
        $range= ((strtotime($fechafin)-strtotime($fechainicio))+(24*60*60)) /(24*60*60);
        //$range= ((strtotime($_GET["finish_at"])-strtotime($_GET["start_at"]))+(24*60*60)) /(24*60*60);
        
         $tabla .= '  <table id="tablageneral2" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
            <thead>
            <th>#</th>
            <th>Nombre</th>';
            for($i=0;$i<$range;$i++):
         setlocale(LC_ALL, 'es_ES');
            $fecha = strftime("%A, %d de %B", strtotime($fechainicio)+($i*(24*60*60)));
 $domingo = date('N',strtotime($fechainicio)+($i*(24*60*60)));
            if($domingo != '7' ){
                 if($domingo != '6' ){
                    $tabla .= '<th>'. utf8_encode($fecha).'</th>';
                 }
            }
           //echo date("d-M",strtotime($_GET["start_at"])+($i*(24*60*60)));
           endfor;
           $tabla .= '</thead>';
            $n = 1;
            foreach($alumns as $alumn){  
               $tabla .= ' <tr>';
               $tabla .='<td>'.$n++.'</td>';
                $tabla .= '<td >'.$alumn->apellidop." ".$alumn->apellidom." ".$alumn->nombre.'</td>';
             for($i=0;$i<$range;$i++):
                    $date_at= date("Y-m-d",strtotime($fechainicio)+($i*(24*60*60)));
                   // $asist = AssistanceData::getByATD($alumn->id,$_GET["team_id"],$date_at);
                    $asist = $this->grupo->listaAsistencia($alumn->idalumno,$idhorario,$date_at,$idhorariodetalle,$idunidad);
                          $domingo = date('N',strtotime($fechainicio)+($i*(24*60*60))); 

 if($domingo != '7' ){
                      if($domingo != '6' ){
                $tabla .= '<td>';
                 if($asist != false){ 
                      switch ($asist->idmotivo) {
                          case 1:
                              # code...
                             $tabla .='<span class="label label-success">'.$asist->nombremotivo.'</span>';
                             $tabla .='  <a  href="javascript:void(0)"><i class="fa fa-pencil edit_button"  data-toggle="modal" data-target="#myModal"
                                data-idasistencia="'.$asist->idasistencia.'"
                                data-idmotivo="'.$asist->idmotivo.'"
                                data-alumno="'.$alumn->apellidop." ".$alumn->apellidom." ".$alumn->nombre.'"
                               style = "color:blue;" title="Editar Calificación"></i> </a>';
                                /*$tabla .=' <a  href="javascript:void(0)"><i class="fa fa-trash delete_button"  data-toggle="modal" data-target="#myModalDelete"
                                data-idasistencia="'.$asist->idasistencia.'"
                                data-idmotivo="'.$asist->idmotivo.'"
                                data-alumno="'.$alumn->apellidop." ".$alumn->apellidom." ".$alumn->nombre.'"
                               style = "color:red;" title="Eliminar Calificación"></i> </a>';*/ 
                            break;
                                  case 2:
                                  $tabla .='<span class="label label-warning">'.$asist->nombremotivo.'</span>';
                                  $tabla .='  <a  href="javascript:void(0)"><i class="fa fa-pencil edit_button"  data-toggle="modal" data-target="#myModal"
                                  data-idasistencia="'.$asist->idasistencia.'"
                                  data-idmotivo="'.$asist->idmotivo.'"
                                  data-alumno="'.$alumn->apellidop." ".$alumn->apellidom." ".$alumn->nombre.'"
                                 style = "color:blue;" title="Editar Calificación"></i> </a>';
                                 /* $tabla .=' <a  href="javascript:void(0)"><i class="fa fa-trash delete_button"  data-toggle="modal" data-target="#myModalDelete"
                                  data-idasistencia="'.$asist->idasistencia.'"
                                  data-idmotivo="'.$asist->idmotivo.'"
                                  data-alumno="'.$alumn->apellidop." ".$alumn->apellidom." ".$alumn->nombre.'"
                                 style = "color:red;" title="Eliminar Calificación"></i> </a>';*/
                                  # code...
                              break;
                                  case 3:
                                  $tabla .='<span class="label label-info">'.$asist->nombremotivo.'</span>';
                                  $tabla .='  <a  href="javascript:void(0)"><i class="fa fa-pencil edit_button"  data-toggle="modal" data-target="#myModal"
                                  data-idasistencia="'.$asist->idasistencia.'"
                                  data-idmotivo="'.$asist->idmotivo.'"
                                  data-alumno="'.$alumn->apellidop." ".$alumn->apellidom." ".$alumn->nombre.'"
                                 style = "color:blue;" title="Editar Calificación"></i> </a>';
                                 /* $tabla .=' <a  href="javascript:void(0)"><i class="fa fa-trash delete_button"  data-toggle="modal" data-target="#myModalDelete"
                                  data-idasistencia="'.$asist->idasistencia.'"
                                  data-idmotivo="'.$asist->idmotivo.'"
                                  data-alumno="'.$alumn->apellidop." ".$alumn->apellidom." ".$alumn->nombre.'"
                                 style = "color:red;" title="Eliminar Calificación"></i> </a>';*/
                                  # code...
                              break;
                                  case 4:
                                  $tabla .='<span class="label label-danger">'.$asist->nombremotivo.'</span>';
                                  $tabla .='  <a  href="javascript:void(0)"><i class="fa fa-pencil edit_button"  data-toggle="modal" data-target="#myModal"
                                  data-idasistencia="'.$asist->idasistencia.'"
                                  data-idmotivo="'.$asist->idmotivo.'"
                                  data-alumno="'.$alumn->apellidop." ".$alumn->apellidom." ".$alumn->nombre.'"
                                 style = "color:blue;" title="Editar Calificación"></i> </a>';
                                  /*$tabla .=' <a  href="javascript:void(0)"><i class="fa fa-trash delete_button"  data-toggle="modal" data-target="#myModalDelete"
                                  data-idasistencia="'.$asist->idasistencia.'"
                                  data-idmotivo="'.$asist->idmotivo.'"
                                  data-alumno="'.$alumn->apellidop." ".$alumn->apellidom." ".$alumn->nombre.'"
                                 style = "color:red;" title="Eliminar Calificación"></i> </a>';*/
                                  # code...
                              break;
                          
                          default:
                              # code...
                              break;
                      }
                 }else{
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
    $alumns = $this->grupo->alumnosGrupo($idhorario);
        $data = array( 
             'alumnos'=>$alumns, 
            'motivo'=>$motivo,
            'idhorario'=>$idhorario,
            'idhorariodetalle'=>$idhorariodetalle,
            'tabla'=>$tabla,
            'nombreclase'=>$nombreclase,
            'unidades'=>$unidades,
            'controller'=>$this
        );
        $this->load->view('docente/header');
        $this->load->view('docente/grupo/busqueda_asistencia',$data);
        $this->load->view('docente/footer');
   }else{
        $data = array(
            'heading'=>'Error',
            'message'=>'Intente mas tarde.'
        );
         $this->load->view('errors/html/error_general',$data);
    }

    }

        public function obetnerAsistencia($idhorario,$fechainicio,$fechafin,$idhorariodetalle)
    { 
         Permission::grant(uri_string());
         $alumns = $this->grupo->alumnosGrupo($idhorario);
         $tabla = ""; 

         if($alumns != false){
        $range= ((strtotime($fechafin)-strtotime($fechainicio))+(24*60*60)) /(24*60*60);
        //$range= ((strtotime($_GET["finish_at"])-strtotime($_GET["start_at"]))+(24*60*60)) /(24*60*60);
        
        $tabla .= '  <table id="tablageneral2" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
            <thead>
            <th>#</th>
            <th>Nombre</th>';
            for($i=0;$i<$range;$i++):
       setlocale(LC_ALL, 'es_ES');
            $fecha = strftime("%A, %d de %B", strtotime($fechainicio)+($i*(24*60*60)));

          $domingo = date('N',strtotime($fechainicio)+($i*(24*60*60)));
            if($domingo != '7' ){
                 if($domingo != '6' ){
                    $tabla .= '<th>'.$fecha.'</th>';
                 }
            }
           //echo date("d-M",strtotime($_GET["start_at"])+($i*(24*60*60)));
           endfor;
           $tabla .= '</thead>';
            $n = 1;
            foreach($alumns as $alumn){  
               $tabla .= ' <tr>';
               $tabla .='<td>'.$n++.'</td>';
                $tabla .= '<td >'.$alumn->apellidop." ".$alumn->apellidom." ".$alumn->nombre.'</td>';
             for($i=0;$i<$range;$i++):
                    $date_at= date("Y-m-d",strtotime($fechainicio)+($i*(24*60*60)));
                   // $asist = AssistanceData::getByATD($alumn->id,$_GET["team_id"],$date_at);
                    $asist = $this->grupo->listaAsistencia($alumn->idalumno,$idhorario,$date_at,$idhorariodetalle);
                        
      $domingo = date('N',strtotime($fechainicio)+($i*(24*60*60))); 

 if($domingo != '7' ){
                      if($domingo != '6' ){

                $tabla .= '<td>';
                 if($asist != false){ 
                      switch ($asist->idmotivo) {
                          case 1:
                              # code...
                                $tabla .='<span class="label label-success">'.$asist->nombremotivo.'</span>';
                               
                                $tabla .='  <a  href="javascript:void(0)"><i class="fa fa-pencil edit_button"  data-toggle="modal" data-target="#myModal"
                                data-idasistencia="'.$asist->idasistencia.'"
                                data-idmotivo="'.$asist->idmotivo.'"
                                data-alumno="'.$alumn->apellidop." ".$alumn->apellidom." ".$alumn->nombre.'"
                               style = "color:blue;" title="Editar Calificación"></i> </a>';
                                /*$tabla .=' <a  href="javascript:void(0)"><i class="fa fa-trash delete_button"  data-toggle="modal" data-target="#myModalDelete"
                                data-idasistencia="'.$asist->idasistencia.'"
                                data-idmotivo="'.$asist->idmotivo.'"
                                data-alumno="'.$alumn->apellidop." ".$alumn->apellidom." ".$alumn->nombre.'"
                               style = "color:red;" title="Eliminar Calificación"></i> </a>';*/

                            break;
                                  case 2:
                                  $tabla .='<span class="label label-warning">'.$asist->nombremotivo.'</span>';
                                  $tabla .='  <a  href="javascript:void(0)"><i class="fa fa-pencil edit_button"  data-toggle="modal" data-target="#myModal"
                                  data-idasistencia="'.$asist->idasistencia.'"
                                  data-idmotivo="'.$asist->idmotivo.'"
                                  data-alumno="'.$alumn->apellidop." ".$alumn->apellidom." ".$alumn->nombre.'"
                                 style = "color:blue;" title="Editar Calificación"></i> </a>';
                                  /*$tabla .=' <a  href="javascript:void(0)"><i class="fa fa-trash delete_button"  data-toggle="modal" data-target="#myModalDelete"
                                  data-idasistencia="'.$asist->idasistencia.'"
                                  data-idmotivo="'.$asist->idmotivo.'"
                                  data-alumno="'.$alumn->apellidop." ".$alumn->apellidom." ".$alumn->nombre.'"
                                 style = "color:red;" title="Eliminar Calificación"></i> </a>';*/
                                  # code...
                              break;
                                  case 3:
                                  $tabla .='<span class="label label-info">'.$asist->nombremotivo.'</span>';
                              
                                  $tabla .='  <a  href="javascript:void(0)"><i class="fa fa-pencil edit_button"  data-toggle="modal" data-target="#myModal"
                                  data-idasistencia="'.$asist->idasistencia.'"
                                  data-idmotivo="'.$asist->idmotivo.'"
                                  data-alumno="'.$alumn->apellidop." ".$alumn->apellidom." ".$alumn->nombre.'"
                                 style = "color:blue;" title="Editar Calificación"></i> </a>';
                                  /*$tabla .=' <a  href="javascript:void(0)"><i class="fa fa-trash delete_button"  data-toggle="modal" data-target="#myModalDelete"
                                  data-idasistencia="'.$asist->idasistencia.'"
                                  data-idmotivo="'.$asist->idmotivo.'"
                                  data-alumno="'.$alumn->apellidop." ".$alumn->apellidom." ".$alumn->nombre.'"
                                 style = "color:red;" title="Eliminar Calificación"></i> </a>';*/
                                     # code...
                              break;
                                  case 4:
                                  $tabla .='<span class="label label-danger">'.$asist->nombremotivo.'</span>';
                                  $tabla .='  <a  href="javascript:void(0)"><i class="fa fa-pencil edit_button"  data-toggle="modal" data-target="#myModal"
                                  data-idasistencia="'.$asist->idasistencia.'"
                                  data-idmotivo="'.$asist->idmotivo.'"
                                  data-alumno="'.$alumn->apellidop." ".$alumn->apellidom." ".$alumn->nombre.'"
                                 style = "color:blue;" title="Editar Calificación"></i> </a>';
                                  /*$tabla .=' <a  href="javascript:void(0)"><i class="fa fa-trash delete_button"  data-toggle="modal" data-target="#myModalDelete"
                                  data-idasistencia="'.$asist->idasistencia.'"
                                  data-idmotivo="'.$asist->idmotivo.'"
                                  data-alumno="'.$alumn->apellidop." ".$alumn->apellidom." ".$alumn->nombre.'"
                                 style = "color:red;" title="Eliminar Calificación"></i> </a>';*/
                                  # code...
                              break;
                          
                          default:
                              # code...
                              break;
                      }
                 }else{
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
 
    public function obtenerCalificacion($idhorario='',$idhorariodetalle)
    {
      # code...
       Permission::grant(uri_string());
     $unidades =  $this->grupo->unidades($this->session->idplantel);
     $alumnos = $this->grupo->alumnosGrupo($idhorario);
     
      $tabla ="";
       $tabla .= ' <table id="tablageneral2" class="table table-striped dt-responsive nowrap" cellspacing="0" width="100%">
      <thead class="bg-teal"> 
      <th>#</th>
      <th>Nombre</th>';
       foreach($unidades as $block):
        $tabla .= '<th>'.$block->nombreunidad.'</th>';
       endforeach; 

      $tabla .= '</thead>';
      $c = 1;
      if (isset($alumnos) && !empty($alumnos)) {
      foreach($alumnos as $row){
        //$alumn = $al->getAlumn();
      
        $tabla .= '<tr>
        <td>'.$c++.'</td>
        <td>'.$row->apellidop." ".$row->apellidom." ".$row->nombre.'</td>';
      foreach($unidades as $block):
      $val = $this->grupo->obtenerCalificacion($row->idalumno, $block->idunidad, $idhorariodetalle);
      
        $tabla .= '<td>';
        if($val != false ){  
          $tabla .='<label>'.$val->calificacion.'  </label>';
          $fecha_inicio = date('Y-m-d');
          $fecha_fin = date('Y-m-d',strtotime($val->fecharegistro)); 
          $total_dias =  dias_pasados($fecha_inicio,$fecha_fin);
         if($total_dias <= 3){
          $tabla .='  <a  href="javascript:void(0)"><i class="fa fa-pencil edit_button"  data-toggle="modal" data-target="#myModal"
          data-idcalificacion="'.$val->idcalificacion.'"
          data-calificacion="'.$val->calificacion.'"
          data-alumno="'.$row->apellidop." ".$row->apellidom." ".$row->nombre.'"
         style = "color:blue;" title="Editar Calificación"></i> </a>';
         }
          /*$tabla .=' <a  href="javascript:void(0)"><i class="fa fa-trash delete_button"  data-toggle="modal" data-target="#myModalDelete"
          data-idcalificacion="'.$val->idcalificacion.'"
          data-calificacion="'.$val->calificacion.'"
          data-alumno="'.$row->apellidop." ".$row->apellidom." ".$row->nombre.'"
         style = "color:red;" title="Eliminar Calificación"></i> </a>';*/
        }else{
           $tabla .='<label>No registrado</label>';
        } 
      $tabla .= '</td>';
      endforeach;

        $tabla .= '</tr>';
      

      }
    }
      $tabla .= '</table>';
      return $tabla;

    }
 
    public function asistencia($idhorario='',$idhorariodetalle)
    {
        Permission::grant(uri_string());
        $idhorario = $this->decode($idhorario);
        $idhorariodetalle = $this->decode($idhorariodetalle);
        if((isset($idhorario) && !empty($idhorario)) && (isset($idhorariodetalle) && !empty($idhorariodetalle))){
        $alumns = $this->grupo->alumnosGrupo($idhorario);
        $motivo = $this->grupo->motivoAsistencia();
        $unidades = $this->grupo->unidades($this->session->idplantel);
        $fechainicio = date("Y-m-d");
        $fechafin = date("Y-m-d");
        $table = $this->obetnerAsistencia($idhorario,$fechainicio,$fechafin,$idhorariodetalle);
        $detalle = $this->grupo->detalleClase($idhorariodetalle);
        //var_dump($detalle);
        $nombreclase = $detalle[0]->nombreclase;
        $data = array(
            'alumnos'=>$alumns, 
            'motivo'=>$motivo,
            'idhorario'=>$idhorario,
            'idhorariodetalle'=>$idhorariodetalle,
            'tabla'=>$table,
            'nombreclase'=>$nombreclase,
            'unidades'=>$unidades,
            'controller'=>$this
        );
        $this->load->view('docente/header');
        $this->load->view('docente/grupo/asistencia',$data);
        $this->load->view('docente/footer');
         }else{
         $data = array(
            'heading'=>'Error',
            'message'=>'Error intente mas tarde.'
        );
         $this->load->view('errors/html/error_general',$data);
    }
    }
    public function eliminarAsistenciaFecha()
    {
        $fecha = $this->input->post('fechaeliminar');
        $idhorariodetalle = $this->input->post('horariodetalle');
        $this->grupo->eliminarAsistenciaFecha($idhorariodetalle,$fecha);
    }
  public function examen($idhorario='',$idhorariodetalle)
    {
      Permission::grant(uri_string());
      $idhorario = $this->decode($idhorario);
      $idhorariodetalle = $this->decode($idhorariodetalle);
      if((isset($idhorario) && !empty($idhorario)) && (isset($idhorariodetalle) && !empty($idhorariodetalle))){
      $unidades =  $this->grupo->unidades($this->session->idplantel);
      $alumns = $this->grupo->alumnosGrupo($idhorario);
      $detalle = $this->grupo->detalleClase($idhorariodetalle); 
      $nombreclase = $detalle[0]->nombreclase; 
      $data = array(
        'alumnos'=>$alumns,
        'idhorario'=>$idhorario,
        'idhorariodetalle'=>$idhorariodetalle,
        'unidades'=>$unidades,
        'nombreclase'=>$nombreclase,
        'tabla' => $this->obtenerCalificacion($idhorario,$idhorariodetalle),
        'oportunidades'=>$this->grupo->showAllOportunidades($this->session->idplantel)
      );

       $this->load->view('docente/header');
        $this->load->view('docente/grupo/examen',$data);
        $this->load->view('docente/footer');
         }else{
         $data = array(
            'heading'=>'Error',
            'message'=>'Error intente mas tarde.'
        );
         $this->load->view('errors/html/error_general',$data);
    }

    }
      public function tarea($idhorario='',$idhorariodetalle)
    {
         Permission::grant(uri_string()); 
         $idhorario = $this->decode($idhorario);
         $idhorariodetalle = $this->decode($idhorariodetalle);
         if((isset($idhorario) && !empty($idhorario)) && (isset($idhorariodetalle) && !empty($idhorariodetalle))){
        $data = array( 
            'idhorario'=>$idhorario,
            'idhorariodetalle'=>$idhorariodetalle, 
            'tareas'=>$this->grupo->allTarea($idhorariodetalle),
            'controller'=>$this
        );

       $this->load->view('docente/header');
        $this->load->view('docente/grupo/tarea',$data);
        $this->load->view('docente/footer');
         }else{
         $data = array(
            'heading'=>'Error',
            'message'=>'Error intente mas tarde.'
        );
         $this->load->view('errors/html/error_general',$data);
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
                'rules' => 'trim|required|decimal|callback_maxNumber',
                'errors' => array(
                    'required' => 'Escribir las Calificaciones.',
                    'decimal' => 'Debe de ser Números decimales.'
                )
            )
        );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            $errors = validation_errors();
            echo json_encode(['error'=>$errors]);
        } else {
            $idhorario = $this->input->post('idhorario');
            $idhorariodetalle = $this->input->post('idhorariodetalle');
            $idalumno = $this->input->post('idalumno');
            $unidad = $this->input->post('unidad');
            $calificacion = $this->input->post('calificacion'); 
            $detalle_oportunidad = $this->grupo->primeraOportunidad($this->session->idplantel);
            if($detalle_oportunidad){
            $idopotunidad = $detalle_oportunidad[0]->idoportunidadexamen;
            $validar = $this->grupo->validarAgregarCalificacion($unidad,$idhorariodetalle);
            if($validar == false){
            foreach ($idalumno as $key => $value) { 
                $idalumno2 = $value;
                $calificacion2 = $calificacion[$key]; 
                $data = array(
                    'idunidad'=>$unidad,
                    'idoportunidadexamen'=>$idopotunidad,
                    'idalumno'=>$idalumno2,
                    'idhorario'=>$idhorario,
                    'idhorariodetalle'=>$idhorariodetalle,
                    'calificacion'=>$calificacion2,
                    'idusuario' => $this->session->user_id,
                    'fecharegistro' => date('Y-m-d H:i:s')
                );
                $this->grupo->addCalificacion($data);
               
            } 
            echo json_encode(['success'=>'Ok']);
          }else{
             echo json_encode(['error'=>'Ya fueron registradas las calificaciones para esta unidad.']);
          }
           }else{
             echo json_encode(['error'=>'No esta registrado la Oportunidad.']);
          }
        }
       // echo json_encode($result);
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
                    'required' => 'Debe de seleccionar una Opción.',
                )
            )
        );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            $errors = validation_errors();
            echo json_encode(['error'=>$errors]);
        } else {
           

            $idhorario = $this->input->post('idhorario');
            $idunidad = $this->input->post('unidad');
            $idhorariodetalle = $this->input->post('idhorariodetalle');
            $idalumno = $this->input->post('idalumno'); 
            $motivo = $this->input->post('motivo');
            $fecha = $this->input->post('fecha'); 
            $numero_semana_enviado = date('W',strtotime($fecha));
            $semana_actual = date('W');
            if($semana_actual == $numero_semana_enviado){
            $validar = $this->grupo->validarAgregarAsistencia($fecha,$idhorariodetalle,$idunidad);
            if($validar == false){
            foreach ($idalumno as $key => $value) {
                # code...
                // value es el idcliete
                $idalumno2 = $value;
                $motivo2 = $motivo[$key];

                $data = array( 
                    'idhorario'=>$idhorario,
                    'idhorariodetalle'=>$idhorariodetalle,
                    'idalumno'=>$idalumno2,
                    'idmotivo'=>$motivo2,
                    'idunidad'=>$idunidad,
                    'fecha'=>$fecha,
                    'idusuario' => $this->session->user_id,
                    'fecharegistro' => date('Y-m-d H:i:s')
                );
                $this->grupo->addAsistencia($data);
            } 
            echo json_encode(['success'=>'Ok']);
          }else{
             echo json_encode(['error'=>'Las Asistencias ya estan registradas para esta Fecha.']);
          }
        }else{
             echo json_encode(['error'=>'Solo puedes trabajar en la semana actual.']);
        }
            
        }
       // echo json_encode($result);
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
                    'required' => 'Debe de seleccionar una Opción.',
                )
            )
        );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            $errors = validation_errors();
            echo json_encode(['error'=>$errors]);
        } else {
            $idasistencia = $this->input->post('idasistencia');  
            $motivo = $this->input->post('motivo');  
                $data = array( 
                    'idmotivo'=>$motivo,
                    'idusuario' => $this->session->user_id,
                    'fecharegistro' => date('Y-m-d H:i:s')
                );
                $valu = $this->grupo->updateAsistencia($idasistencia,$data); 
                if($valu){
                echo json_encode(['success'=>'Ok']);
                }else{
                    echo json_encode(['error'=>'Error... Intente mas tarde.']);
                }
            
        }
       // echo json_encode($result);
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
                    'required' => 'Fecha de entrega.'
                )
            ),
              array(
                'field' => 'tarea',
                'label' => 'Calificación',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Tarea'
                )
            )
        );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            $errors = validation_errors();
            echo json_encode(['error'=>$errors]);
        } else {
            $idhorario = $this->input->post('idhorario');
            $idhorariodetalle = $this->input->post('idhorariodetalle');
            $tarea = $this->input->post('tarea');
            $fechaentrega = $this->input->post('fechaentrega');  

                $data = array(
                    'idhorario'=>$idhorario,
                    'idhorariodetalle'=>$idhorariodetalle,
                    'tarea'=>$tarea,
                    'fechaentrega'=>$fechaentrega, 
                    'idusuario' => $this->session->user_id,
                    'fecharegistro'=>date('Y-m-d H:i:s')
                );
                $value = $this->grupo->addTarea($data);
             
             echo json_encode(['success'=>'Ok']);
            
        }
       // echo json_encode($result);
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
                    'required' => 'Tarea'
                )
            )
        );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            $errors = validation_errors();
            echo json_encode(['error'=>$errors]);
        } else {
            $idhorario = $this->input->post('idhorario');
            $idhorariodetalle = $this->input->post('idhorariodetalle');
            $mensaje = $this->input->post('mensaje');
            //$fechaentrega = $this->input->post('fechaentrega');  

                $data = array(
                    'idhorario'=>$idhorario,
                    'idhorariodetalle'=>$idhorariodetalle,
                    'mensaje'=>$mensaje,
                    'eliminado'=>0, 
                    'idusuario' => $this->session->user_id,
                    'fecharegistro'=>date('Y-m-d H:i:s')
                );
                $this->mensaje->addMensaje($data);
             
             echo json_encode(['success'=>'Ok']);
            
        }
       // echo json_encode($result);
    }

     public function updateTarea()  { 
 Permission::grant(uri_string());
        $config = array(
            array(
                'field' => 'fechaentrega',
                'label' => 'Unidad',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Fecha de entrega.'
                )
            ),
              array(
                'field' => 'tarea',
                'label' => 'Calificación',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Tarea'
                )
            )
        );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            $errors = validation_errors();
            echo json_encode(['error'=>$errors]);
        } else {
            $idtarea = $this->input->post('idtarea'); 
            $tarea = $this->input->post('tarea');
            $fechaentrega = $this->input->post('fechaentrega');  

                $data = array(  
                    'tarea'=>$tarea,
                    'fechaentrega'=>$fechaentrega,
                    'idusuario' => $this->session->user_id,
                    'fecharegistro' => date('Y-m-d H:i:s')
                );
                $this->grupo->updateTarea($idtarea,$data);
             
             echo json_encode(['success'=>'Ok']);
            
        }
       // echo json_encode($result);
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
                    'required' => 'Tarea'
                )
            )
        );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            $errors = validation_errors();
            echo json_encode(['error'=>$errors]);
        } else {
            $idmensaje = $this->input->post('idmensaje'); 
            $mensaje = $this->input->post('mensaje');
                $data = array(  
                    'mensaje'=>$mensaje,
                    'idusuario' => $this->session->user_id,
                    'fecharegistro' => date('Y-m-d H:i:s')
                );
                $this->mensaje->updateMensaje($idmensaje,$data);
             
             echo json_encode(['success'=>'Ok']);
            
        }
       // echo json_encode($result);
    }

public function eliminarTarea($idhorario,$idhorariodetalle,$idtarea)
{
     Permission::grant(uri_string());
  # code...
  $idhorario  = $this->decode($idhorario);
  $idhorariodetalle  = $this->decode($idhorariodetalle);
  $idtarea  = $this->decode($idtarea);
  $this->grupo->eliminarTarea($idtarea);
  redirect('Pgrupo/tarea/'.$this->encode($idhorario).'/'.$this->encode($idhorariodetalle));
}
public function eliminarMensaje($idhorario,$idhorariodetalle,$idmensaje)
{
     Permission::grant(uri_string());
  # code...
    $idhorario  = $this->decode($idhorario);
  $idhorariodetalle  = $this->decode($idhorariodetalle);
  $idmensaje  = $this->decode($idmensaje);
  $data = array(
      'eliminado'=>1
  );
  $this->mensaje->updateMensaje($idmensaje,$data);
  redirect('Pgrupo/mensaje/'.$this->encode($idhorario).'/'.$this->encode($idhorariodetalle));
}
 
public function mensaje($idhorario='',$idhorariodetalle = '')
{
        Permission::grant(uri_string());
        $idhorario = $this->decode($idhorario);
        $idhorariodetalle = $this->decode($idhorariodetalle);
        if((isset($idhorario) && !empty($idhorario)) && (isset($idhorariodetalle) && !empty($idhorariodetalle))){
      $data = array( 
        'idhorario'=>$idhorario,
        'idhorariodetalle'=>$idhorariodetalle, 
        'mensajes'=>$this->mensaje->showAllMensaje($idhorariodetalle),
        'controller'=>$this
      );
        $this->load->view('docente/header');
        $this->load->view('docente/grupo/mensaje',$data);
        $this->load->view('docente/footer');

     }else{
         $data = array(
            'heading'=>'Error',
            'message'=>'Error intente mas tarde.'
        );
         $this->load->view('errors/html/error_general',$data);
    }
}
public function eliminarCalificacion()
{
    # code...
     Permission::grant(uri_string());
    $idcalificacion = $this->input->post('idcalificacion'); 
    $value = $this->grupo->deleteCalificacion($idcalificacion);
    if($value){
        echo json_encode(['success'=>'Ok']);
    }else{
        echo json_encode(['error'=>'Error, Intente mas tarde.']);
    }
}
public function eliminarAsistencia()
{
    # code...
     Permission::grant(uri_string());
    $idasistencia = $this->input->post('idasistencia'); 
    $value = $this->grupo->deleteAsistencia($idasistencia);
    if($value){
        echo json_encode(['success'=>'Ok']);
    }else{
        echo json_encode(['error'=>'Error, Intente mas tarde.']);
    }
}
function maxNumber($num){
    if($num >=0.00 && $num <= 10.00){
        return true;
    }else{
        $this->form_validation->set_message(
            'maxNumber',
            'La Calificacion debe de ser entre 0.00 a 10.00'
        );
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
            'rules' => 'trim|required|decimal|callback_maxNumber',
            'errors' => array(
                'required' => 'De de escribir las Calificaciones.',
                'decimal' => 'Debe de ser Números decimales.'
            )
        )
    );
    $this->form_validation->set_rules($config);
    if ($this->form_validation->run() == FALSE) {
        $errors = validation_errors();
        echo json_encode(['error'=>$errors]);
    } else {
        $idcalificacion = $this->input->post('idcalificacion'); 
        $calificacion = $this->input->post('calificacion'); 
        $detalle_calificacion = $this->grupo->detalleCalificacion($idcalificacion);
          $fecha_inicio = date('Y-m-d');
          $fecha_fin = date('Y-m-d',strtotime($detalle_calificacion->fecharegistro)); 
          $total_dias =  dias_pasados($fecha_inicio,$fecha_fin);
         if($total_dias <= 3){
        $data = array(
                'calificacion'=>$calificacion,
                'idusuario' => $this->session->user_id,
                //'fecharegistro' => date('Y-m-d H:i:s')
            );
            $this->grupo->updateCalificacion($idcalificacion,$data);
         
        echo json_encode(['success'=>'Ok']);
         }else{
             echo json_encode(['error'=>'Ya pasaron los 3 dias habiles.']);
         }
      
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
    if ($this->form_validation->run() == FALSE) {
        $errors = validation_errors();
        echo json_encode(['error'=>$errors]);
    } else {
        $detalle_oportunidad = $this->grupo->primeraOportunidad($this->session->idplantel);
            if($detalle_oportunidad){
            $idopotunidad = $detalle_oportunidad[0]->idoportunidadexamen;
        $unidad = $this->input->post('unidad'); 
        $horariodetalle = $this->input->post('horariodetalle');  
        $detalle_calificacion = $this->grupo->detalleCalificacionUnidad($unidad,$horariodetalle);
       $fecha_inicio = date('Y-m-d');
          $fecha_fin = date('Y-m-d',strtotime($detalle_calificacion->fecharegistro)); 
          $total_dias =  dias_pasados($fecha_inicio,$fecha_fin);
         if($total_dias <= 3){
        $this->grupo->eliminarCalificacionUnidad($unidad,$horariodetalle,$idopotunidad);
         
        echo json_encode(['success'=>'Ok']);
         }else{
             echo json_encode(['error'=>'Ya pasaron los 3 dias habiles.']);
         }
       }else{
             echo json_encode(['error'=>'No esta registrado la Oportunidad.']);
          }
    }

}
public function recuperacion($idhorariodetalle = '',$idopotunidad)
{
    $detalle = $this->grupo->obtenerAlumnoRecuperar($idhorariodetalle,$idopotunidad);
    var_dump($detalle);
}
 
}
