  <!-- page content -->
      <div class="right_col" role="main">

        <div class=""> 

          <div class="row">
            <div class="col-md-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2><strong>HIJOS(AS)</strong></h2> 
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">

                  <div class="row"> 
                    <div class="col-md-12 col-sm-12 col-xs-12 ">
                                  <table class="table ">
                                            <thead >
                                              <th>#</th>
                                              <th>Grupo</th>
                                              <th>Nombre</th>
                                              <th></th>
                                            </thead>
                                            <tbody >
                                              <?php 
                                              if (isset($alumnos) && !empty($alumnos)) {
                                                $numero = 1;
                                                foreach ($alumnos as $value) { ?>
                                                     <tr>
                                                      <td><?php echo $numero++; ?></td>
                                                      <td><?php echo $value->nombrenivel.' '.$value->nombregrupo; ?></td> 
                                                      <td><?php echo $value->nombre.' '.$value->apellidop.' '.$value->apellidom ?></td> 
                                                      <td align="right">
                                                         <div class="btn-group" role="group">
                                                            <div class="btn-group" role="group">
                                                                <button type="button" class="btn btn-primary waves-effect dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    <i class='fa fa-plus'></i>  Opciones
                                                                    <span class="caret"></span>
                                                                </button>
                                                                <ul class="dropdown-menu"> 
                                                                    <!--<li ><a href="<?php //echo site_url('Tutores/materias/'.$value->idalumno) ?>"   title="Eliminar Datos"><i class="fa fa-trash"></i> Materias</a></li>-->
                                                                    <li><a href="<?php echo site_url('Tutores/horario/'.$value->idalumno) ?>"  title="Modificar Datos"><i class="fa fa-edit"></i> Horario</a></li>
                                                                    <li><a href="<?php echo site_url('Tutores/boletas/'.$value->idalumno) ?>"  title="Modificar Datos"><i class="fa fa-edit"></i> Examen</a></li>
                                                                    <li><a href="<?php echo site_url('Tutores/asistencias/'.$value->idalumno) ?>"  title="Modificar Datos"><i class="fa fa-check "></i> Asistencia</a></li>
                                                                    <li><a href="<?php echo site_url('Tutores/pagos/'.$value->idalumno.'/'.$value->idnivelestudio.'/'.$value->idperiodo) ?>"    title="Modificar Datos"><i class="fa fa-paypal "></i> Pagos</a></li>  
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
                                            <tfoot> 
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


