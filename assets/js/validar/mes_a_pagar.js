$(document).ready(function () {
    var this_js_script = $('script[src*=mes_a_pagar]');
    var my_var_1 = this_js_script.attr('data-my_var_1');
    if (typeof my_var_1 === "undefined") {
        var my_var_1 = 'some_default_value';

    }
//Alumno
    var my_var_2 = this_js_script.attr('data-my_var_2');
    if (typeof my_var_2 === "undefined") {
        var my_var_2 = 'some_default_value';

    }
//Periodo
    var my_var_3 = this_js_script.attr('data-my_var_3');
    if (typeof my_var_3 === "undefined") {
        var my_var_3 = 'some_default_value';

    }
    $(".mespago_tc").change(function () {
        var idmes = $(".mespago_tc").find("option:selected").val(); 
        $.ajax({
            type: "POST",
            url:  my_var_1 +"Tutores/agregarCostoColegiatura",
            data: "mes=" + idmes + "&alumno=" + my_var_2 + "&periodo=" + my_var_3,
            dataType: "html",
            success: function (response) {
                $('#tbldefault').hide();
                $('#descuentorealco').val('');
                $('#recargoco').val('');
                $('#descuentorealco_efe').val('');
                $('#recargoco_efe').val('');
                var val = JSON.parse(response);

                var tabla = '<div class="table-responsive">';
                tabla += '<table class="table">';
                tabla += '<tbody>';
                tabla += '<tr>';
                tabla += '<th style="width:50%">CONCEPTO:</th>';
                tabla += '<td><label for="">PAGO DE COLEGIATURA</label></td>';
                tabla += '</tr>';
                tabla += '<tr>';
                tabla += '<td>COLEGIATURA:</td>';
                tabla += '<td>$' + (val.resultado.colegiatura).toFixed(2).replace(/\d(?=(\d{3})+\.)/g,'$&,') + '</td>';
                tabla += '</tr>';

                if (val.resultado.recargo > 0) {
                    tabla += '<tr>';
                    tabla += '<td>RECARGO</td>';
                    tabla += ' <td>$' +  (val.resultado.recargo).toFixed(2).replace(/\d(?=(\d{3})+\.)/g,'$&,') + '</td>';
                    tabla += '</tr>';
                }

                tabla += '<tr>';
                tabla += '<th style="width:50%">SUBTOTAL:</th>';
                tabla += '<td><strong>$' +  (val.resultado.costototal).toFixed(2).replace(/\d(?=(\d{3})+\.)/g,'$&,') + '</strong></td>';
                tabla += '</tr>';

                tabla += '<tr>';
                tabla += '<th>TOTAL:</th>';
                tabla += '<td><strong>$' +  (val.resultado.costototal).toFixed(2).replace(/\d(?=(\d{3})+\.)/g,'$&,') + '</strong></td>';
                tabla += '</tr>';
                tabla += '</tbody>';
                tabla += '</table>';

                $('.resultado').html(tabla);
                $('#descuentorealco').val(val.resultado.colegiatura);
                $('#recargoco').val(val.resultado.recargo);
                $('#descuentorealco_efe').val(val.resultado.colegiatura);
                $('#recargoco_efe').val(val.resultado.recargo);
            }
        });
    });
      $(".mespago_ec").change(function () {
        var idmes = $(".mespago_ec").find("option:selected").val(); 
        $.ajax({
            type: "POST",
            url:  my_var_1 +"Tutores/agregarCostoColegiatura",
            data: "mes=" + idmes + "&alumno=" + my_var_2 + "&periodo=" + my_var_3,
            dataType: "html",
            success: function (response) {
                $('#tbldefault').hide();
                $('#descuentorealco').val('');
                $('#recargoco').val('');
                $('#descuentorealco_efe').val('');
                $('#recargoco_efe').val('');
                var val = JSON.parse(response);

                var tabla = '<div class="table-responsive">';
                tabla += '<table class="table">';
                tabla += '<tbody>';
                tabla += '<tr>';
                tabla += '<th style="width:50%">CONCEPTO:</th>';
                tabla += '<td><label for="">PAGO DE COLEGIATURA</label></td>';
                tabla += '</tr>';
                tabla += '<tr>';
                tabla += '<td>COLEGIATURA:</td>';
                tabla += '<td>$' + (val.resultado.colegiatura).toFixed(2).replace(/\d(?=(\d{3})+\.)/g,'$&,') + '</td>';
                tabla += '</tr>';

                if (val.resultado.recargo > 0) {
                    tabla += '<tr>';
                    tabla += '<td>RECARGO</td>';
                    tabla += ' <td>$' +  (val.resultado.recargo).toFixed(2).replace(/\d(?=(\d{3})+\.)/g,'$&,') + '</td>';
                    tabla += '</tr>';
                }

                tabla += '<tr>';
                tabla += '<th style="width:50%">SUBTOTAL:</th>';
                tabla += '<td><strong>$' +  (val.resultado.costototal).toFixed(2).replace(/\d(?=(\d{3})+\.)/g,'$&,') + '</strong></td>';
                tabla += '</tr>';

                tabla += '<tr>';
                tabla += '<th>TOTAL:</th>';
                tabla += '<td><strong>$' +  (val.resultado.costototal).toFixed(2).replace(/\d(?=(\d{3})+\.)/g,'$&,') + '</strong></td>';
                tabla += '</tr>';
                tabla += '</tbody>';
                tabla += '</table>';

                $('.resultado').html(tabla);
                $('#descuentorealco').val(val.resultado.colegiatura);
                $('#recargoco').val(val.resultado.recargo);
                $('#descuentorealco_efe').val(val.resultado.colegiatura);
                $('#recargoco_efe').val(val.resultado.recargo);
            }
        });
    });
});