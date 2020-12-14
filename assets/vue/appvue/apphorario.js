var this_js_script = $("script[src*=apphorario]");
var my_var_1 = this_js_script.attr("data-my_var_1");
if (typeof my_var_1 === "undefined") {
  var my_var_1 = "some_default_value";
}

Vue.config.devtools = true;
var v = new Vue({
  el: "#app",
  data: {
    url: my_var_1,
    addModal: false,
    editModal: false,
    cargando: false,
    error: false,
    //deleteModal:false,
    horarios: [],
    periodos: [],
    grupos: [],
    meses: [],
    years: [],
    search: {
      text: ""
    },
    emptyResult: false,
    newHorario: {
      idperiodo: "",
      idgrupo: "",
      descripcion: "",
      activo: "",
      smserror: ""
    },
    chooseHorario: {},
    formValidate: [],
    successMSG: "",

    //pagination
    currentPage: 0,
    rowCountPage: 10,
    totalHorarios: 0,
    pageRange: 2,
    directives: {
      columnSortable
    }
  },
  created() {
    this.showAll();
    this.showAllPeriodos();
    this.showAllGrupos();
    this.showAllMeses();
    this.showAllYears();
  },
  methods: {
    orderBy(sortFn) {
      // sort your array data like this.userArray
      this.horarios.sort(sortFn);
    },
    abrirAddModal() {
      $("#addRegister").modal("show");
    },
    abrirEditModal() {
      $("#editRegister").modal("show");
    },
    showAll() {
      axios.get(this.url + "Horario/showAll").then(function (response) {
        if (response.data.horarios == null) {
          v.noResult();
        } else {
          v.getData(response.data.horarios);
        }
      });
    },
    deleteHorario(id) {
      Swal.fire({
        title: "¿Eliminar Horario?",
        text: "Realmente desea eliminar el Horario.",
        type: "question",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Eliminar",
        cancelButtonText: "Cancelar"
      }).then(result => {
        if (result.value) {
          axios.get(this.url + "Horario/deleteHorario", {
            params: {
              idhorario: id
            }
          }).then(function (response) {
            if (response.data.error == false) {
              //v.noResult()
              swal({position: "center", type: "success", title: "Eliminado!", showConfirmButton: false, timer: 3000});
              v.clearAll();
              v.clearMSG();
            } else {
              swal("Información", response.data.msg.msgerror, "info");
            }
            //console.log(response);
          }).catch(error => {
            swal("Información", "No se puede eliminar el Horario", "info");
          });
        }
      });
    },
    showAllMeses() {
      axios.get(this.url + "CicloEscolar/showAllMeses/").then(response => (this.meses = response.data.meses));
    },
    showAllYears() {
      axios.get(this.url + "CicloEscolar/showAllYears/").then(response => (this.years = response.data.years));
    },
    showAllPeriodos() {
      axios.get(this.url + "Horario/showAllPeriodos/").then(response => (this.periodos = response.data.periodos));
    },
    showAllGrupos() {
      axios.get(this.url + "Horario/showAllGrupos/").then(response => (this.grupos = response.data.grupos));
    },
    searchHorario() {
      var formData = v.formData(v.search);
      axios.post(this.url + "Horario/searchHorario", formData).then(function (response) {
        if (response.data.horarios == null) {
          v.noResult();
        } else {
          v.getData(response.data.horarios);
        }
      });
    },
    addHorario() {
      v.cargando = true;
      v.error = false;
      var formData = v.formData(v.newHorario);
      axios.post(this.url + "Horario/addHorario", formData).then(function (response) {
        if (response.data.error) {
          v.formValidate = response.data.msg;
          v.error = true;
          v.cargando = false;
        } else {
          swal({position: "center", type: "success", title: "Exito!", showConfirmButton: false, timer: 3000});

          v.clearAll();
          v.clearMSG();
        }
      });
    },
    updateHorario() {
      v.cargando = true;
      v.error = false;
      var formData = v.formData(v.chooseHorario);
      axios.post(this.url + "Horario/updateHorario", formData).then(function (response) {
        if (response.data.error) {
          v.formValidate = response.data.msg;
          v.error = true;
          v.cargando = false;
        } else {
          //v.successMSG = response.data.success;
          swal({position: "center", type: "success", title: "Modificado!", showConfirmButton: false, timer: 3000});
          v.clearAll();
          v.clearMSG();
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
    getData(horarios) {
      v.emptyResult = false; // become false if has a record
      v.totalHorarios = horarios.length; //get total of user
      v.horarios = horarios.slice(v.currentPage * v.rowCountPage, v.currentPage * v.rowCountPage + v.rowCountPage); //slice the result for pagination

      // if the record is empty, go back a page
      if (v.horarios.length == 0 && v.currentPage > 0) {
        v.pageUpdate(v.currentPage - 1);
        v.clearAll();
      }
    },

    selectHorario(horario) {
      v.chooseHorario = horario;
    },
    clearMSG() {
      setTimeout(function () {
        v.successMSG = "";
      }, 3000); // disappearing message success in 2 sec
    },
    clearAll() {
      $("#editRegister").modal("hide");
      $("#addRegister").modal("hide");
      v.newHorario = {
        idnivelestudio: "",
        idgrupo: "",
        descripcion: "",
        activo: "",
        smserror: ""
      };
      v.formValidate = false;
      v.addModal = false;
      v.editModal = false;
      v.passwordModal = false;
      v.deleteModal = false;
      v.cargando = false;
      v.error = false;
      v.refresh();
    },
    noResult() {
      v.emptyResult = true; // become true if the record is empty, print 'No Record Found'
      v.horarios = null;
      v.totalHorarios = 0; //remove current page if is empty
    },

    pageUpdate(pageNumber) {
      v.currentPage = pageNumber; //receive currentPage number came from pagination template
      v.refresh();
    },
    refresh() {
      v.search.text
        ? v.searchHorario()
        : v.showAll(); //for preventing
    }
  }
});
