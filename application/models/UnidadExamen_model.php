<?php

defined('BASEPATH') or exit('No direct script access allowed');

class UnidadExamen_model extends CI_Model
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

    public function showAll($idplantel = '')
    {
        $this->db->select("t.idunidad,t.numero, t.tipo, t.nombreunidad,t.idplantel, DATE_FORMAT(t.fechainicio,'%d/%m/%Y' ) AS fechainicioshow, DATE_FORMAT(t.fechafin,'%d/%m/%Y' ) AS fechafinshow,t.fechainicio, t.fechafin , p.nombreplantel");
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

    public function showAllMeses()
    {
        $this->db->select('m.idmes, m.nombremes');
        $this->db->from('tblmes m');
        $this->db->order_by('m.enumeracion ASC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function mesesUnidadPorPlantel($idplantel = '')
    {
        $this->db->select("u.idunidad,um.idunidadmes,m.idmes,m.nombremes, um.fechainicio, um.fechafin, DATE_FORMAT(um.fechainicio,'%d/%m/%Y' ) AS fechainicioshow, DATE_FORMAT(um.fechafin,'%d/%m/%Y' ) AS fechafinshow");
        $this->db->from('tblunidad u');
        $this->db->join('tblunidad_mes um', 'um.idunidad = u.idunidad');
        $this->db->join('tblmes m', 'm.idmes = um.idmes');
        $this->db->where('u.idplantel', $idplantel);
        $this->db->where('um.activo', 1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function showAllMesesUnidad($idunidad = '')
    {
        $this->db->select("u.idunidad,um.idunidadmes,m.idmes,m.nombremes, um.fechainicio, um.fechafin, DATE_FORMAT(um.fechainicio,'%d/%m/%Y' ) AS fechainicioshow, DATE_FORMAT(um.fechafin,'%d/%m/%Y' ) AS fechafinshow");
        $this->db->from('tblunidad u');
        $this->db->join('tblunidad_mes um', 'um.idunidad = u.idunidad');
        $this->db->join('tblmes m', 'm.idmes = um.idmes');
        $this->db->where('um.idunidad', $idunidad);
        $this->db->where('um.activo', 1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function showAllOportunidades($idplantel = '')
    {
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

    public function ultimoRegistro($idplantel = '')
    {
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

    public function ultimoRegistroOportunidades($idplantel = '')
    {
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
    public function validarMesUnidad($idunidad = '', $idmes = '')
    {
        $this->db->select('um.*');
        $this->db->from('tblunidad_mes um');
        $this->db->where('um.idmes', $idmes);
        $this->db->where('um.idunidad', $idunidad);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function validarUpdateMesUnidad($idunidadmes = '', $idmes = '', $idplantel = '')
    {
        $unidadmes = array($idunidadmes);
        $this->db->select('um.*');
        $this->db->from('tblunidad_mes um');
        $this->db->join('tblunidad u', 'u.idunidad = um.idunidad');
        $this->db->join('tblplantel p', 'p.idplantel = u.idplantel');
        $this->db->where('um.idmes', $idmes);
        $this->db->where('u.idplantel', $idplantel);
        $this->db->where_not_in('um.idunidadmes', $unidadmes);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function searchUnidadExamen($match)
    {
        $field = array(
            't.numero',
            't.nombreunidad',
            'p.nombreplantel'
        );
        $this->db->select("t.idunidad,t.numero,t.tipo, t.nombreunidad,t.idplantel, DATE_FORMAT(t.fechainicio,'%d/%m/%Y' ) AS fechainicioshow, DATE_FORMAT(t.fechafin,'%d/%m/%Y' ) AS fechafinshow,t.fechainicio, t.fechafin , p.nombreplantel");
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

    public function searchOportunidades($match)
    {
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

    public function addUnidadExamen($data)
    {
        $this->db->insert('tblunidad', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    public function addMesUnidad($data)
    {
        $this->db->insert('tblunidad_mes', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function addOportunidad($data)
    {
        $this->db->insert('tbloportunidad_examen', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function detalleUnidadExamen($idunidad)
    {
        $this->db->select('t.*');
        $this->db->from('tblunidad t');
        $this->db->where('t.idunidad', $idunidad);
        $query = $this->db->get();

        return $query->first_row();
    }

    public function updateUnidadExamen($id, $field)
    {
        $this->db->where('idunidad', $id);
        $this->db->update('tblunidad', $field);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function updateOportunidad($id, $field)
    {
        $this->db->where('idoportunidadexamen', $id);
        $this->db->update('tbloportunidad_examen', $field);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function updateUnidadMes($id, $field)
    {
        $this->db->where('idunidadmes', $id);
        $this->db->update('tblunidad_mes', $field);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteUnidadExamen($idunidad)
    {
        # code...
        $this->db->where('idunidad', $idunidad);
        $this->db->delete('tblunidad');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function deleteUnidadMes($idunidadmes)
    {
        # code...
        $this->db->where('idunidadmes', $idunidadmes);
        $this->db->delete('tblunidad_mes');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteOportunidad($idunidad)
    {
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
