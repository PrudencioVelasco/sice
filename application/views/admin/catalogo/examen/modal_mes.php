<div class="modal fade" id="addRegister" tabindex="-1" role="dialog">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="smallModalLabel">AGREGAR MES</h4>
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
                            <div class="form-group  ">
                                <div class="">
                                    <label>
                                        <font color="red">*</font> MES
                                    </label>
                                    <select style="border-bottom: solid #ebebeb 2px;" v-model="newMes.idmes" :class="{'is-invalid': formValidate.idmes}" class="form-control show-tick">
                                        <option selected>-- MES --</option>
                                        <option v-for="option in meses" v-bind:value="option.idmes">
                                            {{ option.nombremes  }}
                                        </option>
                                    </select>
                                </div>
                                <div class="col-red" v-html="formValidate.nombremes"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group  ">
                                <div class="">
                                    <label>
                                        F. INICIO EVALUACIÓN
                                    </label>
                                    <input type="date" style="border-bottom: solid #ccc 1px;" v-model="newMes.fechainicio" :class="{'is-invalid': formValidate.fechainicio}" class="form-control show-tick">
                                </div>
                                <div class="col-red" v-html="formValidate.fechainicio"></div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group  ">
                                <div class="">
                                    <label>
                                        F. TERMINO EVALUACIÓN
                                    </label>
                                    <input type="date" style="border-bottom: solid #ccc 1px;" v-model="newMes.fechafin" :class="{'is-invalid': formValidate.fechafin}" class="form-control show-tick">
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
                        <button class="btn btn-primary waves-effect waves-black" @click="addMesUnidad"><i class='fa fa-floppy-o'></i> Agregar</button>
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
                <h4 class="modal-title" id="smallModalLabel">EDITAR MES</h4>
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
                                        <font color="red">*</font> MES
                                    </label>
                                    <select style="border-bottom: solid #ebebeb 2px;" v-model="chooseMes.idmes" :class="{'is-invalid': formValidate.idmes}" class="form-control">
                                        <option v-for="option in  meses" selected="option.idmes == chooseMes.idmes ? 'selected' : ''" v-bind:value="option.idmes">
                                            {{ option.nombremes  }}
                                        </option>
                                    </select>
                                </div>
                                <div class="col-red" v-html="formValidate.idmes"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group  ">
                                <div class="">
                                    <label>
                                        F. INICIO EVALUACIÓN
                                    </label>
                                    <input type="date" style="border-bottom: solid #ccc 1px;" v-model="chooseMes.fechainicio" :class="{'is-invalid': formValidate.fechainicio}" class="form-control show-tick">
                                </div>
                                <div class="col-red" v-html="formValidate.fechainicio"></div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group  ">
                                <div class="">
                                    <label>
                                        F. TERMINO EVALUACIÓN
                                    </label>
                                    <input type="date" style="border-bottom: solid #ccc 1px;" v-model="chooseMes.fechafin" :class="{'is-invalid': formValidate.fechafin}" class="form-control show-tick">
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
                        <button class="btn btn-primary waves-effect waves-black" @click="updateMesUnidad"><i class='fa fa-edit'></i> Modificar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>