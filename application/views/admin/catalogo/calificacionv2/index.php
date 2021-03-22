<style>
    .modal {
        overflow: auto !important;
    }
</style>
<div class="right_col" role="main">
    <div class="">
        <div class="row">
            <div class="col-md-12">
                <div class="x_panel">
                    <div class="x_title">
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <h2><strong> <i class="fa fa-check-circle" style="color: #80e166;"></i> CALIFICACIONES</strong></h2>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="row">
                            <div id="app">
                                <div class="row">
                                    <div class="col-md-3 col-sm-12 col-xs-12 ">
                                        <div class="form-group">

                                            <select style="border-bottom: solid #ebebeb 2px;" ref="idperiodo" name="cicloescolar" class="form-control">
                                                <option value="">-- CICLO ESCOLAR --</option>
                                                <option v-for="option in periodos" v-bind:value="option.idperiodo">
                                                    {{ option.mesinicio }} - {{ option.mesfin }} {{ option.yearfin }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12 col-xs-12 ">
                                        <div class="form-group">
                                            <select style="border-bottom: solid #ebebeb 2px;" ref="idgrupo" name="grupo" class="form-control">
                                                <option value="">-- GRUPO --</option>
                                                <option v-for="option in grupos" v-bind:value="option.idgrupo">
                                                    {{ option.nivelgrupo }} {{ option.nombregrupo }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12 col-xs-12 ">
                                        <div class="form-group">
                                            <select style="border-bottom: solid #ebebeb 2px;" ref="idtiporeporte" name="grupo" class="form-control">
                                                <option value="">-- REPORTE --</option>
                                                <option v-bind:value="2">PROMEDIO FINAL</option>
                                                <option v-bind:value="4">CALIFICACIÓN POR MATERIA</option>
                                                <option v-for="option in unidades" v-bind:value="'u'+option.idunidad">
                                                    {{ option.nombreunidad }}
                                                </option>
                                                <option v-for="option in oportunidades" v-bind:value="'o'+option.idoportunidadexamen">
                                                    {{ option.nombreoportunidad }}
                                                </option>
                                                <option v-for="option in meses" v-bind:value="'m'+option.idmes">
                                                    {{ option.nombremes }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-12 col-xs-12 ">
                                        <div class="form-group">
                                            <div v-if="btnbuscar2">
                                                <button class="btn btn-default" type="button" @click="searchAlumnos"> <i class="fa fa-search"></i> Buscar</button>
                                            </div>
                                            <div v-if="btncargandobuscar2">
                                                <button class="btn btn-default" type="button" disabled> <i class="fa fa-spin fa-spinner"></i> Buscando...</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row" v-if="actadeevaluacion">
                                    <div class="col-md-12 col-sm-12 col-xs-12 ">

                                        <div class="panel-group" id="accordion_1" role="tablist" aria-multiselectable="true">
                                            <div class="panel panel-primary">
                                                <div class="panel-heading" role="tab" id="headingOne_1">
                                                    <h4 class="panel-title">
                                                        <a role="button" data-toggle="collapse" data-parent="#accordion_1" href="#collapseOne_1" aria-expanded="true" aria-controls="collapseOne_1">
                                                            Acta de evaluación
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="collapseOne_1" class="panel-collapse collapse " role="tabpanel" aria-labelledby="headingOne_1">
                                                    <div class="panel-body">
                                                        <div v-for="materia in materias">
                                                            <a target="_blank" v-bind:href="'imprimirActaEvaluacionv2/'+materia.idhorariodetalle">{{materia.nombreclase}}</a>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12 ">


                                        <div class="responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th> NOMBRE</th>
                                                        <th></th>
                                                        <th> </th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="alumno in alumnos" v-if="alumnos !=''">
                                                        <th scope="row">{{alumno.enumeracion}}</th>
                                                        <td>{{alumno.nombre}}</td>
                                                        <td>
                                                            <span class="col-red" v-if="(alumno.total_reprobadas) && (alumno.total_reprobadas > 0)">
                                                                Reprobadas: {{alumno.total_reprobadas}}
                                                            </span>
                                                        </td>
                                                        <td align="right">

                                                            <button v-if="alumno.agregar_diciplina == 'SI'" @click="selectAlumno(alumno);abrirAddModalDisciplina();" class="btn btn-success"><i class="fa fa-plus-circle"></i> Agregar</button>
                                                            <button v-if="alumno.editar_diciplina == 'SI'" @click="selectAlumno(alumno);modalEditarDisciplina();" class="btn btn-primary"> <i class="fa fa-pencil-square"></i> Editar</button>
                                                            <!-- <a href="#" v-if="alumno.editar_diciplina == 'SI'"  class="btn btn-default" v-bind:href="'descargarBoletaPDF/'+idperiodo+'/'+idgrupo+'/'+ alumno.idalumno">Boleta</a>-->
                                                            <button @click="selectAlumno(alumno);showCalificacionesAlumno();abrirAddModal();" v-if="alumno.opcion_reporte  == 'UNIDAD'" class="btn btn-info"><i class="fa fa-file-text"></i> Boleta</button>
                                                            <button @click="selectAlumno(alumno);showCalificacionesPSAlumno();abrirAModalCalificacionPS();" v-if="alumno.opcion_reporte  == 'MES'" class="btn btn-info"><i class="fa fa-file-text"></i> Boleta</button>
                                                            <button @click="selectAlumno(alumno);showCalificacionesMateria();abrirAModalCalificacionMateria();" v-if="alumno.opcion_reporte  == 'CALIFICACION_MATERIA'" class="btn btn-info"><i class="fa fa-file-text"></i> Boleta</button>
                                                            <button @click="selectAlumno(alumno);showCalificacionesOportunidad();abrirModalCalificacionesOportunidad();" v-if="alumno.opcion_reporte  == 'CALIFICACION_OPORTUNIDAD'" class="btn btn-info"><i class="fa fa-file-text"></i> Boleta</button>
                                                        </td>
                                                    </tr>
                                                    <tr v-if="alumnos ==''">
                                                        <td colspan="3" align="center"><strong>Sin registros</strong></td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <?php include 'modal.php';
                                ?>
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
<script src="<?php echo base_url(); ?>/assets/vue/vue2-filters.min.js"></script>
<script data-my_var_1="<?php echo base_url() ?>" data-my_var_2="<?php echo $idplantel; ?>" src="<?php echo base_url(); ?>/assets/vue/appvue/administrador/calificaciones/appcalificacion.js"></script>