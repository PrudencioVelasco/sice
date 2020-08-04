$(document).ready(function () {
    var this_js_script = $('script[src*=tutor]');
    var my_var_1 = this_js_script.attr('data-my_var_1');
    if (typeof my_var_1 === "undefined") {
        var my_var_1 = 'some_default_value';
    } 

    $(document).on("click", '.edit_button', function (e) {
        var idasistencia = $(this).data('idasistencia');
        var nombre = $(this).data('alumno');

        $(".idasistencia").val(idasistencia);
        $("#alumno").text(nombre);
    });

    $(document).on("click", '.delete_button', function (e) {
        var idasistencia = $(this).data('idasistencia');
        var nombre = $(this).data('alumno');

        $(".idasistencia").val(idasistencia);
        $("#alumnodelete").text(nombre);
    });

    $("#btnguardar").click(function () {
        $('#btnguardar').prop("disabled", true);
        $('#btnguardar').html(
            `<span class="fa fa-spinner spinner-border-sm" role="status" aria-hidden="true"></span> PROCESANDO...`
        );
        $.ajax({
            type: "POST",
            url: my_var_1 +"Pgrupo/addAsistencia",
            data: $('#frmasistencia').serialize(),
            success: function (data) {
                $('#btnguardar').prop("disabled", false);
                $('#btnguardar').html(
                    `<i class='fa fa-floppy-o'></i> GUARDAR`
                );
                var val = $.parseJSON(data); 
                if ((val.success === "Ok")) { 
                    swal({
                        position: 'center',
                        type: 'success',
                        title: 'Registrado!',
                        text: 'Fue registrado las asistencias con exito.',
                        showConfirmButton: true 
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

    $("#btneliminarasistencia").click(function () {
        $('#btneliminarasistencia').prop("disabled", true);
        $('#btneliminarasistencia').html(
            `<span class="fa fa-spinner spinner-border-sm" role="status" aria-hidden="true"></span> PROCESANDO...`
        );
        var fechainicio = $("#fechaeliminar").val();
        if (fechainicio != "") {
            $.ajax({
                type: "POST",
                url: my_var_1 +"Pgrupo/eliminarAsistenciaFecha",
                data: $('#frmeliminarasistencia').serialize(),
                success: function (data) {
                    $('#btneliminarasistencia').prop("disabled", false);
                    $('#btneliminarasistencia').html(
                        `<i class="fa fa-trash"></i> ELIMINAR`
                    );
                    swal({
                        position: 'center',
                        type: 'success',
                        title: 'Eliminado!',
                        text: 'Fue eliminado las asientencias con exito.',
                        showConfirmButton: true 
                    }).then(function () {
                        location.reload();
                    });


                }
            })
        } else {
            $('#btneliminarasistencia').prop("disabled", false);
            $('#btneliminarasistencia').html(
                `<i class="fa fa-trash"></i> ELIMINAR`
            );
             swal({
                type: 'info',
                title: 'Notificación',
                html: 'Es necesario la Fecha',
                customClass: 'swal-wide',
                footer: ''
            });

        }

    });

    $("#btneliminar").click(function () {
        $.ajax({
            type: "POST",
            url: my_var_1 +"Pgrupo/eliminarAsistencia",
            data: $('#frmeliminar').serialize(),
            success: function (data) {
                var val = $.parseJSON(data);
                if ((val.success === "Ok")) {
                     swal({
                        position: 'center',
                        type: 'success',
                        title: 'Eliminado!',
                        text: 'Fue eliminado la asistencia con exito.',
                        showConfirmButton: true 
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


    $("#btnmodificar").click(function () {
        $('#btnmodificar').prop("disabled", true);
        $('#btnmodificar').html(
            `<span class="fa fa-spinner spinner-border-sm" role="status" aria-hidden="true"></span> PROCESANDO...`
        );
        $.ajax({
            type: "POST",
            url: my_var_1 +"Pgrupo/updateAsistencia",
            data: $('#frmmodificar').serialize(),
            success: function (data) {
                $('#btnmodificar').prop("disabled", false);
                $('#btnmodificar').html(
                    `<i class="fa fa-pencil"></i> MODIFICAR`
                );
                var val = $.parseJSON(data);
                if ((val.success === "Ok")) { 
                    swal({
                        position: 'center',
                        type: 'success',
                        title: 'Modificado!',
                        text: 'Fue modificado la asistencia con exito.',
                        showConfirmButton: true 
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