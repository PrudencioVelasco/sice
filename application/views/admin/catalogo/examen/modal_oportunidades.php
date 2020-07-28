<div class="modal fade" id="addRegisterO" tabindex="-1" role="dialog">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="smallModalLabel">AGREGAR OPORTUNIDAD</h4>
            </div>
            <div class="modal-body">
                <div style=" height: 100px; padding-top:13px; padding-right:15px; overflow-x: hidden; overflow-y: scroll;">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <label class="col-red" v-html="formValidate.msgerror"></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float">
                                <div class="form-line"  >
                                    <label  class="form-label"><font color="red">*</font> NOMBRE DE LA OPORTUNIDAD</label>
                                    <input type="text" v-model="newOportunidad.nombreoportunidad" class="form-control"  :class="{'is-invalid': formValidate.nombreoportunidad }" name="po"> 
                                </div>      
                                <div class="col-red" v-html="formValidate.nombreoportunidad"></div>
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
                        <button class="btn btn-primary waves-effect waves-black" @click="addOportunidad"><i class='fa fa-floppy-o'></i> Agregar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="editRegisterO" tabindex="-1" role="dialog">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="smallModalLabel">EDITAR OPORTUNIDAD</h4>
            </div>
            <div class="modal-body">
                <div style="padding-top:13px; padding-right:15px; height: 100px;overflow-x: hidden; overflow-y: scroll;">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <label  class="col-red" v-html="formValidate.msgerror"></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float">
                                <div class="form-line focused"  > 
                                    <label  class="form-label"><font color="red">*</font> NOMBRE DE LA OPORTUNIDAD</label>
                                    <input type="text" v-model="chooseOportunidad.nombreoportunidad" class="form-control"  :class="{'is-invalid': formValidate.nombreoportunidad}" name="po"> 
                                </div>      
                                <div class="col-red" v-html="formValidate.nombreoportunidad"></div>
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
                        <button class="btn btn-primary waves-effect waves-black" @click="updateOportunidad"><i class='fa fa-edit'></i> Modificar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

