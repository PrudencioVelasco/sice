<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Tarea_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function __destruct() {
        $this->db->close();
    }

    public function showAll($idusuario = '') {
        $this->db->select("t.idtarea, t.titulo, t.tarea,t.horaentrega as horaentregareal, DATE_FORMAT(t.horaentrega,'%h:%i %p') as horaentrega, DATE_FORMAT(t.fechaentrega,'%d/%m/%Y') as fechaentrega,t.fechaentrega as fechaentregareal");
        $this->db->from('tbltareav2 t');
        $this->db->where('t.eliminado', 0);
        if (isset($idusuario) && !empty($idusuario)) {
            $this->db->where('t.idusuario', $idusuario);
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function showAllEstatusTarea() {
        $this->db->select("e.*");
        $this->db->from('tblestatustarea e');
        $this->db->where('e.idestatustarea != 1');
        $this->db->where('e.activo', 1);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function validarTarea($idtarea, $idusuario) {
        $this->db->select("t.idtarea, t.titulo, t.tarea,t.horaentrega, DATE_FORMAT(t.fechaentrega,'%d/%m/%Y') as fechaentrega,t.fechaentrega as fechaentregareal");
        $this->db->from('tbltareav2 t');
        $this->db->where('t.eliminado', 0);
        $this->db->where('t.idusuario', $idusuario);
        $this->db->where('t.idtarea', $idtarea);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function detalleTarea($idtarea) {
        $this->db->select("t.idtarea,t.idhorariodetalle,t.idhorario, t.titulo, t.tarea,t.horaentrega, DATE_FORMAT(t.fechaentrega,'%d/%m/%Y') as fechaentrega,t.fechaentrega as fechaentregareal");
        $this->db->from('tbltareav2 t');
        $this->db->where('t.eliminado', 0);
        $this->db->where('t.idtarea', $idtarea);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function addTarea($data) {
        $this->db->insert('tbltareav2', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function updateTarea($id, $field) {
        $this->db->where('idtarea', $id);
        $this->db->update('tbltareav2', $field);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function updateDetalleTarea($id, $field) {
        $this->db->where('iddetalletarea', $id);
        $this->db->update('tbldetalle_tarea', $field);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function showAllAlumnosTarea($idhorario, $idprofesormateria = '', $idmateria, $idtarea) {

        $sql = "         
SELECT
    idalumno,
    curp,
    nombre,
    apellidop,
    apellidom,
    nombrenivel,
    nombregrupo,
    opcion,
    estatustarea,
    idestatustarea,
    mensaje,
    nombrearchivo,
    iddocumento,
    fecharegistro,
    iddetalletarea
FROM
    (SELECT 
        a.idalumno,
            a.nombre,
            a.apellidop,
            a.apellidom,
            a.curp,
            ne.nombrenivel,
            g.nombregrupo,
            1 AS opcion,
            hd.idmateria,
            (SELECT nombreestatus FROM tbldetalle_tarea dt INNER JOIN tblestatustarea te ON te.idestatustarea = dt.idestatustarea WHERE dt.idalumno = a.idalumno AND dt.idtarea = $idtarea) AS estatustarea,
            (SELECT te.idestatustarea FROM tbldetalle_tarea dt INNER JOIN tblestatustarea te ON te.idestatustarea = dt.idestatustarea WHERE dt.idalumno = a.idalumno AND dt.idtarea = $idtarea) AS idestatustarea,
                  (SELECT dt.mensaje FROM tbldetalle_tarea dt INNER JOIN tblestatustarea te ON te.idestatustarea = dt.idestatustarea WHERE dt.idalumno = a.idalumno AND dt.idtarea = $idtarea) AS mensaje,
                        (SELECT dt.nombrearchivo FROM tbldetalle_tarea dt INNER JOIN tblestatustarea te ON te.idestatustarea = dt.idestatustarea WHERE dt.idalumno = a.idalumno AND dt.idtarea = $idtarea) AS nombrearchivo,
                              (SELECT dt.iddocumento FROM tbldetalle_tarea dt INNER JOIN tblestatustarea te ON te.idestatustarea = dt.idestatustarea WHERE dt.idalumno = a.idalumno AND dt.idtarea = $idtarea) AS iddocumento,
                                   (SELECT DATE_FORMAT(dt.fecharegistro,'%d/%m/%Y %h:%i %p') FROM tbldetalle_tarea dt INNER JOIN tblestatustarea te ON te.idestatustarea = dt.idestatustarea WHERE dt.idalumno = a.idalumno AND dt.idtarea = $idtarea) AS fecharegistro,
                                        (SELECT dt.iddetalletarea FROM tbldetalle_tarea dt INNER JOIN tblestatustarea te ON te.idestatustarea = dt.idestatustarea WHERE dt.idalumno = a.idalumno AND dt.idtarea = $idtarea) AS iddetalletarea
            
    FROM
        tblalumno a
    INNER JOIN tblalumno_grupo ag ON a.idalumno = ag.idalumno
    INNER JOIN tblgrupo g ON g.idgrupo = ag.idgrupo
    INNER JOIN tblnivelestudio ne ON ne.idnivelestudio = g.idnivelestudio
    INNER JOIN tblhorario h ON ag.idgrupo = h.idgrupo
    INNER JOIN tblhorario_detalle hd ON hd.idhorario = h.idhorario
    INNER JOIN tblperiodo p ON p.idperiodo = h.idperiodo
    WHERE
        p.idperiodo = ag.idperiodo
            AND (h.activo = 1 OR p.activo = 1)
            AND ag.activo = 1
            AND h.idhorario = $idhorario";
        if (isset($idmateria) && !empty($idmateria)) {
            $sql .= " AND a.idalumno NOT IN (SELECT 
    ag.idalumno
FROM
    tblalumno_grupo ag
        INNER JOIN
    tblmateria_reprobada mr ON ag.idalumnogrupo = mr.idalumnogrupo
        INNER JOIN
    tblmateria_seriada ms ON ms.idmateriasecundaria = mr.idmateria
WHERE
    ms.idmateriaprincipal = $idmateria AND mr.estatus = 1)   GROUP BY   ag.idalumno ";
        }
        $sql .= "
                UNION ALL SELECT 
        a.idalumno,
            a.nombre,
            a.apellidop,
            a.apellidom,
            a.curp,
            ne.nombrenivel,
            g.nombregrupo,
            0 AS opcion,
            hd.idmateria,
            (SELECT nombreestatus FROM tbldetalle_tarea dt INNER JOIN tblestatustarea te ON te.idestatustarea = dt.idestatustarea WHERE dt.idalumno = a.idalumno AND dt.idtarea = $idtarea) AS estatustarea,
            (SELECT te.idestatustarea FROM tbldetalle_tarea dt INNER JOIN tblestatustarea te ON te.idestatustarea = dt.idestatustarea WHERE dt.idalumno = a.idalumno AND dt.idtarea = $idtarea) AS idestatustarea,
                  (SELECT dt.mensaje FROM tbldetalle_tarea dt INNER JOIN tblestatustarea te ON te.idestatustarea = dt.idestatustarea WHERE dt.idalumno = a.idalumno AND dt.idtarea = $idtarea) AS mensaje,
                        (SELECT dt.nombrearchivo FROM tbldetalle_tarea dt INNER JOIN tblestatustarea te ON te.idestatustarea = dt.idestatustarea WHERE dt.idalumno = a.idalumno AND dt.idtarea = $idtarea) AS nombrearchivo,
                              (SELECT dt.iddocumento FROM tbldetalle_tarea dt INNER JOIN tblestatustarea te ON te.idestatustarea = dt.idestatustarea WHERE dt.idalumno = a.idalumno AND dt.idtarea = $idtarea) AS iddocumento,
                                    (SELECT DATE_FORMAT(dt.fecharegistro,'%d/%m/%Y %h:%i %p') FROM tbldetalle_tarea dt INNER JOIN tblestatustarea te ON te.idestatustarea = dt.idestatustarea WHERE dt.idalumno = a.idalumno AND dt.idtarea = $idtarea) AS fecharegistro,
                                         (SELECT dt.iddetalletarea FROM tbldetalle_tarea dt INNER JOIN tblestatustarea te ON te.idestatustarea = dt.idestatustarea WHERE dt.idalumno = a.idalumno AND dt.idtarea = $idtarea) AS iddetalletarea
    FROM
        tblalumno a
    INNER JOIN tblalumno_grupo ag ON a.idalumno = ag.idalumno
    INNER JOIN tblmateria_reprobada mr ON mr.idalumnogrupo = ag.idalumnogrupo
    INNER JOIN tbldetalle_reprobada dr ON dr.idreprobada = mr.idreprobada
    INNER JOIN tblhorario h ON dr.idhorario = h.idhorario
     INNER JOIN tblhorario_detalle hd ON hd.idhorario = h.idhorario
    INNER JOIN tblgrupo g ON g.idgrupo = h.idgrupo
    INNER JOIN tblnivelestudio ne ON ne.idnivelestudio = g.idnivelestudio
    INNER JOIN tblperiodo p ON p.idperiodo = h.idperiodo
    WHERE
        (h.activo = 1 OR p.activo = 1)";
        if (isset($idprofesormateria) && !empty($idprofesormateria)) {
            $sql .= " AND dr.idprofesormateria = $idprofesormateria";
        }
        $sql .= " AND mr.estatus = 1  AND dr.idhorario = $idhorario GROUP BY ag.idalumno) alumnos
            ORDER BY apellidop ASC";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function searchAllAlumnosTarea($match, $idhorario = '', $idprofesormateria = '', $idmateria = '', $idtarea = '') {
        $field = array(
            'm.nombreclase',
            'e.nombreespecialidad',
            'n.nombrenivel'
        );
        $sql = "SELECT
    idalumno,
    curp,
    nombre,
    apellidop,
    apellidom,
    nombrenivel,
    nombregrupo,
    opcion,
    estatustarea,
    idestatustarea,
    mensaje,
    nombrearchivo,
    iddocumento,
    fecharegistro,
    iddetalletarea
FROM
    (SELECT 
        a.idalumno,
            a.nombre,
            a.apellidop,
            a.apellidom,
            a.curp,
            ne.nombrenivel,
            g.nombregrupo,
            1 AS opcion,
            hd.idmateria,
            (SELECT nombreestatus FROM tbldetalle_tarea dt INNER JOIN tblestatustarea te ON te.idestatustarea = dt.idestatustarea WHERE dt.idalumno = a.idalumno AND dt.idtarea = $idtarea) AS estatustarea,
            (SELECT te.idestatustarea FROM tbldetalle_tarea dt INNER JOIN tblestatustarea te ON te.idestatustarea = dt.idestatustarea WHERE dt.idalumno = a.idalumno AND dt.idtarea = $idtarea) AS idestatustarea,
                  (SELECT dt.mensaje FROM tbldetalle_tarea dt INNER JOIN tblestatustarea te ON te.idestatustarea = dt.idestatustarea WHERE dt.idalumno = a.idalumno AND dt.idtarea = $idtarea) AS mensaje,
                        (SELECT dt.nombrearchivo FROM tbldetalle_tarea dt INNER JOIN tblestatustarea te ON te.idestatustarea = dt.idestatustarea WHERE dt.idalumno = a.idalumno AND dt.idtarea = $idtarea) AS nombrearchivo,
                              (SELECT dt.iddocumento FROM tbldetalle_tarea dt INNER JOIN tblestatustarea te ON te.idestatustarea = dt.idestatustarea WHERE dt.idalumno = a.idalumno AND dt.idtarea = $idtarea) AS iddocumento,
                                    (SELECT DATE_FORMAT(dt.fecharegistro,'%d/%m/%Y %h:%i %p') FROM tbldetalle_tarea dt INNER JOIN tblestatustarea te ON te.idestatustarea = dt.idestatustarea WHERE dt.idalumno = a.idalumno AND dt.idtarea = $idtarea) AS fecharegistro,
                                        (SELECT dt.iddetalletarea FROM tbldetalle_tarea dt INNER JOIN tblestatustarea te ON te.idestatustarea = dt.idestatustarea WHERE dt.idalumno = a.idalumno AND dt.idtarea = $idtarea) AS iddetalletarea
            
    FROM
        tblalumno a
    INNER JOIN tblalumno_grupo ag ON a.idalumno = ag.idalumno
    INNER JOIN tblgrupo g ON g.idgrupo = ag.idgrupo
    INNER JOIN tblnivelestudio ne ON ne.idnivelestudio = g.idnivelestudio
    INNER JOIN tblhorario h ON ag.idgrupo = h.idgrupo
    INNER JOIN tblhorario_detalle hd ON hd.idhorario = h.idhorario
    INNER JOIN tblperiodo p ON p.idperiodo = h.idperiodo
    WHERE
     concat(a.nombre,' ',a.apellidop,' ',a.apellidom) LIKE '%$match%'
       AND  p.idperiodo = ag.idperiodo
            AND (h.activo = 1 OR p.activo = 1)
            AND ag.activo = 1
            AND h.idhorario = $idhorario";
        if (isset($idmateria) && !empty($idmateria)) {
            $sql .= " AND a.idalumno NOT IN (SELECT 
    ag.idalumno
FROM
    tblalumno_grupo ag
        INNER JOIN
    tblmateria_reprobada mr ON ag.idalumnogrupo = mr.idalumnogrupo
        INNER JOIN
    tblmateria_seriada ms ON ms.idmateriasecundaria = mr.idmateria
WHERE
    ms.idmateriaprincipal = $idmateria AND mr.estatus = 1)   GROUP BY   ag.idalumno ";
        }
        $sql .= "
                UNION ALL SELECT 
        a.idalumno,
            a.nombre,
            a.apellidop,
            a.apellidom,
            a.curp,
            ne.nombrenivel,
            g.nombregrupo,
            0 AS opcion,
            hd.idmateria,
            (SELECT nombreestatus FROM tbldetalle_tarea dt INNER JOIN tblestatustarea te ON te.idestatustarea = dt.idestatustarea WHERE dt.idalumno = a.idalumno AND dt.idtarea = $idtarea) AS estatustarea,
            (SELECT te.idestatustarea FROM tbldetalle_tarea dt INNER JOIN tblestatustarea te ON te.idestatustarea = dt.idestatustarea WHERE dt.idalumno = a.idalumno AND dt.idtarea = $idtarea) AS idestatustarea,
                  (SELECT dt.mensaje FROM tbldetalle_tarea dt INNER JOIN tblestatustarea te ON te.idestatustarea = dt.idestatustarea WHERE dt.idalumno = a.idalumno AND dt.idtarea = $idtarea) AS mensaje,
                        (SELECT dt.nombrearchivo FROM tbldetalle_tarea dt INNER JOIN tblestatustarea te ON te.idestatustarea = dt.idestatustarea WHERE dt.idalumno = a.idalumno AND dt.idtarea = $idtarea) AS nombrearchivo,
                              (SELECT dt.iddocumento FROM tbldetalle_tarea dt INNER JOIN tblestatustarea te ON te.idestatustarea = dt.idestatustarea WHERE dt.idalumno = a.idalumno AND dt.idtarea = $idtarea) AS iddocumento,
                                    (SELECT DATE_FORMAT(dt.fecharegistro,'%d/%m/%Y %h:%i %p') FROM tbldetalle_tarea dt INNER JOIN tblestatustarea te ON te.idestatustarea = dt.idestatustarea WHERE dt.idalumno = a.idalumno AND dt.idtarea = $idtarea) AS fecharegistro,
                                         (SELECT dt.iddetalletarea FROM tbldetalle_tarea dt INNER JOIN tblestatustarea te ON te.idestatustarea = dt.idestatustarea WHERE dt.idalumno = a.idalumno AND dt.idtarea = $idtarea) AS iddetalletarea
    FROM
        tblalumno a
    INNER JOIN tblalumno_grupo ag ON a.idalumno = ag.idalumno
    INNER JOIN tblmateria_reprobada mr ON mr.idalumnogrupo = ag.idalumnogrupo
    INNER JOIN tbldetalle_reprobada dr ON dr.idreprobada = mr.idreprobada
    INNER JOIN tblhorario h ON dr.idhorario = h.idhorario
     INNER JOIN tblhorario_detalle hd ON hd.idhorario = h.idhorario
    INNER JOIN tblgrupo g ON g.idgrupo = h.idgrupo
    INNER JOIN tblnivelestudio ne ON ne.idnivelestudio = g.idnivelestudio
    INNER JOIN tblperiodo p ON p.idperiodo = h.idperiodo
    WHERE
        concat(a.nombre,' ',a.apellidop,' ',a.apellidom) LIKE '%$match%'
       AND (h.activo = 1 OR p.activo = 1)";
        if (isset($idprofesormateria) && !empty($idprofesormateria)) {
            $sql .= " AND dr.idprofesormateria = $idprofesormateria";
        }
        $sql .= " AND mr.estatus = 1  AND dr.idhorario = $idhorario GROUP BY ag.idalumno) alumnos
          
            ORDER BY apellidop ASC";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function searchTareas($match, $idusuario = '') {
        $field = 't.titulo,' . "' '" . ',t.fechaentrega';

        $this->db->select("t.idtarea, t.titulo, t.tarea,t.horaentrega as horaentregareal, DATE_FORMAT(t.horaentrega,'%h:%i %p') as horaentrega, DATE_FORMAT(t.fechaentrega,'%d/%m/%Y') as fechaentrega,t.fechaentrega as fechaentregareal");
        $this->db->from('tbltareav2 t');
        $this->db->where('t.eliminado', 0);
        if (isset($idusuario) && !empty($idusuario)) {
            $this->db->where('t.idusuario', $idusuario);
        }
        $this->db->like('concat(' . $field . ')', $match);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

}
