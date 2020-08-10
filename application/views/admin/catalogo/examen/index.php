<!-- page content -->
<div class="right_col" role="main"> 
    <div class="">  
        <div class="row">
            <div class="col-md-12  col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><strong>ADMINISTRAR EXAMENES</strong></h2> 
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content"> 

                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12 ">
                                    <ul class="nav nav-tabs tab-nav-right" role="tablist">
                                        <li role="presentation" class="active"><a href="#unidades" data-toggle="tab">EXAMENES</a></li>
                                        <li role="presentation"><a href="#oportunidades" data-toggle="tab">OPORTUNIDADES</a></li>

                                    </ul>

                                    <!-- Tab panes -->
                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane fade in active" id="unidades">

                                            <div id="appunidades">
                                                <div class="row">
                                                    <div class="col-md-12  col-sm-12 col-xs-12">
                                                        <button class="btn btn-round btn-primary waves-effect waves-black" @click="  abrirAddModal()"><i class='fa fa-plus'></i> Nuevo examen</button> 
                                                    </div>

                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6  col-sm-12 col-xs-12" >
                                                    </div>
                                                    <div class="col-md-6  col-sm-12 col-xs-12" >
                                                        <input placeholder="Buscar" type="search" class="form-control btn-round" :autofocus="'autofocus'" v-model="search.text" @keyup="searchUnidad()" name="search">
                                                    </div>
                                                </div>
                                                <br/>
                                                <div class="row">
                                                    <div  class="col-md-12 col-sm-12 col-xs-12 " >
                                                        <table class="table table-hover table-striped">
                                                            <thead class="bg-teal"> 
                                                            <th class="text-white" v-column-sortable:numero> NÚMERO </th>
                                                            <th class="text-white" v-column-sortable:nombreunidad>EXAMEN </th> 
                                                            <th class="text-center text-white"></th>
                                                            </thead>
                                                            <tbody class="table-light">
                                                                <tr v-for="row in unidades" class="table-default">
                                                                    <td>{{row.numero}}</td> 
                                                                    <td>{{row.nombreunidad}}</td> 
                                                                    <td align="right">
                                                                        <div class="btn-group" role="group">
                                                                            <div class="btn-group" role="group">
                                                                                <button type="button" class="btn btn-info waves-effect dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                    <i class='fa fa-plus'></i>  Opciones
                                                                                    <span class="caret"></span>
                                                                                </button>
                                                                                <ul class="dropdown-menu"> 
                                                                                    <li><a href="#" @click="deleteUnidad(row.idunidad)" title="Eliminar Datos"><i style="color:#fc2222;" class="fa fa-trash"></i> Eliminar</a></li> 
                                                                                    <li><a href="#" @click="abrirEditModal(); selectUnidad(row)" title="Modificar Datos"><i style="color:#789dfc;" class="fa fa-edit"></i> Editar</a></li>

                                                                                </ul>
                                                                            </div>
                                                                        </div>  

                                                                    </td>
                                                                </tr>
                                                                <tr v-if="emptyResult">
                                                                    <td colspan="3" class="text-center h4">No encontrado</td>
                                                                </tr>
                                                            </tbody>
                                                            <tfoot>
                                                                <tr>
                                                                    <td colspan="3" align="right">
                                                            <pagination
                                                                :current_page="currentPage"
                                                                :row_count_page="rowCountPage"
                                                                @page-update="pageUpdate"
                                                                :total_users="totalUnidades"
                                                                :page_range="pageRange"
                                                                >
                                                            </pagination>
                                                            </td>
                                                            </tr>
                                                            </tfoot>
                                                        </table>
                                                        <?php include 'modal.php'; ?>
                                                    </div>
                                                </div>
                                            </div>
                                            </p>
                                        </div>
                                        <div role="tabpanel" class="tab-pane fade" id="oportunidades">

                                            <div id="appoportunidades"> 
                                                <div class="row">
                                                    <div class="col-md-12  col-sm-12 col-xs-12">
                                                        <button class="btn btn-round btn-primary waves-effect waves-black" @click="  abrirAddModal()"><i class='fa fa-plus'></i> Nueva oportunidad</button> 
                                                    </div>

                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6  col-sm-12 col-xs-12" >
                                                    </div>
                                                    <div class="col-md-6  col-sm-12 col-xs-12" >
                                                        <input placeholder="Buscar" type="search" class="form-control btn-round" :autofocus="'autofocus'" v-model="search.text" @keyup="searchOportunidad()" name="search">
                                                    </div>
                                                </div>
                                                <br/>
                                                <div class="row">
                                                    <div  class="col-md-12 col-sm-12 col-xs-12 " >
                                                        <table class="table table-hover table-striped">
                                                            <thead class="bg-teal"> 
                                                            <th class="text-white" v-column-sortable:numero> NÚMERO </th>
                                                            <th class="text-white" v-column-sortable:nombreoportunidad>OPORTUNIDAD </th> 
                                                            <th class="text-center text-white"></th>
                                                            </thead>
                                                            <tbody class="table-light">
                                                                <tr v-for="op in oportunidades" class="table-default">
                                                                    <td>{{op.numero}}</td> 
                                                                    <td>{{op.nombreoportunidad}}</td> 
                                                                    <td align="right">
                                                                        <div class="btn-group" role="group">
                                                                            <div class="btn-group" role="group">
                                                                                <button type="button" class="btn btn-info waves-effect dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                    <i class='fa fa-plus'></i>  Opciones
                                                                                    <span class="caret"></span>
                                                                                </button>
                                                                                <ul class="dropdown-menu"> 
                                                                                    <li><a href="#" @click="deleteOportunidad(op.idoportunidadexamen)" title="Eliminar Datos"><i style="color:#fc2222;" class="fa fa-trash"></i> Eliminar</a></li> 
                                                                                    <li><a href="#" @click="abrirEditModal(); selectOportunidad(op)" title="Modificar Datos"><i style="color:#789dfc;" class="fa fa-edit"></i> Editar</a></li>

                                                                                </ul>
                                                                            </div>
                                                                        </div>  

                                                                    </td>
                                                                </tr>
                                                                <tr v-if="emptyResult">
                                                                    <td colspan="3" class="text-center h4">No encontrado</td>
                                                                </tr>
                                                            </tbody>
                                                            <tfoot>
                                                                <tr>
                                                                    <td colspan="3" align="right">
                                                            <pagination
                                                                :current_page="currentPage"
                                                                :row_count_page="rowCountPage"
                                                                @page-update="pageUpdate"
                                                                :total_users="totalOportunidades"
                                                                :page_range="pageRange"
                                                                >
                                                            </pagination>
                                                            </td>
                                                            </tr>
                                                            </tfoot>
                                                        </table>
                                                        <?php include 'modal_oportunidades.php'; ?>
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
        </div>
    </div>
    <script data-my_var_1="<?php echo base_url() ?>" src="<?php echo base_url(); ?>/assets/vue/appvue/administrador/catalogo/appunidadexamen.js"></script> 
    <script data-my_var_2="<?php echo base_url() ?>" src="<?php echo base_url(); ?>/assets/vue/appvue/administrador/catalogo/appoportunidasexamen.js"></script> 
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

