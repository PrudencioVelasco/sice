<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pagos_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function __destruct() {
        $this->db->close();
    }

   
    public function showAll() {
        $this->db->select('m.*');
        $this->db->from('tblmes m');  
         $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
       
 
      

}
