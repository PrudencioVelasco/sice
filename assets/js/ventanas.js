$(document).ready(function () {
  //$("#modalRegistrarCalificacionBasico").modal({backdrop: "static", keyboard: false});
  //$("#modalEliminarCalificacionBasico").modal({backdrop: "static", keyboard: false});
  $(".cerrarventana").click(function () {
    Swal.fire({
      title: "¿CANCELAR?",
      text: "Esta seguro de cancelar la operación.",
      type: "question",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Si",
      cancelButtonText: "No"
    }).then(result => {
      if (result.value) {
        $("#largeModal").modal("hide");
        $("#myModalDeleteAsistencia").modal("hide");
        $("#myModalModificarMesCalificacion").modal("hide");
        $("#modalRegistrarAsistencia").modal("hide");
        $("#modaEliminarAsistencia").modal("hide");

        $("#smodalRegistrarAsistencia").modal("hide");
        $("#smodalEliminarAsistencia").modal("hide");

        $("#modalRegistrarCalificacionLic").modal("hide");
        $("#modalEliminarCalificacionLic").modal("hide");

        $("#modalRegistrarCalificacionPrepa").modal("hide");
        $("#modalEliminarCalificacionPrepa").modal("hide");

        $("#modalRegistrarCalificacionRecuperacionPrepa").modal("hide");
        $("#modalEliminarCalificacionRecuperacionPrepa").modal("hide");

        $("#myModalEliminarCalificacion").modal("hide");
      }
    });
  });
});