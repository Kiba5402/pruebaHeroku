//funcion ajax para el login
function btnLogin(objectThis) {
    //comprbamos los datos del formulario 
    if (compLogin()) {
        $.ajax({
            method: "POST",
            url: "views/Login/view_login.php",
            type: 'html',
            data: {
                'funcion': 'login',
                'email': $('#emaillogin').val(),
                'pass': $('#passwdlogin').val(),
            },
            beforeSend: function() {
                $('#cargaLogin').removeClass('d-none');
                $('#emaillogin').attr('disabled', true);
                $('#passwdlogin').attr('disabled', true);
            }
        }).done(function(msg) {
            $('#cargaLogin').addClass('d-none');
            $('#emaillogin').removeAttr('disabled', true);
            $('#passwdlogin').removeAttr('disabled', true);
            //validamos la respuesta
            compRespLogin(msg);
        });
    }
}

//funcion que comprueba la respuesta que nos dio el Login
function compRespLogin(msg) {
    if (msg == 2) {
        $("#modalLoginBody").html('La contraseña no es correcta');
        $("#modalLogin").modal('show');
    } else if (msg == 3) {
        $("#modalLoginBody").html('El usuario no existe');
        $("#modalLogin").modal('show');
    } else if (msg == 4) {
        $("#modalLoginBody").html('Ingreso Admin no permitido');
        $("#modalLogin").modal('show');
    } else {
        $('#contentMain').html(msg);
    }

}

//funcion que verifica que los input esten
//con informacion 
function compLogin() {
    var email = $('#emaillogin');
    var passwd = $('#passwdlogin');
    //comprobamos los valores 
    if (email.val().trim() == '') {
        email.addClass('is-invalid');
    } else if (passwd.val().trim() == '') {
        passwd.addClass('is-invalid');
    } else {
        email.removeClass('is-invalid');
        passwd.removeClass('is-invalid');
        return 1;
    }
}

//funcion que cierra la sesion actual
function btnCerrarSesion() {
    $.ajax({
        method: "POST",
        url: "views/Login/view_login.php",
        type: 'html',
        data: {
            'funcion': 'cerrarSesion',
        },
        beforeSend: function() {
            $('#contentMain').addClass('modal-backdrop fade show');
        }
    }).done(function(msg) {
        if (msg == -1) {
            location.reload();
        }
    });
}