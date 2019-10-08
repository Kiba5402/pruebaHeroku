<?php

class controller_agendamiento{

	//mfuncion invocada por el view que ý que asigna la ruta del
	//html a devolver, pero tambien complementa la informacion 
	public function pagAgendamiento($tipoMat){
		return array(
			'tipoMat' => $tipoMat,
			'html' => '../../site_media/html/Usuario/FormularioAgendamiento.html'
		);
	}


}

?>