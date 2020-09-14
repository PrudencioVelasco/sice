<div class="modal fade" id="abrirModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12 " align="left">
                        <h4 class="modal-title" id="defaultModalLabel">BOLETA DE CALIFICACIONES</h4>
                    </div>
                    
                </div>
            </div>
            <div class="modal-body">
                <div style="padding-top:13px; padding-right:15px;">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <label style="color: red" v-html="formValidate.msgerror"></label>
                        </div>
                    </div>
                     
                    
                    <div class="row clearfix ">
                        <div class="col-md-7 col-sm-12 col-xs-12 ">

                            <div class="form-group"> 
                               <multiselect v-model="value"  @select="onSelect" :options="materias" :multiple="true" :close-on-select="false" :clear-on-select="false" :preserve-search="true" placeholder="ASIGNATURA" label="nombremateria" track-by="nombremateria" :preselect-first="true">
    							<template slot="selection" slot-scope="{ values, search, isOpen }"><span class="multiselect__single" v-if="values.length &amp;&amp; !isOpen">{{ values.length }} options selected</span></template>
                               
                            </div>
                        </div> 
                        <div class="col-md-3 col-sm-12 col-xs-12 ">
                            <div class="form-group">
                                 <select style="border-bottom: solid #ebebeb 2px;" v-model="idtipocalificacion"   :class="{'is-invalid': formValidate.idperiodo}" class="form-control">
                                    <option value="">-- CALIFICACION --</option>
                                    <option   v-for="option in tiposcalificacion" v-bind:value="option.idtipocalificacion">
                                        {{ option.tipocalificacion }} 
                                    </option>
                                </select>
                               
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-12 col-xs-12 ">
                            <div class="form-group">
                                <button @click="agregarMateria"   class="btn btn-info"> <i class="fa fa-plus" aria-hidden="true"></i> Agregar</button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <table class=" table table-striped dt-responsive nowrap" cellspacing="0">
                                <thead class="bg-teal">
                                <th>CURSO</th>
                                <th>CALIFICACION</th>
                              
                                <th></th>
                                </thead>
                                <tbody>
                                    <tr v-for="row in materias_seleccionadas" >
                                        <td>{{row.nombremateria}}</td>
                                        <td >
                                        	<span v-if="row.idcalificacion && row.idcalificacion == 1" >EXCELENTE</span>
                                        	<span v-if="row.idcalificacion && row.idcalificacion == 2" >MUY BIEN</span>
                                        	<span v-if="row.idcalificacion && row.idcalificacion == 3" >BIEN</span>
                                        	<span v-if="row.idcalificacion && row.idcalificacion == 4" >NECESITA APOYO</span>
                                        </td>
                                        <td align="right">
                                          <button type="button" @click="eliminarMateria(row.idmateria)" class="btn btn-danger btn-sm">Quitar</button>
                                        </td>
                                       
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div  class="col-md-6 col-sm-12 col-xs-12 " align="center" >
                        <div v-if="cargando">
                            <img  style="width: 50px;" src="<?php echo base_url() . '/assets/loader/pagos.gif' ?>" alt=""> <strong>Procesando...</strong>
                        </div>
                        <div v-if="error"  align="left">
                            <label class="col-red">*Corrija los errores en el formulario.</label>
                        </div>
                       
                    </div>
                    <div class="col-md-6 col-sm-12 col-xs-12 "  align="right"  >
                        <button type="button" class="btn btn-danger waves-effect waves-black"  @click="clearAll"> <i class="fa fa-times"></i> Cancelar</button>
                        <button class="btn btn-primary waves-effect waves-black" @click="registrarCalificacion" ><i class="fa fa-check-circle"></i> Registrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 


<div class="modal fade" id="abrirEditModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12 " align="left">
                        <h4 class="modal-title" id="defaultModalLabel">MODIFICAR BOLETA DE CALIFICACIONES</h4>
                    </div>
                    
                </div>
            </div>
            <div class="modal-body">
                <div style="padding-top:13px; padding-right:15px;">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <label style="color: red" v-html="formValidate.msgerror"></label>
                        </div>
                    </div>
                     
                    
                    <div class="row clearfix ">
                        <div class="col-md-7 col-sm-12 col-xs-12 ">

                            <div class="form-group"> 
                               <multiselect v-model="value"  @select="onSelect" :options="materias" :multiple="true" :close-on-select="false" :clear-on-select="false" :preserve-search="true" placeholder="ASIGNATURA" label="nombremateria" track-by="nombremateria" :preselect-first="true">
    							<template slot="selection" slot-scope="{ values, search, isOpen }"><span class="multiselect__single" v-if="values.length &amp;&amp; !isOpen">{{ values.length }} options selected</span></template>
                               
                            </div>
                        </div> 
                        <div class="col-md-3 col-sm-12 col-xs-12 ">
                            <div class="form-group">
                                 <select style="border-bottom: solid #ebebeb 2px;" v-model="idtipocalificacion"   :class="{'is-invalid': formValidate.idperiodo}" class="form-control">
                                    <option value="">-- CALIFICACION --</option>
                                    <option   v-for="option in tiposcalificacion" v-bind:value="option.idtipocalificacion">
                                        {{ option.tipocalificacion }} 
                                    </option>
                                </select>
                               
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-12 col-xs-12 ">
                            <div class="form-group">
                                <button @click="agregarMateria"   class="btn btn-info"> <i class="fa fa-plus" aria-hidden="true"></i> Agregar</button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <table class=" table table-striped dt-responsive nowrap" cellspacing="0">
                                <thead class="bg-teal">
                                <th>CURSO</th>
                                <th>CALIFICACION</th>
                              
                                <th></th>
                                </thead>
                                <tbody>
                                    <tr v-for="row in materias_registradas" >
                                        <td>{{row.nombremateria}}</td>
                                        <td >
                                        	<span v-if="row.idtipocalificacion && row.idtipocalificacion == 1" >EXCELENTE</span>
                                        	<span v-if="row.idtipocalificacion && row.idtipocalificacion == 2" >MUY BIEN</span>
                                        	<span v-if="row.idtipocalificacion && row.idtipocalificacion == 3" >BIEN</span>
                                        	<span v-if="row.idtipocalificacion && row.idtipocalificacion == 4" >NECESITA APOYO</span>
                                        </td>
                                        <td align="right">
                                          <button type="button" @click="eliminarMateriaAlumno(row)" class="btn btn-danger btn-sm">Quitar</button>
                                        </td>
                                       
                                    </tr>
                                     <tr v-for="row in materias_seleccionadas" >
                                        <td>{{row.nombremateria}}</td>
                                        <td >
                                        	<span v-if="row.idcalificacion && row.idcalificacion == 1" >EXCELENTE</span>
                                        	<span v-if="row.idcalificacion && row.idcalificacion == 2" >MUY BIEN</span>
                                        	<span v-if="row.idcalificacion && row.idcalificacion == 3" >BIEN</span>
                                        	<span v-if="row.idcalificacion && row.idcalificacion == 4" >NECESITA APOYO</span>
                                        </td>
                                        <td align="right">
                                          <button type="button" @click="eliminarMateria(row.idmateria)" class="btn btn-danger btn-sm">Quitar</button>
                                        </td>
                                       
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div  class="col-md-6 col-sm-12 col-xs-12 " align="center" >
                        <div v-if="cargando">
                            <img  style="width: 50px;" src="<?php echo base_url() . '/assets/loader/pagos.gif' ?>" alt=""> <strong>Procesando...</strong>
                        </div>
                        <div v-if="error"  align="left">
                            <label class="col-red">*Corrija los errores en el formulario.</label>
                        </div>
                       
                    </div>
                    <div class="col-md-6 col-sm-12 col-xs-12 "  align="right"  >
                        <button type="button" class="btn btn-danger waves-effect waves-black"  @click="clearAll"> <i class="fa fa-times"></i> Cancelar</button>
                        <button class="btn btn-primary waves-effect waves-black" @click="registrarCalificacion" ><i class="fa fa-pencil"></i> Modificar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 



<div class="modal fade" id="abrirDetalleModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12 " align="left">
                        <h4 class="modal-title" id="defaultModalLabel">DETALLES DE LA BOLETA DE CALIFICACIONES</h4>
                    </div>
                    
                </div>
            </div>
            <div class="modal-body">
                <div style="padding-top:13px; padding-right:15px;"> 
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <table class=" table table-striped dt-responsive nowrap" cellspacing="0">
                                <thead class="bg-teal">
                                <th>CURSO</th>
                                <th></th> 
                                </thead>
                                <tbody>
                                    <tr v-for="row in calificaciones_registradas" >
                                        <td>{{row.nombremateria}}</td>
                                        <td >
                                        {{row.abreviatura}}
                                         </td> 
                                    </tr> 
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="row"> 
                    <div class="col-md-12 col-sm-12 col-xs-12 "  align="right"  >
                        <button type="button" class="btn btn-danger waves-effect waves-black"  @click="clearAll"> <i class="fa fa-times"></i> Cerrar</button>
                     </div>
                </div>
            </div>
        </div>
    </div>
</div> 



<div class="modal fade" id="abrirAddFaltasModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12 " align="left">
                        <h4 class="modal-title" id="defaultModalLabel">AGREGAR FALTAS</h4>
                    </div>
                    
                </div>
            </div>
            <div class="modal-body">
                <div >
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <label style="color: red" v-html="formValidate.msgerror"></label>
                        </div>
                    </div>
                          <div class="row clearfix">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float ">
                                <div class="form-line">
                                    <label class="form-label">
                                        <font color="red">*</font> FALTAS
                                    </label>
                                    <input type="text" v-model="newFaltas.totalfaltas" class="form-control"
                                        :class="{'is-invalid': formValidate.totalfaltas}" name="po">
                                </div>
                                <div class="col-red" v-html="formValidate.totalfaltas"></div>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div  class="col-md-6 col-sm-12 col-xs-12 " align="center" >
                        <div v-if="cargando">
                            <img  style="width: 50px;" src="<?php echo base_url() . '/assets/loader/pagos.gif' ?>" alt=""> <strong>Procesando...</strong>
                        </div>
                        <div v-if="error"  align="left">
                            <label class="col-red">*Corrija los errores en el formulario.</label>
                        </div>
                       
                    </div>
                    <div class="col-md-6 col-sm-12 col-xs-12 "  align="right"  >
                        <button type="button" class="btn btn-danger waves-effect waves-black"  @click="clearAll"> <i class="fa fa-times"></i> Cancelar</button>
                        <button class="btn btn-primary waves-effect waves-black" @click="registrarFaltas" ><i class="fa fa-pencil"></i> Agregar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 

<div class="modal fade" id="abrirEditFaltasModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12 " align="left">
                        <h4 class="modal-title" id="defaultModalLabel">EDITAR FALTAS</h4>
                    </div>
                    
                </div>
            </div>
            <div class="modal-body">
                <div >
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <label style="color: red" v-html="formValidate.msgerror"></label>
                        </div>
                    </div>
                          <div class="row clearfix">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                             <div class="form-group form-float">
                                <div class="form-line focused">
                                    <label class="form-label">
                                        <font color="red">*</font> FALTAS
                                    </label>
                                    <input type="text" v-model="chooseAsistencia.faltas" class="form-control"
                                        :value="chooseAsistencia.faltas" :class="{'is-invalid': formValidate.matricula}"
                                        name="po">
                                </div>
                                <div class="col-red" v-html="formValidate.faltas"></div>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div  class="col-md-6 col-sm-12 col-xs-12 " align="center" >
                        <div v-if="cargando">
                            <img  style="width: 50px;" src="<?php echo base_url() . '/assets/loader/pagos.gif' ?>" alt=""> <strong>Procesando...</strong>
                        </div>
                        <div v-if="error"  align="left">
                            <label class="col-red">*Corrija los errores en el formulario.</label>
                        </div>
                       
                    </div>
                    <div class="col-md-6 col-sm-12 col-xs-12 "  align="right"  >
                        <button type="button" class="btn btn-danger waves-effect waves-black"  @click="clearAll"> <i class="fa fa-times"></i> Cancelar</button>
                        <button class="btn btn-primary waves-effect waves-black" @click="updateAsistencia" ><i class="fa fa-pencil"></i> Modificar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 

