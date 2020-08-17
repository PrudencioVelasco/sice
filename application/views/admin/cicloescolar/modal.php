<div class="modal fade" id="addRegister" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="smallModalLabel">AGREGAR PERIODO ESCOLAR</h4>
            </div>
            <div class="modal-body">
                <div style=" height: 200px; padding-top:13px; padding-right:15px; overflow-x: hidden; overflow-y: scroll;">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <div class="col-red" v-html="formValidate.msgerror"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group">
                                <label><font color="red">*</font> MES INICIO</label>

                                <select style="border-bottom: solid #ebebeb 2px;" v-model="newCiclo.idmesinicio"  :class="{'is-invalid': formValidate.idmesinicio}"class="form-control">
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
                                <label><font color="red">*</font> AÑO INICIO</label>
                                <select style="border-bottom: solid #ebebeb 2px;" v-model="newCiclo.idyearinicio"  :class="{'is-invalid': formValidate.idmesinicio}"class="form-control">
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
                                <label><font color="red">*</font> MES TERMINO</label>
                                <select style="border-bottom: solid #ebebeb 2px;" v-model="newCiclo.idmesfin"  :class="{'is-invalid': formValidate.idmesfin}"class="form-control">
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
                                <label><font color="red">*</font> AÑO TERMINO</label>
                                <select style="border-bottom: solid #ebebeb 2px;" v-model="newCiclo.idyearfin"  :class="{'is-invalid': formValidate.idyearfin}"class="form-control">
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
                        <button class="btn btn-primary waves-effect waves-black" @click="addCiclo"><i class='fa fa-floppy-o'></i> Agregar</button>
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
                <h4 class="modal-title" id="smallModalLabel">EDITAR PERIODO ESCOLAR</h4>
            </div>
            <div class="modal-body">
                <div style="padding-top:13px; padding-right:15px; height: 200px;overflow-x: hidden; overflow-y: scroll;">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <div class="col-red" v-html="formValidate.msgerror"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group">
                                <label><font color="red">*</font> MES INICIO</label>

                                <select style="border-bottom: solid #ebebeb 2px;" v-model="chooseCiclo.idmesinicio"  :class="{'is-invalid': formValidate.idmesinicio}" class="form-control">
                                    <option   v-for="option in meses"  :selected="option.idmes == chooseCiclo.idmesinicio ? 'selected' : ''" v-bind:value="option.idmes">
                                        {{ option.nombremes }}   
                                    </option>
                                </select>
                                <div class="col-red" v-html="formValidate.idmesinicio"></div>

                            </div>
                        </div>  
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group">
                                <label><font color="red">*</font> AÑO INICIO</label>
                                <select style="border-bottom: solid #ebebeb 2px;" v-model="chooseCiclo.idyearinicio"  :class="{'is-invalid': formValidate.idmesinicio}"class="form-control">
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
                                <label><font color="red">*</font> MES TERMINO</label>
                                <select style="border-bottom: solid #ebebeb 2px;" v-model="chooseCiclo.idmesfin"  :class="{'is-invalid': formValidate.idmesfin}"class="form-control">
                                    <option   v-for="option in meses"  :selected="option.idmes == chooseCiclo.idmesfin ? 'selected' : ''" v-bind:value="option.idmes">
                                        {{ option.nombremes }}   
                                    </option>
                                </select>
                                <div class="col-red" v-html="formValidate.idmesfin"></div>

                            </div>
                        </div> 

                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group">
                                <label><font color="red">*</font> AÑO TERMINO</label>
                                <select style="border-bottom: solid #ebebeb 2px;" v-model="chooseCiclo.idyearfin"  :class="{'is-invalid': formValidate.idyearfin}"class="form-control">
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
                                <label for="">* ESTATUS</label><br> 
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
                        <button class="btn btn-primary waves-effect waves-black" @click="updateCiclo"><i class='fa fa-edit'></i> Modificar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

