<!-- page content -->
<div class="right_col" role="main">

    <div class="">

        <div class="row">
            <div class="col-md-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><strong><i class="fa fa-file"></i> PLANEACIONES</strong></h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12 ">
								<table id="tablageneral3" class="table table-hover table-striped">
									<thead class="bg-teal">
										<th>#</th>
										<th>ASIGNATURA</th>
										<th>FECHA</th>
										<th>DOCUMENTO</th>
									</thead>
									<tbody>
									<?php 
									if(isset($planeaciones) && !empty($planeaciones)){ 
									    $contador = 1;
									    foreach ($planeaciones as $row){?>
										<tr>
											<td><?php echo $contador++; ?></td>
											<td><?php echo $row->nombreclase;?></td>
											<td><?php echo $row->fechainicio.' a '.$row->fechafin; ?></td>
										<td>
                                                <?php $url = "'".'../../../../documentos/planeacion/licenciatura/'.$row->documento."'"; ?>
                                            <a target='_blank' onclick="location.href= <?php echo $url; ?> " ><i class="fa fa-download" aria-hidden="true"></i>
                                             DESCARGAR</a></td>
										</tr>
										<?php } }else{?>
											<tr>
												<td colspan="4" align="center">Sin registros</td>
											</tr>
										<?php } ?>
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

<script type="text/javascript">
    $(document).ready(function () {
        $('#tablageneral3').DataTable({ 
             keys: false,
            "scrollX": false,
            
           buttons: [
        'excelHtml5'
        ],
            "language": {
                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Ningún dato disponible en esta tabla",
                "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix": "",
                "sSearch": "Buscar:",
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            }
        });

    });
</script>