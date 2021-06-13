    <div class="modal fade" id="addRegister" tabindex="-1" role="dialog">
        <div class="modal-dialog  " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="smallModalLabel">AGREGAR CONCEPTO</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <div class="col-red" v-html="formValidate.msgerror"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group">
                                <select style="border-bottom: solid #ebebeb 2px;" v-model="newColegiatura.idnivel" :class="{'is-invalid': formValidate.idnivel}" class="form-control">
                                    <option value="">-- NIVEL ESCOLAR --</option>
                                    <option v-for="option in niveles" v-bind:value="option.idnivelestudio">
                                        {{ option.numeroordinaria }}
                                    </option>
                                </select>
                                <div class="col-red" v-html="formValidate.idnivel"></div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group">
                                <select style="border-bottom: solid #ebebeb 2px;" v-model="newColegiatura.idconcepto" :class="{'is-invalid': formValidate.idnivel}" class="form-control">
                                    <option value="">-- CONCEPTO --</option>
                                    <option v-for="option in conceptos" v-bind:value="option.idtipopagocol">
                                        {{ option.concepto  }}
                                    </option>
                                </select>
                                <div class="col-red" v-html="formValidate.idconcepto"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float ">
                                <div class="form-line">
                                    <label class="form-label">
                                        <font color="red">*</font> COSTO
                                    </label>
                                    <input type="text" v-model="newColegiatura.descuento" class="form-control" :class="{'is-invalid': formValidate.descuento}" name="po">
                                </div>
                                <div class="col-red" v-html="formValidate.descuento"></div>
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
                            <button class="btn btn-primary waves-effect waves-black" @click="addColegiatura"><i class='fa fa-floppy-o'></i> Agregar</button>
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
                    <h4 class="modal-title" id="smallModalLabel">EDITAR CONCEPTO</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <div class="col-red" v-html="formValidate.msgerror"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group">
                                <select style="border-bottom: solid #ebebeb 2px;" class="form-control" v-model="chooseColegiatura.idnivelestudio">
                                    <option v-for="option in niveles" :selected="option.idnivelestudio == chooseColegiatura.idperiodo ? 'selected' : ''" :value="option.idnivelestudio">
                                        {{ option.numeroordinaria }}
                                    </option>
                                </select>
                                <div class="col-red" v-html="formValidate.idnivel"></div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group">
                                <select style="border-bottom: solid #ebebeb 2px;" class="form-control" v-model="chooseColegiatura.idtipopagocol">
                                    <option v-for="option in conceptos" :selected="option.idtipopagocol == chooseColegiatura.idtipopagocol ? 'selected' : ''" :value="option.idtipopagocol">
                                        {{ option.concepto }}
                                    </option>
                                </select>
                                <div class="col-red" v-html="formValidate.idconcepto"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float">
                                <div class="form-line focused">
                                    <label class="form-label">
                                        <font color="red">*</font> COSTO
                                    </label>
                                    <input type="text" class="form-control" :class="{'is-invalid': formValidate.descuento}" name="usuario" v-model="chooseColegiatura.descuento">
                                </div>
                                <div class="col-red" v-html="formValidate.descuento"></div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group">
                                <label for="">* ESTATUS</label><br>
                                <div class="demo-radio-button">
                                    <input name="group5" type="radio" id="radio_31" class="with-gap radio-col-green" v-model="chooseColegiatura.activo" value="1" :checked="chooseColegiatura.activo==1" />
                                    <label for="radio_31">ACTIVO</label>
                                    <input name="group5" type="radio" id="radio_32" class="with-gap radio-col-red" v-model="chooseColegiatura.activo" value="0" :checked="chooseColegiatura.activo==0" />
                                    <label for="radio_32">INACTIVO</label>
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
                            <button class="btn btn-primary waves-effect waves-black" @click="updateColegiatura"><i class='fa fa-edit'></i> Modificar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>