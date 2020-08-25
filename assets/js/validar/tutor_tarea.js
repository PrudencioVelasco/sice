$(document).ready(function () {
    var this_js_script = $('script[src*=tutor]');
    var my_var_1 = this_js_script.attr('data-my_var_1');
    if (typeof my_var_1 === "undefined") {
        var my_var_1 = 'some_default_value';
    }

    $(document).on("click", '.edit_button_tarea', function (e) {
        var idtarea = $(this).data('idtarea');
        var fechaentrega = $(this).data('fechaentrega');
        var tarea = $(this).data('tarea');
        CKEDITOR.instances['ckeditoredit'].setData(tarea);
        $(".idtarea").val(idtarea);
        // $(".planeacion").val(planeacion);  
        $(".fechaentrega").val(fechaentrega);
        // $("#entradanumeroparte_salida").text(numeroparte);    
    });

    $("#btnguardar").click(function () {

        $('#btnguardar').prop("disabled", true);
        $('#btnguardar').html(
                `<span class="fa fa-spinner spinner-border-sm" role="status" aria-hidden="true"></span> PROCESANDO...`
                );

        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
        }
        var file_data = $('#documento').prop('files')[0];
        var form_data = new FormData();
        form_data.append('documento',file_data); 
         form_data.append('fechaentrega',$('#fechaentrega')); 
          form_data.append('horaentrega',$('#horaentrega')); 
           form_data.append('tarea',$('#tarea')); 
        
        $.ajax({
            type: "POST",
            //dataType:'text',
            //cache:false,
            //contentType:false,
            async:true,
            processData:false,
            url: my_var_1 + "Pgrupo/addTarea",
            data: form_data,
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
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
        }
        $.ajax({
            type: "POST",
            url: my_var_1 + "Pgrupo/updateTarea",
            data: $('#frmmodificartarea').serialize(),
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
});