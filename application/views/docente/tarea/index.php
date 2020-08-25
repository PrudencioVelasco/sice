 
<div class="right_col" role="main">

    <div class=""> 

        <div class="row">
            <div class="col-md-12">
                <div class="x_panel">
                    <div class="x_title">
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <h2><strong> <i class="fa fa-file"></i> PRUEBAS PARA SUBIR DOCUMENTOS</strong></h2>
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12 " align="right">

                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content"> 
                        <div class="row"  align="center"> 
                            <div id="app">
                                 <div class="row">
                                     <div class="col-md-12 col-sm-12 col-xs-12 ">
                                         <div v-if="procesando">
                                             <h3 class="text-info">Se esta subiendo el documento, esto puede tardar unos minutos.</h3>
                                         </div>
                                         <div v-if="exito">
                                             <h3 class="text-success" >Se subio el documento con exito.</h3>
                                         </div>
                                         <div class="text-danger" v-if="error">
                                             <h3>Error al subir el documento, intente mas tarde.</h3>
                                         </div>
                                     </div>
                                 </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-12 col-xs-12 ">
                                        <input type="file" class="form-control"  v-on:change="onChangeFileUpload()" id="file" ref="file">
                                    </div>
                                    <div class="col-md-6 col-sm-12 col-xs-12 ">
                                        <button class="btn btn-primary" v-on:click="addEscuela()">SUBIR DOCUMENTO</button>
                                    </div>
                                </div>  
                            </div> 
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </div> 
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
<script data-my_var_1="<?php echo base_url() ?>"  src="<?php echo base_url(); ?>/assets/vue/appvue/docente/tarea/apptarea.js"></script> 

