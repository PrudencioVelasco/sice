 <div class="modal fade" id="addRegister" tabindex="-1" role="dialog">
                <div class="modal-dialog"  role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="smallModalLabel">AGREGAR PROFESOR</h4>
                        </div>
                        <div class="modal-body">
                           <div style=" height: 200px;  padding-top:13px;  padding-right:15px; overflow-x: hidden; overflow-y: scroll;">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 ">
                <div class="col-red" v-html="formValidate.msgerror"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 ">
                <div class="form-group form-float">
                       <div class="form-line"  >
                    <label  class="form-label"><font color="red">*</font> CÉDULA PROFESIONAL</label>
                    <input type="text" v-model="newProfesor.cedula" class="form-control"  :class="{'is-invalid': formValidate.cedula}" name="po"> 
                       </div>     
                    <div class="col-red" v-html="formValidate.cedula"></div>
                </div>
            </div>   
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-12 col-xs-12 ">
              <div class="form-group form-float">
                       <div class="form-line"  >
                    <label  class="form-label"><font color="red">*</font> NOMBRE</label>
                    <input type="text" v-model="newProfesor.nombre" class="form-control"  :class="{'is-invalid': formValidate.nombre}" name="po"> 
                       </div>      
                    <div class="col-red" v-html="formValidate.nombre"></div>
                </div>
            </div> 
            <div class="col-md-6 col-sm-12 col-xs-12 ">
              <div class="form-group form-float">
                       <div class="form-line"  >
                    <label  class="form-label"><font color="red">*</font> A. PATERNO</label>
                    <input type="text" v-model="newProfesor.apellidop" class="form-control"  :class="{'is-invalid': formValidate.apellidop}" name="po"> 
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
                    <input type="text" v-model="newProfesor.apellidom" class="form-control"  :class="{'is-invalid': formValidate.apellidom}" name="po"> 
                       </div>      
                    <div class="col-red" v-html="formValidate.apellidom"></div>
                </div>
            </div> 
            <div class="col-md-6 col-sm-12 col-xs-12 ">
                <div class="form-group form-float">
                       <div class="form-line"  >
                    <label  class="form-label"><font color="red">*</font> PROFESIÓN</label>
                    <input type="text" v-model="newProfesor.profesion" class="form-control"  :class="{'is-invalid': formValidate.profesion}" name="po"> 
                       </div>
                    <div class="col-red" v-html="formValidate.profesion"></div>
                </div>
            </div> 
        </div>


         <div class="row">
            <div class="col-md-6 col-sm-12 col-xs-12 ">
              <div class="form-group form-float">
                       <div class="form-line"  >
                    <label  class="form-label"><font color="red">*</font> CORREO ELECTRONICO</label>
                    <input type="text" v-model="newProfesor.correo" class="form-control"  :class="{'is-invalid': formValidate.correo}" name="po"> 
                       </div>     
                    <div class="col-red" v-html="formValidate.correo"></div>
                </div>
            </div> 
            <div class="col-md-6 col-sm-12 col-xs-12 ">
              <div class="form-group form-float">
                       <div class="form-line"  >
                    <label  class="form-label"><font color="red">*</font> CONTRASEÑA</label>
                    <input type="password" v-model="newProfesor.password" class="form-control"  :class="{'is-invalid': formValidate.password}" name="po"> 
                       </div>      
                    <div class="col-red" v-html="formValidate.password"></div>
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
        <button class="btn btn-primary waves-effect waves-black" @click="addProfesor"><i class='fa fa-floppy-o'></i> Agregar</button>
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
                            <div style=" height: 100px; padding-right:15px; padding-top:13px; overflow-x: hidden; overflow-y: scroll;">
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
                                        <input type="password" v-model="chooseProfesor.password1" class="form-control"  :class="{'is-invalid': formValidate.password1}" name="po"> 
                       </div>  
                                        <div class="col-red" v-html="formValidate.password1"></div>
                                    </div>
                                </div> 
                                <div class="col-md-6 col-sm-12 col-xs-12 ">
                                   <div class="form-group form-float">
                       <div class="form-line"  >
                    <label  class="form-label"><font color="red">*</font> REPITA CONTRASEÑA</label>
                                        <input type="password" v-model="chooseProfesor.password2" class="form-control"  :class="{'is-invalid': formValidate.password2}" name="po"> 
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
        <button class="btn btn-primary waves-effect waves-black" @click="updatePasswordProfesor"><i class='fa fa-floppy-o'></i> Modificar</button>
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
                            <h4 class="modal-title" id="smallModalLabel">EDITAR PROFESOR</h4>
                        </div>
                        <div class="modal-body">
                             <div style=" height: 200px;overflow-x: hidden; padding-top:13px; padding-right:15px;  overflow-y: scroll;">
         <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 ">
                <div class="col-red" v-html="formValidate.msgerror"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 ">
                  <div class="form-group form-float">
                   <div class="form-line focused"  > 
                   <label  class="form-label"><font color="red">*</font> Cedula Profesional</label>
                    <input type="text" v-model="chooseProfesor.cedula" class="form-control"  :class="{'is-invalid': formValidate.cedula}" name="po"> 
                   </div>      
                    <div class="col-red" v-html="formValidate.cedula"></div>
                </div>
            </div>   
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-12 col-xs-12 ">
                 <div class="form-group form-float">
                   <div class="form-line focused"  > 
                   <label  class="form-label"><font color="red">*</font> Nombre</label>
                    <input type="text" v-model="chooseProfesor.nombre" class="form-control"  :class="{'is-invalid': formValidate.nombre}" name="po"> 
                   </div>      
                    <div class="col-red" v-html="formValidate.nombre"></div>
                </div>
            </div> 
            <div class="col-md-6 col-sm-12 col-xs-12 ">
                  <div class="form-group form-float">
                   <div class="form-line focused"  > 
                   <label  class="form-label"><font color="red">*</font> A. Paterno</label>
                    <input type="text" v-model="chooseProfesor.apellidop" class="form-control"  :class="{'is-invalid': formValidate.apellidop}" name="po"> 
                   </div>      
                    <div class="col-red" v-html="formValidate.apellidop"></div>
                </div>
            </div> 
        </div>
          <div class="row">
            <div class="col-md-6 col-sm-12 col-xs-12 ">
                 <div class="form-group form-float">
                   <div class="form-line focused"  > 
                   <label  class="form-label">A. Materno</label>
                    <input type="text" v-model="chooseProfesor.apellidom" class="form-control"  :class="{'is-invalid': formValidate.apellidom}" name="po"> 
                   </div>      
                    <div class="col-red" v-html="formValidate.apellidom"></div>
                </div>
            </div> 
            <div class="col-md-6 col-sm-12 col-xs-12 ">
                 <div class="form-group form-float">
                   <div class="form-line focused"  > 
                   <label  class="form-label"><font color="red">*</font> Profesión</label>
                    <input type="text" v-model="chooseProfesor.profesion" class="form-control"  :class="{'is-invalid': formValidate.profesion}" name="po"> 
                   </div>
                    <div class="col-red" v-html="formValidate.profesion"></div>
                </div>
            </div> 
        </div>


         <div class="row">
            <div class="col-md-6 col-sm-12 col-xs-12 ">
                  <div class="form-group form-float">
                   <div class="form-line focused"  > 
                   <label  class="form-label"><font color="red">*</font> Correo electronico</label>
                    <input type="text" v-model="chooseProfesor.correo" class="form-control"  :class="{'is-invalid': formValidate.correo}" name="po"> 
                   </div>      
                    <div class="col-red" v-html="formValidate.correo"></div>
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
        <button class="btn btn-primary waves-effect waves-black" @click="updateProfesor"><i class='fa fa-edit'></i> Modificar</button>
         </div>
        </div>
                        </div>
                    </div>
                </div>
            </div>

 