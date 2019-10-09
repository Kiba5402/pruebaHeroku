<?php 
	require_once("../../controller/Recolector/controlHistorial.php");
	require_once("../superView.php");

	class view_historial extends view_super{

		private $controlador;

			//funcion para loguearse
		public function mostrarhistorial($idRecolector){
			$this->controlador = new controller_historial();
			$arregloControler = $this->controlador->pagHistorial($idRecolector);	
			//formateamos el array de respuesta del controlador
			return array(
				'infoHistorial' => $arregloControler['infoHistorial'],
				'html' => $this->get_include_contents($arregloControler['html'])
			);			
		}
	}

	/*
 	*Recibimos la solucitudes de esta vista desde ajax y devuelve el html 
 	o la informacion solicitada
 	*/
	switch (filter_input(INPUT_POST, 'funcion', FILTER_SANITIZE_STRING)) {
	    case 'historial':
	    	//traemos la informacion
	    	$idRecolector = filter_input(INPUT_POST, 'idRecolector', FILTER_SANITIZE_STRING);
 			$view = new view_historial();
  			echo json_encode($view->mostrarhistorial($idRecolector));
	        break;
	    default:
	        include '../site_media/html/home.html';
	        break;
	}  

 ?>