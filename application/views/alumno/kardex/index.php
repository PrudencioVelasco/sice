<!-- page content -->
<div class="right_col" role="main"> 
    <div class="">  
        <div class="row">
            <div class="col-md-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><strong><i class="fa fa-book"></i> KARDEX</strong></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="" style="color: #000">
                                    <?php
                                    setlocale(LC_ALL, 'es_ES');
                                    $date = new Datetime(date("Y-m-d"));
                                    $fecha = strftime("%A, %d de %B", $date->getTimestamp());
                                    echo "<strong>" . $fecha . "</strong>";
                                    ?>

                                </a>
                            </li>  
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="row">
                            <div class="col-md-6 col-sm-12 col-xs-12 ">
                                <h4><?php echo $detalle->nombre . " " . $detalle->apellidop . ' ' . $detalle->apellidom ?></h4>
                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12 " align="right">
                                <!-- <h4>C. FINAL: </h4>-->
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <table class="table table-striped ">
                                <thead class="bg-teal">
                                    <tr> 
                                        <th>Ciclo Escolar</th>
                                        <th>Nivel</th>
                                        <th>Grupo</th>  
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
                                                    <a class="btn btn-info" href="<?php echo site_url('Aalumno/historial/' . $controller->encode($row->idhorario)) ?>"><i class="fa fa-list-alt"></i> Calificación</a> 

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


