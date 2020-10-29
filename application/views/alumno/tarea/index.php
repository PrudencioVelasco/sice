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
                        <h2><strong><i class="fa fa-book"></i> TAREAS Y MENSAJES</strong></h2>

                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content"> 
                     <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">

                           <?php if (isset($_SESSION['informacion_exito'])): ?>
                            <div class="alert alert-success" role="alert">
                                <h4 class="alert-heading">EXITO!</h4>
                                <p>SE CAMBIO LA CONTRASEÑA CON EXITO.</p> 
                            </div>
                        <?php endif ?>
                    </div>  
                </div>
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
                                            <?php if(isset($this->session->idniveleducativo) && !empty($this->session->idniveleducativo) && $this->session->idniveleducativo != 2 ){ ?>
                                            <th class="text-white" v-column-sortable:calificacion>CALIFICACIÓN </th>
                                            <?php } ?>
                                            <th class="text-white" v-column-sortable:estatus>ESTATUS </th>
                                            <th class="text-center text-white"> </th>
                                        </thead>
                                        <tbody class="table-light">
                                            <tr v-for="row in tareas" class="table-default"> 
                                                <td>{{row.titulo}}</td>
                                                <td>{{row.nombreclase}}</td>
                                                <?php if(isset($this->session->idniveleducativo) && !empty($this->session->idniveleducativo) && $this->session->idniveleducativo != 2 ){ ?>
                                                 <td>{{row.calificacion}}</td> 
                                                  <?php } ?>
                                                <td>
                                                     
                                                    <div v-if="row.estatus > 0 " class="label bg-green" >ENVIADO</div> 
                                                    <div v-else class="label bg-grey" >NO ENTREGADO</div>
                                                </td>
                                               
                                                <td align="right">
                                                    <a class="btn bg-cyan btn-block btn-xs waves-effect waves-black" href="#" v-bind:href="'detalletarea/'+ row.idtarea+'/'+idhorario">Detalles</a>
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
                        <div class="row">
                            <div class="col-md-12  col-sm-12 col-xs-12">
                                <table id="" class="table table-striped  datatabletarea">
                                    <thead class="bg-teal"> 
                                        <tr>
                                            <th>#</th>
                                            <th>ASIGNATURA</th>
                                            <th>MENSAJE</th>  
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (isset($mensajes) && !empty($mensajes)) {
                                            $i = 1;
                                            foreach ($mensajes as $value) {
                                                $value->mensaje;
                                                $space = strrpos($value->mensaje, ' ');
                                                substr($value->mensaje, 0, $space)
                                                ?>
                                                <tr>
                                                    <th scope="row"><?php echo $i++; ?></th>
                                                    <td>
                                                        <?php
                                                        if ($value->idnotificacionalumno == 1) {
                                                            echo '<span class="label bg-light-blue">No leido</span> ';
                                                        } else {
                                                            echo '<span class="label bg-grey">Leido</span> ';
                                                        }
                                                        ?>
                                                        <strong><?php echo $value->nombreclase; ?></strong></td>
                                                        <td><?php
                                                        if (strlen($value->mensaje) > 20) {
                                                            echo $cadena = substr($value->mensaje, 0, 50) . "...";
                                                            ?>
                                                            <a href=""></a>
                                                            <a href="<?php echo site_url('Aalumno/detallemensaje/' . $controller->encode($value->idmensaje)); ?>"> LEER MAS... </a>
                                                            <?php
                                                        } else {
                                                            echo $value->mensaje;
                                                        }
                                                        ?>
                                                    </td>  
                                                </tr>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
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
<script data-my_var_1="<?php echo base_url() ?>" data-my_var_2="<?php echo $controller->encode($idhorario); ?>" data-my_var_3="<?php echo $controller->encode($idalumno); ?>" src="<?php echo base_url(); ?>/assets/vue/appvue/alumno/tarea/apptarea.js"></script> 


<script type="text/javascript">
    $(document).ready(function () {
        $('.datatabletarea').DataTable({
            "scrollX": false,
            "order": [[0, "desc"]],
            "language": {
                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Ningún dato disponible en esta tabla",
                "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix": "",
                "sSearch": "Buscar:",
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            }
        });

    });
</script>