  <!-- page content -->
      <div class="right_col" role="main">

        <div class=""> 

          <div class="row">
            <div class="col-md-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2><strong>MENSAJES PARA EL GRUPO O PADRES DE FAMILIA</strong></h2>
                   
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12 ">
                      <button type="button" class="btn btn-primary waves-effect m-r-20" data-toggle="modal" data-target="#largeModal"><i class='fa fa-plus'></i> Registrar Mensaje</button>
                       </div>

                  </div>
                   <br>
                       <div class="modal fade" id="largeModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="largeModalLabel">REGISTRAR MENSAJE</h4>
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
                                      <label><font color="red">*</font> Redactar Mensaje</label>
                                         <textarea id="ckeditor"   name="mensaje"  required="">
                                
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
                   
                     <table  id="docente_mensaje" class="table table-striped  ">
                       <thead class="bg-teal"> 
                      <tr>
                        <th>#</th>
                        <th>Mensaje</th>
                        <th>Fecha de registro</th> 
                        <th align="right"></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        if (isset($mensajes) && !empty($mensajes)) {
                          # code...
                          $i = 1;
                          foreach ($mensajes as $value) { ?>
                            <tr>
                            <th scope="row"><?php echo $i++ ?></th> 
                            <td><?php
                            
                               if(strlen($value->mensaje) > 50){
                                 echo $cadena = substr($value->mensaje,0,50)."..."; ?>
                                 <?php }else{
                                  echo $value->mensaje;
                                }

                            ?></td>
                            <td>
                              <?php
                              setlocale(LC_ALL, 'es_ES');
                               $date_fin = new Datetime($value->fecharegistro);
                        $fecha_fin = strftime("%A, %d de %B", $date_fin->getTimestamp());

                        echo "<strong>". utf8_encode($fecha_fin)."</strong>";
                        ?>
                            </td>
                            <td align="right">
                                 <a  href="javascript:void(0)"  class="edit_button_tarea btn btn-primary btn-sm"
                      data-toggle="modal" data-target="#largeModalEdit"
                      data-idmensaje="<?php echo $value->idmensaje;?>"
                      data-mensaje="<?php echo $value->mensaje;?>"
                      data-fecharegistro ="<?php echo $value->fecharegistro;?>" >
                      <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                    Modificar / Detalles</a>
                      <a onclick="return confirm('Esta seguro de Eliminar la Tarea?')"  href="<?php echo site_url('Pgrupo/eliminarMensaje/'.$controller->encode($idhorario).'/'.$controller->encode($idhorariodetalle).'/'.$controller->encode($value->idmensaje)) ?>" class="btn btn-danger btn-sm"><i class='fa fa-trash'></i> Eliminar</a>
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
                            <h4 class="modal-title" id="largeModalLabel">MODIFICAR MENSAJE</h4>
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
                                      <label><font color="red">*</font>  Redactar Mensaje</label>
                                         <textarea id="ckeditoredit"   name="mensaje" class="mensaje"  required="">
                                
                                         </textarea> 
                                    </div>
                                </div>
                            </div> 

                        </div>
                        <div class="modal-footer">
                          <input type="hidden" name="idmensaje" class="idmensaje">  
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
<script data-my_var_1="<?php echo base_url() ?>" src="<?php echo base_url(); ?>/assets/js/validar/tutor_mensaje.js"></script> 



