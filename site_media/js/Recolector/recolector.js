/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//funcion que trae el historial de pedidos
function traerHistorial() {
    $.ajax({
        method: "POST",
        url: "views/Recolector/viewHistorialPedidos.php",
        type: 'html',
        data: {
            'funcion': 'historial',
            'idRecolector': localStorage.getItem('idPersona')
        },
        beforeSend: function() {
            $('#cargaHistorial').removeClass('d-none');
        }
    }).done(function(msg) {
        var info = JSON.parse(msg);
        $('#contentMain').html(info.html);
        //ahora pintamos la informacion en la tabla
        if (!info.infoHistorial) {
            $('#cargaHistorialOfertas').html('No hay ofertas para mostrar')
        }else{
            muestraHistorialOfertas(info.infoHistorial);
        }
    });
}

//funcion que trae los pedidos Activos
function traerPedidosAct() {
    $.ajax({
        method: "POST",
        url: "views/Recolector/viewRecogidasActivas.php",
        type: 'html',
        data: {
            'funcion': 'pedidosAct',
            'idRecolector': localStorage.getItem('idPersona')
        },
        beforeSend: function() {
            $('#cargaPedidosAct').removeClass('d-none');
        }
    }).done(function(msg) {
        var info = JSON.parse(msg);
        $('#contentMain').html(info.html);
        //ahora pintamos la informacion en la tabla
        if (!info.infoPedidosActivos) {
            $('#cargaOfertasActivas').html('No hay ofertas para mostrar')
        }else{
            muestraOfertasActivas(info.infoPedidosActivos);
        }
    });
}

