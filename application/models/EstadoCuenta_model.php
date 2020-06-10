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
        $this->db->order_by('p.idperiodo DESC');
         $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function showAllTipoPago() {
        $this->db->select('tp.*');
        $this->db->from('tbltipopagocol tp'); 
        $this->db->where('tp.idtipopagocol  IN (1,2)'); 
         $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    } 
        public function showAllMeses() {
        $this->db->select('tp.*');
        $this->db->from('tblmes tp');  
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
    public function validarAddColegiatura($idalumno,$idperiodo,$idmes) {
        $this->db->select('ec.*');
        $this->db->from('tblestado_cuenta ec'); 
        $this->db->join('tblamotizacion a','ec.idamortizacion = a.idamortizacion'); 
        $this->db->where('ec.idalumno', $idalumno); 
        $this->db->where('ec.idperiodo', $idperiodo); 
        $this->db->where('a.idperiodopago', $idmes);  
         $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }


    public function descuentoPagosInicio($idalumno = '',$idperiodo = '', $idtipo = '') {
        $this->db->select("co.descuento, b.descuento as descuentobeca,(co.descuento - (b.descuento / 100 * co.descuento)) as beca");
        $this->db->from('tblcolegiatura co');  
        $this->db->join('tblgrupo g ', ' g.idnivelestudio = co.idnivelestudio');
        $this->db->join('tblalumno_grupo ag ', ' ag.idgrupo = g.idgrupo');
        $this->db->join('tblbeca b ', 'b.idbeca = ag.idbeca');
        $this->db->where('ag.idalumno',$idalumno);
        $this->db->where('ag.idperiodo',$idperiodo);  
        $this->db->where('co.activo',1);  
         $this->db->where('co.idtipopagocol',$idtipo);  
         $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

public function showAllPagosInicio($idalumno = '',$idperiodo = '') {
        $this->db->select("pi.idpago, pi.descuento, DATE_FORMAT(pi.fechapago,'%d/%m/%Y') as fechapago ,tp.nombretipopago,tp.idtipopago, pi.pagado, pi.autorizacion");
        $this->db->from('tblpago_inicio pi'); 
        $this->db->join('tbltipo_pago tp ', ' tp.idtipopago = pi.idformapago');
        $this->db->where('pi.idalumno',$idalumno);
        $this->db->where('pi.idperiodo',$idperiodo);  
         $this->db->where('pi.eliminado',0);  
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
    a.descuento,
    a.pagado,
     pp.numero as numeromes,
     a.idperiodo,
    CASE
        WHEN pp.numero = 1 THEN 'ENERO'
        WHEN pp.numero = 2 THEN 'FEBRERO'
        WHEN pp.numero = 3 THEN 'MARZO'
        WHEN pp.numero = 4 THEN 'ABRIL'
        WHEN pp.numero = 5 THEN 'MAYO'
        WHEN pp.numero = 6 THEN 'JUNIO'
        WHEN pp.numero = 7 THEN 'JULIO'
        WHEN pp.numero = 8 THEN 'AGOSTO'
        WHEN pp.numero = 9 THEN 'SEPTIEMBRE'
        WHEN pp.numero = 10 THEN 'OCTUBRE'
        WHEN pp.numero = 11 THEN 'NOVIEMBRE'
        WHEN pp.numero = 12 THEN 'DICIEMBRE'
        ELSE 'NO DEFINIDO'
    END AS mes
FROM
    tblamotizacion a
        JOIN
    tblmes pp ON a.idperiodopago = pp.idmes
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
          ec.idestadocuenta,
    a.idamortizacion, 
    ec.descuento,
    ec.pagado,
    pp.numero as numeromes, 
    a.idperiodo,
     DATE_FORMAT(ec.fechapago,'%d/%m/%Y') as fechapago,
    CASE
        WHEN pp.numero = 1 THEN 'ENERO'
        WHEN pp.numero = 2 THEN 'FEBRERO'
        WHEN pp.numero = 3 THEN 'MARZO'
        WHEN pp.numero = 4 THEN 'ABRIL'
        WHEN pp.numero = 5 THEN 'MAYO'
        WHEN pp.numero = 6 THEN 'JUNIO'
        WHEN pp.numero = 7 THEN 'JULIO'
        WHEN pp.numero = 8 THEN 'AGOSTO'
        WHEN pp.numero = 9 THEN 'SEPTIEMBRE'
        WHEN pp.numero = 10 THEN 'OCTUBRE'
        WHEN pp.numero = 11 THEN 'NOVIEMBRE'
        WHEN pp.numero = 12 THEN 'DICIEMBRE'
        ELSE 'NO DEFINIDO'
    END AS mes
FROM
    tblamotizacion a
        JOIN
    tblmes pp ON a.idperiodopago = pp.idmes
     JOIN
    tblestado_cuenta ec ON a.idamortizacion = ec.idamortizacion
    WHERE a.idperiodo = $idperiodo 
    AND a.idalumno = $idalumno  
    AND ec.idamortizacion = $idamortizacion
    AND ec.eliminado = 0"); 
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
}
 
 public function showAllEstadoCuentaTodos($idperiodo='',$idalumno='')
{
          $query =$this->db->query("SELECT 
          ec.idestadocuenta,
    a.idamortizacion, 
    ec.descuento,
    ec.pagado,
    pp.numero as numeromes, 
    a.idperiodo,
    DATE_FORMAT(ec.fechapago,'%d/%m/%Y') as fechapago,
    CASE
        WHEN pp.numero = 1 THEN 'ENERO'
        WHEN pp.numero = 2 THEN 'FEBRERO'
        WHEN pp.numero = 3 THEN 'MARZO'
        WHEN pp.numero = 4 THEN 'ABRIL'
        WHEN pp.numero = 5 THEN 'MAYO'
        WHEN pp.numero = 6 THEN 'JUNIO'
        WHEN pp.numero = 7 THEN 'JULIO'
        WHEN pp.numero = 8 THEN 'AGOSTO'
        WHEN pp.numero = 9 THEN 'SEPTIEMBRE'
        WHEN pp.numero = 10 THEN 'OCTUBRE'
        WHEN pp.numero = 11 THEN 'NOVIEMBRE'
        WHEN pp.numero = 12 THEN 'DICIEMBRE'
        ELSE 'NO DEFINIDO'
    END AS mes
FROM
    tblamotizacion a
        JOIN
    tblmes pp ON a.idperiodopago = pp.idmes
     JOIN
    tblestado_cuenta ec ON a.idamortizacion = ec.idamortizacion
    WHERE a.idperiodo = $idperiodo AND a.idalumno = $idalumno
    AND ec.eliminado = 0"); 
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

    public function updateEstadoCuenta($id, $field)
    {
        $this->db->where('idestadocuenta', $id);
        $this->db->update('tblestado_cuenta', $field);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
        
    } 
      public function updatePagoInicio($id, $field)
    {
        $this->db->where('idpago', $id);
        $this->db->update('tblpago_inicio', $field);
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

     public function addAmortizacion($data)
    {
        $this->db->insert('tblamotizacion', $data);
        $insert_id = $this->db->insert_id(); 
        return  $insert_id;
    }


}
