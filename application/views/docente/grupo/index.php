  <!-- page content -->
      <div class="right_col" role="main">

        <div class=""> 

          <div class="row">
            <div class="col-md-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2><strong>GRUPOS</strong></h2>
                  
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">

                  <div class="row"> 
                  
                   <table class="table">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Periodo</th>
                        <th>Grupo</th>
                        <th>Materia</th>
                        <th>Opción</th> 
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
                              <td>
                                <div class="btn-group" role="group">
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-primary waves-effect dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class='fa fa-list'></i>  Opciones
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu"> 
                                            <li><a href="<?php echo site_url('Pgrupo/examen/'.$value->idhorario.'/'.$value->idhorariodetalle) ?>"> <i class="fa fa-file-o"></i> Examen</a></li> 
                                            <li><a href="<?php echo site_url('Pgrupo/asistencia/'.$value->idhorario.'/'.$value->idhorariodetalle) ?>"> <i class="fa fa-check"></i> Asistencia</a></li> 
                                            <li><a href="<?php echo site_url('Pgrupo/tarea/'.$value->idhorario.'/'.$value->idhorariodetalle) ?>"><i class="fa fa-book"></i> Tarea</a></li> 
                                            <li><a href="<?php echo site_url('Pgrupo/mensaje/'.$value->idhorario.'/'.$value->idhorariodetalle) ?>"> <i class="fa fa-envelope"></i> Mensaje</a></li> 
                                          
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


