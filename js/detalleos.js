$(document).ready(function () {
  var ruta = window.location.pathname.match("(.*/).*")[1];

  var tablaDetalleOs = $("#tablaDetalleOs").DataTable({
    language: {
      url: "" + ruta + "api/Spanish.json",
    },
    ajax: {
      url: "api/getPresentaciones.php",
      method: "POST", //usamos el metodo POST
      //"data":{opcion:opcion}, //enviamos opcion 4 para que haga un SELECT
      data: "", //enviamos opcion 4 para que haga un SELECT
      dataSrc: "",
    },
    columns: [
      { data: "ID" },
      { data: "IDObraSocial" },
      { data: "NombreFarmacia" },
      { data: "Fecha" },
      { data: "Periodo" },
      { data: "Estado" },
      { data: "Total" },
    ],
    //SUMAR COLUMNA 6 y escribir resultado en #total
    drawCallback: function () {
      var sum = $("#tablaDetalleOs").DataTable().column(6).data().sum();
      $("#total").html(sum);
    },
  });

  $("#tablaDetalleOs_filter").hide(); // Ocultar el buscador por defecto, "idtabla"_filter

  //buscador por todo
  $("#txtSearch").on("keyup", function () {
    $("#tablaDetalleOs")
      .DataTable()
      .search($("#txtSearch").val(), false, true)
      .draw();
  });

  //buscador por columna
  $("#txtSearchPeriodo").on("keyup", function () {
    tablaDetalleOs.columns(4).search(this.value).draw();
  });

  //buscador por columna
  $("#txtSearchNombre").on("keyup", function () {
    tablaDetalleOs.columns(2).search(this.value).draw();
  });
});
