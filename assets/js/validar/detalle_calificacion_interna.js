$(document).ready(function () {
    var this_js_script = $('script[src*=detalle_calificacion_interna]');
    var my_var_1 = this_js_script.attr('data-my_var_1');
    if (typeof my_var_1 === "undefined") {
        var my_var_1 = 'some_default_value';
    }
    $(document).on("click", '.edit_button_new', function (e) {
        var idcalificacion = $(this).data('idcalificacion');
        var iddetallecalificacion = $(this).data('iddetallecalificacion');
        var calificacion = $(this).data('calificacion');
        var nombre = $(this).data('alumno');

        $(".idcalificacion").val(idcalificacion);
        $(".calificacion").val(calificacion);
        $(".iddetallecalificacion").val(iddetallecalificacion);
        $("#alumno").text(nombre);
    });
    $(document).on("click", '.eliminar_button_new', function (e) {
        var idcalificacion = $(this).data('idcalificacion');
        var iddetallecalificacion = $(this).data('iddetallecalificacion');
        var calificacion = $(this).data('calificacion');
        var nombre = $(this).data('alumno');

        $(".idcalificacion").val(idcalificacion);
        $(".calificacion").val(calificacion);
        $(".iddetallecalificacion").val(iddetallecalificacion);
        $(".alumno").text(nombre);
    });
    $("#btnmodificar").click(function () {
        $('#btnmodificar').prop("disabled", true);
        $('#btnmodificar').html(
            `<span class="fa fa-spinner fa-pulse  fa-fw spinner-border-sm" role="status" aria-hidden="true"></span> PROCESANDO...`
        );
        $.ajax({
            type: "POST",
            url: my_var_1 + "Pgrupo/updateCalificacionInterna",
            data: $('#frmmodificar').serialize(),
            success: function (data) {
                $('#btnmodificar').prop("disabled", false);
                $('#btnmodificar').html(
                    `<i class='fa fa-pencil'></i> MODIFICAR`
                );
                var val = $.parseJSON(data);
                if ((val.success === "Ok")) {
                    swal({
                        position: 'center',
                        type: 'success',
                        title: 'Notificación!',
                        html: val.mensaje,
                        showConfirmButton: true,
                    }).then(function () {
                        location.reload();
                    });
                } else {
                    swal({
                        type: 'info',
                        title: 'Notificación',
                        html: val.error,
                        customClass: 'swal-wide',
                        footer: ''
                    });
                }

            }
        })
    });

    $("#btneliminar").click(function () {
        $('#btneliminar').prop("disabled", true);
        $('#btneliminar').html(
            `<span class="fa fa-spinner fa-pulse  fa-fw spinner-border-sm" role="status" aria-hidden="true"></span> PROCESANDO...`
        );
        $.ajax({
            type: "POST",
            url: my_var_1 + "Pgrupo/eliminarCalificacionInterna",
            data: $('#frmeliminar').serialize(),
            success: function (data) {
                $('#btneliminar').prop("disabled", false);
                $('#btneliminar').html(
                    `<i class='fa fa-pencil'></i> ELIMINAR`
                );
                var val = $.parseJSON(data);
                if ((val.success === "Ok")) {
                    swal({
                        position: 'center',
                        type: 'success',
                        title: 'Notificación!',
                        html: val.mensaje,
                        showConfirmButton: true,
                    }).then(function () {
                        location.reload();
                    });
                } else {
                    swal({
                        type: 'info',
                        title: 'Notificación',
                        html: val.error,
                        customClass: 'swal-wide',
                        footer: ''
                    });
                }

            }
        })
    });
});