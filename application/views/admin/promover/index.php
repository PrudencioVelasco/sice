  <!-- page content -->
      <div class="right_col" role="main">

        <div class=""> 

          <div class="row">
            <div class="col-md-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2><strong>PROMOCIÓN DE ALUMNOS</strong></h2> 
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <div class="container">
                      <div class="row"> 
                          <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <div class="alert alert-success print-success-msg" style="display:none"></div>
                              <div class="alert alert-danger print-error-msg" style="display:none"></div>
                             </div>
                          </div>
                        <div class="row">
                          <form id="frmbuscar">
                                  <div class="col-md-4 col-sm-12 col-xs-12 ">
                                      <div class="form-group">
                                          <label><font color="red">*</font> Grupo/Nivel</label>
                                          <select name="grupo" class="form-control">
                                            <option value="">--Seleccione--</option>
                                            <?php
                                              if(isset($grupos) && !empty($grupos)){
                                                foreach ($grupos as  $value) {
                                                  ?>
                                                  <option value="<?php echo $value->idgrupo ?>"><?php echo $value->nombrenivel.' - '.$value->nombregrupo ?></option>
                                                  <?php
                                                }
                                              }
                                             ?>
                                          </select> 
                                          <small>Grupo que quiere Promover.</small>
                                      </div>
                                  </div> 
                                  <div class="col-md-4 col-sm-12 col-xs-12 ">
                                      <div class="form-group">
                                          <label><font color="red">*</font> Ciclo Escolar</label>
                                           <select name="cicloescolar" class="form-control">
                                             <option value="">--Seleccione--</option>
                                             <?php
                                              if(isset($cicloescolar) && !empty($cicloescolar)){
                                                foreach ($cicloescolar as  $value) {
                                                  ?>
                                                  <option value="<?php echo $value->idperiodo ?>"><?php echo $value->mesinicio.'-'.$value->mesfin.' '.$value->yearfin ?></option>
                                                  <?php
                                                }
                                              }
                                             ?>
                                           </select>
                                           <small>Ciclo Escolar al cual pasaran los grupos.</small>
                                      </div>
                                  </div> 
                                  <div class="col-md-4 col-sm-12 col-xs-12 ">
                                      <div class="form-group">
                                        <button style="margin-top: 24px" type="button" id="btnbuscar" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                      </div>
                                    </div>
                                  </form>
                              </div>

                      </div> 

                      <div class="row">
                        <hr>
                          <div id="tabla"></div>
                      </div>

                  </div> 
                </div>
              </div>
            </div>
          </div>
        </div>


          <div class="modal fade" id="myModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="largeModalLabel">CALIFICACIONES DE: <label id="nombrealumno"></label></h4>
                         </div>
                         <form id="frmplaneacionmodificar" >
                        <div class="modal-body">
                          <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <div class="alert alert-success print-success-msg" style="display:none"></div>
                               <div class="alert alert-danger print-error-msg" style="display:none"></div>
                             </div>
                          </div>
                            <div class="row">
                               <div class="col-md-12 col-sm-12 col-xs-12 ">
                                  <div id="tabla_calificaciones"></div>
                                </div>
                            </div> 

                        </div>
                        <div class="modal-footer"> 
                            <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal"><i class='fa fa-close'></i> CERRAR</button>
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
   $(document).on( "click", '.edit_button',function(e) { 
        var idalumno = $(this).data('idalumno');
        var idhorario = $(this).data('idhorario');  
        var alumno = $(this).data('alumno'); 

        $("#nombrealumno").text(alumno);  
        //$('#myModal').modal('show'); 
         var data = 'idalumno='+idalumno+'&idhorario='+idhorario;
         $.ajax({
          type: "POST",
          url: "<?php echo site_url('Promover/calificaciones');?>",
          data: data,
          success: function(data) {
            var val = $.parseJSON(data);
              $('#tabla_calificaciones').html(val.tabla);
            $('#myModal').modal('show'); 
     
          }
        })

      });

  $("#btnbuscar").click(function(){ 
    $.ajax({
      type: "POST",
      url: "<?php echo site_url('Promover/buscar');?>",
      data: $('#frmbuscar').serialize(),
      success: function(data) {
        var val = $.parseJSON(data);
        //console.log(val.msg);
         console.log(val.error);

          
         if((val.success === "Ok")){ 

          $('#tabla').html(val.tabla);

        }else{ 
          $(".print-error-msg").css('display','block'); 
          $(".print-error-msg").html(val.error);
          setTimeout(function() {$('.print-error-msg').fadeOut('fast');}, 6000);
        }
 
      }
    })
  });
</script>
