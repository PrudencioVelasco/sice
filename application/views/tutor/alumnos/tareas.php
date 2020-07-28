<!-- page content -->
<div class="right_col" role="main">

    <div class="">

        <div class="row">
            <div class="col-md-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><strong>TAREAS PARA EL ALUMNO</strong></h2>

                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                        <div class="row">

                            <table id="tutor_tarea" class="table table-striped  ">
                                <thead class="bg-teal">
                                    <tr>
                                        <th>#</th>
                                        <th>MATERIA</th>
                                        <th>TAREA</th>
                                        <th>FECHA DE ENTREGA</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (isset($tareas) && !empty($tareas)) {
                                        $i = 1;
                                        foreach ($tareas as $value) {
                                            ?>
                                            <tr>
                                                <th scope="row"><?php echo $i++; ?></th>
                                                <td scope="row">
                                                    <?php echo $value->nombreclase ?><br><small><strong><?php echo $value->nombre . " " . $value->apellidop . " " . $value->apellidom; ?></strong></small>
                                                </td>
                                                <td>
                                                    <?php
                                                    if (strlen($value->tarea) > 50) {
                                                        echo $cadena = substr($value->tarea, 0, 50);
                                                        ?> <a href=""></a>
                                                        <a href="<?php echo site_url('Tutores/detalletarea/' . $controller->encode($value->idtarea)); ?>">
                                                            LEER MAS... </a>
                                                    <?php
                                                    } else {
                                                        echo $value->tarea;
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    setlocale(LC_ALL, 'es_ES');
                                                    $date = new Datetime($value->fechaentrega);
                                                    $fecha = strftime("%A, %d de %B", $date->getTimestamp());
                                                    echo $fecha;
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