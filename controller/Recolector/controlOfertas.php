<?php

require_once("../../model/Recolector/modelRecolector.php");

class controller_ofertas{

	private $modelo;

	//mfuncion invocada por el view que ý que asigna la ruta del
	//html a devolver, pero tambien complementa la informacion 
	public function detalleOferta($idOferta){
		$this->modelo = new modelRecolector();
		return array(
			'infoOferta' => $this->compInfoOfertas($idOferta),
			'html' => '/Recolector/detalleOferta.html'
		);
	}

	//funcion que complementa la informacion de las ofertas
	private function compInfoOfertas($idOferta){ 
		$infoDetalleOferta = $this->modelo->detalleOferta($idOferta);
		return $infoDetalleOferta;
	}

	//funcion que trae un litado de ofertas para elrecolector
	public function listaOfertas($idPersona){
		if ($idPersona != null) {
			//seteamos el modelo
			$this->model = new modelRecolector();
			//traemos la localidad del recolector
			$localidad = $this->model->traeLocalidad($idPersona);
			//traemos las ofertas del recolector
			$ofertas = $this->model->ofertasRecolector($localidad[0]['localidad']);
			return array(
				'infoOfertas' => $ofertas
			);
		}else{
			return -1;
		}
	}

	//funcion que permite aceptar una oferta
	public function aceptaOferta($idPersona, $idOferta){
		//seteamos el modelo
		$this->model = new modelRecolector();
		//seteamos los nuevos valoresa la oferta
		$resultadoUpd = $this->model->aceptarOferta($idOferta,$idPersona);
		return array(
			'resultadoUpd' => $resultadoUpd
		);
	}



}

?>