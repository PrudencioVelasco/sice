<!--add modal-->
<modal v-if="addModal" @close="clearAll()">
    <h3 slot="head" >Nueva colegiatura</h3>
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
                    <label><font color="red">*</font> Nivel Escolar</label>
                     <select v-model="newColegiatura.idnivel"  :class="{'is-invalid': formValidate.idnivel}"class="form-control">
                     <option value="">--SELECCIONE--</option>   
                     <option   v-for="option in niveles" v-bind:value="option.idnivelestudio">
                        {{ option.nombrenivel }}
                      </option>
                    </select>
                    <div class="text-danger" v-html="formValidate.idnivel"></div>
                </div>
            </div>   
            <div class="col-md-6 col-sm-12 col-xs-12 ">
                  <div class="form-group">
                    <label><font color="red">*</font> Concepto</label>
                     <select v-model="newColegiatura.idconcepto"  :class="{'is-invalid': formValidate.idnivel}"class="form-control">
                     <option value="">--SELECCIONE--</option>  
                     <option   v-for="option in conceptos" v-bind:value="option.idtipopagocol">
                        {{ option.concepto  }}
                      </option>
                    </select>
                    <div class="text-danger" v-html="formValidate.idconcepto"></div>
                </div>
            </div>  
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <label><font color="red">*</font> Colegiatura</label>
                    <input type="text" v-model="newColegiatura.descuento" class="form-control"  :class="{'is-invalid': formValidate.descuento}" name="po"> 
                           <div class="text-danger" v-html="formValidate.descuento"></div>
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
        <button class="btn btn-primary waves-effect waves-black" @click="addColegiatura"><i class='fa fa-floppy-o'></i> Agregar</button>
         </div>
         </div>
    </div>
</modal>
<modal v-if="editModal" @close="clearAll()">
    <h3 slot="head" >Editar Colegiatura</h3>
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
                    <label><font color="red">*</font> Nivel Escolar</label>
                     <select class="form-control" v-model="chooseColegiatura.idnivelestudio" >
                        <option v-for="option in niveles"  :selected="option.idnivelestudio == chooseColegiatura.idperiodo ? 'selected' : ''" :value="option.idnivelestudio" >
                            {{ option.nombrenivel }} 
                        </option>
                    </select>
                    <div class="text-danger" v-html="formValidate.idnivel"></div>
                </div>
            </div>  
            <div class="col-md-6 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <label><font color="red">*</font> Concepto</label>
                    <select class="form-control" v-model="chooseColegiatura.idtipopagocol" >
                        <option v-for="option in conceptos"  :selected="option.idtipopagocol == chooseColegiatura.idtipopagocol ? 'selected' : ''" :value="option.idtipopagocol" >
                            {{ option.concepto }} 
                        </option>
                    </select>
                    <div class="text-danger" v-html="formValidate.idconcepto"></div>
                </div>
            </div>
        </div>
           <div class="row">
              <div class="col-md-6 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <label><font color="red">*</font> Colegiatura</label>
                    <input type="text" class="form-control" :class="{'is-invalid': formValidate.descuento}" name="usuario" v-model="chooseColegiatura.descuento"  >
                    <div class="text-danger" v-html="formValidate.descuento"></div>
                </div>
            </div>
                <div class="col-md-6 col-sm-12 col-xs-12 ">
                 <div class="form-group">
                <label for="">* Estatus</label><br> 
                   <div class="demo-radio-button" >  
                                <input name="group5" type="radio" id="radio_31" class="with-gap radio-col-green" v-model="chooseColegiatura.activo" value="1" :checked="chooseColegiatura.activo==1" />
                                <label for="radio_31">ACTIVO</label>
                                <input name="group5" type="radio" id="radio_32" class="with-gap radio-col-red"  v-model="chooseColegiatura.activo" value="0" :checked="chooseColegiatura.activo==0" />
                                <label for="radio_32">INACTIVO</label>
                            </div>

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
        <button class="btn btn-primary waves-effect waves-black" @click="updateColegiatura"><i class='fa fa-edit'></i> Modificar</button>
         </div>
         </div>
    </div>
</modal>

