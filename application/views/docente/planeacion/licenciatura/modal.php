<div class="modal fade" id="addRegister" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #f2f2f2;">
                <h4 class="modal-title" id="smallModalLabel">AGREGAR PLANEACIÓN</h4>
            </div>
            <div class="modal-body">
                <div style="  padding-top:13px; padding-right:15px;">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <label class="col-red" v-html="formValidate.msgerror"></label>
                        </div>
                    </div>  
                    <div class="row">
                        <div class="col-md-12 col-sm-6 col-xs-12 ">
                            <div class="form-group"> 
                                <select style="border-bottom: solid #ebebeb 2px;" v-model="newPlanificacion.idprofesor"  :class="{'is-invalid': formValidate.idprofesor}" class="form-control">
                                    <option value="" selected>-- MATERIA --</option>  
                                    <option   v-for="option in grupos" v-bind:value="option.idhorariodetalle">
                                        {{ option.nombreclase }}   ( {{ option.nombrenivel }} -  {{ option.nombregrupo }} )   
                                    </option>
                                </select>
                                <div class="col-red" v-html="formValidate.idprofesor"></div>
                            </div>
                        </div> 
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group"> 
                                <label > <font color="red" >*</font> Fecha inicio</label> 
                                <input style="border-bottom: solid #ccc 1px;" type="date" v-model="newPlanificacion.fechainicio" class="form-control" />
                                <div class="col-red" v-html="formValidate.fechainicio"></div>
                            </div>
                        </div>  
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group"> 
                                <label > <font color="red" >*</font> Fecha termino</label> 
                                <input style="border-bottom: solid #ccc 1px;"  type="date" v-model="newPlanificacion.fechafin" class="form-control" />
                                <div class="col-red" v-html="formValidate.fechafin"></div>
                            </div>
                        </div> 
                    </div>   
                    <div class="row">
                          <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <div class="form-group"> 
                                <label > <font color="red" >*</font> Documento</label> 
                                <input style="border-bottom: solid #ccc 1px;"  type="file" id="filesubir" ref="filesubir"  v-on:change="onChangeFileUpload()" class="form-control" />
                                <div class="col-red" v-html="formValidate.fechafin"></div>
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
                        <button class="btn btn-primary waves-effect waves-black" @click="addPlanificacion"><i class='fa fa-floppy-o'></i> Agregar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="editRegister" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="smallModalLabel">EDITAR PLANEACIÓN</h4>
            </div>
            <div class="modal-body">
                <div style="padding-top:13px; padding-right:15px;">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <label class="col-red" v-html="formValidate.msgerror"></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <div class="form-group"> 
                                <select style="border-bottom: solid #ebebeb 2px;" v-model="choosePlanificacion.idhorariodetalle"    :class="{'is-invalid': formValidate.idhorariodetalle}"class="form-control">
                                    <option value="" selected>-- MATERIA --</option>  
                                    <option   v-for="option in grupos" :selected="option.idhorariodetalle == choosePlanificacion.idhorariodetalle ? 'selected' : ''" v-bind:value="option.idhorariodetalle">
                                        {{ option.nombreclase }}   ( {{ option.nombrenivel }} -  {{ option.nombregrupo }} )   
                                    </option>
                                </select>
                                <div class="col-red" v-html="formValidate.idhorariodetalle"></div>
                            </div>
                        </div>  
                    </div> 
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group  form-float">
                                <div class="form-line focused">
                                    <label class="form-label"> <font color="red" >*</font> Fecha inicio</label>
                                    <input type="date"  v-model="choosePlanificacion.fechainicios" class="form-control" :class="{'is-invalid': formValidate.fechainicio}" name="message">
                                </div>
                                <div class="col-red" v-html="formValidate.fechainicio"></div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group  form-float">
                                <div class="form-line focused">
                                    <label class="form-label"> <font color="red" >*</font> Fecha termino</label>
                                     <input type="date"  v-model="choosePlanificacion.fechafins"  class="form-control" :class="{'is-invalid': formValidate.fechafin}" name="message"> 
                                </div>
                                <div class="col-red" v-html="formValidate.fechafin"></div>
                            </div>
                        </div> 
                    </div> 
                       <div class="row">
                          <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <div class="form-group"> 
                                <label > <font color="red" >*</font> Documento</label> 
                                <input style="border-bottom: solid #ccc 1px;"  type="file" id="fileupdate" ref="fileupdate"  v-on:change="onChangeFileUploadUpdate()" class="form-control" />
                                <div class="col-red" v-html="formValidate.fechafin"></div>
                                <small>Nota: Seleccionar el documento si quiera cambiarlo.</small>
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
                        <button class="btn btn-primary waves-effect waves-black" @click="updatePlanificacion"><i class='fa fa-floppy-o'></i> Agregar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



