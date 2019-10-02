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
        data: {'funcion': $(objectThis).attr('id')}
    }).done(function (msg) {
        console.log(msg);
        $('#contentMain').html(msg);
    });
}


$(document).ready(function () {
    console.log('asdasdasd');
});