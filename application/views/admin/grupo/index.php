<!-- page content -->
<div class="right_col" role="main"> 
    <div class="">  
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 ">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><strong>ADMINISTRAR GRUPOS</strong></h2> 
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content"> 
                        <div id="app">
                            <div class="container">

                                <div class="row">
                                    <div class="col-md-6  col-sm-12 col-xs-12 ">
                                        <button class="btn  btn-primary waves-effect waves-black" @click=" abrirAddModal()"><i class='fa fa-plus'></i> Agregar Grupo</button> 
                                        <a href="<?= base_url('/Grupo/alumnos') ?>"  class="btn btn-icons btn-info btn-sm waves-effect waves-black" ><i class="fa fa-users" aria-hidden="true"></i> Alumnos</a>

                                    </div>
                                    <div class="col-md-6  col-sm-12 col-xs-12 "></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6  col-sm-12 col-xs-12 ">
                                    </div>
                                    <div class="col-md-6  col-sm-12 col-xs-12 ">
                                        <input placeholder="Buscar" type="search" class="form-control btn-round" :autofocus="'autofocus'"  v-model="search.text" @keyup="searchGrupo" name="search">
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12 ">
                                        <table class="table table-hover table-striped">
                                            <thead class="bg-teal">
                                            <th class="text-white" v-column-sortable:nombrenivel>Nivel </th>
                                            <th class="text-white" v-column-sortable:nombregrupo>Grupo </th>
                                             <th class="text-white" v-column-sortable:nombreespecialidad>Especialidad </th>  
                                            <th class="text-white" v-column-sortable:nombreturno>Turno </th>  
                                            <th class="text-center text-white"> </th>
                                            </thead>
                                            <tbody class="table-light">
                                                <tr v-for="row in grupos" class="table-default">
                                                    <td>{{row.nombrenivel}}</td>
                                                    <td>{{row.nombregrupo}}</td>
                                                    <td>{{row.nombreespecialidad}}</td> 
                                                     <td>{{row.nombreturno}}</td> 
                                                    <td align="right">


                                                        <button type="button" class="btn btn-icons btn-success btn-sm waves-effect waves-black" @click=" abrirEditModal(); selectGrupo(row)" title="Modificar Datos"> <i class="fa fa-edit" aria-hidden="true"></i>
                                                            Editar
                                                        </button>  
                                                        <button type="button" class="btn btn-icons btn-danger btn-sm waves-effect waves-black" @click="deleteGrupo(row.idgrupo)" title="Eliminar Datos"> <i class="fa fa-trash" aria-hidden="true"></i>
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
                                                :total_users="totalGrupos"
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
<script data-my_var_1="<?php echo base_url() ?>" src="<?php echo base_url(); ?>/assets/vue/appvue/appgrupo.js"></script> 


