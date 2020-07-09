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
        $this->db->where('g.idplantel',$idplantel); 
        }  
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
        $this->db->where('o.idplantel',$idplantel); 
        }  
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
        $this->db->where('p.idplantel',$idplantel); 
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
        $this->db->where('g.idnivelestudio',$idnivelestudio);
        $this->db->where('g.idturno', $idturno);
        $this->db->where('g.nombregrupo', $nombregrupo); 
        if (isset($idplantel) && !empty($idplantel)) {
        $this->db->where('g.idplantel',$idplantel); 
        }  
         $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
        public function validarUpdateGrupo($idnivelestudio = '', $idturno = '', $nombregrupo = '', $idgrupo,$idplantel = '') {
        $this->db->select('');
        $this->db->from('tblgrupo g'); 
        $this->db->where('g.idnivelestudio',$idnivelestudio);
        $this->db->where('g.idturno', $idturno);
        $this->db->where('g.nombregrupo', $nombregrupo); 
        $this->db->where('g.idgrupo !=', $idgrupo); 
        if (isset($idplantel) && !empty($idplantel)) {
        $this->db->where('g.idplantel',$idplantel); 
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
        $this->db->where('n.idplantel',$idplantel);
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
        $this->db->where('n.numero',1);
        $this->db->where('n.idplantel',$idplantel);
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
      public function detalleAlumnoGrupo($idalumno,$idperiodo) {
        $this->db->select('ag.*');
        $this->db->from('tblalumno_grupo ag');
        $this->db->where('ag.idalumno',$idalumno);
        $this->db->where('ag.idperiodo',$idperiodo);  
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


      public function searchGrupo($match,$idplantel = '') {
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
        $this->db->where('g.idplantel',$idplantel); 
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
        $this->db->select('hd.idhorariodetalle,ma.nombreclase,p.nombre, p.apellidop, p.apellidom, g.nombregrupo,ne.nombrenivel, g.idgrupo, h.idhorario,m.nombremes as mesinicio,m2.nombremes as mesfin,y.nombreyear as yearinicio,y2.nombreyear as yearfin');
        $this->db->from('tblhorario_detalle hd'); 
        $this->db->join('tblprofesor_materia pm', 'pm.idprofesormateria = hd.idmateria');
        $this->db->join('tblprofesor p', 'p.idprofesor = pm.idprofesor');
        $this->db->join('tblmateria ma', 'ma.idmateria = pm.idmateria'); 
        $this->db->join('tblhorario h', 'hd.idhorario = h.idhorario');
        $this->db->join('tblgrupo g', 'g.idgrupo = h.idgrupo');
        $this->db->join('tblnivelestudio ne', 'ne.idnivelestudio = g.idnivelestudio');
        $this->db->join('tblperiodo pe', 'pe.idperiodo = h.idperiodo');
        $this->db->join('tblmes m ', ' pe.idmesinicio = m.idmes'); 
        $this->db->join('tblmes m2 ', ' pe.idmesfin = m2.idmes'); 
        $this->db->join('tblyear y ', ' pe.idyearinicio = y.idyear');
        $this->db->join('tblyear y2 ', ' pe.idyearfin = y2.idyear');  
        $this->db->join('tblhorario ho', 'ho.idhorario = hd.idhorario');
        $this->db->where('p.idprofesor', $idprofesor);
        $this->db->where('(pe.activo = 1 or ho.activo = 1)');
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

        public function dia($idhorariodetalle='')
        {
            # code...
        $this->db->select('d.iddia,d.nombredia, de.horainicial, de.horafinal');
        $this->db->from('tblhorario_detalle de');  
        $this->db->join('tbldia d', 'd.iddia = de.iddia'); 
        $this->db->where('de.idhorariodetalle', $idhorariodetalle); 
        $query = $this->db->get();
         if ($this->db->affected_rows() > 0) {
        return $query->first_row();
        }else{
            return false;
        }
        }
           public function detalleCalificacion($idcalificacion='')
        {
            # code...
        $this->db->select('c.idcalificacion, date(c.fecharegistro) as fecharegistro');
        $this->db->from('tblcalificacion c');   
        $this->db->where('c.idcalificacion', $idcalificacion); 
        $query = $this->db->get();
         if ($this->db->affected_rows() > 0) {
        return $query->first_row();
        }else{
            return false;
        }
        }
              public function detalleCalificacionUnidad($idunidad='',$idhorariodetalle)
        {
            # code...
        $this->db->select('c.idcalificacion, date(c.fecharegistro) as fecharegistro');
        $this->db->from('tblcalificacion c');   
        $this->db->where('c.idunidad', $idunidad); 
        $this->db->where('c.idhorariodetalle', $idhorariodetalle); 
        $query = $this->db->get();
         if ($this->db->affected_rows() > 0) {
        return $query->first_row();
        }else{
            return false;
        }
        }

        public function allTarea($idhorariodetalle='')
        {
            # code...
        $this->db->select('t.*');
        $this->db->from('tbltarea t');   
        $this->db->where('t.idhorariodetalle', $idhorariodetalle); 
        $query = $this->db->get();
         if ($this->db->affected_rows() > 0) {
        return $query->result();
        }else{
            return false;
        }
        }
         public function listaPlaneacion($idunidad,$idhorariodetalle='')
        {
            # code...
        $this->db->select('p.idplaneacion,p.planeacion,p.lugar,p.fechainicio, p.fechafin');
        $this->db->from('tblplaneacion p');   
        $this->db->where('p.iddetallehorario', $idhorariodetalle); 
        $this->db->where('p.idunidad', $idunidad); 
        $query = $this->db->get();
         if ($this->db->affected_rows() > 0) {
        return $query->result();
        }else{
            return false;
        }
        }

          public function validarAgregarCalificacion($idunidad,$idhorariodetalle='')
        {
            # code...
        $this->db->select('c.*');
        $this->db->from('tblcalificacion c');   
        $this->db->where('c.idhorariodetalle', $idhorariodetalle); 
        $this->db->where('c.idunidad', $idunidad); 
        $query = $this->db->get();
         if ($this->db->affected_rows() > 0) {
        return $query->result();
        }else{
            return false;
        }
        }
          public function validarAgregarAsistencia($fecha,$idhorariodetalle='',$idunidad = '')
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
        }else{
            return false;
        }
        }

    public function unidades($idplantel = '')
        {
            # code...
        $this->db->select('u.idunidad, u.nombreunidad');
        $this->db->from('tblunidad u');   
        $this->db->where('u.idplantel',$idplantel);   
        $query = $this->db->get();
         if ($this->db->affected_rows() > 0) {
       return $query->result();
        }else{
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
        }else{
            return false;
        }
        }

          public function addPlaneacion($data)
    {
        $this->db->insert('tblplaneacion', $data);
        $insert_id = $this->db->insert_id(); 
        return  $insert_id;
    }
        public function addAsistencia($data)
    {
        $this->db->insert('tblasistencia', $data);
        $insert_id = $this->db->insert_id(); 
        return  $insert_id;
    }
      public function addTarea($data)
    {
        $this->db->insert('tbltarea', $data);
        $insert_id = $this->db->insert_id(); 
        return  $insert_id;
    }
       public function addGrupo($data)
    {
        $this->db->insert('tblgrupo', $data);
        $insert_id = $this->db->insert_id(); 
        return  $insert_id;
    }
            public function addCalificacion($data)
    {
        $this->db->insert('tblcalificacion', $data);
        $insert_id = $this->db->insert_id(); 
        return  $insert_id;
    }

public function eliminarPlaneacion($idplaneacion='')
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
public function eliminarAsistenciaFecha($idhorariodetalle = '',$fecha = '')
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
public function eliminarCalificacionUnidad($idunidad = '',$idhorariodetalle = '',$idoportunidadexamen = '')
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
public function eliminarTarea($idtarea='')
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
public function deleteGrupo($idgrupo='')
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
public function deleteCalificacion($idcalificacion='')
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
public function deleteAsistencia($idasistencia='')
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


    public function alumnosGrupo($idhorario)
    {
         $query =$this->db->query(" SELECT 
                                    a.idalumno,
                                    a.nombre,
                                    a.apellidop,
                                    a.apellidom,
                                    ne.nombrenivel,
                                    g.nombregrupo
                                FROM
                                    tblalumno a
                                        INNER JOIN
                                    tblalumno_grupo ag ON a.idalumno = ag.idalumno
                                        INNER JOIN
                                    tblgrupo g ON g.idgrupo = ag.idgrupo
                                        INNER JOIN
                                    tblnivelestudio ne ON ne.idnivelestudio = g.idnivelestudio
                                        INNER JOIN
                                    tblhorario h ON ag.idgrupo = h.idgrupo
                                        INNER JOIN
                                    tblperiodo p ON p.idperiodo = h.idperiodo
                                WHERE
                                     p.idperiodo = ag.idperiodo
                                    AND (h.activo = 1 OR  p.activo = 1) AND ag.activo = 1 
                                    AND h.idhorario  = $idhorario ORDER BY a.apellidop ASC");
       //  return $query->result();

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    
     
  public function listaAsistencia($idalumno = '',$idhorario='',$fecha = '', $idhorariodetalle = '',$idunidad = '')
        {
            # code...
        $this->db->select('a.idasistencia,ma.idmotivo, a.fecha,ma.nombremotivo, ma.abreviatura');
        $this->db->from('tblasistencia a');   
         $this->db->join('tblmotivo_asistencia ma', 'a.idmotivo = ma.idmotivo'); 
        $this->db->where('a.idalumno', $idalumno); 
        $this->db->where('a.idhorario', $idhorario); 
        $this->db->where('a.idhorariodetalle', $idhorariodetalle); 
        $this->db->where('a.fecha', $fecha); 
        if(isset($idunidad) && !empty($idunidad) && $idunidad != 0){
        $this->db->where('a.idunidad', $idunidad); 
        }
        $query = $this->db->get();
         if ($this->db->affected_rows() > 0) {
       return $query->first_row();
        }else{
            return false;
        }
        }
          public function listaAsistenciaBuscar($idalumno = '',$idhorario='',$fecha = '', $idhorariodetalle = '',$idmotivo = '')
        {
            # code...
        $this->db->select('a.idasistencia,ma.idmotivo, a.fecha,ma.nombremotivo, ma.abreviatura');
        $this->db->from('tblasistencia a');   
         $this->db->join('tblmotivo_asistencia ma', 'a.idmotivo = ma.idmotivo'); 
        $this->db->where('a.idalumno', $idalumno); 
        $this->db->where('a.idhorario', $idhorario); 
        $this->db->where('a.idhorariodetalle', $idhorariodetalle); 
        $this->db->where('a.fecha', $fecha); 
        if(isset($idmotivo) && !empty($idmotivo) && $idmotivo != 0){
        $this->db->where('ma.idmotivo', $idmotivo); 
        }
        $query = $this->db->get();
         if ($this->db->affected_rows() > 0) {
       return $query->first_row();
        }else{
            return false;
        }
        }

 
public function listaAsistenciaGeneral($idalumno = '',$idhorario='',$fecha = '', $idhorariodetalle = '', $motivo = '')
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
        }else{
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

public function obtenerCalificacion($idalumno='',$idunidad = '', $idhorariodetalle = '')
{
    # code...
        $this->db->select('c.idcalificacion, c.calificacion, date(c.fecharegistro) as fecharegistro');
        $this->db->from('tblcalificacion c');   
         $this->db->join('tblunidad u', 'c.idunidad = u.idunidad'); 
        $this->db->where('c.idalumno', $idalumno); 
        //$this->db->where('a.idhorario', $idhorario); 
        $this->db->where('c.idhorariodetalle', $idhorariodetalle); 
        $this->db->where('c.idunidad', $idunidad); 
        $query = $this->db->get();
         if ($this->db->affected_rows() > 0) {
       return $query->first_row();
        }else{
            return false;
        }

}
   public function obtenerAlumnoRecuperar($idhorariodetalle,$idoportunidad)
   {
        $this->db->select('a.idalumno, a.nombre, a.apellidop, a.apellidom');
        $this->db->from('tblalumno a'); 
        $this->db->join('tblalumno_grupo ag','ag.idalumno = a.idalumno'); 
        $this->db->join('tblhorario h','h.idperiodo = ag.idperiodo');
        $this->db->join('tblhorario h2','h2.idgrupo = ag.idgrupo');  
        $this->db->join('tblhorario_detalle hd','hd.idhorario = h.idhorario');
        $this->db->where('hd.idhorariodetalle',$idhorariodetalle); 
        
        
        $query = $this->db->get();
         if ($this->db->affected_rows() > 0) {
             return $query->result();
        }else{
            return false;
        }
   }   

}
