<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mensaje_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function __destruct() {
        $this->db->close();
    }

 
        public function showAllMensaje($idhorariodetalle = '') {
        $this->db->select('m.*');
        $this->db->from('tblmensaje m'); 
        if(isset($idhorariodetalle) && !empty($idhorariodetalle)){
        $this->db->where('m.idhorariodetalle',$idhorariodetalle);
        }
        $this->db->where('m.eliminado',0);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    } 
    public function showAllMensajeAlumno($idhorario = '') {
        $this->db->select("m.mensaje, DATE_FORMAT(m.fecharegistro,'%d/%m/%Y') as fecha");
        $this->db->from('tblmensaje m'); 
        if(isset($idhorario) && !empty($idhorario)){
        $this->db->where('m.idhorario',$idhorario);
        } 
        $this->db->where('m.eliminado',0);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    } 
          public function addMensaje($data)
    {
        $this->db->insert('tblmensaje', $data);
        $insert_id = $this->db->insert_id(); 
        return  $insert_id;
    }

        public function updateMensaje($id, $field)
    {
        $this->db->where('idmensaje', $id);
        $this->db->update('tblmensaje', $field);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
      

    }

}
