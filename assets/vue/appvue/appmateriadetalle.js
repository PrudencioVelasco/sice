
var this_js_script = $('script[src*=appmateriadetalle]');
var my_var_1 = this_js_script.attr('data-my_var_1');
if (typeof my_var_1 === "undefined") {
    var my_var_1 = 'some_default_value';
}
var my_var_2 = this_js_script.attr('data-my_var_2');
if (typeof my_var_2 === "undefined") {
    var my_var_2 = 'some_default_value';
}



Vue.config.devtools = true;
var v = new Vue({
    el: '#app',
    data: {
        url: my_var_1,
        idmateria: my_var_2,
        addModal: false,
        editModal: false,
        cargando: false,
        error: false,
        //deleteModal:false,
        materias: [],
        clases: [],
        search: {text: ''},
        emptyResult: false,
        newMateria: {
            idmateria: my_var_2,
            idmateriaseriada: '',
            smserror: ''
        },
        chooseMateria: {},
        formValidate: [],
        successMSG: '',

        //pagination
        currentPage: 0,
        rowCountPage: 10,
        totalMaterias: 0,
        pageRange: 2,
        directives: {columnSortable}
    },
    created() {
        this.showAll();
        this.showAllClases();
    },
    methods: {
        abrirAddModal() {
            $('#addRegister').modal('show');
        },
        abrirEditModal() {
            $('#editRegister').modal('show');
        },
        orderBy(sortFn) {
            // sort your array data like this.userArray
            this.materias.sort(sortFn);
        },
        showAllClases() {

            axios.get(this.url + "Materia/showAllClases/", {
                params: {
                    idmateria: this.idmateria
                }
            }).then(response => (this.clases = response.data.clases));

        },
        showAll() {
            axios.get(this.url + "Materia/showDetalleMateria/", {
                params: {
                    idmateria: this.idmateria
                }
            }).then(function (response) {
                if (response.data.materias == null) {
                    v.noResult()
                } else {
                    v.getData(response.data.materias);
                }
            })
        },
        searchMateria() {
            var formData = v.formData(v.search);
            axios.post(this.url + "Profesor/searchllClases", formData).then(function (response) {
                if (response.data.materias == null) {
                    v.noResult()
                } else {
                    v.getData(response.data.materias);

                }
            })
        },
        addMateria() {
            v.cargando = true;
            v.error = false;
            var formData = v.formData(v.newMateria);
            axios.post(this.url + "Materia/addMateriaSeriada", formData).then(function (response) {
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
                        timer: 3000
                    });

                    v.clearAll();
                    v.clearMSG();
                }
            })
        },
        deleteMateria(id) {
            Swal.fire({
                title: 'Quitar Materia?',
                text: "Realmente desea quitar la Materia.",
                type: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Quitar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.value) {

                    axios.get(this.url + "Materia/deleteMateriaSeriada", {
                        params: {
                            id: id
                        }
                    }).then(function (response) {
                        if (response.data.error == false) {
                            //v.noResult()
                            v.clearAll();
                            v.clearMSG();
                            swal({
                                position: 'center',
                                type: 'success',
                                title: 'Quitado!',
                                showConfirmButton: false,
                                timer: 3000
                            });

                        } else {
                            swal("Información", response.data.msg.msgerror, "info")
                            v.cargando = false;
                        }
                    }).catch((error) => {
                        swal("Información", "No se puede quitar la Materia", "info")
                        v.cargando = false;
                    })
                }
            })


        },
        updateMateria() {
            v.cargando = true;
            v.error = false;
            var formData = v.formData(v.chooseMateria);
            axios.post(this.url + "Materia/updateMateriaSeriada", formData).then(function (response) {
                if (response.data.error) {
                    v.formValidate = response.data.msg;
                    v.cargando = false;
                    v.error = true;
                } else {
                    //v.successMSG = response.data.success;
                    swal({
                        position: 'center',
                        type: 'success',
                        title: 'Modificado!',
                        showConfirmButton: false,
                        timer: 3000
                    });
                    v.clearAll();
                    v.clearMSG();

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
        getData(materias) {
            v.emptyResult = false; // become false if has a record
            v.totalMaterias = materias.length //get total of user
            v.materias = materias.slice(v.currentPage * v.rowCountPage, (v.currentPage * v.rowCountPage) + v.rowCountPage); //slice the result for pagination

            // if the record is empty, go back a page
            if (v.materias.length == 0 && v.currentPage > 0) {
                v.pageUpdate(v.currentPage - 1)
                v.clearAll();
            }
        },

        selectMateria(materia) {
            v.chooseMateria = materia;
        },
        clearMSG() {
            setTimeout(function () {
                v.successMSG = ''
            }, 3000); // disappearing message success in 2 sec
        },
        clearAll() {
            $('#editRegister').modal('hide');
            $('#addRegister').modal('hide');
            v.newMateria = {
                idmateria: my_var_2,
                idmateriaseriada: '',
                smserror: ''
            };
            v.formValidate = false;
            v.addModal = false;
            v.editModal = false;
            v.passwordModal = false;
            v.deleteModal = false;
            v.error = false;
            v.cargando = false;
            v.refresh()

        },
        noResult() {

            v.emptyResult = true;  // become true if the record is empty, print 'No Record Found'
            v.materias = null;
            v.totalMaterias = 0; //remove current page if is empty

        },

        pageUpdate(pageNumber) {
            v.currentPage = pageNumber; //receive currentPage number came from pagination template
            v.refresh();
        },
        refresh() {
            v.search.text ? v.searchMateria() : v.showAll(); //for preventing

        }
    }
})
