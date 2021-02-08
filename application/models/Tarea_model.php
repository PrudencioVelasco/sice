<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Tarea_model extends CI_Model
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

    public function showAll($idusuario = '', $idhorariodetalle = '', $idprofesor = '', $idmateria = '', $idhorario = '')
    {
        $this->db->select("t.idtarea, 
                           t.titulo, 
                            t.tarea,
                            t.horaentrega as horaentregareal, 
                            DATE_FORMAT(t.horaentrega,'%h:%i %p') as horaentrega, 
                            DATE_FORMAT(t.fechaentrega,'%d/%m/%Y') as fechaentrega, 
                            t.iddocumento,
                            t.fechaentrega as fechaentregareal");
        $this->db->from('tbltareav2 t');
        $this->db->join('tblhorario_detalle hd', 'hd.idhorariodetalle = t.idhorariodetalle');
        $this->db->join('tblprofesor_materia pm', 'pm.idprofesormateria = hd.idmateria');
        $this->db->where('hd.idhorario = t.idhorario');
        $this->db->where('t.eliminado', 0);
        if (isset($idusuario) && !empty($idusuario)) {
            //$this->db->where('t.idusuario', $idusuario);
        }
        if (isset($idmateria) && !empty($idmateria)) {
            $this->db->where('pm.idmateria', $idmateria);
        }
        if (isset($idprofesor) && !empty($idprofesor)) {
            $this->db->where('pm.idprofesor', $idprofesor);
        }
        if (isset($idhorario) && !empty($idhorario)) {
            $this->db->where('hd.idhorario', $idhorario);
        }
        if (isset($idhorariodetalle) && !empty($idhorariodetalle)) {
            $this->db->where('t.idhorariodetalle', $idhorariodetalle);
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function showAllEstatusTarea()
    {
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
    public function validarResponderTarea($idtarea, $idalumno)
    {
        $this->db->select("dt.*");
        $this->db->from('tbldetalle_tarea dt');
        $this->db->where('dt.idtarea', $idtarea);
        $this->db->where('dt.idalumno', $idalumno);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->first_row();
        } else {
            return false;
        }
    }
    public function validarTarea($idtarea, $idusuario)
    {
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
    public function validarTareaAlumno($idtarea, $idhorario)
    {
        $this->db->select("t.idtarea, t.titulo, t.tarea,t.horaentrega, DATE_FORMAT(t.fechaentrega,'%d/%m/%Y') as fechaentrega,t.fechaentrega as fechaentregareal");
        $this->db->from('tbltareav2 t');
        $this->db->where('t.eliminado', 0);
        $this->db->where('t.idhorario', $idhorario);
        $this->db->where('t.idtarea', $idtarea);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function detalleTarea($idtarea)
    {
        $this->db->select("t.idtarea,t.idhorariodetalle,t.idhorario, t.titulo, t.tarea,t.horaentrega, DATE_FORMAT(t.fechaentrega,'%d/%m/%Y') as fechaentrega,t.fechaentrega as fechaentregareal, t.nombredocumento, t.iddocumento");
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
    public function detalleTareaAlumno($idtarea)
    {
        $this->db->select("t.idtarea,t.idhorariodetalle,t.idhorario, STR_TO_DATE (CONCAT(DATE(t.fechaentrega),' ',t.horaentrega), '%Y-%m-%d %H:%i:%s') fechaantes, t.titulo, t.tarea,t.horaentrega, DATE_FORMAT(t.fechaentrega,'%d/%m/%Y') as fechaentrega,t.fechaentrega as fechaentregareal, t.nombredocumento, t.iddocumento");
        $this->db->from('tbltareav2 t');
        $this->db->where('t.eliminado', 0);
        $this->db->where('t.idtarea', $idtarea);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->first_row();
        } else {
            return false;
        }
    }
    public function documentosTareaProfesor($idtarea)
    {
        $this->db->select("dt.iddocumento,dt.nombredocumento");
        $this->db->from('tbldocumento_tarea dt');
        $this->db->where('dt.idtarea', $idtarea);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function detalleRespuestaTareaAlumno($idtarea, $idalumno)
    {
        $this->db->select("dt.mensaje,dt.nombrearchivo,et.idestatustarea, dt.observacionesdocente, dt.iddocumento, dt.fecharegistro, et.nombreestatus");
        $this->db->from('tbltareav2 t');
        $this->db->join('tbldetalle_tarea dt', 'dt.idtarea = t.idtarea');
        $this->db->join('tblestatustarea et', 'et.idestatustarea = dt.idestatustarea');
        $this->db->where('t.eliminado', 0);
        $this->db->where('t.idtarea', $idtarea);
        $this->db->where('dt.idalumno', $idalumno);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->first_row();
        } else {
            return false;
        }
    }

    public function addTarea($data)
    {
        $this->db->insert('tbltareav2', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function addDocumentTarea($data)
    {
        $this->db->insert('tbldocumento_tarea', $data);
        $insert_id = $this->db->insert_id();

        return $insert_id;
    }

    public function addDetalleTarea($data)
    {
        $this->db->insert('tbldetalle_tarea', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function addDocumentRespuestaTarea($data)
    {
        $this->db->insert('tbldocumento_alumno', $data);
        $insert_id = $this->db->insert_id();

        return $insert_id;
    }

    public function updateTarea($id, $field)
    {
        $this->db->where('idtarea', $id);
        $this->db->update('tbltareav2', $field);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function updateDocumentoTarea($data)
    { //Funcion para agregar documento al actualizar la tarea en caso de que seleccione mas docs.
        $this->db->insert('tbldocumento_tarea', $data);
        $insert_id = $this->db->insert_id();

        return $insert_id;
    }

    public function updateDetalleTarea($id, $field)
    {
        $this->db->where('iddetalletarea', $id);
        $this->db->update('tbldetalle_tarea', $field);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function showAlumnosGrupo($idhorario)
    {
        $sql = "SELECT * FROM vwalumnosgrupo a WHERE a.idhorario = $idhorario ORDER BY apellidop ASC";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function obtenerCalificacionXId($idhorario, $idmateria, $idalumno, $fecha)
    {
        $sql = "SELECT
                    COUNT(t.idtarea) AS totaltarea,
                    COALESCE((SELECT SUM(dt.calificacion) / COUNT(dt.idtarea)  FROM tbldetalle_tarea dt WHERE dt.idtarea = t.idtarea AND dt.idalumno = $idalumno),0) as calificacion
                FROM
                    tbltareav2 t
                INNER JOIN tblhorario_detalle hd ON
                    t.idhorariodetalle = hd.idhorariodetalle
                INNER JOIN tblprofesor_materia pm ON
                    hd.idmateria = pm.idprofesormateria 
                WHERE pm.idmateria = $idmateria
                AND hd.idhorario = $idhorario
                AND t.fechaentrega = '$fecha' 
                GROUP BY t.idtarea, pm.idmateria, hd.idhorario";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function showAllTaresDetalleAlumno($idtarea, $idalumno)
    {
        $sql = "SELECT
            	dt.iddetalletarea,
            	dt.idtarea,
            	dt.idalumno,
                a.nombre,
                a.apellidop,
                a.apellidom,
            	dt.iddocumento,
            	dt.mensaje, 
                dt.fecharegistro,
                dt.calificacion,
                dt.observacionesdocente,
                SUBSTRING_INDEX(dt.nombrearchivo,'.',-1) as ext
            FROM
            	tbldetalle_tarea dt 
            INNER JOIN tblalumno a ON
                dt.idalumno = a.idalumno
            WHERE dt.idtarea = $idtarea AND dt.idalumno = $idalumno
            GROUP  BY dt.idalumno, dt.idtarea, dt.iddetalletarea ORDER BY dt.fecharegistro ASC ";

        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function showAllAlumnosTareaReporte($idhorario, $idprofesormateria = '', $idmateria, $idtarea)
    {
        $sql = "         
SELECT 
    curp,
    nombre,
    apellidop,
    apellidom, 
FORMAT(calificacion,1) AS calificacion,
CASE
    WHEN estatustarea > 30 THEN 'ENVIADO'
    ELSE 'NO ENVIADO'
END as estatus
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
           COALESCE( (SELECT COUNT(dt.idalumno) FROM tbldetalle_tarea dt WHERE dt.idalumno = a.idalumno AND dt.idtarea = $idtarea),0) AS estatustarea,
  COALESCE( (SELECT ( SUM(dt.calificacion) / COUNT(dt.idalumno)) FROM tbldetalle_tarea dt WHERE dt.idalumno = a.idalumno AND dt.idtarea = $idtarea),0) AS calificacion
            
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
            COALESCE( (SELECT COUNT(dt.idalumno) FROM tbldetalle_tarea dt WHERE dt.idalumno = a.idalumno AND dt.idtarea = $idtarea),0) AS estatustarea,
 COALESCE( (SELECT ( SUM(dt.calificacion) / COUNT(dt.idalumno)) FROM tbldetalle_tarea dt WHERE dt.idalumno = a.idalumno AND dt.idtarea = $idtarea),0) AS calificacion
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

    public function showAllAlumnosTarea($idhorario, $idprofesormateria = '', $idmateria, $idtarea)
    {
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
FORMAT(calificacion,1) AS calificacion
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
           COALESCE( (SELECT COUNT(dt.idalumno) FROM tbldetalle_tarea dt WHERE dt.idalumno = a.idalumno AND dt.idtarea = $idtarea),0) AS estatustarea,
          COALESCE( (SELECT ( SUM(dt.calificacion) / COUNT(dt.idalumno)) FROM tbldetalle_tarea dt WHERE dt.idalumno = a.idalumno AND dt.idtarea = $idtarea),0) AS calificacion
            
    FROM
        tblalumno a
    INNER JOIN tblalumno_grupo ag ON a.idalumno = ag.idalumno
    INNER JOIN tblgrupo g ON g.idgrupo = ag.idgrupo
    INNER JOIN tblnivelestudio ne ON ne.idnivelestudio = g.idnivelestudio
    INNER JOIN tblhorario h ON ag.idgrupo = h.idgrupo
    INNER JOIN tblhorario_detalle hd ON hd.idhorario = h.idhorario
    INNER JOIN tblperiodo p ON p.idperiodo = h.idperiodo
    INNER JOIN tblprofesor_materia pm ON pm.idprofesormateria = hd.idmateria
    INNER JOIN tblmateria m ON m.idmateria = pm.idmateria

    WHERE
        p.idperiodo = ag.idperiodo
        AND m.idclasificacionmateria NOT IN (3)   
        AND (h.activo = 1 OR p.activo = 1)
            AND ag.activo = 1
            AND h.idhorario = $idhorario";
        if (isset($idprofesormateria) && !empty($idprofesormateria)) {
            $sql .= " AND hd.idmateria = $idprofesormateria";
        }
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

        $sql .= " UNION ALL   SELECT 
        a.idalumno,
            a.nombre,
            a.apellidop,
            a.apellidom,
            a.curp,
            ne.nombrenivel,
            g.nombregrupo,
            1 AS opcion,
            hd.idmateria,
           COALESCE( (SELECT COUNT(dt.idalumno) FROM tbldetalle_tarea dt WHERE dt.idalumno = a.idalumno AND dt.idtarea = $idtarea),0) AS estatustarea,
          COALESCE( (SELECT ( SUM(dt.calificacion) / COUNT(dt.idalumno)) FROM tbldetalle_tarea dt WHERE dt.idalumno = a.idalumno AND dt.idtarea = $idtarea),0) AS calificacion
            
    FROM
        tblalumno a
    INNER JOIN tblalumno_grupo ag ON a.idalumno = ag.idalumno
    INNER JOIN tblgrupo g ON g.idgrupo = ag.idgrupo
    INNER JOIN tblnivelestudio ne ON ne.idnivelestudio = g.idnivelestudio
    INNER JOIN tblhorario h ON ag.idgrupo = h.idgrupo
    INNER JOIN tblhorario_detalle hd ON hd.idhorario = h.idhorario
    INNER JOIN tblperiodo p ON p.idperiodo = h.idperiodo
    INNER JOIN tblprofesor_materia pm ON pm.idprofesormateria = hd.idmateria
    INNER JOIN tblmateria m ON m.idmateria = pm.idmateria
    INNER JOIN tblhorario_detalle_cursos hdc ON hdc.idhorario = hd.idhorario
    WHERE
        p.idperiodo = ag.idperiodo
        AND hdc.idprofesormateria = pm.idprofesormateria
        
        AND (h.activo = 1 OR p.activo = 1)
            AND ag.activo = 1
            AND h.idhorario = $idhorario";
        if (isset($idprofesormateria) && !empty($idprofesormateria)) {
            $sql .= " AND pm.idmateria = $idprofesormateria";
        }
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
            COALESCE( (SELECT COUNT(dt.idalumno) FROM tbldetalle_tarea dt WHERE dt.idalumno = a.idalumno AND dt.idtarea = $idtarea),0) AS estatustarea,
 COALESCE( (SELECT ( SUM(dt.calificacion) / COUNT(dt.idalumno)) FROM tbldetalle_tarea dt WHERE dt.idalumno = a.idalumno AND dt.idtarea = $idtarea),0) AS calificacion
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
        $sql .= " AND mr.estatus = 1  AND dr.idhorario = $idhorario GROUP BY ag.idalumno) alumnos GROUP BY idalumno
            ORDER BY apellidop ASC";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function searchAllAlumnosTarea($match, $idhorario = '', $idprofesormateria = '', $idmateria = '', $idtarea = '')
    {
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
FORMAT(calificacion,1) AS calificacion
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
COALESCE( (SELECT COUNT(dt.idalumno) FROM tbldetalle_tarea dt WHERE dt.idalumno = a.idalumno AND dt.idtarea = $idtarea),0) AS estatustarea,
  COALESCE( (SELECT ( SUM(dt.calificacion) / COUNT(dt.idalumno)) FROM tbldetalle_tarea dt WHERE dt.idalumno = a.idalumno AND dt.idtarea = $idtarea),0) AS calificacion
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
    COALESCE( (SELECT COUNT(dt.idalumno) FROM tbldetalle_tarea dt WHERE dt.idalumno = a.idalumno AND dt.idtarea = $idtarea),0) AS estatustarea,
    COALESCE( (SELECT ( SUM(dt.calificacion) / COUNT(dt.idalumno)) FROM tbldetalle_tarea dt WHERE dt.idalumno = a.idalumno AND dt.idtarea = $idtarea),0) AS calificacion
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

    public function searchTareas($match, $idusuario = '', $idhorariodetalle = '', $fechainicio = '', $fechafin = '', $idprofesormateria = '', $idhorario = '')
    {
        $field = 't.titulo,' . "' '" . ',t.fechaentrega';

        $this->db->select("t.idtarea, t.titulo, t.tarea,t.horaentrega as horaentregareal, DATE_FORMAT(t.horaentrega,'%h:%i %p') as horaentrega, DATE_FORMAT(t.fechaentrega,'%d/%m/%Y') as fechaentrega,t.fechaentrega as fechaentregareal");
        $this->db->from('tbltareav2 t');
        $this->db->join('tblhorario_detalle hd', 'hd.idhorariodetalle = t.idhorariodetalle');
        $this->db->where('hd.idhorario = t.idhorario');
        $this->db->where('t.eliminado', 0);
        if (isset($idprofesormateria) && !empty($idprofesormateria)) {
            $this->db->where('hd.idmateria', $idprofesormateria);
        }
        if (isset($idhorario) && !empty($idhorario)) {
            $this->db->where('t.idhorario', $idhorario);
        }
        $this->db->where('t.eliminado', 0);
        if (isset($idusuario) && !empty($idusuario)) {
            //$this->db->where('t.idusuario', $idusuario);
        }
        if (isset($idhorariodetalle) && !empty($idhorariodetalle)) {
            $this->db->where('t.idhorariodetalle', $idhorariodetalle);
        }
        if (!empty($fechainicio) && !empty($fechafin)) {
            $this->db->where('t.fechaentrega BETWEEN "' . $fechainicio . '" and "' . $fechafin . '"');
        }
        $this->db->like('concat(' . $field . ')', $match);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function showTareasAlumnoXMateria($idhorario, $idalumno, $idmateria)
    {
        $sql = 'SELECT
    t.idnotificacionalumno,
    t.idnotificaciontutor,
    hd.idhorariodetalle,
    hd.idhorario,
    hd.horainicial,
    hd.horafinal,
    m.nombreclase,
    p.nombre,
    p.apellidop,
    p.apellidom,
    t.idtarea,
    t.titulo,
    DATE_FORMAT( t.fechaentrega,"%d/%m/%Y") AS fechaentrega,
    DATE_FORMAT( t.horaentrega, "%H:%i") AS horaentrega,
    FORMAT( COALESCE((SELECT SUM(dt.calificacion)/COUNT(dt.calificacion)  FROM tbldetalle_tarea dt WHERE   dt.idtarea = t.idtarea AND dt.idalumno = ' . $idalumno . '),0),1) AS calificacion,
     COALESCE((SELECT COUNT(dt.calificacion) FROM tbldetalle_tarea dt WHERE   dt.idtarea = t.idtarea AND dt.idalumno = ' . $idalumno . '),0) AS estatus
FROM
    tblhorario_detalle hd
      INNER  JOIN
    tblprofesor_materia pm ON hd.idmateria = pm.idprofesormateria
       INNER JOIN
    tblmateria m ON m.idmateria = pm.idmateria
       INNER JOIN
    tblprofesor p ON p.idprofesor = pm.idprofesor
       INNER  JOIN
    tbltareav2 t ON t.idhorariodetalle = hd.idhorariodetalle
WHERE
    hd.idhorario = "' . $idhorario . '" AND m.idmateria = "' . $idmateria . '" AND t.eliminado = 0 ORDER BY t.fecharegistro DESC';
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function showTareasAlumnoMateria($idhorario, $idalumno)
    {
        $sql = 'SELECT 
    t.idnotificacionalumno,
    t.idnotificaciontutor,
    hd.idhorariodetalle,
    hd.idhorario,
    hd.horainicial,
    hd.horafinal,
    m.nombreclase,
    p.nombre,
    p.apellidop,
    p.apellidom,
    t.idtarea,
    t.titulo,
    DATE_FORMAT( t.fechaentrega,"%d/%m/%Y") AS fechaentrega,
    DATE_FORMAT( t.horaentrega, "%H:%i") AS horaentrega,
    FORMAT( COALESCE((SELECT SUM(dt.calificacion)/COUNT(dt.calificacion)  FROM tbldetalle_tarea dt WHERE   dt.idtarea = t.idtarea AND dt.idalumno = ' . $idalumno . '),0),1) AS calificacion,
     COALESCE((SELECT COUNT(dt.calificacion) FROM tbldetalle_tarea dt WHERE   dt.idtarea = t.idtarea AND dt.idalumno = ' . $idalumno . '),0) AS estatus
FROM
    tblhorario_detalle hd
      INNER  JOIN
    tblprofesor_materia pm ON hd.idmateria = pm.idprofesormateria
       INNER JOIN
    tblmateria m ON m.idmateria = pm.idmateria
       INNER JOIN
    tblprofesor p ON p.idprofesor = pm.idprofesor
       INNER  JOIN
    tbltareav2 t ON t.idhorariodetalle = hd.idhorariodetalle
WHERE
    hd.idhorario = "' . $idhorario . '" AND t.eliminado = 0 ORDER BY t.fecharegistro DESC';
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function searchTareasAlumnoMateria($match, $idhorario, $idalumno)
    {
        $sql = "SELECT titulo,nombreclase,idtarea,fechaentrega,horaentrega,estatus,calificacion FROM (SELECT
    t.idnotificacionalumno,
    t.idnotificaciontutor,
    hd.idhorariodetalle,
    hd.idhorario,
    hd.horainicial,
    hd.horafinal,
    m.nombreclase,
    p.nombre,
    p.apellidop,
    p.apellidom,
    t.idtarea,
    t.titulo,
    DATE_FORMAT( t.fechaentrega,'%d/%m/%Y') AS fechaentrega,
    DATE_FORMAT( t.horaentrega, '%H:%i') AS horaentrega,
       FORMAT( COALESCE((SELECT SUM(dt.calificacion)/COUNT(dt.calificacion)  FROM tbldetalle_tarea dt WHERE   dt.idtarea = t.idtarea AND dt.idalumno = $idalumno),0),1) AS calificacion,
     COALESCE((SELECT COUNT(dt.calificacion) FROM tbldetalle_tarea dt WHERE   dt.idtarea = t.idtarea AND dt.idalumno = $idalumno),0) AS estatus
FROM
    tblhorario_detalle hd
      INNER  JOIN
    tblprofesor_materia pm ON hd.idmateria = pm.idprofesormateria
       INNER JOIN
    tblmateria m ON m.idmateria = pm.idmateria
       INNER JOIN
    tblprofesor p ON p.idprofesor = pm.idprofesor
       INNER  JOIN
    tbltareav2 t ON t.idhorariodetalle = hd.idhorariodetalle
WHERE
    hd.idhorario = $idhorario AND t.eliminado = 0) tabla";
        if (isset($match) && !empty($match)) {
            $sql .= "  WHERE   concat(nombreclase,' ',titulo,' ',fechaentrega,' ',estatus) LIKE '%$match%'";
        }
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function searchTareasAlumnoXMateria($match, $idhorario, $idalumno, $idmateria)
    {
        $sql = "SELECT titulo,nombreclase,idtarea,fechaentrega,horaentrega,estatus,calificacion FROM (SELECT 
    t.idnotificacionalumno,
    t.idnotificaciontutor,
    hd.idhorariodetalle,
    hd.idhorario,
    hd.horainicial,
    hd.horafinal,
    m.nombreclase,
    p.nombre,
    p.apellidop,
    p.apellidom,
    t.idtarea,
    t.titulo,
    DATE_FORMAT( t.fechaentrega,'%d/%m/%Y') AS fechaentrega,
    DATE_FORMAT( t.horaentrega, '%H:%i') AS horaentrega,
       FORMAT( COALESCE((SELECT SUM(dt.calificacion)/COUNT(dt.calificacion)  FROM tbldetalle_tarea dt WHERE   dt.idtarea = t.idtarea AND dt.idalumno = $idalumno),0),1) AS calificacion,
     COALESCE((SELECT COUNT(dt.calificacion) FROM tbldetalle_tarea dt WHERE   dt.idtarea = t.idtarea AND dt.idalumno = $idalumno),0) AS estatus
FROM
    tblhorario_detalle hd
      INNER  JOIN
    tblprofesor_materia pm ON hd.idmateria = pm.idprofesormateria
       INNER JOIN
    tblmateria m ON m.idmateria = pm.idmateria
       INNER JOIN
    tblprofesor p ON p.idprofesor = pm.idprofesor
       INNER  JOIN
    tbltareav2 t ON t.idhorariodetalle = hd.idhorariodetalle
WHERE
    hd.idhorario = $idhorario AND t.eliminado = 0 AND m.idmateria = $idmateria) tabla";
        if (isset($match) && !empty($match)) {
            $sql .= "  WHERE   concat(nombreclase,' ',titulo,' ',fechaentrega,' ',estatus) LIKE '%$match%'";
        }
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function obtenerDocumentos($idtarea = '')
    {
        if (!empty($idtarea)) {

            $this->db->select("d.iddocumentotarea,d.iddocumento, d.nombredocumento,SUBSTRING_INDEX(d.nombredocumento,'.',-1) as extension");
            $this->db->from('tbldocumento_tarea d');
            $this->db->where('d.idtarea', $idtarea);
            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                return $query->result();
            } else {
                return false;
            }
        }
    }

    public function obtenerDocumentosAlumno($iddetalletarea = '')
    {
        $this->db->select("d.nombredocumento,SUBSTRING_INDEX(d.nombredocumento,'.',-1) as extension, d.iddocumento");
        $this->db->from('tbldocumento_alumno d');
        $this->db->where('d.iddetalletarea', $iddetalletarea);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }


    public function deleteDocumentoAlumno($iddetalletarea = '')
    { //Funcion para el MODAL (Eliminar documentos)
        if (!empty($iddetalletarea)) {
            $this->db->where('iddetalletarea', $iddetalletarea);
            $this->db->delete('tbldocumento_alumno');
            if ($this->db->affected_rows() > 0) {
                return true;
            } else {
                return false;
            }
        }
    }
    public function deleteDetalleTarea($iddetalletarea = '')
    { //Funcion para el MODAL (Eliminar documentos)
        if (!empty($iddetalletarea)) {
            $this->db->where('iddetalletarea', $iddetalletarea);
            $this->db->delete('tbldetalle_tarea');
            if ($this->db->affected_rows() > 0) {
                return true;
            } else {
                return false;
            }
        }
    }
    public function deleteDocument($iddocumento = '')
    { //Funcion para el MODAL (Eliminar documentos)
        if (!empty($iddocumento)) {
            $this->db->where('iddocumentotarea', $iddocumento);
            $this->db->delete('tbldocumento_tarea');
            if ($this->db->affected_rows() > 0) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function deleteDocumentTarea($idtarea = '')
    { //Funcion para eliminar los documentos cuando se es eliminada directamente la tarea
        if (!empty($idtarea)) {
            $this->db->where('idtarea', $idtarea);
            $this->db->delete('tbldocumento_tarea');
            if ($this->db->affected_rows() > 0) {
                return true;
            } else {
                return false;
            }
        }
    }

    /*    public function obtenerDocumentosTareaAlumno($idtarea = ''){
        if (!empty($idtarea)) {

            $this->db->select("d.iddocumento");
            $this->db->from('tbldocumento_alumno d');
            $this->db->where('d.idtarea', $idtarea);
            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                return $query->result();
            } else {
                return false;
            }        
        }
    } */
}
