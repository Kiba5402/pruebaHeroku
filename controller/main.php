<?php
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
    case 'direccion':
        include filter_input(INPUT_POST, 'dir', FILTER_SANITIZE_STRING);
        break;
    default:
        include '../site_media/html/home.html';
        break;
}  
