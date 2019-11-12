<?php

require_once("../../model/Recolector/modelRecolector.php");

class controller_historial{

	private $modelo;

	//mfuncion invocada por el view que ý que asigna la ruta del
	//html a devolver, pero tambien complementa la informacion 
	public function pagHistorial($idRecolector){
		$this->modelo = new modelRecolector();
		return array(
			'infoHistorial' => $this->compInfoHistorial($idRecolector),
			'html' => '/Recolector/historialPedidos.html'
		);
	}

	//funcion que complementa la informacion del historial
	//de pedidos basado en el id del reclector
	public function compInfoHistorial($idRecolector){ 
		$infoHistPedidos = $this->modelo->historialPedidos($idRecolector);
		return $infoHistPedidos;
	}

	//funcion que trae el detalle de una pedido historico
	public function detalleHistorial($idPedido){
		$this->modelo = new modelRecolector();
		return array(
			'infoDetalleHistorial' => $this->modelo->detalleOferta($idPedido),
			'html' => '/Recolector/detalleHistorialPedidos.html'
		);
	}


}

?>