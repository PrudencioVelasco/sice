
var this_js_script = $('script[src*=apptarea]');
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
        tareas: [],
        file: '',
        percent: 0,
        uploadPercentage: 0,
        procesando: false,
        exito: false,
        error: false,
        search: {text: ''},
        emptyResult: false,
        newTarea: {
            descripcion: '',
            smserror: ''},
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
        //this.showAll();  
    },

    methods: {
//         orderBy(sortFn) { 
//            this.escuelas.sort(sortFn);
//        },
//         showAll(){ axios.get(this.url+"Escuela/showAll").then(function(response){
//                 if(response.data.escuelas == null){
//                     v.noResult()
//                    }else{
//                        v.getData(response.data.escuelas);
//                    }
//            })
//        }, 
//          searchEscuela(){
//            var formData = v.formData(v.search);
//              axios.post(this.url+"Escuela/searchEscuela", formData).then(function(response){
//                  if(response.data.escuelas == null){
//                      v.noResult()
//                    }else{
//                      v.getData(response.data.escuelas);
//
//                    }
//            })
//        },

        addEscuela() {
            v.procesando = true;
            v.exito = false;
            v.error = false;
            var formData = v.formData(v.newTarea);
            formData.append('file', this.file);
            axios.post(this.url + '/Tarea/contestar',
                    formData,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }
            ).then(function (response) {

                v.procesando = false;
                v.exito = true;
                v.error = false;
                $("#file").val(null);


            }).catch(function () {
                v.procesando = false;
                v.exito = false;
                v.error = true;
                $("#file").val(null);
            });
        },
        onChangeFileUpload() {
            this.file = this.$refs.file.files[0];
        },
//        updateEscuela(){
//            var formData = v.formData(v.chooseEscuela); axios.post(this.url+"Escuela/updateEscuela", formData).then(function(response){
//                if(response.data.error){
//                    v.formValidate = response.data.msg; 
//                }else{ 
//                      swal({
//                            position: 'center',
//                            type: 'success',
//                            title: 'Modificado!',
//                            showConfirmButton: false,
//                            timer: 1500
//                          });
//                    v.clearAll();
//                    v.clearMSG();
//
//                }
//            })
//        },
//         deleteEscuela(id) {
//          // body...
//            Swal.fire({
//          title: '¿Eliminar Escuela?',
//          text: "Realmente desea eliminar la Escuela.",
//          type: 'question',
//          showCancelButton: true,
//          confirmButtonColor: '#3085d6',
//          cancelButtonColor: '#d33',
//          confirmButtonText: 'Eliminar',
//          cancelButtonText: 'Cancelar'
//        }).then((result) => {
//          if (result.value) {
//
//              axios.get(this.url + "Escuela/deleteEscuela", {
//                params: {
//                    idplantel: id
//                }
//            }).then(function (response) {
//                if (response.data.escuelas == true) {
//                    //v.noResult()
//                     swal({
//                        position: 'center',
//                        type: 'success',
//                        title: 'Eliminado!',
//                        showConfirmButton: false,
//                        timer: 1500
//                    });
//                    v.clearAll();
//                    v.clearMSG();
//                } else {
//                   swal("Información", "No se puede eliminar la Escuela", "info")
//                }  
//            }).catch((error) => {
//                swal("Información", "No se puede eliminar la Escuela", "info")
//            })
//            }
//            })
//        },

        formData(obj) {
            var formData = new FormData();
            for (var key in obj) {
                formData.append(key, obj[key]);
            }
            return formData;
        },
//        getData(escuelas){
//            v.emptyResult = false; // become false if has a record
//            v.totalEscuelas = escuelas.length //get total of user
//            v.escuelas = escuelas.slice(v.currentPage * v.rowCountPage, (v.currentPage * v.rowCountPage) + v.rowCountPage); //slice the result for pagination
//
//             // if the record is empty, go back a page
//            if(v.escuelas.length == 0 && v.currentPage > 0){
//            v.pageUpdate(v.currentPage - 1)
//            v.clearAll();
//            }
//        },
//
//        selectEscuela(escuela){
//            v.chooseEscuela = escuela;
//        },
        clearMSG() {
            setTimeout(function () {
                v.successMSG = ''
            }, 3000); // disappearing message success in 2 sec
        },
        clearAll() {
            v.newTarea = {
                descripcion: '',
                smserror: ''};
            v.formValidate = false;
            v.addModal = false;
            v.editModal = false;
            v.deleteModal = false;
            v.refresh()

        },
//        noResult(){
//
//               v.emptyResult = true;  // become true if the record is empty, print 'No Record Found'
//                      v.escuelas = null;
//                     v.totalEscuelas = 0 //remove current page if is empty
//
//        },
//
//
//        pageUpdate(pageNumber){
//              v.currentPage = pageNumber; //receive currentPage number came from pagination template
//                v.refresh()
//        },
//        refresh(){
//             v.search.text ? v.searchEscuela() : v.showAll(); //for preventing
//
//        }
    }
})
