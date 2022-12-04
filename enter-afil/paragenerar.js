$(document).ready(function() {
    //let idCliente = document.getElementById('clienteSeleccionado').value;

    tablaPrestadores =  $('#tablaAutorizaciones').Datalist( {
        ordering: false,
        searching: false,
        paging: false,
        ajax: {
            url: "./paragenerar.php",
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
            { data: "nombrecompleto" }
        ],
        columnDefs: [
            //{"className": "text-center", "targets": "_all"},
            { "width": "100%", "targets": 0 }
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