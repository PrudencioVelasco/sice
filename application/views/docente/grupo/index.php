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
                  
                   <table  class="table table-striped  ">
                       <thead class="bg-teal"> 
                      <tr>
                        <th>#</th>
                      
                        <th>Grupo</th>
                        <th>Materia</th>
                        <th></th>
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
                             
                              <td scope="row"><?php echo $value->nombrenivel." - ".$value->nombregrupo ?></td>
                              <td><strong><?php echo $value->nombreclase; ?></strong></td>
                              <td><?php
                                if(isset($value->opcion) && !empty($value->opcion) && $value->opcion == 0){
                                  echo ' <span class="label label-danger">RECURSANDO</span>';
                                }
                              ?></td>
                              <td align="right">
                                <div class="btn-group" role="group">
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-info waves-effect dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class='fa fa-list'></i>  Opciones
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu"> 
                                            <li><a href="<?php echo site_url('Pgrupo/examen/'.$controller->encode($value->idhorario).'/'.$controller->encode($value->idhorariodetalle)) ?>"> <i style="color: #0b94e3;" class="fa fa-file-text-o"></i> Examen</a></li> 
                                            <li><a href="<?php echo site_url('Pgrupo/asistencia/'.$controller->encode($value->idhorario).'/'.$controller->encode($value->idhorariodetalle)) ?>"> <i style="color: #31d50b;" class="fa fa-check-circle"></i> Asistencia</a></li> 
                                            <li><a href="<?php echo site_url('Pgrupo/tarea/'.$controller->encode($value->idhorario).'/'.$controller->encode($value->idhorariodetalle)) ?>"><i style="color: #000;" class="fa fa-book"></i> Tarea</a></li> 
                                            <li><a href="<?php echo site_url('Pgrupo/mensaje/'.$controller->encode($value->idhorario).'/'.$controller->encode($value->idhorariodetalle)) ?>"> <i style="color: #dd3115;" class="fa fa-envelope"></i> Mensaje</a></li> 
                                          
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


