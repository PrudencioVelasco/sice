    <div class="modal fade" id="addRegister" tabindex="-1" role="dialog">
                <div class="modal-dialog " role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="smallModalLabel">AGREGAR MATERIA</h4>
                        </div>
                        <div class="modal-body">
                                 <div style="padding-top:13px; padding-right:15px; height: 200px; overflow-x: hidden; overflow-y: scroll;">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 ">
                <label class="col-red" v-html="formValidate.msgerror"></label>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-12 col-xs-12 ">
                <div class="form-group"> 
                     <select style="border-bottom: solid #ebebeb 2px;" v-model="newMateria.idnivelestudio"  :class="{'is-invalid': formValidate.idnivelestudio}"class="form-control">
                        <option value="">-- NIVEL ESCOLAR --</option>
                        <option   v-for="option in niveles" v-bind:value="option.idnivelestudio">
                        {{ option.nombrenivel }}   
                      </option>
                    </select>
                    <div class="col-red" v-html="formValidate.idnivelestudio"></div>
                </div>
            </div>
              <div class="col-md-6 col-sm-12 col-xs-12 ">
                <div class="form-group"> 
                      <select style="border-bottom: solid #ebebeb 2px;" v-model="newMateria.idespecialidad"  :class="{'is-invalid': formValidate.idespecialidad}"class="form-control">
                        <option value="">-- ESPECIALIDAD --</option>
                        <option   v-for="option in especialidades" v-bind:value="option.idespecialidad">
                        {{ option.nombreespecialidad }}   
                      </option>
                    </select>
                     <div class="col-red" v-html="formValidate.idespecialidad"></div>
                </div>
            </div> 
        </div>
         <div class="row">
            <div class="col-md-6 col-sm-12 col-xs-12 ">
                <div class="form-group form-float">
                      <div class="form-line">
                    <label   class="form-label"><font color="red">*</font> NOMBRE DE LA MATERIA</label>
                    <input type="text" v-model="newMateria.nombreclase" class="form-control"  :class="{'is-invalid': formValidate.nombreclase}" name="po"> 
                      </div>     
                    <div class="col-red" v-html="formValidate.nombreclase"></div>
                </div>
            </div>    
              <div class="col-md-6 col-sm-12 col-xs-12 ">
                <div class="form-group form-float">
                      <div class="form-line">
                    <label   class="form-label"><font color="red">*</font> CLAVE</label> 
                       <input type="text" v-model="newMateria.clave" class="form-control"  :class="{'is-invalid': formValidate.clave}" name="po"> 
                      </div>
                       <div class="col-red" v-html="formValidate.clave"></div>
                </div>
            </div> 
        </div> 
               <div class="row">
            <div class="col-md-6 col-sm-12 col-xs-12 ">
                 <div class="form-group form-float">
                      <div class="form-line">
                    <label   class="form-label"><font color="red">*</font> CREDITO</label>
                    <input type="text" v-model="newMateria.credito" class="form-control"  :class="{'is-invalid': formValidate.credito}" name="po"> 
                      </div>     
                    <div class="col-red" v-html="formValidate.credito"></div>
                </div>
            </div>  
            <div class="col-md-6 col-sm-12 col-xs-12 ">
                <div class="form-group"> 
                      <select  style="border-bottom: solid #ebebeb 2px;" v-model="newMateria.idclasificacionmateria"  :class="{'is-invalid': formValidate.idclasificacionmateria}"class="form-control">
                        <option value="">--CLASIFICACIÓN--</option>
                        <option   v-for="option in clasificacion_materia" v-bind:value="option.idclasificacionmateria">
                        {{ option.nombreclasificacion }}   
                      </option>
                    </select>
                     <div class="col-red" v-html="formValidate.idclasificacionmateria"></div>
                </div>
            </div>   
        </div> 
        

    </div>
                        </div>
                        <div class="modal-footer">
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
                    </div>
                </div>
            </div>


                <div class="modal fade" id="editRegister" tabindex="-1" role="dialog">
                <div class="modal-dialog " role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="smallModalLabel">MODIFICAR MATERIA</h4>
                        </div>
                        <div class="modal-body">
                                   <div style="padding-top:13px; padding-right:15px; height: 200px;overflow-x: hidden; overflow-y: scroll;">
         <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 ">
                <label class="col-red" v-html="formValidate.msgerror"></label>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-12 col-xs-12 ">
                <div class="form-group"> 
                     <select style="border-bottom: solid #ebebeb 2px;" class="form-control" v-model="chooseMateria.idnivelestudio" > 
                     <option v-for="option in niveles"  :selected="option.idnivelestudio == chooseMateria.idnivelestudio ? 'selected' : ''" :value="option.idnivelestudio" >
                     {{ option.nombrenivel }}</small>
                  </option>
             </select>
                     <div class="col-red" v-html="formValidate.idnivelestudio"></div>
                </div>
            </div> 
             <div class="col-md-6 col-sm-12 col-xs-12 ">
                <div class="form-group"> 
                      <select style="border-bottom: solid #ebebeb 2px;" v-model="chooseMateria.idespecialidad"  :class="{'is-invalid': formValidate.idespecialidad}"class="form-control">
                        <option   v-for="option in especialidades" selected="option.idespecialidad == chooseMateria.idespecialidad ? 'selected' : ''" v-bind:value="option.idespecialidad">
                        {{ option.nombreespecialidad }}   
                      </option>
                    </select>
                     <div class="col-red" v-html="formValidate.idespecialidad"></div>
                </div>
            </div>
        </div>
        <div class="row">
          <div class="col-md-6 col-sm-12 col-xs-12 ">
               <div class="form-group form-float">
                   <div class="form-line focused"  > 
                    <label  class="form-label"><font color="red">*</font> NOMBRE MATERIA</label>
                    <input type="text" v-model="chooseMateria.nombreclase" class="form-control"  :class="{'is-invalid': formValidate.nombreclase}" name="po"> 
                   </div>      
                    <div class="col-red" v-html="formValidate.nombreclase"></div>
                </div>
            </div>    
            <div class="col-md-6 col-sm-12 col-xs-12 ">
                <div class="form-group form-float">
                   <div class="form-line focused"  > 
                    <label  class="form-label"><font color="red">*</font> CLAVE</label>
                    <input type="text" v-model="chooseMateria.clave" class="form-control"  :class="{'is-invalid': formValidate.clave}" name="po"> 
                   </div>     
                    <div class="col-red" v-html="formValidate.clave"></div>
                </div>
            </div> 
        </div> 
                <div class="row">
          <div class="col-md-6 col-sm-12 col-xs-12 ">
                <div class="form-group form-float">
                   <div class="form-line focused"  > 
                    <label  class="form-label"><font color="red">*</font> CREDITO</label>
                    <input type="text" v-model="chooseMateria.credito" class="form-control"  :class="{'is-invalid': formValidate.credito}" name="po"> 
                   </div>      
                    <div class="col-red" v-html="formValidate.credito"></div>
                </div>
            </div>   
              <div class="col-md-6 col-sm-12 col-xs-12 ">
                <div class="form-group"> 
                      <select style="border-bottom: solid #ebebeb 2px;" v-model="chooseMateria.idclasificacionmateria"  :class="{'is-invalid': formValidate.idclasificacionmateria}"class="form-control">
                        <option   v-for="option in clasificacion_materia" selected="option.idclasificacionmateria == chooseMateria.idclasificacionmateria ? 'selected' : ''" v-bind:value="option.idclasificacionmateria">
                        {{ option.nombreclasificacion }}   
                      </option>
                    </select>
                     <div class="col-red" v-html="formValidate.idclasificacionmateria"></div>
                </div>
            </div>  
        </div> 


</div>
                        </div>
                        <div class="modal-footer">
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
                    </div>
                </div>
            </div>
 