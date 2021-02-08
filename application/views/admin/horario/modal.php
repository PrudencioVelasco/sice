<div class="modal fade" id="addRegister" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="smallModalLabel">AGREGAR HORARIO</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12 ">
                        <label class="col-red" v-html="formValidate.msgerror"></label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12 ">
                        <div class="form-group">
                            <label>
                                <font color="red">*</font> PERIODO ESCOLAR
                            </label>
                            <select style="border-bottom: solid #ebebeb 2px;" v-model="newHorario.idperiodo" :class="{'is-invalid': formValidate.idperiodo}" class="form-control">
                                <option value="">-- SELECCIONAR --</option>
                                <option v-for="option in periodos" v-bind:value="option.idperiodo">
                                    {{ option.mesinicio }} {{ option.yearinicio }} - {{option.mesfin}} {{ option.yearfin }} / {{option.descripcion}}
                                </option>
                            </select>
                            <div class="col-red" v-html="formValidate.idperiodo"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12 ">
                        <div class="form-group">
                            <label>
                                <font color="red">*</font> GRUPO
                            </label>
                            <select style="border-bottom: solid #ebebeb 2px;" v-model="newHorario.idgrupo" :class="{'is-invalid': formValidate.idgrupo}" class="form-control">
                                <option value="" selected>-- SELECCIONAR --</option>
                                <option v-for="option in grupos" v-bind:value="option.idgrupo">
                                    {{ option.nivelgrupo }} - {{ option.nombregrupo }} - {{ option.nombreturno }} - {{ option.nombreespecialidad }}
                                </option>
                            </select>
                            <div class="col-red" v-html="formValidate.idgrupo"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12 ">
                        <div class="form-group form-float">
                            <div class="form-line">
                                <label class="form-label">
                                    DESCRIPCION/CLAVE
                                </label>
                                <input type="test" v-model="newHorario.descripcion" class="form-control" :class="{'is-invalid': formValidate.descripcion}" name="po">
                            </div>
                            <div class="col-red" v-html="formValidate.descripcion"></div>
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
                        <button class="btn btn-primary waves-effect waves-black" @click="addHorario"><i class='fa fa-floppy-o'></i> Agregar</button>
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
                <h4 class="modal-title" id="smallModalLabel">EDITAR HORARIO</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12 ">
                        <label class="col-red" v-html="formValidate.msgerror"></label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12 ">
                        <div class="form-group">
                            <label>
                                <font color="red">*</font> PERIODO ESCOLAR
                            </label>
                            <select class="form-control" v-model="chooseHorario.idperiodo">
                                <option value="">-- SELECCIONAR --</option>
                                <option v-for="option in periodos" :selected="option.idperiodo == chooseHorario.idperiodo ? 'selected' : ''" :value="option.idperiodo">
                                    {{ option.mesinicio }} {{ option.yearinicio }} - {{option.mesfin}} {{ option.yearfin }} / {{option.descripcion}}
                                </option>
                            </select>
                            <div class="col-red" v-html="formValidate.idperiodo"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12 ">
                        <div class="form-group">
                            <label>
                                <font color="red">*</font> GRUPO
                            </label>
                            <select class="form-control" v-model="chooseHorario.idgrupo">
                                <option value="">-- SELECCIONAR --</option>
                                <option v-for="option in grupos" :selected="option.idgrupo == chooseHorario.idgrupo ? 'selected' : ''" :value="option.idgrupo">
                                    {{ option.nivelgrupo }} - {{ option.nombregrupo }} - {{ option.nombreturno }} - {{ option.nombreespecialidad }}
                                </option>
                            </select>
                            <div class="col-red" v-html="formValidate.idgrupo"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12 ">
                        <div class="form-group form-float">
                            <div class="form-line focused">
                                <label class="form-label">
                                    DESCRIPCIÓN/CLAVE
                                </label>
                                <input type="text" v-model="chooseHorario.descripcionhorario" class="form-control" :class="{'is-invalid': formValidate.descripcionhorario}" name="po">
                            </div>
                            <div class="col-red" v-html="formValidate.descripcionhorario"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12 ">
                        <div class="form-group">
                            <label for="">* ESTATUS</label><br>
                            <div class="demo-radio-button">
                                <input name="group5" type="radio" id="radio_31" class="with-gap radio-col-green" v-model="chooseHorario.activo" value="1" :checked="chooseHorario.activo==1" />
                                <label for="radio_31">EN PROCESO</label>
                                <input name="group5" type="radio" id="radio_32" class="with-gap radio-col-red" v-model="chooseHorario.activo" value="0" :checked="chooseHorario.activo==0" />
                                <label for="radio_32">FINALIZADO</label>
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
                        <button class="btn btn-primary waves-effect waves-black" @click="updateHorario"><i class='fa fa-edit'></i> Modificar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>