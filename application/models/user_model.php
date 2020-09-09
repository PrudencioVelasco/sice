<?php

class User_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function __destruct() {
        $this->db->close();
    }

    public function showAll($idrol = '', $idplantel = '') {
        $this->db->select('u.id as idusuario,p.idpersonal,r.id as idrol,p.usuario,p.idplantel,p.nombre,p.activo, p.apellidop, p.apellidom,  r.rol as rolnombre');
        $this->db->from('users u');
        $this->db->join('users_rol ur', 'u.id = ur.id_user');
        $this->db->join('rol r', 'ur.id_rol = r.id');
        $this->db->join('tblpersonal p', 'p.idpersonal = u.idusuario');
        $this->db->where('u.idtipousuario', 2);

        if (!empty($idrol) && $idrol != 14) {
            $this->db->where('p.idplantel', $idplantel);
            $this->db->where('r.id NOT IN (14)');
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function validarPermiso($permiso) {


        $this->db->select('tblpermiso.uri, tblrol.id');
        $this->db->from('permissions as tblpermiso');
        $this->db->join('permission_rol as tblpermisorol', 'tblpermiso.id = tblpermisorol.permission_id');
        $this->db->join('rol as tblrol', 'tblpermisorol.rol_id = tblrol.id');
        $this->db->join('users_rol as tblrolusuario', 'tblrol.id= tblrolusuario.id_rol');
        $this->db->join('users as tblusuario', 'tblrolusuario.id_user= tblusuario.id');
        $this->db->where('tblusuario.id', $this->session->user_id);
        $this->db->where('tblpermiso.uri', $permiso);


        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function showAllPlantelesUsuario($idplantel) {
        $this->db->select('p.idplantel, p.clave, n.nombreniveleducativo');
        $this->db->from('tblplantel p');
        $this->db->join('tblniveleducativo n', 'p.idniveleducativo = n.idniveleducativo');
        $this->db->where('p.idplantel !=', $idplantel);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function showAllPlanteles($idrol = '', $idplantel = '') {
        $sql ="SELECT  p.*, n.nombreniveleducativo,   CASE
        WHEN p.idplantel = 7 THEN 'PRIMARIA'
         WHEN p.idplantel = 8 THEN 'PREESCOLAR'
        ELSE ''
    END AS opcionivel "
                . "FROM tblplantel p INNER JOIN tblniveleducativo n ON p.idniveleducativo = n.idniveleducativo";
       
        //$this->db->select('p.*, n.nombreniveleducativo');
        //$this->db->from('tblplantel p');
        //$this->db->join('tblniveleducativo n', 'p.idniveleducativo = n.idniveleducativo');
        if (!empty($idrol) && $idrol != 14) {
             $sql .= " WHERE p.idplantel = $idplantel";
            //$this->db->where('p.idplantel', $idplantel);
        }
         $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function showAllRoles($idrol = '') {
        $this->db->select('r.*');
        $this->db->from('rol r');
        $this->db->where('r.id NOT IN (10,11,12)');
        if (isset($idrol) && !empty($idrol)) {
            if ($idrol != 14) {
                $this->db->where('r.id NOT IN (14)');
            }
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function addPersonal($data) {
        $this->db->insert('tblpersonal', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function addUser($data) {
        $this->db->insert('users', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function addUserRol($data) {
        return $this->db->insert('users_rol', $data);
    }

    public function validarUsuarioRegistrado($usuario) {
        # code...
        $this->db->select('u.*');
        $this->db->from('tblpersonal u');
        $this->db->where('u.usuario', $usuario);
        $query = $this->db->get();
        //$query = $this->db->get('permissions');
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function validarUsuarioEliminar($usuario, $idplantel = '') {
        # code...
        $this->db->select('p.*');
        $this->db->from('tblpersonal p');
        $this->db->join('users u', 'u.idusuario = p.idpersonal');
        $this->db->join('users_rol ur', 'ur.id_user = u.id');
        $this->db->where('ur.id_rol IN (13,14)');
        $this->db->where('u.idtipousuario', 2);
        $this->db->where('p.usuario', $usuario);
//       if (isset($idplantel) && !empty($idplantel)) {
//        $this->db->where('p.idplantel',$idplantel);
//        }
        $query = $this->db->get();
        //$query = $this->db->get('permissions');
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
        public function listaPlantelDocente($correo) {
        # code...
         $this->db->select('pla.idplantel, pla.clave, ne.idniveleducativo, ne.nombreniveleducativo, p.idprofesor');
        $this->db->from('tblprofesor p');
        $this->db->join('tblplantel pla', 'p.idplantel = pla.idplantel');
        $this->db->join('tblniveleducativo ne', 'ne.idniveleducativo = pla.idniveleducativo');
      
        $this->db->where('p.correo', $correo); 
        $query = $this->db->get(); 
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
            public function listaPlantelTutor($correo) {
        # code...
         $this->db->select('pla.idplantel, pla.clave, ne.idniveleducativo, ne.nombreniveleducativo, t.idtutor');
        $this->db->from('tbltutor t');
        $this->db->join('tblplantel pla', 't.idplantel = pla.idplantel');
        $this->db->join('tblniveleducativo ne', 'ne.idniveleducativo = pla.idniveleducativo'); 
        $this->db->where('t.correo', $correo); 
        $query = $this->db->get(); 
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function loginAlumno($matricula) {
        $this->db->select('u.id,a.password, a.nombre, a.apellidop, a.apellidom, a.idalumno, a.matricula, pla.idplantel, ne.idniveleducativo, ne.nombreniveleducativo');
        $this->db->from('tblalumno a');
        $this->db->join('users u', 'u.idusuario = a.idalumno');
        $this->db->join('tblplantel pla', 'a.idplantel = pla.idplantel');
        $this->db->join('tblniveleducativo ne','ne.idniveleducativo = pla.idniveleducativo');
        $this->db->where('a.matricula', $matricula);
        $this->db->where('u.idtipousuario', 3);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->first_row();
        } else {
            return false;
        }
    }

    public function detallePlantel($idplantel) {
        $this->db->select('ne.nombreniveleducativo, ne.idniveleducativo, pla.nombreplantel, pla.clave');
        $this->db->from('tblniveleducativo ne');
        $this->db->join('tblplantel pla', 'pla.idniveleducativo = ne.idniveleducativo');
        $this->db->where('pla.idplantel', $idplantel);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->first_row();
        } else {
            return false;
        }
    }

    public function loginDocente($correo) {
        $this->db->select('ne.nombreniveleducativo, ne.idniveleducativo, u.id, p.nombre, p.apellidop, p.apellidom, p.idprofesor,p.correo, pla.idplantel, p.password');
        $this->db->from('tblprofesor p');
        $this->db->join('users u', 'u.idusuario = p.idprofesor');
        $this->db->join('tblplantel pla', 'p.idplantel = pla.idplantel');
          $this->db->join('tblniveleducativo ne', 'ne.idniveleducativo = pla.idniveleducativo');
        $this->db->where('p.correo', $correo);
        $this->db->where('u.idtipousuario', 1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
           return $query->result();
        } else {
            return false;
        }
    }

    public function loginTutor($correo) {
        $this->db->select('ne.nombreniveleducativo, ne.idniveleducativo,u.id, t.idtutor, t.nombre, t.apellidop, t.apellidom,pla.idplantel, t.password');
        $this->db->from('tbltutor t');
        $this->db->join('users u', 'u.idusuario = t.idtutor');
        $this->db->join('tblplantel pla', 't.idplantel = pla.idplantel');
         $this->db->join('tblniveleducativo ne', 'ne.idniveleducativo = pla.idniveleducativo');
        $this->db->where('t.correo', $correo);
        $this->db->where('u.idtipousuario', 5);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function loginAdmin($usuario) {
        $this->db->select('ne.nombreniveleducativo, ne.idniveleducativo,u.id, p.nombre, p.apellidop, p.apellidom, p.idpersonal, pla.nombreplantel, pla.idplantel, ur.id_rol as idrol, p.password');
        $this->db->from('tblpersonal p');
        $this->db->join('users u', 'u.idusuario = p.idpersonal');
        $this->db->join('tblplantel pla', 'pla.idplantel = p.idplantel');
        $this->db->join('tblniveleducativo ne', 'ne.idniveleducativo = pla.idniveleducativo');
        $this->db->join('users_rol ur', 'u.id = ur.id_user');
        $this->db->where('p.usuario', $usuario);
        $this->db->where('u.idtipousuario', 2);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->first_row();
        } else {
            return false;
        }
    }

    public function datosAlumno($idalumno) { 
        $this->db->select("a.idalumno, a.foto, a.matricula, a.curp, a.nombre, a.apellidop, a.apellidom, a.sexo,a.correo, a.telefono,
                           DATE_FORMAT(a.fechanacimiento,'%d/%m/%Y') as fechanacimiento ,a.telefonoemergencia, a.domicilio, a.password  ");
        $this->db->from('tblalumno a');
        $this->db->where('a.idalumno', $idalumno);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->first_row();
        } else {
            return false;
        }
    }
    public function datosTutor($idtutor) {
        # code...
        $this->db->select("t.idtutor, t.foto, t.nombre, t.apellidop, t.apellidom, t.escolaridad,t.ocupacion, t.dondetrabaja,
                           DATE_FORMAT(t.fnacimiento,'%d/%m/%Y') as fnacimiento ,t.direccion, t.telefono, t.correo, t.rfc, t.factura");
        $this->db->from('tbltutor t');
        $this->db->where('t.idtutor', $idtutor);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->first_row();
        } else {
            return false;
        }
    }

    public function showAllAlumnosTutor($idtutor = '') {
        $this->db->select('a.*, ts.tiposanguineo');
        $this->db->from('tbltutoralumno ta');
        $this->db->join('tblalumno a', 'a.idalumno = ta.idalumno');
         $this->db->join('tbltiposanguineo ts', 'ts.idtiposanguineo = a.idtiposanguineo');
        $this->db->where('ta.idtutor', $idtutor);
        $this->db->order_by('a.apellidop ASC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function updatePersonal($id, $field) {
        $this->db->where('idpersonal', $id);
        $this->db->update('tblpersonal', $field);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
        public function updateAlumno($id, $field) {
        $this->db->where('idalumno', $id);
        $this->db->update('tblalumno', $field);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function updateRol($id, $field) {
        $this->db->where('id_user', $id);
        $this->db->update('users_rol', $field);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function searchUser($match, $idrol = '', $idplantel = '') {
        $field = array(
            'p.usuario',
            'p.apellidop',
            'p.apellidom',
            'r.rol'
        );
        $this->db->select('u.id as idusuario,p.idpersonal,r.id as idrol,p.usuario,p.idplantel,p.nombre,p.activo, p.apellidop, p.apellidom,  r.rol as rolnombre');
        $this->db->from('users u');
        $this->db->join('users_rol ur', 'u.id = ur.id_user');
        $this->db->join('rol r', 'ur.id_rol = r.id');
        $this->db->join('tblpersonal p', 'p.idpersonal = u.idusuario');
        $this->db->where('u.idtipousuario', 2);
        if (!empty($idrol) && $idrol != 14) {
            $this->db->where('p.idplantel', $idplantel);
            $this->db->where('r.id NOT IN (14)');
        }
        $this->db->like('concat(' . implode(',', $field) . ')', $match);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function searchAlumnosTutor($match, $idtutor = '') {
        $field = array(
            'a.nombre',
            'a.apellidop',
            'a.apellidom',
        );
        $this->db->select('a.*,ts.tiposanguineo');
        $this->db->from('tbltutoralumno ta');
        $this->db->join('tblalumno a', 'a.idalumno = ta.idalumno');
         $this->db->join('tbltiposanguineo ts', 'ts.idtiposanguineo = a.idtiposanguineo');
        $this->db->where('ta.idtutor', $idtutor);
        $this->db->like('concat(' . implode(',', $field) . ')', $match);
        $this->db->order_by('a.apellidop ASC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

}

?> 