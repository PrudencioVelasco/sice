  <!-- page content -->
      <div class="right_col" role="main">

        <div class=""> 

          <div class="row">
            <div class="col-md-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2><strong>ADMINISTRAR CICLO ESCOLAR</strong></h2> 
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
                                                <button class="btn  btn-primary" @click="addModal= true"><i class='fa fa-plus'></i> Agregar Ciclo Escolar</button> 


                                            </div>
                                            <div class="col-md-6"></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                            </div>
                                            <div class="col-md-6">
                                                <input placeholder="Buscar" type="search" class="form-control" v-model="search.text" @keyup="searchCiclo" name="search">
                                            </div>
                                        </div>
                                        <br>
                                        <table class="table table-striped responsive-utilities jambo_table bulk_action">
                                            <thead class="text-white bg-dark" >
                                            <th class="text-white" v-column-sortable:mesinicio>Mes inicio </th>
                                            <th class="text-white" v-column-sortable:yearinicio>Año inicio </th>
                                            <th class="text-white" v-column-sortable:mesfin>Mes termino </th>
                                            <th class="text-white" v-column-sortable:yearfin>Año termino </th>
                                            <th class="text-white" v-column-sortable:activo>Estado </th>
                                             <th class="text-center text-white">Opción </th>
                                            </thead>
                                            <tbody class="table-light">
                                                <tr v-for="row in ciclos" class="table-default">
                                                  <td>{{row.mesinicio}}</td>
                                                    <td>{{row.yearinicio}}</td>
                                                    <td>{{row.mesfin}}</td>
                                                    <td>{{row.yearfin}}</td> 
                                                    <td>
                                                        <span v-if="row.activo==1" class="label label-success">En proceso</span>
                                                        <span v-else class="label label-danger">Finalizado</span>

                                                    </td>
                                                    <td align="right">


                                                        <button type="button" class="btn btn-icons btn-success btn-sm" @click="editModal = true; selectCiclo(row)" title="Modificar Datos"> <i class="fa fa-edit" aria-hidden="true"></i>
                                                          Editar
                                                        </button>  
                                                         <button type="button" class="btn btn-icons btn-danger btn-sm" @click="deleteCicloEscolar(row.idperiodo)" title="Eliminar Datos"> <i class="fa fa-trash" aria-hidden="true"></i>
                                                          Eliminar
                                                        </button>  

                                                            

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
                                                :total_users="totalCiclos"
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
  <script data-my_var_1="<?php echo base_url() ?>" src="<?php echo base_url(); ?>/assets/vue/appvue/appcicloescolar.js"></script> 


