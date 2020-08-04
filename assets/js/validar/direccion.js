$(document).ready(function () {
    var this_js_script = $('script[src*=direccion]');
    var my_var_1 = this_js_script.attr('data-my_var_1');
    if (typeof my_var_1 === "undefined") {
        var my_var_1 = 'some_default_value';
    }
    $('.colonia').prop('disabled', 'disabled');
    $('#mensajecp').hide();
    $("#cp").keyup(function (e) {
        var dat = $("#cp").val();
        if (dat.length === 5) {
            $.ajax({
                type: "POST",
                url: my_var_1 + "Tutores/buscarCP",
                data: "b=" + dat,
                dataType: "html",
                beforeSend: function () {
                    //imagen de carga
                    // $("#resultado").html("<p align='center'><img src='ajax-loader.gif' /></p>");
                },
                error: function (data) {
                    //console.log(data);
                },
                success: function (data) {

                    if ($.trim(data)) {
                        $('#mensajecp').hide();
                        $(".colonia").prop("disabled", false);
                         var data2 = '<option value="" selected>--SELECCIONAR--</option>';
                        $('#colonia').html(data2).selectpicker('refresh');
                       
                        $("#colonia")
                                .append(data)
                                .selectpicker('refresh');
                    } else {
                        $(".colonia").prop('disabled', 'disabled');
                        $('#colonia').html('').selectpicker('refresh');
                        var datos = '<option value="">--SELECCIONAR--</option>';
                        $("#colonia")
                                .append(datos)
                                .selectpicker('refresh');
                        $('#mensajecp').show();
                    }

                }
            })
        }
    });
    $("#cp").keyup(function (e) {
        var dat = $("#cp").val();
        if (dat.length === 5) {
            $.ajax({
                type: "POST",
                url: my_var_1 + "Tutores/buscarMunicipioCP",
                data: "b=" + dat,
                dataType: "html",
                beforeSend: function () {
                    //imagen de carga
                    // $("#resultado").html("<p align='center'><img src='ajax-loader.gif' /></p>");
                },
                error: function () {
                    alert("error petición ajax");
                },
                success: function (data) {
                    //console.log(data);
                    $('#municipio').html('').selectpicker('refresh');
                    $("#municipio")
                            .append(data)
                            .selectpicker('refresh');
                }
            })
        }
    });
    $("#cp").keyup(function (e) {
        var dat = $("#cp").val();
        if (dat.length === 5) {
            $.ajax({
                type: "POST",
                url: my_var_1 + "Tutores/buscarEstadoCP",
                data: "b=" + dat,
                dataType: "html",
                beforeSend: function () {
                    //imagen de carga
                    // $("#resultado").html("<p align='center'><img src='ajax-loader.gif' /></p>");
                },
                error: function () {
                    alert("error petición ajax");
                },
                success: function (data) {
                    //console.log(data);
                    $('#estado').html('').selectpicker('refresh');
                    $("#estado")
                            .append(data)
                            .selectpicker('refresh');
                }
            });
        }
    });
});