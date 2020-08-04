$(document).ready(function () {
    var this_js_script = $('script[src*=pago_efectivo_reinscripcion]');
    var my_var_1 = this_js_script.attr('data-my_var_1');
    if (typeof my_var_1 === "undefined") {
        var my_var_1 = 'some_default_value';
    }

    $('#pdfdescargarir').hide();

    $("#btngenerarpdfir").click(function () {
        var concepto = $(".concepto_pago_efectivo").find("option:selected").val();
       
        if (concepto != "") {
            $('#btngenerarpdfir').prop("disabled", true);
            $('#btngenerarpdfir').html(
                    `<span class="fa fa-spinner spinner-border-sm" role="status" aria-hidden="true"></span> PROCESANDO...`
                    );
            $("#loadMe").modal({
                backdrop: "static", //remove ability to close modal with click
                keyboard: false, //remove option to close with keyboard
                show: true //Display loader!
            });
            $.ajax({
                type: "POST",
                url: my_var_1 + "Tutores/pagotienda",
                data: $('#frmtiendair').serialize(),
                success: function (data) {
                    $('#btngenerarpdfir').prop("disabled", false);
                    $('#btngenerarpdfir').html(
                            ` GENERAR DOCUMENTO`
                            );
                    $("#loadMe").modal("hide");
                    var val = JSON.parse(data);
                    if (val.tipo_error == 1) {
                        Swal.fire({
                            type: 'info',
                            title: 'Notificación',
                            text: val.msg
                        });
                        //Habilita el boton de pagar
                        //$("#pay-button2").prop("disabled", false);
                    } else {
                        //Deshabilitamos el boton de pagar
                        swal("Exito!", val.msg, "success");
                        $('#pdfdescargarir').show();
                        $("#urlpdfir").attr("href", "https://sandbox-dashboard.openpay.mx/paynet-pdf/mds4bdhgvbese0knzu2x/" + val.referencia);
                        $('#btngenerarpdfir').prop("disabled", true);
                    }
                }
            });
        } else {
            Swal.fire({
                type: 'info',
                title: 'Notificación',
                text: "SELECCIONAR EL CONCEPTO A PAGAR."
            });
        }
    });

});