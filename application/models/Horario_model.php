<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Horario_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function __destruct() {
        $this->db->close();
    }

  
    public function showAll($idplantel = '') {
        $this->db->select('h.idhorario,h.idperiodo,h.idgrupo,m.nombremes as mesinicio,m2.nombremes as mesfin,y.nombreyear as yearinicio,y2.nombreyear as yearfin,ne.nombrenivel,g.nombregrupo,h.activo, t.idturno, t.nombreturno, p.activo as periodoactivo, e.idespecialidad, e.nombreespecialidad');    
        $this->db->from('tblhorario h');
        $this->db->join('tblperiodo p', 'p.idperiodo = h.idperiodo');
        $this->db->join('tblgrupo g', 'g.idgrupo = h.idgrupo'); 
        $this->db->join('tblnivelestudio ne', 'g.idnivelestudio = ne.idnivelestudio'); 
          $this->db->join('tblespecialidad e', 'e.idespecialidad = g.idespecialidad'); 
        $this->db->join('tblturno t', 't.idturno = g.idturno'); 
        $this->db->join('tblmes m ', ' p.idmesinicio = m.idmes'); 
        $this->db->join('tblmes m2 ', ' p.idmesfin = m2.idmes'); 
        $this->db->join('tblyear y ', ' p.idyearinicio = y.idyear');
        $this->db->join('tblyear y2 ', ' p.idyearfin = y2.idyear'); 
          if(!empty($idplantel)){
        $this->db->where('h.idplantel',$idplantel);
        } 
        $this->db->order_by('h.idhorario DESC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    } 
     public function validarAddHorario($idperiodo = '',$idgrupo = '',$idplantel = '') {
        $this->db->select('h.*');    
        $this->db->from('tblhorario h');
        $this->db->where('h.idperiodo', $idperiodo); 
         $this->db->where('h.idgrupo', $idgrupo); 
          if(!empty($idplantel)){
        $this->db->where('h.idplantel',$idplantel);
        } 
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function validarActivoHorario($idhorario = '',$idplantel = '') {
        $this->db->select('h.*');    
        $this->db->from('tblhorario h');
        $this->db->where('h.idhorario', $idhorario); 
          if(!empty($idplantel)){
        $this->db->where('h.idplantel',$idplantel);
        } 
         $this->db->where('h.activo', 1 ); 
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
     public function validarActivoCicloEscolar($idhorario = '',$idplantel = '') {
        $this->db->select('h.*');    
        $this->db->from('tblhorario h');
        $this->db->where('h.idhorario', $idhorario); 
        $this->db->join('tblperiodo p', 'p.idperiodo = h.idperiodo'); 
        $this->db->where('p.activo', 1 ); 
          if(!empty($idplantel)){
        $this->db->where('h.idplantel',$idplantel);
        } 
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
       public function validarUpdateHorario($idperiodo = '',$idgrupo = '',$idhorario = '', $idplantel = '') {
        $this->db->select('h.*');    
        $this->db->from('tblhorario h');
        $this->db->where('h.idperiodo', $idperiodo); 
        $this->db->where('h.idgrupo', $idgrupo); 
         $this->db->where('h.idhorario !=', $idhorario); 
           if(!empty($idplantel)){
        $this->db->where('h.idplantel',$idplantel);
        } 
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    } 

    public function showAllDiaHorario($idhorario,$iddia)
    {
        $query =$this->db->query("SELECT * FROM vhorarioclases WHERE idhorario= $idhorario AND (iddia = $iddia OR iddia ='Todos') ORDER BY horainicial ASC");
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
  

      public function calificacionGeneralAlumno($idhorario,$idalumno)
    {
        $query =$this->db->query("SELECT 
                                    SUM(c.calificacion) AS calificaciongeneral
                                FROM
                                    tblcalificacion c 
                                WHERE
                                    c.idalumno = $idalumno AND c.idhorario = $idhorario
                                GROUP BY c.idalumno");
        if ($query->num_rows() > 0) {
            return $query->first_row();
        } else {
            return false;
        }
    }
        public function calificacionFinalAlumno($idalumno)
    {
        $query =$this->db->query("SELECT 
                                    SUM(c.calificacion) / COUNT(c.idhorariodetalle) AS calificaciongeneral
                                FROM
                                    tblcalificacion c
                                        INNER JOIN
                                    tblhorario_detalle hd ON c.idhorariodetalle = hd.idhorariodetalle
                                        INNER JOIN
                                    tblprofesor_materia pm ON pm.idprofesormateria = hd.idmateria
                                WHERE
                                    c.idalumno = $idalumno 
                                GROUP BY c.idalumno");
        if ($query->num_rows() > 0) {
            return $query->first_row();
        } else {
            return false;
        }
    }

    public function showAllMaterias($idplantel = '')
    {
        # code...
        $this->db->select('pm.idprofesormateria, m.nombreclase, p.nombre, p.apellidop, p.apellidom');    
        $this->db->from('tblprofesor_materia pm');
        $this->db->join('tblmateria m', 'pm.idmateria = m.idmateria');
        $this->db->join('tblprofesor p', 'pm.idprofesor = p.idprofesor'); 
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


   public function showAllDias()
    {
        $this->db->select('d.*');
        $this->db->from('tbldia d');  
         $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
     public function showAllGrupos($idplantel = '')
    {
        # code...
        $this->db->select('n.nombrenivel,g.nombregrupo, e.idespecialidad, e.nombreespecialidad, g.idgrupo, t.idturno, t.nombreturno');    
        $this->db->from('tblgrupo g');
        $this->db->join('tblnivelestudio n', 'g.idnivelestudio = n.idnivelestudio'); 
        $this->db->join('tblturno t', 't.idturno = g.idturno'); 
         $this->db->join('tblespecialidad e', 'e.idespecialidad = g.idespecialidad'); 
        if (isset($idplantel) && !empty($idplantel)) {
        $this->db->where('g.idplantel',$idplantel);
           } 
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
     public function showAllPeriodos($idplantel = '')
    {
       $this->db->select('p.idperiodo,m.nombremes as mesinicio,m2.nombremes as mesfin,y.nombreyear as yearinicio,y2.nombreyear as yearfin');
        $this->db->from('tblperiodo p'); 
        $this->db->join('tblmes m ', ' p.idmesinicio = m.idmes'); 
        $this->db->join('tblmes m2 ', ' p.idmesfin = m2.idmes'); 
        $this->db->join('tblyear y ', ' p.idyearinicio = y.idyear');
        $this->db->join('tblyear y2 ', ' p.idyearfin = y2.idyear');
        if (isset($idplantel) && !empty($idplantel)) {
        $this->db->where('p.idplantel',$idplantel);
           }   
        $this->db->where('p.activo',1);  
         $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }



     public function addHorario($data)
    {
        $this->db->insert('tblhorario', $data);
        $insert_id = $this->db->insert_id(); 
        return  $insert_id;
    }
        public function addHoraSinClase($data)
    {
        $this->db->insert('tblhora_sinclase', $data);
        $insert_id = $this->db->insert_id(); 
        return  $insert_id;
    }
      public function addReceso($data)
    {
        $this->db->insert('tbldescanzo', $data);
        $insert_id = $this->db->insert_id(); 
        return  $insert_id;
    }
      public function updateReceso($id, $field)
    {
        $this->db->where('iddescanzo', $id);
        $this->db->update('tbldescanzo', $field);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
        
    }
     public function addMateriaHorario($data)
    {
        $this->db->insert('tblhorario_detalle', $data);
        $insert_id = $this->db->insert_id(); 
        return  $insert_id;
    }
    
     public function updateHorario($id, $field)
    {
        $this->db->where('idhorario', $id);
        $this->db->update('tblhorario', $field);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
        
    }
    
    public function updateHorarioMateria($id, $field)
    {
        $this->db->where('idhorariodetalle', $id);
        $this->db->update('tblhorario_detalle', $field);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
        
    }
      public function updateHoraSinClase($id, $field)
    {
        $this->db->where('idhorasinclase', $id);
        $this->db->update('tblhora_sinclase', $field);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
        
    }

    public function showAllMateriasProfesor($idprofesor)
    {
        $this->db->select('m.nombreclase, m.idmateria, pm.idprofesormateria');    
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
     public function showNivelGrupo($idhorario)
    {
        $this->db->select('m.nombremes as mesinicio,m2.nombremes as mesfin,y.nombreyear as yearinicio,y2.nombreyear as yearfin, g.nombregrupo, n.nombrenivel, t.nombreturno');
        $this->db->from('tblperiodo p');
        $this->db->join('tblhorario h', 'h.idperiodo = p.idperiodo');
        $this->db->join('tblgrupo g', 'g.idgrupo = h.idgrupo');
        $this->db->join('tblnivelestudio n', 'n.idnivelestudio = g.idnivelestudio');
        $this->db->join('tblturno t', 'g.idturno = t.idturno');
         $this->db->join('tblmes m ', ' p.idmesinicio = m.idmes'); 
        $this->db->join('tblmes m2 ', ' p.idmesfin = m2.idmes'); 
        $this->db->join('tblyear y ', ' p.idyearinicio = y.idyear');
        $this->db->join('tblyear y2 ', ' p.idyearfin = y2.idyear');  
        $this->db->where('h.idhorario', $idhorario); 
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
             return $query->first_row();
        } else {
            return false;
        }
    }

 public function deleteHorarioMateria($id)
    {
        $this->db->where('idhorariodetalle', $id);
        $this->db->delete('tblhorario_detalle');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
        
    }
     public function deleteHorario($id)
    {
        $this->db->where('idhorario', $id);
        $this->db->delete('tblhorario');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
        
    }
         public function deleteSinClases($id)
    {
        $this->db->where('idhorasinclase', $id);
        $this->db->delete('tblhora_sinclase');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
        
    }
public function deleteReceso($id)
    {
        $this->db->where('iddescanzo', $id);
        $this->db->delete('tbldescanzo');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
        
    }

public function searchHorario($match, $idplantel = '') {
        $field = array(
                 'm.nombremes',
                 'y.nombreyear',
                 'm2.nombremes',
                 'y2.nombreyear',
                 'ne.nombrenivel',
                 'g.nombregrupo',
                 'h.activo',
                 't.nombreturno',
                 'e.nombreespecialidad'
        );
       $this->db->select('h.idhorario,h.idperiodo,h.idgrupo,m.nombremes as mesinicio,m2.nombremes as mesfin,y.nombreyear as yearinicio,y2.nombreyear as yearfin,ne.nombrenivel,g.nombregrupo,h.activo, t.idturno, t.nombreturno, p.activo as periodoactivo, e.idespecialidad, e.nombreespecialidad');    
        $this->db->from('tblhorario h');
        $this->db->join('tblperiodo p', 'p.idperiodo = h.idperiodo');
        $this->db->join('tblgrupo g', 'g.idgrupo = h.idgrupo'); 
        $this->db->join('tblnivelestudio ne', 'g.idnivelestudio = ne.idnivelestudio'); 
          $this->db->join('tblespecialidad e', 'e.idespecialidad = g.idespecialidad'); 
        $this->db->join('tblturno t', 't.idturno = g.idturno'); 
        $this->db->join('tblmes m ', ' p.idmesinicio = m.idmes'); 
        $this->db->join('tblmes m2 ', ' p.idmesfin = m2.idmes'); 
        $this->db->join('tblyear y ', ' p.idyearinicio = y.idyear');
        $this->db->join('tblyear y2 ', ' p.idyearfin = y2.idyear'); 
          if(!empty($idplantel)){
        $this->db->where('h.idplantel',$idplantel);
        } 
        $this->db->order_by('h.idhorario DESC');
        $this->db->like('concat(' . implode(',', $field) . ')', $match);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

      

}
