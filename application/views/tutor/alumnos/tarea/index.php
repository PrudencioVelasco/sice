<!-- page content -->
<style>
    .btn:hover{
        color: white;
    }
</style>
<div class="right_col" role="main">
    <div class="">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><strong><i class="fa fa-book"></i> TAREAS</strong></h2>

                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content"> 
                        <div class="row"> 
                            <div id="apptarea">
                                <div class="container">
                                    <div class="row"> 
                                        <div class="col-md-12  col-sm-12 col-xs-12">


                                            <div class="row">
                                                <div class="col-md-6  col-sm-12 col-xs-12">
                                                </div>
                                                <div class="col-md-6  col-sm-12 col-xs-12">
                                                    <input placeholder="Buscar" type="search" class="form-control btn-round" :autofocus="'autofocus'" v-model="search.text" @keyup="searchTarea" name="search">
                                                </div>
                                            </div>
                                            <br>
                                            <table class="table table-hover table-striped">
                                                <thead class="bg-teal">

                                                <th class="text-white" v-column-sortable:titulo>TITULO </th>
                                                <th class="text-white" v-column-sortable:nombreclase>ASIGNATURA </th>
                                                <th class="text-white" v-column-sortable:estatus>ESTATUS </th>
                                                <th class="text-white" v-column-sortable:fechaentrega>ENTREGAR ANTES DE: </th>
                                                <th class="text-center text-white"> </th>
                                                </thead>
                                                <tbody class="table-light">
                                                    <tr v-for="row in tareas" class="table-default"> 
                                                        <td>{{row.titulo}}</td>
                                                        <td>{{row.nombreclase}}</td>
                                                        <td>
                                                            <div v-if="!row.estatus" class="label bg-grey" >NO ENTREGADO</div>
                                                            <div v-if="row.idestatustarea && row.idestatustarea == 1" class="label bg-green" >ENVIADO</div>
                                                            <div v-if="row.idestatustarea && row.idestatustarea != 1" class="label bg-blue" >{{row.estatus}}</div>
                                                        </td>
                                                        <td>{{row.horaentrega}} {{row.fechaentrega}}</td> 
                                                        <td align="right">
                                                            <a class="btn bg-cyan btn-block btn-xs waves-effect waves-black" href="#" v-bind:href="'/Tutores/detalletareav2/'+ row.idtarea+'/'+idhorario+'/'+idalumno">Detalles</a>
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
                                                    :total_users="totalTareas"
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
<script data-my_var_1="<?php echo base_url() ?>" data-my_var_2="<?php echo $controller->encode($idhorario); ?>"  data-my_var_3="<?php echo $controller->encode($idalumno); ?>" src="<?php echo base_url(); ?>/assets/vue/appvue/tutor/tarea/apptarea.js"></script> 
 