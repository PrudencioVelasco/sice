  <!-- page content -->
      <div class="right_col" role="main">

        <div class=""> 

          <div class="row">
            <div class="col-md-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2><strong>ADMINISTRAR TUTORES</strong></h2>
                  
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">

                  <div class="row"> 

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
                                                <button class="btn btn-primary" @click="addModal= true"><i class='fa fa-plus'></i> Agregar Tutor</button> 


                                            </div>
                                            <div class="col-md-6"></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                            </div>
                                            <div class="col-md-6">
                                                <input placeholder="Buscar" :autofocus="'autofocus'" type="search" class="form-control btn-round" v-model="search.text" @keyup="searchTutor" name="search">
                                            </div>
                                        </div>
                                        <br>
                                        <table class="table table-striped responsive-utilities jambo_table bulk_action">
                                            <thead class="text-white bg-dark" >

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

  <div class="btn-group" role="group">
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-primary waves-effect dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class='fa fa-plus'></i>  Opciones
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu"> 
                                            <li ><a href="#" @click="deleteTutor(tutor.idtutor)" title="Eliminar Datos"><i class="fa fa-trash"></i> Eliminar</a></li> 
                                            <li><a href="#"@click="editModal = true; selectTutor(tutor)" title="Modificar Datos"><i class="fa fa-edit"></i> Editar</a></li>
                                            <li><a href="#"  @click="editPasswordModal = true; selectTutor(tutor)" title="Modificar Datos"><i class="fa fa-key"></i>      Contraseña</a></li> 
                                            <li> <a v-bind:href="'alumnos/'+ tutor.idtutor" ><i class="fa fa-graduation-cap" aria-hidden="true"></i> Alumno(s)</a></li>
                                        </ul>
                                    </div>
                                </div> 

                                                    </td>
                                                </tr>
                                                <tr v-if="emptyResult">
                                                    <td colspan="5" class="text-center h4">No encontrado</td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="5" align="right">
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
                            <?php include 'modal.php'; ?>
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
  <script data-my_var_1="<?php echo base_url() ?>" src="<?php echo base_url(); ?>/assets/vue/appvue/apptutor.js"></script> 


