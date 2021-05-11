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
                                    <label class="form-label">
                                        <font color="red">*</font> TITULO
                                    </label>
                                    <input type="text" v-model="newTarea.titulo" class="form-control" :class="{'is-invalid': formValidate.titulo}" name="po">
                                </div>
                                <div class="col-red" v-html="formValidate.titulo"></div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float ">
                                <div class="form-line ">
                                    <input type="date" v-model="newTarea.fechaentrega" class="form-control" :class="{'is-invalid': formValidate.fechaentrega}" name="po">
                                </div>
                                <small>Fecha limite de entrega</small>
                                <div class="col-red" v-html="formValidate.fechaentrega"></div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float ">
                                <div class="form-line ">
                                    <input type="time" v-model="newTarea.horaentrega" class="form-control" :class="{'is-invalid': formValidate.horaentrega}" name="po">
                                </div>
                                <small>Hora limite de entrega</small>
                                <div class="col-red" v-html="formValidate.horaentrega"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <label>
                                <font color="red">*</font> REDACTAR ACTIVIDAD
                            </label>
                            <vue-ckeditor v-model="newTarea.tarea" :config="config" />
                            <div class="col-red" v-html="formValidate.tarea"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <label>DOCUMENTO</label>
                            <input type="file" @change="onChangeFileUploadAdd" class="form-control" id="fileadd" ref="fileadd" name="po" multiple>
                            <strong v-if=" filesSend.length > 0">Archivo(s) seleccionado(s):</strong>
                            <ul>
                                <li v-for="file in filesSend" :key="file.name" style="list-style-type: none;">
                                    <i class='fa fa-trash' v-on:click="removeElement(file.name)" style="color: red;"></i>
                                    {{ file.name }}
                                </li>
                            </ul>
                            <br>
                            <small>Subir documento si es necesario.</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-md-6 col-sm-12 col-xs-12 " align="center">
                        <div v-if="cargando">
                            <img style="width: 50px;" src="<?php echo base_url() . '/assets/loader/pagos.gif' ?>" alt=""> <strong>Procesando...</strong>
                        </div>
                        <div v-if="error" align="left">
                            <label class="col-red">*Corrija los errores en el formulario.</label>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 col-xs-12 " align="right">
                        <button class="btn btn-danger waves-effect waves-black" @click="clearAll"><i class='fa fa-ban'></i> Cancelar</button>

                        <button v-if="!cargando_tarea" class="btn btn-primary waves-effect waves-black" @click="addTarea">
                            <i class='fa fa-floppy-o'></i> Agregar
                        </button>

                        <button disabled class="btn btn-primary waves-effect waves-black" v-if="cargando_tarea"><i class="fa fa-spin fa-spinner"></i> Subiendo tarea...</button>
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
                                    <label class="form-label">
                                        <font color="red">*</font> TITULO
                                    </label>
                                    <input type="text" v-model="chooseTarea.titulo" class="form-control" :class="{'is-invalid': formValidate.titulo}" name="po">
                                </div>
                                <div class="col-red" v-html="formValidate.titulo"></div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float ">
                                <div class="form-line ">
                                    <input type="date" v-model="chooseTarea.fechaentregareal" class="form-control" :class="{'is-invalid': formValidate.fechaentrega}" name="po">
                                </div>
                                <small>Fecha limite de entrega</small>
                                <div class="col-red" v-html="formValidate.fechaentrega"></div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float ">
                                <div class="form-line ">
                                    <input type="time" v-model="chooseTarea.horaentregareal" class="form-control" :class="{'is-invalid': formValidate.horaentrega}" name="po">
                                </div>
                                <small>Hora limite de entrega</small>
                                <div class="col-red" v-html="formValidate.horaentrega"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <label>
                                <font color="red">*</font> REDACTAR ACTIVIDAD
                            </label>
                            <vue-ckeditor v-model="chooseTarea.tarea" :config="config" />
                            <div class="col-red" v-html="formValidate.tarea"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <label>DOCUMENTO</label>
                            <input type="file" @change="onChangeFileUploadEdit" class="form-control" id="fileedit" ref="fileedit" name="po" multiple>
                            <strong v-if="filesSend.length > 0">Archivo(s) seleccionado(s):</strong>
                            <ul>
                                <li v-for="file in filesSend" :key="file.name" style="list-style-type: none;">
                                    <i class='fa fa-trash' v-on:click="removeElement(file.name)" style="color: red;"></i>
                                    {{ file.name }}
                                </li>
                            </ul>
                            <br>
                            <small>Subir documento si quiere cambiarlo.</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-md-6 col-sm-12 col-xs-12 " align="center">
                        <div v-if="cargando">
                            <img style="width: 50px;" src="<?php echo base_url() . '/assets/loader/pagos.gif' ?>" alt=""> <strong>Procesando...</strong>
                        </div>
                        <div v-if="error" align="left">
                            <label class="col-red">*Corrija los errores en el formulario.</label>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 col-xs-12 " align="right">
                        <button class="btn btn-danger waves-effect waves-black" @click="clearAll"><i class='fa fa-ban'></i> Cancelar</button>
                        <button v-if="!cargando_tarea" class="btn btn-primary waves-effect waves-black" @click="updateTarea"><i class='fa fa-floppy-o'></i> Modificar</button>
                        <button disabled class="btn btn-primary waves-effect waves-black" v-if="cargando_tarea"><i class="fa fa-spin fa-spinner"></i> Subiendo tarea...</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="documentosTareas" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="smallModalLabel">DOCUMENTOS</h4>
            </div>
            <div class="modal-body">
                <div style="height: 300px; overflow-x: hidden; overflow-y: scroll;">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <h4 class="text-center" v-if="documentos == false">No tiene archivos asociados a la tarea seleccionada.</h4>
                            <table v-if="documentos.length > 0 " class="table table-hover table-striped">
                                <thead class="bg-teal">
                                    <th class="text-white text-center">Documento</th>
                                    <th class="text-white text-center">Opcion</th>
                                </thead>
                                <tbody class="table-light text-center">
                                    <tr v-for="file in documentos" :key="file.iddocumento" class="table-default">
                                        <td>
                                            <a v-if="file.link !=''" v-bind:href="file.link" target="_blank">
                                                <i class="fa fa-cloud-download"></i> Descargar
                                            </a>
                                            <a v-else v-bind:href="'https://drive.google.com/uc?export=download&id='+ file.iddocumento" target="_blank">
                                                <i class="fa fa-cloud-download"></i> Descargar
                                            </a>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-icons btn-danger btn-sm waves-effect waves-black" @click="deleteDocument(file.iddocumentotarea)" title="Eliminar Documento"> <i class="fa fa-trash" aria-hidden="true"></i>
                                                Eliminar
                                            </button>
                                        </td>
                                    </tr>
                                    <tr v-if="chooseTarea.iddocumento">
                                        <td>
                                            <a v-bind:href="'https://drive.google.com/uc?export=download&id='+ chooseTarea.iddocumento" target="_blank">
                                                <i class="fa fa-cloud-download"></i> Descargar
                                            </a>
                                        </td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger waves-effect waves-black" @click="clearAll"><i class='fa fa-ban'></i>Cancelar</button>
            </div>
        </div>
    </div>
</div>