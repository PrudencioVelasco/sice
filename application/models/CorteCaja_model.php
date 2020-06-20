<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class CorteCaja_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function __destruct() {
        $this->db->close();
    }
        public function showAllPagoInicio($fechainicio = '', $fechafin = '', $estatus = '', $pagoen = '') {
        $this->db->select("
        pi.folio,
        a.matricula,
        a.nombre, 
        a.apellidop, 
        a.apellidom, 
        tp.nombretipopago,
        tpc.concepto,
        pi.descuento, 
        dpi.autorizacion,
        pi.online, 
        pi.pagado, 
         CASE  u.idtipousuario
            WHEN 1 THEN (SELECT CONCAT(pro.nombre,' ',pro.apellidop,' ',pro.apellidom) FROM tblprofesor pro WHERE pro.idprofesor = u.idusuario)
            WHEN 2 THEN (SELECT CONCAT(per.nombre,' ',per.apellidop,' ',per.apellidom) FROM tblpersonal per WHERE per.idpersonal = u.idusuario)
            WHEN 5 THEN (SELECT CONCAT(tut.nombre,' ',tut.apellidop,' ',tut.apellidom) FROM tbltutor tut WHERE tut.idtutor = u.idusuario)
            ELSE 'NO DEFINIDO'
            END AS usuario,
        DATE_FORMAT(pi.fechapago,'%d/%m/%Y') as fecha
        ");
        $this->db->from('tblalumno a'); 
        $this->db->join('tblpago_inicio pi', 'pi.idalumno = a.idalumno');  
        $this->db->join('tbltipopagocol tpc', 'tpc.idtipopagocol = pi.idtipopagocol'); 
        $this->db->join('tbldetalle_pago_inicio dpi','dpi.idpago = pi.idpago');
        $this->db->join('tbltipo_pago tp', 'dpi.idformapago = tp.idtipopago');
        $this->db->join('users u','u.id = dpi.idusuario');
        if((isset($fechainicio) && !empty($fechainicio)) && (isset($fechafin) && !empty($fechafin)) ){
          $this->db->where('pi.fechapago BETWEEN "'. $fechainicio. '" and "'. $fechafin.'"');
        }
        if(isset($pagoen) && !empty($pagoen)){
            $this->db->where('pi.online',$pagoen);
        }
         if(isset($estatus) && !empty($estatus)){
            $this->db->where('pi.pagado',$estatus);
        }
        if($this->session->idrol != 14){
             $this->db->where('a.idplantel',$this->session->idplantel);
        }
        $this->db->where('pi.eliminado',0); 
         $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
      public function showAllPagoColegiaturas($fechainicio = '', $fechafin = '', $estatus = '', $pagoen = '') {
        $this->db->select("es.folio,
         aa.matricula,
         aa.nombre,
         aa.apellidop,
         aa.apellidom,
         tp.nombretipopago,
         'MENSUALIDAD' AS concepto,
         m.nombremes, 
         dp.descuento, 
         DATE_FORMAT(es.fechapago,'%d/%m/%Y') as fecha, 
         dp.idformapago, 
         es.online, 
         es.pagado,
         CASE  u.idtipousuario
            WHEN 1 THEN (SELECT CONCAT(pro.nombre,' ',pro.apellidop,' ',pro.apellidom) FROM tblprofesor pro WHERE pro.idprofesor = u.idusuario)
            WHEN 2 THEN (SELECT CONCAT(per.nombre,' ',per.apellidop,' ',per.apellidom) FROM tblpersonal per WHERE per.idpersonal = u.idusuario)
            WHEN 5 THEN (SELECT CONCAT(tut.nombre,' ',tut.apellidop,' ',tut.apellidom) FROM tbltutor tut WHERE tut.idtutor = u.idusuario)
            ELSE 'NO DEFINIDO'
            END AS usuario,
         dp.autorizacion");
       
        $this->db->from('tblestado_cuenta es'); 
         
         $this->db->join('tblamotizacion a', 'a.idamortizacion = es.idamortizacion');
         $this->db->join('tblmes m', 'a.idperiodopago = m.idmes');  
         $this->db->join('tblalumno aa','es.idalumno = aa.idalumno');
         $this->db->join('tbldetalle_pago dp','dp.idestadocuenta = es.idestadocuenta');
         $this->db->join('tbltipo_pago tp', 'tp.idtipopago = dp.idformapago'); 
         $this->db->join('users u','u.id = dp.idusuario');
        if((isset($fechainicio) && !empty($fechainicio)) && (isset($fechafin) && !empty($fechafin)) ){
          $this->db->where('( DATE(es.fechapago) >= "'. $fechainicio. '" and  DATE(es.fechapago) <= "'. $fechafin.'")');
        }
        if(isset($pagoen) && !empty($pagoen)){
            $this->db->where('es.online',$pagoen);
        }
         if(isset($estatus) && !empty($estatus)){
            $this->db->where('es.pagado',$estatus);
        }
        if($this->session->idrol != 14){
             $this->db->where('aa.idplantel',$this->session->idplantel);
        }
         $this->db->where('es.eliminado', 0); 
         $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
 
}
