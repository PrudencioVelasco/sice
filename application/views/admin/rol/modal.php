    <div class="modal fade" id="addRegister" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="smallModalLabel">AGREGAR ROL</h4>
                        </div>
                        <div class="modal-body">
                          <div class="row">
                               <div class="col-md-12">
                                  <div class="form-group form-float">
                       <div class="form-line"  >
                    <label  class="form-label"><font color="red">*</font> NOMBRE DEL ROL</label>
                                    <input type="text" class="form-control" :class="{'is-invalid': formValidate.rol}" name="rol" v-model="newRol.rol" autcomplete="off">
                       </div>
                                    <div class="col-red" v-html="formValidate.rol"> </div>
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
                                 <button class="btn btn-danger" @click="clearAll"><i class='fa fa-ban'></i> Cancelar</button>
                                 <button class="btn btn-primary" @click="addRol"><i class='fa fa-floppy-o'></i> Agregar</button>
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
                            <h4 class="modal-title" id="smallModalLabel">EDITAR ROL</h4>
                        </div>
                        <div class="modal-body">
                          <div class="row">
                                 <div class="col-md-12">
                                      <div class="form-group form-float">
                   <div class="form-line focused"  > 
                    <label  class="form-label"><font color="red">*</font> NOMBRE DEL ROL</label>
                                       <input type="text" class="form-control" :class="{'is-invalid': formValidate.rol}" name="rol" v-model="chooseRol.rol">
                   </div>
                                       <div class="col-red" v-html="formValidate.rol"> </div>
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
                           <button class="btn btn-primary waves-effect waves-black" @click="updateRol"><i class='fa fa-edit'></i> Modificar</button>
                              </div>
                           </div>
                        </div>
                    </div>
                </div>
            </div>
 