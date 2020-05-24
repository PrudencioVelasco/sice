  <!-- page content -->
  <div class="right_col" role="main">

<div class=""> 

  <div class="row">
    <div class="col-md-12">
      <div class="x_panel">
        <div class="x_title">
          <h2><strong>HORARIO ESCOLAR</strong></h2> 
          <div class="clearfix"></div>
        </div>
        <div class="x_content">

          <div class="row"> 

             <div id="appd">
                  <div class="row">
                           <div class="col-md-12" align="right"> 
                              <a target="_blank" class="btn btn-round btn-primary" href="<?php echo base_url(); ?>/alumno/generarHorarioPDF/<?php echo $idhorario."/".$idalumno ?>"> <i class="fa fa-print"></i> Imprimir Horario</a>
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
                                  <div  v-if="row.opcion == 'NORMAL'">
                                    <strong>{{row.nombreclase}} </strong> ({{row.horainicial}}-{{row.horafinal}})<br>
                                    <small>{{row.nombre}} {{row.apellidop}} {{row.apellidom}}</small>
                                  </div>
                                  <div v-else-if="row.opcion == 'DESCANSO'">
                                     <strong>{{row.nombreclase}} </strong> ({{row.horainicial}}-{{row.horafinal}})
                                  </div>
                                  <div v-else>
                                     <strong>SIN CLASES</strong> ({{row.horainicial}}-{{row.horafinal}})
                                  </div>
                                </a>
                                </li>
                              </ul> 
                          </div>
                       </td>
                        <td>
                          <div v-for="row in martes">  
                             <ul class="nav navbar-right panel_toolbox" style="border: 2px solid #ccc; border-radius: 4px; margin-bottom: 4px">
                               <li><a class="collapse-link " style="color: #000"> 
                                  <div  v-if="row.opcion == 'NORMAL'">
                                    <strong>{{row.nombreclase}} </strong> ({{row.horainicial}}-{{row.horafinal}})<br>
                                    <small>{{row.nombre}} {{row.apellidop}} {{row.apellidom}}</small>
                                  </div>
                                  <div v-else-if="row.opcion == 'DESCANSO'">
                                     <strong>{{row.nombreclase}} </strong> ({{row.horainicial}}-{{row.horafinal}})
                                  </div>
                                  <div v-else>
                                     <strong>SIN CLASES</strong> ({{row.horainicial}}-{{row.horafinal}})
                                  </div>
                                </a>
                                </li> 
                              </ul> 
                          </div>
                        </td> 
                        <td>
                          <div v-for="row in miercoles">  
                             <ul class="nav navbar-right panel_toolbox" style="border: 2px solid #ccc; border-radius: 4px; margin-bottom: 4px">
                               <li><a class="collapse-link " style="color: #000"> 
                                  <div  v-if="row.opcion == 'NORMAL'">
                                    <strong>{{row.nombreclase}} </strong> ({{row.horainicial}}-{{row.horafinal}})<br>
                                    <small>{{row.nombre}} {{row.apellidop}} {{row.apellidom}}</small>
                                  </div>
                                  <div v-else-if="row.opcion == 'DESCANSO'">
                                     <strong>{{row.nombreclase}} </strong> ({{row.horainicial}}-{{row.horafinal}})
                                  </div>
                                  <div v-else>
                                     <strong>SIN CLASES</strong> ({{row.horainicial}}-{{row.horafinal}})
                                  </div>
                                </a>
                                </li>
                              </ul> 
                          </div></td>
                        <td>
                          <div v-for="row in jueves">  
                            <ul class="nav navbar-right panel_toolbox" style="border: 2px solid #ccc; border-radius: 4px; margin-bottom: 4px">
                               <li><a class="collapse-link " style="color: #000"> 
                                  <div  v-if="row.opcion == 'NORMAL'">
                                    <strong>{{row.nombreclase}} </strong> ({{row.horainicial}}-{{row.horafinal}})<br>
                                    <small>{{row.nombre}} {{row.apellidop}} {{row.apellidom}}</small>
                                  </div>
                                  <div v-else-if="row.opcion == 'DESCANSO'">
                                     <strong>{{row.nombreclase}} </strong> ({{row.horainicial}}-{{row.horafinal}})
                                  </div>
                                  <div v-else>
                                     <strong>SIN CLASES</strong> ({{row.horainicial}}-{{row.horafinal}})
                                  </div>
                                </a>
                                </li> 
                              </ul> 
                          </div>
                        </td>
                        <td>
                          <div v-for="row in viernes">  
                            <ul class="nav navbar-right panel_toolbox" style="border: 2px solid #ccc; border-radius: 4px; margin-bottom: 4px">
                              <li><a class="collapse-link " style="color: #000"> 
                                  <div  v-if="row.opcion == 'NORMAL'">
                                    <strong>{{row.nombreclase}} </strong> ({{row.horainicial}}-{{row.horafinal}})<br>
                                    <small>{{row.nombre}} {{row.apellidop}} {{row.apellidom}}</small>
                                  </div>
                                  <div v-else-if="row.opcion == 'DESCANSO'">
                                     <strong>{{row.nombreclase}} </strong> ({{row.horainicial}}-{{row.horafinal}})
                                  </div>
                                  <div v-else>
                                     <strong>SIN CLASES</strong> ({{row.horainicial}}-{{row.horafinal}})
                                  </div>
                                </a>
                                </li> 
                              </ul> 
                          </div>
                        </td>
                      </tr>
                      
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
<script data-my_var_1="<?php echo base_url() ?>" data-my_var_2="<?php echo $idhorario; ?>" src="<?php echo base_url(); ?>/assets/vue/appvue/apphorariodetalle.js"></script> 


