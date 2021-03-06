  <!-- page content -->
  <div class="right_col" role="main">

      <div class="">

          <div class="row">
              <div class="col-md-12">
                  <div class="x_panel">
                      <div class="x_title">
                          <div class="row">
                              <div class="col-md-12 col-sm-12 col-xs-12 ">
                                  <h2><strong><i class="fa fa-users"></i> HIJOS(AS)</strong></h2>
                              </div>
                          </div>

                          <div class="clearfix"></div>
                      </div>
                      <div class="x_content">

                          <div class="row">
                              <div class="container">
                                  <table class="table table-hover table-striped">
                                      <thead class="bg-teal">
                                          <tr>
                                              <th>#</th>
                                              <th>ALUMNO</th>
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
                                              <td scope="row">
                                                  <strong><?php echo $value->apellidop." ".$value->apellidom." ".$value->nombre; ?></strong>
                                              </td>
                                              <td align="right">

                                                  <a href="<?php echo site_url('Tutores/detalle/'.$controller->encode($value->idalumno)) ?>"
                                                     class="btn btn-default"> <i class=" fa fa-eye" style="color:#208fee;"></i> Ver detalle</a>
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