
var this_js_script = $('script[src*=appasignacion_materia]');
var my_var_1 = this_js_script.attr('data-my_var_1');
if (typeof my_var_1 === "undefined") {
    var my_var_1 = 'some_default_value';
}


Vue.config.devtools = true;
var v = new Vue({
    el: '#app',
    data: {
        url: my_var_1,
        cargando: false,
        error: false,
        materiasasignadas: [],
        materiaspenditesaasignar: [],
        materiasdisponibles:[],
        search: {text: ''},
        emptyResult: false,
        nuevaAsignacion: {
            idreprobada: '',
            idhorariodetalle: '',
            smserror: ''},
        chooseRegistro: {},
        formValidate: [],

        successMSG: ''

    },
    created() {
        this.showAll();
        this.showAllPendientes();
    },
    methods: {
        showAll() { 
              axios.get(this.url + "Alumno/showAllMateriasAsignadas")
                    .then(response => (this.materiasasignadas = response.data.materiasasignadas));
        },
        showAllPendientes() {


            axios.get(this.url + "Alumno/showAllMateriasPendientesAAsignar")
                    .then(response => (this.materiaspenditesaasignar = response.data.materiaspendientesaasignar));

        }, 
        addAsignacion() {
            v.error = false;
            v.cargando = true;
            var formData = v.formData(v.nuevaAsignacion);
            axios.post(this.url + "Alumno/asignarReprobado", formData).then(function (response) {
                if (response.data.error) {
                    v.formValidate = response.data.msg;
                    v.cargando = false;
                    v.error = true;
                } else {
                    v.clearAll();
                    v.clearMSG();
                    swal({
                        position: 'center',
                        type: 'success',
                        title: 'Exito!',
                        showConfirmButton: false,
                        timer: 1500
                    });


                }
            })
        },
        onChange(event) {
            var idmateria = event.target.value;
            this.materiasdisponibles="";
             axios.get(this.url + "Alumno/showAllMateriaParaAsignar/", {
                params: {
                    idmateria: idmateria
                }
            }).then(response => (this.materiasdisponibles = response.data.materiasdisponibles));
        },
        deleteAlumno(id) {
            console.log(id);
            v.error = false;
            v.cargando = true;
            Swal.fire({
                title: '¿Eliminar Registro?',
                text: "Realmente desea eliminar el Registro.",
                type: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.value) {

                    axios.get(this.url + "Alumno/deleteReprobada", {
                        params: {
                            id: id
                        }
                    }).then(function (response) {
                       if (response.data.error == false) { 
                            v.clearAll();
                            v.clearMSG();
                            swal({
                                position: 'center',
                                type: 'success',
                                title: 'Eliminado!',
                                showConfirmButton: false,
                                timer: 1500
                            });

                        } else {
                            swal("Información", response.data.msg.msgerror, "info")
                            v.cargando = false;
                        }
                    }).catch((error) => {
                        swal("Información", "No se puede Eliminar.", "info")
                        v.cargando = false;
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

        selectAlumno(row) {
            v.chooseRegistro = row; 
        },
        clearMSG() {
            setTimeout(function () {
                v.successMSG = ''
            }, 3000); // disappearing message success in 2 sec
        },
        clearAll() {
            v.showAll();
            v.showAllPendientes();
            v.materiasdisponibles="";
            v.newAsignacion = {
                idreprobada: '',
                idhorariodetalle: '',
                smserror: ''};
            v.formValidate = false;
            v.addModal = false;
            v.editPasswordModal = false;
            v.editModal = false;
            v.error = false;
            v.cargando = false;

        }
    }
})
