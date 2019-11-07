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
        var respuesta = JSON.parse(msg);
        $('#contentMain').html(respuesta.html);
        localStorage.setItem('idPersona', respuesta.infoUser.id_persona);
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

//funcion para registrarse
function btnRegistrar() {
    //omprobamos que la contraseñas sean iguales
    if (confirmaPass() != -1 && $('#formReg')[0].checkValidity()) {
        $.ajax({
            method: "POST",
            url: "views/Login/view_login.php",
            type: 'html',
            data: {
                'funcion': 'registrar',
                'nombre': $('#nombre').val(),
                'documento': $('#documento').val(),
                'fechaNac': $('#fecha').val(),
                'localidad': $('#localidad option:selected').text(),
                'correo': $('#correo').val(),
                'telefono': $('#telefono').val(),
                'direccion': $('#direccion').val(),
                'pass': $('#pass2').val()
            },
            beforeSend: function() {
                //$('#contentMain').addClass('modal-backdrop fade show');
                $('#cargaReg').removeClass('d-none');
            }
        }).done(function(msg) {
            var msg2 = JSON.parse(msg);
            if (msg2.insertPersona == 1 && msg2.insertUsuario == 1) {
                $('#modalReg').modal('show');
                $('#cargaReg').addClass('d-none');
            }
        });
    } else {
        $('#noCoinciden').removeClass('d-none');
    }
}

//funcion para recargar la pagina
function recargarPag() {
    location.reload();
}



//funcion para validar que la contraseñas son iguales
function confirmaPass() {
    var pass1 = $("#pass1").val();
    var pass2 = $("#pass2").val();
    //validamos
    if ((pass1.trim() != pass2.trim()) || (pass1.trim() == '' || pass2.trim() == '')) {
        return -1;
    } else {
        return 1;
    }
}