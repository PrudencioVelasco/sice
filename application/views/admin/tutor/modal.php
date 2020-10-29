<div class="modal fade" id="addRegister" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="smallModalLabel">AGREGAR TUTOR</h4>
            </div>
            <div class="modal-body">
                <div style=" height: 200px; padding-right:15px; overflow-x: hidden; overflow-y: scroll;">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <label style="color: red" v-html="formValidate.msgerror"></label>
                        </div>
                    </div>
                    <br/>
                    <div class="row clearfix">
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float">
                                <div class="form-line"  >
                                    <label  class="form-label"><font color="red">*</font> NOMBRE</label>
                                    <input type="text" v-model="newTutor.nombre" class="form-control"  :class="{'is-invalid': formValidate.nombre}" name="po"> 
                                </div>      
                                <div class="col-red" v-html="formValidate.nombre"></div>
                            </div>
                        </div> 
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float">
                                <div class="form-line"  >
                                    <label  class="form-label"><font color="red">*</font> A. PATERNO</label>
                                    <input type="text" v-model="newTutor.apellidop" class="form-control"  :class="{'is-invalid': formValidate.apellidop}" name="po"> 
                                </div>      
                                <div class="col-red" v-html="formValidate.apellidop"></div>
                            </div>
                        </div> 
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float">
                                <div class="form-line"  >
                                    <label  class="form-label">A. MATERNO</label>
                                    <input type="text" v-model="newTutor.apellidom" class="form-control"  :class="{'is-invalid': formValidate.apellidom}" name="po"> 
                                </div>     
                                <div class="col-red" v-html="formValidate.apellidom"></div>
                            </div>
                        </div> 
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float">
                                <div class="form-line"  >
                                    <label  class="form-label">ESCOLARIDAD</label>
                                    <input type="text" v-model="newTutor.escolaridad" class="form-control"  :class="{'is-invalid': formValidate.escolaridad}" name="po"> 
                                </div>      
                                <div class="col-red" v-html="formValidate.escolaridad"></div>
                            </div>
                        </div> 
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float">
                                <div class="form-line"  >
                                    <label  class="form-label">OCUPACIÓN</label>
                                    <input type="text" v-model="newTutor.ocupacion" class="form-control"  :class="{'is-invalid': formValidate.ocupacion}" name="po"> 
                                </div>      
                                <div class="col-red" v-html="formValidate.ocupacion"></div>
                            </div>
                        </div> 
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float">
                                <div class="form-line"  >
                                    <label  class="form-label">DONDE TRABAJA</label>
                                    <input type="text" v-model="newTutor.dondetrabaja" class="form-control"  :class="{'is-invalid': formValidate.dondetrabaja}" name="po"> 
                                </div>      
                                <div class="col-red" v-html="formValidate.dondetrabaja"></div>
                            </div>
                        </div> 
                    </div>

                    <div class="row"> 
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float">
                                <div class="form-line"  >
                                    <label  class="form-label"><font color="red">*</font>DIRECCIÓN</label>
                                    <input type="text" v-model="newTutor.direccion" class="form-control"  :class="{'is-invalid': formValidate.direccioni}" name="po"> 
                                </div>     
                                <div class="col-red" v-html="formValidate.direccion"></div>
                                <small>Formato: Calle, Num, Colonia, CP, Ciudad, Estado.</small>
                            </div>


                        </div> 
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float">
                                <div class="form-line"  >
                                    <label  class="form-label"><font color="red">*</font> F. NACIMIENTO</label>
                                    <input type="text" v-model="newTutor.fnacimiento" class="form-control"  :class="{'is-invalid': formValidate.fnacimiento}" name="po"> 
                                </div>    
                                <small>Formato: dd/mm/yyyy</small> 
                                <div class="col-red" v-html="formValidate.fnacimiento"></div>
                            </div>
                        </div> 
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float">
                                <div class="form-line"  >
                                    <label  class="form-label"><font color="red">*</font> TELEFONO</label>
                                    <input type="text" v-model="newTutor.telefono" class="form-control"  :class="{'is-invalid': formValidate.telefono}" name="po"> 
                                </div>     
                                <small>Formato: A 10 digitos</small>  
                                <div class="col-red" v-html="formValidate.telefono"></div>
                            </div>
                        </div> 
                    </div>


                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float">
                                <div class="form-line"  >
                                    <label  class="form-label"><font color="red">*</font> CORREO ELECTRONICO</label>
                                    <input type="text" v-model="newTutor.correo" class="form-control"  :class="{'is-invalid': formValidate.correo}" name="po"> 
                                </div>     
                                <div class="col-red" v-html="formValidate.correo"></div>
                            </div>
                        </div> 
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float">
                                <div class="form-line"  >
                                    <label  class="form-label"><font color="red">*</font> CONTRASEÑA</label>
                                    <input type="password" v-model="newTutor.password" class="form-control"  :class="{'is-invalid': formValidate.password}" name="po"> 
                                </div>      
                                <div class="col-red" v-html="formValidate.password"></div>
                            </div>
                        </div> 
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float">
                                <div class="form-line"  >
                                    <label  class="form-label"><font color="red">*</font> RFC</label>
                                    <input type="text" v-model="newTutor.rfc" class="form-control"  :class="{'is-invalid': formValidate.rfc}" name="po"> 
                                </div>
                                <div class="col-red" v-html="formValidate.rfc"></div>
                            </div>
                        </div> 
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group" >
                                <label><font color="red">*</font> FACTURA</label>
                                <div class="demo-radio-button" style=" display:inline-block;">  
                                    <input name="group5" type="radio" id="radio_31" class="with-gap radio-col-green" v-model="newTutor.factura" value="1" />
                                    <label for="radio_31" style="display:block;">SI</label>
                                    <input name="group5" type="radio" id="radio_32" class="with-gap radio-col-red"  v-model="newTutor.factura" value="0" />
                                    <label for="radio_32" style="display:block;">NO</label>
                                </div>
                                <div class="col-red" v-html="formValidate.factura"></div>
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
                        <button class="btn btn-primary waves-effect waves-black" @click="addTutor"><i class='fa fa-floppy-o'></i> Agregar</button>
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
                <h4 class="modal-title" id="smallModalLabel">EDITAR TUTOR</h4>
            </div>
            <div class="modal-body">
                <div style=" height: 200px; padding-right:15px;  overflow-x: hidden; overflow-y: scroll;">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <label style="color: red" v-html="formValidate.msgerror"></label>
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float">
                                <div class="form-line focused"  > 
                                    <label  class="form-label"><font color="red">*</font> NOMBRE</label>
                                    <input type="text" v-model="chooseTutor.nombre" class="form-control"  :class="{'is-invalid': formValidate.nombre}" name="po"> 
                                </div>       
                                <div class="col-red" v-html="formValidate.nombre"></div>
                            </div>
                        </div> 
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float">
                                <div class="form-line focused"  > 
                                    <label  class="form-label"><font color="red">*</font> A. PATERNO</label>
                                    <input type="text" v-model="chooseTutor.apellidop" class="form-control"  :class="{'is-invalid': formValidate.apellidop}" name="po"> 
                                </div>      
                                <div class="col-red" v-html="formValidate.apellidop"></div>
                            </div>
                        </div> 
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float">
                                <div class="form-line focused"  > 
                                    <label  class="form-label">A. MATERNO</label>
                                    <input type="text" v-model="chooseTutor.apellidom" class="form-control"  :class="{'is-invalid': formValidate.apellidom}" name="po"> 
                                </div>     
                                <div class="col-red" v-html="formValidate.apellidom"></div>
                            </div>
                        </div> 
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float">
                                <div class="form-line focused"  > 
                                    <label  class="form-label">ESCOLARIDAD</label>
                                    <input type="text" v-model="chooseTutor.escolaridad" class="form-control"  :class="{'is-invalid': formValidate.escolaridad}" name="po"> 
                                </div>      
                                <div class="col-red" v-html="formValidate.escolaridad"></div>
                            </div>
                        </div> 
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float">
                                <div class="form-line focused"  > 
                                    <label  class="form-label">OCUPACIÓN</label>
                                    <input type="text" v-model="chooseTutor.ocupacion" class="form-control"  :class="{'is-invalid': formValidate.ocupacion}" name="po"> 
                                </div>      
                                <div class="col-red" v-html="formValidate.ocupacion"></div>
                            </div>
                        </div> 
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float">
                                <div class="form-line focused"  > 
                                    <label  class="form-label">DONDE TRABAJA</label>
                                    <input type="text" v-model="chooseTutor.dondetrabaja" class="form-control"  :class="{'is-invalid': formValidate.dondetrabaja}" name="po"> 
                                </div>      
                                <div class="col-red" v-html="formValidate.dondetrabaja"></div>
                            </div>
                        </div> 
                    </div>

                    <div class="row"> 
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float">
                                <div class="form-line focused"  > 
                                    <label  class="form-label"><font color="red">*</font> DIRECCIÓN</label>
                                    <input type="text" v-model="chooseTutor.direccion" class="form-control"  :class="{'is-invalid': formValidate.direccioni}" name="po"> 
                                </div>       
                                <div class="col-red" v-html="formValidate.direccion"></div>
                                <small>Formato: Calle, Num, Colonia, CP, Ciudad, Estado.</small>
                            </div>


                        </div> 
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float">
                                <div class="form-line focused"  > 
                                    <label  class="form-label"><font color="red">*</font> F. NACIMIENTO</label>
                                    <input type="text" v-model="chooseTutor.fnacimiento" class="form-control"  :class="{'is-invalid': formValidate.fnacimiento}" name="po"> 
                                </div>     
                                <div class="col-red" v-html="formValidate.fnacimiento"></div>
                            </div>
                        </div> 
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float">
                                <div class="form-line focused"  > 
                                    <label  class="form-label"><font color="red">*</font> TELEFONO</label>
                                    <input type="text" v-model="chooseTutor.telefono" class="form-control"  :class="{'is-invalid': formValidate.telefono}" name="po"> 
                                </div>       
                                <div class="col-red" v-html="formValidate.telefono"></div>
                            </div>
                        </div> 
                    </div>


                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float">
                                <div class="form-line focused"  > 
                                    <label  class="form-label"><font color="red">*</font> CORREO ELECTRONICO</label>
                                    <input type="text" v-model="chooseTutor.correo" class="form-control"  :class="{'is-invalid': formValidate.correo}" name="po"> 
                                </div>      
                                <div class="col-red" v-html="formValidate.correo"></div>
                            </div>
                        </div> 
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float">
                                <div class="form-line focused"  > 
                                    <label  class="form-label"><font color="red">*</font> RFC</label>
                                    <input type="text" v-model="chooseTutor.rfc" class="form-control"  :class="{'is-invalid': formValidate.rfc}" name="po"> 
                                </div>      
                                <div class="col-red" v-html="formValidate.rfc"></div>
                            </div>
                        </div> 
                    </div>
                    <div class="row">
                        <div class="col-md-7 col-sm-12 col-xs-12 ">
                            <div class="form-group">
                                <label for=""><font color="red">*</font> FACTURA</label><br> 
                                <div class="demo-radio-button" >  
                                    <input name="group5" type="radio" id="radio_31" class="with-gap radio-col-green" v-model="chooseTutor.factura" value="1" :checked="chooseTutor.factura==1" />
                                    <label for="radio_31">SI</label>
                                    <input name="group5" type="radio" id="radio_32" class="with-gap radio-col-red"  v-model="chooseTutor.factura" value="0" :checked="chooseTutor.factura==0" />
                                    <label for="radio_32">NO</label>
                                </div>

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
                        <button class="btn btn-primary waves-effect waves-black" @click="updateTutor"><i class='fa fa-edit'></i> Modificar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="changePassword" tabindex="-1" role="dialog">
    <div class="modal-dialog  clo" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="smallModalLabel">CAMBIAR CONTRASEÑA</h4>
            </div>
            <div class="modal-body">
                <div style="padding-right:15px;  height: 100px;overflow-x: hidden; overflow-y: scroll;">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <div class="col-red" v-html="formValidate.msgerror"></div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float">
                                <div class="form-line"  > 
                                    <label  class="form-label"><font color="red">*</font> NUEVA CONTRASEÑA</label>
                                    <input type="password" v-model="chooseTutor.password1" class="form-control"  :class="{'is-invalid': formValidate.password1}" name="po"> 
                                </div>       
                                <div class="col-red" v-html="formValidate.password1"></div>
                            </div>
                        </div> 
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float">
                                <div class="form-line"  > 
                                    <label  class="form-label"><font color="red">*</font> REPITA CONTRASEÑA</label>
                                    <input type="password" v-model="chooseTutor.password2" class="form-control"  :class="{'is-invalid': formValidate.password2}" name="po"> 
                                </div>      
                                <div class="col-red" v-html="formValidate.password2"></div>
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
                        <button class="btn btn-primary waves-effect waves-black" @click="updatePassword"><i class='fa fa-edit'></i> Modificar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

