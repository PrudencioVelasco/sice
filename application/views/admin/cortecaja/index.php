  <!-- page content -->
      <div class="right_col" role="main">

        <div class=""> 

          <div class="row">
            <div class="col-md-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2><strong>CORTE DE CAJA</strong></h2> 
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <div class="row">  


              <form  method="post" action="<?php echo site_url('CorteCaja/');?>">
              <div class="row">
                <div class="alert alert-danger print-error-msg-1" style="display:none"></div>
              </div>
            <div class="row"> 
              <div class="col-md-2 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <label><font color="red">*</font> De</label>
                        <input type="date" class="form-control" id="fechainicio" name="fechainicio"> 
                </div>
            </div> 
              <div class="col-md-2 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <label><font color="red">*</font> a</label>
                        <input type="date" class="form-control" id="fechafin"  name="fechafin"> 
                </div>
            </div> 
            <div class="col-md-2 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <label><font color="red">*</font> Pagó en</label>
                    <select class="form-control" name="pagoen" id="pagoen">
                        <option value="">TODOS</option> 
                        <option value="0">OFICINA</option>
                        <option value="1">ONLINE</option>
                    </select> 
                </div>
            </div> 
            <div class="col-md-2 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <label><font color="red">*</font> Estatus</label>
                    <select class="form-control" name="estatus" id="estatus">
                        <option value="">TODOS</option> 
                        <option value="1">PAGADO</option>
                        <option value="0">EN PROCESO</option>
                    </select> 
                </div>
            </div> 
             <div class="col-md-3 col-sm-12 col-xs-12 ">
                <div class="form-group"> 
                    <button class="btn btn-primary" type="submit" id="btnbuscar" style="margin-top: 25px;"><i class="fa fa-search"></i>  Buscar</button>
                </div>
            </div> 
             
           </div> 
         </form>
         
          <div class="row">
               <div class="col-md-12 col-sm-12 col-xs-12 ">
              <table id="datatablereportealmacen" class="table">
                            <thead>
                                <tr>
                                   <th scope="col">ALUMNO</th>
                                   <th scope="col">FORMA PAGO</th>
                                   <th scope="col">PAGÓ EN</th>
                                   <th scope="col">ESTATUS</th>
                                   <th scope="col">CONCEPTO</th>
                                   <th scope="col">DESCUENTO</th>
                                   <th scope="col">AUTORIZACIÓN</th>
                                   <th scope="col">FECHA</th> 
                               </tr>
                           </thead>
                           <tbody>
                               <?php
                                if(isset($pago_inicio) && !empty($pago_inicio)){ 
                                    foreach($pago_inicio as $value){    
                                ?>
                               <tr>
                                   <td><?php echo $value->nombre." ".$value->apellidop." ".$value->apellidom ?></td>
                                   <td><?php echo  $value->nombretipopago; ?></td>
                                    <td>
                                        <?php
                                            if($value->online == 0){
                                                echo '<label class="label label-default">EN OFICINA</label>';
                                            }else{
                                                echo '<label class="label label-primary">EN LINEA</label>';
                                            }
                                        ?>
                                    </td>
                                   <td>
                                       <?php
                                            if($value->pagado == 1){
                                                echo '<label class="label label-success">PAGADO</label>';
                                            }else{
                                                echo '<label class="label label-warning">EN PROCESO</label>';
                                            }
                                        ?>
                                   </td>
                                   <td><?php echo $value->concepto; ?></td>
                                   <td><strong><?php echo $value->descuento; ?></strong></td>
                                   <td><?php echo $value->autorizacion; ?></td>
                                   <td><?php echo $value->fecha; ?></td>
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
        $('#datatablereportealmacen').DataTable({
            "scrollX": false,
            dom: 'Bfrtip',
           buttons: [
        'excelHtml5'
        ],
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