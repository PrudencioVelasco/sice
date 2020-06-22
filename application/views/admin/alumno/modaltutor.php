<!--add modal-->
<modal v-if="addModal" @close="clearAll()">
    <h3 slot="head" >Asignar Tutor</h3>
    <div slot="body"  >
        <div style=" height: 100px; overflow-x: hidden; overflow-y: scroll;">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 ">
                <div class="col-red" v-html="formValidate.msgerror"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 ">
                
                <div class="form-group">
                    <label><font color="red">*</font> Tutor</label>
                   
                  <select v-model="newTutor.idtutor"   :class="{'is-invalid': formValidate.idtutor}" class="form-control select2_single">
                    <option value="" selected>-- SELECCIONAR --</option>
                        <option   v-for="option in tutoresdisponibles" v-bind:value="option.idtutor">
                        {{ option.nombre }}  {{ option.apellidop }} {{option.apellidom}}  
                      </option>
                    </select>
                    <div class="col-red" v-html="formValidate.idtutor"></div>
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
            <button class="btn btn-primary waves-effect waves-black" @click="addTutor"><i class='fa fa-floppy-o'></i> Agregar</button>
         </div>
    </div>
    </div>
</modal>
 

