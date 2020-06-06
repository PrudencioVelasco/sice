  <!-- page content -->
      <div class="right_col" role="main">

        <div class=""> 

          <div class="row">
            <div class="col-md-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2><strong>MENSAJES PARA EL ALUMNO O PADRE DE FAMILIA</strong></h2>
                  
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">

                  <div class="row"> 
                  
                   <table id="tutor_mensaje" class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th>#</th> 
                        <th>Mensaje</th>
                        <th>Fecha</th> 
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        if(isset($mensajes) && !empty($mensajes)){
                          $i=1;
                          foreach ($mensajes as  $value) {
                            ?>
                             <tr>
                              <th scope="row"><?php echo $i++; ?></th> 
                              <td scope="row">
                                <?php  
                               if(strlen($value->mensaje) > 20){
                                 echo $cadena = substr($value->mensaje,0,50)."..."; ?>
                                   <a href="<?php echo site_url('Tutores/detallemensaje/'.$controller->encode($value->idmensaje)); ?>"> leer mas </a>
                                <?php }else{
                                  echo $value->mensaje;
                                }  
                               
                                ?>
                              </td>
                              <td><strong><?php echo $value->fecha; ?></strong></td> 
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


