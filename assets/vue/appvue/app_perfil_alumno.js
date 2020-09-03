
var this_js_script = $('script[src*=app_perfil_alumno]');
var my_var_1 = this_js_script.attr('data-my_var_1');
if (typeof my_var_1 === "undefined") {
    var my_var_1 = 'some_default_value';
}


Vue.config.devtools = true;
var v = new Vue({
    el: '#app',
    data: {
        url: my_var_1,
        addModal: false,
        editModal: false,
           url_image: my_var_1 + '/assets/alumnos/',
        editPasswordModal: false,
        cargando: false,
        error: false,
        alumno: [],
        search: {text: ''},
        emptyResult: false,
        chooseAlumno: {},
        formValidate: [],
        file: '',
        cambiarPassword: {

            passwordanterior: '',
            passwordnueva: '',
            passwordrepita: '',
            smserror: ''
        },
        successMSG: '',
    },
    created() {
        this.detalleTutor();
    },
    methods: {
        detalleTutor() {
            axios.get(this.url + "Perfil/showDatosAlumno/")
                    .then(response => (this.alumno = response.data.alumno));

        },
        updatePasswordAlumno() {
            v.error = false;
            v.cargando = true;
            var formData = v.formData(v.cambiarPassword);
            axios.post(this.url + "Perfil/updatePasswordAlumno", formData).then(function (response) {
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
                        title: 'Modificado!',
                        showConfirmButton: false,
                        timer: 1500
                    });


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

        clearMSG() {
            setTimeout(function () {
                v.successMSG = ''
            }, 3000); // disappearing message success in 2 sec
        },
        clearAll() {
            v.detalleTutor();

            v.cambiarPassword = {
                passwordanterior: '',
                passwordnueva: '',
                passwordrepita: '',
                smserror: ''
            },
                    v.formValidate = false;
            v.error = false;
            v.cargando = false;
            v.file = '';


        }

    }
})
