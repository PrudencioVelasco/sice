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
		var idunidad = $(this).data('idunidad');
		$(".idhorario").val(idhorario);
		$(".idalumno").val(idalumno);
		$(".idunidad").val(idunidad);
		$("#alumno_diciplina_add").text(nombre);
	});
	
	$(document).on("click", '.edit_button_diciplina', function(e) { 
		var nombre = $(this).data('alumno');
		var iddisciplina = $(this).data('iddisciplina');
		var disciplina = $(this).data('disciplina');
		var idpresentacionpersonal = $(this).data('idpresentacionpersonal');
		var presentacionpersonal = $(this).data('presentacionpersonal'); 
		$(".iddisciplina").val(iddisciplina);
		$(".idpresentacionpersonal").val(idpresentacionpersonal);
		$(".presentacionpersonal").val(presentacionpersonal);
		$(".disciplina").val(disciplina);
		$("#alumno_diciplina_edit").text(nombre);
	});
	
		$(document).on("click", '.add_button_calificacion', function(e) { 
		var nombre = $(this).data('alumno');
		var idhorario = $(this).data('idhorario');
		var idalumno = $(this).data('idalumno');
		var idhorariodetalle = $(this).data('idhorariodetalle'); 
		var nombremes = $(this).data('nombremes');
		var idmes = $(this).data('idmes'); 
		$(".idhorariodetalle").val(idhorariodetalle);
		$(".idalumno").val(idalumno);
		$(".idhorario").val(idhorario); 
		$(".nombremes").val(nombremes); 
		$(".idmes").val(idmes); 
		$("#alumno_calificacion_add").text(nombre);
	});
   $(document).on("click", '.edit_button_calificacion', function(e) { 
		var nombre = $(this).data('alumno');
		var calificacion = $(this).data('calificacion');
		var idcalificacion = $(this).data('idcalificacion');
		var iddetallecalificacion = $(this).data('iddetallecalificacion');
		
		$(".idcalificacion").val(idcalificacion);
		$(".iddetallecalificacion").val(iddetallecalificacion);
		$(".calificacion").val(calificacion);  
		$("#alumno_calificacion_edit").text(nombre);
    });
    
    $(document).on("click", '.delete_button_calificacion', function(e) { 
		var nombre = $(this).data('alumno');
		var calificacion = $(this).data('calificacion');
		var idcalificacion = $(this).data('idcalificacion');
		var iddetallecalificacion = $(this).data('iddetallecalificacion');
		
		$(".idcalificacion").val(idcalificacion);
		$(".iddetallecalificacion").val(iddetallecalificacion);
		//$(".calificacion").val(calificacion);  
		$("#alumnodelete").text(nombre);
    });
    
    $("#btneliminar").click(function () {
    $('#btneliminar').prop("disabled", true);
    $('#btneliminar').html(
        `<span class="fa fa-spinner spinner-border-sm" role="status" aria-hidden="true"></span> PROCESANDO...`
    ); 
    $.ajax({
        type: "POST",
        url: my_var_1 +"Calificacion/deleteCalificacionAdmin",
        data: $('#frmeliminar').serialize(),
        success: function (data) {
            $('#btneliminar').prop("disabled", false);
            $('#btneliminar').html(
                `<i class='fa fa-trash'></i> ELIMINAR`
            );
            var val = $.parseJSON(data); 
            if ((val.success === "Ok")) {
                swal({
                    position: 'center',
                    type: 'success',
                    title: 'Eliminado!',
                    text: 'Fue eliminado la calificación con exito.',
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

		$("#btnaddcalificacion").click(function () {
        $('#btnaddcalificacion').prop("disabled", true);
        $('#btnaddcalificacion').html(
            `<span class="fa fa-spinner spinner-border-sm" role="status" aria-hidden="true"></span> PROCESANDO...`
        ); 
        $.ajax({
            type: "POST",
            url: my_var_1 +"Calificacion/addCalificacionAdmin",
            data: $('#frmaddcalificacion').serialize(),
            success: function (data) {
                $('#btnaddcalificacion').prop("disabled", false);
                $('#btnaddcalificacion').html(
                    `<i class='fa fa-plus-circle'></i> AGREGAR`
                );
                var val = $.parseJSON(data); 
                if ((val.success === "Ok")) {
                    swal({
                        position: 'center',
                        type: 'success',
                        title: 'Registrado!',
                        text: 'Fue registrado la calificación con exito.',
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

	 $("#btneditarcalificacion").click(function () {
        $('#btneditarcalificacion').prop("disabled", true);
        $('#btneditarcalificacion').html(
            `<span class="fa fa-spinner spinner-border-sm" role="status" aria-hidden="true"></span> PROCESANDO...`
        ); 
        $.ajax({
            type: "POST",
            url: my_var_1 +"Calificacion/updteCalificacionAdmin",
            data: $('#frmeditarcalificacion').serialize(),
            success: function (data) {
                $('#btneditarcalificacion').prop("disabled", false);
                $('#btneditarcalificacion').html(
                    `<i class='fa fa fa-pencil'></i> MODIFICAR`
                );
                var val = $.parseJSON(data); 
                if ((val.success === "Ok")) {
                    swal({
                        position: 'center',
                        type: 'success',
                        title: 'Modificado!',
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
                $('#btnaddretardo').prop("disabled", false);
                $('#btnaddretardo').html(
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
                $('#btnmodificarretardo').prop("disabled", false);
                $('#btnmodificarretardo').html(
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
                $('#btnmodificarfaltas').prop("disabled", false);
                $('#btnmodificarfaltas').html(
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
                $('#btnmodificarfaltas').prop("disabled", false);
                $('#btnmodificarfaltas').html(
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

  $("#btnagregardiciplina").click(function () {
        $('#btnagregardiciplina').prop("disabled", true);
        $('#btnagregardiciplina').html(
            `<span class="fa fa-spinner spinner-border-sm" role="status" aria-hidden="true"></span> PROCESANDO...`
        ); 
        $.ajax({
            type: "POST",
            url: my_var_1 +"Calificacion/addDisciplina",
            data: $('#frmagregardisciplina').serialize(),
            success: function (data) {
                $('#btnagregardiciplina').prop("disabled", false);
                $('#btnagregardiciplina').html(
                    `<i class='fa fa-plus-circle'></i> AGREGAR`
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
	  $("#btneditardiciplina").click(function () {
        $('#btneditardiciplina').prop("disabled", true);
        $('#btneditardiciplina').html(
            `<span class="fa fa-spinner spinner-border-sm" role="status" aria-hidden="true"></span> PROCESANDO...`
        ); 
        $.ajax({
            type: "POST",
            url: my_var_1 +"Calificacion/editisciplina",
            data: $('#frmeditardisciplina').serialize(),
            success: function (data) {
                $('#btneditardiciplina').prop("disabled", false);
                $('#btneditardiciplina').html(
                    `<i class='fa fa fa-pencil'></i> MODIFICAR`
                );
                var val = $.parseJSON(data); 
                if ((val.success === "Ok")) {
                    swal({
                        position: 'center',
                        type: 'success',
                        title: 'Modificado!',
                        text: 'Fue modificado  con exito.',
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