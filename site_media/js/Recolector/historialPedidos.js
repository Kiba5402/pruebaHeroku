/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//funcion que trae el detalle de algun pedido 
//que esta en el historial
function traerDetalleHist(idPedido) {
    $.ajax({
        method: "POST",
        url: "views/Recolector/viewHistorialPedidos.php",
        type: 'html',
        data: {
            'funcion': 'detalleHist',
            'idPedido': idPedido
        },
        beforeSend: function() {
            $('#cargaHistPedido').removeClass('d-none');
        }
    }).done(function(msg) {
        var info = JSON.parse(msg);
        $('#contentDetallePedido').html(info.html);
        $('#cargaHistPedido').addClass('d-none');
        //contenido del modal
        //nombre del vendedor        
        $('#nombreVendHistPed').html(info.infoDetalleHistorial[0].nombre_vend);
        $('#numeroDelpedidoHistPed').html(info.infoDetalleHistorial[0].idPedido);        
        //fecha
        $('#fechaDetHistPed').html(info.infoDetalleHistorial[0].fecha);
        //tipo material
        $('#tipoMatDetHistPed').html(info.infoDetalleHistorial[0].nombreMat);
        //direccion recogida
        $('#direccionDetHistPed').html(info.infoDetalleHistorial[0].direccion_vend);
        //telefono
        $('#telDetHistPed').html(info.infoDetalleHistorial[0].telefono_vend);
        //localidad
        $('#barrioDetHistPed').html(info.infoDetalleHistorial[0].localidad_vend);
        //peso
        $('#pesoDetHistPed').html(info.infoDetalleHistorial[0].unidades_material + " " + info.infoDetalleHistorial[0].unidad_medida);
        //valor
        $('#valorDetHistPed').html('$' + formatMoneda(info.infoDetalleHistorial[0].valor_aprox));
        //horario
        $('#horarioDetHistPed').html(info.infoDetalleHistorial[0].horario);
        //Estado del pedido
        $('#estadoPedDetHistPed').html(info.infoDetalleHistorial[0].estadoPed);
        //seteamos la calificacion del pedido
        asigCalificacion(info.infoDetalleHistorial[0].calificacion);
        //mostramso el modal
        $('#modalDetallePedido').modal('show');
    });
}

//funcion que pinta la informacion del historial de pedidos
function muestraHistorialOfertas(informacion2) {
    $('#cuerpoTablaHistPedido tr').remove();;
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
                '<span class="badge badge-success" onclick="traerDetalleHist(' + value.idPedido + ')">' +
                'Detalles' +
                '</span>' +
                '</a>',
            'style': 'white-space: nowrap',
            'class': 'detallesPed'
        }).appendTo(fila);
        fila.appendTo($('#cuerpoTablaHistPedido'));
    });
}

// funcion que asigana la calificacion 
function asigCalificacion(calf){
    $('.estrella').each(function(){
        if ($(this).attr('num') <= calf) {
            $(this).css('color','orange');
        }
    });
}