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

		//funcion que muestra el detalle d eun pedido activo
		public function mostrarDetPedidoAct($idPedido){
			$this->controlador = new controller_RecogidasAct();
			$arregloControler = $this->controlador->detallePedidosAct($idPedido);	
			//formateamos el array de respuesta del controlador
			return array(
				'infoPedidoEnProgreso' => $arregloControler['infoPedidoEnProgreso'],
				'html' => $this->get_include_contents($arregloControler['html'])
			);			
		}

		//funcion que cambia el estado de un pedido a recogido
		public function recogerPed($idPedido){
			$this->controlador = new controller_RecogidasAct();
			$arregloControler = $this->controlador->recogePed($idPedido);	
			//formateamos el array de respuesta del controlador
			return array(
				'infoRestPed' => $arregloControler['infoRestPed']
			);			
		}

		//funcion que cambia el estado de un pedido a entregado
		public function entregaPed($idPedido){
			$this->controlador = new controller_RecogidasAct();
			$arregloControler = $this->controlador->entregaPed($idPedido);	
			//formateamos el array de respuesta del controlador
			return array(
				'infoEntregaPed' => $arregloControler['infoEntregaPed']
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
	    case 'detPedidoAct':
	    	//traemos la informacion
	    	$idPedido = filter_input(INPUT_POST, 'idPedido', FILTER_SANITIZE_STRING);
 			$view = new view_recogidasActivas();
  			echo json_encode($view->mostrarDetPedidoAct($idPedido));
	        break;
	    case 'recoPedido':
	    	//traemos la informacion
	    	$idPedido = filter_input(INPUT_POST, 'idPedido', FILTER_SANITIZE_STRING);
 			$view = new view_recogidasActivas();
  			echo json_encode($view->recogerPed($idPedido));
	        break;
	     case 'entregaPedido':
	    	//traemos la informacion
	    	$idPedido = filter_input(INPUT_POST, 'idPedido', FILTER_SANITIZE_STRING);
 			$view = new view_recogidasActivas();
  			echo json_encode($view->entregaPed($idPedido));
	        break;
	    default:
	        include '../site_media/html/home.html';
	        break;
	}  

 ?>