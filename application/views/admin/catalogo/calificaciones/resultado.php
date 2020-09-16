<!-- page content -->
<style>
    ul{
        list-style-type: none;
        margin: 0;
        padding: 0; 
    }

</style>
<div class="right_col" role="main"> 
    <div class="">  
        <div class="row">
            <div class="col-md-12">
                <div class="x_panel">
                    <div class="x_title">
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <h2><strong> <i class="fa fa-check-circle"></i> CALIFICACIONES</strong></h2>
                        </div> 
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content"> 
                        <div class="row"  align="center"> 

                            <form   method="POST" action="<?= base_url(),'Calificacion/buscar'?>">
                                <div class="row">
                                    <div class="col-md-3 col-sm-12 col-xs-12 ">
                                        <div class="form-group"> 
                                            <select style="border-bottom: solid #ebebeb 2px;" name="cicloescolar" required="" class="form-control">
                                                <option value="">-- CICLO ESCOLAR --</option>   
                                               <?php
                                               if(isset($periodos) && !empty($periodos)){
                                                   foreach ($periodos as $value) {
                                                       echo  '<option value="'.$value->idperiodo.'">'.$value->mesinicio.' - '.$value->mesfin.' '.$value->yearfin.'</option>'; 
                                                   }
                                               }
                                               ?>
                                            </select> 
                                        </div>
                                    </div>   
                                    <div class="col-md-3 col-sm-12 col-xs-12 ">
                                        <div class="form-group"> 
                                            <select style="border-bottom: solid #ebebeb 2px;" name="grupo" class="form-control">
                                                <option value="">-- GRUPO --</option>  
                                               <?php 
                                                        if(isset($grupos) && !empty($grupos)){
                                                            foreach ($grupos as $value) {
                                                                  echo  '<option value="'.$value->idgrupo.'">'.$value->nombrenivel.' - '.$value->nombregrupo.'</option>'; 
                                                            }
                                                        }
                                               ?>
                                            </select> 
                                        </div>
                                    </div>  
                                      <div class="col-md-4 col-sm-12 col-xs-12 ">
                                        <div class="form-group"> 
                                            <select style="border-bottom: solid #ebebeb 2px;" name="tiporeporte" class="form-control">
                                                <option value="">-- TIPO DE REPORTE --</option> 
                                                <option value="2">PROMEDIO FINAL</option> 
                                                <option value="4">CALIFICACIÓN POR MATERIA</option>
                                                <option value="5">CALIFICACIÓN POR MATERIA EN RECUPERACIÓN</option> 
                                            </select> 
                                        </div>
                                    </div>  
                                     <div class="col-md-2 col-sm-12 col-xs-12 ">
                                        <div class="form-group"> 
                                            <button class="btn btn-default" type="submit"> <i class="fa fa-search"></i> Buscar</button>
                                           </div>
                                    </div>  
                                </div>
                            </form> 
                        </div> 
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12 ">
                                <?php echo $tabla; ?>
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
        $('#tablageneralcal').DataTable({
            keys: true,
            "scrollX": true,
            dom: 'Bfrtip',
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