<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Planificacion_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function __destruct() {
        $this->db->close();
    }

   
      public function showAll($idprofesor='',$idplantel = '') {
        $this->db->select("CONCAT(pro.nombre,' ',pro.apellidop,' ',pro.apellidom) as nombreprofesor,ne.nombrenivel, g.nombregrupo, m.nombreclase,"
                . "p.idhorariodetalle, p.idperiodo, p.idprofesor,p.idgrupo, p.bloque, DATE_FORMAT(p.fechaejecucion,'%d/%m/%Y') as fechaejecucion,"
                . "p.practicasociallenguaje, p.enfoque, p.ambito,p.competenciafavorece,p.tipotext ,p.aprendizajeesperado,p.propositodelproyecto,"
                . "p.produccionesdesarrolloproyecto, p.recursosdidacticos, p.indicadoresevaluacion, p.observacionesdocente, p.observacionescoordinador, p.idplanificacion");
        $this->db->from('tblplanificacion p');
        $this->db->join('tblprofesor_materia pm', 'p.idprofesor = pm.idprofesormateria');
        $this->db->join('tblprofesor pro', 'pro.idprofesor = pm.idprofesor');
        $this->db->join('tblmateria m', 'm.idmateria = pm.idmateria');
        $this->db->join('tblgrupo g', 'g.idgrupo = p.idgrupo');
        $this->db->join('tblnivelestudio ne', 'ne.idnivelestudio = g.idnivelestudio');
        $this->db->join('tblhorario_detalle hd', 'p.idhorariodetalle = hd.idhorariodetalle');
        $this->db->join('tblhorario h', 'h.idhorario = hd.idhorario');
        $this->db->join('tblperiodo pe', 'pe.idperiodo = h.idperiodo');
        $this->db->where('(pe.activo = 1 OR h.activo = 1)');
        $this->db->where('p.eliminado',0); 
        
        if(isset($idprofesor) && !empty($idprofesor)){
        $this->db->where('p.idusuario', $idprofesor);
        }
         if(isset($idplantel) && !empty($idplantel)){
            $this->db->where('pro.idplantel',$idplantel); 
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function addPlanificacion($data) {
        $this->db->insert('tblplanificacion', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function updatePlanificacion($id, $field) {
        $this->db->where('idplanificacion', $id);
        $this->db->update('tblplanificacion', $field);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
 public function searchPlanificacion($match, $idprofesor,$idplantel = '') {
        $field = array(
              "pro.nombre,' '",
              "pro.apellidop,' '",
              "pro.apellidom,' '",
            "ne.nombrenivel,' '",
            "g.nombregrupo,' '",
            "m.nombreclase,' '",
            "DATE_FORMAT(p.fechaejecucion,'%d/%m/%Y'),' '",
            "p.bloque"
        );
        $this->db->select("CONCAT(pro.nombre,' ',pro.apellidop,' ',pro.apellidom) as nombreprofesor,ne.nombrenivel, g.nombregrupo, m.nombreclase,"
                . "p.idhorariodetalle, p.idperiodo, p.idprofesor,p.idgrupo, p.bloque, DATE_FORMAT(p.fechaejecucion,'%d/%m/%Y') as fechaejecucion,"
                . "p.practicasociallenguaje, p.enfoque, p.ambito,p.competenciafavorece,p.tipotext ,p.aprendizajeesperado,p.propositodelproyecto,"
                . "p.produccionesdesarrolloproyecto, p.recursosdidacticos, p.indicadoresevaluacion, p.observacionesdocente, p.observacionescoordinador, p.idplanificacion");
        $this->db->from('tblplanificacion p');
        $this->db->join('tblprofesor_materia pm', 'p.idprofesor = pm.idprofesormateria');
        $this->db->join('tblprofesor pro', 'pro.idprofesor = pm.idprofesor');
        $this->db->join('tblmateria m', 'm.idmateria = pm.idmateria');
        $this->db->join('tblgrupo g', 'g.idgrupo = p.idgrupo');
        $this->db->join('tblnivelestudio ne', 'ne.idnivelestudio = g.idnivelestudio');
        $this->db->join('tblhorario_detalle hd', 'p.idhorariodetalle = hd.idhorariodetalle');
        $this->db->join('tblhorario h', 'h.idhorario = hd.idhorario');
        $this->db->join('tblperiodo pe', 'pe.idperiodo = h.idperiodo');
        $this->db->where('(pe.activo = 1 OR h.activo = 1)');
        $this->db->where('p.eliminado',0); 
        if(isset($idprofesor) && !empty($idprofesor)){
        $this->db->where('p.idusuario', $idprofesor);
        }
          if(isset($idplantel) && !empty($idplantel)){
        $this->db->where('pro.idplantel', $idplantel);
        }
        $this->db->like('concat(' . implode(',', $field) . ')', $match);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    } 
}
