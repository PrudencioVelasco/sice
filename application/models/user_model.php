 <?php
class User_model extends CI_Model
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
    
  
 
    public function showAll($idrol = '', $idplantel = '')
    {
        $this->db->select('u.id as idusuario,p.idpersonal,r.id as idrol,p.usuario,p.idplantel,p.nombre,p.activo, p.apellidop, p.apellidom,  r.rol as rolnombre');    
        $this->db->from('users u');
        $this->db->join('users_rol ur', 'u.id = ur.id_user');
        $this->db->join('rol r', 'ur.id_rol = r.id'); 
        $this->db->join('tblpersonal p', 'p.idpersonal = u.idusuario');
        $this->db->where('u.idtipousuario', 2); 
        if(!empty($idrol) && $idrol != 14 ){
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
      public function showAllPlantelesUsuario($idplantel)
    {
        $this->db->select('p.idplantel, p.clave, n.nombreniveleducativo');    
        $this->db->from('tblplantel p'); 
        $this->db->join('tblniveleducativo n','p.idniveleducativo = n.idniveleducativo');
        $this->db->where('p.idplantel !=', $idplantel);  
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function showAllPlanteles($idrol = '', $idplantel = '')
    {
        $this->db->select('p.*, n.nombreniveleducativo');    
        $this->db->from('tblplantel p');
        $this->db->join('tblniveleducativo n','p.idniveleducativo = n.idniveleducativo');
         if(!empty($idrol) && $idrol != 14 ){
            $this->db->where('p.idplantel', $idplantel); 
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
        public function showAllRoles($idrol = '')
    {
        $this->db->select('r.*');    
        $this->db->from('rol r'); 
        $this->db->where('r.id IN (13,14,15)'); 
        if(isset($idrol) && !empty($idrol)){
            if($idrol != 14){
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

    public function addPersonal($data)
    {
        $this->db->insert('tblpersonal', $data);
        $insert_id = $this->db->insert_id(); 
        return  $insert_id;
    }
    public function addUser($data)
    {
        $this->db->insert('users', $data);
        $insert_id = $this->db->insert_id(); 
        return  $insert_id;
    }
       public function addUserRol($data)
    {
        return $this->db->insert('users_rol', $data);
    }  
  
    
        public function validarUsuarioRegistrado($usuario )
    {
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
          public function validarUsuarioEliminar($usuario,$idplantel = '')
    {
        # code...
        $this->db->select('p.*');    
        $this->db->from('tblpersonal p');
        $this->db->join('users u','u.idusuario = p.idpersonal');
        $this->db->join('users_rol ur','ur.id_user = u.id');
        $this->db->where('ur.id_rol IN (13,14)'); 
        $this->db->where('u.idtipousuario', 2); 
        $this->db->where('p.usuario', $usuario); 
      if (isset($idplantel) && !empty($idplantel)) {
        $this->db->where('p.idplantel',$idplantel);
        }
        $query = $this->db->get();
        //$query = $this->db->get('permissions');
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function loginAlumno($matricula)
    {
        $this->db->select('u.id,a.password, a.nombre, a.apellidop, a.apellidom, a.idalumno, a.matricula, pla.idplantel');    
        $this->db->from('tblalumno a');
        $this->db->join('users u', 'u.idusuario = a.idalumno');
        $this->db->join('tblplantel pla', 'a.idplantel = pla.idplantel');
        $this->db->where('a.matricula', $matricula); 
         $this->db->where('u.idtipousuario', 3);  
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
             return $query->first_row();
        } else {
            return false;
        }
    }
        public function detallePlantel($idplantel)
    {
        $this->db->select('ne.nombreniveleducativo, pla.nombreplantel, pla.clave');    
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
     public function loginDocente($correo)
    {
        $this->db->select('u.id, p.nombre, p.apellidop, p.apellidom, p.idprofesor, pla.idplantel, p.password');    
        $this->db->from('tblprofesor p');
        $this->db->join('users u', 'u.idusuario = p.idprofesor');
         $this->db->join('tblplantel pla', 'p.idplantel = pla.idplantel');
        $this->db->where('p.correo', $correo); 
         $this->db->where('u.idtipousuario', 1);  
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
             return $query->first_row();
        } else {
            return false;
        }
    }
         public function loginTutor($correo)
    {
        $this->db->select('u.id, t.idtutor, t.nombre, t.apellidop, t.apellidom,pla.idplantel, t.password');    
        $this->db->from('tbltutor t');
        $this->db->join('users u', 'u.idusuario = t.idtutor');
         $this->db->join('tblplantel pla', 't.idplantel = pla.idplantel');
        $this->db->where('t.correo', $correo); 
         $this->db->where('u.idtipousuario', 5);  
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
             return $query->first_row();
        } else {
            return false;
        }
    }
         public function loginAdmin($usuario)
    {
        $this->db->select('ne.nombreniveleducativo,u.id, p.nombre, p.apellidop, p.apellidom, p.idpersonal, pla.nombreplantel, pla.idplantel, ur.id_rol as idrol, p.password');    
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
    public function test()
    {
        # code...
        $this->db->select('tblpermiso.uri');
                      $this->db->from('permissions as tblpermiso');
                      $this->db->join('permission_rol as tblpermisorol', 'tblpermiso.id = tblpermisorol.permission_id');
                      $this->db->join('rol as tblrol', 'tblpermisorol.rol_id = tblrol.id');
                      $this->db->join('users_rol as tblrolusuario', 'tblrol.id= tblrolusuario.id_rol');
                      $this->db->join('users as tblusuario', 'tblrolusuario.id_user= tblusuario.id');
                      $this->db->where('tblusuario.id', 45);
                       $query = $this->db->get();
        if ($query->num_rows() > 0) {
             return $query->first_row();
        } else {
            return false;
        }

    }
  

 public function updatePersonal($id, $field)
    {
        $this->db->where('idpersonal', $id);
        $this->db->update('tblpersonal', $field);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
        
    }
     public function updateRol($id, $field)
    {
        $this->db->where('id_user', $id);
        $this->db->update('users_rol', $field);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
        
    }

    public function searchUser($match,$idrol = '',$idplantel = '') {
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
        if(!empty($idrol) && $idrol != 14 ){
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
  

}
?> 