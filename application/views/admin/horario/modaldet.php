<!--add modal-->
<modal v-if="addModal" @close="clearAll()">
    <h3 slot="head" >Agregar Materia</h3>
    <div slot="body"  >
        <div style=" height: 200px; overflow-x: hidden; overflow-y: scroll;">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 ">
                <div class="text-danger" v-html="formValidate.msgerror"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <label><font color="red">*</font> Materia</label>
                     <select v-model="newHorario.idmateria"  :class="{'is-invalid': formValidate.idmateria}"class="form-control">
                        <option   v-for="option in materias" v-bind:value="option.idprofesormateria">
                        {{ option.nombreclase }} - {{option.nombre}} {{option.apellidop}} {{option.apellidom}}</small>
                      </option>
                    </select>
                     <div class="text-danger" v-html="formValidate.idmateria"></div>
                </div>
            </div>  
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <label><font color="red">*</font> Dia</label>
                    <select v-model="newHorario.iddia"  :class="{'is-invalid': formValidate.iddia}"class="form-control">
                        <option   v-for="option in dias" v-bind:value="option.iddia">
                        {{ option.nombredia }}
                      </option>
                    </select>
                           <div class="text-danger" v-html="formValidate.iddia"></div>
                </div>
            </div>  
        </div>
          <div class="row">
            <div class="col-md-6 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <label><font color="red">*</font> Hora inicial</label>
                    <input type="time" v-model="newHorario.horainicial" class="form-control"  :class="{'is-invalid': formValidate.horainicial}" name="po"> 
                           <div class="text-danger" v-html="formValidate.horainicial"></div>
                </div>
            </div> 
            <div class="col-md-6 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <label><font color="red">*</font> Hora final</label>
                    <input type="time" v-model="newHorario.horafinal" class="form-control"  :class="{'is-invalid': formValidate.horafinal}" name="po"> 
                           <div class="text-danger" v-html="formValidate.horafinal"></div>
                </div>
            </div> 
        </div>  
 
  
    </div>
    </div>
    <div slot="foot"> 
        <button class="btn btn-danger" @click="clearAll"><i class='fa fa-ban'></i> Cancelar</button>
        <button class="btn btn-primary" @click="addHorario"><i class='fa fa-floppy-o'></i> Agregar</button>
    </div>
</modal>
<!--add modal-->
<modal v-if="addModalRecreo" @close="clearAll()">
    <h3 slot="head" >Agregar Receso</h3>
    <div slot="body"  >
        <div style=" height: 200px; overflow-x: hidden; overflow-y: scroll;">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 ">
                <div class="text-danger" v-html="formValidate.msgerror"></div>
            </div>
        </div> 
        <div class="row">
            <div class="col-md-6 col-sm-12 col-xs-12 ">
                 <label>* Aplicara para todos los dias.</label>
            </div>
        </div> 
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <label><font color="red">*</font> Titulo</label>
                    <input type="text" v-model="newHorario.titulo" class="form-control"  :class="{'is-invalid': formValidate.titulo}" name="po"> 
                           <div class="text-danger" v-html="formValidate.titulo"></div>
                </div>
            </div>  
        </div>
          <div class="row">
            <div class="col-md-6 col-sm-12 col-xs-12 ">
               
                <div class="form-group"> 
                    <label><font color="red">*</font> Hora inicial</label>
                    <input type="time" v-model="newHorario.horainicial" class="form-control"  :class="{'is-invalid': formValidate.horainicial}" name="po"> 
                           <div class="text-danger" v-html="formValidate.horainicial"></div>
                </div>
            </div> 
            <div class="col-md-6 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <label><font color="red">*</font> Hora final</label>
                    <input type="time" v-model="newHorario.horafinal" class="form-control"  :class="{'is-invalid': formValidate.horafinal}" name="po"> 
                           <div class="text-danger" v-html="formValidate.horafinal"></div>
                </div>
            </div> 
        </div>  
 
  
    </div>
    </div>
    <div slot="foot"> 
        <button class="btn btn-danger" @click="clearAll"><i class='fa fa-ban'></i> Cancelar</button>
        <button class="btn btn-primary" @click="addReceso"><i class='fa fa-floppy-o'></i> Agregar</button>
    </div>
</modal>
<modal v-if="editModal" @close="clearAll()">
    <h3 slot="head" >Editar Materia</h3>
    <div slot="body">
         <div style=" height: 200px;overflow-x: hidden; overflow-y: scroll;">
         <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 ">
                <div class="text-danger" v-html="formValidate.msgerror"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <label><font color="red">*</font> Materia</label>
                     <select class="form-control" v-model="chooseHorario.idprofesormateria" >
                  <option v-for="option in materias" :selected="option.idprofesormateria == chooseHorario.idprofesormateria ? 'selected' : ''"  :value="option.idprofesormateria">
                    {{ option.nombreclase }} - {{option.nombre}} {{option.apellidop}} {{option.apellidom}}</small>
                  </option>
             </select> 



                     <div class="text-danger" v-html="formValidate.idmateria"></div>
                </div>
            </div>  
        </div> 

    <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <label><font color="red">*</font> Dia</label>
                   <select class="form-control" v-model="chooseHorario.iddia" >
                  <option v-for="option in dias"  :selected="option.iddia == chooseHorario.iddia ? 'selected' : ''" :value="option.iddia" >
                       {{ option.nombredia }}
                  </option>
             </select>
                     <div class="text-danger" v-html="formValidate.iddia"></div>
                </div>
            </div>  
        </div>

   <div class="row">
            <div class="col-md-6 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <label><font color="red">*</font> Hora inicial</label>
                    <input type="text" class="form-control" :class="{'is-invalid': formValidate.horainicial}" name="usuario" v-model="chooseHorario.horainicial"  >
                    <div class="text-danger" v-html="formValidate.horainicial"></div>
                </div>
            </div> 
            <div class="col-md-6 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <label><font color="red">*</font> Hora final</label>
                <input type="text" class="form-control" :class="{'is-invalid': formValidate.horafinal}" name="usuario" v-model="chooseHorario.horafinal" >
                    <div class="text-danger" v-html="formValidate.horafinal"></div>
                </div>
            </div> 
        </div>  

 
</div>
    </div>
    <div slot="foot">
        <button class="btn btn-danger" @click="clearAll"><i class='fa fa-ban'></i> Cancelar</button>
        <button class="btn btn-primary" @click="updateHorario"><i class='fa fa-edit'></i> Modificar</button>
    </div>
</modal>

<modal v-if="editModalRecreo" @close="clearAll()">
    <h3 slot="head" >Editar Receso</h3>
    <div slot="body">
         <div style=" height: 200px;overflow-x: hidden; overflow-y: scroll;">
         <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 ">
                <div class="text-danger" v-html="formValidate.msgerror"></div>
            </div>
        </div>
         <div class="row">
            <div class="col-md-6 col-sm-12 col-xs-12 ">
                 <label>* Aplicara para todos los dias.</label>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 ">
               <div class="form-group">
                <label><font color="red">*</font> Titulo</label>
                <input type="text" class="form-control" :class="{'is-invalid': formValidate.nombreclase}" name="name" v-model="chooseHorario.nombreclase">
                <div class="text-danger" v-html="formValidate.nombreclase"> </div>
             </div> 
            </div> 
        </div>  

        <div class="row">
            <div class="col-md-6 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <label><font color="red">*</font> Hora inicial</label>
                    <input type="text" class="form-control" :class="{'is-invalid': formValidate.horainicial}" name="usuario" v-model="chooseHorario.horainicial"  >
                    <div class="text-danger" v-html="formValidate.horainicial"></div>
                </div>
            </div> 
            <div class="col-md-6 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <label><font color="red">*</font> Hora final</label>
                <input type="text" class="form-control" :class="{'is-invalid': formValidate.horafinal}" name="usuario" v-model="chooseHorario.horafinal" >
                    <div class="text-danger" v-html="formValidate.horafinal"></div>
                </div>
            </div> 
        </div>  

 
        </div>
    </div>
    <div slot="foot">
        <button class="btn btn-danger" @click="clearAll"><i class='fa fa-ban'></i> Cancelar</button>
        <button class="btn btn-primary" @click="updateReceso"><i class='fa fa-edit'></i> Modificar</button>
    </div>
</modal>

