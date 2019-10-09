<?php

//require_once("../../model/Usuario/modelAgendamiento.php");

class controller_historial{

	private $modelo;

	//mfuncion invocada por el view que ý que asigna la ruta del
	//html a devolver, pero tambien complementa la informacion 
	public function pagHistorial($idRecolector){
		//$this->modelo = new modelAgendamiento();
		return array(
			'infoHistorial' => null,
			'html' => '/Recolector/historialPedidos.html'
		);
	}

	//funcion que complementa la informacion del historial
	//de pedidos basado en el id del reclector
	function compInfoHistorial($idRecolector){ 
		//$infoMat = $this->modelo->compinfoMat($idMat);
		//return $infoMat;
	}



}

?>