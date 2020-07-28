
var this_js_script = $('script[src*=apphorariodetalle]');
var my_var_1 = this_js_script.attr('data-my_var_1');
if (typeof my_var_1 === "undefined") {
    var my_var_1 = 'some_default_value';
}
var my_var_2 = this_js_script.attr('data-my_var_2');
if (typeof my_var_2 === "undefined") {
    var my_var_2 = 'some_default_value';
}
  
Vue.config.devtools = true;    
Vue.component('timepicker', window.VueTimepicker.default);
var v = new Vue({  
    el: '#appd',  
    data: {
        
        url: my_var_1,
        idhorario: my_var_2,
        addModal: false,
        addModalRecreo: false,
        addModalHoraSinClase: false,
        editModalHoraSinClase: false,
        editModal: false,
        editModalRecreo: false,
        editModalSinClases: false,
        cargando: false,
        error: false,
        //deleteModal:false,
        horarios: [],
        dias: [],
        lunes: [],
        martes: [],
        miercoles: [],
        jueves: [],
        viernes: [],
        materias: [],
        search: {text: ''},
        emptyResult: false,
        newHorario: {
            idhorario: my_var_2,
            iddia: '',
            titulo: '',
            idmateria: '',
            idprofesormateria: '',
            horainicial: '',
            horafinal: '',
            smserror: ''},
        chooseHorario: {},
        formValidate: [],
        successMSG: ''
    },
    created() {
        this.showAll();
        this.showAllLunes();
        this.showAllMartes();
        this.showAllMiercoles();
        this.showAllJueves();
        this.showAllViernes();
        this.showAllDias();
        this.showAllMaterias();
    },
    methods: {
        modelAgregarMateria() {
            $('#addMateria').modal('show');
        },
        modelEditMateria() {
            $('#editMateria').modal('show');
        },
        modelAgregarHoraSinClase() {
            $('#addModalHoraSinClase').modal('show');
        },
        modelEditHoraSinClase() {
            $('#editModalSinClases').modal('show');
        },
        modelAgregarRecreo() {
            $('#addModalRecreo').modal('show');
        },
        modelEditRecreo() {
            $('#editModalRecreo').modal('show');
        },
        showAll() {
            axios.get(this.url + "Horario/showAll/").then(function (response) {
                if (response.data.horarios == null) {
                    v.noResult()
                } else {
                    response.data.horarios;
                }
            })
        },
        showAllLunes() {

            axios.get(this.url + "Horario/showAllDiaHorario/" + this.idhorario + "/1")
                    .then(response => (this.lunes = response.data.horarios));

        },
        showAllDias() {

            axios.get(this.url + "Horario/showAllDias/")
                    .then(response => (this.dias = response.data.dias));

        },
        showAllMartes() {

            axios.get(this.url + "Horario/showAllDiaHorario/" + this.idhorario + "/2")
                    .then(response => (this.martes = response.data.horarios));

        },
        showAllMiercoles() {

            axios.get(this.url + "Horario/showAllDiaHorario/" + this.idhorario + "/3")
                    .then(response => (this.miercoles = response.data.horarios));

        },
        showAllJueves() {

            axios.get(this.url + "Horario/showAllDiaHorario/" + this.idhorario + "/4")
                    .then(response => (this.jueves = response.data.horarios));

        },
        showAllViernes() {

            axios.get(this.url + "Horario/showAllDiaHorario/" + this.idhorario + "/5")
                    .then(response => (this.viernes = response.data.horarios));

        },
        showAllMaterias() {

            axios.get(this.url + "Horario/showAllMaterias/")
                    .then(response => (this.materias = response.data.materias));

        },
        addHorario() {
            v.cargando = true;
            v.error = false;
            var formData = v.formData(v.newHorario);
            axios.post(this.url + "Horario/addMateriaHorario", formData).then(function (response) {
                if (response.data.error) {
                    v.formValidate = response.data.msg;
                    v.error = true;
                    v.cargando = false;
                } else {
                    swal({
                        position: 'center',
                        type: 'success',
                        title: 'Exito!',
                        showConfirmButton: false,
                        timer: 3000
                    });

                    v.clearAll();
                    v.clearMSG();
                    v.cargar();
                }
            })
        },
        addReceso() {
            v.cargando = true;
            v.error = false;
            var formData = v.formData(v.newHorario);
            axios.post(this.url + "Horario/addReceso", formData).then(function (response) {
                if (response.data.error) {
                    v.formValidate = response.data.msg;
                    v.cargando = false;
                    v.error = true;
                } else {
                    swal({
                        position: 'center',
                        type: 'success',
                        title: 'Exito!',
                        showConfirmButton: false,
                        timer: 3000
                    });

                    v.clearAll();
                    v.clearMSG();
                    v.cargar();
                }
            })
        },
        addHoraSinClases() {
            v.cargando = true;
            v.error = false;
            var formData = v.formData(v.newHorario);
            axios.post(this.url + "Horario/addHoraSinClases", formData).then(function (response) {
                if (response.data.error) {
                    v.formValidate = response.data.msg;
                    v.cargando = false;
                    v.error = true;
                } else {
                    swal({
                        position: 'center',
                        type: 'success',
                        title: 'Exito!',
                        showConfirmButton: false,
                        timer: 3000
                    });

                    v.clearAll();
                    v.clearMSG();
                    v.cargar();
                }
            })
        },
        updateHorario() {
            v.cargando = true;
            v.error = false;
            var formData = v.formData(v.chooseHorario);
            axios.post(this.url + "Horario/updateMateriaHorario", formData).then(function (response) {
                if (response.data.error) {
                    v.formValidate = response.data.msg;
                    v.cargando = false;
                    v.error = true;
                } else {
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
                    v.cargar();

                }
            })
        },
        updateReceso() {
            v.cargando = true;
            v.error = false;
            var formData = v.formData(v.chooseHorario);
            axios.post(this.url + "Horario/updateReceso", formData).then(function (response) {
                if (response.data.error) {
                    v.formValidate = response.data.msg;
                    v.cargando = false;
                    v.error = true;
                } else {
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
                    v.cargar();

                }
            })
        },
        updateHoraSinClases() {
            v.cargando = true;
            v.error = false;
            var formData = v.formData(v.chooseHorario);
            axios.post(this.url + "Horario/updateHoraSinClases", formData).then(function (response) {
                if (response.data.error) {
                    v.formValidate = response.data.msg;
                    v.cargando = false;
                    v.error = true;
                } else {
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
                    v.cargar();

                }
            })
        },
        cargar() {
            //this.showAll(); 
            this.showAllLunes();
            this.showAllMartes();
            this.showAllMiercoles();
            this.showAllJueves();
            this.showAllViernes();
            //this.showAllDias();  
            //this.showAllMaterias();  
        },
        deleteHorario(id) {
            Swal.fire({
                title: '¿Eliminar Elemente?',
                text: "Realmente desea eliminar el Elemente.",
                type: 'question',
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
                        if (response.data.error == false) {
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
                            swal("Información", response.data.msg.msgerror, "info")
                        }
                    }).catch((error) => {
                        swal("Información", "No se puede eliminar el Elemente", "info")
                    })
                }
            })
        },
        deleteSinClases(id) {
            Swal.fire({
                title: '¿Eliminar Elemente?',
                text: "Realmente desea eliminar el Elemente.",
                type: 'question',
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
                        if (response.data.error == false) {
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
                            swal("Información", response.data.msg.msgerror, "info")
                        }
                    }).catch((error) => {
                        swal("Información", "No se puede eliminar el Elemente", "info")
                    })
                }
            })
        },
        deleteReceso(id) {
            Swal.fire({
                title: '¿Eliminar Elemente?',
                text: "Realmente desea eliminar el Elemente.",
                type: 'question',
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
                        if (response.data.error == false) {
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
                            swal("Información", response.data.msg.msgerror, "info")
                        }
                    }).catch((error) => {
                        swal("Información", "No se puede eliminar el Elemente", "info")
                    })
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

        selectHorario(horario) {
            v.chooseHorario = horario;
            console.log(v.chooseHorario);
        },
        clearMSG() {
            setTimeout(function () {
                v.successMSG = ''
            }, 3000); // disappearing message success in 2 sec
        },
        clearAll() {
            $('#addMateria').modal('hide');
            $('#addModalHoraSinClase').modal('hide');
            $('#addModalRecreo').modal('hide');
            $('#editMateria').modal('hide');
            $('#editModalRecreo').modal('hide');
            $('#editModalSinClases').modal('hide');
            v.newHorario = {
                idhorario: my_var_2,
                iddia: '',
                titulo: '',
                idmateria: '',
                horainicial: '',
                horafinal: '',
                smserror: ''};
            v.formValidate = false;
            v.addModal = false;
            v.editModal = false;
            v.passwordModal = false;
            v.deleteModal = false;
            v.addModalRecreo = false;
            v.editModalRecreo = false;
            v.addModalHoraSinClase = false;
            v.editModalHoraSinClase = false;
            v.editModalSinClases = false;
            v.cargando = false;
            v.error = false;
            // v.refresh()

        }
    }
})
