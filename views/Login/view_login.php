<?php 
	require_once("../superView.php");
	require_once("../../controller/Login/controller_login.php");

	class view_login extends view_super{

		private $controlador;

		//funcion para loguearse
		public function login($args){
			$this->controlador = new controller_login($args[0],$args[1]);
			$respuesta = $this->controlador->compInfo();
			//evaluamos la respuesta
			if ($respuesta !== 2 && $respuesta !== 3 && $respuesta !== 4) {
				return $this->get_include_contents($respuesta);
			}else{
				return $respuesta;
			}
		}

		//fruncion para cerrar la sesion actual
		public function closeLog(){
			$this->controlador = new controller_login(null,null);
			$respuesta = $this->controlador->closeSesion();
			//evaluamos la respuesta
			return $respuesta;
		}
	}

	/*
 	*Recibimos la solucitudes de esta vista desde ajax y devuelve el html 
 	o la informacion solicitada
 	*/
	switch (filter_input(INPUT_POST, 'funcion', FILTER_SANITIZE_STRING)) {
	    case 'login':
	    	//traemos la informacion
	    	$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
	    	$pass = filter_input(INPUT_POST, 'pass', FILTER_SANITIZE_STRING);
	        // seteamos el view_login
 			$view = new view_login();
 			echo $view->login([$email,$pass]);
	        break;
	    case 'cerrarSesion':
	        // seteamos el view_login
 			$view = new view_login();
 			echo $view->closeLog();
	        break;
	    default:
	        include '../site_media/html/home.html';
	        break;
	}  

 ?>