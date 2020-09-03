var this_js_script = $('script[src*=appdetalletarea]');
var my_var_1 = this_js_script.attr('data-my_var_1');
if (typeof my_var_1 === "undefined") {
    var my_var_1 = 'some_default_value';
}
var my_var_2 = this_js_script.attr('data-my_var_2');
if (typeof my_var_2 === "undefined") {
    var my_var_2 = 'some_default_value';
}
Vue.config.devtools = true;
Vue.use(CKEditor);
var v = new Vue({
    el: '#appdetalletarea',
    data: {
       editor: ClassicEditor,
        editorData: '<p>Content of the editor.</p>',
        editorConfig: {
            // The configuration of the editor.
              
        },
        url: my_var_1,
        idtarea: my_var_2,
        addModal: false,
        editModal: false,
        //deleteModal:false,
        cargando: false,
        error: false,
        tarea: [],
        contestado:[],
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
            }).then(
                    (response) => (this.tarea = response.data.tarea)
            );
        },
          showTareaContestado() {
            axios.get(this.url + "Tarea/showdetalleRespuestaTareaAlumno", {
                params: {
                    idtarea: this.idtarea,
                }
            }).then(
                    (response) => (this.contestado = response.data.contestado)
            );
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
