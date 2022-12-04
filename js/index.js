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

  document.getElementById("ayuda-label").addEventListener("click", function () {
    modalTitle.innerHTML = "Ayuda";
    modalContent.innerHTML = "Si tiene dificultades para ingresar a la plataforma comuníquese con SOEAD.";
    modal.show();
  });

  $("#formLogin").attr("action", "home.php");

  $("#formLogin").submit(function (e) {
    e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página

    $('#page-loader').fadeIn(500);

    //$('#formLogin').attr('action', 'home.php');
    //$( "#formLogin" ).submit();

    var formData = new FormData(document.getElementById("formLogin"));
    formData.append("opcion", 1);

    $.ajax({
      url: "api/getLogin.php",
      type: "POST",
      datatype: "json",
      data: formData,
      contentType: false,
      cache: false,
      processData: false,
      success: function (data) {
        data = JSON.parse(data);
        
        if (data == false) {
          $('#page-loader').fadeOut(500);
          modalTitle.innerHTML = "Error";
          modalContent.innerHTML = "Usuario o contraseña incorrectos";
          modal.show(); 
        } else {
          window.location.href = "home.php";
        }
      },
      error: function (data) {
        console.log("An error occurred.");
      },
    });
  });
});
