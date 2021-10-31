<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Promover_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function __destruct()
    {
        $this->db->close();
    }
    public function calificacionAlumnoParaPromover($idalumno, $idgrupo, $idhorario)
    {
        $sql = "SELECT
        idalumno,
        nombreprofesor,
        nombreclase,
        calificacion,
        unidadesxmateria ,
        unidadescalificadas ,
        unidades,
        idhorario,
        idgrupo,
        idoportunidadexamen,
        numero ,
        idmateria
    FROM
        (
        SELECT
            c.idalumno ,
            m.nombreclase, 
            CASE 
                WHEN pla.idniveleducativo = 5 THEN 
                SUM(c.calificacion) / m.unidades 
                ELSE SUM(c.calificacion) /  (SELECT
                 COUNT(u.idunidad)
            FROM
                tblunidad u
            WHERE
                u.idplantel = a.idplantel) END AS calificacion ,
            m.unidades as unidadesxmateria,
            COUNT(c.idunidad) AS unidadescalificadas ,
            (
            SELECT
                COUNT(u.idunidad)
            FROM
                tblunidad u
            WHERE
                u.idplantel = a.idplantel) AS unidades,
                CONCAT(p.apellidop,' ',p.apellidom,' ',p.nombre) as nombreprofesor,
                h.idhorario,
                h.idgrupo,
                oe.idoportunidadexamen,
                oe.numero,
                hd.idmateria 
        FROM
            tblcalificacion c
        INNER JOIN tblhorario_detalle hd ON
            c.idhorariodetalle = hd.idhorariodetalle
        INNER JOIN tblalumno a ON
            a.idalumno = c.idalumno
        INNER JOIN tblhorario h ON
            h.idhorario = hd.idhorario
        INNER JOIN tblprofesor_materia pm ON
            pm.idprofesormateria = hd.idmateria
        INNER JOIN tblmateria m ON
            m.idmateria = pm.idmateria
        INNER JOIN tblprofesor p ON
            p.idprofesor = pm.idprofesor
        INNER JOIN tbloportunidad_examen oe ON
            oe.idoportunidadexamen = c.idoportunidadexamen 
        INNER JOIN tblplantel pla ON pla.idplantel = a.idplantel 
        WHERE  m.idclasificacionmateria NOT IN (3)
            AND m.secalifica = 1
        GROUP BY
            c.idalumno,
            hd.idmateria,
            h.idhorario,
            h.idgrupo,
            hd.idmateria,
            oe.idoportunidadexamen 
    UNION ALL
        SELECT
            c.idalumno ,
            m.nombreclase,
                CASE 
                WHEN pla.idniveleducativo = 5 THEN 
                SUM(c.calificacion) / m.unidades 
                ELSE SUM(c.calificacion) /  (SELECT
                 COUNT(u.idunidad)
            FROM
                tblunidad u
            WHERE
                u.idplantel = a.idplantel) END AS calificacion ,
            m.unidades as unidadesxmateria,
            COUNT(c.idunidad) AS unidadescalificadas ,
            (
            SELECT
                COUNT(u.idunidad)
            FROM
                tblunidad u
            WHERE
                u.idplantel = a.idplantel) AS unidades,
                CONCAT(p.apellidop,' ',p.apellidom,' ',p.nombre) as nombreprofesor ,
                h.idhorario ,
                h.idgrupo,
                oe.idoportunidadexamen , 
                oe.numero ,
                hd.idmateria 
        FROM
            tblcalificacion c
        INNER JOIN tblhorario_detalle hd ON
            c.idhorariodetalle = hd.idhorariodetalle
        INNER JOIN tblalumno a ON
            a.idalumno = c.idalumno
        INNER JOIN tblhorario h ON
            h.idhorario = hd.idhorario
        INNER JOIN tblprofesor_materia pm ON
            pm.idprofesormateria = hd.idmateria
        INNER JOIN tblmateria m ON
            m.idmateria = pm.idmateria
        INNER JOIN tblprofesor p ON
            p.idprofesor = pm.idprofesor
        INNER JOIN tblhorario_detalle_cursos hdc ON
            hdc.idprofesormateria = hd.idmateria
        INNER JOIN tbloportunidad_examen oe ON
            oe.idoportunidadexamen = c.idoportunidadexamen 
            
        INNER JOIN tblplantel pla ON pla.idplantel = a.idplantel 
        WHERE
            hd.idhorario = hdc.idhorario
            AND c.idalumno = hdc.idalumno 
        GROUP BY
            c.idalumno,
            hd.idmateria,
            h.idhorario,
            h.idgrupo,
            hd.idmateria,
            oe.idoportunidadexamen) tabla
            WHERE calificacion > 0
            AND idalumno  = $idalumno
            AND idhorario = $idhorario
            AND idgrupo = $idgrupo
        ORDER BY numero DESC";

        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function obtenerDetalleGrupo($idgrupo = '')
    {
        $this->db->select('ne.idnivelestudio');
        $this->db->from('tblgrupo g');
        $this->db->join('tblnivelestudio ne', 'g.idnivelestudio = ne.idnivelestudio');
        $this->db->where('g.idgrupo', $idgrupo);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->first_row();
        } else {
            return false;
        }
    }
    public function obtenerAlumnoGrupo($idalumno = '', $idperiodo = '')
    {
        $this->db->select('ag.idalumnogrupo');
        $this->db->from('tblalumno_grupo ag');
        $this->db->where('ag.idalumno', $idalumno);
        $this->db->where('ag.idperiodo', $idperiodo);
        $this->db->where('ag.activo', 1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->first_row();
        } else {
            return false;
        }
    }
    public function updateAlumnoGrupo($id, $field)
    {
        $this->db->where('idalumnogrupo', $id);
        $this->db->update('tblalumno_grupo', $field);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function addAlumnoGrupo($data)
    {
        $this->db->insert('tblalumno_grupo', $data);
        $insert_id = $this->db->insert_id();
        return  $insert_id;
    }
}
