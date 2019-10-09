<?php 
	/*if (session_status() == PHP_SESSION_NONE) {
    		session_start();
	}*/
	require_once("../../model/Login/model_login.php");
	//clase para el login 

	class controller_login{

		private $modelo;
		private $usuario;
		private $contrasenia;

		public function controller_login($usuario,$passwd){
			//seteamos el modelo
			$this->modelo = new modelLogin();
			//seteamos los datos
			$this->usuario = $usuario;
			$this->contrasenia = $passwd;
		}

		//funcion que comprueba la informacion del usuario y retorna una respuesta 
		public function compInfo(){
			//invoco la funcion login del modelo
			$respuesta = $this->modelo->login($this->usuario,$this->contrasenia);
			if ($respuesta != 2 || $respuesta != 3) {
				switch ($respuesta[0]['nombrerol']) {
						case 'Vendedor':
							return '/Usuario/main.html';
							break;
						case 'Recolector':
							return '/Recolector/mainRecolector.html';
							break;
						default:
							return 4;
							break;
					}	
			}else{
				return $respuesta;
			}
		}

		//funcion que cierra la sesion actual
		public function closeSesion(){
			//invoco la funcion login del modelo
			$respuesta = $this->modelo->borrarSesion();
			return $respuesta;
		}

	}
 ?>