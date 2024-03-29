<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Tutor_model extends CI_Model
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
        $this->db->select("t.idtutor, t.idplantel, t.nombre, t.apellidop, t.apellidom,t.escolaridad, t.ocupacion,
                t.dondetrabaja, DATE_FORMAT(t.fnacimiento,'%d/%m/%Y') as fnacimiento, t.direccion, t.telefono, t.correo, t.password,
                t.rfc, t.factura, t.foto");
        $this->db->from('tbltutor t');
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

    public function showAllTareas($idhorario = '')
    {
        $this->db->select('t.*');
        $this->db->from('tbltarea t');
        if (isset($idhorario) && !empty($idhorario)) {
            $this->db->where('t.idhorario', $idhorario);
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function detalleMes($idmes = '')
    {
        $this->db->select('m.idmes, m.nombremes');
        $this->db->from('tblmes m');
        $this->db->where('m.idmes', $idmes);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function showAllMeses($idalumno, $idperiodo)
    {
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

    public function showAllAlumnos($idplantel = '')
    {
        $this->db->select('a.*');
        $this->db->from('tblalumno a');
        if (isset($idplantel) && !empty($idplantel)) {
            $this->db->where('a.idplantel', $idplantel);
        }
        $this->db->order_by('a.nombre ASC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function validadMatricula($matricula = '')
    {
        $this->db->select('a.*');
        $this->db->from('tblalumno a');
        $this->db->where('a.matricula', $matricula);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function validadMatriculaPorNivel($matricula = '', $idplantel = '')
    {
        $this->db->select('a.*');
        $this->db->from('tblalumno a');
        $this->db->where('a.matricula', $matricula);
        $this->db->where('a.idplantel', $idplantel);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function validadAddTutor($idplantel = '', $nombre = '', $apellidop = '', $apellidom = '')
    {
        $this->db->select('a.*');
        $this->db->from('tbltutor a');
        if (isset($idplantel) && !empty($idplantel)) {
            $this->db->where('a.idplantel', $idplantel);
        }
        $this->db->where('a.nombre', $nombre);
        $this->db->where('a.apellidop', $apellidop);
        $this->db->where('a.apellidom', $apellidom);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function validarAddTutor($correo = '', $idplantel = '')
    {
        $this->db->select('t.*');
        $this->db->from('tbltutor t');
        if (isset($idplantel) && !empty($idplantel) && ($this->session->idplantel != 2)) {
            $this->db->where('t.idplantel', $idplantel);
        }
        $this->db->where('t.correo', $correo);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function validarUpdateTutor($idtutor = '', $correo = '', $idplantel = '')
    {
        $this->db->select('t.*');
        $this->db->from('tbltutor t');
        if (isset($idplantel) && !empty($idplantel) && ($this->session->idplantel != 2)) {
            $this->db->where('t.idplantel', $idplantel);
        }
        $this->db->where('t.correo', $correo);
        $this->db->where('t.idtutor !=', $idtutor);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function showAllTutorAlumnos($idtutor, $idplantel = '')
    {
        $this->db->select('t.idtutoralumno, a.nombre, a.apellidop, a.apellidom');
        $this->db->from('tbltutoralumno t');
        $this->db->join('tblalumno a', 'a.idalumno = t.idalumno');
        $this->db->where('t.idtutor', $idtutor);
        if (isset($idplantel) && !empty($idplantel) && ($this->session->idplantel != 2)) {
            $this->db->where('t.idplantel', $idplantel);
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function detalleColonia($idcolonia = '')
    {
        $this->db->select('c.nombrecolonia,m.nombremunicipio, e.nombreestado');
        $this->db->from('tblcolonia c');
        $this->db->join('tblmunicipio m', 'm.idmunicipio = c.idmunicipio');
        $this->db->join('tblestado e', 'e.idestado = m.idestado');
        $this->db->where('c.idcolonia', $idcolonia);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function precioColegiatura($idtipo = '', $idnivel = '', $idplantel = '')
    {
        $this->db->select('c.descuento');
        $this->db->from('tblcolegiatura c');
        $this->db->where('c.idnivelestudio', $idnivel);
        $this->db->where('c.idtipopagocol', $idtipo);
        if (isset($idplantel) && !empty($idplantel)) {
            $this->db->where('c.idplantel', $idplantel);
        }
        $this->db->where('c.activo', 1);
        $this->db->where('c.eliminado', 0);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function deleteAlumno($id)
    {
        $this->db->where('idtutoralumno', $id);
        $this->db->delete('tbltutoralumno');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function searchTutor($match, $idplantel = '')
    {
        $field = 't.nombre,' . "' '" . ',t.apellidop,' . "' '" . ',t.apellidom';
        $this->db->select("t.idtutor, t.idplantel, t.nombre, t.apellidop, t.apellidom,t.escolaridad, t.ocupacion,
                t.dondetrabaja, DATE_FORMAT(t.fnacimiento,'%d/%m/%Y') as fnacimiento, t.direccion, t.telefono, t.correo, t.password,
                t.rfc, t.factura, t.foto");
        $this->db->from('tbltutor t');
        if (isset($idplantel) && !empty($idplantel)) {
            $this->db->where('t.idplantel', $idplantel);
        }

        $this->db->like('concat(' . $field . ')', $match);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function addTutor($data)
    {
        $this->db->insert('tbltutor', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function addCobroReinscripcion($data)
    {
        $this->db->insert('tblpago_inicio', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function addTutorAlumno($data)
    {
        $this->db->insert('tbltutoralumno', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function addAmortizacion($data)
    {
        $this->db->insert('tblamotizacion', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function addDetallePago($data)
    {
        $this->db->insert('tbldetalle_pago', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function addEstadoCuenta($data)
    {
        $this->db->insert('tblestado_cuenta', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function detalleTutor($idtutor)
    {
        $this->db->select('t.*');
        $this->db->from('tbltutor t');
        $this->db->where('t.idtutor', $idtutor);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->first_row();
        } else {
            return false;
        }
    }

    public function updateTutor($id, $field)
    {
        $this->db->where('idtutor', $id);
        $this->db->update('tbltutor', $field);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteTutor($idtutor)
    {
        # code...
        $this->db->where('idtutor', $idtutor);
        $this->db->delete('tbltutor');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function addDetallePagoInicio($data)
    {
        $this->db->insert('tbldetalle_pago_inicio', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function addDetalleEstadoCuenta($data)
    {
        $this->db->insert('tbldetalle_estadocuenta', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
}
