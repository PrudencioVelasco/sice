$(document).ready(function () {
    var this_js_script = $('script[src*=direccion]');
    var my_var_1 = this_js_script.attr('data-my_var_1');
    if (typeof my_var_1 === "undefined") {
        var my_var_1 = 'some_default_value';
    } 
//console.log(my_var_1);
    //$('#loadingeffects').hide(true);
    $("#cp").keyup(function (e) {
        var dat = $("#cp").val();
        if (dat.length === 5) {
            $.ajax({
                type: "POST",
                url: my_var_1+"Tutores/buscarCP",
                data: "b=" + dat,
                dataType: "html",
                beforeSend: function () {
                    //imagen de carga
                    // $("#resultado").html("<p align='center'><img src='ajax-loader.gif' /></p>");
                },
                error: function (data) {
                    console.log(data);
                },
                success: function (data) {
                    console.log(data);
                    $("#colonia").empty();
                    $("#colonia").append(data);
                }
            })
        }
    });
    $("#cp").keyup(function (e) {
        var dat = $("#cp").val();
        if (dat.length === 5) {
            $.ajax({
                type: "POST",
                url: my_var_1 +"Tutores/buscarMunicipioCP",
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
                    $("#municipio").empty();
                    $("#municipio").append(data);
                }
            })
        }
    });
    $("#cp").keyup(function (e) {
        var dat = $("#cp").val();
        if (dat.length === 5) {
            $.ajax({
                type: "POST",
                url: my_var_1 +"Tutores/buscarEstadoCP",
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
                    $("#estado").empty();
                    $("#estado").append(data);
                }
            })
        }
    }); 
});