$(document).ready(function() {
    //let idCliente = document.getElementById('clienteSeleccionado').value;

    tablaPrestadores =  $('#tablaOrdenes').DataTable( {
        ordering: false,
        searching: true,
        paging: true,
        ajax: {
            url: "acciones/ver-ordenes.php",
            method: "POST", //usamos el metodo POST
            data: {
                //idCliente: idCliente
            },
            dataSrc: "",
          },
        //ajax: '../jsDataTable/totalp.php',
        language: {
            url: 'js/Spanish.json',
            searchPlaceholder: "Buscador"
        },
        //responsive: true,
        //scrollY: 200,
        //scroller: {
        //    loadingIndicator: true
        //},
        columns: [
            { data: "datosafiliado" },
            { data: "numeroafiliado" },
            { data: "fechapedida" },
            { data: "estado" },
            { data: "idorden" , data: "cancelacion",
            'fnCreatedCell': function (nTd, sData, oData, iRow, iCol) {
                if(oData['cancelacion']==1){
                    $(nTd).html("<div style='display:inline-flex;'><form action='./acciones/marcar-pago.php?valor=1' method='post'id='form_eliminar_" + oData['idorden'] + "'><input type='hidden' id='chequealo' name='chequealo' value='"+oData['idorden']+"'/><button type='button' name='Eliminar' Value='Eliminar' class='btn btn-danger' style='border-radius:15px;height:48px;' onclick=pagada(" + oData['idorden'] + ")>No abonado</button></form></div>"); 
                }else{
                    $(nTd).html("<div style='display:inline-flex;'><form action='./acciones/marcar-pago.php?valor=0' method='post'id='form_eliminar_" + oData['idorden'] + "'><input type='hidden' id='chequealo' name='chequealo' value='"+oData['idorden']+"'/><button type='button' name='Eliminar' Value='Eliminar' class='btn btn-success' style='border-radius:15px;height:48px;' onclick=noPagada(" + oData['idorden'] + ")>Abonado</button></form></div>");
                } } }
        ],
        columnDefs: [
            //{"className": "text-center", "targets": "_all"},
            { "width": "25%", "targets": 0 },
            { "width": "20%", "targets": 1 },
            { "width": "20%", "targets": 2 },
            { "width": "20%", "targets": 3 }
        ],
        drawCallback: function( settings ) {

            $('#tablaOrdenes').css('width','100%').css('margin-left','0px');
            $('#tablaOrdenes_wrapper').addClass('content row').css('width','100%').css('margin-left','0px').css('margin-bottom', '45px');
            $('#tablaOrdenes_filter').addClass('content col-lg-6').css('width', '90%');
            $('#tablaOrdenes_filter label').css('width', '100%');
            $('#tablaOrdenes_filter input').addClass('col-lg-12 form-control').css('width', '100%').css
            ('margin-bottom', '10px');
            $('#tablaOrdenes_length').addClass('content col-lg-6').css('width','10%');
            //$('#tablaOrdenes_length label').addClass('row').css('width','100%');;
            $('#tablaOrdenes_length select').addClass('col-lg-6 form-control');

            $('#tablaOrdenes_info').addClass('col-lg-6').css('color','black');
            $('#tablaOrdenes_paginate').addClass('col-lg-6 btn').css('position', 'absolute').css('bottom', '2px').css('right', '2px');

            $('.paginate_button').addClass('btn');
            $('a.current').addClass('content');
            $('#tablaOrdenes_info').addClass('form-group').css('position', 'absolute').css('color', 'grey').css('bottom', '20px');
            
        }
        

    } );
} );