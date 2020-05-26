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
        $this->db->select("a.matricula,a.nombre, a.apellidop, a.apellidom, tp.nombretipopago,tpc.concepto,pi.descuento, pi.autorizacion,pi.online, pi.pagado, DATE_FORMAT(pi.fechapago,'%d/%m/%Y') as fecha");
        $this->db->from('tblalumno a'); 
        $this->db->join('tblpago_inicio pi', 'pi.idalumno = a.idalumno'); 
        $this->db->join('tbltipo_pago tp', 'pi.idformapago = tp.idtipopago');
        $this->db->join('tbltipopagocol tpc', 'tpc.idtipopagocol = pi.idtipopagocol'); 

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
        
         $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
 
}
