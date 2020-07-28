<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Configuracion_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

     public function showAllConfiguracion($idplantel,$idnivel = '')
    {
        $this->db->select('c.diaultimorecargo, c.totalrecargo, dc.calificacion_minima, dc.reprovandas_minima');
        $this->db->from('tblconfiguracion c'); 
        $this->db->join('tbldetalle_configuracion dc','c.idconfiguracion = dc.idconfiguracion');
        $this->db->where('c.idplantel',$idplantel);
        if(isset($idnivel) && !empty($idnivel)){
         $this->db->where('dc.idnivel',$idnivel);
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
	public function __destruct()
	{
		$this->db->close();
	}
}
