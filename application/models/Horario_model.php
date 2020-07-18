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
        if (isset($idplantel) && !empty($idplantel)) {
            $this->db->where('h.idplantel', $idplantel);
        }
        $this->db->order_by('h.idhorario DESC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function validarAddHorario($idperiodo = '', $idgrupo = '', $idplantel = '') {
        $this->db->select('h.*');
        $this->db->from('tblhorario h');
        $this->db->where('h.idperiodo', $idperiodo);
        $this->db->where('h.idgrupo', $idgrupo);
        if (isset($idplantel) && !empty($idplantel)) {
            $this->db->where('h.idplantel', $idplantel);
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function materiasARepetir($idalumno = '') {
        $this->db->select(' mr.idmateria, dr.idhorario, dr.idprofesormateria, p.nombre, p.apellidop, p.apellidom,m.nombreclase');
        $this->db->from('tblmateria_reprobada mr');
        $this->db->join('tbldetalle_reprobada dr', 'mr.idreprobada = dr.idreprobada');
        $this->db->join('tblprofesor_materia pm', 'pm.idprofesormateria = dr.idprofesormateria');
        $this->db->join('tblprofesor p ', 'p.idprofesor = pm.idprofesor');
        $this->db->join('tblmateria m ', 'm.idmateria = pm.idmateria');
        $this->db->join('tblhorario h ', ' dr.idhorario = h.idhorario');
        $this->db->join('tblperiodo pe ', 'pe.idperiodo = h.idperiodo');
        $this->db->join('tblalumno_grupo ag ', ' ag.idalumnogrupo = mr.idalumnogrupo');
        $this->db->where(' mr.estatus', 1);
        $this->db->where('ag.idalumno', $idalumno);
        $this->db->where('(h.activo = 1 OR pe.activo = 1)');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function validarActivoHorario($idhorario = '', $idplantel = '') {
        $this->db->select('h.*');
        $this->db->from('tblhorario h');
        $this->db->where('h.idhorario', $idhorario);
        if (isset($idplantel) && !empty($idplantel)) {
            $this->db->where('h.idplantel', $idplantel);
        }
        $this->db->where('h.activo', 1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function detalleHorarioDetalle($idhorariodetalle = '') {
        $this->db->select('m.nombreclase, m.idmateria, p.idprofesor, pm.idprofesormateria, h.idhorario');
        $this->db->from('tblhorario h');
        $this->db->join('tblhorario_detalle hd', 'h.idhorario = hd.idhorario');
        $this->db->join('tblprofesor_materia pm', 'pm.idprofesormateria = hd.idmateria');
        $this->db->join('tblmateria m', 'm.idmateria = pm.idmateria');
        $this->db->join('tblprofesor p', 'p.idprofesor = pm.idprofesor'); 
        $this->db->where('hd.idhorariodetalle',$idhorariodetalle);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function validarActivoCicloEscolar($idhorario = '', $idplantel = '') {
        $this->db->select('h.*');
        $this->db->from('tblhorario h');
        $this->db->where('h.idhorario', $idhorario);
        $this->db->join('tblperiodo p', 'p.idperiodo = h.idperiodo');
        $this->db->where('p.activo', 1);
        if (isset($idplantel) && !empty($idplantel)) {
            $this->db->where('h.idplantel', $idplantel);
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function validarUpdateHorario($idperiodo = '', $idgrupo = '', $idhorario = '', $idplantel = '') {
        $this->db->select('h.*');
        $this->db->from('tblhorario h');
        $this->db->where('h.idperiodo', $idperiodo);
        $this->db->where('h.idgrupo', $idgrupo);
        $this->db->where('h.idhorario !=', $idhorario);
        if (isset($idplantel) && !empty($idplantel)) {
            $this->db->where('h.idplantel', $idplantel);
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function showAllDiaHorario($idhorario, $iddia) {
        $query = $this->db->query("SELECT * FROM vhorarioclases WHERE idhorario= $idhorario AND (iddia = $iddia OR iddia ='Todos') ORDER BY horainicial ASC");
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function showAllDiaHorarioSinDua($idhorario, $reprobadas = '') {
        $sql = '
        SELECT idmateria,
   concat(DATE_FORMAT(horario.horainicial, "%H:%i")," - ",date_format(horario.horafinal,"%H:%i")) as hora,
    MAX(CASE  WHEN horario.iddia = 1 THEN   CONCAT( "<strong>",horario.nombreclase,"</strong> <br> <small>",profesor,"</small>")
      WHEN horario.iddia = "Todos" THEN horario.nombreclase ELSE ""
END) AS lunes,
     MAX(  CASE  
     WHEN horario.iddia = 2 THEN   CONCAT( "<strong>",horario.nombreclase,"</strong> <br> <small>",profesor,"</small>")
     WHEN horario.iddia = "Todos" THEN horario.nombreclase 
     ELSE ""
END )AS martes,
      MAX( CASE  WHEN horario.iddia = 3 THEN   CONCAT( "<strong>",horario.nombreclase,"</strong> <br> <small>",profesor,"</small>")
        WHEN horario.iddia = "Todos" THEN horario.nombreclase 
        ELSE ""
END) AS miercoles,
      MAX( CASE  WHEN horario.iddia = 4 THEN    CONCAT( "<strong>",horario.nombreclase,"</strong> <br> <small>",profesor,"</small>")
        WHEN horario.iddia = "Todos" THEN horario.nombreclase ELSE ""
END )AS jueves,
       MAX(CASE  WHEN horario.iddia = 5 THEN  CONCAT( "<strong>",horario.nombreclase,"</strong> <br> <small>",profesor,"</small>")
         WHEN horario.iddia = "Todos" THEN horario.nombreclase ELSE ""
END )AS viernes

FROM(select iddia, horainicial, horafinal, nombreclase,idhorariodetalle,idmateria, opcion,  CONCAT(nombre," ",apellidop," ",apellidom) profesor
   from vhorarioclases 
    WHERE idhorario =' . $idhorario . '';
        if (isset($reprobadas) && !empty($reprobadas)) {
            $sql .= " and idmateria NOT IN ($reprobadas)";
        }

        $sql .= ') horario 
      GROUP BY  concat(DATE_FORMAT(horario.horainicial, "%H:%i")," - ",date_format(horario.horafinal,"%H:%i")) 
    ORDER by   concat(DATE_FORMAT(horario.horainicial, "%H:%i")," - ",date_format(horario.horafinal,"%H:%i")) ASC;';
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function showHorarioProfesor($idprofesor = '') {
        $sql = 'SELECT idmateria,
   concat(DATE_FORMAT(horario.horainicial, "%H:%i")," - ",date_format(horario.horafinal,"%H:%i")) as hora,
    MAX(CASE  WHEN horario.iddia = 1 THEN   CONCAT("<strong>",horario.nombreclase,"</strong> <br> <small>",profesor,"</small>"," <br> <small>",grupo,"</small>")
      WHEN horario.iddia = "Todos" THEN horario.nombreclase ELSE ""
END) AS lunes,
     MAX(  CASE  
     WHEN horario.iddia = 2 THEN    CONCAT("<strong>",horario.nombreclase,"</strong> <br> <small>",profesor,"</small>"," <br> <small>",grupo,"</small>")
     WHEN horario.iddia = "Todos" THEN horario.nombreclase 
     ELSE ""
END )AS martes,
      MAX( CASE  WHEN horario.iddia = 3 THEN    CONCAT("<strong>",horario.nombreclase,"</strong> <br> <small>",profesor,"</small>"," <br> <small>",grupo,"</small>")
        WHEN horario.iddia = "Todos" THEN horario.nombreclase 
        ELSE ""
END) AS miercoles,
      MAX( CASE  WHEN horario.iddia = 4 THEN   CONCAT("<strong>",horario.nombreclase,"</strong> <br> <small>",profesor,"</small>"," <br> <small>",grupo,"</small>")
        WHEN horario.iddia = "Todos" THEN horario.nombreclase ELSE ""
END )AS jueves,
       MAX(CASE  WHEN horario.iddia = 5 THEN    CONCAT("<strong>",horario.nombreclase,"</strong> <br> <small>",profesor,"</small>"," <br> <small>",grupo,"</small>")
         WHEN horario.iddia = "Todos" THEN horario.nombreclase ELSE ""
END )AS viernes

FROM(
    SELECT 
        de.idhorariodetalle AS idhorariodetalle,
        de.idhorario AS idhorario,
        d.iddia AS iddia,
        de.horainicial AS horainicial,
        de.horafinal AS horafinal,
        d.nombredia AS nombredia,
        p.nombre AS nombre,
        p.apellidop AS apellidop,
        p.apellidom AS apellidom,
        m.nombreclase AS nombreclase,
        m.idmateria AS idmateria,
        pm.idprofesormateria AS idprofesormateria,
        "NORMAL" AS opcion,
         CONCAT(p.nombre," ",p.apellidop," ",p.apellidom) profesor,
          CONCAT(ne.nombrenivel," - ",g.nombregrupo) grupo
    FROM
        tblhorario_detalle de
        JOIN tbldia d ON de.iddia = d.iddia
        JOIN tblprofesor_materia pm ON pm.idprofesormateria = de.idmateria
        JOIN tblmateria m ON m.idmateria = pm.idmateria
        JOIN tblprofesor p ON p.idprofesor = pm.idprofesor 
        JOIN tblhorario h ON h.idhorario = de.idhorario
        JOIN tblperiodo pe ON h.idperiodo = pe.idperiodo
        JOIN tblgrupo g  ON g.idgrupo = h.idgrupo
        JOIN tblnivelestudio ne ON ne.idnivelestudio = g.idnivelestudio
        WHERE (pe.activo = 1 OR h.activo = 1)
        AND p.idprofesor = ' . $idprofesor . ' ) horario
         GROUP BY  concat(DATE_FORMAT(horario.horainicial, "%H:%i")," - ",date_format(horario.horafinal,"%H:%i")) 
    ORDER by   concat(DATE_FORMAT(horario.horainicial, "%H:%i")," - ",date_format(horario.horafinal,"%H:%i")) ASC;';
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function calificacionGeneralAlumno($idhorario, $idalumno) {
        $query = $this->db->query("SELECT 
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

    public function calificacionFinalAlumno($idalumno) {
        $query = $this->db->query("SELECT 
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

    public function showAllMaterias($idplantel = '') {
        # code...
        $this->db->select('pm.idprofesormateria, m.nombreclase, p.nombre, p.apellidop, p.apellidom');
        $this->db->from('tblprofesor_materia pm');
        $this->db->join('tblmateria m', 'pm.idmateria = m.idmateria');
        $this->db->join('tblprofesor p', 'pm.idprofesor = p.idprofesor');
        if (isset($idplantel) && !empty($idplantel)) {
            $this->db->where('m.idplantel', $idplantel);
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function showAllDias() {
        $this->db->select('d.*');
        $this->db->from('tbldia d');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function showAllGrupos($idplantel = '') {
        # code...
        $this->db->select('n.nombrenivel,g.nombregrupo, e.idespecialidad, e.nombreespecialidad, g.idgrupo, t.idturno, t.nombreturno');
        $this->db->from('tblgrupo g');
        $this->db->join('tblnivelestudio n', 'g.idnivelestudio = n.idnivelestudio');
        $this->db->join('tblturno t', 't.idturno = g.idturno');
        $this->db->join('tblespecialidad e', 'e.idespecialidad = g.idespecialidad');
        if (isset($idplantel) && !empty($idplantel)) {
            $this->db->where('g.idplantel', $idplantel);
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function showAllPeriodos($idplantel = '') {
        $this->db->select('p.idperiodo,m.nombremes as mesinicio,m2.nombremes as mesfin,y.nombreyear as yearinicio,y2.nombreyear as yearfin');
        $this->db->from('tblperiodo p');
        $this->db->join('tblmes m ', ' p.idmesinicio = m.idmes');
        $this->db->join('tblmes m2 ', ' p.idmesfin = m2.idmes');
        $this->db->join('tblyear y ', ' p.idyearinicio = y.idyear');
        $this->db->join('tblyear y2 ', ' p.idyearfin = y2.idyear');
        if (isset($idplantel) && !empty($idplantel)) {
            $this->db->where('p.idplantel', $idplantel);
        }
        $this->db->where('p.activo', 1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function addHorario($data) {
        $this->db->insert('tblhorario', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function addHoraSinClase($data) {
        $this->db->insert('tblhora_sinclase', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function addReceso($data) {
        $this->db->insert('tbldescanzo', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function updateReceso($id, $field) {
        $this->db->where('iddescanzo', $id);
        $this->db->update('tbldescanzo', $field);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
      public function addDetalleReprobado($data) {
        $this->db->insert('tbldetalle_reprobada', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }


    public function addMateriaHorario($data) {
        $this->db->insert('tblhorario_detalle', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function updateHorario($id, $field) {
        $this->db->where('idhorario', $id);
        $this->db->update('tblhorario', $field);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function updateHorarioMateria($id, $field) {
        $this->db->where('idhorariodetalle', $id);
        $this->db->update('tblhorario_detalle', $field);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function updateHoraSinClase($id, $field) {
        $this->db->where('idhorasinclase', $id);
        $this->db->update('tblhora_sinclase', $field);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function showAllMateriasProfesor($idprofesor) {
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

    public function showNivelGrupo($idhorario) {
        $this->db->select('pla.idniveleducativo, n.idnivelestudio, p.idperiodo, m.nombremes as mesinicio,m2.nombremes as mesfin,y.nombreyear as yearinicio,y2.nombreyear as yearfin, g.nombregrupo, n.nombrenivel, t.nombreturno');
        $this->db->from('tblperiodo p');
        $this->db->join('tblhorario h', 'h.idperiodo = p.idperiodo');
        $this->db->join('tblgrupo g', 'g.idgrupo = h.idgrupo');
        $this->db->join('tblnivelestudio n', 'n.idnivelestudio = g.idnivelestudio');
        $this->db->join('tblturno t', 'g.idturno = t.idturno');
        $this->db->join('tblmes m ', ' p.idmesinicio = m.idmes');
        $this->db->join('tblmes m2 ', ' p.idmesfin = m2.idmes');
        $this->db->join('tblyear y ', ' p.idyearinicio = y.idyear');
        $this->db->join('tblyear y2 ', ' p.idyearfin = y2.idyear');
        $this->db->join('tblplantel pla ', ' pla.idplantel = p.idplantel');
        $this->db->where('h.idhorario', $idhorario);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->first_row();
        } else {
            return false;
        }
    }

    public function deleteHorarioMateria($id) {
        $this->db->where('idhorariodetalle', $id);
        $this->db->delete('tblhorario_detalle');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteHorario($id) {
        $this->db->where('idhorario', $id);
        $this->db->delete('tblhorario');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteSinClases($id) {
        $this->db->where('idhorasinclase', $id);
        $this->db->delete('tblhora_sinclase');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteReceso($id) {
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
        if (isset($idplantel) && !empty($idplantel)) {
            $this->db->where('h.idplantel', $idplantel);
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
