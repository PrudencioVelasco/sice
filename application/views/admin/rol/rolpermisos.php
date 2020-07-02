

 <!-- page content -->
      <div class="right_col" role="main">

        <div class="">
          
          <div class="clearfix"></div>

          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2><strong>ADMINISTRAR PERMISOS</strong></h2>
                  
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
 

  <div class="row">
                          
                           <div class="col-md-12">
                              <?php if(isset($_SESSION['exito'])): ?>
                                  <script>
                                       swal({
                                           position: 'center',
                                              type: 'success',
                                              title: '<?= $this->session->userdata('exito'); ?>',
                                              showConfirmButton: false,
                                              timer: 1500

                                        })

                                             </script>

                                <?php endif ?>
                            <div class="row">
                                <div class="col-md-6">
                                    
                                       <a  href="<?= base_url('/User/') ?>" class="btn btn-round btn-default">Usuarios</a>
                                          <a  href="<?= base_url('/Rol/') ?>" class="btn btn-round btn-default">Roles</a>
                                         <a  href="<?= base_url('/Permiso/') ?>" class="btn btn-round btn-default">Permisos</a>
                                       
                                </div>
                                <div class="col-md-6"></div>
                             </div>
                              <div class="row">
                                <div class="col-md-12">
                                  <br>
                                 <table class="table  table-hover table-striped">
                                  <tr>
                                    <td><strong>Descripción</strong></td>
                                      <td><strong>Permiso</strong></td>
                                    <td><strong>Opción</strong></td>
                                  </tr>
                                  <form method="POST" action="<?= base_url('Rol/agregarrolpermiso') ?>">
                                  <?php foreach($permisos as $permiso) { ?>
                                    <tr>
                                      <td>
                                          <?php   if($permiso["description"] != "") { echo $permiso["description"];}else{ echo "Sin descripcion";} ?>
                                      </td>
                                      <td>
                                         <?php   if($permiso["description"] != "") { echo  $permiso["uri"]; }else{ echo  $permiso["uri"];} ?>
                                      </td> 
                                       <td>
                                          <div class="switch">
                                    <label>NO<input type="checkbox" name="permiso[]" value="<?php echo $permiso["id"] ?>"  <?php if($permiso["status"]=="1"){echo "checked";} ?>><span class="lever"></span>SI</label>
                                </div>

                                       </td>
                                    <?php } ?>
                                    <tr>
                                      <td colspan="3">
                                        <input type="hidden" name="rol" value="<?php echo $permiso["rol"] ?>">
                                     <button type="submit"  class="btn btn-primary btn-fw"><i class='fa fa-floppy-o'></i> Guardar</button>
                                      </td>
                                    </tr>
                                    
                                  </form>
                                </div>
                                
                             </div>
                             
                           </div>
                        </div> 



                </div>
              </div>
            </div>
          </div>
        </div>


      </div>
      <!-- /page content -->

 <script  data-my_var_1="<?php echo base_url() ?>" src="<?php echo base_url();?>/assets/js/appvue/apppermiso.js"></script> 