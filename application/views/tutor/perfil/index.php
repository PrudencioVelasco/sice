<!-- page content -->
<div class="right_col" role="main">

    <div class="">

        <div class="row">
            <div class="col-md-12">
                <div class="x_panel">
                    <div class="x_title"> 
                    </div>
                    <div class="x_content">
                        <div id="app">
                            <div class="content">
                                <div class="container-fluid">
                                    <div class="row clearfix">
                                        <div class="col-xs-12 col-sm-3">
                                            <div class="card profile-card">
                                                <div class="profile-header">&nbsp;</div>
                                                <div class="profile-body">
                                                    <div class="image-area">
                                                        <img v-if="datos_tutor.foto" style="width: 128px;"
                                                             v-bind:src="url_image+datos_tutor.foto"
                                                             alt="AdminBSB - Profile Image" />
                                                        <img v-else style="width: 128px;"
                                                             src="<?php echo base_url(); ?>/assets/images/user2.png" />
                                                    </div>
                                                    <div class="content-area">
                                                        <h3>{{datos_tutor.nombre}} {{datos_tutor.apellidop}}
                                                            {{datos_tutor.apellidom}}</h3>
                                                        <p>{{datos_tutor.escolaridad}}</p>
                                                        <p>{{datos_tutor.ocupacion}} </p>
                                                    </div>
<!--                                                    <div class="profile-footer">

                                                        <button @click="abrirSubirFotoModal()"
                                                                 class="btn btn-primary btn-lg waves-effect btn-block">SUBIR
                                                            FOTO</button>
                                                    </div>-->
                                                </div>
                                            </div>

                                            <div class="card card-about-me">
                                                <div class="header">
                                                    <h2>ACERCA DE MI</h2>
                                                </div>
                                                <div class="body">
                                                    <ul>
                                                        <li>
                                                            <div class="">
                                                                <i class="fa fa-pencil"></i> TRABAJA
                                                            </div>
                                                            <div class="content">
                                                                {{datos_tutor.dondetrabaja}}
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="">
                                                                <i class="fa fa-map-marker"></i> DIRECCIÓN
                                                            </div>
                                                            <div class="content">
                                                                {{datos_tutor.direccion}}
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="">
                                                                <i class="fa fa-calendar"></i> NACIMIENTO
                                                            </div>
                                                            <div class="content">
                                                                {{datos_tutor.fnacimiento}}
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="">
                                                                <i class="fa fa-check-circle"></i> CORREO
                                                            </div>
                                                            <div class="content">
                                                                {{datos_tutor.correo}}
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="">
                                                                <i class="fa fa-phone"></i> TELEFONO
                                                            </div>
                                                            <div class="content">
                                                                {{datos_tutor.telefono}}
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-9">
                                            <div class="card">
                                                <div class="body">
                                                    <div>
                                                        <ul class="nav nav-tabs" role="tablist">
                                                            <li role="presentation" class="active"><a href="#home"
                                                                                                      aria-controls="home" role="tab"
                                                                                                      data-toggle="tab">HIJO(A)</a></li>
                                                            <li role="presentation"><a href="#profile_settings"
                                                                                       aria-controls="settings" role="tab"
                                                                                       data-toggle="tab">MIS DATOS</a></li>
                                                            <li role="presentation"><a
                                                                    href="#change_password_settings"
                                                                    aria-controls="settings" role="tab"
                                                                    data-toggle="tab">CAMBIAR CONTRASEÑA</a></li>
                                                        </ul>

                                                        <div class="tab-content">
                                                            <div role="tabpanel" class="tab-pane fade in active"
                                                                 id="home">
                                                                <div class="row">
                                                                    <div class="col-md-6 col-sm-12 col-xs-12 ">
                                                                    </div>
                                                                    <div class="col-md-6 col-sm-12 col-xs-12 ">
                                                                        <input placeholder="Buscar"
                                                                               :autofocus="'autofocus'" type="search"
                                                                               class="form-control btn-round"
                                                                               v-model="search.text"
                                                                               @keyup="searchAlumno" name="search">
                                                                    </div>
                                                                </div>

                                                                <table class="table table-hover table-striped">
                                                                    <thead class="bg-teal">
                                                                    <th class="text-white"
                                                                        v-column-sortable:apellidop>Paterno </th>
                                                                    <th class="text-white"
                                                                        v-column-sortable:apellidom>Materno </th>
                                                                    <th class="text-white"
                                                                        v-column-sortable:nombre>Nombre </th>
                                                                    <th class="text-center ">  </th>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr v-for="alumno in alumnos">

                                                                            <td>{{alumno.apellidom}}</td>
                                                                            <td>{{alumno.apellidop}}</td>
                                                                            <td>{{alumno.nombre}}</td>
                                                                            <td align="right">

                                                                                <button
                                                                                    class="btn btn-rounded btn-primary btn-sm"
                                                                                    @click="abrirEditModal(); selectAlumno(alumno)">
                                                                                    Ver</button>
                                                                            </td>
                                                                        </tr>
                                                                        <tr v-if="emptyResult">
                                                                            <td colspan="4" class="text-center h4">No
                                                                                encontrado</td>
                                                                        </tr>
                                                                    </tbody>
                                                                    <tfoot>
                                                                        <tr>
                                                                            <td colspan="4" align="center">
                                                                    <pagination
                                                                        :current_page="currentPage"
                                                                        :row_count_page="rowCountPage"
                                                                        @page-update="pageUpdate"
                                                                        :total_users="totalAlumnos"
                                                                        :page_range="pageRange">
                                                                    </pagination>
                                                                    </td>
                                                                    </tr>
                                                                    </tfoot>
                                                                </table>


                                                            </div>
                                                            <div role="tabpanel" class="tab-pane fade in"
                                                                 id="profile_settings">

                                                                <div class="row">
                                                                    <div class="col-md-4 col-sm-12 col-xs-12 ">
                                                                        <div class="form-group">

                                                                            <label >
                                                                                <font color="red">*</font> Nombre
                                                                            </label>
                                                                             <div class="form-line">
                                                                            <input type="text"
                                                                                   v-model="datos_tutor.nombre"
                                                                                   class="form-control cajatexto"
                                                                                   :class="{'is-invalid': formValidate.nombre}"
                                                                                   name="po"></div>

                                                                            <div class="col-red"
                                                                                 v-html="formValidate.nombre"></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4 col-sm-12 col-xs-12 ">
                                                                        <div class="form-group ">

                                                                            <label  >
                                                                                <font color="red">*</font> Apellido P
                                                                            </label>
                                                                             <div class="form-line">
                                                                            <input type="text"
                                                                                   v-model="datos_tutor.apellidop"
                                                                                   class="form-control"
                                                                                   :class="{'is-invalid': formValidate.apellidop}"
                                                                                   name="po"></div>

                                                                            <div class="col-red"
                                                                                 v-html="formValidate.apellidop"></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4 col-sm-12 col-xs-12 ">
                                                                        <div class="form-group ">

                                                                            <label>Apellido
                                                                                M</label>
                                                                             <div class="form-line">
                                                                            <input type="text"
                                                                                   v-model="datos_tutor.apellidom"
                                                                                   class="form-control"
                                                                                   :class="{'is-invalid': formValidate.apellidom}"
                                                                                   name="po"></div>

                                                                            <div class="col-red"
                                                                                 v-html="formValidate.apellidom"></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-4 col-sm-12 col-xs-12 ">
                                                                        <div class="form-group"
                                                                             style="margin-top: -25px;">

                                                                            <label >
                                                                                <font color="red">*</font> Escolaridad
                                                                            </label>
                                                                             <div class="form-line">
                                                                            <input type="text"
                                                                                   v-model="datos_tutor.escolaridad"
                                                                                   class="form-control"
                                                                                   :class="{'is-invalid': formValidate.escolaridad}"
                                                                                   name="po"></div>

                                                                            <div class="col-red"
                                                                                 v-html="formValidate.escolaridad">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4 col-sm-12 col-xs-12 ">
                                                                        <div class="form-group "
                                                                             style="margin-top: -25px;">

                                                                            <label >
                                                                                <font color="red">*</font> Ocupación
                                                                            </label>
                                                                             <div class="form-line">
                                                                            <input type="text"
                                                                                   v-model="datos_tutor.ocupacion"
                                                                                   class="form-control"
                                                                                   :class="{'is-invalid': formValidate.ocupacion}"
                                                                                   name="po"></div>

                                                                            <div class="col-red"
                                                                                 v-html="formValidate.ocupacion"></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4 col-sm-12 col-xs-12 ">
                                                                        <div class="form-group "
                                                                             style="margin-top: -25px;">

                                                                            <label >
                                                                                <font color="red">*</font> Donde
                                                                                Trabaja?
                                                                            </label>
                                                                             <div class="form-line">
                                                                            <input type="text"
                                                                                   v-model="datos_tutor.dondetrabaja"
                                                                                   class="form-control"
                                                                                   :class="{'is-invalid': formValidate.dondetrabaja}"
                                                                                   name="po"></div>

                                                                            <div class="col-red"
                                                                                 v-html="formValidate.dondetrabaja">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-md-4 col-sm-12 col-xs-12 ">
                                                                        <div class="form-group"
                                                                             style="margin-top: -25px;">

                                                                            <label >
                                                                                <font color="red">*</font> F.
                                                                                Nacimiento
                                                                            </label>
                                                                             <div class="form-line">
                                                                            <input type="text"
                                                                                   v-model="datos_tutor.fnacimiento"
                                                                                   class="form-control"
                                                                                   :class="{'is-invalid': formValidate.fnacimiento}"
                                                                                   name="po"></div>

                                                                            <div class="col-red"
                                                                                 v-html="formValidate.fnacimiento">
                                                                            </div>
                                                                            <small>Formato: dd/mm/yyyy</small>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4 col-sm-12 col-xs-12 ">
                                                                        <div class="form-group "
                                                                             style="margin-top: -25px;">

                                                                            <label >
                                                                                <font color="red">*</font> Correo
                                                                            </label>
                                                                             <div class="form-line">
                                                                            <input type="text"
                                                                                   v-model="datos_tutor.correo"
                                                                                   class="form-control"
                                                                                   :class="{'is-invalid': formValidate.correo}"
                                                                                   name="po"></div>

                                                                            <div class="col-red"
                                                                                 v-html="formValidate.correo"></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4 col-sm-12 col-xs-12 ">
                                                                        <div class="form-group "
                                                                             style="margin-top: -25px;">

                                                                            <label  >
                                                                                <font color="red">*</font> Telefono
                                                                            </label>
                                                                             <div class="form-line">
                                                                            <input type="text"
                                                                                   v-model="datos_tutor.telefono"
                                                                                   class="form-control"
                                                                                   :class="{'is-invalid': formValidate.telefono}"
                                                                                   name="po"></div>

                                                                            <div class="col-red"
                                                                                 v-html="formValidate.telefono"></div>
                                                                            <small>Formato: A 10 digitos.</small>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-6 col-sm-12 col-xs-12 ">
                                                                        <div class="form-group "
                                                                             style="margin-top: -25px;">

                                                                            <label  >
                                                                                <font color="red">*</font> RFC
                                                                            </label>
                                                                             <div class="form-line">
                                                                            <input type="text"
                                                                                   v-model="datos_tutor.rfc"
                                                                                   class="form-control"
                                                                                   :class="{'is-invalid': formValidate.rfc}"
                                                                                   name="po">
                                                                             </div>
                                                                            <div class="col-red"
                                                                                 v-html="formValidate.rfc"></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6 col-sm-12 col-xs-12 ">
                                                                        <div class="form-group"
                                                                             style="margin-top: -25px;">
                                                                            <label>
                                                                                <font color="red">*</font> Factura
                                                                            </label>
                                                                            <div class="demo-radio-button">
                                                                                <input name="group5" type="radio"
                                                                                       id="radio_31"
                                                                                       class="with-gap radio-col-green"
                                                                                       v-model="datos_tutor.factura"
                                                                                       value="1" />
                                                                                <label for="radio_31">SI</label>
                                                                                <input name="group5" type="radio"
                                                                                       id="radio_32"
                                                                                       class="with-gap radio-col-red"
                                                                                       v-model="datos_tutor.factura"
                                                                                       value="0" />
                                                                                <label for="radio_32">NO</label>
                                                                            </div>
                                                                            <div class="col-red"
                                                                                 v-html="formValidate.factura"></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-12 col-sm-12 col-xs-12 ">
                                                                        <div class="form-group"
                                                                             style="margin-top: -25px;">

                                                                            <label >
                                                                                <font color="red">*</font> Dirección
                                                                            </label>
                                                                             <div class="form-line">
                                                                            <input type="text"
                                                                                   v-model="datos_tutor.direccion"
                                                                                   class="form-control"
                                                                                   :class="{'is-invalid': formValidate.direccion}"
                                                                                   name="po">
                                                                             </div>
                                                                            <div class="col-red"
                                                                                 v-html="formValidate.direccion"></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-6 col-sm-12 col-xs-12 "
                                                                         align="center">
                                                                        <div v-if="cargando">
                                                                            <img style="width: 50px;"
                                                                                 src="<?php echo base_url() . '/assets/loader/pagos.gif' ?>"
                                                                                 alt=""> <strong>Procesando...</strong>
                                                                        </div>
                                                                        <div v-if="error" align="left">
                                                                            <label class="col-red">*Corrija los
                                                                                errores en el formulario.</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6 col-sm-12 col-xs-12 "
                                                                         align="right">
                                                                        <button
                                                                            class="btn btn-primary waves-effect waves-black"
                                                                            @click="updateDatosTutor"><i
                                                                                class='fa fa-edit'></i>
                                                                            Modificar</button>
                                                                    </div>
                                                                </div>


                                                            </div>
                                                            <div role="tabpanel" class="tab-pane fade in"
                                                                 id="change_password_settings">
                                                                <div class="form-horizontal">
                                                                    <div class="row">
                                                                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                                                                            <div class="col-red"
                                                                                 v-html="formValidate.msgerror"></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="OldPassword"
                                                                               class="col-sm-3 control-label">Anterior
                                                                            Contraseña</label>
                                                                        <div class="col-sm-9">
                                                                            <div class="form-line">
                                                                                <input type="password"
                                                                                       v-model="cambiarPassword.passwordanterior"
                                                                                       class="form-control"
                                                                                       placeholder="Anterior Contraseña">

                                                                            </div>
                                                                            <div class="col-red"
                                                                                 v-html="formValidate.passwordanterior">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="NewPassword"
                                                                               class="col-sm-3 control-label">Nueva
                                                                            Contraseña</label>
                                                                        <div class="col-sm-9">
                                                                            <div class="form-line">
                                                                                <input type="password"
                                                                                       v-model="cambiarPassword.passwordnueva"
                                                                                       class="form-control"
                                                                                       placeholder="Nueva Contraseña"
                                                                                       required>

                                                                            </div>
                                                                            <div class="col-red"
                                                                                 v-html="formValidate.passwordnueva">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="NewPasswordConfirm"
                                                                               class="col-sm-3 control-label">Nueva
                                                                            Contraseña (Confirmar)</label>
                                                                        <div class="col-sm-9">
                                                                            <div class="form-line">
                                                                                <input type="password"
                                                                                       v-model="cambiarPassword.passwordrepita"
                                                                                       class="form-control"
                                                                                       placeholder="Nueva Contraseña (Confirmar)"
                                                                                       required>

                                                                            </div>
                                                                            <div class="col-red"
                                                                                 v-html="formValidate.passwordrepita">
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <div class="row">
                                                                            <div class="col-md-6 col-sm-12 col-xs-12 "
                                                                                 align="center">
                                                                                <div v-if="cargando">
                                                                                    <img style="width: 50px;"
                                                                                         src="<?php echo base_url() . '/assets/loader/pagos.gif' ?>"
                                                                                         alt="">
                                                                                    <strong>Procesando...</strong>
                                                                                </div>
                                                                                <div v-if="error" align="left">
                                                                                    <label class="col-red">*Corrija
                                                                                        los errores en el
                                                                                        formulario.</label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6 col-sm-12 col-xs-12 "
                                                                                 align="right">
                                                                                <button
                                                                                    class="btn btn-danger waves-effect waves-black"
                                                                                    @click="updatePasswordTutor"><i
                                                                                        class='fa fa-edit'></i>
                                                                                    Cambiar</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php include 'modal.php'; ?>
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
<script data-my_var_1="<?php echo base_url() ?>"
src="<?php echo base_url(); ?>/assets/vue/appvue/app_perfil_tutor.js"></script>