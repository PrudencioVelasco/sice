
var this_js_script = $('script[src*=appprofesormateria]');
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
        idprofesor: my_var_2,
        addModal: false,
        editModal:false,
        //deleteModal:false,
        materias:[],
        clases:[], 
        search: {text: ''},
        emptyResult:false,
        newMateria:{
            idprofesor:my_var_2,
            idmateria:'',
            smserror:''},
        chooseMateria:{},
        formValidate:[],
        successMSG:'',

        //pagination
        currentPage: 0,
        rowCountPage:10,
        totalMaterias:0,
        pageRange:2,
         directives: {columnSortable}
    },
     created(){
      this.showAll(); 
      this.showAllClases();
    },
    methods:{
         orderBy(sortFn) {
            // sort your array data like this.userArray
            this.materias.sort(sortFn);
        },
         showAllClases() {

            axios.get(this.url+"Profesor/showAllClases/")
                    .then(response => (this.clases = response.data.clases));

        },
         showAll(){ axios.get(this.url+"Profesor/showAllMaterias/"+this.idprofesor).then(function(response){
                 if(response.data.materias == null){
                     v.noResult()
                    }else{
                        v.getData(response.data.materias);
                    }
            })
        }, 
          searchMateria(){
            var formData = v.formData(v.search);
              axios.post(this.url+"Profesor/searchllClases", formData).then(function(response){
                  if(response.data.materias == null){
                      v.noResult()
                    }else{
                      v.getData(response.data.materias);

                    }
            })
        },
          addMateria(){
            var formData = v.formData(v.newMateria);
              axios.post(this.url+"Profesor/addMateria", formData).then(function(response){
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
        deleteMateria(id){
       // var formData = v.formData(v.chooseHorario);
        //console.log(id);
             
           Swal.fire({
          title: '¿Eliminar elemento?',
          text: "Realmente desea eliminar el elemento seleccionado",
          type: 'info',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Eliminar',
          cancelButtonText: 'Cancelar'
        }).then((result) => {
          if (result.value) {
             axios.get(this.url+"Profesor/deleteMateria/"+id).then(function(response){
                
                  //console.log(response.data);
                //v.cargar();
                v.clearAll();
                    v.clearMSG();
            }) 
          }
        })

             
        },
        updateMateria(){
            var formData = v.formData(v.chooseMateria); axios.post(this.url+"Profesor/updateMateria", formData).then(function(response){
                if(response.data.error){
                    v.formValidate = response.data.msg;
                    console.log(response.data.error)
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
        getData(materias){
            v.emptyResult = false; // become false if has a record
            v.totalMaterias = materias.length //get total of user
            v.materias = materias.slice(v.currentPage * v.rowCountPage, (v.currentPage * v.rowCountPage) + v.rowCountPage); //slice the result for pagination

             // if the record is empty, go back a page
            if(v.materias.length == 0 && v.currentPage > 0){
            v.pageUpdate(v.currentPage - 1)
            v.clearAll();
            }
        },

        selectMateria(materia){
            v.chooseMateria = materia;
        },
        clearMSG(){
            setTimeout(function(){
			 v.successMSG=''
			 },3000); // disappearing message success in 2 sec
        },
        clearAll(){
            v.newMateria = {
               idprofesor:my_var_2,
               idmateria:'',
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
                      v.materias = null
                     v.totalMaterias = 0 //remove current page if is empty

        },


        pageUpdate(pageNumber){
              v.currentPage = pageNumber; //receive currentPage number came from pagination template
                v.refresh()
        },
        refresh(){
             v.search.text ? v.searchMateria() : v.showAll(); //for preventing

        }
    }
})
