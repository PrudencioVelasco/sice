<!--add modal-->
<modal v-if="addModal" @close="clearAll()">
    <h3 slot="head" >Agregar Alumno</h3>
    <div slot="body"  >
        <div style=" height: 200px; overflow-x: hidden; overflow-y: scroll;">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 ">
                <div class="text-danger" v-html="formValidate.msgerror"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <label><font color="red">*</font> Matricula</label>
                    <input type="text" v-model="newAlumno.matricula" class="form-control"  :class="{'is-invalid': formValidate.matricula}" name="po"> 
                           <div class="text-danger" v-html="formValidate.matricula"></div>
                </div>
            </div>  
            <div class="col-md-6 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <label><font color="red">*</font> Nombre</label>
                    <input type="text" v-model="newAlumno.nombre" class="form-control"  :class="{'is-invalid': formValidate.nombre}" name="po"> 
                           <div class="text-danger" v-html="formValidate.nombre"></div>
                </div>
            </div>
        </div>
        <div class="row">
             
            <div class="col-md-6 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <label><font color="red">*</font> A. Paterno</label>
                    <input type="text" v-model="newAlumno.apellidop" class="form-control"  :class="{'is-invalid': formValidate.apellidop}" name="po"> 
                           <div class="text-danger" v-html="formValidate.apellidop"></div>
                </div>
            </div> 

              <div class="col-md-6 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <label>A. Materno</label>
                    <input type="text" v-model="newAlumno.apellidom" class="form-control"  :class="{'is-invalid': formValidate.apellidom}" name="po"> 
                           <div class="text-danger" v-html="formValidate.apellidom"></div>
                </div>
            </div> 

        </div>
          <div class="row">
            <div class="col-md-6 col-sm-12 col-xs-12 ">
                <div class="form-group" style="display: block;">
                    <label><font color="red">*</font> Sexo</label> <br>

                   
                            <div class="demo-radio-button" style="display: block;">  
                                <input name="group5" type="radio" id="radio_31" class="with-gap radio-col-blue" v-model="newAlumno.sexo"value="1"  />
                                <label for="radio_31">HOMBRE</label>
                                <input name="group5" type="radio" id="radio_32" class="with-gap radio-col-pink"  v-model="newAlumno.sexo" value="0" />
                                <label for="radio_32">MUJER</label>
                            </div>
                            
                    <div class="text-danger" v-html="formValidate.sexo"></div>
                </div>
            </div> 
            <div class="col-md-6 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <label><font color="red">*</font> Fecha nacimiento</label>
                    <input type="date" v-model="newAlumno.fechanacimiento" class="form-control"  :class="{'is-invalid': formValidate.fechanacimiento}" name="po"> 
                           <div class="text-danger" v-html="formValidate.fechanacimiento"></div>
                </div>
            </div> 
        </div> 

         <div class="row">
              <div class="col-md-6 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <label>Correo electronico</label>
                    <input type="text" v-model="newAlumno.correo" class="form-control"  :class="{'is-invalid': formValidate.correo}" name="po"> 
                           <div class="text-danger" v-html="formValidate.correo"></div>
                </div>
            </div> 
            <div class="col-md-6 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <label><font color="red">*</font> Contraseña</label>
                    <input type="password" v-model="newAlumno.password" class="form-control"  :class="{'is-invalid': formValidate.password}" name="po"> 
                           <div class="text-danger" v-html="formValidate.password"></div>
                </div>
            </div> 
        </div>
     <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <label><font color="red">*</font> Especialidad</label> 
                      <select v-model="newAlumno.idespecialidad"  :class="{'is-invalid': formValidate.idespecialidad}"class="form-control">
                        <option value="">--Seleccione--</option>
                        <option   v-for="option in especialidades" v-bind:value="option.idespecialidad">
                        {{ option.nombreespecialidad }}   
                      </option>
                    </select>
                     <div class="text-danger" v-html="formValidate.idespecialidad"></div>
                </div>
            </div>  
        </div>
 
  
    </div>
    </div>
    <div slot="foot"> 
        <button class="btn btn-danger" @click="clearAll"><i class='fa fa-ban'></i> Cancelar</button>
        <button class="btn btn-primary" @click="addAlumno"><i class='fa fa-floppy-o'></i> Agregar</button>
    </div>
</modal>
<modal v-if="editModal" @close="clearAll()">
    <h3 slot="head" >Editar Alumno</h3>
    <div slot="body">
         <div style=" height: 200px;overflow-x: hidden; overflow-y: scroll;">
         <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 ">
                <div class="text-danger" v-html="formValidate.msgerror"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <label><font color="red">*</font> Matricula</label>
                    <input type="text" v-model="chooseAlumno.matricula" class="form-control"  :class="{'is-invalid': formValidate.matricula}" name="po"> 
                           <div class="text-danger" v-html="formValidate.matricula"></div>
                </div>
            </div> 
            <div class="col-md-6 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <label><font color="red">*</font> Nombre</label>
                    <input type="text" v-model="chooseAlumno.nombre" class="form-control"  :class="{'is-invalid': formValidate.nombre}" name="po"> 
                           <div class="text-danger" v-html="formValidate.nombre"></div>
                </div>
            </div> 
        </div>
        <div class="row">
             
            <div class="col-md-6 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <label><font color="red">*</font> A. Paterno</label>
                    <input type="text" v-model="chooseAlumno.apellidop" class="form-control"  :class="{'is-invalid': formValidate.apellidop}" name="po"> 
                           <div class="text-danger" v-html="formValidate.apellidop"></div>
                </div>
            </div>
              <div class="col-md-6 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <label>A. Materno</label>
                    <input type="text" v-model="chooseAlumno.apellidom" class="form-control"  :class="{'is-invalid': formValidate.apellidom}" name="po"> 
                           <div class="text-danger" v-html="formValidate.apellidom"></div>
                </div>
            </div>  
        </div>
          <div class="row">
              <div class="col-md-6 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <label><font color="red">*</font> Sexo</label> <br>
                     

  <div class="demo-radio-button" >  
                                <input name="group5" type="radio" id="radio_31" class="with-gap radio-col-blue" v-model="chooseAlumno.sexo" value="1" :checked="chooseAlumno.sexo==1"  />
                                <label for="radio_31">HOMBRE</label>
                                <input name="group5" type="radio" id="radio_32" class="with-gap radio-col-pink" v-model="chooseAlumno.sexo" value="0" :checked="chooseAlumno.sexo==0" />
                                <label for="radio_32">MUJER</label>
                            </div>

                            
                    <div class="text-danger" v-html="formValidate.sexo"></div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <label><font color="red">*</font> Correo electronico</label>
                    <input type="text" v-model="chooseAlumno.correo" class="form-control"  :class="{'is-invalid': formValidate.correo}" name="po"> 
                           <div class="text-danger" v-html="formValidate.correo"></div>
                </div>
            </div>  
        </div>
        <div class="row"> 
            <div class="col-md-6 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <label><font color="red">*</font> Fecha nacimiento</label>
                    <input type="date" v-model="chooseAlumno.fechanacimiento" class="form-control"  :class="{'is-invalid': formValidate.fechanacimiento}" name="po"> 
                           <div class="text-danger" v-html="formValidate.fechanacimiento"></div>
                </div>
            </div>
                <div class="col-md-6 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <label><font color="red">*</font> Especialidad</label> 
                      <select v-model="chooseAlumno.idespecialidad"  :class="{'is-invalid': formValidate.idespecialidad}"class="form-control">
                        <option   v-for="option in especialidades" selected="option.idespecialidad == chooseAlumno.idespecialidad ? 'selected' : ''" v-bind:value="option.idespecialidad">
                        {{ option.nombreespecialidad }}   
                      </option>
                    </select>
                     <div class="text-danger" v-html="formValidate.idespecialidad"></div>
                </div>
            </div>  
        </div> 
 
</div>
    </div>
    <div slot="foot">
        <button class="btn btn-danger" @click="clearAll"><i class='fa fa-ban'></i> Cancelar</button>
        <button class="btn btn-primary" @click="updateAlumno"><i class='fa fa-edit'></i> Modificar</button>
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
                    <input type="password" v-model="chooseAlumno.password1" class="form-control"  :class="{'is-invalid': formValidate.password1}" name="po"> 
                           <div class="text-danger" v-html="formValidate.password1"></div>
                </div>
            </div> 
            <div class="col-md-6 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <label><font color="red">*</font> Repita Contraseña</label>
                    <input type="password" v-model="chooseAlumno.password2" class="form-control"  :class="{'is-invalid': formValidate.password2}" name="po"> 
                           <div class="text-danger" v-html="formValidate.password2"></div>
                </div>
            </div> 
        </div>    
 
</div>
    </div>
    <div slot="foot">
        <button class="btn btn-danger" @click="clearAll"><i class='fa fa-ban'></i> Cancelar</button>
        <button class="btn btn-primary" @click="updatePasswordAlumno"><i class='fa fa-edit'></i> Modificar</button>
    </div>
</modal>

