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
        $this->load->library('permission');
        $this->load->library('session');
	}
 
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
  public function estadoCuenta()
  {
  	# code...
  	$idalumno = $this->input->get('idalumno');
  	$idperiodo = $this->input->get('idperiodo');
    //$idalumno = 1;
    //$idperiodo = 11;
  	$estadocuentap = array();
    $i = 0;
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
                        $estadocuentap[$i]['idperiodo'] = $value2->idperiodo;
                        $estadocuentap[$i]['mes'] = $value2->mes;
                        $estadocuentap[$i]['year']     = $value2->yearp;
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
                        $estadocuentap[$i]['idperiodo'] = $value->idperiodo;
                        $estadocuentap[$i]['mes'] = $value->mes;
                        $estadocuentap[$i]['year']     = $value->yearp;
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

  $vali = $this->estadocuenta->showAllEstadoCuentaTodos($idperiodo,$idalumno);
  if($vali != false){
  	  foreach ($vali as $value2) {
  			            $estadocuentap[$i]                = array(); 
                        $estadocuentap[$i]['idamortizacion'] = $value2->idamortizacion;
                        $estadocuentap[$i]['idperiodo'] = $value2->idperiodo;
                        $estadocuentap[$i]['mes'] = $value2->mes;
                        $estadocuentap[$i]['year']     = $value2->yearp;
                        $estadocuentap[$i]['descuento']     = $value2->descuento;
                        $estadocuentap[$i]['numeromes']   = $value2->numeromes;
                        $estadocuentap[$i]['pagado']       = $value2->pagado; 
                        $estadocuentap[$i]['fecha']       = $value2->fechapago; 
                         $i++;
  }
}
}


 function compare_lastname($a, $b)
    {
        return strnatcmp($a['numeromes'], $b['numeromes']);
    }
    usort($estadocuentap, 'compare_lastname');
    //var_dump($estadocuenta);
    echo json_encode($estadocuentap);


 
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
                'idformapago' => form_error('idformapago')
            );
        } else {
 
            $idformapago =  trim($this->input->post('idformapago')); 
            $autorizacion =  trim($this->input->post('autorizacion'));
            $idperiodo =  trim($this->input->post('idperiodobuscado'));
            $idalumno =  trim($this->input->post('idalumno')); 
            $descuento =  trim($this->input->post('descuento')); 
            if($idformapago == 1){ 
              //EFECTIVO FORMA PAGO 
                $data_estadocuenta = array( 
                  'idperiodo'=>$idperiodo,
                  'idalumno'=>$idalumno,
                  'idformapago'=>$idformapago,
                  'descuento'=>$descuento,
                  'autorizacion'=>'',
                  'fechapago'=>date('Y-m-d H:i:s'),
                  'idusuario' => $this->session->user_id,
                  'fecharegistro' => date('Y-m-d H:i:s')
                );

                $idestadocuenta = $this->estadocuenta->addPagoInicio($data_estadocuenta); 
 
        } 
        elseif ($idformapago == 2 && !empty($autorizacion)) {
            //TARJETA
                $data_estadocuenta = array(
                  'idamortizacion'=>$idamortizacion,
                  'idperiodo'=>$idperiodo,
                  'idalumno'=>$idalumno,
                  'descuento'=>$descuento,
                  'autorizacion'=>$autorizacion,
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
        
        }
         
      if(isset($result) && !empty($result)){
         echo json_encode($result);
        }
   }
}
