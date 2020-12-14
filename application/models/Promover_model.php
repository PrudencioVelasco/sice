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
}
