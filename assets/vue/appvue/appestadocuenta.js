
var this_js_script = $('script[src*=appestadocuenta]');
var my_var_1 = this_js_script.attr('data-my_var_1');
if (typeof my_var_1 === "undefined") {
    var my_var_1 = 'some_default_value';
}
var my_var_2 = this_js_script.attr('data-my_var_2');
if (typeof my_var_2 === "undefined") {
    var my_var_2 = 'some_default_value';
}
var my_var_3 = this_js_script.attr('data-my_var_3');
if (typeof my_var_3 === "undefined") {
    var my_var_3 = 'some_default_value';
}


Vue.config.devtools = true 
var ve = new Vue({
    el: '#appestadocuenta',
    data: {
        url: my_var_1,
        idalumno: my_var_2,
        idrol: my_var_3,
        addModal: false,
        addPagoModal: false,
        editModal: false,

        mostrar_condonar: false,
        checkbox_condonar: '',

        eliminarModalP: false,
        eliminarModalC: false,
        mostrar: false,
        mostrar_error: false,
        noresultado: false,
        noresultadoinicio: false,
        addPagoColegiaturaModal: false,
        btnpagar: false,
        btnbuscar: true,
        loaging_buscar: false,
        cargando: false,
        error: false,
        mostar_error_formapago: false,
        error_formapago: '',
        btnpagarcolegiatura: false,
        //deleteModal:false, 
        ciclos: [],
        pagos: [],
        formaspago: [],
        solicitudes: [],
        tipospago: [],
        meses: [],
        search: {text: ''},
        emptyResult: false,

        error_pago: false,
        array_formapago: '',
        array_descuento: '',
        array_autorizacion: '',
        array_pago_colegiatura: [],

        total_que_debe_pagar_inscripcion: 0.00,
        total_que_debe_pagar_reinscripcion: 0.00,
        total_que_debe_pagar_colegiatura: 0.00,
        newBuscarCiclo: {
            idalumno: my_var_2,
            idperiodo: '',
            msgerror: ''},
        newCobroInicio: {
            idalumno: my_var_2,
            descuento: '',
            autorizacion: '',
            idtipopagocol: '',
            idformapago: '',
        },
        newCobroColegiatura: {
            idalumno: my_var_2,
            descuento: '',
            idmes: '',
            autorizacion: '',
            idformapago: '',
            coleccionMeses: []
        },
        eliminarPrimerCobro: {
            usuario: '',
            password: '',
        },
        eliminarColegiatura: {
            usuario: '',
            password: '',
        },
        newCobro: {
            idformapago: '',
            autorizacion: '',
            idperiodo: '',

            idalumno: my_var_2,
            idamortizacion: '',
            msgerror: ''},
        chooseSolicitud: {},
        choosePrimerPago: {},
        choosePeriodo: {},
        formValidate: [],
        idperiodobuscado: '',
        successMSG: '',
    },
    created() {
        this.showAllTutoresDisponibles();
        this.showAllFormasPago();
        this.showAllTiposPago();
        //this.showAllMeses();
        this.verficarCondonar();
    },
    methods: {
        abrirAddModalPrincipal() {
            $('#addCobroPrincipal').modal('show');
        },
        abrirAddModalColegiatura() {
            $('#addCobroColegiatura').modal('show');
        },
        abrirEliminarPrincipal() {
            $('#eliminarPrincipal').modal('show');
        },
        abrirEliminarColegiatura() {
            $('#eliminarColegiatura').modal('show');
        },
        verficarCondonar() {
            if ((this.idrol == 13) || (this.idrol == 14)) {
                this.mostrar_condonar = true;
            }
        },
        agregar_forma_pago_colegiatura() {
            ve.mostar_error_formapago = false;
            ve.error_pago = false;
            ve.error_formapago = "";
            ve.msgerror = '';
            ve.formValidate = false;
            ve.error = false;
            if (ve.array_formapago != '' && ve.array_descuento != '') {
                if (ve.validatCantidad(ve.array_descuento)) {
                    if (ve.array_formapago == 2) {
                        if (ve.array_autorizacion != "") {
                            var forma_pago = {idformapago: ve.array_formapago, descuento: ve.array_descuento, autorizacion: ve.array_autorizacion} //creamos la variable personas, con la variable nombre y apellidos
                            ve.array_pago_colegiatura.push(forma_pago);//añadimos el la variable persona al array
                            //Limpiamos los campos
                            ve.array_formapago = "";
                            ve.array_descuento = "";
                            ve.array_autorizacion = "";
                            ve.msgerror = '';
                            ve.formValidate = false;
                        } else {
                            ve.mostar_error_formapago = true;
                            ve.error_pago = false;
                            ve.error_formapago = "Número de Autorización.";
                            ve.error = false;
                            ve.msgerror = '';
                            ve.formValidate = false;
                        }
                    } else {
                        var forma_pago = {idformapago: ve.array_formapago, descuento: ve.array_descuento, autorizacion: ve.array_autorizacion} //creamos la variable personas, con la variable nombre y apellidos
                        ve.array_pago_colegiatura.push(forma_pago);//añadimos el la variable persona al array
                        //Limpiamos los campos
                        ve.array_formapago = "";
                        ve.array_descuento = "";
                        ve.array_autorizacion = "";
                        ve.msgerror = '';
                        ve.formValidate = false;
                    }
                } else {
                    ve.mostar_error_formapago = true;
                    ve.error_formapago = "El total a pagar no debe de contener (,).";
                    ve.error_pago = false;
                    ve.error = false;
                    ve.msgerror = '';
                    ve.formValidate = false;
                }


            } else {
                ve.mostar_error_formapago = true;
                ve.error_formapago = "Forma de pago y Total a pagar son requeridos."
                ve.error_pago = false;
            }
        },
        deleteItem(index) {
            ve.array_pago_colegiatura.splice(index, 1);
        },
        validatCantidad(cantidad) {
            //var re = new RegExp("/^[+]?([0-9]+(?:[\.][0-9]*)?|\.[0-9]+)$/");
            if (cantidad.match(/^[+]?([0-9]+(?:[\.][0-9]*)?|\.[0-9]+)$/)) {
                return true;
            } else {
                return false;
            }
        },
        searchSolicitud() {
            ve.loaging_buscar = true;
            ve.btnbuscar = false;
            if (this.$refs.idperiodo.value != "") {
                this.mostrar = true;
                ve.mostrar_error = false;
                ve.btnbuscar = false;
                ve.loaging_buscar = true;
                ve.idperiodobuscado = this.$refs.idperiodo.value;
                axios.get(this.url + "EstadoCuenta/estadoCuenta/", {
                    params: {
                        idperiodo: this.$refs.idperiodo.value,
                        idalumno: my_var_2
                    }
                }).then(function (response) {

                    if (response.data == '') {
                        ve.solicitudes = null;
                        ve.noresultado = true;
                        ve.dBuscandoAbtnbuscar();
                    } else {
                        ve.solicitudes = response.data
                        ve.noresultado = false;
                        ve.dBuscandoAbtnbuscar();
                    }
                });

                axios.get(this.url + "EstadoCuenta/pagosInicio/", {
                    params: {
                        idperiodo: this.$refs.idperiodo.value,
                        idalumno: my_var_2
                    }
                }).then(function (response) {
                    if (response.data.pagos == null) {
                        ve.pagos = null;
                        ve.noresultadoinicio = true;
                        ve.btnpagar = true;
                        ve.dBuscandoAbtnbuscar();
                    } else {

                        ve.pagos = response.data.pagos
                        ve.noresultadoinicio = false;
                        ve.btnpagar = false;
                        ve.dBuscandoAbtnbuscar();
                    }
                });

                axios.get(this.url + "EstadoCuenta/showAllMeses/", {
                    params: {
                        idperiodo: this.$refs.idperiodo.value,
                        idalumno: my_var_2
                    }
                }).then(function (response) {
                    //console.log(response.data);
                    if (response.data.meses == null) {
                        ve.dBuscandoAbtnbuscar();
                        ve.btnpagarcolegiatura = false;

                    } else {
                        ve.meses = response.data.meses
                        ve.btnpagarcolegiatura = true;
                        ve.dBuscandoAbtnbuscar();

                    }
                });


                axios.get(this.url + "EstadoCuenta/descuentoPagoInicioInscripcion/", {
                    params: {
                        idperiodo: this.$refs.idperiodo.value,
                        idalumno: my_var_2
                    }
                }).then(function (response) {
                    if (response.data.pagoinscripcion == null) {
                        ve.dBuscandoAbtnbuscar();
                    } else {
                        ve.dBuscandoAbtnbuscar();
                        ve.total_que_debe_pagar_inscripcion = response.data.pagoinscripcion;
                    }
                });
                axios.get(this.url + "EstadoCuenta/descuentoPagoInicioReinscripcion/", {
                    params: {
                        idperiodo: this.$refs.idperiodo.value,
                        idalumno: my_var_2
                    }
                }).then(function (response) {
                    if (response.data.pagoreinscripcion == null) {
                        ve.dBuscandoAbtnbuscar();
                    } else {
                        ve.dBuscandoAbtnbuscar();
                        ve.total_que_debe_pagar_reinscripcion = response.data.pagoreinscripcion;
                    }
                });
                axios.get(this.url + "EstadoCuenta/descuentoPagoColegiatura/", {
                    params: {
                        idperiodo: this.$refs.idperiodo.value,
                        idalumno: my_var_2
                    }
                }).then(function (response) {
                    if (response.data.pagocolegiatura == null) {
                        ve.dBuscandoAbtnbuscar();
                    } else {
                        ve.dBuscandoAbtnbuscar();
                        ve.total_que_debe_pagar_colegiatura = response.data.pagocolegiatura;
                    }
                });

                //ve.idperiodobuscado = this.$refs.idperiodo.value;
                //then(response => (this.solicitudes = response.data))  

            } else {
                ve.mostrar_error = true;
                ve.btnbuscar = true;
                ve.loaging_buscar = false;
            }

        },
        estadocuentaAll() {
            axios.get(this.url + "EstadoCuenta/estadoCuenta/", {
                params: {
                    idperiodo: ve.idperiodobuscado,
                    idalumno: my_var_2
                }
            }).then(function (response) {

                if (response.data == '') {
                    ve.solicitudes = null;
                    ve.noresultado = true;
                } else {
                    ve.solicitudes = response.data
                    ve.noresultado = false;
                }
            });

            axios.get(this.url + "EstadoCuenta/pagosInicio/", {
                params: {
                    idperiodo: ve.idperiodobuscado,
                    idalumno: my_var_2
                }
            }).then(function (response) {
                if (response.data.pagos == null) {
                    ve.pagos = null;
                    ve.noresultadoinicio = true;
                    ve.btnpagar = true;
                } else {
                    ve.pagos = response.data.pagos
                    ve.noresultadoinicio = false;
                    ve.btnpagar = false;
                }
            });
            axios.get(this.url + "EstadoCuenta/showAllMeses/", {
                params: {
                    idperiodo: ve.idperiodobuscado,
                    idalumno: my_var_2
                }
            }).then(function (response) {
                if (response.data.meses == null) {

                } else {
                    ve.meses = response.data.meses

                }
            });
        },
        showAllTutoresDisponibles() {

            axios.get(this.url + "EstadoCuenta/showAllCicloEscolar/")
                    .then(response => (this.ciclos = response.data.ciclos));

        },
        showAllFormasPago() {

            axios.get(this.url + "EstadoCuenta/showAllFormasPago/")
                    .then(response => (this.formaspago = response.data.formaspago));

        },
        showAllTiposPago() {

            axios.get(this.url + "EstadoCuenta/showAllTipoPago/")
                    .then(response => (this.tipospago = response.data.tipospago));

        },
        dBuscandoAbtnbuscar() {
            ve.btnbuscar = true;
            ve.loaging_buscar = false;
        },
        showAllMeses() {

            axios.get(this.url + "EstadoCuenta/showAllMeses/")
                    .then(response => (this.meses = response.data.meses));

        },
        selectPeriodo(solicitud) {
            ve.chooseSolicitud = solicitud;

        },
        selectPrimerPago(row) {
            ve.choosePrimerPago = row;

        },
        formData(obj) {
            var formData = new FormData();
            for (var key in obj) {
                formData.append(key, obj[key]);
            }
            return formData;
        },
        addCobro() {
            ve.error = false;
            ve.cargando = true;
            var formData = v.formData(ve.newCobro);
            formData.append('abono', ve.chooseSolicitud.descuento);
            formData.append('idamortizacion', ve.chooseSolicitud.idamortizacion);
            // for (var value of formData.values()) {
            //                  console.log(value); 
            //               }
            axios.post(this.url + "EstadoCuenta/addCobro", formData).then(function (response) {
                if (response.data.error) {
                    ve.formValidate = response.data.msg;
                    ve.error = true;
                    ve.cargando = false;
                } else {
                    swal({
                        position: 'center',
                        type: 'success',
                        title: 'Exito!',
                        showConfirmButton: false,
                        timer: 2000
                    });

                    ve.clearAll();
                    ve.estadocuentaAll();
                }
            })
        },
        addCobroColegiatura() {
            ve.error_pago = false;
            ve.error = false;
            ve.msgerror = '';
            ve.formValidate = false;
            ve.cargando = true;
            ve.mostar_error_formapago = false;
            if (ve.array_pago_colegiatura.length > 0) {
                ve.error = false;
                //ve.cargando = true;
                var formData = v.formData(ve.newCobroColegiatura);
                formData.append('idperiodo', ve.idperiodobuscado);
                formData.append('idalumno', ve.idalumno);
                formData.append('formapago', JSON.stringify(ve.array_pago_colegiatura));
                formData.append('meseapagar', JSON.stringify(ve.newCobroColegiatura.coleccionMeses));
                formData.append('condonar', ve.checkbox_condonar);

                for (var value of formData.values()) {
                    // console.log(value); 
                }
                axios.post(this.url + "EstadoCuenta/addCobroColegiatura", formData).then(function (response) {
                    if (response.data.error) {
                        ve.formValidate = response.data.msg;
                        ve.error = true;
                        ve.cargando = false;
                    } else {
                        swal({
                            position: 'center',
                            type: 'success',
                            title: 'Exito!',
                            showConfirmButton: false,
                            timer: 2000
                        });

                        ve.clearAll();
                        ve.estadocuentaAll();
                    }
                })
            } else {
                ve.cargando = false;
                ve.error_pago = true;
            }
        },
        eliminarPagoInicio() {
            ve.error = false;
            ve.cargando = true;
            var formData = v.formData(ve.eliminarPrimerCobro);
            formData.append('idpago', ve.choosePrimerPago.idpago);
            formData.append('formapago', JSON.stringify(ve.array_pago_colegiatura));
            formData.append('condonar', ve.checkbox_condonar);
            axios.post(this.url + "EstadoCuenta/eliminarPrimerCobro", formData).then(function (response) {
                if (response.data.error) {
                    ve.formValidate = response.data.msg;
                    ve.error = true;
                    ve.cargando = false;
                } else {
                    swal({
                        position: 'center',
                        type: 'success',
                        title: 'Exito!',
                        showConfirmButton: false,
                        timer: 2000
                    });

                    ve.clearAll();
                    ve.estadocuentaAll();
                }
            })
        },
        eliminarPagoColegiatura() {
            ve.error = false;
            ve.cargando = true;
            var formData = v.formData(ve.eliminarColegiatura);
            formData.append('idpago', ve.chooseSolicitud.idpago);
            axios.post(this.url + "EstadoCuenta/eliminarColegiatura", formData).then(function (response) {
                if (response.data.error) {
                    ve.formValidate = response.data.msg;
                    ve.error = true;
                    ve.cargando = false;
                } else {
                    swal({
                        position: 'center',
                        type: 'success',
                        title: 'Exito!',
                        showConfirmButton: false,
                        timer: 2000
                    });

                    ve.clearAll();
                    ve.estadocuentaAll();
                }
            })
        },
        addCobroInicio() {
            ve.error_pago = false;
            ve.error = false;
            ve.msgerror = '';
            ve.formValidate = false;
            ve.cargando = true;
            ve.mostar_error_formapago = false;
            if (ve.array_pago_colegiatura.length > 0) {
                ve.error = false;
                var formData = v.formData(ve.newCobroInicio);
                formData.append('idperiodobuscado', ve.idperiodobuscado);
                formData.append('idalumno', ve.idalumno);
                formData.append('formapago', JSON.stringify(ve.array_pago_colegiatura));
                formData.append('condonar', ve.checkbox_condonar);
                // for (var value of formData.values()) {
                //                  console.log(value); 
                //               }
                axios.post(this.url + "EstadoCuenta/addCobroInicio", formData).then(function (response) {
                    if (response.data.error) {
                        ve.formValidate = response.data.msg;
                        ve.error = true;
                        ve.cargando = false;
                    } else {
                        swal({
                            position: 'center',
                            type: 'success',
                            title: 'Exito!',
                            showConfirmButton: false,
                            timer: 2000
                        });

                        ve.clearAll();
                        ve.estadocuentaAll();

                    }
                });
            } else {
                ve.cargando = false;
                ve.error_pago = true;
            }
        },
        clearAll() {
            $('#addCobroPrincipal').modal('hide');
            $('#addCobroColegiatura').modal('hide');
            $('#eliminarPrincipal').modal('hide');
            $('#eliminarColegiatura').modal('hide');
            ve.formValidate = false;
            ve.addModal = false;
            ve.addPagoModal = false;
            ve.eliminarModalP = false;
            ve.eliminarModalC = false;
            ve.addPagoColegiaturaModal = false;
            ve.error = false;
            ve.cargando = false;
            ve.array_pago_colegiatura = [];
            ve.mostar_error_formapago = true;
            ve.error_pago = false;
            ve.checkbox_condonar = '';
            ve.eliminarPrimerCobro = {
                usuario: '',
                password: '',
                msgerror: ''
            },
                    ve.eliminarColegiatura = {
                        usuario: '',
                        password: '',
                        msgerror: ''
                    },
                    ve.newCobroInicio = {
                        //idalumno: ve.my_var_2,
                        descuento: '',
                        autorizacion: '',
                        idtipopagocol: '',
                        idformapago: '',
                    },
                    ve.newCobroColegiatura = {
                        //idalumno: ve.my_var_2,
                        idmes: '',
                        descuento: '',
                        autorizacion: '',
                        idformapago: '',
                        coleccionMeses: []

                    },
                    ve.newCobro = {
                        idformapago: '',
                        autorizacion: '',
                        idperiodo: '',
                        //idalumno: ve.my_var_2,
                        idamortizacion: '',
                        msgerror: ''
                    }
        }
    }
});
