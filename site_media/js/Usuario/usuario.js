
//funcion que trae el formulario de detalles de material
function viewDetallesMat(nombreMat){
        $.ajax({
            method: "POST",
            url: "views/Usuario/formularioAgendamientoView.php",
            type: 'json',
            data: {
                'funcion': 'agendar',
                'tipoMat': nombreMat
            },
            beforeSend: function() {

            }
        }).done(function(msg) {
            var info = JSON.parse(msg);
            console.log(info);
                    $('#contentMain').html(info.html);
        });
}