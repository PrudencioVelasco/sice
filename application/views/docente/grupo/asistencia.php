<!-- page content -->
<div class="right_col" role="main">

    <div class="">

        <div class="row">
            <div class="col-md-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><strong>ASISTENCIA DE LOS ALUMNOS - <?php
                                                                if (isset($nombreclase) && !empty($nombreclase)) {
                                                                    echo $nombreclase;
                                                                }
                                                                ?> </strong></h2>

                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12 ">
                                <button type="button" class="btn btn-primary waves-effect m-r-20" data-toggle="modal" data-target="#largeModal"><i class='fa fa-plus'></i> Registrar Asistencia</button>
                                <button type="button" class="btn btn-danger waves-effect m-r-20" data-toggle="modal" data-target="#myModalDeleteAsistencia"><i class='fa fa-trash '></i> Eliminar Asistencia</button>
                                <div class="modal fade" id="largeModal" tabindex="-1" role="dialog">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="largeModalLabel">REGISTRAR ASISTENCIA</h4>
                                            </div>
                                            <form id="frmasistencia">
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                                                            <div class="alert alert-success print-success-msg" style="display:none"></div>
                                                            <div class="alert alert-danger print-error-msg" style="display:none"></div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                                                            <div class="form-group">
                                                                <label>
                                                                    <font color="red">*</font> Fecha
                                                                </label>
                                                                <input type="date" style="border-bottom: solid 1px #ccc;" name="fecha" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                                                            <div class="form-group">
                                                                <label>
                                                                    <font color="red">*</font> Unidad
                                                                </label>
                                                                <select name="unidad" required="" style="border-bottom: solid 1px #ccc;" class="form-control">
                                                                    <option value="">-- SELECCIONAR --</option>
                                                                    <?php
                                                                    if (isset($unidades) && !empty($unidades)) {
                                                                        foreach ($unidades as $value) {
                                                                    ?>
                                                                            <option value="<?php echo $value->idunidad ?>"><?php echo $value->nombreunidad; ?></option>

                                                                    <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                                                            <table class="table">
                                                                <thead class="bg-teal">
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>ALUMNO</th>
                                                                        <th></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                    if (isset($alumnos) && !empty($alumnos)) {
                                                                        $i = 1;
                                                                        foreach ($alumnos as $value) {
                                                                    ?>
                                                                            <input type="hidden" name="idalumno[]" value="<?php echo $value->idalumno ?>">
                                                                            <tr>
                                                                                <td><?php echo $i++ ?></td>
                                                                                <td>
                                                                                    <?php echo $value->apellidop . ' ' . $value->apellidom . ' ' . $value->nombre ?>

                                                                                </td>
                                                                                <td>
                                                                                    <select name="motivo[]" required="" class="form-control">
                                                                                        <option value="">-- SELECCIONAR --</option>
                                                                                        <?php
                                                                                        if (isset($motivo) && !empty($motivo)) {
                                                                                            foreach ($motivo as $value) {
                                                                                        ?>
                                                                                                <option value="<?php echo $value->idmotivo ?>"><?php echo $value->nombremotivo ?></option>
                                                                                        <?php
                                                                                            }
                                                                                        }
                                                                                        ?>
                                                                                    </select>
                                                                                </td>
                                                                            </tr>
                                                                    <?php
                                                                        }
                                                                    } else {
                                                                        echo '<tr><td colspan="3" align="center">Sin registros</td></tr>';
                                                                    }
                                                                    ?>

                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>


                                                </div>
                                                <div class="modal-footer">
                                                    <input type="hidden" name="idhorario" value="<?php echo $idhorario ?>">
                                                    <input type="hidden" name="idhorariodetalle" value="<?php echo $idhorariodetalle ?>">
                                                    <button type="button" id="btnguardar" class="btn btn-primary waves-effect"><i class='fa fa-floppy-o'></i> GUARDAR</button>
                                                    <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal"><i class='fa fa-close'></i> CERRAR</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <hr />
                        <div class="row">
                            <div class="col-md-3 col-sm-12 col-xs-12 "></div>
                            <div class="col-md-9 col-sm-12 col-xs-12 " align="right">
                                <div class="alert alert-danger print-error-msg-1" style="display:none"></div>
                                <form id="frmbuscar">
                                    <div class="row clearfix">
                                        <div class="col-md-4 col-sm-12 col-xs-12 ">
                                            <div class="form-group">
                                                <select name="unidad" style="border-bottom: solid 1px #ccc;" required="" id="unidad" class="form-control">
                                                    <option value="">-- UNIDAD --</option>
                                                    <option value="0">TODOS</option>
                                                    <?php
                                                    if (isset($unidades) && !empty($unidades)) {
                                                        foreach ($unidades as $value) {
                                                    ?>
                                                            <option value="<?php echo $value->idunidad ?>"><?php echo $value->nombreunidad; ?></option>

                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-6">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="date" class="form-control" style="border-bottom: solid 1px #ccc;" name="fechainicio" required="" placeholder="Fecha inicio" id="fechainicio">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-6">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="date" class="form-control" style="border-bottom: solid 1px #ccc;" name="fechafin" placeholder="Fecha fin" required="" id="fechafin">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-md-4 col-sm-4 col-xs-12">
                                            <input type="hidden" name="idhorario" id="idhorario" value="<?php echo $controller->encode($idhorario); ?>">
                                            <input type="hidden" name="idhorariodetalle" id="idhorariodetalle" value="<?php echo $controller->encode($idhorariodetalle); ?>">
                                            <button type="button" id="btnbuscar" class="btn btn-primary"><i class='fa fa-search'></i> BUSCAR</button>
                                        </div>
                                    </div>
                                </form>


                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-4 col-xs-6">
                                <div id="tblalumnos">
                                    <?php
                                    echo $tabla;
                                    ?>
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

<div class="modal fade" id="myModalDeleteAsistencia" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h2 class="modal-title " id="myModalLabel">ELIMINAR ASISTENCIA POR FECHA </h2>
            </div>
            <form method="post" action="" id="frmeliminarasistencia">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">
                            <font color="red">*</font> Fecha:
                        </label>
                        <input class="form-control" style=" border-bottom:solid #ccc 2px; " type="date" name="fechaeliminar" id="fechaeliminar" />
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="horariodetalle" value="<?php echo $idhorariodetalle; ?>">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> CERRAR</button>
                    <button type="button" id="btneliminarasistencia" class="btn btn-primary"><i class="fa fa-trash"></i> ELIMINAR</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title " id="myModalLabel">Alumno: <label id="alumno"></label> </h3>
            </div>
            <form method="post" action="" id="frmmodificar">
                <div class="modal-body">

                    <div class="alert alert-danger print-error-msg" style="display:none"></div>
                    <div class="alert alert-success print-success-msg" style="display:none"></div>
                    <div class="form-group">
                        <input class="form-control idasistencia" type="hidden" name="idasistencia">
                    </div>
                    <div class="form-group">
                        <label>
                            <font color="red">*</font> Opción
                        </label><br>
                        <select name="motivo" style="border-bottom: solid 1px #ccc;" required="" class="form-control">
                            <option value="">-- SELECCIONAR --</option>
                            <?php
                            if (isset($motivo) && !empty($motivo)) {
                                foreach ($motivo as $value) {
                            ?>
                                    <option value="<?php echo $value->idmotivo ?>"><?php echo $value->nombremotivo ?></option>
                            <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> CERRAR</button>
                    <button type="button" id="btnmodificar" class="btn btn-primary"><i class="fa fa-pencil"></i> MODIFICAR</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="myModalDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title " id="myModalLabel">Alumno: <label id="alumnodelete"></label> </h3>
            </div>
            <form method="post" action="" id="frmeliminar">
                <div class="modal-body">
                    <div class="alert alert-danger print-error-msg" style="display:none"></div>
                    <div class="alert alert-success print-success-msg" style="display:none"></div>
                    <div class="form-group">
                        <input class="form-control idasistencia" type="hidden" name="idasistencia">
                    </div>
                    <div class="form-group">
                        <label>
                            <h3>Esta seguro de Eliminar la Asistencia?</h3>
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> CERRAR</button>
                    <button type="button" id="btneliminar" class="btn btn-primary"><i class="fa fa-trash"></i> ELIMINAR</button>
                </div>
            </form>
        </div>
    </div>
</div>



<div id="custom_notifications" class="custom-notifications dsp_none">
    <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
    </ul>
    <div class="clearfix"></div>
    <div id="notif-group" class="tabbed_notifications"></div>
</div>
<script data-my_var_1="<?php echo base_url() ?>" src="<?php echo base_url(); ?>/assets/js/validar/tutor_asistencia.js"></script>


<script type="text/javascript">
    $("#btnbuscar").click(function() {

        var fechainicio = $("#fechainicio").val();
        var fechafin = $("#fechafin").val();
        var unidad = $("#unidad").val();
        var idhorario = $("#idhorario").val();
        var idhorariodetalle = $("#idhorariodetalle").val();

        if (fechainicio != "" && fechafin != "" && unidad != "") {
            window.location = "<?php echo site_url('Pgrupo/buscarAsistencia'); ?>/" + idhorario + '/' + idhorariodetalle + '/' + fechainicio + '/' + fechafin + '/' + unidad + '/';
        } else {
            swal({
                type: 'error',
                title: 'Oops...',
                html: 'Todos los campos son obligatorios.',
                customClass: 'swal-wide',
                footer: ''
            });
        }


    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#tablageneral2').DataTable({
            keys: true,
            "scrollX": true,
            dom: 'Bfrtip',
            buttons: [
                'excelHtml5'
            ],
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