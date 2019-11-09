<?php

require_once("../../model/Recolector/modelRecolector.php");

class controller_ofertas{

	private $modelo;

	//mfuncion invocada por el view que ý que asigna la ruta del
	//html a devolver, pero tambien complementa la informacion 
	public function detalleOferta($idOferta){
		//$this->modelo = new modelAgendamiento();
		return array(
			'infoOferta' => $this->compInfoOfertas($idOferta),
			'html' => '/Recolector/detalleOferta.html'
		);
	}

	//funcion que complementa la informacion de las ofertas
	public function compInfoOfertas($idOferta){ 
		//$infoMat = $this->modelo->compinfoMat($idMat);
		//return $infoMat;
	}

	//funcion que trae un litado de ofertas para elrecolector
	public function listaOfertas($idPersona){
		//seteamos el modelo
		$this->model = new modelRecolector();
		//traemos la localidad del recolector
		$localidad = $this->model->traeLocalidad($idPersona);
		//traemos las ofertas del recolector
		$ofertas = $this->model->ofertasRecolector($localidad[0]['localidad']);
		return array(
			'infoOfertas' => $ofertas
		);
	}



}

?>