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
}
