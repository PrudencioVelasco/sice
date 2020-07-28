<!-- page content -->
<style>

</style>
<div class="right_col" role="main">

    <div class="">

        <div class="row">
            <div class="col-md-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><strong><i class="fa fa-file-excel-o"></i> MODULO DE REPORTES</strong></h2>

                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12 ">
                                <form method="post" action="<?php echo base_url().'Pgrupo/generarReporter' ?>">
                                    <div class="row clearfix">
                                        <div class="col-md-4 col-sm-12 col-xs-12 ">
                                            <div class="form-group">
                                                <select name="unidad" required="" id="idgrupo" class="form-control ">
                                                    <option value="">-- GRUPO --</option>
                                                    <?php
                                                    if (isset($grupos) && !empty($grupos)) {
                                                        foreach ($grupos as $value) {
                                                            ?>
                                                    <option value="<?php echo $value->idhorariodetalle ?>">
                                                        <?php echo $value->nombrenivel.' '.$value->nombregrupo.' - '.$value->nombreclase; ?>
                                                    </option>

                                                    <?php
                                                        }
                                                        }
                                                        ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <select name="tiporeporte" id="" required class="form-control">
                                                        <option value="">-- TIPO DE REPORTE --</option>
                                                        <option value="1">LISTA DE ALUMNOS</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <!--<div class="col-lg-3 col-md-4 col-sm-4 col-xs-6">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="date" class="form-control" name="fechafin"
                                                        placeholder="Fecha fin" required="" id="fechafin">
                                                </div>
                                            </div>
                                        </div>-->
                                        <div class="col-lg-2 col-md-4 col-sm-4 col-xs-12">
                                            <button type="submit" class="btn btn-primary"><i class='fa fa-download'></i>
                                                DESCARGAR</button>
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