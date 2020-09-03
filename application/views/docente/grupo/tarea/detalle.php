<!-- page content -->
<style>
    .ck-content { height:150px; }
</style>
<style>
#axiosForm{  /* Components Root Element ID */
    position: relative;
}
.loader{  /* Loader Div Class */
    position: absolute;
    top:0px;
    right:0px;
    width:100%;
    height:100%;
    background-color:#eceaea;
    background-image: url('assets/ajax-loader.gif');
    background-size: 50px;
    background-repeat:no-repeat;
    background-position:center;
    z-index:10000000;
    opacity: 0.4;
    filter: alpha(opacity=40);
}
</style>
<div class="right_col" role="main">

    <div class="">  
        <div class="row">
            <div class="col-md-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><strong><i class="fa fa-slideshare"></i> TAREA DE: <?php
                                if (isset($detalle_tarea) && !empty($detalle_tarea)) {
                                    echo $detalle_tarea[0]->titulo;
                                }
                                ?></strong></h2>

                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                        <div class="row"> 
                            <div id="appplanificacion">  
                                
                                <div class="row">
                                    <div class="col-md-6">
                                    </div>
                                    <div class="col-md-6">
                                        <input placeholder="Buscar" type="search" class="form-control btn-round" :autofocus="'autofocus'"  v-model="search.text" @keyup="searchAlumnosTareas" name="search">
                                    </div>
                                </div>
                                <br>
                                

                            
                                <table class="table table-hover table-striped">
                                    <thead class="bg-teal">
                                    <th class="text-white" v-column-sortable:apellidop>ALUMNO(A) </th>
                                    <th class="text-white" v-column-sortable:nombreestatus>ESTATUS </th>
                                    <th class="text-white" v-column-sortable:fecharegistro>FECHA ENTREGA </th>  

                                    <th class="text-center text-white"> </th>
                                    </thead>
                                    <tbody class="table-light">
                                      
                                        <tr v-for="row in alumnostareas" class="table-default">
                      
                                            <td><strong>{{row.apellidop}} {{row.apellidom}} {{row.nombre}}</strong></td>
                                            <td>
                                                <span v-if="row.idestatustarea && row.idestatustarea == 1" class="label bg-green">{{row.estatustarea}}</span>
                                                <span v-if="row.idestatustarea && row.idestatustarea != 1"  class="label bg-blue">{{row.estatustarea}}</span>
                                                <span v-if="row.idestatustarea	 == null"  class="label bg-grey">NO ENVIADO</span>
                                            </td>
                                            <td>{{row.fecharegistro}}</td>

                                            <td align="right">


                                                <button  v-if="row.idestatustarea" type="button" class="btn btn-icons btn-default btn-sm waves-effect waves-black" @click=" abrirEditModal(); selectAlumnosTareas(row)" title="Modificar Datos"> <i class="fa fa-edit" aria-hidden="true"></i>
                                                    Detalle
                                                </button>  
                                            </td>
                                        </tr>
                                          <tr v-if="loading">
                                            <td colspan="4" align="center"> 
                                               
                                                <label > <i style="color:#2ca2f9;" class="fa fa-spinner fa-pulse fa-3x fa-fw"></i> Cargando registros...</label>
                                            </td>
                                        </tr>
                                        <tr v-if="emptyResult">
                                            <td colspan="4" class="text-center h4">Sin registros</td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="4" align="right">
                                    <pagination
                                        :current_page="currentPage"
                                        :row_count_page="rowCountPage"
                                        @page-update="pageUpdate"
                                        :total_users="totalAlumnosTareas"
                                        :page_range="pageRange"
                                        >
                                    </pagination>
                                    </td>
                                    </tr>
                                    </tfoot>
                                </table>
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

<script data-my_var_1="<?php echo base_url() ?>" data-my_var_2="<?php echo $idtarea; ?>"  data-my_var_3="<?php echo $idhorario; ?>"  data-my_var_4="<?php echo $idmateria; ?>"  data-my_var_5="<?php echo $idprofesormateria; ?>"  src="<?php echo base_url(); ?>/assets/vue/appvue/docente/tarea/apptarea_detalle.js"></script> 

