$(document).ready(function() {
    //let idCliente = document.getElementById('clienteSeleccionado').value;

    tablaPrestadores =  $('#tablaAfiliados').DataTable( {
        ordering: false,
        searching: true,
        paging: true,
        ajax: {
            url: "acciones/ver-familiares.php",
            method: "POST", //usamos el metodo POST
            data: {
                //idCliente: idCliente
            },
            dataSrc: "",
          },
        //ajax: '../jsDataTable/totalp.php',
        language: {
            url: 'js/Spanish.json',
            search: "- ",
            searchPlaceholder: "Buscador"
        },
        //responsive: true,
        //scrollY: 200,
        //scroller: {
        //    loadingIndicator: true
        //},
        columns: [
            { data: "datosafiliado" },
            { data: "nombrecompleto"},
            { data: "dni" },
            { data: "fecha_nacimiento" },
            { data: "id_afiliado" ,
                'fnCreatedCell': function (nTd, sData, oData, iRow, iCol) {
                    $(nTd).html("<div class='row'><div class='col-lg-6'><form action='./modificacion-familiar.php' method='post'><input type='hidden' name='id-modificar' value='" + oData['id_afiliado'] + "' /><input class='btn btn-secondary' style='margin-right:2px;' type='submit' Value='Modificar'></form></div><div class='col-lg-6'><form action='./acciones/eliminar-afiliado.php' method='post' id='form_eliminar_" + oData['id_afiliado'] + "'><input type='hidden' name='vienedelform' value='" + oData['id_afiliado'] + "' /><button type='button' name='Eliminar' Value='Eliminar' class='btn btn-danger' style='margin-right:2px;'  onclick=alerta(" + oData['id_afiliado'] + ")>Eliminar</button></form></div></div>");
                }
            }
        ],
        columnDefs: [
            //{"className": "text-center", "targets": "_all"},
            { "width": "13%", "targets": 0 },
            { "width": "22%", "targets": 1 },
            { "width": "15%", "targets": 2 },
            { "width": "15%", "targets": 3 },
            { "width": "13%", "targets": 4 }
        ],
        drawCallback: function( settings ) {

            $('#tablaAfiliados').css('width','100%').css('margin-left','0px');
            $('#tablaAfiliados_wrapper').addClass('content row').css('width','100%').css('margin-left','0px').css('margin-bottom', '45px');
            $('#tablaAfiliados_filter').addClass('content col-lg-6').css('width', '90%');
            $('#tablaAfiliados_filter label').css('width', '100%');
            $('#tablaAfiliados_filter input').addClass('col-lg-12 form-control').css('width', '100%').css('margin-bottom', '10px');;
            $('#tablaAfiliados_length').addClass('content col-lg-6').css('width','10%');
            //$('#tablaAfiliados_length label').addClass('row').css('width','100%');;
            $('#tablaAfiliados_length select').addClass('col-lg-6 form-control');

            $('#tablaAfiliados_info').addClass('col-lg-6').css('color','black');
            $('#tablaAfiliados_paginate').addClass('col-lg-6 btn').css('position', 'absolute').css('bottom', '2px').css('right', '2px');

            $('.paginate_button').addClass('btn');
            $('a.current').addClass('content');
            $('#tablaAfiliados_info').addClass('form-group').css('position', 'absolute').css('color', 'grey').css('bottom', '20px');
            
        }
        

    } );
} );