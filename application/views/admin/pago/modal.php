<div class="modal fade" id="addDescuentoFijo" tabindex="-1" role="dialog">
    <div class="modal-dialog  " role="document">
        <div class="modal-content">
            <form data-vv-scope="form2">
                <div class="modal-header">
                    <h4 class="modal-title" id="smallModalLabel">MONTO FIJO</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <label class="form-label">
                                        <font color="red">*</font> DESCUENTO
                                    </label>
                                    <input type="text" class="form-control" v-validate="'required|decimal:2'" name="Descuento" v-model="newDescuento.descuento" autcomplete="off">
                                </div>
                                <div class="invalid-feedback col-red">
                                    {{errors.first('form2.Descuento')}}
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="row">

                        <div class="col-md-12 col-sm-12 col-xs-12 " align="right">
                            <a href="#" class="btn btn-default waves-effect waves-black" @click="cerrarDescuentoFijo()"><i class='fa fa-ban'></i> Cerrar</a>
                            <a href="#" class="btn btn-danger waves-effect waves-black" @click="quitarDescuentoFijo()"><i class='fa fa-times'></i> Quitar</a>
                            <a href="#" class="btn btn-success waves-effect waves-black" @click="agregarDescuentoFijo"><i class='fa fa-check'></i> Agregar</a>
                        </div>
                    </div>
                </div>

            </form>

        </div>
    </div>
</div>

<div class="modal fade" id="addDescuentoPorcentaje" tabindex="-1" role="dialog">
    <div class="modal-dialog  " role="document">
        <div class="modal-content">
            <form data-vv-scope="form3">
                <div class="modal-header">
                    <h4 class="modal-title" id="smallModalLabel">DESCUENTO PORCENTAJE</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <label class="form-label">
                                        <font color="red">*</font> DESCUENTO
                                    </label>
                                    <input type="text" class="form-control" v-validate="'required|decimal:2'" name="Descuento" v-model="newDescuentoPorcentaje.descuento" autcomplete="off">
                                </div>
                                <div class="invalid-feedback col-red">
                                    {{errors.first('form3.Descuento')}}
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="row">

                        <div class="col-md-12 col-sm-12 col-xs-12 " align="right">
                            <a href="#" class="btn btn-default waves-effect waves-black" @click="cerrarDescuentoFijo()"><i class='fa fa-ban'></i> Cerrar</a>
                            <a href="#" class="btn btn-danger waves-effect waves-black" @click="quitarDescuentoFijo()"><i class='fa fa-times'></i> Quitar</a>
                            <a href="#" class="btn btn-success waves-effect waves-black" @click="agregarDescuentoPorcentaje"><i class='fa fa-check'></i> Agregar</a>
                        </div>
                    </div>
                </div>

            </form>

        </div>
    </div>
</div>