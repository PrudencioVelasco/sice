<div class="modal fade" id="addRegister" tabindex="-1" role="dialog">
    <div class="modal-dialog  modal-lg " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="smallModalLabel">RESPONDER TAREA</h4>
            </div>
            <div class="modal-body">
                <div style="padding-top:13px; padding-right:15px;">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <label class="col-red" v-html="formValidate.msgerror"></label>
                        </div>
                    </div> 
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <label><font color="red">*</font> ESCRIBIR TAREA</label>
                            <vue-ckeditor  v-model="responderTarea.tarea"  :config="config"  />
                            
                        </div>
                        <div class="col-red" v-html="formValidate.tarea"></div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <label>DOCUMENTO</label>
                            <input type="file"  @change="onChangeFileUploadAdd" class="form-control" id="fileedit" ref="fileedit" name="po" multiple>
                            <strong v-if="filesSend.length > 0">Archivo(s) seleccionado(s):</strong>
                            <ul>
                                <li v-for="file in filesSend" :key="file.name" style="list-style-type: none;">
                                    <i class='fa fa-trash' v-on:click="removeElement(file.name)" style="color: red;"></i>
                                    {{ file.name }}
                                </li>
                            </ul>
                            <br> 
                            <small>Subir archivo si es necesario.</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div  class="col-md-6 col-sm-12 col-xs-12 " align="left" >
                        <div v-if="cargando">
                            <img  style="width: 50px;" src="<?php echo base_url() . '/assets/loader/pagos.gif' ?>" alt=""> <strong>Subiendo su Tarea, esto puede tardar un momento...</strong>
                        </div>
                        <div v-if="error"  align="left">
                            <label class="col-red" v-html="formValidate.msgerror"></label>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 col-xs-12 "  align="right"  >
                        <button class="btn btn-danger waves-effect waves-black" @click="clearAll"><i class='fa fa-ban'></i> Cancelar</button>
                        <button class="btn btn-primary waves-effect waves-black" @click="enviarTarea" id="btnenviartarea"><i class='fa fa-floppy-o'></i> Agregar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>