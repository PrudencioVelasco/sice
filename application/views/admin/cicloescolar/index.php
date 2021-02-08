  <!-- page content -->
  <div class="right_col" role="main">

    <div class="">

      <div class="row">
        <div class="col-md-12  col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h2><strong>ADMINISTRAR PERIODOS ESCOLARES</strong></h2>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">

              <div class="row">

                <div id="app">

                  <div class="container">
                    <div class="row">
                      <div class="col-md-12  col-sm-12 col-xs-12">

                        <div class="row">
                          <div class="col-md-6  col-sm-12 col-xs-12">
                            <button class="btn  btn-primary waves-effect waves-black" @click="abrirAddModal()"><i class='fa fa-plus'></i> Agregar Periodo Escolar</button>


                          </div>
                          <div class="col-md-6  col-sm-12 col-xs-12"></div>
                        </div>
                        <div class="row">
                          <div class="col-md-6  col-sm-12 col-xs-12">
                          </div>
                          <div class="col-md-6  col-sm-12 col-xs-12">
                            <input placeholder="Buscar" type="search" class="form-control btn-round waves-effect waves-black" :autofocus="'autofocus'" v-model="search.text" @keyup="searchCiclo" name="search">
                          </div>
                        </div>
                        <br>
                        <table class="table table-hover table-striped">
                          <thead class="bg-teal">
                            <th class="text-white" v-column-sortable:mesinicio>Periodo </th>
                            <th class="text-white" v-column-sortable:descripcion>Descripción </th>
                            <th class="text-white" v-column-sortable:activo>Estado </th>
                            <th class="text-center text-white"> </th>
                          </thead>
                          <tbody class="table-light">
                            <tr v-for="row in ciclos" class="table-default">
                              <td>{{row.mesinicio}} {{row.yearinicio}} - {{row.mesfin}} {{row.yearfin}}</td>
                              <td>{{row.descripcion}}</td>
                              <td>

                                <span v-if="row.activo==1" class="label label-success">En proceso</span>
                                <span v-else class="label label-danger">Finalizado</span>

                              </td>
                              <td align="right">


                                <button type="button" class="btn btn-icons btn-success btn-sm waves-effect waves-black" @click="abrirEditModal(); selectCiclo(row)" title="Modificar Datos"> <i class="fa fa-edit" aria-hidden="true"></i>
                                  Editar
                                </button>
                                <button type="button" class="btn btn-icons btn-danger btn-sm waves-effect waves-black" @click="deleteCicloEscolar(row.idperiodo)" title="Eliminar Datos"> <i class="fa fa-trash" aria-hidden="true"></i>
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
                                <pagination :current_page="currentPage" :row_count_page="rowCountPage" @page-update="pageUpdate" :total_users="totalCiclos" :page_range="pageRange">
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