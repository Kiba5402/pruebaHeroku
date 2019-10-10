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
            //$('#cargaHistorial').removeClass('d-none');
        }
    }).done(function(msg) {
        var info = JSON.parse(msg);
        console.log(info);
        $('#contentDetallePedido').html(info.html);
        $('#modalDetallePedido').modal('show');
    });
}
