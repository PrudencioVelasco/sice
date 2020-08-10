<div class="modal fade" id="addAsignarGrupo" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">ASIGNAR GRUPO</h4>
            </div>
            <div class="modal-body"  >
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12 ">
                        <div class="col-red" v-html="formValidate.msgerror"></div>
                    </div>
                </div>   
                <div class="row  clearfix"> 
                    <div class="col-md-12 col-sm-12 col-xs-12 ">
                        <div class="form-group">

                            <select style="border-bottom: solid #ebebeb 2px;" v-model="asignarGrupo.idcicloescolar"  :class="{'is-invalid': formValidate.idcicloescolar}" class="form-control show-tick">
                                <option value="" selected >-- CICLO ESCOLAR  --</option>
                                <option   v-for="option in ciclos_escolares" v-bind:value="option.idperiodo">
                                    {{ option.mesinicio  }} - {{ option.mesfin  }}  {{ option.yearfin  }} 
                                </option>
                            </select>
                            <div class="col-red" v-html="formValidate.idcicloescolar"></div>
                        </div>
                    </div>  
                </div>
                <div class="row  clearfix"> 
                    <div class="col-md-12 col-sm-12 col-xs-12 ">
                        <div class="form-group">

                            <select style="border-bottom: solid #ebebeb 2px;" v-model="asignarGrupo.idgrupo"  :class="{'is-invalid': formValidate.idgrupo}" class="form-control show-tick">
                                <option value="" selected >-- GRUPO  --</option>
                                <option   v-for="value in grupos" v-bind:value="value.idgrupo">
                                    {{ value.nombrenivel  }} {{ value.nombregrupo  }}  - {{ value.nombreturno  }}- {{ value.nombreespecialidad  }}
                                </option>
                            </select>
                            <div class="col-red" v-html="formValidate.idgrupo"></div>
                        </div>
                    </div>  
                </div>    
            </div>
            <div class="modal-footer">
                <div class="row"> 
                    <div class="col-md-12 col-sm-12 col-xs-12 "  align="right"  >
                        <button class="btn btn-danger waves-effect waves-black" @click="clearAll"><i class='fa fa-ban'></i> Cancelar</button>
                        <button class="btn btn-primary waves-effect waves-black" @click="addGrupo"><i class='fa fa-floppy-o'></i> Agregar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="editGrupo" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">CAMBIAR GRUPO</h4>
            </div>
            <div class="modal-body"  >
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12 ">
                        <div class="col-red" v-html="formValidate.msgerror"></div>
                    </div>
                </div>    
                <div class="row  clearfix"> 
                    <div class="col-md-12 col-sm-12 col-xs-12 ">
                        <div class="form-group">

                            <select style="border-bottom: solid #ebebeb 2px;" v-model="asignarGrupo.idgrupo"  :class="{'is-invalid': formValidate.idgrupo}" class="form-control show-tick">
                                <option value=""   >-- GRUPO  --</option> 
                                <option   v-for="option in grupos" selected="option.idgrupo == grupo_actual.idgrupo ? 'selected' : ''"  v-bind:value="option.idgrupo">
                                    {{ option.nombrenivel  }} {{ option.nombregrupo  }}  - {{ option.nombreturno  }}- {{ option.nombreespecialidad  }}
                                </option>
                            </select>
                            <div class="col-red" v-html="formValidate.idgrupo"></div>
                        </div>
                    </div>  
                </div>    
            </div>
            <div class="modal-footer">
                <div class="row"> 
                    <div class="col-md-12 col-sm-12 col-xs-12 "  align="right"  >
                        <button class="btn btn-danger waves-effect waves-black" @click="clearAll"><i class='fa fa-ban'></i> Cancelar</button>
                        <button class="btn btn-primary waves-effect waves-black" @click="updateGrupo"><i class='fa fa-floppy-o'></i> Agregar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="addBeca" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">ASIGNAR BECA</h4>
            </div>
            <div class="modal-body"  >
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12 ">
                        <div class="col-red" v-html="formValidate.msgerror"></div>
                    </div>
                </div>   
                <div class="row  clearfix"> 
                    <div class="col-md-12 col-sm-12 col-xs-12 ">
                        <div class="form-group">

                            <select style="border-bottom: solid #ebebeb 2px;" v-model="asignarBeca.idbeca"  :class="{'is-invalid': formValidate.idbeca}" class="form-control show-tick">
                                <option value="" selected >-- BECA  --</option>
                                <option   v-for="option in becas" v-bind:value="option.idbeca">
                                    {{ option.descuento  }} %
                                </option>
                            </select>
                            <div class="col-red" v-html="formValidate.idbeca"></div>
                        </div>
                    </div>  
                </div>    
            </div>
            <div class="modal-footer">
                <div class="row"> 
                    <div class="col-md-12 col-sm-12 col-xs-12 "  align="right"  >
                        <button class="btn btn-danger waves-effect waves-black" @click="clearAll"><i class='fa fa-ban'></i> Cancelar</button>
                        <button class="btn btn-primary waves-effect waves-black" @click="addBeca"><i class='fa fa-floppy-o'></i> Agregar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="editBeca" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">ASIGNAR BECA</h4>
            </div>
            <div class="modal-body"  >
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12 ">
                        <div class="col-red" v-html="formValidate.msgerror"></div>
                    </div>
                </div>   
                <div class="row  clearfix"> 
                    <div class="col-md-12 col-sm-12 col-xs-12 ">
                        <div class="form-group">

                            <select style="border-bottom: solid #ebebeb 2px;" v-model="asignarBeca.idbeca"  :class="{'is-invalid': formValidate.idbeca}" class="form-control show-tick">
                                <option value="" selected >-- BECA  --</option>
                                <option   v-for="option in becas" v-bind:value="option.idbeca">
                                    {{ option.descuento  }} %
                                </option>
                            </select>
                            <div class="col-red" v-html="formValidate.idbeca"></div>
                        </div>
                    </div>  
                </div>    
            </div>
            <div class="modal-footer">
                <div class="row"> 
                    <div class="col-md-12 col-sm-12 col-xs-12 "  align="right"  >
                        <button class="btn btn-danger waves-effect waves-black" @click="clearAll"><i class='fa fa-ban'></i> Cancelar</button>
                        <button class="btn btn-primary waves-effect waves-black" @click="addBeca"><i class='fa fa-floppy-o'></i> Agregar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="subirFoto" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">SUBIR FOTO</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12 ">
                        <div class="col-red" v-html="formValidate.msgerror"></div>
                    </div>
                </div> 
                <div class="row">

                    <div class="col-md-12 col-sm-12 col-xs-12 ">
                        <div class="form-group ">

                            <label  class="form-label"><font color="red">*</font> SELECCIONAR</label>
                            <input type="file" id="file" ref="file"  v-on:change="onChangeFileUpload()" class="form-control"  > 

                            <div class="col-red" v-html="formValidate.file"></div>
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
                    <div  class="col-md-6 col-sm-12 col-xs-12 " >
                        <button class="btn btn-danger waves-effect waves-black" @click="clearAll"><i class='fa fa-ban'></i> Cancelar</button>
                        <button class="btn btn-primary waves-effect waves-black" v-on:click="subirFoto"><i class='fa fa-upload'></i> Subir</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>