<!--add modal-->
<modal v-if="addModal" @close="clearAll()">
    <h3 slot="head" >Agregar Horario</h3>
    <div slot="body"  >
        <div style=" height: 200px; overflow-x: hidden; overflow-y: scroll;">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 ">
                <label style="color: red" v-html="formValidate.msgerror"></label>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <label><font color="red">*</font> Ciclo Escolar</label>
                     <select v-model="newHorario.idperiodo"  :class="{'is-invalid': formValidate.idperiodo}"class="form-control">
                        <option   v-for="option in periodos" v-bind:value="option.idperiodo">
                        {{ option.mesinicio }}  {{ option.yearinicio }} - {{option.mesfin}}  {{ option.yearfin }}
                      </option>
                    </select>
                    <div class="text-danger" v-html="formValidate.idperiodo"></div>
                </div>
            </div> 
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <label><font color="red">*</font> Grupo</label>
                   <select v-model="newHorario.idgrupo"  :class="{'is-invalid': formValidate.idgrupo}"class="form-control">
                        <option   v-for="option in grupos" v-bind:value="option.idgrupo">
                        {{ option.nombrenivel }} - {{ option.nombregrupo }}  - {{ option.nombreturno }} - {{ option.nombreespecialidad }}
                      </option>
                    </select>
                           <div class="text-danger" v-html="formValidate.idgrupo"></div>
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
<modal v-if="editModal" @close="clearAll()">
    <h3 slot="head" >Editar Horario</h3>
    <div slot="body">
         <div style=" height: 200px;overflow-x: hidden; overflow-y: scroll;">
         <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 ">
                <label style="color: red" v-html="formValidate.msgerror"></label>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <label><font color="red">*</font> Ciclo Escolar</label>
                     <select class="form-control" v-model="chooseHorario.idperiodo" >
                  <option v-for="option in periodos"  :selected="option.idperiodo == chooseHorario.idperiodo ? 'selected' : ''" :value="option.idperiodo" >
                     {{ option.mesinicio }}  {{ option.yearinicio }} - {{option.mesfin}}  {{ option.yearfin }}</small>
                  </option>
             </select>
                     <div class="text-danger" v-html="formValidate.idperiodo"></div>
                </div>
            </div> 
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <label><font color="red">*</font> Grupo</label>
                     <select class="form-control" v-model="chooseHorario.idgrupo" >
                  <option v-for="option in grupos"  :selected="option.idgrupo == chooseHorario.idgrupo ? 'selected' : ''" :value="option.idgrupo" >
                     {{ option.nombrenivel }} - {{ option.nombregrupo }} - {{ option.nombreturno }} - {{ option.nombreespecialidad }}
                  </option>
             </select>
                     <div class="text-danger" v-html="formValidate.idgrupo"></div>
                </div>
            </div> 
        </div>
 
     <div class="row">
                <div class="col-md-6 col-sm-12 col-xs-12 ">
                 <div class="form-group">
                <label for="">* Estatus</label><br> 
                   <div class="demo-radio-button" >  
                                <input name="group5" type="radio" id="radio_31" class="with-gap radio-col-green" v-model="chooseHorario.activo" value="1" :checked="chooseHorario.activo==1" />
                                <label for="radio_31">EN PROCESO</label>
                                <input name="group5" type="radio" id="radio_32" class="with-gap radio-col-red"  v-model="chooseHorario.activo" value="0" :checked="chooseHorario.activo==0" />
                                <label for="radio_32">FINALIZADO</label>
                            </div>

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

