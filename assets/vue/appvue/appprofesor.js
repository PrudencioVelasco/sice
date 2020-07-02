
var this_js_script = $('script[src*=appprofesor]');
var my_var_1 = this_js_script.attr('data-my_var_1'); 
if (typeof my_var_1 === "undefined") {
    var my_var_1 = 'some_default_value';
} 


Vue.config.devtools = true
Vue.component('modal',{ //modal
    template:`
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
   el:'#app',
    data:{
        url: my_var_1,
        addModal: false,
        addModalPassword: false,
        editModal:false,
        cargando:false,
        error:false,
        //deleteModal:false,
        profesores:[], 
        search: {text: ''},
        emptyResult:false,
        newProfesor:{
            cedula:'',
            nombre:'',
            apellidop:'',
            apellidom:'', 
            profesion:'', 
            correo:'',
            password:'',
            repitapassword:'',
            smserror:''},
        chooseProfesor:{},
        formValidate:[],
        successMSG:'',

        //pagination
        currentPage: 0,
        rowCountPage:10,
        totalProfesores:0,
        pageRange:2,
         directives: {columnSortable}
    },
     created(){
      this.showAll(); 
    },
    methods:{
         orderBy(sortFn) {
            // sort your array data like this.userArray
            this.profesores.sort(sortFn);
        }, 
        abrirAddModal() {
            $('#addRegister').modal('show');
        },
        abrirEditModal() {
            $('#editRegister').modal('show');
        },
        abrirChangeModal() {
            $('#changePassword').modal('show');
        },
         showAll(){ axios.get(this.url+"Profesor/showAll").then(function(response){
                 if(response.data.profesores == null){
                     v.noResult()
                    }else{
                        v.getData(response.data.profesores);
                    }
            })
        }, 
          searchProfesor(){
            var formData = v.formData(v.search);
              axios.post(this.url+"Profesor/searchProfesor", formData).then(function(response){
                  if(response.data.profesores == null){
                      v.noResult()
                    }else{
                      v.getData(response.data.profesores);

                    }
            })
        },
          addProfesor(){
              v.cargando = true;
              v.error = false;
            var formData = v.formData(v.newProfesor);
              axios.post(this.url+"Profesor/addProfesor", formData).then(function(response){
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
        deleteProfesor(id) {
             Swal.fire({
          title: '¿Eliminar Profesor?',
          text: "Realmente desea eliminar el Profesor.",
          type: 'question',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Eliminar',
          cancelButtonText: 'Cancelar'
        }).then((result) => {
          if (result.value) {

              axios.get(this.url + "Profesor/deleteProfesor", {
                params: {
                    idprofesor: id
                }
            }).then(function (response) {
                if (response.data.profesores == true) {
                    //v.noResult()
                     swal({
                        position: 'center',
                        type: 'success',
                        title: 'Eliminado!',
                        showConfirmButton: false,
                        timer: 3000
                    });
                    v.clearAll();
                    v.clearMSG();
                } else {
                    swal("Información", "No se puede eliminar el Profesor", "info")
                } 
            }).catch((error) => {
                swal("Información", "No se puede eliminar el Profesor", "info")
            })
            }
            })
        },
        updateProfesor(){
            v.cargando = true;
            v.error = false;
            var formData = v.formData(v.chooseProfesor); axios.post(this.url+"Profesor/updateProfesor", formData).then(function(response){
                if(response.data.error){
                    v.formValidate = response.data.msg; 
                    v.error = true;
                    v.cargando = false;
                }else{
                    //v.successMSG = response.data.success;
                      swal({
                            position: 'center',
                            type: 'success',
                            title: 'Modificado!',
                            showConfirmButton: false,
                            timer: 1500
                          });
                    v.clearAll();
                    v.clearMSG();

                }
            })
        },
         updatePasswordProfesor(){
             v.cargando = true;
             v.error = false;
            var formData = v.formData(v.chooseProfesor); axios.post(this.url+"Profesor/updatePasswordProfesor", formData).then(function(response){
                if(response.data.error){
                    v.formValidate = response.data.msg; 
                    v.error = true;
                    v.cargando = false;
                }else{
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
         
       /* deleteUser(){
             var formData = v.formData(v.chooseUser);
              axios.post(this.url+"user/deleteUser", formData).then(function(response){
                if(!response.data.error){
                     v.successMSG = response.data.success;
                    v.clearAll();
                    v.clearMSG();
                }
            })
        },*/
         formData(obj){
			var formData = new FormData();
		      for ( var key in obj ) {
		          formData.append(key, obj[key]);
		      }
		      return formData;
		},
        getData(profesores){
            v.emptyResult = false; // become false if has a record
            v.totalProfesores = profesores.length //get total of user
            v.profesores = profesores.slice(v.currentPage * v.rowCountPage, (v.currentPage * v.rowCountPage) + v.rowCountPage); //slice the result for pagination

             // if the record is empty, go back a page
            if(v.profesores.length == 0 && v.currentPage > 0){
            v.pageUpdate(v.currentPage - 1)
            v.clearAll();
            }
        },

        selectProfesor(profesor){
            v.chooseProfesor = profesor;
        },
        clearMSG(){
            setTimeout(function(){
			 v.successMSG=''
			 },3000); // disappearing message success in 2 sec
        },
        clearAll(){
            $('#editRegister').modal('hide');
            $('#addRegister').modal('hide');
            $('#changePassword').modal('hide');
            v.newProfesor = {
            cedula:'',
            nombre:'',
            apellidop:'',
            apellidom:'', 
            profesion:'', 
            correo:'',
            password:'',
            repitapassword:'',
            smserror:''};
            v.formValidate = false;
            v.addModal= false;
            v.editModal=false;
            v.passwordModal=false;
            v.deleteModal=false;
            v.addModalPassword =false;
            v.cargando = false;
            v.error = false;
            v.refresh()

        },
        noResult(){

               v.emptyResult = true;  // become true if the record is empty, print 'No Record Found'
                      v.profesores = null
                     v.totalProfesores = 0 //remove current page if is empty

        },


        pageUpdate(pageNumber){
              v.currentPage = pageNumber; //receive currentPage number came from pagination template
                v.refresh()
        },
        refresh(){
             v.search.text ? v.searchProfesor() : v.showAll(); //for preventing

        }
    }
})
