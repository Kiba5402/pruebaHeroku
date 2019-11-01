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

		//funcion que se encraga de una nuevo registro
		public function creaNuevoUsuario($nombre, $tel, $dir, $loc, $fechaNac, $numIdent, $correo, $pass){
			//consultamos el id que sigue de la tabla persona
			$idPersona = $this->modelo->ultimoIdPersona();
			if ($idPersona != -1) {
				//guardamos la infiormacion de la tabla persona
		 		$resultInsert = $this->modelo->creaRegistro($idPersona, $nombre, $tel, $dir, $loc, $fechaNac, $numIdent);
				//consultamos el id de esta persona
				$ultIdPersona2 = $this->modelo->ultimoIdPersona();
				//consultamos el ultimo id de la tabla usuario
				$idUsuario = $this->modelo->ultimoIdUsuario();
				if ($idUsuario != -1) {
					//guardamos un nuevo registro de usuario
					$resultInsert2 = $this->modelo->creaRegistroUsuario($idUsuario, $correo, $pass, ($ultIdPersona2 - 1));
					return array(
						'insertPersona' => $resultInsert,
						'insertUsuario' => $resultInsert2
					);
				}else{
					return -1;
				}				
			}else{
				return -1;
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