<?php 

if (session_status() == PHP_SESSION_NONE) {
			session_start();
	}
	require_once("../../model/conexion.php");

	class modelAgendamiento{
		
		private $conexion;

		private function creaConexion(){
			$conn = new conexion('PG_SQL');
			$this->conexion = $conn->getConn();
		}
		//funcion que complemeneta la ifnormacion del material
		public function compinfoMat($idMat){
			//creamos la conexion
			$this->creaConexion();
			//creamos el query
			$consulta = "select mat.nombre as nombreMat,
			mat.precio_und_medida,
			md.nombre, 
			md.simbolo
			from mv_material mat inner join mv_unidad_medida md
			on mat.id_und_medida_material = md.id_und_medida
			where mat.id_material = $idMat";
			//Enviamos la consulta
			$query = pg_query($this->conexion,$consulta) or die(-1);
			//tomamos el resultado
			$respQuery = pg_fetch_all($query);
			//retornamos el resultado
			return $respQuery;
		}

	}

 ?>