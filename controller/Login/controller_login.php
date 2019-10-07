<?php 
	
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
			return $this->modelo->login($this->usuario,$this->contrasenia);
		}

	}
 ?>