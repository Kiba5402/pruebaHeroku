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
