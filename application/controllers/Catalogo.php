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
            $this->colegiatura->desactivarColegiatura($idconcepto,$idnivel,$update);
            $datausuario     = array(
                    'idnivelestudio' => $this->input->post('idnivel'),
                    'idplantel' => $idplantel,
                    'idtipopagocol' => $this->input->post('idconcepto'),
                    'descuento' => $this->input->post('descuento'),
                    'activo' => 1,
                    'idusuario' => $this->session->user_id,
                    'fecharegistro' => date('Y-m-d H:i:s')

            );
             $this->colegiatura->addColegiatura($datausuario);
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
                'idnivel' => form_error('idnivel'),
                 'idconcepto' => form_error('idconcepto'),
                'descuento' => form_error('descuento'),
            );
        } else {
            $idplantel = $this->session->idplantel;
            $idconcepto = $this->input->post('idconcepto');
            $idnivel = $this->input->post('idnivel');
            $idcolegiatura =  $this->input->post('idcolegiatura');
            $activo_send=  $this->input->post('activo');
            $detalle = $this->colegiatura->detalleColegiatura($idcolegiatura);
            $activo = $detalle[0]->activo;
            if($activo == $activo_send){

            }else{
                
            }
            $update = array(
                'activo' => 0,
                'idusuario' => $this->session->user_id,
                'fecharegistro' => date('Y-m-d H:i:s')
            );
            $this->colegiatura->desactivarColegiatura($idconcepto,$idnivel,$update);
            $datausuario     = array(
                    'idnivelestudio' => $this->input->post('idnivel'),
                    'idplantel' => $idplantel,
                    'idtipopagocol' => $this->input->post('idconcepto'),
                    'descuento' => $this->input->post('descuento'),
                    'activo' => 1,
                    'idusuario' => $this->session->user_id,
                    'fecharegistro' => date('Y-m-d H:i:s')

            );
             $this->colegiatura->addColegiatura($datausuario);
        }
        if(isset($result) && !empty($result)){
        echo json_encode($result);
        }
    	 
     }
}

