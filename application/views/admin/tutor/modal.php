<!--add modal-->
<modal v-if="addModal" @close="clearAll()">
    <h3 slot="head" >Agregar  Tutor</h3>
    <div slot="body"  >
        <div style=" height: 200px; overflow-x: hidden; overflow-y: scroll;">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 ">
                <label style="color: red" v-html="formValidate.msgerror"></label>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <label><font color="red">*</font> Nombre</label>
                    <input type="text" v-model="newTutor.nombre" class="form-control"  :class="{'is-invalid': formValidate.nombre}" name="po"> 
                           <div class="text-danger" v-html="formValidate.nombre"></div>
                </div>
            </div> 
            <div class="col-md-6 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <label><font color="red">*</font> A. Paterno</label>
                    <input type="text" v-model="newTutor.apellidop" class="form-control"  :class="{'is-invalid': formValidate.apellidop}" name="po"> 
                           <div class="text-danger" v-html="formValidate.apellidop"></div>
                </div>
            </div> 
        </div>

           <div class="row">
            <div class="col-md-6 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <label>A. Materno</label>
                    <input type="text" v-model="newTutor.apellidom" class="form-control"  :class="{'is-invalid': formValidate.apellidom}" name="po"> 
                           <div class="text-danger" v-html="formValidate.apellidom"></div>
                </div>
            </div> 
            <div class="col-md-6 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <label>Escolaridad</label>
                    <input type="text" v-model="newTutor.escolaridad" class="form-control"  :class="{'is-invalid': formValidate.escolaridad}" name="po"> 
                           <div class="text-danger" v-html="formValidate.escolaridad"></div>
                </div>
            </div> 
        </div>
          <div class="row">
            <div class="col-md-6 col-sm-12 col-xs-12 ">
               <div class="form-group">
                    <label>Ocupación</label>
                    <input type="text" v-model="newTutor.ocupacion" class="form-control"  :class="{'is-invalid': formValidate.ocupacion}" name="po"> 
                           <div class="text-danger" v-html="formValidate.ocupacion"></div>
                </div>
            </div> 
            <div class="col-md-6 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <label>Donde Trabaja</label>
                    <input type="text" v-model="newTutor.dondetrabaja" class="form-control"  :class="{'is-invalid': formValidate.dondetrabaja}" name="po"> 
                           <div class="text-danger" v-html="formValidate.dondetrabaja"></div>
                </div>
            </div> 
        </div>
       
           <div class="row"> 
            <div class="col-md-12 col-sm-12 col-xs-12 ">
                 <div class="form-group">
                    <label><font color="red">*</font>Dirección</label>
                    <input type="text" v-model="newTutor.direccion" class="form-control"  :class="{'is-invalid': formValidate.direccioni}" name="po"> 
                           <div class="text-danger" v-html="formValidate.direccion"></div>
                           <small>Formato: Calle, Num, Colonia, CP, Ciudad, Estado.</small>
                </div>

              
            </div> 
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-12 col-xs-12 ">
                 <div class="form-group">
                    <label><font color="red">*</font> F. Nacimiento</label>
                    <input type="date" v-model="newTutor.fnacimiento" class="form-control"  :class="{'is-invalid': formValidate.fnacimiento}" name="po"> 
                           <div class="text-danger" v-html="formValidate.fnacimiento"></div>
                </div>
            </div> 
            <div class="col-md-6 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <label><font color="red">*</font> Telefono</label>
                    <input type="text" v-model="newTutor.telefono" class="form-control"  :class="{'is-invalid': formValidate.telefono}" name="po"> 
                           <div class="text-danger" v-html="formValidate.telefono"></div>
                </div>
            </div> 
        </div>


         <div class="row">
            <div class="col-md-6 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <label><font color="red">*</font> Correo electronico</label>
                    <input type="text" v-model="newTutor.correo" class="form-control"  :class="{'is-invalid': formValidate.correo}" name="po"> 
                           <div class="text-danger" v-html="formValidate.correo"></div>
                </div>
            </div> 
            <div class="col-md-6 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <label><font color="red">*</font> Contraseña</label>
                    <input type="password" v-model="newTutor.password" class="form-control"  :class="{'is-invalid': formValidate.password}" name="po"> 
                           <div class="text-danger" v-html="formValidate.password"></div>
                </div>
            </div> 
        </div>

         <div class="row">
            <div class="col-md-6 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <label><font color="red">*</font> RFC</label>
                    <input type="text" v-model="newTutor.rfc" class="form-control"  :class="{'is-invalid': formValidate.rfc}" name="po"> 
                    <div class="text-danger" v-html="formValidate.rfc"></div>
                </div>
            </div> 
            <div class="col-md-6 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <label><font color="red">*</font> Factura</label>
                    <div class="demo-radio-button" >  
                        <input name="group5" type="radio" id="radio_31" class="with-gap radio-col-green" v-model="newTutor.factura" value="1" />
                        <label for="radio_31">SI</label>
                        <input name="group5" type="radio" id="radio_32" class="with-gap radio-col-red"  v-model="newTutor.factura" value="0" />
                        <label for="radio_32">NO</label>
                    </div>
                    <div class="text-danger" v-html="formValidate.factura"></div>
                </div>
            </div> 
        </div>
 
  
    </div>
    </div>
    <div slot="foot"> 
        <button class="btn btn-danger waves-effect waves-black" @click="clearAll"><i class='fa fa-ban'></i> Cancelar</button>
        <button class="btn btn-primary waves-effect waves-black" @click="addTutor"><i class='fa fa-floppy-o'></i> Agregar</button>
    </div>
</modal>
<modal v-if="editModal" @close="clearAll()">
    <h3 slot="head" >Editar Tutor</h3>
    <div slot="body">
         <div style=" height: 200px;overflow-x: hidden; overflow-y: scroll;">
         <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 ">
                 <label style="color: red" v-html="formValidate.msgerror"></label>
            </div>
        </div>
     <div class="row">
            <div class="col-md-6 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <label><font color="red">*</font> Nombre</label>
                    <input type="text" v-model="chooseTutor.nombre" class="form-control"  :class="{'is-invalid': formValidate.nombre}" name="po"> 
                           <div class="text-danger" v-html="formValidate.nombre"></div>
                </div>
            </div> 
            <div class="col-md-6 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <label><font color="red">*</font> A. Paterno</label>
                    <input type="text" v-model="chooseTutor.apellidop" class="form-control"  :class="{'is-invalid': formValidate.apellidop}" name="po"> 
                           <div class="text-danger" v-html="formValidate.apellidop"></div>
                </div>
            </div> 
        </div>

           <div class="row">
            <div class="col-md-6 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <label>A. Materno</label>
                    <input type="text" v-model="chooseTutor.apellidom" class="form-control"  :class="{'is-invalid': formValidate.apellidom}" name="po"> 
                           <div class="text-danger" v-html="formValidate.apellidom"></div>
                </div>
            </div> 
            <div class="col-md-6 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <label>Escolaridad</label>
                    <input type="text" v-model="chooseTutor.escolaridad" class="form-control"  :class="{'is-invalid': formValidate.escolaridad}" name="po"> 
                           <div class="text-danger" v-html="formValidate.escolaridad"></div>
                </div>
            </div> 
        </div>
          <div class="row">
            <div class="col-md-6 col-sm-12 col-xs-12 ">
               <div class="form-group">
                    <label>Ocupación</label>
                    <input type="text" v-model="chooseTutor.ocupacion" class="form-control"  :class="{'is-invalid': formValidate.ocupacion}" name="po"> 
                           <div class="text-danger" v-html="formValidate.ocupacion"></div>
                </div>
            </div> 
            <div class="col-md-6 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <label>Donde Trabaja</label>
                    <input type="text" v-model="chooseTutor.dondetrabaja" class="form-control"  :class="{'is-invalid': formValidate.dondetrabaja}" name="po"> 
                           <div class="text-danger" v-html="formValidate.dondetrabaja"></div>
                </div>
            </div> 
        </div>
       
           <div class="row"> 
            <div class="col-md-12 col-sm-12 col-xs-12 ">
                 <div class="form-group">
                    <label><font color="red">*</font>Dirección</label>
                    <input type="text" v-model="chooseTutor.direccion" class="form-control"  :class="{'is-invalid': formValidate.direccioni}" name="po"> 
                           <div class="text-danger" v-html="formValidate.direccion"></div>
                           <small>Formato: Calle, Num, Colonia, CP, Ciudad, Estado.</small>
                </div>

              
            </div> 
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-12 col-xs-12 ">
                 <div class="form-group">
                    <label><font color="red">*</font> F. Nacimiento</label>
                    <input type="date" v-model="chooseTutor.fnacimiento" class="form-control"  :class="{'is-invalid': formValidate.fnacimiento}" name="po"> 
                           <div class="text-danger" v-html="formValidate.fnacimiento"></div>
                </div>
            </div> 
            <div class="col-md-6 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <label><font color="red">*</font> Telefono</label>
                    <input type="text" v-model="chooseTutor.telefono" class="form-control"  :class="{'is-invalid': formValidate.telefono}" name="po"> 
                           <div class="text-danger" v-html="formValidate.telefono"></div>
                </div>
            </div> 
        </div>


         <div class="row">
            <div class="col-md-6 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <label><font color="red">*</font> Correo electronico</label>
                    <input type="text" v-model="chooseTutor.correo" class="form-control"  :class="{'is-invalid': formValidate.correo}" name="po"> 
                           <div class="text-danger" v-html="formValidate.correo"></div>
                </div>
            </div> 
            <div class="col-md-6 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <label><font color="red">*</font> RFC</label>
                    <input type="text" v-model="chooseTutor.rfc" class="form-control"  :class="{'is-invalid': formValidate.rfc}" name="po"> 
                           <div class="text-danger" v-html="formValidate.rfc"></div>
                </div>
            </div> 
        </div>
              <div class="row">
                <div class="col-md-7 col-sm-12 col-xs-12 ">
                 <div class="form-group">
                <label for=""><font color="red">*</font> Factura</label><br> 
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
    <div slot="foot">
        <button class="btn btn-danger waves-effect waves-black" @click="clearAll"><i class='fa fa-ban'></i> Cancelar</button>
        <button class="btn btn-primary waves-effect waves-black" @click="updateTutor"><i class='fa fa-edit'></i>  Modificar</button>
    </div>
</modal>

<modal v-if="editPasswordModal" @close="clearAll()">
    <h3 slot="head" >Cambiar Contraseña</h3>
    <div slot="body">
         <div style=" height: 100px;overflow-x: hidden; overflow-y: scroll;">
         <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 ">
                <div class="text-danger" v-html="formValidate.msgerror"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <label><font color="red">*</font> Nueva Contraseña</label>
                    <input type="password" v-model="chooseTutor.password1" class="form-control"  :class="{'is-invalid': formValidate.password1}" name="po"> 
                           <div class="text-danger" v-html="formValidate.password1"></div>
                </div>
            </div> 
            <div class="col-md-6 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <label><font color="red">*</font> Repita Contraseña</label>
                    <input type="password" v-model="chooseTutor.password2" class="form-control"  :class="{'is-invalid': formValidate.password2}" name="po"> 
                           <div class="text-danger" v-html="formValidate.password2"></div>
                </div>
            </div> 
        </div>    
 
</div>
    </div>
    <div slot="foot">
        <button class="btn btn-danger waves-effect waves-black" @click="clearAll"><i class='fa fa-ban'></i> Cancelar</button>
        <button class="btn btn-primary waves-effect waves-black" @click="updatePassword"><i class='fa fa-edit'></i> Modificar</button>
    </div>
</modal>



