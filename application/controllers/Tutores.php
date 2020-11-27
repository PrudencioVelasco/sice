<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("America/Mexico_City");

class Tutores extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        if (!isset($_SESSION['user_id'])) {
            $this->session->set_flashdata('flash_data', 'You don\'t have access! ss');
            return redirect('welcome');
        }
        $this->load->helper('url');
        $this->load->model('data_model');
        $this->load->library('permission');
        $this->load->library('session');
        $this->load->model('tarea_model', 'tarea');
        $this->load->model('alumno_model', 'alumno');
        $this->load->model('estadocuenta_model', 'estadocuenta');
        $this->load->model('grupo_model', 'grupo');
        $this->load->model('horario_model', 'horario');
        $this->load->model('user_model', 'user');
        $this->load->model('mensaje_model', 'mensaje');
        $this->load->model('cicloescolar_model', 'cicloescolar');
        $this->load->model('tutor_model', 'tutor');
        $this->load->model('planificacion_model', 'planeacion');
        $this->load->model('configuracion_model', 'configuracion');
        $this->load->model('calificacion_model', 'calificacion');
        $this->load->model('data_model');
        $this->load->library('permission');
        $this->load->library('session');
        $this->load->library('pdfgenerator');
        $this->load->library('openpayservicio');
        $this->load->library('encryption');
        $this->load->helper('numeroatexto_helper');
    }

    public function index()
    {
        Permission::grant(uri_string());
        $alumnos = $this->alumno->showAllAlumnosTutorActivos($this->session->idtutor);
        $mensajes = "";
        $tareas = "";
        if (isset($alumnos) && !empty($alumnos)) {
            foreach ($alumnos as $row) {
                $idhorario = $row->idhorario;
                $idperiodo = $row->idperiodo;
                $idalumno = $row->idalumno;
                $array_materias_reprobadas = array();
                $materias_reprobadas = $this->alumno->obtenerTodasMateriaReprobadasActivas($idalumno);
                if (isset($materias_reprobadas) && !empty($materias_reprobadas)) {
                    foreach ($materias_reprobadas as $row) {
                        array_push($array_materias_reprobadas, $row->idmateriaprincipal);
                    }
                }
                $reprobadas = implode(",", $array_materias_reprobadas);

                $materias = $this->alumno->showAllMaterias($idhorario, $reprobadas);
                if (isset($materias) && !empty($materias)) {
                    $array_profesor = array();
                    foreach ($materias as $row) {
                        array_push($array_profesor, $row->idprofesormateri);
                    }
                    $profesores = implode(",", $array_profesor);
                    $mensajes = $this->mensaje->showAllMensajeATutor($profesores);
                    $tareas = $this->mensaje->showAllTareaATutor($profesores, $idhorario);
                }
            }
        }

        $data = array(
            'mensajes' => $mensajes,
            'tareas' => $tareas
        );
        $this->load->view('tutor/header');
        $this->load->view('tutor/index', $data);
        $this->load->view('tutor/footer');
    }

    public function alumnos()
    {
        Permission::grant(uri_string());
        $alumnos = $this->alumno->showAllAlumnosTutorActivos($this->session->idtutor);

        $data = array(
            'alumnos' => $alumnos,
            'controller' => $this
        );
        $this->load->view('tutor/header');
        $this->load->view('tutor/alumnos/index', $data);
        $this->load->view('tutor/footer');
    }

    public  function planeaciones($idalumno = '', $idhorario = '', $idperiodo = '')
    {
        $idalumno = $this->decode($idalumno);
        $idhorario = $this->decode($idhorario);
        $idperiodo = $this->decode($idperiodo);
        if ((isset($idalumno) && !empty($idalumno)) && (isset($idhorario) && !empty($idhorario)) && (isset($idperiodo) && !empty($idperiodo))) {

            $array_materias_reprobadas = array();
            $materias_reprobadas = $this->alumno->obtenerTodasMateriaReprobadasActivas($idalumno);
            if (isset($materias_reprobadas) && !empty($materias_reprobadas)) {
                foreach ($materias_reprobadas as $row) {
                    array_push($array_materias_reprobadas, $row->idmateriaprincipal);
                }
            }
            $reprobadas = implode(",", $array_materias_reprobadas);
            $idshorariodetalle = array();

            $materias = $this->alumno->showAllMaterias($idhorario, $reprobadas);
            if (isset($materias) && !empty($materias)) {
                foreach ($materias as $value) {
                    array_push($idshorariodetalle, $value->idhorariodetalle);
                }
            }
            $planeaciones = "";
            if (isset($materias) && !empty($materias)) {
                $planeaciones = $this->planeacion->showPlanacionDocente($idshorariodetalle);
            }

            $data = array(
                'planeaciones' => $planeaciones
            );
            $this->load->view('tutor/header');
            $this->load->view('tutor/planeaciones/index', $data);
            $this->load->view('tutor/footer');
        }
    }
    public function boleta($idhorario = '', $idalumno = '', $idunidad = '')
    {
        Permission::grant(uri_string());
        $idhorario = $this->decode($idhorario);
        $idalumno = $this->decode($idalumno);
        $idunidad = $this->decode($idunidad);
        if ((isset($idhorario) && !empty($idhorario)) && (isset($idalumno) && !empty($idalumno)) && (isset($idunidad) && !empty($idunidad))) {
            $detalle_logo = $this->alumno->logo($this->session->idplantel);
            $detalle_configuracion = $this->configuracion->showAllConfiguracion($this->session->idplantel);
            $logo = base_url() . '/assets/images/escuelas/' . $detalle_logo[0]->logoplantel;
            $logo2 = base_url() . '/assets/images/escuelas/' . $detalle_logo[0]->logosegundo;

            $datelle_alumno = $this->alumno->showAllMateriasAlumno($idalumno);
            $materias = $this->alumno->showAllMaterias($idhorario);
            $detalle_unidad = $this->alumno->detalleUnidad($idunidad);
            $this->load->library('tcpdf');
            $hora = date("h:i:s a");
            // $linkimge = base_url() . '/assets/images/woorilogo.png';
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
            <label class="nombreplantel">' . $datelle_alumno[0]->nombreplantel . '</label><br>
            <label class="txtn">' . $datelle_alumno[0]->asociado . '</label><br>
            <label class="direccion">' . $datelle_alumno[0]->direccion . '</label><br>
            <label class="telefono">TELÉFONO: ' . $datelle_alumno[0]->telefono . '</label>
    </td>
    <td width="137" align="center"><img   class="imgtitle" src="' . $logo . '" /></td>
  </tr>
   <tr>
    <td width="543" colspan="3" align="center"><label class="boleta">BOLETA DE CALIFICACIONES DEL ' . $detalle_unidad[0]->nombreunidad . '</label></td>
  </tr>
   <tr>
    <td width="543" colspan="3" align="center"><label class="periodo">PERIODO: ' . $datelle_alumno[0]->mesinicio . ' - ' . $datelle_alumno[0]->mesfin . ' DE ' . $datelle_alumno[0]->yearfin . '</label></td>
  </tr>
 <tr>
    <td width="50" valign="bottom"  class="txtgeneral" >NOMBRE:</td>
    <td width="300" valign="bottom" class="txtgeneral" style="border-bottom:solid 1px black;"> ' . $datelle_alumno[0]->apellidop . ' ' . $datelle_alumno[0]->apellidom . ' ' . $datelle_alumno[0]->nombre . '</td>
    <td width="60" valign="bottom" class="txtgeneral"> GRUPO:</td>
    <td width="130" valign="bottom" class="txtgeneral" style="border-bottom:solid 1px black;">' . $datelle_alumno[0]->nombrenivel . ' ' . $datelle_alumno[0]->nombregrupo . '</td>
  </tr>
  <tr>
   <td width="60" valign="bottom"  class="txtgeneral" >INSCRIPCIÓN:</td>
    <td width="290" valign="bottom" class="txtgeneral" style="border-bottom:solid 1px black;"> PRIMERA</td>
    <td width="60" valign="bottom" class="txtgeneral"> NUA:</td>
    <td width="130" valign="bottom" class="txtgeneral" style="border-bottom:solid 1px black;">' . $datelle_alumno[0]->matricula . '</td>
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
            if (isset($materias) && !empty($materias)) {
                $numero = 1;
                $total_materia = 0;
                $total_calificacion = 0;
                $promedio_final = 0;
                $total_reprobadas = 0;
                $total_aprovadas = 0;
                foreach ($materias as $row) {
                    $total_materia = $total_materia + 1;
                    $idhorariodetalle = $row->idhorariodetalle;
                    $calificacion = $this->alumno->obtenerCalificacionMateria($idhorariodetalle, $idalumno, $idunidad);
                    $asistencia = $this->alumno->obtenerAsistenciaMateria($idhorariodetalle, $idalumno, $idunidad);
                    $tbl .= ' <tr >
           <td width="60" style="border:solid 1px black;" valign="bottom" align="center"  class="txtgeneral" >' . $numero++ . '</td>
            <td width="290" style="border:solid 1px black;" valign="bottom" class="txtgeneral">' . $row->nombreclase . '</td>
            <td width="60" style="border:solid 1px black;" valign="bottom"  align="center" class="txtgeneral">';
                    if ($asistencia != false) {
                        $total_falta = 0;
                        foreach ($asistencia as $value) {
                            $total_falta = $total_falta + 1;
                        }
                        $tbl .= '<label>' . $total_falta . '</label>';
                    } else {
                        $tbl .= '0';
                    }
                    $tbl .= '</td>
            <td width="130"style="border:solid 1px black;" align="center" valign="bottom" class="txtgeneral">';
                    if ($calificacion != false) {
                        $total_calificacion = $total_calificacion + $calificacion->calificacion;
                        if ($calificacion->calificacion < $detalle_configuracion[0]->calificacionminima) {
                            $total_reprobadas = $total_reprobadas + 1;
                            $tbl .= '<label style="color:red;">' . $calificacion->calificacion . '</label>';
                        } else {
                            $total_aprovadas = $total_aprovadas + 1;
                            $tbl .= '<label>' . numberFormatPrecision($calificacion->calificacion, 1, '.') . '</label>';
                        }
                    } else {
                        $tbl .= 'S/C';
                    }
                    $tbl .= '</td>
          </tr>';
                }
                $promedio_final = $total_calificacion / $total_materia;
            }
            $tbl .= '<tr >
   <td width="60" style="" valign="bottom" align="center"  class="txtgeneral" ></td>
    <td width="290" style="" valign="bottom"  align="center" class="txtgeneral"></td>
    <td width="60" style="border:solid 1px black; background-color:#ccc;" valign="bottom"  align="center" class="txtgeneral">PROMEDIO:</td>
    <td width="130"style="border:solid 1px black; background-color:#ccc;" valign="bottom"  align="center" class="txtcalificacion">' . numberFormatPrecision($promedio_final, 1, '.') . '</td>
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
    <td width="130"style="" valign="bottom"  align="right" class="txtgeneral">APROVADAS: ' . $total_aprovadas . '</td>
  </tr>
   <tr >
   <td width="60" style="" valign="bottom" align="center"  class="txtgeneral"  ></td>
    <td width="290" style="" valign="bottom"  align="center" style="border-bottom:solid 2px black" class="txtgeneral"></td>
    <td width="60" class="txtgeneral" ></td>
    <td width="130"style="" valign="bottom"  align="right" class="txtgeneral">REPROVADAS: ' . $total_reprobadas . '</td>
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
            $tbl .= '</table>


      ';

            $pdf->writeHTML($tbl, true, false, false, false, '');

            ob_end_clean();

            $pdf->Output('My-File-Name.pdf', 'I');
        } else {
            $data = array(
                'heading' => 'Error',
                'message' => 'Intente mas tarde.'
            );
            $this->load->view('tutor/header');
            $this->load->view('tutor/error/general', $data);
            $this->load->view('tutor/footer');
        }
    }

    public function horario($idalumno = '')
    {
        $idalumno = $this->decode($idalumno);
        if (isset($idalumno) && !empty($idalumno)) {
            $detalle = $this->alumno->showAllMateriasAlumno($idalumno);
            $idhorario = '';
            $tabla = "";
            if (isset($detalle[0]->idhorario) && !empty($detalle[0]->idhorario)) {
                $idhorario = $detalle[0]->idhorario;
                $tabla = $this->generarHorarioPDF($idhorario, $idalumno);
            }
            $tabla = $this->horarioMostrar($idhorario, $idalumno);
            $materias_repetir = $this->horario->materiasARepetir($idalumno);
            $data = array(
                'idhorario' => $idhorario,
                'idalumno' => $idalumno,
                'controller' => $this,
                'tabla' => $tabla,
                'materias_repetir' => $materias_repetir
            );
            $this->load->view('tutor/header');
            $this->load->view('tutor/alumnos/horario', $data);
            $this->load->view('tutor/footer');
        } else {
            $data = array(
                'heading' => 'Información',
                'message' => 'Error, intente mas tarde.'
            );
            $this->load->view('tutor/header');
            $this->load->view('tutor/error/general', $data);
            $this->load->view('tutor/footer');
        }
    }

    public function horarioMostrar($idhorario = '', $idalumno = '')
    {
        if ((isset($idhorario) && !empty($idhorario)) && (isset($idalumno) && !empty($idalumno))) {

            $tabla = '
            <style type="text/css">
    .txthorario{
       font-size:12px;
    }
    .txttutor{
       font-size:10px;
    }
    .txtdia{
      font-size:14px;
       font-weight: bold;
       background-color:#ccc;
    }
      .tblhorario tr td
                    {
                        border:0px solid black;
                    }
    .card1{
    border:solid #FAF9F9 2px;
    border-radius:5px;
    padding:10px 10px 10px 10px;
    -webkit-box-shadow: 1px 2px 3px -1px rgba(156,156,156,0.63);
    -moz-box-shadow: 1px 2px 3px -1px rgba(156,156,156,0.63);
    box-shadow: 1px 2px 3px -1px rgba(156,156,156,0.63);
    min-height: 160px;
    border-top:solid #33C1FF 2px;
    }
    </style>';

            $tabla .= '<div class="table-responsive"><table class="table "  > ';
            $tabla .= ' <thead class="bg-teal"> ';
            $tabla .= '<td>HORA</td>';
            $tabla .= '<td>LUNES</td>';
            $tabla .= '<td>MARTES</td>';
            $tabla .= '<td>MIERCOLES</td>';
            $tabla .= '<td>JUEVES</td>';
            $tabla .= '<td>VIERNES</td>';

            $tabla .= ' </thead>';
            $array_materias_reprobadas = array();
            $materias_reprobadas = $this->alumno->obtenerTodasMateriaReprobadasActivas($idalumno);
            if (isset($materias_reprobadas) && !empty($materias_reprobadas)) {
                foreach ($materias_reprobadas as $row) {
                    array_push($array_materias_reprobadas, $row->idmateriaprincipal);
                }
            }
            $base = base_url();
            $reprobadas = implode(",", $array_materias_reprobadas);
            $lunesAll = $this->horario->horarioClasesXDia($idhorario, $idalumno, $reprobadas);

            if (isset($lunesAll) && !empty($lunesAll)) {
                foreach ($lunesAll as $row) {
                    $tabla .= '<tr>';
                    $tabla .= '<td  ><strong>' . $row->hora . '</strong></td>';
                    $tabla .= '<td >';
                    if (isset($row->lunes) && !empty($row->lunes)) {
                        $tabla .= '<div class="card1"> <strong><i class="fa fa-book" style="color:#ff7e00;" ></i>  
                                    ' . $row->lunes . '</strong><br>';
                        if (isset($row->lunesprofesor) && !empty($row->lunesprofesor)) {
                            $tabla .= '<small><i class="fa fa-user" style="color:#3db828;" ></i> ' . $row->lunesprofesor . '</small><br>';
                        }

                        $tabla .= '</div>';
                    }
                    $tabla .= '</td>';
                    $tabla .= '<td  >';
                    if (isset($row->martes) && !empty($row->martes)) {
                        $tabla .= '<div class="card1"> <strong><i class="fa fa-book" style="color:#ff7e00;"></i>  
                                    ' . $row->martes . '</strong><br>';
                        if (isset($row->martesprofesor) && !empty($row->martesprofesor)) {
                            $tabla .= '<small><i class="fa fa-user" style="color:#3db828;"></i> ' . $row->martesprofesor . '</small><br>';
                        }

                        $tabla .= '</div>';
                    }
                    $tabla .= '</td>';
                    $tabla .= '<td >';
                    if (isset($row->miercoles) && !empty($row->miercoles)) {
                        $tabla .= '<div class="card1"> <strong><i class="fa fa-book" style="color:#ff7e00;"></i>  
                                    ' . $row->miercoles . '</strong><br>';
                        if (isset($row->miercolesprofesor) && !empty($row->miercolesprofesor)) {
                            $tabla .= '<small><i class="fa fa-user" style="color:#3db828;" ></i> ' . $row->miercolesprofesor . '</small><br>';
                        }
                        $tabla .= '</div>';
                    }
                    $tabla .= '</td>';
                    $tabla .= '<td  >';
                    if (isset($row->jueves) && !empty($row->jueves)) {
                        $tabla .= '<div class="card1"> <strong><i class="fa fa-book" style="color:#ff7e00;"></i>  
                                    ' . $row->jueves . '</strong><br>';
                        if (isset($row->juevesprofesor) && !empty($row->juevesprofesor)) {
                            $tabla .= '<small><i class="fa fa-user" style="color:#3db828;"></i> ' . $row->juevesprofesor . '</small><br>';
                        }
                        $tabla .= '</div>';
                    }
                    $tabla .= '</td>';
                    $tabla .= '<td >';
                    if (isset($row->viernes) && !empty($row->viernes)) {
                        $tabla .= '<div class="card1"> <strong><i class="fa fa-book" style="color:#ff7e00;"></i>  
                                    ' . $row->viernes . '</strong><br>';
                        if (isset($row->viernesprofesor) && !empty($row->viernesprofesor)) {
                            $tabla .= '<small><i class="fa fa-user" style="color:#3db828;" ></i> ' . $row->viernesprofesor . '</small><br>';
                        }
                        $tabla .= '</div>';
                    }
                    $tabla .= '</td>';

                    $tabla .= '</tr>';
                }
            } else {
                $tabla .= '<tr><td colspan="6" align="center"><label>Sin registros</label></td></tr>';
            }
            $tabla .= '</table></div>';

            return $tabla;
        }
    }

    public function obtenerCalificacion($idhorario = '', $idalumno = '')
    {
        # code...
        $detalle_configuracion = $this->configuracion->showAllConfiguracion($this->session->idplantel);
        $unidades = $this->grupo->unidades($this->session->idplantel);
        $materias = $this->alumno->showAllMaterias($idhorario);
        $total_unidades = 0;
        $tabla = "";
        $tabla .= '  <table class="table table-hover table-striped">
       <thead class="bg-teal">
      <th>#</th>
      <th>Nombre de Materia</th>';
        foreach ($unidades as $block) :
            $total_unidades += 1;
            $tabla .= '<th><strong>' . $block->nombreunidad . '</strong></th>';
        endforeach;
        $tabla .= '<th>PROMEDIO</th>';
        $tabla .= '</thead>';
        $c = 1;
        if (isset($materias) && !empty($materias)) {
            $suma_calificacion = 0;
            foreach ($materias as $row) {
                // $alumn = $al->getAlumn();
                $idmateria = $row->idmateria;
                $suma_calificacion = 0;
                $tabla .= '<tr>
        <td>' . $c++ . '</td>
        <td><strong>' . $row->nombreclase . '</strong><br><small>( ' . $row->nombre . ' ' . $row->apellidop . ' ' . $row->apellidom . '</small>)</td>';
                foreach ($unidades as $block) :
                    $val = $this->grupo->obtenerCalificacionValidandoMateria($idalumno, $block->idunidad, $idhorario, $idmateria);

                    $tabla .= '<td>';
                    if ($val != false) {
                        $suma_calificacion = $suma_calificacion + $val->calificacion;
                        if ($val->calificacion >= $detalle_configuracion[0]->calificacionminima) {
                            $tabla .= '<label style="color:green;">' . $val->calificacion . '</label>';
                        } else {
                            $tabla .= '<label style="color:red;">' . numberFormatPrecision($val->calificacion, 1, '.') . '</label>';
                        }
                    } else {
                        $tabla .= '<label>No registrado</label>';
                    }
                    $tabla .= '</td>';
                endforeach;
                $tabla .= '<td>';
                $calificacion_final = numberFormatPrecision($suma_calificacion / $total_unidades, 1, '.');
                if (validar_calificacion($calificacion_final, $detalle_configuracion[0]->calificacionminima)) {
                    $tabla .= '<label style="color:red;">' . numberFormatPrecision($suma_calificacion / $total_unidades, 1, '.') . '</label>';
                } else {
                    $tabla .= '<label style="color:green;">' . numberFormatPrecision($suma_calificacion / $total_unidades, 1, '.') . '</label>';
                }
                $tabla .= '</td>';
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
        if (isset($idalumno) && !empty($idalumno)) {
            $detalle = $this->alumno->showAllMateriasAlumno($idalumno);
            if (isset($detalle[0]->idhorario) && !empty($detalle[0]->idhorario)) {
                $idhorario = $detalle[0]->idhorario;
                $grupo = $this->alumno->obtenerGrupo($idalumno);
                if ($grupo != false) {
                    $idhorario = $grupo->idhorario;
                }

                if ($idhorario != "") {

                    $calificacion = "";
                    $tabla = "";

                    //Obtener nivel educativo del alumno
                    $data = $this->alumno->obtenerNivelEducativoAlumno($idalumno);

                    if ($data->idniveleducativo == 5) {
                        $tabla = $this->obtenerCalificacionLicenciatura($idhorario, $idalumno);
                    } else if ($data->idniveleducativo == 1 || $data->idniveleducativo == 2) {
                        $tabla = $this->calificacionSecu($idhorario, $idalumno);
                    } else {
                        $tabla = $this->obtenerCalificacion2($idhorario, $idalumno);
                    }

                    $datosalumno = $this->alumno->showAllAlumnoId($idalumno);
                    $datoshorario = $this->horario->showNivelGrupo($idhorario);
                    $array_materias_reprobadas = array();
                    $materias_reprobadas = $this->alumno->obtenerTodasMateriaReprobadasActivas($idalumno);
                    if (isset($materias_reprobadas) && !empty($materias_reprobadas)) {
                        foreach ($materias_reprobadas as $row) {
                            array_push($array_materias_reprobadas, $row->idmateriaprincipal);
                        }
                    }
                    $reprobadas = implode(",", $array_materias_reprobadas);

                    $materias = $this->alumno->showAllMaterias($idhorario, $reprobadas);
                    $unidades = $this->grupo->unidades($this->session->idplantel);
                    $idnivelestudio = $datoshorario->idnivelestudio;
                    $idniveleducativo = $datoshorario->idniveleducativo;
                    $detalle_configuracion = $this->configuracion->showAllConfiguracion($this->session->idplantel, $idnivelestudio);
                    $idperiodo = $datoshorario->idperiodo;
                    $alumno_grupo = $this->grupo->detalleAlumnoGrupo($idalumno, $idperiodo);
                    $total_unidades = 0;
                    $total_materia = 0;
                    if ($materias != false) {
                        foreach ($materias as $row) {
                            # code...
                            $total_materia = $total_materia + 1;
                        }
                    }
                    if ($unidades != false) {
                        foreach ($unidades as $row) {
                            # code...
                            $total_unidades = $total_unidades + 1;
                        }
                    }
                    $datoscalifiacacion = $this->horario->calificacionGeneralAlumno($idhorario, $idalumno);
                    if ($datoscalifiacacion != false && $total_materia > 0) {
                        $calificacion = ($datoscalifiacacion->calificaciongeneral / $total_unidades) / $total_materia;
                    }
                    $detalle_oportunidad = $this->alumno->detalleOportunidadExamen($this->session->idplantel, 1);
                    $numero_oportunidad = $detalle_oportunidad->numero;
                    $detalle_siguiente_oportunidad = $this->alumno->siguienteOportunidadExamen($this->session->idplantel, $numero_oportunidad);
                    $detalle_calificacion = $this->alumno->calificacionAlumno($idalumno, $idhorario, $detalle_oportunidad->idoportunidadexamen);

                    $total_aprovadas = 0;
                    $total_reprovadas = 0;
                    if ($detalle_calificacion) {
                        foreach ($detalle_calificacion as $row) {
                            if (validar_calificacion($row->calificacion, $detalle_configuracion[0]->calificacion_minima)) {
                                // REPROVADAS
                                $total_reprovadas += 1;
                            } else {
                                // APROBADAS
                                $total_aprovadas += 1;
                            }
                        }
                    }

                    $calificacion_minima = $detalle_configuracion[0]->calificacion_minima;
                    $reprovatorio_permitido = $detalle_configuracion[0]->reprovandas_minima;

                    $estatus_alumno = calcularReprovado($idnivelestudio, $idniveleducativo, $total_materia, $total_aprovadas, $total_reprovadas, $reprovatorio_permitido, $calificacion, $calificacion_minima);
                    $mostrar_estatus = mostrarReprovado($idnivelestudio, $idniveleducativo, $total_materia, $total_aprovadas, $total_reprovadas, $reprovatorio_permitido, $calificacion, $calificacion_minima);

                    $data = array(
                        'idhorario' => $idhorario,
                        'idalumno' => $idalumno,
                        'tabla' => $tabla,
                        'datosalumno' => $datosalumno,
                        'datoshorario' => $datoshorario,
                        'calificacion' => $calificacion,
                        'controller' => $this,
                        'estatus_nivel' => $estatus_alumno,
                        'oportunidades' => $this->grupo->showAllOportunidades($this->session->idplantel),
                        'nivel_educativo' => $idniveleducativo,
                        'mostrar_estatus' => $mostrar_estatus
                        // 'detalle_siguiente_oportunidad'=>$detalle_siguiente_oportunidad
                    );
                    $this->load->view('tutor/header');
                    $this->load->view('tutor/alumnos/calificacion', $data);
                    $this->load->view('tutor/footer');
                } else {
                    $data = array(
                        'idhorario' => $idhorario
                    );
                    $this->load->view('tutor/header');
                    $this->load->view('tutor/alumnos/boletas', $data);
                    $this->load->view('tutor/footer');
                }
            } else {
                $data = array(
                    'heading' => 'Notificación',
                    'message' => 'El Alumno(a) no tiene registrado Calificación.'
                );
                $this->load->view('tutor/header');
                $this->load->view('tutor/error/general', $data);
                $this->load->view('tutor/footer');
            }
        } else {
            $data = array(
                'heading' => 'Información',
                'message' => 'Error, intente mas tarde.'
            );
            $this->load->view('tutor/header');
            $this->load->view('tutor/error/general', $data);
            $this->load->view('tutor/footer');
        }
    }
    public  function calificacionSecu($idhorario, $idalumno)
    {
        $data = $this->alumno->obtenerNivelEducativoAlumno($idalumno);
        $unidades = $this->grupo->unidades($data->idplantel);
        $array_materias_reprobadas = array();
        $materias_reprobadas = $this->alumno->obtenerTodasMateriaReprobadasActivas($idalumno);
        if (isset($materias_reprobadas) && !empty($materias_reprobadas)) {
            foreach ($materias_reprobadas as $row) {
                array_push($array_materias_reprobadas, $row->idmateriaprincipal);
            }
        }
        $reprobadas = implode(",", $array_materias_reprobadas);

        $materias = $this->alumno->showAllMaterias($idhorario, $reprobadas);
        $datoshorario = $this->horario->showNivelGrupo($idhorario);
        $idnivelestudio = $datoshorario->idnivelestudio;
        $unidades_reales = $this->grupo->unidadesConCalificaciones($data->idplantel, $idhorario);

        $detalle_configuracion = $this->configuracion->showAllConfiguracion($data->idplantel, $idnivelestudio);
        $total_unidades = count($unidades);
        $total_unidades_registradas = 0;
        $total_meses = 0;
        $total_materia = 0;
        $total_cols = 0;
        if ($materias) {
            foreach ($materias as $row) {

                $total_materia = $total_materia + 1;
            }
        }
        $tabla = "";
        $tabla .= '<div class="responsive">
<table class="table  table-striped  table-hover" style="width:100%;" id="datatablebodega">
        <thead  >
        <th>#</th>
        <th>MATERIA</th>';
        if ($unidades_reales) {
            foreach ($unidades_reales as $block) :
                $idunidad = $block->idunidad;
                $meses_reales = $this->grupo->mesesPorUnidad($idhorario, $idunidad);

                if ($meses_reales) {
                    foreach ($meses_reales as $row) {
                        $total_meses += 1;
                        $total_cols += 1;
                        $tabla .= '<th><strong>' . $row->nombremes . '</strong></th>';
                    }
                    $total_unidades_registradas++;
                }
                $total_cols += 1;
                $tabla .= '<th><strong>' . $block->nombreunidad . '</strong></th>';
            endforeach;
        }
        if ($total_unidades == $total_unidades_registradas) {
            $tabla .= '<th>PROMEDIO</th>';
            $total_cols += 1;
        }
        $tabla .= '</thead>';
        $c = 1;
        $mostrar = false;
        $suma_calificacion_verificar = 0;
        if (isset($materias) && !empty($materias)) {
            $suma_calificacion = 0;
            foreach ($materias as $row) {
                $idmateria = $row->idmateria;
                $suma_calificacion = 0;

                $validar = $this->calificacion->verificarCalificacionSiSeMuestra($idalumno, $row->idhorariodetalle);
                if ($validar) {
                    $suma_calificacion_verificar = 0;
                    foreach ($validar as $rowv) {
                        $suma_calificacion_verificar += $rowv->calificacion;
                    }
                    if ($suma_calificacion_verificar > 0) {
                        $mostrar = TRUE;
                    } else {
                        $mostrar = FALSE;
                    }
                } else {
                    $mostrar = TRUE;
                }
                if ($mostrar) {
                    $tabla .= '<tr>
                <td>' . $c++ . '</td>
                <td>';
                    if ($row->opcion == 0) {
                        $tabla .= '<label style="color:red;">R: </label>';
                    }
                    $tabla .= '<strong>' . $row->nombreclase . '</strong><br><small>( ' . $row->nombre . ' ' . $row->apellidop . ' ' . $row->apellidom . '</small>)</td>';
                    if ($unidades_reales) {
                        $suma_calificacion_mes = 0;
                        $contador_meses = 0;
                        foreach ($unidades_reales as $block) :
                            $idunidad = $block->idunidad;
                            $meses_reales = $this->grupo->mesesPorUnidad($idhorario, $idunidad);

                            if ($meses_reales) {
                                $suma_calificacion_mes = 0;
                                $contador_meses = 0;
                                foreach ($meses_reales as $rowmes) {
                                    $val = $this->grupo->obtenerCalificacionValidandoMateria($idalumno, $block->idunidad, $idhorario, $idmateria);
                                    if ($val) {
                                        $idmes = $rowmes->idmes;
                                        $idcalificacion = $val->idcalificacion;
                                        $calificacion_mes = $this->grupo->obtenerCalificacionXMeses($idcalificacion, $idmes);
                                        if ($calificacion_mes) {
                                            $suma_calificacion_mes = $suma_calificacion_mes + $calificacion_mes->calificacion;
                                            $contador_meses++;
                                            $tabla .= '<td align="center"><strong><center>' . numberFormatPrecision($calificacion_mes->calificacion, 1, '.') . '</center></strong></td>';
                                        } else {
                                            $tabla .= '<td><small>No registrado</small></td>';
                                        }
                                    } else {
                                        $tabla .= '<td  ></td>';
                                    }
                                }
                            }

                            if ($contador_meses > 0 && $suma_calificacion_mes > 0) {

                                $calificacion_trimestral = number_format($suma_calificacion_mes / $contador_meses, 2);
                                $suma_calificacion = $suma_calificacion + $calificacion_trimestral;
                                $tabla .= '<td align="center"><strong><center>' . numberFormatPrecision($calificacion_trimestral, 1, '.') . '</center></strong></td>';
                            } else {
                                $tabla .= '<td> </td>';
                            }

                        endforeach;
                    }
                    if ($total_unidades == $total_unidades_registradas) {
                        if ($suma_calificacion > 0 && $total_unidades > 0) {
                            $promedio = $suma_calificacion / $total_unidades;
                            $tabla .= '<td align="center"><strong>' . numberFormatPrecision($promedio, 1, '.') . '</strong></td>';
                        } else {
                            $tabla .= '<td></td>';
                        }
                    }
                    $tabla .= '</tr>';
                }
            }
        }
        $tabla .= '</table></div>';
        return $tabla;
    }
    public function obtenerCalificacion2($idhorario = '', $idalumno = '')
    {
        # code...
        Permission::grant(uri_string());

        //Extraer informacion del Alumno 
        $data = $this->alumno->obtenerNivelEducativoAlumno($idalumno);
        //var_dump($data);

        $unidades = $this->grupo->unidades($data->idplantel);
        $array_materias_reprobadas = array();
        $materias_reprobadas = $this->alumno->obtenerTodasMateriaReprobadasActivas($idalumno);
        if (isset($materias_reprobadas) && !empty($materias_reprobadas)) {
            foreach ($materias_reprobadas as $row) {
                array_push($array_materias_reprobadas, $row->idmateriaprincipal);
            }
        }
        $reprobadas = implode(",", $array_materias_reprobadas);

        $materias = $this->alumno->showAllMaterias($idhorario, $reprobadas, $idalumno);
        $datoshorario = $this->horario->showNivelGrupo($idhorario);
        $idnivelestudio = $datoshorario->idnivelestudio;

        $detalle_configuracion = $this->configuracion->showAllConfiguracion($data->idplantel, $idnivelestudio);
        $total_unidades = 0;
        $total_materia = 0;
        if ($materias != false) {
            foreach ($materias as $row) {
                # code...
                $total_materia = $total_materia + 1;
            }
        }
        $tabla = "";
        $tabla .= '<table class="table  table-striped  table-hover">
      <thead class="bg-teal">
      <th>#</th>
      <th>MATERIA</th>';
        if (isset($unidades) && !empty($unidades)) {
            foreach ($unidades as $block) :
                $total_unidades += 1;
                $tabla .= '<th><strong>' . $block->nombreunidad . '</strong></th>';
            endforeach;
        } else {
            $tabla .= '<th><strong></strong></th>';
        }
        $tabla .= '<th>PROMEDIO</th>';
        $tabla .= '</thead>';
        $c = 1;
        $mostrar = false;
        $suma_calificacion_verificar = 0;
        if (isset($materias) && !empty($materias)) {
            $suma_calificacion = 0;
            foreach ($materias as $row) {
                $suma_calificacion = 0;
                $idmateria = $row->idmateria;
                $validar = $this->calificacion->verificarCalificacionSiSeMuestra($idalumno, $row->idhorariodetalle);
                if ($validar) {
                    $suma_calificacion_verificar = 0;
                    foreach ($validar as $rowv) {
                        $suma_calificacion_verificar += $rowv->calificacion;
                    }
                    if ($suma_calificacion_verificar > 0) {
                        $mostrar = TRUE;
                    } else {
                        $mostrar = FALSE;
                    }
                } else {
                    $mostrar = TRUE;
                }
                if ($mostrar) {
                    $tabla .= '<tr>
          <td>' . $c++ . '</td>
          <td>';
                    if ($row->opcion == 0) {
                        $tabla .= '<label style="color:red;">R: </label>';
                    }
                    $tabla .= '<strong>' . $row->nombreclase . '</strong><br><small>( ' . $row->nombre . ' ' . $row->apellidop . ' ' . $row->apellidom . '</small>)</td>';
                    foreach ($unidades as $block) :
                        $val = $this->grupo->obtenerCalificacionValidandoMateria($idalumno, $block->idunidad, $idhorario, $idmateria);

                        $tabla .= '<td>';
                        if ($val != false) {

                            $idcalificacion = $val->idcalificacion;
                            $detalle_calificacion = $this->grupo->detalleCalificacionSecundaria($idcalificacion);

                            $suma_calificacion = $suma_calificacion + $val->calificacion;

                            if (validar_calificacion($val->calificacion, $detalle_configuracion[0]->calificacion_minima)) {

                                $tabla .= '<label style="color:red;">' . numberFormatPrecision($val->calificacion, 1, '.') . '</label>';
                            } else {

                                $tabla .= '<label style="color:green;">' . numberFormatPrecision($val->calificacion, 1, '.') . '</label>';
                            }
                        } else {
                            $tabla .= '<small>No registrado</small>';
                        }
                        $tabla .= '</td>';
                    endforeach;
                    $tabla .= '<td>';
                    $calificacion_final = numberFormatPrecision($suma_calificacion / $total_unidades, 1, '.');
                    if (validar_calificacion($calificacion_final, $detalle_configuracion[0]->calificacion_minima)) {
                        if ($suma_calificacion > 0.0) {
                            $tabla .= '<label style="color:red;">' . numberFormatPrecision($suma_calificacion / $total_unidades, 1, '.') . '</label>';
                        } else {
                            $tabla .= '<label "> </label>';
                        }
                    } else {
                        $tabla .= '<label style="color:green;">' . numberFormatPrecision($suma_calificacion / $total_unidades, 1, '.') . '</label>';
                    }
                    $tabla .= '</td>';
                    $tabla .= '</tr>';
                }
            }
        }
        $tabla .= '</table>';

        return $tabla;
    }

    public function obtenerCalificacionPrimaria($idhorario = '', $idalumno = '')
    {
        # code...
        Permission::grant(uri_string());
        $idplantel = $this->session->idplantel;
        $datoshorario = $this->horario->showNivelGrupo($idhorario);
        $idnivelestudio = $datoshorario->idnivelestudio;

        $detalle_configuracion = $this->configuracion->showAllConfiguracion($this->session->idplantel, $idnivelestudio);
        $calificaciones = $this->alumno->calificacionFinalPrimaria($idalumno, $idhorario, $idplantel);

        $tabla = "";
        $tabla .= '<table class="table  table-striped  table-hover">
        <thead class="bg-teal">
         <th>#</th>
        <th>Nombre de Materia</th>';
        $tabla .= '<th>PROMEDIO</th>';
        $tabla .= '</thead>';
        $c = 1;

        foreach ($calificaciones as $row) {
            $tabla .= '<tr>';
            $tabla .= '<td>' . $c++ . '</td>';
            $tabla .= '<td>' . $row->nombreclase . '</td>';

            if ($row->calificacion < $detalle_configuracion[0]->calificacion_minima) {
                $tabla .= '<td><strong>NA</strong></td>';
            } else {
                $tabla .= '<td>' . numberFormatPrecision($row->calificacion, 1, '.') . '</td>';
            }
            $tabla .= '</tr>';
        }

        $tabla .= '</table>';
        return $tabla;
    }

    public function materias($idalumno = '')
    {
        Permission::grant(uri_string());
        $materias = $this->alumno->showAllMateriasAlumno($idalumno);
        $alumno = $this->alumno->detalleAlumno($idalumno);
        $data = array(
            'materias' => $materias,
            'alumno' => $alumno,
            'idalumno' => $idalumno
        );
        $this->load->view('tutor/header');
        $this->load->view('tutor/alumnos/materias', $data);
        $this->load->view('tutor/footer');
    }

    public function examen($idhorario = '', $idhorariodetalle = '', $idalumno = '')
    {
        Permission::grant(uri_string());
        $unidades = $this->grupo->unidades($this->session->idplantel);

        $detalle = $this->grupo->detalleClase($idhorariodetalle);
        $estatus_alumno = $detalle->activo;
        $alumns = $this->grupo->alumnosGrupo($idhorario, '', '', $estatus_alumno);
        $nombreclase = $detalle[0]->nombreclase;
        $data = array(
            'alumnos' => $alumns,
            'idhorario' => $idhorario,
            'idhorariodetalle' => $idhorariodetalle,
            'unidades' => $unidades,
            'nombreclase' => $nombreclase,
            'tabla' => $this->obtenerCalificacion($idhorario, $idhorariodetalle, $idalumno)
        );

        $this->load->view('docente/header');
        $this->load->view('docente/grupo/examen', $data);
        $this->load->view('docente/footer');
    }

    public function tareas($idalumno = '', $idnivelestudio = '', $idperiodo = '')
    {
        Permission::grant(uri_string());
        $idalumno = $this->decode($idalumno);
        $idperiodo = $this->decode($idperiodo);
        if ((isset($idalumno) && !empty($idalumno)) && (isset($idperiodo) && !empty($idperiodo))) {
            $detalle = $this->alumno->showAllMateriasAlumno($idalumno);
            if (isset($detalle[0]->idhorario) && !empty($detalle[0]->idhorario)) {
                $idhorario = $detalle[0]->idhorario;
                // $idhorariodetalle = $detalle[0]->idhorariodetalle;
                $tareas = $this->alumno->showAllTareaAlumno($idhorario, '');
                $data = array(
                    'tareas' => $tareas,
                    'controller' => $this
                );
                $this->load->view('tutor/header');
                $this->load->view('tutor/alumnos/tareas', $data);
                $this->load->view('tutor/footer');
            } else {
                $data = array(
                    'heading' => 'Notificación',
                    'message' => 'El Alumno(a) no tiene registrado Tareas.'
                );
                $this->load->view('tutor/header');
                $this->load->view('tutor/error/general', $data);
                $this->load->view('tutor/footer');
            }
        } else {
            $data = array(
                'heading' => 'Error',
                'message' => 'Intente mas tarde.'
            );
            $this->load->view('tutor/header');
            $this->load->view('tutor/error/general', $data);
            $this->load->view('tutor/footer');
        }
    }

    public function tareasv2($idalumno = '', $idnivelestudio = '', $idperiodo = '')
    {
        Permission::grant(uri_string());
        $idalumno = $this->decode($idalumno);
        $idperiodo = $this->decode($idperiodo);
        if ((isset($idalumno) && !empty($idalumno)) && (isset($idperiodo) && !empty($idperiodo))) {
            $detalle = $this->alumno->showAllMateriasAlumno($idalumno);
            if (isset($detalle[0]->idhorario) && !empty($detalle[0]->idhorario)) {

                $idhorario = $detalle[0]->idhorario;
                $idhorariodetalle = $detalle[0]->idhorariodetalle;
                $tareas = $this->alumno->showAllTareaAlumno($idhorario, '');
                $data = array(
                    'tareas' => $tareas,
                    'controller' => $this,
                    'idhorario' => $idhorario,
                    'idalumno' => $idalumno
                );
                $this->load->view('tutor/header');
                $this->load->view('tutor/alumnos/tarea/index', $data);
                $this->load->view('tutor/footer');
            } else {
                $data = array(
                    'heading' => 'Notificación',
                    'message' => 'El Alumno(a) no tiene registrado Tareas.'
                );
                $this->load->view('tutor/header');
                $this->load->view('tutor/error/general', $data);
                $this->load->view('tutor/footer');
            }
        } else {
            $data = array(
                'heading' => 'Error',
                'message' => 'Intente mas tarde.'
            );
            $this->load->view('tutor/header');
            $this->load->view('tutor/error/general', $data);
            $this->load->view('tutor/footer');
        }
    }

    public function detalletareav2($idtarea, $idhorario, $idalumno)
    {
        $idhorario = $this->decode($idhorario);
        $idalumno = $this->decode($idalumno);
        if ((isset($idtarea) && !empty($idtarea)) && (isset($idhorario) && !empty($idhorario)) && (isset($idalumno) && !empty($idalumno))) {
            $validar_tarea = $this->tarea->validarTareaAlumno($idtarea, $idhorario);

            if ($validar_tarea) {
                $data = array(
                    'idtarea' => $idtarea,
                    'idalumno' => $idalumno
                );
                $this->load->view('tutor/header');
                $this->load->view('tutor/alumnos/tarea/detalle', $data);
                $this->load->view('tutor/footer');
            } else {
                $data = array(
                    'heading' => 'ERROR',
                    'message' => 'Ocurrio un error, intente mas tarde.'
                );
                $this->load->view('errors/html/error_general', $data);
            }
        } else {
            $data = array(
                'heading' => 'ERROR',
                'message' => 'Ocurrio un error, intente mas tarde.'
            );
            $this->load->view('errors/html/error_general', $data);
        }
    }

    public function detalletarea($idtarea = '')
    {
        if (isset($idtarea) && !empty($idtarea)) {
            $detalle_tarea = $this->mensaje->detalleTarea($idtarea);
            $data = array(
                'tarea' => $detalle_tarea
            );
            $this->load->view('tutor/header');
            $this->load->view('tutor/detalle/tarea', $data);
            $this->load->view('tutor/footer');
        } else {
            $data = array(
                'heading' => 'Error',
                'message' => 'Intente mas tarde.'
            );
            $this->load->view('tutor/header');
            $this->load->view('tutor/error/general', $data);
            $this->load->view('tutor/footer');
        }
    }

    public function asistencias($idalumno = '')
    {
        Permission::grant(uri_string());
        $idalumno = $this->decode($idalumno);
        if (isset($idalumno) && !empty($idalumno)) {
            $detalle = $this->alumno->showAllMateriasAlumno($idalumno);
            if (isset($detalle[0]->idhorario) && !empty($detalle[0]->idhorario)) {
                $idhorario = $detalle[0]->idhorario;
                $idhorariodetalle = $detalle[0]->idhorariodetalle;

                // $alumns = $this->grupo->alumnosGrupo($idhorario);
                $motivo = $this->grupo->motivoAsistencia();
                $unidades = $this->grupo->unidades($this->session->idplantel);
                $fechainicio = date("Y-m-d");
                $fechafin = date("Y-m-d");
                $table = $this->obetnerAsistencia($idhorario, $fechainicio, $fechafin, $idhorariodetalle, $idalumno);
                $detalle = $this->grupo->detalleClase($idhorariodetalle);
                // var_dump($table);
                $nombreclase = $detalle[0]->nombreclase;
                $data = array(
                    // alumnos' => $alumns,
                    'motivos' => $motivo,
                    'idhorario' => $idhorario,
                    'idhorariodetalle' => $idhorariodetalle,
                    'tabla' => $table,
                    'nombreclase' => $nombreclase,
                    'unidades' => $unidades,
                    'idalumno' => $idalumno,
                    'controller' => $this
                );
                $this->load->view('tutor/header');
                $this->load->view('tutor/alumnos/asistencias', $data);
                $this->load->view('tutor/footer');
            } else {
                $data = array(
                    'heading' => 'Notificación',
                    'message' => 'El Alumno(a) no tiene registrado Asistencia.'
                );
                $this->load->view('tutor/header');
                $this->load->view('tutor/error/general', $data);
                $this->load->view('tutor/footer');
            }
        } else {
            $data = array(
                'heading' => 'Error',
                'message' => 'Intente mas tarde.'
            );
            $this->load->view('tutor/header');
            $this->load->view('tutor/error/general', $data);
            $this->load->view('tutor/footer');
        }
    }

    public function obetnerAsistencia($idhorario, $fechainicio, $fechafin, $idhorariodetalle, $idalumno)
    {
        Permission::grant(uri_string());
        $tabla = "";
        $array_materias_reprobadas = array();
        $materias_reprobadas = $this->alumno->obtenerTodasMateriaReprobadasActivas($idalumno);
        if (isset($materias_reprobadas) && !empty($materias_reprobadas)) {
            foreach ($materias_reprobadas as $row) {
                array_push($array_materias_reprobadas, $row->idmateriaprincipal);
            }
        }
        $reprobadas = implode(",", $array_materias_reprobadas);

        $materias = $this->alumno->showAllMateriasAsistencias($idhorario, $reprobadas, $idalumno);
        $range = ((strtotime($fechafin) - strtotime($fechainicio)) + (24 * 60 * 60)) / (24 * 60 * 60);

        $tabla .= ' <table class="table table-hover table-striped">
                                            <thead class="bg-teal">
            <th>#</th>
            <th>MATERIA</th>';
        for ($i = 0; $i < $range; $i++) :
            setlocale(LC_ALL, 'es_ES');
            $fecha = strftime("%A, %d de %B", strtotime($fechainicio) + ($i * (24 * 60 * 60)));

            $tabla .= '<th>' . utf8_encode($fecha) . '</th>';
        endfor;
        $tabla .= '</thead>';
        $n = 1;
        foreach ($materias as $row) {
            $tabla .= '<tr>';
            $tabla .= '<td>' . $n++ . '</td>';
            $tabla .= '<td>';
            if ($row->opcion == 0) {
                $tabla .= '<label style="color:red;">R: </label>';
            }

            $tabla .= '<strong>' . $row->nombreclase . '</strong><br><small>( ' . $row->nombre . ' ' . $row->apellidop . ' ' . $row->apellidom . '</small>)</td>';
            for ($i = 0; $i < $range; $i++) :
                $date_at = date("Y-m-d", strtotime($fechainicio) + ($i * (24 * 60 * 60)));
                $asist = $this->grupo->listaAsistencia($idalumno, $idhorario, $date_at, $row->idhorariodetalle);

                $tabla .= '<td>';
                if ($asist != false) {
                    switch ($asist->idmotivo) {
                        case 1:
                            # code...
                            $tabla .= '<span class="label label-success">' . $asist->nombremotivo . '</span>';

                            break;
                        case 2:
                            $tabla .= '<span class="label label-warning">' . $asist->nombremotivo . '</span>';

                            break;
                        case 3:
                            $tabla .= '<span class="label label-info">' . $asist->nombremotivo . '</span>';

                            break;
                        case 4:
                            $tabla .= '<span class="label label-danger">' . $asist->nombremotivo . '</span>';

                            # code...
                            break;

                        default:
                            # code...
                            break;
                    }
                } else {
                    $tabla .= "No registrado.";
                }

                $tabla .= '</td>';
            endfor;
            $tabla .= '</tr>';
        }
        $tabla .= '</table>';

        return $tabla;
    }

    public function obetnerAsistenciaAlu($idalumno, $idhorario, $idhorariodetalle, $fechainicio, $fechafin, $idmotivo)
    {
        Permission::grant(uri_string());
        $idhorario = $this->decode($idhorario);
        $idhorariodetalle = $this->decode($idhorariodetalle);
        $idalumno = $this->decode($idalumno);
        if ((isset($idhorario) && !empty($idhorario)) && (isset($idhorariodetalle) && !empty($idhorariodetalle)) && (isset($idalumno) && !empty($idalumno)) && (isset($fechainicio) && !empty($fechainicio)) && (isset($fechafin) && !empty($fechafin)) && (isset($idmotivo))) {
            $tabla = "";
            $array_materias_reprobadas = array();
            $materias_reprobadas = $this->alumno->obtenerTodasMateriaReprobadasActivas($idalumno);
            if (isset($materias_reprobadas) && !empty($materias_reprobadas)) {
                foreach ($materias_reprobadas as $row) {
                    array_push($array_materias_reprobadas, $row->idmateriaprincipal);
                }
            }
            $reprobadas = implode(",", $array_materias_reprobadas);

            $materias = $this->alumno->showAllMateriasAsistencias($idhorario, $reprobadas, $idalumno);

            $range = ((strtotime($fechafin) - strtotime($fechainicio)) + (24 * 60 * 60)) / (24 * 60 * 60);

            $tabla .= '  <table id="tablageneral2" class="table table-striped   dt-responsive nowrap" cellspacing="0" width="100%">
            <thead class="bg-teal">
            <th>#</th>
            <th>Nombre</th>';
            for ($i = 0; $i < $range; $i++) :
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
            foreach ($materias as $row) {
                $tabla .= '<tr>';
                $tabla .= '<td>' . $n++ . '</td>';
                $tabla .= '<td>';
                if ($row->opcion == 0) {
                    $tabla .= '<label style="color:red;">R: </label>';
                }

                $tabla .= ' <strong>' . $row->nombreclase . '</strong><br><small>( ' . $row->nombre . ' ' . $row->apellidop . ' ' . $row->apellidom . '</small>)</td>';
                for ($i = 0; $i < $range; $i++) :
                    $date_at = date("Y-m-d", strtotime($fechainicio) + ($i * (24 * 60 * 60)));
                    $domingo = date('N', strtotime($fechainicio) + ($i * (24 * 60 * 60)));
                    $asist = $this->grupo->listaAsistenciaBuscar($idalumno, $idhorario, $date_at, $row->idhorariodetalle, $idmotivo);

                    if ($domingo != '7') {
                        if ($domingo != '6') {
                            $tabla .= '<td>';
                            if ($asist != false) {
                                switch ($asist->idmotivo) {
                                    case 1:
                                        # code...
                                        $tabla .= '<span class="label label-success">' . $asist->nombremotivo . '</span>';

                                        break;
                                    case 2:
                                        $tabla .= '<span class="label label-warning">' . $asist->nombremotivo . '</span>';

                                        break;
                                    case 3:
                                        $tabla .= '<span class="label label-info">' . $asist->nombremotivo . '</span>';

                                        break;
                                    case 4:
                                        $tabla .= '<span class="label label-danger">' . $asist->nombremotivo . '</span>';

                                        # code...
                                        break;

                                    default:
                                        # code...
                                        break;
                                }
                            } else {
                                $tabla .= "No registrado";
                            }

                            $tabla .= '</td>';
                        }
                    }
                endfor;
                $tabla .= '</tr>';
            }
            $tabla .= '</table>';
            $detalle = $this->alumno->showAllMateriasAlumno($idalumno);
            $motivo = $this->grupo->motivoAsistencia();
            $unidades = $this->grupo->unidades($this->session->idplantel);
            $nombreclase = $detalle[0]->nombreclase;
            $data = array(
                'motivos' => $motivo,
                'idhorario' => $idhorario,
                'idhorariodetalle' => $idhorariodetalle,
                'tabla' => $tabla,
                'nombreclase' => $nombreclase,
                'unidades' => $unidades,
                'idalumno' => $idalumno,
                'controller' => $this
            );
            $this->load->view('tutor/header');
            $this->load->view('tutor/asistencia/busqueda', $data);
            $this->load->view('tutor/footer');
        } else {
            $data = array(
                'heading' => 'Error',
                'message' => 'Intente mas tarde.'
            );
            $this->load->view('tutor/header');
            $this->load->view('tutor/error/general', $data);
            $this->load->view('tutor/footer');
        }
    }

    public function encode($string)
    {
        $encrypted = $this->encryption->encrypt($string);
        if (!empty($string)) {
            $encrypted = strtr($encrypted, array(
                '/' => '~'
            ));
        }
        return $encrypted;
    }

    public function decode($string)
    {
        $string = strtr($string, array(
            '~' => '/'
        ));
        return $this->encryption->decrypt($string);
    }

    public function pagos($idalumno = '', $idnivel = '', $idperiodo = '')
    {
        Permission::grant(uri_string());
        $idalumno = $this->decode($idalumno);
        $idnivel = $this->decode($idnivel);
        $idperiodo = $this->decode($idperiodo);
        // $this->encryption->initialize(array('driver' => 'openssl'));
        if ((isset($idalumno) && !empty($idalumno)) && (isset($idnivel) && !empty($idnivel)) && (isset($idperiodo) && !empty($idperiodo))) {
            $pago_inicio = $this->alumno->showAllPagoInscripcion($idalumno, $idperiodo);
            $pago_colegiaturas = $this->alumno->showAllPagoColegiaturas($idalumno, $idperiodo);
            $meses = $this->tutor->showAllMeses($idalumno, $idperiodo);
            $detalle_alumno = $this->alumno->detalleAlumno($idalumno);
            $nombre_alumno = $detalle_alumno->apellidop . ' ' . $detalle_alumno->apellidom . ' ' . $detalle_alumno->nombre;
            $data = array(
                'pago_inicio' => $pago_inicio,
                'pago_colegiaturas' => $pago_colegiaturas,
                'idalumno' => $this->encode($idalumno),
                'idperiodo' => $this->encode($idperiodo),
                'idnivel' => $this->encode($idnivel),
                'meses' => $meses,
                'nombre_alumno' => $nombre_alumno
            );
            $this->load->view('tutor/header');
            $this->load->view('tutor/alumnos/pagos', $data);
            $this->load->view('tutor/footer');
        } else {
            $data = array(
                'heading' => 'Error',
                'message' => 'Error intente mas tarde.'
            );
            $this->load->view('tutor/header');
            $this->load->view('tutor/error/general', $data);
            $this->load->view('tutor/footer');
        }
    }

    public function pagoi($idalumno = '', $idperiodo = '', $idnivel = '', $tipo = '')
    {
        Permission::grant(uri_string());
        $idalumno = $this->decode($idalumno);
        $idperiodo = $this->decode($idperiodo);
        $idnivel = $this->decode($idnivel);
        $idplantel = $this->session->idplantel;

        if ((isset($idalumno) && !empty($idalumno)) && (isset($idperiodo) && !empty($idperiodo)) && (isset($idnivel) && !empty($idnivel)) && (isset($tipo) && !empty($tipo))) {
            $mensaje = "";
            if ($tipo == 1) {
                $detalle = $this->tutor->precioColegiatura(2, $idnivel, $idplantel);
                $mensaje .= "PAGO DE REINSCRIPCIÓN";
            } elseif ($tipo == 2) {
                $detalle = $this->tutor->precioColegiatura(3, $idnivel, $idplantel);
                $mensaje .= "PAGO DE MENSUALIDAD";
            } else {
                $detalle = false;
            }

            if ($detalle != false) {
                $descuento = $detalle[0]->descuento;
                $detalle_alumno = $this->alumno->detalleAlumno($idalumno);
                $nombre_alumno = $detalle_alumno->apellidop . ' ' . $detalle_alumno->apellidom . ' ' . $detalle_alumno->nombre;
                $data = array(
                    'idalumno' => $this->encode($idalumno),
                    'idperiodo' => $this->encode($idperiodo),
                    'descuento' => $descuento,
                    'mensaje' => $mensaje,
                    'idnivel' => $this->encode($idnivel),
                    'formapago' => 1,
                    'nombre_alumno' => $nombre_alumno,
                    'alumno' => $idalumno,
                    'periodo' => $idperiodo
                );
                $this->load->view('tutor/header');
                $this->load->view('tutor/alumnos/pago_inscripcion', $data);
                $this->load->view('tutor/footer');
            } else {
                $data = array(
                    'heading' => 'Notificación',
                    'message' => 'No se puede pagar por el momento, intente mas tarde.'
                );
                $this->load->view('tutor/header');
                $this->load->view('tutor/error/general', $data);
                $this->load->view('tutor/footer');
            }
        } else {
            $data = array(
                'heading' => 'Error',
                'message' => 'Error intente mas tarde.'
            );
            $this->load->view('tutor/header');
            $this->load->view('tutor/error/general', $data);
            $this->load->view('tutor/footer');
        }
    }

    public function costoPagoInicio()
    {
        $idplantel = $this->session->idplantel;
        $idalumno = $this->input->post('alumno');
        $idperiodo = $this->input->post('periodo');
        $idconcepto = $this->input->post('concepto');
        $cobro_colegiatura = 0;
        $detalle_concepto = "";
        switch ($idconcepto) {
            case 1:
                $detalle_concepto .= "INSCRIPCIÓN";
                break;
            case 2:
                $detalle_concepto .= "REINSCRIPCIÓN";
                break;

            default:
                $detalle_concepto .= "NO DEFINIDO";
                break;
        }
        $detalle_niveleducativo = $this->alumno->detalleAlumnoNivelEducativo($idalumno, $idperiodo);
        if ($detalle_niveleducativo) {
            $idniveleducativo = $detalle_niveleducativo->idnivelestudio;
            $detalle_descuento = $this->estadocuenta->descuentoPagosInicio($idalumno, $idperiodo, $idconcepto, $idplantel, $idniveleducativo);
            if ($detalle_descuento) {
                if ($detalle_descuento[0]->descuento > 0) {
                    $cobro_colegiatura = $detalle_descuento[0]->descuento;
                } else {
                    $cobro_colegiatura = 0;
                }
            } else {
                $cobro_colegiatura = 0;
            }
        } else {
            $cobro_colegiatura = 0;
        }

        $result['resultado'] = array(
            'concepto' => $detalle_concepto,
            'costototal' => $cobro_colegiatura
        );

        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function agregarCostoColegiatura()
    {
        $idplantel = $this->session->idplantel;
        $idalumno = $this->input->post('alumno');
        $idperiodo = $this->input->post('periodo');
        $idmes = $this->input->post('mes');
        $costo_colegiatura = 0;
        $recargo = 0;
        $consto_normal = 0;
        $detalle_niveleducativo = $this->alumno->detalleAlumnoNivelEducativo($idalumno, $idperiodo);
        if ($detalle_niveleducativo) {
            $idniveleducativo = $detalle_niveleducativo->idnivelestudio;
            $detalle_descuento = $this->estadocuenta->descuentoPagosInicio($idalumno, $idperiodo, 3, $idplantel, $idniveleducativo);
            $detalle_alumno = $this->alumno->detalleAlumno($idalumno);
            $detalle_configuracion = $this->configuracion->showAllConfiguracion($this->session->idplantel, $detalle_alumno->idniveleducativo);

            if ($detalle_descuento[0]->idniveleducativo == 1) {
                // PRIMARIA

                $dia_actual = date('Y-m-d');
                $year_actual = date('Y');
                $dia_pago = date('Y-m-d', strtotime($detalle_configuracion[0]->diaultimorecargo . "-" . $idmes . "-" . $year_actual));
                if ($dia_actual > $dia_pago) {
                    $recargo += $detalle_configuracion[0]->totalrecargo;
                } else {
                    $recargo += 0;
                }
            } elseif ($detalle_descuento[0]->idniveleducativo == 2) {
                // SECUNDARIA

                $dia_actual = date('Y-m-d');
                $year_actual = date('Y');
                $dia_pago = date('Y-m-d', strtotime($detalle_configuracion[0]->diaultimorecargo . "-" . $idmes . "-" . $year_actual));
                if ($dia_actual > $dia_pago) {
                    $recargo += $detalle_configuracion[0]->totalrecargo;
                } else {
                    $recargo += 0;
                }
            } elseif ($detalle_descuento[0]->idniveleducativo == 3) {
                // PREPA

                $dia_actual = date('Y-m-d');
                $year_actual = date('Y');
                $dia_pago = date('Y-m-d', strtotime($detalle_configuracion[0]->diaultimorecargo . "-" . $idmes . "-" . $year_actual));
                if ($dia_actual > $dia_pago) {
                    $recargo += $detalle_configuracion[0]->totalrecargo;
                } else {
                    $recargo += 0;
                }
            } else {
                $recargo = 0;
            }
            $consto_normal = (($detalle_descuento[0]->descuento - ($detalle_descuento[0]->descuentobeca / 100 * $detalle_descuento[0]->descuento)) * 1);
            $descuento_correcto = (($detalle_descuento[0]->descuento - ($detalle_descuento[0]->descuentobeca / 100 * $detalle_descuento[0]->descuento)) * 1) + $recargo;
            $costo_colegiatura = $descuento_correcto;
        } else {
            $costo_colegiatura = 0;
        }
        $result['resultado'] = array(
            'costototal' => $costo_colegiatura,
            'colegiatura' => $consto_normal,
            'recargo' => $recargo
        );

        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function pagoc($idalumno = '', $idperiodo = '', $idnivel = '', $tipo = '')
    {
        date_default_timezone_set("America/Mexico_City");
        Permission::grant(uri_string());
        $idalumno = $this->decode($idalumno);
        $idperiodo = $this->decode($idperiodo);
        $idnivel = $this->decode($idnivel);

        $detalle_niveleducativo = $this->alumno->detalleAlumnoNivelEducativo($idalumno, $idperiodo);
        if ((isset($idalumno) && !empty($idalumno)) && (isset($idperiodo) && !empty($idperiodo)) && (isset($idnivel) && !empty($idnivel)) && (isset($tipo) && !empty($tipo)) && $detalle_niveleducativo) {
            $idniveleducativo = $detalle_niveleducativo->idnivelestudio;
            $mensaje = "";
            $idplantel = $this->session->idplantel;
            if ($tipo == 1) {
                $detalle = $this->tutor->precioColegiatura(2, $idnivel, $idplantel);
                $mensaje .= "PAGO DE REINSCRIPCIÓN";
            } elseif ($tipo == 2) {
                $detalle = $this->tutor->precioColegiatura(3, $idnivel, $idplantel);
                $mensaje .= "PAGO DE MENSUALIDAD";
            } else {
                $detalle = false;
            }

            if ($detalle != false) {
                $detalle_descuento = $this->estadocuenta->descuentoPagosInicio($idalumno, $idperiodo, 3, $idplantel, $idniveleducativo);
                $detalle_configuracion = $this->configuracion->showAllConfiguracion($this->session->idplantel);
                $recargo = 0;
                if ($detalle_descuento[0]->idniveleducativo == 1) {
                    // PRIMARIA
                    $dia_actual = date('Y-m-d');
                    $year_actual = date('Y');
                    $mes_actual = date('m');
                    $detalle_configuracion[0]->diaultimorecargo;
                    $dia_pago = date('Y-m-d', strtotime($detalle_configuracion[0]->diaultimorecargo . "-" . $mes_actual . "-" . $year_actual));
                    if ($dia_actual > $dia_pago) {
                        $recargo += $detalle_configuracion[0]->totalrecargo;
                    } else {
                        $recargo += 0;
                    }
                } elseif ($detalle_descuento[0]->idniveleducativo == 2) {
                    // SECUNDARIA
                    $dia_actual = date('Y-m-d');
                    $year_actual = date('Y');
                    $mes_actual = date('m');
                    $dia_pago = date('Y-m-d', strtotime($detalle_configuracion[0]->diaultimorecargo . "-" . $mes_actual . "-" . $year_actual));
                    if ($dia_actual > $dia_pago) {
                        $recargo += $detalle_configuracion[0]->totalrecargo;
                    } else {
                        $recargo += 0;
                    }
                } elseif ($detalle_descuento[0]->idniveleducativo == 3) {
                    // PREPA
                    $dia_actual = date('Y-m-d');
                    $year_actual = date('Y');
                    $mes_actual = date('m');
                    $dia_pago = date('Y-m-d', strtotime($detalle_configuracion[0]->diaultimorecargo . "-" . $mes_actual . "-" . $year_actual));
                    if ($dia_actual > $dia_pago) {
                        $recargo += $detalle_configuracion[0]->totalrecargo;
                    } else {
                        $recargo += 0;
                    }
                } elseif ($detalle_descuento[0]->idniveleducativo == 4) {
                    // PREPA
                    $dia_actual = date('Y-m-d');
                    $year_actual = date('Y');
                    $mes_actual = date('m');
                    $dia_pago = date('Y-m-d', strtotime($detalle_configuracion[0]->diaultimorecargo . "-" . $mes_actual . "-" . $year_actual));
                    if ($dia_actual > $dia_pago) {
                        $recargo += $detalle_configuracion[0]->totalrecargo;
                    } else {
                        $recargo += 0;
                    }
                } elseif ($detalle_descuento[0]->idniveleducativo == 5) {
                    // PREPA
                    $dia_actual = date('Y-m-d');
                    $year_actual = date('Y');
                    $mes_actual = date('m');
                    $dia_pago = date('Y-m-d', strtotime($detalle_configuracion[0]->diaultimorecargo . "-" . $mes_actual . "-" . $year_actual));
                    if ($dia_actual > $dia_pago) {
                        $recargo += $detalle_configuracion[0]->totalrecargo;
                    } else {
                        $recargo += 0;
                    }
                } else {
                    $recargo = 0;
                }

                $descuento = $detalle[0]->descuento;
                $meses = $this->tutor->showAllMeses($idalumno, $idperiodo);
                $detalle_alumno = $this->alumno->detalleAlumno($idalumno);
                $nombre_alumno = $detalle_alumno->apellidop . ' ' . $detalle_alumno->apellidom . ' ' . $detalle_alumno->nombre;
                $data = array(
                    'idalumno' => $this->encode($idalumno),
                    'idperiodo' => $this->encode($idperiodo),
                    'colegiatura' => $descuento,
                    'descuento' => $descuento + $recargo,
                    'mensaje' => $mensaje,
                    'meses' => $meses,
                    'msgrecargo' => 'RECARGO',
                    'recargo' => $recargo,
                    'idnivel' => $this->encode($idnivel),
                    'formapago' => 1,
                    'nombre_alumno' => $nombre_alumno,
                    'alumno' => $idalumno,
                    'periodo' => $idperiodo
                );
                $this->load->view('tutor/header');
                $this->load->view('tutor/alumnos/pago_colegiatura', $data);
                $this->load->view('tutor/footer');
            } else {
                $data = array(
                    'heading' => 'Notificación',
                    'message' => 'No se puede pagar por el momento, intente mas tarde.'
                );
                $this->load->view('tutor/header');
                $this->load->view('tutor/error/general', $data);
                $this->load->view('tutor/footer');
            }
        } else {
            $data = array(
                'heading' => 'Error',
                'message' => 'Error intente mas tarde.'
            );
            $this->load->view('tutor/header');
            $this->load->view('tutor/error/general', $data);
            $this->load->view('tutor/footer');
        }
    }

    public function buscarCP()
    {
        # code...
        $cp = $_POST['b'];
        $array = $this->alumno->showColonias($cp);

        $select = "";
        // $select .= '<option value="">--SELECCIONAR--</option>';
        if (isset($array) && !empty($array)) {
            foreach ($array as $value) {
                # code...
                // $select .= '<option value="">--SELECCIONAR--</option>';
                $select .= '<option value="' . $value->idcolonia . '">' . strtoupper($value->nombrecolonia) . '</option>';
            }
        }

        echo $select;
    }

    public function buscarMunicipioCP()
    {
        # code...
        $cp = $_POST['b'];
        $array = $this->alumno->showMunicipio($cp);

        $select = "";
        if (isset($array) && !empty($array)) {
            foreach ($array as $value) {
                # code...
                $select .= '<option value="' . $value->idmunicipio . '">' . strtoupper($value->nombremunicipio) . '</option>';
            }
        } else {
            $select .= '<option value="">--SELECCIONAR--</option>';
        }
        echo $select;
    }

    public function buscarEstadoCP()
    {
        # code...
        $cp = $_POST['b'];
        $array = $this->alumno->showEstado($cp);

        $select = "";
        if (isset($array) && !empty($array)) {
            foreach ($array as $value) {
                # code...
                $select .= '<option value="' . $value->idestado . '">' . strtoupper($value->nombreestado) . '</option>';
            }
        } else {
            $select .= '<option value="">--SELECCIONAR--</option>';
        }
        echo $select;
    }

    public function pagotarjeta()
    {
        // PAGO DE REISCRIPCION O INSCRIPCION CON TARJETA
        Permission::grant(uri_string());
        $idperiodo = $this->decode($this->input->post('periodo'));
        $idalumno = $this->decode($this->input->post('alumno'));
        $idnivel = $this->decode($this->input->post('nivel'));
        if ((isset($idnivel) && !empty($idnivel)) && (isset($idperiodo) && !empty($idperiodo)) && (isset($idalumno) && !empty($idalumno))) {
            try {
                $idtutor = $this->session->idtutor;
                $detalle_tutor = $this->tutor->detalleTutor($idtutor);
                $detalle_alumno = $this->alumno->detalleAlumno($idalumno);
                $matricula = $detalle_alumno->matricula;
                $nombretarjetahabiente = $this->input->post('nombretitular');
                $calle = $this->input->post('calletitular');
                $numero = $this->input->post('numerocasa');
                $idconcepto = $this->input->post('conceptopago');
                $idcolonia = $this->input->post('colonia');
                $detalle_colonia = $this->tutor->detalleColonia($idcolonia);
                $cp = $this->input->post('cp');
                $descuento = $this->input->post('descuento');
                $mensaje = $this->input->post('mensaje');
                $folio = generateRandomString();
                $validar_mes = $this->estadocuenta->validarAddReincripcion($idalumno, $idperiodo);

                if ($validar_mes == false && $descuento > 0) {
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
                            'country_code' => 'MX'
                        )
                    );

                    $chargeData = array(
                        'method' => 'card',
                        'source_id' => $_POST["token_id"],
                        'amount' => (float) $descuento,
                        'description' => $mensaje . ", MATRICULA: " . $matricula,
                        'device_session_id' => $_POST["deviceIdHiddenFieldName"],
                        'customer' => $customer
                    );

                    $charge = $openpay->charges->create($chargeData);
                    $response['charge'] = $charge;
                    $idopenpay = $charge->id;
                    $idorden = $charge->order_id;
                    $autorizacion = $charge->authorization;
                    // SE AGREGA EL PAGO A LA TABLA DE PAGO DE INICIO
                    $add_cobro = array(
                        'folio' => $folio,
                        'idperiodo' => $idperiodo,
                        'idalumno' => $idalumno,
                        'idtipopagocol' => $idconcepto,
                        'descuento' => $descuento,
                        'totalrecargo' => 0,
                        'recargo' => 0,
                        'condonar' => 0,
                        'idopenpay' => $idopenpay,
                        'idorden' => $idorden,
                        'online' => 1,
                        'pagado' => 1,
                        'fechapago' => date('Y-m-d H:i:s'),
                        'eliminado' => 0,
                        'idusuario' => $this->session->user_id,
                        'fecharegistro' => date('Y-m-d H:i:s')
                    );
                    $idpago = $this->tutor->addCobroReinscripcion($add_cobro);

                    // SE AGREGA EL PAGO A LA TABLA DE DETALLE DE PAGO DE INICIO

                    $data_detalle_cobro = array(
                        'idpago' => $idpago,
                        'idformapago' => 2,
                        'autorizacion' => $autorizacion,
                        'descuento' => $descuento,
                        'idusuario' => $this->session->user_id,
                        'fecharegistro' => date('Y-m-d H:i:s')
                    );
                    $this->tutor->addDetallePagoInicio($data_detalle_cobro);

                    $data = array(
                        'tipo_error' => 0,
                        'msg' => "AUTORIZACIÓN: " . $autorizacion,
                        'alumno' => $this->encode($idalumno),
                        'idestadocuenta' => $this->encode($idpago),
                        'tipo_pago' => $this->encode(10)
                    );
                    echo json_encode($data);
                } else {
                    $data = array(
                        'tipo_error' => 1,
                        'msg' => "La Reinscripción o Inscripción ya se encuentra pagado o el total esta en 0."
                    );
                    echo json_encode($data);
                }
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
                $data = array(
                    'tipo_error' => 1,
                    'msg' => $mensaje
                );
                echo json_encode($data);
            } catch (OpenpayApiRequestError $e) {
                $mensaje .= $e->getMessage();
                $data = array(
                    'tipo_error' => 1,
                    'msg' => $mensaje
                );
                echo json_encode($data);
            } catch (OpenpayApiConnectionError $e) {
                $mensaje .= $e->getMessage();
                $data = array(
                    'tipo_error' => 1,
                    'msg' => $mensaje
                );
                echo json_encode($data);
            } catch (OpenpayApiAuthError $e) {
                $mensaje .= $e->getMessage();
                $data = array(
                    'tipo_error' => 1,
                    'msg' => $mensaje
                );
                echo json_encode($data);
            } catch (OpenpayApiError $e) {
                $mensaje .= $e->getMessage();
                $data = array(
                    'tipo_error' => 1,
                    'msg' => $mensaje
                );
                echo json_encode($data);
            } catch (Exception $e) {
                $mensaje .= $e->getMessage();
                $data = array(
                    'tipo_error' => 1,
                    'msg' => $mensaje
                );
                echo json_encode($data);
            }
        } else {
            $data = array(
                'heading' => 'Error',
                'message' => 'Error intente mas tarde.'
            );
            $this->load->view('tutor/header');
            $this->load->view('tutor/error/general', $data);
            $this->load->view('tutor/footer');
        }
    }

    public function pagotarjetac()
    {
        // PAGO DE COLEGIATURA CON TARJETAS
        Permission::grant(uri_string());
        $idplantel = $this->session->idplantel;
        $idperiodo = $this->decode($this->input->post('periodo'));
        $idalumno = $this->decode($this->input->post('alumno'));
        $idnivel = $this->decode($this->input->post('nivel'));
        $detalle_niveleducativo = $this->alumno->detalleAlumnoNivelEducativo($idalumno, $idperiodo);

        if ((isset($idnivel) && !empty($idnivel)) && (isset($idperiodo) && !empty($idperiodo)) && (isset($idalumno) && !empty($idalumno)) && $detalle_niveleducativo) {
            $meses = $this->tutor->showAllMeses($idalumno, $idperiodo);

            $idniveleducativo = $detalle_niveleducativo->idnivelestudio;
            try {
                $idtutor = $this->session->idtutor;
                $detalle_tutor = $this->tutor->detalleTutor($idtutor);
                $detalle_alumno = $this->alumno->detalleAlumno($idalumno);
                $matricula = $detalle_alumno->matricula;
                $nombretarjetahabiente = $this->input->post('nombretitular');
                $calle = $this->input->post('calletitular');
                $numero = $this->input->post('numerocasa');
                $idcolonia = $this->input->post('colonia');
                $detalle_colonia = $this->tutor->detalleColonia($idcolonia);
                $cp = $this->input->post('cp');
                $descuento = $this->input->post('descuento');
                $recargo = $this->input->post('recargo');
                $mensaje = "";
                $concepto_cobro = $this->input->post('mensaje');
                $idmes = $this->input->post('mespago');
                $detalle_mes = $this->tutor->detalleMes($idmes);
                $validar_mes = $this->estadocuenta->validarAddColegiatura($idalumno, $idperiodo, $idmes);

                if ($validar_mes == false && $descuento > 0) {

                    $folio = generateRandomString();
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
                            'country_code' => 'MX'
                        )
                    );

                    $chargeData = array(
                        'method' => 'card',
                        'source_id' => $_POST["token_id"],
                        'amount' => (float) ($descuento + $recargo),
                        'description' => $concepto_cobro . " DE " . $detalle_mes[0]->nombremes . ", MATRICULA ALUMNO(A): " . $matricula,
                        'device_session_id' => $_POST["deviceIdHiddenFieldName"],
                        'customer' => $customer
                    );

                    $charge = $openpay->charges->create($chargeData);
                    $response['charge'] = $charge;
                    $idopenpay = $charge->id;
                    $idorden = $charge->order_id;
                    $autorizacion = $charge->authorization;
                    // SE CREA UN REGISTRO EN LA TABLA ESTADO DE CUENTA
                    $add_estadocuenta = array(
                        'folio' => $folio,
                        'idperiodo' => $idperiodo,
                        'idalumno' => $idalumno,
                        'descuento' => ($descuento + $recargo),
                        'totalrecargo' => $recargo,
                        'recargo' => ($recargo > 0) ? 1 : 0,
                        'condonar' => 0,
                        'idopenpay' => $idopenpay,
                        'idorden' => $idorden,
                        'online' => 1,
                        'pagado' => 1,
                        'fechapago' => date('Y-m-d H:i:s'),
                        'eliminado' => 0,
                        'idusuario' => $this->session->user_id,
                        'fecharegistro' => date('Y-m-d H:i:s')
                    );
                    $idestadocuenta = $this->tutor->addEstadoCuenta($add_estadocuenta);
                    // SE CRE UN REGISTRO EN LA TABLA DETALLE DE PAGO
                    $add_detalle_pago = array(
                        'idestadocuenta' => $idestadocuenta,
                        'idformapago' => 2,
                        'descuento' => ($descuento + $recargo),
                        'autorizacion' => $autorizacion,
                        'fechapago' => date('Y-m-d H:i:s'),
                        'idusuario' => $this->session->user_id,
                        'fecharegistro' => date('Y-m-d H:i:s')
                    );
                    $data_detalle_estadocuenta = array(
                        'idestadocuenta' => $idestadocuenta,
                        'idmes' => $idmes,
                        'idusuario' => $this->session->user_id,
                        'fecharegistro' => date('Y-m-d H:i:s')
                    );
                    $this->tutor->addDetalleEstadoCuenta($data_detalle_estadocuenta);
                    $this->tutor->addDetallePago($add_detalle_pago);

                    $data = array(
                        'tipo_error' => 0,
                        'msg' => "AUTORIZACIÓN: " . $autorizacion,
                        'alumno' => $this->encode($idalumno),
                        'idestadocuenta' => $this->encode($idestadocuenta),
                        'tipo_pago' => $this->encode(11)
                    );
                    echo json_encode($data);
                } else {
                    $data = array(
                        'tipo_error' => 1,
                        'msg' => "EL Mes ya se encuentra pagado."
                    );
                    echo json_encode($data);
                }
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

                $data = array(
                    'tipo_error' => 1,
                    'msg' => $mensaje
                );
                echo json_encode($data);
            } catch (OpenpayApiRequestError $e) {
                $mensaje .= $e->getMessage();
                $data = array(
                    'tipo_error' => 1,
                    'msg' => $mensaje
                );
                echo json_encode($data);
            } catch (OpenpayApiConnectionError $e) {
                $mensaje .= $e->getMessage();
                $data = array(
                    'tipo_error' => 1,
                    'msg' => $mensaje
                );
                echo json_encode($data);
            } catch (OpenpayApiAuthError $e) {
                $mensaje .= $e->getMessage();
                $data = array(
                    'tipo_error' => 1,
                    'msg' => $mensaje
                );
                echo json_encode($data);
            } catch (OpenpayApiError $e) {
                $mensaje .= $e->getMessage();
                $data = array(
                    'tipo_error' => 1,
                    'msg' => $mensaje
                );
                echo json_encode($data);
            } catch (Exception $e) {
                $mensaje .= $e->getMessage();
                $data = array(
                    'tipo_error' => 1,
                    'msg' => $mensaje
                );
                echo json_encode($data);
            }
        } else {
            $data = array(
                'heading' => 'Error',
                'message' => 'Error intente mas tarde.'
            );
            $this->load->view('tutor/header');
            $this->load->view('tutor/error/general', $data);
            $this->load->view('tutor/footer');
        }
    }

    public function pagotienda()
    {
        // PAGO DE INSCRIPCION O REINCRIPCION EN PAGO EN TIENDA
        Permission::grant(uri_string());
        $idperiodo = $this->decode($this->input->post('periodo'));
        $idalumno = $this->decode($this->input->post('alumno'));
        $idnivel = $this->decode($this->input->post('nivel'));
        if ((isset($idnivel) && !empty($idnivel)) && (isset($idperiodo) && !empty($idperiodo)) && (isset($idalumno) && !empty($idalumno))) {
            try {
                $mensaje = "";
                $idtutor = $this->session->idtutor;
                $detalle_tutor = $this->tutor->detalleTutor($idtutor);
                $descuento = $this->input->post('descuento');
                $idconcepto = $this->input->post('conceptopago');
                $concepto = $this->input->post('mensaje');
                $detalle_alumno = $this->alumno->detalleAlumno($idalumno);
                $matricula = $detalle_alumno->matricula;
                $folio = generateRandomString();
                $validar_pago = $this->estadocuenta->validarAddReincripcion($idalumno, $idperiodo);
                if ($validar_pago == false && $descuento > 0) {
                    $response = [];
                    Openpay::setProductionMode(false);
                    $openpay = Openpay::getInstance('mds4bdhgvbese0knzu2x', 'sk_f95d7349163642fba9f5a71021b3f6d5');
                    $customer = array(
                        'name' => strtoupper($detalle_tutor->nombre),
                        'last_name' => strtoupper($detalle_tutor->apellidop . ' ' . $detalle_tutor->apellidom),
                        'email' => $detalle_tutor->correo,
                        'phone_number' => $detalle_tutor->telefono
                    );
                    $chargeData = array(
                        'method' => 'store',
                        'amount' => $descuento,
                        'description' => $concepto,
                        'customer' => $customer
                    );
                    $charge = $openpay->charges->create($chargeData);

                    $response['charge'] = $charge;
                    $idopenpay = $charge->id;
                    $idorden = $charge->order_id;
                    $autorizacion = $charge->authorization;
                    $barcode = $charge->payment_method->barcode_url;
                    $referencia = $charge->payment_method->reference;
                    $add_cobro = array(
                        'folio' => $folio,
                        'idperiodo' => $idperiodo,
                        'idalumno' => $idalumno,
                        'idtipopagocol' => $idconcepto,
                        'descuento' => $descuento,
                        'totalrecargo' => 0.00,
                        'recargo' => 0,
                        'condonar' => 0,
                        'idopenpay' => $idopenpay,
                        'idorden' => $idorden,
                        'online' => 1,
                        'pagado' => 0,
                        'fechapago' => date('Y-m-d H:i:s'),
                        'eliminado' => 0,
                        'idusuario' => $this->session->user_id,
                        'fecharegistro' => date('Y-m-d H:i:s')
                    );
                    $idpago = $this->tutor->addCobroReinscripcion($add_cobro);
                    // AGREGAR COBRO A TABLA DETALLE DE PAGO INICIO
                    $data_detalle_cobro = array(
                        'idpago' => $idpago,
                        'idformapago' => 1,
                        'autorizacion' => $autorizacion,
                        'descuento' => $descuento,
                        'idusuario' => $this->session->user_id,
                        'fecharegistro' => date('Y-m-d H:i:s')
                    );
                    $this->tutor->addDetallePagoInicio($data_detalle_cobro);

                    $data = array(
                        'tipo_error' => 0,
                        'msg' => "Descargar el Documento.",
                        'referencia' => $referencia
                    );
                    echo json_encode($data);
                } else {
                    $data = array(
                        'tipo_error' => 1,
                        'msg' => "La Reinscripción o Inscripción ya se encuentra pagado o el total esta en 0.00."
                    );
                    echo json_encode($data);
                }
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
                $data = array(
                    'tipo_error' => 1,
                    'msg' => $mensaje
                );
                echo json_encode($data);
            } catch (OpenpayApiRequestError $e) {
                $mensaje .= $e->getMessage();
                $data = array(
                    'tipo_error' => 1,
                    'msg' => $mensaje
                );
                echo json_encode($data);
            } catch (OpenpayApiConnectionError $e) {
                $mensaje .= $e->getMessage();
                $data = array(
                    'tipo_error' => 1,
                    'msg' => $mensaje
                );
                echo json_encode($data);
            } catch (OpenpayApiAuthError $e) {
                $mensaje .= $e->getMessage();
                $data = array(
                    'tipo_error' => 1,
                    'msg' => $mensaje
                );
                echo json_encode($data);
            } catch (OpenpayApiError $e) {
                $mensaje .= $e->getMessage();
                $data = array(
                    'tipo_error' => 1,
                    'msg' => $mensaje
                );
                echo json_encode($data);
            } catch (Exception $e) {
                $mensaje .= $e->getMessage();
                $data = array(
                    'tipo_error' => 1,
                    'msg' => $mensaje
                );
                echo json_encode($data);
            }
        } else {
            $data = array(
                'heading' => 'Error',
                'message' => 'Error intente mas tarde.'
            );
            $this->load->view('tutor/header');
            $this->load->view('tutor/error/general', $data);
            $this->load->view('tutor/footer');
        }
    }

    public function pagotiendac()
    {
        // PAGO EN TIENDA DE LAS COLEGIATURAS
        Permission::grant(uri_string());
        $idperiodo = $this->decode($this->input->post('periodo'));
        $idalumno = $this->decode($this->input->post('alumno'));
        $idnivel = $this->decode($this->input->post('nivel'));
        $detalle_niveleducativo = $this->alumno->detalleAlumnoNivelEducativo($idalumno, $idperiodo);
        if ((isset($idnivel) && !empty($idnivel)) && (isset($idperiodo) && !empty($idperiodo)) && (isset($idalumno) && !empty($idalumno)) && $detalle_niveleducativo) {
            $meses = $this->tutor->showAllMeses($idalumno, $idperiodo);
            $idniveleducativo = $detalle_niveleducativo->idnivelestudio;
            try {
                $mensaje = "";
                $idtutor = $this->session->idtutor;
                $detalle_tutor = $this->tutor->detalleTutor($idtutor);
                $descuento = $this->input->post('descuento');
                $recargo = $this->input->post('recargo');
                $concepto_cobro = $this->input->post('mensaje');
                $idmes = $this->input->post('mespago');
                $detalle_mes = $this->tutor->detalleMes($idmes);
                $folio = generateRandomString();
                $idplantel = $this->session->idplantel;
                $validar_mes = $this->estadocuenta->validarAddColegiatura($idalumno, $idperiodo, $idmes);

                if ($validar_mes == false && $descuento > 0) {

                    $response = [];
                    Openpay::setProductionMode(false);
                    $openpay = Openpay::getInstance('mds4bdhgvbese0knzu2x', 'sk_f95d7349163642fba9f5a71021b3f6d5');
                    $customer = array(
                        'name' => strtoupper($detalle_tutor->nombre),
                        'last_name' => strtoupper($detalle_tutor->apellidop . ' ' . $detalle_tutor->apellidom),
                        'email' => $detalle_tutor->correo,
                        'phone_number' => $detalle_tutor->telefono
                    );
                    $chargeData = array(
                        'method' => 'store',
                        'amount' => $descuento,
                        'description' => $concepto_cobro . " DE " . $detalle_mes[0]->nombremes,
                        'customer' => $customer
                    );
                    $charge = $openpay->charges->create($chargeData);
                    $response['charge'] = $charge;
                    // var_dump($charge);
                    $idopenpay = $charge->id;
                    $idorden = $charge->order_id;
                    $autorizacion = $charge->authorization;
                    $barcode = $charge->payment_method->barcode_url;
                    $referencia = $charge->payment_method->reference;

                    $add_estadocuenta = array(
                        'folio' => $folio,
                        'idperiodo' => $idperiodo,
                        'idalumno' => $idalumno,
                        'descuento' => ($descuento + $recargo),
                        'totalrecargo' => $recargo,
                        'recargo' => ($recargo > 0) ? 1 : 0,
                        'condonar' => 0,
                        'idopenpay' => $idopenpay,
                        'idorden' => $idorden,
                        'online' => 1,
                        'pagado' => 0,
                        'fechapago' => date('Y-m-d H:i:s'),
                        'eliminado' => 0,
                        'idusuario' => $this->session->user_id,
                        'fecharegistro' => date('Y-m-d H:i:s')
                    );
                    $idestadocuenta = $this->tutor->addEstadoCuenta($add_estadocuenta);
                    $add_detalle_pago = array(
                        'idestadocuenta' => $idestadocuenta,
                        'idformapago' => 1,
                        'descuento' => ($descuento + $recargo),
                        'autorizacion' => $autorizacion,
                        'fechapago' => date('Y-m-d H:i:s'),
                        'idusuario' => $this->session->user_id,
                        'fecharegistro' => date('Y-m-d H:i:s')
                    );
                    $this->tutor->addDetallePago($add_detalle_pago);

                    $data_detalle_estadocuenta = array(
                        'idestadocuenta' => $idestadocuenta,
                        'idmes' => $idmes,
                        'idusuario' => $this->session->user_id,
                        'fecharegistro' => date('Y-m-d H:i:s')
                    );
                    $this->tutor->addDetalleEstadoCuenta($data_detalle_estadocuenta);

                    $data = array(
                        'tipo_error' => 0,
                        'msg' => "Descargar el Documento.",
                        'referencia' => $referencia
                    );
                    echo json_encode($data);
                } else {
                    $data = array(
                        'tipo_error' => 1,
                        'msg' => "El Mes ya se encuentra pagado o tiene como Total a pagar en 0."
                    );
                    echo json_encode($data);
                }
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

                $data = array(
                    'tipo_error' => 1,
                    'msg' => $mensaje
                );
                echo json_encode($data);
            } catch (OpenpayApiRequestError $e) {
                $mensaje .= $e->getMessage();

                $data = array(
                    'tipo_error' => 1,
                    'msg' => $mensaje
                );
                echo json_encode($data);
            } catch (OpenpayApiConnectionError $e) {
                $mensaje .= $e->getMessage();

                $data = array(
                    'tipo_error' => 1,
                    'msg' => $mensaje
                );
                echo json_encode($data);
            } catch (OpenpayApiAuthError $e) {
                $mensaje .= $e->getMessage();

                $data = array(
                    'tipo_error' => 1,
                    'msg' => $mensaje
                );
                echo json_encode($data);
            } catch (OpenpayApiError $e) {
                $mensaje .= $e->getMessage();

                $data = array(
                    'tipo_error' => 1,
                    'msg' => $mensaje
                );
                echo json_encode($data);
            } catch (Exception $e) {
                $mensaje .= $e->getMessage();

                $data = array(
                    'tipo_error' => 1,
                    'msg' => $mensaje
                );
                echo json_encode($data);
            }
        } else {
            $data = array(
                'heading' => 'Error',
                'message' => 'Error intente mas tarde.'
            );
            $this->load->view('tutor/header');
            $this->load->view('tutor/error/general', $data);
            $this->load->view('tutor/footer');
        }
    }

    public function kardex()
    {
        Permission::grant(uri_string());
        $alumnos = $this->alumno->showAllAlumnosTutor($this->session->idtutor);
        $data = array(
            'alumnos' => $alumnos,
            'controller' => $this
        );
        $this->load->view('tutor/header');
        $this->load->view('tutor/alumnos/alumnos', $data);
        $this->load->view('tutor/footer');
        // $kardex = $this->alumno->allKardex($id);
    }

    public function calificacionFinal($idalumno)
    {
        $detalle = $this->alumno->allKardex($idalumno);
        $calificacion_periodo = 0;
        $suma_periodo = 0;
        $calificacion_global = 0;
        if (isset($detalle) && !empty($detalle)) {
            foreach ($detalle as $det) {
                $suma_periodo++;
                $idhorario = $det->idhorario;
                $idperiodo = $det->idperiodo;
                $materias = $this->alumno->showAllMateriasPasadas($idhorario, $idalumno, $idperiodo);

                if (isset($materias) && !empty($materias)) {

                    $oportunidades_examen = $this->alumno->showAllOportunidadesExamen($this->session->idplantel);
                    $total_materia = 0;
                    $suma_calificacion = 0;
                    $calificacion = 0;
                    foreach ($materias as $row) {
                        $idnivelestudio = $row->idnivelestudio;
                        $detalle_configuracion = $this->configuracion->showAllConfiguracion($this->session->idplantel, $idnivelestudio);
                        $total_materia = $total_materia + 1;
                        $idhorariodetalle = $row->idhorariodetalle;
                        $calificacion = 0;
                        foreach ($oportunidades_examen as $oportunidad) {
                            $idoportunidadexamen = $oportunidad->idoportunidadexamen;
                            $detalle_calificacion = $this->alumno->calificacionSecuPrepa($idalumno, $idhorariodetalle, $idoportunidadexamen);
                            if ($detalle_calificacion && $calificacion == 0) {
                                if ($detalle_calificacion[0]->calificacion >= $detalle_configuracion[0]->calificacion_minima) {
                                    $calificacion .= $detalle_calificacion[0]->calificacion;
                                    $suma_calificacion += $calificacion;
                                }
                            }
                        }
                    }

                    $calificacion = $suma_calificacion / $total_materia;

                    $calificacion_periodo += numberFormatPrecision($calificacion, 1, '.');
                }
            }
        }

        if ($calificacion_periodo > 0 && $suma_periodo > 0) {
            $calificacion_global = numberFormatPrecision(($calificacion_periodo / $suma_periodo), 1, '.');
        }

        return $calificacion_global;
    }

    public function detalle($idalumno = '')
    {
        Permission::grant(uri_string());
        $idalumno = $this->decode($idalumno);
        if (isset($idalumno) && !empty($idalumno)) {
            $kardex = $this->alumno->allKardex($idalumno);
            $detalle_alumno = $this->alumno->showAllAlumnoId($idalumno);

            $alumnos = $this->alumno->showAllAlumnosTutor($this->session->idtutor);
            $data = array(
                'kardex' => $kardex,
                'idalumno' => $idalumno,
                'promedio' => $this->calificacionFinal($idalumno),
                'detalle_alumno' => $detalle_alumno,
                'controller' => $this
            );
            $this->load->view('tutor/header');
            $this->load->view('tutor/alumnos/kardex', $data);
            $this->load->view('tutor/footer');
        } else {
            $data = array(
                'heading' => 'Error',
                'message' => 'Error intente mas tarde.'
            );
            $this->load->view('tutor/header');
            $this->load->view('tutor/error/general', $data);
            $this->load->view('tutor/footer');
        }
    }

    public function obtenerCalificacionAlumnoPorNivel($idhorario = '', $idalumno = '')
    {
        Permission::grant(uri_string());
        # code...
        $unidades = $this->grupo->unidades($this->session->idplantel);
        $materias = $this->alumno->showAllMaterias($idhorario);
        $total_unidad = 0;
        $total_materia = 0;
        $suma_calificacion = 0;
        $promedio = 0;

        $c = 1;
        if (isset($materias) && !empty($materias)) {

            foreach ($unidades as $block) :
                $total_unidad += 1;
            endforeach;

            foreach ($materias as $row) {
                $total_materia += 1;
                $idmateria = $row->idmateria;
                foreach ($unidades as $block) :
                    $val = $this->grupo->obtenerCalificacionValidandoMateria($idalumno, $block->idunidad, $idhorario, $idmateria);

                    if ($val != false) {
                        $suma_calificacion += $val->calificacion;
                    }
                endforeach;
            }
            $promedio = ($suma_calificacion / $total_unidad) / $total_materia;
        }

        return $promedio;
    }

    public function historial($idhorario = '', $idalumno = '', $idperiodo = '')
    {
        Permission::grant(uri_string());
        $idhorario = $this->decode($idhorario);
        $idalumno = $this->decode($idalumno);
        $idperiodo = $this->decode($idperiodo);
        if ((isset($idhorario) && !empty($idhorario)) && (isset($idalumno) && !empty($idalumno)) && (isset($idperiodo) && !empty($idperiodo))) {
            $datosalumno = $this->alumno->showAllAlumnoId($idalumno);
            $datoshorario = $this->horario->showNivelGrupo($idhorario);
            $unidades = $this->grupo->unidades($this->session->idplantel);
            $idnivelestudio = $datoshorario->idnivelestudio;
            $idniveleducativo = $datoshorario->idniveleducativo;
            $detalle_configuracion = $this->configuracion->showAllConfiguracion($this->session->idplantel, $idnivelestudio);
            if ($idniveleducativo == 1) {
                //PRIMARIA
                $tabla = $this->obtenerCalificacionPrimaria($idhorario, $idalumno);
            }
            if ($idniveleducativo == 4) {
                //PRIMARIA
                $tabla = $this->obtenerCalificacionPrimaria($idhorario, $idalumno);
            }
            if ($idniveleducativo == 2) {
                //SECUNDARIA
                $tabla = $this->obtenerCalificacionSecundaria($idhorario, $idalumno, $idperiodo);
            }
            if ($idniveleducativo == 3) {
                //PREPARATORIA
                $tabla = $this->obtenerCalificacionSecundaria($idhorario, $idalumno, $idperiodo);
            }
            if ($idniveleducativo == 5) {
                //PREPARATORIA
                $tabla = $this->obtenerCalificacionSecundaria($idhorario, $idalumno, $idperiodo);
            }
            //CODIGO PARA OBTENER LA CALIFICACION DEL NIVEL
            $materias = $this->alumno->showAllMateriasPasadas($idhorario, $idalumno, $idperiodo);
            $oportunidades_examen = $this->alumno->showAllOportunidadesExamen($this->session->idplantel);
            $total_materia = 0;
            $suma_calificacion = 0;
            foreach ($materias as $row) {
                $total_materia = $total_materia + 1;
                $idhorariodetalle = $row->idhorariodetalle;
                $calificacion = 0;
                foreach ($oportunidades_examen as $oportunidad) {
                    $idoportunidadexamen = $oportunidad->idoportunidadexamen;
                    $detalle_calificacion = $this->alumno->calificacionSecuPrepa($idalumno, $idhorariodetalle, $idoportunidadexamen);
                    if ($detalle_calificacion && $calificacion == 0) {
                        if ($detalle_calificacion[0]->calificacion >= $detalle_configuracion[0]->calificacion_minima) {
                            $calificacion .= $detalle_calificacion[0]->calificacion;
                            $suma_calificacion += $calificacion;
                        }
                    }
                }
            }
            $calificacion = 0;
            $calificacion = $suma_calificacion / $total_materia;
            //FIN DEL CODIGO PARA OBTENER LA CALIFICACION DEL NIVEL

            $data = array(
                'idhorario' => $idhorario,
                'idalumno' => $idalumno,
                'tabla' => $tabla,
                'datosalumno' => $datosalumno,
                'datoshorario' => $datoshorario,
                'calificacion' => $calificacion,
                'unidades' => $unidades,
                'controller' => $this,
            );
            $this->load->view('tutor/header');
            $this->load->view('tutor/alumnos/kardex_detalle', $data);
            $this->load->view('tutor/footer');
        } else {
            $data = array(
                'heading' => 'Error',
                'message' => 'Error intente mas tarde.',
            );
            $this->load->view('tutor/header');
            $this->load->view('tutor/error/general', $data);
            $this->load->view('tutor/footer');
        }
    }

    public function obtenerCalificacionSecundaria($idhorario = '', $idalumno = '', $idperiodo = '')
    {
        # code...
        Permission::grant(uri_string());
        $data = $this->alumno->obtenerNivelEducativoAlumno($idalumno);
        $unidades = $this->grupo->unidades($data->idplantel);
        $materias = $this->alumno->showAllMateriasPasadas($idhorario, $idalumno, $idperiodo);
        $datoshorario = $this->horario->showNivelGrupo($idhorario);
        $idnivelestudio = $datoshorario->idnivelestudio;
        $oportunidades_examen = $this->alumno->showAllOportunidadesExamen($data->idplantel);

        $detalle_configuracion = $this->configuracion->showAllConfiguracion($data->idplantel, $idnivelestudio);
        $total_unidades = 0;
        $total_materia = 0;
        if (isset($materias) && !empty($materias)) {
            foreach ($materias as $row) {
                # code...
                $total_materia = $total_materia + 1;
            }
        }
        $tabla = "";
        $tabla .= '<table class="table  table-striped  table-hover">
        <thead class="bg-teal">
             <th>NO.</th>
             <th>MATERIA</th>
             <th>CRÉDITO</th>';
        $tabla .= '<th>PROMEDIO</th>';
        $tabla .= '<th></th>';
        $tabla .= '</thead>';
        $c = 1;
        if (isset($materias) && !empty($materias)) {
            foreach ($materias as $row) {
                $idhorariodetalle = $row->idhorariodetalle;
                $calificacion = 0;
                foreach ($oportunidades_examen as $oportunidad) {
                    $idoportunidadexamen = $oportunidad->idoportunidadexamen;
                    $detalle_calificacion = $this->alumno->calificacionSecuPrepa($idalumno, $idhorariodetalle, $idoportunidadexamen);
                    if ($detalle_calificacion && $calificacion == 0) {
                        $calificacion .= $detalle_calificacion[0]->calificacion;
                    }
                }
                $tabla .= '<tr>';
                $tabla .= '<td>' . $c++ . '</td>';
                $tabla .= '<td>' . $row->nombreclase . '</td>';
                $tabla .= '<td>' . $row->credito . '</td>';
                $tabla .= '<td>';
                if ($detalle_configuracion[0]->calificacion_minima < $calificacion) {
                    $tabla .= '<label>' . number_format($calificacion, 2)  . '</label>';
                } else {
                    $tabla .= '<label style="color:red;">NA</label>';
                }

                $tabla .= '</td>';
                $tabla .= '<td>';
                if ($row->opcion == 0) {
                    $tabla .= '<label style="color:blue;">R</label>';
                }

                $tabla .= '</td>';
                $tabla .= '</tr>';
            }
        }
        $tabla .= '</table>';
        return $tabla;
    }

    public function generarHorarioPDF($idhorario = '', $idalumno = '')
    {
        if ((isset($idhorario) && !empty($idhorario)) && (isset($idalumno) && !empty($idalumno))) {

            $tabla = '
        <style type="text/css">
.txthorario{
   font-size:12px;
}
.txttutor{
   font-size:10px;
}
.txtdia{
  font-size:14px;
   font-weight: bold;
   background-color:#ccc;
}
  .tblhorario tr td
                {
                    border:0px solid black;
                }

</style>';

            $tabla .= '<table class="table table-hover table-striped"  > ';
            $tabla .= ' <thead class="bg-teal"> ';
            $tabla .= '<td   >Hora</td>';
            $tabla .= '<td   >Lunes</td>';
            $tabla .= '<td  >Martes</td>';
            $tabla .= '<td >Miercoles</td>';
            $tabla .= '<td  >Jueves</td>';
            $tabla .= '<td  >Viernes</td>';

            $tabla .= ' </thead>';
            $array_materias_reprobadas = array();
            $materias_reprobadas = $this->alumno->obtenerTodasMateriaReprobadasActivas($idalumno);
            if (isset($materias_reprobadas) && !empty($materias_reprobadas)) {
                foreach ($materias_reprobadas as $row) {
                    array_push($array_materias_reprobadas, $row->idmateriaprincipal);
                }
            }
            $reprobadas = implode(",", $array_materias_reprobadas);

            $lunesAll = $this->horario->showAllDiaHorarioSinDua($idhorario, $reprobadas);
            if (isset($lunesAll) && !empty($lunesAll)) {
                foreach ($lunesAll as $row) {
                    $tabla .= '<tr>';
                    $tabla .= '<td  ><strong>' . $row->hora . '</strong></td>';
                    $tabla .= '<td >' . $row->lunes . '</td>';
                    $tabla .= '<td  >' . $row->martes . '</td>';
                    $tabla .= '<td >' . $row->miercoles . '</td>';
                    $tabla .= '<td  >' . $row->jueves . '</td>';
                    $tabla .= '<td >' . $row->viernes . '</td>';

                    $tabla .= '</tr>';
                }
            } else {
                $tabla .= '<tr><td colspan="6">Sin Horario.</td></tr>';
            }
            $tabla .= '</table>';

            return $tabla;
        }
    }

    public function descargar($idhorario = '', $idalumno = '')
    {
        $idalumno = $this->decode($idalumno);
        $idhorario = $this->decode($idhorario);
        if ((isset($idhorario) && !empty($idhorario)) && (isset($idalumno) && !empty($idalumno))) {
            $detalle_logo = $this->alumno->logo($this->session->idplantel);
            $ubicacion_imagen = '/assets/images/escuelas/';
            $logo = base_url() . $ubicacion_imagen . $detalle_logo[0]->logoplantel;
            $logo2 = base_url() . $ubicacion_imagen . $detalle_logo[0]->logosegundo;

            $alumno = $this->alumno->detalleAlumno($idalumno);
            $grupo = $this->horario->showNivelGrupo($idhorario);
            $dias = $this->alumno->showAllDias();
            $datelle_alumno = $this->alumno->showAllMateriasAlumno($idalumno);
            if (isset($datelle_alumno) && !empty($datelle_alumno)) {
                $this->load->library('tcpdf');
                $hora = date("h:i:s a");
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
                $tabla = '
        <style type="text/css">
    .txtn{
        font-size:9px;
    }
    .direccion{
        font-size:8px;
    }
    .nombreplantel{
        font-size:10px;
        font-weight:bolder;
    }
    .telefono{
          font-size:8px;
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
    .titulo{
     font-family:Verdana, Geneva, sans-serif;
      font-size:8px;
    font-weight:bold;
    border-bottom:solid 1px #000000;
}
.result{
     font-family:Verdana, Geneva, sans-serif;
      font-size:8px;
    font-weight:bold;
}.nombreclase{
   font-size:12px;
   font-weight: bold;
}
.txthorario{
   font-size:8px;
}
.txttutor{
   font-size:10px;
}
.txtdia{
  font-size:8px;
   font-weight: bold;
   background-color:#ccc;
}
  .tblhorario tr td
                {
                    border:0px solid black;
                }

</style>
<div id="areimprimir">
          <table width="600" border="0" cellpadding="2" cellspacing="0">
  <tr>
    <td width="101" align="center"><img   class="imgtitle" src="' . $logo2 . '" /></td>
    <td colspan="2" align="center">
            <label class="nombreplantel">' . $datelle_alumno[0]->nombreplantel . '</label><br>
            <label class="txtn">' . $datelle_alumno[0]->asociado . '</label><br>
            <label class="direccion">' . $datelle_alumno[0]->direccion . '</label><br>
            <label class="telefono">TELÉFONO: ' . $datelle_alumno[0]->telefono . '</label>
    </td>
    <td width="137" align="center"><img   class="imgtitle" src="' . $logo . '" /></td>
  </tr>
    <tr>
    <td align="center"  style=""><label class="titulo">Matricula</label></td>
    <td align="center"  style=""><label class="titulo">Alumno</label></td>
    <td align="center"  style=""><label class="titulo">Nivel Escolar</label></td>
    <td align="center"  style=""><label class="titulo">Periodo Escolar</label></td>
  </tr>
  <tr>
    <td align="center"><label class="result">' . $alumno->matricula . '</label></td>
    <td align="center"><label class="result">' . $alumno->nombre . ' ' . $alumno->apellidop . ' ' . $alumno->apellidom . '</label></td>
    <td align="center"><label class="result">' . $grupo->nombrenivel . ' ' . $grupo->nombregrupo . '</label></td>
    <td align="center"><label class="result">' . $grupo->mesinicio . ' ' . $grupo->yearinicio . ' - ' . $grupo->mesfin . ' ' . $grupo->yearfin . '</label></td>
  </tr>
  </table> <br/><br/>';

                $tabla .= '<table class="tblhorario" width="600" cellpadding="2" > ';
                $tabla .= '<tr>';
                $tabla .= '<td width="65" align="center" class="txtdia">Hora</td>';
                $tabla .= '<td width="93" align="center" class="txtdia">Lunes</td>';
                $tabla .= '<td width="93" align="center" class="txtdia">Martes</td>';
                $tabla .= '<td width="93" align="center" class="txtdia">Miercoles</td>';
                $tabla .= '<td width="93" align="center" class="txtdia">Jueves</td>';
                $tabla .= '<td width="93" align="center" class="txtdia">Viernes</td>';

                $tabla .= '</tr>';
                $lunesAll = $this->horario->showAllDiaHorarioSinDua($idhorario);

                foreach ($lunesAll as $row) {
                    $tabla .= '<tr>';
                    $tabla .= '<td width="65" class="txthorario">' . $row->hora . '</td>';
                    $tabla .= '<td width="93" class="txthorario">' . $row->lunes . '</td>';
                    $tabla .= '<td  width="93"class="txthorario">' . $row->martes . '</td>';
                    $tabla .= '<td  width="93"class="txthorario">' . $row->miercoles . '</td>';
                    $tabla .= '<td width="93" class="txthorario">' . $row->jueves . '</td>';
                    $tabla .= '<td width="93" class="txthorario">' . $row->viernes . '</td>';

                    $tabla .= '</tr>';
                }
                $tabla .= '</table>';

                $pdf->writeHTML($tabla, true, false, false, false, '');

                ob_end_clean();

                $pdf->Output('Kardex de Calificaciones', 'I');
            } else {
                return "";
            }
        }
    }

    public function imprimirkardex($idhorario = '', $idalumno = '')
    {
        Permission::grant(uri_string());
        $alumno = $this->alumno->detalleAlumno($idalumno);
        $grupop = $this->horario->showNivelGrupo($idhorario);
        $unidades = $this->grupo->unidades($this->session->idplantel);
        $materias = $this->alumno->showAllMaterias($idhorario);
        $detalle_logo = $this->alumno->logo($this->session->idplantel);
        $logo = base_url() . '/assets/images/escuelas/' . $detalle_logo[0]->logoplantel;
        $logo2 = base_url() . '/assets/images/escuelas/' . $detalle_logo[0]->logosegundo;
        $total_unidades = 0;
        $calificacion = "";
        $materias = $this->alumno->showAllMaterias($idhorario);
        $total_materia = 0;
        if ($materias != false) {
            foreach ($materias as $row) {
                # code...
                $total_materia = $total_materia + 1;
            }
        }
        if ($unidades != false) {
            foreach ($unidades as $row) {
                # code...
                $total_unidades = $total_unidades + 1;
            }
        }
        $datoscalifiacacion = $this->horario->calificacionGeneralAlumno($idhorario, $idalumno);
        if ($datoscalifiacacion != false && $total_materia > 0) {
            $calificacion = ($datoscalifiacacion->calificaciongeneral / $total_unidades) / $total_materia;
        }

        $this->load->library('tcpdf');
        $hora = date("h:i:s a");

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
            <label class="nombreplantel">' . $datelle_alumno[0]->nombreplantel . '</label><br>
            <label class="txtn">INCORPORADA A LA UNIVERSIDAD DE GUANAJUATO SEGÚN EL OFICIO 14/ABRIL/1972</label><br>
            <label class="direccion">' . $datelle_alumno[0]->direccion . '</label><br>
            <label class="telefono">TELÉFONO: ' . $datelle_alumno[0]->telefono . ' EXT 1</label>
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
    <td align="center"><label class="result">' . $alumno->matricula . '</label></td>
    <td align="center"><label class="result">' . $alumno->nombre . ' ' . $alumno->apellidop . ' ' . $alumno->apellidom . '</label></td>
    <td align="center"><label class="result">' . $grupop->nombrenivel . ' ' . $grupop->nombregrupo . '</label></td>
    <td align="center"><label class="result">' . $grupop->mesinicio . ' - ' . $grupop->mesfin . ' ' . $grupop->yearfin . '</label></td>
  </tr>
</table>
<br><br>
 ';
        $tbl .= '<table class="tblcalificacion" cellpadding="2"  >
      <tr>
      <td width="30" class="titulocal">#</td>
      <td width="180" class="titulocal">MATERIA</td>';
        foreach ($unidades as $block) :
            $tbl .= '<td class="titulocal">' . $block->nombreunidad . '</td>';
        endforeach;

        $tbl .= '</tr>';
        $c = 1;
        foreach ($materias as $row) {
            $idmateria = $row->idmateria;
            $tbl .= '<tr>
        <td width="30" class="subtitulocal">' . $c++ . '</td>
        <td width="180" class="subtitulocal">' . $row->nombreclase . '</td>';
            foreach ($unidades as $block) :
                $val = $this->grupo->obtenerCalificacionValidandoMateria($idalumno, $block->idunidad, $idhorario, $idmateria);
                $tbl .= '<td class="subtitulocal">';
                if ($val != false) {
                    $tbl .= '<label>' . $val->calificacion . '</label>';
                } else {
                    $tbl .= '<label>No registrado</label>';
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
        if (isset($calificacion) && !empty($calificacion)) {
            $tbl .= numberFormatPrecision($calificacion, 1, '.');
        } else {
            $tbl .= '<label>0.0</label>';
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

    public function mensajes($idalumno = '', $idnivel = '', $idperiodo = '')
    {
        Permission::grant(uri_string());
        $idalumno = $this->decode($idalumno);
        if (isset($idalumno) && !empty($idalumno)) {
            $idhorario = '';
            $mensajes = '';
            $detalle = $this->alumno->showAllMateriasAlumno($idalumno);
            if ($detalle) {

                if (isset($detalle[0]->idhorario) && !empty($detalle[0]->idhorario)) {
                    $idhorario = $detalle[0]->idhorario;
                }
                $mensajes = $this->mensaje->showAllMensajeAlumno($idhorario);
            }
            $data = array(
                'mensajes' => $mensajes,
                'controller' => $this,
            );
            $this->load->view('tutor/header');
            $this->load->view('tutor/alumnos/mensajes', $data);
            $this->load->view('tutor/footer');
        } else {
            $data = array(
                'heading' => 'Error',
                'message' => 'Error intente mas tarde.',
            );
            $this->load->view('tutor/header');
            $this->load->view('tutor/error/general', $data);
            $this->load->view('tutor/footer');
        }
    }

    public function detallemensaje($idmensaje = '')
    {
        $idmensaje = $this->decode($idmensaje);
        if (isset($idmensaje) && !empty($idmensaje)) {
            $detalle_mensaje = $this->mensaje->detalleMensaje($idmensaje);
            //var_dump($detalle_tarea);
            $data = array(
                'mensaje' => $detalle_mensaje,
            );
            $this->load->view('tutor/header');
            $this->load->view('tutor/detalle/mensaje', $data);
            $this->load->view('tutor/footer');
        } else {
            $data = array(
                'heading' => 'Error',
                'message' => 'Error intente mas tarde.',
            );
            $this->load->view('tutor/header');
            $this->load->view('tutor/error/general', $data);
            $this->load->view('tutor/footer');
        }
    }


    public function obtenerCalificacionOportunidades($idhorario = '', $idalumno = '', $idoportunidad_acterior, $idoportunidad_actual)
    {
        # code...
        Permission::grant(uri_string());
        $idplantel = $this->session->idplantel;
        $datoshorario = $this->horario->showNivelGrupo($idhorario);
        $idnivelestudio = $datoshorario->idnivelestudio;

        $detalle_configuracion = $this->configuracion->showAllConfiguracion($this->session->idplantel, $idnivelestudio);
        $calificaciones = $this->alumno->calificacionPorOportunidad($idalumno, $idhorario, $idoportunidad_acterior);
        $tabla = "";
        $tabla .= '<table class="table  table-striped  table-hover">
        <thead class="bg-teal">
         <th>#</th>
        <th>MATERIA</th>';
        $tabla .= '<th>PROMEDIO</th>';
        $tabla .= '</thead>';
        $c = 1;

        foreach ($calificaciones as $row) {
            if ($row->calificacionmateria < $detalle_configuracion[0]->calificacion_minima) {
                $calificacion_alu = $this->alumno->calificacionPorOportunidad($idalumno, $idhorario, $idoportunidad_actual, $row->idmateria);

                $tabla .= '<tr>';
                $tabla .= '<td>' . $c++ . '</td>';
                $tabla .= '<td>' . $row->nombreclase . '</td>';
                if (isset($calificacion_alu) && !empty($calificacion_alu)) {
                    if ($calificacion_alu[0]->calificacionmateria < $detalle_configuracion[0]->calificacion_minima) {
                        $tabla .= '<td style="color:red;"><strong>' . numberFormatPrecision($calificacion_alu[0]->calificacionmateria, 1, '.') . '</strong></td>';
                    } else {
                        $tabla .= '<td style="color:green;"><strong>' . numberFormatPrecision($calificacion_alu[0]->calificacionmateria, 1, '.') . '</strong></td>';
                    }
                } else {
                    $tabla .= '<td>No registrado.</td>';
                }
                $tabla .= '</tr>';
            }
        }

        $tabla .= '</table>';
        return $tabla;
    }

    public function oportunidades($idalumno, $idhorario, $idopotunidad, $numero)
    {
        $idalumno = $this->decode($idalumno);
        $idhorario = $this->decode($idhorario);
        $idopotunidad = $this->decode($idopotunidad);
        $numero = $this->decode($numero);
        if ((isset($idhorario) && !empty($idhorario)) && (isset($idalumno) && !empty($idalumno)) && (isset($idopotunidad) && !empty($idopotunidad)) && (isset($numero) && !empty($numero))) {
            $idplantel = $this->session->idplantel;
            $detalle_oportunidad_anteriot = $this->grupo->obtenerOportunidadAnterior($numero, $idplantel);
            $idoportunidad_anterior = $detalle_oportunidad_anteriot->idoportunidadexamen;
            // $detalle_calificacion = $this->alumno->calificacionPorOportunidad($idalumno, $idhorario,$idoportunidad_anterior);
            $detalle_oportunidad = $this->grupo->detalleOportunidad($idopotunidad);
            $nombre_oportunidad = $detalle_oportunidad->nombreoportunidad;
            $data = array(
                'tabla' => $this->obtenerCalificacionOportunidades($idhorario, $idalumno, $idoportunidad_anterior, $idopotunidad),
                'nombreoportunidad' => $nombre_oportunidad,
            );
            $this->load->view('tutor/header');
            $this->load->view('tutor/alumnos/oportunidades', $data);
            $this->load->view('tutor/footer');
        } else {
            $data = array(
                'heading' => 'Error',
                'message' => 'Error intente mas tarde.',
            );
            $this->load->view('tutor/header');
            $this->load->view('tutor/error/general', $data);
            $this->load->view('tutor/footer');
        }
    }

    public function exito($idalumno_i = '', $idestasocuenta_i = '', $tipo_pago_i = '')
    {

        $idalumno = $this->decode($idalumno_i);
        $idestasocuenta = $this->decode($idestasocuenta_i);
        $tipo_pago = $this->decode($tipo_pago_i);
        if ((isset($idalumno) && !empty($idalumno)) && (isset($idestasocuenta) && !empty($idestasocuenta)) && (isset($tipo_pago) && !empty($tipo_pago))) {
            $detalle_alumno = $this->alumno->detalleAlumno($idalumno);
            $nombre_alumno = $detalle_alumno->nombre . " " . $detalle_alumno->apellidop . " " . $detalle_alumno->apellidom;
            $concepto = "";
            if ($tipo_pago == 11) {
                $detalle_estadocuenta = $this->estadocuenta->detalleAlumnoRecibo($idestasocuenta);
                $concepto .= "PAGO DE COLEGIATURA DEL MES DE " . $detalle_estadocuenta->nombremes;
            } else {
                $detalle_estadocuenta = $this->estadocuenta->detalleAlumnoPrimerRecibo($idestasocuenta);
                $concepto .= "PAGO DE COLEGIATURA DEL MES DE " . $detalle_estadocuenta->concepto;
            }
            $fecha_pago = $detalle_estadocuenta->fechapagocompleto;
            $date = date_create($fecha_pago);
            $fecha_pago = date_format($date, "d/m/Y H:i:s");
            $data = array(
                'numero_autorizacion' => $detalle_estadocuenta->autorizacion,
                'concepto' => $concepto,
                'total_pagado' => $detalle_estadocuenta->descuento,
                'alumno' => $nombre_alumno,
                'fecha' => $fecha_pago,
                'controller' => $this,
                'idestadocuenta' => $idestasocuenta,
                'idalumno' => $idalumno,
                'tipo' => $tipo_pago
            );
            $this->load->view('tutor/header');
            $this->load->view('tutor/alumnos/exito_pago', $data);
            $this->load->view('tutor/footer');
        } else {
            $data = array(
                'heading' => "Información",
                'message' => 'Error, intente mas tarde.'
            );
            $this->load->view('tutor/header');
            $this->load->view('tutor/error/general', $data);
            $this->load->view('tutor/footer');
        }
    }

    public function imprimir_recibo($idalumno_in = '', $idestadocuenta_in = '', $tipo_in = '')
    {
        $idalumno = $this->decode($idalumno_in);
        $idestasocuenta = $this->decode($idestadocuenta_in);
        $tipo_pago = $this->decode($tipo_in);
        if ((isset($idalumno) && !empty($idalumno)) && (isset($idestasocuenta) && !empty($idestasocuenta)) && (isset($tipo_pago) && !empty($tipo_pago))) {

            $concepto = "";
            $idperiodo = "";
            if ($tipo_pago == 11) {
                $detalle = $this->estadocuenta->detalleAlumnoRecibo($idestasocuenta);
                $concepto .= "MENSUALIDAD DE " . $detalle->nombremes;
                $idperiodo .= $detalle->idperiodo;
            } else {
                $detalle = $this->estadocuenta->detalleAlumnoPrimerRecibo($idestasocuenta);
                $concepto .= $detalle->concepto;
                $idperiodo .= $detalle->idperiodo;
            }
            $detalle_periodo = $this->estadocuenta->detallePeriodo($idperiodo);
            $detalle_grupo = $this->estadocuenta->grupoAlumno($idalumno, $idperiodo);
            $grupo = $detalle_grupo->nombrenivel . ' ' . $detalle_grupo->nombregrupo;
            $ciclo_escolar = $detalle_periodo->mesiniciol . ' A ' . $detalle_periodo->mesfinl . ' DE ' . $detalle_periodo->yearfin;
            $descuento = $detalle->descuento;
            $logo = base_url() . '/assets/images/escuelas/' . $detalle->logoplantel;
            $xcantidad = str_replace('.', '', $descuento);
            if (FALSE === ctype_digit($xcantidad)) {
                echo json_encode(array('leyenda' => 'La cantidad introducida no es válida.'));

                return;
            }
            $response = array(
                'leyenda' => num_to_letras($descuento), 'cantidad' => $descuento
            );
            $this->load->library('tcpdf');
            $fechaactual = date('d/m/Y');
            $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
            $pdf->SetTitle('Recibo de Pago.');
            $pdf->SetHeaderMargin(30);
            $pdf->SetTopMargin(10);
            $pdf->setFooterMargin(20);
            $pdf->SetAutoPageBreak(true);
            $pdf->SetAuthor('Sistema Integral para el Control Escolar');
            $pdf->SetDisplayMode('real', 'default');
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);

            $pdf->AddPage();

            $tbl = ' 
        <style>
          .txtgeneral{
            font-size:10px;
          }
          .txtdireccion{
             font-size:7px;
             cell-spacing:0;
          }
          .imgtitle{
        width:55px; 
    }
    .txtusuario{
       font-size:8px;
    }
    .txtcliclo{
      font-size:8px;
    }
    .txtplantel{
      font-size:11px;
      font-weight:bold;
    }
        </style>
        <table width="575" border="0">
  <tr>
    <td colspan="2" rowspan="3" nowrap="nowrap" width="94" valing="top" aling="center"><img    class="imgtitle" src="' . $logo . '" /></td>
    <td width="304" rowspan="3" nowrap="nowrap" align="center" valign="center">
    <label class="txtplantel">' . $detalle->nombreplantel . '</label><br>
    <label class="txtdireccion">' . $detalle->direccion . '</label><br>
    <label class="txtdireccion"> TELEFONO: ' . $detalle->telefono . '</label><br>
     <label class="txtdireccion"> CLAVE: ' . $detalle->clave . '</label>
 
    
    </td>
    <td width="70" nowrap="nowrap" class="txtgeneral"><strong>Fecha:</strong></td>
    <td width="73" nowrap="nowrap" class="txtgeneral">' . $detalle->fechapago . '</td>
  </tr>
  <tr>
    <td nowrap="nowrap" class="txtgeneral"><strong>Autorización:</strong></td>
    <td nowrap="nowrap" class="txtgeneral"><font color="red"><strong>' . $detalle->autorizacion . '</strong></font></td>
  </tr>
  <tr>
    <td nowrap="nowrap">&nbsp;</td>
    <td nowrap="nowrap">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" nowrap="nowrap" width="94">&nbsp;</td>
    <td colspan="2" align="center" nowrap="nowrap" width="304">&nbsp;</td>
    <td align="center" nowrap="nowrap" width="70" class="txtcliclo">GRUPO:</td>
    <td align="center" nowrap="nowrap" width="73" align="left" class="txtcliclo">&nbsp;' . $grupo . '</td>
  </tr>
    <tr>
    <td colspan="3" align="left" nowrap="nowrap" width="399" class="txtgeneral"><strong>Alumno(a):</strong> ' . $detalle->apellidop . ' ' . $detalle->apellidom . ' ' . $detalle->nombre . '</td>
    <td colspan="2" align="center" nowrap="nowrap" width="143" class="txtcliclo">' . $ciclo_escolar . '</td>
  </tr>
     <tr>
    <td align="center" nowrap="nowrap" width="94">&nbsp;</td>
    <td colspan="2" align="center" nowrap="nowrap" width="304">&nbsp;</td>
    <td align="center" nowrap="nowrap" width="70">&nbsp;</td>
    <td align="center" nowrap="nowrap" width="73">&nbsp;</td>
  </tr>
  <tr>
    <td width="94" align="center" nowrap="nowrap" class="txtgeneral" ><strong>Can</strong></td>
    <td colspan="2" align="left" nowrap="nowrap" width="304" class="txtgeneral"><strong>Concepto</strong></td>
    <td align="center" nowrap="nowrap" width="70" class="txtgeneral"><strong>Cantidad</strong></td>
    <td align="center" nowrap="nowrap" width="73" class="txtgeneral">&nbsp;</td>
  </tr>
  <tr>
    <td nowrap="nowrap" class="txtgeneral" align="center"style="border-top:solid 1px black;border-bottom:solid 1px black;">&nbsp;1</td>
    <td colspan="2" nowrap="nowrap" class="txtgeneral" style="border-top:solid 1px black;border-bottom:solid 1px black;">' . $concepto . '</td>
    <td nowrap="nowrap" class="txtgeneral" align="center" style="border-top:solid 1px black;border-bottom:solid 1px black;">$' . numberFormatPrecision($detalle->descuento, 1, '.') . '</td>
    <td nowrap="nowrap" class="txtgeneral" align="center" style="border-top:solid 1px black;border-bottom:solid 1px black;">&nbsp;</td>
  </tr>
  <tr>
    <td nowrap="nowrap">&nbsp;</td>
    <td colspan="2" nowrap="nowrap" class="txtgeneral"></td>
    <td nowrap="nowrap" class="txtgeneral" align="center"></td>
    <td nowrap="nowrap">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" nowrap="nowrap" class="txtgeneral"><strong>Forma de Pago:</strong> ' . $detalle->nombretipopago . '</td>
    <td nowrap="nowrap"  class="txtgeneral">Subtotal:</td>
    <td nowrap="nowrap" class="txtgeneral">$' . numberFormatPrecision($detalle->descuento, 1, '.') . '</td>
  </tr>
  <tr>
    <td nowrap="nowrap">&nbsp;</td>
    <td colspan="2" nowrap="nowrap">&nbsp;</td>
    <td nowrap="nowrap"  class="txtgeneral">Total:</td>
    <td nowrap="nowrap" class="txtgeneral"><strong>$' . numberFormatPrecision($detalle->descuento, 1, '.') . '</strong></td>
  </tr>
  <tr>
    <td colspan="3" nowrap="nowrap" class="txtgeneral"><strong>Cantidad con letra:</strong> ' . num_to_letras($descuento) . ' </td>
    <td nowrap="nowrap"  class="txtgeneral"></td>
    <td nowrap="nowrap">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" nowrap="nowrap">&nbsp;</td>
    <td nowrap="nowrap">&nbsp;</td>
    <td nowrap="nowrap">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" align="right" nowrap="nowrap" class="txtgeneral">Pagó en: <label class="txtusuario">EN LINEA</label></td>
    
  </tr>
</table>';

            $pdf->writeHTML($tbl, true, false, false, false, '');
            ob_end_clean();
            $pdf->Output('Kardex de Calificaciones', 'I');
        } else {
            $data = array(
                'heading' => "Información",
                'message' => 'Error, intente mas tarde.'
            );
            $this->load->view('tutor/header');
            $this->load->view('tutor/error/general', $data);
            $this->load->view('tutor/footer');
        }
    }

    public function calificacionPreescolar($idalumno = '', $idnivelestudio = '', $idperiodo = '')
    {

        $idalumno = $this->decode($idalumno);
        $idnivelestudio = $this->decode($idnivelestudio);
        $idperiodo = $this->decode($idperiodo);

        $tabla = $this->obtenerCalificacionPreescolar($idalumno, $idnivelestudio, $idperiodo);

        $data = array('tabla' => $tabla);

        $this->load->view('tutor/header');
        $this->load->view('tutor/alumnos/calificacion_preescolar', $data);
        $this->load->view('tutor/footer');
    }


    public  function  obtenerCalificacionPreescolar($idalumno = '', $idnivelestudio = '', $idperiodo = '')
    {

        //Obtener meses
        $meses = $this->alumno->obtenerMeses();
        $materias = $this->alumno->obtenerMaterias($idnivelestudio);


        $tabla = "";
        $tabla .= '<table id="tblcalificacionpreescolartutor" class="table table-striped dt-responsive nowrap" cellspacing="0" width="100%">
        <thead class="bg-teal">
        <th>ASIGNATURA</th>';
        foreach ($meses as $mes) {
            $tabla .= '<th>' . $mes->nombremes . '</th>';
        }

        $tabla .= '</thead>
        <tbody>';
        foreach ($materias as $materia) {
            $idmateria = $materia->idmateriapreescolar;

            if ($idmateria != 1 && $idmateria != 10 && $idmateria != 19 && $idmateria != 21) {

                $tabla .= '<tr>';
                $tabla .= '<td>' . $materia->nombremateria . '</td>';

                foreach ($meses as $mes) {
                    $idmes = $mes->idmes;

                    if ($idmateria == 26) {
                        $faltas = $this->alumno->obtenerFaltasPreescolar($idperiodo, $idalumno, $idmes);

                        if ($faltas) {

                            $tabla .= '<td>' . $faltas->faltas . '</td>';
                        } else {
                            $tabla .= '<td></td>';
                        }
                    } else {
                        $calificacion = $this->alumno->obtenerCalificacionPreescolar($idperiodo, $idalumno, $idmateria, $idmes);

                        if ($calificacion) {

                            $tabla .= '<td>' . $calificacion->abreviatura . '</td>';
                        } else {
                            $tabla .= '<td></td>';
                        }
                    }
                }
                $tabla .= '</tr>';
            }
        }

        $tabla .= '
        </tbody>
        </table>';

        return $tabla;
    }

    public function obtenerCalificacionLicenciatura($idhorario = '', $idalumno = '')
    {
        # code...
        Permission::grant(uri_string());
        $unidades = $this->grupo->unidades($this->session->idplantel);
        $array_materias_reprobadas = array();
        $materias_reprobadas = $this->alumno->obtenerTodasMateriaReprobadasActivas($idalumno);
        if (isset($materias_reprobadas) && !empty($materias_reprobadas)) {
            foreach ($materias_reprobadas as $row) {
                array_push($array_materias_reprobadas, $row->idmateriaprincipal);
            }
        }
        $reprobadas = implode(",", $array_materias_reprobadas);

        $materias = $this->alumno->showAllMaterias($idhorario, $reprobadas);
        $datoshorario = $this->horario->showNivelGrupo($idhorario);
        $idnivelestudio = $datoshorario->idnivelestudio;

        $detalle_configuracion = $this->configuracion->showAllConfiguracion($this->session->idplantel, $idnivelestudio);

        $total_materia = 0;
        if ($materias != false) {
            foreach ($materias as $row) {
                # code...
                $total_materia = $total_materia + 1;
            }
        }
        $tabla = "";
        $tabla .= '<table class="table  table-striped  table-hover">
        <thead class="bg-teal">
        <th>#</th>
        <th>MATERIA</th>';
        foreach ($unidades as $block) :

            $tabla .= '<th><strong>' . $block->nombreunidad . '</strong></th>';
        endforeach;
        $tabla .= '<th>PROMEDIO</th>';
        $tabla .= '</thead>';
        $c = 1;

        if (isset($materias) && !empty($materias)) {
            $suma_calificacion = 0;

            foreach ($materias as $row) {
                $total_unidades = $row->unidades;
                $idmateria = $row->idmateria;
                $suma_calificacion = 0;
                $tabla .= '<tr>
                <td>' . $c++ . '</td>
                <td>';
                if ($row->opcion == 0) {
                    $tabla .= '<label style="color:red;">R: </label>';
                }
                $tabla .= '<strong>' . $row->nombreclase . '</strong><br><small>( ' . $row->nombre . ' ' . $row->apellidop . ' ' . $row->apellidom . '</small>)</td>';
                foreach ($unidades as $block) {

                    $val = $this->grupo->obtenerCalificacionValidandoMateria($idalumno, $block->idunidad, $idhorario, $idmateria);

                    $tabla .= '<td>';
                    if ($val) {

                        $suma_calificacion = $suma_calificacion + $val->calificacion;
                        if (validar_calificacion($val->calificacion, $detalle_configuracion[0]->calificacion_minima)) {
                            $tabla .= '<label style="color:red;">' . $val->calificacion . '</label>';
                        } else {
                            $tabla .= '<label style="color:green;">' . $val->calificacion . '</label>';
                        }
                    } else {
                        $tabla .= '<small>No registrado</small>';
                    }
                    $tabla .= '</td>';
                }
                $tabla .= '<td>';
                if ($suma_calificacion > 0 && $total_unidades > 0) {
                    $calificacion_final = numberFormatPrecision($suma_calificacion / $total_unidades, 1, '.');
                    if (validar_calificacion($calificacion_final, $detalle_configuracion[0]->calificacion_minima)) {
                        if ($suma_calificacion > 0.0) {
                            $tabla .= '<label style="color:red;">' . numberFormatPrecision($suma_calificacion / $total_unidades, 1, '.') . '</label>';
                        } else {
                            $tabla .= '<label "> </label>';
                        }
                    } else {
                        $tabla .= '<label style="color:green;">' . numberFormatPrecision($suma_calificacion / $total_unidades, 1, '.') . '</label>';
                    }
                    $tabla .= '</td>';
                } else {
                    $tabla .= '<label "> </label>';
                }
                $tabla .= '</tr>';
            }
        }
        $tabla .= '</table>';
        return $tabla;
    }
}
