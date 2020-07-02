  <!-- page content -->
      <div class="right_col" role="main">
       <div class="row">
              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                  <?php if (isset($_SESSION['err'])): ?>
                      <div class="alert alert-danger" role="alert">
                          <h4 class="alert-heading">Permiso!</h4>
                          <p>Acceso denegado para entrar a esta opcion.</p>
                          <hr>
                          <p class="mb-0">Si requiere permiso solicitelo al administrador.</p>
                      </div>
                  <?php endif ?>
              </div>  
          </div>  
        <br /> 


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
                        echo "<strong>". utf8_encode($fecha)."</strong>";
                        ?> 
                    </a>
                    </li>  
                  </ul>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content"> 
                  <div class="row">  
                    <h2><strong>* TAREAS</strong></h2>
               <table id="" class="table table-striped   datatabletarea">
                     <thead class="bg-teal"> 
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
                            $space = strrpos($value->tarea, ' ');	
                            ?>
                             <tr>
                              <th scope="row"><?php echo $i++; ?></th>
                              <td><strong><?php echo $value->nombreclase; ?></strong></td>
                              <td>
                                <?php
                                if(strlen($value->tarea) > 20){
                                 echo $cadena = substr($value->tarea,0,50)."..."; ?>
                                   <a href="<?php echo site_url('Aalumno/detalletarea/'.$controller->encode($value->idtarea)); ?>"> leer mas </a>
                                <?php }else{
                                  echo $value->tarea;
                                }  
                                ?>
                              </td> 
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
                    <h2><strong>* MENSAJES</strong></h2>
                   <table id="" class="table table-striped  datatabletarea">
                    <thead class="bg-teal"> 
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
                              $value->mensaje;
                              $space = strrpos($value->mensaje, ' ');
                               substr($value->mensaje, 0, $space)	
                            ?>
                             <tr>
                              <th scope="row"><?php echo $i++; ?></th>
                              <td><strong><?php echo $value->nombreclase; ?></strong></td>
                               <td><?php 
                               
                               if(strlen($value->mensaje) > 20){
                                 echo $cadena = substr($value->mensaje,0,50)."..."; ?>
                                   <a href="<?php echo site_url('Aalumno/detallemensaje/'.$controller->encode($value->idmensaje)); ?>"> leer mas </a>
                                <?php }else{
                                  echo $value->mensaje;
                                }  
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


