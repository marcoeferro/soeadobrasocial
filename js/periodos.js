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
  $(".js-example-basic-single").select2();

  var ruta = window.location.pathname.match("(.*/).*")[1];

  //var idObraSocial = document.getElementById('osocial').value;
  var idFarmacia = document.getElementById("idFarmacia").value;

  var tablaPeriodos = $("#tablaPeriodos").DataTable({
    language: {
      url: "" + ruta + "api/Spanish.json",
    },
    ajax: {
      url: "api/getPeriodos.php",
      method: "POST", //usamos el metodo POST
      //"data":{opcion:opcion}, //enviamos opcion 4 para que haga un SELECT
      //"data":{idObraSocial:idObraSocial}, //enviamos opcion 4 para que haga un SELECT
      data: { idFarmacia: idFarmacia }, //enviamos opcion 4 para que haga un SELECT
      dataSrc: "",
    },
    responsive: true,
    columns: [
      { data: "obraSocial.Nombre", "className": "text-overlow-hidden"},
      { data: "periodo.periodo" , "className": "text-overlow-hidden"},
      { data: "periodo.fechaLimite" , "className": "text-overlow-hidden"},
      { data: "presentacion_final.recetas" },
      { data: "presentacion_final.recaudado" ,
        "render": DataTable.render.number('.', ',', 2, ' $ ', ''),
        "className": 'righted-text',
      },
      { data: "presentacion_final.aCargoOS" ,
        "render": DataTable.render.number('.', ',', 2, ' $ ', ''),
        "className": 'righted-text',
      },
      {
        data: "status",

        fnCreatedCell: function (nTd, sData, oData, iRow, iCol) {
          $(nTd).html(
            "<button class='button-status size-10  status" +
              oData.status +
              " status" +
              oData.status +
              "-content' name='estado" +
              oData.periodo.id +
              "' id='estado" +
              oData.periodo.id +
              "' value='" +
              oData.status +
              "'  ></button>"
          );
        },
      },
      {
        data: "presentacion_final.aCargoOS",

        fnCreatedCell: function (nTd, sData, oData, iRow, iCol) {
          $(nTd).html(
            `<div class='align-right'>
                <button class='btn-circle btnDetalle' name='borrar${oData.periodo.id}' id='borrar${oData.periodo.id} value='${oData.periodo.id}'>
                  <i class='fa-solid fa-eye'></i>
                </button>` +
              (oData.pagos == 1
                ? `
                  <button class='btn-circle primary-regular btnVerPagos ms-2'>
                    <i class="fa-solid fa-dollar-sign"></i>
                  </button></div>
                `
                : "</div>")
          );
        },
      },
    ],
    columnDefs: [
      { orderable: true, targets: [0, 2, 6] },
      { orderable: false, targets: [1, 3, 4, 5, 7] },
      { width: '20%', targets: 0 },
      { width: '15%', targets: 1 },
      { width: '12%', targets: 2 },
      { width: '8%', targets: 3 },
      { width: '10%', targets: 4 },
      { width: '10%', targets: 5 },
      { width: '10%', targets: 6 },
      { width: '10%', targets: 7 },
    ],
    order: [[2, "desc"]],
    //"dom": 'lrtip', //ocultar searching,
    drawCallback: function () {
      //SUMAR COLUMNA 6 y escribir resultado en #total
      //var sum = $('#tablaPresentaciones').DataTable().column(6).data().sum();
      //$('#total').html(sum);

      $("#tablaPeriodos_filter").hide(); // Ocultar el buscador por defecto, "idtabla"_filter
      
      ellipsed = document.querySelectorAll(".text-overlow-hidden")
      ellipsed.forEach(function(element) {
        element.setAttribute("title", `${element.innerText}`);
      });
    },
  });

  //buscador por todo
  $("#txtSearch").on("keyup", function () {
    $("#tablaPeriodos")
      .DataTable()
      .search($("#txtSearch").val(), false, true)
      .draw();
  });

  //buscador por columna -SELECT
  $("#selectos").on("change", function () {
    tablaPeriodos.columns(0).search(this.value).draw();
  });

  //buscador por columna
  $("#txtSearchPeriodo").on("keyup", function () {
    tablaPeriodos.columns(1).search(this.value).draw();
  });

  //buscador por columna
  $("#txtSearchAnio").on("keyup", function () {
    tablaPeriodos.columns(2).search(this.value).draw();
  });

  $(document).on("click", ".btnDetalle", function () {
    fila = $(this).closest("tr");
    IdOSdetalle = tablaPeriodos.row(fila).data().obraSocial.ID;
    IdPeriododetalle = tablaPeriodos.row(fila).data().periodo.id;

    //CREO FORM para enviar datos
    var form = document.createElement("form");
    form.setAttribute("method", "post");
    //form.setAttribute("action", "submit.php");

    document.body.appendChild(form);

    //idperiodo --- idobrasocial

    var idObraSocialdet = document.createElement("input");
    idObraSocialdet.setAttribute("type", "hidden");
    idObraSocialdet.setAttribute("name", "idObraSocial");
    idObraSocialdet.value = IdOSdetalle;

    var idPeriododet = document.createElement("input");
    idPeriododet.setAttribute("type", "hidden");
    idPeriododet.setAttribute("name", "idPeriodo");
    idPeriododet.value = IdPeriododetalle;

    form.appendChild(idObraSocialdet);
    form.appendChild(idPeriododet);

    form.setAttribute("action", "periododetalle.php");
    form.submit();
  });

  $(document).on("click", ".btnVerPagos", function () {
    fila = $(this).closest("tr");
    IdOSdetalle = tablaPeriodos.row(fila).data().obraSocial.ID;
    IdPeriododetalle = tablaPeriodos.row(fila).data().periodo.id;
    OSname = tablaPeriodos.row(fila).data().obraSocial.Nombre;
    PeriodoName = tablaPeriodos.row(fila).data().periodo.periodo;

    //CREO FORM para enviar datos
    var form = document.createElement("form");
    form.setAttribute("method", "post");
    //form.setAttribute("action", "submit.php");

    document.body.appendChild(form);

    //idperiodo --- idobrasocial

    var idObraSocialdet = document.createElement("input");
    idObraSocialdet.setAttribute("type", "hidden");
    idObraSocialdet.setAttribute("name", "idObraSocial");
    idObraSocialdet.value = IdOSdetalle;

    var idPeriododet = document.createElement("input");
    idPeriododet.setAttribute("type", "hidden");
    idPeriododet.setAttribute("name", "idPeriodo");
    idPeriododet.value = IdPeriododetalle;

    var ObraSocial = document.createElement("input");
    ObraSocial.setAttribute("type", "hidden");
    ObraSocial.setAttribute("name", "ObraSocial");
    ObraSocial.value = OSname;

    var Periodo = document.createElement("input");
    Periodo.setAttribute("type", "hidden");
    Periodo.setAttribute("name", "Periodo");
    Periodo.value = PeriodoName;

    form.appendChild(idObraSocialdet);
    form.appendChild(idPeriododet);
    form.appendChild(ObraSocial);
    form.appendChild(Periodo);

    form.setAttribute("action", "pagos.php");
    form.submit();
  });

  /*let params = new URLSearchParams(location.search);
  var contract = params.get('idObraSocial');
  console.log(contract);
  */
  
});


//window.onpopstate = function() {alert(1);}; 
history.pushState({}, '');


