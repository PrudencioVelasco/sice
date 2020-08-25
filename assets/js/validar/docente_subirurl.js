$(document).ready(function () {
    var this_js_script = $('script[src*=docente_subirurl]');
    var my_var_1 = this_js_script.attr('data-my_var_1');
    if (typeof my_var_1 === "undefined") {
        var my_var_1 = 'some_default_value';
    }

    $(document).on("click", '.add_button_url', function (e) {
        var idhorariodetalle = $(this).data('idhorariodetalle'); 
        $(".idhorariodetalle").val(idhorariodetalle);   
    });
    
    $(document).on("click", '.edit_button_url', function (e) {
        var idhorariodetalle = $(this).data('idhorariodetalle'); 
         var urlvideo = $(this).data('urlvideo'); 
        $(".idhorariodetalle").val(idhorariodetalle);   
        $(".utlvideo").val(urlvideo);   
    });
    
    $(document).on("click", '.delete_button_url', function (e) {
        var idhorariodetalle = $(this).data('idhorariodetalle'); 
        $(".idhorariodetalle").val(idhorariodetalle);   
    });
    
    
    

    $("#btnguardar").click(function () {

        $('#btnguardar').prop("disabled", true);
        $('#btnguardar').html(
            `<span class="fa fa-spinner spinner-border-sm" role="status" aria-hidden="true"></span> PROCESANDO...`
        ); 
        $.ajax({
            type: "POST",
            url: my_var_1 +"Phorario/addUrlVideoGrabadoHorario",
            data: $('#frmurl').serialize(),
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
                        text: 'Fue registrado con exito.',
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
            url: my_var_1 +"Phorario/updateUrlVideoGrabadoHorario",
            data: $('#frmmodificar').serialize(),
            success: function (data) {
                $('#btnmodificar').prop("disabled", false);
                $('#btnmodificar').html(
                    `<i class='fa fa-pencil-square-o'></i> MODIFICAR`
                );
                var val = $.parseJSON(data); 
                if ((val.success === "Ok")) { 
                    swal({
                        position: 'center',
                        type: 'success',
                        title: 'Modificado!',
                        text: 'Fue modificado con exito.',
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
      $("#btneliminar").click(function () {
        $('#btneliminar').prop("disabled", true);
        $('#btneliminar').html(
            `<span class="fa fa-spinner spinner-border-sm" role="status" aria-hidden="true"></span> PROCESANDO...`
        ); 
        $.ajax({
            type: "POST",
            url: my_var_1 +"Phorario/deleteUrlVideoGrabadoHorario",
            data: $('#frmeliminar').serialize(),
            success: function (data) {
                $('#btneliminar').prop("disabled", false);
                $('#btneliminar').html(
                    `<i class='fa fa-trash '></i> ELIMINAR`
                );
                var val = $.parseJSON(data); 
                if ((val.success === "Ok")) { 
                    swal({
                        position: 'center',
                        type: 'success',
                        title: 'Eliminado!',
                        text: 'Fue eliminado con exito.',
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