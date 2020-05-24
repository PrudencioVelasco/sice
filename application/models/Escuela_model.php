<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Escuela_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function __destruct() {
        $this->db->close();
    }

  
    public function showAll() {
        $this->db->select('p.*');
        $this->db->from('tblplantel p'); 
        $this->db->where('p.idplantel NOT IN (2)'); 
         $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    } 
  
    public function validarAddEscuela($clave)
    {
        $this->db->select('p.*');    
        $this->db->from('tblplantel p'); 
        $this->db->where('p.clave', $clave); 
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function validarUpdateEscuela($clave = '', $idplantel = '')
    {
        $this->db->select('p.*');    
        $this->db->from('tblplantel p'); 
        $this->db->where('p.clave', $clave);
        $this->db->where('p.idplantel !=', $idplantel); 
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

 public function deleteEscuela($id)
    {
        $this->db->where('idplantel', $id);
        $this->db->delete('tblplantel');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
        
    }

        public function searchEscuela($match) {
        $field = array(
                 'p.clave',
                 'p.nombreplantel',
                 'p.direccion',
                 'p.telefono',
                 'p.director'
        );
         $this->db->select('p.*');
         $this->db->from('tblplantel p'); 
         $this->db->where('p.idplantel NOT IN (2)'); 
        $this->db->like('concat(' . implode(',', $field) . ')', $match);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
   
     public function addEscuela($data)
    {
        $this->db->insert('tblplantel', $data);
        $insert_id = $this->db->insert_id(); 
        return  $insert_id;
    }
    
       public function detalleEscuela()
    {
        $this->db->select('t.*');
        $this->db->from('tblinstitucion t'); 
        $query = $this->db->get();
      if ($this->db->affected_rows() > 0) {
            return $query->first_row();
        } else {
            return false;
        }
       
    }
    
    public function updateEscuela($id, $field)
    {
        $this->db->where('idplantel', $id);
        $this->db->update('tblplantel', $field);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
        
    }

      

}
