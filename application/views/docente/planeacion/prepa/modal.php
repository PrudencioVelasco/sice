<div class="modal fade" id="addRegister" tabindex="-1" role="dialog">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #f2f2f2;">
                <h4 class="modal-title" id="smallModalLabel">AGREGAR PLANIFICACIÓN</h4>
            </div>
            <div class="modal-body">
                <div style=" height: 300px; padding-top:13px; padding-right:15px; overflow-x: hidden; overflow-y: scroll;">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <label class="col-red" v-html="formValidate.msgerror"></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <div class="form-group"> 
                                <select style="border-bottom: solid #ebebeb 2px;" v-model="newPlanificacion.idprofesor"  :class="{'is-invalid': formValidate.idprofesor}" class="form-control">
                                    <option value="" selected>-- MATERIA --</option>  
                                    <option   v-for="option in grupos" v-bind:value="option.idhorariodetalle">
                                        {{ option.nombreclase }}   ( {{ option.nombrenivel }} -  {{ option.nombregrupo }} )   
                                    </option>
                                </select>
                                <div class="col-red" v-html="formValidate.idprofesor"></div>
                            </div>
                        </div> 
                    </div> 

                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group">

                                <label > <font color="red" >*</font> OBJETIVO DEL CURSO</label>

                                <ckeditor :editor="editor" v-model="newPlanificacion.obetivocurso" :config="editorConfig"></ckeditor>
                                <div class="col-red" v-html="formValidate.obetivocurso"></div>
                            </div>
                        </div>  
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group">

                                <label > <font color="red" >*</font> VALOR DEL MES</label> 
                                <ckeditor :editor="editor" v-model="newPlanificacion.valordelmes" :config="editorConfig"></ckeditor>
                                <div class="col-red" v-html="formValidate.valordelmes"></div>
                            </div>
                        </div> 
                    </div> 
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group">

                                <label > <font color="red" >*</font> MATERIAL</label> 
                                <ckeditor :editor="editor" v-model="newPlanificacion.materia" :config="editorConfig"></ckeditor>
                                <div class="col-red" v-html="formValidate.materia"></div>
                            </div>
                        </div>  
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group">

                                <label > <font color="red" >*</font> BIBLIOGRAFÍA</label> 
                                <ckeditor :editor="editor" v-model="newPlanificacion.bibliografia" :config="editorConfig"></ckeditor>
                                <div class="col-red" v-html="formValidate.bibliografia"></div>
                            </div>
                        </div> 
                    </div> 

                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <div class="form-group">
                                <label > <font color="red" >*</font> COMPETENCIAS A DESARROLAR</label> 
                                <ckeditor :editor="editor" v-model="newPlanificacion.competenciaadesarrollar" :config="editorConfig"></ckeditor>
                                <div class="col-red" v-html="formValidate.competenciaadesarrollar"></div>
                            </div>
                        </div> 
                    </div> 
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <button @click="abrirAddDetalleModal()" class="btn btn-info" ><i class="fa fa-plus-circle" ></i> AGREGAR ACTIVIDAD</button>
                        </div> 
                    </div> 
                       <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <table class=" table table-striped dt-responsive nowrap" cellspacing="0">
                                <thead class="bg-teal">
                                <th>Semana</th>
                                <th>Fecha</th>
                                <th>Objetivo</th>
                                 <th>Contenido</th>
                                <th></th>
                                </thead>
                                <tbody>
                                    <tr v-for="(row, index) in detalleplanificacion">
                                        <td >{{row.semana}}</td>
                                        <td >{{row.fecha}}</td>
                                        <td ><div v-html="row.objetivo"></div></td>
                                        <td > <div v-html="row.contenido"></div></td>
                                        <td align="right"><button  @click="deleteItem(index)" class="btn btn-danger">Quitar</button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <div class="form-group  form-float">
                                <div class="form-line">
                                    <label class="form-label"> OBSERVACIONES (DOCENTES)</label>

                                    <textarea  v-model="newPlanificacion.observacion" class="form-control" :class="{'is-invalid': formValidate.observacionesdocente}" name="message"></textarea>
                                </div>
                                <div class="col-red" v-html="formValidate.observacion"></div>
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
                        <button class="btn btn-danger waves-effect waves-black" @click="clearAll"><i class='fa fa-ban'></i> Cancelar</button>
                        <button class="btn btn-primary waves-effect waves-black" @click="addPlanificacion"><i class='fa fa-floppy-o'></i> Agregar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="editRegister" tabindex="-1" role="dialog">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="smallModalLabel">EDITAR PLANIFICACIÓN</h4>
            </div>
            <div class="modal-body">
                <div style=" height: 300px; padding-top:13px; padding-right:15px; overflow-x: hidden; overflow-y: scroll;">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <label class="col-red" v-html="formValidate.msgerror"></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group"> 
                                <select style="border-bottom: solid #ebebeb 2px;" v-model="choosePlanificacion.idhorariodetalle"    :class="{'is-invalid': formValidate.idhorariodetalle}"class="form-control">
                                    <option value="" selected>-- MATERIA --</option>  
                                    <option   v-for="option in grupos" :selected="option.idhorariodetalle == choosePlanificacion.idhorariodetalle ? 'selected' : ''" v-bind:value="option.idhorariodetalle">
                                        {{ option.nombreclase }}   ( {{ option.nombrenivel }} -  {{ option.nombregrupo }} )   
                                    </option>
                                </select>
                                <div class="col-red" v-html="formValidate.idhorariodetalle"></div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12 col-xs-12 ">
                            <div class="form-group  form-float">
                                <div class="form-line focused">
                                    <label class="form-label"> <font color="red" >*</font> FECHA DE EJECUCIÓN</label>
                                    <input type="text" v-model="choosePlanificacion.fechaejecucion" class="form-control"
                                           :class="{'is-invalid': formValidate.fechaejecucion}" name="po">
                                </div>
                                <small>Formato: dd/mm/yyyy</small>
                                <div class="col-red" v-html="formValidate.fechaejecucion"></div>

                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12 col-xs-12 ">
                            <div class="form-group  form-float">
                                <div class="form-line focused">
                                    <label class="form-label"> <font color="red" >*</font> BLOQUE</label>
                                    <input type="text" v-model="choosePlanificacion.bloque" class="form-control"
                                           :class="{'is-invalid': formValidate.bloque}" name="po">
                                </div>
                                <div class="col-red" v-html="formValidate.bloque"></div>
                            </div>
                        </div>
                    </div> 
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group  form-float">
                                <div class="form-line focused">
                                    <label class="form-label"> <font color="red" >*</font> PRÁCTICA SOCILA DEL LENGUAJE</label>
                                    <textarea  v-model="choosePlanificacion.practicasociallenguaje" class="form-control" :class="{'is-invalid': formValidate.practicasociallenguaje}" name="message"></textarea>
                                </div>
                                <div class="col-red" v-html="formValidate.practicasociallenguaje"></div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group  form-float">
                                <div class="form-line focused">
                                    <label class="form-label"> <font color="red" >*</font> ENFOQUE</label>
                                    <textarea  v-model="choosePlanificacion.enfoque"  class="form-control" :class="{'is-invalid': formValidate.enfoque}" name="message"></textarea>
                                </div>
                                <div class="col-red" v-html="formValidate.enfoque"></div>
                            </div>
                        </div> 
                    </div> 
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group  form-float">
                                <div class="form-line focused">
                                    <label class="form-label"> <font color="red" >*</font> ÁMBITO</label>
                                    <textarea  v-model="choosePlanificacion.ambito" class="form-control" :class="{'is-invalid': formValidate.ambito}" name="message"></textarea>
                                </div>
                                <div class="col-red" v-html="formValidate.ambito"></div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group  form-float">
                                <div class="form-line focused">
                                    <label class="form-label"> <font color="red" >*</font> COMPETENCIA QUE FAVORECE</label>
                                    <textarea  v-model="choosePlanificacion.competenciafavorece"  class="form-control" :class="{'is-invalid': formValidate.competenciafavorece}" name="message"></textarea>
                                </div>
                                <div class="col-red" v-html="formValidate.competenciafavorece"></div>
                            </div>
                        </div> 
                    </div> 
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <div class="form-group">

                                <label > <font color="red" >*</font> APRENDIZAJES ESPERADOS</label>

                                <ckeditor :editor="editor" v-model="choosePlanificacion.aprendizajeesperado" :config="editorConfig"></ckeditor>
                                <div class="col-red" v-html="formValidate.aprendizajeesperado"></div>
                            </div>
                        </div> 
                    </div> 
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <div class="form-group">

                                <label > <font color="red" >*</font> PROPÓSITOS DE PROYECTO</label> 
                                <ckeditor :editor="editor" v-model="choosePlanificacion.propositodelproyecto" :config="editorConfig"></ckeditor>
                                <div class="col-red" v-html="formValidate.propositodelproyecto"></div>
                            </div>
                        </div> 
                    </div> 
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <div class="form-group">

                                <label > <font color="red" >*</font> PRODUCCIONES PARA EL DESARROLLO DEL PROYECTO</label> 
                                <ckeditor :editor="editor" v-model="choosePlanificacion.produccionesdesarrolloproyecto" :config="editorConfig"></ckeditor>
                                <div class="col-red" v-html="formValidate.produccionesdesarrolloproyecto"></div>
                            </div>
                        </div> 
                    </div> 
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <div class="form-group">

                                <label > <font color="red" >*</font> RECURSOS DIDÁCTICOS  (ESPECIFICAR ACTIVIDAD PIZARRÓN INTERACTIVO)</label> 
                                <ckeditor :editor="editor" v-model="choosePlanificacion.recursosdidacticos" :config="editorConfig"></ckeditor>
                                <div class="col-red" v-html="formValidate.recursosdidacticos"></div>
                            </div>
                        </div> 
                    </div> 
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <div class="form-group">
                                <label > <font color="red" >*</font> INDICADORES DE EVALUACIÓN</label> 
                                <ckeditor :editor="editor" v-model="choosePlanificacion.indicadoresevaluacion" :config="editorConfig"></ckeditor>
                                <div class="col-red" v-html="formValidate.indicadoresevaluacion"></div>
                            </div>
                        </div> 
                    </div> 
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <div class="form-group  form-float">
                                <div class="form-line focused">
                                    <label class="form-label"> OBSERVACIONES (DOCENTES)</label>

                                    <textarea  v-model="choosePlanificacion.observacionesdocente" class="form-control" :class="{'is-invalid': formValidate.observacionesdocente}" name="message"></textarea>
                                </div>
                                <div class="col-red" v-html="formValidate.observacionesdocente"></div>
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
                        <button class="btn btn-danger waves-effect waves-black" @click="clearAll"><i class='fa fa-ban'></i> Cancelar</button>
                        <button class="btn btn-primary waves-effect waves-black" @click="updatePlanificacion"><i class='fa fa-floppy-o'></i> Agregar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="addRegisterDetalle"  role="dialog">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #1498f4;color: #FFF;">
                <h4 class="modal-title" id="smallModalLabel">AGREGAR DETALLE DE PLANIFICACIÓN</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12 ">
                        <label class="col-red" v-html="derror"></label>
                        <label style="color:#0aca5b;" v-html="dexito"></label>
                    </div>
                </div>
                <br/>
                <div class="row">
                         <div class="col-md-8 col-sm-12 col-xs-12 ">
                        <div class="form-group form-float">
                            <div class="form-line">
                                <label class="form-label">
                                    <font color="red">*</font> SEMENA
                                </label>
                                <input type="text"  v-model="dsemana" class="form-control"
                                       :class="{'is-invalid': formValidate.dsemana}" name="po">
                            </div>
                            <div class="col-red" v-html="formValidate.dsemana"></div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12 col-xs-12 ">
                        <div class="form-group"> 
                            <input type="date" class="form-control" v-model="dfecha" style="border-bottom: solid #ccc 1px;">
                           
                        </div>
                    </div> 
               
                </div> 

                <div class="row">
                    <div class="col-md-6 col-sm-12 col-xs-12 ">
                        <div class="form-group">

                            <label > <font color="red" >*</font> OBJETIVO</label>

                            <ckeditor :editor="editor" v-model="dobjetivo" :config="editorConfig"></ckeditor>
                           
                        </div>
                    </div>  
                    <div class="col-md-6 col-sm-12 col-xs-12 ">
                        <div class="form-group">

                            <label > <font color="red" >*</font> CONTENIDO</label> 
                            <ckeditor :editor="editor" v-model="dcontenido" :config="editorConfig"></ckeditor>
                            <div class="col-red" v-html="formValidate.dcontenido"></div>
                        </div>
                    </div> 
                </div>  

            </div>
            <div class="modal-footer">
                <div class="row"> 
                    <div class="col-md-12 col-sm-12 col-xs-12 "  align="right"  >
                        <button class="btn btn-danger waves-effect waves-black" @click="cerrarVenta"><i class='fa fa-ban'></i> Cerrar</button>
                        <button class="btn btn-primary waves-effect waves-black" @click="agregarActividad"><i class='fa fa-plus'></i> Agregar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>