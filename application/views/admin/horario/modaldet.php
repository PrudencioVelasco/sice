<div class="modal fade" id="addMateria" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">AGREGAR ASIGNATURA/CURSO</h4>
            </div>
            <div class="modal-body">
                <div style="padding-top:13px; padding-right:15px;  ">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <div class="col-red" v-html="formValidate.msgerror"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <div class="form-group">
                                <label>
                                    <font color="red">*</font> ASIGNATURA/CURSO
                                </label>
                                <select style="border-bottom: solid #ebebeb 2px;" v-model="newHorario.idmateria" :class="{'is-invalid': formValidate.idmateria}" class="form-control">
                                    <option value="" selected>-- SELECCIONAR --</option>
                                    <option v-for="option in materias" v-bind:value="option.idprofesormateria">
                                        {{ option.nombreclase }} - {{option.nombre}} {{option.apellidop}} {{option.apellidom}} - {{option.nivelgrupo}}</small>
                                    </option>
                                </select>
                                <div class="col-red" v-html="formValidate.idmateria"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <div class="form-group">
                                <label>
                                    <font color="red">*</font> DIA
                                </label>
                                <select style="border-bottom: solid #ebebeb 2px;" v-model="newHorario.iddia" :class="{'is-invalid': formValidate.iddia}" class="form-control">
                                    <option value="" selected>-- SELECCIONAR --</option>
                                    <option v-for="option in dias" v-bind:value="option.iddia">
                                        {{ option.nombredia }}
                                    </option>
                                </select>
                                <div class="col-red" v-html="formValidate.iddia"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group  form-float">
                                <div class="form-line">

                                    <label>
                                        <font color="red">*</font> HORA INICIAL
                                    </label>
                                    <timepicker format="HH:mm" input-width="100%" :hour-range="[[5, 21]]" debug-mode auto-scroll placeholder="HH:mm" v-model="newHorario.horainicial">
                                    </timepicker>
                                </div>
                                <div class="col-red" v-html="formValidate.horainicial"></div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group  form-float">
                                <div class="form-line">
                                    <label>
                                        <font color="red">*</font> HORA TERMINO
                                    </label>
                                    <timepicker format="HH:mm" input-width="100%" :hour-range="[[5, 21]]" debug-mode auto-scroll placeholder="HH:mm" v-model="newHorario.horafinal">
                                    </timepicker>
                                </div>
                                <div class="col-red" v-html="formValidate.horafinal"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <label class="form-label">
                                        URL VIDEOCONFERENCIA
                                    </label>
                                    <input type="text" v-model="newHorario.urlvideoconferencia" class="form-control" :class="{'is-invalid': formValidate.urlvideoconferencia}" name="po">
                                </div>
                                <div class="col-red" v-html="formValidate.urlvideoconferencia"></div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <label class="form-label">
                                        NÚMERO ANFITRION
                                    </label>
                                    <input type="text" v-model="newHorario.numeroanfitrion" class="form-control" :class="{'is-invalid': formValidate.numeroanfitrion}" name="po">
                                </div>
                                <div class="col-red" v-html="formValidate.numeroanfitrion"></div>
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
                        <button class="btn btn-primary waves-effect waves-black" @click="addHorario"><i class='fa fa-floppy-o'></i> Agregar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addModalHoraSinClase" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">AGREGAR RECESO POR DIA</h4>
            </div>
            <div class="modal-body">
                <div style=" padding-top:13px; padding-right:15px;">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <div class="col-red" v-html="formValidate.msgerror"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <div class="form-group">
                                <label>
                                    <font color="red">*</font> DIA
                                </label>
                                <select style="border-bottom: solid #ebebeb 2px;" v-model="newHorario.iddia" :class="{'is-invalid': formValidate.iddia}" class="form-control">
                                    <option value="" selected>-- SELECCIONAR --</option>
                                    <option v-for="option in dias" v-bind:value="option.iddia">
                                        {{ option.nombredia }}
                                    </option>
                                </select>
                                <div class="col-red" v-html="formValidate.iddia"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group  form-float">
                                <div class="form-line">

                                    <label>
                                        <font color="red">*</font> HORA INICIAL
                                    </label>
                                    <timepicker format="HH:mm" input-width="100%" :hour-range="[[5, 23]]" debug-mode auto-scroll placeholder="HH:mm" v-model="newHorario.horainicial">
                                    </timepicker>
                                </div>
                                <div class="col-red" v-html="formValidate.horainicial"></div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group  form-float">
                                <div class="form-line">
                                    <label>
                                        <font color="red">*</font> HORA TERMINO
                                    </label>
                                    <timepicker format="HH:mm" input-width="100%" :hour-range="[[5, 23]]" debug-mode auto-scroll placeholder="HH:mm" v-model="newHorario.horafinal">
                                    </timepicker>
                                </div>
                                <div class="col-red" v-html="formValidate.horafinal"></div>
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
                        <button class="btn btn-primary waves-effect waves-black" @click="addHoraSinClases"><i class='fa fa-floppy-o'></i> Agregar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="addModalRecreo" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">AGREAGAR RECESO</h4>
            </div>
            <div class="modal-body">
                <div style="padding-top:13px; padding-right:15px;">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <div class="col-red" v-html="formValidate.msgerror"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <label>* Aplicara para todos los dias.</label>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float ">
                                <div class="form-line">
                                    <label class="form-label">
                                        <font color="red">*</font> TITULO
                                    </label>
                                    <input type="text" v-model="newHorario.titulo" class="form-control" :class="{'is-invalid': formValidate.titulo}" name="po">
                                </div>
                                <div class="col-red" v-html="formValidate.titulo"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12 ">

                            <div class="form-group form-float ">
                                <div class="form-line">
                                    <label>
                                        <font color="red">*</font> HORA INICIAL
                                    </label>
                                    <timepicker format="HH:mm" input-width="100%" :hour-range="[[5, 21]]" debug-mode auto-scroll placeholder="HH:mm" v-model="newHorario.horainicial">
                                    </timepicker>

                                </div>
                                <div class="col-red" v-html="formValidate.horainicial"></div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float ">
                                <div class="form-line">
                                    <label>
                                        <font color="red">*</font> HORA FINAL
                                    </label>
                                    <timepicker format="HH:mm" input-width="100%" :hour-range="[[5, 21]]" debug-mode auto-scroll placeholder="HH:mm" v-model="newHorario.horafinal">
                                    </timepicker>
                                </div>
                                <div class="col-red" v-html="formValidate.horafinal"></div>
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
                        <button class="btn btn-primary waves-effect waves-black" @click="addReceso"><i class='fa fa-floppy-o'></i> Agregar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="editMateria" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">EDITAR ASIGNATURA/CURSO</h4>
            </div>
            <div class="modal-body">
                <div style=" padding-top:13px; padding-right:15px;">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <div class="col-red" v-html="formValidate.msgerror"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <div class="form-group">
                                <label>
                                    <font color="red">*</font> ASIGNATURA/CURSO
                                </label>
                                <select style="border-bottom: solid #ebebeb 2px;" class="form-control" v-model="chooseHorario.idprofesormateria">
                                    <option value="">-- SELECCIONAR --</option>
                                    <option v-for="option in materias" :selected="option.idprofesormateria == chooseHorario.idprofesormateria ? 'selected' : ''" :value="option.idprofesormateria">
                                        {{ option.nombreclase }} - {{option.nombre}} {{option.apellidop}} {{option.apellidom}} - {{option.nivelgrupo}}</small>
                                    </option>
                                </select>



                                <div class="col-red" v-html="formValidate.idmateria"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <div class="form-group">
                                <label>
                                    <font color="red">*</font> DIA
                                </label>
                                <select style="border-bottom: solid #ebebeb 2px;" class="form-control" v-model="chooseHorario.iddia">
                                    <option value="">-- SELECCIONAR --</option>
                                    <option v-for="option in dias" :selected="option.iddia == chooseHorario.iddia ? 'selected' : ''" :value="option.iddia">
                                        {{ option.nombredia }}
                                    </option>
                                </select>
                                <div class="col-red" v-html="formValidate.iddia"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float ">
                                <div class="form-line focused">
                                    <label>
                                        <font color="red">*</font> HORA INICIAL
                                    </label>
                                    <timepicker format="HH:mm" input-width="100%" :hour-range="[[5, 23]]" debug-mode auto-scroll placeholder="HH:mm" v-model="chooseHorario.horainicial">
                                    </timepicker>
                                </div>
                                <div class="col-red" v-html="formValidate.horainicial"></div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float ">
                                <div class="form-line focused">
                                    <label>
                                        <font color="red">*</font> HORA FINAL
                                    </label>
                                    <timepicker format="HH:mm" input-width="100%" :hour-range="[[5, 23]]" debug-mode auto-scroll placeholder="HH:mm" v-model="chooseHorario.horafinal">
                                    </timepicker>
                                </div>
                                <div class="col-red" v-html="formValidate.horafinal"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float">
                                <div class="form-line focused">
                                    <label class="form-label">
                                        URL VIDEOCONFERENCIA
                                    </label>
                                    <input type="text" v-model="chooseHorario.urlvideoconferencia" class="form-control" :class="{'is-invalid': formValidate.urlvideoconferencia}" name="po">
                                </div>
                                <div class="col-red" v-html="formValidate.urlvideoconferencia"></div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float">
                                <div class="form-line focused">
                                    <label class="form-label">
                                        NÚMERO ANFITRION
                                    </label>
                                    <input type="text" v-model="chooseHorario.numeroanfitrion" class="form-control" :class="{'is-invalid': formValidate.numeroanfitrion}" name="po">
                                </div>
                                <div class="col-red" v-html="formValidate.numeroanfitrion"></div>
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


<div class="modal fade" id="editModalRecreo" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">EDITAR RECESO</h4>
            </div>
            <div class="modal-body">
                <div style=" padding-top:13px; padding-right:15px; ">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <div class="col-red" v-html="formValidate.msgerror"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <label>* Aplicara para todos los dias.</label>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float">
                                <div class="form-line focused">
                                    <label class="form-label">
                                        <font color="red">*</font> TITULO
                                    </label>

                                    <input type="text" class="form-control" :class="{'is-invalid': formValidate.nombreclase}" name="name" v-model="chooseHorario.nombreclase">
                                </div>
                                <div class="col-red" v-html="formValidate.nombreclase"> </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float">
                                <div class="form-line focused">
                                    <label>
                                        <font color="red">*</font> HORA INICIAL
                                    </label>
                                    <timepicker format="HH:mm" input-width="100%" :hour-range="[[5, 21]]" debug-mode auto-scroll placeholder="HH:mm" v-model="chooseHorario.horainicial">
                                    </timepicker>
                                </div>
                                <div class="col-red" v-html="formValidate.horainicial"></div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float">
                                <div class="form-line focused">
                                    <label>
                                        <font color="red">*</font> HORA FINAL
                                    </label>
                                    <timepicker format="HH:mm" input-width="100%" :hour-range="[[5, 21]]" debug-mode auto-scroll placeholder="HH:mm" v-model="chooseHorario.horafinal">
                                    </timepicker>
                                </div>
                                <div class="col-red" v-html="formValidate.horafinal"></div>
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
                        <button class="btn btn-primary waves-effect waves-black" @click="updateReceso"><i class='fa fa-edit'></i> Modificar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="editModalSinClases" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">EDITAR RECESO POR DIA</h4>
            </div>
            <div class="modal-body">
                <div style=" padding-top:13px; padding-right:15px; ">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <div class="col-red" v-html="formValidate.msgerror"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <div class="form-group">
                                <label>
                                    <font color="red">*</font> DIA
                                </label>
                                <select style="border-bottom: solid #ebebeb 2px;" class="form-control" v-model="chooseHorario.iddia">
                                    <option value="">-- SELECCIONAR --</option>
                                    <option v-for="option in dias" :selected="option.iddia == chooseHorario.iddia ? 'selected' : ''" :value="option.iddia">
                                        {{ option.nombredia }}
                                    </option>
                                </select>
                                <div class="col-red" v-html="formValidate.iddia"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float ">
                                <div class="form-line focused">
                                    <label>
                                        <font color="red">*</font> HORA INICIAL
                                    </label>
                                    <timepicker format="HH:mm" input-width="100%" :hour-range="[[5, 21]]" debug-mode auto-scroll placeholder="HH:mm" v-model="chooseHorario.horainicial">
                                    </timepicker>
                                </div>
                                <div class="col-red" v-html="formValidate.horainicial"></div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float ">
                                <div class="form-line focused">
                                    <label>
                                        <font color="red">*</font> HORA FINAL
                                    </label>
                                    <timepicker format="HH:mm" input-width="100%" :hour-range="[[5, 21]]" debug-mode auto-scroll placeholder="HH:mm" v-model="chooseHorario.horafinal">
                                    </timepicker>
                                </div>
                                <div class="col-red" v-html="formValidate.horafinal"></div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
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
                    <button class="btn btn-primary waves-effect waves-black" @click="updateHoraSinClases"><i class='fa fa-floppy-o'></i> Agregar</button>
                </div>
            </div>
        </div>
    </div>
</div>
</div>