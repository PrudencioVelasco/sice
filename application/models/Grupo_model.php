<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Grupo_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function __destruct() {
        $this->db->close();
    }

    public function showAllGrupos($idplantel = '') {
        $this->db->select('g.idgrupo,g.idplantel, g.idespecialidad, g.nombregrupo,e.nombreespecialidad, t.idturno, t.nombreturno, n.idnivelestudio, n.nombrenivel');
        $this->db->from('tblgrupo g');
        $this->db->join('tblturno t', 't.idturno = g.idturno');
        $this->db->join('tblespecialidad e', 'e.idespecialidad = g.idespecialidad');
        $this->db->join('tblnivelestudio n', 'n.idnivelestudio = g.idnivelestudio');
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
       public function showAllCalificacionUnidad($idunidad = '', $idhorariodetalle = '', $idoportunidadexamen = '') {
        $this->db->select('c.idcalificacion');
        $this->db->from('tblcalificacion c');
        $this->db->where('c.idunidad', $idunidad);
        $this->db->where('c.idhorariodetalle', $idhorariodetalle); 
        $this->db->where('c.idoportunidadexamen', $idoportunidadexamen);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function showAllOportunidadesExamen($idplantel = '') {
        $this->db->select('o.*');
        $this->db->from('tbloportunidad_examen o');
        if (isset($idplantel) && !empty($idplantel)) {
            $this->db->where('o.idplantel', $idplantel);
        }
        // $this->db->where('o.numero > 1');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
 

    public function showAllPeriodos($idplantel = '') {
        $this->db->select('p.idperiodo,m1.nombremes as mesinicio, m2.nombremes as mesfin, y1.nombreyear as yearinicio, y2.nombreyear as yearfin');
        $this->db->from('tblperiodo p');
        $this->db->join('tblmes m1', 'p.idmesinicio = m1.idmes');
        $this->db->join('tblmes m2', 'p.idmesfin = m2.idmes');
        $this->db->join('tblyear y1', 'y1.idyear = p.idyearinicio');
        $this->db->join('tblyear y2', 'y2.idyear = p.idyearfin');
        if (isset($idplantel) && !empty($idplantel)) {
            $this->db->where('p.idplantel', $idplantel);
        }
        $this->db->order_by('p.idperiodo ASC');
        $this->db->limit('3');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function validarAddGrupo($idnivelestudio = '', $idturno = '', $nombregrupo = '', $idplantel = '') {
        $this->db->select('g.*');
        $this->db->from('tblgrupo g');
        $this->db->where('g.idnivelestudio', $idnivelestudio);
        $this->db->where('g.idturno', $idturno);
        $this->db->where('g.nombregrupo', $nombregrupo);
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

    public function validarUpdateGrupo($idnivelestudio = '', $idturno = '', $nombregrupo = '', $idgrupo, $idplantel = '') {
        $this->db->select('');
        $this->db->from('tblgrupo g');
        $this->db->where('g.idnivelestudio', $idnivelestudio);
        $this->db->where('g.idturno', $idturno);
        $this->db->where('g.nombregrupo', $nombregrupo);
        $this->db->where('g.idgrupo !=', $idgrupo);
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

    public function showAllNiveles() {
        $this->db->select('n.*');
        $this->db->from('tblnivelestudio n');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function showAllOportunidades($idplantel) {
        $this->db->select('n.*');
        $this->db->from('tbloportunidad_examen n');
        $this->db->where('n.numero > 1');
        $this->db->where('n.idplantel', $idplantel);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function showAllCalificacionOportunidad($idhorariodetalle,$idoportunidad) {
        $this->db->select('a.nombre, a.apellidop, a.apellidom, c.calificacion');
        $this->db->from('tblcalificacion c');
        $this->db->join('tblalumno a', 'a.idalumno = c.idalumno');
        $this->db->where('c.idoportunidadexamen',$idoportunidad);
        $this->db->where('c.idhorariodetalle', $idhorariodetalle);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function primeraOportunidad($idplantel) {
        $this->db->select('n.*');
        $this->db->from('tbloportunidad_examen n');
        $this->db->where('n.numero', 1);
        $this->db->where('n.idplantel', $idplantel);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function showAllTurnos() {
        $this->db->select('t.*');
        $this->db->from('tblturno t');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function detalleAlumnoGrupo($idalumno, $idperiodo) {
        $this->db->select('ag.*');
        $this->db->from('tblalumno_grupo ag');
        $this->db->where('ag.idalumno', $idalumno);
        $this->db->where('ag.idperiodo', $idperiodo);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function detalleClase($idhorariodetalle = '') {
        $this->db->select('m.nombreclase,m.idmateria,pm.idprofesormateria,ne.nombrenivel, g.nombregrupo');
        $this->db->from('tblhorario_detalle hd');
        $this->db->join('tblprofesor_materia pm', 'hd.idmateria = pm.idprofesormateria');
        $this->db->join('tblmateria m', 'm.idmateria = pm.idmateria');
        $this->db->join('tblhorario h','h.idhorario = hd.idhorario');
        $this->db->join('tblgrupo g','g.idgrupo = h.idgrupo');
        $this->db->join('tblnivelestudio ne','ne.idnivelestudio = g.idnivelestudio');
        $this->db->where('hd.idhorariodetalle', $idhorariodetalle);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function searchGrupo($match, $idplantel = '') {
        $field = array(
            'g.nombregrupo',
            't.nombreturno',
            'n.nombrenivel',
            'e.nombreespecialidad'
        );
        $this->db->select('g.idgrupo, g.nombregrupo, t.idturno,e.idespecialidad,e.nombreespecialidad, t.nombreturno, n.idnivelestudio, n.nombrenivel');
        $this->db->from('tblgrupo g');
        $this->db->join('tblturno t', 't.idturno = g.idturno');
        $this->db->join('tblespecialidad e', 'e.idespecialidad = g.idespecialidad');
        $this->db->join('tblnivelestudio n', 'n.idnivelestudio = g.idnivelestudio');
        if (isset($idplantel) && !empty($idplantel)) {
            $this->db->where('g.idplantel', $idplantel);
        }
        $this->db->like('concat(' . implode(',', $field) . ')', $match);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function showAllGruposProfesor($idprofesor = '') {
        $query = $this->db->query("SELECT 
    idhorariodetalle,
    idprofesormateria,
    idhorario,
    idmateria,
    nombreclase,
    profesor,
    nombregrupo,
    nombrenivel,
    idgrupo,
    opcion
FROM
    (SELECT 
        de.idhorariodetalle,
        pm.idprofesormateria,
            de.idhorario,
            m.idmateria AS idmateria,
            m.nombreclase AS nombreclase,
            g.idgrupo,
            CONCAT(p.nombre, ' ', p.apellidop, ' ', p.apellidom) profesor,
            g.nombregrupo,
            ne.nombrenivel,
               1 as opcion
    FROM
        tblhorario_detalle de
    JOIN tbldia d ON de.iddia = d.iddia
    JOIN tblprofesor_materia pm ON pm.idprofesormateria = de.idmateria
    JOIN tblmateria m ON m.idmateria = pm.idmateria
    JOIN tblprofesor p ON p.idprofesor = pm.idprofesor
    JOIN tblhorario h ON h.idhorario = de.idhorario
    JOIN tblperiodo pe ON h.idperiodo = pe.idperiodo
    JOIN tblgrupo g ON g.idgrupo = h.idgrupo
    JOIN tblnivelestudio ne ON ne.idnivelestudio = g.idnivelestudio
    WHERE
        (pe.activo = 1 OR h.activo = 1)
            AND p.idprofesor = $idprofesor 
             ) grupos
GROUP BY idmateria , idgrupo
ORDER BY nombrenivel ASC");
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function dia($idhorariodetalle = '') {
        # code...
        $this->db->select('d.iddia,d.nombredia, de.horainicial, de.horafinal');
        $this->db->from('tblhorario_detalle de');
        $this->db->join('tbldia d', 'd.iddia = de.iddia');
        $this->db->where('de.idhorariodetalle', $idhorariodetalle);
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->first_row();
        } else {
            return false;
        }
    }

    public function detalleCalificacion($idcalificacion = '') {
        # code...
        $this->db->select('c.idcalificacion, date(c.fecharegistro) as fecharegistro');
        $this->db->from('tblcalificacion c');
        $this->db->where('c.idcalificacion', $idcalificacion);
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->first_row();
        } else {
            return false;
        }
    }
        public function detalleCalificacionSecundaria($idcalificacion = '') {
        # code...
        $this->db->select('c.idcalificacion, dc.iddetallecalificacion, dc.proyecto, dc.tarea,dc.participacion, dc.examen');
        $this->db->from('tblcalificacion c');
        $this->db->join('tbldetalle_calificacion dc','dc.idcalificacion = c.idcalificacion');
        $this->db->where('c.idcalificacion', $idcalificacion);
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->first_row();
        } else {
            return false;
        }
    }

    public function detalleCalificacionUnidad($idunidad = '', $idhorariodetalle) {
        # code...
        $this->db->select('c.idcalificacion, date(c.fecharegistro) as fecharegistro');
        $this->db->from('tblcalificacion c');
        $this->db->where('c.idunidad', $idunidad);
        $this->db->where('c.idhorariodetalle', $idhorariodetalle);
        $this->db->order_by('c.fecharegistro ASC');
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->first_row();
        } else {
            return false;
        }
    }

    public function detalleHorarioDetalle($idhorariodetalle) {
        # code...
        $this->db->select('hd.idmateria as idprofesormateria, t.nombreturno, n.numeroordinaria,h.idhorario, m.nombreclase, pm.idmateria,h.idgrupo,h.idperiodo, m.unidades,p.nombre, p.apellidop, p.apellidom');
        $this->db->from('tblhorario_detalle hd');
        $this->db->join('tblprofesor_materia pm', 'hd.idmateria = pm.idprofesormateria');
        $this->db->join('tblhorario h', 'h.idhorario  = hd.idhorario');
        $this->db->join('tblmateria m', 'm.idmateria = pm.idmateria');
        $this->db->join('tblprofesor p', 'p.idprofesor = pm.idprofesor');
        $this->db->join('tblgrupo g', 'g.idgrupo = h.idgrupo');
        $this->db->join('tblturno t', 'g.idturno = t.idturno');
        $this->db->join('tblnivelestudio n', 'n.idnivelestudio = g.idnivelestudio');
        $this->db->where('hd.idhorariodetalle', $idhorariodetalle);
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->first_row();
        } else {
            return false;
        }
    }
     

    public function detalleUnidad($idunidad) {
        # code...
        $this->db->select('u.idunidad,u.numero,u.nombreunidad');
        $this->db->from('tblunidad u'); 
        $this->db->where('u.idunidad', $idunidad);
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->first_row();
        } else {
            return false;
        }
    }        public function totalAsistencias($idunidad,$idhoraridetalle,$idalumno) {
        $sql = "SELECT 
   COALESCE(  COUNT(a.idalumno),0) AS totalregistrado,
   
     COALESCE(SUM(CASE
        WHEN a.idmotivo = 4 THEN 1
        ELSE 0
    END),0) AS totalfalta,
    ((COALESCE(SUM(CASE
        WHEN a.idmotivo = 4 THEN 1
        ELSE 0
    END),0) / COALESCE(  COUNT(a.idalumno),0)) * 100) as porcentaje
FROM
    tblasistencia a
     
 WHERE a.idalumno = $idalumno
 AND a.idhorariodetalle = $idhoraridetalle
AND a.idunidad =  $idunidad
GROUP BY a.idalumno , a.idhorariodetalle , a.idunidad";
      $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function allTarea($idhorariodetalle = '') {
        # code...
        $this->db->select('t.*');
        $this->db->from('tbltarea t');
        $this->db->where('t.idhorariodetalle', $idhorariodetalle);
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function listaPlaneacion($idunidad, $idhorariodetalle = '') {
        # code...
        $this->db->select('p.idplaneacion,p.planeacion,p.lugar,p.fechainicio, p.fechafin');
        $this->db->from('tblplaneacion p');
        $this->db->where('p.iddetallehorario', $idhorariodetalle);
        $this->db->where('p.idunidad', $idunidad);
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function validarAgregarCalificacion($idunidad, $idhorariodetalle = '', $idoportunidad = '', $idalumno = '') {
        # code...
        $this->db->select('c.*');
        $this->db->from('tblcalificacion c');
        $this->db->where('c.idhorariodetalle', $idhorariodetalle);
        $this->db->where('c.idunidad', $idunidad);

        if (isset($idoportunidad) && !empty($idoportunidad)) {
            $this->db->where('c.idoportunidadexamen', $idoportunidad);
        }
        if (isset($idalumno) && !empty($idalumno)) {
            $this->db->where('c.idalumno', $idalumno);
        }
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function validarAgregarAsistencia($fecha, $idhorariodetalle = '', $idunidad = '') {
        # code...
        $this->db->select('c.*');
        $this->db->from('tblasistencia c');
        $this->db->where('c.idhorariodetalle', $idhorariodetalle);
        $this->db->where('c.fecha', $fecha);
        $this->db->where('c.idunidad', $idunidad);
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function unidades($idplantel = '',$unidades_materia = '') {
        # code...
        $this->db->select('u.idunidad, u.nombreunidad, u.numero');
        $this->db->from('tblunidad u');
        $this->db->where('u.idplantel', $idplantel);
        if(isset($unidades_materia) && !empty($unidades_materia)){
             $this->db->where('u.numero <=', $unidades_materia);
        }
        $this->db->order_by('u.numero ASC');
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function motivoAsistencia() {
        # code...
        $this->db->select('m.idmotivo, m.nombremotivo');
        $this->db->from('tblmotivo_asistencia m');
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function addPlaneacion($data) {
        $this->db->insert('tblplaneacion', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    public function addDetalleCalificacion($data) {
        $this->db->insert('tbldetalle_calificacion', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function addAsistencia($data) {
        $this->db->insert('tblasistencia', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function addTarea($data) {
        $this->db->insert('tbltarea', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function addGrupo($data) {
        $this->db->insert('tblgrupo', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function addCalificacion($data) {
        $this->db->insert('tblcalificacion', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function eliminarPlaneacion($idplaneacion = '') {
        # code...
        $this->db->where('idplaneacion', $idplaneacion);
        $this->db->delete('tblplaneacion');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function eliminarAsistenciaFecha($idhorariodetalle = '', $fecha = '') {
        # code...
        $this->db->where('idhorariodetalle', $idhorariodetalle);
        $this->db->where('fecha', $fecha);
        $this->db->delete('tblasistencia');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function eliminarCalificacionUnidad($idunidad = '', $idhorariodetalle = '', $idoportunidadexamen = '') {
        # code...
        $this->db->where('idhorariodetalle', $idhorariodetalle);
        $this->db->where('idunidad', $idunidad);
        $this->db->where('idoportunidadexamen', $idoportunidadexamen);
        $this->db->delete('tblcalificacion');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
        public function eliminarDetalleCalificacionUnidadSecu($idcalificacion = '') {
      
        $this->db->where('idcalificacion', $idcalificacion);
        $this->db->delete('tbldetalle_calificacion');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function eliminarTarea($idtarea = '') {
        # code...
        $this->db->where('idtarea', $idtarea);
        $this->db->delete('tbltarea');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteGrupo($idgrupo = '') {
        # code...
        $this->db->where('idgrupo', $idgrupo);
        $this->db->delete('tblgrupo');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteCalificacion($idcalificacion = '') {
        # code...
        $this->db->where('idcalificacion', $idcalificacion);
        $this->db->delete('tblcalificacion');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
       public function deleteCalificacionSecu($idcalificacion = '') {
        # code...
        $this->db->where('iddetallecalificacion', $idcalificacion);
        $this->db->delete('tbldetalle_calificacion');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteAsistencia($idasistencia = '') {
        # code...
        $this->db->where('idasistencia', $idasistencia);
        $this->db->delete('tblasistencia');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function alumnosGrupoPreescolar($idhorario,$idprofesor) {
    $sql = "SELECT 
             a.idalumno,
            a.nombre,
            a.apellidop,
            a.apellidom,
            a.curp,
            ne.nombrenivel,
            g.nombregrupo, 
            hd.idmateria
    FROM
        tblalumno a
    INNER JOIN tblalumno_grupo ag ON a.idalumno = ag.idalumno
    INNER JOIN tblgrupo g ON g.idgrupo = ag.idgrupo
    INNER JOIN tblnivelestudio ne ON ne.idnivelestudio = g.idnivelestudio
    INNER JOIN tblhorario h ON ag.idgrupo = h.idgrupo
    INNER JOIN tblhorario_detalle hd ON hd.idhorario = h.idhorario
    INNER JOIN tblprofesor_materia pm ON pm.idprofesormateria = hd.idmateria
    INNER JOIN tblperiodo p ON p.idperiodo = h.idperiodo
    WHERE
        p.idperiodo = ag.idperiodo
            AND (h.activo = 1 OR p.activo = 1)
            AND ag.activo = 1
            AND pm.idprofesor = $idprofesor
            AND h.idhorario = $idhorario";
      $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function alumnosGrupo($idhorario, $idprofesormateria = '', $idmateria) {

        $sql = "SELECT
    idalumno,
    curp,
    nombre,
    apellidop,
    apellidom,
    nombrenivel,
    nombregrupo,
    opcion
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
            hd.idmateria
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
             hd.idmateria
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

    public function listaAsistencia($idalumno = '', $idhorario = '', $fecha = '', $idhorariodetalle = '', $idunidad = '') {
        # code...
        $this->db->select('a.idasistencia,ma.idmotivo, a.fecha,ma.nombremotivo, ma.abreviatura');
        $this->db->from('tblasistencia a');
        $this->db->join('tblmotivo_asistencia ma', 'a.idmotivo = ma.idmotivo');
        $this->db->where('a.idalumno', $idalumno);
        //$this->db->where('a.idhorario', $idhorario);
        $this->db->where('a.idhorariodetalle', $idhorariodetalle);
        $this->db->where('a.fecha', $fecha);
        if (isset($idunidad) && !empty($idunidad) && $idunidad != 0) {
            $this->db->where('a.idunidad', $idunidad);
        }
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->first_row();
        } else {
            return false;
        }
    }

    public function listaAsistenciaBuscar($idalumno = '', $idhorario = '', $fecha = '', $idhorariodetalle = '', $idmotivo = '') {
        # code...
        $this->db->select('a.idasistencia,ma.idmotivo, a.fecha,ma.nombremotivo, ma.abreviatura');
        $this->db->from('tblasistencia a');
        $this->db->join('tblmotivo_asistencia ma', 'a.idmotivo = ma.idmotivo');
        $this->db->where('a.idalumno', $idalumno);
        // $this->db->where('a.idhorario', $idhorario);
        $this->db->where('a.idhorariodetalle', $idhorariodetalle);
        $this->db->where('a.fecha', $fecha);
        if (isset($idmotivo) && !empty($idmotivo) && $idmotivo != 0) {
            $this->db->where('ma.idmotivo', $idmotivo);
        }
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->first_row();
        } else {
            return false;
        }
    }

    public function listaAsistenciaGeneral($idalumno = '', $idhorario = '', $fecha = '', $idhorariodetalle = '', $motivo = '') {
        # code...
        $this->db->select('ma.idmotivo, a.fecha,ma.nombremotivo, ma.abreviatura');
        $this->db->from('tblasistencia a');
        $this->db->join('tblmotivo_asistencia ma', 'a.idmotivo = ma.idmotivo');
        $this->db->where('a.idalumno', $idalumno);
        $this->db->where('a.idhorario', $idhorario);
        $this->db->where('a.idhorariodetalle', $idhorariodetalle);
        $this->db->where('a.idmotivo', $motivo);
        $this->db->where('a.fecha', $fecha);
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->first_row();
        } else {
            return false;
        }
    }

    public function updatePlaneacion($id, $field) {
        $this->db->where('idplaneacion', $id);
        $this->db->update('tblplaneacion', $field);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function updateTarea($id, $field) {
        $this->db->where('idtarea', $id);
        $this->db->update('tbltarea', $field);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
       public function updateDetalleCalificacion($id, $field) {
        $this->db->where('iddetallecalificacion', $id);
        $this->db->update('tbldetalle_calificacion', $field);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function updateAsistencia($id, $field) {
        $this->db->where('idasistencia', $id);
        $this->db->update('tblasistencia', $field);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function updateGrupo($id, $field) {
        $this->db->where('idgrupo', $id);
        $this->db->update('tblgrupo', $field);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function updateCalificacion($id, $field) {
        $this->db->where('idcalificacion', $id);
        $this->db->update('tblcalificacion', $field);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function obtenerCalificacion($idalumno = '', $idunidad = '', $idhorariodetalle = '') {
        # code...
        $this->db->select('c.idcalificacion, c.calificacion, date(c.fecharegistro) as fecharegistro');
        $this->db->from('tblcalificacion c');
        $this->db->join('tblunidad u', 'c.idunidad = u.idunidad');
        $this->db->where('c.idalumno', $idalumno); 
        $this->db->where('c.idhorariodetalle', $idhorariodetalle);
        $this->db->where('c.idunidad', $idunidad);
        $this->db->order_by('c.fecharegistro ASC');
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->first_row();
        } else {
            return false;
        }
    }
        public function obtenerCalificacionPreescolar($idalumno = '', $idunidad = '', $idprofesor = '',$idhorario) {
        # code...
        $this->db->select('');
        $this->db->from('tblcalificacion c');
        $this->db->join('tblunidad u', 'c.idunidad = u.idunidad');
        $this->db->where('c.idalumno', $idalumno); ; 
        $this->db->where('c.idhorariodetalle', $idhorariodetalle);
        $this->db->where('c.idunidad', $idunidad);
        $this->db->order_by('c.fecharegistro ASC');
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->first_row();
        } else {
            return false;
        }
    }

    public function calificacionPorMateria($idalumno = '', $idprofesormateria = '', $idhorario = '') {
        # code...
        $this->db->select('(sum(c.calificacion)/count(c.idunidad)) as calificacion');
        $this->db->from('tblcalificacion c');
        $this->db->join('tblhorario_detalle hd', 'c.idhorariodetalle = hd.idhorariodetalle');
        $this->db->join('tbloportunidad_examen oe', 'oe.idoportunidadexamen = c.idoportunidadexamen');
        $this->db->join('tblhorario h', 'h.idhorario = hd.idhorario');
        $this->db->where('c.idalumno', $idalumno);
        $this->db->where('hd.idmateria', $idprofesormateria);
        $this->db->where('h.idhorario', $idhorario);
        $this->db->group_by('c.idalumno');
        $this->db->group_by('hd.idmateria');
        $this->db->group_by('oe.idoportunidadexamen');
        $this->db->order_by('oe.numero DESC ');
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->first_row();
        } else {
            return false;
        }
    }

    public function obtenerCalificacionRecuperado($idalumno = '', $idoportunidad = '', $idhorariodetalle = '') {
        # code...
        $this->db->select('a.nombre, a.apellidop, a.apellidom, c.idcalificacion,(SUM(c.calificacion)/(COUNT(c.idunidad))) as calificacion, date(c.fecharegistro) as fecharegistro');
        $this->db->from('tblcalificacion c');
        $this->db->join('tblunidad u', 'c.idunidad = u.idunidad');
        $this->db->join('tblalumno a', 'a.idalumno = c.idalumno');
        $this->db->where('c.idalumno', $idalumno);
        $this->db->where('c.idhorariodetalle', $idhorariodetalle);
        $this->db->where('c.idoportunidadexamen', $idoportunidad);
        $this->db->group_by('c.idalumno');
        $this->db->group_by('c.idhorariodetalle');
        $this->db->group_by('c.idoportunidadexamen');
        $this->db->order_by('c.fecharegistro ASC');
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->first_row();
        } else {
            return false;
        }
    }

    public function obtenerAlumnoRecuperar($idhorariodetalle, $idoportunidad, $idprofesormateria) {
        $query = $this->db->query("SELECT 
    a.idalumno,
    a.nombre,
    a.apellidop,
    a.apellidom,
    FORMAT((SUM(c.calificacion) / (COUNT(c.idunidad))),
        2) AS calificacion
FROM
    tblalumno a
        JOIN
    tblalumno_grupo ag ON ag.idalumno = a.idalumno
        JOIN
    tblhorario h ON h.idperiodo = ag.idperiodo
        JOIN
    tblhorario h2 ON h2.idgrupo = ag.idgrupo
        JOIN
    tblhorario_detalle hd ON hd.idhorario = h.idhorario
        JOIN
    tblcalificacion c ON c.idhorariodetalle = hd.idhorariodetalle
        JOIN
    tbloportunidad_examen oe ON oe.idoportunidadexamen = c.idoportunidadexamen
WHERE
    hd.idhorariodetalle = $idhorariodetalle
        AND a.idalumno = c.idalumno
        AND a.idalumno NOT IN (SELECT 
    ag.idalumno
FROM
    tblalumno_grupo ag
        INNER JOIN
    tblmateria_reprobada mr ON ag.idalumnogrupo = mr.idalumnogrupo
        INNER JOIN
    tbldetalle_reprobada dr ON mr.idreprobada = dr.idreprobada
WHERE
    dr.idprofesormateria = $idprofesormateria AND mr.estatus = 1)
        AND oe.idoportunidadexamen = $idoportunidad
GROUP BY a.idalumno , hd.idmateria , hd.idhorariodetalle");
        if ($this->db->affected_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function obtenerOportunidadAnterior($numero = '', $idplantel = '') {
        # code...
        $this->db->select('oe.*');
        $this->db->from('tbloportunidad_examen oe');
        $this->db->where('oe.numero < ', $numero);
        if (isset($idplantel) && !empty($idplantel)) {
            $this->db->where('oe.idplantel', $idplantel);
        }
        $this->db->order_by('oe.numero DESC');
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->first_row();
        } else {
            return false;
        }
    }

    public function obtenerUnidadUno($numero = '') {
        # code...
        $this->db->select('u.*');
        $this->db->from('tblunidad u');
        $this->db->where('u.idplantel', $this->session->idplantel);
        if (isset($numero) && !empty($numero)) {
            $this->db->where('u.numero', $numero);
        }
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->first_row();
        } else {
            return false;
        }
    }

    public function obtenerUnidades($numero) {
        # code...
        $this->db->select('u.*');
        $this->db->from('tblunidad u');
        $this->db->where('u.idplantel', $this->session->idplantel);
        $this->db->where('u.numero', $numero);
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function detalleOportunidad($idoportunidad = '') {
        # code...
        $this->db->select('oe.*');
        $this->db->from('tbloportunidad_examen oe');
        $this->db->where('oe.idoportunidadexamen', $idoportunidad);
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->first_row();
        } else {
            return false;
        }
    }

    public function listaAlumnosGrupo($idperiodo, $idgrupo, $idplantel) {
        $this->db->select('a.idalumno,a.nombre, a.apellidop, a.apellidom');
        $this->db->from('tblalumno a');
        $this->db->join('tblalumno_grupo ag', 'ag.idalumno = a.idalumno');
        $this->db->where('ag.idperiodo', $idperiodo);
        $this->db->where('ag.idgrupo', $idgrupo);
        $this->db->order_by('a.apellidop ASC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function listaAlumnosPorMateria($idperiodo, $idgrupo, $idplantel) {
        $this->db->select('a.idalumno,a.nombre, a.apellidop, a.apellidom');
        $this->db->from('tblalumno a');
        $this->db->join('tblalumno_grupo ag', 'ag.idalumno = a.idalumno');
        $this->db->where('ag.idperiodo', $idperiodo);
        $this->db->where('ag.idgrupo', $idgrupo);
        $this->db->order_by('a.apellidop ASC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function listaAlumnosGrupoReprobados($idperiodo, $idgrupo, $idplantel = '') {
        $this->db->select('a.idalumno,a.nombre, a.apellidop, a.apellidom, dr.idprofesormateria');
        $this->db->from('tblalumno a');
        $this->db->join('tblalumno_grupo ag', 'ag.idalumno = a.idalumno');
        $this->db->join('tblmateria_reprobada mr', 'mr.idalumnogrupo = ag.idalumnogrupo');
        $this->db->join('tbldetalle_reprobada dr', 'dr.idreprobada = mr.idreprobada');
        $this->db->join('tblhorario h', 'h.idhorario = dr.idhorario');
        $this->db->where('h.idperiodo', $idperiodo);
        $this->db->where('h.idgrupo', $idgrupo);
        $this->db->group_by('a.idalumno');
        $this->db->order_by('a.apellidop ASC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function listaMateriasReprobadasGrupo($idperiodo, $idgrupo) {
        $this->db->select('pm.idprofesormateria, m.nombreclase');
        $this->db->from('tblalumno a');
        $this->db->join('tblalumno_grupo ag', 'ag.idalumno = a.idalumno');
        $this->db->join('tblmateria_reprobada mr', 'mr.idalumnogrupo = ag.idalumnogrupo');
        $this->db->join('tbldetalle_reprobada dr', 'dr.idreprobada = mr.idreprobada');
        $this->db->join('tblhorario h', 'h.idhorario = dr.idhorario');
        $this->db->join('tblprofesor_materia pm', 'pm.idprofesormateria = dr.idprofesormateria');
        $this->db->join('tblmateria m', 'm.idmateria = pm.idmateria');
        $this->db->where('dr.idhorario =h.idhorario ');
        $this->db->where('h.idperiodo', $idperiodo);
        $this->db->where('h.idgrupo', $idgrupo);
        $this->db->group_by('a.idalumno');
        $this->db->order_by('a.apellidop ASC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function listaMateriasGrupo($idperiodo, $idgrupo) {
        $this->db->select('pm.idprofesormateria, m.nombreclase,m.idmateria');
        $this->db->from('tblalumno a');
        $this->db->join('tblalumno_grupo ag', 'ag.idalumno = a.idalumno');
        $this->db->join('tblhorario h', 'h.idperiodo = ag.idperiodo');
        $this->db->join('tblhorario_detalle hd', 'hd.idhorario = h.idhorario');
        $this->db->join('tblprofesor_materia pm', 'hd.idmateria = pm.idprofesormateria');
        $this->db->join('tblmateria m', 'm.idmateria = pm.idmateria');
        $this->db->where('h.idgrupo = ag.idgrupo');
        $this->db->where('ag.idperiodo', $idperiodo);
        $this->db->where("ag.idgrupo = $idgrupo");
        //$this->db->or_where('h.idgrupo',$idgrupo);
        $this->db->group_by('hd.idmateria');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function validarMateriaSeriada($idmateria, $idalumno) {
        $this->db->select('');
        $this->db->from('tblalumno a');
        $this->db->join('tblalumno_grupo ag', 'ag.idalumno = a.idalumno');
        $this->db->join('tblmateria_reprobada mr', 'mr.idalumnogrupo = ag.idalumnogrupo');
        $this->db->join('tblmateria_seriada ms', 'ms.idmateriasecundaria = mr.idmateria');
        $this->db->where('a.idalumno', $idalumno);
        $this->db->where('ms.idmateriaprincipal', $idmateria);
        $this->db->where('mr.estatus', 1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

//  public function listaMateriasGrupo($idperiodo, $idgrupo) {
//        $sql = " SELECT 
//    idprofesormateria, nombreclase, opcion
//FROM
//    (SELECT 
//        pm.idprofesormateria, m.nombreclase, 1 AS opcion
//    FROM
//        tblalumno a
//    JOIN tblalumno_grupo ag ON ag.idalumno = a.idalumno
//    JOIN tblhorario h ON h.idperiodo = ag.idperiodo
//    JOIN tblhorario_detalle hd ON hd.idhorario = h.idhorario
//    JOIN tblprofesor_materia pm ON hd.idmateria = pm.idprofesormateria
//    JOIN tblmateria m ON m.idmateria = pm.idmateria
//    WHERE
//        h.idgrupo = ag.idgrupo
//            AND ag.idperiodo = $idperiodo
//            AND ag.idgrupo = $idgrupo
//    GROUP BY hd.idmateria UNION ALL SELECT 
//        pm.idprofesormateria, m.nombreclase, 0 AS opcion
//    FROM
//        tblalumno a
//    JOIN tblalumno_grupo ag ON ag.idalumno = a.idalumno
//    JOIN tblmateria_reprobada mr ON mr.idalumnogrupo = ag.idalumnogrupo
//    JOIN tbldetalle_reprobada dr ON dr.idreprobada = mr.idreprobada
//    JOIN tblhorario h ON h.idhorario = dr.idhorario
//    JOIN tblprofesor_materia pm ON pm.idprofesormateria = dr.idprofesormateria
//    JOIN tblmateria m ON m.idmateria = pm.idmateria
//    WHERE
//        dr.idhorario = h.idhorario
//            AND h.idperiodo = $idperiodo
//            AND h.idgrupo = $idgrupo
//    GROUP BY dr.idprofesormateria) tbl GROUP BY idprofesormateria";
//
//        $query = $this->db->query($sql);
//        if ($query->num_rows() > 0) {
//            return $query->result();
//        } else {
//            return false;
//        }
//    }
    public function calificacionFinalNormal($idgrupo, $idperiodo = '', $idprofesormateria = '', $idalumno = '') {
        $sql = "SELECT 
    c.idoportunidadexamen,
    c.calificacion,
    c.idunidad,
    oe.numero,
    h.idgrupo,
    h.idperiodo,
    FORMAT(SUM(c.calificacion) / COUNT(c.idunidad),
        2) AS calificacionfinal,
    hd.idmateria AS idprofesormateria,
    MAX(oe.numero) as numero
FROM
    tblhorario h
        INNER JOIN
    tblhorario_detalle hd ON h.idhorario = hd.idhorario
        INNER JOIN
    tblcalificacion c ON c.idhorariodetalle = hd.idhorariodetalle
        INNER JOIN
    tbloportunidad_examen oe ON oe.idoportunidadexamen = c.idoportunidadexamen
WHERE
    h.idgrupo = $idgrupo AND h.idperiodo = $idperiodo
        AND hd.idmateria = $idprofesormateria
        AND c.idalumno = $idalumno
GROUP BY hd.idmateria , oe.numero ORDER BY oe.numero DESC";

        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function calificacionFinalReprobadas($idgrupo, $idperiodo = '', $idprofesormateria = '', $idalumno = '') {
        $sql = 'SELECT 
      
            c.idoportunidadexamen,
            c.calificacion,
            c.idunidad,
            oe.numero,
            h.idgrupo,
            h.idperiodo,
            format(sum(c.calificacion)/ count(c.idunidad),2) as calificacionfinal,
            hd.idmateria AS idprofesormateria,
            max(oe.numero)
    FROM
       tblhorario h  
    INNER JOIN tblhorario_detalle hd ON h.idhorario = hd.idhorario
    INNER JOIN tblcalificacion c ON c.idhorariodetalle = hd.idhorariodetalle
    INNER JOIN tbloportunidad_examen oe ON oe.idoportunidadexamen = c.idoportunidadexamen
    INNER JOIN tbldetalle_reprobada dr ON dr.idhorario = h.idhorario
    WHERE h.idgrupo = ' . $idgrupo . '
    AND h.idperiodo = ' . $idperiodo . '
    AND hd.idmateria = ' . $idprofesormateria . '
    AND dr.idprofesormateria = ' . $idprofesormateria . '
    AND c.idalumno = ' . $idalumno . '
   GROUP BY hd.idmateria , oe.numero ORDER BY oe.numero DESC';

        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function calificacionPorOportunidad($idgrupo = '', $idperiodo = '', $idalumno = '', $idoportunidad = '', $idprofesormateria, $opcion = '') {
        $sql = 'SELECT 
                c.idalumno,
                a.nombre, 
                a.apellidop,
                a.apellidom,
                hd.idmateria AS idprofesormateria,
                m.idmateria,
                m.nombreclase,
                FORMAT((SUM(c.calificacion) / COUNT(c.idunidad)),
                    2) AS calificacion
            FROM
                tblhorario h
                    INNER JOIN
                tblhorario_detalle hd ON h.idhorario = hd.idhorario
                    INNER JOIN
                tblcalificacion c ON c.idhorariodetalle = hd.idhorariodetalle
                    INNER JOIN
                tblprofesor_materia pm ON pm.idprofesormateria = hd.idmateria
                    INNER JOIN
                tblmateria m ON m.idmateria = pm.idmateria
                    INNER JOIN
                tblalumno a ON a.idalumno = c.idalumno
            WHERE
                c.idoportunidadexamen = ' . $idoportunidad . '
                AND h.idperiodo = ' . $idperiodo . '
                AND h.idgrupo = ' . $idgrupo . '';
        if (isset($idalumno) && !empty($idalumno)) {
            $sql .= ' AND c.idalumno = ' . $idalumno . '';
        }
        if (isset($idprofesormateria) && !empty($idprofesormateria)) {
            $sql .= ' AND hd.idmateria = ' . $idprofesormateria . '';
        }
        if (isset($opcion) && !empty($opcion) && $opcion == 'alumnos') {
            $sql .= ' GROUP BY c.idalumno';
        }
        if (isset($opcion) && !empty($opcion) && $opcion == 'materias') {
            $sql .= ' GROUP BY hd.idmateria';
        }
        if (isset($opcion) && !empty($opcion) && $opcion == 'calificacion') {
            $sql .= ' GROUP BY hd.idmateria , c.idalumno , c.idoportunidadexamen;';
        }


        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function calificacionPorOportunidadReprobados($idgrupo = '', $idperiodo = '', $idalumno = '', $idoportunidad = '', $idprofesormateria, $opcion = '') {
        $sql = 'SELECT 
                c.idalumno,
                a.nombre, 
                a.apellidop,
                a.apellidom,
                hd.idmateria AS idprofesormateria,
                m.idmateria,
                m.nombreclase,
                FORMAT((SUM(c.calificacion) / COUNT(c.idunidad)),
                    2) AS calificacion
            FROM
                tblhorario h
                    INNER JOIN
                tblhorario_detalle hd ON h.idhorario = hd.idhorario
                    INNER JOIN
                tblcalificacion c ON c.idhorariodetalle = hd.idhorariodetalle
                    INNER JOIN
                tblprofesor_materia pm ON pm.idprofesormateria = hd.idmateria
                    INNER JOIN
                tblmateria m ON m.idmateria = pm.idmateria
                    INNER JOIN
                tblalumno a ON a.idalumno = c.idalumno
                    INNER JOIN 
                tbldetalle_reprobada dr ON dr.idhorario = h.idhorario 
            WHERE
                c.idoportunidadexamen = ' . $idoportunidad . '
                AND h.idperiodo = ' . $idperiodo . '
                AND h.idgrupo = ' . $idgrupo . '';
        if (isset($idalumno) && !empty($idalumno)) {
            $sql .= ' AND c.idalumno = ' . $idalumno . '';
        }
        if (isset($idprofesormateria) && !empty($idprofesormateria)) {
            $sql .= ' AND hd.idmateria = dr.idprofesormateria';
            $sql .= ' AND hd.idmateria = ' . $idprofesormateria . '';
        }
        if (isset($opcion) && !empty($opcion) && $opcion == 'alumnos') {
            $sql .= ' GROUP BY c.idalumno';
        }
        if (isset($opcion) && !empty($opcion) && $opcion == 'materias') {
            $sql .= ' GROUP BY hd.idmateria';
        }
        if (isset($opcion) && !empty($opcion) && $opcion == 'calificacion') {
            $sql .= ' GROUP BY hd.idmateria , c.idalumno , c.idoportunidadexamen;';
        }


        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

}
