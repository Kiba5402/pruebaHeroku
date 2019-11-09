<?php 

	/*if (session_status() == PHP_SESSION_NONE) {
			session_start();
	}*/
	require_once("../../model/conexion.php");

	class modelRecolector{
		
		private $conexion;

		private function creaConexion(){
			$conn = new conexion('PG_SQL');
			$this->conexion = $conn->getConn();
		}

		//funcion que trae la localidad de un usuario
		public function traeLocalidad($idPersona){
			//creamos la conexion
			$this->creaConexion();
			//creamos el query
			$consulta = "SELECT localidad FROM mv_persona where id_persona = $idPersona";
			//Enviamos la consulta
			$query = pg_query($this->conexion,$consulta) or die(-1);
			//tomamos el resultado
			$respQuery = pg_fetch_all($query);
			//retornamos el resultado
			return $respQuery;
		}

		//funcion que trae las ofertas para el recolector
		public function ofertasRecolector($localidad){
			//creamos la conexion
			$this->creaConexion();
			//creamos el query
			$consulta = "SELECT persona.nombre as \"nombreCli\",
			mat.nombre as \"nombreMat\",matPed.unidades as \"unidades\",
			um.simbolo as \"um\",pedido.id_pedido as \"idPedido\"
			FROM public.mv_pedido pedido inner join mv_materiales_pedido matPed
			on pedido.id_pedido = matPed.id_pedido inner join mv_material mat
			on matPed.id_material = mat.id_material inner join mv_persona persona
			on pedido.id_vendedor = persona.id_persona inner join mv_unidad_medida um
			on mat.id_und_medida_material = um.id_und_medida 
			where persona.localidad = '$localidad'";
			//Enviamos la consulta
			$query = pg_query($this->conexion,$consulta) or die(-1);
			//tomamos el resultado
			$respQuery = pg_fetch_all($query);
			//retornamos el resultado
			return $respQuery;
		}

		//funcion que consulta el ultimo id insertado en la tabla pedido
		public function ultimoIdPedido(){
			//se crea la conexion
			$this->creaConexion();
			//creamos el query
			$consulta = "SELECT id_pedido + 1 as ultId FROM public.mv_pedido order by id_pedido DESC limit 1;";
			//Enviamos la consulta
			$query = pg_query($this->conexion,$consulta) or die(-1);
			//tomamos el resultado
			$respQuery = pg_fetch_all($query);
			//retornamos el resultado
			if ($respQuery != null) {
				return $respQuery[0]['ultid'];
			}else{
				return 1;
			}
			
		}

	
		//funcion para crear un registro de pedido
		public function creaRegistroPedido($idPedido, $id_vendedor, $horario){
			$hoy = date('d-m-Y');
			//se crea la conexion
			$this->creaConexion();
			//creamos el query
			$consulta = "INSERT INTO public.mv_pedido (id_pedido, id_vendedor, id_comprador, id_estado_pedido, fecha_pedido, fecha_recogida, fecha_entrega, horariorecogida) VALUES($idPedido, $id_vendedor, NULL, 1, '$hoy', NULL, NULL, '$horario')";
			//Enviamos la consulta
			$query = pg_query($this->conexion,$consulta) or die(-1);
			//tomamos el resultado
			$respQuery = pg_affected_rows($query);
			//retornamos elñ resultado
			return $respQuery;
		}

	}
 ?>