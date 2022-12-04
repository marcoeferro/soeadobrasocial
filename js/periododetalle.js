$(document).ready(function() {

    $('.js-example-basic-single').select2();

    var ruta = window.location.pathname.match('(.*\/).*')[1];

    var idos = document.getElementById("idOS").value; 
    var idperiod = document.getElementById("idPeriod").value;
    var idfarmacia = document.getElementById("idFarmacia").value;

    let opcion = 1;

    
    tablaPresentaciones = $('#tablaRecetas').DataTable({ 
        "language": {
            "url": ""+ruta+"api/Spanish.json"
        },
        "ajax":{            
        "url": "api/getPresentaciones.php", 
        "method": 'POST', //usamos el metodo POST
        "data":{idos:idos, idperiod:idperiod, idfarmacia:idfarmacia, opcion:opcion}, //enviamos opcion 4 para que haga un SELECT
        //"data":"", //enviamos opcion 4 para que haga un SELECT
        "dataSrc":""
        },
        "responsive": true,
        "columns":[
            {"data": "fecha" , 
            
            },
            {"data": "recetas" , 
            
            },
            {"data": "recaudado" , 
                "render": DataTable.render.number('.', ',', 2, ' $ ', ''),
                "className": 'righted-text',
            
            },
            {"data": "aCargoOS" , 
                "render": DataTable.render.number('.', ',', 2, ' $ ', ''),
                "className": 'righted-text',
            
            },
            {"data": "bonificacion",
                "render": DataTable.render.number('.', ',', 2, ' $ ', ''),
                "className": 'righted-text',
            },
            {"data": "observaciones"}
        ],
        "columnDefs": [
            { "orderable": false, "targets": [0, 1, 2, 3, 4, 5] },
            { "orderable": true, "targets": [] }
        ],
    }); 



    //buscador por todo
    $('#txtSearch').on('keyup', function() {
        $('#tablaPeriodos')
        .DataTable()
        .search($('#txtSearch').val(), false, true)
        .draw();
    });


    //buscador por columna -SELECT
    $('#selectos').on( 'change', function () {
        tablaPeriodos
        .columns( 0 )
        .search( this.value )
        .draw();
    } );



    //buscador por columna
    $('#txtSearchPeriodo').on( 'keyup', function () {
        tablaPeriodos
        .columns( 1 )
        .search( this.value )
        .draw();
    } );

    //buscador por columna
    $('#txtSearchAnio').on( 'keyup', function () {
        tablaPeriodos
        .columns( 2 )
        .search( this.value )
        .draw();
    } );

    //Verificar si los valores coinciden, si no coinciden resaltarlos, si no hay asignarles el texto 'pendiente'

    var mensaje = document.getElementById("texto-mensaje").innerHTML;
    var totalLocal = document.getElementById("resultadoTotal-local").innerHTML;
    var totalOSLocal = document.getElementById("resultadoACargoOS-local").innerHTML;
    var recetasLocal = document.getElementById("recetas-local").innerHTML;

    var totalWeb = document.getElementById("resultadoTotal-web").innerHTML;
    var totalOSWeb = document.getElementById("resultadoACargoOS-web").innerHTML;
    var recetasWeb = document.getElementById("recetas-web").innerHTML;

    if(mensaje === ""){
        document.getElementById("texto-mensaje").innerHTML = "No hay ningún mensaje en este momento, esto se debe a que CENPROFAR no ha revisado este periodo aún.";
    }

    if(totalLocal === "$"){
        document.getElementById("resultadoTotal-local").innerHTML = "Pendiente";
    } else if(totalLocal !== totalWeb){
        document.getElementById("total-web-title").className += " status2-text";
        document.getElementById("total-web-circle").className += " status2";
        document.getElementById("resultadoTotal-web").className += " status2-text";
    }

    if(totalOSLocal === "$"){
        document.getElementById("resultadoACargoOS-local").innerHTML = "Pendiente";
    } else if(totalOSLocal !== totalOSWeb){
        document.getElementById("totalOS-web-title").className += " status2-text";
        document.getElementById("totalOS-web-circle").className += " status2";
        document.getElementById("resultadoACargoOS-web").className += " status2-text";
    }

    if(recetasLocal === ""){
        document.getElementById("recetas-local").innerHTML = "Pendiente";
    } else if(recetasLocal !== recetasWeb){
        document.getElementById("recetas-web-title").className += " status2-text";
        document.getElementById("recetas-web-circle").className += " status2";
        document.getElementById("recetas-web").className += " status2-text";
    }

});

/*

window.onbeforeunload = function(e) {
    console.log("hola");

    let idos = document.getElementById("idOS").value;
    let idperiod = document.getElementById("idPeriod").value;

    localStorage.setItem('datos', JSON.stringify({idOS:idos, idPeriod:idperiod}));

    //localStorage.setItem("idOS", idos);
    //localStorage.getItem("lastname");

};

*/
   

/*

   window.addEventListener('beforeunload', (event) => {
    event.returnValue = 'Are you sure you want to leave?';
  });

  */