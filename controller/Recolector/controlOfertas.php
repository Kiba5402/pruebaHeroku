<?php

//require_once("../../model/Usuario/modelAgendamiento.php");

class controller_ofertas{

	private $modelo;

	//mfuncion invocada por el view que ý que asigna la ruta del
	//html a devolver, pero tambien complementa la informacion 
	public function detalleOferta($idOferta){
		//$this->modelo = new modelAgendamiento();
		return array(
			'infoOferta' => null,
			'html' => '/Recolector/detalleOferta.html'
		);
	}

	//funcion que complementa la informacion de las ofertas
	function compInfoPedidosAct($idOferta){ 
		//$infoMat = $this->modelo->compinfoMat($idMat);
		//return $infoMat;
	}



}

?>