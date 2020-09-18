
<div class="modal fade" id="editRegister" tabindex="-1" role="dialog">
    <div class="modal-dialog  modal-lg " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="smallModalLabel">DETALLE DE LA TAREA</h4>
            </div>
            <div class="modal-body">
                <div style="padding-right:15px;">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <label class="col-red" v-html="formValidate.msgerror"></label>
                        </div>
                    </div> 
                 
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 "> 
                            <div   v-if="chooseAlumnosTareas.mensaje" v-html="chooseAlumnosTareas.mensaje"></div>
                        </div>
                    </div>
                    <hr>
                     <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12 "> 
                            <div class="form-group"> 
                                <label><font color="red">*</font> SELECCIONE EL TIPO DE CALIFICACION</label>
                              <select class=" form-control" v-model="chooseAlumnosTareas.idestatustarea" style="border-bottom: solid #ccc 1px; "> 
                                  
                                  <option   v-for="option in estatustarea"  :selected="option.idestatustarea == chooseAlumnosTareas.idestatustarea ? 'selected' : ''" :value="option.idestatustarea" >
                                        {{ option.nombreestatus }}   
                                    </option>
                                </select>
                                <div class="col-red" v-html="formValidate.idnivelestudio"></div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 col-sm-12 col-xs-12 "> 
                            <a v-if="chooseAlumnosTareas.iddocumento"  v-bind:href="'https://drive.google.com/uc?export=download&id='+ chooseAlumnosTareas.iddocumento"><i class="fa fa-download"></i> DESCARGAR DOCUMENTO</a>
                        </div>
                  
                     
                    </div>
                      <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <label>Observaciones</label>
                             <vue-ckeditor  v-model="chooseAlumnosTareas.observaciones"  :config="config"  />
                          <div class="col-red" v-html="formValidate.observacionesa"></div>
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
                        <button class="btn btn-primary waves-effect waves-black" @click="updateAlumnosTareas"><i class='fa fa-check'></i> Calificar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
