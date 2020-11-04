var this_js_script = $('script[src*=apptarea]');
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
var my_var_4 = this_js_script.attr('data-my_var_4');
if (typeof my_var_4 === "undefined") {
    var my_var_4 = 'some_default_value';
} 
Vue.config.devtools = true;
var v = new Vue({
    el: '#apptarea',
    data: {
        url: my_var_1,
        idhorario:my_var_2,
        idhorariodetalle:my_var_3,
		idmateria:my_var_4,
        addModal: false,
        editModal: false,
        //deleteModal:false,
        cargando: false,
        error: false,
        tareas: [], 
        search: {text: ''},
        emptyResult: false, 
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
    },
    methods: {
        orderBy(sortFn) {
            // sort your array data like this.userArray
            this.tareas.sort(sortFn);
        },
        abrirAddModal() {
            $('#addRegister').modal('show');
        },
        abrirEditModal() {
            $('#editRegister').modal('show');
        },
        showAll() {
            axios.get(this.url + "Tarea/showAllTareasXAsignatura", {
              params: {
                idhorario: this.idhorario,
                idhorariodetalle: this.idhorariodetalle,
				idmateria: this.idmateria
              }
            }).then(function (response) {
                if (response.data.tareas == null) {
                    v.noResult()
                } else {
                    v.getData(response.data.tareas);
                }
            })
        }, 
        searchTarea() {
            var formData = v.formData(v.search);
            axios.post(this.url + "Tarea/searchTareasAlumnoXMateria", formData,{
              params: {
                idhorario: this.idhorario,
 idhorariodetalle: this.idhorariodetalle,
                 idalumno: this.idalumno,
				idmateria: this.idmateria
              }
            }).then(function (response) {
                if (response.data.tareas == null) {
                    v.noResult()
                } else {
                    v.getData(response.data.tareas);

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
            v.emptyResult = false; // become false if has a record
            v.totalTareas = tareas.length //get total of user
            v.tareas = tareas.slice(v.currentPage * v.rowCountPage, (v.currentPage * v.rowCountPage) + v.rowCountPage); //slice the result for pagination

            // if the record is empty, go back a page
            if (v.tareas.length == 0 && v.currentPage > 0) {
                v.pageUpdate(v.currentPage - 1)
                v.clearAll();
            }
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
            v.formValidate = false;
            v.addModal = false;
            v.editModal = false;
            v.cargando = false;
            v.error = false;
            v.refresh();

        },
        noResult() {

            v.emptyResult = true;  // become true if the record is empty, print 'No Record Found'
            v.tareas = null;
            v.totalTareas = 0; //remove current page if is empty

        },

        pageUpdate(pageNumber) {
            v.currentPage = pageNumber; //receive currentPage number came from pagination template
            v.refresh();
        },
        refresh() {
            v.search.text ? v.searchTarea() : v.showAll(); //for preventing

        }
    }
})
