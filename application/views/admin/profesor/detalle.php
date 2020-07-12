  <!-- page content -->
      <div class="right_col" role="main">

        <div class=""> 

          <div class="row">
            <div class="col-md-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2><strong>PERFIL PROFESOR</strong></h2> 
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
           <div id="app">
                  <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-xs-12 col-sm-3">
                    <div class="card profile-card">
                        <div class="profile-header">&nbsp;</div>
                        <div class="profile-body">
                            <div class="image-area">
                                 <img  v-if="detalle_profesor.foto"   style="width: 128px;"  v-bind:src="url_image+detalle_profesor.foto" alt="" />
                                <img v-else  style="width: 128px;"  src="<?php echo base_url(); ?>/assets/images/user2.png"  />
                            </div>
                            <div class="content-area">
                                <h3>{{detalle_profesor.nombre}}</h3>
                                <p>{{detalle_profesor.profesion}}</p> 
                                 <p>{{detalle_profesor.cedula}} </p>
                            </div>
                        </div>
                        <div class="profile-footer"> 
                            <button @click="abrirSubirFotoModal()" class="btn btn-primary btn-lg waves-effect btn-block"> <i class="fa fa-cloud-upload"></i> SUBIR FOTO</button>
                        </div>
                    </div>

                    <div class="card card-about-me">
                        <div class="header">
                            <h2>ACERCA DE MI</h2>
                        </div>
                        <div class="body">
                            <ul>
                                <li>
                                    <div class="">
                                        <i class="fa fa-check-circle"></i> CORREO
                                    </div>
                                    <div class="content">
                                        {{detalle_profesor.correo}}
                                    </div>
                                </li>  
                              
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-9">
                    <div class="card">
                        <div class="body">
                            <div>
                                <ul class="nav nav-tabs" role="tablist">
                                    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">MATERIAS</a></li>
                                    
                                </ul>

                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane fade in active" id="home">
                                       <div class="row">
                                    <div class="col-md-6">
                                        <button class="btn btn-round btn-primary waves-effect waves-black" @click="abrirAddModal()"><i class='fa fa-plus'></i> Agregar Materia</button> 


                                    </div> 
                                </div> 

                                         <table class="table table-hover table-striped">
                                            <thead class="bg-teal">
                                    <th class="text-white" v-column-sortable:nombrenivel>Materia / Clase</th> 
                                     <th class="text-center text-white"> </th>
                                    </thead>
                                    <tbody class="table-light">                                        <tr v-for="materia in materias" class="table-default">
 
                                            <td>{{materia.nombreclase}}</td> 
                                             
                                            <td align="right">
                                                <button type="button" class="btn btn-success btn-sm" @click=" abrirEditModal(); selectMateria(materia)" title="Modificar Datos"> <i class="fa fa-edit" aria-hidden="true"></i>
                                                  Editar
                                                </button> 
                                                 <button type="button" class="btn btn-danger btn-sm" @click="deleteMateria(materia.idprofesormateria)" title="Eliminar Datos"> <i class="fa fa-trash" aria-hidden="true"></i>
                                                  Editar
                                                </button> 
                                            </td>
                                        </tr>
                                        <tr v-if="emptyResult">
                                            <td colspan="2" class="text-center h4">No encontrado</td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="5" align="right">
                                    <pagination
                                        :current_page="currentPage"
                                        :row_count_page="rowCountPage"
                                        @page-update="pageUpdate"
                                        :total_users="totalMaterias"
                                        :page_range="pageRange"
                                        >
                                    </pagination>
                                    </td>
                                    </tr>
                                    </tfoot>
                                </table>
                                  <?php include 'modalmateria.php'; ?>
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
  <script data-my_var_1="<?php echo base_url() ?>" data-my_var_2="<?php echo $id ?>" src="<?php echo base_url(); ?>/assets/vue/appvue/appprofesormateria.js"></script> 


