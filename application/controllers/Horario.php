<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("America/Mexico_City");
class Horario extends CI_Controller {
 
  function __construct() {
        parent::__construct(); 
        if (!isset($_SESSION['user_id'])) {
            $this->session->set_flashdata('flash_data', 'You don\'t have access! ss');
            return redirect('welcome');
        }
        $this->load->helper('url');
        $this->load->model('horario_model','horario');  
        $this->load->model('data_model'); 
        $this->load->library('permission');
        $this->load->library('session');
    }

	public function index()
	{
     Permission::grant(uri_string());
		$this->load->view('admin/header');
		$this->load->view('admin/horario/index');
		$this->load->view('admin/footer');
	}
    public function searchHorario() {
        //Permission::grant(uri_string());
      $idplantel = $this->session->idplantel;
        $value = $this->input->post('text');
        $query = $this->horario->searchHorario($value,$idplantel);
        if ($query) {
            $result['horarios'] = $query;
        }
       if(isset($result) && !empty($result)){
         echo json_encode($result);
        }
    }

    public function showAll() {
        // Permission::grant(uri_string()); 
         $query = $this->horario->showAll($this->session->idplantel);
         //var_dump($query);
         if ($query) {
             $result['horarios'] = $this->horario->showAll($this->session->idplantel);
         }
        if(isset($result) && !empty($result)){
         echo json_encode($result);
        }
     }

     public function detalle($id)
     {
         # code...
        $activo_horario = 0;
        $activo_ciclo_escolar = 0;
        if($this->horario->validarActivoHorario($id)){
          $activo_horario = 1;
        }
        if($this->horario->validarActivoCicloEscolar($id)){
          $activo_ciclo_escolar = 1;
        }

        $data = array(
            'id'=>$id,
            'activo_horario'=>$activo_horario,
            'activo_ciclo_escolar'=>$activo_ciclo_escolar
        );
        $this->load->view('admin/header');
        $this->load->view('admin/horario/detalle',$data);
        $this->load->view('admin/footer');
     }
      public function showAllDiaHorario($idhorario,$iddia) {
        // Permission::grant(uri_string()); 
         $query = $this->horario->showAllDiaHorario($idhorario,$iddia);
         //var_dump($query);
         if ($query) {
             $result['horarios'] = $this->horario->showAllDiaHorario($idhorario,$iddia);
         }
        if(isset($result) && !empty($result)){
         echo json_encode($result);
        }
     }
     public function showAllDias() {
        // Permission::grant(uri_string()); 
         $query = $this->horario->showAllDias();
         //var_dump($query);
         if ($query) {
             $result['dias'] = $this->horario->showAllDias();
         }
        if(isset($result) && !empty($result)){
         echo json_encode($result);
        }
     }
     public function showAllPeriodos() { 
         $query = $this->horario->showAllPeriodos($this->session->idplantel); 
         if ($query) {
             $result['periodos'] = $this->horario->showAllPeriodos($this->session->idplantel);
         }
         if(isset($result) && !empty($result)){
         echo json_encode($result);
        }
     }
      public function showAllGrupos() { 
         $query = $this->horario->showAllGrupos($this->session->idplantel); 
         if ($query) {
             $result['grupos'] = $this->horario->showAllGrupos($this->session->idplantel);
         }
        if(isset($result) && !empty($result)){
         echo json_encode($result);
        }
     }

public function showAllMaterias() {
        // Permission::grant(uri_string()); 
         $query = $this->horario->showAllMaterias($this->session->idplantel);
         //var_dump($query);
         if ($query) {
             $result['materias'] = $this->horario->showAllMaterias($this->session->idplantel);
         }
       if(isset($result) && !empty($result)){
         echo json_encode($result);
        }
     }
  public function addMateriaHorario() {
        //Permission::grant(uri_string());
        $config = array(
             array(
                'field' => 'idmateria',
                'label' => 'Materia',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),
            array(
                'field' => 'iddia',
                'label' => 'Dia',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),
             array(
                'field' => 'horainicial',
                'label' => 'Hora inicial',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),
            array(
                'field' => 'horafinal',
                'label' => 'Hora final',
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
                'idmateria' => form_error('idmateria'),
                'iddia' => form_error('iddia'),
                'horainicial' => form_error('horainicial'),
                'horafinal' => form_error('horafinal')
            );
        } else {

            $data = array(
                    'idhorario' => $this->input->post('idhorario'),
                    'idmateria' => strtoupper($this->input->post('idmateria')),
                    'iddia' => strtoupper($this->input->post('iddia')),
                    'horainicial' => strtoupper($this->input->post('horainicial')), 
                    'horafinal' => $this->input->post('horafinal') 
                     
                );
            $this->horario->addMateriaHorario($data); 
        }
         
       if(isset($result) && !empty($result)){
         echo json_encode($result);
        }
         
    }
      public function addReceso() {
        //Permission::grant(uri_string());
        $config = array(
             array(
                'field' => 'titulo',
                'label' => 'Titulo',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),
             array(
                'field' => 'horainicial',
                'label' => 'Hora inicial',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),
            array(
                'field' => 'horafinal',
                'label' => 'Hora final',
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
                'titulo' => form_error('titulo'),
                'horainicial' => form_error('horainicial'),
                'horafinal' => form_error('horafinal')
            );
        } else {
            $data = array(
                    'titulo' => strtoupper($this->input->post('titulo')),
                    'idhorario' => $this->input->post('idhorario'),
                    'horainicial' => strtoupper($this->input->post('horainicial')), 
                    'horafinal' => $this->input->post('horafinal') 
                     
                );
            $this->horario->addReceso($data);
              $result['error']   = false;
                $result['success'] = 'User updated successfully'; 
        }
         
     if(isset($result) && !empty($result)){
         echo json_encode($result);
        }
         
    }
        public function addHoraSinClases() {
        //Permission::grant(uri_string());
        $config = array(
             array(
                'field' => 'iddia',
                'label' => 'Titulo',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),
             array(
                'field' => 'horainicial',
                'label' => 'Hora inicial',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),
            array(
                'field' => 'horafinal',
                'label' => 'Hora final',
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
                'iddia' => form_error('iddia'),
                'horainicial' => form_error('horainicial'),
                'horafinal' => form_error('horafinal')
            );
        } else {
            $data = array(
                    'iddia' => $this->input->post('iddia'),
                    'idhorario' => $this->input->post('idhorario'),
                    'horainicial' => $this->input->post('horainicial'), 
                    'horafinal' => $this->input->post('horafinal') 
                     
                );
            $this->horario->addHoraSinClase($data);
              $result['error']   = false;
                $result['success'] = 'User updated successfully'; 
        }
         
     if(isset($result) && !empty($result)){
         echo json_encode($result);
        }
         
    }
     public function updateHoraSinClases() {
        //Permission::grant(uri_string());
        $config = array(
             array(
                'field' => 'iddia',
                'label' => 'Titulo',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),
             array(
                'field' => 'horainicial',
                'label' => 'Hora inicial',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),
            array(
                'field' => 'horafinal',
                'label' => 'Hora final',
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
                'iddia' => form_error('iddia'),
                'horainicial' => form_error('horainicial'),
                'horafinal' => form_error('horafinal')
            );
        } else {
            $id =  $this->input->post('idhorariodetalle');
            $data = array(
                    'iddia' => $this->input->post('iddia'), 
                    'horainicial' => $this->input->post('horainicial'), 
                    'horafinal' => $this->input->post('horafinal') 
                     
                );
            $this->horario->updateHoraSinClase($id,$data); 
        }
         
     if(isset($result) && !empty($result)){
         echo json_encode($result);
        }
         
    }
  public function addHorario() {
        //Permission::grant(uri_string());
        $config = array(
             array(
                'field' => 'idperiodo',
                'label' => 'Periodo',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),
            array(
                'field' => 'idgrupo',
                'label' => 'Grupo',
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
                'idperiodo' => form_error('idperiodo'),
                'idgrupo' => form_error('idgrupo')
            );
        } else {
            $idperiodo = $this->input->post('idperiodo');
            $idgrupo = $this->input->post('idgrupo');
            $validar = $this->horario->validarAddHorario($idperiodo,$idgrupo,$this->session->idplantel);
            if($validar == FALSE){
            $data = array(
                    'idplantel'=>$this->session->idplantel,
                    'idperiodo' => $this->input->post('idperiodo'),
                    'idgrupo' => $this->input->post('idgrupo'),
                    'activo' => 1
                     
                );
            $this->horario->addHorario($data);

        }else{
            $result['error'] = true;
            $result['msg'] = array(
                'msgerror' => "EL Horario ya esta registrado para este Ciclo Escolar."
            );
        }

        }
         
       if(isset($result) && !empty($result)){
         echo json_encode($result);
        }
         
    }
     public function updateHorario() {
        //Permission::grant(uri_string());
        $config = array(
             array(
                'field' => 'idperiodo',
                'label' => 'Periodo',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),
            array(
                'field' => 'idgrupo',
                'label' => 'Grupo',
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
                'idperiodo' => form_error('idperiodo'),
                'idgrupo' => form_error('idgrupo')
            );
        } else {
            $id = $this->input->post('idhorario');
            $idgrupo = $this->input->post('idgrupo');
            $idperiodo = $this->input->post('idperiodo');
            $validar = $this->horario->validarUpdateHorario($idperiodo,$idgrupo,$id,$this->session->idplantel);
            if($validar == FALSE){
            $data = array(
                    'idplantel'=>$this->session->idplantel,
                    'idperiodo' => $this->input->post('idperiodo'),
                    'idgrupo' => $this->input->post('idgrupo'),
                    'activo' => $this->input->post('activo')
                     
                );
            $this->horario->updateHorario($id,$data); 
          }else{
            $result['error'] = true;
            $result['msg'] = array(
                'msgerror' =>  "El horario ya esta regisrado."
            );
          }

        }
         
    if(isset($result) && !empty($result)){
         echo json_encode($result);
        }
         
    }
      public function updateMateriaHorario() {
        //Permission::grant(uri_string());
        $config = array(
             array(
                'field' => 'idmateria',
                'label' => 'Materia',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),
            array(
                'field' => 'iddia',
                'label' => 'Dia',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),
             array(
                'field' => 'horainicial',
                'label' => 'Hora inicial',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),
            array(
                'field' => 'horafinal',
                'label' => 'Hora final',
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
                'idmateria' => form_error('idmateria'),
                'iddia' => form_error('iddia'),
                'horainicial' => form_error('horainicial'),
                'horafinal' => form_error('horafinal')
            );
        } else {
            $id = $this->input->post('idhorariodetalle');
            $data = array(
                    'idhorario' => $this->input->post('idhorario'),
                    'idmateria' => strtoupper($this->input->post('idprofesormateria')),
                    'iddia' => strtoupper($this->input->post('iddia')),
                    'horainicial' => strtoupper($this->input->post('horainicial')), 
                    'horafinal' => $this->input->post('horafinal') 
                     
                );
            $this->horario->updateHorarioMateria($id,$data);
              $result['error']   = false;
                $result['success'] = 'User updated successfully'; 
        }
         
      if(isset($result) && !empty($result)){
         echo json_encode($result);
        }
         
    }
     public function updateReceso() {
        //Permission::grant(uri_string());
        $config = array(
             array(
                'field' => 'nombreclase',
                'label' => 'Titulo',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),
             array(
                'field' => 'horainicial',
                'label' => 'Hora inicial',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),
            array(
                'field' => 'horafinal',
                'label' => 'Hora final',
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
                'nombreclase' => form_error('nombreclase'),
                'horainicial' => form_error('horainicial'),
                'horafinal' => form_error('horafinal')
            );
        } else {
            $id = $this->input->post('idhorariodetalle');
            $data = array(
                    'titulo' => strtoupper($this->input->post('nombreclase')),
                    'horainicial' => strtoupper($this->input->post('horainicial')), 
                    'horafinal' => $this->input->post('horafinal') 
                     
                );
            $this->horario->updateReceso($id,$data);
              $result['error']   = false;
                $result['success'] = 'User updated successfully'; 
        }
         
       if(isset($result) && !empty($result)){
         echo json_encode($result);
        }
         
    }

 public function deleteHorarioMateria()
 { 
      $id = $this->input->get('id');
        $query = $this->horario->deleteHorarioMateria($id);
        if ($query) {
            $result['horarios'] = true;
        } 
       if(isset($result) && !empty($result)){
         echo json_encode($result);
        }

 }

  public function deleteReceso()
 { 
        $id = $this->input->get('id');
        $query = $this->horario->deleteReceso($id);
        if ($query) {
            $result['horarios'] = true;
        } 
       if(isset($result) && !empty($result)){
         echo json_encode($result);
        }

 }

 public function imprimirHorario($idhorario='')
 {
   # code...
   $lunes = $this->horario->showAllDiaHorario($idhorario,1);
        $martes = $this->horario->showAllDiaHorario($idhorario,2);
        $miercoles = $this->horario->showAllDiaHorario($idhorario,3);
        $jueves = $this->horario->showAllDiaHorario($idhorario,4);
        $viernes = $this->horario->showAllDiaHorario($idhorario,5);  
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
.dl{ 
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
     font-size:8px;
     font-weight:bolder;
}
</style>

<title>Title</title>
</head>
<body>
 
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
$this->dompdf->stream("welcome.pdf", array("Attachment"=>0));
 }

 public function deleteHorario()
  {
        $idhorario = $this->input->get('idhorario');
        $query = $this->horario->deleteHorario($idhorario);
        if ($query) {
            $result['horarios'] = true;
        } 
       if(isset($result) && !empty($result)){
         echo json_encode($result);
        }
  }
  public function deleteSinClases()
  {
        $id = $this->input->get('id');
        $query = $this->horario->deleteSinClases($id);
        if ($query) {
            $result['horarios'] = true;
        } 
       if(isset($result) && !empty($result)){
         echo json_encode($result);
        }
  }


}
