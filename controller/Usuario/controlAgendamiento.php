<?php

require_once("../../model/Usuario/modelAgendamiento.php");

class controller_agendamiento{

	private $modelo;

	//mfuncion invocada por el view que ý que asigna la ruta del
	//html a devolver, pero tambien complementa la informacion 
	public function pagAgendamiento($idMat){
		$this->modelo = new modelAgendamiento();
		return array(
			'infoMat' => $this->compInfoMat($idMat),
			'html' => '/Usuario/FormularioAgendamiento.html'
		);
	}

	//funcion que complementa la informacion del material
	public function compInfoMat($idMat){ 
		$infoMat = $this->modelo->compinfoMat($idMat);
		return $infoMat;
	}

	//funcion que guarda el agendamiento de un pedido
	public function guardaAgendamiento($idVendedor,$horarioRec,$idMaterial,$unidades,$valorAprox){
		$respMateriales = -1;
		$respPedido = -1;
		
		if ($idVendedor != -1 && $idMaterial != -1) {
			$this->modelo = new modelAgendamiento();
			//consultamos el ultimo id de la tabla pedido
			$ultimoIdPedido = $this->modelo->ultimoIdPedido();
			//guardamos el registro en la tabla pedido
			$respPedido = $this->modelo->creaRegistroPedido($ultimoIdPedido, $idVendedor, $horarioRec);
			if ($respPedido == 1) {
				//consultamos el ultimo id de la tabla materiales de contenido
				$ultimoIdMateriales = $this->modelo->ultimoIdMatPedido();
				//guardamos el material en la tabla materiales de pedido
				$respMateriales = $this->modelo->creaRegistroMatPedido($ultimoIdMateriales, $idMaterial, $ultimoIdPedido, $unidades, $valorAprox);
			}
		}

		return array(
			'respPedido' => $respPedido,
			'respMateriales' => $respMateriales
		);
	}

	//funcion que trae la informacion sobre los pedidos que ha realizado el usuario
	public function pedidosUser($idVendedor){
		if ($idVendedor != null) {
			$this->modelo = new modelAgendamiento();
			$infoPedidosUsr = $this->modelo->pedidosUser($idVendedor);		
			return $infoPedidosUsr;
		}else{
			return -1;
		}
	}

	//funcion que trae el detalle del pedido
	public function detallePedido($idPedido){
		$this->modelo = new modelAgendamiento();
		return array(  	
			'infoPed' => $this->modelo->detallePedidosUser($idPedido),
			'html' => '/Usuario/detallePedido.html'
		);
	}

	//funcion que nos permite calificar un pedido
	public function calificarPedido($idPedido, $calificacion){
		$this->modelo = new modelAgendamiento();
		return array(
			'infoCalif' => $this->modelo->calificaPed($idPedido, $calificacion),
		);
	}
}

?>