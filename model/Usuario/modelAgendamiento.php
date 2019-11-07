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
			mat.id_material,
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

		//funcion que consulta el ultimo id insertado en la tabla materiales de pedido
		public function ultimoIdMatPedido(){
			//se crea la conexion
			$this->creaConexion();
			//creamos el query
			$consulta = "SELECT id_materiales + 1 as ultId FROM public.mv_materiales_pedido order by id_materiales DESC limit 1;";
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

		//funcion para crear un registro de material de pedido
		public function creaRegistroMatPedido($idMateriales, $id_material, $id_pedido, $unidades, $valor_aprox){
			//se crea la conexion
			$this->creaConexion();
			//creamos el query
			$consulta = "INSERT INTO public.mv_materiales_pedido (id_materiales, id_material, id_pedido, unidades, valor_aprox) VALUES($idMateriales, $id_material, $id_pedido, $unidades, $valor_aprox)";
			//Enviamos la consulta
			$query = pg_query($this->conexion,$consulta) or die(-1);
			//tomamos el resultado
			$respQuery = pg_affected_rows($query);
			//retornamos elñ resultado
			return $respQuery;
		}

		//funcion que consulta los pedidos realizados por el usuario 
		public function pedidosUser($idVendedor){
			//creamos la conexion
			$this->creaConexion();
			//creamos el query
			$consulta = "SELECT mat.nombre as \"nombreMat\",* 
			FROM mv_pedido pedido inner join mv_materiales_pedido matPed
			on pedido.id_pedido = matPed.id_pedido inner join mv_material mat 
			on matPed.id_material = mat.id_material inner join mv_unidad_medida um
			on mat.id_und_medida_material = um.id_und_medida 
			where pedido.id_vendedor = $idVendedor 
			order by pedido.fecha_pedido desc";
			//Enviamos la consulta
			$query = pg_query($this->conexion,$consulta) or die(-1);
			//tomamos el resultado
			$respQuery = pg_fetch_all($query);
			//retornamos el resultado
			return $respQuery;
		}

	}
 ?>