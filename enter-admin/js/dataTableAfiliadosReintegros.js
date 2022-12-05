$(document).ready(function() {
    //let idCliente = document.getElementById('clienteSeleccionado').value;

    tablaPrestadores =  $('#tablaAfiliados').DataTable( {
        ordering: false,
        searching: true,
        paging: true,
        ajax: {
            url: "acciones/ver-afiliados.php",
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
            { data: "id_afiliado" , data:"nro_afiliado",
                'fnCreatedCell': function (nTd, sData, oData, iRow, iCol) {
                    $(nTd).html(`
                        <form method="post" action="./acciones/reintegros.php"  class="form-group" enctype = "multipart/form-data">
                            <div class="container">
                                <div class="row row-cols-auto">
                                
                                    <div class="col-md-6">
                                        <input type='hidden' name='emailAfil' value=${oData['email']}/>
                                        <input type='hidden' name='nombrecompleto' value=${oData['nombrecompleto'].replaceAll(' ','-')}/>
                                        <input required type="file" class="btn" name="archivo" id="archivo" accept="application/pdf">                                    
                                    </div>
                                    <div class="col">
                                        <button class="login-button" type="submit" id="cargar">Enviar Email</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        
                    `);
                }
            }
        ],
        columnDefs: [
            //{"className": "text-center", "targets": "_all"},
            { "width": "12%", "targets": 0 },
            { "width": "18%", "targets": 1 },
            { "width": "15%", "targets": 2 },
            { "width": "13%", "targets": 3 },
            { "width": "22%", "targets": 4 }
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