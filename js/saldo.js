$(document).ready(function() {

    $('.js-example-basic-single').select2();

    var formatNumber = new Intl.NumberFormat('de-DE');

    var ruta = window.location.pathname.match('(.*\/).*')[1];

    var idfarmacia = document.getElementById("idFarmacia").value;

    let opcion = 1;

    tablaPresentaciones = $('#tablaMovimientos').DataTable({ 
        "language": {
            "url": ""+ruta+"api/Spanish.json"
        },
        "ajax":{            
        "url": "api/getSaldo.php", 
        "method": 'POST', //usamos el metodo POST
        "data":{idfarmacia:idfarmacia, opcion:opcion}, //enviamos opcion 4 para que haga un SELECT
        //"data":"", //enviamos opcion 4 para que haga un SELECT
        "dataSrc":""
        },
        "columns":[
            {"data": "fecha" , 
                fnCreatedCell: function (nTd, sData, oData, iRow, iCol) {
                    $(nTd).html(
                        /* (oData.idLiquidacion == null ? `<span class='text-danger'>${oData.fecha}</span>` : `<span class='text-success'>${oData.fecha}</span>`) */
                        (oData.detalles.length > 0 ? `<i class="fa-solid fa-caret-right me-4"></i> ${oData.fecha}`:`<div style="padding-left:35px;">${oData.fecha}</div>`)
                    );
                },
            },
            {
                "data": "nombre" , 
                "className": "bold lefted-text"
            },
            {"data": "debe" , 
                "render": DataTable.render.number('.', ',', 2, ' $ ', ''),
                "className": 'righted-text',
            },
            {"data": "haber" , 
                "render": DataTable.render.number('.', ',', 2, ' $ ', ''),
                "className": 'righted-text',
            },
/*             {"data": "total" , 
                "render": DataTable.render.number('.', ',', 2, ' $ ', ''),
                "className": 'righted-text',
            }, */
            {"data": "saldo" , 
                "render": DataTable.render.number('.', ',', 2, ' $ ', ''),
                "className": 'righted-text',
            }

        ],
        "columnDefs": [
            { "orderable": false, "targets": [0, 1, 2, 3, 4] },
            { "orderable": true, "targets": [] }
        ],
        order: false,
    }); 

    tablaPresentaciones.on( 'draw', function () {
        var table = $('#tablaMovimientos').DataTable();

        var totalDebito = document.getElementById("totalDebito");
        var totalCredito = document.getElementById("totalCredito");
        var totalSaldo = document.getElementById("totalSaldo");

        totalDebito.innerHTML = "$ "+formatNumber.format((table.column(2).data().sum()).toFixed(2));
        totalCredito.innerHTML = "$ "+formatNumber.format((table.column(3).data().sum()).toFixed(2));
        totalSaldo.innerHTML = "$ "+formatNumber.format((table.column(4).data().sum()).toFixed(2));
    } );

    $('#tablaMovimientos tbody').on('click', 'tr', function () {
        var table = $('#tablaMovimientos').DataTable();
        var tr = $(this).closest('tr');
        var row = table.row(tr);
        if(row.data().detalles.length > 0){
            if (row.child.isShown()) {
                $(this).find('i').removeClass('rotated');
                row.child.hide();
                tr.removeClass('shown');
            } else {
                $(this).find('i').addClass('rotated');
                row.child(format(row.data())).show();
                tr.addClass('shown');
            }
        }
    });

    function format(d) {
        var formatter = new Intl.NumberFormat('de-DE');
        return (
            `<table class="row-childs" cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">
                ${d.detalles.map(function(detalle){
                    return `
                        <tr >
                            <td></td>
                            <td class="lefted-text">- ${detalle.nombre}</td>
                            <td class="righted-text">${detalle.debe !== null?formatter.format(detalle.debe):''}</td>
                            <td class="righted-text">${detalle.haber !== null?formatter.format(detalle.haber):''}</td>
                            <td></td>
                        </tr>
                    `
                }).join('')}
            </table>`
        );
    }

});
