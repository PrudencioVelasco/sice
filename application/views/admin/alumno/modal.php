<!--AGREGAR ALUMNO-->
<div class="modal fade" id="addRegister" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">AGREGAR ALUMNO</h4>
            </div>
            <div class="modal-body">
                <div style="padding-top:13px; padding-right:15px;">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <div class="col-red" v-html="formValidate.msgerror"></div>

                        </div>
                    </div>
                    <br />
                    <div class="row clearfix">
                        <div class="col-md-4 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float ">
                                <div class="form-line">
                                    <label class="form-label">
                                        <font color="red">*</font> MATRICULA
                                    </label>
                                    <input type="text" v-model="newAlumno.matricula" class="form-control" :class="{'is-invalid': formValidate.matricula}" name="po">
                                </div>
                                <div class="col-red" v-html="formValidate.matricula"></div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <label class="form-label">
                                        <font color="red">*</font> NOMBRE
                                    </label>
                                    <input type="text" v-model="newAlumno.nombre" class="form-control" :class="{'is-invalid': formValidate.nombre}" name="po">
                                </div>
                                <div class="col-red" v-html="formValidate.nombre"></div>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <label class="form-label">
                                        <font color="red">*</font> A. PATERNO
                                    </label>
                                    <input type="text" v-model="newAlumno.apellidop" class="form-control" :class="{'is-invalid': formValidate.apellidop}" name="po">
                                </div>
                                <div class="col-red" v-html="formValidate.apellidop"></div>
                            </div>
                        </div>


                    </div>
                    <div class="row clearfix">


                        <div class="col-md-4 col-sm-12 col-xs-12 ">
                            <div class="form-group  form-float">
                                <div class="form-line">
                                    <label class="form-label">A. MATERNO</label>
                                    <input type="text" v-model="newAlumno.apellidom" class="form-control" :class="{'is-invalid': formValidate.apellidom}" name="po">
                                </div>
                                <div class="col-red" v-html="formValidate.apellidom"></div>
                            </div>
                        </div>


                        <div class="col-md-4 col-sm-12 col-xs-12 ">
                            <div class="form-group  form-float">
                                <div class="form-line">
                                    <label class="form-label">
                                        <font color="red">*</font> CURP
                                    </label>
                                    <input type="text" v-model="newAlumno.curp" class="form-control" :class="{'is-invalid': formValidate.curp}" name="po">
                                </div>
                                <div class="col-red" v-html="formValidate.curp"></div>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <label class="form-label">
                                        LUGAR DE NACIMIENTO
                                    </label>
                                    <input type="text" v-model="newAlumno.lugarnacimiento" class="form-control" :class="{'is-invalid': formValidate.lugarnacimiento}" name="po">
                                </div>
                                <div class="col-red" v-html="formValidate.lugarnacimiento"></div>
                            </div>
                        </div>

                    </div>
                    <div class="row clearfix">

                        <div class="col-md-4 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <label class="form-label">
                                        <font color="red">*</font> NACIONALIDAD
                                    </label>
                                    <input type="text" v-model="newAlumno.nacionalidad" class="form-control" :class="{'is-invalid': formValidate.nacionalidad}" name="po">
                                </div>
                                <div class="col-red" v-html="formValidate.nacionalidad"></div>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <label class="form-label">
                                        SERVICIO MEDICO
                                    </label>
                                    <input type="text" v-model="newAlumno.serviciomedico" class="form-control" :class="{'is-invalid': formValidate.serviciomedico}" name="po">
                                </div>
                                <div class="col-red" v-html="formValidate.serviciomedico"></div>
                            </div>
                        </div>


                        <div class="col-md-4 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <label class="form-label">
                                        <font color="red">*</font> TELEFONO CELULAR
                                    </label>
                                    <input type="text" v-model="newAlumno.telefono" class="form-control" :class="{'is-invalid': formValidate.telefono}" name="po">

                                </div>
                                <small>Formato: A 10 digitos</small>
                                <div class="col-red" v-html="formValidate.telefono"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">


                        <div class="col-md-4 col-sm-12 col-xs-12 ">
                            <div class="form-group  form-float">
                                <div class="form-line">
                                    <label class="form-label">
                                        <font color="red">*</font> TELEFONO DE EMERGENCIA
                                    </label>
                                    <input type="text" v-model="newAlumno.telefonoemergencia" class="form-control" :class="{'is-invalid': formValidate.telefonoemergencia}" name="po">

                                </div>
                                <small>Formato: A 10 digitos</small>
                                <div class="col-red" v-html="formValidate.telefonoemergencia"></div>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-12 col-xs-12 ">
                            <div class="form-group">

                                <select style="border-bottom: solid #ebebeb 2px;" v-model="newAlumno.idtiposanguineo" :class="{'is-invalid': formValidate.idtiposanguineo}" class="form-control show-tick">
                                    <option value="" selected>-- TIPO SANGUINEO --</option>
                                    <option v-for="option in tipossanguineos" v-bind:value="option.idtiposanguineo">
                                        {{ option.tiposanguineo  }}
                                    </option>
                                </select>
                                <div class="col-red" v-html="formValidate.idtiposanguineo"></div>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-12 col-xs-12 ">
                            <div class="form-group  form-float">
                                <div class="form-line">
                                    <label class="form-label">
                                        ALERGIA O PADECIMIENTO
                                    </label>
                                    <input type="text" v-model="newAlumno.alergiaopadecimiento" class="form-control" :class="{'is-invalid': formValidate.alergiaopadecimiento}" name="po">
                                </div>
                                <div class="col-red" v-html="formValidate.alergiaopadecimiento"></div>
                            </div>
                        </div>

                    </div>
                    <div class="row clearfix">

                        <div class="col-md-4 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <label class="form-label">
                                        PESO
                                    </label>
                                    <input type="text" v-model="newAlumno.peso" class="form-control" :class="{'is-invalid': formValidate.peso}" name="po">
                                </div>
                                <div class="col-red" v-html="formValidate.peso"></div>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-12 col-xs-12 ">
                            <div class="form-group  form-float">
                                <div class="form-line">
                                    <label class="form-label">
                                        ESTATURA
                                    </label>
                                    <input type="text" v-model="newAlumno.estatura" class="form-control" :class="{'is-invalid': formValidate.estatura}" name="po">
                                </div>
                                <div class="col-red" v-html="formValidate.estatura"></div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12 col-xs-12 ">
                            <div class="form-group ">

                                <font color="red">*</font> Sexo



                                <div class="">
                                    <input name="group5" type="radio" id="radio_31" class="with-gap radio-col-blue" v-model="newAlumno.sexo" value="1" />
                                    <label for="radio_31">HOMBRE</label>
                                    <input name="group5" type="radio" id="radio_32" class="with-gap radio-col-pink" v-model="newAlumno.sexo" value="0" />
                                    <label for="radio_32">MUJER</label>
                                </div>

                                <div class="col-red" v-html="formValidate.sexo"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">

                        <div class="col-md-4 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <label class="form-label">
                                        <font color="red">*</font> FECHA NACIMIENTO
                                    </label>
                                    <input type="text" v-model="newAlumno.fechanacimiento" id="date" class="form-control" :class="{'is-invalid': formValidate.fechanacimiento}" name="po">

                                </div>
                                <small>Formato:dd/mm/yyyy</small>
                                <div class="col-red" v-html="formValidate.fechanacimiento"></div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <label class="form-label">NÚMERO FOLIO</label>
                                    <input type="text" v-model="newAlumno.numfolio" class="form-control" :class="{'is-invalid': formValidate.numfolio}" name="po">
                                </div>
                                <div class="col-red" v-html="formValidate.numfolio"></div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <label class="form-label">NÚMERO DE ACTA</label>
                                    <input type="text" v-model="newAlumno.numacta" class="form-control" :class="{'is-invalid': formValidate.numacta}" name="po">
                                </div>
                                <div class="col-red" v-html="formValidate.numacta"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-md-3 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <label class="form-label"> NÚMERO DE LIBRO</label>
                                    <input type="text" v-model="newAlumno.numlibro" class="form-control" :class="{'is-invalid': formValidate.numlibro}" name="po">
                                </div>
                            </div>
                            <div class="col-red" v-html="formValidate.numlibro"></div>
                        </div>

                        <div class="col-md-3 col-sm-12 col-xs-12 ">
                            <div class="form-group">

                                <select style="border-bottom: solid #ebebeb 2px;" v-model="newAlumno.idespecialidad" :class="{'is-invalid': formValidate.idespecialidad}" class="form-control">
                                    <option value="" selected>-- ESPECIALIDAD --</option>
                                    <option v-for="option in especialidades" v-bind:value="option.idespecialidad">
                                        {{ option.nombreespecialidad }}
                                    </option>
                                </select>
                                <div class="col-red" v-html="formValidate.idespecialidad"></div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <label class="form-label">CORREO ELECTRONICO</label>
                                    <input type="text" v-model="newAlumno.correo" class="form-control" :class="{'is-invalid': formValidate.correo}" name="po">
                                </div>
                                <div class="col-red" v-html="formValidate.correo"></div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <label class="form-label">
                                        CONTRASEÑA
                                    </label>
                                    <input type="password" v-model="newAlumno.password" class="form-control" :class="{'is-invalid': formValidate.password}" name="po">
                                </div>
                                <div class="col-red" v-html="formValidate.password"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row clearfix">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <label class="form-label">
                                        <font color="red">*</font> DOMICILIO
                                    </label>
                                    <input type="text" v-model="newAlumno.domicilio" class="form-control" :class="{'is-invalid': formValidate.domicilio}" name="po">
                                </div>
                                <small>Formato: Calle, Num, Colonia, CP, Ciudad, Estado.</small>
                                <div class="col-red" v-html="formValidate.domicilio"></div>
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
                        <button class="btn btn-primary waves-effect waves-black" @click="addAlumno"><i class='fa fa-floppy-o'></i> Agregar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--EDITAR ALUMNO-->

<div class="modal fade" id="editRegister" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">EDITAR ALUMNO</h4>
            </div>
            <div class="modal-body">
                <div style="padding-top:13px; padding-right:15px; ">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <div class="col-red" v-html="formValidate.msgerror"></div>
                        </div>
                    </div>
                    <br />
                    <div class="row clearfix">
                        <div class="col-md-4 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float">
                                <div class="form-line focused">
                                    <label class="form-label">
                                        <font color="red">*</font> MATRICULA
                                    </label>
                                    <input type="text" v-model="chooseAlumno.matricula" class="form-control" :value="chooseAlumno.matricula" :class="{'is-invalid': formValidate.matricula}" name="po">
                                </div>
                                <div class="col-red" v-html="formValidate.matricula"></div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float">
                                <div class="form-line focused">
                                    <label class="form-label">
                                        <font color="red">*</font> NOMBRE
                                    </label>
                                    <input type="text" v-model="chooseAlumno.nombre" class="form-control" :class="{'is-invalid': formValidate.nombre}" name="po">
                                </div>
                                <div class="col-red" v-html="formValidate.nombre"></div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float">
                                <div class="form-line focused">
                                    <label class="form-label">
                                        <font color="red">*</font> A. PATERNO
                                    </label>
                                    <input type="text" v-model="chooseAlumno.apellidop" class="form-control" :class="{'is-invalid': formValidate.apellidop}" name="po">
                                </div>
                                <div class="col-red" v-html="formValidate.apellidop"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">


                        <div class="col-md-4 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float">
                                <div class="form-line focused">
                                    <label class="form-label">A. MATERNO</label>
                                    <input type="text" v-model="chooseAlumno.apellidom" class="form-control" :class="{'is-invalid': formValidate.apellidom}" name="po">
                                </div>
                                <div class="col-red" v-html="formValidate.apellidom"></div>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float">
                                <div class="form-line focused">
                                    <label class="form-label">
                                        <font color="red">*</font> CURP
                                    </label>
                                    <input type="text" v-model="chooseAlumno.curp" class="form-control" :class="{'is-invalid': formValidate.curp}" name="po">
                                </div>
                                <div class="col-red" v-html="formValidate.curp"></div>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float">
                                <div class="form-line focused">
                                    <label class="form-label">
                                        LUGAR DE NACIMIENTO
                                    </label>
                                    <input type="text" v-model="chooseAlumno.lugarnacimiento" class="form-control" :class="{'is-invalid': formValidate.lugarnacimiento}" name="po">
                                </div>
                                <div class="col-red" v-html="formValidate.lugarnacimiento"></div>
                            </div>
                        </div>

                    </div>
                    <div class="row clearfix">

                        <div class="col-md-4 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float">
                                <div class="form-line focused">
                                    <label class="form-label">
                                        <font color="red">*</font> NACIONALIDAD
                                    </label>
                                    <input type="text" v-model="chooseAlumno.nacionalidad" class="form-control" :class="{'is-invalid': formValidate.nacionalidad}" name="po">
                                </div>
                                <div class="col-red" v-html="formValidate.nacionalidad"></div>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float">
                                <div class="form-line focused">
                                    <label class="form-label">
                                        SERVICIO MEDICO
                                    </label>
                                    <input type="text" v-model="chooseAlumno.serviciomedico" class="form-control" :class="{'is-invalid': formValidate.serviciomedico}" name="po">
                                </div>
                                <div class="col-red" v-html="formValidate.serviciomedico"></div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float">
                                <div class="form-line focused">
                                    <label class="form-label">
                                        <font color="red">*</font> TELEFONO CELULAR
                                    </label>
                                    <input type="text" v-model="chooseAlumno.telefono" class="form-control" :class="{'is-invalid': formValidate.telefono}" name="po">
                                </div>
                                <small>A 10 digitos.</small>
                                <div class="col-red" v-html="formValidate.telefono"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">



                        <div class="col-md-4 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float">
                                <div class="form-line focused">
                                    <label class="form-label">
                                        <font color="red">*</font> TELEFONO DE EMERGENCIA
                                    </label>
                                    <input type="text" v-model="chooseAlumno.telefonoemergencia" class="form-control" :class="{'is-invalid': formValidate.telefonoemergencia}" name="po">
                                </div>
                                <small>A 10 digitos.</small>
                                <div class="col-red" v-html="formValidate.telefonoemergencia"></div>
                            </div>
                        </div>


                        <div class="col-md-4 col-sm-12 col-xs-12 ">
                            <div class="form-group">
                                <select style="border-bottom: solid #ebebeb 2px;" v-model="chooseAlumno.idtiposanguineo" :class="{'is-invalid': formValidate.idtiposanguineo}" class="form-control">
                                    <option value="">-- TIPO SANGUINEO --</option>
                                    <option v-for="option in tipossanguineos" selected="option.idtiposanguineo == chooseAlumno.idtiposanguineo ? 'selected' : ''" v-bind:value="option.idtiposanguineo">
                                        {{ option.tiposanguineo  }}
                                    </option>
                                </select>
                                <div class="col-red" v-html="formValidate.idtiposanguineo"></div>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float">
                                <div class="form-line focused">
                                    <label class="form-label">
                                        ALERGIA O PADECIMIENTO
                                    </label>
                                    <input type="text" v-model="chooseAlumno.alergiaopadecimiento" class="form-control" :class="{'is-invalid': formValidate.alergiaopadecimiento}" name="po">
                                </div>
                                <div class="col-red" v-html="formValidate.alergiaopadecimiento"></div>
                            </div>
                        </div>

                    </div>
                    <div class="row clearfix">

                        <div class="col-md-4 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float">
                                <div class="form-line focused">
                                    <label class="form-label">
                                        PESO
                                    </label>
                                    <input type="text" v-model="chooseAlumno.peso" class="form-control" :class="{'is-invalid': formValidate.peso}" name="po">
                                </div>
                                <div class="col-red" v-html="formValidate.peso"></div>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float">
                                <div class="form-line focused">
                                    <label class="form-label">
                                        ESTATURA
                                    </label>
                                    <input type="text" v-model="chooseAlumno.estatura" class="form-control" :class="{'is-invalid': formValidate.estatura}" name="po">
                                </div>
                                <div class="col-red" v-html="formValidate.estatura"></div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float">
                                <div class="form-line focused">
                                    <label class="form-label">NÚMERO FOLIO</label>
                                    <input type="text" v-model="chooseAlumno.numfolio" class="form-control" :class="{'is-invalid': formValidate.numfolio}" name="po">
                                </div>
                                <div class="col-red" v-html="formValidate.numfolio"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">

                        <div class="col-md-4 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float">
                                <div class="form-line focused">
                                    <label class="form-label">NÚMERO DE ACTA</label>
                                    <input type="text" v-model="chooseAlumno.numacta" class="form-control" :class="{'is-invalid': formValidate.numacta}" name="po">
                                </div>
                                <div class="col-red" v-html="formValidate.numacta"></div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float">
                                <div class="form-line focused">
                                    <label class="form-label">NÚMERO DE LIBRO</label>
                                    <input type="text" v-model="chooseAlumno.numlibro" class="form-control" :class="{'is-invalid': formValidate.numlibro}" name="po">
                                </div>
                                <div class="col-red" v-html="formValidate.numlibro"></div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12 col-xs-12 ">
                            <div class="form-group">
                                <select style="border-bottom: solid #ebebeb 2px;" v-model="chooseAlumno.idestatusalumno" :class="{'is-invalid': formValidate.idestatusalumno}" class="form-control">
                                    <option value="">-- ESTATUS ALUMNO --</option>
                                    <option v-for="option in estatusalumno" selected="option.idestatusalumno == chooseAlumno.idestatusalumno ? 'selected' : ''" v-bind:value="option.idestatusalumno">
                                        {{ option.nombreestatus  }}
                                    </option>
                                </select>
                                <div class="col-red" v-html="formValidate.idestatusalumno"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-md-4 col-sm-12 col-xs-12 ">
                            <div class="form-group">

                                <font color="red">*</font> Sexo

                                <div>
                                    <input name="group5" type="radio" id="radio_31" class="with-gap radio-col-blue" v-model="chooseAlumno.sexo" value="1" :checked="chooseAlumno.sexo==1" />
                                    <label for="radio_31">HOMBRE</label>
                                    <input name="group5" type="radio" id="radio_32" class="with-gap radio-col-pink" v-model="chooseAlumno.sexo" value="0" :checked="chooseAlumno.sexo==0" />
                                    <label for="radio_32">MUJER</label>
                                </div>
                                <div class="col-red" v-html="formValidate.sexo"></div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float">
                                <div class="form-line focused">
                                    <label class="form-label">CORREO ELECTRONICO</label>
                                    <input type="text" v-model="chooseAlumno.correo" class="form-control" :class="{'is-invalid': formValidate.correo}" name="po">
                                </div>
                                <div class="col-red" v-html="formValidate.correo"></div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float">
                                <div class="form-line focused">
                                    <label class="form-label">
                                        <font color="red">*</font> FECHA NACIMIENTO
                                    </label>
                                    <input type="text" v-model="chooseAlumno.fechanacimiento" class="form-control" :class="{'is-invalid': formValidate.fechanacimiento}" name="po">
                                </div>
                                <div class="col-red" v-html="formValidate.fechanacimiento"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">

                        <div class="col-md-3 col-sm-12 col-xs-12 ">
                            <div class="form-group">

                                <select style="border-bottom: solid #ebebeb 2px;" v-model="chooseAlumno.idespecialidad" :class="{'is-invalid': formValidate.idespecialidad}" class="form-control">
                                    <option value="">ESPECIALIDAD</option>
                                    <option v-for="option in especialidades" selected="option.idespecialidad == chooseAlumno.idespecialidad ? 'selected' : ''" v-bind:value="option.idespecialidad">
                                        {{ option.nombreespecialidad }}
                                    </option>
                                </select>
                                <div class="col-red" v-html="formValidate.idespecialidad"></div>
                            </div>
                        </div>
                        <div class="col-md-9 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float">
                                <div class="form-line focused">
                                    <label class="form-label">
                                        <font color="red">*</font> DOMICILIO
                                    </label>
                                    <input type="text" v-model="chooseAlumno.domicilio" class="form-control" :class="{'is-invalid': formValidate.domicilio}" name="po">
                                </div>
                                <small>Formato: Calle, Num, Colonia, CP, Ciudad, Estado.</small>
                                <div class="col-red" v-html="formValidate.domicilio"></div>
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
                    <div class="col-md-6 col-sm-12 col-xs-12 ">
                        <button class="btn btn-danger waves-effect waves-black" @click="clearAll"><i class='fa fa-ban'></i> Cancelar</button>
                        <button class="btn btn-primary waves-effect waves-black" @click="updateAlumno"><i class='fa fa-edit'></i> Modificar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="changePassword" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">CAMBIAR CONTRASEÑA </h4>
            </div>
            <div class="modal-body">
                <div style="">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <div class="col-red" v-html="formValidate.msgerror"></div>
                        </div>
                    </div><br>
                    <div class="row clearfix">
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float">
                                <div class="form-line  ">
                                    <label class="form-label">
                                        <font color="red">*</font> NUEVA CONTRASEÑA
                                    </label>
                                    <input type="password" v-model="chooseAlumno.password1" class="form-control" :class="{'is-invalid': formValidate.password1}" name="po">
                                </div>
                                <div class="col-red" v-html="formValidate.password1"></div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float">
                                <div class="form-line  ">
                                    <label class="form-label">
                                        <font color="red">*</font> REPITA CONTRASEÑA
                                    </label>
                                    <input type="password" v-model="chooseAlumno.password2" class="form-control" :class="{'is-invalid': formValidate.password2}" name="po">
                                </div>
                                <div class="col-red" v-html="formValidate.password2"></div>
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
                    <div class="col-md-6 col-sm-12 col-xs-12 ">
                        <button class="btn btn-danger waves-effect waves-black" @click="clearAll"><i class='fa fa-ban'></i> Cancelar</button>
                        <button class="btn btn-primary waves-effect waves-black" @click="updatePasswordAlumno"><i class='fa fa-edit'></i> Modificar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--AGREGAR ALUMNO-->
<div class="modal fade" id="situacionAlumnos" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">ESTATUS ALUMNOS</h4>
            </div>
            <div class="modal-body">
                <div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <div class="col-red" v-html="formValidate.msgerror"></div>

                        </div>
                    </div>
                    <br />
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <button type="button" @click="exportExcel()" class="btn btn-default"><i class="fa fa-file-excel-o"></i> Exportar</button>
                            <table class="table table-hover table-striped">
                                <thead class="bg-teal">
                                    <th>#</th>
                                    <th>NOMBRE</th>
                                    <th>ESTATUS</th>
                                </thead>
                                <tbody>
                                    <tr v-for="(row,index) in estatusalumnos">
                                        <td>{{index + 1}}</td>
                                        <td style="color:#000;">{{row.apellidop}} {{row.apellidom}} {{row.nombre}}</td>
                                        <td>
                                            <span v-if="row.idestatusalumno == 3" class="label label-danger">{{row.nombreestatus}}</span>
                                            <span v-if="row.idestatusalumno == 2" class="label label-warning">{{row.nombreestatus}}</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12 " align="right">
                        <button class="btn btn-danger waves-effect waves-black" @click="clearAll"><i class='fa fa-ban'></i> Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>