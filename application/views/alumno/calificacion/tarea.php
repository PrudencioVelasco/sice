  <!-- page content -->
      <div class="right_col" role="main">

        <div class=""> 

          <div class="row">
            <div class="col-md-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2><strong><i class="fa fa-book"></i> TAREAS - <?php if(isset($nombreclase) && !empty($nombreclase)){echo $nombreclase;} ?></strong></h2>
                   <ul class="nav navbar-right panel_toolbox">
                    <li><a class="" style="color: #000">
                       <?php
                                setlocale(LC_ALL, 'es_ES');
                        $date = new Datetime(date("Y-m-d"));
                        $fecha = strftime("%A, %d de %B", $date->getTimestamp());
                        echo "<strong>".$fecha."</strong>";
                        ?>

                    </a>
                    </li>  
                  </ul>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">

                  <div class="row"> 
                      <table class="table">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Materia</th>
                        <th>Tarea</th> 
                        <th>Fecha de entrega</th> 
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        if(isset($tareas) && !empty($tareas)){
                          $i=1;
                          foreach ($tareas as  $value) {
                            ?>
                             <tr>
                              <th scope="row"><?php echo $i++; ?></th>
                              <td><strong><?php echo $value->nombreclase; ?></strong></td>
                              <td><?php echo $value->tarea ?> </td> 
                             <td>
                              <?php
                                setlocale(LC_ALL, 'es_ES');
                        $date = new Datetime($value->fechaentrega);
                        $fecha = strftime("%A, %d de %B", $date->getTimestamp());
                        echo $fecha;
                        ?>
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

