<!--add modal-->
<modal v-if="addModal" @close="clearAll()">
    <h3 slot="head" >Agregar Materia</h3>
    <div slot="body"  >
        <div style=" height: 100px; overflow-x: hidden; overflow-y: scroll;">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 ">
                <label  class="col-red" v-html="formValidate.msgerror"></label>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <label><font color="red">*</font> Materia</label>
                      <select v-model="newMateria.idmateria"  :class="{'is-invalid': formValidate.idmateria}"class="form-control">
                       <option value="">-- SELECCIONAR --</option>
                        <option   v-for="option in clases" v-bind:value="option.idmateria">
                        {{ option.nombreclase }} 
                      </option>
                    </select>

                           <div class="col-red" v-html="formValidate.idmateria"></div>
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
               <label class="col-red">*Corrija los errores en el formulario.</label>
           </div>
        </div>
         <div class="col-md-6 col-sm-12 col-xs-12 "  align="right"  >
        <button class="btn btn-danger waves-effect waves-black" @click="clearAll"><i class='fa fa-ban'></i> Cancelar</button>
        <button class="btn btn-primary waves-effect waves-black" @click="addMateria"><i class='fa fa-floppy-o'></i> Agregar</button>
         </div>
        </div>
    </div>
</modal>
<modal v-if="editModal" @close="clearAll()">
    <h3 slot="head" >Editar Materia</h3>
    <div slot="body">
         <div style=" height: 100px;overflow-x: hidden; overflow-y: scroll;">
         <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 ">
                <label  class="col-red" v-html="formValidate.msgerror"></label>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <label><font color="red">*</font> Materia</label>
                     <select class="form-control" v-model="chooseMateria.idmateria" >
                      <option v-for="option in clases"  :selected="option.idmateria == chooseMateria.idmateria ? 'selected' : ''" :value="option.idmateria" >
                           {{ option.nombreclase }}
                      </option>
                 </select>

                    <div class="col-red" v-html="formValidate.idmateria"></div>
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
               <label class="col-red">*Corrija los errores en el formulario.</label>
           </div>
        </div>
         <div class="col-md-6 col-sm-12 col-xs-12 "  align="right"  >
        <button class="btn btn-danger waves-effect waves-black" @click="clearAll"><i class='fa fa-ban'></i> Cancelar</button>
        <button class="btn btn-primary waves-effect waves-black" @click="updateMateria"><i class='fa fa-edit'></i> Modificar</button>
         </div>
        </div>
    </div>
</modal>

