  <!-- page content -->
      <div class="right_col" role="main">
 


            <div class=""> 

          <div class="row">
            <div class="col-md-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2><strong><i class="fa fa-book"></i> TAREAS Y MENSAJES</strong></h2>
                  <ul class="nav navbar-right panel_toolbox">
                    <li><a class="" style="color: #000">
                       <?php
                                setlocale(LC_ALL, 'es_ES');
                        $date = new Datetime(date("Y-m-d"));
                        $fecha = strftime("%A, %d de %B", $date->getTimestamp());
                        echo "<strong>".$fecha."</strong>";
                        ?> 
                    </a>
                    </li>  
                  </ul>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content"> 
                  <div class="row">  
               <table id="" class="table table-striped table-bordered datatabletarea">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Materia</th>
                        <th>Tarea</th> 
                        <th>Fecha de entrega</th> 
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        if(isset($tareas) && !empty($tareas)){
                          $i=1;
                          foreach ($tareas as  $value) {
                            ?>
                             <tr>
                              <th scope="row"><?php echo $i++; ?></th>
                              <td><strong><?php echo $value->nombreclase; ?></strong></td>
                              <td><?php echo $value->tarea ?> </td> 
                             <td>
                              <?php
                                setlocale(LC_ALL, 'es_ES');
                                $date = new Datetime($value->fechaentrega);
                                $fecha = strftime("%A, %d de %B", $date->getTimestamp());
                                echo "<strong>".$fecha."</strong>";
                                ?>
                             </td>
                            </tr>
                            <?php
                          }
                        }
                      ?>
                     
                    </tbody>
                  </table>

                   <table id="" class="table table-striped table-bordered datatabletarea">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Materia</th>
                        <th>Mensaje</th>  
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        if(isset($mensajes) && !empty($mensajes)){
                          $i=1;
                          foreach ($mensajes as  $value) {
                            ?>
                             <tr>
                              <th scope="row"><?php echo $i++; ?></th>
                              <td><strong><?php echo $value->nombreclase; ?></strong></td>
                              <td><?php echo $value->mensaje ?> </td>  
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
  <script type="text/javascript">
    $(document).ready(function () {
        $('.datatabletarea').DataTable({
            "scrollX": false, 
            "order": [[0, "desc"]],
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


