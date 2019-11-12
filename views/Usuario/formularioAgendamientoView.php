<?php 
	require_once("../../controller/Usuario/controlAgendamiento.php");
	require_once("../superView.php");

	class view_agendamiento extends view_super{

		private $controlador;

		//funcion para loguearse
		public function mostrarFormAgendar($tipoMat){
			$this->controlador = new controller_agendamiento();
			$arregloControler = $this->controlador->pagAgendamiento($tipoMat);	
			//formateamos el array de respuesta del controlador
			return array(
				'TipoMat' => $arregloControler,
				'html' => $this->get_include_contents($arregloControler['html'])
			);			
		}

		//funcion que invoca el controlador para la creacion del agendamiento
		public function agendarRecogida($idVendedor,$horarioRec,$idMaterial,$unidades,$valorAprox){
			//inicializamos el controlador
			$this->controlador = new controller_agendamiento();
			//enviamos la informacion a ser guardada
			$respuestaGuardado = $this->controlador->guardaAgendamiento($idVendedor,$horarioRec,$idMaterial,$unidades,$valorAprox);
			//retornamos el resultado
			return $respuestaGuardado;
		}

		//funcion que invoca el controlador del vendedor
		//para complementar la informacion que sera mostrada en la
		//primera pantalla
		public function infoPedidosVend($idVendedor){
			$this->controlador = new controller_agendamiento();
			return $this->controlador->pedidosUser($idVendedor);
		}

		//funcion que trae los detalles de un pedido
		public function detallePedido($idPedido){
			$this->controlador = new controller_agendamiento();
			$respDetallePedido =  $this->controlador->detallePedido($idPedido);
			//formateamos el array de respuesta del controlador
			return array(
				'datos' => $respDetallePedido['infoPed'],
				'html' => $this->get_include_contents($respDetallePedido['html'])
			);	
		}

		//funcion que nos permite calificar el pedido
		public function calificarPedido($idPedido,$calificacion){
			$this->controlador = new controller_agendamiento();
			$respDetallePedido =  $this->controlador->calificarPedido($idPedido, $calificacion);
			//formateamos el array de respuesta del controlador
			return array(
				'infoCalif' => $respDetallePedido['infoCalif'],
			);	
		}

	}

	/*
 	*Recibimos la solucitudes de esta vista desde ajax y devuelve el html 
 	o la informacion solicitada
 	*/
	switch (filter_input(INPUT_POST, 'funcion', FILTER_SANITIZE_STRING)) {
	    case 'agendar':
	    	//traemos la informacion
	    	$tipoMat = filter_input(INPUT_POST, 'tipoMat', FILTER_SANITIZE_STRING);
 			$view = new view_agendamiento();
  			echo json_encode($view->mostrarFormAgendar($tipoMat));
	        break;
	    case 'agendarRecogida':
	    	//traemos la informacion
	    	$idVendedor = filter_input(INPUT_POST, 'idVendedor', FILTER_SANITIZE_STRING);
	    	$idVendedor = (($idVendedor == '')? '-1' : $idVendedor);
	        $horarioRec = filter_input(INPUT_POST, 'horarioRec', FILTER_SANITIZE_STRING);
	        $idMaterial = filter_input(INPUT_POST, 'idMaterial', FILTER_SANITIZE_STRING);
	        $idMaterial = (($idMaterial == '')? '-1' : $idMaterial); 
	        $unidades = filter_input(INPUT_POST, 'unidades', FILTER_SANITIZE_STRING);
	        $valorAprox = filter_input(INPUT_POST, 'valorAprox', FILTER_SANITIZE_STRING);   
 			$view = new view_agendamiento();
  			echo json_encode($view->agendarRecogida($idVendedor,$horarioRec,$idMaterial,$unidades,$valorAprox));
	        break;
	    case 'pedidosUsr':
	    	//invocamos la funcion que nos trae la informacion de los pedidos dle usuario 
	    	$idPersona = filter_input(INPUT_POST, 'idPersona', FILTER_SANITIZE_STRING);
	    	$view = new view_agendamiento();
  			echo json_encode($view->infoPedidosVend($idPersona));
	        break;
	    case 'detallePedido':
	    	//invocamos la funcion que nos trae la informacion de los pedidos dle usuario 
	    	$idPedido = filter_input(INPUT_POST, 'idPedido', FILTER_SANITIZE_STRING);
	    	$view = new view_agendamiento();
  			echo json_encode($view->detallePedido($idPedido));
	        break;
	     case 'calificar':
	    	//invocamos la funcion que nos trae la informacion de los pedidos dle usuario 
	    	$idPedido = filter_input(INPUT_POST, 'idPedido', FILTER_SANITIZE_STRING);
	    	$calificacion = filter_input(INPUT_POST, 'calificacion', FILTER_SANITIZE_STRING);
	    	$view = new view_agendamiento();
  			echo json_encode($view->calificarPedido($idPedido,$calificacion));
	        break;
	    default:
	        include '../site_media/html/home.html';
	        break;
	}  

 ?>