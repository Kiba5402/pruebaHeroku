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
            //$('#cargaHistorial').removeClass('d-none');
        }
    }).done(function(msg) {
        var info = JSON.parse(msg);
        console.log(info);
        $('#contentDetallePedidoActivo').html(info.html);
        $('#modalDetallePedidoActivo').modal('show');
    });
}
