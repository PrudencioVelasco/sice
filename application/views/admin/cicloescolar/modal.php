<!--add modal-->
<modal v-if="addModal" @close="clearAll()">
    <h3 slot="head" >Agregar Ciclo Escolar</h3>
    <div slot="body"  >
        <div style=" height: 200px; overflow-x: hidden; overflow-y: scroll;">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 ">
                <div class="col-red" v-html="formValidate.msgerror"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <label><font color="red">*</font> Mes inicio</label>
                     
                    <select v-model="newCiclo.idmesinicio"  :class="{'is-invalid': formValidate.idmesinicio}"class="form-control">
                       <option value="" selected>-- SELECCIONAR --</option>
                        <option   v-for="option in meses" v-bind:value="option.idmes">
                        {{ option.nombremes }}   
                      </option>
                    </select>
                    <div class="col-red" v-html="formValidate.idmesinicio"></div>
                           
                </div>
            </div>  
            <div class="col-md-6 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <label><font color="red">*</font> Año inicio</label>
                    <select v-model="newCiclo.idyearinicio"  :class="{'is-invalid': formValidate.idmesinicio}"class="form-control">
                        <option value="" selected>-- SELECCIONAR --</option>
                        <option   v-for="option in years" v-bind:value="option.idyear">
                        {{ option.nombreyear }}   
                      </option>
                    </select>
                           <div class="col-red" v-html="formValidate.idyearinicio"></div>
                           
                </div>
            </div>
        </div>
        <div class="row">
             
            <div class="col-md-6 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <label><font color="red">*</font> Mes termino</label>
                     <select v-model="newCiclo.idmesfin"  :class="{'is-invalid': formValidate.idmesfin}"class="form-control">
                        <option value="" selected>-- SELECCIONAR --</option>
                        <option   v-for="option in meses" v-bind:value="option.idmes">
                        {{ option.nombremes }}   
                      </option>
                    </select>
                           <div class="col-red" v-html="formValidate.idmesfin"></div>
                           
                </div>
            </div> 

              <div class="col-md-6 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <label><font color="red">*</font> Año termino</label>
                    <select v-model="newCiclo.idyearfin"  :class="{'is-invalid': formValidate.idyearfin}"class="form-control">
                       <option value="" selected>-- SELECCIONAR --</option>
                        <option   v-for="option in years" v-bind:value="option.idyear">
                        {{ option.nombreyear }}   
                      </option>
                    </select>
                    <div class="col-red" v-html="formValidate.idyearfin"></div>
                          
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
        <button class="btn btn-primary waves-effect waves-black" @click="addCiclo"><i class='fa fa-floppy-o'></i> Agregar</button>
         </div>
        </div>
    </div>
</modal>
<modal v-if="editModal" @close="clearAll()">
    <h3 slot="head" >Editar Ciclo Escolar</h3>
    <div slot="body">
         <div style=" height: 200px;overflow-x: hidden; overflow-y: scroll;">
         <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 ">
                <div class="col-red" v-html="formValidate.msgerror"></div>
            </div>
        </div>
         <div class="row">
            <div class="col-md-6 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <label><font color="red">*</font> Mes inicio</label>
                     
                    <select v-model="chooseCiclo.idmesinicio"  :class="{'is-invalid': formValidate.idmesinicio}" class="form-control">
                        <option   v-for="option in meses"  :selected="option.idmes == chooseCiclo.idmesinicio ? 'selected' : ''" v-bind:value="option.idmes">
                        {{ option.nombremes }}   
                      </option>
                    </select>
                    <div class="col-red" v-html="formValidate.idmesinicio"></div>
                           
                </div>
            </div>  
            <div class="col-md-6 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <label><font color="red">*</font> Año inicio</label>
                    <select v-model="chooseCiclo.idyearinicio"  :class="{'is-invalid': formValidate.idmesinicio}"class="form-control">
                        <option   v-for="option in years"  :selected="option.idyear == chooseCiclo.idyearinicio ? 'selected' : ''" v-bind:value="option.idyear">
                        {{ option.nombreyear }}   
                      </option>
                    </select>
                           <div class="col-red" v-html="formValidate.idyearinicio"></div>
                           
                </div>
            </div>
        </div>
        <div class="row">
             
            <div class="col-md-6 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <label><font color="red">*</font> Mes termino</label>
                     <select v-model="chooseCiclo.idmesfin"  :class="{'is-invalid': formValidate.idmesfin}"class="form-control">
                        <option   v-for="option in meses"  :selected="option.idmes == chooseCiclo.idmesfin ? 'selected' : ''" v-bind:value="option.idmes">
                        {{ option.nombremes }}   
                      </option>
                    </select>
                           <div class="col-red" v-html="formValidate.idmesfin"></div>
                           
                </div>
            </div> 

              <div class="col-md-6 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <label><font color="red">*</font> Año termino</label>
                    <select v-model="chooseCiclo.idyearfin"  :class="{'is-invalid': formValidate.idyearfin}"class="form-control">
                        <option   v-for="option in years"  :selected="option.idyear == chooseCiclo.idyearfin ? 'selected' : ''" v-bind:value="option.idyear">
                        {{ option.nombreyear }}   
                      </option>
                    </select>
                    <div class="col-red" v-html="formValidate.idyearfin"></div>
                          
                </div>
            </div> 

        </div>  
 

             <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12 ">
                 <div class="form-group">
                <label for="">* Estatus</label><br> 
                   <div class="demo-radio-button" >  
                                <input name="group5" type="radio" id="radio_31" class="with-gap radio-col-green" v-model="chooseCiclo.activo" value="1" :checked="chooseCiclo.activo==1" />
                                <label for="radio_31">EN PROCESO</label>
                                <input name="group5" type="radio" id="radio_32" class="with-gap radio-col-red"  v-model="chooseCiclo.activo" value="0" :checked="chooseCiclo.activo==0" />
                                <label for="radio_32">FINALIZADO</label>
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
               <label class="col-red">*Corrija los errores en el formulario.</label>
           </div>
        </div>
         <div class="col-md-6 col-sm-12 col-xs-12 "  align="right"  >
        <button class="btn btn-danger waves-effect waves-black" @click="clearAll"><i class='fa fa-ban'></i> Cancelar</button>
        <button class="btn btn-primary waves-effect waves-black" @click="updateCiclo"><i class='fa fa-edit'></i> Modificar</button>
         </div>
        </div>
    </div>
</modal>



