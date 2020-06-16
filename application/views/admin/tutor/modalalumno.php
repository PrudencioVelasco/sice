<!--add modal-->
<modal v-if="addModal" @close="clearAll()">
    <h3 slot="head" >Asignar Alumno</h3>
    <div slot="body"  >
        <div style=" height: 100px; overflow-x: hidden; overflow-y: scroll;">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 ">
                <div class="text-danger" v-html="formValidate.msgerror"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <label><font color="red">*</font> Nombre de alumno</label>
                    <select v-model="newAlumno.idalumno"  :class="{'is-invalid': formValidate.idperiodo}"class="form-control">
                    <option value="" selected>-- SELECCIONAR --</option>    
                    <option   v-for="option in alumnosposibles" v-bind:value="option.idalumno">
                        {{ option.nombre }}  {{ option.apellidop }} {{option.apellidom}}  
                      </option>
                    </select>
                           <div class="text-danger" v-html="formValidate.idalumno"></div>
                </div>
            </div>  
        </div>
    </div>
    </div>
    <div slot="foot"> 
        <button class="btn btn-danger waves-effect waves-black" @click="clearAll"><i class='fa fa-ban'></i>  Cancelar</button>
        <button class="btn btn-primary waves-effect waves-black" @click="addAlumno"><i class='fa fa-floppy-o'></i> Agregar</button>
    </div>
</modal>


