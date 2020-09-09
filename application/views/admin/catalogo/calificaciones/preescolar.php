<!-- page content -->
<style>
    ul{
        list-style-type: none;
        margin: 0;
        padding: 0; 
    }

</style>
<div class="right_col" role="main"> 
    <div class="">  
        <div class="row">
            <div class="col-md-12">
                <div class="x_panel">
                    <div class="x_title">
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <h2><strong> <i class="fa fa-check-circle"></i> CALIFICACIONES</strong></h2>
                        </div> 
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content"> 
                        <div class="row"  align="center"> 
							<div id="app" > 
                                <div class="row">
                                    <div class="col-md-3 col-sm-12 col-xs-12 ">
                                        <div class="form-group"> 
                          
                                            <select style="border-bottom: solid #ebebeb 2px;" ref="idperiodo"  name="cicloescolar"   class="form-control">
                                                <option value="">-- CICLO ESCOLAR --</option>   
                                                 <option v-for="option in periodos" v-bind:value="option.idperiodo">
                                                    {{ option.mesinicio }} - {{ option.mesfin }}  {{ option.yearfin }}
                                                </option>
                                            </select> 
                                        </div>
                                    </div>   
                                    <div class="col-md-4 col-sm-12 col-xs-12 ">
                                        <div class="form-group"> 
                                            <select style="border-bottom: solid #ebebeb 2px;" ref="idgrupo" name="grupo" class="form-control">
                                                <option value="">-- GRUPO --</option>  
                                                <option v-for="option in grupos" v-bind:value="option.idgrupo">
                                                    {{ option.nombrenivel }}  {{ option.nombregrupo }}
                                                </option>
                                            </select> 
                                        </div>
                                    </div>  
                                     <div class="col-md-3 col-sm-12 col-xs-12 ">
                                        <div class="form-group"> 
                                            <select style="border-bottom: solid #ebebeb 2px;" ref="idmes" name="grupo" class="form-control">
                                                <option value="">-- MES --</option>  
                                                <option v-for="option in meses" v-bind:value="option.idmes">
                                                    {{ option.nombremes }}
                                                </option>
                                            </select> 
                                        </div>
                                    </div> 
                                     <div class="col-md-2 col-sm-12 col-xs-12 ">
                                        <div class="form-group"> 
                                            <button class="btn btn-default" type="button" @click="searchAlumnos"> <i class="fa fa-search"></i> Buscar</button>
                                           </div>
                                    </div>  
                                </div>
                              <div class="row">
                               <!-- <multiselect v-model="value"  @select="onSelect" :options="materias" :multiple="true" :close-on-select="false" :clear-on-select="false" :preserve-search="true" placeholder="Pick some" label="nombremateria" track-by="nombremateria" :preselect-first="true">
    <template slot="selection" slot-scope="{ values, search, isOpen }"><span class="multiselect__single" v-if="values.length &amp;&amp; !isOpen">{{ values.length }} options selected</span></template>
                                    {{ value  }} -->
                                    <div class="col-md-12 col-sm-12 col-xs-12 ">
                                    	  <table class="table table-hover table-striped">
                                    <thead class="bg-teal">  
                                     <th class="text-white"># </th>
                                    <th class="text-white" v-column-sortable:matricula>MATRICULA </th>
                                    <th class="text-white" v-column-sortable:nombrealumno>NOMBRE </th>
                                    <th class="text-white">ESTATUS </th>
                                   
                                    <th class="text-center text-white">Opción </th>
                                    </thead>
                                    <tbody  >
                                        <tr v-for="(alumno,index) in alumnos"  > 
                                          <td valign="bottom">{{index + 1 }}</td>
                                            <td valign="bottom">{{alumno.matricula}}</td>
                                            <td valign="middle">{{alumno.nombrealumno}}</td>
                                            <td>
                                            <span v-if="alumno.registrado && alumno.registrado == 0" class="label label-info" >NO REGISTRADO</span>
                                             <span v-if="alumno.registrado && alumno.registrado > 0" class="label label-success" >REGISTRADO</span>
                                            </td>
                                            <td align="right"> 
												 	  <button v-if="alumno.registrado && alumno.registrado == 0 && alumno.activo == 1" type="button" class="btn btn-primary btn-sm" @click="abrirAddModal();seleccionarAlumno(alumno.idalumno)">Agregar</button>
												 	  <button v-if="alumno.registrado && alumno.registrado > 0 && alumno.activo == 1" type="button" @click="abrirEditModal(); seleccionarAlumnoEditar(alumno.idalumno)" class="btn btn-info btn-sm">Editar</button>
												      <button v-if="alumno.registrado && alumno.registrado > 0 " @click="abrirDetalleModal(); seleccionarAlumnoEditar(alumno.idalumno)" type="button" class="btn btn-default btn-sm"> Detalle</button>

                                            </td>
                                        </tr>
                                       
                                    </tbody> 
                                </table> 
                                    </div>
                              </div>
                              <?php include 'modal_preescolar.php'; ?>
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
<script src="<?php echo base_url(); ?>/assets/vue/vue2-filters.min.js"></script>
  <script data-my_var_1="<?php echo base_url() ?>" src="<?php echo base_url(); ?>/assets/vue/appvue/administrador/calificaciones/appcalificaciones_preescolar.js"></script> 
