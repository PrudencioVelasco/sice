<!-- page content -->
<style>
    .ck-content {
        height: 150px;
    }
</style>
<div class="right_col" role="main">
    <div class="">
        <div class="row">
            <div class="col-md-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><strong><i class="fa fa-slideshare"></i> ADMINISTRAR TAREAS DE: <?php if (isset($detalle_grupo) && !empty($detalle_grupo)) {
                            echo $detalle_grupo[0]->nombrenivel . ' - ' . $detalle_grupo[0]->nombregrupo;
                        } ?></strong></h2>

                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="row">
                            <div id="appplanificacion">
                                <div class="row" >
                                    <div class="col-md-12">
                                        <button class="btn  btn-primary waves-effect waves-black"
                                        @click=" abrirAddModal()"><i class='fa fa-plus'></i> Agregar Tarea</button>
                                    </div>
                                </div>
								<div class="row" aling="right"> 
									<div class="col-md-2 col-sm-12 col-xs-12 "  align="right">
										<div class="form-group">
											<label class="form-label"><font color="red">*</font> De: </label>
											<input type="date" style="border: solid 1px #ccc"
												v-model="buscarRegistros.fechainicio" class="form-control"
												:class="{'is-invalid': formValidate.fechainicio}" name="po">
											<div class="col-red" v-html="formValidate.fechainicio"></div>
										</div>
										<!--<input placeholder="Buscar" type="search" class="form-control btn-round"
                                        :autofocus="'autofocus'" v-model="search.text" @keyup="searchTarea"
                                        name="search">-->
									</div>
									<div class="col-md-2 col-sm-12 col-xs-12 "  align="right">
										<div class="form-group">
											<label class="form-label"><font color="red">*</font> a: </label>
											<input type="date" style="border: solid 1px #ccc"
												v-model="buscarRegistros.fechafin" class="form-control"
												:class="{'is-invalid': formValidate.fechafin}" name="po">
											<div class="col-red" v-html="formValidate.fechafin"></div>
										</div>
									</div>
									<div class="col-md-4 col-sm-12 col-xs-12 "  >
										<div class="form-group" align="right">
											<label class="form-label"></label>
											<input type="text" style="border: solid 1px #ccc; margin-top: 5px;padding-left:10px;"
												v-model="buscarRegistros.texto" class="form-control"
												:class="{'is-invalid': formValidate.texto}" name="po" placeholder="Buscar"  >
											<div class="col-red" v-html="formValidate.texto"></div>
										</div>
									</div>
									<div class="col-md-4 col-sm-12 col-xs-12 " align="right" >
										<div class="form-group">
										<button class="btn btn-info" @click="searchTarea()" style="margin-top: 25px;"><i class="fa fa-search"></i> Buscar</button>
                                        <button class="btn btn-default" @click="generarReporte()" style="margin-top: 25px;"><i class="fa fa-file-excel-o"></i> Calificaciones</button>
										</div>
									</div>
									
								</div>
								<br>
                                <table class="table table-hover table-striped">
                                    <thead class="bg-teal">
                                        <th class="text-white" v-column-sortable:titulo>TITULO </th>
                                        <th class="text-white" v-column-sortable:fechaentrega>FECHA </th>
                                        <th class="text-white" v-column-sortable:horaentrega>HORA </th>
                                        <th class="text-center text-white"> </th>
                                    </thead>
                                    <tbody class="table-light">
                                        <tr v-for="row in tareas" class="table-default">
                                            <td>{{row.titulo}}</td>
                                            <td>{{row.fechaentrega}}</td>
                                            <td>{{row.horaentrega}}</td>
                                            <td align="right">
                                               <button type="button" class="btn btn-icons btn-primary btn-sm waves-effect waves-black" @click="abrirDocumentosModal(); selectDocumentos(row.idtarea);selectTarea(row);" title="Ver documentos"> <i class="fa fa-eye" aria-hidden="true"></i>
                                                Documentos
                                            </button>
                                            <button type="button"
                                            class="btn btn-icons btn-info btn-sm waves-effect waves-black"
                                            @click=" abrirEditModal(); selectTarea(row)"
                                            title="Modificar Datos"> <i class="fa fa-edit"
                                            aria-hidden="true"></i>
                                            Editar
                                        </button>
                                        <button type="button"
                                        class="btn btn-icons btn-danger btn-sm waves-effect waves-black"
                                        @click="deleteTarea(row.idtarea)" title="Eliminar Datos"> <i
                                        class="fa fa-trash" aria-hidden="true"></i>
                                        Eliminar
                                    </button>
                                    <a class="btn btn-icons btn-default btn-sm waves-effect waves-black"
                                    v-bind:href="'/Pgrupo/revisar/'+ row.idtarea"><i
                                    class="fa fa-list-alt" aria-hidden="true"></i> Revisar</a>
                                </td>
                            </tr>
                            <tr v-if="emptyResult">
                                <td colspan="6" class="text-center h4">Sin registros</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="6" align="right">
                                    <pagination :current_page="currentPage" :row_count_page="rowCountPage"
                                    @page-update="pageUpdate" :total_users="totalTareas"
                                    :page_range="pageRange">
                                </pagination>
                            </td>
                        </tr>
                    </tfoot>
                </table>
                <?php include 'modal.php'; ?>
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
<script src="//cdn.ckeditor.com/4.15.0/standard/ckeditor.js"></script>
<script src="//unpkg.com/vue-ckeditor2"></script>
 
<!--<script src="<?php //echo base_url().'assets/vue/ckeditor/ckeditor.js' ?>" ></script>
<script src="<?php //echo base_url().'assets/vue/ckeditor/vue-ckeditor2.umd.js' ?>" ></script>-->
<script data-my_var_1="<?php echo base_url() ?>" data-my_var_2="<?php echo $idhorario; ?>"
    data-my_var_3="<?php echo $idhorariodetalle ?>"
    src="<?php echo base_url(); ?>/assets/vue/appvue/docente/tarea/apptarea_principal.js"></script>