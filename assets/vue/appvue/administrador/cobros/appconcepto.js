var this_js_script = $("script[src*=appconcepto]");
var my_var_1 = this_js_script.attr("data-my_var_1");
if (typeof my_var_1 === "undefined") {
  var my_var_1 = "some_default_value";
}

Vue.config.devtools = true;
var vcon = new Vue({
  el: "#appconcepto",
  data: {
    url: my_var_1,
    addModal: false,
    editModal: false,
    //deleteModal:false,
    cargando: false,
    error: false,
    conceptos: [],
    search: {
      text: ""
    },
    emptyResult: false,
    newConcepto: {
      concepto: ""
    },
    chooseConcepto: {},
    formValidate: [],
    successMSG: "",

    //pagination
    currentPage: 0,
    rowCountPage: 10,
    totalConceptos: 0,
    pageRange: 2,
    directives: {
      columnSortable
    }
  },
  created() {
    this.showAll();
  },
  methods: {
    abrirAddModal() {
      $("#addRegisterConcepto").modal("show");
    },
    abrirEditModal() {
      $("#editRegisterConcepto").modal("show");
    },
    orderBy(sortFn) {
      // sort e array data like this.userArray
      this.conceptos.sort(sortFn);
    },
    searchConcepto() {
      var formData = vcon.formData(vcon.search);

      axios.post(this.url + "Colegiatura/searchConcepto", formData).then(function (response) {
        if (response.data.conceptos == null) {
          vcon.noResult();
        } else {
          vcon.getData(response.data.conceptos);
        }
      });
    },
    showAll() {
      axios.get(this.url + "Colegiatura/showAllConceptos").then(function (response) {
        if (response.data.conceptos == null) {
          vcon.noResult();
        } else {
          vcon.getData(response.data.conceptos);
        }
      });
    },
    addConcepto() {
      vcon.cargando = true;
      vcon.error = false;
      var formData = vcon.formData(vcon.newConcepto);
      axios.post(this.url + "Colegiatura/addConcepto", formData).then(function (response) {
        if (response.data.error) {
          vcon.formValidate = response.data.msg;
          vcon.error = true;
          vcon.cargando = false;
        } else {
          swal({position: "center", type: "success", title: "Exito!", showConfirmButton: false, timer: 3000});

          vcon.clearAll();
          vcon.clearMSG();
        }
      });
    },
    updateConcepto() {
      vcon.cargando = true;
      vcon.error = false;
      var formData = vcon.formData(vcon.chooseConcepto);
      axios.post(this.url + "Colegiatura/updateConcepto", formData).then(function (response) {
        if (response.data.error) {
          vcon.formValidate = response.data.msg;
          vcon.error = true;
          vcon.cargando = false;
          //console.log(response.data.error)
        } else {
          //v.successMSG = response.data.success;
          swal({position: "center", type: "success", title: "Modificado!", showConfirmButton: false, timer: 3000});
          vcon.clearAll();
          vcon.clearMSG();
        }
      });
    },
    deleteConcepto(id) {
      // body...
      Swal.fire({
        title: "¿Eliminar Concepto?",
        text: "Realmente desea eliminar el concepto.",
        type: "question",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Eliminar",
        cancelButtonText: "Cancelar"
      }).then(result => {
        if (result.value) {
          axios.get(this.url + "Colegiatura/eliminarConcepto", {
            params: {
              idtipopagocol: id
            }
          }).then(function (response) {
            if (response.data.error == false) {
              swal({position: "center", type: "success", title: "Eliminado!", showConfirmButton: false, timer: 1500});
              vcon.clearAll();
              vcon.clearMSG();
            } else {
              swal("Información", response.data.msg.msgerror, "info");
            }
            console.log(response);
          }).catch(error => {
            swal("Información", "No se puede eliminar el concepto.", "info");
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
    getData(conceptos) {
      vcon.emptyResult = false; // become false if has a record
      vcon.totalConceptos = conceptos.length; //get total of user
      vcon.conceptos = conceptos.slice(vcon.currentPage * vcon.rowCountPage, vcon.currentPage * vcon.rowCountPage + vcon.rowCountPage); //slice the result for pagination

      // if the record is empty, go back a page
      if (vcon.conceptos.length == 0 && vcon.currentPage > 0) {
        vcon.pageUpdate(vcon.currentPage - 1);
        vcon.clearAll();
      }
    },

    selectConcepto(concepto) {
      vcon.chooseConcepto = concepto;
    },
    clearMSG() {
      setTimeout(function () {
        vcon.successMSG = "";
      }, 3000); // disappearing message success in 2 sec
    },
    clearAll() {
      $("#editRegisterConcepto").modal("hide");
      $("#addRegisterConcepto").modal("hide");
      vc.newConcepto = {
        concepto: ""
      };
      vcon.formValidate = false;
      vcon.addModal = false;
      vcon.editModal = false;
      vcon.deleteModal = false;
      vcon.cargando = false;
      vcon.error = false;
      vcon.refresh();
    },
    noResult() {
      vcon.emptyResult = true; // become true if the record is empty, print 'No Record Found'
      vcon.conceptos = null;
      vcon.totalConceptos = 0; //remove current page if is empty
    },

    pageUpdate(pageNumber) {
      vcon.currentPage = pageNumber; //receive currentPage number came from pagination template
      vcon.refresh();
    },
    refresh() {
      vcon.search.text
        ? vcon.searchConcepto()
        : vcon.showAll(); //for preventing
    }
  }
});
