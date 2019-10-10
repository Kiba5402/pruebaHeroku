<?php 
	require_once("../../controller/Recolector/controlHistorial.php");
	require_once("../superView.php");

	class view_historial extends view_super{

		private $controlador;

		//funcion quemuestra el la tabla de histrial de pedidos
		public function mostrarhistorial($idRecolector){
			$this->controlador = new controller_historial();
			$arregloControler = $this->controlador->pagHistorial($idRecolector);	
			//formateamos el array de respuesta del controlador
			return array(
				'infoHistorial' => $arregloControler['infoHistorial'],
				'html' => $this->get_include_contents($arregloControler['html'])
			);			
		}

		//funcion que trae el detalle dede un pedido historico
		public function detalleHistorico($idPedido){
			$this->controlador = new controller_historial();
			$arregloControler = $this->controlador->detalleHistorial($idPedido);	
			//formateamos el array de respuesta del controlador
			return array(
				'infoDetalleHistorial' => $arregloControler['infoDetalleHistorial'],
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
	    case 'detalleHist':
	    	//traemos la informacion
	    	$idPedido = filter_input(INPUT_POST, 'idPedido', FILTER_SANITIZE_STRING);
 			$view = new view_historial();
  			echo json_encode($view->detalleHistorico($idPedido));
	        break;
	    default:
	        include '../site_media/html/home.html';
	        break;
	}  

 ?>