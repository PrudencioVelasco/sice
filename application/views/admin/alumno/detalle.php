  <!-- page content -->
      <div class="right_col" role="main">

        <div class=""> 

          <div class="row">
            <div class="col-md-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2><strong>PERFIL DEL ALUMNO</strong></h2> 
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  

                            <div class="col-md-3 col-sm-3 col-xs-12 profile_left">
                    <div id="appdetalle">
                    <div class="profile_img">

                      <!-- end of image cropping -->
                      <div id="crop-avatar">
                        <!-- Current avatar -->
                        <div class="avatar-view"  > 
                          <img  v-if="alumno.foto"   v-bind:src="url_image+alumno.foto" alt="Avatar"> 
                           <img v-else   src="<?php echo base_url(); ?>/assets/images/user2.png"  />
                        </div>
          </div>
                      <!-- end of image cropping -->

                    </div>
                    <h3>{{alumno.nombre}} {{alumno.apellidop}} {{alumno.apellidom}}</h3>

                    <ul class="list-unstyled user_data">
                      <li><i class="fa fa-key" style="color:#d4d209;" ></i> <label>Matricula: {{alumno.matricula}}</label></li>

                      <li>
                        <i class="fa fa-home" style="color:#098fd4;" ></i> <label> 
                        <span v-if="grupo_actual" >{{grupo_actual.nombrenivel}} {{grupo_actual.nombregrupo}} - {{grupo_actual.nombreturno}}</span>
                        <span v-if="!grupo_actual">Grupo no asignado.</span> 
                      </label>
                      </li>
                      <li>
                        <i class="fa fa-check-circle" style="color:#0cb62c;" ></i> <label>Promedio Gral. --- </label>
                      </li>
                      <li>
                        <i class="fa fa-check-circle " style="color:#0cb62c;"></i> <label>{{alumno.nombreespecialidad}}</label>
                      </li>
                      <li>
                        <i class="fa fa-check-circle " style="color:#0cb62c;"></i> <label>Beca: 
                         <span v-if="!beca_actual" >0%</span>
                         <span v-if="beca_actual" >{{beca_actual.descuento}}%</span>
                         
                         </label>
                         <i class="fa fa-pencil" v-if="beca_actual"  @click="abrirEditModalCambiarBeca()"  title="Modificar Beca."></i>  
                          
                      </li> 
                      <li>
                        <button  @click=" abrirAddModalFoto()" class="btn btn-info waves-effect btn-block btn-sm "> <i class="fa fa-cloud-upload" ></i> SUBIR FOTO</button>
                      </li>
                    </ul>

                   <div class="row">
                         <div class="col-md-12 col-sm-12 col-xs-12 " align="left">
                            <div class="form-group">
                               
                                 <button type="button" v-if="!grupo_actual"  @click="abrirAddModalAsignarGrupo()" class="btn btn-default btn-sm  btn-block"><i class="fa fa-plus"></i> ASIGNAR GRUPO</button>
                                <button type="button" v-if="grupo_actual"  @click="abrirEditModalGrupo()" class="btn btn-default btn-sm  btn-block"><i class="fa fa-pencil"></i> CAMBIAR GRUPO</button>
                                 
                            </div>
                        </div>   
                  </div> 
                     <?php include 'modal_detalle_alumno.php' ?>
                                </div>

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
                          <li role="presentation" class=""><a href="#tab_content4" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false"><i class="fa fa-user"></i> <label>D. Alumno(a)</label></a>
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
                                            <li><a href="<?php echo site_url('Alumno/historial/'.$row->idhorario.'/'.$id) ?>"><i class="fa fa-list-alt" aria-hidden="true"></i> Boleta</a></li> 
                                            <li><a href="<?php echo site_url('Alumno/horario/'.$row->idhorario.'/'.$id) ?>"><i class="fa fa-clock-o"></i> Horario</a></li> 
                                           <!-- <li><a href="<?php //echo site_url('alumno/asistencia/'.$row->idhorario.'/'.$id) ?>"> <i class="fa fa-check"></i> Asistencia</a></li>  -->
                                           
                                          
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
                                    <div class="col-md-12">
 
                                        <div class="row">
                                            <div class="col-md-6">
                                               <button class="btn btn-round btn-primary waves-effect waves-black" @click="abrirAddModal()"><i class='fa fa-plus'></i> Asignar Tutor</button> 
                                            </div>
                                            <div class="col-md-6">
                                                <input placeholder="Buscar" :autofocus="'autofocus'" type="search" class="form-control btn-round" v-model="search.text"  @keyup="searchTutor" name="search">
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


                                                        <button type="button" class="btn btn-icons btn-danger btn-sm waves-effect waves-black" @click="deleteTutor(tutor.idtutoralumno)"> <i class="fa fa-trash" aria-hidden="true"></i>
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
                                             <select style="border-bottom: solid #ebebeb 2px;"  v-model="newBuscarCiclo.idperiodo"  ref="idperiodo" :class="{'is-invalid': formValidate.idperiodo}"class="form-control">
                                              <option value="">-- CICLO ESCOLAR --</option>
                                                <option   v-for="option in ciclos" v-bind:value="option.idperiodo">
                                                {{ option.mesinicio }} - {{option.mesfin}}  {{ option.yearfin }}
                                              </option>
                                            </select>
                                            <span v-if="mostrar_error" style="color:red;">Ciclo Escolar requerido</span>
                                        </div>
                                    </div>  
                                    <div class="col-md-6 col-sm-12 col-xs-12 ">
                                  
                                        <div class="form-group" > 
                                        <div v-if="btnbuscar">    
                                        <button   class="btn btn-primary waves-effect waves-black"  @click.prevent="searchSolicitud()" style="margin-top: 0"><i class="fa fa-search"></i> Buscar</button>
                                        </div>     
                                           
                                            <div v-if="loaging_buscar"  >
                                                <img  style="width: 50px;" src="<?php echo base_url() . '/assets/loader/pagos.gif' ?>" alt=""> <strong>Buscando...</strong>
                                            </div>
                                             </div>
                                              
                                    </div>
                                </div>
                                <div class="row">
                                  <div class="col-md-12 col-sm-12 col-xs-12 ">
                                  <div v-if="mostrar">
                                      <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12" v-if="btnpagar" align="left"> 
                                      <button   @click="abrirAddModalPrincipal();" class="btn btn-default waves-effect waves-black"> <i class="fa fa-plus-circle"></i> Agregar Pago</button>
                                    </div>
                                  </div>  
                                  
                                  <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12" align="center">
                                      <small style="font-weight: bold;text-decoration: underline red; ">Pagos de Inscripcion o Reinscripcion</small>
                                    </div>
                                     </div>  
                                   
                                     <table class="table table-hover">
                                          <thead style="background-color: #e3e3df;">
                                            <tr>
                                              <th>Descuento</th> 
                                              <th>Forma de Pago</th>
                                              <th>Estatus</th>
                                              <th>Fecha</th> 
                                               <th></th>
                                            </tr>
                                          </thead>
                                          <tbody>
                                            <tr v-for="pago in pagos" class="table-default">  
                                               <td><label style="font-weight: bold;">{{pago.descuento | currency}}</label></td> 
                                               <td align="left">
                                                <label v-if="pago.idtipopago == 1" class="label label-primary">{{pago.nombretipopago}}</label>
                                                <label  v-else class="label label-default">{{pago.nombretipopago}}</label>
                                               </td> 
                                                <td align="left">
                                                <label v-if="pago.pagado == 1" class="label label-success">PAGADO</label>
                                                <label  v-else class="label label-warning">EN PROCESO</label>
                                               </td> 
                                               <td>{{pago.fechapago}}</td> 
                                               
                                               <td align="left">
                                                    <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-info waves-effect dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                 Opciones
                                                <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu">   
                                                <li><a v-if="pago.pagado==1" ref="#"  @click="abrirEliminarPrincipal(); selectPrimerPago(pago)"> <i class="fa fa-trash" style="color: red;"></i> Eliminar</a></li>  
                                                <li v-if="pago.pagado==1"><a  target="_blank" ref="#"  v-bind:href="'../../EstadoCuenta/imprimir/'+ pago.idpago+'/'+idperiodobuscado+'/'+idalumno+'/0'" ><i class="fa fa-print" style="color:blue;"></i> Imprimir</a></li>  
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
                                        <div class="row" v-if="btnpagarcolegiatura">
                                          <div class="col-md-12 col-sm-12 col-xs-12">
                                            <button class="btn btn-info waves-effect waves-black"  @click="abrirAddModalColegiatura()"> <i class="fa fa-plus-circle"></i> Agregar Pago</button>
                                          </div>
                                        </div>
                                  <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12" align="center">

                                      <small style="font-weight: bold;text-decoration: underline red;  ">Pagos de Colegiaturas</small>
                                    </div>
                                  </div> 
                                       <table class="table table-hover">
                                          <thead style="background-color: #68c5ea">
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
                                               
                                               
                                               <td>{{solicitud.mes}}</td> 
                                               <td><strong>{{solicitud.descuento | currency}}</strong></td>
                                               <td>
                                                   <span v-if="solicitud.pagado==1" class="label label-success">PAGADO</span>
                                                   <span v-else class="label label-warning">EN PROCESO</span>
                                               </td>
                                               <td>{{solicitud.fecha}}</td>
                                               <td>
                                                 
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-info waves-effect dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                 Opciones
                                                <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu">  
                                                 <li  v-if="solicitud.pagado==1"><a  ref="#" @click="abrirEliminarColegiatura() ; selectPeriodo(solicitud)"> <i class="fa fa-trash" style="color: red;"></i> Eliminar</a></li>  
                                                  <li v-if="solicitud.pagado==1"><a  target="_blank" ref="#"  v-bind:href="'../../EstadoCuenta/imprimir/'+ solicitud.idpago+'/'+idperiodobuscado+'/'+idalumno+'/1'" ><i class="fa fa-print" style="color:blue;"></i> Imprimir</a></li>  
                                              
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
                            </div>
                            <?php include 'modal_estadocuenta.php' ?>
                        </div>
                     </div>
                                

                       <div role="tabpanel" class="tab-pane fade" id="tab_content4" aria-labelledby="profile-tab">
                              <div class="row">
                                   <div class="col-md-6 col-sm-12 col-xs-12 ">
                                        <h5 align="center">Datos del Alumno(a)</h5>
                                         <div>
                                           <ul>
                                          <li>  CURP: <label for=""><?php echo $detalle->curp; ?></label> </li>
                                          <li><i class="fa fa-phone"></i> Núm Celular:  <label for=""><?php echo $detalle->telefono; ?></label></li>
                                          <li><i class="fa fa-phone"></i> Núm Emergencia: <label for=""> <?php echo $detalle->telefonoemergencia; ?></label></li>
                                          <li>L. Nacimiento: <label for=""><?php echo $detalle->lugarnacimiento; ?></label></li>
                                          <li>Nacionalidad: <label for=""><?php echo $detalle->nacionalidad; ?></label> </li>
                                          <li>Servicio Medico: <label for=""><?php echo $detalle->serviciomedico; ?></label></li>
                                          <li>Alergia o Padecimiento: <label for=""><?php echo $detalle->alergiaopadecimiento; ?></label></li>
                                           <li>T. Sanguineo: <label for=""><?php echo $detalle->tiposanguineo; ?></label></li>
                                           <li>Peso: <label for=""><?php echo $detalle->peso; ?></label></li>
                                           <li>Estatura: <label for=""><?php echo $detalle->estatura; ?></label></li>
                                           <li>Núm Folio: <label for=""><?php echo $detalle->numfolio; ?></label></li>
                                           <li>Núm Acta: <label for=""><?php echo $detalle->numacta; ?></label></li>
                                           <li>Núm Libro: <label for=""><?php echo $detalle->numlibro; ?></label></li>
                                           <li>F. Nacimiento: <label for=""><?php echo $detalle->fechanacimiento; ?></label></li>
                                           <li>Sexo: <label for=""><?php 
                                                if($detalle->sexo == 1){
                                                  echo "HOMBRE";
                                                }else{
                                                  echo "MUJER";
                                                }
                                           ?></label></li>
                                           <li>Correo: <label for=""><?php echo $detalle->correo; ?></label></li>
                                            <li>Domicilio: <label for=""><?php echo $detalle->domicilio; ?></label></li>
                                      </ul>
                                        </div>
                                   </div>
                                    <div class="col-md-6 col-sm-12 col-xs-12 ">
                                        <h5 align="center">Datos del Tutor</h5>
                                        <?php if(isset($tutores) && !empty($tutores)){
                                          foreach($tutores as $value){
                                          ?>
                                        <ul>
                                          <li>Nombre: <label for=""><?php echo $value->nombre." ".$value->apellidop." ".$value->apellidom ?></label></li>
                                          <li>Escolaridad: <label for=""><?php echo $value->escolaridad; ?></label></li>
                                          <li>Ocupación: <label for=""><?php echo $value->ocupacion; ?></label></li>
                                          <li>Donde Trabaja: <label for=""><?php echo $value->dondetrabaja; ?></label></li>
                                          <li>Telefono: <label for=""><?php echo $value->telefono; ?></label></li>
                                          <li>Correo: <label for=""><?php echo $value->correo; ?></label></li>
                                          <li>Domicilio: <label for=""><?php echo $value->direccion; ?></label></li>
                                        </ul>
                                        <hr>
                                        <?php } } ?>
                                   </div>
                              </div>
                       </div>

                      </div>
                    </div>
                  </div>

                 <!-- MODAL ASIGNAR/MODIFICAR BEVA -->
                  <div class="modal fade bs-beca-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
                  <div class="modal-dialog modal-sm">
                    <div class="modal-content">

                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel2">ASIGNAR BECA</h4>
                      </div>
                        <form method="post" id="frmasignarbeca" action="">
                      <div class="modal-body">
                       
                          <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12 ">
                               <div class="alert alert-danger print-error-msg" style="display:none"></div>
                               <div class="alert alert-success print-success-msg" style="display:none"></div>
                                <div class="form-group">
                                    <label><font color="red">*</font> Beca</label>
                                   
                                        <select style="border-bottom: solid #ebebeb 2px;" name="idbeca" required=""  class="form-control" >
                                            <option value="">-- SELECCIONAR --</option>
                                              <?php if(isset($becas) && !empty($becas)){ 
                                                foreach($becas as $row){
                                                ?>
                                                <option value="<?php echo $row->idbeca ?>"><?php echo $row->descuento.'%'; ?></option>
                                             
                                              <?php  }  } ?>
                                        </select>
                                   
                                </div> 
                            </div>  
                        </div>
                      
                      </div>
                      <div class="modal-footer">
                         <input type="hidden" name="idalumnobeca" value="<?php echo $id ?>">
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class='fa fa-ban'></i>  Cerrar</button>
                        <button type="button" id="btnasignarbeca" class="btn btn-primary"> <i class='fa fa-floppy-o'></i> Aceptar</button>
                      </div>
                        </form>

                    </div>
                  </div>
                </div>
                <!-- FIN MODAL ASIGNAR/MODIFICAR BECA -->
                 <!-- MODAL ASIGNAR GRUPO -->
                  <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
                  <div class="modal-dialog modal-sm">
                    <div class="modal-content">

                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel2">ASIGNAR GRUPO</h4>
                      </div>
                        <form method="post" id="frmasignargrupo" action="">
                      <div class="modal-body">
                       
                          <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12 ">
                               <div class="alert alert-danger print-error-msg" style="display:none"></div>
                               <div class="alert alert-success print-success-msg" style="display:none"></div>
                                <div class="form-group">
                      
                                    <label><font color="red">*</font> Ciclo Escolar</label>
                                   
                                        <select style="border-bottom: solid #ebebeb 2px;" name="idcicloescolar" required=""  class="form-control" >
                                            <option value="">-- SELECCIONAR --</option>
                                              <?php if(isset($cicloescolar) && !empty($cicloescolar)){ 
                                                foreach($cicloescolar as $row){
                                                ?>
                                                <option value="<?php echo $row->idperiodo ?>"><?php echo $row->mesinicio." - ".$row->mesfin." ".$row->yearfin ?></option>
                                             
                                              <?php  }  } ?>
                                        </select>
                                   
                                </div>
                                <div class="form-group">
                                    <label><font color="red">*</font> Grupo</label>
                                   
                                        <select style="border-bottom: solid #ebebeb 2px;" name="idgrupo" required=""  class="form-control" >
                                            <option value="">-- SELECCIONAR --</option>
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
                <!-- FIN MODAL ASIGNAR GRUPO -->

<!--MODAL PARA MOFIFICAR GRUPO-->
                  <div class="modal fade bs-example-cambiar-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
                  <div class="modal-dialog modal-sm">
                    <div class="modal-content">

                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel2">GRUPO</h4>
                      </div>
                       <form method="post" id="frmcambiargrupo" action="">
                      <div class="modal-body">
                       
                          <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12 ">
                              <div class="alert alert-success print-success-msg" style="display:none"></div>
                              <div class="alert alert-danger print-error-msg" style="display:none"></div>
                                <div class="form-group">
                                    <label><font color="red">*</font> Grupo</label>
                                   
                                        <select style="border-bottom: solid #ebebeb 2px;" name="idgrupo" required=""  class="form-control" >
                                            <option value="">-- SELECCIONAR --</option>
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
 <!--FIN DEL MODAL PARA MODIFICAR GRUPO-->

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
  <script src="<?php echo base_url(); ?>/assets/vue/vue2-filters.min.js"></script>
  <script data-my_var_1="<?php echo base_url() ?>" data-my_var_2="<?php echo $id ?>" src="<?php echo base_url(); ?>/assets/vue/appvue/appalumnotutor.js"></script> 
  <script data-my_var_1="<?php echo base_url() ?>" data-my_var_2="<?php echo $id ?>" data-my_var_3="<?php echo $this->session->idrol; ?>" src="<?php echo base_url(); ?>/assets/vue/appvue/appestadocuenta.js"></script> 
  <script data-my_var_1="<?php echo base_url() ?>" data-my_var_2="<?php echo $id ?>"   src="<?php echo base_url(); ?>/assets/vue/appvue/appdetalle_alumno.js"></script> 
  

<script type="text/javascript">
    $(document).ready(function() {

        var myform;
        var disabled;
        var serialized;

        $("#btncambiargrupo").click(function(){
 
            myform = $('#frmcambiargrupo'); 
            serialized = myform.serialize();
            $.ajax({
             method: "POST",
             url: "<?php echo site_url('Alumno/cambiarGrupo'); ?>",
             data: serialized,
             beforeSend: function( xhr ) { 
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
        $("#btnasignarbeca").click(function(){ 
                myform = $('#frmasignarbeca'); 
            serialized = myform.serialize();
            $.ajax({
             method: "POST",
             url: "<?php echo site_url('Alumno/asignarBeca'); ?>",
             data: serialized,
             beforeSend: function( xhr ) {
                //xhr.overrideMimeType( "text/plain; charset=x-user-defined" );
                console.log(xhr);
            }
        }).done(function(data) { 
                      var val = $.parseJSON(data); 
                        if((val.success === "Ok")){ 
                          $(".print-success-msg").css('display','block'); 
                          $(".print-success-msg").html("La beca fue registrada.");
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