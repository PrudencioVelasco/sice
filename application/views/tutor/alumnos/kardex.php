  <!-- page content -->
  <div class="right_col" role="main">

    <div class="">

      <div class="row">
        <div class="col-md-12">
          <div class="x_panel">
            <div class="x_title">
              <div class="row">
                <div class="col-md-8 col-sm-12 col-xs-12 ">
                  <h4><strong><i class="fa fa-user"></i> ALUMNO(A):
                    <?php echo $detalle_alumno[0]->apellidop . " " . $detalle_alumno[0]->apellidom . " " . $detalle_alumno[0]->nombre; ?></strong>
                  </h4>
                </div>
                <div class="col-md-4 col-sm-12 col-xs-12 " align="right">
                  <?php
                  if (isset($promedio) && !empty($promedio)) {
                    echo '<h4>Promedio: '.$promedio.'</h4>';
                  }
                  ?>
                </div>
              </div>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">

              <div class="row">
                <div class="container">
                  <div class="col-md-12 col-sm-12 col-xs-12 ">
                    <table class="table table-hover table-striped">
                      <thead class="bg-teal">
                        <tr>
                          <th>CICLO ESCOLAR</th>
                          <th>AÑO</th>
                          <th>GRUPO</th>
                          <th></th> 
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        if (isset($kardex) && !empty($kardex)) {
                          foreach ($kardex as $row) {
                            ?>
                            <tr>
                              <td> <?php echo "<label>" . $row->mesinicio . " " . $row->yearinicio . " - " . $row->mesfin . " " . $row->yearfin . "</label>"; ?>
                            </td>
                            <td> <?php echo $row->nombrenivel; ?> </td>
                            <td> <?php echo $row->nombregrupo; ?> </td> 
      <td align="right">
       <?php if($row->idniveleducativo == 4){?>
        <a class="btn btn-default" href="<?php echo site_url('Tutores/calificacionPreescolar/'  . $controller->encode($idalumno) . '/' . $controller->encode($row->idnivelestudio) . '/' . $controller->encode($row->idperiodo)) ?>"
          title="Calificaciones"><i style="color: #0b94e3;"
          class="fa fa-file-text-o"></i>
        Calificaciones</a>
      <?php } else { ?>
        <a class="btn btn-default" href="<?php echo site_url('Tutores/historial/' . $controller->encode($row->idhorario) . '/' . $controller->encode($idalumno). '/' . $controller->encode($row->idperiodo)) ?>" title="Calificaciones"><i
          style="color: #0b94e3;" class="fa fa-file-text-o"></i>
        Calificaciones</a>
      <?php } ?>
        <!--<a class=" btn btn-default"
        href="<?php echo site_url('Tutores/historial/' . $controller->encode($row->idhorario) . '/' . $controller->encode($idalumno). '/' . $controller->encode($row->idperiodo)) ?>"><i
        style="color: #0b94e3;" class="fa fa-file-text-o"></i>
      Calificaciones</a>-->
                                                      <!--<div class="btn-group" role="group">
                                                          <div class="btn-group" role="group">
                                                              <button type="button"
                                                                  class="btn btn-info waves-effect dropdown-toggle"
                                                                  data-toggle="dropdown" aria-haspopup="true"
                                                                  aria-expanded="false">
                                                                  Opciones
                                                                  <span class="caret"></span>
                                                              </button>
                                                              <ul class="dropdown-menu">
                                                                  <li><a
                                                                          href="<?php //echo site_url('Tutores/historial/' . $controller->encode($row->idhorario) . '/' . $controller->encode($idalumno)) ?>"><i
                                                                              class="fa fa-list-alt"
                                                                              aria-hidden="true"></i> Boleta</a></li>
                                                                  <li><a
                                                                          href="<?php //echo site_url('Tutores/horario2/' . $controller->encode($row->idhorario) . '/' . $controller->encode($idalumno)) ?>"><i
                                                                              class="fa fa-clock-o"></i> Horario</a>
                                                                  </li>
                                                                   <li><a href="<?php //echo site_url('alumno/asistencia/'.$row->idhorario.'/'.$id) ?>"> <i class="fa fa-check"></i> Asistencia</a></li> 


                                                              </ul>
                                                          </div>
                                                        </div>-->


                                                      </td>
                                                    </tr>
                                                  <?php }} else {echo "<tr><td colspan='4' align='center'>No existe Kardex del alumno.</td></tr>";}?>
                                                </tbody>
                                              </table>
                                            </div>
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