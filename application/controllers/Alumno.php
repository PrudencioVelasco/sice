<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("America/Mexico_City");
class Alumno extends CI_Controller {
 
  function __construct() {
        parent::__construct(); 
        if (!isset($_SESSION['user_id'])) {
            $this->session->set_flashdata('flash_data', 'You don\'t have access! ss');
            return redirect('welcome');
        }
        $this->load->helper('url');
        $this->load->model('alumno_model','alumno'); 
        $this->load->model('grupo_model','grupo'); 
        $this->load->model('horario_model','horario');
        $this->load->model('user_model','user');
        $this->load->model('cicloescolar_model','cicloescolar');  
        $this->load->model('data_model'); 
        $this->load->library('permission');
        $this->load->library('session');
        $this->load->library('pdfgenerator'); 
        $this->promedio_minimo = 7.00;
    }

	public function index()
	{
         Permission::grant(uri_string());
		$this->load->view('admin/header');
		$this->load->view('admin/alumno/index');
		$this->load->view('admin/footer');
	}
	  public function showAll() {
       // Permission::grant(uri_string()); 
        $idplantel = $this->session->idplantel;
        $query = $this->alumno->showAll();
        if ($query) {
            $result['alumnos'] = $this->alumno->showAll($idplantel);
        }
        if(isset($result) && !empty($result)){
        echo json_encode($result);
        }
    }
      public function showAllEspecialidades() {
       // Permission::grant(uri_string()); 
        $idplantel = $this->session->idplantel;
        $query = $this->alumno->showAllEspecialidades($idplantel);
        if ($query) {
            $result['especialidades'] = $this->alumno->showAllEspecialidades($idplantel);
        }
        if(isset($result) && !empty($result)){
        echo json_encode($result);
        }
    }
     public function showAllTutores($id) {
       // Permission::grant(uri_string()); 
        //$this->session->user_id,
        $query = $this->alumno->showAllTutores($id);
        if ($query) {
            $result['tutores'] = $this->alumno->showAllTutores($id);
        }
        echo json_encode($result);
    }
    public function showAllTutoresDisponibles() {
       // Permission::grant(uri_string()); 
        $query = $this->alumno->showAllTutoresDisponibles();
        if ($query) {
            $result['tutores'] = $this->alumno->showAllTutoresDisponibles();
        }
        if(isset($result) && !empty($result)){
        echo json_encode($result);
        }
    }

    public function addAlumno() {
        //Permission::grant(uri_string());
        $config = array(
             array(
                'field' => 'idespecialidad',
                'label' => 'Nombre',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),
             array(
                'field' => 'matricula',
                'label' => 'Nombre',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),
            array(
                'field' => 'nombre',
                'label' => 'Nombre',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),
             array(
                'field' => 'apellidop',
                'label' => 'A. Paterno',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ), 
              array(
                'field' => 'fechanacimiento',
                'label' => 'Fecha nacimiento',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ), 
            array(
                'field' => 'password',
                'label' => 'Contraseña',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            )
            , 
            array(
                'field' => 'sexo',
                'label' => 'Sexo',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            )
        );

        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            $result['error'] = true;
            $result['msg'] = array(
                'idespecialidad' => form_error('idespecialidad'),
                'nombre' => form_error('nombre'),
                'apellidop' => form_error('apellidop'), 
                'matricula' => form_error('matricula'),
                'fechanacimiento' => form_error('fechanacimiento'),
                'correo' => form_error('correo'),
                'password' => form_error('password'),
                'sexo' => form_error('sexo')
            );
        } else {

            $matricula =  trim($this->input->post('matricula'));
            $validar = $this->alumno->validarMatricula($matricula,$this->session->idplantel);
            if($validar == FALSE){
        	$data = array(
                    'idplantel'=> $this->session->idplantel,
                    'idespecialidad'=>  trim($this->input->post('idespecialidad')),
                    'matricula' => trim($this->input->post('matricula')),
                    'nombre' => strtoupper($this->input->post('nombre')),
                    'apellidop' => strtoupper($this->input->post('apellidop')),
                    'apellidom' => strtoupper($this->input->post('apellidom')),
                    'fechanacimiento' => $this->input->post('fechanacimiento'), 
                    'foto' => '', 
                    'sexo' => $this->input->post('sexo'), 
                    'correo' => $this->input->post('correo'),
                    'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                    'idusuario' => $this->session->user_id,
                    'fecharegistro' => date('Y-m-d H:i:s')
                     
                );
              $idalumno =  $this->alumno->addAlumno($data); 
              $datausuario     = array(
                'idusuario' => $idalumno,
                'idtipousuario' => 3, 
                'fecharegistro' => date('Y-m-d H:i:s')

            );
             $idusuario = $this->user->addUser($datausuario);
        }else{
             $result['error'] = true;
            $result['msg'] = array(
                'msgerror' => 'La Matricula ya esta registrado.'
            );
        	 
          } 
        }
        if(isset($result) && !empty($result)){
        echo json_encode($result);
        }
    	 
    }
     public function addTutorAlumno() {
        //Permission::grant(uri_string());
        $config = array(
             array(
                'field' => 'idtutor',
                'label' => 'Nombre',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            )  
        );

        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            $result['error'] = true;
            $result['msg'] = array(
                'idtutor' => form_error('idtutor')
            );
        } else {
            $data = array(
                    'idtutor' => $this->input->post('idtutor'),
                    'idalumno' => $this->input->post('idalumno')
                     
                );
            $this->alumno->addTutorAlumno($data);
              $result['error']   = false;
                $result['success'] = 'User updated successfully'; 
        }
         if(isset($result) && !empty($result)){
        echo json_encode($result);
    }
         
    }
     public function updateAlumno() {
        //Permission::grant(uri_string());
        $config = array(
             array(
                'field' => 'idespecialidad',
                'label' => 'Nombre',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),
              array(
                'field' => 'matricula',
                'label' => 'Nombre',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),
            array(
                'field' => 'nombre',
                'label' => 'Nombre',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),
             array(
                'field' => 'apellidop',
                'label' => 'A. Paterno',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),
             array(
                'field' => 'fechanacimiento',
                'label' => 'Fecha de nacimiento',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ) 

            
        );

        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            $result['error'] = true;
            $result['msg'] = array(
                'nombre' => form_error('nombre'),
                'apellidop' => form_error('apellidop'), 
                'matricula' => form_error('matricula'),
                'correo' => form_error('correo'),
                'fechanacimiento' => form_error('fechanacimiento'), 
            );
        } else {
            $idalumno = $this->input->post('idalumno');
            $matricula = trim($this->input->post('matricula'));
            $validar = $this->alumno->validarMatricula($matricula,$idalumno,$this->session->idplantel);
            if($validar == false){
            $data = array(
                    'idplantel'=> $this->session->idplantel,
                    'idespecialidad' => $this->input->post('idespecialidad'),
                    'matricula' => $this->input->post('matricula'),
                    'nombre' => strtoupper($this->input->post('nombre')),
                    'apellidop' => strtoupper($this->input->post('apellidop')),
                    'apellidom' => strtoupper($this->input->post('apellidom')), 
                    'fechanacimiento' => $this->input->post('fechanacimiento'),
                    'sexo' => $this->input->post('sexo'),  
                    'correo' => $this->input->post('correo'), 
                    'idusuario' => $this->session->user_id,
                    'fecharegistro' => date('Y-m-d H:i:s')
                     
                );
            $this->alumno->updateAlumno($idalumno,$data); 
            }else{
                  $result['error'] = true;
            $result['msg'] = array(
                'msgerror' => 'La Matricula ya esta registrado.'
            );
            }
            
        }
         if(isset($result) && !empty($result)){
        echo json_encode($result);
    }
         
    }
    public function searchAlumno() {
        //Permission::grant(uri_string());
        $value = $this->input->post('text');
        $query = $this->alumno->searchAlumno($value);
        if ($query) {
            $result['alumnos'] = $query;
        }
        if(isset($result) && !empty($result)){
        echo json_encode($result);
        }
    }
    public function searchTutor($idalumno) {
        //Permission::grant(uri_string());
        $value = $this->input->post('text');
        $query = $this->alumno->searchTutores($value,$idalumno);
        if ($query) {
            $result['tutores'] = $query;
        }
        if(isset($result) && !empty($result)){
        echo json_encode($result);
        }
    }
   

    public function imprimirkardex($idhorario='',$idalumno = '')
    {
        $alumno = $this->alumno->detalleAlumno($idalumno);
        $grupop = $this->horario->showNivelGrupo($idhorario);
        $unidades =  $this->grupo->unidades($this->session->idplantel);
        $materias = $this->alumno->showAllMaterias($idhorario);

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
      font-size:9px; 
    font-weight:bold;
}
.tblcalificacion  td 
                {
                    border:0px  solid black;
                }
tblcalificacion  {border-collapse:collapse}
.titulocal{
     font-family:Verdana, Geneva, sans-serif;
     font-weight:bolder;
     font-size:10px;
     background-color:#ccc;
}
.subtitulocal{
     font-family:Verdana, Geneva, sans-serif; 
     font-size:9px; 
}
</style>
 <table width="540" border="0" cellpadding="0" cellspacing="4">
  <tr>
    <td colspan="4" align="center"><label class="escuela">'.$alumno->nombreplantel.'</label></td> 
  </tr>
  <tr>
    <td colspan="4" align="center"><label class="horario">Kardex Escolar del Alumno</label></td> 
    </tr>
   <tr>
    <td align="center"  style="border-bottom:solid 1px #000000;"><label class="titulo">Matricula</label></td>
    <td align="center"  style="border-bottom:solid 1px #000000;"><label class="titulo">Alumno</label></td>
    <td align="center"  style="border-bottom:solid 1px #000000;"><label class="titulo">Nivel Escolar</label></td>
    <td align="center"  style="border-bottom:solid 1px #000000;"><label class="titulo">Periodo Escolar</label></td>
  </tr>
  <tr>
    <td align="center"><label class="result">'.$alumno->matricula.'</label></td>
    <td align="center"><label class="result">'.$alumno->nombre.' '.$alumno->apellidop.' '.$alumno->apellidom.'</label></td>
    <td align="center"><label class="result">'.$grupop->nombrenivel.' '.$grupop->nombregrupo.'</label></td>
    <td align="center"><label class="result">'.$grupop->mesinicio.' '.$grupop->yearinicio.' - '.$grupop->mesfin.' '.$grupop->yearfin.'</label></td>
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
            <td align="right" class="" >
                Promedio: <strong>'.number_format($calificacion,2).'</strong>
            </td>
        </tr>
      </table>
      ';

        $pdf->writeHTML($tbl, true, false, false, false, '');

    ob_end_clean();


        $pdf->Output('My-File-Name.pdf', 'I');

    }
 
    public function detalle($id)
    { 
        $kardex = $this->alumno->allKardex($id);  
        $cicloescolar_activo = $this->cicloescolar->showAllCicloEscolarActivo($this->session->idplantel);
        $grupo_actual="";
        $valida_grupo = $this->alumno->validadAlumnoGrupo($id);
        if($valida_grupo){
            $datag = $this->alumno->detalleGrupoActual($id);
            $grupo_actual =$datag->nombrenivel." ".$datag->nombregrupo." - ".$datag->nombreturno;
        }
//var_dump($kardex);
        //Codigo para obtener la caficacion Final
         $calificacion_final = 0;
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
                    $datoscalifiacacion = $this->horario->calificacionGeneralAlumno($idhorario,$id);
                     if($datoscalifiacacion != FALSE && $total_materia > 0){
                          $suma_calificacion= ($datoscalifiacacion->calificaciongeneral / $total_unidad) / $total_materia;
                         }
                        // echo $suma_calificacion;

            }
           $calificacion_final = $suma_calificacion / $total_periodo;
        }
        

    	$data = array(
    		'id'=>$id,
    		'detalle'=>$this->alumno->detalleAlumno($id),
            'nivelestudio'=>$this->alumno->nivelEstudio($id),
            'validargrupo'=>$this->alumno->validadAlumnoGrupo($id),
            'grupos'=>$this->alumno->showAllGrupos($this->session->idplantel),
            'grupoactual'=>$grupo_actual,
            'promediogeneral' =>$calificacion_final,
            'kardex'=>$kardex,
            'cicloescolar'=>$cicloescolar_activo

    	);
    	$this->load->view('admin/header');
		$this->load->view('admin/alumno/detalle',$data);
		$this->load->view('admin/footer');
    }

    public function horario($idhorario,$idalumno)
    {
        # code...
        //$tabla = $this->obtenerCalificacion($idhorario);
        $data = array(
            'idhorario'=>$idhorario,
            'idalumno'=>$idalumno
        ); 
        $this->load->view('admin/header');
        $this->load->view('admin/alumno/horario',$data);
        $this->load->view('admin/footer');
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

    public function historial($idhorario = '',$idalumno = '')
    {
        if((isset($idhorario) && !empty($idhorario)) && (isset($idalumno) && !empty($idalumno))){
        $calificacion = "";
        $tabla = $this->obtenerCalificacion($idhorario,$idalumno);
        $datosalumno = $this->alumno->showAllAlumnoId($idalumno);
        $datoshorario = $this->horario->showNivelGrupo($idhorario);
        $materias = $this->alumno->showAllMaterias($idhorario);
        $unidades =  $this->grupo->unidades($this->session->idplantel);
        $total_materia = 0;
        if ($materias != FALSE) { 
            foreach ($materias as $row) {
                # code...
                $total_materia = $total_materia + 1;
            }
        } 
        $datoscalifiacacion = $this->horario->calificacionGeneralAlumno($idhorario,$idalumno);
         if($datoscalifiacacion != FALSE && $total_materia > 0){
            $calificacion= $datoscalifiacacion->calificaciongeneral / $total_materia;
         }
        # code...
       // printf($tabla);

          $data = array(
            'idhorario'=>$idhorario,
            'idalumno'=>$idalumno,
            'tabla'=>$tabla,
            'datosalumno'=>$datosalumno,
            'datoshorario'=>$datoshorario,
            'calificacion'=>$calificacion,
            'unidades'=>$unidades
        );
        $this->load->view('admin/header');
        $this->load->view('admin/alumno/kardex',$data);
        $this->load->view('admin/footer');
    }else{
        $data = array(
            'heading'=>'Error',
            'message'=>'Error intente mas tarde.'
        );
         $this->load->view('errors/html/error_general',$data);
    }

    }

    public function deleteTutor($id)
    {
        # code...
        $eliminar = $this->alumno->deleteTutor($id);
    }

    public function asignarGrupo()
    {
              $config = array(
            array(
                'field' => 'idcicloescolar',
                'label' => 'Ciclo Escolar',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Seleccione el Ciclo Escolar.'
                )
            ),
            array(
                'field' => 'idgrupo',
                'label' => 'Seleccionar el Grupo.',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Seleccionar el Grupo.'
                )
            ) 
        );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            $errors = validation_errors();
        echo json_encode(['error'=>$errors]);
        } else {
            $data = array( 
                    'idalumno' => $this->input->post('idalumno'),
                    'idperiodo' => $this->input->post('idcicloescolar'),
                    'idgrupo' => $this->input->post('idgrupo'), 
                    'activo'=>1,
                    'idusuario' => $this->session->user_id,
                    'fecharegistro' => date('Y-m-d H:i:s')
                     
                );
            $value = $this->alumno->asignarGrupo($data); 
            if($value){
                echo json_encode(['success'=>'Ok']);
             }else{
                echo json_encode(['error'=>'Error... Intente mas tarde.']);
             }

    }
    }

    public function actualizarFoto()
    {
            $mi_archivo = 'avatar_file';
            $config['upload_path'] = "assets/alumnos/";
            //$config['file_name'] = 'Avatar' . date("Y-m-d his");
            //$config['allowed_types'] = "*";
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size'] = "50000";
            $config['max_width'] = "2000";
            $config['max_height'] = "2000";
            $file_name = $_FILES['avatar_file']['name'];
            $tmp = explode('.', $file_name);
            $extension_img = end($tmp);
            $user_img_profile = date("Y-m-dhis") . '.' . $extension_img;
            $config['file_name'] = $user_img_profile;

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload($mi_archivo)) {
                //*** ocurrio un error
                $data['state'] = 500;
                $data['message'] = $this->upload->display_errors();
                //echo $this->upload->display_errors();
                echo json_encode($data);
                return;
            }
            $idalumno =  $this->input->post('idalumno');
            $data = array(
                'foto'=>$user_img_profile
            );
            $this->alumno->updateAlumno($idalumno,$data);
            $return =  array(
                'state'=>200);

          echo json_encode($return);

            

    }

    public function generarHorarioPDF($idhorario = '',$idalumno='')
    {
        if((isset($idhorario) && !empty($idhorario)) && (isset($idalumno) && !empty($idalumno)) ){
 
        $lunes = $this->horario->showAllDiaHorario($idhorario,1);
        $martes = $this->horario->showAllDiaHorario($idhorario,2);
        $miercoles = $this->horario->showAllDiaHorario($idhorario,3);
        $jueves = $this->horario->showAllDiaHorario($idhorario,4);
        $viernes = $this->horario->showAllDiaHorario($idhorario,5);
        $alumno = $this->alumno->detalleAlumno($idalumno);
        $grupo = $this->horario->showNivelGrupo($idhorario);
        $this->load->library('tcpdf');  
        $hora = date("h:i:s a");
        //$linkimge = base_url() . '/assets/images/woorilogo.png';
        $fechaactual = date('d/m/Y');
         

        $tbl = '
        <!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style type="text/css">
.titulodias{font-size:9px; font-weight:bold;}
.cajon{
     font-family:Verdana, Geneva, sans-serif;
    font-size:9px; 
    font-weight:bold;  
    border-bottom:solid 1px black;  
    border-left:solid 1px black;
     border-right:solid 1px black;  
      padding:900px 20px 20px 20px;
}  
.escuela{
     font-family:Verdana, Geneva, sans-serif;
      font-size:12px; 
    font-weight:bold;
}
.horario{
     font-family:Verdana, Geneva, sans-serif;
      font-size:10px; 
    font-weight:bold;
}
.titulo{
     font-family:Verdana, Geneva, sans-serif;
      font-size:8px; 
    font-weight:bold;
}
.result{
     font-family:Verdana, Geneva, sans-serif;
      font-size:9px; 
    font-weight:bold;
}
.dl{ 
     font-family:Verdana, Geneva, sans-serif;
    width:142px;
    display:inline-block;
    *display:inline;
    vertical-align:top;
    margin-right:-4px;

}
.dia{
    font-family:Verdana, Geneva, sans-serif;
    border:solid 1px #ccc;
     font-size:8px;
     height:38px;
     vertical-align:top; 
     padding: 5px 5px 5px 5px;
     margin:0;
}
.diasemana{
      font-family:Verdana, Geneva, sans-serif;
    border:solid 1px #ccc;
     font-size:10px;
     height:20px;
     background-color:#ccc;
     padding: 5px 5px 0px 5px;
     font-weight:bolder;
}
.hora{
     font-family:Verdana, Geneva, sans-serif;
     font-size:8px;
     font-weight:bolder;
}
</style>

<title>Title</title>
</head>
<body>
<table width="540" border="0" cellpadding="1" cellspacing="4">
  <tr>
    <td colspan="4" align="center"><label class="escuela">'.$alumno->nombreplantel.'</label></td> 
  </tr>
  <tr>
    <td colspan="4" align="center"><label class="horario">Horario del Alumno</label></td> 
    </tr>
   <tr>
    <td align="center"  style="border-bottom:solid 1px #000000;"><label class="titulo">Matricula</label></td>
    <td align="center"  style="border-bottom:solid 1px #000000;"><label class="titulo">Alumno</label></td>
    <td align="center"  style="border-bottom:solid 1px #000000;"><label class="titulo">Nivel Escolar</label></td>
    <td align="center"  style="border-bottom:solid 1px #000000;"><label class="titulo">Periodo Escolar</label></td>
  </tr>
  <tr>
    <td align="center"><label class="result">'.$alumno->matricula.'</label></td>
    <td align="center"><label class="result">'.$alumno->nombre.' '.$alumno->apellidop.' '.$alumno->apellidom.'</label></td>
    <td align="center"><label class="result">'.$grupo->nombrenivel.' '.$grupo->nombregrupo.'</label></td>
    <td align="center"><label class="result">'.$grupo->mesinicio.' '.$grupo->yearinicio.' - '.$grupo->mesfin.' '.$grupo->yearfin.'</label></td>
  </tr> 
</table>
<br>
<div class = "dl">
<div class="diasemana"><label>LUNES</label></div>
    ';
    if(isset($lunes) && !empty($lunes)){
    foreach($lunes as $row){
              if(strtoupper($row->opcion) == "NORMAL"){ 
                 $tbl.='<div class="dia"><label> '.$row->nombreclase.'</label><br> <small class = "hora">('.$row->horainicial.' - '.$row->horafinal.')</small>
              <br>
              <small class = "hora">'.$row->nombre.' '.$row->apellidop.' '.$row->apellidom.'</small></div>';
              
            
            }
            if(strtoupper($row->opcion) == "DESCANSO"){
              $tbl.='<div class="dia"><label> '.$row->nombreclase.'</label><br> <small class = "hora">('.$row->horainicial.' - '.$row->horafinal.')</small></div>';
            }
             if(strtoupper($row->opcion) == "SIN CLASES"){
              $tbl.='<div class="dia"><label>SIN CLASES</label><br> <small class = "hora">('.$row->horainicial.' - '.$row->horafinal.')</small></div>';
            }
        }
        } 
    $tbl .='
</div>
<div class = "dl">
<div class="diasemana"><label>MARTES</label></div>
     ';
     if(isset($martes) && !empty($martes)){
    foreach($martes as $row){
            if(strtoupper($row->opcion) == "NORMAL"){ 
                 $tbl.='<div class="dia"><label> '.$row->nombreclase.'</label><br> <small class = "hora">('.$row->horainicial.' - '.$row->horafinal.')</small>
              <br>
              <small class = "hora">'.$row->nombre.' '.$row->apellidop.' '.$row->apellidom.'</small></div>';
              
            
            }
            if(strtoupper($row->opcion) == "DESCANSO"){
              $tbl.='<div class="dia"><label> '.$row->nombreclase.'</label><br> <small class = "hora">('.$row->horainicial.' - '.$row->horafinal.')</small></div>';
            }
             if(strtoupper($row->opcion) == "SIN CLASES"){
              $tbl.='<div class="dia"><label>SIN CLASES</label><br> <small class = "hora">('.$row->horainicial.' - '.$row->horafinal.')</small></div>';
            }
        } 
    }
    $tbl .='
</div> 
<div class = "dl">
<div class="diasemana"><label>MIERCOLES</label></div>
   ';
   if(isset($miercoles) && !empty($miercoles)){
    foreach($miercoles as $row){
            if(strtoupper($row->opcion) == "NORMAL"){ 
                 $tbl.='<div class="dia"><label> '.$row->nombreclase.'</label><br> <small class = "hora">('.$row->horainicial.' - '.$row->horafinal.')</small>
              <br>
              <small class = "hora">'.$row->nombre.' '.$row->apellidop.' '.$row->apellidom.'</small></div>';
              
            
            }
            if(strtoupper($row->opcion) == "DESCANSO"){
              $tbl.='<div class="dia"><label> '.$row->nombreclase.'</label><br> <small class = "hora">('.$row->horainicial.' - '.$row->horafinal.')</small></div>';
            }
             if(strtoupper($row->opcion) == "SIN CLASES"){
              $tbl.='<div class="dia"><label>SIN CLASES</label><br> <small class = "hora">('.$row->horainicial.' - '.$row->horafinal.')</small></div>';
            }
        }
    }
    $tbl .='
</div> 
<div class = "dl">
<div class="diasemana"><label>JUEVES</label></div>
     ';
     if(isset($jueves) && !empty($jueves)){
    foreach($jueves as $row){
          if(strtoupper($row->opcion) == "NORMAL"){ 
                 $tbl.='<div class="dia"><label> '.$row->nombreclase.'</label><br> <small class = "hora">('.$row->horainicial.' - '.$row->horafinal.')</small>
              <br>
              <small class = "hora">'.$row->nombre.' '.$row->apellidop.' '.$row->apellidom.'</small></div>';
              
            
            }
            if(strtoupper($row->opcion) == "DESCANSO"){
              $tbl.='<div class="dia"><label> '.$row->nombreclase.'</label><br> <small class = "hora">('.$row->horainicial.' - '.$row->horafinal.')</small></div>';
            }
             if(strtoupper($row->opcion) == "SIN CLASES"){
              $tbl.='<div class="dia"><label>SIN CLASES</label><br> <small class = "hora">('.$row->horainicial.' - '.$row->horafinal.')</small></div>';
            }
        } 
    }
    $tbl .='
</div> 
<div class = "dl">
<div class="diasemana"><label>VIERNES</label></div>
    ';
    if(isset($viernes) && !empty($viernes)){
    foreach($viernes as $row){
             if(strtoupper($row->opcion) == "NORMAL"){ 
                 $tbl.='<div class="dia"><label> '.$row->nombreclase.'</label><br> <small class = "hora">('.$row->horainicial.' - '.$row->horafinal.')</small>
              <br>
              <small class = "hora">'.$row->nombre.' '.$row->apellidop.' '.$row->apellidom.'</small></div>';
              
            
            }
            if(strtoupper($row->opcion) == "DESCANSO"){
              $tbl.='<div class="dia"><label> '.$row->nombreclase.'</label><br> <small class = "hora">('.$row->horainicial.' - '.$row->horafinal.')</small></div>';
            }
             if(strtoupper($row->opcion) == "SIN CLASES"){
              $tbl.='<div class="dia"><label>SIN CLASES</label><br> <small class = "hora">('.$row->horainicial.' - '.$row->horafinal.')</small></div>';
            }
        } 
    }
    $tbl .='
</div> 
</body>
</html>
';
 $this->load->library('pdfgenerator');
$this->dompdf->loadHtml($tbl);
$this->dompdf->setPaper('A4');
$this->dompdf->render();
$this->dompdf->stream("Horario Escolar.pdf", array("Attachment"=>0));
        }else{
             $data = array(
            'heading'=>'Notificación',
            'message'=>'El Alumno(a) no tiene registrado Horario.'
        );
         $this->load->view('errors/html/error_general',$data);
        }
        
        }
    public function updatePasswordAlumno()
    {
        # code...
              $config = array(
             array(
                'field' => 'password1',
                'label' => 'Nombre',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),
            array(
                'field' => 'password2',
                'label' => 'Nombre',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            )
        );

        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            $result['error'] = true;
            $result['msg'] = array(
                'password1' => form_error('password1'),
                'password2' => form_error('password2')
            );
        } else {
            if($this->input->post('password1') == $this->input->post('password2')){
            $id = $this->input->post('idalumno'); 
            $password_encrypted = password_hash(trim($this->input->post('password1')), PASSWORD_BCRYPT);
            
            $data = array(
                    'password' => $password_encrypted, 
                    'idusuario' => $this->session->user_id,
                    'fecharegistro' => date('Y-m-d H:i:s')
                     
                );
            $this->alumno->updateAlumno($id,$data); 
        }else{
             $result['error'] = true;
                    $result['msg'] = array(
                           'msgerror' => "La Contraseña no coinciden."
                    );
        }
        }
         if(isset($result) && !empty($result)){
        echo json_encode($result);
        }
    }

   public function obetnerAsistencia($idhorario = '',$fechai = '',$fechaf = '',$idalumno = '',$motivo= '')
    { 
        
        // $alumns = $this->grupo->alumnosGrupo($idhorario);
         
         $materias = $this->alumno->showAllMaterias($idhorario);
         $tabla = ""; 
         

         if($materias != false){
        $range= ((strtotime($fechaf)-strtotime($fechai))+(24*60*60)) /(24*60*60);
        //$range= ((strtotime($_GET["finish_at"])-strtotime($_GET["start_at"]))+(24*60*60)) /(24*60*60);
        
        $tabla .= '<table class="table">
            <thead>
            <th>#</th>
            <th>Nombre</th>';
            for($i=0;$i<$range;$i++):
           $tabla .= '<th>'.date("D d-M",strtotime($fechai)+($i*(24*60*60))).'</th>';
           //echo date("d-M",strtotime($_GET["start_at"])+($i*(24*60*60)));
           endfor;
           $tabla .= '</thead>';
            $n = 1;
            foreach($materias as $row){  
               $tabla .= ' <tr>';
               $tabla .='<td>'.$n++.'</td>';
                $tabla .= '<td >'.$row->nombreclase.'</td>';
             for($i=0;$i<$range;$i++):
                    $date_at= date("Y-m-d",strtotime($fechai)+($i*(24*60*60)));
                   // $asist = AssistanceData::getByATD($alumn->id,$_GET["team_id"],$date_at);
                    $asist = $this->grupo->listaAsistenciaGeneral($idalumno,$idhorario,$date_at,$row->idhorariodetalle,$motivo);
                        


                $tabla .= '<td>';
                 if($asist != false){ 
                      switch ($asist->idmotivo) {
                          case 1:
                              # code...
                             $tabla .='<span class="label label-success">'.$asist->nombremotivo.'</span>';
                              break;
                                  case 2:
                                  $tabla .='<span class="label label-warning">'.$asist->nombremotivo.'</span>';
                              # code...
                              break;
                                  case 3:
                                  $tabla .='<span class="label label-info">'.$asist->nombremotivo.'</span>';
                              # code...
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
                    $tabla .="No registrado.";
                 }
                   
                $tabla .= '</td>';
             endfor; 
                $tabla .= '</tr>';
                

            }
$tabla .= '</table>';
}
return $tabla;

    }
     public function asistencia($idhorario='', $idalumno = '')
  {
        $materias = $this->alumno->showAllMaterias($idhorario);
         $tipoasistencia = $this->alumno->showAllTipoAsistencia(); 
        $data = array(
            'materias'=>$materias,
            'idhorario'=>$idhorario,
            'idalumno'=>$idalumno,
            'tipoasistencia'=>$tipoasistencia
        );
        $this->load->view('admin/header');
        $this->load->view('admin/alumno/asistencia',$data);
        $this->load->view('admin/footer');
  }

  public function buscarAsistencia()
  { 
           
            $materias = $this->input->post('materias');
            $idhorario = $this->input->post('idhorario');
            $idalumno = $this->input->post('idalumno');
            $fechainicio = $this->input->post('fechainicio');
            $fechafin = $this->input->post('fechafin');
            $motivo = $this->input->post('motivo'); 
             foreach ($materias as $key ) {
                 # code...
               // echo $key;
                if($key == 2804){
                    $tabla = $this->obetnerAsistencia($idhorario,$fechainicio,$fechafin,$idalumno,$motivo);
                    echo $tabla;
                }else{

                }
             } 
         

  }
  public function deleteAlumno()
  {
        $idalumno = $this->input->get('idalumno');
        $query = $this->alumno->deleteAlumno($idalumno);
        if ($query) {
            $result['alumnos'] = true;
        } 
       if(isset($result) && !empty($result)){
         echo json_encode($result);
        }
  }

  public function boleta($idhorario='',$idalumno = '',$idunidad = '')
  {
      $logo = base_url() . '/assets/images/escuelas/logo.jpeg';
       $logo2 = base_url() . '/assets/images/escuelas/ugto.png';
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
                     $tbl .= '<label style="color:red;">'.$calificacion->calificacion.'<label>';
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
  }
}
