/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//funcion que trae el detalle de algun pedido 
//que esta en el historial
function traerDetallePedidoAct(idPedido) {
    $.ajax({
        method: "POST",
        url: "views/Recolector/viewRecogidasActivas.php",
        type: 'html',
        data: {
            'funcion': 'detPedidoAct',
            'idPedido': idPedido
        },
        beforeSend: function() {
            $('#cargaPedidoActMain').removeClass('d-none');
        }
    }).done(function(msg) {
        $('#cargaPedidoActMain').addClass('d-none');
        var info = JSON.parse(msg);
        $('#contentDetallePedidoActivo').html(info.html);
        //nombre del vendedor        
        $('#nombreVendPedAct').html(info.infoPedidoEnProgreso[0].nombre_vend);
        //fecha
        $('#fechaDetOfAct').html(info.infoPedidoEnProgreso[0].fecha);
        //tipo material
        $('#tipoMatDetOfAct').html(info.infoPedidoEnProgreso[0].nombreMat);
        //direccion recogida
        $('#direccionDetOfAct').html(info.infoPedidoEnProgreso[0].direccion_vend);
        //telefono
        $('#telDetOfAct').html(info.infoPedidoEnProgreso[0].telefono_vend);
        //localidad
        $('#barrioDetOfAct').html(info.infoPedidoEnProgreso[0].localidad_vend);
        //peso
        $('#pesoDetOfAct').html(info.infoPedidoEnProgreso[0].unidades_material + " " + info.infoPedidoEnProgreso[0].unidad_medida);
        //valor
        $('#valorDetOfAct').html('$' + formatMoneda(info.infoPedidoEnProgreso[0].valor_aprox));
        //horario
        $('#horarioDetOfAct').html(info.infoPedidoEnProgreso[0].horario);
        //Estado del pedido
        $('#estadoPedDetOfAct').html(info.infoPedidoEnProgreso[0].estadoPed);
        //seteamos lo botones con sus funciones
        seteoBtn(info.infoPedidoEnProgreso[0].idPedido, info.infoPedidoEnProgreso[0].telefono_vend, info.infoPedidoEnProgreso[0].id_estPed);
        $('#modalDetallePedidoActivo').modal('show');
    });
}

//funcion que nos ayuda con seteo de los botones
function seteoBtn(idPedido, telefono, estadoPed) {
    if (estadoPed == 2) {
        $('#btnCancelarDetPedAct').attr('onclick', 'cancelaPedAct(' + idPedido + ')');
        $('#btnRecogidoDetPedAct').attr('onclick', 'recoPedAct(' + idPedido + ')');
        $('#btnContacDetPedAct').attr('onclick', 'contactarPedAct(' + telefono + ')');
    } else if (estadoPed == 3) {
        $('#btnCancelarDetPedAct').attr('disabled', true);
        $('#btnContacDetPedAct').attr('disabled', true);
        $('#btnRecogidoDetPedAct').attr('onclick', 'entregaPedAct(' + idPedido + ')').html('Entregar');
    }

}

//funcion que pinta la informacion de la ofertas activas del recolector
function muestraOfertasActivas(informacion2) {
    $('#cuerpoTablaPedidoAct tr').remove();
    $.each(informacion2, function(index, value) {
        var fila = $('<tr/>', {
            'id': 'oferta' + value.idPedido
        });
        //columna ip pedido
        $('<td/>', {
            'text': value.idPedido,
            'style': 'white-space: nowrap'
        }).appendTo(fila);
        //columna fecha
        $('<td/>', {
            'text': value.fecha,
            'style': 'white-space: nowrap'
        }).appendTo(fila);
        //columna nombre cliente
        $('<td/>', {
            'text': value.nombre_vend,
            'style': 'white-space: nowrap'
        }).appendTo(fila);
        //columna material
        $('<td/>', {
            'text': value.nombreMat,
            'style': 'white-space: nowrap'
        }).appendTo(fila);
        //columna estado de pedido
        $('<td/>', {
            'html': estadoPed(value.id_estPed),
            'style': 'white-space: nowrap'
        }).appendTo(fila);
        //columna aceptar pedido
        $('<td/>', {
            'html': '<a href="#ancla">' +
                '<span class="badge badge-success" onclick="traerDetallePedidoAct(' + value.idPedido + ')">' +
                'Detalles' +
                '</span>' +
                '</a>',
            'style': 'white-space: nowrap',
            'class': 'detallesPed'
        }).appendTo(fila);
        fila.appendTo($('#cuerpoTablaPedidoAct'));
    });
}

//funcion para contactar al vendedor de una material 
function contactarPedAct(tel) {
    $('#modalContacto').modal('show');
    $('#telefonoModal').html(tel);
}

//funcion para cancelar un pedido activo
function cancelaPedAct(idPedido) {
    $.ajax({
        method: "POST",
        url: "views/Recolector/viewRecogidasActivas.php",
        type: 'html',
        data: {
            'funcion': 'cancelaPed',
            'idPedido': idPedido
        },
        beforeSend: function() {
            $('#cargaDetPedAct').removeClass('d-none');
            $('.btnDetPedAct').attr('disabled', true);
        }
    }).done(function(msg) {
        $('#cargaPedidoActMain').addClass('d-none');
        var info = JSON.parse(msg);
        if (info.infoCancelaPed == 1) {
            //seteamos titulo modal
            $('#tituloModalRespDetOfAct').html('Pedido Cancelado');
            //seteamos contenido modal
            $('#cuerpoModalRespDetOfAct').html('La recogida del pedido ha sido cancelada,'+
                ' si desea retomarlo aparecerá en el apartado de ofertas.</p>');
        } else {
            //seteamos titulo modal
            $('#tituloModalRespDetOfAct').html('Error cambiar estado');
            //seteamos contenido modal
            $('#cuerpoModalRespDetOfAct').html('<p>Ocurrió un error en el sistema,' +
                ' por favor contacte con el administrador.</p>');
        }
        //cerramos modal de detalle
        $('#modalDetallePedidoActivo').modal('hide');
        //abrimos modal de respuesta
        $('#modalResultadoDetOfAct').modal('show');
    });
}

//funcion para cambiar a estado recogido un pedido
function recoPedAct(idPedido) {
    $.ajax({
        method: "POST",
        url: "views/Recolector/viewRecogidasActivas.php",
        type: 'html',
        data: {
            'funcion': 'recoPedido',
            'idPedido': idPedido
        },
        beforeSend: function() {
            $('#cargaDetPedAct').removeClass('d-none');
            $('.btnDetPedAct').attr('disabled', true);
        }
    }).done(function(msg) {
        $('#cargaPedidoActMain').addClass('d-none');
        var info = JSON.parse(msg);
        if (info.infoRestPed == 1) {
            //seteamos titulo modal
            $('#tituloModalRespDetOfAct').html('Material Recogido');
            //seteamos contenido modal
            $('#cuerpoModalRespDetOfAct').html('<p>Usted ha recogido el material,' +
                ' recuerde entregarlo a la central en las misma condiciones' +
                ' recibidas y verificar que el pago al cliente haya sido correcto,' +
                ' el pedido lo podrá encontrar en la tabla de pedidos activos con el' +
                ' estado “Recogido”.</p>');
        } else {
            //seteamos titulo modal
            $('#tituloModalRespDetOfAct').html('Error cambiar estado');
            //seteamos contenido modal
            $('#cuerpoModalRespDetOfAct').html('<p>Ocurrió un error en el sistema,' +
                ' por favor contacte con el administrador.</p>');
        }
        //cerramos modal de detalle
        $('#modalDetallePedidoActivo').modal('hide');
        //abrimos modal de respuesta
        $('#modalResultadoDetOfAct').modal('show');
    });
}

//funcion para cambiar a estado recogido un pedido
function entregaPedAct(idPedido) {
    $.ajax({
        method: "POST",
        url: "views/Recolector/viewRecogidasActivas.php",
        type: 'html',
        data: {
            'funcion': 'entregaPedido',
            'idPedido': idPedido
        },
        beforeSend: function() {
            $('#cargaDetPedAct').removeClass('d-none');
            $('.btnDetPedAct').attr('disabled', true);
        }
    }).done(function(msg) {
        $('#cargaPedidoActMain').addClass('d-none');
        var info = JSON.parse(msg);
        if (info.infoEntregaPed == 1) {
            //seteamos titulo modal
            $('#tituloModalRespDetOfAct').html('Material Entregado');
            //seteamos contenido modal
            $('#cuerpoModalRespDetOfAct').html('Pedido entregado a la central,' +
                ' ahora podrá obtener información del mismo en la' +
                ' sección historial de pedidos.</p>');
        } else {
            //seteamos titulo modal
            $('#tituloModalRespDetOfAct').html('Error cambiar estado');
            //seteamos contenido modal
            $('#cuerpoModalRespDetOfAct').html('<p>Ocurrió un error en el sistema,' +
                ' por favor contacte con el administrador.</p>');
        }
        //cerramos modal de detalle
        $('#modalDetallePedidoActivo').modal('hide');
        //abrimos modal de respuesta
        $('#modalResultadoDetOfAct').modal('show');
    });
}