rowParents = document.querySelectorAll(".row-parent");

rowParents.forEach((parent) => {
  parent.addEventListener("click", (e) => {
    rowChilds = document.querySelector(
      "[data-parent='" + parent.dataset.id + "']"
    );
    rowChilds.classList.toggle("hidden-childs");
    parent.querySelector(".fa-caret-right").classList.toggle("rotated");
  });
});

$(document).ready(function () {
  $('.js-example-basic-single').select2();

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
});
