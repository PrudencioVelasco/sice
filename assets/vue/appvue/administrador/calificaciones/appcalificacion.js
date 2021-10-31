var this_js_script = $("script[src*=appcalificacion]");
var my_var_1 = this_js_script.attr("data-my_var_1");
if (typeof my_var_1 === "undefined") {
  var my_var_1 = "some_default_value";
}
var my_var_2 = this_js_script.attr("data-my_var_2");
if (typeof my_var_2 === "undefined") {
  var my_var_2 = "some_default_value";
}
var my_var_3 = this_js_script.attr("data-my_var_3");
if (typeof my_var_3 === "undefined") {
  var my_var_3 = "some_default_value";
}

Vue.config.devtools = true;
var v = new Vue({
  el: "#app",
  components: {
    Multiselect: window.VueMultiselect.default
  },
  data: {
    url: my_var_1,
    idniveleducativo: my_var_3,
    cargando: false,
    btnbuscar2: true,
    btncargandobuscar2: false,
    mostrar_calificacion_tabla: false,
    cargando_calificacion_tabla: false,
    error: false,
    actadeevaluacion: false,
    //deleteModal:false, 
    periodos: [],
    idplantel: my_var_2,
    idperiodo: "",
    idgrupo: "",
    idtiporeporte: "",
    idalumno: "",
    calificacionminima: "",
    grupos: [],
    alumnos: [],
    materias: [],
    //materias: [],
    //materias_registradas: [],
    //materias_seleccionadas: [],
    //calificaciones_registradas: [],
    meses: [],
    value: [],
    unidades: [],
    oportunidades: [],
    calificaciones: [],
    //idtipocalificacion: "",
    //tiposcalificacion: [],
    search: {
      text: ""
    },
    emptyResult: false,
    newDisciplina: {
      idalumno: "",
      idhorario: "",
      idunidad: "",
      disciplina: "",
      presentacionpersonal: "",
      smserror: ""
    },
    newCalificacionPrepa: {
      calificacion: ""
    },
    newCalificacionOportunidadPrepa: {
      calificacion: ""
    },
    newCalificacionPrimaria: {
      calificacion: ""
    },
    //newFaltas: {
    //  totalfaltas: ""
    //},
    chooseAlumno: {},
    chooseAsistencia: {},
    chooseCalificacionPrepa: {},
    chooseCalificacionOportunidadPrepa: {},
    chooseCalificacionPrimaria: {},
    chooseCalificacionQuita: {},
    formValidate: [],
    successMSG: "",

    directives: {
      columnSortable
    }
  },
  created() {
    //this.showAll();
    //this.showAllMaterias();
    this.showAllTiposCalificacion();
    this.showAllPeriodos();
    this.showAllGrupos();
    this.showAllUnidades();
    this.showAllOportunidades();
    this.showAllMeses();
  },
  methods: {
    onSelect(option, id) { },
    orderBy(sortFn) {
      this.alumnos.sort(sortFn);
    },
    abrirAddModal() {
      $("#abrirModal").modal("show");
      // v.showAllMaterias(this.idgrupo);
    },
    abrirAModalCalificacionPS() {
      $("#abrirModalCalificacionPS").modal("show");
      // v.showAllMaterias(this.idgrupo);
    },
    abrirAModalCalificacionMateria() {
      $("#abrirModalCalificacionMateria").modal("show");
      // v.showAllMaterias(this.idgrupo);
    },
    abrirModalCalificacionesOportunidad() {
      $("#abrirModalCalificacionOportunidad").modal("show");
      // v.showAllMaterias(this.idgrupo);
    },
    abrirAddModalDisciplina() {
      $("#abrirAddModalDisciplina").modal("show");
      // v.showAllMaterias(this.idgrupo);
    },
    abrirModalAddCalificacionPrepa() {
      $("#modalAddCalificacionPrepa").modal("show");
    },
    abrirModalAddCalificacionOportunidadPrepa() {
      $("#modalAddCalificacionOportunidadPrepa2").modal("show");
    },
    abrirModalEditCalificacionOportunidadPrepa() {
      $("#modalEditCalificacionOportunidadPrepa2").modal("show");
    },
    abrirModalAddCalificacionPrimaria() {
      $("#modalAddCalificacionPrimaria").modal("show");
    },
    abrirModalEditCalificacionPrepa() {
      $("#modalEditCalificacionPrepa").modal("show");
    },
    abrirModalEditCalificacionPrimaria() {
      $("#modalEditCalificacionPrimaria").modal("show");
    },
    modalEditarDisciplina() {
      $("#modalEditarDisciplina").modal("show");
    },

    showCalificacionesAlumno() {
      v.mostrar_calificacion_tabla = false;
      v.cargando_calificacion_tabla = true;
      axios.get(this.url + "Calificacion/detalladoCalificaciones/", {
        params: {
          idalumno: v.chooseAlumno.idalumno,
          idhorario: v.chooseAlumno.idhorario,
          idunidad: v.chooseAlumno.idunidad
        }
      }).then(response => (this.calificaciones = response.data.calificaciones)).finally(() => {
        v.mostrar_calificacion_tabla = true;
        v.cargando_calificacion_tabla = false;
      });
    },
    showCalificacionesPSAlumno() {
      v.mostrar_calificacion_tabla = false;
      v.cargando_calificacion_tabla = true;
      axios.get(this.url + "Calificacion/detalladoCalificacionesPS/", {
        params: {
          idalumno: v.chooseAlumno.idalumno,
          idhorario: v.chooseAlumno.idhorario,
          idmes: v.chooseAlumno.idmes
        }
      }).then(response => (this.calificaciones = response.data.calificaciones)).finally(() => {
        v.mostrar_calificacion_tabla = true;
        v.cargando_calificacion_tabla = false;
      });
    },
    showCalificacionesMateria() {
      v.mostrar_calificacion_tabla = false;
      v.cargando_calificacion_tabla = true;
      axios.get(this.url + "Calificacion/detalladoCalificacionesMateria/", {
        params: {
          idalumno: v.chooseAlumno.idalumno,
          idhorario: v.chooseAlumno.idhorario,
          idperiodo: v.chooseAlumno.idperiodo
        }
      }).then(response => (this.calificaciones = response.data.calificaciones)).finally(() => {
        v.mostrar_calificacion_tabla = true;
        v.cargando_calificacion_tabla = false;
      });
    },
    showCalificacionesOportunidad() {
      v.mostrar_calificacion_tabla = false;
      v.cargando_calificacion_tabla = true;
      axios.get(this.url + "Calificacion/detalladoCalificacionesOportunidad/", {
        params: {
          idalumno: v.chooseAlumno.idalumno,
          idhorario: v.chooseAlumno.idhorario,
          idperiodo: v.chooseAlumno.idperiodo,
          idoportunidad: v.chooseAlumno.idoportunidad
        }
      }).then(response => (this.calificaciones = response.data.calificaciones)).finally(() => {
        v.mostrar_calificacion_tabla = true;
        v.cargando_calificacion_tabla = false;
      });
    },
    obtenerCalificacionMinima() {
      axios.get(this.url + "Calificacion/obtenerCalificacionMinima/", {
        params: {
          idhorario: v.chooseAlumno.idhorario
        }
      }).then(response => (this.calificacionminima = response.data.calificacionminima)).finally(() => {

      });
    },
    showAllTiposCalificacion() {
      axios.get(this.url + "Calificacion/showAllTiposCalificacionPreescolar/").then(response => (this.tiposcalificacion = response.data.tiposcalificacion));
    },
    showAllPeriodos() {
      axios.get(this.url + "Calificacion/showAllPeriodos/").then(response => (this.periodos = response.data.periodos));
    },
    showAllGrupos() {
      axios.get(this.url + "Calificacion/showAllGrupos/").then(response => (this.grupos = response.data.grupos));
    },
    showAllUnidades() {
      axios.get(this.url + "Calificacion/unidadesv2/").then(response => (this.unidades = response.data.unidades));
    },
    showAllOportunidades() {
      axios.get(this.url + "Calificacion/oportunidadesv2/").then(response => (this.oportunidades = response.data.oportunidades));
    },
    showAllMeses() {
      axios.get(this.url + "Calificacion/showAllMeses/").then(response => (this.meses = response.data.meses));
    },
    seleccionarAlumno(idalumno) {
      this.idalumno = idalumno;
      v.materias_seleccionadas = [];
    },
    selectAlumnoAsistencia(alumno) {
      v.chooseAsistencia = alumno;
    },

    searchAlumnos() {
      //v.mostrar_calificacion_tabla = false;
      //v.cargando_calificacion_tabla = false;

      v.alumnos = [];
      var idtiporeporte = this.$refs.idtiporeporte.value;
      var idperiodo = this.$refs.idperiodo.value;
      var idgrupo = this.$refs.idgrupo.value;
      if (idtiporeporte != "" && idperiodo != "" && idperiodo != "") {
        v.btncargandobuscar2 = true;
        v.btnbuscar2 = false;
        this.idperiodo = idperiodo;
        this.idgrupo = idgrupo;
        this.idtiporeporte = idtiporeporte;
        if (idtiporeporte == 4) {
          v.actadeevaluacion = true;
          v.obtenerMaterias(idperiodo, idgrupo);
        } else {
          v.actadeevaluacion = false;
        }
        // v.obtenerMaterias(idperiodo, idgrupo);
        axios.get(this.url + "Calificacion/buscarCalificacionesv2/", {
          params: {
            idtiporeporte: idtiporeporte,
            idperiodo: idperiodo,
            idgrupo: idgrupo
          }
        }).then(response => (this.alumnos = response.data)).finally(() => {
          v.btnbuscar2 = true;
          v.btncargandobuscar2 = false;
        });
        //v.showAllMaterias(idgrupo);
      } else {
        v.btnbuscar2 = true;
        v.btncargandobuscar2 = false;
        swal("NOTIFICACIÓN", "SELECCIONE EL PERIODO, GRUPO Y TIPO DE REPORTE. ", "info");
      }
    },
    obtenerMaterias(idperiodo, idgrupo) {
      //v.actadeevaluacion = true;
      axios.get(this.url + "Calificacion/obtenerMateriasGrupo/", {
        params: {
          idperiodo: idperiodo,
          idgrupo: idgrupo
        }
      }).then(response => (this.materias = response.data.materias)).finally(() => {
        //v.btnbuscar2 = true;
        //v.btncargandobuscar2 = false;
      });
    },
    acutalizarDisciplina() {
      var formData = v.formData(v.chooseAlumno);
      axios.post(this.url + "Calificacion/editisciplinav2", formData).then(function (response) {
        if (response.data.error) {
          v.formValidate = response.data.msg;
          v.cargando = false;
          v.error = true;
        } else {
          //v.successMSG = response.data.success;
          v.clearAll();
          v.clearMSG();
          swal({ position: "center", type: "success", title: "Modificado!", showConfirmButton: false, timer: 1500 });
        }
      });
    },
    acutalizarCalificacionPrepa() {
      var formData = v.formData(v.chooseCalificacionPrepa);
      axios.post(this.url + "Calificacion/updateCalificacionAdminPrepav2", formData).then(function (response) {
        if (response.data.error) {
          v.formValidate = response.data.msg;
          v.cargando = false;
          v.error = true;
        } else {
          //v.successMSG = response.data.success;
          v.cerrarVentaEditPrepa();
          v.clearMSG();
          v.showCalificacionesAlumno();
          swal({ position: "center", type: "success", title: "Modificado!", showConfirmButton: false, timer: 1500 });
        }
      });
    },
    actualizarCalificacionPrimaria() {
      var formData = v.formData(v.chooseCalificacionPrimaria);
      axios.post(this.url + "Calificacion/updteCalificacionPrimariav2", formData).then(function (response) {
        if (response.data.error) {
          v.formValidate = response.data.msg;
          v.cargando = false;
          v.error = true;
        } else {
          //v.successMSG = response.data.success;
          v.showCalificacionesPSAlumno();
          v.cerrarVentanaEditPrimaria();
          v.clearMSG();
          swal({ position: "center", type: "success", title: "Modificado!", showConfirmButton: false, timer: 1500 });
        }
      });
    },
    eliminarCalificacionPrepa() {
      // console.log(v.chooseCalificacionPrepa.idcalificacion);
      Swal.fire({
        title: "Eliminar Calificacion?",
        text: "Realmente desea eliminar la Calificacion.",
        type: "question",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Eliminar",
        cancelButtonText: "Cancelar"
      }).then(result => {
        if (result.value) {
          axios.get(this.url + "Calificacion/deleteCalificacionAdminPrepav2", {
            params: {
              idcalificacion: v.chooseCalificacionPrepa.idcalificacion
            }
          }).then(function (response) {
            if (response.data.error == false) {
              swal({ position: "center", type: "success", title: "Eliminado!", showConfirmButton: false, timer: 1500 });
              v.showCalificacionesAlumno();
            } else {
              swal("Información", response.data.mensaje, "info");
              //v.showCalificacionesAlumno();
            }
          }).catch(error => {
            swal("Información", "No se puedo Eliminar la Calificacion..", "info");
            v.cargando = false;
          });
        }
      });
    },
    eliminarCalificacionPrimaria() {
      // console.log(v.chooseCalificacionPrepa.idcalificacion);
      Swal.fire({
        title: "Eliminar Calificacion?",
        text: "Realmente desea eliminar la Calificacion.",
        type: "question",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Eliminar",
        cancelButtonText: "Cancelar"
      }).then(result => {
        if (result.value) {
          axios.get(this.url + "Calificacion/deleteCalificacionPrimariav2", {
            params: {
              idcalificacion: v.chooseCalificacionPrimaria.idcalificacion,
              iddetallecalificacion: v.chooseCalificacionPrimaria.iddetallecalificacion
            }
          }).then(function (response) {
            if (response.data.error == false) {
              swal({ position: "center", type: "success", title: response.data.msg.mensaje, showConfirmButton: false, timer: 1500 });
              v.showCalificacionesPSAlumno();
            } else {
              swal("Información", response.data.mensaje, "info");
              //v.showCalificacionesAlumno();
              v.showCalificacionesPSAlumno();
            }
          }).catch(error => {
            swal("Información", "No se puedo Eliminar la Calificacion.", "info");
            v.cargando = false;
          });
        }
      });
    },
    quitarMateria() {
      // console.log(v.chooseCalificacionPrepa.idcalificacion);
      Swal.fire({
        title: "Quitar curso para calificar?",
        text: "Realmente desea quitar el curso.",
        type: "question",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Quitar",
        cancelButtonText: "Cancelar"
      }).then(result => {
        if (result.value) {
          axios.get(this.url + "Calificacion/quitarMateriaParaCalificar", {
            params: {
              idalumno: v.chooseCalificacionQuita.idalumno,
              idhorario: v.chooseCalificacionQuita.idhorario,
              idprofesormateria: v.chooseCalificacionQuita.idprofesormateria,
              idmateria: v.chooseCalificacionQuita.idmateria
            }
          }).then(function (response) {
            if (response.data.error == false) {
              swal({ position: "center", type: "success", title: "Quitado!", showConfirmButton: false, timer: 1500 });
              v.showCalificacionesMateria();
            } else {
              swal("Información", response.data.msg.mensaje, "info");
              //v.showCalificacionesAlumno();
            }
          }).catch(error => {
            swal("Información", "No se puedo quitar el curso.", "info");
            v.cargando = false;
          });
        }
      });
    },
    reestablecerMateria() {
      // console.log(v.chooseCalificacionPrepa.idcalificacion);
      Swal.fire({
        title: "Agregar curso para calificar?",
        text: "Realmente desea agregar el curso.",
        type: "question",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Agregar",
        cancelButtonText: "Cancelar"
      }).then(result => {
        if (result.value) {
          axios.get(this.url + "Calificacion/restablecerMateriaQuitada", {
            params: {
              idquitarmateria: v.chooseCalificacionQuita.idquitarmateria
            }
          }).then(function (response) {
            if (response.data.error == false) {
              swal({ position: "center", type: "success", title: "Agregado!", showConfirmButton: false, timer: 1500 });
              v.showCalificacionesMateria();
            } else {
              swal("Información", response.data.msg.mensaje, "info");
              //v.showCalificacionesAlumno();
            }
          }).catch(error => {
            swal("Información", "No se puedo quitar el curso.", "info");
            v.cargando = false;
          });
        }
      });
    },
    eliminarCalificacionOportunidadPrepa() {
      // console.log(v.chooseCalificacionPrepa.idcalificacion);
      Swal.fire({
        title: "Eliminar calificación?",
        text: "Realmente desea eliminar la calificación.",
        type: "question",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Eliminar",
        cancelButtonText: "Cancelar"
      }).then(result => {
        if (result.value) {
          axios.get(this.url + "Calificacion/eliminarCalificacionOportunidad", {
            params: {
              idcalificacion: v.chooseCalificacionOportunidadPrepa.idcalificacionoportunidad
            }
          }).then(function (response) {
            if (response.data.error == false) {
              swal({ position: "center", type: "success", title: "Eliminado!", showConfirmButton: false, timer: 1500 });
              //v.showCalificacionesMateria();
              v.showCalificacionesOportunidad();
            } else {
              swal("Información", response.data.msg.mensaje, "info");
              //v.showCalificacionesAlumno();
            }
          }).catch(error => {
            swal("Información", "No se puedo modificar la calificación.", "info");
            v.cargando = false;
          });
        }
      });
    },
    addDisciplina() {
      v.error = false;
      // var formData = v.formData();
      var formData = v.formData(v.newDisciplina);
      formData.append("idhorario", v.chooseAlumno.idhorario);
      formData.append("idunidad", v.chooseAlumno.idunidad);
      formData.append("idalumno", v.chooseAlumno.idalumno);
      axios.post(this.url + "Calificacion/addDisciplinav2", formData).then(function (response) {
        if (response.data.error) {
          v.formValidate = response.data.msg;
          v.error = true;
          v.cargando = false;
        } else {
          swal({ position: "center", type: "success", title: "Agregado!", showConfirmButton: false, timer: 1500 });
          v.searchAlumnos();
          v.clearAll();
          v.clearMSG();
        }
      });
    },
    addCalificacionPrepa() {
      v.error = false;
      // var formData = v.formData();
      var formData = v.formData(v.newCalificacionPrepa);
      formData.append("idhorario", v.chooseCalificacionPrepa.idhorario);
      formData.append("idhorariodetalle", v.chooseCalificacionPrepa.idhorariodetalle);
      formData.append("idunidad", v.chooseAlumno.idunidad);
      formData.append("idalumno", v.chooseAlumno.idalumno);
      axios.post(this.url + "Calificacion/addCalificacionAdminPrepav2", formData).then(function (response) {
        if (response.data.error) {
          v.formValidate = response.data.msg;
          v.error = true;
          v.cargando = false;
        } else {
          v.showCalificacionesAlumno();
          v.cerrarVentanaAddPrepa();
          v.clearMSG();
          swal({ position: "center", type: "success", title: "Agregado!", showConfirmButton: false, timer: 1500 });
        }
      });
    },
    addCalificacionOportunidadPrepa() {
      v.error = false;
      // var formData = v.formData();
      var formData = v.formData(v.newCalificacionOportunidadPrepa);
      formData.append("idhorario", v.chooseCalificacionOportunidadPrepa.idhorario);
      formData.append("idhorariodetalle", v.chooseCalificacionOportunidadPrepa.idhorariodetalle);
      formData.append("idoportunidadexamen", v.chooseAlumno.idoportunidad);
      formData.append("idalumno", v.chooseCalificacionOportunidadPrepa.idalumno);
      formData.append("idprofesormateria", v.chooseCalificacionOportunidadPrepa.idprofesormateria);
      axios.post(this.url + "Calificacion/addCalificacionAdminOportunidadPrepa", formData).then(function (response) {
        if (response.data.error) {
          v.formValidate = response.data.msg;
          v.error = true;
          v.cargando = false;
        } else {
          v.showCalificacionesOportunidad();
          v.cerrarVentanaAddOportunidadPrepa();
          v.clearMSG();
          swal({ position: "center", type: "success", title: "Agregado!", showConfirmButton: false, timer: 1500 });
        }
      });
    },
    addCalificacionOportunidadPrepa() {
      v.error = false;
      // var formData = v.formData();
      var formData = v.formData(v.newCalificacionOportunidadPrepa);
      formData.append("idhorario", v.chooseCalificacionOportunidadPrepa.idhorario);
      formData.append("idhorariodetalle", v.chooseCalificacionOportunidadPrepa.idhorariodetalle);
      formData.append("idoportunidadexamen", v.chooseAlumno.idoportunidad);
      formData.append("idalumno", v.chooseCalificacionOportunidadPrepa.idalumno);
      formData.append("idprofesormateria", v.chooseCalificacionOportunidadPrepa.idprofesormateria);
      axios.post(this.url + "Calificacion/addCalificacionAdminOportunidadPrepa", formData).then(function (response) {
        if (response.data.error) {
          v.formValidate = response.data.msg;
          v.error = true;
          v.cargando = false;
        } else {
          v.showCalificacionesOportunidad();
          v.cerrarVentanaAddOportunidadPrepa();
          v.clearMSG();
          swal({ position: "center", type: "success", title: "Agregado!", showConfirmButton: false, timer: 1500 });
        }
      });
    },
    editCalificacionOportunidadPrepa() {
      v.error = false;
      // var formData = v.formData();
      var formData = v.formData(v.chooseCalificacionOportunidadPrepa);
      axios.post(this.url + "Calificacion/editCalificacionAdminOportunidadPrepa", formData).then(function (response) {
        if (response.data.error) {
          v.formValidate = response.data.msg;
          v.error = true;
          v.cargando = false;
        } else {
          v.showCalificacionesOportunidad();
          v.cerrarVentanaEditOportunidadPrepa();
          v.clearMSG();
          swal({ position: "center", type: "success", title: "Modificado!", showConfirmButton: false, timer: 1500 });
        }
      });
    },
    addCalificacionPrimaria() {
      v.error = false;
      // var formData = v.formData();
      var formData = v.formData(v.newCalificacionPrimaria);
      formData.append("idhorario", v.chooseCalificacionPrimaria.idhorario);
      formData.append("idhorariodetalle", v.chooseCalificacionPrimaria.idhorariodetalle);
      formData.append("idmes", v.chooseAlumno.idmes);
      formData.append("idalumno", v.chooseAlumno.idalumno);
      axios.post(this.url + "Calificacion/addCalificacionAdminPSv2", formData).then(function (response) {
        if (response.data.error) {
          v.formValidate = response.data.msg;
          v.error = true;
          v.cargando = false;
        } else {
          v.showCalificacionesPSAlumno();
          v.cerrarVentanaAddPrimaria();
          v.clearMSG();
          swal({ position: "center", type: "success", title: "Agregado!", showConfirmButton: false, timer: 1500 });
        }
      });
    },

    formData(obj) {
      var formData = new FormData();
      for (var key in obj) {
        formData.append(key, obj[key]);
      }
      return formData;
    },

    selectAlumno(alumno) {
      v.chooseAlumno = alumno;
    },
    selectCalificacionPrepa(calificacion) {
      v.chooseCalificacionPrepa = calificacion;
    },
    selectCalificacionOportunidadPrepa(calificacion) {
      v.chooseCalificacionOportunidadPrepa = calificacion;
    },
    selectCalificacionPrimaria(calificacion) {
      v.chooseCalificacionPrimaria = calificacion;
    },
    selectCalificacionQuitar(calificacion) {
      v.chooseCalificacionQuita = calificacion;
    },

    clearMSG() {
      setTimeout(function () {
        v.successMSG = "";
      }, 3000); // disappearing message success in 2 sec
    },
    cerrarVentaEditPrepa() {
      $("#modalEditCalificacionPrepa").modal("hide");
      v.formValidate = false;
      v.searchAlumnos();
      v.cargando = false;
      v.error = false;
    },
    cerrarVentanaAddPrepa() {
      $("#modalAddCalificacionPrepa").modal("hide");
      v.formValidate = false;
      v.searchAlumnos();
      v.cargando = false;
      v.error = false;
      v.newCalificacionPrepa = {
        calificacion: ""
      };
    },
    cerrarVentanaAddOportunidadPrepa() {
      $("#modalAddCalificacionOportunidadPrepa2").modal("hide");
      v.formValidate = false;
      //v.searchAlumnos();
      v.cargando = false;
      v.error = false;
      v.newCalificacionOportunidadPrepa = {
        calificacion: ""
      };
    },
    cerrarVentanaEditOportunidadPrepa() {
      $("#modalEditCalificacionOportunidadPrepa2").modal("hide");
      v.formValidate = false;
      //v.searchAlumnos();
      v.cargando = false;
      v.error = false;
      v.newCalificacionOportunidadPrepa = {
        calificacion: ""
      };
    },
    cerrarVentanaAddPrimaria() {
      $("#modalAddCalificacionPrimaria").modal("hide");
      v.formValidate = false;
      v.searchAlumnos();
      v.cargando = false;
      v.error = false;
      v.newCalificacionPrimaria = {
        calificacion: ""
      };
    },
    cerrarVentanaEditPrimaria() {
      $("#modalEditCalificacionPrimaria").modal("hide");
      v.formValidate = false;
      v.searchAlumnos();
      v.cargando = false;
      v.error = false;
    },

    clearAll() {
      // v.mostrar_calificacion_tabla = false;
      // v.cargando_calificacion_tabla = false;
      $("#abrirModal").modal("hide");
      $("#abrirEditModal").modal("hide");
      $("#abrirDetalleModal").modal("hide");
      $("#abrirAddFaltasModal").modal("hide");
      $("#abrirEditFaltasModal").modal("hide");
      $("#modalEditarDisciplina").modal("hide");
      $("#abrirAddModalDisciplina").modal("hide");
      $("#abrirModalCalificacionPS").modal("hide");
      $("#modalAddCalificacionPrimaria").modal("hide");
      $("#modalEditCalificacionPrimaria").modal("hide");
      $("#abrirModalCalificacionMateria").modal("hide");
      $("#abrirModalCalificacionOportunidad").modal("hide");
      v.newDisciplina = {
        idalumno: "",
        idhorario: "",
        idunidad: "",
        disciplina: "",
        presentacionpersonal: "",
        smserror: ""
      };
      v.newCalificacionPrepa = {
        calificacion: ""
      };
      v.newCalificacionPrimaria = {
        calificacion: ""
      };
      v.formValidate = false;
      //v.searchAlumnos();
      v.cargando = false;
      v.error = false;
    }
  }
});
