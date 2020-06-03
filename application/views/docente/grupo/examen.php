
<!-- page content -->
      <div class="right_col" role="main">

        <div class=""> 

          <div class="row">
            <div class="col-md-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2><strong>CALIFICACIONES DEL ALUMNO - <?php if(isset($nombreclase) && !empty($nombreclase)){echo $nombreclase;} ?></strong></h2>
                   
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12 ">
                      <button type="button" class="btn btn-primary waves-effect m-r-20" data-toggle="modal" data-target="#largeModal"><i class='fa fa-plus'></i> Registrar Calificación</button>
                       <button type="button" class="btn btn-danger waves-effect m-r-20" data-toggle="modal" data-target="#myModalDeleteAsistencia"><i class='fa fa-trash '></i> Eliminar Calificación</button>
                       </div>

                  </div>
                   <br>
                     <div class="modal fade" id="myModalDeleteAsistencia" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h2 class="modal-title " id="myModalLabel">ELIMINAR CALIFICACIÓN POR UNIDAD </h2>
                          </div>
                          <form method="post" action="" id="frmeliminarcalificacion">
                            <div class="modal-body"> 
                              <div class="form-group">
                                <label for=""> <font color="red">*</font> Unidad:</label>
                                 <select  class="form-control" name="unidad" id="">
                                    <option value="">-- SELECCIONAR --</option>
                                    <?php
                                      if(isset($unidades) && !empty($unidades)){ 
                                        foreach($unidades as $row){  
                                      ?>
                                        <option value="<?php echo $row->idunidad ?>"><?php echo $row->nombreunidad; ?></option>
                                    <?php
                                      }
                                    }
                                    ?>
                                  </select>
                              </div> 
                          </div>
                          <div class="modal-footer">
                            <input type="hidden" name="horariodetalle" value="<?php echo $idhorariodetalle; ?>">
                            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
                            <button type="button" id="btneliminarcalificacion" class="btn btn-primary"><i class="fa fa-trash"></i> Eliminar</button>
                          </div>
                        </form>
                      </div>
                    </div>
                    </div>

                       <div class="modal fade" id="largeModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="largeModalLabel">REGISTRAR CALIFICACIÓN</h4>
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
                               <div class="col-md-12 col-sm-12 col-xs-12 ">
                                  <div class="form-group">
                                      <label><font color="red">*</font> Unidad</label>
                                       <select class="form-control" name="unidad">
                                         <option value="">-- SELECCIONAR --</option>
                                         <?php
                                            if(isset($unidades) && !empty($unidades)){
                                              foreach($unidades as $row){ ?>
                                                  <option value="<?php echo $row->idunidad ?>"><?php echo $row->nombreunidad ?></option>
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
                                                     <input type="text" name="calificacion[]" class="form-control" placeholder="Calificación">
                                                     <small>Formato decimal Ej. 10.00, 9.60, etc.</small>
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

                   
           
                  <div class="row">
                  <div class="col-md-12 col-sm-12 col-xs-12 "> 
                  <div id="tblalumnos">
                  <?php 
                    if(isset($tabla)){
                        echo $tabla;
                    }
                  ?>
                    </div> 
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
            <input class="form-control idcalificacion" type="hidden" name="idcalificacion"> 
          </div>
          <div class="form-group">
           <label ><font color="red">*</font> Cantidad</label><br>
           <input type="text" name="calificacion"  class="form-control calificacion">
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
            <input class="form-control idcalificacion" type="hidden" name="idcalificacion"> 
          </div>
          <div class="form-group">
           <label ><h3>Esta seguro de Eliminar la Calificación?</h3></label> 
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
      var idcalificacion = $(this).data('idcalificacion'); 
      var calificacion = $(this).data('calificacion');
      var nombre = $(this).data('alumno'); 

      $(".idcalificacion").val(idcalificacion);  
      $(".calificacion").val(calificacion);   
      $("#alumno").text(nombre);    
    }); 
    $(document).on( "click", '.delete_button',function(e) { 
      var idcalificacion = $(this).data('idcalificacion');  
      var nombre = $(this).data('alumno'); 

      $(".idcalificacion").val(idcalificacion);  
      $("#alumnodelete").text(nombre);    
    }); 

    $("#btnguardar").click(function(){ 
    $.ajax({
      type: "POST",
      url: "<?php echo site_url('Pgrupo/addCalificacion');?>",
      data: $('#frmasistencia').serialize(),
      success: function(data) {
        var val = $.parseJSON(data);
        //console.log(val.msg);
         //console.log(val.error);

          
         if((val.success === "Ok")){ 
          //$(".print-success-msg").css('display','block'); 
          //$(".print-success-msg").html("Fue registrado las Calificaciones con Exito.");
          //setTimeout(function() {
           // $('.print-error-msg').fadeOut('fast');
           // location.reload(); 
          //}, 3000);
            swal({
                            position: 'center',
                            type: 'success',
                            title: 'Fue registrado las Calificaciones con Exito!',
                            text:'Dar clic en el boton.',
                            showConfirmButton: true,
                            //timer: 1500
                          }).then(function(){
                            location.reload();
                          });
        }else{ 
        swal({
               type: 'error',
               title: 'Oops...', 
               html: val.error,
               customClass:'swal-wide',
               footer: ''
              }); 
          //$(".print-error-msg").css('display','block'); 
          //$(".print-error-msg").html(val.error);
          //setTimeout(function() {$('.print-error-msg').fadeOut('fast');}, 6000);
        }
 
      }
    })
  });

    $("#btneliminarcalificacion").click(function(){ 
    $.ajax({
      type: "POST",
      url: "<?php echo site_url('Pgrupo/eliminarCalificacionUnidad');?>",
      data: $('#frmeliminarcalificacion').serialize(),
      success: function(data) {
        var val = $.parseJSON(data); 
         if((val.success === "Ok")){ 
          //$(".print-success-msg").css('display','block'); 
          //$(".print-success-msg").html("Fue eliminado la Calificación con Exito.");
          //setTimeout(function() {
          //  $('.print-error-msg').fadeOut('fast');
          //  location.reload(); 
          //}, 3000);

           swal({
                            position: 'center',
                            type: 'success',
                            title: 'Fue eliminado la Calificación con Exito!',
                            text:'Dar clic en el boton.',
                            showConfirmButton: true,
                            //timer: 1500
                          }).then(function(){
                            location.reload();
                          });

          //$(".print-error-msg").css('display','none'); 
          //location.reload(); 
        }else{ 
          //$(".print-error-msg").css('display','block'); 
          //$(".print-error-msg").html(val.error);
          //setTimeout(function() {$('.print-error-msg').fadeOut('fast');}, 6000);
          swal({
               type: 'error',
               title: 'Oops...', 
               html: val.error,
               customClass:'swal-wide',
               footer: ''
              }); 
        }
 
      }
    })
  });
  $("#btneliminar").click(function(){ 
    $.ajax({
      type: "POST",
      url: "<?php echo site_url('Pgrupo/eliminarCalificacion');?>",
      data: $('#frmeliminar').serialize(),
      success: function(data) {
        var val = $.parseJSON(data); 
         if((val.success === "Ok")){ 
          //$(".print-success-msg").css('display','block'); 
          //$(".print-success-msg").html("Fue eliminado la Calificación con Exito.");
          //setTimeout(function() {
          //  $('.print-error-msg').fadeOut('fast');
          //  location.reload(); 
          //}, 3000);

           swal({
                            position: 'center',
                            type: 'success',
                            title: 'Fue eliminado la Calificación con Exito!',
                            text:'Dar clic en el boton.',
                            showConfirmButton: true,
                            //timer: 1500
                          }).then(function(){
                            location.reload();
                          });

          //$(".print-error-msg").css('display','none'); 
          //location.reload(); 
        }else{ 
          //$(".print-error-msg").css('display','block'); 
          //$(".print-error-msg").html(val.error);
          //setTimeout(function() {$('.print-error-msg').fadeOut('fast');}, 6000);
          swal({
               type: 'error',
               title: 'Oops...', 
               html: val.error,
               customClass:'swal-wide',
               footer: ''
              }); 
        }
 
      }
    })
  });


  $("#btnmodificar").click(function(){ 
    $.ajax({
      type: "POST",
      url: "<?php echo site_url('Pgrupo/updateCalificacion');?>",
      data: $('#frmmodificar').serialize(),
      success: function(data) {
        var val = $.parseJSON(data); 
         if((val.success === "Ok")){ 
          //$(".print-success-msg").css('display','block'); 
          //$(".print-success-msg").html("Fue modificado la Calificación con Exito.");
          //setTimeout(function() {
          //  $('.print-error-msg').fadeOut('fast');
          //  location.reload(); 
          //}, 3000);

           swal({
                            position: 'center',
                            type: 'success',
                            title: 'Fue modificado la Calificación con Exito!',
                            text:'Dar clic en el boton.',
                            showConfirmButton: true,
                            //timer: 1500
                          }).then(function(){
                            location.reload();
                          });

          //$(".print-error-msg").css('display','none'); 
          //location.reload(); 
        }else{ 
          //$(".print-error-msg").css('display','block'); 
          //$(".print-error-msg").html(val.error);
          //setTimeout(function() {$('.print-error-msg').fadeOut('fast');}, 6000);
          swal({
               type: 'error',
               title: 'Oops...', 
               html: val.error,
               customClass:'swal-wide',
               footer: ''
              }); 
        }
 
      }
    })
  });

 

</script>

