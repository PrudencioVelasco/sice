var this_js_script = $("script[src*=appconfiguracion]");
var my_var_1 = this_js_script.attr("data-my_var_1");
if (typeof my_var_1 === "undefined") {
  var my_var_1 = "some_default_value";
}

Vue.config.devtools = true;
var vc = new Vue({
  el: "#appconfiguracion",
  data: {
    url: my_var_1,
    addModal: false,
    editModal: false,
    //deleteModal:false,
    cargando: false,
    error: false,
    configuraciones: [],
    niveles: [],
    search: {
      text: ""
    },
    emptyResult: false,
    newConfiguracion: {
      idniveleducativo: "",
      diaultimorecargo: "",
      totalrecargo: ""
    },
    chooseConfiguracion: {},
    formValidate: [],
    successMSG: "",

    //pagination
    currentPage: 0,
    rowCountPage: 10,
    totalConfiguraciones: 0,
    pageRange: 2,
    directives: {
      columnSortable
    }
  },
  created() {
    this.showAll();
    this.showAllNiveles();
  },
  methods: {
    abrirAddModal() {
      $("#addRegisterRecargo").modal("show");
    },
    abrirEditModal() {
      $("#editRegisterRecargo").modal("show");
    },
    orderBy(sortFn) {
      // sort e array data like this.userArray
      this.configuraciones.sort(sortFn);
    },
    showAll() {
      axios.get(this.url + "EstadoCuenta/showAllConfiguraciones").then(function (response) {
        if (response.data.configuraciones == null) {
          vc.noResult();
        } else {
          vc.getData(response.data.configuraciones);
        }
      });
    },
    showAllNiveles() {
      axios.get(this.url + "Colegiatura/showAllNiveles/").then(response => (this.niveles = response.data.niveles));
    },
    searchConfiguracion() {
      var formData = vc.formData(vc.search);
      axios.post(this.url + "Colegiatura/searchColegiatura", formData).then(function (response) {
        if (response.data.colegiaturas == null || response.data.colegiaturas == false) {
          vc.noResult();
        } else {
          vc.getData(response.data.colegiaturas);
        }
      });
    },
    addConfiguracion() {
      vc.cargando = true;
      vc.error = false;
      var formData = vc.formData(vc.newConfiguracion);
      axios.post(this.url + "Colegiatura/addColegiatura", formData).then(function (response) {
        if (response.data.error) {
          vc.formValidate = response.data.msg;
          vc.error = true;
          vc.cargando = false;
        } else {
          swal({position: "center", type: "success", title: "Exito!", showConfirmButton: false, timer: 3000});

          vc.clearAll();
          vc.clearMSG();
        }
      });
    },
    updateConfiguracion() {
      vc.cargando = true;
      vc.error = false;
      var formData = vc.formData(vc.chooseConfiguracion);
      axios.post(this.url + "EstadoCuenta/updateRecargo", formData).then(function (response) {
        if (response.data.error) {
          vc.formValidate = response.data.msg;
          vc.error = true;
          vc.cargando = false;
          //console.log(response.data.error)
        } else {
          //v.successMSG = response.data.success;
          swal({position: "center", type: "success", title: "Modificado!", showConfirmButton: false, timer: 3000});
          vc.clearAll();
          vc.clearMSG();
        }
      });
    },
    deleteConfiguracion(id) {
      // body...
      Swal.fire({
        title: "¿Eliminar Recargo?",
        text: "Realmente desea eliminar el recargo.",
        type: "question",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Eliminar",
        cancelButtonText: "Cancelar"
      }).then(result => {
        if (result.value) {
          axios.get(this.url + "Colegiatura/eliminarRecargo", {
            params: {
              idconfiguracion: id
            }
          }).then(function (response) {
            if (response.data.error == false) {
              swal({position: "center", type: "success", title: "Eliminado!", showConfirmButton: false, timer: 1500});
              vc.clearAll();
              vc.clearMSG();
            } else {
              swal("Información", response.data.msg.msgerror, "info");
            }
            console.log(response);
          }).catch(error => {
            swal("Información", "No se puede eliminar el recargo.", "info");
          });
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
    getData(configuracion) {
      vc.emptyResult = false; // become false if has a record
      vc.totalConfiguraciones = configuracion.length; //get total of user
      vc.configuraciones = configuracion.slice(vc.currentPage * vc.rowCountPage, vc.currentPage * vc.rowCountPage + vc.rowCountPage); //slice the result for pagination

      // if the record is empty, go back a page
      if (vc.configuraciones.length == 0 && vc.currentPage > 0) {
        vc.pageUpdate(vc.currentPage - 1);
        vc.clearAll();
      }
    },

    selectConfiguracion(configuracion) {
      vc.chooseConfiguracion = configuracion;
    },
    clearMSG() {
      setTimeout(function () {
        vc.successMSG = "";
      }, 3000); // disappearing message success in 2 sec
    },
    clearAll() {
      $("#editRegisterRecargo").modal("hide");
      $("#addRegisterRecargo").modal("hide");
      vc.newConfiguracion = {
        idniveleducativo: "",
        diaultimorecargo: "",
        totalrecargo: ""
      };
      vc.formValidate = false;
      vc.addModal = false;
      vc.editModal = false;
      vc.deleteModal = false;
      vc.cargando = false;
      vc.error = false;
      vc.refresh();
    },
    noResult() {
      vc.emptyResult = true; // become true if the record is empty, print 'No Record Found'
      vc.configuraciones = null;
      vc.totalConfiguraciones = 0; //remove current page if is empty
    },

    pageUpdate(pageNumber) {
      vc.currentPage = pageNumber; //receive currentPage number came from pagination template
      vc.refresh();
    },
    refresh() {
      vc.search.text
        ? vc.searchConfiguracion()
        : vc.showAll(); //for preventing
    }
  }
});
