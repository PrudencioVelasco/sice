<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Pago_model extends CI_Model
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

    public function showAllAlumnos($idplantel = '')
    {
        $this->db->select("a.idalumno,a.matricula, a.apellidop, a.apellidom, a.nombre,a.foto,CONCAT(a.matricula, ' - ', a.apellidop, ' ', a.apellidom, ' ', a.nombre) as alumno");
        $this->db->from('tblalumno a');
        if (isset($idplantel) && !empty($idplantel)) {
            $this->db->where('a.idplantel', $idplantel);
        }
        $this->db->order_by('a.apellidop,a.apellidom ASC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function showAllFormaPago()
    {
        $this->db->select("tp.*");
        $this->db->from('tbltipo_pago tp');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function alumnoActivo($idalumno)
    {
        $this->db->select("g.idnivelestudio,a.nombre, a.apellidop, a.apellidom, a.foto, a.matricula");
        $this->db->from('tblalumno a');
        $this->db->join('tblalumno_grupo ag', 'ag.idalumno = a.idalumno');
        $this->db->join('tblgrupo g', 'g.idgrupo = ag.idgrupo');
        $this->db->where('ag.activo', 1);
        $this->db->where('a.idalumno', $idalumno);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->first_row();
        } else {
            return false;
        }
    }
    public function showConceptosSinColegiatura($idnivelestudio, $idplantel)
    {
        $no = array(3);
        $this->db->select("tpc.idtipopagocol,c.idnivelestudio, tpc.concepto, c.descuento");
        $this->db->from('tblcolegiatura c');
        $this->db->join('tbltipopagocol tpc', ' c.idtipopagocol = tpc.idtipopagocol');
        $this->db->where('c.idnivelestudio', $idnivelestudio);
        $this->db->where('c.idplantel', $idplantel);
        $this->db->where_not_in('tpc.idtipopagocol  ', $no);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function showMesesColegiatura()
    {

        $this->db->select("3 as idtipopagocol, CONCAT( 'COLEGIATURA DE ',' ',m.nombremes) AS concepto, m.idmes, m.nombremes");
        $this->db->from('tblmes m');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function descuentoDeColegiatura($idnivelestudio, $idplantel)
    {
        $no = array(3);
        $this->db->select("tpc.idtipopagocol,c.idnivelestudio, tpc.concepto, c.descuento");
        $this->db->from('tblcolegiatura c');
        $this->db->join('tbltipopagocol tpc', ' c.idtipopagocol = tpc.idtipopagocol');
        $this->db->where('c.idnivelestudio', $idnivelestudio);
        $this->db->where('c.idplantel', $idplantel);
        $this->db->where_in('tpc.idtipopagocol  ', $no);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->first_row();
        } else {
            return false;
        }
    }
}
