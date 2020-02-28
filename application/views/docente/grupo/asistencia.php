  <!-- page content -->
      <div class="right_col" role="main">

        <div class=""> 

          <div class="row">
            <div class="col-md-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2><strong>ASISTENCIA DE LOS ALUMNOS - <?php if(isset($nombreclase) && !empty($nombreclase)){echo $nombreclase;} ?> </strong></h2>
                  
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12 ">
                      <button type="button" class="btn btn-primary waves-effect m-r-20" data-toggle="modal" data-target="#largeModal"><i class='fa fa-plus'></i> Registrar Asistencia</button>
                       <div class="modal fade" id="largeModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="largeModalLabel">REGISTRAR ASISTENCIA</h4>
                         </div>
                         <form id="frmasistencia" >
                        <div class="modal-body">
                          <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <div class="alert alert-success print-success-msg" style="display:none"></div>
                              <div class="alert alert-danger print-error-msg" style="display:none"></div>
                             </div>
                          </div>
                            <div class="row">
                               <div class="col-md-6 col-sm-12 col-xs-12 ">
                                  <div class="form-group">
                                      <label><font color="red">*</font> Fecha</label>
                                      <input type="date"  name="fecha" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12 col-xs-12 ">
                                  <div class="form-group">
                                      <label><font color="red">*</font> Unidad</label>
                                      <select name="unidad" required="" class="form-control">
                                        <option value="">--Seleccionar--</option>
                                       <?php
                                        if(isset($unidades) && !empty($unidades)){
                                            foreach ($unidades as $value) { ?>
                                              <option value="<?php echo $value->idunidad ?>"><?php echo $value->nombreunidad; ?></option>

                                            <?php
                                            }
                                        }
                                       ?>
                                       </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                               <div class="col-md-12 col-sm-12 col-xs-12 " >
                                         <table class="table">
                                        <thead>
                                          <tr>
                                            <th>#</th>
                                            <th>Alumno</th> 
                                            <th></th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                          <?php
                                            if (isset($alumnos) && !empty($alumnos)) {
                                              $i = 1;
                                                foreach($alumnos as $value){ ?>
                                                  <input type="hidden" name="idalumno[]" value="<?php echo $value->idalumno ?>">
                                                  <tr>
                                                  <td><?php echo $i++ ?></td>
                                                  <td>
                                                    <?php echo $value->apellidop.' '.$value->apellidom.' '.$value->nombre ?>
                                                    
                                                  </td> 
                                                  <td>
                                                    <select name="motivo[]" required="" class="form-control">
                                                      <option value="">--Seleccionar--</option>
                                                      <?php
                                                        if(isset($motivo) && !empty($motivo)){
                                                            foreach($motivo as $value){ ?>
                                                              <option value="<?php echo $value->idmotivo ?>"><?php echo $value->nombremotivo ?></option>
                                                              <?php 
                                                            }
                                                        }
                                                      ?>
                                                    </select>
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
                        <div class="modal-footer"> 
                          <input type="hidden" name="idhorario" value="<?php echo $idhorario ?>">
                          <input type="hidden" name="idhorariodetalle" value="<?php echo $idhorariodetalle ?>">
                            <button type="button" id="btnguardar" class="btn btn-primary waves-effect"><i class='fa fa-floppy-o'></i> GUARDAR</button>
                            <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal"><i class='fa fa-close'></i> CERRAR</button>
                        </div>
                      </form>
                    </div>
                </div>
            </div>

                    </div>
                  </div>
                  <div class="row">
                       <div class="col-md-4 col-sm-12 col-xs-12 "></div>
                        <div class="col-md-8 col-sm-12 col-xs-12 " align="right">
                               <div class="alert alert-danger print-error-msg-1" style="display:none"></div>
                            <form id="frmbuscar">
                                <div class="row clearfix">
                                  <div class="col-md-4 col-sm-12 col-xs-12 ">
                                  <div class="form-group"> 
                                      <select name="unidad" required="" class="form-control">
                                        <option value="">--Seleccionar Unidad--</option>
                                        <option value="1">TODOS</option>
                                       <?php
                                        if(isset($unidades) && !empty($unidades)){
                                            foreach ($unidades as $value) { ?>
                                              <option value="<?php echo $value->idunidad ?>"><?php echo $value->nombreunidad; ?></option>

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

  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3 class="modal-title " id="myModalLabel">Alumno: <label id="alumno"></label> </h3>
      </div>
      <form method="post" action="" id="frmmodificar">
        <div class="modal-body">
        
          <div class="alert alert-danger print-error-msg" style="display:none"></div>
          <div class="alert alert-success print-success-msg" style="display:none"></div>
          <div class="form-group">
            <input class="form-control idasistencia" type="hidden" name="idasistencia"> 
          </div>
          <div class="form-group">
           <label ><font color="red">*</font> Opción</label><br>
           <select name="motivo" required="" class="form-control">
                  <option value="">--Seleccionar--</option>
                  <?php
                   if(isset($motivo) && !empty($motivo)){
                     foreach($motivo as $value){ ?>
                      <option value="<?php echo $value->idmotivo ?>"><?php echo $value->nombremotivo ?></option>
                  <?php 
                      }
                        }
                  ?>
          </select>
         </div> 
       </div>
       <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
        <button type="button" id="btnmodificar" class="btn btn-primary"><i class="fa fa-pencil"></i> Modificar</button>
      </div>
    </form>
  </div>
</div>
</div>


<div class="modal fade" id="myModalDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3 class="modal-title " id="myModalLabel">Alumno: <label id="alumnodelete"></label> </h3>
      </div>
      <form method="post" action="" id="frmeliminar">
        <div class="modal-body">
          <div class="alert alert-danger print-error-msg" style="display:none"></div>
          <div class="alert alert-success print-success-msg" style="display:none"></div>
          <div class="form-group">
            <input class="form-control idasistencia" type="hidden" name="idasistencia"> 
          </div>
          <div class="form-group">
           <label ><h3>Esta seguro de Eliminar la Asistencia?</h3></label> 
         </div> 
       </div>
       <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
        <button type="button" id="btneliminar" class="btn btn-primary"><i class="fa fa-trash"></i> Eliminar</button>
      </div>
    </form>
  </div>
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
      var idasistencia= $(this).data('idasistencia');  
      var nombre = $(this).data('alumno'); 

      $(".idasistencia").val(idasistencia);    
      $("#alumno").text(nombre);    
    }); 
    $(document).on( "click", '.delete_button',function(e) { 
      var idasistencia = $(this).data('idasistencia');  
      var nombre = $(this).data('alumno'); 

      $(".idasistencia").val(idasistencia);  
      $("#alumnodelete").text(nombre);    
    }); 

    $("#btnguardar").click(function(){ 
    $.ajax({
      type: "POST",
      url: "<?php echo site_url('Pgrupo/addAsistencia');?>",
      data: $('#frmasistencia').serialize(),
      success: function(data) {
        var val = $.parseJSON(data);
        //console.log(val.msg);
         console.log(val.error);

          
         if((val.success === "Ok")){ 
          $(".print-success-msg").css('display','block'); 
          $(".print-success-msg").html("Las asistencias fueron registrado con Exito.");
          setTimeout(function() {
            $('.print-error-msg').fadeOut('fast');
            location.reload(); 
          }, 3000);
        }else{ 
          $(".print-error-msg").css('display','block'); 
          $(".print-error-msg").html(val.error);
          setTimeout(function() {$('.print-error-msg').fadeOut('fast');}, 6000);
        }
 
      }
    })
  });

        $("#btnbuscar").click(function(){ 
          var fechainicio = $("#fechainicio").val();
          var fechafin = $("#fechafin").val();
          if(fechainicio != "" && fechafin != ""){
              $.ajax({
                type: "POST",
                url: "<?php echo site_url('Pgrupo/buscarAsistencia');?>",
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

  $("#btneliminar").click(function(){ 
    $.ajax({
      type: "POST",
      url: "<?php echo site_url('Pgrupo/eliminarAsistencia');?>",
      data: $('#frmeliminar').serialize(),
      success: function(data) {
        var val = $.parseJSON(data); 
         if((val.success === "Ok")){ 
          $(".print-success-msg").css('display','block'); 
          $(".print-success-msg").html("Fue eliminado la Asistencia con Exito.");
          setTimeout(function() {
            $('.print-error-msg').fadeOut('fast');
            location.reload(); 
          }, 3000);

          //$(".print-error-msg").css('display','none'); 
          //location.reload(); 
        }else{ 
          $(".print-error-msg").css('display','block'); 
          $(".print-error-msg").html(val.error);
          setTimeout(function() {$('.print-error-msg').fadeOut('fast');}, 6000);
        }
 
      }
    })
  });


  $("#btnmodificar").click(function(){ 
    $.ajax({
      type: "POST",
      url: "<?php echo site_url('Pgrupo/updateAsistencia');?>",
      data: $('#frmmodificar').serialize(),
      success: function(data) {
        var val = $.parseJSON(data); 
         if((val.success === "Ok")){ 
          $(".print-success-msg").css('display','block'); 
          $(".print-success-msg").html("Fue modificado la Asistencia con Exito.");
          setTimeout(function() {
            $('.print-error-msg').fadeOut('fast');
            location.reload(); 
          }, 3000);

          //$(".print-error-msg").css('display','none'); 
          //location.reload(); 
        }else{ 
          $(".print-error-msg").css('display','block'); 
          $(".print-error-msg").html(val.error);
          setTimeout(function() {$('.print-error-msg').fadeOut('fast');}, 6000);
        }
 
      }
    })
  });


</script>

