$(document).ready(function () {
    var this_js_script = $('script[src*=concepto_de_pago]');
    var my_var_1 = this_js_script.attr('data-my_var_1');
    if (typeof my_var_1 === "undefined") {
        var my_var_1 = 'some_default_value';
    }
    var my_var_2 = this_js_script.attr('data-my_var_2');
    if (typeof my_var_2 === "undefined") {
        var my_var_2 = 'some_default_value';
    }
    var my_var_3 = this_js_script.attr('data-my_var_3');
    if (typeof my_var_3 === "undefined") {
        var my_var_3 = 'some_default_value';
    }


    $(".concepto_pago").change(function () {
        var concepto = $(".concepto_pago").find("option:selected").val();
        if (concepto != "") {
            $.ajax({
                type: "POST",
                url: my_var_1 + "Tutores/costoPagoInicio",
                data: "concepto=" + concepto + "&alumno=" + my_var_2 + "&periodo=" + my_var_3,
                dataType: "html",
                success: function (response) {
                    $('#tbldefault').hide();
                    $('#mensajetarjeta').val('');
                    $('#mensajeefectivo').val('');
                    $('#descuentoefectivo').val('');
                    $('#descuentotarjeta').val('');
                    var val = JSON.parse(response);
                    var tabla = "";
                    tabla += '<table class="table">';
                    tabla += '<tbody>';
                    tabla += '<tr>';
                    tabla += '<th style="width:50%">CONCEPTO:</th>';
                    tabla += '<td><label for="">' + val.resultado.concepto + '</label></td>';
                    tabla += ' </tr>';
                    tabla += '<tr>';
                    tabla += '<th style="width:50%">SUBTOTAL:</th>';
                    tabla += '<td>$' + (parseInt(val.resultado.costototal)).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,') + '</td>';
                    tabla += '</tr>';
                    tabla += '<tr>';
                    tabla += '<th>TOTAL:</th>';
                    tabla += '<td>$' + (parseInt(val.resultado.costototal)).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,') + '</td>';
                    tabla += '</tr>';
                    tabla += '</tbody>';
                    tabla += '</table>';
                    $('#descuentoefectivo').val(val.resultado.costototal);
                    $('#descuentotarjeta').val(val.resultado.costototal);
                    $('#mensajetarjeta').val(val.resultado.concepto);
                    $('#mensajeefectivo').val(val.resultado.concepto);
                    $('.resultado').html(tabla);
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
    $(".concepto_pago_efectivo").change(function () {
        var concepto = $(".concepto_pago_efectivo").find("option:selected").val();
        if (concepto != "") {
            $.ajax({
                type: "POST",
                url: my_var_1 + "Tutores/costoPagoInicio",
                data: "concepto=" + concepto + "&alumno=" + my_var_2 + "&periodo=" + my_var_3,
                dataType: "html",
                success: function (response) {
                    $('#tbldefault').hide();
                    $('#descuentoefectivo').val('');
                    $('#descuentotarjeta').val('');
                    $('#mensajetarjeta').val('');
                    $('#mensajeefectivo').val('');
                    var val = JSON.parse(response);
                    var tabla = "";
                    tabla += '<table class="table">';
                    tabla += '<tbody>';
                    tabla += '<tr>';
                    tabla += '<th style="width:50%">CONCEPTO:</th>';
                    tabla += '<td><label for="">' + val.resultado.concepto + '</label></td>';
                    tabla += ' </tr>';
                    tabla += '<tr>';
                    tabla += '<th style="width:50%">SUBTOTAL:</th>';
                    tabla += '<td>$' + (parseInt(val.resultado.costototal)).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,') + '</td>';
                    tabla += '</tr>';
                    tabla += '<tr>';
                    tabla += '<th>TOTAL:</th>';
                    tabla += '<td>$' + (parseInt(val.resultado.costototal)).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,') + '</td>';
                    tabla += '</tr>';
                    tabla += '</tbody>';
                    tabla += '</table>';
                    $('#descuentoefectivo').val(val.resultado.costototal);
                    $('#descuentotarjeta').val(val.resultado.costototal);
                    $('#mensajetarjeta').val(val.resultado.concepto);
                    $('#mensajeefectivo').val(val.resultado.concepto);
                    $('.resultado').html(tabla);
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