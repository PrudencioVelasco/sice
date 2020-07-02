 

 <div class="modal fade" id="addCobroPrincipal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="defaultModalLabel">PAGO DE REINSCRIPCIÓN O INSCRIPCIÓN</h4>
                        </div>
                        <div class="modal-body">
                                <div style=" height: 300px; padding-top:13px; padding-right:15px;  overflow-x: hidden; overflow-y: scroll;">
      <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 ">
                <label style="color: red" v-html="formValidate.msgerror"></label>
            </div>
        </div>
        <div class="row"> 
          <div class="col-md-6 col-sm-12 col-xs-12 "> 
          <div class="form-group"> 
          <select style="border-bottom: solid #ebebeb 2px; margin-top:15px;"  v-model="newCobroInicio.idtipopagocol"  :class="{'is-invalid': formValidate.idtipopagocol}" class="form-control">
                   <option value="">-- SELECCIONAR CONCEPTO DE PAGO--</option>
                   <option   v-for="option in tipospago" v-bind:value="option.idtipopagocol">
                        {{ option.concepto }} 
                  </option>
         </select>
           <div class="col-red" v-html="formValidate.idtipopagocol"></div>
         </div>
        </div>
           <div class="col-md-6 col-sm-6 col-xs-12 " v-if="mostrar_condonar" align="center">
             <div class="form-group">
                      <label ><font color="red">*</font>  CONDONAR</label>
                     <div class="demo-switch">
                                <div class="switch">
                                    <label>NO<input type="checkbox" v-model="checkbox_condonar" > <span class="lever"></span>SI</label>
                                </div>
                               
                            </div>
                        
                    </div>
               
               </div>
      </div>
<hr>
              <div class="row" v-if="mostar_error_formapago">
                 <div class="col-md-12 col-sm-12 col-xs-12 ">
                         <label class="col-red">{{error_formapago}}</label>
                 </div>
         </div>
         <div class="row clearfix ">
            <div class="col-md-4 col-sm-4 col-xs-12 ">
                
               <div class="form-group"> 
                  <select style="border-bottom: solid #ebebeb 2px;" v-model="array_formapago"  :class="{'is-invalid': formValidate.idperiodo}" class="form-control">
                     <option value="">-- FORMA DE PAGO --</option>
                     <option   v-for="option in formaspago" v-bind:value="option.idformapago">
                        {{ option.nombretipopago }} 
                     </option>
                  </select>
                  <div class="col-red" v-html="formValidate.idformapago"></div>
               </div>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12 ">
                <div class="form-group form-float">
                       <div class="form-line"  >
                    <label  class="form-label"><font color="red">*</font> TOTAL A PAGAR</label>
                  <input type="text" v-model="array_descuento" class="form-control"  :class="{'is-invalid': formValidate.descuento}" name="po" > 
                       </div> 
                  <div class="col-red" v-html="formValidate.descuento"></div>
               </div>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12 ">
                <div class="form-group form-float">
                       <div class="form-line"  >
                    <label  class="form-label">NÚMERO DE AUTORIZACIÓN</label>
                  <input type="text" v-model="array_autorizacion" class="form-control"  :class="{'is-invalid': formValidate.autorizacion}" name="po"> 
                       </div>
                  <div class="col-red" v-html="formValidate.autorizacion"></div>
               </div>
            </div>
              <div class="col-md-2 col-sm-2 col-xs-12 ">
               <div class="form-group">
                   <button @click="agregar_forma_pago_colegiatura()" style="margin-top: 25px;"  class="btn btn-info"> <i class="fa fa-plus" aria-hidden="true"></i> Agregar</button>
               </div>
              </div>
         </div>
         <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 ">
                <table class="table">
                     <caption align="center" > <center><strong>Detalle de Forma de Pago</strong></center></caption>
                    <thead>
                        <th>Forma de Pago</th>
                        <th>Descuento</th>
                        <th>Número de Autorización</th>
                        <th></th>
                    </thead>
                    <tbody>
                        <tr v-for="(row, index) in array_pago_colegiatura">
                            <td>
                                <label  v-if="row.idformapago === '1'" class="text-success" for="">EFECTIVO</label>
                                <label v-else-if="row.idformapago === '2'" class="text-info" for="">TARJETA</label>
                                <label v-else for="" class=" text-dark">NO DEFINIDO</label>
                            </td>
                            <td >{{ row.descuento | currency }}</td>
                            <td >{{row.autorizacion}}</td>
                            <td><button  @click="deleteItem(index)" class="btn btn-danger">Quitar</button></td>
                        </tr>
                    </tbody>
                </table>
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
               <div v-if="error_pago"  align="left">
               <label class="col-red">*Agregar detalle de Forma de Pago.</label>
            </div>
        </div>
         <div class="col-md-6 col-sm-12 col-xs-12 "  align="right"  >
    <button type="button" class="btn btn-danger waves-effect waves-black"  @click="clearAll"> <i class="fa fa-times"></i> Cancelar</button>
      <button class="btn btn-primary waves-effect waves-black" @click="addCobroInicio" ><i class="fa fa-check-circle"></i> Cobrar</button>
   </div>
      </div>
                        </div>
                    </div>
                </div>
            </div> 
 
               <div class="modal fade" id="addCobroColegiatura" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="largeModalLabel">COBRO DE COLEGIATURA</h4>
                        </div>
                        <div class="modal-body">
                         <div style=" height: 300px; padding-top:13px; padding-right:15px;  overflow-x: hidden; overflow-y: scroll;">
         <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 ">
               <label style="color: red" v-html="formValidate.msgerror"></label>
            </div>
         </div>
         <div class="row"> 
            <div class="col-md-6 col-sm-6 col-xs-12 ">
               <div class="form-group">
                  <label><font color="red">*</font> MES A PAGAR</label> 
                  <p>
                               <div v-for="(option,index) in meses" style="display: inline-block;" v-bind:key="option.idmes"> 
                                  
                                <input type="checkbox" v-model="newCobroColegiatura.coleccionMeses" class="filled-in" :id="'basic_checkbox_'+option.idmes" :value="option.idmes" />
                              
                                   <label style="padding-right:15px;"  :for="'basic_checkbox_'+option.idmes">   {{option.nombremes}}    </label>
</div></p>
                     
                  <div class="col-red" v-html="formValidate.idmes"></div>
               </div>
            </div>
               <div class="col-md-6 col-sm-6 col-xs-12 " v-if="mostrar_condonar" align="center">
             <div class="form-group">
                      <label ><font color="red">*</font>  CONDONAR</label>
                     <div class="demo-switch">
                                <div class="switch">
                                    <label>NO<input type="checkbox" v-model="checkbox_condonar" > <span class="lever"></span>SI</label>
                                </div>
                               
                            </div>
                        
                    </div>
               
               </div>
            
         </div>  
         <div class="row" v-if="mostar_error_formapago">
                 <div class="col-md-12 col-sm-12 col-xs-12 ">
                         <label class="col-red">{{error_formapago}}</label>
                 </div>
         </div>
         <div class="row clearfix">
            <div class="col-md-4 col-sm-4 col-xs-12 ">
                
               <div class="form-group"> 
                  <select style="border-bottom: solid #ebebeb 2px;" v-model="array_formapago"  :class="{'is-invalid': formValidate.idperiodo}" class="form-control">
                     <option value="">-- FORMA DE PAGO --</option>
                     <option   v-for="option in formaspago" v-bind:value="option.idformapago">
                        {{ option.nombretipopago }} 
                     </option>
                  </select>
                  <div class="col-red" v-html="formValidate.idformapago"></div>
               </div>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12 ">
                 <div class="form-group form-float">
                       <div class="form-line"  >
                    <label  class="form-label"><font color="red">*</font> TOTAL A PAGAR</label>
                  <input type="text" v-model="array_descuento" class="form-control"  :class="{'is-invalid': formValidate.descuento}" name="po" > 
                       </div>
                  <small>Ejemplo: 300.00, 500.50, etc.</small>
                  <div class="col-red" v-html="formValidate.descuento"></div>
               </div>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12 ">
                 <div class="form-group form-float">
                       <div class="form-line"  >
                    <label  class="form-label">NÚMERO DE AUTORIZACIÓN</label>
                  <input type="text" v-model="array_autorizacion" class="form-control"  :class="{'is-invalid': formValidate.autorizacion}" name="po"> 
                       </div>
                  <div class="col-red" v-html="formValidate.autorizacion"></div>
               </div>
            </div>
              <div class="col-md-2 col-sm-2 col-xs-12 ">
               <div class="form-group">
                   <button @click="agregar_forma_pago_colegiatura()" style="margin-top: 0;"  class="btn btn-info"> <i class="fa fa-plus" aria-hidden="true"></i> Agregar</button>
               </div>
              </div>
         </div>
         <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 ">
                <table class="table">
                     <caption align="center" > <center><strong>Detalle de Forma de Pago</strong></center></caption>
                    <thead>
                        <th>Forma de Pago</th>
                        <th>Descuento</th>
                        <th>Número de Autorización</th>
                        <th></th>
                    </thead>
                    <tbody>
                        <tr v-for="(row, index) in array_pago_colegiatura">
                            <td>
                                <label  v-if="row.idformapago === '1'" class="text-success" for="">EFECTIVO</label>
                                <label v-else-if="row.idformapago === '2'" class="text-info" for="">TARJETA</label>
                                <label v-else for="" class=" text-dark">NO DEFINIDO</label>
                            </td>
                            <td >{{ row.descuento | currency }}</td>
                            <td >{{row.autorizacion}}</td>
                            <td><button  @click="deleteItem(index)" class="btn btn-danger">Quitar</button></td>
                        </tr>
                    </tbody>
                </table>
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
            <div v-if="error_pago"  align="left">
               <label class="col-red">*Agregar detalle de Forma de Pago.</label>
            </div>
         </div>
         <div class="col-md-6 col-sm-12 col-xs-12 "  align="right"  >
            <button type="button" class="btn btn-danger waves-effect waves-black"  @click="clearAll"> <i class="fa fa-times"></i> Cancelar</button>
            <button class="btn btn-primary waves-effect waves-black" @click="addCobroColegiatura" ><i class="fa fa-check-circle"></i> Cobrar</button>
         </div>
      </div>
                        </div>
                    </div>
                </div>
            </div>

 
             <div class="modal fade" id="eliminarPrincipal" tabindex="-1" role="dialog">
                <div class="modal-dialog " role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="smallModalLabel">ELIMINAR COBRO</h4>
                        </div>
                        <div class="modal-body">
                           <div style=" height: 100px;   padding-right:15px;  overflow-x: hidden; overflow-y: scroll;">
                                 <div class="row">
                                    <div class="col-md-6 col-sm-12 col-xs-12 ">
                                       <label class="col-red" v-html="formValidate.msgerror"></label>
                                    </div>
                              </div>
                              <br>
                              <div class="row clearfix">
                                    <div class="col-md-6 col-sm-12 col-xs-12 ">
                                         <div class="form-group form-float">
                       <div class="form-line"  >
                    <label  class="form-label"><font color="red">*</font> USUARIO</label>
                                          <input type="password" v-model="eliminarPrimerCobro.usuario" class="form-control"  :class="{'is-invalid': formValidate.usuario}" name="po"> 
                       </div>        
                                          <div class="col-red" v-html="formValidate.usuario"></div>
                                       </div>
                                    </div> 
                             
                                    <div class="col-md-6 col-sm-12 col-xs-12 ">
                                      <div class="form-group form-float">
                       <div class="form-line"  >
                    <label  class="form-label"><font color="red">*</font> CONTRASEÑA</label>
                                          <input type="password" v-model="eliminarPrimerCobro.password" class="form-control"  :class="{'is-invalid': formValidate.password}" name="po"> 
                       </div>       
                                          <div class="col-red" v-html="formValidate.password"></div>
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
                              <button class="btn btn-primary waves-effect waves-black" @click="eliminarPagoInicio"><i class='fa fa-edit'></i> Eliminar</button>
                           </div>
                              </div>
                        </div>
                    </div>
                </div>
            </div>

  <div class="modal fade" id="eliminarColegiatura" tabindex="-1" role="dialog">
                <div class="modal-dialog  " role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="smallModalLabel">ELIMINAR COBRO</h4>
                        </div>
                        <div class="modal-body">
                             <div style=" height: 100px;  padding-right:15px;  overflow-x: hidden; overflow-y: scroll;">
                                 <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12 ">
                                       <label class="col-red" v-html="formValidate.msgerror"></label>
                                    </div>
                              </div><br>
                              <div class="row clearfix" >
                                    <div class="col-md-6 col-sm-12 col-xs-12 ">
                                       <div class="form-group form-float">
                       <div class="form-line"  >
                    <label  class="form-label"><font color="red">*</font> USUARIO</label>
                                          <input type="password" v-model="eliminarColegiatura.usuario" class="form-control"  :class="{'is-invalid': formValidate.usuario}" name="po"> 
                       </div>       
                                          <div class="col-red" v-html="formValidate.usuario"></div>
                                       </div>
                                    </div> 
                                    <div class="col-md-6 col-sm-12 col-xs-12 ">
                                        <div class="form-group form-float">
                       <div class="form-line"  >
                    <label  class="form-label"><font color="red">*</font> CONTRASEÑA</label>
                                          <input type="password" v-model="eliminarColegiatura.password" class="form-control"  :class="{'is-invalid': formValidate.password}" name="po"> 
                       </div>        
                                          <div class="col-red" v-html="formValidate.password"></div>
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
        <button class="btn btn-primary waves-effect waves-black" @click="eliminarPagoColegiatura"><i class='fa fa-edit'></i> Eliminar</button>
    </div>
       </div>
                        </div>
                    </div>
                </div>
            </div>

 