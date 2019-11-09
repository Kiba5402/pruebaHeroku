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
        if (!info) {
            $('#cargaTablaOfertas').html('No hay ofertas para mostrar')
        } else {
            muestraOfertas(info);
        }
    });
}


//funcion que pinta la informacion de la ofertas del recolector
function muestraOfertas(informacion2) {
    console.log(informacion2.infoOfertas);
    $('#bodyTablaOfertas tr').remove();
    $.each(informacion2.infoOfertas, function(index, value) {
        var fila = $('<tr/>');
        //columna ip pedido
        $('<td/>', {
            'text': value.idPedido,
            'style': 'white-space: nowrap'
        }).appendTo(fila);
        //columna nombre cliente
        $('<td/>', {
            'text': value.nombreCli,
            'style': 'white-space: nowrap'
        }).appendTo(fila);
        //columna material
        $('<td/>', {
            'text': value.nombreMat,
            'style': 'white-space: nowrap'
        }).appendTo(fila);
        //columna unidades
        $('<td/>', {
            'text': value.unidades+" "+value.um,
            'style': 'white-space: nowrap'
        }).appendTo(fila);
        //columna aceptar pedido
        $('<td/>', {
            'html': '<a href="#ancla">' +
                '<span class="badge badge-info" onclick="traerDetalleOferta(' + value.idPedido + ')">' +
                'Detalles' +
                '</span>' +
                '</a>',
            'style': 'white-space: nowrap',
            'class': 'detallesPed'
        }).appendTo(fila);
        fila.appendTo($('#bodyTablaOfertas'));
    });
}