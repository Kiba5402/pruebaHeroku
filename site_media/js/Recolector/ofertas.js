/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//funcion que trae el detalle de algun pedido 
//que esta en el historial
function traerDetalleOferta(idOferta) {
    $.ajax({
        method: "POST",
        url: "views/Recolector/viewOfertas.php",
        type: 'html',
        data: {
            'funcion': 'detalleOferta',
            'idPedido': idOferta
        },
        beforeSend: function() {
            //$('#cargaHistorial').removeClass('d-none');
        }
    }).done(function(msg) {
        var info = JSON.parse(msg);
        console.log(info);
        $('#contentDetalleOferta').html(info.html);
        $('#modalDetalleOferta').modal('show');
    });
}

//funcion que trae ela informacion de las ofertas
function traerOfertas() {
    $.ajax({
        method: "POST",
        url: "views/Recolector/viewOfertas.php",
        type: 'json',
        data: {
            'funcion': 'traerOfertas',
            'idPersona': localStorage.getItem('idPersona')
        },
        beforeSend: function() {
            //$('#cargaMat' + idMat).removeClass('d-none');
        }
    }).done(function(msg) {
        var info = JSON.parse(msg);
        console.log(info);
        /*if (!info) {
            $('#cargaTabla').html('No hay pedidos para mostrar')
        } else {
            muestraPedidos(info);
        }*/
    });
}