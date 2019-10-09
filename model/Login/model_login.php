<?php
	require_once("../../model/conexion.php");

	class modelLogin{
		
		private $usuario;
		private $contrasenia;
		private $rol;
		private $conexion;

		private function creaConexion(){
			$conn = new conexion('PG_SQL');
			$this->conexion = $conn->getConn();
		}

		public function login($usuario,$contrasenia){
			//borramos una sesion existente
			$this->borrarSesion();
			//se crea la conexion
			$this->creaConexion();
			//comprobamos la existencia del usuario 
			$compUser = $this->compUsuario($usuario);
			//si existe comprobamos la contraseña
			if ($compUser) {
				$compUser2 = $this->compPssd($usuario,$contrasenia);
				if ($compUser2) {
				//comprbamos los demas datos para dar el acceso
					return $this->compInfoUsr($compUser2[0]['id_usuario']);
				}
				//no coincide la contraseña
				else{
					return 2;
				}
			}
			//no existe el usuario
			else{
				return 3;
			}
		}

		// funcion que comprueba el nombre dle susuario
		private function compUsuario($usuario){
			//creamos el query
			$consulta = "select id_usuario from mv_usuario where correo = '$usuario'";
			//Enviamos la consulta
			$query = pg_query($this->conexion,$consulta) or die(-1);
			//tomamos el resultado
			$respQuery = pg_fetch_all($query);
			//retornamos el resultado
			//(si no encontro un susuario con ese correo retorn false)
			return $respQuery;
		}

		//funcioj que compruieba la contraseña del usuario
		private function compPssd($usuario,$psswd){
			//creamos el query
			$consulta = "select id_usuario from mv_usuario where correo = '$usuario' and contrasenia = '$psswd'";
			//Enviamos la consulta
			$query = pg_query($this->conexion,$consulta) or die(-1);
			//tomamos el resultado
			$respQuery = pg_fetch_all($query);
			//retornamos el resultado
			//(si no coincide la contraseña y el usaurio retorna false)
			return $respQuery;
		}

		//funcion que trae la informacio  del usuario y lo seta en la 
		//variables de sesion
		private function compInfoUsr($idUsr){
			//creamos el query
			$consulta = "select usr.correo, prs.nombre, prs.num_identificacion, prs.direccion,
						prs.localidad, prs.telefono, rol.nombrerol
						from mv_usuario usr inner join mv_persona prs
						on usr.id_persona_usuario = prs.id_persona
						inner join mv_rol rol
						on prs.id_rol_persona = rol.id_rol
						where usr.id_usuario = $idUsr";
			//Enviamos la consulta
			$query = pg_query($this->conexion,$consulta) or die(-1);
			//tomamos el resultado
			$respQuery = pg_fetch_all($query);
			//si esxiste un resultado guardamos la infromacion en la variables de sesion
			//$this->asigVarSesion($respQuery);
			return $respQuery;
		}

		//funcion que hace la asignacion de variables
		/*private function asigVarSesion($respQuery){
			//seteamos la iformacion
			if ($respQuery) {
				$_SESSION['correo'] = $respQuery[0]['correo'];
            	$_SESSION['nombre'] = $respQuery[0]['nombre'];
            	$_SESSION['num_identificacion'] = $respQuery[0]['num_identificacion'];
            	$_SESSION['direccion'] = $respQuery[0]['direccion'];
            	$_SESSION['localidad'] = $respQuery[0]['localidad'];
            	$_SESSION['telefono'] = $respQuery[0]['telefono'];
            	$_SESSION['nombrerol'] = $respQuery[0]['nombrerol'];
			}
		}*/

		//funcion logout
		public function borrarSesion(){
			//$_SESSION = array();
			if ($this->conexion != null) {
				$this->conexion->pg_close();
				$this->conexion = null;
			}
			return -1;
		}

	}

 ?>