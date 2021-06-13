<div class="modal fade" id="addRegisterRecargo" tabindex="-1" role="dialog">
    <div class="modal-dialog  " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="smallModalLabel">AGREGAR RECARGO</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12 ">
                        <div class="col-red" v-html="formValidate.msgerror"></div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 col-sm-12 col-xs-12 ">
                        <div class="form-group form-float ">
                            <div class="form-line">
                                <label class="form-label">
                                    <font color="red">*</font> DIA CORTE
                                </label>
                                <input type="text" v-model="newConfiguracion.diaultimorecargo" class="form-control" :class="{'is-invalid': formValidate.diaultimorecargo}" name="po">
                            </div>
                            <div class="col-red" v-html="formValidate.diaultimorecargo"></div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 col-xs-12 ">
                        <div class="form-group form-float ">
                            <div class="form-line">
                                <label class="form-label">
                                    <font color="red">*</font> RECARGO
                                </label>
                                <input type="text" v-model="newConfiguracion.totalrecargo" class="form-control" :class="{'is-invalid': formValidate.totalrecargo}" name="po">
                            </div>
                            <div class="col-red" v-html="formValidate.totalrecargo"></div>
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
                        <button class="btn btn-primary waves-effect waves-black" @click="addConfiguracion"><i class='fa fa-floppy-o'></i> Agregar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editRegisterRecargo" tabindex="-1" role="dialog">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="smallModalLabel">EDITAR RECARGO</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12 ">
                        <div class="col-red" v-html="formValidate.msgerror"></div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 col-sm-12 col-xs-12 ">
                        <div class="form-group form-float">
                            <div class="form-line focused">
                                <label class="form-label">
                                    <font color="red">*</font> DIA CORTE
                                </label>
                                <input type="text" class="form-control" :class="{'is-invalid': formValidate.diaultimorecargo}" name="usuario" v-model="chooseConfiguracion.diaultimorecargo">
                            </div>
                            <div class="col-red" v-html="formValidate.diaultimorecargo"></div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 col-xs-12 ">
                        <div class="form-group form-float">
                            <div class="form-line focused">
                                <label class="form-label">
                                    <font color="red">*</font> RECARGO
                                </label>
                                <input type="text" class="form-control" :class="{'is-invalid': formValidate.totalrecargo}" name="usuario" v-model="chooseConfiguracion.totalrecargo">
                            </div>
                            <div class="col-red" v-html="formValidate.totalrecargo"></div>
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
                        <button class="btn btn-primary waves-effect waves-black" @click="updateConfiguracion"><i class='fa fa-edit'></i> Modificar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>