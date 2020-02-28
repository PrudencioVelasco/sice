  <!-- page content -->
      <div class="right_col" role="main">

        <div class=""> 

          <div class="row">
            <div class="col-md-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2><strong>ADMINISTRAR ALUMNOS</strong></h2> 
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
                                            <div class="col-md-6 col-sm-12 col-xs-12 ">
                                                <button class="btn  btn-primary" @click="addModal= true"><i class='fa fa-plus'></i> Agregar Alumno</button> 


                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12 ">
                                        </div>
                                        <div class="row">
                                             <div class="col-md-6 col-sm-12 col-xs-12 ">
                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12 ">
                                                <input placeholder="Buscar" type="search" class="form-control" v-model="search.text" @keyup="searchAlumno" name="search">
                                            </div>
                                        </div>
                                        <br>
                                        <table class="table table-striped responsive-utilities jambo_table bulk_action">
                                            <thead class="text-white bg-dark" >
                                            <th class="text-white" v-column-sortable:matricula>Matricula </th>
                                            <th class="text-white" v-column-sortable:nombre>Nombre </th>
                                            <th class="text-white" v-column-sortable:apellidop>A. Paterno </th>
                                            <th class="text-white" v-column-sortable:apellidom>A. Materno </th>
                                             <th class="text-center text-white">Opción </th>
                                            </thead>
                                            <tbody class="table-light">
                                                <tr v-for="alumno in alumnos" class="table-default">
                                                  <td>{{alumno.matricula}}</td>
                                                    <td>{{alumno.nombre}}</td>
                                                    <td>{{alumno.apellidop}}</td>
                                                    <td>{{alumno.apellidom}}</td> 
                                                    <td align="right">

                              <div class="btn-group" role="group">
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-primary waves-effect dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class='fa fa-plus'></i>  Opciones
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu"> 
                                            <li ><a href="#" @click="deleteAlumno(alumno.idalumno)" title="Eliminar Datos"><i class="fa fa-trash"></i> Eliminar</a></li> 
                                            <li><a href="#" @click="editModal = true; selectAlumno(alumno)" title="Modificar Datos"><i class="fa fa-edit"></i> Editar</a></li>
                                            <li><a href="#"  @click="editPasswordModal = true; selectAlumno(alumno)" title="Modificar Datos"><i class="fa fa-key"></i>Contraseña</a></li> 
                                            <li><a href="#" v-bind:href="'detalle/'+ alumno.idalumno"><i class="fa fa-list-alt" aria-hidden="true"></i> Detalles</a></li>
                                        </ul>
                                    </div>
                                </div>    

                                                            

                                                    </td>
                                                </tr>
                                                <tr v-if="emptyResult">
                                                    <td colspan="7" class="text-center h4">No encontrado</td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="7" align="center">
                                            <pagination
                                                :current_page="currentPage"
                                                :row_count_page="rowCountPage"
                                                @page-update="pageUpdate"
                                                :total_users="totalAlumnos"
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
  <script data-my_var_1="<?php echo base_url() ?>" src="<?php echo base_url(); ?>/assets/vue/appvue/appalumno.js"></script> 


