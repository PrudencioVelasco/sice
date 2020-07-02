  <!-- page content -->
      <div class="right_col" role="main">

        <div class=""> 

          <div class="row">
            <div class="col-md-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2><strong>ADMINISTRAR ALUMNOS</strong></h2> 
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">  

                             <div class="row clearfix">
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <select class="form-control">
                                                    <option>-- GRUPO --</option>
                                                    <?php
                                                        if(isset($grupos) && !empty($grupos)){
                                                            foreach($grupos as $row){
                                                                echo '<option value="'.$row->idgrupo.'">'.$row->nombrenivel.' '.$row->nombregrupo.'</option>';
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
                                                <select class="form-control">
                                                    <option>-- PERIODO --</option>
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
                                                 <select class="form-control">
                                                    <option>-- OPCIÓN --</option>
                                                    <option value="28">LISTA</option>
                                                     <?php
                                                        if(isset($oportunidades) && !empty($oportunidades)){
                                                            foreach($oportunidades as $row){
                                                                echo '<option value="'.$row->idoportunidadexamen.'">'.$row->nombreoportunidad.'</option>';
                                                            }
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-3 col-xs-12"> 
                                        <button type="button" class="btn btn-primary btn-lg m-l-15 waves-effect">ACEPTAR</button>
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


