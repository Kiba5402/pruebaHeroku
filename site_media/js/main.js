/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function accionBtn(objectThis) {
    $.ajax({
        method: "POST",
        url: "controller/main.php",
        type: 'html',
        data: { 'funcion': $(objectThis).attr('id') }
    }).done(function(msg) {
        $('#contentMain').html(msg);
    });
}

//funcion que cierra el modal del id enviado
function cerrarModal(idModal) {
    $('#' + idModal).modal('hide');
}

//funcion para reornar a una pagina
function atrasDir(funcion,direccion) {
    $.ajax({
        method: "POST",
        url: "controller/main.php",
        type: 'html',
        data: {
         	'funcion': funcion,
        	'dir': direccion	
         }
    }).done(function(msg) {
        $('#contentMain').html(msg);
    });
}

//funcion que formatea el valor a formato moneda
function formatMoneda(valor){
   return parseFloat(valor, 10)
   .toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString();
}


//funcion que construlle el elemento html del estado de pedido
function estadoPed(idEstado) {
    switch (idEstado) {
        case '1':
            return $('<span/>', {
                'class': 'badge badge-primary',
                'text': 'A la espera'
            });
            break;
        case '2':
            return $('<span/>', {
                'class': 'badge badge-info',
                'text': 'Por Recoger'
            });
        case '3':
            return $('<span/>', {
                'class': 'badge badge-secondary',
                'text': 'Recogido'
            });
            break;
        case '4':
            return $('<span/>', {
                'class': 'badge badge-secondary',
                'text': 'Entregado'
            });
            break;
        case '5':
            return $('<span/>', {
                'class': 'badge badge-success',
                'text': 'Cerrado'
            });
            break;
        case '6':
            return $('<span/>', {
                'class': 'badge badge-dark',
                'text': 'Cancelado'
            });
            break;
        default:
            break;
    }
}
