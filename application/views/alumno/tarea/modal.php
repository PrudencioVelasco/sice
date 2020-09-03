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
                            <ckeditor  :editor="editor" v-model="responderTarea.tarea" :config="editorConfig"></ckeditor>
                         <div class="col-red" v-html="formValidate.tarea"></div>
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <label>ARCHIVO</label>
                            <input type="file"  v-on:change="onChangeFileUploadAdd()" class="form-control" id="fileadd" ref="fileadd" name="po"> 
                            <small>Subir archivo si es necesario.</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div  class="col-md-6 col-sm-12 col-xs-12 " align="center" >
                        <div v-if="cargando">
                            <img  style="width: 50px;" src="<?php echo base_url() . '/assets/loader/pagos.gif' ?>" alt=""> <strong>Subiendo su Tarea, esto puede tardar un momento...</strong>
                        </div>
                        <div v-if="error"  align="left">
                            <label class="col-red">*Corrija los errores en el formulario.</label>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 col-xs-12 "  align="right"  >
                        <button class="btn btn-danger waves-effect waves-black" @click="clearAll"><i class='fa fa-ban'></i> Cancelar</button>
                        <button class="btn btn-primary waves-effect waves-black" @click="enviarTarea"><i class='fa fa-floppy-o'></i> Agregar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>