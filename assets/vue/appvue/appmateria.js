var this_js_script = $('script[src*=appmateria]');
var my_var_1 = this_js_script.attr('data-my_var_1');
if (typeof my_var_1 === "undefined") {
    var my_var_1 = 'some_default_value';
} 
Vue.config.devtools = true;
var v = new Vue({
    el: '#app',
    data: {
        url: my_var_1,
        addModal: false,
        editModal: false,
        //deleteModal:false,
        cargando: false,
        error: false,
        materias: [],
        niveles: [],
        especialidades: [],
        clasificacion_materia: [],
        search: {text: ''},
        emptyResult: false,
        newMateria: {
            idplantel: '',
            idnivelestudio: '',
            idespecialidad: '',
            idclasificacionmateria: '',
            nombreclase: '',
            clave: '',
            credito: '',
            unidades:'',
            smserror: ''},
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
        this.showAllNiveles();
        this.showAllEspecialidades();
        this.showAllClasificaciones();
    },
    methods: {
        orderBy(sortFn) {
            // sort your array data like this.userArray
            this.materias.sort(sortFn);
        },
        abrirAddModal() {
            $('#addRegister').modal('show');
        },
        abrirEditModal() {
            $('#editRegister').modal('show');
        },
        showAll() {
            axios.get(this.url + "Materia/showAll").then(function (response) {
                if (response.data.materias == null) {
                    v.noResult()
                } else {
                    v.getData(response.data.materias);
                }
            })
        },
        showAllEspecialidades() {
            axios.get(this.url + "Materia/showAllEspecialidades/")
                    .then(response => (this.especialidades = response.data.especialidades));

        },
        showAllClasificaciones() {
            axios.get(this.url + "Materia/showAllClasificaciones/")
                    .then(response => (this.clasificacion_materia = response.data.clasificaciones));

        },
        showAllNiveles() {
            axios.get(this.url + "Materia/showAllNiveles/")
                    .then(response => (this.niveles = response.data.niveles));

        },
        searchMateria() {
            var formData = v.formData(v.search);
            axios.post(this.url + "Materia/searchMateria", formData).then(function (response) {
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
            axios.post(this.url + "Materia/addMateria", formData).then(function (response) {
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
        updateMateria() {
            v.cargando = true;
            v.error = false;
            var formData = v.formData(v.chooseMateria);
            axios.post(this.url + "Materia/updateMateria", formData).then(function (response) {
                if (response.data.error) {
                    v.formValidate = response.data.msg;
                    v.error = true;
                    v.cargando = false;
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
        deleteMateria(id) {
            Swal.fire({
                title: '¿Eliminar Materia?',
                text: "Realmente desea eliminar la Materia.",
                type: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.value) {

                    axios.get(this.url + "Materia/deleteMateria", {
                        params: {
                            idmateria: id
                        }
                    }).then(function (response) {
                        if (response.data.error == false) {
                            //v.noResult()
                            swal({
                                position: 'center',
                                type: 'success',
                                title: 'Eliminado!',
                                showConfirmButton: false,
                                timer: 1500
                            });
                            v.clearAll();
                            v.clearMSG();
                        } else {
                            swal("Información", response.data.msg.msgerror, "info")
                        }
                    }).catch((error) => {
                        swal("Información", "No se puede eliminar la Materia", "info")
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
                idplantel: '',
                idnivelestudio: '',
                idespecialidad: '',
                idclasificacionmateria: '',
                nombreclase: '',
                clave: '',
                credito: '',
                unidades:'',
                smserror: ''};
            v.formValidate = false;
            v.addModal = false;
            v.editModal = false;
            v.cargando = false;
            v.error = false;
            v.refresh();

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
