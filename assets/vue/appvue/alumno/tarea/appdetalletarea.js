var this_js_script = $("script[src*=appdetalletarea]");
var my_var_1 = this_js_script.attr("data-my_var_1");
if (typeof my_var_1 === "undefined") {
  var my_var_1 = "some_default_value";
}
var my_var_2 = this_js_script.attr("data-my_var_2");
if (typeof my_var_2 === "undefined") {
  var my_var_2 = "some_default_value";
}

Vue.config.devtools = true;
Vue.use(VueCkeditor);
var v = new Vue({
  el: "#appdetalletarea",
  components: {
    VueCkeditor
  },
  data: {
    config: {
      height: 200
    },
    url: my_var_1,
    idtarea: my_var_2,
    addModal: false,
    editModal: false,
    //deleteModal:false,
    cargando: false,
    error: false,
    tarea: [],
    documentosTarea: {},
    filesSend: [],
    documentosAlumnos: {},
    contestado: [],
    emptyResult: false,
    file: "",
    responderTarea: {
      titulo: "",
      tarea: "",
      smserror: ""
    },
    chooseTarea: {},
    formValidate: [],
    successMSG: ""
  },
  created() {
    this.showTarea();
    this.showTareaContestado();
    this.showDocumentosTarea(); //Docs de la tarea
  },
  methods: {
    abrirAddModal() {
      $("#addRegister").modal("show");
    },
    abrirEditModal() {
      $("#editRegister").modal("show");
    },
    showTarea() {
      axios.get(this.url + "Tarea/showDetalleTarea", {
        params: {
          idtarea: this.idtarea
        }
      }).then(response => (this.tarea = response.data.tarea));
    },
    showTareaContestado() {
      axios.get(this.url + "Tarea/showdetalleRespuestaTareaAlumno", {
        params: {
          idtarea: this.idtarea
        }
      }).then(response => (this.contestado = response.data));
    },
    showDocumentosTarea() {
      axios.get(this.url + "Tarea/obtenerDocumentosTarea", {
        params: {
          idtarea: this.idtarea
        }
      }).then(response => (v.documentosTarea = response.data));
    },
    onChangeFileUploadAdd(e) {
      var selectedFiles = e.target.files;
      for (let i = 0; i < selectedFiles.length; i++) {
        this.filesSend.push(selectedFiles[i]);
      }
    },
    removeElement: function (index) {
      this.filesSend.splice(index, 1);
      if (this.filesSend.length == 0) {
        this.$refs.fileedit.value = "";
      }
    },
    formData(obj) {
      var formData = new FormData();
      for (var key in obj) {
        formData.append(key, obj[key]);
      }
      return formData;
    },
    enviarTarea() {
      $("#btnenviartarea").prop("disabled", true);
      v.formValidate = false;
      v.cargando = false;
      v.error = false;
      Swal.fire({
        title: "¿Enviar Tarea?",
        text: "Una vez enviado no se podra modificar o reenviar.",
        type: "question",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Enviar",
        cancelButtonText: "Cancelar"
      }).then(result => {
        if (result.value) {
          v.cargando = true;
          v.error = false;
          var formData = v.formData(v.responderTarea);
          for (var i = 0; i < this.filesSend.length; i++) {
            let file = this.filesSend[i];
            formData.append("files[" + i + "]", file);
          }
          formData.append("idtarea", this.idtarea);
          axios.post(this.url + "Tarea/responderTareaAlumno", formData, {
            headers: {
              "Content-Type": "multipart/form-dara"
            }
          }).then(function (response) {
            if (response.data.error) {
              v.formValidate = true;
              v.formValidate = response.data.msg;
              v.error = true;
              v.cargando = false;
              $("#btnenviartarea").prop("disabled", false);
            } 
            if(!response.data.error) {
              swal({
                position: "center", 
                type: "success", 
                title:response.data.msg.msgerror, 
                showConfirmButton: true
                // timer: 2000
              });
              
              v.showTareaContestado();
              v.clearAll();
              v.clearMSG();
            }
          }).catch(error => {
            swal("Información", error, "info");
          });
        }
      });
    },
    selectTarea(tarea) {
      v.chooseTarea = tarea;
    },
    clearMSG() {
      setTimeout(function () {
        v.successMSG = "";
      }, 3000); // disappearing message success in 2 sec
    },
    clearAll() {
      this.$refs.fileedit.value = "";
      v.filesSend = [];
      $("#btnenviartarea").prop("disabled", false);
      $("#editRegister").modal("hide");
      $("#addRegister").modal("hide");
      $("#fileadd").val(null);
      v.formValidate = false;
      v.addModal = false;
      v.editModal = false;
      v.cargando = false;
      v.error = false;
      v.responderTarea = {
        titulo: "",
        tarea: "",
        smserror: ""
      };
    }
  }
});
