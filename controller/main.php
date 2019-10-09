<?php
if (session_status() == PHP_SESSION_NONE) {
 	session_start();
}
/*
 *Esta clase recibe solicitudes de un ajax y devuelve el html
 *solicitado
 */

switch (filter_input(INPUT_POST, 'funcion', FILTER_SANITIZE_STRING)) {
    case 'registroBtn':
        include '../site_media/html/Formulario-Registro.html';
        break;
    case 'atrasRegistro':
        include '../site_media/html/home.html';
        break;
    case 'inicioSesion':
        include '../'.$_SESSION['pagIni'];;
        break;
    default:
        include '../site_media/html/home.html';
        break;
}  
