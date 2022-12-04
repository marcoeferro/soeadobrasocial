$(document).ready(function () {
  
  $(".js-example-basic-single").select2();

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

  var idos = document.getElementById("idOS").value;
  var idperiod = document.getElementById("idPeriod").value;
  var idfarmacia = document.getElementById("idFarmacia").value;

  let opcion = 1;

  tablaPresentaciones = $("#tablaPresentaciones").DataTable({
    language: {
      url: "" + ruta + "api/Spanish.json",
    },
    ajax: {
      url: "api/getPresentaciones.php",
      method: "POST", //usamos el metodo POST
      data: {
        idos: idos,
        idperiod: idperiod,
        idfarmacia: idfarmacia,
        opcion: opcion,
      }, //enviamos opcion 4 para que haga un SELECT
      //"data":"", //enviamos opcion 4 para que haga un SELECT
      dataSrc: "",
    },
    responsive: true,
    columns: [
      { data: "fecha" },
      { data: "recetas" },
      { data: "recaudado",
        "render": DataTable.render.number('.', ',', 2, ' $ ', ''),
        "className": 'righted-text', 
      },
        
      { data: "aCargoOS", 
        "render": DataTable.render.number('.', ',', 2, ' $ ', ''),
        "className": 'righted-text', 
      },
      { data: "bonificacion" ,
        "render": DataTable.render.number('.', ',', 2, ' $ ', ''),
        "className": 'righted-text',
      },
      { data: "observaciones" },
      {
        data: "aCargoOS",

        fnCreatedCell: function (nTd, sData, oData, iRow, iCol) {
          $(nTd).html(
            "<button class='btn-circle' name='borrar" +
              oData.id +
              "' id='borrar" +
              oData.id +
              "' value='" +
              oData.id +
              "' onclick='deleteRow(" +
              oData.id +
              ")' ><i class='fa-solid fa-trash'></i></button>"
          );
        },
      },
    ],
    columnDefs: [
      { orderable: false, targets: [0, 1, 2, 3, 4, 5] },
      { orderable: true, targets: [] },
    ],
  });

  //Insertar nuevos datos
  $("#cargarDatos").submit(function (e) {
    e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página

    opcion = 1;

    var formData = new FormData(document.getElementById("cargarDatos"));
    formData.append("opcion", opcion);

    if(document.getElementById("cantidadRecetas").value != "" && document.getElementById("totalPresentado").value != "" && document.getElementById("totalOs").value != "" ){

      //ACA AGREGAR EL INSERT DEL DATO
      $.ajax({
        url: "api/saveData.php",
        type: "POST",
        datatype: "json",
        data: formData,
        contentType: false,
        cache: false,
        processData: false,
        success: function (data) {
          modalTitle.innerHTML = "Datos guardados";
          modalContent.innerHTML = ("Los datos se guardaron correctamente");
          modal.show();
          tablaPresentaciones.ajax.reload(null, false); //Recargar Datatable

          //limpiar inputs
          document.getElementById("cantidadRecetas").value = null;
          document.getElementById("totalPresentado").value = null;
          document.getElementById("totalOs").value = null;
          document.getElementById("totalBonificacion").value = null;
          document.getElementById("observaciones").value = null;

          //document.getElementById("cantidadRecetas").value = "";
          //document.getElementById("totalPresentado").value = "";
          //document.getElementById("totalOs").value = "";

          reloadMontos();
        },
      });

    }else{
      modalTitle.innerHTML = "Datos no guardados";
      modalContent.innerHTML = ("Para guardar los datos debe llenar todos los campos de manera correcta.");
      modal.show();
    }

    //tablaPresentaciones.ajax.reload(null, false); //Recargar tabla sin recargar pagina
  });
});

function deleteRow(idReceta) {
  //alert("Esta seguro que desea eliminar esta carga? id="+id);

  let opcion = 2;

  if (
    confirm("¿Esta seguro que desea eliminar esta carga? ") == true
  ) {
    //alert("Entra al ACEPTAR");

    $.ajax({
      url: "api/saveData.php",
      type: "POST",
      datatype: "json",
      data: { idReceta: idReceta, opcion: opcion },
      success: function (data) {
        modalTitle.innerHTML = "Datos eliminados";
        modalContent.innerHTML = ("Los datos se eliminaron correctamente");
        modal.show();
        tablaPresentaciones.ajax.reload(null, false); //Recargar Datatable
        reloadMontos();
      },
    });
  } else {
    //alert("Entra al CANCELAR");
  }
}

function reloadMontos() {
  let opcion = 2;

  var idos = document.getElementById("idOS").value;
  var idperiod = document.getElementById("idPeriod").value;
  var idfarmacia = document.getElementById("idFarmacia").value;

  $.ajax({
    url: "api/getPresentaciones.php",
    type: "POST",
    datatype: "json",
    data: {
      idos: idos,
      idperiod: idperiod,
      idfarmacia: idfarmacia,
      opcion: opcion,
    },
    success: function (data) {

      data = JSON.parse(data);

      var formatNumber = new Intl.NumberFormat('de-DE');

      document.getElementById("resultadoRecetas").innerHTML = data["recetas"];

      document.getElementById("resultadoACargoOS").innerHTML = formatNumber.format(data["aCargoOS"]);

      document.getElementById("resultadoTotales").innerHTML = formatNumber.format(data["recaudado"]);
    },
  });
}

var modal = new bootstrap.Modal(document.getElementById("modalCenprofar"), {
  keyboard: false,
});
