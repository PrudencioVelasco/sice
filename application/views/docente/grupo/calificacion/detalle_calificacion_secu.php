<!-- page content -->
<div class="right_col" role="main">

    <div class="">

        <div class="row">
            <div class="col-md-12">
                <div class="x_panel">
                    <div class="x_title">
                            
                        <div class="row">
                            <div class="col-md-6 col-sm-12 col-xs-12 " align="left">
                        			<?php 
                        			     if (isset($detalle) && !empty($detalle)) {
                        			         echo '<h5><strong><i class="fa fa-graduation-cap" ></i> '.$detalle[0]->nombre.' '.$detalle[0]->apellidop.' '.$detalle[0]->apellidom.'</strong></h5>';
                        			     }
                        			?>
                            </div>
                              <div class="col-md-6 col-sm-12 col-xs-12 " align="right">
                        			<?php 
                        			     if (isset($detalle) && !empty($detalle)) {
                        			         echo '<h5><strong><i class="fa fa-book" style="color:#4c8cf5;" ></i> '.$detalle[0]->nombreclase.'</strong></h5>';
                        			     }
                        			?>
                            </div>
                        </div>

                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content"> 

                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12 " align="right">
                                <small>*Tiene 3 dias para modificar/eliminar las calificaciones despues de haberla
                                    registrado.</small>
                            </div>
                        </div>
 						 <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12 " align="left">
                              
                              <h4>
                                  <?php
                                  if (isset($detalle) && !empty($detalle)) {
                                       echo $detalle[0]->nombreunidad ;
                                    }
                                  ?>
                              </h4>
                              <div class="responsive">
									<table class="table">
										<tr>
											<td>MES</td>
											<td>CALIFICACIÓN</td>
											<td></td>
										</tr>
                                          	<?php
                                        if (isset($detalle) && ! empty($detalle)) {
                                            foreach ($detalle as $row) { 
                                                    ?>
                                          	         <tr>
            											<td><?php echo $row->nombremes; ?></td>
            											<td><?php echo $row->calificacion; ?></td>
            											<td>
            												 <?php   if ($row->dias <= 3) { ?>
            												 <a  href="#" class="btn btn-default edit_button_new" data-toggle="modal" data-target="#myModal"
				                               					 data-iddetallecalificacion="<?php echo $row->iddetallecalificacion ?>"
				                               					  data-idcalificacion="<?php echo $row->idcalificacion ?>"
				                                				 data-calificacion="<?php echo $row->calificacion ?>" 
				                              		  			 data-alumno="<?php echo $row->apellidop . ' ' .$row->apellidom . ' ' . $row->nombre?>"><i class="fa fa-pencil "  
			                                   					 title="Editar Calificación"></i> Editar</a>
			                                   				<?php } ?>
            											</td>
            										</tr>
            										
                                          	  <?php 
                                            }
                                        }
                                        ?>
                              	 
                              </table>
								</div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title " id="myModalLabel">ALUMNO: <label id="alumno"></label> </h3>
            </div>
            <form method="post" action="" id="frmmodificar">
                <div class="modal-body">

                    <div class="alert alert-danger print-error-msg" style="display:none"></div>
                    <div class="alert alert-success print-success-msg" style="display:none"></div>
                    <div class="form-group"> 
                        <input class="iddetallecalificacion" type="hidden" name="iddetallecalificacion"/>
                          <input class="idcalificacion" type="hidden" name="idcalificacion"/>
                    </div> 
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <div class="form-group">
                                <label><font color="red">*</font> Calificación</label> 
                                <input type="number" style="border-bottom: solid 1px #ccc; border-top: solid 1px #ccc; border-left: solid 1px #ccc; border-right: solid 1px #ccc; padding: 0 5px 0 5px;" class="form-control calificacion"   name="calificacion"> 
                            </div>
                        </div> 
                            
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i>
                        CERRAR</button>
                    <button type="button" id="btnmodificar" class="btn btn-primary"><i class="fa fa-pencil"></i>
                        MODIFICAR</button>
                </div>
            </form>
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
<script type="text/javascript">

</script>
<script data-my_var_1="<?php echo base_url() ?>" src="<?php echo base_url(); ?>/assets/js/validar/detalle_calificacion_secundaria.js"></script>
 