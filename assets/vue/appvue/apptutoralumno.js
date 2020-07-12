
var this_js_script = $('script[src*=apptutoralumno]');
var my_var_1 = this_js_script.attr('data-my_var_1'); 
if (typeof my_var_1 === "undefined") {
    var my_var_1 = 'some_default_value';
} 
var my_var_2 = this_js_script.attr('data-my_var_2'); 
if (typeof my_var_2 === "undefined") {
    var my_var_2 = 'some_default_value';
} 


Vue.config.devtools = true 
var v = new Vue({
   el:'#app',
    data:{
        url: my_var_1,
        idtutor:my_var_2,
        addModal: false,
        editModal:false,
        cargando:false,
        error:false,
        url_image: my_var_1 + '/assets/tutores/',
        file: '',
        alumnos:[], 
        alumnosposibles:[], 
        datos_tutor:[],
        search: {text: ''},
        emptyResult:false,
        newAlumno:{
            idtutor:my_var_2,
            idalumno:'',
            smserror:''},
        chooseAlumno:{},
        formValidate:[],
        successMSG:'',

        //pagination
        currentPage: 0,
        rowCountPage:10,
        totalAlumnos:0,
        pageRange:2,
         directives: {columnSortable}
    },
     created(){
      this.showAll(); 
       this.showAllAlumnos(); 
       this.showDetalleTutor();
    },
    methods:{
         orderBy(sortFn) {
            // sort your array data like this.userArray
            this.alumnos.sort(sortFn);
        },
      abrirAddModal() {
        $('#addRegister').modal('show');
      },
          showAll() {

            axios.get(this.url+"Tutor/showAllTutorAlumnos/"+this.idtutor)
                    .then(response => (this.alumnos = response.data.alumnos));

        },
      abrirSubirFotoModal() {
        $('#subirFoto').modal('show');
      },
      showDetalleTutor() {

        axios.get(this.url + "Tutor/showDetalleTutor/", {
          params: {
            idtutor: this.idtutor
          }
        }).then(response => (this.datos_tutor = response.data.detalle_tutor));

      },
        showAllAlumnos() {

            axios.get(this.url+"Tutor/showAllAlumnos/"+this.idtutor)
                    .then(response => (this.alumnosposibles = response.data.alumnos));

        },

          addAlumno(){
            v.cargando = true;
            v.error = false;
            var formData = v.formData(v.newAlumno);
              axios.post(this.url+"Tutor/addTutorAlumno", formData).then(function(response){
                if(response.data.error){
                    v.formValidate = response.data.msg;
                    v.error = true;
                    v.cargando = false;
                }else{
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
        deleteAlumno(id){ 

          Swal.fire({
            title: 'Quitar Alumno?',
            text: "Realmente desea quitar el Alumno.",
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Quitar',
            cancelButtonText: 'Cancelar'
          }).then((result) => {
            if (result.value) {

              axios.get(this.url + "Tutor/deleteAlumno", {
                params: {
                  id: id
                }
              }).then(function (response) {
                if (response.data.alumnos == true) {
                  //v.noResult()
                  swal({
                    position: 'center',
                    type: 'success',
                    title: 'Quitado!',
                    showConfirmButton: false,
                    timer: 3000
                  });
                  v.clearAll();
                  v.clearMSG();
                } else {
                  swal("Información", "No se puede quitar el Alumno", "info")
                }
              }).catch((error) => {
                swal("Información", "No se puede quitar el Alumno", "info")
              })
            }
          })

             
        },
         formData(obj){
			var formData = new FormData();
		      for ( var key in obj ) {
		          formData.append(key, obj[key]);
		      }
		      return formData;
    },
      subirFoto() {
        v.error = false;
        v.cargando = true;
        var formData = v.formData();
        formData.append('file', this.file);
        formData.append('idtutor', this.idtutor);
        axios.post(this.url + "Tutor/subirFoto", formData, {
          headers: {
            'Content-Type': 'multipart/form-dara'
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
        }).catch(function () {
          console.log('ERROR AL SUBIR LA IMAGEN.');
        })
      },
      onChangeFileUpload() {
        this.file = this.$refs.file.files[0];
      },
        getData(alumnos){
            v.emptyResult = false; // become false if has a record
            v.totalAlumnos = alumnos.length //get total of user
            v.alumnos = alumnos.slice(v.currentPage * v.rowCountPage, (v.currentPage * v.rowCountPage) + v.rowCountPage); //slice the result for pagination

             // if the record is empty, go back a page
            if(v.alumnos.length == 0 && v.currentPage > 0){
            v.pageUpdate(v.currentPage - 1)
            v.clearAll();
            }
        },

        selectUser(tutor){
            v.chooseAlumno = alumno;
        },
        clearMSG(){
            setTimeout(function(){
			 v.successMSG=''
			 },3000); // disappearing message success in 2 sec
        },
        clearAll(){
          $('#subirFoto').modal('hide'); 
          $('#addRegister').modal('hide');
          v.showDetalleTutor();
            v.newAlumno = {
            idtutor:my_var_2,
            idalumno:'',
            smserror:''};
            v.formValidate = false;
            v.addModal= false;
            v.editModal=false;
            v.passwordModal=false;
            v.deleteModal=false;
            v.cargando = false;
            v.error = false;
            v.refresh()

        },
        noResult(){

               v.emptyResult = true;  // become true if the record is empty, print 'No Record Found'
                      v.alumnos = null
                     v.totalAlumnos = 0 //remove current page if is empty

        },


        pageUpdate(pageNumber){
              v.currentPage = pageNumber; //receive currentPage number came from pagination template
                v.refresh()
        },
        refresh(){
             v.search.text ? v.searchAlumno() : v.showAll(); //for preventing

        }
    }
})
