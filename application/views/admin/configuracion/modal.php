<div class="modal fade" id="addRegister" tabindex="-1" role="dialog">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="smallModalLabel">AGREGAR REGISTRO</h4>
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
                                        <font color="red">*</font> NIVEL
                                    </label>
                                    <select style="border-bottom: solid #ebebeb 2px;" v-model="newRegistro.idnivel" :class="{'is-invalid': formValidate.idnivel}" class="form-control">
                                        <option value="">-- NIVEL ESCOLAR --</option>
                                        <option v-if="idniveleducativo == 3 || idniveleducativo == 5" v-for="option in niveles" v-bind:value="option.idnivelestudio">
                                            {{ option.numeroromano }}
                                        </option>
                                        <option v-if="idniveleducativo == 1 || idniveleducativo == 2 || idniveleducativo == 4" v-for="option in niveles" v-bind:value="option.idnivelestudio">
                                            {{ option.numeroordinaria }}
                                        </option>
                                    </select>
                                </div>
                                <div class="col-red" v-html="formValidate.idnivel"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float ">
                                <div class="form-line focused">
                                    <label class="form-label">
                                        <font color="red">*</font> CALIFICACION MINIMA
                                    </label>
                                    <input type="text" v-model="newRegistro.calificacion_minima" class="form-control" :class="{'is-invalid': formValidate.calificacion_minima}" name="po">
                                </div>
                                <div class="col-red" v-html="formValidate.calificacion_minima"></div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float ">
                                <div class="form-line focused">
                                    <label class="form-label">
                                        <font color="red">*</font> TOTAL CURSOS
                                    </label>
                                    <input type="text" v-model="newRegistro.reprovandas_minima" class="form-control" :class="{'is-invalid': formValidate.reprovandas_minima}" name="po">
                                </div>
                                <div class="col-red" v-html="formValidate.reprovandas_minima"></div>
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
                        <button class="btn btn-primary waves-effect waves-black" @click="agregarCalificacion"><i class='fa fa-floppy-o'></i> Agregar</button>
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
                <h4 class="modal-title" id="smallModalLabel">MODIFICAR REGISTRO</h4>
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
                                        <font color="red">*</font> NIVEL
                                    </label>
                                    <select style="border-bottom: solid #ebebeb 2px;" class="form-control" v-model="chooseCalificacion.idnivel">
                                        <option value="">-- NIVEL ESCOLAR --</option>
                                        <option v-if="idniveleducativo == 3 || idniveleducativo == 5" v-for="option in niveles" v-bind:value="option.idnivelestudio">
                                            {{ option.numeroromano }}
                                        </option>
                                        <option v-if="idniveleducativo == 1 || idniveleducativo == 2 || idniveleducativo == 4" v-for="option in niveles" v-bind:value="option.idnivelestudio">
                                            {{ option.numeroordinaria }}
                                        </option>

                                    </select>
                                </div>
                                <div class="col-red" v-html="formValidate.idnivel"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float ">
                                <div class="form-line focused">
                                    <label class="form-label">
                                        <font color="red">*</font> CALIFICACION MINIMA
                                    </label>
                                    <input type="text" v-model="chooseCalificacion.calificacion_minima" class="form-control" :class="{'is-invalid': formValidate.calificacion_minima}" name="po">
                                </div>
                                <div class="col-red" v-html="formValidate.calificacion_minima"></div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float ">
                                <div class="form-line focused">
                                    <label class="form-label">
                                        <font color="red">*</font> TOTAL CURSOS
                                    </label>
                                    <input type="text" v-model="chooseCalificacion.reprovandas_minima" class="form-control" :class="{'is-invalid': formValidate.reprovandas_minima}" name="po">
                                </div>
                                <div class="col-red" v-html="formValidate.reprovandas_minima"></div>
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
                        <button class="btn btn-primary waves-effect waves-black" @click="modificarCalificacion"><i class='fa fa-edit'></i> Modificar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="subirFotoPrincipal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">SUBIR LOGO PRINCIPAL</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12 ">
                        <div class="col-red" v-html="formValidate.msgerror"></div>
                    </div>
                </div>
                <div class="row">

                    <div class="col-md-12 col-sm-12 col-xs-12 ">
                        <div class="form-group ">

                            <label class="form-label">
                                <font color="red">*</font> SELECCIONAR
                            </label>
                            <input type="file" id="file" ref="file" v-on:change="onChangeFileUpload()" class="form-control">

                            <div class="col-red" v-html="formValidate.file"></div>
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
                    <div class="col-md-6 col-sm-12 col-xs-12 ">
                        <button class="btn btn-danger waves-effect waves-black" @click="clearAll"><i class='fa fa-ban'></i> Cancelar</button>
                        <button class="btn btn-primary waves-effect waves-black" v-on:click="subirFotoPrincipal"><i class='fa fa-upload'></i> Subir</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="subirFotoSecundario" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">SUBIR LOGO SECUNDARIO</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12 ">
                        <div class="col-red" v-html="formValidate.msgerror"></div>
                    </div>
                </div>
                <div class="row">

                    <div class="col-md-12 col-sm-12 col-xs-12 ">
                        <div class="form-group ">

                            <label class="form-label">
                                <font color="red">*</font> SELECCIONAR
                            </label>
                            <input type="file" id="filesecundario" ref="filesecundario" v-on:change="onChangeFileUploadSecundario()" class="form-control">

                            <div class="col-red" v-html="formValidate.filesecundario"></div>
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
                    <div class="col-md-6 col-sm-12 col-xs-12 ">
                        <button class="btn btn-danger waves-effect waves-black" @click="clearAll"><i class='fa fa-ban'></i> Cancelar</button>
                        <button class="btn btn-primary waves-effect waves-black" v-on:click="subirFotoSecundario"><i class='fa fa-upload'></i> Subir</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addConfiguracion" tabindex="-1" role="dialog">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="smallModalLabel">AGREGAR CONFIGURACION</h4>
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
                            <div class="form-group  ">
                                <div class="">
                                    <label>
                                        <font color="red">*</font> PLANTEL
                                    </label>
                                    <select style="border-bottom: solid #ebebeb 2px;" v-model="newConfiguracion.idplantel" :class="{'is-invalid': formValidate.idplantel}" class="form-control">
                                        <option v-for="option in planteles" v-bind:value="option.idplantel">
                                            {{ option.clave }} {{ option.nombreplantel }} - {{ option.nombreniveleducativo }}
                                        </option>
                                    </select>
                                </div>
                                <div class="col-red" v-html="formValidate.idplantel"></div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group  ">
                                <div class="">
                                    <label>
                                        <font color="red">*</font> NIVEL EDUCATIVO
                                    </label>
                                    <select style="border-bottom: solid #ebebeb 2px;" v-model="newConfiguracion.idniveleducativo" :class="{'is-invalid': formValidate.idniveleducativo}" class="form-control">
                                        <option v-for="option in niveleseducativos" v-bind:value="option.idniveleducativo">
                                            {{ option.nombreniveleducativo }}
                                        </option>
                                    </select>
                                </div>
                                <div class="col-red" v-html="formValidate.idniveleducativo"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float ">
                                <div class="form-line focused">
                                    <label class="form-label">
                                        <font color="red">*</font> RECARGO
                                    </label>
                                    <input type="text" v-model="newConfiguracion.totalrecargo" class="form-control" :class="{'is-invalid': formValidate.calificacion_minima}" name="po">
                                </div>
                                <div class="col-red" v-html="formValidate.totalrecargo"></div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float ">
                                <div class="form-line focused">
                                    <label class="form-label">
                                        <font color="red">*</font> DIA DE CORTE
                                    </label>
                                    <input type="text" v-model="newConfiguracion.diaultimorecargo" class="form-control" :class="{'is-invalid': formValidate.reprovandas_minima}" name="po">
                                </div>
                                <div class="col-red" v-html="formValidate.diaultimorecargo"></div>
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
                        <button class="btn btn-primary waves-effect waves-black" @click="agregarConfiguracion"><i class='fa fa-floppy-o'></i> Agregar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>