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
        div.find('#valor').attr('precio', precio);

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
        $('#valor').val('$' + formatMoneda(total));
    } else {
        $('#valor').val('$0');
    }
}