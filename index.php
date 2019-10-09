<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<!--ccs-->
<link rel="stylesheet" href="site_media/plugins/css/bootstrap-grid.min.css">
<link rel="stylesheet" href="site_media/plugins/css/bootstrap-reboot.css">
<link rel="stylesheet" href="site_media/plugins/css/bootstrap.min.css">
<link rel="stylesheet" href="site_media\css\Usuario\estilo.css">
<link rel="stylesheet" href="site_media/css/main.css">
<link href="site_media/plugins/css/open-iconic-bootstrap.css" rel="stylesheet">


<!--javascript-->
<script src="site_media/plugins/js/jquery.js"></script>
<script src="site_media/plugins/js/bootstrap.bundle.min.js"></script>
<script src="site_media/plugins/js/bootstrap.min.js"></script>

<html>
    <head>
    	<title>Mundo Verde</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="UTF-8">
    </head>
    <body id="contentMain" style="background: #f7f7f1;overflow-x: hidden;overflow-y: auto;">
        <?php
        echo "hola";
        echo $_SESSION['pagIni'];
        session_start();
        if (isset($_SESSION['pagIni'])) {
            include './'.$_SESSION['pagIni'];
        }else{
            include './site_media/html/home.html';
        }
        ?>

    </body>

</html>

<!--javascript-->
<script src="site_media/js/main.js"></script>
<script src="site_media/js/Login/login.js"></script>
<script src="site_media/js/Usuario/usuario.js"></script>