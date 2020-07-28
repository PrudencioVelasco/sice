<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class UnidadExamen_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function __destruct() {
        $this->db->close();
    }

    public function showAll($idplantel = '') {
        $this->db->select('t.idunidad,t.numero, t.nombreunidad,t.idplantel, p.nombreplantel');
        $this->db->from('tblunidad t');
        $this->db->join('tblplantel p', 'p.idplantel = t.idplantel');
        if (isset($idplantel) && !empty($idplantel)) {
            $this->db->where('t.idplantel', $idplantel);
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function showAllOportunidades($idplantel = '') {
        $this->db->select('o.idoportunidadexamen,o.numero, o.nombreoportunidad,p.idplantel, p.nombreplantel');
        $this->db->from('tbloportunidad_examen o');
        $this->db->join('tblplantel p', 'p.idplantel = o.idplantel');
        if (isset($idplantel) && !empty($idplantel)) {
            $this->db->where('p.idplantel', $idplantel);
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function ultimoRegistro($idplantel = '') {
        $this->db->select('t.numero');
        $this->db->from('tblunidad t');
        $this->db->join('tblplantel p', 'p.idplantel = t.idplantel');
        if (isset($idplantel) && !empty($idplantel)) {
            $this->db->where('t.idplantel', $idplantel);
        }
        $this->db->order_by('t.numero DESC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function ultimoRegistroOportunidades($idplantel = '') {
        $this->db->select('o.numero');
        $this->db->from('tbloportunidad_examen o');
        $this->db->join('tblplantel p', 'p.idplantel = o.idplantel');
        if (isset($idplantel) && !empty($idplantel)) {
            $this->db->where('p.idplantel', $idplantel);
        }
        $this->db->order_by('o.numero DESC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function searchUnidadExamen($match) {
        $field = array(
            't.numero',
            't.nombreunidad',
            'p.nombreplantel'
        );
        $this->db->select('t.idunidad,t.numero, t.nombreunidad,t.idplantel, p.nombreplantel');
        $this->db->from('tblunidad t');
        $this->db->join('tblplantel p', 'p.idplantel = t.idplantel');
        $this->db->where('p.idplantel', $this->session->idplantel);
        $this->db->like('concat(' . implode(',', $field) . ')', $match);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function searchOportunidades($match) {
        $field = array(
            'o.numero',
            'o.nombreoportunidad',
            'p.nombreplantel'
        );
        $this->db->select('o.idoportunidadexamen,o.numero, o.nombreoportunidad,p.idplantel, p.nombreplantel');
        $this->db->from('tbloportunidad_examen o');
        $this->db->join('tblplantel p', 'p.idplantel = o.idplantel');
        $this->db->where('p.idplantel', $this->session->idplantel);
        $this->db->like('concat(' . implode(',', $field) . ')', $match);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function addUnidadExamen($data) {
        $this->db->insert('tblunidad', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function addOportunidad($data) {
        $this->db->insert('tbloportunidad_examen', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function detalleUnidadExamen($idunidad) {
        $this->db->select('t.*');
        $this->db->from('tblunidad t');
        $this->db->where('t.idunidad', $idunidad);
        $query = $this->db->get();

        return $query->first_row();
    }

    public function updateUnidadExamen($id, $field) {
        $this->db->where('idunidad', $id);
        $this->db->update('tblunidad', $field);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function updateOportunidad($id, $field) {
        $this->db->where('idoportunidadexamen', $id);
        $this->db->update('tbloportunidad_examen', $field);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteUnidadExamen($idunidad) {
        # code...
        $this->db->where('idunidad', $idunidad);
        $this->db->delete('tblunidad');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteOportunidad($idunidad) {
        # code...
        $this->db->where('idoportunidadexamen', $idunidad);
        $this->db->delete('tbloportunidad_examen');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

}
