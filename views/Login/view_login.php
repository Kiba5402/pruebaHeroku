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
				return json_encode(array(
					'html' => $this->get_include_contents($respuesta['ruta']),
					'ruta' => $respuesta['ruta'],
					'infoUser'=> $respuesta['infoUser']
				));
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

		//funcion para registrarse
		public function registrar($nombre, $documento, $fechaNac, $localidad, $correo, $tel, $direccion, $pass){
				//seteamos el controlador
				$this->controlador = new controller_login(null, null);
				//funcion del controlador que inserta la info de usuario
				$resultado = $this->controlador->creaNuevoUsuario($nombre, $tel, $direccion, $localidad, $fechaNac, $documento, $correo, $pass);
				//retornamos el resultado
				return json_encode($resultado);
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
	    case 'registrar':
	    	//traemos la informacion
            $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
            $documento = filter_input(INPUT_POST, 'documento', FILTER_SANITIZE_STRING);
            $fechaNac = filter_input(INPUT_POST, 'fechaNac', FILTER_SANITIZE_STRING);
            $localidad = filter_input(INPUT_POST, 'localidad', FILTER_SANITIZE_STRING);
	    	$email = filter_input(INPUT_POST, 'correo', FILTER_SANITIZE_STRING);
	    	$telefono = filter_input(INPUT_POST, 'telefono', FILTER_SANITIZE_STRING);
	    	$direccion = filter_input(INPUT_POST, 'direccion', FILTER_SANITIZE_STRING);
	    	$pass = filter_input(INPUT_POST, 'pass', FILTER_SANITIZE_STRING);
	        // seteamos el view_login
 			$view = new view_login();
 			echo $view->registrar($nombre, $documento, $fechaNac, $localidad, $email, $telefono, $direccion, $pass);
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