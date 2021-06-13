var this_js_script = $("script[src*=apppagos]");
var my_var_1 = this_js_script.attr("data-my_var_1");
if (typeof my_var_1 === "undefined") {
  var my_var_1 = "some_default_value";
}
Vue.config.devtools = true;
Vue.component("v-select", VueSelect.VueSelect);
//Vue.use(VeeValidate);
Vue.use(VeeValidate, {
  classes: true, // Sí queremos que ponga clases automáticamente
  // Indicar qué clase poner al input en caso de que sea
  // válido o inválido. Usamos Bootstrap 4
  classNames: {
    valid: "is-valid",
    invalid: "is-invalid"
  },
  // Podría ser blur, change, etcétera. Si está vacío
  // entonces se tiene que validar manualmente
  events: "change|blur|keyup"
});
VeeValidate.Validator.localize("es");
var vcon = new Vue({
  el: "#app",

  data: {
    url: my_var_1,
    addModal: false,
    editModal: false,
    cargando: false,
    error: false,
    perfil: false,
    loading: false,
    divmensaje: false,
    divmesajeDetallePago: false,
    btnpagar: false,
    mensajeDetallePago: "",
    mensaje: "",
    inputalumno: true,
    total: 0,
    totalapagar: 0,
    totalpagado: 0,
    alumnos: [],
    formapagos: [],
    pagosalumno: [],
    array_pago_detalle: [],
    array_forma_pago: [],
    array_descuento_fijo: [],
    array_descuento_porcentaje: [],
    establecer_porcentaje_descuento: "Establecer",
    establecer_fijo_descuento: "Establecer",
    newFormaPago: {
      descuento: "",
      numautorizacion: "",
      idformapago: ""
    },
    newDescuento: {
      descuento: ""
    },
    newDescuentoPorcentaje: {
      descuento: ""
    },
    visiblemsgerror: false,
    msgerror: "",
    detalleAlumno: [],
    chooseAlumno: {},
    formValidate: [],
    successMSG: "",
    events: "change|blur|keyup"
  },
  created() {
    this.showAllAlumnos();
    this.showAllFormaPago();
    this.iniciales();
    this.habilitarBoton();
  },
  methods: {
    iniciales() {
      if (vcon.newDescuento.descuento != "") {
        vcon.establecer_fijo_descuento = vcon.newDescuento.descuento;
      }
      if (vcon.newDescuentoPorcentaje.descuento != "") {
        vcon.establecer_porcentaje_descuento = vcon.newDescuentoPorcentaje.descuento + "%";
      }
    },

    habilitarBoton() {
      if (vcon.total > 0 && vcon.totalapagar == 0) {
        vcon.btnpagar = true;
      } else {
        vcon.btnpagar = false;
      }
    },
    abrirModalDescuentoFijo() {
      if (vcon.total > 0) {
        $("#addDescuentoFijo").modal("show");
      } else {
        //vcon.divmensaje = true;
        // vcon.mensaje = "Total deber ser mayor a 0";
        Swal({type: "info", title: "Información", text: "El total a pagar deber ser mayor a $0.00"});
        //swal({position: "center", type: "success", title: "Exito!", showConfirmButton: false, timer: 2000});
        //swal({icon: "error", title: "Informació", text: "Es total a pagar deber ser mayor a $0.00"});
      }
    },
    abrirModalDescuentoPorcentaje() {
      if (vcon.total > 0) {
        $("#addDescuentoPorcentaje").modal("show");
      } else {
        //vcon.divmensaje = true;
        // vcon.mensaje = "Total deber ser mayor a 0";
        Swal({type: "info", title: "Información", text: "El total a pagar deber ser mayor a $0.00"});
        //swal({position: "center", type: "success", title: "Exito!", showConfirmButton: false, timer: 2000});
        //swal({icon: "error", title: "Informació", text: "Es total a pagar deber ser mayor a $0.00"});
      }
    },
    showAllAlumnos() {
      axios.get(this.url + "Pago/showAllAlumnos/").then(response => (this.alumnos = response.data.alumnos));
    },
    showAllFormaPago() {
      axios.get(this.url + "Pago/showAllFormaPago/").then(response => (this.formapagos = response.data.formapagos));
    },
    selectAlumno(alumno) {
      vcon.chooseAlumno = alumno;
    },
    updateTotalEliminarArray(index) {
      var item = vcon.array_pago_detalle.slice(index, 1);
      console.log(item);
      //vcon.total = vcon.total - parseFloat(item[0].descuento);
    },
    deleteItemFormaPago(index) {
      item = vcon.array_forma_pago[index];
      vcon.totalpagado = parseFloat(vcon.totalpagado).toFixed(2) - parseFloat(item.descuento).toFixed(2);
      vcon.totalapagar = parseFloat(vcon.totalapagar) + parseFloat(item.descuento);
      vcon.array_forma_pago.splice(index, 1);
      vcon.habilitarBoton();
    },
    deleteItem(index) {
      //var item = vcon.array_pago_detalle.slice(index, 1);
      //vcon.total = vcon.total - parseFloat(item[0].descuento);
      //console.log(index);
      //console.log(vcon.array_pago_detalle);
      //console.log(vcon.array_pago_detalle[index]);
      item = vcon.array_pago_detalle[index];
      //console.log(parseFloat(item.descuento.toFixed(2)));
      vcon.total = parseFloat(vcon.total.toFixed(2)) - parseFloat(item.total.toFixed(2));
      vcon.totalapagar = parseFloat(vcon.totalapagar.toFixed(2)) - parseFloat(item.total.toFixed(2));
      vcon.array_pago_detalle.splice(index, 1);
      if (vcon.establecer_porcentaje_descuento != "Establecer") {
        var descuento_porcentaje = 0;
        var subtotal = 0;
        vcon.array_descuento_porcentaje = [];
        for (var a = 0, l = vcon.array_pago_detalle.length; a < l; a++) {
          descuento_porcentaje += vcon.array_pago_detalle[a].total;
          subtotal += vcon.array_pago_detalle[a].descuento;
        }
        var forma_pago = {
          opcion: 1,
          concepto: vcon.establecer_porcentaje_descuento,
          descuento: parseFloat(subtotal - descuento_porcentaje).toFixed(2)
        };
        vcon.array_descuento_porcentaje.push(forma_pago);
      }

      if (vcon.array_pago_detalle.length == 0) {
        vcon.clearAll();
      }
      //var eliminado = vcon.array_pago_detalle.splice(index, 1);
    },

    quitarAlumno() {
      vcon.inputalumno = true;
      vcon.array_pago_detalle = [];
      vcon.perfil = false;
      vcon.pagosalumno = [];
      vcon.total = 0;
      vcon.totalapagar = 0;
      vcon.clearAll();
      vcon.iniciales();
    },
    changedLabel(event) {
      //console.log(event.idalumno);

      vcon.array_pago_detalle = [];
      axios.get(this.url + "Pago/pagosAlumno/", {
        params: {
          idalumno: event.idalumno
        }
      }).then(response => (this.pagosalumno = response.data));
      axios.get(this.url + "Pago/detalleAlumno/", {
        params: {
          idalumno: event.idalumno
        }
      }).then(response => (this.detalleAlumno = response.data.alumno));
      vcon.perfil = true;
      vcon.inputalumno = false;
    },
    agregarDescuentoFijo() {
      this.$validator.validateAll("form2").then(isValid => {
        if (isValid) {
          var descuento = vcon.validarNumeroEntero(vcon.newDescuento.descuento);
          console.log(descuento);
          if (descuento < vcon.totalapagar) {
            vcon.array_descuento_fijo = [];
            var forma_pago = {
              opcion: 0,
              concepto: "Descuento Fijo",
              descuento: descuento
            };
            vcon.totalapagar = vcon.totalapagar - parseFloat(descuento);
            vcon.total = vcon.total - parseFloat(descuento);
            vcon.array_descuento_fijo.push(forma_pago);
            vcon.cerrarDescuentoFijo();
            vcon.iniciales();
          } else {
            Swal({type: "info", title: "Información", text: "El descuento debe ser menor o igual al total a pagar."});
          }
        }
      });
    },
    agregarDescuentoPorcentaje() {
      this.$validator.validateAll("form3").then(isValid => {
        if (isValid) {
          vcon.array_descuento_porcentaje = [];
          var descuento = vcon.validarNumeroEntero(vcon.newDescuentoPorcentaje.descuento);
          var subtotal = 0;
          var total_descuento_fijo = 0;
          for (var e = 0, l = vcon.array_descuento_fijo.length; e < l; e++) {
            total_descuento_fijo += vcon.array_descuento_fijo[e].descuento;
          }
          var total = 0;
          for (var i = 0, l = vcon.array_pago_detalle.length; i < l; i++) {
            //ES LA PRIMERA VEZ CON DESCUENTO GLOBAL
            vcon.array_pago_detalle[i].descuentoporcentajeglobal = descuento;
            vcon.array_pago_detalle[i].descuentoporcentajeindividual = 0;
            var nuevodescuento = descuento;
            var descuento_real = vcon.array_pago_detalle[i].descuento - this.descuentoPorcentaje(vcon.array_pago_detalle[i].descuento, nuevodescuento);
            vcon.array_pago_detalle[i].total = parseFloat(descuento_real);
            total += parseFloat(descuento_real);
            subtotal += parseFloat(vcon.array_pago_detalle[i].descuento);
          }
          vcon.total = parseFloat(total).toFixed(2) - total_descuento_fijo;
          var forma_pago = {
            opcion: 1,
            concepto: nuevodescuento + "%",
            descuento: subtotal - parseFloat(total).toFixed(2)
          };
          vcon.array_descuento_porcentaje.push(forma_pago);
          var total_pagado = 0;
          for (var a = 0, l = vcon.array_forma_pago.length; a < l; a++) {
            total_pagado += vcon.array_forma_pago[a].descuento;
          }
          if (total_pagado > 0) {
            vcon.totalapagar = parseFloat(total_pagado) - (parseFloat(total).toFixed(2) - total_descuento_fijo);
          } else {
            vcon.totalapagar = parseFloat(total).toFixed(2) - total_descuento_fijo;
          }
          vcon.cerrarDescuentoPorcentaje();
          vcon.iniciales();
        }
      });
    },
    agregarDetalleFormaPago() {
      this.divmesajeDetallePago = false;
      this.mensajeDetallePago = "";
      this.$validator.validateAll("form1").then(isValid => {
        if (isValid) {
          this.divmesajeDetallePago = false;
          this.mensajeDetallePago = "";
          var descuento = vcon.validarNumeroEntero(vcon.newFormaPago.descuento);
          var idformapago = vcon.newFormaPago.idformapago.idtipopago;
          var formapago = vcon.newFormaPago.idformapago.nombretipopago;
          var numautorizacion = vcon.newFormaPago.numautorizacion;
          if (vcon.totalapagar <= 0) {
            if (parseFloat(vcon.newFormaPago.descuento) <= vcon.totalapagar) {
              var forma_pago = {
                idformapago: idformapago,
                formapago: formapago,
                descuento: descuento,
                numautorizacion: numautorizacion
              };
              vcon.array_forma_pago.push(forma_pago);
              vcon.totalpagado = vcon.totalpagado + parseFloat(vcon.newFormaPago.descuento);
              vcon.totalapagar = vcon.totalapagar - parseFloat(vcon.newFormaPago.descuento);
            } else {
              Swal({type: "info", title: "Información", text: "La cantidad  deber ser menor o igual al total a pagar."});
              //vcon.visiblemsgerror = true;
              //vcon.msgerror = "El total a pagar debe ser igual.";
            }
          } else {
            Swal({type: "info", title: "Información", text: "El total a pagar deber ser mayor a $0.00"});
          }
          vcon.iniciales();
          vcon.habilitarBoton();
        }
      });
    },
    changedAdd(event) {
      if (event.idconcepto == 3) {
        //Es colegiatura
        const resultado = vcon.array_pago_detalle.find(row => row.idmes === event.idmes);
        if (resultado === undefined) {
          // No exite la mensualidad registrada
          var forma_pago = {
            id: this.aleatorio(1, 200),
            idconcepto: event.idconcepto,
            concepto: event.concepto,
            descuento: parseFloat(event.descuento),
            descuentoporcentajeindividual: 0,
            descuentoporcentajeglobal: 0,
            total: parseFloat(event.descuento),
            idmes: event.idmes,
            nombremes: event.nombremes
          };
          //creamos la variable personas, con la variable nombre y apellidos
          vcon.total = vcon.total + parseFloat(event.descuento);
          vcon.totalapagar = vcon.totalapagar + parseFloat(event.descuento);
          vcon.array_pago_detalle.push(forma_pago); //añadimos el la variable persona al array
        }
      } else {
        const resultado = vcon.array_pago_detalle.find(row => row.idconcepto === event.idconcepto);
        if (resultado === undefined) {
          // No exite el concepto registrado
          var forma_pago = {
            id: this.aleatorio(1, 200),
            idconcepto: event.idconcepto,
            concepto: event.concepto,
            descuento: parseFloat(event.descuento),
            descuentoporcentajeindividual: 0,
            descuentoporcentajeglobal: 0,
            total: parseFloat(event.descuento),
            idmes: event.idmes,
            nombremes: event.nombremes
          };
          //creamos la variable personas, con la variable nombre y apellidos
          vcon.total = vcon.total + parseFloat(event.descuento);
          vcon.totalapagar = vcon.totalapagar + parseFloat(event.descuento);
          vcon.array_pago_detalle.push(forma_pago); //añadimos el la variable persona al array
        }
      }
      vcon.iniciales();
    },
    quitarDescuentoFijo() {
      vcon.total = vcon.total + parseFloat(vcon.newDescuento.descuento);
      vcon.totalapagar = vcon.totalapagar + parseFloat(vcon.newDescuento.descuento);
      // $("#addDescuentoFijo").modal("hide");
      vcon.formValidate = false;
      vcon.array_descuento_fijo = [];
      var total = 0;
      var totalapagar = 0;
      //var descuentoporcentaje = 0;
      var nuevodescuento = 0;
      vcon.array_pago_detalle.forEach(element => {
        //total = total + element.descuento;
        //totalapagar = totalapagar + element.descuento;
        if (element.descuentoporcentajeindividual > 0) {
          nuevodescuento += element.total;
        } else if (element.descuentoporcentajeglobal > 0) {
          nuevodescuento += element.total;
        } else {
          total = total + element.descuento;
          totalapagar = totalapagar + element.descuento;
        }
      });
      vcon.total = total + nuevodescuento;
      vcon.totalapagar = totalapagar + nuevodescuento;
      console.log(nuevodescuento);
    },
    cerrarDescuentoFijo() {
      $("#addDescuentoFijo").modal("hide");
      vcon.formValidate = false;
    },
    cerrarDescuentoPorcentaje() {
      $("#addDescuentoPorcentaje").modal("hide");
      vcon.formValidate = false;
    },
    descuentoPorcentaje(cantidad, porcentahe) {
      return Math.floor(cantidad * porcentahe) / 100;
    },
    validarDecimal(numero) {
      resultado = false;
      var decimal = /^[-+]?[0-9]+\.[0-9]+$/;
      console.log(numero);
      if (numero.match(decimal)) {
        resultado = true;
      } else {
        resultado = false;
      }
    },
    validarNumeroEntero(numero) {
      resultado = 0;
      if (numero % 1 == 0) {
        var numerotemporal = parseFloat(numero + ".00");
        return (resultado = numerotemporal);
        //return true;
      } else {
        return (resultado = numero);
      }
    },
    clearAll() {
      vcon.newDescuento = {
        descuento: ""
      };
      vcon.newDescuentoPorcentaje = {
        descuento: ""
      };
      vcon.array_descuento_fijo = [];
      vcon.array_descuento_porcentaje = [];
      vcon.array_forma_pago = [];
      vcon.establecer_porcentaje_descuento = "Establecer";
      vcon.establecer_fijo_descuento = "Establecer";
      vcon.totalapagar = 0;
      vcon.total = 0;
    },
    aleatorio(min, max) {
      var num = Math.floor(Math.random() * (max - min + 1)) + min;
      return num;
    }
  }
});
