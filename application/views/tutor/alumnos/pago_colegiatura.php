  <style>
ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
}
  </style> 
<div class="right_col" role="main">

    <div class=""> 

        <div class="row">
            <div class="col-md-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><strong>PAGOS DE: <?php
                                if (isset($nombre_alumno) && !empty($nombre_alumno)) {
                                    echo $nombre_alumno;
                                }
                                ?></strong></h2>

                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                        <div class="row"> 
                            <div class="col-xs-7">
                                <p class="lead">Forma de pago:</p>
                                <div class="" role="tabpanel" data-example-id="togglable-tabs">
                                    <ul id="myTab" class="nav nav-tabs bar_tabs"  role="tablist">
                                        <li role="presentation" class="active" ><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true"><i class="fa fa-credit-card"></i> <strong>PAGO CON TARJETA</strong></a>
                                        </li>
                                        <li role="presentation" ><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false"> <i class="fa fa-money"></i> <strong>PAGO EN EFECTIVO</strong></a>
                                        </li> 
                                    </ul>
                                    <div id="myTabContent" class="tab-content">
                                        <div role="tabpanel"  class="tab-pane fade active in"  id="tab_content1" aria-labelledby="home-tab">
                                            <img align="right" style="padding-right: 5px" src="<?php echo base_url(); ?>/assets/images/visa.png" alt="Visa">
                                            <img align="right" style="padding-right: 5px" src="<?php echo base_url(); ?>/assets/images/mastercard.png" alt="Mastercard">
                                            <img align="right" style="padding-right: 5px" src="<?php echo base_url(); ?>/assets/images/american-express.png" alt="Americ" >   

                                            <form id="payment-form2" > 
                                                <input type="hidden" name="token_id" id="token_id">
                                                <div class="row">
                                                    <div class="col-md-12 col-sm-12 col-xs-12 ">
                                                        <h4> <i class="fa fa-money" style="color:#49ca1c;"></i> MES A PAGAR</h4>
                                                    </div>
                                                </div> 
                                                <div class="row">
                                                    <div class="col-md-12 col-sm-12 col-xs-12 ">
                                                        <div class="form-group"> 
                                                            <select class="form-control mespago_tc" name="mespago"  required />
                                                            <option value="">--SELECCIONAR MES A PAGAR--</option>
                                                            <?php
                                                            if (isset($meses) && !empty($meses)) {
                                                                foreach ($meses as $value) {
                                                                    echo '<option value="' . $value->idmes . '" >' . $value->nombremes . '</option>';
                                                                }
                                                            }
                                                            ?>
                                                            </select>    
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12 col-sm-12 col-xs-12 ">
                                                        <h4> <i class="fa fa-user" style="color: #5a9def;"></i> DATOS DEL TITULAR</h4>
                                                    </div>
                                                </div> 
                                                <div class="row">
                                                    <div class="col-md-12 col-sm-12 col-xs-12 ">

                                                        <div class="form-group form-float">
                                                            <div class="form-line">
                                                                <label class="form-label"><font color="red">*</font> TITULAR DE LA TARJETA</label>
                                                                <input type="text" class="form-control" id="cnombretitular" name="nombretitular" required=""  autocomplete="off" data-openpay-card="holder_name"> 
                                                            </div>
                                                        </div>
                                                    </div>  
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12 col-sm-12 col-xs-12 ">
                                                        <div class="form-group form-float">
                                                            <div class="form-line">
                                                                <label class="form-label"><font color="red">*</font> NÚMERO DE TARJETA</label>
                                                                <input type="text" class="form-control" name="numerotarjeta" id="cnumerotarjeta"  required="" autocomplete="off" data-openpay-card="card_number"> 
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12 col-sm-12 col-xs-12 ">
                                                        <label><font color="red">*</font> Vigencia de la Tarjeta.</label>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-4 col-sm-12 col-xs-12 ">
                                                        <div class="form-group">
                                                            <div class="form-inline">
                                                                <select class="form-control" id="tarjetames" name="mes" requiredselectpicker="required" data-openpay-card="expiration_month">
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

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-sm-12 col-xs-12 ">
                                                        <div class="form-group">
                                                            <select class="form-control"   id="tarjetayear" name="year" required="required"  data-openpay-card="expiration_year">
                                                                <option value="">YY</option> 
                                                                <option value="20">2020</option>
                                                                <option value="21">2021</option>
                                                            </select>
                                                        </div>
                                                    </div>


                                                    <div class="col-md-4 col-sm-12 col-xs-12 ">
                                                        <div class="form-group">
                                                            <div class="form-group form-float" style="">
                                                                <div class="form-line">
                                                                    <label class="form-label"  data-toggle="tooltip" title=""
                                                                           data-original-title="3 digitos al reverso de la tarjeta.">CVV <i
                                                                            class="fa fa-question-circle"></i></label>
                                                                    <input type="password" class="form-control" name="codigo"  required="required" autocomplete="off" data-openpay-card="cvv2" id="ccodigo">
                                                                </div>
                                                            </div> <!-- form-group.// -->
                                                        </div>
                                                    </div> <!-- row.// -->
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12 col-sm-12 col-xs-12 ">
                                                        <h4> <i class="fa fa-home" style="color: #e4b90d;"></i> DOMICILIO DEL TITULAR</h4>
                                                    </div>
                                                </div>
                                                <div class="row" id="mensajecp">
                                                    <div class="col-md-12 col-sm-12 col-xs-12 " align='center'>
                                                        <div class="alert alert-warning alert-dismissible" role="alert">
                                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                            El <strong>Codigo Postal</strong> no existe.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4 col-sm-12 col-xs-12 ">
                                                          <div class="form-group form-float">
                                                            <div class="form-line">
                                                                <label class="form-label"><font color="red">*</font> CODIGO POSTAL</label>
                                                                <input type="text" class="form-control" name="cp"  id="cp" maxlength="5" minlength="5"   autocomplete="off" require />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-8 col-sm-12 col-xs-12 ">
                                                         <div class="form-group form-float">
                                                            <div class="form-line">
                                                                <label class="form-label"><font color="red">*</font> NOMBRE DE LA CALLE</label>
                                                                <input type="text" class="form-control" name="calletitular" id="ccalle"  >
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-4 col-sm-12 col-xs-12 ">
                                                         <div class="form-group form-float">
                                                            <div class="form-line">
                                                                <label class="form-label"><font color="red">*</font> NUM. EXTERIOR</label>
                                                                <input type="text" class="form-control" name="numerocasa" required="" id="cnumerocasa" >
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-8 col-sm-12 col-xs-12 ">
                                                        <div class="form-group"> 
                                                            <select class="form-control  colonia" name="colonia" id="colonia">
                                                                <option value="">--COLONIA--</option>
                                                            </select>    
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 col-sm-12 col-xs-12 ">
                                                        <div class="form-group"> 
                                                            <select class="form-control" name="municipio" id="municipio" disabled>
                                                                <option value="">--MUNICIPIO--</option>
                                                            </select>   

                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-sm-12 col-xs-12 ">
                                                        <div class="form-group"> 
                                                            <select class="form-control" name="estado" id="estado" disabled>
                                                                <option value="">--ESTADO--</option>
                                                            </select>    
                                                        </div>
                                                    </div>
                                                </div>

                                                <input type="hidden" name="descuento"   id="descuentorealco" />
                                                <input type="hidden" name="recargo"   id="recargoco" />
                                                <input type="hidden" name="mensaje" value="<?php echo $mensaje ?>"/>
                                                <input type="hidden" name="periodo" id="periodo_co" value="<?php echo $idperiodo ?>"/>
                                                <input type="hidden" name="alumno" id="alumno_c" value="<?php echo $idalumno ?>"/>
                                                <input type="hidden" name="nivel" value="<?php echo $idnivel ?>"/> 
                                                <button class="subscribe btn btn-primary btn-block waves-effect" type="button" id="pay-button2" > CONFIRMAR PAGO </button>
                                            </form>
                                        </div>
                                        <div role="tabpanel" class="tab-pane fade"  id="tab_content2" aria-labelledby="profile-tab">

                                            <form id="frmefectivoc">  
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
                                                            <select class="form-control mespago_ec" name="mespago" id="mespago_efectivo" required />
                                                            <option value="">--SELECCIONAR--</option>
                                                            <?php
                                                            if (isset($meses) && !empty($meses)) {
                                                                foreach ($meses as $value) {
                                                                    echo '<option value="' . $value->idmes . '" >' . $value->nombremes . '</option>';
                                                                }
                                                            }
                                                            ?>
                                                            </select>    
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row" align="center" id="pdfpagoc">
                                                    <a target="_blank" id="idurlc" href="" class="btn btn-app btn-success">
                                                        <i class="fa fa-cloud-download" aria-hidden="true"></i> Descargar Documento
                                                    </a>
                                                </div>

                                                <input type="hidden" name="descuento" id="descuentorealco_efe" />
                                                <input type="hidden" name="recargo"  id="recargoco_efe" />
                                                <input type="hidden" name="mensaje" value="<?php echo $mensaje ?>"/>
                                                <input type="hidden" name="periodo" value="<?php echo $idperiodo ?>"/>
                                                <input type="hidden" name="alumno" value="<?php echo $idalumno ?>"/>
                                                <input type="hidden" name="nivel" value="<?php echo $idnivel ?>"/>

                                                <button class="subscribe btn btn-primary btn-block waves-effect" id="btngenerarpdfc" type="button"  > GENERAR DOCUMENTO </button>

                                            </form>
                                        </div> 
                                    </div>
                                </div>

                            </div>

                            <!-- /.col -->
                            <div class="col-xs-5">
                                <p class="lead">Detalles de pago</p>
                                <div class="resultado">

                                </div>
                                <div class="table-responsive" id="tbldefault">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <th style="width:50%">CONCEPTO:</th>
                                                <td><label for=""><?php echo $mensaje; ?></label></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">*SELECCIONE EL MES A PAGAR PARA MOSTRAR LOS PRECIOS.</td>

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




            <div class="modal fade" id="loadMe" tabindex="-1" role="dialog" aria-labelledby="loadMeLabel">
                <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content">
                        <div class="modal-body text-center">
                            <div class="loader">
                                <img src="<?php echo base_url() . '/assets/loader/pagos.gif ' ?>" alt="">                             
                            </div>
                            <div clas="loader-txt">
                                <h4>Procesando pago...</h4>
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
<script data-my_var_1="<?php echo base_url() ?>" data-my_var_2="<?php echo $alumno; ?>" data-my_var_3="<?php echo $periodo; ?>" src="<?php echo base_url(); ?>/assets/js/validar/mes_a_pagar.js" type="text/javascript"></script>
 <script data-my_var_1="<?php echo base_url() ?>" src="<?php echo base_url(); ?>/assets/js/validar/pago_tarjeta_colegiatura.js"></script>
<script data-my_var_1="<?php echo base_url() ?>" src="<?php echo base_url(); ?>/assets/js/validar/pago_efectivo_colegiatura.js"></script>