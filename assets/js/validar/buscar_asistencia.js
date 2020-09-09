$(document).ready(function () {
    var this_js_script = $('script[src*=buscar_asistencia]');
    var my_var_1 = this_js_script.attr('data-my_var_1');
    if (typeof my_var_1 === "undefined") {
        var my_var_1 = 'some_default_value';
    }
    $('#curso').prop('disabled', 'disabled');
       $("#idgrupo").click(function () {
        var idperiodo = $("#idperiodo").find("option:selected").val();
		var idgrupo = $("#idgrupo").find("option:selected").val();
        if(idperiodo != ''){
	        $.ajax({
	            type: "POST",
	            url: my_var_1 +"Calificacion/buscarCursos",
	            data: "idperiodo=" + idperiodo + "&idgrupo=" + idgrupo,
	            success: function (data) {
	               
	                    $('#curso').empty().append('<option value="">-- CURSO --</option>'); 
	                    $("#curso").prop("disabled", false);
	                    $("#curso").append(data);
	
	
	            }
	        });
		}else{
			Swal.fire({
                type: 'info',
                title: 'Notificación',
                text: "SELECCIONE EL PERIODO ESCOLAR."
            });
		}

    }); 
});