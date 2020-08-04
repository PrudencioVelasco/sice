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

    public function unidades($idplantel = '') {
        $this->db->select('u.idunidad, u.nombreunidad');
        $this->db->from('tblunidad u');
        if (isset($idplantel) && !empty($idplantel)) {
            $this->db->where('u.idplantel', $idplantel);
        }
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->result();
        } else {
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

    public function obtenerCalificacion($idalumno = '', $idunidad = '', $idhorariodetalle = '') {
        $this->db->select('c.idcalificacion, c.calificacion');
        $this->db->from('tblcalificacion c');
        $this->db->join('tblunidad u', 'c.idunidad = u.idunidad');
        $this->db->where('c.idalumno', $idalumno);
        $this->db->where('c.idhorariodetalle', $idhorariodetalle);
        $this->db->where('c.idunidad', $idunidad);
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->first_row();
        } else {
            return false;
        }
    }

    public function listaAlumnoPorGrupo($idgrupo = '', $idplantel = '', $idperiodo = '') {
        $query = $this->db->query("SELECT * FROM vlistaalumnogrupo WHERE idplantel = $idplantel AND idgrupo = $idgrupo AND idperiodo = $idperiodo  ORDER BY apellidop DESC");
        //  return $query->result();

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function showAllMateriasRecuperando($idhorario, $idalumno, $idperiodo) {
        $query = $this->db->query("SELECT   idnivelestudio, idprofesormateria,
    idhorariodetalle,
    idhorario,
    horainicial,
    horafinal,
    nombreclase,
    nombre,
    apellidop,
    apellidom,
    idmateria, 
    opcion,
     idgrupo,
    credito 
    FROM (
SELECT 
    g.idnivelestudio,
    hd.idmateria AS idprofesormateria,
    hd.idhorariodetalle,
    hd.idhorario,
    hd.horainicial,
    hd.horafinal,
    m.nombreclase,
    p.nombre,
    p.apellidop,
    p.apellidom,
    m.idmateria,
    0 AS opcion,
    m.credito,
      g.idgrupo
FROM
    tblmateria_reprobada mr
        INNER JOIN
    tbldetalle_reprobada dr ON mr.idreprobada = dr.idreprobada
        INNER JOIN
    tblhorario_detalle hd ON dr.idprofesormateria = hd.idmateria
        INNER JOIN
    tblhorario h ON h.idhorario = hd.idhorario
        INNER JOIN
    tblperiodo pe ON h.idperiodo = pe.idperiodo
        JOIN
    tblprofesor_materia pm ON hd.idmateria = pm.idprofesormateria
        JOIN
    tblmateria m ON m.idmateria = pm.idmateria
        JOIN
    tblprofesor p ON p.idprofesor = pm.idprofesor
        JOIN
    tblalumno_grupo ag ON ag.idalumnogrupo = mr.idalumnogrupo
    JOIN tblgrupo g ON g.idgrupo = h.idgrupo
    AND h.idperiodo = $idperiodo
    AND ag.idalumno = $idalumno
    AND h.idhorario IN ($idhorario)) tabla");
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    
        public function calificacionMateria($idhorario, $idalumno, $idmateria = '') {
        $query = $this->db->query(" SELECT 
    FORMAT((SUM(c.calificacion) / COUNT(c.idunidad)),
        2) AS calificacion,
        oe.numero 
FROM
    tblhorario h
        INNER JOIN
    tblhorario_detalle hd ON h.idhorario = hd.idhorario
        INNER JOIN
    tblcalificacion c ON c.idhorariodetalle = hd.idhorariodetalle
        INNER JOIN
    tbloportunidad_examen oe ON c.idoportunidadexamen = oe.idoportunidadexamen
    WHERE c.idalumno = $idalumno AND h.idhorario =$idhorario AND hd.idmateria = $idmateria
GROUP BY c.idoportunidadexamen , hd.idmateria , c.idalumno, h.idhorario, oe.numero
ORDER BY    oe.numero DESC");
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    
    

}
