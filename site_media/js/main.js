/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

 sessionStorage.setItem("Nombre", 'asdasd');

function accionBtn(objectThis) {
    $.ajax({
        method: "POST",
        url: "controller/main.php",
        type: 'html',
        data: {'funcion': $(objectThis).attr('id')}
    }).done(function (msg) {
        $('#contentMain').html(msg);
    });
}

//funcion que cierra el modal del id enviado
function cerrarModal(idModal){
    $('#'+idModal).modal('hide');
}
