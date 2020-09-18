$(document).ready(function() {
	var this_js_script = $('script[src*=calificacion]');
	var my_var_1 = this_js_script.attr('data-my_var_1');
	if (typeof my_var_1 === "undefined") {
		var my_var_1 = 'some_default_value';
	}
	$(document).on("click", '.add_button', function(e) {
		var idcalificacion = $(this).data('idcalificacion');
		var nombre = $(this).data('alumno');
		$(".idcalificacion").val(idcalificacion);
		$("#alumno_faltas_add").text(nombre);
	});

	$(document).on("click", '.add_button_retardo', function(e) {
		var idcalificacion = $(this).data('idcalificacion');
		var nombre = $(this).data('alumno');
		$(".idcalificacion").val(idcalificacion);
		$("#alumno_retardo_add").text(nombre);
	});


	$(document).on("click", '.edit_button', function(e) {
		var id = $(this).data('id');
		var nombre = $(this).data('alumno');
		var faltas = $(this).data('faltas');
		$(".id").val(id);
		$(".faltas").val(faltas);
		$("#alumno_faltas_add").text(nombre);
	});

	$(document).on("click", '.edit_button_retardo', function(e) {
		var id = $(this).data('id');
		var nombre = $(this).data('alumno');
		var retardo = $(this).data('retardo');
		$(".id").val(id);
		$(".retardo").val(retardo);
		$("#alumno_retardo_edit").text(nombre);
	});
	
		$(document).on("click", '.add_button_diciplina', function(e) { 
		var nombre = $(this).data('alumno');
		var idhorario = $(this).data('idhorario');
		var idalumno = $(this).data('idalumno');
		$(".idhorario").val(idhorario);
		$(".idalumno").val(idalumno);
		$("#alumno_diciplina_add").text(nombre);
	});
	
	  $("#btnaddfaltas").click(function () {
        $('#btnaddfaltas').prop("disabled", true);
        $('#btnaddfaltas').html(
            `<span class="fa fa-spinner spinner-border-sm" role="status" aria-hidden="true"></span> PROCESANDO...`
        ); 
        $.ajax({
            type: "POST",
            url: my_var_1 +"Calificacion/addFaltasCalificacion",
            data: $('#frmaddfaltas').serialize(),
            success: function (data) {
                $('#btnaddfaltas').prop("disabled", false);
                $('#btnaddfaltas').html(
                    `<i class='fa fa-plus-circle'></i> AGREGAR`
                );
                var val = $.parseJSON(data); 
                if ((val.success === "Ok")) {
                    swal({
                        position: 'center',
                        type: 'success',
                        title: 'Registrado!',
                        text: 'Fue registrado las faltas con exito.',
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

	  $("#btnaddretardo").click(function () {
        $('#btnaddretardo').prop("disabled", true);
        $('#btnaddretardo').html(
            `<span class="fa fa-spinner spinner-border-sm" role="status" aria-hidden="true"></span> PROCESANDO...`
        ); 
        $.ajax({
            type: "POST",
            url: my_var_1 +"Calificacion/addRetardo",
            data: $('#frmaddretardo').serialize(),
            success: function (data) {
                $('#btnaddfaltas').prop("disabled", false);
                $('#btnaddfaltas').html(
                    `<i class='fa fa-plus-circle'></i> AGREGAR`
                );
                var val = $.parseJSON(data); 
                if ((val.success === "Ok")) {
                    swal({
                        position: 'center',
                        type: 'success',
                        title: 'Registrado!',
                        text: 'Fue registrado los retardos con exito.',
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


	  $("#btnmodificarretardo").click(function () {
        $('#btnmodificarretardo').prop("disabled", true);
        $('#btnmodificarretardo').html(
            `<span class="fa fa-spinner spinner-border-sm" role="status" aria-hidden="true"></span> PROCESANDO...`
        ); 
        $.ajax({
            type: "POST",
            url: my_var_1 +"Calificacion/updateRetardo",
            data: $('#frmmodificarretardo').serialize(),
            success: function (data) {
                $('#btnaddfaltas').prop("disabled", false);
                $('#btnaddfaltas').html(
                    `<i class='fa fa fa-pencil'></i> MODIFICAR`
                );
                var val = $.parseJSON(data); 
                if ((val.success === "Ok")) {
                    swal({
                        position: 'center',
                        type: 'success',
                        title: 'Registrado!',
                        text: 'Fue modificado los retardos con exito.',
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

	  $("#btnmodificarfaltas").click(function () {
        $('#btnmodificarfaltas').prop("disabled", true);
        $('#btnmodificarfaltas').html(
            `<span class="fa fa-spinner spinner-border-sm" role="status" aria-hidden="true"></span> PROCESANDO...`
        ); 
        $.ajax({
            type: "POST",
            url: my_var_1 +"Calificacion/updateFaltasCalificacion",
            data: $('#frmmodificarfaltas').serialize(),
            success: function (data) {
                $('#btnaddfaltas').prop("disabled", false);
                $('#btnaddfaltas').html(
                    `<i class='fa fa fa-pencil'></i> MODIFICAR`
                );
                var val = $.parseJSON(data); 
                if ((val.success === "Ok")) {
                    swal({
                        position: 'center',
                        type: 'success',
                        title: 'Registrado!',
                        text: 'Fue modificado las faltas con exito.',
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

	  $("#btnmodificarfaltas").click(function () {
        $('#btnmodificarfaltas').prop("disabled", true);
        $('#btnmodificarfaltas').html(
            `<span class="fa fa-spinner spinner-border-sm" role="status" aria-hidden="true"></span> PROCESANDO...`
        ); 
        $.ajax({
            type: "POST",
            url: my_var_1 +"Calificacion/updateFaltasCalificacion",
            data: $('#frmmodificarfaltas').serialize(),
            success: function (data) {
                $('#btnaddfaltas').prop("disabled", false);
                $('#btnaddfaltas').html(
                    `<i class='fa fa fa-pencil'></i> MODIFICAR`
                );
                var val = $.parseJSON(data); 
                if ((val.success === "Ok")) {
                    swal({
                        position: 'center',
                        type: 'success',
                        title: 'Registrado!',
                        text: 'Fue modificado las faltas con exito.',
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