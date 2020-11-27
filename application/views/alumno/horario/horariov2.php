<!-- page content -->
<style>
    ul {
        list-style-type: none;
        margin: 0;
        padding: 0;
    }

    .seleccionado {
        border: solid red 6px;
    }
</style>
<div class="right_col" role="main">

    <div class="">

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <h2><strong> <i class="fa fa-calendar"></i> HORARIO ESCOLAR</strong></h2>
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12 " align="right">
                            <?php if (isset($tabla) && !empty($tabla)) { ?>
                                <a target="_blank" href="<?php echo site_url('Aalumno/generarHorarioPDF/' . $controller->encode($idhorario) . '/' . $controller->encode($idalumno)) ?>" class="btn btn-primary">IMPRIMIR HORARIO</a>
                            <?php } ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">


                        <?php
                        if (isset($materias_repetir) && !empty($materias_repetir)) {
                            echo '  <div class="row" > 
                    <div class="col-md-12 col-sm-12 col-xs-12 ">
                        <h5>Materias para recuperar.</h5>
                        ';
                            foreach ($materias_repetir as $row) {
                                echo '<label>*' . $row->nombreclase . '</label> - <small>' . $row->nombre . ' ' . $row->apellidop . ' ' . $row->apellidom . '</small> || ';
                            }
                            echo '   <div class="clearfix"></div>    
                    </div>
                    </div>
                    ';
                        }
                        ?>
                        <?php

                        if (isset($this->session->idplantel) && ($this->session->idplantel == 1 || $this->session->idplantel == 3 || $this->session->idplantel == 5)) {
                        ?>
                            <div class="alert alert-info alert-dismissible fade in" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                                </button>
                                <strong>Información!</strong> Antes de iniciar una clase es necesario que descargue e instale ZOOM, lo puede descargar desde aqui <a target="_blank" href="https://zoom.us/download">Descargar</a>
                            </div>
                            <div class="alert alert-info alert-dismissible fade in" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                                </button>
                                <strong>Información!</strong> Puede de entrar a clases 10 minutos antes o mas tardar 30 minutos despues de haber iniciado.
                            </div>
                        <?php
                        }
                        ?>
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <?php if (isset($_SESSION['exito_taller_clase'])) : ?>
                                    <div class="alert alert-success" role="alert">
                                        <h4 class="alert-heading">Agregado!</h4>
                                        <p><?php echo $_SESSION['exito_taller_clase']; ?></p>

                                    </div>
                                <?php endif ?>
                            </div>
                        </div>
                        <br />
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12 ">
                                <?php if ($mostrar) { ?>
                                    <button type="button" class="btn btn-info" data-toggle="modal" data-target=".bs-example-modal-sm">SELECCIONAR CLASE DE TALLER</button>
                                <?php } ?>
                                <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">

                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                                                </button>
                                                <h4 class="modal-title" id="myModalLabel2">SELECCIONAR TALLER</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div align="center">
                                                    <small class=" text-danger">* Si no le aparece o esta incorrecto en el horario su clase de taller, seleccione.</small>
                                                    <br /><br />
                                                    <?php
                                                    if (isset($materias_taller) && !empty($materias_taller)) {
                                                        foreach ($materias_taller as $row) { ?>
                                                            <a href="<?php echo base_url() . '/Aalumno/seleccionarTaller/' . $idhorario . '/' . $idalumno . '/' . $row->idprofesormateria . '/' . $row->idmateria; ?>" <?php if (isset($materia_seleccionada)  && !empty($materia_seleccionada)) {
                                                                                                                                                                                                                            if ($materia_seleccionada->idmateria == $row->idmateria) {
                                                                                                                                                                                                                                echo  'class="btn  btn-app btn-lg btn-success"';
                                                                                                                                                                                                                            } else {
                                                                                                                                                                                                                                echo  'class="btn  btn-app btn-lg"';
                                                                                                                                                                                                                            }
                                                                                                                                                                                                                        } else {
                                                                                                                                                                                                                            echo  'class="btn  btn-app btn-lg"';
                                                                                                                                                                                                                        } ?>>
                                                                <h4><?php echo $row->nombreclase; ?></h4>
                                                            </a><br>
                                                    <?php    }
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12 " align="center">
                                <?php
                                if (isset($tabla) && !empty($tabla)) {
                                    echo $tabla;
                                } else {
                                    echo '<label align="center">No tiene registrado Horario de Clases.</label>';
                                }
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
<script language="Javascript">
    // Recibe ID 
    function cambiar_estado(idhorariodetalle, base) {

        $.ajax({
            type: "POST",
            url: base + "/Aalumno/verificarhora",
            data: "idhorariodetalle=" + idhorariodetalle,
            success: function(data) {
                var val = JSON.parse(data);
                if (val.opcion == 1) {
                    let a = document.createElement('a');
                    a.target = '_blank';
                    a.href = val.url;
                    a.click();
                } else {
                    swal({
                        type: 'info',
                        title: 'Notificación',
                        html: val.mensaje,
                        customClass: 'swal-wide',
                        footer: ''
                    });

                }
            }
        })
    }
</script>
</script>