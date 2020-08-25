
var this_js_script = $('script[src*=apptarea_principal]');
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
Vue.use(CKEditor);
var vu = new Vue({
    el: '#appplanificacion',
    data: {
        editor: ClassicEditor,
        editorData: '<p>Content of the editor.</p>',
        editorConfig: {
            // The configuration of the editor.
        },
        url: my_var_1,
        idhorario: my_var_2,
        idhorariodetalle: my_var_3,
        addModal: false,
        editModal: false,
        cargando: false,
        error: false,
        tareas: [],
        grupos: [],
        file: '',
        search: {text: ''},
        emptyResult: false,
        newTarea: {
            titulo: '',
            tarea: '',
            fechaentrega: '',
            horaentrega: '',

            smserror: ''
        },
        chooseTarea: {},
        formValidate: [],
        successMSG: '',

        //pagination
        currentPage: 0,
        rowCountPage: 10,
        totalTareas: 0,
        pageRange: 2,
        directives: {columnSortable}
    },
    created() {
        this.showAll();
        this.showAllGrupos();
    },
    methods: {
        orderBy(sortFn) {
            // sort e array data like this.userArray
            this.tareas.sort(sortFn);
        },
        abrirAddModal() {
            $("#addRegister").modal("show");
        },
        abrirEditModal() {
            $("#editRegister").modal("show");
        },
        showAll() {
            axios.get(this.url + "Tarea/showAll").then(function (response) {
                if (response.data.tareas == null) {
                    vu.noResult()
                } else {
                    vu.getData(response.data.tareas);
                }
            })
        },
        showAllGrupos() {
            axios.get(this.url + "Planificacion/showAllGrupos/")
                    .then(
                            (response) => (this.grupos = response.data.grupos)
                    );
        },
        searchTarea() {
            var formData = vu.formData(vu.search);
            axios.post(this.url + "Tarea/searchTarea", formData).then(function (response) {
                if (response.data.tareas == null) {
                    vu.noResult()
                } else {
                    vu.getData(response.data.tareas);

                }
            })
        },
        addTarea() {
            vu.cargando = true;
            vu.error = false;
            var formData = vu.formData(vu.newTarea);
            formData.append('file', this.file);
            formData.append('idhorario', this.idhorario);
            formData.append('idhorariodetalle', this.idhorariodetalle);
            axios.post(this.url + "Tarea/addTarea", formData, {
                headers: {
                    'Content-Type': 'multipart/form-dara'
                }
            }).then(function (response) {
                if (response.data.error) {
                    vu.formValidate = response.data.msg;
                    vu.error = true;
                    vu.cargando = false;
                } else {
                    swal({
                        position: 'center',
                        type: 'success',
                        title: 'Registrado!',
                        showConfirmButton: false,
                        timer: 1500
                    });

                    vu.clearAll();
                    vu.clearMSG();
                }
            });
        },
        onChangeFileUploadAdd() {
            this.file = this.$refs.fileadd.files[0];
        },
         onChangeFileUploadEdit() {
            this.file = this.$refs.fileedit.files[0];
        },
        updateTarea() {
            vu.cargando = true;
            vu.error = false;
            var formData = vu.formData(vu.chooseTarea);
            formData.append('file', this.file);
            formData.append('idhorario', this.idhorario);
            formData.append('idhorariodetalle', this.idhorariodetalle);
            axios.post(this.url + "Tarea/updateTarea", formData, {
                headers: {
                    'Content-Type': 'multipart/form-dara'
                }
            }).then(function (response) {
                if (response.data.error) {
                    vu.formValidate = response.data.msg;
                    vu.error = true;
                    vu.cargando = false;
                } else {
                    //vu.successMSG = response.data.success;
                    swal({
                        position: 'center',
                        type: 'success',
                        title: 'Modificado!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    vu.clearAll();
                    vu.clearMSG();

                }
            }).catch((error) => {
                swal("Información", "Ocurrio un error, intente mas tarde", "info");
            });
        },
        deleteTarea(id) {
            Swal.fire({
                title: '¿Eliminar Tarea?',
                text: "Realmente desea eliminar la Tarea.",
                type: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.value) {

                    axios.get(this.url + "Tarea/deleteTarea", {
                        params: {
                            id: id
                        }
                    }).then(function (response) {
                        if (response.data.error == false) {
                            swal({
                                position: 'center',
                                type: 'success',
                                title: 'Eliminado!',
                                showConfirmButton: false,
                                timer: 3000
                            });
                            vu.clearAll();
                            vu.clearMSG();
                        } else {
                            swal("Información", response.data.msg.msgerror, "info");
                        }
                    }).catch((error) => {
                        swal("Información", "No se puede eliminar la Tarea", "info");
                    });
                }
            })
        },
        formData(obj) {
            var formData = new FormData();
            for (var key in obj) {
                formData.append(key, obj[key]);
            }
            return formData;
        },
        getData(tareas) {
            vu.emptyResult = false; // become false if has a record
            vu.totalTareas = tareas.length; //get total of user
            vu.tareas = tareas.slice(vu.currentPage * vu.rowCountPage, (vu.currentPage * vu.rowCountPage) + vu.rowCountPage); //slice the result for pagination

            // if the record is empty, go back a page
            if (vu.tareas.length == 0 && vu.currentPage > 0) {
                vu.pageUpdate(vu.currentPage - 1);
                vu.clearAll();
            }
        },

        selectTarea(tarea) {
            vu.chooseTarea = tarea;
        },
        clearMSG() {
            setTimeout(function () {
                vu.successMSG = ''
            }, 3000); // disappearing message success in 2 sec
        },
        clearAll() {
            vu.cargando = false;
            vu.error = false;
            $("#editRegister").modal("hide");
            $("#addRegister").modal("hide");
            $("#fileadd").val(null);
            $("#fileedit").val(null);
            vu.newTarea = {
                titulo: '',
                tarea: '',
                fechaentrega: '',
                horaentrega: '',
                smserror: ''
            };
            vu.formValidate = false;
            vu.refresh();

        },
        noResult() {
            vu.emptyResult = true;  // become true if the record is empty, print 'No Record Found'
            vu.tareas = null;
            vu.totalTareas = 0; //remove current page if is empty 
        },

        pageUpdate(pageNumber) {
            vu.currentPage = pageNumber; //receive currentPage number came from pagination template
            vu.refresh();
        },
        refresh() {
            vu.search.text ? vu.searcTarea() : vu.showAll(); //for preventing

        }
    }
})
