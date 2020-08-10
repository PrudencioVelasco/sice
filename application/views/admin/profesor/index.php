  <!-- page content -->
      <div class="right_col" role="main">

        <div class=""> 

          <div class="row">
            <div class="col-md-12  col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2><strong>ADMINISTRAR PROFESORES</strong></h2> 
                  <div class="clearfix"></div>
                </div>
                <div class="x_content"> 
                     <div id="app">
                            <div class="container">
                                <div class="row">
                                    <transition
                                        enter-active-class="animated fadeInLeft"
                                        leave-active-class="animated fadeOutRight">
                                        <div class="notification is-success text-center px-5 top-middle" v-if="successMSG" @click="successMSG = false">{{successMSG}}</div>
                                    </transition>
                                    <div class="col-md-12  col-sm-12 col-xs-12">

                                        <div class="row">
                                            <div class="col-md-6  col-sm-12 col-xs-12">
                                                <button class="btn btn-round btn-primary waves-effect waves-black" @click="  abrirAddModal()"><i class='fa fa-plus'></i> Agregar Profesor</button> 


                                            </div>
                                            <div class="col-md-6  col-sm-12 col-xs-12"></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6  col-sm-12 col-xs-12">
                                            </div>
                                            <div class="col-md-6  col-sm-12 col-xs-12">
                                                <input placeholder="Buscar" type="search" class="form-control btn-round" :autofocus="'autofocus'" v-model="search.text" @keyup="searchProfesor" name="search">
                                            </div>
                                        </div>
                                        <br>
                                        <table class="table table-hover table-striped">
                                            <thead class="bg-teal">
                                            <th>Foto</th>  
                                            <th class="text-white" v-column-sortable:cedula>Cédula </th>
                                            <th class="text-white" v-column-sortable:nombre>Nombre </th>
                                            <th class="text-white" v-column-sortable:apellidop>A. Paterno </th>
                                            <th class="text-white" v-column-sortable:apellidom>A. Materno </th>
                                             <th class="text-center text-white">Opción </th>
                                            </thead>
                                            <tbody class="table-light">
                                                <tr v-for="profesor in profesores" class="table-default">
                                                <td>
                                                    <div class="media">
                                                    <div class="media-left">
                                                        <a href="#">
                                                           <img v-if="profesor.foto"  v-bind:src="url_image+profesor.foto" alt="Imagen del Tutor" />
                                                          <img v-else src="<?php echo base_url(); ?>/assets/images/user2.png"  />
                                                      </a>
                                                    </div>
                                                    </div>

                                                 </td> 
                                                <td>{{profesor.cedula}}</td>
                                                    <td>{{profesor.nombre}}</td>
                                                    <td>{{profesor.apellidop}}</td>
                                                    <td>{{profesor.apellidom}}</td> 
                                                    <td align="right">
                                                       <div class="btn-group" role="group">
                                      <div class="btn-group" role="group">
                                          <button type="button" class="btn btn-info waves-effect dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                              <i class='fa fa-plus'></i>  Opciones
                                              <span class="caret"></span>
                                          </button>
                                          <ul class="dropdown-menu"> 
                                              <li><a href="#" @click="deleteProfesor(profesor.idprofesor)" title="Eliminar Datos"><i style="color:#fc2222;" class="fa fa-trash"></i> Eliminar</a></li> 
                                              <li><a href="#" @click="abrirEditModal(); selectProfesor(profesor)" title="Modificar Datos"><i style="color:#789dfc;" class="fa fa-edit"></i> Editar</a></li>
                                              <li><a href="#"  @click=" abrirChangeModal(); selectProfesor(profesor)" title="Cambiar Contraseña"><i style="color:#ecd558;" class="fa fa-key"></i> Contraseña</a></li> 
                                              <li><a href="#" v-bind:href="'detalle/'+ profesor.idprofesor"><i style="color:#000000;" class="fa fa-list-alt" aria-hidden="true"></i> Detalles</a></li>
                                          </ul>
                                      </div>
                                  </div>  

                                                    </td>
                                                </tr>
                                                <tr v-if="emptyResult">
                                                    <td colspan="6" class="text-center h4">No encontrado</td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="6" align="right">
                                            <pagination
                                                :current_page="currentPage"
                                                :row_count_page="rowCountPage"
                                                @page-update="pageUpdate"
                                                :total_users="totalProfesores"
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
                            <?php include 'modal.php'; ?>
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
  <script data-my_var_1="<?php echo base_url() ?>" src="<?php echo base_url(); ?>/assets/vue/appvue/appprofesor.js"></script> 


