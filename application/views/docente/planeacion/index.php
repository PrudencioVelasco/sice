  <!-- page content -->
      <div class="right_col" role="main">

        <div class=""> 

          <div class="row">
            <div class="col-md-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2><strong>ADMINISTRAR PLANEACIONES</strong></h2>
                  
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">

                  <div class="row"> 
                  
                   <table class="table table-striped  ">
                       <thead class="bg-teal"> 
                      <tr>
                        <th>#</th>
                        <th>Periodo</th>
                        <th>Grupo</th>
                        <th>Materia</th>
                        <th></th> 
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        if(isset($datos) && !empty($datos)){
                          $i=1;
                          foreach ($datos as  $value) {
                            ?>
                             <tr>
                              <th scope="row"><?php echo $i++; ?></th>
                              <th scope="row"><?php echo $value->mesinicio." ".$value->yearinicio." - ".$value->mesfin." ".$value->yearfin; ?></th>
                              <td scope="row"><?php echo $value->nombrenivel." ".$value->nombregrupo ?></td>
                              <td><?php echo $value->nombreclase; ?></td>
                              <td align="right">
                                <div class="btn-group" role="group">
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-info waves-effect dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class='fa fa-plus'></i>  Planeación
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu">
                                          <?php 
                                          if(isset($unidades) && !empty($unidades)){
                                          foreach($unidades as $row){
                                           ?>
                                            <li><a href="<?php echo site_url('Pprofesor/planear/'.$controller->encode($row->idunidad).'/'.$controller->encode($value->idhorariodetalle)) ?>"><?php echo $row->nombreunidad; ?></a></li> 
                                          <?php } }?>
                                        </ul>
                                    </div>
                                </div> 

                              </td> 
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
  <script data-my_var_1="<?php echo base_url() ?>" src="<?php echo base_url(); ?>/assets/vue/appvue/apptutor.js"></script> 


