<div class="modal fade" id="addRegister" tabindex="-1" role="dialog">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="smallModalLabel">AGREGAR EXAMEN</h4>
            </div>
            <div class="modal-body">
                <div style="padding-top:13px; padding-right:15px; ">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <label class="col-red" v-html="formValidate.msgerror"></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <label class="form-label">
                                        <font color="red">*</font> NOMBRE DEL EXAMEN
                                    </label>
                                    <input type="text" v-model="newUnidad.nombreunidad" class="form-control" :class="{'is-invalid': formValidate.nombre}" name="po">
                                </div>
                                <div class="col-red" v-html="formValidate.nombreunidad"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <div class="">
                                <label>
                                    <font color="red">*</font> TIPO:
                                </label>

                                <input name="group5" type="radio" id="radio_31" class="with-gap radio-col-green" v-model="newUnidad.tipo" value="0" />
                                <label for="radio_31">Examen</label>
                                <input name="group5" type="radio" id="radio_32" class="with-gap radio-col-red" v-model="newUnidad.tipo" value="1" />
                                <label for="radio_32">Trabajo Final</label>

                                <div class="col-red" v-html="formValidate.tipo"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group">
                                <div class="">

                                    FECHA INICIO DE EVALUACIÓN

                                    <input type="date" v-model="newUnidad.fechainicio" style="border-bottom: solid #ccc 1px;" class="form-control" :class="{'is-invalid': formValidate.fechainicio}" name="po">
                                </div>
                                <div class="col-red" v-html="formValidate.fechainicio"></div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group">
                                <div class="">

                                    FECHA TERMINO DE EVALUACIÓN

                                    <input type="date" v-model="newUnidad.fechafin" style="border-bottom: solid #ccc 1px;" class="form-control" :class="{'is-invalid': formValidate.fechafin}" name="po">
                                </div>
                                <div class="col-red" v-html="formValidate.fechafin"></div>
                            </div>
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
                        <button class="btn btn-primary waves-effect waves-black" @click="addUnidad"><i class='fa fa-floppy-o'></i> Agregar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="editRegister" tabindex="-1" role="dialog">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="smallModalLabel">EDITAR EXAMEN</h4>
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
                            <div class="form-group form-float">
                                <div class="form-line focused">
                                    <label class="form-label">
                                        <font color="red">*</font> NOMBRE DEL EXAMEN
                                    </label>
                                    <input type="text" v-model="chooseUnidad.nombreunidad" class="form-control" :class="{'is-invalid': formValidate.nombreunidad}" name="po">
                                </div>
                                <div class="col-red" v-html="formValidate.nombreunidad"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <div class="">
                                <label>
                                    <font color="red">*</font> TIPO:
                                </label>

                                <input name="group5" type="radio" id="radio_31" class="with-gap radio-col-green" v-model="chooseUnidad.tipo" value="0" />
                                <label for="radio_31">Examen</label>
                                <input name="group5" type="radio" id="radio_32" class="with-gap radio-col-red" v-model="chooseUnidad.tipo" value="1" />
                                <label for="radio_32">Trabajo Final</label>

                                <div class="col-red" v-html="formValidate.tipo"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group">
                                <div>
                                    FECHA INICIO DE EVALUACIÓN
                                    <input type="date" v-model="chooseUnidad.fechainicio" class="form-control" style="border-bottom: solid #ccc 1px;" :class="{'is-invalid': formValidate.nombreunidad}" name="po">
                                </div>
                                <div class="col-red" v-html="formValidate.fechainicio"></div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group ">
                                <div>
                                    FECHA TERMINO DE EVALUACIÓN
                                    <input type="date" v-model="chooseUnidad.fechafin" class="form-control" style="border-bottom: solid #ccc 1px;" :class="{'is-invalid': formValidate.nombreunidad}" name="po">
                                </div>
                                <div class="col-red" v-html="formValidate.fechafin"></div>
                            </div>
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
                        <button class="btn btn-primary waves-effect waves-black" @click="updateUnidad"><i class='fa fa-edit'></i> Modificar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>