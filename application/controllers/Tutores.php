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
        $this->load->model('mensaje_model','mensaje');
        $this->load->model('cicloescolar_model','cicloescolar');
         $this->load->model('tutor_model','tutor');  
         $this->load->model('mensaje_model','mensaje'); 
        $this->load->model('data_model'); 
        $this->load->library('permission');
        $this->load->library('session');
        $this->load->library('pdfgenerator'); 
        $this->load->library('openpayservicio');
       $this->load->library('encryption');
       $this->promedio_minimo = 7.00;
	}
 
	public function index()
	{ 
       // $_SESSION['user_id'];
        Permission::grant(uri_string());
	    $this->load->view('tutor/header');
        $this->load->view('tutor/index');
        $this->load->view('tutor/footer');

	} 
    public function alumnos()
    {
        Permission::grant(uri_string());
        $alumnos = $this->alumno->showAllAlumnosTutorActivos($this->session->idtutor);
        
        $data = array(
            'alumnos'=>$alumnos,
            'controller'=>$this
        );
        $this->load->view('tutor/header');
        $this->load->view('tutor/alumnos/index',$data);
        $this->load->view('tutor/footer');
    }
     public function boleta($idhorario='',$idalumno = '',$idunidad = '')
  {
      Permission::grant(uri_string());
      $idhorario = $this->decode($idhorario);
      $idalumno = $this->decode($idalumno);
      $idunidad = $this->decode($idunidad);
      if((isset($idhorario) && !empty($idhorario)) && (isset($idalumno) && !empty($idalumno)) && (isset($idunidad) && !empty($idunidad))){
       $detalle_logo = $this->alumno->logo($this->session->idplantel);
        $logo = base_url() . '/assets/images/escuelas/'.$detalle_logo[0]->logoplantel;
        $logo2 = base_url() . '/assets/images/escuelas/'.$detalle_logo[0]->logosegundo;
        
       $datelle_alumno = $this->alumno->showAllMateriasAlumno($idalumno);
       $materias = $this->alumno->showAllMaterias($idhorario);
       $detalle_unidad = $this->alumno->detalleUnidad($idunidad);
       $this->load->library('tcpdf');  
        $hora = date("h:i:s a");
        //$linkimge = base_url() . '/assets/images/woorilogo.png';
        $fechaactual = date('d/m/Y');
        $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetTitle('Horario de clases.');
        $pdf->SetHeaderMargin(30);
        $pdf->SetTopMargin(10);
        $pdf->setFooterMargin(20);
        $pdf->SetAutoPageBreak(true);
        $pdf->SetAuthor('Author');
        $pdf->SetDisplayMode('real', 'default');
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        $pdf->AddPage();

        $tbl = '
<style type="text/css">
    .txtn{
        font-size:7px;
    }
    .direccion{
        font-size:8px;
    }
    .nombreplantel{
        font-size:11px;
        font-weight:bolder;
    }
    .telefono{
          font-size:7px;
    }
    .boleta{
         font-size:9px;
         font-weight:bolder;
    }
     .periodo{
         font-size:9px;
         font-weight:bolder;
    }
    .txtgeneral{
         font-size:8px;
         font-weight:bolder; 
    }
    .txtnota{
         font-size:6px;
         font-weight:bolder; 
    } 
    .txtcalificacion{
        font-size:10px;
         font-weight:bolder; 
    } 
    .imgtitle{
        width:55px;

    }
</style>
<table width="610" border="0" cellpadding="2" cellspacing="0">
  <tr>
    <td width="101" align="center"><img   class="imgtitle" src="' . $logo2 . '" /></td>
    <td colspan="2" align="center">
            <label class="nombreplantel">'.$datelle_alumno[0]->nombreplantel.'</label><br>
            <label class="txtn">INCORPORADA A LA UNIVERSIDAD DE GUANAJUATO SEGÚN EL OFICIO 14/ABRIL/1972</label><br>
            <label class="direccion">'.$datelle_alumno[0]->direccion.'</label><br>
            <label class="telefono">TELÉFONO: '.$datelle_alumno[0]->telefono.' EXT 1</label>
    </td>
    <td width="137" align="center"><img   class="imgtitle" src="' . $logo . '" /></td>
  </tr>
   <tr>
    <td width="543" colspan="3" align="center"><label class="boleta">BOLETA DE CALIFICACIONES DEL '.$detalle_unidad[0]->nombreunidad.'</label></td>  
  </tr>
   <tr> 
    <td width="543" colspan="3" align="center"><label class="periodo">PERIODO: '.$datelle_alumno[0]->mesinicio.' - '.$datelle_alumno[0]->mesfin.' DE '.$datelle_alumno[0]->yearfin.'</label></td> 
  </tr>
 <tr>
    <td width="50" valign="bottom"  class="txtgeneral" >NOMBRE:</td>
    <td width="300" valign="bottom" class="txtgeneral" style="border-bottom:solid 1px black;"> '.$datelle_alumno[0]->apellidop.' '.$datelle_alumno[0]->apellidom.' '.$datelle_alumno[0]->nombre.'</td>
    <td width="60" valign="bottom" class="txtgeneral"> GRUPO:</td>
    <td width="130" valign="bottom" class="txtgeneral" style="border-bottom:solid 1px black;">'.$datelle_alumno[0]->nombrenivel.' '.$datelle_alumno[0]->nombregrupo.'</td>
  </tr>
  <tr>
   <td width="60" valign="bottom"  class="txtgeneral" >INSCRIPCIÓN:</td>
    <td width="290" valign="bottom" class="txtgeneral" style="border-bottom:solid 1px black;"> PRIMERA</td>
    <td width="60" valign="bottom" class="txtgeneral"> NUA:</td>
    <td width="130" valign="bottom" class="txtgeneral" style="border-bottom:solid 1px black;">'.$datelle_alumno[0]->matricula.'</td>
  </tr>
<tr>
   <td width="60" colspan="4" ></td> 
  </tr>
    <tr >
   <td width="60" style="border:solid 1px black; background-color:#ccc;" valign="bottom" align="center"  class="txtgeneral" >NUM</td>
    <td width="290" style="border:solid 1px black; background-color:#ccc;" valign="bottom"  align="center" class="txtgeneral">MATERIA</td>
    <td width="60" style="border:solid 1px black; background-color:#ccc;" valign="bottom"  align="center" class="txtgeneral">FALTAS</td>
    <td width="130"style="border:solid 1px black; background-color:#ccc;" valign="bottom"  align="center" class="txtgeneral">CALIFICACIÓN</td>
  </tr>
  ';
  if(isset($materias) && !empty($materias)){
    $numero = 1;
    $total_materia = 0;
    $total_calificacion = 0;
    $promedio_final = 0;
    $total_reprobadas = 0;
    $total_aprovadas = 0;
  foreach ($materias as $row) { 
    $total_materia = $total_materia + 1;
    $idhorariodetalle = $row->idhorariodetalle;
    $calificacion = $this->alumno->obtenerCalificacionMateria($idhorariodetalle,$idalumno,$idunidad);
     $asistencia = $this->alumno->obtenerAsistenciaMateria($idhorariodetalle,$idalumno,$idunidad);
    $tbl .=' <tr >
           <td width="60" style="border:solid 1px black;" valign="bottom" align="center"  class="txtgeneral" >'.$numero++.'</td>
            <td width="290" style="border:solid 1px black;" valign="bottom" class="txtgeneral">'.$row->nombreclase.'</td>
            <td width="60" style="border:solid 1px black;" valign="bottom"  align="center" class="txtgeneral">';
                 if($asistencia != FALSE){
                    $total_falta = 0;
                        foreach ($asistencia as  $value) {
                           $total_falta = $total_falta + 1;
                        }
                    $tbl .= '<label>'.$total_falta.'</label>';
                    }else{
                        $tbl .= '0';
                    }
            $tbl .= '</td>
            <td width="130"style="border:solid 1px black;" align="center" valign="bottom" class="txtgeneral">';
            if($calificacion != FALSE){
                $total_calificacion = $total_calificacion + $calificacion->calificacion;
                if($calificacion->calificacion < $this->promedio_minimo){
                    $total_reprobadas = $total_reprobadas + 1;
                     $tbl .= '<label style="color:red;">'.$calificacion->calificacion.'</label>';
                }else{
                    $total_aprovadas= $total_aprovadas + 1;
                     $tbl .= '<label>'.$calificacion->calificacion.'</label>';
                }
            }else{
                $tbl .= 'S/C';
            }
           $tbl .='</td>
          </tr>';
  }
  $promedio_final = $total_calificacion / $total_materia;
}
$tbl .='<tr >
   <td width="60" style="" valign="bottom" align="center"  class="txtgeneral" ></td>
    <td width="290" style="" valign="bottom"  align="center" class="txtgeneral"></td>
    <td width="60" style="border:solid 1px black; background-color:#ccc;" valign="bottom"  align="center" class="txtgeneral">PROMEDIO:</td>
    <td width="130"style="border:solid 1px black; background-color:#ccc;" valign="bottom"  align="center" class="txtcalificacion">'.number_format($promedio_final,2).'</td>
  </tr>
  <tr >
   <td width="60" style="" valign="bottom" align="center"  class="txtgeneral" ></td>
    <td width="290" style="" valign="bottom"  align="center" class="txtgeneral"></td>
    <td width="60"  valign="bottom"  align="center" class="txtgeneral"></td>
    <td width="130" valign="bottom"  align="center" class="txtgeneral"></td>
  </tr>
  <tr >
   <td width="60" style="" valign="bottom" align="center"  class="txtgeneral" ></td>
    <td width="290" style="" valign="bottom"  align="center" class="txtgeneral"></td>
    <td width="60" class="txtgeneral"></td>
    <td width="130"style="" valign="bottom"  align="right" class="txtgeneral">APROVADAS: '.$total_aprovadas.'</td>
  </tr>
   <tr >
   <td width="60" style="" valign="bottom" align="center"  class="txtgeneral"  ></td>
    <td width="290" style="" valign="bottom"  align="center" style="border-bottom:solid 2px black" class="txtgeneral"></td>
    <td width="60" class="txtgeneral" ></td>
    <td width="130"style="" valign="bottom"  align="right" class="txtgeneral">REPROVADAS: '.$total_reprobadas.'</td>
  </tr>
   <tr >
   <td width="60" style="" valign="bottom" align="center"  class="txtgeneral"  ></td>
    <td width="290" style="" valign="bottom"  align="center" style="" class="txtgeneral">LRI.MARÍA ELENA DURÁN HERNÁNDEZ</td> 
    <td width="190"  colspan= "2"  style="" valign="bottom"  align="center" class="txtgeneral"> *Sin validez oficial </td>
  </tr>
  <tr > 
    <td width="540"  colspan= "4"  style="" valign="bottom"  align="left" class="txtnota">   </td>
  </tr>
  <tr > 
    <td width="540"  colspan= "4"  style="" valign="bottom"  align="left" class="txtnota">  </td>
  </tr>
  <tr > 
    <td width="540"  colspan= "4"  style="" valign="bottom"  align="left" class="txtnota"> NOTA: AC = ACREDITADO, NA= NO ACREDITADO, MÍNIMA APROVATORIA = 7.0 </td>
  </tr>
  ';
$tbl .='</table>
 

      ';

        $pdf->writeHTML($tbl, true, false, false, false, '');

    ob_end_clean();


        $pdf->Output('My-File-Name.pdf', 'I');
         }else{
        $data = array(
            'heading'=>'Error',
            'message'=>'Intente mas tarde.'
        );
         $this->load->view('errors/html/error_general',$data);
    }
  }
    public function horario($idalumno = '')
    {
        $idalumno = $this->decode($idalumno);
        if(isset($idalumno) && !empty($idalumno)){
       $detalle = $this->alumno->showAllMateriasAlumno($idalumno);
       $idhorario = '';
       if(isset($detalle[0]->idhorario) && !empty($detalle[0]->idhorario)){
        $idhorario =  $detalle[0]->idhorario;
       } 
        $data = array(
            'idhorario'=>$idhorario,
            'idalumno'=>$idalumno,
            'controller'=>$this
        ); 
        $this->load->view('tutor/header');
        $this->load->view('tutor/alumnos/horario',$data);
        $this->load->view('tutor/footer');
         }else{
         $data = array(
            'heading'=>'Error',
            'message'=>'Error intente mas tarde.'
        );
         $this->load->view('errors/html/error_general',$data);
    }
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
            if($val->calificacion >= $this->promedio_minimo){
                 $tabla .='<label style="color:green;">'.$val->calificacion.'</label>'; 
            }else{
                $tabla .='<label style="color:red;">'.$val->calificacion.'</label>';
            } 
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
        Permission::grant(uri_string());
        $idalumno = $this->decode($idalumno);
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
        Permission::grant(uri_string());
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
        Permission::grant(uri_string());
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
    public function tareas($idalumno = '',$idnivelestudio = '',$idperiodo = ''){
        Permission::grant(uri_string());
        $idalumno = $this->decode($idalumno);
        $idperiodo = $this->decode($idperiodo);
        if((isset($idalumno) && !empty($idalumno)) && (isset($idperiodo) && !empty($idperiodo))){
            $detalle = $this->alumno->showAllMateriasAlumno($idalumno);
            if(isset($detalle[0]->idhorario) && !empty($detalle[0]->idhorario)){
                $idhorario = $detalle[0]->idhorario;
                $idhorariodetalle =  $detalle[0]->idhorariodetalle;
                $tareas = $this->alumno->showAllTareaAlumno($idhorario);
                $data = array(
                    'tareas'=>$tareas,
                    'controller'=>$this
                );
                    $this->load->view('tutor/header');
                    $this->load->view('tutor/alumnos/tareas',$data);
                    $this->load->view('tutor/footer');
                }else{
                $data = array(
                    'heading'=>'Notificación',
                    'message'=>'El Alumno(a) no tiene registrado Tareas.'
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

    public function detalletarea($idtarea = '')
    {
        $idtarea = $this->decode($idtarea);
        if(isset($idtarea) && !empty($idtarea)){
            $detalle_tarea = $this->mensaje->detalleTarea($idtarea);
            $data = array(
                'tarea'=>$detalle_tarea
            );
             $this->load->view('tutor/header');
             $this->load->view('tutor/detalle/tarea',$data);
             $this->load->view('tutor/footer');

        }else{
              $data = array(
                    'heading'=>'Error',
                    'message'=>'Intente mas tarde.'
                );
             $this->load->view('errors/html/error_general',$data);
        }
    }
 
     public function asistencias($idalumno='')
    {
        Permission::grant(uri_string());
         $idalumno = $this->decode($idalumno);
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
        Permission::grant(uri_string());
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
        Permission::grant(uri_string());
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
    public function pagos($idalumno = '',$idnivel = '',$idperiodo = '')
    { 
        Permission::grant(uri_string());
        $idalumno = $this->decode($idalumno);
        $idnivel = $this->decode($idnivel);
        $idperiodo = $this->decode($idperiodo);
        //$this->encryption->initialize(array('driver' => 'openssl'));
        if((isset($idalumno) && !empty($idalumno)) && (isset($idnivel) && !empty($idnivel)) && (isset($idperiodo) && !empty($idperiodo))){
        $pago_inicio = $this->alumno->showAllPagoInscripcion($idalumno,$idperiodo); 
        $data = array(
            'pago_inicio'=>$pago_inicio,
            'idalumno'=>$this->encode($idalumno),
            'idperiodo'=>$this->encode($idperiodo),
            'idnivel'=>$this->encode($idnivel), 
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
        Permission::grant(uri_string());
         $idalumno = $this->decode($idalumno);
          $idperiodo = $this->decode($idperiodo);
           $idnivel = $this->decode($idnivel); 
        
        if((isset($idalumno) && !empty($idalumno)) && (isset($idperiodo) && !empty($idperiodo)) && (isset($idnivel) && !empty($idnivel)) && (isset($tipo) && !empty($tipo)))
        {
            $mensaje = "";
        if($tipo == 1){
            $detalle = $this->tutor->precioColegiatura(2,$idnivel);
            $mensaje .= "PAGO DE REINSCRIPCIÓN";
         }elseif($tipo == 2){
             $detalle = $this->tutor->precioColegiatura(3,$idnivel);
             $mensaje .= "PAGO DE MENSUALIDAD";
         }else{
             $detalle = false;
         }

        if($detalle != false){
         $descuento = $detalle[0]->descuento;
         $data = array( 
            'idalumno'=>$this->encode($idalumno),
            'idperiodo'=>$this->encode($idperiodo),
            'descuento'=>$descuento,
            'mensaje'=>$mensaje,
            'idnivel'=>$this->encode($idnivel),
            'formapago'=>1
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
     public function pagoc($idalumno = '',$idperiodo = '',$idnivel = '',$tipo = '')
    {
        Permission::grant(uri_string());
         $idalumno = $this->decode($idalumno);
          $idperiodo = $this->decode($idperiodo);
           $idnivel = $this->decode($idnivel); 
        
        if((isset($idalumno) && !empty($idalumno)) && (isset($idperiodo) && !empty($idperiodo)) && (isset($idnivel) && !empty($idnivel)) && (isset($tipo) && !empty($tipo)))
        {
            $mensaje = "";
        if($tipo == 1){
            $detalle = $this->tutor->precioColegiatura(2,$idnivel);
            $mensaje .= "PAGO DE REINSCRIPCIÓN";
         }elseif($tipo == 2){
             $detalle = $this->tutor->precioColegiatura(3,$idnivel);
             $mensaje .= "PAGO DE MENSUALIDAD";
         }else{
             $detalle = false;
         }

        if($detalle != false){
         $descuento = $detalle[0]->descuento;
         $meses = $this->tutor->showAllMeses($idalumno,$idperiodo);
         $data = array( 
            'idalumno'=>$this->encode($idalumno),
            'idperiodo'=>$this->encode($idperiodo),
            'descuento'=>$descuento,
            'mensaje'=>$mensaje,
            'meses'=>$meses,
            'idnivel'=>$this->encode($idnivel),
            'formapago'=>1
        );
         $this->load->view('tutor/header');
        $this->load->view('tutor/alumnos/pago_colegiatura',$data);
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
        Permission::grant(uri_string());
        $idperiodo = $this->decode($this->input->post('periodo'));
        $idalumno = $this->decode($this->input->post('alumno'));
        $idnivel = $this->decode($this->input->post('nivel'));
        if((isset($idnivel) && !empty($idnivel)) && (isset($idperiodo) && !empty($idperiodo)) && (isset($idalumno) && !empty($idalumno))){
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
                        //var_dump($charge->authorization);
                         $idopenpay = $charge->id;
                         $idorden = $charge->order_id;
                         $autorizacion = $charge->authorization; 
                        $add_cobro = array(
                            'idperiodo'=>$idperiodo,
                            'idalumno'=>$idalumno,
                            'idformapago'=>2,
                            'idtipopagocol'=>2,
                            'descuento'=>$descuento,
                            'idopenpay'=>$idopenpay,
                            'idorden'=>$idorden,
                            'autorizacion'=>$autorizacion, 
                            'online'=>1,
                            'pagado'=>1,
                            'fechapago'=>date('Y-m-d H:i:s'),
                            'eliminado'=>0,
                            'idusuario'=> $this->session->user_id,
                            'fecharegistro'=>date('Y-m-d H:i:s')
                        );
                        $this->tutor->addCobroReinscripcion($add_cobro);
                         $mensaje = "PAGO DE REINSCRIPCIÓN";
                         $data = array( 
                                'formapago'=>1,
                                'idalumno'=>$this->encode($idalumno),
                                'idperiodo'=>$this->encode($idperiodo),
                                'descuento'=>$descuento,
                                'mensaje'=>$mensaje,
                                'idnivel'=>$this->encode($idnivel),
                                'numeroautorizacion'=>$autorizacion
                            );
                            $this->load->view('tutor/header');
                            $this->load->view('tutor/alumnos/pago_inscripcion',$data);
                            $this->load->view('tutor/footer');
                       
                    } catch (OpenpayApiTransactionError $e) {
                        $mensaje = "";
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
                         $mensaje_pago = "PAGO DE REINSCRIPCIÓN";
                         $data = array( 
                                'formapago'=>1,
                                'idalumno'=>$this->encode($idalumno),
                                'idperiodo'=>$this->encode($idperiodo),
                                'descuento'=>$descuento,
                                'mensaje'=>$mensaje_pago,
                                'idnivel'=>$this->encode($idnivel), 
                                'error'=>$mensaje
                            );
                            $this->load->view('tutor/header');
                            $this->load->view('tutor/alumnos/pago_inscripcion',$data);
                            $this->load->view('tutor/footer');
                        
                    } catch (OpenpayApiRequestError $e) {
                        $mensaje .= $e->getMessage();
                         $mensaje_pago = "PAGO DE REINSCRIPCIÓN";
                         $data = array( 
                                'formapago'=>1,
                                'idalumno'=>$this->encode($idalumno),
                                'idperiodo'=>$this->encode($idperiodo),
                                'descuento'=>$descuento,
                                'mensaje'=>$mensaje_pago,
                                'idnivel'=>$this->encode($idnivel), 
                                'error'=>$mensaje
                            );
                            $this->load->view('tutor/header');
                            $this->load->view('tutor/alumnos/pago_inscripcion',$data);
                            $this->load->view('tutor/footer');
                         
                    } catch (OpenpayApiConnectionError $e) {
                        $mensaje .= $e->getMessage();
                         $mensaje_pago = "PAGO DE REINSCRIPCIÓN";
                         $data = array( 
                                 'formapago'=>1,
                                'idalumno'=>$this->encode($idalumno),
                                'idperiodo'=>$this->encode($idperiodo),
                                'descuento'=>$descuento,
                                'mensaje'=>$mensaje_pago,
                                'idnivel'=>$this->encode($idnivel), 
                                'error'=>$mensaje
                            );
                            $this->load->view('tutor/header');
                            $this->load->view('tutor/alumnos/pago_inscripcion',$data);
                            $this->load->view('tutor/footer');
                       
                    } catch (OpenpayApiAuthError $e) {
                        $mensaje .= $e->getMessage();
                         $mensaje_pago = "PAGO DE REINSCRIPCIÓN";
                         $data = array( 
                                'formapago'=>1,    
                                'idalumno'=>$this->encode($idalumno),
                                'idperiodo'=>$this->encode($idperiodo),
                                'descuento'=>$descuento,
                                'mensaje'=>$mensaje_pago,
                                'idnivel'=>$this->encode($idnivel), 
                                'error'=>$mensaje
                            );
                            $this->load->view('tutor/header');
                            $this->load->view('tutor/alumnos/pago_inscripcion',$data);
                            $this->load->view('tutor/footer');
                      
                    } catch (OpenpayApiError $e) {
                        $mensaje .= $e->getMessage();
                         $mensaje_pago = "PAGO DE REINSCRIPCIÓN";
                         $data = array(
                                'formapago'=>1, 
                                'idalumno'=>$this->encode($idalumno),
                                'idperiodo'=>$this->encode($idperiodo),
                                'descuento'=>$descuento,
                                'mensaje'=>$mensaje_pago,
                                'idnivel'=>$this->encode($idnivel), 
                                'error'=>$mensaje
                            );
                            $this->load->view('tutor/header');
                            $this->load->view('tutor/alumnos/pago_inscripcion',$data);
                            $this->load->view('tutor/footer');
                         
                    } catch (Exception $e) {
                        $mensaje .= $e->getMessage();
                         $mensaje_pago = "PAGO DE REINSCRIPCIÓN";
                         $data = array(
                                'formapago'=>1, 
                                'idalumno'=>$this->encode($idalumno),
                                'idperiodo'=>$this->encode($idperiodo),
                                'descuento'=>$descuento,
                                'mensaje'=>$mensaje_pago,
                                'idnivel'=>$this->encode($idnivel), 
                                'error'=>$mensaje
                            );
                            $this->load->view('tutor/header');
                            $this->load->view('tutor/alumnos/pago_inscripcion',$data);
                            $this->load->view('tutor/footer');
                        
                    }
                      }else{
         $data = array(
            'heading'=>'Error',
            'message'=>'Error intente mas tarde.'
        );
         $this->load->view('errors/html/error_general',$data);
        }
    }
     public function pagotarjetac()
    {
        Permission::grant(uri_string());
        $idperiodo = $this->decode($this->input->post('periodo'));
        $idalumno = $this->decode($this->input->post('alumno'));
        $idnivel = $this->decode($this->input->post('nivel'));
        if((isset($idnivel) && !empty($idnivel)) && (isset($idperiodo) && !empty($idperiodo)) && (isset($idalumno) && !empty($idalumno))){
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
                $idmes  = $this->input->post('mespago');
                $detalle_mes = $this->tutor->detalleMes($idmes);
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
                            'description' => $mensaje." DE ".$detalle_mes[0]->nombremes,
                            'device_session_id' => $_POST["deviceIdHiddenFieldName"],
                            'customer' => $customer
                        );

                        $charge = $openpay->charges->create($chargeData);
                        $response['charge'] = $charge;  
                         $idopenpay = $charge->id;
                         $idorden = $charge->order_id;
                         $autorizacion = $charge->authorization; 
                        
                         /*$data = array(
                            'idperiodo'=>$idperiodo,
                            'idalumno'=>$idalumno,
                            'idformapago'=>2,
                            'idtipopagocol'=>2,
                            'descuento'=>$descuento,
                            'idopenpay'=>$idopenpay,
                            'idorden'=>$idorden,
                            'autorizacion'=>$autorizacion, 
                            'online'=>1,
                            'pagado'=>1,
                            'fechapago'=>date('Y-m-d H:i:s'),
                            'eliminado'=>0,
                            'idusuario'=> $this->session->user_id,
                            'fecharegistro'=>date('Y-m-d H:i:s')
                        );
                        $this->tutor->addCobroReinscripcion($data);*/
                        $add_amortizacion = array(
                            'idalumno'=>$idalumno,
                            'idperiodo'=>$idperiodo,
                            'idperiodopago'=>$idmes,
                            'descuento'=>$descuento,
                            'pagado'=>1,
                            'idusuario'=> $this->session->user_id,
                            'fecharegistro'=>date('Y-m-d H:i:s')
                        );
                        $idamortizacion = $this->tutor->addAmortizacion($add_amortizacion);
                        $add_estadocuenta = array(
                            'idamortizacion'=>$idamortizacion,
                            'idperiodo'=>$idperiodo,
                            'idalumno'=>$idalumno,
                            'idformapago'=>2,
                            'descuento'=>$descuento,
                            'idopenpay'=>$idopenpay,
                            'idorden'=>$idorden,
                            'autorizacion'=>$autorizacion, 
                            'online'=>1,
                            'pagado'=>1,
                            'fechapago'=>date('Y-m-d H:i:s'), 
                            'idusuario'=> $this->session->user_id,
                            'fecharegistro'=>date('Y-m-d H:i:s')
                        );
                        $idestadocuenta = $this->tutor->addEstadoCuenta($add_estadocuenta);
                        $add_detalle_pago = array(
                            'idestadocuenta'=>$idestadocuenta,
                            'idformapago'=>2,
                            'descuento'=>$descuento,
                            'autorizacion'=>$autorizacion,
                            'fechapago'=>date('Y-m-d H:i:s'), 
                            'idusuario'=> $this->session->user_id,
                            'fecharegistro'=>date('Y-m-d H:i:s')
                        );
                        $this->tutor->addDetallePago($add_detalle_pago);
                         $mensaje = "PAGO DE MENSUALIDAD";
                         $data = array( 
                                'formapago'=>1,
                                'idalumno'=>$this->encode($idalumno),
                                'idperiodo'=>$this->encode($idperiodo),
                                'descuento'=>$descuento,
                                'mensaje'=>$mensaje,
                                'idnivel'=>$this->encode($idnivel),
                                'numeroautorizacion'=>$autorizacion
                            );
                            $this->load->view('tutor/header');
                            $this->load->view('tutor/alumnos/pago_colegiatura',$data);
                            $this->load->view('tutor/footer');
                       
                    } catch (OpenpayApiTransactionError $e) {
                        $mensaje = "";
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
                         $mensaje_pago = "PAGO DE MENSUALIDAD";
                         $data = array( 
                                'formapago'=>1,
                                'idalumno'=>$this->encode($idalumno),
                                'idperiodo'=>$this->encode($idperiodo),
                                'descuento'=>$descuento,
                                'mensaje'=>$mensaje_pago,
                                'idnivel'=>$this->encode($idnivel), 
                                'error'=>$mensaje
                            );
                            $this->load->view('tutor/header');
                            $this->load->view('tutor/alumnos/pago_colegiatura',$data);
                            $this->load->view('tutor/footer');
                        
                    } catch (OpenpayApiRequestError $e) {
                        $mensaje .= $e->getMessage();
                         $mensaje_pago = "PAGO DE MENSUALIDAD";
                         $data = array( 
                                'formapago'=>1,
                                'idalumno'=>$this->encode($idalumno),
                                'idperiodo'=>$this->encode($idperiodo),
                                'descuento'=>$descuento,
                                'mensaje'=>$mensaje_pago,
                                'idnivel'=>$this->encode($idnivel), 
                                'error'=>$mensaje
                            );
                            $this->load->view('tutor/header');
                            $this->load->view('tutor/alumnos/pago_colegiatura',$data);
                            $this->load->view('tutor/footer');
                         
                    } catch (OpenpayApiConnectionError $e) {
                        $mensaje .= $e->getMessage();
                         $mensaje_pago = "PAGO DE MENSUALIDAD";
                         $data = array( 
                                 'formapago'=>1,
                                'idalumno'=>$this->encode($idalumno),
                                'idperiodo'=>$this->encode($idperiodo),
                                'descuento'=>$descuento,
                                'mensaje'=>$mensaje_pago,
                                'idnivel'=>$this->encode($idnivel), 
                                'error'=>$mensaje
                            );
                            $this->load->view('tutor/header');
                            $this->load->view('tutor/alumnos/pago_colegiatura',$data);
                            $this->load->view('tutor/footer');
                       
                    } catch (OpenpayApiAuthError $e) {
                        $mensaje .= $e->getMessage();
                         $mensaje_pago = "PAGO DE MENSUALIDAD";
                         $data = array( 
                                'formapago'=>1,    
                                'idalumno'=>$this->encode($idalumno),
                                'idperiodo'=>$this->encode($idperiodo),
                                'descuento'=>$descuento,
                                'mensaje'=>$mensaje_pago,
                                'idnivel'=>$this->encode($idnivel), 
                                'error'=>$mensaje
                            );
                            $this->load->view('tutor/header');
                            $this->load->view('tutor/alumnos/pago_colegiatura',$data);
                            $this->load->view('tutor/footer');
                      
                    } catch (OpenpayApiError $e) {
                        $mensaje .= $e->getMessage();
                         $mensaje_pago = "PAGO DE MENSUALIDAD";
                         $data = array(
                                'formapago'=>1, 
                                'idalumno'=>$this->encode($idalumno),
                                'idperiodo'=>$this->encode($idperiodo),
                                'descuento'=>$descuento,
                                'mensaje'=>$mensaje_pago,
                                'idnivel'=>$this->encode($idnivel), 
                                'error'=>$mensaje
                            );
                            $this->load->view('tutor/header');
                            $this->load->view('tutor/alumnos/pago_colegiatura',$data);
                            $this->load->view('tutor/footer');
                         
                    } catch (Exception $e) {
                        $mensaje .= $e->getMessage();
                         $mensaje_pago = "PAGO DE MENSUALIDAD";
                         $data = array(
                                'formapago'=>1, 
                                'idalumno'=>$this->encode($idalumno),
                                'idperiodo'=>$this->encode($idperiodo),
                                'descuento'=>$descuento,
                                'mensaje'=>$mensaje_pago,
                                'idnivel'=>$this->encode($idnivel), 
                                'error'=>$mensaje
                            );
                            $this->load->view('tutor/header');
                            $this->load->view('tutor/alumnos/pago_colegiatura',$data);
                            $this->load->view('tutor/footer');
                        
                    }
                      }else{
         $data = array(
            'heading'=>'Error',
            'message'=>'Error intente mas tarde.'
        );
         $this->load->view('errors/html/error_general',$data);
        }
    }
 
 
 public function pagotienda()
 {
     Permission::grant(uri_string());
        $idperiodo = $this->decode($this->input->post('periodo'));
        $idalumno = $this->decode($this->input->post('alumno'));
        $idnivel = $this->decode($this->input->post('nivel'));
        if((isset($idnivel) && !empty($idnivel)) && (isset($idperiodo) && !empty($idperiodo)) && (isset($idalumno) && !empty($idalumno))){
            try {
                 $idtutor = $this->session->idtutor;
                $detalle_tutor = $this->tutor->detalleTutor($idtutor);
                $descuento  = $this->input->post('descuento'); 
                $mensaje  = $this->input->post('mensaje');
                        $response = [];
                        Openpay::setProductionMode(false);
                        $openpay = Openpay::getInstance('mds4bdhgvbese0knzu2x', 'sk_f95d7349163642fba9f5a71021b3f6d5');
                         $customer = array(
                            'name' => strtoupper($detalle_tutor->nombre),
                            'last_name' => strtoupper($detalle_tutor->apellidop.' '.$detalle_tutor->apellidom),
                            'email' => $detalle_tutor->correo,
                            'phone_number' => $detalle_tutor->telefono
                        );
                        $chargeData = array(
                                    'method' => 'store',
                                    'amount' => $descuento,
                                    'description' => $mensaje,
                                     'customer' => $customer); 
                        $charge = $openpay->charges->create($chargeData);
                        $response['charge'] = $charge; 
                        //var_dump($charge);
                         $idopenpay = $charge->id;
                         $idorden = $charge->order_id;
                         $autorizacion = $charge->authorization;
                         $barcode = $charge->payment_method->barcode_url;
                         $referencia =$charge->payment_method->reference;
                        //var_dump($charge["authorization"]);
                        //var_dump($charge->authorization);
                        //$autorizacion = $charge->authorization;
                        $add_cobro = array(
                            'idperiodo'=>$idperiodo,
                            'idalumno'=>$idalumno,
                            'idformapago'=>1,
                            'idtipopagocol'=>2,
                            'descuento'=>$descuento,
                            'idopenpay'=>$idopenpay,
                            'idorden'=>$idorden,
                            'autorizacion'=>$autorizacion,
                            'online'=>1,
                            'pagado'=>0,
                            'fechapago'=>date('Y-m-d H:i:s'),
                            'eliminado'=>0,
                            'idusuario'=> $this->session->user_id,
                            'fecharegistro'=>date('Y-m-d H:i:s')
                        );
                        $this->tutor->addCobroReinscripcion($add_cobro);
                         $mensaje = "PAGO DE REINSCRIPCIÓN";
                         $data = array( 
                                'formapago'=>0,
                                'opcion'=>0,
                                'idalumno'=>$this->encode($idalumno),
                                'idperiodo'=>$this->encode($idperiodo),
                                'descuento'=>$descuento,
                                'mensaje'=>$mensaje,
                                'idnivel'=>$this->encode($idnivel),
                                'opcion'=>1,
                                'referencia'=>$referencia
                            );
                            $this->load->view('tutor/header');
                            $this->load->view('tutor/alumnos/pago_inscripcion',$data);
                            $this->load->view('tutor/footer');
                       
                    } catch (OpenpayApiTransactionError $e) {
                        $mensaje = "";
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
                         $mensaje_pago = "PAGO DE REINSCRIPCIÓN";
                         $data = array( 
                             'formapago'=>0,
                                'opcion'=>0,
                                'idalumno'=>$this->encode($idalumno),
                                'idperiodo'=>$this->encode($idperiodo),
                                'descuento'=>$descuento,
                                'mensaje'=>$mensaje_pago,
                                'idnivel'=>$this->encode($idnivel), 
                                'error'=>$mensaje
                            );
                            $this->load->view('tutor/header');
                            $this->load->view('tutor/alumnos/pago_inscripcion',$data);
                            $this->load->view('tutor/footer');
                        
                    } catch (OpenpayApiRequestError $e) {
                        $mensaje .= $e->getMessage();
                         $mensaje_pago = "PAGO DE REINSCRIPCIÓN";
                         $data = array( 
                                'formapago'=>0,
                                'opcion'=>0,
                                'idalumno'=>$this->encode($idalumno),
                                'idperiodo'=>$this->encode($idperiodo),
                                'descuento'=>$descuento,
                                'mensaje'=>$mensaje_pago,
                                'idnivel'=>$this->encode($idnivel), 
                                'error'=>$mensaje
                            );
                            $this->load->view('tutor/header');
                            $this->load->view('tutor/alumnos/pago_inscripcion',$data);
                            $this->load->view('tutor/footer');
                         
                    } catch (OpenpayApiConnectionError $e) {
                        $mensaje .= $e->getMessage();
                         $mensaje_pago = "PAGO DE REINSCRIPCIÓN";
                         $data = array( 
                             'formapago'=>0,
                                'opcion'=>0,
                                'idalumno'=>$this->encode($idalumno),
                                'idperiodo'=>$this->encode($idperiodo),
                                'descuento'=>$descuento,
                                'mensaje'=>$mensaje_pago,
                                'idnivel'=>$this->encode($idnivel), 
                                'error'=>$mensaje
                            );
                            $this->load->view('tutor/header');
                            $this->load->view('tutor/alumnos/pago_inscripcion',$data);
                            $this->load->view('tutor/footer');
                       
                    } catch (OpenpayApiAuthError $e) {
                        $mensaje .= $e->getMessage();
                         $mensaje_pago = "PAGO DE REINSCRIPCIÓN";
                         $data = array( 
                             'formapago'=>0,
                                'opcion'=>0,
                                'idalumno'=>$this->encode($idalumno),
                                'idperiodo'=>$this->encode($idperiodo),
                                'descuento'=>$descuento,
                                'mensaje'=>$mensaje_pago,
                                'idnivel'=>$this->encode($idnivel), 
                                'error'=>$mensaje
                            );
                            $this->load->view('tutor/header');
                            $this->load->view('tutor/alumnos/pago_inscripcion',$data);
                            $this->load->view('tutor/footer');
                      
                    } catch (OpenpayApiError $e) {
                        $mensaje .= $e->getMessage();
                         $mensaje_pago = "PAGO DE REINSCRIPCIÓN";
                         $data = array(
                             'formapago'=>0,
                                'opcion'=>0, 
                                'idalumno'=>$this->encode($idalumno),
                                'idperiodo'=>$this->encode($idperiodo),
                                'descuento'=>$descuento,
                                'mensaje'=>$mensaje_pago,
                                'idnivel'=>$this->encode($idnivel), 
                                'error'=>$mensaje
                            );
                            $this->load->view('tutor/header');
                            $this->load->view('tutor/alumnos/pago_inscripcion',$data);
                            $this->load->view('tutor/footer');
                         
                    } catch (Exception $e) {
                        $mensaje .= $e->getMessage();
                         $mensaje_pago = "PAGO DE REINSCRIPCIÓN";
                         $data = array(
                             'formapago'=>0,
                                'opcion'=>0, 
                                'idalumno'=>$this->encode($idalumno),
                                'idperiodo'=>$this->encode($idperiodo),
                                'descuento'=>$descuento,
                                'mensaje'=>$mensaje_pago,
                                'idnivel'=>$this->encode($idnivel), 
                                'error'=>$mensaje
                            );
                            $this->load->view('tutor/header');
                            $this->load->view('tutor/alumnos/pago_inscripcion',$data);
                            $this->load->view('tutor/footer');
                        
                    }
                      }else{
         $data = array(
            'heading'=>'Error',
            'message'=>'Error intente mas tarde.'
        );
         $this->load->view('errors/html/error_general',$data);
        }
 }
 public function pagotiendac()
 {
     Permission::grant(uri_string());
        $idperiodo = $this->decode($this->input->post('periodo'));
        $idalumno = $this->decode($this->input->post('alumno'));
        $idnivel = $this->decode($this->input->post('nivel'));
        if((isset($idnivel) && !empty($idnivel)) && (isset($idperiodo) && !empty($idperiodo)) && (isset($idalumno) && !empty($idalumno))){
            try {
                 $idtutor = $this->session->idtutor;
                $detalle_tutor = $this->tutor->detalleTutor($idtutor);
                $descuento  = $this->input->post('descuento'); 
                $mensaje  = $this->input->post('mensaje');
                $idmes  = $this->input->post('mespago');
                $detalle_mes = $this->tutor->detalleMes($idmes);
                        $response = [];
                        Openpay::setProductionMode(false);
                        $openpay = Openpay::getInstance('mds4bdhgvbese0knzu2x', 'sk_f95d7349163642fba9f5a71021b3f6d5');
                         $customer = array(
                            'name' => strtoupper($detalle_tutor->nombre),
                            'last_name' => strtoupper($detalle_tutor->apellidop.' '.$detalle_tutor->apellidom),
                            'email' => $detalle_tutor->correo,
                            'phone_number' => $detalle_tutor->telefono
                        );
                        $chargeData = array(
                                    'method' => 'store',
                                    'amount' => $descuento,
                                    'description' => $mensaje." DE ".$detalle_mes[0]->nombremes,
                                     'customer' => $customer); 
                        $charge = $openpay->charges->create($chargeData);
                        $response['charge'] = $charge; 
                        //var_dump($charge);
                         $idopenpay = $charge->id;
                         $idorden = $charge->order_id;
                         $autorizacion = $charge->authorization;
                         $barcode = $charge->payment_method->barcode_url;
                         $referencia =$charge->payment_method->reference;
                        //var_dump($charge["authorization"]);
                        //var_dump($charge->authorization);
                        //$autorizacion = $charge->authorization;
                        /*$add_cobro = array(
                            'idperiodo'=>$idperiodo,
                            'idalumno'=>$idalumno,
                            'idformapago'=>1,
                            'idtipopagocol'=>2,
                            'descuento'=>$descuento,
                            'idopenpay'=>$idopenpay,
                            'idorden'=>$idorden,
                            'autorizacion'=>$autorizacion,
                            'online'=>1,
                            'pagado'=>0,
                            'fechapago'=>date('Y-m-d H:i:s'),
                            'eliminado'=>0,
                            'idusuario'=> $this->session->user_id,
                            'fecharegistro'=>date('Y-m-d H:i:s')
                        );
                        $this->tutor->addCobroReinscripcion($add_cobro);*/
                        $add_amortizacion = array(
                            'idalumno'=>$idalumno,
                            'idperiodo'=>$idperiodo,
                            'idperiodopago'=>$idmes,
                            'descuento'=>$descuento,
                            'pagado'=>1,
                            'idusuario'=> $this->session->user_id,
                            'fecharegistro'=>date('Y-m-d H:i:s')
                        );
                        $idamortizacion = $this->tutor->addAmortizacion($add_amortizacion);
                        $add_estadocuenta = array(
                            'idamortizacion'=>$idamortizacion,
                            'idperiodo'=>$idperiodo,
                            'idalumno'=>$idalumno,
                            'idformapago'=>2,
                            'descuento'=>$descuento,
                            'idopenpay'=>$idopenpay,
                            'idorden'=>$idorden,
                            'autorizacion'=>$autorizacion, 
                            'online'=>1,
                            'pagado'=>0,
                            'fechapago'=>date('Y-m-d H:i:s'), 
                            'idusuario'=> $this->session->user_id,
                            'fecharegistro'=>date('Y-m-d H:i:s')
                        );
                        $idestadocuenta = $this->tutor->addEstadoCuenta($add_estadocuenta);
                        $add_detalle_pago = array(
                            'idestadocuenta'=>$idestadocuenta,
                            'idformapago'=>2,
                            'descuento'=>$descuento,
                            'autorizacion'=>$autorizacion,
                            'fechapago'=>date('Y-m-d H:i:s'), 
                            'idusuario'=> $this->session->user_id,
                            'fecharegistro'=>date('Y-m-d H:i:s')
                        );
                        $this->tutor->addDetallePago($add_detalle_pago);
                         $mensaje = "PAGO DE MENSUALIDAD";
                         $data = array( 
                                'formapago'=>0,
                                'opcion'=>0,
                                'idalumno'=>$this->encode($idalumno),
                                'idperiodo'=>$this->encode($idperiodo),
                                'descuento'=>$descuento,
                                'mensaje'=>$mensaje,
                                'idnivel'=>$this->encode($idnivel),
                                'opcion'=>1,
                                'referencia'=>$referencia
                            );
                            $this->load->view('tutor/header');
                            $this->load->view('tutor/alumnos/pago_colegiatura',$data);
                            $this->load->view('tutor/footer');
                       
                    } catch (OpenpayApiTransactionError $e) {
                        $mensaje = "";
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
                         $mensaje_pago = "PAGO DE MENSUALIDAD";
                         $data = array( 
                             'formapago'=>0,
                                'opcion'=>0,
                                'idalumno'=>$this->encode($idalumno),
                                'idperiodo'=>$this->encode($idperiodo),
                                'descuento'=>$descuento,
                                'mensaje'=>$mensaje_pago,
                                'idnivel'=>$this->encode($idnivel), 
                                'error'=>$mensaje
                            );
                            $this->load->view('tutor/header');
                            $this->load->view('tutor/alumnos/pago_colegiatura',$data);
                            $this->load->view('tutor/footer');
                        
                    } catch (OpenpayApiRequestError $e) {
                        $mensaje .= $e->getMessage();
                         $mensaje_pago = "PAGO DE MENSUALIDAD";
                         $data = array( 
                                'formapago'=>0,
                                'opcion'=>0,
                                'idalumno'=>$this->encode($idalumno),
                                'idperiodo'=>$this->encode($idperiodo),
                                'descuento'=>$descuento,
                                'mensaje'=>$mensaje_pago,
                                'idnivel'=>$this->encode($idnivel), 
                                'error'=>$mensaje
                            );
                            $this->load->view('tutor/header');
                            $this->load->view('tutor/alumnos/pago_colegiatura',$data);
                            $this->load->view('tutor/footer');
                         
                    } catch (OpenpayApiConnectionError $e) {
                        $mensaje .= $e->getMessage();
                         $mensaje_pago = "PAGO DE MENSUALIDAD";
                         $data = array( 
                             'formapago'=>0,
                                'opcion'=>0,
                                'idalumno'=>$this->encode($idalumno),
                                'idperiodo'=>$this->encode($idperiodo),
                                'descuento'=>$descuento,
                                'mensaje'=>$mensaje_pago,
                                'idnivel'=>$this->encode($idnivel), 
                                'error'=>$mensaje
                            );
                            $this->load->view('tutor/header');
                            $this->load->view('tutor/alumnos/pago_colegiatura',$data);
                            $this->load->view('tutor/footer');
                       
                    } catch (OpenpayApiAuthError $e) {
                        $mensaje .= $e->getMessage();
                         $mensaje_pago = "PAGO DE MENSUALIDAD";
                         $data = array( 
                             'formapago'=>0,
                                'opcion'=>0,
                                'idalumno'=>$this->encode($idalumno),
                                'idperiodo'=>$this->encode($idperiodo),
                                'descuento'=>$descuento,
                                'mensaje'=>$mensaje_pago,
                                'idnivel'=>$this->encode($idnivel), 
                                'error'=>$mensaje
                            );
                            $this->load->view('tutor/header');
                            $this->load->view('tutor/alumnos/pago_colegiatura',$data);
                            $this->load->view('tutor/footer');
                      
                    } catch (OpenpayApiError $e) {
                        $mensaje .= $e->getMessage();
                         $mensaje_pago = "PAGO DE MENSUALIDAD";
                         $data = array(
                             'formapago'=>0,
                                'opcion'=>0, 
                                'idalumno'=>$this->encode($idalumno),
                                'idperiodo'=>$this->encode($idperiodo),
                                'descuento'=>$descuento,
                                'mensaje'=>$mensaje_pago,
                                'idnivel'=>$this->encode($idnivel), 
                                'error'=>$mensaje
                            );
                            $this->load->view('tutor/header');
                            $this->load->view('tutor/alumnos/pago_colegiatura',$data);
                            $this->load->view('tutor/footer');
                         
                    } catch (Exception $e) {
                        $mensaje .= $e->getMessage();
                         $mensaje_pago = "PAGO DE MENSUALIDAD";
                         $data = array(
                             'formapago'=>0,
                                'opcion'=>0, 
                                'idalumno'=>$this->encode($idalumno),
                                'idperiodo'=>$this->encode($idperiodo),
                                'descuento'=>$descuento,
                                'mensaje'=>$mensaje_pago,
                                'idnivel'=>$this->encode($idnivel), 
                                'error'=>$mensaje
                            );
                            $this->load->view('tutor/header');
                            $this->load->view('tutor/alumnos/pago_colegiatura',$data);
                            $this->load->view('tutor/footer');
                        
                    }
                      }else{
         $data = array(
            'heading'=>'Error',
            'message'=>'Error intente mas tarde.'
        );
         $this->load->view('errors/html/error_general',$data);
        }
 }
    public function kardex()
    {
        Permission::grant(uri_string());
        $alumnos = $this->alumno->showAllAlumnosTutor($this->session->idtutor);
        $data = array(
            'alumnos'=>$alumnos,
            'controller'=>$this
        );
        $this->load->view('tutor/header');
        $this->load->view('tutor/alumnos/alumnos',$data);
        $this->load->view('tutor/footer');
       //$kardex = $this->alumno->allKardex($id);  
    }
    public function detalle($idalumno = '')
    {
        Permission::grant(uri_string());
        $idalumno = $this->decode($idalumno);
        if(isset($idalumno) && !empty($idalumno)){
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
            'detalle_alumno'=>$detalle_alumno,
            'controller'=>$this
        );
        $this->load->view('tutor/header');
        $this->load->view('tutor/alumnos/kardex',$data);
        $this->load->view('tutor/footer');
         }else{
         $data = array(
            'heading'=>'Error',
            'message'=>'Error intente mas tarde.'
        );
         $this->load->view('errors/html/error_general',$data);
        }
    }
     public function obtenerCalificacionAlumnoPorNivel($idhorario='',$idalumno = '')
    {
        Permission::grant(uri_string());
      # code...
     $unidades =  $this->grupo->unidades($this->session->idplantel);
     $materias = $this->alumno->showAllMaterias($idhorario);
     $total_unidad = 0;
     $total_materia = 0;
     $suma_calificacion = 0; 
     $promedio = 0;
 
      $c = 1;
      if (isset($materias) && !empty($materias)) {
      
        foreach($unidades as $block):
        $total_unidad += 1;
       endforeach; 
      
       foreach($materias as $row){
       $total_materia +=1;
      
       foreach($unidades as $block):
      $val = $this->grupo->obtenerCalificacion($idalumno, $block->idunidad, $row->idhorariodetalle);
      
      
        if($val != false ){ 
         $suma_calificacion +=$val->calificacion; 
        }  
      endforeach; 
      

      }
      $promedio = ($suma_calificacion / $total_unidad) / $total_materia;
  } 
  
      return $promedio;

    }
     public function historial($idhorario = '',$idalumno = '')
    {
        Permission::grant(uri_string());
        $idhorario = $this->decode($idhorario);
        $idalumno = $this->decode($idalumno);
        if((isset($idhorario) && !empty($idhorario)) && (isset($idalumno) && !empty($idalumno))){
        $calificacion = "";
        $tabla = $this->obtenerCalificacion($idhorario,$idalumno);
        $datosalumno = $this->alumno->showAllAlumnoId($idalumno);
        $datoshorario = $this->horario->showNivelGrupo($idhorario);
        $materias = $this->alumno->showAllMaterias($idhorario);
        $unidades =  $this->grupo->unidades($this->session->idplantel);
       
        # code...
       // printf($tabla);

          $data = array(
            'idhorario'=>$idhorario,
            'idalumno'=>$idalumno,
            'tabla'=>$tabla,
            'datosalumno'=>$datosalumno,
            'datoshorario'=>$datoshorario,
            'calificacion'=>$this->obtenerCalificacionAlumnoPorNivel($idhorario,$idalumno),
            'unidades'=>$unidades,
            'controller'=>$this
        );
        $this->load->view('tutor/header');
        $this->load->view('tutor/alumnos/kardex2',$data);
        $this->load->view('tutor/footer');
    }else{
        $data = array(
            'heading'=>'Error',
            'message'=>'Error intente mas tarde.'
        );
         $this->load->view('errors/html/error_general',$data);
    }

    }
     public function horario2($idhorario,$idalumno)
    {
        # code...
        Permission::grant(uri_string());
          $idhorario = $this->decode($idhorario);
        $idalumno = $this->decode($idalumno);
        if((isset($idhorario) && !empty($idhorario)) && (isset($idalumno) && !empty($idalumno))){
       
        //$tabla = $this->obtenerCalificacion($idhorario);
        $data = array(
            'idhorario'=>$idhorario,
            'idalumno'=>$idalumno,
            'controller'=>$this
        ); 
        $this->load->view('tutor/header');
        $this->load->view('tutor/alumnos/horario2',$data);
        $this->load->view('tutor/footer');
         }else{
        $data = array(
            'heading'=>'Error',
            'message'=>'Error intente mas tarde.'
        );
         $this->load->view('errors/html/error_general',$data);
    }
    }
        public function imprimirkardex($idhorario='',$idalumno = '')
    {
        Permission::grant(uri_string());
        $alumno = $this->alumno->detalleAlumno($idalumno);
        $grupop = $this->horario->showNivelGrupo($idhorario);
        $unidades =  $this->grupo->unidades($this->session->idplantel);
        $materias = $this->alumno->showAllMaterias($idhorario);
        $detalle_logo = $this->alumno->logo($this->session->idplantel);
        $logo = base_url() . '/assets/images/escuelas/'.$detalle_logo[0]->logoplantel;
        $logo2 = base_url() . '/assets/images/escuelas/'.$detalle_logo[0]->logosegundo;
        $total_unidades = 0;
        $calificacion = "";   
        $materias = $this->alumno->showAllMaterias($idhorario);
        $total_materia = 0;
        if ($materias != FALSE) { 
            foreach ($materias as $row) {
                # code...
                $total_materia = $total_materia + 1;
            }
        } 
         if ($unidades != FALSE) { 
            foreach ($unidades as $row) {
                # code...
                $total_unidades = $total_unidades + 1;
            }
        } 
        $datoscalifiacacion = $this->horario->calificacionGeneralAlumno($idhorario,$idalumno);
         if($datoscalifiacacion != FALSE && $total_materia > 0){
            $calificacion= ($datoscalifiacacion->calificaciongeneral / $total_unidades) / $total_materia;
         }


       $this->load->library('tcpdf');  
        $hora = date("h:i:s a");
        //$linkimge = base_url() . '/assets/images/woorilogo.png';
      
       $datelle_alumno = $this->alumno->showAllMateriasAlumno($idalumno);
        $fechaactual = date('d/m/Y');
        $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetTitle('Horario de clases.');
        $pdf->SetHeaderMargin(30);
        $pdf->SetTopMargin(10);
        $pdf->setFooterMargin(20);
        $pdf->SetAutoPageBreak(true);
        $pdf->SetAuthor('Author');
        $pdf->SetDisplayMode('real', 'default');
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        $pdf->AddPage();

        $tbl = '
<style type="text/css">
.titulodias{font-size:9px; font-weight:bold;}
.cajon{
    font-size:9px; 
    font-weight:bold;  
    border-bottom:solid 1px black;  
    border-left:solid 1px black;
     border-right:solid 1px black;  
      padding:900px 20px 20px 20px;
}  
 .txtn{
        font-size:6px;
    }
    .direccion{
        font-size:6px;
    }
.escuela{
      font-size:12px; 
    font-weight:bold;
}
.horario{
      font-size:10px; 
    font-weight:bold;
}
.titulo{
      font-size:8px; 
    font-weight:bold;
}
.result{
      font-size:8px; 
    font-weight:bold;
} 
    .nombreplantel{
        font-size:11px;
        font-weight:bolder;
    }
    .telefono{
          font-size:6px;
    }
 .imgtitle{
        width:55px;

    }
    .promedio{
           font-size:10px;
    }
.tblcalificacion  td 
                {
                    border:0px  solid black;
                }
tblcalificacion  {border-collapse:collapse}
.titulocal{
     font-family:Verdana, Geneva, sans-serif;
     font-weight:bolder;
     font-size:8px;
     background-color:#ccc;
}
.subtitulocal{
     font-family:Verdana, Geneva, sans-serif; 
     font-size:7px; 
}
</style>
 <table width="580" border="0" cellpadding="0" cellspacing="4">
   <tr>
    <td width="101" align="left"><img   class="imgtitle" src="' . $logo2 . '" /></td>
    <td colspan="2" align="center">
            <label class="nombreplantel">'.$datelle_alumno[0]->nombreplantel.'</label><br>
            <label class="txtn">INCORPORADA A LA UNIVERSIDAD DE GUANAJUATO SEGÚN EL OFICIO 14/ABRIL/1972</label><br>
            <label class="direccion">'.$datelle_alumno[0]->direccion.'</label><br>
            <label class="telefono">TELÉFONO: '.$datelle_alumno[0]->telefono.' EXT 1</label>
    </td>
    <td width="137" align="right"><img   class="imgtitle" src="' . $logo . '" /></td>
  </tr>
   
  <tr>
    <td colspan="4" align="center"><label class="horario">KARDEX ESCOLAR</label></td> 
    </tr>
   <tr>
    <td align="center"  style="border-bottom:solid 1px #000000;"><label class="titulo">Matricula</label></td>
    <td align="center"  style="border-bottom:solid 1px #000000;"><label class="titulo">Alumno(a)</label></td>
    <td align="center"  style="border-bottom:solid 1px #000000;"><label class="titulo">Nivel Escolar</label></td>
    <td align="center"  style="border-bottom:solid 1px #000000;"><label class="titulo">Periodo Escolar</label></td>
  </tr>
  <tr>
    <td align="center"><label class="result">'.$alumno->matricula.'</label></td>
    <td align="center"><label class="result">'.$alumno->nombre.' '.$alumno->apellidop.' '.$alumno->apellidom.'</label></td>
    <td align="center"><label class="result">'.$grupop->nombrenivel.' '.$grupop->nombregrupo.'</label></td>
    <td align="center"><label class="result">'.$grupop->mesinicio.' - '.$grupop->mesfin.' '.$grupop->yearfin.'</label></td>
  </tr> 
</table>
<br><br>
 ';
 $tbl .= '<table class="tblcalificacion" cellpadding="2"  >
      <tr>
      <td width="30" class="titulocal">#</td>
      <td width="180" class="titulocal">MATERIA</td>';
       foreach($unidades as $block):
        $tbl .= '<td class="titulocal">'.$block->nombreunidad.'</td>';
       endforeach; 

      $tbl .= '</tr>';
      $c = 1;
      foreach($materias as $row){
        //$alumn = $al->getAlumn();
      
        $tbl .= '<tr>
        <td width="30" class="subtitulocal">'.$c++.'</td>
        <td width="180" class="subtitulocal">'.$row->nombreclase.'</td>';
      foreach($unidades as $block):
      $val = $this->grupo->obtenerCalificacion($idalumno, $block->idunidad, $row->idhorariodetalle);
      //var_dump($val);
        $tbl .= '<td class="subtitulocal">';
        if($val != false ){ 
          $tbl .='<label>'.$val->calificacion.'</label>'; 
        }else{
           $tbl .='<label>No registrado</label>';
        } 
      $tbl .= '</td>';
      endforeach;

        $tbl .= '</tr>';
      

      }
      $tbl .= '</table>';
      $tbl .= '
<br><br>
      <table border="0" width="531">
        <tr>
            <td align="right" class="promedio" >
                Promedio: <strong>';
                if(isset($calificacion) && !empty($calificacion)){
                   $tbl .= number_format($calificacion,2);
                }else{
                    $tbl .='<label>0.0</label>';
                }
                
                $tbl .= '</strong>
            </td>
        </tr>
      </table>
      ';

        $pdf->writeHTML($tbl, true, false, false, false, '');

    ob_end_clean();


        $pdf->Output('Kardex de Calificaciones', 'I');

    }

    public function mensajes($idalumno = '',$idnivel = '',$idperiodo = '')
    {
        Permission::grant(uri_string());
        $idalumno = $this->decode($idalumno);
        if(isset($idalumno) && !empty($idalumno)){
       $detalle = $this->alumno->showAllMateriasAlumno($idalumno);
       $idhorario = '';
       if(isset($detalle[0]->idhorario) && !empty($detalle[0]->idhorario)){
        $idhorario =  $detalle[0]->idhorario;
       } 
       $mensajes = $this->mensaje->showAllMensajeAlumno($idhorario);
       $data = array(
            'mensajes'=>$mensajes,
            'controller'=>$this
       );
        $this->load->view('tutor/header');
        $this->load->view('tutor/alumnos/mensajes',$data);
        $this->load->view('tutor/footer');
        }else{
              $data = array(
            'heading'=>'Error',
            'message'=>'Error intente mas tarde.'
        );
         $this->load->view('errors/html/error_general',$data);
        }

        
    }
    public function detallemensaje($idmensaje = '')
{
    $idmensaje = $this->decode($idmensaje);
    if(isset($idmensaje) && !empty($idmensaje)){
        $detalle_mensaje = $this->mensaje->detalleMensaje($idmensaje);
        //var_dump($detalle_tarea);
        $data = array(
          'mensaje'=>$detalle_mensaje
        );
        $this->load->view('tutor/header');
        $this->load->view('tutor/detalle/mensaje',$data);
        $this->load->view('tutor/footer');
         }else{
              $data = array(
            'heading'=>'Error',
            'message'=>'Error intente mas tarde.'
        );
         $this->load->view('errors/html/error_general',$data);
        }
}
   /*
    public function noficaciones()
    {
        $body = @file_get_contents('php://input');
        $data = json_decode($body);
        http_response_code(200); // Return 200 OK 
    }
    public function crear_webhooks()
    {
       $openpay = Openpay::getInstance('moiep6umtcnanql3jrxp', 'sk_3433941e467c1055b178ce26348b0fac');

        $webhook = array(
            'url' => 'http://requestb.in/11vxrsf1',
            'user' => 'juanito',
            'password' => 'passjuanito',
                'event_types' => array(
                'charge.refunded',
                'charge.failed',
                'charge.cancelled',
                'charge.created',
                'chargeback.accepted'
                )
            );

        $webhook = $openpay->webhooks->add($webhook);
    }
    public function solicitar_webhooks()
    {
        $openpay = Openpay::getInstance('moiep6umtcnanql3jrxp', 'sk_3433941e467c1055b178ce26348b0fac');

        $webhook = $openpay->webhooks->get('wxvanstudf4ssme8khmc');
    }
    */
}
