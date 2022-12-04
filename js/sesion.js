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

  //FUNCION CERRAR SESION

  (function ($) {
    $.fn.cerrarSesion = function () {
      opcion = 2;

      $.ajax({
        url: "api/getLogin.php",
        type: "POST",
        datatype: "json",
        data: { opcion: opcion },
        success: function (data) {
          //data = JSON.parse(data);
          
          if (data) {
            //alert("Usuario o contraseña incorrectos");
            window.location.href = "index.php";
          } else {
            //window.location.href = "home.php";
            modalTitle.innerHTML = "Error";
            modalContent.innerHTML = "Error al cerrar sesión";
            modal.show();
          }
        },
        error: function (data) {
          console.log("An error occurred.");
        },
      });
    };
  })(jQuery);

  $("#cerrarSesion").click(function () {
    $("#cerrarSesion").cerrarSesion();
  });

  //change pharmacy
  $("#selectFarmacia").change(function () {
    var idFarmacia = $("#selectFarmacia").val();

    $.ajax({
      url: "api/changeFarmacia.php",
      type: "POST",
      datatype: "json",
      data: {idFarmacia: idFarmacia },
      success: function (data) {
        if (data) {
          window.location.href = "";
        } else {
          modalTitle.innerHTML = "Error";
          modalContent.innerHTML = "Error al cambiar de farmacia";
          modal.show();
        }
      },
      error: function (data) {
        console.log("An error occurred.");
      },
    });
  });
});
