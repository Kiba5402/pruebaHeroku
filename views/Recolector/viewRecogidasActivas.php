<?php 
	require_once("../../controller/Recolector/controlRecogidasActivas.php");
	require_once("../superView.php");

	class view_recogidasActivas extends view_super{

		private $controlador;

		//funcion que muestra la pagina de pedidos activos
		public function mostrarpedidosActivos($idRecolector){
			$this->controlador = new controller_RecogidasAct();
			$arregloControler = $this->controlador->pagPedidosAct($idRecolector);	
			//formateamos el array de respuesta del controlador
			return array(
				'infoPedidosActivos' => $arregloControler['infoPedidosActivos'],
				'html' => $this->get_include_contents($arregloControler['html'])
			);			
		}
	}

	/*
 	*Recibimos la solucitudes de esta vista desde ajax y devuelve el html 
 	o la informacion solicitada
 	*/
	switch (filter_input(INPUT_POST, 'funcion', FILTER_SANITIZE_STRING)) {
	    case 'pedidosAct':
	    	//traemos la informacion
	    	$idRecolector = filter_input(INPUT_POST, 'idRecolector', FILTER_SANITIZE_STRING);
 			$view = new view_recogidasActivas();
  			echo json_encode($view->mostrarpedidosActivos($idRecolector));
	        break;
	    default:
	        include '../site_media/html/home.html';
	        break;
	}  

 ?>