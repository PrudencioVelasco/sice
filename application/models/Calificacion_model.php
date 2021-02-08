<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Calificacion_model extends CI_Model
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

    public function unidades($idplantel = '')
    {
        $this->db->select('u.idunidad, u.nombreunidad');
        $this->db->from('tblunidad u');
        if (isset($idplantel) && !empty($idplantel)) {
            $this->db->where('u.idplantel', $idplantel);
        }
        $this->db->order_by('u.numero ASC');
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function oportunidades($idplantel = '')
    {
        $this->db->select('o.idoportunidadexamen, o.nombreoportunidad');
        $this->db->from('tbloportunidad_examen o');
        if (isset($idplantel) && !empty($idplantel)) {
            $this->db->where('o.idplantel', $idplantel);
        }
        $this->db->where('o.numero > 1');
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function detalleOportunidad($idoportunidad, $idplantel = '')
    {
        $this->db->select('o.idoportunidadexamen,o.numero, o.nombreoportunidad');
        $this->db->from('tbloportunidad_examen o');
        if (isset($idplantel) && !empty($idplantel)) {
            $this->db->where('o.idplantel', $idplantel);
        }
        $this->db->where('o.idoportunidadexamen', $idoportunidad);
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->first_row();
        } else {
            return false;
        }
    }
    public  function  detallePeriodo($idperiodo)
    {
        $this->db->select('pe.activo, m.nombremes as mesinicio,m2.nombremes as mesfin,y.nombreyear as yearinicio,y2.nombreyear as yearfin,pe.descripcion');
        $this->db->from('tblperiodo pe');
        $this->db->join('tblmes m ', ' pe.idmesinicio = m.idmes');
        $this->db->join('tblmes m2 ', ' pe.idmesfin = m2.idmes');
        $this->db->join('tblyear y ', ' pe.idyearinicio = y.idyear');
        $this->db->join('tblyear y2 ', ' pe.idyearfin = y2.idyear');
        $this->db->where('pe.idperiodo', $idperiodo);
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->first_row();
        } else {
            return false;
        }
    }



    public  function  detalleHorarioCalificacion($idperiodo, $idgrupo)
    {
        $this->db->select('h.idhorario');
        $this->db->from('tblhorario h');
        $this->db->where('h.idperiodo', $idperiodo);
        $this->db->where('h.idgrupo', $idgrupo);
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->first_row();
        } else {
            return false;
        }
    }
    public  function  detalleMes($idmes)
    {
        $this->db->select('m.idmes, m.nombremes');
        $this->db->from('tblmes m');
        $this->db->where('m.idmes', $idmes);
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->first_row();
        } else {
            return false;
        }
    }
    public function detalleGrupo($idgrupo)
    {
        $this->db->select('g.idgrupo, g.idnivelestudio');
        $this->db->from('tblgrupo g');
        $this->db->where('g.idgrupo', $idgrupo);
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->first_row();
        } else {
            return false;
        }
    }
    public function allMateriasPreescolarReporte($idnivelestudio = '')
    {
        $this->db->select('ma.idmateriapreescolar, ma.nombremateria');
        $this->db->from('tblmateria_preescolar ma');
        $this->db->where('ma.activo', 1);
        if (isset($idnivelestudio) && !empty($idnivelestudio) && $idnivelestudio == 1) {
            $this->db->where('ma.idmateriapreescolar NOT IN(27)');
        }
        $this->db->order_by('ma.numero ASC');
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function detalleCalificacion($idalumno, $idhorario)
    {
        $this->db->select('cd.idcalificaciondisciplina,cd.idtipoevaluacion, cd.evaluacion');
        $this->db->from('tblcalificacion_disciplina cd');
        $this->db->where('cd.idalumno', $idalumno);
        $this->db->where('cd.idhorario', $idhorario);
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function detalleCalificacionPorId($idcalificacion)
    {
        $this->db->select('c.calificacion');
        $this->db->from('tblcalificacion c');
        $this->db->where('c.idcalificacion', $idcalificacion);
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->first_row();
        } else {
            return false;
        }
    }
    public function validarOtrasEvaluaciones($idalumno, $idhorario, $idunidad)
    {
        $this->db->select('cd.idcalificaciondisciplina,cd.idtipoevaluacion, cd.evaluacion');
        $this->db->from('tblcalificacion_disciplina cd');
        $this->db->where('cd.idalumno', $idalumno);
        $this->db->where('cd.idhorario', $idhorario);
        $this->db->where('cd.idunidad', $idunidad);
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function obtenerOtrasEvaluaciones($idalumno, $idhorario, $idunidad, $idtipoevaluacion)
    {
        $this->db->select('cd.idcalificaciondisciplina,cd.idtipoevaluacion, cd.evaluacion');
        $this->db->from('tblcalificacion_disciplina cd');
        $this->db->where('cd.idalumno', $idalumno);
        $this->db->where('cd.idhorario', $idhorario);
        $this->db->where('cd.idunidad', $idunidad);
        $this->db->where('cd.idtipoevaluacion', $idtipoevaluacion);
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->first_row();
        } else {
            return false;
        }
    }
    public function allMateriasPreescolar($idnivelestudio = '')
    {
        $this->db->select('ma.idmateriapreescolar, ma.nombremateria');
        $this->db->from('tblmateria_preescolar ma');
        $this->db->where('ma.activo', 1);
        if (isset($idnivelestudio) && !empty($idnivelestudio) && $idnivelestudio == 1) {
            $this->db->where('ma.idmateriapreescolar NOT IN(27)');
        }
        $this->db->where('ma.idmateriapreescolar NOT IN(1,10,19,21,26)');
        $this->db->order_by('ma.numero ASC');
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function allMateriasPreescolarAlumno($idperiodo, $idgrupo, $idmes, $idalumno)
    {
        $this->db->select('cp.idalumno,cp.idcalificacionpreescolar,ma.idmateriapreescolar, cp.idtipocalificacion, ma.nombremateria,tc.tipocalificacion, tc.abreviatura');
        $this->db->from('tblmateria_preescolar ma');
        $this->db->join('tblcalificacion_preescolar cp', 'cp.idmateriapreescolar = ma.idmateriapreescolar');
        $this->db->join('tbltipo_calificacion tc', 'tc.idtipocalificacion = cp.idtipocalificacion');
        $this->db->where('cp.idperiodo', $idperiodo);
        $this->db->where('cp.idgrupo', $idgrupo);
        $this->db->where('cp.idmes', $idmes);
        $this->db->where('cp.idalumno', $idalumno);
        $this->db->order_by('ma.nombremateria ASC');
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function allTipoCalificacionPreescolar()
    {
        $this->db->select('tc.idtipocalificacion, tc.tipocalificacion, tc.abreviatura');
        $this->db->from('tbltipo_calificacion tc');
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function allMeses()
    {
        $this->db->select('m.idmes, m.nombremes');
        $this->db->from('tblmes m');
        $this->db->where('m.numero NOT IN(7,8)');
        $this->db->order_by('m.enumeracion ASC');
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }


    public function showAllMateriasAlumno($idalumno = '')
    {
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

    public function obtenerCalificacion($idalumno = '', $idunidad = '', $idhorariodetalle = '')
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
        } else {
            return false;
        }
    }
    public function obtenerEspecialidadAlumno($idalumno)
    {
        $query = $this->db->query("
                SELECT 
                    CASE 
                    WHEN g.idnivelestudio =  1   THEN '10'
                    WHEN g.idnivelestudio =  3 AND a.idespecialidad =  12  THEN '30'
                    WHEN g.idnivelestudio =  3 AND a.idespecialidad =  10  THEN '31'
                    WHEN g.idnivelestudio =  3 AND a.idespecialidad =  9  THEN '32'
                    WHEN g.idnivelestudio =  5 AND a.idespecialidad =  10  THEN '50'
                    WHEN g.idnivelestudio =  5 AND a.idespecialidad =  9  THEN '51'
                    ELSE '' END AS grupo
                    FROM tblalumno a INNER JOIN tblalumno_grupo ag ON a.idalumno = ag.idalumno 
                    INNER JOIN tblgrupo g ON g.idgrupo = ag.idgrupo 
                    WHERE a.idalumno = $idalumno");
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function obtenerCalificacionXUnidadMateria($idalumno = '', $idunidad = '', $idprofesormateria = '')
    {
        $this->db->select('c.idcalificacion, c.calificacion');
        $this->db->from('tblcalificacion c');
        $this->db->join('tblunidad u', 'c.idunidad = u.idunidad');
        $this->db->join('tblhorario_detalle hd', 'hd.idhorariodetalle =  c.idhorariodetalle');
        $this->db->where('c.idalumno', $idalumno);
        $this->db->where('hd.idmateria', $idprofesormateria);
        $this->db->where('c.idunidad', $idunidad);
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->first_row();
        } else {
            return false;
        }
    }
    public  function obtenerCalificacionValidandoMateria($idalumno = '', $idunidad = '', $idhorario = '', $idmateria = '')
    {
        $this->db->select('c.idcalificacion, c.calificacion, date(c.fecharegistro) as fecharegistro');
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
    public function verificarCalificacionSiSeMuestra($idalumno = '', $idhorariodetalle = '')
    {
        $this->db->select('c.idcalificacion,c.calificacion');
        $this->db->from('tblcalificacion c');
        $this->db->join('tblunidad u', 'c.idunidad = u.idunidad');
        $this->db->where('c.idalumno', $idalumno);
        $this->db->where('c.idhorariodetalle', $idhorariodetalle);
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function verificarCalificacionSiSeMuestraXMateria($idalumno = '', $idhorario = '', $idmateria = '')
    {
        $this->db->select('c.idcalificacion, c.calificacion, date(c.fecharegistro) as fecharegistro');
        $this->db->from('tblcalificacion c');
        $this->db->join('tblunidad u', 'c.idunidad = u.idunidad');
        $this->db->join('tblhorario_detalle hd', 'c.idhorariodetalle = hd.idhorariodetalle');
        $this->db->join('tblprofesor_materia pm', 'pm.idprofesormateria = hd.idmateria');
        $this->db->join('tbloportunidad_examen op', 'op.idoportunidadexamen = c.idoportunidadexamen');
        $this->db->where('c.idalumno', $idalumno);
        $this->db->where('op.numero', 1);
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

    public function obtenerCalificacionXUnidad($idalumno = '', $idunidad = '', $idmateria = '', $idhorario)
    {
        $this->db->select('c.idcalificacion, c.calificacion');
        $this->db->from('tblcalificacion c');
        $this->db->join('tblunidad u', 'c.idunidad = u.idunidad');
        $this->db->join('tblhorario_detalle hd', 'hd.idhorariodetalle = c.idhorariodetalle');
        $this->db->join('tblhorario h', 'hd.idhorario = h.idhorario');
        $this->db->where('c.idalumno', $idalumno);
        $this->db->where('hd.idmateria', $idmateria);
        $this->db->where('c.idunidad', $idunidad);
        $this->db->where('h.idhorario', $idhorario);
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->first_row();
        } else {
            return false;
        }
    }


    public function obtenerCalificacionXOportunidad($idalumno = '', $idoportunidad = '', $idmateria = '')
    {
        $this->db->select('c.idcalificacion, c.calificacion');
        $this->db->from('tblcalificacion c');
        $this->db->join('tblunidad u', 'c.idunidad = u.idunidad');
        $this->db->join('tblhorario_detalle hd', 'hd.idhorariodetalle = c.idhorariodetalle');
        $this->db->where('c.idalumno', $idalumno);
        $this->db->where('hd.idmateria', $idmateria);
        $this->db->where('c.idoportunidadexamen', $idoportunidad);
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->first_row();
        } else {
            return false;
        }
    }
    public function obtenerDirector($idplantel)
    {
        $this->db->select('p.nombre, p.apellidop, p.apellidom');
        $this->db->from('tblpersonal p');
        $this->db->join('users u', 'p.idpersonal = u.idusuario');
        $this->db->join('users_rol ur', 'ur.id_user = u.id');
        $this->db->where('u.idtipousuario', 2);
        $this->db->where('p.idplantel', $idplantel);
        $this->db->where('ur.id_rol', 13);
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->first_row();
        } else {
            return false;
        }
    }
    public function obtenerDisciplina($idalumno, $idhorario)
    {
        $this->db->select('cd.idtipoevaluacion, cd.evaluacion');
        $this->db->from('tblcalificacion_disciplina cd');
        $this->db->where('cd.idalumno', $idalumno);
        $this->db->where('cd.idhorario', $idhorario);
        $this->db->where('cd.idtipoevaluacion IN (3,4)');
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }



    public function listaAlumnos($idgrupo = '', $idplantel = '', $idperiodo = '')
    {
        $this->db->select('a.idalumno, a.nombre, a.apellidop, a.apellidom');
        $this->db->from('tblalumno a');
        $this->db->join('tblalumno_grupo ag', 'a.idalumno = ag.idalumno');
        $this->db->where('ag.idperiodo', $idperiodo);
        $this->db->where('ag.idgrupo', $idgrupo);
        $this->db->where('a.idplantel', $idplantel);
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function validarMateriaSeriada($idalumno = '', $idmateria = '', $estatus_periodo = '')
    {
        $this->db->select('ag.*');
        $this->db->from('tblalumno_grupo ag');
        $this->db->join('tblmateria_reprobada mr', 'ag.idalumnogrupo = mr.idalumnogrupo');
        $this->db->join('tblmateria_seriada ms', 'ms.idmateriasecundaria  = mr.idmateria');
        if (isset($estatus_periodo) && !empty($estatus_periodo) && $estatus_periodo == 1) {
            $this->db->where('mr.estatus', 1);
        }
        if (isset($estatus_periodo) && !empty($estatus_periodo) && $estatus_periodo == 0) {
            $this->db->where('mr.estatus', 0);
        }

        $this->db->where('ms.eliminado  = 0');
        $this->db->where('ag.idalumno', $idalumno);
        $this->db->where('ms.idmateriaprincipal', $idmateria);
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function calificacionXMes($idalumno, $idprofesormateria, $idmes, $idhorario)
    {
        $this->db->select('c.idcalificacion, dc.calificacion,dc.fecharegistro, dc.iddetallecalificacion');
        $this->db->from('tbldetalle_calificacion dc');
        $this->db->join('tblcalificacion c', 'c.idcalificacion = dc.idcalificacion');
        $this->db->join('tblhorario_detalle hd', 'hd.idhorariodetalle = c.idhorariodetalle');
        $this->db->join('tblhorario h', 'h.idhorario = hd.idhorario');
        $this->db->where('c.idalumno', $idalumno);
        $this->db->where('hd.idmateria', $idprofesormateria);
        $this->db->where('dc.idmes', $idmes);
        $this->db->where('h.idhorario', $idhorario);
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->first_row();
        } else {
            return false;
        }
    }
    public function validarExistenciaOtrasEvaluaciones($idcalificacion, $tipoevaluacion)
    {
        $this->db->select('dco.iddetallecalificacionotras,dco.evaluacion');
        $this->db->from('tbldetalle_calificacion_otras dco');
        $this->db->where('dco.idcalificacion', $idcalificacion);
        if (isset($tipoevaluacion) && !empty($tipoevaluacion)) {
            $this->db->where('dco.idtipoevaluacion', $tipoevaluacion);
        }
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->first_row();
        } else {
            return false;
        }
    }
    public function validarMateriaReprobadaXUnidad($idalumno = '', $idmateria = '')
    {
        $this->db->select('ag.*');
        $this->db->from('tblalumno_grupo ag');
        $this->db->join('tblmateria_reprobada mr', 'ag.idalumnogrupo = mr.idalumnogrupo');
        $this->db->join('tbldetalle_reprobada dr', 'dr.idreprobada  = mr.idreprobada');
        $this->db->where('ag.idalumno', $idalumno);
        $this->db->where('dr.idprofesormateria', $idmateria);
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function alumnosGrupo($idperiodo, $idgrupo, $idestatus = '')
    {

        $sql =  "SELECT * FROM vwalumnosgrupo WHERE idperiodo = $idperiodo AND idgrupo = $idgrupo";
        if (isset($idestatus) && !empty($idestatus) && $idestatus == 1) {
            $sql .= " AND idalumnoestatus = 1";
        }
        $sql .= " ORDER BY apellidop ASC";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function gradoAlumno($idalumno = '', $idperiodo = '', $idgrupo)
    {
        $this->db->select('a.idespecialidad, g.idnivelestudio');
        $this->db->from('tblalumno_grupo ag');
        $this->db->join('tblhorario h', 'h.idperiodo = ag.idperiodo');
        $this->db->join('tblgrupo g', 'g.idgrupo = ag.idgrupo');
        $this->db->join('tblalumno a', 'a.idalumno = ag.idalumno');
        $this->db->where('g.idgrupo = h.idgrupo');
        $this->db->where('ag.idalumno', $idalumno);
        $this->db->where('ag.idperiodo', $idperiodo);
        $this->db->where('ag.idgrupo', $idgrupo);
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->first_row();
        } else {
            return false;
        }
    }
    public function obtenerMateriaTaller($idalumno = '', $idprofesormateria = '', $idhorario = '')
    {
        $this->db->select('hdc.*');
        $this->db->from('tblhorario_detalle_cursos hdc');
        $this->db->join('tblhorario_detalle hd', 'hd.idhorario = hdc.idhorario');
        $this->db->where('hd.idmateria = hdc.idprofesormateria');
        $this->db->where('hdc.idalumno', $idalumno);
        $this->db->where('hdc.idhorario', $idhorario);
        $this->db->where('hd.idmateria', $idprofesormateria);
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->first_row();
        } else {
            return false;
        }
    }
    public function materiasGrupoStoreProcedure($idespecialidad, $idnivelestudio, $idperiodo, $idgrupo)
    {
        $query = $this->db->query("CALL spMateriasGrupo($idespecialidad,$idnivelestudio,$idperiodo,$idgrupo)");
        $res = $query->result();
        //add this two line
        $query->next_result();
        $query->free_result();
        //end of new code
        return $res;
    }

    public function materiasGrupo($idperiodo, $idgrupo)
    {

        $sql =  "SELECT * FROM vwmateriasgrupo WHERE idperiodo = $idperiodo AND idgrupo = $idgrupo";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function listaMateriasGrupo($idgrupo = '', $idplantel = '', $idperiodo = '')
    {
        $this->db->select('pm.idprofesormateria,m.idmateria as idmateriareal, hd.idmateria, h.idhorario, hd.idhorariodetalle,  m.nombreclase, p.nombre, p.apellidop, p.apellidom');
        $this->db->from('tblhorario h');
        $this->db->join('tblhorario_detalle hd', 'h.idhorario = hd.idhorario');
        $this->db->join('tblprofesor_materia pm', 'pm.idprofesormateria = hd.idmateria');
        $this->db->join('tblmateria m', 'pm.idmateria = m.idmateria');
        $this->db->join('tblprofesor p', 'p.idprofesor = pm.idprofesor');
        $this->db->where('h.idperiodo', $idperiodo);
        $this->db->where('h.idgrupo', $idgrupo);
        $this->db->where('h.idplantel', $idplantel);
        $this->db->group_by('pm.idprofesormateria, h.idhorario');
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public  function listaMateriasReprobadas($idalumno = '', $idperiodo = '')
    {
        $this->db->select('dr.idhorario, dr.idprofesormateria');
        $this->db->from('tblmateria_reprobada mr');
        $this->db->join('tbldetalle_reprobada dr', 'mr.idreprobada = dr.idreprobada');
        $this->db->join('tblalumno_grupo ag', 'ag.idalumnogrupo = mr.idalumnogrupo');
        $this->db->join('tblhorario h', 'h.idhorario = dr.idhorario');
        $this->db->where('h.idperiodo', $idperiodo);
        $this->db->where('ag.idalumno', $idalumno);
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public  function obtenerAsistenciaBoleta($idalumno = '', $idperiodo = '', $idprofesormateria, $tipo = '')
    {
        $this->db->select('COUNT(as.idasistencia) as total');
        $this->db->from('tblasistencia as');
        $this->db->join('tblmotivo_asistencia ma', 'ma.idmotivo = as.idmotivo');
        $this->db->join('tblhorario_detalle hd', 'hd.idhorariodetalle = as.idhorariodetalle');
        $this->db->join('tblhorario h', 'hd.idhorario = h.idhorario');
        $this->db->where('h.idperiodo', $idperiodo);
        $this->db->where('as.idalumno', $idalumno);
        $this->db->where('as.idmotivo', $tipo);
        $this->db->where('hd.idmateria', $idprofesormateria);
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->first_row();
        } else {
            return false;
        }
    }

    public  function obtenerAsistencia($idperiodo = '', $idgrupo = '', $idmateria = '', $tipoasistencia = '', $fechainicio = '', $fechafin = '')
    {
        $this->db->select('m.nombreclase,CONCAT(p.apellidop," ",p.apellidom," ",p.nombre) as nombreprofesor,CONCAT(a.apellidop," ",a.apellidom," ",a.nombre) as nombrealumno ');
        $this->db->from('tblasistencia as');
        $this->db->join('tblhorario_detalle hd', 'as.idhorariodetalle = hd.idhorariodetalle');
        $this->db->join('tblhorario h', 'h.idhorario = hd.idhorario');
        $this->db->join('tblprofesor_materia pm', 'hd.idmateria = pm.idprofesormateria');
        $this->db->join('tblmateria m', 'm.idmateria = pm.idmateria');
        $this->db->join('tblprofesor p', 'p.idprofesor = pm.idprofesor');
        $this->db->join('tblalumno a', 'a.idalumno = as.idalumno');
        $this->db->join('tblmotivo_asistencia ma', 'ma.idmotivo = as.idmotivo');
        $this->db->where('pm.idprofesormateria', $idmateria);
        $this->db->where('h.idperiodo', $idperiodo);
        $this->db->where('h.idgrupo', $idgrupo);
        if (isset($tipoasistencia) && !empty($tipoasistencia) && $tipoasistencia != 28) {
            $this->db->where('as.idmotivo', $tipoasistencia);
        }
        if (!empty($fechainicio) && !empty($fechafin)) {
            $this->db->where('as.fecha BETWEEN "' . $fechainicio . '" and "' . $fechafin . '"');
        }
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function listaAsistencia($idalumno = '', $fecha = '', $idmateria = '', $idmotivo)
    {
        # code...
        $this->db->select('a.idasistencia,ma.idmotivo, a.fecha,ma.nombremotivo, ma.abreviatura');
        $this->db->from('tblasistencia a');
        $this->db->join('tblmotivo_asistencia ma', 'a.idmotivo = ma.idmotivo');
        $this->db->join('tblhorario_detalle hd', 'hd.idhorariodetalle = a.idhorariodetalle');
        $this->db->where('a.idalumno', $idalumno);
        $this->db->where('hd.idmateria', $idmateria);
        $this->db->where('a.fecha', $fecha);
        if (isset($idmotivo) && !empty($idmotivo) && $idmotivo != 28) {
            $this->db->where('a.idmotivo', $idmotivo);
        }
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->first_row();
        } else {
            return false;
        }
    }
    public function  obtenerCalificacionPreescolar($idperiodo, $idgrupo, $idalumno, $idmes, $idmateria)
    {
        $this->db->select('cp.idmateriapreescolar, mp.nombremateria,tc.tipocalificacion, tc.abreviatura, m.numero, m.nombremes');
        $this->db->from('tblcalificacion_preescolar cp');
        $this->db->join('tblmateria_preescolar mp', 'cp.idmateriapreescolar = mp.idmateriapreescolar');
        $this->db->join('tbltipo_calificacion tc', 'tc.idtipocalificacion = cp.idtipocalificacion');
        $this->db->join('tblmes m', 'm.idmes = cp.idmes');
        $this->db->where('cp.idperiodo', $idperiodo);
        $this->db->where('cp.idgrupo', $idgrupo);
        $this->db->where('cp.idalumno', $idalumno);
        $this->db->where('cp.idmes', $idmes);
        $this->db->where('cp.idmateriapreescolar', $idmateria);
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->first_row();
        } else {
            return false;
        }
    }
    public function  obtenerFaltasPreescolar($idperiodo, $idgrupo, $idalumno, $idmes)
    {
        $this->db->select('ap.faltas');
        $this->db->from('tblasistencia_preescolar ap');
        $this->db->where('ap.idperiodo', $idperiodo);
        $this->db->where('ap.idgrupo', $idgrupo);
        $this->db->where('ap.idalumno', $idalumno);
        $this->db->where('ap.idmes', $idmes);
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->first_row();
        } else {
            return false;
        }
    }
    public  function detalleCurso($idprofesormateria)
    {
        $this->db->select('m.nombreclase');
        $this->db->from('tblprofesor_materia pm');
        $this->db->join('tblmateria m', 'm.idmateria = pm.idmateria');
        $this->db->where('pm.idprofesormateria', $idprofesormateria);
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->first_row();
        } else {
            return false;
        }
    }

    public  function obtenerAsistenciaPreescolar($idperiodo, $idgrupo, $idmes, $idalumno)
    {
        $this->db->select('ap.faltas');
        $this->db->from('tblasistencia_preescolar ap');
        $this->db->where('ap.idperiodo', $idperiodo);
        $this->db->where('ap.idgrupo', $idgrupo);
        $this->db->where('ap.idalumno', $idalumno);
        $this->db->where('ap.idmes', $idmes);
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->first_row();
        } else {
            return false;
        }
    }

    public  function motivoAsistencia()
    {
        $this->db->select('ma.idmotivo, ma.nombremotivo');
        $this->db->from('tblmotivo_asistencia ma');
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public  function cursosHorario($idperiodo, $idgrupo)
    {
        $this->db->select('m.idmateria, pm.idprofesormateria, m.nombreclase');
        $this->db->from('tblhorario h');
        $this->db->join('tblhorario_detalle hd', 'h.idhorario = hd.idhorario');
        $this->db->join('tblprofesor_materia pm', 'hd.idmateria = pm.idprofesormateria');
        $this->db->join('tblmateria m', 'm.idmateria = pm.idmateria');
        $this->db->where('h.idperiodo', $idperiodo);
        $this->db->where('h.idgrupo', $idgrupo);
        $this->db->group_by('hd.idmateria');
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function obtenerCalificacionSumatoria($idalumno, $idmateria, $idperiodo, $idhorario)
    {
        $this->db->select('(sum(c.calificacion)/(SELECT count(*) FROM tblunidad u WHERE u.idplantel = h.idplantel )) as calificacion, oe.numero, c.idoportunidadexamen,h.idperiodo, pm.idmateria, c.idalumno');
        $this->db->from('tblhorario_detalle hd');
        $this->db->join('tblcalificacion c', 'hd.idhorariodetalle = c.idhorariodetalle');
        $this->db->join('tblprofesor_materia pm', 'hd.idmateria = pm.idprofesormateria');
        $this->db->join('tblhorario h', 'h.idhorario = hd.idhorario');
        $this->db->join('tbloportunidad_examen oe', 'oe.idoportunidadexamen = c.idoportunidadexamen');
        $this->db->where('hd.idmateria', $idmateria);
        $this->db->where('c.idalumno', $idalumno);
        //$this->db->where('h.idperiodo', $idperiodo); 
        $this->db->where('hd.idhorario', $idhorario);
        $this->db->order_by('oe.numero DESC');
        $this->db->group_by('c.idoportunidadexamen, c.idalumno,c.idhorario, pm.idmateria');

        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function validarMateriaReprobada($idalumno, $idmateria)
    {
        $this->db->select('mr.idmateria, mr.idhorariodetalle, mr.estatus, ms.idmateriaprincipal');
        $this->db->from(' tblmateria_reprobada mr');
        $this->db->join('tblmateria_seriada ms', 'mr.idmateria = ms.idmateriasecundaria');
        $this->db->join(' tblalumno_grupo ag', 'ag.idalumnogrupo = mr.idalumnogrupo');
        $this->db->where('ag.idalumno', $idalumno);
        $this->db->where('ms.idmateriaprincipal', $idmateria);
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function listaAlumnoPorGrupo($idgrupo = '', $idplantel = '', $idperiodo = '')
    {
        $query = $this->db->query("SELECT * FROM vlistaalumnogrupo WHERE idplantel = $idplantel AND idgrupo = $idgrupo AND idperiodo = $idperiodo  ORDER BY apellidop DESC");
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function showAllAlumnosPreescolar($idperiodo, $idgrupo, $idmes)
    {
        $query = $this->db->query("SELECT 
                a.idalumno,
                ag.idperiodo,
                ag.idgrupo,
                a.matricula,
                p.activo,
                a.nombre,
                (SELECT ao.faltas FROM tblasistencia_preescolar ao 
                            WHERE  ao.idalumno = a.idalumno
                            AND ao.idperiodo = ag.idperiodo
                            AND ao.idgrupo = ag.idgrupo AND ao.idmes = $idmes) as faltas,
   (SELECT ao.idasistenciapreescolar FROM tblasistencia_preescolar ao 
                            WHERE  ao.idalumno = a.idalumno
                            AND ao.idperiodo = ag.idperiodo
                            AND ao.idgrupo = ag.idgrupo AND ao.idmes = $idmes) as idasistenciapreescolar,
                CONCAT(a.apellidop,
                        ' ',
                        a.apellidom,
                        ' ',
                        a.nombre) nombrealumno,
                (SELECT 
                        COUNT(cp.idalumno)
                    FROM
                        tblcalificacion_preescolar cp 
                    WHERE
                           cp.idalumno = a.idalumno
                            AND cp.idperiodo = ag.idperiodo
                            AND cp.idgrupo = ag.idgrupo AND cp.idmes = $idmes) AS registrado,
                (SELECT 
                        COUNT(mp.idmateriapreescolar)
                    FROM
                        tblmateria_preescolar mp
                    WHERE
                        mp.activo = 1) totalmaterias
            FROM
                tblalumno a
                    INNER JOIN
                tblalumno_grupo ag ON a.idalumno = ag.idalumno
                    INNER JOIN 
                tblperiodo p ON p.idperiodo = ag.idperiodo 
            WHERE ag.idperiodo = $idperiodo
            AND ag.idgrupo = $idgrupo");
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function materiasXRecuperar($idperiodo, $idalumno)
    {
        $query = $this->db->query("SELECT
            	hd.idhorariodetalle,
                pm.idprofesormateria,
                pm.idmateria,
                h.idhorario,
            	m.clave ,
            	m.nombreclase
            FROM
            	tblalumno a
            INNER JOIN tblalumno_grupo ag on
            	a.idalumno = ag.idalumno
            INNER JOIN tblmateria_reprobada mr on
            	mr.idalumnogrupo = ag.idalumnogrupo
            INNER JOIN tbldetalle_reprobada dr on
            	dr.idreprobada = mr.idreprobada
            INNER JOIN tblhorario h on
            	h.idhorario = dr.idhorario
            INNER JOIN tblhorario_detalle hd on
            	hd.idhorario = h.idhorario
            INNER JOIN tblprofesor_materia pm on
            	pm.idprofesormateria = hd.idmateria
            INNER JOIN tblmateria m on
            	m.idmateria = pm.idmateria
            WHERE
            	hd.idmateria = dr.idprofesormateria
            AND h.idperiodo = $idperiodo
            AND ag.idalumno = $idalumno");
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function showAlumnosMateriasOportunidades($idperiodo, $idgrupo, $opcion = '')
    {
        $sql = "";
        $sql .= "SELECT
	idalumno,
	idhorario,
	apellidop,
	apellidom,
	nombre,
	idmateria,
	nombreclase,
	totalunidad,
	totalunidades,
	calificacion,
	idprofesormateria,
	idperiodo,
	idgrupo,
	calificacionoportunidad 
FROM
	(
	SELECT
		c.idalumno, vw.idhorario, vw.idperiodo , vw.idgrupo, vw.apellidop, vw.apellidom, vw.nombre, m.idmateria, m.nombreclase, COUNT(c.idunidad) totalunidad, FORMAT((SUM(c.calificacion)/ COUNT(c.idunidad)),
		2) calificacion, pm.idprofesormateria, (
		SELECT
			COUNT(*)
		FROM
			tblunidad u
		WHERE
			u.idplantel = a.idplantel) totalunidades,
			COALESCE(FORMAT( (SELECT c2.calificacion FROM tblcalificacion c2 WHERE c2.idhorariodetalle = c.idhorariodetalle AND c2.idalumno = c.idalumno AND c2.idoportunidadexamen  = 2),2),0) as calificacionoportunidad
	FROM
		vwalumnosgrupo vw
	INNER JOIN tblhorario_detalle hd ON
		vw.idhorario = hd.idhorario
	INNER JOIN tblcalificacion c ON
		c.idhorariodetalle = hd.idhorariodetalle
	INNER JOIN tblprofesor_materia pm ON
		hd.idmateria = pm.idmateria
	INNER JOIN tblmateria m ON
		m.idmateria = pm.idmateria
	INNER JOIN tblalumno a ON
		a.idalumno = vw.idalumno
	WHERE
		vw.idalumno = c.idalumno
	GROUP BY
		c.idhorariodetalle, c.idalumno, hd.idhorario) tbl
WHERE
	totalunidad = totalunidades
    AND idperiodo = $idperiodo
    AND idgrupo = $idgrupo";
        if (isset($opcion) && !empty($opcion) && $opcion == "materias") {
            $sql .= " GROUP BY idprofesormateria";
        }
        $sql .= " ORDER BY apellidop ASC";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function showAlumnosMateriasOportunidadesXId($idperiodo, $idgrupo, $idoportunidadanterior = '', $idoportunidadactual = '')
    {
        $sql = "";
        $sql .= "SELECT
	idalumno,
	idhorario,
	apellidop,
	apellidom,
	nombre,
	idmateria,
	nombreclase,
	totalunidad,
	totalunidades,
	calificacion,
	idprofesormateria,
	idperiodo,
	idgrupo,
	calificacionoportunidadanterior,
	calificacionoportunidadactual 
FROM
	(
	SELECT
		c.idalumno, vw.idhorario, vw.idperiodo , vw.idgrupo, vw.apellidop, vw.apellidom, vw.nombre, m.idmateria, m.nombreclase, COUNT(c.idunidad) totalunidad, FORMAT((SUM(c.calificacion)/ COUNT(c.idunidad)),
		2) calificacion, pm.idprofesormateria, (
		SELECT
			COUNT(*)
		FROM
			tblunidad u
		WHERE
			u.idplantel = a.idplantel) totalunidades,
			COALESCE(FORMAT( (SELECT c2.calificacion FROM tblcalificacion c2 WHERE c2.idhorariodetalle = c.idhorariodetalle AND c2.idalumno = c.idalumno AND c2.idoportunidadexamen  = $idoportunidadanterior),2),0) as calificacionoportunidadanterior,
			COALESCE(FORMAT( (SELECT c3.calificacion FROM tblcalificacion c3 WHERE c3.idhorariodetalle = c.idhorariodetalle AND c3.idalumno = c.idalumno AND c3.idoportunidadexamen  = $idoportunidadactual),2),0) as calificacionoportunidadactual
	FROM
		vwalumnosgrupo vw
	INNER JOIN tblhorario_detalle hd ON
		vw.idhorario = hd.idhorario
	INNER JOIN tblcalificacion c ON
		c.idhorariodetalle = hd.idhorariodetalle
	INNER JOIN tblprofesor_materia pm ON
		hd.idmateria = pm.idmateria
	INNER JOIN tblmateria m ON
		m.idmateria = pm.idmateria
	INNER JOIN tblalumno a ON
		a.idalumno = vw.idalumno
	WHERE
		vw.idalumno = c.idalumno
	GROUP BY
		c.idhorariodetalle, c.idalumno, hd.idhorario) tbl
WHERE
	totalunidad = totalunidades
    AND h.idperiodo = $idperiodo
    AND h.idgrupo = $idgrupo
	GROUP BY
		c.idhorariodetalle, c.idalumno, hd.idhorario, c.idoportunidadexamen) tbl ORDER BY apellidop ASC";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function showAllMateriasRecuperando($idhorario, $idalumno, $idperiodo)
    {
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
    public function calificacionMateria($idhorario, $idalumno, $idmateria = '')
    {
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


    public function daleteCalificacionPreescolar($idalumno = '')
    {
        # code...
        $this->db->where('idcalificacionpreescolar', $idalumno);
        $this->db->delete('tblcalificacion_preescolar');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function daleteCalificacionPreescolarAll($idperiodo, $idgrupo, $idalumno, $idmes)
    {
        # code...
        $this->db->where('idperiodo', $idperiodo);
        $this->db->where('idalumno', $idalumno);
        $this->db->where('idgrupo', $idgrupo);
        $this->db->where('idmes', $idmes);
        $this->db->delete('tblcalificacion_preescolar');
        if ($this->db->affected_rows() > 0) {
            return true;
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

    public function updateFaltas($id, $field)
    {
        $this->db->where('idasistenciapreescolar', $id);
        $this->db->update('tblasistencia_preescolar', $field);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function updateOtrasEvaluacion($id, $field)
    {
        $this->db->where('idasistenciapreescolar', $id);
        $this->db->update('tbldetalle_calificacion_otras', $field);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function updateDiscriplina($id, $field)
    {
        $this->db->where('idcalificaciondisciplina', $id);
        $this->db->update('tblcalificacion_disciplina', $field);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function addCalificacionPreescolar($data)
    {
        $this->db->insert('tblcalificacion_preescolar', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    public function addFaltasCalificacion($data)
    {
        $this->db->insert('tbldetalle_calificacion_otras', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    public function addAsistenciaPreescolar($data)
    {
        $this->db->insert('tblasistencia_preescolar', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    public function AddDiscriplina($data)
    {
        $this->db->insert('tblcalificacion_disciplina', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    public function showAllCalificacionesDetalle($idperiodo, $idgrupo, $idmes, $idalumno)
    {
        $sql = "SELECT 
    numero, nombremateria, tipocalificacion, abreviatura
FROM
    (SELECT 
        ma.numero,
            ma.nombremateria,
            tc.tipocalificacion,
            tc.abreviatura
    FROM
        tblmateria_preescolar ma
    INNER JOIN tblcalificacion_preescolar cp ON cp.idmateriapreescolar = ma.idmateriapreescolar
    INNER JOIN tbltipo_calificacion tc ON tc.idtipocalificacion = cp.idtipocalificacion
    WHERE
        cp.idperiodo = $idperiodo
        AND cp.idgrupo = $idgrupo
            AND cp.idmes = $idmes
            AND cp.idalumno = $idalumno UNION ALL SELECT 
        27 AS numero,
            'FALTAS' AS nombremateria,
            ap.faltas AS tipocalificacion,
            ap.faltas AS abreviatura
    FROM
        tblasistencia_preescolar ap
    WHERE
         ap.idperiodo = $idperiodo 
            AND ap.idgrupo = $idgrupo
            AND ap.idmes = $idmes
            AND ap.idalumno = $idalumno) 
            tblasistencia
            ORDER BY numero ASC";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function validarCalificacionRegistrada($idalumno, $idhorario, $idprofesormateria, $idunidad)
    {
        $this->db->select('c.calificacion');
        $this->db->from('tblcalificacion  c');
        $this->db->join('tblhorario_detalle hd', 'hd.idhorariodetalle = c.idhorariodetalle');
        //$this->db->join(' tblalumno_grupo ag', 'ag.idalumnogrupo = mr.idalumnogrupo');
        $this->db->where('hd.idhorario', $idhorario);
        $this->db->where('hd.idmateria', $idprofesormateria);
        $this->db->where('c.idalumno', $idalumno);
        $this->db->where('c.idunidad', $idunidad);
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function validarCalificacionRegistradaMeses($idalumno, $idhorario, $idprofesormateria, $idmes)
    {
        $this->db->select('dc.calificacion');
        $this->db->from('tblcalificacion  c');
        $this->db->join('tblhorario_detalle hd', 'hd.idhorariodetalle = c.idhorariodetalle');
        $this->db->join('tbldetalle_calificacion dc', 'dc.idcalificacion = c.idcalificacion');
        $this->db->where('hd.idhorario', $idhorario);
        $this->db->where('hd.idmateria', $idprofesormateria);
        $this->db->where('c.idalumno', $idalumno);
        $this->db->where('dc.idmes', $idmes);
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
}
