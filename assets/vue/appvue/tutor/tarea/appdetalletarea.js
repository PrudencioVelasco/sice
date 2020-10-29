var this_js_script = $('script[src*=appdetalletarea]');
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
Vue.config.devtools = true;
var v = new Vue({
    el: '#appdetalletarea',
    data: {
        url: my_var_1,
        idtarea: my_var_2,
        idalumno: my_var_3,
        addModal: false,
        editModal: false,
        cargando: false,
        error: false,
        tarea: [],
        contestado: [],
        documentosTarea: {},
        documentosAlumnos: {},
        emptyResult: false,
        file: '',
        responderTarea: {
            titulo: '',
            tarea: '',
            smserror: ''
        },
        chooseTarea: {},
        formValidate: [],
        successMSG: ''
    },
    created() {
        this.showTarea();
        this.showTareaContestado();
        this.showDocumentosTarea();
        this.showDocumentosEnviadosAlumno();
    },
    methods: {
        abrirAddModal() {
            $('#addRegister').modal('show');
        },
        abrirEditModal() {
            $('#editRegister').modal('show');
        },
        showTarea() {
            axios.get(this.url + "Tarea/showDetalleTarea", {
                params: {
                    idtarea: this.idtarea,
                }
            }).then((response) => (this.tarea = response.data.tarea));
        },
        showTareaContestado() {
            axios.get(this.url + "Tarea/showdetalleRespuestaTareaAlumnoTutor", {
                params: {
                    idtarea: this.idtarea,
                    idalumno: this.idalumno,
                }
            }).then((response) => (this.contestado = response.data));
        },
        showDocumentosEnviadosAlumno() {
            axios.get(this.url + "Tarea/showDocumentosAlumno", {
                params: {
                    idtarea: this.idtarea,
                    idalumno: this.idalumno,
                }
            }).then((response) => (v.documentosAlumnos = response.data.documentos));
        },
        showDocumentosTarea() {
            axios.get(this.url + "Tarea/obtenerDocumentosTarea", {
                params: {
                    idtarea: this.idtarea,
                }
            }).then((response) => (v.documentosTarea = response.data.documentos));
        },
        onChangeFileUploadAdd() {
            this.file = this.$refs.fileadd.files[0];
        },
        formData(obj) {
            var formData = new FormData();
            for (var key in obj) {
                formData.append(key, obj[key]);
            }
            return formData;
        },
        selectTarea(tarea) {
            v.chooseTarea = tarea;
        },
        clearMSG() {
            setTimeout(function () {
                v.successMSG = ''
            }, 3000); // disappearing message success in 2 sec
        },
        clearAll() {
            $('#editRegister').modal('hide');
            $('#addRegister').modal('hide');
            $("#fileadd").val(null);
            v.formValidate = false;
            v.addModal = false;
            v.editModal = false;
            v.cargando = false;
            v.error = false;
            v.responderTarea = {
                titulo: '',
                tarea: '',
                smserror: ''
            }
        }
    }
})
