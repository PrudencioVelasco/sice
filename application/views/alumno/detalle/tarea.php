  <!-- page content -->
  <div class="right_col" role="main">

<div class=""> 

  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2><strong> <i class="fa fa-clock-o"></i> DETALLE DE LA TAREA</strong></h2>
         
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <div class="row">  
             <div class="col-md-6 col-sm-12 col-xs-12 " >
               <h4><label style="color:#000;">*MATERIA/CLASE:</label> <?php echo $tarea[0]->nombreclase; ?>
             </div> 
             <div class="col-md-6 col-sm-12 col-xs-12 " align="right" >
              <h4> <label style="color:#000;">*FECHA DE ENTREGA:</label> <?php echo $tarea[0]->fecha; ?>
             </div> 
          </div>
          <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12 " >
                  <h4><label style="color:#000;">*TAREA:</label></h4>
                  <?php
                    echo $tarea[0]->tarea;
                  ?>
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
<script data-my_var_1="<?php echo base_url() ?>" data-my_var_2="<?php echo $idhorario; ?>" src="<?php echo base_url(); ?>/assets/vue/appvue/apphorariodetalle.js"></script> 
