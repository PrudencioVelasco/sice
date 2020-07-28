  <script src="<?php echo base_url(); ?>/assets/editor/ckeditor5-build-classic/ckeditor.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>/assets/editor/ckeditor5-vue/ckeditor.js" type="text/javascript"></script>
    
<div class="modal fade" id="addRegister" tabindex="-1" role="dialog">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
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
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
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
                        <div class="col-md-3 col-sm-12 col-xs-12 ">
                            <div class="form-group  form-float">
                                <div class="form-line">
                                    <label class="form-label"> <font color="red" >*</font> FECHA DE EJECUCIÓN</label>
                                    <input type="text" v-model="newPlanificacion.fechaejecucion" class="form-control"
                                           :class="{'is-invalid': formValidate.fechaejecucion}" name="po">
                                </div>
                                <small>Formato: dd/mm/yyyy</small>
                                <div class="col-red" v-html="formValidate.fechaejecucion"></div>

                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12 col-xs-12 ">
                            <div class="form-group  form-float">
                                <div class="form-line">
                                    <label class="form-label"> <font color="red" >*</font> BLOQUE</label>
                                    <input type="text" v-model="newPlanificacion.bloque" class="form-control"
                                           :class="{'is-invalid': formValidate.bloque}" name="po">
                                </div>
                                <div class="col-red" v-html="formValidate.bloque"></div>
                            </div>
                        </div>
                    </div> 
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group  form-float">
                                <div class="form-line">
                                    <label class="form-label"> <font color="red" >*</font> PRÁCTICA SOCILA DEL LENGUAJE</label>
                                    <textarea  v-model="newPlanificacion.practicasociallenguaje" class="form-control" :class="{'is-invalid': formValidate.practicasociallenguaje}" name="message"></textarea>
                                </div>
                                <div class="col-red" v-html="formValidate.practicasociallenguaje"></div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group  form-float">
                                <div class="form-line">
                                    <label class="form-label"> <font color="red" >*</font> ENFOQUE</label>
                                    <textarea  v-model="newPlanificacion.enfoque"  class="form-control" :class="{'is-invalid': formValidate.enfoque}" name="message"></textarea>
                                </div>
                                <div class="col-red" v-html="formValidate.enfoque"></div>
                            </div>
                        </div> 
                    </div> 
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group  form-float">
                                <div class="form-line">
                                    <label class="form-label"> <font color="red" >*</font> ÁMBITO</label>
                                    <textarea  v-model="newPlanificacion.ambito" class="form-control" :class="{'is-invalid': formValidate.ambito}" name="message"></textarea>
                                </div>
                                <div class="col-red" v-html="formValidate.ambito"></div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group  form-float">
                                <div class="form-line">
                                    <label class="form-label"> <font color="red" >*</font> COMPETENCIA QUE FAVORECE</label>
                                    <textarea  v-model="newPlanificacion.competenciafavorece"  class="form-control" :class="{'is-invalid': formValidate.competenciafavorece}" name="message"></textarea>
                                </div>
                                <div class="col-red" v-html="formValidate.competenciafavorece"></div>
                            </div>
                        </div> 
                    </div> 
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <div class="form-group">

                                <label > <font color="red" >*</font> APRENDIZAJES ESPERADOS</label>

                                <ckeditor :editor="editor" v-model="newPlanificacion.aprendizajeesperado" :config="editorConfig"></ckeditor>
                                <div class="col-red" v-html="formValidate.aprendizajeesperado"></div>
                            </div>
                        </div> 
                    </div> 
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <div class="form-group">

                                <label > <font color="red" >*</font> PROPÓSITOS DE PROYECTO</label> 
                                <ckeditor :editor="editor" v-model="newPlanificacion.propositodelproyecto" :config="editorConfig"></ckeditor>
                                <div class="col-red" v-html="formValidate.propositodelproyecto"></div>
                            </div>
                        </div> 
                    </div> 
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <div class="form-group">

                                <label > <font color="red" >*</font> PRODUCCIONES PARA EL DESARROLLO DEL PROYECTO</label> 
                                <ckeditor :editor="editor" v-model="newPlanificacion.produccionesdesarrolloproyecto" :config="editorConfig"></ckeditor>
                                <div class="col-red" v-html="formValidate.produccionesdesarrolloproyecto"></div>
                            </div>
                        </div> 
                    </div> 
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <div class="form-group">

                                <label > <font color="red" >*</font> RECURSOS DIDÁCTICOS  (ESPECIFICAR ACTIVIDAD PIZARRÓN INTERACTIVO)</label> 
                                <ckeditor :editor="editor" v-model="newPlanificacion.recursosdidacticos" :config="editorConfig"></ckeditor>
                                <div class="col-red" v-html="formValidate.recursosdidacticos"></div>
                            </div>
                        </div> 
                    </div> 
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <div class="form-group">
                                <label > <font color="red" >*</font> INDICADORES DE EVALUACIÓN</label> 
                                <ckeditor :editor="editor" v-model="newPlanificacion.indicadoresevaluacion" :config="editorConfig"></ckeditor>
                                <div class="col-red" v-html="formValidate.indicadoresevaluacion"></div>
                            </div>
                        </div> 
                    </div> 
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <div class="form-group  form-float">
                                <div class="form-line">
                                    <label class="form-label"> OBSERVACIONES (DOCENTES)</label>

                                    <textarea  v-model="newPlanificacion.observacionesdocente" class="form-control" :class="{'is-invalid': formValidate.observacionesdocente}" name="message"></textarea>
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
