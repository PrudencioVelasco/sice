<!-- page content -->
<div class="right_col" role="main">

    <div class="">

        <div class="row">
            <div class="col-md-12  col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><strong>CONFIGURACIONES</strong></h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                        <div id="app">
                            <div class="col-xs-3">
                                <!-- required for floating -->
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs tabs-left">
                                    <li class="active"><a href="#escuela" data-toggle="tab"><i class="fa fa-graduation-cap"></i> Escuela</a>
                                    </li>
                                    <li><a href="#messages" data-toggle="tab"><i class="fa fa-wrench"></i> Configuracion</a>
                                    </li>
                                    <li><a href="#calificacion" data-toggle="tab"><i class="fa fa-list"></i> D. Configuracion</a>
                                    </li>

                                    <li><a href="#settings" data-toggle="tab">Settings</a>
                                    </li>
                                </ul>
                            </div>

                            <div class="col-xs-9">
                                <!-- Tab panes -->
                                <div id="appplantel">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="escuela">

                                            <p class="lead">ESCUELA</p>
                                            <div class="row">
                                                <div class="col-md-12 col-sm-12 col-xs-12 ">
                                                    <div v-if="!plantel">
                                                        <button class="btn btn-default"><i class="fa fa-plus"></i> Agregar</button>
                                                    </div>

                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row">
                                                <div class="col-md-6 col-sm-12 col-xs-12 ">
                                                    <div class="form-group">
                                                        <div class="form-line ">
                                                            <label>
                                                                <font color="red">*</font> Clave
                                                            </label>
                                                            <input type="text" v-model="plantel.clave" class="form-control" :class="{'is-invalid': formValidate.clave}" name="po">
                                                        </div>
                                                        <div class="text-danger" v-html="formValidate.clave"></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-12 col-xs-12 ">
                                                    <div class="form-group">
                                                        <div class="form-line ">
                                                            <label>
                                                                <font color="red">*</font> Nombre de la Escuela
                                                            </label>
                                                            <input type="text" v-model="plantel.nombreplantel" class="form-control" :class="{'is-invalid': formValidate.nombreplantel}" name="po">
                                                        </div>
                                                        <div class="text-danger" v-html="formValidate.nombreplantel"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">

                                                <div class="col-md-12 col-sm-12 col-xs-12 ">
                                                    <div class="form-group">
                                                        <div class="form-line">
                                                            <label>
                                                                <font color="red">*</font> Dirección
                                                            </label>
                                                            <input type="text" v-model="plantel.direccion" class="form-control" :class="{'is-invalid': formValidate.direccion}" name="po">
                                                        </div>
                                                        <div class="text-danger" v-html="formValidate.direccion"></div>
                                                        <small>Formato: Calle, Num, Colonia, CP, Ciudad, Estado.</small>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="row">
                                                <div class="col-md-6 col-sm-12 col-xs-12 ">
                                                    <div class="form-group">
                                                        <div class="form-line">
                                                            <label>
                                                                <font color="red">*</font> Director
                                                            </label>
                                                            <input type="text" v-model="plantel.director" class="form-control" :class="{'is-invalid': formValidate.director}" name="po">
                                                        </div>
                                                        <div class="text-danger" v-html="formValidate.director"></div>

                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-12 col-xs-12 ">
                                                    <div class="form-group">
                                                        <div class="form-line ">
                                                            <label>
                                                                <font color="red">*</font> Telefono
                                                            </label>
                                                            <input type="text" v-model="plantel.telefono" class="form-control" :class="{'is-invalid': formValidate.telefono}" name="po">
                                                        </div>
                                                        <div class="text-danger" v-html="formValidate.telefono"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6 col-sm-12 col-xs-12 ">
                                                    <div class="form-group">
                                                        <div class="form-line ">
                                                            <label>
                                                                <font color="red">*</font> Mision
                                                            </label>
                                                            <textarea v-model="plantel.mision" class="form-control" name="message"></textarea>
                                                        </div>
                                                        <div class="text-danger" v-html="formValidate.mision"></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-12 col-xs-12 ">
                                                    <div class="form-group">
                                                        <div class="form-line ">
                                                            <label>
                                                                <font color="red">*</font> Vision
                                                            </label>
                                                            <textarea v-model="plantel.vision" class="form-control" name="message"></textarea>
                                                        </div>
                                                        <div class="text-danger" v-html="formValidate.vision"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12 col-sm-12 col-xs-12 ">
                                                    <div class="form-group">
                                                        <div class="form-line ">
                                                            <label>
                                                                <font color="red">*</font> Objetivos
                                                            </label>
                                                            <textarea v-model="plantel.objetivos" class="form-control" name="message"></textarea>
                                                        </div>
                                                        <div class="text-danger" v-html="formValidate.objetivos"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="row">
                                                    <div class="col-md-12 col-sm-12 col-xs-12 ">
                                                        <button type="button" @click="modificarPlantel()" class="btn btn-primary waves-effect waves-black"><i class="fa fa-pencil-square-o"></i> MODIFICAR</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row">
                                                <div class="col-md-12 col-sm-12 col-xs-12 " align="center">
                                                    <div v-if="cargando">
                                                        <img style="width: 50px;" src="<?php echo base_url() . '/assets/loader/pagos.gif' ?>" alt=""> <strong>Procesando...</strong>
                                                    </div>
                                                    <div v-if="error" align="left">
                                                        <label class="col-red">*Corrija los errores en el formulario.</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 col-sm-12 col-xs-12 ">
                                                    <p>LOGO PRINCIPAL</p>
                                                    <img v-if="plantel.logoplantel" style="width: 200; height:180px; display: block;" v-bind:src="url_image+plantel.logoplantel" alt="Imagen del Tutor" />
                                                    <img v-else style="width: 200; height:180px; display: block;" src="<?php echo base_url(); ?>/assets/images/user2.png" />
                                                    <br />
                                                    <button class="btn btn-info waves-effect waves-black" @click="abrirSubirFotoPrincipal()"><i class="fa fa-upload"></i> Subir</button>
                                                    <button class="btn btn-danger waves-effect waves-black" @click="eliminarLogoPrincipal()"><i class="fa fa-trash"></i> Eliminar</button>
                                                </div>
                                                <div class="col-md-6 col-sm-12 col-xs-12 ">
                                                    <p>LOGO SECUNDARIO</p>
                                                    <img v-if="plantel.logosegundo" class="image" style="width: 200; height:180px; display: block;" v-bind:src="url_image+plantel.logosegundo" alt="Imagen del Tutor" />
                                                    <img v-else style="width: 200; height:180px; display: block;" src="<?php echo base_url(); ?>/assets/images/user2.png" />
                                                    <br />
                                                    <button class="btn btn-info waves-effect waves-black" @click="abrirSubirFotoSecundario()"><i class="fa fa-upload"></i> Subir</button>
                                                    <button class="btn btn-danger waves-effect waves-black" @click="eliminarLogoSecundario()"><i class="fa fa-trash"></i> Eliminar</button>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="tab-pane" id="calificacion">
                                            <p class="lead">DETALLE CONFIGURACION</p>
                                            <button class="btn btn-primary waves-effect waves-black" @click="abrirAddModal()"><i class="fa fa-plus"></i> Agregar</button>
                                            <table class="table table-hover table-striped">
                                                <thead class="bg-teal">
                                                    <th class="text-white">NIVEL </th>
                                                    <th class="text-white">CALIFICACION MINIMA </th>
                                                    <th class="text-white">REPROBADAS PERMITIDAS </th>
                                                    <th class="text-center text-white"> </th>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="row in calificaciones">
                                                        <td>{{row.nivelgrupo}}</td>
                                                        <td>{{row.calificacion_minima}}</td>
                                                        <td>{{row.reprovandas_minima}}</td>
                                                        <td align="right">
                                                            <button class="btn btn-info waves-effect waves-black" @click="abrirEditModal();selectCalificacion(row);"><i class="fa fa-pencil-square-o"></i> Modificar</button>
                                                            <button class="btn btn-danger waves-effect waves-black" @click="eliminarCalificacion(row.iddetalle)"><i class="fa fa-trash"></i> Eliminar</button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="tab-pane" id="messages">
                                            <p class="lead"> CONFIGURACION</p>
                                            <div class="row">
                                                <div v-if="!configuracion ">
                                                    <div class="col-md-12 col-sm-12 col-xs-12 ">
                                                        <button class="btn btn-default waves-effect waves-black" @click="abrirConfiguracion()"><i class="fa fa-plus"></i> Agregar</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr />
                                            <div v-if="configuracion && configuracion.idconfiguracion !=''">
                                                <div class="row">
                                                    <div class="col-md-8 col-sm-12 col-xs-12 ">
                                                        <div class="form-group">
                                                            <div class="form-line">
                                                                <label>
                                                                    <font color="red">*</font> PLANTEL
                                                                </label>
                                                                <select style="border-bottom: solid #ebebeb 2px;" v-model="configuracion.idplantel" :class="{'is-invalid': formValidate.idplantel}" class="form-control">
                                                                    <option v-for="option in planteles" selected="option.idplantel == configuracion.idplantel ? 'selected' : ''" v-bind:value="option.idplantel">
                                                                        {{ option.clave }} {{ option.nombreplantel }} - {{ option.nombreniveleducativo }}
                                                                    </option>
                                                                </select>

                                                            </div>
                                                            <div class="text-danger" v-html="formValidate.idplantel"></div>

                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-sm-12 col-xs-12 ">
                                                        <div class="form-group">
                                                            <div class="form-line">
                                                                <label>
                                                                    <font color="red">*</font> NIVEL EDUCATIVO
                                                                </label>
                                                                <select style="border-bottom: solid #ebebeb 2px;" v-model="configuracion.idniveleducativo" :class="{'is-invalid': formValidate.idniveleducativo}" class="form-control">
                                                                    <option v-for="option in niveleseducativos" selected="option.idniveleducativo == configuracion.idniveleducativo ? 'selected' : ''" v-bind:value="option.idniveleducativo">
                                                                        {{ option.nombreniveleducativo }}
                                                                    </option>
                                                                </select>

                                                            </div>
                                                            <div class="text-danger" v-html="formValidate.idniveleducativo"></div>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 col-sm-12 col-xs-12 ">
                                                        <div class="form-group">
                                                            <div class="form-line">
                                                                <label>
                                                                    <font color="red">*</font> RECARGO
                                                                </label>
                                                                <input type="text" v-model="configuracion.totalrecargo" class="form-control" :class="{'is-invalid': formValidate.totalrecargo}" name="po">
                                                            </div>
                                                            <div class="text-danger" v-html="formValidate.totalrecargo"></div>

                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-sm-12 col-xs-12 ">
                                                        <div class="form-group">
                                                            <div class="form-line ">
                                                                <label>
                                                                    <font color="red">*</font> DIA DE CORTE
                                                                </label>
                                                                <input type="text" v-model="configuracion.diaultimorecargo" class="form-control" :class="{'is-invalid': formValidate.diaultimorecargo}" name="po">
                                                            </div>
                                                            <div class="text-danger" v-html="formValidate.diaultimorecargo"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12 col-sm-12 col-xs-12 " align="left">
                                                        <div v-if="cargando">
                                                            <img style="width: 50px;" src="<?php echo base_url() . '/assets/loader/pagos.gif' ?>" alt=""> <strong>Procesando...</strong>
                                                        </div>
                                                        <div v-if="error" align="left">
                                                            <label class="col-red">*Corrija los errores en el formulario.</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button class="btn btn-info waves-effect waves-black" @click="modificarConfiguracion()"><i class="fa fa-pencil-square-o"></i> MODIFICAR</button>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="settings">Settings Tab.</div>
                                    </div>
                                    <?php include 'modal.php'; ?>
                                </div>
                            </div>

                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- footer content -->
    <footer>
        <div class="copyright-info">
            <p class="pull-right">SICE - Sistema Integral para el Control Escolar</a>
            </p>
        </div>
        <div class="clearfix"></div>
    </footer>
    <!-- /footer content -->

</div>
<!-- /page content -->
</div>

</div>

<div id="custom_notifications" class="custom-notifications dsp_none">
    <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
    </ul>
    <div class="clearfix"></div>
    <div id="notif-group" class="tabbed_notifications"></div>
</div>
<script data-my_var_1="<?php echo base_url() ?>" data-my_var_2="<?php echo $this->session->idniveleducativo; ?>" src="<?php echo base_url(); ?>/assets/vue/appvue/administrador/configuracion/appplantel.js?1.0"></script>