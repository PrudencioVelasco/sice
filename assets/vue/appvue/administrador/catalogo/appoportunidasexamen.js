
var this_js_script2 = $('script[src*=appoportunidasexamen]');
var my_var_2 = this_js_script2.attr('data-my_var_2');
if (typeof my_var_2 === "undefined") {
    var my_var_2 = 'some_default_value';
}


Vue.config.devtools = true;
var vo = new Vue({
    el: '#appoportunidades',
    data: {
        url: my_var_2,
        addModal: false,
        editModal: false,
        cargando: false,
        error: false,
        oportunidades: [],
        search: {text: ''},
        emptyResult: false,
        newOportunidad: {
            nombreoportunidad: '',
            smserror: ''},
        chooseOportunidad: {},
        formValidate: [],
        successMSG: '',

        //pagination
        currentPage: 0,
        rowCountPage: 10,
        totalOportunidades: 0,
        pageRange: 2,
        directives: {columnSortable}
    },
    created() {
        this.showAll();
    },
    methods: {
        orderBy(sortFn) {
            // sort e array data like this.userArray
            this.oportunidades.sort(sortFn);
        },
        abrirAddModal() {
            $("#addRegisterO").modal("show");
        },
        abrirEditModal() {
            $("#editRegisterO").modal("show");
        },
        showAll() {
            axios.get(this.url + "Examen/showAllOportunidades").then(function (response) {
                if (response.data.oportunidades == null) {
                    vo.noResult()
                } else {
                    vo.getData(response.data.oportunidades);
                }
            })
        },
        searchOportunidad() {
            var formData = vo.formData(vo.search);
            axios.post(this.url + "Examen/searchOportunidades", formData).then(function (response) {
                if (response.data.oportunidades == null) {
                    vo.noResult()
                } else {
                    vo.getData(response.data.oportunidades);

                }
            })
        },
        addOportunidad() {
            vo.cargando = true;
            vo.error = false;
            var formData = vo.formData(vo.newOportunidad);
            axios.post(this.url + "Examen/addOportunidad", formData).then(function (response) {
                if (response.data.error) {
                    vo.formValidate = response.data.msg;
                    vo.error = true;
                    vo.cargando = false;
                } else {
                    swal({
                        position: 'center',
                        type: 'success',
                        title: 'Exito!',
                        showConfirmButton: false,
                        timer: 1500
                    });

                    vo.clearAll();
                    vo.clearMSG();
                }
            })
        },
        updateOportunidad() {
            vo.cargando = true;
            vo.error = false;
            var formData = vo.formData(vo.chooseOportunidad);
            axios.post(this.url + "Examen/updateOportunidad", formData).then(function (response) {
                if (response.data.error) {
                    vo.formValidate = response.data.msg;
                    vo.error = true;
                    vo.cargando = false;
                } else {
                    //v.successMSG = response.data.success;
                    swal({
                        position: 'center',
                        type: 'success',
                        title: 'Modificado!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    vo.clearAll();
                    vo.clearMSG();

                }
            })
        },
        deleteOportunidad(id) {
            Swal.fire({
                title: '¿Eliminar Oportunidad?',
                text: "Realmente desea eliminar la Oportunidad.",
                type: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.value) {

                    axios.get(this.url + "Examen/deleteOportunidad", {
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
                            vo.clearAll();
                            vo.clearMSG();
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
        getData(oportunidades) {
            vo.emptyResult = false; // become false if has a record
            vo.totalOportunidades = oportunidades.length; //get total of user
            vo.oportunidades = oportunidades.slice(vo.currentPage * vo.rowCountPage, (vo.currentPage * vo.rowCountPage) + vo.rowCountPage); //slice the result for pagination

            // if the record is empty, go back a page
            if (vo.oportunidades.length == 0 && vo.currentPage > 0) {
                vo.pageUpdate(vo.currentPage - 1)
                vo.clearAll();
            }
        },

        selectOportunidad(oportunidad) {
            vo.chooseOportunidad = oportunidad;
        },
        clearMSG() {
            setTimeout(function () {
                vo.successMSG = ''
            }, 3000); // disappearing message success in 2 sec
        },
        clearAll() {
            vo.cargando = false;
            $("#editRegisterO").modal("hide");
            $("#addRegisterO").modal("hide");
            vo.newOportunidad = {
                nombreoportunidad : '',
                smserror: ''};
            vo.formValidate = false;
            vo.refresh();

        },
        noResult() {
            vo.emptyResult = true;  // become true if the record is empty, print 'No Record Found'
            vo.oportunidades = null;
            vo.totalOportunidades = 0; //remove current page if is empty 
        },

        pageUpdate(pageNumber) {
            vo.currentPage = pageNumber; //receive currentPage number came from pagination template
            vo.refresh();
        },
        refresh() {
            vo.search.text ? vo.searchOportunidad() : vo.showAll(); //for preventing

        }
    }
})
