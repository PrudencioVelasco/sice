  <!-- page content -->
  <div class="right_col" role="main">

      <div class="">

          <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="x_panel">
                      <div class="x_title">
                          <h2><strong><i class="fa fa-book"></i> CLASES EN ESTE CURSO</strong></h2>

                          <div class="clearfix"></div>
                      </div>
                      <div class="x_content">

                          <div class="row">
                              <div class="col-md-12 col-sm-12 col-xs-12 ">
                                  <table class="table table-striped ">
                                      <thead class="bg-teal">
                                          <tr>
                                              <th>#</th>
                                              <th>MATERIA</th>
                                              <th>MAESTRO</th>
                                              <th align="right"></th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                          <?php
                        if(isset($materias) && !empty($materias)){
                          $i=1;
                          foreach ($materias as  $value) {
                            ?>
                                          <tr>
                                              <th scope="row"><?php echo $i++; ?></th>
                                              <td><strong>
                                                      <?php
                                    if($value->opcion == 0){
                                        echo '<label style="color:red;">R: </label>';
                                    }
                                   ?>
                                                      <?php echo $value->nombreclase; ?></strong></td>
                                              <td scope="row">
                                                  <small><?php echo $value->nombre." ".$value->apellidop." ".$value->apellidom ?></small>
                                              </td>
                                              <td align="right">
                                                  <div class="btn-group" role="group">
                                                      <div class="btn-group" role="group">
                                                          <button type="button"
                                                              class="btn btn-info waves-effect dropdown-toggle"
                                                              data-toggle="dropdown" aria-haspopup="true"
                                                              aria-expanded="false">
                                                              <i class='fa fa-plus'></i> Opción
                                                              <span class="caret"></span>
                                                          </button>
                                                          <ul class="dropdown-menu">
                                                              <!--<li><a
                                                                      href="<?php //echo site_url('Aalumno/calificacion/'.$controller->encode($value->idhorario).'/'.$controller->encode($value->idhorariodetalle).'/'.$controller->encode($value->idmateria)) ?>">
                                                                      <i style="color: #0b94e3;"
                                                                          class="fa fa-file-text-o"></i>
                                                                      Calificación</a>
                                                              </li>-->
                                                              <li><a
                                                                      href="<?php echo site_url('Aalumno/asistencia/'.$controller->encode($value->idhorario).'/'.$controller->encode($value->idhorariodetalle).'/'.$controller->encode($value->idmateria)) ?> ">
                                                                      <i style="color: #31d50b;"
                                                                          class="fa fa-check-circle"></i> Asistencia</a>
                                                              </li>

                                                          </ul>
                                                      </div>
                                                  </div>

                                              </td>
                                          </tr>
                                          <?php
                          }
                        }else{
                          echo '
                            <tr align="center">
                                <td colspan="4">Sin registro de Clases.</td>
                            </tr>
                          ';
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