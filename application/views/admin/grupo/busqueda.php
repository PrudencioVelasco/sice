  <!-- page content -->
      <div class="right_col" role="main">

        <div class=""> 

          <div class="row">
            <div class="col-md-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2><strong>CONSULTAS</strong></h2> 
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">  
                    <form id="frmbuscar">
                             <div class="row clearfix">
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <select class="form-control" name="grupo" id="grupo">
                                                    <option value="">-- GRUPO --</option>
                                                    <?php
                                                        if(isset($grupos) && !empty($grupos)){
                                                            foreach($grupos as $row){
                                                                echo '<option value="'.$row->idgrupo.'">'.$row->nombrenivel.' '.$row->nombregrupo.' - '.$row->nombreturno.'</option>';
                                                            }
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <select class="form-control" name="periodo" id="periodo">
                                                    <option value="">-- PERIODO --</option>
                                                    <?php
                                                        if(isset($periodos) && !empty($periodos)){
                                                            foreach($periodos as $row){
                                                                echo '<option value="'.$row->idperiodo.'">'.$row->mesinicio.' - '.$row->mesfin.' '.$row->yearfin.'</option>';
                                                            }
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <select class="form-control" name="opcion" id="opcion">
                                                    <option value="">-- OPCIÓN --</option>
                                                    <option value="28">LISTA</option> 
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-3 col-xs-12"> 
                                        <button type="button" id="btnbuscar" class="btn btn-primary  m-l-15 waves-effect"> <i class="fa fa-search " ></i> BUSCAR</button>
                                    </div>
                                </div>
                            </form>
                    
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <?php
                                if(isset($lista_alumnos) && !empty($lista_alumnos)){
                                    echo ' <table  class="tablageneral2 table table-striped">
                                         <caption class="bg-teal"  align="center" > <center><strong>LISTA DE ALUMNOS</strong></center></caption>     
                                        <thead class="bg-teal"> 
                                         <tr>
                                           <th>#</th>
                                           <th>NOMBRE</th> 
                                           <th></th>
                                         </tr>
                                       </thead>
                                       ';
                                    $numero = 1;
                                    foreach ($lista_alumnos as $value) {
                                        echo '<tr>
                                              <td>'.$numero++.'</td>
                                              <td>'.$value->apellidop.' '.$value->apellidom.' '.$value->nombre.'</td>
                                              <td></td>
                                            </tr>';
                                    }
                                    if(isset($alumnos_reprobados) && !empty($alumnos_reprobados)){
                                         foreach ($alumnos_reprobados as $value) {
                                        echo '<tr>
                                              <td>'.$numero++.'</td>
                                              <td>'.$value->apellidop.' '.$value->apellidom.' '.$value->nombre.'</td>
                                              <td>R</td>
                                            </tr>';
                                    }
                                    }
                                    echo ' </table>';
                                }
                                if(isset($calificaion_final) && !empty($calificaion_final)){
                                    echo $calificaion_final;
                                }
                                 if(isset($calificacion_por_oportunidad) && !empty($calificacion_por_oportunidad)){
                                    echo $calificacion_por_oportunidad;
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

  
  <div id="custom_notifications" class="custom-notifications dsp_none">
    <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
    </ul>
    <div class="clearfix"></div>
    <div id="notif-group" class="tabbed_notifications"></div>
  </div>
  <script data-my_var_1="<?php echo base_url() ?>" src="<?php echo base_url(); ?>/assets/vue/appvue/appalumno.js"></script> 

<script type="text/javascript"> 

        $("#btnbuscar").click(function(){  

            var grupo = $("#grupo").val();
            var periodo = $("#periodo").val();
            var opcion = $("#opcion").val();  
         
          if(grupo != "" && periodo != "" && opcion != "" ){
            window.location = "<?php echo site_url('Grupo/busqueda'); ?>/"+grupo+'/'+periodo+'/'+opcion;
          }else{
              swal({
                       type: 'info',
                        title: 'Notificación',
                        html: 'Seleccione todos los campos.',
                        customClass: 'swal-wide',
                        footer: ''
                    });
          }


  });

         

</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('.tablageneral2').DataTable({ 
            keys: false,
            "scrollX": false,
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

<script type="text/javascript">
    $(document).ready(function () {
        $('.tblcalificacionfinal').DataTable({ 
            keys: false,
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
