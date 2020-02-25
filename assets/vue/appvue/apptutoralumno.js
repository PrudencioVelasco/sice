
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
Vue.component('modal',{ //modal
    template:`
   <transition name="modal">
      <div class="modal-mask">
        <div class="modal-wrapper">
          <div class="modal-dialog">
			    <div class="modal-content">


			      <div class="modal-header">
				        <h5 class="modal-title"> <slot name="head"></slot></h5>
				       <i class="fa fa-window-close  icon-md text-danger" @click="$emit('close')"></i>
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
        idtutor:my_var_2,
        addModal: false,
        editModal:false,
        //deleteModal:false,
        alumnos:[], 
        alumnosposibles:[], 
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
    },
    methods:{
         orderBy(sortFn) {
            // sort your array data like this.userArray
            this.alumnos.sort(sortFn);
        },
          showAll() {

            axios.get(this.url+"Tutor/showAllTutorAlumnos/"+this.idtutor)
                    .then(response => (this.alumnos = response.data.alumnos));

        },
        showAllAlumnos() {

            axios.get(this.url+"Tutor/showAllAlumnos/"+this.idtutor)
                    .then(response => (this.alumnosposibles = response.data.alumnos));

        },

          addAlumno(){
            var formData = v.formData(v.newAlumno);
              axios.post(this.url+"Tutor/addTutorAlumno", formData).then(function(response){
                if(response.data.error){
                    v.formValidate = response.data.msg;
                }else{
                    swal({
            					  position: 'center',
            					  type: 'success',
            					  title: 'Exito!',
            					  showConfirmButton: false,
            					  timer: 1500
            					}); 
                    v.clearAll();
                    v.clearMSG();
                }
               })
        }, 
        deleteAlumno(id){
       // var formData = v.formData(v.chooseHorario);
        //console.log(id);
             
           Swal.fire({
          title: '¿Quitar elemento?',
          text: "Realmente desea eliminar el elemento seleccionado",
          type: 'info',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Eliminar',
          cancelButtonText: 'Cancelar'
        }).then((result) => {
          if (result.value) {
             axios.get(this.url+"Tutor/deleteAlumno/"+id).then(function(response){
                
                  //console.log(response.data);
               v.clearAll();
                    v.clearMSG();
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
            v.newAlumno = {
            idtutor:my_var_2,
            idalumno:'',
            smserror:''};
            v.formValidate = false;
            v.addModal= false;
            v.editModal=false;
            v.passwordModal=false;
            v.deleteModal=false;
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
