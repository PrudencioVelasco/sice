<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        if (!isset($_SESSION['user_id'])) {
            $this->session->set_flashdata('flash_data', 'You don\'t have access! ss');
            return redirect('welcome');
        }
        $this->load->helper('url');
        $this->load->model('data_model');
        $this->load->model('user_model', 'user'); 
        $this->load->library('permission');
        $this->load->library('session');

    }
    public function index()
    {
        Permission::grant(uri_string());
        $this->load->view('admin/header');
        $this->load->view('admin/usuario/index');
        $this->load->view('admin/footer');
    }

 
 
    public function showAll()
    {
       // Permission::grant(uri_string());
        $idplantel = $this->session->idplantel;
        $idrol = $this->session->idrol;
        $query = $this->user->showAll($idrol,$idplantel);
        if ($query) {
            $result['users'] = $this->user->showAll($idrol,$idplantel);
        }
       if(isset($result) && !empty($result)){
         echo json_encode($result);
        }
    }

    public function showAllPlanteles()
    {
         $idplantel = $this->session->idplantel;
        $idrol = $this->session->idrol;
       // Permission::grant(uri_string());
        $query = $this->user->showAllPlanteles($idrol,$idplantel);
         
         if(isset($query) && !empty($query)){
         echo json_encode($query);
        }
    }
        public function showAllRoles()
    { 
        $query = $this->user->showAllRoles();
         
        if(isset($query) && !empty($query)){
         echo json_encode($query);
        }
    }



    public function addUser()
    {
     //     Permission::grant(uri_string());
        $config = array(
            array(
                'field' => 'usuario',
                'label' => 'Usuario',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),
            array(
                'field' => 'nombre',
                'label' => 'Nombre',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),
              array(
                'field' => 'apellidop',
                'label' => 'Nombre',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),
            array(
                'field' => 'password1',
                'label' => 'Password',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),
            array(
                'field' => 'password2',
                'label' => 'Password 2',
                'rules' => 'trim|required|matches[password1]',
                'errors' => array(
                    'required' => 'Campo obligatorio.',
                    'matches' => 'Las Contrasenas no conciden.'
                )
            ),
            array(
                'field' => 'rol',
                'label' => 'Rol',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),array(
                'field' => 'idplantel',
                'label' => 'idplantel',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            )
        );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            $result['error'] = true;
            $result['msg']   = array(
                'usuario' => form_error('usuario'),
                'nombre' => form_error('nombre'),
                'apellidop' => form_error('apellidop'), 
                'password1' => form_error('password1'),
                'password2' => form_error('password2'),
                'rol' => form_error('rol'),
                'idplantel' => form_error('idplantel')
            );

        } else {
            $resuldovalidacion = $this->user->validarUsuarioRegistrado($this->input->post('usuario'));

            if (!empty($resuldovalidacion)) {
                $result['error'] = true;
                    $result['msg']   = array(
                        'smserror' => "El nombre del usuario ya se encuentra registrado."
                    );
            }else{
                $password_encrypted = password_hash(trim($this->input->post('password1')), PASSWORD_BCRYPT);
            $data     = array(
                'idplantel' => $this->input->post('idplantel'),
                'nombre' => $this->input->post('nombre'),
                'apellidop' => $this->input->post('apellidop'),
                'apellidom' => $this->input->post('apellidom'),
                'usuario' => $this->input->post('usuario'),
                'password' => $password_encrypted,
                'activo' => 1,
                'idusuario' => $this->session->user_id,
                'fecharegistro' => date('Y-m-d H:i:s')

            );
            $idrol=$this->input->post('rol');

            $idpersonal =$this->user->addPersonal($data);

             $datausuario     = array(
                'idusuario' => $idpersonal,
                'idtipousuario' => 2,
                 'idusuario' => $this->session->user_id,
                'fecharegistro' => date('Y-m-d H:i:s')

            );
             $idusuario = $this->user->addUser($datausuario);

            $datauserrol     = array(
                'id_rol' => $idrol,
                'id_user' => $idusuario
            );
            $this->user->addUserRol($datauserrol);
        }

        }
       if(isset($result) && !empty($result)){
         echo json_encode($result);
        }
    }

    public function updateUser()
    {
            $config = array( 
            array(
                'field' => 'nombre',
                'label' => 'Nombre',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),
              array(
                'field' => 'apellidop',
                'label' => 'Nombre',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ), 
            array(
                'field' => 'idrol',
                'label' => 'Rol',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),array(
                'field' => 'idplantel',
                'label' => 'idplantel',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            )
        );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            $result['error'] = true;
            $result['msg']   = array(
                'nombre' => form_error('nombre'),
                 'apellidop' => form_error('apellidop'),
                'idplantel' => form_error('idplantel'),
                'idrol' => form_error('idrol')
            );

        } else {
            $idpersonal   = $this->input->post('idpersonal');
            $idusuario   = $this->input->post('idusuario');
            $data = array(
                'nombre' => strtoupper($this->input->post('nombre')),
                'apellidop' => strtoupper($this->input->post('apellidop')),
                'apellidom' => strtoupper($this->input->post('apellidom')),
                'idplantel' => $this->input->post('idplantel'),
                'activo' => $this->input->post('activo'),
                'idusuario' => $this->session->user_id,
                'fecharegistro' => date('Y-m-d H:i:s')
            );
            if ($this->user->updatePersonal($idpersonal, $data)) {
                $result['error']   = false;
                $result['success'] = 'User updated successfully';
            }


              $datarol = array(
                'id_rol' => $this->input->post('idrol')
            );
            if ($this->user->updateRol($idusuario, $datarol)) {
                $result['error']   = false;
                $result['success'] = 'User updated successfully';
            }


        }
      if(isset($result) && !empty($result)){
         echo json_encode($result);
        }
    }
      public function passwordupdateUser()
    {
         //Permission::grant(uri_string());
        $config = array(
            array(
                'field' => 'password1',
                'label' => 'password1',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
            )),
            array(
                'field' => 'password2',
                'label' => 'password2',
                'rules' => 'trim|required|matches[password1]',
                'errors' => array(
                    'required' => 'Campo obligatorio.',
                    'matches' => 'Las Contrasenas no conciden.'
                )
            )
        );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            $result['error'] = true;
            $result['msg']   = array(
                'password1' => form_error('password1'),
                'password2' => form_error('password2')
            );

        } else {
            $idpersonal   = $this->input->post('idpersonal');
            $password = $this->input->post('password1');
             $password_encrypted = password_hash($password, PASSWORD_BCRYPT); 
            $data = array(
                'password' => $password_encrypted
            );
            if ($this->user->updatePersonal($idpersonal, $data)) {
                $result['error']   = false;
                //$result['success'] = 'User updated successfully';
           }

        }
       if(isset($result) && !empty($result)){
         echo json_encode($result);
        }
    }
    public function deleteUser()
    {
    //Permission::grant(uri_string());
        $id = $this->input->post('id');
        if ($this->user->deleteUser($id)) {
            $msg['error']   = false;
            $msg['success'] = 'User deleted successfully';
        } else {
            $msg['error'] = true;
        }
        echo json_encode($msg);

    }
    public function searchUser()
    {
        //Permission::grant(uri_string());
        $idplantel = $this->session->idplantel;
        $idrol = $this->session->idrol;
        $value = $this->input->post('text');
        $query = $this->user->searchUser($value,$idrol,$idplantel);
        if ($query) {
            $result['users'] = $query;
        }

       if(isset($result) && !empty($result)){
         echo json_encode($result);
        }

    }
    public function administrar()
    {
           Permission::grant(uri_string());
        $this->load->view('header');
        $this->load->view('usuario/administrar');
        $this->load->view('footer');
    }


}
?>
