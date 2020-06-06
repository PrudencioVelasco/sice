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
         <div class="row">
           <div class="x_content">
                <div class="col-md-12 col-sm-12 col-xs-12 ">
                    <div class="dashboard_graph">
                      <h1>Bienvenido</h1>
                      <h2>SICE - Sistema Integral para el Control Escolar</h2>
                    </div>
                 </div>
            </div>
          
        </div> 
      </div>
      <!-- /page content -->