  <!-- page content -->
      <div class="right_col" role="main">

        <div class=""> 

          <div class="row">
            <div class="col-md-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2><strong>ASISTENCIA DE LOS ALUMNO(A)</strong></h2>
                  
                  <div class="clearfix"></div>
                </div>
                <div class="x_content"> 
                  <div class="row">
                       <div class="col-md-4 col-sm-12 col-xs-12 "></div>
                        <div class="col-md-8 col-sm-12 col-xs-12 " align="right">
                               <div class="alert alert-danger print-error-msg-1" style="display:none"></div>
                            <form id="frmbuscar">
                                <div class="row clearfix"> 
                                    <div class="col-lg-5 col-md-5 col-sm-4 col-xs-6" aling="right">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="date" class="form-control" name="fechainicio" required="" placeholder="Fecha inicio" id="fechainicio">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-6"  aling="right">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="date" class="form-control" name="fechafin" placeholder="Fecha fin" required="" id="fechafin">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                      <input type="hidden" name="idhorario" value="<?php echo $idhorario ?>">
                                      <input type="hidden" name="idhorariodetalle" value="<?php echo $idhorariodetalle ?>">
                                       <input type="hidden" name="idalumno" value="<?php echo $idalumno ?>">
                                         <button type="button" id="btnbuscar" class="btn btn-primary"><i class='fa fa-search'></i> Buscar</button>
                                    </div>
                                </div>
                            </form>


                        </div>  
                      </div>  
                  <div class="row"> 
                  <div id="tblalumnos">
                   <?php
                   echo $tabla;
                   ?>
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
          if(fechainicio != "" && fechafin != ""){
              $.ajax({
                type: "POST",
                url: "<?php echo site_url('Tutores/obetnerAsistenciaAlu');?>",
                data: $('#frmbuscar').serialize(),
                success: function(data) {
                  //var val = $.parseJSON(data);
                 // console.log(data);
                 $("#tblalumnos").css('display','none'); 
                  $('#tblasistencias').html(data);
                   
           
                }
              })
          }else{
          $(".print-error-msg-1").css('display','block'); 
          $(".print-error-msg-1").html("Es necesario la Fecha.");
          setTimeout(function() {$('.print-error-msg-1').fadeOut('fast');}, 4000);

}

  });
 


</script>

