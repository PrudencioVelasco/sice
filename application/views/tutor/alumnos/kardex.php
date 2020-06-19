  <!-- page content -->
      <div class="right_col" role="main">

        <div class=""> 

          <div class="row">
            <div class="col-md-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2><strong>ALUMNO(A): <?php echo $detalle_alumno[0]->apellidop." ".$detalle_alumno[0]->apellidom." ".$detalle_alumno[0]->nombre; ?></strong></h2>
                  
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">

                  <div class="row"> 
                  
             <table class="table">
                    <thead>
                      <tr> 
                        <th>Periodo</th>
                        <th>Año</th>
                        <th>Grupo</th> 
                        <th></th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 
                          if(isset($kardex) && !empty($kardex)){
                            foreach($kardex as $row){
                           ?>
                              <tr> 
                                <td>  <?php   echo "<label>".$row->mesinicio." ".$row->yearinicio." - ".$row->mesfin." ".$row->yearfin."</label>";  ?>   </td> 
                                <td> <?php echo $row->nombrenivel;  ?>  </td>
                                 <td> <?php echo $row->nombregrupo;  ?> </td>
                                <td>

                                  <?php
                                  if($row->idestatusnivel == 1){
                                       echo '<label class="text-info">'.$row->nombreestatusnivel.'</label>';
                                  }elseif($row->idestatusnivel == 2){
                                         echo '<label class="text-success">'.$row->nombreestatusnivel.'</label>';
                                  }elseif($row->idestatusnivel == 3){
                                         echo '<label class="text-danger">'.$row->nombreestatusnivel.'</label>';
                                  }elseif($row->idestatusnivel == 4){
                                         echo '<label class="text-warning">'.$row->nombreestatusnivel.'</label>';
                                  }else{
                                    echo '<label>NO DEFINIDO</label>';
                                  }
                                   
                                  ?>
                                  
                                </td>
                                <td align="right">
                                     <div class="btn-group" role="group">
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-primary waves-effect dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                             Opciones
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu"> 
                                            <li><a href="<?php echo site_url('Tutores/historial/'.$controller->encode($row->idhorario).'/'.$controller->encode($idalumno)) ?>"><i class="fa fa-list-alt" aria-hidden="true"></i> Boleta</a></li> 
                                            <li><a href="<?php echo site_url('Tutores/horario2/'.$controller->encode($row->idhorario).'/'.$controller->encode($idalumno)) ?>"><i class="fa fa-clock-o"></i> Horario</a></li> 
                                           <!-- <li><a href="<?php //echo site_url('alumno/asistencia/'.$row->idhorario.'/'.$id) ?>"> <i class="fa fa-check"></i> Asistencia</a></li>  -->
                                           
                                          
                                        </ul>
                                    </div>
                                </div>
 

                                </td>
                             </tr>
                       <?php } } else{ echo "<tr><td colspan='4' align='center'>No existe Kardex del alumno.</td></tr>"; }?>
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


