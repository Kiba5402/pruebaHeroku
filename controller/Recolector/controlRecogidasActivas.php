<?php

require_once("../../model/Recolector/modelRecolector.php");

class controller_RecogidasAct{

	private $modelo;

	//mfuncion invocada por el view que ý que asigna la ruta del
	//html a devolver, pero tambien complementa la informacion 
	public function pagPedidosAct($idRecolector){
		$this->modelo = new modelRecolector();
		return array(
			'infoPedidosActivos' => $this->modelo->pedidoActivos($idRecolector),
			'html' => '/Recolector/pedidosActivos.html'
		);
	}

	//funcion que muesra el detalle de un pedido actual
	//en progreso 
	public function detallePedidosAct($idPedido){
		$this->modelo = new modelRecolector();
		return array(
			'infoPedidoEnProgreso' => $this->modelo->detalleOferta($idPedido),
			'html' => '/Recolector/detallePedidoActual.html'
		);
	}

	//funcion que permite cambiar el estado de un pedido a recogido
	function recogePed($idPedido){ 
		$this->modelo = new modelRecolector();
		return array(
			'infoRestPed' => $this->modelo->recogerPed($idPedido)
		);
	}

	//funcion que permite cambiar el estado de un pedido a entregado
	function entregaPed($idPedido){ 
		$this->modelo = new modelRecolector();
		return array(
			'infoEntregaPed' => $this->modelo->entregaPed($idPedido)
		);
	}

	//funcion que permite cambiar el estado de un pedido a entregado
	function cancelaPed($idPedido){ 
		$this->modelo = new modelRecolector();
		return array(
			'infoCancelaPed' => $this->modelo->cancelaPed($idPedido)
		);
	}
}

?>