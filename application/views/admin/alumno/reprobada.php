<!-- page content -->
<div class="right_col" role="main"> 
    <div class=""> 
        <div class="row">
            <div class="col-md-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><strong>RECURSAMIENTOS DE ALUMNOS</strong></h2> 
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">  

                        <div id="app"> 
                            <div class="container"> 
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12 ">
                                        <div class="col-red" v-html="formValidate.msgerror"></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5 col-sm-12 col-xs-12 ">
                                        <div class="form-group">
                                           
                                                <label><font color="red">*</font> REPROBADO</label>
                                                <select class="form-control"  @change="onChange($event)" v-model="nuevaAsignacion.idreprobada" >
                                                    <option value="">-- SELECCIONAR --</option>
                                                      <option  v-for="option in materiaspenditesaasignar" v-bind:value="option.idreprobada">
                                                                {{ option.nombre  }}  {{ option.apellidop  }}  {{ option.apellidom  }} -  {{ option.nombreclase  }}
                                                        </option>
                                                </select>
                                            
                                            <div class="col-red" v-html="formValidate.idreprobada"></div>
                                        </div>
                                    </div>  
                                    <div class="col-md-5 col-sm-12 col-xs-12 ">
                                        <div class="form-group"> 
                                                <label  ><font color="red">*</font> ASIGNARSELO A</label>
                                                <select class="form-control" v-model="nuevaAsignacion.idhorariodetalle" >
                                                  <option value="">-- SELECCIONAR --</option>
                                                      <option  v-for="option in materiasdisponibles" v-bind:value="option.idhorariodetalle">
                                                                {{ option.profesor  }} - {{ option.nombrenivel  }}  {{ option.nombregrupo  }}
                                                        </option>
                                                </select>
                                           
                                            <div class="col-red" v-html="formValidate.idhorariodetalle"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-12 col-xs-12">
                                        <button type="button" @click="addAsignacion()"  style="margin-top: 25px"  class="btn btn-primary  m-l-15 waves-effect"> <i class="fa fa-plus " ></i> ASIGNAR</button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12 ">
                                        <table class="table table-striped dt-responsive nowrap">
                                            <tr  class="bg-teal">
                                                <td colspan="3" align="center" style="border-right: solid 2px #ccc;">
                                                    <label>REPROBADO</label>
                                                </td>
                                                <td colspan="3" align="center">
                                                    <label>RECUPERARÁ CON</label>
                                                </td>
                                            </tr>
                                            <tr  class="bg-teal">
                                                <td>Alumno</td>
                                                <td>Grupo</td>
                                                <td  style="border-right: solid 2px #ccc;">Materia</td>
                                                <td>Grupo</td>
                                                <td>Profesor</td>
                                                <td></td>
                                            </tr>
                                            <tr v-for="row in materiasasignadas">
                                                <td>{{ row.nombre}} {{ row.apellidop}} {{ row.apellidom}}</td>
                                                <td>{{ row.nombrenivel}} {{ row.nombregrupo}}</td>
                                                <td  style="border-right: solid 2px #ccc;">
                                                    {{ row.nombreclase}}
                                                </td>
                                                <td>{{ row.nombrenivel2}} {{ row.nombregrupo2}}</td>
                                                <td>{{ row.profesor}}</td>
                                                <td align="right">
                                                    <button @click="deleteAlumno(row.iddetalle)" class="btn btn-danger btn-sm"> <i class="fa fa-trash" ></i> Eliminar</button>
                                                </td>
                                            </tr>
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
<script data-my_var_1="<?php echo base_url() ?>" src="<?php echo base_url(); ?>/assets/vue/appvue/appasignacion_materia.js"></script> 


