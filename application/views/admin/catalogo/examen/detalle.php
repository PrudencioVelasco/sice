<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="row">
            <div class="col-md-12  col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><strong>MESES DEL TRIMESTRE</strong></h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                        <div class="container-fluid">
                            <div id="appmeses">
                                <div class="row">
                                    <div class="col-md-12  col-sm-12 col-xs-12">
                                        <button class="btn btn-round btn-primary waves-effect waves-black" @click="abrirAddModal()"><i class='fa fa-plus'></i> Agregar mes</button>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12 ">
                                        <table class="table table-hover table-striped">
                                            <thead class="bg-teal">
                                                <th class="text-white" v-column-sortable:nombremes> MES </th>
                                                <th class="text-white" v-column-sortable:fechainicio>FECHA DE EVALUACIÓN </th>
                                                <th class="text-center text-white"></th>
                                            </thead>
                                            <tbody class="table-light">
                                                <tr v-for="row in unidadmeses" class="table-default">
                                                    <td>{{row.nombremes}}</td>
                                                    <td>
                                                        <span v-if="row.fechainicioshow  == '00/00/0000'">No registrado</span>
                                                        <span v-else> Del {{row.fechainicioshow}} al {{row.fechafinshow}}</span>
                                                    </td>
                                                    <td align="right">
                                                        <a href="#" class="btn btn-danger" @click="deleteUnidadMes(row.idunidadmes)" title="Eliminar Datos"><i class="fa fa-trash"></i> Eliminar</a>
                                                        <a href="#" class="btn btn-info" @click="abrirEditModal(); selectUnidadMes(row)" title="Modificar Datos"><i class="fa fa-edit"></i> Editar</a>

                                                    </td>
                                                </tr>
                                                <tr v-if="emptyResult">
                                                    <td colspan="3" class="text-center h4">No encontrado</td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="3" align="right">
                                                        <pagination :current_page="currentPage" :row_count_page="rowCountPage" @page-update="pageUpdate" :total_users="totalMeses" :page_range="pageRange">
                                                        </pagination>
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                <?php include 'modal_mes.php'; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script data-my_var_1="<?php echo base_url() ?>" data-my_var_2="<?php echo $idunidad; ?>" src="<?php echo base_url(); ?>/assets/vue/appvue/administrador/catalogo/appmesestrimestre.js"></script>
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