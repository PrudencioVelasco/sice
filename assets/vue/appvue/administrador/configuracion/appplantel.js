var this_js_script = $("script[src*=appplantel]");
var my_var_1 = this_js_script.attr("data-my_var_1");
if (typeof my_var_1 === "undefined") {
  var my_var_1 = "some_default_value";
}

var my_var_2 = this_js_script.attr("data-my_var_2");
if (typeof my_var_2 === "undefined") {
  var my_var_2 = "some_default_value";
}

Vue.config.devtools = true;
var v = new Vue({
  el: "#appplantel",
  data: { 
    url: my_var_1,
   
    cargando: false,
    error: false,
    niveles: [],
    niveleseducativos:[],
    plantel: [],
    planteles: [],
    calificaciones:[],
    configuracion: [],
    idniveleducativo:my_var_2,
    url_image: my_var_1 + "/assets/images/escuelas/",
    search: { text: "" },
    emptyResult: false,
    file: "",
    filesecundario:"",
    choosePlantel: {},
    chooseCalificacion:{},
    formValidate: [],
    newRegistro: {
      idnivel: "",
      calificacion_minima: "",
      reprovandas_minima: "",
    },
    newConfiguracion: {
      idniveleducativo: "",
      idplantel:"",
      diaultimorecargo: "",
      totalrecargo: "",
    },
    successMSG: "", 
  },
  created() {
    this.showPlantel();
    this.showPlanteles();
    this.showAllCalificaciones(); 
    this.showAllNiveles();
    this.showAllNivelesEducativos();
    this.detalleConfiguracion();
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
    abrirSubirFotoPrincipal(){
      $("#subirFotoPrincipal").modal("show");
    },
    abrirSubirFotoSecundario(){
      $("#subirFotoSecundario").modal("show");
    },
    abrirConfiguracion(){
      $("#addConfiguracion").modal("show");
    },
    showAllNiveles() {
      axios.get(this.url + "Grupo/showAllNiveles/")
              .then(response => (this.niveles = response.data.niveles));

  },
  showAllNivelesEducativos() {
    axios.get(this.url + "Configuracion/showAllNivelesEducativos/")
            .then(response => (this.niveleseducativos = response.data.niveleseducativos));

},
detalleConfiguracion() {
  axios.get(this.url + "Configuracion/detalleConfiguracionPrincipal").then(response => (this.configuracion = response.data.configuracion));
  }, 
    showPlantel() {
        axios.get(this.url + "Configuracion/detallePlantel").then(response => (this.plantel = response.data.plantel));
        }, 
        showPlanteles() {
          axios.get(this.url + "Configuracion/showAllPlanteles").then(response => (this.planteles = response.data.planteles));
          }, 
        showAllCalificaciones() {
          axios.get(this.url + "Configuracion/showAllCalificaciones").then(response => (this.calificaciones = response.data.calificaciones));
          }, 
   modificarPlantel(){
    var formData = v.formData();
    formData.append('clave', this.plantel.clave);
    formData.append('nombreplantel',this.plantel.nombreplantel);
    formData.append('mision',this.plantel.mision);
    formData.append('vision',this.plantel.vision);
    formData.append('objetivos',this.plantel.objetivos);
    formData.append('direccion',this.plantel.direccion);
    formData.append('director',this.plantel.director);
    formData.append('telefono',this.plantel.telefono);
    formData.append('idplantel',this.plantel.idplantel); 
    axios.post(this.url + "Configuracion/modificarPlantel", formData).then(function (response) {
      if (response.data.error) {
          v.formValidate = response.data.msg;
          //v.error = true;
          //v.cargando = false;
      } else {
          swal({
              position: 'center',
              type: 'success',
              title: 'Exito!',
              showConfirmButton: false,
              timer: 2000
          });

          //v.clearAll();

      }
  })

   },
   modificarConfiguracion(){
    v.error = false;
    v.cargando = true;
    var formData = v.formData();
    formData.append('idplantel', this.configuracion.idplantel);
    formData.append('idniveleducativo', this.configuracion.idniveleducativo);
    formData.append('totalrecargo',this.configuracion.totalrecargo);
    formData.append('diaultimorecargo',this.configuracion.diaultimorecargo);
    formData.append('idconfiguracion',this.configuracion.idconfiguracion);  
    axios.post(this.url + "Configuracion/modificarConfiguracion", formData).then(function (response) {
      if (response.data.error) {
          v.formValidate = response.data.msg;
          v.error = true;
          v.cargando = false;
      } else {
          swal({
              position: 'center',
              type: 'success',
              title: 'Exito!',
              showConfirmButton: false,
              timer: 2000
          });
          v.error = false;
          v.cargando = false;
          //v.clearAll();

      }
  })

   },
    agregarCalificacion() {
    v.error = false;
    v.cargando = true;
    var formData = v.formData(v.newRegistro);
    axios
      .post(this.url + "Configuracion/agregarCalificacion", formData)
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
   modificarCalificacion(){
    v.error = false;
    v.cargando = true;
    var formData = v.formData(v.chooseCalificacion);
    axios
      .post(this.url + "Configuracion/modificarCalificacion", formData)
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
  onChangeFileUpload() {
    this.file = this.$refs.file.files[0];
},
onChangeFileUploadSecundario() {
  this.filesecundario = this.$refs.filesecundario.files[0];
},
subirFotoPrincipal() {
  v.error = false;
  v.cargando = true;
  var formData = v.formData();
  formData.append('file', this.file); 
  axios.post(this.url + "Configuracion/subirFotoPlantelPrincipal", formData, {
      headers: {
          'Content-Type': 'multipart/form-dara'
      }
  }).then(function (response) {
      if (response.data.error) {
          v.formValidate = response.data.msg;
          v.error = true;
          v.cargando = false;
      } else {
          //v.successMSG = response.data.success;
          v.showPlantel();
          v.clearAll();
          v.clearMSG();
          swal({
              position: 'center',
              type: 'success',
              title: 'Subido!',
              showConfirmButton: false,
              timer: 1500
          });


      }
  }).catch(function () {
      console.log('ERROR AL SUBIR LA IMAGEN.');
  })
},

subirFotoSecundario() {
  v.error = false;
  v.cargando = true;
  var formData = v.formData();
  formData.append('file', this.filesecundario); 
  axios.post(this.url + "Configuracion/subirFotoPlantelSecundario", formData, {
      headers: {
          'Content-Type': 'multipart/form-dara'
      }
  }).then(function (response) {
      if (response.data.error) {
          v.formValidate = response.data.msg;
          v.error = true;
          v.cargando = false;
      } else {
          //v.successMSG = response.data.success;
          v.showPlantel();
          v.clearAll();
          v.clearMSG();
          swal({
              position: 'center',
              type: 'success',
              title: 'Subido!',
              showConfirmButton: false,
              timer: 1500
          });


      }
  }).catch(function () {
      console.log('ERROR AL SUBIR LA IMAGEN.');
  })
},
agregarConfiguracion(){
  v.error = false;
  v.cargando = true; 
  var formData = v.formData(v.newConfiguracion);
  axios.post(this.url + "Configuracion/agregarConfiguracion", formData).then(function (response) {
      if (response.data.error) {
          v.formValidate = response.data.msg;
          v.error = true;
          v.cargando = false;
      } else {
          //v.successMSG = response.data.success;
          //v.detalleConfiguracion();
          v.clearAll();
          v.clearMSG();
          swal({
              position: 'center',
              type: 'success',
              title: 'Subido!',
              showConfirmButton: false,
              timer: 1500
          });


      }
  }).catch(function () {
      console.log('ERROR AL SUBIR LA IMAGEN.');
  })
},
  eliminarCalificacion(id) {
    v.error = false;
    v.cargando = false;
    Swal.fire({
      title: "¿Eliminar Registro?",
      text: "Realmente desea eliminar el Registro.",
      type: "question",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Eliminar",
      cancelButtonText: "Cancelar",
    }).then((result) => {
      if (result.value) {
        axios
          .get(this.url + "Configuracion/eliminarCalificacion", {
            params: {
              iddetalle: id,
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
         /* .catch((error) => {
            swal("Información", "No se puede eliminar el registro", "info");
            v.cargando = false;
          });*/
      }
    });
  },
  eliminarLogoSecundario(){
    v.error = false;
    v.cargando = false;
    var opcion = 2;
    Swal.fire({
      title: "¿Eliminar Logo Secundario?",
      text: "Realmente desea eliminar el Registro.",
      type: "question",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Eliminar",
      cancelButtonText: "Cancelar",
    }).then((result) => {
      if (result.value) {
        axios
          .get(this.url + "Configuracion/eliminarLogo", {
            params: {
              opcion:opcion,
            },
          })
          .then(function (response) {
            if (response.data.error == false) {
              //v.noResult()
              //v.clearAll();
              //v.clearMSG();
              v.error = false;
              v.cargando = false;
              v.showPlantel();
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
          /*.catch((error) => {
            swal("Información", "No se puede eliminar el registro", "info");
            v.cargando = false;
          });*/
      }
    });
  },
  eliminarLogoPrincipal() {
    v.error = false;
    v.cargando = false;
    var opcion = 1;
    Swal.fire({
      title: "¿Eliminar Logo Principal?",
      text: "Realmente desea eliminar el Registro.",
      type: "question",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Eliminar",
      cancelButtonText: "Cancelar",
    }).then((result) => {
      if (result.value) {
        axios
          .get(this.url + "Configuracion/eliminarLogo", {
            params: {
              opcion:opcion,
            },
          })
          .then(function (response) {
            if (response.data.error == false) {
              //v.noResult()
              //v.clearAll();
              //v.clearMSG();
              v.error = false;
              v.cargando = false;
              v.showPlantel();
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
          /*.catch((error) => {
            swal("Información", "No se puede eliminar el registro", "info");
            v.cargando = false;
          });*/
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
   
    selectCalificacion(calificacion) {
      v.chooseCalificacion = calificacion;
      
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
      $("#subirFotoPrincipal").modal("hide");
      $("#subirFotoSecundario").modal("hide");
      $("#addConfiguracion").modal("hide");
      v.newRegistro = {
        idnivel: "",
        calificacion_minima: "",
        reprovandas_minima: "",
        smserror: "",
      };
      newConfiguracion = {
        idniveleducativo: "",
        idplantel:"",
        diaultimorecargo: "",
        totalrecargo: "",
        smserror: "",
      };
      v.formValidate = false; 
      v.error = false;
      v.cargando = false;
      v.showAllCalificaciones();
      v.showPlantel();
 
    }, 
  },
});
