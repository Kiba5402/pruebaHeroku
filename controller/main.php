<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

switch (filter_input(INPUT_POST, 'funcion', FILTER_SANITIZE_STRING)) {
    case 'informes':
        include '../site_media/html/informes.html';
        break;
    default:
        include '../site_media/html/construction.html';
        break;
}  
