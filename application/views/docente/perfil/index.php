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
                                                        <img v-if="profesor.foto" style="width: 128px; height: 128px;"
                                                             v-bind:src="url_image+profesor.foto"
                                                             alt="AdminBSB - Profile Image" />
                                                        <img v-else style="width: 128px;  height: 128px;"
                                                             src="<?php echo base_url(); ?>/assets/images/user2.png" />
                                                    </div>
                                                    <div class="content-area">
                                                        <h3>{{profesor.nombre}} {{profesor.apellidop}}
                                                            {{profesor.apellidom}}</h3>
                                                        <p>{{profesor.cedula}}</p> 
                                                    </div>
                                                    <!--                                                    <div class="profile-footer">
                                                    
                                                                                                            <button @click="abrirSubirFotoModal()"
                                                                                                                     class="btn btn-primary btn-lg waves-effect btn-block">SUBIR
                                                                                                                FOTO</button>
                                                                                                        </div>-->
                                                </div>
                                            </div>

<!--                                            <div class="card card-about-me">
                                                <div class="header">
                                                    <h2>ACERCA DE MI</h2>
                                                </div>
                                                <div class="body">
                                                    <ul> 
                                                        <li>
                                                            <div class="">
                                                                <i class="fa fa-map-marker"></i> DIRECCIÓN
                                                            </div>
                                                            <div class="content">
                                                                {{alumno.domicilio }}
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="">
                                                                <i class="fa fa-calendar"></i> NACIMIENTO
                                                            </div>
                                                            <div class="content">
                                                                {{alumno.fechanacimiento}}
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="">
                                                                <i class="fa fa-check-circle"></i> CORREO
                                                            </div>
                                                            <div class="content">
                                                                {{alumno.correo}}
                                                            </div>
                                                        </li>
                                                         <li>
                                                            <div class="">
                                                                <i class="fa fa-phone"></i> TELEFONO
                                                            </div>
                                                            <div class="content">
                                                                {{alumno.telefono}}
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="">
                                                                <i class="fa fa-phone"></i> TELEFONO EMERGENCIA
                                                            </div>
                                                            <div class="content">
                                                                {{alumno.telefonoemergencia}}
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>-->
                                        </div>
                                        <div class="col-xs-12 col-sm-9">
                                            <div class="card">
                                                <div class="body">
                                                    <div>
                                                        <ul class="nav nav-tabs" role="tablist">
                                                            <li role="presentation" class="active"><a href="#home"
                                                                                                      aria-controls="home" role="tab"
                                                                                                      data-toggle="tab">CAMBIAR CONTRASEÑA</a></li>
                                                            
                                                        </ul>

                                                        <div class="tab-content">
                                                            <div role="tabpanel" class="tab-pane fade in active"
                                                                 id="home">

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
                                                                                    @click="updatePasswordProfesor"><i
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
src="<?php echo base_url(); ?>/assets/vue/appvue/app_perfil_docente.js"></script>