<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("America/Mexico_City");
class Materia extends CI_Controller {
 
  function __construct() {
        parent::__construct(); 
        if (!isset($_SESSION['user_id'])) {
            $this->session->set_flashdata('flash_data', 'You don\'t have access! ss');
            return redirect('welcome');
        }
        $this->load->helper('url');
        $this->load->model('Materia_model','materia');  
        $this->load->model('data_model'); 
        $this->load->library('permission');
        $this->load->library('session');
        $this->load->library('pdfgenerator'); 
    }

	public function index()
	{ 
       // Permission::grant(uri_string());
		$this->load->view('admin/header');
		$this->load->view('admin/materia/index');
		$this->load->view('admin/footer');
	}
      public function searchCiclo() { 
        $value = $this->input->post('text');
        $query = $this->ciclo->searchCiclo($value,$this->session->idplantel);
        if ($query) {
            $result['ciclos'] = $query;
        }
     if(isset($result) && !empty($result)){
         echo json_encode($result);
        }
    }

    public function showAll() { 
         $query = $this->materia->showAll($this->session->idplantel);
         //var_dump($query);
         if ($query) {
             $result['materias'] = $this->materia->showAll($this->session->idplantel);
         }
       if(isset($result) && !empty($result)){
         echo json_encode($result);
        }
     }
    public function showAllNiveles() { 
         $query = $this->materia->showAllNiveles();
         //var_dump($query);
         if ($query) {
             $result['niveles'] = $this->materia->showAllNiveles();
         }
        if(isset($result) && !empty($result)){
         echo json_encode($result);
        }
     }
     public function showAllEspecialidades() { 
         $query = $this->materia->showAllEspecialidades($this->session->idplantel);
         //var_dump($query);
         if ($query) {
             $result['especialidades'] = $this->showAllEspecialidades->showAllYears($this->session->idplantel);
         }
        if(isset($result) && !empty($result)){
         echo json_encode($result);
        }
     }
     
       public function addMateria() {
        //Permission::grant(uri_string());
        $config = array(
             array(
                'field' => 'idnivelestudio',
                'label' => 'Mes inicio',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),
            array(
                'field' => 'idespecialidad',
                'label' => 'Nombre',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),
             array(
                'field' => 'nombreclase',
                'label' => 'A. Paterno',
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
                'idnivelestudio' => form_error('idnivelestudio'),
                'idespecialidad' => form_error('idespecialidad'), 
                'nombreclase' => form_error('nombreclase') 
            );
        } else {

            $idnivelestudio =  trim($this->input->post('idnivelestudio'));
            $idespecialidad =  trim($this->input->post('idespecialidad'));
            $nombreclase =  trim($this->input->post('nombreclase')); 
            $validar = $this->materia->validarAddMateria($idnivelestudio,$idespecialidad,$nombreclase, $this->session->idplantel);
            if($validar == FALSE){

            $data = array(
                    'idplantel'=> $this->session->idplantel,
                    'idnivelestudio' => $idnivelestudio,
                    'idespecialidad' =>  $idespecialidad,
                    'nombreclase' =>  $nombreclase, 
                    'idusuario' => $this->session->user_id,
                    'fecharegistro' => date('Y-m-d H:i:s')
                     
                );
            $this->materia->addMateria($data);


         }else{
             $result['error'] = true;
            $result['msg'] = array(
                'msgerror' => 'Ya esta registrado la Materia.'
            );
             
          } 
        }
         
       if(isset($result) && !empty($result)){
         echo json_encode($result);
        }
         
    }

    public function updateMateria()
    {
           $config = array(
             array(
                'field' => 'idnivelestudio',
                'label' => 'Mes inicio',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),
            array(
                'field' => 'idespecialidad',
                'label' => 'Nombre',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),
             array(
                'field' => 'nombreclase',
                'label' => 'A. Paterno',
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
                'idnivelestudio' => form_error('idnivelestudio'),
                'idespecialidad' => form_error('idespecialidad'), 
                'nombreclase' => form_error('nombreclase') 
            );
        } else {

           $idnivelestudio =  trim($this->input->post('idnivelestudio'));
            $idespecialidad =  trim($this->input->post('idespecialidad'));
            $nombreclase =  trim($this->input->post('nombreclase'));
            $idmateria =  trim($this->input->post('idmateria')); 
            $validar = $this->materia->validarUpdateMateria($idmateria,$idnivelestudio,$idespecialidad,$nombreclase,$this->session->idplantel);
            if($validar == FALSE){ 

            $data = array(
                    'idnivelestudio' => $idnivelestudio,
                    'idespecialidad' =>  $idespecialidad,
                    'nombreclase' =>  $nombreclase, 
                    'idusuario' => $this->session->user_id,
                    'fecharegistro' => date('Y-m-d H:i:s')
                     
                );
            $this->materia->updateMateria($idmateria,$data);
         


         }else{
             $result['error'] = true;
            $result['msg'] = array(
                'msgerror' => 'Ya esta registrado la Materia.'
            );
             
          } 
        }
         
       if(isset($result) && !empty($result)){
         echo json_encode($result);
        }
    }
   public function deleteMateria()
    {
        # code...
        $idmateria = $this->input->get('idmateria');
        $query = $this->materia->deleteMateria($idmateria);
        if ($query) {
            $result['materias'] = true;
        } 
       if(isset($result) && !empty($result)){
         echo json_encode($result);
        }
    }

}
