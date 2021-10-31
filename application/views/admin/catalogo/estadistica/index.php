<!-- page content -->
<div class="right_col" role="main">

    <div class="">

        <div class="row">
            <div class="col-md-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><strong>ESTADISTICAS</strong></h2>
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
                                <div class="row">
                                    <form id="frmbuscar" method="GET" action="<?= base_url(), 'Estadistica/buscar' ?>">
                                        <div class=" col-md-3 col-sm-12 col-xs-12 ">
                                            <div class=" form-group">
                                                <label>
                                                    <font color="red">*</font> T. Estadistica
                                                </label>
                                                <select name="tipografica" class="form-control" required>
                                                    <option value="">-- SELECCIONAR --</option>
                                                    <option value="1">G. Barra de C. por alumno</option>
                                                    <option value="2">G. Barra de C. por grupo</option>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-12 col-xs-12 ">
                                            <div class="form-group">
                                                <label>
                                                    <font color="red">*</font> Grupo/Nivel
                                                </label>
                                                <select name="grupo" class="form-control" required>
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
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-12 col-xs-12 ">
                                            <div class="form-group">
                                                <label>
                                                    <font color="red">*</font> Ciclo Escolar
                                                </label>
                                                <select name="periodo" class="form-control" required>
                                                    <option value="">-- SELECCIONAR --</option>
                                                    <?php
                                                    if (isset($cicloescolar) && !empty($cicloescolar)) {
                                                        foreach ($cicloescolar as $value) {
                                                    ?>
                                                            <option value="<?php echo $value->idperiodo ?>"><?php echo $value->mesinicio . '-' . $value->mesfin . ' ' . $value->yearfin ?></option>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-12 col-xs-12 ">
                                            <div class="form-group">
                                                <button style="margin-top: 24px" type="submit" id="btnbuscar" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                            </div>
                                        </div>
                                    </form>
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