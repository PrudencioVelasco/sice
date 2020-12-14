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
                            <h2><strong> <i class="fa fa-check-circle"></i> CALIFICACIONES</strong></h2>
                        </div> 
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content"> 
                        <div class="row"  align="center"> 
                       
                            <form method="POST" action="<?= base_url(),'Calificacion/buscar'?>">
                                <div class="row">
                                    <div class="col-md-3 col-sm-12 col-xs-12 ">
                                        <div class="form-group"> 
                                            <select style="border-bottom: solid #ebebeb 2px;" name="cicloescolar" required="" id="idcicloescolar" class="form-control">
                                                <option value="">-- CICLO ESCOLAR --</option>   
                                               <?php
                                               if(isset($periodos) && !empty($periodos)){
                                                   foreach ($periodos as $value) {
                                                       echo  '<option value="'.$value->idperiodo.'">'.$value->mesinicio.' - '.$value->mesfin.' '.$value->yearfin.'</option>'; 
                                                   }
                                               }
                                               ?>
                                            </select> 
                                        </div>
                                    </div>   
                                    <div class="col-md-3 col-sm-12 col-xs-12 ">
                                        <div class="form-group"> 
                                            <select style="border-bottom: solid #ebebeb 2px;" name="grupo" id="idgrupo" class="form-control">
                                                <option value="">-- GRUPO --</option>  
                                               <?php 
                                                        if(isset($grupos) && !empty($grupos)){
                                                            foreach ($grupos as $value) {
                                                                  echo  '<option value="'.$value->idgrupo.'">'.$value->nivelgrupo.' - '.$value->nombregrupo.'</option>'; 
                                                            }
                                                        }
                                               ?>
                                            </select> 
                                        </div>
                                    </div>  
                                      <div class="col-md-4 col-sm-12 col-xs-12 ">
                                        <div class="form-group"> 
                                            <select style="border-bottom: solid #ebebeb 2px;" name="tiporeporte"  id="idtiporeporte" class="form-control">
                                                <option value="">-- TIPO DE REPORTE --</option>  
                                                <option value="2">PROMEDIO FINAL</option> 
                                                <option value="4">CALIFICACIÓN POR MATERIA</option> 
                                                <?php 
                                                if(isset($unidades) && !empty($unidades)){
                                                    foreach ($unidades as $row){
                                                        echo '<option value="u'.$row->idunidad.'">'.$row->nombreunidad.'</option>';
                                                    }
                                                }
                                                
                                                if(isset($oportunidades) && !empty($oportunidades)){
                                                    foreach ($oportunidades as $row){
                                                        echo '<option value="o'.$row->idoportunidadexamen.'">'.$row->nombreoportunidad.'</option>';
                                                    }
                                                }
                                                if($this->session->idniveleducativo == 1 || $this->session->idniveleducativo == 2){
                                                    if(isset($meses) && !empty($meses)){
                                                        foreach ($meses as $row){
                                                            echo '<option value="m'.$row->idmes.'">'.$row->nombremes.'</option>';
                                                        }
                                                    }
                                                }
                                                ?>
                                            </select> 
                                        </div>
                                    </div>  
                                     <div class="col-md-2 col-sm-12 col-xs-12 ">
                                        <div class="form-group"> 
                                            <button class="btn btn-default" type="submit"> <i class="fa fa-search"></i> Buscar</button>
                                           </div>
                                    </div>  
                                </div>
                            </form>



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
<script data-my_var_2="<?php echo base_url() ?>" src="<?php echo base_url(); ?>/assets/js/validar/Administrar/busqueda_asignaturas.js"></script> 
<div id="custom_notifications" class="custom-notifications dsp_none">
    <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
    </ul>
    <div class="clearfix"></div>
    <div id="notif-group" class="tabbed_notifications"></div>
</div>
