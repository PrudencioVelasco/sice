  <!-- page content -->
  <div class="right_col" role="main">
    <div class="">
      <div class="row">
        <div class="col-md-12">
          <div class="x_panel">
            <div class="x_title">
              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12 ">
                  <h2><strong><i class="fa fa-check-circle"></i> Significado de calificación</strong></h2>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="x_content bs-example-popovers">
                    <div class="col-md-3 col-sm-3 col-xs-3 alert alert-success alert-dismissible fade in" role="alert">
                      <strong>E:</strong> Excelente
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-3 alert alert-info alert-dismissible fade in" role="alert">
                      <strong>MB:</strong> Muy bien
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-3 alert alert-warning alert-dismissible fade in" role="alert">
                      <strong>B:</strong> Bien
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-3 alert alert-danger alert-dismissible fade in" role="alert">
                      <strong>NA:</strong> Necesita Apoyo
                    </div>
                  </div>
                </div>
              </div>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <div class="row">
                <div class="container">
                  <?php if(isset($tabla) && !empty($tabla)){ ?>
                    <?php echo $tabla; ?>
                  <?php } ?>
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