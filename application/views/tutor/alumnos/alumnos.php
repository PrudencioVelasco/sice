  <!-- page content -->
      <div class="right_col" role="main">

        <div class=""> 

          <div class="row">
            <div class="col-md-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2><strong>ALUMNOS</strong></h2>
                  
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">

                  <div class="row"> 
                  
                   <table class="table">
                    <thead>
                      <tr>
                        <th>#</th> 
                        <th>Nombre</th> 
                        <th></th> 
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        if(isset($alumnos) && !empty($alumnos)){
                          $i=1;
                          foreach ($alumnos as  $value) {
                            ?>
                             <tr>
                              <th scope="row"><?php echo $i++; ?></th> 
                              <td scope="row"><?php echo $value->nombre." ".$value->apellidop." ".$value->apellidom ?></td>
                              <td align="right">
                                 
                                <a  href="<?php echo site_url('Tutores/detalle/'.$controller->encode($value->idalumno)) ?>" class="btn btn-info"> <i class=" fa fa-eye "></i> Ver Kardex</a>
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


