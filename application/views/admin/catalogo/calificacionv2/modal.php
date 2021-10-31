<div class="modal fade" id="abrirModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12 " align="left">
                        <h4 class="modal-title" id="defaultModalLabel">BOLETA DE CALIFICACIONES DE: {{chooseAlumno.nombre}}</h4>
                    </div>

                </div>
            </div>
            <div class="modal-body">
                <div style="padding-top:13px; padding-right:15px;">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <label style="color: red" v-html="formValidate.msgerror"></label>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <div v-if="mostrar_calificacion_tabla">
                                <table class=" table table-striped dt-responsive nowrap" cellspacing="0">
                                    <thead class="bg-teal">
                                        <th>CURSO</th>
                                        <th>CALIFICACIÓN</th>

                                        <th></th>
                                    </thead>
                                    <tbody>
                                        <tr v-for="row in calificaciones" v-if="row.mostrar == 'SI' && row.calificacion != 'null' && row.totalcalificado != 0 ">
                                            <div>
                                                <td>
                                                    <span v-if="row.mostrar_calificar == 'NO'">
                                                        <i class="fa fa-ban" style="color:red;"></i>
                                                    </span>
                                                    {{row.nombreclase}}
                                                </td>
                                                <td>
                                                    <div v-if="chooseAlumno.limitar_unidades == 'SI'">
                                                        <div v-if="chooseAlumno.idunidad != '22'">
                                                            <div v-if=" chooseAlumno.numero_unidades <= row.totalunidades">
                                                                <strong v-if="row.calificacion == '' || row.calificacion == 'null' || !row.calificacion">No registrado</strong>
                                                                <strong v-else>{{row.calificacion}}</strong>
                                                            </div>
                                                            <div v-else>
                                                                Solo tiene {{row.totalunidades}} unidades.
                                                            </div>
                                                        </div>
                                                        <div v-else>
                                                            <strong v-if="row.calificacion == '' || row.calificacion == 'null' || !row.calificacion">No registrado</strong>
                                                            <strong v-else>{{row.calificacion}}</strong>
                                                        </div>
                                                    </div>
                                                    <div v-else>
                                                        <strong v-if="row.calificacion == '' || row.calificacion == 'null' || !row.calificacion">No registrado</strong>
                                                        <strong v-else>{{row.calificacion}}</strong>
                                                    </div>

                                                </td>

                                                <td align="right">
                                                    <div v-if="row.mostrar_calificar == 'SI' || chooseAlumno.numero_unidades <= row.totalunidades">
                                                        <button type="button" v-if="row.calificacion && (chooseAlumno.editar_calificacion &&  chooseAlumno.editar_calificacion == 'SI')" @click="eliminarCalificacionPrepa();selectCalificacionPrepa(row);" class="btn btn-danger btn-sm">Eliminar</button>
                                                        <button type="button" v-if="row.calificacion  && (chooseAlumno.editar_calificacion &&  chooseAlumno.editar_calificacion == 'SI')" @click="selectCalificacionPrepa(row); abrirModalEditCalificacionPrepa()" class="btn btn-info btn-sm">Modificar</button>
                                                        <button type="button" @click="abrirModalAddCalificacionPrepa();selectCalificacionPrepa(row); " v-if="(row.calificacion == '' || row.calificacion == 'null' || !row.calificacion)  && (chooseAlumno.editar_calificacion &&  chooseAlumno.editar_calificacion == 'SI')" class="btn btn-primary btn-sm">Agregar</button>
                                                    </div>
                                                </td>
                                            </div>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div v-if="cargando_calificacion_tabla" align="center">
                                <h4><i class="fa fa-spin fa-spinner"></i> Cargando calificaciones...</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="row">

                    <div class="col-md-12 col-sm-12 col-xs-12 " align="right">
                        <button type="button" class="btn btn-danger waves-effect waves-black" @click="clearAll"> <i class="fa fa-times"></i> Cancelar</button>
                        <a href="#" target="_blank" v-if="chooseAlumno.editar_diciplina == 'SI'" class="btn btn-default" v-bind:href="'descargarBoletaPDF/'+idperiodo+'/'+idgrupo+'/'+ chooseAlumno.idalumno"> <i class="fa fa-cloud-download"></i> Descargar Boleta</a>
                        <a href="#" target="_blank" v-if="chooseAlumno.editar_diciplina == 'SI'" class="btn btn-default" v-bind:href="'descargarBoletaPDFNuevoFormato/'+idperiodo+'/'+idgrupo+'/'+ chooseAlumno.idalumno"> <i class="fa fa-cloud-download"></i> Descargar Nueva Boleta</a>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditarDisciplina" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12 " align="left">
                        <h4 class="modal-title" id="defaultModalLabel">ALUMNO(A): {{chooseAlumno.nombre}}</h4>
                    </div>

                </div>
            </div>
            <div class="modal-body">
                <div style=" ">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <div class="col-red" v-html="formValidate.msgerror"></div>

                        </div>
                    </div>
                    <br />
                    <div class="row clearfix">
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float ">
                                <div class="form-line focused">
                                    <label class="form-label">
                                        <font color="red">*</font> FORMACION EN VALORES
                                    </label>
                                    <input type="text" v-model="chooseAlumno.formacionvalores" class="form-control" :class="{'is-invalid': formValidate.disciplina}" name="po">
                                </div>
                                <div class="col-red" align="left" v-html="formValidate.formacionvalores"></div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float ">
                                <div class="form-line focused">
                                    <label class="form-label">
                                        <font color="red">*</font> ASISTENCIA
                                    </label>
                                    <input type="text" v-model="chooseAlumno.asistencia" class="form-control" :class="{'is-invalid': formValidate.disciplina}" name="po">
                                </div>
                                <div class="col-red" align="left" v-html="formValidate.asistencia"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float ">
                                <div class="form-line focused">
                                    <label class="form-label">
                                        <font color="red">*</font> PUNTUALIDAD
                                    </label>
                                    <input type="text" v-model="chooseAlumno.puntualidad" class="form-control" :class="{'is-invalid': formValidate.disciplina}" name="po">
                                </div>
                                <div class="col-red" align="left" v-html="formValidate.puntualidad"></div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float ">
                                <div class="form-line focused">
                                    <label class="form-label">
                                        <font color="red">*</font> DISCIPLINA
                                    </label>
                                    <input type="text" v-model="chooseAlumno.disciplina" class="form-control" :class="{'is-invalid': formValidate.disciplina}" name="po">
                                </div>
                                <div class="col-red" align="left" v-html="formValidate.disciplina"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float ">
                                <div class="form-line focused">
                                    <label class="form-label">
                                        <font color="red">*</font> PRESENTACION PERSONAL
                                    </label>
                                    <input type="text" v-model="chooseAlumno.presentacionpersonal" class="form-control" :class="{'is-invalid': formValidate.presentacionpersonal}" name="po">
                                </div>
                                <div class="col-red" align="left" v-html="formValidate.presentacionpersonal"></div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float ">
                                <div class="form-line focused">
                                    <label class="form-label">
                                        <font color="red">*</font> CONDUCTA
                                    </label>
                                    <input type="text" v-model="chooseAlumno.conducta" class="form-control" :class="{'is-invalid': formValidate.disciplina}" name="po">
                                </div>
                                <div class="col-red" align="left" v-html="formValidate.conducta"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float ">
                                <div class="form-line focused">
                                    <label class="form-label">
                                        <font color="red">*</font> RESPONSABILIDAD
                                    </label>
                                    <input type="text" v-model="chooseAlumno.responsabilidad" class="form-control" :class="{'is-invalid': formValidate.disciplina}" name="po">
                                </div>
                                <div class="col-red" align="left" v-html="formValidate.responsabilidad"></div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <div class="row">

                    <div class="col-md-12 col-sm-12 col-xs-12 " align="right">
                        <button type="button" class="btn btn-danger waves-effect waves-black" @click="clearAll"> <i class="fa fa-times"></i> Cancelar</button>
                        <button class="btn btn-primary waves-effect waves-black" @click="acutalizarDisciplina"><i class='fa fa-edit'></i> Modificar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<!--AGREGAR DISCIPLINA-->
<div class="modal fade" id="abrirAddModalDisciplina" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" align="left">
                <h4 class="modal-title" id="defaultModalLabel">ALUMNO(A): {{chooseAlumno.nombre}}</h4>
            </div>
            <div class="modal-body">
                <div style=" ">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <div class="col-red" v-html="formValidate.msgerror"></div>

                        </div>
                    </div>
                    <br />
                    <div class="row clearfix">
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float ">
                                <div class="form-line">
                                    <label class="form-label">
                                        <font color="red">*</font> FORMACION EN VALORES
                                    </label>
                                    <input type="text" v-model="newDisciplina.formacionvalores" class="form-control" :class="{'is-invalid': formValidate.disciplina}" name="po">
                                </div>
                                <div class="col-red" align="left" v-html="formValidate.formacionvalores"></div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float ">
                                <div class="form-line">
                                    <label class="form-label">
                                        <font color="red">*</font> ASISTENCIA
                                    </label>
                                    <input type="text" v-model="newDisciplina.asistencia" class="form-control" :class="{'is-invalid': formValidate.disciplina}" name="po">
                                </div>
                                <div class="col-red" align="left" v-html="formValidate.asistencia"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float ">
                                <div class="form-line">
                                    <label class="form-label">
                                        <font color="red">*</font> PUNTUALIDAD
                                    </label>
                                    <input type="text" v-model="newDisciplina.puntualidad" class="form-control" :class="{'is-invalid': formValidate.disciplina}" name="po">
                                </div>
                                <div class="col-red" align="left" v-html="formValidate.puntualidad"></div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float ">
                                <div class="form-line">
                                    <label class="form-label">
                                        <font color="red">*</font> DISCIPLINA
                                    </label>
                                    <input type="text" v-model="newDisciplina.disciplina" class="form-control" :class="{'is-invalid': formValidate.disciplina}" name="po">
                                </div>
                                <div class="col-red" align="left" v-html="formValidate.disciplina"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float ">
                                <div class="form-line">
                                    <label class="form-label">
                                        <font color="red">*</font> PRESENTACION PERSONAL
                                    </label>
                                    <input type="text" v-model="newDisciplina.presentacionpersonal" class="form-control" :class="{'is-invalid': formValidate.presentacionpersonal}" name="po">
                                </div>
                                <div class="col-red" align="left" v-html="formValidate.presentacionpersonal"></div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float ">
                                <div class="form-line">
                                    <label class="form-label">
                                        <font color="red">*</font> CONDUCTA
                                    </label>
                                    <input type="text" v-model="newDisciplina.conducta" class="form-control" :class="{'is-invalid': formValidate.disciplina}" name="po">
                                </div>
                                <div class="col-red" align="left" v-html="formValidate.conducta"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float ">
                                <div class="form-line">
                                    <label class="form-label">
                                        <font color="red">*</font> RESPONSABILIDAD
                                    </label>
                                    <input type="text" v-model="newDisciplina.responsabilidad" class="form-control" :class="{'is-invalid': formValidate.disciplina}" name="po">
                                </div>
                                <div class="col-red" align="left" v-html="formValidate.responsabilidad"></div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <div class="row">

                    <div class="col-md-12 col-sm-12 col-xs-12 " align="right">
                        <button class="btn btn-danger waves-effect waves-black" @click="clearAll"><i class='fa fa-ban'></i> Cancelar</button>
                        <button class="btn btn-primary waves-effect waves-black" @click="addDisciplina"><i class='fa fa-floppy-o'></i> Agregar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!--EDITAR CALIFICACION PREPA-->
<div class="modal fade" id="modalEditCalificacionPrepa" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" align="left">
                <h4 class="modal-title" id="defaultModalLabel"><i class="fa fa-user"></i> ALUMNO(A): {{chooseAlumno.nombre}}</h4>
                <h4 class="modal-title" id="defaultModalLabel"><i class="fa fa-book"></i> CURSO: {{chooseCalificacionPrepa.nombreclase}}</h4>
            </div>
            <div class="modal-body">
                <div style=" ">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <div class="col-red" v-html="formValidate.msgerror"></div>

                        </div>
                    </div>
                    <br />
                    <div class="row clearfix">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float ">
                                <div class="form-line focused">
                                    <label class="form-label">
                                        <font color="red">*</font> CALIFICACIÓN
                                    </label>
                                    <input type="text" v-model="chooseCalificacionPrepa.calificacion" class="form-control" :class="{'is-invalid': formValidate.calificacion}" name="po">
                                </div>
                                <div class="col-red" align="left" v-html="formValidate.calificacion"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="row">

                    <div class="col-md-12 col-sm-12 col-xs-12 " align="right">
                        <button class="btn btn-danger waves-effect waves-black" @click="cerrarVentaEditPrepa"><i class='fa fa-ban'></i> Cancelar</button>
                        <button class="btn btn-primary waves-effect waves-black" @click="acutalizarCalificacionPrepa"><i class='fa fa-floppy-o'></i> Modificar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--AGREGAR CALIFICACION PREPA-->
<div class="modal fade" id="modalAddCalificacionPrepa" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" align="left">
                <h4 class="modal-title" id="defaultModalLabel"><i class="fa fa-user"></i> ALUMNO(A): {{chooseAlumno.nombre}}</h4>
                <h4 class="modal-title" id="defaultModalLabel"><i class="fa fa-book"></i> CURSO: {{chooseCalificacionPrepa.nombreclase}}</h4>
            </div>
            <div class="modal-body">
                <div style=" ">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <div class="col-red" v-html="formValidate.msgerror"></div>

                        </div>
                    </div>
                    <br />
                    <div class="row clearfix">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float ">
                                <div class="form-line focused">
                                    <label class="form-label">
                                        <font color="red">*</font> CALIFICACIÓN
                                    </label>
                                    <input type="text" v-model="newCalificacionPrepa.calificacion" class="form-control" :class="{'is-invalid': formValidate.calificacion}" name="po">
                                </div>
                                <div class="col-red" align="left" v-html="formValidate.calificacion"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="row">

                    <div class="col-md-12 col-sm-12 col-xs-12 " align="right">
                        <button class="btn btn-danger waves-effect waves-black" @click="cerrarVentanaAddPrepa"><i class='fa fa-ban'></i> Cancelar</button>
                        <button class="btn btn-primary waves-effect waves-black" @click="addCalificacionPrepa"><i class='fa fa-floppy-o'></i> Agregar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<div class="modal fade" id="abrirModalCalificacionPS" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12 " align="left">
                        <h4 class="modal-title" id="defaultModalLabel">BOLETA DE CALIFICACIONES DE: {{chooseAlumno.nombre}}</h4>
                    </div>

                </div>
            </div>
            <div class="modal-body">
                <div style="padding-top:13px; padding-right:15px;">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <label style="color: red" v-html="formValidate.msgerror"></label>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <div v-if="mostrar_calificacion_tabla">
                                <table class=" table table-striped dt-responsive nowrap" cellspacing="0">
                                    <thead class="bg-teal">
                                        <th>CURSO</th>
                                        <th>CALIFICACIÓN</th>

                                        <th></th>
                                    </thead>
                                    <tbody>
                                        <tr v-for="row in calificaciones" v-if="row.mostrar == 'SI' && row.calificacion != '0.0' && row.totalcalificado != '0' ">
                                            <div>
                                                <td>{{row.nombreclase}}</td>
                                                <td>

                                                    <strong v-if="row.calificacion == '' || row.calificacion == 'null' || !row.calificacion">No registrado</strong>
                                                    <strong v-else>{{row.calificacion}}</strong>
                                                </td>

                                                <td align="right">

                                                    <button type="button" v-if="row.calificacion && (chooseAlumno.editar_calificacion &&  chooseAlumno.editar_calificacion == 'SI')" @click="eliminarCalificacionPrimaria();selectCalificacionPrimaria(row);" class="btn btn-danger btn-sm">Eliminar</button>
                                                    <button type="button" v-if="row.calificacion  && (chooseAlumno.editar_calificacion &&  chooseAlumno.editar_calificacion == 'SI')" @click="selectCalificacionPrimaria(row); abrirModalEditCalificacionPrimaria()" class="btn btn-info btn-sm">Modificar</button>
                                                    <button type="button" @click="abrirModalAddCalificacionPrimaria();selectCalificacionPrimaria(row); " v-if="(row.calificacion == '' || row.calificacion == 'null' || !row.calificacion)  && (chooseAlumno.editar_calificacion &&  chooseAlumno.editar_calificacion == 'SI')" class="btn btn-primary btn-sm">Agregar</button>
                                                </td>
                                            </div>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div v-if="cargando_calificacion_tabla" align="center">
                                <h4><i class="fa fa-spin fa-spinner"></i> Cargando calificaciones...</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="row">

                    <div class="col-md-12 col-sm-12 col-xs-12 " align="right">
                        <button type="button" class="btn btn-danger waves-effect waves-black" @click="clearAll"> <i class="fa fa-times"></i> Cancelar</button>
                        <a href="#" v-if="chooseAlumno.editar_diciplina == 'SI'" class="btn btn-default" v-bind:href="'descargarBoletaPDF/'+idperiodo+'/'+idgrupo+'/'+ chooseAlumno.idalumno">Descargar Boleta</a>
                        <a href="#" v-if="chooseAlumno.editar_diciplina == 'SI'" class="btn btn-default" v-bind:href="'descargarBoletaPDFNuevoFormato/'+idperiodo+'/'+idgrupo+'/'+ chooseAlumno.idalumno">Descargar Nueva Boleta</a>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--AGREGAR CALIFICACION PRIMARIA Y SECUNDARIA-->
<div class="modal fade" id="modalAddCalificacionPrimaria" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" align="left">
                <h4 class="modal-title" id="defaultModalLabel"><i class="fa fa-user"></i> ALUMNO(A): {{chooseAlumno.nombre}}</h4>
                <h4 class="modal-title" id="defaultModalLabel"><i class="fa fa-book"></i> CURSO: {{chooseCalificacionPrimaria.nombreclase}}</h4>
            </div>
            <div class="modal-body">
                <div style=" ">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 " align="left">
                            <div class="col-red" v-html="formValidate.msgerror"></div>

                        </div>
                    </div>
                    <br />
                    <div class="row clearfix">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float ">
                                <div class="form-line">
                                    <label class="form-label">
                                        <font color="red">*</font> CALIFICACIÓN
                                    </label>
                                    <input type="text" v-model="newCalificacionPrimaria.calificacion" class="form-control" :class="{'is-invalid': formValidate.calificacion}" name="po">
                                </div>
                                <div class="col-red" align="left" v-html="formValidate.calificacion"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="row">

                    <div class="col-md-12 col-sm-12 col-xs-12 " align="right">
                        <button class="btn btn-danger waves-effect waves-black" @click="cerrarVentanaAddPrimaria"><i class='fa fa-ban'></i> Cancelar</button>
                        <button class="btn btn-primary waves-effect waves-black" @click="addCalificacionPrimaria"><i class='fa fa-floppy-o'></i> Agregar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--EDITAR CALIFICACION PRIMARIA Y SECUNDARIA-->
<div class="modal fade" id="modalEditCalificacionPrimaria" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" align="left">
                <h4 class="modal-title" id="defaultModalLabel"><i class="fa fa-user"></i> ALUMNO(A): {{chooseAlumno.nombre}}</h4>
                <h4 class="modal-title" id="defaultModalLabel"><i class="fa fa-book"></i> CURSO: {{chooseCalificacionPrimaria.nombreclase}}</h4>
            </div>
            <div class="modal-body">
                <div style=" ">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <div class="col-red" v-html="formValidate.msgerror"></div>

                        </div>
                    </div>
                    <br />
                    <div class="row clearfix">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <div class="form-group form-float ">
                                <div class="form-line focused">
                                    <label class="form-label">
                                        <font color="red">*</font> CALIFICACIÓN
                                    </label>
                                    <input type="text" v-model="chooseCalificacionPrimaria.calificacion" class="form-control" :class="{'is-invalid': formValidate.calificacion}" name="po">
                                </div>
                                <div class="col-red" align="left" v-html="formValidate.calificacion"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="row">

                    <div class="col-md-12 col-sm-12 col-xs-12 " align="right">
                        <button class="btn btn-danger waves-effect waves-black" @click="cerrarVentanaEditPrimaria"><i class='fa fa-ban'></i> Cancelar</button>
                        <button class="btn btn-primary waves-effect waves-black" @click="actualizarCalificacionPrimaria"><i class='fa fa-floppy-o'></i> Modificar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="abrirModalCalificacionMateria" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12 " align="left">
                        <h4 class="modal-title" id="defaultModalLabel">BOLETA DE CALIFICACIONES DE: {{chooseAlumno.nombre}}</h4>
                    </div>

                </div>
            </div>
            <div class="modal-body">
                <div style="padding-top:13px; padding-right:15px;">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <label style="color: red" v-html="formValidate.msgerror"></label>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <div v-if="mostrar_calificacion_tabla">
                                <table class=" table table-striped dt-responsive nowrap" cellspacing="0">
                                    <thead class="bg-teal">
                                        <th>CURSO</th>
                                        <th>CALIFICACIÓN</th>
                                        <th></th>
                                    </thead>
                                    <tbody>
                                        <tr v-for="row in calificaciones" v-if="row.mostrar == 'SI' ">
                                            <div>
                                                <td>
                                                    <i class="fa fa-ban" style="color: red;" v-if="(chooseAlumno.quitar_materia == 'SI') && (row.idquitarmateria)"></i>
                                                    {{row.nombreclase}}
                                                </td>
                                                <td>
                                                    <strong v-if="row.calificacion == '' || row.calificacion == 'null' || !row.calificacion">No registrado</strong>
                                                    <strong v-else>{{row.calificacion}}</strong>
                                                </td>
                                                <td>
                                                    <button v-if="(chooseAlumno.quitar_materia == 'SI') && (!row.idquitarmateria)" @click="selectCalificacionQuitar(row);quitarMateria()" class="btn btn-danger">Quitar</button>
                                                    <button v-if="(chooseAlumno.quitar_materia == 'SI') && (row.idquitarmateria)" @click="selectCalificacionQuitar(row);reestablecerMateria()" class="btn btn-success">Agregar</button>
                                                </td>

                                            </div>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div v-if="cargando_calificacion_tabla" align="center">
                                <h4><i class="fa fa-spin fa-spinner"></i> Cargando calificaciones...</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="row">

                    <div class="col-md-12 col-sm-12 col-xs-12 " align="right">
                        <button type="button" class="btn btn-danger waves-effect waves-black" @click="clearAll"> <i class="fa fa-times"></i> Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="abrirModalCalificacionOportunidad" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12 " align="left">
                        <h4 class="modal-title" id="defaultModalLabel">BOLETA DE CALIFICACIONES DE: {{chooseAlumno.nombre}}</h4>
                    </div>

                </div>
            </div>
            <div class="modal-body">
                <div style="padding-top:13px; padding-right:15px;">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <label style="color: red" v-html="formValidate.msgerror"></label>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <div v-if="mostrar_calificacion_tabla">
                                <table class=" table table-striped dt-responsive nowrap" cellspacing="0">
                                    <thead class="bg-teal">
                                        <th>CURSO</th>
                                        <th>CALIFICACIÓN ANTERIOR</th>
                                        <th>{{chooseAlumno.nombreoportunidad}}</th>
                                    </thead>
                                    <tbody>
                                        <tr v-for="row in calificaciones" v-if="row.mostrar == 'SI' ">
                                            <div>
                                                <td>{{row.nombreclase}}</td>
                                                <td>
                                                    <strong v-if="row.calificacion == '' || row.calificacion == 'null' || !row.calificacion">No registrado</strong>
                                                    <strong v-else>{{row.calificacion}}</strong>
                                                </td>
                                                <td>
                                                    <div v-show="row.calificacionoportunidad == '' || row.calificacionoportunidad == 'null'|| row.calificacionoportunidad == null  ">

                                                        <div v-if="parseFloat(row.calificacion) < parseFloat(calificacionminima)">

                                                            <button class="btn btn-primary  waves-effect waves-black" data-toggle="modal" @click="selectCalificacionOportunidadPrepa(row);abrirModalAddCalificacionOportunidadPrepa();"><i class="fa fa-plus"></i> Agregar</button>
                                                        </div>
                                                        <div v-else>
                                                            <span class="label label-success">APROBADO</span>
                                                        </div>

                                                    </div>
                                                    <div v-show="!(row.calificacionoportunidad == '' || row.calificacionoportunidad == null|| row.calificacionoportunidad == 'null')">
                                                        <div v-if="parseFloat(row.calificacionoportunidad) < parseFloat(calificacionminima)">
                                                            <span class="label label-danger">{{row.calificacionoportunidad}}</span> <a title="CAMBIAR" href="#" @click="selectCalificacionOportunidadPrepa(row);abrirModalEditCalificacionOportunidadPrepa()"><i class="fa fa-pencil-square-o fa-sm"></i></a> | <a href="#" title="ELIMINAR" @click="selectCalificacionOportunidadPrepa(row);eliminarCalificacionOportunidadPrepa()"><i class="fa fa-trash" style="color: red;"></i></a>
                                                        </div>
                                                        <div v-else>
                                                            <span class="label label-success">{{row.calificacionoportunidad}}</span> <a title="CAMBIAR" href="#" @click="selectCalificacionOportunidadPrepa(row);abrirModalEditCalificacionOportunidadPrepa()"><i class="fa fa-pencil-square-o fa-sm"></i></a> | <a href="#" title="ELIMINAR" @click="selectCalificacionOportunidadPrepa(row);eliminarCalificacionOportunidadPrepa()"><i class="fa fa-trash" style="color: red;"></i></a>
                                                        </div>
                                                    </div>
                                                </td>


                                            </div>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div v-if="cargando_calificacion_tabla" align="center">
                                <h4><i class="fa fa-spin fa-spinner"></i> Cargando calificaciones...</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="row">

                    <div class="col-md-12 col-sm-12 col-xs-12 " align="right">
                        <button type="button" class="btn btn-danger waves-effect waves-black" @click="clearAll"> <i class="fa fa-times"></i> Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--AGREGAR CALIFICACION POR OPORTUNIDADES PREPA-->
<div class="modal fade " id="modalAddCalificacionOportunidadPrepa2" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel"><i class="fa fa-user"></i> ALUMNO(A): {{chooseAlumno.nombre}}</h4>
                <h4 class="modal-title" id="defaultModalLabel"><i class="fa fa-book"></i> CURSO: {{chooseCalificacionOportunidadPrepa.nombreclase}}</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12 ">
                        <div class="col-red" v-html="formValidate.msgerror"></div>

                    </div>
                </div>
                <br />
                <div class="row clearfix">
                    <div class="col-md-12 col-sm-12 col-xs-12 ">
                        <div class="form-group form-float ">
                            <div class="form-line focused">
                                <label class="form-label">
                                    <font color="red">*</font> CALIFICACIÓN
                                </label>
                                <input type="text" v-model="newCalificacionOportunidadPrepa.calificacion" class="form-control" :class="{'is-invalid': formValidate.calificacion}" name="po">
                            </div>
                            <div class="col-red" align="left" v-html="formValidate.calificacion"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger waves-effect waves-black" @click="cerrarVentanaAddOportunidadPrepa"><i class='fa fa-ban'></i> Cancelar</button>
                <button class="btn btn-primary waves-effect waves-black" @click="addCalificacionOportunidadPrepa"><i class='fa fa-floppy-o'></i> Agregar</button>
            </div>

        </div>
    </div>
</div>

<!--AGREGAR CALIFICACION POR OPORTUNIDADES PREPA-->
<div class="modal fade " id="modalEditCalificacionOportunidadPrepa2" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel"><i class="fa fa-user"></i> ALUMNO(A): {{chooseAlumno.nombre}}</h4>
                <h4 class="modal-title" id="defaultModalLabel"><i class="fa fa-book"></i> CURSO: {{chooseCalificacionOportunidadPrepa.nombreclase}}</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12 ">
                        <div class="col-red" v-html="formValidate.msgerror"></div>

                    </div>
                </div>
                <br />
                <div class="row clearfix">
                    <div class="col-md-12 col-sm-12 col-xs-12 ">
                        <div class="form-group form-float ">
                            <div class="form-line focused">
                                <label class="form-label">
                                    <font color="red">*</font> CALIFICACIÓN
                                </label>
                                <input type="text" v-model="chooseCalificacionOportunidadPrepa.calificacionoportunidad" class="form-control" :class="{'is-invalid': formValidate.calificacion}" name="po">
                            </div>
                            <div class="col-red" align="left" v-html="formValidate.calificacionoportunidad"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger waves-effect waves-black" @click="cerrarVentanaEditOportunidadPrepa"><i class='fa fa-ban'></i> Cancelar</button>
                <button class="btn btn-primary waves-effect waves-black" @click="editCalificacionOportunidadPrepa"><i class='fa fa-edit'></i> Modificar</button>
            </div>

        </div>
    </div>
</div>