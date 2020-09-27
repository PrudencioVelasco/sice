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
                                        <button type="button" id="btnbuscar" class="btn btn-primary  m-l-15 waves-effect"> <i class="fa fa-search" ></i> BUSCAR</button>
                                    </div>
                                </div>
                            </form>
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
