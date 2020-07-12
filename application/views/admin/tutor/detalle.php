  <!-- page content -->
      <div class="right_col" role="main">

        <div class=""> 

          <div class="row">
            <div class="col-md-12">
              <div class="x_panel">
                <div class="x_title">
               <h2><strong>PERFIL DEL TUTOR</strong></h2> 
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
<div class="row">
  <div class="container">
      <div id="app">
     <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-xs-12 col-sm-3">
                    <div class="card profile-card">
                        <div class="profile-header">&nbsp;</div>
                        <div class="profile-body">
                            <div class="image-area">
                                <img  v-if="datos_tutor.foto"   style="width: 128px;"  v-bind:src="url_image+datos_tutor.foto" alt="" />
                                  <img v-else  style="width: 128px;"  src="<?php echo base_url(); ?>/assets/images/user2.png"  />
                            </div>
                            <div class="content-area">
                                <h3>{{datos_tutor.nombre}} {{datos_tutor.apellidop}} {{datos_tutor.apellidom}}</h3>
                                 <p>{{datos_tutor.escolaridad}}</p>
                                  <p>{{datos_tutor.ocupacion}} </p>
                            </div>
                        </div>
                        <div class="profile-footer"> 
                            <button  @click="abrirSubirFotoModal()" class="btn btn-primary btn-lg waves-effect btn-block"> <i class="fa fa-cloud-upload"></i> SUBIR FOTO</button>
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
                                        <i class="fa fa-pencil"></i> TRABAJA
                                    </div>
                                    <div class="content">
                                      {{datos_tutor.dondetrabaja}}
                                    </div>
                                </li>
                                <li>
                                    <div class="">
                                        <i class="fa fa-map-marker"></i> DIRECCIÓN
                                    </div>
                                    <div class="content">
                                         {{datos_tutor.direccion}}
                                    </div>
                                </li>  
                                 <li>
                                    <div class="">
                                        <i class="fa fa-calendar"></i> NACIMIENTO
                                    </div>
                                    <div class="content">
                                        {{datos_tutor.fnacimiento}}
                                    </div>
                                </li>  
                                 <li>
                                    <div class="">
                                        <i class="fa fa-check-circle"></i> CORREO
                                    </div>
                                    <div class="content">
                                        {{datos_tutor.correo}}
                                    </div>
                                </li>  
                                 <li>
                                    <div class="">
                                        <i class="fa fa-phone"></i> TELEFONO
                                    </div>
                                    <div class="content">
                                         {{datos_tutor.telefono}}
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
                                    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">ALUMNOS</a></li>
                                    
                                </ul>

                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane fade in active" id="home">

                                          <div class="row">
                                            <div class="col-md-12" aling="left">
                                                <button class="btn btn-primary" @click="  abrirAddModal()"><i class='fa fa-plus'></i> Asignar Alumno</button> 
                                              </div>
                                          
                                        </div> 
                                          <table class="table table-hover table-striped">
                                            <thead class="bg-teal">

                                            <th class="text-white" v-column-sortable:nombre>Nombre </th>
                                            <th class="text-white" v-column-sortable:apellidop>A. Paterno </th>
                                            <th class="text-white" v-column-sortable:apellidom>A. Materno </th>
                                             <th class="text-center text-white">Opción </th>
                                            </thead>
                                            <tbody class="table-light">
                                                <tr v-for="alumno in alumnos" class="table-default">
                                                     <td>{{alumno.nombre}}</td>
                                                    <td>{{alumno.apellidop}}</td>
                                                    <td>{{alumno.apellidom}}</td> 
                                                    <td align="right"> 
                                                        <button type="button" class="btn btn-danger btn-sm" @click="deleteAlumno(alumno.idtutoralumno)"  > <i class="fa fa-trash" aria-hidden="true"></i>
                                                          Quitar
                                                        </button> 

                                                    </td>
                                                </tr>
                                                <tr v-if="emptyResult">
                                                    <td colspan="5" class="text-center h4">No encontrado</td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="5" align="right">
                                            <pagination
                                                :current_page="currentPage"
                                                :row_count_page="rowCountPage"
                                                @page-update="pageUpdate"
                                                :total_users="totalAlumnos"
                                                :page_range="pageRange"
                                                >
                                            </pagination>
                                            </td>
                                            </tr>
                                            </tfoot>
                                        </table> 
                                          <?php include 'modalalumno.php'; ?>
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
  <script data-my_var_1="<?php echo base_url() ?>" data-my_var_2="<?php echo $id ?>" src="<?php echo base_url(); ?>/assets/vue/appvue/apptutoralumno.js"></script> 


