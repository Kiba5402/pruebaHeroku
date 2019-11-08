//funcion que trae el formulario de detalles de material
function viewDetallesMat(idMat) {
    $.ajax({
        method: "POST",
        url: "views/Usuario/formularioAgendamientoView.php",
        type: 'json',
        data: {
            'funcion': 'agendar',
            'tipoMat': idMat
        },
        beforeSend: function() {
            $('#cargaMat' + idMat).removeClass('d-none');
        }
    }).done(function(msg) {
        var info = JSON.parse(msg);
        var div = $('<div/>', {
            'html': info.html
        });
        //seteamos la informacion dentro del html
        var nombreMat = info.TipoMat.infoMat[0].nombremat;
        var precio = info.TipoMat.infoMat[0].precio_und_medida;
        var nombreUndMed = info.TipoMat.infoMat[0].nombre;
        var simbolo = info.TipoMat.infoMat[0].simbolo;
        //ponemos los nombres dentro de los elementos html
        div.find('#h3titulo').html(nombreMat);
        div.find('#undMed').html('Cant. ' + nombreUndMed);
        div.find('#valor').attr('precio', info.TipoMat.infoMat[0].precio_und_medida);
        //seteamos el id del material 
        localStorage.setItem('idMaterial', info.TipoMat.infoMat[0].id_material);

        $('#contentMain').html(div);
    });
}

//funcion para abrir el modal 
function abrirModal() {
    $('#modalAdvertenciaAgendamiento').modal('show');
}

//funcion que calcula el valor segun la unicad
//aproximada que tenga el cliente
function multiplica(objectThis) {
    var cant = $(objectThis).val();
    var precio = $('#valor').attr('precio');
    if (cant.trim() !== '') {
        var total = cant * precio;
        $('#valor').attr('total', total);
        $('#valor').val('$' + formatMoneda(total));
    } else {
        $('#valor').val('$0');
        $('#valor').attr('total', 0);
    }
}

//funcion que agenda la recogida del material
function agendarRecogida() {
    //comprobamos los datos
    if (validaInfo()) {
        $('#datosAgendaIncomp').addClass('d-none');
        $.ajax({
            method: "POST",
            url: "views/Usuario/formularioAgendamientoView.php",
            type: 'json',
            data: {
                'funcion': 'agendarRecogida',
                'idVendedor': localStorage.getItem('idPersona'),
                'horarioRec': $('#horario option:selected').text(),
                'idMaterial': localStorage.getItem('idMaterial'),
                'unidades': $('#unidad').val().trim(),
                'valorAprox': $('#valor').attr('total')
            },
            beforeSend: function() {
                $('#unidad').attr('disabled', true);
                $('#horario').attr('disabled', true);
                $('#cargaAgenda').removeClass('d-none');
            }
        }).done(function(msg) {
            var info = JSON.parse(msg);
            $('#cargaAgenda').addClass('d-none');
            if (info.respPedido == 1 && info.respMateriales == 1) {
                $('#modalAgendamientoOk').modal('show');
            } else {
                $('#modalerrorAgendamiento').modal('show');
            }
        });
    } else {
        $('#datosAgendaIncomp').removeClass('d-none');
    }
}

//funvion que comprueba si la informacion para agendar esta completa
function validaInfo() {
    //validamos la unidad
    var valueUnidad = $('#unidad').val().trim();
    var valueHorario = $('#horario option:selected').val();
    if ((valueUnidad != '' || valueUnidad != 0) && valueHorario != -1) {
        return true;
    } else {
        return false;
    }
}

//funcion que trae el formulario de detalles de material
function traerPedidos() {
    $.ajax({
        method: "POST",
        url: "views/Usuario/formularioAgendamientoView.php",
        type: 'json',
        data: {
            'funcion': 'pedidosUsr',
            'idPersona': localStorage.getItem('idPersona')
        },
        beforeSend: function() {
            //$('#cargaMat' + idMat).removeClass('d-none');
        }
    }).done(function(msg) {
        var info = JSON.parse(msg);
        if (!info) {
            $('#cargaTabla').html('No hay pedidos para mostrar')
        } else {
            muestraPedidos(info);
        }
    });
}

//funcion que pinta la informacion de pedidos del usuario
function muestraPedidos(informacion2) {
    $('#bodyPedidosUsr tr').remove();
    $.each(informacion2, function(index, value) {
        var fila = $('<tr/>');
        //columna id de pedido
        $('<td/>', {
            'text': value.id_pedido,
            'style': 'white-space: nowrap'
        }).appendTo(fila);
        //columna fecha pedido
        $('<td/>', {
            'text': value.fecha_pedido,
            'style': 'white-space: nowrap'
        }).appendTo(fila);
        //columna material de pedido
        $('<td/>', {
            'text': value.nombreMat,
            'style': 'white-space: nowrap'
        }).appendTo(fila);
        //columna unidades de pedido
        $('<td/>', {
            'text': value.unidades + ' ' + value.simbolo,
            'style': 'white-space: nowrap'
        }).appendTo(fila);
        //columna valor de pedido
        $('<td/>', {
            'text': '$' + formatMoneda(value.valor_aprox),
            'style': 'white-space: nowrap; text-align:right'
        }).appendTo(fila);
        //columna detalle de pedido
        $('<td/>', {
            'html': '<a href="#ancla">' +
                '<span class="btn-registrar badge badge-success" onclick="traerDetallePed(' + value.id_pedido + ')">' +
                'Detalles' +
                '</span>' +
                '</a>',
            'style': 'white-space: nowrap',
            'class': 'detallesPed'
        }).appendTo(fila);
        //columna estado de pedido
        $('<td/>', {
            'html': estadoPed(value.id_estado_pedido),
            'style': 'white-space: nowrap'
        }).appendTo(fila);
        fila.appendTo($('#bodyPedidosUsr'));
    });
}

//funcion que trae el detalle del pedido hecho por el usuario
function traerDetallePed(idPedido) {
    $.ajax({
        method: "POST",
        url: "views/Usuario/formularioAgendamientoView.php",
        type: 'html',
        data: {
            'funcion': 'detallePedido',
            'idPedido': idPedido
        },
        beforeSend: function() {
            $('#cargaPedidos').removeClass('d-none');
        }
    }).done(function(msg) {
        var info = JSON.parse(msg);
        $('#cargaPedidos').addClass('d-none');
        //contenido del modal
        $('#contenidoModalDetallepedido').html(info.html);
        //numero del pedido        
        $('#numeropedido').html(info.datos[0].idPedido);
        //tipo material
        $('#tipoMatDetPed').html(info.datos[0].nombreMat);
        //direccion recogida
        $('#direccionDetPed').html(info.datos[0].direccion_vend);
        //telefono
        $('#telDetPed').html(info.datos[0].telefono_vend);
        //localidad
        $('#barrioDetPed').html(info.datos[0].localidad_vend);
        //peso
        $('#pesoDetPed').html(info.datos[0].unidades_material + " " + info.datos[0].unidad_medida);
        //nombre del recolector
        $('#nombreRecolectorDetPed').html((info.datos[0].nombre_comp == null) ? 'A la espera' : info.datos[0].nombre_comp);
        //telefono rtecolector
        $('#telefonoRecolectorDetPed').html((info.datos[0].telefono_comp == null) ? 'A la espera' : info.datos[0].telefono_comp);
        //valor
        $('#valorDetPed').html('$' + formatMoneda(info.datos[0].valor_aprox));
        //Estado del pedido
        $('#estadoPedDetPed').html(info.datos[0].estadoPed);
        //mostramso el modal
        $('#modalDetallePedido').modal('show');
    });
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