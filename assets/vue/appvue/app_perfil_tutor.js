
var this_js_script = $('script[src*=app_perfil_tutor]');
var my_var_1 = this_js_script.attr('data-my_var_1');
if (typeof my_var_1 === "undefined") {
    var my_var_1 = 'some_default_value';
}


Vue.config.devtools = true
Vue.component('modal', { //modal
    template: `
   <transition name="modal">
      <div class="modal-mask">
        <div class="modal-wrapper">
          <div class="modal-dialog">
			    <div class="modal-content">

			      <div class="modal-header">
				        <h5 class="modal-title"> <slot name="head"></slot></h5>
				       </div>

			      <div class="modal-body" style="background-color:#fff;">
			         <slot name="body"></slot>
			      </div>
			      <div class="modal-footer">

			         <slot name="foot"></slot>
			      </div>
			    </div>
          </div>
        </div>
      </div>
    </transition>
    `
})
var v = new Vue({
    el: '#app',
    data: {
        url: my_var_1,
        addModal: false,
        editModal: false,
        editPasswordModal: false,
        cargando: false,
        error: false, 
        alumnos: [],
        datos_tutor: [],
        url_image: my_var_1 +'/assets/tutores/',
        especialidades: [],
        tipossanguineos: [], 
        search: { text: '' },
        emptyResult: false, 
        chooseAlumno: {},
        formValidate: [],
        file:'',
        cambiarPassword: {
           
            passwordanterior: '',
            passwordnueva: '',
            passwordrepita: '',
            smserror: ''},
        successMSG: '',

        //pagination
        currentPage: 0,
        rowCountPage: 10,
        totalAlumnos: 0,
        pageRange: 2,
        directives: { columnSortable }
    },
    created() {
        this.showAll(); 
        this.detalleTutor(); 
        this.showAllEspecialidades();
        this.showAllTiposSanguineos();
    },
    methods: {
        abrirAddModal() {
            $('#addRegister').modal('show');
        },
        abrirEditModal() {
            $('#editRegister').modal('show');
        },
        abrirSubirFotoModal() {
            $('#subirFoto').modal('show');
        },
        orderBy(sortFn) {
            // sort your array data like this.userArray
            this.alumnos.sort(sortFn);
        },
        
    showAllEspecialidades() {
        axios.get(this.url + "Alumno/showAllEspecialidades/")
            .then(response => (this.especialidades = response.data.especialidades));

    }, 
    showAllTiposSanguineos() {
        axios.get(this.url + "Alumno/showAllTiposSanguineos/")
            .then(response => (this.tipossanguineos = response.data.tipossanguineos));

    },  
        showAll() {
            axios.get(this.url + "Perfil/showAllAlumnoTutor").then(function (response) {
                if (response.data.alumnos == null) {
                    v.noResult()
                } else {
                    v.getData(response.data.alumnos);
                }
            })
        },
        detalleTutor() {
            axios.get(this.url + "Perfil/showDatosTutor/")
                .then(response => (this.datos_tutor = response.data.datos_tutor));

        },
       
        searchAlumno() {
            var formData = v.formData(v.search);
            axios.post(this.url + "Perfil/searchAlumnosTutor", formData).then(function (response) {
                if (response.data.alumnos == null) {
                    v.noResult()
                } else {
                    v.getData(response.data.alumnos);

                }
            })
        }, 
        updateDatosTutor(){
            v.error = false;
            v.cargando = true;
            var formData = v.formData(v.datos_tutor); axios.post(this.url + "Perfil/updateDatosTutor", formData).then(function (response) {
                if (response.data.error) {
                    v.formValidate = response.data.msg;
                    v.cargando = false;
                    v.error = true;
                } else {
                    //v.successMSG = response.data.success;
                    v.clearAll();
                    v.clearMSG();
                    swal({
                        position: 'center',
                        type: 'success',
                        title: 'Modificado!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                  

                }
            })
        },
        updateAlumno() {
            v.error = false;
            v.cargando = true;
            var formData = v.formData(v.chooseAlumno); axios.post(this.url + "Perfil/updateAlumno", formData).then(function (response) {
                if (response.data.error) {
                    v.formValidate = response.data.msg;
                    v.cargando = false;
                    v.error = true;
                } else {
                    //v.successMSG = response.data.success;
                    v.clearAll();
                    v.clearMSG();
                    swal({
                        position: 'center',
                        type: 'success',
                        title: 'Modificado!',
                        showConfirmButton: false,
                        timer: 1500
                    });


                }
            })
        }, 
        subirFoto() {
            v.error = false;
            v.cargando = true;
            var formData = v.formData();
            formData.append('file',this.file); 
            axios.post(this.url + "Perfil/subirFotoTutor", formData,{
                headers:{
                    'Content-Type':'multipart/form-dara'
                }
            }).then(function (response) {
                if (response.data.error) {
                    v.formValidate = response.data.msg;
                    v.error = true;
                    v.cargando = false;
                } else {
                    //v.successMSG = response.data.success;
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
            }).catch(function(){
                console.log('ERROR AL SUBIR LA IMAGEN.');
            })
        },
        onChangeFileUpload(){
            this.file = this.$refs.file.files[0];
        },
        updatePasswordTutor() {
            v.error = false;
            v.cargando = true;
            var formData = v.formData(v.cambiarPassword); axios.post(this.url + "Perfil/updatePasswordTutor", formData).then(function (response) {
                if (response.data.error) {
                    v.formValidate = response.data.msg;
                    v.error = true;
                    v.cargando = false;
                } else {
                    //v.successMSG = response.data.success;
                    v.clearAll();
                    v.clearMSG();
                    swal({
                        position: 'center',
                        type: 'success',
                        title: 'Modificado!',
                        showConfirmButton: false,
                        timer: 1500
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
        getData(alumnos) {
            v.emptyResult = false; // become false if has a record
            v.totalAlumnos = alumnos.length //get total of user
            v.alumnos = alumnos.slice(v.currentPage * v.rowCountPage, (v.currentPage * v.rowCountPage) + v.rowCountPage); //slice the result for pagination

            // if the record is empty, go back a page
            if (v.alumnos.length == 0 && v.currentPage > 0) {
                v.pageUpdate(v.currentPage - 1)
                v.clearAll();
            }
        },

        selectAlumno(alumno) {
            v.chooseAlumno = alumno;
             
        },
        clearMSG() {
            setTimeout(function () {
                v.successMSG = ''
            }, 3000); // disappearing message success in 2 sec
        },
        clearAll() {
            v.detalleTutor(); 
            $('#editRegister').modal('hide');
            $('#addRegister').modal('hide');
            $('#subirFoto').modal('hide'); 
            v.cambiarPassword = {
                
                passwordanterior: '',
                passwordnueva: '',
                passwordrepita: '',
                smserror: ''
            },
            v.formValidate = false;
            v.addModal = false;
            v.editPasswordModal = false;
            v.editModal = false;
            v.error = false;
            v.cargando = false; 
            v.file = '';
            this.$refs.file.files[0] = '';
            v.refresh()

        },
        noResult() {

            v.emptyResult = true;  // become true if the record is empty, print 'No Record Found'
            v.alumnos = null
            v.totalAlumnos = 0 //remove current page if is empty

        },


        pageUpdate(pageNumber) {
            v.currentPage = pageNumber; //receive currentPage number came from pagination template
            v.refresh()
        },
        refresh() {
            v.search.text ? v.searchAlumno() : v.showAll(); //for preventing

        }
    }
})
