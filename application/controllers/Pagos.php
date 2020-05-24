<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("America/Mexico_City");
class Pagos extends CI_Controller {
 
  function __construct() {
        parent::__construct();  
        $this->load->helper('url'); 
        $this->load->model('data_model');  
        $this->load->model('alumno_model','alumno');  
        $this->load->model('pagos_model','pagos');  
    }

	public function index()
	{ 
        $meses =  $this->pagos->showAll();
        $data = array(
           'meses'=>$meses
        );
        //$this->load->view('admin/header');
       
		$this->load->view('pagos/index',$data);
		//$this->load->view('admin/footer');
	}
    public function buscar()
    {
        # code...
        $matricula = strtoupper($this->input->post('matricula'));
        $resultado = $this->alumno->buscarAlumno($matricula);
        $total = 0;
        if($resultado){
                foreach ($resultado as  $value) {
                $total = $total + 1;
            }
        }
        if($total == 1){
            //echo 1;
            $data = array(
                'opcion' => 1,
                'nombre'=> $resultado[0]->nombre." ".$resultado[0]->apellidop." ".$resultado[0]->apellidom,
                'idalumno'=>$resultado[0]->idalumno
            );
            echo json_encode($data);
        }else{
             $data = array(
                'opcion' => 0,
                'error'=> 'Matricula no encontrada.'
            );
              echo json_encode($data);
        }
         
    }


}
