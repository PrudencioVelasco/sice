
var this_js_script = $('script[src*=apphorariodetalle]');
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
   el:'#appd',
    data:{
        url: my_var_1,
        idhorario:my_var_2,
        addModal: false,
        addModalRecreo: false,
        addModalHoraSinClase: false,
        editModalHoraSinClase: false,
        editModal:false,
        editModalRecreo: false,
        editModalSinClases: false,
        //deleteModal:false,
        horarios:[], 
        dias:[], 
        lunes:[],
        martes:[],
        miercoles:[],
        jueves:[],
        viernes:[], 
        materias:[], 
        search: {text: ''},
        emptyResult:false,
        newHorario:{
            idhorario:my_var_2,
            iddia:'',
            titulo:'',
            idmateria:'',
            idprofesormateria:'',
            horainicial :'',
            horafinal :'',
            smserror:''},
        chooseHorario:{},
        formValidate:[],
        successMSG:''
    },
     created(){
      this.showAll(); 
      this.showAllLunes(); 
      this.showAllMartes(); 
      this.showAllMiercoles(); 
      this.showAllJueves(); 
      this.showAllViernes();
      this.showAllDias();  
      this.showAllMaterias();   
    },
    methods:{
         
         showAll(){ axios.get(this.url+"Horario/showAll/").then(function(response){
                 if(response.data.horarios == null){
                     v.noResult()
                    }else{
                        response.data.horarios;
                    }
            })
        }, 
       showAllLunes() {

            axios.get(this.url+"Horario/showAllDiaHorario/"+this.idhorario+"/1")
                    .then(response => (this.lunes = response.data.horarios));

        },
        showAllDias() {

            axios.get(this.url+"Horario/showAllDias/")
                    .then(response => (this.dias = response.data.dias));

        },
        showAllMartes() {

            axios.get(this.url+"Horario/showAllDiaHorario/"+this.idhorario+"/2")
                    .then(response => (this.martes = response.data.horarios));

        },
        showAllMiercoles() {

            axios.get(this.url+"Horario/showAllDiaHorario/"+this.idhorario+"/3")
                    .then(response => (this.miercoles = response.data.horarios));

        },
        showAllJueves() {

            axios.get(this.url+"Horario/showAllDiaHorario/"+this.idhorario+"/4")
                    .then(response => (this.jueves = response.data.horarios));

        },
        showAllViernes() {

            axios.get(this.url+"Horario/showAllDiaHorario/"+this.idhorario+"/5")
                    .then(response => (this.viernes = response.data.horarios));

        }, 
        showAllMaterias() {

            axios.get(this.url+"Horario/showAllMaterias/")
                    .then(response => (this.materias = response.data.materias));

        }, 
          addHorario(){
            var formData = v.formData(v.newHorario);
              axios.post(this.url+"Horario/addMateriaHorario", formData).then(function(response){
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
                     v.cargar();
                }
               })
        },
        addReceso(){
            var formData = v.formData(v.newHorario);
              axios.post(this.url+"Horario/addReceso", formData).then(function(response){
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
                     v.cargar();
                }
               })
        },
        addHoraSinClases(){
            var formData = v.formData(v.newHorario);
              axios.post(this.url+"Horario/addHoraSinClases", formData).then(function(response){
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
                     v.cargar();
                }
               })
        },
        updateHorario(){
            var formData = v.formData(v.chooseHorario); 
            axios.post(this.url+"Horario/updateMateriaHorario", formData).then(function(response){
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
                     v.cargar();

                }
            })
        },
        updateReceso(){
            var formData = v.formData(v.chooseHorario); 
            axios.post(this.url+"Horario/updateReceso", formData).then(function(response){
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
                     v.cargar();

                }
            })
        },
        updateHoraSinClases(){
            var formData = v.formData(v.chooseHorario); 
            axios.post(this.url+"Horario/updateHoraSinClases", formData).then(function(response){
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
                     v.cargar();

                }
            })
        },
      cargar(){
          //this.showAll(); 
          this.showAllLunes(); 
          this.showAllMartes(); 
          this.showAllMiercoles(); 
          this.showAllJueves(); 
          this.showAllViernes();
          //this.showAllDias();  
          //this.showAllMaterias();  
         },
       deleteHorario(id){
                   Swal.fire({
          title: '¿Eliminar Elemente?',
          text: "Realmente desea eliminar el Elemente.",
          type: 'info',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Eliminar',
          cancelButtonText: 'Cancelar'
        }).then((result) => {
          if (result.value) {

              axios.get(this.url + "Horario/deleteHorarioMateria", {
                params: {
                    id: id
                }
            }).then(function (response) {
                if (response.data.horarios == true) {
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
                     v.cargar();
                } else {
                   swal("Error", "No se puede eliminar el Elemente", "error")
                }
                console.log(response);
            }).catch((error) => {
                swal("Error", "No se puede eliminar el Elemente", "error")
            })
            }
            }) 
        },
   deleteSinClases(id) {
             Swal.fire({
          title: '¿Eliminar Elemente?',
          text: "Realmente desea eliminar el Elemente.",
          type: 'info',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Eliminar',
          cancelButtonText: 'Cancelar'
        }).then((result) => {
          if (result.value) {

              axios.get(this.url + "Horario/deleteSinClases", {
                params: {
                    id: id
                }
            }).then(function (response) {
                if (response.data.horarios == true) {
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
                     v.cargar();
                } else {
                   swal("Error", "No se puede eliminar el Elemente", "error")
                }
                console.log(response);
            }).catch((error) => {
                swal("Error", "No se puede eliminar el Elemente", "error")
            })
            }
            })
        },
         deleteReceso(id){
        Swal.fire({
          title: '¿Eliminar Elemente?',
          text: "Realmente desea eliminar el Elemente.",
          type: 'info',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Eliminar',
          cancelButtonText: 'Cancelar'
        }).then((result) => {
          if (result.value) {

              axios.get(this.url + "Horario/deleteReceso", {
                params: {
                    id: id
                }
            }).then(function (response) {
                if (response.data.horarios == true) {
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
                     v.cargar();
                } else {
                   swal("Error", "No se puede eliminar el Elemente", "error")
                }
                console.log(response);
            }).catch((error) => {
                swal("Error", "No se puede eliminar el Elemente", "error")
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

        selectHorario(horario){
            v.chooseHorario = horario;
            console.log(v.chooseHorario);
        },
        clearMSG(){
            setTimeout(function(){
			 v.successMSG=''
			 },3000); // disappearing message success in 2 sec
        },
        clearAll(){
            v.newHorario = {
                idhorario:my_var_2,
                iddia:'',
                titulo:'',
                idmateria:'',
                horainicial :'',
                horafinal :'',
                smserror:''};
            v.formValidate = false;
            v.addModal= false;
            v.editModal=false;
            v.passwordModal=false;
            v.deleteModal=false;
            v.addModalRecreo = false;
            v.editModalRecreo = false;
            v.addModalHoraSinClase = false;
            v.editModalHoraSinClase = false;
            v.editModalSinClases =false;
           // v.refresh()

        }
    }
})
