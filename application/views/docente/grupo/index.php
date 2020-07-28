<!-- page content -->
<style>

</style>
<div class="right_col" role="main">

    <div class="">

        <div class="row">
            <div class="col-md-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><strong><i class="fa fa-users"></i> GRUPOS</strong></h2>

                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="row" align="right">
                            <div class="col-md-12 col-sm-12 col-xs-12 ">
                                <form method="post" action="<?php echo base_url() . 'Pgrupo/generarReporter' ?>">
                                    <div class="row">
                                        <div class="col-md-2 col-sm-2 col-xs-12 "></div>
                                        <div class="col-md-4 col-sm-4 col-xs-12 ">
                                            <div class="form-group">
                                                <select style=" border-bottom: solid #ccc 2px;" name="grupo" style="" required="" id="idgrupo"
                                                        class="form-control  show-tick">
                                                    <option value="">-- GRUPO --</option>
                                                    <?php
                                                    if (isset($grupos) && !empty($grupos)) {
                                                        foreach ($grupos as $value) {
                                                            ?>
                                                            <option value="<?php echo $value->idhorariodetalle ?>">
                                                                <?php echo $value->nombrenivel . ' ' . $value->nombregrupo . ' - ' . $value->nombreclase; ?>

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

                                                <select name="tiporeporte"  style=" border-bottom: solid #ccc 2px;" id="" required class="form-control">
                                                    <option value="">-- TIPO DE REPORTE --</option>
                                                    <option value="1">LISTA DE ALUMNOS</option>
                                                    <option value="2">CALIFICACION FINAL</option> 
                                                </select>

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
                                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-12">
                                            <button type="submit" class="btn btn-primary"><i class='fa fa-download'></i>
                                                DESCARGAR</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12 ">
                                <table class="table table-striped  ">
                                    <thead class="bg-teal">
                                        <tr>
                                            <th>#</th>
                                            <th>GRUPO</th>
                                            <th>MATERIA</th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (isset($datos) && !empty($datos)) {
                                            $i = 1;
                                            foreach ($datos as $value) {
                                                ?>
                                                <tr>
                                                    <th scope="row"><?php echo $i++; ?></th>

                                                    <td scope="row">
                                                        <strong><?php echo $value->nombrenivel . " - " . $value->nombregrupo ?></strong>
                                                    </td>
                                                    <td><strong><?php echo $value->nombreclase; ?></strong></td>
                                                    <td><?php
                                                        if (isset($value->opcion) && !empty($value->opcion) && $value->opcion == 0) {
                                                            echo ' <span class="label label-danger">RECURSANDO</span>';
                                                        }
                                                        ?></td>
                                                    <td align="right">
                                                        <div class="btn-group" role="group">
                                                            <div class="btn-group" role="group">
                                                                <button type="button"
                                                                        class="btn btn-info waves-effect dropdown-toggle"
                                                                        data-toggle="dropdown" aria-haspopup="true"
                                                                        aria-expanded="false">
                                                                    <i class='fa fa-list'></i> Opciones
                                                                    <span class="caret"></span>
                                                                </button>
                                                                <ul class="dropdown-menu">
                                                                    <li><a
                                                                            href="<?php echo site_url('Pgrupo/examen/' . $controller->encode($value->idhorario) . '/' . $controller->encode($value->idhorariodetalle)) ?>">
                                                                            <i style="color: #0b94e3;"
                                                                               class="fa fa-file-text-o"></i> Calificación</a>
                                                                    </li>
                                                                    <li><a
                                                                            href="<?php echo site_url('Pgrupo/asistencia/' . $controller->encode($value->idhorario) . '/' . $controller->encode($value->idhorariodetalle)) ?>">
                                                                            <i style="color: #31d50b;"
                                                                               class="fa fa-check-circle"></i> Asistencia</a>
                                                                    </li>
                                                                    <li><a
                                                                            href="<?php echo site_url('Pgrupo/tarea/' . $controller->encode($value->idhorario) . '/' . $controller->encode($value->idhorariodetalle)) ?>"><i
                                                                                style="color: #000;" class="fa fa-book"></i>
                                                                            Tarea</a></li>
                                                                    <li><a
                                                                            href="<?php echo site_url('Pgrupo/mensaje/' . $controller->encode($value->idhorario) . '/' . $controller->encode($value->idhorariodetalle)) ?>">
                                                                            <i style="color: #dd3115;"
                                                                               class="fa fa-envelope"></i> Mensaje</a></li>

                                                                </ul>
                                                            </div>
                                                        </div>

                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        }else{
                                            echo '<tr><td colspan="5" align="center">Sin registros de Grupos.</td></tr>';
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