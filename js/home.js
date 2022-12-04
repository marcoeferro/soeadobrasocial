$(document).ready(function () {

  /*modal*/
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
  /*fin modal*/

  $(".js-example-basic-single").select2();

  $("#historial").click(function () {
    //$('#obrasocial').attr('action', 'periodos.php');
    //$( "#obrasocial" ).submit();
    window.location.href = "periodos.php";
  });

  $("#presentacion").click(function (e) {
    e.preventDefault();

    let obraSocial = document.getElementById("osocial").value;

    if (obraSocial != "") {
      $.ajax({
        url: "api/getCurrent.php",
        type: "POST",
        datatype: "json",
        data: { obraSocial: obraSocial },
        success: function (data) {
          data = JSON.parse(data);

          if (data.id != null) {
            $("#obrasocial").submit();
          } else {
            modalTitle.innerHTML = "Obra Social sin período Activo";
            modalContent.innerHTML =
              "No se ha encontrado un período activo para la obra social seleccionada. Por favor, seleccione otra obra social.";
            modal.show();
          }
        },
      });

      $("#obrasocial").attr("action", "cargarpresentacion.php");
      //$( "#obrasocial" ).submit();
    } else {
      modalTitle.innerHTML = "Seleccione una obra social";
      modalContent.innerHTML =
        "Para cargar una obra social debe seleccionar una de la lista.";
      modal.show();
    }
  });

  //obtener vencimientos por mes
  /*function getVencimientos(){

    let opcion = 0;

    $.ajax({
      url: "api/getForMonth.php",
      type: "POST",
      datatype: "json",
      data: { opcion: opcion },
      success: function (data) {
        data = JSON.parse(data);

        console.log(data[0].fechaLimite);
        
      },
    });

  }*/

  //getVencimientos();

});

//window.onpopstate = function() {alert(1);}; 
history.pushState({}, '');