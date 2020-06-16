  <!-- page content -->
      <div class="right_col" role="main">

        <div class=""> 

          <div class="row">
            <div class="col-md-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2><strong>ASISTENCIAS - <?php if(isset($nombreclase) && !empty($nombreclase)){echo $nombreclase;} ?></strong></h2>
                   
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
               <div class="row">
                       <div class="col-md-4 col-sm-12 col-xs-12 "></div>
                        <div class="col-md-8 col-sm-12 col-xs-12 " align="right">
                               <div class="alert alert-danger print-error-msg-1" style="display:none"></div>
                            <form id="frmbuscar">
                                <div class="row clearfix">
                                  <div class="col-md-4 col-sm-12 col-xs-12 ">
                                  <div class="form-group">  
                                      <select name="motivo" required="" id="motivo" class="form-control">
                                        <option value="">-- SELECCIONAR --</option>
                                        <option value="0">TODOS</option>
                                       <?php
                                        if(isset($motivos) && !empty($motivos)){
                                            foreach ($motivos as $value) { ?>
                                              <option value="<?php echo $value->idmotivo ?>"><?php echo $value->nombremotivo; ?></option>

                                            <?php
                                            }
                                        }
                                       ?>
                                       </select>
                                    </div>
                                </div>
                                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-6">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="date" class="form-control" name="fechainicio" required="" placeholder="Fecha inicio" id="fechainicio">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-6">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="date" class="form-control" name="fechafin" placeholder="Fecha fin" required="" id="fechafin">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-4 col-sm-4 col-xs-12">
                                      <input type="hidden" name="idhorario" value="<?php echo $idhorario ?>">
                                      <input type="hidden" name="idhorariodetalle" value="<?php echo $idhorariodetalle ?>">
                                         <button type="button" id="btnbuscar" class="btn btn-primary"><i class='fa fa-search'></i> Buscar</button>
                                    </div>
                                </div>
                            </form>


                        </div>  
                      </div>
                  <div class="row"> 
                    <div id="tblalumnos">
                    <?php if (isset($tabla)): 
                    echo $tabla;
                      
                    endif ?>
                    </div>
                       <div id="tblasistencias">
                      

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

<script type="text/javascript"> 

        $("#btnbuscar").click(function(){ 
          var fechainicio = $("#fechainicio").val();
          var fechafin = $("#fechafin").val();
           var motivo = $("#motivo").val();
          if(fechainicio != "" && fechafin != "" && motivo != ""){
              $.ajax({
                type: "POST",
                url: "<?php echo site_url('Aalumno/buscarAsistencia');?>",
                data: $('#frmbuscar').serialize(),
                success: function(data) {
                  //var val = $.parseJSON(data);
                 // console.log(data);
                 $("#tblalumnos").css('display','none'); 
                  $('#tblasistencias').html(data);
                   
           
                }
              })
          }else{
          //$(".print-error-msg-1").css('display','block'); 
          //$(".print-error-msg-1").html("Es necesario la Fecha.");
          //setTimeout(function() {$('.print-error-msg-1').fadeOut('fast');}, 4000);
           swal({
               type: 'error',
               title: 'Oops...', 
               html: 'Todos los campos son obligatorios.',
               customClass:'swal-wide',
               footer: ''
              }); 

}

  });

         

</script>

