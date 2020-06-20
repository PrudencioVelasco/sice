$(document).ready(function () {
    var this_js_script = $('script[src*=pago_efectivo_colegiatura]');
    var my_var_1 = this_js_script.attr('data-my_var_1');
    if (typeof my_var_1 === "undefined") {
        var my_var_1 = 'some_default_value';
    }

    $('#pdfpagoc').hide();

    $("#btngenerarpdfc").click(function () {

        var mespago = $('#mespago_efectivo').val();
        
        if(mespago != ""){
        $('#btngenerarpdfc').prop("disabled", true);
        $('#btngenerarpdfc').html(
            `<span class="fa fa-spinner spinner-border-sm" role="status" aria-hidden="true"></span> PROCESANDO...`
        );
        $("#loadMe").modal({
            backdrop: "static", //remove ability to close modal with click
            keyboard: false, //remove option to close with keyboard
            show: true //Display loader!
        });
        $.ajax({
            type: "POST",
            url: my_var_1 + "Tutores/pagotiendac",
            data: $('#frmefectivoc').serialize(),
            success: function (data) {
                $('#btngenerarpdfc').prop("disabled", false);
                $('#btngenerarpdfc').html(
                    ` GENERAR DOCUMENTO`
                ); 
                $("#loadMe").modal("hide");
                var val = JSON.parse(data); 
                if (val.tipo_error == 1) {
                    Swal.fire({
                        type: 'error',
                        title: 'Oops...',
                        text: val.msg
                    });
                    //Habilita el boton de pagar
                    //$("#pay-button2").prop("disabled", false);
                } else {
                    //Deshabilitamos el boton de pagar
                    swal("Exito!", val.msg, "success"); 
                    $('#pdfpagoc').show();
                    $("#idurlc").attr("href", "https://sandbox-dashboard.openpay.mx/paynet-pdf/mds4bdhgvbese0knzu2x/"+val.referencia);
                    $('#btngenerarpdfc').prop("disabled", true);
                }
            }
        });
    }else{
            Swal.fire({
                type: 'error',
                title: 'Oops...',
                text:'Seleccione el Mes a Pagar.'
            });
    }
    });

});