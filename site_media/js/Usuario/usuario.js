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
        sessionStorage.setItem('idMaterial', info.TipoMat.infoMat[0].id_material);

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
                'idVendedor': sessionStorage.getItem('idPersona'),
                'horarioRec': $('#horario option:selected').text(),
                'idMaterial': sessionStorage.getItem('idMaterial'),
                'unidades': $('#unidad').val().trim(),
                'valorAprox': $('#valor').attr('total')
            },
            beforeSend: function() {
                //$('#cargaMat' + idMat).removeClass('d-none');
            }
        }).done(function(msg) {
            var info = JSON.parse(msg);
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