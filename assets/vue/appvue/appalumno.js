
var this_js_script = $('script[src*=app]');
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
        editPasswordModal:false,
        //deleteModal:false,
        alumnos:[], 
        especialidades:[], 
        tipossanguineos: [], 
        search: {text: ''},
        emptyResult:false,
        newAlumno:{
            idespecialidad:'',
            matricula:'',
            curp: '',
            nombre:'',
            apellidop:'',
            apellidom:'', 
            lugarnacimiento: '',
            nacionalidad: '',
            domicilio: '',
            telefono: '',
            telefonoemergencia: '',
            serviciomedico:'',
            idtiposanguineo: '',
            alergiaopadecimiento: '',
            peso: '',
            estatura: '',
            numfolio: '',
            numacta: '',
            numlibro: '',
            fechanacimiento:'', 
            foto:'', 
            sexo:'',
            correo:'',
            password:'',
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
      this.showAllEspecialidades(); 
       this.showAllTiposSanguineos();
    },
    methods:{
         orderBy(sortFn) {
            // sort your array data like this.userArray
            this.alumnos.sort(sortFn);
        },
         showAll(){ axios.get(this.url+"Alumno/showAll").then(function(response){
                 if(response.data.alumnos == null){
                     v.noResult()
                    }else{
                        v.getData(response.data.alumnos);
                    }
            })
        }, 
        showAllEspecialidades(){ 
          axios.get(this.url+"Alumno/showAllEspecialidades/")
                    .then(response => (this.especialidades = response.data.especialidades));

        }, 
      showAllTiposSanguineos() {
        axios.get(this.url + "Alumno/showAllTiposSanguineos/")
          .then(response => (this.tipossanguineos = response.data.tipossanguineos));

      },  
          searchAlumno(){
            var formData = v.formData(v.search);
              axios.post(this.url+"Alumno/searchAlumno", formData).then(function(response){
                  if(response.data.alumnos == null){
                      v.noResult()
                    }else{
                      v.getData(response.data.alumnos);

                    }
            })
        },
          addAlumno(){
            var formData = v.formData(v.newAlumno);
              axios.post(this.url+"Alumno/addAlumno", formData).then(function(response){
                if(response.data.error){
                    v.formValidate = response.data.msg;
                }else{
                  console.log("aqui");
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
        updateAlumno(){
            var formData = v.formData(v.chooseAlumno); axios.post(this.url+"Alumno/updateAlumno", formData).then(function(response){
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
        deleteAlumno(id) {
             Swal.fire({
          title: '¿Eliminar Alumno?',
          text: "Realmente desea eliminar el Alumno.",
          type: 'info',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Eliminar',
          cancelButtonText: 'Cancelar'
        }).then((result) => {
          if (result.value) {

              axios.get(this.url + "Alumno/deleteAlumno", {
                params: {
                    idalumno: id
                }
            }).then(function (response) {
                if (response.data.alumnos == true) {
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
                   swal("Error", "No se puede eliminar el Alumno", "error")
                }
                console.log(response);
            }).catch((error) => {
                swal("Error", "No se puede eliminar el Alumno", "error")
            })
            }
            })
        },
        updatePasswordAlumno(){
            var formData = v.formData(v.chooseAlumno); axios.post(this.url+"Alumno/updatePasswordAlumno", formData).then(function(response){
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

        selectAlumno(alumno){
            v.chooseAlumno = alumno;
            console.log(alumno);
        },
        clearMSG(){
            setTimeout(function(){
			 v.successMSG=''
			 },3000); // disappearing message success in 2 sec
        },
        clearAll(){
            v.newAlumno = {
              matricula: '',
              curp: '',
              nombre: '',
              apellidop: '',
              apellidom: '',
              lugarnacimiento: '',
              nacionalidad: '',
              domicilio: '',
              telefono: '',
              telefonoemergencia: '',
              serviciomedico: '',
              idtiposanguineo: '',
              alergiaopadecimiento: '',
              peso: '',
              estatura: '',
              fechanacimiento: '',
              foto: '',
              sexo: '',
            correo:'',
            password:'',
            smserror:''};
            v.formValidate = false;
            v.addModal= false;
            v.editPasswordModal=false;
            v.editModal=false;
            //v.passwordModal=false;
            //v.deleteModal=false;
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
