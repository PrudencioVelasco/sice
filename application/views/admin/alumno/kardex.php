<!-- page content -->
<div class="right_col" role="main">

    <div class="">

        <div class="row">
            <div class="col-md-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><strong>KARDEX DEL ALUMNO(A)</strong></h2>
                        
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                        <div class="row">
                            <div class="col-md-4 col-sm-12 col-xs-12 " align="center">
                                <label>ALUMNO(A): </label><br><label style="color:#000;"><?php echo $datosalumno[0]->nombre . ' ' . $datosalumno[0]->apellidop . ' ' . $datosalumno[0]->apellidom ?></label>
                            </div>
                            <div class="col-md-4 col-sm-12 col-xs-12 " align="center">
                                <label>CICLO ESCOLAR: </label><br><label style="color: #000"> <?php echo $datoshorario->mesinicio . ' ' . $datoshorario->yearinicio . ' - ' . $datoshorario->mesfin . ' ' . $datoshorario->yearfin ?></label>
                            </div>
                            <div class="col-md-4 col-sm-12 col-xs-12 " align="center">
                                <label>GRUPO:</label><br>
                                <label style="color: #000">
                                    <?php
                                    echo $datoshorario->nivelgrupo . ' ' . $datoshorario->nombregrupo . ' - ' . $datoshorario->nombreturno;
                                    ?>
                                </label>
                            </div>

                        </div>
                        <br>
                        <div class="row">
                            <?php
                            if (isset($tabla) && !empty($tabla)) {
                                echo $tabla;
                            }
                            ?>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12 " align="right">
                                <?php
                              //  if (isset($calificacion) && !empty($calificacion)) {
                                    ?>
                                 <!--  <a target="_blank" href="<?php //echo site_url('Alumno/imprimirkardex/' . $controller->encode($idhorario) . '/' . $controller->encode($idalumno)) ?>" class="btn btn-primary"><i class="fa fa-print"></i> IMPRIMIR KARDEX</a>-->
                                    <?php
                               // }
                                ?>

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