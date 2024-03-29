<!-- page content -->
<div class="right_col" role="main">

    <div class="">

        <div class="row">
            <div class="col-md-12  col-sm-12 col-xs-12 ">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><strong>ADMINISTRAR ALUMNOS</strong></h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                        <div id="app">
                            <div class="container">

                                <div class="row">
                                    <div class="col-md-6 col-sm-12 col-xs-12 ">

                                        <button class="btn  btn-primary waves-effect waves-black" @click="abrirAddModal()"><i class='fa fa-plus'></i> Agregar Alumno</button>
                                        <button class="btn  btn-info waves-effect waves-black" @click="abrirSituacionAlumnos();showAllEstatusAlumnos();"><i class='fa fa-info-circle'></i> Situacion</button>
                                        <a class="btn btn-default waves-effect waves-black" href="<?php echo base_url() . 'Alumno/reprobadas'; ?>"> <i class="fa fa-share"></i> Asignación</a>


                                    </div>
                                    <div class="col-md-6 col-sm-12 col-xs-12 "> </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-12 col-xs-12 " align="right">
                                        <div v-if="buscandoalumno">
                                            <label><strong> Buscando...</strong> <i class="fa fa-spin fa-spinner fa-2x" style="color:royalblue"></i> </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12 col-xs-12 ">
                                        <input placeholder="Buscar" :autofocus="'autofocus'" type="search" class="form-control btn-round" v-model="search.text" @keyup="searchAlumno" name="search">
                                    </div>
                                </div>
                                <br>



                                <table class="table table-hover table-striped">
                                    <thead class="bg-teal">
                                        <th>Foto</th>
                                        <th class="text-white" v-column-sortable:matricula>Matricula </th>
                                        <th class="text-white" v-column-sortable:nombre>Nombre </th>
                                        <th class="text-white" v-column-sortable:apellidop>A. Paterno </th>
                                        <th class="text-white" v-column-sortable:apellidom>A. Materno </th>
                                        <th class="text-center text-white">Opción </th>
                                    </thead>
                                    <tbody>
                                        <tr v-for="alumno in alumnos">
                                            <td>
                                                <div class="media">
                                                    <div class="media-left">
                                                        <a href="#">
                                                            <img v-if="alumno.foto" style="width: 50px; height:50px; border:solid #ccc 1px;" v-bind:src="url_image+alumno.foto" alt="" />
                                                            <img v-else src="<?php echo base_url(); ?>/assets/images/user2.png" />
                                                        </a>
                                                    </div>
                                                </div>

                                            </td>
                                            <td valign="bottom">{{alumno.matricula}}</td>
                                            <td valign="middle">{{alumno.nombre}}</td>
                                            <td valign="middle"> {{alumno.apellidop}}</td>
                                            <td valign="middle">{{alumno.apellidom}}</td>
                                            <td align="right">

                                                <div class="btn-group" role="group">
                                                    <div class="btn-group" role="group">
                                                        <button type="button" class="btn btn-info waves-effect dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class='fa fa-plus'></i> Opciones
                                                            <span class="caret"></span>
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li><a href="#" @click="deleteAlumno(alumno.idalumno)" title="Eliminar Datos"><i style="color:#fc2222;" class="fa fa-trash"></i> Eliminar</a></li>
                                                            <li><a href="#" @click="abrirEditModal(); selectAlumno(alumno)" title="Modificar Datos"><i style="color:#789dfc;" class="fa fa-edit"></i> Editar</a></li>
                                                            <li><a href="#" @click="abrirChangeModal();selectAlumno(alumno)" title="Modificar Datos"><i style="color:#ecd558;" class="fa fa-key"></i> Contraseña</a></li>
                                                            <li><a href="#" v-bind:href="'detalle/'+ alumno.idalumno"><i style="color:#000000;" class="fa fa-list-alt" aria-hidden="true"></i> Detalles</a></li>
                                                        </ul>
                                                    </div>
                                                </div>



                                            </td>
                                        </tr>
                                        <tr v-if="emptyResult">
                                            <td colspan="7" class="text-center h4">No encontrado</td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="7" align="center">
                                                <pagination :current_page="currentPage" :row_count_page="rowCountPage" @page-update="pageUpdate" :total_users="totalAlumnos" :page_range="pageRange">
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/vuejs-paginator/2.0.0/vuejs-paginator.js"></script>

<script data-my_var_1="<?php echo base_url() ?>" src="<?php echo base_url(); ?>/assets/vue/appvue/appalumno.js?v1.0"></script>