/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function reloadFn(){
    $.ajax({
        method: "POST",
        url: "index.php",
        type: 'html',
        data: { 'urlSesion': sessionStorage['Nombre'] }
    }).done(function(msg) {
        $('#contentMain').html(msg);
    });
}

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
