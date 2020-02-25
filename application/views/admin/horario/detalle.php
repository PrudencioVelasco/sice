  <!-- page content -->
  <div class="right_col" role="main">

<div class=""> 

  <div class="row">
    <div class="col-md-12">
      <div class="x_panel">
        <div class="x_title">
          <h2><strong>ADMINISTRAR MATERIAS DEL HORARIO</strong></h2>
         
          <div class="clearfix"></div>
        </div>
        <div class="x_content">

          <div class="row"> 

             <div id="appd">
                  <div class="row">
                           <div class="col-md-12">
                              <?php if($activo_horario == 1 && $activo_ciclo_escolar == 1){ ?>
                                <button class="btn btn-round btn-primary" @click="addModal= true"><i class='fa fa-plus'></i> Agregar Materia</button> 

                                <button class="btn btn-round btn-primary" @click="addModalRecreo= true"><i class='fa fa-plus'></i> Agregar Receso</button> 
                              <?php } ?>
                                <a  target="_blank" class="btn btn-round btn-info" href="<?php echo base_url(); ?>/horario/imprimirHorario/<?php echo $id ?>" class="btn btn-primary"><i class="fa fa-print"></i> Imprimir Horario</a>
                            </div> 
                  </div> 
                   <table class="table">
                    <thead>
                      <tr> 
                        <th>LUNES</th>
                        <th>MARTES</th>
                        <th>MIERCOLES</th>
                        <th>JUEVES</th>
                        <th>VIERNES</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr> 
                        <td >
                          <div v-for="row in lunes">  
                            <ul class="nav navbar-right panel_toolbox" style="border: 2px solid #ccc; border-radius: 4px; margin-bottom: 4px">
                                <li><a class="collapse-link " style="color: #000"> 
                                  <div  v-if="row.opcion != 'Descanso'">
                                    <strong>{{row.nombreclase}} </strong> ({{row.horainicial}}-{{row.horafinal}})<br>
                                    <small>{{row.nombre}} {{row.apellidop}} {{row.apellidom}}</small>
                                  </div>
                                  <div v-else>
                                     <strong>{{row.nombreclase}} </strong> ({{row.horainicial}}-{{row.horafinal}})
                                  </div>
                                </a>
                                </li>
                                 <?php if($activo_horario == 1 && $activo_ciclo_escolar == 1){ ?>
                                <li class="dropdown">
                                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                  <ul class="dropdown-menu" role="menu">

                                     <li v-if="row.opcion != 'Descanso'"><a @click="editModal = true; selectHorario(row)" href="#">Editar</a>
                                    </li>
                                    <li v-else><a @click="editModalRecreo = true; selectHorario(row)" href="#">Editar</a>
                                    </li>


                                   <li v-if="row.opcion != 'Descanso'"><a href="#" @click="deleteHorario(row.idhorariodetalle); selectHorario(row);">Eliminar</a>
                                    </li>
                                    <li v-else><a href="#" @click="deleteReceso(row.idhorariodetalle); selectHorario(row);">Eliminar</a>
                                    </li>
                                    
                                  </ul>
                                </li> 
                              <?php } ?>
                              </ul> 
                          </div>
                       </td>
                        <td>
                          <div v-for="row in martes">  
                             <ul class="nav navbar-right panel_toolbox" style="border: 2px solid #ccc; border-radius: 4px; margin-bottom: 4px">
                                <li><a class="collapse-link " style="color: #000">
                                  <div  v-if="row.opcion != 'Descanso'">
                                    <strong>{{row.nombreclase}} </strong> ({{row.horainicial}}-{{row.horafinal}})<br>
                                    <small>{{row.nombre}} {{row.apellidop}} {{row.apellidom}}</small>
                                  </div>
                                  <div v-else>
                                     <strong>{{row.nombreclase}} </strong> ({{row.horainicial}}-{{row.horafinal}})
                                  </div>
                                </a>
                                </li>
                                 <?php if($activo_horario == 1 && $activo_ciclo_escolar == 1){ ?>
                                <li class="dropdown">
                                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                  <ul class="dropdown-menu" role="menu">
                                    <li v-if="row.opcion != 'Descanso'"><a @click="editModal = true; selectHorario(row)" href="#">Editar</a>
                                    </li>
                                    <li v-else><a @click="editModalRecreo = true; selectHorario(row)" href="#">Editar</a>
                                    </li>
                                  <li v-if="row.opcion != 'Descanso'"><a href="#" @click="deleteHorario(row.idhorariodetalle); selectHorario(row);">Eliminar</a>
                                    </li>
                                    <li v-else><a href="#" @click="deleteReceso(row.idhorariodetalle); selectHorario(row);">Eliminar</a>
                                    </li>
                                  </ul>
                                </li> 
                              <?php } ?>
                              </ul> 
                          </div>
                        </td> 
                        <td>
                          <div v-for="row in miercoles">  
                             <ul class="nav navbar-right panel_toolbox" style="border: 2px solid #ccc; border-radius: 4px; margin-bottom: 4px">
                                <li><a class="collapse-link " style="color: #000">
                                  <div  v-if="row.opcion != 'Descanso'">
                                    <strong>{{row.nombreclase}} </strong> ({{row.horainicial}}-{{row.horafinal}})<br>
                                    <small>{{row.nombre}} {{row.apellidop}} {{row.apellidom}}</small>
                                  </div>
                                  <div v-else>
                                     <strong>{{row.nombreclase}} </strong> ({{row.horainicial}}-{{row.horafinal}})
                                  </div>
                                </a>
                                </li>
                                 <?php if($activo_horario == 1 && $activo_ciclo_escolar == 1){ ?>
                                <li class="dropdown">
                                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                  <ul class="dropdown-menu" role="menu">
                                   <li v-if="row.opcion != 'Descanso'"><a @click="editModal = true; selectHorario(row)" href="#">Editar</a>
                                    </li>
                                    <li v-else><a @click="editModalRecreo = true; selectHorario(row)" href="#">Editar</a>
                                    </li>
                                  <li v-if="row.opcion != 'Descanso'"><a href="#" @click="deleteHorario(row.idhorariodetalle); selectHorario(row);">Eliminar</a>
                                    </li>
                                    <li v-else><a href="#" @click="deleteReceso(row.idhorariodetalle); selectHorario(row);">Eliminar</a>
                                    </li>
                                  </ul>
                                </li> 
                              <?php } ?>
                              </ul> 
                          </div></td>
                        <td>
                          <div v-for="row in jueves">  
                            <ul class="nav navbar-right panel_toolbox" style="border: 2px solid #ccc; border-radius: 4px; margin-bottom: 4px">
                                <li><a class="collapse-link " style="color: #000">
                                  <div  v-if="row.opcion != 'Descanso'">
                                    <strong>{{row.nombreclase}} </strong> ({{row.horainicial}}-{{row.horafinal}})<br>
                                    <small>{{row.nombre}} {{row.apellidop}} {{row.apellidom}}</small>
                                  </div>
                                  <div v-else>
                                     <strong>{{row.nombreclase}} </strong> ({{row.horainicial}}-{{row.horafinal}})
                                  </div>
                                </a>
                                </li>
                                 <?php if($activo_horario == 1 && $activo_ciclo_escolar == 1){ ?>
                                <li class="dropdown">
                                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                  <ul class="dropdown-menu" role="menu">
                                    <li v-if="row.opcion != 'Descanso'"><a @click="editModal = true; selectHorario(row)" href="#">Editar</a>
                                    </li>
                                    <li v-else><a @click="editModalRecreo = true; selectHorario(row)" href="#">Editar</a>
                                    </li>
                                   <li v-if="row.opcion != 'Descanso'"><a href="#" @click="deleteHorario(row.idhorariodetalle); selectHorario(row);">Eliminar</a>
                                    </li>
                                    <li v-else><a href="#" @click="deleteReceso(row.idhorariodetalle); selectHorario(row);">Eliminar</a>
                                    </li>
                                  </ul>
                                </li> 
                              <?php } ?>
                              </ul> 
                          </div>
                        </td>
                        <td>
                          <div v-for="row in viernes">  
                            <ul class="nav navbar-right panel_toolbox" style="border: 2px solid #ccc; border-radius: 4px; margin-bottom: 4px">
                                <li><a class="collapse-link " style="color: #000">
                                  <div  v-if="row.opcion != 'Descanso'">
                                    <strong>{{row.nombreclase}} </strong> ({{row.horainicial}}-{{row.horafinal}})<br>
                                    <small>{{row.nombre}} {{row.apellidop}} {{row.apellidom}}</small>
                                  </div>
                                  <div v-else>
                                     <strong>{{row.nombreclase}} </strong> ({{row.horainicial}}-{{row.horafinal}})
                                  </div>
                                </a>
                                </li>
                                 <?php if($activo_horario == 1 && $activo_ciclo_escolar == 1){ ?>
                                <li class="dropdown">
                                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                  <ul class="dropdown-menu" role="menu">
                                   <li v-if="row.opcion != 'Descanso'"><a @click="editModal = true; selectHorario(row)" href="#">Editar</a>
                                    </li>
                                    <li v-else><a @click="editModalRecreo = true; selectHorario(row)" href="#">Editar</a>
                                    </li>
                                   <li v-if="row.opcion != 'Descanso'"><a href="#" @click="deleteHorario(row.idhorariodetalle); selectHorario(row);">Eliminar</a>
                                    </li>
                                    <li v-else><a href="#" @click="deleteReceso(row.idhorariodetalle); selectHorario(row);">Eliminar</a>
                                    </li>
                                  </ul>
                                </li> 
                              <?php } ?>
                              </ul> 
                          </div>
                        </td>
                      </tr>
                      
                    </tbody>
                  </table>
                    <?php include 'modaldet.php'; ?>


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
<script data-my_var_1="<?php echo base_url() ?>" data-my_var_2="<?php echo $id; ?>" src="<?php echo base_url(); ?>/assets/vue/appvue/apphorariodetalle.js"></script> 


