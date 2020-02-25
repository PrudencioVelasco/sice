<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("America/Mexico_City");
class Administrator extends CI_Controller {
 
 
	public function index()
	{ 
		$this->load->view('loginadmin'); 

	} 
}
