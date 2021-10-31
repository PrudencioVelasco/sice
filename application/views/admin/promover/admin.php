<!-- page content -->
<style>
    .modal {
        overflow: auto !important;
    }
</style>
<div class="right_col" role="main">

    <div class="">

        <div class="row">
            <div class="col-md-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><strong>PROMOCIÓN DE ALUMNOS</strong></h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="container">
                            <div class="row">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12 ">
                                        <div class="alert alert-success print-success-msg" style="display:none"></div>
                                        <div class="alert alert-danger print-error-msg" style="display:none"></div>
                                    </div>
                                </div>

                                <form id="frmbuscar">
                                    <div class="row">
                                        <div class="col-md-3 col-sm-12 col-xs-12 ">
                                            <label>
                                                ACTUAL
                                            </label>
                                            <hr />
                                            <div class="form-group">
                                                <label>
                                                    <font color="red">*</font> Grupo/Nivel
                                                </label>
                                                <select name="grupo" class="form-control">
                                                    <option value="">-- SELECCIONAR --</option>
                                                    <?php
                                                    if (isset($grupos) && !empty($grupos)) {
                                                        foreach ($grupos as $value) {
                                                    ?>
                                                            <option value="<?php echo $value->idgrupo ?>"><?php echo $value->nivelgrupo . ' - ' . $value->nombregrupo ?></option>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                                <small>Grupo que quiere Promover.</small>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-12 col-xs-12 ">
                                            <label></label>
                                            <hr />
                                            <div class="form-group">
                                                <label>
                                                    <font color="red">*</font> Ciclo Escolar
                                                </label>
                                                <select name="cicloescolar" class="form-control">
                                                    <option value="">-- SELECCIONAR --</option>
                                                    <?php
                                                    if (isset($cicloescolarinactivo) && !empty($cicloescolarinactivo)) {
                                                        foreach ($cicloescolarinactivo as $value) {
                                                    ?>
                                                            <option value="<?php echo $value->idperiodo ?>"><?php echo $value->mesinicio . '-' . $value->mesfin . ' ' . $value->yearfin ?></option>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                                <small>Ciclo Escolar al cual pasaran los grupos.</small>
                                            </div>
                                        </div>

                                        <div class="col-md-3 col-sm-12 col-xs-12 ">
                                            <label>POSTERIOR</label>
                                            <hr />
                                            <div class="form-group">
                                                <label>
                                                    <font color="red">*</font> Grupo/Nivel
                                                </label>
                                                <select name="grupoposterior" class="form-control">
                                                    <option value="">-- SELECCIONAR --</option>
                                                    <?php
                                                    if (isset($grupos) && !empty($grupos)) {
                                                        foreach ($grupos as $value) {
                                                    ?>
                                                            <option value="<?php echo $value->idgrupo ?>"><?php echo $value->nivelgrupo . ' - ' . $value->nombregrupo ?></option>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                                <small>Grupo que quiere Promover.</small>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-12 col-xs-12 ">
                                            <label></label>
                                            <hr />
                                            <div class="form-group">
                                                <label>
                                                    <font color="red">*</font> Ciclo Escolar
                                                </label>
                                                <select name="cicloescolarposterior" class="form-control">
                                                    <option value="">-- SELECCIONAR --</option>
                                                    <?php
                                                    if (isset($cicloescolaractivo) && !empty($cicloescolaractivo)) {
                                                        foreach ($cicloescolaractivo as $value) {
                                                    ?>
                                                            <option value="<?php echo $value->idperiodo ?>"><?php echo $value->mesinicio . '-' . $value->mesfin . ' ' . $value->yearfin ?></option>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                                <small>Ciclo Escolar al cual pasaran los grupos.</small>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                                            <div class="form-group">
                                                <button type="button" id="btnbuscar" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                                <button type="button" class="btn btn-default" id="btnpromover"> PROMOVER <i class="fa fa-chevron-right"></i></button>
                                                <button type="button" class="btn btn-success" id="btnfinalizar"> FINALIZAR <i class="fa fa-check"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </form>


                            </div>
                            <div class="row" align="center">
                                <div id="cargandopromover"></div>
                            </div>
                            <div class="row" align="center">
                                <div id="cargandofinalizar"></div>
                            </div>
                            <div class="row" align="center">
                                <div id="tabla"></div>
                            </div>



                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="myModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="largeModalLabel">CALIFICACIONES DE: <label id="nombrealumno"></label></h4>
                </div>
                <form id="frmplaneacionmodificar">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12 ">
                                <div class="alert alert-success print-success-msg" style="display:none"></div>
                                <div class="alert alert-danger print-error-msg" style="display:none"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12 ">
                                <div id="tabla_calificaciones"></div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal"><i class='fa fa-close'></i> CERRAR</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalVerUnidades" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="largeModalLabel">CALIFICACIONES DE: <label id="nombreclase"></label></h4>
                </div>
                <form id="frmplaneacionmodificar">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12 ">
                                <div class="alert alert-success print-success-msg" style="display:none"></div>
                                <div class="alert alert-danger print-error-msg" style="display:none"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12 ">
                                <div id="tabla_calificaciones_unidades"></div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal"><i class='fa fa-close'></i> CERRAR</button>
                    </div>
                </form>
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


<script type="text/javascript">
    $(document).on("click", '.edit_button', function(e) {
        var idalumno = $(this).data('idalumno');
        var idhorario = $(this).data('idhorario');
        var alumno = $(this).data('alumno');

        $("#nombrealumno").text(alumno);
        //$('#myModal').modal('show'); 
        var data = 'idalumno=' + idalumno + '&idhorario=' + idhorario;
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Promover/calificaciones'); ?>",
            data: data,
            success: function(data) {
                var val = $.parseJSON(data);
                $('#tabla_calificaciones').html(val.tabla);
                $('#myModal').modal('show');

            }
        })

    });
    $(document).on("click", '.ver_unidades', function(e) {
        var idalumno = $(this).data('idalumno');
        var idhorario = $(this).data('idhorario');
        var idprofesormateria = $(this).data('idprofesormateria');
        var nombreclase = $(this).data('nombreclase');

        $("#nombreclase").text(nombreclase);
        //$('#myModal').modal('show'); 
        var data = 'idalumno=' + idalumno + '&idhorario=' + idhorario + '&idprofesormateria=' + idprofesormateria;
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Promover/calificacionPorUnidad'); ?>",
            data: data,
            success: function(data) {
                var val = $.parseJSON(data);
                $('#tabla_calificaciones_unidades').html(val.tabla);
                $('#modalVerUnidades').modal('show');

            }
        })

    });

    $("#btnbuscar").click(function() {
        $("#btnbuscar").prop('disabled', true);
        $("#btnpromover").prop('disabled', true);
        $("#btnfinalizar").prop('disabled', true);
        $('#tabla').html('<div> <img src="<?php echo base_url(); ?>/assets/loader/principal2.gif" width="100"/> <strong>Espero un momento de favor.</strong></div>');
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Promover/buscar'); ?>",
            data: $('#frmbuscar').serialize(),
            success: function(data) {
                $("#btnbuscar").prop('disabled', false);
                $("#btnpromover").prop('disabled', false);
                $("#btnfinalizar").prop('disabled', false);
                var val = $.parseJSON(data);
                if ((val.success === "Ok")) {

                    $('#tabla').html(val.tabla);
                    $('#grupo').val(val.idgrupo);
                    $('#cicloescolar').val(val.idcicloescolar);

                } else if (val.success === "Error") {
                    $('#tabla').html("");
                    $(".print-error-msg").css('display', 'block');
                    $(".print-error-msg").html(val.error);
                    setTimeout(function() {
                        $('.print-error-msg').fadeOut('fast');
                    }, 6000);
                } else {
                    $('#tabla').html("");
                    $(".print-error-msg").css('display', 'block');
                    $(".print-error-msg").html(val.error);
                    setTimeout(function() {
                        $('.print-error-msg').fadeOut('fast');
                    }, 6000);
                }

            }
        })
    });

    $("#btnpromover").click(function() {
        $("#btnpromover").prop('disabled', true);
        $("#btnbuscar").prop('disabled', true);
        $("#btnfinalizar").prop('disabled', true);
        $('#cargandopromover').html('<div> <img src="<?php echo base_url(); ?>/assets/loader/principal2.gif" width="100"/> <strong>Espero un momento de favor.</strong></div>');

        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Promover/promover'); ?>",
            data: $('#frmbuscar').serialize(),
            success: function(data) {
                var val = $.parseJSON(data);
                $("#btnpromover").prop('disabled', false);
                $("#btnbuscar").prop('disabled', false);
                $("#btnfinalizar").prop('disabled', false);
                if ((val.success === "Exito")) {
                    $('#cargandopromover').html("");
                    $(".print-success-msg").css('display', 'block');
                    $(".print-success-msg").html(val.mensaje);
                    setTimeout(function() {
                        $('.print-success-msg').fadeOut('fast');
                    }, 9000);

                } else if (val.success === "Error") {
                    $(".print-error-msg").css('display', 'block');
                    $(".print-error-msg").html(val.error);
                    setTimeout(function() {
                        $('.print-error-msg').fadeOut('fast');
                    }, 9000);
                    $('#cargandopromover').html("");
                } else {
                    $(".print-error-msg").css('display', 'block');
                    $(".print-error-msg").html(val.error);
                    setTimeout(function() {
                        $('.print-error-msg').fadeOut('fast');
                    }, 9000);
                    $('#cargandopromover').html("");
                }

            }
        })
    });

    $("#btnfinalizar").click(function() {
        $("#btnpromover").prop('disabled', true);
        $("#btnbuscar").prop('disabled', true);
        $("#btnfinalizar").prop('disabled', true);
        $('#cargandofinalizar').html('<div> <img src="<?php echo base_url(); ?>/assets/loader/principal2.gif" width="100"/> <strong>Espero un momento de favor.</strong></div>');

        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Promover/finalizar'); ?>",
            data: $('#frmbuscar').serialize(),
            success: function(data) {
                var val = $.parseJSON(data);
                $("#btnpromover").prop('disabled', false);
                $("#btnbuscar").prop('disabled', false);
                $("#btnfinalizar").prop('disabled', false);
                if ((val.success === "Exito")) {
                    $('#cargandofinalizar').html("");
                    $(".print-success-msg").css('display', 'block');
                    $(".print-success-msg").html(val.mensaje);
                    setTimeout(function() {
                        $('.print-success-msg').fadeOut('fast');
                    }, 9000);

                } else if (val.success === "Error") {
                    $(".print-error-msg").css('display', 'block');
                    $(".print-error-msg").html(val.error);
                    setTimeout(function() {
                        $('.print-error-msg').fadeOut('fast');
                    }, 9000);
                    $('#cargandofinalizar').html("");
                } else {
                    $(".print-error-msg").css('display', 'block');
                    $(".print-error-msg").html(val.error);
                    setTimeout(function() {
                        $('.print-error-msg').fadeOut('fast');
                    }, 9000);
                    $('#cargandofinalizar').html("");
                }

            }
        })
    });
</script>