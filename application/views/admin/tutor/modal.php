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
                    <label><font color="red">*</font> F. Nacimiento</label>
                    <input type="date" v-model="newTutor.fnacimiento" class="form-control"  :class="{'is-invalid': formValidate.fnacimiento}" name="po"> 
                           <div class="text-danger" v-html="formValidate.fnacimiento"></div>
                </div>
            </div> 
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <label><font color="red">*</font>Dirección</label>
                    <input type="text" v-model="newTutor.direccion" class="form-control"  :class="{'is-invalid': formValidate.direccioni}" name="po"> 
                           <div class="text-danger" v-html="formValidate.direccion"></div>
                           <small>Formato: Calle, Num, Colonia, CP, Ciudad, Estado.</small>
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
 
  
    </div>
    </div>
    <div slot="foot"> 
        <button class="btn btn-danger" @click="clearAll"><i class='fa fa-ban'></i> Cancelar</button>
        <button class="btn btn-primary" @click="addTutor"><i class='fa fa-floppy-o'></i> Agregar</button>
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
                    <label><font color="red">*</font> F. Nacimiento</label>
                    <input type="date" v-model="chooseTutor.fnacimiento" class="form-control"  :class="{'is-invalid': formValidate.fnacimiento}" name="po"> 
                           <div class="text-danger" v-html="formValidate.fnacimiento"></div>
                </div>
            </div> 
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <label><font color="red">*</font> Dirección</label>
                    <input type="text" v-model="chooseTutor.direccion" class="form-control"  :class="{'is-invalid': formValidate.direccioni}" name="po"> 
                           <div class="text-danger" v-html="formValidate.direccion"></div>
                           <small>Formato: Calle, Num, Colonia, CP, Ciudad, Estado.</small>
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
        </div>
 
 
</div>
    </div>
    <div slot="foot">
        <button class="btn btn-danger" @click="clearAll"><i class='fa fa-ban'></i> Cancelar</button>
        <button class="btn btn-primary" @click="updateTutor"><i class='fa fa-edit'></i>  Modificar</button>
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
        <button class="btn btn-danger" @click="clearAll"><i class='fa fa-ban'></i> Cancelar</button>
        <button class="btn btn-primary" @click="updatePassword"><i class='fa fa-edit'></i> Modificar</button>
    </div>
</modal>



