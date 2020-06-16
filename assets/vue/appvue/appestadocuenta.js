
var this_js_script = $('script[src*=appestadocuenta]');
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
var ve = new Vue({
   el:'#appestadocuenta',
    data:{
        url: my_var_1,
        idalumno: my_var_2, 
        addModal: false,
        addPagoModal: false,
        editModal:false,
        eliminarModalP: false,
        eliminarModalC: false,
        mostrar:false,
        mostrar_error:false,
        noresultado:false,
        noresultadoinicio:false,
        addPagoColegiaturaModal:false,
        btnpagar:false,
        //deleteModal:false, 
        ciclos:[],
        pagos:[],
        formaspago:[],
        solicitudes:[], 
        tipospago: [],
        meses: [], 
        search: {text: ''},
        emptyResult:false,
        total_que_debe_pagar_inscripcion:0.00,
        total_que_debe_pagar_reinscripcion: 0.00,
        total_que_debe_pagar_colegiatura: 0.00,
        newBuscarCiclo:{
            idalumno:my_var_2,
            idperiodo:'',
            msgerror:''},
        newCobroInicio:{
            idalumno:my_var_2, 
            descuento:'',
            autorizacion:'',
            idtipopagocol: '',
            idformapago:'', 
        },
        newCobroColegiatura: {
            idalumno: my_var_2,
            descuento: '',
            idmes:'',
            autorizacion: '',
            idformapago: '',
        },
        eliminarPrimerCobro: {
            usuario: '',
            password: '',
        },
        eliminarColegiatura: {
            usuario: '',
            password: '',
        },
        newCobro:{ 
            idformapago:'', 
            autorizacion:'',
            idperiodo:'',
            
            idalumno:my_var_2,
            idamortizacion:'', 
            msgerror:''},
        chooseSolicitud:{},
        choosePrimerPago: {},
        choosePeriodo:{},
        formValidate:[],
        idperiodobuscado:'',
        successMSG:'', 
    },
     created(){ 
      this.showAllTutoresDisponibles();
      this.showAllFormasPago(); 
      this.showAllTiposPago();
      //this.showAllMeses();

    },
    methods:{
      searchSolicitud() {  
            if (this.$refs.idperiodo.value != ""){
             this.mostrar = true; 
             ve.mostrar_error = false;
             ve.idperiodobuscado = this.$refs.idperiodo.value;
             axios.get(this.url+"EstadoCuenta/estadoCuenta/", {
                 params: {
                     idperiodo: this.$refs.idperiodo.value,
                     idalumno: my_var_2
                 }
             }).then(function(response){
                //console.log(response.data);
                 if(response.data == ''){
                      ve.solicitudes = null;
                      ve.noresultado = true;
                    }else{
                        ve.solicitudes = response.data
                         ve.noresultado = false;
                    }
            });

            axios.get(this.url+"EstadoCuenta/pagosInicio/", {
                 params: {
                     idperiodo: this.$refs.idperiodo.value,
                     idalumno: my_var_2
                 }
             }).then(function(response){ 
                 if(response.data.pagos == null ){
                      ve.pagos = null;
                      ve.noresultadoinicio = true;
                      ve.btnpagar = true;
                    }else{
                      console.log(response.data);
                        ve.pagos = response.data.pagos
                         ve.noresultadoinicio = false;
                         ve.btnpagar = false;
                    }
            });

                axios.get(this.url + "EstadoCuenta/showAllMeses/", {
                    params: {
                        idperiodo: this.$refs.idperiodo.value,
                        idalumno: my_var_2
                    }
                }).then(function (response) {
                    //console.log(response.data);
                    if (response.data.meses == null) {
                        
                    } else {
                        ve.meses = response.data.meses
                       
                    }
                });


                axios.get(this.url + "EstadoCuenta/descuentoPagoInicioInscripcion/", {
                    params: {
                        idperiodo: this.$refs.idperiodo.value,
                        idalumno: my_var_2
                    }
                }).then(function (response) {
                    if (response.data.pagoinscripcion == null) { 
                    } else { 
                        ve.total_que_debe_pagar_inscripcion = response.data.pagoinscripcion;
                    }
                });
                axios.get(this.url + "EstadoCuenta/descuentoPagoInicioReinscripcion/", {
                    params: {
                        idperiodo: this.$refs.idperiodo.value,
                        idalumno: my_var_2
                    }
                }).then(function (response) {
                    if (response.data.pagoreinscripcion == null) {
                    } else {
                        ve.total_que_debe_pagar_reinscripcion = response.data.pagoreinscripcion;
                    }
                });
                axios.get(this.url + "EstadoCuenta/descuentoPagoColegiatura/", {
                    params: {
                        idperiodo: this.$refs.idperiodo.value,
                        idalumno: my_var_2
                    }
                }).then(function (response) {
                    if (response.data.pagocolegiatura == null) {
                    } else {
                        ve.total_que_debe_pagar_colegiatura = response.data.pagocolegiatura;
                    }
                });

             //ve.idperiodobuscado = this.$refs.idperiodo.value;
          //then(response => (this.solicitudes = response.data))  
            }else{
                ve.mostrar_error = true;
        }

         },
         estadocuentaAll(idperiodo){ 
             console.log(idperiodo);
             axios.get(this.url+"EstadoCuenta/estadoCuenta/", {
                 params: {
                     idperiodo: ve.idperiodobuscado,
                     idalumno: my_var_2
                 }
             }).then(response => (this.solicitudes = response.data));

             axios.get(this.url + "EstadoCuenta/pagosInicio/", {
                 params: {
                     idperiodo: ve.idperiodobuscado,
                     idalumno: my_var_2
                 }
             }).then(function (response) {
                 if (response.data.pagos == null) {
                     ve.pagos = null;
                     ve.noresultadoinicio = true;
                     ve.btnpagar = true;
                 } else {
                     console.log(response.data);
                     ve.pagos = response.data.pagos
                     ve.noresultadoinicio = false;
                     ve.btnpagar = false;
                 }
             });
             axios.get(this.url + "EstadoCuenta/showAllMeses/", {
                 params: {
                     idperiodo: ve.idperiodobuscado,
                     idalumno: my_var_2
                 }
             }).then(function (response) { 
                 if (response.data.meses == null) {

                 } else {
                     ve.meses = response.data.meses

                 }
             });
         },
        showAllTutoresDisponibles() {

            axios.get(this.url+"EstadoCuenta/showAllCicloEscolar/")
                    .then(response => (this.ciclos = response.data.ciclos));

        },
        showAllFormasPago() {

            axios.get(this.url+"EstadoCuenta/showAllFormasPago/")
                    .then(response => (this.formaspago = response.data.formaspago));

        },
        showAllTiposPago() {

            axios.get(this.url + "EstadoCuenta/showAllTipoPago/")
                .then(response => (this.tipospago = response.data.tipospago));

        },
        showAllMeses() {

            axios.get(this.url + "EstadoCuenta/showAllMeses/")
                .then(response => (this.meses = response.data.meses));

        },
        selectPeriodo(solicitud) {
             ve.chooseSolicitud = solicitud; 

         },
        selectPrimerPago(row) {
            ve.choosePrimerPago = row;

        },
        formData(obj){
            var formData = new FormData();
              for ( var key in obj ) {
                  formData.append(key, obj[key]);
              }
              return formData;
        },
      addCobro(){
            var formData = v.formData(ve.newCobro);
                formData.append('abono', ve.chooseSolicitud.descuento);
                formData.append('idamortizacion', ve.chooseSolicitud.idamortizacion);
            // for (var value of formData.values()) {
            //                  console.log(value); 
            //               }
              axios.post(this.url+"EstadoCuenta/addCobro", formData).then(function(response){
                if(response.data.error){
                    ve.formValidate = response.data.msg;
                }else{
                    swal({
                      position: 'center',
                      type: 'success',
                      title: 'Exito!',
                      showConfirmButton: false,
                      timer: 1800
                    });

                    ve.clearAll(); 
                    ve.estadocuentaAll(ve.chooseSolicitud.idperiodo);
                }
               })
        },
        addCobroColegiatura(){
            var formData = v.formData(ve.newCobroColegiatura); 
            formData.append('idperiodo', ve.idperiodobuscado);
            formData.append('idalumno', ve.idalumno);
            // for (var value of formData.values()) {
            //                  console.log(value); 
            //               }
            axios.post(this.url + "EstadoCuenta/addCobroColegiatura", formData).then(function (response) {
                if (response.data.error) {
                    ve.formValidate = response.data.msg;
                } else {
                    swal({
                        position: 'center',
                        type: 'success',
                        title: 'Exito!',
                        showConfirmButton: false,
                        timer: 1800
                    });

                    ve.clearAll();
                    ve.estadocuentaAll(ve.chooseSolicitud.idperiodo);
                }
            })
        },
        eliminarPagoInicio(){
            var formData = v.formData(ve.eliminarPrimerCobro);
            formData.append('idpago', ve.choosePrimerPago.idpago);
            axios.post(this.url + "EstadoCuenta/eliminarPrimerCobro", formData).then(function (response) {
                if (response.data.error) {
                    ve.formValidate = response.data.msg;
                } else {
                    swal({
                        position: 'center',
                        type: 'success',
                        title: 'Exito!',
                        showConfirmButton: false,
                        timer: 1800
                    });

                    ve.clearAll();
                    ve.estadocuentaAll(ve.chooseSolicitud.idperiodo);
                }
            })
        },
        eliminarPagoColegiatura() {
            console.log(ve.idperiodobuscado);
            var formData = v.formData(ve.eliminarColegiatura);
            formData.append('idpago', ve.chooseSolicitud.idpago);
            axios.post(this.url + "EstadoCuenta/eliminarColegiatura", formData).then(function (response) {
                if (response.data.error) {
                    ve.formValidate = response.data.msg;
                } else {
                    swal({
                        position: 'center',
                        type: 'success',
                        title: 'Exito!',
                        showConfirmButton: false,
                        timer: 1800
                    });

                    ve.clearAll();
                    ve.estadocuentaAll(ve.idperiodobuscado);
                }
            })
        },
            addCobroInicio(){
            var formData = v.formData(ve.newCobroInicio); 
                formData.append('idperiodobuscado', ve.idperiodobuscado);
                formData.append('idalumno', ve.idalumno);
            // for (var value of formData.values()) {
            //                  console.log(value); 
            //               }
              axios.post(this.url+"EstadoCuenta/addCobroInicio", formData).then(function(response){
                if(response.data.error){
                    ve.formValidate = response.data.msg;
                }else{
                    swal({
                      position: 'center',
                      type: 'success',
                      title: 'Exito!',
                      showConfirmButton: false,
                      timer: 1800
                    });

                    ve.clearAll(); 
                    ve.estadocuentaAll(ve.chooseSolicitud.idperiodo);
                    
                }
               })
        },
        clearAll(){ 
            ve.formValidate = false;
            ve.addModal= false; 
            ve.addPagoModal = false;
            ve.eliminarModalP = false;
            ve.eliminarModalC = false;
            ve.addPagoColegiaturaModal = false;
            
             
                ve.eliminarPrimerCobro = { 
                    usuario: '',
                    password: '',
                    msgerror: ''
                },
                    ve.eliminarColegiatura = {
                        usuario: '',
                        password: '',
                        msgerror: ''
                    },
                ve.newCobroInicio = {
                //idalumno: ve.my_var_2,
                descuento: '',
                autorizacion: '',
                idtipopagocol: '',
                idformapago: '', 
        },
                ve.newCobroColegiatura = {
                //idalumno: ve.my_var_2,
                idmes:'',
                descuento: '',
                autorizacion: '',
                idformapago: '',
        },
                ve.newCobro = {
                idformapago: '',
                autorizacion: '',
                idperiodo: '', 
                //idalumno: ve.my_var_2,
                idamortizacion: '',
                msgerror: ''
            }
        }
    }
});
