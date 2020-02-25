<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class EstadoCuenta_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function __destruct() {
        $this->db->close();
    }

  
   public function showAllCicloEscolar($idplantel = '') {
        $this->db->select('p.*,m.nombremes as mesinicio,m2.nombremes as mesfin,y.nombreyear as yearinicio,y2.nombreyear as yearfin');
        $this->db->from('tblperiodo p'); 
        $this->db->join('tblmes m ', ' p.idmesinicio = m.idmes'); 
        $this->db->join('tblmes m2 ', ' p.idmesfin = m2.idmes'); 
        $this->db->join('tblyear y ', ' p.idyearinicio = y.idyear');
        $this->db->join('tblyear y2 ', ' p.idyearfin = y2.idyear'); 
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
public function showAllFormasPago() {
        $this->db->select('tp.idtipopago as idformapago, tp.nombretipopago');
        $this->db->from('tbltipo_pago tp'); 
        $this->db->where('tp.activo', 1);  
         $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

public function showAllPagosInicio($idalumno = '',$idperiodo = '') {
        $this->db->select("pi.descuento, DATE_FORMAT(pi.fechapago,'%d/%m/%Y') as fechapago ,tp.nombretipopago, pi.autorizacion");
        $this->db->from('tblpago_inicio pi'); 
        $this->db->join('tbltipo_pago tp ', ' tp.idtipopago = pi.idformapago');
        $this->db->where('pi.idalumno',$idalumno);
        $this->db->where('pi.idperiodo',$idperiodo);  
         $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

public function showAllTableAmotizacion($idperiodo='',$idalumno='')
{
          $query =$this->db->query("SELECT 
    a.idamortizacion,
    pp.year as yearp,
    a.descuento,
    a.pagado,
     pp.mes as numeromes,
     a.idperiodo,
    CASE
        WHEN pp.mes = 1 THEN 'ENERO'
        WHEN pp.mes = 2 THEN 'FEBRERO'
        WHEN pp.mes = 3 THEN 'MARZO'
        WHEN pp.mes = 4 THEN 'ABRIL'
        WHEN pp.mes = 5 THEN 'MAYO'
        WHEN pp.mes = 6 THEN 'JUNIO'
        WHEN pp.mes = 7 THEN 'JULIO'
        WHEN pp.mes = 8 THEN 'AGOSTO'
        WHEN pp.mes = 9 THEN 'SEPTIEMBRE'
        WHEN pp.mes = 10 THEN 'OCTUBRE'
        WHEN pp.mes = 11 THEN 'NOVIEMBRE'
        WHEN pp.mes = 12 THEN 'DICIEMBRE'
        ELSE 'NO DEFINIDO'
    END AS mes
FROM
    tblamotizacion a
        JOIN
    tblperiodo_pago pp ON a.idperiodopago = pp.idperiodopago
    WHERE a.idperiodo = $idperiodo AND a.idalumno = $idalumno"); 
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
}
public function showAllEstadoCuenta($idperiodo='',$idalumno='',$idamortizacion = '')
{
          $query =$this->db->query("SELECT 
    a.idamortizacion,
    pp.year as yearp,
    ec.descuento,
    a.pagado,
    pp.mes as numeromes, 
    a.idperiodo,
     DATE_FORMAT(ec.fechapago,'%d/%m/%Y') as fechapago,
    CASE
        WHEN pp.mes = 1 THEN 'ENERO'
        WHEN pp.mes = 2 THEN 'FEBRERO'
        WHEN pp.mes = 3 THEN 'MARZO'
        WHEN pp.mes = 4 THEN 'ABRIL'
        WHEN pp.mes = 5 THEN 'MAYO'
        WHEN pp.mes = 6 THEN 'JUNIO'
        WHEN pp.mes = 7 THEN 'JULIO'
        WHEN pp.mes = 8 THEN 'AGOSTO'
        WHEN pp.mes = 9 THEN 'SEPTIEMBRE'
        WHEN pp.mes = 10 THEN 'OCTUBRE'
        WHEN pp.mes = 11 THEN 'NOVIEMBRE'
        WHEN pp.mes = 12 THEN 'DICIEMBRE'
        ELSE 'NO DEFINIDO'
    END AS mes
FROM
    tblamotizacion a
        JOIN
    tblperiodo_pago pp ON a.idperiodopago = pp.idperiodopago
     JOIN
    tblestado_cuenta ec ON a.idamortizacion = ec.idamortizacion
    WHERE a.idperiodo = $idperiodo AND a.idalumno = $idalumno  AND ec.idamortizacion = $idamortizacion"); 
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
}
 
 public function showAllEstadoCuentaTodos($idperiodo='',$idalumno='')
{
          $query =$this->db->query("SELECT 
    a.idamortizacion,
    pp.year as yearp,
    ec.descuento,
    a.pagado,
    pp.mes as numeromes, 
    a.idperiodo,
    DATE_FORMAT(ec.fechapago,'%d/%m/%Y') as fechapago,
    CASE
        WHEN pp.mes = 1 THEN 'ENERO'
        WHEN pp.mes = 2 THEN 'FEBRERO'
        WHEN pp.mes = 3 THEN 'MARZO'
        WHEN pp.mes = 4 THEN 'ABRIL'
        WHEN pp.mes = 5 THEN 'MAYO'
        WHEN pp.mes = 6 THEN 'JUNIO'
        WHEN pp.mes = 7 THEN 'JULIO'
        WHEN pp.mes = 8 THEN 'AGOSTO'
        WHEN pp.mes = 9 THEN 'SEPTIEMBRE'
        WHEN pp.mes = 10 THEN 'OCTUBRE'
        WHEN pp.mes = 11 THEN 'NOVIEMBRE'
        WHEN pp.mes = 12 THEN 'DICIEMBRE'
        ELSE 'NO DEFINIDO'
    END AS mes
FROM
    tblamotizacion a
        JOIN
    tblperiodo_pago pp ON a.idperiodopago = pp.idperiodopago
     JOIN
    tblestado_cuenta ec ON a.idamortizacion = ec.idamortizacion
    WHERE a.idperiodo = $idperiodo AND a.idalumno = $idalumno"); 
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
}
 

public function datosTablaAmortizacion($idamortizacion='')
    {
        $this->db->select('a.idalumno, a.idamortizacion,a.idperiodo, a.descuento');
        $this->db->from('tblamotizacion a'); 
        $this->db->where('a.idamortizacion', $idamortizacion);  
         $query = $this->db->get();
        if ($query->num_rows() > 0) {
             return $query->first_row();
        } else {
            return false;
        }
    } 

       public function updateTablaAmortizacion($id, $field)
    {
        $this->db->where('idamortizacion', $id);
        $this->db->update('tblamotizacion', $field);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
        
    } 

     public function addEstadoCuenta($data)
    {
        $this->db->insert('tblestado_cuenta', $data);
        $insert_id = $this->db->insert_id(); 
        return  $insert_id;
    }
     public function addDetalleEstadoCuenta($data)
    {
        $this->db->insert('tbldetalle_pago', $data);
        $insert_id = $this->db->insert_id(); 
        return  $insert_id;
    }
      public function addPagoInicio($data)
    {
        $this->db->insert('tblpago_inicio', $data);
        $insert_id = $this->db->insert_id(); 
        return  $insert_id;
    }


}
