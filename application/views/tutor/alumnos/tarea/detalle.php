<!-- page content -->
<style>
  .ck-editor__editable {
    min-height: 200px;
}
</style>
<div class="right_col" role="main">
    <div class="">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><strong><i class="fa fa-book"></i> DETALLE DE LA TAREA</strong></h2>

                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content"> 
                        <div class="row"> 
                            <div id="appdetalletarea">
                                <div class="container">
                                    <div class="row"> 
                                        <div class="col-md-8  col-sm-12 col-xs-12">
                                            <h6>Titulo:</h6>
                                            <h5>{{tarea.titulo}}</h5>
                                        </div>
                                        <div class="col-md-4  col-sm-12 col-xs-12" align='right'>
                                            <h5>Entregar antes de: {{tarea.horaentrega}} {{tarea.fechaentrega}}</h5>

                                        </div>
                                    </div> 
                                    <div class="row">
                                        <div class="col-md-8  col-sm-12 col-xs-12">
                                            <h6>Tarea:</h6>
                                            <div v-html="tarea.tarea" ></div>
                                        </div>
                                        <div class="col-md-4  col-sm-12 col-xs-12" align='right'>
                                            <div v-for="file in documentosTarea" :key="file.iddocumento">
                                                <a v-if="file.iddocumento" v-bind:href="'https://drive.google.com/uc?export=download&id='+ file.iddocumento" target="_blank"><i class="fa fa-cloud-download"></i> DESCARGAR DOCUMENTO</a>
                                            </div>
                                            <a v-if="tarea.iddocumento" v-bind:href="'https://drive.google.com/uc?export=download&id='+ tarea.iddocumento" target="_blank"><i class="fa fa-cloud-download"></i> DESCARGAR DOCUMENTO</a>
                                        </div>
                                    </div>
                                    <hr/> 
                                    <div v-for="row in contestado">
                                    <div  v-if="contestado">
                                        <div class="row">
                                           <div class="col-md-6  col-sm-12 col-xs-12" align="left">
                                                <label  class="label bg-blue">Calificación: {{row.calificacion}}</label>
                                           </div>
                                           <div class="col-md-6  col-sm-12 col-xs-12" align="right">
                                            <small>Envió: {{row.fecharegistro}}</small>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12  col-sm-12 col-xs-12">
                                            <h6>Respuesta:</h6>
                                            <div v-html="row.mensaje" ></div>
                                        </div>
                                    </div>
											<div class="row">
												<div class="col-md-12  col-sm-12 col-xs-12" align='right'>
													<div class="col-md-55" v-if="row.iddocumento">
														<div class="thumbnail">
															<div class="image view view-first">
																<img
																	v-if="file.ext == 'jpg' || file.ext == 'jpeg' || file.ext == 'png'"
																	style="width: 100%; display: block;"
																	v-bind:src="'https://drive.google.com/thumbnail?id'+ row.iddocumento"
																	alt="No se puede previsualizar el archivo." /> <img v-else alt="No se puede previsualizar el archivo"
																	v-bind:src="'https://drive.google.com/thumbnail?id'+ row.iddocumento"
																	style="width: 100%; display: block;">
																<div class="mask">

																	<div class="tools tools-bottom">
																		<a
																			v-bind:href="'https://drive.google.com/uc?export=download&id='+ row.iddocumento" target="_blank"><i
																			class="fa fa-download"></i></a>
																	</div>
																</div>
															</div>
														</div>
													</div>

													<div v-for="file in row.documentos">
														<div class="col-md-55">
															<div class="thumbnail">
																<div class="image view view-first">
																	<img
																		v-if="file.ext == 'jpg' || file.ext == 'jpeg' || file.ext == 'png'"
																		style="width: 100%; display: block;"
																		v-bind:src="'https://drive.google.com/thumbnail?id='+ row.iddocumento"
																		alt="No se puede previsualizar el archivo" /> <img v-else alt="No se puede previsualizar el archivo"
																		v-bind:src="'https://drive.google.com/thumbnail?id='+ file.file"
																		style="width: 100%; display: block;">


																	<div class="mask">

																		<div class="tools tools-bottom">
																			<a
																				v-bind:href="'https://drive.google.com/uc?export=download&id='+ file.file" target="_blank"><i
																				class="fa fa-download"></i></a>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
													
												</div>
											</div>
										</div>
                                <div v-if="row.observacionesdocente != ''">
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-8  col-sm-12 col-xs-12">
                                            <h6>Observaciones del docente:</h6>
                                            <div v-html="row.observacionesdocente" ></div>
                                        </div> 
                                    </div>
                                </div>
                                  <hr>
                                </div>
                              
                            </div> 
                        </div>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</div>

<!-- footer content -->
<footer>
    <div class="copyright-info">
        <p class="pull-right">SICE - Sistema Integral para el Control Escolar</a>
        </p>
    </div>
    <div class="clearfix"></div>
</footer>
<!-- /footer content -->

</div>
<!-- /page content -->
</div>

</div>

<div id="custom_notifications" class="custom-notifications dsp_none">
    <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
    </ul>
    <div class="clearfix"></div>
    <div id="notif-group" class="tabbed_notifications"></div>
</div>
<script src="<?php echo base_url().'assets/vue/ckeditor/' ?>ckeditor.js"></script>
<script src="<?php echo base_url().'assets/vue/ckeditor/' ?>vue-ckeditor2.umd.js"></script>
<script data-my_var_1="<?php echo base_url() ?>" data-my_var_2="<?php echo $idtarea; ?>" data-my_var_3="<?php echo $idalumno; ?>" src="<?php echo base_url(); ?>/assets/vue/appvue/tutor/tarea/appdetalletarea.js"></script> 