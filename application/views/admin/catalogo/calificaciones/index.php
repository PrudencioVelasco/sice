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

                            <form>
                                <div class="row">
                                    <div class="col-md-3 col-sm-12 col-xs-12 ">
                                        <div class="form-group"> 
                                            <select style="border-bottom: solid #ebebeb 2px;" class="form-control">
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
                                            <select style="border-bottom: solid #ebebeb 2px;" class="form-control">
                                                <option value="">-- GRUPO --</option>  
                                               <?php 
                                                        if(isset($grupos) && !empty($grupos)){
                                                            foreach ($grupos as $value) {
                                                                  echo  '<option value="'.$value->idgrupo.'">'.$value->nombrenivel.' - '.$value->nombregrupo.'</option>'; 
                                                            }
                                                        }
                                               ?>
                                            </select> 
                                        </div>
                                    </div>  
                                      <div class="col-md-4 col-sm-12 col-xs-12 ">
                                        <div class="form-group"> 
                                            <select style="border-bottom: solid #ebebeb 2px;" v-model="newColegiatura.idconcepto"  :class="{'is-invalid': formValidate.idnivel}"class="form-control">
                                                <option value="">-- TIPO DE REPORTE --</option> 
                                                <option value="1">LISTA</option>
                                                <option value="2">CALIFICACIÓN FINAL</option>
                                                <option value="3">CALIFICACIÓNFINAL EN RECUPERACIÓN</option> 
                                                <option value="2">CALIFICACIÓN POR MATERIA</option>
                                                <option value="3">CALIFICACIÓN POR MATERIA EN RECUPERACIÓN</option>
                                            </select> 
                                        </div>
                                    </div>  
                                     <div class="col-md-2 col-sm-12 col-xs-12 ">
                                        <div class="form-group"> 
                                            <button class="btn btn-default"> <i class="fa fa-search"></i> Buscar</button>
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

<div id="custom_notifications" class="custom-notifications dsp_none">
    <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
    </ul>
    <div class="clearfix"></div>
    <div id="notif-group" class="tabbed_notifications"></div>
</div>
