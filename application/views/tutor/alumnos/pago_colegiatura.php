<div class="right_col" role="main">

        <div class=""> 

          <div class="row">
            <div class="col-md-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2><strong>PAGOS</strong></h2>
                  
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
 
    <div class="row">
                    <?php if(isset($numeroautorizacion) && !empty($numeroautorizacion)){ ?>
                       <div class="alert alert-success alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                        </button>
                        <strong> <i class="fa fa-check-circle"></i> Cargo con Exito!</strong> Número de Autorización: <?php echo $numeroautorizacion; ?> 
                      </div>
                    <?php } ?>
                    <?php if(isset($error) && !empty($error)){ ?>
                       <div class="alert alert-danger alert-dismissible fade in" role="alert">
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                      </button>
                      <strong> <i class="fa fa-exclamation-circle" aria-hidden="true"></i> Error!</strong> <?php echo $error; ?>.
                    </div>
                    <?php } ?>
                      <div class="col-xs-7">
                        <p class="lead">Forma de pago:</p>
                        <div class="" role="tabpanel" data-example-id="togglable-tabs">
                            <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                            <li role="presentation" <?php if(isset($formapago)) { if($formapago == 1){ echo 'class="active"';} } ?> ><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true"><i class="fa fa-credit-card"></i> <strong>PAGO CON TARJETA</strong></a>
                            </li>
                            <li role="presentation" <?php if(isset($formapago)) { if($formapago == 0){ echo 'class="active"';} } ?>><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false"> <i class="fa fa-money"></i> <strong>PAGO EN EFECTIVO</strong></a>
                            </li> 
                            </ul>
                            <div id="myTabContent" class="tab-content">
                            <div role="tabpanel" <?php if(isset($formapago)){ if($formapago == 1){ echo 'class="tab-pane fade active in"';}else{echo 'class="tab-pane fade"';}} ?>  id="tab_content1" aria-labelledby="home-tab">
                                    <img align="right" style="padding-right: 5px" src="<?php echo base_url(); ?>/assets/images/visa.png" alt="Visa">
                                    <img align="right" style="padding-right: 5px" src="<?php echo base_url(); ?>/assets/images/mastercard.png" alt="Mastercard">
                                    <img align="right" style="padding-right: 5px" src="<?php echo base_url(); ?>/assets/images/american-express.png" alt="Americ" >   
                                      <form id="payment-form2" method="POST" action="<?php echo site_url('Tutores/pagotarjetac');?>">  
                                          <input type="hidden" name="token_id" id="token_id">
                                    <div class="row">
                                            <div class="col-md-12 col-sm-12 col-xs-12 ">
                                                <label for=""> <i class="fa fa-user"></i> DATOS DEL TITULAR</label>
                                            </div>
                                    </div>

                                     <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12 ">
                                        
                                        <div class="form-group">
                                            <label><font color="red">*</font> Titular de la Tarjeta</label>
                                            <input type="text" class="form-control" name="nombretitular" required=""  autocomplete="off" data-openpay-card="holder_name"> 
                                              
                                        </div>
                                    </div>  
                                        </div>
                                    <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12 ">
                                        <div class="form-group">
                                            <label><font color="red">*</font> Número de Tarjeta</label>
                                            <input type="text" class="form-control" name="numerotarjeta"  required="" autocomplete="off" data-openpay-card="card_number"> 
                                                
                                        </div>
                                    </div>
                                </div>
                                
                  
                                    <div class="row">
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label><span class="hidden-xs"><font color="red">*</font> Vigencia</span> </label>
                                    <div class="form-inline">
                                        <select class="form-control" style="width:45%" id="tarjetames" name="mes" required="required" data-openpay-card="expiration_month">
                                            <option value="">MM</option>
                                            <option value="01">01</option>
                                            <option value="02">02</option>
                                            <option value="03">03</option>
                                            <option value="04">04</option>
                                            <option value="05">05</option>
                                            <option value="06">06</option>
                                            <option value="07">07</option>
                                            <option value="08">08</option>
                                            <option value="09">09</option>
                                            <option value="10">10</option>
                                            <option value="11">11</option>
                                            <option value="12">12</option>
                                        </select>
                                        <span style="width:10%; text-align: center"> / </span>
                                        <select class="form-control" style="width:45%" id="tarjetayear" name="year" required="required"  data-openpay-card="expiration_year">
                                            <option value="">YY</option> 
                                            <option value="20">2020</option>
                                            <option value="21">2021</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label data-toggle="tooltip" title=""
                                        data-original-title="3 digitos al reverso de la tarjeta.">CVV <i
                                            class="fa fa-question-circle"></i></label>
                                    <input type="password" class="form-control" name="codigo" required="required" autocomplete="off" data-openpay-card="cvv2" id="codigo">
                                </div> <!-- form-group.// -->
                            </div>
                        </div> <!-- row.// -->
                          <div class="row">
                                            <div class="col-md-12 col-sm-12 col-xs-12 ">
                                                <label for=""> <i class="fa fa-home"></i> DOMICILIO DEL TITULAR</label>
                                            </div>
                            </div>

                            <div class="row">
                                     <div class="col-md-4 col-sm-12 col-xs-12 ">
                                         <div class="form-group">
                                            <label><font color="red">*</font> Codigo Postal</label>
                                            <input type="text" class="form-control" name="cp" id="cp"  autocomplete="off" require />
                                            
                                        </div>
                                     </div>
                                      <div class="col-md-8 col-sm-12 col-xs-12 ">
                                        <div class="form-group">
                                            <label><font color="red">*</font> Calle</label>
                                            <input type="text" class="form-control" name="calletitular" id="calle"  >
                                            
                                        </div>
                                     </div>
                            </div>

                            <div class="row">
                                     <div class="col-md-4 col-sm-12 col-xs-12 ">
                                         <div class="form-group">
                                            <label><font color="red">*</font> Num. Exterior</label>
                                            <input type="text" class="form-control" name="numerocasa" required="" id="numerocasa" >
                                            
                                        </div>
                                     </div>
                                      <div class="col-md-8 col-sm-12 col-xs-12 ">
                                        <div class="form-group">
                                            <label><font color="red">*</font> Colonia</label>
                                           <select class="form-control" name="colonia" id="colonia">
                                               <option value="">--SELECCIONAR--</option>
                                           </select>    
                                        </div>
                                     </div>
                            </div>
                            <div class="row">
                                     <div class="col-md-6 col-sm-12 col-xs-12 ">
                                         <div class="form-group">
                                            <label><font color="red">*</font> Municipio</label>
                                             <select class="form-control" name="municipio" id="municipio" disabled>
                                               <option value="">--SELECCIONAR--</option>
                                           </select>   
                                            
                                        </div>
                                     </div>
                                      <div class="col-md-6 col-sm-12 col-xs-12 ">
                                        <div class="form-group">
                                            <label><font color="red">*</font> Estado</label>
                                           <select class="form-control" name="estado" id="estado" disabled>
                                               <option value="">--SELECCIONAR--</option>
                                           </select>    
                                        </div>
                                     </div>
                            </div>
                              <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12 ">
                                        <label for=""> <i class="fa fa-money"></i> MES A PAGAR</label>
                                      </div>
                                </div>
                                <div class="row">
                                     <div class="col-md-12 col-sm-12 col-xs-12 ">
                                        <div class="form-group">
                                            <label><font color="red">*</font> Mes a pagar</label>
                                           <select class="form-control" name="mespago" id="mespago" required />
                                               <option value="">--SELECCIONAR--</option>
                                               <?php
                                                if(isset($meses) && !empty($meses)){
                                                    foreach($meses as $value){
                                                      echo '<option value="'.$value->idmes.'" >'.$value->nombremes.'</option>';
                                                    }
                                                }
                                               ?>
                                           </select>    
                                        </div>
                                     </div>
                                </div>
                            <input type="hidden" name="descuento" value="<?php echo $descuento ?>"/>
                             <input type="hidden" name="mensaje" value="<?php echo $mensaje ?>"/>
                             <input type="hidden" name="periodo" value="<?php echo $idperiodo ?>"/>
                             <input type="hidden" name="alumno" value="<?php echo $idalumno ?>"/>
                            <input type="hidden" name="nivel" value="<?php echo $idnivel ?>"/>
                            <button class="subscribe btn btn-primary btn-block" type="button" id="pay-button2" > CONFIRMAR PAGO </button>
                        </form>
                            </div>
                            <div role="tabpanel" <?php if(isset($formapago)){ if($formapago == 0){echo 'class="tab-pane fade active in"';}else{echo 'class="tab-pane fade"';} } ?>  id="tab_content2" aria-labelledby="profile-tab">
                               
                            <form method="post" action="<?php echo site_url('Tutores/pagotiendac');?>">  
                            <label>Pasos para pagar en Tiendas</label> 
                            <ul>
                                 <li>1. Seleccionar el mes a pagar.</li>
                                 <li>2. Generar Documento.</li>
                                 <li>3. Descargar Documento.</li>
                                 <li>4. Pagar en Tiendas.</li>
                               </ul>
                                                               <div class="row">
                                     <div class="col-md-12 col-sm-12 col-xs-12 ">
                                        <div class="form-group">
                                            <label><font color="red">*</font> Mes a pagar</label>
                                           <select class="form-control" name="mespago" id="mespago" required />
                                               <option value="">--SELECCIONAR--</option>
                                               <?php
                                                if(isset($meses) && !empty($meses)){
                                                    foreach($meses as $value){
                                                      echo '<option value="'.$value->idmes.'" >'.$value->nombremes.'</option>';
                                                    }
                                                }
                                               ?>
                                           </select>    
                                        </div>
                                     </div>
                                </div>
                               <?php if(isset($opcion) && !empty($opcion) && $opcion == 1){ ?>
                              <div class="row" align="center">
                                  <a href="https://sandbox-dashboard.openpay.mx/paynet-pdf/mds4bdhgvbese0knzu2x/<?php echo $referencia ?>" class="btn btn-app btn-success">
                                 <i class="fa fa-cloud-download" aria-hidden="true"></i> Descargar Documento
                                </a>
                              </div>
                               <?php } ?>
                              <input type="hidden" name="descuento" value="<?php echo $descuento ?>"/>
                               <input type="hidden" name="mensaje" value="<?php echo $mensaje ?>"/>
                               <input type="hidden" name="periodo" value="<?php echo $idperiodo ?>"/>
                               <input type="hidden" name="alumno" value="<?php echo $idalumno ?>"/>
                               <input type="hidden" name="nivel" value="<?php echo $idnivel ?>"/>
                              <?php if(!isset($opcion)){ ?>
                               <button class="subscribe btn btn-primary btn-block" type="submit"  > GENERAR DOCUMENTO </button>
                              <?php } ?>
                              </form>
                            </div> 
                            </div>
                        </div>

                      </div>
                      <!-- /.col -->
                      <div class="col-xs-5">
                        <p class="lead">Detalle</p>
                        <div class="table-responsive">
                          <table class="table">
                            <tbody>
                              <tr>
                                <th style="width:50%">Concepto:</th>
                                <td><label for=""><?php echo $mensaje; ?></label></td>
                              </tr>
                              <tr>
                                <th style="width:50%">Subtotal:</th>
                                <td>$<?php echo number_format($descuento,2); ?></td>
                              </tr>
                               
                              <tr>
                                <th>Total:</th>
                                <td>$<?php echo number_format($descuento,2); ?></td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>
                      <!-- /.col -->
                    </div>

                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- footer content -->
        <footer>
          <div class="copyright-info">
            <p class="pull-right">SICE - Sistema Integral para el Control Escolar</a>
            </p>
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->

      </div>
      <!-- /page content -->
    </div>

  </div>

  <div id="custom_notifications" class="custom-notifications dsp_none">
    <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
    </ul>
    <div class="clearfix"></div>
    <div id="notif-group" class="tabbed_notifications"></div>
  </div> 


