<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("America/Mexico_City");
class Escuela extends CI_Controller {
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
        $this->load->model('escuela_model','escuela'); 
	}
 
	public function index()
	{  
        Permission::grant(uri_string());
	      $this->load->view('admin/header');
        $this->load->view('admin/escuela/index');
        $this->load->view('admin/footer');

	} 
   public function showAll() { 
         $query = $this->escuela->showAll();
         //var_dump($query);
         if ($query) {
             $result['escuelas'] = $this->escuela->showAll();
         }
         if(isset($result) && !empty($result)){
         echo json_encode($result);
        }
     }
  public function searchEscuela() {
        //Permission::grant(uri_string());
        $value = $this->input->post('text');
        $query = $this->escuela->searchEscuela($value);
        if ($query) {
            $result['escuelas'] = $query;
        }
        if(isset($result) && !empty($result)){
         echo json_encode($result);
        }
    }
    public function addEscuela()
    {
         $config = array(
            array(
                'field' => 'clave',
                'label' => 'Clave',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),
             array(
                'field' => 'nombreplantel',
                'label' => 'Nombre del plantel',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),
            array(
                'field' => 'direccion',
                'label' => 'Dirección',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),array(
                'field' => 'director',
                'label' => 'director',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),
            array(
                'field' => 'telefono',
                'label' => 'Telefono',
                'rules' => 'trim|required|integer|exact_length[10]',
                'errors' => array(
                    'required' => 'Campo obligatorio.',
                    'integer'=>'Debe de ser solo número.',
                    'exact_length'=>'Debe de ser 10 digitos.'
                )
            )
        );

        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            $result['error'] = true;
            $result['msg'] = array(
                'clave' => form_error('clave'),
                'nombreplantel' => form_error('nombreplantel'),
                'direccion' => form_error('direccion'),
                'telefono' => form_error('telefono'),
                'director' => form_error('director')
            );
        } else {
            $clave = strtoupper($this->input->post('clave'));
            $validar = $this->escuela->validarAddEscuela($clave);
            if($validar == FALSE){
            $data = array(
                    'clave' => strtoupper($this->input->post('clave')),
                    'nombreplantel' => strtoupper($this->input->post('nombreplantel')),
                    'direccion' => strtoupper($this->input->post('direccion')),
                    'telefono' => $this->input->post('telefono'),
                    'director' =>  strtoupper($this->input->post('director')), 
                    'idusuario' => $this->session->user_id,
                    'fecharegistro' => date('Y-m-d H:i:s')
                     
                );
            $this->escuela->addEscuela($data); 
        }
            else{
                    $result['error'] = true;
                    $result['msg'] = array(
                        'msgerror' => "La clave de la Escuela ya esta registrado."
                    );

            }
        }
         
       if(isset($result) && !empty($result)){
         echo json_encode($result);
        }
    }
       public function updateEscuela()
    {
         $config = array(
            array(
                'field' => 'clave',
                'label' => 'Clave',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),
             array(
                'field' => 'nombreplantel',
                'label' => 'Nombre del plantel',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),
            array(
                'field' => 'direccion',
                'label' => 'Dirección',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),array(
                'field' => 'director',
                'label' => 'director',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),
            array(
                'field' => 'telefono',
                'label' => 'Telefono',
                'rules' => 'trim|required|integer|exact_length[10]',
                'errors' => array(
                    'required' => 'Campo obligatorio.',
                    'integer'=>'Debe de ser solo número.',
                    'exact_length'=>'Debe de ser 10 digitos.'
                )
            )
        );

        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            $result['error'] = true;
            $result['msg'] = array(
                'clave' => form_error('clave'),
                'nombreplantel' => form_error('nombreplantel'),
                'direccion' => form_error('direccion'),
                'telefono' => form_error('telefono'),
                'director' => form_error('director')
            );
        } else {
            $clave = strtoupper($this->input->post('clave'));
            $idplantel = strtoupper($this->input->post('idplantel'));
            $validar = $this->escuela->validarUpdateEscuela($clave,$idplantel);
            if($validar == FALSE){
            $data = array(
                    'clave' => strtoupper($this->input->post('clave')),
                    'nombreplantel' => strtoupper($this->input->post('nombreplantel')),
                    'direccion' => strtoupper($this->input->post('direccion')),
                    'telefono' => $this->input->post('telefono'),
                    'director' =>  strtoupper($this->input->post('director')), 
                    'idusuario' => $this->session->user_id,
                    'fecharegistro' => date('Y-m-d H:i:s')
                     
                );
            $this->escuela->updateEscuela($idplantel,$data); 
        }
            else{
                    $result['error'] = true;
                    $result['msg'] = array(
                        'msgerror' => "La clave de la Escuela ya esta registrado."
                    );

            }
        }
         
       if(isset($result) && !empty($result)){
         echo json_encode($result);
        }
    }

       public function deleteEscuela()
    {
        # code...
        $idplantel = $this->input->get('idplantel');
        $query = $this->escuela->deleteEscuela($idplantel);
        if ($query) {
            $result['escuela'] = true;
        } 
       if(isset($result) && !empty($result)){
         echo json_encode($result);
        }
    }



}
