/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//--------!!
//funcion que permite aceptar una oferta
function aceptaOferta(idOferta) {
    $.ajax({
        method: "POST",
        url: "views/Recolector/viewOfertas.php",
        type: 'json',
        data: {
            'funcion': 'aceptarOferta',
            'idPersona': localStorage.getItem('idPersona')
        },
        beforeSend: function() {
            //$('#cargaMat' + idMat).removeClass('d-none');
        }
    }).done(function(msg) {
        if (msg != -1) {
            var info = JSON.parse(msg);
            if (!info.infoOfertas) {
                $('#cargaTablaOfertas').html('No hay ofertas para mostrar')
            } else {
                muestraOfertas(info);
            }
        }
    });
}

//funcion que permite rechazar una oferta
function rechazarOferta(idOferta) {
    $('#bodyTablaOfertas #oferta'+idOferta).remove();
    $('#modalDetalleOferta').modal('hide');
}

//funcion que trae el detalle de algun pedido 
//que esta en el historial
function traerDetalleOferta(idOferta) {
    $.ajax({
        method: "POST",
        url: "views/Recolector/viewOfertas.php",
        type: 'html',
        data: {
            'funcion': 'detalleOferta',
            'idOferta': idOferta
        },
        beforeSend: function() {
            $('#cargaOfertas').removeClass('d-none');
        }
    }).done(function(msg) {
        var info = JSON.parse(msg);
        console.log(info);
        $('#contentDetalleOferta').html(info.html);
        $('#cargaOfertas').addClass('d-none');
        //contenido del modal
        //nombre del vendedor        
        $('#nombreVendedor').html(info.infoOferta[0].nombre_vend);
        //tipo material
        $('#tipoMatDetOf').html(info.infoOferta[0].nombreMat);
        //direccion recogida
        $('#direccionDetOf').html(info.infoOferta[0].direccion_vend);
        //telefono
        $('#telDetOf').html(info.infoOferta[0].telefono_vend);
        //localidad
        $('#barrioDetOf').html(info.infoOferta[0].localidad_vend);
        //peso
        $('#pesoDetOf').html(info.infoOferta[0].unidades_material + " " + info.infoOferta[0].unidad_medida);
        //valor
        $('#valorDetOf').html('$' + formatMoneda(info.infoOferta[0].valor_aprox));
        //Estado del pedido
        $('#estadoPedDetOf').html(info.infoOferta[0].estadoPed);
        //seteamos los onclick de los dos botones
        $('#btnAceptar').attr('onclick','aceptaOferta('+info.infoOferta[0].idPedido+')');
        $('#btnRechazar').attr('onclick', 'rechazarOferta(' + info.infoOferta[0].idPedido + ')');
        //mostramso el modal
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
        if (msg != -1) {
            var info = JSON.parse(msg);
            if (!info.infoOfertas) {
                $('#cargaTablaOfertas').html('No hay ofertas para mostrar')
            } else {
                muestraOfertas(info);
            }
        }
    });
}

//funcion que pinta la informacion de la ofertas del recolector
function muestraOfertas(informacion2) {
    $('#bodyTablaOfertas tr').remove();
    $.each(informacion2.infoOfertas, function(index, value) {
        var fila = $('<tr/>',{
            'id': 'oferta'+value.idPedido
        });
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
            'text': value.unidades + " " + value.um,
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