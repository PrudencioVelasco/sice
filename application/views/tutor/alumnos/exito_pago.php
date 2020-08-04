<style>
    .lineainferior{
        width: 16%;
        border: solid #33eb67 2px;
    } 
</style>
<div class="right_col" role="main">

    <div class="">

        <div class="row">
            <div class="col-md-12">
                <div class="x_panel"> 
                    <div class="x_content"> 
                        <div class="row" align="center">
                            <div class="col-md-12 col-sm-12 col-xs-12 ">
                                <h2><strong>PAGO REALIZADO CON EXITO!!</strong></h2>
                                <div class="clearfix lineainferior"></div>
                            </div> 
                            <div class="col-md-12 col-sm-12 col-xs-12 ">
                                <h5>Número de Autorización</h5>
                                <h3><?= (isset($numero_autorizacion) && !empty($numero_autorizacion))? $numero_autorizacion:000 ?></h3>
                            </div> 
                        </div>
                        <div class="row">
                              <div class="col-md-6 col-sm-12 col-xs-12 " align="right">
                                  <h6>ALUMNO:</h6>
                            </div> 
                            <div class="col-md-6 col-sm-12 col-xs-12 " align="left">
                                  <h6><?= (isset($alumno) && !empty($alumno))?  $alumno:'' ?></h6>
                            </div> 
                        </div>
                          <div class="row">
                              <div class="col-md-6 col-sm-12 col-xs-12 " align="right">
                                  <h6>CONCEPTO DE PAGO:</h6>
                            </div> 
                            <div class="col-md-6 col-sm-12 col-xs-12 " align="left">
                                    <h6><?= (isset($concepto) && !empty($concepto))? $concepto:'' ?></h6>
                            </div> 
                        </div>
                          <div class="row">
                              <div class="col-md-6 col-sm-12 col-xs-12 " align="right">
                                  <h6>TOTAL PAGADO:</h6>
                            </div> 
                            <div class="col-md-6 col-sm-12 col-xs-12 " align="left">
                                <h6>$<?= (isset($total_pagado) && !empty($total_pagado))? number_format($total_pagado,2):'' ?></h6>
                            </div> 
                        </div>
                         <div class="row">
                              <div class="col-md-6 col-sm-12 col-xs-12 " align="right">
                                  <h6>FECHA Y HORA:</h6>
                            </div> 
                            <div class="col-md-6 col-sm-12 col-xs-12 " align="left">
                                   <h6><?= (isset($fecha) && !empty($fecha))? $fecha:'' ?></h6>
                            </div> 
                        </div>
                        <div class="row">
                              <div class="col-md-12 col-sm-12 col-xs-12 " align="center">
                                  <a href="<?php echo base_url().'Tutores/imprimir_recibo/'.$controller->encode($idalumno).'/'.$controller->encode($idestadocuenta).'/'.$controller->encode($tipo); ?>" class="btn btn-default waves-black"> <i class="fa fa-print" ></i> IMPRIMIR RECIBO</a>
                            </div>  
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