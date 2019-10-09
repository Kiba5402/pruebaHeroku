<?php

//require_once("../../model/Usuario/modelAgendamiento.php");

class controller_RecogidasAct{

	private $modelo;

	//mfuncion invocada por el view que ý que asigna la ruta del
	//html a devolver, pero tambien complementa la informacion 
	public function pagPedidosAct($idRecolector){
		//$this->modelo = new modelAgendamiento();
		return array(
			'infoPedidosActivos' => null,
			'html' => '/Recolector/pedidosActivos.html'
		);
	}

	//funcion que complementa la informacion de los pedidos
	//activos basados en el recolestor
	function compInfoPedidosAct($idRecolector){ 
		//$infoMat = $this->modelo->compinfoMat($idMat);
		//return $infoMat;
	}



}

?>