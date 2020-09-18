<div class="modal fade" id="addRegister" tabindex="-1" role="dialog">
    <div class="modal-dialog  modal-lg " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="smallModalLabel">AGREGAR TAREA</h4>
            </div>
            <div class="modal-body">
                <div style=" height: 200px; padding-top:13px; padding-right:15px;">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <label class="col-red" v-html="formValidate.msgerror"></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float ">
                                <div class="form-line">
                                    <label class="form-label"><font color="red">*</font> TITULO</label>
                                    <input type="text" v-model="newTarea.titulo" class="form-control"  :class="{'is-invalid': formValidate.titulo}" name="po"> 
                                </div>      
                                <div class="col-red" v-html="formValidate.titulo"></div>
                            </div>
                        </div>  
                        <div class="col-md-3 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float ">
                                <div class="form-line ">

                                    <input type="date" v-model="newTarea.fechaentrega" class="form-control"   :class="{'is-invalid': formValidate.fechaentrega}" name="po"> 

                                </div>  
                                <small>Fecha limite de entrega</small>
                                <div class="col-red" v-html="formValidate.fechaentrega"></div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float ">
                                <div class="form-line ">

                                    <input type="time" v-model="newTarea.horaentrega" class="form-control"  :class="{'is-invalid': formValidate.horaentrega}" name="po"> 

                                </div>      
                                <small>Hora limite de entrega</small>
                                <div class="col-red" v-html="formValidate.horaentrega"></div>
                            </div>
                        </div>  
                    </div> 
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <label><font color="red">*</font> REDACTAR ACTIVIDAD</label> 
                            <vue-ckeditor  v-model="newTarea.tarea"  :config="config"  />
      
                         <div class="col-red" v-html="formValidate.tarea"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <label>DOCUMENTO</label>
                            <input type="file"  v-on:change="onChangeFileUploadAdd()" class="form-control" id="fileadd" ref="fileadd" name="po"> 
                            <small>Subir documento si es necesario.</small>
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
                        <button class="btn btn-primary waves-effect waves-black" @click="addTarea"><i class='fa fa-floppy-o'></i> Agregar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="editRegister" tabindex="-1" role="dialog">
    <div class="modal-dialog  modal-lg " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="smallModalLabel">EDITAR TAREA</h4>
            </div>
            <div class="modal-body">
                <div style=" height: 200px; padding-top:13px; padding-right:15px;">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <label class="col-red" v-html="formValidate.msgerror"></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float ">
                                <div class="form-line focused">
                                    <label class="form-label"><font color="red">*</font> TITULO</label>
                                    <input type="text" v-model="chooseTarea.titulo" class="form-control"  :class="{'is-invalid': formValidate.titulo}" name="po"> 
                                </div>      
                                <div class="col-red" v-html="formValidate.titulo"></div>
                            </div>
                        </div>  
                        <div class="col-md-3 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float ">
                                <div class="form-line ">

                                    <input type="date" v-model="chooseTarea.fechaentregareal" class="form-control"   :class="{'is-invalid': formValidate.fechaentrega}" name="po"> 

                                </div>  
                                <small>Fecha limite de entrega</small>
                                <div class="col-red" v-html="formValidate.fechaentrega"></div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float ">
                                <div class="form-line ">

                                    <input type="time" v-model="chooseTarea.horaentregareal" class="form-control"  :class="{'is-invalid': formValidate.horaentrega}" name="po"> 

                                </div>      
                                <small>Hora limite de entrega</small>
                                <div class="col-red" v-html="formValidate.horaentrega"></div>
                            </div>
                        </div>  
                    </div> 
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <label><font color="red">*</font> REDACTAR ACTIVIDAD</label> 
                             <vue-ckeditor  v-model="chooseTarea.tarea"  :config="config"  />
                         <div class="col-red" v-html="formValidate.tarea"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <label>DOCUMENTO</label>
                            <input type="file"  v-on:change="onChangeFileUploadEdit()" class="form-control" id="fileedit" ref="fileedit" name="po"> 
                            <small>Subir documento si quiere cambiarlo.</small>
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
                        <button class="btn btn-primary waves-effect waves-black" @click="updateTarea"><i class='fa fa-floppy-o'></i> Agregar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
