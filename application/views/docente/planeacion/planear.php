  <!-- page content -->
      <div class="right_col" role="main">

        <div class=""> 

          <div class="row">
            <div class="col-md-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2><strong>ADMINISTRAR PLANEACIÓN</strong></h2>
                  
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">

                  <div class="row"> 


                  


          <button type="button" class="btn btn-primary waves-effect m-r-20" data-toggle="modal" data-target="#largeModal"><i class='fa fa-plus'></i> Nueva Actividad</button>
 <div class="modal fade" id="largeModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="largeModalLabel">AGREGAR NUEVA ACTIVIDAD</h4>
                         </div>
                         <form id="frmplaneacion" >
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
                                      <label><font color="red">*</font> Actividad a Desarrollar, Materiales y Equipos a utilizar</label>
                                         <textarea id="ckeditor"   name="planeacion"  required="">
                                
                                         </textarea> 
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                               <div class="col-md-4 col-sm-12 col-xs-12 ">
                                  <div class="form-group">
                                      <label><font color="red">*</font> Lugar</label>
                                         <input type="text"  name="lugar" class="form-control">
                                         <small>Ej. Aula de clase, Laboratorio, etc.</small>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12 col-xs-12 ">
                                  <div class="form-group">
                                      <label><font color="red">*</font> Fecha de inicio</label>
                                         <input type="date"  name="finicio" class="form-control">
                                         <small>Fecha inicio de actividad</small>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12 col-xs-12 ">
                                  <div class="form-group">
                                      <label><font color="red">*</font> Fecha de termino</label>
                                         <input type="date"  name="ffin" class="form-control">
                                         <small>Fecha termino de actividad</small>
                                    </div>
                                </div>
                            </div>


                        </div>
                        <div class="modal-footer">
                          <input type="hidden" name="unidad" value="<?php echo $idunidad ?>">
                          <input type="hidden" name="horario" value="<?php echo $iddetallehorario ?>">
                            <button type="button" id="btnguardad" class="btn btn-primary waves-effect"><i class='fa fa-floppy-o'></i> GUARDAR</button>
                            <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal"><i class='fa fa-close'></i> CERRAR</button>
                        </div>
                      </form>
                    </div>
                </div>
            </div>



             <div class="modal fade" id="largeModalEdit" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="largeModalLabel">MODIFICAR ACTIVIDAD</h4>
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
                                  <div class="form-group">
                                      <label><font color="red">*</font> Actividad a Desarrollar, Materiales y Equipos a utilizar</label>
                                         <textarea id="ckeditoredit"   name="planeacion" class="planeacion"  required="">
                                
                                         </textarea> 
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                               <div class="col-md-4 col-sm-12 col-xs-12 ">
                                  <div class="form-group">
                                      <label><font color="red">*</font> Lugar</label>
                                         <input type="text"  name="lugar" class="form-control lugar">
                                         <small>Ej. Aula de clase, Laboratorio, etc.</small>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12 col-xs-12 ">
                                  <div class="form-group">
                                      <label><font color="red">*</font> Fecha de inicio</label>
                                         <input type="date"  name="finicio" class="form-control fechainicio">
                                         <small>Fecha inicio de actividad</small>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12 col-xs-12 ">
                                  <div class="form-group">
                                      <label><font color="red">*</font> Fecha de termino</label>
                                         <input type="date"  name="ffin" class="form-control fechafin">
                                         <small>Fecha termino de actividad</small>
                                    </div>
                                </div>
                            </div>


                        </div>
                        <div class="modal-footer">
                          <input type="hidden" name="idplaneacion" class="idplaneacion">  

                            <button type="button" id="btnmodificar" class="btn btn-primary waves-effect"><i class='fa fa-edit'></i> MODIFICAR</button>
                            <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal"><i class='fa fa-close'></i> CERRAR</button>
                        </div>
                      </form>
                    </div>
                </div>
            </div>

</br></br>

  <table class="table">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Planeación</th>
                        <th>Lugar</th>
                        <th>Fecha</th>
                        <th align="right"></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        if (isset($listaplaneacion) && !empty($listaplaneacion)) {
                          # code...
                          $i = 1;
                          foreach ($listaplaneacion as $value) { ?>
                            <tr>
                            <th scope="row"><?php echo $i++ ?></th>
                            <td>PLANEADO</td>
                            <td><?php echo $value->lugar ?></td>
                            <td>
                               <?php
                                setlocale(LC_ALL, 'es_ES');
                        $date_inicio = new Datetime($value->fechainicio);
                        $fecha_inicio = strftime("%A, %d de %B", $date_inicio->getTimestamp());

                        $date_fin = new Datetime($value->fechafin);
                        $fecha_fin = strftime("%A, %d de %B", $date_fin->getTimestamp());

                        echo "<strong>".$fecha_inicio." al ".$fecha_fin."</strong>";
                        ?> </td>
                            <td align="right">
                                 <a  href="javascript:void(0)"  class="edit_button_planeacion btn btn-primary btn-sm"
                      data-toggle="modal" data-target="#largeModalEdit"
                      data-idplaneacion="<?php echo $value->idplaneacion;?>"
                      data-planeacion="<?php echo $value->planeacion;?>"
                      data-lugar="<?php echo $value->lugar;?>"
                      data-fechainicio="<?php echo $value->fechainicio;?>"
                      data-fechafin="<?php echo $value->fechafin;?>">
                      <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                    Modificar / Detalles</a>
                      <a onclick="return confirm('Esta seguro de Eliminar la Planeación?')" href="<?php echo site_url('Pprofesor/eliminar/'.$controller->encode($idunidad).'/'.$controller->encode($iddetallehorario).'/'.$controller->encode($value->idplaneacion)) ?>" class="btn btn-danger btn-sm"><i class='fa fa-trash'></i> Eliminar</a>
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
      $(document).on( "click", '.edit_button_planeacion',function(e) { 
        var idplaneacion = $(this).data('idplaneacion'); 
        var planeacion = $(this).data('planeacion');
        var lugar = $(this).data('lugar');
        var fechainicio = $(this).data('fechainicio');
        var fechafin = $(this).data('fechafin'); 
        CKEDITOR.instances['ckeditoredit'].setData(planeacion);
        $(".idplaneacion").val(idplaneacion);  
        $(".planeacion").val(planeacion);  
        $(".lugar").val(lugar);
        $(".fechainicio").val(fechainicio);   
        $(".fechafin").val(fechafin);
       // $("#entradanumeroparte_salida").text(numeroparte);    
      });

  $("#btnguardad").click(function(){
    for ( instance in CKEDITOR.instances) {
      CKEDITOR.instances[instance].updateElement();
    } 
    $.ajax({
      type: "POST",
      url: "<?php echo site_url('Pprofesor/addPlaneacion');?>",
      data: $('#frmplaneacion').serialize(),
      success: function(data) {
        var val = $.parseJSON(data);
        //console.log(val.msg);
         console.log(val.error);

          
         if((val.success === "Ok")){ 
          //$(".print-success-msg").css('display','block'); 
          //$(".print-success-msg").html("Fue agregado la Actividad con Exito.");
          //setTimeout(function() {
          //  $('.print-error-msg').fadeOut('fast');
          //  location.reload(); 
          //}, 3000);
          swal({
                            position: 'center',
                            type: 'success',
                            title: 'Fue agregado la Actividad con Exito!',
                            text:'Dar clic en el boton.',
                            showConfirmButton: true,
                            //timer: 1500
                         }).then(function(){
                            location.reload();
                          });

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
    for ( instance in CKEDITOR.instances) {
      CKEDITOR.instances[instance].updateElement();
    } 
    $.ajax({
      type: "POST",
      url: "<?php echo site_url('Pprofesor/updatePlaneacion');?>",
      data: $('#frmplaneacionmodificar').serialize(),
      success: function(data) {
        var val = $.parseJSON(data);
        //console.log(val.msg);
         console.log(val.error);

          
         if((val.success === "Ok")){ 
          //$(".print-success-msg").css('display','block'); 
          //$(".print-success-msg").html("Fue modificado la Actividad con Exito.");
          //setTimeout(function() {
          //  $('.print-error-msg').fadeOut('fast');
          //  location.reload(); 
          //}, 3000);
           swal({
                            position: 'center',
                            type: 'success',
                            title: 'Fue modificado la Actividad con Exito!',
                            text:'Dar clic en el boton.',
                            showConfirmButton: true,
                            //timer: 1500
                         }).then(function(){
                            location.reload();
                          });

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


