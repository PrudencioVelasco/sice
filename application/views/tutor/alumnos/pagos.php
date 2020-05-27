  <!-- page content -->
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
                    <?php if(isset($pago_inicio) && empty($pago_inicio)){ ?>
                  <a href="<?php echo site_url('Tutores/pagoi/'.$idalumno.'/'.$idperiodo.'/'.$idnivel.'/1') ?>" class="btn btn-primary"> <i class="fa fa-money"></i> PAGAR REINSCRIPCIÓN</a>
                    <?php } ?>
                  <a href="<?php echo site_url('Tutores/pagoc/'.$idalumno.'/'.$idperiodo.'/'.$idnivel.'/2') ?>" class="btn btn-primary"><i class="fa fa-money"></i> PAGAR COLEGIATURA</a>
                  <hr>
                   <table class="table">
                    <thead>
                      <tr>
                        <th>#</th> 
                        <th>FORMA DE PAGO</th>
                        <th>PAGÓ</th>
                        <th>ESTATUS</th>
                        <th>CONCEPTO</th>
                        <th>DESCUENTO</th> 
                        <th>FECHA</th>
                        <th></th> 
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        if(isset($pago_inicio) && !empty($pago_inicio)){
                          $i=1;
                          foreach ($pago_inicio as  $value) {
                            ?>
                             <tr> 
                                 <td><?php echo $i++; ?></td>
                                 <td><?php echo $value->nombretipopago ?></td>
                                 <td>
                                   <?php
                                    if($value->online == 0){
                                      echo '<label class="label label-default">EN OFICINA</label>';
                                    }else{
                                       echo '<label class="label label-primary">EN LINEA</label>';
                                    }
                                   ?>
                                 </td>
                                 <td>
                                   <?php
                                    if($value->pagado == 1){
                                      echo '<label class="label label-success">PAGADO</label>';
                                    }elseif($value->online == 1 && $value->pagado == 0){
                                       echo '<label class="label label-warning">EN PROCESO</label>';
                                    }
                                    else{
                                       echo '<label class="label label-warning">SIN DEFINIR</label>';
                                    }
                                   ?>
                                 </td>
                                 <td><?php echo $value->concepto ?></td>
                                 <td><strong>$<?php echo $value->descuento ?> </strong></td>
                                 <td><?php echo $value->fecharegistro ?> </td>
                            </tr>
                            <?php
                          }
                        }
                      ?>
                     
                    </tbody>
                  </table>
                    

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


