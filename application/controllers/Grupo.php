<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("America/Mexico_City");
class Grupo extends CI_Controller {
 
  function __construct() {
        parent::__construct(); 
        if (!isset($_SESSION['user_id'])) {
            $this->session->set_flashdata('flash_data', 'You don\'t have access! ss');
            return redirect('welcome');
        }
        $this->load->helper('url');
        $this->load->model('Grupo_model','grupo');  
         $this->load->model('Alumno_model','alumno');  
        $this->load->model('data_model'); 
        $this->load->library('permission');
        $this->load->library('session');
        $this->load->library('pdfgenerator'); 
    }

	public function index()
	{  
    Permission::grant(uri_string());
		$this->load->view('admin/header');
		$this->load->view('admin/grupo/index');
		$this->load->view('admin/footer');
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
      public function searchGrupo() { 
         $idplantel = $this->session->idplantel;
        $value = $this->input->post('text');
        $query = $this->grupo->searchGrupo($value,$idplantel);
        if ($query) {
            $result['grupos'] = $query;
        }
       if(isset($result) && !empty($result)){
         echo json_encode($result);
        }
    }

    public function showAll() { 
       $idplantel = $this->session->idplantel;
         $query = $this->grupo->showAllGrupos($idplantel);
         //var_dump($query);
         if ($query) {
             $result['grupos'] = $this->grupo->showAllGrupos($idplantel);
         }
if(isset($result) && !empty($result)){
         echo json_encode($result);
        }
     }
     public function showAllNiveles() { 
         $query = $this->grupo->showAllNiveles();
         //var_dump($query);
         if ($query) {
             $result['niveles'] = $this->grupo->showAllNiveles();
         }
        if(isset($result) && !empty($result)){
         echo json_encode($result);
        }
     }
      public function showAllTurnos() { 
         $query = $this->grupo->showAllTurnos();
         //var_dump($query);
         if ($query) {
             $result['turnos'] = $this->grupo->showAllTurnos();
         }
        if(isset($result) && !empty($result)){
         echo json_encode($result);
        }
     }
     
       public function addGrupo() {
        //Permission::grant(uri_string());
        $config = array(
             array(
                'field' => 'idespecialidad',
                'label' => 'Mes inicio',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),
              array(
                'field' => 'idnivelestudio',
                'label' => 'Mes inicio',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),
            array(
                'field' => 'idturno',
                'label' => 'Nombre',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),
             array(
                'field' => 'nombregrupo',
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
                'idturno' => form_error('idturno'), 
                'nombregrupo' => form_error('nombregrupo')
            );
        } else {

            $idnivelestudio =  trim($this->input->post('idnivelestudio'));
            $idturno =  trim($this->input->post('idturno'));
            $nombregrupo =  trim($this->input->post('nombregrupo')); 
            $validar = $this->grupo->validarAddGrupo($idnivelestudio,$idturno,$nombregrupo,$this->session->idplantel);
            if($validar == FALSE){ 
            $data = array(
                    'idespecialidad' =>  $this->input->post('idespecialidad'),
                    'idplantel'=> $this->session->idplantel,
                    'idnivelestudio' =>  $this->input->post('idnivelestudio'),
                    'idturno' => $this->input->post('idturno'),
                    'nombregrupo' =>  strtoupper($this->input->post('nombregrupo')), 
                    'idusuario' => $this->session->user_id,
                    'fecharegistro' => date('Y-m-d H:i:s')
                     
                );
            $this->grupo->addGrupo($data);


         }else{
             $result['error'] = true;
            $result['msg'] = array(
                'msgerror' => 'Ya esta registrado el Grupo.'
            );
             
          } 
        }
         
       if(isset($result) && !empty($result)){
         echo json_encode($result);
        }
         
    }

           public function updateGrupo() {
        //Permission::grant(uri_string());
        $config = array(
             array(
                'field' => 'idespecialidad',
                'label' => 'Mes inicio',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),
              array(
                'field' => 'idnivelestudio',
                'label' => 'Mes inicio',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),
            array(
                'field' => 'idturno',
                'label' => 'Nombre',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),
             array(
                'field' => 'nombregrupo',
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
                'idturno' => form_error('idturno'), 
                'nombregrupo' => form_error('nombregrupo')
            );
        } else {
            $idgrupo =  trim($this->input->post('idgrupo'));
            $idnivelestudio =  trim($this->input->post('idnivelestudio'));
            $idturno =  trim($this->input->post('idturno'));
            $nombregrupo =  trim($this->input->post('nombregrupo')); 

            $validar = $this->grupo->validarUpdateGrupo($idnivelestudio,$idturno,$nombregrupo,$idgrupo,$this->session->idplantel);
            if($validar == FALSE){ 
            $data = array(
                    'idespecialidad' =>  $this->input->post('idespecialidad'),
                    'idplantel'=> $this->session->idplantel,
                    'idnivelestudio' =>  $this->input->post('idnivelestudio'),
                    'idturno' => $this->input->post('idturno'),
                    'nombregrupo' =>  strtoupper($this->input->post('nombregrupo')), 
                    'idusuario' => $this->session->user_id,
                    'fecharegistro' => date('Y-m-d H:i:s')
                     
                );
            $this->grupo->updateGrupo($idgrupo,$data);


         }else{
             $result['error'] = true;
            $result['msg'] = array(
                'msgerror' => 'Ya esta registrado el Grupo.'
            );
             
          } 
        }
         
        if(isset($result) && !empty($result)){
         echo json_encode($result);
        }
         
    }


    
   public function deleteGrupo()
    {
        # code...
        $idgrupo = $this->input->get('idgrupo');
        $query = $this->grupo->deleteGrupo($idgrupo);
        if ($query) {
            $result['grupos'] = true;
        } 
       if(isset($result) && !empty($result)){
         echo json_encode($result);
        }
    }

}
