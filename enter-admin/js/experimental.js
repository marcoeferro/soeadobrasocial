$(document).ready(function() {
    //let idCliente = document.getElementById('clienteSeleccionado').value;

    const searchBar = document.querySelector('#search');
    searchBar.addEventListener('keyup',searchUser);

    function searchUser(event){
        const text = event.target.value.toLowerCase();

    }
    
    tablaPrestadores =  $('#tablaPrestadores').DataTable( {
        ordering: false,
        searching: true,
        paging: true,
        ajax: {
            url: "./enter-admin/acciones/ver-prestadores.php",
            method: "POST", //usamos el metodo POST
            data: {
                //idCliente: idCliente
            },
            dataSrc: "",
          },
        //ajax: '../jsDataTable/totalp.php',
        language: {
            url: './enter-admin/js/Spanish.json',
            search: "- ",
            searchPlaceholder: "Buscador"
        },
        //responsive: true,
        //scrollY: 200,
        //scroller: {
        //    loadingIndicator: true
        //},
        columns: [
            { data: "nombreEspecialidad" },
            { data: "nombrePrestador",
                'fnCreatedCell': function (nTd, sData, oData, iRow, iCol) {
                    $(nTd).html("" + oData['nombrePrestador'] + " " + oData['ap'] + "");
                }
            },
            { data: "matri" },
            { data: "nombreCentro" },
            { data: "telCentro" }
        ],
        columnDefs: [
            //{"className": "text-center", "targets": "_all"},
            { "width": "12%", "targets": 0 },
            { "width": "20%", "targets": 1 },
            { "width": "10%", "targets": 2 },
            { "width": "20%", "targets": 3 },
            { "width": "20%", "targets": 4 }
        ],
        drawCallback: function( settings ) {

            $('#tablaPrestadores').css('width','100%').css('margin-left','0px');
            $('#tablaPrestadores_wrapper').addClass('content row').css('width','100%').css('margin-left','0px').css('margin-bottom', '45px');
            $('#tablaPrestadores_filter').addClass('content col-lg-6').css('width', '90%');
            $('#tablaPrestadores_filter label').css('width', '100%');
            $('#tablaPrestadores_filter input').addClass('col-lg-12 form-control').css('width', '100%').css('margin-bottom', '10px');
            $('#tablaPrestadores_length').addClass('content col-lg-6').css('width','10%');
            //$('#tablaPrestadores_length label').addClass('row').css('width','100%');;
            $('#tablaPrestadores_length select').addClass('col-lg-6 form-control');

            $('#tablaPrestadores_info').addClass('col-lg-6').css('color','black');
            $('#tablaPrestadores_paginate').addClass('col-lg-6 btn').css('position', 'absolute').css('bottom', '2px').css('right', '2px');

            $('.paginate_button').addClass('btn ');
            $('a.current').addClass('content');
            $('#tablaPrestadores_info').addClass('form-group').css('position', 'absolute').css('color', 'grey').css('bottom', '20px');
            
        }
        

    } );
} );