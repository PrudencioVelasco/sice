<!-- page content -->
<div class="right_col" role="main">

    <div class=""> 

        <div class="row">
            <div class="col-md-12  col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><strong>ADMINISTRAR HORARIO DE CLASES</strong></h2> 
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                        <div id="app">
                            <div class="container">
                                <div class="row"> 
                                    <div class="col-md-12  col-sm-12 col-xs-12">

                                        <div class="row">
                                            <div class="col-md-6  col-sm-12 col-xs-12">
                                                <button class="btn btn-round btn-primary waves-effect waves-black"  @click=" abrirAddModal() "><i class='fa fa-plus'></i> Agregar Horario</button> 


                                            </div>
                                            <div class="col-md-6  col-sm-12 col-xs-12"></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6  col-sm-12 col-xs-12">
                                            </div>
                                            <div class="col-md-6  col-sm-12 col-xs-12">
                                                <input placeholder="Buscar" type="search" class="form-control btn-round" :autofocus="'autofocus'"  v-model="search.text" @keyup="searchHorario" name="search">
                                            </div>
                                        </div>
                                        <br>
                                        <table class="table table-hover table-striped">
                                            <thead class="bg-teal">

                                            <th class="text-white" v-column-sortable:mesinicio>Periodo Escolar </th>
                                            <th class="text-white" v-column-sortable:nombrenivel>Nivel </th>
                                            <th class="text-white" v-column-sortable:nombregrupo>Turno </th>
                                            <th class="text-white" v-column-sortable:nombreespecialidad>Especialidad </th>
                                            <th class="text-white" v-column-sortable:activo>Proceso </th>
                                            <th class="text-center text-white">Opción </th>
                                            </thead>
                                            <tbody class="table-light">
                                                <tr v-for="horario in horarios" class="table-default">

                                                    <td>{{horario.mesinicio}} - {{horario.mesfin}} {{horario.yearfin}}</td>
                                                    <td>
                                                    <label v-if="horario.idniveleducativo == 3 || horario.idniveleducativo == 5"> {{horario.numeroromano}}  {{horario.nombregrupo}}</label>
                                                    <label v-else> {{horario.numeroordinaria}}  {{horario.nombregrupo}}</label>
                                                   
                                                    
                                                    </td>
                                                    <td>{{horario.nombreturno}}</td>
                                                     <td>{{horario.nombreespecialidad}}</td>
                                                    <td>

                                                        <span v-if="horario.activo==1" class="label label-success">En proceso</span>
                                                        <span v-else class="label label-danger">Finalizado</span>
                                                    </td>
                                                    <td align="right">
                                                    <div class="btn-group" role="group">
                                                    <div class="btn-group" role="group">
                                                        <button type="button" class="btn btn-info waves-effect dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class='fa fa-plus'></i>  Opciones
                                                            <span class="caret"></span>
                                                        </button>
                                                        <ul class="dropdown-menu"> 
                                                            <li ><a href="#" @click="deleteHorario(horario.idhorario)"  title="Eliminar Datos"><i style="color:#fc2222;" class="fa fa-trash"></i> Eliminar</a></li> 
                                                            <li><a href="#" @click=" abrirEditModal(); selectHorario(horario)" title="Modificar Datos"><i style="color:#789dfc;" class="fa fa-edit"></i> Editar</a></li>
                                                            <li><a href="#" v-bind:href="'detalle/'+ horario.idhorario"><i style="color:#000000;" class="fa fa-list-alt" aria-hidden="true"></i> Detalles</a></li>
                                                        </ul>
                                                    </div>
                                                </div>

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
                                                :total_users="totalHorarios"
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
<script data-my_var_1="<?php echo base_url() ?>" src="<?php echo base_url(); ?>/assets/vue/appvue/apphorario.js"></script> 


