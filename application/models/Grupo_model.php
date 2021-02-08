<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Grupo_model extends CI_Model
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

    public function showAllGrupos($idplantel = '')
    {
        $this->db->select("g.idgrupo,g.idplantel, g.idespecialidad, g.nombregrupo,e.nombreespecialidad, t.idturno, t.nombreturno, n.idnivelestudio, n.nombrenivel, CASE niv.idniveleducativo 
        WHEN 3 THEN n.numeroromano
        WHEN 5 THEN n.numeroromano
        WHEN 1 THEN n.numeroordinaria
        WHEN 2 THEN n.numeroordinaria
        WHEN 4 THEN n.numeroordinaria
        ELSE ''
    END AS nivelgrupo");
        $this->db->from('tblgrupo g');
        $this->db->join('tblturno t', 't.idturno = g.idturno');
        $this->db->join('tblespecialidad e', 'e.idespecialidad = g.idespecialidad');
        $this->db->join('tblnivelestudio n', 'n.idnivelestudio = g.idnivelestudio');
        $this->db->join('tblplantel pla', 'pla.idplantel = g.idplantel');
        $this->db->join('tblniveleducativo niv', 'pla.idniveleducativo = niv.idniveleducativo');
        if (isset($idplantel) && !empty($idplantel)) {
            $this->db->where('g.idplantel', $idplantel);
        }
        $this->db->order_by('n.nombrenivel ASC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function showAllCalificacionUnidad($idunidad = '', $idhorariodetalle = '', $idoportunidadexamen = '')
    {
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
    public function showAllCalificacionUnidadXMateria($idunidad = '', $idhorario = '', $idmateria = '', $idoportunidadexamen = '')
    {
        $this->db->select('c.idcalificacion');
        $this->db->from('tblcalificacion c');
        $this->db->join('tblhorario_detalle hd', 'c.idhorariodetalle = hd.idhorariodetalle');
        $this->db->join('tblprofesor_materia pm', 'pm.idprofesormateria = hd.idmateria');
        $this->db->where('c.idunidad', $idunidad);
        $this->db->where('hd.idhorario', $idhorario);
        $this->db->where('pm.idmateria', $idmateria);
        $this->db->where('c.idoportunidadexamen', $idoportunidadexamen);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function showAllOportunidadesExamen($idplantel = '')
    {
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


    public function showAllPeriodos($idplantel = '')
    {
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

    public function validarAddGrupo($idnivelestudio = '', $idturno = '', $nombregrupo = '', $idplantel = '')
    {
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

    public function validarUpdateGrupo($idnivelestudio = '', $idturno = '', $nombregrupo = '', $idgrupo, $idplantel = '')
    {
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

    public function showAllNiveles()
    {
        $this->db->select('n.idnivelestudio,n.nombrenivel,n.numeroordinaria,n.numeroromano');
        $this->db->from('tblnivelestudio n');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function validarMesUnidad($idmes, $idunidad)
    {
        $this->db->select('um.idmes');
        $this->db->from('tblunidad_mes um');
        $this->db->where('um.idmes', $idmes);
        $this->db->where('um.idunidad', $idunidad);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function showAllOportunidades($idplantel)
    {
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
    public function showAllCalificacionOportunidad($idhorariodetalle, $idoportunidad)
    {
        $this->db->select('a.nombre, a.apellidop, a.apellidom, c.calificacion');
        $this->db->from('tblcalificacion c');
        $this->db->join('tblalumno a', 'a.idalumno = c.idalumno');
        $this->db->where('c.idoportunidadexamen', $idoportunidad);
        $this->db->where('c.idhorariodetalle', $idhorariodetalle);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function primeraOportunidad($idplantel)
    {
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

    public function showAllTurnos()
    {
        $this->db->select('t.*');
        $this->db->from('tblturno t');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function detalleAlumnoGrupo($idalumno, $idperiodo)
    {
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

    public function detalleClase($idhorariodetalle = '')
    {
        $this->db->select('m.nombreclase,m.idmateria,pe.activo, m.idmateria, hd.idhorario, pm.idprofesormateria,ne.nombrenivel, g.nombregrupo');
        $this->db->from('tblhorario_detalle hd');
        $this->db->join('tblprofesor_materia pm', 'hd.idmateria = pm.idprofesormateria');
        $this->db->join('tblmateria m', 'm.idmateria = pm.idmateria');
        $this->db->join('tblhorario h', 'h.idhorario = hd.idhorario');
        $this->db->join('tblgrupo g', 'g.idgrupo = h.idgrupo');
        $this->db->join('tblnivelestudio ne', 'ne.idnivelestudio = g.idnivelestudio');
        $this->db->join('tblperiodo pe', 'pe.idperiodo = h.idperiodo');
        $this->db->where('hd.idhorariodetalle', $idhorariodetalle);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function searchGrupo($match, $idplantel = '')
    {
        $field = array(
            'g.nombregrupo',
            't.nombreturno',
            'n.nombrenivel',
            'e.nombreespecialidad'
        );
        $this->db->select("g.idgrupo, g.nombregrupo, t.idturno,e.idespecialidad,e.nombreespecialidad, t.nombreturno, n.idnivelestudio, n.nombrenivel, CASE niv.idniveleducativo 
        WHEN 3 THEN n.numeroromano
        WHEN 5 THEN n.numeroromano
        WHEN 1 THEN n.numeroordinaria
        WHEN 2 THEN n.numeroordinaria
        WHEN 4 THEN n.numeroordinaria
        ELSE ''
    END AS nivelgrupo");
        $this->db->from('tblgrupo g');
        $this->db->join('tblturno t', 't.idturno = g.idturno');
        $this->db->join('tblespecialidad e', 'e.idespecialidad = g.idespecialidad');
        $this->db->join('tblnivelestudio n', 'n.idnivelestudio = g.idnivelestudio');
        $this->db->join('tblplantel pla', 'pla.idplantel = g.idplantel');
        $this->db->join('tblniveleducativo niv', 'pla.idniveleducativo = niv.idniveleducativo');
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

    public function showAllGruposProfesor($idprofesor = '')
    {
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
    opcion,
    nivelgrupo,
    nombreespecialidad
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
            1 as opcion,
               CASE niv.idniveleducativo 
                WHEN 3 THEN ne.numeroromano
                WHEN 5 THEN ne.numeroromano
                WHEN 1 THEN ne.numeroordinaria
                WHEN 2 THEN ne.numeroordinaria
                WHEN 4 THEN ne.numeroordinaria
					ELSE ''
				END AS nivelgrupo,
            e.nombreespecialidad
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
    JOIN tblplantel pla ON pla.idplantel = g.idplantel
    JOIN tblniveleducativo niv ON pla.idniveleducativo = niv.idniveleducativo
    JOIN tblespecialidad e ON e.idespecialidad = g.idespecialidad
    WHERE
         pe.activo = 1 AND h.activo = 1 
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

    public function dia($idhorariodetalle = '')
    {
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

    public function detalleCalificacion($idcalificacion = '')
    {
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
    public function detalleCalificacionSecundaria($idcalificacion = '')
    {
        # code...
        $this->db->select('c.idcalificacion, dc.iddetallecalificacion, dc.calificacion');
        $this->db->from('tblcalificacion c');
        $this->db->join('tbldetalle_calificacion dc', 'dc.idcalificacion = c.idcalificacion');
        $this->db->where('c.idcalificacion', $idcalificacion);
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->first_row();
        } else {
            return false;
        }
    }

    public function detalleCalificacionUnidad($idunidad = '', $idhorariodetalle)
    {
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
    public function detalleCalificacionUnidadXMateriaOportunidad($idunidad = '', $idhorario, $idmateria, $oportunidad)
    {
        # code...
        $this->db->select('c.idhorariodetalle, c.fecharegistro');
        $this->db->from('tblcalificacion c');
        $this->db->join('tblhorario_detalle hd', 'hd.idhorariodetalle = c.idhorariodetalle');
        $this->db->join('tblprofesor_materia pm', 'pm.idprofesormateria =  hd.idmateria');
        $this->db->where('c.idunidad', $idunidad);
        $this->db->where('hd.idhorario', $idhorario);
        $this->db->where('pm.idmateria', $idmateria);
        $this->db->where('c.idoportunidadexamen', $oportunidad);
        $this->db->order_by('c.fecharegistro ASC');
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function detalleCalificacionUnidadXMateria($idunidad = '', $idhorario, $idmateria)
    {
        # code...
        $this->db->select('c.idhorariodetalle, c.fecharegistro');
        $this->db->from('tblcalificacion c');
        $this->db->join('tblhorario_detalle hd', 'hd.idhorariodetalle = c.idhorariodetalle');
        $this->db->join('tblprofesor_materia pm', 'pm.idprofesormateria =  hd.idmateria');
        $this->db->where('c.idunidad', $idunidad);
        $this->db->where('hd.idhorario', $idhorario);
        $this->db->where('pm.idmateria', $idmateria);
        $this->db->order_by('c.fecharegistro ASC');
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function detalleCalificacionUnidadXMes($idunidad = '', $idhorario, $idmateria, $idmes)
    {
        # code...
        $this->db->select('c.idcalificacion, date(c.fecharegistro) as fecharegistro');
        $this->db->from('tblcalificacion c');
        $this->db->join('tbldetalle_calificacion dc', 'dc.idcalificacion = c.idcalificacion');
        $this->db->join('tblhorario_detalle hd', 'hd.idhorariodetalle = c.idhorariodetalle');
        $this->db->join('tblprofesor_materia pm', 'pm.idprofesormateria = hd.idmateria');
        $this->db->where('c.idunidad', $idunidad);
        $this->db->where('hd.idhorario', $idhorario);
        $this->db->where('pm.idmateria', $idmateria);
        $this->db->where('dc.idmes', $idmes);
        $this->db->order_by('c.fecharegistro ASC');
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->first_row();
        } else {
            return false;
        }
    }
    public function listaCalificacionXUnidad($idunidad = '', $idhorariodetalle)
    {
        # code...
        $this->db->select('c.idcalificacion, date(c.fecharegistro) as fecharegistro');
        $this->db->from('tblcalificacion c');
        $this->db->where('c.idunidad', $idunidad);
        $this->db->where('c.idhorariodetalle', $idhorariodetalle);
        $this->db->order_by('c.fecharegistro ASC');
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function detalleHorarioDetalle($idhorariodetalle)
    {
        # code...
        $this->db->select('m.idmateria as idmateriareal,g.idgrupo,n.nombrenivel,m.clave, hd.idmateria as idprofesormateria, pm.idprofesormateria as profesormateria, pe.activo, t.nombreturno, n.numeroordinaria,h.idhorario,m.idclasificacionmateria,m.secalifica, m.nombreclase, pm.idmateria,h.idgrupo,h.idperiodo, m.unidades,p.nombre, p.apellidop, p.apellidom');
        $this->db->from('tblhorario_detalle hd');
        $this->db->join('tblprofesor_materia pm', 'hd.idmateria = pm.idprofesormateria');
        $this->db->join('tblhorario h', 'h.idhorario  = hd.idhorario');
        $this->db->join('tblmateria m', 'm.idmateria = pm.idmateria');
        $this->db->join('tblprofesor p', 'p.idprofesor = pm.idprofesor');
        $this->db->join('tblgrupo g', 'g.idgrupo = h.idgrupo');
        $this->db->join('tblturno t', 'g.idturno = t.idturno');
        $this->db->join('tblnivelestudio n', 'n.idnivelestudio = g.idnivelestudio');
        $this->db->join('tblperiodo pe', 'pe.idperiodo = h.idperiodo');
        $this->db->where('hd.idhorariodetalle', $idhorariodetalle);
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->first_row();
        } else {
            return false;
        }
    }


    public function detalleUnidad($idunidad)
    {
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
    }
    public function totalAsistencias($idunidad, $idhoraridetalle, $idalumno)
    {
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

    public function allTarea($idhorariodetalle = '')
    {
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

    public function listaPlaneacion($idunidad, $idhorariodetalle = '')
    {
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
    public function showAllDetalleCalificacion($idcalificacion = '')
    {
        # code...
        $this->db->select('dc.*');
        $this->db->from('tbldetalle_calificacion dc');
        $this->db->where('dc.idcalificacion', $idcalificacion);
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function calificacionXMes($idalumno, $idhorariodetalle, $idmes)
    {
        $this->db->select('dc.calificacion');
        $this->db->from('tbldetalle_calificacion dc');
        $this->db->join('tblcalificacion c', 'c.idcalificacion = dc.idcalificacion');
        $this->db->join('tblhorario_detalle hd', 'hd.idhorariodetalle = c.idhorariodetalle');
        $this->db->where('c.idalumno', $idalumno);
        $this->db->where('dc.idmes', $idmes);
        $this->db->where('c.idhorariodetalle', $idhorariodetalle);
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function sumaCalificacion($idcalificacion, $iddetallecalificacion)
    {
        $this->db->select('count(dc.calificacion) as contador, sum(dc.calificacion) as calificacion');
        $this->db->from('tbldetalle_calificacion dc');
        $this->db->where('dc.idcalificacion', $idcalificacion);
        $this->db->where('dc.iddetallecalificacion !=', $iddetallecalificacion);
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function detalleMateriaCalificacion($idcalificacion = '')
    {
        # code...
        $this->db->select('dc.iddetallecalificacion,dc.calificacion, dc.idcalificacion, m.nombreclase, a.nombre, a.apellidop, a.apellidom,TIMESTAMPDIFF(day,curdate(),dc.fecharegistro) as dias,me.nombremes, u.nombreunidad');
        $this->db->from('tbldetalle_calificacion dc');
        $this->db->join('tblcalificacion c', 'c.idcalificacion = dc.idcalificacion');
        $this->db->join('tblhorario_detalle hd', 'hd.idhorariodetalle = c.idhorariodetalle');
        $this->db->join('tblprofesor_materia pm', 'pm.idprofesormateria = hd.idmateria');
        $this->db->join('tblmateria m', 'pm.idmateria = m.idmateria');
        $this->db->join('tblalumno a', 'a.idalumno =  c.idalumno');
        $this->db->join('tblmes me', 'me.idmes =  dc.idmes');
        $this->db->join('tblunidad u', 'u.idunidad =  c.idunidad');
        $this->db->where('dc.idcalificacion', $idcalificacion);
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function validarMesDetalleCalificacion($idmes, $idcalificacion = '')
    {
        # code...
        $this->db->select('dc.*');
        $this->db->from('tbldetalle_calificacion dc');
        $this->db->where('dc.idcalificacion', $idcalificacion);
        $this->db->where('dc.idmes', $idmes);
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function validarAgregarCalificacion($idunidad, $idhorariodetalle = '', $idoportunidad = '', $idalumno = '')
    {
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

    public function validarAgregarCalificacionXMateria($idunidad, $idhorario = '', $idmateria = '', $idoportunidad = '', $idalumno = '')
    {
        # code...
        $this->db->select('c.idcalificacion, c.calificacion, date(c.fecharegistro) as fecharegistro');
        $this->db->from('tblcalificacion c');
        $this->db->join('tblunidad u', 'c.idunidad = u.idunidad');
        $this->db->join('tblhorario_detalle hd', 'c.idhorariodetalle = hd.idhorariodetalle');
        $this->db->join('tblprofesor_materia pm', 'pm.idprofesormateria = hd.idmateria');
        $this->db->join('tbloportunidad_examen op', 'op.idoportunidadexamen = c.idoportunidadexamen');
        $this->db->where('c.idalumno', $idalumno);
        if (isset($idoportunidad) && !empty($idoportunidad)) {
            $this->db->where('c.idoportunidadexamen', $idoportunidad);
        }
        $this->db->where('hd.idhorario', $idhorario);
        $this->db->where('pm.idmateria', $idmateria);
        $this->db->where('c.idunidad', $idunidad);
        $this->db->order_by('c.fecharegistro ASC');
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function validarSiLePerteneceLaMateria($idmateria, $idprofesor, $idhorario)
    {
        $this->db->select('hd.*');
        $this->db->from('tblhorario_detalle hd');
        $this->db->join('tblprofesor_materia pm', 'pm.idprofesormateria = hd.idmateria');
        $this->db->where('hd.idhorario', $idhorario);
        $this->db->where('pm.idprofesor', $idprofesor);
        $this->db->where('pm.idmateria', $idmateria);
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function validarAgregarAsistencia($fecha, $idhorariodetalle = '', $idunidad = '')
    {
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
    public function validarAgregarAsistenciaXMateria($fecha, $idhorario = '', $idmateria = '')
    {
        # code...
        $this->db->select('c.*');
        $this->db->from('tblasistencia c');
        $this->db->join('tblhorario_detalle hd', 'hd.idhorariodetalle = c.idhorariodetalle');
        $this->db->join('tblprofesor_materia pm', 'hd.idmateria = pm.idprofesormateria');
        $this->db->where('hd.idhorario', $idhorario);
        $this->db->where('pm.idmateria', $idmateria);
        $this->db->where('c.fecha', $fecha);
        //$this->db->where('c.idunidad', $idunidad);
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function unidades($idplantel = '', $unidades_materia = '')
    {
        # code...
        $this->db->select('u.idunidad, u.nombreunidad, u.numero');
        $this->db->from('tblunidad u');
        $this->db->where('u.idplantel', $idplantel);
        if (isset($unidades_materia) && !empty($unidades_materia)) {
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
    public function unidadesConCalificaciones($idplantel = '', $idhorario = '')
    {
        # code...
        $this->db->select('u.idunidad, u.nombreunidad');
        $this->db->from('tblunidad u');
        $this->db->join('tblcalificacion c', 'c.idunidad = u.idunidad');
        $this->db->join('tblhorario_detalle hd', 'c.idhorariodetalle = hd.idhorariodetalle');
        $this->db->where('hd.idhorario', $idhorario);
        $this->db->where('u.idplantel', $idplantel);
        $this->db->order_by('u.numero asc');
        $this->db->group_by('c.idunidad, hd.idhorario');

        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function mesesPorUnidad($idhorario = '', $idunidad)
    {
        # code...
        $this->db->select('m.idmes,m.nombremes');
        $this->db->from('tbldetalle_calificacion dc');
        $this->db->join('tblcalificacion c', 'c.idcalificacion = dc.idcalificacion');
        $this->db->join('tblmes m', 'dc.idmes = m.idmes');
        $this->db->join('tblhorario_detalle hd', 'c.idhorariodetalle = hd.idhorariodetalle');
        $this->db->where('hd.idhorario', $idhorario);
        $this->db->where('c.idunidad', $idunidad);
        $this->db->order_by('m.enumeracion asc');
        $this->db->group_by('dc.idmes');
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function obtenerCalificacionXMeses($idcalificacion = '', $idmes)
    {
        # code...
        $this->db->select('dc.calificacion');
        $this->db->from('tbldetalle_calificacion dc');
        $this->db->where('dc.idcalificacion', $idcalificacion);
        $this->db->where('dc.idmes', $idmes);
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->first_row();
        } else {
            return false;
        }
    }

    public function motivoAsistencia()
    {
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

    public function addPlaneacion($data)
    {
        $this->db->insert('tblplaneacion', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    public function addDetalleCalificacion($data)
    {
        $this->db->insert('tbldetalle_calificacion', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function addAsistencia($data)
    {
        $this->db->insert('tblasistencia', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function addTarea($data)
    {
        $this->db->insert('tbltarea', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function addGrupo($data)
    {
        $this->db->insert('tblgrupo', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function addCalificacion($data)
    {
        $this->db->insert('tblcalificacion', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function eliminarPlaneacion($idplaneacion = '')
    {
        # code...
        $this->db->where('idplaneacion', $idplaneacion);
        $this->db->delete('tblplaneacion');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function eliminarAsistenciaFecha($idhorariodetalle = '', $fecha = '')
    {
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

    public function eliminarCalificacionUnidad($idunidad = '', $idhorariodetalle = '', $idoportunidadexamen = '')
    {
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
    public function eliminarDetalleCalificacionUnidadSecu($idcalificacion = '')
    {

        $this->db->where('idcalificacion', $idcalificacion);
        $this->db->delete('tbldetalle_calificacion');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function eliminarDetalleCalificacionXId($iddetallecalificacion = '')
    {

        $this->db->where('iddetallecalificacion', $iddetallecalificacion);
        $this->db->delete('tbldetalle_calificacion');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function eliminarTarea($idtarea = '')
    {
        # code...
        $this->db->where('idtarea', $idtarea);
        $this->db->delete('tbltarea');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteGrupo($idgrupo = '')
    {
        # code...
        $this->db->where('idgrupo', $idgrupo);
        $this->db->delete('tblgrupo');

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteCalificacion($idcalificacion = '')
    {
        # code...
        $this->db->where('idcalificacion', $idcalificacion);
        $this->db->delete('tblcalificacion');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function deleteCalificacionSecu($idcalificacion = '')
    {
        # code...
        $this->db->where('iddetallecalificacion', $idcalificacion);
        $this->db->delete('tbldetalle_calificacion');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteAsistencia($idasistencia = '')
    {
        # code...
        $this->db->where('idasistencia', $idasistencia);
        $this->db->delete('tblasistencia');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function alumnosGrupoPreescolar($idhorario, $idprofesor)
    {
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

    public function alumnosGrupo($idhorario, $idprofesormateria = '', $idmateria, $idestatus = '')
    {

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
    INNER JOIN tblprofesor_materia pm ON pm.idprofesormateria = hd.idmateria
    INNER JOIN tblmateria m ON m.idmateria = pm.idmateria
    WHERE
        p.idperiodo = ag.idperiodo  
        AND m.secalifica = 1
            AND (h.activo = 1 OR p.activo = 1)
            AND ag.activo = 1";
        if (isset($idprofesormateria) && !empty($idprofesormateria)) {
            $sql .= " AND hd.idmateria = $idprofesormateria";
        }
        if (isset($idestatus) && !empty($idestatus) && $idestatus == 1) {
            $sql .= " AND a.idalumnoestatus = 1";
        }

        $sql .= " AND h.idhorario = $idhorario";
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
    INNER JOIN tblprofesor_materia pm ON pm.idprofesormateria = hd.idmateria
    INNER JOIN tblmateria m ON m.idmateria = pm.idmateria
    WHERE   (h.activo = 1 OR p.activo = 1)";
        if (isset($idprofesormateria) && !empty($idprofesormateria)) {
            $sql .= " AND dr.idprofesormateria = $idprofesormateria";
        }
        $sql .= " AND mr.estatus = 1  AND dr.idhorario = $idhorario";
        if (isset($idestatus) && !empty($idestatus) && $idestatus == 1) {
            $sql .= " AND a.idalumnoestatus = 1";
        }
        $sql .= "  GROUP BY ag.idalumno) alumnos
            ORDER BY apellidop ASC";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function alumnosGrupoAsistencia($idhorario, $idprofesormateria = '', $idmateria, $idestatus = '')
    {

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
    INNER JOIN tblprofesor_materia pm ON pm.idprofesormateria = hd.idmateria
    INNER JOIN tblmateria m ON m.idmateria = pm.idmateria
    WHERE
        p.idperiodo = ag.idperiodo                 
            AND (h.activo = 1 OR p.activo = 1)
            AND ag.activo = 1";
        if (isset($idprofesormateria) && !empty($idprofesormateria)) {
            $sql .= " AND hd.idmateria = $idprofesormateria";
        }
        if (isset($idestatus) && !empty($idestatus) && $idestatus == 1) {
            $sql .= " AND a.idalumnoestatus = 1";
        }

        $sql .= " AND h.idhorario = $idhorario";
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
    INNER JOIN tblprofesor_materia pm ON pm.idprofesormateria = hd.idmateria
    INNER JOIN tblmateria m ON m.idmateria = pm.idmateria
    WHERE   (h.activo = 1 OR p.activo = 1)";
        if (isset($idprofesormateria) && !empty($idprofesormateria)) {
            $sql .= " AND dr.idprofesormateria = $idprofesormateria";
        }
        $sql .= " AND mr.estatus = 1  AND dr.idhorario = $idhorario";
        if (isset($idestatus) && !empty($idestatus) && $idestatus == 1) {
            $sql .= " AND a.idalumnoestatus = 1";
        }
        $sql .= "  GROUP BY ag.idalumno) alumnos
            ORDER BY apellidop ASC";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function alumnosGrupoTaller($idhorario, $idprofesormateria = '', $idmateria, $idestatus = '')
    {

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
    INNER JOIN tblhorario_detalle_cursos hdc ON hdc.idhorario = hd.idhorario
    WHERE
        hdc.idprofesormateria = hd.idmateria
       AND  p.idperiodo = ag.idperiodo
       AND hdc.idalumno = a.idalumno 
            AND (h.activo = 1 OR p.activo = 1)
            AND ag.activo = 1";
        if (isset($idprofesormateria) && !empty($idprofesormateria)) {
            $sql .= " AND hd.idmateria = $idprofesormateria";
        }
        if (isset($idestatus) && !empty($idestatus) && $idestatus == 1) {
            $sql .= " AND a.idalumnoestatus = 1";
        }

        $sql .= " AND h.idhorario = $idhorario";
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
        $sql .= " AND mr.estatus = 1  AND dr.idhorario = $idhorario";
        if (isset($idestatus) && !empty($idestatus) && $idestatus == 1) {
            $sql .= " AND a.idalumnoestatus = 1";
        }
        $sql .= "  GROUP BY ag.idalumno) alumnos
            ORDER BY apellidop ASC";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function listaAsistencia($idalumno = '', $idhorario = '', $fecha = '', $idhorariodetalle = '', $idunidad = '')
    {
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

    public function listaAsistenciaBuscar($idalumno = '', $idhorario = '', $fecha = '', $idhorariodetalle = '', $idmotivo = '')
    {
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

    public function listaAsistenciaGeneral($idalumno = '', $idhorario = '', $fecha = '', $idhorariodetalle = '', $motivo = '')
    {
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

    public function updatePlaneacion($id, $field)
    {
        $this->db->where('idplaneacion', $id);
        $this->db->update('tblplaneacion', $field);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function updateTarea($id, $field)
    {
        $this->db->where('idtarea', $id);
        $this->db->update('tbltarea', $field);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function updateDetalleCalificacion($id, $field)
    {
        $this->db->where('iddetallecalificacion', $id);
        $this->db->update('tbldetalle_calificacion', $field);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function updateAsistencia($id, $field)
    {
        $this->db->where('idasistencia', $id);
        $this->db->update('tblasistencia', $field);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function updateGrupo($id, $field)
    {
        $this->db->where('idgrupo', $id);
        $this->db->update('tblgrupo', $field);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function updateCalificacion($id, $field)
    {
        $this->db->where('idcalificacion', $id);
        $this->db->update('tblcalificacion', $field);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function obtenerCalificacion($idalumno = '', $idunidad = '', $idhorariodetalle = '')
    {
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
    public  function obtenerCalificacionValidandoMateria($idalumno = '', $idunidad = '', $idhorario = '', $idmateria = '')
    {
        $this->db->select('c.idcalificacion, c.calificacion, date(c.fecharegistro) as fecharegistro,COALESCE((SELECT(SUM(dc.calificacion) / COUNT(dc.idcalificacion)) FROM tbldetalle_calificacion dc WHERE dc.idcalificacion =  c.idcalificacion),0) as calificaciondetalle');
        $this->db->from('tblcalificacion c');
        $this->db->join('tblunidad u', 'c.idunidad = u.idunidad');
        $this->db->join('tblhorario_detalle hd', 'c.idhorariodetalle = hd.idhorariodetalle');
        $this->db->join('tblprofesor_materia pm', 'pm.idprofesormateria = hd.idmateria');
        $this->db->join('tbloportunidad_examen op', 'op.idoportunidadexamen = c.idoportunidadexamen');
        $this->db->where('c.idalumno', $idalumno);
        $this->db->where('op.numero', 1);
        $this->db->where('hd.idhorario', $idhorario);
        $this->db->where('pm.idmateria', $idmateria);
        $this->db->where('c.idunidad', $idunidad);
        $this->db->order_by('c.fecharegistro ASC');
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->first_row();
        } else {
            return false;
        }
    }
    public function obtenerCalificacionPreescolar($idalumno = '', $idunidad = '', $idprofesor = '', $idhorario)
    {
        # code...
        $this->db->select('');
        $this->db->from('tblcalificacion c');
        $this->db->join('tblunidad u', 'c.idunidad = u.idunidad');
        $this->db->where('c.idalumno', $idalumno);;
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

    public function calificacionPorMateria($idalumno = '', $idprofesormateria = '', $idhorario = '')
    {
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

    public function obtenerCalificacionRecuperado($idalumno = '', $idoportunidad = '', $idhorariodetalle = '')
    {
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

    public function obtenerCalificacionRecuperadoXMateria($idalumno = '', $idoportunidad = '', $idhorario = '', $idprofesormateria = '')
    {
        # code...
        $this->db->select('a.nombre, a.apellidop, a.apellidom, c.idcalificacion, (SUM(c.calificacion)/(( COUNT(c.idunidad) ))) as calificacion, date(c.fecharegistro) as fecharegistro');
        $this->db->from('tblcalificacion c');
        $this->db->join('tblunidad u', 'c.idunidad = u.idunidad');
        $this->db->join('tblalumno a', 'a.idalumno = c.idalumno');
        $this->db->join('tblhorario_detalle hd', 'hd.idhorariodetalle = c.idhorariodetalle');
        $this->db->join('tblprofesor_materia pm', 'pm.idprofesormateria = hd.idmateria');
        $this->db->join('tblhorario h', 'h.idhorario = hd.idhorario');
        $this->db->where('c.idalumno', $idalumno);
        $this->db->where('hd.idhorario', $idhorario);
        $this->db->where('pm.idprofesormateria', $idprofesormateria);
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


    public function obtenerAlumnoRecuperar($idhorario, $idoportunidad, $idprofesormateria)
    {
        $query = $this->db->query("SELECT
        CASE
            WHEN numero = 1
            AND unidadesregistradas = unidades THEN 'SI'
            WHEN numero > 1 THEN 'SI'
            ELSE 'NO'
        END AS mostrar,
        numero ,
        idalumno,
        apellidop,
        apellidom,
        nombre,
        calificacion ,
        unidadesregistradas,
        unidades
    FROM
        (
        SELECT
            oe.numero , a2.idalumno , a2.apellidop, a2.apellidom , a2.nombre ,
            CASE
                /* PRIMARIA */
                WHEN p1.idniveleducativo = 1 THEN
                CASE
                    WHEN oe.numero = 1 THEN FORMAT((
                    SELECT
                        ((SUM(dc1.calificacion)/ 8)/(
                        SELECT
                            COUNT(u2.idunidad)
                        FROM
                            tblunidad u2
                        WHERE
                            u2.idplantel = a2.idplantel))
                    FROM
                        tbldetalle_calificacion dc1
                    WHERE
                        dc1.idcalificacion = c1.idcalificacion), 1)
                    ELSE SUM(c1.calificacion)
                END /* SECUNDARIA */
                WHEN p1.idniveleducativo = 2 THEN
                CASE
                    WHEN oe.numero = 1 THEN FORMAT((
                    SELECT
                        ((SUM(dc1.calificacion)/ 8)/(
                        SELECT
                            COUNT(u2.idunidad)
                        FROM
                            tblunidad u2
                        WHERE
                            u2.idplantel = a2.idplantel))
                    FROM
                        tbldetalle_calificacion dc1
                    WHERE
                        dc1.idcalificacion = c1.idcalificacion), 1)
                    ELSE SUM(c1.calificacion)
                END /* PREPA */
                WHEN p1.idniveleducativo = 3 THEN
                CASE
                    WHEN oe.numero = 1 THEN (SUM(c1.calificacion) / (
                    SELECT
                        COUNT(u2.idunidad)
                    FROM
                        tblunidad u2
                    WHERE
                        u2.idplantel = a2.idplantel))
                    ELSE SUM(c1.calificacion)
                END /* LICENCIATUA */
                WHEN p1.idniveleducativo = 5 THEN
                CASE
                    WHEN oe.numero = 1 THEN (SUM(c1.calificacion) / m2.unidades)
                    ELSE SUM(c1.calificacion)
                END
                ELSE ''
            END AS calificacion,
            CASE
                /* PRIMARIA */
                WHEN p1.idniveleducativo = 1 THEN
                CASE
                    WHEN oe.numero = 1 THEN (
                    SELECT
                        COUNT(dc3.idcalificacion)
                    FROM
                        tbldetalle_calificacion dc3
                    WHERE
                        dc3.idcalificacion = c1.idcalificacion)
                    ELSE 28
                END /* SECUNDARIA */
                WHEN p1.idniveleducativo = 2 THEN
                CASE
                    WHEN oe.numero = 1 THEN (
                    SELECT
                        COUNT(dc2.idcalificacion)
                    FROM
                        tbldetalle_calificacion dc2
                    WHERE
                        dc2.idcalificacion = c1.idcalificacion)
                    ELSE 28
                END /* PREPA */
                WHEN p1.idniveleducativo = 3 THEN
                CASE
                    WHEN oe.numero = 1 THEN COUNT(c1.idcalificacion)
                    ELSE 28
                END /* LICENCIATUA */
                WHEN p1.idniveleducativo = 5 THEN
                CASE
                    WHEN oe.numero = 1 THEN COUNT(c1.idcalificacion)
                    ELSE 28
                END
                ELSE ''
            END AS unidadesregistradas,
            CASE
                /* PRIMARIA */
                WHEN p1.idniveleducativo = 1 THEN 8 /* SECUNDARIA */
                WHEN p1.idniveleducativo = 2 THEN 8 /* PREPA */
                WHEN p1.idniveleducativo = 3 THEN (
                SELECT
                    COUNT(u2.idunidad)
                FROM
                    tblunidad u2
                WHERE
                    u2.idplantel = a2.idplantel)/* LICENCIATUA */
                WHEN p1.idniveleducativo = 5 THEN m2.unidades
                ELSE ''
            END AS unidades
        FROM
            tblcalificacion c1
        INNER JOIN tblhorario_detalle hd ON
            hd.idhorariodetalle = c1.idhorariodetalle
        INNER JOIN tbloportunidad_examen oe ON
            c1.idoportunidadexamen = oe.idoportunidadexamen
        INNER JOIN tblalumno a2 ON
            a2.idalumno = c1.idalumno
        INNER JOIN tblplantel p1 ON
            p1.idplantel = a2.idplantel
        INNER JOIN tblprofesor_materia pm2 ON
            pm2.idprofesormateria = hd.idmateria
        INNER JOIN tblmateria m2 ON
            m2.idmateria = pm2.idmateria
        INNER JOIN tblhorario h ON
            h.idhorario = hd.idhorario
        WHERE
            hd.idmateria = $idprofesormateria
            AND hd.idhorario = $idhorario
            AND c1.idoportunidadexamen = $idoportunidad
            AND a2.idalumno NOT IN (
            SELECT
                ag.idalumno
            FROM
                tblalumno_grupo ag
            INNER JOIN tblmateria_reprobada mr ON
                ag.idalumnogrupo = mr.idalumnogrupo
            INNER JOIN tbldetalle_reprobada dr ON
                mr.idreprobada = dr.idreprobada
            WHERE
                dr.idprofesormateria = idprofesormateria
                AND mr.estatus = 1)
        GROUP BY
            c1.idoportunidadexamen, a2.idalumno, pm2.idprofesormateria, hd.idhorario, h.idperiodo) tbl ORDER BY apellidop ASC
    ");
        if ($this->db->affected_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function obtenerOportunidadAnterior($numero = '', $idplantel = '')
    {
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

    public function obtenerUnidadUno($numero = '')
    {
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

    public function obtenerUnidades($numero)
    {
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

    public function detalleOportunidad($idoportunidad = '')
    {
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

    public function listaAlumnosGrupo($idperiodo, $idgrupo, $idplantel)
    {
        $this->db->select('a.idalumno,a.nombre, a.apellidop, a.apellidom');
        $this->db->from('tblalumno a');
        $this->db->join('tblalumno_grupo ag', 'ag.idalumno = a.idalumno');
        $this->db->join('tblalumno_estatus ae', 'a.idalumnoestatus = ae.idestatusalumno');
        $this->db->where('ag.idperiodo', $idperiodo);
        $this->db->where('ag.idgrupo', $idgrupo);
        $this->db->where('a.idalumnoestatus', 1);
        $this->db->order_by('a.apellidop ASC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function listaAlumnosPorMateria($idperiodo, $idgrupo, $idplantel)
    {
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

    public function listaAlumnosGrupoReprobados($idperiodo, $idgrupo, $idplantel = '')
    {
        $this->db->select('a.idalumno,a.nombre, a.apellidop, a.apellidom, dr.idprofesormateria');
        $this->db->from('tblalumno a');
        $this->db->join('tblalumno_grupo ag', 'ag.idalumno = a.idalumno');
        $this->db->join('tblmateria_reprobada mr', 'mr.idalumnogrupo = ag.idalumnogrupo');
        $this->db->join('tbldetalle_reprobada dr', 'dr.idreprobada = mr.idreprobada');
        $this->db->join('tblhorario h', 'h.idhorario = dr.idhorario');
        $this->db->join('tblalumno_estatus ae', 'a.idalumnoestatus = ae.idestatusalumno');
        $this->db->where('h.idperiodo', $idperiodo);
        $this->db->where('h.idgrupo', $idgrupo);
        $this->db->where('a.idalumnoestatus', 1);
        $this->db->group_by('a.idalumno');
        $this->db->order_by('a.apellidop ASC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function listaMateriasReprobadasGrupo($idperiodo, $idgrupo)
    {
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

    public function listaMateriasGrupo($idperiodo, $idgrupo)
    {
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

    public function validarMateriaSeriada($idmateria, $idalumno)
    {
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
    public function calificacionFinalNormal($idgrupo, $idperiodo = '', $idprofesormateria = '', $idalumno = '')
    {
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

    public function calificacionFinalReprobadas($idgrupo, $idperiodo = '', $idprofesormateria = '', $idalumno = '')
    {
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

    public function calificacionPorOportunidad($idgrupo = '', $idperiodo = '', $idalumno = '', $idoportunidad = '', $idprofesormateria, $opcion = '')
    {
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

    public function calificacionPorOportunidadReprobados($idgrupo = '', $idperiodo = '', $idalumno = '', $idoportunidad = '', $idprofesormateria, $opcion = '')
    {
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
    public function obtenerMateriasAlumno($idalumno, $idperiodo)
    {

        $query = $this->db->query("CALL spObtenerMariasAlumno ($idalumno,$idperiodo)");
        $res = $query->result();
        //add this two line
        $query->next_result();
        $query->free_result();
        //end of new code
        return $res;
    }
}
