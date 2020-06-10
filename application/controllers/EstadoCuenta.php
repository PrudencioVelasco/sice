<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("America/Mexico_City");
class EstadoCuenta extends CI_Controller {
 function __construct() {
        parent::__construct();

        if (!isset($_SESSION['user_id'])) {
            $this->session->set_flashdata('flash_data', 'You don\'t have access! ss');
            return redirect('welcome');
        }
        $this->load->helper('url');
        $this->load->model('data_model'); 
         $this->load->model('EstadoCuenta_model','estadocuenta'); 
         $this->load->model('user_model','usuario'); 
        $this->load->library('permission');
        $this->load->library('session');
        $this->load->helper('numeroatexto_helper');
  }
  
  public function index()
  {
    # code..
    echo generateRandomString();
  }
   /*$cantidad = trim($this->input->post('cantidad'));

        if (empty($cantidad)) {
            echo json_encode(array('leyenda' => 'Debe introducir una cantidad.'));
            
            return;
        }
        
        # verificar si el número no tiene caracteres no númericos, con excepción
        # del punto decimal
        $xcantidad = str_replace('.', '', $cantidad);
        
        if (FALSE === ctype_digit($xcantidad)){
            echo json_encode(array('leyenda' => 'La cantidad introducida no es válida.'));
            
            return;
        }

        # procedemos a covertir la cantidad en letras
        $this->load->helper('numeros');
        $response = array(
            'leyenda' => num_to_letras($cantidad)
            , 'cantidad' => $cantidad
            );
        echo json_encode($response);
    }*/
 
   public function showAllCicloEscolar() { 
        $idplantel = $this->session->idplantel;
         $query = $this->estadocuenta->showAllCicloEscolar($idplantel); 
         if ($query) {
             $result['ciclos'] = $this->estadocuenta->showAllCicloEscolar($idplantel);
         }
         if(isset($result) && !empty($result)){
         echo json_encode($result);
        }
     }
  public function showAllFormasPago() { 
         $query = $this->estadocuenta->showAllFormasPago(); 
         if ($query) {
             $result['formaspago'] = $this->estadocuenta->showAllFormasPago();
         }
        if(isset($result) && !empty($result)){
         echo json_encode($result);
        }
     }
  public function showAllTipoPago() { 
         $query = $this->estadocuenta->showAllTipoPago(); 
         if ($query) {
             $result['tipospago'] = $this->estadocuenta->showAllTipoPago();
         }
        if(isset($result) && !empty($result)){
         echo json_encode($result);
        }
     }
       public function showAllMeses() { 
         $query = $this->estadocuenta->showAllMeses(); 
         if ($query) {
             $result['meses'] = $this->estadocuenta->showAllMeses();
         }
        if(isset($result) && !empty($result)){
         echo json_encode($result);
        }
     }

public function pagosInicio()
{
    $idalumno = $this->input->get('idalumno');
    $idperiodo = $this->input->get('idperiodo');
    //$idalumno = 1;
    //$idperiodo = 1;
    $query = $this->estadocuenta->showAllPagosInicio($idalumno,$idperiodo); 
         if ($query) {
             $result['pagos'] = $this->estadocuenta->showAllPagosInicio($idalumno,$idperiodo);
         }
         //if(isset($result)){
       if(isset($result) && !empty($result)){
         echo json_encode($result);
        }
   
}
public function descuentoPagoInicioInscripcion()
{
   $idalumno = $this->input->get('idalumno');
   $idperiodo = $this->input->get('idperiodo');
   $resultado = $this->estadocuenta->descuentoPagosInicio($idalumno,$idperiodo,1);
    if($resultado){
       $result['pagoinscripcion']=number_format($resultado[0]->beca,2);
    }
     if(isset($result) && !empty($result)){
         echo json_encode($result);
        }
}
public function descuentoPagoInicioReinscripcion()
{
   $idalumno = $this->input->get('idalumno');
   $idperiodo = $this->input->get('idperiodo');
   $resultado = $this->estadocuenta->descuentoPagosInicio($idalumno,$idperiodo,2);
   //var_dump($resultado);
    if($resultado){
       $result['pagoreinscripcion']=number_format($resultado[0]->beca,2);
    }
     if(isset($result) && !empty($result)){
         echo json_encode($result);
        }
}
public function descuentoPagoColegiatura()
{
   $idalumno = $this->input->get('idalumno');
   $idperiodo = $this->input->get('idperiodo');
   $resultado = $this->estadocuenta->descuentoPagosInicio($idalumno,$idperiodo,3);
    if($resultado){
       $result['pagocolegiatura']=number_format($resultado[0]->beca,2);
    }
     if(isset($result) && !empty($result)){
         echo json_encode($result);
        }
}
public function eliminarColegiatura()
{
     $config = array(
             array(
                'field' => 'usuario',
                'label' => 'Forma de Pago',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),
             array(
                'field' => 'password',
                'label' => 'Forma de Pago',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            )
            
        );

        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            $result['error'] = true;
            $result['msg'] = array(
                'usuario' => form_error('usuario'),
                'password' => form_error('password')
            );
        } else {
        $idpago = $this->input->post('idpago');
        $usuario = $this->input->post('usuario');
        $password = $this->input->post('password'); 
        $detalle_usuario =  $this->usuario->validarUsuarioEliminar($usuario);
        if($detalle_usuario){
            if (password_verify($password, $detalle_usuario[0]->password)) {
              
              $data = array(
                'eliminado'=>1
              );
              $this->estadocuenta->updateEstadoCuenta($idpago,$data);

            }else{
              $result['error'] = true;
                $result['msg'] = array(
                            'msgerror' => 'El Usuario o Contraseña no son validos.'
                    );
            }
        } else{
              $result['error'] = true;
              $result['msg'] = array(
                          'msgerror' => 'El Usuario o Contraseña no son validos.'
                  );
              
        }
  }
  if(isset($result) && !empty($result)){
         echo json_encode($result);
        }
}
public function eliminarPrimerCobro()
{
     $config = array(
             array(
                'field' => 'usuario',
                'label' => 'Forma de Pago',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),
             array(
                'field' => 'password',
                'label' => 'Forma de Pago',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            )
            
        );

        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            $result['error'] = true;
            $result['msg'] = array(
                'usuario' => form_error('usuario'),
                'password' => form_error('password')
            );
        } else {
        $idpago = $this->input->post('idpago');
        $usuario = $this->input->post('usuario');
        $password = $this->input->post('password'); 
        $detalle_usuario =  $this->usuario->validarUsuarioEliminar($usuario);
        if($detalle_usuario){
            if (password_verify($password, $detalle_usuario[0]->password)) {
              
              $data = array(
                'eliminado'=>1
              );
              $this->estadocuenta->updatePagoInicio($idpago,$data);

            }else{
              $result['error'] = true;
                $result['msg'] = array(
                            'msgerror' => 'El Usuario o Contraseña no son validos.'
                    );
            }
        } else{
              $result['error'] = true;
              $result['msg'] = array(
                          'msgerror' => 'El Usuario o Contraseña no son validos.'
                  );
              
        }
  }
  if(isset($result) && !empty($result)){
         echo json_encode($result);
        }
}
  public function estadoCuenta()
  {
  	# code...
  	$idalumno = $this->input->get('idalumno');
  	$idperiodo = $this->input->get('idperiodo');
    //$idalumno = 1;
    //$idperiodo = 11;
  	$estadocuentap = array();
    $i = 0;
    /*
  	$tabla_amoritzacion = $this->estadocuenta->showAllTableAmotizacion($idperiodo,$idalumno);
  	//var_dump($tabla_amoritzacion);
  	if($tabla_amoritzacion != false){
  	foreach ($tabla_amoritzacion as $value) {
  		$estadocuenta_veri = $this->estadocuenta->showAllEstadoCuenta($idperiodo,$idalumno,$value->idamortizacion);
  		if($estadocuenta_veri != false){
  			//PAGADO
  			  foreach ($estadocuenta_veri as $value2) {
  			            $estadocuentap[$i]                = array(); 
                        $estadocuentap[$i]['idamortizacion'] = $value2->idamortizacion;
                        $estadocuentap[$i]['idpago'] = $value2->idestadocuenta;
                        $estadocuentap[$i]['idperiodo'] = $value2->idperiodo;
                        $estadocuentap[$i]['mes'] = $value2->mes; 
                        $estadocuentap[$i]['descuento']     = $value2->descuento;
                        $estadocuentap[$i]['numeromes']   = $value2->numeromes;
                        $estadocuentap[$i]['pagado']       = $value2->pagado; 
                        $estadocuentap[$i]['fecha']       = $value2->fechapago; 
                         $i++;
                     }
  		} else{
  				//NO PAGADO
                        $estadocuentap[$i]                = array(); 
                        $estadocuentap[$i]['idamortizacion'] = $value->idamortizacion;
                         $estadocuentap[$i]['idpago'] = 0;
                        $estadocuentap[$i]['idperiodo'] = $value->idperiodo;
                        $estadocuentap[$i]['mes'] = $value->mes; 
                        $estadocuentap[$i]['descuento']     = $value->descuento;
                        $estadocuentap[$i]['numeromes']   = $value->numeromes;
                        $estadocuentap[$i]['descuento']       = $value->descuento; 
                        $estadocuentap[$i]['pagado']       = $value->pagado; 
                         $estadocuentap[$i]['fecha']       = "---";
                         $i++;
  		}
  	}
  }
else{
//PURO ESTADO DE CUENTA
*/
  $vali = $this->estadocuenta->showAllEstadoCuentaTodos($idperiodo,$idalumno);
  if($vali != false){
  	  foreach ($vali as $value2) {
  			            $estadocuentap[$i]                = array(); 
                        $estadocuentap[$i]['idamortizacion'] = $value2->idamortizacion;
                         $estadocuentap[$i]['idpago'] = $value2->idestadocuenta;
                        $estadocuentap[$i]['idperiodo'] = $value2->idperiodo;
                        $estadocuentap[$i]['mes'] = $value2->mes;
                        //$estadocuentap[$i]['year']     = $value2->yearp;
                        $estadocuentap[$i]['descuento']     = $value2->descuento;
                        $estadocuentap[$i]['numeromes']   = $value2->numeromes;
                        $estadocuentap[$i]['pagado']       = $value2->pagado; 
                        $estadocuentap[$i]['fecha']       = $value2->fechapago; 
                         $i++;
  }
}
//}


 function compare_lastname($a, $b)
    {
        return strnatcmp($a['numeromes'], $b['numeromes']);
    }
    usort($estadocuentap, 'compare_lastname');
    //var_dump($estadocuenta);
    echo json_encode($estadocuentap);


 
  }
public function addCobroColegiatura()
{
   $config = array(
             array(
                'field' => 'idformapago',
                'label' => 'Forma de Pago',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),
             array(
                'field' => 'idperiodo',
                'label' => 'Forma de Pago',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),
              array(
                'field' => 'descuento',
                'label' => 'Forma de Pago',
                'rules' => 'trim|required|decimal',
                'errors' => array(
                    'required' => 'Campo obligatorio.',
                    'decimal' =>'Formato decimal.'
                )
            ),
            array(
                'field' => 'idmes',
                'label' => 'Forma de Pago',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),
            
            
        );

        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            $result['error'] = true;
            $result['msg'] = array(
                'idformapago' => form_error('idformapago'),
                'idmes' => form_error('idmes'),
                'descuento' => form_error('descuento'),
                'msgerror' => form_error('idperiodo')
            );
        } else {

            $idformapago =  trim($this->input->post('idformapago')); 
            $autorizacion =  trim($this->input->post('autorizacion'));
            $idperiodo =  trim($this->input->post('idperiodo'));
            $idalumno =  trim($this->input->post('idalumno'));
            $idmes =  trim($this->input->post('idmes')); 
            $abono =  trim($this->input->post('descuento')); 
            $validar = $this->estadocuenta->validarAddColegiatura($idalumno,$idperiodo,$idmes);
             $folio = generateRandomString();
            if($validar == false){
              $detalle_descuento = $this->estadocuenta->descuentoPagosInicio($idalumno,$idperiodo,3);
            if($detalle_descuento){

               $descuento_correcto = $detalle_descuento[0]->descuento - ($detalle_descuento[0]->descuentobeca / 100 * $detalle_descuento[0]->descuento);
              if($abono == $descuento_correcto){
            if($idformapago == 1){

              //1.- OBTENER DATOS DE LA TABLA AMORTIZACION Y PONER COMO PAGADO
              $data_add_amortizacion = array(
                'idalumno'=>$idalumno,
                'idperiodo'=>$idperiodo,
                'idperiodopago'=>$idmes,
                'descuento'=>$abono,
                'pagado'=>1,
                'idusuario' => $this->session->user_id,
                'fecharegistro' => date('Y-m-d H:i:s')
              );
              $idamortizacion = $this->estadocuenta->addAmortizacion($data_add_amortizacion);
               $data_estadocuenta = array(
                  'folio'=> $folio,
                  'idamortizacion'=>$idamortizacion,
                  'idperiodo'=>$idperiodo,
                  'idalumno'=>$idalumno,
                  'idformapago'=>$idformapago,
                  'descuento'=>$abono, 
                  'idopenpay'=>'',
                  'idorden'=>'',
                  'autorizacion'=>'',
                  'online'=>0,
                  'pagado'=>1,
                  'fechapago'=>date('Y-m-d H:i:s'),
                  'eliminado'=>0,
                  'idusuario' => $this->session->user_id,
                  'fecharegistro' => date('Y-m-d H:i:s')
                );

                $idestadocuenta = $this->estadocuenta->addEstadoCuenta($data_estadocuenta);

                $data_detallepago = array(
                  'idestadocuenta'=>$idestadocuenta,
                  'idformapago'=>$idformapago,
                  'descuento'=>$abono,
                  'autorizacion'=>'',
                  'fechapago'=>date('Y-m-d H:i:s'),
                  'idusuario' => $this->session->user_id,
                  'fecharegistro' => date('Y-m-d H:i:s')
                );
                $this->estadocuenta->addDetalleEstadoCuenta($data_detallepago);
              
 
        } 
        elseif ($idformapago == 2 && !empty($autorizacion)) {
            //1.- OBTENER DATOS DE LA TABLA AMORTIZACION Y PONER COMO PAGADO
                 $data_add_amortizacion = array(
                'idalumno'=>$idalumno,
                'idperiodo'=>$idperiodo,
                'idperiodopago'=>$idmes,
                'descuento'=>$abono,
                'pagado'=>1,
                'idusuario' => $this->session->user_id,
                'fecharegistro' => date('Y-m-d H:i:s')
              );
              $idamortizacion = $this->estadocuenta->addAmortizacion($data_add_amortizacion);
                 //Se modifico el estatus de pagado
                $data_estadocuenta = array(
                  'folio'=>$folio,
                  'idamortizacion'=>$idamortizacion,
                  'idperiodo'=>$idperiodo,
                  'idalumno'=>$idalumno,
                  'idformapago'=>$idformapago,
                  'descuento'=>$abono,
                  'idopenpay'=>'',
                  'idorden'=>'',
                  'autorizacion'=>'',
                  'online'=>0,
                  'pagado'=>1,
                  'fechapago'=>date('Y-m-d H:i:s'),
                  'eliminado'=>0,
                  'idusuario' => $this->session->user_id,
                  'fecharegistro' => date('Y-m-d H:i:s')
                );

                $idestadocuenta = $this->estadocuenta->addEstadoCuenta($data_estadocuenta);

                $data_detallepago = array(
                  'idestadocuenta'=>$idestadocuenta,
                  'idformapago'=>$idformapago,
                  'descuento'=>$abono,
                  'autorizacion'=>$autorizacion,
                  'fechapago'=>date('Y-m-d H:i:s'),
                  'idusuario' => $this->session->user_id,
                  'fecharegistro' => date('Y-m-d H:i:s')
                );
                $this->estadocuenta->addDetalleEstadoCuenta($data_detallepago);
               
        }
        else{
             $result['error'] = true;
            $result['msg'] = array(
                'msgerror' => 'Es necesario registrar el Número Autorización.'
            );
           
          } 

            } else{
             $result['error'] = true;
            $result['msg'] = array(
                'msgerror' => 'El pago debe de ser de: '. number_format($descuento_correcto,2)
            );
           
          } 


          }   
        else{
             $result['error'] = true;
            $result['msg'] = array(
                'msgerror' => 'No esta registrado el Pago para el Nivel.'
            );
           
          } 
        } else{
             $result['error'] = true;
            $result['msg'] = array(
                'msgerror' => 'El pago de este mes ya esta abonado.'
            );
           
          } 
        }
         
       if(isset($result) && !empty($result)){
         echo json_encode($result);
        }
}
public function addCobro()
{
 $config = array(
             array(
                'field' => 'idformapago',
                'label' => 'Forma de Pago',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),
            
        );

        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            $result['error'] = true;
            $result['msg'] = array(
                'idformapago' => form_error('idformapago')
            );
        } else {

            $idformapago =  trim($this->input->post('idformapago')); 
            $autorizacion =  trim($this->input->post('autorizacion'));
            $idamortizacion =  trim($this->input->post('idamortizacion'));
            $idalumno =  trim($this->input->post('idalumno')); 
            $abono =  trim($this->input->post('abono')); 
            if($idformapago == 1){

              //1.- OBTENER DATOS DE LA TABLA AMORTIZACION Y PONER COMO PAGADO
              $data_amortizacion = $this->estadocuenta->datosTablaAmortizacion($idamortizacion);
              $idperiodo = $data_amortizacion->idperiodo; 
              $data_update_amortizacion = array(
                'pagado'=>1
              );
              $result_update_amortizacion = $this->estadocuenta->updateTablaAmortizacion($idamortizacion,$data_update_amortizacion);
              if($result_update_amortizacion == true){
                //Se modifico el estatus de pagado
                $data_estadocuenta = array(
                  'idamortizacion'=>$idamortizacion,
                  'idperiodo'=>$idperiodo,
                  'idalumno'=>$idalumno,
                  'descuento'=>$abono,
                  'fechapago'=>date('Y-m-d H:i:s'),
                  'idusuario' => $this->session->user_id,
                  'fecharegistro' => date('Y-m-d H:i:s')
                );

                $idestadocuenta = $this->estadocuenta->addEstadoCuenta($data_estadocuenta);

                $data_detallepago = array(
                  'idestadocuenta'=>$idestadocuenta,
                  'idformapago'=>$idformapago,
                  'descuento'=>$abono,
                  'autorizacion'=>'',
                  'fechapago'=>date('Y-m-d H:i:s'),
                  'idusuario' => $this->session->user_id,
                  'fecharegistro' => date('Y-m-d H:i:s')
                );
                $this->estadocuenta->addDetalleEstadoCuenta($data_detallepago);
              }else{ 
                //No se pudo modificar el estatus de pagado de la tabla amortizacion
                 $result['error'] = true;
                  $result['msg'] = array(
                      'msgerror' => 'Error intente mas tarde.'
                  );
           
              }
 
        } 
        elseif ($idformapago == 2 && !empty($autorizacion)) {
            //1.- OBTENER DATOS DE LA TABLA AMORTIZACION Y PONER COMO PAGADO
              $data_amortizacion = $this->estadocuenta->datosTablaAmortizacion($idamortizacion);
              $idperiodo = $data_amortizacion->idperiodo; 
              $data_update_amortizacion = array(
                'pagado'=>1
              );
              $result_update_amortizacion = $this->estadocuenta->updateTablaAmortizacion($idamortizacion,$data_update_amortizacion);
              if($result_update_amortizacion == true){
                //Se modifico el estatus de pagado
                $data_estadocuenta = array(
                  'idamortizacion'=>$idamortizacion,
                  'idperiodo'=>$idperiodo,
                  'idalumno'=>$idalumno,
                  'descuento'=>$abono,
                  'fechapago'=>date('Y-m-d H:i:s'),
                  'idusuario' => $this->session->user_id,
                  'fecharegistro' => date('Y-m-d H:i:s')
                );

                $idestadocuenta = $this->estadocuenta->addEstadoCuenta($data_estadocuenta);

                $data_detallepago = array(
                  'idestadocuenta'=>$idestadocuenta,
                  'idformapago'=>$idformapago,
                  'descuento'=>$abono,
                  'autorizacion'=>$autorizacion,
                  'fechapago'=>date('Y-m-d H:i:s'),
                  'idusuario' => $this->session->user_id,
                  'fecharegistro' => date('Y-m-d H:i:s')
                );
                $this->estadocuenta->addDetalleEstadoCuenta($data_detallepago);
              }else{ 
                //No se pudo modificar el estatus de pagado de la tabla amortizacion
                 $result['error'] = true;
                  $result['msg'] = array(
                      'msgerror' => 'Error intente mas tarde.'
                  );
           
              }
        }
        else{
             $result['error'] = true;
            $result['msg'] = array(
                'msgerror' => 'Es necesario registrar el Número Autorización.'
            );
           
          } 
        }
         
       if(isset($result) && !empty($result)){
         echo json_encode($result);
        }
}

	 
   public function addCobroInicio()
   {
       $config = array(
             array(
                'field' => 'idperiodobuscado',
                'label' => 'Periodo',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),
            array(
                'field' => 'idtipopagocol',
                'label' => 'Periodo',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),
            array(
                'field' => 'descuento',
                'label' => 'descuento',
                'rules' => 'trim|required|decimal',
                'errors' => array(
                    'required' => 'Campo obligatorio.',
                    'decimal' =>'Formato decimal.'
                )
            ),
             array(
                'field' => 'idformapago',
                'label' => 'Forma de pago',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            )
        );

        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            $result['error'] = true;
            $result['msg'] = array(
                'idperiodobuscado' => form_error('idperiodobuscado'),
                'descuento' => form_error('descuento'), 
                'idformapago' => form_error('idformapago'),
                'idtipopagocol' => form_error('idtipopagocol')
            );
        } else {
 
            $idformapago =  trim($this->input->post('idformapago')); 
            $autorizacion =  trim($this->input->post('autorizacion'));
            $idperiodo =  trim($this->input->post('idperiodobuscado'));
            $idalumno =  trim($this->input->post('idalumno')); 
            $descuento =  trim($this->input->post('descuento')); 
            $idamortizacion =  trim($this->input->post('idamortizacion'));
            $idtipopagocol =  trim($this->input->post('idtipopagocol'));
            $detalle_descuento = $this->estadocuenta->descuentoPagosInicio($idalumno,$idperiodo,$idtipopagocol);
            if($detalle_descuento){
              //$descuento_correcto  = $detalle_descuento[0]->descuento;
              $descuento_correcto = $detalle_descuento[0]->descuento - ($detalle_descuento[0]->descuentobeca / 100 * $detalle_descuento[0]->descuento);
              if($descuento == $descuento_correcto){
            $folio = generateRandomString();
            if($idformapago == 1){ 
              //EFECTIVO FORMA PAGO 
                $data_estadocuenta = array( 
                  'folio'=>$folio,
                  'idperiodo'=>$idperiodo,
                  'idalumno'=>$idalumno,
                  'idformapago'=>$idformapago,
                  'idtipopagocol'=>$idtipopagocol,
                  'descuento'=>$descuento,
                  'autorizacion'=>'',
                  'online'=>0,
                  'pagado'=>1,
                  'fechapago'=>date('Y-m-d H:i:s'),
                  'idusuario' => $this->session->user_id,
                  'fecharegistro' => date('Y-m-d H:i:s')
                );

                $idestadocuenta = $this->estadocuenta->addPagoInicio($data_estadocuenta); 
 
        } 
        elseif ($idformapago == 2 && !empty($autorizacion)) {
            //TARJETA
                $data_estadocuenta = array(
                  'folio'=>$folio,
                  'idperiodo'=>$idperiodo,
                  'idalumno'=>$idalumno,
                  'idformapago'=>$idformapago,
                  'idtipopagocol'=>$idtipopagocol,
                  'descuento'=>$descuento,
                  'autorizacion'=>$autorizacion,
                  'online'=>0,
                  'pagado'=>1,
                  'fechapago'=>date('Y-m-d H:i:s'),
                  'idusuario' => $this->session->user_id,
                  'fecharegistro' => date('Y-m-d H:i:s')
                );

                $idestadocuenta = $this->estadocuenta->addPagoInicio($data_estadocuenta); 
        }
        else{
             $result['error'] = true;
            $result['msg'] = array(
                'msgerror' => 'Es necesario registrar el Número Autorización.'
            );
           
          } 
        } else{
             $result['error'] = true;
            $result['msg'] = array(
                'msgerror' => 'El pago debe de ser de: '. number_format($descuento_correcto,2)
            );
           
          } 
        }   
        else{
             $result['error'] = true;
            $result['msg'] = array(
                'msgerror' => 'No esta registrado el Pago para el Nivel.'
            );
           
          } 
        
        }
         
      if(isset($result) && !empty($result)){
         echo json_encode($result);
        }
   }

 
}
