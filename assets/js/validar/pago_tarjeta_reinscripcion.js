$(document).ready(function () {
    var this_js_script = $('script[src*=pago_tarjeta_reinscripcion]');
    var my_var_1 = this_js_script.attr('data-my_var_1');
    if (typeof my_var_1 === "undefined") {
        var my_var_1 = 'some_default_value';
    }

    $("#payment-formir").validate({
        rules: {
            nombretitular: "required", 
            mes: "required",
            year: "required",
            calletitular: "required", 
            estado: "required",
            municipio: "required",
            colonia: "required",
            numerocasa:"required",
            numerotarjeta: {
                required: true,
                digits: true,
                number: true
            },
            codigo: {
                required: true,
                digits: true,
                rangelength: [3, 4]
            },
            cp: {
                required: true,
                digits: true,
                rangelength: [5, 5]
            }


        },
        messages: {
            nombretitular: "Campo requerido.", 
            mes: "Campo requerido.",
            year: "Campo requerido.",
            calletitular: "Campo requerido.", 
            estado: "Campo requerido.",
            municipio: "Campo requerido.",
            colonia: "Campo requerido.",
            numerocasa:"Campo requerido",
            numerotarjeta: {
                required: "Campo requerido.",
                digits: "Solo número.",
                number: "Solo número."
            },
            codigo: {
                required: "Campo requerido.",
                digits: "Solo número.",
                rangelength: "Entre 3 dígitos."
            },
            cp: {
                required: "Campo requerido.",
                digits: "Solo número.",
                rangelength: "5 dígitos."
            }
        }

    });



    OpenPay.setId('mds4bdhgvbese0knzu2x');
    OpenPay.setApiKey('pk_10828e6bd4144cc58ae2216bf4408f1f');
    OpenPay.setSandboxMode(true);
    //Se genera el id de dispositivo
    var deviceSessionId = OpenPay.deviceData.setup("payment-formir", "deviceIdHiddenFieldName");

    $('#pay-buttonir').on('click', function (event) {
        if ($("#payment-formir").valid()) {
            event.preventDefault();
            $("#pay-buttonir").prop("disabled", true);
            OpenPay.token.extractFormAndCreate('payment-formir', sucess_callbak, error_callbak);

        } else {
            return false;
        }


    });

    var sucess_callbak = function (response) {
        var token_id = response.data.id;
        $('#token_id').val(token_id);
        Enviar(); 

    };
    function Enviar() {
        $("#loadMe").modal({
            backdrop: "static", //remove ability to close modal with click
            keyboard: false, //remove option to close with keyboard
            show: true //Display loader!
        });
        $.ajax({
            type: "POST",
            url: my_var_1 + "Tutores/pagotarjeta",
            data: $('#payment-formir').serialize(),
            dataType: 'json',
            success: function (data) {
                $("#loadMe").modal("hide");
                var val = JSON.parse(JSON.stringify(data));
                if (val.tipo_error == 1) {
                    Swal.fire({
                        type: 'info',
                        title: 'Notificación',
                        text: val.msg
                    });
                    //Habilita el boton de pagar
                    $("#pay-buttonir").prop("disabled", false);
                } else {
                    //Deshabilitamos el boton de pagar
                   // swal("Exito!", val.msg, "success");
                    window.location.href =  my_var_1 +"Tutores/exito/"+val.alumno+'/'+val.idestadocuenta+'/'+val.tipo_pago;
                    $("#pay-buttonir").prop("disabled", true);

                    $('#nombretitular').val('');
                    $('#numerotarjeta').val('');
                    $("option:selected").prop("selected", false)
                    $('#codigo').val('');
                    $('#cp').val('');
                    $('#calle').val('');
                    $('#numerocasa').val(''); 
                    $('#colonia').empty().append('<option value="">--SELECCIONAR--</option>');
                    $('#municipio').empty().append('<option value="">--SELECCIONAR--</option>');
                    $('#estado').empty().append('<option value="">--SELECCIONAR--</option>');
                }
            }
        });
    }

    var error_callbak = function (response) {
        var desc = response.data.description != undefined ? response.data.description : response.message;
        
        $('#msmerror').val(desc);
        Swal.fire({
            type: 'info',
            title: 'Notificación',
            text: desc
        });
        //alert("ERROR [" + response.status + "] " + desc);
        $("#pay-buttonir").prop("disabled", false);
    };

});