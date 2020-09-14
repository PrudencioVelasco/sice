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
    public  function  detallePeriodo($idperiodo){
        $this->db->select('m.nombremes as mesinicio,m2.nombremes as mesfin,y.nombreyear as yearinicio,y2.nombreyear as yearfin');
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
    public function detalleGrupo($idgrupo){
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
    public function allMateriasPreescolarReporte($idnivelestudio ='') {
        $this->db->select('ma.idmateriapreescolar, ma.nombremateria');
        $this->db->from('tblmateria_preescolar ma');
        $this->db->where('ma.activo', 1);
        if(isset($idnivelestudio) && !empty($idnivelestudio) && $idnivelestudio == 1){
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
    public function allMateriasPreescolar($idnivelestudio ='') {
        $this->db->select('ma.idmateriapreescolar, ma.nombremateria');
        $this->db->from('tblmateria_preescolar ma'); 
        $this->db->where('ma.activo', 1); 
        if(isset($idnivelestudio) && !empty($idnivelestudio) && $idnivelestudio == 1){
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
    public function allMateriasPreescolarAlumno($idperiodo,$idgrupo,$idmes,$idalumno) {
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
    public function allTipoCalificacionPreescolar() {
        $this->db->select('tc.idtipocalificacion, tc.tipocalificacion, tc.abreviatura');
        $this->db->from('tbltipo_calificacion tc'); 
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function allMeses() {
        $this->db->select('m.idmes, m.nombremes');
        $this->db->from('tblmes m');
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
    public function listaAlumnos($idgrupo = '', $idplantel = '', $idperiodo = '') {
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
    public function listaMateriasGrupo($idgrupo = '', $idplantel = '', $idperiodo = '') {
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
    public  function listaMateriasReprobadas($idalumno ='', $idperiodo =''){
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
    public  function obtenerAsistencia($idperiodo = '',$idgrupo = '',$idmateria = '',$tipoasistencia = '',$fechainicio = '',$fechafin = ''){
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
           $this->db->where('as.idmotivo',$tipoasistencia);
        }
        if (!empty($fechainicio) && !empty($fechafin)) {
            $this->db->where('as.fecha BETWEEN "'. $fechainicio. '" and "'. $fechafin.'"');
        }
         $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    
    } 
    public function listaAsistencia($idalumno = '', $fecha = '', $idmateria = '',$idmotivo) {
        # code...
        $this->db->select('a.idasistencia,ma.idmotivo, a.fecha,ma.nombremotivo, ma.abreviatura');
        $this->db->from('tblasistencia a');
        $this->db->join('tblmotivo_asistencia ma', 'a.idmotivo = ma.idmotivo');
        $this->db->join('tblhorario_detalle hd', 'hd.idhorariodetalle = a.idhorariodetalle');
        $this->db->where('a.idalumno', $idalumno); 
        $this->db->where('hd.idmateria', $idmateria);
        $this->db->where('a.fecha', $fecha);
        if (isset($idmotivo) && !empty($idmotivo) && $idmotivo != 28) {
            $this->db->where('a.idmotivo',$idmotivo);
        }
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->first_row();
        } else {
            return false;
        }
    }
    public function  obtenerCalificacionPreescolar($idperiodo,$idgrupo,$idalumno,$idmes,$idmateria){
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
    public function  obtenerFaltasPreescolar($idperiodo,$idgrupo,$idalumno,$idmes){
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
    public  function detalleCurso($idprofesormateria) {
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
    
    public  function obtenerAsistenciaPreescolar($idperiodo,$idgrupo,$idmes,$idalumno) {
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
    
    public  function motivoAsistencia(){
        $this->db->select('ma.idmotivo, ma.nombremotivo');
        $this->db->from('tblmotivo_asistencia ma'); 
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
            
    }
    public  function cursosHorario($idperiodo,$idgrupo){
        $this->db->select('m.idmateria, pm.idprofesormateria, m.nombreclase');
        $this->db->from('tblhorario h');
        $this->db->join('tblhorario_detalle hd', 'h.idhorario = hd.idhorario');
        $this->db->join('tblprofesor_materia pm', 'hd.idmateria = pm.idprofesormateria');
        $this->db->join('tblmateria m', 'm.idmateria = pm.idmateria');
        $this->db->where('h.idperiodo',$idperiodo);
        $this->db->where('h.idgrupo',$idgrupo);
        $this->db->group_by('hd.idmateria');
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
        
    }
    public function obtenerCalificacionSumatoria($idalumno,$idmateria,$idperiodo) {
        $this->db->select('(sum(c.calificacion)/(SELECT count(*) FROM tblunidad u WHERE u.idplantel = h.idplantel )) as calificacion, oe.numero, c.idoportunidadexamen, pm.idmateria, c.idalumno');
        $this->db->from('tblhorario_detalle hd');
        $this->db->join('tblcalificacion c', 'hd.idhorariodetalle = c.idhorariodetalle');
        $this->db->join('tblprofesor_materia pm', 'hd.idmateria = pm.idprofesormateria'); 
        $this->db->join('tblhorario h', 'h.idhorario = hd.idhorario'); 
        $this->db->join('tbloportunidad_examen oe', 'oe.idoportunidadexamen = c.idoportunidadexamen');
        $this->db->where('pm.idmateria', $idmateria); 
        $this->db->where('c.idalumno', $idalumno); 
        $this->db->where('h.idperiodo', $idperiodo); 
        $this->db->order_by('oe.numero DESC');
        $this->db->group_by('c.idoportunidadexamen, c.idalumno,c.idhorario, pm.idmateria');
        
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function validarMateriaReprobada($idalumno,$idmateria) {
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

    public function listaAlumnoPorGrupo($idgrupo = '', $idplantel = '', $idperiodo = '') {
        $query = $this->db->query("SELECT * FROM vlistaalumnogrupo WHERE idplantel = $idplantel AND idgrupo = $idgrupo AND idperiodo = $idperiodo  ORDER BY apellidop DESC");
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function showAllAlumnosPreescolar($idperiodo, $idgrupo,$idmes) {
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
    
    
    public function daleteCalificacionPreescolar($idalumno = '') {
        # code...
        $this->db->where('idcalificacionpreescolar', $idalumno);
        $this->db->delete('tblcalificacion_preescolar');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function updateAlumnoGrupo($id, $field) {
        $this->db->where('idalumnogrupo', $id);
        $this->db->update('tblalumno_grupo', $field);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    
    public function updateFaltas($id, $field) {
        $this->db->where('idasistenciapreescolar', $id);
        $this->db->update('tblasistencia_preescolar', $field);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    
    public function addCalificacionPreescolar($data) {
        $this->db->insert('tblcalificacion_preescolar', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    public function addAsistenciaPreescolar($data) {
        $this->db->insert('tblasistencia_preescolar', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    public function showAllCalificacionesDetalle($idperiodo, $idgrupo, $idmes,$idalumno) {
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

}
