<!-- page content -->
<style>
    .ck-content { height:150px; }.
</style>
<div class="right_col" role="main">

    <div class="">  
        <div class="row">
            <div class="col-md-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><strong><i class="fa fa-slideshare"></i> ADMINISTRAR PLANEACIONES</strong></h2>

                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                        <div class="row"> 
                            <div id="appplanificacion">
                                <div class="row">
                                    <div class="col-md-12">
                                        <button class="btn  btn-primary waves-effect waves-black" @click=" abrirAddModal()"><i class='fa fa-plus'></i> Agregar Planeación</button> 
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                    </div>
                                    <div class="col-md-6">
                                        <input placeholder="Buscar" type="search" class="form-control btn-round" :autofocus="'autofocus'"  v-model="search.text" @keyup="searcPlanificacion" name="search">
                                    </div>
                                </div>
                                <br>
                                <table class="table table-hover table-striped">
                                    <thead class="bg-teal">
                                    <th class="text-white" v-column-sortable:nombrenivel>GRUPO </th> 
                                    <th class="text-white" v-column-sortable:nombreclase>MATERIA </th>  
                                     <th class="text-white" v-column-sortable:fechainicio>FECHA </th> 
                                      <th class="text-white" v-column-sortable:documento>DOCUMENTO </th> 

                                    <th class="text-center text-white"> </th>
                                    </thead>
                                    <tbody class="table-light">
                                        <tr v-for="row in planificaciones" class="table-default">
                                            <td>{{row.nombrenivel}} - {{row.nombregrupo}}</td>
                                            <td>{{row.nombreclase}}</td>
                                            <td>{{row.fechainicio}} al {{row.fechafin}}</td>
                                            <td><a target='_blank' v-bind:href="'../../documentos/planeacion/licenciatura/' + row.documento">DESCARGAR</a></td>
                                            <td align="right">


                                                <button type="button" class="btn btn-icons btn-info btn-sm waves-effect waves-black" @click=" abrirEditModal(); selectPlanificacion(row)" title="Modificar Datos"> <i class="fa fa-edit" aria-hidden="true"></i>
                                                    Editar
                                                </button>  
                                                <button type="button" class="btn btn-icons btn-danger btn-sm waves-effect waves-black" @click="deletePlanificacion(row.idplaneacion)" title="Eliminar Datos"> <i class="fa fa-trash" aria-hidden="true"></i>
                                                    Eliminar
                                                </button>  

                                            </td>
                                        </tr>
                                        <tr v-if="emptyResult">
                                            <td colspan="6" class="text-center h4">Sin registros</td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="6" align="right">
                                    <pagination
                                        :current_page="currentPage"
                                        :row_count_page="rowCountPage"
                                        @page-update="pageUpdate"
                                        :total_users="totalPlanificaciones"
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


<script data-my_var_1="<?php echo base_url() ?>" src="<?php echo base_url(); ?>/assets/vue/appvue/docente/planificacion/appplanificacion_licenciatura.js"></script> 


