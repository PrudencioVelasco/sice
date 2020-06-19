<!--add modal-->
<modal v-if="addModal" @close="clearAll()">
   <h3 slot="head" >Agregar Usuario</h3>
   <div slot="body" class="row">
    <div class="col-md-12">
       <div class="text-danger" v-html="formValidate.smserror"> </div>
    </div>
      <div class="col-md-6">


         <div class="form-group">
            <label><font color="red">*</font> Usuario</label>
            <input type="text" class="form-control" :class="{'is-invalid': formValidate.usuario}" name="usuario" v-model="newUser.usuario" autcomplete="off">
            <div class="text-danger" v-html="formValidate.usuario"> </div>
         </div>
          <div class="form-group">
            <label><font color="red">*</font> Apellido P.</label>
            <input type="text" class="form-control" :class="{'is-invalid': formValidate.apellidop}" name="apellidop" v-model="newUser.apellidop" autcomplete="off">
            <div class="text-danger" v-html="formValidate.apellidop"> </div>
         </div>
          <div class="form-group">
            <label><font color="red">*</font> Contraseña</label>
            <input type="password" class="form-control" :class="{'is-invalid': formValidate.password2}" name="password2" v-model="newUser.password2" autcomplete="off" >
            <div class="text-danger" v-html="formValidate.password2"></div>
         </div>
          <div class="form-group">
            <label><font color="red">*</font> Rol</label>

             <select v-model="newUser.rol"  :class="{'is-invalid': formValidate.rol}"class="form-control">
                <option value="" selected="">--Seleccionar--</option>
                <option   v-for="option in roles" v-bind:value="option.id">
                {{ option.rol }}
              </option>
            </select>
              <div class="text-danger" v-html="formValidate.rol"></div>
         </div>
      </div>
      <div class="col-md-6">
         <div class="form-group">
            <label><font color="red">*</font> Nombre</label>
            <input type="text" class="form-control" :class="{'is-invalid': formValidate.nombre}" name="nombre" v-model="newUser.nombre" autcomplete="off">
            <div class="text-danger" v-html="formValidate.nombre"></div>
         </div>
         <div class="form-group">
            <label> Apellido M.</label>
            <input type="text" class="form-control" :class="{'is-invalid': formValidate.apellidom}" name="apellidom" v-model="newUser.apellidom" autcomplete="off">
            <div class="text-danger" v-html="formValidate.apellidom"></div>
         </div>
          <div class="form-group">
            <label><font color="red">*</font> Repita Contraseña</label>
            <input class="form-control" :class="{'is-invalid': formValidate.password1}" name="password1" v-model="newUser.password1" type="password" autcomplete="off">
            <div class="text-danger" v-html="formValidate.password1"></div>
         </div> 
          <div class="form-group">
            <label><font color="red">*</font> Plantel</label>

             <select v-model="newUser.idplantel"  :class="{'is-invalid': formValidate.idplantel}"class="form-control">
                <option value="" selected="">--Seleccionar--</option>
                <option   v-for="option in planteles" v-bind:value="option.idplantel">
                {{option.nombreniveleducativo}} - {{ option.nombreplantel }}
              </option>
            </select>
              <div class="text-danger" v-html="formValidate.idplantel"></div>
         </div>
      </div>
   </div>
   <div slot="foot">
      <div class="row">
        <div  class="col-md-6 col-sm-12 col-xs-12 " align="center" >
           <div v-if="cargando">
               <img  style="width: 50px;" src="<?php echo base_url() . '/assets/loader/pagos.gif' ?>" alt=""> <strong>Procesando...</strong>
           </div>
           <div v-if="error"  align="left">
               <label class="text-danger">*Corrija los errores en el formulario.</label>
           </div>
        </div>
         <div class="col-md-6 col-sm-12 col-xs-12 "  align="right"  >
    <button class="btn btn-danger waves-effect waves-black" @click="clearAll"><i class='fa fa-ban'></i> Cancelar</button>
      <button class="btn btn-primary waves-effect waves-black" @click="addUser"><i class='fa fa-floppy-o'></i> Agregar</button>
         </div>
      </div>
   </div>
</modal>
<!--update modal-->
<modal v-if="editModal" @close="clearAll()">
   <h3 slot="head" >Editar usuario</h3>
   <div slot="body" class="row">
     <div class="col-md-12">
       <div class="text-danger" v-html="formValidate.smserror"> </div>
    </div>
    <div class="row">
      <div class="col-md-6">

       
         <div class="form-group">
            <label><font color="red">*</font> Usuario</label>
            <input type="text" class="form-control" :class="{'is-invalid': formValidate.usuario}" name="usuario" v-model="chooseUser.usuario" autcomplete="off" disabled="">
            <div class="text-danger" v-html="formValidate.usuario"> </div>
         </div>
          <div class="form-group">
            <label><font color="red">*</font> Apellido P.</label>
            <input type="text" class="form-control" :class="{'is-invalid': formValidate.apellidop}" name="apellidop" v-model="chooseUser.apellidop" autcomplete="off">
            <div class="text-danger" v-html="formValidate.apellidop"> </div>
         </div> 
           <div class="form-group">
            <label><font color="red">*</font> Rol</label>
              <select class="form-control" v-model="chooseUser.idrol" >
                  <option v-for="option in roles"  :selected="option.id == chooseUser.idrol ? 'selected' : ''" :value="option.id" >
                      {{ option.rol }}
                  </option>
             </select>
         </div>


      </div>
      <div class="col-md-6">
       <div class="form-group">
            <label><font color="red">*</font> Nombre</label>
            <input type="text" class="form-control" :class="{'is-invalid': formValidate.nombre}" name="nombre" v-model="chooseUser.nombre" autcomplete="off">
            <div class="text-danger" v-html="formValidate.nombre"></div>
         </div>
         <div class="form-group">
            <label> Apellido M.</label>
            <input type="text" class="form-control" :class="{'is-invalid': formValidate.apellidom}" name="apellidom" v-model="chooseUser.apellidom" autcomplete="off">
            <div class="text-danger" v-html="formValidate.apellidom"></div>
         </div>
             <div class="form-group">
            <label><font color="red">*</font> Plantel</label>
              <select class="form-control" v-model="chooseUser.idplantel" >
                  <option v-for="option in planteles"  :selected="option.idplantel == chooseUser.idplantel ? 'selected' : ''" :value="option.idplantel" >
                      {{ option.nombreplantel }}
                  </option>
             </select>
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
   <div slot="foot">
      <div class="row">
        <div  class="col-md-6 col-sm-12 col-xs-12 " align="center" >
           <div v-if="cargando">
               <img  style="width: 50px;" src="<?php echo base_url() . '/assets/loader/pagos.gif' ?>" alt=""> <strong>Procesando...</strong>
           </div>
           <div v-if="error"  align="left">
               <label class="text-danger">*Corrija los errores en el formulario.</label>
           </div>
        </div>
         <div class="col-md-6 col-sm-12 col-xs-12 "  align="right"  >
      <button class="btn btn-danger waves-effect waves-black" @click="clearAll"><i class='fa fa-ban'></i> Cancelar</button>
      <button class="btn btn-primary waves-effect waves-black" @click="updateUser"><i class='fa fa-edit'></i> Modificar</button>
         </div>
      </div>
   </div>
</modal>
<!--Modificar passeord model-->
 <modal v-if="passwordModal" @close="clearAll()">
   <h3 slot="head" >Cambiar Contraseña</h3>
   <div slot="body" class="row">
      <div class="col-md-6">
         <div class="form-group">
            <label><font color="red">*</font> Contraseña</label>


             <input type="password" class="form-control" :class="{'is-invalid': formValidate.password1}" name="password1" v-model="chooseUser.password1">
            <div class="text-danger" v-html="formValidate.password1"></div>

         </div>

      </div>
      <div class="col-md-6">
         <div class="form-group">
            <label><font color="red">*</font> Repita contraseña</label>
           <input type="password" class="form-control" :class="{'is-invalid': formValidate.password2}" name="password2" v-model="chooseUser.password2">
            <div class="text-danger" v-html="formValidate.password2"></div>
         </div>


      </div>
   </div>
   <div slot="foot">
      <div class="row">
        <div  class="col-md-6 col-sm-12 col-xs-12 " align="center" >
           <div v-if="cargando">
               <img  style="width: 50px;" src="<?php echo base_url() . '/assets/loader/pagos.gif' ?>" alt=""> <strong>Procesando...</strong>
           </div>
           <div v-if="error"  align="left">
               <label class="text-danger">*Corrija los errores en el formulario.</label>
           </div>
        </div>
         <div class="col-md-6 col-sm-12 col-xs-12 "  align="right"  >
      <button class="btn btn-danger waves-effect waves-black" @click="clearAll"><i class='fa fa-ban'></i> Cancelar</button>
      <button class="btn btn-primary waves-effect waves-black" @click="passwordupdateUser"><i class='fa fa-edit'></i> Modificar</button>
         </div>
      </div>
   </div>
</modal>
