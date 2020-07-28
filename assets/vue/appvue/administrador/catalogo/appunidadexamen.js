
var this_js_script = $('script[src*=appunidadexamen]');
var my_var_1 = this_js_script.attr('data-my_var_1');
if (typeof my_var_1 === "undefined") {
    var my_var_1 = 'some_default_value';
}


Vue.config.devtools = true;
var vu = new Vue({
    el: '#appunidades',
    data: {
        url: my_var_1,
        addModal: false,
        editModal: false,
        cargando: false,
        error: false,
        unidades: [],
        search: { text: '' },
        emptyResult: false,
        newUnidad: {
            nombreunidad: '',
            smserror: ''
        },
        chooseUnidad: {},
        formValidate: [],
        successMSG: '',

        //pagination
        currentPage: 0,
        rowCountPage: 10,
        totalUnidades: 0,
        pageRange: 2,
        directives: { columnSortable }
    },
    created() {
        this.showAll();
    },
    methods: {
        orderBy(sortFn) {
            // sort e array data like this.userArray
            this.unidades.sort(sortFn);
        },
        abrirAddModal() {
            $("#addRegister").modal("show");
        },
        abrirEditModal() {
            $("#editRegister").modal("show");
        },
        showAll() {
            axios.get(this.url + "Examen/showAll").then(function (response) {
                if (response.data.unidades == null) {
                    vu.noResult()
                } else {
                    vu.getData(response.data.unidades);
                }
            })
        },
        searchUnidad() {
            var formData = vu.formData(vu.search);
            axios.post(this.url + "Examen/searchUnidadExamen", formData).then(function (response) {
                if (response.data.unidades == null) {
                    vu.noResult()
                } else {
                    vu.getData(response.data.unidades);

                }
            })
        },
        addUnidad() {
            vu.cargando = true;
            vu.error = false;
            var formData = vu.formData(vu.newUnidad);
            axios.post(this.url + "Examen/addUnidadExamen", formData).then(function (response) {
                if (response.data.error) {
                    vu.formValidate = response.data.msg;
                    vu.error = true;
                    vu.cargando = false;
                } else {
                    swal({
                        position: 'center',
                        type: 'success',
                        title: 'Exito!',
                        showConfirmButton: false,
                        timer: 1500
                    });

                    vu.clearAll();
                    vu.clearMSG();
                }
            })
        },
        updateUnidad() {
            vu.cargando = true;
            vu.error = false;
            var formData = vu.formData(vu.chooseUnidad);
            axios.post(this.url + "Examen/updateUnidadExamen", formData).then(function (response) {
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
            })
        },
        deleteUnidad(id) {
            Swal.fire({
                title: '¿Eliminar Examen?',
                text: "Realmente desea eliminar el Examen.",
                type: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.value) {

                    axios.get(this.url + "Examen/deleteUnidadExamen", {
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
                            swal("Información", response.data.msg.msgerror, "info")
                        }
                    }).catch((error) => {
                        swal("Información", "No se puede eliminar el Examen", "info")
                    })
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
        getData(unidades) {
            vu.emptyResult = false; // become false if has a record
            vu.totalUnidades = unidades.length; //get total of user
            vu.unidades = unidades.slice(vu.currentPage * vu.rowCountPage, (vu.currentPage * vu.rowCountPage) + vu.rowCountPage); //slice the result for pagination

            // if the record is empty, go back a page
            if (vu.unidades.length == 0 && vu.currentPage > 0) {
                vu.pageUpdate(vu.currentPage - 1)
                vu.clearAll();
            }
        },

        selectUnidad(unidad) {
            vu.chooseUnidad = unidad;
        },
        clearMSG() {
            setTimeout(function () {
                vu.successMSG = ''
            }, 3000); // disappearing message success in 2 sec
        },
        clearAll() {
            vu.cargando = false;
            $("#editRegister").modal("hide");
            $("#addRegister").modal("hide");
            vu.newUnidad = {
                nombreunidad: '',
                smserror: ''
            };
            vu.formValidate = false;
            vu.refresh();

        },
        noResult() {
            vu.emptyResult = true;  // become true if the record is empty, print 'No Record Found'
            vu.unidades = null;
            vu.totalUnidades = 0; //remove current page if is empty 
        },

        pageUpdate(pageNumber) {
            vu.currentPage = pageNumber; //receive currentPage number came from pagination template
            vu.refresh();
        },
        refresh() {
            vu.search.text ? vu.searchUnidad() : vu.showAll(); //for preventing

        }
    }
})
