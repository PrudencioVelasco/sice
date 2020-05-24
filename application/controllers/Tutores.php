<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("America/Mexico_City");
class Tutores extends CI_Controller {
 function __construct() {
        parent::__construct();

        if (!isset($_SESSION['user_id'])) {
            $this->session->set_flashdata('flash_data', 'You don\'t have access! ss');
            return redirect('welcome');
        }
        $this->load->helper('url');
        $this->load->model('data_model'); 
        $this->load->library('permission');
        $this->load->library('session'); 
        $this->load->model('alumno_model','alumno'); 
        $this->load->model('grupo_model','grupo'); 
        $this->load->model('horario_model','horario');
        $this->load->model('user_model','user');
        $this->load->model('cicloescolar_model','cicloescolar');
         $this->load->model('tutor_model','tutor');  
        $this->load->model('data_model'); 
        $this->load->library('permission');
        $this->load->library('session');
        $this->load->library('pdfgenerator'); 
        $this->load->library('openpayservicio');
	}
 
	public function index()
	{ 

	    $this->load->view('tutor/header');
        $this->load->view('tutor/index');
        $this->load->view('tutor/footer');

	} 
    public function alumnos()
    {
        $alumnos = $this->alumno->showAllAlumnosTutorActivos($this->session->idtutor);
        
        $data = array(
            'alumnos'=>$alumnos
        );
        $this->load->view('tutor/header');
        $this->load->view('tutor/alumnos/index',$data);
        $this->load->view('tutor/footer');
    }
    public function horario($idalumno = '')
    {
       $detalle = $this->alumno->showAllMateriasAlumno($idalumno);
       $idhorario = '';
       if(isset($detalle[0]->idhorario) && !empty($detalle[0]->idhorario)){
        $idhorario =  $detalle[0]->idhorario;
       } 
        $data = array(
            'idhorario'=>$idhorario,
            'idalumno'=>$idalumno
        ); 
        $this->load->view('tutor/header');
        $this->load->view('tutor/alumnos/horario',$data);
        $this->load->view('tutor/footer');
    }
     public function obtenerCalificacion($idhorario='',$idalumno = '')
    {
      # code...
     $unidades =  $this->grupo->unidades($this->session->idplantel);
     $materias = $this->alumno->showAllMaterias($idhorario);
     
      $tabla ="";
       $tabla .= '<table class="table table-bordered table-hover">
      <thead>
      <th>#</th>
      <th>Nombre de Materia</th>';
       foreach($unidades as $block):
        $tabla .= '<th><strong>'.$block->nombreunidad.'</strong></th>';
       endforeach; 

      $tabla .= '</thead>';
      $c = 1;
      if (isset($materias) && !empty($materias)) {

      foreach($materias as $row){
        //$alumn = $al->getAlumn();
      
        $tabla .= '<tr>
        <td>'.$c++.'</td>
        <td><strong>'.$row->nombreclase.'</strong><br><small>( '.$row->nombre.' '.$row->apellidop.' '.$row->apellidom.'</small>)</td>';
      foreach($unidades as $block):
      $val = $this->grupo->obtenerCalificacion($idalumno, $block->idunidad, $row->idhorariodetalle);
      
        $tabla .= '<td>';
        if($val != false ){ 
          $tabla .='<label>'.$val->calificacion.'</label>'; 
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
     public function boletas($idalumno = '')
    {
        if(isset($idalumno) && !empty($idalumno)){
        $detalle = $this->alumno->showAllMateriasAlumno($idalumno);
         if(isset( $detalle[0]->idhorario) && !empty( $detalle[0]->idhorario)){
        $idhorario = $detalle[0]->idhorario;
        $calificacion = "";
        $tabla = $this->obtenerCalificacion($idhorario,$idalumno);
        $datosalumno = $this->alumno->showAllAlumnoId($idalumno);
        $datoshorario = $this->horario->showNivelGrupo($idhorario);
        $materias = $this->alumno->showAllMaterias($idhorario);
        $unidades =  $this->grupo->unidades($this->session->idplantel);
        $total_materia = 0;
        if ($materias != FALSE) { 
            foreach ($materias as $row) { 
                $total_materia = $total_materia + 1;
            }
        } 
        $datoscalifiacacion = $this->horario->calificacionGeneralAlumno($idhorario,$idalumno);
         if($datoscalifiacacion != FALSE && $total_materia > 0){
            $calificacion= $datoscalifiacacion->calificaciongeneral / $total_materia;
         }
         $data = array(
            'idhorario'=>$idhorario,
            'idalumno'=>$idalumno,
            'tabla'=>$tabla,
            'datosalumno'=>$datosalumno,
            'datoshorario'=>$datoshorario,
            'calificacion'=>$calificacion,
            'unidades'=>$unidades
        );
        $this->load->view('tutor/header');
        $this->load->view('tutor/alumnos/boletas',$data);
        $this->load->view('tutor/footer');
         }else{
        $data = array(
            'heading'=>'Notificación',
            'message'=>'El Alumno(a) no tiene registrado Calificación.'
        );
         $this->load->view('errors/html/error_general',$data);
    }
    }else{
        $data = array(
            'heading'=>'Error',
            'message'=>'Intente mas tarde.'
        );
         $this->load->view('errors/html/error_general',$data);
    }

    }
    public function materias($idalumno='')
    {
        $materias = $this->alumno->showAllMateriasAlumno($idalumno);
        $alumno = $this->alumno->detalleAlumno($idalumno);
         $data = array(
            'materias'=>$materias,
            'alumno'=>$alumno,
            'idalumno'=>$idalumno
        );
        $this->load->view('tutor/header');
        $this->load->view('tutor/alumnos/materias',$data);
        $this->load->view('tutor/footer');
    }
   
    public function examen($idhorario='',$idhorariodetalle = '',$idalumno = '')
    {
      $unidades =  $this->grupo->unidades($this->session->idplantel);
      $alumns = $this->grupo->alumnosGrupo($idhorario);
      $detalle = $this->grupo->detalleClase($idhorariodetalle);
      //var_dump($detalle);
      $nombreclase = $detalle[0]->nombreclase;
     // echo $this->obtenerCalificacion($idhorario,$idhorariodetalle);
      $data = array(
        'alumnos'=>$alumns,
        'idhorario'=>$idhorario,
        'idhorariodetalle'=>$idhorariodetalle,
        'unidades'=>$unidades,
        'nombreclase'=>$nombreclase,
        'tabla' => $this->obtenerCalificacion($idhorario,$idhorariodetalle,$idalumno)
      );

       $this->load->view('docente/header');
        $this->load->view('docente/grupo/examen',$data);
        $this->load->view('docente/footer');

    }
 
     public function asistencias($idalumno='')
    {
        if(isset($idalumno) && !empty($idalumno)){
       $detalle = $this->alumno->showAllMateriasAlumno($idalumno);
       if(isset($detalle[0]->idhorario) && !empty($detalle[0]->idhorario)){
       $idhorario = $detalle[0]->idhorario;
       $idhorariodetalle =  $detalle[0]->idhorariodetalle;
 
        $alumns = $this->grupo->alumnosGrupo($idhorario);
        $motivo = $this->grupo->motivoAsistencia();
         $unidades = $this->grupo->unidades($this->session->idplantel);
        $fechainicio = date("Y-m-d");
        $fechafin = date("Y-m-d");
        $table = $this->obetnerAsistencia($idhorario,$fechainicio,$fechafin,$idhorariodetalle,$idalumno);
        $detalle = $this->grupo->detalleClase($idhorariodetalle);
        //var_dump($table);
        $nombreclase = $detalle[0]->nombreclase;
        $data = array(
            'alumnos'=>$alumns, 
            'motivo'=>$motivo,
            'idhorario'=>$idhorario,
            'idhorariodetalle'=>$idhorariodetalle,
            'tabla'=>$table,
            'nombreclase'=>$nombreclase,
            'unidades'=>$unidades,
            'idalumno'=>$idalumno
        );
        $this->load->view('tutor/header');
        $this->load->view('tutor/alumnos/asistencias',$data);
        $this->load->view('tutor/footer');
        }else{
                $data = array(
                    'heading'=>'Notificación',
                    'message'=>'El Alumno(a) no tiene registrado Asistencia.'
                );
                $this->load->view('errors/html/error_general',$data);
            }
        
         }else{
        $data = array(
            'heading'=>'Error',
            'message'=>'Intente mas tarde.'
        );
         $this->load->view('errors/html/error_general',$data);
    }
    }

     public function obetnerAsistencia($idhorario,$fechainicio,$fechafin,$idhorariodetalle,$idalumno)
    { 
        
       //  $alumns = $this->grupo->alumnosGrupo($idhorario);
         $tabla = "";  
         $materias = $this->alumno->showAllMaterias($idhorario); 
        // var_dump($materias);

        $range= ((strtotime($fechafin)-strtotime($fechainicio))+(24*60*60)) /(24*60*60);
        //$range= ((strtotime($_GET["finish_at"])-strtotime($_GET["start_at"]))+(24*60*60)) /(24*60*60);
        
        $tabla .= '<table class="table">
            <thead>
            <th>#</th>
            <th>Nombre</th>';
            for($i=0;$i<$range;$i++):
           $tabla .= '<th>'.date("D d-M",strtotime($fechainicio)+($i*(24*60*60))).'</th>';
           //echo date("d-M",strtotime($_GET["start_at"])+($i*(24*60*60)));
           endfor;
           $tabla .= '</thead>';
            $n = 1;
             foreach($materias as $row){
               $tabla .='<tr>';
               $tabla .='<td>'.$n++.'</td>';
               $tabla .='<td><strong>'.$row->nombreclase.'</strong><br><small>( '.$row->nombre.' '.$row->apellidop.' '.$row->apellidom.'</small>)</td>';
             for($i=0;$i<$range;$i++):
                    $date_at= date("Y-m-d",strtotime($fechainicio)+($i*(24*60*60)));
                   // $asist = AssistanceData::getByATD($alumn->id,$_GET["team_id"],$date_at);
                    $asist = $this->grupo->listaAsistencia($idalumno,$idhorario,$date_at,$idhorariodetalle);
                        


                $tabla .= '<td>';
                 if($asist != false){ 
                      switch ($asist->idmotivo) {
                          case 1:
                              # code...
                                $tabla .='<span class="label label-success">'.$asist->nombremotivo.'</span>';
                                

                            break;
                                  case 2:
                                  $tabla .='<span class="label label-warning">'.$asist->nombremotivo.'</span>';
                                  
                              break;
                                  case 3:
                                  $tabla .='<span class="label label-info">'.$asist->nombremotivo.'</span>';
                              
                                  
                              break;
                                  case 4:
                                  $tabla .='<span class="label label-danger">'.$asist->nombremotivo.'</span>';
                                  
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
             endfor; 
                $tabla .= '</tr>';
                

            }
$tabla .= '</table>';
 
return $tabla;


    }


      public function obetnerAsistenciaAlu()
    { 
        $idhorario = $this->input->post('idhorario'); 
        $idhorariodetalle = $this->input->post('idhorariodetalle');
        $fechainicio = $this->input->post('fechainicio');
        $fechafin = $this->input->post('fechafin');
        $idalumno = $this->input->post('idalumno');
       //  $alumns = $this->grupo->alumnosGrupo($idhorario);
         $tabla = "";  
         $materias = $this->alumno->showAllMaterias($idhorario); 
        // var_dump($materias);

        $range= ((strtotime($fechafin)-strtotime($fechainicio))+(24*60*60)) /(24*60*60);
        //$range= ((strtotime($_GET["finish_at"])-strtotime($_GET["start_at"]))+(24*60*60)) /(24*60*60);
        
        $tabla .= '<table class="table">
            <thead>
            <th>#</th>
            <th>Nombre</th>';
            for($i=0;$i<$range;$i++):
           $tabla .= '<th>'.date("D d-M",strtotime($fechainicio)+($i*(24*60*60))).'</th>';
           //echo date("d-M",strtotime($_GET["start_at"])+($i*(24*60*60)));
           endfor;
           $tabla .= '</thead>';
            $n = 1;
             foreach($materias as $row){
               $tabla .='<tr>';
               $tabla .='<td>'.$n++.'</td>';
               $tabla .='<td><strong>'.$row->nombreclase.'</strong><br><small>( '.$row->nombre.' '.$row->apellidop.' '.$row->apellidom.'</small>)</td>';
             for($i=0;$i<$range;$i++):
                    $date_at= date("Y-m-d",strtotime($fechainicio)+($i*(24*60*60)));
                   // $asist = AssistanceData::getByATD($alumn->id,$_GET["team_id"],$date_at);
                    $asist = $this->grupo->listaAsistencia($idalumno,$idhorario,$date_at,$idhorariodetalle);
                        


                $tabla .= '<td>';
                 if($asist != false){ 
                      switch ($asist->idmotivo) {
                          case 1:
                              # code...
                                $tabla .='<span class="label label-success">'.$asist->nombremotivo.'</span>';
                                

                            break;
                                  case 2:
                                  $tabla .='<span class="label label-warning">'.$asist->nombremotivo.'</span>';
                                  
                              break;
                                  case 3:
                                  $tabla .='<span class="label label-info">'.$asist->nombremotivo.'</span>';
                              
                                  
                              break;
                                  case 4:
                                  $tabla .='<span class="label label-danger">'.$asist->nombremotivo.'</span>';
                                  
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
             endfor; 
                $tabla .= '</tr>';
                

            }
$tabla .= '</table>';
 
echo $tabla;


    }

    public function pagos($idalumno = '',$idnivel = '',$idperiodo = '')
    { 
        if((isset($idalumno) && !empty($idalumno)) && (isset($idnivel) && !empty($idnivel)) && (isset($idperiodo) && !empty($idperiodo))){
        $pago_inicio = $this->alumno->showAllPagoInscripcion($idalumno,$idperiodo); 
        $data = array(
            'pago_inicio'=>$pago_inicio,
            'idalumno'=>$idalumno,
            'idperiodo'=>$idperiodo,
            'idnivel'=>$idnivel
        );
        $this->load->view('tutor/header');
        $this->load->view('tutor/alumnos/pagos',$data);
        $this->load->view('tutor/footer');
         }else{
         $data = array(
            'heading'=>'Error',
            'message'=>'Error intente mas tarde.'
        );
         $this->load->view('errors/html/error_general',$data);
    }
    }
    public function pagoi($idalumno = '',$idperiodo = '',$idnivel = '',$tipo = '')
    {
        if((isset($idalumno) && !empty($idalumno)) && (isset($idperiodo) && !empty($idperiodo)) && (isset($idnivel) && !empty($idnivel)) && (isset($tipo) && !empty($tipo)))
        {
            $mensaje = "";
        if($tipo == 1){
            $detalle = $this->tutor->precioColegiatura(2,$idnivel);
            $mensaje .= "PAGO DE REINSCRIPCIÓN";
         }elseif($tipo == 2){
             $detalle = $this->turor->precioColegiatura(3,$idnivel);
             $mensaje .= "PAGO DE MENSUALIDAD";
         }else{
             $detalle = false;
         }

        if($detalle != false){
        $descuento = $detalle[0]->descuento;
         $data = array( 
            'idalumno'=>$idalumno,
            'idperiodo'=>$idperiodo,
            'descuento'=>$descuento,
            'mensaje'=>$mensaje
        );
         $this->load->view('tutor/header');
        $this->load->view('tutor/alumnos/pago_inscripcion',$data);
        $this->load->view('tutor/footer');
        
    }else{
         $data = array(
            'heading'=>'Notificación',
            'message'=>'No se puede pagar por el momento, intente mas tarde.'
        );
         $this->load->view('errors/html/error_general',$data);
    }
    }else{
         $data = array(
            'heading'=>'Error',
            'message'=>'Error intente mas tarde.'
        );
         $this->load->view('errors/html/error_general',$data);
    }
    }

    public function buscarCP() {
        # code...
        $cp = $_POST['b'];
        $array = $this->alumno->showColonias($cp);

        $select = "";
        $select .= '<option value="">--SELECCIONAR--</option>';
        if (isset($array) && !empty($array)) {
            foreach ($array as $value) {
                # code...
                $select .= '<option value="' . $value->idcolonia . '">' . strtoupper($value->nombrecolonia) . '</option>';
            }
        }
        echo $select;
    }
        public function buscarMunicipioCP() {
        # code...
        $cp = $_POST['b'];
        $array = $this->alumno->showMunicipio($cp);

        $select = "";
        if (isset($array) && !empty($array)) {
            foreach ($array as $value) {
                # code...
                $select .= '<option value="' . $value->idmunicipio . '">' . strtoupper($value->nombremunicipio) . '</option>';
            }
        }
        echo $select;
    }

    public function buscarEstadoCP() {
        # code...
        $cp = $_POST['b'];
        $array = $this->alumno->showEstado($cp);

        $select = "";
        if (isset($array) && !empty($array)) {
            foreach ($array as $value) {
                # code...
                $select .= '<option value="' . $value->idestado . '">' . strtoupper($value->nombreestado) . '</option>';
            }
        }
        echo $select;
    }
    
    public function pagotarjeta()
    {
            try {
                $idtutor = $this->session->idtutor;
                $detalle_tutor = $this->tutor->detalleTutor($idtutor);
                $nombretarjetahabiente  = $this->input->post('nombretitular');
                $calle  = $this->input->post('calletitular');
                $nombretarjetahabiente  = $this->input->post('nombretitular');
                $numero  = $this->input->post('numerocasa');
                $idcolonia  = $this->input->post('colonia');
                $detalle_colonia = $this->tutor->detalleColonia($idcolonia);
                $cp  = $this->input->post('cp');
                $descuento  = $this->input->post('descuento');
                $mensaje  = $this->input->post('mensaje');
                        $response = [];
                        Openpay::setProductionMode(false);
                        $openpay = Openpay::getInstance('mds4bdhgvbese0knzu2x', 'sk_f95d7349163642fba9f5a71021b3f6d5');
                        $customer = array(
                            'name' => strtoupper($nombretarjetahabiente),
                            'last_name' => '',
                            'email' => $detalle_tutor->correo,
                            'phone_number' => $detalle_tutor->telefono,
                            'address' => array(
                                'line1' => strtoupper($calle . ' ' . $numero),
                                'line2' => strtoupper($detalle_colonia[0]->nombrecolonia),
                                'line3' => '',
                                'postal_code' => $cp,
                                'state' => strtoupper($detalle_colonia[0]->nombreestado),
                                'city' => strtoupper($detalle_colonia[0]->nombremunicipio),
                                'country_code' => 'MX'));

                        $chargeData = array(
                            'method' => 'card',
                            'source_id' => $_POST["token_id"],
                            'amount' => (float) $descuento,
                            'description' => $mensaje,
                            'device_session_id' => $_POST["deviceIdHiddenFieldName"],
                            'customer' => $customer
                        );

                        $charge = $openpay->charges->create($chargeData);
                        $response['charge'] = $charge; 
                        //var_dump($charge["authorization"]);
                        var_dump($charge->authorization);
                        $data = array(
                            
                        );

                       
                    } catch (OpenpayApiTransactionError $e) {

                        switch ($e->getErrorCode()) {
                            case 3001:
                                $mensaje .= "La tarjeta fue declinada.";
                                break;
                            case 3002:
                                $mensaje .= "La tarjeta ha expirado.";
                                break;
                            case 3003:
                                $mensaje .= "La tarjeta no tiene fondos suficientes.";
                                break;
                            case 3004:
                                $mensaje .= "La tarjeta ha sido identificada como una tarjeta robada.";
                                break;
                            case 3005:
                                $mensaje .= "La tarjeta ha sido rechazada por el sistema antifraudes.";
                                break;
                            case 3006:
                                $mensaje .= "La operación no esta permitida para este cliente o esta transacción.";
                                break;
                            case 3007:
                                $mensaje .= "Deprecado. La tarjeta fue declinada.";
                                break;
                            case 3008:
                                $mensaje .= "La tarjeta no es soportada en transacciones en línea.";
                                break;
                            case 3009:
                                $mensaje .= "La tarjeta fue reportada como perdida.";
                                break;
                            case 3010:
                                $mensaje .= "El banco ha restringido la tarjeta.";
                                break;
                            case 3011:
                                $mensaje .= "El banco ha solicitado que la tarjeta sea retenida. Contacte al banco.";
                                break;
                            case 3012:
                                $mensaje .= "Se requiere solicitar al banco autorización para realizar este pago.";
                                break;

                            default:
                                $mensaje .= $e->getMessage();
                                break;
                        }
                    } catch (OpenpayApiRequestError $e) {
                        $mensaje .= $e->getMessage();
                         
                    } catch (OpenpayApiConnectionError $e) {
                        $mensaje .= $e->getMessage();
                       
                    } catch (OpenpayApiAuthError $e) {
                        $mensaje .= $e->getMessage();
                      
                    } catch (OpenpayApiError $e) {
                        $mensaje .= $e->getMessage();
                         
                    } catch (Exception $e) {
                        $mensaje .= $e->getMessage();
                        
                    }
    }
    
    public function kardex()
    {
        $alumnos = $this->alumno->showAllAlumnosTutor($this->session->idtutor);
        $data = array(
            'alumnos'=>$alumnos
        );
        $this->load->view('tutor/header');
        $this->load->view('tutor/alumnos/alumnos',$data);
        $this->load->view('tutor/footer');
       //$kardex = $this->alumno->allKardex($id);  
    }
    public function detalle($idalumno = '')
    {
         $kardex = $this->alumno->allKardex($idalumno);
         $detalle_alumno = $this->alumno->showAllAlumnoId($idalumno);
         
         $total_periodo = 0;
         $suma_calificacion = 0;
               if($kardex != FALSE){
            foreach ($kardex as $row) {
                $total_periodo = $total_periodo + 1;
                 $idhorario = $row->idhorario; 
                 $materias = $this->alumno->showAllMaterias($idhorario);
                 $unidades = $this->alumno->showAllUnidades($this->session->idplantel);
                 //var_dump($materias);
                 $total_materia = 0;
                 $total_unidad = 0;
                    if ($materias != FALSE) { 
                        foreach ($materias as $row) { 
                            $total_materia = $total_materia + 1;
                        }
                    } 
                    if(isset($unidades) && !empty($unidades)){
                        foreach ($unidades as $value) {
                            $total_unidad = $total_unidad + 1;
                        }
                    } 
                    $datoscalifiacacion = $this->horario->calificacionGeneralAlumno($idhorario,$idalumno);
                     if($datoscalifiacacion != FALSE && $total_materia > 0){
                          $suma_calificacion= ($datoscalifiacacion->calificaciongeneral / $total_unidad) / $total_materia;
                         }
                        // echo $suma_calificacion;

            }
           $calificacion_final = $suma_calificacion / $total_periodo;
        } 
         $alumnos = $this->alumno->showAllAlumnosTutor($this->session->idtutor);
        $data = array(
            'kardex'=>$kardex,
            'idalumno'=>$idalumno,
            'detalle_alumno'=>$detalle_alumno
        );
        $this->load->view('tutor/header');
        $this->load->view('tutor/alumnos/kardex',$data);
        $this->load->view('tutor/footer');
    }
}
