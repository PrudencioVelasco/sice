  <!-- page content -->
  <div class="right_col" role="main">

<div class=""> 

  <div class="row">
    <div class="col-md-12">
      <div class="x_panel">
        <div class="x_title">
          <h2><strong><i class="fa fa-tasks"></i> CALIFICACIÓN DEL ALUMNO(A)</strong></h2>
          <ul class="nav navbar-right panel_toolbox">
<!--             <h3><small>C. del Nivel: </small><strong style="color: green">
             <?php 
                //$calificacion 
         //    if(isset($calificacion) && !empty($calificacion)){
         //     echo  number_format($calificacion,2);
         //   }else{
         //     echo "0.00";
          //  }
               ?>
             </strong></h3>-->
          </ul>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <?php if(isset($idhorario) && !empty($idhorario)){ ?>
          <div class="row">
             <div class="col-md-4 col-sm-12 col-xs-12 " align="center">
               <label>ALUMNO(A): </label><br><label style="color:#000;"><?php echo $datosalumno[0]->nombre.' '.$datosalumno[0]->apellidop.' '.$datosalumno[0]->apellidom ?></label>
             </div>
             <div class="col-md-4 col-sm-12 col-xs-12 " align="center">
                <label>CICLO ESCOLAR: </label><br><label style="color: #000"> <?php echo $datoshorario->mesinicio.' '.$datoshorario->yearinicio.' - '.$datoshorario->mesfin.' '.$datoshorario->yearfin ?></label>
             </div>
             <div class="col-md-4 col-sm-12 col-xs-12 " align="center">
               <label>GRUPO</label><br>
                  <label style="color: #000">
                  <?php 
                    echo $datoshorario->nombrenivel.' '.$datoshorario->nombregrupo.' - '.$datoshorario->nombreturno;
                   ?>
                  </label>
             </div>
              
          </div>  <br>
          <div class="row">
                  <div class="col-md-6 col-sm-12 col-xs-12 " align="left"> 
                  </div>
                  <?php
                  if (isset($mostrar_estatus) && !empty($mostrar_estatus) && $mostrar_estatus == true) {
                      ?>
                      <div class="col-md-6 col-sm-12 col-xs-12 " align="right">
                          <?php
                          if ((isset($oportunidades) && !empty($oportunidades))) {
                              foreach ($oportunidades as $row) {
                                  ?>
                                  <a href="<?php echo site_url('Aalumno/oportunidades/' . $controller->encode($idalumno) . '/' . $controller->encode($idhorario) . '/' . $controller->encode($row->idoportunidadexamen) . '/' . $controller->encode($row->numero)) ?>" class="btn btn-success btn-sm waves-effect"><?php echo $row->nombreoportunidad ?></a>
                                  <?php
                              }
                          }
                          ?>
                      </div>
                      <?php
                  }
                  ?>

              </div>
          <br>
          <div class="row">   
            <?php
              if (isset($tabla) && !empty($tabla)) {
                echo $tabla;
              }
            ?> 
          </div>
<!--          <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12 " align="right">
                <?php
                 //if(isset($calificacion) && !empty($calificacion)){
                   ?>
                     <a target="_blank" href="<?php //echo site_url('Aalumno/imprimirkardex/'.$controller->encode($idhorario).'/'.$controller->encode($idalumno)) ?>" class="btn btn-primary"><i class="fa fa-print"></i> IMPRIMIR KARDEX</a>
                   <?php 
                  //}
                ?>
              
              </div>
          </div>-->
                <?php } else {?>
                     <div class="row">
                      <div class="col-md-12 col-sm-12 col-xs-12 " align="center">
                          <label>Sin calificaciones</label>
                      </div>
                     </div>
                <?php } ?>
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

