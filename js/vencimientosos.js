$(document).ready(function () {
  var modal = new bootstrap.Modal(document.getElementById("modalCenprofar"), {
    keyboard: false,
  });

  var modalTitle = document.getElementById("modalTitle");
  var modalContent = document.getElementById("modalContent");
  var btnCerrar = document.getElementById("btnCerrarModal");
  var btnCerrarX = document.getElementById("btnCerrarModalX");

  btnCerrar.addEventListener("click", function () {
    modalTitle.innerHTML = "";
    modalContent.innerHTML = "";
    modal.hide();
  });

  btnCerrarX.addEventListener("click", function () {
    modalTitle.innerHTML = "";
    modalContent.innerHTML = "";
    modal.hide();
  });

  var ruta = window.location.pathname.match("(.*/).*")[1];

  var tablaVencimientos = $("#tablaVencimientos").DataTable({
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
      var sum = $("#tablaVencimientos").DataTable().column(6).data().sum();
      $("#total").html(sum);
    },
  });

  $("#tablaVencimientos_filter").hide(); // Ocultar el buscador por defecto, "idtabla"_filter
});
