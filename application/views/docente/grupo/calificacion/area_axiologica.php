<!-- page content -->
<div class="right_col" role="main">

    <div class="">

        <div class="row">
            <div class="col-md-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><strong>CALIFICACIONES DE ÁREA AXIOLÓGICA- <?php
                                                                        if (isset($nombreclase) && !empty($nombreclase)) {
                                                                            echo $nombreclase;
                                                                        }
                                                                        ?></strong></h2>

                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12 ">
                                <button type="button" class="btn btn-primary waves-effect m-r-20" data-toggle="modal" data-target="#largeModal" data-backdrop="static" data-keyboard="false"><i class='fa fa-plus'></i> Registrar</button>
                                <button type="button" class="btn btn-danger waves-effect m-r-20" data-toggle="modal" data-target="#myModalDeleteAsistencia" data-backdrop="static" data-keyboard="false"><i class='fa fa-trash '></i>
                                    Eliminar</button>

                            </div>

                        </div>
                        <br>
                        <div class="modal fade" id="myModalDeleteAsistencia" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h2 class="modal-title " id="myModalLabel">ELIMINAR CALIFICACIÓN POR UNIDAD
                                        </h2>
                                    </div>
                                    <form method="post" action="" id="frmeliminarcalificacion">
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="">
                                                    <font color="red">*</font> Unidad:
                                                </label>
                                                <select style="border-bottom: solid 2px #ccc;" class="form-control" name="unidad">
                                                    <option value="">-- SELECCIONAR --</option>
                                                    <?php
                                                    if (isset($unidades) && !empty($unidades)) {
                                                        foreach ($unidades as $row) {
                                                    ?>
                                                            <option value="<?php echo $row->idunidad ?>">
                                                                <?php echo $row->nombreunidad; ?></option>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="">
                                                    <font color="red">*</font> Mes:
                                                </label>
                                                <select style="border-bottom: solid 2px #ccc;" class="form-control" name="meseliminar">
                                                    <option value="">-- SELECCIONAR --</option>
                                                    <?php
                                                    if (isset($mes) && !empty($mes)) {
                                                        foreach ($mes as $row) {
                                                    ?>
                                                            <option value="<?php echo $row->idmes ?>">
                                                                <?php echo $row->nombremes ?></option>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="hidden" name="horariodetalle" value="<?php echo $idhorariodetalle; ?>">
                                            <button type="button" class="btn btn-danger cerrarventana"><i class="fa fa-times"></i> CANCELAR</button>
                                            <button type="button" id="btneliminarcalificacion" class="btn btn-primary"><i class="fa fa-trash"></i> ELIMINAR</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="largeModal" tabindex="-1" role="dialog">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="largeModalLabel">REGISTRAR CALIFICACIÓN</h4>
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
                                                            <font color="red">*</font> Unidad
                                                        </label>
                                                        <select style="border-bottom: solid 2px #ccc;" class="form-control" name="unidad">
                                                            <option value="">-- SELECCIONAR --</option>
                                                            <?php
                                                            if (isset($unidades) && !empty($unidades)) {
                                                                foreach ($unidades as $row) {
                                                            ?>
                                                                    <option value="<?php echo $row->idunidad ?>">
                                                                        <?php echo $row->nombreunidad ?></option>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-12 col-xs-12 ">
                                                    <div class="form-group">
                                                        <label>
                                                            <font color="red">*</font> Mes
                                                        </label>
                                                        <select style="border-bottom: solid 2px #ccc;" class="form-control" name="mes">
                                                            <option value="">-- SELECCIONAR --</option>
                                                            <?php
                                                            if (isset($mes) && !empty($mes)) {
                                                                foreach ($mes as $row) {
                                                            ?>
                                                                    <option value="<?php echo $row->idmes ?>">
                                                                        <?php echo $row->nombremes ?></option>
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
                                                    <small><strong>Nota:</strong> Solo agregue la calificación a los alumnos que quiera.</small>
                                                    <table class="table table-striped  ">
                                                        <thead class="bg-teal">
                                                            <tr>
                                                                <th>#</th>
                                                                <th>ALUMNO</th>
                                                                <th></th>
                                                                <th></th>
                                                                <th></th>
                                                                <th></th>
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
                                                                        <?php
                                                                        if ($value->opcion == 0) {
                                                                            echo '<td  style="color:red;">';
                                                                        } else {
                                                                            echo '<td>';
                                                                        }
                                                                        ?>
                                                                        <?php echo $value->apellidop . ' ' . $value->apellidom . ' ' . $value->nombre ?>

                                                                        </td>
                                                                        <td>
                                                                            <input type="text" name="asistencia[]" class="form-control" placeholder="Asistencia">
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" name="puntualidad[]" class="form-control" placeholder="Puntualidad">
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" name="presentacionpersonal[]" class="form-control" placeholder="Presentación Personal">
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" name="responsabilidad[]" class="form-control" placeholder="Responsabilidad">
                                                                        </td>
                                                                    </tr>
                                                            <?php
                                                                }
                                                            } else {
                                                                echo '<tr><td colspan="3" align="center">Sin alumnos</td></tr>';
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
                                            <button type="button" class="btn btn-danger waves-effect cerrarventana"><i class='fa fa-close'></i> CANCELAR</button>
                                            <button type="button" id="btnguardar" class="btn btn-primary waves-effect"><i class='fa fa-floppy-o'></i>
                                                GUARDAR</button>

                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12 " align="right">
                                <small>*Tiene 3 dias para modificar/eliminar las calificaciones despues de haberla
                                    registrado.</small>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12 ">
                                <div id="tblalumnos">
                                    <?php
                                    if (isset($tabla)) {
                                        echo $tabla;
                                    }
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

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title " id="myModalLabel">ALUMNO: <label id="alumno"></label> </h3>
            </div>
            <form method="post" action="" id="frmmodificar">
                <div class="modal-body">

                    <div class="alert alert-danger print-error-msg" style="display:none"></div>
                    <div class="alert alert-success print-success-msg" style="display:none"></div>
                    <div class="form-group">
                        <input class="form-control idcalificacion" type="hidden" name="idcalificacion">
                        <input class="iddetallecalificacion" type="hidden" name="iddetallecalificacion" />
                    </div>
                    <div class="row">
                        <div class="col-md-3 col-sm-12 col-xs-12 ">
                            <div class="form-group">
                                <label>
                                    <font color="red">*</font> Proyecto
                                </label>
                                <input type="number" style="border-bottom: solid 1px #ccc; border-top: solid 1px #ccc; border-left: solid 1px #ccc; border-right: solid 1px #ccc; padding: 0 5px 0 5px;" class="form-control pproyecto" name="proyecto">
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12 col-xs-12 ">
                            <div class="form-group">
                                <label>
                                    <font color="red">*</font> T. Casa
                                </label>
                                <input type="number" style="border-bottom: solid 1px #ccc; border-top: solid 1px #ccc; border-left: solid 1px #ccc; border-right: solid 1px #ccc;  padding: 0 5px 0 5px;" class="form-control ptarea" name="tarea">
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12 col-xs-12 ">
                            <div class="form-group">
                                <label>
                                    <font color="red">*</font> Participación
                                </label>
                                <input type="number" style="border-bottom: solid 1px #ccc; border-top: solid 1px #ccc; border-left: solid 1px #ccc; border-right: solid 1px #ccc;  padding: 0 5px 0 5px;" class="form-control pparticipacion" name="participacion">
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12 col-xs-12 ">
                            <div class="form-group">
                                <label>
                                    <font color="red">*</font> Examen
                                </label>
                                <input type="number" style="border-bottom: solid 1px #ccc; border-top: solid 1px #ccc; border-left: solid 1px #ccc; border-right: solid 1px #ccc;  padding: 0 5px 0 5px;" class="form-control pexamen" name="examen">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i>
                        CERRAR</button>
                    <button type="button" id="btnmodificar" class="btn btn-primary"><i class="fa fa-pencil"></i>
                        MODIFICAR</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="myModalDetalle" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title " id="myModalLabel">ALUMNO: <label id="alumno_detalle"></label> </h3>
            </div>
            <form method="post" action="" id="frmdetalle">
                <div class="modal-body">

                    <div class="alert alert-danger print-error-msg" style="display:none"></div>
                    <div class="alert alert-success print-success-msg" style="display:none"></div>
                    <div class="form-group">
                        <input class="form-control idcalificacion" type="hidden" name="idcalificacion">
                        <input class="iddetallecalificacion" type="hidden" name="iddetallecalificacion" />
                    </div>
                    <div class="row">
                        <div class="col-md-3 col-sm-12 col-xs-12 ">
                            <div class="form-group">
                                <label>
                                    <font color="red">*</font> Proyecto
                                </label>
                                <h3 class="pproyecto_calificacion"></h3>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12 col-xs-12 ">
                            <div class="form-group">
                                <label>
                                    <font color="red">*</font> T. Casa
                                </label>
                                <h3 class="ptarea_calificacion"></h3>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12 col-xs-12 ">
                            <div class="form-group">
                                <label>
                                    <font color="red">*</font> Participación
                                </label>
                                <h3 class="pparticipacion_calificacion"></h3>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12 col-xs-12 ">
                            <div class="form-group">
                                <label>
                                    <font color="red">*</font> Examen
                                </label>
                                <h3 class="pexamen_calificacion">%</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i>
                        CERRAR</button>
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
                <h3 class="modal-title " id="myModalLabel">ALUMNO: <label id="alumnodelete"></label> </h3>
            </div>
            <form method="post" action="" id="frmeliminar">
                <div class="modal-body">
                    <div class="alert alert-danger print-error-msg" style="display:none"></div>
                    <div class="alert alert-success print-success-msg" style="display:none"></div>
                    <div class="form-group">
                        <input class="form-control idcalificacion" type="hidden" name="idcalificacion">
                        <input class="iddetallecalificacion" type="hidden" name="iddetallecalificacion" />
                    </div>
                    <div class="form-group">
                        <label>
                            <h3>Esta seguro de Eliminar la Calificación?</h3>
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i>
                        Cerrar</button>
                    <button type="button" id="btneliminar" class="btn btn-primary"><i class="fa fa-trash"></i>
                        Eliminar</button>
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
<script type="text/javascript">

</script>
<script data-my_var_1="<?php echo base_url() ?>" src="<?php echo base_url(); ?>/assets/js/validar/examen_area_axiologica.js"></script>


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