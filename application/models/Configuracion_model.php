<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Configuracion_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function showAllConfiguracion($idplantel, $idnivel = '')
    {
        $this->db->select('c.idconfiguracion,c.diaultimorecargo, c.totalrecargo, dc.calificacion_minima, dc.reprovandas_minima');
        $this->db->from('tblconfiguracion c');
        $this->db->join('tbldetalle_configuracion dc', 'c.idconfiguracion = dc.idconfiguracion');
        $this->db->where('c.idplantel', $idplantel);
        if (isset($idnivel) && !empty($idnivel)) {
            $this->db->where('dc.idnivel', $idnivel);
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function calificacionPorMateriaPS($idalumno, $idhorario, $idprofesormateria, $idplantel)
    {
        $query = $this->db->query("CALL calificacionPorCursoPS ($idalumno, $idhorario,$idprofesormateria,$idplantel)");
        $res = $query->result();
        //add this two line
        $query->next_result();
        $query->free_result();
        //end of new code
        return $res;
    }
    public function showAllPlanteles()
    {
        $this->db->select('p.idplantel,p.clave,p.nombreplantel,ne.idniveleducativo, ne.nombreniveleducativo');
        $this->db->from('tblplantel p');
        $this->db->join('tblniveleducativo ne', 'ne.idniveleducativo = p.idniveleducativo');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function showAllNivelesEducativos()
    {
        $this->db->select('ne.*');
        $this->db->from('tblniveleducativo ne');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function detallePlantel($idplantel)
    {
        $this->db->select('p.idplantel,p.clave, p.nombreplantel,p.mision, p.vision,p.objetivos, p.asociado,p.logoplantel, p.logosegundo, p.direccion,
    p.telefono, p.director');
        $this->db->from('tblplantel  p');
        $this->db->where('p.idplantel', $idplantel);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->first_row();
        } else {
            return false;
        }
    }
    public function detalleConfiguracionPrincpal($idplantel)
    {
        $this->db->select('c.idconfiguracion,p.idplantel,p.clave,p.nombreplantel,c.idniveleducativo, ne.nombreniveleducativo,c.diaultimorecargo,c.totalrecargo');
        $this->db->from('tblplantel p');
        $this->db->join('tblniveleducativo ne', 'ne.idniveleducativo = p.idniveleducativo');
        $this->db->join('tblconfiguracion c', 'c.idplantel = p.idplantel');
        $this->db->where('c.idplantel', $idplantel);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->first_row();
        } else {
            return false;
        }
    }

    public function showAllCalificaciones($idplantel)
    {
        $this->db->select("dc.iddetalle, dc.idconfiguracion, dc.calificacion_minima, dc.reprovandas_minima, dc.idnivel, CASE niv.idniveleducativo 
        WHEN 3 THEN ne.numeroromano
        WHEN 5 THEN ne.numeroromano
        WHEN 1 THEN ne.numeroordinaria
        WHEN 2 THEN ne.numeroordinaria
        WHEN 4 THEN ne.numeroordinaria
        ELSE ''
    END AS nivelgrupo");
        $this->db->from('tbldetalle_configuracion  dc');
        $this->db->join('tblconfiguracion c', 'c.idconfiguracion = dc.idconfiguracion');
        $this->db->join('tblnivelestudio ne', 'dc.idnivel=ne.idnivelestudio');
        $this->db->join('tblplantel p', 'c.idplantel = p.idplantel');
        $this->db->join('tblniveleducativo niv', 'p.idniveleducativo = niv.idniveleducativo');
        $this->db->where('c.idplantel', $idplantel);
        $this->db->order_by('ne.idnivelestudio DESC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function validarUpdateCalificacion($idnivel = '', $idplantel = '', $iddetalle = '')
    {
        $this->db->select('dc.*');
        $this->db->from('tbldetalle_configuracion  dc');
        $this->db->join('tblconfiguracion c', 'c.idconfiguracion = dc.idconfiguracion');
        $this->db->where('dc.idnivel', $idnivel);
        $this->db->where('dc.iddetalle !=', $iddetalle);
        $this->db->where('c.idplantel', $idplantel);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function configuracionPorPlante($idplantel = '')
    {
        $this->db->select('c.*');
        $this->db->from('tblconfiguracion c');
        $this->db->where('c.idplantel', $idplantel);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function validarAddCalificacion($idnivel = '', $idplantel = '', $idconfiguracion = '')
    {
        $this->db->select('dc.*');
        $this->db->from('tbldetalle_configuracion  dc');
        $this->db->join('tblconfiguracion c', 'c.idconfiguracion = dc.idconfiguracion');
        $this->db->where('dc.idnivel', $idnivel);
        $this->db->where('dc.idconfiguracion', $idconfiguracion);
        $this->db->where('c.idplantel', $idplantel);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function updateCalificacion($iddetalle = '', $field)
    {
        $this->db->where('iddetalle ', $iddetalle);
        $this->db->update('tbldetalle_configuracion', $field);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function updatePlantel($idplantel = '', $field)
    {
        $this->db->where('idplantel ', $idplantel);
        $this->db->update('tblplantel', $field);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function updateConfiguracion($idconfiguracion = '', $field)
    {
        $this->db->where('idconfiguracion ', $idconfiguracion);
        $this->db->update('tblconfiguracion', $field);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function eliminarCalificacion($iddetalle = '')
    {
        $this->db->where('iddetalle ', $iddetalle);
        $this->db->delete('tbldetalle_configuracion');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function addDetalleConfiguracion($data)
    {
        $this->db->insert('tbldetalle_configuracion', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    public function addConfiguracion($data)
    {
        $this->db->insert('tblconfiguracion', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    public function __destruct()
    {
        $this->db->close();
    }
}
