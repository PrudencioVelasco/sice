<div class="modal fade" id="addRegister" tabindex="-1" role="dialog">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="smallModalLabel">AGREGAR GRUPO</h4>
            </div>
            <div class="modal-body">
                <div style="padding-top:13px; padding-right:15px;">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <label class="col-red" v-html="formValidate.msgerror"></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group">

                                <select style="border-bottom: solid #ebebeb 2px;" v-model="newGrupo.idnivelestudio" :class="{'is-invalid': formValidate.idnivelestudio}" class="form-control">
                                    <option value="">-- NIVEL ESCOLAR --</option>
                                    <option v-if="idniveleducativo == 3 || idniveleducativo == 5" v-for="option in niveles" v-bind:value="option.idnivelestudio">
                                        {{ option.numeroromano }}
                                    </option>
                                    <option v-if="idniveleducativo == 1 || idniveleducativo == 2 || idniveleducativo == 4" v-for="option in niveles" v-bind:value="option.idnivelestudio">
                                        {{ option.numeroordinaria }}
                                    </option>
                                </select>

                                <div class="col-red" v-html="formValidate.idnivelestudio"></div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group">
                                <select style="border-bottom: solid #ebebeb 2px;" v-model="newGrupo.idespecialidad" :class="{'is-invalid': formValidate.idespecialidad}" class="form-control">
                                    <option value="">-- ESPECIALIDAD --</option>
                                    <option v-for="option in especialidades" v-bind:value="option.idespecialidad">
                                        {{ option.nombreespecialidad }}
                                    </option>
                                </select>
                                <div class="col-red" v-html="formValidate.idespecialidad"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float ">
                                <div class="form-line">
                                    <label class="form-label">
                                        <font color="red">*</font> NOMBRE DEL GRUPO
                                    </label>
                                    <input type="text" v-model="newGrupo.nombregrupo" class="form-control" :class="{'is-invalid': formValidate.nombregrupo}" name="po">
                                </div>
                                <div class="col-red" v-html="formValidate.nombregrupo"></div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group">
                                <select style="border-bottom: solid #ebebeb 2px;" v-model="newGrupo.idturno" :class="{'is-invalid': formValidate.idturno}" class="form-control">
                                    <option value="" selected>-- TURNO --</option>
                                    <option v-for="option in turnos" v-bind:value="option.idturno">
                                        {{ option.nombreturno }}
                                    </option>
                                </select>
                                <div class="col-red" v-html="formValidate.idturno"></div>
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
                        <button class="btn btn-primary waves-effect waves-black" @click="addGrupo"><i class='fa fa-floppy-o'></i> Agregar</button>
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
                <h4 class="modal-title" id="smallModalLabel">EDITAR GRUPO</h4>
            </div>
            <div class="modal-body">
                <div style="padding-top:13px; padding-right:15px;">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <label class="col-red" v-html="formValidate.msgerror"></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group">
                                <select style="border-bottom: solid #ebebeb 2px;" class="form-control" v-model="chooseGrupo.idnivelestudio">
                                    <option value="">-- NIVEL ESCOLAR --</option>
                                    <option v-if="idniveleducativo == 3 || idniveleducativo == 5" v-for="option in niveles" v-bind:value="option.idnivelestudio">
                                        {{ option.numeroromano }}
                                    </option>
                                    <option v-if="idniveleducativo == 1 || idniveleducativo == 2 || idniveleducativo == 4" v-for="option in niveles" v-bind:value="option.idnivelestudio">
                                        {{ option.numeroordinaria }}
                                    </option>

                                </select>
                                <div class="col-red" v-html="formValidate.idnivelestudio"></div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group">
                                <select style="border-bottom: solid #ebebeb 2px;" v-model="chooseGrupo.idespecialidad" :class="{'is-invalid': formValidate.idespecialidad}" class="form-control">
                                    <option value="">-- ESPECIALIDAD --</option>
                                    <option v-for="option in especialidades" selected="option.idespecialidad == chooseGrupo.idespecialidad ? 'selected' : ''" v-bind:value="option.idespecialidad">
                                        {{ option.nombreespecialidad }}
                                    </option>
                                </select>
                                <div class="col-red" v-html="formValidate.idespecialidad"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float ">
                                <div class="form-line focused">
                                    <label class="form-label">
                                        <font color="red">*</font> NOMBRE DEL GRUPO
                                    </label>
                                    <input type="text" v-model="chooseGrupo.nombregrupo" class="form-control" :class="{'is-invalid': formValidate.nombregrupo}" name="po">
                                </div>
                                <div class="col-red" v-html="formValidate.nombregrupo"></div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group">
                                <select style="border-bottom: solid #ebebeb 2px;" class="form-control" v-model="chooseGrupo.idturno">
                                    <option value="">-- TURNO --</option>
                                    <option v-for="option in turnos" :selected="option.idturno == chooseGrupo.idturno ? 'selected' : ''" :value="option.idturno">
                                        {{ option.nombreturno }}
                                    </option>
                                </select>
                                <div class="col-red" v-html="formValidate.idturno"></div>
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
                        <button class="btn btn-primary waves-effect waves-black" @click="updateGrupo"><i class='fa fa-edit'></i> Modificar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>