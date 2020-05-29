<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Colegiatura_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function __destruct() {
        $this->db->close();
    }

  
    public function showAll($idplantel = '') {
        $this->db->select('c.idcolegiatura, c.descuento,p.nombreplantel, c.idnivelestudio, n.nombrenivel, c.activo, c.idtipopagocol, tp.concepto');
        $this->db->from('tblcolegiatura c'); 
        $this->db->join('tblplantel p', 'p.idplantel = c.idplantel');
        $this->db->join('tblnivelestudio n', 'n.idnivelestudio = c.idnivelestudio');
        $this->db->join('tbltipopagocol tp', 'tp.idtipopagocol = c.idtipopagocol');
        if (isset($idplantel) && !empty($idplantel)) {
        $this->db->where('c.idplantel',$idplantel); 
        }   
        $this->db->where('c.eliminado',0);
         $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    } 
     public function showAllNiveles() {
        $this->db->select('n.*');
        $this->db->from('tblnivelestudio n'); 
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    } 
 
    public function showAllConceptos() {
        $this->db->select('n.*');
        $this->db->from('tbltipopagocol n'); 
        $this->db->where('n.activo',1); 
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function detalleColegiatura($idcolegiatura) {
        $this->db->select('c.*');
        $this->db->from('tblcolegiatura c'); 
        $this->db->where('c.idcolegiatura',$idcolegiatura); 
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
        public function searchColegiatura($match) {
        $field = array(
                 'c.descuento',
                 'p.nombreplantel',
                 'n.nombrenivel',
                 'tp.concepto',
                 'c.activo'
        );
       $this->db->select('c.idcolegiatura, c.descuento,p.nombreplantel, c.idnivelestudio, n.nombrenivel, c.activo, c.idtipopagocol, tp.concepto');
        $this->db->from('tblcolegiatura c'); 
        $this->db->join('tblplantel p', 'p.idplantel = c.idplantel');
        $this->db->join('tblnivelestudio n', 'n.idnivelestudio = c.idnivelestudio');
        $this->db->join('tbltipopagocol tp', 'tp.idtipopagocol = c.idtipopagocol'); 
        //$this->db->where('c.idplantel',$this->session->idplantel);  
        $this->db->where('c.eliminado',0);
        $this->db->like('concat(' . implode(',', $field) . ')', $match);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
   
     public function addColegiatura($data)
    {
        $this->db->insert('tblcolegiatura', $data);
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
    
    public function desactivarColegiatura($idconcepto = '',$idnivel = '',$idplantel = ' ', $field)
    {
        $this->db->where('idplantel', $idplantel);
        $this->db->where('idnivelestudio', $idnivel);
        $this->db->where('idtipopagocol', $idconcepto);
        $this->db->update('tblcolegiatura', $field);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
        
    }
        public function updateColegiatura($idcolegiatura = '', $field)
    {
        $this->db->where('idcolegiatura', $idcolegiatura);
        $this->db->update('tblcolegiatura', $field);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
        
    }

      

}
