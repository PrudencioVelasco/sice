<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Materia_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function __destruct() {
        $this->db->close();
    }

   
      public function showAll($idplantel = '') {
        $this->db->select('m.idmateria, m.nombreclase, e.idespecialidad, e.nombreespecialidad, n.idnivelestudio, n.nombrenivel');
        $this->db->from('tblmateria m'); 
        $this->db->join('tblnivelestudio n ', ' n.idnivelestudio = m.idnivelestudio'); 
        $this->db->join('tblespecialidad e ', ' m.idespecialidad = e.idespecialidad');  
        if (isset($idplantel) && !empty($idplantel)) {
        $this->db->where('m.idplantel',$idplantel); 
        }   
        $this->db->order_by('m.nombreclase DESC');
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
     public function showAllEspecialidades($idplantel = '') {
        $this->db->select('e.*');
        $this->db->from('tblespecialidad e');  
        if (isset($idplantel) && !empty($idplantel)) {
        $this->db->where('e.idplantel',$idplantel);
        }
         $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
         public function showAllYears() {
        $this->db->select('m.*');
        $this->db->from('tblyear m');  
         $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function validarAddMateria($idnivelestudio = '', $idespecialidad = '', $nombreclase= '',$idplantel = '') {
        $this->db->select('m.*');
        $this->db->from('tblmateria m');
        $this->db->where('m.idnivelestudio',$idnivelestudio);
        $this->db->where('m.idespecialidad',$idespecialidad);
        $this->db->where('m.nombreclase',$nombreclase); 
        if (isset($idplantel) && !empty($idplantel)) {
        $this->db->where('p.idplantel',$idplantel);
        }
         $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
       public function validarUpdateMateria($idmateria = '', $idnivelestudio = '', $idespecialidad= '', $nombreclase = '',$idplantel = '') {
        $this->db->select('m.*');
        $this->db->from('tblmateria m');
        $this->db->where('m.idnivelestudio',$idnivelestudio);
        $this->db->where('m.idespecialidad',$idespecialidad);
        $this->db->where('m.nombreclase',$nombreclase); 
        $this->db->where('m.idmateria !=',$idmateria);
         if (isset($idplantel) && !empty($idplantel)) {
        $this->db->where('m.idplantel',$idplantel);
        }
         $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
   

 
public function addMteria($data)
    {
        $this->db->insert('tblmateria', $data);
        $insert_id = $this->db->insert_id(); 
        return  $insert_id;
    }
 
public function deleteMateria($idmateria='')
{
    # code...
     $this->db->where('idmateria', $idmateria);
        $this->db->delete('tblmateria');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
}
        public function searchMateria($match,$idplantel = '') {
        $field = array(
                 'm.nombreclase',
                 'e.nombreespecialidad',
                 'n.nombrenivel'
        );
       $this->db->select('m.idmateria, m.nombreclase, e.idespecialidad, e.nombreespecialidad, n.idnivelestudio, n.nombrenivel');
        $this->db->from('tblmateria m'); 
        $this->db->join('tblnivelestudio n ', ' n.idnivelestudio = m.idnivelestudio'); 
        $this->db->join('tblespecialidad e ', ' m.idespecialidad = e.idespecialidad');  
        if (isset($idplantel) && !empty($idplantel)) {
        $this->db->where('m.idplantel',$idplantel); 
        }    
        $this->db->like('concat(' . implode(',', $field) . ')', $match);
        $this->db->order_by('m.nombreclase DESC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
 


public function updateMateria($id, $field)
    {
        $this->db->where('idmateria', $id);
        $this->db->update('tblmateria', $field);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
        
    } 
    public function updateHorario($id, $field)
    {
        $this->db->where('idperiodo', $id);
        $this->db->update('tblhorario', $field);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
        
    } 
    public function desactivarHorario($field)
    { 
        $this->db->update('tblhorario', $field);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
        
    } 
    public function desactivaCiclo($field)
    {
       // $this->db->where('idplaneacion', $id);
        $this->db->update('tblperiodo', $field);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
        
    } 
 
      

}
