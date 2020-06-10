
var this_js_script = $('script[src*=appmateria]');
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
        editModal:false, 
        //deleteModal:false,
        materias:[], 
        niveles:[], 
        especialidades:[],  
        search: {text: ''},
        emptyResult:false,
        newMateria:{
            idplantel:'',
            idnivelestudio:'',
            idespecialidad:'',
            nombreclase:'', 
            clave:'', 
            credito:'', 
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
        this.showAllNiveles(); 
        this.showAllEspecialidades(); 
    },
    methods:{
         orderBy(sortFn) {
            // sort your array data like this.userArray
            this.materias.sort(sortFn);
        },
         showAll(){ axios.get(this.url+"Materia/showAll").then(function(response){
                 if(response.data.materias == null){
                     v.noResult()
                    }else{
                        v.getData(response.data.materias);
                    }
            })
        },  
        showAllEspecialidades(){ 
          axios.get(this.url+"Materia/showAllEspecialidades/")
                    .then(response => (this.especialidades = response.data.especialidades));

        },  
        showAllNiveles(){  
             axios.get(this.url+"Materia/showAllNiveles/")
                    .then(response => (this.niveles = response.data.niveles));

        }, 
          searchMateria(){
            var formData = v.formData(v.search);
              axios.post(this.url+"Materia/searchMateria", formData).then(function(response){
                  if(response.data.materias == null){
                      v.noResult()
                    }else{
                      v.getData(response.data.materias);

                    }
            })
        },
          addMateria(){
            var formData = v.formData(v.newMateria);
              axios.post(this.url+"Materia/addMateria", formData).then(function(response){
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
        updateMateria(){
            var formData = v.formData(v.chooseMateria); axios.post(this.url+"Materia/updateMateria", formData).then(function(response){
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
         deleteMateria(id){
            Swal.fire({
          title: '¿Eliminar Materia?',
          text: "Realmente desea eliminar la Materia.",
          type: 'info',
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
                if (response.data.materias == true) {
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
                   swal("Error", "No se puede eliminar la Materia", "error")
                }
                console.log(response);
            }).catch((error) => {
                swal("Error", "No se puede eliminar la Materia", "error")
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
            //console.log(alumno);
        },
        clearMSG(){
            setTimeout(function(){
			 v.successMSG=''
			 },3000); // disappearing message success in 2 sec
        },
        clearAll(){
            v.newMateria = {
              idplantel:'',
              idnivelestudio:'',
              idespecialidad:'',
              nombreclase:'', 
              clave:'', 
              credito:'', 
              smserror:''};
            v.formValidate = false;
            v.addModal= false; 
            v.editModal=false; 
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
