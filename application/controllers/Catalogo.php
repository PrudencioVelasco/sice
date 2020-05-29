<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("America/Mexico_City");
class Catalogo extends CI_Controller {
 function __construct() {
        parent::__construct();

        if (!isset($_SESSION['user_id'])) {
            $this->session->set_flashdata('flash_data', 'You don\'t have access! ss');
            return redirect('welcome');
        }
        $this->load->helper('url');
        $this->load->model('data_model');
        $this->load->model('colegiatura_model','colegiatura');
        $this->load->model('unidadexamen_model','unidadexamen'); 
        $this->load->library('permission');
        $this->load->library('session');
	}
 
	public function index()
	{
		 
		Permission::grant(uri_string());
		$this->load->view('admin/header');
		$this->load->view('admin/catalogo/index');
		$this->load->view('admin/footer');
		# code...

    } 
    public function colegiatura()
    {
     	$this->load->view('admin/header');
		$this->load->view('admin/catalogo/colegiatura/index');
		$this->load->view('admin/footer');
    }
    public function showAll()
    {
         $idplantel = $this->session->idplantel;
         $query = $this->colegiatura->showAll($idplantel);
         //var_dump($query);
         if ($query) {
             $result['colegiaturas'] = $this->colegiatura->showAll($idplantel);
         }
         if(isset($result) && !empty($result)){
         echo json_encode($result);
        }
    }
      public function searchColegiatura() { 
        $value = $this->input->post('text');
        $query = $this->colegiatura->searchColegiatura($value);
        if ($query) {
            $result['colegiaturas'] = $query;
        }
        if(isset($result) && !empty($result)){
         echo json_encode($result);
        }
    }
        public function showAllUnidadExamen()
    {
         $idplantel = $this->session->idplantel;
         $query = $this->unidadexamen->showAll($idplantel);
         //var_dump($query);
         if ($query) {
             $result['unidades'] = $this->unidadexamen->showAll($idplantel);
         }
         if(isset($result) && !empty($result)){
         echo json_encode($result);
        }
    }
        public function searchUnidadExamen() {
        //Permission::grant(uri_string());
        $value = $this->input->post('text');
        $query = $this->unidadexamen->searchUnidadExamen($value);
        if ($query) {
            $result['unidades'] = $query;
        }
        if(isset($result) && !empty($result)){
        echo json_encode($result);
        }
    }
     public function showAllNiveles() { 
         $query = $this->colegiatura->showAllNiveles();
         //var_dump($query);
         if ($query) {
             $result['niveles'] = $this->colegiatura->showAllNiveles();
         }
         if(isset($result) && !empty($result)){
         echo json_encode($result);
        }
     }
      public function showAllConceptos() { 
         $query = $this->colegiatura->showAllConceptos();
         //var_dump($query);
         if ($query) {
             $result['conceptos'] = $this->colegiatura->showAllConceptos();
         }
         if(isset($result) && !empty($result)){
         echo json_encode($result);
        }
     }
     public function addColegiatura()
     {
         $config = array(
             array(
                'field' => 'idnivel',
                'label' => 'Nombre',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),
             array(
                'field' => 'idconcepto',
                'label' => 'Nombre',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),
            array(
                'field' => 'descuento',
                'label' => 'Nombre',
                'rules' => 'trim|required|decimal',
                'errors' => array(
                    'required' => 'Campo obligatorio.',
                     'decimal' =>'Formato decimal.'
                )
            )
        );

        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            $result['error'] = true;
            $result['msg'] = array(
                'idnivel' => form_error('idnivel'),
                 'idconcepto' => form_error('idconcepto'),
                'descuento' => form_error('descuento'),
            );
        } else {
            $idplantel = $this->session->idplantel;
            $idconcepto = $this->input->post('idconcepto');
            $idnivel = $this->input->post('idnivel');
            $update = array(
                'activo' => 0,
                'idusuario' => $this->session->user_id,
                'fecharegistro' => date('Y-m-d H:i:s')
            );
            $this->colegiatura->desactivarColegiatura($idconcepto,$idnivel,$idplantel,$update);
            $datausuario     = array(
                    'idnivelestudio' => $this->input->post('idnivel'),
                    'idplantel' => $idplantel,
                    'idtipopagocol' => $this->input->post('idconcepto'),
                    'descuento' => $this->input->post('descuento'),
                    'activo' => 1,
                    'eliminado'=>0,
                    'idusuario' => $this->session->user_id,
                    'fecharegistro' => date('Y-m-d H:i:s')

            );
             $this->colegiatura->addColegiatura($datausuario);
        }
        if(isset($result) && !empty($result)){
        echo json_encode($result);
        }
    	 
     }
          public function addUnidadExamen()
     {
         $config = array(
             array(
                'field' => 'idplanel',
                'label' => 'Nombre',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),
             array(
                'field' => 'nombreunidad',
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
                'idplantel' => form_error('idplantel'),
                'nombreunidad' => form_error('nombreunidad')
            );
        } else { 
            $idplantel = $this->input->post('idplantel');
            $nombreunidad = $this->input->post('nombreunidad'); 
            $data     = array( 
                    'idplantel' => $idplantel,
                    'nombreunidad' => $nombreunidad, 
                    'idusuario' => $this->session->user_id,
                    'fecharegistro' => date('Y-m-d H:i:s')

            );
             $this->unidadexamen->addUnidadExamen($data);
        }
        if(isset($result) && !empty($result)){
        echo json_encode($result);
        }
    	 
     }
public function updateUnidadExamen()
     {
         $config = array(
             array(
                'field' => 'idunidad',
                'label' => 'Nombre',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),
             array(
                'field' => 'idplantel',
                'label' => 'Nombre',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),
            array(
                'field' => 'nombreunidad',
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
                'idunidad' => form_error('idunidad'),
                 'idplantel' => form_error('idplantel'),
                'nombreunidad' => form_error('nombreunidad'),
            );
        } else {
            $idunidad = $this->input->post('idconcepto');
            $idplantel = $this->input->post('idnivel');
            $nombreunidad =  $this->input->post('idcolegiatura');
            $data     = array(
                    'idplantel' => $idplantel,
                    'nombreunidad' => $nombreunidad, 
                    'idusuario' => $this->session->user_id,
                    'fecharegistro' => date('Y-m-d H:i:s')

            );
             $this->unidadexamen->updateUnidadExamen($idunidad,$data);
        }
        if(isset($result) && !empty($result)){
        echo json_encode($result);
        }
    	 
     }

          public function updateColegiatura()
     {
         $config = array(
             array(
                'field' => 'idnivelestudio',
                'label' => 'Nombre',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),
             array(
                'field' => 'idtipopagocol',
                'label' => 'Nombre',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),
            array(
                'field' => 'descuento',
                'label' => 'Nombre',
                'rules' => 'trim|required|decimal',
                'errors' => array(
                    'required' => 'Campo obligatorio.',
                     'decimal' =>'Formato decimal.'
                )
            )
        );

        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            $result['error'] = true;
            $result['msg'] = array(
                'idnivel' => form_error('idnivel'),
                 'idconcepto' => form_error('idconcepto'),
                'descuento' => form_error('descuento'),
            );
        } else {
            $idplantel = $this->session->idplantel;
            $idconcepto = $this->input->post('idtipopagocol');
            $idnivel = $this->input->post('idnivelestudio');
            $idcolegiatura =  $this->input->post('idcolegiatura');
            $activo_send=  $this->input->post('activo'); 
            
            if($activo_send == 1){
            $update = array(
                'activo' => 0,
                'idusuario' => $this->session->user_id,
                'fecharegistro' => date('Y-m-d H:i:s')
            );
            $this->colegiatura->desactivarColegiatura($idconcepto,$idnivel,$idplantel,$update);
            }
            $data     = array(
                    'idnivelestudio' => $this->input->post('idnivelestudio'), 
                    'idtipopagocol' => $this->input->post('idtipopagocol'),
                    'descuento' => $this->input->post('descuento'),
                    'activo' => $activo_send,
                    'idusuario' => $this->session->user_id,
                    'fecharegistro' => date('Y-m-d H:i:s')

            );
             $this->colegiatura->updateColegiatura($idcolegiatura,$data);
        }
        if(isset($result) && !empty($result)){
        echo json_encode($result);
        }
    	 
     }
    public function deleteColegiatura()
    {
        # code...
        $idcolegiatura = $this->input->get('idcolegiatura');
        $data = array(
            'eliminado'=>1
        );
        $query = $this->colegiatura->updateColegiatura($idcolegiatura,$data);
        if ($query) {
            $result['colegiaturas'] = true;
        } 
       if(isset($result) && !empty($result)){
         echo json_encode($result);
        }
    }
}

