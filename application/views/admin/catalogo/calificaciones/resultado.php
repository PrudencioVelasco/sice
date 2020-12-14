<!-- page content -->
<style>
    ul {
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
                        <div class="row" align="center">

                            <form method="POST" action="<?= base_url(), 'Calificacion/buscar' ?>">
                                <div class="row">
                                    <div class="col-md-3 col-sm-12 col-xs-12 ">
                                        <div class="form-group">
                                            <select style="border-bottom: solid #ebebeb 2px;" name="cicloescolar" required="" class="form-control">
                                                <option value="">-- CICLO ESCOLAR --</option>
                                                <?php
                                                if (isset($periodos) && !empty($periodos)) {
                                                    foreach ($periodos as $value) {
                                                        echo  '<option value="' . $value->idperiodo . '">' . $value->mesinicio . ' - ' . $value->mesfin . ' ' . $value->yearfin . '</option>';
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12 col-xs-12 ">
                                        <div class="form-group">
                                            <select style="border-bottom: solid #ebebeb 2px;" name="grupo" class="form-control">
                                                <option value="">-- GRUPO --</option>
                                                <?php
                                                if (isset($grupos) && !empty($grupos)) {
                                                    foreach ($grupos as $value) {
                                                        echo  '<option value="' . $value->idgrupo . '">' . $value->nivelgrupo . ' - ' . $value->nombregrupo . '</option>';
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12 col-xs-12 ">
                                        <div class="form-group">
                                            <select style="border-bottom: solid #ebebeb 2px;" name="tiporeporte" class="form-control">
                                                <option value="">-- TIPO DE REPORTE --</option>
                                                <option value="2">PROMEDIO FINAL</option>
                                                <option value="4">CALIFICACIÓN POR MATERIA</option>
                                                <?php
                                                if (isset($unidades) && !empty($unidades)) {
                                                    foreach ($unidades as $row) {
                                                        echo '<option value="u' . $row->idunidad . '">' . $row->nombreunidad . '</option>';
                                                    }
                                                }
                                                if (isset($oportunidades) && !empty($oportunidades)) {
                                                    foreach ($oportunidades as $row) {
                                                        echo '<option value="o' . $row->idoportunidadexamen . '">' . $row->nombreoportunidad . '</option>';
                                                    }
                                                }
                                                if ($this->session->idniveleducativo == 1 || $this->session->idniveleducativo == 2) {
                                                    if (isset($meses) && !empty($meses)) {
                                                        foreach ($meses as $row) {
                                                            echo '<option value="m' . $row->idmes . '">' . $row->nombremes . '</option>';
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
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12 ">
                                <?php echo $tabla; ?>
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

<div class="modal fade" id="modalAddCalificacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title " id="myModalLabel">
                    ALUMNO(A): <label id="alumno_calificacion_add"></label>
                </h3>
            </div>
            <form method="post" action="" id="frmaddcalificacion">
                <div class="modal-body">
                    <div class="form-group">
                        <input class="form-control idalumno" type="hidden" name="idalumno">
                        <input class="form-control idhorario" type="hidden" name="idhorario"> <input class="form-control idhorariodetalle" type="hidden" name="idhorariodetalle"> <input class="form-control idmes" type="hidden" name="idmes">
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group">
                                <label>
                                    <font color="red">*</font> Unidad
                                </label> <select class="form-control" style="border: solid 1px #ccc" name="unidad">
                                    <option value="">SELECCIONAR</option>
                                    <?php
                                    if (isset($unidades) && !empty($unidades)) {
                                        foreach ($unidades as $unidad) {
                                            echo '<option value="' . $unidad->idunidad . '">' . $unidad->nombreunidad . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="form-group">
                                <label>
                                    <font color="red">*</font> Mes
                                </label> <input type="text" name="mes" style="border: solid 1px #ccc; padding-left: 5px;" class="form-control nombremes" value="" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <div class="form-group">
                                <label>
                                    <font color="red">*</font> Calificación
                                </label> <input type="text" style="border-bottom: solid 1px #ccc; border-top: solid 1px #ccc; border-left: solid 1px #ccc; border-right: solid 1px #ccc; padding: 0 5px 0 5px;" class="form-control" name="calificacion">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">
                        <i class="fa fa-times"></i> CERRAR
                    </button>
                    <button type="button" id="btnaddcalificacion" class="btn btn-primary">
                        <i class="fa fa-plus-circle"></i> AGREGAR
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalAddCalificacionPrepa" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title " id="myModalLabel">
                    ALUMNO(A): <label id="alumno_calificacion_add_prepa"></label>
                </h3>
            </div>
            <form method="post" action="" id="frmaddcalificacionprepa">
                <div class="modal-body">
                    <div class="form-group">
                        <input class="form-control idalumno" type="hidden" name="idalumno">
                        <input class="form-control idhorario" type="hidden" name="idhorario">
                        <input class="form-control idhorariodetalle" type="hidden" name="idhorariodetalle">
                        <input class="form-control idunidad" type="hidden" name="idunidad">
                        <input class="form-control idoportunidadexamen" type="hidden" name="idoportunidadexamen">
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <div class="form-group">
                                <label>
                                    <font color="red">*</font> Calificación
                                </label> <input type="text" style="border-bottom: solid 1px #ccc; border-top: solid 1px #ccc; border-left: solid 1px #ccc; border-right: solid 1px #ccc; padding: 0 5px 0 5px;" class="form-control" name="calificacion">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">
                        <i class="fa fa-times"></i> CERRAR
                    </button>
                    <button type="button" id="btnaddcalificacionprepa" class="btn btn-primary">
                        <i class="fa fa-plus-circle"></i> AGREGAR
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditCalificacionPrepa" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title " id="myModalLabel">
                    ALUMNO(A): <label id="alumno_calificacion_edit_prepa"></label>
                </h3>
            </div>
            <form method="post" action="" id="frmeditcalificacionprepa">
                <div class="modal-body">
                    <div class="form-group">
                        <input class="form-control idcalificacion" type="hidden" name="idcalificacion">
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <div class="form-group">
                                <label>
                                    <font color="red">*</font> Calificación
                                </label> <input type="text" style="border-bottom: solid 1px #ccc; border-top: solid 1px #ccc; border-left: solid 1px #ccc; border-right: solid 1px #ccc; padding: 0 5px 0 5px;" class="form-control calificacion" name="calificacion">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">
                        <i class="fa fa-times"></i> CERRAR
                    </button>
                    <button type="button" id="btneditcalificacionprepa" class="btn btn-primary">
                        <i class="fa fa-pencil"></i> MODIFICAR
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalDeleteCalificacionPrepa" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title " id="myModalLabel">
                    ALUMNO(A): <label id="alumno_calificacion_delete_prepa"></label>
                </h3>
            </div>
            <form method="post" action="" id="frmdeletecalificacionprepa">
                <div class="modal-body">
                    <div class="form-group">
                        <input class="form-control idcalificacion" type="hidden" name="idcalificacion">
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <h4>Esta seguro que desea eliminar la Calificación?</h4>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">
                        <i class="fa fa-times"></i> CERRAR
                    </button>
                    <button type="button" id="btndeletecalificacionprepa" class="btn btn-primary">
                        <i class="fa fa-trash"></i> ELIMINAR
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditCalificacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title " id="myModalLabel">ALUMNO(A): <label id="alumno_calificacion_edit"></label> </h3>
            </div>
            <form method="post" action="" id="frmeditarcalificacion">
                <div class="modal-body">
                    <div class="form-group">
                        <input class="form-control idcalificacion" type="hidden" name="idcalificacion">
                        <input class="form-control iddetallecalificacion" type="hidden" name="iddetallecalificacion">
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <div class="form-group">
                                <label>
                                    <font color="red">*</font> Calificación
                                </label>
                                <input type="text" style="border-bottom: solid 1px #ccc; border-top: solid 1px #ccc; border-left: solid 1px #ccc; border-right: solid 1px #ccc; padding: 0 5px 0 5px;" class="form-control calificacion" name="calificacion">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i>
                        CERRAR</button>
                    <button type="button" id="btneditarcalificacion" class="btn btn-primary"><i class="fa fa-pencil"></i>
                        MODIFICAR</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="modalAddFaltas" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title " id="myModalLabel">ALUMNO(A): <label id="alumno_faltas_add"></label> </h3>
            </div>
            <form method="post" action="" id="frmaddfaltas">
                <div class="modal-body">
                    <div class="form-group">
                        <input class="form-control idcalificacion" type="hidden" name="idcalificacion">
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <div class="form-group">
                                <label>
                                    <font color="red">*</font> Faltas
                                </label>
                                <input type="number" style="border-bottom: solid 1px #ccc; border-top: solid 1px #ccc; border-left: solid 1px #ccc; border-right: solid 1px #ccc; padding: 0 5px 0 5px;" class="form-control" name="faltas">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i>
                        CERRAR</button>
                    <button type="button" id="btnaddfaltas" class="btn btn-primary"><i class="fa fa-plus-circle"></i>
                        AGREGAR</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalAddOtrasEvaluaciones" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title " id="myModalLabel">ALUMNO(A): <label id="alumno_diciplina_add"></label> </h3>
            </div>
            <form method="post" action="" id="frmagregardisciplina">
                <div class="modal-body">
                    <div class="form-group">
                        <input class="form-control idhorario" type="hidden" name="idhorario">
                        <input class="form-control idalumno" type="hidden" name="idalumno">
                        <input class="form-control idunidad" type="hidden" name="idunidad">
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <div class="form-group">
                                <label>
                                    <font color="red">*</font> DISCIPLINA
                                </label>
                                <input type="text" style="border-bottom: solid 1px #ccc; border-top: solid 1px #ccc; border-left: solid 1px #ccc; border-right: solid 1px #ccc; padding: 0 5px 0 5px;" class="form-control" name="disciplina">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <div class="form-group">
                                <label>
                                    <font color="red">*</font> PRESENTACIÓN PERSONAL
                                </label>
                                <input type="text" style="border-bottom: solid 1px #ccc; border-top: solid 1px #ccc; border-left: solid 1px #ccc; border-right: solid 1px #ccc; padding: 0 5px 0 5px;" class="form-control" name="presentacionpersonal">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i>
                        CERRAR</button>
                    <button type="button" id="btnagregardiciplina" class="btn btn-primary"><i class="fa fa-plus-circle"></i>
                        AGREGAR</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditOtrasEvaluaciones" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title " id="myModalLabel">ALUMNO(A): <label id="alumno_diciplina_edit"></label> </h3>
            </div>
            <form method="post" action="" id="frmeditardisciplina">
                <div class="modal-body">
                    <div class="form-group">
                        <input class="form-control iddisciplina" type="hidden" name="iddisciplina">
                        <input class="form-control idpresentacionpersonal" type="hidden" name="idpresentacionpersonal">
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <div class="form-group">
                                <label>
                                    <font color="red">*</font> DISCIPLINA
                                </label>
                                <input type="text" style="border-bottom: solid 1px #ccc; border-top: solid 1px #ccc; border-left: solid 1px #ccc; border-right: solid 1px #ccc; padding: 0 5px 0 5px;" class="form-control disciplina" name="disciplina">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <div class="form-group">
                                <label>
                                    <font color="red">*</font> PRESENTACIÓN PERSONAL
                                </label>
                                <input type="text" style="border-bottom: solid 1px #ccc; border-top: solid 1px #ccc; border-left: solid 1px #ccc; border-right: solid 1px #ccc; padding: 0 5px 0 5px;" class="form-control presentacionpersonal" name="presentacionpersonal">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i>
                        CERRAR</button>
                    <button type="button" id="btneditardiciplina" class="btn btn-primary"><i class="fa fa-pencil"></i>
                        MODIFICAR</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalAddRetardo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title " id="myModalLabel">ALUMNO(A): <label id="alumno_retardo_add"></label> </h3>
            </div>
            <form method="post" action="" id="frmaddretardo">
                <div class="modal-body">
                    <div class="form-group">
                        <input class="form-control idcalificacion" type="hidden" name="idcalificacion">
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <div class="form-group">
                                <label>
                                    <font color="red">*</font> Retardo
                                </label>
                                <input type="number" style="border-bottom: solid 1px #ccc; border-top: solid 1px #ccc; border-left: solid 1px #ccc; border-right: solid 1px #ccc; padding: 0 5px 0 5px;" class="form-control" name="retardo">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i>
                        CERRAR</button>
                    <button type="button" id="btnaddretardo" class="btn btn-primary"><i class="fa fa-plus-circle"></i>
                        AGREGAR</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditFaltas" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title " id="myModalLabel">ALUMNO(A): <label id="alumno_faltas_add"></label> </h3>
            </div>
            <form method="post" action="" id="frmmodificarfaltas">
                <div class="modal-body">
                    <div class="form-group">
                        <input class="form-control id" type="hidden" name="id">
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <div class="form-group">
                                <label>
                                    <font color="red">*</font> Faltas
                                </label>
                                <input type="number" style="border-bottom: solid 1px #ccc; border-top: solid 1px #ccc; border-left: solid 1px #ccc; border-right: solid 1px #ccc; padding: 0 5px 0 5px;" class="form-control faltas" name="faltas">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i>
                        CERRAR</button>
                    <button type="button" id="btnmodificarfaltas" class="btn btn-primary"><i class="fa fa-pencil"></i>
                        MODIFICAR</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id=modalEditRetardo tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title " id="myModalLabel">ALUMNO(A): <label id="alumno_retardo_edit"></label> </h3>
            </div>
            <form method="post" action="" id="frmmodificarretardo">
                <div class="modal-body">
                    <div class="form-group">
                        <input class="form-control id" type="hidden" name="id">
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <div class="form-group">
                                <label>
                                    <font color="red">*</font> Retardo
                                </label>
                                <input type="number" style="border-bottom: solid 1px #ccc; border-top: solid 1px #ccc; border-left: solid 1px #ccc; border-right: solid 1px #ccc; padding: 0 5px 0 5px;" class="form-control retardo" name="retardo">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i>
                        CERRAR</button>
                    <button type="button" id="btnmodificarretardo" class="btn btn-primary"><i class="fa fa-pencil"></i>
                        MODIFICAR</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="myModalDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title " id="myModalLabel">ALUMNO: <label id="alumnodelete"></label> </h3>
            </div>
            <form method="post" action="" id="frmeliminar">
                <div class="modal-body">
                    <div class="alert alert-danger print-error-msg" style="display:none"></div>
                    <div class="alert alert-success print-success-msg" style="display:none"></div>
                    <div class="form-group">
                        <input class="form-control idcalificacion" type="hidden" name="idcalificacion">
                        <input class="iddetallecalificacion" type="hidden" name="iddetallecalificacion" />
                    </div>
                    <div class="form-group">
                        <label>
                            <h3>Esta seguro de Eliminar la Calificación?</h3>
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i>
                        Cerrar</button>
                    <button type="button" id="btneliminar" class="btn btn-primary"><i class="fa fa-trash"></i>
                        Eliminar</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script data-my_var_1="<?php echo base_url() ?>" src="<?php echo base_url(); ?>/assets/js/validar/Administrar/calificacion.js"></script>

<div id="custom_notifications" class="custom-notifications dsp_none">
    <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
    </ul>
    <div class="clearfix"></div>
    <div id="notif-group" class="tabbed_notifications"></div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#tablageneralcal').DataTable({
            "order": [],
            "columnDefs": [{
                "targets": 'no-sort',
                "orderable": false
            }],
            keys: true,
            "scrollX": true,
            dom: 'Bfrtip',
            buttons: [
                'excelHtml5'
            ],
            "language": {
                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Ningún dato disponible en esta tabla",
                "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix": "",
                "sSearch": "Buscar:",
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            }
        });

    });
</script>