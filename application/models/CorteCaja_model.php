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

    public function showAllPagoInicio($fechainicio = '', $fechafin = '', $estatus = '', $pagoen = '', $idplantel = '') {
        $sql = "SELECT * FROM pagosinicio WHERE eliminado = 0";
        if ((isset($fechainicio) && !empty($fechainicio)) && (isset($fechafin) && !empty($fechafin))) {
            $sql .= ' AND date(fechapago) BETWEEN "' . $fechainicio . '" and "' . $fechafin . '"';
        }
        if (isset($pagoen) && !empty($pagoen)) {
            $sql .= " AND pi.online = $pagoen";
        }
        if (isset($estatus) && !empty($estatus)) {
            $sql .= " AND pi.pagado = $estatus";
        }
        if ($this->session->idrol != 14) {
            $sql .= " AND a.idplantel = $idplantel";
        }
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function showAllPagoColegiaturas($fechainicio = '', $fechafin = '', $estatus = '', $pagoen = '', $idplantel = '') {
        $sql = "SELECT * FROM pagoscolegiaturas WHERE eliminado = 0";
        if ((isset($fechainicio) && !empty($fechainicio)) && (isset($fechafin) && !empty($fechafin))) {
            $sql .= ' AND date(fechapago) BETWEEN "' . $fechainicio . '" and "' . $fechafin . '"';
        }
        if (isset($pagoen) && !empty($pagoen)) {
            $sql .= " AND pi.online = $pagoen";
        }
        if (isset($estatus) && !empty($estatus)) {
            $sql .= " AND pi.pagado = $estatus";
        }
        if ($this->session->idrol != 14) {
            $sql .= " AND a.idplantel = $idplantel";
        }
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

}
