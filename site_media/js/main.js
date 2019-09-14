/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$('.lista').click(function () {
    $.ajax({
        method: "POST",
        url: "controller/main.php",
        type: 'html',
        data: {'funcion': $(this).attr('id')}
    }).done(function (msg) {
        console.log(msg);
        $('#contentMain').html(msg);
    });
});


$(document).ready(function () {
    console.log('asdasdasd');
});