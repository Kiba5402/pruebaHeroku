/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//funcion que trae el historial de pedidos
function traerHistorial() {
    $.ajax({
        method: "POST",
        url: "views/Recolector/viewHistorialPedidos.php",
        type: 'html',
        data: {
            'funcion': 'historial',
            'idRecolector': '123'
        },
        beforeSend: function() {
            $('#cargaHistorial').removeClass('d-none');
        }
    }).done(function(msg) {
        var info = JSON.parse(msg);
        $('#contentMain').html(info.html);
    });
}

//funcion que trae los pedidos Activos
function traerPedidosAct() {
    $.ajax({
        method: "POST",
        url: "views/Recolector/viewRecogidasActivas.php",
        type: 'html',
        data: {
            'funcion': 'pedidosAct',
            'idRecolector': '123'
        },
        beforeSend: function() {
            $('#cargaPedidosAct').removeClass('d-none');
        }
    }).done(function(msg) {
        console.log(msg);
        var info = JSON.parse(msg);
        $('#contentMain').html(info.html);
    });
}