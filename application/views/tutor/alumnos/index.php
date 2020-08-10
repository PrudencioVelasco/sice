<!-- page content -->
<div class="right_col" role="main">

    <div class="">

        <div class="row">
            <div class="col-md-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><strong><i class="fa fa-users"></i> HIJOS(AS)</strong></h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12 ">
                                <table class="table table-hover table-striped">
                                    <thead class="bg-teal">
                                    <th>#</th>
                                    <th>GRUPO</th>
                                    <th>ALUMNO</th>
                                    <th></th>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (isset($alumnos) && !empty($alumnos)) {
                                            $numero = 1;
                                            foreach ($alumnos as $value) {
                                                ?>
                                                <tr>
                                                    <td><strong><?php echo $numero++; ?></strong></td>
                                                    <td><strong><?php echo $value->nombrenivel . ' - ' . $value->nombregrupo; ?></strong>
                                                    </td>
                                                    <td><strong><?php echo $value->apellidop . ' ' . $value->apellidom . ' ' . $value->nombre; ?></strong>
                                                    </td>
                                                    <td align="right">
                                                        <div class="btn-group" role="group">
                                                            <div class="btn-group" role="group">
                                                                <button type="button"
                                                                        class="btn btn-info waves-effect dropdown-toggle"
                                                                        data-toggle="dropdown" aria-haspopup="true"
                                                                        aria-expanded="false">
                                                                    <i class='fa fa-plus'></i> Opciones
                                                                    <span class="caret"></span>
                                                                </button>
                                                                <ul class="dropdown-menu">
                                                                    <!--<li ><a href="<?php //echo site_url('Tutores/materias/'.$value->idalumno)  ?>"   title="Eliminar Datos"><i class="fa fa-trash"></i> Materias</a></li>-->
                                                                    <li><a href="<?php echo site_url('Tutores/horario/' . $controller->encode($value->idalumno)) ?>"
                                                                           title="Horario"><i class="fa fa-edit"></i>
                                                                            Horario</a></li>
                                                                    <li><a href="<?php echo site_url('Tutores/boletas/' . $controller->encode($value->idalumno)) ?>"
                                                                           title="Examen"><i style="color: #0b94e3;"
                                                                                          class="fa fa-file-text-o"></i>
                                                                            Calificación</a></li>
                                                                    <li><a href="<?php echo site_url('Tutores/asistencias/' . $controller->encode($value->idalumno)) ?>"
                                                                           title="Asistencias"> <i style="color: #31d50b;"
                                                                                                class="fa fa-check-circle"></i>
                                                                            Asistencia</a></li>
                                                                    <li><a href="<?php echo site_url('Tutores/mensajes/' . $controller->encode($value->idalumno) . '/' . $controller->encode($value->idnivelestudio) . '/' . $controller->encode($value->idperiodo)) ?>"
                                                                           title="Mensajes"> <i style="color: #dd3115;"
                                                                                             class="fa fa-envelope"></i>
                                                                            Mensajes</a></li>
                                                                    <li><a href="<?php echo site_url('Tutores/tareas/' . $controller->encode($value->idalumno) . '/' . $controller->encode($value->idnivelestudio) . '/' . $controller->encode($value->idperiodo)) ?>"
                                                                           title="Tareas"><i style="color: #000;"
                                                                                          class="fa fa-book"></i>
                                                                            Tarea</a></li>
                                                                    <li><a href="<?php echo site_url('Tutores/pagos/' . $controller->encode($value->idalumno) . '/' . $controller->encode($value->idnivelestudio) . '/' . $controller->encode($value->idperiodo)) ?>"
                                                                           title="Pagos"><i class="fa fa-paypal "
                                                                                         style="color:#215adc;"></i>
                                                                            Pagos</a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        }else{
                                            echo '<tr><td colspan="4" align="center">Sin registros</td></tr>';
                                        }
                                        ?>

                                    </tbody>
                                    <tfoot>
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