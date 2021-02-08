<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class WebHook_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function __destruct() {
        $this->db->close();
    }
    public function alumnos($idperiodo)
    {
        $this->db->select('ag.*');
        $this->db->from('tblalumno_grupo ag');
        $this->db->where('ag.idperiodo',$idperiodo);
        //$this->db->where('ag.idgrupo',$idgrupo);
        $this->db->where('ag.activo',1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function addAlumnoGrupo($data)
    {
        $this->db->insert('tblalumno_grupo', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function updateAlumnoGrupo($id, $field)
    {
        $this->db->where('idalumnogrupo', $id);
        $this->db->update('tblalumno_grupo', $field);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

}
