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
            $this->db->where('p.idplantel', $idplantel);
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

    public function showAllMeses($idperiodo = '', $idalumno = '') {
        $query = $this->db->query("SELECT  m.*
                                FROM
                                    tblmes m
                                WHERE
                                    m.idmes NOT IN (SELECT 
                                            dp.idmes
                                        FROM 
                                            tblestado_cuenta ec  INNER JOIN
                                            tbldetalle_estadocuenta dp ON ec.idestadocuenta = dp.idestadocuenta
                                            WHERE ec.idalumno = $idalumno AND ec.idperiodo = $idperiodo AND ec.eliminado = 0)");
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function showAllMesesSiguiente($idperiodo = '', $idalumno = '') {
        $query = $this->db->query("SELECT  m.*
                                FROM
                                    tblmes m
                                WHERE
                                    m.idmes NOT IN (SELECT 
                                            dp.idmes
                                        FROM 
                                            tblestado_cuenta ec  INNER JOIN
                                            tbldetalle_estadocuenta dp ON ec.idestadocuenta = dp.idestadocuenta
                                            WHERE ec.idalumno = $idalumno AND ec.idperiodo = $idperiodo AND ec.eliminado = 0 ) ORDER BY m.numero ASC LIMIT 1");
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

    public function validarAddColegiatura($idalumno, $idperiodo, $idmes) {
        $this->db->select('ec.*');
        $this->db->from('tblestado_cuenta ec');
        $this->db->join('tbldetalle_estadocuenta de', 'ec.idestadocuenta = de.idestadocuenta');
        $this->db->where('ec.idalumno', $idalumno);
        $this->db->where('ec.idperiodo', $idperiodo);
        $this->db->where('de.idmes', $idmes);
        $this->db->where('ec.eliminado', 0);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function validarAddReincripcion($idalumno, $idperiodo) {
        $this->db->select('pi.*');
        $this->db->from('tblpago_inicio pi');
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

    public function detalleAlumno($idalumno) {
        $this->db->select(' e.nombreespecialidad, p.clave,  p.nombreplantel,  p.direccion,  p.telefono,  ts.tiposanguineo, p.idniveleducativo');
        $this->db->from('tblalumno t');
        $this->db->join('tblespecialidad e', 'e.idespecialidad = t.idespecialidad');
        $this->db->join('tblplantel p', 'p.idplantel = t.idplantel');
        $this->db->join('tbltiposanguineo ts', 'ts.idtiposanguineo = t.idtiposanguineo');
        $this->db->where('t.idalumno', $idalumno);
        $query = $this->db->get();
        return $query->first_row();
    }

    public function grupoAlumno($idalumno = '', $idperiodo = '') {
        $this->db->select('n.nombrenivel, g.nombregrupo');
        $this->db->from('tblalumno_grupo ag');
        $this->db->join('tblgrupo g', 'g.idgrupo = ag.idgrupo');
        $this->db->join('tblnivelestudio n', 'n.idnivelestudio = g.idnivelestudio');
        $this->db->where('ag.idalumno', $idalumno);
        $this->db->where('ag.idperiodo', $idperiodo);
        $query = $this->db->get();
        return $query->first_row();
    }

    public function detalleAlumnoRecibo($idpago) {
        $this->db->select("e.nombreespecialidad, p.clave, p.logoplantel,  p.nombreplantel,  p.direccion,  p.telefono, p.idniveleducativo,
        ec.folio,    (SELECT     
    (SELECT 
            GROUP_CONCAT(CONCAT_WS(' ', m.nombremes)
                    SEPARATOR ', ')
        )  FROM  tbldetalle_estadocuenta det  
        INNER JOIN
    tblmes m ON m.idmes = det.idmes WHERE det.idestadocuenta = ec.idestadocuenta )AS 
    nombremes,( SELECT
         GROUP_CONCAT(CONCAT_WS(' ', tp.nombretipopago)
                    SEPARATOR ', ') ) AS nombretipopago,ec.idperiodo, t.nombre, t.apellidop, t.apellidom, dp.autorizacion, DATE_FORMAT(dp.fechapago,'%d/%m/%Y') as fechapago, dp.fechapago as fechapagocompleto");
        $this->db->from('tblalumno t');
        $this->db->join('tblespecialidad e', 'e.idespecialidad = t.idespecialidad');
        $this->db->join('tblplantel p', 'p.idplantel = t.idplantel');
        $this->db->join('tblestado_cuenta ec', 'ec.idalumno = t.idalumno');
        $this->db->join('tbldetalle_pago dp', 'dp.idestadocuenta = ec.idestadocuenta');
        $this->db->join('tbltipo_pago tp', 'tp.idtipopago = dp.idformapago');
        $this->db->where('ec.idestadocuenta', $idpago);
        $this->db->select_sum('dp.descuento');
        $this->db->group_by('ec.idestadocuenta');
        $query = $this->db->get();
        return $query->first_row();
    }

    public function detalleAlumnoPrimerRecibo($idpago) {
        $this->db->select("tpc.concepto, e.nombreespecialidad, p.clave, p.logoplantel,  p.nombreplantel,  p.direccion,  p.telefono, p.idniveleducativo,
        pi.folio,( SELECT
         GROUP_CONCAT(CONCAT_WS(' ', tp.nombretipopago)
                    SEPARATOR ', ') ) AS nombretipopago,pi.idperiodo, t.nombre, t.apellidop, t.apellidom,dpi.autorizacion, pi.fechapago as fechapagocompleto, DATE_FORMAT(pi.fechapago,'%d/%m/%Y') as fechapago");
        $this->db->from('tblalumno t');
        $this->db->join('tblespecialidad e', 'e.idespecialidad = t.idespecialidad');
        $this->db->join('tblplantel p', 'p.idplantel = t.idplantel');
        $this->db->join('tblpago_inicio pi', 'pi.idalumno = t.idalumno');
        $this->db->join('tbldetalle_pago_inicio dpi', 'pi.idpago = dpi.idpago');
        $this->db->join('tbltipo_pago tp', 'tp.idtipopago = dpi.idformapago');
        $this->db->join('tbltipopagocol tpc', 'tpc.idtipopagocol = pi.idtipopagocol');
        $this->db->where('pi.idpago', $idpago);
        $this->db->select_sum('dpi.descuento');
        $this->db->group_by('pi.idpago');
        $query = $this->db->get();
        return $query->first_row();
    }

    public function detallePeriodo($idperiodo) {
        $this->db->select('m.numero mesinicio, m2.numero mesfin, m.nombremes as mesiniciol, m2.nombremes as mesfinl, y.nombreyear as yearinicio, y2.nombreyear as yearfin');
        $this->db->from('tblperiodo p');
        $this->db->join('tblmes m', 'p.idmesinicio = m.idmes');
        $this->db->join('tblmes m2', 'p.idmesfin = m2.idmes');
        $this->db->join('tblyear y', 'p.idyearinicio = y.idyear');
        $this->db->join('tblyear y2', 'p.idyearfin = y2.idyear');
        $this->db->where('p.idperiodo', $idperiodo);
        $query = $this->db->get();
        return $query->first_row();
    }

    public function descuentoPagosInicio($idalumno = '', $idperiodo = '', $idtipo = '', $idplantel, $idniveleducativo) {
        $query = $this->db->query("SELECT 
    idniveleducativo,
    descuentobeca,
     descuento,
       COALESCE((descuento - (descuentobeca / 100 * descuento)),0) AS beca
FROM
    (SELECT 
        p.idniveleducativo,
            b.descuento AS descuentobeca,
            COALESCE((SELECT 
                    co.descuento 
                FROM
                    tblcolegiatura co
                WHERE
                    co.idplantel = $idplantel
                        AND co.idtipopagocol = $idtipo
                        AND co.activo = 1
                        AND co.idnivelestudio = $idniveleducativo), 0)
                         AS descuento
    FROM
        tblgrupo g
    JOIN tblalumno_grupo ag ON ag.idgrupo = g.idgrupo
    JOIN tblbeca b ON b.idbeca = ag.idbeca
    JOIN tblalumno a ON a.idalumno = ag.idalumno
    JOIN tblplantel p ON a.idplantel = p.idplantel
    WHERE
        ag.idalumno = $idalumno AND ag.idperiodo = $idperiodo) tbl;");
        //  return $query->result();

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function showAllPagosInicio($idalumno = '', $idperiodo = '') {
        $this->db->select("pi.idpago,( SELECT
         GROUP_CONCAT(CONCAT_WS(' ', tp.nombretipopago)
                    SEPARATOR ', ') ) AS nombretipopago  , DATE_FORMAT(pi.fechapago,'%d/%m/%Y') as fechapago ,tp.idtipopago, pi.pagado");
        $this->db->from('tblpago_inicio pi');
        $this->db->join('tbldetalle_pago_inicio dpi ', ' dpi.idpago = pi.idpago');
        $this->db->join('tbltipo_pago tp ', ' dpi.idformapago = tp.idtipopago');
        $this->db->where('pi.idalumno', $idalumno);
        $this->db->where('pi.idperiodo', $idperiodo);
        $this->db->where('pi.eliminado', 0);
        $this->db->group_by('dpi.idpago');
        $this->db->select_sum('dpi.descuento');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function showAllTableAmotizacion($idperiodo = '', $idalumno = '') {
        $query = $this->db->query("SELECT 
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

    public function showAllMesPeriodo($idperiodo = '', $idalumno = '', $mesinicio = '', $mesfin = '') {
        $query = $this->db->query("SELECT  m.*
                                FROM
                                    tblmes m
                                WHERE
                                    m.idmes NOT IN (SELECT 
                                            ed.idmes
                                        FROM
                                            tbldetalle_estadocuenta ed
                                                INNER JOIN
                                            tblestado_cuenta ec ON ec.idestadocuenta = ed.idestadocuenta 
                                            WHERE ec.idalumno = $idalumno AND ec.idperiodo = $idperiodo AND ec.eliminado = 0)
                                AND (m.numero between $mesinicio AND $mesfin)");
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function showAllSiguienteMesPeriodo($idperiodo = '', $idalumno = '', $mesinicio = '', $mesfin = '') {
        $query = $this->db->query("SELECT  m.*
                                FROM
                                    tblmes m
                                WHERE
                                    m.idmes NOT IN (SELECT 
                                             ed.idmes
                                        FROM
                                            tbldetalle_estadocuenta ed
                                                INNER JOIN
                                            tblestado_cuenta ec ON ec.idestadocuenta = ed.idestadocuenta 
                                            WHERE ec.idalumno = $idalumno AND ec.idperiodo = $idperiodo AND ec.eliminado = 0)
                                AND (m.numero between $mesinicio AND $mesfin) ORDER BY m.numero ASC LIMIT 1");
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function showAllEstadoCuenta($idperiodo = '', $idalumno = '', $idamortizacion = '') {
        $query = $this->db->query("SELECT 
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

    public function showAllEstadoCuentaTodos($idperiodo = '', $idalumno = '') {
        $query = $this->db->query("SELECT 
    ec.idestadocuenta,
    SUM(dp.descuento) AS descuento,
    ec.pagado,
    ec.idperiodo,
    (SELECT 
            GROUP_CONCAT(CONCAT_WS(' ', tp.nombretipopago)
                    SEPARATOR ', ')
        ) AS nombretipopago,
    DATE_FORMAT(ec.fechapago, '%d/%m/%Y') AS fechapago,
    (SELECT     
    (SELECT 
            GROUP_CONCAT(CONCAT_WS(' ', m.nombremes)
                    SEPARATOR ', ')
        )  FROM  tbldetalle_estadocuenta det  
        INNER JOIN
    tblmes m ON m.idmes = det.idmes WHERE det.idestadocuenta = ec.idestadocuenta )AS mes
FROM
    tblestado_cuenta ec
        INNER JOIN
    tbldetalle_pago dp ON ec.idestadocuenta = dp.idestadocuenta
        INNER JOIN
    tbltipo_pago tp ON tp.idtipopago = dp.idformapago 
    WHERE ec.idperiodo = $idperiodo AND ec.idalumno = $idalumno
    AND ec.eliminado = 0
    GROUP BY ec.idestadocuenta");
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function datosTablaAmortizacion($idamortizacion = '') {
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

    public function updateTablaAmortizacion($id, $field) {
        $this->db->where('idamortizacion', $id);
        $this->db->update('tblamotizacion', $field);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function updateEstadoCuenta($id, $field) {
        $this->db->where('idestadocuenta', $id);
        $this->db->update('tblestado_cuenta', $field);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function updatePagoInicio($id, $field) {
        $this->db->where('idpago', $id);
        $this->db->update('tblpago_inicio', $field);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function addEstadoCuenta($data) {
        $this->db->insert('tblestado_cuenta', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function addDetalleEstadoCuenta($data) {
        $this->db->insert('tbldetalle_pago', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function addPagoInicio($data) {
        $this->db->insert('tblpago_inicio', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function addDetallePagoInicio($data) {
        $this->db->insert('tbldetalle_pago_inicio', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function addAmortizacion($data) {
        $this->db->insert('tblamotizacion', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function addEstadoCuentaDetalle($data) {
        $this->db->insert('tbldetalle_estadocuenta', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

}
