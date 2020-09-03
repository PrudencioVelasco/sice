             <div class="modal fade" id="editRegister" tabindex="-1" role="dialog">
                 <div class="modal-dialog" role="document">
                     <div class="modal-content">
                         <div class="modal-header">
                             <h4 class="modal-title" id="defaultModalLabel">DETALLES ALUMNO(A)</h4>
                         </div>
                         <div class="modal-body">
                             <div
                                 style="padding-top:13px; padding-right:15px;">
                                 <div class="row">
                                     <div class="col-md-12 col-sm-12 col-xs-12 ">
                                         <div class="col-red" v-html="formValidate.msgerror"></div>
                                     </div>
                                 </div>
                                 <div class="row clearfix">
                                     <div class="col-md-6 col-sm-12 col-xs-12 ">
                                         <div class="form-group ">

                                             <label class="form-label">
                                                 <font color="red">*</font> MATRICULA
                                             </label>
                                             <input disabled type="text" v-model="chooseAlumno.matricula"
                                                 class="form-control" :value="chooseAlumno.matricula"
                                                 :class="{'is-invalid': formValidate.matricula}" name="po">

                                             <div class="col-red" v-html="formValidate.matricula"></div>
                                         </div>
                                     </div>
                                     <div class="col-md-6 col-sm-12 col-xs-12 ">
                                         <div class="form-group ">

                                             <label class="form-label">
                                                 <font color="red">*</font> NOMBRE
                                             </label>
                                             <input disabled type="text" v-model="chooseAlumno.nombre"
                                                 class="form-control" :class="{'is-invalid': formValidate.nombre}"
                                                 name="po">

                                             <div class="col-red" v-html="formValidate.nombre"></div>
                                         </div>
                                     </div>
                                 </div>
                                 <div class="row">
                                     <div class="col-md-6 col-sm-12 col-xs-12 ">
                                         <div class="form-group  ">
                                             <label class="form-label">
                                                 <font color="red">*</font> A. PATERNO
                                             </label>
                                             <input disabled type="text" v-model="chooseAlumno.apellidop"
                                                 class="form-control" :class="{'is-invalid': formValidate.apellidop}"
                                                 name="po">
                                             <div class="col-red" v-html="formValidate.apellidop"></div>
                                         </div>
                                     </div>
                                     <div class="col-md-6 col-sm-12 col-xs-12 ">
                                         <div class="form-group ">
                                             <label class="form-label">A. MATERNO</label>
                                             <input disabled type="text" v-model="chooseAlumno.apellidom"
                                                 class="form-control" :class="{'is-invalid': formValidate.apellidom}"
                                                 name="po">

                                             <div class="col-red" v-html="formValidate.apellidom"></div>
                                         </div>
                                     </div>
                                 </div>
                                 <div class="row">

                                     <div class="col-md-6 col-sm-12 col-xs-12 ">
                                         <div class="form-group ">

                                             <label class="form-label">
                                                 <font color="red">*</font> CURP
                                             </label>
                                             <input disabled type="text" v-model="chooseAlumno.curp"
                                                 class="form-control" :class="{'is-invalid': formValidate.curp}"
                                                 name="po">

                                             <div class="col-red" v-html="formValidate.curp"></div>
                                         </div>
                                     </div>

                                     <div class="col-md-6 col-sm-12 col-xs-12 ">
                                         <div class="form-group ">

                                             <label class="form-label">
                                                 <font color="red">*</font> LUGAR DE NACIMIENTO
                                             </label>
                                             <input disabled type="text" v-model="chooseAlumno.lugarnacimiento"
                                                 class="form-control"
                                                 :class="{'is-invalid': formValidate.lugarnacimiento}" name="po">

                                             <div class="col-red" v-html="formValidate.lugarnacimiento"></div>
                                         </div>
                                     </div>

                                 </div>
                                 <div class="row">

                                     <div class="col-md-6 col-sm-12 col-xs-12 ">
                                         <div class="form-group ">

                                             <label class="form-label">
                                                 <font color="red">*</font> NACIONALIDAD
                                             </label>
                                             <input disabled type="text" v-model="chooseAlumno.nacionalidad"
                                                 class="form-control" :class="{'is-invalid': formValidate.nacionalidad}"
                                                 name="po">

                                             <div class="col-red" v-html="formValidate.nacionalidad"></div>
                                         </div>
                                     </div> 
<div class="col-md-6 col-sm-12 col-xs-12 ">
                                         <div class="form-group">
                                             <label class="form-label">
                                                 <font color="red">*</font> FECHA NACIMIENTO
                                             </label>
                                             <input disabled type="date" v-model="chooseAlumno.fechanacimiento"
                                                 class="form-control"
                                                 :class="{'is-invalid': formValidate.fechanacimiento}" name="po">
                                             <div class="col-red" v-html="formValidate.fechanacimiento"></div>
                                         </div>
                                     </div> 
                                 </div>
                                 <div class="row">

                                     <div class="col-md-6 col-sm-12 col-xs-12 ">
                                         <div class="form-group ">
                                             <label class="form-label"> TELEFONO</label>
                                             <input disabled type="text" v-model="chooseAlumno.telefono"
                                                 class="form-control" :class="{'is-invalid': formValidate.telefono}"
                                                 name="po">
                                             
                                             <div class="col-red" v-html="formValidate.telefono"></div>
                                         </div>
                                     </div>

                                     <div class="col-md-6 col-sm-12 col-xs-12 ">
                                         <div class="form-group ">
                                             <label class="form-label"> TELEFONO DE EMERGENCIA</label>
                                             <input disabled type="text" v-model="chooseAlumno.telefonoemergencia"
                                                 class="form-control"
                                                 :class="{'is-invalid': formValidate.telefonoemergencia}" name="po">
                                           
                                             <div class="col-red" v-html="formValidate.telefonoemergencia"></div>
                                         </div>
                                     </div>

                                 </div>
                                 <div class="row">

                                     <div class="col-md-6 col-sm-12 col-xs-12 ">
                                         <div class="form-group">
                                             <label class="form-label"> TIPO SANGUINEO</label><br/>
                                             <span>{{chooseAlumno.tiposanguineo}}</span> 
                                             </select>
                                             <div class="col-red" v-html="formValidate.idtiposanguineo"></div>
                                         </div>
                                     </div> 
 
                                     <div class="col-md-6 col-sm-12 col-xs-12 ">
                                         <div class="form-group ">

                                             <label class="form-label">CORREO ELECTRONICO</label>
                                             <input disabled type="text" v-model="chooseAlumno.correo" class="form-control"
                                                 :class="{'is-invalid': formValidate.correo}" name="po">

                                             <div class="col-red" v-html="formValidate.correo"></div>
                                         </div>
                                     </div>
                                 </div>
                                 <div class="row clearfix">
                                     <div class="col-md-12 col-sm-12 col-xs-12 ">
                                         <div class="form-group">
                                             <label>
                                                 <font color="red">*</font> Sexo
                                             </label> <br>
                                             <div class="demo-radio-button">
                                                 <input name="group5" type="radio" id="radio_31"
                                                     class="with-gap radio-col-blue" v-model="chooseAlumno.sexo"
                                                     value="1" :checked="chooseAlumno.sexo==1" />
                                                 <label for="radio_31">HOMBRE</label>
                                                 <input name="group5" type="radio" id="radio_32"
                                                     class="with-gap radio-col-pink" v-model="chooseAlumno.sexo"
                                                     value="0" :checked="chooseAlumno.sexo==0" />
                                                 <label for="radio_32">MUJER</label>
                                             </div>
                                             <div class="col-red" v-html="formValidate.sexo"></div>
                                         </div>
                                     </div>
                                 </div> 
                                 <div class="row clearfix">
                                     <div class="col-md-12 col-sm-12 col-xs-12 ">
                                         <div class="form-group ">

                                             <label class="form-label">
                                                 <font color="red">*</font> DOMICILIO
                                             </label>
                                             <input type="test" disabled v-model="chooseAlumno.domicilio" class="form-control"
                                                 :class="{'is-invalid': formValidate.domicilio}" name="po">

                                            
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
                                         <img style="width: 50px;"
                                             src="<?php echo base_url() . '/assets/loader/pagos.gif' ?>" alt="">
                                         <strong>Procesando...</strong>
                                     </div>
                                     <div v-if="error" align="left">
                                         <label class="col-red">*Corrija los errores en el formulario.</label>
                                     </div>
                                 </div>
                                 <div class="col-md-6 col-sm-12 col-xs-12 ">
                                     <button class="btn btn-danger waves-effect waves-black" @click="clearAll"><i
                                             class='fa fa-ban'></i> Cerrar</button> 
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>



             <div class="modal fade" id="subirFoto" tabindex="-1" role="dialog">
                 <div class="modal-dialog" role="document">
                     <div class="modal-content">
                         <div class="modal-header">
                             <h4 class="modal-title" id="defaultModalLabel">SUBIR FOTO</h4>
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
                                         <input type="file" id="file" ref="file" v-on:change="onChangeFileUpload()"
                                             class="form-control">

                                         <div class="col-red" v-html="formValidate.file"></div>
                                     </div>
                                 </div>
                             </div>

                         </div>
                         <div class="modal-footer">
                             <div class="row">
                                 <div class="col-md-6 col-sm-12 col-xs-12 " align="center">
                                     <div v-if="cargando">
                                         <img style="width: 50px;"
                                             src="<?php echo base_url() . '/assets/loader/pagos.gif' ?>" alt="">
                                         <strong>Procesando...</strong>
                                     </div>
                                     <div v-if="error" align="left">
                                         <label class="col-red">*Corrija los errores en el formulario.</label>
                                     </div>
                                 </div>
                                 <div class="col-md-6 col-sm-12 col-xs-12 ">
                                     <button class="btn btn-danger waves-effect waves-black" @click="clearAll"><i
                                             class='fa fa-ban'></i> Cancelar</button>
                                     <button class="btn btn-primary waves-effect waves-black" v-on:click="subirFoto"><i
                                             class='fa fa-upload'></i> Subir</button>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>