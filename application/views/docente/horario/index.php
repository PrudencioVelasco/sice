<!-- page content -->
<style>
    ul{
        list-style-type: none;
        margin: 0;
        padding: 0; 
    }

</style>
<div class="right_col" role="main">

    <div class=""> 

        <div class="row">
            <div class="col-md-12">
                <div class="x_panel">
                    <div class="x_title">
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <h2><strong> <i class="fa fa-clock-o"></i> HORARIO ESCOLAR</strong></h2>
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12 " align="right">
                            <?php if (isset($id) && !empty($id)) { ?>
                                <a target="_blank" href="<?php echo site_url('Phorario/descargar/' . $controller->encode($id)) ?>" class="btn btn-primary">IMPRIMIR HORARIO</a>
                            <?php } ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content"> 
                        <div class="row"  align="center"> 
                            <?php
                            
                            if (isset($this->session->idplantel) && ($this->session->idplantel == 1 || $this->session->idplantel == 3 || $this->session->idplantel == 5)) {
                                ?>
                            <div class="alert alert-info alert-dismissible fade in" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                                    </button>
                                <strong>Información!</strong> Para dar una clase usted debe de reclarar ser anfitrion ingresando el número de anfitrion que está debajo de su asignatura, puede ver el manual de como hacer aqui.<a target="_blank" href="https://drive.google.com/file/d/1eG7q1p6cM39bNGZsZg7oNjiqKd4w_FH9/view?usp=sharing" >Descargar manual</a>
                                </div>
                                    <?php
                            }
                            ?>
                            <?php
                            if (isset($tabla) && !empty($tabla)) {
                                echo $tabla;
                            } else {
                                echo '<label align="center">No tiene registrado Horario de Clases.</label>';
                            }
                            ?>


                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="largeModalAdd" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="largeModalLabel">REGISTRAR URL VIDEO GRABADO</h4>
                </div>
                <form id="frmurl" >
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12 ">
                                <div class="alert alert-success print-success-msg" style="display:none"></div>
                                <div class="alert alert-danger print-error-msg" style="display:none"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12 ">
                                <div class="form-group">
                                    <label><font color="red">*</font> URL VIDEOCONFERENCIA</label>
                                    <input type="url"  style="border-bottom:solid #ccc 1px;"  name="url" required="" class="form-control">
                                </div>
                            </div>
                        </div> 


                    </div>
                    <div class="modal-footer"> 
                         <input type="hidden" name="idhorariodetalle" class="idhorariodetalle"> 
                        <button type="button" id="btnguardar" class="btn btn-primary waves-effect"><i class='fa fa-floppy-o'></i> GUARDAR</button>
                        <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal"><i class='fa fa-close'></i> CERRAR</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
      <div class="modal fade" id="largeModalEdit" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="largeModalLabel">MODIFICAR LA URL VIDE GRABADO</h4>
                </div>
                <form id="frmmodificar" >
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12 ">
                                <div class="alert alert-success print-success-msg" style="display:none"></div>
                                <div class="alert alert-danger print-error-msg" style="display:none"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12 ">
                                <div class="form-group">
                                    <label><font color="red">*</font> URL VIDEOCONFERENCIA</label>
                                    <input type="url"  style="border-bottom:solid #ccc 1px;"  name="url" required="" class="utlvideo form-control">
                                </div>
                            </div>
                        </div> 


                    </div>
                    <div class="modal-footer"> 
                         <input type="hidden" name="idhorariodetalle" class="idhorariodetalle"> 
                        <button type="button" id="btnmodificar" class="btn btn-primary waves-effect"><i class='fa fa-pencil-square-o'></i> MODIFICAR</button>
                        <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal"><i class='fa fa-close'></i> CERRAR</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
      <div class="modal fade" id="largeModalDelete" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="largeModalLabel">ELIMINAR URL VIDEO </h4>
                </div>
                <form id="frmeliminar" >
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12 ">
                                <div class="alert alert-success print-success-msg" style="display:none"></div>
                                <div class="alert alert-danger print-error-msg" style="display:none"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12 ">
                                <h3>Esta seguro de eliminar la URL del video?</h3>
                            </div>
                        </div> 


                    </div>
                    <div class="modal-footer"> 
                         <input type="hidden" name="idhorariodetalle" class="idhorariodetalle"> 
                        <button type="button" id="btneliminar" class="btn btn-primary waves-effect"><i class='fa fa-trash '></i> ELIMINAR</button>
                        <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal"><i class='fa fa-close'></i> CERRAR</button>
                    </div>
                </form>
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
<script data-my_var_1="<?php echo base_url() ?>" data-my_var_2="<?php echo $id; ?>" src="<?php echo base_url(); ?>/assets/vue/appvue/apphorariodetalle.js"></script> 

<script data-my_var_1="<?php echo base_url() ?>" src="<?php echo base_url(); ?>/assets/js/validar/docente_subirurl.js" type="text/javascript"></script>
