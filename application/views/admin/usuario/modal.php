<div class="modal fade" id="addRegister" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="smallModalLabel">AGREGAR USUARIO</h4>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-md-12">
                        <div class="col-red" v-html="formValidate.smserror"> </div>
                    </div>
                </div>
                <div class="row clearfix"> 
                    <div class="col-md-6 col-sm-12 col-xs-12 ">
                        <div class="form-group form-float">
                            <div class="form-line">
                                <label class="form-label"><font color="red">*</font> USUARIO</label>
                                <input type="text" class="form-control" :class="{'is-invalid': formValidate.usuario}" name="usuario" v-model="newUser.usuario" autcomplete="off">
                            </div>
                            <div class="col-red" v-html="formValidate.usuario"> </div>
                        </div>
                    </div> 

                    <div class="col-md-6 col-sm-12 col-xs-12 ">
                        <div class="form-group form-float">
                            <div class="form-line">
                                <label class="form-label"><font color="red">*</font> NOMBRE</label>
                                <input type="text" class="form-control" :class="{'is-invalid': formValidate.nombre}" name="nombre" v-model="newUser.nombre" autcomplete="off">
                            </div>
                            <div class="col-red" v-html="formValidate.nombre"></div>
                        </div>
                    </div> 

                </div>
                <div class="row clearfix"> 
                    <div class="col-md-6 col-sm-12 col-xs-12 ">
                        <div class="form-group form-float">
                            <div class="form-line">
                                <label class="form-label"><font color="red">*</font> APELLIDO P.</label>
                                <input type="text" class="form-control" :class="{'is-invalid': formValidate.apellidop}" name="apellidop" v-model="newUser.apellidop" autcomplete="off">
                            </div>
                            <div class="col-red" v-html="formValidate.apellidop"> </div>
                        </div>
                    </div> 

                    <div class="col-md-6 col-sm-12 col-xs-12 ">
                        <div class="form-group form-float">
                            <div class="form-line">
                                <label class="form-label"><font color="red">*</font> APELLIDO M.</label>
                                <input type="text" class="form-control" :class="{'is-invalid': formValidate.apellidom}" name="apellidom" v-model="newUser.apellidom" autcomplete="off">
                            </div>
                            <div class="col-red" v-html="formValidate.apellidom"></div>
                        </div>
                    </div> 

                </div>
                <div class="row clearfix"> 
                    <div class="col-md-6 col-sm-12 col-xs-12 ">
                        <div class="form-group form-float">
                            <div class="form-line">
                                <label class="form-label"><font color="red">*</font> CONTRASEÑA</label>
                                <input type="password" class="form-control" :class="{'is-invalid': formValidate.password2}" name="password2" v-model="newUser.password2" autcomplete="off" >
                            </div>
                            <div class="col-red" v-html="formValidate.password2"></div>
                        </div>
                    </div> 

                    <div class="col-md-6 col-sm-12 col-xs-12 ">
                        <div class="form-group form-float">
                            <div class="form-line">
                                <label class="form-label"><font color="red">*</font> REPITA CONTRASEÑA</label>
                                <input class="form-control" :class="{'is-invalid': formValidate.password1}" name="password1" v-model="newUser.password1" type="password" autcomplete="off">
                            </div>
                            <div class="col-red" v-html="formValidate.password1"></div>
                        </div>
                    </div> 

                </div>
                <div class="row"> 
                    <div class="col-md-6 col-sm-12 col-xs-12 ">
                        <div class="form-group">

                            <select style="border-bottom: solid #ebebeb 2px;" v-model="newUser.rol"  :class="{'is-invalid': formValidate.rol}"class="form-control">
                                <option value="" selected="">-- ROL --</option>
                                <option   v-for="option in roles" v-bind:value="option.id">
                                    {{ option.rol }}
                                </option>
                            </select>
                            <div class="col-red" v-html="formValidate.rol"></div>
                        </div>
                    </div> 

                    <div class="col-md-6 col-sm-12 col-xs-12 ">
                        <div class="form-group">

                            <select style="border-bottom: solid #ebebeb 2px;" v-model="newUser.idplantel"  :class="{'is-invalid': formValidate.idplantel}"class="form-control">
                                <option value="" selected="">-- PLANTEL --</option>
                                <option   v-for="option in planteles" v-bind:value="option.idplantel">
                                    {{option.nombreniveleducativo}} {{option.opcionivel}} - {{ option.nombreplantel }}
                                </option>
                            </select>
                            <div class="col-red" v-html="formValidate.idplantel"></div>
                        </div>
                    </div> 

                </div>


            </div>
            <div class="modal-footer">
                <div class="row">
                    <div  class="col-md-6 col-sm-12 col-xs-12 " align="center" >
                        <div v-if="cargando">
                            <img  style="width: 50px;" src="<?php echo base_url() . '/assets/loader/pagos.gif' ?>" alt=""> <strong>Procesando...</strong>
                        </div>
                        <div v-if="error"  align="left">
                            <label class="col-red">*Corrija los errores en el formulario.</label>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 col-xs-12 "  align="right"  >
                        <button class="btn btn-danger waves-effect waves-black" @click="clearAll"><i class='fa fa-ban'></i> Cancelar</button>
                        <button class="btn btn-primary waves-effect waves-black" @click="addUser"><i class='fa fa-floppy-o'></i> Agregar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="editRegister" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="smallModalLabel">EDITAR USUARIO</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-red" v-html="formValidate.smserror"> </div>
                    </div>
                </div>
                <div class="row clearfix"> 
                    <div class="col-md-6 col-sm-12 col-xs-12 ">
                        <div class="form-group form-float">
                            <div class="form-line focused">
                                <label class="form-label"><font color="red">*</font> USUARIO</label>
                                <input type="text" disabled class="form-control" :class="{'is-invalid': formValidate.usuario}" name="usuario" v-model="chooseUser.usuario" autcomplete="off">
                            </div>
                            <div class="col-red" v-html="formValidate.usuario"> </div>
                        </div>
                    </div> 

                    <div class="col-md-6 col-sm-12 col-xs-12 ">
                        <div class="form-group form-float">
                            <div class="form-line focused">
                                <label class="form-label"><font color="red">*</font> NOMBRE</label>
                                <input type="text" class="form-control" :class="{'is-invalid': formValidate.nombre}" name="nombre" v-model="chooseUser.nombre" autcomplete="off">
                            </div>
                            <div class="col-red" v-html="formValidate.nombre"></div>
                        </div>
                    </div> 

                </div>
                <div class="row clearfix"> 
                    <div class="col-md-6 col-sm-12 col-xs-12 ">
                        <div class="form-group form-float">
                            <div class="form-line focused">
                                <label class="form-label"><font color="red">*</font> APELLIDO P.</label>
                                <input type="text" class="form-control" :class="{'is-invalid': formValidate.apellidop}" name="apellidop" v-model="chooseUser.apellidop" autcomplete="off">
                            </div>
                            <div class="col-red" v-html="formValidate.apellidop"> </div>
                        </div>
                    </div> 

                    <div class="col-md-6 col-sm-12 col-xs-12 ">
                        <div class="form-group form-float">
                            <div class="form-line focused">
                                <label class="form-label"><font color="red">*</font> APELLIDO M.</label>
                                <input type="text" class="form-control" :class="{'is-invalid': formValidate.apellidom}" name="apellidom" v-model="chooseUser.apellidom" autcomplete="off">
                            </div>
                            <div class="col-red" v-html="formValidate.apellidom"></div>
                        </div>
                    </div> 

                </div>

                <div class="row"> 
                    <div class="col-md-6 col-sm-12 col-xs-12 ">
                        <div class="form-group">

                            <select style="border-bottom: solid #ebebeb 2px;" class="form-control" v-model="chooseUser.idrol" >
                                <option v-for="option in roles"  :selected="option.id == chooseUser.idrol ? 'selected' : ''" :value="option.id" >
                                    {{ option.rol }}
                                </option>
                            </select>
                            <div class="col-red" v-html="formValidate.rol"></div>
                        </div>
                    </div> 

                    <div class="col-md-6 col-sm-12 col-xs-12 ">
                        <div class="form-group">

                            <select style="border-bottom: solid #ebebeb 2px;" class="form-control" v-model="chooseUser.idplantel" >
                                <option v-for="option in planteles"  :selected="option.idplantel == chooseUser.idplantel ? 'selected' : ''" :value="option.idplantel" >
                                    {{option.nombreniveleducativo}} {{option.opcionivel}} - {{ option.nombreplantel }}
                                </option>
                            </select>
                            <div class="col-red" v-html="formValidate.idplantel"></div>
                        </div>
                    </div> 

                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">


                            <label for=""><font color="red">*</font> Estatus</label><br>
                            <div class="demo-radio-button">  
                                <input name="group5" type="radio" id="radio_31" class="with-gap radio-col-green" v-model="chooseUser.activo" value="1" :checked="chooseUser.activo==1" />
                                <label for="radio_31">ACTIVO</label>
                                <input name="group5" type="radio" id="radio_32" class="with-gap radio-col-red"  v-model="chooseUser.activo" value="0" :checked="chooseUser.activo==0" />
                                <label for="radio_32">INACTIVO</label>
                            </div>
                        </div> 
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <div class="row">
                    <div  class="col-md-6 col-sm-12 col-xs-12 " align="center" >
                        <div v-if="cargando">
                            <img  style="width: 50px;" src="<?php echo base_url() . '/assets/loader/pagos.gif' ?>" alt=""> <strong>Procesando...</strong>
                        </div>
                        <div v-if="error"  align="left">
                            <label class="col-red">*Corrija los errores en el formulario.</label>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 col-xs-12 "  align="right"  >
                        <button class="btn btn-danger waves-effect waves-black" @click="clearAll"><i class='fa fa-ban'></i> Cancelar</button>
                        <button class="btn btn-primary waves-effect waves-black" @click="updateUser"><i class='fa fa-edit'></i> Modificar</button>
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
                <h4 class="modal-title" id="smallModalLabel">CAMBIAR CONTRASEÑA</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group form-float">
                            <div class="form-line"  >
                                <label  class="form-label"><font color="red">*</font> CONTRASEÑA</label> 
                                <input type="password" class="form-control" :class="{'is-invalid': formValidate.password1}" name="password1" v-model="chooseUser.password1">
                            </div>
                            <div class="col-red" v-html="formValidate.password1"></div>

                        </div>

                    </div>
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group form-float">
                            <div class="form-line"  >
                                <label  class="form-label"><font color="red">*</font> REPITA CONTRASEÑA</label>
                                <input type="password" class="form-control" :class="{'is-invalid': formValidate.password2}" name="password2" v-model="chooseUser.password2">
                            </div>  
                            <div class="col-red" v-html="formValidate.password2"></div>
                        </div>


                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div  class="col-md-6 col-sm-12 col-xs-12 " align="center" >
                        <div v-if="cargando">
                            <img  style="width: 50px;" src="<?php echo base_url() . '/assets/loader/pagos.gif' ?>" alt=""> <strong>Procesando...</strong>
                        </div>
                        <div v-if="error"  align="left">
                            <label class="col-red">*Corrija los errores en el formulario.</label>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 col-xs-12 "  align="right"  >
                        <button class="btn btn-danger waves-effect waves-black" @click="clearAll"><i class='fa fa-ban'></i> Cancelar</button>
                        <button class="btn btn-primary waves-effect waves-black" @click="passwordupdateUser"><i class='fa fa-edit'></i> Modificar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
