
var this_js_script = $('script[src*=appdetalle_alumno]');
var my_var_1 = this_js_script.attr('data-my_var_1');
if (typeof my_var_1 === "undefined") {
    var my_var_1 = 'some_default_value';
}
var my_var_2 = this_js_script.attr('data-my_var_2');
if (typeof my_var_2 === "undefined") {
    var my_var_2 = 'some_default_value';
}
 

Vue.config.devtools = true; 
var vede = new Vue({
    el: '#appdetalle',
    data: {
        url: my_var_1,
        idalumno: my_var_2,  
        cargando: false,
        error: false, 
        url_image: my_var_1 + '/assets/alumnos/',
        file: '',
        alumno: [],
        search: { text: '' },
        emptyResult: false,
        grupos:[],
        ciclos_escolares:[],
        beca_actual: [],
        estatus_alumno: [],
        grupo_actual:[],
        calificacion:[],
        becas:[],
        estatus:[],
		especialidades:[],
        asignarGrupo: {
            idalumno: my_var_2,
            idcicloescolar:'',
            idgrupo: '',
            msgerror: ''
        },
        asignarBeca:{
            idalumno: my_var_2,
            idbeca: '', 
            msgerror: ''
        },
        asignarEstatus:{
            idalumno: my_var_2,
            idestatus: '',
            msgerror: ''
        },
		asignarEspecialidad:{
            idalumno: my_var_2,
            idespecialidad: '',
            msgerror: ''
        },
        
        chooseRegistro: {}, 
        formValidate: [], 
        successMSG: '',
    },
    created() {
        this.detalleAlumno(); 
        this.grupoActual();
        this.showAllGrupo();
        this.showAllCiclosEscolares();
        this.becaActual();
        this.estatusAlumno();
        this.showAllBecas();
        this.showAllEstatus();
        this.calificacionAlumno();
        this.especialidadAlumno();
    },
    methods: {
        abrirAddModalAsignarGrupo() {
            $('#addAsignarGrupo').modal('show');
        },
        abrirAddModalAsignarBeca() {
            $('#addBeca').modal('show');
        },
        abrirAddModalFoto() {
            $('#subirFoto').modal('show');
        },
        abrirEditModalCambiarBeca() {
            $('#editBeca').modal('show');
        },
        abrirEditModalGrupo() {
            $('#editGrupo').modal('show');
        },
        abrirSubirFoto() {
            $('#uploadFoto').modal('show');
        },
        abrirEditModalCambiarEstatus() {
            $('#editEstatus').modal('show');
        },
 	 abrirEditModalEspecialidad() {
            $('#editEspecialidad').modal('show');
        },
        selectRegistro(row) {
            vede.chooseRegistro = row;

        },
        detalleAlumno() {
            axios.get(this.url + "Alumno/detalleAlumno/", {
                params: {
                    idalumno: this.idalumno
                }
            }).then(response => (this.alumno = response.data.alumno));

        },
         calificacionAlumno() {
            axios.get(this.url + "Alumno/calificacionGlobal/", {
                params: {
                    idalumno: this.idalumno
                }
            }).then(response => (this.calificacion = response.data.datos));

        },
        grupoActual() {
            axios.get(this.url + "Alumno/grupoActual/", {
                params: {
                    idalumno: this.idalumno
                }
            }).then(response => (this.grupo_actual = response.data.grupoactual));

        },
        becaActual() {
            axios.get(this.url + "Alumno/becaActual/", {
                params: {
                    idalumno: this.idalumno
                }
            }).then(response => (this.beca_actual = response.data.becaactual));

        },
  	especialidadAlumno() {
            axios.get(this.url + "Alumno/especialidadAlumno/", {
                params: {
                    idalumno: this.idalumno
                }
            }).then(response => (this.especialidades = response.data.especialidades));

        },
        estatusAlumno() {
            axios.get(this.url + "Alumno/estatusAlumno/", {
                params: {
                    idalumno: this.idalumno
                }
            }).then(response => (this.estatus_alumno = response.data.estatusalumno));

        },
        showAllGrupo() {
            axios.get(this.url + "Alumno/showAllGrupos/").then(response => (this.grupos = response.data.grupos));

        }, 
        showAllBecas() {
            axios.get(this.url + "Alumno/showAllBecas/").then(response => (this.becas = response.data.becas));

        },
        showAllEstatus(){
            axios.get(this.url + "Alumno/showAllEstatusAlumno/").then(response => (this.estatus = response.data.estatusalumno));
        }, 
        showAllCiclosEscolares() {
            axios.get(this.url + "Alumno/showAllCiclosEscolar/").then(response => (this.ciclos_escolares = response.data.cicloescolar));

        },
        formData(obj) {
            var formData = new FormData();
            for (var key in obj) {
                formData.append(key, obj[key]);
            }
            return formData;
        },
        subirFoto() {
            vede.error = false;
            vede.cargando = true;
            var formData = v.formData();
            formData.append('file', this.file);
            formData.append('idalumno',this.idalumno);
            axios.post(this.url + "Alumno/subirFoto", formData, {
                headers: {
                    'Content-Type': 'multipart/form-dara'
                }
            }).then(function (response) {
                if (response.data.error) {
                    vede.formValidate = response.data.msg;
                    vede.error = true;
                    vede.cargando = false;
                } else {
                    //v.successMSG = response.data.success;
                    vede.clearAll();
                    vede.clearMSG();
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
        addGrupo() {
            vede.error = false;
            vede.cargando = true;
            var formData = v.formData(vede.asignarGrupo);  
            // for (var value of formData.values()) {
            //                  console.log(value); 
            //               }
            axios.post(this.url + "Alumno/asignarGrupo", formData).then(function (response) {
                if (response.data.error) {
                    vede.formValidate = response.data.msg;
                    vede.error = true;
                    vede.cargando = false;
                } else {
                    swal({
                        position: 'center',
                        type: 'success',
                        title: 'Exito!',
                        showConfirmButton: false,
                        timer: 2000
                    });

                    vede.clearAll();
                   
                }
            })
        }, 
        addBeca() {
            vede.error = false;
            vede.cargando = true;
            var formData = v.formData(vede.asignarBeca);
            formData.append('idalumnogrupo', vede.beca_actual.idalumnogrupo); 
            // for (var value of formData.values()) {
            //                  console.log(value); 
            //               }
            axios.post(this.url + "Alumno/asignarBeca", formData).then(function (response) {
                if (response.data.error) {
                    vede.formValidate = response.data.msg;
                    vede.error = true;
                    vede.cargando = false;
                } else {
                    swal({
                        position: 'center',
                        type: 'success',
                        title: 'Exito!',
                        showConfirmButton: false,
                        timer: 2000
                    });

                    vede.clearAll();

                }
            })
        },
		addEspecialidad(){
			vede.error = false;
            vede.cargando = true;
            var formData = v.formData(vede.asignarEspecialidad);
            //formData.append('idalumno', vede.estatus_alumno.idalumno);

            axios.post(this.url + "Alumno/asignarEspecialidad", formData).then(function (response) {
                if (response.data.error) {
                    vede.formValidate = response.data.msg;
                    vede.error = true;
                    vede.cargando = false;
                } else {
                    swal({
                        position: 'center',
                        type: 'success',
                        title: 'Exito!',
                        showConfirmButton: false,
                        timer: 2000
                    });

                    vede.clearAll();

                }
            })
		},
        addEstatus() {
            vede.error = false;
            vede.cargando = true;
            var formData = v.formData(vede.asignarEstatus);
            formData.append('idalumno', vede.estatus_alumno.idalumno);

            axios.post(this.url + "Alumno/asignarEstatusAlumno", formData).then(function (response) {
                if (response.data.error) {
                    vede.formValidate = response.data.msg;
                    vede.error = true;
                    vede.cargando = false;
                } else {
                    swal({
                        position: 'center',
                        type: 'success',
                        title: 'Exito!',
                        showConfirmButton: false,
                        timer: 2000
                    });

                    vede.clearAll();

                }
            })
        }, 
        updateGrupo() {
            vede.error = false;
            vede.cargando = true;
            var formData = v.formData(vede.asignarGrupo);
            formData.append('idalumnogrupo', vede.grupo_actual.idalumnogrupo); 
            axios.post(this.url + "Alumno/cambiarGrupo", formData).then(function (response) {
                if (response.data.error) {
                    vede.formValidate = response.data.msg;
                    vede.error = true;
                    vede.cargando = false;
                } else {
                    swal({
                        position: 'center',
                        type: 'success',
                        title: 'Exito!',
                        showConfirmButton: false,
                        timer: 2000
                    });

                    vede.clearAll();

                }
            })
        },
        clearAll() {
            $('#addAsignarGrupo').modal('hide');
            $('#editGrupo').modal('hide');
            $('#uploadFoto').modal('hide'); 
            $('#addBeca').modal('hide');
            $('#editBeca').modal('hide');
            $('#subirFoto').modal('hide');
            $('#editEstatus').modal('hide');
			$('#editEspecialidad').modal('hide');
            vede.detalleAlumno();
            vede.grupoActual();
            vede.becaActual();
            vede.estatusAlumno();
            vede.formValidate = false; 
            vede.error = false;
            vede.cargando = false; 
 			vede.especialidadAlumno(); 
            vede.asignarGrupo ={
                idalumno: vede.idalumno,
                idcicloescolar: '',
                idgrupo: '',
                msgerror: ''
            } 
        }
    }
});
