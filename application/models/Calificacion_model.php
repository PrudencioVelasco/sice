<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Calificacion_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function __destruct() {
        $this->db->close();
    }

       public function unidades($idplantel = '')
        { 
            $this->db->select('u.idunidad, u.nombreunidad');
            $this->db->from('tblunidad u');   
            $this->db->where('u.idplantel',$idplantel);   
            $query = $this->db->get();
            if ($this->db->affected_rows() > 0) {
                return $query->result();
            }else{
                return false;
            }
        }
       public function showAllMateriasAlumno($idalumno = '') {
            $this->db->select('pe.idperiodo, hd.idhorariodetalle,ma.nombreclase,p.nombre, p.apellidop, p.apellidom, g.nombregrupo,ne.nombrenivel, g.idgrupo, h.idhorario,m.nombremes as mesinicio,m2.nombremes as mesfin,y.nombreyear as yearinicio,y2.nombreyear as yearfin, pla.nombreplantel,pla.asociado, pla.direccion, pla.telefono, a.matricula, ho.idhorario');
            $this->db->from('tblhorario_detalle hd'); 
            $this->db->join('tblprofesor_materia pm', 'pm.idprofesormateria = hd.idmateria');
            $this->db->join('tblprofesor p', 'p.idprofesor = pm.idprofesor');
            $this->db->join('tblmateria ma', 'ma.idmateria = pm.idmateria'); 
            $this->db->join('tblhorario h', 'hd.idhorario = h.idhorario');
            $this->db->join('tblplantel pla', 'pla.idplantel = h.idplantel');
            $this->db->join('tblgrupo g', 'g.idgrupo = h.idgrupo');
            $this->db->join('tblnivelestudio ne', 'ne.idnivelestudio = g.idnivelestudio');
            $this->db->join('tblperiodo pe', 'pe.idperiodo = h.idperiodo');
            $this->db->join('tblmes m ', ' pe.idmesinicio = m.idmes'); 
            $this->db->join('tblmes m2 ', ' pe.idmesfin = m2.idmes'); 
            $this->db->join('tblyear y ', ' pe.idyearinicio = y.idyear');
            $this->db->join('tblyear y2 ', ' pe.idyearfin = y2.idyear');  
            $this->db->join('tblhorario ho', 'ho.idhorario = hd.idhorario');
            $this->db->join('tblalumno_grupo ag', 'ag.idgrupo = g.idgrupo');
            $this->db->join('tblalumno a', 'a.idalumno = ag.idalumno');
            $this->db->where('a.idalumno', $idalumno);
            $this->db->where('(pe.activo = 1 or ho.activo = 1)');
            $this->db->where('(pe.idperiodo = ag.idperiodo)');
            $this->db->group_by('ma.idmateria');
            $this->db->group_by('h.idgrupo');
            $this->db->order_by('ne.nombrenivel asc');
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                return $query->result();
            } else {
                return false;
            }
    }
        public function obtenerCalificacion($idalumno='',$idunidad = '', $idhorariodetalle = '')
        { 
                $this->db->select('c.idcalificacion, c.calificacion');
                $this->db->from('tblcalificacion c');   
                $this->db->join('tblunidad u', 'c.idunidad = u.idunidad'); 
                $this->db->where('c.idalumno', $idalumno);  
                $this->db->where('c.idhorariodetalle', $idhorariodetalle); 
                $this->db->where('c.idunidad', $idunidad); 
                $query = $this->db->get();
                if ($this->db->affected_rows() > 0) {
            return $query->first_row();
                }else{
                    return false;
                }

        }

}
