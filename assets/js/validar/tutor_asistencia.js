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
                        title: 'Las asistencias fueron registrado con Exito!',
                        text: 'Dar clic en el boton.',
                        showConfirmButton: true 
                    }).then(function () {
                        location.reload();
                    });
                } else {
                    swal({
                        type: 'error',
                        title: 'Oops...',
                        html: val.error,
                        customClass: 'swal-wide',
                        footer: ''
                    }); 
                }

            }
        })
    });

    /*$("#btnbuscar").click(function () {
        $('#btnbuscar').prop("disabled", true);
        $('#btnbuscar').html(
            `<span class="fa fa-spinner spinner-border-sm" role="status" aria-hidden="true"></span> BUSCANDO...`
        );
        var fechainicio = $("#fechainicio").val();
        var fechafin = $("#fechafin").val();
        var motivo = $("#motivo").val();
        var idhorario = $("#idhorario").val();
        var idhorariodetalle = $("#idhorariodetalle").val();
        if (fechainicio != "" && fechafin != "") {
            $.ajax({
                type: "POST",
                url: my_var_1 +"Pgrupo/buscarAsistencia",
                data: $('#frmbuscar').serialize(),
                success: function (data) { 
                    $('#btnbuscar').prop("disabled", false);
                    $('#btnbuscar').html(
                        `<i class='fa fa-search'></i> BUSCAR`
                    );
                    $("#tblalumnos").css('display', 'none');
                    $('#tblasistencias').html(data);


                }
            })
       

            if (fechainicio != "" && fechafin != "" && motivo != "") {
                window.location = "<?php echo site_url('Aalumno/buscarAsistencia/'); ?>/" + idhorario + '/' + idhorariodetalle + '/' + fechainicio + '/' + fechafin + '/' + motivo + '/';
            } else {
                swal({
                    type: 'error',
                    title: 'Oops...',
                    html: 'Todos los campos son obligatorios.',
                    customClass: 'swal-wide',
                    footer: ''
                });
            }

            
        } else {
            $('#btnbuscar').prop("disabled", false);
            $('#btnbuscar').html(
                `<i class='fa fa-search'></i> BUSCAR`
            );
             swal({
                type: 'error',
                title: 'Oops...',
                html: 'Es necesario la Fecha',
                customClass: 'swal-wide',
                footer: ''
            });

        }

    });*/

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
                        title: 'Fue eliminado las Asistencias con Exito!',
                        text: 'Dar clic en el boton.',
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
                type: 'error',
                title: 'Oops...',
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
                        title: 'Fue eliminado la Asistencia con Exito!',
                        text: 'Dar clic en el boton.',
                        showConfirmButton: true 
                    }).then(function () {
                        location.reload();
                    }); 
                } else {
                    swal({
                        type: 'error',
                        title: 'Oops...',
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
                        title: 'Fue modificado la Asistencia con Exito!',
                        text: 'Dar clic en el boton.',
                        showConfirmButton: true 
                    }).then(function () {
                        location.reload();
                    }); 
                } else {
                    swal({
                        type: 'error',
                        title: 'Oops...',
                        html: val.error,
                        customClass: 'swal-wide',
                        footer: ''
                    }); 
                }

            }
        })
    });
});