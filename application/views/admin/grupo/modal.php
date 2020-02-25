<!--add modal-->
<modal v-if="addModal" @close="clearAll()">
    <h3 slot="head" >Agregar Grupo</h3>
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
                    <label><font color="red">*</font> Nivel Escolar</label>
                     <select v-model="newGrupo.idnivelestudio"  :class="{'is-invalid': formValidate.idnivelestudio}"class="form-control">
                        <option   v-for="option in niveles" v-bind:value="option.idnivelestudio">
                        {{ option.nombrenivel }}   
                      </option>
                    </select>
                    <div class="text-danger" v-html="formValidate.idnivelestudio"></div>
                </div>
            </div>
              <div class="col-md-6 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <label><font color="red">*</font> Especialidad</label> 
                      <select v-model="newGrupo.idespecialidad"  :class="{'is-invalid': formValidate.idespecialidad}"class="form-control">
                        <option value="">--Seleccione--</option>
                        <option   v-for="option in especialidades" v-bind:value="option.idespecialidad">
                        {{ option.nombreespecialidad }}   
                      </option>
                    </select>
                     <div class="text-danger" v-html="formValidate.idespecialidad"></div>
                </div>
            </div> 
        </div>
         <div class="row">
            <div class="col-md-6 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <label><font color="red">*</font> Nombre Grupo</label>
                    <input type="text" v-model="newGrupo.nombregrupo" class="form-control"  :class="{'is-invalid': formValidate.nombregrupo}" name="po"> 
                           <div class="text-danger" v-html="formValidate.nombregrupo"></div>
                </div>
            </div>    
              <div class="col-md-6 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <label><font color="red">*</font> Turno</label>
                     <select v-model="newGrupo.idturno"  :class="{'is-invalid': formValidate.idturno}"class="form-control">
                        <option   v-for="option in turnos" v-bind:value="option.idturno">
                        {{ option.nombreturno }}   
                      </option>
                    </select>
                    <div class="text-danger" v-html="formValidate.idturno"></div>
                </div>
            </div> 
        </div> 
        

    </div>
    </div>
    <div slot="foot"> 
        <button class="btn btn-danger" @click="clearAll"><i class='fa fa-ban'></i> Cancelar</button>
        <button class="btn btn-primary" @click="addGrupo"><i class='fa fa-floppy-o'></i> Agregar</button>
    </div>
</modal>
<modal v-if="editModal" @close="clearAll()">
    <h3 slot="head" >Editar Grupo</h3>
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
                    <label><font color="red">*</font> Ciclo Escolar</label>
                     <select class="form-control" v-model="chooseGrupo.idnivelestudio" >
                  <option v-for="option in niveles"  :selected="option.idnivelestudio == chooseGrupo.idnivelestudio ? 'selected' : ''" :value="option.idnivelestudio" >
                     {{ option.nombrenivel }}</small>
                  </option>
             </select>
                     <div class="text-danger" v-html="formValidate.idnivelestudio"></div>
                </div>
            </div> 
             <div class="col-md-6 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <label><font color="red">*</font> Especialidad</label> 
                      <select v-model="chooseGrupo.idespecialidad"  :class="{'is-invalid': formValidate.idespecialidad}"class="form-control">
                        <option   v-for="option in especialidades" selected="option.idespecialidad == chooseGrupo.idespecialidad ? 'selected' : ''" v-bind:value="option.idespecialidad">
                        {{ option.nombreespecialidad }}   
                      </option>
                    </select>
                     <div class="text-danger" v-html="formValidate.idespecialidad"></div>
                </div>
            </div>
        </div>
        <div class="row">
          <div class="col-md-6 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <label><font color="red">*</font> Nombre Grupo</label>
                    <input type="text" v-model="chooseGrupo.nombregrupo" class="form-control"  :class="{'is-invalid': formValidate.nombregrupo}" name="po"> 
                           <div class="text-danger" v-html="formValidate.nombregrupo"></div>
                </div>
            </div>    
            <div class="col-md-6 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <label><font color="red">*</font> Turno</label>
                     <select class="form-control" v-model="chooseGrupo.idturno" >
                  <option v-for="option in turnos"  :selected="option.idturno == chooseGrupo.idturno ? 'selected' : ''" :value="option.idturno" >
                     {{ option.nombreturno }}
                  </option>
             </select>
                     <div class="text-danger" v-html="formValidate.idturno"></div>
                </div>
            </div> 
        </div> 


</div>
    </div>
    <div slot="foot">
        <button class="btn btn-danger" @click="clearAll"><i class='fa fa-ban'></i> Cancelar</button>
        <button class="btn btn-primary" @click="updateGrupo"><i class='fa fa-edit'></i> Modificar</button>
    </div>
</modal>

