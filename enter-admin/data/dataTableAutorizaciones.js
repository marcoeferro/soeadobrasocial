$(document).ready(function() {
    //let idCliente = document.getElementById('clienteSeleccionado').value;

    //

    tablaPrestadores =  $('#tablaAutorizaciones').DataTable( {
        //ordering: false,
        searching: false,
        paging: false,
        //order:[[2,'desc']],
        ajax: {
            url: "data/autorizaciones.php",
            method: "POST", //usamos el metodo POST
            data: {
                //idCliente: idCliente
            },
            dataSrc: "",
          },
        //ajax: '../jsDataTable/totalp.php',
        language: {
            url: './Spanish.json',
            search: "- ",
            searchPlaceholder: "Buscador"
        },
        //responsive: true,
        //scrollY: 200,
        //scroller: {
        //    loadingIndicator: true
        //},
        columns: [
            { data: "names" },
            { data: "nbre_afil"},
            { data: "fecha1" },
            { data: "prestador" },
            { data: "estado", data: "idAutorizacion",
            'fnCreatedCell': function (nTd, sData, oData, iRow, iCol) {
                if(oData['estado']=='Pendiente'){ 
                $(nTd).html("<div style='display:inline-flex;'><form action='./acciones/autorizar.php' method='post' id='form_eliminar_aprobar_" + oData['idAutorizacion'] + "'><input type='hidden' name='vienedelform' value='"+oData['idAutorizacion']+"' /><button  type='button' name='Eliminar' Value='Eliminar' class='btn btn-success' style='border-radius:15px;height:48px;margin-right:2px;' onclick=aprobarModal(" + oData['idAutorizacion'] + ")>Aprobar</button></form><form action='./acciones/denegar.php' method='post' id='form_eliminar_denegar_" + oData['idAutorizacion'] + "'><input type='hidden' name='vienedelform' value='"+oData['idAutorizacion']+"'/><button  type='button' name='Eliminar' Value='Eliminar' class='btn btn-danger' style='border-radius:15px;height:48px;margin-left:2px;' onclick=denegarModal(" + oData['idAutorizacion'] + ")>Denegar</button></form></div>");
            } else {
                $(nTd).html(oData['estado']);
            } } }
        ],
        columnDefs: [
            //{"className": "text-center", "targets": "_all"},
            { "width": "20%", "targets": 0 },
            { "width": "20%", "targets": 1 },
            { "width": "20%", "targets": 2 },
            { "width": "20%", "targets": 3 },
            { "width": "20%", "targets": 4 }
        ],
        drawCallback: function( settings ) {

            $('#tablaAutorizaciones').css('width','100%').css('margin-left','0px');
            $('#tablaAutorizaciones_wrapper').addClass('content row').css('width','100%').css('margin-left','0px').css('margin-bottom', '45px');
            $('#tablaAutorizaciones_filter').addClass('content col-lg-6').css('width', '90%');
            $('#tablaAutorizaciones_filter label').css('width', '100%');
            $('#tablaAutorizaciones_filter input').addClass('col-lg-12 form-control').css('width', '100%').css('margin-bottom', '10px');
            $('#tablaAutorizaciones_length').addClass('content col-lg-6').css('width','10%');
            //$('#tablaAutorizaciones_length label').addClass('row').css('width','100%');;
            $('#tablaAutorizaciones_length select').addClass('col-lg-6 form-control');

            $('#tablaAutorizaciones_info').addClass('col-lg-6').css('color','black');
            $('#tablaAutorizaciones_paginate').addClass('col-lg-6 btn').css('position', 'absolute').css('bottom', '2px').css('right', '2px');

            $('.paginate_button').addClass('btn ');
            $('a.current').addClass('content');
            $('#tablaAutorizaciones_info').addClass('form-group').css('position', 'absolute').css('color', 'grey').css('bottom', '20px');
            
        }
        

    } );
} );