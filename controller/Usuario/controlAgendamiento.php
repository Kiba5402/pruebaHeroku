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
	function compInfoMat($idMat){ 
		$infoMat = $this->modelo->compinfoMat($idMat);
		return $infoMat;
	}



}

?>