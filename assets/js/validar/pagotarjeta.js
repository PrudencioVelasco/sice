$(document).ready(function () {

    $("#payment-form").validate({
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
    var deviceSessionId = OpenPay.deviceData.setup("payment-form", "deviceIdHiddenFieldName");

    $('#pay-button').on('click', function (event) {
        if ($("#payment-form").valid()) {
            event.preventDefault();
            $("#pay-button").prop("disabled", true);
            OpenPay.token.extractFormAndCreate('payment-form', sucess_callbak, error_callbak);

        } else {
            return false;
        }


    });

    var sucess_callbak = function (response) {
        var token_id = response.data.id;
        $('#token_id').val(token_id);
        $('#payment-form').submit();

    };

    var error_callbak = function (response) {
        var desc = response.data.description != undefined ? response.data.description : response.message;
        console.log(desc);
        $('#msmerror').val(desc);
        Swal.fire({
            type: 'error',
            title: 'Oops...',
            text: desc
        });
        //alert("ERROR [" + response.status + "] " + desc);
        $("#pay-button").prop("disabled", false);
    };

});