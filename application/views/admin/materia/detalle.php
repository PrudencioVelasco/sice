  <!-- page content -->
      <div class="right_col" role="main">

        <div class=""> 

          <div class="row">
            <div class="col-md-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2><strong>MATERIA SERIADA DE : <?php echo $detalle_materia[0]->nombreclase; ?></strong></h2> 
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
                                        <button class="btn btn-round btn-primary waves-effect waves-black" @click=" abrirAddModal()"><i class='fa fa-plus'></i> Agregar Materia</button> 


                                    </div>
                                    <div class="col-md-6"></div>
                                </div> 
                                <br>
                               <table class="table table-hover table-striped">
                                            <thead class="bg-teal">
                                    <th class="text-white" v-column-sortable:nombrenivel>Materia / Clase</th> 
                                     <th class="text-center text-white"> </th>
                                    </thead>
                                    <tbody class="table-light"> 
                                        <tr v-for="materia in materias" class="table-default">
 
                                            <td>{{materia.nombreclase}}</td> 
                                             
                                            <td align="right">
                                                <button type="button" class="btn btn-success btn-sm" @click="abrirEditModal(); selectMateria(materia)" title="Modificar Datos"> <i class="fa fa-edit" aria-hidden="true"></i>
                                                  Editar
                                                </button> 
                                                 <button type="button" class="btn btn-danger btn-sm" @click="deleteMateria(materia.idmateriaseriada)" title="Eliminar Datos"> <i class="fa fa-trash" aria-hidden="true"></i>
                                                  Eliminar
                                                </button> 
                                            </td>
                                        </tr>
                                        <tr v-if="emptyResult">
                                            <td colspan="2" class="text-center h4">Sin registros</td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="5" align="right">
                                    <pagination
                                        :current_page="currentPage"
                                        :row_count_page="rowCountPage"
                                        @page-update="pageUpdate"
                                        :total_users="totalMaterias"
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
                    <?php include 'modal_detalle.php'; ?>
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
  <script data-my_var_1="<?php echo base_url() ?>" data-my_var_2="<?php echo $id ?>" src="<?php echo base_url(); ?>/assets/vue/appvue/appmateriadetalle.js"></script> 


