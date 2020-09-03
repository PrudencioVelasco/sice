var this_js_script = $("script[src*=appalumno]");
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
    editPasswordModal: false,
    cargando: false,
    error: false,
    //deleteModal:false,
    alumnos: [],
    especialidades: [],
    tipossanguineos: [],
    estatusalumno: [],
    url_image: my_var_1 + "/assets/alumnos/",
    search: { text: "" },
    emptyResult: false,
    newAlumno: {
      idespecialidad: "",
      matricula: "",
      curp: "",
      nombre: "",
      apellidop: "",
      apellidom: "",
      lugarnacimiento: "",
      nacionalidad: "",
      domicilio: "",
      telefono: "",
      telefonoemergencia: "",
      serviciomedico: "",
      idtiposanguineo: "",
      alergiaopadecimiento: "",
      peso: "",
      estatura: "",
      numfolio: "",
      numacta: "",
      numlibro: "",
      fechanacimiento: "",
      foto: "",
      sexo: "",
      correo: "",
      password: "",
      idestatusalumno: "",
      smserror: "",
    },
    chooseAlumno: {},
    formValidate: [],

    successMSG: "",

    //pagination
    currentPage: 0,
    rowCountPage: 10,
    totalAlumnos: 0,
    pageRange: 2,
    directives: { columnSortable },
  },
  created() {
    this.showAll();
    this.showAllEspecialidades();
    this.showAllTiposSanguineos();
    this.showAllEstatusAlumno();
  },
  methods: {
    abrirAddModal() {
      $("#addRegister").modal("show");
    },
    abrirEditModal() {
      $("#editRegister").modal("show");
    },
    abrirChangeModal() {
      $("#changePassword").modal("show");
    },
    orderBy(sortFn) {
      // sort your array data like this.userArray
      this.alumnos.sort(sortFn);
    },
    showAll() {
        axios.get(this.url + "Alumno/showAll").then(function (response) {
                if (response.data.alumnos == null) {
                    v.noResult()
                } else {
                    v.getData(response.data.alumnos);
                }
            })
        }, 
    showAllEspecialidades() {
      axios
        .get(this.url + "Alumno/showAllEspecialidades/")
        .then(
          (response) => (this.especialidades = response.data.especialidades)
        );
    },
    showAllEstatusAlumno() {
      axios
        .get(this.url + "Alumno/showAllEstatusAlumno/")
        .then((response) => (this.estatusalumno = response.data.estatusalumno));
    },
    showAllTiposSanguineos() {
      axios
        .get(this.url + "Alumno/showAllTiposSanguineos/")
        .then(
          (response) => (this.tipossanguineos = response.data.tipossanguineos)
        );
    },
    searchAlumno() {
      var formData = v.formData(v.search); 
        
        axios.post(this.url + "Alumno/searchAlumno", formData).then(function (response) {
                if (response.data.alumnos == null) {
                    v.noResult()
                } else {
                    v.getData(response.data.alumnos);

                }
            })
    },
    addAlumno() {
      v.error = false;
      v.cargando = true;
      var formData = v.formData(v.newAlumno);
      axios
        .post(this.url + "Alumno/addAlumno", formData)
        .then(function (response) {
          if (response.data.error) {
            v.formValidate = response.data.msg;
            v.cargando = false;
            v.error = true;
          } else {
            v.clearAll();
            v.clearMSG();
            swal({
              position: "center",
              type: "success",
              title: "Exito!",
              showConfirmButton: false,
              timer: 1500,
            });
          }
        });
    },
    updateAlumno() {
      v.error = false;
      v.cargando = true;
      var formData = v.formData(v.chooseAlumno);
      axios
        .post(this.url + "Alumno/updateAlumno", formData)
        .then(function (response) {
          if (response.data.error) {
            v.formValidate = response.data.msg;
            v.cargando = false;
            v.error = true;
          } else {
            //v.successMSG = response.data.success;
            v.clearAll();
            v.clearMSG();
            swal({
              position: "center",
              type: "success",
              title: "Modificado!",
              showConfirmButton: false,
              timer: 1500,
            });
          }
        });
    },
    deleteAlumno(id) {
      v.error = false;
      v.cargando = true;
      Swal.fire({
        title: "¿Eliminar Alumno?",
        text: "Realmente desea eliminar el Alumno.",
        type: "question",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Eliminar",
        cancelButtonText: "Cancelar",
      }).then((result) => {
        if (result.value) {
          axios
            .get(this.url + "Alumno/deleteAlumno", {
              params: {
                idalumno: id,
              },
            })
            .then(function (response) {
              if (response.data.error == false) {
                //v.noResult()
                v.clearAll();
                v.clearMSG();
                swal({
                  position: "center",
                  type: "success",
                  title: "Eliminado!",
                  showConfirmButton: false,
                  timer: 1500,
                });
              } else {
                swal("Información", response.data.msg.msgerror, "info");
                v.cargando = false;
              }
            })
            .catch((error) => {
              swal("Información", "No se puede eliminar el Alumno", "info");
              v.cargando = false;
            });
        }
      });
    },
    updatePasswordAlumno() {
      v.error = false;
      v.cargando = true;
      var formData = v.formData(v.chooseAlumno);
      axios
        .post(this.url + "Alumno/updatePasswordAlumno", formData)
        .then(function (response) {
          if (response.data.error) {
            v.formValidate = response.data.msg;
            v.error = true;
            v.cargando = false;
          } else {
            //v.successMSG = response.data.success;
            v.clearAll();
            v.clearMSG();
            swal({
              position: "center",
              type: "success",
              title: "Modificado!",
              showConfirmButton: false,
              timer: 1500,
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
     getData(alumnos) {
            v.emptyResult = false; // become false if has a record
            v.totalAlumnos = alumnos.length //get total of user
            v.alumnos = alumnos.slice(v.currentPage * v.rowCountPage, (v.currentPage * v.rowCountPage) + v.rowCountPage); //slice the result for pagination

            // if the record is empty, go back a page
            if (v.alumnos.length == 0 && v.currentPage > 0) {
                v.pageUpdate(v.currentPage - 1)
                v.clearAll();
            }
        },

    selectAlumno(alumno) {
      v.chooseAlumno = alumno;
      
    },
    clearMSG() {
      setTimeout(function () {
        v.successMSG = "";
      }, 3000); // disappearing message success in 2 sec
    },
    clearAll() {
      $("#editRegister").modal("hide");
      $("#addRegister").modal("hide");
      $("#changePassword").modal("hide");
      v.newAlumno = {
        matricula: "",
        curp: "",
        nombre: "",
        apellidop: "",
        apellidom: "",
        lugarnacimiento: "",
        nacionalidad: "",
        domicilio: "",
        telefono: "",
        telefonoemergencia: "",
        serviciomedico: "",
        idtiposanguineo: "",
        alergiaopadecimiento: "",
        peso: "",
        estatura: "",
        fechanacimiento: "",
        foto: "",
        sexo: "",
        correo: "",
        password: "",
        idestatusalumno: "",
        smserror: "",
      };
      v.formValidate = false;
      v.addModal = false;
      v.editPasswordModal = false;
      v.editModal = false;
      v.error = false;
      v.cargando = false;

      //v.passwordModal=false;
      //v.deleteModal=false;
      v.refresh();
    },
    noResult() {
      v.emptyResult = true; // become true if the record is empty, print 'No Record Found'
      v.alumnos = null;
      v.totalAlumnos = 0; //remove current page if is empty
    },

    pageUpdate(pageNumber) {
      v.currentPage = pageNumber; //receive currentPage number came from pagination template
      v.refresh();
    },
    refresh() {
      v.search.text ? v.searchAlumno() : v.showAll(); //for preventing
    },
  },
});
