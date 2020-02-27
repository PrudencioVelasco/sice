  <!-- page content -->
      <div class="right_col" role="main">

        <div class=""> 

          <div class="row">
            <div class="col-md-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2><strong>DETALLES DEL ALUMNO</strong></h2> 
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  

                            <div class="col-md-3 col-sm-3 col-xs-12 profile_left">

                    <div class="profile_img">

                      <!-- end of image cropping -->
                      <div id="crop-avatar">
                        <!-- Current avatar -->
                        <div class="avatar-view" title="Dar clic para cambiar la Foto.">
                          <?php if(isset($detalle->foto) && (!empty($detalle->foto) || $detalle->foto != null) ){ ?>
                          <img src="<?php echo base_url(); ?>/assets/alumnos/<?php echo $detalle->foto ?>" alt="Avatar">
                        <?php } else { ?>
                           <img src="<?php echo base_url(); ?>/assets/images/images.png" alt="Avatar">
                        <?php } ?>
                        </div>

                        <!-- Cropping modal -->
                        <div class="modal fade" id="avatar-modal" aria-hidden="true" aria-labelledby="avatar-modal-label" role="dialog" tabindex="-1">
                          <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                              <form class="avatar-form" action="<?php echo base_url('alumno/actualizarFoto')?>" enctype="multipart/form-data" method="post">
                                <div class="modal-header">
                                  <button class="close" data-dismiss="modal" type="button">&times;</button>
                                  <h4 class="modal-title" id="avatar-modal-label">Cambiar foto</h4>
                                </div>
                                <div class="modal-body">
                                  <div class="avatar-body">

                                    <!-- Upload image and data -->
                                    <div class="avatar-upload">
                                      <input class="avatar-src" name="avatar_src" type="hidden">
                                      <input class="avatar-data" name="avatar_data" type="hidden">
                                      <label for="avatarInput">Cargar imagen</label>
                                      <input class="avatar-input" id="avatarInput" name="avatar_file" type="file">
                                      <input type="hidden" name="idalumno" value="<?php echo $id;?>">
                                    </div>

                                    <!-- Crop and preview -->
                                    <div class="row">
                                      <div class="col-md-9">
                                        <div class="avatar-wrapper"></div>
                                      </div>
                                      <div class="col-md-3">
                                        <div class="avatar-preview preview-lg"></div>
                                        <div class="avatar-preview preview-md"></div>
                                        <div class="avatar-preview preview-sm"></div>
                                      </div>
                                    </div>

                                    <div class="row avatar-btns">
                                      <div class="col-md-9">
                                        <div class="btn-group">
                                          <button class="btn btn-primary" data-method="rotate" data-option="-90" type="button" title="Rotate -90 degrees">R. izquierda</button>
                                          <button class="btn btn-primary" data-method="rotate" data-option="-15" type="button">-15deg</button>
                                          <button class="btn btn-primary" data-method="rotate" data-option="-30" type="button">-30deg</button>
                                          <button class="btn btn-primary" data-method="rotate" data-option="-45" type="button">-45deg</button>
                                        </div>
                                        <div class="btn-group">
                                          <button class="btn btn-primary" data-method="rotate" data-option="90" type="button" title="Rotate 90 degrees">R. derecha</button>
                                          <button class="btn btn-primary" data-method="rotate" data-option="15" type="button">15deg</button>
                                          <button class="btn btn-primary" data-method="rotate" data-option="30" type="button">30deg</button>
                                          <button class="btn btn-primary" data-method="rotate" data-option="45" type="button">45deg</button>
                                        </div>
                                      </div>
                                      <div class="col-md-3">
                                        <button class="btn btn-primary btn-block avatar-save" type="submit">Subir</button>
                                        <button onclick="javascript:window.location.reload()" class="btn btn-danger btn-block">Cerrar</button>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <!-- <div class="modal-footer">
                                                  <button class="btn btn-default" data-dismiss="modal" type="button">Close</button>
                                                </div> -->
                              </form>
                            </div>
                          </div>
                        </div>
                        <!-- /.modal -->

                        <!-- Loading state -->
                        <div class="loading" aria-label="Loading" role="img" tabindex="-1"></div>
                      </div>
                      <!-- end of image cropping -->

                    </div>
                    <h3><?php echo $detalle->nombre." ".$detalle->apellidop." ".$detalle->apellidom ?></h3>

                    <ul class="list-unstyled user_data">
                      <li><i class="fa fa-key user-profile-icon" ></i> <label>Matricula:  <?php echo $detalle->matricula ?></label></li>

                      <li>
                        <i class="fa fa-home user-profile-icon" style="color: blue"></i> <label><?php if(isset($grupoactual) && empty($grupoactual)) { echo "Grupo no asignado";}else{ echo $grupoactual; } ?></label>
                      </li>
                      <li>
                        <i class="fa fa-check-circle" style="color: green"></i> <label>Promedio Gral. <?php if(isset($promediogeneral) && !empty($promediogeneral)) {  echo number_format($promediogeneral,2);}else{ echo " --- "; } ?></label>
                      </li>
                      <li>
                        <i class="fa fa-check-circle "></i> <label>Especialidad: <?php echo $detalle->nombreespecialidad ?></label>
                      </li>


                     <!-- <li class="m-top-xs">
                        <i class="fa fa-external-link user-profile-icon"></i>
                        <a href="http://www.kimlabs.com/profile/" target="_blank">www.kimlabs.com</a>
                      </li>-->
                    </ul>

                   <div class="row">
                         <div class="col-md-12 col-sm-12 col-xs-12 " align="left">
                            <div class="form-group">
                                 <?php if(isset($validargrupo) && empty($validargrupo)){ ?>
                                 <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target=".bs-example-modal-sm">Asignar grupo</button>
                               <?php } ?>
                                <!--  <?php// if(isset($validargrupo) && !empty($validargrupo)){ ?>
                                 <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target=".bs-example-cambiar-modal-sm">Cambiar de grupo</button>
                                   <?php// } ?>-->
                            </div>
                        </div>   
                  </div>
                    <br />

                    

                  </div>
                  <div class="col-md-9 col-sm-9 col-xs-12">
 

                    <div class="" role="tabpanel" data-example-id="togglable-tabs">
                      <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true"><i class="fa fa-bookmark"></i> <label>Kardex / Horario</label></a>
                        </li>
                        <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false"><i class="fa fa-users"></i> <label>Tutor(es)</label></a>
                        </li>
                        <li role="presentation" class=""><a href="#tab_content3" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false"><i class="fa fa-money"></i> <label>Estado Cuenta</label></a>
                        </li>
                      </ul>
                      <div id="myTabContent" class="tab-content">
                        <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
    <table class="table">
                    <thead>
                      <tr> 
                        <th>Periodo</th>
                        <th>Año</th>
                        <th>Grupo</th> 
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 
                          if(isset($kardex) && !empty($kardex)){
                            foreach($kardex as $row){
                           ?>
                              <tr> 
                                <td>
                                <?php 
                                    echo "<label>".$row->mesinicio." ".$row->yearinicio." - ".$row->mesfin." ".$row->yearfin."</label>";
                                 ?> 
                                </td> 
                                <td>
                                  <?php
                                    echo $row->nombrenivel;
                                  ?>
                                </td>
                                 <td>
                                  <?php
                                    echo $row->nombregrupo;
                                  ?>
                                </td>
                                <td align="right">
                                     <div class="btn-group" role="group">
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-primary waves-effect dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                             Opciones
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu"> 
                                            <li><a href="<?php echo site_url('alumno/historial/'.$row->idhorario.'/'.$id) ?>"><i class="fa fa-list-alt" aria-hidden="true"></i> Boleta</a></li> 
                                            <li><a href="<?php echo site_url('alumno/horario/'.$row->idhorario.'/'.$id) ?>"><i class="fa fa-clock-o"></i> Horario</a></li> 
                                            <li><a href="<?php echo site_url('alumno/asistencia/'.$row->idhorario.'/'.$id) ?>"> <i class="fa fa-check"></i> Asistencia</a></li>  
                                           
                                          
                                        </ul>
                                    </div>
                                </div>
 

                                </td>
                             </tr>
                       <?php } } else{ echo "<tr><td colspan='4'>No existe Kardex del alumno.</td></tr>"; }?>
                    </tbody>
                  </table>

                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab"> 

                             <div id="app">
                            <div class="container">
                                <div class="row">
                                    <transition
                                        enter-active-class="animated fadeInLeft"
                                        leave-active-class="animated fadeOutRight">
                                        <div class="notification is-success text-center px-5 top-middle" v-if="successMSG" @click="successMSG = false">{{successMSG}}</div>
                                    </transition>
                                    <div class="col-md-12">
 
                                        <div class="row">
                                            <div class="col-md-6">
                                               <button class="btn btn-round btn-primary" @click="addModal= true"><i class='fa fa-plus'></i> Asignar Tutor</button> 
                                            </div>
                                            <div class="col-md-6">
                                                <input placeholder="Buscar" type="search" class="form-control" v-model="search.text" @keyup="searchTutor" name="search">
                                            </div>
                                        </div>
                                        <br>
                                        <table class="table ">
                                            <thead class="" >

                                            <th class="text-white" v-column-sortable:nombre>Nombre </th>
                                            <th class="text-white" v-column-sortable:apellidop>A. Paterno </th>
                                            <th class="text-white" v-column-sortable:apellidom>A. Materno </th>
                                             <th class="text-center text-white">Opción </th>
                                            </thead>
                                            <tbody class="table-light">
                                                <tr v-for="tutor in tutores" class="table-default">

                                                    <td>{{tutor.nombre}}</td>
                                                    <td>{{tutor.apellidop}}</td>
                                                    <td>{{tutor.apellidom}}</td> 
                                                    <td align="right">


                                                        <button type="button" class="btn btn-icons btn-danger btn-sm" @click="deleteTutor(tutor.idtutoralumno)"> <i class="fa fa-trash" aria-hidden="true"></i>
                                                          Quitar
                                                        </button> 

                                                    </td>
                                                </tr>
                                                <tr v-if="emptyResult">
                                                    <td colspan="4" class="text-center">No existe Tutor</td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="4" align="right">
                                            <pagination
                                                :current_page="currentPage"
                                                :row_count_page="rowCountPage"
                                                @page-update="pageUpdate"
                                                :total_users="totalTutores"
                                                :page_range="pageRange"
                                                >
                                            </pagination>
                                            </td>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div> 
                            </div>
                            <?php include 'modaltutor.php'; ?>
                        </div>

                        </div>


                      <div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="profile-tab">  
                            <div id="appestadocuenta">
                                <div class="container">
                                  <div class="row">
                                    <div class="col-md-6 col-sm-12 col-xs-12 ">
                                        <div class="form-group"> 
                                             <select v-model="newBuscarCiclo.idperiodo"  ref="idperiodo" :class="{'is-invalid': formValidate.idperiodo}"class="form-control">
                                              <option value="">--Seleccione Ciclo Escolar--</option>
                                                <option   v-for="option in ciclos" v-bind:value="option.idperiodo">
                                                {{ option.mesinicio }}  {{ option.yearinicio }} - {{option.mesfin}}  {{ option.yearfin }}
                                              </option>
                                            </select>
                                        </div>
                                    </div>  
                                    <div class="col-md-6 col-sm-12 col-xs-12 ">
                                        <div class="form-group"> 
                                             <button class="btn btn-primary"  @click.prevent="searchSolicitud()" style="margin-top: 0"><i class="fa fa-search"></i> Buscar</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                  <div v-if="mostrar">
                                  <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12" align="center">
                                      <small style="font-weight: bold;">Pagos de Inscripcion o Reinscripcion</small>
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-xs-12" align="left"> 
                                      <button v-if="btnpagar"   @click="addPagoModal = true;" class="btn btn-info">Pagar</button>
                                    </div>
                                  </div>  
                                     <table class="table table-hover">
                                          <thead style="background-color: #ccc">
                                            <tr>
                                              <th>Descuento</th> 
                                              <th>Forma de Pago</th>
                                              <th>Fecha de Pago</th> 
                                               <th></th>
                                            </tr>
                                          </thead>
                                          <tbody>
                                            <tr v-for="pago in pagos" class="table-default">  
                                               <td><label style="font-weight: bold;">${{pago.descuento}}</label></td> 
                                               <td align="left">
                                                <label class="label label-success">{{pago.nombretipopago}}</label>
                                               </td> 
                                               <td>{{pago.fechapago}}</td> 
                                               <td align="left">
                                                    <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-info waves-effect dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                 Opciones
                                                <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu">  
                                                <li><a href="" ><i class="fa fa-print" style="color:blue;"></i> Imprimir</a></li> 
                                                <li><a href=""> <i class="fa fa-trash" style="color: red;"></i> Eliminar</a></li>  
                                               
                                              
                                            </ul>
                                        </div>
                                               </td> 
                                            </tr> 
                                            <tr v-if="noresultadoinicio">
                                              <td colspan="4" align="center">
                                                No abonado Incripción/Reincripción
                                              </td>
                                            </tr>
                                          </tbody> 
                                        </table>
                                  <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12" align="center">
                                      <small style="font-weight: bold;">Pagos de Colegiaturas</small>
                                    </div>
                                  </div> 
                                       <table class="table table-hover">
                                          <thead style="background-color: #ccc">
                                            <tr>
                                             
                                              <th>Mes</th> 
                                              <th>Descuento</th>
                                              <th>Pagado</th>
                                              <th>Fecha</th>
                                               <th></th>
                                            </tr>
                                          </thead>
                                          <tbody>
                                            <tr v-for="solicitud in solicitudes" class="table-default">
                                               
                                               
                                               <td>{{solicitud.mes}} {{solicitud.year}}</td> 
                                               <td>{{solicitud.descuento}}</td>
                                               <td>
                                                   <span v-if="solicitud.pagado==1" class="label label-success">ABONADO</span>
                                                        <span v-else class="label label-danger">NO ABONADO</span>
                                               </td>
                                               <td>{{solicitud.fecha}}</td>
                                               <td>
                                                 
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-info waves-effect dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                 Opciones
                                                <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu"> 
                                                <li v-if="solicitud.pagado==0"  @click="addModal = true; selectPeriodo(solicitud)"><a href="#" ><i class="fa fa-money" aria-hidden="true"></i> Pagar</a></li> 
                                                <li v-if="solicitud.pagado==1"><a href="" ><i class="fa fa-print"></i> Imprimir</a></li> 
                                                <li v-if="solicitud.pagado==1"><a href=""> <i class="fa fa-trash"></i> Eliminar</a></li>  
                                               
                                              
                                            </ul>
                                        </div>
                                     

                                               </td>
                                            </tr> 
                                            <tr v-if="noresultado">
                                              <td colspan="5" align="center">Sin estado de cuenta</td>
                                            </tr>
                                          </tbody> 
                                        </table>
                  
                                  </div>
                                </div>
                            </div>
                            <?php include 'modal_estadocuenta.php' ?>
                        </div>
                     </div>


                      </div>
                    </div>
                  </div>


                 
                  <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
                  <div class="modal-dialog modal-sm">
                    <div class="modal-content">

                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel2">Asgnar Grupo</h4>
                      </div>
                        <form method="post" id="frmasignargrupo" action="">
                      <div class="modal-body">
                       
                          <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12 ">
                               <div class="alert alert-danger print-error-msg" style="display:none"></div>
                               <div class="alert alert-success print-success-msg" style="display:none"></div>
                                <div class="form-group">
                                    <label><font color="red">*</font> Ciclo Escolar</label>
                                   
                                        <select name="idcicloescolar" required=""  class="form-control" >
                                            <option value="">Seleccionar</option>
                                              <?php if(isset($cicloescolar) && !empty($cicloescolar)){ 
                                                foreach($cicloescolar as $row){
                                                ?>
                                                <option value="<?php echo $row->idperiodo ?>"><?php echo $row->mesinicio." - ".$row->mesfin." ".$row->yearfin ?></option>
                                             
                                              <?php  }  } ?>
                                        </select>
                                   
                                </div>
                                <div class="form-group">
                                    <label><font color="red">*</font> Grupo</label>
                                   
                                        <select name="idgrupo" required=""  class="form-control" >
                                            <option value="">Seleccionar</option>
                                              <?php if(isset($grupos) && !empty($grupos)){ 
                                                foreach($grupos as $row){
                                                ?>
                                                <option value="<?php echo $row->idgrupo ?>"><?php echo $row->nombrenivel." - ".$row->nombregrupo ?></option>
                                             
                                              <?php  }  } ?>
                                        </select>
                                   
                                </div>
                            </div>  
                        </div>
                      
                      </div>
                      <div class="modal-footer">
                         <input type="hidden" name="idalumno" value="<?php echo $id ?>">
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class='fa fa-ban'></i>  Cerrar</button>
                        <button type="button" id="btnasignargrupo" class="btn btn-primary"> <i class='fa fa-floppy-o'></i> Aceptar</button>
                      </div>
                        </form>

                    </div>
                  </div>
                </div>


                  <div class="modal fade bs-example-cambiar-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
                  <div class="modal-dialog modal-sm">
                    <div class="modal-content">

                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel2">Grupo</h4>
                      </div>
                       <form method="post" id="frmcambiargrupo" action="">
                      <div class="modal-body">
                       
                          <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12 ">
                              <div class="alert alert-success print-success-msg" style="display:none"></div>
                              <div class="alert alert-danger print-error-msg" style="display:none"></div>
                                <div class="form-group">
                                    <label><font color="red">*</font> Grupo</label>
                                   
                                        <select name="idgrupo" required=""  class="form-control" >
                                            <option value="">Seleccionar</option>
                                              <?php if(isset($grupos) && !empty($grupos)){ 
                                                foreach($grupos as $row){
                                                ?>
                                                <option value="<?php echo $row->idgrupo ?>"><?php echo $row->nombrenivel." - ".$row->nombregrupo ?></option>
                                             
                                              <?php  }  } ?>
                                        </select>
                                   
                                </div>
                            </div>  
                        </div>
                      
                      </div>
                      <div class="modal-footer">
                        <input type="hidden" name="idalumno" value="<?php echo $id ?>">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" id="btncambiargrupo">Guardar</button>
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
  <script data-my_var_1="<?php echo base_url() ?>" data-my_var_2="<?php echo $id ?>" src="<?php echo base_url(); ?>/assets/vue/appvue/appalumnotutor.js"></script> 
  <script data-my_var_1="<?php echo base_url() ?>" data-my_var_2="<?php echo $id ?>" src="<?php echo base_url(); ?>/assets/vue/appvue/appestadocuenta.js"></script> 

<script type="text/javascript">
    $(document).ready(function() {

        var myform;
        var disabled;
        var serialized;

        $("#btncambiargrupo").click(function(){
 
                myform = $('#frmcambiargrupo');
            // Encuentra entradas deshabilitadas, y elimina el atributo "deshabilitado"
           // disabled = myform.find(':input:disabled').removeAttr('disabled');
            // serializar el formulario
            serialized = myform.serialize();
            $.ajax({
             method: "POST",
             url: "<?php echo site_url('Alumno/cambiarGrupo'); ?>",
             data: serialized,
             beforeSend: function( xhr ) {
                //xhr.overrideMimeType( "text/plain; charset=x-user-defined" );
            }
        }).done(function(data) {
            console.log(data);
             var msg = $.parseJSON(data);
                    console.log(msg.error);
                    if((typeof msg.error === "undefined")){ 
                    $(".print-error-msg").css('display','none'); 
                    // window.location.href = "<?php //echo site_url('hold/index'); ?>";
                    }else{ 
                    $(".print-error-msg").css('display','block'); 
                    $(".print-error-msg").html(msg.error);

                    } 
                     }); 
                    
                });

           $("#btnasignargrupo").click(function(){
 
                myform = $('#frmasignargrupo');
            // Encuentra entradas deshabilitadas, y elimina el atributo "deshabilitado"
           // disabled = myform.find(':input:disabled').removeAttr('disabled');
            // serializar el formulario
            serialized = myform.serialize();
            $.ajax({
             method: "POST",
             url: "<?php echo site_url('Alumno/asignarGrupo'); ?>",
             data: serialized,
             beforeSend: function( xhr ) {
                //xhr.overrideMimeType( "text/plain; charset=x-user-defined" );
                console.log(xhr);
            }
        }).done(function(data) {

          
 var val = $.parseJSON(data);
        //console.log(val.msg);
         console.log(val.error);

          
         if((val.success === "Ok")){ 
          $(".print-success-msg").css('display','block'); 
          $(".print-success-msg").html("Fue asignado al Grupo.");
          setTimeout(function() {
            $('.print-error-msg').fadeOut('fast');
            location.reload(); 
          }, 3000);

        }else{ 
          $(".print-error-msg").css('display','block'); 
          $(".print-error-msg").html(val.error);
          setTimeout(function() {$('.print-error-msg').fadeOut('fast');}, 6000);
        }


                     }); 
                    
                });
          
    
        
 
    });

</script>