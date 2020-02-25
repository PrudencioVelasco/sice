<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Profesor_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function __destruct() {
        $this->db->close();
    }

  
    public function showAll($idplantel = '') {
        $this->db->select('t.*');
        $this->db->from('tblprofesor t'); 
        if (isset($idplantel) && !empty($idplantel)) {
        $this->db->where('t.idplantel',$idplantel); 
        }  
         $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    } 
     public function showAllClases($idplantel = '') {
        $this->db->select('m.*');
        $this->db->from('tblmateria m'); 
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
     public function validarCedula($cedula = '',$idprofesor, $idplantel = '') {
        $this->db->select('p.*');
        $this->db->from('tblprofesor p'); 
        $this->db->where('p.cedula',$cedula); 
        if(isset($idprofesor) && !empty($idprofesor)){
        $this->db->where('p.idprofesor !=',$idprofesor);  
        }
         if(isset($idplantel) && !empty($idplantel)){
        $this->db->where('p.idplantel',$idplantel);  
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    } 
     public function validarMateriaProfesor($idprofesor = '',$idmateria) {
        $this->db->select('p.*');
        $this->db->from('tblprofesor_materia p');  
        $this->db->where('p.idprofesor',$idprofesor);  
        $this->db->where('p.idmateria',$idmateria);   
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    } 
     public function validarMateriaProfesorUpdate($idprofesor = '', $idmateria,$idprofesormateria) {
        $this->db->select('p.*');
        $this->db->from('tblprofesor_materia p');  
        $this->db->where('p.idprofesor',$idprofesor); 
        $this->db->where('p.idprofesormateria !=',$idprofesormateria);  
        $this->db->where('p.idmateria',$idmateria);   
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    } 






        public function searchProfesor($match,$idplantel = '') {
        $field = array(
                 't.nombre',
                 't.apellidop',
                 't.apellidom',
                 't.cedula'
        );
         $this->db->select('t.*');
        $this->db->from('tblprofesor t'); 
        if (isset($idplantel) && !empty($idplantel)) {
            $this->db->where('t.idplantel',$idplantel);
        }
        $this->db->like('concat(' . implode(',', $field) . ')', $match);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
       public function searchMaterias($match,$idprofesor) {
        $field = array(
                 'm.nombreclase'
        );
         $this->db->select('m.*');    
        $this->db->from('tblmateria m');
        $this->db->join('tblprofesor_materia pm', 'pm.idmateria = m.idmateria');
        $this->db->where('pm.idprofesor', $idprofesor);
        $this->db->like('concat(' . implode(',', $field) . ')', $match);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
   
     public function addProfesor($data)
    {
        $this->db->insert('tblprofesor', $data);
        $insert_id = $this->db->insert_id(); 
        return  $insert_id;
    }
    public function addMateria($data)
    {
        $this->db->insert('tblprofesor_materia', $data);
        $insert_id = $this->db->insert_id(); 
        return  $insert_id;
    }
    
       public function detalleProfesor($idprofesor)
    {
        $this->db->select('t.*');
        $this->db->from('tblprofesor t'); 
        $this->db->where('t.idprofesor', $idprofesor);
        $query = $this->db->get();

        return $query->first_row();
    }
    
    public function updateProfesor($id, $field)
    {
        $this->db->where('idprofesor', $id);
        $this->db->update('tblprofesor', $field);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
        
    }
    public function updateMateria($id, $field)
    {
        $this->db->where('idprofesormateria', $id);
        $this->db->update('tblprofesor_materia', $field);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
        
    }

 public function deleteMateria($id)
    {
        $this->db->where('idprofesormateria', $id);
        $this->db->delete('tblprofesor_materia');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
        
    }
     public function deleteProfesor($id)
    {
        $this->db->where('idprofesor', $id);
        $this->db->delete('tblprofesor');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
        
    }

    public function showTareas($idprofesor,$fechaentrega) {
        $this->db->select('hd.idhorariodetalle,hd.idhorario, hd.horainicial, hd.horafinal, m.nombreclase,p.nombre, p.apellidop, p.apellidom,t.tarea, t.fechaentrega,p.idprofesor,g.nombregrupo,ne.nombrenivel,tu.nombreturno');
        $this->db->from('tblhorario_detalle hd'); 
        $this->db->join('tblprofesor_materia pm', 'hd.idmateria = pm.idprofesormateria');
        $this->db->join('tblmateria m', 'm.idmateria = pm.idmateria');
        $this->db->join('tblprofesor p', 'p.idprofesor = pm.idprofesor');
        $this->db->join('tbltarea t', 't.idhorariodetalle = hd.idhorariodetalle');
        $this->db->join('tblhorario h', 'hd.idhorario = h.idhorario');
        $this->db->join('tblgrupo g', 'g.idgrupo = h.idgrupo');
        $this->db->join('tblnivelestudio ne', 'ne.idnivelestudio = g.idnivelestudio');
        $this->db->join('tblturno tu', 'tu.idturno = g.idturno');
        $this->db->where('p.idprofesor', $idprofesor); 
        $this->db->where('h.activo', 1); 
        $this->db->where("t.fechaentrega >= '$fechaentrega'"); 
         $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
        public function showPlaneaciones($idprofesor,$fechafin) {
        $this->db->select('hd.idhorariodetalle,hd.idhorario, hd.horainicial, hd.horafinal, m.nombreclase,p.nombre, p.apellidop, p.apellidom,p.idprofesor,g.nombregrupo,ne.nombrenivel,tu.nombreturno,pl.planeacion,pl.fechainicio, pl.fechafin, u.nombreunidad');
        $this->db->from('tblhorario_detalle hd'); 
        $this->db->join('tblprofesor_materia pm', 'hd.idmateria = pm.idprofesormateria');
        $this->db->join('tblmateria m', 'm.idmateria = pm.idmateria');
        $this->db->join('tblprofesor p', 'p.idprofesor = pm.idprofesor');
        $this->db->join('tblplaneacion pl', 'pl.iddetallehorario  = hd.idhorariodetalle');
        $this->db->join('tblunidad u', 'pl.idunidad = u.idunidad');
        $this->db->join('tblhorario h', 'hd.idhorario = h.idhorario');
        $this->db->join('tblgrupo g', 'g.idgrupo = h.idgrupo');
        $this->db->join('tblnivelestudio ne', 'ne.idnivelestudio = g.idnivelestudio');
        $this->db->join('tblturno tu', 'tu.idturno = g.idturno');
        $this->db->where('p.idprofesor', $idprofesor); 
        $this->db->where('h.activo', 1); 
        $this->db->where("pl.fechafin >= '$fechafin'"); 
         $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    } 
    public function showAllMateriasProfesor($idprofesor)
    {
        $this->db->select('m.nombreclase, m.idmateria, pm.idprofesor, pm.idprofesormateria');    
        $this->db->from('tblmateria m');
        $this->db->join('tblprofesor_materia pm', 'pm.idmateria = m.idmateria');
        $this->db->where('pm.idprofesor', $idprofesor); 
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

      

}
