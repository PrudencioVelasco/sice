    <div class="modal fade" id="addRegister" tabindex="-1" role="dialog">
        <div class="modal-dialog  " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="smallModalLabel">AGREGAR PERMISO</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <label class="form-label">
                                        <font color="red">*</font> PERMISO
                                    </label>
                                    <input type="text" class="form-control" :class="{'is-invalid': formValidate.uri}" name="rol" v-model="newPermiso.uri" autcomplete="off">
                                </div>
                                <div class="col-red" v-html="formValidate.uri"> </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <label class="form-label">
                                        <font color="red">*</font> DESCRIPCIÓN
                                    </label>
                                    <textarea type="text" class="form-control  no-resize" :class="{'is-invalid': formValidate.description}" name="description" v-model="newPermiso.description">

                                 </textarea>
                                </div>
                                <div class="col-red" v-html="formValidate.description"> </div>
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
                            <button class="btn btn-primary waves-effect waves-black" @click="addPermiso"><i class='fa fa-floppy-o'></i> Agregar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="editRegister" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="smallModalLabel">EDITAR PERMISO</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group form-float">
                                <div class="form-line focused">
                                    <label class="form-label">
                                        <font color="red">*</font> PERMISO
                                    </label>
                                    <input type="text" class="form-control" :class="{'is-invalid': formValidate.uri}" name="uri" v-model="choosePermiso.uri">
                                </div>
                                <div class="col-red" v-html="formValidate.uri"> </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group form-float">
                                <div class="form-line focused">
                                    <label class="form-label">
                                        <font color="red">*</font> DESCRIPCIÓN
                                    </label>
                                    <input type="text" class="form-control" :class="{'is-invalid': formValidate.uri}" name="description" v-model="choosePermiso.description">
                                </div>
                                <div class="col-red" v-html="formValidate.description"> </div>
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
                            <button class="btn btn-primary waves-effect waves-black" @click="updatePermiso"><i class='fa fa-floppy-o'></i> Agregar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>