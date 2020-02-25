  <!-- page content -->
      <div class="right_col" role="main">

        <div class=""> 

          <div class="row">
            <div class="col-md-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2><strong>TAREAS PARA EL GRUPO</strong></h2>
                   
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12 ">
                      <button type="button" class="btn btn-primary waves-effect m-r-20" data-toggle="modal" data-target="#largeModal"><i class='fa fa-plus'></i> Registrar Tarea</button>
                       </div>

                  </div>
                   <br>
                       <div class="modal fade" id="largeModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="largeModalLabel">REGISTRAR TAREA</h4>
                         </div>
                         <form id="frmtarea" >
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
                                      <label><font color="red">*</font> Fecha de entrega</label>
                                      <input type="date" name="fechaentrega" required="" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                               <div class="col-md-12 col-sm-12 col-xs-12 ">
                                  <div class="form-group">
                                      <label><font color="red">*</font> Tarea</label>
                                         <textarea id="ckeditor"   name="tarea"  required="">
                                
                                         </textarea> 
                                    </div>
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
                   
                     <table class="table">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Tarea</th>
                        <th>Fecha de entrega</th> 
                        <th align="right"></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        if (isset($tareas) && !empty($tareas)) {
                          # code...
                          $i = 1;
                          foreach ($tareas as $value) { ?>
                            <tr>
                            <th scope="row"><?php echo $i++ ?></th> 
                            <td><?php echo $value->tarea ?></td>
                            <td>
                              <?php
                              setlocale(LC_ALL, 'es_ES');
                               $date_fin = new Datetime($value->fechaentrega);
                        $fecha_fin = strftime("%A, %d de %B", $date_fin->getTimestamp());

                        echo "<strong>".$fecha_fin."</strong>";
                        ?>
                            </td>
                            <td align="right">
                                 <a  href="javascript:void(0)"  class="edit_button_tarea btn btn-primary btn-sm"
                      data-toggle="modal" data-target="#largeModalEdit"
                      data-idtarea="<?php echo $value->idtarea;?>"
                      data-tarea="<?php echo $value->tarea;?>"
                      data-fechaentrega ="<?php echo $value->fechaentrega;?>" >
                      <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                    Modificar / Detalles</a>
                      <a onclick="return confirm('Esta seguro de Eliminar la Tarea?')"  href="<?php echo site_url('Pgrupo/eliminarTarea/'.$idhorario.'/'.$idhorariodetalle.'/'.$value->idtarea) ?>" class="btn btn-danger btn-sm"><i class='fa fa-trash'></i> Eliminar</a>
                            </td> 
                          </tr>
                     <?php
                          }
                        }

                      ?>
                     
                       
                    </tbody>
                  </table>


             <div class="modal fade" id="largeModalEdit" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="largeModalLabel">MODIFICAR TAREA</h4>
                         </div>
                         <form id="frmmodificartarea" >
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
                                      <label><font color="red">*</font>  Fecha de entrega</label>
                                        <input type="date" name="fechaentrega" class="form-control fechaentrega">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                               <div class="col-md-12 col-sm-12 col-xs-12 ">
                                  <div class="form-group">
                                      <label><font color="red">*</font>  Tarea</label>
                                         <textarea id="ckeditoredit"   name="tarea" class="tarea"  required="">
                                
                                         </textarea> 
                                    </div>
                                </div>
                            </div> 

                        </div>
                        <div class="modal-footer">
                          <input type="hidden" name="idtarea" class="idtarea">  
                            <button type="button" id="btnmodificar" class="btn btn-primary waves-effect"><i class='fa fa-edit'></i> MODIFICAR</button>
                            <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal"><i class='fa fa-close'></i> CERRAR</button>
                        </div>
                      </form>
                    </div>
                </div>
            </div>


                  
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

  <div id="custom_notifications" class="custom-notifications dsp_none">
    <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
    </ul>
    <div class="clearfix"></div>
    <div id="notif-group" class="tabbed_notifications"></div>
  </div> 
<script type="text/javascript">
       $(document).on( "click", '.edit_button_tarea',function(e) { 
        var idtarea = $(this).data('idtarea'); 
        var fechaentrega = $(this).data('fechaentrega');
        var tarea = $(this).data('tarea');  
        CKEDITOR.instances['ckeditoredit'].setData(tarea);
        $(".idtarea").val(idtarea);  
       // $(".planeacion").val(planeacion);  
        $(".fechaentrega").val(fechaentrega); 
       // $("#entradanumeroparte_salida").text(numeroparte);    
      });

  $("#btnguardar").click(function(){
    for ( instance in CKEDITOR.instances) {
      CKEDITOR.instances[instance].updateElement();
    } 
    $.ajax({
      type: "POST",
      url: "<?php echo site_url('Pgrupo/addTarea');?>",
      data: $('#frmtarea').serialize(),
      success: function(data) {
        var val = $.parseJSON(data);
        //console.log(val.msg);
         console.log(val.error);

          
         if((val.success === "Ok")){ 
          $(".print-success-msg").css('display','block'); 
          $(".print-success-msg").html("Fue registrado la Tarea con Exito.");
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

    $("#btnmodificar").click(function(){
    for ( instance in CKEDITOR.instances) {
      CKEDITOR.instances[instance].updateElement();
    } 
    $.ajax({
      type: "POST",
      url: "<?php echo site_url('Pgrupo/updateTarea');?>",
      data: $('#frmmodificartarea').serialize(),
      success: function(data) {
        var val = $.parseJSON(data);
        //console.log(val.msg);
         console.log(val.error);

          
         if((val.success === "Ok")){ 
          $(".print-success-msg").css('display','block'); 
          $(".print-success-msg").html("Fue modificado la Tarea con Exito.");
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

 

</script>

