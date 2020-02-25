  <!-- page content -->
  <div class="right_col" role="main">

<div class=""> 

  <div class="row">
    <div class="col-md-12">
      <div class="x_panel">
        <div class="x_title">
          <h2><strong>HORARIO ESCOLAR</strong></h2> 
          <div class="clearfix"></div>
        </div>
        <div class="x_content">

          <div class="row"> 
            <form  id="frmbuscar">
              <div class="row">
                <div class="alert alert-danger print-error-msg-1" style="display:none"></div>
              </div>
            <div class="row">
            <div class="col-md-3 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <label><font color="red">*</font> Materias</label>
                        <select name="materias[]" id="materias" class="select2_multiple form-control" multiple="multiple">
                          <option value="2804">TODAS LAS MATERIAS</option>
                          <?php 
                            if(isset($materias) && !empty($materias)){
                              foreach ($materias as $value) {
                          ?>
                            <option value="<?php echo $value->idhorariodetalle ?>"><?php echo $value->nombreclase ?></option>
                          <?php 
                              }

                            }
                           ?> 
                        </select>
                </div>
            </div> 
              <div class="col-md-2 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <label><font color="red">*</font> De</label>
                        <input type="date" class="form-control" id="fechainicio" name="fechainicio"> 
                </div>
            </div> 
              <div class="col-md-2 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <label><font color="red">*</font> a</label>
                        <input type="date" class="form-control" id="fechafin"  name="fechafin"> 
                </div>
            </div> 
            <div class="col-md-2 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <label><font color="red">*</font> Tipo</label>
                    <select class="form-control" name="motivo" id="motivo">
                      <option value="">SELECCIONAR</option>
                      <?php
                        if (isset($tipoasistencia) && !empty($tipoasistencia)) {
                            foreach ($tipoasistencia as $value) { ?>
                               <option value="<?php echo $value->idmotivo ?>"><?php echo $value->nombremotivo ?></option>
                      <?php        
                            }
                        }
                      ?>
                     
                    </select> 
                </div>
            </div> 
             <div class="col-md-3 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <input type="hidden" name="idalumno" value="<?php echo $idalumno ?>">
                    <input type="hidden" name="idhorario" value="<?php echo $idhorario ?>">
                    <button class="btn btn-primary" type="button" id="btnbuscar" style="margin-top: 25px;"><i class="fa fa-search"></i>  Buscar</button>
                </div>
            </div> 
             
           </div> 
         </form>
          </div>

          <div class="row">
            <div id="tblasistencias"></div>
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
          var materias = $("#materias").val();
          var fechainicio = $("#fechainicio").val();
          var fechafin = $("#fechafin").val(); 
          var tipo = $("#motivo").val(); 
          console.log(materias);
          if(materias != null && fechainicio != "" && fechafin != "" && tipo != ""){
              $.ajax({
                type: "POST",
                url: "<?php echo site_url('Alumno/buscarAsistencia');?>",
                data: $('#frmbuscar').serialize(),
                success: function(data) { 
                  //$("#tblalumnos").css('display','none'); 
                  $('#tblasistencias').html(data);
                   
           
                }
              })
          }else{
          $(".print-error-msg-1").css('display','block'); 
          $(".print-error-msg-1").html("Todos los campos son obligatorios");
          setTimeout(function() {$('.print-error-msg-1').fadeOut('fast');}, 4000);

}

  });
</script>

