$(document).ready(function () {
    var this_js_script = $('script[src*=alumno_secundaria]');
    var my_var_1 = this_js_script.attr('data-my_var_1');
    if (typeof my_var_1 === "undefined") {
        var my_var_1 = 'some_default_value';
    } 
        $(document).on("click", '.detalle_button', function (e) {
        var idcalificacion = $(this).data('idcalificacion');
        var iddetallecalificacion = $(this).data('iddetallecalificacion');
        var calificacion = $(this).data('calificacion');
        var nombre = $(this).data('alumno'); 
        var proyecto = $(this).data('proyecto');
        var tarea = $(this).data('tarea');
        var participacion = $(this).data('participacion');
        var examen = $(this).data('examen'); 
        $(".idcalificacion").val(idcalificacion); 

        $(".pproyecto_calificacion").text(proyecto + "%");
        $(".ptarea_calificacion").text(tarea+ "%");
        $(".pparticipacion_calificacion").text(participacion+ "%");
        $(".pexamen_calificacion").text(examen+ "%");
        $(".iddetallecalificacion").val(iddetallecalificacion);
        $("#alumno_detalle").text(nombre);
    }); 
 
});