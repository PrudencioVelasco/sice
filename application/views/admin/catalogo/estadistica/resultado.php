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
                            <?php if (isset($tipografica) && $tipografica == 2) {
                                if (isset($datosgraficagrupo) && !empty($datosgraficagrupo)) { ?>
                                    <div class="row">
                                        <a href="#" id="downloadPdf">Descargar grafica</a>
                                        <div id="reportPage">
                                            <canvas id="chart1" style="width:100%;" height="100"></canvas>
                                        </div>
                                    </div>
                                <?php } else { ?>
                                    <div class="row" align="center">
                                        <label>No existe informacion para graficar.</label>
                                    </div>
                            <?php }
                            }
                            if (isset($tipografica) && $tipografica == 1) {
                                if (isset($alumnos) && !empty($alumnos)) {
                                    echo '<div align="center" id="generandografica"></div>';
                                    $tabla = '';
                                    $tabla .= ' <table class="table table-striped">
                                    <thead class="bg-teal">
                                      <tr> 
                                        <th>#</th> 
                                        <th>ALUMNO(A)</th> 
                                        <th></th>
                                      </tr>
                                    </thead>
                                    <tbody> ';
                                    $contador = 1;
                                    foreach ($alumnos as $alumno) {
                                        $tabla .= '<tr>';
                                        $tabla .= '<td>' . $contador++ . '</td>';
                                        $tabla .= '<td>' . $alumno->apellidop . ' ' . $alumno->apellidom . ' ' . $alumno->nombre . '</td>';
                                        $tabla .= '<td>
                                        <a  href="javascript:void(0)" class="generargrafica_button"  data-toggle="modal"
                                  data-idalumno="' . $alumno->idalumno . '"
                                  data-idhorario="' . $alumno->idhorario . '"
                                 data-alumno="' . $alumno->apellidop . ' ' . $alumno->apellidom . ' ' . $alumno->nombre . '"
                                  data-idperiodo="' . $alumno->idperiodo . '"  title="Ver Calificaciones">Generar grafica </a>
                                        </td>';
                                        $tabla .= '</tr>';
                                    }
                                    $tabla .= '</tbody></table>';
                                    echo $tabla;
                                } else {
                                    echo '    <div class="row" align="center">
                                    <label>No existe informacion para graficar.</label>
                                </div>';
                                }
                            }
                            ?>

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

<div class="modal fade" id="myModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="largeModalLabel">GRAFICA DE: <label id="nombrealumno"></label></h4>
            </div>
            <form id="frmplaneacionmodificar">
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <canvas id="chart2" style="width:100%;" height="100"></canvas>
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
<div id="custom_notifications" class="custom-notifications dsp_none">
    <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
    </ul>
    <div class="clearfix"></div>
    <div id="notif-group" class="tabbed_notifications"></div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>
<script src="<?php echo base_url(); ?>/assets/js/chart.min.js"></script>
<script>
    $('#downloadPdf').click(function(event) {
        // get size of report page
        var reportPageHeight = $('#reportPage').innerHeight();
        var reportPageWidth = $('#reportPage').innerWidth();

        // create a new canvas object that we will populate with all other canvas objects
        var pdfCanvas = $('<canvas />').attr({
            id: "canvaspdf",
            width: reportPageWidth,
            height: reportPageHeight
        });

        // keep track canvas position
        var pdfctx = $(pdfCanvas)[0].getContext('2d');
        var pdfctxX = 0;
        var pdfctxY = 0;
        var buffer = 100;

        // for each chart.js chart
        $("canvas").each(function(index) {
            // get the chart height/width
            var canvasHeight = $(this).innerHeight();
            var canvasWidth = $(this).innerWidth();

            // draw the chart into the new canvas
            pdfctx.drawImage($(this)[0], pdfctxX, pdfctxY, canvasWidth, canvasHeight);
            pdfctxX += canvasWidth + buffer;

            // our report page is in a grid pattern so replicate that in the new canvas
            if (index % 2 === 1) {
                pdfctxX = 0;
                pdfctxY += canvasHeight + buffer;
            }
        });

        // create new pdf and add our new canvas as an image
        var pdf = new jsPDF('l', 'pt', [reportPageWidth, reportPageHeight]);
        pdf.addImage($(pdfCanvas)[0], 'PNG', 0, 0);

        // download the pdf
        pdf.save('filename.pdf');
    });
    var ctx = document.getElementById("chart1");
    var data1 = {
        labels: [
            <?php foreach ($datosgraficagrupo as $d) : ?> "<?php echo $d['alumno'] ?>",
            <?php endforeach; ?>
        ],
        datasets: [{
            label: 'Calificación',
            data: [
                <?php foreach ($datosgraficagrupo as $d) : ?>
                    <?php echo $d['calificacion']; ?>,
                <?php endforeach; ?>
            ],
            backgroundColor: "#3898db",
            borderColor: "#9b59b6",
            borderWidth: 1
        }]
    };
    var options1 = {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: false
                }
            }]
        }
    };
    var chart1 = new Chart(ctx, {
        type: 'bar',
        /* valores: line, bar*/
        data: data1,
        options: options1
    });
</script>

<script type="text/javascript">
    $(document).on("click", '.generargrafica_button', function(e) {
        var idalumno = $(this).data('idalumno');
        var idhorario = $(this).data('idhorario');
        var idperiodo = $(this).data('idperiodo');
        var alumno = $(this).data('alumno');
        $("#generandografica").css('display', 'block');
        $('#generandografica').html(
            `<span class="fa fa-spin fa-spinner" style="color:green;" role="status" aria-hidden="true"></span> <label>Generando la grafica, espere un momento...</label>`
        );
        $("#nombrealumno").text(alumno);
        //$('#myModal').modal('show'); 
        var data = 'idalumno=' + idalumno + '&idhorario=' + idhorario + '&idperiodo=' + idperiodo;
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('Estadistica/calificacionPorAlumno'); ?>",
            data: data,
            success: function(data) {
                $("#generandografica").css('display', 'none');
                var val = JSON.parse(data);
                const $grafica = document.querySelector('#chart2');
                const etiqueta = val.nombreclase;

                var data = {
                    labels: val.nombreclase,
                    datasets: [{
                        label: 'Calificación',
                        data: val.calificacion,
                        backgroundColor: 'rgba(54,162,235,0.2)',
                        borderColor: 'rgba(54,162,235,1)',
                        borderWidth: 1,
                    }]
                };

                const datosCalificaciones = {
                    label: "Calificación",
                    data: val.calificacion,
                    backgroundColor: 'rgba(54,162,235,0.2)',
                    borderColor: 'rgba(54,162,235,1)',
                    borderWidth: 1,
                };
                var options = {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                };
                new Chart($grafica, {
                    type: 'line',
                    /* valores: line, bar*/
                    data: data,
                    options: options
                });
                $('#myModal').modal('show');

            }
        })

    });
</script>