<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="row">
            <div class="col-md-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><strong><i class="fa fa-list"></i> KARDEX</strong></h2>

                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="row">
                            <div class="col-md-6 col-sm-12 col-xs-12 ">
                                <h4><strong><?php echo $detalle->nombre . " " . $detalle->apellidop . ' ' . $detalle->apellidom ?></strong>
                                </h4>
                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12 " align="right">
                                <h4><strong>Promedio: <?= $promedio; ?></strong></h4>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <table class="table table-striped ">
                                <thead class="bg-teal">
                                    <tr>
                                        <th>CICLO ESCOLAR</th>
                                        <th>NIVEL</th>
                                        <th>GRUPO</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (isset($kardex) && !empty($kardex)) {
                                        foreach ($kardex as $row) {
                                            ?>
                                    <tr>
                                        <td><strong>
                                                <?php
                                                        echo $row->mesinicio . " " . $row->yearinicio . " - " . $row->mesfin . " " . $row->yearfin;
                                                        ?>
                                            </strong>
                                        </td>
                                        <td><?php echo $row->nombrenivel; ?></td>
                                        <td><?php echo $row->nombregrupo; ?> </td>
                                        <td align="right">
                                            <a class="btn btn-default" 
                                                href="<?php echo site_url('Aalumno/historial/' . $controller->encode($row->idhorario).'/'.$controller->encode($row->idperiodo)) ?>"><i
                                                    class="fa fa-list-alt" style="color: #249dfa;"></i> Calificaciones</a>

                                        </td>
                                    </tr>
                                    <?php }
                                    } else {
                                        echo "<tr><td colspan='4' align='center'>No existe Kardex del alumno.</td></tr>";
                                    } ?>
                                </tbody>
                            </table>



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