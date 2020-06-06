  <!-- page content -->
      <div class="right_col" role="main">

        <div class=""> 

          <div class="row">
            <div class="col-md-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2><strong>SUBIR DOCUMENTOS</strong></h2> 
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">  

                 <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left"  method="POST" action="<?php echo base_url('Subir/comparar'); ?>" enctype="multipart/form-data">
                            <div class="row"> 
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><font color="red">*</font> Archivo</label>
                                        <input type="file" id="first-name"   name="mi_archivo" required="" accept=".xls,.xlsx" class="form-control col-md-7 col-xs-12" value="<?php echo set_value('mi_archivo'); ?>">
                                        <div class="text-danger" > <?php echo form_error('mi_archivo'); ?>  </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <button type="submit" style="margin-top: 25px" class="btn btn-success">Subir documento</button>
                                    </div>
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
 