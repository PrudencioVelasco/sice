<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("America/Mexico_City");
class Tutor extends CI_Controller {
 
  function __construct() {
        parent::__construct(); 
        if (!isset($_SESSION['user_id'])) {
            $this->session->set_flashdata('flash_data', 'You don\'t have access! ss');
            return redirect('welcome');
        }
        $this->load->helper('url');
        $this->load->model('tutor_model','tutor');
        $this->load->model('user_model','user');
        $this->load->model('data_model'); 
        $this->load->library('permission');
        $this->load->library('session'); 

    }

	public function index()
	{
         Permission::grant(uri_string());
		$this->load->view('admin/header');
		$this->load->view('admin/tutor/index');
		$this->load->view('admin/footer');
	}
	  public function showAll() {
       // Permission::grant(uri_string()); 
         $idplantel = $this->session->idplantel;
        $query = $this->tutor->showAll();
        if ($query) {
            $result['tutores'] = $this->tutor->showAll($idplantel);
        }
       if(isset($result) && !empty($result)){
         echo json_encode($result);
        }
    }
     public function showAllAlumnos() {
       // Permission::grant(uri_string()); 
         $idplantel = $this->session->idplantel;
        $query = $this->tutor->showAllAlumnos();
        if ($query) {
            $result['alumnos'] = $this->tutor->showAllAlumnos($idplantel);
        }
      if(isset($result) && !empty($result)){
         echo json_encode($result);
        }
    }
    public function showAllTutorAlumnos($idtutor) {
       // Permission::grant(uri_string()); 
        $query = $this->tutor->showAllTutorAlumnos($idtutor);
        if ($query) {
            $result['alumnos'] = $this->tutor->showAllTutorAlumnos($idtutor);
        }
       if(isset($result) && !empty($result)){
         echo json_encode($result);
        }
    }

    public function addTutor() {
        //Permission::grant(uri_string());
        $config = array(
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
                'field' => 'fnacimiento',
                'label' => 'Fecha nacimiento',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),array(
                'field' => 'direccion',
                'label' => 'Dirección',
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
            ),
            array(
                'field' => 'correo',
                'label' => 'Correo',
                'rules' => 'trim|required|valid_email',
                'errors' => array(
                    'required' => 'Campo obligatorio.',
                    'valid_email' => 'Correo no valido.'
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
        );

        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            $result['error'] = true;
            $result['msg'] = array(
                'nombre' => form_error('nombre'),
                'apellidop' => form_error('apellidop'),
                'fnacimiento' => form_error('fnacimiento'),
                'telefono' => form_error('telefono'),
                'correo' => form_error('correo'),
                'direccion' => form_error('direccion'),
                'password' => form_error('password')
            );
        } else {
            $correo = trim($this->input->post('correo'));
            $validar = $this->tutor->validarAddTutor($correo, $this->session->idplantel);
            if($validar == FALSE){
            $password_encrypted = password_hash(trim($this->input->post('password')), PASSWORD_BCRYPT);
        	$data = array(
                   'idplantel'=> $this->session->idplantel,
                    'nombre' => strtoupper($this->input->post('nombre')),
                    'apellidop' => strtoupper($this->input->post('apellidop')),
                    'apellidom' => strtoupper($this->input->post('apellidom')),
                    'fnacimiento' => $this->input->post('fnacimiento'),
                    'direccion' =>  strtoupper($this->input->post('direccion')),
                    'telefono' => $this->input->post('telefono'),
                    'correo' => $this->input->post('correo'),
                    'password' => $password_encrypted,
                    'idusuario' => $this->session->user_id,
                    'fecharegistro' => date('Y-m-d H:i:s')
                     
                );
        	  $idtutor = $this->tutor->addTutor($data); 
              $datausuario     = array(
                'idusuario' => $idtutor,
                'idtipousuario' => 5, 
                'fecharegistro' => date('Y-m-d H:i:s')

            );
             $idusuario = $this->user->addUser($datausuario);
        }else{
              $result['error'] = true;
              $result['msg'] = array(
                           'msgerror' => "El correo electrico ya esta registrado."
                    );
        }
        }
         
      if(isset($result) && !empty($result)){
         echo json_encode($result);
        }
    	 
    }

        public function updateTutor() {
        //Permission::grant(uri_string());
      $config = array(
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
                'field' => 'fnacimiento',
                'label' => 'Fecha nacimiento',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),array(
                'field' => 'direccion',
                'label' => 'Dirección',
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
            ),
            array(
                'field' => 'correo',
                'label' => 'Correo',
                'rules' => 'trim|required|valid_email',
                'errors' => array(
                    'required' => 'Campo obligatorio.',
                    'valid_email' => 'Correo no valido.'
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
        );

        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            $result['error'] = true;
            $result['msg'] = array(
                'nombre' => form_error('nombre'),
                'apellidop' => form_error('apellidop'),
                'fnacimiento' => form_error('fnacimiento'),
                'telefono' => form_error('telefono'),
                'correo' => form_error('correo'),
                'direccion' => form_error('direccion'),
                'password' => form_error('password')
            );
        } else {
            $idtutor = $this->input->post('idtutor');
            $correo = trim($this->input->post('correo'));
            $validar = $this->tutor->validarUpdateTutor($idtutor,$correo,$this->session->idplantel);
            if($validar == FALSE){
            $data = array(
                    'idplantel'=> $this->session->idplantel,
                    'nombre' => strtoupper($this->input->post('nombre')),
                    'apellidop' => strtoupper($this->input->post('apellidop')),
                    'apellidom' => strtoupper($this->input->post('apellidom')),
                    'fnacimiento' => $this->input->post('fnacimiento'),
                    'direccion' =>  strtoupper($this->input->post('direccion')),
                    'telefono' => $this->input->post('telefono'),
                    'correo' => $this->input->post('correo'),
                    'idusuario' => $this->session->user_id,
                    'fecharegistro' => date('Y-m-d H:i:s')
                     
                );
            $this->tutor->updateTutor($idtutor,$data); 

             }else{
              $result['error'] = true;
              $result['msg'] = array(
                           'msgerror' => "El correo electrico ya esta registrado."
                    );
        }

        }
         
      if(isset($result) && !empty($result)){
         echo json_encode($result);
        }
         
    }
    public function searchTutor() {
        //Permission::grant(uri_string());
        $value = $this->input->post('text');
         $idplantel = $this->session->idplantel;
        $query = $this->tutor->searchTutor($value,$idplantel);
        if ($query) {
            $result['tutores'] = $query;
        }
      if(isset($result) && !empty($result)){
         echo json_encode($result);
        }
    }

    public function alumnos($id)
    {
    	# code...
    	$data = array(
    		'id'=>$id,
    		'detalle'=>$this->tutor->detalleTutor($id)
    	);
    	$this->load->view('admin/header');
		$this->load->view('admin/tutor/detalle',$data);
		$this->load->view('admin/footer');
    }
        public function addTutorAlumno() {
        //Permission::grant(uri_string());
        $config = array(
            array(
                'field' => 'idalumno',
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
                'idalumno' => form_error('idalumno')
            );
        } else {
            $data = array(
                    'idtutor' => $this->input->post('idtutor'),
                    'idalumno' => $this->input->post('idalumno')
                     
                );
            $this->tutor->addTutorAlumno($data);
              $result['error']   = false;
                $result['success'] = 'User updated successfully'; 
        }
         
      if(isset($result) && !empty($result)){
         echo json_encode($result);
        }
         
    }
    public function deleteAlumno($id)
    {
        # code...
        $this->tutor->deleteAlumno($id);
    }
      public function deleteTutor()
  {
        $idtutor = $this->input->get('idtutor');
        $query = $this->tutor->deleteTutor($idtutor);
        if ($query) {
            $result['tutores'] = true;
        } 
       if(isset($result) && !empty($result)){
         echo json_encode($result);
        }
  }
  public function updatePassword()
  {
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
            $id = $this->input->post('idtutor'); 
            $password_encrypted = password_hash(trim($this->input->post('password1')), PASSWORD_BCRYPT);
            
            $data = array(
                    'password' => $password_encrypted, 
                    'idusuario' => $this->session->user_id,
                    'fecharegistro' => date('Y-m-d H:i:s')
                     
                );
            $this->tutor->updateTutor($id,$data); 
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
}
