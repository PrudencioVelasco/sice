<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Alumno_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function __destruct() {
        $this->db->close();
    }

  
    public function showAll($idplantel = '') {
        $this->db->select('t.*');
        $this->db->from('tblalumno t'); 
        if (isset($idplantel) && !empty($idplantel)) {
        $this->db->where('t.idplantel',$idplantel); 
        }  
         $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }

    }
        public function logo($idplantel = '') {
        $this->db->select('p.*');
        $this->db->from('tblplantel p'); 
        if (isset($idplantel) && !empty($idplantel)) {
        $this->db->where('p.idplantel',$idplantel); 
        }  
         $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
        
    }
    public function buscarAlumno($matricula = '')
    {
        $this->db->select('a.idalumno, a.nombre, a.apellidop, a.apellidom');
        $this->db->from('tblalumno a');   
        $this->db->where('a.matricula', $matricula); 
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function becaAlumno($idalumno = '')
    {
        $this->db->select('b.descuento,b.descripcion');
        $this->db->from('tblbeca b');  
        $this->db->join('tblalumno_grupo ag','ag.idbeca = b.idbeca'); 
        $this->db->where('ag.idalumno', $idalumno); 
        $this->db->where('ag.activo',1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
     public function showAllBecas()
    {
        $this->db->select('b.idbeca, b.descuento,b.descripcion');
        $this->db->from('tblbeca b');    
        $this->db->where('b.activo',1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function showAllAlumnosTutor($idtutor = '')
    {
        $this->db->select('a.idalumno,a.nombre, a.apellidop, a.apellidom');
        $this->db->from('tbltutoralumno ta');   
        $this->db->join('tblalumno a', 'a.idalumno = ta.idalumno'); 
        $this->db->where('ta.idtutor', $idtutor); 
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function showAllTiposSanguineos()
    {
        $this->db->select('ts.*');
        $this->db->from('tbltiposanguineo ts');    
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function showAllAlumnosTutorActivos($idtutor = '') {
        $this->db->select('a.idalumno, a.nombre, a.apellidop, a.apellidom,ne.nombrenivel, ne.idnivelestudio, g.nombregrupo, g.idgrupo, ag.idperiodo');
        $this->db->from('tblalumno a');  
        $this->db->join('tbltutoralumno ta','a.idalumno=ta.idalumno'); 
        $this->db->join('tblalumno_grupo ag','ag.idalumno=a.idalumno'); 
        $this->db->join('tblgrupo g','g.idgrupo=ag.idgrupo'); 
        $this->db->join('tblnivelestudio ne','g.idnivelestudio=ne.idnivelestudio'); 
        $this->db->where('ta.idtutor',$idtutor); 
        $this->db->where('ag.activo', 1); 
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
        public function showAllMateriasAlumno($idalumno = '',$activo = '') {
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
        if(isset($activo) && empty($activo)){
        $this->db->where('(pe.activo = 1 or ho.activo = 1)');
        }
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
     public function showAllPagoInscripcion($idalumno = '',$idperiodo = '') {
        $this->db->select("tp.nombretipopago, tp2.concepto, pi.descuento,tp.nombretipopago, DATE_FORMAT(pi.fecharegistro,'%d/%m/%Y') as fecharegistro, pi.idformapago, pi.online, pi.pagado");
        $this->db->from('tblpago_inicio pi'); 
        $this->db->join('tbltipo_pago tp', 'tp.idtipopago = pi.idformapago'); 
        $this->db->join('tbltipopagocol tp2', 'tp2.idtipopagocol = pi.idtipopagocol'); 
        $this->db->where('pi.idalumno', $idalumno); 
        $this->db->where('pi.idperiodo', $idperiodo); 
         $this->db->where('pi.eliminado', 0); 
         $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
      public function showAllPagoColegiaturas($idalumno = '',$idperiodo = '') {
        $this->db->select("tp.nombretipopago, 'MENSUALIDAD' AS concepto,m.nombremes, es.descuento,tp.nombretipopago, DATE_FORMAT(es.fechapago,'%d/%m/%Y') as fecharegistro, es.idformapago, es.online, es.pagado");
        $this->db->from('tblestado_cuenta es'); 
        $this->db->join('tbltipo_pago tp', 'tp.idtipopago = es.idformapago');  
         $this->db->join('tblamotizacion a', 'a.idamortizacion = es.idamortizacion');
         $this->db->join('tblmes m', 'a.idperiodopago = m.idmes');  
        $this->db->where('es.idalumno', $idalumno); 
        $this->db->where('es.idperiodo', $idperiodo); 
         $this->db->where('es.eliminado', 0); 
         $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
       public function showColonias($cp)
    {
        $this->db->select('c.*');
        $this->db->from('tblcolonia c');
         $this->db->where('c.cp',$cp);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
      public function showMunicipio($cp)
    {
        $this->db->select('m.*');
        $this->db->from('tblcolonia c');
        $this->db->join('tblmunicipio m ', 'c.idmunicipio = m.idmunicipio');
        $this->db->where('c.cp',$cp);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
      public function showEstado($cp)
    {
        $this->db->select('e.*');
        $this->db->from('tblcolonia c');
        $this->db->join('tblmunicipio m ', 'c.idmunicipio = m.idmunicipio');
         $this->db->join('tblestado e ', 'e.idestado = m.idestado');
        $this->db->where('c.cp',$cp);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
     public function showAllUnidades($idplantel = '') {
        $this->db->select('u.*');
        $this->db->from('tblunidad u'); 
        if (isset($idplantel) && !empty($idplantel)) {
        $this->db->where('u.idplantel',$idplantel); 
        }  
         $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
         public function showAllEspecialidades($idplantel = '') {
        $this->db->select('e.*');
        $this->db->from('tblespecialidad e'); 
        if (isset($idplantel) && !empty($idplantel)) {
        $this->db->where('e.idplantel',$idplantel); 
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
        $this->db->where('d.iddia NOT IN (6,7)');
         $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    } 
      public function showAllGrupos($idplantel = '') {
        $this->db->select('g.idgrupo,n.nombrenivel,g.nombregrupo');
        $this->db->from('tblgrupo g'); 
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
    public function showAllTipoAsistencia() {
        $this->db->select('a.*');
        $this->db->from('tblmotivo_asistencia a');  
         $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
 
    public function showAllTutorAlumno($idalumno = '') {
        $this->db->select('t.nombre,t.apellidop,t.apellidom,t.escolaridad,t.ocupacion,t.dondetrabaja, t.fnacimiento,direccion,telefono,correo');
        $this->db->from('tbltutor t');  
        $this->db->join('tbltutoralumno ta','ta.idtutor= t.idtutor');
        $this->db->where('ta.idalumno',$idalumno);
         $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    } 

    public function validarMatricula($matricula = '',$idalumno = '', $idplantel = '') {
        $this->db->select('a.*');
        $this->db->from('tblalumno a'); 
        $this->db->where('a.matricula',$matricula);
        if(!empty($idalumno)){
        $this->db->where('a.idalumno !=',$idalumno);
        }
         if(!empty($idplantel)){
        $this->db->where('a.idplantel',$idplantel);
        }
         $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    } 

      public function showAllMaterias($dhorario) {
        $this->db->select('hd.idhorariodetalle,hd.idhorario, hd.horainicial, hd.horafinal, m.nombreclase,p.nombre, p.apellidop, p.apellidom,m.idmateria');
        $this->db->from('tblhorario_detalle hd'); 
        $this->db->join('tblprofesor_materia pm', 'hd.idmateria = pm.idprofesormateria');
        $this->db->join('tblmateria m', 'm.idmateria = pm.idmateria');
        $this->db->join('tblprofesor p', 'p.idprofesor = pm.idprofesor');
         $this->db->where('hd.idhorario', $dhorario);
        $this->db->group_by('m.idmateria');
         $this->db->order_by('m.nombreclase ASC');
         $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    } 
     public function showAllTareaAlumno($dhorario = '',$idmateria = '') {
        $this->db->select('t.idtarea, hd.idhorariodetalle,hd.idhorario, hd.horainicial, hd.horafinal, m.nombreclase,p.nombre, p.apellidop, p.apellidom,t.tarea, t.fechaentrega');
        $this->db->from('tblhorario_detalle hd'); 
        $this->db->join('tblprofesor_materia pm', 'hd.idmateria = pm.idprofesormateria');
        $this->db->join('tblmateria m', 'm.idmateria = pm.idmateria');
        $this->db->join('tblprofesor p', 'p.idprofesor = pm.idprofesor');
        $this->db->join('tbltarea t', 't.idhorariodetalle = hd.idhorariodetalle');
        if(isset($idhorario) && !empty($idhorario)){
        $this->db->where('hd.idhorario', $dhorario);
        }
        if(isset($idmateria) && !empty($idmateria)){
         $this->db->where('m.idmateria', $idmateria);
        }
         $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    } 
      public function showTareaAlumnoMateria($dhorario) {
        $this->db->select('hd.idhorariodetalle,hd.idhorario, hd.horainicial, hd.horafinal, m.nombreclase,p.nombre, p.apellidop, p.apellidom,LEFT(t.tarea, 90) as tarea, t.idtarea, t.fechaentrega');
        $this->db->from('tblhorario_detalle hd'); 
        $this->db->join('tblprofesor_materia pm', 'hd.idmateria = pm.idprofesormateria');
        $this->db->join('tblmateria m', 'm.idmateria = pm.idmateria');
        $this->db->join('tblprofesor p', 'p.idprofesor = pm.idprofesor');
        $this->db->join('tbltarea t', 't.idhorariodetalle = hd.idhorariodetalle');
        $this->db->where('hd.idhorario', $dhorario); 
         $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    } 
     
     public function validadAlumnoGrupo($idalumno) {
        $this->db->select('t.*');
        $this->db->from('tblalumno_grupo t');
        $this->db->where('t.idalumno',$idalumno); 
         $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    } 

      public function detalleUnidad($idunidad = '') {
        $this->db->select('u.*');
        $this->db->from('tblunidad u');
        $this->db->where('u.idunidad',$idunidad); 
         $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    } 
    

    
     public function showAllTutoresDisponibles($idplantel = '') {
        $this->db->select('t.*');
        $this->db->from('tbltutor t');
        if (isset($idplantel) && !empty($idplantel)) {
        $this->db->where('t.idplantel',$idplantel); 
        }   
        $this->db->order_by('t.nombre ASC');
         $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    } 
   public function showAllTutores($idalumno)
    {
        $this->db->select('t.idtutoralumno, a.nombre, a.apellidop, a.apellidom');    
        $this->db->from('tbltutoralumno t');
        $this->db->join('tbltutor a', 'a.idtutor = t.idtutor');
        $this->db->where('t.idalumno', $idalumno); 
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function showAllTareas($idhorariodetalle)
    {
        $this->db->select('t.*');
        $this->db->from('tbltarea t'); 
        $this->db->where('t.idhorariodetalle', $idhorariodetalle); 
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function detalleClase($idhorariodetalle = '') {
        $this->db->select('m.nombreclase');
        $this->db->from('tblhorario_detalle hd');
        $this->db->join('tblprofesor_materia pm','hd.idmateria = pm.idprofesormateria'); 
        $this->db->join('tblmateria m','m.idmateria = pm.idmateria');  
        $this->db->where('hd.idhorariodetalle',$idhorariodetalle);  
         $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

      public function showAllAlumnoId($idalumno)
    {
        $this->db->select('t.*, e.nombreespecialidad');
        $this->db->from('tblalumno t'); 
        $this->db->where('t.idalumno', $idalumno); 
        $this->db->join('tblespecialidad e', 't.idespecialidad = e.idespecialidad'); 
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
            //return $query->first_row();
        } else {
            return false;
        }
    }
     public function ultimaFechaAsistencia($idalumno,$idhorariodetalle)
    {
        $this->db->select('a.fecha');
        $this->db->from('tblasistencia a'); 
        $this->db->where('a.idalumno', $idalumno);
         $this->db->where('a.idhorariodetalle', $idhorariodetalle);
         $this->db->order_by('a.fecha DESC'); 
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
           return $query->first_row();
        } else {
            return false;
        }
    }
    public function primeraFechaAsistencia($idalumno,$idhorariodetalle)
    {
        $this->db->select('a.fecha');
        $this->db->from('tblasistencia a'); 
        $this->db->where('a.idalumno', $idalumno);
         $this->db->where('a.idhorariodetalle', $idhorariodetalle);
         $this->db->order_by('a.fecha ASC'); 
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
           return $query->first_row();
        } else {
            return false;
        }
    }

      public function listaAlumnoPorGrupo($idgrupo = '', $idplantel = '')
    {
         $query =$this->db->query("SELECT 
                                    a.nombre,
                                    a.apellidop,
                                    a.apellidom,
                                    h.idhorario,
                                    a.idalumno,
                                    ag.idgrupo, 
                                    h.idhorario,
                                  ( ( (SELECT COALESCE(SUM(c.calificacion),0) FROM tblcalificacion c WHERE c.idalumno = a.idalumno AND c.idhorario = h.idhorario) /   (SELECT COUNT(*) FROM tblunidad WHERE idplantel = $idplantel))/   (SELECT  count(distinct hd.idmateria) FROM tblhorario_detalle hd WHERE hd.idhorario  = h.idhorario )) as calificacion
                                  
                                FROM
                                    tblalumno a
                                        INNER JOIN
                                    tblalumno_grupo ag ON a.idalumno = ag.idalumno
                                        INNER JOIN
                                    tblhorario h ON ag.idgrupo = h.idgrupo
                                WHERE
                                    ag.idperiodo = h.idperiodo
                                        AND ag.activo = 1
                                        AND ag.idgrupo = $idgrupo");
       //  return $query->result();

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function horarioDia($idalumno,$idnivelestudio,$iddia)
    {
         $query =$this->db->query("SELECT 
                            ne.nombrenivel,
                            g.nombregrupo,
                            m.nombremes as mesinicio,
                            y.nombreyear as yearinicio,
                            m2.nombremes as mesfin,
                            y2.nombreyear as yearfin,
                            d.nombredia,
                            m.nombreclase,
                            pro.nombre,
                            pro.apellidop,
                            pro.apellidom,
                            hd.horainicial,
                            hd.horafinal
                        FROM
                            tblgrupo g
                                INNER JOIN
                            tblalumno_grupo ag ON g.idgrupo = ag.idgrupo
                                INNER JOIN
                            tblnivelestudio ne ON ne.idnivelestudio = g.idnivelestudio
                                INNER JOIN
                            tblhorario h ON h.idgrupo = g.idgrupo
                                INNER JOIN
                            tblperiodo p ON p.idperiodo = h.idperiodo
                                INNER JOIN
                            tblhorario_detalle hd ON hd.idhorario = h.idhorario
                                INNER JOIN
                            tbldia d ON d.iddia = hd.iddia
                                INNER JOIN
                            tblprofesor_materia pm ON pm.idprofesormateria = hd.idmateria
                                INNER JOIN
                            tblmateria m ON m.idmateria = pm.idmateria
                                INNER JOIN
                            tblprofesor pro ON pro.idprofesor = pm.idprofesor

                             INNER JOIN
                            tblmes m ON p.idmesinicio = m.idmes
                             INNER JOIN
                            tblmes m2 ON p.idmesfin = m2.idmes
                             INNER JOIN
                            tblyear y ON p.idyearinicio = y.idyear
                             INNER JOIN
                            tblyear y2 ON p.idyearfin = y2.idyear

                        WHERE
                            ag.idalumno = $idalumno
                                AND ne.idnivelestudio = $idnivelestudio
                                AND d.iddia = $iddia");
       //  return $query->result();

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
     public function nivelEstudio($idalumno)
    {
         $query =$this->db->query("SELECT 
                    g.nombregrupo, ne.idnivelestudio, ne.nombrenivel
                FROM
                    tblalumno_grupo ag
                        INNER JOIN
                    tblgrupo g ON ag.idgrupo = g.idgrupo
                        INNER JOIN
                    tblnivelestudio ne ON ne.idnivelestudio = g.idnivelestudio
                    WHERE ag.idalumno = $idalumno
                    ORDER BY ne.idnivelestudio  DESC ");
       //  return $query->result();

        if ($query->num_rows() > 0) {
            return $query->first_row();
        } else {
            return false;
        }
    }
      public function allKardex($idalumno)
    {
         $query =$this->db->query("SELECT 
                            h.idhorario,
                            m.nombremes AS mesinicio,
                            y.nombreyear AS yearinicio,
                            m2.nombremes AS mesfin,
                            y2.nombreyear AS yearfin,
                            g.nombregrupo,
                            ne.idnivelestudio,
                            ne.nombrenivel
                        FROM
                            tblperiodo p
                                INNER JOIN
                            tblhorario h ON p.idperiodo = h.idperiodo
                                INNER JOIN
                            tblalumno_grupo ag ON ag.idperiodo = p.idperiodo
                                INNER JOIN
                            tblmes m ON p.idmesinicio = m.idmes
                                INNER JOIN
                            tblmes m2 ON p.idmesfin = m2.idmes
                                INNER JOIN
                            tblyear y ON p.idyearinicio = y.idyear
                                INNER JOIN
                            tblyear y2 ON p.idyearfin = y2.idyear
                                INNER JOIN
                            tblgrupo g ON ag.idgrupo = g.idgrupo
                                INNER JOIN
                            tblnivelestudio ne ON ne.idnivelestudio = g.idnivelestudio
                        WHERE
                            ag.idgrupo = h.idgrupo
                                AND ag.idalumno = $idalumno
                                ORDER BY p.idperiodo DESC");
       //  return $query->result();

        if ($query->num_rows() > 0) {
             return $query->result();

        } else {
            return false;
        }
    }
          public function obtenerGrupo($idalumno)
    {
         $query =$this->db->query("SELECT 
                                    h.idhorario,
                                    m.nombremes as mesinicio,
                                    y.nombreyear as yearinicio,
                                    m2.nombremes as mesfin,
                                    y2.nombreyear as yearfin,
                                    g.nombregrupo,
                                    ne.idnivelestudio,
                                    ne.nombrenivel
                                FROM
                                    tblalumno_grupo ag
                                        INNER JOIN
                                    tblgrupo g ON ag.idgrupo = g.idgrupo
                                        INNER JOIN
                                    tblnivelestudio ne ON ne.idnivelestudio = g.idnivelestudio
                                        INNER JOIN
                                    tblhorario h ON h.idgrupo = ag.idgrupo
                                        INNER JOIN
                                    tblperiodo p ON p.idperiodo = h.idperiodo
                                     INNER JOIN
                                    tblmes m ON p.idmesinicio = m.idmes
                                     INNER JOIN
                                    tblmes m2 ON p.idmesfin = m2.idmes
                                     INNER JOIN
                                    tblyear y ON p.idyearinicio = y.idyear
                                     INNER JOIN
                                    tblyear y2 ON p.idyearfin = y2.idyear
                                WHERE
                                    p.idperiodo = ag.idperiodo
                                AND (h.activo = 1 OR  p.activo = 1) 
                                AND ag.activo = 1 
                                AND  ag.idalumno = $idalumno 
                                ORDER BY ne.idnivelestudio DESC");
       //  return $query->result();

        if ($query->num_rows() > 0) {
             return $query->first_row();

        } else {
            return false;
        }
    }



        public function searchAlumno($match) {
        $field = array(
                 't.nombre',
                 't.apellidop',
                 't.apellidom',
                 't.matricula'
        );
         $this->db->select('t.*');
        $this->db->from('tblalumno t'); 
        $this->db->like('concat(' . implode(',', $field) . ')', $match);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
   
    public function searchTutores($match,$idalumno) {
        $field = array(
                 't.nombre',
                 't.apellidop',
                 't.apellidom'
        );
         $this->db->select('t.*');
        $this->db->from('tbltutor t'); 
        $this->db->join('tbltutoralumno ta', 'ta.idtutor = t.idtutor');
        $this->db->where('ta.idalumno',$idalumno);
        $this->db->like('concat(' . implode(',', $field) . ')', $match);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
   
     public function addAlumno($data)
    {
        $this->db->insert('tblalumno', $data);
        $insert_id = $this->db->insert_id(); 
        return  $insert_id;
    }
     public function asignarGrupo($data)
    {
        $this->db->insert('tblalumno_grupo', $data);
        $insert_id = $this->db->insert_id(); 
        return  $insert_id;
    }
    public function addTutorAlumno($data)
    {
        $this->db->insert('tbltutoralumno', $data);
        $insert_id = $this->db->insert_id(); 
        return  $insert_id;
    }
    
       public function detalleAlumno($idalumno)
    {
        $this->db->select('t.*, 
         e.nombreespecialidad,
         p.clave,
         p.nombreplantel, 
         p.direccion, 
         p.telefono,
         ts.tiposanguineo
         ');
        $this->db->from('tblalumno t'); 
        $this->db->join('tblespecialidad e', 'e.idespecialidad = t.idespecialidad');
        $this->db->join('tblplantel p', 'p.idplantel = t.idplantel');
         $this->db->join('tbltiposanguineo ts', 'ts.idtiposanguineo = t.idtiposanguineo');
        $this->db->where('t.idalumno', $idalumno);
      
        $query = $this->db->get(); 
        return $query->first_row();
    }
    
    public function updateAlumno($id, $field)
    {
        $this->db->where('idalumno', $id);
        $this->db->update('tblalumno', $field);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
        
    }
        public function updateBecaAlumno($id, $field)
    {
        $this->db->where('idalumno', $id);
        $this->db->where('activo', 1);
        $this->db->update('tblalumno_grupo', $field);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
        
    }
public function detalleGrupoActual($idalumno)
    {
        $this->db->select('g.nombregrupo, n.nombrenivel, t.nombreturno');
        $this->db->from('tblalumno_grupo ag'); 
        //$this->db->where('t.idprofesor', $idprofesor);
        $this->db->join('tblgrupo g', 'ag.idgrupo = g.idgrupo');
        $this->db->join('tblnivelestudio n', 'g.idnivelestudio = n.idnivelestudio');
         $this->db->join('tblturno t', 't.idturno = g.idturno');
        $this->db->where('ag.idalumno', $idalumno);
        $this->db->order_by("n.nombrenivel", "asc");
        $query = $this->db->get();
         if ($this->db->affected_rows() > 0) {
        return $query->first_row();
        }else{
            return false;
        }
    }
    public function obtenerCalificacionMateria($idhorariodetalle = '',$idalumno = '', $idunidad = '')
    {
        $this->db->select('c.calificacion');
        $this->db->from('tblcalificacion c');   
        $this->db->where('c.idalumno', $idalumno);
         $this->db->where('c.idhorariodetalle', $idhorariodetalle);
          $this->db->where('c.idunidad', $idunidad); 
        $query = $this->db->get();
         if ($this->db->affected_rows() > 0) {
        return $query->first_row();
        }else{
            return false;
        }
    }
     public function obtenerAsistenciaMateria($idhorariodetalle = '',$idalumno = '', $idunidad = '')
    {
        $this->db->select('a.*');
        $this->db->from('tblasistencia a');   
        $this->db->where('a.idalumno', $idalumno);
        $this->db->where('a.idhorariodetalle', $idhorariodetalle);
        $this->db->where('a.idunidad', $idunidad); 
        $this->db->where('a.idmotivo', 4); 
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->result();
        }else{
            return false;
        }
    }
    

public function deleteTutor($id)
    {
        $this->db->where('idtutoralumno', $id);
        $this->db->delete('tbltutoralumno');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
        
    }
      
      public function obtenerCalificacionAlumno($idalumno ='', $idgrupo = '',$idplantel = '')
    {
         $query =$this->db->query(" SELECT 
                                    p.nombre,
                                    p.apellidop,
                                    p.apellidom,
                                    m.nombreclase,
                                    COALESCE(SUM(c.calificacion), 0) AS calificacionmateria,
                                    (SELECT 
                                            COUNT(*)
                                        FROM
                                            tblunidad WHERE idplantel = $idplantel) AS totalunidad,
                                    (COALESCE(SUM(c.calificacion), 0) / (SELECT 
                                            COUNT(*)
                                        FROM
                                            tblunidad WHERE idplantel = $idplantel)) AS calificacionfinal
                                FROM
                                    tblcalificacion c
                                        INNER JOIN
                                    tblhorario_detalle hd ON hd.idhorariodetalle = c.idhorariodetalle
                                        INNER JOIN
                                    tblprofesor_materia pm ON hd.idmateria = pm.idprofesormateria
                                        INNER JOIN
                                    tblmateria m ON pm.idmateria = m.idmateria
                                        INNER JOIN
                                    tblprofesor p ON pm.idprofesor = p.idprofesor
                                    inner join tblhorario h on h.idhorario = c.idhorario
                                WHERE
                                    c.idalumno = $idalumno
                                    and h.idgrupo =$idgrupo
                                GROUP BY c.idhorariodetalle ");
       //  return $query->result();

        if ($query->num_rows() > 0) {
             return $query->result();

        } else {
            return false;
        }
    }

public function deleteAlumno($idalumno='')
{
    # code...
     $this->db->where('idalumno', $idalumno);
        $this->db->delete('tblalumno');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
}

}
